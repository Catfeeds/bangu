<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>景点评论管理</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">景点名称：</span>
						<span><input type="text" class="search-input" name="name" placeholder="景点名称"></span>
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
<div class="detail-box" >
	<div class="db-body">
		<div class="db-title">
			<h4>评论详细</h4>
			<div class="db-close fb-close">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-row">
					<div class="db-row-title">评论图片：</div>
					<div class="db-row-content pic-lists">
						<img src="/file/c/expert_receipt_img_1450688488.jpg" />
					</div>
				</li>
				<li class="db-row">
					<div class="db-row-title">评论内容：</div>
					<div class="db-row-content review-content">aseraweawerw</div>
				</li>
			</ul>
			<div class="db-buttons">
				<div class="fb-close">关闭</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script>
var columns = [ {field : 'name',title : '景点名称',width : '180',align : 'center'},
		{field : 'nickname',title : '会员名称',width : '140',align : 'center'},
		{field : null,title : '评论内容',width : '180',align : 'center',formatter:function(item){
				return item.content+'...';
			}
		},
		{field : 'praise',title : '赞的数量',width : '120',align : 'center'},
		{field : 'addtime',title : '评论时间',width : '120',align : 'center'},
		{field : null,title : '操作',align : 'center', width : '170',formatter: function(item){
			var button =  '<a href="javascript:void(0);" onclick="see('+item.id+')" class="tab-button but-blue">查看内容</a>&nbsp;';
			return button += '<a href="javascript:void(0);" onclick="del('+item.id+')" class="tab-button but-red">删除</a>&nbsp;';
		}
	}];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/scenic/review/getReviewData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});

function del(id) {
	if (confirm('您确定要删除此评论吗？')) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/scenic/review/delete',
			data:{id:id},
			dataType:'json',
			type:'post',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns,
						url:'/admin/a/scenic/review/getReviewData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}

function see(id) {
	$.ajax({
		url:'/admin/a/scenic/review/getContent',
		data:{id:id},
		type:'post',
		dataType:'json',
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('数据错误');
			} else {
				$('.review-content').html(data.content);
				var picStr = '';
				if (!$.isEmptyObject(data.picArr)) {
					$.each(data.picArr ,function(k ,val) {
						picStr += '<img src="'+val.pic+'" />';
					})
					$('.pic-lists').html(picStr).parent().show();
				} else {
					$('.pic-lists').html(picStr).parent().hide();
				}
				$('.detail-box,.mask-box').fadeIn(500);
			}
		}
	});
}
</script>									

