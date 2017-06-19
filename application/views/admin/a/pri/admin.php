<style>
	#search_condition .form-control{width:200px;margin-right: 15px;}
	.form-group { float:left;} 
	.col_span { margin-top:4px;}
	.bootbox-body form .form-group { float:none;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">管理员管理</li>
		</ul>
	</div>
	<div class="page-body">
		<a id="addAdmin" href="javascript:void(0);" style="margin-bottom: 10px;" class="btn btn-default">添加 </a>
		<div class="tab-content">
			<form action="<?php echo site_url('admin/a/pri/adminList/getAdminJson');?>" id='search_condition' method="post">
				<div class="form-group">
					<span class="search_title col_span">姓名:</span>
					<input type="text" class="form-control col_ip" name="realname">
				</div>
				<div class="form-group">
					<span class="search_title col_span">手机号:</span>
					<input type="text" class="form-control col_ip"name="mobile">
				</div>
				<div class="form-group">
					<span class="search_title col_span">邮箱:</span>
					<input type="text" class="form-control col_ip" name="email">
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
				<h4 class="modal-title">管理员管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择角色<span class="input-must">*</span></label>
						<div class="col-sm-10" id="choiceRole">
							<?php 
								foreach($roleData as $val)
								{
									echo '<div class="col-lg-4 col-sm-4 col-xs-4 admin_check" style="width:150px;"><div class="checkbox">';
									echo '<label><input style="left:20px;opacity:1;" value="'.$val['roleId'].'" name="role[]" type="checkbox">'.$val['roleName'].'</label></div></div>';
								}
							?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">账号<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control" style="ime-mode: disabled"  name="username"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">密码<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="password"  type="password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">确认密码<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="repass"  type="password">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">真实姓名<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="realname"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">手机号<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" style="ime-mode: disabled"  name="mobile"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">邮箱地址<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" style="ime-mode: disabled" name="email"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">QQ<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" style="ime-mode: disabled" name="qq"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">头像<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
							<input name="photo" type="hidden" />
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">备注 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="beizhu" rows="6" style="width:100%;"></textarea>
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
var columns = [ {field : 'username',title : '管理员账号',width : '120',align : 'center'},
				{field : 'realname',title : '姓名',width : '120',align : 'center'},
				{field : 'mobile',title : '手机号',width : '130',align : 'center'},
				{field : 'email',title : '邮箱',align : 'center', width : '140'},
				{field : 'qq',title : 'QQ',align : 'center', width : '100'},
				{field : false,title : '是否启用',align : 'center', width : '110',formatter:function(item){
						return item.isopen == 1 ? '已启用' : '未启用';
					}
				},
				{field : 'roles',title : '角色',align : 'center', width : '350'},
				{field : 'addtime',title : '添加时间',align : 'center', width : '140'},
				{field : 'beizu',title : '备注',align : 'center', width : '110'},
				{field : false,title : '操作',align : 'center', width : '100',formatter: function(item) {
					var button = "<a href='javascript:void(0);' onclick='edit("+item.id+")' class='btn btn-info btn-xs edit'>修改</a>&nbsp;";
					if (item.isopen == 1) {
						button += "<a href='javascript:void(0);' onclick='disable("+item.id+")' class='btn btn-info btn-xs edit'>禁用</a>";
					} else {
						button += "<a href='javascript:void(0);' onclick='enable("+item.id+")' class='btn btn-info btn-xs edit'>启用</a>";
					}
					return button;
				}
			}];
						
$("#dataTable").pageTable({
	columns:columns,
	url:'admin/a/pri/adminList/getAdminJson',
	searchForm:'#search_condition',
	pageNumNow:1
});
//添加弹出层
$("#addAdmin").click(function(){
	var fromObj = $("#addFormData");
	fromObj.find('input[type=text]').val('');
	fromObj.find('input[type=hidden]').val('');
	fromObj.find('input[type=password]').val('');
	$('input[name=password]').attr('placeholder','');
	$('.uploadImg').remove();
	$('.bootbox,.modal-backdrop').show();
})

function disable(id) {
	if (confirm('您确认要禁用此管理员?')) {
		var page = $('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/pri/adminList/disable',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns,
						url:'admin/a/pri/adminList/getAdminJson',
						searchForm:'#search_condition',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
function enable(id) {
	if (confirm('您确认要启用此管理员?')) {
		var page = $('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/pri/adminList/enable',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns,
						url:'admin/a/pri/adminList/getAdminJson',
						searchForm:'#search_condition',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
$("#addFormData").submit(function(){
	var id = $('input[name=id]').val();
	if (id > 0) {
		var url = '/admin/a/pri/adminList/edit';
	} else {
		var url = '/admin/a/pri/adminList/add';
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
					url:'admin/a/pri/adminList/getAdminJson',
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
		url:'/admin/a/pri/adminList/getAdminDetail',
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
				$.each(data.roles ,function(key ,val){
					formObj.find('input:checkbox[value="'+val.roleId+'"]').attr('checked' ,'checked');
				})
				$('.uploadImg').remove();
				$('input[name=username]').val(data.username);
				$('input[name=id]').val(data.id);
				$('input[name=password]').attr('placeholder','不填写则为原密码');
				$('input[name=qq]').val(data.qq);
				$('input[name=photo]').val(data.photo);
				$('textarea[name=beizhu]').val(data.beizu);
				formObj.find('input[name=realname]').val(data.realname);
				formObj.find('input[name=email]').val(data.email);
				formObj.find('input[name=mobile]').val(data.mobile);
				$("#uploadFile").parent('div').append('<img class="uploadImg" src="'+data.photo+'" width="80">')
				$('.bootbox,.modal-backdrop').show();
			}
		}
	});
}
function closebox() {
	$('.bootbox,.modal-backdrop').hide();
}
</script>