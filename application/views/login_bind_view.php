<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/user/login.css'); ?>" rel="stylesheet"/>
<script src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<title>绑定第三方帐号</title>
</head>
<body class="reg_body">
<div class="body-2">
<!--头部 开始-->
<div class="register_header">
    <div>
    	<div class="reg_header_img fl"><a href="/"><img src="<?php echo base_url('static'); ?>/img/logo.png" /></a></div>
        <div class="reg_title fl">绑定帐号</div>
    </div>
</div>
<!--头部 结束-->
<!--内容开始-->
<div class="stered_content">
	<div class="stered_content_too">
		<div class="stered_back">
        	<div class="stered_title">绑定帐号</div>
				 <form class="form-horizontal form-bordered" method="post" id="register" action="<?php echo site_url('register/do_register')?>">
            	<div class="stered_main clear">
                	<div class="stered_input" style="position:relative;">
                    	<div class="stered_one fl"/>86</div><input class="stered_two fr" name="mobile" placeholder="请输入手机号" id="input1" maxlength="11"/>
                    </div>
                        
                    <div class="stered_input" id="yzm" style="display:none;width:212px;">
                        
                    	<input class="stered_five fl" type="text" placeholder="验证码" name="code" id="input5" maxlength="4"/>
                        <div class="stered_yanzheng fl">
                        <img style="-webkit-user-select: none; width:88px; height:34px;" id="verifycode" src="<?php echo base_url('tools/captcha/index'); ?>" onclick="this.src='<?php echo base_url('tools/captcha/index');?>?'+Math.random()" />
                        </div>
                            <input type="button" value="发送" class="yzm_tijiao" />
                            <input type="button" value="关闭" class="yzm_guanbi" />    
                    </div>
                     
                    <div class="stered_input">
                    	<input class="stered_three fl" placeholder="请输入手机验证码" name="mobile_code" id="input2" maxlength="4"/>
                        <div class="stered_phone fr "><span class='mobile_code' id="btnSendCode" is_get_code="1">获取短信验证码</span></div>
                    </div>
                    <div class="stered_input">
                    	<input class="stered_four fl" name="password" type="password" placeholder="请输入密码" id="input3" maxlength="20"/>
                    </div>
                    <div class="stered_agreement" style="padding-left:50px">
                    	<input type="checkbox" name="checkbox" class="fl" value="1" checked="checked" id="input6"/>                        
                        <div class="stered_agreement_two fl">我接受<a href="/service/member_agreement" target="_blank"><<帮游会员协议条款>></a></div>
                    </div>
                    <div class="stered_botton">
                    	<input type="hidden" name="rand_code" value="<?php echo mt_rand(100000,999999);?>" />
                    	<input type="submit" name="submit" value="确定绑定" />
                    </div>
                    </form>
                </div>    
				
                <div class="container">
					<ol>
                        <li>
                            <label for="mobile" class="info1"><span></span></label>
                        </li>
                        <li style="margin-bottom:20px;height:32px;line-height:32px;">
                            <label for="img_yzm" class="info5" style="background-position:0px 9px;"><span></span></label>
                        </li>
                        <li>
                            <label for="mobile_yzm" class="info2"><span></span></label>
                        </li>
                        <li>
                            <label for="password" class="info3"><span></span></label>
                        </li>                        
                        <li style="margin-bottom:20px;height:18px;line-height:18px;">
                            <label for="checkbox" class="info6" style="background-position:0px 2px;"><span></span></label>
                        </li>
					</ol>
				</div>
            <div class="clear stered_keep">Copyright © 2006-2015 帮游旅行网 www.1b1u.com | 营业执照 | ICP证：粤B1-66886688 </div>
            </div>
        </div> 
	</div>
<!--内容结束-->
<script type="text/javascript">
$(function(){
	
	//短信验证码必须是数字
	$('#input1,#input2,#input5').keyup(function(){  
		var c=$(this);  
		if(/[^\d]/.test(c.val())){//替换非数字字符  
		  var temp_amount=c.val().replace(/[^\d]/g,'');  
		  $(this).val(temp_amount);  
		}  
	 });
	
$('.change_code').click(function(){
		var str = "<?php echo base_url('tools/captcha/index')?>?"+Math.random();
		$('#verifycode').attr('src' ,str);
	});

//发送手机验证码
$('.yzm_tijiao').click(function(){
	var mobile = $("#register").find('#input1').val();
	var code = $('input[name="code"]').val();
	var rand_code = $("input[name='rand_code']").val();
	if (code.length < 1) {
		alert('请先输入下面的验证码再获取手机验证码');
		return false;
	}
	var is_get_code = $('#btnSendCode').attr('is_get_code');
	if (is_get_code != 1) {
		return false;
	}
	$.post(
		"<?php echo site_url('send_code/sendMobileCode');?>",
		{'mobile':mobile,'verifycode':code,'rand_code':rand_code,'type':1},
		function(data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				$('#yzm').css('display','none');
				sendMessage();
				alert(data.msg);
			} else if (data.code == 8000) {
				return false;
			} else {
				alert(data.msg);	
			}
			$('#verifycode').trigger('click');
			create_code();
		} 
	);
	return false;
})
create_code();
function create_code() {
	//重新生成随机码
	var $chars = '0123456789'; 
	var rand_code = '';  
	for (i = 0; i < 6; i++) {  
	    rand_code += $chars.charAt(Math.floor(Math.random() * 10));  
	}  
	$('input[name="rand_code"]').val(rand_code);
}

//倒计时
var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
  　curCount = count;
　　//设置button效果，开始计时
	 $("#btnSendCode").css({"background":"#ccc","cursor":"auto"}).attr('is_get_code' ,'0');
     $("#btnSendCode").html("" + curCount + "秒内输入有效");
     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
}

