<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>【帮游旅行网】一帮一游,私人定制旅游管家,让帮游在您的旅途中帮You</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="旅游线路,旅游网,旅游管家,旅游攻略,自助游" />
<meta name="description" content="帮游旅行网首创性地推出一帮一游旅游服务理念，专业旅游管家为您提供私人定制旅游，周边游、主题游、跟团游、自驾游、游记攻略等一对一旅游产品服务，24小时热线400-096-5166。" />

<meta name="baidu-site-verification" content="jguQ2lIhhk" />

<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<script src="http://siteapp.baidu.com/static/webappservice/uaredirect.js" type="text/javascript"></script>

<?php if(in_array(gethostbyname($_SERVER["SERVER_NAME"]),array('192.168.10.202'))): //测试环境（温文斌） ?>
<script type="text/javascript">
uaredirect("http://m.51ubang.com")
</script>
<?php elseif(in_array(gethostbyname($_SERVER["SERVER_NAME"]),array('120.25.217.197'))): //正式环境 （温文斌）?>
<script type="text/javascript">
uaredirect("http://m.1b1u.com")
</script>

<?php endif;?>



<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/plugins/choice_city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />

<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/lubotu.js'); ?>"></script>
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />

<!--[if IE]>

<style> 
.fix_float{ display:none;}

.triangle_right{ display:none;}
</style>

<![endif]-->

<style>
	img{display: block;}
</style>
</head>
<body style=" background:#fff">
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<!-- 头部搜索开始 -->
<div class="container ">
	<div class="main">
		<div class="wrap ">
			<div class="img_banner lubo">
				<!-- 轮播图 -->
				<ul class="lubo_box">
					<?php
						foreach ($rollPic as $key=>$val){
                                                    //var_dump($val);
							if ($key == 0) {
								echo '<li style=" opacity: 1;z-index:1;filter:alpha(opacity=100);"><a href="'.$val['link'].'" target=_blank style="background:url('.$val['pic'].') center top no-repeat"></a></li>';
							} else {
								echo '<li><a href="'.$val['link'].'" target=_blank style="background:url('.$val['pic'].') center top no-repeat"></a></li>';
							}
						}
					?>
				</ul>
				<div id="course">
					<div class="course_tit clear">
						<div class="courseon fl" style="width:132px;">找管家<i class="right_search_bg" style="left:133px;"></i></div>
						<div class="fl" style="left:132px;width:133px;border-left:1px solid #d0d1c4;border-right:1px solid #d0d1c4;"><i class="left_search_bg"></i>看产品<i class="right_search_bg"></i></div>
						<div class="fl" style="left:266px;width:133px;border-right:none;"><i class="left_search_bg" style="left:-7px;"></i>我定制</div>
					</div>
					<div class="course_content">
					<!-- 搜索管家开始 -->
						<div class="course_list">
                                                     <!-- 将guanj改为guanjia/ 魏勇编辑-->
							<form action="/guanjia/" id="search_expert_form" method="post">
								<div class="course_listfont">
									<dl>
										<dd>
											<span class="ie7">所在地区</span>
											<span class="listinput">
												<input type="text" id="expertCityName" name="expertCityName" value="<?php echo $this->session->userdata('city_location') ?>" class="cityName" />
												<input type="hidden" name="expertCityId" value="<?php echo $startcityid?>" id="expertCityId">
											</span>
										</dd>
										<dd>
											<span class="ie7">上门服务</span>
											<span id="visit_service">
												<div class="expertAge_box">
													<div class="expertAge_showbox expert_grade"> 不限 </div>
													<input type="hidden" value="0" name="visit_service" />
													<ul class="expertAge_option">
														<li value="0" class="selected" >不限</li>
														<?php
															foreach($areaArr as $key =>$val) {
																echo '<li data-val="'.$key.'">'.$val.'</li>';
															}
														?>

													</ul>
												</div>
											</span>
										</dd>
										<dd>
											<span class="ie7">管家性别</span>
											<span class="expertSex ie7"><i class="expert_sex_select"></i> 不限</span>
											<span class="expertSex ie7"><i></i> 男</span>
											<span class="expertSex ie7"><i></i> 女</span>
											<input type="hidden" name="sex" value="0" class="expert_sex_value"/>
										</dd>
										<dd>
											<span class="ie7">管家级别</span>
											<span id="expertAge">
												<div class="expertAge_box">
													<div class="expertAge_showbox expert_grade"> 不限 </div>
													<!-- 保存选择的管家级别 -->
													<input type="hidden" value="0" name="grade" class="expert_grade_input" />
													<ul class="expertAge_option" id='selecr'>
														<li value="0" class="selected" >不限</li>
														<?php
															foreach($expertGrade as $key=>$val) {
																echo "<li value='{$key}'>{$val}</li>";
															}
														?>

													</ul>
												</div>
											</span>
										</dd>
										<dd>
											<span class="ie7">擅长产品</span>
											<span class="listinput"><input type="text" id="expertDestName" name="expertDestName" placeholder="请选择" /></span>
											<input type="hidden" name="expertDestId" id="expertDestId">
										</dd>
										<dd>
											<div class="quick_search_button" id="submit_expert_search">
												<span><i></i>搜 索 管 家</span>
											</div>
										</dd>
									</dl>
								</div>
							</form>
						</div>	
						<!-- 搜索管家结束 -->
						<!-- 看产品 -->
						<div class="course_list" id="search_line" style="display: none;">
								<div class="course_listfont">
									<dl>
										<dd>
											<span class="ie7">出发城市</span>
											<span class="listinput" style="margin-right:4px;">
												<input type="text" name="city_name" id="lineCityName"  placeholder="<?php echo $this->session->userdata('city_location') ?>" class="cityName" style="width:85px;"/>
											</span>
											<input type="hidden" name="lineCityId" id="lineCityId">
											<span class="ie7">　目的地</span>
											<span class="listinput">
												<input type="text" placeholder="请输入城市名" name="line_dest" id="lineDestName" class="cityName" style="width:96px; _width:108px;"/>
												<input type="hidden" name="lineDestId" id="lineDestId" />
											</span>
										</dd>
										<dd>
											<span class="ie7">价格区间</span>
											<span id="expertAge">
												<div class="expertAge_box" style="width:265px; z-index:1000;">
													<div class="expertAge_showbox line_price" style="width:278px;background-position:245px 13px;">全部 </div>
													<ul class="expertAge_option eo_line_price" style="width:278px;">
														<li class="selected" min="0" max="0" style="width:265px;">全部</li>
														<?php
															foreach($linePrice as $val) {
																if ($val['minvalue'] <= 0) {
																	echo "<li min='0' max='{$val['maxvalue']}'  style='width:265px;'>{$val['maxvalue']}以下</li>";
																} elseif ($val['maxvalue'] <= 0) {
																	echo "<li min='{$val['minvalue']}' max='0' style='width:265px;'>{$val['minvalue']}以上</li>";
																} else {
																	echo "<li min='{$val['minvalue']}' max='{$val['maxvalue']}' style='width:265px;'>{$val['minvalue']}-{$val['maxvalue']}</li>";
																}
															}
														?>
													</ul>
												</div>
											</span>
										</dd>
									<dd>
										<span class="ie7">旅行天数</span>
											<span id="expertAge">
												<div class="expertAge_box" style="width:265px;">
													<div class="expertAge_showbox line_day_num" style="width:278px;background-position:245px 13px;">全部 </div>
													<ul class="expertAge_option eo_line_day" style="width:278px;overflow-x:visible;">
														<li class="selected" min="0" max="0" style="width:265px;">全部</li>
														<?php
															foreach($lineDay as $val) {
																if ($val['minvalue'] <= 0) {
																	echo "<li min='0' max='{$val['maxvalue']}' style='width:265px;'>{$val['maxvalue']}天</li>";
																} elseif ($val['maxvalue'] <= 0) {
																	echo "<li min='{$val['minvalue']}' max='0' style='width:265px;'>{$val['minvalue']}天</li>";
																} else {
																	echo "<li min='{$val['minvalue']}' max='{$val['maxvalue']}' style='width:265px;'>{$val['minvalue']}-{$val['maxvalue']}天</li>";
																}
															}
														?>
													</ul>
												</div>
											</span>
										</dd>
										<dd style="margin-top:40px;">
											<div class="quick_search_button" id="submit_list_search">
												<span><i></i>搜 索 产 品</span>
											</div>
										</dd>
									</dl>
								</div>
						</div>
						<!-- 我定制 -->
						<div class="course_list" style="display: none;">
							<form action="/srdz" id="custom_form" method="post">
								<div class="course_listfont course_listfont_dz">
									<div id="cursor_list_product">
										<dl>
											<dd>
												<span>定制类型</span>
												<span id="expertAge">
													<div class="expertAge_box" style="width:265px;">
														<input  type="hidden" name="custom_type">
														<div class="expertAge_showbox custom_type_name" style="width:277px;background-position:245px 13px;">请选择</div>
														<ul class="expertAge_option custom_type" style="width:277px;overflow-x:visible;">
															<li value="1" style="width:265px;">出境游</li>
															<li value="2" style="width:265px;">国内游</li>
															<li value="3" style="width:265px;">周边游</li>
														</ul>
													</div>
												</span>
											</dd>
											<dd>
												<span class="ie7">出发城市</span>
												<span class="listinput" style="margin-right:4px;">
													<input type="text" name="startcity" class="input_cx_cfd" id="customCityName" placeholder="请输入城市名"/>
													<input type="hidden" name="customCityId" id="customCityId" />
												</span>
												<span class="ie7">　目的地</span>
												<span class="listinput custom_dest">
													<input type="text" name="dest1" id="custom_abroad" placeholder="请选择目的地" style="width:96px;_width:108px;">
													<input type="text" name="dest2" style="display:none;width:96px;" id="custom_domestic" placeholder="请选择目的地" >
													<input type="text" name="dest3" style="display:none;width:96px;" id="custom_trip" placeholder="请选择目的地" >
												</span>
												<input type="hidden" id="customDestId" name="customDestId" />
											</dd>
											<dd>
												<span class="ie7">预估日期</span>
												<span class="listinput">
												<input class="Wdate input_cx_data" name="startdate" placeholder="YYYY-MM-DD" type="text" id="estimatedate" readonly='readonly' autocomplete="off" style="_width:268px;"/>
												</span>
											</dd>
											<dd style="margin-top:40px;">
												<div class="quick_search_button" onclick="submit_custom();" style="width:150px;margin-left:60px;display:inline-block">
													<span style=" position:relative; left:22px;"><i></i>快 速 定 制</span>
												</div>
                                                                                                <!-- 将/expert/expert_list改为guanjia/ 魏勇编辑-->
												<a href="guanjia/" class="assign_expert" target="_blank">指定管家</a>
											</dd>
										</dl>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 头部搜索结束 -->

