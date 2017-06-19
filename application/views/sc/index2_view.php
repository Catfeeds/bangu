<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="keywords" content="国内游,周边游,出境游,旅游管家,定制游" />
  <meta name="description" content="深圳之窗旅游频道联合帮游旅行网为你提供国内旅游、周边旅游、出境旅游、旅游管家和个性定制旅游等旅游线路、旅游资讯、游玩攻略等旅游服务和攻略参考。" />
  <title>深圳旅游_旅游资讯_深圳旅行社-帮游网-深圳之窗网</title>
  
  <script src="<?php echo base_url('static/js/jquery-1.7.2.min.js'); ?>" type="text/javascript"></script>
  <script src="<?php echo base_url('static/js/sc/jqeury.tab.1.0.js'); ?>" type="text/javascript"></script>
  <!--<script src="<?php echo base_url('static/js/sc-action.js'); ?>" type="text/javascript"></script> -->
  <!-- <link href="<?php echo base_url('static/css/sc/common.css'); ?>" rel="stylesheet" /> -->
  <link href="<?php echo base_url('static/css/sc/sc_index2.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('static/css/plugins/choice_city.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
  <link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
    
</head>
<body>
<!-- 头部 -->
<?php $this->load->view('sc/com/head');?>

<!-- logo 图片 -->
<div class="logo_img sc_1000 clear">
	<a href="http://travel.shenchuang.com/" target="_blank" class="fl"><img src="<?php echo base_url();?>static/img/sc/sc_logo.jpg" class="sc_logo"/></a>
    <a href="http://mp.weixin.qq.com/s?__biz=MzIwMDQ1MzA5OQ==&mid=402305275&idx=1&sn=ace01200e7bb79199efdf93dfbe7872c&scene=1&srcid=0307bZITuRqAyKm7y16l8V4e&from=singlemessage&isappinstalled=0#wechat_redirect" target="_blank" class="fl"><img src="<?php echo base_url();?>static/img/sc/logo2.png" class="guanggao_logo"/></a>
    <a href="<?php echo base_url();?>" target="_blank" class="fr"><img src="<?php echo base_url();?>static/img/sc/bu_logo.jpg" class="bu_logo"/></a>
</div>

