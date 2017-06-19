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
class Coupon_Data extends UA_Controller {
	const pagesize = 10;
	
	public function __construct() {
		parent::__construct ();
	}
	public function index(){
		$this->load_view ( 'admin/a/coupon_manage/coupon_data');
	}
	//查看
	public function coupon_detail(){
		$id = intval($this ->input ->get_post('id')); //兑换码id
		$type = intval($this ->input ->get_post('type')); //兑换码id
		$data = array(
				'id' =>$id,
				'type'=>$type
		);
		$this->load_view ( 'admin/a/coupon_manage/coupon_detail',$data);
	}
	//发放
	public function send_detail(){
		$id = intval($this ->input ->get_post('id')); //兑换码id
		$type = intval($this ->input ->get_post('type')); //兑换码id
		$data = array(
				'id' =>$id,
				'type'=>$type
		);
		$this->load_view ( 'admin/a/coupon_manage/send_detail',$data);
	}
	//优惠券列表
	public function coupon_list() {
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$sql="select * from u_coupon where c_type<>6 order by id desc ".$str;
		$coupon_data=$this->db->query($sql)->result_array();//全站优惠劵
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
	
	//添加全站优惠券
	public function add_coupon() {
		$number = intval($this ->input ->get_post('number')); //张数
		$endtime = $this ->input ->get_post('time' ,true); //有效期
		$min_price = intval($this ->input ->get_post('min_price' ,true)); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->get_post('coupon_price' ,true); //优惠额
		$decription = $this ->input ->get_post('decription' ,true);//说明
		$starttime=date('Y-m-d');
		if ($coupon_price==0) {
			$this->__errormsg("优惠劵金额不能为0");
		}else if(empty($coupon_price)){
			$this->__errormsg("请填写优惠劵金额");
		}else {
			if (!preg_match('/^\d*$/',$coupon_price)) $this->__errormsg("优惠劵金额只能为整数数字");
			if ($coupon_price>500)  $this->__errormsg("优惠劵金额不能超过500");
		}
		
		if ($number<1) {
			$this->__errormsg("优惠劵张数不能小于1张");
		}else if(empty($number)){
			$this->__errormsg("请填写优惠劵张数");
		}else {
			if (!preg_match('/^\d*$/',$number)) $this->__errormsg("优惠劵张数只能为整数数字");
			if ($number>100000000)  $this->__errormsg("优惠劵张不能超过1亿张");
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
		if ($min_price==='') $this->__errormsg("请填写使用条件");
		if (empty($min_price) && $min_price !=0){
			$this->__errormsg("请填写使用条件");
		}else{
			if (!preg_match('/^\d*$/',$min_price)) $this->__errormsg("使用条件只能为整数数字");
		}
		if ($min_price!=0){
			if ($min_price < $coupon_price) $this->__errormsg("使用条件不能小于优惠劵金额");
			if ($min_price>1000000)  $this->__errormsg("使用条件不能超过百万");
		}
		if (!empty($decription)){
			$mb = mb_strlen($decription,'utf-8');
			if ($mb>30) $this->__errormsg("优惠劵说明不能超过30个字符");
		}
		$data = array(
				'price' =>$min_price,//最低使用条件  0代表没有
				'c_sum' =>$number,//张数
				'c_take' =>0,
				'c_use' =>0,
				'c_value_time' =>strtotime($endtime),//有效期
				'number' =>$coupon_price,//优惠额
				'c_description' =>$decription,
				'if_not' =>1,//是否已作废 1为未作废2为已作废
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'c_type'=>1 //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		);
		$time=time();
		$this->db->trans_begin();//事务开启
		$status = $this ->db ->insert('u_coupon' ,$data);
		$id=$this->db->insert_id();
		$insert_data=array(
				'mid'=>0,
				'take_time'=>0,
				'use_time'=>0,
				'c_status'=>1,//状态 1、为未领用 2、已领用3、已使用 4、已作废
				'type'=>1,//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
				'send_time'=>0,
				'set_time'=>$time,//生成时间
				'void_time'=>0,//作废时间
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'param'=>$id //关联的优惠劵id
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
	
	
	//添加类目优惠券
	public function add_dest_coupon() {
		$number = intval($this ->input ->get_post('number')); //张数
		$endtime = $this ->input ->get_post('time' ,true); //有效期
		$min_price = intval($this ->input ->get_post('min_price' ,true)); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->get_post('coupon_price' ,true); //优惠额
		$decription = $this ->input ->get_post('decription' ,true);//说明
		$dest_id = $this ->input ->get_post('dest_id' ,true);//适用类目 235,335,446
		$starttime=date('Y-m-d');
		if ($coupon_price==0) {
			$this->__errormsg("优惠劵金额不能为0");
		}else if(empty($coupon_price)){
			$this->__errormsg("请填写优惠劵金额");
		}else {
			if (!preg_match('/^\d*$/',$coupon_price)) $this->__errormsg("优惠劵金额只能为整数数字");
			if ($coupon_price>500)  $this->__errormsg("优惠劵金额不能超过500");
		}
		
		if ($number<1) {
			$this->__errormsg("优惠劵张数不能小于1张");
		}else if(empty($number)){
			$this->__errormsg("请填写优惠劵张数");
		}else {
			if (!preg_match('/^\d*$/',$number)) $this->__errormsg("优惠劵张数只能为整数数字");
			if ($number>100000000)  $this->__errormsg("优惠劵张不能超过1亿张");
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
		if ($min_price==='') $this->__errormsg("请填写使用条件");
		if (empty($min_price) && $min_price !=0){
			$this->__errormsg("请填写使用条件");
		}else{
			if (!preg_match('/^\d*$/',$min_price)) $this->__errormsg("使用条件只能为整数数字");
		}
		if ($min_price!=0){
			if ($min_price < $coupon_price) $this->__errormsg("使用条件不能小于优惠劵金额");
			if ($min_price>1000000)  $this->__errormsg("使用条件不能超过百万");
		}
		if (!empty($decription)){
			$mb = mb_strlen($decription,'utf-8');
			if ($mb>30) $this->__errormsg("优惠劵说明不能超过30个字符");
		}
		if (empty($dest_id)) {
			$this->__errormsg("请选择适用类目");
		}
		if (empty($min_price)) $min_price=0;
		$data = array(
				'price' =>$min_price,//最低使用条件  0代表没有
				'c_sum' =>$number,//张数
				'c_take' =>0,
				'c_use' =>0,
				'c_value_time' =>strtotime($endtime),//有效期
				'number' =>$coupon_price,//优惠额
				'c_description' =>$decription,
				'if_not' =>1,//是否已作废 1为未作废2为已作废
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'c_type'=>2 //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		);
		$time=time();
		$this->db->trans_begin();//事务开启
		$status = $this ->db ->insert('u_coupon' ,$data);
		$id=$this->db->insert_id();
		$exp=array('c_id'=>$id);
		//目的地处理
		$dest_id=rtrim($dest_id ,',');
		$dest_data=explode(',', $dest_id);
		$dest_datas=array();
		foreach ($dest_data as $key=>$val){
			$exp['dest_id']=$val;
			array_push($dest_datas, $exp);
		}
		$this->db->insert_batch('u_coupon_dest_exp', $dest_datas);
		$insert_data=array(
				'mid'=>0,
				'take_time'=>0,
				'use_time'=>0,
				'c_status'=>1,//状态 1、为未领用 2、已领用3、已使用 4、已作废
				'type'=>2,//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
				'send_time'=>0,
				'set_time'=>$time,//生成时间
				'void_time'=>0,//作废时间
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'param'=>$id, //关联的优惠劵id
				'param_val'=>$dest_id //关联的值
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
	
	//添加店铺优惠券
	public function add_supplier_coupon() {
		$supplier=trim($this->input->get_post('supplier',true));//供应商
		$number = intval($this ->input ->get_post('number')); //张数
		$endtime = $this ->input ->get_post('time' ,true); //有效期
		$min_price = intval($this ->input ->get_post('min_price' ,true)); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->get_post('coupon_price' ,true); //优惠额
		$decription = $this ->input ->get_post('decription' ,true);//说明
		$starttime=date('Y-m-d');
		if (empty($supplier)) {
			$this->__errormsg("请填写供应商名称");
		}
		$supplier_data=$this->db->query("select id from u_supplier where status=2 and company_name='{$supplier}'")->row_array();
		if (empty($supplier_data)) $this->__errormsg("该供应商不存在或已终止合作");
		if ($coupon_price==0) {
			$this->__errormsg("优惠劵金额不能为0");
		}else if(empty($coupon_price)){
			$this->__errormsg("请填写优惠劵金额");
		}else {
			if (!preg_match('/^\d*$/',$coupon_price)) $this->__errormsg("优惠劵金额只能为整数数字");
			if ($coupon_price>500)  $this->__errormsg("优惠劵金额不能超过500");
		}
		
		if ($number<1) {
			$this->__errormsg("优惠劵张数不能小于1张");
		}else if(empty($number)){
			$this->__errormsg("请填写优惠劵张数");
		}else {
			if (!preg_match('/^\d*$/',$number)) $this->__errormsg("优惠劵张数只能为整数数字");
			if ($number>100000000)  $this->__errormsg("优惠劵张不能超过1亿张");
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
		if ($min_price==='') $this->__errormsg("请填写使用条件");
		if (empty($min_price) && $min_price !=0){
			$this->__errormsg("请填写使用条件");
		}else{
			if (!preg_match('/^\d*$/',$min_price)) $this->__errormsg("使用条件只能为整数数字");
		}
		if ($min_price!=0){
			if ($min_price < $coupon_price) $this->__errormsg("使用条件不能小于优惠劵金额");
			if ($min_price>1000000)  $this->__errormsg("使用条件不能超过百万");
		}
		if (!empty($decription)){
			$mb = mb_strlen($decription,'utf-8');
			if ($mb>30) $this->__errormsg("优惠劵说明不能超过30个字符");
		}
		if (empty($min_price)) $min_price=0;
		$data = array(
				'price' =>$min_price,//最低使用条件  0代表没有
				'c_sum' =>$number,//张数
				'c_take' =>0,
				'c_use' =>0,
				'c_value_time' =>strtotime($endtime),//有效期
				'number' =>$coupon_price,//优惠额
				'c_description' =>$decription,
				'if_not' =>1,//是否已作废 1为未作废2为已作废
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'c_type'=>3 //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		);
		$time=time();
		$this->db->trans_begin();//事务开启
		$status = $this ->db ->insert('u_coupon' ,$data);
		$id=$this->db->insert_id();
		$insert_data=array(
				'mid'=>0,
				'take_time'=>0,
				'use_time'=>0,
				'c_status'=>1,//状态 1、为未领用 2、已领用3、已使用 4、已作废
				'type'=>3,//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
				'send_time'=>0,
				'set_time'=>$time,//生成时间
				'void_time'=>0,//作废时间
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'param'=>$id, //关联的优惠劵id
				'param_val'=>$supplier_data['id'] //关联的值
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
	
	//添加产品优惠券
	public function add_line_coupon() {
		$number = intval($this ->input ->get_post('number')); //张数
		$endtime = $this ->input ->get_post('time' ,true); //有效期
		$min_price = intval($this ->input ->get_post('min_price' ,true)); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->get_post('coupon_price' ,true); //优惠额
		$decription = $this ->input ->get_post('decription' ,true);//说明
		$dest_id = $this ->input ->get_post('line_id' ,true);//线路id 235,335,446
		$starttime=date('Y-m-d');
		if ($coupon_price==0) {
			$this->__errormsg("优惠劵金额不能为0");
		}else if(empty($coupon_price)){
			$this->__errormsg("请填写优惠劵金额");
		}else {
			if (!preg_match('/^\d*$/',$coupon_price)) $this->__errormsg("优惠劵金额只能为整数数字");
			if ($coupon_price>500)  $this->__errormsg("优惠劵金额不能超过500");
		}
		
		if ($number<1) {
			$this->__errormsg("优惠劵张数不能小于1张");
		}else if(empty($number)){
			$this->__errormsg("请填写优惠劵张数");
		}else {
			if (!preg_match('/^\d*$/',$number)) $this->__errormsg("优惠劵张数只能为整数数字");
			if ($number>100000000)  $this->__errormsg("优惠劵张不能超过1亿张");
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
		if ($min_price==='') $this->__errormsg("请填写使用条件");
		if (empty($min_price) && $min_price !=0){
			$this->__errormsg("请填写使用条件");
		}else{
			if (!preg_match('/^\d*$/',$min_price)) $this->__errormsg("使用条件只能为整数数字");
		}
		if ($min_price!=0){
			if ($min_price < $coupon_price) $this->__errormsg("使用条件不能小于优惠劵金额");
			if ($min_price>1000000)  $this->__errormsg("使用条件不能超过百万");
		}
		if (!empty($decription)){
			$mb = mb_strlen($decription,'utf-8');
			if ($mb>30) $this->__errormsg("优惠劵说明不能超过30个字符");
		}
		if (empty($dest_id)) $this->__errormsg("请选择线路");
		if (empty($min_price)) $min_price=0;
		$data = array(
				'price' =>$min_price,//最低使用条件  0代表没有
				'c_sum' =>$number,//张数
				'c_take' =>0,
				'c_use' =>0,
				'c_value_time' =>strtotime($endtime),//有效期
				'number' =>$coupon_price,//优惠额
				'c_description' =>$decription,
				'if_not' =>1,//是否已作废 1为未作废2为已作废
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'c_type'=>4 //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		);
		$time=time();
		$this->db->trans_begin();//事务开启
		$status = $this ->db ->insert('u_coupon' ,$data);
		$id=$this->db->insert_id();
		$exp=array('c_id'=>$id);
		//线路处理
		$dest_id=rtrim($dest_id ,',');
		$dest_data=explode(',', $dest_id);
		$dest_datas=array();
		foreach ($dest_data as $key=>$val){
			$exp['line_id']=$val;
			array_push($dest_datas, $exp);
		}
		$this->db->insert_batch('u_coupon_line_exp', $dest_datas);
		$insert_data=array(
				'mid'=>0,
				'take_time'=>0,
				'use_time'=>0,
				'c_status'=>1,//状态 1、为未领用 2、已领用3、已使用 4、已作废
				'type'=>4,//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
				'send_time'=>0,
				'set_time'=>$time,//生成时间
				'void_time'=>0,//作废时间
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'param'=>$id, //关联的优惠劵id
				'param_val'=>$dest_id //关联的值
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
	
	//添加注册优惠券
	public function add_res_coupon() {
		$number = intval($this ->input ->get_post('number')); //张数
		$endtime = $this ->input ->get_post('time' ,true); //有效期
		$min_price = intval($this ->input ->get_post('min_price' ,true)); //最低使用条件  0代表没有
		$coupon_price = $this ->input ->get_post('coupon_price' ,true); //优惠额
		$decription = $this ->input ->get_post('decription' ,true);//说明
		$starttime=date('Y-m-d');
		if ($coupon_price==0) {
			$this->__errormsg("优惠劵金额不能为0");
		}else if(empty($coupon_price)){
			$this->__errormsg("请填写优惠劵金额");
		}else {
			if (!preg_match('/^\d*$/',$coupon_price)) $this->__errormsg("优惠劵金额只能为整数数字");
			if ($coupon_price>500)  $this->__errormsg("优惠劵金额不能超过500");
		}
		
		if ($number<1) {
			$this->__errormsg("优惠劵张数不能小于1张");
		}else if(empty($number)){
			$this->__errormsg("请填写优惠劵张数");
		}else {
			if (!preg_match('/^\d*$/',$number)) $this->__errormsg("优惠劵张数只能为整数数字");
			if ($number>100000000)  $this->__errormsg("优惠劵张不能超过1亿张");
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
		if ($min_price==='') $this->__errormsg("请填写使用条件");
		if (empty($min_price) && $min_price !=0){
			$this->__errormsg("请填写使用条件");
		}else{
			if (!preg_match('/^\d*$/',$min_price)) $this->__errormsg("使用条件只能为整数数字");
		}
		if ($min_price!=0){
			if ($min_price < $coupon_price) $this->__errormsg("使用条件不能小于优惠劵金额");
			if ($min_price>1000000)  $this->__errormsg("使用条件不能超过百万");
		}
		if (!empty($decription)){
			$mb = mb_strlen($decription,'utf-8');
			if ($mb>30) $this->__errormsg("优惠劵说明不能超过30个字符");
		}
		if (empty($min_price)) $min_price=0;
		$data = array(
				'price' =>$min_price,//最低使用条件  0代表没有
				'c_sum' =>$number,//张数
				'c_take' =>0,
				'c_use' =>0,
				'c_value_time' =>strtotime($endtime),//有效期
				'number' =>$coupon_price,//优惠额
				'c_description' =>$decription,
				'if_not' =>1,//是否已作废 1为未作废2为已作废
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'c_type'=>5 //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		);
		$time=time();
		$this->db->trans_begin();//事务开启
		$status = $this ->db ->insert('u_coupon' ,$data);
		$id=$this->db->insert_id();
		$str_code="A1zcyhj";
		$insert_data=array(
				'mid'=>0,
				'take_time'=>0,
				'use_time'=>0,
				'c_status'=>1,//状态 1、为未领用 2、已领用3、已使用 4、已作废
				'type'=>5,//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
				'send_time'=>0,
				'set_time'=>$time,//生成时间
				'void_time'=>0,//作废时间
				'if_send' =>1,//是否已发放 1为未发放2为已发放
				'param'=>$id, //关联的优惠劵id
				'code'=>$str_code
		);
		
		$datas=array();
		$n=ceil($number/50000);
		if ($n>1){
			$max="50000";
			for ($i=0;$i<$n;$i++){
				if ($i==0){
					for ($x=0; $x<50000; $x++) {
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
						array_push($datas, $insert_data);
					}
					$this->db->insert_batch('u_coupon_record', $datas);
					unset($datas);
					$datas=array();
				}
		
			}
		}else{
			for ($x=0; $x<$number; $x++) {
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
	
	//模糊获取供应商名称
	public function get_supplier(){
		$supplier=trim($this->input->get_post('supplier',true));//供应商
		$supplier_data=$this->db->query("select company_name from u_supplier where status=2 and company_name like'%{$supplier}%'")->result_array();
		$data=array();
		foreach ($supplier_data as $key=>$val){
			$data[]=$val['company_name'];
		}
		echo json_encode($data);
	}
	
	
	//优惠劵查看
	public function coupon_details() {
		$type = intval($this ->input ->get_post('type' ,true)); //所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		$id = intval($this ->input ->get_post('id' ,true)); //优惠劵id
		if (!in_array($type, array(1,2,3,4,5))) $this->__errormsg("参数错误");
		if (empty($id)) $this->__errormsg("id不能为空");
		$sql="select id,number,price,c_sum,c_value_time,c_type,c_description from u_coupon where id={$id} and c_type={$type}";
		if ($type==3){//店铺优惠劵
			$sql="select u.id,u.number,u.price,u.c_sum,u.c_value_time,u.c_type,u.c_description,s.brand from u_coupon as u 
			left join u_coupon_record as c on u.id=c.param
			left join u_supplier as s on c.param_val=s.id 
			where u.id={$id} and u.c_type={$type}";
		}
		$data=$this->db->query($sql)->row_array();
		if (!empty($data)){
			$data['c_value_time']=date('Y-m-d',$data['c_value_time']);
		}
		$this->__data($data);
	}
	
	//查看类目
	public function coupon_dest_looks() {
		$id = intval($this ->input ->get_post('id' ,true)); //优惠劵id
		if (empty($id)) $this->__errormsg("id不能为空");
		$dest_data=$this->db->query("select dest_id from u_coupon_dest_exp where c_id={$id} ")->result_array();
		if (!empty($dest_data)){
			$where="";
			foreach ($dest_data as $key=>$val){
				$where.=" id=".$val['dest_id'].' or';
			}
			$where= empty($where)?'':' where '.rtrim($where ,'or');
			$data=$this->db->query("select name from u_dest_cfg {$where} ")->result_array();
		}else{
			$data=$dest_data;
		}
		
		$this->__data($data);
	}
	
	//查看产品
	public function coupon_line_looks() {
		$id = intval($this ->input ->get_post('id' ,true)); //优惠劵id
		if (empty($id)) $this->__errormsg("id不能为空");
		$line_data=$this->db->query("select line_id from u_coupon_line_exp where c_id={$id} ")->result_array();
		if (!empty($line_data)){
			$where="";
			foreach ($line_data as $key=>$val){
				$where.=" id=".$val['line_id'].' or';
			}
			$where= empty($where)?'':' where '.rtrim($where ,'or');
			$data=$this->db->query("select linecode,linename from u_line {$where} ")->result_array();
		}else{
			$data=$line_data;
		}
		$this->__data($data);
	}
	
	//获取适用类目
	public function get_dest(){
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$dest_name=$this ->input ->get_post('dest_name' ,true);//目的地名称
		$id=$this ->input ->get_post('id' ,true);//id 1,2,3,
		$where='';
		if (!empty($id)){
			$id=rtrim($id,',');
			$id_data=explode(',', $id);
			foreach ($id_data as $key=>$val){
				$where.= ' and id!='.$val.' ';
			}
		}
		$sql="select id,name from u_dest_cfg where isopen=1 and level=3 ";
		if (!empty($dest_name)){
			$sql.=" and name like'%".$dest_name."%'";
		}
		$sql.=$where.$str;
		$coupon_data=$this->db->query($sql)->result_array();
		if (!empty($coupon_data)){
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
	
	//获取产品数据
	public function get_line_data(){
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$line_name=$this ->input ->get_post('line_name' ,true);//线路名称
		$line_code=$this ->input ->get_post('line_code' ,true);//线路编号
		$brand_name=$this ->input ->get_post('brand_name' ,true);//品牌名称
		$supplier_name=$this ->input ->get_post('supplier_name' ,true);//供应商名称
		$where='';
		$time=date("Y-m-d");
		if (!empty($line_name)){
			$where.=" a.linename like'%".trim($line_name)."%' and";
		}
		if (!empty($line_code)){
			$where.=" a.linecode like'%".$line_code."%' and";
		}
		if (!empty($brand_name)){
			$where.=" s.brand like'%".trim($brand_name)."%' and";
		}
		if (!empty($supplier_name)){
			$where.=" s.company_name='".trim($supplier_name)."' and";
		}
		$string=" where a.status=2 and a.line_status=1 and a.line_kind=1 and b.day> '".$time."'";
		$where= empty($where) ? $string : $string.' and '.rtrim($where ,'and');
		$sql="SELECT a.id,a.linecode,a.linename,MIN(b.adultprice) AS adultprice FROM u_line_suit_price b
				INNER JOIN u_line a ON a.id=b.lineid 
				INNER JOIN u_supplier s ON a.supplier_id=s.id ".$where ."
				GROUP BY b.lineid".$str;
		$coupon_data=$this->db->query($sql)->result_array();
		if (!empty($coupon_data)){
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
	
	//搜索优惠劵
	public function search_coupon(){
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 10;
		$pageSize = empty($pageSize) ? 10 : $pageSize;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$id=intval($this ->input ->get_post('id' ,true));//优惠劵id
		$member_name=$this ->input ->get_post('member_name' ,true);//会员名称
		$mobile=$this ->input ->get_post('mobile' ,true);//会员手机
		$coupon_code=$this ->input ->get_post('coupon_code' ,true);//优惠劵代码
		$status=$this ->input ->get_post('status' ,true);//状态 1、为未领用 2、已领用3、已使用 4、已作废 5、全部
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
		if (!empty($coupon_code)){
			$where.=" c.code like'%".trim($coupon_code)."%' and";
		}
		if (!empty($status)){
			if ($status!=1 && $status!=5 ){
				$where.=" c.c_status='".trim($status)."' and";
			}
			if ($status == 5){
				$where.=" c.c_status!=5 and";
			}
		}
		$string=" where c.param={$id} and c.type<>6 ";
		$where= empty($where) ? $string.' and c.c_status=1'  : $string.' and '.rtrim($where ,'and');
		$sql="SELECT m.nickname,m.mobile,c.code,c.take_time,c.use_time, p.c_value_time,c.id,c.c_status FROM u_coupon_record as c
				left join u_coupon as p on c.param=p.id
				left join u_member as m on c.mid=m.mid ".$where.$str;
		$coupon_data=$this->db->query($sql)->result_array();
		if (!empty($coupon_data)){
			foreach ($coupon_data as $key=>$val){
				if (!empty($val['use_time'])){
					$val['use_time']=date('Y-m-d',$val['use_time']);
				}
				if (!empty($val['c_value_time'])){
					$val['c_value_time']=date('Y-m-d',$val['c_value_time']);
				}
				if (!empty($val['take_time'])){
					$val['take_time']=date('Y-m-d H:i:s',$val['take_time']);
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
	
	//单条记录作废
	public function coupon_void(){
		$id=intval($this ->input ->get_post('id' ,true));//记录id
		$data=$this->db->query("select param from u_coupon_record where id={$id} ")->row_array();
		if (!empty($data)){
			$cou_data=$this->db->query("select c_sum,c_use,c_not,c_value_time from u_coupon where id={$data['param']} ")->row_array();
			if (!empty($cou_data)){
				$time=date("Y-m-d");
				$times=time();
				$c_value_time=date('Y-m-d',$cou_data['c_value_time']);
				if($c_value_time<$time) $this->__errormsg("该优惠劵已过期");
				$c_not=$cou_data['c_sum']-$cou_data['c_use']-$cou_data['c_not'];//计算作废的条数
				if ($c_not <=0) $this->__errormsg("已没有可作废的优惠劵");
				$ret=$this->db->query("update u_coupon_record set `c_status`=4,`void_time`='{$times}' where `id`={$id} and `type`!=6 ");
				if($ret){
					$this->db->query("update u_coupon set `c_not`=`c_not`+1 where id={$data['param']} ");
					$this->__data("操作成功");
				}
				else $this->__errormsg("操作失败,请重新尝试");
			}
			$this->__errormsg("找不到该优惠劵");
		}
		$this->__errormsg("找不到该优惠劵");
		
	}
	
	//批量作废优惠劵
	public function coupon_void_all(){
		$id=intval($this ->input ->get_post('id' ,true));//优惠劵id
		$type=intval($this ->input ->get_post('type' ,true));//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		if (empty($id)) $this->__errormsg("id参数缺失");
		if (empty($type)) $this->__errormsg("参数缺失");
		if (!in_array($type, array(1,2,3,4,5,6))) $this->__errormsg("参数错误");
		$data=$this->db->query("select c_sum,c_use,c_not,c_value_time from u_coupon where id={$id} ")->row_array();
		if (!empty($data)){
			$t=date("Y-m-d");
			$c_value_time=date('Y-m-d',$data['c_value_time']);
			if($c_value_time<$t){
				if ($type !=6){
					$this->__errormsg("该优惠劵已过期");
				}else{
					$this->__errormsg("该兑换码已过期");
				}
			}
			$c_not=$data['c_sum']-$data['c_use']-$data['c_not'];//计算作废的条数
			if ($c_not <=0){
				if ($type !=6){
					$this->__errormsg("已没有可作废的优惠劵");
				}else{
					$this->__errormsg("已没有可作废的兑换码");
				}
			}
			$time=time();
			$ret=$this->db->query("UPDATE `u_coupon_record` SET `c_status` = 4, `void_time` ={$time}  WHERE `param` = {$id} AND `type` = {$type} AND `c_status`<3 ");
			// 		$ret=$this->db->update('u_coupon_record',array('c_status'=>4,'void_time'=>time()),array('param'=>$id,'type'=>$type,'c_status<>'=>4,'c_status<>'=>3));
			if($ret){
				$this->db->query("update u_coupon set `if_not`=2,`c_not`=`c_not`+{$c_not} where id={$id} and c_type={$type} ");
				$this->__data("操作成功");
			}
			else $this->__errormsg("操作失败,请重新尝试");
		}else{
			if ($type !=6){
				$this->__errormsg("找不到该优惠劵");
			}else{
				$this->__errormsg("找不到该兑换码");
			}
		}
	}
	


	//获取发放用户数据
	public function get_user_data(){
		$postArr = $this->security->xss_clean($_POST);
		$page = isset($postArr['page']) ? intval($postArr['page']) : 1;
		$page = empty($page) ? 1 : $page;
		$pageSize = isset($postArr['pageSize']) ? intval($postArr['pageSize']) : 1000;
		$str= ' limit '.($page-1)*$pageSize.','.$pageSize;
		$id=intval($this ->input ->get_post('id' ,true));//优惠劵id
		$type=intval($this ->input ->get_post('type' ,true));//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		$member_name=$this ->input ->get_post('member_name' ,true);//会员名称
		$mobile=$this ->input ->get_post('mobile' ,true);//会员手机
		$res_time1=$this ->input ->get_post('res_time1' ,true);//注册日期1 格式：2010-07-12 12:00:01
		$res_time2=$this ->input ->get_post('res_time2' ,true);//注册日期2 格式：2010-07-12 12:00:01
		$login_time1=$this ->input ->get_post('login_time1' ,true);//登录日期1 格式：2010-07-12 12:00:01
		$login_time2=$this ->input ->get_post('login_time2' ,true);//登录日期2 格式：2010-07-12 12:00:01
		if (empty($id)) $this->__errormsg("id参数缺失");
		if (empty($type)) $this->__errormsg("参数缺失");
		if (!in_array($type, array(1,2,3,4,5))) $this->__errormsg("参数错误");
		$where='';
		if (!empty($member_name)){
			$where.=" nickname like'%".trim($member_name)."%' and";
		}
		if (!empty($mobile)){
			$where.=" mobile like'%".$mobile."%' and";
		}
		if (!empty($res_time1)){
// 			$res_time1=strtotime($res_time1);
			$where.=" jointime >='{$res_time1}' and";
		}
		if (!empty($res_time2)){
// 			$res_time2=strtotime($res_time2);
			$where.=" jointime <='{$res_time2}' and";
		}
		if (!empty($res_time1) && !empty($res_time2)){
			if ($res_time1>$res_time2) $this->__errormsg("注册日期区间错误");
		}
		
		if (!empty($login_time1)){
			$login_time1=strtotime($login_time1);
			$where.=" login_time >='{$login_time1}' and";
		}
		if (!empty($login_time2)){
			$login_time2=strtotime($login_time2);
			$where.=" login_time <='{$login_time2}' and";
		}
		if (!empty($login_time1) && !empty($login_time2)){
			if ($login_time1>$login_time2) $this->__errormsg("登录日期区间错误");
		}
		//找出已经领过该优惠劵的用户id
		$u_data=$this->db->query("select mid from u_coupon_record where type={$type} and param={$id} and mid!=0")->result_array();
		if (!empty($u_data)){
			foreach ($u_data as $key=>$val){
				$where.=' mid!='.$val['mid'].' and';
			}
		}
		$where= empty($where) ? '' : ' where '.rtrim($where ,'and');
		$sql="select mid,nickname,mobile,jointime,login_time from u_member ".$where." order by login_time desc ".$str;
		$coupon_data=$this->db->query($sql)->result_array();
		if (!empty($coupon_data)){
			foreach ($coupon_data as $key=>$val){
				if (!empty($val['login_time'])){
					$val['login_time']=date('Y-m-d H:i:s',$val['login_time']);
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
	
	
	//全部发放优惠劵
	public function coupon_send_all(){
		$id=intval($this ->input ->get_post('id' ,true));//优惠劵id
		$type=intval($this ->input ->get_post('type' ,true));//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		$member_name=$this ->input ->get_post('member_name' ,true);//会员名称
		$mobile=$this ->input ->get_post('mobile' ,true);//会员手机
		$res_time1=$this ->input ->get_post('res_time1' ,true);//注册日期1 格式：2010-07-12 12:00:01
		$res_time2=$this ->input ->get_post('res_time2' ,true);//注册日期2 格式：2010-07-12 12:00:01
		$login_time1=$this ->input ->get_post('login_time1' ,true);//登录日期1 格式：2010-07-12 12:00:01
		$login_time2=$this ->input ->get_post('login_time2' ,true);//登录日期2 格式：2010-07-12 12:00:01
		if (empty($id)) $this->__errormsg("id参数缺失");
		if (empty($type)) $this->__errormsg("参数缺失");
		if (!in_array($type, array(1,2,3,4,5))) $this->__errormsg("参数错误");
		$where='';
		if (!empty($member_name)){
			$where.=" nickname like'%".trim($member_name)."%' and";
		}
		if (!empty($mobile)){
			$where.=" mobile like'%".$mobile."%' and";
		}
		if (!empty($res_time1)){
			// 			$res_time1=strtotime($res_time1);
			$where.=" jointime >='{$res_time1}' and";
		}
		if (!empty($res_time2)){
			// 			$res_time2=strtotime($res_time2);
			$where.=" jointime <='{$res_time2}' and";
		}
		if (!empty($res_time1) && !empty($res_time2)){
			if ($res_time1>$res_time2) $this->__errormsg("注册日期区间错误");
		}
		
		if (!empty($login_time1)){
			$login_time1=strtotime($login_time1);
			$where.=" login_time >='{$login_time1}' and";
		}
		if (!empty($login_time2)){
			$login_time2=strtotime($login_time2);
			$where.=" login_time <='{$login_time2}' and";
		}
		if (!empty($login_time1) && !empty($login_time2)){
			if ($login_time1>$login_time2) $this->__errormsg("登录日期区间错误");
		}
		$data=$this->db->query("select c_value_time,c_take from u_coupon where id={$id} ")->row_array();
		if (!empty($data)){
			$t=date("Y-m-d");
			$c_value_time=date('Y-m-d',$data['c_value_time']);
			if($c_value_time<$t) $this->__errormsg("该优惠劵已过期");
			$u_num=$this->db->query("select mid from u_coupon_record where param={$id} and type={$type} and mid!=0 ")->result_array();//已领用用户
			if (!empty($u_num)){
				foreach ($u_num as $key=>$val){
					$where.=" mid!=".$val['mid'].' and';
				}
			}
			$where=empty($where)? '': ' where '.rtrim($where,'and');
			$user_num=$this->db->query("select mid from u_member {$where}")->result_array();//该发放的用户
			if (empty($user_num)) $this->__errormsg("已没有可发放的用户");
			$user_num_count=count($user_num);//计算该发放的用户数
			$use_data=$this->db->query("select count(id) as num from u_coupon_record where param={$id} and c_status=1 and type={$type} and mid=0  ")->row_array();//可发放的数
			if (empty($use_data)) {
				$this->__errormsg("已没有可发放的优惠劵");
			}else if($use_data['num']<$user_num_count){
				$this->__errormsg("已超过可发放的优惠劵数量:".$use_data['num']);
			}else{
				$result=$this->db->query("select id from u_coupon_record where param={$id} and type={$type} and c_status=1 limit {$user_num_count} ")->result_array();
				if (!empty($result)){
					$dest_datas=$update=array();
					$ids='';
					$time=time();
					$update_sql = 'UPDATE u_coupon_record SET';
					$update_sql .= ' mid = CASE id';
					foreach ($result as $key=>$val){
						$ids.=$val['id'].',';
						$update_sql .= " WHEN " .$val['id'] . " THEN " . $user_num[$key]['mid'] . " ";
					}
					$update_sql .= " END";
					$update_sql .= ',send_time = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN " . $time . " ";
					}
					$update_sql .= " END";
					$update_sql .= ',take_time = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN " . $time . " ";
					}
					$update_sql .= " END";
					$update_sql .= ',c_status = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN 2 ";
					}
					$update_sql .= " END";
					$update_sql .= ',if_send = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN 2 ";
					}
					$ids=rtrim($ids,',');
					$update_sql .= " END";
					$update_sql .= " WHERE id IN (" . $ids . ")";
					$this->db->trans_begin();//事务开启
					$this->db->query($update_sql);
					$this->db->update('u_coupon',array('if_send'=>2,'c_take'=>$data['c_take']+$user_num_count),array('id'=>$id,'c_type'=>$type));
					$this->db->trans_complete(); //事务结束
					//事务
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$this->__errormsg("发放异常，请重新尝试");
					}else{
						$this->db->trans_commit();
						$this->__data("发放成功");
					}
				}
				$this->__errormsg("没有可发放的优惠劵");
			}
		}
		$this->__errormsg("找不到该优惠劵");
	}
	
	//发放优惠劵给指定用户
	public function send_user_coupon(){
		$id=intval($this ->input ->get_post('id' ,true));//优惠劵id
		$type=intval($this ->input ->get_post('type' ,true));//所属类别 1、全站优惠劵2、类目优惠劵3、店铺优惠劵4、产品优惠劵 5、注册优惠劵6、兑换码
		$user_id=$this ->input ->get_post('user_id' ,true);//所选用户 (格式：1,2,3,4)
		if (empty($id)) $this->__errormsg("id参数缺失");
		if (empty($type)) $this->__errormsg("参数缺失");
		if (!in_array($type, array(1,2,3,4,5))) $this->__errormsg("参数错误");
		if (empty($user_id)){
			$this->__errormsg("请选择用户");
		}else{
			$user_id=rtrim($user_id ,',');
			$user_data=explode(',', $user_id);
			$num=count($user_data);//计算用户数量
			$res_data=$this->db->query("select mid from u_coupon_record where param={$id} and type={$type} and mid!=0 ")->result_array();
			if (!empty($res_data)){
				foreach ($user_data as $key=>$val){
					foreach ($res_data as $k=>$v){
						if (in_array($val,$v)){
							$u=$this->db->query("select mobile from u_member where mid={$val}")->row_array();
							$this->__errormsg("选项中存在已领取该优惠劵的用户".$u['mobile'].",请重新选择");
						}
					}
				}
			}
		}
		$data=$this->db->query("select c_value_time,c_take from u_coupon where id={$id} ")->row_array();
		$use_data=$this->db->query("select count(id) as num from u_coupon_record where param={$id} and c_status=1 and type={$type} ")->row_array();//可发放的数
		if (!empty($data)){
			$t=date("Y-m-d");
			$c_value_time=date('Y-m-d',$data['c_value_time']);
			if($c_value_time<$t) $this->__errormsg("该优惠劵已过期");
			if (empty($use_data)) {
				$this->__errormsg("已没有可发放的优惠劵");
			}else if($use_data['num']<$num){
				$this->__errormsg("已超过可发放的优惠劵数量:".$use_data['num']);
			}else{
				$result=$this->db->query("select id from u_coupon_record where param={$id} and type={$type} and c_status=1 limit {$num} ")->result_array();
				if (!empty($result)){
					$dest_datas=$update=array();
					$ids='';
					$time=time();
					$update_sql = 'UPDATE u_coupon_record SET';
					$update_sql .= ' mid = CASE id';
					foreach ($result as $key=>$val){
						$ids.=$val['id'].',';
						$update_sql .= " WHEN " .$val['id'] . " THEN " . $user_data[$key] . " ";
					}
					$update_sql .= " END";
					$update_sql .= ',send_time = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN " . $time . " ";
					}
					$update_sql .= " END";
					$update_sql .= ',take_time = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN " . $time . " ";
					}
					$update_sql .= " END";
					$update_sql .= ',c_status = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN 2 ";
					}
					$update_sql .= " END";
					$update_sql .= ',if_send = CASE id';
					foreach ($result as $key=>$val){
						$update_sql .= " WHEN " .$val['id'] . " THEN 2 ";
					}
					$ids=rtrim($ids,',');
					$update_sql .= " END";
					$update_sql .= " WHERE id IN (" . $ids . ")";
					$this->db->trans_begin();//事务开启
					$this->db->query($update_sql);
					$this->db->update('u_coupon',array('c_take'=>$data['c_take']+$num),array('id'=>$id));//更新发放数
					$this->db->trans_complete(); //事务结束
					//事务
					if ($this->db->trans_status() === FALSE)
					{
						$this->db->trans_rollback();
						$this->__errormsg("发放异常，请重新尝试");
					}else{
						$this->db->trans_commit();
						$this->__data("发放成功");
					}
				}
				$this->__errormsg("没有可发放的优惠劵");
			}
		}
		$this->__errormsg("找不到该优惠劵");
	}
	
}