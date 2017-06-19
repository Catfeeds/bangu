<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="深圳游资讯,深圳周边游,旅游线路,旅游管家" />
    <meta name="description" content="深圳之窗旅游频道联合帮游旅行网为你提供国内、周边、出境等旅游线路的美食、住宿、娱乐、购物、小众旅游等各方面的资讯供大家出游参考。" />
    <title>深圳旅游资讯_旅游攻略_帮游网-深圳之窗网</title>
    
    <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
    <script src="<?php echo base_url('static/js/jquery-1.7.2.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('static/js/sc/jqeury.tab.1.0.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>
    <link href="<?php echo base_url('static/css/sc/sc_index2.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('static/css/sc/sc_information.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('static/css/plugins/choice_city.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
   
  
</head>

<body>
<!-- 头部 -->
 <?php $this->load->view('sc/com/head');?>

<!-- 管家咨询列表-->
<div class="expert_console sc_1000">
	<ul class="clear sc_1020 ">
	<?php foreach ($expertData as $key => $val) {?>
    	<li>
            <!-- 添加后缀.html-->
        	<div class="expertImg"><a href="<?php echo $url['guanj'].$val['eid'].'.html'?>"><img src="<?php echo base_url($val['smallpic']);?> "/></a></div>
            <p class="expertName"><span><?php	echo $val['nickname'];?></span></p>
            <!-- <p class="expertLink"><a href="<?php echo $url['guanjia'].$val['eid'].$url['wei'];?>" target="_blank" class="consoleLink fl">找我定制</a><a href="<?php	echo $url['index'].':8080/kefu_member.html?mid='.$this ->session ->userdata('c_userid').'&eid='.$val['eid'];?> " target="_blank" class="customLink fr">向我咨询</a></p> -->
        	<p class="expertName zanses"><i>等级:</i><?php echo $val['grade'];?></p>
        </li>
	<?php }?>
    </ul>
</div>
<!-- 导航条 -->
<div class="nav_bar">
	<ul class="sc_1000 clear">
	
			<?php foreach ($nav  as $k=>$v){?>
		<li><a href="<?php echo  base_url($v['link']);?>"  target="_blank"><?php echo $v['name']?></a></li>
		<?php }?>
    	 
    </ul>
</div>

<div class="text_nav_title">
	<a href="http://www.1b1u.com/sc/index/index2" class="fl">深圳之窗旅游</a>
	<span class="fl">></span>

	<a href="#" class="fl changes">旅游资讯</a>

