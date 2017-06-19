<link type="text/css" href="<?php echo base_url('static/css/login_box.css');?>" rel="stylesheet" />
<div class="login_box" id="treeDiv">
<div class="login_box2">
	
	<div class="login_title clear">
    	<span>您尚未登录</span>
    	<i class="close_login_box"></i>
    </div>
    <div class="login_content">
    	<div class="big_title">帮游登录</div>
        <div class="form_box">
        	<div class="info"><span><i></i><a>账户不能为空</a></span></div>
            <form action="<?php echo site_url('login/do_login')?>" method="post"  id="login_form1" class="login_form_box">
            	<div class="input_div clear"><div class="login_left fl">账<span class="zhanwei1"></span>号:</div><input type="text" name="username" placeholder="手机号/邮箱" class="input1 fl"/></div>
            	<div class="input_div clear"><div class="login_left fl">密<span class="zhanwei1"></span>码:</div><input type="password" name="password" class="input2 fl"/></div>
				<div class="input_div clear"><div class="login_left fl">验<span class="zhanwei2"></span>证<span style="width:8px; display: inline-block"></span>码:</div><input type="text" name="verifycode" class="input3 fl"/>
				<img style="-webkit-user-select: none" class="yzm_img fl" id="verifycodeBox" src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()">
				</div>
            	<div id="button_div"><input type="submit" name="submit" value="登   录"/></div>
            </form>
        </div>
        <div class="login_type">
        	<div class="reg_link"><a href="<?php echo site_url('login/retrieve_pass')?>" target="_blank">忘记密码</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        	<a href="/register" class="startRegister">免费注册</a></div>
            <div class="login_type_txt"><span>您还可以使用以下方式登录</span></div>
            
			<div class="otherlogin">
            	<a href="<?php echo base_url('');?>sns/session/qq"><img src="<?php echo base_url('static/img/user/qqdl_16.png'); ?>" class="fl"/><span>QQ账号登录</span></a>
                <a href="<?php echo base_url('');?>sns/session/weibo"><img src="<?php echo base_url('static/img/user/saindl_17.jpg'); ?>" class="fl" /><span>新浪微博登录</span></a>
            </div>
        </div>
    </div>
</div>
</div>
<script>

$(function(){

	$('.close_login_box').click(function(){
		$('.bg').css("display","none");
		$('.login_box').css("display","none");
	});


});	
//登录框拖动
// var _move=false;//移动标记
// var _x,_y;//鼠标离控件左上角的相对位置
// $(document).ready(function(){
// 	$("#treeDiv").click(function(){
// 	//alert("click");//点击（松开后触发）
// 	}).mousedown(function(e){
// 		_move=true;
// 		_x=e.pageX-parseInt($("#treeDiv").css("left"));
// 		_y=e.pageY-parseInt($("#treeDiv").css("top"));
// 	});
// 	$(document).mousemove(function(e){
// 		if(_move){
// 			var x=e.pageX-_x;//移动时根据鼠标位置计算控件左上角的绝对位置
// 			var y=e.pageY-_y;
// 			$("#treeDiv").css({top:y,left:x});//控件新位置
// 		}
// 	}).mouseup(function(){
// 		_move=false;	
// 	});
// });
</script>