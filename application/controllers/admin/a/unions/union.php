<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 旅行社管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Union extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('union_model' ,'union_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/union/union_list');
	}
	
	public function getUnionJson()
	{
		$whereArr = array('be.is_admin =' =>1);
		$name = trim($this ->input ->post('name'));
		$linkman = trim($this ->input ->post('linkman'));
		$mobile = trim($this ->input ->post('mobile'));
		$status = intval($this ->input ->post('status'));
		switch($status)
		{
			case 1:
			case -1:
				$whereArr['u.status ='] = $status;
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		
		if (!empty($name))
		{
			$whereArr['u.union_name like '] = '%'.$name.'%';
		}
		if (!empty($linkman))
		{
			$whereArr['u.linkman like '] = '%'.$linkman.'%';
		}
		if (!empty($mobile))
		{
			$whereArr['u.linkmobile ='] = $mobile;
		}
		$data = $this ->union_model ->getUnionData($whereArr);
		echo json_encode($data);
	}
	//添加旅行社
	public function add()
	{
		$union_name = trim($this ->input ->post('union_name'));
		$linkman = trim($this ->input ->post('linkman'));
		$linkmobile= trim($this ->input ->post('linkmobile'));
		$password = trim($this ->input ->post('password'));
		$loginname = trim($this ->input ->post('loginname'));
		$realname = trim($this ->input ->post('realname'));
		$bankcard = trim($this ->input ->post('bankcard'));
		$bankname = trim($this ->input ->post('bankname'));
		$branch = trim($this ->input ->post('branch'));
		$cardholder = trim($this ->input ->post('cardholder'));
		$country = intval($this ->input ->post('country'));
		$province = intval($this ->input ->post('province'));
		$city = intval($this ->input ->post('city'));
		if (empty($union_name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社名称');
		}
		if (empty($linkman))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社联系人');
		}
		if (empty($linkmobile))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社联系人手机号');
		}
		if (empty($loginname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写管理员账号');
		}
		else 
		{
			$loginArr = $this ->union_model ->getUnionEmployee($loginname);
			if (!empty($loginArr))
			{
				$this ->callback ->setJsonCode(4000 ,'账号已存在');
			}
		}
		if (empty($realname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写管理员姓名');
		}
		if (empty($password))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写管理员密码');
		}
		
		if (empty($city))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择所在城市');
		}
		
		if (empty($bankcard))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行卡号');
		}
		if (empty($bankname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行名称');
		}
		if (empty($branch))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写开户支行');
		}
		if (empty($cardholder))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写持卡人');
		}
		$time = date('Y-m-d H:i:s' ,time());
		$unionArr = array(
				'union_name' =>$union_name,
				'linkman' =>$linkman,
				'linkmobile' =>$linkmobile,
				'addtime' =>$time,
				'status' =>1,
				'admin_id' =>$this ->admin_id,
				'bankcard' =>$bankcard,
				'bankname' =>$bankname,
				'branch' =>$branch,
				'cardholder' =>$cardholder,
				'country' =>$country,
				'province' =>$province,
				'city' =>$city
		);
		$employeeArr = array(
				'loginname' =>$loginname,
				'pwd' =>md5($password),
				'realname' =>$realname,
				'is_admin' =>1,
				'status' =>1,
				'addtime' =>$time,
				'modtime' =>$time,
				'role_id' =>1
		);
		
		$status = $this ->union_model ->addUnion($unionArr ,$employeeArr);
		if ($status == true)
		{
			$this ->log(1, 3, '旅行社管理', '添加旅行社信息,旅行社名称:'.$union_name);
			$this ->callback ->setJsonCode(2000 ,'添加成功');
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'添加失败');
		}
	}
	
	//获取旅行社的营业部
	public function getUnionDepart()
	{
		$union_id = intval($this ->input ->post('union_id'));
		$name = trim($this ->input ->post('depart_name' ,true));
		$linkman = trim($this ->input ->post('linkman' ,true));
		$mobile = trim($this ->input ->post('mobile' ,true));
		if ($union_id < 0)
		{
			echo json_encode($this ->defaultArr);
			exit;
		}
		$whereArr = array(
				'status =' =>1,
				'union_id =' =>$union_id
		);
		if (!empty($name))
		{
			$whereArr[' name like '] = '%'.$name.'%';
		}
		if (!empty($linkman))
		{
			$whereArr[' linkman like '] = '%'.$linkman.'%';
		}
		if (!empty($mobile))
		{
			$whereArr['linkmobile ='] = $mobile;
		}
		
		$deparData = $this ->union_model ->getUnionDepartData($whereArr);
		echo json_encode($deparData);
	}
	//获取旅行社的供应商
	public function getUnionSupplier()
	{
		$id = intval($this ->input ->post('union_id'));
		$name = trim($this ->input ->post('name' ,true));
		$linkman = trim($this ->input ->post('linkman' ,true));
		$mobile = trim($this ->input ->post('mobile' ,true));
		if ($id < 0)
		{
			echo json_encode($this ->defaultArr);
			exit;
		}
		$whereArr = array(
				'cs.union_id =' =>$id
		);
		
		if (!empty($name))
		{
			$whereArr [' s.company_name like '] = '%'.$name.'%';
		}
		if (!empty($linkman))
		{
			$whereArr [' s.realname like '] = '%'.$linkman.'%';
		}
		if (!empty($mobile))
		{
			$whereArr [' s.mobile ='] = $mobile;
		}
		
		$deparData = $this ->union_model ->getUnionSupplierData($whereArr);
		echo json_encode($deparData);
	}
	//旅行社详细
	public function detail()
	{
		$id = intval($this ->input ->get('id'));
		$uninoData = $this ->union_model ->row(array('id' =>$id));
		$this ->view('admin/a/union/union_detail' ,array('unionData' =>$uninoData));
	}
	
	//旅行社信息
	public function getUnionDetail()
	{
		$id = intval($this ->input ->post('id'));
		$uninoData = $this ->union_model ->row(array('id' =>$id));
		echo json_encode($uninoData);
	}
	
	//编辑旅行社
	public function edit()
	{
		$id = intval($this ->input ->post('id'));
		$union_name = trim($this ->input ->post('union_name'));
		$linkman = trim($this ->input ->post('linkman'));
		$linkmobile= trim($this ->input ->post('linkmobile'));
		$bankcard = trim($this ->input ->post('bankcard'));
		$bankname = trim($this ->input ->post('bankname'));
		$branch = trim($this ->input ->post('branch'));
		$cardholder = trim($this ->input ->post('cardholder'));
		$country = intval($this ->input ->post('country'));
		$province = intval($this ->input ->post('province'));
		$city = intval($this ->input ->post('city'));
		if (empty($union_name))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社名称');
		}
		if (empty($linkman))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社联系人');
		}
		if (empty($linkmobile))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社联系人手机号');
		}
		$unionData = $this ->union_model ->row(array('id' =>$id));
		if (empty($unionData))
		{
			$this ->callback ->setJsonCode(4000 ,'旅行社不存在');
		}
		
		if (empty($city))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择所在城市');
		}
		
		if (empty($bankcard))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行卡号');
		}
		if (empty($bankname))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写银行名称');
		}
		if (empty($branch))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写开户支行');
		}
		if (empty($cardholder))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写持卡人');
		}
		$unionArr = array(
				'union_name' =>$union_name,
				'linkman' =>$linkman,
				'linkmobile' =>$linkmobile,
				'admin_id' =>$this ->admin_id,
				'bankcard' =>$bankcard,
				'bankname' =>$bankname,
				'branch' =>$branch,
				'cardholder' =>$cardholder,
				'country' =>$country,
				'province' =>$province,
				'city' =>$city
		);
		if ($union_name == $unionData['union_name'])
		{
			$status = $this ->db ->where('id' ,$id) ->update('b_union' ,$unionArr);
		}
		else
		{
			//若旅行社名称有更改，则要改变营业部表和管家表的旅行社名称
			$deparData = $this ->union_model ->getUnionDepaAll($id);
			$deparIds = '';
			if (!empty($deparData))
			{
				foreach($deparData as $k =>$v)
				{
					$deparIds .= $v['id'].',';
				}
			}
			$status = $this ->union_model ->updateUnion($unionArr ,$id ,rtrim($deparIds,','));
		}
		if ($status == true)
		{
			$this ->log(3, 3, '旅行社管理', '修改旅行社信息,旅行社ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
		else 
		{
			$this ->callback ->setJsonCode(4000 ,'修改失败');
		}
	}
	
	//停用旅行社
	public function disable()
	{
		$id = intval($this ->input ->post('id'));
		$remark = trim($this ->input ->post('remark'));
		if (empty($remark))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写停用原因');
		}
		$unionData = $this ->union_model ->row(array('id' =>$id));
		if (empty($unionData))
		{
			$this ->callback ->setJsonCode(4000 ,'旅行社不存在');
		}
		$unionArr = array(
				'status' =>-1,
				'remark' =>$remark
		);
		$deparData = $this ->union_model ->getUnionDepaAll($id);
		$deparIds = '';
		if (!empty($deparData))
		{
			foreach($deparData as $k =>$v)
			{
				$deparIds .= $v['id'].',';
			}
		}
		
		$status = $this ->union_model ->disableUnion($unionArr ,$id ,rtrim($deparIds ,','));
		if ($status === true)
		{
			$this ->log(3, 3, '旅行社管理', '停用旅行社,旅行社ID:'.$id);
			//发送短息
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>'union_disable' ,'isopen' =>1));
			if (!empty($smsData['msg']) && !empty($unionData['linkmobile']))
			{
				$msg = str_replace('{#REMARK#}',$remark,$smsData['msg']);
				$msg = str_replace('{#UNION_NAME#}',$unionData['union_name'],$msg);
				$this ->send_message($unionData['linkmobile'] ,$msg);
			}
			$this ->callback ->setJsonCode(2000 ,'停用成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'停用失败');
		}
		
	}
	//启用旅行社
	public function enable()
	{
		$id = intval($this ->input ->post('id'));
		$unionData = $this ->union_model ->row(array('id' =>$id));
		if (empty($unionData) || $unionData['status'] != -1)
		{
			$this ->callback ->setJsonCode(4000 ,'旅行社不存在或旅行社不在停用状态');
		}
		$this->db->trans_start();
		//启用旅行社
		$this ->db ->where('id' ,$id) ->update('b_union' ,array('status' =>1));

		$time = date('Y-m-d H:i:s',time());
		//启用营业部
		$this ->db ->where('union_id' ,$id) ->update('b_depart' ,array('status' =>1 ,'modtime' =>$time));
		
		$this->db->trans_complete();
		if ($this->db->trans_status() === true)
		{
			$this ->log(3, 3, '旅行社管理', '启用旅行社,旅行社ID:'.$id);
			//发送短息
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>'union_open' ,'isopen' =>1));
			if (!empty($smsData['msg']) && !empty($unionData['linkmobile']))
			{
				$msg = str_replace('{#UNION_NAME#}',$unionData['union_name'],$smsData['msg']);
				$this ->send_message($unionData['linkmobile'] ,$msg);
			}
			$this ->callback ->setJsonCode(2000 ,'启用成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'启用失败');
		}
	}
}