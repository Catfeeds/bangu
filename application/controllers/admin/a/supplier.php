<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Supplier extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'supplier_model');
		
	}
	public function index()
	{
		$this->view ( 'admin/a/supplier/supplier_list');
	}
	
	public function getSupplierData()
	{
		$data = $this ->getCommonData();
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
	
	
	public function getCommonData($type=false)
	{
		$whereArr = array();
		$postArr = $this->security->xss_clean($_POST);
		switch($postArr['status'])
		{
			case 1: //新申请
				$whereArr ['s.status ='] = 1;
				$order_by = 's.id desc';
				break;
			case 2: //已通过
			case 3: //已拒绝
			case -1://冻结
			case -2://已终止
				$whereArr ['s.status ='] = $postArr['status'];
				$order_by = 's.modtime desc';
				break;
			default:
				echo json_encode($this ->defaultArr);exit;
				break;
		}
		//供应商名称搜索
		if (!empty($postArr['supplier_id']))
		{
			$whereArr ['s.id ='] = intval($postArr['supplier_id']);
		}
		elseif (!empty($postArr['supplier_name']))
		{
			$whereArr ['s.company_name like'] = '%'.trim($postArr['supplier_name']).'%';
		}
		//供应商品牌搜索
		if (!empty($postArr['brand']))
		{
			$whereArr ['s.brand like'] = '%'.trim($postArr['brand']).'%';
		}
		
		//所在地搜索
		if (!empty($postArr['city']))
		{
			$whereArr ['s.city='] = intval($postArr['city']);;
		}
		elseif (!empty($postArr['province']))
		{
			$whereArr ['s.province='] = intval($postArr['province']);;
		}
		elseif (!empty($postArr['country']))
		{
			$whereArr ['s.country='] = intval($postArr['country']);;
		}
		//手机号搜索
		if (!empty($postArr['mobile']))
		{
			$whereArr['s.mobile='] = trim($postArr['mobile']);
		}
		//邮箱搜索
		if (!empty($postArr['email']))
		{
			$whereArr['s.email='] = trim($postArr['email']);
		}
		if (!empty($postArr['admin_id']))
		{
			$whereArr['s.admin_id='] = $postArr['admin_id'];
		}
		elseif(!empty($postArr['username']))
		{
			$whereArr['a.username like'] = '%'.trim($postArr['username']).'%';
		}
		if (!empty($postArr['starttime']))
		{
			$whereArr['s.modtime >='] = $postArr['starttime'];
		}
		if (!empty($postArr['endtime']))
		{
			$whereArr['s.modtime <='] = $postArr['endtime'].' 23:59:59';
		}
		
		if (!empty($postArr['stime']))
		{
			$whereArr['s.addtime >='] = $postArr['stime'];
		}
		if (!empty($postArr['etime']))
		{
			$whereArr['s.addtime <='] = $postArr['etime'].' 23:59:59';
		}
		
		$sql = '';
		if ($postArr['isExpert'] == 1)
		{
			$sql = '(select e.id from u_expert as e where e.supplier_id = s.id and e.status=2 limit 1) >0';
		}
		elseif ($postArr['isExpert'] == 2)
		{
			$sql = '(select e.id from u_expert as e where e.supplier_id = s.id and e.status=2 limit 1) is null';
		}
		
		return $this ->supplier_model ->getSupplierData ($whereArr  ,$order_by ,$type ,$sql);
	}
	
	//导出excel
	public function exportExcel()
	{
		$data = $this ->getCommonData('all');
	//var_dump($data);exit;
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
	
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 35 );
		$objActSheet->setCellValue ( "A1", '供应商名称' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->setCellValue ( "B1", '所在地' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "C1", '入驻日期' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "D1", '品牌名称' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 20 );
		$objActSheet->setCellValue ( "E1", '负责人' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 20 );
		$objActSheet->setCellValue ( "F1", '负责人电话' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 20 );
		$objActSheet->setCellValue ( "G1", '联系人' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'H' )->setWidth ( 20 );
		$objActSheet->setCellValue ( "H1", '联系人电话' );
		$objActSheet->getStyle ( 'H1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'I' )->setWidth ( 30 );
		$objActSheet->setCellValue ( "I1", '电子邮箱' );
		$objActSheet->getStyle ( 'I1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'J' )->setWidth ( 35 );
		$objActSheet->setCellValue ( "J1", '主营业务' );
		$objActSheet->getStyle ( 'J1' )->applyFromArray ($style_array);
		
		$objActSheet->getColumnDimension ( 'K' )->setWidth ( 35 );
		$objActSheet->setCellValue ( "K1", '直属管家' );
		$objActSheet->getStyle ( 'K1' )->applyFromArray ($style_array);
	
		$i=0;
		foreach ( $data as $key => $val )
		{
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['company_name'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
			
			$address = $val['province'].$val['city'];
			$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $address, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $val['addtime'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['brand'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $val['realname'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
				
			
			$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $val['mobile'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
				
			$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $val['linkman'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'H' . ($i + 2), $val['link_mobile'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'H' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'I' . ($i + 2), $val['email'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'I' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'J' . ($i + 2), $val['expert_business'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'J' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'K' . ($i + 2), $val['expert_names'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'K' . ($i + 2) )->applyFromArray ($one_style_array);
			$i ++;
		}
	
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/b2/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		$this ->callback ->setJsonCode(2000 ,'/'.$file);
	}
	
	//获取一条记录
	public function getDetailData()
	{
		$id = intval($this ->input ->post('id'));
		$data = $this ->supplier_model ->getSupplierDetail($id);
		echo json_encode($data);
	}
	/**
	 * @method 调整供应商管理费率
	 * @author jiakairong
	 */
	function adjustAgentRate() {
		$id = intval($this ->input ->post('id'));
		$agent_rate = floatval($this ->input ->post('agent_rate'));
		if ($agent_rate <= 0 || $agent_rate >= 100)
		{
			$this->callback->setJsonCode ( 4000 ,'管理费率在0到100之间');
		}
		$supplier = $this ->supplier_model ->row(array('id' =>$id) ,'arr' ,'' ,'mobile,status');
		if (empty($supplier))
		{
			$this->callback->setJsonCode ( 4000 ,'此商家不存在');
		}
		
		$supplierArr = array(
			'agent_rate' =>round($agent_rate /100 ,4)
		);

		$status = $this ->supplier_model ->update($supplierArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'调整失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg'=>'调整成功'));
			$this ->log(3,3,'供应商管理','平台调整供应商的管理费率，ID：'.$id.',管理费率：'.$agent_rate.'%');
			//发短信
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$sms = $this ->sms_model ->row(array('msgtype' =>'supplier_agent_rate' ,'isopen' =>1));
			$content = str_replace('{#AGENT_RATE#}', $agent_rate, $sms['msg']);
			$this ->send_message($supplier['mobile'] ,$content);
		}
	}
	/**
	 * @method 通过申请
	 * @author jiakairong
	 * @since  2015-12-01
	 */
	function through_apply()
	{
		$id = intval($this ->input ->post('id'));
		$agent_rate = floatval($this ->input ->post('agent_rate'));
// 		$code = trim($this ->input ->post('code' ,true));
		if ($agent_rate <= 0 || $agent_rate >= 100)
		{
			$this->callback->setJsonCode ( 4000 ,'管理费率在0到100之间');
		}
// 		if (empty($code))
// 		{
// 			$this->callback->setJsonCode ( 4000 ,'请填写供应商代码');
// 		}
		
		$supplier = $this ->supplier_model ->row(array('id' =>$id));
		if (empty($supplier) || $supplier['status'] != 1)
		{
			$this->callback->setJsonCode ( 4000 ,'此商家不在审核中，请确认此商家的状态');
		}
		
		//验证登录账号是否存在
		$whereArr = array(
				'login_name =' =>$supplier['login_name'],
				'id !=' =>$supplier['id'], //排除自己
				'status !=' =>3 //排除已拒绝的
		);
		$supplierMobile = $this ->supplier_model ->uniqueLoginname($whereArr);
		if (!empty($supplierMobile))
		{
			$this->callback->setJsonCode ( 4000 ,'联系人手机号已存在，不可通过');
		}
		
		//验证手机号是否存在
// 		$supplierMobile = $this ->supplier_model ->throughSupplierMobile($supplier['link_mobile'] ,$id);
// 		if (!empty($supplierMobile))
// 		{
// 			$this->callback->setJsonCode ( 4000 ,'联系人手机号已存在，不可通过');
// 		}
		//var_dump($supplier);exit;
		//验证邮箱
// 		if (!empty($supplier['linkemail']))
// 		{
// 			//验证邮箱
// 			$supplierEmail = $this ->supplier_model ->throughSupplierEmail($supplier['linkemail'] ,$id);
// 			if (!empty($supplierEmail))
// 			{
// 				$this->callback->setJsonCode ( 4000 ,'邮箱号已存在，不可通过');
// 			}
// 		}

		$supplierArr = array(
			'status' =>2,
			'modtime' =>date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']),
			'enable' =>1,
			'agent_rate' =>round($agent_rate /100 ,4),
			//'code' =>$code,
			'admin_id' =>$this ->admin_id
		);
		$status = $this ->supplier_model ->update($supplierArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->load_model('admin/a/web_model' ,'web_model');
			$webData = $this ->web_model ->row(array('id' =>1) ,'arr' ,'' ,'eqixiu_url');
			$url = $webData['eqixiu_url'].'/index.php?c=user&a=registerApi&loginName='.$supplier['mobile'].'&password='.$supplier['password'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			$data = curl_exec($ch);
			curl_close($ch);
			
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_through_msg ,'isopen' =>1));
			$this ->send_message($supplier['link_mobile'] ,$sms['msg']);
			$this ->log(5,3,'供应商管理','审核通过供应商申请,ID：'.$id.',管理费率:'.$agent_rate.'%');
		}
	}
	/**
	 * @method 拒绝申请
	 * @author jiakairong
	 * @since  2015-12-01
	 */
	public function refuse_apply() {
		$id = intval($this ->input ->post('id'));
		$refuse_reason = trim($this ->input ->post('refuse_reason' ,true));
		if (empty($refuse_reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写拒绝原因');
		}
		$supplier = $this ->supplier_model ->row(array('id' =>$id));
		if (empty($supplier) || $supplier['status'] != 1)
		{
			$this->callback->setJsonCode ( 4000 ,'此商家不在审核中，请确认此商家的状态');
		}
		$supplierArr = array(
				'status' =>3,
				'modtime' =>date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']),
				'enable' =>0,
				'refuse_reason' =>$refuse_reason,
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->supplier_model ->update($supplierArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,"操作失败");
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$this ->log(5,3,'供应商管理','审核拒绝供应商申请，ID：'.$id);
			$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_refuse_msg ,'isopen' =>1));
			$content = str_replace('{#REASON#}', $refuse_reason, $sms['msg']);
			$this ->send_message($supplier['link_mobile'] ,$content);
		}
	}
	
	/**
	 * @method 冻结供应商
	 * @author jiakairong
	 * @since  2015-12-01
	 */
	public function frozenSupplier()
	{
		$id = intval($this ->input ->post('id'));
		$refuse_reason = trim($this ->input ->post('reason'));
		$supplier = $this ->supplier_model ->row(array('id' =>$id));
		if (empty($supplier))
		{
			$this->callback->setJsonCode ( 4000 ,'此商家不在审核中，请确认此商家的状态');
		}
		
		if (empty($refuse_reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写冻结理由');
		}
		$time = date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME']);
		//供应商变更数据
		$supplierArr = array(
			'modtime' =>$time,
			'status' =>-1,
			'enable' =>0,
			'refuse_reason' =>$refuse_reason
		);
		//黑名单数据
		$platformArr = array(
			'refuse_type' =>2,
			'userid' =>$id,
			'freeze_days' =>-1,
			'admin_id' =>$this ->admin_id,
			'reason' =>$refuse_reason,
			'addtime' =>$time,
			'status' =>0
		);
		
		$status = $this ->supplier_model ->frozenSupplier($id ,$supplierArr ,$platformArr);
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$this ->log(3,3,'供应商管理','冻结供应商，ID：'.$id);
			$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_stop_msg ,'isopen' =>1));
			$content = str_replace('{#REASON#}', $refuse_reason, $sms['msg']);
			$this ->send_message($supplier['link_mobile'] ,$content);
		}
	}
	
	/**
	 * @method 终止与供应商合作
	 * @author jiakaiorng
	 * @since  2015-12-01
	 */
	public function stop_supplier()
	{
		$id = intval($this ->input ->post('id'));
		$supplier = $this ->supplier_model ->row(array('id' =>$id) ,'arr' ,'' ,'id,status,mobile');
		if (empty($supplier) || $supplier['status'] != -1)
		{
			$this->callback->setJsonCode ( 4000 ,'此商家并未被冻结，不可终止');
		}
		$supplierArr = array(
			'status' =>-2,
			'modtime' =>date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME'])
		);
		$status = $this ->supplier_model ->update($supplierArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3,3,'供应商管理','终止与供应商合作，ID：'.$id);
		}
	}
	/**
	 * @method 恢复与供应商合作
	 * @author jiakairong
	 * @since  2015-12-02
	 */
	public function recovery()
	{
		$id = intval($this ->input ->post('id'));
		$supplier = $this ->supplier_model ->row(array('id' =>$id));
		if (empty($supplier) || $supplier['status'] != -1)
		{
			$this->callback->setJsonCode ( 4000 ,'此商家不在冻结状态，不可进行此操作');
		}

		$status = $this ->supplier_model ->recoverySupplier($id);
		
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3,3,'供应商管理','恢复与供应商合作，ID：'.$id);
			$this ->load_model('admin/a/sms_template_model' ,'sms_model');
			$sms = $this ->sms_model ->row(array('msgtype' =>sys_constant::supplier_back ,'isopen' =>1));
			$this ->send_message($supplier['link_mobile'] ,$sms['msg']);
		}
	}
	
	/**
	 * @method 新增供应商
	 * @author jiakairong
	 * @since  2015-08-08
	 */
	public function add_supplier() {
		$this->load->helper ( 'regexp' );
		$post = $this->security->xss_clean($_POST);
		foreach($post as $key =>$val)
		{
			$post[$key] = trim($val);
		}
		
		if ($post['type'] != 1 && $post['type'] != 2 && $post['type'] != 3)
		{
			$this->callback->setJsonCode ( 4000 ,'请选择供应商类型');
		}
		if (empty($post['mobile']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写负责人手机号');
		}

		$password_len = strlen($post['password']);
		if (empty($post['password']) || $password_len < 6 || $password_len > 20)
		{
			$this->callback->setJsonCode ( 4000 ,'请填写6到20位的密码');
		}
		else
		{
			if ($post['password'] != $post['repass'])
			{
				$this->callback->setJsonCode ( 4000 ,'两次密码输入不一致');
			}
		}
		if (empty($post['realname']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写负责人姓名');
		}
		if ($post['type'] == 1 || $post['type'] == 2)
		{
			if (empty($post['idcardpic']))
			{
				$this->callback->setJsonCode ( 4000 ,'请上传身份证扫描件');
			}
		}
		else 
		{
			if (empty($post['idcardpic']))
			{
				$this->callback->setJsonCode ( 4000 ,'请上传有效证件扫描件');
			}
		}
		if (empty($post['city']))
		{
			$this->callback->setJsonCode ( 4000 ,'请将供应商所在地选择完整');
		}
		if (empty($post['brand']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写供应商品牌');
		}
		if (empty($post['expert_business']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写主营业务');
		}
		if (empty($post['linkman']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写联系人');
		}
		if (empty($post['link_mobile']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写联系人手机号');
		}
		else
		{
			$supplier = $this ->supplier_model ->uniqueMobileAdd($post['link_mobile']);
			if (!empty($supplier))
			{
				$this->callback->setJsonCode ( 4000 ,'联系人手机号已存在,不可添加');
			}
		}
		
		if (!regexp('email' ,$post['email']))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写正确的电子邮箱');
		}
		
		if ($post['type'] == 1 || $post['type'] == 3)
		{
			if (empty($post['company_name']))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写企业名称');
			}
			if (empty($post['corp_name']))
			{
				$this->callback->setJsonCode ( 4000 ,'请填法人代表姓名');
			}
		}
		if ($post['type'] == 1)
		{
			if (empty($post['business_licence']))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写营业执照扫描件');
			}
			if (empty($post['licence_img']))
			{
				$this->callback->setJsonCode ( 4000 ,'请填写经营许可证扫描件');
			}
// 			if (empty($post['corp_idcardpic']))
// 			{
// 				$this->callback->setJsonCode ( 4000 ,'请填写法人代表身份证扫描件');
// 			}
		}
		
		$this ->load_model('common/cfg_web_model' ,'web_model');
		$webData = $this ->web_model ->row(array('id' =>1),'arr' ,'' ,'agent_rate');
		
		if (empty($post['country'])) //获取地区第一级
		{
			$this ->load_model('common/u_area_model' ,'area_model');
			$areaData = $this ->area_model ->row(array('id' =>$post['province']));
			$post['country'] = $areaData['pid'];
		}
		$date = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$supplierArr = array(
			'kind' =>$post['type'],
			'mobile' =>$post['mobile'],
			'login_name' =>$post['link_mobile'],
			'password' =>md5($post['password']),
			'realname' =>$post['realname'],
			'idcardpic' =>$post['idcardpic'],
			'country' =>$post['country'],
			'province' =>$post['province'],
			'city' =>empty($post['city']) ? 0 : $post['city'],
			'region' =>empty($post['region']) ? 0 : $post['region'],
			'brand' =>$post['brand'],
			'expert_business' =>$post['expert_business'],
			'linkman' =>$post['linkman'],
			'link_mobile' =>$post['link_mobile'],
			'telephone' =>$post['tel'],
			'fax' =>$post['fax'],
			'email' =>$post['email'],
			'company_name' =>empty($post['company_name']) ? '' : $post['company_name'],
			'business_licence' =>empty($post['business_licence']) ? '' : $post['business_licence'],
			'licence_img' =>empty($post['licence_img']) ? '' : $post['licence_img'],
			'corp_name' =>empty($post['corp_name']) ? '' : $post['corp_name'],
			'corp_idcardpic' =>empty($post['corp_idcardpic']) ? '' : $post['corp_idcardpic'],
			'addtime' =>$date,
			'modtime' =>$date,
			'status' =>1,
			'enable' =>0,
			'agent_rate' =>$webData['agent_rate']
		);
		$status = $this ->db ->insert('u_supplier' ,$supplierArr);
		if ($status == false) {
			$this->callback->setJsonCode ( 4000 , '添加失败');
		} else {
			$this->callback->setJsonCode ( 2000 , '添加成功');
		}
	}
	//修改资料
	public function edit() 
	{
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['company_name']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写公司名称');
		}
		if (empty($postArr['brand']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写品牌名称');
		}
		
		if (empty($postArr['mobile'])) 
		{
			$this ->callback ->setJsonCode(4000 ,'请填写负责人手机号');
		}
		else
		{
			$supplierData = $this ->supplier_model ->throughSupplierMobile($postArr['mobile'] ,$postArr['id']);
			//echo $this->db->last_query();exit;
			if (!empty($supplierData))
			{
				$this ->callback ->setJsonCode(4000 ,'手机号已存在');
			}
		}
		if (empty($postArr['realname']))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写负责人姓名');
		}
		if (empty($postArr['idcardpic']))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传身份证扫描件');
		}
		if ($postArr['kind'] == 1 || $postArr['kind'] == 2) 
		{
			if (empty($postArr['corp_name']))
			{
				$this ->callback ->setJsonCode(4000 ,'请填写法人姓名');
			}
		}
		if ($postArr['kind'] == 1)
		{
			if (empty($postArr['business_licence']))
			{
				$this ->callback ->setJsonCode(4000 ,'请上传营业执照扫描件');
			}
			if (empty($postArr['licence_img_code']))
			{
				$this ->callback ->setJsonCode(4000 ,'请填写营业执照号');
			}
			if (empty($postArr['licence_img']))
			{
				$this ->callback ->setJsonCode(4000 ,'请上传经营许可证扫描件');
			}
// 			if (empty($postArr['corp_idcardpic']))
// 			{
// 				$this ->callback ->setJsonCode(4000 ,'请上传法人身份证扫描件');
// 			}
		}
		$dataArr = array(
				'mobile' =>$postArr['mobile'],
				'company_name' =>$postArr['company_name'],
				'brand' =>$postArr['brand'],
				'realname' =>$postArr['realname'],
				'idcardpic' =>$postArr['idcardpic'],
				'corp_name' =>$postArr['corp_name'],
				'business_licence' =>$postArr['business_licence'],
				'licence_img_code' =>$postArr['licence_img_code'],
				'licence_img' =>$postArr['licence_img'],
				'corp_idcardpic' =>$postArr['corp_idcardpic']
		);
		$status = $this ->supplier_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if ($status == true)
		{
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		} else {
			$this ->callback ->setJsonCode(4000 ,'修改失败');
		}
	}
	//获取供应商银行账号  @xml
	function get_supplier_brank(){
		$id=$this->input->post('id',true);
		if(!empty($id)){
			$data=$this ->supplier_model ->sel_supplier_brank($id);
			echo  json_encode(array('status'=>1,'data'=>$data));
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
		}
	}
	//保存供应商的银行账号
	function  save_supplier_brand(){
		$supplier_id=$this->input->post('supplierID',true);
		$bank=$this->input->post('bank_num',true);
		$bankname=$this->input->post('bankname',true);
		$brand=$this->input->post('brand',true);
		$openman=$this->input->post('openman',true);
		$brand_id=$this->input->post('brand_id',true);
		if(empty($bank)){
			echo  json_encode(array('status'=>-1,'msg'=>'开户账号'));exit;
		}
		if(empty($bankname)){
			echo  json_encode(array('status'=>-1,'msg'=>'开户银行'));exit;
		}
		if(empty($brand)){
			echo  json_encode(array('status'=>-1,'msg'=>'开户银行支行'));exit;
		}
		if(empty($openman)){
			echo  json_encode(array('status'=>-1,'msg'=>'开户人'));exit;
		}
		
		if(!empty($supplier_id)){
			$data=array(
				'bank'=>$bank,
				'bankname'=>$bankname,
				'brand'=>$brand,
				'openman'=>$openman,
				'modtime'=>date('Y-m-d H:i:s',time()),
			);
			$where=array('id'=>$brand_id,'supplier_id'=>$supplier_id);
			$re =$this ->supplier_model->save_Sbrand($data,$where);
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'保存成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'保存失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'保存失败'));
		}
	}
	/**
	 * @method 供应商对接口
	 * @author xml
	 */
	function supplier_interface(){
		//$data =$this ->supplier_model->et_supplier_secret();
		$this->view ( 'admin/a/supplier/supplier_interface');
	}
	/**
	 * @method 添加供应商对接口页面
	 * @author xml
	 */
	function add_interface(){
		
		$this->load->view("admin/a/supplier/add_interface");
	}
	/**
	 * @method 添加供应商数据 用于供应商对接管理
	 * @author xml
	 */
	 function get_supplier_data(){
	 	$this ->load_model('admin/a/supplier_secret_key_model','supplier_secret');
	 	$whereArr = array();
	 	$postArr = $this->security->xss_clean($_POST);

	 	//供应商名称搜索
	 	if (!empty($postArr['supplier_id']))
	 	{
	 		$whereArr ['s.id ='] = intval($postArr['supplier_id']);
	 	}
	 	elseif (!empty($postArr['supplier_name']))
	 	{
	 		$whereArr ['s.company_name like'] = '%'.trim($postArr['supplier_name']).'%';
	 	}
	 	//供应商品牌搜索
	 	if (!empty($postArr['brand']))
	 	{
	 		$whereArr ['s.brand like'] = '%'.trim($postArr['brand']).'%';
	 	}
	 	//供应商负责人
	 	if (!empty($postArr['realname']))
	 	{
	 		$whereArr ['s.realname ='] = $postArr['realname'];
	 	}
	 	
	 	//手机号搜索
	 	if (!empty($postArr['mobile']))
	 	{
	 		$whereArr['s.mobile='] = trim($postArr['mobile']);
	 	}
	 
	 	$data=$this ->supplier_secret ->getSupplierApiData ($whereArr  ,'s.id desc' ,false);
	 	echo json_encode($data);
	 	
	 }
	 /**
	  * @method 添加供应商对接数据  用于供应商对接管理 
	  *  @author xml
	  */
	 function add_supplier_secret(){
	 	$this ->load_model('admin/a/supplier_secret_key_model','supplier_secret');
	
	 	$supplier_id=$this->input->post('is_check',true);
	 	if(!empty($supplier_id)){
	 		 $this->db->trans_start();

	 		 foreach ($supplier_id as $k=>$v){
	 		 	  //判断改供应商是否有选择
	 		 	  $supplier=$this->supplier_secret->get_supplier_key($v);
	 		 	  if(!empty($supplier)){
	 		 	     	$this ->callback ->setJsonCode(4000 ,"供应商{$supplier['realname']}已存在");
	 		 	  }
	 		 	  
	 		 	  //生成供应商ID
	 		 	  $x=0;
	 		 	  while($x==0){
	 		 	  	$string=strtotime(date('Y-m-s H:i:s',time()));
	 		 	  	$appkey='bangu'.$string.rand(1,10000);
	 		 	  	
	 		 	  	$appkeyData=$this->supplier_secret->row(array('appkey'=>$appkey));
	                if(!empty($appkeyData)){
	                	$x=0; 	
	                }else{
	                	$x=1;
	                }
	 		 	  } 
	 		 	  
	 		 	  //生成供应商秘钥
	 		 	  $y=0;
	 		 	  while($y==0){
	 		 	  	$secret=sha1((md5('supplier'.$v.rand(1,99999))));
	 		 	  	$secretData=$this->supplier_secret->row(array('secret'=>$secret));
	 		 	  	if(!empty($secretData)){
	 		 	  		$y=0;
	 		 	  	}else{
	 		 	  		$y=1;
	 		 	  	}
	 		 	  }
               
	 		 	  if(!empty($appkey)&&!empty($secret)){
                      $keyArr=array(
                      	 'supplierId'=>$v,
                      	 'appkey'=>$appkey,
                      	'secret'=>$secret
                      );
                      $this->supplier_secret->insert($keyArr);
	 		 	  	
	 		 	  }else{
	 		 	  	$this ->callback ->setJsonCode(4000 ,"添加失败");
	 		 	  }

	 		 }

	 		 $this->db->trans_complete();
	 		 if($this->db->trans_status()==false){
	 		 	$this ->callback ->setJsonCode(4000 ,'添加失败');
	 		 }else{
	 		 	$this ->callback ->setJsonCode(200 ,'添加成功');
	 		 }
	 	}else{
	 		$this ->callback ->setJsonCode(4000 ,'请选择供应商');
	 	}
	 }
	 /**
	  * @method 获取供应商对接数据  用于供应商对接管理
	  *  @author xml
	  */
	 function get_supplier_secretkey(){
	 	$this ->load_model('admin/a/supplier_secret_key_model','supplier_secret');
	 	
	 	$supplier_id= trim($this ->input ->post('supplier_id' ,true));
	 	$supplier_name= trim($this ->input ->post('supplier_name' ,true));
	 	$realname= trim($this ->input ->post('realname' ,true));
	 	$mobile= trim($this ->input ->post('mobile' ,true));
	 	$brand= trim($this ->input ->post('brand' ,true));

	 	$whereArr = array();
	 	if(!empty($supplier_id)){
	 		$whereArr['sk.supplierId ='] =$supplier_id;
	 	}else{
	 		$whereArr['s.company_name like'] = '%'.$supplier_name.'%';
	 	} 
	 	
	 	if(!empty($realname)){
	 		$whereArr['s.realname ='] =$realname;
	 	}
	 	if(!empty($mobile)){
	 		$whereArr['s.mobile ='] =$mobile;
	 	}
	 	if(!empty($brand)){
	 		$whereArr['s.brand like'] = '%'.$brand.'%';
	 	}
/* 	 	switch($status)
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
	 	} */
	 	
	 	$data = $this ->supplier_secret ->getSupplierKeyData($whereArr);
	 	echo json_encode($data);
	 }
	 
}