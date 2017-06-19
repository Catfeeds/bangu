<style type="text/css">
	 .nav-tabs{ margin-top: 20px}
	 .form-group{margin-right: 10px;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">提现管理</li>
		</ul>
	</div>

	<!-- <div class="well with-header with-footer"> -->
		<ul id="myTab5" class="nav nav-tabs">
			<li class="active" onclick="change_nav(this);" status = '1'>
				<a href="javascript:void(0);" >新申请</a>
			</li>
			<li class="tab-red" onclick="change_nav(this);" status = '2'>
				<a href="javascript:void(0);">已通过</a>
			</li>
			<li class="tab-blue" onclick="change_nav(this);" status = '3'>
				<a href="javascript:void(0);">已拒绝</a>
			</li>
		</ul>

		<div class="tab-content">
				<form class="form-inline" id="search_condition" action="<?php echo base_url('admin/a/expert/get_exchange_data'); ?>" method="post">
					<div class="form-group dataTables_filter fl">
						<label class="sr-only"> 专家 </label> 
						<input type="text" name="search_name" class="form-control" placeholder="专家姓名" >
					</div>
					<div class="form-group fl">
						<div class="controls fl">
							<div class="input-group fl">
								<span class="input-group-addon " style=" width:40px;"> <i class="fa fa-calendar"></i>
								</span> <input type="text" class="form-control"
									onfocus="init_value(this)" id="apply_date" readonly  name="addtime"
									placeholder="申请时间"  style=" width:195px;  float:left">
							</div>
						</div>
					</div>
					<input type="hidden" name="status" value="1">
					<input type="hidden" name="page_new" value="1">
					<button type="submit" class="btn btn-darkorange">搜索</button>
				</form>
				<br/>
			<table class="table table-striped table-hover table-bordered dataTable no-footer"  aria-describedby="editabledatatable_info">
				<thead class="pagination_title"></thead>
				<!-- 提现数据 -->
				<tbody class="pagination_data"></tbody>
			</table>
			<div class="pagination"></div>
		</div>
	<!-- </div> -->
</div>

<div class="eject_body refuse_apply">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title">拒绝提现申请</div>
	<div class="eject_content">
		<form id="refuse_apply_form" method="post">
		<div class="eject_content_text">
			<div class="eject_text_name">拒绝理由:</div>
			<div class="eject_text_info"><textarea rows="5" cols="50" name="beizhu" ></textarea></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="refuse_id" />
			<div class="ex_colse">关闭</div>
			<div class="refuse_submit">确认拒绝</div>
		</div>	
		</form>
	</div>						
</div>
<div class="eject_body through_apply" style="width:30%;left:35%;">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title">通过提现申请</div>
	<div class="eject_content">
		<div class="eject_content_text">
			<div class="eject_text_name">持卡人姓名:</div>
			<div class="eject_text_info ex_cardholder" style="margin: -20px 0px 0px 170px;"></div>
			<div class="clear"></div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">可提现金额:</div>
			<div class="eject_text_info ex_amount_before" style="margin: -20px 0px 0px 170px;"></div>
			<div class="clear"></div>
		</div>
		<div class="eject_content_text" style="margin-top:50px;">
			<div class="eject_text_name">申请提现金额:</div>
			<div class="eject_text_info ex_amount" style="margin: -20px 0px 0px 170px;"></div>
			<div class="clear"></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="through_id" />
			<div class="ex_colse">关闭</div>
			<div class="through_submit">确认通过</div>
		</div>	
	</div>						
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<div id="ceshi"></div>
<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url('assets/js/admin/common.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script type="text/javascript">

//申请中
var columns1 = [ {field : 'addtime',title : '申请日期',width : '200',align : 'center'},
		{field : 'amount_before',title : '可提现金额',width : '150',align : 'center'},
		{field : 'bankcard',title : '提现卡号',width : '140',align : 'center'},
		{field : 'bankname',title : '交易类型',width : '140',align : 'center'},
		{field : 'brand',title : '提现支行',width : '140',align : 'center'},
		{field : 'cardholder',title : '持卡人',align : 'center', width : '120'},
		{field : 'amount',title : '申请提现金额',width : '140',align : 'center'},
		{field : 'realname',title : '专家名称',align : 'center', width : '120'},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="through('+item.id+')" class="btn btn-info btn-xs">通过</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="refuse('+item.id+')" class="btn btn-info btn-xs">拒绝</a>';	
			return button;
		}
	}];
