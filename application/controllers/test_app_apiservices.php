<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Test_app_apiservices extends CI_Controller {
	private $resultJSON;
	private $result_code;
	private $result_msg;
	private $result_data = array();
	private $callback;
	private $webserviceArr;
	public function __construct() {
		parent::__construct ();
		//$this->db = $this->load->database ( "default", TRUE );
		$this->callback = $this->input->get ( "callback" );
		header ( "content-type:text/html;charset=utf-8" );
		$this->apiserviceArr = array(
				"dataType" => "jsonp", 
				"method" => 'get', 
				"format" => 'callback({"msg":"msgData","code":"codeData","data":{"field":"value"}})', 
				"desc" => "callback：自定义的回调名；<br />msg：通信消息；<br />code：通信代码（2000表示获取数据成功，4001表示数据为空）；<br />data：通信数据内容（只有 code是2000的时候才有数据）" 
		);
	}
	public function index() {
		$data = array(
				"dataType" => $this->webserviceArr["dataType"], 
				"method" => $this->webserviceArr['method'], 
				"format" => $this->webserviceArr["format"], 
				"desc" => $this->webserviceArr["desc"], 
				"webservice" => array(
						array(
								"serviceName" => "筛选管家",
								"urlName" => "cfgm_find_expert?cityname=深圳&qy_id=0&e_grade=4&sex=0&dest_id=10425,10335&label=160,163",
								"serviceDesc" => "管家id(expert_id),管家小图片(small_photo)，管家真实名字(realname)，成交量(volume)，专注(expert_dest)，服务积分(total_score)，满意度(satisfaction_rate)，等级(grade)，最新申请的线路名(newest_apply_line)，线路id(line_id)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "cityname",
												"desc" => "所在地城市名(必备)"
										),
										array(
												"field" => "qy_id",
												"desc" => "区域id(可选)"
										),
										array(
												"field" => "e_grade",
												"desc" => "等级(可选: 1管家;2初级专家;3中级专家;4高级专家;5明星专家)"
										),
										array(
												"field" => "sex",
												"desc" => "性别(可选 2女;1男)"
										),
										array(
												"field" => "dest_id",
												"desc" => "线路始发地(多选 可选)"
										),
										array(
												"field" => "sort",
												"desc" => "排序(可选)"
										),
										array(
												"field" => "label",
												"desc" => "标签(多选(160,170) 可选)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "管家详情(主表)",
								"urlName" => "cfgm_expert_detail?expertid=1",
								"serviceDesc" => "管家id(id)，头像(small_photo)，登陆名称(login_name)，性别(sex)，真实名字(realname)，擅长线路(expert_dest)，满意度(satisfaction_rate)，总积分(total_score)，专家宣言(talk)，专家头衔(title),专家等级(grade)，成交量(volume)，评价(comments)，咨询(ask)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "expertid",
												"desc" => "专家ID(必备)"
										)
								)
						),
						array(
								"serviceName" => "管家详情(售卖线路)",
								"urlName" => "cfgm_sale_line?expertid=1",
								"serviceDesc" => "专家id(expert_id)，等级(grade)，线路id(line_id)，线路名称(linename)，线路图片(mainpic)，线路价格(lineprice)，满意度(satisfyscore)，总积分(total_score)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "expertid",
												"desc" => "专家ID(必备)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "管家详情(成交量)",
								"urlName" => "cfgm_volume_record?expertid=1",
								"serviceDesc" => "产品名称(productname)，成交时间(finishdatetime)，用户昵称(nickname)，用户头像(litpic)，行程（startcity->overcity），出发时间(day)，人数(people)，人均(avg_price)，头部成交量统计(volume)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "expertid",
												"desc" => "专家ID(必备)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "管家详情(咨询)",
								"urlName" => "cfgm_ask_record?expertid=1",
								"serviceDesc" => "咨询内容(content)，时间(addtime)，回复内容(replycontent)，线路名称(linename)，用户昵称(nickname)，头部咨询记录统计(ask)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "expertid",
												"desc" => "专家ID(必备)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "管家详情(评价)",
								"urlName" => "cfgm_comment_record?expertid=1",
								"serviceDesc" => "时间(addtime)，内容(content)，等级(level)，用户昵称(nickname)，用户头像(litpic)，头部评论统计(comments)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "expertid",
												"desc" => "专家ID(必备)"
										),
										array(
												"field" => "level",
												"desc" => "评价等级(默认显示全部,1:)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "管家详情(个人荣誉)",
								"urlName" => "cfgm_person_honor?expertid=1",
								"serviceDesc" => "个人荣誉(honor)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "expertid",
												"desc" => "专家ID(必备)"
										)
								)
						),  
						array(
								"serviceName" => "看产品(热门地区)", 
								"urlName" => "cfgm_hot_area", 
								"serviceDesc" => "目的地id(dest_id),目的地名称(name)，目的地图片(pic)，目的地线路统计(linenum)", 
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})', 
								"para" => array() 
						), 
						array(
								"serviceName" => "线路详情(主表)",
								"urlName" => "cfgm_line_detail?lineid=118",
								"serviceDesc" => "获取线路id(id)，线路名字(linename)，线路价钱(lineprice)，市场价(marketprice),满意度(satisfyscore)，图片路径(filepath)，成交量(volume)，特色(features)，总积分(all_score)，均积分(avg_score),标签数组(lineattr),是否已收藏(is_sc),是否已分享(is_fx)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "lineid",
												"desc" => "线路ID(必备)"
										),
										array(
												"field" => "number",
												"desc" => "token(可选)"
										)
								)
						),
						array(
								"serviceName" => "浏览时长",
								"urlName" => "cfgm_browse_long?lineid=118&number=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "lineid",
												"desc" => "线路ID(必备)"
										),
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "线路详情(查看行程)",
								"urlName" => "cfgm_line_notice?lineid=118",
								"serviceDesc" => "第几天(day)，标题(title)，介绍(jieshao)，早餐(breakfirst)，午餐(lunch)，晚餐(supper)，交通(transport)，住宿(hotel)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "lineid",
												"desc" => "线路ID(必备)"
										)
								)
						),
						array(
								"serviceName" => "预定须知",
								"urlName" => "cfgm_line_info?lineid=118",
								"serviceDesc" => "费用说明(费用包含(feeinclude)，费用不包含(feenotinclude))，预定须知(book_notice)，签证(visa_content)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "lineid",
												"desc" => "线路ID(必备)"
										)
								)
						),
						array(
								"serviceName" => "用户评价",
								"urlName" => "cfgm_user_comments?lineid=58&level=1",
								"serviceDesc" => "用户头像(litpic)，用户昵称(nickname)，评论内容(content)，评论时间(addtime)，评论等级(level)，手机(mobile)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "lineid",
												"desc" => "线路ID(必备)"
										),
										array(
												"field" => "level",
												"desc" => "评价等级(0全部 1失望  2不满意 3一般 4满意 5非常满意 可选)"
										), 
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "选择出发日期(线路套餐)",
								"urlName" => "cfgm_line_suit?lineid=118",
								"serviceDesc" => "套餐id(id)，套餐名字(suitname)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "id",
												"desc" => "线路ID(必备)"
										)
								)
						),
						array(
								"serviceName" => "选择出发日期(价格套餐日历)",
								"urlName" => "cfgm_price_date?suitid=62",
								"serviceDesc" => "日期(day)，成人价格(adult_price)，儿童价格(kid_price)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "suitid",
												"desc" => "套餐ID(必备)"
										)
								)
						),
						array(
								"serviceName" => "分享(线路详情页)",
								"urlName" => "cfgm_sc_fx",
								"serviceDesc" => "post表单",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										), 
										array(
												"field" => "fxid",
												"desc" => "分享线路id(如果当前是收藏功能，则必备)"
										),
										array(
												"field" => "fxcontent",
												"desc" => "分享内容(可选)"
										),
										array(
												"field" => "from",
												"desc" => "分享位置(可选)"
										)
										
								)
						),
						array(
								"serviceName" => "收藏(线路详情页)",
								"urlName" => "cfgm_sc_line?number=&scid=",
								"serviceDesc" => "日期(day)，成人价格(adult_price)，儿童价格(kid_price)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "scid",
												"desc" => "收藏线路id(必备)"
										),
								)
						),
						array(
								"serviceName" => "用户注册",
								"urlName" => "cfgm_user_register?mobile=&password=",
								"serviceDesc" => "表单提交,get方式",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "mobile",
												"desc" => "手机号(必备)"
										),
										array(
												"field" => "password",
												"desc" => "密码(必备)"
										)
								)
						),
						array(
								"serviceName" => "用户登录",
								"urlName" => "cfgm_user_login?mobile=&password=",
								"serviceDesc" => "表单提交，get方式",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "mobile",
												"desc" => "手机号(必备)"
										),
										array(
												"field" => "password",
												"desc" => "密码(必备)"
										) 	
								)
						), 
						array(
								"serviceName" => "订单详情",
								"urlName" => "cfgm_suit_line_detail?suitid=14&lineid=58&day=2015-06-09",
								"serviceDesc" => "(数组line): 线路id(line_id),线路名(linename);(数组suit): 套餐id(suit_id),出发日期(day),成人价格(adultprice),儿童价格(adultprice);(数组expert): 专家id(expert_id),专家名(realname),头像(small_photo),等级(grade)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "lineid",
												"desc" => "线路ID(必备)"
										)
								)
						),
						array(
								"serviceName" => "提交订单",
								"urlName" => "cfgm_add_order?number=&line_id=&expert_id=&suitid=&indent_day=&adult_price=&child_price&adult_number=&child_number=&all_price=&linkman=&linkman_phone=",
								"serviceDesc" => "这是一个表单提交，get方式",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "预定成功",
								"urlName" => " cfgm_book_success?orderid=659",
								"serviceDesc" => "订单id(id),订单编号(ordersn),用户昵称(nickname),管家名字(realname),头像(small_photo),手机号(mobile)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										)
								)
						), 
						array(
								"serviceName" => "用户订单评论页面",
								"urlName" => "cfgm_order_show",
								"serviceDesc" => "订单id(id),题目(productname),出发日期(usedate),金额(total_price),订单图片(litpic)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										),
										array(
												"field" => "number",
												"desc" => "token(必备)"
										) 
								)
						),
						array(
								"serviceName" => "提交评价表单",
								"urlName" => "cfgm_submit_comment",
								"serviceDesc" => "post 方式",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
										
								)
						),
						
