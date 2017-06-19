<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
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
	margin-left: 22px;
}

.eject_list_row {
	padding-left: 0px;
}
#form_data_submit label{width:20%;text-align:right;float:left;}
#form_data_submit .col-sm-8{width:80%;float:left;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i>
			 <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">培训公告</li>
		</ul>
	</div>
	<div class="page-body">
		<!-- <div class="widget-body"> -->
			<div class="table-toolbar">
				<a href="javascript:void(0);" class="btn btn-default"
					onclick="popLayer();"> 添加 </a>
			</div>
			<ul class="nav nav-tabs">
				<li class="active" status="0"><a>已保存</a></li>
				<li class="tab-red" status="1"><a>已发布</a></li>
				<li class="tab-blue" status="2"><a>已取消</a></li>
			</ul>
			<div class="tab-content">
			<form class="form-inline" id="search_condition" action="<?php echo site_url("admin/a/opportunity/get_opportunity_data")?>"
				method="post" style="margin-bottom: 15px;">
				<div class="form-group dataTables_filter"
					style="float: left; margin-right: 20px;">
					<input type="text" class="form-control" name='title'
						placeholder="主题">
				</div>
				<input type="hidden" name="page_new" value="1">
				<input type="hidden" name="status" value="0">
				<button type="submit" class="btn btn-darkorange">搜索</button>
			</form>
			<div role="grid" id="editabledatatable_wrapper"
				class="dataTables_wrapper form-inline no-footer">
				<table
					class="table table-striped table-hover table-bordered dataTable no-footer"
					aria-describedby="editabledatatable_info">
					<thead class="pagination_title"></thead>

					<tbody class="pagination_data"></tbody>
				</table>

			</div>
			<br />
			<div class="pagination"></div>
			</div>
		<!-- </div> -->

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
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">主题<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="title" id='title' placeholder="主题" class="form-control content_required">
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">培训时长<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="spend" placeholder="培训时长(分钟为单位)" class="form-control pi_required" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">培训地点<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="address" placeholder="培训地点(汉字、字母、数字)" class="form-control cln_required">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">报名开始时间<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control content_required" name="begintime" id="opp_begintime" readonly placeholder="报名开始时间">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">报名截止时间<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="endtime" id="opp_endtime" class="form-control content_required"  readonly placeholder="截止报名时间" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">培训开始时间<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control content_required" name="starttime" id="opp_starttime" readonly placeholder="培训开始时间" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">容纳人数<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="people" placeholder="容纳人数" class="form-control pi_required" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right">主办方<span class="input-must">*</span></label>
									<div class="col-sm-8">
										<input type="text" name="sponsor" placeholder="主办方" class="form-control content_required" >
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">内容<span class="input-must">*</span></label>
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
										<button id="upload_file">上传</button>
										10M(doc|txt|xls|docx) <input type="hidden" name="attachment" />
									</div>
								</div>
								<div class="form-group">
									<div></div>
									<input type='hidden' value='' name='is'>
									<input type="hidden" value="" name="id">
									<div  onclick="submit_opp(1);" class="btn btn-default opp_srelease" style="left:55%;">保存</div>
									<div  onclick="submit_opp(2);"  class="btn btn-default opp_srelease" style="left:65%;">保存并发布</div>
									<div  onclick="submit_opp(3);" class="btn btn-default opp_eidt" style="left:55%;">保存</div>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>


