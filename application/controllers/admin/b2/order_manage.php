<?php
/**
 * 专家答题
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';
include_once './application/controllers/msg/t33_refund_msg.php';
class Order_manage extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/order_manage_model', 'order_manage');
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load_model('admin/b2/pay_manage_model', 'pay_manage');
		
		$this->load_model('admin/b2/v2/order_deal_model', 'order_deal');//版本二
	}
    /*
     * 我的订单
     * */
	function index() 
	{
		$data['real_name']=$this->session->userdata('real_name'); //真实姓名
		$data['is_manage']=$this->session->userdata('is_manage'); //是否是经理
		$data['depart_info'] = $this->pay_manage->get_depart(array('dep.id'=>$this->session->userdata('depart_id'))); //营业部信息
		// 所属营业部下所有的销售
		$data['expert_info'] = $this->expert->all('FIND_IN_SET(\''.$this->session->userdata('parent_depart_id').'\',depart_list)>0' );
		$this->load_view('admin/b2/order_manage_view',$data);
	}
	
	/*
	 * 我的订单： ajax数据
	 * */
	function ajax_get_orders()
	{
		//1、传值
		$company_name = trim($this ->input ->post('supplier' ,true));      //供应商名称
		$supplier_id = intval($this ->input ->post('supplier_id'));        //供应商id
		$linename = trim($this ->input ->post('linename' ,true));          //线路名称
		$order_sn = trim($this ->input ->post('order_sn' ,true));          //订单号
		$starttime = trim($this ->input ->post('starttime' ,true));        //出团开始时间
		$endtime = trim($this ->input ->post('endtime' ,true));            //出团结束时间
		$end_place = trim($this ->input ->post('end_place' ,true));        //目的地名称
		$end_place_id = trim($this ->input ->post('destid' ,true));  //目的地id
		$start_place = trim($this ->input ->post('start_place' ,true));    //出发地名称
		$start_place_id = trim($this ->input ->post('start_place_id' ,true)); //出发地id
		$expert = trim($this ->input ->post('expert' ,true));              //销售员
		$team_num = trim($this ->input ->post('team_num' ,true));          //团号
		$order_stastus = trim($this ->input ->post('order_stastus' ,true));  //订单状态
		
		//2、分页
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        $number = empty($number) ? 10 : $number;
        $page = empty($page) ? 1 : $page;
        
        //3、where条件
        $whereArr = array();
       	$is_manage = $this->session->userdata('is_manage');
       	if($is_manage==1){
       		$whereArr['mb_od.depart_id'] = 'FIND_IN_SET('.$this->session->userdata('depart_id').',mb_od.depart_list)>0';
       	}else{
       		$whereArr['mb_od.depart_id='] =$this->session->userdata('depart_id');
       	}
            
       	if (!empty($team_num))   $whereArr['suit_price.description like'] = '%'.$team_num.'%'; //团号
		if (!empty($linecode))   $whereArr['l.linecode like'] = '%'.$linecode.'%';             //线路编号
		if (!empty($linename))   $whereArr['l.linename like'] = '%'.$linename.'%';             //线路名称
		if (!empty($order_sn))   $whereArr['mb_od.ordersn like'] = '%'.$order_sn.'%';    //订单号
		if (!empty($starttime))  $whereArr['mb_od.usedate >='] = $starttime;           //出团时间
		if (!empty($endtime))    $whereArr['mb_od.usedate <='] = $endtime.' 23:59:59'; //结束时间
		if (!empty($expert))     $whereArr['mb_od.expert_id ='] = $expert;  //销售员
			//出发城市
		if (!empty($start_place_id))
		{
			$whereArr['ls.startplace_id ='] = $start_place_id;
		}
		elseif (!empty($start_place))
		{
			$whereArr['sp.cityname like'] = '%'.$start_place.'%';
		}
		   //订单状态
		if(!empty($order_stastus)){
			if($order_stastus==10){
				$whereArr['mb_od.status'] = 'mb_od.status IN(10,11)';
			}else{
				$whereArr['mb_od.status'] = 'mb_od.status ='.$order_stastus;
			}
		}
           //供应商
		if (!empty($supplier_id)){
			$whereArr['mb_od.supplier_id ='] = $supplier_id;
		}elseif(!empty($company_name)){
			$this ->load_model('supplier_model' ,'supplier_model');
			$destData = $this ->supplier_model ->all(array('company_name like' =>'%'.$company_name.'%'));
			if (empty($destData)) {
				echo json_encode($this ->defaultArr);exit;
			}else{
				foreach ($destData as $val) {
					$supplier_ids = $val['id'].',';
				}
				$whereArr['supplier_ids'] = 'mb_od.supplier_id IN ('.rtrim($supplier_ids,',').')';
			}
		}
			//目的地
		if (!empty($end_place_id)){
			$specialSql = ' find_in_set('.$end_place_id.' ,l.overcity)';
			$whereArr['overcity'] = $specialSql;
		}elseif (!empty($end_place)){
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$destData = $this ->dest_base_model ->all(array('kindname like' =>'%'.$end_place.'%'));
			if (empty($destData)) {
				echo json_encode($this ->defaultArr);exit;
			}else{
				$specialSql = ' (';
				foreach($destData as $v){
					$specialSql .= ' find_in_set('.$v['id'].' ,l.overcity) or';
				}
				$specialSql = rtrim($specialSql ,'or').') ';
			}
			$whereArr['overcity'] = $specialSql;
		}

        //4、sql查询
		$pagecount = $this->order_manage->get_orders($whereArr , 0,$number);     //总数据条数
		$order_list = $this->order_manage->get_orders($whereArr, $page,$number); //分页数据
		   //总页数
		if (($total = $pagecount - $pagecount % $number) / $number == 0) 
		{
             $total = 1;
	    }
	    else
	    {
	         $total = ($pagecount - $pagecount % $number) / $number;
	         if ($pagecount % $number > 0) 
	         {
	             $total +=1;
	         }
	    }
	   $data=array(
	               	"totalRecords" => $pagecount,
	               	"totalPages" =>  $total,
	                "pageNum" => $page,
	                "pageSize" => $number,
	               	"rows" => $order_list
            		);
		echo json_encode($data);
	}
	
	/*
	 * 订单详情页面
	 * */
	function go_order_detail()
	{
		$sum_ys=0;
		$sum_yf=0;
		$sum_bx=0;
		$sum_receive=0;
		$sum_receive_pending = 0;
		$sum_receive_total = 0;
		$sum_commission=0;
		$commission_data = array();
		$order_id = $this->input->get('order_id');
		$is_manage = $this->session->userdata('is_manage');

		//$this ->load_model('common/u_line_suit_price_model' ,'suit_price_model');
		$this->load_model('admin/b2/order_model', 'order');
		$this->load->model ( 'dictionary_model', 'dictionary_model' );
		$post_arr['mo.id'] = $order_id;

		$union_bank = $this->order_manage->get_union_bank();
		$order_detail_info = $this->order->get_order_detail ( $post_arr );
		$is_show_order=false;
		if(!empty($order_detail_info[0]))
		$is_show_order = $this->order_manage->is_show_order($order_id,$order_detail_info[0]['depart_id']);
		if(!$is_show_order){
			echo"<script>alert('拒绝查看');window.close();</script>";
		}
		//echo $this ->db ->last_query();exit();
		$order_people = $this->order->get_order_people ( $post_arr );

		$sum_receive_total = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status!='=>'3,4,6'));

		$sum_receive_pending = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status!='=>'2,3,4,6'));

		$total_receive_amount = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status='=>'2'));
		$order_detail_info[0]['total_receive_amount'] = !empty($total_receive_amount) ? $total_receive_amount['total_receive_amount'] : 0;
		//使用的发票
		$use_invoice = $this->order_manage->get_use_invoice_list($order_id);
		//使用的合同:纸质
		$use_contract = $this->order_manage->get_use_contract_list($order_id);
		//使用的合同:在线
		$use_online_contract = $this->order_manage->get_use_onlinecontract_list($order_id);
		//使用的收据
		$use_receipt = $this->order_manage->get_use_receipt_list($order_id);
		//应收账单
		$ys_data = $this->order_manage->get_ys_data(array('ys.order_id'=>$order_id));
		
		if(!empty($ys_data)){
			foreach ($ys_data as $key => $val) {
				if($val['status']==1){
					$sum_ys = $sum_ys+$val['amount'];
				}
			}
		}
		
		//应付账单
		$yf_data = $this->order_manage->get_yf_data(array('yf.order_id'=>$order_id));
		if(!empty($yf_data)){
			foreach ($yf_data as $key => $val) {
				if($val['status']==2){
					$sum_yf = $sum_yf+$val['amount'];
				}
			}
		}
		//保险账单
		$bx_data = $this->order_manage->get_bx_data($order_id);
		if(!empty($bx_data)){
			foreach ($bx_data as $key => $val) {
				//if($val['status']==2){
				$sum_bx = $sum_bx+$val['amount'];
				//}
			}
		}
		//已收账单
		$receive_data = $this->order_manage->get_receive_data($order_id);
		if(!empty($receive_data)){
			foreach ($receive_data as $key => $val) {
				if($val['status']==2){
					$sum_receive = $sum_receive+$val['money'];
				}
			}
		}

		if($order_detail_info[0]['diplomatic_agent']>0){
			$commission_data = $this->order_manage->get_commission_data($order_id);
			if(!empty($commission_data)){
				foreach ($commission_data as $key => $val) {
					//if($val['status']==1){
						$sum_commission = $sum_commission+$val['amount'];
					//}
				}
			}
		}

		$apply_limit =  $this->order_manage->get_apply_limit(array('order_id='=>$order_id));
        $apply_limit_zhong=$this->order_manage->get_apply_limit(array('order_id='=>$order_id,'status='=>1));
        $apply_limit_pass =  $this->order_manage->get_apply_limit(array('order_id='=>$order_id,'status='=>3));
		$travels_people =  $this->order_manage->get_travels($order_id);
		$order_insurance =  $this->order->get_order_insurance($order_id);
		$suit_price_data = $this->order_manage->get_suit_price_data(array('lsp.suitid'=>$order_detail_info[0]['suitid'],'lsp.`day`'=>"'".$order_detail_info[0]['usedate']."'",'lsp.is_open'=>1));
		if(!empty($apply_limit_pass)){
			$apply_limit_pass_str = '('.(!empty($apply_limit_pass[0]['company_name']) && $apply_limit_pass[0]['company_name']!='' ? $apply_limit_pass[0]['company_name'] : $apply_limit_pass[0]['union_name']) .'担保额度： '.$apply_limit_pass[0]['credit_limit'].'元，担保意见：'.$apply_limit_pass[0]['reply'].')';
		}else{
			$apply_limit_pass_str = '';
		}

		//线路信息
		$this ->load_model('admin/t33/sys/b_union_approve_line_model' ,'approve_line_model');
		$linelist=$this ->approve_line_model ->row(array('line_id' =>$order_detail_info[0]['productautoid']));
		if(!empty($linelist)) $lineData=$linelist;
		else $lineData=array('status'=>'2');
		// 供应商信息
		$this->load->model ( 'app/user_shop_model' );
		$supplier = $this->user_shop_model->get_user_shop_select ( 'u_supplier', array ('id' => $order_detail_info[0]['supplier_id']) );
		$data = array(
				'order_detail_info' => $order_detail_info[0],
				'order_id' => $order_id,
				'order_sn' => $order_detail_info[0]['line_sn'],
				'order_people' => $order_people,
				'ys_data'=>$ys_data,
				'yf_data'=>$yf_data,
				'bx_data'=>$bx_data,
				'receive_data'=>$receive_data,
				'sum_ys'=>$sum_ys,
				'sum_yf'=>$sum_yf,
				'sum_bx'=>$sum_bx,
				'line_type'=>$order_detail_info[0]['cer_type'],
				'sum_receive'=>$sum_receive,
				'travels_people'=>$travels_people,
				'commission_data'=>$commission_data,
				'sum_commission'=>$sum_commission,
				'apply_limit' =>!empty($apply_limit) ? $apply_limit[0] :array('credit_limit'=>0),
				'apply_limit_zhong'=>!empty($apply_limit_zhong) ? $apply_limit_zhong[0] :array('credit_limit'=>0),
				'apply_limit_pass'=>$apply_limit_pass_str,
				'order_insurance'=>$order_insurance,
				'suit_price_data'=>$suit_price_data,
				'is_manage'=>$is_manage,
				'union_bank'=>$union_bank,
				'userid'=>$order_detail_info[0]['expert_id'],
				'supplier'=>$supplier,
				'sum_receive_pending'=>$sum_receive_pending['total_receive_amount'],
				'sum_receive_total'=>$sum_receive_total['total_receive_amount'],
				'use_contract' =>empty($use_contract) ? '' : $use_contract,
				'use_online_contract' =>empty($use_online_contract) ? '' : $use_online_contract,
				'use_invoice' =>empty($use_invoice) ? '' : $use_invoice,
				'use_receipt' => empty($use_receipt) ? '' : $use_receipt,
				'lineData' =>$lineData
		);
		if ($order_detail_info[0]['cer_type']==1){
			//出境游
			$data['certificate'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_ABROAD_CERTIFICATE_TYPE);
		}else{
			//国内游
			$data['certificate'] = $this ->dictionary_model ->get_dictionary_data(sys_constant::DICT_DOMESTIC_CERTIFICATE_TYPE);
		}
		$this->load_view('admin/b2/order_detail_view',$data);
	}


	//生成申请额度编号
	protected function create_apply_code(){
		$strArr = range('A' ,'Z');
		$code = $strArr[mt_rand(0,25)].mt_rand(100000,999999);
		$this->load_model('admin/t33/b_limit_apply_model' ,'limit_apply_model');
		$applyData = $this ->limit_apply_model ->row(array('code' =>$code));
		if (!empty($applyData)) {
			$this ->create_apply_code();
		}
		return $code;
	}

	/*
	 * 改价：应收
	 * 1、改高应收
	 * 2、改低应收
	 */
	function apply_change_price()
	{
		//1、post数据
		$arrData = $this->security->xss_clean($_POST);
		$order_id = $arrData['change_order_id'];
		$pass_depart_id = $arrData['depart_id'];
		$is_cash =  $arrData['is_cash'];
		
		//2、数据查询
		$order_info = $this->order_manage->get_one_order($arrData['change_order_id']);
		$depart_limit = $this->order_manage->get_depart_limit($arrData['depart_id']);
		$sum_ys = $this->order_manage->get_sum_ys($arrData['change_order_id']);
		$sum_yf = $this->order_manage->get_sum_yf($arrData['change_order_id']);
		
		$whereArr['order_id='] = $arrData['change_order_id'];
		$whereArr['status!='] = '3,4,6';//获取不是拒绝的所有交款账单总和
		$sum_receive = $this->order_manage->get_sum_receive($whereArr);
		$is_manage = $this->session->userdata('is_manage');
		$arrData['num'] = (int)$arrData['num'];
		$add_total_price = (float)$arrData['price']*$arrData['num'];
		$sum_total = $sum_ys+$add_total_price;
		$diff_cash = 0;

		//3、逻辑验证
		if(empty($arrData['item'])){
			echo json_encode(array('status'=>204,'msg'=>'改价项目必选'));
			exit();
		}
		if (empty($arrData['price']) || !preg_match("/^(-?\d+)(\.\d+)?/", $arrData['price'])) {
			echo json_encode(array('status'=>202,'msg'=>'订单修改价必填数字'));
			exit();
		}

		if (empty($arrData['num']) || !preg_match("/^[0-9]*[1-9][0-9]*$/", $arrData['num'])) {
			echo json_encode(array('status'=>203,'msg'=>'数量为整数'));
			exit();
		}

		if($order_info['status']==2 || $order_info['status']==3 || $order_info['status']==10 || $order_info['status']==11){
			echo json_encode(array('status'=>214,'msg'=>'额度申请没有审核, 无法修改应收价'));
			exit();
		}

		if($order_info['ys_lock']==1){
			echo json_encode(array('status'=>212,'msg'=>'单团已核算不能修改应收'));
			exit();
		}

		if($order_info['order_deposit']>0 && $sum_total<$order_info['order_deposit']){
			echo json_encode(array('status'=>217,'msg'=>'应收金额不能小于订单的订金'));
			exit();
		}

		if($order_info['balance_complete']==2 && $add_total_price<=0){
			echo json_encode(array('status'=>213,'msg'=>'订单已结算只能改高应收价格'));
			exit();
		}

		if($order_info['status']!=9){
			if($add_total_price>($depart_limit['credit_limit']+$depart_limit['cash_limit'])){
				echo json_encode(array('status'=>205,'msg'=>'额度不足以此次加价'));
				exit();
			}
		}

		if($sum_total<$sum_yf){
			echo json_encode(array('status'=>209,'msg'=>'应收账单总计不能小于应付总计'));
			exit();
		}
		if($sum_total<(/*$order_info['diplomatic_agent']+*/$sum_receive['total_receive_amount'])){
			echo json_encode(array('status'=>211,'msg'=>'应收账单总额不能小于已收总额'));
			exit();
		}

		if($add_total_price<0 ){
			 if(abs($add_total_price)>($order_info['total_price']-abs($sum_receive['total_receive_amount']))){
				echo json_encode(array('status'=>206,'msg'=>'填写的价格不能小于未收款'/*.$order_info['total_price']*/));
				exit();
			}

			if(abs($sum_receive['total_receive_amount'])>=$order_info['total_price']){
				echo json_encode(array('status'=>209,'msg'=>'已交全款,请走退款流程'));
				exit();
			}

			if($order_info['supplier_cost']>($order_info['total_price']-abs($arrData['price']))){
				echo json_encode(array('status'=>210,'msg'=>'修改后应收价不能小于成本价'));
				exit();
			}
		}
		
		if($sum_ys<0 && (abs($sum_ys)-$order_info['total_price']>0.001)){
			echo json_encode(array('status'=>207,'msg'=>'还有未处理对冲应收账单'));
			exit();
		}

		if($sum_total<0 && (abs($sum_total)-$order_info['total_price']>0.001)){
			echo json_encode(array('status'=>208,'msg'=>'还有未处理对冲应收账单'));
			exit();
		}

		//4、修改应收：数据处理
		$this->db->trans_begin();//开启事物
		if($arrData['item']=="其他"){
			$arrData['item'] = $arrData['other_item'];
		}
		  //4.1 生成一条应收记录
		$ys_info = array(
				'item'=>$arrData['item'],
				'num'=>$arrData['num'],
				'price'=>$arrData['price'],
				'amount'=>  (empty($arrData['num']) || $arrData['num']==0) ? $arrData['price'] : $arrData['price']*$arrData['num'],
				'remark'=>	$arrData['beizhu'],
				'status'=>0,
				'source'=>2,
			);
		if($is_manage==1)
			$ys_info['status']=1; //如果是经理, 收款账单直接是通过状态
		  //4.2 若改高应收，还需生成一条交款记录
		if($is_cash==1 && $arrData['price']>0)
		{
			if($depart_limit['cash_limit']>0){
				if(($arrData['price']*$arrData['num'])>$depart_limit['cash_limit']){
					//改动的价格大于账户现金余额, 直接用全部现金余额交款
					$diff_cash = $depart_limit['cash_limit'];
				}else{
					//改动价格小于等于账户现金余额, 用部分账户现金余额交款
					$diff_cash = $arrData['price']*$arrData['num'];
				}
			}
			$receive_data = array(
				'money'=>$diff_cash,
				'way'=>'账户余额',
				'remark'=>'改高应收价格直接使用账户余额交款',
				'status'=>0
				);
			//如果是经理, 就相当于通过改价, 收款表直接插入一条记录 $this->order_manage->insert('u_order_receivable',$receive_data);
			if($order_info['status']!=9 && $is_manage==1){
				$receive_id = $this->order_manage->write_receive($arrData['change_order_id'],$receive_data);
			    $ys_info['sk_id']=$receive_id;
			   
			}
		}
		
		$ys_id = $this->order_manage->write_ys($arrData['change_order_id'],$ys_info);//应收账单插入一条记录

		   //4.3、经理操作的改价, 就直接通过并且重新计算额度和订单数据
		if($is_manage==1)
		{
			$this->cal_result($order_id, $pass_depart_id,$ys_info['amount'],1,$ys_id);
			
			//交完全款之后,重新计算返佣金, 就当前佣金和已返佣金对比, 从账户中多退少补
			$order_data = $this->order_manage->get_one_order($order_id);
			$receive_res = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status='=>2));
			if($order_data['total_price']==$receive_res['total_receive_amount'])
			{
				if($order_data['depart_balance']>$order_data['agent_fee']){
					$refund_agent_fee = $order_data['depart_balance']-$order_data['agent_fee'];
					$this->order_manage->del_cash($refund_agent_fee,$order_data['depart_id']);
					$insert_limit_log = array(
						'cut_money'=>-$refund_agent_fee,
						'type'=>'改应收,扣除多返的管家佣金',
						'remark'=>'b2:改应收,扣除多返的管家佣金'
						);
					$this->order_manage->write_limit_log($order_id,$insert_limit_log);
				}elseif($order_data['depart_balance']<$order_data['agent_fee']){
					$add_agent_fee = $order_data['agent_fee']-$order_data['depart_balance'];
					$this->order_manage->return_cash($add_agent_fee,$order_data['depart_id']);
					$insert_limit_log = array(
						'receivable_money'=>$add_agent_fee,
						'type'=>'改应收,增加管家佣金',
						'remark'=>'b2:改应收,增加管家佣金'
						);
					$this->order_manage->write_limit_log($order_id,$insert_limit_log);
				}
				$this->db->update('u_member_order',array('depart_balance'=>$order_data['agent_fee']),array('id'=>$order_id));
			}

		}
		$this->order_manage->write_order_log($order_id,'在订单详情页面，调整应收：'.$ys_info['amount']);
		//exit();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			$arrData['realname'] = $this->session->userdata('real_name');
			if($is_manage==1){
				$arrData['status']=1;
				//发送消息
				$msg = new T33_send_msg();
				$msgArr = $msg ->billYsManager($ys_id,1,$this->session->userdata('real_name'));
			}else{
				$arrData['status']=0;
				//发送消息
				$msg = new T33_send_msg();
				$msgArr = $msg ->billYsUpdate($ys_id,1,$this->session->userdata('real_name'));
			}
			$arrData['addtime'] = date('Y-m-d H:i');
			echo json_encode(array('status'=>200,'msg'=>$arrData));
			exit();
		}
	}//End 改价


	//申请佣金调整提交接口(暂时停用了)
	function apply_commission(){
		$arrData = $this->security->xss_clean($_POST);

		if(empty($arrData['item'])){
			echo json_encode(array('status'=>204,'msg'=>'改价项目必选'));
			exit();
		}
		if (empty($arrData['price']) || !preg_match("/^(-?\d+)(\.\d+)?/", $arrData['price'])) {
			echo json_encode(array('status'=>202,'msg'=>'订单修改价必填数字'));
			exit();
		}
		if($arrData['item']=="其他"){
			$arrData['item']=$arrData['other_item'];
		}
		$insert_agent_data = array(
				'order_id'=>$arrData['agent_order_id'],
				'expert_id'=>$this->expert_id,
				'item'=>$arrData['item'],
				'num'=>$arrData['num'],
				'agent'=>$arrData['price'],
				'depart_id'=>$this->session->userdata('depart_id'),
				'expert_name'=>$this->session->userdata('real_name'),
				'amount'=>  (empty($arrData['num']) || $arrData['num']==0) ? $arrData['price'] : $arrData['price']*$arrData['num'],
				'reason'=>	$arrData['beizhu'],
				'status'=>0,
				'addtime'=>date('Y-m-d H:i:s')
			);
		$status = $this->db->insert('u_order_agent_apply',$insert_agent_data);
		if($status){
			$arrData['realname'] = $this->session->userdata('real_name');
			echo json_encode(array('status'=>200,'msg'=>$arrData));
			exit();
		}else{
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}
	}//End 佣金调整



	/*
	 * 申请退团：退团退人、退团不退人
	 * @post: 
	 *        refund_ys     退应收
	 *        refund_yj     退已交
	 *        refund_yf     退应付
	 *        tuituan_id    参团人id（判断退人还是不退人）
	 *        tuituan_order_id   退团的订单id
	 *        suit_day_id        u_line_suit_price表的dayid
	 *        pass_depart_id     部门id
	 * */ 
	function apply_tuituan_price()
	{
		//1、post数据
		$arrData = $this->security->xss_clean($_POST);
		$arrData['refund_ys']=trim($arrData['refund_ys']);
		$arrData['refund_yf']=trim($arrData['refund_yf']);
		$arrData['refund_yj']=trim($arrData['refund_yj']);

		//2、逻辑验证
		if($arrData['refund_yj']==0 && $arrData['refund_ys']==0 && $arrData['refund_yf']==0){
    			echo json_encode(array('status'=>205,'msg'=>'三个数值不能同时为0'));
				exit();
		}
		if($arrData['refund_yf'] !=0 && !preg_match('/^-[0-9]+(.[0-9]{1,3})?$/', $arrData['refund_yf'])){
    			echo json_encode(array('status'=>202,'msg'=>'退供应商必填合法负数'));
				exit();
		}
		if($arrData['refund_ys']!=0 && !preg_match('/^-[0-9]+(.[0-9]{1,3})?$/', $arrData['refund_ys'])){
    				echo json_encode(array('status'=>203,'msg'=>'退应收必填合法负数'));
				exit();
		}
		if($arrData['refund_yj']!=0 && !preg_match('/^-[0-9]+(.[0-9]{1,3})?$/', $arrData['refund_yj'])){
    				echo json_encode(array('status'=>204,'msg'=>'退已交款必填合法负数'));
				exit();
		}

		//3、变量赋值
		$is_manage = $this->session->userdata('is_manage');//是否是经理
		$order_id = $arrData['tuituan_order_id'];
		//$mt_name = "";
		//$mt_total_price = 0;
		//$mt_total_cost  = 0;
		$total_foreign_agent = 0;//默认增加的外交佣金是 0
		$add_platform_fee = 0;  //平台佣金
		$total_agent = 0; //总的佣金(是外交佣金或者平台佣金)
		$arrData['refund_yf'] = (float)$arrData['refund_yf'];
		$arrData['refund_ys'] = (float)$arrData['refund_ys'];
		$arrData['refund_yj'] = (float)$arrData['refund_yj'];
		$pass_depart_id = $arrData['pass_depart_id'];
		$group_traver_arr = array();
		
		//4、数据查询
		$this->db->trans_begin();     //开启事物
		$this->load_model('common/u_line_model', 'line');
		$order_info = $this->order_manage->get_one_order($arrData['tuituan_order_id']); //订单信息
		$sum_yf = $this->order_manage->get_sum_yf($arrData['tuituan_order_id']);        //总应付
		$sum_ys = $this->order_manage->get_sum_ys($arrData['tuituan_order_id']);        //总应收
		$sum_pay = $this->order_manage->get_sum_pay(array('order_id='=>$arrData['tuituan_order_id'])); //总结算金额(供应商申请)
		   //总已交（去除已拒绝的）
		$sum_receive = $this->order_manage->get_sum_receive(array('order_id='=>$arrData['tuituan_order_id'],'status!='=>'3,4,6')); 
		   //总已交(已通过)
		$receive_res = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status='=>2));
		$sum_receive2 = $this->order_manage->get_sum_receive(array('order_id='=>$arrData['tuituan_order_id'],'status='=>2));
		   //"退团中"的数据 (存在审核中的退团,就不可以再次新增退团, 否则可以)
		$refund_data = $this->order_manage->get_refund_data(array('order_id='=>$arrData['tuituan_order_id'],'status!='=>'-1,-2,3'));
		   //新的总应收、应付、已交(与3个框的值重新计算)
		$sum_yf_total = $sum_yf+$arrData['refund_yf'];
		$sum_ys_total = $sum_ys+$arrData['refund_ys'];
		$sum_receive_total = $sum_receive['total_receive_amount']+$arrData['refund_yj'];
		   //退已交款的金额和已交款账单总和的值加起来
		$sum_receive_pending = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status!='=>'2,3,4,6'));
		$sum_receive_total_pending = $sum_receive_pending['total_receive_amount']+$arrData['refund_yj'];
        
		//5、后台逻辑限制
		if(!empty($refund_data) && ($refund_data['status']==0 || $refund_data['status']==1 || $refund_data['status']==2)){
			switch ($refund_data['status']) {
				case '1':
					$msg = "目前还有一条待供应商审核的退团记录";
					break;
				case '2':
					$msg = "目前还有一条待旅行社审核的退团记录";
					break;
				default:
					$msg = "目前还有一条待经理审核的退团记录";
					break;
			}
			echo json_encode(array('status'=>214,'msg'=>$msg));
			exit();
		}     //退团中的订单不能再次申请退团
		if($order_info['status']==2 || $order_info['status']==3 || $order_info['status']==10 || $order_info['status']==11){
			echo json_encode(array('status'=>214,'msg'=>'信用额度申请正在等待审核, 无法退订'));
			exit();
		}     // 信用额度申请正在等待审核, 无法退订
		if($order_info['ys_lock']==1){
			echo json_encode(array('status'=>212,'msg'=>'单团已核算后不能退订'));
			exit();
		}     //单团已核算后不能退订
		if($order_info['balance_complete']==2){
			echo json_encode(array('status'=>213,'msg'=>'订单已结算不能退订退团'));
			exit();
		}     //订单已结算不能退订退团

		/*if($sum_pay['total_pay_amount']>$sum_yf_total){
			if($sum_pay['total_pay_amount']>0){
				echo json_encode(array('status'=>215,'msg'=>'供应商已结算：'.$sum_pay['total_pay_amount'].',无法退订'));
			}else{
			   echo json_encode(array('status'=>215,'msg'=>'供应商已结算总金额大于成本总额,无法退订'));
			}
			exit();
		}*/

		/*if($arrData['refund_yf']<0 && ($sum_yf_total<$order_info['balance_money'])){
			echo json_encode(array('status'=>209,'msg'=>'退供应商金额低于已结算金额,无法退订'));
			exit();
		}*/

		if($arrData['refund_yf']<0 && (abs($arrData['refund_yf'])>$order_info['supplier_cost'])){
			echo json_encode(array('status'=>209,'msg'=>'退供应商超过成本价'));
			exit();
		}

		if($arrData['refund_ys']<0 && (abs($arrData['refund_ys'])>$order_info['total_price'])){
			echo json_encode(array('status'=>206,'msg'=>'退应收超过订单总金额'.abs($order_info['total_price'])));
			exit();
		}

		if($arrData['refund_yj']<0 && (abs($arrData['refund_yj'])>$sum_receive['total_receive_amount'])){
			echo json_encode(array('status'=>221,'msg'=>'退已交超过已交款'));
			exit();
		}

		if($sum_ys_total<$sum_yf_total){
			  echo json_encode(array('status'=>220,'msg'=>'应收总计不能小于应付总计'));
			  exit();
		   }
		/*if($order_info['diplomatic_agent']>0){
			if($sum_ys_total<($order_info['diplomatic_agent']+$sum_yf_total)){
			  echo json_encode(array('status'=>219,'msg'=>'应收总计减外交佣金不能大于应付总计'));
			  exit();
		   }
		}else{
			if($sum_ys_total<$sum_yf_total){
			  echo json_encode(array('status'=>220,'msg'=>'应收总计不能大于应付总计'));
			  exit();
		   }
		}*/

		if($sum_ys_total<$sum_receive_total){
			echo json_encode(array('status'=>211,'msg'=>'应收账单总额不能小于已交总额'));
			exit();
		}

		if($receive_res['total_receive_amount']>=$order_info['total_price']){
			if($arrData['refund_ys']!=$arrData['refund_yj']){
				echo json_encode(array('status'=>212,'msg'=>'交完全款之后退应收应该等于退已交'));
				exit();
			}
		}

		if($sum_yf_total<0 && (abs($sum_yf_total)-$order_info['supplier_cost']>0.001)){
			echo json_encode(array('status'=>207,'msg'=>'还有未处理对冲应付账单'));
			exit();
		}
		if($sum_ys_total<0 && (abs($sum_ys_total)-$order_info['total_price']>0.001)){
			echo json_encode(array('status'=>208,'msg'=>'还有未处理对冲应收账单'));
			exit();
		}
        
		// 6、数据增删查改
		$insert_yf_data = array(
			'item'=>'退团',
			'num'=> 1,
			'oldnum'=> 0,
			'childnum'=>0,
			'childnobednum'=> 0,
			'price'=>$arrData['refund_yf'],
			'amount'=>$arrData['refund_yf'],
			'status'=>0,
			'user_type'=>1
		);   //应付
		$insert_ys_data = array(
			'item'=>'退团 ',
			'num'=>1,
			'price'=>$arrData['refund_ys'],
			'amount'=>$arrData['refund_ys'],
			'status'=>0,
			'source'=>2
		);
		if($is_manage==1){
			$insert_ys_data['status'] = 1;
			$insert_ys_data['m_time'] = date('Y-m-d H:i:s');
			$insert_yf_data['status'] = 1;
			$insert_yf_data['m_time'] = date('Y-m-d H:i:s');
		}   //应收
		$insert_receive_data = array(
			'money'=>$arrData['refund_yj'],
			'status'=>0,
			'way'=>"账户余额",
			'from'=>1
		);  //已交
		
		// 7、退团 
		if (!isset($arrData['tuituan_id']) || empty($arrData['tuituan_id'])) 
		{
		   //退团不退人的时候
				$yf_remark =  '退团不退人，退应付：'.($arrData['refund_yf']).'元';
				$insert_yf_data['remark'] =$yf_remark;
				$insert_yf_data['kind'] =4;
				$ys_remark = '退团不退人，退应收：'.($arrData['refund_ys']).'元';
				$insert_ys_data['remark'] =$ys_remark;
				$insert_receive_data['remark'] = '退团不退人,退已交：'.$insert_receive_data['money'].'元';
				if($is_manage==1)
				{
						$insert_receive_data['status'] = 1; //经理已提交
						if(!empty($arrData['refund_yj']) && $arrData['refund_yj']!=0)
						{
							//退已交不等于已经交款的,就直接插入该条负数记录
							if($sum_receive_total_pending!=0){
								$receive_id  = $this->order_manage->write_receive($order_id,$insert_receive_data);
								$refund_receive_id = $receive_id;
							}else{
							//退已等于已交款的记录, 那就不写入记录, 直接取消之前审核中的交款,为了避免全团退之后有一条记录没人处理, 一直在转圈的状态
								$receive_res = $this->order_manage->get_pedding_receive($order_id);
								$refund_receive_id  = $receive_res['recevie_ids'];
								$this->order_manage->cancle_receive($order_id);
								$receive_id  = 0;
							}
						}
						else
						{
							$refund_receive_id = $receive_id  = 0;
						}
						$insert_ys_data['sk_id'] = $receive_id;
						
				 }
				
				$insert_receive_data['kind'] = 4;
				$ys_id  = $this->order_manage->write_ys($order_id,$insert_ys_data);
				$insert_yf_data['ys_id'] = $ys_id;
				if(!empty($arrData['refund_yf']) && $arrData['refund_yf']!=0){
						$yf_id  = $this->order_manage->write_yf($order_id,$insert_yf_data);
				}else{
						$yf_id  = 0;
				}
				$insert_refund_data = array(
							'order_id'=>$arrData['tuituan_order_id'],
							'expert_id'=>$order_info['expert_id'],
							'ys_money'=>$arrData['refund_ys'],
							'ys_id'=>$ys_id,
							'sk_money'=>$arrData['refund_yj'],
							'union_id'	=> $this->session->userdata('union_id'),
							'yf_money' => $arrData['refund_yf'],
							'yf_id' => $yf_id,
							'holder'=>$arrData['card_holder'],
							'bank'	=>$arrData['open_bank'],
							'brand'	=>$arrData['branch_bank'],
							'account'	=>$arrData['card_num'],
							'num'	=>0,
							'remark'=>$arrData['beizhu'],
							'status' =>0
				);
				if($is_manage==1)  //如果退应付录入的是0，供应商那边不用审批（其实是经理帮供应商做了审批动作，为了避免管家佣金出错）；如果退已交款录入的是0，就直接跳过旅行社审批。反之， 三个数值都录入的是非0，那么就要按照 经理审批--->供应商审批--->旅行社审批
				{
						if($yf_id==0)
						{  //退应付录入的是0
							if($insert_refund_data['sk_money']==0){
								$insert_refund_data['status'] = 3;
								$insert_refund_data['sk_id'] = $refund_receive_id;
							}else{
								$insert_refund_data['status'] = 2;
								$insert_refund_data['sk_id'] = $refund_receive_id;
							}
						}
						else
						{
							$insert_refund_data['status'] = 1;
							$insert_refund_data['sk_id'] = $refund_receive_id;
						}
				}
				$this->db->insert('u_order_refund',$insert_refund_data);
				$refundId = $this->db->insert_id();
				
				//订单操作日志
				$this->order_manage->write_order_log($arrData['tuituan_order_id'],'在订单详情页面，退团不退人：退应收'.$arrData['refund_ys'].'、退已交'.$arrData['refund_yj'].'、退应付'.$arrData['refund_yf']);
		}
		else
		{
		  //退团并且退人
			$traver_id = $arrData['tuituan_id'];
			$traver_id_arr = explode(',', $arrData['tuituan_id']);
			$travels_people =  $this->order_manage->get_tuituan_travels($arrData['tuituan_id']);
			$group_traver = $this->order_manage->get_group_count($arrData['tuituan_id']);
			
			//统计各个类型人群的数量   1是成人、2是老人、3是儿童占床、4是儿童不占床
			foreach ($group_traver  as $key => $value) {
				$group_traver_arr[$value['people_type']]['count_type'] = $value['count_type'];
				$group_traver_arr[$value['people_type']]['mt_price'] 	= $value['mt_price'];
				$group_traver_arr[$value['people_type']]['mt_cost'] 	= $value['mt_cost'];
			}
			
			$num 					= (isset($group_traver_arr['1']['count_type']) && $group_traver_arr['1']['count_type']!=0) ? $group_traver_arr['1']['count_type']:0;
			$oldnum 				= (isset($group_traver_arr['2']['count_type']) && $group_traver_arr['2']['count_type']!=0) ? $group_traver_arr['2']['count_type']:0;
			$childnum  			= (isset($group_traver_arr['3']['count_type']) && $group_traver_arr['3']['count_type']!=0) ? $group_traver_arr['3']['count_type']:0;
			$childnobednum 		= (isset($group_traver_arr['4']['count_type']) && $group_traver_arr['4']['count_type']!=0) ? $group_traver_arr['4']['count_type']:0;

			$num_cost			= (isset($group_traver_arr['1']['mt_cost']) && $group_traver_arr['1']['mt_cost']!=0) ? $group_traver_arr['1']['mt_cost']:0;
			$oldnum_cost 		= (isset($group_traver_arr['2']['mt_cost']) && $group_traver_arr['2']['mt_cost']!=0) ? $group_traver_arr['2']['mt_cost']:0;
			$childnum_cost  		= (isset($group_traver_arr['3']['mt_cost']) && $group_traver_arr['3']['mt_cost']!=0) ? $group_traver_arr['3']['mt_cost']:0;
			$childnobednum_cost 	= (isset($group_traver_arr['4']['mt_cost']) && $group_traver_arr['4']['mt_cost']!=0) ? $group_traver_arr['4']['mt_cost']:0;

			$num_price			= (isset($group_traver_arr['1']['mt_price']) && $group_traver_arr['1']['mt_price']!=0) ? $group_traver_arr['1']['mt_price']:0;
			$oldnum_price		= (isset($group_traver_arr['2']['mt_price']) && $group_traver_arr['2']['mt_price']!=0) ? $group_traver_arr['2']['mt_price']:0;
			$childnum_price  		= (isset($group_traver_arr['3']['mt_price']) && $group_traver_arr['3']['mt_price']!=0) ? $group_traver_arr['3']['mt_price']:0;
			$childnobednum_price 	= (isset($group_traver_arr['4']['mt_price']) && $group_traver_arr['4']['mt_price']!=0) ? $group_traver_arr['4']['mt_price']:0;

			$ding_cost 			= $num*$num_cost;
			$old_cost			= $oldnum*$oldnum_cost;
			$child_cost 		= $childnum*$childnum_cost;
			$childnobed_cost 	= $childnobednum*$childnobednum_cost;
			$total_tuituan_cost = $ding_cost+$old_cost+$child_cost+$childnobed_cost;

			$ding_price 		= $num*$num_price;
			$old_price 			= $oldnum*$oldnum_price;
			$child_price 		= $childnum*$childnum_price;
			$childnobed_price 	= $childnobednum*$childnobednum_price;
			$total_tuituan_price = $ding_price+$old_price+$child_price+$childnobed_price;

			/******************start  此部分和"退团不退人"一样    start**************/
			$yf_remark = '退团退'.count($traver_id_arr).'人，退应付：'.($arrData['refund_yf']).'元';
			$insert_yf_data['remark'] = $yf_remark;
			$insert_yf_data['kind'] 	   = 2;

			$ys_remark = '退团退'.count($traver_id_arr).'人，退应收：'.($arrData['refund_ys']).'元';
			$insert_ys_data['remark'] = $ys_remark;
			$insert_receive_data['remark'] = '退团退'.count($traver_id_arr).'人,退已交:'.$insert_receive_data['money'];
			
			if($is_manage==1)
			{
				$insert_receive_data['status'] = 1;
				if(!empty($arrData['refund_yj']) && $arrData['refund_yj']!=0)
				{
					if($sum_receive_total_pending!=0)
					{
						$receive_id  = $this->order_manage->write_receive($order_id,$insert_receive_data);
						$refund_receive_id = $receive_id;
					}
					else
					{
						$receive_res = $this->order_manage->get_pedding_receive($order_id);
						$refund_receive_id  = $receive_res['recevie_ids'];
						$this->order_manage->cancle_receive($order_id);
						$receive_id  = 0;
					}
				}
				else
				{
					$receive_id  = 0;
					$refund_receive_id = 0;
				}
				$insert_ys_data['sk_id'] = $receive_id;
				     
			}
			
			$insert_receive_data['kind'] = 2;             
			$ys_id  = $this->order_manage->write_ys($order_id,$insert_ys_data);
			$insert_yf_data['ys_id'] = $ys_id;
			
			$yf_id  = $this->order_manage->write_yf($order_id,$insert_yf_data);
			
			$insert_refund_data = array(
					'order_id'=>$arrData['tuituan_order_id'],
					'expert_id'=>$order_info['expert_id'],
					'ys_money'=>$arrData['refund_ys'],
					'ys_id'=>$ys_id,
					'sk_money'=>$arrData['refund_yj'],
					'union_id'	=> $this->session->userdata('union_id'),
					'yf_money' => $arrData['refund_yf'],
					'yf_id' => $yf_id,
					'holder'=>$arrData['card_holder'],
					'bank'	=>$arrData['open_bank'],
					'brand'	=>$arrData['branch_bank'],
					'account'	=>$arrData['card_num'],
					'num'	=>count($traver_id_arr),
					'remark'=>$arrData['beizhu']
				);
			if($is_manage==1)
			{
				if($yf_id==0)
				{
					if($insert_refund_data['sk_money']==0)
					{
						$insert_refund_data['status'] = 3;
						$insert_refund_data['sk_id'] = $refund_receive_id;
					}
					else
					{
						$insert_refund_data['status'] = 2;
						$insert_refund_data['sk_id'] = $refund_receive_id;
					}
				}
				else
				{
					$insert_refund_data['status'] = 1;
					$insert_refund_data['sk_id'] = $refund_receive_id;
				}
			}
			$this->db->insert('u_order_refund',$insert_refund_data);
			$refundId = $this->db->insert_id();
			/*******************end  此部分和"退团不退人"一样   end ********/
	
			if($is_manage==1)
			{
				//外交佣金和平台佣金  type=1外交佣金、type=2为平台佣金
				$agent_rules = $this->order_manage->get_agent_rules($order_id);  
				if(!empty($agent_rules))
				{
					if($agent_rules['kind']==1 || $agent_rules['kind']==4)
					{ //按照人头算佣金
						if($order_info['suitnum']==0) //非套餐
						    $total_agent = ($num*$agent_rules['adultprice'])+($childnobednum*$agent_rules['childnobedprice'])+($oldnum*$agent_rules['oldprice'])+($childnum*$agent_rules['childprice']);
						else  //套餐
							$total_agent = $order_info['suitnum']*$agent_rules['adultprice'];
						
						if($agent_rules['type']==1)
						{
							//外交佣金
							$total_foreign_agent = $total_agent;
							$insert_wj_log = array(
							'num'=>1,
							'price'=>-$total_foreign_agent,
							'amount'=>-$total_foreign_agent,
							'remark' =>'退订参团人,退外交佣金: '.$total_foreign_agent,
							'item' =>'退订参团人'
							);
							$this->order_manage->write_wj($order_id,$insert_wj_log);
						}
						else
						{
							//平台管理费
							$add_platform_fee = $total_agent;
							$insert_yj_log = array(
							'num'=>1,
							'price'=>-$add_platform_fee,
							'amount'=>-$add_platform_fee,
							'item' =>'退订参团人',
							'm_time'=>date('Y-m-d H:i:s'),
							'a_time'=>date('Y-m-d H:i:s'),
							'status'=>2,
							'remark'=>'退订参团人,退平台管理费: '.$add_platform_fee
							);
							$this->order_manage->write_yj($order_id,$insert_yj_log);
						}
					}
					elseif($agent_rules['kind']==2)
					{  //按照比例算佣金,对应的账单只需要写一个
							$total_agent = abs($total_tuituan_price)*$agent_rules['ratio'];
							if($agent_rules['type']==1)
							{
								//外交佣金
								$total_foreign_agent = $total_agent;
								$insert_wj_log = array(
									'num'=>1,
									'price'=>-$total_foreign_agent,
									'amount'=>-$total_foreign_agent,
									'remark' =>'退订参团人,退外交佣金: '.$total_foreign_agent,
									'item' =>'退订参团人'
									);
								$this->order_manage->write_wj($order_id,$insert_wj_log);
							}
							else
							{
								//平台管理费
								$add_platform_fee = $total_agent;
								$insert_yj_log = array(
									'num'=>1,
									'price'=>-$add_platform_fee,
									'amount'=>-$add_platform_fee,
									'item' =>'退订参团人',
									'm_time'=>date('Y-m-d H:i:s'),
									'a_time'=>date('Y-m-d H:i:s'),
									'status'=>2,
									'remark'=>'退订参团人,退平台管理费: '.$add_platform_fee
									);
								$this->order_manage->write_yj($order_id,$insert_yj_log);
							}
					}
					elseif($agent_rules['kind']==3)
					{ //按照天数算佣金,对应的账单只需要写一个
							$total_agent = ($num+$oldnum+$childnum+$childnobednum)*$agent_rules['dayprice'];
							if($agent_rules['type']==1){
								//外交佣金
								$total_foreign_agent = $total_agent;
								$insert_wj_log = array(
									'num'=>1,
									'price'=>-$total_foreign_agent,
									'amount'=>-$total_foreign_agent,
									'remark' =>'退订参团人,退外交佣金: '.$total_foreign_agent,
									'item' =>'退订参团人'
									);
								$this->order_manage->write_wj($order_id,$insert_wj_log);
							}
							else
							{
								//平台管理费，按人群写入账单
								
// 								$add_platform_fee = $total_agent;
// 								$insert_yj_log = array(
// 										'num'=>1,
// 										'price'=>-$add_platform_fee,
// 										'amount'=>-$add_platform_fee,
// 										'item' =>'退订参团人',
// 										'm_time'=>date('Y-m-d H:i:s'),
// 										'a_time'=>date('Y-m-d H:i:s'),
// 										'status'=>2,
// 										'remark'=>'退订参团人,退平台管理费: '.$add_platform_fee
// 								);
// 								$this->order_manage->write_yj($order_id,$insert_yj_log);
								
								$add_platform_fee = round($num*$agent_rules['dayprice']+$childnum*$agent_rules['dayprice_child']+$childnobednum*$agent_rules['dayprice_childnobed'],2);
								if ($num >0)
								{
									//成人
									$amount = round($num*$agent_rules['dayprice'] ,2);
									$insert_yj_log = array(
											'num'=>$num,
											'price'=>-$agent_rules['dayprice'],
											'amount'=>-$amount,
											'item' =>'退订参团人',
											'm_time'=>date('Y-m-d H:i:s'),
											'a_time'=>date('Y-m-d H:i:s'),
											'status'=>2,
											'remark'=>'退订参团人(成人),退平台管理费: '.$amount
									);
									$this->order_manage->write_yj($order_id,$insert_yj_log);
								}
								if ($childnum >0)
								{
									//小孩占床
									$amount = round($childnum*$agent_rules['dayprice_child'] ,2);
									$insert_yj_log = array(
											'num'=>$childnum,
											'price'=>-$agent_rules['dayprice_child'],
											'amount'=>-$amount,
											'item' =>'退订参团人',
											'm_time'=>date('Y-m-d H:i:s'),
											'a_time'=>date('Y-m-d H:i:s'),
											'status'=>2,
											'remark'=>'退订参团人(小孩占床),退平台管理费: '.$amount
									);
									$this->order_manage->write_yj($order_id,$insert_yj_log);
								}
								if ($childnobednum >0)
								{
									//小孩不占床
									$amount = round($childnobednum*$agent_rules['dayprice_childnobed'] ,2);
									$insert_yj_log = array(
											'num'=>$childnobednum,
											'price'=>-$agent_rules['dayprice_childnobed'],
											'amount'=>-$amount,
											'item' =>'退订参团人',
											'm_time'=>date('Y-m-d H:i:s'),
											'a_time'=>date('Y-m-d H:i:s'),
											'status'=>2,
											'remark'=>'退订参团人(小孩不占床),退平台管理费: '.$amount
									);
									$this->order_manage->write_yj($order_id,$insert_yj_log);
								}
							}
					}
					
				}
				//参团人、订单数据变化
				$this->order_manage->save_tuituan_travels($arrData['tuituan_id'],$arrData['tuituan_order_id'],$yf_id);
				$this->db->query('DELETE FROM u_member_traver where id IN ('.$traver_id.')');
				$this->db->query('DELETE FROM u_member_order_man where traver_id IN ('.$traver_id.') AND order_id='.$arrData['tuituan_order_id']);
				$this->db->query('UPDATE u_member_order SET dingnum=dingnum-'.$num.',oldnum=oldnum-'.$oldnum.', childnum=childnum-'.$childnum.',childnobednum=childnobednum-'.$childnobednum.',diplomatic_agent=diplomatic_agent-'.$total_foreign_agent.',platform_fee=platform_fee-'.$add_platform_fee.' WHERE id='.$arrData['tuituan_order_id']);

				$travels_people =  $this->order_manage->get_travels($order_id);
				if(empty($travels_people)){
					//全团退人的时候订单状态变成退订中
					$this->db->query('UPDATE u_member_order SET status=-3 WHERE id='.$arrData['tuituan_order_id']);
					$this->db->query('UPDATE u_line_suit_price SET number=number+'.($num+$oldnum+$childnum+$childnobednum).',order_num=order_num-1 WHERE dayid='.$arrData['suit_day_id']);
				}else{
					$this->db->query('UPDATE u_line_suit_price SET number=number+'.($num+$oldnum+$childnum+$childnobednum).' WHERE dayid='.$arrData['suit_day_id']);
				}


			}
			else
			{
				$insert_tuituan_travel = array(
					'ys_id'=>$ys_id,
					'order_id'=>$arrData['tuituan_order_id'],
					'travel_id'=>$traver_id,
					'num'=>$num,
					'childnum'=>$childnum,
					'childnobednum'=>$childnobednum,
					'oldnum'=>$oldnum,
					'suit_day_id'=>$arrData['suit_day_id']
					);
				$this->db->insert('u_record_tuituan_travel',$insert_tuituan_travel);
			}
			//订单操作日志
			$this->order_manage->write_order_log($arrData['tuituan_order_id'],'在订单详情页面，退团退'.count($group_traver).'人：退应收'.$arrData['refund_ys'].'、退已交'.$arrData['refund_yj'].'、退应付'.$arrData['refund_yf']);
		}

		//8、经理操作的直接就重新计算额度和订单数据: 
		/*    
		 *    按$arrData['refund_yj']的值来退款
		 *   
		 *     
		 * */
		
		if($is_manage==1)
		{
                //退款(按退已交的值去退款)
				$cash_refund=abs($arrData['refund_yj']);
				$this->order_manage->return_cash(abs($arrData['refund_yj']),$order_info['depart_id']);
				//退已交的值去还u_order_debit表的现金
				$insert_limit_log = array(
					'refund_monry'=>abs($arrData['refund_yj']),
					'type'=>'退订退款',
					'addtime'=>date('Y-m-d H:i:s',strtotime("-2 second")),
					'remark'=>'经理通过退订退款申请(使用公式)',
					'log_start'=>'退订退款，'
				);
				 $this->order_manage->reback_debit($order_id,'1',$insert_limit_log['refund_monry'],'退团还额度');
				//退应收-退已交  的值去还管家信用额度
				 $config=array(
				 	'order_id'=>$order_id,
				 	'ys_amount'=>$insert_ys_data['amount']+$insert_limit_log['refund_monry'], //填的退应收的值(正值)+返还的现金（负值）
				 	'log_start'=>'退团退款'
				 );
				 if($config['ys_amount']<0)
				 $this->order_deal->return_limit($config);
				 //写额度明细日志
				 if($insert_limit_log['refund_monry']!=0)
				 {
					 unset($insert_limit_log['log_start']);
					 $this->order_manage->write_limit_log($order_id,$insert_limit_log);
				 }
				 //更新u_order_refund表的cash_refund字段,方便供应商拒绝时知道该退多少钱
				 $this->order_manage->update_cash_refund($ys_id,$cash_refund);
				 
				 //修改订单数据
				 $after_order_info['total_price'] = $order_info['total_price']+$insert_ys_data['amount'];
				 $after_order_info['supplier_cost'] = $order_info['supplier_cost'];
				 $after_order_info['agent_fee'] = $after_order_info['total_price']-$after_order_info['supplier_cost']-$order_info['diplomatic_agent'];
				 $this->db->update('u_member_order',$after_order_info,array('id'=>$order_id));
				 //若不走供应商审核退款流程，且已交全款，已返管家佣金，则扣回已返的管家佣金
				 if($yf_id==0){ 
				 	
				 	if($sum_receive['total_receive_amount']>=$order_info['total_price']&&$order_info['depart_balance']!=0)
				 	{
				 		$limitMoney=$order_info['depart_balance']-$after_order_info['agent_fee'];
				 		
				 		$insert_limit_log = array(
				 				'cut_money'=>-$limitMoney,
				 				'type'=>'退已交款后，未交全款，扣回已返管家佣金',
				 				'remark'=>'b2：改高应收扣额度'
				 		);
				 		
				 		$this->order_manage->del_limit($order_id,$pass_depart_id,$limitMoney,$insert_limit_log);
				 		$this->db->update('u_member_order',array('depart_balance'=>'0'),array('id'=>$order_id));
				 	}
				 }
				
				 
	    }//End  is_manage
	   
	    //exit();
	    // 9、提交数据
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}
		else
		{
			$this->db->trans_commit();
			//发起退团申请的时候, 发一个消息提醒
			$this ->sendMsgOrderWX(array('orderid' =>$arrData['tuituan_order_id'] ,'refundId' =>$refundId,'type'=>3));
			if (isset($refundId))
			{
				$msg = new T33_refund_msg();
				$msgArr = $msg ->sendMsgRefund($refundId,1,$this->session->userdata('real_name'),$is_manage);
			}
			echo json_encode(array('status'=>200,'msg'=>'已提交,等待审核'));

		}
	}//End 退团

	/*
	 * 改应付：数据提交接口
	 */
	function apply_suplier_pay()
	{
		$arrData = $this->security->xss_clean($_POST);
		$is_manage = $this->session->userdata('is_manage');
		$order_info = $this->order_manage->get_one_order($arrData['supplier_order_id']);
		$depart_limit = $this->order_manage->get_depart_limit($order_info['depart_id']);
		$sum_yf = $this->order_manage->get_sum_yf($order_info['id']);
		$add_total_cost = (float)$arrData['price']*$arrData['num'];
		
		if($add_total_cost>$depart_limit['cash_limit']&&$add_total_cost>0&&$order_info['status']!="9"){
			echo json_encode(array('status'=>201,'msg'=>'营业部账户余额不足以抵扣调高的应付'));
			exit();
		}
		if($order_info['yf_lock']==1){
			echo json_encode(array('status'=>212,'msg'=>'单团核算不能修改成本价'));
			exit();
		}

		if($order_info['balance_complete']==2 && $add_total_cost<=0){
			echo json_encode(array('status'=>213,'msg'=>'订单已结算只能改高应付价'));
			exit();
		}

		if (!preg_match("/^[1-9]\d*$/", $arrData['num'])) {
			echo json_encode(array('status'=>205,'msg'=>'数量必须是正整数'));
			exit();
		}

		//echo (!is_int($arrData['price']+0) && !is_float($arrData['price'])+0);exit();

		if (!is_int($arrData['price']+0) && !is_float($arrData['price']+0)) {
			echo json_encode(array('status'=>206,'msg'=>'应付必填合法数字'));
			exit();
		}

		if(($arrData['price']*$arrData['num']+$sum_yf)>($order_info['total_price']-$order_info['diplomatic_agent'])){
			echo json_encode(array('status'=>207,'msg'=>'累计应付供应商成本不能大于应收减去外交佣金'));
			exit();
		}

		if(($arrData['price']*$arrData['num']+$sum_yf)<0){
			echo json_encode(array('status'=>207,'msg'=>'累计应付供应商成本不能是小于0'));
			exit();
		}
		$this->db->trans_begin();//开启事物
		if($arrData['item']=="其他"){
			$arrData['item'] = $arrData['other_item'];
		}
		$insert_yf_data = array(
				'item'=>$arrData['item'],
				'num'=> $arrData['num'],
				'oldnum'=> 0,
				'childnum'=> 0,
				'childnobednum'=> 0,
				'price'=>$arrData['price'],
				'amount'=>$arrData['price']*$arrData['num'],
				'remark'=>$arrData['beizhu'],
				'status'=>1,
				'user_type'=>1,
				'kind'=>3
			);
		$yf_id = $this->order_manage->write_yf($arrData['supplier_order_id'],$insert_yf_data);
		$this->order_manage->write_order_log($arrData['supplier_order_id'],'在订单详情页面，调整应付：'.$insert_yf_data['amount']);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			$this ->sendMsgOrderWX(array('orderid' =>$order_info['id'],'yfId'=>$yf_id,'type'=>2));
			$arrData['addtime'] = date('Y-m-d H:i');
			$arrData['realname'] = $this->session->userdata('real_name');

			//发送消息
			$msg = new T33_send_msg();
			$msgArr = $msg ->billYfExpert($yf_id,1,$this->session->userdata('real_name'));
			echo json_encode(array('status'=>200,'msg'=>$arrData));
			exit();
		}
	}//End 应付供应商数据提交接口
	
	/*
	 * 供应商发起的修改成本价(应付价)：审核通过操作
	* */
	function pass_b1()
	{
		$order_id = $this->input->post('order_id');
		$yf_id		= $this->input->post('id');
	
		$this->db->trans_begin();//开启事物
		$yf_data = $this->order_manage->get_one_yf($yf_id);
		$order_data = $this->order_manage->get_one_order($order_id);
		$sum_yf = $this->order_manage->get_sum_yf($order_id);
		$sum_ys = $this->order_manage->get_sum_ys($order_id);
		$depart_limit = $this->order_manage->get_depart_limit($order_data['depart_id']);
	
		if($yf_data['status']!=0){
			echo json_encode(array('status'=>202,'msg'=>'该条记录已审核'));
			exit();
		}
		if($sum_yf>$sum_ys){
			echo json_encode(array('status'=>201,'msg'=>'应付总额大于应收,请先调高应收价'));
			exit();
		}
		if($yf_data['amount']>$depart_limit['cash_limit']&&$yf_data['amount']>0&&$order_data['status']!="9"){
			echo json_encode(array('status'=>201,'msg'=>'营业部账户余额不足以抵扣调高的应付'));
			exit();
		}
	
		$supplier_cost = $order_data['supplier_cost']+$yf_data['amount'];
		$agent_fee = $order_data['total_price'] - $order_data['diplomatic_agent'] - $supplier_cost;
		$order_sql = 'UPDATE u_member_order SET agent_fee='.$agent_fee.',supplier_cost='.$supplier_cost.' WHERE id='.$order_id;
		$this->db->query($order_sql);
		$update_yf = array(
				'm_time'=>date('Y-m-d H:i:s'),
				'manager_id'=>$this->expert_id,
				'm_remark'=>$this->session->userdata('real_name').' 在 '.date('Y-m-d H:i:s').' 通过了供应商的成本修改申请',
				'status'=>2
		);
		$this->db->update('u_order_bill_yf',$update_yf,array('id'=>$yf_id));
		/*
			* 当已收全款-营业部额度变化 重新计算管家佣金 @xml
		*/
		$this->load->model ( 'admin/b1/order_status_model','b1_order' );
		$this->b1_order->change_expert_limit($order_id,$yf_id,$order_data['supplier_id'],'b2');
	
		// 判断是否 结算价!= 修改后的成本 订单的已结算改成未结算 @xml
		$this->b1_order->update_order_balance($order_id);
		//订单操作日志
		$this->order_manage->write_order_log($order_id,'在订单详情页面，审核通过：供应商调整应付'.$yf_data['amount']);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			//发送消息
			$msg = new T33_send_msg();
			$msgArr = $msg ->billYfSupplier($yf_id,2,$this->session->userdata('real_name'));
			echo json_encode(array('status'=>200,'msg'=>'已提交'));
			exit();
		}
	}
	
	/*
	 * 供应商发起的修改成本价(应付价)：审核拒绝操作
	* */
	function refuse_b1()
	{
		$order_id = $this->input->post('refuse_b1_order_id');
		$yf_id		= $this->input->post('refuse_b1_id');
		$yf_data = $this->order_manage->get_one_yf($yf_id);
		$refuse_b1_reason = $this->input->post('refuse_b1_reason');
		$this->db->trans_begin();//开启事物
		$update_yf = array(
				'm_time'=>date('Y-m-d H:i:s'),
				'expert_id'=>$this->expert_id,
				'm_remark'=>$refuse_b1_reason,//$this->session->userdata('real_name').' 在 '.date('Y-m-d H:i:s').' 拒绝了供应商的成本修改申请',
				'status'=>3
		);
		$this->db->update('u_order_bill_yf',$update_yf,array('id'=>$yf_id));
		//订单操作日志
		$this->order_manage->write_order_log($order_id,'在订单详情页面，审核拒绝：供应商调整应付'.$yf_data['amount']);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			//发送消息
			$msg = new T33_send_msg();
			$msgArr = $msg ->billYfSupplier($yf_id,2,$this->session->userdata('real_name'));
			echo json_encode(array('status'=>200,'msg'=>'已提交'));
			exit();
		}
	}
	/*
	 * 新增交款：数据提交接口
	* */
	function apply_receive()
	{
		$is_manage = $this->session->userdata('is_manage');
		$this->load_model('admin/b2/change_approval_model', 'change_approval');
		$arrData = $this->security->xss_clean($_POST);
		$arrData['price'] = (float)$arrData['price'];
		$order_info = $this->order_manage->get_one_order($arrData['receive_order_id']);
		$manage = $this->order_manage->get_manage();
		$whereArr['order_id='] = $order_info['id'];
		$whereArr['status!='] = '3,4,6';
		$total_receive_amount = $this->order_manage->get_sum_receive($whereArr);
		$final_res 		= $this->change_approval->get_depart_limit($order_info['depart_id']);
		if ($arrData['price']=='0' || !preg_match("/^\d+(\.\d+)?/", $arrData['price'])) {
			echo json_encode(array('status'=>202,'msg'=>'订单交款必填正数'));
			exit();
		}
		if ($arrData['price']>$order_info['total_price']) {
			echo json_encode(array('status'=>203,'msg'=>'交款金额不能超过应收价'));
			exit();
		}
		if (($arrData['price']+$total_receive_amount['total_receive_amount'])>$order_info['total_price']) {
			echo json_encode(array('status'=>204,'msg'=>'累计交款金额不能超过应收价'));
			exit();
		}
	
		if($order_info['status']==2 || $order_info['status']==3 || $order_info['status']==10 || $order_info['status']==11){
			echo json_encode(array('status'=>214,'msg'=>'额度申请没有审核, 无法修新增交款'));
			exit();
		}
		/* if($order_info['status']=="9"&&$order_info['order_deposit']>0)
		{
			$allow_receive=$order_info['total_price']-$total_receive_amount['total_receive_amount']-$order_info['order_deposit'];
			if($arrData['price']>$allow_receive){  //临时保存的押金订单，允许交的钱小于等于 “未交款金额-押金金额”
		    echo json_encode(array('status'=>213,'msg'=>'该订单是定金订单，最大可交款金额为'.$allow_receive.'元'));
		    exit();
			}
		} */
		
		if($order_info['balance_complete']==2 && $arrData['price']<=0){
			echo json_encode(array('status'=>213,'msg'=>'订单已结算交款金额只能是正数'));
			exit();
		}
		if($arrData['way']=="账户余额"){
			if($arrData['price']>$final_res['cash_limit']){
				echo json_encode(array('status'=>205,'msg'=>'账户现金额度不够交款'));
				exit();
			}
		}
		$this->db->trans_begin();//开启事物
		$this->load->model('common/u_expert_model','expert_model');
		$expert_info = $this->expert_model->get_expert_data($order_info['expert_id']);
		$insert_receive_data = array(
				'money'=>$arrData['price'],
				'way'=>$arrData['way'],
				'remark'=>$arrData['beizhu'],
				'union_name'=>$expert_info['union_name'],
				'kind'=>1,
				//'bankcard'=>$arrData['bank_num'],
				//'bankname'=>$arrData['bank_info'],
				'code_pic'=>$arrData['water_pic'],
				'status'=>0,
				'from'=>1,
				'is_urgent'=>$arrData['is_urgent']
		);
		$this->db->insert('code_sk_voucher',array('code'=>'S'));
		$code = $this->db->insert_id();
		$insert_receive_data['code'] = $code.'S';
	
		if($arrData['way']=="账户余额"){
			$this->order_manage->del_cash($arrData['price'],$order_info['depart_id']);
			//额度使用账单日志
			$insert_limit_log = array(
					'cut_money'=>-$arrData['price'],
					'type'=>'销售人员新增交款',
					'remark'=>'b2:销售人员在订单详情页面新增一条交款,扣额度'
			);
			$this->order_manage->write_limit_log($arrData['receive_order_id'],$insert_limit_log);
			unset($insert_receive_data['bankcard']);
			unset($insert_receive_data['bankname']);
			$arrData['bank_num'] = '';
			$arrData['bank_info']='';
		}
		$receive_id = $this->order_manage->write_receive($arrData['receive_order_id'],$insert_receive_data);
		$this->order_manage->write_order_log($arrData['receive_order_id'],'在订单详情页面，新增交款：'.$insert_receive_data['money']);
	    //exit();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			$arrData['realname'] = $this->session->userdata('real_name');
			$arrData['addtime'] = date('Y-m-d H:i');
	
			//发送消息
			$msg = new T33_send_msg();
			$msgArr = $msg ->receivableMsg($receive_id,1,$this->session->userdata('real_name'));
			echo json_encode(array('status'=>200,'msg'=>$arrData));
			exit();
		}
	
	}//End 订单收款
	//添加出团人表单提交
	function add_people(){
		/**
		 * 添加的总人数必须<= 剩余的余位
		 * 添加的总金额 <= 可用额度;
		 * ★ 可用额度算法: b_depart表:{credit_limit(信用额度)+cash_limit(现金额度)}+b_expert_limit_apply表:{apply_amount-real_amount}
		 * ★添加的总金额 = (人数*对应单价)之和
		 */
		$arrData = $this->security->xss_clean($_POST);
		$this->load_model('common/u_line_model', 'line');
		$add_people_arr = array();
		$total_foreign_agent = 0;//默认增加的外交佣金是 0
		$add_platform_fee = 0;  //平台佣金
		$total_agent = 0; //总的佣金(是外交佣金或者平台佣金)
		$add_limit = 0;
		$order_id			= $arrData['add_order_id'];
		$line_id 			= $arrData['line_id'];
		$s_agent_rate	    = $arrData['s_agent_rate']; //供应商设置的平台佣金费率
		$agent_rate_child   = $arrData['agent_rate_child'];//儿童费率
		$agent_rate_int	    = $arrData['agent_rate_int'];//成人费率
		$overcity2			= $arrData['overcity2'];//目的地
		$order_sn 		    = $arrData['add_order_sn'];
		$order_unit		    = $arrData['order_unit']; //这个字段来判断是不是套餐订单
		$line_type			= $arrData['line_type'];
		$suit_day_id		= $arrData['suit_day_id'];
		$adult_price		= $arrData['adult_price'];
		$old_price			=  $arrData['old_price'];
		$child_price 		= $arrData['child_price'];
		$child_nobed_price  = $arrData['child_nobed_price'];
		$sale_depart_id     = $arrData['sale_depart_id'];
		$lineday			=	$arrData['lineday'];
		$supplier_id		=	$arrData['supplier_id'];

		$child_num		= isset($arrData['child_num']) && !empty($arrData['child_num']) ? $arrData['child_num'] : 0;
		$childnobed_num = isset($arrData['childnobed_num']) && !empty($arrData['childnobed_num']) ? $arrData['childnobed_num'] : 0;
		$old_num			= isset($arrData['old_num']) && !empty($arrData['old_num']) ? $arrData['old_num'] : 0;
		$dingnum	= isset($arrData['dingnum']) && !empty($arrData['dingnum']) ? $arrData['dingnum'] : 0;
		$receive_id = 0;
		//1、订单操作日志
		$log_content='在订单详情页面，添加参团人：';
		if($arrData['dingnum']>0)
			$log_content.='成人'.$arrData['dingnum'].'个*'.$arrData['adult_price'].'元';
		if($arrData['child_num']>0)
			$log_content.='    儿童占床'.$arrData['child_num'].'个*'.$arrData['child_price'].'元';
		if($arrData['childnobed_num']>0)
			$log_content.='    儿童不占床'.$arrData['childnobed_num'].'个*'.$arrData['child_nobed_price'].'元';
		$this->order_manage->write_order_log($arrData['add_order_id'],$log_content);
		
		//2、线路、订单、套餐、营业部信用等信息
		$line_info = $this->line->getLineInfo(array('l.id'=>$line_id));
		if($line_info[0]['deposit']>0){ //有订金的线路
				$total_add_price = ($dingnum*$adult_price)+($childnobed_num*$child_nobed_price)+($old_num*$old_price)+($child_num*$child_price);
				$total_price = ($dingnum+$childnobed_num+$old_num+$child_num)*$line_info[0]['deposit'];
		}else{
				if($order_unit>=2){
					$dingnum	= $arrData['dingnum'];
					$total_price = $arrData['dingnum']*$adult_price;
					$total_add_price =  $arrData['dingnum']*$adult_price;
				}else{
					$total_price = ($dingnum*$adult_price)+($childnobed_num*$child_nobed_price)+($old_num*$old_price)+($child_num*$child_price);
					$total_add_price = ($dingnum*$adult_price)+($childnobed_num*$child_nobed_price)+($old_num*$old_price)+($child_num*$child_price);
				}
		}
		$order_info = $this->order_manage->get_one_order($order_id); //订单信息
		$suit_price_data = $this->order_manage->get_suit_price_data(array('lsp.dayid'=>$suit_day_id)); //套餐信息
		$final_res = $this->order_manage->get_depart_limit($sale_depart_id);

        //3、逻辑验证
		if($order_info['ys_lock']==1){
			echo json_encode(array('status'=>212,'msg'=>'单团核算后不能修改添加参团人'));
			exit();
		}
		if($order_info['status']==2 || $order_info['status']==3 || $order_info['status']==10 || $order_info['status']==11){
			echo json_encode(array('status'=>214,'msg'=>'额度申请没有审核, 无法修改新增参团人'));
			exit();
		}
		if($order_info['balance_complete']==2){
			echo json_encode(array('status'=>213,'msg'=>'订单已结算不能添加参团人'));
			exit();
		}
		if(($child_num+$childnobed_num+$dingnum+$old_num)==0){
			echo json_encode(array('status'=>204,'msg'=>'还没有添加参团人'));
			exit();
		}
		if(($child_num+$childnobed_num+$dingnum+$old_num)>$suit_price_data['number']){
			echo json_encode(array('status'=>201,'msg'=>'添加的总人数超过余位'));
			exit();
		}
		if($total_price>($final_res['cash_limit']+$final_res['credit_limit'])){
			echo json_encode(array('status'=>202,'msg'=>'添加总金额超过可用额度'));
			exit();
		}

		$this->db->trans_begin();//开启事物
		//4、添加参团人信息
		$birthday_arr 		= $arrData['birthday'];
		$card_num_arr 	    = $arrData['card_num'];
		$card_type_arr	    = $arrData['card_type'];
		$name_arr		    = $arrData['name'];
		$people_type_arr	= $arrData['people_type'];
		$sex_arr			= $arrData['sex'];
		$tel_arr			= $arrData['tel'];
		$arr_count = count($name_arr);

		if($line_type==1){//出境游的时候才会有这些数据
			$endtime_arr		= $arrData['endtime'];
			$enname_arr		= $arrData['enname'];
			$sign_place_arr	= $arrData['sign_place'];
			$sign_time_arr	= $arrData['sign_time'];
			for($i=0; $i<$arr_count; $i++){
				if($people_type_arr[$i]==1){
					$sell_price = $adult_price;
					$cost_price = $adult_price-$suit_price_data['agent_rate_int'];
				}elseif($people_type_arr[$i]==2){
					$sell_price = $old_price;
					$cost_price = $old_price-$suit_price_data['agent_rate_int'];
				}elseif ($people_type_arr[$i]==3) {
					$sell_price = $child_price;
					$cost_price = $child_price-$suit_price_data['agent_rate_child'];
				}elseif($people_type_arr[$i]==4){
					$sell_price = $child_nobed_price;
					$cost_price = $child_nobed_price-$suit_price_data['agent_rate_childno'];
				}
				$insert_data = array(
					'name'				=>$name_arr[$i],
					'enname'			=>$enname_arr[$i],
					'certificate_type' 	=>$card_type_arr[$i],
					'certificate_no'	=>$card_num_arr[$i],
					'endtime'			=>$endtime_arr[$i],
					'telephone'			=>$tel_arr[$i],
					'sex'				=>$sex_arr[$i],
					'birthday'			=>$birthday_arr[$i],
					'addtime'			=>date('Y-m-d H:i:s'),
					'sign_place'		=>$sign_place_arr[$i],
					'sign_time'			=>$sign_time_arr[$i],
					'price'				=>$sell_price,  //售卖价格
					'cost'				=>$cost_price,//成本价
					'people_type'		=>$people_type_arr[$i]
					);
				$this->db->insert('u_member_traver',$insert_data);
				$travel_id = $this->db->insert_id();
				$this->db->insert('u_member_order_man',array('order_id'=>$order_id,'traver_id'=>$travel_id));
			}
		}else{
			for($i=0; $i<$arr_count; $i++){
				//计算当前类型人群的成本价
				if($people_type_arr[$i]==1){
					$sell_price = $adult_price;
					$cost_price = $adult_price-$suit_price_data['agent_rate_int'];
				}elseif($people_type_arr[$i]==2){
					$sell_price = $old_price;
					$cost_price = $old_price-$suit_price_data['agent_rate_int'];
				}elseif ($people_type_arr[$i]==3) {
					$sell_price = $child_price;
					$cost_price = $child_price-$suit_price_data['agent_rate_child'];
				}elseif($people_type_arr[$i]==4){
					$sell_price = $child_nobed_price;
					$cost_price = $child_nobed_price-$suit_price_data['agent_rate_childno'];
				}
				$insert_data = array(
					'name'				=>$name_arr[$i],
					'certificate_type' 	=>$card_type_arr[$i],
					'certificate_no'	=>$card_num_arr[$i],
					'telephone'			=>$tel_arr[$i],
					'sex'				=>$sex_arr[$i],
					'birthday'			=>$birthday_arr[$i],
					'addtime'			=>date('Y-m-d H:i:s'),
					'price'				=>$sell_price,  //售卖价格
					'cost'				=>$cost_price,//成本价
					'people_type'		=>$people_type_arr[$i]
					);
				$this->db->insert('u_member_traver',$insert_data);
				$travel_id = $this->db->insert_id();
				$this->db->insert('u_member_order_man',array('order_id'=>$order_id,'traver_id'=>$travel_id));
			}
		}
		//5、扣除余位
		if($order_unit>=2){//套餐类型
			$this->db->query('UPDATE u_line_suit_price SET number=number-'.($child_num+$childnobed_num+($dingnum*$order_unit)+$old_num).' WHERE dayid='.$suit_day_id);
		}else{//非套餐类型
			$this->db->query('UPDATE u_line_suit_price SET number=number-'.($child_num+$childnobed_num+$dingnum+$old_num).' WHERE dayid='.$suit_day_id);
		}

		//6、 扣额度
		//现金额度足够抵扣新增加的人所需要的钱
		if($final_res['cash_limit']>=$total_price){
			$this->order_manage->del_cash($total_price,$sale_depart_id);
			$debit_sql = 'UPDATE u_order_debit SET real_amount=real_amount+'.$total_price.',status=0 WHERE order_id='.$order_id.' AND type=1';
			$this->db->query($debit_sql);
			if($line_info[0]['deposit']>0){
				//订金线路添加人的时候, 单团额度也要跟着变化
				$debit_sql2 = 'UPDATE u_order_debit SET real_amount=real_amount+'.($total_add_price-$total_price).',status=0 WHERE order_id='.$order_id.' AND type=3';
				$this->db->query($debit_sql2);

				$add_limit=$total_add_price-$total_price; //需另外再申请的额度
				$add_limit_sql="UPDATE b_limit_apply set credit_limit=credit_limit+".$add_limit." where order_id=".$order_id;
				$this->db->query($add_limit_sql);
				$add_expert_limit_sql="UPDATE b_expert_limit_apply set apply_amount=apply_amount+".$add_limit.",real_amount=real_amount+".$add_limit." where order_id=".$order_id;
				$this->db->query($add_expert_limit_sql);
			}
		}else{
			//现金额度不足以够抵扣新增加的人所需要的钱
			//现金扣完了
			$this->order_manage->del_cash($final_res['cash_limit'],$sale_depart_id);
			//继续扣除营业部信用额度
			$this->order_manage->del_credit($total_price,$sale_depart_id,$final_res['cash_limit']);
			$debit_sql1 = 'UPDATE u_order_debit SET real_amount=real_amount+'.$final_res['cash_limit'].',status=0 WHERE order_id='.$order_id.' AND type=1';
			$this->db->query($debit_sql1);
			$diff_credit_limit = $total_price-$final_res['cash_limit'];
			$debit_sql2 = 'UPDATE u_order_debit SET real_amount=real_amount+'.$diff_credit_limit.',status=0 WHERE order_id='.$order_id.' AND type=2';
			$this->db->query($debit_sql2);
			if($line_info[0]['deposit']>0){
				//订金线路添加人的时候, 单团额度也要跟着变化
				$debit_sql3 = 'UPDATE u_order_debit SET real_amount=real_amount+'.($total_add_price-$total_price).',status=0 WHERE order_id='.$order_id.' AND type=3';
				$this->db->query($debit_sql3);

				$add_limit=$total_add_price-$total_price; //需另外再申请的额度。等式成立原因是因为前面有 total_price > limit_cash + credit_limit 限制
				$add_limit_sql="UPDATE b_limit_apply set credit_limit=credit_limit+".$add_limit." where order_id=".$order_id;
				$this->db->query($add_limit_sql);
				$add_expert_limit_sql="UPDATE b_expert_limit_apply set apply_amount=apply_amount+".$add_limit.",real_amount=real_amount+".$add_limit." where order_id=".$order_id;
				$this->db->query($add_expert_limit_sql);
			}
		}

		//7、开始修改订单数据,佣金,外交佣金, 订单价格重新计算
		//增加的管家佣金(净差值)
		$add_agent_fee 		= $suit_price_data['agent_rate_int']*($dingnum+$old_num)+$suit_price_data['agent_rate_child']*$child_num+$suit_price_data['agent_rate_childno']*$childnobed_num;
		//增加的平台佣金(净差值)
		//订单的佣金规则
		$agent_rules = $this->order_manage->get_agent_rules($order_id);
		if(!empty($agent_rules)){
			if($agent_rules['kind']==1 || $agent_rules['kind']==4){//按照人头算佣金
				$total_agent = ($dingnum*$agent_rules['adultprice'])+($childnobed_num*$agent_rules['childnobedprice'])+($old_num*$agent_rules['oldprice'])+($child_num*$agent_rules['childprice']);
				if($agent_rules['type']==1){
					//外交佣金
					$total_foreign_agent = $total_agent;
				}else{
					//平台管理费
					$add_platform_fee = $total_agent;
				}
			}elseif($agent_rules['kind']==2){
				//按照比例算佣金,对应的账单只需要写一个
				$total_agent = $total_add_price*$agent_rules['ratio'];
				if($agent_rules['type']==1){
					//外交佣金
					$total_foreign_agent = $total_agent;
					$insert_wj_log = array(
						'num'=>1,
						'price'=>$total_foreign_agent,
						'amount'=>$total_foreign_agent,
						'remark' =>'添加参团人,增加外交佣金: '.$total_foreign_agent,
						'item' =>'添加参团人'
						);
					$this->order_manage->write_wj($order_id,$insert_wj_log);

				}else{
					//平台管理费
					$add_platform_fee = $total_agent;
					$insert_yj_log = array(
						'num'=>1,
						'price'=>$add_platform_fee,
						'amount'=>$add_platform_fee,
						'remark' =>'添加参团人,增加平台管理费',
						'item' =>'添加参团人',
						'm_time'=>date('Y-m-d H:i:s'),
						'a_time'=>date('Y-m-d H:i:s'),
						'status'=>2,
						'remark'=>'新增参团人,增加平台管理费: '.$add_platform_fee
						);
					$this->order_manage->write_yj($order_id,$insert_yj_log);
				}
			}elseif($agent_rules['kind']==3){
				//按照天数算佣金,对应的账单只需要写一个
				if($agent_rules['type']==1){
					$total_agent = ($dingnum+$old_num+$child_num+$childnobed_num)*$agent_rules['dayprice'];
					//外交佣金
					$total_foreign_agent = $total_agent;
					$insert_wj_log = array(
						'num'=>1,
						'price'=>$total_foreign_agent,
						'amount'=>$total_foreign_agent,
						'remark' =>'添加参团人,增加外交佣金: '.$total_foreign_agent,
						'item' =>'添加参团人'
						);
					$this->order_manage->write_wj($order_id,$insert_wj_log);
				}else{
					//按天数计算管理费，账单需要按人群写入
					$add_platform_fee = round($dingnum*$agent_rules['dayprice']+$child_num*$agent_rules['dayprice_child']+$childnobed_num*$agent_rules['dayprice_childnobed'],2);
					if ($dingnum >0)
					{
						//成人
						$amount = round($dingnum*$agent_rules['dayprice'] ,2);
						$insert_yj_log = array(
								'num'=>$dingnum,
								'price'=>$agent_rules['dayprice'],
								'amount'=>$amount,
								'item' =>'添加参团人',
								'm_time'=>date('Y-m-d H:i:s'),
								'a_time'=>date('Y-m-d H:i:s'),
								'status'=>2,
								'remark'=>'新增参团人(成人),增加平台管理费: '.$amount
						);
						$this->order_manage->write_yj($order_id,$insert_yj_log);
					}
					if ($child_num >0)
					{
						//小孩占床
						$amount = round($child_num*$agent_rules['dayprice_child'] ,2);
						$insert_yj_log = array(
								'num'=>$child_num,
								'price'=>$agent_rules['dayprice_child'],
								'amount'=>$amount,
								'item' =>'添加参团人',
								'm_time'=>date('Y-m-d H:i:s'),
								'a_time'=>date('Y-m-d H:i:s'),
								'status'=>2,
								'remark'=>'新增参团人(小孩占床),增加平台管理费: '.$amount
						);
						$this->order_manage->write_yj($order_id,$insert_yj_log);
					}
					if ($childnobed_num >0)
					{
						//小孩不占床
						$amount = round($childnobed_num*$agent_rules['dayprice_childnobed'] ,2);
						$insert_yj_log = array(
								'num'=>$childnobed_num,
								'price'=>$agent_rules['dayprice_childnobed'],
								'amount'=>$amount,
								'item' =>'添加参团人',
								'm_time'=>date('Y-m-d H:i:s'),
								'a_time'=>date('Y-m-d H:i:s'),
								'status'=>2,
								'remark'=>'新增参团人(小孩不占床),增加平台管理费: '.$amount
						);
						$this->order_manage->write_yj($order_id,$insert_yj_log);
					}
					
// 					$insert_yj_log = array(
// 						'num'=>1,
// 						'price'=>$add_platform_fee,
// 						'amount'=>$add_platform_fee,
// 						'remark' =>'添加参团人,增加平台管理费',
// 						'item' =>'添加参团人',
// 						'm_time'=>date('Y-m-d H:i:s'),
// 						'a_time'=>date('Y-m-d H:i:s'),
// 						'status'=>2,
// 						'remark'=>'新增参团人,增加平台管理费: '.$add_platform_fee
// 						);
// 					$this->order_manage->write_yj($order_id,$insert_yj_log);
				}
			}

		}


		//供应商成本(净差值)
		$diff_supplier_cost 	= $total_add_price - $add_agent_fee-$total_foreign_agent;
		//修改订单数据
		if($order_unit>=2){
			$add_dingnum=$dingnum*$order_unit;
		}else{
			$add_dingnum=$dingnum;
		}
		$update_order_sql = 'UPDATE u_member_order SET balance_status=(CASE balance_status WHEN 2 THEN 0 END), total_price=total_price+'.$total_add_price.', order_price=order_price+'.$total_add_price.',agent_fee=agent_fee+'.$add_agent_fee.',platform_fee=platform_fee+'.$add_platform_fee.',diplomatic_agent=diplomatic_agent+'.$total_foreign_agent.',dingnum=dingnum+'.$add_dingnum.',childnum=childnum+'.$child_num.',oldnum=oldnum+'.$old_num.',childnobednum=childnobednum+'.$childnobed_num.',supplier_cost=supplier_cost+'.$diff_supplier_cost.' WHERE id='.$order_id;
		$this->db->query($update_order_sql);
		//改好了对应的价格和人数之后, 最后计算最后的供应商成本价(暂时停止这一步)
		// 8、额度使用账单日志
		$order_data = $this->order_manage->get_one_order($order_id);
		$remark_str = $this->session->userdata('real_name').'操作添加参团人; 订单编号: '.$order_sn.'新增加了';
		if($dingnum>0){
			$remark_str .='成人:'.$dingnum.'个;';
		}
		if($old_num>0){
			$remark_str .='老人:'.$old_num.'个;';
		}
		if($child_num>0){
			$remark_str .='不占床儿童:'.$child_num.'个;';
		}
		if($childnobed_num>0){
			$remark_str .='占床儿童:'.$childnobed_num.'个;';
		}
		$remark_str .='总共金额:';

		$insert_limit_log = array(
			'cut_money'=>-$total_price,
			'sx_limit'=>-$add_limit,  //授信
			'type'=>'订单增加参团人',
			'remark'=>$remark_str.$total_price
			);
		$this->order_manage->write_limit_log($order_id,$insert_limit_log);
		// 9、写入应收账单
		$insert_ys_log = array(
			'num'	     =>$dingnum+$old_num+$child_num+$childnobed_num,
			'item'=>'新增套餐费用',
			'price'=>$total_price,
			'amount'=>$total_price,
			'm_time'=>date('Y-m-d H:i:s'),
			'status'=>1,
			'source'=>1,
			'remark'=>'新增套餐价格: '.$total_price
			);

		//如果选择了现金余额交款
		//if(isset($arrData['add_people_cash']) && $arrData['add_people_cash']==1){
			if($final_res['cash_limit']>0 && $total_price>0){
				if($total_price>$final_res['cash_limit']){
					//改动的价格大于账户现金余额, 直接用全部现金余额交款
					$diff_cash = $final_res['cash_limit'];
				}else{
					//改动价格小于等于账户现金余额, 用部分账户现金余额交款
					$diff_cash = $total_price;
				}
				$receive_data = array(
					'money'=>$diff_cash,
					'way'=>'账户余额',
					'remark'=>'新增加出团人价格直接使用账户余额交款',
					'status'=>0
				);
				$receive_id = $this->order_manage->write_receive($order_id,$receive_data);
			}
		//}
		$manage = $this->order_manage->get_manage();
		// 10、写入应付账单
		$insert_yf_log = array(
			'manager_id'=>$manage['id'],
			'user_type'=>1,
			'num'	     =>1,
			'oldnum'	=>$old_num,
			'childnum'	=>$child_num,
			'childnobednum'=>$childnobed_num,
			'item'=>'新增套餐费用',
			'price'=>$diff_supplier_cost,
			'amount'=>$diff_supplier_cost,
			'm_time'=>date('Y-m-d H:i:s'),
			's_time' =>date('Y-m-d H:i:s'),
			'kind'=>1,
			'status'=>2,
			'supplier_id'=>$order_data['supplier_id'],
			'remark'=>'新增套餐成本: '.$diff_supplier_cost
			);
		// 11、写入平台佣金、外交佣金账单
		$insert_yj_log = array(
			'user_type'=>1,
			'a_id'=>$manage['union_id'],
			'num'	     =>$dingnum+$old_num+$child_num+$childnobed_num,
			'item'=>'新增套餐费用',
			'price'=>$add_platform_fee,
			'amount'=>$add_platform_fee,
			'm_time'=>date('Y-m-d H:i:s'),
			'a_time'=>date('Y-m-d H:i:s'),
			'status'=>2,
			'remark'=>'新增套餐佣金: '.$add_platform_fee
			);
		$insert_wj_log = array(
			//'user_type'=>1,
			'num'	     =>$dingnum+$old_num+$child_num+$childnobed_num,
			'item'=>'新增套餐外交佣金费用',
			'price'=>$total_foreign_agent,
			'amount'=>$total_foreign_agent,
			'remark'=>'新增套餐佣金: '.$total_foreign_agent
			);

		if($order_unit>=2){
			//套餐类型就直接写入一种人群就可以
			$insert_ys_log['sk_id'] = $receive_id;
			$ys_id = $this->order_manage->write_ys($order_id,$insert_ys_log);
			$insert_yf_log['ys_id'] = $ys_id;
			$insert_yf_log['num'] = $dingnum;
			$this->order_manage->write_yf($order_id,$insert_yf_log);
			if(!empty($agent_rules)){
				if($agent_rules['kind']==1 || $agent_rules['kind']==4){
					if($agent_rules['type']==2){
						$this->order_manage->write_yj($order_id,$insert_yj_log);
					}else{
						$this->order_manage->write_wj($order_id,$insert_wj_log);
					}
				}
			}
		}else{
			//非套餐类型就要分添加的各个人群类型来写入应收账单
			//成人账单
			if($dingnum>0){
				$replace_ys_log = array(
						'num'	   =>$dingnum,
						'item'	   =>"新增成人费用",
						'price'	   =>$adult_price,
						'amount' =>$dingnum*$adult_price,
						'remark'  =>'新增成人费用 : '.$dingnum.'*'.$adult_price.'='.($dingnum*$adult_price)
					);
				$insert_ys_log = array_replace($insert_ys_log,$replace_ys_log);
				$insert_ys_log['sk_id'] = $receive_id;
				$ys_id = $this->order_manage->write_ys($order_id,$insert_ys_log);
				$replace_yf_log = array(
						'num'	      =>$dingnum,
						'oldnum'	=>0,
						'childnum'	=>0,
						'childnobednum'=>0,
						'ys_id' => $ys_id,
						'item'=>'新增成人成本',
						'price'=>$adult_price-$suit_price_data['agent_rate_int'],
						'amount'=>($adult_price-$suit_price_data['agent_rate_int'])*$dingnum,
						'remark'=>'新增成人成本: '.$dingnum.'*'.($adult_price-$suit_price_data['agent_rate_int']).'='.(($adult_price-$suit_price_data['agent_rate_int'])*$dingnum)
					);
				$insert_yf_log = array_replace($insert_yf_log,$replace_yf_log);
				$yf_id = $this->order_manage->write_yf($order_id,$insert_yf_log);

					if(!empty($agent_rules)){
						if($agent_rules['kind']==1 || $agent_rules['kind']==4){
							if($agent_rules['type']==2){//平台佣金
								$replace_yj_log = array(
									'num'	     =>$dingnum,
									'item'=>'新增成人佣金',
									'price'=>$agent_rules['adultprice'],
									'amount'=>$dingnum*$agent_rules['adultprice'],
									'remark'=>'新增成人平台佣金: '.($dingnum*$agent_rules['adultprice'])
								);
								$insert_yj_log = array_replace($insert_yj_log,$replace_yj_log);
								$this->order_manage->write_yj($order_id,$insert_yj_log);
							}else{//外交佣金
								$replace_wj_log = array(
									'num'	     =>$dingnum,
									'item'=>'新增成人佣金',
									'price'=>$agent_rules['adultprice'],
									'amount'=>$dingnum*$agent_rules['adultprice'],
									'remark'=>'新增成人外交佣金: '.$dingnum*$agent_rules['adultprice']
								);
								$insert_wj_log = array_replace($insert_wj_log,$replace_wj_log);
								$this->order_manage->write_wj($order_id,$insert_wj_log);
							}
						}
					}
			}
			//老人账单
			if($old_num>0){
				$replace_ys_log = array(
						'num'	   =>$old_num,
						'item'	   =>"新增老人费用",
						'price'	   =>$old_price,
						'amount' =>$old_num*$old_price,
						'remark'  =>'新增老人费用 : '.$old_num.'*'.$old_price.'='.($old_num*$old_price)
					);
				$insert_ys_log = array_replace($insert_ys_log,$replace_ys_log);
				$insert_ys_log['sk_id'] = $receive_id;
				$ys_id = $this->order_manage->write_ys($order_id,$insert_ys_log);
				$replace_yf_log = array(
						'num'	      =>$old_num,
						'oldnum'	=>0,
						'childnum'	=>0,
						'childnobednum'=>0,
						'ys_id' => $ys_id,
						'item'=>'新增老人成本',
						'price'=>$old_price-$suit_price_data['agent_rate_int'],
						'amount'=>($old_price-$suit_price_data['agent_rate_int'])*$old_num,
						'remark'=>'新增老人成本: '.$old_num.'*'.($old_price-$suit_price_data['agent_rate_int']).'='.(($old_price-$suit_price_data['agent_rate_int'])*$old_num)
					);
				$insert_yf_log = array_replace($insert_yf_log,$replace_yf_log);
				$yf_id = $this->order_manage->write_yf($order_id,$insert_yf_log);
				if(!empty($agent_rules)){
						if($agent_rules['kind']==1 || $agent_rules['kind']==4){
							if($agent_rules['type']==2){//平台佣金
								$replace_yj_log = array(
									'num'	     =>$old_num,
									'item'=>'新增老人佣金',
									'price'=>$agent_rules['oldprice'],
									'amount'=>$old_num*$agent_rules['oldprice'],
									'remark'=>'新增老人平台佣金: '.($old_num*$agent_rules['oldprice'])
								);
								$insert_yj_log = array_replace($insert_yj_log,$replace_yj_log);
								$this->order_manage->write_yj($order_id,$insert_yj_log);
							}else{//外交佣金
								$replace_wj_log = array(
									'num'	     =>$old_num,
									'item'=>'新增老人佣金',
									'price'=>$agent_rules['oldprice'],
									'amount'=>$old_num*$agent_rules['oldprice'],
									'remark'=>'新增老人外交佣金: '.$old_num*$agent_rules['oldprice']
								);
								$insert_wj_log = array_replace($insert_wj_log,$replace_wj_log);
								$this->order_manage->write_wj($order_id,$insert_wj_log);
							}
						}
					}
			}
			//占床儿童账单
			if($child_num>0){
				$replace_ys_log = array(
						'num'	   =>$child_num,
						'item'	   =>"新增占床儿童费用",
						'price'	   =>$child_price,
						'amount' =>$child_num*$child_price,
						'remark'  =>'新增占床儿童费用 : '.$child_num.'*'.$child_price.'='.($child_num*$child_price)
					);
				$insert_ys_log = array_replace($insert_ys_log,$replace_ys_log);
				$insert_ys_log['sk_id'] = $receive_id;
				$ys_id = $this->order_manage->write_ys($order_id,$insert_ys_log);
				$replace_yf_log = array(
						'num'	      =>$child_num,
						'oldnum'	=>0,
						'childnum'	=>0,
						'childnobednum'=>0,
						'ys_id' => $ys_id,
						'item'=>'新增占床儿童成本',
						'price'=>$child_price-$suit_price_data['agent_rate_child'],
						'amount'=>($child_price-$suit_price_data['agent_rate_child'])*$child_num,
						'remark'=>'新增占床儿童成本: '.$child_num.'*'.($child_price-$suit_price_data['agent_rate_child']).'='.(($child_price-$suit_price_data['agent_rate_child'])*$child_num)
					);
				$insert_yf_log = array_replace($insert_yf_log,$replace_yf_log);
				$yf_id = $this->order_manage->write_yf($order_id,$insert_yf_log);
				if(!empty($agent_rules)){
						if($agent_rules['kind']==1 || $agent_rules['kind']==4){
							if($agent_rules['type']==2){//平台佣金
								$replace_yj_log = array(
									'num'	     =>$child_num,
									'item'=>'新增占床儿童佣金',
									'price'=>$agent_rules['childprice'],
									'amount'=>$child_num*$agent_rules['childprice'],
									'remark'=>'新增占床儿童佣金: '.$child_num*$agent_rules['childprice']
								);
								$insert_yj_log = array_replace($insert_yj_log,$replace_yj_log);
								$this->order_manage->write_yj($order_id,$insert_yj_log);
							}else{//外交佣金
								$replace_wj_log = array(
									'num'	     =>$child_num,
									'item'=>'新增占床儿童佣金',
									'price'=>$agent_rules['childprice'],
									'amount'=>$child_num*$agent_rules['childprice'],
									'remark'=>'新增占床儿童佣金: '.$child_num*$agent_rules['childprice']
								);
								$insert_wj_log = array_replace($insert_wj_log,$replace_wj_log);
								$this->order_manage->write_wj($order_id,$insert_wj_log);
							}
						}
					}
			}
			//不占床儿童账单
			if($childnobed_num>0){
				$replace_ys_log = array(
						'num'	   =>$childnobed_num,
						'item'	   =>"新增不占床儿童费用",
						'price'	   =>$child_nobed_price,
						'amount' =>$childnobed_num*$child_nobed_price,
						'remark'  =>'新增不占床儿童费用 : '.$childnobed_num.'*'.$child_nobed_price.'='.($childnobed_num*$child_nobed_price)
					);
				$insert_ys_log = array_replace($insert_ys_log,$replace_ys_log);
				$insert_ys_log['sk_id'] = $receive_id;
				$ys_id = $this->order_manage->write_ys($order_id,$insert_ys_log);
				$replace_yf_log = array(
						'num'	      =>$childnobed_num,
						'oldnum'	=>0,
						'childnum'	=>0,
						'childnobednum'=>0,
						'ys_id' => $ys_id,
						'item'=>'新增不占床儿童成本',
						'price'=>$child_nobed_price-$suit_price_data['agent_rate_childno'],
						'amount'=>($child_nobed_price-$suit_price_data['agent_rate_childno'])*$childnobed_num,
						'remark'=>'新增不占床儿童成本: '.$childnobed_num.'*'.($child_nobed_price-$suit_price_data['agent_rate_childno']).'='.(($child_nobed_price-$suit_price_data['agent_rate_childno'])*$childnobed_num)
					);
				$insert_yf_log = array_replace($insert_yf_log,$replace_yf_log);
				$yf_id = $this->order_manage->write_yf($order_id,$insert_yf_log);

				if(!empty($agent_rules)){
						if($agent_rules['kind']==1 || $agent_rules['kind']==4){
							if($agent_rules['type']==2){//平台佣金
								$replace_yj_log = array(
									'num'	     =>$childnobed_num,
									'item'=>'新增不占床儿童佣金',
									'price'=>$agent_rules['childnobedprice'],
									'amount'=>$childnobed_num*$agent_rules['childnobedprice'],
									'remark'=>'新增不占床儿童佣金: '.$childnobed_num*$agent_rules['childnobedprice']
								);
								$insert_yj_log = array_replace($insert_yj_log,$replace_yj_log);
								$this->order_manage->write_yj($order_id,$insert_yj_log);
							}else{//外交佣金
								$replace_wj_log = array(
									'num'	     =>$childnobed_num,
									'item'=>'新增不占床儿童佣金',
									'price'=>$agent_rules['childnobedprice'],
									'amount'=>$childnobed_num*$agent_rules['childnobedprice'],
									'remark'=>'新增不占床儿童佣金: '.$childnobed_num*$agent_rules['childnobedprice']
								);
								$insert_wj_log = array_replace($insert_wj_log,$replace_wj_log);
								$this->order_manage->write_wj($order_id,$insert_wj_log);
							}
						}
					}
			}
		}
		// 12、新增参团人, 外交佣金, 平台佣金 改成未核算
		//$this->db->update('u_member_order',array('yj_lock'=>0,'wj_lock'=>0),array('id'=>$order_id));

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			$this ->sendMsgOrderWX(array('orderid' =>$order_id,'num'=>($child_num+$childnobed_num+$dingnum+$old_num),'price'=>$total_price,'type'=>5));

			//发送消息
			$msg = new T33_send_msg();
			$msgArr = $msg ->addPeopleMsg($order_id,$total_add_price,$total_price,$dingnum,$child_num,$childnobed_num,$this->session->userdata('real_name'));
			echo json_encode(array('status'=>200,'msg'=>'已提交'));
			exit();
		}
	}

	

    /*
     * 重新提交订单
     * 
     * */
	function resubmit_order()
	{
		//1、传递参数
		$orderId        = $this->input->post('order_id');
		$line_id		= $this->input->post('line_id');
		$depart_id      = $this->input->post('depart_id');
		
		//2、开启事物
		$this->db->trans_begin();
		$this->load_model('order_model');
		$this ->load_model('line_model' ,'line_model');
		$ys_data = $this->order_manage->get_ys_data(array('ys.order_id'=>$orderId,'ys.status'=>0));
		if(!empty($ys_data)){
			echo json_encode(array('status'=>202,'msg'=>'您有未审核应收账单,需经理审核后再提交订单'));
			exit();
		}
		$orderArr = $this->order_manage->get_one_order($orderId);
		$sum_receive = $this->order_manage->get_sum_receive(array('order_id='=>$orderId,'status!='=>'3,4,6'));
		$order_debit = $this->order_manage->get_order_debit($orderId);
		$depart_limit = $this->order_manage->get_depart_limit($orderArr['depart_id']);
		$manage = $this->order_manage->get_manage();
		$lineData = $this ->line_model ->getLineOrder(array('l.id' =>$line_id));
		$suit_day = $this ->line_model ->getLineSuitDay($orderArr['suitid'],$orderArr['usedate']);
		if(empty($suit_day)) {
			echo json_encode(array('status'=>202,'msg'=>'该线路套餐已删除，无法重新提交订单'));
			exit();
		}
		$suitData = $this ->line_model ->getLineSuit($suit_day['dayid'] ,$line_id);
		$lineData = $lineData[0];
		$agentArr = array();
		if ($lineData['line_kind']==2) {
			//旅行社单项线路
			$suitData['unit'] = 1;
			$singleAgent = $this ->order_model ->getSingleAgent($lineData['id']);
			$agentArr = $singleAgent;
		} else {
			if($lineData['line_kind']==1){
				//供应商添加的正常线路
				if($lineData['producttype']==0){
					//普通线路
					$type=1;
				}else{
					//包团线路
					$type=2;
				}
			}else{
				//供应商单项线路
				$type=1;
			}
			$agentArr = $this ->order_model ->getUnionLineAgent($orderArr['platform_id'] ,$orderArr['supplier_id'],$type);
			if (!empty($agentArr) && $agentArr['type'] == 3){
				$agentArr = $this ->order_model ->getUnionLineDay($orderArr['supplier_id'] ,$lineData['lineday'] ,$orderArr['platform_id'],$type);
			}
		}

		//营业部现金额度+营业部信用额度够够,修改订单状态4
		//不够就申请额度,,修改订单状态2,3(向供应商或者旅行社申请额度)
		//以上步骤需扣除额度, 扣除顺序 营业部现金>营业部信用>申请的临时额度
		
		$account_money=0;//账户余额：营业部现金+营业部信用  [当营业部现金位负数时，不使用,当营业部信用为负数时，不使用]
		if($depart_limit['cash_limit']>=0)
			$account_money+=$depart_limit['cash_limit'];
		if($depart_limit['credit_limit']>=0)
			$account_money+=$depart_limit['credit_limit'];
		//*****非押金线路****
			if(empty($orderArr['order_deposit']) || $orderArr['order_deposit']==0){
				$order_diff_price = $orderArr['total_price']-$sum_receive['total_receive_amount'];//订单未收款金额
				if($order_diff_price>$account_money){
					//营业部信用额度不够扣除,所以需要申请管家信用
					$result = array(
						'diff_amount'=>$order_diff_price-($account_money),
						'expert_id'	=> $orderArr['expert_id'],
						'order_id'	=> $orderId,
						'depart_id' => $depart_id,
						'depart_name' => $depart_limit['name'],
						'manager_id'	=> $manage['id'],
						'manager_name' => $manage['realname'],
						'expert_name'     => $orderArr['realname']
						);
					echo json_encode(array('status'=>201,'msg'=>$result));
					exit();
				}else{//不用申请管家信用
					if($order_diff_price>$depart_limit['cash_limit']){//既使用营业部现金，又使用营业部信用
						if(empty($order_debit)){
							$this ->order_manage->write_debit($orderId ,1 ,($depart_limit['cash_limit']+$sum_receive['total_receive_amount']));
							$this ->order_manage->write_debit($orderId ,2 ,($order_diff_price-$depart_limit['cash_limit']));
							$this ->order_manage->write_debit($orderId ,3 ,0);
						}else{
							$this ->order_manage->update_debit($orderId ,1 ,($depart_limit['cash_limit']+$sum_receive['total_receive_amount']));
							$this ->order_manage->update_debit($orderId ,2 ,($order_diff_price-$depart_limit['cash_limit']));
							$this ->order_manage->update_debit($orderId ,3 ,0);
						}
						
						//额度日志、交款账单
						$this->order_deal->use_limit($orderId,$order_diff_price,'提交临时保存订单');
						$insert_receive_log = array(
								'money'=>$depart_limit['cash_limit'],
								'way'=>'账户余额',
								'remark'=>'重新提交订单交款',
								'status'=>0,
								'from'=>2
						);
						$receive_id=0;
						if($depart_limit['cash_limit']>0)
						$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);
						
					}else{//全部使用营业部现金
						if(empty($order_debit)){
							//现金余额足够需要扣除的额度;
							$this ->order_manage->write_debit($orderId ,1 ,($order_diff_price+$sum_receive['total_receive_amount']));
							$this ->order_manage->write_debit($orderId ,2 ,0);
							$this ->order_manage->write_debit($orderId ,3 ,0);
						}else{
							//现金余额足够需要扣除的额度;
							$this ->order_manage->update_debit($orderId ,1 ,($order_diff_price+$sum_receive['total_receive_amount']));
							$this ->order_manage->update_debit($orderId ,2 ,0);
							$this ->order_manage->update_debit($orderId ,3 ,0);
						}
						//额度日志、交款账单
						//$this->order_deal->use_limit($orderId,$depart_limit['cash_limit'],'提交临时保存订单');
						//jkr，参数错误，修改
						$this->order_deal->use_limit($orderId,$order_diff_price,'提交临时保存订单');
						$insert_receive_log = array(
								'money'=>$order_diff_price,
								'way'=>'账户余额',
								'remark'=>'重新提交订单交款',
								'status'=>0,
								'from'=>2
						);
						$receive_id=0;
						if($order_diff_price>0)
						$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);
					}
					$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('order_id'=>$orderId));
					
					
					$order_sql = 'UPDATE u_member_order SET status=4 WHERE id='.$orderId;
					$this->db->query($order_sql);
					$orderArr['addtime'] = date('Y-m-d H:i:s');
					
					
					if($orderArr['status']==9 || $orderArr['status']==-1 || $orderArr['status']==-2 || $orderArr['status']==-6){
						$receive_res = $this->order_manage->get_sum_receive(array('order_id='=>$orderId,'status='=>2));
						if($receive_res['total_receive_amount']>=$orderArr['total_price']){
							//交完全款就返还利润到营业部现金账户
							$this->order_manage->return_profit($orderId);
						}
					}
					/*$this->db->query('UPDATE u_line_suit_price SET number=number+'.($orderArr['dingnum']+$orderArr['childnum']+$orderArr['oldnum']+$orderArr['childnobednum']).' WHERE day=\''.$orderArr['usedate'].'\' AND suitid='.$orderArr['suitid']);*/
					$suit_sql = 'UPDATE u_line_suit_price SET order_num=order_num+1,number=number-'.($orderArr['dingnum']+$orderArr['childnum']+$orderArr['oldnum']+$orderArr['childnobednum']).' WHERE suitid='.$orderArr['suitid'].' AND day=\''.$orderArr['usedate'].'\'';
					$this ->db ->query($suit_sql);
					
					//订单操作日志
					$this->order_manage->write_order_log($orderId,'在我的订单页面，重新提交订单：非押金订单，账户余额大于扣款金额，不申请信用');
				}
		}else{
			//押金订单
			if($orderArr['order_deposit']>($account_money+$sum_receive['total_receive_amount'])){
				echo json_encode(array('status'=>204,'msg'=>'账户余额不够扣除订金'));
				exit();
			}else{
					$cut_credit = $orderArr['total_price']-$orderArr['order_deposit'];//还需申请的管家信用（自动通过）
					$order_diff_price = $orderArr['order_deposit']-$sum_receive['total_receive_amount'];//订单未收款金额= 押金 - 总已交款
					if($order_diff_price<=0){//不扣现金，也不扣信用
						if(empty($order_debit)){
							$this ->order_manage->write_debit($orderId ,1 ,$sum_receive['total_receive_amount']);
							$this ->order_manage->write_debit($orderId ,2,0);
							$this ->order_manage->write_debit($orderId ,3 ,$cut_credit);
						}else {
							$this ->order_manage->update_debit($orderId ,1 ,$sum_receive['total_receive_amount']);
							$this ->order_manage->update_debit($orderId ,2,0);
							$this ->order_manage->update_debit($orderId ,3 ,$cut_credit);
						}
						$cut_credit = $orderArr['total_price']-$sum_receive['total_receive_amount'];//还需申请的管家信用（自动通过）
					  
					}
					elseif($order_diff_price>$depart_limit['cash_limit']){//既使用营业部现金，又使用营业部信用
						//写入订单扣款表,现金+信用
						if(empty($order_debit)){
							$this ->order_manage->write_debit($orderId ,1 ,$depart_limit['cash_limit']+$sum_receive['total_receive_amount']);
							$this ->order_manage->write_debit($orderId ,2,$order_diff_price-$depart_limit['cash_limit']);
							$this ->order_manage->write_debit($orderId ,3 ,$cut_credit);
						}else {
							$this ->order_manage->update_debit($orderId ,1 ,$depart_limit['cash_limit']+$sum_receive['total_receive_amount']);
							$this ->order_manage->update_debit($orderId ,2,$order_diff_price-$depart_limit['cash_limit']);
							$this ->order_manage->update_debit($orderId ,3 ,$cut_credit);
						}
						//额度日志、交款账单
						$insert_receive_log = array(
								'money'=>$depart_limit['cash_limit'],
								'way'=>'账户余额',
								'remark'=>'重新提交订单交款(扣除订金)',
								'status'=>0,
								'from'=>2
						);
						$receive_id=0;
						if(($depart_limit['cash_limit']+$sum_receive['total_receive_amount'])>0)
						$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);
						$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('order_id'=>$orderId));
						$this->order_deal->use_limit($orderId,$order_diff_price,'提交临时保存定金订单','(从账户补扣)');
						
					}else{
						//写入订单扣款表,全现金扣款
						if(empty($order_debit)){
							$this ->order_manage->write_debit($orderId ,1 ,$orderArr['order_deposit']);
							$this ->order_manage->write_debit($orderId ,2,0);
							$this ->order_manage->write_debit($orderId ,3 ,$cut_credit);
						}else{
							$this ->order_manage->update_debit($orderId ,1 ,$orderArr['order_deposit']);
							$this ->order_manage->update_debit($orderId ,2,0);
							$this ->order_manage->update_debit($orderId ,3 ,$cut_credit);
						}
						//额度日志、交款账单
						$insert_receive_log = array(
								'money'=>$order_diff_price,
								'way'=>'账户余额',
								'remark'=>'重新提交订单交款(扣除订金)',
								'status'=>0,
								'from'=>2
						);
						$receive_id=0;
						if($order_diff_price>0)
						$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);
						$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('order_id'=>$orderId));
						$this->order_deal->use_limit($orderId,$order_diff_price,'提交临时保存定金订单','(从账户补扣)');
				}
					
				$order_sql = 'UPDATE u_member_order SET status=4 WHERE id='.$orderId;
				$this->db->query($order_sql);
				$suit_sql = 'UPDATE u_line_suit_price SET order_num=order_num+1,number=number-'.($orderArr['dingnum']+$orderArr['childnum']+$orderArr['oldnum']+$orderArr['childnobednum']).' WHERE suitid='.$orderArr['suitid'].' AND day=\''.$orderArr['usedate'].'\'';
				$this ->db ->query($suit_sql);
				$orderArr['addtime'] = date('Y-m-d H:i:s');
					
				//申请管家信用
				if($orderArr['total_price']>$orderArr['order_deposit']){
						$apply_code = $this->create_apply_code();
						$limit_arr = $this->order_manage->write_limit_apply($orderArr,$cut_credit,$apply_code);
						$this->order_manage->write_expert_apply($orderArr,$limit_arr);
						$write_limit_log = array(
								'sx_limit'=>$cut_credit,
								'type'=>'提交临时保存定金订单(申请管家信用自动通过)',
								'remark'=>'b2:提交临时保存定金订单(申请管家信用自动通过)'
						);
						$this->order_manage->write_limit_log($orderId,$write_limit_log);
						$write_limit_log2 = array(
								'sx_limit'=>-$cut_credit,
								'type'=>'提交临时保存定金订单(使用管家信用)',
								'remark'=>'b2:提交临时保存定金订单(使用管家信用)'
						);
						$this->order_manage->write_limit_log($orderId,$write_limit_log2);
				}
				
				//订单操作日志
				$this->order_manage->write_order_log($orderId,'在我的订单页面，重新提交订单：押金订单，账户余额大于定金，还需申请信用额度并自动通过');
			}
		}
		//exit();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'已提交'));

			//发送新订单消息
			$msg = new T33_send_msg();
			$msg ->addOrderMsg($orderId,$this->session->userdata('real_name'));
			exit();
		}
	}
	/*
	 * 重新提交订单:1、额度不足，弹出需申请管家信用窗口
	 *           2、特殊情况，弹出申请管家信用窗口的瞬间，营业部的现金、信用发生了变化，此时重新计算扣款
	 * 
	 */
	function submit_apply_order()
	{
		$arrData = $this->security->xss_clean($_POST);
		$this->load_model('order_model');
		$this ->load_model('line_model' ,'line_model');
		$is_manage = $this->session->userdata('is_manage');
		$orderId = $arrData['apply_order_id'];
		$depart_id = $arrData['depart_id'];
		$managerId = $arrData['manager_id'];
		$orderArr = $this->order_manage->get_one_order($orderId);
		$departData = $this->order_manage->get_depart_limit($orderArr['depart_id']);
		$order_debit = $this->order_manage->get_order_debit($orderId);
		$whereArr['order_id='] = $orderId;
		$whereArr['status='] = '5'; //查找是否有未被拒绝的
		$apply_limit = $this->order_manage->get_apply_limit($whereArr);
	
		//判断有没有申请额度的记录
		$whereArr2['order_id='] = $orderId;
		$apply_limit2 = $this->order_manage->get_apply_limit($whereArr2);
	
		$manage = $this->order_manage->get_manage();
		$whereArr2['order_id='] = $orderId;
		$whereArr2['status!='] = '3,4,6';
		$whereArr2['way='] = '账户余额';
		$sum_receive = $this->order_manage->get_sum_receive($whereArr2);
		$lineData = $this ->line_model ->getLineOrder(array('l.id' =>$orderArr['productautoid']));
		$suit_day = $this ->line_model ->getLineSuitDay($orderArr['suitid'],$orderArr['usedate']);
		$suitData = $this ->line_model ->getLineSuit($suit_day['dayid'] ,$orderArr['productautoid']);
		$lineData = $lineData[0];
		if ($lineData['line_kind']==2) {
			$suitData['unit'] = 1;
			$singleAgent = $this ->order_model ->getSingleAgent($lineData['id']);
			$agentArr = $singleAgent;
		} else {
			if($lineData['line_kind']==1){
				if($lineData['producttype']==0){
					$type=1;
				}else{
					$type=2;
				}
			}else{
				$type=1;
			}
			$agentArr = $this ->order_model ->getUnionLineAgent($orderArr['platform_id'] ,$orderArr['supplier_id'],$type);
			if (!empty($agentArr) && $agentArr['type'] == 3){
				$agentArr = $this ->order_model ->getUnionLineDay($orderArr['supplier_id'] ,$lineData['lineday'] ,$orderArr['platform_id'],$type);
			}
		}
		if(strtotime($arrData['apply_date']) > strtotime($arrData['return_date'])){
			echo json_encode(array('status'=>201,'msg'=>'还款日期必须大于申请日期'));
			exit();
		}
		
		$this->db->trans_begin();//开启事物
		//写入订单日志
		//$this ->order_model->insertOrderLog($orderId, 1, $orderArr['expert_id'], date('Y-m-d H:i:s'));
		//扣除额度
		$money = $orderArr['total_price']-$sum_receive['total_receive_amount'];
		
		$account_money=0;//账户余额：营业部现金+营业部信用  [当营业部现金位负数时，不使用,当营业部信用为负数时，不使用]
		if($departData['cash_limit']>=0)
			$account_money+=$departData['cash_limit'];
		if($departData['credit_limit']>=0)
			$account_money+=$departData['credit_limit'];
		
		$balance 	= $money - $account_money;
	
		if ($balance < 0.0001){ //不用申请管家信用
			
			if ($money > $departData['cash_limit']){//既使用营业部现金，又使用营业部信用
				if(empty($order_debit)){
					$this ->order_manage->write_debit($orderId ,1 ,($departData['cash_limit']+$sum_receive['total_receive_amount']));
					$this ->order_manage->write_debit($orderId ,2 ,($money-$departData['cash_limit']));
				}else{
					$this ->order_manage->update_debit($orderId ,1 ,($departData['cash_limit']+$sum_receive['total_receive_amount']));
					$this ->order_manage->update_debit($orderId ,2 ,($money-$departData['cash_limit']));
				}
				$this ->order_manage->write_debit($orderId ,3 ,0);
				//额度日志、交款账单
				$this->order_deal->use_limit($orderId,$money,'提交临时保存订单');
				$insert_receive_log = array(
						'money'=>$departData['cash_limit'],
						'way'=>'账户余额',
						'remark'=>'重新提交订单交款',
						'status'=>0,
						'from'=>2
				);
				$receive_id=0;
				if($departData['cash_limit']>0)
					$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);

			}else{//现金余额足够
				if(empty($order_debit)){
							$this ->order_manage->write_debit($orderId ,1 ,($money+$sum_receive['total_receive_amount']));
							$this ->order_manage->write_debit($orderId ,2 ,0);
							$this ->order_manage->write_debit($orderId ,3 ,0);
						}else{
							$this ->order_manage->update_debit($orderId ,1 ,($money+$sum_receive['total_receive_amount']));
							$this ->order_manage->update_debit($orderId ,2 ,0);
							$this ->order_manage->update_debit($orderId ,3 ,0);
						}
						
				//额度日志、交款账单
				$this->order_deal->use_limit($orderId,$money,'提交临时保存订单');
				$insert_receive_log = array(
						'money'=>$money,
						'way'=>'账户余额',
						'remark'=>'重新提交订单交款',
						'status'=>0,
						'from'=>2
				);
				$receive_id=0;
				if($money>0)
				$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);
			}
			$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('order_id'=>$orderId));
			$order_sql = 'UPDATE u_member_order SET status=4 WHERE id='.$orderId;
			$this->db->query($order_sql);
			
			$suit_sql = 'UPDATE u_line_suit_price SET order_num=order_num+1,number=number-'.($orderArr['dingnum']+$orderArr['childnum']+$orderArr['oldnum']+$orderArr['childnobednum']).' WHERE suitid='.$orderArr['suitid'].' AND day=\''.$orderArr['usedate'].'\'';
			$this ->db ->query($suit_sql);
			
			if($orderArr['status']==9 || $orderArr['status']==-1 || $orderArr['status']==-2 || $orderArr['status']==-6){
				$receive_res = $this->order_manage->get_sum_receive(array('order_id='=>$orderId,'status='=>2));
				if($receive_res['total_receive_amount']>=$orderArr['total_price']){
					//交完全款就返还利润到营业部现金账户
					$this->order_manage->return_profit($orderId);
				}
			}
			
		}else{
			
			//先扣营业部现金和营业部信用
			$cash_pay=$departData['cash_limit']>0?$departData['cash_limit']:0;
			$credit_pay=$departData['credit_limit']>0?$departData['credit_limit']:0;
			$this->order_deal->use_limit($orderId,$account_money,'提交临时保存订单');
			//交款账单
			if ($departData['cash_limit'] > 0){
				$insert_receive_log = array(
						'money'=>$departData['cash_limit'],
						'way'=>'账户余额',
						'remark'=>'重新提交订单交款',
						'status'=>0,
						'from'=>2
				);
				$receive_id = $this->order_manage->write_receive($orderId,$insert_receive_log);
				$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('order_id'=>$orderId));
			}
	
			//管家额度不足，管家申请信用额度
			$limitApplyArr = array(
					'order_id' => $orderId,
					'depart_id' => $depart_id,
					'depart_name'	 => $arrData['depart_name'],
					'expert_id'	 => $arrData['expert_id'],
					'expert_name'	 => $arrData['expert_name'],
					'manager_id' => $arrData['manager_id'],
					'manager_name' => $arrData['manager_name'],
					'addtime'	    => date('Y-m-d H:i:s',strtotime("+1 second")),
					'return_time'  => $arrData['return_date'],
					'code'		    => $arrData['pay_code']
			);
			if($is_manage==1){
				$limitApplyArr['status'] = 1;
			}else{
				$limitApplyArr['status'] = 0;
			}
			$limitApplyArr['credit_limit'] = $arrData['apply_amount'] < $balance ? round($balance ,2) : $arrData['apply_amount'];
			if($arrData['apply_type']==1){
				//旅行社
				$limitApplyArr['union_id'] = $orderArr['platform_id'];
			}else{
				$limitApplyArr['supplier_id'] = $orderArr['supplier_id'];
			}
	
			if(!empty($apply_limit) || empty($apply_limit2)){
				//写入管家申请额度表
				$this ->db ->insert('b_limit_apply' ,$limitApplyArr);
				$apply_id = $this->db->insert_id();
				$this ->sendMsgQuotaWX(array('applyId' =>$apply_id));
			}else{
				$this->db->update('b_limit_apply',$limitApplyArr,array('order_id'=>$orderId));
				$this ->sendMsgQuotaWX(array('applyId' =>$apply_limit2[0]['id']));
				$apply_id = $apply_limit2[0]['id'];
			}
			//使用的单团额度
			$sx_limit = $limitApplyArr['credit_limit'];
			if(empty($order_debit)){
				//写入订单扣款表
				$this ->order_manage->write_debit($orderId ,1 ,($cash_pay+$sum_receive['total_receive_amount']));
				$this ->order_manage->write_debit($orderId ,2 ,$credit_pay);
				//有使用管家单团信用额度
				$this ->order_manage->write_debit($orderId ,3 ,$sx_limit);
			}else{
				$this ->order_manage->update_debit($orderId ,1 ,($cash_pay+$sum_receive['total_receive_amount']));
				$this ->order_manage->update_debit($orderId ,2 ,$credit_pay);
				$this ->order_manage->update_debit($orderId ,3 ,$sx_limit);
			}
			if($is_manage==1){//经理提交的申请额度直接通过
				if($arrData['apply_type']==2){
					$order_sql = 'UPDATE u_member_order SET status=3 WHERE id='.$orderId;
				}else{
					$order_sql = 'UPDATE u_member_order SET status=2 WHERE id='.$orderId;
				}
			}else{
				if($arrData['apply_type']==2){
					$order_sql = 'UPDATE u_member_order SET status=11 WHERE id='.$orderId;
				}else{
					$order_sql = 'UPDATE u_member_order SET status=10 WHERE id='.$orderId;
				}
			}
			$this->db->query($order_sql);
			
			//订单操作日志
			$this->order_manage->write_order_log($arrData['apply_order_id'],'在我的订单页面，重新提交订单：非押金订单，账户余额不足扣款金额，还需申请信用额度');
		}
	
	    
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'已提交'));
	
			//发送额度消息
			if (isset($apply_id) && $apply_id >0)
			{
				$msg = new T33_send_msg();
				$msg ->applyQuotaMsg($apply_id,1,$this->session->userdata('real_name'));
			}
			exit();
		}
	}
	/*
	 * 取消订单
	 * */
	function cancle_order()
	{
		//1、参数传递
		$orderId        = $this->input->post('order_id'); //订单id
		$line_id		= $this->input->post('line_id');  //线路id 
		$depart_id      = $this->input->post('depart_id');//部门id
		
		//2、开启事物
		$this->db->trans_begin();
		$this->load_model('order_model');
		$this->load_model('admin/b2/credit_approval_model', 'credit_approval');
		$orderArr = $this->order_manage->get_one_order($orderId); //订单详情
		$whereArr=array('order_id='=>$orderId,'status!='=>'3,4,6','way='=>'账户余额');
		$sum_receive = $this->order_manage->get_sum_receive($whereArr); //已交款
		
		//3、取消操作[只有暂存的订单才可以取消]
		if($orderArr['status']!=9){
			echo json_encode(array('status'=>204,'msg'=>'只限取消临时保存的订单'));
			exit();
		}
		else
		{
			  //改订单状态
			$update_order_sql='UPDATE u_member_order SET status=-4,dingnum=0,oldnum=0,childnum=0,childnobednum=0 WHERE id='.$orderId;
			$this->db->query($update_order_sql);
			  //改额度申请状态
			$update_limit_sql='UPDATE b_limit_apply SET status=-1 WHERE id='.$orderId;
			$this->db->query($update_limit_sql);
			  //返还营业部现金额度
			$this->order_manage->return_cash($sum_receive['total_receive_amount'],$orderArr['depart_id']);
			  //拒绝所有的未提交交款
			$this->db->query('UPDATE u_order_receivable SET status=4 WHERE order_id='.$orderId.' AND status=0');
				/* //废弃
				$debit_res = $this->order_manage->get_one_debit($orderId,1);
				$debit_res2 = $this->order_manage->get_one_debit($orderId,2);
		 		if(!empty($debit_res)){//还掉营业部现金额度
		 			$this->order_manage->return_cash($debit_res['real_amount'],$orderArr['depart_id']);
		 		}
		 		if(!empty($debit_res2)){//还掉营业部信用额度
		 			$this->order_manage->return_credit($debit_res2['real_amount'],$orderArr['depart_id']);
		 		}
		 		$this->db->query('UPDATE u_line_suit_price SET number=number+'.($orderArr['dingnum']+$orderArr['childnum']+$orderArr['oldnum']+$orderArr['childnobednum']).' WHERE day=\''.$orderArr['usedate'].'\' AND suitid='.$orderArr['suitid']);
		 		*/
			$write_limit_log = array(
						'refund_monry'=>$sum_receive['total_receive_amount'],
						'type'=>'取消订单,退还扣除的账户额度',
						'remark'=>'取消订单,退还扣除的账户额度'
						);
			if($sum_receive['total_receive_amount']>0){
				$this->order_manage->write_limit_log($orderId,$write_limit_log);
			}
			//订单操作日志
			$this->order_manage->write_order_log($orderId,'在我的订单页面，取消订单');

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'取消失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'取消成功'));
			exit();
		}
	}
}


	/*
	 * 改价的时候重新计算信用额度和订单数据
	 * 说明：1、经理发起的改价, 直接修改订单和和额度信息,无须经理再次通过
	 *      2、待提交的订单改价, 不涉及额度的变化, 最后提交的时候一起重新在计算
	 *      
	 *      //$this->load_model('admin/b2/change_approval_model', 'change_approval');
	 * */
	protected function cal_result($order_id, $pass_depart_id,$ys_amount,$ope_type,$ys_id=0)
	{
			$order_info = $this->order_manage->get_one_order($order_id);
			if($order_info['status']==9 || $order_info['status']==-1 || $order_info['status']==-2 || $order_info['status']==-6 )
			{ //未提交的订单,可以修改订单信息(参团人数, 订单金额等, 并且和额度无关)
					//重新计算订单的各个价格
					$after_order_info['total_price'] = $order_info['total_price']+$ys_amount;
					$after_order_info['supplier_cost'] = $order_info['supplier_cost'];
					$after_order_info['agent_fee'] = $after_order_info['total_price']-$after_order_info['supplier_cost']-$order_info['diplomatic_agent'];
					$this->db->update('u_member_order',$after_order_info,array('id'=>$order_id));
					//流水账记录
					$insert_limit_log = array(
						'refund_monry'=>$ys_amount,
						'type'=>'未提交订单改价',
						'remark'=>'b2:经理通过未提交订单改价'
					);
				//$this->order_manage->write_limit_log($order_id,$insert_limit_log);
			}
			else
			{ //已提交的订单
				$final_res 	= $this->order_manage->get_depart_limit($pass_depart_id);//下订单的销售所属的营业部
				   //real_amount;获取之前的扣款表数据
				$cash_debit = $this->order_manage->get_one_debit($order_id,1);
				$credit_debit = $this->order_manage->get_one_debit($order_id,2);

				$after_order_info['total_price'] = $order_info['total_price']+$ys_amount;
				$after_order_info['supplier_cost'] = $order_info['supplier_cost'];
				$after_order_info['agent_fee'] = $after_order_info['total_price']-$after_order_info['supplier_cost']-$order_info['diplomatic_agent'];
				$this->db->update('u_member_order',$after_order_info,array('id'=>$order_id));
				if($ys_amount>=0)
				{ //改高应收扣除额度
					$this->order_manage->del_limit($order_id,$pass_depart_id,$ys_amount);
					//应收价变动,相对应的更新扣款表
					if($ys_amount>$final_res['cash_limit'])
					{
						$after_cash_real_amount = $cash_debit['real_amount']+$final_res['cash_limit'];
						$after_credit_real_amount = ($ys_amount-$final_res['cash_limit'])+$credit_debit['real_amount'];
					   	$this ->order_manage->update_debit($order_id ,1 ,$after_cash_real_amount);
                        $this ->order_manage->update_debit($order_id ,2 ,$after_credit_real_amount);
					}
					else
					{
						$after_cash_real_amount = $cash_debit['real_amount']+$ys_amount;
						$this ->order_manage->update_debit($order_id ,1 ,$after_cash_real_amount);
					}
				}
				else
				{ //改低应收返还额度，但需还完信用额度
					$config=array(
							'order_id'=>$order_id,
							'ys_amount'=>$ys_amount, //填的退应收的值(正值)+返还的现金（负值）
							'log_start'=>'改低应收'
					);
					$this->order_deal->return_limit($config);
				}
		}
	}

	/**
	 * @method 给订单新增合同
	 * @author jkr
	 */
	public function add_contract_new()
	{
		$order_id = intval($this ->input ->post('order_id'));
		$contract_sn = intval($this ->input ->post('contract_sn')); //合同编号
		if (empty($contract_sn))
		{
			$this ->callback ->setJsonCode(400 ,'请填写合同编号');
		}
		//获取订单信息
		$orderData = $this ->order_manage ->get_order_contract($order_id);
		if (empty($orderData))
		{
			$this ->callback ->setJsonCode(400 ,'没有找到订单，请联系管理员');
		}
		/**
		 * 合同分为两种，一：普通合同，二：电子合同(电子合同和普通合同的合同号也可能重复)
		 * 普通合同:分配管家后，管家所在营业部(此营业部代表顶级营业部)下的所有管家都可以使用(特别注意：普通合同的合同号可能重复)
		 * 电子合同:分配管家后，只能这个管家使用
		 */
		//根据合同号获取普通合同的数据
		
		
		
	}
