<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>注册</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta charset="utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
	<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
	<link href="<?php echo base_url(); ?>assets/css/registerb-1.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>/static/plugins/DatePicker/skin/WdatePicker.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
    <style type="text/css">
    .audit_tips{color: red; text-align: center;}
    </style>
</head> 
<body  class="supplier_bg_1">
<div class="most_top">
	<div class="w_1200">
	    <div class="welcome green_word fl">欢迎来到帮游旅行网！</div>
	    <div class="enshrine"><a href="javascript:void(0);" onclick="addFavorite('bangu.com','jiarong')" class=" green_word" rel="sidebar"><i class="header_ico"></i>收藏本站</a></div>
	    <script>
                  //收藏本站
                    function addFavorite(sURL, sTitle) {
                    	//window.external.addFavorite(sURL, sTitle);
					    try {
					        //IE
					        window.external.addFavorite(sURL, sTitle);
					    } catch (e) {
					        try {
					            //Firefox
					            window.sidebar.addPanel(sTitle, sURL, "");
					        } catch (e) {
					            alert("您的浏览器不支持自动加入收藏，请使用Ctrl+D进行添加,或手动在浏览器里进行设置.", "提示信息");  
					        }
					    }
					}
                    </script>
		    <div class="context_menu">
	    	<ul>
	    		<li><a class="green_word" href="/admin/b1/index">供应商登录</a></li>
	            <li><a class="green_word" href="/admin/b1/register/index">供应商免费注册</a></li>
	            <li><a class="link_black" href="<?php echo site_url('index/site_map');?>">网站地图</a></li>
		   	</ul>
	    </div>
    </div>
</div>
<div class="regis_box">
	<div class="head_logo">
		<div class="logo_box"><a href="<?php echo sys_constant::INDEX_URL?>"><img src="/static/img/reg_logo.png" alt="logo"/></a></div>
		<div class="title_word">免费注册</div>
	</div>
