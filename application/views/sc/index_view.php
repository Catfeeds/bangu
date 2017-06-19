<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script src="<?php echo base_url('static/js/jquery-1.7.2.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('static/js/sc/jqeury.tab.1.0.js'); ?>" type="text/javascript"></script>
    <!-- <link href="<?php echo base_url('static/css/sc/common.css'); ?>" rel="stylesheet" /> -->
    <link href="<?php echo base_url('static/css/sc/sc_index.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('static/css/plugins/choice_city.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
    <title>帮游_深圳之窗_首页</title>
</head>
<body>
<!-- 头部 -->
<div class="header">
  	<div class="sc_1000 wind_top">
	
	 
  		<!-- 花式登陆 等等 -->
  		<ul class="logis_top">
  			<li><a href=""><i class="weibo"></i><span>微博</span></a></li>
  			<li><a href=""><i class="weixin"></i><span>微信</span></a></li>
  			<li><a href="http://m.1b1u.com" target="_blank"><i class="shouji"></i><span>手机版</span></a></li>
  			<li><a href=""><i class="shoucang"></i><span>设为首页</span></a></li>
  		</ul>
		 <a href="javascript:void(0);" class="yuming"   rel="sidebar" onclick="addFavorite('1b1u.com','zhy')" >收藏本站</a>
                    <script>
                  //收藏本站
                    function addFavorite(sURL, sTitle) {
                    	//window.external.addFavorite(sURL, sTitle);
					    try {
					        //IE
					        window.external.addFavorite(sURL, sTitle);
					    } catch (e) {
					        try {
					            //Firefox
					            window.sidebar.addPanel(sTitle, sURL, "");
					        } catch (e) {
					            alert("您的浏览器不支持自动加入收藏，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.", "提示信息");  
					        }
					    }
					}
                    </script>
  		<!-- 搜索栏 -->
		  <div class="sc_search">  
                      <!-- guanj改为guanjia/ 这里需要转义-->
		<form id="search_line_form" class="search_line_form" action="<?php if(!empty($search_type) && $search_type ==1){echo site_url('guanjia\/');}else{echo site_url('all');}?>" method="post">
	                	<input type="submit" class="sech_button" value="搜索" style="_border:none"  />
	                	<input type="text" class="sech_text" placeholder="快速检索管家" autocomplete="off" value="<?php if(empty($key_word)) echo ''; else echo $key_word ;?>" name="key_word" onkeyup="this.value=this.value.replace(/[^\u4e00-\u9fa5\w]/g,'')" ；this.value=this.value.replace(/[^\u4e00-\u9fa5\w]/g,''/>
	                	
                	
  		<!--
  			<input type="button" class="sech_button" value="搜索">
  			<input type="text" class="sech_text" placeholder="站内搜索" />-->
  		
		</form>
		</div>
  	</div>
</div>


<!-- banner 活动广告图 -->
<div class="sc_banner_box relative">
	<a href="<?php echo base_url($desc['link']); ?>"  target="_blank"><img src="<?php echo base_url($desc['pic']); ?>" class="sc_banner_img"></a>
	<div class="banner_close"></div>
</div>


<!-- logo 等等 -->
<div class="sc_1000 sc_logo relative">
	<a href="<?php echo base_url(); ?>" class="sc_logo_a"  target="_blank"><img src="<?php echo base_url('static/img/sc/sc_shouye_logo.gif'); ?>"></a>
	<img src="<?php echo base_url('static/img/sc/sc_zhuanye.gif'); ?>" class="sc_zhuanye">
</div>


<!-- nav 导航 -->
<div class="sc_nav">
	<ul>
		<li class="nav_total">全部分类</li>
		<?php foreach ($nav  as $k=>$v){?>
		<li><a href="<?php echo  base_url($v['link']);?>"  target="_blank"><?php echo $v['name']?></a></li>
		<?php }?>
	</ul>
</div>


<!-- 详细分类 -->
<div class="sc_1000 relative over" style="padding-bottom:50px;">
	<!-- 详细分类-------------------左面 -->
	<div class="sc_con_le">
		<div class="sc_con_ificat">
			<div class="ificat_title"><img src="<?php echo base_url('static/img/sc/chujing.jpg'); ?>" class="cat_ico"><h1>出境游</h1></div>
			<ul class="sc_destina">
				<?php foreach ($jw5  as $k=>$v){?> 
					<li><a href="<?php echo $url['cj'].$v['dest_id'].$url['wei']?>" target="_blank"><?php echo $v['name']?></a></li>
				<?php }?>
			</ul>
			<span><!-- 1px线 --></span>
		</div>
		<div class="sc_con_ificat">
			<div class="ificat_title"><img src="<?php echo base_url('static/img/sc/guonei.jpg'); ?>" class="cat_ico"><h1>国内游</h1></div>
			<ul class="sc_destina">
				<?php foreach ($gn5  as $k=>$v){?>
					<li><a href="<?php echo $url['gn'].$v['dest_id'].$url['wei']?>" target="_blank"><?php echo $v['name']?></a></li>
				<?php }?>
			</ul>
			<span><!-- 1px线 --></span>
		</div>
		<div class="sc_con_ificat">
			<div class="ificat_title"><img src="<?php echo base_url('static/img/sc/zhoubian.jpg'); ?>" class="cat_ico"><h1>周边游</h1></div>
			<ul class="sc_destina">
				<?php foreach ($zb5  as $k=>$v){?>
					<li><a href="<?php echo $url['zb'].$v['dest_id'].$url['wei']?>" target="_blank"><?php echo $v['name']?></a></li>
				<?php }?>
			</ul>
			<span><!-- 1px线 --></span>
		</div>
		<div class="sc_con_ificat">
			<div class="ificat_title"><img src="<?php echo base_url('static/img/sc/zhuti.jpg'); ?>" class="cat_ico"><h1>主题游</h1></div>
			<ul class="sc_destina">
				<?php foreach ($zt5  as $k=>$v){?>
					<li><a href="<?php echo $url['zt'].$v['index_kind_id'].$url['wei']?>" target="_blank"><?php echo $v['name']?></a></li>
				<?php }?>
			</ul>
			<span><!-- 1px线 --></span>
		</div>
		<div class="sc_con_ificat">
			<div class="ificat_title"><img src="<?php echo base_url('static/img/sc/guanjia.jpg'); ?>" class="cat_ico"><h1>管家</h1></div>
			<ul class="sc_destina">
				<?php foreach ($guanj5  as $k=>$v){?>
					<li><a href="<?php echo $url['guanj'].$v['id'].$url['guanwei']?>" target="_blank"><?php echo $v['title']?></a></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<!-- 详细分类-------------------中间 -->
	<div class="sc_con_zh">
		<div class="sc_xinwen_list">
			<div class="xinwen_title">
			<a href="<?php echo  $url['wz'].$swz1['id'].$url['wei'] ?>"  target="_blank" ><?php echo $swz1['title']?></a></div>
			<ul class="xinwen_list_box">
			<?php foreach ($wz  as $k=>$v){?>
				<li><i></i><a href="<?php echo $url['wz'].$v['id'].$url['wei']?>" target="_blank"><?php echo $v['title']?></a></li>
				<?php }?>
			</ul>
		</div>
		<div class="baner">
		<a href="<?php echo $desc_zhong['link']; ?>" target="_blank"><img src="<?php echo base_url($desc_zhong['pic']); ?>" class="sc_banner_img"></a>
		</div>
	</div>
	<!-- 详细分类-------------------右面-->
	<div class="sc_con_you">
		<div class="tab">
			<!-- tab nav -->
			<ul class="tabnav">
				<li class="cuttor">找管家</li>
				<li>看产品</li>
				<li>我定制</li>
			</ul>
			<!-- tab con -->
			<div class="tabcontent">
				<!-- 找管家 -->
				<!-- <div class="tab_con" style="background:#f54; display: block"> -->
				<div class="tab_con" style=" display: block">
					<div class="sc_input_list">
						<div class="sc_inp_title">所在地区</div>
						<div class="sc_inp_box"><input type="text" id="expertCityName" class="inp_one" placeholder="管家所在区域" autocomplete="off"/></div>			
						<input type="hidden" name="expertCityId" value="235" id="expertCityId">
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">上门服务</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">选择城市<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden">
								<li data-val="1">境外</li>
								<li data-val="2">中国</li> 
							</ul>
						</div>    
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">管家性别 </div>
						<div class="sc_inp_box">
							<label><input type="radio" name="gender" class="inp_chex" />不限</label>
							<label><input type="radio" name="gender" class="inp_chex" />男</label>
							<label><input type="radio" name="gender" class="inp_chex" />女</label>
						</div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">管家级别</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">不限<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden">
								<li value="0">不限</li><!-- 这个li也在选项内 -->
								<li value="1">管家</li>
								<li value="2">初级专家</li>
								<li value="3">中级专家</li>
								<li value="4">高级专家</li>
							</ul>
						</div>    
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">擅长产品</div>
						<div class="sc_inp_box">
							<input type="text" class="inp_one" id="expertDestName" name="expertDestName" placeholder="请选择" autocomplete="off" /> 
							<input type="hidden" name="expertDestId" id="expertDestId">
						</div>
					</div>
					<div class="sc_input_btn">
						<input type="button" class="sc_button" id="guanjia" value="搜索管家" />  <!-- id="guanjia" -->
					</div>
				</div>
				<!-- 看产品 -->
				<!-- <div class="tab_con" style="background:#6eb92b"> -->
				<div class="tab_con">
					<div class="sc_input_list">
						<div class="sc_inp_title">出发城市</div>
						<div class="sc_inp_box">
							<input type="text" name="city_name" class="inp_one" id="lineCityName"  placeholder="省/市" class="cityName" autocomplete="off"/>
						 </div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">目的地</div>
						<div class="sc_inp_box">
							<input type="text" class="inp_one" placeholder="请输入城市名" name="line_dest" id="lineDestName" class="cityName" autocomplete="off"/>
							<input type="hidden" name="lineDestId" id="lineDestId" />
						</div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">价格区间</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">全部<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden">
								<li class="selected">全部</li>
								<li>500以下</li>
								<li>501-1000</li>
								<li>1001-5000</li>
								<li>5001-10000</li>
								<li>10001-20000</li>
							</ul>
						</div>    
					</div>

					<div class="sc_input_list">
						<div class="sc_inp_title">旅行天数</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">全部<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden">
								<li class="selected">全部</li>
								<li>1-3天</li>
								<li>4-6天</li>
								<li>7-9天</li>
								<li>10-15天</li>
							</ul>
						</div>    
					</div>
					<div class="sc_input_btn">
						<input type="button" class="sc_button" id="chanpin" value="搜索产品" /> <!-- id="chanpin" -->
					</div>
				</div>
				<!-- 我定制 -->
				<!-- <div class="tab_con" style="background:#e8667e"> -->
				<div class="tab_con">
				<form action="/srdz" id="custom_form" method="post">
					<div class="sc_input_list">
						<div class="sc_inp_title">定制类型</div>
						<div class="sc_inp_box">
						
							<div class="inp_two this_input">请选择<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							
							<ul class="inp_two_hidden custom_type" >
								<li value="1">出境游</li> 
								<li value="2">国内游</li>
								<li value="3">周边游</li>

							</ul>
						</div>    
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">出发城市</div>
						<div class="sc_inp_box">
							<input type="text" name="startcity" class="inp_one" class="input_cx_cfd" id="customCityName" autocomplete="off" placeholder="请输入城市名"/>
							<input type="hidden" name="customCityId" id="customCityId" />
						</div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">目的地</div>
						<div class="sc_inp_box  custom_dest">
						<input  type="hidden" name="custom_type">
							<input type="text" name="dest1" class="inp_one" id="custom_abroad" placeholder="请选择目的地" autocomplete="off" style="width:96px;_width:108px;">
							<input type="text" name="dest2" class="inp_one" style="display:none;width:96px;" autocomplete="off" id="custom_domestic" placeholder="请选择目的地" >
							<input type="text" name="dest3" class="inp_one" style="display:none;width:96px;" autocomplete="off" id="custom_trip" placeholder="请选择目的地" >
							
					 	</div><input type="hidden" id="customDestId" name="customDestId" />
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">预估日期</div>
						<div class="sc_inp_box">
							<input class="Wdate input_cx_data inp_one" name="estimatedate" placeholder="YYYY-MM-DD" type="text" id="estimatedate" readonly='readonly' autocomplete="off"/>
						</div>
					</div>
					<div class="sc_input_btn" onclick="submit_custom();">
						<input type="button" class="sc_button" id="dingzhi" value="定制旅游" /> <!-- id="dingzhi" -->
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- 旅游管家  免费帮您策划安排，一对一全程跟进旅程，获取完美服务体验！ -->
	<div class="sc_guanjia_box margin_top">
		<div class="guanji_title">
			<h2>旅游管家</h2>
			<span>免费帮您策划安排，一对一全程跟进旅程，获取完美服务体验！</span>
			<div class="sc_more"><a href="<?php echo $url['guanj']?>">更多管家</a></div>
		</div>
		<div class="img_details">
                    <!-- 添加后缀.html 魏勇编辑-->
			<a href="<?php echo $url['guanj'].$expertData1['eid'].'.html' ;?>"  target="_blank" id="img_href"> <img  src="<?php echo base_url($expertData1['pic']); ?>" class="gj_img" /></a>
		</div>
		<ul class="gj_img_list">
			<?php foreach($expertData2 as $key=>$val){?>
                    <!-- 添加后缀.html 魏勇编辑-->
				<li att="<?php echo $val['eid']?>"><a href="<?php echo  $url['guanj'].$val['eid'].'.html';?>"  target="_blank" ><img src="<?php echo base_url($val['pic']); ?>"></a></li>
			<?php }?>
		</ul>
		<div class="gj_intor">
			<div style="width:100%; overflow: hidden;">
                            <!-- 添加后缀.html 魏勇编辑-->
				<div class="gj_name"><a href="<?php echo $url['guanj'].$expertData1['eid'].'.html' ;?> "  target="_blank" ><?php echo $expertData1['nickname']?></a></div>
				<ul class="guanjia_xiqin">
					<li><div class="guaji_til">最高级别</div><span>高级管家</span></li>
					<li><i class="city_ico"></i><span style="color:#5d7895;"><?php echo $expertData1['cityname']?></span></li>
					<li><div class="guaji_til">上门服务</div><span><?php echo $expertData1['door']?></span></li>
					<li><div class="guaji_til">擅长产品</div><span><?php echo $expertData1['end']?></span></li>
				</ul>
			</div>
			<p><?php echo $expertData1['talk']?></p>
			<!--<div class="gj_city"><i class="city_ico"></i><span><?php echo $expertData1['cityname']?></span></div>
			<div class="gj_level">中级管家</div>
			<div class="gj_at">擅长线路:</div>
			<div class="gj_line"><?php echo $expertData1['end']?></div>
			<div class="gj_service">上门服务:<span><?php echo $expertData1['door']?></span></div> -->
	</div>
	<!-- 出境游 国内游 周边游 主题游  list -->
	<div class="sc_tourism margin_top">
  	<!-- ++++++++++++++++++++++++++出境游++++++++++++++++++++++++++++++++ -->
		<div class="sc_tourism_le tour_chujing">
			<div class="con_img_pan">
				<a href=""><img src="<?php echo base_url('static/img/sc/con_chujing.jpg'); ?>" class="con_img_lix"></a>
			</div>
			<div class="sc_product_list sc_product_chujing" >
				<ul class="sc_product_place">
				<?php foreach($jw9 as $key=>$val){?>
					<li><a href="<?php echo $url['cj'].$val['dest_id'].$url['wei']?>"  target="_blank"><?php echo $val['name']; ?></a></li>
				<?php }?>
					<li><a href="">更多产品></a></li>
				</ul>
			</div>
		</div>
		<div class="sc_tourism_zh list_chujing">
		<!-- tab2 -->
			<div class="tab2">
				<ul class="tabnav2">
					<li class="cuttor2">出境游资讯</li>
					<li>出境产品</li>
				</ul>
				<div class="tabcontent2">
				<!-- 资讯 -->
					<div class="tab_con2" style=" display:block;">
						<div class="sc_tour_til"><a href="<?php echo $url['wz'].$jw_consult1['id'].$url['wei'] ?>" target="_blank"><?php echo $jw_consult1['title'] ?></a></div>
						<div class="sc_tour_con sc_inden">
							<a href="<?php echo $url['wz'].$jw_consult1['id'].$url['wei'] ?>">
								<?php echo $jw_consult1content;?>
							</a>
						</div>
						<ul class="sc_tour_xinwen chujing_li">
						<?php if(is_array($jw_consult)&&!empty($jw_consult)){?>
							<?php foreach($jw_consult as $key=>$val){?>
								<li><i></i><a href="<?php echo $url['wz'].$val['id'].$url['wei']?>" target="_blank"><?php echo $val['title']; ?></a></li>
						<?php }}else{echo '';}?>
						</ul>
						<div class="sc_suse_box">
						<?php foreach($orderByLine2['cj'] as $key=>$val){?>
							<div class="sc_suse_list fl">
                                                            <!-- 将cj和gn改为line,添加后缀.html-->
							<a href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; ?>" target="_blank">
								<div class="sc_suse"><img src="<?php echo base_url($val['mainpic']); ?>" /></div>
								<div class="sc_suse_xi">
									<div class="sc_suse_text"><?php echo 	mb_substr($val['linename'],0,16,'utf-8') . '...'.mb_substr($val['linetitle'],0,14,'utf-8') . '...'?></div>
									<span>¥<?php echo $val['lineprice']?></span>
								</div>
							</a>
							</div>
						<?php }?>	
						</div>
					</div>
					<!-- 产品 -->
					<div class="tab_con2" style=" padding-left:5px; padding-top:5px;">
					<?php if(is_array($orderByLine['cj'])&&!empty($orderByLine['cj'])){?>
						<?php foreach ($orderByLine['cj'] as $k=>$v) {?>
						<div class="sc_duct_list">
                                                    <!-- 将cj和gn改为line,添加后缀.html-->
						<a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>"  target="_blank">
							<div class="sc_duct"><img src="<?php echo base_url($v['mainpic']); ?>" /></div>
							<div class="sc_duct_xi">
								<div class="sc_duct_txt">       
									<span class=" col_333"><?php echo mb_substr($v['linename'],0,16,'utf-8') . '...';?></span>
									<span class=" col_666"><?php echo mb_substr($v['linetitle'],0,14,'utf-8') . '...';?></span>
								</div>						
								<div class="sc_price">
									<i>¥</i><span><?php echo $v['lineprice'];?></span><i>起</i><s>¥ <?php echo $v['marketprice'];?> </s>
								</div>
								<div class="sc_diff"><i>省</i><span><?php echo $v['marketprice']-$v['lineprice'];?></span></div>
							</div>
						</a>
						</div>
					<?php }}else{	echo '';}?>
					</div>
				</div>
			</div>
		</div>
		<div class="sc_tourism_you list_chujing">
			<div class="sc_blem_title">出境游常见问题</div>
			<ul class="blem_list chujing_li">
			<?php foreach($p_cj as $key=>$val){?>
				<li><a href=""><span><?php echo ++$key.'	、';?></span><?php  $str=strlen($val['title']);	if($str>='16'){	 $ss=mb_substr($val['title'],0,13,'utf-8').'...'; }else{	 $ss=mb_substr($val['title'],0,15,'utf-8');	 }	 echo ($ss); ?></a></li>		 
			<?php }?>
				<li class="text_cen"><a href="">更多></a></li>
			</ul>
			<div class="yaolvyou">
				<div class="sc_yao_box"><img src="<?php echo base_url('static/img/sc/yaolvyou.jpg'); ?>"></div>
				<div class="gj_shec_chujing"><a href="http://www.1b1u.com/guanj" target="_blank"><span>搜索管家</span></a></div>
			</div>
		</div>
	</div>
	<div class="sc_tourism margin_top">
  <!-- ++++++++++++++++++++++++++国内游++++++++++++++++++++++++++++++++ -->
		<div class="sc_tourism_le tour_guonei">
			<div class="con_img_pan">
				<a href=""><img src="<?php echo base_url('static/img/sc/con_guonei.jpg'); ?>" class="con_img_lix"></a>
			</div>
			<div class="sc_product_list sc_product_guonei">
				<ul class="sc_product_place">
					<?php foreach($gn9 as $key=>$val){?>
					<li><a href="<?php echo $url['gn'].$val['dest_id'].$url['wei']?>"><?php echo $val['name']; ?></a></li>
					<?php }?>
					<li><a href="">更多产品></a></li>
				</ul>
			</div>
		</div>

		<div class="sc_tourism_zh list_guonei">
		<!-- tab2 -->
			<div class="tab2">
				<ul class="tabnav2">
					<li class="cuttor2">国内游资讯</li>
					<li>国内产品</li>
				</ul>
				<div class="tabcontent2">
				<!-- 资讯 -->
					<div class="tab_con2" style=" display:block;">
						<div class="sc_tour_til"><a href="<?php echo $url['wz'].$gn_consult1['id'].$url['wei'] ?>" target="_blank"><?php echo $gn_consult1['title'] ?></a></div>
						
							
						<div class="sc_tour_con sc_inden">
						<a href="<?php echo $url['wz'].$gn_consult1['id'].$url['wei'] ?>" target="_blank">
						<?php echo ($gn_consult1content); ?>
						
						</a>
						</div>
						<ul class="sc_tour_xinwen guonei_li">
						<?php if(is_array($gn_consult)&&!empty($gn_consult)){?>		
							<?php foreach($gn_consult as $key=>$val){?>
							<li><i></i><a href="<?php echo $url['wz'].$val['id'].$url['wei']?>" target="_blank"><?php echo $val['title']; ?></a></li>
						<?php }}else{ echo '';}?>
						</ul>
						<div class="sc_suse_box">
						<?php if(is_array($orderByLine2['gn'])&&!empty($orderByLine2['gn'])){?>	
							<?php foreach($orderByLine2['gn'] as $key=>$val){?>
							<div class="sc_suse_list fl">
                                                            <!-- 将cj和gn改为line,添加后缀.html-->
							<a href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; ?>" target="_blank">
								<div class="sc_suse"><img src="<?php echo base_url($val['mainpic']); ?>" /></div>
								<div class="sc_suse_xi">
									<div class="sc_suse_text"><?php echo 	mb_substr($val['linename'],0,16,'utf-8') . '...'.mb_substr($val['linetitle'],0,14,'utf-8') . '...'?></div>
									<span>¥<?php echo $val['lineprice']?></span>
								</div>
							</a>
							</div>
						<?php }}else{	echo '';}?>
						</div>
					</div>
					<!-- 产品 -->
					<div class="tab_con2" style=" padding-left:5px; padding-top:5px;">
					<?php if(is_array($orderByLine['gn'])&&!empty($orderByLine['gn'])){?>	
						<?php foreach ($orderByLine['gn'] as $k=>$v) {?>
						<div class="sc_duct_list">
                                                    <!-- 将cj和gn改为line,添加后缀.html-->
						<a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>" target="_blank">
							<div class="sc_duct"><img src="<?php echo base_url($v['mainpic']); ?>" /></div>
							<div class="sc_duct_xi">
								<div class="sc_duct_txt">
									<span class=" col_333"><?php echo mb_substr($v['linename'],0,16,'utf-8') . '...';?></span>
									<span class=" col_666"><?php echo mb_substr($v['linetitle'],0,14,'utf-8') . '...';?></span>
								</div>
								<div class="sc_price">
									<i>¥</i><span><?php echo $v['lineprice'];?></span><i>起</i><s>¥ <?php echo $v['marketprice'];?> </s>
								</div>
								<div class="sc_diff"><i>省</i><span><?php echo $v['marketprice']-$v['lineprice'];?></span></div>
							</div>
						</a>
						</div>
					<?php }}else{echo '';}?>
					</div>
				</div>
			</div>
		</div>
		<div class="sc_tourism_you list_guonei">
			<div class="sc_blem_title">国内游常见问题</div>
			<ul class="blem_list guonei_li">
			<?php foreach($p_gn as $key=>$val){?>
			
			<li><a href=""><span><?php echo ++$key.'	、';?></span><?php  $str=strlen($val['title']);	if($str>='16'){	 $ss=mb_substr($val['title'],0,13,'utf-8').'...'; }else{	 $ss=mb_substr($val['title'],0,15,'utf-8');	 }	 echo ($ss); ?></a></li>	
			
			
				
			<?php }?>
				<li class="text_cen"><a href="">更多></a></li>
			</ul>
			<div class="yaolvyou">
				<div class="sc_yao_box"><img src="<?php echo base_url('static/img/sc/yaolvyou.jpg'); ?>"></div>
				<div class="gj_shec_guonei"><a href="http://www.1b1u.com/guanj" target="_blank"><span>搜索管家</span></a></div>
			</div>
		</div>
	</div>
	<div class="sc_tourism margin_top">
		<!-- ++++++++++++++++++++++++++周边游++++++++++++++++++++++++++++++++ -->
		<div class="sc_tourism_le tour_zhoubian">
			<div class="con_img_pan">
				<a href=""><img src="<?php echo base_url('static/img/sc/con_zhoubian.jpg'); ?>" class="con_img_lix"></a>
			</div>
			<div class="sc_product_list sc_product_zhoubian">
				<ul class="sc_product_place">
					<?php foreach($zb9 as $key=>$val){?>
						<li><a href="<?php echo $url['zb'].$val['dest_id'].$url['wei']?>"><?php echo $val['name']; ?></a></li>
					<?php }?>
					<li><a href="">更多产品></a></li>
				</ul>
			</div>
		</div>
		<div class="sc_tourism_zh list_zhoubian">
		<!-- tab2 -->
			<div class="tab2">
				<ul class="tabnav2">
					<li class="cuttor2">周边游资讯</li>
					<li>周边游产品</li>
				</ul>
				<div class="tabcontent2">
				<!-- 资讯 -->
					<div class="tab_con2" style=" display:block;">
						<div class="sc_tour_til"><a href="<?php echo $url['wz'].$zb_consult1['id'].$url['wei'] ?>" target="_blank"><?php echo $zb_consult1['title'] ?></a></div>
						<div class="sc_tour_con sc_inden"><a href="<?php echo $url['wz'].$zb_consult1['id'].$url['wei'] ?>" target="_blank"><?php echo $zb_consult1content;?></a></div>
						<ul class="sc_tour_xinwen zhoubian_li">
						<?php if(is_array($zb_consult)&&!empty($zb_consult)){?>	
							<?php foreach($zb_consult as $key=>$val){?>
								<li><i></i><a href="<?php echo $url['wz'].$val['id'].$url['wei'] ?>" target="_blank"><?php echo $val['title']; ?></a></li>
						<?php }}else{	echo '';}?>
						</ul>
						<div class="sc_suse_box">
						<?php if(is_array($orderByLine2['zb'])&&!empty($orderByLine2['zb'])){?>	
							<?php foreach($orderByLine2['zb'] as $key=>$val){?>
							<div class="sc_suse_list fl">
                                                            <!-- 将cj和gn改为line,添加后缀.html-->
							<a href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; ?> " target="_blank">

								<div class="sc_suse"><img src="<?php echo base_url($val['mainpic']); ?>" /></div>
								<div class="sc_suse_xi">
									<div class="sc_suse_text"><?php echo 	mb_substr($val['linename'],0,16,'utf-8') . '...'.mb_substr($val['linetitle'],0,14,'utf-8') . '...'?></div>
									<span>¥<?php echo $val['lineprice']?></span>
								</div>
							</a>
							</div>
						<?php }}else{	echo '';}?>	
						</div>
					</div>
					<!-- 产品 -->
					<div class="tab_con2" style=" padding-left:5px; padding-top:5px;">
					<?php if(is_array($orderByLine['zb'])&&!empty($orderByLine['zb'])){?>	
						<?php foreach ($orderByLine['zb'] as $k=>$v) {?>
						<div class="sc_duct_list">
                                                    <!-- 将cj和gn改为line,添加后缀.html-->
						<a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>"  target="_blank">
							<div class="sc_duct"><img src="<?php echo base_url($v['mainpic']); ?>" /></div>
							<div class="sc_duct_xi">
								<div class="sc_duct_txt">
									<span class=" col_333"><?php echo mb_substr($v['linename'],0,16,'utf-8') . '...';?></span>
									<span class=" col_666"><?php echo mb_substr($v['linetitle'],0,14,'utf-8') . '...';?></span>
								</div>
								<div class="sc_price">
									<i>¥</i><span><?php echo $v['lineprice'];?></span><i>起</i><s>¥ <?php echo $v['marketprice'];?> </s>
								</div>
								<div class="sc_diff"><i>省</i><span><?php echo $v['marketprice']-$v['lineprice'];?></span></div>
							</div>
						</a>
						</div>
					<?php }}else{	echo '';}?>
					</div>
				</div>
			</div>
		</div>
		<div class="sc_tourism_you list_zhoubian">
			<div class="sc_blem_title">周边游常见问题</div>
			<ul class="blem_list zhoubian_li">
				<?php foreach($p_zt as $key=>$val){?>
					<li><a href=""><span><?php echo ++$key;?></span><?php echo ' 、'.mb_substr($val['title'],0,15,'utf-8'); ?></a></li>		 
				<?php }?>
					<li class="text_cen"><a href="">更多></a></li>
			</ul>
			<div class="yaolvyou">
				<div class="sc_yao_box"><img src="<?php echo base_url('static/img/sc/yaolvyou.jpg'); ?>"></div>
				<div class="gj_shec_zhoubian"><a href="http://www.1b1u.com/guanj" target="_blank"><span>搜索管家</span></a></div>
			</div>
		</div>
	</div>
	<div class="sc_tourism margin_top">
		<!-- ++++++++++++++++++++++++++主题游++++++++++++++++++++++++++++++++ -->
		<div class="sc_tourism_le tour_zhuti">
			<div class="con_img_pan">
				<a href=""><img src="<?php echo base_url('static/img/sc/con_zhuti.jpg'); ?>" class="con_img_lix"></a>
			</div>
			<div class="sc_product_list sc_product_zhuti">
				<ul class="sc_product_place">
				
					<?php foreach($zt9 as $key=>$val){?>
						<li><a href="<?php echo $url['zt'].$val['index_kind_id'].$url['wei']?>" target="_blank"><?php echo $val['name']; ?></a></li>
					<?php }?>
					<li><a href="">更多产品></a></li>
				</ul>
			</div>
		</div>
		<div class="sc_tourism_zh list_zhuti">
		<!-- tab2 -->
			<div class="tab2">
				<ul class="tabnav2">
					<li class="cuttor2">主题游资讯</li>
					<li>主题游产品</li>
				</ul>
				<div class="tabcontent2">
				<!-- 资讯 -->
					<div class="tab_con2" style=" display:block;">
						<div class="sc_tour_til"><a href="<?php echo $url['wz'].$zt_consult1['id'].$url['wei']	 ?>" target="_blank"><?php echo $zt_consult1['title'] ?></a></div>
						<div class="sc_tour_con sc_inden"><a href="<?php echo $url['wz'].$zt_consult1['id'].$url['wei']	 ?>" target="_blank"><?php echo $zt_consult1content ;?></a></div>
						<ul class="sc_tour_xinwen zhuti_li">
							<?php if(is_array($zt_consult)&&!empty($zt_consult)){?>	
							<?php foreach($zt_consult as $key=>$val){?>
								<li><i></i><a href="<?php echo $url['wz'].$val['id'].$url['wei']?>"><?php echo $val['title']; ?></a></li>
							<?php }}else{	echo '';}?>
						</ul>
						<div class="sc_suse_box">
						<?php if(is_array($orderByLine2['zt'])&&!empty($orderByLine2['zt'])){?>	
							<?php foreach($orderByLine2['zt'] as $key=>$val){?>
						 
							<div class="sc_suse_list fl">
                                                            <!-- 将cj和gn改为line,添加后缀.html-->
							<a href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html';   ?>" target="_blank">
								<div class="sc_suse"><img src="<?php echo base_url($val['mainpic']); ?>" /></div>
								<div class="sc_suse_xi">
									<div class="sc_suse_text"><?php echo 	mb_substr($val['linename'],0,16,'utf-8') . '...'.mb_substr($val['linetitle'],0,14,'utf-8') . '...'?></div>
									<span>¥<?php echo $val['lineprice']?></span>
								</div>
							</a>
							</div>
						<?php }}else{echo '';}?>	
						</div>
					</div>
					<!-- 产品 -->
					<div class="tab_con2" style=" padding-left:5px; padding-top:5px;">
					<?php if(is_array($orderByLine['zt'])&&!empty($orderByLine['zt'])){?>	
					<?php foreach ($orderByLine['zt'] as $k=>$v) {?>
						<div class="sc_duct_list">
                                                    <!-- 将cj和gn改为line,添加后缀.html-->
						<a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>" target="_blank">
							<div class="sc_duct"><img src="<?php echo base_url($v['mainpic']); ?>" /></div>
							<div class="sc_duct_xi">
								<div class="sc_duct_txt">
									<span class=" col_333"><?php echo mb_substr($v['linename'],0,16,'utf-8') . '...';?></span>
									<span class=" col_666"><?php echo mb_substr($v['linetitle'],0,14,'utf-8') . '...';?></span>
								</div>
								<div class="sc_price">
									<i>¥</i><span><?php echo $v['lineprice'];?></span><i>起</i><s>¥ <?php echo $v['marketprice'];?> </s>
								</div>
								<div class="sc_diff"><i>省</i><span><?php echo $v['marketprice']-$v['lineprice'];?></span></div>
							</div>
						</a>
						</div>
					<?php }}else{	echo '';}?>
					</div>
				</div>
			</div>
		</div>
		<div class="sc_tourism_you list_zhuti">
			<div class="sc_blem_title">主题游常见问题</div>
			<ul class="blem_list zhuti_li">	
			<?php foreach($p_zb as $key=>$val){?>
				<li><a href=""><span><?php echo ++$key.'	、';?></span><?php  $str=strlen($val['title']);	if($str>='16'){	 $ss=mb_substr($val['title'],0,13,'utf-8').'...'; }else{	 $ss=mb_substr($val['title'],0,15,'utf-8');	 }	 echo ($ss); ?></a></li>	
			<?php }?>
				<li class="text_cen"><a href="">更多></a></li>
			</ul>
			<div class="yaolvyou">
				<div class="sc_yao_box"><img src="<?php echo base_url('static/img/sc/yaolvyou.jpg'); ?>"></div>
				<div class="gj_shec_zhuti"><a href="http://www.1b1u.com/guanj" target="_blank"><span>搜索管家</span></a></div>
			</div>
		</div>
	</div>
</div>
</div>
<!-- 内容结束 -->
<!-- 页脚 -->
<div class="sc_foot">
	<div class="sc_1000 foot_yangs">
		<div class="for_fooer">
			<a href="http://www.1b1u.com/article/about_us-introduce" target="_blank">关于我们</a>
			<a href="http://www.1b1u.com/article/recruit" target="_blank">读者服务</a>
			<a href="http://www.1b1u.com/article/privacy_desc" target="_blank">免责声明</a>
			<a href="http://www.1b1u.com/article/contact_us" target="_blank">联系我们</a>
			<a href="http://www.1b1u.com/article/index-0.html" target="_blank">商务洽谈</a>
			<span>读者热线&nbsp;: &nbsp;&nbsp;40088&nbsp;&nbsp;44688&nbsp;&nbsp;(&nbsp;公共工作日&nbsp;:&nbsp;08:30~12:00&nbsp;&nbsp;13:30~18:00&nbsp;)</span>
		</div>
		<div class="sc_record">
			<span>网站备案号:粤ICP备11067328号-2&nbsp;&nbsp;增值电信业务经营许可证:粤B2-20080275   </span>
			<a href="">©深窗网</a>
		</div>
		<div class="supervise">
			<ul>
				<li><a href="http://www.1b1u.com/article/about_us-introduce" target="_blank" ><img src="<?php echo base_url('static/img/sc/ipc_1.jpg'); ?>" /></a></li>
				<li><a href=""><img src="<?php echo base_url('static/img/sc/ipc_2.jpg'); ?>" /></a></li>
				<li><a href=""><img src="<?php echo base_url('static/img/sc/ipc_3.jpg'); ?>" /></a></li>
				<li><a href=""><img src="<?php echo base_url('static/img/sc/ipc_4.jpg'); ?>" /></a></li>
				<li><a href=""><img src="<?php echo base_url('static/img/sc/ipc_5.jpg'); ?>" /></a></li>
				<li><a href=""><img src="<?php echo base_url('static/img/sc/ipc_6.jpg'); ?>" /></a></li>
			</ul>
		</div>
	</div>
</div>


<?php $this->load->view('sc/com/foot');?>
</body>
</html>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript">


$('#estimatedate').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d'
});



