<link rel="stylesheet" href="/file/common/plugins/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/file/common/plugins/kindeditor/plugins/code/prettify.css" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗首页旅游曝光台文章</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sc_cfg/sc_index_travel_article/getDataList')?>" id='search_condition' class="search_condition_form" method="post"></form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗首页旅游曝光台文章</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="title"  name="title" type="text">
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
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否显示</label>
						<div class="col-sm-10">
							<select name="is_show" style="width:100%;">
								<option value="0">不显示</option>
								<option value="1" selected="selected">显示</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">内容</label>
						<!-- <div class="col-sm-10 col_ts">
							<textarea class="form-control" name="article_content" id="article_content"></textarea>
						</div> -->
						<div class="eject_content_list">
						<div class="eject_list_row" style="width:100%;">
							<textarea class="eject_list_name" id="article_content" name="article_content" style="width:98%;height:400px;"></textarea>
						</div>
						</div>
					</div>
					<div class="form-group">
						<input type="hidden" value="" name="article_id" id="article_id">
						<input type="hidden" value="" name="article_detail_id" id="article_detail_id">
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
<!-- 编辑器 -->
<script charset="utf-8" src="/file/common/plugins/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/plugins/code/prettify.js"></script>
<script>
var columns = [
		{field : 'title',title : '名称',width : '100',align : 'center'},
        		{field : false,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                   	 }
                	},
                	{field : 'showorder',title : '排序',width : '100',align : 'center'},
                	{field : false,title : '是否显示',width : '100',align : 'center',formatter:function(item){
                		if(item.is_show==1){
                			return '是';
                		}else{
                			return '否';
                		}
                	}},
                	{field : 'username',title : '操作人',width : '100',align : 'center'},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" data-val="'+item.id+'|'+item.sd_id+'" onclick="del(this);" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/sc_cfg/sc_index_travel_article/getDataList',
	searchForm:'#search_condition',
});

 	//编辑器
KindEditor.ready(function(K){
        window.editor = K.create('#article_content');
  });

//添加数据弹出
$("#addData").click(function(){
	$("input[name='id']").val('');
	$("input[name='title']").val('');
	$("select[name='is_show']").val('');
	$("input[name='showorder']").val('');
	//$("#article_content").val('');
	$("input[name='pic']").val('');
	$(".uploadImg").remove();
	$('#article_content').html('');     //清除编辑内容
	editor.sync();
	editor.html('');
 	$('.eject_body').css('z-index','100')
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='article_id']").val();
	if (id.length > 0) {
		var url = "/admin/a/sc_cfg/sc_index_travel_article/edit";
	} else {
		var url = "/admin/a/sc_cfg/sc_index_travel_article/add";
	}
	 editor.sync();
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
	$.post("/admin/a/sc_cfg/sc_index_travel_article/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='article_id']").val(data.id);
		$("input[name='article_detail_id']").val(data.sd_id);
		$("input[name='title']").val(data.title);
		$("input[name='pic']").val(data.pic);
		$("select[name='is_show']").val(data.is_show);
		$("input[name='showorder']").val(data.showorder);
		$("#article_content").html(data.article_content);
		 editor.sync();
		editor.html(data.article_content);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	});
}
//删除
function del(obj) {
	var id_arr = $(obj).attr('data-val').split('|');
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/sc_index_travel_article/delete",{'article_id':id_arr[0],'article_detail_id':id_arr[1]},function(json){
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
