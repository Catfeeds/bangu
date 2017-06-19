
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="#"> 首页 </a></li>
			<li class="active">仪表盘</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="well with-header with-footer">
					<div class="widget">
						<div class="widget-header  with-footer">
							<span class="widget-caption">菜单</span>
							<div class="widget-buttons">
								<a href="#" data-toggle="maximize"> <i class="fa fa-expand"></i>
								</a> <a href="#" data-toggle="collapse"> <i class="fa fa-minus"></i>
								</a> <a href="#" data-toggle="dispose"> <i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="widget-body">
							<div class="flip-scroll">

								<label>
									<form class="form-inline" role="form" action="<?php echo base_url();?>admin/a/order/order_receivable" method="post">
										<div class="form-group dataTables_filter">
											<input type="text"
												class="form-control"  name="product_name" placeholder="产品标题" value="<?php echo $product_name?>">
										</div>
										<div class="form-group dataTables_filter">
											<input type="text"
												class="form-control"  name="ordersn" placeholder="订单编号 " value="<?php echo $ordersn?>">
										</div>
										<div class="form-group">
											<div class="controls">
												<div class="input-group">
													<span class="input-group-addon"> <i class="fa fa-calendar">
													</i>
													</span> <input type="text" class="form-control"
														id="departure_date" name="departure_date" value="<?php echo $departure_date ? $departure_date:'出团日期';?>">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label > 供应商 </label>
											<select name="supplier_id">
								                                            <option value="">请选择</option>
								                                            <?php foreach ($suppliers as $item):?>
								                                                 <?php if ($item['id'] == $supplier_check): ?>
								                                                     <option value="<?php echo $item['id'];?>" selected='selected'><?php echo $item['realname'];?></option>
								                                                <?php else: ?>
								                                                        <option value="<?php echo $item['id'];?>"><?php echo $item['realname'];?></option>
								                                                 <?php endif?>
								                                            <?php endforeach;?>
                                           							 </select>
										</div>
										<button type="submit" class="btn btn-darkorange">搜索</button>
									</form>
								</label>
								<table class="table table-hover">
									<thead class="bordered-darkorange">
										<tr>
											<th>订单编号</th>
											<th>预定人</th>
											<th>产品标题</th>
											<th>参团人数</th>
											<th>订单金额</th>
											<th>收款金额</th>
											<th>供应商</th>
											<th>专家</th>
											<th>出团日期</th>
											<th>下单时间</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
                                                                                         <?php foreach ($apply_list as $item): ?>
										<tr>
											<td><?php echo $item['ordersn'];?></td>
											<td><?php echo$item['people'];?></td>
											<td><?php echo$item['pro_title'];?></td>
											<td><?php echo$item['people_num'];?></td>
											<td><?php echo$item['order_amount'];?></td>
											<td><?php echo$item['receive_amount'];?></td>
											<td><?php echo$item['supplier_name'];?></td>
											<td><?php echo$item['expert'];?></td>
											<td><?php echo$item['begin_time'];?></td>
											<td><?php echo$item['addtime'];?></td>
											<td>
											<?php if($item['status']==3):?>
												<font color="green">已确认首款收款</font>
                                                                                                                      <?php else:?>
                                                                                                                      	<a  class="btn btn-default btn-xs purple" onclick="show_receive_dialog(this)" data-val="<?php echo $item['id'];?>">
                                                                                                                        <i class="fa fa-edit">
                                                                                                                        </i>登记收款
                                                                                                                      </a>
                                                                                                                      <?php endif;?>
                                                                                                                    </td>

										</tr>
                                                                                         <?php endforeach;?>
									</tbody>
								</table>
                                                                                <div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /Page Body -->
</div>
<!--Basic Scripts-->





<!--弹窗登记收款-->
<div id="redund_myModal_1" style="display: none;">
<div class="bootbox-body">
    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url();?>admin/a/order/register_receive">
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">收款金额</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="receive_amount" value="0" />
                <input type="hidden" class="form-control" id="hidden_order_sn" name="order_sn" value="" />
            </div>
        </div>
            <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">备注</label>
            <div class="col-sm-10">
                <textarea name="beizhu" style="resize:none;width:100%;height:100%">备注</textarea>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>
</div>
</div>



<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
$('#departure_date').daterangepicker();
   $('#departure_date').focus(function(){
   	$(this).val('');
   });

function show_receive_dialog(obj){
       var order_sn = $(obj).attr('data-val');
       $("#hidden_order_sn").val(order_sn);

       bootbox.dialog({
                message: $("#redund_myModal_1").html(),
                title: "登记收款",
            });
}

</script>




