<style type="text/css">
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.messages_show{background-color:#fbfbfb}
	.messages_color{ background: #000;}
	#msg_title { padding:15px 20px;line-height:20px;text-align:center;}
	.layui-layer-page { top:150px !important;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">消息通知</li>
	</ul>
</div>

<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">	
				<li class="active" name="tabs"><a href="#home" data-toggle="tab" id="tab"> 
				平台公告<?php $mess=$this->session->userdata('mess');if(!empty($mess['sys'])){ echo '<span style="color:#FF0000" class="m_sys">('.$mess['sys'].')</span>';}else{ echo '<span style="color:#FF0000" class="m_sys" >(0)</span>';} ?></a></li>	
				<li class="" name="tabs0"><a href="#home0" data-toggle="tab" id="tab0"> 
				业务通知<?php $mess=$this->session->userdata('mess');if(!empty($mess['buniess'])){ echo '<span style="color:#FF0000" class="m_buniess">('.$mess['buniess'].')</span>';}else{ echo '<span style="color:#FF0000" class="m_buniess" >(0)</span>';} ?></a></li>	
				</ul>
				<div class="tab-content tabs-flat">	
					<!-- 平台公告 -->
					<div class="tab-pane active" id="home">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="registrationForm"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width: auto; float:left;padding-right:0;">标题：</label>
										<div class="col-lg-4 w_200" style="float:left">
											<input type="text" name="title"
												class="form-control user_name_b1">
										</div>
										<label class="col-lg-4 control-label" style="width: auto; float:left;padding-right:0;">发布时间：</label>
										<div class="col-lg-4 w_200" style="float:left">
										   <div>
												<select data-bv-field="country" name="addtime" style="clear:both;line-height:23px;">
													<option value="">未选择</option>
													<option value="1">近一个月</option>
													<option value="2">近二个月</option>
													<option value="3">近三个月</option>
												</select>
											</div>
										</div>
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="w80" style="float:left">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchfrom">
										</div>		
									</div>
								</form>
								<div id="list"></div>
							</div>
						</div>
					</div>
	              <!-- 业务通知 -->
				  	<div class="tab-pane" id="home0">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="registrationForm0"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style="width: auto; float:left;padding-right:0;">标题：</label>
										<div class="col-lg-4 w_200" style="float:left">
											<input type="text" name="title"
												class="form-control user_name_b1">
										</div>
										<label class="col-lg-4 control-label" style="width:auto;float:left;padding-right:0;">发布时间：</label>
										<div class="col-lg-4 w_200" style="float:left">
										   <div>
												<select data-bv-field="country" name="addtime" style="clear:both;line-height:23px;">
													<option value="">未选择</option>
													<option value="1">近一个月</option>
													<option value="2">近二个月</option>
													<option value="3">近三个月</option>
												</select>
											</div>
										</div>
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4 w80" style="float:left">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchfrom0">
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
<!-- 消息弹出框 -->
<div class="fb-content" id="messages_letter" style="display:none;">
    <div class="box-title">
        <h4>业务通知</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <div id="registration-form">
            <h4 id="msg_title">业务通知：</h4>
            <div class="form-group has-feedback clear" style="margin:0 20px;padding-bottom:5px;border-bottom:1px dashed #ccc;">
                <label class="col-lg-4 control-label" style="width: 45% !important;padding-left:0;" id="issue_addtime">发布时间：</label>
                <label class="col-lg-4 control-label" style="width: 45% !important;padding-left:0;" id="issue_people">发布人：</label>
            </div>
        </div>
		<div style="margin:10px 20px;text-indent:2em;min-height:80px;padding-bottom:20px;" id="issue_content">内容</div>

    </div>
</div>
<!-- 消息弹出框结束 -->
<?php echo $this->load->view('admin/b1/common/messages_script'); ?>					
					