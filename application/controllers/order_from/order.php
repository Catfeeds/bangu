<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月23日11:59:53
 * @author		汪晓烽
 *注意:目前没有登陆,用户的id全都等于 4;即: memberid = 4
 */

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Order extends UC_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load_model( 'order_model', 'order');
		$this->load_model( 'member_model', 'member');
		$this->load_model ( 'line_model', 'line_model' );
		$this->load->model ( 'admin/b1/order_status_model', 'order_status_model' );
	}

	function line_order($type='',$page=1){
		if($page<1){
			$page=1;
		}
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$c_logintime=$this->session->userdata('c_logintime');
		//优惠券
		$this->load_model( 'coupon_model', 'coupon');
		$data['coupon_n']=$this->coupon->get_where_coupon($userid,0);
		//订单信息
		$order=$this->member->get_order_num($userid);
		//已收款
		$order_money=$this->member->get_order_refund($userid);
		//echo $this->db->last_query();
		//未评论
		$nocomment=$this->member->on_comment(0,$userid);
		//收款拒绝
		$order_refuse=$this->member->get_order_refuse($userid);
		//产品提问
		$line_answer=$this->member->get_line_consult($userid);
		//指定提问
		$expert_answer=$this->member->get_expert_consult($userid);
		//定制信息
		$custom_answer=$this->member->get_custom_consult($userid);
		//echo $this->db->last_query();
		//业务消息
		$notice_answer=$this->member->get_notice_consult($userid);
		//评为体验师   会员只能申请一次
		$experience=$this->member->get_alldata('u_member_experience',array('member_id'=>$userid,'status'=>1));
		//echo $this->db->last_query();
		//订单信息
		$post_arr = array();//查询条件数组
		$this->load->library('Page');

		$this->uri->segment(3, 0);
		$tyle=$this->uri->segment(4, 0);
		$post_arr['mb.mid'] = $this->session->userdata('c_userid');
		//$type=$this->input->get('type');
		//var_dump($type);
 			if(!empty($type)){
 				if($type==1){ //已留位
 					$post_arr['mb_od.status']=1;
 					//$post_arr['mb_od.ispay']=0;

 				}elseif($type==4){ //已确认
 					$post_arr['mb_od.status']=4;
 					$post_arr['mb_od.ispay']=2;

 				}elseif($type==54){ //已收款
 					//$post_arr['mb_od.status']=4;
 					//$post_arr['mb_od.ispay']=2;
 					$post_arr="mb_od.status >0 and  mb_od.ispay =2 and mb.mid={$post_arr['mb.mid']} ";
 				}elseif($type==11){  //收款拒绝
 					$post_arr['or_de.status']=-1;

 				}else if($type==44){ //已退款
 					$post_arr['mb_od.status']=-4;
 					$post_arr['mb_od.ispay']=4;

 				}else if($type==5){ //未评论
 					$userid=$this->session->userdata('c_userid');
 					//$post_arr=['mb_od.status >']=4;
 					$post_arr="mb_od.status >4 and  mb.mid ={$userid}  and (co.status is null)";

 				}elseif($type==64){ //已取消
 					//var_dump($type);
 					$post_arr['mb_od.status']=-4;
 					$post_arr['mb_od.ispay']=0;

 				}else if($type==55){  //未发体验
 					$userid=$this->session->userdata('c_userid');
 					$post_arr="mb_od.id not in ( select tn.order_id from travel_note as tn where  tn.usertype = 0 AND tn.status= 1 and tn.is_show=1) AND mb_od.status>4 and mb.mid=".$userid;
 				}else if($tyle=66){   //已被评为体验师
 					$orderid=$page;
 					$post_arr['mb_od.id']=$orderid;
 					$page=1;
 				}

 				$config['base_url'] = '/order_from/order/line_order_'.$type.'_';
 				$config ['pagesize'] = 10;
 				$config ['page_now'] = $page;
 				$config ['pagecount'] = count($this->order->get_all_line_order($post_arr, 0, $config['pagesize']));
 				$all_order_list = $this->order->get_all_line_order($post_arr, $page, $config['pagesize']);
 				//echo $this->db->last_query();
 			}else{
 				$post_arr['mb.mid'] = $this->session->userdata('c_userid');
 				$config['url_suffix'] = 'html';
 				$config['base_url'] = '/order_from/order/line_order_0_';
 				$config ['pagesize'] = 10;
 				$config ['page_now'] = $page;
 				$config ['pagecount'] = count($this->order->get_all_line_order($post_arr, 0, $config['pagesize']));
 				$all_order_list = $this->order->get_all_line_order($post_arr, $page, $config['pagesize']);
 			}

		//会员信息
		$where['mb.mid']=$userid;
		$data['member']=$this->order->get_member_data($where);

	    	//取消理由字典
	    	$reason=$this->order->select_data('DICT_CANCEL_REASON');

		$data = array('all_order_list'=>$all_order_list,
			'member'=>$data['member'],
			'reason'=>$reason,
			'order'=>$order,
			'line_answer'=>$line_answer,
			'expert_answer'=>$expert_answer,
			'custom_answer'=>$custom_answer,
			'notice_answer'=>$notice_answer,
			'c_logintime'=>$c_logintime,
			'order_refuse'=>$order_refuse,
			'title'=>'首页',
			'coupon_n'=>$data['coupon_n'],
			'experience'=>$experience,
			'nocomment'=>$nocomment,
			'order_money'=>$order_money
		);

		$this->page->initialize ( $config );

		$this->load->view('/order/line_order',$data);
	}
	//编辑订单
	function show_order_detail($order_id=0){
		//会员信息
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$where['mb.mid']=$userid;
		$data['member']=$this->order->get_member_data($where);
		//判断该订单是否是该用户的
		if(is_numeric($order_id)){
			$is_order=$this->order->get_alldata('u_member_order',array('id'=>$order_id,'memberid'=>$userid));
			if(empty($is_order)){
				echo "<script>alert('该订单你没有权限修改!');window.close();</script>";
			}
		}else{
			echo "<script>alert('该订单不存在!');window.close();</script>";
		}
		$progress_info = $this->order->get_progress_tracking($order_id);

		$concact_info  = $this->order->get_contact($order_id);
		$travel_info   = $this->order->get_travel(array('mom.order_id'=>$order_id));
        
		$invoice_info = $this->order->get_invoice($order_id);

		//产品信息
		$data['product']=$this->order->get_product_data(array('mo.id'=>$order_id));
		//保险费用
		$data['insurance']=$this->order->get_insurance($order_id);

		$order_info = $this ->order ->get_order_message(array('mo.id' =>$order_id));
		if(!empty($order_info)){
			$endtime = date('Y-m-d' ,(strtotime($order_info ['usedate']) + $order_info ['lineday']*24*3600));
			$order_info ['endtime'] = $endtime;
			$order_info ['usedate'] = date('Y-m-d' ,strtotime($order_info['usedate']));
		}
		//合同信息
		$cfg_web=$this ->order ->get_alldata('cfg_web',array());
		$overArr=explode(',', $data['product']['overcity']);
		if(in_array(1,$overArr)){  //出境游合同
			$contract=$cfg_web['travel_contract_abroad_url'];
		}else{			//国内合同
			$contract=$cfg_web['travel_contract_domestic_url'];
		}
		//证件类型
		$tyle=$this ->order ->select_data('DICT_CERTIFY_WAY');

		//线路的出发地
		$citystr='';
		if(!empty($data['product']['lineid'])){
			$cityData=$this->order->select_startplace(array('ls.line_id'=>$data['product']['lineid']));
			foreach ($cityData as $k=>$v){
				if(count($cityData)<($k+2)){
					$citystr=$citystr.$v['cityname'];
				}else{
					$citystr=$citystr.$v['cityname'].',';
				}

			}
		}

		$data = array(
			'progress_info' =>$progress_info,
			'concact_info' =>$concact_info,
			'travel_info' =>$travel_info,
			'invoice_info' =>$invoice_info,
			'order_id' =>$order_id,
			'order_info' =>$order_info,
			'product'=>$data['product'],
			'tyle'=>$tyle,
			'order_id'=>$order_id,
			'member'=>$data['member'],
			'insurance'=>$data['insurance'],
			'contract'=>$contract,
			'citystr'=>$citystr
		);

		$this->load->view('order/line_order_detail',$data);
	}
	//出游人
	function get_member_travel(){
		$id=$this->input->get('id',true);
		$lineid=$this->input->get('lineid',true);
		
		$data['travel']=$this->order->get_travel(array('mt.id'=>$id));
	    $data['product']= $this->order->get_alldata('u_line',array('id'=>$lineid));
	 
	    //证件类型
	     $data['type']=$this ->order ->select_data('DICT_CERTIFY_WAY');
	
		$this->load->view('order/member_travel',$data);		
	}
    //查看订单信息
    function show_order_message($order_id=0){

    	//会员信息
    	$this->load->library('session');
    	$userid=$this->session->userdata('c_userid');
    	$where['mb.mid']=$userid;
    	$data['member']=$this->order->get_member_data($where);

    	//判断该订单是否是该用户的
    	if(is_numeric($order_id)){
    		$is_order=$this->order->get_alldata('u_member_order',array('id'=>$order_id,'memberid'=>$userid));
    		if(empty($is_order)){
    			echo "<script>alert('该订单你没有权限修改!');window.history.back(-1);</script>";
    		}
    	}else{
    		   echo "<script>alert('该订单不存在!');window.history.back(-1);</script>";
    	}

    	$progress_info = $this->order->get_progress_tracking($order_id);
    	$concact_info  = $this->order->get_contact($order_id);
    	$travel_info      = $this->order->get_travel(array('mom.order_id'=>$order_id));

    	$invoice_info = $this->order->get_invoice($order_id);

    	//产品信息
    	$data['product']=$this->order->get_product_data(array('mo.id'=>$order_id));
            //保险费用
    	$data['insurance']=$this->order->get_insurance($order_id);

    	$order_info = $this ->order ->get_order_message(array('mo.id' =>$order_id));
	    //echo $this->db->last_query();
    	if(!empty($order_info)){
    		$endtime = date('Y-m-d' ,(strtotime($order_info ['usedate']) + $order_info ['lineday']*24*3600));
    		$order_info ['endtime'] = $endtime;
    		$order_info ['usedate'] = date('Y-m-d' ,strtotime($order_info['usedate']));
    	}

    	//合同信息
    	$cfg_web=$this ->order ->get_alldata('cfg_web',array());
    	$overArr=explode(',', $data['product']['overcity']);
    	if(in_array(1,$overArr)){  //出境游合同
    		$contract=$cfg_web['travel_contract_abroad_url'];
    	}else{			//国内合同
    		$contract=$cfg_web['travel_contract_domestic_url'];
    	}

    	//证件类型
    	$tyle=$this ->order ->select_data('DICT_CERTIFY_WAY');

    	//线路的出发地
    	$citystr='';
    	if(!empty($data['product']['lineid'])){
    		$cityData=$this->order->select_startplace(array('ls.line_id'=>$data['product']['lineid']));
    		foreach ($cityData as $k=>$v){
    			if(count($cityData)<($k+2)){
    				$citystr=$citystr.$v['cityname'];
    			}else{
    				$citystr=$citystr.$v['cityname'].',';
    			}

    		}
    	}

    	$data = array(
    		'progress_info' =>$progress_info,
    		'concact_info' =>$concact_info,
    		'travel_info' =>$travel_info,
    		'invoice_info' =>$invoice_info,
    		'order_id' =>$order_id,
    		'order_info' =>$order_info,
    		'product'=>$data['product'],
    		'tyle'=>$tyle,
    		'order_id'=>$order_id,
    		'member'=>$data['member'],
    		'insurance'=>$data['insurance'],
    		'contract'=>$contract,
    		'citystr'=>$citystr
    	);


    	$this->load->view('order/line_order_message',$data);

    }
    //生成合同png
