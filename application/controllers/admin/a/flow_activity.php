<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @since 2015年5月24日10:19:53
 * @author xml    
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Flow_activity extends UA_Controller
{	
	const pagesize = 10; //分页的页数	
	public function __construct()
	{
		parent::__construct ();	
	}
	
	/**
	 * @method 流量活动游侠列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function index($page=1)
	{
		$starttime = $this ->input ->get('starttime' ,true);
		$endtime = $this ->input ->get('endtime' ,true);		
		$status = $this ->input ->get('status' ,true);		
		$param = array();
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;		
		if($this ->input ->get('page' ,true)){
			$page = $this ->input ->get('page' ,true);
		}			
		$urldata = array();	
		parse_str($_SERVER['QUERY_STRING'],$urldata);
		unset($urldata['page']);
		$urlstr ='?';
		foreach($urldata as $k => $v){
			$urlstr .=$k.'='.$v.'&';
		}		
		
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/flow_activity/index/'.$urlstr.'&page=';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' wm.utype=1 ';
		if(!empty($param['starttime'])){
			$where_sql.=' AND  wm.addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  wm.addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}
		$where_sql1= '';
		$status =1;
		if($status>=0){
			$where_sql.=' AND  wm.status="'.$status.'" ';
			$where_sql1=' status="'.$status.'" ';			
		}		
        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(wm.id) as total from wx_flow_activity_member as wm left join u_member as u on(wm.member_id=u.mid) where ".$where_sql;		
		$query_sql1=" select wm.*,u.loginname,u.mobile from wx_flow_activity_member as wm left join u_member as u on(wm.member_id=u.mid)  where ".$where_sql." ORDER BY  wm.addtime desc LIMIT {$from},{$page_size}";
		
		$t = $this ->db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this ->db ->query($query_sql1) ->result_array();		
		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$member_ids = array();
		foreach($wx_flow_activity_member_data as $v){
			$member_ids[$v['member_id']] = $v['member_id'];
		}
		$pep_all = array();
		if(!empty($member_ids)){
			$query_sql=" select count(id) as num,member_id from wx_flow_activity_rec where `status`=1 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array as $v){
				$pep_all[$v['member_id']] = $v['num'];
			}
		}
		$query_sql=" select sum(money) as total from wx_flow_activity_member  where utype=1 and status=1 ";		
		$money_total = $this ->db ->query($query_sql) ->row_array();		
		$money_total = $money_total['total'];		
		
		$query_sql=" select count(id) as total from wx_flow_activity_member  where utype=1 and status=1 ";		
		$num_total = $this ->db ->query($query_sql) ->row_array();		
		$num_total = $num_total['total'];		
		
		$data['num_total'] = $num_total;
		$data['money_total'] = $money_total;
		$data['status'] = $status;		
		$data['pep_all'] = $pep_all;
		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/flow_activity/index_list',$data);
	}	
	
	/**
	 * @method 流量活动游侠列表
	 * @author xml
	 * @since  2016-5-24 
	 */
	public function liu_list($page=1)
	{
		$starttime = $this ->input ->get('starttime' ,true);
		$endtime = $this ->input ->get('endtime' ,true);		
		$status = $this ->input ->get('status' ,true);
		if($this ->input ->get('page' ,true)){
			$page = $this ->input ->get('page' ,true);
		}	
		$param = array();
		$param['starttime'] = $starttime;
		$param['endtime'] = $endtime;
		$urldata = array();	
		parse_str($_SERVER['QUERY_STRING'],$urldata);
		unset($urldata['page']);
		$urlstr ='?';
		foreach($urldata as $k => $v){
			$urlstr .=$k.'='.$v.'&';
		}
		$data = array();
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/flow_activity/liu_list/'.$urlstr.'&page=';
		$config ['pagesize'] = self::pagesize;
		$config ['page_now'] = $page;		
	
		$where_sql = ' wm.utype=0 ';
		if(!empty($param['starttime'])){
			$where_sql.=' AND  wm.addtime >="'.strtotime(trim($param['starttime']).' 00:00:00').'" ';
		}
		if(!empty($param['endtime'])){
			$where_sql.=' AND  wm.addtime <="'.strtotime(trim($param['endtime']).' 23:59:59').'" ';
		}
		$status =1;
		if($status>=0){
			$where_sql.=' AND  wm.status="'.$status.'" ';
		}		
        $page_size = self::pagesize;  //每页显示记录数
        $from = ($page - 1) * $page_size; //from	
		
		$query_sql2=" select count(wm.id) as total from wx_flow_activity_member as wm left join u_member as u on(wm.member_id=u.mid) where ".$where_sql;		
		$query_sql1=" select wm.*,u.loginname,u.mobile from wx_flow_activity_member as wm left join u_member as u on(wm.member_id=u.mid)  where ".$where_sql." ORDER BY  wm.addtime desc LIMIT {$from},{$page_size}";
		
		$t = $this ->db ->query($query_sql2) ->row_array();
		$total = $t['total'];				
		$wx_flow_activity_member_data = $this ->db ->query($query_sql1) ->result_array();
		$telphone = array();
		
		$member_ids = array();
		foreach($wx_flow_activity_member_data as $k=>$v){
			$member_ids[$v['member_id']] = $v['member_id'];
			if(preg_match('/^1([0-9]{9})/',$v['mobile'])){
				$tm3 = substr($v['mobile'],0,3);
				$tm4 = intval(substr($v['mobile'],0,4));
				$strd1 = array(135,136,137,138,139,150,151,152,157,158,159,182,183,184,187,188,147,178);//移动手机号码：1340-1348,135,136,137,138,139,150,151,152,157,158,159,182,183,184,187,188,147,178
				$strd2 = array(130,131,132,155,156,145,185,186,176,175);//联通手机号码：130、131、132、152、155、156、185、186 
				$strd3 = array(133,153,180,181,189,177,173,149);//电信手机号码：133、153、180、189、（1349卫通）
				if($tm4 == 1349){
					$wx_flow_activity_member_data[$k]['company'] = '电信卫通';
				}else if($tm4>=1340 && $tm4<= 1348 ){
					$wx_flow_activity_member_data[$k]['company'] = '移动';					
				}else{
					if(in_array($tm3,$strd1)){
						$wx_flow_activity_member_data[$k]['company'] = '移动';
					}else if(in_array($tm3,$strd2)){
						$wx_flow_activity_member_data[$k]['company'] = '联通';						
					}else if(in_array($tm3,$strd3)){	
						$wx_flow_activity_member_data[$k]['company'] = '电信';					
					}else{
						$wx_flow_activity_member_data[$k]['company'] = '未知';
					}
				}	
			}else{
				$wx_flow_activity_member_data[$k]['company'] = '未知';
				
			}
		}

		$config ['pagecount'] = $total;
		$data['pageData']= $wx_flow_activity_member_data;

		$pep_all = array();
		if(!empty($member_ids)){
			$query_sql=" select count(id) as num,member_id from wx_flow_activity_rec where `status`=1 and member_id in(".implode(",",$member_ids).") GROUP BY member_id ";		
			$pep_array = $this ->db ->query($query_sql) ->result_array();
			foreach($pep_array as $v){
				$pep_all[$v['member_id']] = $v['num'];
			}
		}		
		
		
		$query_sql=" select sum(flownums) as total from wx_flow_activity_member  where utype=0 and status=1 ";		
		$flownums_total = $this ->db ->query($query_sql) ->row_array();		
		$flownums_total = $flownums_total['total'];

		$query_sql=" select sum(flownums) as total from wx_flow_activity_flowlog  where type=1";		
		$congzhi_total = $this ->db ->query($query_sql) ->row_array();		
		$congzhi_total = $congzhi_total['total'];		
		
		$query_sql=" select count(id) as total from wx_flow_activity_member  where utype=0 and status=1 ";		
		$num_total = $this ->db ->query($query_sql) ->row_array();		
		$num_total = $num_total['total'];
		
		$query_sql=" select count(id) as total from wx_flow_activity_member  where utype=0 ";		
		$all_num_total = $this ->db ->query($query_sql) ->row_array();		
		$all_num_total = $all_num_total['total'];		
		
		$data['starttime'] = $starttime;
		$data['endtime'] = $endtime;
		$data['status'] = $status;		
		$data['num_total'] = $num_total;
		$data['all_num_total'] = $all_num_total;	
		
		$data['flownums_total'] = $flownums_total + $congzhi_total;
		$data['congzhi_total'] = $congzhi_total;
		
		$data['pep_all'] = $pep_all;
		
		$this->page->initialize ( $config );			
		$this->load_view ( 'admin/a/flow_activity/liu_list',$data);
	}	
	
	
	/**
	 * 流量兑换
	 */
	public function congzhi() {
		$id = intval($this->input->post("id"));
		$str_sql = "select * from wx_flow_activity_member where id=".$id;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->row_array();
		if(!empty($wx_flow_activity_member_data)){
			if($wx_flow_activity_member_data['status']==1){
				if($wx_flow_activity_member_data['flownums']>=50){
					$flownums = $wx_flow_activity_member_data['flownums'];
					$time = time();
					$this->db->trans_begin();//事务

					$this->db->query("update wx_flow_activity_member set `flownums`=`flownums`-50 where id = {$id}");//减少流量	
					$data = array(
						'member_id'=>$wx_flow_activity_member_data['member_id'],									
						'flownums'=>50,
						'type' => 1,
						'info' => '流量已经兑换',
						'addtime' => $time,									
					);	
					$this->db->insert ( 'wx_flow_activity_flowlog', $data );//增加流量记录
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$this->callback->set_code ( 4000 ,"网络原因，兑换失败，请再试一下");
						$this->callback->exit_json();	
					} else {
						$this->db->trans_commit();
						$this->callback->set_code ( 2000 ,"兑换成功");
						$this->callback->exit_json();
					}					
				}else{
					$this->callback->set_code ( 4000 ,"流量不足50M，不能兑换");
					$this->callback->exit_json();		
				}				
			}else{
				$this->callback->set_code ( 4000 ,"账号没激活不能兑换");
				$this->callback->exit_json();				
			}	
		}else{
			$this->callback->set_code ( 4000 ,"参数错误");
			$this->callback->exit_json();		
		}					
	}	
	
	/**
	 * 流量兑换
	 */
	public function dakuang() {
		$id = intval($this->input->post("id"));
		$str_sql = "select * from wx_flow_activity_member where id=".$id;
		$wx_flow_activity_member_data = $this->db->query($str_sql)->row_array();
		if(!empty($wx_flow_activity_member_data)){
			if($wx_flow_activity_member_data['status']==1){
				if($wx_flow_activity_member_data['money']>0){
					$this->db->trans_begin();//事务
					$this->db->query("update wx_flow_activity_member set `retmoney`=1 where id = {$id}");//变更状态 1表示已经打款，0表示未打款	
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$this->callback->set_code ( 4000 ,"网络原因，操作失败，请再试一下");
						$this->callback->exit_json();	
					} else {
						$this->db->trans_commit();
						$this->callback->set_code ( 2000 ,"打款成功");
						$this->callback->exit_json();
					}					
				}else{
					$this->callback->set_code ( 4000 ,"金额为0，不能打款");
					$this->callback->exit_json();		
				}				
			}else{
				$this->callback->set_code ( 4000 ,"账号没激活不能兑换");
				$this->callback->exit_json();				
			}	
		}else{
			$this->callback->set_code ( 4000 ,"参数错误");
			$this->callback->exit_json();		
		}					
	}


	/**
	 * [export_excel 导出出团人为Excel]
	 */
	function export_excel(){
		$this->load->library('PHPExcel');
        		$this->load->library('PHPExcel/IOFactory');
		$post_arr = array();
		$order_id = $this->input->post('id');
		$post_arr['mo.id'] = $order_id;
		$order_people = $this->order_model->get_order_people($post_arr);

		$pid=$order_people[0]['productautoid'];	
		$reDataArr =$this->order_model->judge_around($pid);  //判断国内国外游

	        	$objPHPExcel = new PHPExcel();
	        	$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
	       	$objPHPExcel->setActiveSheetIndex(0);

	       	 $objActSheet = $objPHPExcel->getActiveSheet ();
	       	 $objActSheet->getColumnDimension('A')->setWidth(5);
	         	 $objActSheet->getColumnDimension('B')->setWidth(15);
	       	 $objActSheet->getColumnDimension('C')->setWidth(15);
	        	 $objActSheet->getColumnDimension('D')->setWidth(20);
	       	 $objActSheet->getColumnDimension('E')->setWidth(20);
	       	 $objActSheet->getColumnDimension('F')->setWidth(20);
	       	 $objActSheet->getColumnDimension('G')->setWidth(5);
	        	 $objActSheet->getColumnDimension('H')->setWidth(20);

	             $objActSheet->setCellValue("A1",'序号');
		$objActSheet->getStyle('A1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('B1', '姓名');
		$objActSheet->getStyle('B1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		$objActSheet->setCellValue('C1', '性别');
		$objActSheet->getStyle('C1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('D1', '证件类型');
		$objActSheet->getStyle('D1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER )));
		
		$objActSheet->setCellValue('E1', '证件号码');
		$objActSheet->getStyle('E1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		$objActSheet->setCellValue('F1', '出生年月');
		$objActSheet->getStyle('F1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER )));

		$objActSheet->setCellValue('G1', '手机号码');
		$objActSheet->getStyle('G1')->applyFromArray(array( 'font' => array( 'bold' => true),
			       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		if(!empty($reDataArr[0])){
			if($reDataArr[0]['inou']==1){  //境外
				$objActSheet->setCellValue('H1', '签发地');
				$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValue('I1', '签发日期');
				$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValue('J1', '有效期至');
				$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValue('K1', '英文名');
				$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					       'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			}

		}
		
		

		if(!empty($order_people)){
			$i=0;
			foreach ($order_people as $key => $value) {
				if($value['sex']==1){
					$sex='男';
				}elseif($value['sex']==-1){
					$sex='保密';
				}else{
					$sex='女';
				}
				if($value['birthday']=='0000-00-00'){
					$value['birthday']='';	
				}
			$objActSheet->setCellValueExplicit('A'.($i+2),$value['id'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('A'.($i+2))->applyFromArray(array(
			          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('B'.($i+2),$value['m_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('B'.($i+2))->applyFromArray(array(
			          'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
			$objActSheet->setCellValueExplicit('C'.($i+2), $sex,PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('C'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('D'.($i+2), $value['certificate_type'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('D'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('E'.($i+2), $value['certificate_no'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('E'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('F'.($i+2), $value['birthday'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('F'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

			$objActSheet->setCellValueExplicit('G'.($i+2), $value['telephone'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('G'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		if(!empty($reDataArr[0])){
			if($reDataArr[0]['inou']==1){  //境外

			if($value['sign_time']=='0000-00-00'){
				$value['sign_time']='';	
			}

			if($value['endtime']=='0000-00-00'){
				$value['endtime']='';	
			}

			$objActSheet->setCellValueExplicit('H'.($i+2), $value['sign_place'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

			$objActSheet->setCellValueExplicit('I'.($i+2), $value['sign_time'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

			$objActSheet->setCellValueExplicit('J'.($i+2),$value['endtime'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

			$objActSheet->setCellValueExplicit('K'.($i+2), $value['enname'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
			           'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			}
		}
			
			$i++;
			}
		}


	      	$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
	       	list($ms, $s) = explode(' ',microtime());
		$ms = sprintf("%03d",$ms*1000);
		$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
	      	$file="file/b1/uploads/".$g_session.".xlsx";
		$objWriter->save($file);
		echo json_encode($file);
	}



	
	
           
}