<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗活动推荐目的地</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/cfg_act/activity_dest_love/getDestLoveData')?>" id='search_condition' class="search_condition_form" method="post"></form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗活动推荐目的地</h4>
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
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">目的地<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts" id="addDestForm">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" name="name" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片</label>
						<div class="col-sm-10">
							<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
							<input name="pic" type="hidden" />
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">备注</label>
						<div class="col-sm-10 col_ts">
							<textarea class="form-control" name="beizhu" id="beizhu" cols="30" rows="10"></textarea>
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
<?php echo $this->load->view('admin/a/choice_data/choice_line.php');  ?>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [
		{field : 'name',title : '名称',width : '100',align : 'center'},
		{field : 'city_name',title : '活动城市名字',width : '100',align : 'center'},
		{field : 'de_name',title : '目的地',width : '100',align : 'center'},
		{field : false,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                   	 }
                	},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg_act/activity_dest_love/getDestLoveData',
	searchForm:'#search_condition',
});

destSelect('addDestForm' ,156);
//添加数据弹出
$("#addData").click(function(){
	$("input[name='id']").val('');
	$("input[name='showorder']").val('');
	$("input[name='linename']").val('');
	$("input[name='line_id']").val('');
	$("select[name='act_city_id']").val('');
	$("select[name='act_dest_id']").val('');
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/cfg_act/activity_dest_love/edit";
	} else {
		var url = "/admin/a/cfg_act/activity_dest_love/add";
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
	$.post("/admin/a/cfg_act/activity_dest_love/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='name']").val(data.name);
		$("#beizhu").val(data.beizhu);
		$("#addFormData").find("input[name='pic']").val(data.pic);
		$("input[name='id']").val(data.id);
		$("input[name='showorder']").val(data.showorder);
		$("select[name='act_city_id']").val(data.activity_city_id);
		if (typeof data.country != 'undefined') {
			var defaultjson = {0:data.country,1:data.province,2:data.startplaceid};
			startCitySelect('addStartplace' ,156 ,defaultjson);
		} else {
			startCitySelect('addStartplace' ,156);
		}
		if (typeof data.destOne != 'undefined') {
			if (typeof data.destOne == 'object') {
				var defaultJson = {0:data.destTwo,1:data.dest_id};
			} else {
				var defaultJson = {0:data.destOne,1:data.destTwo,2:data.dest_id};
			}

			destSelect('addDestForm' ,156 ,defaultJson);
		} else {
			destSelect('addDestForm' ,156);
		}

		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_act/activity_dest_love/delete",{id:id},function(json){
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

//筛选线路
$("#ChoiceLine").click(function(){
	var destid = $("#addFormData").find("select[name='act_dest_id'] :selected").attr("data-dest");
	if (typeof destid == 'undefined' || destid < 1) {
		var destid = $("#addFormData").find("select[name='destTwo']").val();
		if (typeof destid == 'undefined' || destid < 1) {
			alert('请选择目的地');
			return false;
		}
	}
	$("input[name='line_dest']").val(destid);
	createDataHtml();
})
//确认选择线路
$(".submit_choice").click(function(){
	var actObj = $("#choiceLineBox").find(".choice_content").children(".cl_active");
	var id = actObj.attr("data-val");
	var name = actObj.attr("data-name");
	$("#addFormData").find("input[name='line_id']").val(id);
	$("#addFormData").find("input[name='linename']").val(name);
	$("#choiceLineBox").hide();
})





$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})
</script>
