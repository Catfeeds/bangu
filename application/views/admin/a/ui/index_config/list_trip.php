<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.col_st{ float: left; width: 83%;}
	.col_lb{float: left; width: 16%; text-align: right;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">周边游配置</li>
		</ul>
	</div>
	<div class="page-body">
		<div class="table-toolbar">
			<a href="javascript:void(0);" class="btn btn-default" onclick="add_trip();"> 添加 </a>
		</div>
        <div class="tab-content">
            <form action="<?php echo site_url('admin/a/round_trip/getRoundData')?>" id='search_condition' method="post">
				<select name=search_top_dest>
					<option value="0">请选择</option>
				</select>
				<input type="hidden" name="page_new" class="page_new" value="1">
				<button type="submit" class="btn btn-darkorange active" style="margin: -2px 0 0 30px;">搜索</button>
			</form>
			<br/>
			<div class="tab-pane active">
				<table class="table table-striped table-hover table-bordered dataTable no-footer">
					<thead class="bordered-darkorange" id="pagination_title"></thead>
					<tbody class='kind_line' id="pagination_data"></tbody>
				</table>
				<div class="pagination" id="pagination"></div>
			</div>
		</div>
	</div>
</div>
<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog" style="margin:30px auto;width:600px;">
			<div class="modal-content" style="">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">周边游配置</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="submit_form" method="post">
					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right; float:left; ">出发城市</label>
						<div class="col-sm-8 fl" id="startcity_sel" style="float:left;"></div>
					</div>
					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">邻居目的地</label>
						<div class="col-sm-8 fl" id="dest_sel"></div>
					</div>
					
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input class="btn btn-palegreen submit" value="提交" style="float: right; margin-right: 2%;" type="submit">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
	
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/common.js"></script>
<script>
	var columns = [ {field : 'cityname',title : '出发城市',width : '150',align : 'center'},
			{field : 'kindname',title : '临近目的地',width : '200',align : 'center',length:15},
			{field : null,title : '是否启用',width : '140',align : 'center',formatter:function(item){
					return openArr[item.isopen];
				}
			},
			{field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
				
				if (item.isopen == 1) {
					var button = '<a href="javascript:void(0);" onclick="disableTrip('+item.id+');" class="btn btn-default btn-xs purple">禁用</a>';
				} else if (item.isopen == 0) {
					var button = '<a href="javascript:void(0);" onclick="openTrip('+item.id+');" class="btn btn-default btn-xs purple">启用</a>';
				}
				button += '&nbsp;&nbsp;<a href="javascript:void(0);" onclick="deleteTrip('+item.id+')" class="btn btn-default btn-xs purple">删除</a>';
				return button;
			}
		}];

	//初始加载
	var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
	ajaxGetData(columns ,inputId);
	//搜索
	$('#search_condition').submit(function(){
		$('input[name="page_new"]').val(1);
		ajaxGetData(columns ,inputId);
		return false;
	})
	
	function deleteTrip(id) {
		if (confirm("删除后不可恢复，您确定删除?")) {
			$.post("/admin/a/round_trip/delete",{id:id},function(json){
				var data = eval("("+json+")");
				if (data.code == 2000) {
					alert(data.msg);
					ajaxGetData(columns ,inputId);
				} else {
					alert(data.msg);
				}
			});
		}
	} 
	function disableTrip(id) {
		$.post("/admin/a/round_trip/disableTrip",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				ajaxGetData(columns ,inputId);
			} else {
				alert(data.msg);
			}
		});
	}
	function openTrip(id) {
		$.post("/admin/a/round_trip/openTrip",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				ajaxGetData(columns ,inputId);
			} else {
				alert(data.msg);
			}
		});
	}
	//出发城市下拉
	startCitySelect("startcity_sel");
	//目的地下拉
	destSelect("dest_sel" ,120);
	function add_trip() {
		$(".modal-backdrop,.bootbox").show();
	}
	$("#submit_form").submit(function(){
		$.post("/admin/a/round_trip/addRoundTrip",$("#submit_form").serialize(),function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				$("input[name='page_new']").val(1);
				$(".modal-backdrop,.bootbox").hide();
				ajaxGetData(columns ,inputId);
			} else {
				alert(data.msg);
			}
		});
		return false;
	})
	
</script>

