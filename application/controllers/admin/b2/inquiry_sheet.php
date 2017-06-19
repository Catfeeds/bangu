<?php
/**
 * 询价单
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月22日15:50:11
 * @author		汪晓烽
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry_Sheet extends UB2_Controller {

	public function __construct() {
		parent::__construct();

		$this->load_model('admin/b2/inquiry_sheet_model', 'inquiry_sheet');
	}
	public function index() {
		$tab_index = $this->input->get('tab');
		$tab_index = (!isset($tab_index) || empty($tab_index)) ? 0 : $tab_index;
		$data = array('tab_index' => $tab_index);
		$this->load_view('admin/expert/inquiry_sheet',$data);
	}

	//询价单数据
	public function inquiry_sheet_list(){
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
		$inquiry_list = $this->inquiry_sheet->get_inquiry_list($page, $number,$this->expert_id);
		$pagecount = $this->inquiry_sheet->get_inquiry_list(0,10,$this->expert_id);
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
	               	"rows" => $inquiry_list
            	);

		echo json_encode($data);
	}

	//已回复数据
	public function inquiry_sheet_reply_list(){
		$endplace = "";
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
		$inquiry_reply_list = $this->inquiry_sheet->get_inquiry_reply_list($page, $number,$this->expert_id);
		$pagecount = $this->inquiry_sheet->get_inquiry_reply_list(0,10,$this->expert_id);
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
	               	"rows" => $inquiry_reply_list
            	);
		echo json_encode($data);
	}

	//已完成数据
	function   inquiry_sheet_completed_list(){
		$endplace = "";
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
		$completed_reply_list = $this->inquiry_sheet->get_inquiry_complete_list($page, $number,$this->expert_id);
		$pagecount = $this->inquiry_sheet->get_inquiry_complete_list(0,10,$this->expert_id);
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
	               	"rows" => $completed_reply_list
            	);
		echo json_encode($data);
	}

	//已取消数据
	function   inquiry_sheet_cancle_list(){
		$endplace = "";
		$number = $this->input->post('pageSize', true);
       		 $page = $this->input->post('pageNum', true);
        		$number = empty($number) ? 5 : $number;
        		$page = empty($page) ? 1 : $page;
		$cancle_reply_list = $this->inquiry_sheet->get_inquiry_cancle_list($page, $number,$this->expert_id);
		$pagecount = $this->inquiry_sheet->get_inquiry_cancle_list(0,10,$this->expert_id);
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
	               	"rows" => $cancle_reply_list
            	);
		echo json_encode($data);
	}


	//取消操作
	function cancle_inquiry_sheet(){
		$id = $this->input->post('id', true);
		$update_sql = "UPDATE u_enquiry SET STATUS=-2 WHERE id=".$id;
		$status = $this->db->query($update_sql);
		$this->db->close();
		echo "Success";
	}

	//显示编辑管家自己添加的询价单
	function edit_inquiry(){
		$post_arr = array();
		$post_trip_arr = array();

		$ca_id = $this->input->get('ca_id',true);
		$e_id = $this->input->get('e_id',true);
		$ca_id = (!empty($ca_id) && $ca_id!='null') ? $ca_id: -1;
		$e_id = (!empty($e_id) && $e_id!='null') ? $e_id: -1;
		$c_id = $this->input->get('c_id',true);
		$again = $this->input->get('again',true);

		$grab_custom_data = $this->inquiry_sheet->get_one_customize($c_id);
		$custom_trip_data_list = $this->inquiry_sheet->get_customize_trip($ca_id);
		$expert_baojia = $this->inquiry_sheet->get_expert_price($ca_id);

		if(isset($again) && $again==1 && !empty($grab_custom_data) && $grab_custom_data[0]['e_status']==2){
			//如果是1就是再次发单;2是不是再次发单
			$ca_id = -1;
			$e_id = -1;
			$c_id=-1;
		}
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
		$supplier = $this ->supplier_model ->all();
		$data = array(
			'trip_way' =>$trip_way,
			'choose' =>$choose,
			'hotel' =>$hotel,
			'shopping' =>$shopping,
			'catering' =>$catering,
			'room' =>$room,
			'supplier'=>$supplier,
			'expert_id'=>$this->expert_id,
			'ca_id'=>$ca_id,
			'c_id'=>$grab_custom_data[0]['id'],
			'e_id'=>$e_id,
			'expert_c_id'=>$c_id,
			'grab_custom_data'=>$grab_custom_data[0],
			'custom_trip_data_list'=>$custom_trip_data_list
			);
		if(!empty($expert_baojia)){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array('price'=>0,'childprice'=>0,'childnobedprice'=>0,'oldprice'=>0,'old_people_price'=>0,'price_description'=>'','plan_design'=>'','ca_title'=>'');
		}
		$this->view('admin/expert/edit_inquiry',$data);
	}

	//修改操作,真正操作数据库
	function edit_opera(){
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
			echo json_encode(array('status'=>-304,'msg'=>'价格说明必填'));
			exit();
		}

		if(empty($price_decription)){
			echo json_encode(array('status'=>-304,'msg'=>'价格说明必填'));
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
		$custom_arr['custom_type'] = $replay_data['destOne'];
		$dest_three = rtrim($replay_data['expert_dest_id'],',');
		if(!empty($dest_three)){
			$custom_arr['endplace']  = $replay_data['destTwoId'].','.$dest_three;
		}else{
			$custom_arr['endplace']  = $replay_data['destTwoId'];
		}
		$custom_arr['trip_way'] = $replay_data['trip_way'];
		$custom_arr['another_choose'] = rtrim($replay_data['choose_one'],',');
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
		$custom_arr['people'] = $replay_data['people'];
		$custom_arr['childnum'] = $replay_data['childnum'];
		$custom_arr['childnobednum'] = $replay_data['childnobednum'];
		$custom_arr['oldman'] = $replay_data['oldman'];
		$custom_arr['addtime'] = date('Y-m-d H:i:s');
		$custom_arr['customize_id'] = $replay_data['customize_id'];
		$custom_arr['expert_id'] = $this->expert_id;
		$this->load_model('admin/b2/grab_custom_order_model', 'grab_custom_order');

		//开始事物
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
				'childprice'=>$replay_data['childprice'],
				'childnobedprice'=>$replay_data['childnobedprice'],
				'price'=> $replay_data['price'],
				'oldprice'=>$replay_data['oldprice'],
				'price_description'=>$price_decription
			);
			//判断是暂存还是提交
			/*if($replay_data['submit_type']==2){
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
				'isuse'=>0,
				'childprice'=>$replay_data['childprice'],
				'childnobedprice'=>$replay_data['childnobedprice'],
				'price'=> $replay_data['price'],
				'oldprice'=>$replay_data['oldprice'],
				'price_description'=>$price_decription
			);
			//判断是暂存还是提交
			/*if($replay_data['submit_type']==2){
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
			if($replay_data['supplier_id']==""){
				$insert_inquiry_data['is_assign'] = 0;
			}else{
				$insert_inquiry_data['is_assign'] = 1;
				$insert_inquiry_data['supplier_id'] = $replay_data['supplier_id'];
			}
			if(!empty($replay_data['e_id']) && $replay_data['e_id']!=-1){
				$this->db->update('u_enquiry',$insert_inquiry_data,array('id'=>$replay_data['e_id']));
			}else{
				$insert_inquiry_data['customize_answer_id'] = $customize_answer_id;
				$this->db->insert('u_enquiry',$insert_inquiry_data);
				$new_inquiery_id = $this->db->insert_id();
				$this->db->update('u_customize_expert',array('enquiry_id'=>$new_inquiery_id),array('id'=>$c_expert_id));
			}
			if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array("status"=>200,"msg"=>"确定成功"));
			}else{
				$this->db->trans_rollback();
				echo json_encode(array('status' =>-8 ,'msg' =>'操作失败'));
				exit();
			}

	}

	//查看询价单详情
	function show_inquiry(){
		$ca_id = $this->input->get('ca_id',true);
		$ca_id = (!empty($ca_id) && $ca_id!='null') ? $ca_id: -1;
		$c_id = $this->input->get('c_id',true);
		$e_id = $this->input->get('e_id',true);
		$grab_custom_data = $this->inquiry_sheet->get_one_customize($c_id);
		$custom_trip_data_list = $this->inquiry_sheet->get_customize_trip($ca_id);
		$expert_baojia = $this->inquiry_sheet->get_expert_price($ca_id);
		$data = array(
			'expert_id'=>$this->expert_id,
			'ca_id'=>$ca_id,
			'c_id'=>$grab_custom_data[0]['id'],
			'grab_custom_data'=>$grab_custom_data[0],
			'custom_trip_data_list'=>$custom_trip_data_list
		);
		if(!empty($expert_baojia)){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array('price'=>0,'childprice'=>0,'childnobedprice'=>0,'oldprice'=>0,'price_description'=>'','plan_design'=>'','ca_title'=>'');
		}
		$this->view('admin/expert/show_inquiry',$data);
	}

	//再次发单操作
	function again_inquiry(){
		$insert_data_arr = array();
		$again_inquiry_data = $this->security->xss_clean($_POST);
		$insert_data_arr['customize_id'] = $again_inquiry_data['c_id'];
		$insert_data_arr['expert_id'] = $this->expert_id;
		$insert_data_arr['addtime'] = date('Y-m-d H:i:s');
		$insert_data_arr['status'] = $again_inquiry_data['submit_type'];
		$insert_data_arr['price'] = $again_inquiry_data['price'];
		$insert_data_arr['childprice'] = $again_inquiry_data['childprice'];
		$insert_data_arr['childnobedprice'] = $again_inquiry_data['childnobedprice'];
		$insert_data_arr['oldprice'] = $again_inquiry_data['oldprice'];
		$insert_data_arr['customize_answer_id'] = $again_inquiry_data['ca_id'];
		if($again_inquiry_data['supplier_id']==""){
			$insert_data_arr['is_assign'] = 0;
		}else{
			$insert_data_arr['is_assign'] = 1;
			$insert_data_arr['supplier_id'] = $again_inquiry_data['supplier_id'];
		}

		$status = $this->db->insert('u_enquiry',$insert_data_arr);
		if($status){
			echo json_encode(array('code'=>200,'msg'=>'提交成功'));
		}else{
			echo json_encode(array('code'=>-200,'msg'=>'提交失败'));
		}
	}

	//查看供应商的回复方案
	function get_supplier_reply(){

		$post_arr = array();
		$id = $this->input->post('id', true);
		 $post_arr['ey.id'] =$id;
		$data = $this->inquiry_sheet->get_inquiry_reply($post_arr);
		$this->db->close();
		echo json_encode($data);
	}

	//选择此方案操作
	function choose_one(){
		$id = $this->input->post('id', true);
		$eid = $this->input->post('eid', true);
		$supplier_id = $this->input->post('sid',true);
		$price = $this->input->post('price',true);
		$childprice = $this->input->post('childprice',true);
		$child_nobed_price = $this->input->post('child_nobed_price',true);
		$old_price = $this->input->post('old_price',true);

		if($price=='无'||$price==''){
			$price=0;
		}
		if($childprice=='无' || $childprice==''){
			$childprice=0;
		}
		if($child_nobed_price=='无' || $child_nobed_price==''){
			$child_nobed_price=0;
		}
		if($old_price=='无' || $old_price==''){
			$old_price=0;
		}
		//开始事物处理
		$this->db->trans_begin();
		$update_sql = "UPDATE u_enquiry SET STATUS=3,is_assign=1,price=$price,childprice=$childprice,childnobedprice=$child_nobed_price,oldprice=$old_price,supplier_id=$supplier_id WHERE id=".$eid;
		$this->db->query($update_sql);
		$update_sql2 = "UPDATE u_enquiry_grab SET isuse=1 WHERE id=".$id;
		$this->db->query($update_sql2);
		if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				$this->db->close();
				echo 'Success';
			}else{
				$this->db->trans_rollback();
				$this->db->close();
				echo 'Fail';
			}

	}

	//转询价单显示数据
	function preview_go_inquiry(){
		$post_arr = array();
		$post_trip_arr = array();
		$grab_custom_arr = array();
		$c_id = $this->input->get('c_id',true);
		$ca_id = $this->input->get('ca_id',true);
		$e_id = $this->input->get('e_id',true);
		$this->load_model('admin/b2/grab_custom_order_model', 'grab_custom_order');

		$grab_custom_data = $this->inquiry_sheet->get_one_customize($c_id,$this->expert_id);
		$expert_baojia = $this->inquiry_sheet->get_expert_price($ca_id,$this->expert_id);
		$custom_trip_data_list = $this->inquiry_sheet->get_customize_trip($ca_id,$this->expert_id);
		if(!empty($grab_custom_data)){
			$grab_custom_arr = $grab_custom_data[0];
			$post_arr['eg.supplier_id'] = $supplier_id;
			$post_arr['eg.enquiry_id'] = $e_id;
			$post_arr['eg.isuse'] = 1;
			$supplier_reply = $this->inquiry_sheet->get_inquiry_reply($post_arr);
		}
		$this->db->close();
		$data = array(
				'c_id' => $c_id,
				'expert_id'=>$this->expert_id,
				'grab_custom_data'=>$grab_custom_arr,
				'custom_trip_data_list' => $custom_trip_data_list
			);
		if(isset($supplier_reply[0]) && !empty($supplier_reply[0])){
			$data['supplier_reply'] = $supplier_reply[0];
		}else{
			$data['supplier_reply'] = array();
		}
		if(isset($expert_baojia[0]) && !empty($expert_baojia[0])){
			$data['expert_baojia'] = $expert_baojia[0];
		}else{
			$data['expert_baojia'] = array();
		}

		$this->load_view('admin/b2/inqury_go_inquiry',$data);

	}

	//查看询价单供应商回复的方案
	function show_supplier_plan(){
		$data = array();
		$eid = $this->input->get('eid');
		$c_id = $this->input->get('c_id');
		$supplier_id = $this->input->get('sid');
		$custom_info = $this->inquiry_sheet->get_one_customize($c_id);
		$supplier_customize = $this->inquiry_sheet->get_supplier_customize($eid,$supplier_id);
		$supplier_trip_data_list = $this->inquiry_sheet->get_supplier_trip($eid,$supplier_id);
		$custom_info[0]['ca_title']= $supplier_customize[0]['ca_title'];
		$custom_info[0]['plan_design']= $supplier_customize[0]['reply'];
		$custom_info[0]['price']= $supplier_customize[0]['price'];
		$custom_info[0]['childprice']= $supplier_customize[0]['childprice'];
		$custom_info[0]['childnobedprice']= $supplier_customize[0]['childnobedprice'];
		$custom_info[0]['oldprice']= $supplier_customize[0]['oldprice'];
		$custom_info[0]['agent_rate']= $supplier_customize[0]['agent_rate'];
		$custom_info[0]['plan_description']= $supplier_customize[0]['plan_description'];

		$data = array(
			'grab_custom_data'=>$custom_info[0],
			'eid'=>$eid,
			'c_id'=>$custom_info[0]['id'],
			'custom_trip_data_list' => $supplier_trip_data_list
			);
		$this->view('admin/expert/show_supplier_plan',$data);
	}

	function show_add_inquiry(){
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
		$supplier = $this ->supplier_model ->all();
		$data = array(
			'trip_way' =>$trip_way,
			'choose' =>$choose,
			'hotel' =>$hotel,
			'shopping' =>$shopping,
			'catering' =>$catering,
			'room' =>$room,
			'supplier'=>$supplier,
			'expert_id'=>$this->expert_id
			);

		$this->view('admin/expert/add_inquiry',$data);
	}

	//新增加询价单
	function add_inquiry(){
		$replay_data = $this->security->xss_clean($_POST);
		//echo json_encode($replay_data);exit();
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
			echo json_encode(array('status'=>-304,'msg'=>'价格说明必填'));
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

		//开始事物处理
		$this->db->trans_begin();

		$custom_arr['startplace'] = $replay_data['startcityId'];
		$custom_arr['custom_type'] = $replay_data['destOne'];
		$dest_three = rtrim($replay_data['expert_dest_id'],',');
		if(!empty($dest_three)){
			$custom_arr['endplace']  = $replay_data['destTwoId'].','.$dest_three;
		}else{
			$custom_arr['endplace']  = $replay_data['destTwoId'];
		}
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
		$custom_arr['people'] = $replay_data['people'];
		$custom_arr['childnum'] = $replay_data['childnum'];
		$custom_arr['childnobednum'] = $replay_data['childnobednum'];
		$custom_arr['oldman'] = $replay_data['oldman'];
		$custom_arr['addtime'] = date('Y-m-d H:i:s');
		$custom_arr['user_type'] = 1;
		$custom_arr['member_id'] = $this->expert_id;
		$custom_arr['question'] = $this->inquiry_sheet->get_question($custom_arr);
		$this->db->insert('u_customize',$custom_arr);
		$customize_id = $this->db->insert_id();
		$custom_arr['customize_id'] = $customize_id;
		$custom_arr['expert_id'] = $this->expert_id;
		unset($custom_arr['user_type']);
		unset($custom_arr['member_id']);
		$this ->db ->insert('u_customize_expert',$custom_arr);
		$customize_expert_id = $this->db->insert_id();
		//$this->inquiry->add_inquiry($custom_arr,$this->expert_id);

			$insert_data = array(
				'expert_id'=>$this->expert_id,
				'customize_id'=>$customize_id,
				'plan_design'=>$replay_data['plan_design'],
				'isuse'=>0,
				'title'=>$replay_data['ca_title'],
				'addtime'=>date('Y-m-d H:i:s'),
				'childprice'=>$replay_data['childprice'],
				'childnobedprice'=>$replay_data['childnobedprice'],
				'price'=> $replay_data['price'],
				'oldprice'=>$replay_data['oldprice'],
				'price_description'=>$price_decription
			);
			//判断是暂存还是提交
			/*if($replay_data['submit_type']==2){
				$insert_data['replytime'] = date('Y-m-d H:i:s');
			}*/
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
					  $this ->db ->insert('u_customize_jieshao',$insert_data_js);
					  $insert_data_pic['customize_jieshao_id'] = $this->db->insert_id();
					  $this ->db ->insert('u_customize_jieshao_pic',$insert_data_pic);

				}
			}else{
				echo json_encode(array('status' =>-9 ,'msg' =>'操作失败'));
				exit();
			}
			$insert_inquiry_data['customize_id'] = $customize_id;
			$insert_inquiry_data['customize_answer_id'] = $customize_answer_id;
			$insert_inquiry_data['expert_id'] = $this->expert_id;
			$insert_inquiry_data['addtime'] = date('Y-m-d H:i:s');
			$insert_inquiry_data['status'] = $replay_data['submit_type'];
			$insert_inquiry_data['price'] = $replay_data['price'];
			$insert_inquiry_data['childprice'] = $replay_data['childprice'];
			$insert_inquiry_data['childnobedprice'] = $replay_data['childnobedprice'];
			$insert_inquiry_data['oldprice'] = $replay_data['oldprice'];
			if($replay_data['supplier_id']==""){
				$insert_inquiry_data['is_assign'] = 0;
			}else{
				$insert_inquiry_data['is_assign'] = 1;
				$insert_inquiry_data['supplier_id'] = $replay_data['supplier_id'];
			}
			$this->db->insert('u_enquiry',$insert_inquiry_data);
			$enquiry_id = $this->db->insert_id();
			$this->db->update('u_customize_expert', array('enquiry_id'=>$enquiry_id), array('id' =>$customize_expert_id));

			if($this->db->trans_status() === TRUE){
				 $this->db->trans_commit();
				echo json_encode(array("status"=>200,"msg"=>"确定成功"));
			}else{
				$this->db->trans_rollback();
				echo json_encode(array('status' =>-9 ,'msg' =>'操作失败'));
				exit();
			}

	}

		//多图片上传的时候的处理程序
	function up_pics(){
		$this->load->helper ( 'url' );
		$config['upload_path'] = './file/b2/upload/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '40000';
		$file_name = 'b2_'.date('Y_m_d', time()).'_'.sprintf('%02d', rand(0,99));
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			echo json_encode(array('status' => -1,'msg' =>'请选择要上传的图片'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/b2/upload/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}
}