<!-- 旅游管家 -->
<?php if (!empty($expertData) && is_array($expertData)): ?>
<div class="layer w_1200 lvyouguanjia" style=" position: relative;">
	<div class="" id="expert_nav">
		<i id="expert_ico"></i>
		<h2>旅游管家 <span>免费帮您策划安排，一对一全程跟进旅程，获取完美服务体验！</span></h2>
	</div>
	<div class="content">
	<!-- 默认显示第一个管家 -->
                <!-- 将guanj改为guanjia,添加后缀.html-->
		<a id="big_img_link" href="<?php echo site_url().'guanjia/'.$expertData[0]['eid'].'.html'?>">
			<img id="current_expert" src="<?php echo site_url('static/img/loading1.gif'); ?>" data-original="<?php echo $expertData[0]['small_photo'] ?>" alt="旅游管家<?php echo $expertData[0]['nickname']?>" />
		</a>
		<div>
			<ul id="list-experts">
				<?php foreach ($expertData as $key => $val): ?>
				<li value="<?php echo $key;?>">
					<a href="<?php echo site_url().'guanjia/'.$val['eid'].'.html'?>" target="_blank">
						<img src="<?php echo base_url('static/img/loading1.gif'); ?>" data-original="<?php echo $val['small_photo']; ?>" alt="旅游管家<?php echo $val['nickname']; ?>" />
					</a>
				</li>
				<?php endforeach; ?>
				<!-- 最后一张咨询更多 -->
				<li>
                                    <!-- guanj改为guanjia/ 这里需要转义-->
					<a href="<?php echo site_url('guanjia\/')?>" target="_blank">
						<img src="<?php echo site_url('static/img/loading1.gif'); ?>" data-original="<?php echo site_url('static/img/zixungengduo_1.png'); ?>" alt="张三" />
					</a>
				</li>
			</ul>
		</div>
		<!-- 默认显示第一个管家 -->
		<div id="profile" class="clear">
			<div class="profile_left_content fl">
				<div class="expert_info">
                                        <!-- guanj改为guanjia,添加后缀.html-->
					<a id="expert_list_link" href='<?php echo site_url('guanjia/'.$expertData[0]['eid'].'.html')?>'>
						<span id='expert_realname'><?php echo $expertData[0]['nickname'] ?></span>
					</a>
					
					
					<span id='expert_grade'><div class="back_5d7">最高级别</div>：
					<i class="expert_grade_dis"><?php $expertData[0]['gradeName'];?>
					
					</i>
					</span>
					<label class="city_txt">
						<span id="city" class="icon_site"><i></i><?php echo $expertData[0]['cityname'] ?></span>
					</label>
					<span class="serve honour_card" id="expert_service"><div class="back_5d7">上门服务</div>：<span class="expert_service_dis"><?php echo $expertData[0]['service_name'];?></span></span>
					<span class="destination" id="expert_destination"><div class="back_5d7">擅长产品</div>：<i class="expert_destination_dis"><?php echo $expertData[0]['dest_name']?></i></span>
				</div>
				<p id='expert_talk'><?php echo $expertData[0]['talk'] ?></p>
			</div>
			<div class="credit fr">
				<div class="right_info_num clear" style=" height:115px;">
					<div class="soo_report">个人成绩单</div>
					<p class="person_num">年销人数 : <span id='expert_people'><?php echo $expertData[0]['people_count'] ?></span></p>
					<p class="credit_xy">年总积分 : <span id='expert_score'><?php echo $expertData[0]['total_score'] ?>分 </span></p>
					<p class="Revenue">年成交额 : <em>¥</em><span id='expert_amount'><?php echo $expertData[0]['order_amount'] ?></span></p>
					<p class="score">年满意度 :
						<span id='expert_satisfaction'>
							<?php 
								if($expertData[0]['satisfaction_rate'] > 1 || $expertData[0]['satisfaction_rate'] == 0) {
									echo '100%';
								} else {
									echo intval($expertData[0]['satisfaction_rate']*100).'%';
								}
							?>
						</span>
					</p>
				</div>
				<div class="triangle_right"></div>
			</div>
		</div>
	</div>
	<!-- <div class="huodong">
			<img src="../../static/img/close_n.png" class="close_huodong">
		<a href="/register">
			<img src="../../static/img/shouye_libao.gif">
		</a>
	</div> -->
