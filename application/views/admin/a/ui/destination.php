<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style>
	#upload-img{
		border: 1px solid #ccc;
		padding: 3px;
		width: 70px;
		text-align: center;
		border-radius: 3px;
		cursor: pointer;
		margin: 0px 20px 10px 0px;
	}
</style>

<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active header_name">目的地管理</li>
		</ul>
	</div>
	<div class="page-body">
		<div class="tab-content">
			<a id="addNotice" href="javascript:void(0);" class="button-default" >添加 </a>
			<form action="#" id='search_condition' class="search-form" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">名称：</span>
						<span ><input class="search-input" type="text" name="kindname" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">目的地：</span>
						<span id="search-dest"></span>
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
<div style="display: none; position: absolute; z-index: 1041; overflow: visible;" class="bootbox addHire modal fade in">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button bc_close close colseBox" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">目的地管理</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post" action="#">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">选择上级<span class="input-must">*</span></label>
							<div class="col-sm-10" id="add-dest"></div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">名称<span class="input-must">*</span></label>
							<div class="col-sm-10" >
								<input class="form-control" name="kindname" type="text">
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
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片</label>
							<div class="col-sm-10">
								<div id="upload-img">上传图片</div>
								<input type="hidden" name="pic" >
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
<div id="xiuxiu_box" class="xiuxiu_box"></div>
<div class="avatar_box" style="z-index: 1050;"></div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/pinyin.js"></script>
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script>
var columns = [ {field : 'kindname',title : '名称',width : '150',align : 'center'},
                {field : 'enname',title : '全拼',align : 'center', width : '180'},
				{field : 'simplename',title : '简拼',width : '120',align : 'center'},
				{field : 'parent',title : '上级',width : '150',align : 'center'},
				{field : 'displayorder',title : '排序',width : '120',align : 'center'},
				{field : 'description',title : '描述',width : '150',align : 'center'},
				{field : false,title : '是否热门',align : 'center', width : '110',formatter:function(item){
						return item.ishot == 1 ? '是' :'否';
					}
				},
				{field : false,title : '是否启用',align : 'center', width : '110',formatter:function(item){
						return item.isopen == 1 ? '是' :'否';
					}
				},
				{field : false,title : '操作',align : 'center', width : '100',formatter: function(item) {
					return "<a href='javascript:void(0);' onclick='edit("+item.id+")' class='btn btn-info btn-xs edit'>修改</a>";
				}
			}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/destination/getDestinationJson',
	searchForm:'#search_condition',
	pageNumNow:1
});
$.ajax({
	url:'/common/selectData/getDestAll',
	dataType:'json',
	type:'post',
	data:{level:4},
	success:function(data){
		$('#search-dest').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city' ,'region']
		});
		$('#add-dest').selectLinkage({
			jsonData:data,
			width:'150px',
			names:['country','province','city']
		});
	}
});

//添加弹出层
$("#addNotice").click(function(){
	var fromObj = $("#addFormData");
	fromObj.find('input[type=text]').val('');
	fromObj.find('input[type=hidden]').val('');
	fromObj.find('select').val(0).eq(0).nextAll().hide();
	$('#upload-img').next('img').remove();
	$("select[name=isopen]").val(1);
	$("textarea[name=description]").val('');
	$('.bootbox,.modal-backdrop').show();
})
//生成拼音
$("#addFormData").find("input[name=kindname]").keyup(function(){
	var name = $(this).val();
	var enname = pinyin.getFullChars(name).toLowerCase();
	var simplename = pinyin.getCamelChars(name).toLowerCase();
	$("input[name='simplename']").val(simplename);
	$("input[name='enname']").val(enname);
})
$("#addFormData").submit(function(){
	var id = $('input[name=id]').val();
	var url = id >0 ? '/admin/a/destination/edit' : '/admin/a/destination/add';
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/destination/getDestinationJson',
					searchForm:'#search_condition',
					pageNumNow:1,
					pageNumNow:page
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
		url:'/admin/a/destination/getDestDetail',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				$('input[name=id]').val(data.id);
				$('input[name=enname]').val(data.enname);
				$('input[name=simplename]').val(data.simplename);
				$('input[name=displayorder]').val(data.displayorder);
				$('input[name=pic]').val(data.pic);
				$('#upload-img').next('img').remove();
				if (typeof data.pic == 'string' && data.pic.length > 1) {
					$('#upload-img').after('<img src="'+data.pic+'" style="width: 100px;">');
				}
				$('textarea[name=description]').val(data.description);
				$('select[name=ishot]').val(data.ishot);
				$('select[name=isopen]').val(data.isopen);
				formObj.find('input[name=kindname]').val(data.kindname);
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.city);
				$('.bootbox,.modal-backdrop').show();
			}
		}
	});
}
function closebox() {
	$('.bootbox,.modal-backdrop').hide();
}

$('#upload-img').click(function(){
	xiuxiu.setLaunchVars('cropPresets', '347*480');
	xiuxiu.embedSWF('xiuxiu_box',5,'100%','100%','xiuxiuEditor');
	xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu')?>");
    xiuxiu.setUploadType(2);
    xiuxiu.setUploadDataFieldName('uploadFile');
	xiuxiu.onInit = function ()
	{
		xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
	}
	xiuxiu.onUploadResponse = function (data)
	{
		data = eval('('+data+')');
		if (data.code == 2000) {
			$('input[name=pic]').val(data.msg);
			if ($('#upload-img').next('img').length) {
				$('#upload-img').next('img').attr('src' ,data.msg);
			} else {
				$('#upload-img').after('<img src="'+data.msg+'" style="width: 100px;">');
			}
			$("#xiuxiuEditor,.avatar_box").hide();		
		} else {
			alert(data.msg);
		}
	}
	$('#xiuxiuEditor').css({'width':'1000px' ,'height':'700px','position':'absolute'});
	$("#xiuxiuEditor,.avatar_box").show();
})
$(document).mouseup(function(e) {
	var _con = $('#xiuxiuEditor');
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
    	$("#xiuxiuEditor,.avatar_box").hide();
	}
})
</script>