//出发城市获取
	createChoicePluginPY({
		data:chioceStartCityJson,
		nameId:'lineCityName',
		valId:'lineCityId',
		width:500,
		isHot:true,
		hotName:'热门城市',
		blurDefault:true
	});
	createChoicePluginPY({
		data:chioceStartCityJson,
		nameId:'customCityName',
		valId:'customCityId',
		width:500,
		isHot:true,
		hotName:'热门城市',
		blurDefault:true
	});



//地区获取
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


 $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
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
 	//周边目的地
	createChoicePlugin({
		data:{0:chioceDestJson['trip']},
		nameId:"custom_trip",
		valId:"customDestId",
		blurDefault:true
	});
});

// banner 图收缩
$('.banner_close').click(function(){

	$(this).parent().slideUp();

});
var foo=true;
 
$(".inp_two_hidden li").click(function(){
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
});

//插件调用
$(".tab").tab({
		
	type:'click'	
		
});

//下拉菜单显示
$(".this_input").click(function(){

	$(".sc_input_list").css("z-index","10");                           //设置层级保证 ie7+ie6的层级问题

	$(this).parent().parent(".sc_input_list").css("z-index","10000");  //设置层级保证 ie7+ie6的层级问题

	$(".inp_two_hidden").hide();

	$(this).siblings(".inp_two_hidden").show();

	$(".pop_city").hide();                          //防止与城市插件冲突   放生层级问题

});

