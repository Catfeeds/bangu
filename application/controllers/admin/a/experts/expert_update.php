<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015-11-27
 * @author		jiakairong
 * @method 		管家资料修改
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Expert_update extends UA_Controller 
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/bridge_expert_model', 'bridge_expert_model' );
	}
	public function index() 
	{
		$this->view ( 'admin/a/expert/expert_update');
	}
	/**
	 * @method 获取管家数据
	 * @since  2015-11-30
	 */
	public function getBridgeExpertData()
	{
		$whereArr = array();
		$realname = trim($this ->input ->post('name' ,true));
		$mobile = trim($this ->input ->post('mobile' ,true));
		$email = trim($this ->input ->post('email' ,true));
		$status = intval($this ->input ->post('status'));
		//审核状态
		$whereArr['bem.status ='] = $status;

		if (!empty($realname)) 
		{
			$whereArr ['be.realname like'] = '%'.$realname.'%';
		}
		if (!empty($mobile))
		{
			$whereArr ['be.mobile ='] = $mobile;
		}
		if (!empty($email))
		{
			$whereArr ['be.email ='] = $email;
		}
		$data = $this ->bridge_expert_model ->getExpertMapData ($whereArr);
		echo json_encode($data);
	}
	/**
	 * @method 返回管家详细
	 * @since  2015-11-30
	 */
	public function getExpertDetail()
	{
		$this ->load_model('expert_model');
		$mapid = intval($this ->input ->post('mapid')); //桥接表ID
		//修改后的管家资料
		$bridgeExpert = $this ->bridge_expert_model ->getBridgeExpert($mapid);
		//修改前管家信息
		$expertData = $this ->expert_model ->getExpertDetail($bridgeExpert[0]['expert_id']);
		if (!empty($bridgeExpert) && !empty($expertData))
		{
			$bridgeExpert = $bridgeExpert[0];
			$bridgeExpert['destName'] = $this ->getDestName($bridgeExpert['expert_dest']);
			$bridgeExpert['servinceName'] = $this ->getServiceName($bridgeExpert['visit_service']);
			$bridgeExpert['address'] = $bridgeExpert['country_name'].$bridgeExpert['province_name'].$bridgeExpert['city_name'].$bridgeExpert['region_name'];
			//从业经历
			if (empty($bridgeExpert['b_expert_resume_ids']))
			{
				$bridgeExpert['resume'] = array();
			}
			else
			{
				$bridgeExpert['resume'] = $this ->bridge_expert_model ->getExpertResume($bridgeExpert['b_expert_resume_ids']);
			}
			//证书
			if (empty($bridgeExpert['b_expert_certificate_ids']))
			{
				$bridgeExpert['certificate'] = array();
			}
			else
			{
				$bridgeExpert['certificate'] = $this ->bridge_expert_model ->getExpertCertificate($bridgeExpert['b_expert_certificate_ids']);
			}
			
			$expertData = $expertData[0];
			$expertData['destName'] = $this ->getDestName($expertData['expert_dest']);
			$expertData['servinceName'] = $this ->getServiceName($expertData['visit_service']);
			$expertData['resume'] = $this ->expert_model ->getExpertResume($expertData['id']);
			$expertData['certificate'] = $this ->expert_model ->getExpertCertificate($expertData['id']);
			$expertData['address'] = $expertData['country_name'].$expertData['province_name'].$expertData['city_name'].$expertData['region_name'];
			$data = array(
					'expert' =>$expertData,
					'bridge' =>$bridgeExpert
			);
			echo json_encode($data);
		}
	}
	/**
	 * @method 获取上门服务地区
	 * @param unknown $servince
	 */
	public function getServiceName($servince)
	{
		if (!empty($servince))
		{
			$this ->load_model('area_model');
			$areaData = $this ->area_model ->getAreaIN($servince);
			$name = '';
			foreach($areaData as $val)
			{
				$name .= $val['name'].',';
			}
			return  rtrim($name ,',');
		}
		else
		{
			return '';
		}
	}
	/**
	 * @method 获取擅长目的地
	 * @param unknown $destIds
	 */
	public function getDestName($destIds)
	{
		if (!empty($destIds))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$whereArr = array(
					'in' =>array('d.id' =>$destIds)
			);
			$destData = $this ->dest_base_model ->getDestBaseData($whereArr);
			$name = '';
			foreach($destData as $val)
			{
				$name .= $val['kindname'].',';
			}
			return  rtrim($name ,',');
		}
		else
		{
			return '';
		}
	}
	/**
	 * @method 拒绝管家资料修改
	 * @author jiakairong
	 */
	public function refuse()
	{
		$mapid = intval($this ->input ->post('mapid'));
		$reason = trim($this ->input ->post('reason' ,true));
		if (empty($reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写拒绝原因');
		}
		$status = $this ->bridge_expert_model ->refuseExpertUpdate($mapid ,$reason);
		if ($status == true)
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(5,3,'管家资料审核','平台拒绝管家资料修改申请，申请ID：'.$mapid);
			$expertData = $this ->bridge_expert_model ->getBridgeExpert($mapid);
			if (!empty($expertData))
			{
				$this ->load_model('admin/a/sms_template_model' ,'sms_model');
				$sms = $this ->sms_model ->row(array('msgtype' =>'expert_update_refuse' ,'isopen' =>1));
				$content = str_replace('{#NAME#}', $expertData[0]['realname'] ,$sms['msg']);
				$content = str_replace('{#REASON#}', $reason ,$content);
				$this ->send_message($expertData[0]['mobile'] ,$content);
			}
		}
		else 
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败，请重试');
		}
	}
	/**
	 * @method 通过管家资料修改
	 * @author jiakairong
	 */
	public function through()
	{
		$mapid = intval($this ->input ->post('mapid'));	
		//管家桥接表信息
		$bridgeExpert = $this ->bridge_expert_model ->getBridgeExpert($mapid);
		if (empty($bridgeExpert))
		{
			$this->callback->setJsonCode ( 4000 ,'记录不存在');
		}
		else 
		{
			$bridgeExpert = $bridgeExpert[0];
			$expert_id = $bridgeExpert['expert_id'];
			$resume_ids = $bridgeExpert['b_expert_resume_ids'];
			$certificate_ids = $bridgeExpert['b_expert_certificate_ids'];
		}
		
		//管家表信息
		$this ->load_model('admin/a/expert_model' ,'expert_model');
		$expertData = $this ->expert_model ->row(array('id' =>$expert_id));
		
		//获取更新的字段
		$fieldArr = array(
				'nickname',
				'weixin',
				'idcard',
				'idcardpic',
				'idcardconpic',
				'small_photo',
				'big_photo',
				'talk',
				'school',
				'profession',
				'working',
				'expert_dest',
				'country',
				'province',
				'city',
				'visit_service',
				'sex',
				'mobile'
			);

		$dataArr = array();
		
		foreach($fieldArr as $v)
		{
			if ($bridgeExpert[$v] != $expertData[$v])
			{
				$dataArr[$v] = $bridgeExpert[$v];
			}
		}
		$dataArr['modtime'] = date('Y-m-d H:i:s' ,time());
		
		//由平台发起管家资料修改，这时需要将管家状态修改为2
		if ($expertData['status'] == 5)
		{
			$dataArr['status'] = 2;
		}
		
		//管家证书
		$certificateArr = array();
		if (!empty($certificate_ids))
		{
			$certificateArr = $this ->bridge_expert_model ->getExpertCertificate($certificate_ids);
		}
		//管家从业简历
		$resumeArr = array();
		if (!empty($resume_ids))
		{
			$resumeArr = $this ->bridge_expert_model ->getExpertResume($resume_ids);
		}
		$status = $this ->bridge_expert_model ->updateExpert($expert_id ,$dataArr ,$certificateArr ,$resumeArr ,$mapid);
		if ($status === false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else 
		{
			//更新主播表
			$this ->load_model('live/anchor_model' ,'anchor_model');
			$anchorData = $this ->anchor_model ->getAnchorId($expert_id ,1);
			if(!empty($anchorData))
			{
				$anchorArr = array(
							'sex' =>$bridgeExpert['sex'],
							'realname' =>$bridgeExpert['realname'],
							'nickname' =>$bridgeExpert['nickname'],
							'idcardconpic' =>$bridgeExpert['idcardconpic'],
							'idcardnum' =>$bridgeExpert['idcard'],
							'modtime' =>date('Y-m-d H:i:s' ,time())
				);
				$this ->anchor_model ->updateAnchor($anchorArr ,$anchorData['anchor_id']);
			}
			
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			
			$this ->log(5,3,'管家资料审核','平台通过管家资料修改申请，申请ID：'.$mapid);
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$sms = $this ->sms_model ->row(array('msgtype' =>'expert_update_through' ,'isopen' =>1));
			$content = str_replace('{#NAME#}', $bridgeExpert['realname'] ,$sms['msg']);
			$this ->send_message($bridgeExpert['mobile'] ,$content);
		}
		
	}
}