</div>
<?php endif;?>
<!-- 旅游管家  结束 -->

<!-- 体验师开始 -->
<?php if (!empty($experienceData)):?>
<div class="layer w_1200 tiyanshi" style=" display:none;">
	<div class="" id="tys_nav"> <i id="tiyan_ico"></i>
		<h2>旅游体验师 <span>他们用亲身经历告诉您，每个旅游产品的不同体验和感受！</span></h2>
	</div>
	<div class="tiyan_content">
		<ul class="clear">
		<?php
			foreach($experienceData as $key =>$val):
			//$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/cj/'.$val['lineid'] : '/gn/'.$val['lineid'];
                            $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html';
		?>
			<li class="">
				<div class="tiyan_link relative" >
					<a href="<?php echo $line_url;?>" target="_blank">
						<img src="<?php echo base_url('static/img/loading0.gif'); ?>" data-original="<?php echo $val['pic']; ?>" />
					</a>
					<a href="<?php echo site_url('tys/'.$val['mid'])?>" target="_blank">
						<div class="experience_photo"><img src="<?php echo $val['litpic']; ?>" /></div>
					</a>
				</div>
				<div class="experience_txt_info">
					<a href="<?php echo site_url('tys/'.$val['mid'])?>" target="_blank">
						<span class="experience_name"><?php echo $val['nickname'];?></span>
					</a>
					<a href="<?php echo $line_url;?>" target="_blank">
						<div class="experience_ription" title="<?php echo $val['linename']?>"><?php echo $val['linename']?></div>
					</a>
				</div>
			</li>
			<?php endforeach;?>
			<li class="more_experience last_experience" style=" position:relative;">
				<a class="tiyan_link" href="<?php echo site_url('tys')?>" target="_blank">
					<div class="jike_box">
						<img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url('static/img/zixungengduo_2.png'); ?>" style=" width:auto; height:auto; display:block" class="w960_img" />
					</div>
				</a>
				<a href="<?php echo site_url('register')?>" target="_blank" class="abs_jike"><div class="experience_txt_info apply_link">即刻申请会员>></div></a>
			</li>
		</ul>
	</div>
</div>
<?php endif?>
<!-- 体验师结束 -->

<!-- 特价线路开始 -->
<!-- <?php if (!empty($lineSellData)):?> -->
	

<div class="layer good_lines tejiaxinlu">
	<div class="" id="tjxl_nav">
		<i class="consultant_ico"></i>
		<h2>特价线路 <span>时时为您呈现特价优惠、尾单促销、特优性价比产品！</span></h2>
		<a href="<?php echo site_url('all');?>" target="_blank"><span class="saleMore">更多+</span></a>
	</div>
	<div class="content tejia clear">
		<div class="tejia_img fl">
			<a href="<?php echo base_url('all');?>" target="_blank">
				<img src="<?php echo base_url('static/img/loading2.gif'); ?>" data-original="<?php echo base_url('static/img/tejia_img_03.png'); ?>" />
			</a>
		</div>
		<div class="list_item fl tjxl">
			<ul class="list-lines clear">
			<?php 
				foreach ($lineSellData as $key => $val):
				//$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/cj/'.$val['lineid'] : '/gn/'.$val['lineid'];
                                    $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html';
			?>
				<li>
					<div class="product_img">
						<a class="link_picBox" href="<?php echo $line_url;?>" target="_blank">
							<img class="animation_txt" src="<?php echo base_url('static/img/loading0.gif'); ?>" data-original="<?php echo $val['pic'] ?>" alt="<?php echo $val['linename'] ?>" />
						</a>
						<b><em class="money_ico">¥</em><?php echo $val['lineprice'];?></b>
					</div>
					<div class="product_title product_title_Special">
						<a href="<?php echo $line_url;?>" target="_blank" title="<?php echo $val['linename'].$val['linetitle'];?>">
						<span><?php echo str_cut($val['linename'], 69)?></span><?php echo str_cut($val['linetitle'], 30)?></a>
						<a class="link_snapUp" href="<?php echo $line_url;?>">立即抢购</a>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
 <!-- **********************************************<?php endif;?> -->
<!-- 特价线路结束 -->
<!-- 左侧悬浮导航 -->
<div class="bar_left_icon">
	<div class="f1_icon f_icon">
		<p class="gj_ico" title="旅游管家"><a href="javascript:;"></a></p>
		<!-- <p class="ty_ico" title="旅游体验师"><a href="javascript:;"></a></p> -->
		<p class="tj_ico" title="特价路线"><a href="javascript:;"></a></p>
		<p class="cg_ico" title="出境游"><a href="javascript:;"></a></p>
		<p class="gn_ico" title="国内游"><a href="javascript:;"></a></p>
		<p class="zy_ico" title="周边游"><a href="javascript:;"></a></p>
		<p class="zt_ico" title="主题游"><a href="javascript:;"></a></p>
	</div>
</div>
<div class="tour_details clear">
	<div class="head_img">
		<a href="#">
			<img src="<?php echo base_url('static'); ?>/img/tour.jpg" alt="出游">
		</a>
	</div>
