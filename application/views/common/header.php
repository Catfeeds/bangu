<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	header ( 'Content-Type:text/html; charset=UTF-8' );
	$this->load->library('session');
	$this->username=$this->session->userdata('c_username');
?>
<?php $this->load->view('common/login_box'); ?>
<link href="<?php echo base_url('static/css/jock-citypicker-2.0.min.css'); ?>" rel="stylesheet" />


<!--[if IE]>

<style>

.city_name i{ display:none;}
.return_top{ display:none;}

</style>

<![endif]-->
    <style>
        .moblic{ position: relative;z-index: 9999;}
        .moblic .weimaBox{ position: absolute; top: 30px; left: -80px; width: 200px; background: #fff; border: 1px solid #f1f1f1; display: none;}
        .moblic .weimaBox .download { float: left; width: 80px; margin: 10px ; margin-bottom: 0;}
        .moblic .weimaBox .download img{ width: 100%; height: 100%; display: block;}
        .moblic .weimaBox .download span{ display: block; width: 100%; text-align: center;}
    </style>
	<div class="header">
    	<div class="header_top">
        	<div class="w_1200">
                <div class="header_top_fl" style=" width:auto;">
                    <span  class=" fl">您好&nbsp;,&nbsp;欢迎来到帮游旅行网！</span>
                    <a href="javascript:void(0);" class="logo_top" style=" margin: 0;" rel="sidebar" onclick="addFavorite('bangu.com','jiarong')" ><!-- <i class="header_collection"></i> -->收藏本站</a>
                    <a href="#" class="moblic">
                        <span>手机帮游</span>
                        <div class="weimaBox">
                            <div class="download">
                                <img src="<?php echo base_url('static/img/gongzhong.jpg'); ?>" alt="" />
                                <span>公众号二维码</span>
                            </div>
                            <div class="download">
                                <img src="<?php echo base_url('static/img/load.png'); ?>" alt="" />
                                <span>app下载</span>
                            </div>
                        </div>
                    </a>
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
                </div>
                <div class="header_top_fr">
                	<a href="<?php $memberid=$this->session->userdata('c_userid'); echo $web['expert_question_url'].'/kefu_member.html?mid='.$memberid;?>" id="user_message" target="_blank"><img src="<?php echo base_url('static'); ?>/img/user_message.gif" /></a>
                    <?php if(!isset($this->username) ||empty($this->username)){  ?>
					<a href="/login">登录</a>
					<a href="/register">注册</a>
					<?php }else{   ?>
					<a href="/order_from/order/line_order" class="username">您好，<?php echo $this ->session ->userdata('c_loginname');?></a>
					<a href="/login/logout">退出</a>
					<?php } ?>
					<a class="link_black" href="<?php echo site_url('index/site_map');?>">网站地图</a>
                </div>
        	</div>
        </div>
        <div class="header_content">
        	<div class="w_1200 clear fimiry" style="position:relative; z-index:1001;">
                <div class="header_logo fl">
                	<h1 class="logo_img fl">
                        <a href="<?php echo sys_constant::INDEX_URL?>"><img src="/static/img/shouye_logo.png" title="帮游旅行网" alt=""/></a>
                    </h1>

                        <div class="city">
                            <div class="city_name">

                            	<span class="current_city border_none">
                            	<?php
                            		$city_location = $this->session->userdata('city_location');
                            		$lastStr = mb_substr($city_location ,-1);
                            		if ($lastStr == '市') {
                            			$city_location = mb_substr($city_location ,0 ,-1);
                            		}
                            		if(!empty($city_location)) echo $city_location.'站';else echo '深圳站';
                            	?><i class="triangle-down"></i></span>
                                <div class="igcPw"></div>
                                <span class="Choice_current border_none">选择城市</span>
                           </div>
                        </div>
                        <div id="headerStartCity"></div>

                        <div class="city_box fl">
                        	<div class="city_block">
                           		<span class="current_city current_topic">呼和浩特<i class="triangle-down"></i></span>
                                <div class="igcPh"></div>
                           	</div>
                            <div class="city_cleso">x</div>
                            <div class="hidd_city">

                            	<!--cityTab-->
                            	<ul class="cityTab">
                                	<li class="TabLik">热门城市</li>
                                    <li>ABCDEFG</li>
                                    <li>HIJKLMN</li>
                                    <li>OPGRST</li>
                                    <li>UVWXYZ</li>
                                </ul>

                            	<!--cityList-->
                            	<ul class="cityList">

                                	<li style="display:block;">

                                        <!--citySite-->
                                        <ul class="citySite topic">
                                        	<li>北京</li>
                                            <li>天津</li>
                                            <li>呼和浩特</li>
                                            <li>澳门</li>
                                            <li>北京</li>
                                            <li>天津</li>
                                            <li>呼和浩特</li>
                                            <li>澳门</li>
                                            <li>北京</li>
                                            <li>天津</li>
                                            <li>呼和浩特</li>
                                            <li>澳门</li>
                                            <li>北京</li>
                                            <li>天津</li>


                                        </ul>
                                    </li>

                                    <li>
                                    	<span>A</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>
                                            <li>济南</li>
                                            <li>石家庄</li>

                                        </ul>

                                        <span>B</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>
                                            <li>济南</li>
                                            <li>石家庄</li>
                                            <li>齐齐哈尔</li>

                                        </ul>

                                        <span>C</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>

                                        </ul>

                                        <span>D</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>

                                        </ul>

                                        <span>E</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>

                                        </ul>

                                        <span>F</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>

                                        </ul>

                                        <span>G</span>
                                        <!--citySite-->
                                        <ul class="citySite">
                                        	<li>北京</li>
                                            <li>天津</li>

                                        </ul>

                                    </li>

                                </ul>

                            </div>

                    </div>
                </div>


                <div class="header_search fl">
                	<form id="search_line_form" class="search_line_form" action="<?php if(!empty($search_type) && $search_type ==1){echo site_url('guanjia');}else{echo site_url('all');}?>" method="post">
	                	<select class="select" name="classid">
	                        <option value="0" >产品</option>
	                        <option value="1" <?php if (!empty($search_type) && $search_type == 1 ) echo "selected='selected'" ?>>管家</option>
	                    </select>
	                	<input type="text" class="search_input fl" placeholder="快速检索产品或专家" value="<?php if(empty($key_word)) echo '' ; else echo $key_word ;?>"  name="key_word" style="_border:none;outline: none;"
                         />
                         <!-- onkeyup="this.value=this.value.replace(/[^\u4e00-\u9fa5\w]/g,'')" ；this.value=this.value.replace(/[^\u4e00-\u9fa5\w]/g,'' -->
	                	<button type="button" class="search_submit_ico fl" style="_border:none" ></button>
                	</form>
                </div>
                <div class="header_tel fr">
                	<p><i class="tel_ico"></i>24小时热线</p>
                  	<p class="tel_num"><i>400-693-9800</i></p>
                </div>
            </div>
        </div>
        <div class="header_nav">
        	<div class="w_1200 clear fimiry">
                <ul class="fl index_nav">
					<?php
						//获取当前url
						$now_url = $_SERVER['REQUEST_URI'];

						if (!empty($now_url) && $now_url != '/') {
							$now_url = substr($now_url,0 ,strpos($now_url ,'/' ,2));
						}
						foreach($navData as $key =>$val) {
							$on = '';
							if ($val['link'] == $now_url) {
								$on = 'on';
							}
							if ($key == 0 && ($now_url == '/' || $now_url == '/index')) {
								// seo优化，在链接后加上斜杠
								echo "<li class='on'><a href='{$val['link']}/'>{$val['name']}</a></li>";
							} else {
								echo "<li class='{$on}'><a href='{$val['link']}/'>{$val['name']}</a></li>";
							}

						}
					?>
                </ul>
				<div class="index_nav_right fr" >
					<a class="link_black fl" href="http://www.1b1u.com/lyzx" target="_blank">旅游资讯</a>   <!--将帮游社区改为旅游资讯-->
					<?php if ($now_url == '/yj'):?>
                    <!--<a class="link_black fl on" href="/yj">体验分享</a>-->
                    <a class="link_black fl on" href="/youji/">体验分享</a>
                    <?php else:?>
                    <!--<a class="link_black fl" href="/yj">体验分享</a>-->
                    <a class="link_black fl" href="/youji/">体验分享</a>
                    <?php endif;?>

                </div>
            </div>
        </div>
    </div>

	<!-- 右侧返回顶部 -->
	<div class="return_top">
    	<ul>
        	<li style="display:none;"><a href="#" title="找客服" class="kefu_link"><img class="kefu_logo" src="<?php echo base_url('static'); ?>/img/kefu_ico.png"/><img class="kefu_message" src="<?php echo base_url('static'); ?>/img/kefu_message.png"/></a></li>
            <li><a href="#" title="返回顶部" class="return_top"><i class=""></i></a></li>
        </ul>
	</div>
    <script type="text/javascript" src="<?php echo base_url('static/js/jock-citypicker-2.0.min.js'); ?>"> </script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.select.js'); ?>" ></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.choiceCity.js'); ?>" ></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceHeaderCityJson.js'); ?>" ></script>
	<script>
    var tim = null;
    $(".moblic").hover(function(){
        clearTimeout(tim);
        $(this).find(".weimaBox").show();
    },function(){
        var mov = $(this).find(".weimaBox");
        tim = setTimeout(function () {
            mov.hide();
        }, 500);
    })
function addEvent(obj,type,fn){
    if(obj.attachEvent){
        obj.attachEvent('on'+type,function(){
            fn.call(obj);
        })
    }else{
        obj.addEventListener(type,fn,false);
    }
}
addEvent(window,'scroll',function(){
    if ($(window).scrollTop() <300) {
		$(".return_top ul li").eq(1).hide();
	} else {
		$(".return_top ul li").eq(1).show();
	}
});
$(".return_top").click(function(){$("html,body").animate({scrollTop:0},500);});
		$(".search_input").focus(function(){
			$(this).css("border-color","#f00;");
		});
		$(".change_city_close").hover(function(){
			$(this).addClass("hover_this");
		},function(){
			$(this).removeClass("hover_this");
		});

		//头部搜索
		$('.search_submit_ico').click(function(){
			var top_name = $('.select_showbox').html();
			var key_word = $('input[name="key_word"]').val();

			if (top_name == "产品") {
				location.href="/all/kw-"+key_word+'.html';
			} else {
				$('#search_line_form').attr('action','/guanjia/na-'+key_word+'.html');
				$('#search_line_form').submit();
			}
		});

		//按回车键时搜索
		$(document).keydown(function(event){
			if (event.keyCode == 13) {
				if($("input[name='key_word'").is(':focus')) {
					var top_name = $('.select_showbox').html();
					var key_word = $('input[name="key_word"]').val();

					if (top_name == "产品") {
						location.href="/all/kw-"+key_word+'.html';

					} else if (top_name == '管家') {
						location.href="/guanjia/na-"+key_word+'.html';
					}
					return false;
				}
			}
		});

	$(".city").click(function(){
		var tisWei=$(this).width();
		//alert(tisWei);
		$(".hidden_city").css("width",tisWei*1.5)

		//alert($("#city_location_name").html())
			$(".hidden_city").show();
		})

		//更改站点城市
		$(".hidden_city ul li").click(function(){
			var thishtml=$(this).html();
			var id = $(this).attr("data-val");

			$("#city_location_name").html(thishtml+'站');
			$("#this_city").html(thishtml+'站');
			$(".hidden_city").hide();

			$.post(
				"<?php echo base_url('index/set_city_location')?>",
				{'city_location':thishtml,cityId:id},
				function(data){
					location.reload();
					$(".change_city_close").css("display","none");
			});
		})

		$("#this_city").click(function(){
			$(".hidden_city").hide();
		})
		$(document).mouseup(function(e) {
          var no_con = $('.select_option '); // 设置目标区域
          if (!no_con.is(e.target) && no_con.has(e.target).length === 0) {
			  	$(".select_option").hide();
          	}
      	})
		$(".change_city_close").click(function(e){
			citypicker.show({left:$("#city_name_change").offset().left-10000, top:$("#city_name_change").offset().top-10000});
			$(this).hide();
			e.stopPropagation();
		});
		$(document).mouseup(function(e) {
          var _con = $('.mod_list_city'); // 设置目标区域
          if (!_con.is(e.target) && _con.has(e.target).length === 0) {
			  $(".change_city_close").hide();
              $(".mod_list_city").hide();
          }
      })

	  //用户的提示消息
function getNewMsg(){
        var send_url="<?php echo $web['expert_question_url'].'/chat!getMsgCount.do'?>" ;
		var c_userid = "<?php echo $this->session->userdata('c_userid');?>";

            $.ajax({
                url : send_url,
                dataType:"jsonp",
                type : 'POST',
                data : {
                    'mid' : c_userid,
                    'action':0
                },
                success : function(jsonData) {
                    if (jsonData.code == '2000') {//成功
                        if(jsonData.data >0){//有新消息
                            //显示泡泡
                            $("#user_message").show();
                        }else{
                            //隐藏泡泡
                             $("#user_message").hide();
                        }
                    } else {
                        //alert('获取消息失败');
                    }
                }
            });
}
setInterval(getNewMsg,5000);

	$(function(){
		$("input").attr("autocomplete","off");
			var thishtml=$("#city_location_name").html();
			$("#this_city").html(thishtml);
	})

/********************选择城市相关**************************/
$("#headerStartCity").choiceCity({
		datajson:chioceHeaderCityJson,
		showElement:'.city_name',
		defaultName:'<?php echo $this->session->userdata('city_location')?>',
		dataClick:function(obj){
			$.ajax({
				url:'/index/set_city_location',
				type:'post',
				dataType:'html',
				data:{id:$(obj).attr('data-val')},
				success:function(msg) {
					if (msg == 'error') {
						alert('当前选择站点有误，请联系客服');
					} else {
						location.reload();
					}
				}
			});
		}
	});

	//城市显示隐藏;: ;
	$('.city,.city_box').mouseover(function(){
		//$(this).parent().siblings('.city_box').show();
       $(".current_city").css("box-shadow","0 0 8px 0 #999")
	});
    // $('.city_box,.city').mouseout(function(){

    //    $(".current_city").css("box-shadow","none")
    // });
    // if($(".city_box").is(":hidden")) {
    //     $(".current_city").css("box-shadow","none")
    // }else{
    //     $(".current_city").css("box-shadow","none")
    // }
	/*
	$('.city_box').mouseleave(function(){
		$(this).hide();
	});
	*/
	//城市选择选项卡
	$('.cityTab>li').click(function(){
		$(this).addClass('TabLik').siblings().removeClass('TabLik');
		var index =$(this).index();
		$(".cityList>li").eq(index).show().siblings().hide();
	});

	//城市选择 添加选中样式
	$('.citySite>li').click(function(){
		$(this).addClass('SiteLik');
	})

	$('.city_cleso').click(function(){
		$('.city_box').hide();
	})
</script>
