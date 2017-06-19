<style type="text/css">
.choice_order span{padding-left: 5px;}
table { margin-top: 10px;margin-left:25px;}
th{width: 150px;}
</style>
<div><table >
<tr><td><b>创建时间:</b></td><td><?php echo $addtime;?></td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
				<td><b>创建人:</b></td><td><?php echo $creator;?></td></tr>
<tr>
</tr>
<tr><td><b>备注:</b></td><td><?php echo $beizhu;?></td></tr></table></div><hr/>



<div class="choice_order">
   <span>已选择订单</span>
<table border=1 style="border-collapse:collapse">
	<tr>
	<th style="text-align:center">订单编号</th>
	<th style="text-align:center">产品标题</th>
	<th style="text-align:center">参团人数</th>
	<th style="text-align:center">出团日期</th>
	<th style="text-align:center">订单金额</th>
	<th style="text-align:center">管家佣金</th>
	<th style="text-align:center">平台管理费</th>
	<th style="text-align:center">结算金额</th>
	</tr>
		<?php foreach ($detail_list as $item): ?>
                    		<tr>
				<td style="width:150px;text-align:center"><?php echo $item['ordersn']?></td>
				<td style="width:150px;text-align:center"><?php echo $item['productname']?></td>
				<td style="width:150px;text-align:center"><?php echo $item['people_num']?></td>
				<td style="width:350px;text-align:center"><?php echo $item['usedate']?></td>
				<td style="width:150px;text-align:center"><?php echo $item['total_price']?></td>
				<td style="width:150px;text-align:center"><?php echo $item['agent_fee']?></td>
				<td style="width:150px;text-align:center"><?php echo $item['total_price']*$item['agent_rate']?></td>
				<td style="width:150px;text-align:center"><?php echo $item['total_price']-$item['total_price']*$item['agent_rate']-$item['agent_fee']?></td>
			</tr>
                    <?php endforeach;?>

</table>
</div>

<div class="choice_order">
   <span>修改记录</span>
<table border=1 style="border-collapse:collapse">
	<tr>
	<th style="text-align:center">修改人</th>
	<th style="text-align:center">修改时间</th>
	<th style="text-align:center">修改前金额</th>
	<th style="text-align:center">修改后金额</th>
	<th style="text-align:center">修改原因</th>
	</tr>
	<?php foreach ($edit_list as $item): ?>
             <tr>
		<td style="width:150px;text-align:center"><?php echo $item['ad_name']?></td>
		<td style="width:150px;text-align:center"><?php echo $item['addtime']?></td>
		<td style="width:150px;text-align:center"><?php echo $item['before_amount']?></td>
		<td style="width:350px;text-align:center"><?php echo $item['after_amount']?></td>
		<td style="width:350px;text-align:center"><?php echo $item['remark']?></td>
	</tr>
          <?php endforeach;?>
</table>
</div>