<!-- 目的地线路列表 -->
	<?php if (!empty($indexKind)):?>
	<div class="travel_costs">
		<?php foreach($indexKind as $key=>$val):?>
		<div class="layer travel_items clear pos<?php echo $key+1?>">
			<div class="travel_type">
				<!-- 一级分类 -->
				<div class="header_msg">
					<img src="<?php echo base_url('static/img/'.($key+1).'F.png'); ?>"alt="">
					<div class="left_info_tour ut_f<?php echo $key+1?>">
						<div class="icon_ss<?php echo $key+1?>"></div>
						<h2><?php echo $val['name']?></h2>
					</div>
					<div class="under_tour ut_f<?php echo $key+1?>"></div>
				</div>
				<!-- 分类目的地 -->
				<div class="trl_type">
					<div class="experts_imgs">
						<img src="<?php echo base_url('static/img/loading2.gif'); ?>" data-original="<?php echo $val['pic'] ?>" alt="<?php echo $val['name']?>">
					</div>
					<div class="anim_fato"><!--这个是切换的透明div--></div>
					<div class="anim_top_box">
						<ul class="item_txt choice_line clear" data-val="<?php echo $key+1 ?>">
						<?php
							if (isset($val['kindDest']) && is_array($val['kindDest'])) {
								foreach($val['kindDest'] as $k =>$v) {
									//if ($k == 0) {
									//	$active = $key + 1;
									//	echo "<li class='on_{$active}' data-val='{$v['id']}'><a href='javascript:void(0);'>{$v['name']}</a></li>";
									//} else {
										echo "<li  data-val='{$v['id']}'><a href='javascript:void(0);'>{$v['name']}</a></li>";
									//}
								}
							}
						?>
					</ul>
					</div>
					<div class="btn_out out_btn_gj<?php echo $key+1 ?>"><!--点击动画的按钮--></div>
					<div class="btn_in in_btn_gj<?php echo $key+1 ?>"><!--点击动画的按钮--></div>
					
					<div class="show_more show_more<?php echo $key+1 ?>">
                                            <?php //var_dump($val['url']);?>
						<a href="<?php echo $val['url']?>">更多产品 〉</a>
					</div>
				</div>
			</div>
			<!-- 目的地的线路 -->
			<div class="list_pic_right dest_line<?php echo $key+1 ?>">
			<?php
				//默认展示线路
				if (isset($val['defaultLine']) && is_array($val['defaultLine'])) {
					echo '<ul class="list_tour_costs clear " >';
					foreach($val['defaultLine'] as $i) {
						//$line_url = in_array(1 ,explode(',',$i['overcity'])) ? '/cj/'.$i['lineid'] : '/gn/'.$i['lineid'];
                                            $line_url = in_array(1 ,explode(',',$i['overcity'])) ? '/line/'.$i['lineid'].'.html' : '/line/'.$i['lineid'].'.html';
			?>
					<li>
						<a class="pic_itmes" href="<?php echo $line_url;?>">
						<img src="<?php echo base_url('static/img/loading0.gif'); ?>" data-original="<?php echo $i['pic']; ?>" alt="<?php echo $i['linename']; ?>" />
							<div class="product_cover">
								<p><?php echo '['.$i['linename'].']'; ?></p>
							</div>
						</a>
						<div class="product_title">
							<a href="<?php echo $line_url;?>">
								<span><?php echo '['.$i['linename'].']';?></span><?php echo $i['linetitle'];?>
							</a>
						</div>
						<div class="prodct_info">
							<span class="price">
								<i><em class="money_ico">¥</em><em><?php echo $i['lineprice'];?></em> 起</i>&nbsp;&nbsp;
								<b><em class="money_ico">¥</em> <?php echo $i['lineprice']+$i['saveprice'];?> </b>
							</span>
							<span class="province"><i>省</i><?php echo $i['saveprice'];?></span>
						</div>
					</li>
				<?php 
					}
					echo '</ul>';
				}
			
				if (isset($val['kindDest']) && is_array($val['kindDest'])):
				foreach($val['kindDest'] as $k=>$v):
			?>
				<ul class="list_tour_costs clear line_data<?php echo $v['id']?>"  style="display:none;">
				<?php
					if (isset($v['lineArr']) && is_array($v['lineArr'])):
					foreach($v['lineArr'] as $item):
					//$line_url = in_array(1 ,explode(',',$item['overcity'])) ? '/cj/'.$item['lineid'] : '/gn/'.$item['lineid'];
                                            $line_url = in_array(1 ,explode(',',$item['overcity'])) ? '/line/'.$item['lineid'].'.html' : '/line/'.$item['lineid'].'.html';
				?>
					<li>
						<a class="pic_itmes" href="<?php echo $line_url;?>">
							<img src="<?php echo base_url('static/img/loading0.gif'); ?>" data-original="<?php echo $item['pic']; ?>" alt="<?php echo $item['linename']; ?>" />
							<div class="product_cover">
								<p><?php echo '['.$item['linename'].']'; ?></p>
							</div>
						</a>
						<div class="product_title">
							<a href="<?php echo $line_url;?>">
								<span><?php echo '['.$item['linename'].']';?></span><?php echo $item['linetitle'];?>
							</a>
						</div>
						<div class="prodct_info">
							<span class="price">
								<i><em class="money_ico">¥</em><em><?php echo $item['lineprice'];?></em> 起</i>&nbsp;&nbsp;
								<b><em class="money_ico">¥</em> <?php echo $item['lineprice']+$item['saveprice'];?> </b>
							</span>
							<span class="province"><i>省</i><?php echo $item['saveprice'];?></span>
						</div>
					</li>
					<?php	
						endforeach;
						endif;
					?>
				</ul>
				<?php
					endforeach;
					endif;
				?>
			</div>
		</div>
		<?php endforeach;?>
	</div>
	<?php endif;?>
	<div class="bar_right">
	<!-- 最美专家开始 -->
		<?php if (!empty($beautifulExpert)):?>
		<div class="side_item side_top">
			<h4 class="cm_side_title">最美专家</h4>
			<div class="cm_pic_list">
				<div class="bd cm_pic">
					<ul class="clear">
						<?php foreach($beautifulExpert  as $item):?>
						<li id="expert_link" num="<?php echo $item['eid'];?>" class="beautiful_expert">
							<div class="imgs_box">
                                                            <!-- 添加后缀.html-->
								<a href="<?php echo site_url('guanjia/'.$item['eid'].'.html')?>" target="_blank">
									<img src="<?php echo $item['smallpic']; ?>" alt="旅游管家<?php echo $item['nickname']?>" />
									<div class="title_text_info"><p>由帮游旅行公众号评选出<br/>本月最美专家前十名</p></div>
								</a>
							</div>
							<div class="info_box">
								<p class="imgs_name">
									<a href="<?php echo site_url('guanjia/'.$item['eid'].'.html')?>" target="_blank"><?php echo $item['nickname']; ?></a>
								</p>
								<p class="imgs_title"><?php echo $item['dest_name']; ?></p>
							</div>
						</li>
						<?php endforeach;?>
					</ul>
					<a class="link_a prev" href="javascript:void(0)"><</a> <a class="link_a next" href="javascript:void(0)">></a>
				</div>
			</div>
		</div>
		<?php endif;?>
		<!-- 最美专家结束 -->
		<?php if (!empty($beautyExperience)):?>
		<!-- 最美体验师 -->
		<!-- <div class="side_item side_top">   // 暂时隐藏
			<h4 class="cm_side_title">最美体验师</h4>
			<div class="cm_pic_list">
				<div class="bd cm_pic">
					<ul class="clear">
					<?php foreach($beautyExperience as $key=>$val):?>
						<li id="line_link"  class="beautiful_experience">
							<div class="imgs_box">
								<a href="<?php echo base_url('tys/'.$val['mid'])?>" target="_blank">
									<img src="<?php echo $val['pic'] ?>"/>
									<div class="title_text_info"><p>由帮游旅行公众号评选出<br/>本月最美体验师前十名</p></div>
								</a>
							</div>
							<div class="info_box">
								<p class="imgs_name"><?php echo $val['nickname']; ?></p>
								<p class="imgs_title">
									<a href="<?php echo base_url('tys/'.$val['mid'])?>" target="_blank">
								<?php
									if (isset($val['kindname']) && !empty($val['kindname'])) {
										echo $val['kindname'];
									}
								?>
									</a>
								</p>
							</div>
						</li>
					<?php endforeach;?>
					</ul>
					<a class="link_a prev" href="javascript:void(0)"><</a> <a class="link_a next" href="javascript:void(0)">></a>
				</div>
			</div>
		</div> -->
		<?php endif;?>
		<!-- 最美体验师结束 -->
		<!-- 销量排行 -->
		<?php if (is_array($orderByLine)):?>
		<div class="side_item">
			<h4 class="cm_side_title">销量排行</h4>
			<div class="tab_xl_contnet">
				<div class="hd clear">
					<ul>
						<?php
							foreach($orderByLine as $key =>$val){
								if ($key == 0) {
									echo "<li class='on'>{$val['name']}</li>";
								} else {
									echo "<li>{$val['name']}</li>";
								}
							}
						?>
					</ul>
				</div>
				<div class="bd">
					<ul class="ul_list">
						<?php foreach($orderByLine as $val): ?>
						<li>
							<ul class="bd_ul">
							<?php
								if (is_array($val['lower'])):
								foreach($val['lower'] as $k =>$v):
								//$line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/cj/'.$v['id'] : '/gn/'.$v['id'];
                                                                $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['id'].'.html' : '/line/'.$v['id'].'.html';
							?>
								<li>
									<a class="clear" href="<?php echo $line_url;?>" target="_blank" >
										<div class="pic_left fl">
											<img src="<?php echo $v['mainpic']; ?>" alt="<?php echo $v['linename']?>"/>
											<?php
												if ($k < 3) {
													$url = base_url('static/img/paihang_bg.png) 0px 0px no-repeat');
												} else {
													$url = base_url('static/img/paihang_bg2.png) 0px 0px no-repeat');
												}
											?>
											<b style="background:url(<?php echo $url ?>;">TOP<?php echo $k+1;?></b>
										</div>
										<div class="text_right fl">
											<p><?php echo $v['linename']; ?></p>
											<i class="price"><em class="money_ico">¥</em><?php echo $v['lineprice']; ?></i>
										</div>
									</a>
								</li>
							<?php
								endforeach;
								endif;
							?>
							</ul>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php endif;?>
		<!-- 销量排行结束 -->
		<!-- 最新点评 -->
		<?php if (!empty($commentData)):?>
			<div class="side_item">
				<h4 class="cm_side_title">最新点评</h4>
				<div class="scroll_zx_contnet">
					<div class="bd comment_detail" style="position:relative">
						<ul class="comment_detail_list" style=" overflow: hidden;">
							<?php 
								foreach ($commentData as $key=>$val):
								//$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/cj/'.$val['lineid'] : '/gn/'.$val['lineid'];
                                                                $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html';
							?>
							<li>
								<h3>用户<?php echo $val['nickname'];?> 发表了点评</h3>
								<p class="product">
									<a href="<?php echo $line_url;?>" target="_blank"><?php echo $val['linename'];?></a>
								</p>
								<p class="comment_txt"><?php echo $val['content'];?></p>
							</li>
							<?php endforeach;?>
						</ul>
					</div>
				</div>
			</div>
		<?php endif;?>
		<!-- 最新点评结束 -->
		<!-- 旅游百宝箱 -->
		<div class="side_item baibaoxiang">
			<div class="cm_side_title">旅游百宝箱</div>
			<div class="chest_list">
				<ul>
					<li style="border-right:1px dashed #fff;border-bottom:1px dashed #fff;"><a href="http://www.weather.com.cn/" rel="nofollow" target="_blank"><i></i>天气查询</a></li>
					<li style="border-bottom:1px dashed #fff;"><a href="http://www.12308.com/" rel="nofollow" target="_blank"><i class="ticket_ico"></i>汽车查询</a></li>
					<li style="border-right:1px dashed #fff;"><a href="http://www.12306.cn/mormhweb/" rel="nofollow" target="_blank"><i class="subway_ico"></i>火车查询</a></li>
					<li style=" border:none;"><a href="http://www.expedia.com.hk/" rel="nofollow" target="_blank"><i class="flight_ico"></i>航班查询</a></li>
				</ul>
			</div>
		</div>
		<!-- 旅游百宝箱结束 -->
	</div>