<!-- 详细分类 -->
<div class="man_content sc_1000 clear">
	<!-- 详细分类-------------------左面 -->
	<div class="sc_con_le">
		<div class="nav_box">
        	<ul class="nav_list clear">
            	<li class="current">出境游<i></i></li>
            	<li>国内游<i></i></li>
                <li>周边游<i></i></li>
                <li>主题游<i></i></li>
               
               
            </ul>
            <div class="nav_content">
            	<div>
                	<div class="line_img">
                	<?php if(count($lunbo)>0):?>
                	 <?php foreach ($lunbo as $bo=>$bo_value):?>
                	  <?php if($bo_value['kind_dest_id']=='1'):?>
                	  <a href="<?php echo $bo_value['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$bo_value['pic'];?>"/></a>
                	  <?php endif;?>
                	  <?php endforeach;?>
                	<?php endif;?>
                	</div>
                	
                    <div class="des_link clear">
                     <?php if(count($jw5)>0):?>
				         <?php foreach ($jw5 as $jw=>$jw_value):?>
				            <?php if($jw<5):?>
				        	<a href="<?php echo $url['cj'].$jw_value['id'].$url['wei']?>" target="_blank"><?php echo $jw_value['kindname'];?></a>
				            <?php endif;?>
				         <?php endforeach;?>
				            <?php if(count($jw5)>=5):?>
				             <a href="<?php echo $url['line'];?>" class="more_des_link" target="_blank">更多...</a>
				            <?php endif;?>
				        <?php endif;?>
                    
                    </div>
                </div>
                <div><div class="line_img">
                <?php if(count($lunbo)>0):?>
                	 <?php foreach ($lunbo as $bo=>$bo_value):?>
                	  <?php if($bo_value['kind_dest_id']=='2'):?>
                	  <a href="<?php echo $bo_value['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$bo_value['pic'];?>"/></a>
                	  <?php endif;?>
                	  <?php endforeach;?>
                	<?php endif;?>
                </div>
                    <div class="des_link clear">
                     <?php if(count($gn5)>0):?>
				         <?php foreach ($gn5 as $gn=>$gn_value):?>
				            <?php if($gn<5):?>
				        	<a href="<?php echo $url['cj'].$gn_value['id'].$url['wei']?>" target="_blank"><?php echo $gn_value['kindname'];?></a>
				            <?php endif;?>
				         <?php endforeach;?>
				            <?php if(count($gn5)>=5):?>
				             <a href="<?php echo $url['line'];?>" class="more_des_link" target="_blank">更多...</a>
				            <?php endif;?>
		            <?php endif;?>
                    </div>
                </div>
                <div><div class="line_img">
                <?php if(count($lunbo)>0):?>
                	 <?php foreach ($lunbo as $bo=>$bo_value):?>
                	  <?php if($bo_value['kind_dest_id']=='3'):?>
                	  <a href="<?php echo $bo_value['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$bo_value['pic'];?>"/></a>
                	  <?php endif;?>
                	  <?php endforeach;?>
                	<?php endif;?>
                </div>
                    <div class="des_link clear">
                    <?php if(count($zb5)>0):?>
				         <?php foreach ($zb5 as $zb=>$zb_value):?>
				            <?php if($zb<5):?>
				        	<a href="<?php echo $url['cj'].$zb_value['id'].$url['wei']?>" target="_blank"><?php echo $zb_value['kindname'];?></a>
				            <?php endif;?>
				         <?php endforeach;?>
				            <?php if(count($zb5)>=5):?>
				            <a href="<?php echo $url['line'];?>" class="more_des_link" target="_blank">更多...</a>
				            <?php endif;?>
		            <?php endif;?>
                    </div>
                </div>
                <div><div class="line_img">
                <?php if(count($lunbo)>0):?>
                	 <?php foreach ($lunbo as $bo=>$bo_value):?>
                	  <?php if($bo_value['kind_dest_id']=='4'):?>
                	  <a href="<?php echo $bo_value['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$bo_value['pic'];?>"/></a>
                	  <?php endif;?>
                	  <?php endforeach;?>
                	<?php endif;?>
                </div>
                    <div class="des_link clear">
                    <?php if(count($zt5)>0):?>
				         <?php foreach ($zt5 as $zt=>$zt_value):?>
				            <?php if($zt<5):?>
				        	<a href="<?php echo $url['cj'].$zt_value['id'].$url['wei']?>" target="_blank"><?php echo $zt_value['name'];?></a>
				            <?php endif;?>
				         <?php endforeach;?>
				            <?php if(count($zt5)>=5):?>
				             <a href="<?php echo $url['line'];?>" class="more_des_link" target="_blank">更多...</a>
				            <?php endif;?>
		            <?php endif;?>
                    </div>
                </div>

               
               
            </div>
        </div>
        <div class="more_expert clear">旅游管家向您推荐<a href="<?php echo $url['line'];?>" class="fr" target="_blank">更多</a></div>
        <ul class="line_expert">
        <?php if(count($recommend_line)>0):?>
            <?php foreach ($recommend_line as $re=>$re_value):?>
            <li>
                <!-- 将cj和gn改为line,添加后缀.html-->
            	<div class="line_info fl"><a href="<?php  $line_url = in_array(1 ,explode(',',$re_value['overcity'])) ? 'line/'.$re_value['lineid'].'.html' : 'line/'.$re_value['lineid'].'.html'; echo base_url().$line_url; ?>" target="_blank">
                	<div><img src="<?php echo BANGU_URL.$re_value['mainpic'];?>"/></div>
                    <p><<?php echo $re_value['linename']?>></p></a>
                </div>
                <!-- 添加后缀.html 魏勇编辑-->
                <div class="expert_info fr"><a href="<?php echo $url['guanj'].$re_value['expert_id'].'.html' ;?>" target="_blank">
                	<div><img src="<?php echo BANGU_URL.$re_value['big_photo'];?>"/></div>
                    <!--<p><img src="<?php $sex="n2.png";if($re_value['sex']=='0') $sex="n1.png";echo BANGU_URL."/static/img/page/".$sex;?>"/> <span><?php echo $re_value['nickname'];?></span></p></a>-->
                    <p><i class="shou"/> </i><?php echo $re_value['nickname'];?></span></a>
                </div>
            </li>
            <?php endforeach;?>
        <?php endif;?>
        	
        </ul>
        
	</div>
   
	<!-- 详细分类-------------------中间 -->
	<div class="sc_con_zh">
    	<div class="travel_article">
            <p class="titil_txt"><a href="<?php echo base_url();?>sc/index/information_list">哪好玩<i>&bull;</i>旅游管家告诉你</a></p>
            
            <ul class="article_list">
            <!-- <li><i>&bull;</i><a href="" target="_blank"><span>dasdasdasdasd</span></a><a href="" target="_blank">11111111111111111111111111111111111111</a></li> -->
                 <?php if(count($consult_top)>0):?>
                 <?php foreach ($consult_top as $top=>$top_value):?>
                <li><i>&bull;</i><span><?php echo $top_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$top_value['id'];?>" target="_blank" title="<?php echo $top_value['title'];?>"><?php echo $top_value['title'];?></a></li>

               <?php endforeach;?>
               <?php endif;?>
            </ul>
            <ul class="article_list">
               <?php if(count($consult_jw)>0):?>
                 <?php foreach ($consult_jw as $jw=>$jw_value):?>
                <li><i>&bull;</i><span><?php echo $jw_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$jw_value['id'];?>" target="_blank" title="<?php echo $jw_value['title'];?>"><?php echo $jw_value['title'];?></a></li>
               <?php endforeach;?>
               <?php endif;?>
                
            </ul>
            <ul class="article_list">
                <?php if(count($consult_gn)>0):?>
                 <?php foreach ($consult_gn as $gn=>$gn_value):?>
                <li><i>&bull;</i><span><?php echo $gn_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$gn_value['id'];?>" target="_blank" title="<?php echo $gn_value['title'];?>"><?php echo $gn_value['title'];?></a></li>
               <?php endforeach;?>
               <?php endif;?>
            </ul>
            
            <ul class="article_list">
                 <?php if(count($consult_zb)>0):?>
                 <?php foreach ($consult_zb as $zb=>$zb_value):?>
                <li><i>&bull;</i><span><?php echo $zb_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$zb_value['id'];?>" target="_blank" title="<?php echo $zb_value['title'];?>"><?php echo $zb_value['title'];?></a></li>
               <?php endforeach;?>
               <?php endif;?>
            </ul>
        </div>
        <div class="custom_img">
        <?php if(isset($fix_desc['top'][0]['pic'])):?>
        <a href="<?php echo $fix_desc['top'][0]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['top'][0]['pic'];?>"/></a>
        <?php endif;?>
        
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
						<div class="sc_inp_box"><input type="text" id="expertCityName" class="inp_one" value="<?php echo $startcityname;?>" placeholder="请选择城市" autocomplete="off"/></div>			
						<input type="hidden" name="expertCityId" value="<?php echo $startcityId;?>" id="expertCityId">
					</div>
					<div class="sc_input_list" id="visit_div">
						<div class="sc_inp_title">上门服务</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input"><font class="service_city">选择城市</font><i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden" id="visit_service" data-item="0">
							<?php foreach ($server_visit as $key=>$value):?>
                            <li data-val="<?php echo $value['id'];?>"><?php echo $value['name'];?></li>
                            <?php endforeach;?>
							</ul>
						</div>    
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">管家性别 </div>
						<div class="sc_inp_box">
							<label><input type="radio" name="gender" value="0" checked class="inp_chex" />不限</label>
							<label><input type="radio" name="gender" value="1" class="inp_chex" />男</label>
							<label><input type="radio" name="gender" value="2" class="inp_chex" />女</label>
						</div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">管家级别</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">不限<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden" id="expert_grade" data-item="0">
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
					<div class="sc_search_btn" id="guanjia">
					<span><i></i>搜索管家</span>
						  <!-- id="guanjia" -->
					</div>
				</div>
				<!-- 看产品 -->
				<!-- <div class="tab_con" style="background:#6eb92b"> -->
				<div class="tab_con">
					<div class="sc_input_list">
						<div class="sc_inp_title">出发城市</div>
						<div class="sc_inp_box">
							<input type="text" name="city_name" class="inp_one cityName" id="lineCityName"  placeholder="省/市" autocomplete="off"/>
						 </div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">目的地</div>
						<div class="sc_inp_box">
							<input type="text" class="inp_one cityName" placeholder="请输入城市名" name="line_dest" id="lineDestName" autocomplete="off"/>
							<input type="hidden" name="lineDestId" id="lineDestId" />
						</div>
					</div>
					<div class="sc_input_list">
						<div class="sc_inp_title">价格区间</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">全部<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden" id="my_price" data-item="0">
								<li data-id="0" class="selected">全部</li>
								<li data-id="0-500">500以下</li>
								<li  data-id="501-1000">501-1000</li>
								<li  data-id="1001-5000">1001-5000</li>
								<li  data-id="5001-10000">5001-10000</li>
								<li  data-id="10001-20000">10001-20000</li>
							</ul>
						</div>    
					</div>

					<div class="sc_input_list">
						<div class="sc_inp_title">旅行天数</div>
						<div class="sc_inp_box">
							<div class="inp_two this_input">全部<i class="down_ico"></i></div>    <!-- this_input   赋值 -->
							<ul class="inp_two_hidden" id="my_day" data-item="0">
								<li data-id="0" class="selected">全部</li>
								<li data-id="1-3">1-3天</li>
								<li data-id="4-6">4-6天</li>
								<li data-id="7-9">7-9天</li>
								<li data-id="10-15">10-15天</li>
							</ul>
						</div>    
					</div>
					<div class="sc_search_btn" id="chanpin">
					<span><i></i>搜索产品</span>
						 <!-- id="chanpin" -->
					</div>
				</div>
				<!-- 我定制 -->
				<!-- <div class="tab_con" style="background:#e8667e"> -->
				<div class="tab_con">
				<form action="<?php echo base_url();?>srdz" id="custom_form" method="post" target="_blank">
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
							<input type="text" name="startcity" class="inp_one input_cx_cfd" id="customCityName" autocomplete="off" placeholder="请输入城市名"/>
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
					<div class="sc_search_btn" onclick="submit_custom();">
						<span><i></i>定制旅游</span> <!-- id="dingzhi" -->
					</div>
					</form>
				</div>
			</div>
		</div>
        <!--=========旅游小秘书=========== -->
        <div class="travel_secretary">
            <p class="title">旅游小秘书</p>
            <ul class="travel_serve">
            <?php if(count($application)>0):?>
             <?php foreach ($application as $app=>$app_value):?>
             <li><a href="<?php echo $app_value['link'];?>"><img src="<?php echo BANGU_URL.$app_value['pic']; ?>" /><span><?php echo $app_value['name'];?></span></a></li>
             <?php endforeach;?>
            <?php endif;?>
            	
            </ul>
        </div>
	</div> 
