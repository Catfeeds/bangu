<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>平台管理系统</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
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
	
    <div class="page-body" id="bodyMsg">
        <div class="order_detail">
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">申请人姓名:</td>
                        <td class="w_40_p"><?php echo $detailArr['expert_name']?></td>
                        <td class="order_info_title">申请金额:</td>
                        <td class="w_40_p"><?php echo $detailArr['amount']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">营业部:</td>
                        <td class="w_40_p"><?php echo $detailArr['depart_name']?></td>
                        <td class="order_info_title">旅行社:</td>
                        <td class="w_40_p"><?php echo $detailArr['union_name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行卡号:</td>
                        <td class="w_40_p"><?php echo $detailArr['bankcard']?></td>
                        <td class="order_info_title">银行名称:</td>
                        <td class="w_40_p"><?php echo $detailArr['bankname']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">开户分行:</td>
                        <td class="w_40_p"><?php echo $detailArr['branch']?></td>
                        <td class="order_info_title">持卡人:</td>
                        <td class="w_40_p"><?php echo $detailArr['cardholder']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo $detailArr['addtime']?></td>
                        <td class="order_info_title"></td>
                        <td></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请理由:</td>
                        <td colspan="3"><?php echo $detailArr['reason']?></td>
                    </tr>
                </table>
                <?php if ($detailArr['status'] ==1 || $detailArr['status'] == 2):?>
                <div class="small_title_txt clear">
                    <span class="txt_info fl">审核信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">审核人:</td>
                        <td class="w_40_p"><?php echo $detailArr['employee_name']?></td>
                        <td class="order_info_title">审核时间:</td>
                        <td class="w_40_p"><?php echo $detailArr['u_time']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核状态:</td>
                        <td class="w_40_p"><?php echo $detailArr['status'] == 1 ? '审核通过' : '审核拒绝'?></td>
                        <td class="order_info_title"></td>
                        <td class="w_40_p"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核意见:</td>
                        <td colspan="3"><?php echo $detailArr['u_reason']?></td>
                    </tr>
                </table>
                <?php endif;?>
            </div>
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">结算订单</span>
                </div>
                <form class="search_form" method="post" id="order-form" action="">
                    	<div class="search_form_box clear">
<!--                         	<div class="search_group"> -->
<!--                             	<label>使用日期</label> -->
<!--                                <input type="text" name="starttime" id="starttime" style="width:110px;" class="search_input" placeholder="开始时间"/>-->
 <!--                               <input type="text" name="endtime" id="endtime" style="width:110px;" class="search_input" placeholder="开始时间"/>-->
<!--                             </div> -->
<!--                             <div class="search_group"> -->
<!--                             	<label>订单号</label> -->
<!--                                 <input type="text" name="ordersn" class="search_input" placeholder="订单号"/> -->
<!--                             </div> -->
                            <div class="search_group">
                            	<input type="hidden" name="settlement_id" value="<?php echo $detailArr['id']?>">
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
<script>
var columns = [ {field : 'agent_fee',title : '利润',width : '100',align : 'center'},
	             	{field : false,title : '订单号',width : '120',align : 'center',formatter:function(result) {
	             			return '<a href="/admin/a/orders/order/order_detail_info?id='+result.orderid+'" target="_blank">'+result.ordersn+'</a>';
		             	}
					},
	            	{field : 'linename',title : '产品名称',width : '140',align : 'center'},
	            	{field : 'usedate',title : '出团日期',width : '100',align : 'center'},
	            	{field : 'total_price',title : '订单金额',align : 'center', width : '110'},
	            	{field : 'supplier_cost',title : '成本总计',align : 'center', width : '110'},
	            	{field : 'diplomatic_agent',title : '外交佣金',align : 'center', width : '80'},
	            	{field : 'settlement_price',title : '保险费',align : 'center', width : '80'},
	            	{field : 'item_code',title : '团号',align : 'center', width : '120'},
	            	{field : 'expert_name',title : '销售',align : 'center', width : '110'}]
	$("#order-list").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/depart_settlement/getSettlementOrder',
		pageSize:10,
		searchForm:'#order-form',
		tableClass:'table table-bordered table_hover',
		isStatistics:true,
		statisticsContent:'<span style="float: left;margin-top: 23px;">总计：<span style="color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;">'+<?php echo $detailArr['amount']?>+'</span>元</span>'
	});
	
//通过拒绝
function but_click(id) {
	var t = true;
	$('.through-but').click(function(){
		if (t == false) {
			return false;
		} else {
			t = false;
		}
		$.ajax({
			url:'/admin/a/union_finance/depart_settlement/through',
			data:{id:id,reason:$('textarea[name=a_reason]').val()},
			type:'post',
			dataType:'json',
			success:function(result) {
				t = true;
				if (result.code == 2000) {
					$('.layui-layer-close').trigger('click');
					layer.alert(result.msg, {icon: 2});
					getData(1);
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	})
	$('.refuse-but').click(function(){
		$.ajax({
			url:'/admin/a/union_finance/depart_settlement/refuse',
			data:{id:id,reason:$('textarea[name=a_reason]').val()},
			type:'post',
			dataType:'json',
			success:function(result) {
				if (result.code == 2000) {
					$('.layui-layer-close').trigger('click');
					layer.alert(result.msg, {icon: 2});
					getData(1);
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	})
}
</script>
</body>
</html>
