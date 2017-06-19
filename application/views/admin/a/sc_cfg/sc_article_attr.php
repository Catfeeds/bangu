<link rel="stylesheet" href="/file/common/plugins/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/file/common/plugins/kindeditor/plugins/code/prettify.css" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗文章标签设置</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sc_cfg/sc_common_problem/getListData')?>" id='search_condition' class="form-inline clear" method="post"></form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗文章标签</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post" >
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">属性名</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" name="attrname" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否启用</label>
						<div class="col-sm-10">
							<select name="isopen" style="width:100%;">
								<option value="0">不启用</option>
								<option value="1" selected="selected">启用</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">描述:</label>
						<div class="col-sm-10">
							<textarea class="eject_list_name" id="description" name="description" style="width:100%;height:400px;"></textarea>
						</div>
					</div>

					<div class="form-group">
						<input type="hidden" name="article_attr_id" value="" >
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
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>

<!--编辑器-->
<script charset="utf-8" src="/file/common/plugins/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/plugins/code/prettify.js"></script>
<script>
var columns = [
		{field : 'attrname',title : '标签名称',width : '200',align : 'center' ,length:20},
        		{field : false ,title : '是否启用' ,width : '100' ,align : 'center',formatter:function(item){
        				 if(item.isopen==1){
        				 	return '启用';
        				 }else{
        				 	return '不启用';
        				 }
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);"  onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	            }];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/sc_cfg/sc_article_attr/getDataList',
	searchForm:'#search_condition',
});


//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[type='hidden']").val('');
	$("select[name='isopen']").val(0);
	$('#description').val('');
	$(".bootbox,.modal-backdrop").show();
});

$("#addFormData").submit(function(){
	var id = $(this).find("input[name='article_attr_id']").val();
	if (id.length > 0){
		var url = "/admin/a/sc_cfg/sc_article_attr/edit";
	}else{
		var url = "/admin/a/sc_cfg/sc_article_attr/add";
	}
	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
	return false;
});

function edit(id) {
	$.post("/admin/a/sc_cfg/sc_article_attr/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='article_attr_id']").val(data.id);
		$("input[name='showorder']").val(data.showorder);
		$("input[name='attrname']").val(data.attrname);
		$("select[name='isopen']").val(data.isopen);
		$("#description").val(data.description);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/sc_article_attr/delete",{'id':id},function(json){
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
});
</script>
