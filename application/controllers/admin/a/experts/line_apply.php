<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 	2016-03-16
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line_apply extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'line_apply_model' ,'lineApplyModel');
	}
	public function index()
	{
		$this ->load_model('expert_grade_model');
		$data['grade'] = $this ->expert_grade_model ->all();
		$this->view ( 'admin/a/expert/line_apply' ,$data);
	}
	public function getLineApplyData()
	{
		$whereArr = array();
		$findInSet = '';
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$startcity = trim($this ->input ->post('startcity' ,true));
		$startcity_id = intval($this ->input ->post('startcity_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$expertId = intval($this ->input ->post('expert_id'));
		$realname = trim($this ->input ->post('realname' ,true));
		$whereArr['la.status ='] = 2;//目前的申请都是直接通过的
		if (!empty($linename))
		{
			$whereArr['l.linename like'] = '%'.$linename.'%';
		}
		//供应商
		if (!empty($supplier_id))
		{
			$whereArr['l.supplier_id ='] = $supplier_id;
		}
		elseif (!empty($company_name))
		{
			$whereArr['s.company_name like'] = '%'.$company_name.'%';
		}
		//管家
		if (!empty($expertId))
		{
			$whereArr['la.expert_id ='] = $expertId;
		}
		elseif (!empty($realname))
		{
			$whereArr['e.realname like'] = '%'.$realname.'%';
		}
		//出发城市
		if (!empty($startcity_id))
		{
			$whereArr['ls.startplace_id ='] = $startcity_id;
		}
		elseif (!empty($startcity))
		{
			$whereArr['sp.cityname like'] = '%'.$startcity.'%';
		}
		//目的地
		if (!empty($overcity))
		{
			$findInSet = ' find_in_set('.$overcity.' ,l.overcity)';
		}
		elseif (!empty($kindname))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->all(array('kindname like' =>'%'.$kindname.'%'));
			if (empty($destData))
			{
				echo json_encode($this ->defaultArr);exit;
			}
			else 
			{
				$findInSet = ' (';
				foreach($destData as $v)
				{
					$findInSet .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$findInSet = rtrim($findInSet ,'or').') ';
			}
		}
		
		$data = $this->lineApplyModel->getLineApplyData ( $whereArr ,$findInSet);
		echo json_encode($data);
	}
	//调整管家级别
	public function changeGrade()
	{
		$grade = intval($this ->input ->post('grade'));
		$applyId = intval($this ->input ->post('applyId'));
		if (empty($grade))
		{
			$this ->callback->setJsonCode(4000 ,'请选择管家级别');
		}
		$applyData = $this ->lineApplyModel ->getApplyDetail($applyId);
		if (empty($applyData) || $applyData[0]['status'] != 2) 
		{
			$this ->callback->setJsonCode(4000 ,'记录不存在或不在正常状态');
		}
		$applyData = $applyData[0];
		$this->db->trans_start();
		$dataArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'grade' =>$grade
		);
		$this ->lineApplyModel ->update($dataArr ,array('id' =>$applyId));
		//给升级表写入数据
		$upgradeArr = array(
				'expert_id' =>$applyData['expert_id'],
				'line_id' =>$applyData['line_id'],
				'grade_before' =>$applyData['grade'],
				'grade_after' =>$grade,
				'deal_type' =>3,
				'user_id' =>$this ->admin_id,
				'status' =>2,
				'addtime' =>$dataArr['modtime']
		);
		$this ->load_model('expert_upgrade_model');
		$this ->expert_upgrade_model ->insert($upgradeArr);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			$this ->log(3,3,'管家售卖权管理','平台调整管家级别,记录ID:'.$applyId);
			//给b2发送系统消息
			$this ->load_model('expert_grade_model');
			$gradeData = $this ->expert_grade_model ->row(array('grade' =>$grade));
			$content = '供应商：'.$applyData['company_name'].' <br/>线路名称：'.$applyData['linename'].' <br/>平台将您的售卖级别调整为：'.$gradeData['title'];
			$this ->add_message($content ,1,$applyData['expert_id'] ,'平台调整您的线路售卖级别');
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
	}
	//获取详情
	public function getApplyDetail()
	{
		$applyId = intval($this ->input ->post('applyId'));
		$applyData = $this ->lineApplyModel ->getApplyDetail($applyId);
		if (!empty($applyData))
		{
			echo json_encode($applyData[0]);
		}
	}
	//删除管家线路
	public function deleteLineApply()
	{
		$applyId = intval($this ->input ->post('applyId'));
		$applyData = $this ->lineApplyModel ->getApplyDetail($applyId);
		if (empty($applyData) || $applyData[0]['status'] != 2)
		{
			$this ->callback->setJsonCode(4000 ,'记录不存在或不在正常状态');
		}
		$applyData = $applyData[0];
		$applyArr = array(
			'status' =>-1,
			'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->lineApplyModel ->update($applyArr ,array('id' =>$applyId));
		if ($status == false)
		{
			$this->callback->set_code ( 4000 ,'操作失败');
		}
		else
		{
			$this ->log(2,3,'售卖权管理','删除管家售卖权,记录ID:'.$applyId);
			//给b2发送系统消息
			$content = "供应商：{$applyData['company_name']} <br/>线路名称：{$applyData['linename']} <br/>平台将您的售卖权关闭";
			$this ->add_message($content ,1,$applyData['expert_id'] ,'平台关闭您的线路售卖权');
			$this->callback->set_code ( 2000 ,'操作成功');
		}
		$this->callback->exit_json();
	}
}