</div>
	
<!-- 旅游管家  免费帮您策划安排，一对一全程跟进旅程，获取完美服务体验！ -->
<!-- ======================广告位=============================== -->
   <?php if(isset($fix_desc['center'][0]['pic'])):?>
    <div class="banner_img">
   
        <a href="<?php echo $fix_desc['center'][0]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['center'][0]['pic'];?>"/></a>
    </div>
    <?php else: ?>
			<div class="banner_img_null" style="border-top:1px solid #6eb92b;margin:50px auto;">
			</div>
   <?php endif;?>
	<div class="sc_guanjia_box margin_top clear">
		<div class="img_details">
			<a href="#"  target="_blank" id="img_href"> <img  src="<?php echo base_url();?>static/img/sc/gj_1.jpg" class="gj_img" /></a>
		</div>
		<ul class="gj_img_list">
		<?php if(count($expertData2)>0):?>
		  <?php foreach ($expertData2 as $ex=>$ex_value):?>
                    <!-- 添加.html后缀 魏勇编辑-->
			<li att="<?php echo $ex_value['eid']?>"><a href="<?php echo  $url['guanj'].$ex_value['eid'].'.html'?>"  target="_blank" ><img src="<?php echo BANGU_URL.$ex_value['pic'];?>"></a></li>
			<?php endforeach;?>

		<?php endif;?>
		</ul>
		<div class="gj_intor">
			<div style="width:100%; overflow: hidden;">
                            <!-- 添加.html后缀 魏勇编辑-->
				<div class="gj_name"><a href="<?php echo $url['guanj'].$expertData1[0]['eid'].'.html' ;?> "  target="_blank" ><?php echo $expertData1[0]['nickname']?></a></div>
				<ul class="guanjia_xiqin">
					<li style=" width:150px;"><div class="guaji_til">最高级别</div><span>高级管家</span></li>
					<li style=" width:300px;"><div class="guaji_til">擅长产品</div><span><?php echo $expertData1[0]['end']?></span></li>
          <li style=" width:300px;"><div class="guaji_til">上门服务</div><span><?php echo $expertData1[0]['door']?></span></li>
				</ul>
			</div>
      <div class="gj_citysl"><i class="city_ico"></i><span style="color:#5d7895;"><?php echo $expertData1[0]['cityname']?></span></div>
			<p><?php echo $expertData1[0]['talk']?></p>
			<a class='ganj_lian' href='http://www.1b1u.com/guanj/' target="_blank">[更多管家]</a>
	</div>
	