<div class="modal-backdrop fade in" style="display: none;"></div>
<!-- 培训公告详情 -->
<div class="eject_body">
	<div class="eject_colse opp_colse">X</div>
	<div class="eject_title">培训公告详情</div>
	<div class="eject_content">
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">主办方:</div>
				<div class="content_info opp_sponsor"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">培训主题:</div>
				<div class="content_info opp_title"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">容纳人数:</div>
				<div class="content_info opp_people"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">报名人数:</div>
				<div class="content_info opp_apply"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">公告状态:</div>
				<div class="content_info opp_status"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">培训地点:</div>
				<div class="content_info opp_address"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">开始报名时间:</div>
				<div class="content_info opp_addtime"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">截止报名时间:</div>
				<div class="content_info opp_endtime"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">培训开始时间:</div>
				<div class="content_info opp_starttime"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">培训时长:</div>
				<div class="content_info opp_spend"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">发布者类型:</div>
				<div class="content_info opp_publisher_type"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">发布者:</div>
				<div class="content_info opp_publisher_name"></div>
			</div>
		</div>
		<div class="eject_content_list"> 
			<div class="eject_list_row"> 
			<div class="eject_list_name ">附件:</div> 
			<div class="content_info opp_attachment">查看</div> 
			</div>	 
		</div> 
		<div class="eject_content_text">
			<div class="eject_text_name">公告内容:</div>
			<div class="eject_text_info">
				<textarea rows="5" cols="50" class="opp_content" disabled></textarea>
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">公告说明:</div>
			<div class="eject_text_info">
				<textarea rows="5" cols="50" class="opp_description" disabled></textarea>
			</div>
		</div>
		<div class="eject_botton">
			<input type="hidden" name="opp_id" />
			<div class="opp_colse">关闭</div>
			<div class="opp_release">发布</div>
			<div class="opp_cancel">取消发布</div>
			<div class="opp_delete">确认删除</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/admin/common.js'); ?>"></script>
<script>
//保存
var columns1 = [ {field : 'title',title : '主题',width : '200',align : 'left'},
			{field : 'address',title : '地点',width : '200',align : 'left'},
			{field : 'begintime',title : '报名开始时间',width : '200',align : 'center'},
			{field : 'endtime',title : '报名截止时间',align : 'center', width : '200'},
			{field : 'sponsor',title : '主办方',align : 'center', width : '180'},
			{field : 'people',title : '容纳人数',align : 'center', width : '180'},
			{field : null,title : '操作',align : 'left', width : '200',formatter: function(item){
				var button = '<a href="javascript:void(0);" onclick="details('+item.id+' ,1)" class="btn btn-info btn-xs edit">查看</a>&nbsp;';
				button += '<a href="javascript:void(0);" onclick="show_details('+item.id+')" class="btn btn-info btn-xs edit">编辑</a>&nbsp;';
				button += '<a href="javascript:void(0);" onclick="details('+item.id+' ,2)" class="btn btn-info btn-xs edit">发布</a>&nbsp;';
				button += '<a href="javascript:void(0);" onclick="details('+item.id+' ,3)" class="btn btn-info btn-xs edit">删除</a>';
				return button;
			}
		}];
//发布
var columns2 = [ {field : 'title',title : '主题',width : '200',align : 'left'},
     			{field : 'address',title : '地点',width : '200',align : 'left'},
     			{field : 'begintime',title : '报名开始时间',width : '200',align : 'center'},
     			{field : 'endtime',title : '报名截止时间',align : 'center', width : '200'},
     			{field : 'sponsor',title : '主办方',align : 'center', width : '180'},
     			{field : 'people',title : '容纳人数',align : 'center', width : '180'},
     			{field : null,title : '操作',align : 'left', width : '200',formatter: function(item){
     				var button = '<a href="javascript:void(0);" onclick="details('+item.id+' ,1)" class="btn btn-info btn-xs edit">查看</a>&nbsp;';
     				button += '<a href="javascript:void(0);" onclick="show_details('+item.id+')" class="btn btn-info btn-xs edit">编辑</a>&nbsp;';
     				button += '<a href="javascript:void(0);" onclick="details('+item.id+' ,4)" class="btn btn-info btn-xs edit">取消发布</a>&nbsp;';
     				return button;
     			}
     		}];
