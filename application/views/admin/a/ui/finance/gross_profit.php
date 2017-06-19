<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
	input{ padding:6px 2px; margin-bottom: 8px;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">毛利统计</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<ul id="myTab" class="nav nav-tabs tabs-flat">
						<li  name="tabs" class="active"><a href="<?php echo base_url('admin/a/gross_profit');?>" id="tab0">毛利统计</a></li>
					</ul>
				   <div class="tab-content">

					<div class="tab-pane active" id="tab_content0"><!--已提交:数据开始-->
						<div class="gross_profit_list1">
						<form action="<?php echo base_url();?>admin/a/gross_profit/get_ajax_data" id='gross_profit1' name='gross_profit1' method="post">
								<!-- 其他搜索条件,放在form 里面就可以了 -->
						产品名称:<input type="text"  id="productname" name="productname" class="search_input"/>
						订单编号:<input type="text"  id="order_sn" name="order_sn" class="search_input"/>
						出团日期:<input type="text"  id="use_date" name="use_date"  class="search_input"/>
						管家:<input class="search_input" type="text" id="expert" name="realname" />
						<button type="button" class="btn btn-darkorange active" id="searchBtn" style="margin-left: 2%;">
				        			搜索
				    		</button>
						<div id="gross_profit_dataTable1"><!--列表数据显示位置--></div>
						<div class="row DTTTFooter">
						<div class="col-sm-6" >
							<div class="dataTables_info" id="editabledatatable_info">
								第
								<span class='pageNum'>0</span> /
								<span class='totalPages'>0</span> 页 ,
								<span class='totalRecords'>0</span>条记录,每页
								<label>
									<select name="pageSize" id='gross_profit_Select'
										class="form-control input-sm" >
										<option value="">
											--请选择--
										</option>
										<option value="5">
											5
										</option>
										<option value="10">
											10
										</option>
										<option value="15">
											15
										</option>
										<option value="20">
											20
										</option>
									</select>
								</label>
								条记录
							</div>
						</div>
							<div class="col-sm-6">
								<div class="dataTables_paginate paging_bootstrap">
									<!-- 分页的按钮存放 -->
									<ul class="pagination"> </ul>
								</div>
							</div>
						</div>
						</form>
						</div>
					</div><!--数据结束-->
					</div>

			</div>
		</div>
	</div>
	<!-- /Page Body -->
</div>

<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	// 列数据映射配置
	var gross_profit_columns=[
			{field : 'usedate',title : '出团日期',width : '130',align : 'center'},
			{field : 'ordersn',title : '订单编号',width : '100',align : 'center'},
			{field : 'order_name',title : '订单名称',align : 'left', width : '460'},
			{field : 'total_price',title : '应收客人款',align : 'center', width : '150'},
			{field : 'cost',title : '应付供应商款',align : 'center', width : '150'},
			{field : 'gross_profit',title : '平台管理费',align : 'center', width : '150'},
			{field : 'yishou',title : '已收客人款',align : 'center', width : '150'},
			{field : 'zhekou',title : '抵扣',align : 'center', width : '150'},
			{field : 'expert_name',title : '管家',align : 'center', width : '150'},
			{field : 'agent_fee',title : '管家佣金',align : 'center', width : '150'}
			];

	var isJsonp= false ;// 是否JSONP,跨域
	initTableForm("#gross_profit1","#gross_profit_dataTable1",gross_profit_columns,isJsonp ).load();
	$('#gross_profit_Select').change(function(){
		initTableForm("#gross_profit1","#gross_profit_dataTable1",gross_profit_columns,isJsonp ).load();
	});
	$("#searchBtn").click(function(){
		initTableForm("#gross_profit1","#gross_profit_dataTable1",gross_profit_columns,isJsonp ).load();
	});
});
$('#use_date').daterangepicker();
//管家名字
$.post('/admin/a/comboBox/get_expert_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.realname,
		    value : val.id,
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#expert",
	    name : "expert_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
</script>