</div>
<?php if(count($index_kind)>0):?>
   <?php foreach ($index_kind as $index=>$index_value):?>
   <!--    第一栏   -->
     <?php if($index=='0'):?>
     <!-- ======================广告位=============================== -->
		<?php if(isset($fix_desc['center'][$index+1]['pic'])):?>
			<div class="banner_img">
			<a href="<?php echo $fix_desc['center'][$index+1]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['center'][$index+1]['pic'];?>"/></a>
			</div>
	    <?php else: ?>
			<div class="banner_img_null" style="border-top:1px solid #6eb92b;margin:50px auto;">
			</div>
	   <?php endif;?>
        
		<div class="content_box sc_1000 clear">
			<div class="left_line fl">
		    	<ul>
		    	<?php $i=0;if(count($index_kind_line)>0):?>
		    	  <?php foreach ($index_kind_line as $line=>$line_value):?>
			    	  <?php if($line_value['sc_index_kind_id']==$index_value['id']&&$i<5):?>
			    	  <!-- 将cj和gn改为line,添加后缀.html-->
			    	    <li><a href="<?php  $line_url = in_array(1 ,explode(',',$line_value['overcity'])) ? 'line/'.$line_value['line_id'].'.html' : 'line/'.$line_value['line_id'].'.html'; echo base_url().$line_url; ?>" target="_blank">
			            	<div class="left_line_img"><img src="<?php echo BANGU_URL.$line_value['mainpic'];?>"/></div>
			                <div class="left_line_name">《<?php echo $line_value['linename'];?>》</div>
			                <span class="left_line_price"><i><?php echo $line_value['lineprice'];?></i>起</span></a>
			            </li>
			            <?php $i++;?>
			           <?php endif;?>
		    	  <?php endforeach;?>
		    	<?php endif;?>
		        	
		        </ul>
		    </div>
		   
		    <div class="meijing_article fr">
		     <?php foreach ($index_category as $cat=>$cat_value):?>
		      <?php if($cat_value['sc_index_kind_id']==$index_value['id']):?>
		      <div class="content_info">
		        	<h3 class="content_title"><?php echo $cat_value['name'];?><a href="<?php echo base_url();?>sc/index/information_list" target="_blank">更多</a></h3>
		            <div class="item_content clear">
		            	<div class="beautiful_img">
		            	<?php foreach ($index_category_consult as $sult=>$sult_value):?>
		                 <?php if($sult_value['sc_index_category_id']==$cat_value['id']):?>
		            	  <img src="<?php echo BANGU_URL.$sult_value['pic'];?>"/>
		            	<?php endif;?>
		               <?php endforeach;?>
		            	</div>
		                <ul class="article_list art2">
		               <?php $i=0;foreach ($index_category_consult as $sult=>$sult_value):?>
		                 <?php if($sult_value['sc_index_category_id']==$cat_value['id']&&$i<7):?>
		                <li><i>&bull;</i><span><?php echo $sult_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$sult_value['consult_id'];?>" target="_blank" title="<?php echo $sult_value['title'];?>"><?php echo $sult_value['title'];?></a></li>
		                 <?php $i++;?>
		                 <?php endif;?>
		               <?php endforeach;?>
		                    
		                 
		                </ul>
		            </div>
		        </div>
		      <?php endif;?>
		    <?php endforeach;?>

		    </div>
		    
		</div>
		<?php endif;?>
		
		<!--    第二栏   -->
		<?php if($index=='1'):?>
			<!-- ======================广告位=============================== -->
			<?php if(isset($fix_desc['center'][$index+1]['pic'])):?>
			<div class="banner_img">
			<a href="<?php echo $fix_desc['center'][$index+1]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['center'][$index+1]['pic'];?>"/></a>
			</div>
		    <?php else: ?>
				<div class="banner_img_null" style="border-top:1px solid #6eb92b;margin:50px auto;">
				</div>
		    <?php endif;?>
		<!-- ======================吃喝玩购=============================== -->
		<div class="content_box sc_1000 clear">
			<div class="left_line fl">
		    	<ul>
		    	<?php $i=0;if(count($index_kind_line)>0):?>
				     <?php foreach ($index_kind_line as $line=>$line_value):?>
					    <?php if($line_value['sc_index_kind_id']==$index_value['id']&&$i<5):?>
                            <!-- 将cj和gn改为line,添加后缀.html-->
				        	<li><a href="<?php  $line_url = in_array(1 ,explode(',',$line_value['overcity'])) ? 'line/'.$line_value['line_id'].'.html' : 'line/'.$line_value['line_id'].'.html';echo base_url().$line_url; ?>" target="_blank">
				            	<div class="left_line_img"><img src="<?php echo BANGU_URL.$line_value['mainpic'];?>"/></div>
				                <div class="left_line_name">《<?php echo $line_value['linename'];?>》</div>
				                <span class="left_line_price"><i><?php echo $line_value['lineprice'];?></i>起</span></a>
				            </li>
				            <?php $i++;?>
		                <?php endif;?>
				   <?php endforeach;?>
				 <?php endif;?>
		            
		        </ul>
		        
		    </div>
		    
		    <div class="zhong_content fl">
		     <?php $i=0;foreach ($index_category as $cat=>$cat_value):?>
		      <?php if($cat_value['sc_index_kind_id']==$index_value['id']):?>
		    	<div class="zhong_content_list">
		        	<h3><?php echo $cat_value['name']?><a href="<?php echo base_url();?>sc/index/information_list" target="_blank">更多</a></h3>
		            <ul>
		            <?php $max="3";if($i=="3") $max="4";?>
		               <?php $j=0;foreach ($index_category_consult as $sult=>$sult_value):?>
		               
		                 <?php if($sult_value['sc_index_category_id']==$cat_value['id']&&$j<$max):?>
		                <li><i>&bull;</i><span><?php echo $sult_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$sult_value['consult_id'];?>" target="_blank" title="<?php echo $sult_value['title'];?>"><?php echo $sult_value['title'];?></a></li>
		                <?php $j++;?>
		                 <?php endif;?>
		               <?php endforeach;?>
		            </ul>
		        </div>
		        
		       <?php endif;?>
		       <?php $i++;?>
		      <?php endforeach;?>
		        
		    </div>
		    
		   	<div class="right_content fr">
		    	<p class="right_content_title">帮游原创<a href="<?php echo base_url();?>sc/index/information_list">更多</a></p>
		        <ul class="right_travel_list">
		        <?php if(count($index_bangu_article)>0):?>
		         <?php foreach ($index_bangu_article as $bang=>$bang_value):?>
		        	<li><a href="<?php echo $bang_value['link'];?>" target="_blank">
		            	<div class="travel_img fl"><img src="<?php echo BANGU_URL.$bang_value['pic'];?>"/></div>
		                <div class="introduce_txt fr"><p class="title"><?php echo $bang_value['name'];?><span>[详情]</span></p></div></a>
		            </li>
		            <?php endforeach;?>
		        <?php endif;?>
		                  
		        </ul>
		        <div class="public_num">
		        	<p>帮游公众号</p>
		            <div class="clear">
		            	<div class="weixin_img fl"><img src="<?php echo BANGU_URL.$index_public_qrcode[0]['pic'];?>"/></div>
		                <div class="text_title fr"><?php echo $index_public_qrcode[0]['remark']; ?></div>
		            </div>
		        </div>
		        <div class="console_expert">
		        	<div class="expert_photo"><a href="<?php echo $url['guanj'];?>" target="_blank"><img src="<?php echo base_url();?>static/img/sc/console_expert.jpg"/></a></div>
		            <a href="<?php echo $url['guanj'];?>" target="_blank" class="console_button"></a>
		        </div>
		    </div>
		    
		</div>
    <?php endif;?>
    <!-- 第三栏 -->
		<?php if($index=='2'):?>
			<!-- ======================广告位=============================== -->
			<?php if(isset($fix_desc['center'][$index+1]['pic'])):?>
			<div class="banner_img">
			<a href="<?php echo $fix_desc['center'][$index+1]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['center'][$index+1]['pic'];?>"/> </a>
			</div>
			<?php else: ?>
			<div class="banner_img_null" style="border-top:1px solid #6eb92b;margin:50px auto;">
			</div>
			<?php endif;?>
		<!-- ======================吃喝玩购=============================== -->
		<div class="content_box sc_1000 clear">
			<div class="left_line fl">
		    	<ul>
		    	<?php if(count($index_kind_line)>0):?>
				     <?php $i=0;foreach ($index_kind_line as $line=>$line_value):?>
					    <?php if($line_value['sc_index_kind_id']==$index_value['id']&&$i<5):?>
                            <!-- 将cj和gn改为line,添加后缀.html-->
				        	<li><a href="<?php  $line_url = in_array(1 ,explode(',',$line_value['overcity'])) ? 'line/'.$line_value['line_id'].'.html' : 'line/'.$line_value['line_id'].'.html';echo base_url().$line_url; ?>" target="_blank">
				            	<div class="left_line_img"><img src="<?php echo BANGU_URL.$line_value['mainpic'];?>"/></div>
				                <div class="left_line_name">《<?php echo $line_value['linename'];?>》</div>
				                <span class="left_line_price"><i><?php echo $line_value['lineprice'];?></i>起</span></a>
				            </li>
				            <?php $i++;?>
		                <?php endif;?>
				   <?php endforeach;?>
				 <?php endif;?>
		            
		        </ul>
		        
		    </div>
		    
		    <div class="zhong_content fl">
		     <?php foreach ($index_category as $cat=>$cat_value):?>
		      <?php if($cat_value['sc_index_kind_id']==$index_value['id']):?>
		    	<div class="zhong_content_list">
		        	<h3><?php echo $cat_value['name']?><a href="<?php echo base_url();?>sc/index/information_list" target="_blank">更多</a></h3>
		            <ul>
		               <?php $i=0;foreach ($index_category_consult as $sult=>$sult_value):?>
		                 <?php if($sult_value['sc_index_category_id']==$cat_value['id']&&$i<4):?>
		                <li><i>&bull;</i><span><?php echo $sult_value['attrname'];?></span><a href="<?php echo $url['sc_consult_detail'].'?id='.$sult_value['consult_id'];?>" target="_blank" title="<?php echo $sult_value['title'];?>"><?php echo $sult_value['title'];?></a></li>
		                 <?php $i++;?>
		                 <?php endif;?>
		               <?php endforeach;?>
		            </ul>
		        </div>
		        
		       <?php endif;?>
		      <?php endforeach;?>
		        
		    </div>
		    
		   	<div class="right_content fr">
		    	<p class="right_content_title">旅游曝光台<a href="<?php echo base_url();?>sc/index/exposure_list" target="_blank">更多</a></p>
		        <ul class="right_travel_list">
		        <?php if(count($index_travel_articl)>0):?>
		         <?php foreach ($index_travel_articl as $travel=>$travel_value):?>
		        	<li><a href="<?php echo $url['articl_detail'].$travel_value['id'];?>" target="_blank">
		            	<div class="travel_img fl"><img src="<?php echo BANGU_URL.$travel_value['pic'];?>"/></div>
		                <div class="introduce_txt fr"><p class="title"><?php echo $travel_value['title'];?><span>[详情]</span></p></div></a>
		            </li>
		            <?php endforeach;?>
		        <?php endif;?>
		                  
		        </ul>
		        
		    </div>
		    
		</div>
    <?php endif;?>
    
    <!-- 第4栏至第n栏 -->
    <?php if($index>=3):?>
    <!-- ======================广告位=============================== -->
      <?php if(isset($fix_desc['center'][$index+1]['pic'])):?>
		<div class="banner_img">
		<a href="<?php echo $fix_desc['center'][$index+1]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['center'][$index+1]['pic'];?>"/> </a>
		</div>
	  <?php else: ?>
			<div class="banner_img_null" style="border-top:1px solid #6eb92b;margin:50px auto;">
			</div>
	  <?php endif;?>
		<div class="content_box sc_1000 clear">
			<div class="left_line fl">
		    	<ul>
		    	<?php if(count($index_kind_line)>0):?>
		    	  <?php $i=0;foreach ($index_kind_line as $line=>$line_value):?>
			    	  <?php if($line_value['sc_index_kind_id']==$index_value['id']&&$i<5):?>
                            <!-- 将cj和gn改为line,添加后缀.html-->
			    	    <li><a href="<?php  $line_url = in_array(1 ,explode(',',$line_value['overcity'])) ? 'line/'.$line_value['line_id'].'.html' : 'line/'.$line_value['line_id'].'.html';echo base_url().$line_url; ?>" target="_blank">
			            	<div class="left_line_img"><img src="<?php echo BANGU_URL.$line_value['mainpic'];?>"/></div>
			                <div class="left_line_name">《<?php echo $line_value['linename'];?>》</div>
			                <span class="left_line_price"><i><?php echo $line_value['lineprice'];?></i>起</span></a>
			            </li>
			            <?php $i++;?>
			           <?php endif;?>
		    	  <?php endforeach;?>
		    	<?php endif;?>
		        	
		        </ul>
		    </div>
		   
		    <div class="meijing_article fr">
		     <?php foreach ($index_category as $cat=>$cat_value):?>
		      <?php if($cat_value['sc_index_kind_id']==$index_value['id']):?>
		      <div class="content_info">
		        	<h3 class="content_title"><?php echo $cat_value['name'];?><a href="<?php echo $url['consult'];?>" target="_blank">更多</a></h3>
		            <div class="item_content clear">
		            	<div class="beautiful_img"><img src="<?php echo BANGU_URL.$index_category_consult[0]['pic'];?>"/></div>
		                <ul class="article_list">
		               <?php $i=0;foreach ($index_category_consult as $sult=>$sult_value):?>
		                 <?php if($sult_value['sc_index_category_id']==$cat_value['id']&&$i<7):?>
		                <li><i>&bull;</i><a href="" target="_blank"><span><?php echo $sult_value['attrname'];?></span></a><a href="<?php echo $url['sc_consult_detail'].'?id='.$sult_value['consult_id'];?>" target="_blank" title="<?php echo $sult_value['title'];?>"><?php echo $sult_value['title'];?></a></li>
		                 <?php $i++;?>
		                 <?php endif;?>
		               <?php endforeach;?>
		                    
		                 
		                </ul>
		            </div>
		        </div>
		      <?php endif;?>
		    <?php endforeach;?>

		    </div>
		    
		</div>
		<?php endif;?>
    <!-- 栏目结束 -->
		
   <?php endforeach;?>