</div>
<div class="main_bottom clear w_1200">
	<div class="main_bottom_introduce">
		<!-- 底部文章 -->
		<?php if (!empty($articleArr)):?>
		<div class="question_line">
		<?php
			foreach ($articleArr as $k=>$v):
		?>
			<div class="question_line_content">
				<ul>
					<li class="question_line_title"><h3><?php echo $v['name'];?></h3></li>
					<?php
						if (isset($v['lower']) && is_array($v['lower'])):
							foreach ($v['lower'] as $key=>$val ):
					?>
					<li>
						<a href="<?php echo site_url('article/index-'.$val['id'].'.html#id'.$val['id']);?>" target="_blank"><?php echo  $val['title'] ;?></a>
					</li>
					<?php
						endforeach;
						endif;
					?>
				</ul>
			</div>
			<?php
				endforeach;
			?>
		</div>
		<?php endif;?>
		<!-- 底部文章结束 -->
		<div class="why_bangu">
			<img src="<?php echo base_url('static/img/1pxbaide.gif'); ?>" data-original="<?php echo base_url('static/img/why_bangu.png'); ?>" />
		</div>
		<!-- 图片类型友情链接 -->
		<?php if (is_array($friendLinkPic)):?>
		<div class="integrity_server">
			<ul>
			<?php foreach ($friendLinkPic as $key=>$val):?>
				<li>
					<a href="<?php echo $val['url'];?>" target="_blank">
						<img src="<?php echo base_url('static/img/1pxbaide.gif'); ?>" alt="<?php echo $val['name']?>" data-original="<?php echo $val['icon'];?>"/>
					</a>
				</li>
			<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
	</div>
	<!-- 文字类型友情链接 -->
	<?php if (is_array($friendLinkWord)):?>
	<div class="web_links">
		<div class="web_links_titile fl">友情链接:</div>
		<div class="web_links_content fr">
			<?php foreach ($friendLinkWord as $key=>$val):?>
			<a href="<?php echo $val['url'];?>" target="_blank"><?php echo $val['name'];?></a>
			<?php endforeach;?>
			<a href="/article/friend_link">更多友情链接>></a>
		</div>
	</div>
<?php endif;?>
</div>
</div>
</div>

<!--下方固定悬浮 -->

<div class="fix_float" style=" display:none;">
	<div class="_float_con">
    	<!-- <i class="shouji_float"></i> -->      <!--手机 -->
        <i class="quit"></i>       <!--关闭 -->
        
        <i class="code_text">关注官方微信<br>赢取更多优惠</i>
        <i class="float_code"></i>     <!--二维码 -->
        <i class="piaoliu"><img src="../../static/img/finx.png"></i>
        <div></div>

        
    </div>
</div>

<div class="cleae_con">
	<i class="cleae_shouji"><img src="../../static/img/fix_cons.png"></i>
    <span class="_fix_texi1">2016<i>注册</i></span>
    <span class="_fix_texi2">冬送温泉夏漂流</span>
</div>

