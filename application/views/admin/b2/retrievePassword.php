<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></meta>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/Cellphone.css'); ?>" type="text/css" rel="stylesheet">
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<title>手机找回密码</title>
</head>
<body>
	<div class="Cellphone_header">
    	<div class="Cellphone_main">
        	<a href="/"><img src="<?php echo base_url('static/img/logo.png'); ?>"/></a>
        	<div class="Cellphone_tltle">找回密码</div>
        	<div class="Cellphone_Return"><a href="/">返回帮游旅行首页</a></div>
        	<div class="Cellphone_Reg"><a href="<?php echo site_url('admin/b2/register/index');?>">免费注册</a></div>
        	<div class="Cellphone_land"><a href="<?php echo site_url('admin/b2/login')?>">管家登录</a></div>
        </div>
    </div>
    <div class="Cellphone_conment">     
    	<div class="Cellphone_conment_title">手机找回密码</div>
        <div class="Cellphone_conment_Prompt">请输入您注册时使用或绑定的手机号进行短信验证</div>
        <form action="" method="post" id="retrieve_password">
  		 	<div class="Cellphone_input">
  		 		<div class="chunk_box">
        			<span>手机号码</span>
        			<input style=" width:230px;" type="text" maxlength="11" name="mobile" placeholder="请输入手机号码">
        			<div class="Cellphone_Validation get_mobile_code" is_get_code="1" id="btnSendCode">获取验证码</div>
        		</div>
        		<div class="chunk_box">
            		<span class="magin_top">验证码</span>
            		<input class="magin_top" name="code" maxlength="4" id="tipfocu" placeholder="输入手机验证码">
            		<div class="Cellphone_tip_box">
            			<img id="tip_tsh" src="<?php echo base_url('static/img/user/Tip_box.png'); ?>"/>
            		</div>
            	</div>
           		<div class="eject_yanzheng">
            		<input class="" name="vcode" maxlength="4"  placeholder="请输入验证码">
            		<div class="Cellphone_ejc_box">
            			<img style=" display: inline-block;border:1px solid #ccc;width:88px;height:38px;" id=vcode src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()">
            		</div>
               		<button class="tijiao submit_code">提交</button>
                	<button class="guanbi">关闭</button>
               	</div>
            	<div class="chunk_box">
            		<span class="magin_top">密码</span>
            		<input class="magin_top" name="password" style=" width:338px;" maxlength="15" type="password" placeholder="设置登录密码" onKeyUp=pwStrength(this.value) onBlur=pwStrength(this.value)>
             	</div>
            	<table class="Cellphone_two_table" style="padding-top: 0;">
	    			<tr>
				    	<td class="Cellphone_two_td" id="strength_L">弱</td>
				    	<td class="Cellphone_two_td" id="strength_M">中</td>
				    	<td class="Cellphone_two_td" id="strength_H">强</td>
			    	</tr>
   				</table> 
   				<div class="chunk_box">  
             		<span style=" margin-top:15px;">确认密码</span>
             		<input name="repass" style=" width:338px; margin-top:15px;" maxlength="15" type="password" placeholder="再次输入密码" >
             	</div>
            	<div class="Back_next_step_btn">
            		<span><a href="javascript:void(0);" onclick="submit_form();">确认修改密码</a></span>
            	</div>
        	</div>
        </form>
     </div>
   	<!-- 公共页尾 直接删除-->
    <!-- 尾部 -->
	<div class="footer clear" id="foot"  style="font-family: '微软雅黑';">
    	<div class="footer_content">
        	<div class="footer_img w_1200"><img src="<?php echo base_url('static'); ?>/img/footer_bg.png"/></div>
        	<div class="footer_links">
            	<p class="guild_link">
            		<a href="/admin/b2/login">管家登录</a>|
            		<a href="/admin/b1/index">供应商登录</a>|
            		<a target="_blank" href="/article/privacy_desc">隐私声明</a>|
            		<a href="<?php echo site_url('index/site_map'); ?>">网站地图</a>|
            		<a target="_blank" href="<?php echo site_url('article/recruit'); ?>">加入我们</a>|
    				<a target="_blank" href="<?php echo site_url('article/contact_us'); ?>">联系我们</a>| 
					<a target="_blank" href="<?php echo site_url('article/about_us'); ?>" >关于我们</a>| 
					<a target="_blank" href="<?php echo site_url('article/friend_link'); ?>">友情链接</a>
                </p>
            	<p class="siteinfo"> Copyright&nbsp;&nbsp; ©&nbsp;&nbsp;2006-2015&nbsp;&nbsp;    http://192.168.10.202  帮游网 &nbsp;&nbsp; 版权所有 &nbsp;&nbsp;  |&nbsp;&nbsp;  营业执照 &nbsp;&nbsp;  | &nbsp;&nbsp;  ICP证：粤ICP备15067822号</p>
            </div>
        </div>
    </div>