<?php endif;?>
    
    <!--  ===========第4栏至第n栏 ========= -->
    



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
			<?php foreach ($friend_link as $key=>$link):?>
				<li><a href="<?php echo $link['url'];?>" target="_blank" ><img src="<?php echo BANGU_URL.$link['icon']; ?>" /></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<!-- 右侧的浮动 活动模块 -->
<div class="fix_sc_huodong">
	<a href="http://www.1b1u.com/sc/index/scactivity" target="_blank">
		<i style="width:193px; height:142px; display:block;background:url(<?php echo base_url();?>static/img/sc/fix_sc_action.png)"></i>
	</a>
</div>


<?php $this->load->view('sc/com/foot');?>
</body>
</html>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jQuery-plugin/citylist/querycity.js');?>"></script>
<script type="text/javascript">
$(".nav_content>div").eq(0).show().siblings().hide();
var num1 = $(".travel_article ul").length;
$(".travel_article ul").eq(num1-1).css("border-bottom","0");

//左中右列表最后一个li去掉margin-bottom;
$(".left_line,.right_travel_list").each(function(){
	var len = $(this).find("li").length;
	$(this).find("li:eq("+(len-1)+")").css("margin-bottom","0px");
});
$(".zhong_content").each(function(){
	var len = $(this).find(".zhong_content_list").length;
	$(this).find(".zhong_content_list:eq("+(len-1)+")").css("margin-bottom","0px");
});


