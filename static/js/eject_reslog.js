$(function(){
	var html = "<div class='eject_login' id='eject_login'>";
		
		html += "<div class='login_box'>";	
		
		html +="<div class='login_back fr'>"
		//切换
		html +="<div class='login_land_title'><span class='hydl'>帮游会员登录</span><span class='dtmm'>动态密码登陆</span></div>";
		html +="<div class='huiyuan'>";
		//表单开始    普通登录方式
		html +="<form class='form-horizontal form-bordered' role='form' id='login_form' method='post' action='/login/do_login'>";
		html +="<div class='info'><span><i></i><a></a></span></div>";
		//内容开始
		html +="<div class='login_input'>";
		
		//账号开始
		html +="<div class='login_number'>";
		html +="<div class='login_left fl'>账<span class='zhanwei1'></span>号:</div>";
		html +="<div class='login_right fr'><input placeholder='手机号/邮箱' autofocus type='text' class='login_input-1' name='username'/></div>";
		html +="</div>";
		//账号结束
		
		//密码开始
		html +="<div class='login_number'>";
		html +="<div class='login_left fl'>密<span class='zhanwei1'></span>码:</div>";
		html +="<div class='login_right fr'><input class='login_input-2' type='password' name='password'/></div>";
		html +="</div>";
		//密码结束
         
		 //验证码开始
		 html +="<div class='login_number'>"; 
		 html +="<div class='login_left fl'>验<span class='zhanwei2'></span>证<span style='width:8px; display: inline-block'></span>码:</div>"; 
		 html +=" <div class='login_right fr'><input class='login_input-3' type='text' name='verifycode'/><span class='fr'><img style='-webkit-user-select: none' id='verifycode' src='/tools/captcha/index' onclick='this.src='/tools/captcha/index?'+Math.random()'></span></div>"; 
		 html +="</div> ";   
		 //验证码结束	
		 
		 html +="<input type='hidden' name='url' value='<?php echo $url;?>'>";	
		 html +="<div class='login_botton'><input type='submit' style=' border:none; background-color:#f7830a; border-radius:3px; width:275px; height:40px; color:#FFF; font-size:24px; font-family:simhei' value='登 录' /></div>";	
		 html +="<div class='login_shu'><a href='/login/retrieve_pass'>忘记密码</a>丨<a href='/register/index'>免费注册</a></div>";	
		 html +="</div>";
		 html +="</form>"; 
		//您还可以用其他方式登陆
         html +="<div class='login_yxfs'>"; 
		 html +="<span>你还可以使用以下方式登录</span>"; 
		 html +="</div>"; 
		 html +="<div class='otherlogin'>"; 
		 html +="<a href='/qq'><img src='/static/img/user/qqdl_16.png' class='fl'/><span>QQ账号登录</span></a>"; 
		 html +="<a href='/weibo'><img src='static/img/user/saindl_17.jpg' class='fl' /><span>新浪微博登录</span></a>"; 
		 html +="</div> ";    
		 html +="</div>";	 
			 
			
			 
		//表单开始    短信登录方式 
              
         html +="<div class='dongtai'>	";	  	
         html +="<form class='form-horizontal form-bordered' role='form' id='dynamic_login' method='post' action='../login/do_login'>"; 
         html +="<div class='info'><span><i></i><a></a></span></div> ";    
         html +="<div class='login_input'>";	
          
		  //账号开始
         html +="<div class='login_number'>"; 
		 html +="<div class='login_left fl'>账<span class='zhanwei1'></span>号:</div>"; 
		 html +="<div class='login_right fr'><input placeholder='手机号/邮箱' autofocus type='text' class='login_input-1' name='loginname'/></div>"; 
		 html +="</div>";  
             
           //账号结束        	
          
		  //动态密码获取
		 html +="<div class='login_number'>"; 
		 html +="<div class='login_left fl'>动态密码:</div>";  
		 html +="<div class='login_right fr'>";  
		 html +="<input class='login_input-3' style=' width:80px;' type='text' name='dynamic_code'/>";  
		 html +="<span class='fr' id='get_dynamic_code' style=' width:110px; text-align:center; border:1px solid #dedede; color:#666; cursor:pointer;'>获取动态密码</span>";  
		 html +="</div>";  
		 html +="</div> ";            
                   	
            //动态密码获取
			
		 html +="<input type='hidden' name='url' value=''/>";
		 html +="<div class='login_botton'><input type='submit' style=' border:none; background-color:#f7830a; border-radius:3px; width:275px; height:40px; color:#FFF; font-size:24px; font-family:simhei' value='登 录' /></div>";
		 html +="<div class='login_shu'><a href='/login/retrieve_pass'>忘记密码</a>丨<a href='../register/index'>免费注册</a></div> ";
		 html +="</div>";	
		 html +="<form>";
			
			
		 html +="<div class='login_yxfs'>";
		 html +="<span>你还可以使用以下方式登录</span>";	
		 html +="</div>";	
		 html +="<div class='otherlogin'>";	
		 html +="<a href='/qq'><img src='/static/img/user/qqdl_16.png' class='fl'/><span>QQ账号登录</span></a>";	
		 html +="<a href='/weibo'><img src='/static/img/user/saindl_17.jpg' class='fl' /><span>新浪微博登录</span></a>";	
		 html +="</div>";		
		 html +="</div>";
		 html +="</div>";	

	$("body").append(html);
		

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
	

	$('#login_form').submit(function(){
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
			$('#login_form').serialize(),
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
			var thisHeight=$(".login_back").height();
			var thistwoHeight=$(".login_back").height()/2;
			//alert(thistwoHeight)
			$(".login_box").css("height",thisHeight)
			$(".login_box").css("margin-top",-thistwoHeight)
			$(this).css("border","none")
			$(this).css("background","#fff")
			//添加新的样式
			$(".dtmm").css("border-left","1px solid #ccc")
			$(".dtmm").css("border-bottom","1px solid #ccc")
			$(".dtmm").css("background","#f4f4f4")	
			//相对的隐藏显示
			$(".huiyuan").show();
			$(".dongtai").hide();
			
		})
		
		$(".dtmm").click(function(){
			var thisHeight=$(".login_back").height();
			var thistwoHeight=$(".login_back").height()/2;
			//alert(thisHeight)
			$(".login_box").css("height",thisHeight)
			//$(".login_box").css("height",thisHeight)
			//去掉相对的样式
			$(this).css("border","none")
			$(this).css("background","#fff")
			//添加新的样式
			$(".hydl").css("border-right","1px solid #ccc")
			$(".hydl").css("border-bottom","1px solid #ccc")
			$(".hydl").css("background","#f4f4f4")	
			//相对的隐藏显示
			$(".huiyuan").hide();
			$(".dongtai").show();
		})
		$(function(){
			$("input").attr("autocomplete","off")
		})
		
	    $(document).mouseup(function(e) {
        var _con = $('.login_box'); // 设置目标区域
        if (!_con.is(e.target) && _con.has(e.target).length === 0) {
            $("#eject_login").fadeOut("slow")
        }
    })
	
	
	
	
	
	
	
	
	
	
	
})












