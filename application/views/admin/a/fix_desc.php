<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">广告配置</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/fix_desc/getFixDescJson')?>" id='search_condition' class="form-inline clear" method="post">
			<div class="form-group dataTables_filter ">
				<input type="text" class="form-control" id="searchStarttime" placeholder="开始时间" name="starttime">
				<input type="text" class="form-control" id="searchEndtime" placeholder="结束时间" name="endtime">
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
				<h4 class="modal-title">广告管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addSubmitForm" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">固定标识<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" name="code" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">跳转链接<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" name="url" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">开始时间<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" name="starttime" readonly="readonly" id="starttime" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">结束时间<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input class="form-control" name="endtime" readonly="readonly" id="endtime" type="text">
							</div>
						</div>
						
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">排序</label>
							<div class="col-sm-10">
								<input class="form-control inputNumber" name="showorder" type="text">
							</div>
						</div>
						<div class="form-group addContent">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否可删除</label>
							<div class="col-sm-10">
								<select name="isdelete" style="width:100%;">
									<option value="0" selected="selected">不可删除</option>
									<option value="1" >可删除</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
								<input name="pic" type="hidden" />
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">描述</label>
							<div class="col-sm-10">
								<textarea name="description" style="width:100%;height:120px;"></textarea>
							</div>
						</div>
						<div class="form-group addContent">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">不可修改描述</label>
							<div class="col-sm-10">
								<textarea name="no_description" style="width:100%;height:120px;"></textarea>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
var columns = [ {field : 'dict_code',title : '固定标识',width : '150',align : 'center'},
		{field : null ,title : '图片' ,width : '130' ,align : 'center',formatter:function(item){
				return "<a href='"+item.pic+"' target='_blank'>预览</a>";
			}
		},
		{field : 'url',title : '链接地址',align : 'center', width : '150'},
		{field : 'showorder',title : '排序',align : 'center', width : '100'},
		{field : 'starttime',title : '开始时间',align : 'center', width : '140'},
		{field : 'endtime',title : '结束时间',align : 'center', width : '140'},
		{field : 'description',title : '描述',align : 'center', width : '150',length:20},
		{field : 'no_description',title : '不可修改描述',align : 'center', width : '150',length:20},
		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
			if (item.isdelete == 1) {
				button += '<a href="javascript:void(0);" onclick="del('+item.id+')" class="btn btn-default btn-xs purple">删除</a>';
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

$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#searchStarttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#searchEndtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});

//添加弹出层
$("#addData").click(function(){
	$("#addSubmitForm").find("input[type='text']").val('');
	$("#addSubmitForm").find("input[type='hidden']").val('');
	$("#addSubmitForm").find("select[name='isdelete']").val(0);
	$(".uploadImg").remove();
	$("input[name='code']").removeAttr("disabled");
	$(".addContent").show();
	$(".addFormBox,.modal-backdrop").show();
})

$("#addSubmitForm").submit(function(){
	var id = $("#addSubmitForm").find("input[name='id']").val();
	if (id > 0) {
		var url = '/admin/a/fix_desc/editFixDesc';
	} else {
		var url = '/admin/a/fix_desc/addFixDesc';
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
	$.post("/admin/a/fix_desc/getFixDescDetail",{id:id},function(json) {
		var data = eval("("+json+")");
		$(".uploadImg").remove();
		$("#addSubmitForm").find("input[name='starttime']").val(data.starttime);
		$("#addSubmitForm").find("input[name='endtime']").val(data.endtime);
		$("input[name='showorder']").val(data.showorder);
		$("input[name='code']").val(data.dict_code).attr("disabled","disabled");
		$("select[name='isdelete']").val(data.isopen);
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$("input[name='pic']").val(data.pic);
		$("input[name='id']").val(data.id);
		$("input[name='url']").val(data.url);
		$("textarea[name='description']").val(data.description);
		$(".addContent").hide();
		$(".addFormBox,.modal-backdrop").show();
	})
}

function del(id) {
	if (confirm("您确定要删除？")) {
		$.post("/admin/a/fix_desc/delete",{id:id},function(data){
			var data = eval("("+data+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		})
	}
}

$(".colseBox").click(function(){
	$(".modal-backdrop,.bootbox").hide();
})
</script>
