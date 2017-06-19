<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
	.form-group label{ float: left; width: 100px;}
	.col-lg-4{float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.widget-body {padding: 12px}
	.fg_div{ float: left; margin-top: 2px;}
	.table thead th {
	text-align: center;
	}
	
	.table tbody td {
		text-align: center;
	}
	
	.eject_list_name {
		width: 25%;
		text-align: right;
	}
	
	.content_info {
		margin-left: 0px;
	}
	.col-sm-8{width:30%;}
	.eject_list_row {
		padding-left: 0px;
	}
	.eidt_div{top:10px;}
	#form_data_submit label{width:20%;text-align:right;float:left;}
	#form_data_submit .col-sm-8{width:80%;float:left;}
	.form-control{display:inline}
	
	#upfile { width: 200px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
</style>	
	<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">订单管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

	<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs" id=""><a href="#home0" data-toggle="tab" id="tab0"> 已保存 </a></li>
					<li class="" name="tabs" id="clicktab0"><a href="#home1" data-toggle="tab" id="tab1"> 已发布 </a></li>
					<li class="" name="tabs" id="clicktab1"><a href="#home2" data-toggle="tab" id="tab2"> 已取消 </a></li>	
							
				</ul>
				<div class="tab-content tabs-flat">
				<!-- 已保存 -->
					<div class="tab-pane active" id="home0">
				         <input name="tab" type="hidden" value="tab0">
						<div class="widget-body">
							<div id="registration-form">
								<div class="table-toolbar" style="padding:4px 0">
								  <a class="btn btn-default" onclick="popLayer();" href="javascript:void(0);"> 添加 </a>
								</div>
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="searchForm0" novalidate="novalidate">
									<div class="form-group has-feedback">
										<div class="fg_div" ><label class="col-lg-4 control-label" >主题：</label>
										<div class="col-lg-4" style="width: 200px;">
											<input type="text" name="op_title"
												class="form-control user_name_b1">
										</div></div>									
										<div class="col-lg-4 fg_div" style="width: 70px">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn0">
										</div>
									</div>
								
								</form>
								
								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 已发布 -->
					<div class="tab-pane" id="home1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form"
									id="searchForm1" novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label">主题：</label>
										<div class="col-lg-4" style="width: 12%;">
											<input type="text" name="op_title"
												class="form-control user_name_b1">
										</div>																		
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn1">
										</div>

									</div>
								</form>
								<div id="list1"></div>
							</div>
						</div>
					</div>
					<!-- 已取消 -->
					<div class="tab-pane" id="home2">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post"
									id="searchForm2" novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label" style=>主题：</label>
										<div class="col-lg-4" style="width: 12%;">
											<input type="text" name="op_title"
												class="form-control user_name_b1">
										</div>

										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="searchBtn2">
										</div>		
									</div>
								</form>
						<div id="list2"></div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button bc_close close"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">添加培训公告</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="form_data_submit" method="post" action="#">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>主题</label>
									<div class="col-sm-8">
										<input type="text" name="title" id='title' placeholder="主题" class="form-control content_required">
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>培训时长</label>
									<div class="col-sm-8" >
										<input type="text" style="width:190px;" name="spend" placeholder="培训时长(分钟为单位)" class="form-control pi_required" >
										<span>分钟</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>培训地点</label>
									<div class="col-sm-8">
										<input type="text" name="address" placeholder="培训地点(汉字、字母、数字)" class="form-control cln_required">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>报名开始时间</label>
									<div class="col-sm-8">
										<!-- <input type="text" class="form-control content_required" name="begintime" id="opp_begintime" readonly placeholder="报名开始时间"> -->
											<div class="input-group" style="width:190px;">
											<input class="form-control date-picker" id="begintime"  readonly name="begintime"
												type="text" data-date-format="yyyy-mm-dd"> <span
												class="input-group-addon"> <i class="fa fa-calendar"></i>
											</span>
										   </div>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>报名截止时间</label>
									<div class="col-sm-8">
										<!-- <input type="text" name="endtime" id="opp_endtime" class="form-control content_required"  readonly placeholder="截止报名时间" > -->
											<div class="input-group" style="width:190px;">
											<input class="form-control date-picker" id="endtime" readonly name="endtime"
												type="text" data-date-format="yyyy-mm-dd"> <span
												class="input-group-addon"> <i class="fa fa-calendar"></i>
											</span>
										   </div>	
								    </div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>培训开始时间</label>
									<div class="col-sm-8">
											<div class="input-group" style="width:190px;">
											<input class="form-control date-picker" id="starttime"  readonly name="starttime"
												type="text" data-date-format="yyyy-mm-dd"> <span
												class="input-group-addon"> <i class="fa fa-calendar"></i>
											</span>
										   </div>	
										</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>容纳人数</label>
									<div class="col-sm-8">
										<input type="text" name="people" style="width:190px;" placeholder="容纳人数" class="form-control pi_required" >
										<span>人</span>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>主办方</label>
									<div class="col-sm-8">
										<input type="text" name="sponsor" placeholder="主办方" class="form-control content_required" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color: red;">*</span>内容</label>
									<div class="col-sm-8">
										<textarea class="form-control content_required" rows="3" name='content' placeholder="内容"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">说明<span class="input-span"></span></label>
									<div class="col-sm-8">
										<textarea class="form-control" rows="3" name='description' placeholder="说  明"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">上传附件<span class="input-span"></span></label>
									<div class="col-sm-8">
										<input id="upfile" type="file" name="upfile" value="10M(doc|txt|xls|docx)" />
										<button id="upload_file">上传文件</button>
										10M(doc|txt|docx) <input type="hidden" name="attachment" />
									</div>
								</div>
								<div class="form-group">
									<div></div>
									<input type='hidden' value='' name='is'>
									<input type="hidden" value="" name="id">
									<div  onclick="submit_opp(1);" class="btn btn-default opp_srelease" style="left:50%;">保存</div>
									<div  onclick="submit_opp(2);"  class="btn btn-default opp_srelease" style="left:60%;">保存并发布</div>
								   <div  onclick="submit_opp(3);" class="btn btn-default opp_eidt" style="left:50%;">保存</div> 
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<!-- 培训公告详情 -->	
<div class="modal-backdrop fade in eject_body" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="eject_body  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content" style="width:735px">			
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close eject_colse"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title eject_title">培训公告详情</h4>
				</div>		

			<div class="modal-body">
			<div class="bootbox-body">
			<form class="form-horizontal" role="form" id="" method="post" action="#">
				<div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">主办方:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_sponsor"></div>
						</div>
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">培训主题:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_title"></div>
						</div>
			    </div>
			    <div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">容纳人数:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_people"></div>
						</div>
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">报名人数:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_apply"></div>
						</div>
			    </div>
			    <div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">公告状态:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_status"></div>
						</div>
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">培训地点:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_address"></div>
						</div>
			    </div>
			     <div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">开始报名时间:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_addtime"></div>
						</div>
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">截止报名时间:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_endtime"></div>
						</div>
			    </div>
			   <div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">培训开始时间:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_starttime"></div>
						</div>
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">培训时长:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_spend"></div>
						</div>
			    </div>
			    <div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">发布者类型:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_publisher_type"></div>
						</div>
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">发布者:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_publisher_name"></div>
						</div>
			    </div>
			     <div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">附件:</label>
						<div class="col-sm-8 eidt_div">
							<div class="content_info opp_attachment">查看</div>
						</div>

			    </div>
 				<div class="form-group">
						<label for="inputEmail3"
							class="col-sm-3 control-label no-padding-right" style="width:105px;">公告内容:</label>
						<div class="col-sm-8 eidt_div">
							<div class="eject_text_info">
								<textarea rows="5" cols="50" class="opp_content" disabled></textarea>
							</div>
						</div>
			    </div>
			    <input type="hidden" name="status" value="0">
    		  <div class="form-group eject_botton">
							<input type="hidden" name="opp_id" />
				<div class="opp_colse btn btn-default" style="left:38%;">关闭</div>
				<div class="opp_release btn btn-default" style="left:48%;">发布</div>
				<div class="opp_cancel btn btn-default" style="left:48%;">取消发布</div>
				<div class="opp_delete btn btn-default" style="left:48%;">确认删除</div>
			</div>

			</form>
			</div>
			
		</div>
		</div>
	</div>
</div>
<?php echo $this->load->view('admin/b1/common/opportunity_script'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
//添加培训公告的弹出层
function popLayer() {
	$('.bootbox').show();
	$('.modal-backdrop,.opp_srelease').show();
	$('.opp_eidt').css('display','none');
	$("#form_data_submit").find('input,textarea').val('');
	$('.input_cx_data').css({'width':'270px','height':'35px'});
};
$('.opp_colse,.bc_close').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();
	$('.bootbox').hide();
	
})
 // 添加培训公告，提交表单