//新增合同
function add_contract(){
	$arrData = $this->security->xss_clean($_POST);
	$order_id = $arrData['order_id'];//订单id
	$contract_sn = trim($arrData['contract_sn']); //要查找的合同编号
	$op_line_type = $arrData['op_line_type']; //1是境外合同，否则是境内合同

	$contract_res = $this->order_manage->get_contract_data($contract_sn,$op_line_type);
	$one_order = $this->order_manage->get_one_order($order_id);
	$depart = $this->order_manage->get_depart_limit($this->session->userdata('depart_id'));
	
	if(empty($contract_res)){
		echo json_encode(array('status'=>201,'msg'=>'无法找到此合同'));
		exit();
	}else{
		if($contract_res[0]['confirm_status']!=0){
			echo json_encode(array('status'=>202,'msg'=>'此合同已被使用'));
			exit();
		}else{
			$this->db->trans_begin();//开启事物
			$use_time = date('Y-m-d H:i:s');
			$type=1;
			if(!isset($contract_res[0]['contract_launch'])){
				$type=1;
				$sql = 'UPDATE b_contract_list SET confirm_status=1,use_time=\''.$use_time.'\', order_id='.$order_id.',ordersn=\''.$one_order['ordersn'].'\',expert_id='.$this->session->userdata('expert_id').',expert_name=\''.$this->session->userdata('real_name').'\',depart_id=\''.$this->session->userdata('depart_id').'\',depart_name=\''.$depart['name'].'\' WHERE id='.$contract_res[0]['id'];
				$this->db->query($sql);
				$sql2 = 'UPDATE  b_contract_use SET use_num=use_num+1 WHERE id='.$contract_res[0]['cu_id'];
				$this->db->query($sql2);
			}else{
				$type=2;
				$sql = 'UPDATE b_contract_launch SET confirm_status=1,use_time=\''.$use_time.'\', order_id='.$order_id.',order_sn=\''.$one_order['ordersn'].'\' WHERE id='.$contract_res[0]['id'];
				$this->db->query($sql);
			}


		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'添加失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'添加成功','data'=>array('contract_code'=>$contract_sn,'data_id'=>$contract_res[0]['id'],'type'=>$type)));
			exit();
		}
		}
	}
}
  
 /*
  * 删除合同： data_type=1 纸质合同   data_type=2 在线合同
  * */
 public function del_contract()
 {
 	$data_type=$this->input->post("data_type",true); //1是纸质合同，2是在线合同
 	$data_id=$this->input->post("data_id",true);
 	if(empty($data_type)){
 		echo json_encode(array('status'=>203,'msg'=>'合同类型不能为空'));
	    exit();
 	}
 	if(empty($data_id)){
 		echo json_encode(array('status'=>203,'msg'=>'合同id不能为空'));
 		exit();
 	}
 	
 	
 	$this->db->trans_begin();//开启事物
 	//删除合同   更新order_id为空
 	if($data_type=="1"){
 		$sql="update b_contract_list set confirm_status=0,order_id=0,ordersn=0,expert_id=0,expert_name=null,depart_id=0,depart_name=null where id=".$data_id;
 	    $this->db->query($sql);
 	    
 	    $use_one=$this->db->query("select use_id from b_contract_list where id=".$data_id)->row_array();
 	    if(!empty($use_one))
 	    $this->db->query("update b_contract_use set use_num=use_num-1 where id=".$use_one['use_id']);
 	    
 	}else{
 		$sql="update b_contract_launch set confirm_status=0,order_id=0,ordersn=0 where id=".$data_id;
 		$this->db->query($sql);
 	}
 	if($this->db->trans_status() === FALSE){
 		$this->db->trans_rollback();
 		echo json_encode(array('status'=>203,'msg'=>'操作失败'));
 		exit();
 	}else{
 		$this->db->trans_commit();
 		echo json_encode(array('status'=>200,'msg'=>'已删除'));
 		exit();
 	}
 	
 }