//审核中
var columns2 = [ {field : 'addtime',title : '申请日期',width : '160',align : 'center'},
         {field : 'modtime',title : '完成日期',width : '160',align : 'center'},
         {field : 'serial_number',title : '流水号',width : '200',align : 'center'},
         {field : 'bankname',title : '交易类型',width : '180',align : 'center'},
         {field : 'brand',title : '提现支行',width : '140',align : 'center'},
         {field : 'amount_before',title : '可提现金额',align : 'center', width : '120'},
         {field : 'amount',title : '申请金额',align : 'center', width : '130'},
         {field : 'realname',title : '专家名称',align : 'center', width : '180'},
         {field : 'username',title : '审核人',align : 'center', width : '180'}
     ];
//已拒绝
var columns3 = [ {field : 'addtime',title : '申请日期',width : '160',align : 'center'},
         {field : 'modtime',title : '完成日期',width : '160',align : 'center'},
         {field : 'serial_number',title : '流水号',width : '200',align : 'center'},
         {field : 'bankname',title : '交易类型',width : '180',align : 'center'},
         {field : 'brand',title : '提现支行',width : '140',align : 'center'},
         {field : 'amount_before',title : '可提现金额',align : 'center', width : '120'},
         {field : 'amount',title : '申请金额',align : 'center', width : '130'},
         {field : 'realname',title : '专家名称',align : 'center', width : '180'},
         {field : 'username',title : '审核人',align : 'center', width : '180'}
     ];
//初始加载
var initial_status = $('input[name="status"]').val();
change_status(initial_status);
// $("#ceshi").pageTable({
// 	columns:columns1,
// 	url:'/admin/a/expert/get_exchange_data',
// });
//导航栏切换
function change_nav(obj) {
	$(obj).addClass('active').siblings().removeClass('active');
	$('#search_condition').find('input').val('');
	var status = $(obj).attr('status')
	$('input[name="status"]').val(status);
	$('input[name="page_new"]').val(1);
	change_status(status);
}
//搜索
$('#search_condition').submit(function(){
	var status = $('input[name="status"]').val();
	$('input[name="page_new"]').val(1);
	change_status(status);
	return false;	
})

//根据状态加载数据
function change_status(status) {
	if (status == 1) { //申请中
		get_ajax_page_data(columns1);
	} else if(status == 2) { //审核中
		get_ajax_page_data(columns2);
	} else if (status == 3) { //已拒绝 
		get_ajax_page_data(columns3);
	}
}
//通过
function through(id) {
	$.post("/admin/a/expert/get_exchange_json",{id:id},function(json) {
		if (json == false) {
			alert("请确认您选择的数据");
			return false;
		}
		var data = eval("("+json+")");
		$('.ex_cardholder').html(data.cardholder);
		$('.ex_amount_before').html(data.amount_before);
		$('.ex_amount').html(data.amount);
		$('input[name="through_id"]').val(id);
		$('.through_apply,.modal-backdrop').show();
	})
}
var ts = true;
$('.through_submit').click(function(){
	if (ts == false) {
		return false;
	} else {
		ts = false;
	}
	var status = $('input[name="status"]').val();
	var id = $('input[name="through_id"]').val();
	$.post("/admin/a/expert/through_apply",{id:id},function(json){
		ts = true;
		var data = eval('('+json+')');
		if (data.code == 2000) {
			change_status(status);
			alert(data.msg);
			$('.through_apply,.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	});
})
//拒绝
function refuse(id) {
	$('input[name="refuse_id"]').val(id);
	$('textarea[name="beizhu"]').val('');
	$('.refuse_apply,.modal-backdrop').show();
}
var rs = true;
$('.refuse_submit').click(function(){
	if (rs == false) {
		return false;
	} else {
		rs = false;
	}
	var status = $('input[name="status"]').val();
	$.post("/admin/a/expert/refused_apply" ,$('#refuse_apply_form').serialize(),function(json) {
		rs = true;
		var data = eval('('+json+')');
		if (data.code == 2000) {
			change_status(status);
			alert(data.msg);
			$('.refuse_apply,.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})

$('.ex_colse').click(function(){
	$('.refuse_apply,.modal-backdrop,.through_apply').hide();
})

 $('#apply_date').daterangepicker();

  function init_value(obj){
  	$(obj).val('');
  }
</script>