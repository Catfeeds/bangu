<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>平台管理系统</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<style>
	.but-list{
		text-align: right;
	}
	.but-list button{
		background: rgb(255, 255, 255) none repeat scroll 0% 0%;
		border: 1px solid rgb(204, 204, 204);
		padding: 3px;
		border-radius: 3px;
		cursor: pointer;
	}
	.table_td_border > tbody > tr > td {
	    width: 23%;
	}
	.order_detail{margin-bottom:30px;}
</style>
</head>
<body>
	
    <div class="page-body" id="bodyMsg">
        
        <div class="order_detail">
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">退款退团信息</span>
                </div>
                <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="5"><?php echo $refundArr['linename']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单号:</td>
                        <td><a href="/admin/a/orders/order/order_detail_info?id=<?php echo $refundArr['order_id']?>" target="_blank"><?php echo $refundArr['ordersn']?></a></td>
                        <td class="order_info_title">订单人数:</td>
                        <td><?php echo round($refundArr['dingnum']+$refundArr['childnum']+$refundArr['childnobednum']+$refundArr['oldnum'])?></td>
                        <td class="order_info_title">退订人数:</td>
                        <td><?php echo $refundArr['num']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单金额:</td>
                        <td><?php echo $refundArr['total_price']?></td>
                        <td class="order_info_title">已交款:</td>
                        <td><?php echo $refundArr['money']?></td>
                        <td class="order_info_title">未交款:</td>
                        <td><?php echo round($refundArr['total_price']-$refundArr['money'] ,2)?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td><?php echo round($refundArr['supplier_cost']-$refundArr['platform_fee'] ,2)?></td>
                        <td class="order_info_title">未结算:</td>
                        <td><?php echo round($refundArr['supplier_cost']-$refundArr['platform_fee']-$refundArr['balance_money'],2);?></td>
                        <td class="order_info_title">已结算:</td>
                        <td><?php echo $refundArr['balance_money']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">代收金额:</td>
                        <td><?php echo ''?></td>
                        <td class="order_info_title">授信额度:</td>
                        <td><?php echo empty($applyData) ? 0.00 : $applyData['real_amount']?></td>
                        <td class="order_info_title">联盟单位佣金:</td>
                        <td><?php echo $refundArr['platform_fee']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">供应商备注:</td>
                        <td colspan="5"><?php echo empty($supplierRefund) ? '' : $supplierRefund['remark'] ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">联盟审核备注:</td>
                        <td colspan="5"><?php echo $refundArr['u_remark'] ?></td>
                    </tr>
                </table>
                <div class="small_title_txt clear">
                    <span class="txt_info fl">退款信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">退交款:</td>
                        <td><?php echo $refundArr['sk_money']?> </td>
                        <td class="order_info_title">退佣金:</td>
                        <td><?php echo $refundArr['union_money'] ?></td>
                        <td class="order_info_title">退应收:</td>
                        <td><?php echo $refundArr['ys_money'] ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">退应付:</td>
                        <td><?php echo $refundArr['yf_money'] ?></td>
                        <td class="order_info_title"></td>
                        <td></td>
                    </tr>
                </table>
                <div class="small_title_txt clear">
                    <span class="txt_info fl">客人退款账号</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">持卡人:</td>
                        <td><?php echo $refundArr['holder']?> </td>
                        <td class="order_info_title">开户行:</td>
                        <td><?php echo $refundArr['bank'] ?></td>
                        <td class="order_info_title">支行名称:</td>
                        <td><?php echo $refundArr['brand'] ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行账号:</td>
                        <td colspan="5"><?php echo $refundArr['account'] ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">销售备注:</td>
                        <td colspan="5"><?php echo $refundArr['remark'] ?></td>
                    </tr>
                </table>
            </div>
            
			<?php if ($refundArr['status'] == 3):?>
			<div class="but-list">
				<button class="through-pay" data-val="<?php echo $refundArr['id']?>">确认转款</button>
			</div>
			<?php endif;?>
        </div>
	</div>
	
<div class="fb-content" id="through-box" style="display:none;">
    <div class="box-title">
        <h4>通过申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="through-form" class="form-horizontal">
        	<div class="form-group">
                <div class="fg-title">结算金额：</div>
                <div class="fg-input"><input type="text" name="amount" value="<?php echo $agentArr['amount']?>"></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="agent_id" value="<?php echo $refundArr['id']?>">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script>
var orderColumns = [ {field : false,title : '佣金总计',width : '100',align : 'center' ,formatter:function(result) {
							return (result.diplomatic_agent*1 + result.platform_fee *1).toFixed(2);
						}
					},
					{field : false,title : '订单号',width : '120',align : 'center',formatter:function(result) {
							return '<a href="/admin/a/orders/order/order_detail_info?id='+result.order_id+'" target="_blank">'+result.ordersn+'</a>';
						}
					},
					{field : 'usedate',title : '出团日期',width : '100',align : 'center'},
					{field : 'supplier_cost',title : '成本总计',width : '100',align : 'center'},
					{field : false,title : '订单金额',width : '170',align : 'center' ,formatter:function(result) {
							return (result.total_price*1 + result.settlement_price*1).toFixed(2);
						}
					},
					{field : 'item_code',title : '团号',align : 'center', width : '120'}]

$("#order-list").pageTable({
	columns:orderColumns,
	url:'/admin/a/union_finance/union_agent/getAgentOrder',
	pageSize:10,
	searchForm:'#detail-form',
	tableClass:'table table-bordered table_hover',
});

$('.through-pay').click(function(){
	var id = $(this).attr('data-val');
	layer.confirm('您确认转款？', 
			{btn: ['确认','取消']},
			function(index){
				layer.close(index);
				$.ajax({
					url:'/admin/a/union_finance/refund/through',
					data:{id:id},
					type:'post',
					dataType:'json',
					success:function(result) {
						if (result.code == 2000) {
							layer.confirm(result.msg, {btn:['确认']},function(){
								t33_close_iframe();
							});
						} else {
							layer.alert(result.msg, {icon: 2});
						}
					}
				});
			}, 
			function(){}
		);
})

</script>
</body>
</html>
