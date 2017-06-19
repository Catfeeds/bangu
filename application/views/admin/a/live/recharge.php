<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>充值记录</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">会员名称：</span>
						<span ><input class="search-input" type="text" name="name" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">充值时间：</span>
						<span>
							<input type="text" id="starttime"  class="search-input" style="width:110px;" name="starttime" placeholder="开始日期" />
							<input type="text" id="endtime"  class="search-input" style="width:110px;"  name="endtime" placeholder="结束日期" />
					 	</span>
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
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script>
//新申请
var columns = [ {field : 'username',title : '会员名称',width : '120',align : 'center'},
		{field : 'money',title : '充值金额',width : '140',align : 'center' },
		{field : 'umoney',title : '价值U币',width : '120',align : 'center'},
		{field : 'pay_way',title : '充值方式',width : '80',align : 'center'},
		{field : 'serial',title : '流水号',align : 'center', width : '100'},
		{field : 'addtime',title : '支付时间',align : 'center', width : '60'}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/live/recharge/getRechargeJson',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
</script>
