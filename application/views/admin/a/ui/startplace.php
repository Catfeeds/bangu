<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">出发城市管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="#" class="form-inline clear" id='search_condition' method="post">
			<div class="form-group dataTables_filter" id="search-city">
				
			</div>
			<div class="form-group dataTables_filter">
				<select name="isopen">
					<option value="0">是否启用</option>
					<option value="1">已启用</option>
					<option value="2">未启用</option>
				</select>
			</div>
			<input type="submit" value="搜索" class="btn btn-darkorange active" />
		</form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox addHire modal fade in" id="addStartplace">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">出发城市管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">选择上级<span class="input-must">*</span></label>
							<div class="col-sm-10" id="add_start">
								
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">选择城市<span class="input-must">*</span></label>
							<div class="col-sm-10" id="add-area">
								
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">全拼</label>
							<div class="col-sm-10">
								<input class="form-control" value="999" name="enname" type="text">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">简拼</label>
							<div class="col-sm-10">
								<input class="form-control" value="999" name="simplename" type="text">
							</div>
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
<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox addHire modal fade in" id="startplaceChild">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">子站点管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addStartChild" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">当前站点:</label>
							<div class="col-sm-10" id="have-child" style="margin-top: 7px;">
								
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">选择站点:</label>
							<div class="col-sm-10" id="choice-child">
								
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">已有站点:</label>
							<div class="col-sm-10" id="childButton" style="margin-top: 5px;">
							</div>
						</div>
						<div class="form-group">
							<input type="hidden" name="startid" >
							<input class="btn btn-palegreen bootbox-close-button colseBox" value="取消" style="float: right; margin-right: 2%;" type="button"> 
							<input class="btn btn-palegreen" value="提交" style="float: right; margin-right: 2%;" type="submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="seeChild"></div>
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/pinyin.js"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.detailbox.js") ;?>"></script>
<script>
function editChild(obj) {
	$("#have-child").html($(obj).attr('data-name'));
	$.ajax({
		url:'/admin/a/startplace/getChildStart',
		dataType:'json',
		type:'post',
		data:{id:$(obj).attr('data-val')},
		success:function(data) {
			var child = '';
			if (!$.isEmptyObject(data)) {
				$.each(data, function(key ,val){
					child += '<span data-val="'+val.id+'">'+val.cityname+'<i onclick="deleteChild(this);">x</i></span>';
				});
			}
			$("#childButton").html(child);
			$("input[name=startid]").val($(obj).attr('data-val'));
			$("#choice-child").find("select").val(0).eq(0).nextAll().hide();
			$("#startplaceChild,.modal-backdrop").show();
		}
	});
}
function deleteChild(obj) {
	$("#choice-child").find("select[name=city]").val(0);
	$(obj).parent().remove();
}
$("#addStartChild").submit(function(){
	var buttonObj = $("#childButton");
// 	if (buttonObj.find('span').length < 1) {
// 		alert('请选择子站点');
// 	} else {
		var childId = '';
		$.each($("#childButton").find('span') ,function(){
			childId += $(this).attr('data-val')+',';
		})
		$.ajax({
			url:'/admin/a/startplace/updateChild',
			type:'post',
			dataType:'json',
			data:{ids:childId,startid:$(this).find('input[name=startid]').val()},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns,
						url:'/admin/a/startplace/getStartplaceJson',
						searchForm:'#search_condition',
						pageNumNow:1
					});
					alert(data.msg);
					$("#startplaceChild,.modal-backdrop").hide();
				} else {
					alert(data.msg);
				}
			}
		});
// 	}
	return false;
})

var columns = [ {field : 'cityname',title : '城市名',width : '100',align : 'center'},
		{field : 'enname',title : '全拼',width : '100',align : 'center'},
		{field : 'simplename' ,title : '简拼' ,width : '150' ,align : 'center'},
		{field : 'displayorder',title : '排序',width : '140',align : 'center'},
		{field : 'parent',title : '上级名称',width : '140',align : 'center'},
		{field : false,title : '是否热门',align : 'center', width : '160',formatter:function(item){
				return item.ishot == 1 ? '是' : '否';
			}
		},
		{field : false,title : '是否启用',align : 'center', width : '160',formatter:function(item){
				return item.isopen == 1 ? '已启用' : '未启用';
			}
		},
		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
			if (item.level == 3) {
				button += '<a href="javascript:void(0);" data-val="'+item.id+'" data-name="'+item.cityname+'" onclick="seeChild(this);" class="btn btn-default btn-xs purple">查看子站点</a>&nbsp;';
				button += '<a href="javascript:void(0);" data-val="'+item.id+'" data-name="'+item.cityname+'" onclick="editChild(this);" class="btn btn-default btn-xs purple">编辑子站点</a>';
			}
			return button;
		}
	}];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/startplace/getStartplaceJson',
	searchForm:'#search_condition',
	pageNumNow:1
});

