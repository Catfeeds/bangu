<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站地图</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/line_list.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
</head>
<body>
	<div>
		<!-- 头部 -->
	<?php $this->load->view('common/header'); ?>
	<!-- 头部轮播图 -->
		<div class="lunbo">
			<div class="img_banner">
				<!-- 轮播图信息结束 -->
				 <div class="img_list">
	              <?php foreach ($banner_list as $key=>$val):?>
	              <a href="<?php echo $val['link'];?>"target="_blank">
					<img src="<?php echo $val['pic'];?>">
	              </a>

	              <?php endforeach;?>
            </div>
			</div>
		</div>
		<!-- 头部轮播图结束 -->
		<div class="container clear">
			<div class="weizhi">
				<p>
					您的位置： <a href="/">首页</a> <span class="right_jiantou">></span> <a
						href="/index/site_map">网站地图</a> <span class="right_jiantou">></span>
				</p>
			</div>
			 <div class="containerContext" style=" padding-bottom: 50px;">
				<div class="travelNav">
					<ul class="travelNavList clear">
						<li style="font-size: 18px;color:#8f9c00;" class="travelNavListAll travelNavListButton">我是游客</li>
					</ul>
					<div class="travelNavSelect">
						<div class="travelLabel clear">
							<div class="travelLabelTitle">
								<span style="font-size:14px;">帮游会员:</span>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('register');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 16px;">注册</h5></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('login');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 16px;">登录</h5></a>
							</div>

						</div>
					</div>
					<div class="travelNavSelect">
						<div class="travelLabel clear">
							<div class="travelLabelTitle">
								<span style="font-size:14px;">我要旅游:</span>
							</div>
							<div class="travelLabelTitle">
                                                            <!-- 将gn改为guonei/-->
								<a href="<?php echo base_url('guonei/');?>" target="_blank"><h2 style="color:#8f9c00; font-size: 14px;">国内游</h2></a>
							</div>
							<div class="travelLabelTitle">
                                                            <!-- 将cj改为chujing/-->
								<a href="<?php echo base_url('chujing/');?>" target="_blank"><h2 style="color:#8f9c00; font-size: 14px;">出境游</h2></a>
							</div>
							<div class="travelLabelTitle">
                                                            <!-- 将zb改为zhoubian/-->
								<a href="<?php echo base_url('zhoubian/');?>" target="_blank"><h2 style="color:#8f9c00; font-size: 14px;">周边游</h2></a>
							</div>
							<div class="travelLabelTitle">
                                                            <!-- 将zt改为zhuti/-->
								<a href="<?php echo base_url('zhuti/');?>" target="_blank"><h2 style="color:#8f9c00; font-size: 14px;">主题游</h2></a>
							</div>
							<div class="travelLabelTitle">
                                                            <!-- 将dzy改为dzy/-->
								<a href="<?php echo base_url('dzy/');?>" target="_blank"><h2 style="color:#8f9c00; font-size: 14px;">定制游</h2></a>
							</div>
						</div>
					</div>
					<div class="travelNavSelect">
						<div class="travelLabel clear">
							<div class="travelLabelTitle">
								<span style="font-size:14px;">旅游管家:</span>
							</div>
							<div class="travelLabelTitle">
                                                            <!--将guanj改为guanjia\n-->
								<a href="<?php echo base_url('guanjia\/');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">管家/专家列表</h3></a>
							</div>
							<div class="travelLabelTitle">
								<a href="http://bangu.com/line/line_list-t-1.html" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">售卖产品</h3></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('dzy');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">定制记录</h3></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('travels/travels_list');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">个人游记</h3></a>
							</div>
						</div>
					</div>
					<div class="travelNavSelect">
						<div class="travelLabel clear">
							<div class="travelLabelTitle">
								<span style="font-size:14px;">游记攻略:</span>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('yj');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">游记列表</h3></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('travels/travels_list');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">写游记</h3></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('travels/travels_list');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">最热门游记线路</h3></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('travels/travels_list');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">最新游记线路</h3></a>
							</div>
						</div>
					</div>
					<div class="travelNavSelect">
						<div class="travelLabel clear">
							<div class="travelLabelTitle">
								<span style="font-size:14px;">会员中心:</span>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('order_from/order/line_order');?>" target="_blank"><h4 style="color:#8f9c00; font-size: 14px;">我的订单</h4></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/member/myshare');?>" target="_blank"><h4 style="color:#8f9c00; font-size: 14px;">我的分享</h4></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/member/mycustom');?>" target="_blank"><h4 style="color:#8f9c00; font-size: 14px;">我的定制单</h4></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/travel/index');?>" target="_blank"><h4 style="color:#8f9c00; font-size: 14px;">我的游记</h4></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/member/invoice');?>" target="_blank"><h4 style="color:#8f9c00; font-size: 14px;">我的发票</h4></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/member/integral');?>" target="_blank"><h4 style="color:#8f9c00; font-size: 14px;">我的积分</h4></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/member/comment');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">我的点评</h3></a>
							</div>
						</div>
					</div>
						<div class="travelNavSelect">
							<div class="travelLabel clear">
								<div class="travelLabelTitle">
									<span style="font-size:14px;">我的资料:</span>
								</div>
								<div class="travelLabelTitle">
									<a href="<?php echo base_url('base/member/profile');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">基本资料</h3></a>
								</div>
								<div class="travelLabelTitle">
									<a href="<?php echo base_url('base/member/updata_password');?>" target="_blank"><h3 style="color:#8f9c00; font-size: 14px;">修改密码</h3></a>
								</div>
							</div>
					  </div>
					<div class="travelNavSelect">
						<div class="travelLabel clear">
							<div class="travelLabelTitle">
								<span style="font-size:14px;">帮游助手:</span>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/member/collect');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 14px;">我的收藏</h5></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/coupon');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 14px;">我的优惠券</h5></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/system/message');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 14px;">站内消息</h5></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/customer_service');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 14px;">我的咨询</h5></a>
							</div>
							<div class="travelLabelTitle">
								<a href="<?php echo base_url('base/customer_service/complaint');?>" target="_blank"><h5 style="color:#8f9c00; font-size: 14px;">投诉维权</h5></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 尾部 -->
		</div>
<?php $this->load->view('common/footer'); ?>
</body>
</html>




