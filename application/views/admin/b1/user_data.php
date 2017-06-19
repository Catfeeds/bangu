<style type="text/css">
.form-control {
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	color: #555;
	display: block;
	font-size: 14px;
	height: 34px;
	line-height: 1.42857;
	padding: 6px 12px;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s
		ease-in-out 0s;
	width: 20%;
}
.form-group{
margin-bottom:30px;
}
.col-sm-2 {
    width: 9%;
	height:32px;
	text-align:right;
	margin-right:3%;
}
input[type="checkbox"],input[type="radio"] {
	left: 0px;
	opacity: 100;
	position: static;
}
.col_ts {float: left;} 

.form-group .disabled { color:#aaa;}
body:before,body,.widget-body { background:#fff;}
select { height:36px !important;line-height:36px !important;}
.t_content{margin-left:10px}
</style>


<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">B1后台</li>
		<li class="active">资料修改</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div id="registration-form">
             <form action="<?php echo base_url()?>admin/b1/user/index" accept-charset="utf-8"  method="post" 
			novalidate="novalidate" id="userform"  enctype="multipart/form-data" >
            <table class="table_form_content table_td_border" border="1" width="800">
                <tr class="form_group">
                    <td class="form_title">负责人姓名：</td>
                    <td><span class="t_content"><?php if(!empty($realname)){echo $realname;}  ?></span><!-- <input type="text" placeholder="负责人姓名" id="userameInput" class="form_input disabled" name="realname" value="" disabled /> --></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">负责人手机号：</td>
                    <td><span class="t_content"><?php if(!empty($mobile)){echo $mobile ;} ?></span><!-- <input type="text" placeholder="负责人手机号" id="mobile" class="form_input disabled" name="mobile" value="" disabled> --></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">负责人邮箱：</td>
                    <td><span class="t_content"><?php if(!empty($email)){echo $email  ;}  ?></span><!-- <input type="text" placeholder="负责人邮箱" id="" class="form_input disabled" name="email" value="" disabled> --></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title"><i class="important_title">*</i>联系人：</td>
                    <td><input type="text" placeholder="联系人" id="linkman" class="form_input" name="linkman" value="<?php echo $linkman ; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title"><i class="important_title">*</i>联系人手机号：</td>
                    <td><input type="text" placeholder="手机号" id="link_mobile" class="form_input" name="link_mobile" value="<?php echo $link_mobile ; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title"><i class="important_title">*</i>联系人邮箱：</td>
                    <td><input type="text" placeholder="联系人邮箱" class="form_input" name="linkemail" value="<?php echo $linkemail  ; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">法人代表姓名：</td>
                    <td><?php  if(!empty($corp_name)){ echo $corp_name  ;} ?><!-- <input type="text" placeholder="法人代表姓名" class="form_input disabled" name="corp_name" id="corp_name" value="" disabled> --></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">有效证件扫描件：</td>
                    <td><img src="<?php echo $idcardpic; ?>" class="form_img">
                    <input type="hidden" name="idcardpic" value="<?php echo $idcardpic; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">法人代表身份证扫描件：</td>
                    <td><img src="<?php echo $corp_idcardpic; ?>" class="form_img">
                    <input type="hidden" name="corp_idcardpic" value="<?php echo $corp_idcardpic; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">营业执照扫描件：</td>
                    <td><img src="<?php echo $business_licence ; ?>" class="form_img">
                    <input type="hidden" name="business_licence" value="<?php echo $business_licence; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">经营许可证扫描件：</td>
                    <td><img src="<?php echo $licence_img; ?>" class="form_img">
                    <input type="hidden" name="licence_img" value="<?php echo $licence_img; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">经营许可证编码：</td>
                    <td><input type="text" placeholder="经营许可证编码" class="form_input" name="licence_img_code" id="licence_img_code" value="<?php echo $licence_img_code; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">供应商品牌：</td>
                    <td><span class="t_content"><?php  if(!empty($brand)){echo $brand;} ?></span><!-- <input type="text" placeholder="品牌名称" class="form_input disabled" name="idcard" id="idcard" value="" disabled> --></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">主营业务：</td>
                    <td><input type="text" placeholder="主营业务" class="form_input" name="expert_business" id="expert_business" value="<?php echo $expert_business; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">企业名称：</td>
                    <td><span class="t_content"><?php  if(!empty($company_name)){echo $company_name;} ?></span><!-- <input type="text" placeholder="企业名称" class="form_input disabled" name="company_name" id="company_name" value="" disabled> -->
                    </td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">固定电话：</td>
                    <td><input type="text" placeholder="固定电话" class="form_input" name="telephone" id="telephone" value="<?php echo $telephone; ?>">
                    <span class="title_txt">如:010-XXXXXXXX</span>
                    </td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">传真：</td>
                    <td><input type="text" placeholder="传真" class="form_input " name="fax" id="fax" value="<?php echo $fax; ?>"></td>
                </tr>
                <tr class="form_group">
                    <td class="form_title"><i class="important_title">*</i>供应商所在地：</td>
                    <td>
                    	<select name="country_id" id="country_id">
                            <option value="0">选择国家</option>
                            <?php   foreach($area as $val) {?>
                            <option value='<?php echo $val["id"];?>' <?php if($country==$val["id"]){echo 'selected="selected"';} ?>><?php echo $val["name"]; ?></option>
                            <?php }  ?>
                    	</select>
                    	<?php if(!empty($province)){?>               
                    	<select id="province_id" name="province_id">
                        	<?php   foreach($province_arr as $val) {?>
							<option value='<?php echo $val["id"];?>' <?php if($province==$val["id"]){echo 'selected="selected"';} ?> ><?php echo $val["name"]; ?></option>
                            <?php }  ?>
                     	</select>
                    	<?php }?> 
                     
                    	<?php if(!empty($city)){?>               
                    	<select id="city_id" name="city_id">
                        	<?php  foreach($city_arr as $val) {?>
							<option value='<?php echo $val["id"];?>' <?php if($city==$val["id"]){echo 'selected="selected"';} ?>  ><?php echo $val["name"]; ?></option>
                            <?php }  ?>
                     	</select>
                     	<?php }?> 
                        
                    </td>
                </tr>
                <tr class="form_group">
                    <td class="form_title">供应商品牌介绍：</td>
                    <td><textarea placeholder="其他显示信息" class="form_textarea w_600 noresize" name="beizhu"><?php echo $beizhu; ?></textarea></td>
                </tr>
            </table>
            <div class="form_btn clear">
                <input type="button" name="submit" value="更新"  onclick="return checkForm(this)"  class="btn btn_blue" style="margin-left:360px;"/>
            </div>

		</form>
        </div>
	</div>
</div>
<script>
	function checkForm(o){
		   var obj=$("#userform");
		//   var phone= obj.mobile.value;
		//   var telephone=obj.telephone.value;
		//   var link_mobile=obj.link_mobile.value;
/*		   var linkman=obj.linkman.value;
		   var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
		   var res=/\d{3}-\d{8}|\d{4}-\d{7,8}/;
		   if(phone==''){
		    	alert("手机号码不能为空！");
			       return false;
			 }
			 
		   if(!myreg.test(phone))
		   {
		       alert('请输入有效的手机号码！');
		       return false;
		   } */
		 var linkman=$('input[name="linkman"]').val();	
		   if(linkman==''){
			     alert('联系人不能为空!');
			     return false;
		   }
/*		   if(link_mobile==''){
			 alert("联系人手机号码不能为空！");
		      	 return false;
		   }else{
			   if(!myreg.test(link_mobile)){
				alert('请输入联系人有效的手机号码！');
			       	return false;
			    }
		   }*/

		   //邮件验证
		    var email=$('input[name="linkemail"]').val();
		    var Regex = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/; 
		    if(email==''){
		    	alert("联系人邮件不能为空！");
			 return false;
		    }
		    if(!Regex.test(email))
		     {
			 alert("联系人邮件不合法");
			return false;
		     }  
		     //
	     	 jQuery.ajax({ type : "POST",data : jQuery('#userform').serialize(),url : "<?php echo base_url()?>admin/b1/user/update_userdata", 
                        
			success : function(response) {
	 			var response=eval("("+response+")");
				 if(response.status==1){  
				 	alert(response.msg); 
				 	 window.location.reload();	
					// priceDate.loadData();
					// $('.cal-manager').find('.package-tab').eq(0).click();  
				 }else{
				 	alert(response.msg); 
					// alert('日期价格插入表里出错,需要重新保存');
				 }
				 //刷新页面
				
			}
		  });
		   
	}

		$('select[name="country_id"]').change(function(){
			var country_id = $('select[name="country_id"] :selected').val();
			$('#province_id').remove();
			$('#city_id').remove();
			$('#region_id').remove();
			if (country_id == 0) {
				return false;
			}
			$.post(
				"<?php echo site_url('admin/b1/user/get_area')?>",
				{'id':country_id},
				function(data) {
					data = eval('('+data+')');
				//	$('#country_id').after("<select name='province_id' id='province_id'><option value='0'>请选择省份</option></select>");
					if(country_id==1){ //国际
					    $('#country_id').after("<select name='province_id' id='province_id'><option value='0'>请选择国家</option></select>");
					}else{   //中国
						  $('#country_id').after("<select name='province_id' id='province_id'><option value='0'>请选择省份</option></select>");
					}
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
				"<?php echo site_url('admin/b1/user/get_area')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					$('#province_id').after("<select name='city_id' id='city_id'><option value='0'>请选择城市</option></select>");
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
		
		$('#province_id').change(function(){
			var province_id = $('select[name="province_id"] :selected').val();
			province(province_id)
		})
			
		$('#city_id').change(function(){
				var city_id = $('select[name="city_id"] :selected').val();
				city(city_id)
		})	
 
</script>