$(".left_line ul li").hover(function(){
	$(this).css("border-color","#ffae00");
},function(){
	$(this).css("border-color","#ccc");
});
$(".nav_box").tab({
		navClass:'current',
		tabNav:'.nav_list>li',
		tabCon:'.nav_content>div',	
		type:'mouseover'
	});
$(".line_expert li").hover(function(){
	$(this).addClass("on");
},function(){
	$(this).removeClass("on");
});




$('#estimatedate').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d'
});



//出发城市获取
//$.post("<?php echo base_url().'common/area/getStartplaceAllData';?>",{},function(json) {
	/*var data = eval("("+json+")");
	createChoicePluginPY({
		data:data,
		nameId:'lineCityName',
		valId:'lineCityId',
		width:500,
		isHot:true,
		hotName:'热门城市',
		blurDefault:true
	});
	createChoicePluginPY({
		data:data,
		nameId:'customCityName',
		valId:'customCityId',
		width:500,
		isHot:true,
		hotName:'热门城市',
		blurDefault:true
	});
});*/
$.ajax({
	type:"POST",
	url:"<?php echo base_url().'sc/index/getStartplaceAllData_sc';?>",
	dataType:"JSONP",
	jsonp: "callbackparam",
	jsonpCallback:"jsonpCallback1",
	data:{},
	success:function(json){
		//var data = eval("("+json+")");
		var data=json;
		createChoicePluginPY({
			data:data,
			nameId:'lineCityName',
			valId:'lineCityId',
			width:500,
			isHot:true,
			hotName:'热门城市',
			blurDefault:true
		});
		createChoicePluginPY({
			data:data,
			nameId:'customCityName',
			valId:'customCityId',
			width:500,
			isHot:true,
			hotName:'热门城市',
			blurDefault:true
		});
	},
	error:function(){
	}
})



