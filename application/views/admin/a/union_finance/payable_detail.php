<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>平台管理系统</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style>
	.detail-add-but{
		margin-left: 120px;
		border: 1px solid rgb(204, 204, 204);
		width: 45px;
		text-align: center;
		border-radius: 3px;
		padding: 3px 0px;
		cursor: pointer;
	}
</style>
</head>
<body>
	
    <div class="page-body " id="bodyMsg">
        <div class="order_detail">
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">供应商:</td>
                        <td><?php echo $payableArr['supplier_name']?></td>
                        <td class="order_info_title">旅行社:</td>
                        <td><?php echo $payableArr['union_name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请时间:</td>
                        <td class="w_40_p"><?php echo $payableArr['addtime']?></td>
                        <td class="order_info_title">申请金额:</td>
                        <td class="w_40_p"><?php echo $payableArr['amount']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行卡号:</td>
                        <td class="w_40_p"><?php echo $payableArr['bankcard']?></td>
                        <td class="order_info_title">银行名称</td>
                        <td class="w_40_p"><?php echo $payableArr['bankname']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">开户公司:</td>
                        <td class="w_40_p"><?php echo $payableArr['bankcompany']?></td>
                        <td class="order_info_title"></td>
                        <td class="w_40_p"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请理由:</td>
                        <td colspan="3" class="w_40_p"><?php echo $payableArr['remark']?></td>
                    </tr>
                </table>
                
                <?php if ($payableArr['status'] == 1 || $payableArr['status'] == 2):?>
                <div class="small_title_txt clear">
                    <span class="txt_info fl">审核信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">审核人:</td>
                        <td><?php echo $payableArr['employee_name']?></td>
                        <td class="order_info_title">审核状态:</td>
                        <td><?php echo $payableArr['status'] == 1 ? '审核通过' : '审核拒绝';?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核时间:</td>
                        <td class="w_40_p"><?php echo $payableArr['u_time']?></td>
                        <td class="order_info_title"></td>
                        <td class="w_40_p"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核回复:</td>
                        <td colspan="3" class="w_40_p"><?php echo $payableArr['u_reply']?></td>
                    </tr>
                </table>
                <?php endif;?>
            </div>
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">订单列表</span>
                </div>
                <form class="search_form" method="post" id="detail-form" action="">
                    	<div class="search_form_box clear">
                            <div class="search_group">
                            	<input type="hidden" name="detail_id" value="<?php echo $payableArr['id']?>">
<!--                             	<input type="submit" name="submit" class="search_button" value="搜索"/> -->
                            </div>
                    	</div>
                   </form>
                <div id="order-list"></div>
            </div>
            
        </div>
	</div>
	
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script>
var orderColumns = [ {field : 'amount_apply',title : '申请金额',width : '100',align : 'center'},
	                    {field : false,title : '申请比例',width : '100',align : 'center',formatter:function(result) {
								return Math.round(result.amount_apply / (result.supplier_cost - result.balance_money)*100 ,3)+'%';
		                    }
 					},
	             		{field : false,title : '订单号',width : '120',align : 'center',formatter:function(result) {
	             				return '<a href="/admin/a/orders/order/order_detail_info?id='+result.order_id+'" target="_blank">'+result.ordersn+'</a>';
		             		}
						},
	            		{field : 'linename',title : '产品名称',width : '170',align : 'center'},
	            		{field : 'usedate',title : '出团日期',width : '100',align : 'center'},
	            		{field : 'supplier_cost',title : '成本总计',align : 'center', width : '110'},
	            		{field : 'balance_money',title : '已结算',align : 'center', width : '80'},
	            		{field : false,title : '未结算',align : 'center', width : '80' ,formatter:function(result) {
								return Math.round(result.supplier_cost - result.balance_money ,2);
		            		}
	            		},
	            		{field : 'item_code',title : '团号',align : 'center', width : '120'}]
	            	
	$("#order-list").pageTable({
		columns:orderColumns,
		url:'/admin/a/union_finance/payable_apply/getPayableOrder',
		pageSize:10,
		searchForm:'#detail-form',
		tableClass:'table table-bordered table_hover',
	});

</script>
</body>
</html>
