<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员登录-帮游旅行网</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="keywords" content="会员登录,用户登录,帮游通行证" />
<meta name="description" content="登录帮游旅游网会员，马上享数万名资深旅游管家为您量身定制国际国内游，放心旅行，当然帮游网。" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/user/login.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<style type="text/css">
	html,body{ height: 100% !important; width: 100%; }
	.login-foot{ border:none; }
</style>
</head>
<body style=" background: #fff;">
<!--头部 开始-->
<div class="login_header">
	<div class="login_logo fl" ><a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url('static/img/logo.png'); ?>"/></a></div>
    <div class="login_member fl"><h2 class="fl">会员登录</h2></div>
    <div class="login_member_link fr">
    <span class="login_member_link_1"> <a href="<?php echo sys_constant::INDEX_URL?>">返回帮游旅行网首页</a></span></div>
</div>
<!--头部 结束-->
<!--内容开始-->
<div class="login_content clear">
	<div class="w_1200 clear">
    	<div class="login_back fr">
        	<div class="login_land_title"><span class="hydl">普通会员登录</span><span class="dtmm">动态密码登陆</span></div>
            <!--帮游会员登录-->
            <div class="huiyuan">	
			 <?php if ($result_msg): ?>
				<div class="alert alert-danger fade in">
					<button data-dismiss="alert" class="close">×</button>
					<i class="fa-fw fa fa-times"></i> <strong>!</strong> <?php echo $result_msg;?>
				</div>
			<?php endif;?>
			<form class="form-horizontal form-bordered" role="form" id="login_form" method="post" action="<?php echo site_url('login/do_login')?>">
            <div class="infoBox">
				<div class="info"><span><i></i><a></a></span></div>   
			</div>
            <div class="login_input">
            	<div class="login_number">
                	<div class="login_left fl"><div class="loginIco"></div></div>
                    <div class="login_right fr"><input placeholder="手机号/邮箱" type="text" class="login_input-1" value="<?php echo $mobile; ?>" name="username"/></div>
                </div>
                <div class="login_number">
                	<div class="login_left fl"><div class="passIco"></div></div>
                    <div class="login_right fr"><input class="login_input-2" type="password" name="password" value="<?php echo $pass;?>" placeholder="登录密码"/></div>
                </div>
                <div class="login_number">
                	<div class="login_left fl"><div class="cationIco"></div></div>
                    <div class="login_right fr"><input class="login_input-3" placeholder="输入验证码" maxlength="4" type="text" name="verifycode"/><span class="fr"><img style="-webkit-user-select: none" id="verifycode" src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()"></span></div>
                </div>
                <div class="musgo">
                	<input class="chenchk" id="CheckBoxRememberMe" <?php if($isRemeber==1){echo 'checked="checked"' ;}?> name="isRemember" type="checkbox" value="1" />一周之内记住密码
                	<a href="<?php echo site_url('login/retrieve_pass')?>">忘记密码?</a>
                </div>
                <input type="hidden" name="url" value="<?php echo $url;?>" />
                <div class="login_botton"><input type="submit" id="ButtonLogin" style=" border:none; background-color:#f7830a; border-radius:3px; width:263px; height:40px; color:#FFF; font-size:24px; font-family:simhei" value="登 录" /></div>
            </div>
			</form>
            <div class="login_shu">您还不是帮游网会员?&nbsp;<a href="<?php echo base_url('register/index');?>">快速注册!</a></div>  
            <div class="otherlogin">
            <div class="otherTitle">使用官方合作账号登陆&nbsp;:</div>
            	<a href="<?php echo base_url('');?>sns/session/qq" class="sanqq"><span>QQ登录</span></a>
                <a href="<?php echo base_url('');?>sns/session/weibo" class="sanwb"><span>微博登录</span></a>
            </div>
        </div>
        <!--动态密码登录-->
        <div class="dongtai">	
			 <?php if ($result_msg): ?>
				<div class="alert alert-danger fade in">
					<button data-dismiss="alert" class="close">×</button>
					<i class="fa-fw fa fa-times"></i> <strong>!</strong> <?php echo $result_msg;?>
				</div>
			<?php endif;?>
			<form class="form-horizontal form-bordered" role="form" id="dynamic_login" method="post" action="<?php echo site_url('login/do_login')?>">
			<div class="infoBox">
				<div class="info"><span><i></i><a></a></span></div>   
			</div>
            
            <div class="login_input">
            	<div class="login_number">
                	<div class="login_left fl"><div class="loginIco"></div></div>
                    <div class="login_right fr"><input placeholder="手机号/邮箱" autofocus type="text" class="login_input-1" name="loginname"/></div>
                </div>
                <div class="login_number">
                	<div class="login_left fl"><div class="passIco"></div></div>
                    <div class="login_right fr">
                   	 	<input class="login_input-3" style=" width:80px;" type="text" name="dynamic_code"/>
                    	<span class="fr" id="get_dynamic_code" style=" width:88px; text-align:center; border:1px solid #dedede; color:#666; cursor:pointer;">获取动态密码</span>
                    </div>
                </div>
                <input type="hidden" name="url" value="<?php echo $url;?>" />
                <div class="login_botton"><input type="submit" style=" border:none; background-color:#f7830a; border-radius:3px; width:263px; height:40px; color:#FFF; font-size:24px; font-family:simhei" value="登 录" /></div>
               <div class="login_shu">您还不是帮游网会员?&nbsp;<a href="<?php echo base_url('register/index');?>">快速注册!</a></div>      </div>
			</form>
           	<div class="otherlogin">
	            <div class="otherTitle">使用官方合作账号登陆&nbsp;:</div>
	            	<a href="<?php echo base_url('');?>sns/session/qq" class="sanqq"><span>QQ登录</span></a>
	                <a href="<?php echo base_url('');?>sns/session/weibo" class="sanwb"><span>微博登录</span></a>
	            </div>
	        </div>
        </div>
        <div  class="logn_daoying"><div class="logn_daoying_1"></div> </div>
    </div>
