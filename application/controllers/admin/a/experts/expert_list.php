<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 * @method 		管家列表
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
include './application/controllers/admin/commonExpert.php';
class Expert_list extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'admin/a/expert_model', 'expert_model' );
		$this->load_model('dest/dest_base_model' ,'dest_base_model');
		$this->load_model('line_apply_model' ,'line_apply_model');
		$this->load_model('line_model' ,'line_model');
	}
	//管家列表
	public function index()
	{
		$destArr = array();
		
		$destData = $this ->dest_base_model ->all(array('level <=' =>2) ,'level asc');
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				if ($val['level'] == 1)
				{
					$destArr[$val['id']] = $val;
				}
				elseif ($val['level'] == 2)
				{
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][] = $val;
					}
				}
			}
		}
		$data['destArr'] = $destArr;
		
		$this->view ( 'admin/a/expert/expert_list' ,$data);
		//$this->view ( 'admin/a/view');
	}
	//返回管家数据
	public function getExpertData()
	{
		$data = $this ->getCommonData();
		echo json_encode($data);
	}
	
	public function getCommonData($type=false)
	{
		$whereArr = array();
		$postArr = $this->security->xss_clean($_POST);
		
		switch($postArr['status'])
		{
			case 1:
				$whereArr ['e.status = '] = $postArr['status'];
				$order_by = 'e.id';
				break;
			case 2:
			case 3:
			case -1:
				$whereArr ['e.status ='] = $postArr['status'];
				$order_by = 'e.modtime';
				break;
			case -2:
				$whereArr ['e.status ='] = 0;
				$order_by = 'e.id';
				break;
			case 5:
				$whereArr ['e.status ='] = $postArr['status'];
				$order_by = 'e.modtime';
				break;
			default:
				echo json_encode($this->defaultArr);exit;
				break;
		}
		//搜索姓名
		if (!empty($postArr['realname']))
		{
			$whereArr ['e.realname like'] = '%'.trim($postArr['realname']).'%';
		}
		if (!empty($postArr['nickname']))
		{
			$whereArr ['e.nickname like'] = '%'.trim($postArr['nickname']).'%';
		}
		//搜索手机号
		if (!empty($postArr['mobile']))
		{
			$whereArr ['e.mobile ='] = trim($postArr['mobile']);
		}
		if (!empty($postArr['email']))
		{
			$whereArr ['e.email ='] = trim($postArr['email']);
		}
		//搜索地区
		if (isset($postArr['city']) && $postArr['city'] > 0)
		{
			$whereArr ['e.city ='] = $postArr['city'];
		}
		elseif (isset($postArr['province']) && !empty($postArr['province']))
		{
			$whereArr ['e.province ='] = $postArr['province'];
		}
		elseif (isset($postArr['country']) && !empty($postArr['country']))
		{
			$whereArr ['e.country ='] = $postArr['country'];
		}
		if (!empty($postArr['admin_id']))
		{
			$whereArr['e.admin_id ='] = $postArr['admin_id'];
		}
		elseif (!empty($postArr['username']))
		{
			$whereArr['ua.username like'] = '%'.trim($postArr['username']).'%';
		}
		if (!empty($postArr['starttime']))
		{
			$whereArr['e.modtime >='] = $postArr['starttime'];
		}
		if (!empty($postArr['endtime']))
		{
			$whereArr['e.modtime <='] = $postArr['endtime'].' 23:59:59';
		}
		if (isset($postArr['union_status']))
		{
			$whereArr['e.union_status ='] = $postArr['union_status'];
		}
		//获取数据
		return $this ->expert_model ->getExpertData ($whereArr ,$order_by ,$type);
	}
	
	//导出excel
	public function exportExcel()
	{
		$data = $this ->getCommonData(true);
	
		//生成excel
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
	
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 15 );
		$objActSheet->setCellValue ( "A1", '管家姓名' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 15 );
		$objActSheet->setCellValue ( "B1", '管家昵称' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "C1", '手机号' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "D1", '邮箱号' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "E1", '身份证' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "F1", '所在地' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 35 );
		$objActSheet->setCellValue ( "G1", '营业部' );
		if ($_POST['status'] ==2)
		{
			$objActSheet->getStyle ( 'H1' )->applyFromArray ($style_array);
			$objActSheet->getColumnDimension ( 'H' )->setWidth ( 35 );
			$objActSheet->setCellValue ( "H1", '直属供应商' );
			$objActSheet->getStyle ( 'H1' )->applyFromArray ($style_array);
			$objActSheet->getColumnDimension ( 'I' )->setWidth ( 15 );
			$objActSheet->setCellValue ( "I1", '售卖数量' );
			$objActSheet->getStyle ( 'I1' )->applyFromArray ($style_array);
		}
	
		$i=0;
		foreach ( $data as $key => $val )
		{
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['realname'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['nickname'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $val['mobile'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['email'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $val['idcard'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
			
			$address = $val['pd_name'].$val['cid_name'];
			$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $address, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
			
			$name = empty($val['union_name']) ? '平台' : $val['union_name'];
			$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $name, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
			if ($_POST['status'] ==2)
			{
				$objActSheet->setCellValueExplicit ( 'H' . ($i + 2), $val['company_name'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'H' . ($i + 2) )->applyFromArray ($one_style_array);
				$objActSheet->setCellValueExplicit ( 'I' . ($i + 2), $val['apply_num'], PHPExcel_Cell_DataType::TYPE_STRING );
				$objActSheet->getStyle ( 'I' . ($i + 2) )->applyFromArray ($one_style_array);
			}	
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
	
	//添加管家页面
	public function add()
	{
		$data['destArr'] = $this ->getDestData();
		$this->load_view ( 'admin/a/expert/add_expert' ,$data);
	}
	//添加管家
	public function add_expert()
	{
		$expertNew = new CommonExpert($_POST);
		$expertNew ->addAExpert();
	}

	public function detail()
	{
		$id = intval($this ->input ->post('id'));
		$expertData = $this ->expert_model ->getExpertDetail($id);
		if (!empty($expertData))
		{
			$expertData = $expertData[0];
			$this ->load_model('area_model');
			//擅长目的地
			$destName = '';
			if (!empty($expertData['expert_dest']))
			{
				$whereArr = array(
						'in' =>array('d.id' =>$expertData['expert_dest'])
				);
				$destData = $this ->dest_base_model ->getDestBaseData($whereArr);
				if(!empty($destData))
				{
					foreach($destData as $val) {
						$destName .= $val['kindname'].',';
					}
					$destName = rtrim($destName ,',');
				}
			}
			$expertData['destName'] = $destName;
			//上门服务
			$cityname = '';
			if (!empty($expertData['visit_service']))
			{
				$areaData = $this ->area_model ->getAreaIN($expertData['visit_service']);
				if (!empty($areaData)) {
					foreach($areaData as $v) {
						$cityname .= $v['name'].',';
					}
					$cityname = rtrim($cityname ,',');
				}
			}
			$expertData['cityname'] = $cityname;
		
			//从业经历
			$this ->load_model('common/u_expert_resume_model' ,'resume_model');
			$resumeData = $this ->resume_model ->all(array('expert_id' =>$id,'status' =>1));
			//证书
			$this ->load_model('common/u_expert_certificate_model' ,'certificate_model');
			$certificateData = $this ->certificate_model ->all(array('expert_id' =>$id,'status' =>1));
				
			//转utf8编码
			foreach($expertData as $key =>$val) {
				$expertData[$key] = mb_convert_encoding($val, "UTF-8", "auto");
			}
			foreach($resumeData as $key =>$val) {
				foreach($val as $k=>$v) {
					$resumeData[$key][$k] = mb_convert_encoding($v, "UTF-8", "auto");
				}
			}
			foreach($certificateData as $key =>$val) {
				foreach($val as $k=>$v) {
					$certificateData[$key][$k] = mb_convert_encoding($v, "UTF-8", "auto");
				}
			}
			$expertData['certificate'] = $certificateData;
			$expertData['resume'] = $resumeData;
			echo json_encode($expertData);
		}
	}
	
	//返回专家详细的信息
	public function getExpertDetails()
	{
		$id = intval($this ->input ->post('id'));
		$expertData = $this ->expert_model ->getExpertDetail($id);
		if (!empty($expertData))
		{
			$expertData = $expertData[0];
			$this ->load_model('area_model');
			//擅长目的地
			$destName = '';
			if (!empty($expertData['expert_dest']))
			{
				$whereArr = array(
						'in' =>array('d.id' =>$expertData['expert_dest'])
				);
				$destData = $this ->dest_base_model ->getDestBaseData($whereArr);
				if(!empty($destData))
				{
					foreach($destData as $val) {
						$destName .= $val['kindname'].',';
					}
					$destName = rtrim($destName ,',');
				}
			}
			$expertData['destName'] = $destName;
			//上门服务
			$cityname = '';
			if (!empty($expertData['visit_service']))
			{
				$areaData = $this ->area_model ->getAreaIN($expertData['visit_service']);
				if (!empty($areaData)) {
					foreach($areaData as $v) {
						$cityname .= $v['name'].',';
					}
					$cityname = rtrim($cityname ,',');
				}
			}
			$expertData['cityname'] = $cityname;

			//从业经历
			$this ->load_model('common/u_expert_resume_model' ,'resume_model');
			$resumeData = $this ->resume_model ->all(array('expert_id' =>$id,'status' =>1));
			//证书
			$this ->load_model('common/u_expert_certificate_model' ,'certificate_model');
			$certificateData = $this ->certificate_model ->all(array('expert_id' =>$id,'status' =>1));
			
			//转utf8编码
			foreach($expertData as $key =>$val) {
				$expertData[$key] = mb_convert_encoding($val, "UTF-8", "auto");
			}
			foreach($resumeData as $key =>$val) {
				foreach($val as $k=>$v) {
					$resumeData[$key][$k] = mb_convert_encoding($v, "UTF-8", "auto");
				}
			}
			foreach($certificateData as $key =>$val) {
				foreach($val as $k=>$v) {
					$certificateData[$key][$k] = mb_convert_encoding($v, "UTF-8", "auto");
				}
			}
			$expertData['certificate'] = $certificateData;
			$expertData['resume'] = $resumeData;
			echo json_encode($expertData);
		}
	}
	
	//管家售卖线路
	public function getExpertLineData()
	{
		$likeArr = array();

		$expert_id = intval($this ->input ->post('expert_id'));
		$linename = trim($this ->input ->post('linename' ,true));
		$supplier_id = intval($this ->input ->post('search_supplier'));
		
		$whereArr = array(
				'la.status =' => 2,
				//'l.status =' => 2,
				'l.producttype =' => 0,
				//'s.status =' =>2,
				'la.expert_id =' =>$expert_id
		);
		if (!empty($supplier_id)) {
			$whereArr ['s.id'] = $supplier_id;
		}
		if (!empty($linename)) {
			$whereArr ['l.linename like'] = '%'.$linename.'%';
		}

		$data = $this ->expert_model ->getExpertApplyLine($whereArr);
		//echo $this ->db->last_query();exit;
		echo json_encode($data);
	}

	//退回管家申请
	public function refuse_expert()
	{
		$id = intval($this ->input ->post('id'));
		$refuse_reasion = trim($this ->input ->post('refuse_reasion' ,true));
		if (empty($refuse_reasion))
		{
			$this->callback->setjsonCode ( 4000 ,'请填写退回原因');
		}
		
		$expertData = $this ->expert_model ->row(array('id' =>$id) ,'arr' ,'' ,'mobile,email,status,id');
		if (empty($expertData))
		{
			$this->callback->setJsonCode ( 4000 ,'管家不存在');
		}
		if ($expertData['status'] != 1)
		{
			$this->callback->setJsonCode ( 4000 ,'此管家不在审核状态');
		}
		
		$experArr = array(
			'status' =>3,
			'modtime' =>date('Y-m-d H:i:s' ,time()),
			'refuse_reasion' =>$refuse_reasion,
			'admin_id' =>$this->admin_id
		);
		$status = $this ->expert_model ->update($experArr ,array('id' =>$id));
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'退回失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg'=>'退回成功'));
			$this ->log(5,3,'管家管理','平台退回管家注册申请，管家ID：'.$id);
			//发短信
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::expert_refuse_msg));
			if (!empty($smsData['msg']) && !empty($expertData['mobile']))
			{
				$msg = str_replace("{#REASON#}",$refuse_reasion,$smsData['msg']);
				$this ->send_message($expertData['mobile'] ,$msg);
			}
		}
	}
	//通过管家
	public function through_expert()
	{
		$id = intval($this ->input ->post('id'));
		$expertData = $this ->expert_model ->row(array('id' =>$id) ,'arr' ,'' ,'mobile,email,status,id,password,nickname');
		if (empty($expertData))
		{
			$this ->callback->setJsonCode(4000 ,'此管家不存在');
		}
		if ($expertData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'此管家不在审核状态');
		}
		if (!empty($expertData['mobile']))
		{
			$whereArr = array(
					'status =' =>2,
					'or' =>array(
							'login_name =' =>$expertData['mobile'],
							'mobile =' =>$expertData['mobile']
					)
			);
			//存在状态为2的，那么此手机号就不能通过
			$mobileExpert = $this ->expert_model ->getAllExpert($whereArr);
			if (!empty($mobileExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'手机号已存在，不可通过');
			}
		}
		if (!empty($expertData['email']))
		{
			//验证邮箱
			$whereArr = array(
					'status =' =>2,
					'email =' =>$expertData['email']
			);
			//存在状态为2的，那么此邮箱就不能通过
			$emailExpert = $this ->expert_model ->getAllExpert($whereArr);
			if (!empty($emailExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'邮箱号已存在，不可通过');
			}
		}
/* 		if (!empty($expertData['nickname']))
		{
			$nickExpert = $this ->expert_model ->all(array('nickname' =>$expertData['nickname'] ,'status != 1 and status !='=>3 ));
			if (!empty($nickExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'昵称已存在，不可通过');
			}
		} */
		$experArr = array(
				'status' =>2,
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'admin_id' =>$this->admin_id
		);
		$status = $this ->expert_model ->update($experArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'通过失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'通过成功'));
			$this ->log(5,3,'管家管理','平台通过管家注册申请，管家ID：'.$id);
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::expert_through_msg));
			if (!empty($smsData['msg']) && !empty($expertData['mobile']))
			{
				$this ->send_message($expertData['mobile'] ,$smsData['msg']);
			}
			$this ->load_model('admin/a/web_model' ,'web_model');
			$webData = $this ->web_model ->row(array('id' =>1) ,'arr' ,'' ,'eqixiu_url');
			$url = $webData['eqixiu_url'].'/index.php?c=user&a=registerApi&loginName='.$expertData['mobile'].'&password='.$expertData['password'];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_POST, 0);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			$data = curl_exec($ch);
			curl_close($ch);
		}
	}
	//终止与专家的合作
	public function stop_expert()
	{
		$id = intval($this ->input ->post('stop_id'));
		$reason = trim($this ->input ->post('reason' ,true)); //终止理由
	
		if (empty($reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写终止理由');
		}
		$expert = $this ->expert_model ->row(array('id' =>$id));
		if (empty($expert))
		{
			$this ->callback->setJsonCode(4000 ,'此管家不存在');
		}
		if ($expert['status'] != 2)
		{
			$this ->callback ->setJsonCode(4000 ,'此管家状态不符合');
		}
		
		$time = date('Y-m-d H:i:s' ,time());
		$platformArr = array(
				'refuse_type' =>1,
				'userid' =>$id,
				'freeze_days' =>-1,
				'admin_id' =>$this->admin_id,
				'reason' =>$reason,
				'addtime' =>$time,
				'status' =>0
		);
		
		$this->db->trans_begin(); //事务开始
		//写入黑名单表
		$this ->db ->insert('u_platform_refuse' ,$platformArr);
		
		//更改专家表状态
		$dataArr = array(
				'status' =>-1,
				'modtime' =>$time
		);
		$this ->expert_model ->update($dataArr ,array('id' =>$id));
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			$this->db->trans_commit();
			
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			
			$this ->log(5,3,'管家管理','平台终止与管家合作，管家ID：'.$id);
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::expert_stop_msg));
			if (!empty($smsData['msg']) && !empty($expert['mobile']))
			{
				$msg = str_replace('{#REASON#}',$reason,$smsData['msg']);
				$this ->send_message($expert['mobile'] ,$msg);
			}
		}
	}
	// 恢复与管家合作
	public function recovery() {
		$id = intval($this ->input ->post('id'));
		$expertData = $this ->expert_model ->row(array('id' =>$id) ,'arr' ,'' ,'status,mobile,email');
		if (empty($expertData))
		{
			$this ->callback->setJsonCode(4000 ,'此管家不存在');
		}
		if ($expertData['status'] != -1)
		{
			$this ->callback ->setJsonCode(4000 ,'此管家不在终止合作中');
		}
		//判断手机号是否存在，除去自己
		if (!empty($expertData['mobile']))
		{
			$mobileExpert = $this ->expert_model ->getMobileUniqueNo($expertData['mobile'] ,$id);
			//var_dump($mobileExpert);
			if (!empty($mobileExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'手机号已存在，不可通过');
			}
		}
		if (!empty($expertData['email']))
		{
			//验证邮箱
			$emailExpert = $this ->expert_model ->getEmailUniqueNo($expertData['email'] ,$id);
			if (!empty($emailExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'邮箱号已存在，不可通过');
			}
		}		
		
		$expertArr = array(
			'status' =>2,
			'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->expert_model ->update($expertArr ,array('id' =>$id));
		//echo  $this ->db ->last_query();exit;
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3,3,'管家管理','平台恢复与管家合作，管家ID：'.$id);
			//发送短信
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::expert_back));
			if (!empty($smsData['msg']) && !empty($expertData['mobile']))
			{
				$this ->send_message($expertData['mobile'] ,$smsData['msg']);
			}
		}
	}
	// 恢复与管家合作： 拒绝情况下的回复管家
	public function back() {
		$id = intval($this ->input ->post('id'));
		$expertData = $this ->expert_model ->row(array('id' =>$id) ,'arr' ,'' ,'status,mobile,email');
		if (empty($expertData))
		{
			$this ->callback->setJsonCode(4000 ,'此管家不存在');
		}
		if ($expertData['status'] != 3)
		{
			$this ->callback ->setJsonCode(4000 ,'此管家不在拒绝状态');
		}
		//判断手机号是否存在，除去自己
		if (!empty($expertData['mobile']))
		{
			$mobileExpert = $this ->expert_model ->getMobileUniqueNo($expertData['mobile'] ,$id);
			//var_dump($mobileExpert);
			if (!empty($mobileExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'手机号已存在，不可通过');
			}
		}
		if (!empty($expertData['email']))
		{
			//验证邮箱
			$emailExpert = $this ->expert_model ->getEmailUniqueNo($expertData['email'] ,$id);
			if (!empty($emailExpert))
			{
				$this ->callback ->setJsonCode(4000 ,'邮箱号已存在，不可通过');
			}
		}
	
		$expertArr = array(
				'status' =>2,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->expert_model ->update($expertArr ,array('id' =>$id));
		//echo  $this ->db ->last_query();exit;
		if ($status == false)
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			echo json_encode(array('code' =>2000 ,'msg' =>'操作成功'));
			$this ->log(3,3,'管家管理','平台恢复与管家合作，管家ID：'.$id);
			//发送短信
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>sys_constant::expert_back));
			if (!empty($smsData['msg']) && !empty($expertData['mobile']))
			{
				$this ->send_message($expertData['mobile'] ,$smsData['msg']);
			}
		}
	}
	public function getDestData()
	{
		$destArr = array();
		
		$destData = $this ->dest_base_model ->all(array('level <=' =>2) ,'level asc');
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				if ($val['level'] == 1)
				{
					$destArr[$val['id']] = $val;
				}
				elseif ($val['level'] == 2)
				{
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][] = $val;
					}
				}
			}
		}
		return $destArr;
	}
	
	//修改擅长目的地
	public function update_dest()
	{
		$id = intval($this ->input ->post('id'));
		$destid = trim($this ->input ->post('destid' ,true) ,',');
		if (empty($destid))
		{
			$this ->callback ->setJsonCode(4000 ,'请选择擅长线路');
		}
		$dataArr = array(
				'expert_dest' =>$destid,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->expert_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//修改个人描述
	public function update_talk()
	{
		$id = intval($this ->input ->post('id'));
		$talk = trim($this ->input ->post('talk' ,true));
		if (empty($talk))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写个人描述');
		}
		$dataArr = array(
				'talk' =>$talk,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		$status = $this ->expert_model ->update($dataArr ,array('id' =>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//管家资料不全，发起资料修改
	public function edit_info()
	{
		$id = intval($this ->input ->post('id'));
		$reason = trim($this ->input ->post('reason' ,true));
		if (empty($reason))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写原因');
		}
		$expertData = $this ->expert_model ->row(array('id' =>$id));
		if (empty($expertData))
		{
			$this ->callback ->setJsonCode(4000 ,'管家数据有误');
		}
		
		$status = $this ->expert_model ->editInfo($id ,$reason);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			//发送短息
			$this ->load_model('common/u_sms_template_model','template_model');
			$smsData = $this ->template_model ->row(array('msgtype' =>'expert_change_data'));
			if (!empty($smsData['msg']) && !empty($expertData['mobile']))
			{
				$msg = str_replace('{#EXPERTNAME#}', $expertData['realname'] , $smsData['msg']);
				$msg = str_replace('{#REASON#}', $reason , $msg);
				$this ->send_message($expertData['mobile'] ,$msg);
			}
			
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//更新管家资料
	public function edit_expert()
	{
		$postArr= $this->security->xss_clean($_POST);
		$id = intval($postArr['id']);
		$expertArr = array(
				'sex' =>intval($postArr['sex']),
				'idcard' =>trim($postArr['idcard']),
				'school' =>trim($postArr['school']),
				'working' =>trim($postArr['working']),
				'talk' =>trim($postArr['talk'])
		);
		$resumeArr = array();
		if (isset($postArr['starttime']))
		{
			foreach($postArr['starttime']  as $k=>$v)
			{
				if (empty($v) && empty($postArr['endtime'][$k]) && empty($postArr['company_name'][$k]) && empty($postArr['job'][$k]) && empty($postArr['description'][$k])) {
					continue;
				}
				$resumeArr[] = array(
						'starttime' =>$v,
						'endtime' =>$postArr['endtime'][$k],
						'company_name' =>$postArr['company_name'][$k],
						'job' =>$postArr['job'][$k],
						'description' =>$postArr['description'][$k],
						'status' =>1,
						'expert_id' =>$id
				);
			}
		}
		
		$status = $this ->expert_model ->edit_expert($id ,$expertArr ,$resumeArr);
		if ($status)
		{
			$this ->callback ->setJsonCode(2000 ,'修改成功');
		}
		else
		{
			$this ->callback ->setJsonCode(4000 ,'修改失败');
		}
	}
	
	//绑定直属供应商
	public function bind_supplier()
	{
		$id = intval($this ->input ->get('id'));
		$dataArr = array(
				'id' =>$id
		);
		$this ->view('admin/a/expert/bind_supplier' ,$dataArr);
	}
	//绑定供应商
	public function confirm_bind()
	{
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$expert_id = intval($this ->input ->post('expert_id'));
		
		//获取供应商的线路
		$whereArr = array(
				'supplier_id' =>$supplier_id,
				'status >' =>-1
		);
		$lineData = $this ->line_model ->all($whereArr ,'' ,'arr' ,'id');
		//获取管家已申请的供应商线路
		$whereArr = array(
				'la.expert_id =' =>$expert_id,
				'l.supplier_id =' =>$supplier_id
		);
		$applyData = $this ->line_apply_model ->getApplyData($whereArr);
		
		/*
		 *	绑定供应商的线路，向管家申请线路表写入记录
		 *	管家已经申请过的线路不变，但其中有特殊情况：解绑供应商将通过状态的申请记录下架(状态为4),这样的线路要改为通过状态(2)
		 */
		$insertArr = array();
		$updateArr = array();
		$idsArr = array();
		if (empty($applyData))
		{
			//管家之前没有申请过供应商的线路，则所有的线路写入申请表
			$insertArr = $lineData;
		}
		else 
		{
			//管家有申请供应商的线路
			foreach($applyData as $v)
			{
				$idsArr[] = $v['line_id'];
				if ($v['status'] == 4)
				{
					//解绑供应商的同时解绑的线路
					$updateArr[] = $v['id'];
				}
			}
		}
		
		if (!empty($idsArr))
		{
			//过滤掉已经申请的线路
			foreach($lineData as $v)
			{
				if (array_search($v['id'], $idsArr) === false)
				{
					$insertArr[] = $v;
				}
			}
		}
		
		
		$dataArr = array(
				'supplier_id' =>$supplier_id
		);
		
		$status = $this ->expert_model ->bindSupplier($expert_id ,$supplier_id ,$insertArr ,$updateArr);
		
		if ($status == false) 
		{
			$this ->callback ->setJsonCode(4000 ,'绑定失败');
		}
		else 
		{
			$this ->callback ->setJsonCode(2000 ,'绑定成功');
		}
	}
	
	//解除与供应商的绑定
	public function relieve_bind()
	{
		$expert_id = intval($this ->input ->post('id'));
		
		$expertData = $this ->expert_model ->row(array('id' =>$expert_id));
		if (empty($expertData))
		{
			$this ->callback ->setJsonCode(4000 ,'管家不存在');
		}
		
		//获取管家已申请的供应商线路
		$whereArr = array(
				'la.expert_id =' =>$expert_id,
				'l.supplier_id =' =>$expertData['supplier_id'],
				'la.status =' =>2
		);
		$applyData = $this ->line_apply_model ->getApplyData($whereArr);
		$ids = '';
		foreach($applyData as $v)
		{
			$ids .= $v['id'].',';
		}
		
		//解绑供应商的同时解绑供应商的线路
		$status = $this ->expert_model ->relieveSupplier($expert_id ,rtrim($ids ,','));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'解除失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'解除成功');
		}
	}
	
	//在C端隐藏管家
	public function hidden_expert()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->expert_model ->update(array('is_commit'=>0) ,array('id'=>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	//在C端显示管家
	public function show_expert()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->expert_model ->update(array('is_commit'=>1) ,array('id'=>$id));
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//进入管家资料修改页面
	public function edit_view()
	{
		$id = intval($this ->input ->get('id'));
		$expertData = $this ->expert_model ->row(array('id' =>$id));
		if (!empty($expertData))
		{
			//获取从业经历
			$this ->load_model('common/u_expert_resume_model' ,'resume_model');
			$resumeData = $this ->resume_model ->all(array('expert_id' =>$id,'status' =>1));
			$dataArr = array(
					'expert' =>$expertData,
					'resume' =>$resumeData
			);
			$this ->view('admin/a/expert/edit_expert' ,$dataArr);
		}
	}
}