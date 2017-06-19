<link rel="stylesheet" href="/file/common/plugins/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/file/common/plugins/kindeditor/plugins/code/prettify.css" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗主题线路设置</li>
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
				<h4 class="modal-title">深窗常见问题</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post" >
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">问题分类</label>
						<div class="col-sm-10 col_ts">
							<!-- <input class="form-control" name="problem_kind" type="text"> -->
							<select name="problem_kind" id="problem_kind">
								<option value="">请选择</option>
								<?php  foreach($problem_kind as $k=>$v):?>
								<option value="<?php echo $v['id']?>"><?php echo $v['name']?></option>
								<?php  endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group">

						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">标题</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" name="problem_title" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否显示</label>
						<div class="col-sm-10">
							<select name="is_show" style="width:100%;">
								<option value="0">不显示</option>
								<option value="1" selected="selected">显示</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">详细内容:</label>
						<div class="col-sm-10">
							<textarea class="eject_list_name" id="problem_content" name="problem_content" style="width:100%;height:400px;"></textarea>
						</div>
					</div>

					<div class="form-group">
						<input type="hidden" name="problem_id" value="" >
						<input type="hidden" name="problem_detail_id" value="" >
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
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<!--编辑器-->
<script charset="utf-8" src="/file/common/plugins/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/plugins/code/prettify.js"></script>

<script>
var columns = [
		{field : 'title',title : '标题',width : '200',align : 'center' ,length:20},
                	{field : 'kind_name',title : '问题类别',width : '75',align : 'center'},
        		{field : false ,title : '是否显示' ,width : '100' ,align : 'center',formatter:function(item){
        				return showArr[item.is_show];
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : 'addtime',title : '添加时间',align : 'center', width : '80'},
        		{field : 'modtime',title : '修改时间',align : 'center', width : '80'},
        		{field : 'realname',title : '操作人',align : 'center', width : '160' ,length:15},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" data-val='+item.id+'|'+item.p_detail_id+' onclick="del(this);" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	            }];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/sc_cfg/sc_common_problem/getListData',
	searchForm:'#search_condition',
});

 	//编辑器
KindEditor.ready(function(K) {
        window.editor = K.create('#problem_content');
});

//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[type='hidden']").val('');
	$("#ds-list").html('');
	$("#problem_kind").val('');
	$("select[name='is_show']").val(1);
	$("select[name='is_modify']").val(0);
	$('#consult_content').val('');
	editor.sync();
	editor.html('');
	$(".bootbox,.modal-backdrop").show();
});

$("#addFormData").submit(function(){
	var id = $(this).find("input[name='problem_id']").val();
	if (id.length > 0){
		var url = "/admin/a/sc_cfg/sc_common_problem/edit";
	}else{
		var url = "/admin/a/sc_cfg/sc_common_problem/add";
	}
	editor.sync();
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
	$.post("/admin/a/sc_cfg/sc_common_problem/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		var dest_str_arr = data.dest_name_str.split(',');
		var dest_str = '<div class="selectedTitle">已选择:</div>';
		$("input[name='problem_id']").val(data.id);
		$("input[name='problem_detail_id']").val(data.p_detail_id);
		$("input[name='showorder']").val(data.showorder);
		$("input[name='problem_title']").val(data.title);
		$("select[name='is_show']").val(data.is_show);
		$("#problem_content").val(data.p_content);
		editor.sync();
		// 设置HTML内容
		editor.html(data.p_content);
		$("#problem_kind").val(data.kind_id);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(obj) {
	var problem_id_arr = $(obj).attr('data-val').split('|');
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/sc_common_problem/delete",{'id':problem_id_arr[0],'detail_id':problem_id_arr[1]},function(json){
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

//目的地(所有)
$.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"overcityArr",
		valId:"overcitystr",
		width:640,
		number:5,
		buttonId:'ds-list'
	});
});
</script>
