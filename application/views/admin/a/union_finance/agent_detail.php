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
	    width: 40%;
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
                        <td class="order_info_title">旅行社名称:</td>
                        <td colspan="3"><?php echo $agentArr['union_name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人:</td>
                        <td><?php echo $agentArr['employee_name']?></td>
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo $agentArr['addtime']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请结算金额:</td>
                        <td><?php echo $agentArr['amount']?></td>
                        <td class="order_info_title">实际结算金额:</td>
                        <td><?php echo $agentArr['real_amount']?></td>
                    </tr>
                </table>
                <?php if ($agentArr['status'] == 1 || $agentArr['status'] == 2) :?>
                <div class="small_title_txt clear">
                    <span class="txt_info fl">审核信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">审核人:</td>
                        <td><?php echo $agentArr['admin_name']?> </td>
                        <td class="order_info_title">审核状态:</td>
                        <td><?php echo $agentArr['status'] == 1 ? '审核通过' : '审核拒绝'; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核时间</td>
                        <td><?php echo $agentArr['modtime']?></td>
                        <td class="order_info_title"></td>
                        <td></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核回复:</td>
                        <td colspan="3"><?php echo $agentArr['reply']?></td>
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
                            	<input type="hidden" name="detail_id" value="<?php echo $agentArr['id']?>">
<!--                             	<input type="submit" name="submit" class="search_button" value="搜索"/> -->
                            </div>
                    	</div>
                   </form>
                <div id="order-list"></div>
            </div>
            
			<?php if ($agentArr['status'] == 0):?>
			<div class="but-list">
				<button class="through-pay">通过</button>
				<button class="refuse-pay">退回</button>
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
                <input type="hidden" name="agent_id" value="<?php echo $agentArr['id']?>">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<div class="fb-content" id="refuse-box" style="display:none;">
    <div class="box-title">
        <h4>拒绝申请</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="refuse-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">拒绝理由：</div>
                <div class="fg-input"><textarea name="reply" maxlength="150"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="agent_id" value="<?php echo $agentArr['id']?>">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script>
$('input[name=amount]').verifNum({
	digit:2,
	maxNum:<?php echo $agentArr['amount']?>
});
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
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '460px',
		  shadeClose: false,
		  content: $('#through-box')
	});
})

$('.refuse-pay').click(function(){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '460px',
		  shadeClose: false,
		  content: $('#refuse-box')
	});
})

var t = true;
$('#through-form').submit(function() {
	if (t == false) {
		return false;
	} else {
		t = false;
	}
	$.ajax({
		url:'/admin/a/union_finance/union_agent/through',
		data:$(this).serialize(),
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
	return false;
})
var t = true;
$('#refuse-form').submit(function() {
	if (t == false) {
		return false;
	} else {
		t = false;
	}
	$.ajax({
		url:'/admin/a/union_finance/union_agent/refuse',
		data:$(this).serialize(),
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
	return false;
})
</script>
</body>
</html>