//地区获取
//$.post("<?php echo base_url().'common/area/getAreaData';?>",{},function(json){
	/* var data = eval("("+json+")");
	createChoicePlugin({
		data:data,
		nameId:"expertCityName",
		valId:"expertCityId",
		isCallback:true,
		callbackFuncName:callbackFunc,
		blurDefault:true
	});
});*/

$.ajax({
	type:"POST",
	data:{},
	url:"<?php echo base_url().'sc/index/getAreaData_sc';?>",
	dataType:"JSONP",
	jsonp: "callbackparam",
	jsonpCallback:"jsonpCallback2",
	success:function(json){
		//var data = eval("("+json+")");
		var data=json;
		createChoicePlugin({
			data:data,
			nameId:"expertCityName",
			valId:"expertCityId",
			isCallback:true,
			callbackFuncName:callbackFunc,
			blurDefault:true
		});
	},
	error:function(){
	}
})


var i=5;
//选择管家所在地后获取所在地的区域 
function callbackFunc() {
	$("#visit_service").find(".expertAge_showbox").html("不限");
	$("#visit_service").find("input[name='visit_service']").val("");
	var cityid = $("#expertCityId").val();
	/*$.post("/common/area/getRegionData",{cityid:cityid},function(data){
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
	})*/
	$(".service_city").html("选择城市");
	$("#visit_service").attr("data-item","0");
	$("#visit_div").css("display","block");
	$.ajax({
		type:"POST",
		//data:{cityid:cityid},
		url:"<?php echo base_url().'sc/index/getRegionData_sc/';?>"+cityid,
		dataType:"JSONP",
		jsonp: "callbackparam",
		jsonpCallback:"jsonpCallback"+i,
		success:function(json){
			//var data = eval("("+data+")");
			var data=json;
			var html = "";
			$.each(data ,function(key ,val){
				html += "<li data-val='"+val.id+"'>"+val.name+"</li>";
			})
		
			$("#visit_service").html(html);
			$("#visit_service li").click(function(){
				$(this).addClass("selected");
				$(".service_city").html($(this).text());
				$("#visit_service").attr("data-item",$(this).attr("data-val"));
				$(".inp_two_hidden").hide();
			})
		},
		error:function(){
		}
	})
	i++;
	//end
}


//目的地
//$.post("<?php echo base_url().'common/area/getDestAllData';?>",{},function(json) {
	/*var data = eval("("+json+")");
	//所有目的地
	createChoicePlugin({
		data:data,
		nameId:"expertDestName",
		valId:"expertDestId",
		blurDefault:true
	});
	createChoicePlugin({
		data:data,
		nameId:"lineDestName",
		valId:"lineDestId",
		blurDefault:true
	});
	//国内目的地
	createChoicePlugin({
		data:{0:data['domestic']},
		nameId:"custom_domestic",
		valId:"customDestId",
		blurDefault:true
	});
 	//出境目的地
	createChoicePlugin({
		data:{0:data.abroad},
		nameId:"custom_abroad",
		valId:"customDestId",
		blurDefault:true
	});
 	//周边目的地
	createChoicePlugin({
		data:{0:data['trip']},
		nameId:"custom_trip",
		valId:"customDestId",
		blurDefault:true
	});
});*/

