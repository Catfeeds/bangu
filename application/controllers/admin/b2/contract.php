<?php
/**
 * 合同签署
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月17日11:59:53
 * @author 徐鹏
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Contract extends UB2_Controller {
	public $defaultData = array(
			'count' =>0,
			'data' =>array()
	);
	public function __construct()
	{
		parent::__construct ();
		$this->load->helper ( 'regexp' );
		$this ->load->library ( 'callback' );
		$this->load_model ( 'admin/t33/b_contract_launch_model', 'contract_model' );
		$this ->load_model('expert_model');
	}

	public function index()
	{
		$is_manage = $this ->session ->userdata('is_manage');
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		
		$expertArr = array();
		if ($is_manage == 1)
		{
			//获取营业部下的管家
			$departIds = empty($expertData['depart_list']) ? $expertData['depart_id'] : rtrim($expertData['depart_list'] ,',');
			
			$expertArr = $this ->expert_model ->getDepartExpert($departIds);
		}
		
		$dataArr = array(
				'is_manage' =>$is_manage,
				'expertArr' =>$expertArr,
				'expertData' =>$expertData
		);
		
		$this->view('admin/b2/contract_view' ,$dataArr);
	}
	
	//获取未使用的合同
	public function getContractApply()
	{
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		$is_manage = $this ->session ->userdata('is_manage');
		
		$whereArr = array(
				'ca.status =' =>1,
				'cl.status =' =>0
		);
		if ($is_manage == 0)
		{
			//此管家不是营业部经理，只能看见自己的合同
			$whereArr['cl.expert_id ='] = $this ->expert_id; //合同使用表管家ID
		}
		else 
		{
			//此管家是营业部经理
			$whereArr['ca.expert_id ='] = $this ->expert_id; //合同申请表管家ID
		}
		
		
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$expert_name = trim($this ->input ->post('expert_name' ,true));
		
		if (!empty($starttime)) {
			$whereArr['ca.addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['ca.addtime <='] = $endtime.' 23:59:59';
		}
		if (!empty($expert_name)) {
			$whereArr['ca.expert_name like'] = '%'.$expert_name.'%';
		}
		
		$data = $this ->contract_model ->getContractApplyData($whereArr);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
	
	//获取合同数据
	public function getContractData()
	{
		$status = intval($this ->input ->post('status'));
		$contract_code = trim($this ->input ->post('contract_code' ,true));
		$guest_name = trim($this ->input ->post('guest_name' ,true));
		$ordersn = trim($this ->input ->post('ordersn' ,true));
		$starttime = trim($this ->input ->post('starttime' ,true));
		$endtime = trim($this ->input ->post('endtime' ,true));
		$expert_name = trim($this ->input ->post('expert_name' ,true));
		
		
		switch($status) {
			case 1:
				$orderBy = 'id desc';
				break;
			case 2:
				$orderBy = 'write_time desc';
				break;
			case 3:
				$orderBy = 'confirm_time desc';
				break;
			case 4:
			case -1:
				$orderBy = 'cancel_time desc';
				break;
			default:
				echo json_encode($this ->defaultData);exit;
				break;
		}
		$whereArr['status ='] = $status;
		$whereArr['expert_id ='] = $this ->expert_id;
		
		if (!empty($contract_code)) {
			$whereArr['contract_code ='] = $contract_code;
		}
		if (!empty($guest_name)) {
			$whereArr['guest_name like'] = '%'.$guest_name.'%';
		}
		if (!empty($ordersn)) {
			$whereArr['order_sn ='] = $ordersn;
		}
		if (!empty($starttime)) {
			$whereArr['addtime >='] = $starttime;
		}
		if (!empty($endtime)) {
			$whereArr['addtime <='] = $endtime.' 23:59:59';
		}
		if (!empty($expert_name)) {
			$whereArr['expert_name like'] = '%'.$expert_name.'%';
		}
		
		$data = $this ->contract_model ->getContractData($whereArr);
		//echo $this ->db ->last_query();exit;
		echo json_encode($data);
	}
	
	//查看申请记录
	public function seeApplyContract()
	{
		$this->view('admin/b2/see_apply_contract_view');
	}
	
	public function getApplyContract()
	{
		$whereArr = array(
				'expert_id =' =>$this ->expert_id
		);
		
		$data = $this ->contract_model ->getContractApplyT33($whereArr);
		echo json_encode($data);
	}
	
	//分配合同管家
	public function chioceExpert()
	{
		$expertId = intval($this ->input ->post('expert_id'));
		$contractId = intval($this ->input ->post('launch_id'));
		if (empty($expertId) || $expertId < 0)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择管家');
		}
		
		$expertData = $this ->expert_model ->row(array('id' =>$expertId));
		if (empty($expertData))
		{
			$this ->callback ->setJsonCode(4000 ,'管家不存在');
		}
		
		$dataArr = array(
			'expert_id' =>$expertId,
			'expert_name' =>$expertData['realname']
		);
		
		$status = $this ->db ->where('id' ,$contractId) ->update('b_contract_launch' ,$dataArr);
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	//申请作废合同
	public function abandoned()
	{
		$id = intval($this ->input ->post('id'));
		$remark = trim($this ->input ->post('remark' ,true));
		if (empty($remark)) {
			$this ->callback ->setJsonCode(4000 ,'请填写作废理由');
		}
		
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		
		$dataArr = array(
				'status' =>-1,
				'cancel_time' =>date('Y-m-d H:i:s'),
				'remark' =>$remark,
				'expert_id' =>$this ->expert_id,
				'expert_name' =>$expertData['realname']
		);
		//var_dump($id);exit;
		$status = $this ->db ->where('id' ,$id) ->update('b_contract_launch' ,$dataArr);
		//echo $this ->db ->last_query();
		if ($status == false) {
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		} else {
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
	}
	
	
	//管家发起合同
	public function launchContract()
	{
		$id = intval($this ->input ->get('id'));
		$first = intval($this->input->get('first'));//1表示首次进入，需要先查看|上传签名
		//先判断管家是否保存了签名
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		if ($first == 1)
		{
			//进入管家签名页面	
			$this ->load ->view('admin/b2/expert_sign_view' ,array('contractId' =>$id ,'sign_pic'=>$expertData['sign_pic']));
		}
		else 
		{
			$contractData = $this ->contract_model ->row(array('id' =>$id));
			
			$this ->load_model('union_model');
			
			$unionData = $this ->union_model ->row(array('id' =>$contractData['union_id']));
			
			$unionChapter = $this ->db ->where('union_id' ,$contractData['union_id']) ->get('b_contract_chapter') ->row_array();
			$banguChapter = $this ->db ->where('id' ,1) ->get('b_contract_chapter_bangu') ->row_array();
			
			$dataArr = array(
					'contractData' =>$contractData,
					'unionData' =>$unionData,
					'unionChapter' =>$unionChapter,
					'banguChapter' =>$banguChapter,
					'expertData' =>$expertData
			);
			$this ->load ->view('admin/b2/launch_contract_view' ,$dataArr);
		}
	}
	
	//管家签名
	public function imgHandle()
	{
		$base64 = trim($this ->input ->post('str' ,true));
		
		//保存用户签名
		$img = base64_decode($base64);
		$url = './file/expert_sign/';
		if (!file_exists($url)) {
			mkdir($url ,0777 ,true);
		}
		
		$filename = md5(time().mt_rand(10, 99)).".jpg";
		$status = file_put_contents($url.$filename, $img);
		if ($status === false)
		{
			$this ->callback ->setJsonCode(4000 ,'上传失败');
		}
		
		
		$dataArr = array(
				'sign_pic' =>'/file/expert_sign/'.$filename
		);
		$status = $this ->db ->where('id' ,$this ->expert_id) ->update('u_expert' ,$dataArr);
		if ($status ==  false)
		{
			$this ->callback ->setJsonCode(4000 ,'上传失败');
		}
		else
		{
			$this ->callback ->setJsonCode(2000 ,'上传成功');
		}
	}
	
	//查看合同
	public function seeLaunchContract()
	{
		$code = trim($this ->input ->get('code')); //合同编号
		$contractData = $this ->contract_model ->row(array('contract_code' =>$code));
		if (!empty($contractData))
		{
			if ($contractData['type'] == 1)
			{
				$detailArr = $this ->contract_model ->getAbroadContract($code);
			}
			else
			{
				$detailArr = $this ->contract_model ->getDomesticContract($code);
			}
			
			
			$time = strtotime($detailArr['start_time']);
			$detailArr['start_year'] = date('Y' ,$time);
			$detailArr['start_month'] = date('m' ,$time);
			$detailArr['start_day'] = date('d' ,$time);
			
			$hour = date('H:i:s' ,$time);
			if ($hour == '23:59:59') {
				$detailArr['start_time'] = 24;
			} else {
				$detailArr['start_time'] = date('H' ,$time);
			}
			
			
			$time = strtotime($detailArr['end_time']);
			$detailArr['end_year'] = date('Y' ,$time);
			$detailArr['end_month'] = date('m' ,$time);
			$detailArr['end_day'] = date('d' ,$time);
			
			$hour = date('H:i:s' ,$time);
			if ($hour == '23:59:59') {
				$detailArr['end_time'] = 24;
			} else {
				$detailArr['end_time'] = date('H' ,$time);
			}
			$detailArr['pay_time'] = date('Y-m-d' ,strtotime($detailArr['pay_time']));
			
			$fileData = $this ->contract_model ->getContractFile($contractData['id']);
			
			$expertData = $this ->expert_model ->row(array('id' =>$contractData['expert_id']));
			
			$dataArr = array(
					'detailArr' =>$detailArr,
					'fileData' =>$fileData,
					'expertData' =>$expertData
			);
			//echo $this ->db ->last_query();
			$this ->load ->view('admin/b2/see_launch_contract_view' ,$dataArr);
		}
	}
	
	//申请合同
	public function applyContract()
	{
		$num = intval($this ->input ->post('num'));
		$type = intval($this ->input ->post('type'));
		$reason = trim($this ->input ->post('reason' ,true));
		if ($type != 1 && $type != 2)
		{
			$this ->callback ->setJsonCode(4000 ,'请选择合同类型');
		}
		if ($num < 1)
		{
			$this ->callback ->setJsonCode(4000 ,'请填写合同份数');
		}
		//获取管家信息
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		if (empty($expertData))
		{
			$this ->callback ->setJsonCode(4000 ,'您的信息有误');
		}
		
		//获取营业部信息
		if (!empty($expertData['depart_list']))
		{
			$this ->load_model('admin/t33/b_depart_model' ,'depart_model');
			$departData = $this ->depart_model ->getDepartInData(rtrim($expertData['depart_list'] ,',') ,1);
			if (empty($departData))
			{
				$departId = $departData['id'];
				$departName = $departData['name'];
			}
		}
		//var_dump($departData);exit;
		if (empty($departId))
		{
			$departId = $expertData['depart_id'];
			$departName = $expertData['depart_name'];
		}
		
		$dataArr = array(
				'num' =>$num,
				'type' =>$type,
				'reason' =>$reason,
				'expert_id' =>$this ->expert_id,
				'expert_name' =>$expertData['realname'],
				'depart_id' =>$departId,
				'depart_name' =>$departName,
				'depart_list' =>$expertData['depart_list'],
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'union_id' =>$expertData['union_id'],
				'status' =>0
		);
		
		$status = $this ->db ->insert('b_contract_apply' ,$dataArr);
		if ($status == false) {
			$this ->callback ->setJsonCode(4000 ,'申请合同失败');
		} else {
			$this ->callback ->setJsonCode(2000 ,'申请合同成功');
		}
	}
	
	//添加合同
	public function add()
	{
		$guest_name = trim($this ->input ->post('guest_name' ,true));
		$guest_mobile = trim($this ->input ->post('guest_mobile' ,true));
		$guest_email = trim($this ->input ->post('guest_email' ,true));
		$travelman = trim($this ->input ->post('travelman' ,true));
		$travelnum = intval($this ->input ->post('travelnum'));
		$travel_agency = trim($this ->input ->post('travel_agency' ,true));
		$travel_agency = trim($this ->input ->post('travel_agency' ,true));
		$business_code = trim($this ->input ->post('business_code' ,true));
		$start_year = intval($this ->input ->post('start_year'));
		$start_month = intval($this ->input ->post('start_month'));
		$start_day = intval($this ->input ->post('start_day'));
		$start_time = intval($this ->input ->post('start_time'));
		$end_year = intval($this ->input ->post('end_year'));
		$end_month = intval($this ->input ->post('end_month'));
		$end_day = intval($this ->input ->post('end_day'));
		$end_time = intval($this ->input ->post('end_time'));
		$days = intval($this ->input ->post('days'));
		$nights = trim($this ->input ->post('nights' ,true));
		$adultprice = trim($this ->input ->post('adultprice' ,true));
		$childprice = trim($this ->input ->post('childprice' ,true));
		$serverprice = trim($this ->input ->post('serverprice' ,true));
		$total_travel = trim($this ->input ->post('total_travel' ,true));
		$pay_way = trim($this ->input ->post('pay_way' ,true));
		$pay_time = trim($this ->input ->post('pay_time' ,true));
		$insurance_name = trim($this ->input ->post('insurance_name' ,true));
		$is_buy = intval($this ->input ->post('is_buy'));
		$min_num = intval($this ->input ->post('min_num'));
		$is_agree_contract = trim($this ->input ->post('is_agree_contract' ,true));
		$is_agree_delay = trim($this ->input ->post('is_agree_delay' ,true));
		$is_agree_change = trim($this ->input ->post('is_agree_change' ,true));
		$is_agree_relieve = trim($this ->input ->post('is_agree_relieve' ,true));
		$is_agree_group = trim($this ->input ->post('is_agree_group' ,true));
		$group_travel = trim($this ->input ->post('group_travel' ,true));
		$other_matter = trim($this ->input ->post('other_matter' ,true));
		$copie = intval($this ->input ->post('copie'));
		$mutual_copie = intval($this ->input ->post('mutual_copie'));
		$id = intval($this ->input ->post('contractId'));
		
		
		$contractData = $this ->contract_model ->row(array('id' =>$id));
		//echo $this ->db ->last_query();exit;
		if (empty($contractData) || $contractData['status'] != 0)
		{
			$this ->callback ->setJsonCode(4000 ,'合同不存在，或已领用');
		}
		
		if (empty($guest_name)) {
			$this ->callback ->setJsonCode(4000 ,'请填写客人姓名');
		}
		if (empty($guest_mobile)) {
			$this ->callback ->setJsonCode(4000 ,'请填写客人电话');
		} else {
			if (!regexp('mobile' ,$guest_mobile)){
				$this->callback->setJsonCode ( 4000 ,'请输入正确的客人电话');
			}
		}
// 		if (empty($guest_email)) {
// 			$this ->callback ->setJsonCode(4000 ,'请填写客人邮箱');
// 		}
		if (empty($travelman)) {
			$this ->callback ->setJsonCode(4000 ,'请填旅游者名称');
		}
		if (empty($travelnum)) {
			$this ->callback ->setJsonCode(4000 ,'请填写出游人数');
		}
		if (empty($travel_agency)) {
			$this ->callback ->setJsonCode(4000 ,'请填写旅行社名称');
		}
		if (empty($business_code)) {
			$this ->callback ->setJsonCode(4000 ,'请填写许可证编号');
		}
		
		
		if (empty($start_year) || empty($start_month) || empty($start_day) || empty($start_time)) {
			$this ->callback ->setJsonCode(4000 ,'请填将出发时间填写完整');
		}
		if (empty($end_year) || empty($end_month) || empty($end_day) || empty($end_time)) {
			$this ->callback ->setJsonCode(4000 ,'请填将结束时间填写完整');
		}
		$nowYear = date('Y' ,time())-1;
		if ($start_year < $nowYear || $end_year < $nowYear) {
			$this ->callback ->setJsonCode(4000 ,'请填写正确的年份');
		}
		
		if ($start_month < 10 && strlen($start_month) == 1) {
			$start_month = '0'.$start_month;
		}
		if ($start_day < 10 && strlen($start_day) == 1) {
			$start_day = '0'.$start_day;
		}
		if ($start_time < 10 && strlen($start_time) == 1) {
			$start_time = '0'.$start_time;
		}
		if ($end_day < 10 && strlen($end_day) == 1) {
			$end_day = '0'.$end_day;
		}
		if ($end_month < 10 && strlen($end_month) == 1) {
			$end_month = '0'.$end_month;
		}
		if ($end_time < 10 && strlen($end_time) == 1) {
			$end_time = '0'.$end_time;
		}
		//出发和结束时间
		$starttime = $start_year.'-'.$start_month.'-'.$start_day;
		if ($start_time == '24') {
			$starttime = $starttime.' 23:59:59';
		} else {
			$starttime = $starttime.' '.$start_time.':00:00';
		}
		
		$endtime = $end_year.'-'.$end_month.'-'.$end_day;
		if ($end_time == '24') {
			$endtime = $endtime.' 23:59:59';
		} else {
			$endtime = $endtime.' '.$end_time.':00:00';
		}
		
		//echo $start_day.'----'.$end_time;
		if ($endtime > $endtime) {
			$this ->callback ->setJsonCode(4000 ,'出发时间不可以大于结束时间');
		}
		
		if ($days < 1) {
			$this ->callback ->setJsonCode(4000 ,'请填写出游天数');
		}
		
		$len = strlen($nights);
		if ($len < 1 || $nights < 0) {
			$this ->callback ->setJsonCode(4000 ,'请填写住宿夜晚');
		}
		$len = strlen($adultprice);
		if ($len < 1 || $adultprice < 0) {
			$this ->callback ->setJsonCode(4000 ,'请填写成人价格');
		}
		$len = strlen($childprice);
		if ($len < 1 || $childprice < 0) {
			$this ->callback ->setJsonCode(4000 ,'请填写儿童价格');
		}
		$len = strlen($serverprice);
		if ($len < 1 || $serverprice < 0) {
			$this ->callback ->setJsonCode(4000 ,'请填写导游服务费');
		}
		$len = strlen($total_travel);
		if ($len < 1 || $total_travel < 0) {
			$this ->callback ->setJsonCode(4000 ,'请填费用合计');
		}
		
		if (empty($pay_way)) {
			$this ->callback ->setJsonCode(4000 ,'请填写支付方式');
		}
		if (empty($pay_time)) {
			$this ->callback ->setJsonCode(4000 ,'请填写支付时间');
		}
		
		if($is_buy != 1 && $is_buy != 2 && $is_buy != 3) {
			$this ->callback ->setJsonCode(4000 ,'请选择保险购买方式');
		}
		if ($is_buy == 1 && empty($insurance_name)) {
			$this ->callback ->setJsonCode(4000 ,'请填写保险名称');
		}
		
		if ($min_num < 1) {
			$this ->callback ->setJsonCode(4000 ,'请填写最低成团人数');
		}
		
		if ($is_agree_contract != '同意' && $is_agree_contract != '不同意') {
			$this ->callback ->setJsonCode(4000 ,'是否同意旅社社委托，请填写同意或不同意');
		}
		if ($is_agree_delay != '同意' && $is_agree_delay != '不同意') {
			$this ->callback ->setJsonCode(4000 ,'是否同意延期出团，请填写同意或不同意');
		}
		if ($is_agree_change != '同意' && $is_agree_change != '不同意') {
			$this ->callback ->setJsonCode(4000 ,'是否同意改签其它线路出团，请填写同意或不同意');
		}
		if ($is_agree_relieve != '同意' && $is_agree_relieve != '不同意') {
			$this ->callback ->setJsonCode(4000 ,'是否同意解除合同，请填写同意或不同意');
		}
		
		if ($is_agree_group != '同意' && $is_agree_group != '不同意') {
			$this ->callback ->setJsonCode(4000 ,'是否同意拼团，请填写同意或不同意');
		}
		
		if (empty($group_travel)) {
			$this ->callback ->setJsonCode(4000 ,'请填写拼团旅行社');
		}
		
		if (empty($other_matter)) {
			$this ->callback ->setJsonCode(4000 ,'请填写其它约定事项');
		}
		if (empty($copie)) {
			$this ->callback ->setJsonCode(4000 ,'请填写合同份数');
		}
		if (empty($mutual_copie)) {
			$this ->callback ->setJsonCode(4000 ,'请填写每人持有的合同数量');
		}
		
		$expertData = $this ->expert_model ->row(array('id' =>$this ->expert_id));
		
		$contractArr = array(
				'guest_name' =>$guest_name,
				'guest_mobile' =>$guest_mobile,
				'guest_email' =>$guest_email,
				'num' =>$travelnum,
				'expert_id' =>$this ->expert_id,
				'expert_name' =>$expertData['realname'],
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'is_sign' =>0,
				'union_id' =>$expertData['union_id'],
				'status' =>1,
				'link' =>$this ->createLink()
		);
		$dataArr = array(
				'travelman' =>$travelman,
				'travelnum' =>$travelnum,
				'contract_code' =>$contractData['contract_code'],
				'travel_agency' =>$travel_agency,
				'business_code' =>$business_code,
				'start_time' =>$starttime,
				'end_time' =>$endtime,
				'days' =>$days,
				'nights' =>$nights,
				'adultprice' =>$adultprice,
				'childprice' =>$childprice,
				'serverprice' =>$serverprice,
				'total_travel' =>$total_travel,
				'pay_way' =>$pay_way,
				'pay_time' =>$pay_time,
				'is_buy' =>$is_buy,
				'insurance_name' =>$insurance_name,
				'min_num' =>$min_num,
				'is_agree_contract' =>$is_agree_contract,
				//'contract_travel' =>$contract_travel,
				'is_agree_delay' =>$is_agree_delay,
				'is_agree_change' =>$is_agree_change,
				'is_agree_relieve' =>$is_agree_relieve,
				'is_agree_group' =>$is_agree_group,
				'group_travel' =>$group_travel,
				'other_matter' =>$other_matter,
				'copie' =>$copie,
				'mutual_copie' =>$mutual_copie
		);
		
		$unionChapter = $this ->db ->where('union_id' ,$contractData['union_id']) ->get('b_contract_chapter') ->row_array();
		$banguChapter = $this ->db ->where('id' ,1) ->get('b_contract_chapter_bangu') ->row_array();
		
		$fileArr = array(
				'contract_launch_id' =>$contractData['id'],
				'union_sign' =>empty($unionChapter['union_chapter']) ? '' : $unionChapter['union_chapter'],
				'bangu_sign' =>empty($banguChapter['bangu_chapter']) ? '' : $banguChapter['bangu_chapter']
		);
		
		$status = $this ->contract_model ->insertContract($contractData ,$contractArr ,$dataArr ,$fileArr);
		if ($status === false) {
			$this ->callback ->setJsonCode(4000 ,'发起失败');
		} else {
			echo json_encode(array('code' =>2000 ,'msg' =>'发起成功'));
			//发送短息给客人
			
			$this ->load_model('sms_template_model');
			$template = $this ->sms_template_model ->row(array('msgtype' =>'contract_sign'));
			$content = str_replace("{#ID#}", $contractArr['link'] ,$template['msg']);
			$this ->send_message($guest_mobile ,$content);
			
		}
	}
	
	//重新发送
	public function resendContract()
	{
		$id = intval($this ->input ->post('id'));
		$contractData = $this ->contract_model ->row(array('id' =>$id));
		if (empty($contractData) || $contractData['status'] != 1)
		{
			$this ->callback ->setJsonCode(4000 ,'合同不存在或不在签署中');
		}
		echo json_encode(array('code' =>2000 ,'msg' =>'发送成功'));
		
		$this ->load_model('sms_template_model');
		$template = $this ->sms_template_model ->row(array('msgtype' =>'contract_sign'));
		$content = str_replace("{#ID#}", $contractData['link'] ,$template['msg']);
		$this ->send_message($contractData['guest_mobile'] ,$content);
	}
	
	//生成短连接
	public function createLink()
	{
		$arr = range('a' ,'z');
		$i = 1;
		$code = '';
		for($i ;$i<=6 ;$i++)
		{
			$index = mt_rand(0 ,25);
			$code .= $arr[$index];
		}
		$contractData = $this ->contract_model ->row(array('link' =>$code));
		if (!empty($contractData)) {
			$this ->createLink();
		}
		return $code;
	}
	
	
	
	
	
	
}