//取消
var columns3 = [ {field : 'title',title : '主题',width : '200',align : 'left'},
     			{field : 'address',title : '地点',width : '200',align : 'left'},
     			{field : 'begintime',title : '报名开始时间',width : '200',align : 'center'},
     			{field : 'endtime',title : '报名截止时间',align : 'center', width : '200'},
     			{field : 'sponsor',title : '主办方',align : 'center', width : '180'},
     			{field : 'people',title : '容纳人数',align : 'center', width : '180'},
     			{field : null,title : '操作',align : 'left', width : '180',formatter: function(item){
     				var button = '<a href="javascript:void(0);" onclick="details('+item.id+' ,1)" class="btn btn-info btn-xs edit">查看</a>&nbsp;';
     				button += '<a href="javascript:void(0);" onclick="details('+item.id+' ,3)" class="btn btn-info btn-xs edit">删除</a>';
     				return button;
     			}
     		}];
//初始加载
var initial_status = $('input[name="status"]').val();
change_status(initial_status); 

//导航栏切换
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('status')
	$('input[name="status"]').val(status);
	$('input[name="page_new"]').val(1);
	change_status(status);
})
//搜索
$('#search_condition').submit(function(){
	var status = $('input[name="status"]').val();
	$('input[name="page_new"]').val(1);
	change_status(status);
	return false;	
})

//根据状态加载数据
function change_status(status) {
	if (status == 0) { //保存
		get_ajax_page_data(columns1);
	} else if(status == 1) { //已发布
		get_ajax_page_data(columns2);
	} else if (status == 2) { //已取消
		get_ajax_page_data(columns3);
	}
}
											
// 添加培训公告的弹出层
function popLayer() {
	$('.bootbox').show();
	$('.modal-backdrop,.opp_srelease').show();
	$('.opp_eidt').css('display','none');
	$("#form_data_submit").find('input,textarea').val('');
	$('.input_cx_data').css({'width':'270px','height':'35px'});
};
// 添加培训公告，提交表单
function submit_opp(is) {
	$('input[name="is"]').val(is)
	$.post("/admin/a/opportunity/add_opportunity",$('#form_data_submit').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
	return false;
}
//编辑弹出
function show_details(id) {
	$.post("/admin/a/opportunity/get_one_json",{'id':id},function(data) {
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

// 上传附件
$('#upload_file').on('click', function() {  
	$.ajaxFileUpload({  
		url:'/admin/upload/up_file',  
		secureuri:false,  
		fileElementId:'upfile',// file标签的id
		dataType: 'json',// 返回数据的类型
		data:{filename:'upfile'},
		success: function (data, status) {  
			if (data.code == 2000) {
				$('input[name="attachment"]').val(data.msg);
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
	$.post("/admin/a/opportunity/get_one_json",{'id':id},function(data) {
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
//删除公告
$('.opp_delete').click(function(){
	var id = $('input[name="opp_id"]').val();
	var status = $('input[name="status"]').val();
	$.post("/admin/a/opportunity/delete",{'id':id},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.modal-backdrop,.eject_body').hide();
		} else {
			alert(data.msg);
		}
	});
})
//取消公告
$('.opp_cancel').click(function(){
	var id = $('input[name="opp_id"]').val();
	var status = $('input[name="status"]').val();
	$.post("/admin/a/opportunity/cancel",{'id':id},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.modal-backdrop,.eject_body').hide();
		} else {
			alert(data.msg);
		}
	});
})
//发布公告
$('.opp_release').click(function(){
	var id = $('input[name="opp_id"]').val();
	var status = $('input[name="status"]').val();
	$.post("/admin/a/opportunity/release",{'id':id},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.modal-backdrop,.eject_body').hide();
		} else {
			alert(data.msg);
		}
	});
})
var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:'11:00'
		});
	}else
		this.setOptions({
			minTime:'8:00'
		});
};
$('#opp_begintime').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$('#opp_starttime').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$('#opp_endtime').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
</script>