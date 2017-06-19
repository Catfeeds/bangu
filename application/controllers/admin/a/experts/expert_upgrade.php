<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 	2016-03-16
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Expert_upgrade extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'expert_upgrade_model' ,'upgradeModel');
	}
	public function index()
	{
		$this ->load_model('expert_grade_model');
		$gradeData = $this ->expert_grade_model ->all();
		$data['gradeArr'] = array();
		foreach($gradeData as $v)
		{
			$data['gradeArr'][$v['grade']] = $v['title'];
		}
		$this->view ( 'admin/a/expert/expert_upgrade' ,$data);
	}
	public function getUpgradeData()
	{
		$whereArr = array();
		$findInSet = '';
		$status = intval($this ->input ->post('status'));
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$startcity = trim($this ->input ->post('startcity' ,true));
		$startcity_id = intval($this ->input ->post('startcity_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$expertId = intval($this ->input ->post('expert_id'));
		$realname = trim($this ->input ->post('realname' ,true));
		$whereArr['eu.status ='] = $status;
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
			$whereArr['eu.expert_id ='] = $expertId;
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
		$data = $this->upgradeModel->getUpgradeData ( $whereArr ,$findInSet);
		$this ->load_model('startplace_model');
		foreach($data['data'] as $k=>$v)
		{
			$cityname = '';
			$startData = $this ->startplace_model ->getLineStartCity($v['line_id']);
			foreach($startData as $val)
			{
				$cityname .= $val['name'].',';
			}
			$data['data'][$k]['cityname'] = rtrim($cityname ,',');
		}
		echo json_encode($data);
	}
	//获取数据信息详细
	public function getUpgradeDetail()
	{
		$id = intval($this ->input ->post('upgradeId'));
		$upgradeData = $this ->upgradeModel ->getUpgradeDetail($id);
		if (!empty($upgradeData))
		{
			$this ->load_model('startplace_model');
			$cityname = '';
			$startData = $this ->startplace_model ->getLineStartCity($upgradeData[0]['line_id']);
			foreach($startData as $val)
			{
				$cityname .= $val['name'].',';
			}
			$upgradeData[0]['cityname'] = rtrim($cityname ,',');
			echo json_encode($upgradeData[0]);
		}
	}
	//拒绝管家升级
	public function refuse() 
	{
		$upgradeId = intval($this->input->post('upgradeId'));
		$remark = trim($this->input->post('remark' ,true));
		if (empty($remark))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写拒绝原因');
		}
		$upgradeArr = array(
			'refuse_remark' =>$remark,
			'status' =>-2,
			'deal_type' =>3,
			'user_id' =>$this ->admin_id
		);
		$status = $this ->upgradeModel ->update($upgradeArr ,array('id' =>$upgradeId));
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			$this ->log(5,3,'售卖权管理','平台拒绝专家升级,记录ID:'.$upgradeId);
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
	}
	//通过管家升级
	public function through()
	{
		$upgradeId = intval($this ->input ->post('upgradeId'));
		$upgradeData = $this ->upgradeModel ->row(array('id' =>$upgradeId));
		if (empty($upgradeData) || ($upgradeData['status'] != 1 && $upgradeData['status'] !=0)) 
		{
			$this ->callback->setJsonCode(4000 ,'记录不存在或不在审核状态');
		}
		$this->db->trans_start();
		//更改专家线路申请表
		$applyArr = array(
			'grade' => $upgradeData['grade_after'],
			'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$whereArr = array(
			'expert_id' =>$upgradeData['expert_id'],
			'line_id' =>$upgradeData['line_id'],
			'status' =>2
		);
		$this ->db ->where($whereArr);
		$this ->db ->update('u_line_apply' ,$applyArr);
			
		//更新申请升级表
		$upgradeArr = array(
			'deal_type' =>3,
			'user_id' =>$this ->admin_id,
			'status' =>2
		);
		$this ->upgradeModel ->update($upgradeArr ,array('id' =>$upgradeId));
		//操作日志
		$this ->log(5,3,'售卖权管理','平台通过专家升级,记录ID:'.$upgradeId);
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
	}
}