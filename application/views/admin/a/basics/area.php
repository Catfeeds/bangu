<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">地区管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="#" id='search_condition' class="search_condition_form" method="post">
			<input type="text" name="name" class="input_text" placeholder="地区名称" />
			<select name="ishot">
				<option value="0" selected="selected">是否热门</option>
				<option value="1">是</option>
				<option value="2">否</option>
			</select>
			<select name="isopen">
				<option value="0" selected="selected">是否启用</option>
				<option value="1">是</option>
				<option value="2">否</option>
			</select>
			<input type="submit" class="input_button" value="搜索" />
		</form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">地区管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择上级</label>
						<div class="col-sm-10 col_ts">
							<span id="addArea"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" name="name" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">全拼<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control" name="enname" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">简拼<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control" name="simplename" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="displayorder" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否启用</label>
						<div class="col-sm-10">
							<select name="isopen" style="width:100%;">
								<option value="0">否</option>
								<option value="1" selected="selected">是</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否热门 </label>
						<div class="col-sm-10">
							<select name="ishot" style="width:100%;">
								<option value="0">否</option>
								<option value="1">是</option>
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
<?php echo $this->load->view('admin/a/choice_data/choice_line.php');  ?>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/staticState/areaSelectJson.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/pinyin.js"></script>
<script>
var columns = [ {field : 'name',title : '名称',width : '180',align : 'center'},
                {field : 'enname',title : '全拼',width : '200',align : 'center'},
                {field : 'simplename',title : '简拼',width : '100',align : 'center'},
                {field : 'parent_name',title : '上级',width : '100',align : 'center'},
        		{field : false ,title : '是否启用' ,width : '100' ,align : 'center',formatter:function(item){
        				if (item.isopen == 1) return '启用'; else return '未启用';
        			}
        		},
        		{field : false,title : '是否热门',width : '100',align : 'center',formatter:function(item){
        				if (item.ishot == 1) return '是'; else return '否';
        			}
        		},
        		{field : 'displayorder',title : '排序',align : 'center', width : '80'},
        		{field : 'level',title : '等级',align : 'center', width : '100' },
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			return '<a href="javascript:void(0);" onclick="edit('+item.id+');" class="btn btn-default btn-xs purple">编辑</a>';
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/basics/area/getAreaJson',
	searchForm:'#search_condition',
});

//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[type='hidden']").val('');
	$("select[name='isopen']").val(1);
	$("select[name='ishot']").val(0);
	$("#addArea").find("select").val(0).eq(0).nextAll().hide();
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/basics/area/edit";
	} else {
		var url = "/admin/a/basics/area/add";
	}
	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			$("#dataTable").pageTable({
				columns:columns,
				url:'/admin/a/basics/area/getAreaJson',
				searchForm:'#search_condition',
				pageNumNow:1
			});
			alert(data.msg);
			$(".bootbox,.modal-backdrop").hide();
		} else {
			alert(data.msg);
		}
	})
	return false;
})

function edit(id) {
	$.ajax({
		url:'/admin/a/basics/area/getAreaDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			var formObj = $("#addFormData");
			formObj.find("input[name=name]").val(data.name);
			$('input[name=enname]').val(data.enname);
			$('input[name=simplename]').val(data.simplename);
			$('input[name=id]').val(data.id);
			$('input[name=displayorder]').val(data.displayorder);
			formObj.find('select[name=isopen]').val(data.isopen);
			formObj.find('select[name=ishot]').val(data.ishot);
			if (typeof data.city != 'undefined') {
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.city);
			} else if (typeof data.province != 'undefined'){
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').show();
			} else if (typeof data.country != 'undefined'){
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').show();
				formObj.find('select[name=city]').hide();
			}
			
			$(".bootbox,.modal-backdrop").show();
		}
	});
}
//获取地区的下拉
// $.ajax({
// 	url:'/common/selectData/getAreaAll',
// 	dataType:'json',
// 	type:'post',
// 	success:function(data){
// 		$('#addArea').selectLinkage({
// 			jsonData:data,
// 			width:'130px',
// 			names:['country','province','city']
// 		});
// 	}
// });

$('#addArea').selectLinkage({
	jsonData:selectAreaJson,
	width:'130px',
	names:['country','province','city']
});
//生成拼音
$("#addFormData").find("input[name=name]").change(function(){
	var name = $(this).val();
	var enname = pinyin.getFullChars(name).toLowerCase();
	var simplename = pinyin.getCamelChars(name).toLowerCase();
	$("input[name='simplename']").val(simplename);
	$("input[name='enname']").val(enname);
})

$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})
</script>