</div>
	<div class="wrap main_reg">
    	<div class="main_title relative">
		    <div class="title_titl"><?php if (empty($supplier)) {echo '供应商合作';} else {echo '供应商注册-审核';}?></div>
		    	
		    	<div class="direct_logo">已经有帮游帐号了？您可以直接<a  href="/admin/b1/index">登录</a> </div>

	    </div>
	    <?php 
    		if (!empty($supplier)) {
    			echo '<div class="audit_tips">';
    			if ($supplier['status'] == 1) {
    				echo '<p class="expert_tishi">您的账号正在审核中</p>';
    			} else {
    				echo '<p class="expert_tishi">'.$supplier['refuse_reason'].'</p>';
    			}
    			echo '</div>';
    		}
    	?>

    	<div class="border_min">
        <ul class="qiehuan_head">
        	<!--<li>请选择供应商类型:</li>-->
            <li class="supplier_type reg_ico_jn back_pos_jn" >
            	<input type="radio" value="1" name="kind_title" <?php if (empty($supplier) || (!empty($supplier) && $supplier['kind'] == 1)) {echo 'checked' ;} ?> />
            </li>
            <li class="supplier_type reg_ico_jw" >
            	<input type="radio" value="3" name="kind_title" <?php if (!empty($supplier) && $supplier['kind'] == 3) {echo 'checked' ;}?> />
            </li>
            <li class="supplier_type reg_ico_gr" >
            	<input type="radio" value="2" name="kind_title" <?php if (!empty($supplier) && $supplier['kind'] == 2) {echo 'checked' ;}?> />
            </li>
        </ul>
        <div class="qiehuan_box">
        	<!--    境内供应商注册   -->
            <div class="jingnei_reg">
            	<form class="biaodan_jingnei" method="post" id="supplier_form">
                    <div class="biaoti">基本信息</div>
                	<ul>
                        <li>
                        	<span><div>负责人手机号：</div><u>*</u></span>
                        	<input name="mobile" maxlength="11" value='<?php if (!empty($supplier)) {echo $supplier['mobile'] ;} ?>' type="text" class="shouji" />
                            <input name="mobile" maxlength="11" disabled="disabled" value='<?php if (!empty($supplier)) {echo $supplier['mobile'] ;} ?>' type="text" class="shouji_wai sign" style="display:none" />

                        	<!--<div class="info2" style="left:520px;"></div>-->
                        		<!--各项提示-->
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3 class='html_jiwai'>请输入11位字符</h3></span>
                        		<span class="ti_2"><i></i><h3>只可输入数字</h3></span>
                        	</div>
                        </li>
                        
						<li>
							<span><div>负责人姓名：</div><u>*</u></span>
							<input name="responname" value='<?php if (!empty($supplier)) {echo $supplier['realname'] ;} ?>' type="text" maxlength="8" class="lianxiren">
							<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>可输入汉字和字母</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>
						</li>
						<li>
                        	<span><div>负责人邮箱：</div><u>*</u></span>
                        	<input name="email" value='<?php if (!empty($supplier)) {echo $supplier['email'] ;} ?>' type="text" class="email">
                        		<!---->
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>请使用邮箱格式</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>		
                        </li>
                        <li class="shangchuan">
                        	<span style="width:150px;"><div class="cardName">身份证扫描件：</div><u>*</u></span>
                        	<input type="file" onchange="uploadImgFile(this)" id="fileInput1" name="fileInput1" class="shangchuan_btn lianxiren">
                        	<div class="file_class">上传文件</div>
                        	<input type="hidden" name="cardImgUrl" value="<?php if(!empty($supplier)) {echo $supplier['idcardpic'] ;}?>">
                        	<?php 
                            	if (!empty($supplier)) {
                            		echo '<div class="fangda_box" style=" top:0px;">';
                            	} else {
                            		echo '<div class="fangda_box" style=" top:0px; display:none;">';
                            	}
                            ?>
                        	<img src="<?php if(!empty($supplier)) {echo $supplier['idcardpic'] ;}?>" class="fang_photo">
                        	</div>
                        </li>
                        <li class="live_place">
                        	<span><div>供应商所在地：</div><u>*</u></span>
                        	<div id="supplierAddress1"></div>
                        	<div id="supplierAddress2" style="display:none;"></div>
                        </li>
                        <li>
                        	<span><div>供应商品牌：</div><u>*</u></span>
                        	<input name="brand" value='<?php if (!empty($supplier)) {echo $supplier['brand'] ;} ?>' type="text" maxlength="5" placeholder="若没有，可填写公司简称+部门名" class="brand">
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>例:xx公司运营部</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>
                        </li>
                        <li>
                        	<span><div>主营业务：</div><u>*</u></span>
                        	<input name="expert_business" value='<?php if (!empty($supplier)) {echo $supplier['expert_business'] ;} ?>' type="text">
                        </li>
                        <li>
                        	<span><div>联系人：</div><u>*</u></span>
                        	<input name="linkman" value='<?php if (!empty($supplier)) {echo $supplier['linkman'] ;} ?>' type="text" class="lianxiren_waiguo">
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>可输入汉字和字母</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>
                        </li>
                        <li>
                        	<span><div>联系人邮箱：</div><u>*</u></span>
                        	<input name="linkemail" value='<?php if (!empty($supplier)) {echo $supplier['linkemail'] ;} ?>' type="text" class="email">
                        		<!---->
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>请使用邮箱格式</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>		
                        </li>
                        <li>
                            <span><div>联系人手机：</div><u>*</u></span>
                            <input name="link_mobile" value='<?php if (!empty($supplier)) {echo $supplier['link_mobile'] ;} ?>' type="text"  maxlength="11" class="shouji">
                            <input name="link_mobile" value='<?php if (!empty($supplier)) {echo $supplier['link_mobile'] ;} ?>' disabled="disabled" type="text"  maxlength="11" class="shouji_wai sign" style="display:none">
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3 class='html_jiwai'>请输入11位字符</h3></span>
                        		<span class="ti_2"><i></i><h3>只可输入数字</h3></span>
                        	</div>
                        </li>
                        <li>
                        	<span><div>设置密码：</div><u>*</u></span>
                        	<input name="password" type="password" placeholder="6-20位数字、字母或符号,区分大小写" onKeyUp="pwStrength(this.value ,this)" onBlur="pwStrength(this.value ,this)" maxlength="20" class="mima">
                        	<!--<div class="info4" style="left:520px;">dsadasdasds</div>-->
                        	<div class="ti_box pssw_num">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>密码长度为6-20</h3></span>
                        		<span class="ti_2"><i></i><h3>可输入字母或数字</h3></span>
                        	</div>
                        </li>
                        <li>
                        	<span><div>确认密码：</div><u>*</u></span>
                        	<input name="repass" maxlength="20" type="password" placeholder="请再次输入密码" class="zaici">
                        	<div class="ti_box pssw_zaici">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i class="repeat"></i><h3>两次密码输入一致</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>
                        </li>
                        <li>
                            <span><div>电话：</div><u>*</u></span>
                            <input name="tel" value='<?php if (!empty($supplier)) {echo $supplier['telephone'] ;} ?>' type="text" placeholder="区号-电话号码" maxlength="20">
                        </li>
                        <li>
                            <span><div>传真：</div><u>*</u></span>
                         	 <input name="fax" value='<?php if (!empty($supplier)) {echo $supplier['fax'] ;} ?>' type="text" placeholder="区号-传真号" maxlength="20">
                        </li>
                        
                   	</ul>
                   	
                   	<!-- 国内企业 -->
                    <ul class="domestic_ul">
                        <div class="biaoti">企业信息</div>
                        <li>
                        	<span><div>所属企业名称：</div><u>*</u></span>
                        	<input name="company_name" value='<?php if (!empty($supplier)) {echo $supplier['company_name'] ;} ?>' type="text" maxlength="100" class="company_name">
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>可输入汉字和字母</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>
                        </li>
                        <li class="shangchuan">
                        	<span style="width:150px;"><div>营业执照扫描件：</div><u>*</u></span>
                        	<input type="file" onchange="uploadImgFile(this)" id="fileInput2" name="fileInput2" class="shangchuan_btn">
                        	<div class="file_class">上传文件</div>
                        	<input type="hidden" name="business_licence" value="<?php if(!empty($supplier)) {echo $supplier['business_licence'] ;}?>">
                            <span class="red_col" style=" padding-left: 120px;">需加授权使用印章</span>
                            <?php 
                            	if (!empty($supplier)) {
                            		echo '<div class="fangda_box" style=" top:0px;">';
                            	} else {
                            		echo '<div class="fangda_box" style=" top:0px; display:none;">';
                            	}
                            ?>
                        		<img src="<?php if(!empty($supplier)) {echo $supplier['business_licence'] ;}?>" class="fang_photo">
                        	</div>
                        </li>
                        <li class="shangchuan">
                        	<span style="width:150px;"><div>经营许可证扫描件：</div><u>*</u></span>
                        	<input type="file" onchange="uploadImgFile(this)" id="fileInput3" name="fileInput3" class="shangchuan_btn">
                        	<div class="file_class">上传文件</div>
                        	<input type="hidden" name="licence_img" value="<?php if(!empty($supplier)) {echo $supplier['licence_img'] ;}?>">
                        	<?php 
                            	if (!empty($supplier)) {
                            		echo '<div class="fangda_box" style=" top:0px;">';
                            	} else {
                            		echo '<div class="fangda_box" style=" top:0px; display:none;">';
                            	}
                            ?>
                        		<img src="<?php if (!empty($supplier)) {echo $supplier['licence_img'];}?>" class="fang_photo" />
                        	</div>
                        </li>
                        <li>
                            <span><div>经营许可证编号：</div><u>*</u></span>
                            <input name="licence_img_code" value='' type="text" placeholder="许可证编号" />
                        </li>
                        <li>
                        	<span><div>法人代表姓名：</div><u>*</u></span>
                        	<input name="corp_name" value='<?php if (!empty($supplier)) {echo $supplier['corp_name'] ;} ?>' type="text" class="lianxiren">
                        	<div class="ti_box">
                        		<div class="tri"></div>
                        		<span class="ti_1"><i></i><h3>可输入汉字和字母</h3></span>
                        		<span class="ti_2"><i></i><h3>输入不能为空</h3></span>
                        	</div>
                        </li>
                        <li class="shangchuan">
                        	<span style="width:150px;"><div style=" width:180px;">法人代表身份证扫描件：</div></span>
                        	<input type="file" onchange="uploadImgFile(this)" id="fileInput6" name="fileInput6" class="shangchuan_btn">
                        	<div class="file_class">上传文件</div>
                        	<input type="hidden" name="corp_idcardpic" value="<?php if(!empty($supplier)) {echo $supplier['corp_idcardpic'] ;}?>">
                        	<?php 
                            	if (!empty($supplier)) {
                            		echo '<div class="fangda_box" style=" top:0px;">';
                            	} else {
                            		echo '<div class="fangda_box" style=" top:0px; display:none;">';
                            	}
                            ?>
                        		<img src="<?php if (!empty($supplier)) {echo $supplier['corp_idcardpic'];}?>" class="fang_photo">
                        	</div>
                        </li>
                        <li class="relative">
                        	<span><div>手机账户验证码：</div><u>*</u></span>
                        	<input name="code" type="text" style=" width:210px;" maxlength="11">
                       		<div class="wrep_yanzheng2" id="btnSendCode1" >获取验证码</div>
                        </li>
                        <div class="huoqu_hidden2" id="yanzheng">
            				<input class="yanzheng_shuru2" type="text" name="vcode" placeholder="输入四位验证码" autofocus id="input3" maxlength="4">
            				<div style="float:right; height:40px;width:91px;">
            					<img style="height:39px;border:1px solid #ccc; width:88px;" id='verifycode1' src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()">
            				</div>
              				<div class="tijiao" onclick="getMobileCode(this ,1);">提交</div>
                			<div class="guanbi">关闭</div>
            			</div>        
                   </ul>
                   
                   <!-- 国外企业 -->
                   <ul class="abroad_ul" style="display: none;">
                        <div class="biaoti">企业信息</div>
                        <li>
                        	<span><div>所属企业名称：</div><u>*</u></span>
                        	<input name="company_name" value='<?php if (!empty($supplier)) {echo $supplier['company_name'] ;} ?>' type="text" maxlength="100" />
                        </li>
                        <li>
                        	<span><div>法人代表姓名：</div><u>*</u></span>
                        	<input name="corp_name" value='<?php if (!empty($supplier)) {echo $supplier['corp_name'] ;} ?>' type="text" maxlength="11" class="lianxiren">
                        	<div class="info1">dsadasdasds</div>
                        </li>
                        <li>
                        	<span><div>验证码：</div><u>*</u></span>
                        	<input name="code" type="text" style=" width:210px;" maxlength="11">
                       		<img id="verifycode2" src="<?php echo base_url(); ?>tools" style=" border:1px solid #999; width:80px; height:38px; margin-left:15px;" onclick="this.src='<?php echo base_url();?>tools?'+Math.random()">
                       	</li>      
                   </ul>
                   
                   <!-- 个人 -->
                   <ul class="individual_ul" style="display: none;">
                   		<li>
                        	<span><div>手机验证码：</div><u>*</u></span>
                        	<input name="code" type="text" style=" width:210px;" maxlength="11" />
                       		<div class="wrep_yanzheng3" id="btnSendCode2"  >获取验证码</div>
                       	</li>
                        <div class="huoqu_hidden3 " id="yanzheng">
            				<input class="yanzheng_shuru3" type="text" name="vcode" placeholder="输入四位验证码" autofocus id="input3" maxlength="4" />
            				<div style="float:right; height:40px;width:91px;">
            					<img style="height:39px;border:1px solid #ccc; width:88px;" id='verifycode3' src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()" />
            				</div>
               				<div class="tijiao" onclick="getMobileCode(this,2)">提交</div>
                			<div class="guanbi">关闭</div>
           			    </div>
                   </ul>
                   <input type="hidden" name="sid" value="<?php if (!empty($supplier)) {echo $supplier['id'];}?>" />
                   <input type="hidden" name="kind" />
                   <input type="submit" value="提交审核" class="button_zhuce" />
				</form>
            </div>
        </div>
   	</div>
