<!DOCTYPE html>
<html>

<head>
<title>注册</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta charset="utf-8">
<link href="<?php echo base_url(); ?>assets/css/register.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
<style>
#login_error { 
	border-radius: 3px;
	background: red;
	text-align: center;
	font-weight: 600;
	color: #fff;
	display: none;
}
.info {
	width:400px;
	height:30px;
	text-align:center;
	position:relative;
	margin-left:383px;
	left:0px;
	top:0px;
	margin-bottom:10px;
}
.info i {
	margin-top:8px;
}
</style>
</head>

<body class="supplier_bg_1">
	<!--    头部-->
	<div class="wa_wp">
		<div class="wa">
			<a href='/index/home'><img src="<?php echo base_url(); ?>static/img/logo.png"
				alt=""></a> <span class="wa_sapn_1">供应商注册</span>
			<div>
				<span class="wa_sapn_3"><a href="/admin/b1/">供应商登录</a></span><span
					class="wa_sapn_4"><a href="/">返回帮游旅行首页</a></span>
			</div>
		</div>
	</div>
	<div class="wrap">
		<div class="wrap_top_cl">
			<span>加入供应商</span>
		</div>
		<div class="schedule" style="height:115px;">
			<dd>
				<dl>创建账户</dl>
				<dl class="scheduleon">填写账户资料</dl>
				<dl>注册成功</dl>
			</dd>
			<br />
			<dd>
				<dl>
					<img src="<?php echo base_url(); ?>assets/img/register/reg_one_1.png" alt="">
				</dl>
				<dl>
					<img src="<?php echo base_url(); ?>assets/img/register/reg_twoon_1.png" alt="">
				</dl>
				<dl>
					<img src="<?php echo base_url(); ?>assets/img/register/reg_three.png" alt="">
				</dl>
			</dd>
		</div>
        <div class="info"><i></i><b></b></div>
		<div class="fromlist">
			<div class="fromname_1">
				<div class="fromtext">
				<form action="" id="register_form" method="post">
					<dd>
							<dl>
								<div class="enterprise_type">
									<span style="background-color: #fff; margin-left: 0px;">企业类型</span>
									<div class="enterprise_type_option" style="margin-left: 2px; display: inline; margin-left: -6px;">
										<span class="selecton" name="1">旅行社</span>
										<span name="2">景区</span> 
										<span name="3">酒店</span>
										<span name="4">票务</span> 
										<span name="5">政务</span> 
										<span name="6">车队</span> 
										<span name="7">其他</span>
									</div>
								</div>
							</dl>
						<!-- 用于保存企业类型 -->
						<input type="hidden" name="supplier_type" value="1">
					</dd>
					<!-- 旅行社列表 -->
					<dd class="data_frame travel_agency">
						<dl >
							<span style="">真实名字</span>
							<i><input type="text" name="realname" class="input1"></i>
						</dl>
						<dl >
							<span class="company_name">所属旅行社全称</span>
							<i><input type="text" name="company_name"></i>
						</dl>
						<dl style="display:block;" class="guide_number">
							<span>经营许可证号</span>
							<i><input type="text" name="management_code"></i>
						</dl>
						<!-- 景区 -->
						<dl style="margin-top: 20px;display:none;" class="scenic_spot">
							<span>景区认证</span>
							<i class="i_input"> 
								<input style="width: 20px; height: 10px; line-height: 10px;" name="spot_grade" value="1" type="radio">AA 
								<input style="width: 20px; height: 10px; line-height: 10px;" name="spot_grade" value="2" type="radio">AAA 
								<input style="width: 20px; height: 10px; line-height: 10px;" name="spot_grade" value="3" type="radio">AAAA 
								<input style="width: 20px; height: 10px; line-height: 10px;" name="spot_grade" value="4" type="radio">AAAAA 
								<input style="width: 20px; height: 10px; line-height: 10px;" name="spot_grade" value="0" type="radio">暂未评级
							</i>
						</dl>
 				  		<dl style="margin-top: 8px; " class="position"> 
							<span>岗位</span>
							<i>
							<select name="position">
								<option>选择岗位</option>
								<?php 
									foreach($position as $key =>$val){
										echo "<option value='{$val['dict_id']}'>{$val['description']}</>";	
									}
								?>
							</select></i>
						</dl>
						<dl style="margin-top: 0px; ">
							<span>所在地</span>
							<i style="margin-left: 12px;">
							 <select name="country_id" id="country_id"  class="input5">
									<option value="0">请选择</option>
                                    <?php
										foreach ( $area as $val ) {
											echo "<option value='{$val["id"]}'>{$val["name"]}</option>";
										}																																
									?>
                             </select></i>
						</dl>
						<dl style="margin-top: 11px; ">
							<span>QQ</span>
							<i><input type="text" name="qq" class="input6" maxlength="15"></i>
						</dl>
						<dl style="margin-top: 20px;">
							<input type="hidden" name="id" value="<?php echo $this ->input ->get('id'); ?>">
							<!-- <div id="login_error">请填写正确的手机号</div> -->
							<div class="bottom"  id="login_submit" style="margin-left:131px;"> 下&nbsp;一&nbsp;步 </div>
						</dl>
					</dd>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	$('.input6').keyup(function(){  
		var c=$(this);  
		if(/[^\d]/.test(c.val())){//替换非数字字符  
		  var temp_amount=c.val().replace(/[^\d]/g,'');  
		  $(this).val(temp_amount);  
		}  
	 });
	 $(".input1").blur(function(){
			var ture_name = $(this).val();
			if(ture_name.length<=0){
				$('.info b').html("请输入您的真实姓名");	
				$('.info').css("display","block");
				return false;
			}else{
				$('.info').css("display","none");
			};
		});
	 $(".input6").blur(function(){
			var qq = $(this).val();
			if(qq.length<=0){
				$('.info b').html("请输入您的QQ号");	
				$('.info').css("display","block");
				return false;
			}else if(!qq.match(/^[1-9]\d{4,14}$/)){
				$('.info b').html("QQ号码格式不正确");	
				$('.info').css("display","block");
			}else{
				$('.info').css("display","none");
			};
		});
	 
		$('#login_submit').click(function(){
			var ture_name = $(".input1").val();  
			var address = $(".input5").val(); 
			var qq = $(".input6").val(); 
			if(ture_name.length<=0){
				$('.info b').html("请输入您的真实姓名");	
				$('.info').css("display","block");
				return false;
			}else{
				$('.info').css("display","none");
			};
			if(address=="0"){
				$('.info b').html("请输入您的所在地");	
				$('.info').css("display","block");
				return false;
			}else{
				$('.info').css("display","none");
			};
			if(qq.length<=0){
				$('.info b').html("请输入您的QQ号");	
				$('.info').css("display","block");
				return false;
			}else if(!qq.match(/^[1-9]\d{4,14}$/)){
				$('.info b').html("QQ号码格式不正确");	
				$('.info').css("display","block");
			}else{
				$('.info').css("display","none");
			};
			
			$.post(
					"<?php echo site_url('admin/b1/register/perfect_supplier')?>",
					$('#register_form').serialize(),
					function(data) {
						data = eval('('+data+')');
						if (data.code == 2000) {
							location.href="<?php echo site_url('admin/b1/register/success')?>";
						} else {
							
							 alert(data.msg);
						}
					}
				);
		})
		$('select[name="country_id"]').change(function(){
			var country_id = $('select[name="country_id"] :selected').val();
			$('#province_id').remove();
			$('#city_id').remove();
			$('#region_id').remove();
			if (country_id == 0) {
				return false;
			}
			$.post(
				"<?php echo site_url('admin/b1/register/get_area')?>",
				{'id':country_id},
				function(data) {
					data = eval('('+data+')');
					$('#country_id').after("<select name='province_id' id='province_id'><option value='0'>请选择</option></select>");
					$.each(data ,function(key ,val){
						str = "<option value='"+val.id+"'>"+val.name+"</option>";
						$('#province_id').append(str);
					})
					$('#province_id').change(function(){
						var province_id = $('select[name="province_id"] :selected').val();
						province(province_id)
					})
				} 
			);
		})
		
		function province(id) {
			$('#city_id').remove();
			$('#region_id').remove();
			if (id == 0) {
				return false;
			}
			$.post(
				"<?php echo site_url('admin/b1/register/get_area')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					$('#province_id').after("<select name='city_id' id='city_id'><option value='0'>请选择</option></select>");
					$.each(data ,function(key ,val){
						str = "<option value='"+val.id+"'>"+val.name+"</option>";
						$('#city_id').append(str);
					})
					$('#city_id').change(function(){
						var city_id = $('select[name="city_id"] :selected').val();
						city(city_id)
					})
				} 
			);
		}
		function city(id) {
			$('#region_id').remove();
			if (id == 0) {
				return false;
			}
			$.post(
				"<?php echo site_url('admin/b1/register/get_area')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					if (data.length < 1) {
						return false;
					}
					$('#city_id').after("<select name='region_id' id='region_id'><option value='0'>请选择</option></select>");
					$.each(data ,function(key ,val){
						str = "<option value='"+val.id+"'>"+val.name+"</option>";
						$('#region_id').append(str);
					})
					
				} 
			);
		}
             // 企业类型列表切换
        $(function(){
            $(".enterprise_type_option span").click(function(){
				$('.info').css("display","none");
                $(this).addClass("selecton").siblings().removeClass("selecton");
                var is = $(this).attr('name');
                $('.company_name').parent('dl');
                $('.scenic_spot').hide();
                $('.guide_number').hide();
                $('.position').hide();
                if (is == 1) {
					var name = "所属旅行社全称";
					$('.company_name').parent('dl');
					$('.guide_number').show();
					$('.position').show();
                } else if (is == 2) {
					var name = "景区名称";
					$('.scenic_spot').show();
					$('.position').show();
                } else if (is == 3) {
					var name = "酒店名称";
                } else if (is == 4) {
                	var name = "公司名称";
                } else if (is == 5) {
                	var name = "机构名称";
                } else if (is == 6) {
                	var name = "公司名称";
                } else if (is == 7) {
                	var name = "公司名称";
                }
				$('.company_name').html(name);
				$('input[name="supplier_type"]').val(is);
//                 var idx=$(this).index();
//                 $(".data_frame:eq("+idx+")").show().siblings(".data_frame").hide();
            })
                                                     
        })
    </script>
</body>

</html>