<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
<script>
function createCitySelector() {
	
}
</script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery.SuperSlide.2.1.1.js"></script>
<script type="text/javascript">
//  最新点评滚动效果 
	var clearTime = "";
	var clearTime2 = "";
	var latest_comments = function() {
	var root = $(".comment_detail"),
		comments = $(root).find(".comment_detail_list");
	var li_heig = 0;
	function slide() {
		li_heig = parseInt(comments.find("li").eq(0).height()) + 10;
		comments.find("li").animate({
			top: "-=" + li_heig
		},
		"normal", "linear",
		function() {});
		clearTime = setTimeout(function() {
		var comment = comments.find("li").eq(0).remove();
		$(comments).append(comment);
		$(comments).find("li").css("top", 0);
		slide();
		},3000);
	};
	if (comments.height() > root.height()) {
		comments.hover(function() {
			clearTimeout(clearTime);
			clearTimeout(clearTime2);
			},function() {
		clearTime2 = setTimeout(function() {
			slide();
			},2000);
		});
		slide();
		}
	};
	latest_comments();
//  最美专家和你可能喜欢的轮播效果  
	jQuery(".cm_pic_list").slide({mainCell:".bd ul",autoPlay:true,delayTime:500});
//  销量排行切换效果 //
	jQuery(".tab_xl_contnet").slide({mainCell:".bd ul"});
	$(".beautiful_expert,.beautiful_experience").hover(function(){
		$(this).find(".title_text_info").show();
	},function(){
		$(this).find(".title_text_info").hide();
	});
</script>
</body>
</html>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>

<script type="text/javascript">
$(function(){ $(".lubo").lubo({});})
</script>
<script>
$('#estimatedate').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
});
//出发城市获取
createChoicePluginPY({
	data:chioceStartCityJson,
	nameId:'lineCityName',
	valId:'lineCityId',
	width:500,
	isHot:true,
	hotName:'热门城市',
	blurDefault:true,
	isCallback:true,
	callbackFuncName:function() {
		//切换周边游目的地
		$.post("/common/area/getRoundTripData",{'startcity':$('#lineCityId').val()},function(json) {
			var data = eval("("+json+")");
			chioceDestJson.trip = data;
			createChoicePlugin({
				data:chioceDestJson,
				nameId:"lineDestName",
				valId:"lineDestId",
				blurDefault:true
			});
		});
		return false;
	},
});
createChoicePluginPY({
	data:chioceStartCityJson,
	nameId:'customCityName',
	valId:'customCityId',
	width:500,
	isHot:true,
	hotName:'热门城市',
	blurDefault:true,
	isCallback:true,
	callbackFuncName:function() {
		
		//切换周边游目的地
// 		$.post("/common/area/getRoundTripData",{'startcity':$('#lineCityId').val()},function(json) {
// 			var data = eval("("+json+")");
// 			chioceDestJson.trip = data;
// 			createChoicePlugin({
// 				data:chioceDestJson,
// 				nameId:"lineDestName",
// 				valId:"lineDestId",
// 				blurDefault:true
// 			});
// 		});
		return false;
	},
});

//国内目的地
createChoicePlugin({
	data:{0:chioceDestJson['domestic']},
	nameId:"custom_domestic",
	valId:"customDestId",
	blurDefault:true
});
//出境目的地
createChoicePlugin({
	data:{0:chioceDestJson.abroad},
	nameId:"custom_abroad",
	valId:"customDestId",
	blurDefault:true
});

//目的地
$.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"expertDestName",
		valId:"expertDestId",
		blurDefault:true
	});
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"lineDestName",
		valId:"lineDestId",
		blurDefault:true
	});
 	//周边目的地
	createChoicePlugin({
		data:{0:data},
		nameId:"custom_trip",
		valId:"customDestId",
		blurDefault:true
	});
});

//管家所在地选择
createChoicePlugin({
	data:chioceAreaJson,
	nameId:"expertCityName",
	valId:"expertCityId",
	isCallback:true,
	callbackFuncName:callbackFunc,
	blurDefault:true
});

//选择管家所在地后获取所在地的区域 
function callbackFunc() {
	$("#visit_service").find(".expertAge_showbox").html("不限");
	$("#visit_service").find("input[name='visit_service']").val("");
	var cityid = $("#expertCityId").val();
	$.post("/common/area/getRegionData",{cityid:cityid},function(data){
		var data = eval("("+data+")");
		var html = "";
		$.each(data ,function(key ,val){
			html += "<li data-val='"+val.id+"'>"+val.name+"</li>";
		})
		$("#visit_service").find("ul").html(html);
		$("#visit_service ul li").click(function(){
			$(this).addClass("selected");
			$("#visit_service").find(".expertAge_showbox").html($(this).text());
			$("#visit_service").find("ul").hide();
		})
	})
}

//快速定制
function submit_custom() {
	var myDate = new Date();
	var year = myDate.getFullYear(); //获取完整的年份(4位,1970-????)
	var month = (myDate.getMonth()) * 1 + 1; //获取当前月份(0-11,0代表1月)
	var date = myDate.getDate(); //获取当前日(1-31)
	if (month <= 9) {
		month = '0'+month;
	}
	if (date <= 9) {
		date = '0'+date;
	}
	var dateNew = year+'-'+month+'-'+date;
	var custom_type = $(".custom_type_name").html();
	$("input[name='custom_type']").val(custom_type);
	var estimatedate = $("#estimatedate").val();
	if (estimatedate.length > 1) {
		if (estimatedate <= dateNew) {
			alert('预估日期要在今日之后');
			return false;
		}
	}
	$('#custom_form').submit();
}
$(document).mouseup(function(e){
	var _con = $('#js_cityBox');   // 设置目标区域
	if(!_con.is(e.target) && _con.has(e.target).length === 0){
		$("#js_cityBox").hide()
	}
});
//专家搜索
$('#submit_expert_search').click(function() {
	//上门服务
	var visit_service = $('#visit_service').find("ul").find('.selected').attr('data-val');
	//管家级别
	var grade = $('.expert_grade').next().next('#selecr').find('.selected').attr('value');
	var cityid = $("#expertCityId").val();
	var destid = $('#expertDestId').val();
	var sex = $('input[name=sex]').val();
        // 将guanj改为guanjia
	//var url = '/guanj/';
        var url = '/guanjia/';
	if (cityid >0) {
		url += '_c-'+cityid;
	}
	if (sex == 1 || sex == 2) {
		url += '_s-'+sex;
	}
	if (grade > 0) {
		url += '_g-'+grade;
	}
	if (destid >0) {
		url += '_d-'+destid;
	}
	if (visit_service > 0) {
		url += '_vs-'+visit_service;
	}
        /*
	if (url == '/guanj/') {
		location.href = '/guanj';
	} else {
		location.href = url+'.html';
	}*/
        if (url == '/guanjia/') {
		location.href = '/guanjia';
	} else {
		location.href = url+'.html';
	}
	return false;
});


