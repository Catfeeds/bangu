<div class="page-content" style="min-width:initial;">
	<div class="page-body">
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">供应商名称：</span>
						<span ><input class="search-input" type="text" name="supplier_name" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">供应商品牌：</span>
						<span ><input class="search-input" type="text" name="brand" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">手机号：</span>
						<span ><input class="search-input" type="text" name="mobile" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">邮箱号：</span>
						<span ><input class="search-input" type="text" name="email" /></span>
					</li>
					<li class="search-list">
						<input type="hidden" value="2" name="status">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript">
var columns = [ {field : 'company_name',title : '供应商',width : '150',align : 'center'},
			{field : 'brand',title : '品牌名称',width : '100',align : 'center'},
			{field : 'realname',title : '负责人',width : '100',align : 'center'},
			{field : 'mobile',title : '联系电话',width : '120',align : 'center'},
			{field : 'email',title : '电子邮箱',width : '120',align : 'center'},
			{field : false,title : '操作',align : 'center', width : '80',formatter: function(item){
					return '<a href="javascript:void(0);" onclick="confirm_bind('+item.id+' ,<?php echo $id;?>)" class="tab-button but-blue">绑定</a>';
				}
			}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/supplier/getSupplierData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});

function confirm_bind(supplier_id ,expert_id) {
	$.ajax({
		url:'/admin/a/experts/expert_list/confirm_bind',
		data:{supplier_id:supplier_id ,expert_id:expert_id},
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				layer.confirm(result.msg, {btn:['确认']},function(){
					parent[0].getData();
					t33_close_iframe_noreload();
				});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
}
</script>