</div>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('static/js/common.js') ;?>"></script>
<script type="text/javascript">
var province = <?php if (empty($supplier)) {echo 0 ;} else {echo $supplier['province'];}?>;
var city = <?php if (empty($supplier)) {echo 0 ;} else {echo $supplier['city'];}?>;
var kind = <?php if (empty($supplier)) {echo 0 ;} else {echo $supplier['kind'];}?>;
var kind_title = $("input[name='kind_title']:checked").val();
disabledInput(kind_title);

function disabledInput(kind_title) {
	//$("input[name='cardImgUrl']").val('');
	//$("input[name='cardImgUrl']").next("div").hide();
	if (kind_title == 1) { 
		//国内
		$(".domestic_ul").show().find("input").removeAttr("disabled");
		$(".individual_ul,.abroad_ul").hide().find("input").attr("disabled","disabled");
		$(".cardName").html('身份证扫描件：');
		$("#supplierAddress1").show().find("select").removeAttr("disabled");
		$("#supplierAddress2").hide().find("select").attr("disabled","disabled");
	} else if (kind_title == 3) {
		//国外
		$(".abroad_ul").show().find("input").removeAttr("disabled");
		$(".individual_ul,.domestic_ul").hide().find("input").attr("disabled","disabled");
		$(".cardName").html('有效证件扫描件：');
		$("#verifycode2").trigger("click");
		$("#supplierAddress2").show().find("select").removeAttr("disabled");
		$("#supplierAddress1").hide().find("select").attr("disabled","disabled");
	} else if (kind_title == 2) {
		//个人
		$(".individual_ul").show().find("input").removeAttr("disabled");
		$(".domestic_ul,.abroad_ul").hide().find("input").attr("disabled","disabled");
		$(".cardName").html('身份证扫描件：');
		$("#supplierAddress1").show().find("select").removeAttr("disabled");
		$("#supplierAddress2").hide().find("select").attr("disabled","disabled");
	}
}
//供应商类型切换
$(".supplier_type").click(function(){
	
	$(this).find("input").attr("checked","checked");
	$(this).siblings().find("input").removeAttr("checked");
	var kind_title = $("input[name='kind_title']:checked").val();
	disabledInput(kind_title);

	// 获取 input的类型 点击清空
	var input_text = $("#supplier_form input[type='text']");
	var input_password = $("#supplier_form input[type='password']");
	$(input_text).val("");
	$(input_password).val("");
	$(".fangda_box").hide();
	
})