$(".inp_one").focus(function(){                    //  防止与城市插件冲突

	$(".sc_input_list").css("z-index","10");       //  需要控制展示时的 z-index 值  

	$(".inp_two_hidden").hide();                   //  城市插件显示时 下拉隐藏
	
})

//下拉菜单点击赋值
$(".inp_two_hidden li").click(function(){

	var text = $(this).text();
	
	$(this).parent().hide().siblings(".this_input").text(text).append('<i class="down_ico"></i>');

	$(".sc_input_list").css("z-index","10");  

});

//下拉菜单隐藏
$(document).mouseup(function(e){

	var _con = $('.tab_con');   // 设置目标区域

	if(!_con.is(e.target) && _con.has(e.target).length === 0){

		$(".sc_input_list").css("z-index","10");  

		$(".inp_two_hidden").hide();

	}

});

//管家的切换图片

$(".gj_img_list li img").hover(function(){

	var src = $(this).attr("src");

	$(this).addClass("img_cuttor")

	$(".gj_img").attr("src",src);
	var base_url="<?php echo base_url()?>";
	var kks =$(this).parent().parent().attr("att");
	$.ajax({
			type:"post",
			url: base_url+"sc/index/expert_data_after",
			data:{kks:kks},
			dataType:"json",
			success:function(data){
				var smfw="";
				if(data.code=="4000"){
 					tan(data.msg);
				}
				if(data.code=="2000"){
				if(data.data.door=="" || data.data.door==null){ smfw = '暂无';}else{ smfw = data.data.door; };
				var html = '';
					html += "<div class='gj_name'><a href=''>"+data.data.nickname+"</a></div>";
					html += "<ul class='guanjia_xiqin'>	<li><div class='guaji_til'>最高级别</div><span>"+data.data.grade+"</span></li>";
					html += "<li><i class='city_ico'></i><span style='color:#5d7895;'>"+data.data.cityname+"</span></li>";
					html += "<li><div class='guaji_til'>上门服务</div><span>"+smfw+"</span></li>";
					html += "<li><div class='guaji_til'>擅长产品</div><span>"+data.data.end+"</span></li>";
					html += "</ul><p>"+data.data.talk+"</p>";
        		    $('.gj_intor').html(html);
                            // 将guanj改为guanjia,添加后缀.html  魏勇编辑
    				$("#img_href").attr("href","<?php echo site_url();?>guanjia/"+data.data.eid+".html");
				}
						 
				
				
				
			},
			error:function(){}
		});

},function(){

	$(this).removeClass("img_cuttor");
})