$.ajax({
	url:'/common/selectData/getStartplaceJson',
	dataType:'json',
	type:'post',
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'100px',
			names:['country','province','city']
		});
		$('#add_start').selectLinkage({
			jsonData:data,
			width:'150px',
			names:['start_country','start_province']
		});
		$('#choice-child').selectLinkage({
			jsonData:data,
			width:'150px',
			names:['country','province','city'],
			callback:function(obj){
				if ($(obj).attr('name') == 'city') {
					if (name == '请选择') {
						return false;
					}
					var name = $(obj).find('option:selected').text();
					var id = $(obj).val();
					var buttonObj = $("#childButton");
					var s = true;
					$.each(buttonObj.find('span') ,function(){
						if (id == $(this).attr('data-val')) {
							s = false;
						}
					})
					if (s == false) {
						alert('此站点已存在');
						return false;
					}
					var html = '<span data-val="'+id+'">'+name+'<i onclick="deleteChild(this);">x</i></span>';
					buttonObj.append(html);
				}
			}
		});
	}
});
$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#add-area').selectLinkage({
			jsonData:data,
			width:'150px',
			names:['country','province','city'],
			callback:function(obj){
					var name = $(obj).find(':selected').text();
					if (name == '请选择') {
						if ($(obj).prev('select').length > 0) {
							var name = $(obj).prev('select').find(':selected').text();
						} else {
							$("input[name='simplename']").val('');
							$("input[name='enname']").val('');
							return false;
						}
					}
					var enname = pinyin.getFullChars(name).toLowerCase();
					var simplename = pinyin.getCamelChars(name).toLowerCase();
					$("input[name='simplename']").val(simplename);
					$("input[name='enname']").val(enname);
				}
		});
	}
});

//添加数据弹出
$("#addData").click(function(){
	var formObj = $("#addFormData");
	formObj.find("input[type='text']").val('');
	formObj.find("input[type='hidden']").val('');
	formObj.find("#add_start").find("select").val(0).eq(0).nextAll('select').hide();
	formObj.find("#add-area").find("select").val(0).eq(0).nextAll('select').hide();
	$("#addStartplace,.modal-backdrop").show();
})

$("#addFormData").submit(function(){
	var id = $("#addFormData").find("input[name='id']").val();
	if (id > 0) {
		var url = "/admin/a/startplace/edit";
	} else {
		var url = "/admin/a/startplace/add";
	}
	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			$("#dataTable").pageTable({
				columns:columns,
				url:'/admin/a/startplace/getStartplaceJson',
				searchForm:'#search_condition',
				pageNumNow:1
			});
			alert(data.msg);
			$("#addStartplace,.modal-backdrop").hide();
		} else {
			alert(data.msg);
		}
	})
	return false;
})

function edit(id) {
	var formObj = $("#addFormData");
	$.ajax({
		url:'/admin/a/startplace/getStartDetail',
		dataType:'json',
		data:{id:id},
		type:'post',
		success:function(data){
			if (!$.isEmptyObject(data)){
				formObj.find("#add_start").find("select").val(0).eq(0).nextAll('select').hide();
				formObj.find("#add-area").find("select").val(0).eq(0).nextAll('select').hide();
				$("input[name='displayorder']").val(data.displayorder);
				$("input[name='id']").val(data.id);
				$("input[name='enname']").val(data.enname);
				$("input[name='simplename']").val(data.simplename);
				$("select[name='isopen']").val(data.isopen);
				$("select[name='ishot']").val(data.ishot);
				formObj.find("#add_start").find("select[name=start_country]").val(data.start_country).change();
				if (typeof data.start_province != 'undefined') {
					formObj.find("#add_start").find("select[name=start_province]").val(data.start_province);
				}
				formObj.find("#add-area").find("select[name=country]").val(data.country).change();
				if (typeof data.province != 'undefined') {
					formObj.find("#add-area").find("select[name=province]").val(data.province).change();
				}
				if (typeof data.city != 'undefined') {
					formObj.find("#add-area").find("select[name=city]").val(data.city);
				}
				$("#addStartplace,.modal-backdrop").show();
			} else {
				alert('数据错误');
			}
		}
	});
}
function seeChild(obj) {
	var name = $(obj).attr('data-name');
	$.ajax({
		url:'/admin/a/startplace/getChildStart',
		dataType:'json',
		type:'post',
		data:{id:$(obj).attr('data-val')},
		success:function(data) {
			var child = '';
			if (!$.isEmptyObject(data)) {
				$.each(data, function(key ,val){
					child += val.cityname+'&nbsp;&nbsp;';
				});
			}
			var customize = {
					"当前站点":{content:name},
					"子站点":{content:child}
				};
			$("#seeChild").detailbox({
				data:customize,
				titleName:"查看子站点"
			});
		}
	});
}

</script>
