<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">银行卡管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/theme/getThemeJson')?>" id='search_condition' class="form-inline clear" method="post">
			<div class="form-group dataTables_filter ">
				<input type="text" class="form-control" placeholder="主题名称" name="name">
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

<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox addFormBox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">主题管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addSubmitForm" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">名称<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" name="name" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">排序</label>
							<div class="col-sm-10">
								<input class="form-control inputNumber" name="showorder" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">描述</label>
							<div class="col-sm-10">
								<textarea name="description" style="width:100%;height:120px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="id" >
							<input class="btn btn-palegreen bootbox-close-button colseBox" value="取消" style="float: right; margin-right: 2%;" type="button"> 
							<input class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" type="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [ {field : 'name',title : '主题名称',width : '200',align : 'center'},
		{field : 'showorder',title : '排序',align : 'center', width : '130'},
		{field : 'description',title : '描述',align : 'center', width : '200',length:20},
		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
			return '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
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
$("#addData").click(function(){
	$("#addSubmitForm").find("input[type='text']").val('');
	$("#addSubmitForm").find("input[type='hidden']").val('');
	$("textare[name='description']").val('');
	$(".addFormBox,.modal-backdrop").show();
})

$("#addSubmitForm").submit(function(){
	var id = $("#addSubmitForm").find("input[name='id']").val();
	if (id > 0) {
		var url = '/admin/a/theme/editTheme';
	} else {
		var url = '/admin/a/theme/addTheme';
	}
	$.post(url,$("#addSubmitForm").serialize(),function(json){
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
//编辑
function edit(id){
	$.post("/admin/a/theme/getThemeDetail",{id:id},function(json) {
		var data = eval("("+json+")");
		$("#addSubmitForm").find("input[name='name']").val(data.name);
		$("input[name='showorder']").val(data.showorder);
		$("textarea[name='description']").val(data.description);
		$("input[name='id']").val(data.id);
		$(".addFormBox,.modal-backdrop").show();
	})
}

$(".colseBox").click(function(){
	$(".modal-backdrop,.bootbox").hide();
})
</script>