</body>
<html>
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
//提交审核
function submit_form() {
	$.post(
		"<?php echo site_url('admin/b2/retrieve_pass/do_retrieve_pass')?>",
		$('#retrieve_password').serialize(),
		function(data) {
			var data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				location.href="/admin/b2/login";
			} else {
				alert(data.msg);
			}
		}
	)
}
$('.submit_code').click(function(){
	var is_get_code = $("#btnSendCode").attr('is_get_code');
	if (is_get_code != 1) {
		return false;
	}
	var mobile = $('input[name="mobile"]').val();
	var vcode = $('input[name="vcode"]').val();
	if (mobile.length != 11) {
		alert('请填写正确手机号');
		return false;
	}
	if (vcode.length < 1) {
		alert('请先输入下面的图形验证码，再获取手机验证码');
		return false;
	}
	$.post( 
		"<?php echo site_url('send_code/sendMobileCode');?>",
		{'mobile':mobile,'verifycode':vcode,'type':5},
		function(data) {
			var data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				$('.eject_yanzheng').hide();
				sendMessage();
			} else if(data.code == 7000) {
				alert(data.msg);
				location.href="/admin/b2/register/index";
			} else {
				alert(data.msg);
				$("#vcode").trigger("click");
			}
		} 
	);
	return false;
})


//倒计时
var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
 　curCount = count;
　　//设置button效果，开始计时
	 $("#btnSendCode").css({"background":"#ccc","cursor":"auto"}).attr('is_get_code' ,'0');
    $("#btnSendCode").html(curCount + "s重新获取");
    InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
}

//timer处理函数
function SetRemainTime() {
	if (curCount == 0) {                
        window.clearInterval(InterValObj);//停止计时器
        $("#btnSendCode").html("重新发送");
		 $("#btnSendCode").css({"background":"url(/static/img/user/Validation_btn.png)","cursor":"pointer"}).attr('is_get_code' ,'1');
   }
   else {
        curCount--;
        $("#btnSendCode").html(curCount + "s重新获取");
   }
}




$(document).ready(function(){
  $("#tipfocu").focus(function(){
	   $("#tip_tsh").show();
  });
 $("#tipfocu").blur(function(){
    $("#tip_tsh").hide();
  });
});
</script>


    <script language=javascript>
    //判断输入密码的类型
    function CharMode(iN){
    if (iN>=48 && iN <=57) //数字
    return 1;
    if (iN>=65 && iN <=90) //大写
    return 2;
    if (iN>=97 && iN <=122) //小写
    return 4;
    else
    return 8;
    }
    //bitTotal函数
    //计算密码模式
    function bitTotal(num){
    modes=0;
    for (i=0;i<4;i++){
    if (num & 1) modes++;
    num>>>=1;
    }
    return modes;
    }
    //返回强度级别
    function checkStrong(sPW){
    if (sPW.length<=4)
    return 0; //密码太短
    Modes=0;
    for (i=0;i<sPW.length;i++){
    //密码模式
    Modes|=CharMode(sPW.charCodeAt(i));
    }
    return bitTotal(Modes);
    }
    //显示颜色
    function pwStrength(pwd){
    O_color="#aeadad";
    L_color="#ffa535";
    M_color="#e009f3";
    H_color="#0cf0f3";
    if (pwd==null||pwd==''){
    Lcolor=Mcolor=Hcolor=O_color;
    }
    else{
    S_level=checkStrong(pwd);
    switch(S_level) {
    case 0:
    Lcolor=Mcolor=Hcolor=O_color;
    case 1:
    Lcolor=L_color;
    Mcolor=Hcolor=O_color;
    break;
    case 2:
    Lcolor=Mcolor=M_color;
    Hcolor=O_color;
    break;
    default:
    Lcolor=Mcolor=Hcolor=H_color;
    }
    }
    document.getElementById("strength_L").style.background=Lcolor;
    document.getElementById("strength_M").style.background=Mcolor;
    document.getElementById("strength_H").style.background=Hcolor;
    return;
    }
    </script>
    <script>
        $("#btnSendCode").click(function(){
            $(".eject_yanzheng").show();
        })
    </script>
    <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?da409c07ec1641736bde4ab39783b82f";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>

