<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">文章分类</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/basics/articleAttr/getArticleAttrData')?>" id='search_condition' class="search_condition_form" method="post">
			<select name="search_ishome">
				<option value="2" selected="selected">选择显示位置</option>
				<option value="0">不显示在首页</option>
				<option value="1">显示在首页</option>
			</select>
			<input type="hidden" name="page_new" class="page_new" />
			<input type="submit" class="input_button" value="搜索" />
		</form>
		<div class="dataTables_wrapper form-inline no-footer">
			<table class="table table-striped table-hover table-bordered dataTable no-footer" >
				<thead id="pagination_title"></thead>
				<tbody id="pagination_data"></tbody>
			</table>
		</div>
		<div class="pagination" id="pagination"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">文章分类</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">分类名称<span class="input-must">*</span></label>
						<div class="col-sm-8 col_ts">
							<input class="form-control" name="attr_name" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">名称缩写</label>
						<div class="col-sm-8 col_ts">
							<input class="form-control" maxlength="4"  name="shortname" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">分类编号</label>
						<div class="col-sm-8 col_ts">
							<input class="form-control" maxlength="10"  name="attr_code" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-8 col_ts">
							<input class="form-control inputNumber" maxlength="4"  name="showorder" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">显示在首页</label>
						<div class="col-sm-8">
							<select name="ishome" style="width:100%;">
								<option value="0">不显示在首页</option>
								<option value="1">显示在首页</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<input type="hidden" value="" name="id">
						<input class="close-button form-button" value="关闭" type="button">
						<input class="form-button" value="提交" type="submit">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
var columns = [ {field : 'attr_name',title : '分类名称',width : '120',align : 'center'},
        		{field : 'shortname' ,title : '名称缩写' ,width : '120' ,align : 'center'},
        		{field : 'attr_code',title : '分类编号',width : '150',align : 'center'},
        		{field : null,title : '是否显示在首页',align : 'center', width : '80',formatter:function(item){
						if (item.ishome == 1) {
							return '是';
						} else {
							return '否';
						}
            		}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '160' ,length:15},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
ajaxGetData(columns ,inputId);

//搜索
$('#search_condition').submit(function(){
	$('input[name="page_new"]').val(1);
	ajaxGetData(columns ,inputId);
	return false;
})

//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[type='hidden']").val('');
	$("select[name='ishome']").val(0);
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/basics/articleAttr/edit";
	} else {
		var url = "/admin/a/basics/articleAttr/add";
	}
	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	})
	return false;
})

function edit(id) {
	$.post("/admin/a/basics/articleAttr/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='attr_name']").val(data.attr_name);
		$("input[name='shortname']").val(data.shortname);
		$("input[name='attr_code']").val(data.attr_code);
		$("input[name='id']").val(data.id);
		$("input[name='showorder']").val(data.showorder);
		$("select[name='ishome']").val(data.is_home);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/basics/articleAttr/delete",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}

$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})
</script>