//线路搜索
$('#submit_list_search').click(function(){
	var minPrice = $('#search_line').find('.eo_line_price').find('.selected').attr('min');
	var maxPrice = $('#search_line').find('.eo_line_price').find('.selected').attr('max');
	var minDay = $('#search_line').find('.eo_line_day').find('.selected').attr('min');
	var maxDay = $('#search_line').find('.eo_line_day').find('.selected').attr('max');
	var startcityId = $("#lineCityId").val();
	var startcityName = $("#lineCityName").val();
	var destName = $("#lineDestName").val();
	var destId = $("#lineDestId").val();
	var $url = '/all/';
	if (minPrice>0 || maxPrice>0) {
		$url = $url+'_p-'+minPrice+'-'+maxPrice;
	}
	if (minDay >0 || maxDay >0) {
		$url = $url+'_dl-'+minDay+'-'+maxDay;
	}
	if (startcityId >0) {
		$url = $url+'_st-'+startcityId;
	}
	if (destId >0) {
		$url = $url+'_ds-'+destId;
	}
	if ($url != '/all/') {
		$url= $url+'.html';
	} else {
		$url = '/all';
	}
	location.href=$url;
});
//管家性别选择
$(".expertSex").click(function(){
	$(".expertSex").find("i").removeClass("expert_sex_select");
	$(this).find("i").addClass("expert_sex_select");
	var index = $(".expertSex").index(this);
	//alert(index);
	$(".expert_sex_value").val(index);
});
</script>
<!-- 遮罩层 -->
<script type="text/javascript">
$(".link_picBox,.pic_itmes").hover(function(){
	product_cover_show($(this),".product_cover")
},function(){
	product_cover_hide($(this),".product_cover")
});
function product_cover_show(_this,_find){
	_this.find(_find).stop().animate({top: '0px'}, 150);
}
function product_cover_hide(_this,_find){
	var _top=_this.height();
	_this.find(_find).stop().animate({top:_top}, 150);
}
</script>
<script type="text/javascript">
$(function() {
	//专家图片切换
	var expert = <?php echo json_encode($expertData);?>;
	$("#list-experts li:lt(7)").hover(function(){
		var key = $(this).attr("value");
		/*if (typeof key == 'undefined') {
			return false;
		}*/
		$(this).addClass("on").siblings().removeClass("on");
		//管家大图切换
                // 将guanj改为guanjia,添加后缀.html
		$("#big_img_link").attr("href","<?php echo site_url();?>guanjia/"+expert[key]['eid'] + ".html");
		var src = $(this).find("img").attr("data-original");
		$("#current_expert").attr({"src":src ,"alt":expert[key]['nickname']});
		//底部信息显示切换
		$("#expert_list_link").attr("href","<?php echo site_url();?>guanjia/"+expert[key]['eid'] + ".html");            // 将guanj改为guanjia,添加后缀.html
		$("#expert_realname").html(expert[key]['nickname']);
		$(".expert_service_dis").attr("title",expert[key]['service_name']).html(expert[key]['service_name']);
		if (expert[key]['grade'] == 1) {
			var grade = "管家";
		} else if (expert[key]['grade'] == 2) {
			var grade = "初级专家";
		} else if (expert[key]['grade'] == 3) {
			var grade = "中级专家";
		} else if (expert[key]['grade'] == 4) {
			var grade = "高级专家";
		} else {
			var grade = "管家";
		}
		$(".expert_grade_dis").html(grade);
		$(".expert_destination_dis").attr("title",expert[key]['dest_name']).html(expert[key]['dest_name']);
		$("#expert_talk").attr("title",expert[key]['talk']).html(expert[key]['talk']);
		$("#expert_people").html(expert[key]["people_count"]);
		$("#expert_score").html(expert[key]["total_score"]+"分");
		$("#expert_amount").html(expert[key]["order_amount"]);
		console.log(expert[key]["satisfaction_rate"]);
		console.log(expert[key]["satisfaction_rate"]==0);
		if (expert[key]["satisfaction_rate"] > 1 || typeof expert[key]["satisfaction_rate"] == 'object') {
			$("#expert_satisfaction").html("100%");
		} else {
			$("#expert_satisfaction").html((expert[key]["satisfaction_rate"]*100).toFixed(0)+"%");
		}
	})
});
</script>
<!-- 轮播图  -->

<!-- 线路搜索，专家搜索，快速定制选项卡 -->
<script type="text/javascript">
$(function() {
	$(".course_tit div").eq(0).find("i").css("visibility","visible");
	$(".course_tit div").click(function() {
	var index = $(".course_tit div").index(this);
	$(".course_tit div").removeClass("courseon");
	$(this).addClass("courseon");
	$(".course_tit div i").css("visibility","hidden");
	$(this).find("i").css("visibility","visible");
	$(".course_list").hide();
	$(".course_list").eq(index).show();
});
//左边 出境游  国内游 周边游  主题游  翁金碧
$(".choice_line li").click(function(){
	var key = $(this).parent().attr("data-val");
	var className = "on_"+key;
	$(this).addClass(className).siblings().removeClass(className);
	var val = $(this).attr("data-val");
	$(this).parents(".travel_type").next(".list_pic_right").find(".line_data"+val).show().siblings().hide();
	$(".choice_line li").find("img").lazyload({
		effect : "fadeIn"
	});
});

//下拉框效果
var foo=true;
$(".expertAge_showbox").click(function(){
	$(".expertAge_showbox").siblings(".expertAge_option").hide();
	$(this).siblings(".expertAge_option").show();
});

$(".expertAge_option li").click(function(){
	//点击定制类型的时候切换目的地的id值,达到切换选择插件的目的
	if ($(this).parent("ul").hasClass("custom_type")) {
		var type = $(this).attr('value');
	if (type == 1) {
		$(".custom_dest").find("#custom_abroad").show().siblings().hide();
	} else if (type == 2) {
	$(".custom_dest").find("#custom_domestic").show().siblings().hide();
		} else if (type == 3) {
	$(".custom_dest").find("#custom_trip").show().siblings().hide();
		}
	$(".custom_dest").find("input").val("");
	$("#customDestId").val('');
	//$("#destSelected").find("span").reomve();
}
var values=$(this).html();
var val = parseInt($(this).attr("value"));
	$(this).parent().hide();
	$(this).addClass('selected').siblings().removeClass('selected');
	$(this).parent().siblings("input").val(val);
	$(this).parent().siblings().html(values);
});

$(document).mouseup(function(e) {
	var _con = $('.expertAge_box'); // 设置目标区域
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		$(".expertAge_box").find("ul").hide()
	}
})

$(".chest_list ul li").hover(function(){
	$(this).find("i").css("opacity","0.7");
},function(){
	$(this).find("i").css("opacity","1");
});
//鼠标移入改变css样式 (字体颜色,旅游体验师)
$(".tiyan_content ul li").hover(function(){
	$(this).find(".experience_txt_info").find("a").find(".experience_ription").addClass("on_f30");
},function(){
	$(this).find(".experience_txt_info").find("a").find(".experience_ription").removeClass("on_f30");
	})
});
</script>
<script type="text/javascript">
//首页左侧导航悬浮框
//需要在获得的高度之上-300  
var showON= $(".layer").offset().top; 
      //到了这个高度让 导航显示
