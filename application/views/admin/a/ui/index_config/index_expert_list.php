<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">招聘管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="add_hire" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/hire/getHireData')?>" id='search_condition' class="form-inline clear" method="post">
			<div class="form-group dataTables_filter ">
				<input type="text" class="form-control" placeholder="标题" name="title">
			</div>
			<div class="form-group dataTables_filter ">
				<input type="text" class="form-control" placeholder="更新时间开始"  id="datetimepicker1" name="start_time">
			</div>
			<div class="form-group dataTables_filter ">
				<input type="text" class="form-control" placeholder="更新时间结束"  id="datetimepicker2" name="end_time">
			</div>
				<input type="hidden" value="1" name="page_new" class="page_new" />
			<button type="submit" class="btn btn-darkorange active" >搜索</button>
		</form>
		<div class="dataTables_wrapper form-inline no-footer">
			<table class="table table-striped table-hover table-bordered dataTable no-footer" >
				<thead id="pagination_title"></thead>
				<tbody id="pagination_data"></tbody>
			</table>
		</div>
		<br/>
		<div class="pagination" id="pagination"></div>
	</div>
</div>

<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox addHire modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">添加招聘信息</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addSubmitForm" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">标题<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" maxlength="50"  name="title" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">招聘人数<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control inputNumber" maxlength="2"  name="hire_num" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">岗位职责<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<textarea name="responsibility" style="width:100%;height:120px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">岗位要求<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<textarea name="requirement" style="width:100%;height:120px;"></textarea>
							</div>
						</div>

						<div class="form-group">
							<input class="btn btn-palegreen bootbox-close-button colseBox" value="取消" style="float: right; margin-right: 2%;" type="button"> 
							<input class="btn btn-palegreen" value="添加" style="float: right; margin-right: 2%;" type="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox editHire modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">编辑招聘信息</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="editSubmitForm" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">标题<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" maxlength="50"  name="title" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">招聘人数<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control inputNumber" maxlength="2"  name="hire_num" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">岗位职责<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<textarea name="responsibility" style="width:100%;height:120px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">岗位要求<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<textarea name="requirement" style="width:100%;height:120px;"></textarea>
							</div>
						</div>			
						<div class="form-group">
							<input type="hidden" name="id" />
							<input class="btn btn-palegreen bootbox-close-button colseBox" value="取消" style="float: right; margin-right: 2%;" type="button"> 
							<input class="btn btn-palegreen" value="确认编辑" style="float: right; margin-right: 2%;" type="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="eject_body hire_Detail">
	<div class="eject_colse colseBox">X</div>
	<div class="eject_title">招聘详细</div>
	<div class="eject_content">
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">招聘标题:</div>
				<div class="content_info hire_title"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">招聘人数:</div>
				<div class="content_info hire_num"></div>
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">岗位职责:</div>
			<div class="eject_text_info responsibility"></div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">岗位要求:</div>
			<div class="eject_text_info requirement"></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="hireId" />
			<div class="ex_colse colseBox">关闭</div>
			<div class="hireRelease">确认发布</div>
			<div class="hireCancel">确认取消</div>
		</div>	
	</div>						
</div>

<div class="modal-backdrop fade in bc_close" style="display: none"></div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
$('#datetimepicker1').datetimepicker({
	lang:'ch',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#datetimepicker2').datetimepicker({
	lang:'ch',
	timepicker:false,
	format:'Y-m-d',
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
var columns = [ {field : null,title : '标题',width : '150',align : 'center' ,formatter:function(item){
				return '<a href="javascript:void(0);" onclick="see_detail('+item.id+' ,1);">'+item.title+'</a>';
			}
		},
		{field : 'responsibility',title : '职责',width : '200',align : 'left',length:15},
		{field : 'requirement',title : '岗位要求',width : '140',align : 'left' ,length:20},
		{field : 'modtime',title : '更新时间',align : 'left', width : '160'},
		{field : 'hire_num',title : '招聘人数',align : 'center', width : '130'},
		{field : null,title : '状态',align : 'center', width : '120',formatter:function(item){
				return enableArr[item.enable];
			}
		},
		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">编辑</a>&nbsp;&nbsp;';
			if (item.enable == 1) {
				button += '<a href="javascript:void(0);" onclick="see_detail('+item.id+' ,3);" class="btn btn-default btn-xs purple">取消发布</a>';
			} else if (item.enable == 0) {
				button += '<a href="javascript:void(0);" onclick="see_detail('+item.id+' ,2);" class="btn btn-default btn-xs purple">发布</a>';
			}
			return button;
		}
	}];

