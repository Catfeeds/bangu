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
                        <td class="order_info_title">旅行社:</td>
                        <td colspan="3" ><?php echo $unionArr['union_name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">累计营业额:</td>
                        <td class="w_40_p"><?php echo $unionArr['total_turnover']?></td>
                        <td class="order_info_title">累计佣金:</td>
                        <td class="w_40_p"><?php echo round($unionArr['not_settle_agent'] + $unionArr['settle_agent'],2)?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">未结算佣金:</td>
                        <td class="w_40_p"><?php echo $unionArr['not_settle_agent']?></td>
                        <td class="order_info_title">已结算佣金</td>
                        <td class="w_40_p"><?php echo $unionArr['settle_agent']?></td>
                    </tr>
                </table>
            </div>
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">订单列表</span>
                </div>
                <form class="search_form" method="post" id="detail-form" action="">
                    	<div class="search_form_box clear">
                            <div class="search_group">
                            	<input type="hidden" name="detail_id" value="<?php echo $unionArr['id']?>">
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
var columns = [ {field : false,title : '佣金总计',width : '100',align : 'center' ,formatter:function(result) {
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
	columns:columns,
	url:'/admin/a/union_finance/union_agent_sel/getAgentOrder',
	pageSize:10,
	searchForm:'#detail-form',
	tableClass:'table table-bordered table_hover'
});

</script>
</body>
</html>
