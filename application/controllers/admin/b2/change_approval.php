<?php
/**
 * 专家答题
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年8月4日15:05:11
 * @author		汪晓烽
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';
include_once './application/controllers/msg/t33_refund_msg.php';
class Change_approval extends UB2_Controller {

	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/change_approval_model', 'change_approval');
		$this->load_model('admin/b2/expert_model', 'expert');
		$this->load_model('admin/b2/order_manage_model', 'order_manage');
		
		$this->load_model('admin/b2/v2/order_deal_model', 'order_deal');//版本二
	}
    /*
     * 改价/退团审批页面
     * */
	function index() {
		$expert_info = $expert_info = $this->expert->all('FIND_IN_SET(\''.$this->session->userdata('parent_depart_id').'\',depart_list)>0' );
		$data['expert_info'] = $expert_info;
		$this->view('admin/b2/change_approval_view',$data);
	}
	/*
	 * 改价/退团审批页面：ajax数据
	* */
	function ajax_approval_list(){
		$whereArr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 10 : $number;
        	$page = empty($page) ? 1 : $page;

        	$order_sn = trim($this ->input ->post('order_sn' ,true));
       	$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$apply_status = trim($this ->input ->post('apply_status' ,true));
		$expert = trim($this ->input ->post('expert' ,true));

		if (!empty($order_sn)){
			$whereArr['md.ordersn like'] = '%'.$order_sn.'%';
		}

		if (!empty($apply_status) || $apply_status==='0'){
			$whereArr['ys.`status` ='] = $apply_status;
		}

		if (!empty($expert)){
			$whereArr['ys.expert_id ='] = $expert;
		}

		if (!empty($starttime)){
			$whereArr['ys.addtime >='] = $starttime;
		}

		if (!empty($endtime)){
			$whereArr['ys.addtime <='] = $endtime.' 23:59:59';
		}

		$whereArr['md.status !='] = -4 ; //已取消，已退款的订单不能进行"改价/退团"操作
		$approval_list = $this->change_approval->get_approval_data($whereArr,$page,$number);
		$pagecount = $this->change_approval->get_approval_data($whereArr,0,$number);
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
	               	"rows" => $approval_list
            		);
		echo json_encode($data);
	}

	/*
	 * 经理拒绝改价申请
	 */
	function refuse_apply()
	{
		$arrData = $this->security->xss_clean($_POST);
		$this->db->trans_begin();//开启事物

		$ys_info	  	= $this->change_approval->get_one_ys($arrData['refuse_id']);
		$refund_info 	= $this->change_approval->get_one_refund($arrData['refuse_id']);
		if($ys_info['status']==1 || $ys_info['status']==3){
			echo json_encode(array('status'=>208,'msg'=>"该条记录已审批过"));
			exit();
		}
		$update_ys_data = array(
			'status'=>3,
			'm_remark'=>$arrData['refuse_remark'],
			'm_time'=>date('Y-m-d H:i:s'),
			'manager_id'=>$this->expert_id
			);
		//应收账单改为拒绝状态
		$status = $this->db->update('u_order_bill_ys',$update_ys_data , array('id' => $arrData['refuse_id']));
		if(!empty($arrData['refuse_yf_id'])){
				$update_yf_data = array(
							'status'=>3,
							'm_remark'=>$arrData['refuse_remark'],
							'm_time'=>date('Y-m-d H:i:s'),
							'manager_id'=>$this->expert_id
			);
		//应付账单改为拒绝状态
		$status = $this->db->update('u_order_bill_yf',$update_yf_data , array('id' => $arrData['refuse_yf_id']));
		}
		//退款账单改为拒绝状态
		if(!empty($arrData['refuse_refund_id'])){
				$update_refund_data = array( 'status'=>-1);
				$status = $this->db->update('u_order_refund',$update_refund_data , array('id' => $arrData['refuse_refund_id']));
		}
		//kind=1是来自于新增修改;kind=2来自于退订
		if(!empty($arrData['refuse_kind']) && $arrData['refuse_kind']==2){
			//将退团的人全部还回去
			$this->change_approval->return_order_travel($arrData['refuse_order_id'],$arrData['refuse_yf_id']);
			$this->change_approval->return_del_travel($arrData['refuse_order_id'],$arrData['refuse_yf_id']);
		}
		//订单操作日志
		if(!empty($refund_info))
		    $this->order_manage->write_order_log($arrData['refuse_order_id'],'在改价/退团审批页面，审核拒绝退团：退应收'.$refund_info['ys_money'].'、退已交'.$refund_info['sk_money'].'、退应付'.$refund_info['yf_money'].'，退人:'.$refund_info['num'].'个');
		else 
			$this->order_manage->write_order_log($arrData['refuse_order_id'],'在改价/退团审批页面，审核拒绝调整应收：'.$ys_info['amount']);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			//发送消息
			if ($arrData['refuse_refund_id'] > 0)
			{
				$msg = new T33_refund_msg();
				$msgArr = $msg ->sendMsgRefund($arrData['refuse_refund_id'],2,$this->session->userdata('real_name'));
			}
			else
			{
				$msg = new T33_send_msg();
				$msgArr = $msg ->billYsUpdate($arrData['refuse_id'],2,$this->session->userdata('real_name'));
			}
			echo json_encode(array('status'=>200,'msg'=>'已拒绝'));
			exit();
		}
	}



	//经理通过改价申请,里面的操作逻辑和order_manage控制器一样
	//也就是扣还额度, 修改订单(应收)数据
	function pass_apply()
	{
		$arrData = $this->security->xss_clean($_POST);
		//$this->load_model('admin/b2/order_manage_model', 'order_manage');
		$this->load_model('common/u_line_model', 'line');
		$order_id = $arrData['pass_order_id'];
		$ys_id = $arrData['pass_id'];
		$yf_id = empty($arrData['yf_id'])==true?0:$arrData['yf_id'];
		$yf_kind = $arrData['yf_kind']; //等于1的时候才需要修改成本价和人数
		$pass_remark = $arrData['pass_remark'];
		$pass_depart_id = $arrData['pass_depart_id'];
		$pass_refund_id = $arrData['pass_refund_id'];
		$total_foreign_agent = 0;//默认增加的外交佣金是 0
		$add_platform_fee = 0;  //平台佣金
		$total_agent = 0; //总的佣金(是外交佣金或者平台佣金)
		$after_order_info = array();
		$this->db->trans_begin();//开启事物
		//获各个额度
		//$debit_info = $this->change_approval->get_order_debit($order_id);
		$final_res 		= $this->change_approval->get_depart_limit($pass_depart_id);//get_expert_limit($order_id);
		$order_info 	= $this->change_approval->get_one_order($order_id);
		$ys_info	  	= $this->change_approval->get_one_ys($ys_id);
		$refund_info 	= $this->change_approval->get_one_refund($ys_id);
		
		$sum_ys = $this->order_manage->get_sum_ys($order_id);
		$whereArr['order_id='] = $order_id;
		$whereArr['status!='] = '3,4,6';
		$sum_receive = $this->order_manage->get_sum_receive($whereArr);

		$sum_receive2 = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status='=>2));

		$sum_receive_pending = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status!='=>'2,3,4,6'));
		if($ys_info['status']==1 || $ys_info['status']==3){
			echo json_encode(array('status'=>208,'msg'=>"该条记录已审批过"));
			exit();
		}

		if($ys_info['amount']<0 && (abs($ys_info['amount'])>$order_info['total_price'])){
			echo json_encode(array('status'=>204,'msg'=>"订单金额对冲太多,为负数"));
			exit();
		}
		if($ys_info['status']!=0){
			echo json_encode(array('status'=>207,'msg'=>"经理已经审核过, 无需再次审核"));
			exit();
		}
		if($order_info['status']==9 || $order_info['status']==-1 || $order_info['status']==-2 || $order_info['status']==-6 ){
					//未提交的订单,可以修改订单信息(参团人数, 订单金额等, 并且和额度无关)
					//重新计算订单的各个价格
					$after_order_info['total_price'] = $order_info['total_price']+$ys_info['amount'];
					if($yf_kind==1){//新增
						$yf_info	  = $this->change_approval->get_one_yf($yf_id);
						$after_order_info['supplier_cost'] = $order_info['supplier_cost']+$yf_info['amount'];
					}else{//退团
						$after_order_info['supplier_cost'] = $order_info['supplier_cost'];
					}
					$after_order_info['agent_fee'] = $after_order_info['total_price']-$after_order_info['supplier_cost']-$order_info['diplomatic_agent'];//-$order_info['platform_fee'];
					$this->db->update('u_member_order',$after_order_info,array('id'=>$order_id));
					$update_ys = array('status'=>1,'m_time'=>date('Y-m-d H:i:s'),'m_remark'=>" 经理通过 ");
					$this->db->update('u_order_bill_ys',$update_ys,array('id'=>$ys_id));
		}else{
			if($ys_info['amount']>=0){
				if($ys_info['amount']>($final_res['cash_limit']+$final_res['credit_limit'])){
					echo json_encode(array('status'=>202,'msg'=>"可用额度不够扣款"));
					exit();
				}
			}
		//重新计算订单的价格
		$after_order_info['total_price'] = $order_info['total_price']+$ys_info['amount'];
		$after_order_info['agent_fee'] = $after_order_info['total_price']-$order_info['supplier_cost']-$order_info['diplomatic_agent'];//-$order_info['platform_fee'];
		$this->db->update('u_member_order',$after_order_info,array('id'=>$order_id));

		//(信用/现金)额度重新计算
		if($ys_info['amount']>0){
			$cash_debit = $this->order_manage->get_one_debit($order_id,1);
			$credit_debit = $this->order_manage->get_one_debit($order_id,2);
			$this->order_manage->del_limit($order_id,$pass_depart_id,$ys_info['amount']);
			$receive_data = array(
				'money'=>$ys_info['amount'],
				'way'=>'账户余额',
				'remark'=>'改高应收价格直接使用账户余额交款',
				'status'=>0
				);
			$receive_id = $this->order_manage->write_receive($order_id,$receive_data);
			$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('id'=>$ys_id));
			//应收价改变的时候, 需要相对应的修改扣款表的数据
                   if($ys_info['amount']>$final_res['cash_limit']){
				$after_cash_real_amount = $cash_debit['real_amount']+$final_res['cash_limit'];
				$after_credit_real_amount = ($ys_info['amount']-$final_res['cash_limit'])+$credit_debit['real_amount'];
			   	$this ->order_manage->update_debit($order_id ,1 ,$after_cash_real_amount);
                         $this ->order_manage->update_debit($order_id ,2 ,$after_credit_real_amount);
			}else{
				$after_cash_real_amount = $cash_debit['real_amount']+($final_res['cash_limit']-$ys_info['amount']);
				$this ->order_manage->update_debit($order_id ,1 ,$after_cash_real_amount);
			}

		}else{
			if(!empty($refund_info)){//退团
				    //按退已交的值去退款
					$cash_refund=abs($refund_info['sk_money']);
					$insert_limit_log = array(
						'refund_monry'=>abs($refund_info['sk_money']),
						'type'=>'退订退款',
						'addtime'=>date('Y-m-d H:i:s',strtotime("-2 second")),
						'remark'=>'经理通过退订退款申请',
						'log_start'=>'退订退款，'
					);
					$this->order_manage->return_cash(abs($refund_info['sk_money']),$order_info['depart_id']);
					//按退已交的值去还u_order_debit表的现金
					$this->order_manage->reback_debit($order_id,'1',$insert_limit_log['refund_monry'],'退团还额度');
					$config=array(
							'order_id'=>$order_id,
							'ys_amount'=>$ys_info['amount']+$insert_limit_log['refund_monry'],//填的退应收的值(正值)+返还的现金（负值）
							'log_start'=>'退订退款'
					);
					//退应收-退已交  的值去还管家信用额度
					if($config['ys_amount']<0)
					$this->order_deal->return_limit($config);
					//写额度明细日志
					if($refund_info['sk_money']!=0)
					{
						unset($insert_limit_log['log_start']);
						$this->order_manage->write_limit_log($order_id,$insert_limit_log);
					}
					//更新u_order_refund表的cash_refund字段,方便供应商拒绝时知道该退多少钱
					$this->order_manage->update_cash_refund($ys_id,$cash_refund);
					//若不走供应商审核退款流程，且已交全款，已返管家佣金，则扣回已返的管家佣金
					if($refund_info['yf_id']==0){
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
          
			}else{
				//改价
				 //退款流水记录
				$insert_limit_log = array(
					'type'=>'改低应收价格,退款',
					'remark'=>'经理通过改低应应收价格申请'
				);
				$config=array(
						'order_id'=>$order_id,
						'ys_amount'=>$ys_info['amount'], 
						'log_start'=>'改低应收'
				);
				$this->order_deal->return_limit($config);
				
				/**重新计算返佣金**/
				$order_data = $this->order_manage->get_one_order($order_id);
				$receive_res = $this->order_manage->get_sum_receive(array('order_id='=>$order_id,'status='=>2));
				if($order_data['total_price']==$receive_res['total_receive_amount']){
					if($order_data['depart_balance']>$order_data['agent_fee']){
						$refund_agent_fee = $order_data['depart_balance']-$order_data['agent_fee'];
						$this->order_manage->del_cash($refund_agent_fee,$order_data['depart_id']);
						$insert_limit_log = array(
							'cut_money'=>-$refund_agent_fee,
							'type'=>'改价,扣除多返的管家佣金',
							'remark'=>'改价,扣除多返的管家佣金'
							);
						$this->order_manage->write_limit_log($order_id,$insert_limit_log);
					}elseif($order_data['depart_balance']<$order_data['agent_fee']){
						$add_agent_fee = $order_data['agent_fee']-$order_data['depart_balance'];
						$this->order_manage->return_cash($add_agent_fee,$order_data['depart_id']);
						$insert_limit_log = array(
							'receivable_money'=>$add_agent_fee,
							'type'=>'改价,增加管家佣金',
							'remark'=>'改价,增加管家佣金'
							);
						$this->order_manage->write_limit_log($order_id,$insert_limit_log);
					}
					$this->db->update('u_member_order',array('depart_balance'=>$order_data['agent_fee']),array('id'=>$order_id));
				}
				
			}//if end
		}

		if(!empty($refund_info) && $refund_info['yf_id']!=0) {//退团
			$update_yf = array('status'=>1,'m_time'=>date('Y-m-d H:i:s'),'m_remark'=>" 经理通过 ");
			$this->db->update('u_order_bill_yf',$update_yf,array('id'=>$yf_id));
		}
			$update_ys = array('status'=>1,'m_time'=>date('Y-m-d H:i:s'),'m_remark'=>" 经理通过 ");
			$this->db->update('u_order_bill_ys',$update_ys,array('id'=>$ys_id));
		}
		if(!empty($refund_info) && $refund_info['num']>=1){
				//通过的时候删除退团的人,并且退还位置回去
				$travel_data = $this->change_approval->get_travel_record($order_id,$ys_id);
				$del_traveler = $this->change_approval->get_order_travel($travel_data[0]['travel_id']);
				$agent_rules = $this->order_manage->get_agent_rules($order_id);
				if(!empty($agent_rules)){
					if($agent_rules['kind']==1 || $agent_rules['kind']==4){//按照人头算佣金
						
						if($order_info['suitnum']==0) //非套餐
							$total_agent = ($travel_data[0]['num']*$agent_rules['adultprice'])+($travel_data[0]['childnobednum']*$agent_rules['childnobedprice'])+($travel_data[0]['oldnum']*$agent_rules['oldprice'])+($travel_data[0]['childnum']*$agent_rules['childprice']);
						else  //套餐
							$total_agent = $order_info['suitnum']*$agent_rules['adultprice'];
						
						if($agent_rules['type']==1){
							//外交佣金
							$total_foreign_agent = $total_agent;
							$insert_wj_log = array(
								'num'=>1,
								'price'=>-$total_foreign_agent,
								'amount'=>-$total_foreign_agent,
								'remark' =>'退人,退外交佣金: '.$total_foreign_agent,
								'item' =>'退参团人'
								);
							$this->order_manage->write_wj($order_id,$insert_wj_log);
						}else{
							//平台管理费
							$add_platform_fee = $total_agent;
							$insert_yj_log = array(
								'num'=>1,
								'price'=>-$add_platform_fee,
								'amount'=>-$add_platform_fee,
								'item' =>'退参团人',
								'm_time'=>date('Y-m-d H:i:s'),
								'a_time'=>date('Y-m-d H:i:s'),
								'status'=>2,
								'remark'=>'退参团人,退平台管理费: '.$add_platform_fee
								);
							$this->order_manage->write_yj($order_id,$insert_yj_log);
						}
					}elseif($agent_rules['kind']==2){
						//按照比例算佣金,对应的账单只需要写一个
						$tui_price =0;
						foreach ($del_traveler AS $key => $val) {
							$tui_price = $tui_price+$val['price'];
						}
						/*$tui_price =  ($travel_data[0]['num']*$order_info['price'])+($travel_data[0]['childnobednum']*$order_info['childnobedprice'])+($travel_data[0]['oldnum']*$order_info['oldprice'])+($travel_data[0]['childnum']*$order_info['childprice']);*/
						$total_agent = abs($tui_price)*$agent_rules['ratio'];
						if($agent_rules['type']==1){
							//外交佣金
							$total_foreign_agent = $total_agent;
							$insert_wj_log = array(
								'num'=>1,
								'price'=>-$total_foreign_agent,
								'amount'=>-$total_foreign_agent,
								'remark' =>'退人,退外交佣金: '.$total_foreign_agent,
								'item' =>'退参团人'
								);
							$this->order_manage->write_wj($order_id,$insert_wj_log);
						}else{
							//平台管理费
							$add_platform_fee = $total_agent;
							$insert_yj_log = array(
								'num'=>1,
								'price'=>-$add_platform_fee,
								'amount'=>-$add_platform_fee,
								'item' =>'退参团人',
								'm_time'=>date('Y-m-d H:i:s'),
								'a_time'=>date('Y-m-d H:i:s'),
								'status'=>2,
								'remark'=>'退参团人,退平台管理费: '.$add_platform_fee
								);
							$this->order_manage->write_yj($order_id,$insert_yj_log);
						}
					}elseif($agent_rules['kind']==3){
						//按照天数算佣金,对应的账单只需要写一个
						$total_agent = ($travel_data[0]['num']+$travel_data[0]['oldnum']+$travel_data[0]['childnum']+$travel_data[0]['childnobednum'])*$agent_rules['dayprice'];
						if($agent_rules['type']==1){
							//外交佣金
							$total_foreign_agent = $total_agent;
							$insert_wj_log = array(
								'num'=>1,
								'price'=>-$total_foreign_agent,
								'amount'=>-$total_foreign_agent,
								'remark' =>'退团,退外交佣金: '.$total_foreign_agent,
								'item' =>'退参团人'
								);
							$this->order_manage->write_wj($order_id,$insert_wj_log);
						}else{
							//平台管理费
							$add_platform_fee = $total_agent;
							$insert_yj_log = array(
								'num'=>1,
								'price'=>-$add_platform_fee,
								'amount'=>-$add_platform_fee,
								'item' =>'退参团人',
								'm_time'=>date('Y-m-d H:i:s'),
								'a_time'=>date('Y-m-d H:i:s'),
								'status'=>2,
								'remark'=>'退参团人,退平台管理费: '.$add_platform_fee
								);
							$this->order_manage->write_yj($order_id,$insert_yj_log);
						}
					}
					//$this->db->update('u_member_order',array('yj_lock'=>0,'wj_lock'=>0),array('id'=>$order_id));
				}
				if(!empty($travel_data)){
					
					$this->order_manage->save_tuituan_travels($travel_data[0]['travel_id'],$order_id,$yf_id);
					$this->db->query('DELETE FROM u_member_traver where id IN ('.$travel_data[0]['travel_id'].')');
					$this->db->query('DELETE FROM u_member_order_man where traver_id IN ('.$travel_data[0]['travel_id'].') AND order_id='.$order_id);
					$this->db->query('UPDATE u_member_order SET dingnum=dingnum-'.$travel_data[0]['num'].',oldnum=oldnum-'.$travel_data[0]['oldnum'].', childnum=childnum-'.$travel_data[0]['childnum'].',childnobednum=childnobednum-'.$travel_data[0]['childnobednum'].',diplomatic_agent=diplomatic_agent-'.$total_foreign_agent.',platform_fee=platform_fee-'.$add_platform_fee.' WHERE id='.$order_id);
				}
				$travels_people =  $this->order_manage->get_travels($order_id);
				if(empty($travels_people)){
					//全团退人的时候订单状态变成退订中
					$this->db->query('UPDATE u_member_order SET status=-3 WHERE id='.$order_id);
					$this->db->query('UPDATE u_line_suit_price SET number=number+'.($travel_data[0]['num']+$travel_data[0]['childnum']+$travel_data[0]['childnobednum']+$travel_data[0]['oldnum']).',order_num=order_num-1 WHERE dayid='.$travel_data[0]['suit_day_id']);
				}else{
					$this->db->query('UPDATE u_line_suit_price SET number=number+'.($travel_data[0]['num']+$travel_data[0]['childnum']+$travel_data[0]['childnobednum']+$travel_data[0]['oldnum']).' WHERE dayid='.$travel_data[0]['suit_day_id']);
				}
		}
		if(!empty($refund_info)){
			$sum_receive_total_pending = $sum_receive_pending['total_receive_amount']+$refund_info['sk_money'];
			//新增加一个退款记录表
			$order_data = $this->change_approval->get_one_order($order_id);
			$insert_receive_data = array(
					'money'=>$refund_info['sk_money'],
					'status'=>1,
					'kind'=>2,
					'way'=>'账户余额',
					'remark'=>'经理通过退团,退已交款'
				);
			if($refund_info['sk_money']!=0){
				if($sum_receive_total_pending!=0){
					
					$receive_id = $this->order_manage->write_receive($order_id,$insert_receive_data);
				}else{
					
					$receive_res = $this->order_manage->get_pedding_receive($order_id);
					$receive_id  = $receive_res['recevie_ids'];
					$this->order_manage->cancle_receive($order_id);
					//$receive_id  = 0;
				}
			}else{
				$receive_id = 0;
			}
			if($refund_info['ys_id']==0){
				if($refund_info['sk_id']==0){
					$update_refund = array('status'=>3,'sk_id'=>$receive_id);
				}else{
					$update_refund = array('status'=>2,'sk_id'=>$receive_id);
				}
			}else{
				$update_refund = array('status'=>2,'sk_id'=>$receive_id);
			}
			$this->db->update('u_order_refund',$update_refund,array('ys_id'=>$ys_id));
			//更新应收表的sk_id
			$this->db->update('u_order_bill_ys',array('sk_id'=>$receive_id),array('id'=>$ys_id));
			
			//订单操作日志
			$this->order_manage->write_order_log($order_id,'在改价/退团审批页面，审核通过退团：退应收'.$refund_info['ys_money'].'、退已交'.$refund_info['sk_money'].'、退应付'.$refund_info['yf_money'].'，退人:'.$refund_info['num'].'个');
		}
		else 
		{
			//写订单操作日志
			$this->order_manage->write_order_log($order_id,'在改价/退团审批页面，审核通过调整应收:'.$ys_info['amount']);
		}
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			//发送消息
			if (empty($refund_info))
			{
				$msg = new T33_send_msg();
				$msgArr = $msg ->billYsUpdate($ys_id,2,$this->session->userdata('real_name'));
			}
			else
			{
				$msg = new T33_refund_msg();
				$msgArr = $msg ->sendMsgRefund($refund_info['id'],2,$this->session->userdata('real_name'));
			}
			echo json_encode(array('status'=>200,'msg'=>'已通过'));
			exit();
		}
	}
}