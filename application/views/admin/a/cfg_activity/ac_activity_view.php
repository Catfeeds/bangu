<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗活动配置</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/cfg_act/ac_activity/getAcList')?>" id='search_condition' class="form-inline clear" method="post">
		</form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗活动配置</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">广告标题<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="title" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">说明 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="description" rows="6" style="width:100%;"></textarea>
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
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script>
var columns = [ {field : 'name',title : '广告标题',width : '100',align : 'center'},
        		{field : 'addtime',title : '添加时间',align : 'center', width : '80'},
        		{field : 'realname',title : '添加人',align : 'center', width : '80'},
        		{field : 'description',title : '说明',align : 'center', width : '160' ,length:20},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg_act/ac_activity/getAcList',
	searchForm:'#search_condition',
});

//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[name='id']").val('');
	$("#addFormData").find("input[name='description']").val('');
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/cfg_act/ac_activity/edit";
	} else {
		var url = "/admin/a/cfg_act/ac_activity/add";
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
	$.post("/admin/a/cfg_act/ac_activity/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("#addFormData").find("input[type='text']").val(data.name);
		$("input[name='id']").val(data.id);
		$("textarea[name='description']").val(data.description);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_act/ac_activity/delete",{id:id},function(json){
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