$(".tab2").tab({
		
	navClass:'cuttor2',
			
	tabNav:'.tabnav2>li',
	
	tabCon:'.tabcontent2>div',
	
	type:'hover'	
		
});

//专家搜索
$('#guanjia').click(function() {
	//上门服务
	var visit_service = $('#visit_service').find("ul").find('.selected').attr('data-val');
	//管家级别
	var grade = $('.expert_grade').next().next('#selecr').find('.selected').attr('value');
	var cityid = $("#expertCityId").val();
	var destid = $('#expertDestId').val();
	var sex = $('input[name=sex]').val();
        // 将guanj改为guanjia 魏勇编辑
	// var url = '/guanj/';
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
	}
        */
       if (url == '/guanjia/') {
		location.href = '/guanjia/';
	} else {
		location.href = url+'.html';
	}
	return false;
});

//线路搜索
$('#chanpin').click(function(){
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

		//头部搜索
		$('.sech_button').click(function(){
			var top_name = $('.select_showbox').html();
			var key_word = $('input[name="key_word"]').val();

			if (top_name == "产品") {
				location.href="/all/kw-"+key_word+'.html';
			} else {
                            // 将guanj改为guanjia
				$('#search_line_form').attr('action','/guanjia/na-'+key_word+'.html');
				$('#search_line_form').submit();
			}
		});



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

</script>

<script type="text/javascript">
	$(function(){
		$(".sc_suse_box").each(function(){
			$(this).children("div").eq(1).addClass("fr").removeClass("fl")
		})
	})
</script>


