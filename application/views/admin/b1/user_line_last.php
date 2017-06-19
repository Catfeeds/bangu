<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
</style>
	<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">投诉维权</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<!-- Page Header -->
<!-- <div class="page-header position-relative">
	<div class="header-title">
		<h1>投诉维权</h1>
	</div>
</div> -->
<!-- /Page Header -->
 <div class="widget flat radius-bordered search_box">                                                
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li name="tabs" class="active"><a href="###" id="tab0">投诉维权 </a></li>
					
				</ul>
	<div class="tab-content tabs-flat">			
	<div id="registration-form" style="padding-top:10px !important;">
		<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
			data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
			data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
			data-bv-message="This value is not valid"
			class="form-horizontal bv-form" method="post" id="registrationForm"
			novalidate="novalidate">
			<div class="form-group has-feedback search" style="margin-left:0px">			
				<label class="col-lg-4 control-label" style="width:auto">投诉人：</label>
				<div class="col-lg-4 w_200" style="">
					<input type="text" name="truename"
						class="form-control user_name_b1">
				</div>
				<label class="col-lg-4 control-label" style="width:auto;">产品名称：</label>
				<div class="col-lg-4 w_200" style="">
					<input type="text" name="productname"
						class="form-control user_name_b1" >
				</div>
				<label class="col-lg-4 control-label" style="width:auto">处理状态：</label>
				<div class="col-lg-4" style="width:auto">
				    <div>
						<select data-bv-field="country" name="status">
							<option value="">未选择</option>
							<option value="0">未处理</option>
							<option value="1">已处理</option>
							
						</select>
					</div>
				</div>
				<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
				<div class="col-lg-4 w80" style="">
					<input type="button" value="搜索" class="btn btn-palegreen" id='searchBtn'>
				</div>
			</div>
		</form>
		
			<div id="user_line"></div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- 新询单价  回复的弹框-->
<div id="user_line_text" style="display: none;">
	
        <form action="<?php echo base_url();?>admin/b1/user_line/insert_replay" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="repalyForm" novalidate="novalidate"  onsubmit="return CheckeReply(this);" >
         <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right" style="float:left;">回复内容</label>
            <div class="col-sm-10" style="float:left; width:83%;">
           	 <input name="complain_id" value="" id="complain_id" type="hidden" />
                <textarea name="replay" style="resize:none;width:100%;height:120px" placeholder="100字以内"></textarea>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>
</div>
<!--弹框结束 -->
<script type="text/javascript">

jQuery('#user_line').on("click", 'a[name="reply"]',function(){
	var data=jQuery(this).attr('data');
	$("#complain_id").val(data);
    bootbox.dialog({
           message: $("#user_line_text").html(),
           title: "回复",
  	});
	
});
function CheckeReply(obj){
	var replay= obj.replay.value;
	if(replay==''){
		alert('不能为空');
		return false;
	}


}
</script>

<?php echo $this->load->view('admin/b1/common/line_script'); ?>