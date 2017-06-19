<?php
/**
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:00:11
 * @author		温文斌
 *
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_deal_model extends MY_Model {

	public function __construct() {
		parent::__construct();
	}
        /*
         * @name: 获取已交款总计
         * @return: 一维数组
         */
	function get_sum_receive($whereArr){
                $whereStr="";
                if(isset($whereArr['status!='])){
			$whereStr .= ' and status not in('.$whereArr['status!='].') ';
		}elseif(isset($whereArr['status'])){
			$whereStr .= " and status = {$whereArr['status']}";	
		}
                if(isset($whereArr['order_id']))
                    $whereStr.=" and order_id={$whereArr['order_id']}";
		$sql = "SELECT IFNULL(sum(money), 0)  AS total FROM u_order_receivable where id>0 {$whereStr}";
		$query = $this->db->query($sql);
		$row=$query->row_array();
		return $row;
	}
        /*
         * @name: 获取应收总计
         * @return: 一维数组
         */
	function get_sum_ys($whereArr){
                $whereStr="";
                if(isset($whereArr['status!='])){
			$whereStr .= ' and status not in('.$whereArr['status!='].') ';
		}elseif(isset($whereArr['status'])){
			$whereStr .= " and status = {$whereArr['status']}";	
		}
                if(isset($whereArr['order_id']))
                    $whereStr.=" and order_id={$whereArr['order_id']}";
		$sql = "SELECT IFNULL(sum(amount), 0)  AS total FROM u_order_bill_ys where id>0 {$whereStr}";
		$query = $this->db->query($sql);
		$row=$query->row_array();
		return $row;
	}
         /*
         * @name: 获取应收总计
         * @return: 一维数组
         */
	function get_sum_yf($whereArr){
                $whereStr="";
                if(isset($whereArr['status!='])){
			$whereStr .= ' and status not in('.$whereArr['status!='].') ';
		}elseif(isset($whereArr['status'])){
			$whereStr .= " and status = {$whereArr['status']}";	
		}
                if(isset($whereArr['order_id']))
                    $whereStr.=" and order_id={$whereArr['order_id']}";
		$sql = "SELECT IFNULL(sum(amount), 0)  AS total FROM u_order_bill_yf where id>0 {$whereStr}";
		$query = $this->db->query($sql);
		$row=$query->row_array();
		return $row;
	}
         /*
         * @name: 获取保险费用总计
         * @return: 一维数组
         */
	function get_sum_bx($whereArr){
                $whereStr="";
                if(isset($whereArr['status!='])){
			$whereStr .= ' and status not in('.$whereArr['status!='].') ';
		}elseif(isset($whereArr['status'])){
			$whereStr .= " and status = {$whereArr['status']}";	
		}
                if(isset($whereArr['order_id']))
                    $whereStr.=" and order_id={$whereArr['order_id']}";
		$sql = "SELECT IFNULL(sum(amount), 0)  AS total FROM u_order_bill_bx where id>0 {$whereStr}";
		$query = $this->db->query($sql);
		$row=$query->row_array();
		return $row;
	}
         /*
         * @name: 获取外交佣金总计
         * @return: 一维数组
         */
	function get_sum_wj($whereArr){
                $whereStr="";
                if(isset($whereArr['status!='])){
			$whereStr .= ' and status not in('.$whereArr['status!='].') ';
		}elseif(isset($whereArr['status'])){
			$whereStr .= " and status = {$whereArr['status']}";	
		}
                if(isset($whereArr['order_id']))
                    $whereStr.=" and order_id={$whereArr['order_id']}";
		$sql = "SELECT IFNULL(sum(amount), 0)  AS total FROM u_order_bill_wj where id>0 {$whereStr}";
		$query = $this->db->query($sql);
		$row=$query->row_array();
		return $row;
	}
         /*
         * @name: 获取平台佣金总计
         * @return: 一维数组
         */
	function get_sum_yj($whereArr){
                $whereStr="";
                if(isset($whereArr['status!='])){
			$whereStr .= ' and status not in('.$whereArr['status!='].') ';
		}elseif(isset($whereArr['status'])){
			$whereStr .= " and status = {$whereArr['status']}";	
		}
                if(isset($whereArr['order_id']))
                    $whereStr.=" and order_id={$whereArr['order_id']}";
		$sql = "SELECT IFNULL(sum(amount), 0)  AS total FROM u_order_bill_yj where id>0 {$whereStr}";
		$query = $this->db->query($sql);
		$row=$query->row_array();
		return $row;
	}
         /*
         * @name: 订单详情
         * @return: 一维数组
         */
        function order_detail($order_id){
		$sql = 'SELECT 
                                md.*,e.depart_name,e.realname,suit.suitname,suit.unit,l.linebefore,aff.deposit,order_aff.deposit AS order_deposit,
                                order_aff.before_day 
                        FROM 
                                u_member_order AS md 
                                LEFT JOIN u_expert AS e ON e.id=md.expert_id 
                                LEFT JOIN u_line_suit AS suit ON suit.id=md.suitid  
                                LEFT JOIN u_line AS l ON l.id=md.productautoid 
                                LEFT JOIN u_line_affiliated AS aff ON aff.line_id=l.id 
                                LEFT JOIN u_member_order_affiliated AS order_aff ON order_aff.order_id=md.id 
                       WHERE md.id='.$order_id;
		$query = $this->db->query($sql);
		$row=$query->row_array();
                $row['top_depart_id']=current(explode(',',rtrim($row['depart_list'],','))); //顶级部门id，扣额度，返额度都是这个部门
                return $row;
	}
         /*
         * @name: 获取营业部信息： 基本信息、现金额度、信用额度
         * @return: 一维数组
         */
 	function depart_detail($depart_id){
 		$sql = 'SELECT * FROM b_depart WHERE id='.$depart_id;
		$depart = $this->db->query($sql)->row_array();
		return $depart;
		
 	}
        /*分割线*/
        function _______________________()
	{
            
        }
        /*
         * 还管家信用、营业部信用
         * @param: $config数组
         *         order_id:订单id
         *         ys_amount：变化的应收金额
         *         log_start：日志开头
         *          
         * */
	function return_limit($config)
	{
		if(!empty($config['order_id'])&&!empty($config['ys_amount']))
		{
                    $ys_amount=abs($config['ys_amount']);//转化为绝对值
                    $ys_amount_after=0;//还完管家信用剩下的金额
                    $log_start=empty($config['log_start'])==true?'':$config['log_start'];
                    ////////////    先还管家信用
                    //1、还 u_order_debit表
                    $sx_debit=$this->get_one_debit($config['order_id'],'3');
                    if(!empty($sx_debit)&&$ys_amount>0)
                    {//管家信用
                            $no_back=$sx_debit['real_amount']-$sx_debit['repayment']; //没有还的
                            if($no_back>0)
                            {
                                $to_back=0;
                                if($ys_amount>=$no_back&&$no_back>0){
                                    $to_back=$no_back;
                                    $ys_amount_after=$ys_amount-$no_back;
                                }
                                else
                                    $to_back=$ys_amount;
                                $this->reback_debit($config['order_id'], '3', $to_back,'改低应收还管家信用');
                                $limit_log = array(
                                        'sx_limit'=>-$to_back,
                                        'type'=>$log_start.',自动还款(管家信用)',
                                        'remark'=>'b2:'.$log_start.'自动还款(管家信用)'
                                );
                                $this->write_limit_log($config['order_id'],$limit_log);
                            } 
                            else
                                $ys_amount_after=$ys_amount;
                    }
                   
                    $sx_debit_depart=$this->get_one_debit($config['order_id'],'2');
                    if(!empty($sx_debit_depart)&&$ys_amount_after>0)
                    {//营业部信用
                            $no_back=$sx_debit_depart['real_amount']-$sx_debit_depart['repayment']; //没有还的
                            if($no_back>0)
                            {
                                $to_back=0;
                                if($ys_amount_after>=$no_back&&$no_back>0){
                                    $to_back=$no_back;
                                }
                                else
                                    $to_back=$ys_amount_after;
                                $this->reback_debit($config['order_id'], '2', $to_back,'改低应收还营业部信用');
                                $limit_log = array(
                                        'sx_limit'=>-$to_back,
                                        'type'=>$log_start.',自动还款(营业部信用)',
                                        'remark'=>'b2:'.$log_start.'自动还款(营业部信用)'
                                );
                                $this->write_limit_log($config['order_id'],$limit_log);
                            }
                    }
                    
                    //2、还b_expert_limit_apply表
                    $expert_limit=$this->get_e_limit($config['order_id']);
                    if(!empty($expert_limit)&&$expert_limit['apply_amount']>0)
                    {
                               $no_back_limit=$expert_limit['apply_amount']-$expert_limit['return_amount'];
                               $to_back=0;
                               if($ys_amount>=$no_back_limit)
                                   $to_back=$no_back_limit;
                               else 
                                   $to_back=$ys_amount;
                               $row=  $this->get_e_limit($config['order_id']);
                               if(($row['return_amount']+$to_back)>=$row['apply_amount']){ //已还清
                                   $this->db->query("update b_expert_limit_apply set return_amount=apply_amount,status=2,return_time='".date("Y-m-d H:i:s")."' where order_id=".$config['order_id']);
                                   $this->db->query("update b_limit_apply set status=4 where order_id=".$config['order_id']);
                               }else{
                                 $this->db->query("update b_expert_limit_apply set return_amount=return_amount+".$to_back.",return_time='".date("Y-m-d H:i:s")."' where order_id=".$config['order_id']);
                               }
                    }
                   
		}
               
	}
	/*
	 * 使用（扣除）额度
	 * 先扣营业部现金、再扣营业部信用
	 * */
	function use_limit($order_id,$amount,$log_start="",$end=""){
		$order_info=$this->order_detail($order_id);
		$depart_limit = $this->depart_detail($order_info['depart_id']);
		
		if(!empty($depart_limit))
		{
			if($depart_limit['cash_limit']>=$amount){//账户现金额度足够扣除
				
				$this->del_cash($amount,$order_info['depart_id']);
				//流水账记录
				$insert_limit_log = array(
						'cut_money'=>-$amount,
						'type'=>$log_start.'，扣营业部现金'.$end,
						'remark'=>'b2：'.$log_start.'扣营业部现金'.$end
				);
				if($amount>0)
				$this->write_limit_log($order_id,$insert_limit_log);
			}else{//既扣现金、又扣信用
				//扣营业部现金
				$this->del_cash($depart_limit['cash_limit'],$order_info['depart_id']);
				//额度明细
				$insert_limit_log = array(
						'cut_money'=>-$depart_limit['cash_limit'],
						'type'=>$log_start.'，扣营业部现金'.$end,
						'remark'=>'b2：'.$log_start.'扣营业部现金'.$end
				);
				if($depart_limit['cash_limit']>0)
				$this->write_limit_log($order_id,$insert_limit_log);
				//扣营业部信用
				$this->del_credit($amount-$depart_limit['cash_limit'],$order_info['depart_id']);
				//额度明细
				$insert_limit_log = array(
						'cut_money'=>-($amount-$depart_limit['cash_limit']),
						'type'=>$log_start.'，扣营业部信用'.$end,
						'remark'=>'b2：'.$log_start.'扣营业部信用'.$end
				);
				if(($amount-$depart_limit['cash_limit'])>0)
				$this->write_limit_log($order_id,$insert_limit_log);
			}
			
		}
		
	}
    //获取一条扣款记录
	function get_one_debit($order_id,$type){
		$sql='SELECT od.* FROM u_order_debit AS od WHERE od.order_id='.$order_id.' AND od.type='.$type;
		$query = $this->db->query($sql);
		$result=$query->row_array();
		return $result;
	}
        /*
	 * 返还扣款表u_order_debit：repayment
	 * */
	public function reback_debit($order_id ,$type ,$amount ,$remark='退团还额度'){
		$modtime=date('Y-m-d H:i:s');
		$sql="update u_order_debit set repayment=repayment+".$amount.",modtime='".$modtime."',remark='".$remark."' where order_id=".$order_id." and type=".$type."";
		$this->db->query($sql);
        //状态修改
        $row=  $this->db->query("select * from u_order_debit where order_id='{$order_id}' and type='{$type}' ")->row_array();
        if(!empty($row)&&$row['repayment']>=$row['real_amount'])
        $this->db->query("update u_order_debit set status=1 where order_id='{$order_id}' and type='{$type}' ");
        
        //还营业部信用的时候，营业部信用要加到营业部账户上去
        if($type==2)
        {
        $orderInfo=$this->order_detail($order_id);
        $this->db->query("update b_depart set credit_limit=credit_limit+'{$amount}' where id ={$orderInfo['depart_id']} ");
        }
	}
        //获取管家信用使用记录
 	function get_e_limit($order_id){
 		$sql = 'SELECT * FROM b_expert_limit_apply WHERE order_id='.$order_id;
		$expert_limit = $this->db->query($sql)->row_array();
		return $expert_limit;
 	}
    //额度变化明细日志
 	function write_limit_log($order_id,$limit_data=array()){
		$order_info = $this->order_detail($order_id);
	 	$manage = $this->get_manage();
	 	$depart_limit = $this->depart_detail($order_info['top_depart_id']);//扣款部门id,即顶级部门id
		$insert_limit_log = array(
				'depart_id'=>$order_info['top_depart_id'], //扣款部门id,即顶级部门id
                //'use_depart_id'=>$order_info['depart_id'], //使用部门id
				'expert_id'=>$order_info['expert_id'],
				'manager_id'=>$manage['id'],
				'order_id'=>$order_info['id'],
				'order_sn'=>$order_info['ordersn'],
				'order_price'=>$order_info['total_price'],//$order_data['total_price'],
				'union_id'=>$this->session->userdata('union_id'),
				'cash_limit'=>$depart_limit['cash_limit'],
				'credit_limit'=>$depart_limit['credit_limit'],
				'addtime'=>date('Y-m-d H:i:s')
				);
		$insert_limit_log = array_merge($insert_limit_log, $limit_data);
		$status = $this->db->insert('b_limit_log',$insert_limit_log);
		return $this->db->insert_id();
                  
	}
	//部门额度明细
	function write_depart_log($depart_id,$limit_data=array()){
		
		$manage = $this->get_manage();
		$depart_limit = $this->depart_detail($depart_id);//扣款部门id,即顶级部门id
		$insert_limit_log = array(
				'depart_id'=>$depart_id, //扣款部门id,即顶级部门id
				'manager_id'=>$manage['id'],
				'union_id'=>$this->session->userdata('union_id'),
				'cash_limit'=>$depart_limit['cash_limit'],
				'credit_limit'=>$depart_limit['credit_limit'],
				'addtime'=>date('Y-m-d H:i:s')
		);
		$insert_limit_log = array_merge($insert_limit_log, $limit_data);
		$status = $this->db->insert('b_limit_log',$insert_limit_log);
		return $this->db->insert_id();
	
	}
    //获取经理信息
 	function get_manage(){
 		$sql = 'SELECT * FROM u_expert WHERE is_dm=1 AND depart_id='.$this->session->userdata('parent_depart_id');
		$manage = $this->db->query($sql)->row_array();
		return $manage;
 	}
 	//扣除现金余额
 	function del_cash($cut_money,$depart_id){
 		$sql = 'UPDATE b_depart SET cash_limit=cash_limit-'.$cut_money.' WHERE id='.$depart_id;
 		$status  =$this->db->query($sql);
 		return $status;
 	}
 	//增加现金余额
 	function add_cash($cut_money,$depart_id){
 		$sql = 'UPDATE b_depart SET cash_limit=cash_limit+'.$cut_money.' WHERE id='.$depart_id;
 		$status  =$this->db->query($sql);
 		return $status;
 	}
 	
 	//营业信用额度
 	function del_credit($cut_money,$depart_id){
 		$sql = 'UPDATE b_depart SET credit_limit=credit_limit-'.$cut_money.' WHERE id='.$depart_id;
 		$status  = $this->db->query($sql);
 		return $status;
 	}
 	//增加信用额度
 	function add_credit($cut_money,$depart_id){
 		$sql = 'UPDATE b_depart SET credit_limit=credit_limit+'.$cut_money.' WHERE id='.$depart_id;
 		$status  = $this->db->query($sql);
 		return $status;
 	}
}