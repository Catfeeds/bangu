<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.form-group{ float: left; padding-right: 5px;margin-top: 5px;}
	 .nav-tabs{ margin-top: 20px}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="#"> 首页 </a></li>
			<li class="active">已收款管理</li>
		</ul>
	</div>

	<div class="tabbable">
		<ul id="myTab5" class="nav nav-tabs">
			<li class="active" status="0">
				<a href="javascript:void(0);">新申请</a>
			</li>
			<li class="tab-red" status="1">
				<a href="javascript:void(0);">已通过</a>
			</li>
			<li class="tab-blue" status="-1">
				<a href="javascript:void(0);">已拒绝</a>
			</li>
		</ul>
		<div class="widget-body">
			<div class="tabbable">
				<label>
					<form class="form-inline" id="search_condition" action="<?php echo site_url('admin/a/finance/get_ajax_data');?>" method="post">
						<div class="form-group dataTables_filter">
							<label class="sr-only"> 产品名称 </label> 
							<input type="text" class="form-control"  name="productname" placeholder="产品名称">
						</div>
						<div class="form-group dataTables_filter">
							<label class="sr-only"> 订单编号 </label> 
							<input type="text" class="form-control"  name="ordersn" placeholder="订单编号">
						</div>
						<div class="form-group dataTables_filter">
							<label class="sr-only"> 申请人 </label> 
							<input type="text" class="form-control"  name="truename" placeholder="申请人">
						</div>
						<div class="form-group">
							<div class="controls">
								<div class="input-group">
								<span class="input-group-addon">  <i class="fa fa-calendar"></i> </span> 
								<input type="text" class="form-control" id="reservation2" name="time" >
							 	</div>
							</div>
						</div>
						<input type="hidden" name="page_new" value="1">
						<input type='hidden' name='status' value='0'>
						<button style="margin-top:5px;" type="submit" class="btn btn-default" style="float:left;">搜索</button>
					</form>
				</label>
				<table class="table table-striped table-bordered table-hover dataTable no-footer">
					<thead class="bordered-darkorange pagination_title"></thead>
					<tbody class="pagination_data"> </tbody>
				</table>
				<br/>
				<div class="pagination"></div>
			</div>
		</div>
	</div>

</div>
						
<!-- 弹出层 开始-->
<div class="eject_body">
	<div class="eject_colse">X</div>
	<div class="eject_title">收款登记</div>
	<div class="eject_content">
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">流水号:</div>
				<div class="content_info eject_receipt"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">订单编号:</div>
				<div class="content_info eject_ordersn"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">收款日期:</div>
				<div class="content_info eject_addtime"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">收款金额:</div>
				<div class="content_info eject_amount"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">打款银行:</div>
				<div class="content_info eject_bankname"></div>
			</div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">说明:</div>
			<div class="eject_text_info"><textarea rows="5" cols="50" class="eject_beizhu" disabled></textarea></div>
		</div>
		<div class="eject_content_text">
			<div class="eject_text_name">审批意见:</div>
			<div class="eject_text_info"><textarea rows="5" cols="50" name="refuse_reason"></textarea></div>
		</div>
			<div class="eject_content_text">
			<div class="eject_text_name">流水单扫描件:</div>
			<img src="" id="eject_img"></img>
		</div>
	</div>	
	<div class="eject_botton">
		<input type="hidden" value="" name="id">
		<div class="eject_fefuse">拒绝</div>
		<div class="eject_through">通过</div>
		
	</div>					
</div>							
<!-- 弹出层结束 -->
<div class="modal-backdrop fade in" style="display: none;"></div>
<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
//审核中
var columns1 = [ {field : 'receipt',title : '流水号',width : '120',align : 'center'},
        {field : 'ordersn',title : '订单编号',width : '120',align : 'center'},
		{field : 'productname',title : '产品名称',width : '200',align : 'center',length:20},
		{field : 'cityname',title : '出发地',align : 'center', width : '120'},
		{field : 'addtime',title : '付款时间',width : '150',align : 'left'},
		{field : 'amount',title : '收款金额',width : '120',align : 'center'},
		{field : null,title : '会员',align : 'center', width : '120',formatter:function(item){
				if (typeof item.truename == 'object' || item.truename.length == 0) {
					if (typeof item.tel != 'object') {
						return item.tel.substring(0,3)+'xxxx'+item.tel.substring(7,11);
					} else {
						return '';
					}
				} else {
					return item.truename;
				}
			}
		},
		{field : 'supplier_name',title : '供应商',width : '180',align : 'left'},
		{field : 'expert_name',title : '专家',width : '120',align : 'center'},
		{field : 'beizhu',title : '申请备注',align : 'center', width : '200',lenght:15},
		{field : null,title : '操作',align : 'center', width : '80',formatter: function(item){
			return '<a href="javascript:void(0)" onclick="see_info('+item.id+');" class="btn btn-default btn-xs purple">审核</a>';
		}
	}];

