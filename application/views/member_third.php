<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/login_third.css'); ?>" rel="stylesheet"/>
<title>第三方信息完善</title>
</head>
<body>
<!--头部 开始-->
<div class="login_header">
	<div class="login_logo fl" ><a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url('static/img/logo.png'); ?>"/></a></div>
    <div class="login_member fl"><h2 class="fl">信息完善</h2></div>
    <div class="login_member_link fr">
    <span class="login_member_link_1"> <a href="<?php echo sys_constant::INDEX_URL?>">返回帮游旅行网首页</a></span></div>
</div>
<!--头部 结束-->
<!--内容开始-->
<div class="login_content clear">
	<div class="w_1200 clear">
    	<div class="login_back fl">
        	<div class="login_land_title"><span class="hydl">已有本站账号</span><span class="dtmm">创建新账号</span></div>
            <div class="third_head_photo"><img src="<?php echo $pic?>"/></div>
            <div class="third_head_name"><h3><?php echo $screen_name?> </h3>欢迎使用QQ帐号登录&nbsp;&nbsp;帮游&nbsp;&nbsp;官方网</div>
            <!--帮游会员登录-->
            <div class="huiyuan">	
			<form class="form-horizontal form-bordered" role="form" id="login_form1" method="post" action="<?php echo site_url('login/do_login');?>">
            <div class="info"><span><i></i><a>已有帮游会员账号,请登录账号进行绑定</a></span></div>  
            <div class="login_input">
            	<div class="login_number">
                	<div class="login_left fl">账<span class="zhanwei1"></span>号:</div>
                    <div class="login_right fl"><input placeholder="手机号/邮箱" autofocus type="text" class="login_input-1" name="username"/></div>
                </div>
                <div class="login_number">
                	<div class="login_left fl">密<span class="zhanwei1"></span>码:</div>
                    <div class="login_right fl"><input class="login_input-2" placeholder="请输入密码" type="password" name="password"/></div>
                </div>
                <div class="login_number">
                	<div class="login_left fl">验<span class="zhanwei2"></span>证<span style="width:8px; display: inline-block"></span>码:</div>
                    <div class="login_right fl"><input class="login_input-3" placeholder="请输入验证码" type="text" name="verifycode"/><span class="fr"><img style="-webkit-user-select: none" id="verifycode" src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()"></span></div>
                </div>
                <div class="login_botton"><input type="submit" value="登录或绑定会员账号" /></div>             
            </div>
			</form>
        </div>
        <!--动态密码登录-->
        <div class="dongtai">	
			<form class="form-horizontal form-bordered" role="form" id="dynamic_login" method="post" action="<?php echo site_url('login/createAccount')?>">
            <div class="info"><span><i></i><a>还没有游帮账号?赶紧注册一个</a></span></div>   
            <div class="login_input">
            	<div class="login_number">
                	<div class="login_left fl">手<span class="zhanwei2"></span>机<span style="width:8px; display: inline-block"></span>号:</div>
                    <div class="login_right fl"><input placeholder="手机号/邮箱" autofocus type="text" class="login_input-1" name="mobile"/></div>
                </div>
                 <div class="login_number">
                	<div class="login_left fl">密<span class="zhanwei1"></span>码:</div>
                    <div class="login_right fl"><input class="login_input-2" placeholder="请输入密码" type="password" name="password"/></div>
                </div>
                 <div class="login_number">
                	<div class="login_left fl">确认密码:</div>
                    <div class="login_right fl"><input class="login_input-2" placeholder="请再次输入密码" type="password" name="repass"/></div>
                </div>
                <div class="login_number">
                	<div class="login_left fl">验<span class="zhanwei2"></span>证<span style="width:8px; display: inline-block"></span>码:</div>
                    <div class="login_right fl">
                   	 	<input class="login_input-3" style=" width:80px;" placeholder="请输入验证码" type="text" name="code"/>
                    	<span class="fr" id="get_dynamic_code" style=" width:110px; text-align:center; border:1px solid #dedede; color:#666; cursor:pointer;">获取动态密码</span>
                    </div>
                </div>
                <div class="login_number" style=" margin:0; padding-left:20px;">
                	<input type="checkbox" value="1" name="isAccept" />愿意接受旅游资讯免费信息
                </div>
                <div class="login_number xieyi_book" style=" padding-left:20px;">
                	<input type="checkbox" value="1" name="isAgree" />我已阅读并接受<a href="rvice/member_agreement">游帮会员协议</a>
                </div>
                <div class="login_botton"><input type="submit" value="登录并绑定会员账号" /></div>               
            </div>
			</form>
        </div>
        </div>
        <div  class="logn_daoying"><div class="logn_daoying_1"></div> </div>
    </div>