/*     function create_png($msg){
    	$this->load->library('Textpng');
    	$text = new Textpng();
    	$text->msg = $msg; // 需要显示的文字
    	$text->font = './file/font/simkai.ttf'; // 字体
    	$text->size = 14; // 文字大小
    	$text->rot = 0; // 旋转角度
    	$text->pad = 0; // padding
    	$text->red ='#e83b37'; // 文字颜色
    	$text->grn = 0; // ..
    	$text->blu = 0; // ..
    	$text->bg_red = 255; // 背景颜色.
    	$text->bg_grn =  255; // ..
    	$text->bg_blu =  255; // ..
    	$text->transparent = 1; // 透明度 (boolean).
    	$text->draw();

    } */
	//取消订单
	function cancle_order(){

		$order_id = $this->input->post('cancle_order_id');
		$cancle_reasons   = $this->input->post('cancle_reasons');
		$reasons  = $this->input->post('reasons'); //取消原因
		$reasons_data='';
		$cancle='';

		if(!empty($reasons)){
			if($reasons==-1){
				$cancle=$cancle_reasons;
			}else{
				$reasons_data=$reasons;
			}
		}
		//订单信息
		$order_message=$this->order->get_alldata('u_member_order',array('id'=>$order_id));
		//修改订单状态
		$re=$this->order->updata_order_stutas(array('id'=>$order_id),array('STATUS'=>-4,'canceltime'=>date('Y-m-d H:i:s')));
		if($re){
			if($order_message['status']==1){
				//加库存
				$total_number=$order_message["dingnum"]+$order_message["childnum"]+$order_message["u_member_order"];
				$date=$order_message['usedate'];
				$suitid=$order_message['suitid'];
				$lineid=$order_message['productautoid'];
				$number=$this->order->get_alldata('u_line_suit_price',array('lineid'=>$lineid,'suitid'=>$suitid,'day'=>$date));

				if(!empty($total_number)){      //减少库存
					$where_suit=array(
						'lineid'=>$lineid,
						'suitid'=>$suitid,
						'day'=>$date,
					);
					$num_date=$number['number']+$total_number;
					if($number['number']!=-1){
						$status = $this->order->updata_Stock( $where_suit,array('number'=>$num_date));
					}
				}
			}
		$this->order->order_log($order_id,'用户取消订单',$order_message['status']);
		//统计订单操作数据
		$this->order_status_model->update_order_status_cal($order_id);

		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');
		$username=$this->session->userdata('c_username');

		//发消息给1:B2,2:B1
		$expert=$this->input->post('expert');
		$supplier=$this->input->post('supplier');
		if(!empty($expert)){    //发给b2
			$this->add_message('用户'.$username.'已经取消订单，订单号:'.$order_message['ordersn'].',线路：'.$order_message['productname'],'1',$expert);
		}

		if(!empty($supplier)){   //发给B1
			$this->add_message('用户'.$username.'已经取消订单，订单号:'.$order_message['ordersn'].',线路：'.$order_message['productname'],'2',$supplier);
		}
		//返回积分
		//$order_message['jifen']
	//	$update_jifen=$this->order->update_member_jifen($userid,$order_message['jifen']);
		//取消的理由
		$this->order->insert_tabledata('u_member_order_attach',array('orderid'=>$order_id,'cancel_reason'=>$reasons_data,'cancel_text'=>$cancle));
		 echo true;
		}else{
			echo false;
		}
		//redirect($_SERVER['HTTP_REFERER']);

	}

	//付款
	function pay(){
		$this->load->library ( 'callback' );
		$account_name = $this->input->post('account_name');
		$bank_name = $this->input->post('bank_name');
		//$card_num = $this->input->post('card_num');

		$card_before_four = $this->input->post('card_before_four');
		$card_before_four = trim($card_before_four);
		$card_after_four = $this->input->post('card_after_four');
		$card_after_four = trim($card_after_four);

		$receipt = $this->input->post('receipt');
		$receipt_img = $this->input->post('receipt_img_url');
		$receipt_img = trim($receipt_img,';');
		$pay_amount = floatval($this->input->post('pay_money'));
		$order_id = intval($this->input->post('pay_order_id'));
		$invoice = intval($this ->input ->post('invoice'));
		$diff_price = intval($this->input->post('diff_price'));
		$ispay = intval($this ->input ->post('ispay'));
		$userid = intval($this ->session ->userdata('c_userid'));
		if (empty($account_name)) {
			$this->callback->set_code ( 4000 ,"账户名称必填");
			$this->callback->exit_json();
		}
		if (empty($bank_name)) {
			$this->callback->set_code ( 4000 ,"银行名称必填");
			$this->callback->exit_json();
		}
		/*if (empty($card_num)) {
			$this->callback->set_code ( 4000 ,"银行卡号必填");
			$this->callback->exit_json();
		}*/
		if(empty($card_before_four) || !preg_match('/^\d{4}$/', $card_before_four)){
			$this->callback->set_code ( 4000 ,"银行卡号前四位必填");
			$this->callback->exit_json();
		}

		if(empty($card_after_four) || !preg_match('/^\d{4}$/', $card_after_four)){
			$this->callback->set_code ( 4000 ,"银行卡号后四位必填");
			$this->callback->exit_json();
		}

		$card_num = $card_before_four.'-'.$card_after_four;
		/*if (empty($receipt)) {
			$this->callback->set_code ( 4000 ,"流水回执号必填");
			$this->callback->exit_json();
		}*/
		//判断订单是否存在
		$order_info = $this ->order ->row(array('id' =>$order_id));
		if (empty($order_info)) {
			$this->callback->set_code ( 4000 ,"订单不存在");
			$this->callback->exit_json();
		}
		//验证线路
		$line_info = $this ->line_model ->row(array('id' =>$order_info['productautoid'] ,'status' =>2));
		if (empty($line_info)) {
			$this->callback->set_code ( 4000 ,"您选择的旅游线路不存在或已下架，请咨询您的旅游专家");
			$this->callback->exit_json();
		}

		$first_pay_rate = $line_info['first_pay_rate'];//线路首付比例
		if ($first_pay_rate > 0 && $first_pay_rate <= 1) { //线路首付比例正常
			 if ($first_pay_rate == 1) { //不支持首付
			 	$min_pay_money = $order_info ['total_price']; //最少支付金额
			 } else {
			 	$min_pay_money = $order_info ['total_price'] * $first_pay_rate;
			 }
		} else { //首付值异常默认为全部支付
			$min_pay_money = $order_info ['total_price'];
		}

		//判断订单的支付状态
		switch($order_info['ispay']) {
			case 0: //没有支付
				if ($order_info['status'] == 0) { //B1已留位可以支付
					//验证支付金额
					if (($min_pay_money-$pay_amount)>0.001) {
						$this->callback->set_code ( 4000 ,"支付金额最少为：￥{$min_pay_money}，请您重新填写支付金额");
						$this->callback->exit_json();
					} elseif (($pay_amount-($order_info['settlement_price']+$order_info['total_price']))>0.001) {
						$this->callback->set_code ( 4000 ,"您填写的支付金额超过了支付金额");
						$this->callback->exit_json();
					}
				} /*elseif ($order_info['status'] == 0) {
					$this->callback->set_code ( 4000 ,"您的订单旅行社尚未留位，请耐心等待，如有问题请咨询旅游专家");
					$this->callback->exit_json();
				} */elseif ($order_info['status'] < 0) {
					$this->callback->set_code ( 4000 ,"您的订单已取消，或留位失败");
					$this->callback->exit_json();
				} else {
					$this->callback->set_code ( 4000 ,"订单有误，请联系客服");
					$this->callback->exit_json();
				}
				break;
			case 1: //付完首付(支付宝每个订单号只可以支付一次)
				if ($order_info ['status'] < 2) {
					$this->callback->set_code ( 4000 ,"订单有误，请联系客服");
					$this->callback->exit_json();
				} else {
					//验证支付金额
					$final_pay = $order_info['total_price'] - $order_info['first_pay'];//尾款
					if (abs($pay_amount-$final_pay)>0.001) {
					$this->callback->set_code ( 4000 ,"您填写的支付尾款不正确，尾款为：￥{$final_pay}");
					$this->callback->exit_json();
					}
				}
				break;
			case 2: //已付完
				if($diff_price<=0){
					$this->callback->set_code ( 4000 ,"订单已支付完成，无需再支付");
					$this->callback->exit_json();
				}
				break;
			default: //未知状态
				$this->callback->set_code ( 4000 ,"订单有误，请联系您的专家");
				$this->callback->exit_json();
				break;
		}
		//保存发票信息
			if ($invoice == 1) {
				$invoice_name = trim($this ->input ->post('title' ,true));
				$invoice_detail = trim($this ->input ->post('detail' ,true));
				$receiver = trim($this ->input ->post('receiver' ,true));
				$telephone = trim($this ->input ->post('mobile' ,true));
				$address = trim($this ->input ->post('address' ,true));
				$province = intval($this ->input ->post('province'));
				$city = intval($this ->input ->post('city'));
				$region = intval($this ->input ->post('region'));
				if (empty($invoice_name)) {
					$this->callback->set_code ( 2004 ,"请填写发票抬头");
					$this->callback->exit_json();
				}
				if (empty($receiver)) {
					$this->callback->set_code ( 2004 ,"请填写收件人");
					$this->callback->exit_json();
				}
				if (empty($telephone)) {
					$this->callback->set_code ( 2005 ,"请填写手机号");
					$this->callback->exit_json();
				}
				if (empty($region)) {
					$this->callback->set_code ( 2006 ,"请将地址选择完整");
					$this->callback->exit_json();
				} else {
					$sql = "select name from u_area where id in ($province,$city,$region) order by pid asc";
					$areaData = $this ->db ->query($sql) ->result_array();
					$addname = '';
					if (!empty($areaData)) {
						foreach($areaData as $val) {
							$addname .= $val['name'];
						}
					}
				}
				if (empty($address)) {
					$this->callback->set_code ( 2006 ,"请填写详细地址");
					$this->callback->exit_json();
				}
				$time = date('Y-m-d H:i:s' ,time());
				$invoiceArr = array(
					'invoice_name' =>$invoice_name,
					'invoice_detail' =>$invoice_detail,
					'receiver' =>$receiver,
					'telephone' =>$telephone,
					'address' =>$addname.$address,
					'member_id' =>$userid,
					'modtime' =>$time
				);
				$this ->load_model('common/u_member_order_invoice_model' ,'order_invoice_model');
				$this ->load_model('common/u_member_invoice_model' ,'invoice_model');
				$invoiceData = $this ->order_invoice_model ->row(array('order_id' =>$order_id));
				if (empty($invoiceData)) {
					$invoiceArr['addtime'] = $time;
					$invoiceId = $this ->invoice_model ->insert($invoiceArr);
					if (empty($invoiceId)) {
						$this->callback->set_code ( 2007 ,"系统繁忙，稍后重试");
					$this->callback->exit_json();
					} else {
						$oiArr = array(
							'order_id' =>$order_id,
							'invoice_id' =>$invoiceId
						);
						$this ->order_invoice_model ->insert($oiArr);
					}
				} else {
					$status = $this ->invoice_model ->update($invoiceArr ,array('id' =>$invoiceData['invoice_id']));
					if (empty($status)) {
						throw new Exception('系统繁忙，稍后重试');
					}
				}
			}
		//验证流水号不能重复填写
		$this->db->select('count(*) AS receipt_count');
		$this->db->from('u_order_detail');
		$this->db->where(array('receipt'=>$receipt,'bankname'=>$bank_name,'bankcard'=>$card_num));
		$receipt_c = $this->db->get()->result_array();
		if($receipt_c[0]['receipt_count']>=1){
			$this->callback->set_code ( 4001 ,"流水回执号已经存在,请重新填写!");
			$this->callback->exit_json();
		}
		//写入订单支付详情表
		$insert_data['order_id'] =$order_info['id'];
		$insert_data['amount'] = $pay_amount;
		$insert_data['bankname'] = $bank_name;
		$insert_data['bankcard'] =$card_num;
		$insert_data['receipt'] =$receipt;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		$insert_data['beizhu'] = '线下付款';
		$insert_data['receipt_pic'] = $receipt_img;
		$insert_data['account_name'] = $account_name;
		$insert_data['pay_way'] = '银行转账';
		$insert_data['status'] = 0;
		//$status = $this->db->insert('u_order_detail',$insert_data);
		$status =$this->order->insert_tabledata('u_order_detail',$insert_data);
		if($status){
			$this->order->order_log($order_id,'用户付款',$order_info['status']);
			if($diff_price>0 && $ispay==2){
				$order_data = array('final_pay' =>$pay_amount);
			}else{
				$order_data = array(
					'ispay' =>1,
					'first_pay' =>$pay_amount,
					'final_pay' =>0
				);
			}

			//是否需要发票,如果是就改成1
			if($invoice==1){
				$order_data['isneedpiao'] = 1;
			}
			$this ->db ->where(array('id' =>$order_info['id']));
			$status = $this ->db ->update('u_member_order' ,$order_data);
			if($status){
				//发消息给1:B2,2:B1

				//启用session
				$this->load->library('session');
				$userid=$this->session->userdata('c_userid');
				$username=$this->session->userdata('c_username');
				//订单信息
				$order_message=$this->order->get_alldata('u_member_order',array('id'=>$order_id));
				//$suit_data = $this->order->update_suit_data($order_message['suitid'],$order_message['usedate']);
				if($order_message['suitnum']>0){
					$this->db->query('UPDATE u_line_suit_price SET number=number-'.$order_message['suitnum'].' WHERE suitid='.$order_message['suitid'].' and day='.$order_message['usedate']);
				}else{
					$total_people = $order_message['oldnum']+$order_message['dingnum']+$order_message['childnum']+$order_message['childnobednum'];
					$this->db->query('UPDATE u_line_suit_price SET number=number-'.$total_people.' WHERE suitid='.$order_message['suitid'].' and day='.$order_message['usedate']);
				}
				$expert=$this->input->post('expert');
				$supplier=$this->input->post('supplier');
				if(!empty($expert)){    //发给b2
					$this->add_message('用户'.$username.'付款，订单号:'.$order_message["ordersn"].',线路：'.$order_message['productname'],'1',$expert);
				}
				if(!empty($supplier)){   //发给B1
					$this->add_message('用户'.$username.'付款，订单号:'.$order_message["ordersn"].',线路：'.$order_message['productname'],'2',$supplier);
				}
				//统计订单操作数据
				$this->order_status_model->update_order_status_cal($order_id);
				$this->callback->set_code ( 2000 ,"提交成功");
				$this->callback->exit_json();
			}else{
				$this->callback->set_code ( 4000 ,"提交失败");
				$this->callback->exit_json();
			}
		}else{
			$this->callback->set_code ( 4000 ,"写入订单付款详情失败");
			$this->callback->exit_json();
		}
	}

	//申请退单
	function apply_refund_order(){
		$order_id = $this->input->post('refund_order_id');
		$mobile   = $this->input->post('pay_mobile');
		$back_reason   = $this->input->post('back_reason');
		$userid = intval($this ->session ->userdata('c_userid'));
	//	$pay_other_reason  = $this->input->post('pay_other_reason'); //其他原因
		$pay_reason  = $this->input->post('pay_reason'); //取消原因
		$reasons_data='';
	    $dis_reason='';
	    $reason='';
	    if(!empty($pay_reason)){
	     	if($pay_reason==-1){
	     		$dis_reason=$back_reason;
	     		$reason=$back_reason;

	     	}else{
	     		$reasons_data=$pay_reason;
	     		if($pay_reason>0){
		     		$res=$this->order->get_alldata('u_dictionary',array('dict_id'=>$pay_reason));
		     		$reason=$res['description'];
	     		}
	     	}
	     }
	     //订单信息
	    $order_message=$this->order->get_alldata('u_member_order',array('id'=>$order_id));
	    $this->order->insert_tabledata('u_member_order_attach',array('orderid'=>$order_id,'cancel_reason'=>$reasons_data,'cancel_text'=>$dis_reason));


		//改变订单状态
	    $re=$this->order->updata_order_stutas(array('id'=>$order_id),array('STATUS'=>-3,'canceltime'=>date('Y-m-d H:i:s'),'ispay'=>3,'reason_member'=>$reason));

		if($re){
			//插入退款表
			$this->order->insert_order_refund($order_id,$reason,$mobile,$userid);
			//统计订单操作数据
			$this->order_status_model->update_order_status_cal($order_id);

			//订单日志
			$this->order->order_log($order_id,'用户申请退单',$order_message['status']);

			//发消息给1:B2,2:B1
			$expert=$this->input->post('expert');
			$supplier=$this->input->post('supplier');


			//启用session
			$this->load->library('session');
			$userid=$this->session->userdata('c_userid');
			$username=$this->session->userdata('c_username');


	 		if(!empty($expert)){    //发给b2
				$this->add_message('用户'.$username.'退单，订单号:'.$order_message["ordersn"].',线路：'.$order_message['productname'],'1',$expert,'用户'.$username.'退单');
			}
			if(!empty($supplier)){   //发给B1
				$this->add_message('用户'.$username.'退单，订单号:'.$order_message["ordersn"].',线路：'.$order_message['productname'],'2',$supplier,'用户'.$username.'退单');
			}

			echo true;
		}else{
			echo false;
		}

	//  redirect($_SERVER['HTTP_REFERER']);

	}

	//评论
	function comment(){
		$this->load->library ( 'callback' );
		$insert_data = array();
		$memberid = $this->session->userdata('c_userid');
		$order_id = $this->input->post('c_order_id');
		$line_id = $this->input->post('c_line_id');
		$expert_id = $this->input->post('c_expert_id');
		$pic_url = $this->input->post('img');
		if(!empty($pic_url)){
			$pic_url = implode(',', $pic_url);
		}
		$content = $this->input->post('content');
		$level = $this->input->post('level');
		$expert_comment = $this->input->post('expert_comment');
		$score0 = $this->input->post('score0');
		$score1 = $this->input->post('score1');
		$score2 = $this->input->post('score2');
		$score3 = $this->input->post('score3');
		$score4 = $this->input->post('score4');
		$score5 = $this->input->post('score5');
		$insert_data['orderid'] = $order_id;
		$insert_data['expert_id'] = $expert_id;
		$insert_data['memberid'] = $memberid;
		$insert_data['line_id'] = $line_id;
		$insert_data['ADDTIME'] = date('Y-m-d H:i:s');
		$insert_data['content'] = $content;
		$insert_data['pictures'] = $pic_url;
		$insert_data['score1'] = $score0;
		$insert_data['score2'] = $score1;
		$insert_data['score3'] = $score2;
		$insert_data['score4'] = $score3;
		$insert_data['score5'] = $score4;
		$insert_data['score6'] = $score5;
		$insert_data['isanonymous'] = $this->input->post('isanonymous');
		$insert_data['avgscore1']=($score0+$score1+$score2+$score3)/4;
		$insert_data['avgscore2']=($score4+$score5)/2;
		//评论送积分
		$integral=0;
		if($insert_data['avgscore1']>0){
			$integral=100;
		}
		if(!empty($content)){
			$integral=$integral+500;
			$content_len=mb_strlen($content, 'UTF-8');
			if($content_len>30){
				$integral=$integral+500;
			}
		}
		if(!empty($pic_url)){
			$integral=$integral+500;
		}
		//$insert_data['LEVEL'] = $level;
		$insert_data['expert_content'] = $expert_comment;
		$insert_data['channel'] = 0;
		$insert_data['isshow'] = 1;
		$insert_data['jifen'] = $integral;
		if(empty($pic_url)){
			$insert_data['haspic'] = 0;
		}else{
			$insert_data['haspic'] = 1;
		}
		//会员信息
		$member=$this->order->get_alldata('u_member',array('mid'=>$memberid));
		//获取线路的始发地
		//$line= $this->order->get_alldata('u_line',array('id'=>$line_id));
		$citystr='';
		$this->load->model ( 'admin/b1/user_shop_model' );
		$cityArr=$this->user_shop_model->select_startplace(array('ls.line_id'=>$line_id));
		foreach ($cityArr as $k=>$v){
			if(!empty($v['startplace_id'])){
				$citystr=$citystr.$v['startplace_id'].',';
			}
		}
		$insert_data['starcityid'] = rtrim($citystr ,',');

		//查询评论
		$comment=$this->order->get_alldata('u_comment',array('orderid'=>$order_id,'status'=>1));
		if(empty($comment)){
			$status=$this->order->insert_tabledata('u_comment',$insert_data); //插入评论表
			$update_jifen=$this->order->update_member_jifen($memberid,$integral);
			if($update_jifen){  //记录积分记录
			   	$jifenArr['member_id']=$memberid;
			   	$jifenArr['point_before']=$member['jifen'];
			   	$jifenArr['point_after']=$member['jifen']+$integral;
			   	$jifenArr['point']=$integral;
			   	$jifenArr['content']='评论赠送积分';
			   	$jifenArr['addtime']=date('Y-m-d H:i:s',time());
			   	$this->order->insert_tabledata('u_member_point_log',$jifenArr);
			}
			//记录评论数量
			$this->order->update_comment_count($line_id);
			//记录管家评论数据
			if($expert_id>0){
			      $this->order->update_expert_comment_count($expert_id);
			}

		}else{
			$status=false;
			$this->callback->set_code ( 400 ,"你已点评了");
			$this->callback->exit_json();
		}
		//订单信息
		$order_message=$this->order->get_alldata('u_member_order',array('id'=>$order_id));
		if($status){
			//改变订单状态
			$re=$this->order->updata_order_stutas(array('id'=>$order_id),array('STATUS'=>6));
			if($re){
				//删除缓存
				$this->cache->redis->delete('SYhomeComment');

				$this->order->order_log($order_id,'用户点评',$order_message['status']);
				//统计订单操作数据
				$this->order_status_model->update_order_status_cal($order_id);
				$this->callback->set_code ( 200 ,"评论提交成功",$order_message['status']);
				$this->callback->exit_json();
			}else{
				$this->callback->set_code ( 400 ,"评论提交失败",$order_message['status']);
				$this->callback->exit_json();
			}
		}else{
			$this->callback->set_code ( 400 ,"评论提交失败",$order_message['status']);
			$this->callback->exit_json();
		}
	}

	//投诉
	function complaint(){
		$memberid=$this->session->userdata('c_userid');
		$member=$this->order->get_alldata('u_member',array('mid'=>$memberid));
		$username=$member['truename'];
		$order_id = $this->input->post('complaint_order_id');
		$mobile = $this->input->post('complaint_mobile');
		$content   = $this->input->post('complaint_content');
		$insert_data['order_id'] = $order_id;
		$insert_data['member_id'] = $memberid;
		$insert_data['complain_type'] = $this->input->post('complain_type');
		$insert_data['reason'] =$content;
		$insert_data['mobile'] =$mobile;
		$insert_data['user_name'] =$username;
		$insert_data['addtime'] = date('Y-m-d H:i:s');
		$insert_data['status'] = 0;
		$insert_data['attachment'] = $this->input->post('attachment');

		//订单信息
		$order_message=$this->order->get_alldata('u_member_order',array('id'=>$order_id));

		$ifcomplain=$this->order->get_today_complain($order_id);
		if(!empty($ifcomplain)){
                           echo  json_encode(array('status'=>-1,'msg'=>'今天您已经投诉过了'));
                           exit;
		}

		$flag=$this->order->insert_tabledata('u_complain',$insert_data);

		$re=false;
		if($flag>0){
			//改变订单状态
			$re=$this->order->updata_order_stutas(array('id'=>$order_id),array('STATUS'=>7));
		}
		if($re){

			$this->order->order_log($order_id,'用户投诉',$order_message['status']);

			//统计订单操作数据
			$this->order_status_model->update_order_status_cal($order_id);

			//发消息给1:B2,2:B1
			$expert=$this->input->post('expert');
			$supplier=$this->input->post('supplier');

			//启用session
			$this->load->library('session');
			$userid=$this->session->userdata('c_userid');
			$username=$this->session->userdata('c_username');

			if(!empty($expert)){    //发给b2
				$this->add_message('用户'.$username.'投诉，订单号:'.$order_message["ordersn"].', 线路：'.$order_message['productname'],'1',$expert,'用户'.$username.'投诉');
			}
			//$member=$_POST['member'];
			if(!empty($supplier)){   //发给B1
				$this->add_message('用户'.$username.'投诉，订单号:'.$order_message["ordersn"].', 线路：'.$order_message['productname'],'2',$supplier,'用户'.$username.'投诉');
			}
			echo  json_encode(array('status'=>1,'msg'=>'投诉成功!'));
		}else{
			echo  json_encode(array('status'=>1,'msg'=>'投诉失败!'));
		}

	}
	 //投诉的文件
	 function up_file(){

	 	$config['upload_path']="./file/c/complaint";//文件上传目录
	 	if(!file_exists("./file/c/complaint/")){
	 		mkdir("./file/c/complaint/",0777,true);//原图路径
	 	}
        if(!empty($_FILES['upfile']['name'])){
		 	if($_FILES['upfile']['error']==0){
		 		$pathinfo=pathinfo($_FILES["upfile"]['name']);
		 		$extension=$pathinfo['extension'];
		 		$file_url=$config['upload_path'].'/'.date("Ymd").time().".".$extension;
		 		$file_arr=array('doc','docx');

		 		if(!in_array($extension, $file_arr)){
		 			echo json_encode(array('code' => -1,'msg' =>'上传格式出错,请选择doc,docx格式的文件'));
		 			exit;
		 		}
		 		if(!move_uploaded_file ($_FILES['upfile']['tmp_name'], $file_url)){
		 			echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
		 			exit;
		 		}else{
		 			$linedoc=substr($file_url,1 );
		 			$linename=$_FILES['upfile']['name'];
		 			echo json_encode(array('code' =>200, 'msg' =>$linedoc));
		 		}
		 	}else{
		 		echo json_encode(array('code' => -1,'msg' =>'上传出错,请重新选择文件'));
		 		exit;
		 	}
        }else{
        	echo json_encode(array('code' => -1,'msg' =>'请选择文件'));
        	exit;
        }
	 }


	//删除订单
	function delete_order(){

	}


	/**
	 * @copyright	深圳海外国际旅行社有限公司
	 * @version		1.0
	 * @author		谢明丽
	 * 修改游客信息
	 */
	function update_traver(){
		$tyle = $this->input->post('tyle');
		$order_id = $this->input->post('data');
		if(!empty($tyle) && $tyle=="updata"){//修改游客信息
			$updata['num'] =$this->input->post('num');

			if($updata['num']>0){
				$id = $this->input->post('id');
				$name = $this->input->post('name');
				$sex = $this ->input ->post('sex');
				$certificate_type = $this->input->post('certificate_type');
				$certificate_no = $this->input->post('certificate_no');
				$telephone = $this->input->post('telephone');
				$birthday = $this->input->post('birthday');
				$endtime = $this->input->post('endtime');
				$country=$this->input->post('country');
				$enname=$this->input->post('enname');
				$sign_place=$this->input->post('sign_place');
				$sign_time=$this->input->post('sign_time');
			  for($i=0;$i<$updata['num'];$i++){
			 	 $orderid=$id[$i];
			 	 $data['name']=$name[$i];
			 	 $data['certificate_type']=$certificate_type[$i];
			 	 $data['certificate_no']=$certificate_no[$i];
			 	 $data['telephone']=$telephone[$i];
			 	 $data['sex'] = $sex[$i];
			     $data['birthday'] = $birthday[$i];
			     $data['endtime'] = $endtime[$i];
			     $data['country'] = $country[$i];
			     if(!empty($sign_place[$i])){
			     	$data['sign_place'] = $sign_place[$i];
			     }
			     if(!empty($enname[$i])){
			     	$data['enname'] = $enname[$i];
			     }
			     if(!empty($sign_time[$i])){
			     	$data['sign_time'] = $sign_time[$i];
			     }
			 	 $this->order->updata_travel($orderid,$data);
			 }
			 echo 1;
			}else{
				echo false;
			}
			$data['travel_info'] = $this->order->get_travel(array('mom.order_id'=>$order_id));
		}else{
			$data['travel_info'] = $this->order->get_travel(array('mom.order_id'=>$order_id));
			echo false;
		}
		// $this->load->view('/order/information_ajax',$data);
	}
	// * 修改游客信息
	function update_order_travel(){
		
		$id =intval($this->input->post('id'));
		$name = $this->input->post('name');
		$sex = $this ->input ->post('sex');
		$certificate_type = $this->input->post('certificate_type');
		$certificate_no = $this->input->post('certificate_no');
		$telephone = $this->input->post('telephone');
		$birthday = $this->input->post('birthday');
		$endtime = $this->input->post('endtime');
		$country=$this->input->post('country');
		$enname=$this->input->post('enname');
		$sign_place=$this->input->post('sign_place');
		$sign_time=$this->input->post('sign_time');
		

		$data['name']=$name;
		$data['certificate_type']=$certificate_type;
		$data['certificate_no']=$certificate_no;
		$data['telephone']=$telephone;
		$data['sex'] = $sex;
		$data['birthday'] = $birthday;
		$data['endtime'] = $endtime;
		$data['country'] = $country;
		
		//境外手机号验证
		if(!empty($telephone)){
			if (!preg_match("/^1[34578]{1}\d{9}$/",$telephone))
			{
				echo json_encode(array('status' => -1,'msg' =>'请输入正确的手机号'));
				exit;
			}
		}
	
		
		if(!empty($sign_place)){
			$data['sign_place'] = $sign_place;
		}
		if(!empty($enname)){
			$data['enname'] = $enname;
		}
		if(!empty($sign_time)){
			$data['sign_time'] = $sign_time;
		}
		if($id>0){
			$re=$this->order->updata_travel($id,$data);
			if($re){
				echo json_encode(array('status' => 1,'msg' =>'修改成功!'));
				exit;
			}else{
				echo json_encode(array('status' => -1,'msg' =>'修改失败!'));
				exit;
			}
		}else{
			echo json_encode(array('status' => -1,'msg' =>'修改失败!'));
			exit;
		}
			
	
	}

	//保存出游信息
	function save_info(){
		$birthday=$this->input->post('birthday');
		$certificate_no=$this->input->post('certificate_no');
		$certificate_type=$this->input->post('certificate_type');
		$country=$this->input->post('country');
		$endtime=$this->input->post('endtime');
		$name=$this->input->post('name');
		$order_id=$this->input->post('order_id');
		$sex=$this->input->post('sex');
		$telephone=$this->input->post('telephone');
		$country=$this->input->post('country');
		$dataArr=array('name'=>$name,
		           'certificate_no'=>$certificate_no,
				   'certificate_type' =>$certificate_type,
				   'endtime' =>$endtime,
				   'country'=>$country,
				   'telephone'=>$telephone,
				   'sex'=>$sex,
				   'birthday'=>$birthday,
				   'addtime'=>date('Y-m-d H:i:s',time()),
				   'country'=>$country,
		);
		//插入出游人表
		$id=$this->order->insert_tabledata('u_member_traver',$dataArr);

		if(is_numeric($id)){      //记录出游人信息表
			$memberArr=array(
				'order_id'=>$order_id,
				'traver_id'=>$id

			);
			$this->order->insert_tabledata('u_member_order_man',$memberArr);
		}
		echo $id;

	}
	/**
	 * @copyright	深圳海外国际旅行社有限公司
	 * @version		1.0
	 * @author		谢明丽
	 * 修改发票的信息
	 */
   function ajax_invoice(){
    	$tyle = $this->input->post('tyle');
    	$id = $this->input->post('id');
    	$invoice_name = $this->input->post('invoice_name');
    	$receiver = $this->input->post('receiver');
    	$address = $this->input->post('address');
    	$telephone = $this->input->post('telephone');
    	$order_id = $this->input->post('order_id');
    	if(!empty($tyle) && $tyle=="updata"){//修改发票信息
    		$updata['num'] =$this->input->post('num');
    		if($id>0){  //修改发票

    				$orderid=$order_id;
    				$data['invoice_name']=$invoice_name;
    				$data['receiver']=$receiver;
    				$data['address']=$address;
    				$data['telephone']=$telephone;
    				$data['modtime']=date('Y-m-d H:i:s',time());
    				$this->order->updata_invoice($id,$data);
    				//需要发票
    				$this->order->updata_order_stutas(array('id'=>$order_id),array('isneedpiao'=>1));
    		}else{  //插入发票
              //判断是否已有发票了。
    			$invoice_message=$this->order->get_alldata('u_member_order_invoice',array('order_id'=>$order_id));
    			if(empty($invoice_message)){
	    			$dataArr=array(
	    				'invoice_type'=>0,
	    				'invoice_name'=>$invoice_name,
	    				'receiver'=>$receiver,
	    				'telephone '=>$telephone,
	    				'address'=>$address,
	    				'addtime'=>date('Y-m-d H:i:s',time()),
	    			);
	    			$invoice_id=$this->order->insert_tabledata('u_member_invoice',$dataArr);

	                 //需要发票
	    			$this->order->updata_order_stutas(array('id'=>$order_id),array('isneedpiao'=>1));
	    			if(is_numeric($invoice_id)){
	    				$Arr=array('order_id'=>$order_id,
	    				          'invoice_id'=>$invoice_id
	    				);
	    				$this->order->insert_tabledata('u_member_order_invoice',$Arr);

	    			}
    			}

    		}

    		echo 1;
    		$data['invoice_info'] = $this->order->get_invoice($order_id);

    	}else{

    		$order_id = $this->input->post('data');
    		$data['invoice_info'] = $this->order->get_invoice($order_id);

    	}
    	echo $order_id;
   }

   /**
    * @copyright	深圳海外国际旅行社有限公司
    * @version		1.0
    * @author		谢明丽
    * 保存联系人的信息
    */
	  function save_concact(){
	  	$order_id = $this->input->post('id');
	  	$data['linkman'] = $this->input->post('linkman');
	  	$data['linkmobile'] = $this->input->post('linkmobile');
	  	$data['linktel'] = $this->input->post('linktel');
	  	$data['linkemail'] = $this->input->post('mail');
	    $res= $this->order->updata_concact($order_id,$data);
	    echo $res;
	  }



	/**
	 * @method 获取一条订单的信息
	 * @author 贾开荣
	 * @since  2015-06-10
	 */
	public function get_one_order_json() {
		$id = intval($_POST['id']);
		$order_info = $this ->order ->get_order_data(array('mo.id' =>$id));
		if (!empty($order_info)) {
			//最低支付价格
			$order_info ['min_pay_money'] = $order_info ['total_price'] * $order_info ['first_pay_rate'];
			$order_info ['final_pay'] = $order_info ['total_price'] - $order_info ['first_pay'];
			//查询目的地
			$dest_list = $this ->order ->get_dest_line($order_info ['overcity']);
			$dest_name = null;
			if (!empty($dest_list)) {
				foreach($dest_list as $key =>$val) {
					$dest_name = $val['kindname'].',';
				}
				$dest_name = rtrim($dest_name ,',');
			}
			$order_info ['dest_name'] = $dest_name;
			echo json_encode($order_info);
		} else {
			echo false;
		}
	}

	/*我的订单分享*/
	public  function add_share(){
		//启用session
		$this->load->library('session');
		$userid=$this->session->userdata('c_userid');

		$title=$this->input->post('title');
		$img_url=$this->input->post('img_url');
		$share_line_id=$this->input->post('share_line_id');
		//插入我的分享表
		$insert=array(
				'member_id'=>$userid,
				'content' =>$title,
				'addtime' =>date('Y-m-d H:i:s',time()),
				'praise_count'=>0,
				'location'=>'深圳',
				'line_id'=>$share_line_id
		);
		$share_id=$this->member->insert_data('u_line_share',$insert);
		if(is_numeric($share_id)){
			if(!empty($img_url)){

				foreach ($img_url as $k=>$v){
					$pic_insert=array('line_share_id'=>$share_id,'pic'=>$v);
					$pic_id=$this->member->insert_data('u_line_share_pic',$pic_insert);
				}
			}
		}else{
			//echo false;
			redirect($_SERVER['HTTP_REFERER']);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}

	//获取用户订单的付款信息
	function get_user_pay_message(){
		$order_id=$this->input->post('id');
		if(is_numeric($order_id)){
			$pay_message=$this->order->get_alldata('u_order_detail',array('order_id'=>$order_id));
			echo json_encode($pay_message);
		}else{

			echo false;
		}

	}
    function get_order_data(){
    	$order_id=$this->input->post('id');
    	if(is_numeric($order_id)){
    		//启用session
    		$this->load->library('session');
    		$userid=$this->session->userdata('c_userid');
    		$username=$this->order->get_alldata('u_member',array('mid'=>$userid));
    		$pay_message=$this->order->get_ordermessage(array('mo.id'=>$order_id));
    		$pay_message['username']=$username['nickname'];
    		echo json_encode($pay_message);
    	}else{

    		echo false;
    	}
    }
	/**
	 * 汪晓烽
	 * 2015-08-19
	 * @return [type] [description]
	 */
	function upload_receipt(){
		$name_str = $this ->input ->post('filename' ,true);
		$this->load->helper ( 'url' );
		$this->load->helper(array('form', 'url'));
		$config['upload_path'] = './file/c/';
		$config['allowed_types'] ='*';
		$config['max_size'] = '4000000000';
		$file_name = 'expert_'.$name_str.'_'.time();
		$config['file_name'] = $file_name;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($name_str))
		{
			echo json_encode(array('status' => -1,'msg' =>'请重新选择要上传的文件'));
			exit;
		}
		else
		{
			$file_info = array('upload_data' => $this->upload->data());
			$url =  '/file/c/' .$file_info ['upload_data'] ['file_name'];
			echo json_encode(array('status' =>1, 'url' =>$url ));
			exit;
		}
	}
	/**
	 * 在线合同
	 * */
	function show_order_contract($orderid)
	{
		$this ->load_model('contract_model');
		//权限判断
		$userid=$this->session->userdata('c_userid');
		$orderData = $this ->order ->getOrderLine($orderid ,$userid);
		if (empty($orderData))
		{
			echo "<script>alert('该订单不存在!');window.close();</script>";exit;
		}
		//合同类型
		if (in_array(1 ,explode(',',$orderData['overcity'])))
		{
			$type = 1;
			$code = 'BUA'.$orderData['ordersn'];
		}
		else
		{
			$type = 2;
			$code = 'BUB'.$orderData['ordersn'];
		}

		$contractData = $this ->contract_model ->row(array('type' =>$type));
		//第一个出游人
		$traverData = $this ->order ->getOrderTraver($orderid);
		if (empty($contractData) || empty($traverData))
		{
			echo "<script>alert('下载失败!');window.close();</script>";exit;
		}
		//替换合同变量
		$name = $type == 1 ? $traverData['enname'] : $traverData['name'];
		$content = str_replace('{#LINKMAN#}', $name, $contractData['content']);
		$content = str_replace('{#CONTRACTCODE#}', $code, $content);
		$content = str_replace('{#PEOPLES#}', $orderData['dingnum']+$orderData['childnum']+$orderData['childnobednum']+$orderData['oldnum'], $content);
		$content = str_replace('{#COMPANYNAME#}', $orderData['company_name'].$orderData['brand'], $content);
		if ($orderData['kind'] == 1)
		{
			$content = str_replace('{#SUPPLIERCODE#}', $orderData['licence_img_code'], $content);
		}
		else
		{
			$content = str_replace('{#SUPPLIERCODE#}', 'L-GD-CJ00052', $content);
		}

		$content = str_replace('{#LINENAME#}', $orderData['linename'], $content);
		$content = str_replace('{#USEDATE#}', $orderData['usedate'], $content);
		$content = str_replace('{#BACKDAY#}', date('Y-m-d' ,strtotime($orderData['usedate'])+($orderData['lineday']-1)*24*3600), $content);
		$content = str_replace('{#DAYS#}', $orderData['lineday'], $content);
		$content = str_replace('{#NIGHTS#}', $orderData['linenight'], $content);
		$content = str_replace('{#NIGHTS#}', $orderData['linenight'], $content);
		if($orderData['unit'] == 1)
		{
			$msg = '成人'.round($orderData['price']*$orderData['dingnum'] ,2).'元，';
			$msg .= '儿童占床'.round($orderData['childprice']*$orderData['childnum'] ,2).'元，';
			$msg .= '儿童不占床'.round($orderData['childnobedprice']*$orderData['childnobednum'] ,2).'元，';
			$msg .= '老人'.round($orderData['oldprice']*$orderData['oldnum'] ,2).'元';
		}
		else
		{
			$msg = $orderData['price'].'元/'.$orderData['unit'].'人套餐*'.$orderData['suitnum'];
		}
		$msg .= '(积分抵扣'.$orderData['jifenprice'].'元,优惠券抵扣'.$orderData['couponprice'].'元,保险费用'.$orderData['settlement_price'].'元)';
		$content = str_replace('{#SUITPRICE#}', $msg, $content);
		$content = str_replace('{#TOTALPRICE#}', round($orderData['total_price']+$orderData['settlement_price'],'2'), $content);

		$payWay = $orderData['pay_way'] == 0 ? '线下支付' : '线上支付';
		$content = str_replace('{#PAYWAY#}', $payWay ,$content);
		$content = str_replace('{#PAYTIME#}', $orderData['paytime'], $content);
		if ($orderData['isbuy_insurance'] == 1)
		{
			$content = str_replace('{#KUANG#}', '■', $content);
			$content = str_replace('{#YUAN#}', '□', $content);
			//查询保险
			$insurance = $this ->order ->getOrderInsurance($orderid);
			$name = '';
			if (!empty($insurance))
			{
				foreach($insurance as $v)
				{
					$name .= $v['insurance_name'].'、';
				}
			}
			$content = str_replace('{#INSURANCE#}', rtrim($name ,'、'), $content);
		}
		else
		{
			$content = str_replace('{#INSURANCE#}', '', $content);
			$content = str_replace('{#YUAN#}', '■', $content);
			$content = str_replace('{#KUANG#}', '□', $content);
		}

		$content = str_replace('{#FEENOTINCLUDE#}', $orderData['feenotinclude'], $content);
		$content = str_replace('{#LINKMAN#}', $traverData['name'], $content);
		$content = str_replace('{#COMPANYNAME#}', $orderData['company_name'].$orderData['brand'], $content);
		$content = str_replace('{#LINKID#}', $traverData['certificate_no'], $content);
		$content = str_replace('{#SUPPLIERMAN#}', $orderData['supplier_name'], $content);
		$content = str_replace('{#SUPPLIERMANCITY#}', $orderData['country'].$orderData['province'].$orderData['city'], $content);
		$content = str_replace('{#LINKMOBILE#}', $orderData['linkmobile'], $content);
		$content = str_replace('{#SUPPLIERMANMOBILE#}', $orderData['supplier_mobile'], $content);
		$content = str_replace('{#LINKEMAIL#}', $orderData['linkemail'], $content);
		$content = str_replace('{#SUPPLIERMANEMAIL#}', $orderData['supplier_email'], $content);
		$content = str_replace('{#ENTERTIME#}', $orderData['confirmtime_supplier'], $content);
		$this->load->library('fpdf');
		$html="<meta http-equiv='Content-Type' content='text/html; charset=utf8'>
			        <head>
			              <title>在线合同-帮游旅游网</title>
				    <style type='text/css'>
					      *{margin:0;padding:0;font-family:SimSun;}
					      body{margin:0;padding:0;font-weight:lighter;font-family:SimSun;width:100%;height:100%;font-size:14px;}
					      p.title{width:100%;height:32px;line-height:20px;background:#F2F2F2;padding:0 0 0 10px;}
					      p.title font{color:#fa8621;}
					      #content{width:96%;margin:20px 2% 0 2%;height:auto;}
					      #content{text-indent:2em;}
					      #content .part1{font-size:24px;text-align:center;}
					      #content .part2 p{height:24px;margin:10px auto;}
					      #content .part2 p.p1{text-align:right;}
					      #content .part2 p.p3{width:100%;height:auto;}
					      #content .part3 p{line-height:24px;}
				    </style>
				    </head>
				    <body>
				      <p class='title'>旅游合同&nbsp;&nbsp;<font>请仔细阅读旅游合同，具体出游信息以您填写的订单为准</font></p>
				      <div id='content'>
				           <div class='part2'>
					          ".$content."
					       </div>
				      </div>
			        </body>
			 ";
		//$html += "</p>";
		//<img src='lo.png' style='position:absolute;top:0;opacity:0.7;' />
		$this->fpdf->Outpdf($html ,'旅游合同.pdf' ,false);
	}
	//删除线路评价
	function del_line_comment(){
		$id=$this->input->post('id',true);
		$orderid=$this->input->post('orderid',true);
		if($id){
		      	$re=$this->order->updata_comment($id,$orderid);
		      	if($re){
		      		echo  json_encode(array('status'=>1,'msg'=>'删除成功!'));
		      	}else{
		      		echo  json_encode(array('status'=>-1,'msg'=>'删除失败!'));
		      	}
		}else{
			echo  json_encode(array('status'=>-1,'msg'=>'删除失败!'));
		}
	}

}