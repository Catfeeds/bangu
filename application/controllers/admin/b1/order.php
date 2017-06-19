<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	include_once './application/controllers/msg/t33_send_msg.php';
	include_once './application/controllers/msg/t33_refund_msg.php';
class Order extends UB1_Controller {

	public function __construct() {
		//$this->need_login = true;
		parent::__construct ();
		$this->load->helper ( 'url' );
		$this->load->model ( 'admin/b1/order_status_model','order_model' );
		$this->load_model ( 'admin/b2/order_model', 'order' );
		header ( "content-type:text/html;charset=utf-8" );
	}
	public function index() {
		$supplier = $this->getLoginSupplier();
	       	//主页搜索传来的参数
	       	$data['type']=$this->input->get('type',true);
	       	$data['cancel']=$this->input->get('cancel',true); //取消
	       	$data['status']=$this->input->get('status',true); //点评,投诉
	       	$data['kind']=$this->input->get('kind',true); //订单类型
            if($data['type']==2){ //待确认订单 
        		$where=array('order_ispay'=>2,'order_status'=>1,'supplier_id'=>$supplier['id']);
        		$this->order_model->update_order_read(array('isread'=>1),$where);
            }else if($data['type']==3){  //客人申请退款
	        	$where=array(
	        		'order_ispay'=>3,
	        		'order_status'=>-3,
	        		'supplier_id'=>$supplier['id'],
	        	);
	        	$wherestr='order_id in (SELECT order_id from u_refund where refund_type=0)';
	        	$this->order_model->update_order_read(array('isread'=>1),$where,$wherestr);
        	
            }else if($data['type']==33){//管家申请退款
	        	$where=array('order_ispay'=>3,'order_status'=>-3,'supplier_id'=>$supplier['id']);
	        	$wherestr='order_id in (SELECT order_id from u_refund where refund_type=1)';
	        	$this->order_model->update_order_read(array('isread'=>1),$where,$wherestr);
	        	$data['type']=3;
            }else if($data['type']==4){ //平台已退款
	        	$where=array('order_ispay'=>4,'order_status'=>-4,'supplier_id'=>$supplier['id']);
	        	$this->order_model->update_order_read(array('isread'=>1),$where);
            }else if($data['type']=='01'){  // 待留位订单
	        	$where=array('order_ispay'=>0,'order_status'=>0,'supplier_id'=>$supplier['id']);
	        	$this->order_model->update_order_read(array('isread'=>1),$where);
            }
	        
            if($data['cancel']==1){  //订单已取消
    	        $where=array('order_ispay'=>0,'order_status'=>-4,'supplier_id'=>$supplier['id']);
    	        $this->order_model->update_order_read(array('isread'=>1),$where);
            }
        	if( $data['status']==7){  // 客人已投诉
	        	$where=array('order_ispay'=>2,'order_status'=>7,'supplier_id'=>$supplier['id']);
	        	$this->order_model->update_order_read(array('isread'=>1),$where);
        	}else if($data['status']==6){ //客人发评价
	        	$where=array('order_ispay'=>2,'order_status'=>6,'supplier_id'=>$supplier['id']);
	        	$this->order_model->update_order_read(array('isread'=>1),$where);
        	}
        
        	if(!empty($data['type'])){
        		$param=array('status'=>'1','status1'=>'2','status2'=>'3','pay_status'=>$data['type']);
        	}else{
        		$param=array('status'=>'1','status1'=>'2','status2'=>'3');
        	}
        	//order_status
        	if(!empty($data['status'])){
        		$status=array('order_status'=>$data['status']);
        	}else{
        		$status=null;
        	}
    		//全部订单
    	    $data['orderData']=$this->order_model->get_order_list(array(),$this->getPage (),$supplier['id']); 
    	    //计算订单未结算
    	    $data['orderData']=(array)json_decode($data['orderData']);
    	    foreach ($data['orderData']['rows'] as $k=>$v){ 
    	    	$ap_balance=$this->order_model->get_order_un_money($v->id);
    	    	$un_balance=($v->un_money)-$ap_balance;
    	    	$data['orderData']['rows'][$k]->un_balance=$un_balance;
    	    	$data['orderData']['rows'][$k]->a_balance=$ap_balance;
    	    }
    	    $data['orderData']=json_encode((object)$data['orderData']);
    	    
    	    //预留位
    	    $data['pageData']=$this->order_model->get_order_user(array('status'=>'0'),$this->getPage ()); 
                    
    		$this->load->view('admin/b1/header.html');
    		$this->load->view('admin/b1/order_data',$data);
    		$this->load->view('admin/b1/footer.html');
	}
    //全部订单
	public function  orderData(){
		$supplier = $this->getLoginSupplier();
		$param = $this->getParam(array('status','ordersn','linename','linesn','linecode','starttime','endtime'));

		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('destcity',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$cityName=$this->input->post('cityName',true);
		if(!empty($cityName)){
			$param['cityName']=trim($cityName);
		}
	/* 	$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		} */
    
		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}
		//var_dump($param);	
		//全部订单
	     $data=$this->order_model->get_order_list($param,$this->getPage (),$supplier['id']); 

	     
	     $data=(array)json_decode($data);
	     foreach ($data['rows'] as $k=>$v){
	     		
	     	$ap_balance=$this->order_model->get_order_un_money($v->id);
	     	$un_balance=($v->un_money)-$ap_balance;
	     	$data['rows'][$k]->un_balance=$un_balance;
	     	$data['rows'][$k]->a_balance=$ap_balance;
	     }
	     $data=json_encode((object)$data);
	     
	   //echo $this->db->last_query();
	     echo $data;
	}
	/*订单管理的分页查询*///预留位
	public function indexData(){

		$param = $this->getParam(array('status','ordersn','linename','linesn','linecode','starttime','endtime'));
		$param['status']= 0;
	//	$line_time=$this->getParam(array('line_time'));
		//时间查询
	/*	if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		}*/
		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$cityName=$this->input->post('cityName',true);
		if(!empty($cityName)){
			$param['cityName']=trim($cityName);
		}
		/* $dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		} */

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}
    	$data = $this->order_model->get_order_user($param,$this->getPage ());
    	//echo $this->db->last_query();
		echo  $data ;
	}
	//已预留位
	public function indexData1(){
		$param = $this->getParam(array('status','status1','status2','linecode','linename','pay_status','linesn'));
		$line_time=$this->getParam(array('line_time'));
		//时间查询
		if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		}
		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		}

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}

		$data = $this->order_model->get_order_left($param,$this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	//已确认
	public function indexData2(){
		$param = $this->getParam(array('status','ordersn','linename','linesn','linecode','starttime','endtime'));

		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$cityName=$this->input->post('cityName',true);
		if(!empty($cityName)){
			$param['cityName']=trim($cityName);
		}
	/* 	$dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		} */

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}

		$data = $this->order_model->get_order_user($param,$this->getPage ());
		
		$data=(array)json_decode($data);
		foreach ($data['rows'] as $k=>$v){
		
			$ap_balance=$this->order_model->get_order_un_money($v->id);
			$un_balance=($v->un_money)-$ap_balance;
			$data['rows'][$k]->un_balance=$un_balance;
			$data['rows'][$k]->a_balance=$ap_balance;
		}
		$data=json_encode((object)$data);
		
		//echo $this->db->last_query();
		echo  $data ;
	}
	//已取消
	public function indexData3(){
		$param = $this->getParam(array('ordersn','linename','pay_status','linesn','linecode','starttime','endtime'));
	/*	$line_time=$this->getParam(array('line_time'));
		//时间查询
		if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		}*/
		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$cityName=$this->input->post('cityName',true);
		if(!empty($cityName)){
			$param['cityName']=trim($cityName);
		}
/* 		$dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		} */

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}
		$data = $this->order_model->get_disorder($param,$this->getPage ());
		//echo $this->db->last_query();
		echo  $data ;
	}
	//出团中---行程结束
	public function indexData4(){
		$type=$this->input->post('status',true);
		$param = $this->getParam(array('ordersn','linename','order_status','linesn','linecode','starttime','endtime'));

		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$cityName=$this->input->post('cityName',true);
		if(!empty($cityName)){
			$param['cityName']=trim($cityName);
		}
		/* $dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		} */

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}
		$data = $this->order_model->get_order_over($param,$this->getPage (),$type);
		
		$data=(array)json_decode($data);
		foreach ($data['rows'] as $k=>$v){
		
			$ap_balance=$this->order_model->get_order_un_money($v->id);
			$un_balance=($v->un_money)-$ap_balance;
			$data['rows'][$k]->un_balance=$un_balance;
			$data['rows'][$k]->a_balance=$ap_balance;
		}
		$data=json_encode((object)$data);
		//echo $this->db->last_query();
		echo  $data ;
	}
	//改价/退团
	public function indexData5(){
		$type=$this->input->post('status',true);
		$param = $this->getParam(array('ordersn','linename','order_status','linesn','linecode','starttime','endtime'));
	/*	$line_time=$this->getParam(array('line_time'));
		//时间查询
		if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){
			$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
			$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		}*/
		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$cityName=$this->input->post('cityName',true);
		if(!empty($cityName)){
			$param['cityName']=trim($cityName);
		}
		/* $dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		} */

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}
		$data = $this->order_model->get_order_up($param,$this->getPage (),$type);
		
		$data=(array)json_decode($data);
		foreach ($data['rows'] as $k=>$v){
		
			$ap_balance=$this->order_model->get_order_un_money($v->id);
			$un_balance=($v->un_money)-$ap_balance;
			$data['rows'][$k]->un_balance=$un_balance;
			$data['rows'][$k]->a_balance=$ap_balance;
		}
		$data=json_encode((object)$data);
		
		echo  $data ;
	}
	/*确认余位,改变订单的状态*/
	public function updata_status(){
		
		$supplier = $this->getLoginSupplier(); //供应商
		
		if(!empty($_POST['data'])&& !empty($_POST['status'])){
			$memberid=$_POST['member'];  //会员
			$id=$_POST['data'];         //订单id
			$status=$_POST['status'];    //1、余位   4、空位
			
			//订单信息
			$order= $this->order_model->sel_data('u_member_order',array('id'=>$id));

			//改变订单状态
			$data=$this->order_model->up_order_status($order,$id);
			 if(!empty($order)){
				$number= $this->order_model->get_line_suit(array('sp.lineid'=>$order['productautoid'],'sp.suitid'=>$order['suitid'],'sp.is_open'=>1,'sp.day'=>$order['usedate']));
				$num_date=$number['number'];  //剩余库存
			}else {
				$num_date='';
			}
			if(!empty($order)){
				if($order['status']==4){
					echo  json_encode(array('type'=>0,'data'=>'订单已通过了！'));exit;
				}
			}
			if($data>0){ 
				//发消息给0代用户、1代b2
				$member=$_POST['member'];
				$expert=$_POST['expert'];
				//订单日记
				$this->order_model->order_log($order['id'],'供应商已留位',$supplier['id'],$order['status']);
				$content='供应商已留位,订单编号:'.$order['ordersn'].',线路标题：'.$order['productname'];
				if(!empty($expert)){    //发给b2
					$this->add_message($content,'1',$expert,'供应商已留位,请您及时跟进');
				}
				if(!empty($member)){   //发给用户
					$this->add_message($content,'0',$member,'供应商已留位,请您及时关注');
					//发短信通知用户
					$this->get_code($memberid,$id,$status,'');
				}
				if($num_date<5){      //库存少于5      发短信告诉供应商
					if(!empty($supplier['id'])){
						//发短信供应商
						$this->get_code($memberid,$id,200,$number);
					}	
				}
				echo  json_encode(array('type'=>1,'data'=>'余位成功！'));
			}elseif($data==-1){
				echo  json_encode(array('type'=>-1,'data'=>'库存不足！'));
			}else{
				echo  json_encode(array('type'=>0,'data'=>'操作失败！'));
			}
		}else{
			echo  json_encode(array('type'=>0,'data'=>'操作失败！'));
		}
	
	}
	/*确认订单 ,改变订单的状态*/
	public function ajax_status(){
		$supplier = $this->getLoginSupplier();
		if(!empty($_POST['data'])&& !empty($_POST['status'])){	
			//查询出会员
			$memberid=$_POST['member'];	
			$id=$_POST['data'];
			$status=$_POST['status'];    //1、余位   4、空位
			//订单信息
			$order= $this->order_model->sel_data('u_member_order',array('id'=>$id));
			$param=array('status'=>$status,'confirmtime_supplier'=>date("Y-m-d H:i:s",time()));
			if(!empty($order)){
				if($order['status']==4){
					echo  json_encode(array('type'=>0,'data'=>'订单已通过了！'));exit;
				}
			}
			//改变订单状态
	     	$data = $this->order_model->update_status($param,$id);
      		if($data){ 
		           $this->order_model->update_order_status_cal($id); //管家订单状态 
		           //发消息给0代用户、1代b2
		           $member=$_POST['member'];
		           $expert=$_POST['expert'];
		           $this->order_model->order_log($order['id'],'供应商已确认',$supplier['id'],$order['status']);
		           $content='供应商已确认,订单编号:'.$order['ordersn'].',线路标题：'.$order['productname'];
		           if(!empty($expert)){    //发给b2
		           		$this->add_message($content,'1',$expert,'供应商已确认,请您及时跟进');
		           }
		           if(!empty($member)){   //发给供应商
		           		$this->add_message($content,'0',$supplier['id'],'供应商已确认,请您及时关注');
		           		//发短信通知用户
		          	 	$this->get_code($memberid,$id,$status,'');
		           }
		           echo  json_encode(array('type'=>1,'data'=>'确认订单成功！'));
	       	}else{
	       	   	echo  json_encode(array('type'=>0,'data'=>'操作失败！'));
	       	}
		}else{
		   echo  json_encode(array('type'=>0,'data'=>'操作失败！'));
		}
	}

	/*订单详情*/
	public function order_detail(){
		$post_arr = array();
		$order_id = $this->input->get('id');
		$supplier = $this->getLoginSupplier();
		//访问订单的权限
		if($order_id>0){
			$res=$this->order_model->sel_data('u_member_order',array('id'=>$order_id,'supplier_id'=>$supplier['id']));
			if(empty($res)){
				echo '<script>alert("您没有权限访问该订单详情");window.history.back(-1);</script>';exit;	
			}
		}else{
			echo '<script>alert("不存在该订单详情");window.history.back(-1);</script>';exit;	
		} 

		$data=array();
		if($order_id>0){
			//订单信息
			$post_arr['mo.id'] = $order_id;
			$order_detail_info = $this->order_model->get_order_detail($post_arr); 

			//已付款
			//$this->load_model('admin/b2/order_manage_model', 'order_manage');
			$whereArr['order_id='] = $order_id;
			$whereArr['status='] = 2;
			$total_receive_amount = $this->order_model->get_sum_receive($whereArr);
			//echo $this->db->last_query();
			$order_detail_info[0]['total_receive_amount'] = !empty($total_receive_amount) ? $total_receive_amount['total_receive_amount'] : 0;

			//保险费用
			$insurance=$this->order_model->get_insurance($order_id);

			 //订单人数
			$order_people = $this->order_model->get_order_people($post_arr);
			//echo $this->db->last_query();
			//发票信息
			$order_invoice =$this->order_model->get_order_invoice(array('mo.order_id'=>$order_id));

			$pid=$order_detail_info[0]['productautoid'];	
			$reDataArr =$this->order_model->judge_around($pid);  //判断国内国外游
			//echo $this->db->last_query();	
			//订单付款详情
			$order_detail_data =$this->order_model->sel_data('u_order_detail',array('order_id'=>$order_id));
			
			//平台管理费
			$bill_yj=$this->order_model->get_order_bill_yj($order_id);
	
			//成本账单
			$bill_yf=$this->order_model->get_order_bill_yf($order_id);

			//已交款账单
			$receive=$this->order_model->get_receive_list($order_id);
		   
			//应收账单
			$order_ys=$this->order_model->get_bill_ys($order_id);			
			//应收账单总计
			$all_ys=$this->order_model->get_all_ys($order_id);
			
			//是否有额度申请
			$limit=$this->order_model->get_order_limit_apply($order_id,$supplier['id']);
			
			//订单附属表
			$affil=$this->order_model->sel_data('u_member_order_affiliated',array('order_id'=>$order_id));
			
			$data = array(
				'order_detail_info'=>$order_detail_info[0],
				'order_id'=>$order_id,
				'order_people'=>$order_people,
				'insurance'=>$insurance,
				'invoice'=>$order_invoice,
				'order_detail_data'=>$order_detail_data,
				'bill_yj'=>$bill_yj,
				'bill_yf'=>$bill_yf,
				'order_inou'=>$reDataArr,
				'receive'=>$receive,
			    'limit'=>$limit,
				'affil'=>$affil,
			   	'order_ys'=>$order_ys,
				'all_ys'=>$all_ys		
			);

		}
		if($order_detail_info[0]['user_type']==1){
			$this->load_view('admin/b1/order_detail_view',$data);	
		}else{
			$this->load_view('admin/b1/c_order_detail_view',$data);	
		}
		
	}
	//锁定名单
	function up_people_lock(){
		$orderid=$this->input->post('orderid',true); 
		if($orderid>0){
			$this->order_model->update_people_lock($orderid);

 			//订单人数
			$post_arr['mo.id'] = $orderid;
			$order_people = $this->order_model->get_order_people($post_arr);
	
			echo  json_encode(array('status'=>1,'order_people'=>$order_people)); 
		}else{
			echo  json_encode(array('status'=>-1,'mag'=>'操作失败')); 
		}
		
	}
   
	/*保存添加供应商的成本价*/
	function  add_order_cost(){
        $orderid=$this->input->post('orderid',true);
		$price=$this->input->post('price',true);
		$num=$this->input->post('num',true);
		$beizhu=$this->input->post('beizhu',true);
		$supplier = $this->getLoginSupplier(); //供应商
		$project=$this ->input->post('project',true);
		if(empty($project)){
			echo  json_encode(array('status'=>-1,'msg'=>'填写项目')); 
			exit;
		}
		if(empty($price)){
			echo  json_encode(array('status'=>-1,'msg'=>'填写价格')); 
			exit;
		}
		if(empty($num)){
			echo  json_encode(array('status'=>-1,'msg'=>'填写数量')); 
			exit;
		}

		if($orderid){
			$amount=$price*$num;
			$insertData=array(
				'order_id'=>$orderid,
				'user_type'=>2,
				'user_id'=>$supplier['id'],
				'user_name'=>$supplier['login_realname'],
				'num'=>$num,
				'price'=>$price,
				'amount'=>$amount,
				'addtime'=>date('Y-m-d H:i:s',time()),
				'item'=>$project,
				'remark'=>$beizhu,
				'supplier_id'=>$supplier['id'],
			);
			//供应商成本
			$orderArr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
			$order_yf=$orderArr['supplier_cost']+$amount;
	       
			if($order_yf>$orderArr['total_price']){
			    echo  json_encode(array('status'=>-1,'msg'=>'修改后的应付不能大于应收'));
			    exit;
			}
			if($order_yf<0){
				echo  json_encode(array('status'=>-1,'msg'=>'修改后的应付不能小于0'));
				exit;
			}

			
			$id=$this->order_model->save_order_bill_yf($insertData);			
			if($id){
				$data=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$id));
				if(!empty($data['addtime'])){
					$data['addtime']=date("Y-m-d H:s",strtotime($data['addtime']));
				}
				//发送消息jkr
				$msg = new T33_send_msg();
				$loginData = $this ->session ->userdata('loginSupplier');
				$msgArr = $msg ->billYfSupplier($id ,1 ,$loginData['linkman']);
				
				echo  json_encode(array('status'=>1,'msg'=>'保存成功','data'=>$data));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'保存失败'));
			}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'保存失败'));
		}	

	}
	/*通过成本价 退团*/
	function  through_oderprice(){

		$orderid=$this->input->post('order_id',true);
		$bill_id=$this->input->post('id',true);
		$s_remark=$this->input->post('supplier_remark',true);
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );
	/*	if(empty($s_remark)){
			 echo  json_encode(array('status'=>-1,'msg'=>'请填写审核意见'));
			 exit;
		}*/	
		if($bill_id>0 && $orderid>0){

			//供应商成本
			$orderArr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));

			//已通过成本的账单
			$order_yf=$this->order_model->get_order_yf_list($orderid,$bill_id);

			if($order_yf>$orderArr['total_price']){
				echo  json_encode(array('status'=>-1,'msg'=>'修改后的成本价不能少于订单总价')); 
				exit;
			}

			$this->load->model ( 'admin/b1/apply_order_model','apply_order');
			$re=$this->apply_order->update_bill_yf($bill_id,$orderid,$arr['id'],$s_remark);
			
			//订单操作日志
			$bill_row=$this->db->query("select * from u_order_bill_yf where id=".$bill_id)->row_array();
			$this->write_order_log($bill_row['order_id'],'审核通过调整应付:'.$bill_row['amount']);

			if($re){
				if($re==2){
					echo  json_encode(array('status'=>-1,'msg'=>'成本价不能低于0元'));
				}elseif($re==3){
					echo  json_encode(array('status'=>-1,'msg'=>'申请结算的金额已大于订单修改后的成本价'));	
				}else{
					echo  json_encode(array('status'=>1,'msg'=>'操作成功'));	
				}
				
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			 echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	/*拒绝成本价 退团*/
	function refuse_oderprice(){
		$orderid=$this->input->post('order_id',true);
		$bill_id=intval($this->input->post('id',true));
		//var_dump($bill_id);
		$this->load->library('session');
		$s_remark=$this->input->post('supplier_remark',true);
		$arr=$this->session->userdata ( 'loginSupplier' );
		if(empty($s_remark)){
			 echo  json_encode(array('status'=>-1,'msg'=>'请填写审核意见'));
			 exit;
		}
		//供应商成本
		$orderArr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
		
		if($arr['id']!=$orderArr['supplier_id']){
			echo json_encode(array('status'=>-1,'msg'=>'该订单跟供应商账号对不上,无法操作,请重新刷新页面'));exit;	
		}
		
		//已通过成本的账单
		$order_yf=$this->order_model->get_order_q($orderid);
		if($order_yf>$orderArr['total_price']){
			echo  json_encode(array('status'=>-1,'msg'=>'成本价不能少于订单总价')); 
			exit;
		}

		//账单
		$bill=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));
		//订单操作日志
		$bill_row=$this->db->query("select * from u_order_bill_yf where id=".$bill_id)->row_array();
		$this->write_order_log($orderid,'审核拒绝调整应付:'.$bill_row['amount']);
		
		if(!empty($bill)){
			if($bill['status']==4){
				echo json_encode(array('status'=>-1,'msg'=>'该账单已被拒绝了'));
				exit;	
			}
			if($bill['status']==2){
				echo json_encode(array('status'=>-1,'msg'=>'该账单已被确认了'));
				exit;
			}
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'该账单不存在了'));
			exit;
		}
		
		if($bill_id>0){
			$this->load->model ( 'admin/b1/apply_order_model','apply_order');
			$re=$this->apply_order->refuse_bill_yf($bill_id,$orderid,$arr['id'],$s_remark);
			if($re){
				//发送消息jkr
				$msg = new T33_send_msg();
				$loginData = $this ->session ->userdata('loginSupplier');
				$msgArr = $msg ->billYfExpert($bill_id ,2 ,$loginData['linkman']);
				
				echo  json_encode(array('status'=>1,'msg'=>'操作成功'));
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
			}
		}else{
			 echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
		}
	}
	/*撤销成本账单*/
	function dis_oder_yf(){
		$this->load->library('session');
		$arr=$this->session->userdata ( 'loginSupplier' );

		$bill_id=$this->input->post('bill_id',true);

		//成本账单信息	
		$bill=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));

		if(!empty($bill)){
			if($bill['status']==2){
				echo  json_encode(array('status'=>-1,'msg'=>' 该条记录销售人员已通过,不能被撤回了,请刷新一下页面')); 
				exit;
			}
		}

    	if($bill_id>0){
    		$re=$this->order_model->dis_bill_yf($bill_id,$arr['id']);
    		if($re){
    			echo  json_encode(array('status'=>1,'msg'=>'操作成功'));	
    		}else{
    			echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
    		}
    		
    	}else{
    		echo  json_encode(array('status'=>-1,'msg'=>'操作失败'));
    	}	
	}
	/*保险明细*/
	function sel_insurance(){
	    	$id=$this->input->post('id');
	    	if($id>0){
	         	$insurArr=$this->order_model->get_one_insurance($id);
	            echo  json_encode(array('status'=>1,'msg'=>'获取数据成功','insurArr'=>$insurArr));
	    	}else{
	    		echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败'));
	    	}
	    	
	}
    
	/*导出订单信息*/
	public function order_message(){

		$param = $this->getParam(array('linecode','linename','ordersn','pay_status','order_status','linesn','starttime','endtime'));
	//	var_dump($param);exit;
		//$line_time=$this->getParam(array('line_time'));
		//时间查询
		// if(isset($line_time['line_time'])&&!empty($line_time['line_time']) ){
		// 	$param['startdatetime'] =trim(substr(trim($line_time['line_time']),0,10));
		// 	$param['enddatetime'] = trim(substr(trim($line_time['line_time']),12));
		// }

		/*$pay_status=$this->input->post('pay_status',true);
		if(intval($pay_status)>=0){
			$param['pay_status']=$pay_status;
		}*/

		//管家查询
		$expert=$this->input->post('expert_name',true);
		if(!empty($expert)){
			$param['expert']=$expert;
		}
		//目的地
		$dest_city=$this->input->post('dest_city',true);
		if(!empty($dest_city)){
			$param['orvercity']=intval($dest_city);
		}
		$dest_country=$this->input->post('dest_country',true);
		if(!empty($dest_country)){
			$param['dest_country']=intval($dest_country);
		}
		$dest_province=$this->input->post('dest_province',true);
		if(!empty($dest_province)){
			$param['dest_province']=intval($dest_province);
		}

		//出发城市
		$country=$this->input->post('country',true);
		if(!empty($city)){
			$param['country']=$country;
		}
		$province=$this->input->post('province',true);
		if(!empty($city)){
			$param['province']=$province;
		}		
		$city=$this->input->post('city',true);
		if(!empty($city)){
			$param['startcity']=$city;
		}

		$type=$this->input->post('type',true);	
		$order_message=$this->order_model->get_order_meaasge($param,$type);
		//echo $this->db->last_query();exit;
		
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		 
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
		$objActSheet->getColumnDimension('I')->setWidth(15);
		$objActSheet->getColumnDimension('J')->setWidth(15);
		$objActSheet->getColumnDimension('K')->setWidth(15);
		$objActSheet->getColumnDimension('L')->setWidth(15);
        
		$objActSheet->setCellValue("A1",'订单编号');	
		$objActSheet->getStyle('A1')->applyFromArray(array( 'font' => array( 'bold' => true),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER ) ) );

		$objActSheet->setCellValue('B1', '团队编号');
		$objActSheet->getStyle('B1')->applyFromArray(array( 'font' => array( 'bold' => true),
			'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		$objActSheet->setCellValue('C1', '线路标题');
		$objActSheet->getStyle('C1')->applyFromArray(array( 'font' => array( 'bold' => true),
			'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('D1', '参团人数');
		$objActSheet->getStyle('D1')->applyFromArray(array( 'font' => array( 'bold' => true),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		
		$objActSheet->setCellValue('E1', '出团日期');
		$objActSheet->getStyle('E1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		$objActSheet->setCellValue('F1', '出团天数');
		$objActSheet->getStyle('F1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		$objActSheet->setCellValue('G1', '已收金额');
		$objActSheet->getStyle('G1')->applyFromArray(array( 'font' => array( 'bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		if($type==0){  //全部
			$objActSheet->setCellValue('H1', '结算价');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('I1', '已结算');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('J1', '未结算');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('K1', '下单时间');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('L1', '下单类型');
			$objActSheet->getStyle('L1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('M1', '销售部门');
			$objActSheet->getStyle('M1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('N1', '销售员');
			$objActSheet->getStyle('N1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		}elseif($type==1){  //预留位
			$objActSheet->setCellValue('H1', '下单时间');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('I1', '下单类型');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('J1', '销售部门');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('K1', '销售员');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
		}/*elseif($type==2){ //已预留位

			$objActSheet->setCellValue('H1', '支付状态');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('I1', '留位时间');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('J1', '下单类型');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('K1', '销售部门');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('L1', '销售员');
			$objActSheet->getStyle('L1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
		}*/elseif ($type==3 || $type==4){ //已确认,出团中

			$objActSheet->setCellValue('H1', '已付金额');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('I1', '结算价');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('J1', '已结算');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('K1', '未结算');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('L1', '确认时间');
			$objActSheet->getStyle('L1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('M1', '下单类型');
			$objActSheet->getStyle('M1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('N1', '销售部门');
			$objActSheet->getStyle('N1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('O1', '销售员');
			$objActSheet->getStyle('O1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			
		}else if($type==5){  //行程结束

			$objActSheet->setCellValue('H1', '已付金额');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('I1', '结算价');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('J1', '已结算');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('K1', '未结算');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('L1', '下单类型');
			$objActSheet->getStyle('L1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('M1', '销售部门');
			$objActSheet->getStyle('M1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('N1', '销售员');
			$objActSheet->getStyle('N1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		}else if($type==6){  //已取消

			$objActSheet->setCellValue('H1', '已付金额');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('I1', '支付状态');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('J1', '退款金额');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('K1', '取消时间');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('L1', '下单类型');
			$objActSheet->getStyle('L1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('M1', '销售部门');
			$objActSheet->getStyle('M1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('N1', '销售员');
			$objActSheet->getStyle('N1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

		}else if($type==7){  //改价,退团
			$objActSheet->setCellValue('H1', '结算价');
			$objActSheet->getStyle('H1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('I1', '已结算');
			$objActSheet->getStyle('I1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));	
			$objActSheet->setCellValue('J1', '未结算');
			$objActSheet->getStyle('J1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('K1', '下单时间');
			$objActSheet->getStyle('K1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('L1', '下单类型');
			$objActSheet->getStyle('L1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('M1', '销售部门');
			$objActSheet->getStyle('M1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
			$objActSheet->setCellValue('N1', '销售员');
			$objActSheet->getStyle('N1')->applyFromArray(array( 'font' => array( 'bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
		}
	
		
		if(!empty($order_message)){
			$i=0;
			foreach ($order_message as $key => $value) {
				
				$objActSheet->setCellValueExplicit('A'.($i+2),$value['ordersn'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('A'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValueExplicit('B'.($i+2),$value['linesn'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('B'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValueExplicit('C'.($i+2),$value['linename'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('C'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$objActSheet->setCellValueExplicit('D'.($i+2), $value['num'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('D'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValueExplicit('E'.($i+2), $value['usedate'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('E'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValueExplicit('F'.($i+2), $value['lineday'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('F'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				$objActSheet->setCellValueExplicit('G'.($i+2), $value['receive_price'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->getStyle('G'.($i+2))->applyFromArray(array(
						'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				$money='';
				if($value['ispay']=='确认中'){
					$money=$value['total_price'];
				}else if($value['ispay']=='未付款'){
					$money=0;
				}else if($value['ispay']=='已收款'){
					$money=$value['total_price'];
				}else{
					$money=$value['total_price'];
				}
				if($value['user_type']==0){
					$userstr="用户下单";
				}else if($value['user_type']==1){
					$userstr="管家下单";
				}
				if($type==0 || $type==7){ //全部订单

					$objActSheet->setCellValueExplicit('H'.($i+2), $value['supplier_cost'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('I'.($i+2), $value['balance_money'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('J'.($i+2), $value['un_money'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('K'.($i+2), $value['addtime'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('L'.($i+2), $userstr,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('L'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('M'.($i+2), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('M'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('N'.($i+2), $value['realname'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('N'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				}elseif($type==1 ){ //预留位

					$objActSheet->setCellValueExplicit('H'.($i+2), $value['addtime'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
					$objActSheet->setCellValueExplicit('I'.($i+2), $userstr,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					

					$objActSheet->setCellValueExplicit('J'.($i+2), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
					$objActSheet->setCellValueExplicit('K'.($i+2),$value['realname'] ,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
				
				}elseif($type==2){ //已预留位

					$objActSheet->setCellValueExplicit('H'.($i+2), $value['ispay'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('I'.($i+2), $value['lefttime'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
					$objActSheet->setCellValueExplicit('J'.($i+2), $userstr,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					

					$objActSheet->setCellValueExplicit('K'.($i+2), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
					$objActSheet->setCellValueExplicit('L'.($i+2),$value['realname'] ,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('L'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
						
				}elseif ($type==3 || $type==4){ //已确认,出团中

					$objActSheet->setCellValueExplicit('H'.($i+2), $money,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('I'.($i+2), $value['supplier_cost'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('J'.($i+2), $value['balance_money'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('K'.($i+2), $value['un_money'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('L'.($i+2), $value['confirmtime_supplier'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('L'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('M'.($i+2), $userstr,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('M'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('N'.($i+2), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('N'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('O'.($i+2), $value['realname'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('O'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				}elseif ($type==5){  //行程结束
					if($value['status']==4){
						$order_status='已确认';
					}else if($value['status']==5){
						$order_status='已完成';
					}else if($value['status']==6){
						$order_status='已评论';
					}else if($value['status']==7){
						$order_status='已投诉';
					}
					$objActSheet->setCellValueExplicit('H'.($i+2), $money,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('I'.($i+2), $value['supplier_cost'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('J'.($i+2), $value['balance_money'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('K'.($i+2), $value['un_money'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('L'.($i+2), $order_status,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('L'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('M'.($i+2), $userstr,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('M'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('N'.($i+2), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('N'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('O'.($i+2), $value['realname'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('O'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

				}elseif ($type==6){ 

					if($value['ispay1']=='退款中'){
					      	$ispay1=$value['ispay1'];
					}else if($value['ispay1']=='已退款'){
						$ispay1=$value['total_price'];
					}else{
						$ispay1=$value['ispay1'];
					}
					
					if($value['ispay2']==0){
						$ispay2='未付款';
					}else if($value['ispay2']==1){
						$ispay2='确认中';
					}else if($value['ispay2']==2){
						$ispay2='已收款';
					}else if($value['ispay2']==3){
						$ispay2='退款中';
					}else if($value['ispay2']==4){
						$ispay2='已退款';
					}
					$objActSheet->setCellValueExplicit('H'.($i+2), $money,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('H'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('I'.($i+2), $ispay2,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('I'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
					$objActSheet->setCellValueExplicit('J'.($i+2), $ispay1,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('J'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
						
					$objActSheet->setCellValueExplicit('K'.($i+2),$value['canceltime'] ,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('K'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('L'.($i+2), $userstr,PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('L'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('M'.($i+2), $value['depart_name'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('M'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));

					$objActSheet->setCellValueExplicit('N'.($i+2), $value['realname'],PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle('N'.($i+2))->applyFromArray(array(
							'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)));
					
				}
			
				$i++;
			}
		}
			
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		list($ms, $s) = explode(' ',microtime());
		$ms = sprintf("%03d",$ms*1000);
		$g_session = date('YmdHis')."_".$ms."_".rand(1000, 9999);
		$file="file/b1/uploads/order_message".$g_session.".xlsx";
		$objWriter->save($file);
		echo json_encode($file);
	}

	/**
	 * @method 获取线路的行程
	 * @author 贾开荣
	 * @since  2015-06-02
	 */
	public function get_line_jieshao() {
		$id = intval($_POST['id']);
		$this->load_model('admin/b1/line_jieshao_model','line_model');
		$data=$this ->line_model ->get_line_jieshao($id);
		echo json_encode($data);
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
   	 //发短信	
	public function get_code ($memberid,$orderid,$type,$Arr=array()) {

		$this->load->library ( 'callback' );
		//查询会员
		$member_arr=$this->order_model->sel_data('u_member',array('mid'=>$memberid));
		$order_arr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
		if(!empty($order_arr['supplier_id'])){
			$supplier_arr=$this->order_model->sel_data('u_supplier',array('id'=>$order_arr['supplier_id']));
		}
		if(!empty($member_arr)){
			
			$mobile=$member_arr['mobile'];
			//读取短信模板
			$this->load->model ( 'sms_template_model' ,'sms_model' );
			if($type==1){     //已留位
				$template = $this ->sms_model ->row(array('msgtype' =>'line_order_msg2'));
			}elseif($type==200){ //供应商
				$template = $this ->sms_model ->row(array('msgtype' =>'line_remind')); 
			}else{       //已确认
				$template = $this ->sms_model ->row(array('msgtype' =>'line_order_msg3'));
			}
			$template = $template ['msg'];
			if($type==1){
				//将验证码放入模板中
				$content=$template;
				//发送短信
				$status = $this ->send_message($mobile ,$content);

			}else if ($type==200){
				if(!empty($supplier_arr['mobile'])){
					$mobile=$supplier_arr['link_mobile'];
					$content = str_replace("{#LINENAME#}", $order_arr['productname'] ,$template);
					$content = str_replace("{#NAME#}", $Arr['suitname'] ,$content);
					$content = str_replace("{#NUMBER#}", $Arr['number'] ,$content);
				}
			}else{
				//将验证码放入模板中
			//	$content = str_replace("{#MEMBERNAME#}", $member_arr['loginname'] ,$template);
				$content = str_replace("{#PRODUCTNAME#}", $order_arr['productname'] ,$template);
				//发送短信
				$status = $this ->send_message($mobile ,$content);
			}
			if (empty($status)) {
              			 // echo 1;
			} else {
			//	echo 0;
			}
		}else{
			//echo '该用户不存在！';
		} 
	}
	
	function show_stock(){
		$lineid=$this->input->post('lineid');
		$suitid=$this->input->post('suitid');
		$day=$this->input->post('usedate');
		$stock=$this->order_model->get_stock($lineid,$day,$suitid);
		echo  json_encode(array('stock'=>$stock));
	}
	//B端的确认订单,再成本额度
	function  add_order_debit(){
	
		$orderid=intval($this->input->post('orderid',true));
		$is_agree=$this->input->post('is_agree',true);
		$ap_reply=$this->input->post('ap_reply',true);
		
		if($orderid>0){
			//$limitApply=$this->db->query("select id,credit_limit from b_limit_apply where order_id={$orderid} and status=1 ")->row_array(); 

			$Apply=$this->order_model->sel_data('b_limit_apply',array('order_id'=>$orderid,'status'=>1));
			if(empty($Apply)){
				echo  json_encode(array('status'=>-1,'msg'=>'该额度申请已不存在!')); 
				exit;	
			}else{
	            //判断余位是否充足
				$order=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
				if(!empty($order)){
					$member_sum=$order['childnobednum']+$order['childnum']+$order['dingnum'];
					$suit=$this->order_model->sel_data('u_line_suit_price',array('suitid'=>$order['suitid'],'day'=>$order['usedate'],'is_open'=>1));
					if(!empty($suit)){
						$mun=$suit['number']-$member_sum;
						if($mun<0){
							echo  json_encode(array('status'=>-1,'msg'=>'该线路的套餐价格余位不足!'));
							exit;
						}
					}else{
						echo  json_encode(array('status'=>-1,'msg'=>'该订单的套餐价格不存在!'));
						exit;
					}
					
					if($order['status']!=3){
						echo  json_encode(array('status'=>-1,'msg'=>'申请该额度的订单的状态出错,操作失败!'));
						exit;
					}
					
					$supplier = $this->getLoginSupplier();
					if($supplier['id']!=$order['supplier_id']){
						echo json_encode(array('status'=>-1,'msg'=>'该订单跟供应商账号对不上,无法操作,请重新刷新页面'));exit;
					}
				}
				
				$re=$this->order_model->save_order_debit($orderid,$ap_reply);
				
				if($re){
					//订单操作日志
					$this->write_order_log($orderid,'审核通过管家信用申请:'.$Apply['credit_limit'].'元');
					echo  json_encode(array('status'=>1,'msg'=>'操作成功')); 
					//发送消息jkr
					$msg = new T33_send_msg();
					$loginData = $this ->session ->userdata('loginSupplier');
					$msgArr = $msg ->applyQuotaMsg($Apply['id'],3,$loginData['linkman']);
					exit;
				}else{
					echo  json_encode(array('status'=>-1,'msg'=>'操作失败')); 
					exit;	
				}
			}

		}else{		
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败')); 
			exit;
		}
	}
	//下单扣款数据
	function get_order_debit(){
		$orderid=$this->input->post('orderid',true);
		if($orderid>0){
			$data=$this->order_model->get_order_debit_list($orderid);
			echo  json_encode($data);
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'获取数据失败')); 
			exit;
		}
	}
	//拒绝信用额度的下单申请
	function refuse_order_debit(){
      
		$orderid=intval($this->input->post('orderid',true));
		$s_reply=$this->input->post('s_reply',true);

		if(empty($s_reply)){
			echo  json_encode(array('status'=>-1,'msg'=>'请填写拒绝理由')); 
			exit;	
		}

		if($orderid>0){

			
			$Apply=$this->order_model->sel_data('b_limit_apply',array('order_id'=>$orderid,'status'=>1));
			if(!empty($Apply)){
			 	//订单状态
			 	$order=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
			 	if($order['status']!=3){
			 		echo  json_encode(array('status'=>-1,'msg'=>'订单号状态对不上,操作失败'));exit;
			 	}
			 		
				$re=$this->order_model->update_order_debit($orderid,$s_reply);
				
				if($re){
					echo  json_encode(array('status'=>1,'msg'=>'操作成功')); 
					//订单操作日志
					$this->write_order_log($orderid,'审核拒绝管家信用申请:'.$Apply['credit_limit'].'元');
					//发送消息jkr
					$msg = new T33_send_msg();
					$loginData = $this ->session ->userdata('loginSupplier');
					$msgArr = $msg ->applyQuotaMsg($Apply['id'],3,$loginData['linkman']);
					exit;
				}else{
					//var_dump($re);
					echo  json_encode(array('status'=>-1,'msg'=>'操作失败')); 
					exit;	
				}
				$supplier = $this->getLoginSupplier();
				if($supplier['id']!=$order['supplier_id']){
					echo json_encode(array('status'=>-1,'msg'=>'该订单跟供应商账号对不上,无法操作,请重新刷新页面'));exit;
				}
				
			}else{
				echo  json_encode(array('status'=>1,'msg'=>'订单额度不存在')); 
				exit;
			}

		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'操作失败')); 
			exit;
		}	
	}
	//用户信息
	function show_user_message(){
		$user_type=$this->input->post('user_type',true);
		$user_id=$this->input->post('user_id',true);
		if($user_type==1){ //管家
			$this->load_model('admin/b2/expert_model', 'expert');
			$data['user']=$this->expert->row(array('id'=>$user_id));
			//管家从业简历表
			$data['expert_resume']=$this->expert->get_alldate('u_expert_resume',array('expert_id'=>$user_id));
			//荣誉证书
			$data['expert_certificate']=$this->expert->get_alldate('u_expert_certificate',array('expert_id'=>$user_id));
			//上门服务
			if(!empty($data['user']['visit_service'])){
				$data['service']=$this->expert->getLineattr(explode(",",$data['user']['visit_service']));
			}
	        //擅长的目的
	        if(!empty($data['user']['expert_dest'])){
				$data['dest']=$this->expert->getDestattr(explode(",",$data['user']['expert_dest']));
	       	}
				
		}else if($user_type==2){ //供应商
			$this->load_model ( 'supplier_model', 'supplier' );
			$data['user']=$this->supplier->row(array('id'=>$user_id));
		}else if($user_type==3){ //平台
			$this->load_model ( 'admin/t33/b_employee_model', 'employee' );
			$data['user']=$this->employee->row(array('id'=>$user_id));
		}else if($user_type==4){ //旅行社
			$this->load_model ( 'union_model', 'union' );
			$data['user']=$this->union->row(array('id'=>$user_id));
		}
		echo   json_encode($data);
	}
	//获取改价信息
	function get_tuituan_data(){
		$bill_id=$this->input->post('bill_id',true);
		$orderid=$this->input->post('orderid',true);
		$data=$this->order_model->get_tuituanData($bill_id,$orderid);
		echo   json_encode($data);
	}
	//获取订单退团信息
	function retired_order_detail(){
		$bill_id=$this->input->get('bill_id',true);
		$orderid=$this->input->get('orderid',true);
		$data=array();
		if(!empty($bill_id) && !empty($orderid)){
			$data['refund']=$this->order_model->get_tuituanData($bill_id,$orderid);
			$data['order']=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));	
			$data['bill_id']=$bill_id;
			$data['orderid']=$orderid;	
		}
		$this->load_view('admin/b1/b_order/retired_order_detail',$data);
	}
	// 供应商退款申请表	
	function save_tuituan_data(){
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
		$t_remark=$this->input->post('t_remark',true);
		$core_pic=$this->input->post('core_pic',true);
		$t_meney=$this->input->post('t_meney',true);
		//var_dump($t_meney);exit;
		if(empty($t_meney)){
			echo json_encode(array('status'=>-1,'msg'=>'请填写退款金额'));
			exit;
		}else{
			if($t_meney<0){
				echo json_encode(array('status'=>-1,'msg'=>'退款金额需大于0的金额'));
				exit;
			}
		}
		$receIve=$this->order_model->get_order_receIve($orderid);	
		if(!empty($receIve['money'])){
			if($t_meney>$receIve['money']){
				echo json_encode(array('status'=>-1,'msg'=>'退款金额大于已结算金额'));
				exit;
			}
		}
		if(empty($t_remark)){
			echo json_encode(array('status'=>-1,'msg'=>'请填写备注'));
			exit;
		}
		$refund= $this->order_model->sel_data('u_supplier_refund',array('yf_id'=>$bill_id));
		if(!empty($refund)){  //判断是否有操作
			if($refund['status']==0){
				echo json_encode(array('status'=>-1,'msg'=>'待确认退款中'));
				exit;
			}
		}

		if(!empty($bill_id)){
			$supplier = $this->getLoginSupplier();
			$Tmessage=$this->order_model->get_tuituanData($bill_id,$orderid);
			$tol_money=$Tmessage['p_amount']+$Tmessage['platform_fee']+$t_meney; //未结算,平台管理费,退结算金额
			$amount=-$Tmessage['amount'];
			if($tol_money<$amount){ //退款
				echo json_encode(array('status'=>-1,'msg'=>'退已结算金额和未结算金额和平台管理费之和不能小于订单退款金额'));
				exit;	
			}

			$re=$this->order_model->add_order_refund($Tmessage,$orderid,$bill_id,$supplier['id'],$t_remark,$core_pic,$t_meney);	
			if($re){
				echo  json_encode(array('status'=>1,'msg'=>'操作成功')); 
				exit;
			}else{
				//var_dump($re);
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败')); 
				exit;	
			}	
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'提交失败'));
		}
	}
	//通过成本价的修改
	function save_tuituan_order(){
		$orderid=$this->input->post('orderid',true);
		$bill_id=$this->input->post('bill_id',true);
		$supplier = $this->getLoginSupplier();
		if(!empty($bill_id)){
			//供应商成本
			$orderArr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));

			if($supplier['id']!=$orderArr['supplier_id']){
				echo json_encode(array('status'=>-1,'msg'=>'该订单跟供应商账号对不上,无法操作,请重新刷新页面'));exit;	
			}
	
			$bill=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));
			if(!empty($bill)){
				if($bill['status']==2){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已通过,请刷新一下页面')); 
					exit;
				}
				if($bill['status']==4 || $bill['status']==3){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已被拒绝,请刷新一下页面')); 
					exit;
				}
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>' 该条账单不存在'));
				exit;
			}
			
			//-------------------判断管家账户余额是否够扣-----------------------
			//修改后的佣金;
			$item_price=$orderArr['supplier_cost']+$bill['amount'];
			$agent_fee=$orderArr['total_price']-$item_price-$orderArr['settlement_price']-$orderArr['diplomatic_agent'];
			//以前的佣金-修改后的佣金;
			$agent_change=$orderArr['depart_balance']-$agent_fee;
			$depart_limit=$this->order_model->get_depart_limit($orderArr['depart_id']);
			if($agent_change>$depart_limit['cash_limit']&&$orderArr['status']!="9"){
				echo json_encode(array('status'=>-1,'msg'=>'营业部账户余额不足以抵扣调高的应付'));
				exit();
			}	
				
			//已通过成本的账单
			$order_yf=$this->order_model->get_order_yf_list($orderid,$bill_id);
			
			//订单操作日志 wwb
			$bill_row=$this->db->query("select * from u_order_bill_yf where id=".$bill_id)->row_array();
			$order_refund=$this->db->query("select id from u_order_refund where yf_id=".$bill_id)->row_array();
			$text="调整应付:";
			if(!empty($order_refund)) $text="退团的退应付:";
			$this->write_order_log($bill_row['order_id'],'审核通过'.$text.$bill_row['amount']);
			
	
			if($order_yf>$orderArr['total_price']){
				echo  json_encode(array('status'=>-1,'msg'=>'修改后的成本价不能少于订单总价')); 
				exit;
			}
         

			$re=$this->order_model->update_bill_yf($orderid,$bill_id,$supplier['id']);

			if($re){
				//发送消息jkr
				$loginData = $this ->session ->userdata('loginSupplier');
				if (is_array($re))
				{
					$msg = new T33_refund_msg();
					$msgArr = $msg ->sendMsgRefund($re['id'],3,$loginData['linkman']);
				}
				else 
				{
					$msg = new T33_send_msg();
					$msgArr = $msg ->billYfExpert($bill_id ,2 ,$loginData['linkman']);
				}
				
				echo  json_encode(array('status'=>1,'msg'=>'操作成功')); 
				exit;
			}else{
				//var_dump($re);
				echo  json_encode(array('status'=>-1,'msg'=>'操作失败')); 
				exit;	
			}	
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'提交失败'));	
		}
	}

	//确认退团退人
	function save_confirm_order(){
	
		$orderid=$this->input->post('orderid',true);
		$bill_id=intval($this->input->post('bill_id',true));
		$supplier = $this->getLoginSupplier();
		$supplier_id=$supplier['id'];

		if($bill_id>0){

			$this->db->trans_start(); //事务开始
			//订单操作日志wwb
			$order_refund=$this->db->query("select * from u_order_refund where yf_id=".$bill_id.' and order_id='.$orderid)->row_array();
			$this->write_order_log($orderid,'通过退团(退'.$order_refund['num'].'人):退应收'.$order_refund['ys_money'].'、退已交'.$order_refund['sk_money'].'、退应付'.$order_refund['yf_money']);
			
			//供应商成本信息
			$orderArr=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));

			if($supplier_id!=$orderArr['supplier_id']){
				echo json_encode(array('status'=>-1,'msg'=>'该订单跟供应商账号对不上,无法操作,请重新刷新页面'));exit;	
			}
          
			//成本账单信息	
			$bill=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id));
			
			if(!empty($bill)){
				if($bill['status']==2){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已通过,请刷新一下页面')); 
					exit;
				}
				if($bill['status']==4 || $bill['status']==3){
					echo  json_encode(array('status'=>-1,'msg'=>' 该条记录已被拒绝,请刷新一下页面')); 
					exit;
				}
			}else{
				echo  json_encode(array('status'=>-1,'msg'=>' 该条账单不存在'));
				exit;
			}


			//-----------------------------1.修改供应商成本-------------------------
			$item_price=$orderArr['supplier_cost']+$bill['amount']; 
			$this->order_model->update_tabledata('u_member_order',array('supplier_cost'=>$item_price), array('id'=>$orderid));

			//修改成本账单
			$billArr=array(
				'supplier_id'=>$supplier_id,
				's_time'=>date('Y-m-d,H:i:s',time()),
				'status'=>2,
			);
			$this->order_model->update_tabledata('u_order_bill_yf',$billArr, array('id'=>$bill['id']));

			//---------------------------------2.订单操作日记----------------------------------
			if($bill['kind']==2){
				$remark=" 订单价格{$orderArr['supplier_cost']} 改成 成本价{$item_price} ,";
				if(!empty($bill['num'])){ $remark.=" 退{$bill['num']}成人 , ";}
				if(!empty($bill['childnum'])){ $remark.=" 退{$bill['childnum']}小孩 , ";}
				if(!empty($bill['childnobednum'])){ $remark.=" 退{$bill['childnobednum']}小孩(不占床) , ";}
				if(!empty($bill['oldnum'])){ $remark.=" 退{$bill['oldnum']}老人 , ";}
			}else{
				$remark=" 订单价格{$orderArr['supplier_cost']} 改成 成本价{$item_price} ";
			}	
			$logArr=array(
				'order_id'=>$bill['order_id'],
				'num'=>$bill['num'],
				'type'=>1,
				'price'=>$bill['price'],
				'amount'=>$bill['amount'],
				'user_type'=>2,
				'user_id'=>$bill['supplier_id'],
				'addtime'=>date("Y-m-d H:i:s"),
				'remark'=>$remark,
			);
			$this->db->insert ( 'u_order_bill_log', $logArr );

			//------------------------------4.订单退款表  状态改为2--------------------------------
			$yfdata=$this->order_model->sel_data('u_order_refund',array('yf_id'=>$bill_id,'order_id'=>$orderid));
			if(!empty($yfdata)){
				$this->order_model->update_tabledata('u_order_refund',array('status'=>2), array('order_id'=>$orderid,'yf_id'=>$bill_id));
			}

			//------------------------------------ 5.退管家佣金-----------------------------
			///订单是否交全款
			$receiva=$this->db->query("select  sum(money) as j_money  from u_order_receivable where order_id={$orderid} and (status=2 or status=1 or status=0)")->row_array();
			if(empty($receiva['j_money'])){
				$receiva['j_money']=0;
			}	
			if($receiva['j_money']>=$orderArr['total_price']){

				//营业部额度信息
				$depart=$this->db->query("select  cash_limit  from b_depart where id={$orderArr['depart_id']} ")->row_array(); 

				//修改后的佣金;
				$agent_fee=$orderArr['total_price']-$item_price-$orderArr['settlement_price']-$orderArr['diplomatic_agent'];
				 //以前的佣金-修改后的佣金;
				$agent_change=$orderArr['depart_balance']-$agent_fee;			

				//营业部额度变化记录表
				$limitLog=array(
					'depart_id'=>$orderArr['depart_id'],
					'expert_id'=>$orderArr['expert_id'],
					'order_id'=>$orderArr['id'],
					'union_id'=>$orderArr['platform_id'],
					'supplier_id'=>$supplier_id,
					'addtime'=>date("Y-m-d H:i:s"),
					'order_sn'=>$orderArr['ordersn'],
					'order_price'=>$orderArr['total_price'],
					'remark'=>'供应商确认退团'
				);
				$limitMoney=-$agent_change;
				if($limitMoney>0){
					$limitLog['receivable_money']=$limitMoney;	
					$limitLog['type']='退团,返回管家佣金';	
				}else{
					$limitLog['cut_money']=$limitMoney;
					$limitLog['type']='退团,扣除管家佣金';
				}
				$limitLog['cash_limit']=$depart['cash_limit']+$limitMoney;
				$this->db->insert ( 'b_limit_log', $limitLog );
				
				//判断管家账户余额是否够用
				$depart_limit=$this->order_model->get_depart_limit($orderArr['depart_id']);
				if($agent_change>0){
					if($agent_change>$depart_limit['cash_limit']&&$orderArr['status']!="9"){
						echo json_encode(array('status'=>-1,'msg'=>'营业部账户余额不足以抵扣调高的应付'));
						exit();
					}
				}
				
				//营业部额度
				$this->db->query("update b_depart set cash_limit=cash_limit+{$limitMoney} where id={$orderArr['depart_id']} ");
				$this->db->query("update u_member_order set depart_balance=depart_balance+{$limitMoney} where id={$orderid} ");
			}
		
			//修改管家佣金  应交-应付-外交-保险
			$e_sql="update u_member_order set agent_fee=total_price-supplier_cost-settlement_price-diplomatic_agent where id={$orderid}";
			$this->db->query($e_sql);

			//---------------------------------6.修改订单价格--------------------------------------
			if($orderArr['status']==-3 ){  //退订中
			   if($orderArr['total_price']==0){
			   		$this->order_model->update_tabledata('u_member_order',array('status'=>'-4','ispay'=>4,'depart_balance'=>0), array('id'=>$orderid));
			   }	
			
			}else{
				$this->order_model->update_tabledata('u_member_order',array('status'=>'4'), array('id'=>$orderid));
			} 	

			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>-1,'msg'=>'操作失败'));	
			}else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>1,'msg'=>'操作成功'));	
			}

		}else{
			echo json_encode(array('status'=>-1,'msg'=>'操作失败'));		
		}
	
	}
	
	//拒绝订单退团(不退人)
	function refuse_order_bill(){

	    $orderid=$this->input->post('orderid',true);
	    $bill_id=$this->input->post('bill_id',true);
	    $s_remark=$this->input->post('supplier_remark',true);
	    $supplier = $this->getLoginSupplier();
	    $supplier_id=$supplier['id'];
	    if(intval($bill_id)>0){
	    
	        $this->db->trans_start(); //事务开始
	        
	        //订单信息
	        $order=$this->order_model->sel_data('u_member_order',array('id'=>$orderid));
	        //订单操作日志wwb
	        $order_refund=$this->db->query("select * from u_order_refund where yf_id=".$bill_id.' and order_id='.$orderid)->row_array();
	        $this->write_order_log($orderid,'拒绝退团(不退人):退应收'.$order_refund['ys_money'].'、退已交'.$order_refund['sk_money'].'、退应付'.$order_refund['yf_money']);
	        //应付账单
	        $bill_yf=$orderArr=$this->order_model->sel_data('u_order_bill_yf',array('id'=>$bill_id,'order_id'=>$orderid));
	        if($bill_yf['status']==4 ||$bill_yf['status']==3){
	           echo json_encode(array('status'=>-1,'msg'=>'该账单已拒绝'));exit;  
	        }
	        if($bill_yf['status']==2){
	            echo json_encode(array('status'=>-1,'msg'=>'该账单已通过'));exit;
	        }
	        if($bill_yf['status']==0){
	            echo json_encode(array('status'=>-1,'msg'=>'该账单需经理审核提交'));exit;
	        }
            
	        //应收账单
	        $bill_ys=$this->order_model->sel_data('u_order_bill_ys',array('id'=>$bill_yf['ys_id'],'order_id'=>$orderid));
	        if(empty($bill_ys)){
	            echo json_encode(array('status'=>-1,'msg'=>'操作失败,不存在应收账单'));exit;
	        }
	        
	        //改应付账单  
	        $this->order_model->update_tabledata('u_order_bill_yf',array('status'=>4,'s_remark'=>$s_remark,'s_time'=>date('Y-m-d,H:i:s',time())), array('id'=>$bill_id));

	        //退款账单
	        $order_receiv=$this->db->query("select sum(cash_refund) as money from u_order_refund where ys_id={$bill_yf['ys_id']} and order_id={$orderid}")->row_array(); 
			if(empty($order_receiv['money'])){
				$order_receiv['money']=0;
			}
			$rece=$order_receiv['money'];
	        
	        //退应收-改应收账单
	        $total_price=$order['total_price']-$bill_ys['amount'];        
	        $this->order_model->update_tabledata('u_member_order',array('total_price'=>$total_price), array('id'=>$orderid));
	        $this->order_model->update_tabledata('u_order_bill_ys',array('status'=>3), array('id'=>$bill_ys['id']));
	        
	        //退额度--营业部额度变化记录表
	        $depart=$this->order_model->sel_data('b_depart',array('id'=>$order['depart_id']));
	        $limitLog=array(
	            'depart_id'=>$order['depart_id'],
	            'expert_id'=>$order['expert_id'],
	            'order_id'=>$order['id'],
	            'union_id'=>$order['platform_id'],
	            'supplier_id'=>$supplier_id,
	            'addtime'=>date('Y-m-d H:i:s',time()),
	            'order_sn'=>$order['ordersn'],
	        	'order_price'=>$order['total_price'],
	        	'remark'=>'供应商拒绝退团'
	        );
	        //$limitMoney=$bill_ys['amount'];
	        $limitMoney=-$rece;
	        if($limitMoney>0){
	            $limitLog['receivable_money']=$limitMoney;
	            $limitLog['type']='拒绝退团,供应商退营业部额度';
	        }else{
	            $limitLog['cut_money']=$limitMoney;
	            $limitLog['type']='拒绝退团,供应商扣营业部额度';
	        }
	        
	        $limitLog['cash_limit']=$depart['cash_limit']+$limitMoney;
	        $this->db->insert ( 'b_limit_log', $limitLog );
	        
	        //营业部额度
	        $this->db->query("update b_depart set cash_limit=cash_limit+{$limitMoney} where id={$order['depart_id']} ");
	        
	        //订单账单日志表
	        $logArr=array(
	            'order_id'=>$bill_yf['order_id'],
	            'num'=>0,
	            'type'=>1,
	            'price'=>$bill_yf['price'],
	            'amount'=>$bill_yf['amount'],
	            'user_type'=>2,
	            'user_id'=>$bill_yf['supplier_id'],
	            'addtime'=>date("Y-m-d H:i:s",time()),
	            'remark'=>'订单成本'.$order['supplier_cost'].',供应商拒绝退团',
	        );
	        $this->db->insert ( 'u_order_bill_log', $logArr );
	
	       
	        //情况一:产生一条负交款单
	        if(!empty($bill_ys['sk_id'])){
	        	
	        	$this->order_model->update_tabledata('u_order_receivable',array('status'=>6), array('id'=>$bill_ys['sk_id']));
	        	
	        }else{//情况二: 经理拒绝交款---改成未提交
	        		
	        	$refund=$this->order_model->sel_data('u_order_refund',array('yf_id'=>$bill_id,'order_id'=>$orderid));
	        	if(!empty($refund['sk_id'])){
	        		$sk_id=explode(',', $refund['sk_id']);
	        		if(!empty($sk_id)){
	        			foreach ($sk_id as $k=>$v){
	        				$this->order_model->update_tabledata('u_order_receivable',array('status'=>0), array('order_id'=>$order['id'],'id'=>$v));
	        			}
	        		}
	        	}
	        	
	        }
	        
	        //改退款表
	        $this->order_model->update_tabledata('u_order_refund',array('status'=>-2), array('yf_id'=>$bill_id,'order_id'=>$orderid));
	        
	        //-------修改订单扣款表----------
	        $yf_money=-$bill_ys['amount'];
	        $limit_money=$yf_money-$rece;  //单团信用额度  
	        $this->db->query("update u_order_debit set repayment=repayment-{$rece} where order_id={$orderid} and type=1 ");  
	        $this->db->query("update u_order_debit set repayment=repayment-{$limit_money} where order_id={$orderid} and type=3 ");
	       
	        //重新计算管家佣金

	        $e_sql="update u_member_order set agent_fee=total_price-supplier_cost-settlement_price-diplomatic_agent where id={$orderid}";
	        $this->db->query($e_sql);
	        
	        if ($this->db->trans_status() === FALSE){
	            $this->db->trans_rollback();
	            echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
	        }else{
	            $this->db->trans_commit();
	            
	            //获取退团信息
	            $sql = 'select * from u_order_refund where yf_id='.$bill_id.' and order_id='.$orderid;
	            $refundData = $this ->db ->query($sql) ->row_array();
	            
	            $loginData = $this ->session ->userdata('loginSupplier');
	            $msg = new T33_refund_msg();
	            $msgArr = $msg ->sendMsgRefund($refundData['id'],3,$loginData['linkman']);
	            
	            echo json_encode(array('status'=>1,'msg'=>'操作成功'));
	        }
	        
	    }else{
	        echo json_encode(array('status'=>-1,'msg'=>'操作失败'));
	    }
   
	}

}