if($(".lvyouguanjia").length>0 ){
	var guanjiaSet=$(".lvyouguanjia").offset().top; //1. 旅游管家 set
	var guanjiaHei=$(".lvyouguanjia").outerHeight(true); //1. 旅游管家 hei 
}else{
	$(".gj_ico").hide();
}
if($(".tiyanshi").length>0 ){
	var tiyanshiSet=$(".tiyanshi").offset().top; //1. 旅游管家 set
	var tiyanshiHei=$(".tiyanshi").outerHeight(true); //1. 旅游管家 hei 
}else{
	$(".ty_ico").hide();	
}
if($(".tejiaxinlu").length>0 ){
	var tejiaSet=$(".tejiaxinlu").offset().top; //1. 特价线路 set
	var tejiaHei=$(".tejiaxinlu").outerHeight(true); //1. 特价线路 hei 
}else{
	$(".tj_ico").hide();
}
if($(".pos1").length>0 ){
	var chujingSet=$(".pos1").offset().top; //1.    出境游 set
	var chujingHei=$(".pos1").outerHeight(true); //1. 出境游 hei 
	//alert(chujingSet)
}else{
	$(".cg_ico").hide();
}
if($(".pos2").length>0 ){
	var guoneiSet=$(".pos2").offset().top; //1. 国内游 set
	var guoneiHei=$(".pos2").outerHeight(true); //1. 国内游 hei 
	//alert(guoneiSet)
}else{
	$(".gn_ico").hide();
}
if($(".pos3").length>0 ){
	var zhoubianSet=$(".pos3").offset().top; //1. 周边游 set
	var zhoubianHei=$(".pos3").outerHeight(true); //1. 周边游 hei 
}else{
	$(".zy_ico").hide();
}
if($(".pos4").length>0 ){
	var zhutiSet=$(".pos4").offset().top; //1. 主题游 set
	var zhutiHei=$(".pos4").outerHeight(true); //1. 主题游 hei 
}else{
	$(".zt_ico").hide();
}

window.onscroll=function(){

	//左面菜单 
	if($(window).scrollTop()>showON-300 && $(window).scrollTop() <zhutiHei+zhutiSet-400){
		$(".bar_left_icon").fadeIn(500);
	}else{
		$(".bar_left_icon").fadeOut(500);
	}
	if ($(window).scrollTop()>=guanjiaSet-235 && $(window).scrollTop()<guanjiaHei+guanjiaSet-260) {
		$(".gj_ico a").css("background-position","-321px 0px");
	} else {
		$(".gj_ico a").css("background-position","-250px 0px");
	}
	// if ($(window).scrollTop()>=tiyanshiSet && $(window).scrollTop()<tiyanshiHei+tiyanshiSet) {
	// 	$(".ty_ico a").css("background-position","-184px 0px");
	// } else {
	// 	$(".ty_ico a").css("background-position","-110px 0px");
	// }
	if ($(window).scrollTop()>=tejiaSet-285 && $(window).scrollTop()<tejiaHei+tejiaSet-170) {
		$(".tj_ico a").css("background-position","0 -251px");
	} else {
		$(".tj_ico a").css("background-position","0px -187px");
	}
	if ($(window).scrollTop()>=chujingSet-320 && $(window).scrollTop()<chujingHei+chujingSet-395) {
		$(".cg_ico a").css("background-position","-122px -251px");
	} else {
		$(".cg_ico a").css("background-position","-122px -187px");
	}
	if ($(window).scrollTop()>=guoneiSet-380 && $(window).scrollTop()<guoneiHei+guoneiSet-440) {
		$(".gn_ico a").css("background-position","-183px -251px");
	} else {
		$(".gn_ico a").css("background-position","-183px -187px");
	}
	if ($(window).scrollTop()>=zhoubianSet-440 && $(window).scrollTop()<zhoubianHei+zhoubianSet-500) {
		$(".zy_ico a").css("background-position","-244px -251px");
	} else {
		$(".zy_ico a").css("background-position","-244px -187px");
	}
	if ($(window).scrollTop()>=zhutiSet-500 && $(window).scrollTop()<zhutiHei+zhutiSet-580) {
		$(".zt_ico a").css("background-position","-305px -251px");
	} else {
		$(".zt_ico a").css("background-position","-305px -187px");
	}
}
//点击事件

	$(".gj_ico").click(function(){$("html,body").animate({scrollTop:guanjiaSet-235},300);});
	// $(".ty_ico").click(function(){$("html,body").animate({scrollTop:tiyanshiSet-285},300);});
	$(".tj_ico").click(function(){$("html,body").animate({scrollTop:tejiaSet-285},300);});
	$(".cg_ico").click(function(){$("html,body").animate({scrollTop:chujingSet-320},300);});
	$(".gn_ico").click(function(){$("html,body").animate({scrollTop:guoneiSet-380},300);});
	$(".zy_ico").click(function(){$("html,body").animate({scrollTop:zhoubianSet-440},300);});
	$(".zt_ico").click(function(){$("html,body").animate({scrollTop:zhutiSet-500},300);});


</script>
				
<script>
//出境游 主题游 周边游 国内游 渐变切换效果						
	$(function(){
		//切换上来的动画
		$(".btn_in").click(function(){
			$(this).fadeOut("400");
			$(this).siblings(".btn_out").fadeIn("400");
			$(this).siblings(".anim_top_box").stop().animate({
				top:"0"
			},150);
				$(this).siblings(".anim_fato").stop().fadeIn("400");
			});
			//切换下去的动画
			$(".btn_out").click(function(){
				$(this).fadeOut("400");
				$(this).siblings(".btn_in").fadeIn("400");
				$(this).siblings(".anim_top_box").stop().animate({
					top:"334px"
			},100);
			$(this).siblings(".anim_fato").stop().fadeOut("400");
		});
	})
</script>

<script type="text/javascript">
$(function() {
	$("img").lazyload({
		effect : "fadeIn"
	});
	$("#big_img_link img").lazyload({
		effect : "fadeIn"
	});
	$("#list-experts li a img").lazyload({
		effect : "fadeIn"
	});
	$(".tiyan_link a img").lazyload({
		effect : "fadeIn"
	});
	$(".jike_box img").lazyload({
		effect : "fadeIn"
	});
	$(".product_img a img").lazyload({
		effect : "fadeIn"
	});
	$(".list_tour_costs li a img").lazyload({
		effect : "fadeIn"
	});
	$(".tejia_img img").lazyload({
		effect : "fadeIn"
	});
	$(".why_bangu img").lazyload({
		effect : "fadeIn"
	});
	$(".experts_imgs img").lazyload({
		effect : "fadeIn"
	});
	//判断是否登陆  若果登陆就把 注册送礼隐藏
	
 });

</script>
<script>
//--------------------------下方固定广告区域--------------------------//
$(function(){
	//切换回去
    //var thisWidth=$(".fix_float").width();
	var thisWidth=$(window).width();
	$(".cleae_con").css("left",-thisWidth);
	//alert(thisWidth)
	$(".quit").click(function(){
		var thisWidth=$(window).width();
		$(".fix_float").animate({
			left:-thisWidth,
		},300,function(){
			$(".fix_float").hide();
		});
		$(".cleae_con").show();
		$(".cleae_con").delay(300).animate({
			left:0,
		});
	})
	//切换出来
	$(".cleae_con").click(function(){
		var thisWidth=$(window).width();
		$(".fix_float").css("left",-thisWidth)
		$(".cleae_con").animate({
			left:-thisWidth,
		},300,function(){
			$(".cleae_con").hide();
		});
		$(".fix_float").show();
		$(".fix_float").delay(300).animate({
			left:0,
		});
	})
})
</script>
				
					