//初始加载
change_status();
//搜索
$('#search_condition').submit(function(){
	$('input[name="page_new"]').val(1);
	change_status();
	return false;	
})
//根据状态加载数据
function change_status() {
	var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
	ajaxGetData(columns ,inputId);
}
//添加弹出层
$("#add_hire").click(function(){
	$("#addSubmitForm").find("input[name='text']").val('');
	$("#addSubmitForm").find("textarea").val('');
	$(".addHire,.modal-backdrop").show();
})
$("#addSubmitForm").submit(function(){
	$.post("/admin/a/hire/addSubmitForm",$("#addSubmitForm").serialize(),function(json){
		var data = eval("("+json+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	})
	return false;
})
//查看详情
function see_detail(id ,type) {
	$.post("/admin/a/hire/getHireDetail",{id:id},function(json){
		if (json == false) {
			return false;
		}
		var data = eval("("+json+")");
		$(".hire_title").html(data.title);
		$(".hire_num").html(data.hire_num);
		$(".responsibility").html(data.responsibility);
		$(".requirement").html(data.requirement);
		$("input[name='hireId']").val(data.id);
		$(".hire_Detail,.modal-backdrop").show();
		if (type == 1) {
			$(".hireRelease,.hireCancel").hide();
		} else if (type == 2) {
			$(".hireCancel").hide();
			$(".hireRelease").show();
		} else if (type == 3) {
			$(".hireRelease").hide();
			$(".hireCancel").show();
		}
	})
}

$(".colseBox").click(function(){
	$(".hire_Detail,.modal-backdrop,.bootbox").hide();
})

//确认发布
$(".hireRelease").click(function(){
	var id = $("input[name='hireId']").val();
	$.post("/admin/a/hire/hireRelease",{id:id},function(json){
		var data = eval("("+json+")");
		if (data.code == 2000) {
			$(".hire_Detail,.modal-backdrop").hide();
			change_status();
		} else {
			alert(data.msg);
		}
	})
})
//取消发布
$(".hireCancel").click(function(){
	var id = $("input[name='hireId']").val();
	$.post("/admin/a/hire/hireCancel",{id:id},function(json){
		var data = eval("("+json+")");
		if (data.code == 2000) {
			$(".hire_Detail,.modal-backdrop").hide();
			change_status();
		} else {
			alert(data.msg);
		}
	})
})
//编辑
function edit(id) {
	$.post("/admin/a/hire/getHireDetail" ,{id:id} ,function(json){
		if (json == false) {
			return false;
		}
		var data = eval("("+json+")");
		$("#editSubmitForm").find("input[name='title']").val(data.title);
		$("#editSubmitForm").find("input[name='hire_num']").val(data.hire_num);
		$("#editSubmitForm").find("textarea[name='responsibility']").val(data.responsibility);
		$("#editSubmitForm").find("textarea[name='requirement']").val(data.requirement);
		$("#editSubmitForm").find("input[name='id']").val(data.id);
		
		$(".editHire,.modal-backdrop").show();
	})
}
$("#editSubmitForm").submit(function(){
	$.post("/admin/a/hire/editHire",$("#editSubmitForm").serialize(),function(json){
		var data = eval("("+json+")")
		if (data.code == 2000) {
			$(".editHire,.modal-backdrop").hide();
			change_status();
		} else {
			alert(data.msg);
		}
	});
	return false;
})
</script>