</div>
<!--  广告位 -->
<?php if(!empty($fix_desc['center'][1]['pic'])){?>

<div class="banner_img"><a href="<?php echo $fix_desc['center'][1]['link'];?>" target="_blank"><img src="<?php echo BANGU_URL.$fix_desc['center'][1]['pic'];?>"/></a> </div>
                   

<?php }else{?>
			<div class="banner_img_null" style="border-top:1px solid #6eb92b;margin:50px auto;"></div>
<?php }?>
<!-- 详细分类 -->
<div class="man_content sc_1000 clear">
	<!-- 详细分类-------------------左面 -->
	<div class="left_content">
    	<!--================资讯列表=========== -->
        <div class="info_list">
        
            <ul class="information_type clear one" style="overflow: hidden;width:8%;float:left;clear:none;">
            <li style="padding:0 10px;"><a href="<?php echo base_url().'sc/index/index2';?>" target="_blank" style="color:#fff;">首页</a></li>
            </ul>
        	<ul class="information_type clear two" style="overflow: hidden;width:92%;clear:none;">
			<?php foreach	($tip	as $key =>$val)	{ ?>
                <li <?php	if($key=='0'){echo "class='on'"	;}else{	echo '';}?>><?php	echo $val['attrname'];?></li>
 
			<?php	}?> 
            </ul>
            <div class="tabcontents">
            <?php foreach ($im_content as $item=>$con):?>
                <div class="tab_cons" data-id="<?php echo $item;?>" style="display: <?php if($item=="1") echo 'block'; else echo 'none';?>;">
                    <ul class="information_list_info">
						<?php foreach	($con as $key =>$val)	{ ?>
                    	<li><a href="<?php echo base_url('sc/index/information_detail?id='.$val['id']);?>"	 target="_blank">
                        	<div class="information_img fl">
                        		
                        		<img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['pic']);?>">
                        	</div>
                            <div class="information_txt fr">
                            	<h4><?php echo $val['title'];?></h4>
                                <p><?php echo  $val['content_paper'];?></p>
                                
                            </div>
        					</a>
        					
    					 <div class="attention">
	    					 <span class="spn1"><?php echo substr($val['addtime'],0,4); ?>年<?php echo substr($val['addtime'],5,2); ?>月<?php echo substr($val['addtime'],8,2); ?>日</span>&nbsp;&nbsp;
	    					 <span class="spn2"><?php echo substr($val['addtime'],-8,-3); ?></span>&nbsp;&nbsp;
	    					 <span class="spn3">阅读&nbsp;&nbsp;(&nbsp;<i><?php echo $val['shownum']; ?></i>&nbsp;)</span>
    					 </div>
    					 <div class="readtext"><a href="<?php echo base_url('sc/index/information_detail?id='.$val['id']);?>" target="_blank">+阅读全文</a></div>
						</li>
                        
                    
						<?php }?>
						</ul>
						<div class="page_box">
							<ul class="ul_page"><?php echo $link_page[$item];?></ul>
						</div>
                </div>
                
             <?php endforeach;?>

               
                
 
                
            </div>
            <!--==============此处分页============= -->
          
            <p class="more_info_title"><span class="fl">想要获取更多旅游资讯请访问帮游旅游网</span><a href="http://www.1b1u.com/lyzx" class="fl">http://www.1b1u.com/lyzx</a></p>
        </div>
        
        <!--================猜您喜欢================ -->
        <div class="like_line">
        	<div class="title_txt"><span>猜您喜欢</span></div>
            <ul class="line_line_list clear">
			
			<?php  foreach ($guess_line as $key => $val){?>
                <!-- 将cj和gn改为line,添加后缀.html-->
            	<li><a href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>"		 target="_blank">
                	<div class="like_line_img">
                		
                		<img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']);?>">
                	</div>
                    <div class="like_line_info">
                    	<p class="line_name"><span><?php	echo $val['linename']?></span><?php	echo $val['linetitle']?></p>
                        <div class="line_price clear">
                        	<span class="current_price fl">¥<i><?php	echo $val['lineprice']?></i>起</span>
                            <span class="original_price fl">¥<i><?php	echo $val['marketprice']?></i></span>
                            <span class="privilege_price fr">省<i><?php	echo $val['saveprice']?></i></span>
                        </div>
                    </div>
                </a></li>
			<?php }?>
			
                
            </ul>
            
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
					<div class="sc_input_list" style="padding-bottom:10px;">
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
				<form action="/srdz" id="custom_form" method="post" target="_blank">
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
        
        <!--=================北美游记================== -->
        <div class="travel_notes">
        	<div class="travel_title"><span>最热线路</span></div>
            <ul class="travel_note_list">
 
			<?php foreach ($hot_tok as $key => $val){?>
             	<li>
                    <!-- 将cj和gn改为line,添加后缀.html-->
                	<a href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'#item8' : '/line/'.$val['id'].'#item8'; ?>"	 target="_blank"	>
                		<div class="travel_note_img">
                			
                			<img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']);?>">
                		</div>
                    	<p class="travel_note_title"><?php echo $val['linename'].$val['linetitle']?></p>
                    	<div class="over" style=" padding-bottom:5px;">
                    		<div class="jiage_list_no"><i>¥</i><span><?php echo $val['lineprice']; ?></span><i>起</i></div>
                    		<div class="jiage_list_nos"><i>¥</i><s><?php echo $val['marketprice']; ?></s></div>
                    		<div class="jiage_she">
                    			<span>省</span>
                    			<i><?php echo $val['saveprice']; ?></i>
                    		</div>
                    	</div>
                	</a>
                	<!--<span class="cancle_num">2580</span>--><!-- <span class="comment_num"><?php	echo $val['comment_count']?></span> -->

                </li>
					<?php }?>
            </ul>
        </div>
        
        
 
        
        
        
        
        
        
        
        
        
        <!--================帮游公众号================= -->
        <div class="bu_public_num">
        	<div class="public_num">
                <p>帮游公众号</p>
                <div class="clear">
		            	<div class="weixin_img fl"><img src="<?php echo BANGU_URL.$index_public_qrcode[0]['pic'];?>"/></div>
		                <div class="text_title fr"><?php echo $index_public_qrcode[0]['remark']; ?></div>
                </div>
            </div>
            <div class="console_expert">
                <div class="expert_photo"><a href="http://www.1b1u.com/guanj" target="_blank"><img src="<?php echo base_url();?>static/img/sc/console_expert.jpg"></a></div>
                <a href="http://www.1b1u.com/guanj" target="_blank" class="console_button"></a>
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
			<?php foreach ($friend_link as $key=>$link):?>
				<li><a href="<?php echo $link['url'];?>" target="_blank" ><img src="<?php echo BANGU_URL.$link['icon']; ?>" /></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

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
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript">
$(function(){
	
	$(".travel_note_list li").eq(2).css("border-bottom","0px");
	
	$(".tab").tab({	
		type:'click'		
	});

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

$(".information_type li").click(function(){
    $(this).addClass("on").siblings().removeClass("on");
})



//下拉菜单隐藏
$(document).mouseup(function(e){

    var _con = $('.tab_con');   // 设置目标区域

    if(!_con.is(e.target) && _con.has(e.target).length === 0){

        $(".sc_input_list").css("z-index","10");  

        $(".inp_two_hidden").hide();

    }

});

$(".travel_note_list li").hover(function(){
    $(this).find(".travel_note_title").addClass("col_red");
},function(){
     $(this).find(".travel_note_title").removeClass("col_red");
})

$(".cancle_num").click(function(){
    $(this).toggleClass("like_red");
});

$(".info_list").tab({
        
    navClass:'on',
            
    tabNav:'.information_type>li',
    
    tabCon:'.tabcontents>div',
    
    type:'click'    
        
});



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
	var url = '<?php echo base_url();?>guanjia/';     // 将guanj改为guanjia
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
				$('#search_line_form').attr('action','/guanjia/na-'+key_word+'.html');    // 将guanj改为guanjia
				$('#search_line_form').submit();
			}
		});


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

	$(".service_city").html("选择城市");
	$("#visit_service").attr("data-item","0");
	$("#visit_div").css("display","block");
	$.post("/common/area/getRegionData",{cityid:cityid},function(data){
		var data = eval("("+data+")");
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
	})
}


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

