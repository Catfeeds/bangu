<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>供应商登录—帮游旅行网</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
    <meta name="keywords" content="旅游线路供应,旅游服务" />
    <meta name="description" content="帮游旅行网为广大传统旅行社提供一个线上收客的渠道，注册成为帮游供应商发布自己的产品实现线上售卖旅行社产品拥抱更多优质客户。" />
    <meta charset="utf-8">
    <meta name=”renderer” content=”webkit” />
    <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
    <link href="<?php echo base_url(); ?>assets/css/home.css?v=2" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
</head>
<body>
     <div class="wa">
     <div class="w_1200 clear">
            <a href="/"><img src="<?php echo base_url(); ?>static/img/logo.png" alt=""></a>
              <span  class="wa_span">供应商登录</span>
              <div class="return"><a href="/">返回帮游旅行首页</a></div>
        </div>
    </div>
    <div class="wrap">
        <div class="container w_1200 clear">
            <div class="register-box">
                <div class="reg-slogan"> 供应商登录</div>
                <div class="lofinTip">
                    <div class="info fl"><span><i></i><a></a></span></div>
                </div>
                <form class="form-horizontal form-bordered" role="form" id="form_login_data" method="post" action="<?php echo site_url('admin/login/do_login')?>">
                    <div class="reg-form" id="js-form-mobile">
                        <div class="reg-font">
                            <div class="fotLeft">
                                <div class="loginIco"></div>
                            </div>
                            <input type="text" name="username"   placeholder="手机号" autofocus class="loginname">
                        </div>
                        <div class="reg-font">
                            <div class="fotLeft">
                                <div class="passIco"></div>
                            </div>
                            <input type="password" name="password" placeholder="登录密码"  class="loginpassword">
                        </div>
                        <div class="reg-font clear">
                            <div class="fotLeft">
                                <div class="cationIco"></div>
                            </div>
                            <input type="text" class="loginyanzheng fl" name="verifycode" size="10" maxlength="4" placeholder="输入验证码">
                            <span class="yzm_img">
    							<img id="verifycode" src="<?php echo base_url(); ?>tools" onclick="this.src='<?php echo base_url();?>tools?'+Math.random()">
    						</span>  
                        </div>
                        <div style="margin-bottom:15px;">
                            <div class="forget_pw">
                                <div class="checkOne">
                                    <input type="checkbox" name="remember" value="1" class="checkInput" >
                                    <div class="checkTip">记住密码</div>
                                </div>
                                <div class="checkTwo">
                                    <input type="checkbox" name="auto_login" value="1" class="checkInput"  >
                                    <div class="checkTip">自动登录</div>
                                </div>
                            </div>
                        </div>
                        <div class="bottom">
                            <a id="login_submit"   class="button btn-green" >登&nbsp;&nbsp;录</a>
                        </div>
                        <div class="login_dd">
                            <a href="<?php echo site_url('admin/b1/retrieve_pass/retrievePassword')?>">忘记密码</a>
                            <a class="shu" href="">|</a>
                            <a href="<?php echo site_url('admin/b1/register/index') ?>" style="">免费注册</a>
                        </div>
                    </div>                
	           </form>
            </div>
        </div>
    </div>
    <div class="dibu">
        <ul >
        	<li><a href="/admin/b2/login">管家登录</a></li>
            <li><a href="">|</a></li>
            <li><a href="/admin/b1/index">供应商登录</a></li>
            <li><a href="">|</a></li>
            <li><a href="/article/privacy_desc" target="_blank">隐私声明</a></li>
            <li><a href="">|</a></li>
            <li><a href="">网站地图</a></li>
            <li><a href="">|</a></li>
            <li><a href="/article/index" target="_blank">常见问题</a></li>
            <li><a href="">|</a></li>
            <li><a href="/article/recruit" target="_blank">人才招聘</a></li>
            <li><a href="">|</a></li>
            <li><a  href="/article/contact_us" target="_blank">联系我们</a></li>
            <li><a href="">|</a></li>
            <li><a href="/article/about_us-introduce" target="_blank">关于我们</a></li>
        </ul>
        <dd  class="huizhi">Copyright © 2006-2015 帮游旅行网 www.1b1u.com | 营业执照 | ICP证：粤B1-66886688</dd>
    </div>
<script src="<?php echo base_url('static/js/placeholder.js') ;?>"></script>
<script>
$(function(){ $('input, textarea').placeholder(); });
document.onkeyup = function(e){      //onkeyup是javascript的一个事件、当按下某个键弹起 var _key; 
    if (e == null) { // ie  
        _key = event.keyCode;  
    } else { // firefox              //获取你按下键的keyCode  
        _key = e.which;          //每个键的keyCode是不一样的  
    }  
      
    if(_key == 13){   //判断keyCode是否是13，也就是回车键(回车的keyCode是13)  
         document.getElementById('login_submit').click()   
    }
}
		$('.loginname').blur(function(){
			var username = $(this).val();
			if(username.length>0){
				$('.info').hide();
			}
		});
		$('.loginpassword').blur(function(){
			var pw = $(this).val();
			if(pw.length>0){
				$('.info').hide();
			}
		});
		$('.loginyanzheng').blur(function(){
			var yzm = $(this).val();
			if(yzm.length>0){
				$('.info').hide();
			}
		});
$('#login_submit').click(function(){
	var username = $('input[name="username"]').val();
	var password = $('input[name="password"]').val();
	var verifycode = $('input[name="verifycode"]').val();
	if(username.length<=0){
			$('.info span a').html("账号不能为空");
			$('.info').show();
			return false;
		}
		if(password.length<=0){
			$('.info span a').html("请填写密码");
			$('.info').show();
			return false;
		}
		if(verifycode.length<=0){
			$('.info span a').html("请填写验证码");
			$('.info').show();
			return false;
		}
	$.post(
		"<?php echo site_url('admin/b1/home/do_login')?>",
		$('#form_login_data').serialize(),
		function(data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				location.href="<?php echo site_url('admin/b1/view') ?>";
			} else if (data.code == 7000) {
				location.href="<?php echo site_url('admin/b1/register/perfectInfo?sid=') ?>"+data.msg;
			} else {
				$('input[name="password"]').val('');
				$('.info').show();//.html(data.msg);
				$('.info span a').html(data.msg);
				$('#verifycode').trigger('click');
			}
		}
	);
	return false;
})
	$(".login_butto").click(function(){
			$("#login_error").hide();
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