</div>	
<!--内容结束-->
<!--尾部开始-->
<div class="login-foot clear" style="font-family: '微软雅黑';">
	<ul>
    	<li><a href="/admin/b2/login">管家登录</a><span>丨</span></li>
    	<li><a href="/admin/b1/index">供应商登录</a><span>丨</span></li>
    	<li><a href="/article/privacy_desc" target="_blank">隐私声明</a><span>丨</span></li>
        <li><a href="#">网站地图</a><span>丨</span></li>
        <li><a href="/article/index" target="_blank">常见问题</a><span>丨</span></li>
        <li><a href="/article/recruit" target="_blank">人才招聘</a><span>丨</span></li>
        <li><a href="/article/contact_us" target="_blank">联系我们</a><span>丨</span></li>
        <li><a href="/article/about_us-introduce" target="_blank">关于我们</a></li>
    </ul>
    <div class="login-keep">
    	  <p class="siteinfo">&nbsp;<?php echo 'Copyright © 2015-2016 &nbsp; ' . $web['url'] . '&nbsp;&nbsp;'. $web['webname'] .'&nbsp;版权所有 &nbsp;|&nbsp; 营业执照 &nbsp;|&nbsp; ICP证：' . $web['icp']; ?></p>
    </div>
</div>
<!--尾部结束-->
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('static/js/placeholder.js') ;?>"></script>
<script src="<?php echo base_url('static/js/common.js'); ?>" type="text/javascript"></script>
<script>
$(function(){ $('input, textarea').placeholder(); });
	$(function(){
		$('.login_input-1').blur(function(){
			var username = $(this).val();
			if(username.length>0){
				$('.info').hide();
			}
		});
		$('.login_input-2').blur(function(){
			var pw = $(this).val();
			if(pw.length>0){
				$('.info').hide();
			}
		});
		$('.login_input-3').blur(function(){
			var yzm = $(this).val();
			if(yzm.length>0){
				$('.info').hide();
			}
		});
	});

	$('#login_form').submit(function(){
		var username = $('.login_input-1').val();
		var pw = $('.login_input-2').val();
		var yzm = $('.login_input-3').val();
		if(username.length<=0){
			$('.info span a').html("账户不能为空");
			$('.info').show();
			return false;
		}else{
			$('.info').hide();
		}
		if(pw.length<=0){
			$('.info span a').html("请填写密码");
			$('.info').show();
			return false;
		}else{
			$('.info').hide();
		}
		if(yzm.length<=0){
			$('.info span a').html("请填写验证码");
			$('.info').show();
			return false;
		}else{
			$('.info').hide();
		}
		$.post(
			"<?php echo site_url('login/do_login')?>",
			$('#login_form').serialize(),
			function(data) {
				data = eval('('+data+')');
				if (data.code == 2000) {
					jQuery.ajax({ type : "POST", url : "/uc/syslogin.php", data : null,success : function(response) {
						jQuery('body').append(response);
						window.location.href=data.msg;
						}
					});
					//
				} else {
					$('#verifycode').trigger('click');
					$('.info span a').html(data.msg);
					$('.info').show();
				}
			}
		);
		return false;
	})
	//动态登陆
	$("#dynamic_login").submit(function(){
		$.post("login/doDynamicLogin",$("#dynamic_login").serialize(),function(json){
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
		var loginname = $("input[name='loginname']").val();
		//验证手机或邮箱
		if (!isEmail(loginname) && !isMobile(loginname)) {
			alert('请填写正确的邮箱或手机号');
			d = true;
			return false;
		}
		$.post("/send_code/getDynamicLogin",{loginname:loginname,type:1},function(json){
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
			//去掉相对的样式
			$(this).css("border","none")
			$(this).css("background","#fff")
			//添加新的样式
			
			$(".dtmm").css("background","#f1f1f1")	
			//相对的隐藏显示
			$(".huiyuan").show();
			$(".dongtai").hide();
		})
		
		$(".dtmm").click(function(){
			//去掉相对的样式
			$(this).css("border","none")
			$(this).css("background","#fff")
			//添加新的样式
			
			$(".hydl").css("background","#f1f1f1")	
			//相对的隐藏显示
			$(".huiyuan").hide();
			$(".dongtai").show();
		})
		$(function(){
			$("input").attr("autocomplete","off")
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
<script type="text/javascript">
//val 模仿提示字
$(function(){
if(!placeholderSupport()){   // 判断浏览器是否支持 placeholder
    $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
    }).blur();
};
})
function placeholderSupport() {
    return 'placeholder' in document.createElement('input');
}
</script>

