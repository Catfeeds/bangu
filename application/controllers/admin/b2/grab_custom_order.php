<?php
/**
 * 抢定制订单
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月22日15:50:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Shanghai');
class Grab_Custom_Order extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/grab_custom_order_model', 'grab_custom_order');
	}

          //进入首页,列出抢单数据
	public function index($page=1) {
		$tab_index = $this->input->get('tab');
		$tab_index = (!isset($tab_index) || empty($tab_index)) ? 0 : $tab_index;
		$data = array('tab_index' => $tab_index);
		$this->view('admin/expert/custom_order',$data);
	}

	//回复方案
	public function reply_project() {
		$post_arr = array();
		$post_trip_arr = array();
		$supplier_reply_arr = array();
		$choose_reply_id = array();
		$ca_id = $this->input->get('ca_id',true);
		$reply_again = $this->input->get('reply_again',true);
		$ca_id = (!empty($ca_id) && $ca_id!='null') ? $ca_id: -1;

		$c_id = $this->input->get('c_id',true);
		$post_trip_arr['cj.customize_answer_id']  = $ca_id;
		$custom_info = $this->grab_custom_order->get_one_customize($c_id);
		$supplier_reply = $this->grab_custom_order->get_supplier_reply($c_id, $this->expert_id);
		$custom_trip_data_list = $this->grab_custom_order->get_customize_trip($post_trip_arr);

		$supplier_reply_count = count($supplier_reply);
		if(!empty($supplier_reply) ){
			for($i=0; $i<$supplier_reply_count; $i++){
				if(!empty($supplier_reply[$i]['c_eg_id']) && $supplier_reply[$i]['c_eg_id']!=0 && $supplier_reply[$i]['ca_status']==1){
					$supplier_reply_data = $this->grab_custom_order->get_supplier_reply_detail($supplier_reply[$i]['c_eg_id']);
					$supplier_reply_arr[$supplier_reply[$i]['eg_title']] = $supplier_reply_data[0];
					$choose_reply_id[] = $supplier_reply[$i]['c_eg_id'];
				}
			}
		}
		$expert_baojia = $this->grab_custom_order->get_expert_price($ca_id,$this->expert_id);
		if(isset($reply_again) && $reply_again==1 && !empty($custom_trip_data_list) && !empty($custom_trip_data_list[0]['replytime'])){
			//如果是1就是再次发单;2是不是再次发单
			$ca_id=-1;
		}
		$data = array(
			'expert_id'=>$this->expert_id,
			'max_day'=>$custom_info[0]['days'],
			'now_date' => date('Y-m-d H:i:s'),
			'ca_id'=>$ca_id,
			'c_id'=>$c_id,
			'custom_info'=>$custom_info[0],
			'supplier_reply'=>$supplier_reply,
			'custom_trip_data_list'=>$custom_trip_data_list,
			'supplier_reply_arr'=>$supplier_reply_arr,
			'choose_reply_id'=>$choose_reply_id,
			'reply_again'=>$reply_again
			);

		if(!empty($expert_baojia)){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array('price'=>0,'childprice'=>0,'childnobedprice'=>0,'oldprice'=>0,'price_description'=>'','plan_design'=>'','ca_title'=>'');
		}

		if(isset($reply_again) && $reply_again==1){
			
			$this->view('admin/expert/reply_project',$data);
		}else{
			$this->view('admin/expert/simple_reply_project',$data);
		}

	}



	//查看回复方案
	public function show_reply_project() {
		$post_arr = array();
		$post_trip_arr = array();
		$ca_id = $this->input->get('ca_id',true);
		$e_id = $this->input->get('e_id',true);
		$ca_id = (!empty($ca_id) && $ca_id!='null') ? $ca_id: -1;
		$e_id = (!empty($e_id) && $e_id!='null') ? $e_id: -1;
		$c_id = $this->input->get('c_id',true);
		$post_trip_arr['cj.customize_answer_id']  = $ca_id;
		$grab_custom_data = $this->grab_custom_order->get_one_customize($c_id);
		$expert_custom_data = $this->grab_custom_order->get_expert_custom($c_id, $this->expert_id);
		$custom_trip_data_list = $this->grab_custom_order->get_customize_trip($post_trip_arr);
		$expert_baojia = $this->grab_custom_order->get_expert_price($ca_id,$this->expert_id);
		$data = array(
			'expert_id'=>$this->expert_id,
			'ca_id'=>$ca_id,
			'c_id'=>$c_id,
			'e_id'=>$e_id,
			'custom_trip_data_list'=>$custom_trip_data_list
		);
		if(!empty($expert_custom_data)){
			$data['grab_custom_data'] = $expert_custom_data[0];
		}else{
			$data['grab_custom_data'] = $grab_custom_data[0];
		}
		if(!empty($expert_baojia)){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array('price'=>0,'childprice'=>0,'childnobedprice'=>0,'oldprice'=>0,'price_description'=>'','plan_design'=>'','ca_title'=>'');
		}
		$this->view('admin/expert/show_reply_project',$data);
	}
	//转询价单
	public function turn_inquiry_sheet() {
		$post_arr = array();
		$post_trip_arr = array();
		$ca_id = $this->input->get('ca_id',true);
		$e_id = $this->input->get('e_id',true);
		$ca_id = (!empty($ca_id) && $ca_id!='null') ? $ca_id: -1;
		$e_id = (!empty($e_id) && $e_id!='null') ? $e_id: -1;
		$c_id = $this->input->get('c_id',true);
		$post_trip_arr['cj.customize_answer_id']  = $ca_id;
		$grab_custom_data = $this->grab_custom_order->get_one_customize($c_id);

		$expert_custom_data = $this->grab_custom_order->get_expert_custom($e_id);
		//var_dump($this->db->last_query());exit();
		$custom_trip_data_list = $this->grab_custom_order->get_customize_trip($post_trip_arr);
		$expert_baojia = $this->grab_custom_order->get_expert_price($ca_id);
		$this->load_model ( 'common/u_dictionary_model', 'dictionary_model' );
		//出游方式
		$trip_way = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_TRIP_TYPE);
		//单项服务
		$choose = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_ANOTHER_CHOOSE);
		//酒店星级
		$hotel = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_HOTEL_STAR);
		//购物自费项目
		$shopping = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_SHOPPING);
		//用餐要求
		$catering= $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_CATERING);
		//用房要求
		$room = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_ROOM_REQUIRE);
		$this->load_model ( 'common/u_supplier_model', 'supplier_model' );
		//$supplier = $this ->supplier_model ->all();
		$data = array(
			'trip_way' =>$trip_way,
			'choose' =>$choose,
			'hotel' =>$hotel,
			'shopping' =>$shopping,
			'catering' =>$catering,
			'room' =>$room,
			//'supplier'=>$supplier,
			'expert_id'=>$this->expert_id,
			'ca_id'=>$ca_id,
			'c_id'=>$c_id,
			'e_id'=>$e_id,
			//'grab_custom_data'=>$grab_custom_data[0],
			'custom_trip_data_list'=>$custom_trip_data_list
			);

		if(!empty($expert_custom_data)){
			$data['expert_c_id'] = $expert_custom_data[0]['c_expert_id'];
			$data['grab_custom_data'] = $expert_custom_data[0];
		}else{
			$data['expert_c_id'] = '-1';
			$data['grab_custom_data'] = $grab_custom_data[0];
		}
		if(!empty($expert_baojia)){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array('price'=>0,'childprice'=>0,'childnobedprice'=>0,'oldprice'=>0,'old_people_price'=>0,'price_description'=>'','plan_design'=>'','ca_title'=>'');
		}
		//var_dump($grab_custom_data);exit();
		$this->view('admin/expert/turn_inquiry_sheet',$data);
	}



	//查看询价单
	public function show_turn_inquiry() {
		$post_arr = array();
		$post_trip_arr = array();
		$ca_id = $this->input->get('ca_id',true);
		$e_id = $this->input->get('e_id',true);
		$ca_id = (!empty($ca_id) && $ca_id!='null') ? $ca_id: -1;
		$c_id = $this->input->get('c_id',true);
		$post_trip_arr['cj.customize_answer_id']  = $ca_id;
		$grab_custom_data = $this->grab_custom_order->get_one_customize($c_id);
		$expert_custom_data = $this->grab_custom_order->get_expert_custom($e_id);
		$custom_trip_data_list = $this->grab_custom_order->get_customize_trip($post_trip_arr);
		$expert_baojia = $this->grab_custom_order->get_enqury_price($e_id);
		$data = array(
			'expert_id'=>$this->expert_id,
			'ca_id'=>$ca_id,
			'c_id'=>$c_id,
			'custom_trip_data_list'=>$custom_trip_data_list
		);
		if(!empty($expert_custom_data)){
			$data['grab_custom_data'] = $expert_custom_data[0];
		}else{
			$data['grab_custom_data'] = $grab_custom_data[0];
		}
		//var_dump($expert_baojia);exit();
		if(!empty($expert_baojia)){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array('price'=>0,'childprice'=>0,'childnobedprice'=>0,'oldprice'=>0,'price_description'=>'','plan_design'=>'','ca_title'=>'');
		}
		$this->view('admin/expert/show_turn_inquiry',$data);
	}

	//抢单列表数据
	public function ajax_grab_order(){
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 15 : $number;
        	$page = empty($page) ? 1 : $page;
		$reply_list = $this->grab_custom_order->get_grab_custom_list( $page, $number,$this->expert_id);
		//print_r($this->db->last_query());exit();
		$pagecount = $this->grab_custom_order->get_grab_custom_list(0,10,$this->expert_id);

		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $reply_list,
	               	"SQL" => $this->db->last_query()
            		);
		echo json_encode($data);
	}
	//Ajax列出已投标的数据的控制器
	public function ajax_reply_order(){
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 15 : $number;
        	$page = empty($page) ? 1 : $page;
		$reply_list = $this->grab_custom_order->get_reply_list( $page, $number,$this->expert_id);
		$pagecount = $this->grab_custom_order->get_reply_list(0,10,$this->expert_id);
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $reply_list
            		);
		echo json_encode($data);
	}

	//Ajax列出已中标的数据的控制器
	public function ajax_bid_order(){
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 15 : $number;
        	$page = empty($page) ? 1 : $page;
		$grab_order_list = $this->grab_custom_order->get_grab_order($page, $number,$this->expert_id);
		$pagecount = $this->grab_custom_order->get_grab_order(0,10,$this->expert_id);
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
	           	 } else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
	            	}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $grab_order_list
           	 	);
		//print_r($grab_order_list);exit();
		echo json_encode($data);
	}

	//Ajax列出已过期的数据
	function ajax_expired_order(){
		$post_arr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 15 : $number;
        	$page = empty($page) ? 1 : $page;
		$expired_order_list = $this->grab_custom_order->get_expired_order($post_arr, $page, $number);
		$pagecount = $this->grab_custom_order->get_expired_order($post_arr,0,10);
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
           	 	} else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
            		}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $expired_order_list
            	);
		echo json_encode($data);
	}

	//Ajax列出已回复的数据
	function ajax_replyed_order(){
		$post_arr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 15 : $number;
        	$page = empty($page) ? 1 : $page;
		$replyed_order_list = $this->grab_custom_order->get_replyed_order($post_arr, $page, $number,$this->expert_id);
		$pagecount = $this->grab_custom_order->get_replyed_order($post_arr,0,10,$this->expert_id);
		$this->db->close();
		 if (($total = $pagecount - $pagecount % $number) / $number == 0) {
               		 $total = 1;
           	 	} else {
	                	$total = ($pagecount - $pagecount % $number) / $number;
	                		if ($pagecount % $number > 0) {
	                    			$total +=1;
	                		}
            		}
		$data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                	"pageNum" => $page,
	                	"pageSize" => $number,
	               	"rows" => $replyed_order_list
            	);
		echo json_encode($data);
	}


	//获取供应商数据的详情
	function ajax_get_supplier_reply(){
		$eg_id = $this->input->post('eg_id');
		$supplier_reply_detail = $this->grab_custom_order->get_supplier_reply_detail($eg_id);
		echo json_encode(array('status'=>200,'msg'=>$supplier_reply_detail));
	}

	//转询价单操作
	function turn_inquiry(){
		$replay_data = $this->security->xss_clean($_POST);
		$custom_arr = array();
		$travel_title_arr = $replay_data['travel_title'];
		$travel_content_arr = $replay_data['travel_content'];
		$pics_url_arr = $replay_data['pics_url'];
		$breakfirst_arr = $replay_data['breakfirst'];
		$lunch_arr = $replay_data['lunch'];
		$supper_arr = $replay_data['supper'];
		$traffic_arr = $replay_data['traffic'];
		$hotel_arr = $replay_data['hotel'];
		$price_decription = trim($replay_data['price_description']);
		$ca_title  = trim($replay_data['ca_title']);

		$travel_title_arr_count = count($travel_title_arr);
		for($k=0;$k<$travel_title_arr_count;$k++){
			$num = $k+1;
			if(isset($replay_data['breakfirsthas'][$num]) && $replay_data['breakfirsthas'][$num]!=''){
			   $breakfirsthas_arr[$k] = $replay_data['breakfirsthas'][$num];
			 }else{
		 	   $breakfirsthas_arr[$k] = 0;
			}

			if(isset($replay_data['supperhas'][$num]) && $replay_data['supperhas'][$num]!=''){
			   $supperhas_arr[$k] = $replay_data['supperhas'][$num];
			 }else{
		 	   $supperhas_arr[$k] = 0;
			}

			if(isset($replay_data['lunchhas'][$num]) && $replay_data['lunchhas'][$num]!=''){
			   $lunchhas_arr[$k] = $replay_data['lunchhas'][$num];
			 }else{
		 	   $lunchhas_arr[$k] = 0;
			}
		}
		if(empty($price_decription)){
			echo json_encode(array('status'=>-304,'msg'=>'方案推荐必填'));
			exit();
		}

		if(!empty($replay_data['price'])){
			if(!is_numeric($replay_data['price'])){
				echo json_encode(array('status'=>-300,'msg'=>'成人价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['childprice'])){
			if(!is_numeric($replay_data['childprice'])){
				echo json_encode(array('status'=>-301,'msg'=>'占床小孩价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['childnobedprice'])){
			if(!is_numeric($replay_data['childnobedprice'])){
				echo json_encode(array('status'=>-302,'msg'=>'不占床小孩价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['oldprice'])){
			if(!is_numeric($replay_data['oldprice'])){
				echo json_encode(array('status'=>-303,'msg'=>'老人价格必须是数字'));
				exit();
			}
		}


		$custom_arr['startplace'] = $replay_data['startcityId'];
		/*$custom_arr['custom_type'] = $replay_data['destOne'];
		$dest_three = rtrim($replay_data['expert_dest_id'],',');
		if(!empty($dest_three)){
			$custom_arr['endplace']  = $replay_data['destTwoId'].','.$dest_three;
		}else{
			$custom_arr['endplace']  = $replay_data['destTwoId'];
		}*/
		
		$custom_arr['endplace'] = $replay_data['endplace'];
		
		$custom_arr['trip_way'] = $replay_data['trip_way'];
		$custom_arr['another_choose'] = $replay_data['choose_one'];
		$custom_arr['startdate'] = $replay_data['startdate'];
		$custom_arr['estimatedate'] = $replay_data['estimatedate'];
		$custom_arr['budget'] = $replay_data['budget'];
		$custom_arr['days'] = $replay_data['days'];
		$custom_arr['hotelstar'] = $replay_data['hotel_star'];
		$custom_arr['catering'] = $replay_data['catering'];
		$custom_arr['room_require'] = $replay_data['room_require'];
		$custom_arr['isshopping'] = $replay_data['shopping'];
		$custom_arr['service_range'] = $replay_data['service_range'];
		$custom_arr['total_people'] = $replay_data['total_people'];
		$custom_arr['roomnum'] = $replay_data['roomnum'];
		$custom_arr['people'] = 0;//$replay_data['people'];
		$custom_arr['childnum'] = 0;//$replay_data['childnum'];
		$custom_arr['childnobednum'] = 0;//$replay_data['childnobednum'];
		$custom_arr['oldman'] = 0;//$replay_data['oldman'];
		$custom_arr['addtime'] = date('Y-m-d H:i:s');
		$custom_arr['customize_id'] = $replay_data['customize_id'];
		$custom_arr['expert_id'] = $this->expert_id;
		//开始事务处理
		$this->db->trans_begin();
		$c_expert_id = $this->grab_custom_order->update_custom($custom_arr,$replay_data['customize_id'],$this->expert_id,$replay_data['expert_c_id']);

		if(!isset($replay_data['ca_id']) || empty($replay_data['ca_id']) || $replay_data['ca_id']==-1){
			$insert_data = array(
				'expert_id'=>$this->expert_id,
				'customize_id'=>$replay_data['customize_id'],
				'plan_design'=>$replay_data['plan_design'],
				'isuse'=>0,
				'title'=>$replay_data['ca_title'],
				'addtime'=>date('Y-m-d H:i:s'),
				'childprice'=> 0,//$replay_data['childprice'],
				'childnobedprice'=>0,//$replay_data['childnobedprice'],
				'price'=> 0,//$replay_data['price'],
				'oldprice'=>0, //$replay_data['oldprice'],
				'price_description'=>$price_decription
			);
			//判断是暂存还是提交
			/*if($replay_data['submit_type']==2 && !empty($ca_title)){
				$insert_data['replytime'] = date('Y-m-d H:i:s');
			}*/
			$status = $this ->db ->insert('u_customize_answer',$insert_data);
			$customize_answer_id = $this->db->insert_id();
			if($status){
				for ($i=0;$i<$travel_title_arr_count;$i++) {
					$insert_data_js['customize_answer_id'] =$customize_answer_id;
					$insert_data_js['day'] = $i+1;
					$insert_data_js['title'] = $travel_title_arr[$i];
					$insert_data_js['transport'] = $traffic_arr[$i];
					$insert_data_js['hotel'] = $hotel_arr[$i];
					$insert_data_js['breakfirsthas'] = $breakfirsthas_arr[$i];
					$insert_data_js['breakfirst'] = $breakfirst_arr[$i+1];
					$insert_data_js['lunchhas'] = $lunchhas_arr[$i];
					$insert_data_js['lunch'] = $lunch_arr[$i+1];
					$insert_data_js['supperhas'] = $supperhas_arr[$i];
					$insert_data_js['supper'] = $supper_arr[$i+1];
					$insert_data_js['jieshao'] = $travel_content_arr[$i];
					//插入图片表
					$insert_data_pic['pic'] = $pics_url_arr[$i];
					$insert_data_pic['addtime'] = date('Y-m-d H:i:s');
					//这四项不填时不让插入表中
					$this ->db ->insert('u_customize_jieshao',$insert_data_js);
					$insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					$this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);
				}
			}else{
				echo json_encode(array('status' =>-9 ,'msg' =>'操作失败'));
				exit();
			}
		}else{
			$update_data = array(
				'plan_design'=>$replay_data['plan_design'],
				'title'=>$replay_data['ca_title'],
				//'childprice'=>$replay_data['childprice'],
				//'childnobedprice'=>$replay_data['childnobedprice'],
				//'price'=> $replay_data['price'],
				//'oldprice'=>$replay_data['oldprice'],
				'price_description'=>$price_decription
			);
			//判断是暂存还是提交
			/*if($replay_data['submit_type']==2 && !empty($ca_title)){
				$update_data['replytime'] = date('Y-m-d H:i:s');
			}*/
			$status = $this ->db ->update('u_customize_answer',$update_data,array('id'=>$replay_data['ca_id']));
			if($status){
				$update_arr_count = count($replay_data['cj_id']);
				for ($i=0;$i<$update_arr_count;$i++) {
					$update_data_js['customize_answer_id'] =$replay_data['ca_id'];
					$update_data_js['day'] = $i+1;
					$update_data_js['title'] = $travel_title_arr[$i];
					$update_data_js['transport'] = $traffic_arr[$i];
					$update_data_js['hotel'] = $hotel_arr[$i];
					$update_data_js['breakfirsthas'] = $breakfirsthas_arr[$i];
					$update_data_js['breakfirst'] = $breakfirst_arr[$i+1];
					$update_data_js['lunchhas'] = $lunchhas_arr[$i];
					$update_data_js['lunch'] = $lunch_arr[$i+1];
					$update_data_js['supperhas'] = $supperhas_arr[$i];
					$update_data_js['supper'] = $supper_arr[$i+1];
					$update_data_js['jieshao'] = $travel_content_arr[$i];
					$update_data_pic['pic'] = $pics_url_arr[$i];
					$update_data_pic['addtime'] = date('Y-m-d H:i:s');
					//这四项不填时不让插入表中
					  $this ->db ->update('u_customize_jieshao',$update_data_js,array('id'=>$replay_data['cj_id'][$i]));
					   $update_data_pic['pic'] = $pics_url_arr[$i];
					   $this ->db ->update('u_customize_jieshao_pic',$update_data_pic,array('id'=>$replay_data['pic_id'][$i]));

				}
				//动态增加的天数行程
				for ($k=$update_arr_count;$k<$travel_title_arr_count;$k++) {
					$insert_data_js['customize_answer_id'] =$replay_data['ca_id'];
					$insert_data_js['day'] = $k+1;
					$insert_data_js['title'] = $travel_title_arr[$k];
					$insert_data_js['transport'] = $traffic_arr[$k];
					$insert_data_js['breakfirsthas'] = $breakfirsthas_arr[$k];
					$insert_data_js['breakfirst'] = $breakfirst_arr[$k+1];
					$insert_data_js['lunchhas'] = $lunchhas_arr[$k];
					$insert_data_js['lunch'] = $lunch_arr[$k+1];
					$insert_data_js['supperhas'] = $supperhas_arr[$k];
					$insert_data_js['supper'] = $supper_arr[$k+1];
					$insert_data_js['jieshao'] = $travel_content_arr[$k];
					$this ->db ->insert('u_customize_jieshao',$insert_data_js);
					$insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					$insert_data_pic['pic'] = $pics_url_arr[$k];
					$insert_data_pic['addtime'] = date('Y-m-d H:i:s');
					$this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);
				}
			}else{
				echo json_encode(array('status' =>-8 ,'msg' =>'操作失败'));
				exit();
			}
		}

			$insert_inquiry_data['customize_id'] = $replay_data['customize_id'];
			$insert_inquiry_data['expert_id'] = $this->expert_id;
			$insert_inquiry_data['addtime'] = date('Y-m-d H:i:s');
			//$insert_inquiry_data['status'] = 1;  //是暂存还是确认发单
			$insert_inquiry_data['status'] = $replay_data['submit_type'];
			$insert_inquiry_data['price'] = $replay_data['price'];
			$insert_inquiry_data['childprice'] = $replay_data['childprice'];
			$insert_inquiry_data['childnobedprice'] = $replay_data['childnobedprice'];
			$insert_inquiry_data['oldprice'] = $replay_data['oldprice'];

			$insert_inquiry_data['is_assign'] = 0;
			/*if($replay_data['supplier_id']==""){
				$insert_inquiry_data['is_assign'] = 0;
			}else{
				$insert_inquiry_data['is_assign'] = 1;
				$insert_inquiry_data['supplier_id'] = $replay_data['supplier_id'];
			}*/
			if(!empty($replay_data['e_id']) && $replay_data['e_id']!=-1){
				$this->db->update('u_enquiry',$insert_inquiry_data,array('id'=>$replay_data['e_id']));
			}else{
				if(!isset($replay_data['ca_id']) || empty($replay_data['ca_id']) || $replay_data['ca_id']==-1){
					$insert_inquiry_data['customize_answer_id'] = $customize_answer_id;
				}else{
					$insert_inquiry_data['customize_answer_id'] = $replay_data['ca_id'];
				}
				$this->db->insert('u_enquiry',$insert_inquiry_data);
				$new_inquiery_id = $this->db->insert_id();
				$this->db->update('u_customize_expert',array('enquiry_id'=>$new_inquiery_id),array('id'=>$c_expert_id));
			}
			if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array("status"=>200,"msg"=>"确定成功"));
			}else{
				$this->db->trans_rollback();
				echo json_encode(array("status"=>-3,"msg"=>"操作失败"));
			}

	}


	//回复方案操作
	function grab_custom_reply(){
		$is_submit = false;   //判断是否提交还是暂存
		$nickname = $this->session->userdata('nickname');
		$replay_data = $this->security->xss_clean($_POST);
		$message = $this->grab_custom_order->get_msg_template('customize_answer',$nickname);

		$travel_title_arr = $replay_data['travel_title'];
		$travel_content_arr = $replay_data['travel_content'];
		$pics_url_arr = $replay_data['pics_url'];
		$breakfirst_arr = $replay_data['breakfirst'];
		$lunch_arr = $replay_data['lunch'];
		$supper_arr = $replay_data['supper'];
		$traffic_arr = $replay_data['traffic'];
		$hotel_arr = $replay_data['hotel'];
		$price_decription = trim($replay_data['price_decription']);
		$choose_reply_arr = $this->grab_custom_order->is_choose_supply($replay_data['customize_id']);
		if(empty($price_decription)){
			echo json_encode(array('status'=>-304,'msg'=>'方案推荐必填'));
			exit();
		}

		$travel_title_arr_count = count($travel_title_arr);
		for($k=0;$k<$travel_title_arr_count;$k++){
			$num = $k+1;
			if(isset($replay_data['breakfirsthas'][$num]) && $replay_data['breakfirsthas'][$num]!=''){
			   $breakfirsthas_arr[$k] = $replay_data['breakfirsthas'][$num];
			 }else{
		 	   $breakfirsthas_arr[$k] = 0;
			}

			if(isset($replay_data['supperhas'][$num]) && $replay_data['supperhas'][$num]!=''){
			   $supperhas_arr[$k] = $replay_data['supperhas'][$num];
			 }else{
		 	   $supperhas_arr[$k] = 0;
			}

			if(isset($replay_data['lunchhas'][$num]) && $replay_data['lunchhas'][$num]!=''){
			   $lunchhas_arr[$k] = $replay_data['lunchhas'][$num];
			 }else{
		 	   $lunchhas_arr[$k] = 0;
			}
		}


		if(!empty($replay_data['people_price'])){
			if(!is_numeric($replay_data['people_price'])){
				echo json_encode(array('status'=>-300,'msg'=>'成人价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['child_bed_price'])){
			if(!is_numeric($replay_data['child_bed_price'])){
				echo json_encode(array('status'=>-301,'msg'=>'占床小孩价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['child_no_bed_price'])){
			if(!is_numeric($replay_data['child_no_bed_price'])){
				echo json_encode(array('status'=>-302,'msg'=>'不占床小孩价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['old_people_price'])){
			if(!is_numeric($replay_data['old_people_price'])){
				echo json_encode(array('status'=>-303,'msg'=>'老人价格必须是数字'));
				exit();
			}
		}
		//开始事物处理
		//$this->db->trans_begin();
		//选择供应商方案回复给客人
		      if(!empty($replay_data['supply_id'])){

		      	$supplier_reply_arr = array();
		      	$supplier_reply_arr = explode(',',rtrim($replay_data['supply_id'],','));
			$s_reply_count = count($supplier_reply_arr);
			for($i=0; $i<$s_reply_count; $i++){
				if(empty($choose_reply_arr['s_reply_id']) || !in_array($supplier_reply_arr[$i],$choose_reply_arr['s_reply_id'])){

					$insert_data = array(
					'expert_id'=>$this->expert_id,
					'customize_id'=>$replay_data['customize_id'],
					'plan_design'=>$replay_data['travel_description'],
					'isuse'=>0,
					'addtime'=>date('Y-m-d H:i:s'),
					'childprice'=>$replay_data['child_bed_price'],
					'childnobedprice'=>$replay_data['child_no_bed_price'],
					'price'=> $replay_data['people_price'],
					'oldprice'=>$replay_data['old_people_price'],
					'price_description'=>$replay_data['price_decription'],
					'enquiry_grab_id'=>$supplier_reply_arr[$i],
					'status'=>1
					);
					if($replay_data['submit_type']==1){
						$insert_data['replytime'] = date('Y-m-d H:i:s');
					}
					$this->grab_custom_order->insert_reply_from_supplier($insert_data,$supplier_reply_arr[$i]);
				}else{
					if($replay_data['submit_type']==1){
						$is_submit = true;
					}
					$this->grab_custom_order->update_supplier_reply($choose_reply_arr['s_ca_id'][$i],$is_submit);
				}

			}
		    }elseif(empty($replay_data['supply_id']) && !empty($choose_reply_arr['s_reply_id'])){
		    	$s_reply_count = count($choose_reply_arr['s_reply_id']);
		    	if($replay_data['submit_type']==1){
				$is_submit = true;
			}
		    	for($i=0; $i<$s_reply_count; $i++){
		    	  $this->grab_custom_order->update_supplier_reply($choose_reply_arr['s_ca_id'][$i],$is_submit);
		    	}
		    }


		if(!isset($replay_data['ca_id']) || empty($replay_data['ca_id']) || $replay_data['ca_id']==-1){
			$insert_data = array(
				'expert_id'=>$this->expert_id,
				'customize_id'=>$replay_data['customize_id'],
				'plan_design'=>$replay_data['travel_description'],
				'isuse'=>0,
				'title'=>$replay_data['plan_name'],
				'addtime'=>date('Y-m-d H:i:s'),
				'childprice'=>$replay_data['child_bed_price'],
				'childnobedprice'=>$replay_data['child_no_bed_price'],
				'price'=> $replay_data['people_price'],
				'oldprice'=>$replay_data['old_people_price'],
				'price_description'=>$replay_data['price_decription'],
				'status'=>1
			);
			//判断是暂存还是提交
			if($replay_data['submit_type']==1 && !empty($replay_data['plan_name'])){
				$insert_data['replytime'] = date('Y-m-d H:i:s');
				//发短信给客人
				//$this->send_message($replay_data['linkphone'],$message);
			}
			$status = $this ->db ->insert('u_customize_answer',$insert_data);
			$customize_answer_id = $this->db->insert_id();
			//先简单回复, 在回复方案的时候, 需要把简单回复表的anwser_id带上去
			//$this->db->update('u_customize_reply',);
			$this->db->update('u_customize_reply', array('answer_id'=>$customize_answer_id), array('customize_id'=>$replay_data['customize_id'],'expert_id'=>$this->expert_id));
			if($status){
				for ($i=0;$i<$travel_title_arr_count;$i++) {
					$insert_data_js['customize_answer_id'] =$customize_answer_id;
					$insert_data_js['day'] = $i+1;
					//$insert_data_js['day'] = $i+1;
					$insert_data_js['title'] = $travel_title_arr[$i];
					$insert_data_js['transport'] = $traffic_arr[$i];
					$insert_data_js['hotel'] = $hotel_arr[$i];
					$insert_data_js['breakfirsthas'] = $breakfirsthas_arr[$i];
					$insert_data_js['breakfirst'] = $breakfirst_arr[$i+1];
					$insert_data_js['lunchhas'] = $lunchhas_arr[$i];
					$insert_data_js['lunch'] = $lunch_arr[$i+1];
					$insert_data_js['supperhas'] = $supperhas_arr[$i];
					$insert_data_js['supper'] = $supper_arr[$i+1];
					$insert_data_js['jieshao'] = $travel_content_arr[$i];
					//插入图片表
					$insert_data_pic['pic'] = $pics_url_arr[$i];
					$insert_data_pic['addtime'] = date('Y-m-d H:i:s');
					//这四项不填时不让插入表中
					if($insert_data_js['title']!='' || $insert_data_js['transport']!='' || $insert_data_js['jieshao']!='' || $insert_data_pic['pic']!=''){
					  $this ->db ->insert('u_customize_jieshao',$insert_data_js);
					  $insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					  $this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);
					}
				}
			}else{
				echo json_encode(array('status' =>-9 ,'msg' =>'操作失败'));
				exit();
			}
		}else{
			$update_data = array(
				'plan_design'=>$replay_data['travel_description'],
				'title'=>$replay_data['plan_name'],
				'isuse'=>0,
				'childprice'=>$replay_data['child_bed_price'],
				'childnobedprice'=>$replay_data['child_no_bed_price'],
				'price'=> $replay_data['people_price'],
				'oldprice'=>$replay_data['old_people_price'],
				'price_description'=>$replay_data['price_decription']
			);
			//判断是暂存还是提交
			if($replay_data['submit_type']==1 && !empty($replay_data['plan_name'])){
				$update_data['replytime'] = date('Y-m-d H:i:s');
				//发短信给客人
				//$this->send_message($replay_data['linkphone'],$message);
			}
			$status = $this ->db ->update('u_customize_answer',$update_data,array('id'=>$replay_data['ca_id']));
			if($status){
				$update_arr_count = count($replay_data['cj_id']);
				for ($i=0;$i<$update_arr_count;$i++) {
					$update_data_js['customize_answer_id'] =$replay_data['ca_id'];
					$update_data_js['day'] = $i+1;
					$update_data_js['title'] = $travel_title_arr[$i];
					$update_data_js['transport'] = $traffic_arr[$i];
					$update_data_js['hotel'] = $hotel_arr[$i];
					$update_data_js['breakfirsthas'] = $breakfirsthas_arr[$i];
					$update_data_js['breakfirst'] = $breakfirst_arr[$i+1];
					$update_data_js['lunchhas'] = $lunchhas_arr[$i];
					$update_data_js['lunch'] = $lunch_arr[$i+1];
					$update_data_js['supperhas'] = $supperhas_arr[$i];
					$update_data_js['supper'] = $supper_arr[$i+1];
					$update_data_js['jieshao'] = $travel_content_arr[$i];
					$update_data_pic['pic'] = $pics_url_arr[$i];
					$update_data_pic['addtime'] = date('Y-m-d H:i:s');
					//这四项不填时不让插入表中
					if($update_data_js['title']!='' || $update_data_js['transport']!='' || $update_data_js['jieshao']!='' ){
					  $this ->db ->update('u_customize_jieshao',$update_data_js,array('id'=>$replay_data['cj_id'][$i]));
					   $update_data_pic['pic'] = $pics_url_arr[$i];
					   $this ->db ->update('u_customize_jieshao_pic',$update_data_pic,array('id'=>$replay_data['pic_id'][$i]));
					}
				}
				//动态增加的天数行程
				for ($k=$update_arr_count;$k<$travel_title_arr_count;$k++) {
					$insert_data_js['customize_answer_id'] =$replay_data['ca_id'];
					$insert_data_js['day'] = $k+1;
					$insert_data_js['title'] = $travel_title_arr[$k];
					$insert_data_js['transport'] = $traffic_arr[$k];
					$insert_data_js['breakfirsthas'] = $breakfirsthas_arr[$k];
					$insert_data_js['breakfirst'] = $breakfirst_arr[$k+1];
					$insert_data_js['lunchhas'] = $lunchhas_arr[$k];
					$insert_data_js['lunch'] = $lunch_arr[$k+1];
					$insert_data_js['supperhas'] = $supperhas_arr[$k];
					$insert_data_js['supper'] = $supper_arr[$k+1];
					$insert_data_js['jieshao'] = $travel_content_arr[$k];
					$this ->db ->insert('u_customize_jieshao',$insert_data_js);
					$insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					$insert_data_pic['pic'] = $pics_url_arr[$k];
					$insert_data_pic['addtime'] = date('Y-m-d H:i:s');
					$this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);
				}
			}else{
				echo json_encode(array('status' =>-8 ,'msg' =>'操作失败'));
				exit();
			}
		}

		//判断是否是提交,如果是提交的话,并且选择了供应商方案直接作为选择中标的方案
		if($replay_data['submit_type']==1){
			if(isset($replay_data['choose_supplier_plan']) && !empty($replay_data['choose_supplier_plan']) ){
				$this->grab_custom_order->choose_supplier($replay_data['choose_supplier_plan']);
			}
		}
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array('status' =>1 ,'msg' =>'操作成功'));
			}else{
				$this->db->trans_rollback();
				echo json_encode(array('status' =>-7 ,'msg' =>'操作失败'));
				exit();
			}
	}


		//回复方案操作
	function grab_simple_reply(){
		$is_submit = false;   //判断是否提交还是暂存
		$nickname = $this->session->userdata('nickname');
		$replay_data = $this->security->xss_clean($_POST);
		$message = $this->grab_custom_order->get_msg_template('customize_answer',$nickname);

		$travel_title_arr = $replay_data['travel_title'];
		$travel_content_arr = $replay_data['travel_content'];
		$pics_url_arr = $replay_data['pics_url'];
		$breakfirst_arr = $replay_data['breakfirst'];
		$lunch_arr = $replay_data['lunch'];
		$supper_arr = $replay_data['supper'];
		$traffic_arr = $replay_data['traffic'];
		$hotel_arr = $replay_data['hotel'];
		$price_decription = trim($replay_data['price_decription']);
		$simple_aws =  trim($replay_data['simple_aws']);
		$is_simple = $replay_data['is_simple'];
		$customize_answer_id = 0;
		$choose_reply_arr = $this->grab_custom_order->is_choose_supply($replay_data['customize_id']);
		/*if(empty($price_decription)){
			echo json_encode(array('status'=>-304,'msg'=>'方案推荐必填'));
			exit();
		}*/

		if(empty($simple_aws)){
			echo json_encode(array('status'=>-304,'msg'=>'简单回复必填'));
			exit();
		}

		if($is_simple==2){
		$travel_title_arr_count = count($travel_title_arr);
		for($k=0;$k<$travel_title_arr_count;$k++){
			$num = $k+1;
			if(isset($replay_data['breakfirsthas'][$num]) && $replay_data['breakfirsthas'][$num]!=''){
			   $breakfirsthas_arr[$k] = $replay_data['breakfirsthas'][$num];
			 }else{
		 	   $breakfirsthas_arr[$k] = 0;
			}

			if(isset($replay_data['supperhas'][$num]) && $replay_data['supperhas'][$num]!=''){
			   $supperhas_arr[$k] = $replay_data['supperhas'][$num];
			 }else{
		 	   $supperhas_arr[$k] = 0;
			}

			if(isset($replay_data['lunchhas'][$num]) && $replay_data['lunchhas'][$num]!=''){
			   $lunchhas_arr[$k] = $replay_data['lunchhas'][$num];
			 }else{
		 	   $lunchhas_arr[$k] = 0;
			}
		}


		if(!empty($replay_data['people_price'])){
			if(!is_numeric($replay_data['people_price'])){
				echo json_encode(array('status'=>-300,'msg'=>'成人价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['child_bed_price'])){
			if(!is_numeric($replay_data['child_bed_price'])){
				echo json_encode(array('status'=>-301,'msg'=>'占床小孩价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['child_no_bed_price'])){
			if(!is_numeric($replay_data['child_no_bed_price'])){
				echo json_encode(array('status'=>-302,'msg'=>'不占床小孩价格必须是数字'));
				exit();
			}
		}
		if(!empty($replay_data['old_people_price'])){
			if(!is_numeric($replay_data['old_people_price'])){
				echo json_encode(array('status'=>-303,'msg'=>'老人价格必须是数字'));
				exit();
			}
		}
		//开始事物处理
		//$this->db->trans_begin();
		//选择供应商方案回复给客人
		      if(!empty($replay_data['supply_id'])){

		      	$supplier_reply_arr = array();
		      	$supplier_reply_arr = explode(',',rtrim($replay_data['supply_id'],','));
			$s_reply_count = count($supplier_reply_arr);
			for($i=0; $i<$s_reply_count; $i++){
				if(empty($choose_reply_arr['s_reply_id']) || !in_array($supplier_reply_arr[$i],$choose_reply_arr['s_reply_id'])){

					$insert_data = array(
					'expert_id'=>$this->expert_id,
					'customize_id'=>$replay_data['customize_id'],
					'plan_design'=>$replay_data['travel_description'],
					'isuse'=>0,
					'addtime'=>date('Y-m-d H:i:s'),
					'childprice'=>$replay_data['child_bed_price'],
					'childnobedprice'=>$replay_data['child_no_bed_price'],
					'price'=> $replay_data['people_price'],
					'oldprice'=>$replay_data['old_people_price'],
					'price_description'=>$replay_data['price_decription'],
					'enquiry_grab_id'=>$supplier_reply_arr[$i],
					'status'=>1
					);
					if($replay_data['submit_type']==1){
						$insert_data['replytime'] = date('Y-m-d H:i:s');
					}
					$this->grab_custom_order->insert_reply_from_supplier($insert_data,$supplier_reply_arr[$i]);
				}else{
					if($replay_data['submit_type']==1){
						$is_submit = true;
					}
					$this->grab_custom_order->update_supplier_reply($choose_reply_arr['s_ca_id'][$i],$is_submit);
				}

			}
		    }elseif(empty($replay_data['supply_id']) && !empty($choose_reply_arr['s_reply_id'])){
		    	$s_reply_count = count($choose_reply_arr['s_reply_id']);
		    	if($replay_data['submit_type']==1){
				$is_submit = true;
			}
		    	for($i=0; $i<$s_reply_count; $i++){
		    	  $this->grab_custom_order->update_supplier_reply($choose_reply_arr['s_ca_id'][$i],$is_submit);
		    	}
		    }


		if(!isset($replay_data['ca_id']) || empty($replay_data['ca_id']) || $replay_data['ca_id']==-1){
			$insert_data = array(
				'expert_id'=>$this->expert_id,
				'customize_id'=>$replay_data['customize_id'],
				'plan_design'=>$replay_data['travel_description'],
				'isuse'=>0,
				'title'=>$replay_data['plan_name'],
				'addtime'=>date('Y-m-d H:i:s'),
				'childprice'=>$replay_data['child_bed_price'],
				'childnobedprice'=>$replay_data['child_no_bed_price'],
				'price'=> $replay_data['people_price'],
				'oldprice'=>$replay_data['old_people_price'],
				'price_description'=>$replay_data['price_decription'],
				'status'=>1
			);
			//判断是暂存还是提交
			if($replay_data['submit_type']==1 && !empty($replay_data['plan_name'])){
				$insert_data['replytime'] = date('Y-m-d H:i:s');
				//发短信给客人
				//$this->send_message($replay_data['linkphone'],$message);
			}
			$status = $this ->db ->insert('u_customize_answer',$insert_data);
			$customize_answer_id = $this->db->insert_id();
			if($status){
				for ($i=0;$i<$travel_title_arr_count;$i++) {
					$insert_data_js['customize_answer_id'] =$customize_answer_id;
					$insert_data_js['day'] = $i+1;
					//$insert_data_js['day'] = $i+1;
					$insert_data_js['title'] = $travel_title_arr[$i];
					$insert_data_js['transport'] = $traffic_arr[$i];
					$insert_data_js['hotel'] = $hotel_arr[$i];
					$insert_data_js['breakfirsthas'] = $breakfirsthas_arr[$i];
					$insert_data_js['breakfirst'] = $breakfirst_arr[$i+1];
					$insert_data_js['lunchhas'] = $lunchhas_arr[$i];
					$insert_data_js['lunch'] = $lunch_arr[$i+1];
					$insert_data_js['supperhas'] = $supperhas_arr[$i];
					$insert_data_js['supper'] = $supper_arr[$i+1];
					$insert_data_js['jieshao'] = $travel_content_arr[$i];
					//插入图片表
					$insert_data_pic['pic'] = $pics_url_arr[$i];
					$insert_data_pic['addtime'] = date('Y-m-d H:i:s');
					//这四项不填时不让插入表中
					if($insert_data_js['title']!='' || $insert_data_js['transport']!='' || $insert_data_js['jieshao']!='' || $insert_data_pic['pic']!=''){
					  $this ->db ->insert('u_customize_jieshao',$insert_data_js);
					  $insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					  $this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);
					}
				}
			}else{
				echo json_encode(array('status' =>-9 ,'msg' =>'操作失败'));
				exit();
			}
		}else{
			$update_data = array(
				'plan_design'=>$replay_data['travel_description'],
				'title'=>$replay_data['plan_name'],
				'isuse'=>0,
				'childprice'=>$replay_data['child_bed_price'],
				'childnobedprice'=>$replay_data['child_no_bed_price'],
				'price'=> $replay_data['people_price'],
				'oldprice'=>$replay_data['old_people_price'],
				'price_description'=>$replay_data['price_decription']
			);
			//判断是暂存还是提交
			if($replay_data['submit_type']==1 && !empty($replay_data['plan_name'])){
				$update_data['replytime'] = date('Y-m-d H:i:s');
				//发短信给客人
				//$this->send_message($replay_data['linkphone'],$message);
			}
			$status = $this ->db ->update('u_customize_answer',$update_data,array('id'=>$replay_data['ca_id']));
			if($status){
				$update_arr_count = count($replay_data['cj_id']);
				for ($i=0;$i<$update_arr_count;$i++) {
					$update_data_js['customize_answer_id'] =$replay_data['ca_id'];
					$update_data_js['day'] = $i+1;
					$update_data_js['title'] = $travel_title_arr[$i];
					$update_data_js['transport'] = $traffic_arr[$i];
					$update_data_js['hotel'] = $hotel_arr[$i];
					$update_data_js['breakfirsthas'] = $breakfirsthas_arr[$i];
					$update_data_js['breakfirst'] = $breakfirst_arr[$i+1];
					$update_data_js['lunchhas'] = $lunchhas_arr[$i];
					$update_data_js['lunch'] = $lunch_arr[$i+1];
					$update_data_js['supperhas'] = $supperhas_arr[$i];
					$update_data_js['supper'] = $supper_arr[$i+1];
					$update_data_js['jieshao'] = $travel_content_arr[$i];
					$update_data_pic['pic'] = $pics_url_arr[$i];
					$update_data_pic['addtime'] = date('Y-m-d H:i:s');
					//这四项不填时不让插入表中
					if($update_data_js['title']!='' || $update_data_js['transport']!='' || $update_data_js['jieshao']!='' ){
					  $this ->db ->update('u_customize_jieshao',$update_data_js,array('id'=>$replay_data['cj_id'][$i]));
					   $update_data_pic['pic'] = $pics_url_arr[$i];
					   $this ->db ->update('u_customize_jieshao_pic',$update_data_pic,array('id'=>$replay_data['pic_id'][$i]));
					}
				}
				//动态增加的天数行程
				for ($k=$update_arr_count;$k<$travel_title_arr_count;$k++) {
					$insert_data_js['customize_answer_id'] =$replay_data['ca_id'];
					$insert_data_js['day'] = $k+1;
					$insert_data_js['title'] = $travel_title_arr[$k];
					$insert_data_js['transport'] = $traffic_arr[$k];
					$insert_data_js['breakfirsthas'] = $breakfirsthas_arr[$k];
					$insert_data_js['breakfirst'] = $breakfirst_arr[$k+1];
					$insert_data_js['lunchhas'] = $lunchhas_arr[$k];
					$insert_data_js['lunch'] = $lunch_arr[$k+1];
					$insert_data_js['supperhas'] = $supperhas_arr[$k];
					$insert_data_js['supper'] = $supper_arr[$k+1];
					$insert_data_js['jieshao'] = $travel_content_arr[$k];
					$this ->db ->insert('u_customize_jieshao',$insert_data_js);
					$insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					$insert_data_pic['pic'] = $pics_url_arr[$k];
					$insert_data_pic['addtime'] = date('Y-m-d H:i:s');
					$this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);
				}
			}else{
				echo json_encode(array('status' =>-8 ,'msg' =>'操作失败'));
				exit();
			}
		}

		//判断是否是提交,如果是提交的话,并且选择了供应商方案直接作为选择中标的方案
		if($replay_data['submit_type']==1){
			if(isset($replay_data['choose_supplier_plan']) && !empty($replay_data['choose_supplier_plan']) ){
				$this->grab_custom_order->choose_supplier($replay_data['choose_supplier_plan']);
			}
		}

		}

			//插入一个人表, 使得简单回复的方案能够单独在一个数据表里
		$insert_data_reply = array(
			'customize_id'=>$replay_data['customize_id'],
			'expert_id'=>$this->expert_id,
			'answer_id'=>$customize_answer_id,
			'reply'=>$simple_aws,
			'addtime'=>date('Y-m-d H:i:s')
			);
		$this ->db ->insert('u_customize_reply',$insert_data_reply);
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array('status' =>1 ,'msg' =>'操作成功'));
				exit();
			}else{
				$this->db->trans_rollback();
				echo json_encode(array('status' =>-7 ,'msg' =>'操作失败'));
				exit();
			}
	}
}