if (province > 0) {
	var defaultJson = {0:province,1:city};
	if (kind == 1 || kind ==2) {
		//获取中国的省份下拉框
		chinaPC("supplierAddress1" ,160 ,defaultJson);
		abroadPC("supplierAddress2" ,160);
	} else {
		chinaPC("supplierAddress1" ,160);
		//获取境外的国家下拉
		abroadPC("supplierAddress2" ,160 ,defaultJson);
	}
} else {
	//获取中国的省份下拉框
	chinaPC("supplierAddress1" ,160);
	//获取境外的国家下拉
	abroadPC("supplierAddress2" ,160);
}


//提交表单
var formStatus = true;
$("#supplier_form").submit(function(){
	if (formStatus == false) {
		return false;
	} else {
		fromStatus = true;
	}
	var sid = $("input[name='sid']").val();
	if (sid.length > 1) {
		var url = "/admin/b1/register/perfect_supplier";
	} else {
		var url = "/admin/b1/register/supplier_register";
	}
	var type = $("input[name='kind_title']:checked").val();
	if (type == 1 || type == 2) {
		$("#supplierAddress1").find("select").removeAttr("disabled");
		$("#supplierAddress2").find("select").attr("disabled","disabled");
	} else {
		$("#supplierAddress2").find("select").removeAttr("disabled");
		$("#supplierAddress1").find("select").attr("disabled","disabled");
	}
	
	$("input[name='kind']").val(type);
	$.post(url,$(this).serialize(),function(json){
		fromStatus = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			//alert(data.msg);
			location.href="/admin/b1/register/success";
		} else {
			alert(data.msg);
		}
	});
	return false;
})
//上传文件
function uploadImgFile(obj){
	var fileId = $(obj).attr('id');
	$.ajaxFileUpload({
		url : '/admin/upload/uploadImgFile',
	    secureuri : false,
	    fileElementId : fileId,// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {fileId : fileId ,prefix :'supplier_register'},
	    success : function(data, status) {
		    if (data.code == 2000) {
			   $('#'+fileId).nextAll('input[type="hidden"]').val(data.msg);
			   $('#'+fileId).nextAll('.fangda_box').show().find('img').attr('src',data.msg)
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
//发送短信
var codeStatus = true;
function getMobileCode(obj ,type){
	if (codeStatus == false) {
		return false;
	} else {
		codeStatus = false;
	}
	var buttonId = 'btnSendCode'+type;
	var mobile = $(obj).parents("form").find("input[name='mobile']").val();
	var code = $(obj).prev("div").prev("input").val();
	if (!isMobile(mobile)) {
		alert('请填写正确的手机号');
		codeStatus = true;
		return false;
	}
	$.post("/send_code/sendMobileCode",{mobile:mobile,type:6,verifycode:code},function(json){
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

		$(".input2").blur(function(){
			var mobile_yzm = $(this).val();
			if(mobile_yzm.length<=0){
				$('.info2 b').html("请输入您收到的短信验证码");	
				$('.info2').css("display","block");
				return false;
			}else{
				$('.info2').css("display","none");
			};
		});
		$("#input3").blur(function(){
			var img_yzm = $(this).val();
			if(img_yzm.length<=0){
				$('.info3 b').html("图形验证码不能为空");	
				$('.info3').css("display","block");
				return false;
			}else{
				$('.info3').css("display","none");
			};
		});

        //第二个密码验证
        $(function(){
            $(".fangda_box").mouseover(function(){
                $(this).css("top","-210px");
                $(this).find("img").css("width","240px");
                $(this).find("img").css("height","240px");
            })
            $(".fang_photo").mouseleave(function(){
                $(this).parents().css("top","0")
                $(this).css("width","30px");
                $(this).css("height","30px");
            })
            $(".tijiao").click(function(){
                $(".yanzheng_one").hide();
                $(".yanzheng_two").hide();
                $(".yanzheng_three").hide();
            })
            $(".guanbi").click(function(){
                $(".yanzheng_two, .yanzheng_one, .yanzheng_three").hide();
            })
            $(".wrep_yanzheng2").click(function(){
                $("#verifycode1").trigger("click");
                $(".huoqu_hidden2").show();
            })
            $(".guanbi").click(function(){
                $(".huoqu_hidden2").hide();
            })
            $(".wrep_yanzheng3").click(function(){
            	$("#verifycode3").trigger("click");
                $(".huoqu_hidden3").show();
            })
            $(".guanbi").click(function(){
                $(".huoqu_hidden3").hide();
            })
        })
		$(function(){
			$("input").attr("autocomplete","off")
		})
    </script> 
    <script>
    //点击改变切换是的背景图
        	$(function(){
                var jn= $(".reg_ico_jn"); //境内
                var jw= $(".reg_ico_jw") //境外
                var jn= $(".reg_ico_jw") //个人

                var jingwai =  $('.html_jiwai')
        		$(".reg_ico_jn").click(function(){
        			$(".reg_ico_jn").removeClass("back_pos_jn");
        			$(".reg_ico_gr").removeClass("back_pos_gr");
        			$(".reg_ico_jw").removeClass("back_pos_jw");
      				$(this).addClass("back_pos_jn");

                    
                    jingwai.html('请输入11位字符')
                    
                    $('.shouji_wai').attr("disabled","disabled").hide();
                    $('.shouji').removeAttr("disabled").show();

        		});
        		$(".reg_ico_jw").click(function(){
        			$(".reg_ico_jn").removeClass("back_pos_jn");
        			$(".reg_ico_gr").removeClass("back_pos_gr");
        			$(".reg_ico_jw").removeClass("back_pos_jw");
      				$(this).addClass("back_pos_jw");
                    //境外的手机号有 8-11位 需要更换 html  和字符数量的验证
                    jingwai.html('请输入8-11位字符')

                    $('.shouji').attr("disabled","disabled").hide();
                    $('.shouji_wai').removeAttr("disabled").show();
                    //<input name="mobile" maxlength="11" readonly="readonly" value='<?php if (!empty($supplier)) {echo $supplier['mobile'] ;} ?>' type="hidden" class="shouji_wai">
        		});
        		$(".reg_ico_gr").click(function(){
        			$(".reg_ico_jn").removeClass("back_pos_jn");
        			$(".reg_ico_gr").removeClass("back_pos_gr");
        			$(".reg_ico_jw").removeClass("back_pos_jw");
      				$(this).addClass("back_pos_gr");

                    $('.shouji_wai').attr("disabled","disabled").hide();
                    $('.shouji').removeAttr("disabled").show();

                    jingwai.html('请输入11位字符')
                    //$('.html_jiwai').parent().parent().siblings('input').removeClass('shouji_wai').addClass('shouji');
        		});
        	})
        </script>
<script>
    /*手机号验证*/
    $(function(){
        /*获取焦点先显示*/
        $(".shouji").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".shouji").blur(function(){
            $(this).siblings(".ti_box").hide();
        })
        $(".shouji").keyup(function(){
            var mobile = $(this).val();
            if(mobile.length<=10){
            /*ti_1*/
                $(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };
            if(!mobile.match(/[0-9]/)){   
            /*ti_2*/
                $(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_defa").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }
            /*ti_1*/ /*ti_2*/
            if(mobile.length==0){
                /*ti_1*/  /*ti_1*/
                $(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");	
            }
        })
    });

</script>

<script>
    /*手机号验证*/
    $(function(){
        /*获取焦点先显示*/
        $(".shouji_wai").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".shouji_wai").blur(function(){
            $(this).siblings(".ti_box").hide();
        })
        $(".shouji_wai").keyup(function(){
            var mobile = $(this).val();
            if(mobile.length<8){
            /*ti_1*/
                $(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };
            if(!mobile.match(/[0-9]/)){   
            /*ti_2*/
                $(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_defa").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }
            /*ti_1*/ /*ti_2*/
            if(mobile.length==0){
                /*ti_1*/  /*ti_1*/
                $(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");  
            }
        })
    });

    //shouji_wai  请输入8-11位字符  

</script>


<script>
    /*密码验证*/
    $(function(){
        $(".mima").focus(function(){
            $(this).siblings(".ti_box").show();
        });
       	$(".mima").blur(function(){
            $(this).siblings(".ti_box").hide();
            var pw1 = $(".zaici").val();
			var pw2 = $(".mima").val();
			if(pw1!=pw2){
			}else{
				$(".repeat").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
			}
        });
        $(".mima").keyup(function(){
            var mobile = $(this).val();
            if(mobile.length<6 || mobile.length>20){
            /*ti_1*/
            	$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };
            if(!mobile.match(/^[0-9a-zA-Z]*$/)){   
            /*ti_2*/
                $(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_defa").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }
            if(mobile.length==0){
            /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");
            }
        })
    })
</script>
<script>
    /*密码验证*/
    $(function(){
        $(".zaici").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".zaici").blur(function(){
            $(this).siblings(".ti_box").hide();
            var pw1 = $(".zaici").val();
			var pw2 = $(".mima").val();
			if(pw1!=pw2){
			}else{
				$(".repeat").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
			}
        });
        $(".zaici").keyup(function(){
            var mobile = $(this).val();
            var pw1 = $(".zaici").val();
			var pw2 = $(".mima").val();
        	if(pw1!=pw2 || pw2!=pw1){
			$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");	
			}else{
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
			};
        	if(mobile.length==0){
        	/*ti_1*/  /*ti_2*/
          		$(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");
        	}else{
				$(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_no").removeClass("tri_defa").addClass("tri_ok");
			};
        })
    })
</script>
<script>
    /*姓名验证*/
    $(function(){
        $(".lianxiren,.lianxiren_waiguo,.company_name").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".lianxiren,.lianxiren_waiguo,.company_name").blur(function(){
            $(this).siblings(".ti_box").hide();
        });
        $(".lianxiren,.lianxiren_waiguo,.company_name").keyup(function(){
            var mobile = $(this).val();
            if(!mobile.match(/([A-Za-z]|[\u4E00-\u9FA5])/)){
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");	
			}else{
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
			};
            if(mobile.length==0){
            /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");
            }else{
				$(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_no").removeClass("tri_defa").addClass("tri_ok");
			};
        })
    })
</script>
<script>
    /*brand 格式实例*/
    $(function(){
        $(".brand").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".brand").blur(function(){
            $(this).siblings(".ti_box").hide();
        });
        $(".brand").keyup(function(){
            var mobile = $(this).val();
            if(!mobile.match(/([A-Za-z]|[\u4E00-\u9FA5])/)){
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");	
			}else{
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
			};
            if(mobile.length==0){
                /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");
            }else{
				$(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_no").removeClass("tri_defa").addClass("tri_ok");
			};
        })
    })
</script>
<script>
    /*姓名验证*/
    $(function(){
        $(".email").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".email").blur(function(){
            $(this).siblings(".ti_box").hide();
        });
        $(".email").keyup(function(){
            var mobile = $(this).val();
            if(!mobile.match(/^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/)){
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").addClass("tri_no");	
			}else{
				$(this).siblings(".ti_box").find(".ti_1").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
			};
            if(mobile.length==0){
                /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find("span").find("i").removeClass("tri_ok").addClass("tri_defa");
            }else{
				$(this).siblings(".ti_box").find(".ti_2").find("i").removeClass("tri_no").removeClass("tri_defa").addClass("tri_ok");
			};
        })
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