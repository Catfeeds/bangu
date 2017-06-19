<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_custom extends UC_NL_Controller {
	public $pageNew = 1;
	public $whereArr = array(
			'e.status' =>2,
 			'c.status' =>3,
 			'ca.isuse' =>1
	);
	public $dataArr = array();

	public function __construct() {
		parent::__construct ();
	//	set_error_handler('customError');
		$this ->load_model ('customize_model');
		$this ->load_model('common/u_destinations_model' ,'dest_model');
	}
	public function index($url='')
	{
		//解析url地址并将搜索条件保存到数组中
		$this ->analyticalUrl(rtrim($url,'.html'));
		//目的地的名称与ID同时存在则以ID优先
		if (isset($this ->whereArr['endplace']) && isset($this ->whereArr['destName']))
		{
			unset($this ->whereArr['destName']);
		}
		//获取搜索价格
		$this ->load_model('search_line_price_model' ,'price_model');
		$this ->dataArr['priceArr'] = $this ->price_model ->all(array('type' =>2));
		//获取定制数据
		//var_dump($this ->whereArr);
		$customArr = $this ->customize_model ->get_customize_data($this ->whereArr ,$this ->pageNew ,12);
		//echo $this ->db ->last_query();
		//var_dump($customArr['customData']);
		//分页
		$this ->getPageStr($customArr['count'] ,$url);
		$this ->dataArr['customData'] = $customArr['customData'];
		//月份的链接
		$this ->dataArr['monthUrl'] = $this ->createUrl($url, 'm' ,'p');
		$this ->dataArr['priceUrl'] = $this ->createUrl($url, 'pr' ,'p');
		$this ->dataArr['destUrl'] = $this ->createUrl($url, 'd' ,'dn' ,'p');
		$this ->getSeo($url);
		$this->load->view ( 'line/line_custom_view' ,$this ->dataArr);
	}
	
	/*
	 * /line/line_custom/index_p-2_m-8_pr-200-4000_d-235_dn-深圳.html
	 * p:分页
	 * m:月份
	 * pr:价格，小的-大的
	 * d:目的地ID
	 * dn:目的地名称,汉字要用urldecode转换
	 */
	
	/**
	 * @method 生成url地址
	 * @param unknown $url  地址栏的url参数部分
	 * @param unknown $type  参数的字母代号,如价格：pr
	 * @param string  $type1  
	 */
	protected function createUrl($url ,$type ,$type1='' ,$type2='')
	{
		$urlArr = explode('_',$url);
		$urlStr = '';
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			if ($firstStr == 'dn')
			{
				$val = 'dn-'.urldecode($parameterArr[0]);
			}
			if ($type != $firstStr && $type1 != $firstStr && $type2 != $firstStr)
			{
				$urlStr = $urlStr.'_'.$val;
			}
		}
		return '/dzy/'.$urlStr;
	}
	/**
	 * @method seo关键词与描述
	 * @param unknown $url
	 */
	protected function getSeo($url)
	{
		$month = '';
		$price = '';
		$destName = '';
		$urlArr = explode('_',$url);
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			switch($firstStr)
			{
				case 'm':
					$month = empty($parameterArr[0]) ? '' :intval($parameterArr[0]).'月份出发';
					break;
				case 'pr':
					$minPrice = empty($parameterArr[0]) ? 0 : intval($parameterArr[0]);
					$maxPrice = empty($parameterArr[1]) ? 0 : intval($parameterArr[1]);
					if ($minPrice == 0 && $maxPrice > 0)
					{
						$price = $maxPrice.'元以下';
					} 
					elseif ($minPrice >0 && $maxPrice ==0)
					{
						$price = $minPrice.'元以上';
					}
					else 
					{
						$price = $minPrice.'-'.$maxPrice.'元';
					}
					break;
				case 'dn':
					$destName = empty($parameterArr[0]) ? '' : '('.urldecode($parameterArr['0']).')';
					break;
			}
		}
		if (empty($month) && empty($price) && empty($destName))
		{
			$this ->dataArr['title'] = '定制游_定制旅游线路_个性旅游-帮游旅行网';
			$this ->dataArr['description'] = '帮游旅游网数万名资深旅游管家为您和公司量身定制优质而个性的旅游线路，为您提供定制旅游线路、景点、价格、攻略等全面而有个性的定制旅游服务';
		}
		else 
		{
			$this ->dataArr['title'] = $month.$price.$destName.'个人定制旅游线路列表—帮游旅行网';
			$this ->dataArr['description'] = '帮游旅行网为广大出游朋友提供'.$month.$price.$destName.'个人定制旅游线路列表分享，大家可以用以做参考，以便定制最适合自己的旅游线路';
		}
	}
	
	/**
	 * @method 解析url地址
	 * @param unknown $url  地址栏的url参数部分
	 */
	protected function analyticalUrl($url)
	{
		$urlArr = explode('_',$url);
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			switch($firstStr)
			{
				case 'p':
					$this ->pageNew = empty($parameterArr[0]) ? 1 :intval($parameterArr[0]);
					break;
				case 'm':
					$this ->searchMonth($parameterArr);
					break;
				case 'pr':
					$this ->searchPrice($parameterArr);
					break;
				case 'd':
					$this ->searchDest($parameterArr);
					break;
				case 'dn':
					//$this ->searchDestName($parameterArr);
					$this ->dataArr['destName'] = urldecode($parameterArr['0']);
					break;
			}
		}
	}
	
	/**
	 * @method 根据目的地名称搜索
	 * @param unknown $parameterArr
	 */
	protected function searchDestName($parameterArr)
	{
		if (!empty($parameterArr['0']))
		{
			$name = urldecode($parameterArr['0']);
			$destData = $this ->dest_model ->all(array('kindname like' =>$name.'%' ,'level <='=>3 ,'level >='=>2));
			if (empty($destData))
			{
				$this ->whereArr['destName'] = array(0);
			}
			else 
			{
				foreach($destData as $val)
				{
					$this ->whereArr['destName'][] = $val['id'];
				}
			}
			$this ->dataArr['destName'] = $name;
		}
		
	}
	
	/**
	 * @method 目的地搜索，以目的地的ID
	 * @param unknown $parameterArr
	 */
	protected function searchDest($parameterArr)
	{
		if (!empty($parameterArr['0']))
		{
			$this ->whereArr['endplace'] = array(intval($parameterArr['0']));
			$this ->dataArr['destid'] = intval($parameterArr['0']);
		}
	}
	
	/**
	 * @method 月份搜索
	 * @param unknown $parameterArr
	 */
	protected function searchMonth($parameterArr)
	{
		if (!empty($parameterArr['0']))
		{
			$this ->whereArr['c.month'] = intval($parameterArr['0']);	
			$this ->dataArr['month'] = $this ->whereArr['c.month'];
		}
	}
	/**
	 * @method 价格搜索
	 * @param unknown $parameterArr
	 */
	protected function searchPrice($parameterArr)
	{
		$minPrice = empty($parameterArr['0']) ? 0 : intval($parameterArr['0']);
		$maxPrice = empty($parameterArr['1']) ? 0 : intval($parameterArr['1']);
		if ($minPrice > 0)
		{
			$this ->whereArr['c.budget >'] = $minPrice;
		}
		if ($maxPrice >0)
		{
			$this ->whereArr['c.budget <'] = $maxPrice;
		}
		$this ->dataArr['minprice'] = $minPrice;
		$this ->dataArr['maxprice'] = $maxPrice;
	}
	
	/**
	 * @method 分页
	 * @param unknown $page
	 * @param unknown $count
	 */
	protected function getPageStr ($count ,$url)
	{
		$this->load->library ( 'page' );
		$config['pagesize'] = 12;
		$config['page_now'] = $this ->pageNew;
		$config['pagecount'] = $count;
		$config['base_url'] = $this ->createUrl($url ,'p').'_p-';
		$config['suffix'] = '.html';
		$this->page->initialize ( $config );
	}

	//私人定制页  // url: srdz/c-3_e-4.html
	public function custom_user_info ($url = '')
	{
		if (!empty($url))
		{
			$urlArr = explode('-', $url);
			if (!empty($urlArr[0]) && !empty($urlArr[1]))
			{
				switch($urlArr[0])
				{
					case 'c': //定制单ID
						$customid = intval($urlArr[1]);
						break;
					case 'e'://管家ID
						$expertid = intval($urlArr[1]);
						break;
				}
			}
		}
		$custom_type = '';
		if (!empty($customid))
		{
			//存在定制单样例
			$customArr = $this ->customize_model ->getCustomizeDetail($customid);
			if (!empty($customArr))
			{
				$customArr = $customArr[0];
			}
		}
		elseif  (!empty($expertid))
		{
			//指定管家
			$this ->load_model('expert_model');
			$customArr = $this ->expert_model ->row(array('id' =>$expertid) ,'arr' ,'' ,'nickname,small_photo,satisfaction_rate,total_score,id as expert_id');
			
			//首页快速定制
			$customArr['cityname'] = $this ->input ->post('startcity' ,true); //出发城市名称
			$customArr['startplace'] = intval($this ->input ->post('customCityId')); //出发城市ID
			$customArr['custom_type'] = $this ->input ->post('custom_type' ,true);//定制类型
			$customArr['startdate'] = $this ->input ->post('startdate' ,true);//出行日期
			$customArr['endplace'] = intval($this ->input ->post('customDestId'));//目的地ID
		}
		else 
		{
			//首页快速定制
			$customArr['cityname'] = $this ->input ->post('startcity' ,true); //出发城市名称
			$customArr['startplace'] = intval($this ->input ->post('customCityId')); //出发城市ID
			$customArr['custom_type'] = $this ->input ->post('custom_type' ,true);//定制类型
			$customArr['startdate'] = $this ->input ->post('startdate' ,true);//出行日期
			$customArr['endplace'] = intval($this ->input ->post('customDestId'));//目的地ID
		}
		//出发城市
		if (empty($customArr['cityname']) || empty($customArr['startplace']))
		{
			$customArr['cityname'] = $this ->session ->userdata('city_location');
			$customArr['startplace'] = $this ->session ->userdata('city_location_id');
		}
		//目的地
		$destData = array();
		$parentId = 0;
		$parentName = '';
		$destTwoIdArr = array();
		$destArr = array();
		if (!empty($customArr['endplace']))
		{
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$whereArr = array(
					'in' =>array('id' =>$customArr['endplace'])
			);
			$destData = $this ->dest_base_model ->getDestBaseAllData($whereArr);
			
			if ($customArr['custom_type'] != '周边游')
			{
				$parentId = '';
				foreach($destData  as $v)
				{
					if ($v['level'] == 2) 
					{
						$parentId .= $v['id'].',';
						$destTwoIdArr[] = $v['id'];
					}
					else 
					{
						$destArr[] = $v;
					}
				}
			}
			else 
			{
				$destArr = $destData;
			}
		}
		$this->load_model ( 'common/u_dictionary_model', 'dictionary_model' );
		//出游方式
		$traffic = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_TRIP_TYPE);
		//单项服务
		$choose = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_ANOTHER_CHOOSE);
		//酒店星级
		$hotel = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_HOTEL_STAR);
		//购物自费项目
		$shopping = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_SHOPPING);
		//用餐要求
		$catering= $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_CATERING);
		//用房要求
		$room = $this ->dictionary_model ->getDictCodeLower(sys_constant::DICT_ROOM_REQUIRE);
		$data = array(
			'traffic' =>$traffic,
			'choose' =>$choose,
			'hotel' =>$hotel,
			'shopping' =>$shopping,
			'catering' =>$catering,
			'room' =>$room,
			'custom_type' => $custom_type,
			'customArr' =>$customArr,
			'destData' =>$destArr,
			'parentName' =>$parentName,
			'parentId' =>$parentId,
			'destTwoIdArr' =>$destTwoIdArr
		);
		$this ->load ->view('line/custom_user_info_view' ,$data);
	}

	/**
	 * @method 生成定制单
	 * @author jiakairong
	 * @since  2015-11-05
	 */
	function createCustom() {
		$this->load->library ( 'callback' );
		$this ->load_model('member_model');
		$this ->load_model('expert_model');
		$postArr = $this ->security ->xss_clean($_POST);
		foreach($postArr as &$val) {
			$val = trim($val);
		}
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$userid = $this ->session ->userdata('c_userid');
		if  (empty($userid))
		{
			//验证手机号，和验证码
			$status = $this ->judgeMobileCode($postArr['mobile'] ,$postArr['code']);
			if ($status !== true) {
				$this->callback->setJsonCode ( 4000 ,$status);
			}
		}
		else 
		{
			$this->load->helper ( 'regexp' );
			if (!regexp('mobile' ,$postArr['mobile'])) {
				$this->callback->setJsonCode ( 4000 ,"请输入正确的手机号");
			}
		}

		//验证管家
		$is_assign = 0;
		$expert_id = 0;
		if (!empty($postArr['expert_id'])) {
			$expertData = $this ->expert_model ->row(array('id' =>intval($postArr['expert_id']) ,'status' =>2) ,'arr' ,'' ,'id');
			if (empty($expertData)) {
				$this->callback->setJsonCode ( 4000 ,'您选择的管不存在');
			} else {
				$is_assign = 1;
				$expert_id = intval($postArr['expert_id']);
			}
		}
		
		//验证数据
		if (empty($postArr['startcityId'])) {
			$this->callback->setJsonCode ( 4000 ,'请选择出发城市');
		}
		//目的地
		if (empty($postArr['destTwoId'])) {
			$this->callback->setJsonCode ( 4000 ,'请您依次选择目的地');
		} else {
			if (empty($postArr['expert_dest_id'])) {
				$destid = trim($postArr['destTwoId'] ,',');
			} else {
				$destid = trim($postArr['expert_dest_id'] ,',');
			}
		}
		
		$destData = $this ->getDestPid($destid);
		$destid = $destData['destIds'];
		$destArr = explode(',' ,$destid);
		if (empty($postArr['trip_way'])) {
			$this->callback->setJsonCode ( 4000 ,'请选择出游方式');
		} elseif ($postArr['trip_way'] == '单项服务' || $postArr['trip_way'] == '自由行') {
			if (empty($postArr['another_choose'])) {
				$this->callback->setJsonCode ( 4000 ,'请选择多项服务');
			} else {
				$another_choose = trim($postArr['another_choose'] ,',');
			}
		} else {
			$another_choose = '';
		}

		switch($postArr['datetype']) {
			case 1:
				if (empty($postArr['startdate'])) {
					$this->callback->setJsonCode ( 4000 ,'请选择出行日期');
				} else {
					$date = date('Y-m-d' ,time());
					if ($postArr['startdate'] < $date) {
						$this->callback->setJsonCode ( 4000 ,'出发日期不可在今日之前');
					}
				}
				$month = date('m' ,strtotime($postArr['startdate']));
				break;
			case 2:
				if (empty($postArr['estimatedate'])) {
					$this->callback->setJsonCode ( 4000 ,'请填写出行日期');
				} else {
					$month = 0;
				}
				break;
			default:
				$this->callback->setJsonCode ( 4000 ,'请选择出行日期类型');
				break;
		}
 		if (empty($postArr['budget'])) {
			$this->callback->setJsonCode ( 4000 ,'请填写人均预算');
		}
		if (empty($postArr['days'])) {
			$this->callback->setJsonCode ( 4000 ,'请填写出游时长');
		}
		if (intval($postArr['total_people']) < 1) {
			$this->callback->setJsonCode ( 4000 ,'请填写总人数');
		} else {
			$total_people = intval($postArr['total_people']);
		}

		if (intval($postArr['people']) < 1) {
			$this->callback->setJsonCode ( 4000 ,'请填写成人数量');
		}
		$people = $postArr['people'] + $postArr['childnum'] + $postArr['childnobednum'] + $postArr['oldman'];
		if (abs($total_people - $people) > 0.01) {
			$this->callback->setJsonCode ( 4000 ,'人数不相符');
		}
		
		if (empty($postArr['linkname'])) {
			$this->callback->setJsonCode ( 4000 ,'请填写联系人');
		}
		//验证是否登陆
		
		$memberArr = array();
		if ($userid == false) {
			
			$memberData = $this ->member_model ->getMemberLogin($postArr['mobile']);
			if (!empty($memberData)) {
				//已注册则为其自动登陆
				$this->loginSuccess($memberData[0]);
				$userid = $memberData[0]['mid'];
				
			} else {
				//会员注册信息
				$memberArr = $this ->registerInfo($postArr['mobile'], $postArr['linkname']);
			}
		}
		
		//定制单信息数组
		$customArr = array(
				'member_id' =>$userid,
				'user_type' =>0,
				'addtime' =>$time,
				'days' =>intval($postArr['days']),
				'custom_type' =>$postArr['destOne'],
				'total_people' =>intval($postArr['total_people']),
				'people' =>intval($postArr['people']),
				'childnum' =>intval($postArr['childnum']),
				'childnobednum' =>intval($postArr['childnobednum']),
				'oldman' =>intval($postArr['oldman']),
				'roomnum' =>$postArr['roomnum'],
				'room_require' =>$postArr['room_require'],
				'budget' =>intval($postArr['budget']),
				'startplace' =>intval($postArr['startcityId']),
				'service_range' =>$postArr['service_range'],
				'trip_way' =>$postArr['trip_way'],
				'another_choose' =>$another_choose,
				'catering' =>$postArr['catering'],
				'isshopping' =>$postArr['isshopping'],
				'hotelstar' =>$postArr['hotelstar'],
				'linkname' =>$postArr['linkname'],
				'linkphone' =>$postArr['mobile'],
				'linkweixin' =>$postArr['weixin'],
				'is_assign' => $is_assign,
				'expert_id' => $expert_id,
				'status' => 0,
				'question' =>$postArr['startplace'].'到'.$destData['destName'].$postArr['days'].'日游',
				'pic' =>'/file/b2/upload/img/customize.png',
				'endplace' =>$destid,
				'month' =>ltrim($month,'0')
			);
		if ($postArr['datetype'] == 1) 
		{
			$customArr['startdate'] = $postArr['startdate'];
		}
		elseif ($postArr['datetype'] == 2)
		{
			$customArr['estimatedate'] = $postArr['estimatedate'];
		}
		//var_dump($destArr);exit;
		$status = $this ->customize_model ->createCustom($customArr ,$destArr ,$memberArr);
		if ($status == false) {
			$this->callback->setJsonCode ( 4000 ,'下单失败，请稍后重试');
		} else {
			echo json_encode(array('code' =>2000 ,'msg' =>$status['customId']));
			$this ->session ->unset_userdata('mobile_code');
			$this ->session ->unset_userdata('new_member');
			if (!empty($memberArr)) {
				$this ->session ->set_userdata('new_member' ,'1');
				//注册送优惠券
				//$this ->member_coupon(1, $status['userid']);
				//给用户发送短信提示
				$this->load->model ( 'sms_template_model' ,'sms_model' );
				$msg = $this ->sms_model ->row(array('msgtype' =>sys_constant::auto_reg));
				$content = str_replace("{#LOGINNAME#}" ,$memberArr['loginname'] ,$msg['msg']);
				$content = str_replace("{#PASSWORD#}", 123456 ,$content);
				$this ->send_message($postArr['mobile'] ,$content);
				//自动登陆
				$memberArr['mid'] = $status['userid'];
				$this->loginSuccess($memberArr);
			}
		}
	}
	
	/**
	 * @method 获取目的地的上级id
	 * @param unknown $destId
	 */
	protected function getDestPid($destId) {
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		
		$whereArr = array(
				'in' =>array('id' =>$destId)
		);
		$destData = $this ->dest_base_model ->getDestBaseAllData($whereArr);
		if (empty($destData)) {
			$this->callback->setJsonCode ( 4000 ,'目的地选择不正确');
		} else {
			$destName = '';
			foreach($destData as $val) {
				if ($val['level'] == 3) {
					$destId .= ','.$val['pid'];
				}
				$destName .= $val['name'].'、';
			}
			$destName = trim($destName ,'、');
		}
		//echo implode(',',array_unique(explode(',',$destId)));
		return array(
				'destName' =>rtrim($destName ,'、'),
				'destIds' =>implode(',',array_unique(explode(',',$destId)))
		);
	} 
	
	/**
	 * @method 会员注册信息
	 * @author jiakairong
	 * @since  2015-11-05
	 * @param unknown $mobile 手机号
	 * @param unknown $name  用户姓名
	 */
	private function registerInfo($mobile ,$name) {

		$nickname = substr($mobile ,0,3).'****'.substr($mobile,7,10);
		
		$time = date('Y-m-d H:i:s' ,$_SERVER['REQUEST_TIME']);
		$userArea = $this ->getUserArea();
		return array(
			'loginname'=>$mobile,
			'nickname' =>$nickname,
			'truename' =>$name,
			'pwd'=>md5(123456),
			'mobile'=>$mobile,
			'jointime'=> $time,
			'logintime' =>$time,
			'litpic' =>sys_constant::DEFAULT_PHOTO,
			'jifen' =>sys_constant::REGISTER_JIFEN,
			'register_channel' =>'PC',
			'loginip' =>$userArea['ip'],
			'province' =>$userArea['province'],
			'city' =>$userArea['city'],
		);
	}
	//获取会员的地址
	public function getUserArea()
	{
		$this->load->library ( 'GetCityIp' );
		$this->load_model('area_model');
		$province_id = 0;
		$city_id = 0;
		$ip = $this ->getip();
		//$ip = '61.244.148.166';
		$areaArr = $this ->getcityip ->getIPLoc_sina($ip);
		if (!empty($areaArr))
		{
			//$country = empty($areaArr['country']) ? '' : $areaArr['country'];
			$province = empty($areaArr['province']) ? '' : $areaArr['province'];
			$city = empty($areaArr['city']) ? '' : $areaArr['city'];
			if ($province == '香港')
			{
				$city = $province;
			}
			if (!empty($province))
			{
				$areaData = $this ->area_model ->row(array('name like' =>$province.'%' ,'level' =>2));
				if (!empty($areaData))
				{
					$province_id = $areaData['id'];
				}
			}
			if (!empty($city))
			{
				$areaData = $this ->area_model ->row(array('name like' =>$city.'%' ,'level' =>3));
				if (!empty($areaData))
				{
					$city_id = $areaData['id'];
				}
			}
		}
		return array(
				'ip' =>$ip,
				'province' =>$province_id,
				'city' =>$city_id
		);
	}
	/**
	 * @method 获取目的地
	 * @author jiakairong
	 * @since  2015-11-05
	 */
	public function getDestData()
	{
		$this ->load_model('dest/dest_base_model' ,'dest_base_model');
		$destData = $this ->dest_base_model ->all(array('level <=' =>3) ,'' ,'arr' ,'pid,id,kindname as name');
		$destArr = array();
		foreach($destData as $val)
		{
			if ($val['pid'] == 0)
			{
				$destArr['top'][] = $val;
			}
			else
			{
				$destArr[$val['pid']][] = $val;
			}
		}
		unset($destData);
		//周边游
		$destArr['top'][] = array('id' =>'trip' ,'name' =>'周边游');
		echo json_encode($destArr);
	}
	/**
	 * 通过出发城市ID获取周边目的地
	 * @author jkr
	 */
	public function getRoundTrip()
	{
		$this ->load_model('common/cfg_round_trip_model' ,'trip_model');
 		$cityId = intval($this ->input ->post('cityId'));
 		
 		$whereArr = array(
 				'cfg.startplaceid =' =>$cityId,
 				'cfg.isopen =' =>1,
 				'd.isopen =' =>1
 		);
 		$tripArr = $this ->trip_model ->getRoundTripCustom($whereArr);
 		echo json_encode($tripArr);
	}
	
	//定制成功页面
	public function custom_success($id=0) {
		$userid = $this ->session ->userdata('c_userid');
		$data = $this ->customize_model ->getCustomDetail($id ,$userid);
		if (empty($data)) {
			header("Location:/line/line_custom/custom_user_info");exit;
		} else {
			$data = $data['0'];
			$this ->load_model('dest/dest_base_model' ,'dest_base_model');
			$whereArr = array(
					'in' =>array('id' =>$data['endplace']),
					'level =' =>3
			);
			$destData = $this ->dest_base_model ->getDestBaseAllData($whereArr);
			
			$destName = '';
			if (!empty($destData)) {
				foreach($destData as $val) {
					
					$destName .= $val['name'].'、';
				}
			}
			$data['destName'] = rtrim($destName ,'、');
			$this->load->view ( 'line/custom_success' ,$data);
		}
	}
}