//新增发票
function add_invoice(){
	$arrData = $this->security->xss_clean($_POST);
	$order_id = $arrData['order_id'];
	$invoice_sn = $arrData['invoice_sn'];
	$op_line_type = $arrData['op_line_type'];
	$invoice_res = $this->order_manage->get_invoice_data($invoice_sn);
	$one_order = $this->order_manage->get_one_order($order_id);
	$depart = $this->order_manage->get_depart_limit($this->session->userdata('depart_id'));
	if(empty($invoice_res)){
		echo json_encode(array('status'=>201,'msg'=>'无法找到此发票'));
		exit();
	}else{
		if($invoice_res[0]['confirm_status']!=0){
			echo json_encode(array('status'=>202,'msg'=>'此发票已被使用'));
			exit();
		}else{
			$this->db->trans_begin();//开启事物
			$use_time = date('Y-m-d H:i:s');
			$sql = 'UPDATE b_invoice_list SET confirm_status=1,use_time=\''.$use_time.'\', order_id='.$order_id.',ordersn=\''.$one_order['ordersn'].'\',expert_id='.$this->session->userdata('expert_id').',expert_name=\''.$this->session->userdata('real_name').'\',depart_id='.$this->session->userdata('depart_id').',depart_name=\''.$depart['name'].'\' WHERE id='.$invoice_res[0]['id'];
			$this->db->query($sql);
			$sql2 = 'UPDATE  b_invoice_use SET use_num=use_num+1 WHERE id='.$invoice_res[0]['cu_id'];
			$this->db->query($sql2);
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>203,'msg'=>'添加失败'));
				exit();
			}else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>200,'msg'=>$invoice_sn));
				exit();
			}
		}
	}
}
	//删除发票、收据 ：data_type=1 发票  data_type=2 收据
	public function del_invoice()
	{
		$data_type=$this->input->post("data_type",true); 
		$data_id=$this->input->post("data_id",true);
		if(empty($data_type)){
			echo json_encode(array('status'=>203,'msg'=>'类型不能为空'));
			exit();
		}
		if(empty($data_id)){
			echo json_encode(array('status'=>203,'msg'=>'id不能为空'));
			exit();
		}
		
		$this->db->trans_begin();//开启事物
		//删除发票、收据   更新order_id为空
		if($data_type=="1"){
			$type_name="发票";
			$sql="update b_invoice_list set confirm_status=0,order_id=0,ordersn=0,expert_id=0,expert_name=null,depart_id=0,depart_name=null where id=".$data_id;
			$this->db->query($sql);
			
			$use_one=$this->db->query("select use_id from b_invoice_list where id=".$data_id)->row_array();
			if(!empty($use_one))
				$this->db->query("update b_invoice_use set use_num=use_num-1 where id=".$use_one['use_id']);
			
		}else{
			$type_name="收据";
			$sql="update b_receipt_list set confirm_status=0,order_id=0,ordersn=0,expert_id=0,expert_name=null,depart_id=0,depart_name=null where id=".$data_id;
			$this->db->query($sql);
			
			$use_one=$this->db->query("select use_id from b_receipt_list where id=".$data_id)->row_array();
			if(!empty($use_one))
				$this->db->query("update b_receipt_use set use_num=use_num-1 where id=".$use_one['use_id']);
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>203,'msg'=>'操作失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>$type_name.'已删除'));
			exit();
		}
	}

