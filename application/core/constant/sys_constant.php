<?php
class sys_constant {
	const URATE = 100;//人民币对U币的倍率
	//网站倍率
	const PRAISE_RATE = 100;//好评的倍率
	//注册赠送积分
	const REGISTER_JIFEN = 0;
	//首页路径
	const INDEX_URL = '/';//首页链接
	const LINE_DEFAULT_PIC = '/static/img/page/no_line.png';//没有线路数据时默认显示图片
	const EXPERT_DEFAULT_PIC = '/static/img/page/no_expert.png';// 管家列表显示图片
	
	//数据字典表
	const DICT_TRANSPORT = 'DICT_TRANSPORT';//交通方式
	const DICT_HOTEL_STAR = 'DICT_HOTEL_STAR';//星际酒店
	const DICT_TRIP_TYPE = 'DICT_TRIP_TYPE';//出游方式
	const DICT_SHOPPING = 'DICT_SHOPPING';//购物情况
	const DICT_POST = 'DICT_POST';//岗位
	const DICT_JOP_TYPE = 'DICT_JOP_TYPE';//从业类型
	const DICT_EXPERT_GRADE = 'DICT_EXPERT_GRADE';//专家等级
	const DICT_CERTIFY_WAY = 'DICT_CERTIFY_WAY';//证件类型
	const DICT_CATERING = 'DICT_CATERING';//餐饮要求
	const DICT_ROOM_REQUIRE = 'DICT_ROOM_REQUIRE';//用房要求
	const DICT_ANOTHER_CHOOSE = 'DICT_ANOTHER_CHOOSE';//单项服务
	const DICT_DOMESTIC_CERTIFICATE_TYPE = 'DICT_DOMESTIC_CERTIFICATE_TYPE';//国内证件类型
	const DICT_ABROAD_CERTIFICATE_TYPE = 'DICT_ABROAD_CERTIFICATE_TYPE'; //国外证件类型 
	
	const SEARCH_AGE_CODE = 'CON_USER_AGE';//年龄搜索code值
	const PAGE_SIZE = 10;//c端分页的分页条数
	const B_PAGE_SIZE = 15;//T33端分页的分页条数
	const TRAVEL_PAGE_SIZE = 18;//游记列表分页数条数
	const EXPERTIENCE_PAGE_SIZE = 5;//c端体验师分页条数
	const A_PAGE_SIZE = 10;//a端分页的分页条数
	const ACID = 2;//地区表(area)中国的ID
	const AIID = 1;//地区表(area)国际的ID
	
	//搜索条件（天数，年龄，价格）
	const CON_USER_AGE = 'CON_USER_AGE';//pc端用户年龄搜索
	const CON_LINE_PRICE = 'CON_LINE_PRICE ';//线路价格搜索
	const CON_LINE_DAY = 'CON_LINE_DAY';//线路天数
	const CON_EXPERT_AGE = 'CON_EXPERT_AGE';//管家年龄
	const CON_CUSTOME_PRICE = 'CON_CUSTOME_PRICE';//定制单价格
	const CON_CUSTOME_DAY = 'CON_CUSTOME_DAY';//定制单天数
	
	/*******短信模板*********/
	const member_register = 'member_register';//用户注册
	const expert_refuse_msg = 'expert_refuse_msg';//管家注册拒绝
	const expert_through_msg = 'expert_through_msg';//管家注册申请通过
	const expert_stop_msg = 'expert_stop_msg';//平台终止与管家合作
	const supplier_through_msg = 'supplier_through_msg';//平台通过供应商注册申请
	const supplier_refuse_msg = 'supplier_refuse_msg';//平台拒绝供应商申请
	const supplier_stop_msg = 'supplier_stop_msg';//平台终止与供应商合作
	const line_order_msg1 = 'line_order_msg1';//会员下单
	const expert_back = 'expert_back';//恢复与管家合作
	const supplier_back = 'supplier_back';//恢复与供应商合作
	const expert_register_msg = 'expert_register_msg';//管家注册
	const admin_refund = 'admin_refund';//平台退单
	const order_detail_through = 'order_detail_through';//平台通过收款申请
	const order_detail_refuse = 'order_detail_refuse';//平台拒绝收款申请
	const order_refund_refuse = 'order_refund_refuse';//平台拒绝退款
	const order_refund_through = 'order_refund_through';// 平台通过退款
	const dynamic_password = 'dynamic_password';//会员动态登陆验证码
	const auto_reg = 'auto_reg';//定制单自动注册
	const expert_update = 'expert_update';//管家注册
	const supplier_agent_rate = 'supplier_agent_rate';//平台调整供应商管理费率
	const order_confirm = 'order_confirm';//平台确认收款,通知供应商
	const expert_order = 'expert_order';//用户下单通知管家
	const order_leave = 'order_leave';//用户下单通知供应商
	const expert_order_pay = 'expert_order_pay';//用户付款通知管家
	const supplier_order_pay = 'supplier_order_pay';//用户付款通知供应商
	const expert_order_confirm = 'expert_order_confirm';//平台确认收款通知管家
	const order_refund_through_expert = 'order_refund_through_expert';//平台通过退款通知管家
	const order_refund_refuse_expert = 'order_refund_refuse_expert';//平台拒绝退款通知管家
	/********短信模板结束*********/
	
	const around_city_name = '深圳';//默认周边城市深圳
	const attrname = '内容标签'; //线路搜索的标签
	
	const expert_retrieve_pass = 'expert_retrieve_pass';//管家找回密码
	const supplier_retrieve_pass = 'supplier_retrieve_pass';//供应商找回密码
	const reg_findpwd = 'reg_findpwd';//会员找回密码
	
	const STARTCITY = '深圳市';
	
	//默认头像
	const DEFAULT_PHOTO = '/file/c/img/face.png';
	//注册送温泉活动
	const WX_REG_PL="reg_pl";
}
