<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
	.page-content { min-width: 840px !important;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">线路游记</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs"><a href="#home11" data-toggle="tab"
						id="tab0"> 最新游记</a></li>
					<li class="" name="tabs"><a href="#profile11" data-toggle="tab"
						id="tab1"> 历史游记 </a></li>
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
										<label class="col-lg-4 control-label" style="width:auto">游记标题：</label>
										<div class="col-lg-4" style="width:160px;">
											<input type="text" name="line_name" class="form-control user_name_b1"> 
										</div>
										<label class="col-lg-4 control-label" style="width:auto">发布时间：</label>
										<div class="col-lg-4" style="width:210px;">
										 	<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  class="form-control"
													id="reservation" name="time" style="width:180px;">
											</div> 	
										</div>
	
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
										</div>
									</div>
								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 未结算弹出框 -->
					<div style="display: none;" class="tbtsd">
						<div class="closetd" style="opacity: 0.2; padding:0 0 0 8px;font-size: 20px; font-weight: 800;">×</div>
						<div align="center" style="height:100%;">
							<div class="widget-body" style="height:100%;">
								<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
			
								</div>
							</div>
						</div>
					</div>
					<div class="bgsd" style="display: none;"></div>
					<!-- 未结算弹出框结束 -->
					<!-- 已结算 -->
					<div class="tab-pane" id="tab_content1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="list1Form"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width:auto">游记标题：</label>
										<div class="col-lg-4" style="width:160px">
											<input type="text" name="line_name" class="form-control user_name_b1"> 
										</div>
										<label class="col-lg-4 control-label" style="width:auto">发布时间：</label>
										<div class="col-lg-4" style="width:210px;">
										 	<div class="input-group">
												<span class="input-group-addon"> <i class="fa fa-calendar">
												</i>
												</span> <input type="text"  class="form-control"
													id="reservation0" name="time" style="width:180px;">
											</div> 	
										</div>
								
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" class="btn btn-palegreen " id="searchBtn1">
										</div>
									</div>
								</form>
								<div id="list1"></div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- 申请弹框-->
<div id="reply_text" style="display: none;">  
    <form action="<?php echo base_url()?>admin/b1/travel_notes/replay" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="apply" novalidate="novalidate"onsubmit="return add_replay(this);" >
         <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">申诉内容</label>
            <div class="col-sm-10">
            <input type="hidden" value="" name="travel_note_id">
            <input type="hidden" value="" name="member">        
                <textarea name="reason" id="reason" style="resize:none;width:100%;height:120px">
                </textarea>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>
</div>
<!--弹框结束 -->
<?php echo $this->load->view('admin/b1/common/travel_notes_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>
<script type="text/javascript">
jQuery('#list').on("click", 'a[name="replay_data"]',function(){
  //$("#reply_text").html('<div id="reply_scheme_data"></div>');
  var id = jQuery(this).attr('data');
  var member=jQuery(this).attr('member');
  $('input[name="travel_note_id"]').val(id);
  $('input[name="member"]').val(member);
	bootbox.dialog({
        message: $("#reply_text").html(),
        title: "申述内容",
        className: "reply_scheme_text"
 	}); 
});

//提交申请
function add_replay(obj){
 //   var reason=$("#reason").val(); 
    var reason_data= obj.reason.value;
    if(obj.reason.value ==''){
    	alert('申述内容不能为空！'); 
    	return false;
	 }
}

</script>