//新增收据
function add_receipt(){
	$arrData = $this->security->xss_clean($_POST);
	$order_id = $arrData['order_id'];
	$receipt_sn = $arrData['receipt_sn'];
	$op_line_type = $arrData['op_line_type'];
	$receipt_res = $this->order_manage->get_receipt_data($receipt_sn);
	$one_order = $this->order_manage->get_one_order($order_id);
	$depart = $this->order_manage->get_depart_limit($this->session->userdata('depart_id'));
	if(empty($receipt_res)){
		echo json_encode(array('status'=>201,'msg'=>'无法找到此收据'));
		exit();
	}else{
		if($receipt_res[0]['confirm_status']!=0){
			echo json_encode(array('status'=>202,'msg'=>'此收据已被使用'));
			exit();
		}else{
			$this->db->trans_begin();//开启事物
			$use_time = date('Y-m-d H:i:s');
			$sql = 'UPDATE b_receipt_list SET confirm_status=1,use_time=\''.$use_time.'\', order_id='.$order_id.',ordersn=\''.$one_order['ordersn'].'\',expert_id='.$this->session->userdata('expert_id').',expert_name=\''.$this->session->userdata('real_name').'\',depart_id='.$this->session->userdata('depart_id').',depart_name=\''.$depart['name'].'\' WHERE id='.$receipt_res[0]['id'];
			$this->db->query($sql);
			$sql2 = 'UPDATE  b_receipt_use SET use_num=use_num+1 WHERE id='.$receipt_res[0]['cu_id'];
			$this->db->query($sql2);
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>203,'msg'=>'添加失败'));
				exit();
			}else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>200,'msg'=>$receipt_sn));
				exit();
			}
		}
	}
}

