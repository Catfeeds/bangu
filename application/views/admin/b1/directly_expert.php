<link href="<?php echo base_url('assets/ht/css/base.css'); ?>" rel="stylesheet" />
<style type="text/css">
	input { box-sizing:border-box;}
	.order_info_table { margin-top:0;}
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.registered_btn a{ padding:6px 10px;display:block; background: #2dc3e8;color: #fff; border-radius: 3px;  text-decoration: none}
	#myTab11{ margin-top: 20px;}
	.col-sm-4{top:7px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
	
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">直属管家</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable" style="padding-top:10px;">
			 <span class="registered_btn" style="display:inline-block;margin-bottom:10px;"><a target="_blank" href="/admin/b1/directly_expert/registered_expert">添加直属管家</a></span>
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
			    	<li class="active" name="tabs"><a href="#home1" data-toggle="tab" id="tab1"> 申请中 </a></li>  
					<li class="" name="tabs"><a href="#home2" data-toggle="tab" id="tab2"> 合作中 </a></li>
					<li class="" name="tabs"><a href="#home3" data-toggle="tab" id="tab3">已拒绝 </a></li>
					<li class="" name="tabs"><a href="#home4" data-toggle="tab" id="tab4"> 已终止 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 申请中  -->
					<div class="tab-pane active" id="home1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">专家姓名：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="realname" style="width:100px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">手机号：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" name="mobile" style="width:100px;">
										</div>	
										
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">所在地：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											<div id="select">
											  <select name="country" id="country" onchange="country_change(this);" style="width:80px;">
													<option value="">请选择</option>
													<?php
													if(!empty($country)){
														foreach ( $country as $val ) {
															echo "<option value='{$val['id']}'>{$val['name']}</option>";
														}
													 }
													?>
												</select>
											</div>
										</div>
						            	
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch">
										</div>
									</div>
								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 合作中  -->
					<div class="tab-pane " id="home2">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm1"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">专家姓名：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="realname" style="width:100px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">手机号：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" name="mobile" style="width:100px;">
										</div>	
										
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">所在地：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											<div id="select">
							 					<select name="country" id="country" onchange="country_change(this);" style="width:80px;">
													<option value="">请选择</option>
													<?php
													if(!empty($country)){
														foreach ( $country as $val ) {
															echo "<option value='{$val['id']}'>{$val['name']}</option>";
														}
													 }
													?>
												</select>
											</div>
										</div>
						            
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch1">
										</div>
									</div>
								</form>

								<div id="list1"></div>
							</div>
						</div>
					</div>
					<!-- 已拒绝 -->
					<div class="tab-pane " id="home3">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm2"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">专家姓名：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="realname" style="width:100px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">手机号：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" name="mobile" style="width:100px;">
										</div>	
										
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">所在地：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											<div id="select">
												 <select name="country" id="country" onchange="country_change(this);" style="width:80px;">
													<option value="">请选择</option>
													<?php
													if(!empty($country)){
														foreach ( $country as $val ) {
															echo "<option value='{$val['id']}'>{$val['name']}</option>";
														}
													 }
													?>
												</select>
											</div>
										</div>
						            	
										<label class="col-lg-4 control-label"style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch2">
										</div>
									</div>
								</form>

								<div id="list2"></div>
							</div>
						</div>
					</div>
					<!-- 已终止  -->
					<div class="tab-pane " id="home4">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm3"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">专家姓名：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="realname" style="width:100px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">手机号：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" name="mobile" style="width:100px;">
										</div>	
										
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">所在地：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											<div id="select">
												 <select name="country" id="country" onchange="country_change(this);" style="width:80px;">
													<option value="">请选择</option>
													<?php
													if(!empty($country)){
														foreach ( $country as $val ) {
															echo "<option value='{$val['id']}'>{$val['name']}</option>";
														}
													 }
													?>
												</select>
											</div>
										</div>
						            
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch3">
										</div>
									</div>
								</form>

								<div id="list3"></div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 查看 -->
<div class="lookexpert modal fade in" style="display:none;">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:800px;height:500px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">管家详情</h4>
			    </div>
			    <div class="modal-body" style="height:450px;overflow-y:auto;overflow-x:hidden;">
                	<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                        <tbody>
                            <tr height="40">
                                <td class="order_info_title">昵称:</td>
                                <td class="nickname"></td>
                                <td class="order_info_title">头像:</td>
                                <td class="big_photo"></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">真实姓名:</td>
                                <td class="realname"></td>
                                <td class="order_info_title">性别:</td>
                                <td class="sex"></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">电子邮件:</td>
                                <td class="email"></td>
                                <td class="order_info_title">微信号:</td>
                                <td class="weixin"></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">所属城市:</td>
                                <td class="address"></td>
                                <td class="order_info_title">擅长线路:</td>
                                <td class="dest"></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">身份证号:</td>
                                <td class="idcard"></td>
                                <td class="order_info_title">个人描述:</td>
                                <td class="talk"></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">身份证扫描件:</td>
                                <td colspan="3" class="idcardpic"></td>
                            </tr>
                        </tbody>
                    </table>
			        <div class="form-group" style="margin-top:20px;">
			             <div class="resume_nav" style="width:100%;display:none;">
	                        <table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer" style="100%">
							<thead>
							      <tr role="row">
									 <th style="width:80px;text-align:center">起止时间 </th>
									 <th style="width: 100px;text-align:center">所在企业</th>
									 <th style="width: 100px;text-align:center">职务 </th>
									 <th style="width: 100px;text-align:center">工作描述</th>
									 
								 </tr>
							</thead>
							<tbody class="train_table job_table">
																			   
							</tbody>
						</table>
	                    </div>
			        </div>
			        <div class="form-group" style="margin-top:20px;">
			             <div class="certificate_nav" style="width:100%;display:none;">
	                        <table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer" style="100%">
							<thead>
							      <tr role="row">
									 <th style="width:150px;text-align:center">证书名称 </th>
									 <th style="width: 150px;text-align:center">证书扫描件</th>
								 </tr>
							</thead>
							<tbody class="train_table certificate_table">
																			   
							</tbody>
						</table>
	                    </div>
			        </div>

                 </div>
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>




<?php echo $this->load->view('admin/b1/common/directly_expert_script'); ?>

<script type="text/javascript">
//查看管家信息
function look_div(id){
	$('.job_table').html('');
	$('.certificate_table').html('');
	//var id=$(this).attr('data');
	$.post("/admin/b1/directly_expert/get_expert",{'id':id},function(json){
		var data = eval("("+json+")");
		if (data.status == 1) {
			if(data.expert!=''){
				if(data.expert.sex==1){
					var sex='男';
			    }else{
			    	var sex='女';
				}
				$('.nickname').html(data.expert.nickname);
				$('.realname').html(data.expert.realname);
				$('.big_photo').html('<img style="width:50px; height:50px;"src="'+data.expert.big_photo+'">');
				$('.sex').html(sex);
				$('.email').html(data.expert.email);
				$('.weixin').html(data.expert.weixin);
				$('.address').html(data.expert.country1+data.expert.province1+data.expert.city1);
				$('.idcard').html(data.expert.idcard);
				$('.idcardpic').html('<img style="width:175px; height:100px;"src="'+data.expert.idcardpic+'">');
				$('.talk').html(data.expert.talk);
			}
			if(data.dest!=''){
				var dest='';
			    $.each(data.dest, function(i, val){
					 dest=dest+val.name+'&nbsp';
					 $('.dest').html(dest);		
				})
			}
			
			//从业经历
			if(data.expert_resume!=''){
				$('.resume_nav').show();
				var html='';
				 $.each(data.expert_resume, function(k, v){		
					html=html+'<tr class="train_len">';
					html=html+'<td style="text-align:center">'+v.starttime+'至'+v.endtime+'</td>';
					html=html+'<td style="text-align:center">'+v.company_name+'</td>';
					html=html+'<td style="text-align:center">'+v.job+'</td>';
					html=html+'<td style="text-align:center">'+v.description+'</td>';
					html=html+'</tr>';
					$('.job_table').append(html);
				 })
			}
			//荣誉证书
			
			if(data.expert_certificate!=''){
				$('.certificate_nav').show();
				var html='';
				 $.each(data.expert_certificate, function(k, v){		
					html=html+'<tr >';
					html=html+'<td style="text-align:center">'+v.certificate+'</td>';
					html=html+'<td style="text-align:center"><img style="width:50px;height:50px;" src="'+v.certificatepic+'"></td>';
					html=html+'</tr>';
					$('.certificate_table').append(html);
				 })
			}
				
		} else {
			alert(data.msg);
		}  
	})
	$('.lookexpert').show();
}
$('.bootbox-close-button').click(function(){
	$('.lookexpert ').hide();
});

//终止合作
function stop_cooperation(id){
	 if (!confirm("确定要终止合作？")) {
         window.event.returnValue = false;
     }else{
     	 $.post("/admin/b1/directly_expert/update_expert_status",{'id':id},function(json){
     		  var data = eval("("+json+")");
     		 alert(data.msg);
     		  $('#tab2').click();
          })
     }
}

//国家变动1
function country_change(obj) {
	var country_id = $(obj).val();
	if ($(obj).next('#province_id').length == 0) {
		$(obj).after("<select name='province_id' id='province_id' style='width:140px;' onchange='province_change(this);'></select>");
	}
	$('#province_id').html("<option value=''>请选择</option>");
	$('#province_id').nextAll('select').remove();
	if (country_id == 0) {
		$(obj).nextAll('select').remove();
		return false;
	}
	$.post("/admin/b1/directly_expert/get_area_json",{id:country_id},function(data){
		if (data == false) {
			return false;
		}
		var data = eval('('+data+')');
		$.each(data ,function (key ,val){
			var html = "<option value='"+val.id+"'>"+val.name+"</option>";
			$('#province_id').append(html);
		})
	})
}
//省份变动
function province_change(obj) {
	var province_id = $(obj).val();
	if (province_id == 0) {
		$(obj).nextAll('select').remove();
		return false;
	}
	$.post("/admin/b1/directly_expert/get_area_json",{id:province_id},function(data){
		if (data == false) {
			$(obj).nextAll('select').remove();
			return false;
		}
		if ($(obj).next('#city_id').length == 0) {
			$(obj).after("<select name='city_id' id='city_id' style='width:140px;' onchange='city_change(this);'></select>");
		}
		$('#city_id').html("<option value=''>请选择</option>");
		$('#city_id').nextAll('select').remove();
		var data = eval('('+data+')');
		$.each(data ,function (key ,val){
			var html = "<option value='"+val.id+"'>"+val.name+"</option>";
			$('#city_id').append(html);
		})
	})
}
//城市变动
// function city_change(obj) {
// 	var city_id = $(obj).val();
// 	if (city_id == 0) {
// 		$(obj).next('select').remove();
// 		return false;
// 	}
// 	$.post("/admin/a/comboBox/get_area_json",{id:city_id},function(data){
// 		if (data == false) {
// 			$(obj).next('select').remove();
// 			return false;
// 		}
// 		if ($(obj).next('#region_id').length == 0) {
// 			$(obj).after("<select name='region_id' id='region_id' style='width:140px;' ></select>");
// 		}
// 		$('#region_id').html("<option value='0'>请选择</option>");
// 		var data = eval('('+data+')');
// 		$.each(data ,function (key ,val){
// 			var html = "<option value='"+val.id+"'>"+val.name+"</option>";
// 			$('#region_id').append(html);
// 		})
// 	})
// }

function checkorder(){
	var type='<?php if(!empty($type)){ echo $type;} ?>';
	if(type !=''){
		if(type==2){ //待确认订单
			$('#tab2').click();
		}
	 }

}

jQuery(document).ready(function(){	
	　checkorder();　 
});
</script>