$.ajax({
	type:"POST",
	data:{},
	url:"<?php echo base_url().'sc/index/getDestAllData_sc';?>",
	dataType:"JSONP",
	jsonp: "callbackparam",
	jsonpCallback:"jsonpCallback3",
	success:function(json){
		//var data = eval("("+json+")");
		var data=json;
		//所有目的地
		createChoicePlugin({
			data:data,
			nameId:"expertDestName",
			valId:"expertDestId",
			blurDefault:true
		});
		createChoicePlugin({
			data:data,
			nameId:"lineDestName",
			valId:"lineDestId",
			blurDefault:true
		});
		//国内目的地
		createChoicePlugin({
			data:{0:data['domestic']},
			nameId:"custom_domestic",
			valId:"customDestId",
			blurDefault:true
		});
	 	//出境目的地
		createChoicePlugin({
			data:{0:data.abroad},
			nameId:"custom_abroad",
			valId:"customDestId",
			blurDefault:true
		});
	 	//周边目的地
		createChoicePlugin({
			data:{0:data['trip']},
			nameId:"custom_trip",
			valId:"customDestId",
			blurDefault:true
		});
	},
	error:function(){
	}
})


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
var max=100000;
$(".gj_img_list li img").hover(function(){

	var src = $(this).attr("src");

	$(this).addClass("img_cuttor")

	$(".gj_img").attr("src",src);
	var base_url="<?php echo base_url()?>";
	var kks =$(this).parent().parent().attr("att");
	
	$.ajax({
			type:"post",
			url: base_url+"sc/index/expert_data_after/"+kks,
			dataType:"JSONP",
			success:function(data){
				var smfw="";
				if(data.code=="4000"){
 					tan(data.msg);
				}
				if(data.code=="2000"){
				if(data.data.door=="" || data.data.door==null){ smfw = '暂无';}else{ smfw = data.data.door; };
				var html = '';
					html += "<div class='gj_name'><a href=''>"+data.data.nickname+"</a></div>";
					html += "<ul class='guanjia_xiqin'>	<li style='width:150px'><div class='guaji_til'>最高级别</div><span>"+data.data.grade+"</span></li>";
					// html += "<li><i class='city_ico'></i><span style='color:#5d7895;'>"+data.data.cityname+"</span></li>";
					html += "<li style='width:300px'><div class='guaji_til'>擅长产品</div><span>"+data.data.end+"</span></li>";
					html += "<li style='width:300px'><div class='guaji_til'>上门服务</div><span>"+smfw+"</span></li>";
					html += "</ul><div class='gj_citysl'><i class='city_ico'></i><span style='color:#5d7895;'>"+data.data.cityname+"</span></div><p>"+data.data.talk+"</p><a class='ganj_lian' href='http://www.1b1u.com/guanj/'>[更多管家]</a>";
        		    $('.gj_intor').html(html);
                                // guanj改为guanjia,添加后缀.html
    				$("#img_href").attr("href","<?php echo site_url();?>guanjia/"+data.data.eid + ".html");
				}	
			},
			error:function(){}
		});
	max--;
   

},function(){

	$(this).removeClass("img_cuttor");
})


$(".tab2").tab({
		
	navClass:'cuttor2',
			
	tabNav:'.tabnav2>li',
	
	tabCon:'.tabcontent2>div',
	
	type:'hover'	
		
});
$("#expert_grade li").click(function(){
	var value=$(this).attr("value");
	$("#expert_grade").attr("data-item",value);
})
$("#visit_service li").click(function(){
	var value=$(this).attr("data-val");
	$("#visit_service").attr("data-item",value);
})
//专家搜索
$('#guanjia').click(function() {
	//上门服务
	var visit_service = $('#visit_service').attr('data-item');
	//管家级别
	var grade = $('#expert_grade').attr('data-item');
	var cityid = $("#expertCityId").val();
	var destid = $('#expertDestId').val();
	var sex = $('input[name=gender]:checked').val();
	
        // guanj改为guanjia
	//var url = '<?php echo base_url();?>guanj/';
        var url = '<?php echo base_url();?>guanjia/';
	var url2="";
	if (cityid >0) {
		url2 += '_c-'+cityid;
	}
	if (sex == 1 || sex == 2) {
		url2 += '_s-'+sex;
	}
	if (grade > 0) {
		url2 += '_g-'+grade;
	}
	if (destid >0) {
		url2 += '_d-'+destid;
	}
	if (visit_service > 0) {
		url2 += '_vs-'+visit_service;
	}
	
	if (url2 == '') {
		//location.href = '/guanj';
		window.open(url);
		
	} else {
		//location.href = url+'.html';
		window.open(url+url2+'.html');
	}
	return false;
});


$("#my_price li").click(function(){
	var value=$(this).attr("data-id");
	$("#my_price").attr("data-item",value);
})
$("#my_day li").click(function(){
	var value=$(this).attr("data-id");
	$("#my_day").attr("data-item",value);
})
//线路搜索
$('#chanpin').click(function(){
	var myPrice = $('#my_price').attr('data-item');
	var myDay = $('#my_day').attr('data-item');
	var price_arr=myPrice.split("-");
	var day_arr=myDay.split("-");
	var minPrice = price_arr[0];
	var maxPrice = price_arr[1];
	var minDay = day_arr[0];
	var maxDay = day_arr[1];
	var startcityId = $("#lineCityId").val();
	var startcityName = $("#lineCityName").val();
	var destName = $("#lineDestName").val();
	var destId = $("#lineDestId").val();
	
	
	var $url = '<?php echo base_url();?>all/';
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
	else
	{
		$url = $url+'_ds-0';
	}
	if ($url != '/all/') {
		$url= $url+'.html';
	} else {
		$url = '/all';
	}
	window.open($url);
});

		//头部搜索
		$('.sech_button').click(function(){
			var top_name = $('.select_showbox').html();
			var key_word = $('input[name="key_word"]').val();

			if (top_name == "产品") {
				location.href="<?php echo base_url();?>all/kw-"+key_word+'.html';
			} else {
                            // guanj改为guanjia
				$('#search_line_form').attr('action','<?php echo base_url();?>guanjia/na-'+key_word+'.html');
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
	});

	$("")

</script>