//已通过
var columns2 = [ {field : 'receipt',title : '流水号',width : '120',align : 'center'},
        {field : 'ordersn',title : '订单编号',width : '120',align : 'center'},
		{field : 'productname',title : '产品名称',width : '200',align : 'center',length:20},
		{field : 'cityname',title : '出发地',align : 'center', width : '120'},
		{field : 'addtime',title : '审批时间',width : '150',align : 'left'},
		{field : 'amount',title : '收款金额',width : '120',align : 'center'},
		{field : null,title : '会员',align : 'center', width : '120',formatter:function(item){
				if (typeof item.truename == 'object' || item.truename.length == 0) {
					if (typeof item.tel != 'object') {
						return item.tel.substring(0,3)+'xxxx'+item.tel.substring(7,11);
					} else {
						return '';
					}
				} else {
					return item.truename;
				}
			}
		},
		{field : 'supplier_name',title : '供应商',width : '180',align : 'left'},
		{field : 'expert_name',title : '专家',width : '120',align : 'center'},
		{field : 'refuse_reason',title : '审批备注',align : 'center', width : '200',lenght:15},
		{field : 'username',title : '审批人',align : 'center', width : '100'}
	];
//已拒绝
var columns3 = [ {field : 'receipt',title : '流水号',width : '120',align : 'center'},
        {field : 'ordersn',title : '订单编号',width : '120',align : 'center'},
		{field : 'productname',title : '产品名称',width : '200',align : 'center',length:20},
		{field : 'cityname',title : '出发地',align : 'center', width : '120'},
		{field : 'addtime',title : '审批时间',width : '150',align : 'left'},
		{field : 'amount',title : '收款金额',width : '120',align : 'center'},
		{field : null,title : '会员',align : 'center', width : '120',formatter:function(item){
				if (typeof item.truename == 'object' || item.truename.length == 0) {
					if (typeof item.tel != 'object') {
						return item.tel.substring(0,3)+'xxxx'+item.tel.substring(7,11);
					} else {
						return '';
					}
				} else {
					return item.truename;
				}
			}
		},
		{field : 'supplier_name',title : '供应商',width : '180',align : 'left'},
		{field : 'expert_name',title : '专家',width : '120',align : 'center'},
		{field : 'refuse_reason',title : '拒绝原因',align : 'center', width : '200',lenght:15},
		{field : 'username',title : '审批人',align : 'center', width : '100'}
	];
//导航切换
$('.nav-tabs li').click(function(){
	$('#search_condition').find('input').val('');
	var status = $(this).attr('status');
	$(this).addClass('active').siblings().removeClass('active');
	$('input[name="status"]').val(status);
	$('input[name="page_new"]').val(1);
	change_status(status);
})

//初始加载
var initial_status = $('input[name="status"]').val();
change_status(initial_status);

//搜索
$('#search_condition').submit(function(){
	var status = $('input[name="status"]').val();
	$('input[name="page_new"]').val(1);
	change_status(status);
	return false;	
})

//根据状态加载数据
function change_status(status) {

	if (status == 0) { 
		get_ajax_page_data(columns1);
	} else if(status == 1) { 
		get_ajax_page_data(columns2);
	} else if (status == -1) { 
		get_ajax_page_data(columns3);
	}
}
	//查看付款详情
	function see_info(id) {
		$.post(
			"<?php echo site_url('admin/a/finance/get_one_json')?>",
			{'id':id},
			function(data) {
				if (data.lenght == 0) {
					alert('请确认您的选择');
					return false;
				}
				data = eval('('+data+')');
				$('input[name="id"]').val(data.id);
				$('.eject_receipt').html(data.receipt);
				$('.eject_ordersn').html(data.ordersn);
				$('.eject_addtime').html(data.addtime);
				$('.eject_amount').html(data.amount);
				$('.eject_bankname').html(data.bankname);
				$('.eject_beizhu').html(data.beizhu);
				$('img[id="eject_img"]').attr('src',data.receipt_pic); 
				$('.modal-backdrop').show();
				$('.eject_body').show();
			}
		);
	}
	$('.eject_colse').click(function(){
		$('.modal-backdrop').hide();
		$('.eject_body').hide();
	})
	/*通过审核*/
	var s = true;
	$('.eject_through').click(function(){
		if(s == false) {
			return false;
		} else {
			s = false;
		}
		var id = $('input[name="id"]').val();
		var refuse_reason = $('textarea[name="refuse_reason"]').val();
		var status = $('input[name="status"]').val();
		$.post(
			"<?php echo site_url('admin/a/finance/finance_through')?>",
			{'id':id,'refuse_reason':refuse_reason},
			function(data) {
				s = true;
				data = eval('('+data+')');
				if (data.code == 2000) {
					alert(data.msg);
					change_status(status);
					$('.modal-backdrop,.eject_body').hide();
				} else {
					alert(data.msg);
				}
			}
		);
	})
	/*审批拒绝*/
	var i = true;
	$('.eject_fefuse').click(function(){
		if(i == false) {
			return false;
		} else {
			i = false;
		}
		var id = $('input[name="id"]').val();
		var refuse_reason = $('textarea[name="refuse_reason"]').val();
		var status = $('input[name="status"]').val();
		$.post(
			"<?php echo site_url('admin/a/finance/finance_refuse')?>",
			{'id':id,'refuse_reason':refuse_reason},
			function(data) {
				i = true;
				data = eval('('+data+')');
				if (data.code == 2000) {
					alert(data.msg);
					change_status(status);
					$('.modal-backdrop,.eject_body').hide();
				} else {
					alert(data.msg);
				}
			}
		);
	})
</script>