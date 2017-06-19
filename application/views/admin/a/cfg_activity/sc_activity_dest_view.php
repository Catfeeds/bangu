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
		<form action="<?php echo site_url('admin/a/cfg_act/sc_activity_dest/getDestData')?>" id='search_condition' class="search_condition_form" method="post"></form>
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
							<select name="act_city_id" id="act_city_id" onchange="setStartCityID(this)">
								<option value="">请选择</option>
								<?php foreach ($act_city_name as $k => $vl): ?>
									<option value="<?php echo $vl['id']?>" data-val="<?php echo $vl['startcityid']?>"><?php echo $vl['name']?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"   name="name" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">一级分类<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<select name="kind_id" style="width:100%;">
								<option value="0">请选择</option>
								<?php
									foreach($kindData as $val) {
										echo "<option value='{$val['id']}'>{$val['name']}</option>";
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">目的地<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<span id="addDestAbroad">
								<select style="width:156px;">
								<option value="0">请选择</option>
								</select>
							</span>
							<span id="addDestDomestic" style="display:none;"></span>
							<span id="addDestTrip" style="display:none;">
								<select name="destTwo" style="width:156px;">
									<option value="0" >请选择</option>
								</select>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
						</div>
					</div>
					<div class="form-group">

						<input type="hidden" value="" name="id">
						<input type="hidden" name="start_city_id"  id="start_city_id" value="">
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
        		{field : 'ik_name',title : '类别',width : '100',align : 'center'},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg_act/sc_activity_dest/getDestData',
	searchForm:'#search_condition',
});



$("select[name='kind_id']").change(function() {
	var id = $(this).val();
	var name = $("select[name='kind_id'] :selected").text();
	var startCity = $("#start_city_id").val();
	commonChoise(name ,startCity);
});

function setStartCityID(obj){
	var startcityid = $(obj).find('option:selected').attr('data-val');
	$("#start_city_id").val(startcityid);
	$("select[name='kind_id']").val('');
	$("#addDestTrip").html('');
}

/**
 * @param name  一级分类名称
 * @param city  出发城市的id
 * @param dest_id 目的地
 * @param defaultJson 目的地的选择值
 */
function commonChoise(name ,city ,dest_id ,defaultJson) {
	if (name == '出境游') { //境外
		if ($("#addDestAbroad").find("select[name='destOne']").length == 0) {
			$("#addDestAbroad").find("select").remove();
			abroadDestSel('addDestAbroad' ,156 ,defaultJson);
		}
		$("#addDestAbroad").show().find("select").removeAttr("disabled");
		$("#addDestAbroad").siblings("span").hide().find("select").attr("disabled" ,"disabled");
	} else if (name == '国内游') { //国内
		if ($("#addDestDomestic").find("select").length == 0) {
			domesticDestSel('addDestDomestic' ,156 ,defaultJson);
		}
		$("#addDestDomestic").show().find("select").removeAttr("disabled");
		$("#addDestDomestic").siblings("span").hide().find("select").attr("disabled" ,"disabled");
 	} else if (name == '周边游') { //周边
		$("#addDestTrip").show().find("select").removeAttr("disabled");
		$("#addDestTrip").siblings("span").hide().find("select").attr("disabled" ,"disabled");
		if (typeof city == 'undefined' || city == '') {
			alert('请选择出发城市');
			return false;
		}else if(city == 0) {
			$("#addDestTrip").find("select").find("option").eq(0).nextAll().remove();
		} else {
			$.post("/admin/a/cfg/index_kind_dest/getTripDest",{city:city},function(data){
				if (data == false) {
					alert("此出发城市下没有周边游的目的地，请到周边游管理去配置");
					return false;
				} else {
					var data = eval("("+data+")");
					var html = '<select name="destTwo" style="width:156px;"><option>请选择</option>';
					if (typeof dest_id == 'undefined') {
						$.each(data ,function(key ,val){
							html += '<option value="'+val.dest_id+'">'+val.kindname+'</option>';
						})
					} else {
						$.each(data ,function(key ,val){
							if (val.dest_id == dest_id) {
								html += '<option value="'+val.dest_id+'" selected="selected">'+val.kindname+'</option>';
							} else {
								html += '<option value="'+val.dest_id+'">'+val.kindname+'</option>';
							}
						})
					}
					html += '</select>';
					$("#addDestTrip").html(html);
				}
			})
		}
	}
}

//添加数据弹出
$("#addData").click(function(){
	$("input[name='id']").val('');
	$("input[name='showorder']").val('');
	$("select[name='kind_id']").val(0);
	$("input[name='name']").val('');
	$("select[name='act_city_id']").val('');
	$("select[name='start_country']").val(0);
	$("select[name='destOne']").val(0);
	$("select[name='start_province']").remove();
	$("select[name='start_city']").remove();
	$("select[name='destTwo']").remove();
	$("#addDestAbroad").show().removeAttr("disabled").siblings().hide().attr("disabled","disabled");
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/cfg_act/sc_activity_dest/edit";
	} else {
		var url = "/admin/a/cfg_act/sc_activity_dest/add";
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
	$.post("/admin/a/cfg_act/sc_activity_dest/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='id']").val(data.id);
		$("input[name='name']").val(data.name);
		$("input[name='showorder']").val(data.showorder);
		$("select[name='act_city_id']").val(data.activity_city_id);
		$("select[name='kind_id']").val(data.index_kind_id);
		var defaultJson = {0:data.destOne ,1:data.dest_id};
		commonChoise(data.ik_name ,data.startcityid,data.dest_id ,defaultJson);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_act/sc_activity_dest/delete",{id:id},function(json){
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
	//$("#choiceLineBox").show();
	$("#searchLineData").find("select[name='start_city']").remove();
	$("#searchLineData").find("select[name='start_province']").val(0);
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
