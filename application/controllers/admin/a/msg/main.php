<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 消息内容管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Main extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('msg/msg_main_model' ,'main_model');
		$this ->load_model('msg/get_data_model' ,'data_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/msg/main');
	}
	
	public function getMsgMainData()
	{
		$status = intval($this ->input ->post('status'));
		$title = trim($this ->input ->post('title' ,true));
		
		$whereArr = array();
		switch($status)
		{
			case 0:
			case 1:
				$whereArr['main.isopen ='] = $status;
				break;
			default:
				echo json_encode($this ->defaultArr);exit;
				break;
		}
		if(!empty($title))
		{
			$whereArr['main.title like'] = '%'.$title.'%';
		}
		
		$data = $this ->main_model ->getMsgMainData($whereArr);
		echo json_encode($data);
	}
	//添加或编辑消息标题
	public function upload()
	{
		$title = trim($this ->input ->post('title' ,true));
		$isopen = intval($this ->input ->post('isopen'));
		$code = trim($this ->input ->post('code' ,true));
		$remark = trim($this ->input ->post('remark' ,true));
		$id = intval($this ->input->post('id'));
		$type = intval($this ->input ->post('type'));
		
		if (empty($title))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写消息标题');
		}
		if (empty($type))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择业务类型');
		}
		
		if (empty($code))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写消息编号');
		}
		else 
		{
			/**根据消息编号获取发送的消息，消息编号不可更改*/
			if (empty($id))
			{
				//查询消息编号是否唯一
				$msgArr = $this ->main_model ->row(array('code' =>$code));
				if (!empty($msgArr))
				{
					$this ->callback ->setJsonCode(4000 ,'编号已存在');
				}
			}
		}
		
		$time = date('Y-m-d H:i:s' ,time());
		$dataArr = array(
				'title' =>$title,
				'isopen' =>$isopen,
				'code' =>$code,
				'remark' =>$remark,
				'admin_id' =>$this ->admin_id,
				'modtime' =>$time,
				'type' =>$type
		);
		if ($id > 0)
		{
			$status = $this ->main_model ->update($dataArr ,array('id' =>$id));
		}
		else
		{
			$dataArr['addtime'] = $time;
			$status = $this ->main_model ->insert($dataArr);
		}
		
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//停用
	public function disable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'isopen' =>0,
				'modtime' =>date('Y-m-d H:i:s'),
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->main_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else 
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//启用
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$dataArr = array(
				'isopen' =>1,
				'modtime' =>date('Y-m-d H:i:s'),
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->main_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	//进入编辑或添加消息标题页面
	public function uploadMain()
	{
		$id = intval($this ->input ->get('id'));
		$dataArr = array();
		if ($id > 0)
		{
			$dataArr = $this ->main_model ->row(array('id' =>$id));
		}
		$this->view ( 'admin/a/msg/upload_main' ,$dataArr);
	}
	
	//获取消息内容
	public function getMsgContentData()
	{
		$this ->load_model('msg/msg_content_model' ,'content_model');
		
		$content = trim($this ->input ->post('content' ,true));
		
		$whereArr = array(
				'content.isopen =' =>1
		);
		if(!empty($content))
		{
			$whereArr['content.content like'] = '%'.$content.'%';
		}
		
		$data = $this ->content_model ->getContentPoint($whereArr);
		echo json_encode($data);
	}
	
	//查看节点
	public function see_point()
	{
		$id = intval($this ->input ->get('id'));
		//获取配置的节点信息
		$stepPoint = $this ->main_model ->getMainStepPoint($id);
		$stepArr = array();
		if (!empty($stepPoint))
		{
			//按步骤分类
			foreach($stepPoint as $k=>$v)
			{
				if (!array_key_exists($v['step'], $stepArr))
				{
					$stepArr[$v['step']] = array(
							'description' =>$v['description'],
							'step' =>$v['step'],
							'through' =>array(),
							'ordinary' =>array(),
							'refuse' =>array()
					);
				}
				$pointArr[] = $v;
			}
				
			foreach($pointArr as $key =>$val)
			{
				if ($val['belong'] == 1)
				{
					$stepArr[$val['step']]['through'][] = $val;
				}
				elseif ($val['belong'] == 2)
				{
					$stepArr[$val['step']]['refuse'][] = $val;
				}
				else
				{
					$stepArr[$val['step']]['ordinary'][] = $val;
				}
			}
		}
		
		$titleArr = array(
				1=>'第一步',
				2=>'第二步',
				3=>'第三步',
				4=>'第四步',
				5=>'第五步',
				6=>'第六步',
				7=>'第七步',
				8=>'第八步',
				9=>'第九步',
				10=>'第十步',
		);
		//接收人类型
		$typeArr = array(1=>'营业部经理' ,2=>'营业部销售' ,3=>'供应商');
		//获取旅行社角色
		$roleArr = $this ->data_model ->getUnionRole();
		foreach($roleArr as $v)
		{
			$typeArr[$v['id']] = '联盟'.$v['role'];
		}
		
		$dataArr = array(
				'stepArr' =>$stepArr,
				'titleArr' =>$titleArr,
				'typeArr' =>$typeArr
		);
		$this ->view('/admin/a/msg/see_point' ,$dataArr);
	}
	
	//配置消息节点页面
	public function add_point()
	{
		$id = intval($this ->input ->get('id'));
		//获取配置的节点信息
		$stepPoint = $this ->main_model ->getMainStepPoint($id);
		$stepArr = array();
		if (!empty($stepPoint))
		{
			//按步骤分类
			foreach($stepPoint as $k=>$v)
			{
				if (!array_key_exists($v['step'], $stepArr))
				{
					$stepArr[$v['step']] = array(
							'description' =>$v['description'],
							'step' =>$v['step'],
							'is_ts' =>0,
							'through' =>array(),
							'ordinary' =>array(),
							'refuse' =>array()
					);
				}
				if ($v['type'] == 2)
				{
					$stepArr[$v['step']]['is_ts'] = 1;
				}
				$pointArr[] = $v;
			}
			
			foreach($pointArr as $key =>$val)
			{
				if ($val['belong'] == 1)
				{
					$stepArr[$val['step']]['through'][] = $val;
				}
				elseif ($val['belong'] == 2)
				{
					$stepArr[$val['step']]['refuse'][] = $val;
				}
				else 
				{
					$stepArr[$val['step']]['ordinary'][] = $val;
				}
			}
		}
		
		//接收人类型
		$typeArr = array(
				array('id'=>1 ,'name'=>'营业部经理'),
				array('id'=>2 ,'name'=>'营业部销售'),
				array('id'=>3 ,'name'=>'供应商')
		);
		
		//获取旅行社角色
		$roleArr = $this ->data_model ->getUnionRole();
		foreach($roleArr as $v)
		{
			$typeArr[] = array(
					'id' =>$v['id'],
					'name' =>'联盟'.$v['role']
			);
		}
		
		$titleArr = array(
				1=>'第一步',
				2=>'第二步',
				3=>'第三步',
				4=>'第四步',
				5=>'第五步',
				6=>'第六步',
				7=>'第七步',
				8=>'第八步',
				9=>'第九步',
				10=>'第十步',
		);
		
		$dataArr = array(
				'id' =>$id,
				'stepArr' =>$stepArr,
				'typeArr' =>$typeArr,
				'titleArr' =>$titleArr
		);
		$this ->view('/admin/a/msg/add_point' ,$dataArr);
	}
	
	
	//配置消息节点
	public function mainNode()
	{
		$stepArr = $this ->input ->post('step');
		$descriptionArr = $this ->input ->post('description' ,true);
		$main_id = intval($this ->input ->post('main_id'));
		//保存每一步有几条消息
		$keyArr = $this ->input ->post('key' ,true);
		$typeArr = $this ->input ->post('type' ,true);
		$contentArr = $this ->input ->post('content_id' ,true);
		$belongArr = $this ->input ->post('belong' ,true);
		
		//获取消息编号
		$mainData = $this ->main_model ->row(array('id' =>$main_id));
		if (empty($mainData))
		{
			$this ->callback ->setJsonCode(4000 ,'选择消息标题有误');
		}
		
		//保存步骤
		$mainStepArr = array();
		$i = 0;
		foreach($stepArr as $k=>$v)
		{
			//保存节点内容信息
			$pointArr = array();
			if (empty($descriptionArr[$k]))
			{
				$this ->callback ->setJsonCode(4000 ,'请将步骤说明填写完整');
			}
			
			//获取此步骤有几条消息
			$key = $keyArr[$k];
			$j = $i+$key;
			for($i ;$i<$j ;$i++)
			{
				if (empty($contentArr[$i]))
				{
					$this ->callback ->setJsonCode(4000 ,'请将消息内容选择完整');
				}
				if (empty($typeArr[$i]))
				{
					$this ->callback ->setJsonCode(4000 ,'请将接收人选择完整');
				}
				$pointArr[] = array(
						'main_id' =>$main_id,
						'code' =>$mainData['code'],
						'content_id' =>$contentArr[$i],
						'user_type' =>$typeArr[$i],
						'belong' =>$belongArr[$i]
				);
			}
			
			$mainStepArr[] = array(
					'main_id' =>$main_id,
					'step' =>$v,
					'description' =>$descriptionArr[$k],
					'point' =>$pointArr
			);
		}
		//var_dump($mainStepArr);exit;
		$status = $this ->main_model ->addMsgPoint($mainStepArr);
		if ($status === false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
}