//timer处理函数
function SetRemainTime() {
	if (curCount == 0) {                
         window.clearInterval(InterValObj);//停止计时器
         $("#btnSendCode").html("重新发送验证码");
		 $("#btnSendCode").css({"background":"#37D","cursor":"pointer"}).attr('is_get_code' ,'1');
    }
    else {
         curCount--;
         $("#btnSendCode").html("" + curCount + "秒内输入有效");
    }
}

//注册验证 
	$("#input1").blur(function(){
		var mobile = $(this).val();
		if(!mobile.match(/^1[3-8]\d{9}$/)&&mobile.length!=0){
			$('.info1 span').html("您输入的手机号码格式不正确");	
			$('.info1').css("display","block");
			return false;
		}else{
			$('.info1').css("display","none");
		};
	});	
	$("#input5").blur(function(){
		var img_yzm = $(this).val();
	
		
		//失去光标检测图片验证码
// 		if(img_yzm.length!=0){
// 			$.post(
// 				"",
// 				{img_yzm:$(this).val()},
// 				function(msg){
// 					if(){
// 						$('.info5 span').html("请输入图片验证码");	
// 						$('.info5').css("display","block");
// 					}else{
// 						$('.info5').css("display","none");
// 					}
// 				}
// 			);
// 		}
	});
	$("#input2").blur(function(){
		var mobile_yzm = $(this).val();

		//失去光标检测短信验证码
		if(mobile_yzm.length!=0){
			$.post(
				"",
				{mobile_yzm:$(this).val()},
				function(msg){
					if(false){
						$('.info2 span').html("请输入您收到的短信验证码");	
						$('.info2').css("display","block");
					}else{
						$('.info2').css("display","none");
					}
				}
			);
		}
	});
	$("#input3").blur(function(){
		var pw1 = $(this).val();
		
		if(pw1.length<6&&pw1.length!=0){
			$('.info3 span').html("您输入的密码长度不足（至少6个字符）");	
			$('.info3').css("display","block");
			return false;
		}else {
			$('.info3').css("display","none");
		};
	});
	$("#input4").blur(function(){
		var pw1 = $("#input3").val();
		var pw2 = $("#input4").val();
		if(pw1!=pw2){
			$('.info4 span').html("两次输入的密码不一致");	
			$('.info4').css("display","block");
			return false;
		}else{
			$('.info4').css("display","none");
		};
	});
	
	$('#register').submit(function(){	
		var mobile = $("#input1").val();
		var mobile_yzm = $("#input2").val();
		var pw1 = $("#input3").val();
		var img_yzm = $("#input5").val();
		var xieyi = $("#input6").attr("checked");
		if(mobile.length<=0){
			$('.info1 span').html("请输入您的11位手机号");	
			$('.info1').css("display","block");
			return false;
		};
		if(!mobile.match(/^1[3-8]\d{9}$/)){
			$('.info1 span').html("您输入的手机号码格式不正确");	
			$('.info1').css("display","block");
			return false;
		}else{
			$('.info1').css("display","none");
		};
		if(img_yzm.length<=0){
			$('.info5 span').html("请输入图片验证码");	
			$('.info5').css("display","block");
			return false;
		}else{
			$('.info5').css("display","none");
		};
		if(mobile_yzm.length<=0){
			$('.info2 span').html("请输入您收到的短信验证码");	
			$('.info2').css("display","block");
			return false;
		}else{
			$('.info2').css("display","none");
		};
		if(pw1.length<=0){
			$('.info3 span').html("请输入密码（6-20位：字母、数字、特殊符号）");	
			$('.info3').css("display","block");
			return false;
		};
		if(pw1.length<6){
			$('.info3 span').html("您输入的密码长度不足（至少6个字符）");	
			$('.info3').css("display","block");
			return false;
		}else {
			$('.info3').css("display","none");
		};
		if(xieyi==false){
			$('.info6 span').html("您还没有同意帮游会员协议");	
			$('.info6').css("display","block");
			return false;
		}else{
			$('.info6').css("display","none");
		};
		
		$.post(
			"<?php echo site_url('register/do_register')?>",
			$('#register').serialize(),
			function(data) {
				var data = eval('('+data+')');
				if (data.code == 2000) {
					alert(data.msg);
					window.location.href="/";
				} else {
					$('#verifycode').trigger('click');
					alert(data.msg);
				}
			}
		);
		return false;
	});
	
});
</script>
    <script>
        $(function(){
            $(".mobile_code").click(function(){
                $("#yzm").show();
            });
            $(".yzm_tijiao").click(function(){
                $("#yzm").hide();
            });
            $(".yzm_guanbi").click(function(){
                $("#yzm").hide();
            });
            
        })
    </script>
</body>
</html>
