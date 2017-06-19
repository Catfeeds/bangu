<?php
/**
 * 交款管理
 *
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年7月28日15:05:11
 * @author		汪晓烽
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once './application/controllers/msg/t33_send_msg.php';
class Credit_approval extends UB2_Controller {
	public function __construct() {
		parent::__construct();
		$this->load_model('admin/b2/credit_approval_model', 'credit_approval');
		$this->load_model('admin/b2/order_manage_model', 'order_manage');
	}
	/*
	 * 管家信用额度申请页面
	 * */
	function index() 
	{
		$this ->load_model('expert_model');
		$is_manage = $this->session->userdata('is_manage');
		//查询营业部经理
		$whereArr = array('expert_type'=>1,'is_dm' =>1,'depart_id' =>$this->session->userdata('parent_depart_id'));
		$managerArr = $this ->expert_model ->row($whereArr);
		$this ->load_model('admin/t33/b_company_supplier_model' ,'company_supplier_model');
		$unionSupplier = $this ->company_supplier_model ->getUnionSupplierAll($this->session->userdata('union_id'));
		$expert_info = $this->expert_model->all('FIND_IN_SET(\''.$this->session->userdata('parent_depart_id').'\',depart_list)>0' );
		$data = array(
			'is_manage'=>$is_manage,
			'depart_id'=>$this->session->userdata('depart_id'),
			'real_name'=>$this->session->userdata('real_name'),
			'expert_id'=>$this->expert_id,
			'manager_name'=>isset($managerArr['realname'])&&!empty($managerArr['realname']) ? $managerArr['realname']: '',
			'manager_id'=>isset($managerArr['id'])&&!empty($managerArr['id']) ? $managerArr['id']: '',
			'depart_name'=>isset($managerArr['depart_name'])&&!empty($managerArr['depart_name']) ? $managerArr['depart_name']: '',
			'unionSupplier'=>$unionSupplier,
			'expert_info'=>$expert_info
			);
		$this->load_view('admin/b2/credit_approval_view',$data);
	}
	/*
	 * 额度申请列表：数据
	 * 
	 * */
	function ajax_credit_list(){
		$whereArr = array();
		$number = $this->input->post('pageSize', true);
       	$page = $this->input->post('pageNum', true);
        	$number = empty($number) ? 10 : $number;
        	$page = empty($page) ? 1 : $page;
        	$is_manage = $this->session->userdata('is_manage');

        	$order_sn = trim($this ->input ->post('order_sn' ,true));
       	$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$apply_status = trim($this ->input ->post('apply_status' ,true));
		$expert = trim($this ->input ->post('expert' ,true));
		$starttime2 = trim($this ->input ->post('starttime2' ,true));
		$endtime2 = trim($this ->input ->post('endtime2' ,true));
		$apply_sn = trim($this ->input ->post('apply_sn' ,true));

       	if($is_manage==1){
       		$whereArr['app.depart_id'] = $this->session->userdata('depart_id');
       	}else{
       		$whereArr['app.expert_id ='] = $this->expert_id;
       	}


       	if (!empty($order_sn)){
			$whereArr['md.ordersn like'] = '%'.$order_sn.'%';
		}

		if (!empty($apply_sn)){
			$whereArr['app.code like'] = '%'.$apply_sn.'%';
		}



		if (!empty($apply_status) || $apply_status==='0'){
			$whereArr['app.`status` ='] = $apply_status;
		}

		if (!empty($expert)){
			$whereArr['app.expert_id ='] = $expert;
		}

		if (!empty($starttime)){
			$whereArr['app.addtime >='] = $starttime;
		}

		if (!empty($endtime)){
			$whereArr['app.addtime <='] = $endtime.' 23:59:59';
		}

		if (!empty($starttime2)){
			$whereArr['app.return_time >='] = $starttime2;
		}

		if (!empty($endtime2)){
			$whereArr['app.return_time <='] = $endtime2.' 23:59:59';
		}

		$credit_list = $this->credit_approval->get_data_list($whereArr,$page,$number);
		$pagecount = $this->credit_approval->get_data_list($whereArr, 0,$number);
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
	               	"rows" => $credit_list
            		);
		echo json_encode($data);
	}
    /*
     * 新申请管家信用(废弃不用)
     * 
     * */
	function new_apply(){
		$arrData = $this->security->xss_clean($_POST);

		if (!preg_match("/^\d+(.\d+)?$/", $arrData['apply_amount'])) {
			echo json_encode(array('status'=>205,'msg'=>'申请额度必填正数'));
			exit();
		}

		if($arrData['apply_type']==2){
			if($arrData['apply_supplier']==='0'){
				echo json_encode(array('status'=>206,'msg'=>'申请对象的供应商必选'));
				exit();
			}
		}

		if(empty($arrData['apply_date'])){
			echo json_encode(array('status'=>207,'msg'=>'申请日期必填'));
			exit();
		}

		if(empty($arrData['return_date'])){
			echo json_encode(array('status'=>208,'msg'=>$arrData['return_date']));
			exit();
		}

		$res = $this->credit_approval->is_using_data($this->expert_id);
		if(!empty($res) ){
			echo json_encode(array('status'=>204,'msg'=>'你有一条未使用申请记录'));
			exit();
		}else{
			$res2 = $this->credit_approval->is_applying_data($this->expert_id);
			if(!empty($res2)){
				echo json_encode(array('status'=>204,'msg'=>'你有一条未使用申请记录'));
				exit();
			}
		}

		$insert_apply_data = array(
			'depart_id'			=>$this->session->userdata('depart_id'),
			'depart_name'		=>$arrData['depart_name'],
			'expert_id'			=>$this->expert_id,
			'expert_name'		=>$this->session->userdata('real_name'),
			'manager_id'		=>$arrData['manager_id'],
			'manager_name'	=>$arrData['manager_name'],
			'credit_limit'		=>$arrData['apply_amount'],
			'addtime'			=>$arrData['apply_date'],
			'modtime'			=>date('Y-m-d'),
			'return_time'		=>$arrData['return_date'],
			'code'				=>$arrData['pay_code'],
			'remark'			=>$arrData['apply_remark']
			);
		if($arrData['is_manage']==1){
			$insert_apply_data['status']=1;
			$insert_apply_data['m_addtime'] = date('Y-m-d H:i:s');
		}else{
			$insert_apply_data['status']=0;
		}
		if($arrData['apply_type']==2){
			$insert_apply_data['supplier_id']=$arrData['apply_supplier'];
		}else{
			$insert_apply_data['union_id']=$this->session->userdata('union_id');
		}
		$status = $this->db->insert('b_limit_apply',$insert_apply_data);
		if($status){
			echo json_encode(array('status'=>200,'msg'=>'提交成功,等待审核'));
			exit();
		}else{
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}
	}

    /*
     * 经理审批：销售申请的信用额度
     * */
	function manager_submit()
	{
		$arrData = $this->security->xss_clean($_POST);
		$arrData['approval_ids'] = rtrim($arrData['approval_ids'],',');
		if ($arrData['m_approval_status'] == 2 && empty($arrData['m_remark'])) {
			echo json_encode(array('status'=>201,'msg'=>'请填写备注'));
			exit();
		}

		$this->db->trans_begin();//开启事物
		$order_id_sql = 'SELECT GROUP_CONCAT(order_id) AS order_id_str FROM b_limit_apply WHERE id IN('.$arrData['approval_ids'].')';
		$order_id_res = $this ->db ->query($order_id_sql) ->row_array();
		if($arrData['m_approval_status'] == 1){
			//经理通过额度审批
			$sql = 'UPDATE b_limit_apply SET manager_name=\''.$this->session->userdata('real_name').'\',manager_id='.$this->expert_id.',status='.$arrData['m_approval_status'].', m_remark=\''.$arrData['m_remark'].'\',m_addtime=\''.date('Y-m-d H:i:s').'\' WHERE id in ('.$arrData['approval_ids'].')';
		}else{
			$sql = 'UPDATE b_limit_apply SET supplier_id=0,union_id=0,manager_name=\''.$this->session->userdata('real_name').'\',manager_id='.$this->expert_id.',status='.$arrData['m_approval_status'].', m_remark=\''.$arrData['m_remark'].'\',m_addtime=\''.date('Y-m-d H:i:s').'\' WHERE id in ('.$arrData['approval_ids'].')';
		}
		$status = $this->db->query($sql);
		//var_dump($arrData);exit;

		if ($arrData['m_approval_status'] == 1){
			//经理通过额度审批
			$order_sql = 'UPDATE u_member_order SET status = (CASE WHEN status=10 THEN 2  WHEN STATUS=11 THEN 3 END) WHERE id in('.$order_id_res['order_id_str'].')';
			$status = $this->db->query($order_sql);
		}else{
			//经理拒绝额度审批
			$order_sql = 'UPDATE u_member_order SET status = -6 WHERE id in('.$order_id_res['order_id_str'].')';
			$status = $this->db->query($order_sql);
			//拒绝额度申请的时候把, 扣除的额度还回去
			$order_id_arr = explode(',', $order_id_res['order_id_str']);
			$ids_count = count($order_id_arr);
			for($i=0; $i<$ids_count; $i++){
				$whereArr['order_id='] = $order_id_arr[$i];
				$whereArr['status!='] = '3,4,6';
				$whereArr['way='] = '账户余额';
				$sum_receive = $this->order_manage->get_sum_receive($whereArr);
				$order_info = $this->order_manage->get_one_order($order_id_arr[$i]);
				//退还营业部额度
				//$this->order_manage->return_cash($sum_receive['total_receive_amount'],$order_info['depart_id']);
				$debit_res = $this->credit_approval->get_debit_data(array("order_id="=>$order_id_arr[$i],"type="=>1));
		 		$debit_res2 = $this->credit_approval->get_debit_data(array("order_id="=>$order_id_arr[$i],"type="=>2));
		 		if(!empty($debit_res)){//还掉营业部现金额度
		 			$this->order_manage->return_cash($debit_res[0]['real_amount'],$order_info['depart_id']);
		 		}
		 		if(!empty($debit_res2)){//还掉营业部信用额度
		 			$this->order_manage->return_credit($debit_res2[0]['real_amount'],$order_info['depart_id']);
		 		}
				$write_limit_log = array(
	                        'refund_monry'=>$debit_res[0]['real_amount']+$debit_res2[0]['real_amount'],
	                        'type'=>'单团额度审批时被经理拒绝，退还已扣额度',
	                        'remark'=>'b2:单团额度审批时被经理拒绝，退还已扣营业部额度'
                        );
            			$this->order_manage->write_limit_log($order_id_arr[$i],$write_limit_log);
				//拒绝(作废)这一条交款;因为这笔钱退还给营业部了
	 			$refused_receive_sql = 'UPDATE  u_order_receivable SET status=4 WHERE status=0 AND order_id='.$order_id_arr[$i];
	 			$this->db->query($refused_receive_sql);
			}
		}
		
		//订单操作日志
		$limit_rows=$this->db->query("select * from b_limit_apply where id in (".$arrData['approval_ids'].")")->result_array();
		if(!empty($limit_rows))
		{
			foreach ($limit_rows as $k=>$v)
			{
				if($arrData['m_approval_status'] == 1)
					$log_content="通过".$v['credit_limit']."元管家信额度";
				else 
					$log_content="拒绝".$v['credit_limit']."元管家信额度";
				$this->order_manage->write_order_log($v['order_id'],'在额度申请页面，审核'.$log_content);
			}
		}
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'提交成功'));
			//发送消息jkr
			$msg = new T33_send_msg();
			$msgArr = $msg ->applyQuotaMsg($arrData['approval_ids'],2,$this->session->userdata('real_name'));
			exit();
		}
	}

	function ajax_one_data(){
		$whereArr = array();
		$arrData = $this->security->xss_clean($_POST);
		$res = $this->credit_approval->get_one_data(array('app.id='=>$arrData['id']));
		echo json_encode($res);
	}
    /*
     * 取消额度申请：废弃
     * */
	function ajax_cancle_apply(){
		$arrData 	= $this->security->xss_clean($_POST);
		$app_id 	= $arrData['apply_id'];
		$elp_id 	= $arrData['apply_use_id'];
		$this->db->trans_begin();//开启事物
		$update_app_data = array(
				'status'=>-1,
				'supplier_id'=>0,
				'union_id'=>0
			);
		$this->db->update('b_limit_apply',$update_app_data,array('id'=>$app_id));
		if(!empty($elp_id)){
			$this->db->update('b_expert_limit_apply',array('status'=>-1),array('id'=>$elp_id));
		}
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'提交失败'));
			exit();
		}else{
			$this->db->trans_commit();
			echo json_encode(array('status'=>200,'msg'=>'已提交,等待审核'));
			exit();
		}
	}
	/*
	 * 取消额度申请
	 * */
	function ajax_cancle_order_apply(){
		$arrData 	= $this->security->xss_clean($_POST);
		$order_id	= $arrData['order_id'];
		$expert_id 	= $arrData['expert_id'];
		$this->db->trans_begin();//开启事物
		
		$whereArr=array(
				'order_id='=>$order_id,
				'status!='=>'3,4,6',
				'way='=>'账户余额'
		);
		$sum_receive = $this->order_manage->get_sum_receive($whereArr);
		$order_info = $this->order_manage->get_one_order($order_id);
		$apply_limit = $this->credit_approval->get_one_data(array('app.order_id='=>$order_id,'app.status='=>1));
		
		if(empty($apply_limit)){
			echo json_encode(array('status'=>202,'msg'=>'额度申请记录已经被审核过'));
			exit();
		}
		$update_app_data = array(
			'status'=>-1,
			'supplier_id'=>0,
			'union_id'=>0
		);
		$this->db->update('b_limit_apply',$update_app_data,array('order_id'=>$order_id));
		if(!empty($expert_id)){
			$this->db->update('b_expert_limit_apply',array('status'=>-1),array('order_id'=>$order_id));
		}
		//订单状态
		$this->load_model('admin/b2/order_model', 'order');
		$this->order->update(array('status'=>'9'),array('id'=>$order_id)); //状态改为“未提交”
		//$this->order_manage->return_cash($sum_receive['total_receive_amount'],$order_info['depart_id']);

 		$debit_res = $this->credit_approval->get_debit_data(array("order_id="=>$order_id,"type="=>1));
 		$debit_res2 = $this->credit_approval->get_debit_data(array("order_id="=>$order_id,"type="=>2));
 		if(!empty($debit_res)){//还掉营业部现金额度
 			$this->order_manage->return_cash($debit_res[0]['real_amount'],$order_info['depart_id']);
 		}
 		if(!empty($debit_res2)){//还掉营业部信用额度
 			$this->order_manage->return_credit($debit_res2[0]['real_amount'],$order_info['depart_id']);
 		}
 		$write_limit_log = array(
			'refund_monry'=>$debit_res[0]['real_amount']+$debit_res2[0]['real_amount'],
			'type'=>'销售取消管家信用申请，退还已扣额度',
			'remark'=>'b2:销售取消管家信用申请，退还已扣额度'
		);
		$this->order_manage->write_limit_log($order_id,$write_limit_log);
 		//取消额度申请的时候, 把所有账户余额交款的拒绝
 		$refuse_receive_sql = 'UPDATE u_order_receivable SET status=4 WHERE order_id='.$order_id.' AND way=\'账户余额\'';
 		$this->db->query($refuse_receive_sql);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			echo json_encode(array('status'=>201,'msg'=>'操作失败'));
			exit();
		}else{
			$this->db->trans_commit();
			//发送消息jkr
			$msg = new T33_send_msg();
			$msgArr = $msg ->cancelQuotaApply($apply_limit[0]['id'],1,$this->session->userdata('real_name'));
			echo json_encode(array('status'=>200,'msg'=>"取消成功"));
			exit();
		}
	}
}