// 						array(
// 								"serviceName" => "订单详情(下拉选择日期价格)",
// 								"urlName" => "cfgm_suit_date_price?suitid=14&lineid=58&day=2015-06-09",
// 								"serviceDesc" => "线路id(line_id),线路名(linename),套餐id(suit_id),出发日期(day),成人价格(adultprice),儿童价格(adultprice),",
// 								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
// 								"para" => array(
// 										array(
// 												"field" => "lineid",
// 												"desc" => "线路ID(必备)"
// 										),
// 										array(
// 												"field" => "suitid",
// 												"desc" => "套餐ID(必备)"
// 										),
// 										array(
// 												"field" => "day",
// 												"desc" => "出发日期(必备)"
// 										)
// 								)
// 						),
						array(
								"serviceName" => "我定制(定制案例展示)",
								"urlName" => "cfgm_my_customize",
								"serviceDesc" => "定制id(c_id),目的地(endplace),游玩天数(days),主题(theme),出发地(startplace),人均预算(budget),人数(people),专家id(expert_id),专家等级(grade),专家真实名字(realname),专家头像(small_photo),管家id(expert_id)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										
								)
						),
						array(
								"serviceName" => "定制单详情(我定制 > 定制案例展示)",
								"urlName" => "cfgm_customize_info?cid=20",
								"serviceDesc" => "目的地(endplace),游玩天数(days),主题(theme),出发地(startplace),人均预算(budget),人数(people),专家id(expert_id),专家等级(grade),专家真实名字(realname),专家头像(small_photo),管家id(expert_id),方案介绍( fangan: 第几天(day),是否早餐(breakfirsthas),是否午餐(lunchhas),是否晚餐(supperhas),酒店(hotel),介绍(jieshao))",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "cid",
												"desc" => "定制单id(必备)"
										) 
								)
						),
						array(
								"serviceName" => "旅游主题、出游方式等(量身定制)",
								"urlName" => "cfgm_play_method?type=hotel",
								"serviceDesc" => "旅游主题(id,name),其他(dict_id,description);",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "type",
												"desc" => "type值为hotel或method或theme或shop或meal(必备)"
										)
								)
						),
						array(
								"serviceName" => "量身定制",
								"urlName" => "cfgm_ls_customize?theme=11&days=2&meal=60&from=深圳&method=41&people=2&date=2015-06-29&budget=111111&end=香港&hotel=13&isshop=57&beizhu=测试&linkname=测试&mobile=15322222222&weixin=",
								"serviceDesc" => "表单提交，post方式",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "theme",
												"desc" => "定制主题(必备)"
										),
										array(
												"field" => "from",
												"desc" => "出发城市(文字 必备)"
										),
										array(
												"field" => "method",
												"desc" => "出游方式(必备)"
										),
										array(
												"field" => "people",
												"desc" => "人数(必备)"
										),
										array(
												"field" => "date",
												"desc" => "出发日期(必备)"
										),
										array(
												"field" => "days",
												"desc" => "游玩天数(必备)"
										),
										array(
												"field" => "budget",
												"desc" => "人均预算(必备)"
										),
										array(
												"field" => "end",
												"desc" => "目的地(文字 必备)"
										),
										array(
												"field" => "hotel",
												"desc" => "酒店星级(必备)"
										),
										array(
												"field" => "isshop",
												"desc" => "购物自费项目(可选)"
										),
										array(
												"field" => "beizhu",
												"desc" => "备注(可选)"
										),
										array(
												"field" => "meal",
												"desc" => "用餐要求(可选)"
										),
										array(
												"field" => "linkname",
												"desc" => "联系人(必备)"
										),
										array(
												"field" => "mobile",
												"desc" => "手机号(必备)"
										),
										array(
												"field" => "weixin",
												"desc" => "微信号(可选)"
										)
								)
						), 
						array(
								"serviceName" => "我的",
								"urlName" => "cfgm_walk_count?number=",
								"serviceDesc" => "用户昵称(nickname),用户头像(litpic),待支付数目(wait_pay),待出行数目(wait_walk),待评价数目(wait_comment),退款中数目(wait_tk)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(  
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "我的(我的定制)",
								"urlName" => "cfgm_my_line?number=",
								"serviceDesc" => "定制id(id)，线路名(theme)，人均预算(budget)，人数(people)，线路图片(pic)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "我的(游记攻略)",
								"urlName" => "cfgm_my_travel?number=",
								"serviceDesc" => "封面(cover_pic)，题目(title)，时间(addtime)，用户名(loginname)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(可选)"
										)
								)
						),
						array(
								"serviceName" => "游记攻略详情",
								"urlName" => "cfgm_travel_detail?number=&tnid=1",
								"serviceDesc" => "封面(cover_pic),题目(title),标签(tags),总价(total_price),天数(days),吃(chi),住(zhu),行(xing),购(gou),吃图片(chi_pic),住图片(zhu_pic),行图片(xing_pic),购图片(gou_pic)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "tnid",
												"desc" => "游记id(必备)"
										)
								)
						),
						array(
								"serviceName" => "我的(我的分享)",
								"urlName" => "cfgm_my_share?number=",
								"serviceDesc" => "线路id(line_id)，分享内容(content)，线路名(linename)，线路图片(pic)，分享位置(location)，分享时间(addtime)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "我的(我的收藏)",
								"urlName" => "cfgm_my_collection?number=",
								"serviceDesc" => "线路id(line_id)，线路名(linename)，线路图片(mainpic)，天数(lineday)，价格(lineprice)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "我的(浏览记录)",
								"urlName" => "cfgm_browse_record?number=",
								"serviceDesc" => "线路id(id),线路名(linename)，线路图片(mainpic)，好评率(satisfyscore)，价格(lineprice)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "我的(全部、待支付、待出行、待评价、退款 )",
								"urlName" => "cfgm_order_status?number=&code=",
								"serviceDesc" => "全部、待支付、待出行、待评价(订单id(mo_id),订单号(mo_ordersn),平台确认准予出行时间(mo_finishdatetime),是否付款(mo_ispay),订单状态(mo_status),线路名(linename),线路图片(litpic),人数(people),出发日期(day),总价(total_price),支付状态(pay_status),订单状态(order_status));退款(订单id(mo_id),mo_status,退款id(r_id),线路名(linename),线路图片(litpic),人数(people),出发日期(day),总价(total_price),退款状态(order_status));按钮说明(status=0 编辑订单和取消订单;status=1 付款和取消订单;status=2 and mb_od.ispay=1 付款和退单;status=2 and mb_od.ispay=2 退单;status=3 退单;status=4 退单; status=5 评论和投诉)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(用ad123帐号登录 必备)"
										),
										array(
												"field" => "code",
												"desc" => "订单状态code(0:全部; 1:待支付; 2:待出行; 3:待评价; 4:退款)"
										)
								)
						),
						array(
								"serviceName" => "编辑订单(按钮操作 显示订单详情)",
								"urlName" => "cfgm_xs_order?number=",
								"serviceDesc" => "订单编号(ordersn),去支付按钮(如果  status>=1&&ispay=0),订单状态(order_status),线路名(productname),线路图片(litpic),出发城市(cf_city),日期(usedate),总金额(total_price),成人(dingnum),儿童(childnum),游客id(t_id),游客名字(t_name),成人类型(t_isman),身份证号(t_number),电话(t_phone),生日(t_birth)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "bj_id",
												"desc" => "编辑订单id(必备)"
										)
								)
						),
						array(
								"serviceName" => "退单/投诉详情页",
								"urlName" => "cfgm_tk_detail?number=",
								"serviceDesc" => "订单状态(退款中:status=-3; 已投诉:status=7),线路名(productname),线路图片(litpic),人数(people),订单金额(total_price),出发日期(usedate),手机号(linkmobile),退款金额(amount),退款理由(reason),投诉理由(reason)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "tk_id",
												"desc" => "退款订单id(必备)"
										),
										array(
												"field" => "ts_id",
												"desc" => "投诉订单id(必备)"
										)
								)
						),
						array(
								"serviceName" => "取消订单、申请退单、评价订单、投诉(按钮操作)",
								"urlName" => "cfgm_action_order?number=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),array(
												"field" => "qx_id",
												"desc" => "取消订单的id"
										),
										array(
												"field" => "td_id",
												"desc" => "退单的id"
										),
										array(
												"field" => "reason",
												"desc" => "退单的理由"
										),
										array(
												"field" => "total_price",
												"desc" => "退单的金额"
										),
										array(
												"field" => "mobile",
												"desc" => "退单的手机号"
										),
