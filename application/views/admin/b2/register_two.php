<!DOCTYPE html>
<html>

<head>
    <title>注册</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta charset="utf-8">
    <link href="<?php echo base_url(); ?>assets/css/register.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
    <style>
    	#login_error{
    		border-radius: 3px;
			background: red;
			text-align: center;
			font-weight: 600;
			color: #fff;
			display:none;
    	}
		.info {
			left:470px;
		}
		.info b { 
			padding-left:28px;
		}
		.place_select select {
			height:39px;
			line-height:40px;
		}
    </style>
</head>

<body class="supplier_bg_1">
    <!--    头部-->
<div  class="wa_wp">
    <div class="wa">
        <a href='/index/home'><img src="<?php echo base_url(); ?>static/img/logo.png" alt=""></a>
        <span class="wa_sapn_1">管家注册</span>
        <div><span class="wa_sapn_2"><a href="/admin/b2/login">管家登录</a></span><span class="wa_sapn_4"><a href="/">返回帮游旅行首页</a></span></div>
    </div>
  </div>
    <div class="wrap">
           <div  class="wrap_top_cl"><span>免费注册</span></div>
            <div class="schedule">
                        <dd><dl>创建账户</dl><dl class="scheduleon">填写账户资料</dl><dl>注册成功</dl></dd><br />
                        <dd>
                            <dl><img src="<?php echo base_url(); ?>assets/img/register/reg_one_1.png" alt=""></dl>
                            <dl><img src="<?php echo base_url(); ?>assets/img/register/reg_twoon_1.png" alt=""></dl>
                            <dl><img src="<?php echo base_url(); ?>assets/img/register/reg_three.png" alt=""></dl>
                        </dd>
            </div>
            <div class="fromlist b2_reg_box">
                        <div class="fromname_1">
                                 <div  class="fromtext">
                                 <form action="" id="register_form" method="post">
                                <dd>
                                    
                                    <dl>
                                        <div class="enterprise_type">
                                           <span style="background-color:#fff;margin-left: 0px;background:none;">从业类型</span>
                                           <div class="enterprise_type_option" style="margin-left:2px; display:inline;margin-left: -6px;">
                                            
                                          	<?php
												foreach($industry_type as $key =>$val) {
													if ($key == 0) {
														echo "<input type='hidden' name='industry_type' value='{$val['dict_id']}'>";
														echo "<span class='selecton' value='{$val['dict_id']}'>{$val['description']}</span>";
													} else {
														echo "<span value='{$val['dict_id']}'>{$val['description']}</span>";
													}
												}
                                          	?>
                                            </div>
                                            
                                    </div>
                                    </dl>
                                </dd>
                                <!-- 管理人员列表 -->
                                <dd  class="data_frame travel_agency "  style="clear:both;">
                                    <dl style="margin-top:11px;">
                                    	<span style=" ">真实名字</span>
                                    	<i><input type="text" name="realname" class="input1"></i>
                                        <div class="info info1"><i></i><b></b></div>
                                    </dl>
                                    <dl style="margin-top:11px;">
                                    	<span style=" ">身份证号</span>
                                    	<i><input type="text" name="idcard" class="input5" maxlength="20"></i>
                                        <div class="info info5"><i></i><b></b></div>
                                    </dl>
                                    <dl style="margin-top:11px; position: relative;">
                                    	<span style=" ">证件扫描件</span>
                                    	<i><input type="file" name="up_idcardpic" onchange="upload_file('up_idcardpic')" id="up_idcardpic" style="width:64px;" value="" /></i>
                                    	<div class="fangda_boxb1" style="display: none;">
                        					<img src="" class="fang_photo"></div>
                                    	<input type="hidden" name="idcardpic" value="" class="input6">
                                        
                                        <div class="info info6"><i></i><b></b></div>
                                    </dl>
                                    <dl style="margin-top:10px;">
                                    	<span>所属旅行社全称</span>
                                    	<i><input type="text" name="company_name" class="input2"></i>
                                        <div class="info info2"><i></i><b></b></div>
                                    </dl>
                                    <dl style="margin-top:11px;padding-left: 0px;">
                                    	<span>所在地</span>
                                        <i style="margin-left:12px; " class="place_select"> 
                                        	<select name="country_id" id="country_id" class="input3">
                                            <option value="0">请选择</option>
                                            <?php 
                                                foreach($area as $val) {
                                                    echo "<option value='{$val["id"]}'>{$val["name"]}</option>";
                                                }

                                            ?>
                                       		</select>
                                       	</i>
                                        <div class="info info3"><i></i><b></b></div>
                                    </dl>
                                    <dl style="margin-top:11px;">
                                    	<span>QQ</span><i><input type="text" name="qq" class="input4" maxlength="15"></i>
                                        <div class="info info4"><i></i><b></b></div>
                                    </dl>
                                    <dl style="margin-top:20px;">
                                           <input type="hidden" name="id" value="<?php echo $this ->input ->get('id'); ?>" >
                                        <!-- <div id="login_error">请填写正确的手机号</div> -->
                                        <div class="bottom"  id="login_submit" style="margin-left:131px;"> 下&nbsp;一&nbsp;步 </div>
                                    </dl>
                                
                                </dd>
                              </form>
                        </div>
                  </div>
            </div>
    </div>
    <script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
    <script>
  //上传文件
    function upload_file(fileId) {
    	$.ajaxFileUpload({
    	    url : '/admin/b2/register/upload_file',
    	    secureuri : false,
    	    fileElementId : fileId,// file标签的id
    	    dataType : 'json',// 返回数据的类型
    	    data : {
    	        filename : fileId,
    	    },
    	    success : function(data, status) {
    		    if (data.code == 2000) {
    			   alert('上传成功');
    			   $('input[name="idcardpic"]').val(data.msg);
    			  	$('.fang_photo').attr('src',data.msg).parent('div').show();
    		    } else {
    			    alert(data.msg);
    		    }
    	    },
    	    error : function(data, status, e)// 服务器响应失败处理函数
    	    {
    		    alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
    	    }
    	});
    }
	$('.input4').keyup(function(){  
		var c=$(this);  
		if(/[^\d]/.test(c.val())){//替换非数字字符  
		  var temp_amount=c.val().replace(/[^\d]/g,'');  
		  $(this).val(temp_amount);  
		}  
	 });
		$(".input1").blur(function(){
			var ture_name = $(this).val();
			if(ture_name.length>0){
				$('.info1').css("display","none");
			};
		});
		$(".input5").blur(function(){
			var zjh = $(this).val();
			if(zjh.length>0){
				$('.info5').css("display","none");
			};
		});
		$(".input2").blur(function(){
			var quanchen = $(this).val();
			if(quanchen.length>0){
				$('.info2').css("display","none");
			};
		});
		
		$(".input4").blur(function(){
			var qq = $(this).val();
			if(!qq.match(/^[1-9]\d{4,14}$/)&&qq.length!=0){
				$('.info4 b').html("QQ号码格式不正确");	
				$('.info4').css("display","block");
			}else{
				$('.info4').css("display","none");
			};
		});

		var s = true;
		$('#login_submit').click(function(){
			if (s == false) {
				return false;
			} else {
				s = false;
			}
			var ture_name = $(".input1").val(); 
			var quanchen = $(".input2").val(); 
			var address = $(".input3").val(); 
			var qq = $(".input4").val(); 
			var zjh = $(".input5").val(); 
			var smj = $(".input6").val(); 
			if(ture_name.length<=0){
				$('.info1 b').html("请输入您的真实姓名");	
				$('.info1').css("display","block");
				s = true;
				return false;
			}else{
				$('.info1').css("display","none");
			};
			if(zjh.length<=0){
				$('.info5 b').html("请输入您的证件号");	
				$('.info5').css("display","block");
				s = true;
				return false;
			}else{
				$('.info5').css("display","none");
			};
			if(smj.length<=0){
				$('.info6 b').html("请上传您的证件扫描件");	
				$('.info6').css("display","block");
				s = true;
				return false;
			}else{
				$('.info6').css("display","none");
			};
			if(quanchen.length<=0){
				$('.info2 b').html("请输入您所属旅行社全称");	
				$('.info2').css("display","block");
				s = true;
				return false;
			}else{
				$('.info2').css("display","none");
			};
			if(address=="0"){
				$('.info3 b').html("请输入您的所在地");	
				$('.info3').css("display","block");
				s = true;
				return false;
			}else{
				$('.info3').css("display","none");
			};
			if(qq.length >0) {
				if(!qq.match(/^[1-9]\d{4,14}$/)){
					$('.info4 b').html("QQ号码格式不正确");	
					$('.info4').css("display","block");
					s = true;
					return false;
				}else{
					$('.info4').css("display","none");
				}
			}
			$.post(
					"<?php echo site_url('admin/b2/register/perfect_expert')?>",
					$('#register_form').serialize(),
					function(data) {
						s = true;
						data = eval('('+data+')');
						if (data.code == 2000) {
							location.href="<?php echo site_url('admin/b2/register/success')?>";
						} else if (data.code == 3200){
							location.href="<?php echo site_url('admin/b2/register/index')?>";
						} else if (data.code == 8000) {
							alert(data.msg);
							location.href="<?php echo site_url('admin/b2/register/index')?>";
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
				"<?php echo site_url('admin/b2/register/get_area')?>",
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
				"<?php echo site_url('admin/b2/register/get_area')?>",
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
				"<?php echo site_url('admin/b2/register/get_area')?>",
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
                $(this).addClass("selecton").siblings().removeClass("selecton");
				$('input[name="industry_type"]').val($(this).attr('value'));
                var idx=$(this).index();
                $(".data_frame:eq("+idx+")").show().siblings(".data_frame").hide();
            })
                                                     
        })
        $(function(){
            $("#yanzheng_one").click(function(){
                $(".yanzheng_one").show();
            });
            $("#yanzheng_two").click(function(){
                $(".yanzheng_two").show();
            });
            $("#yanzheng_three").click(function(){
                $(".yanzheng_three").show();
            });
            $(".fangda_boxb1").mouseover(function(){
               $(this).css("top","-100px");
                $(this).find("img").css("width","240px");
                $(this).find("img").css("height","240px");
            })
            $(".fang_photo").mouseleave(function(){
            $(this).parents(".fangda_boxb1").css("top","8px")
                $(this).css("width","30px");
                $(this).css("height","30px");
            })
            
        })
    </script>
</body>

</html>