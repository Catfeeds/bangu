<?php
/**
* @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月23日09:28
* @author		jiakairong
* @method 		优惠券
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Coupon extends UA_Controller {
	const pagesize = 10;
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/coupon_model', 'coupon_model' );
	}
	
	//优惠券列表
	public function coupon_list() {
		$whereArr = array();
		$status = intval($this ->input ->get('status'));
		$page_new = intval($this ->input ->get('page'));
		$page_new = empty($page_new) ? 1 : $page_new;
		
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
		//获取数据
		$list = $this ->coupon_model ->get_coupon_data($whereArr ,$page_new ,self::pagesize );
		$count = $this->getCountNumber($this->db->last_query());
		$page_string = $this ->getAjaxPage($page_new ,$count);
		$list = $this ->handle_array($list);
		
		$data = array(
			'list' =>$list,
			'page_string' =>$page_string,
			'status' =>$whereArr['status']
		);
		
		$this ->load_view('admin/a/ui/coupon/coupon_list' ,$data);
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
	//添加优惠券
	public function add_coupon() {
		$this->load->library ( 'callback' );
		
		$number = intval($this ->input ->post('number')); //总量
		$time = $this ->input ->post('time' ,true); //时间
		$pic = $this ->input ->post('pic' ,true); //图片
		$min_price = intval($this ->input ->post('min_price' ,true)); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->post('coupon_price' ,true); //优惠额
		$use_range = intval($this ->input ->post('use_range')); //使用范围
		$admin_id = $this->session->userdata('a_user_id');
		
		$new_day = date('Y-m-d' ,time()).' 23:59:59';
		if (empty($time)) {
			$this->callback->set_code ( 4000 ,"请填填写时间");
			$this->callback->exit_json();
		} else {
			$time = explode('-' ,$time);
			$starttime = $time['0'].'-'.rtrim($time['2']).'-'.$time['1'];
			$endtime = ltrim($time['3']).'-'.$time['5'].'-'.$time['4'];
			if (empty($starttime) || empty($endtime)) {
				$this->callback->set_code ( 4000 ,"请将日期填写完整");
				$this->callback->exit_json();
			} elseif ($endtime <= $starttime) {
				$this->callback->set_code ( 4000 ,"结束日期要大于开始日期");
				$this->callback->exit_json();
			} elseif ($endtime <= $new_day) {
				$this->callback->set_code ( 4000 ,"结束日期要在今天之后");
				$this->callback->exit_json();
			}
		}
		if ($number < 1) {
			$this->callback->set_code ( 4000 ,"请填写数量");
			$this->callback->exit_json();
		}
		if (empty($coupon_price)) {
			$this->callback->set_code ( 4000 ,"请填写优惠额");
			$this->callback->exit_json();
		}
		if ($min_price == 0 ) {
			$name = '减'.$coupon_price;
		} else {
			$name = "满{$min_price}减{$coupon_price}";
		}
		//生成二维码
		$this->load->library('ciqrcode');
		$params['data'] = 'coupon';
		$params['level'] = 'H';
		$params['size'] = 10;
		$params['savename'] = "./file/qrcodes/coupon_".time().".png";
		$this->ciqrcode->generate($params);
		
	
		$data = array(
			'coupon_type' =>3,
			'userid' =>$admin_id,
			'status' =>1,
			'name' =>$name,
			'pic' =>$pic,
			'starttime' =>$starttime,
			'endtime' =>$endtime,
			'number' =>$number,
			'use_range' =>$use_range,
			'min_price' =>$min_price,
			'coupon_price' =>$coupon_price,
			'addtime' =>date('Y-m-d H:i:s' ,time()),
			'qrcode' =>ltrim($params['savename'] ,'.')
		);	
		
		$status = $this ->db ->insert('cou_coupon' ,$data);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		} else {
			$id =  $this ->db ->insert_id();
			$this ->log(1,3,'优惠券管理',"添加优惠券，ID：{$id}");
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}
		
	}
	//编辑优惠券
	public function edit_coupon() {
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('id'));
		$number = intval($this ->input ->post('number')); //总量
		$time = $this ->input ->post('time' ,true); //时间
		$pic = $this ->input ->post('pic' ,true); //图片
		
		if (empty($time)) {
			$this->callback->set_code ( 4000 ,"请填填写时间");
			$this->callback->exit_json();
		} else {
			$time = explode('-' ,$time);
			$starttime = $time['0'].'-'.rtrim($time['2']).'-'.$time['1'];
			$endtime = ltrim($time['3']).'-'.$time['5'].'-'.$time['4'];
			if (empty($starttime) || empty($endtime)) {
				$this->callback->set_code ( 4000 ,"请将日期填写完整");
				$this->callback->exit_json();
			} elseif ($endtime <= $starttime) {
				$this->callback->set_code ( 4000 ,"结束日期要大于开始日期");
				$this->callback->exit_json();
			}
		}
		$data = array(
			'number' => $number,
			'pic' =>$pic,
			'starttime' =>$starttime,
			'endtime' =>$endtime
		);
		$this ->db ->where(array('id' =>$id));
		$status = $this ->db ->update('cou_coupon' ,$data);
		if (empty($status)) {
			$this->callback->set_code ( 4000 ,"操作失败");
			$this->callback->exit_json();
		} else {
			$id =  $this ->db ->insert_id();
			$this ->log(3,3,'优惠券管理',"编辑优惠券，ID：{$id}");
			$this->callback->set_code ( 2000 ,"操作成功");
			$this->callback->exit_json();
		}
	}
	
	//获取一条数据
	public function get_one_json() {
		$id = intval($this ->input ->post('id'));
		$whereArr = array('id' =>$id);
		$data = $this ->coupon_model ->get_coupon_data($whereArr ,1 ,1 );
		if (empty($data)) {
			echo false;
		} else {
			$starttime = date('Y-d-m',strtotime($data[0]['starttime']));
			$endtime = date('Y-d-m',strtotime($data[0]['endtime']));
			$time = $starttime.' - '.$endtime;
			$data[0]['time'] = $time;
			echo json_encode($data[0]);
		}
	}
	/**
	 * @method 优惠卷配置列表
	 * @author xml
	 */
	public function get_member_coupon(){
		//优惠卷
		$data['coupon']=$this->coupon_model->get_coupon_alldata();
	
		$data['pageData']=$this->coupon_model->member_coupon(null,$this->getPage ());
		$this->load_view ( 'admin/a/ui/coupon/member_coupon',$data);
	}
	public function  couponData(){
		$param = $this->getParam(array('coupon_name','member_name'));
		$data=$this->coupon_model->member_coupon($param,$this->getPage ());
		echo $data;
	}
	//获取会员
	public function get_member_data () {

		$this ->load_model('admin/a/member_model' ,'member_model');
		$startplace = $this ->member_model ->all(array(),'mid asc');
		//	cache_set('startplace' ,$startplace);
		//	}
		echo json_encode($startplace);
	}
	//添加会员优惠券
	public function add_mcoupon(){
		$memberid=$this->input->post('memberid');
		$sel_memberid=$this->input->post('sel_memberid');
		$coupon=$this->input->post('coupon');
		$coupon_id=$this->input->post('coupon_id');
	 	if(empty($memberid)){
	 		echo json_encode(array('status'=>-1,'msg'=>'请选择会员手机'));
	 		exit;
		} 
		$id=$this->coupon_model->insert_mcoupon($coupon_id,$coupon,$memberid);
	 	if($id){
			echo json_encode(array('status'=>1,'msg'=>'添加成功'));
		}else{
			echo json_encode(array('status'=>-1,'msg'=>'添加失败'));
		} 
	}

}