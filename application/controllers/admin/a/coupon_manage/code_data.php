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
class Code_Data extends UA_Controller {
	const pagesize = 10;
	
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/coupon_model', 'coupon_model' );
	}
	public function index(){
		$this->load_view ( 'admin/a/coupon_manage/code_data');
	}
	public function code_detail(){
		$id = intval($this ->input ->get_post('id')); //兑换码id
		$data = array(
				'id' =>$id,
		);
		$this->load_view ( 'admin/a/coupon_manage/code_detail',$data);
	}
	//兑换码列表
	public function coupon_list() {		
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql="select * from u_coupon where c_type=6 order by id desc ".$str;
		$coupon_data=$this->db->query($sql)->result_array();
		if (!empty($coupon_data)){
			foreach ($coupon_data as $key=>$val){
				$val['c_value_time']=date('Y-m-d',$val['c_value_time']);
				$coupon_data[$key]=$val;
			}
			$count = $this->getCountNumber($this->db->last_query());
			$data['coupon_data']=$coupon_data;
			$data['pagedata']['page']=$page;
			$data['pagedata']['pageSize']=$pageSize;
			$data['pagedata']['count']=$count;
		}else{
			$data=$coupon_data;
		}
		$this->__data($data);
	}
	
	//添加兑换码
	public function add_code() {
		$number = $this ->input ->get_post('number'); //张数
		$endtime = $this ->input ->get_post('time' ,true); //有效期
// 		$min_price = $this ->input ->get_post('min_price' ,true); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->get_post('coupon_price' ,true); //兑换额
		$decription = $this ->input ->get_post('decription' ,true);//说明
		$starttime=date('Y-m-d');
		if ($coupon_price==0) {
			$this->__errormsg("兑换码金额不能为0");
		}else if(empty($coupon_price)){
			$this->__errormsg("请填写兑换码金额");
		}else {
			if (!preg_match('/^\d*$/',$coupon_price)) $this->__errormsg("兑换码金额只能为整数数字");
			if ($coupon_price>500)  $this->__errormsg("兑换码金额不能超过500");
		}
		
		if ($number<1) {
			$this->__errormsg("兑换码张数不能小于1张");
		}else if(empty($number)){
			$this->__errormsg("请填写兑换码张数");
		}else {
			if (!preg_match('/^\d*$/',$number)) $this->__errormsg("兑换码张数只能为整数数字");
			if ($number>100000000)  $this->__errormsg("兑换码张数不能超过1亿张");
		}
		
		if (empty($endtime)) {
			$this->__errormsg("请填写有效期");
		}
		$is_date=strtotime($endtime)?strtotime($endtime):false;
		if($is_date===false){
			$this->__errormsg('日期格式非法');
		}
		if (date('Y-m-d',$is_date) <= $starttime) {
			$this->__errormsg("有效期不能小于当前日期");
		}
// 		if ($min_price==='') $this->__errormsg("请填写使用条件");
// 		if (empty($min_price) && $min_price !=0){
// 			$this->__errormsg("请填写使用条件");
// 		}else{
// 			if (!preg_match('/^\d*$/',$min_price)) $this->__errormsg("使用条件只能为整数数字");
// 		}
// 		if ($min_price!=0){
// 			if ($min_price < $coupon_price) $this->__errormsg("使用条件不能小于兑换金额");
// 			if ($min_price>1000000)  $this->__errormsg("使用条件不能超过百万");
// 		}
		if (!empty($decription)){
			$mb = mb_strlen($decription,'utf-8');
			if ($mb>30) $this->__errormsg("兑换码说明不能超过30个字符");
		}
		$data = array(
				'price' =>0,//最低使用条件  0代表没有
				'c_sum' =>$number,//张数
				'c_take' =>0,
				'c_use' =>0,
				'c_value_time' =>strtotime($endtime),//有效期
				'number' =>$coupon_price,//兑换额
				'c_description' =>$decription,
				'if_not' =>1,//是否已作废 1为未作废2为已作废
				'c_type'=>6 //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		);
		$time=time();
		$this->db->trans_begin();//事务开启
		$status = $this ->db ->insert('u_coupon' ,$data);
		$id=$this->db->insert_id();
		$insert_data=array(
				'mid'=>0,
				'take_time'=>0,
				'use_time'=>0,
				'c_status'=>1,//状态 1、为未发放 2、已发放3、已使用 4、已作废
				'type'=>6,//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
				'send_time'=>0,
				'set_time'=>$time,//生成时间
				'void_time'=>0,//作废时间
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'param'=>$id //关联的兑换码id
		);
		$str_code="A1";
		$datas=array();
		$n=ceil($number/50000);
		if ($n>1){
			$max="50000";
			for ($i=0;$i<$n;$i++){
				if ($i==0){
					for ($x=0; $x<50000; $x++) {
						$rand=$this->get_rand();//获取随机数
						$insert_data['code']=$str_code.$rand;//生成随机数
						array_push($datas, $insert_data);
					}
					$this->db->insert_batch('u_coupon_record', $datas);
					unset($datas);
					$datas=array();
				}else{
					if (($number-$max*$i)>=50000){
						$nums=50000;
					}else{
						$nums=$number-$max*$i;
					}
					for ($x=0; $x<$nums; $x++) {
						$rand=$this->get_rand();//获取随机数
						$insert_data['code']=$str_code.$rand;//生成随机数
						array_push($datas, $insert_data);
					}
					$this->db->insert_batch('u_coupon_record', $datas);
					unset($datas);
					$datas=array();
				}
		
			}
		}else{
			for ($x=0; $x<$number; $x++) {
				$rand=$this->get_rand();//获取随机数
				$insert_data['code']=$str_code.$rand;//生成随机数
				array_push($datas, $insert_data);
			}
			$this->db->insert_batch('u_coupon_record', $datas);
		}
// 		$this->db->insert_batch('u_coupon_record', $datas);
		$this->db->trans_complete(); //事务结束
		//事务
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			$this->__errormsg("操作失败");
		}else{
			$this->db->trans_commit();
			$this->__data("添加成功");
		}
	}
	//搜索兑换码
	public function search_code(){
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$id=intval($this ->input ->get_post('id' ,true));//兑换码id
		$member_name=$this ->input ->get_post('member_name' ,true);//会员名称
		$mobile=$this ->input ->get_post('mobile' ,true);//会员手机
		$status=$this ->input ->get_post('status' ,true);//状态 1、为未发放 2、已发放3、已使用 4、已作废 5、全部
		if (empty($id)) $this->__errormsg("id参数缺失");
		if (empty($status)) $this->__errormsg("参数缺失");
		if (!in_array($status, array(1,2,3,4,5))) $this->__errormsg("参数错误");
		$where='';
		if (!empty($member_name)){
			$where.=" m.nickname like'%".trim($member_name)."%' and";
		}
		if (!empty($mobile)){
			$where.=" m.mobile like'%".$mobile."%' and";
		}
		if (!empty($status)){
			if ($status!=1 && $status!=5 ){
				$where.=" c.c_status='".trim($status)."' and";
			}
			if ($status == 5){
				$where.=" c.c_status!=5 and";
			}
		}
		$string=" where c.param={$id} and c.type=6 ";
		$where= empty($where) ? $string.' and c.c_status=1 ' : $string.' and '.rtrim($where ,'and');
		$sql="SELECT m.nickname,m.mobile,c.code,c.send_time, p.c_value_time,c.id,c.c_status FROM u_coupon_record as c
				left join u_coupon as p on c.param=p.id
				left join u_member as m on c.mid=m.mid ".$where.$str;
		$coupon_data=$this->db->query($sql)->result_array();
		if (!empty($coupon_data)){
			foreach ($coupon_data as $key=>$val){
				if (!empty($val['send_time'])){
					$val['send_time']=date('Y-m-d',$val['send_time']);
				}
				if (!empty($val['c_value_time'])){
					$val['c_value_time']=date('Y-m-d',$val['c_value_time']);
				}
				$coupon_data[$key]=$val;
			}
			$count = $this->getCountNumber($this->db->last_query());
			$data['coupon_data']=$coupon_data;
			$data['pagedata']['page']=$page;
			$data['pagedata']['pageSize']=$pageSize;
			$data['pagedata']['count']=$count;
		}else{
			$data=$coupon_data;
		}
		$this->__data($data);
	}
	
	//单条兑换码作废
	public function code_void(){
		$id=intval($this ->input ->get_post('id' ,true));//记录id
		$data=$this->db->query("select param from u_coupon_record where id={$id} ")->row_array();
		if (!empty($data)){
			$cou_data=$this->db->query("select c_sum,c_use,c_not,c_value_time from u_coupon where id={$data['param']} ")->row_array();
			if (!empty($cou_data)){
				$time=date("Y-m-d");
				$c_value_time=date('Y-m-d',$cou_data['c_value_time']);
				if($c_value_time<$time) $this->__errormsg("该兑换码已过期");
				$c_not=$cou_data['c_sum']-$cou_data['c_use']-$cou_data['c_not'];//计算作废的条数
				if ($c_not <=0) $this->__errormsg("已没有可作废的兑换码");
				$ret=$this->db->update('u_coupon_record',array('c_status'=>4,'void_time'=>time()),array('id'=>$id,'type'=>6));
				if($ret){
					$this->db->query("update u_coupon set `c_not`=`c_not`+1 where id={$data['param']} ");
					$this->__data("操作成功");
				}
				else $this->__errormsg("操作失败,请重新尝试");
			}
			$this->__errormsg("找不到该兑换码");
		}
		$this->__errormsg("找不到该兑换码");
		
	}
	
	//单条兑换码发放
	public function code_send(){
		$id=intval($this ->input ->get_post('id' ,true));//记录id
		$data=$this->db->query("select param from u_coupon_record where id={$id} ")->row_array();
		if (!empty($data)){
			$cou_data=$this->db->query("select c_value_time,c_take from u_coupon where id={$data['param']} ")->row_array();
			$use_data=$this->db->query("select count(id) as num from u_coupon_record where id={$data['param']} and c_status=1 and type=6 ")->row_array();//可发放的数
			if (!empty($cou_data)){
				if (empty($use_data)) $this->__errormsg("没有可发放的兑换码");
				$time=date("Y-m-d");
				$c_value_time=date('Y-m-d',$cou_data['c_value_time']);
				if($c_value_time<$time) $this->__errormsg("该兑换码已过期");
				$ret=$this->db->update('u_coupon_record',array('c_status'=>2,'send_time'=>time(),'if_send'=>2),array('id'=>$id,'type'=>6));
				if($ret){
					$this->db->update('u_coupon',array('c_take'=>$cou_data['c_take']+1),array('id'=>$id,'type'=>6));//更新领用数
					$this->__data("操作成功");
				}
				else $this->__errormsg("操作失败,请重新尝试");
			}
			$this->__errormsg("找不到该兑换码");
		}
		$this->__errormsg("找不到该兑换码");
	}
	
	//兑换码查看
	public function coupon_details() {
		$id = intval($this ->input ->get_post('id' ,true)); //兑换码id
		if (empty($id)) $this->__errormsg("id不能为空");
		$data=$this->db->query("select id,number,price,c_sum,c_value_time,c_type,c_description from u_coupon where id={$id} and c_type=6")->row_array();
		if (!empty($data)){
			$data['c_value_time']=date('Y-m-d',$data['c_value_time']);
		}
		$this->__data($data);
	}
	

}