// 										array(
// 												"field" => "card",
// 												"desc" => "退单的银行卡号"
// 										),
// 										array(
// 												"field" => "bank",
// 												"desc" => "退单的银行名称"
// 										),
										array(
												"field" => "pj_id",
												"desc" => "评价订单的id"
										),
										array(
												"field" => "lineid",
												"desc" => "评价订单的线路id(隐藏框)"
										),
										array(
												"field" => "expertid",
												"desc" => "评价订单的专家id(隐藏框)"
										),
										array(
												"field" => "content",
												"desc" => "评价订单的内容"
										),
										array(
												"field" => "dy",
												"desc" => "评价订单的导游"
										),
										array(
												"field" => "xc",
												"desc" => "评价订单的行程"
										),
										array(
												"field" => "cy",
												"desc" => "评价订单的餐饮"
										),
										array(
												"field" => "jt",
												"desc" => "评价订单的交通"
										),
										array(
												"field" => "zy",
												"desc" => "评价订单的专业"
										),
										array(
												"field" => "fw",
												"desc" => "评价订单的服务"
										),
										array(
												"field" => "pics",
												"desc" => "评价订单的图片"
										),
										array(
												"field" => "expert_content",
												"desc" => "评价订单的专家评价内容"
										),
										array(
												"field" => "ts_id",
												"desc" => "投诉订单的id"
										),
