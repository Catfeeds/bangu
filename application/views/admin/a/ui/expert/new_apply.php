<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">提现管理</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

	<div class="well with-header with-footer">
		<ul id="myTab5" class="nav nav-tabs">
			<li class="active"><a
				href="<?php echo base_url(); ?>admin/a/expert/topic_list">新申请</a></li>
			<li class="tab-red"><a
				href="<?php echo base_url(); ?>admin/a/expert/passed">已审核</a></li>
			<li class="tab-blue"><a
				href="<?php echo base_url(); ?>admin/a/expert/refused">已拒绝</a></li>
		</ul>

		<div class="tab-content">
			<label>
				<form class="form-inline" role="form"
					action="<?php echo base_url(); ?>admin/a/expert/topic_list" method="get">
					<div class="form-group dataTables_filter fl">
						<label class="sr-only"> 专家 </label> <input type="text"
							onfocus="init_value(this)" name="cardholder" id="expert_name"
							class="form-control" placeholder="专家姓名" value="<?php echo $cardholder?>">
					</div>
					<div class="form-group fl">
						<div class="controls fl">
							<div class="input-group fl">
								<span class="input-group-addon " style=" width:40px;"> <i class="fa fa-calendar"></i>
								</span> <input type="text" class="form-control"
									onfocus="init_value(this)" id="apply_date" value="<?php echo $addtime?>" name="addtime"
									value="申请时间"  style=" width:195px;  float:left">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-darkorange">搜索</button>
				</form>
			</label>


			<table
				class="table table-striped table-hover table-bordered dataTable no-footer"
				id="editabledatatable" aria-describedby="editabledatatable_info">
				<thead>
					<tr role="row">
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">编号</th>
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">申请日期</th>
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 100px; text-align: center">流水号</th>
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">交易类型</th>
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">可提现金额</th>
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">申请金额</th>
						<th class="sorting_disabled" tabindex="0" rowspan="1" colspan="1"
							style="width: 120px; text-align: center">专家名称</th>
						<th class="sorting_disabled" rowspan="1" colspan="1"
							style="width: 300px; text-align: center">操作</th>
					</tr>
				</thead>
				<tbody>
						 <?php foreach ($new_apply_list as $item): ?>
							<tr>
						<td style="text-align: center"><?php echo $item['id']?></td>
						<td style="text-align: center"><?php echo $item['apply_date']?></td>
						<td style="text-align: center"><?php echo $item['serial_number']?></td>
						<td style="text-align: center"><?php echo $item['bankname']?></td>
						<td style="text-align: center"><?php echo $item['amount_before']?></td>
						<td style="text-align: center"><?php echo $item['apply_amount']?></td>
						<td style="text-align: center"><?php echo $item['expert_name']?></td>
						<td style="text-align: center"><a
							data-val="<?php echo $item['id']?>"
							class="btn btn-info btn-xs edit" onclick="show_pass_dialog(this)">
								确认
						</a> <a data-val="<?php echo $item['id']?>"
							onclick="show_refused_dialog(this)"
							class="btn btn-danger btn-xs delete">拒绝
						</a></td>
					</tr>
							<?php endforeach;?>
						</tbody>
			</table>
			<div class="pagination"><?php echo $this->page->create_page()?></div>

		</div>
	</div>

	<!-- /Page Body -->
</div>

<div id="refused_form" style="display: none;">
	<form class="form-horizontal" role="form" id="applyMoney" method="post"
		action="<?php echo site_url('admin/a/expert/refused_operation')?>">
		<div class="form-group">
			<label for="inputEmail3"
				class="col-sm-2 control-label no-padding-right">拒绝理由</label>
			<div class="col-sm-10">
				<textarea name="beizhu" id="reason"></textarea>
				<input type="hidden" class="form-control" name='apply_id'
					id="apply_id" value="">
			</div>
		</div>
		<div class="form-group">
			<input type="button" class="btn btn-palegreen bootbox-close-button "
				aria-hidden="true" type="button" value="取消"
				style="float: right; margin-right: 2%;" /> <input type='submit'
				class="btn btn-palegreen" value='提交'
				style="float: right; margin-right: 2%;" />
		</div>
	</form>
</div>


	<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">提现审核</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="nav_form" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">持卡人姓名</label>
						<div class="col-sm-10">
							<input class="form-control" disabled  name="cardholder" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">可提现金额</label>
						<div class="col-sm-10">
							<input class="form-control" disabled name="amount_before" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">申请提现金额</label>
						<div class="col-sm-10">
							<input class="form-control" disabled name="amount" type="text">
						</div>
					</div>

					<input type="hidden" value="" name="exchange_id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input id="submit_exchange" class="btn btn-palegreen submit" value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade in" style="display:none;"></div>



<!--Bootstrap Date Range Picker-->
<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script
	src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>


<script type="text/javascript">

 $('#apply_date').daterangepicker();

  function init_value(obj){
  	$(obj).val('');
  }


function show_refused_dialog(obj){
 var id = $(obj).attr('data-val');
$("#apply_id").val(id);
 bootbox.dialog({
                	message: $("#refused_form").html(),
                	title: "拒绝",

           });
}


function show_pass_dialog(obj){
	 var id = $(obj).attr('data-val');
	 $.post(
		"<?php echo site_url('admin/a/expert/get_exchange_json')?>",
		{'id':id},
		function(data) {
			data = eval('('+data+')');
			$('input[name="cardholder"]').val(data.cardholder);
			$('input[name="amount_before"]').val(data.amount_before);
			$('input[name="amount"]').val(data.amount);
			 $('input[name="exchange_id"]').val(data.id);
			$('.modal-backdrop').show();
			$('.bootbox').show();
		}
	);
}

$('.bootbox-close-button').click(function(){
	$('input[name="cardholder"]').val('');
	$('input[name="amount_before"]').val('');
	$('input[name="amount"]').val('');
	 $('input[name="exchange_id"]').val('');
	$('.modal-backdrop').hide();
	$('.bootbox').hide();
})
$('#submit_exchange').click(function(){
	id = $('input[name="exchange_id"]').val();
	$.post(
		"<?php echo site_url('admin/a/expert/pass_operation')?>",
		{'id':id},
		function (data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				window.location.reload();
			} else {
				alert(data.msg);
			}
		}
	);
})
</script>