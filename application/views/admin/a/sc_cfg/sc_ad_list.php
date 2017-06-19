<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗广告配置</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sc_cfg/sc_ad/getAdList')?>" id='search_condition' class="form-inline clear" method="post">
			<input type="hidden" name="page_new" class="page_new" />
		</form>
		<div class="dataTables_wrapper form-inline no-footer">
			<table class="table table-striped table-hover table-bordered dataTable no-footer" >
				<thead id="pagination_title"></thead>
				<tbody id="pagination_data"></tbody>
			</table>
		</div>
		<div class="pagination" id="pagination"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗广告配置</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">广告标题<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="title" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">链接地址<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="link_address" placeholder="请输入正确的链接地址 (例:/line/index?id=3)" name="link" type="text">
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
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">说明 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="description" rows="6" style="width:100%;"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">显示位置</label>
						<div class="col-sm-10">
							<select name="location" style="width:100%;">
								<option value="1">头部</option>
								<option value="2" selected="selected">中间</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否显示</label>
						<div class="col-sm-10">
							<select name="is_show" style="width:100%;">
								<option value="0">不显示</option>
								<option value="1" selected="selected">显示</option>
							</select>
						</div>
					</div>
					<!-- <div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否更改</label>
						<div class="col-sm-10">
							<select name="is_modify" style="width:100%;">
								<option value="0">可更改</option>
								<option value="1">不可更改</option>
							</select>
						</div>
					</div> -->

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
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [ {field : 'title',title : '广告标题',width : '100',align : 'center'},
        		{field : 'link',title : '链接地址',width : '150',align : 'center'},
        		{field : null,title : '显示位置',width : '150',align : 'center',formatter:function(item){
        				if(item.location==1){
        					return '头部';
        				}else{
        					return '中间';
        				}
        			}
        		},
        		{field : null ,title : '是否显示' ,width : '120' ,align : 'center',formatter:function(item){
        				if(item.is_show==0){
        					return '不显示';
        				}else{
        					return '显示';
        				}
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : null,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                   	 }
                	},
        		{field : 'description',title : '说明',align : 'center', width : '160' ,length:20},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			if (item.is_modify == 0) {
        				button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			}
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
ajaxGetData(columns ,inputId);

//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("select[name='is_show']").val(1);
	$("select[name='location']").val(1);
	$("select[name='pic']").val('');
	$("#addFormData").find("input[name='id']").val('');
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/sc_cfg/sc_ad/edit";
	} else {
		var url = "/admin/a/sc_cfg/sc_ad/add";
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
	$.post("/admin/a/sc_cfg/sc_ad/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='title']").val(data.title);
		$("input[name='link']").val(data.link);
		$("input[name='id']").val(data.id);
		$("input[name='showorder']").val(data.showorder);
		$("textarea[name='description']").val(data.description);
		$("select[name='is_show']").val(data.is_show);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/sc_ad/delete",{id:id},function(json){
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
