<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>礼物管理</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">礼物名称：</span>
						<span ><input class="search-input" type="text" name="name" /></span>
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
<div class="form-box fb-body">
	<div class="fb-content">
		<div class="box-title">
			<h4>礼物管理</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">礼物名称：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="name"  />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">礼物单位：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="unit" placeholder="朵，辆，架...." />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">礼物价值：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="worth" placeholder="以U币计算" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" class="showorder" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">图标：<i>*</i></div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">状态：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="status" value="0">关闭</label></li>
							<li><label><input type="radio" class="fg-radio" name="status" checked="checked" value="1">正常</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">动画效果：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="style" value="1">飞机</label></li>
							<li><label><input type="radio" class="fg-radio" name="style" value="2">跑车</label></li>
							<li><label><input type="radio" class="fg-radio" name="style" value="3">豪宅</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/jquery.extend.js"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/common.js"></script>
<script>
var animate = {1:'飞机',2:'跑车',3:'豪宅'};
//新申请
var columns = [ {field : 'gift_name',title : '礼物名称',width : '120',align : 'center'},
		{field : 'worth',title : '礼物价值',width : '140',align : 'center' },
		{field : 'unit',title : '礼物单位',width : '140',align : 'center' },
		{field : false,title : '礼物图片',width : '120',align : 'center' ,formatter:function(item){
				return '<a href="'+item.pic+'" target="_blank">预览图片</a>';
			}
		},
		{field : false,title : '礼物动画效果',width : '80',align : 'center',formatter:function(item){
				return typeof animate[item.style] == 'string' ? animate[item.style] : '无效果';
			}
		},
		{field : false,title : '状态',align : 'center', width : '100',formatter:function(item){
				return item.status == 1 ? '正常' :'关闭';
			}
		},
		{field : 'showorder',title : '排序',align : 'center', width : '60'},
		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="edit('+item.gift_id+');" class="tab-button but-blue">编辑</a>';
			button += '<a href="javascript:void(0);" onclick="del('+item.gift_id+');" class="tab-button but-red">删除</a>';
			return button;
		}
	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/live/gift/getGiftJson',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});

$('.showorder').verifNum();
//添加弹出层
$("#add-button").click(function(){
	var formObj = $("#add-data");
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=file]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find("input[name='status'][value=1]").attr("checked",true);
	formObj.find("input[name='style']").removeAttr("checked");
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
})

$("#add-data").submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id > 0 ? '/admin/a/live/gift/edit' :'/admin/a/live/gift/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/live/gift/getGiftJson',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".fb-body,.mask-box").hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

//删除
function del(id) {
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/live/gift/del",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/live/gift/getGiftJson',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		});
	}
}
//编辑
function edit(id){
	$.ajax({
		url:'/admin/a/live/gift/getDetailJson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)){
				var formObj = $("#add-data");
				formObj.find('input[name=name]').val(data.gift_name);
				formObj.find('input[name=id]').val(data.gift_id);
				formObj.find('input[name=showorder]').val(data.showorder);
				formObj.find('input[name=pic]').val(data.pic);
				formObj.find('input[name=unit]').val(data.unit);
				formObj.find('input[name=worth]').val(data.worth);
				formObj.find("input[name='status'][value="+data.status+"]").attr("checked",true);
				formObj.find("input[name='style'][value="+data.style+"]").attr("checked",true);
				$(".uploadImg").remove();
				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
				$(".fb-body,.mask-box").show();
			} else {
				alert('请确认您选择的数据');
			}
		}
	});
}
</script>