$(function(){
    var tarLi=$(".travel_note_list li").length;
    //alert(tarLi);
    if(tarLi==0){
        $(".travel_notes").hide();
    }
})


$(".tab_cons .ul_page li a").click(function(){
   var cate=$(this).parent().parent().parent().parent().attr("data-id");
   var page=$(this).attr("page_new");
  
   $.ajax({
     type:"POST",
     async : false, 
     data:{page:page,cate:cate,isajax:true},
     url:"<?php echo base_url().'sc/index/information_list'?>",
     dataType:"json",
     success:function(data){
         var str="";
         var base_url="<?php echo base_url();?>";
         var json=data.result;
         for(var o in json)
         {
            //console.log(json[0]['id']);
          
		
			str +="<li><a href='"+base_url+"sc/index/information_detail?id="+json[o]['id']+"' target='_blank'>";
			str +="<div class='information_img fl'><img src='"+base_url+json[o]['pic']+"' data-original='"+base_url+json[o]['pic']+"'></div>";
			str +="<div class='information_txt fr'><h4>"+(json[o]['title']==null?'':json[o]['title'])+"</h4><p>"+(json[o]['content_paper']==null?'':json[o]['content_paper'])+"</p></div></a>";
            str +="<div class='attention'><span class='spn1'>"+json[o]['addtime'].substr(0,4)+"年"+json[o]['addtime'].substr(5,2)+"月"+json[o]['addtime'].substr(8,2)+"日</span>&nbsp;&nbsp;<span class='spn2'>"+json[o]['addtime'].substr(11,5)+"</span>&nbsp;&nbsp;<span class='spn3'>阅读&nbsp;&nbsp;(<i>"+json[o]['shownum']+"</i>&nbsp;)</sapn></div>";
            str +="<div class='readtext'><a href='"+base_url+"sc/index/information_detail?id="+json[o]['id']+"' target='_blank'>+阅读全文</a></div>";
			str +="</li>";
         }
        
         $(".tab_cons[data-id="+cate+"] .information_list_info").html(str);
         $(".tab_cons[data-id="+cate+"] .ul_page .ajax_page").each(function(){
            if($(this).hasClass('total')==false&&$(this).hasClass('next')==false&&$(this).hasClass('lastest')==false&&$(this).hasClass('last')==false)
     	    if($(this).find("a").attr('page_new')==page)
     	    {
     	    	 $(this).addClass("active").siblings().removeClass("active");
     	    }
     	  });
         var total=$(".tab_cons[data-id="+cate+"] .ul_page .lastest").find("a").attr("page_new");
    	 if(page<total)
    	     var next=parseInt(page)+1;
    	 else
        	 var next=total;
         $(".tab_cons[data-id="+cate+"] .ul_page .next").find("a").attr("page_new",next);
         
     },
     error:function(){
     }
     
   })

   
})
 
$(function(){
	$(".banner_img img").lazyload({
      effect : "fadeIn"
    })
    $(".information_img img").lazyload({
    	effect:"fadeIn"
    })
    $(".like_line_img img").lazyload({
    	effect:"fadeIn"
    })
    $(".travel_note_img img").lazyload({
    	effect:"fadeIn"
    })

    $(".information_type li").click(function(){
    	$(".information_img img").lazyload({
    		effect:"fadeIn"
    	})
    })

    $(".one li").click(function(){
    $(this).removeClass("on");
})
    
})

$(function(){
	changes();
	function changes(){
		var html = $(".information_type").find(".on").html();
		$(".changes").html(html);
	}
	
	//alert(html)
	$(".information_type li").click(function(){
		changes();
	})
})

</script>