// 										array(
// 												"field" => "c_type",
// 												"desc" => "投诉订单的供应商或专家类型(1:专家;2:供应商)"
// 										),
										array(
												"field" => "content",
												"desc" => "投诉订单的内容"
										),
										array(
												"field" => "mobile",
												"desc" => "投诉订单的手机号"
										)
								)
						), 
						array(
								"serviceName" => "编辑、插入、删除游客信息(编辑订单按钮)",
								"urlName" => "cfgm_action_tourist",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										),
										array(
												"field" => "scid",
												"desc" => "删除游客信息的id"
										),
										array(
												"field" => "bjid",
												"desc" => "编辑游客信息的id"
										),
										array(
												"field" => "ykname",
												"desc" => "编辑(添加)游客信息的名字"
										),
										array(
												"field" => "idcard",
												"desc" => "编辑(添加)游客的身份证号"
										), 
										array(
												"field" => "isman",
												"desc" => "编辑(添加)游客的是否成人(isman=1是成人，isman=2是儿童)"
										),
										array(
												"field" => "mobile",
												"desc" => "编辑(添加)游客的手机号"
										),
										array(
												"field" => "birth",
												"desc" => "编辑(添加)游客的出生日期"
										) 
								)
						),
						array(
								"serviceName" => "支付接口",
								"urlName" => "cfgm_pay_order",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										)
								)
						),
						array(
								"serviceName" => "支付成功",
								"urlName" => "cfgm_pay_success",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										), 
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										),
										array(
												"field" => "all_price",
												"desc" => "付款总金额"
										),
										array(
												"field" => "bank",
												"desc" => "打款银行"
										),
