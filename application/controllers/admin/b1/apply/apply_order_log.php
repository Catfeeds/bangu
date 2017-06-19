<?php
/**
 * **
 * 深圳海外国际旅行社
 * 2015-3-18
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Apply_order_log extends  UB1_Controller{
	public function __construct() {
		// $this->need_login = true;
		parent::__construct ();
		$this->load->helper ( array(
				'form',
				'url'
		) );
		$this->load->helper ( 'url' );
		$this->load->database ();
		$this->load->model ( 'admin/b1/apply_order_model','apply_order');
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {

	    $pageArr=$this->getPage ();
	    $pageArr->pageSize=15; //总页数15
	      
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];
		
		$data['pageData'] = $this->apply_order->get_payable_apply_log($param,$pageArr);
		
		$data['pageData']=(array)json_decode($data['pageData']);
 		if(!empty($data['pageData']['rows'])){
		    $amount_apply=0;
		    $supplier_cost=0;
		    $balance_money=0;
		    $un_money=0;
		    $platform_fee=0;
		    $p_apply=0;
		    $n=0;
		    $un_balance=0;
		    $a_balance=0;
		    $id_in=array();
		    $a=array(); // 关联数组：每个id对应的num
		    
		    foreach ($data['pageData']['rows'] as $k=>$v){         
		        $data['pageData']['rows'][$k]->un_money=sprintf("%.2f",($v->un_money));
		        $data['pageData']['rows'][$k]->amount_apply=sprintf("%.2f",($v->amount_apply));
		        $data['pageData']['rows'][$k]->un_balance=sprintf("%.2f", ($v->un_money)-($v->ap_balance));
		        $data['pageData']['rows'][$k]->a_balance=sprintf("%.2f",($v->ap_balance)); 
		        $data['pageData']['rows'][$k]->p_apply=sprintf("%.2f",($v->p_apply));
		        $amount_apply=$amount_apply+$v->amount_apply; //申请金额总额
		        if(empty($a[$v->order_id])){  //相同订单合拼
    		            $a[$v->order_id]=1;
    		            $supplier_cost=$supplier_cost+$v->supplier_cost;
    		            $balance_money=$balance_money+$v->balance_money;
    		            $un_money=$un_money+$v->un_money;
    		            $platform_fee=$platform_fee+$v->platform_fee;
    		            $un_balance=$un_balance+$data['pageData']['rows'][$k]->un_balance;
    		            $a_balance=$a_balance+$data['pageData']['rows'][$k]->a_balance;
    		            if(empty($v->p_apply)){
    		                $v->p_apply=0;
    		            }
    		            $p_apply=$p_apply+$v->p_apply;
    		            $p_apply=sprintf("%.2f",$p_apply);
		        }
		       
		        if(empty($a[$v->order_id])){
		            $a[$v->order_id]=1;
		        }
		        
		        $n=$n+1;
		    }
		       
		    
		    //统计数量 
		  	$data['pageData']['rows'][$n] = new StdClass();
		    $data['pageData']['rows'][$n]->type=-1;
		    $data['pageData']['rows'][$n]->amount_apply=$amount_apply; 
		    $data['pageData']['rows'][$n]->supplier_cost=$supplier_cost;
		    $data['pageData']['rows'][$n]->balance_money=$balance_money;
		    $data['pageData']['rows'][$n]->un_money= sprintf("%.2f", $un_money);
		    $data['pageData']['rows'][$n]->a_balance=sprintf("%.2f",$a_balance);
		    $data['pageData']['rows'][$n]->platform_fee=$platform_fee;
		    $data['pageData']['rows'][$n]->paid='';
		    $data['pageData']['rows'][$n]->item_code='';
		    $data['pageData']['rows'][$n]->ordersn='';
		    $data['pageData']['rows'][$n]->productname='';
		    $data['pageData']['rows'][$n]->usedate='';
		    $data['pageData']['rows'][$n]->realname='';
		    $data['pageData']['rows'][$n]->u_reply='';
		    $data['pageData']['rows'][$n]->remark='';
		    $data['pageData']['rows'][$n]->p_union_name='';
		    $data['pageData']['rows'][$n]->employee_name=''; 
		    $data['pageData']['rows'][$n]->p_apply=sprintf("%.2f",$p_apply);
		    $data['pageData']['rows'][$n]->un_balance=$un_balance;

		} 
		$data['pageData']=json_encode((object)$data['pageData']);
	  	
		//echo $this->db->last_query();exit;
		$data['supplierName'] = $arr['login_realname'];
		$this->load->view ( 'admin/b1/header.html' );
		$this->load->view ( "admin/b1/apply/apply_order_log_view",$data);
		$this->load->view ( 'admin/b1/footer.html' );
	}
	//申请付款列表记录
	function indexData(){
	    $pageArr=$this->getPage ();	 
	    $pageArr->pageSize=15;
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$param['supplier_id'] = $arr['id'];

		$apply_sn=$this->input->post('apply_sn',true);
		if(!empty($apply_sn)){
			$param['apply_sn']=$apply_sn;
		}
		
		$ordersn=$this->input->post('ordersn',true);
		if(!empty($ordersn)){
			$param['ordersn']=$ordersn;
		}

		$apply_status=$this->input->post('apply_status',true);
		if(isset($apply_status)&&$apply_status>=0){
			$param['apply_status']=$apply_status;
		}
		//时间查询
		$starttime=$this->input->post('starttime',true);
		if(!empty($starttime) ){
			$param['starttime'] =$starttime;
		}
		$endtime=$this->input->post('endtime',true);
		if(!empty($endtime)){
			$param['endtime']=$endtime;
		}
		//团号
		$item_code=$this->input->post('item_code',true);
		if(!empty($item_code)){
		    $param['item_code']=$item_code;
		}
		//产品名称
		$linename=$this->input->post('linename',true);
		if(!empty($linename)){
		    $param['linename']=$linename;
		}
		//var_dump($param);
    	$data = $this->apply_order->get_payable_apply_log($param,$pageArr);
        
    	$data=(array)json_decode($data);
    	if(!empty($data['rows'])){
    	    $amount_apply=0;
    	    $supplier_cost=0;
    	    $balance_money=0;
    	    $un_money=0;
    	    $platform_fee=0;
    	    $p_apply=0;
    	    $n=0;
    	    $un_balance=0;
    	    $a_balance=0;
    	    foreach ($data['rows'] as $k=>$v){
    	        $amount_apply=$amount_apply+$v->amount_apply; //申请金额总额
    	        $data['rows'][$k]->un_money= sprintf("%.2f",($v->un_money));
    	        $data['rows'][$k]->amount_apply= sprintf("%.2f",($v->amount_apply));
    	        $data['rows'][$k]->un_balance= sprintf("%.2f",($v->un_money)-($v->ap_balance));
    	        $data['rows'][$k]->a_balance=sprintf("%.2f",($v->ap_balance));
    	        $data['rows'][$k]->p_apply=sprintf("%.2f",($v->p_apply));
    	        if(empty($a[$v->order_id])){  //相同订单合拼
    	            $a[$v->order_id]=1;
    	            $supplier_cost=$supplier_cost+$v->supplier_cost;
    	            $balance_money=$balance_money+$v->balance_money;
    	            $un_money=$un_money+$v->un_money;
    	            $platform_fee=$platform_fee+$v->platform_fee;
    	            $un_balance=$un_balance+$data['rows'][$k]->un_balance;
    	            $a_balance=$a_balance+$data['rows'][$k]->a_balance; 
    	            if(empty($v->p_apply)){
    	                $v->p_apply=0;
    	            }
    	            $p_apply=$p_apply+$v->p_apply;
    	            $p_apply=sprintf("%.2f",$p_apply);
    	        }
    	         
    	        if(empty($a[$v->order_id])){
    	            $a[$v->order_id]=1;
    	        }
    	    
    	        $n=$n+1;
    	    }
    	    //统计数量
    	    $data['rows'][$n] = new StdClass();
    	    $data['rows'][$n]->type=-1;
    	    $data['rows'][$n]->amount_apply=$amount_apply;
    	    $data['rows'][$n]->supplier_cost=$supplier_cost;
    	    $data['rows'][$n]->balance_money=$balance_money;
    	    $data['rows'][$n]->un_money=sprintf("%.2f", $un_money);
    	    $data['rows'][$n]->platform_fee=$platform_fee;
    	    $data['rows'][$n]->a_balance=sprintf("%.2f",$a_balance); 
    	    $data['rows'][$n]->paid='';
    	    $data['rows'][$n]->item_code='';
    	    $data['rows'][$n]->ordersn='';
    	    $data['rows'][$n]->productname='';
    	    $data['rows'][$n]->usedate='';
    	    $data['rows'][$n]->realname='';
    	    $data['rows'][$n]->u_reply='';
    	    $data['rows'][$n]->remark='';
    	    $data['rows'][$n]->p_union_name='';
    	    $data['rows'][$n]->employee_name='';
    	    $data['rows'][$n]->p_apply=sprintf("%.2f",$p_apply);
    	    $data['rows'][$n]->un_balance=$un_balance;
    	}
    	$data=json_encode((object)$data);
    	
		echo $data;
	}
	//申请付款单
	function get_apply_order(){
		$id=$this->input->post('id',true);
		$param = $this->getParam(array('u_starttime','u_endtime','ordersn'));
		$page=$this->input->post('page',true);
		$pageSize=$this->input->post('pageSize',true);
		if(empty($page)){
			$page=1;
		}
		if(empty($pageSize)){
			$pageSize=10;
		}
		$data='';
		if($id>0){
			$data = $this->apply_order->get_apply_order_list($id,$param,$page,$pageSize);
			//echo $this->db->last_query();	
		}
		echo json_encode($data);
	}
	//获取
	function get_apply_count(){

         $param = $this->getParam(array('u_starttime','u_endtime'));
         $id=$this->input->post('id',true);
         //流水单
         if(!empty($id)){
         	 	$flag=$this->apply_order->get_payable_pic($id);
         	 	$re['pic']=$flag;
         }
         $data = $this->apply_order->get_apply_order_list($id,$param,1,10);
         $re['apply_money']=0;
         $re['supplier_cost']=0;
         $re['balace_money']=0;
         $re['un_money']=0;
         $re['platform_fee']=0;
         if(!empty($data['data'])){
     		foreach ($data['data'] as $key => $value) {
     			$re['apply_money']=$value['amount_apply']+$re['apply_money'];
     			$re['supplier_cost']=$value['supplier_cost']+$re['supplier_cost'];
     			$re['balace_money']=$value['balance_money']+$re['balace_money'];
     			$re['un_money']=$value['un_account']+$re['un_money'];
     			$re['platform_fee']=$value['platform_fee']+$re['platform_fee'];

				$re['bankcard']=$value['bankcard'];
				$re['bankname']=$value['bankname'];
				$re['bankcompany']=$value['bankcompany'];
				$re['all_account']=$value['amount'];
				$re['remark_list']=$value['remark'];
     		}
         }  
         echo json_encode($re);

	}
	//取消申请的订单
	function cancel_apply_order(){
		$order_id=$this->input->post('order_id',true);
		$apply_id=$this->input->post('id',true);

		$apply=$this->apply_order->sel_data('u_payable_order',array('id'=>$apply_id));
		if(!empty($apply[0])){
		    if($apply[0]['status']==2){
		       echo json_encode(array('status' => -1,'msg' =>'该申请单已通过'));
		       exit;  
		    }
		}
		if(!empty($apply_id)&&!empty($order_id)){
			$re=$this->apply_order->save_apply_order($apply_id,$order_id);
			if($re){
				echo json_encode(array('status' =>1,'msg' =>'取消成功!'));
			}else{
				echo json_encode(array('status' => -1,'msg' =>'取消失败!'));	
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'取消失败!'));
		}
	}
	/*打印预付款*/
	public function pay_print()
	{
	
		$id=$this->input->get("id");
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$result=$this->u_payable_apply_model->payable_detail(array('po_id'=>$id)); 
		$data['list']=$result;
		$data['row']=$result[0];
		$data['list_id']=$id;
		
		$this->load->view ( "admin/b1/apply/pay_print",$data);
	}
	/**
	 * 打印月结预览
	 * */
	public function pay_print_month($id,$action="1")
	{
		$data['id']=$id;
		$data['action']=$action;
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$data['row']=$this->u_payable_apply_model->row(array('id'=>$id));

		$this->load->model('admin/t33/approve/u_supplier_refund_model','u_supplier_refund_model'); //供应商退款申请
		$this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
		$data['supplier']=$this->u_supplier_model->row(array('id'=>$data['row']['supplier_id']));
	
		$this->load->view("admin/b1/apply/pay_print_month",$data);
	}
	/**
	 * @name：私有函数：输出数据,$len是长度
	 * @author: 温文斌
	 * @param:
	 * @return:
	 *
	 */
	
	public function __data($reDataArr,$common=array()) {
		$len="1";
		if(empty($reDataArr))
		{
			$code="4001";
			$msg="data empty";
			$data=array();
		}
		else
		{
			if(is_array($reDataArr))
			$len=count($reDataArr);
	
			//$reDataArr = strip_slashes ( $reDataArr );
			$data=$reDataArr;
			$code="2000";
			$msg="success";
		}
	
		$output= json_encode ( array (
				"code" => $code,
				"msg" => $msg,
				"data" => $data,
				"total" => $len,
				'common'=>$common
		), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
	
		echo $output;
		exit ();
	}
	/**
	 * 请求错误信息接口
	 * @param string $msg
	 * @param string $code
	 */
	public function __errormsg($msg = "", $code = "-3") {
		$this->result_code = $code;
		if ($msg == "") {
			$this->result_msg = "data error";
		} else {
			$this->result_msg = $msg;
		}
	
		$this->resultJSON = json_encode ( array(
				"code" => $this->result_code,
				"msg" => $this->result_msg,
		) );
		echo $this->resultJSON;
		exit ();
	}
	/**
	 *  结算订单列表：api
	 * */
	public function api_pay_order()
	{
	
		$id=trim($this->input->post("id",true)); //营业部结算申请表id
		$price_start=trim($this->input->post("price_start",true));
		$price_end=trim($this->input->post("price_end",true));
		$team_code=trim($this->input->post("team_code",true));
		$productname=trim($this->input->post("productname",true));
		$expert_name=trim($this->input->post("expert_name",true));
	
		//分页
		$page = $this->input->post ( 'page', true );
		$page_size = 8;
		//$page_size="1";
		$page = empty ( $page ) ? 1 : $page;
		$from = ($page - 1) * $page_size;
		
		//条件筛选
		$where=array();
		//$supplier_name="地方";
		if(!empty($team_code))
			$where['team_code']=$team_code;
		if(!empty($productname))
			$where['productname']=$productname;
		if(!empty($expert_name))
			$where['expert_name']=$expert_name;
		if(!empty($price_start))
			$where['price_start']=$price_start;
		if(!empty($price_end))
			$where['price_end']=$price_end;

		$u_starttime=$this->input->post('u_starttime',true);
		$u_endtime=$this->input->post('u_endtime',true);
		$ordersn=$this->input->post('ordersn',true);
		if(!empty($ordersn)){$where['ordersn']=$ordersn;}  //供应商搜索订单编号
		if(!empty($u_starttime)){$where['u_starttime']=$u_starttime;}
		if(!empty($u_endtime)){$where['u_endtime']=$u_endtime;}

		$where['id']=$id;
		$this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
		$return=$this->u_payable_apply_model->pay_order($where,$from,$page_size);
		$result=$return['result'];
		$total_rows=$return['rows'];
		$total_page=ceil ( $total_rows/$page_size );

		if(empty($result))  $this->__data($result);
		$output=array(
			'page_size'=>$page_size,
			'page'=>$page,
			'total_rows'=>$total_rows,
			'total_page'=>$total_page,
			'result'=>$result
		);
		$this->__data($output);
		
			
	}
	//导出请款单
/*  	function drive_payable(){
        
 	    
 	    
	}  */
	//导出请款单
	function drive_payable(){
	    
		$param = $this->getParam(array('item_code','ordersn','linename','apply_sn','apply_status','starttime','endtime'));
	
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		 
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPHPExcel->setActiveSheetIndex(0);


		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->setTitle('供应商月结'); //表名
		
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
		$supplier_id = $arr['id'];
		
 		$bank=$this->apply_order->get_table_data('u_supplier_bank',array('supplier_id'=>$supplier_id));
		$sup=$this->apply_order->get_table_data('u_supplier',array('id'=>$supplier_id));
		if(!empty($sup[0]['company_name'])){
		    $supplier['company_name']=$sup[0]['company_name'];
		}else{
		    $supplier['company_name']='';
		}
		if(!empty($sup[0]['brand'])){
		    $supplier['brand']=$sup[0]['brand'];
		}else{
		    $supplier['company_name']='';
		}
		if(!empty($bank[0]['openman'])){
		    $supplier['bankcompany']=$bank[0]['openman'];
		}else{
		    $supplier['bankcompany']='';
		}
		if(!empty($bank[0]['bank'])){
		    $supplier['bankcard']=$bank[0]['bank'];
		}else {
		    $supplier['bankcard']='';
		}
		if(!empty($bank[0]['bankname'])){
		    $supplier['bankname']=$bank[0]['bankname'].$bank[0]['brand'];
		}else{
		    $supplier['bankname']='';
		}
		 
		$objActSheet->mergeCells('A1:M1');  //第一行空格
		$objActSheet->setCellValue('A1', '');
		//1、表结构1（供应商品牌名）
		$start=2;
		if(!empty($supplier))
		{
		    $objActSheet->mergeCells('A'.$start.':M'.$start);
		    $objActSheet->setCellValue('A'.$start, $sup[0]['company_name']."·".$sup[0]['brand']);
		    $objActSheet->getStyle('A'.$start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $objActSheet->getStyle('A'.$start)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
		    $start=3;
		}
			
		$data = $this->apply_order->drive_payable_apply_log($param,$supplier_id);
	
		$munu=array(    
	    	'0'=>'订单号',
			'1'=>'申请金额',
		    '2'=>'人数',
			'3'=>'结算价',
			'4'=>'已结算',
			'5'=>'操作费',
			'6'=>'未结算',
			'7'=>'待付款',
			'8'=>'团号',
		    '9'=>'备注'
		);

		//第二场景
		if(empty($supplier))
		{
		    $munu['14']="供应商名称";
		    $munu['15']="户名";
		    $munu['16']="银行账户";
		    $munu['17']="银行名称";
		}

		
		$i = 'A';
		foreach ($munu as $key=>$val) {
		    $col_title = $i . $start; //每次给这个值进行更改 即 第一次A1，第二次B1，第三次C1
		
		    $objActSheet->getColumnDimension($i)->setWidth(14);
		    $objActSheet->setCellValue($col_title,$munu[$key]);
		    $objActSheet->getStyle($col_title)->applyFromArray(array( 'font' => array( ),
		        'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) ) );
		    //执行相应操作
		    $i++;
		}

	    $acount=count($data);
		$start=$start+1;
		if(!empty($data)){
		    
		    $id_in=array();
		    $a=array(); // 关联数组：每个id对应的num

			foreach ($data as $key => $value) {
			    
		    if(empty($value['p_apply'])){
		        $value['p_apply']=0;
		    }
		    $value['un_money']=sprintf("%.2f",$value['un_money']);
		    $value['p_apply']=sprintf("%.2f",$value['p_apply']);
		    $value['amount_apply']=sprintf("%.2f",$value['amount_apply']);
		    
			$objActSheet->setCellValueExplicit('A'.($i+$start+$key),$value['ordersn'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('A'.($i+$start+$key))->applyFromArray(array(
			    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('B'.($i+$start+$key),$value['amount_apply'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('B'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

/* 			$objActSheet->getColumnDimension('C')->setWidth(30);
			$objActSheet->setCellValueExplicit('C'.($i+$start+$key),$value['productname'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('C'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('D'.($i+$start+$key), $value['usedate'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('D'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER))); */
            //人数
			$objActSheet->setCellValueExplicit('C'.($i+$start+$key),$value['order_people'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('C'.($i+$start+$key))->applyFromArray(array(
			    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
						
			$objActSheet->setCellValueExplicit('D'.($i+$start+$key), $value['supplier_cost'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('D'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

			$objActSheet->setCellValueExplicit('E'.($i+$start+$key), $value['balance_money'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('E'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
						
			$objActSheet->setCellValueExplicit('F'.($i+$start+$key), $value['platform_fee'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('F'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('G'.($i+$start+$key), $value['un_money'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('G'.($i+$start+$key))->applyFromArray(array(
			    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$objActSheet->setCellValueExplicit('H'.($i+$start+$key), $value['p_apply'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('H'.($i+$start+$key))->applyFromArray(array(
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

			$objActSheet->setCellValueExplicit('I'.($i+$start+$key), $value['item_code'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('I'.($i+$start+$key))->applyFromArray(array(
			    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
	/* 		$objActSheet->setCellValueExplicit('L'.($i+$start+$key), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('L'.($i+$start+$key))->applyFromArray(array(
			    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER))); */
			
			$objActSheet->getColumnDimension('J')->setWidth(30);
			$objActSheet->setCellValueExplicit('J'.($i+$start+$key), $value['remark'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->getStyle('J'.($i+$start+$key))->applyFromArray(array(
			    'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
			$i++;
					
    		//---------------------合拼单元格-----------------	
    			if($acount>1){
    			    
    			    array_push($id_in,$value['order_id']);

    			    if(in_array($value['order_id'],$id_in)&&!empty($a[$value['order_id']])){   //相同订单合拼
    			        $a[$value['order_id']]=$a[$value['order_id']]+1;
    			        $data[$key]['supplier_cost']=0;
    			        $data[$key]['balance_money']=0;
    			        $data[$key]['un_money']=0;
    			        $data[$key]['platform_fee']=0;
    			        $data[$key]['total_price']=0;
    			        $data[$key]['p_apply']=0;
    			        $data[$key]['order_people']=0;
    					        		
    			        $objActSheet->mergeCells('A'.($i+$start+$key-$a[$value['order_id']]+1).':A'.($i+$start+$key));        
    			        $objActSheet->mergeCells('C'.($i+$start+$key-$a[$value['order_id']]+1).':C'.($i+$start+$key));
    			        $objActSheet->mergeCells('D'.($i+$start+$key-$a[$value['order_id']]+1).':D'.($i+$start+$key));
    			        $objActSheet->mergeCells('E'.($i+$start+$key-$a[$value['order_id']]+1).':E'.($i+$start+$key));
    			        $objActSheet->mergeCells('F'.($i+$start+$key-$a[$value['order_id']]+1).':F'.($i+$start+$key));
    			        $objActSheet->mergeCells('G'.($i+$start+$key-$a[$value['order_id']]+1).':G'.($i+$start+$key));
    			        $objActSheet->mergeCells('H'.($i+$start+$key-$a[$value['order_id']]+1).':H'.($i+$start+$key));
    			        $objActSheet->mergeCells('I'.($i+$start+$key-$a[$value['order_id']]+1).':I'.($i+$start+$key));
    			      //  $objActSheet->mergeCells('J'.($i+$start+$key-$a[$value['order_id']]+1).':J'.($i+$start+$key));
    			       /*  $objActSheet->mergeCells('K'.($i+$start+$key-$a[$value['order_id']]+1).':K'.($i+$start+$key));
    			        $objActSheet->mergeCells('L'.($i+$start+$key-$a[$value['order_id']]+1).':L'.($i+$start+$key));
    			        $objActSheet->mergeCells('M'.($i+$start+$key-$a[$value['order_id']]+1).':M'.($i+$start+$key)); */
    			        $objActSheet->getStyle('A4'.':J'.($i+$start+$key))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    			      
    			    }
    			    
    			    if(empty($a[$value['order_id']])){ 
    			        $a[$value['order_id']]=1;    			       
    			    }    
    			}
    			
			}
			
			//------------------统计价格---------------------
			$n=0;
			$amount_apply=0;
			$supplier_cost=0;
			$balance_money=0;
			$un_money=0;
			$platform_fee=0;
			$p_apply=0;
			$total_price=0;
			$order_people=0;
			foreach ($data as $k=>$v){
			    $amount_apply=$amount_apply+$v['amount_apply'];
			    $supplier_cost=$supplier_cost+$v['supplier_cost'];
			    $balance_money=$balance_money+$v['balance_money'];
			    $un_money=$un_money+sprintf("%.2f",$v['un_money']);
			    $platform_fee=$platform_fee+$v['platform_fee'];
			    $p_apply=$p_apply+$v['p_apply'];
			    $p_apply=sprintf("%.2f",$p_apply);
			    $total_price=$total_price+$v['total_price'];
			    $order_people=$order_people+$v['order_people'];
			    $n=$n+1;
			}
			
			$last=$i+$start+count($data);
			
			$objActSheet->setCellValue('A'.$last, '总计');
			$objActSheet->setCellValue('B'.$last, $amount_apply);
			$objActSheet->setCellValue('C'.$last, $order_people);
			$objActSheet->setCellValue('D'.$last, $supplier_cost);
			$objActSheet->setCellValue('E'.$last, $balance_money);
			$objActSheet->setCellValue('F'.$last, $platform_fee);
			$objActSheet->setCellValue('G'.$last, $un_money);
			$objActSheet->setCellValue('H'.$last, $p_apply);
			$objActSheet->mergeCells('I'.$last.':J'.$last);
			$objActSheet->getStyle('A'.$last.':J'.$last)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
			//--------------供应商 银行账号----------------
			$last=$i+$start+count($data)+1;
			$three_start=$last+2;
				
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '户名：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objActSheet->mergeCells('C'.$three_start.':J'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, $supplier['bankcompany']);
				
			$three_start+=1;
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '银行账号：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				
			$objActSheet->mergeCells('C'.$three_start.':J'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, ' '.$supplier['bankcard']);
			$objActSheet->getStyle('C'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objActSheet->getStyle('C'.$three_start)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				
			$three_start+=1;
			$objActSheet->mergeCells('A'.$three_start.':B'.$three_start);
			$objActSheet->setCellValue('A'.$three_start, '银行名称-支行：');
			$objActSheet->getStyle('A'.$three_start)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objActSheet->mergeCells('C'.$three_start.':J'.$three_start);
			$objActSheet->setCellValue('C'.$three_start, $supplier['bankname']);
			
			//设置边框
			$styleArray = array(
					'borders' => array(
							'allborders' => array(
									//'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的
									'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框
									//'color' => array('argb' => 'FFFF0000'),
							),
					),
			);
			$objActSheet->getStyle('A1:J'.$three_start)->applyFromArray($styleArray);

		}
 
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		list($ms, $s) = explode(' ',microtime());
		$ms = sprintf("%03d",$ms*1000);
		$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
		$file='file/b1/uploads/payable'.$g_session.".xlsx";
		$objWriter->save($file);
		echo json_encode(array('status'=>1,'file'=>$file));

	}

	/**
	 * 付款申请详情 ： 版本二
	 * */
	public function pay_order_detail()
	{
	    $data=array();
	    $id=$this->input->get('id',true);
	    $data['payable_order_id']=$id;

	    $this->load->model('admin/t33/approve/u_payable_apply_model','u_payable_apply_model'); //付款申请表
	    $result=$this->u_payable_apply_model->payable_list3(array('id'=>$id));
	    
	    $data['row']=$result['result'][0];
	    $this->load->model('admin/t33/u_supplier_bank_model','u_supplier_bank_model'); //供应商银行账号
	    $data['bank']=$this->u_supplier_bank_model->row(array('supplier_id'=>$data['row']['supplier_id']));
	    
	   	$this->load->model('admin/t33/approve/u_payable_apply_pic_model','u_payable_apply_pic_model');
	    $data['pics']=$this->u_payable_apply_pic_model->all(array('payable_id'=>$data['row']['payable_id']));
	    $data['apply_id']=$data['row']['payable_id'];
	
	    $this->load->model('admin/t33/u_supplier_model','u_supplier_model'); //
	    $data['supplier']=$this->u_supplier_model->row(array('id'=>$data['row']['supplier_id']));
	
	    //结算申请中
	    $data['a_balance']=0;
	    if(!empty($data['row']['order_id'])){
	    	$ap_balance=$this->apply_order->get_pay_allmoney($data['row']['order_id']);	
	    	if(!empty($ap_balance['amount'])){
	    		$data['a_balance']=$ap_balance['amount'];
	    	}
	    }
	  
	    
	    $this->load->view("admin/b1/apply/pay_manage_detail",$data);
	}
		
	
}