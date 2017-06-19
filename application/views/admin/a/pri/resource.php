<style>
	#search_condition .form-group{width:120px;margin-right: 15px;float:left;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">权限管理</li>
		</ul>
	</div>
	<div class="page-body">
		<a id="addAdmin" href="javascript:void(0);" style="margin-bottom: 10px;" class="btn btn-default">添加 </a>
		<div class="tab-content">
			<form action="#" id='search_condition' method="post">
				<div class="form-group">
					<select name="pid">
						<option value="0">选择上级</option>
						<?php 
							foreach($resourceArr as $val) {
								echo '<option value="'.$val['resourceId'].'">'.$val['name'].'</option>';
							}
						?>
					</select>
				</div>
				<div class="form-group">
					<select name="isopen">
						<option value="0">是否启用</option>
						<option value="2">未启用</option>
						<option value="1">已启用</option>
					</select>
				</div>
				<input type="submit" value="搜索" class="btn btn-darkorange active" />
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" onclick="closebox();">×</button>
				<h4 class="modal-title">权限管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择上级</label>
						<div class="col-sm-10">
							<select name="pid" style="width:100%;">
								<option value="0">选择上级</option>
								<?php 
									foreach($resourceArr as $val) {
										echo '<option value="'.$val['resourceId'].'">'.$val['name'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择角色<span class="input-must">*</span></label>
						<div class="col-sm-10" id="choiceRole">
							<?php 
								foreach($roleArr as $val)
								{
									if (empty($val['roleName'])) continue;
									echo '<div class="col-lg-4 col-sm-4 col-xs-4 admin_check" style="width:150px;"><div class="checkbox">';
									echo '<label><input style="left:20px;opacity:1;" value="'.$val['roleId'].'" name="role[]" type="checkbox">'.$val['roleName'].'</label></div></div>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">名称<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control"  name="name"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">url地址<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control"  name="url"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10">
							<input class="form-control"  name="showorder"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">是否启用</label>
						<div class="col-sm-10">
							<select name="isopen" style="width:100%;">
								<option value="0">不启用</option>
								<option value="1" selected="selected">启用</option>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">描述 </label>
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
<script>
var columns = [ {field : 'name',title : '名称',width : '120',align : 'center'},
				{field : 'uri',title : 'url地址',width : '170',align : 'center'},
				{field : 'parent',title : '上级',width : '130',align : 'center'},
				{field : false,title : '是否启用',width : '120',align : 'center',formatter:function(item){
						return item.isopen == 1 ? '已启用' : '未启用';
					}
				},
				{field : 'roles',title : '角色',width : '250',align : 'center'},
				{field : 'showorder',title : '排序',width : '80',align : 'center'},
				{field : 'description',title : '描述',width : '130',align : 'center'},
				{field : false,title : '操作',align : 'center', width : '120',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='edit("+item.resourceId+")' class='btn btn-info btn-xs edit'>修改</a>";;
				}
			}];				
$("#dataTable").pageTable({
	columns:columns,
	url:'admin/a/pri/resource/getResourceJson',
	searchForm:'#search_condition',
	pageNumNow:1
});
//添加弹出层
$("#addAdmin").click(function(){
	var fromObj = $("#addFormData");
	fromObj.find('input[type=text]').val('');
	fromObj.find('input[type=hidden]').val('');
	fromObj.find('select[name=isopen]').val(1);
	fromObj.find('select[name=pid]').val(0);
	fromObj.find('input[type=checkbox]').attr('checked' ,false);
	$('.bootbox,.modal-backdrop').show();
})
$("#addFormData").submit(function(){
	var id = $('input[name=id]').val();
	if (id > 0) {
		var url = '/admin/a/pri/resource/edit';
	} else {
		var url = '/admin/a/pri/resource/add';
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
					url:'admin/a/pri/resource/getResourceJson',
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
		url:'/admin/a/pri/resource/getResourceDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				formObj.find('input:checkbox').attr('checked',false);
				$.each(data.roles ,function(key ,val){
					formObj.find('input:checkbox[value="'+val.roleId+'"]').attr('checked' ,'checked');
				})
				$('input[name=name]').val(data.name);
				$('input[name=id]').val(data.resourceId);
				$('input[name=showorder]').val(data.showorder);
				$('input[name=url]').val(data.uri);
				$('textarea[name=description]').val(data.description);
				$('input[name=id]').val(data.resourceId);
				formObj.find('select[name=isopen]').val(data.isopen);
				formObj.find('select[name=pid]').val(data.pid);
				$('.bootbox,.modal-backdrop').show();
			} else {
				alert('无数据');
			}
		}
	});
}
function closebox() {
	$('.bootbox,.modal-backdrop').hide();
}
</script>