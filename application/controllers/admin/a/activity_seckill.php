<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2016年01月30日14:22:35
 * @author		wangxiaofeng
 * @method 		深窗文章标签配置
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Activity_seckill extends UA_Controller {
	public $controllerName = '秒杀商品管理';
	public function __construct() {
		parent::__construct ();
	}

	function index(){

		$this->load_view ( 'admin/a/activity_seckill/activity_seckill_index');
	}

	public function getDataList() {
		$whereArr = array();
		$goods_name = $this ->input ->get_post('goods_name');		
		$status = $this ->input ->get_post('status');
		
		$page = intval($this ->input ->get_post('page'));
        $page = empty($page) ? 1 : $page;	
        $page_size = intval($this ->input ->get_post('pageSize'));;  //每页显示记录数
		if(empty($page_size))$page_size=10;
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";		
		
		//获取数据
		$whereStr = ' where 1 ';
		if($goods_name){
			$whereStr .= ' and seckill_goods_name like "%'.$goods_name.'%" ';
		}
		if($status==1){//上架
			$whereStr .= ' and seckill_goods_state=1 ';
		}else if($status==2){
			$whereStr .= ' and seckill_goods_state=0 ';
		}
		$data = array();
		$query_sql2=" select count(seckill_goods_id) as total from activity_seckill_goods  ".$whereStr;		
		$query_sql1=" select * from activity_seckill_goods  ".$whereStr." ORDER BY  seckill_goods_id desc {$sql_page}";
		$t = $this ->db ->query($query_sql2) ->row_array();
		$data['count'] = $t['total'];				
		$result = $this ->db ->query($query_sql1) ->result_array();	

		if(!empty($result)){
			foreach($result as $k=> $v){
				$result[$k]['seckill_goods_image'] = trim(base_url(''),'/').$result[$k]['seckill_goods_image'];
				$result[$k]['start_time'] = date("Y-m-d H:i:s",$result[$k]['start_time']);
				$result[$k]['end_time'] = date("Y-m-d H:i:s",$result[$k]['end_time']);				
				$result[$k]['exchange_end_time'] = date("Y-m-d H:i:s",$result[$k]['exchange_end_time']);
			}
		}
		
		$data['data']= $result;				
		echo json_encode($data);
	}
	//订单列表
	public function orderindex(){

		$this->load_view ( 'admin/a/activity_seckill/activity_seckill_order_index');
	}
	//订单数据
	public function getOrderDataList() {
		$whereArr = array();
		$goods_name = $this ->input ->get_post('goods_name');
		$ordersn = $this ->input ->get_post('ordersn');
		$paysn = $this ->input ->get_post('paysn');
		$buyername = $this ->input ->get_post('buyername');
		$payment =intval($this ->input ->get_post('payment'));//订单状态10未付款20已付款40未兑换30已兑换
		$page = intval($this ->input ->post('page'));
        $page = empty($page) ? 1 : $page;	
        $page_size = intval($this ->input ->get_post('pageSize'));;  //每页显示记录数
		if(empty($page_size))$page_size=10;
        $from = ($page - 1) * $page_size; //from
        $sql_page = " LIMIT {$from},{$page_size}";		
		
		//获取数据
		$whereStr = ' where 1 ';
		if($goods_name){
			$whereStr .= ' and seckill_goods_name like "%'.$goods_name.'%" ';
		}
		if($ordersn){
			$whereStr .= ' and order_sn like "%'.$ordersn.'%" ';
		}
		if($paysn){
			$whereStr .= ' and pay_sn like "%'.$paysn.'%" ';
		}
		if($buyername){
			$whereStr .= ' and buyer_name like "%'.$buyername.'%" ';
		}
		if (!empty($payment)){
			if($payment=="40"){
				$whereStr .= ' and order_state in(10,20) ';
			}else{
				$whereStr .= ' and order_state='.$payment;
			}
		}
		
		$data = array();
		$query_sql2=" select count(order_id) as total from activity_seckill_order  ".$whereStr;		
		$query_sql1=" select * from activity_seckill_order  ".$whereStr." ORDER BY  order_id desc {$sql_page}";
		$t = $this ->db ->query($query_sql2) ->row_array();
		$data['count'] = $t['total'];				
		$result = $this ->db ->query($query_sql1) ->result_array();	

		if(!empty($result)){
			foreach($result as $k=> $v){
				$result[$k]['seckill_goods_image'] = trim(base_url(''),'/').$result[$k]['seckill_goods_image'];
				$result[$k]['seckill_goods_start_time'] = date("Y-m-d H:i:s",$result[$k]['seckill_goods_start_time']);
				$result[$k]['seckill_goods_end_time'] = date("Y-m-d H:i:s",$result[$k]['seckill_goods_end_time']);				
				$result[$k]['seckill_goods_exchange_end_time'] = date("Y-m-d H:i:s",$result[$k]['seckill_goods_exchange_end_time']);
				$result[$k]['add_time'] = date("Y-m-d H:i:s",$result[$k]['add_time']);
				$result[$k]['payment_time'] = date("Y-m-d H:i:s",$result[$k]['payment_time']);
			}
		}


		
		$data['data']= $result;				
		echo json_encode($data);
	}	
	
	
	//增加
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['seckill_goods_name'])) {
			$this->callback->set_code ( 4000 ,"商品名称不能为空");
			$this->callback->exit_json();
		}		
		if (empty($postArr['seckill_goods_price']) || $postArr['seckill_goods_price']<0.01 ) {
			$this->callback->set_code ( 4000 ,"原始价格不能为空");
			$this->callback->exit_json();
		}		
		if (empty($postArr['seckill_price']) || $postArr['seckill_price']<0.01) {
			$this->callback->set_code ( 4000 ,"秒杀价格不能为空");
			$this->callback->exit_json();
		}
		if ( $postArr['seckill_price'] >= $postArr['seckill_goods_price'] ) {
			$this->callback->set_code ( 4000 ,"秒杀价格必须低于原始价格");
			$this->callback->exit_json();
		}		
		
		if (empty($postArr['seckill_goods_storage'])) {
			$this->callback->set_code ( 4000 ,"商品库存不能为空");
			$this->callback->exit_json();
		}	
		
		if (empty($postArr['seckill_goods_line_id'])) {
			$this->callback->set_code ( 4000 ,"请填写相关线路id");
			$this->callback->exit_json();
		}
		
		if (empty($postArr['pic'])) {
			$this->callback->set_code ( 4000 ,"封面图不能为空");
			$this->callback->exit_json();
		}
		
		if (empty($postArr['starttime'])) {
			$this->callback->set_code ( 4000 ,"秒杀时间不能为空");
			$this->callback->exit_json();
		}
		if (strtotime( date('Y-m-d H:i:s', strtotime($postArr['starttime'])) ) !== strtotime( $postArr['starttime'] )) {
			$this->callback->set_code ( 4000 ,"秒杀时间格式错误");
			$this->callback->exit_json();
		}	

		if (empty($postArr['endtime'])) {
			$this->callback->set_code ( 4000 ,"秒杀结束时间不能为空");
			$this->callback->exit_json();
		}
		if (strtotime( date('Y-m-d H:i:s', strtotime($postArr['endtime'])) ) !== strtotime( $postArr['endtime'] )) {
			$this->callback->set_code ( 4000 ,"秒杀结束时间格式错误");
			$this->callback->exit_json();
		}
		
		if (strtotime($postArr['starttime'])>strtotime($postArr['endtime'])) {
			$this->callback->set_code ( 4000 ,"秒杀结束时间不能小于开始时间");
			$this->callback->exit_json();
		}		
		
		if (empty($postArr['exchangeendtime'])) {
			$this->callback->set_code ( 4000 ,"兑换时间不能为空");
			$this->callback->exit_json();
		}	
		
		if (strtotime( date('Y-m-d H:i:s', strtotime($postArr['exchangeendtime'])) ) !== strtotime( $postArr['exchangeendtime'] )) {
			$this->callback->set_code ( 4000 ,"兑换时间格式错误");
			$this->callback->exit_json();
		}
		
		if (strtotime($postArr['starttime'])>strtotime($postArr['exchangeendtime'])) {
			$this->callback->set_code ( 4000 ,"兑换时间不能小于开始时间");
			$this->callback->exit_json();
		}

		if(!empty($postArr['seckill_goods_line_id'])){			
			$sql= "SELECT a.id FROM	u_line as a WHERE a.id =".$postArr['seckill_goods_line_id']." ";
			$data_line=$this->db->query($sql)->row_array();
			if(empty($data_line)){
				$this->callback->set_code ( 4000 ,"该线路id不存在!");
				$this->callback->exit_json();				
			}
		}

		
		$data = array(
			'seckill_goods_name' =>$postArr['seckill_goods_name'],
			'seckill_goods_price' =>$postArr['seckill_goods_price'],
			'seckill_price' =>$postArr['seckill_price'],
			'seckill_goods_storage' =>$postArr['seckill_goods_storage'],
			'seckill_goods_vrstorage' =>$postArr['seckill_goods_vrstorage'],			
			'seckill_rob_storage' =>$postArr['seckill_goods_storage'],
			'seckill_goods_line_id' =>$postArr['seckill_goods_line_id'],
			'seckill_goods_image' =>$postArr['pic'],			
			'start_time' =>strtotime($postArr['starttime']),
			'end_time' =>strtotime($postArr['endtime']),			
			'exchange_end_time' =>strtotime($postArr['exchangeendtime']),	
			'seckill_goods_state' =>$postArr['state'],	
                        'init_storage'=>$postArr['seckill_goods_storage'],  // 魏勇添加,初始库存
		);		
		$status = $this->db->insert('activity_seckill_goods', $data);
		$goods_id = $this->db->insert_id();
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"添加失败");
			$this->callback->exit_json();
		} else {
			$pics = '';
			for($i=1;$i<=5;$i++){
				if($postArr['pic'.$i] && $postArr['pic_del'.$i]==0){
					$pics .= $postArr['pic'.$i].',';
				}
			}
			$data1 = array(
				'seckill_goods_id' =>$goods_id,			
				'seckill_goods_images' =>$pics,
				'mobile_body' => strip_tags($postArr['goods_content']),
				'seckill_guizhe' => strip_tags($postArr['seckill_guizhe']),
				'seckill_duishuo' => strip_tags($postArr['seckill_duishuo']),				
			);			
			$status1 = $this->db->insert('activity_seckill_goods_content', $data1);
			
			
			$this->callback->set_code ( 2000 ,"添加成功");
			$this->callback->exit_json();
		}
	}
	//编辑
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['goods_id'])) {
			$this->callback->set_code ( 4000 ,"缺少编辑的数据");
			$this->callback->exit_json();
		}
		
		if (empty($postArr['seckill_goods_name'])) {
			$this->callback->set_code ( 4000 ,"商品名称不能为空");
			$this->callback->exit_json();
		}		
		if (empty($postArr['seckill_goods_price']) || $postArr['seckill_goods_price']<0.01 ) {
			$this->callback->set_code ( 4000 ,"原始价格不能为空");
			$this->callback->exit_json();
		}		
		if (empty($postArr['seckill_price']) || $postArr['seckill_price']<0.01) {
			$this->callback->set_code ( 4000 ,"秒杀价格不能为空");
			$this->callback->exit_json();
		}
		if ( $postArr['seckill_price'] >= $postArr['seckill_goods_price'] ) {
			$this->callback->set_code ( 4000 ,"秒杀价格必须低于原始价格");
			$this->callback->exit_json();
		}		
		if (empty($postArr['seckill_goods_storage'])) {
			$this->callback->set_code ( 4000 ,"商品库存不能为空");
			$this->callback->exit_json();
		}	
		
		if (empty($postArr['seckill_goods_line_id'])) {
			$this->callback->set_code ( 4000 ,"请填写相关线路id");
			$this->callback->exit_json();
		}
		
		if (empty($postArr['pic'])) {
			$this->callback->set_code ( 4000 ,"封面图不能为空");
			$this->callback->exit_json();
		}
		if (empty($postArr['starttime'])) {
			$this->callback->set_code ( 4000 ,"秒杀时间不能为空");
			$this->callback->exit_json();
		}
		if (strtotime( date('Y-m-d H:i:s', strtotime($postArr['starttime'])) ) !== strtotime( $postArr['starttime'] )) {
			$this->callback->set_code ( 4000 ,"秒杀时间格式错误");
			$this->callback->exit_json();
		}		
		
		if (empty($postArr['endtime'])) {
			$this->callback->set_code ( 4000 ,"秒杀结束时间不能为空");
			$this->callback->exit_json();
		}
		if (strtotime( date('Y-m-d H:i:s', strtotime($postArr['endtime'])) ) !== strtotime( $postArr['endtime'] )) {
			$this->callback->set_code ( 4000 ,"秒杀结束时间格式错误");
			$this->callback->exit_json();
		}
		
		if (strtotime($postArr['starttime'])>strtotime($postArr['endtime'])) {
			$this->callback->set_code ( 4000 ,"秒杀结束时间不能小于开始时间");
			$this->callback->exit_json();
		}			
		
		if (empty($postArr['exchangeendtime'])) {
			$this->callback->set_code ( 4000 ,"兑换时间不能为空");
			$this->callback->exit_json();
		}	
		
		if (strtotime( date('Y-m-d H:i:s', strtotime($postArr['exchangeendtime'])) ) !== strtotime( $postArr['exchangeendtime'] )) {
			$this->callback->set_code ( 4000 ,"兑换时间格式错误");
			$this->callback->exit_json();
		}			

		if (strtotime($postArr['starttime'])>strtotime($postArr['exchangeendtime'])) {
			$this->callback->set_code ( 4000 ,"兑换时间不能小于开始时间");
			$this->callback->exit_json();
		}	
		if(!empty($postArr['seckill_goods_line_id'])){			
			$sql= "SELECT a.id FROM	u_line as a WHERE a.id =".$postArr['seckill_goods_line_id']." ";
			$data_line=$this->db->query($sql)->row_array();
			if(empty($data_line)){
				$this->callback->set_code ( 4000 ,"该线路id不存在!");
				$this->callback->exit_json();				
			}
		}
		
		$data = array(
			'seckill_goods_name' =>$postArr['seckill_goods_name'],
			'seckill_goods_price' =>$postArr['seckill_goods_price'],
			'seckill_price' =>$postArr['seckill_price'],
			'seckill_goods_storage' =>$postArr['seckill_goods_storage'],
			'seckill_goods_vrstorage' =>$postArr['seckill_goods_vrstorage'],			
			'seckill_rob_storage' =>$postArr['seckill_goods_storage'],
			'seckill_goods_line_id' =>$postArr['seckill_goods_line_id'],			
			'seckill_goods_image' =>$postArr['pic'],			
			'start_time' =>strtotime($postArr['starttime']),
			'end_time' =>strtotime($postArr['endtime']),			
			'exchange_end_time' =>strtotime($postArr['exchangeendtime']),	
			'seckill_goods_state' =>$postArr['state'],	
                        'init_storage'=>$postArr['seckill_goods_storage'],  // 魏勇添加,初始库存
		);		
		$status = $this->db->update('activity_seckill_goods', $data, array('seckill_goods_id' => intval($postArr['goods_id'])));

		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"编辑失败");
			$this->callback->exit_json();
		} else {
			$pics = '';
			for($i=1;$i<=5;$i++){
				if($postArr['pic'.$i] && $postArr['pic_del'.$i]==0){
					$pics .= $postArr['pic'.$i].',';
				}
			}
			$data1 = array(			
				'seckill_goods_images' =>$pics,
				'mobile_body' => strip_tags($postArr['goods_content']),
				'seckill_guizhe' => strip_tags($postArr['seckill_guizhe']),
				'seckill_duishuo' => strip_tags($postArr['seckill_duishuo']),				
			);
			$this->db->update('activity_seckill_goods_content', $data1, array('seckill_goods_id' => intval($postArr['goods_id'])));
						
			
			$this->callback->set_code ( 2000 ,"编辑成功");
			$this->callback->exit_json();
		}
	}



	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->get_post('id'));
		$sql = 'SELECT * FROM activity_seckill_goods WHERE seckill_goods_id= '.$id;
		$goods_info =  $this->db->query($sql )->row_array();

		$sql = 'SELECT * FROM activity_seckill_goods_content WHERE seckill_goods_id= '.$id;
		$content_info =  $this->db->query($sql )->row_array();

		$data = array(
			'seckill_goods_id' =>$goods_info['seckill_goods_id'],
			'seckill_goods_name' =>$goods_info['seckill_goods_name'],
			'seckill_goods_price' =>$goods_info['seckill_goods_price'],
			'seckill_price' =>$goods_info['seckill_price'],
			'seckill_goods_storage' =>$goods_info['seckill_goods_storage'],
			'seckill_goods_vrstorage' =>$goods_info['seckill_goods_vrstorage'],
			'seckill_goods_line_id' =>$goods_info['seckill_goods_line_id'],
			'pic' =>$goods_info['seckill_goods_image'],			
			'starttime' =>date("Y-m-d H:i:s",$goods_info['start_time']),
			'endtime' =>date("Y-m-d H:i:s",$goods_info['end_time']),			
			'exchangeendtime' =>date("Y-m-d H:i:s",$goods_info['exchange_end_time']),	
			'state' =>$goods_info['seckill_goods_state'],
			'goods_content' => $content_info['mobile_body'],
			'seckill_guizhe' => $content_info['seckill_guizhe'],
			'seckill_duishuo' => $content_info['seckill_duishuo'],			
		);
		$pics = explode(",",$content_info['seckill_goods_images']);
		for($i=1;$i<=5;$i++){
			$t = $i-1;
			if(isset($pics[$t])){
				$data['pic'.$i] = $pics[$t];
			}else{
				$data['pic'.$i] = '';
			}
		}

		echo json_encode($data);
	}

	public function duihuan() {
		$postArr = $this->security->xss_clean($_POST);
		if (empty($postArr['order_id'])) {
			$this->callback->set_code ( 4000 ,"参数错误");
			$this->callback->exit_json();
		}
		$data = array(	
			'order_state' =>30,	
		);		
		$status = $this->db->update('activity_seckill_order', $data, array('order_id' => intval($postArr['order_id'])));
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"兑换失败");
			$this->callback->exit_json();
		} else {
			$this->callback->set_code ( 2000 ,"兑换成功");
			$this->callback->exit_json();
		}
	}

}