</div>	
<!--内容结束-->
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
    	Copyright © 2015-2020 帮游旅行网 www.1b1u.com | 营业执照 | ICP证：粤B1-66886688 
    </div>
</div>
<!--尾部结束-->
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/common.js'); ?>" type="text/javascript"></script>
<script>
	$(function(){
		$('.login_input-1').blur(function(){
			var username = $(this).val();
			if(username.length>0){
				$('.info span').hide();
			}
		});
		$('.login_input-2').blur(function(){
			var pw = $(this).val();
			if(pw.length>0){
				$('.info span').hide();
			}
		});
		$('.login_input-3').blur(function(){
			var yzm = $(this).val();
			if(yzm.length>0){
				$('.info span').hide();
			}
		});
	});

	$('#login_form1').submit(function(){
		var username = $('.login_input-1').val();
		var pw = $('.login_input-2').val();
		var yzm = $('.login_input-3').val();
		if(username.length<=0){
			$('.info span a').html("账户不能为空");
			$('.info span').show();
			return false;
		}else{
			$('.info span').hide();
		}
		if(pw.length<=0){
			$('.info span a').html("请填写密码");
			$('.info span').show();
			return false;
		}else{
			$('.info span').hide();
		}
		if(yzm.length<=0){
			$('.info span a').html("请填写验证码");
			$('.info span').show();
			return false;
		}else{
			$('.info span').hide();
		}
		$.post(
			"<?php echo site_url('login/do_login')?>",
			$('#login_form1').serialize(),
			function(data) {
				data = eval('('+data+')');
				if (data.code == 2000) {
					window.location.href=data.msg;
				} else {
					$('#verifycode').trigger('click');
					$('.info span a').html(data.msg);
					$('.info span').show();
				}
			}
		);
		return false;
	})
	//动态登陆
	$("#dynamic_login").submit(function(){
		$.post("login/createAccount",$("#dynamic_login").serialize(),function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				window.location.href=data.msg;
			} else {
				alert(data.msg);
			}
		})
		return false;
	})
	//获取动态码
	var codeStatus = true;
	$("#get_dynamic_code").click(function(){
		if (codeStatus == false) {
			return false;
		} else {
			codeStatus = false;
		}
		var mobile = $("#dynamic_login").find("input[name='mobile']").val();
		$.post("/send_code/sendMobileCode",{mobile:mobile,type:1,verifycode:'无'},function(json){
			codeStatus = true;
			var data = eval("("+json+")");
			if (data.code == 2000) {
				countdown("get_dynamic_code");
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		});
		
	})

	//点击切换样式i
		$(".hydl").click(function(){
			$(this).css("border-bottom","1px solid #fff");
			$(".dtmm").css("border-bottom","1px solid #939393");
//			$(".dtmm").css("background","#f4f4f4")	
			//相对的隐藏显示
			$(".huiyuan").show();
			$(".dongtai").hide();
		})
		
		$(".dtmm").click(function(){
			$(this).css("border-bottom","1px solid #fff");
			$(".hydl").css("border-bottom","1px solid #939393");

			$(".huiyuan").hide();
			$(".dongtai").show();
		})
		$(function(){
			$("input").attr("autocomplete","off")
		})
</script>

</body>
</html>
