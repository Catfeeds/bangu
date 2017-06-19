<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 	2016-03-15
 * @author jiakairong
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Line extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load->model ( 'line_model');
		$this->load->model ( 'admin/b1/user_shop_model' );
	}
	public function index()
	{
		$this ->load_model('admin/a/admin_model' ,'admin_model');
		$data['admin'] = $this ->admin_model ->all(array(),'' ,'arr', 'id,realname');
		//t33 系统管理员
		$data['union'] =$this ->admin_model ->get_employee();
		
		$this->view ( 'admin/a/line/line' ,$data);
	}
	public function getLineData()
	{
		$data = $this ->getCommonData();
		echo json_encode($data);
	}
	
	//导出excel
	public function exportExcel()
	{
		$lineData = $this ->getCommonData(0);
		
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
		$objActSheet->setCellValue ( "A1", '产品编号' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 50 );
		$objActSheet->setCellValue ( "B1", '产品标题' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "C1", '出发地' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "D1", '上线时间' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "E1", '更新时间' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 15 );
		$objActSheet->setCellValue ( "F1", '录入人' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'G' )->setWidth ( 35 );
		$objActSheet->setCellValue ( "G1", '供应商' );
		$objActSheet->getStyle ( 'G1' )->applyFromArray ($style_array);

		$i=0;
		foreach ( $lineData as $key => $val )
		{
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $val['linecode'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $val['linename'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), $val['cityname'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $val['online_time'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $val['modtime'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $val['linkman'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
			$objActSheet->setCellValueExplicit ( 'G' . ($i + 2), $val['company_name'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'G' . ($i + 2) )->applyFromArray ($one_style_array);
			
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
	
	public function getCommonData($type=1)
	{
		$whereArr = array();
		$specialSql = ''; //特殊语句sql
		$status = intval($this ->input ->post('status')); //线路状态
		$linecode = trim($this ->input ->post('code' ,true)); //产品编号
		$linename = trim($this ->input ->post('linename' ,true)); //产品名称
		$company_name = trim($this ->input ->post('supplier' ,true)); //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));
		$admin_id = rtrim($this ->input ->post('admin_id') ,',');
		$startcity = trim($this ->input ->post('startcity' ,true));
		$startcity_id = intval($this ->input ->post('startcity_id'));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$overcity = intval($this ->input ->post('destid'));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$stime = trim($this ->input ->post('stime' ,true));
		$etime = trim($this ->input ->post('etime' ,true));
		$admin_name=trim($this ->input ->post('admin_name' ,true));
		$whereArr['l.status ='] = $status;
		$whereArr['l.line_kind ='] = 1;
		$orderBy = 'l.modtime desc';
		switch($status)
		{
			case 2:
				$orderBy = 'l.confirm_time desc';
				$whereArr['l.status ='] = $status;
				break;
			case 3:
			case 1:
				$whereArr['l.status ='] = $status;
				break;
			case 4:
				$whereArr['l.status ='] = $status;
				$whereArr['l.line_status ='] = 1;
				break;
			case 5:
				$whereArr['l.status ='] = 4;
				$whereArr['l.line_status ='] = 0;
				break;
			default:
				echo json_encode($this ->defaultArr);
				exit;
				break;
		}
		if (!empty($linecode))
		{
			$whereArr['l.linecode ='] = $linecode;
		}
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
		//出发城市
		if (!empty($startcity_id) || $startcity)
		{
			$dataArr = $this ->get_startcity_sd($startcity_id ,$startcity);
			if (!empty($dataArr['ids']) && !empty($dataArr['pids']))
			{
				$specialSql .= ' (sp.id in ('.$dataArr['ids'].') or sp.pid in ('.$dataArr['pids'].')) and';
			}
			elseif (!empty($dataArr['pids']))
			{
				$specialSql .= ' sp.pid in ('.$dataArr['pids'].') and';
			}
			elseif(!empty($dataArr['ids']))
			{
				$specialSql .= ' sp.id in ('.$dataArr['ids'].') and';
			}
		}
         		
		//目的地
		if (!empty($overcity))
		{ 
			$specialSql .= ' find_in_set('.$overcity.' ,l.overcity) and';
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
				$specialSql = ' (';
				foreach($destData as $v)
				{
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') and';
			}
		}
		if (!empty($starttime))
		{
			$whereArr['l.online_time >='] = $starttime;
		}
		if (!empty($endtime))
		{
			$whereArr['l.online_time <='] = $endtime.' 23:59:59';
		}
		if ($status == 2)
		{
			if (!empty($stime))
			{
				$whereArr['l.confirm_time >='] = $stime;
			}
			if (!empty($etime))
			{
				$whereArr['l.confirm_time <='] = $etime.' 23:59:59';
			}
		}
		else 
		{
			if (!empty($stime))
			{
				$whereArr['l.modtime >='] = $stime;
			}
			if (!empty($etime))
			{
				$whereArr['l.modtime <='] = $etime.' 23:59:59';
			}
		}
		
		/* if (!empty($admin_id))
		{
			$specialSql .= ' l.admin_id in ('.$admin_id.') and';
		} */
		if(!empty($admin_name)){
			//(case  when a=1 then a when 表.字段='asdfasdf' then b end)
			$specialSql= "(case  when a.id>0 then a.realname like '%{$admin_name}%' when b.employee_name is NOT NULL then b.employee_name like '%{$admin_name}%' end)";
		}
		if ($type == 1)
		{
			$data = $this->line_model->getALineData ( $whereArr ,rtrim($specialSql,'and') ,false ,$orderBy);
			
			return $data;
		}
		else 
		{
			return $this->line_model->getALineData ( $whereArr ,$specialSql ,'all');
		}
	}
	
	//线路退回
	public function refuse()
	{
		$id = intval($this->input->post ( 'lineid' ));
		$refuse_remark = trim($this->input->post ( 'refuse_remark', true ));
		if (empty ( $refuse_remark ))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写退回原因');
		}
		
		$lineData = $this ->line_model ->row(array('id' =>$id));
		if (empty( $lineData ) || $lineData['status'] != 1)
		{
			$this->callback->setJsonCode ( 4000 ,'线路不存在或线路尚未进入审核中的流程');
		}
		$data = array(
				'status' => 3, 
				'refuse_remark' => $refuse_remark,
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'admin_id' =>$this ->admin_id
		);
		$status = $this ->line_model ->update($data ,array('id' =>$id));
		if (!empty ( $status ))
		{
			$this ->log(5,3,'平台线路管理','平台退回线路申请,记录ID:'.$id);
			$this->add_message ( '平台已拒绝您的线路审核,线路名称：'.$lineData['linename'], 2, $lineData['supplier_id'] ,'平台拒绝线路上线');
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
		else
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
	}
	//审核通过
	public function through()
	{
		$id = intval($this->input->post ( 'lineid'));

		$lineData = $this ->line_model ->row(array('id' =>$id));
		if (empty ( $lineData ) || $lineData['status'] != 1)
		{
			$this->callback->setJsonCode ( 4000 ,'线路不存在或不在审核状态');
		}
		//获取线路套餐
		$this->load->model ( 'admin/a/line_suit_model', 'suit_model' );
		$suitData = $this ->suit_model ->row(array('lineid' =>$id));
		if (empty($suitData))
		{
			$this->callback->setJsonCode ( 4000 ,'此线路没有套餐，不可通过');
		}
		$time = date('Y-m-d H:i:s' ,time());
		//更改线路
		$dataArr = array(
			'status' => 2,
			'modtime' =>$time,
			'confirm_time' =>$time,
			'admin_id' =>$this ->admin_id,
			'line_status' =>1
		);
		if (empty($lineData['online_time']) || strtotime($lineData['online_time']) == false)
		{
			$dataArr['online_time'] = $dataArr['modtime'];
		}
	
		$this->db->trans_start();
		
		$this->load->model ( 'admin/t33/b_company_supplier_model', 'company_supplier_model');
		$this->load->model('admin/t33/u_line_model','approve_line');
		
		//帮游线路通过
		$status = $this ->line_model ->update($dataArr ,array('id' =>$id));
		
        //---------------判断该线路是否是t33供应商------------------------@xml
/*         if($lineData['producttype']==0){  
			$com_supplier=$this->company_supplier_model->result(array('supplier_id'=>$lineData['supplier_id']));
			if(!empty($com_supplier)){
				foreach ($com_supplier as $k=>$v){
					if($v['status']==1){
					    $Appline=$this ->line_model ->select_rowData('b_union_approve_line',array('line_id'=>$id,'supplier_id'=>$lineData['supplier_id'],'union_id'=>$v['union_id']));
						if(empty($Appline)){  
							$ApplineArr=array(
								'union_id'=>$v['union_id'],
								'supplier_id'=>$lineData['supplier_id'],
								'line_id'=>$id,
								'status'=>2,
								'addtime'=>date("Y-m-d H:i:s",time()),
								'modtime'=>date("Y-m-d H:i:s",time()),
								'employee_name'=>$this->realname
							);
							$this->line_model->insert_data('b_union_approve_line',$ApplineArr);  
						}else{
							$status=$this->approve_line->approve_ok(array('status'=>'2','modtime'=>date("Y-m-d H:i:s"),'employee_name'=>$this->realname),array('line_id'=>$id,'union_id'=>$v['union_id']));
						}   
					}
				}
			}
        } */	
        	
		$this->db->trans_complete();
	    $re=$this->db->trans_status();
	    
	    if(!$re){
	    	$this->callback->setJsonCode ( 4000 ,'操作失败');
	    }
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
		else
		{
			
			$this->add_message ( '平台已通过您的线路审核,线路名称：'.$lineData['linename'], 2, $lineData['supplier_id'] ,'平台通过线路审核');
			$this ->log(5,3,'平台线路管理','平台通过线路申请,记录ID:'.$id);
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
	}
	//线路审核人
	function get_admin_user(){
		$this ->load_model('admin/a/admin_model' ,'admin_model');
		//帮游审核人
		$data['admin'] = $this ->admin_model ->all(array(),'' ,'arr', 'id,realname');
		
		//t33 系统管理员
		$data['union'] =$this ->admin_model ->get_employee();
	
		$type=$this->input->get('type',true);
		if($type==1){
			$result=array_merge($data['union'],$data['admin']);
		}else{
			$result=$data['union'];
		}
	
		echo json_encode($result);

	}
	/**
	 * @method 下线线路
	 * @author jiakairong
	 */
	public function disable()
	{
		$id = intval($this->input->post ( 'lineid'));
		$reason = trim($this ->input ->post('reason' ,true));
		if (empty($reason))
		{
			$this->callback->setJsonCode ( 4000 ,'请填写下线理由');
		}
		$lineData = $this ->line_model ->row(array('id' =>$id));
		if (empty ( $lineData ) || $lineData['status'] != 2)
		{
			$this->callback->setJsonCode ( 4000 ,'线路不存在或不在上线状态');
		}
		$this->db->trans_start();
		//帮游线路,如该供应商同是t33供应商.同步下线
		$dataArr = array(
				'status' =>4,
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'admin_id' =>$this ->admin_id,
				'refuse_remark' =>$reason,
				'line_status' =>1
		);
	    $this ->line_model ->update($dataArr ,array('id' =>$id));
		
		//t33线路
	/* 	if($lineData['producttype']==0){ 
			$this->load->model('admin/t33/sys/b_union_approve_line_model','b_union_approve_line_model');
			$re=$this->b_union_approve_line_model->update(array('status'=>3,'modtime'=>date("Y-m-d H:i:s"),'employee_name'=>$this->realname),array('line_id'=>$id));
		} */
		
		$this->db->trans_complete();
		$re=$this->db->trans_status(); 
		
		if ($re)
		{
			$this->cache->redis->delete('SYhomeLineRanking');
			$this->cache->redis->delete('SYDestLine');
			$this->add_message ( '平台已下线您的线路,线路名称:'.$lineData['linename'], 2, $lineData['supplier_id'] ,'平台下线线路');
			$this ->log(2,3,'平台线路管理->线路审核','平台下线线路,记录ID:'.$id);
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
		else
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
	}
	/**
	 * @method 停售线路
	 * @author jiakairong
	 */
	public function stopsale()
	{
		$id = intval($this->input->post ( 'lineid'));
// 		$reason = trim($this ->input ->post('reason' ,true));
// 		if (empty($reason))
// 		{
// 			$this->callback->setJsonCode ( 4000 ,'请填写下线理由');
// 		}
		$lineData = $this ->line_model ->row(array('id' =>$id));
		if (empty ( $lineData ) || $lineData['status'] != 4)
		{
			$this->callback->setJsonCode ( 4000 ,'线路不存在或不在下线状态');
		}
		$dataArr = array(
				'modtime' =>date('Y-m-d H:i:s' ,time()),
				'admin_id' =>$this ->admin_id,
				'line_status' =>0
				//'online_time' =>null
		);
		$status = $this ->line_model ->update($dataArr ,array('id' =>$id));
		if (!empty ( $status ))
		{
			$this->add_message ( '平台已停售您的线路,线路名称:'.$lineData['linename'], 2, $lineData['supplier_id'] ,'平台停售线路');
			$this ->log(2,3,'线路管理','平台停售线路,记录ID:'.$id);
			$this->callback->setJsonCode ( 2000 ,'操作成功');
		}
		else
		{
			$this->callback->setJsonCode ( 4000 ,'操作失败');
		}
	}
	//线路行程
	public function trip()
	{
	
		$line_id=$this->input->get("id",true);
		$suit_id=$this->input->get("suit_id",true);
		$usedate=$this->input->get("usedate",true);
		
		$this->load->model ( 'admin/t33/sys/u_line_suit_price_model', 'u_line_suit_price_model' );
		$data['suit']=$this->u_line_suit_price_model->row(array('day'=>$usedate,'suitid'=>$suit_id));
		
		$this->load->model('admin/t33/u_line_model','u_line_model');
		$return = $this ->u_line_model ->line_trip($line_id);
		
		$data['list'] = $return['result'];
		$union_id=$this->session->userdata('union_id');
		$expert_id=$this->session->userdata('expert_id');
		
		$this->load->model('admin/t33/sys/b_union_log_model','b_union_log_model');
		$data['logo']=$this->b_union_log_model->row(array('union_id'=>$union_id));
		$data['expert_id']=$expert_id;
		$data['dayid']=$data['suit']['dayid'];
		$data['line']['data']=$this->u_line_model->row(array('id'=>$line_id));
	
		$this->load->view("admin/t33/line/trip",$data);
	}
	
	//评论
	public function insertComment()
	{
		$this ->load_model('line_model');
		$content = trim($this ->input ->post('content' ,true));
		$score1 = intval($this ->input ->post('score1'));
		$score2 = intval($this ->input ->post('score2'));
		$score3 = intval($this ->input ->post('score3'));
		$score4 = intval($this ->input ->post('score4'));
		$lineId = intval($this ->input ->post('lineId'));
		$imgArr = $this ->input ->post('img');
		if (empty($content))
		{
			$this ->callback ->setJsonCode(4000 ,'请填写评论内容');
		}
		$pictures = '';
		if (!empty($imgArr))
		{
			$pictures = implode(',', $imgArr);
		}
		
		$lineData = $this ->line_model ->getLineStartplace($lineId);
		if (empty($lineData))
		{
			$this ->callback ->setJsonCode(4000 ,'线路不存在');
		}
		$starcityid = '';
		foreach($lineData as $v)
		{
			$starcityid .= $v['startplace_id'].',';
		}
		$commentArr = array(
				'line_id' =>$lineId,
				'channel' =>2,
				'isshow' =>1,
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'haspic' =>empty($imgArr) ? 0 : 1,
				'content' =>$content,
				'pictures' =>$pictures,
				'score1' =>$score1,
				'score2' =>$score2,
				'score3' =>$score3,
				'score4' =>$score4,
				'avgscore1' =>round(($score1+$score2+$score3+$score4) /4 ,1),
				'isanonymous' =>1,
				'starcityid' =>rtrim($starcityid ,',')
		);
		//var_dump($commentArr);exit;
		$status = $this ->db ->insert('u_comment' ,$commentArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'评论失败');
		}
		else
		{
			$this->cache->redis->delete('SYhomeComment');
			$this ->log(1, 3, '线路管理','添加评论');
			$this ->callback ->setJsonCode(2000 ,'评论成功');
		}
	}
	
	public function detail()
	{
		$this->load->model ( 'admin/b1/user_shop_model' );
		$lineId= $this->get('id');
		$type=$this->get('type');
		//$supplier = $this->getLoginSupplier();
		
		//获取线路的信息
		$data['data'] = $this->user_shop_model->get_user_shop_byid($lineId);
		
		//获取线路的出发地
		$citystr='';
		$cityArr=$this->user_shop_model->select_startplace(array('ls.line_id'=>$lineId));
		foreach ($cityArr as $k=>$v){
			if(!empty($v['startplace_id'])){
				$citystr=$citystr.$v['startplace_id'].',';
			}
		}
		$data['cityArr']=$cityArr;
		$data['citystr']=$citystr;
		
		//获取套餐的信息
		$data['suits'] =$this->user_shop_model->getLineSuit($lineId);
		
		//去掉复制的标识
		$linename=str_replace("— 复制","",$data['data']['linename']);
		$this->user_shop_model->update_rowdata('u_line',array('linename'=>$linename),array('id'=>$lineId));
		
		//获取线路的出发地
		$data['startcity']='';
		if($data['data']['startcity']>0){
			$startcity = $this->user_shop_model->get_user_shop_select ('u_startplace' ,array('id'=>$data['data']['startcity']));
			$data['startcity']=$startcity[0];
		}
		//获取线路的目的地
		$data['overcity2_arr'] = array();
		if(""!=$data['data']['overcity2']){
			$data['overcity2_arr'] = $this->user_shop_model->getDestinationsId(explode(",",$data['data']['overcity2']));
		}
		
		//线路的标签
		$data['line_attr_arr'] = array();
		if(""!=$data['data']['linetype']){
			$this->load_model ( 'admin/a/lineattr_model', 'lineattr_model' );
			$data['line_attr_arr'] = $this->lineattr_model->getLineattr(explode(",",$data['data']['linetype']));
		}
		
		//线路图片
		$data['imgurl']=$this->user_shop_model->select_imgdata($lineId);
		if(!empty($data['imgurl'])){
			$data['imgurl_str']='';
			foreach ($data['imgurl'] as $k=>$v){
				$data['imgurl_str']=$data['imgurl_str'].$v['filepath'].',';
			}
		}
		
		//线路属性
		$data['attr']='';
		$attr=$this->user_shop_model->select_attr_data(array('pid'=>0,'isopen'=>1));
		if(!empty($attr)){
			foreach ($attr as $k=>$v){ //二级
				$attr[$k]['str']='';
				$attr[$k]['two']=$this->user_shop_model->select_attr_data(array('pid'=>$v['id'],'isopen'=>1));
				foreach ($attr[$k]['two'] as $key=>$val){
					$attr[$k]['str'].=$val['id'].',';
				}
			}
			$data['attr']=$attr;
		}
		//行程安排
		$data['rout']=$this->user_shop_model->getLineRout($lineId);
		//echo $this->db->last_query();
		//供应商信息
		$data['supplier']=$this->user_shop_model->get_user_shop_select('u_supplier',array('id'=>$data['data']['supplier_id']));
		//管家培训
		$data['train']=$this->user_shop_model->get_user_shop_select('u_expert_train',array('line_id'=>$lineId,'status'=>1));
		//选保险
		$data['insurance_id']=$this->user_shop_model->get_user_shop_select('u_line_insurance',array('line_id'=>$lineId,'status'=>1));
		$data['insurance']=$this->user_shop_model->sel_line_insurance($lineId,array('supplier_id'=>$data['data']['supplier_id'],'status'=>1));
		
		//主题游
		$data['theme']=$this->user_shop_model->get_user_shop_select('u_theme','');
		if(!empty($data['theme'])){
			$data['themeData']='';
			foreach ($data['theme'] as $k=>$v){
				if(empty($data['themeData'])){
					$data['themeData']=$v['id'];
				}else{
					$data['themeData'].=','.$v['id'];
				}
			}
		}
		$data['themeid']='';
		if(!empty($data['data']['themeid'])){   //被选中的主题游
			$data['themeid']=$this->user_shop_model->get_user_shop_select('u_theme',array('id'=>$data['data']['themeid']));
		}
		
		//礼品管理
// 		$data['gift']=$this->user_shop_model->get_gift_data($lineId);
// 		$this->load->model ( 'admin/b1/gift_manage_model','gift_manage' );
// 		$where=' and ( g.status=0 or g.status=1)  ';
// 		$data['pageData1'] = $this->gift_manage->get_gift_list( array('linelistID'=>$lineId),$where,$this->getPage () );
		
		//线路类型
		$line_overcity=explode(',', $data['data']['overcity']);
		if(in_array("1", $line_overcity)){
			$data['line_type']=1;
		}else{
			$data['line_type']=2;
		}
		
		//默认前六张的图库
		$data['dest_two']=$this->user_shop_model->get_dest_pic($data['data']['supplier_id']);
		
		//线路景点
		$data['spot']=$this->user_shop_model->select_line_spot($lineId);
		$data['spotid']='';
		if(!empty($data['spot'])){
			foreach ($data['spot'] as $key => $value) {
				if($data['spotid']==''){
					$data['spotid']=$value['spot_id'];
				}else{
					$data['spotid'].=$data['spotid'].','.$value['spot_id'];
				}
			}
		}
		//线路押金,团款
		$data['line_aff']=$this->user_shop_model->select_rowData('u_line_affiliated',array('line_id'=>$lineId));
		
		//上车地点
   		$data['carAddress']=$this->user_shop_model->select_data('u_line_on_car',array('line_id'=>$lineId));
   		
		//附件
		$data['protocol']=$this->user_shop_model->select_data('u_line_protocol',array('line_id'=>$lineId));
		$data['type']=$type;
		$data['line']=$data;
		$this->load->view ( 'admin/a/line/line_detail' ,$data);
	}
	
	//日历价格
	public function getProductPriceJSON(){
		$lineId = $this->get("lineId");
		// 		$suitId = $this->get("suitId");
		// 		$startDate = $this->get("startDate");
		$productPrice = "[]";
		if(null!=$lineId && ""!=$lineId){
			$productPrice = $this->user_shop_model->getProductPriceByProductId($lineId);
		}
		//echo $this->db->last_query();
		echo $productPrice;
	}
	
	//修改收藏虚拟值
	public function vr_num()
	{
		$id = intval($this ->input ->post('id'));
		$vr_num = intval($this ->input ->post('vr_num'));
		if ($vr_num < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写虚拟值');
		}
		$status = $this ->line_model ->vrNum($id ,$vr_num);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
}