// 										array(
// 												"field" => "card",
// 												"desc" => "银行卡号)"
// 										)
								)
						),
						array(
								"serviceName" => "显示用户资料(修改资料)",
								"urlName" => "cfgm_show_info",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "修改资料",
								"urlName" => "cfgm_update_info?number=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "nickname",
												"desc" => "用户昵称(可选)"
										),
										array(
												"field" => "email",
												"desc" => "邮箱(可选)"
										),
										array(
												"field" => "truename",
												"desc" => "真实名字(可选)"
										),
										array(
												"field" => "sex",
												"desc" => "性别(可选)"
										),
										array(
												"field" => "address",
												"desc" => "地址(可选)"
										),
										array(
												"field" => "postcode",
												"desc" => "邮编(可选)"
										),
										array(
												"field" => "sex",
												"desc" => "性别(可选)"
										)
								)
						),
						array(
								"serviceName" => "验证原始密码(修改密码)",
								"urlName" => "cfgm_validate_password?number=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "password",
												"desc" => "原始密码(必备)"
										),
								)
						),
						array(
								"serviceName" => "设置登录密码(修改密码)",
								"urlName" => "cfgm_set_password?number=&mobile=&new_password=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "new_password",
												"desc" => "新密码(必备)"
										),
								)
						),
						array(
								"serviceName" => "重置密码(手机短信验证码)",
								"urlName" => "cfgm_phone_password?mobile=&new_password=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
										array(
												"field" => "new_password",
												"desc" => "新密码(必备)"
										),
								)
						),
						array(
								"serviceName" => "手机短信发送验证码",
								"urlName" => "send_message",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "mobile",
												"desc" => "手机号"
										),
										array(
												"field" => "is",
												"desc" => "值为2为找回密码"
										),
										array(
												"field" => "time",
												"desc" => "发送时间"
										),
								)
						),
						array(
								"serviceName" => "退出",
								"urlName" => "cfgm_user_logout?number=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "跟团服务(所在地行政区域)",
								"urlName" => "cfgm_in_location?cityname=湖南",
								"serviceDesc" => "区域id(a_id),区域名(a_name),城市id(p_id),城市名(p_name)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "cityname",
												"desc" => "所在地城市名"
										)
								)
						),
						array(
								"serviceName" => "跟团服务(管家类型)",
								"urlName" => "cfgm_expert_type",
								"serviceDesc" => "id,等级(grade:1管家,2初级专家,3中级专家,4高级专家,5明星专家),等级头衔(title)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
								)
						),
						array(
								"serviceName" => "跟团服务(产品分类)",
								"urlName" => "cfgm_line_sort?dest=0&more=1",
								"serviceDesc" => "第一层id(f_id),第一层name(f_name),第三层id(th_id),第三层name(th_name)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "dest",
												"desc" => "一级目的地(可选):出境游(0)，国内游(1)，周边游(2)，主题游(3)"
										),
										array(
												"field" => "more",
												"desc" => "更多(值可设置为1)"
										)
										
								)
						),
						array(
								"serviceName" => "切换城市(周边城市)",
								"urlName" => "cfgm_around_city?cityname=深圳",
								"serviceDesc" => "周边城市id(n_id),周边城市名(n_name),所在地id(dest_id),所在地城市名(dest_name)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
									array(
										"field" => "cityname",
										"desc" => "所在地城市名"
									)
								)
						),
						array(
								"serviceName" => "切换城市(热门城市)",
								"urlName" => "cfgm_hot_city?sortid=2",
								"serviceDesc" => "城市id(id),城市名(name)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "sortid",
												"desc" => "1.国际; 2.中国;(默认是中国)"
										)
								)
						),
						array(
								"serviceName" => "城市字母排序",
								"urlName" => "cfgm_sort_city?sortid=2",
								"serviceDesc" => "城市id(id),城市名(name),城市全拼(spell),首字母(szm)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "sortid",
												"desc" => "2.中国;1.国际;(默认是中国)"
										)
								)
						),
						array(
								"serviceName" => "全球城市字母排序",
								"urlName" => "cfgm_all_city",
								"serviceDesc" => "城市id(id),城市名(name),城市全拼(spell),首字母(szm)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "null",
												"desc" => "全球城市全部在，demo_city是国内城市，abro_city是国外城市"
										)
								)
						),
						array(
								"serviceName" => "查找城市",
								"urlName" => "find_city?city=sz",
								"serviceDesc" => "城市id(id),城市名(name)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "city",
												"desc" => "城市名(中文、全拼、简拼)"
										)
								)
						),
						array(
								"serviceName" => "筛选线路",
								"urlName" => "cfgm_find_line?cityname=鞍山&price=2&day=5&dest_id=5,1,10041,16&sort=2",
								"serviceDesc" => "线路id(line_id)，线路名称(linename)，路线图片(mainpic)，线路价钱(lineprice)，评分(satisfyscore)，评论人数(comments)，出行人数(people),销量(volume)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "areaid",
												"desc" => "热门地区id(可选)"
										),
										array(
												"field" => "cityname",
												"desc" => "所在地城市名(可选)"
										),
										array(
												"field" => "price",
												"desc" => "价格区间(0:500以内; 1:500-4000; 2:4000-8000; 3:8000以上; 可选)"
										), 
										array(
												"field" => "day",
												"desc" => "游玩天数(可选)"
										),
										array(
												"field" => "dest_id",
												"desc" => "线路目的地(多选 可选)"
										),
										array(
												"field" => "sort",
												"desc" => "排序(可选)"
										), 
										array(
												"field" => "label",
												"desc" => "标签(多选(160,170) 可选)"
										),
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页显示条数(默认为5 可选)"
										)
								)
						),
						array(
								"serviceName" => "标签选择(适合人气、产品属性、内容标签)",
								"urlName" => "cfgm_line_attr",
								"serviceDesc" => "标签属性id(id),属性名(attrname),是否热门(ishot),父标签id(pid),父标签名(p_name)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array( 
								)
						),
						array(
								"serviceName" => "体验师(体验秀列表)",
								"urlName" => "cfgm_experience_show",
								"serviceDesc" => "体验师(tys_id),体验师头像(tys_photo),线路名(l_name),图片(productpic),价格(total_price),题目(title),游记id(tn_id),一句话(content)",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "page",
												"desc" => "页码(可选)"
										),
										array(
												"field" => "pagesize",
												"desc" => "每页条数(默认为5条 可选)"
										)
								)
						),
						array(
								"serviceName" => "体验师(体验秀详情页)",
								"urlName" => "cfgm_experience_detail?yjid=1",
								"serviceDesc" => "体验师id(tys_id)，体验师头像(tys_photo)，体验师名字(truename)，分享时间(addtime),一句话内容(content),游记题目(title),顶部封面图(cover_pic),吃描述(chi_content),住描述(zhu_content),行描述(xing_content),购描述(gou_content),吃图片数组(chi_pic)，住图片数组(zhu_pic)，行图片数组(xing_pic)，购图片数组(gou_pic))",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "yjid",
												"desc" => "游记id(必备)"
										)
								)
						),
						array(
								"serviceName" => "体验师(个人信息)",
								"urlName" => "cfgm_experience_info?id=4",
								"serviceDesc" => "体验师头像(tys_photo)，体验师名字(truename)，性别(sex),出游次数(order_count),游记篇数(yj_count),游记列表yj_list(游记id:tn_id,图片:cover_pic,游记题目:title,时间:addtime,赞的次数:praise_count,评论次数:pl_count))",
								"format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "id",
												"desc" => "体验师id(必备)"
										)
								)
						),
						array(
								"serviceName" => "专家注册(b2)",
								"urlName" => "cfgm_expert_register?mobile=&password=",
								"serviceDesc" => "表单提交,get方式",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
											
								)
						),
						array(
								"serviceName" => "专家登录(b2)",
								"urlName" => "cfgm_expert_login?mobile=&password=",
								"serviceDesc" => "表单提交，get方式",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
											
								)
						),
						array(
								"serviceName" => "专家登录成功后显示信息",
								"urlName" => "expert_info_show?number=",
								"serviceDesc" => "id,realname,small_photo",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						), 
						array(
								"serviceName" => "订单列表(b2)",
								"urlName" => "cfgm_order_list?number=&code",
								"serviceDesc" => "全部、待支付、待留位、待确认(订单id(mo_id),待取消(0)是否付款(mo_ispay),订单状态(mo_status),线路名(linename),线路图片(litpic),人数(people),出发日期(day),总价(total_price),支付状态(pay_status),订单状态(order_status));退款(订单id(mo_id),mo_status,退款id(r_id),线路名(linename),线路图片(litpic),人数(people),出发日期(day),总价(total_price),退款状态(order_status));按钮说明(status=0 编辑订单和取消订单;status=1 付款和取消订单;status=2 and mb_od.ispay=1 付款和退单;status=2 and mb_od.ispay=2 退单;status=3 退单;status=4 退单; status=5 评论和投诉)",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)",
												"code"=>"0,1,2,3,4"
										)
								)
						),
						array(
								"serviceName" => "订单详情(b2)",
								"urlName" => "cfgm_order_detail?number=&orderid=",
								"serviceDesc" => "订单id(id),编号(ordersn),线路名(productname),出发城市(cityname),出发日期(usedate),成人数量(dingnum),儿童数量(childnum),总价(total_price),费用(agent_fee),联系人(linkman),联系电话(linkmobile),发票(is_fp),支付状态(pay_status)",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										)
								)
						),
						array(
								"serviceName" => "游客信息(订单详情 b2 )",
								"urlName" => "cfgm_tourist_info?number=&orderid=",
								"serviceDesc" => "订单id(mo_id),游客id(t_id),游客名(t_name),游客身份证号(t_idcard)",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "orderid",
												"desc" => "订单id(必备)"
										)
								)
						), 
						array(
								"serviceName" => "定制管理(我 b2 )",
								"urlName" => "cfgm_customize_manage?number=",
								"serviceDesc" => "定制单id(id),出发日期(startdate),预算(budget),购物状态(shop_status),目的地(endplace),游玩天数(days),人数(people),出游方式(play_method)",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										)
								)
						),
						array(
								"serviceName" => "定制单详情(我 b2)",
								"urlName" => "cfgm_customize_detail?number=&cid=",
								"serviceDesc" => "定制单id(c_id),出发日期(startdate)，预算(budget),购物状态(shop_status),目的地(endplace),游玩天数(days),人数(people),游玩方式(play_method),星级酒店(hotel_status),服务范围(service_range),其他服务(other_service)",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "cid",
												"desc" => "定制单id(必备)"
										),
								)
						),
						array(
								"serviceName" => "抢单(我>定制单详情  b2)",
								"urlName" => "cfgm_get_bill?number=&cid=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "cid",
												"desc" => "定制单id(必备)"
										),
								)
						),
						array(
								"serviceName" => "显示资料(我>资料修改  b2)",
								"urlName" => "cfgm_expert_info?number=",
								"serviceDesc" => "专家id(e_id),头像(small_photo),名字(realname),手机(mobile),性别(sex),身份证(idcard),证件图片(idcardpic),擅长线路(business),所在城市(city_name)	",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										), 
								)
						), 
						array(
								"serviceName" => "修改资料(我>资料修改  b2)",
								"urlName" => "expert_update_info?number=&realname=李思敏&mobile=15242621531&sex=0&idcard=456215859548658153&idcard_pic=/file/b2/upload/img/201506051605131433494551.jpg&business=擅长此等业务&city=爱尔巴桑",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "realname",
												"desc" => "名字(必备)"
										),
										array(
												"field" => "mobile",
												"desc" => "手机号(必备)"
										),
										array(
												"field" => "sex",
												"desc" => "性别(必备)"
										),
										array(
												"field" => "idcard",
												"desc" => "证件号码(必备)"
										),
										array(
												"field" => "idcard_pic",
												"desc" => "证件扫描件(必备)"
										),
										array(
												"field" => "business",
												"desc" => "擅长线路(必备)"
										),
										array(
												"field" => "city",
												"desc" => "所在城市(必备)"
										),
								)
						),
						array(
								"serviceName" => "擅长线路(资料修改  b2)",
								"urlName" => "cfgm_line_list?number=",
								"serviceDesc" => "线路id(id),线路名(kindname)",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										), 
								)
						),
						array(
								"serviceName" => "验证原始密码(修改密码  b2)",
								"urlName" => "expert_validate_password?number=&password=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										),
										array(
												"field" => "password",
												"desc" => "原本密码(必备)"
										),
								)
						),
						array(
								"serviceName" => "修改密码(登录修改密码  b2)",
								"urlName" => "expert_set_password?number=&new_password=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										), 
										array(
												"field" => "new_password",
												"desc" => "新密码(必备)"
										),
								)
						),
						array(
								"serviceName" => "手机重设密码(短信验证  b2)",
								"urlName" => "expert_phone_password?mobile=&new_password=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array( 
										array(
												"field" => "mobile",
												"desc" => "手机号(必备)"
										),
										array(
												"field" => "new_password",
												"desc" => "新密码(必备)"
										),
								)
						),
						array(
								"serviceName" => "退出登录(b2)",
								"urlName" => "expert_user_logout?number=",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "token(必备)"
										), 
								)
						),
						array(
								"serviceName" => "QQ三方登录(app)",
								"urlName" => "cfgm_qq_register",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "number",
												"desc" => "openid(必备)",
												"desc" => "token",
												"desc" => "status(从哪里来的)",
												"desc" => "mid(是否绑定用户ID)"
										), 
								)
						),
						array(
								"serviceName" => "量身定制(app)",
								"urlName" => "mo_ls_customize?theme=11&end=湖贝&from=大剧院&method=自由行&people=2&cp=2&cnp=2&olp=2&dayr=2015-09-08&days=10&budget=5000&hotel=五星&isshop=购物&meal=吃喝&beizhu=特色服务&linkname=尼古拉斯赵四&mobile=18671687888&weixin=1b1u",
								"serviceDesc" => "",
								"format" => 'callback({"msg":"success","code":"1","data":{"save_result":"success"}})',
								"para" => array(
										array(
												"field" => "theme",
												"desc" => "定制主题(必备)"
										),
										array(
												"field" => "from",
												"desc" => "出发城市(文字 必备)"
										),
										array(
												"field" => "method",
												"desc" => "出游方式(必备)"
										),
										array(
												"field" => "people",
												"desc" => "人数(必备)"
										),
										array(
												"field" => "date",
												"desc" => "出发日期(必备)"
										),
										array(
												"field" => "days",
												"desc" => "游玩天数(必备)"
										),
										array(
												"field" => "budget",
												"desc" => "人均预算(必备)"
										),
										array(
												"field" => "end",
												"desc" => "目的地(文字 必备)"
										),
										array(
												"field" => "hotel",
												"desc" => "酒店星级(必备)"
										),
										array(
												"field" => "isshop",
												"desc" => "购物自费项目(可选)"
										),
										array(
												"field" => "beizhu",
												"desc" => "备注(可选)"
										),
										array(
												"field" => "meal",
												"desc" => "用餐要求(可选)"
										),
										array(
												"field" => "linkname",
												"desc" => "联系人(必备)"
										),
										array(
												"field" => "mobile",
												"desc" => "手机号(必备)"
										),
										array(
												"field" => "weixin",
												"desc" => "微信号(可选)"
										)
								)
						),
				) 
		);
		$this->load->view ( 'test_app_api_view', $data );
	} 
}
