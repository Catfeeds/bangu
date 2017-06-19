<?php
/**
* @copyright	深圳帮游网络科技有限公司
* @version		1.0
* @since		2017年4月15日
* @author		zyf
* @method 		优惠券
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Coupon_Record extends UA_Controller {
	const pagesize = 10;
	
	public function __construct() {
		parent::__construct ();
	}
	public function index(){
		$this->load_view ( 'admin/a/coupon_manage/coupon_record');
	}
	//优惠券列表
	public function coupon_list() {
		$postArr = $this->security->xss_clean($_POST);
		$where='';
		if (!empty($postArr['name'])){
			$where.=" m.nickname='".trim($postArr['name'])."' and";
		}
		if (!empty($postArr['mobile'])){
			$where.=" m.mobile='".$postArr['mobile']."' and";
		}
		if (!empty($postArr['code'])){
			$where.=" u.code='".trim($postArr['code'])."' and";
		}
		if (!empty($postArr['status'])){
			if (!in_array($postArr['status'], array(2,3,5))){
				$this->__errormsg("状态出错");
			}
			if ($postArr['status']==2 || $postArr['status']==3){
				$where.=" u.c_status='".trim($postArr['status'])."' and";
			}
			if ($postArr['status'] ==5){
				$where.=" u.c_status in('2','3') and";
			}
		}else{
			$this->__errormsg("参数缺失");
		}
		$string=' where c.c_type<>6 ';
		$where= empty($where) ? $string : $string.' and '.rtrim($where ,'and');
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql="select  u.id,u.param,u.use_time,u.type,u.code,u.take_time,m.nickname,m.mobile,c.c_value_time,c.price,c.number from u_coupon_record as u 
				left join u_member as m on u.mid=m.mid 
				left join u_coupon as c on c.id=u.param 
				".$where ."
				group by u.id ORDER BY u.use_time DESC ";
		$sqls=$sql.$str;
		$coupon_data=$this->db->query($sqls)->result_array();
		if (!empty($coupon_data)){
			foreach ($coupon_data as $key=>$val){
				switch ($val['type']){
					case '1':
						$val['use_range']="全网";
						 break;
					case '2':
					 	$val['use_range']="类目";
					 	break;
				 	case '3':
				 		$supplier_data=$this->db->query("select u.brand from u_coupon_record as c left join u_supplier as u on c.param_val=u.id where c.type=3 and c.id={$val['id']}")->row_array();
				 		if (!empty($supplier_data)){
				 			$val['use_range']=$supplier_data['brand'];
				 		}else{
				 			$val['use_range']="供应商";
				 		}
				 		break;
			 		case '4':
			 			$val['use_range']="产品";
			 			break;
		 			case '5':
		 				$val['use_range']="注册";
		 				break;
		 			default:
		 				$val['use_range']="";
		 				break;
				}
				$val['c_value_time']=date('Y-m-d',$val['c_value_time']);
				if (!empty($val['use_time'])){
					$val['use_time']=date('Y-m-d',$val['use_time']);
				}
				if (!empty($val['take_time'])){
					$val['take_time']=date('Y-m-d H:i:s',$val['take_time']);
				}
				$coupon_data[$key]=$val;
			}
			
			$query = $this->db->query("SELECT COUNT(*) AS num FROM (".$sql.") va");
			$result = $query->result();
			$totalRecords = $result[0]->num;
			$data['coupon_data']=$coupon_data;
			$data['pagedata']['page']=$page;
			$data['pagedata']['pageSize']=$pageSize;
			$data['pagedata']['count']=$totalRecords;
		}else{
			$data=$coupon_data;
		}
		$this->__data($data);
	}
	
	//通过优惠劵id取订单id
	public function get_order_id(){
		$id = intval($this ->input ->post('id',true));//优惠劵id
		if (empty($id)) $this->__errormsg("id不能为空");
		$data=$this->db->query("select id from u_member_order where coupon_id={$id}")->row_array();
		$this->__data($data);
	}
	
	//查看供应商
	public function get_supplier(){
		$id = intval($this ->input ->post('id',true));//优惠劵id
		if (empty($id)) $this->__errormsg("id不能为空");
		$data=$this->db->query("select u.brand from u_coupon_record as c left join u_supplier as u on c.param_val=u.id where c.type=3 and c.id={$id}")->row_array();
		$this->__data($data);
	}
	
	
	//分页 搜索
	public function get_ajax_data() {
		$type = intval($this ->input ->post('type'));
		$time = $this ->input ->post('starttime' ,true);
		$status = intval($this ->input ->post('status'));
		$page_new = intval($this ->input ->post('page_new'));
		
		$whereArr = array();
		switch($status) {
			case 1:
				//有效
				$whereArr ['status'] = 1;
				break;
			case -1:
				//拒绝
				$whereArr ['status'] = -1;
				break;
			default:
				$whereArr ['status'] = 1;
				break;
		}
		if (!empty($type)) {
			switch($type) {
				case 2:
					//商家
					$whereArr ['coupon_type'] = 2;
					break;
				case 3:
					//平台
					$whereArr ['coupon_type'] = 3;
					break;
			}
		}
		if (!empty($time)) {
			$time = explode('-' ,$time);
			$starttime = $time['0'].'-'.rtrim($time['2']).'-'.$time['1'];
			$endtime = ltrim($time['3']).'-'.$time['5'].'-'.$time['4'];
			
			$whereArr ['starttime >'] = $starttime.' 00:00:00';
			$whereArr ['starttime <'] = $endtime.' 23:59:59';
		}
		//var_dump($whereArr);
		//获取数据
		$list = $this ->coupon_model ->get_coupon_data($whereArr ,$page_new ,self::pagesize );
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		$list = $this ->handle_array($list);
		
		$data = array(
				'list' =>$list,
				'page_string' =>$page_string
		);
		
		echo json_encode($data);
	}
	
	/**
	 * @method 对获得的数组进行处理
	 * @since  2015-06-23
	 * @author 贾开荣
	 * @param  array $data 要处理的数组
	 */
	public function handle_array($data) {
		foreach ( $data as $key => $val ) {
			switch($val['use_range']) {
				case 1:
					$data [$key]['use_range_name'] = '线路';
					break;
				case 2:
					$data [$key]['use_range_name'] = '商家';
					break;		
				case 3:
					$data [$key]['use_range_name'] = '区域';
					break;	
				case 4:
					$data [$key]['use_range_name'] = '全网';
					break;
			}
			switch($val['coupon_type']) {
				case 2:
					//商家
					$data [$key]['type'] = "商家";
					//查询其管理者
					$this->load->model ( 'admin/a/supplier_model', 'supplier_model' );
					$supplier_info = $this ->supplier_model->row(array('id' =>$val['userid']));
					$data [$key]['username'] = $supplier_info['company_name'];
					break;
				case 3:
					//平台
					$data [$key]['type'] = "平台";
					//查询其管理者
					$this->load->model ( 'admin/a/admin_model', 'admin_model' );
					$admin_info = $this ->admin_model->row(array('id' =>$val['userid']));
					$data [$key]['username'] = $admin_info['username'];
					break;
			}
		}
		return $data;
	}
	//截取字符串
	public function substr_name($name ,$length) {
		if (empty($name)) {
			return '';
		}
		if (mb_strlen($name) > $length) {
			return mb_substr($name , 0, $length).'...';
		} else {
			return $name;
		}
	}
	

}