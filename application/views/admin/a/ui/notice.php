<style>
	#search_condition .form-control{width:200px;margin-right: 15px;}
	.form-group { float:left;} 
	.col_span { margin-top:4px;}
	.bootbox-body form .form-group { float:none;}
</style>
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">消息管理</li>
		</ul>
	</div>
	<div class="page-body">
		<a id="addNotice" href="javascript:void(0);" style="margin-bottom: 10px;" class="btn btn-default">添加 </a>
		<div class="tab-content clear">
			<form action="#" id='search_condition' method="post">
				<div class="form-group">
					<span class="search_title col_span">标题:</span>
					<input type="text" class="form-control col_ip" name="title">
				</div>
				<div class="form-group">
					<span class="search_title col_span">发布时间:</span>
					<input type="text" class="form-control col_ip" placeholder="开始时间" id="starttime" name="starttime">
					<input type="text" class="form-control col_ip" placeholder="结束时间" id="endtime" name="endtime">
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
				<h4 class="modal-title">系统消息管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal clear" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">标题<span class="input-must">*</span></label>
						<div class="col-sm-10">
							<input class="form-control" name="title"  type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">内容 <span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<textarea name="content" rows="6" style="width:100%;"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">接收人<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts" id="inputChecks">
							<ul>
								<li><input name="type[]" value="1" type="checkbox">管家</li>
								<li><input name="type[]" value="2" type="checkbox">供应商</li>
								<li><input name="type[]" value="3" type="checkbox">平台</li>
							</ul>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">附件</label>
						<div class="col-sm-10 col_ts">
							<input id="uploadFile" onchange="upFile(this);" name="uploadFile" type="file">
							<input type="hidden" name="attachment">
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
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
var columns = [ {field : 'title',title : '标题',width : '150',align : 'center'},
                {field : false,title : '内容',align : 'center', width : '200',formatter:function(item){
						return item.content.length > 40 ? item.content.substring(0,40)+'...' : item.content;
					}
				},
				{field : 'addtime',title : '发布时间',width : '120',align : 'center'},
				{field : 'realname',title : '发布人',width : '120',align : 'center'},
				{field : false,title : '接收实体类型',align : 'center', width : '140',formatter:function(item){
						var typeArr = item.notice_type.split(',');
						var typeStr = '';
						$.each(typeArr ,function(key ,val) {
							if (val == 1) typeStr += '管家,'; else if(val == 2) typeStr += '供应商,'; else if(val == 3) typeStr += '平台,';
						})
						return typeStr.substring(0 ,typeStr.length-1);
					}
				},
				{field : false,title : '操作',align : 'center', width : '100',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='edit("+item.id+")' class='btn btn-info btn-xs edit'>修改</a>";;
				}
			}];
						
$("#dataTable").pageTable({
	columns:columns,
	url:'admin/a/notice/getNoticeJson',
	searchForm:'#search_condition',
	pageNumNow:1
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
function upFile(obj){
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadFile',
	    secureuri : false,
	    fileElementId : 'uploadFile',// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {fileId : 'uploadFile' ,type:'f'},
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	$('input[name=attachment]').val(data.msg);
		    	alert('上传成功');
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败');
	    }
	});
}

//添加弹出层
$("#addNotice").click(function(){
	var fromObj = $("#addFormData");
	fromObj.find('input[type=text]').val('');
	fromObj.find('input[type=hidden]').val('');
	$("textarea[name=content]").val('');
	$(".see-attachment").remove();
	$("#inputChecks").find('input[type=checkbox]').attr('checked' ,false);
	$('.bootbox,.modal-backdrop').show();
})
$("#addFormData").submit(function(){
	var id = $('input[name=id]').val();
	if (id > 0) {
		var url = '/admin/a/notice/edit';
	} else {
		var url = '/admin/a/notice/add';
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
					url:'admin/a/notice/getNoticeJson',
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
		url:'/admin/a/notice/getNoticeDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				formObj.find('input:checkbox').attr('checked',false);
				var checkArr = data.notice_type.split(',');
				$.each(checkArr ,function(key ,val){
					formObj.find('input:checkbox[value="'+val+'"]').attr('checked' ,true);
				})
				$(".see-attachment").remove();
				$('input[name=id]').val(data.id);
				$('input[name=attachment]').val(data.attachment);
				if (typeof data.attachment != 'undefined' && data.attachment.length > 1) {
					formObj.find("#uploadFile").after('<a class="see-attachment" href="'+data.attachment+'">查看附件</a>');
				}
				$('textarea[name=content]').val(data.content);
				formObj.find('input[name=title]').val(data.title);
				$('.bootbox,.modal-backdrop').show();
			}
		}
	});
}
function closebox() {
	$('.bootbox,.modal-backdrop').hide();
}
</script>