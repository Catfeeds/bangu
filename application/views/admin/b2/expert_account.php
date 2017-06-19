
<form class="form-horizontal" role="form"
	action="<?php echo site_url('admin/index.php/b2/expert/exchange_add')?>"
	method="post">

	<div class="form-group">
		<label for="inputCash" class="col-sm-2 control-label no-padding-right">当前账户资金</label>
		<div class="col-sm-10">
			<input type="text" id="inputCash" class="form-control"
				value="<?php echo $expert_info['amount']?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputMoney"
			class="col-sm-2 control-label no-padding-right">申请提现金额</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputMoney" name="amount">
		</div>
	</div>
	<div class="form-group">
		<label for="inputCard" class="col-sm-2 control-label no-padding-right">银行卡号</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputCard"
				value="<?php echo $expert_info['bankcard']?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputName" class="col-sm-2 control-label no-padding-right">银行名称</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputName"
				value="<?php echo $expert_info['bankname']?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<label for="inputPerson"
			class="col-sm-2 control-label no-padding-right">持卡人</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="inputPerson"
				value="<?php echo $expert_info['cardholder']?>" readonly>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button type="submit" class="btn btn-default">申请提现</button>
		</div>
	</div>
</form>

<div class="well with-header with-footer">
	<div class="header bg-palegreen">提现记录</div>
	<table class="table table-hover table-striped table-bordered">
		<thead class="bordered-blueberry">
			<tr>
				<th>提现日期</th>
				<th>提现金额</th>
				<th>备注</th>
				<th>状态</th>
			</tr>
		</thead>
		<tbody>
                                    <?php foreach ($exchange_info as $item): ?>
                                        <tr>
				<td>
                                                <?php echo $item['addtime']?>
                                            </td>
				<td>
                                                <?php echo $item['amount']?>
                                            </td>
				<td>
                                                <?php echo $item['beizhu']?>
                                            </td>
				<td>
                                                <?php echo $item['approve_status']?>
                                            </td>
			</tr>
                                        <?php endforeach;?>
                                       
                                    </tbody>
	</table>

</div>

<div class="well with-header with-footer">
	<div class="header bg-palegreen">月度结算记录</div>
	<table class="table table-hover table-striped table-bordered">
		<thead class="bordered-blueberry">
			<tr>
				<th>结算开始时间</th>
				<th>结算结束时间</th>
				<th>结算金额</th>
				<th>备注</th>

			</tr>
		</thead>
		<tbody>
                                    <?php foreach ($month_account_info as $item): ?>
                                        <tr>
				<td>
                                                <?php echo $item['starttime']?>
                                            </td>
				<td>
                                                <?php echo $item['endtime']?>
                                            </td>
				<td>
                                                <?php echo $item['amount']?>
                                            </td>
				<td>
                                                <?php echo $item['beizhu']?>
                                            </td>

			</tr>
                                        <?php endforeach;?>
                                       
                                    </tbody>
	</table>

</div>