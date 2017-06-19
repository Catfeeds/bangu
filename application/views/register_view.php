<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员注册-帮游旅行网</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta content="会员注册,免费注册,会员" name="keywords" />
<meta content="注册成为帮游旅游网会员，可享数万名资深旅游管家为您量身定制国际国内游，还有更多旅游惊喜等着你。" name="description" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/user/login.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<style>
html{ height:100%; background: #fff;}
body{ height:100%; min-width: 1000px;}
</style>
</head>
<body class="body_back" style=" height:100%; font-family: '微软雅黑' !imortant">
<div class="body-2">
<!--头部 开始-->
<div class="most_top">
	<div class="w_1200">
	    <div class="welcome green_word fl">您好&nbsp;,&nbsp; 欢迎来到帮游旅行网！</div>
	    <div class="enshrine"><a href="javascript:void(0);" onclick="addFavorite('bangu.com','jiarong')" class=" green_word" rel="sidebar">收藏本站</a></div>
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
		    <div class="context_menu">
	    	<ul>
	    		<li><a class="green_word" href="/login">登录</a></li>
	            <li><a class="green_word" href="/register">注册</a></li>
	            <li><a class="link_black" href="<?php echo site_url('index/site_map');?>">网站地图</a></li>
		   	</ul>
	    </div>
    </div>
</div>
<div class="regis_box">
	<div class="head_logo">
		<div class="logo_box"><a href="<?php echo sys_constant::INDEX_URL?>"><img src="/static/img/reg_logo.png" alt="logo"/></a></div>
		<div class="title_word">免费注册</div>
	</div>
</div>
<!--头部 结束-->
<!--内容开始-->
<div class="stered_content">
	<div class="stered_content_too">
		<div class="stered_back">
        	<div class="main_title relative">
		    	<div class="title_xian"></div>
                <div class="title_titl"><div class="regTitle">注册</div></div>
		    	<div class="direct_logo">已经有帮游帐号了？您可以直接<a  href="/login" target="_blank">登录</a> </div>
	    	</div>
				<form class="form-horizontal form-bordered" method="post" id="register" action="<?php echo site_url('register/do_register')?>">
            	<div class="stered_main clear">
            		<div class="form_con">
                	<div class="stered_input" style="position:relative;">
                		<div class="mingchengs"><i>*</i>手机号码：</div>
                    	<input class="stered_two fr greed_mark shouji" name="mobile" placeholder="手机号" id="input1" maxlength="11"/>
                        <div class="regIco icoIcos1"></div>
                    	<div class="ti_box">
                            <i></i><span>信息填写不正确</span>
                        </div>
                        <div class="defaTi">您的登陆账户为手机号码</div>
                    </div>
                    
                    <div class="stered_input">
                    	<div class="mingchengs"><i>*</i>设置密码：</div>
                    	<input class="stered_four fl greed_mark mima" name="password" type="password" placeholder="输入密码" id="input3" maxlength="20"/>
                        <div class="regIco icoIcos2"></div>
                    	<div class="ti_box">
                            <i></i><span>信息填写不正确</span>
                        </div>
                        <div class="defaTi">密码格式格式6-18位字母或数字</div>
                    </div>
                    <div class="stered_input" id="pw2">
                    	<div class="mingchengs"><i>*</i>验证密码：</div>
                    	<input class="stered_four fl greed_mark zaici" name="repass" type="password" placeholder="输入密码" maxlength="20" id="input4"/>
                        <div class="regIco icoIcos3"></div>
                    	<div class="ti_box">
                            <i></i><span>信息填写不正确</span>
                        </div>
                        <div class="defaTi">两次密码要填写一致</div>
                    </div>
                    <div class="stered_input" id="yzm" style="display:none;width:212px;">
                    	<input class="stered_five  fl" type="text" placeholder="验证码" name="code" id="verification" maxlength="4"/>
                        <div class="stered_yanzheng fl">
                        <img style="-webkit-user-select: none; width:88px; height:34px;" id="verifycode" src="<?php echo base_url('tools/captcha/index'); ?>" onclick="this.src='<?php echo base_url('tools/captcha/index');?>?'+Math.random()" />
                        </div>
                        <input type="button" value="发送" class="yzm_tijiao" />
                        <input type="button" value="关闭" class="yzm_guanbi" />    
                    </div>
                    <div class="stered_input">
                    	<div class="mingchengs"><i>*</i>短信验证：</div>
                    	<input class="stered_three fl" placeholder="验证码" name="mobile_code" id="input2" maxlength="4"/>
                        <div class="regIco icoIcos4"></div>
                        <div class="stered_phone fr "><span class='mobile_code' id="btnSendCode">获取短信验证码</span></div>
                    </div>
                    
                    <div class="stered_agreement" style="padding-left:90px">
                    	<input type="checkbox" name="isAgree" class="fl" value="1" checked="checked" id="input6"/>
                        <div class="stered_agreement_two fl">我接受<a href="/service/member_agreement" target="_blank"><<帮游会员协议条款>></a></div>
                    </div>
                    <div class="stered_botton">
                    	<input type="hidden" name="url" value="<?php echo $url;?>" />
                    	<input type="hidden" name="channel" value="PC" />
                    	<input type="submit" name="submit" value="免费注册" />
                    </div>
                    <!--注册成功 弹窗 送优惠劵--> 
                    <div class="success_tips tip_ondeBar"> 
                    	<div class="guanbi_succe"></div>   <!--关闭按钮 -->
                        <div class="rmb_succe">您已获得<span>320<span>元大礼包</div>
                        <div class="see_succe"><a href="/base/coupon/coupon_used_0_1.html">查看我的礼品</a></div>
                        <span class="go_shouye"><a href="/" target="_blank">跳转到首页</a></span>
                        <span class="go_huiyuan"><a href="/order_from/order/line_order" target="_blank">跳转到会员中心</a></span>
                    </div>
                    <!--注册成功 弹窗 正常注册-->
                    <div class="success_tips tip_ondeOar">
                        <div class="guanbi_succe"></div>   <!--关闭按钮 -->
                        
                        <span class="go_shouye"><a href="/" target="_blank">跳转到首页</a></span>
                        <span class="go_huiyuan"><a href="/order_from/order/line_order" target="_blank">跳转到会员中心</a></span>
                    </div>
                    </div>
                    </form>
                </div>    
            </div>
        </div> 
	</div>
	<!--尾部开始-->
<div class="login-foot clear">
	<ul>
    	<li><a href="/admin/b2/login">管家登录</a><span>丨</span></li>
    	<li><a href="/admin/b1/index">供应商登录</a><span>丨</span></li>
    	<li><a href="/article/privacy_desc" target="_blank">隐私声明</a><span>丨</span></li>
        <li><a href="#">网站地图</a><span>丨</span></li>
        <li><a href="/article/index" target="_blank">常见问题</a><span>丨</span></li>
        <li><a href="/article/recruit" target="_blank">人才招聘</a><span>丨</span></li>
        <li><a href="/article/contact_us" target="_blank">联系我们</a><span>丨</span></li>
        <li><a href="/article/about_us" target="_blank">关于我们</a></li>
    </ul>
    <div class="login-keep">
    	 <?php
             echo 'Copyright © 2015-2016 '.$web['webname'].' '.$web['url'].' | 营业执照 | ICP证：'.$web['icp'];
         ?>
    </div>
</div>
<!--尾部结束-->
<script src="<?php echo base_url('static/js/placeholder.js') ;?>"></script>
<script src="<?php echo base_url('static/js/common.js') ;?>"></script>
<script type="text/javascript">

$(function(){ $('input, textarea').placeholder(); });
//提交表单信息  
var s = true;       
$("#register").submit(function(){
	if (s == false) {
		return false;
	} else {
		s = false;
	}
	//success_tips 注册成功了就显示这个 div
	$("#register").find("input").focus().trigger('blur');
	if($("i").hasClass("tri_defa") || $("i").hasClass("tri_no")){
		s = true;
		return false;
	} else {
		var url = $("input[name='url']").val();
		$.post("/register/doRegister" ,$(this).serialize(),function(data) {
			s = true;
			var data = eval("("+data+")");
			if (data.code == 2000) {
				jQuery.ajax({ type : "POST", url : "/uc/sysreg.php", data : null,success : function(response) {
						jQuery('body').append(response);
						//window.location.href=url;
                        //0正常注册; //1送优惠券
						tips(0);
					}
				});
				
			} else {
				alert(data.msg);
			}
		})
	}
	return false;
})
function tips(m){
    //正常注册
    if(m==0){
        $(".tip_ondeOar").show();
    }
    //送优惠券
    if(m==1){
        $(".tip_ondeBar").show();
    }
}
//发送验证码
var codeStatus = true;
$(".yzm_tijiao").click(function(){
	if (codeStatus == false) {
		return false;
	} else {
		codeStatus = false;
	}
	var mobile = $("input[name='mobile']").val();
	var code = $("#verification").val();
	if (!isMobile(mobile)) {
		alert('请填写正确的手机号');
		codeStatus = true;
		return false;
	}
	$.post("/send_code/sendMobileCode",{mobile:mobile,type:1,verifycode:code},function(json){
		codeStatus = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			countdown('btnSendCode');
			$("#yzm").hide();
		} else {
			alert(data.msg);
		}
		$('#verifycode').trigger("click");
	});
})
$(function(){
	//************弹出验证码 效果
    $(".mobile_code").click(function(){
        $("#verifycode").trigger("click");
        $("#yzm").show();
    });
    $(".yzm_tijiao").click(function(){
        $("#yzm").hide();
    });
    $(".yzm_guanbi").click(function(){
        $("#yzm").hide();
    });
})
//获取验证焦点
$(".greed_mark").focus(function(){
    $(this).siblings(".ti_box").hide();
    //$(this).addClass("invalid")
    $(this).removeClass("inverror").addClass("invalid")
})
//**************手机号验证
$(function(){
    $(".shouji").blur(function(){
        var mobile = $(this).val();
        if(!mobile.match(/[0-9]/)){   
            $(this).siblings(".ti_box").find("span").html("您填写的不是正确的手机号!");
            $(this).siblings(".ti_box").show();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").addClass("inverror")
        }else if(mobile.length<=10){
            $(this).siblings(".ti_box").find("span").html("填写格式少于11位或为空!");
            $(this).siblings(".ti_box").show();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").addClass("inverror")
        }else{
            $(this).siblings(".ti_box").hide();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").removeClass("inverror")
            $(".mima").focus();
        }
    })
//***********************密码验证
    $(".mima").blur(function(){
        var mobile = $(this).val();
        if(!mobile.match(/^[0-9a-zA-Z]*$/)){   
            $(this).siblings(".ti_box").find("span").html("密码为6-18位数字或字母的组合!");
            $(this).siblings(".ti_box").show();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").addClass("inverror")
        }else if(mobile.length<6 || mobile.length>20){
            $(this).siblings(".ti_box").find("span").html("密码格式少于6位或大于18位!");
            $(this).siblings(".ti_box").show();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").addClass("inverror")
        }else{
            $(this).siblings(".ti_box").hide();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").removeClass("inverror")
            $(".zaici").focus();
        }
    })
//********************两次密码验证
    $(".zaici").blur(function(){
        var mobile = $(this).val();
        var pw1 = $(".zaici").val();
		var pw2 = $(".mima").val();
        if(pw1!=pw2){
			$(this).siblings(".ti_box").find("span").html("密码填写不一致!");
            $(this).siblings(".ti_box").show();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").addClass("inverror")
		}else if(mobile.length==0){
            $(this).siblings(".ti_box").find("span").html("当前填写为空!");
            $(this).siblings(".ti_box").show();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").addClass("inverror")
        }else{
            $(this).siblings(".ti_box").hide();
            $(this).siblings(".defaTi").hide();
            $(this).removeClass("invalid").removeClass("inverror")
        };
    })
})
//********************//
$(function(){
	$("input").attr("autocomplete","off")
});
$(function(){
	$(".guanbi_succe").click(function(){
		$(".success_tips").hide();
	})
})
</script>

<script>
//百度统计
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?da409c07ec1641736bde4ab39783b82f";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>
