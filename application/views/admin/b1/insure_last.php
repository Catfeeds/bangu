<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="#">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">保险管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs"><a href="#home11" data-toggle="tab"
						id="tab0">保险管理 </a></li>
					<!--  <li class="" name="tabs"><a href="#profile11" data-toggle="tab"
						id="tab1"> 已申请 </a></li>-->
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 未结算 -->
					<div class="tab-pane active" id="tab_content0">
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
										<div style="margin: 10px 0px 0px 12px;">
											   <input id="addinsure" class="btn btn-palegreen" type="button" onclick="add_insure()" value="新增保险">
									    </div>
									</div>
								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ---------新增保险---------- -->
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">新增保险</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="form_data_submit" method="post" action="#">				
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险名称</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_name" placeholder="保险名称" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险公司</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_company" placeholder="保险公司" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险期限</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="insurance_date"  placeholder="保险期限">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>售价</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_price"  class="form-control"   placeholder="售价" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>说明</label>
									<div class="col-sm-8">
										<textarea class="form-control content_required" rows="4" name='description' id="description" placeholder="说明"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">简要介绍</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="4" name='simple_explain' placeholder="简要介绍"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="4" name='insurance_clause' placeholder="保险条款"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div></div>
									<div  onclick="submit_addinsure();" class="btn btn-default" style="left:55%;">保存</div>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<!-- ---------编辑保险---------- -->
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="editbootbox  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">新增保险</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="form_editdata_submit" method="post" action="#">				
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险名称</label>
									<div class="col-sm-8">
										<input type="text" name="edit_insurance_name" placeholder="保险名称" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险公司</label>
									<div class="col-sm-8">
										<input type="text" name="edit_insurance_company" placeholder="保险公司" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险期限</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="edit_insurance_date"  placeholder="保险期限">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>售价</label>
									<div class="col-sm-8">
										<input type="text" name="edit_insurance_price"  class="form-control"   placeholder="售价" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>说明</label>
									<div class="col-sm-8">
										<textarea class="form-control content_required" rows="4" name='edit_description' id="edit_description" placeholder="说明"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">简要介绍</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="4" name='edit_simple_explain' id="edit_simple_explain" placeholder="简要介绍"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="4" name='edit_insurance_clause' id="edit_insurance_clause" placeholder="保险条款"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div></div>
									<input type="hidden" name="insure_id" id="insure_id" value=""/>
									<div  onclick="submit_editInsure();" class="btn btn-default opp_eidt" style="left:55%;">保存</div>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
function add_insure(){
    $('.opp_srelease').css('display','none');
	$('.bootbox').show();
	$('.modal-backdrop,.opp_eidt').show();
}
//关闭弹框
$('.opp_colse').click(function(){
	$('.bootbox,.editbootbox').hide();
	$('.modal-backdrop').hide();
})
//新增保险
function submit_addinsure(){
	var insurance_name =$('input[name="insurance_name"]').val();
	var insurance_company=$('input[name="insurance_company"]').val();
	var insurance_date=$('input[name="insurance_date"]').val();
	var insurance_price=$('input[name="insurance_price"]').val();
	var description=$('#description').val();
	
	if(insurance_name==''){
		alert('保险名称不能为空!');
		return false;
	}
	if(insurance_company==''){
		alert('保险公司不能为空!');
		return false;
	}
	if(insurance_date==''){
		alert('保险期限不能为空!');
		return false;
	}
	if(insurance_price==''){
		alert('售价不能为空!');
		return false;
	}
	if(description==''){
		alert('说明不能为空!');
		return false;
	}

	$.post("/admin/b1/insure/addInsure",$('#form_data_submit').serialize(),function(data) {
 		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
			location.reload();
		} 
	});
	return false;
}
//编辑保险的弹框
function edit_insure(id){
    $('input[name="insure_id"]').val(id);
    $.post("/admin/b1/insure/sel_insure",{'id':id},function(re) {
    	var re = eval('('+re+')');
		if (re.status == 1) {
			$('input[name="edit_insurance_name"]').val(re.data.insurance_name);
			$('input[name="edit_insurance_company"]').val(re.data.insurance_company);
			$('input[name="edit_insurance_date"]').val(re.data.insurance_date);
			$('input[name="edit_insurance_price"]').val(re.data.insurance_price);
			$('#edit_simple_explain').val(re.data.simple_explain);
			$('#edit_description').val(re.data.description);
			$('#edit_insurance_clause').val(re.data.insurance_clause);
		} else {
			alert(data.msg);
		} 
    });
	$('.editbootbox').show();
	$('.modal-backdrop,.opp_eidt').show();
}
//保存编辑
function submit_editInsure(){
	var insurance_name =$('input[name="edit_insurance_name"]').val();
	var insurance_company=$('input[name="edit_insurance_company"]').val();
	var insurance_date=$('input[name="edit_insurance_date"]').val();
	var insurance_price=$('input[name="edit_insurance_price"]').val();
	var description=$('#edit_description').val();
	
	if(insurance_name==''){
		alert('保险名称不能为空!');
		return false;
	}
	if(insurance_company==''){
		alert('保险公司不能为空!');
		return false;
	}
	if(insurance_date==''){
		alert('保险期限不能为空!');
		return false;
	}
	if(insurance_price==''){
		alert('售价不能为空!');
		return false;
	}
	if(description==''){
		alert('说明不能为空!');
		return false;
	}
	$.post("/admin/b1/insure/editInsure",$('#form_editdata_submit').serialize(),function(data) {
 		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
			location.reload();
		} 
	});
	return false;
}
//删除
function del_insure(id){
	 if (!confirm("确定要删除？")) {
         window.event.returnValue = false;
     }else{
	    $.post("/admin/b1/insure/del_insure",{'id':id},function(data) {
	 		var data = eval('('+data+')');
			if (data.status == 1) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
				location.reload();
			} 
		});
     }
	return false;
}
$(document).on('mouseover', '.hide_info3', function(){
	$(this).next().find(".hide_info").show();
});
$(document).on('mouseout', '.hide_info3', function(){
	$(this).next().find(".hide_info").hide();
});
</script>
<?php echo $this->load->view('admin/b1/common/insure_script'); ?>
