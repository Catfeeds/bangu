<style type="text/css">
    .page-body{ padding: 20px;}
    .well.with-footer{ padding-bottom: 20px;}
    .col_ts{ float: left; }
    .form-control{ width: 180px; display: inline;}
    .form-head{ min-height:50px; background: #fff; padding:15px 20px 0 0;}
    .form-group{ margin-right: 20px; margin-top: 0;}
    .form-group input{ height:26px; line-height: 26px; padding: 0 10px; float: left}
    .form-group label{ height: 26px; line-height: 26px; padding:0 5px; margin:0; float: left; border: 1px solid #dedede; border-right: none; }
    .table>thead>tr>th, .table>tbody>tr>td{ padding: 6px}
    .paginaBox{ width: 100%; padding-top: 20px; text-align: center}
    .well.with-header{}
    .well{ background: #fff;padding:0 10px;}
	.formBox { padding:0 10px 15px;}
</style>
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"> </i>
			<a href="<?php echo site_url('admin/b2/home/index')?>">主页</a>
		</li>
		<li class="active">我的客户</li>
	</ul>
</div>
<div class="page-body" id="bodyMsg">
	<div class="form-head shadow">
		<form class="form-inline formBox" method="post" action="<?php echo site_url('admin/b2/expert/customer')?>" >
			<div class="form-group col_ts">
				<label style="col_ts" >客户昵称:</label>
				<input style="col_ts" type="text"  class="form-control" name="nickname" value="<?php echo $nickname;?>" />
			</div>
			<div class="form-group col_ts">
				<label style="col_ts">手机号:</label>
				<input type="text" class="form-control" name="mobile" value="<?php echo $mobile; ?>" style="width:180px;display: inline;"/>
			</div>
			<button type="submit" class="btn btn-darkorange active">搜索</button>
		</form>
	</div>
	<div class="well with-header with-footer shadow" style=" padding-top: 0px;">
	    <table class="table table-bordered table-hover">
	        <thead>
	            <tr>
	                <th style="text-align:center;width: 120px;">客户昵称</th>
	                <th style="text-align:center;width: 90px;"> 订单数量</th>
	                <th style="text-align:center;width: 150px;">最后下单时间</th>
	                <th style="text-align:center;width: 150px;">消费总金额</th>
	                <th style="text-align:center;width: 150px;">联系方式</th>
	            </tr>
	        </thead>
	        <tbody>

	        	<?php foreach ($cust_info as $item): ?>
	            <tr>
	                <td style="text-align:center"> <?php echo $item['nickname']?></td>
	                <td style="text-align:center"> <?php echo $item['order_amount']?></td>
	                <td style="text-align:center"><?php echo $item['last_time']?> </td>
	                <td style="text-align:center"><?php echo $item['total_price']?></td>
	                <td style="text-align:center"> <?php echo $item['mobile']?> </td>
	            </tr>
	            <?php endforeach; ?>
	        </tbody>
	    </table>
        <div class="paginaBox"><div class="pagination" style=" margin:0 auto;"><?php echo $this->page->create_page()?></div></div>
    </div>
</div>
