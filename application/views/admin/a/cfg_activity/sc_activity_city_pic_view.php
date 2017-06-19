<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗活动城市</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/cfg_act/sc_activity_city_pic/getPicList')?>" id='search_condition' class="search_condition_form" method="post"></form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗活动城市</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">活动城市<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<select name="act_city_id" id="act_city_id">
								<option value="">请选择</option>
								<?php foreach ($act_city_name as $k => $vl): ?>
									<option value="<?php echo $vl['id']?>"><?php echo $vl['name']?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片<span class="input-must">*</span></label>
							<div class="col-sm-10">
								<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
								<input name="pic" type="hidden" />
							</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">链接地址<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="link_address" placeholder="请输入正确的链接地址 (例:/line/index?id=3)" name="link" type="text">
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
							<select name="is_open" style="width:100%;">
								<option value="0">否</option>
								<option value="1" selected="selected">是</option>
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
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [
		{field : 'city_name',title : '活动城市名字',width : '100',align : 'center'},
        		{field : 'link',title : '链接',width : '100',align : 'center'},
        		{field : false,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                   	 }
                	},
        		{field : false,title : '是否启用',align : 'center', width : '80',formatter: function(item){
        			if(item.isopen==1){
        				return '是';
        			}else{
        				return '否';
        			}
        		}},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg_act/sc_activity_city_pic/getPicList',
	searchForm:'#search_condition',
});


//添加数据弹出
$("#addData").click(function(){
	$("input[name='link']").val('');
	$("input[name='id']").val('');
	$("input[name='showorder']").val(1);
	$("select[name='is_open']").val(1);
	$("select[name='pic']").val('');
	$("select[name='act_city_id']").val('');
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/cfg_act/sc_activity_city_pic/edit";
	} else {
		var url = "/admin/a/cfg_act/sc_activity_city_pic/add";
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
	$.post("/admin/a/cfg_act/sc_activity_city_pic/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='link']").val(data.link);
		$("input[name='id']").val(data.id);
		$("input[name='showorder']").val(data.showorder);
		$("select[name='is_open']").val(data.isopen);
		$("select[name='act_city_id']").val(data.activity_city_id);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_act/sc_activity_city_pic/delete",{id:id},function(json){
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
