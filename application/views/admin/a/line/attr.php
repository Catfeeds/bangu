<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">线路属性管理</li>
		</ul>
	</div>
	<div class="page-body">
		<div class="tab-content">
			<a id="addButton" href="javascript:void(0);" class="button-default" >添加 </a>
			<form action="#" id='search_condition' class="search-form" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">名称：</span>
						<span><input class="search-input" type="text" name="name" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">属性：</span>
						<span id="search-attr"></span>
					</li>
					<li class="search-list">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox addHire modal fade in">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">线路属性管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">名称<span class="input-must">*</span></label>
							<div class="col-sm-10" >
								<input class="form-control" name="attrname" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">选择上级</label>
							<div class="col-sm-10" id="add-attr"></div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">排序</label>
							<div class="col-sm-10">
								<input class="form-control inputNumber" value="999" name="displayorder" type="text">
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
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否热门</label>
							<div class="col-sm-10">
								<select name="ishot" style="width:100%;">
									<option value="0" selected="selected">否</option>
									<option value="1" >是</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">描述</label>
							<div class="col-sm-10">
								<textarea name="description" style="width:100%;" rows="6"></textarea>
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
<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script>
var columns = [ {field : 'attrname',title : '名称',width : '150',align : 'center'},
                {field : 'parent',title : '上级',align : 'center', width : '180'},
				{field : 'displayorder',title : '排序',width : '120',align : 'center'},
				{field : false,title : '是否热门',align : 'center', width : '110',formatter:function(item){
						return item.ishot == 1 ? '是' :'否';
					}
				},
				{field : false,title : '是否启用',align : 'center', width : '110',formatter:function(item){
						return item.isopen == 1 ? '是' :'否';
					}
				},
				{field : 'description',title : '描述',width : '150',align : 'center'},
				{field : false,title : '操作',align : 'center', width : '100',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='edit("+item.id+")' class='btn btn-info btn-xs edit'>修改</a>";
				}
			}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/lines/attr/getAttrJson',
	searchForm:'#search_condition',
	pageNumNow:1
});
$.ajax({
	url:'/common/selectData/getAttrJson',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-attr').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['attrid','pid']
		});
		$('#add-attr').selectLinkage({
			jsonData:data,
			width:'100%',
			names:['pid']
		});
	}
});

//添加弹出层
$("#addButton").click(function(){
	var fromObj = $("#addFormData");
	fromObj.find('input[type=text]').val('');
	fromObj.find('input[type=hidden]').val('');
	fromObj.find('select').val(0).eq(0).next().hide();
	$("select[name=isopen]").val(1);
	$("textarea[name=description]").val('');
	$('.bootbox,.modal-backdrop').show();
})
$("#addFormData").submit(function(){
	var id = $('input[name=id]').val();
	var url = id >0 ? '/admin/a/lines/attr/edit' : '/admin/a/lines/attr/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/lines/attr/getAttrJson',
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
		url:'/admin/a/lines/attr/getAttrDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				$('input[name=id]').val(data.id);
				$('input[name=displayorder]').val(data.displayorder);
				$('textarea[name=description]').val(data.description);
				$('select[name=ishot]').val(data.ishot);
				$('select[name=isopen]').val(data.isopen);
				formObj.find('input[name=attrname]').val(data.attrname);
				formObj.find('select[name=pid]').val(data.pid);
				$('.bootbox,.modal-backdrop').show();
			}
		}
	});
}
function closebox() {
	$('.bootbox,.modal-backdrop').hide();
}
</script>