function submit_opp(is) {
	var id=$('input[name="is"]').val(is);
	var tab=$('input[name="tab"]').val();
	$.post("/admin/b1/opportunity/add_opportunity",$('#form_data_submit').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {		
			alert(data.msg);
			 $('#'+tab).click();
			$('.bc_close').click();
			//location.reload();
		} else {
			alert(data.msg);
		}
	});
	return false;
}
/**********************时间插件*************************/
  $('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
  $('#endtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
  $('#begintime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
//上传附件
  $('#upload_file').on('click', function() { 

  	$.ajaxFileUpload({  
  		url:'/admin/b1/opportunity/up_file',  
  		secureuri:false,  
  		fileElementId:'upfile',// file标签的id
  		dataType: 'json',// 返回数据的类型
  		data:{filename:'upfile'},
  		success: function (data, status) {  
  			if (data.code == 200) {
  				$('input[name="attachment"]').val(data.url);
  				alert("上传成功");
  			} else {
  			 	alert(data.msg);
  			}
  		},  
  		error: function (data, status, e) {  
  		 	alert("请选择不超过10M的doc|txt|xls|docx的文件上传");  
  		}  
  	});  
   	return false;
  });

//培训公告详情
  function details(id ,is) {
  	$.post("/admin/b1/opportunity/get_opp_data",{'id':id},function(data) {
  		if (data == false) {
  			alert("请确认您选择的数据是否正确");
  			return false;
  		}
  		var data = eval('('+data+')');		
  		$('.opp_sponsor').html(data.sponsor);
  		$('.opp_title').html(data.title);
  		$('.opp_people').html(data.people);
  		$('.opp_apply').html(data.apply_count);
  		$('.opp_status').html(data.sname);
  		$('.opp_address').html(data.address);
  		$('.opp_starttime').html(data.starttime);
  		$('.opp_endtime').html(data.endtime);
  		$('.opp_publisher_type').html(data.publisher_type);
  		$('.opp_publisher_name').html(data.publisher_name);
  		$('.opp_content').html(data.content);
  		$('.opp_description').html(data.description);
  		$('input[name="opp_id"]').val(data.id);
  		$('.opp_addtime').html(data.begintime);
  		$('.opp_spend').html(data.spend+'分钟');
  		if (typeof data.attachment == 'string' && data.attachment.length > 0) {
  			var attachment = '<a href="'+data.attachment+'">查看</a>';
  		} else {
  			var attachment = '暂无附件';
  		}
  		if (is == 1) {
  			$(".eject_botton").find('.opp_colse').nextAll('div').hide();
  		} else if (is == 2) {
  			$('.opp_release').show();
  			$('.opp_cancel,.opp_delete').hide();
  		} else if (is == 3) {
  			$('.opp_delete').show();
  			$('.opp_cancel,.opp_release').hide();
  		} else if (is == 4) {
  			$('.opp_cancel').show();
  			$('.opp_delete,.opp_release').hide();
  		}
  		$('.opp_attachment').html(attachment);
  		$('.eject_body').show();
  		$('.modal-backdrop').show();
  	})
  	
  }
  //关闭详情
  $('.opp_colse').click(function(){
  	$('.eject_body').hide();
  	$('.modal-backdrop').hide();
  })
  //编辑弹出
function show_details(id) {
	$.post("/admin/b1/opportunity/get_opp_data",{'id':id},function(data) {
		if (data == false) {
			alert('请确认您选择的数据');
			return false;
		}
		var data = eval('('+data+')');
		$('input[name="title"]').val(data.title);
		$('input[name="spend"]').val(data.spend);
		$('input[name="address"]').val(data.address);
		$('input[name="begintime"]').val(data.begintime);
		$('input[name="endtime"]').val(data.endtime);
		$('input[name="starttime"]').val(data.starttime);
		$('input[name="people"]').val(data.people);
		$('input[name="sponsor"]').val(data.sponsor);
		$('input[name="attachment"]').val(data.attachment);
		$('textarea[name="content"]').val(data.content);
		$('textarea[name="description"]').val(data.description);
		$('input[name="id"]').val(id);
		$('.opp_srelease').css('display','none');
		$('.bootbox').show();
		$('.modal-backdrop,.opp_eidt').show();
		
	})
}
//发布公告
  $('.opp_release').click(function(){
  	var id = $('input[name="opp_id"]').val();
	var tab=$('input[name="tab"]').val();
  	$.post("/admin/b1/opportunity/release",{'id':id},function(data){
  		var data = eval('('+data+')');
  		if (data.code == 2000) {
  			alert(data.msg);
  			$('#'+tab).click();
  			$('.modal-backdrop,.eject_body').hide();
  		} else {
  			alert(data.msg);
  		}
  	});
  })
  //取消公告
$('.opp_cancel').click(function(){
	var id = $('input[name="opp_id"]').val();
	var tab=$('input[name="tab"]').val();
	$.post("/admin/b1/opportunity/cancel",{'id':id},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			$('#'+tab).click();
			$('.modal-backdrop,.eject_body').hide();
		} else {
			alert(data.msg);
		}
	});
})
//删除公告
$('.opp_delete').click(function(){
	var id = $('input[name="opp_id"]').val();
	var tab=$('input[name="tab"]').val();
	$.post("/admin/b1/opportunity/delete",{'id':id},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
		    $('#'+tab).click();
			$('.modal-backdrop,.eject_body').hide();
		} else {
			alert(data.msg);
		}
	});
})
</script>


