<link href="/assets/js/jQuery-plugin/citylist/city.css" rel="stylesheet" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗常见问题详情</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sc_cfg/sc_common_problem_detail/getListData')?>" id='search_condition' class="form-inline clear" method="post"></form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗常见问题详情</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">问题</label>
						<div class="col-sm-10 col_ts">
							<select id="common_problem_id" name="common_problem_id">
								<option value="">请选择</option>
								<?php foreach($problem AS $k=>$val):?>
								<option value="<?php echo $val['id']?>"><?php echo $val['title']?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">内容</label>
						<div class="col-sm-10 col_ts">
							<textarea class="form-control" name="problem_content" id="problem_content"></textarea>
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
<!-- 目的地结束 -->
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script>
var columns = [{field : 'title',title : '标题',width : '200',align : 'center' ,length:20},
                	{field : 'content',title : '内容',width : '200',align : 'center' ,length:20},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	            }];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/sc_cfg/sc_common_problem_detail/getListData',
	searchForm:'#search_condition',
});



//添加数据弹出
$("#addData").click(function(){
	$("#problem_content").val('');
	$("#common_problem_id").val('');
	$(".bootbox,.modal-backdrop").show();
});

$("#addFormData").submit(function(){
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0){
		var url = "/admin/a/sc_cfg/sc_common_problem_detail/edit";
	}else{
		var url = "/admin/a/sc_cfg/sc_common_problem_detail/add";
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
});

function edit(id) {
	$.post("/admin/a/sc_cfg/sc_common_problem_detail/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='id']").val(data.id);
		$("#problem_content").val(data.content);
		$("#common_problem_id").val(data.sc_common_problem_id);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/sc_common_problem_detail/delete",{id:id},function(json){
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
