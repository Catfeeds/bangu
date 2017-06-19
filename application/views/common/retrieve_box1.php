<link type="text/css" href="<?php echo base_url('static/css/retrieve_box1.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<div class="body-2">

<!--内容开始-->
<div class="stered_content">

	<div class="stered_content_too">
    	<div class="stered_box">
		<div class="stered_back">
        
        	<div class="stered_title">手机注册<i class="close_retrieve_box1">×</i></div>
            <div class="input_html"> </div>
				 <form class="form-horizontal form-bordered" style=" float:none;" method="post" id="register" action="<?php echo site_url('register/do_register')?>">
                 
            	<div class="stered_main clear">
                	<div class="stered_input" style="position:relative;">
                    	<div class="stered_one fl"/>86</div><input class="stered_two fr" name="mobile" placeholder="请输入手机号" id="input1" maxlength="11"/>
                        
                    </div>    
                    <div class="stered_input" id="yzm" style="display:none;width:212px;">
                        
                    	<input class="stered_five fl" type="text" placeholder="验证码" name="code" id="input5" maxlength="4"/>
                        <div class="stered_yanzheng fl">
                        	<img style="-webkit-user-select: none; width:88px; height:34px;" id="verifycodeBox1" src="<?php echo base_url('tools/captcha/index'); ?>" onclick="this.src='<?php echo base_url('tools/captcha/index');?>?'+Math.random()" />
                        </div>
                        <input type="button" value="发送" onclick="getMobileCode(this);" class="yzm_tijiao" />
                        <input type="button" value="关闭" class="yzm_guanbi" />    
                    </div>
                     
                    <div class="stered_input">
                    	<input class="stered_three fl" placeholder="请输入手机验证码" name="mobile_code" id="input2" maxlength="4"/>
                        <div class="stered_phone fr "><span class='mobile_code' id="btnSendCode" >获取短信验证码</span></div>
                    </div>
                    <div class="stered_input">
                    	<input class="stered_four fl" name="password" type="password" placeholder="请输入密码" id="input3" maxlength="20"/>
                        <span></span>
                    </div>
                    <div class="stered_input" id="pw2">
                    	<input class="stered_four fl" name="repass" type="password" placeholder="请再次输入密码" id="input4"/>
                    </div>
                    <div class="stered_agreement" style="padding-left:50px">
                    	<input type="checkbox" name="isAgree" class="fl" value="1" checked="checked" id="input6"/>
                        
                        <div class="stered_agreement_two fl">我接受<a href="/service/member_agreement" target="_blank"><<帮游会员协议条款>></a></div>
                    </div>
                    <div class="stered_botton">
                    	<input type="submit" name="submit" value="免费注册" />
                    </div>
                    </form>
                </div>    
				</div>
            </div>
        </div> 
<script src="<?php echo base_url('static/js/common.js') ;?>"></script>
<script>
//发送短信
var codeStatus = true;
function getMobileCode(obj){
	if (codeStatus == false) {
		return false;
	} else {
		codeStatus = false;
	}
	var buttonId = 'btnSendCode';
	var mobile = $(obj).parents("form").find("input[name='mobile']").val();
	var code = $(obj).parents("form").find("input[name='code']").val();
// 	if (!isMobile(mobile)) {
// 		alert('请填写正确的手机号');
// 		codeStatus = true;
// 		return false;
// 	}
	$.post("/send_code/sendMobileCode",{mobile:mobile,type:1,verifycode:code},function(json){
		var data = eval("("+json+")");
		if (data.code == 2000) {
			countdown(buttonId);
			$(obj).parent("div").hide();
		} else {
			codeStatus = true;
			alert(data.msg);
		}
		$(obj).prev("div").find("img").trigger("click");
	});
}

$(function(){
	$(".close_retrieve_box1").click(function(){
		$(".stered_content").hide();
	});
	//短信验证码必须是数字
	$('#input1,#input2,#input5').keyup(function(){  
		var c=$(this);  
		if(/[^\d]/.test(c.val())){//替换非数字字符  
		  var temp_amount=c.val().replace(/[^\d]/g,'');  
		  $(this).val(temp_amount);  
		} 
	 });


//注册验证 
	$("#input1").blur(function(){
		var mobile = $(this).val();
		if(mobile.length!=0){
			if(!mobile.match(/^1[3-8]\d{9}$/)){
				$('.input_html').html("您输入的手机号码格式不正确!");
				
			}else{
				$('.input_html').html("");
				return false;
			};
		};
		
	});	
	$("#input5").blur(function(){
		var img_yzm = $(this).val()
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
						$('.input_html').html("请输入您收到的短信验证码!");	
						return false;
					}else{
						$('.input_html').html("");
					}
				}
			);
		}
	});
	$("#input3").blur(function(){
		var pw1 = $(this).val();
		
		if(pw1.length<6&&pw1.length!=0){
			$('.input_html').html("您输入的密码长度不足（至少6个字符）!");	
		}else {
			$('.input_html').html("");
			return false;
		};
	});
	$("#input4").blur(function(){
		var pw1 = $("#input3").val();
		var pw2 = $("#input4").val();
		if(pw1!=pw2){
			$('.input_html').html("两次输入的密码不一致!");	
		}else{
			$('.input_html').html("");	
			return false;
		};
	});

	function testingData() {
		var mobile = $("#input1").val();
		var mobile_yzm = $("#input2").val();
		var pw1 = $("#input3").val();
		var pw2 = $("#input4").val();
		var img_yzm = $("#input5").val();
		var xieyi = $("#input6").attr("checked");
		if(mobile.length<=0){
			$('.input_html').html("请输入您的11位手机号");	
			$('.info1').css("display","block");
			return false;
		};
		if(!mobile.match(/^1[3-8]\d{9}$/)){
			$('.input_html').html("您输入的手机号码格式不正确");	
			$('.info1').css("display","block");
			return false;
		}else{
			$('.info1').css("display","none");
		};
		if(img_yzm.length<=0){
			$('.input_html').html("请输入图片验证码");	
			$('.info5').css("display","block");
			return false;
		}else{
			$('.info5').css("display","none");
		};
		if(mobile_yzm.length<=0){
			$('.input_html').html("请输入您收到的短信验证码");	
			$('.info2').css("display","block");
			return false;
		}else{
			$('.info2').css("display","none");
		};
		if(pw1.length<=0){
			$('.input_html').html("请输入密码（6-20位：字母、数字、特殊符号）");	
			$('.info3').css("display","block");
			return false;
		};
		if(pw1.length<6){
			$('.input_html').html("您输入的密码长度不足（至少6个字符）");	
			$('.info3').css("display","block");
			return false;
		}else {
			$('.info3').css("display","none");
		};
		if(pw1!=pw2){
			$('.input_html').html("两次输入的密码不一致");	
			$('.info4').css("display","block");
			return false;
		}else{
			$('.info4').css("display","none");
		};
		
		
		if(xieyi==false){
			$('.input_html').html("您还没有同意帮游会员协议");	
			$('.info6').css("display","block");
			return false;
		}else{
			$('.info6').css("display","none");
		};
	}

	
});
</script>
    <script>
        $(function(){
            $(".mobile_code").click(function(){
                $("#verifycode").trigger("click");
                $("#yzm").show();
            });
           
            $(".yzm_guanbi").click(function(){
                $("#yzm").hide();
            });
            
        })
		$(function(){
			$("input").attr("autocomplete","off")
		})
</script>


