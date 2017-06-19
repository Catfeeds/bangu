<style>
	#search_condition .form-control{width:200px;margin-right: 15px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">角色管理</li>
		</ul>
	</div>
	<div class="page-body">
		<a id="addAdmin" href="javascript:void(0);" style="margin-bottom: 10px;" class="btn btn-default">添加 </a>
		<div class="tab-content">
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog" style="width:800px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" onclick="closebox();">×</button>
				<h4 class="modal-title">角色管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">角色名称<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control" style="ime-mode: disabled"  name="name"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择管理员<span class="input-must">*</span></label>
						<div class="col-sm-10" id="choiceAdmin">
							<?php 
								foreach($adminData as $val)
								{
									if (empty($val['realname'])) continue;
									echo '<div class="col-lg-4 col-sm-4 col-xs-4 admin_check" style="width:150px;"><div class="checkbox">';
									echo '<label><input style="left:20px;opacity:1;" value="'.$val['id'].'" name="admin[]" type="checkbox">'.$val['realname'].'</label></div></div>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择模块<span class="input-must">*</span></label>
						<div class="col-sm-10" id="choiceCheck">
							<ul>
							<?php 
								foreach($resourceArr as $val)
								{
									if (!empty($val['lower']))
									{
										echo '<li class="pr_resource"><input type="checkbox" class="inputCheck" name="resource[]" value="'.$val['resourceId'].'">'.$val['name'].'<ul class="lower-resource">';
										foreach($val['lower'] as $v)
										{
											echo '<li class="cl_resource"><input type="checkbox" class="inputCheck" name="resource[]" value="'.$v['resourceId'].'">'.$v['name'].'</li>';
										}
										echo '<div class="clear"></div></ul></li>';
									}
								}
							?>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">描述 <span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<textarea name="description" rows="6" style="width:100%;"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<input type="hidden" value="" name="id">
						<input class="close-button form-button" onclick="closebox();" value="关闭" type="button">
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
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [ {field : 'roleName',title : '角色名称',width : '120',align : 'center'},
				{field : 'resource',title : '管理模块',width : '500',align : 'center'},
				{field : 'admin',title : '管理员',width : '200',align : 'center'},
				{field : 'description',title : '描述',width : '120',align : 'center'},
				{field : false,title : '操作',align : 'center', width : '100',formatter: function(item) {
					var button = "<a href='javascript:void(0);' onclick='edit("+item.roleId+")' class='btn btn-info btn-xs edit'>修改</a>&nbsp;";
					button += "<a href='javascript:void(0);' onclick='del("+item.roleId+")' class='btn btn-danger btn-xs'>删除</a>";
					return button;
				}
			}];
						
$("#dataTable").pageTable({
	columns:columns,
	url:'admin/a/pri/role/getRoleJson',
	searchForm:'#search_condition',
	pageNumNow:1
});
//添加弹出层
$("#addAdmin").click(function(){
	var fromObj = $("#addFormData");
	fromObj.find('input[type=text]').val('');
	fromObj.find('input[type=hidden]').val('');
	fromObj.find('input[type=checkbox]').attr("checked" ,false);
	$("textarea[name=description]").val('');
	$('.bootbox,.modal-backdrop').show();
})
$("#addFormData").submit(function(){
	var id = $('input[name=id]').val();
	if (id > 0) {
		var url = '/admin/a/pri/role/edit';
	} else {
		var url = '/admin/a/pri/role/add';
	}
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'admin/a/pri/role/getRoleJson',
					searchForm:'#search_condition',
					pageNumNow:1
				});
				alert(data.msg);
				$('.bootbox,.modal-backdrop').hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
function edit(id) {
	var formObj = $('#addFormData');
	$.ajax({
		url:'/admin/a/pri/role/getRoleDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data) {
			if (!$.isEmptyObject(data)) {
// 				formObj.find('input:checkbox').each(function (index, domEle) {
// 					var roleid = $(this).val();
// 					$.each(data.roles ,function(key ,val){
// 						if (val.roleId == roleid) {
// 							formObj.find('input:checkbox').eq(index).attr('checked' ,'checked');
// 						}
// 					})
// 				});
				formObj.find('input:checkbox').attr('checked',false);
				$.each(data.admins ,function(key ,val){
					formObj.find("#choiceAdmin").find('input:checkbox[value="'+val.id+'"]').attr('checked' ,true);
				})
				$.each(data.resource ,function(key ,val){
					formObj.find("#choiceCheck").find('input:checkbox[value="'+val.resourceId+'"]').attr('checked' ,true);
				})
				$('input[name=name]').val(data.roleName);
				$('input[name=id]').val(data.roleId);
				$("textarea[name=description]").val(data.description);
				$('.bootbox,.modal-backdrop').show();
			}
		}
	});
}
function del(id) {
	if (confirm("删除将不可恢复！您确定要删除吗？")) {
		$.ajax({
			url:"/admin/a/pri/role/delete",
			dataType:"json",
			type:"post",
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns,
						url:'admin/a/pri/role/getRoleJson',
						searchForm:'#search_condition',
						pageNumNow:1
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
function closebox() {
	$('.bootbox,.modal-backdrop').hide();
}
//模块全选
$(".pr_resource").children(".inputCheck").click(function(){
	if ($(this).is(":checked")) {
		$(this).parent("li").find("ul").find(".inputCheck").attr("checked" ,true);
	} else {
		$(this).parent("li").find("ul").find(".inputCheck").attr("checked" ,false);
	}
})
</script>