function add_invoice_receipt(){
	$arrData = $this->security->xss_clean($_POST);
	$order_id = $arrData['order_id'];
	$invoice_receipt_sn = trim($arrData['invoice_receipt_sn']);
	$add_type = $arrData['add_type'];
	if(empty($add_type)){
		echo json_encode(array('status'=>203,'msg'=>'请选择增加发票还是收据'));
		exit();
	}
	if($add_type=='1'){
		//发票
		$res = $this->order_manage->get_invoice_data($invoice_receipt_sn);
	}else{
		//收据
		$res = $this->order_manage->get_receipt_data($invoice_receipt_sn);
	}

	$one_order = $this->order_manage->get_one_order($order_id);
	$depart = $this->order_manage->get_depart_limit($this->session->userdata('depart_id'));
	if(empty($res)){
		if($add_type=='1'){
			$msg = '无法找到此发票';
		}else{
			$msg = '无法找到此收据';
		}
		echo json_encode(array('status'=>201,'msg'=>$msg));
		exit();
	}else{
		if($res[0]['confirm_status']!=0){
			if($add_type=='1'){
				$msg = '此发票已被使用';
			}else{
				$msg = '此收据已被使用';
			}
			echo json_encode(array('status'=>202,'msg'=>$msg));
			exit();
		}else{
			$this->db->trans_begin();//开启事物
			$use_time = date('Y-m-d H:i:s');
			if($add_type=='1'){
				$sql = 'UPDATE b_invoice_list SET confirm_status=1,use_time=\''.$use_time.'\', order_id='.$order_id.',ordersn=\''.$one_order['ordersn'].'\',expert_id='.$this->session->userdata('expert_id').',expert_name=\''.$this->session->userdata('real_name').'\',depart_id='.$this->session->userdata('depart_id').',depart_name=\''.$depart['name'].'\' WHERE id='.$res[0]['id'];
				$this->db->query($sql);
				$sql2 = 'UPDATE  b_invoice_use SET use_num=use_num+1 WHERE id='.$res[0]['cu_id'];
				$this->db->query($sql2);
			}else{
				$sql = 'UPDATE b_receipt_list SET confirm_status=1,use_time=\''.$use_time.'\', order_id='.$order_id.',ordersn=\''.$one_order['ordersn'].'\',expert_id='.$this->session->userdata('expert_id').',expert_name=\''.$this->session->userdata('real_name').'\',depart_id='.$this->session->userdata('depart_id').',depart_name=\''.$depart['name'].'\' WHERE id='.$res[0]['id'];
				$this->db->query($sql);
				$sql2 = 'UPDATE  b_receipt_use SET use_num=use_num+1 WHERE id='.$res[0]['cu_id'];
				$this->db->query($sql2);
			}

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				echo json_encode(array('status'=>203,'msg'=>'添加失败'));
				exit();
			}else{
				$this->db->trans_commit();
				echo json_encode(array('status'=>200,'msg'=>'添加成功','data'=>array('code'=>$invoice_receipt_sn,'data_id'=>$res[0]['id'],'type'=>$add_type)));
				exit();
			}
		}
	}
}


	/*
	 * 获取账户余额
	 * */
	function get_limit(){
		$order_id = $this->input->post('order_id');
		$one_order = $this->order_manage->get_one_order($order_id);
		$is_add = true;
		$ys_data = $this->order_manage->get_ys_data(array('ys.order_id'=>$order_id,'ys.status'=>0));
		$yf_data = $this->order_manage->get_yf_data(array('yf.order_id'=>$order_id,'yf.status'=>0));
		if(!empty($ys_data) || !empty($yf_data)){
			$is_add = false;
		}
		$depart_limit = $this->order_manage->get_depart_limit($one_order['depart_id']);
		$depart_limit['is_add'] = $is_add;
		echo json_encode($depart_limit);
	}


	function ajax_get_one_travel(){
		$travel_man_id = $this->input->post('travel_man_id');
		$travel_man = $this->order_manage->get_one_travel($travel_man_id);
		echo json_encode($travel_man);
	}

	function edit_people(){
		$arrData = $this->security->xss_clean($_POST);
		$update_arr = array(
			'name'=>$arrData['travel_name'],
			'certificate_type'=>$arrData['certificate_type'],
			'telephone'=>$arrData['telephone'],
			'certificate_no'=>$arrData['cer_num'],
			'sex'=>$arrData['sex'],
			'birthday'=>$arrData['birthday']
			);
		if(isset($arrData['travel_en_name'])){
			$update_arr['enname'] = $arrData['travel_en_name'];
		}
		$status = $this->db->update('u_member_traver',$update_arr,array('id'=>$arrData['edit_travel_id']));
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'修改成功'));
			exit();
		}else{
			echo json_encode(array('status'=>201,'msg'=>'修改失败'));
			exit();
		}
	}

	//点击交款tab, 异步刷新局部数据
	function ajax_show_receive(){
		$order_id = $this->input->post('order_id');
		$order_info = $this->order_manage->get_one_order($order_id);
		$sum_receive = 0;
		$receive_data = $this->order_manage->get_receive_data($order_id);
		if(!empty($receive_data)){
			foreach ($receive_data as $key => $val) {
				if($val['status']==2){
					$sum_receive = $sum_receive+$val['money'];
				}
			}
		}
		$receive_data['sum_receive'] = $sum_receive;
		$whereArr=" order_id={$order_id} and (status=1 or status=2 or status=0)";
		$total_receive_amount = $this->order_manage->get_sum_receive2($whereArr);
		$receive_data['no_receive_amount'] = $order_info['total_price']-(!empty($total_receive_amount['total_receive_amount']) ? $total_receive_amount['total_receive_amount'] : 0);

		echo json_encode($receive_data);
	}

	function ajax_show_ys(){
		$sum_ys = 0;
		$order_id = $this->input->post('order_id');
		$ys_data = $this->order_manage->get_ys_data(array('ys.order_id'=>$order_id));
		if(!empty($ys_data)){
			foreach ($ys_data as $key => $val) {
				if($val['status']==1){
					$sum_ys = $sum_ys+$val['amount'];
				}
			}
		}
		$ys_data['sum_ys'] = $sum_ys;
		echo json_encode($ys_data);
	}

	function ajax_show_yf(){
		$sum_yf = 0;
		$order_id = $this->input->post('order_id');
		$yf_data = $this->order_manage->get_yf_data(array('yf.order_id'=>$order_id));
		if(!empty($yf_data)){
			foreach ($yf_data as $key => $val) {
				if($val['status']==2){
					$sum_yf = $sum_yf+$val['amount'];
				}
			}
		}
		$yf_data['sum_yf'] = $sum_yf;
		echo json_encode($yf_data);
	}

	function ajax_show_diplomatic(){
		$sum_commission = 0;
		$order_id = $this->input->post('order_id');
		$commission_data = $this->order_manage->get_commission_data($order_id);
		if(!empty($commission_data)){
			foreach ($commission_data as $key => $val) {
				$sum_commission = $sum_commission+$val['amount'];
			}
		}
		$commission_data['sum_commission'] = $sum_commission;
		echo json_encode($commission_data);
	}

}



