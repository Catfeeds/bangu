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
	
    <div class="page-body w_1200" id="bodyMsg">
    
        <div class="current_page">您的位置：
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">供应商结算明细</a>
        </div>
        
        <div class="order_detail">
            <h2 class="lineName headline_txt">供应商结算明细</h2>
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">供应商名称:</td>
                        <td><?php echo $accountArr['supplier_name']?></td>
                        <td class="order_info_title">申请结算金额:</td>
                        <td><?php echo $accountArr['amount']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行名称:</td>
                        <td><?php echo $accountArr['bankname']?></td>
                        <td class="order_info_title">支行名称:</td>
                        <td><?php echo $accountArr['brank']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行卡号:</td>
                        <td><?php echo $accountArr['bank']?></td>
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo $accountArr['addtime']?></td>
                    </tr>
                </table>
            </div>
            <?php if ($accountArr['status'] > 0 ) :?>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">旅行社审核信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">旅行社:</td>
                        <td><?php echo $accountArr['union_name']?> </td>
                        <td class="order_info_title">审核状态:</td>
                        <td>
                        <?php 
                        	if ($accountArr['status'] == 1 || $accountArr['status'] > 2) {
                        		echo '审核通过';
                        	} else if ($accountArr['status'] == 2) {
                        		echo '审核退回';
                        	}
                        ?>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核人:</td>
                        <td><?php echo $accountArr['employee_name']?></td>
                        <td class="order_info_title">审核时间</td>
                        <td><?php echo $accountArr['modtime']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核回复:</td>
                        <td colspan="3"><?php echo $accountArr['e_reply']?></td>
                    </tr>
                </table>
            </div>
            <?php endif;?>
            <?php if ($accountArr['status'] == 3 || $accountArr['status'] == 4) :?>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">平台审核信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">审核人:</td>
                        <td><?php echo $accountArr['admin_name']?> </td>
                        <td class="order_info_title">审核状态:</td>
                        <td>
                        <?php 
                        	if ($accountArr['status'] == 3) {
                        		echo '审核通过';
                        	} else if ($accountArr['status'] == 4) {
                        		echo '审核退回';
                        	}
                        ?>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核时间:</td>
                        <td><?php echo $accountArr['a_time']?></td>
                        <td class="order_info_title"></td>
                        <td></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核回复:</td>
                        <td colspan="3"><?php echo $accountArr['a_reply']?></td>
                    </tr>
                </table>
            </div>
            <?php endif;?>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">结算订单详细</span>
                </div>
                <form method="post" id="form-detail">
                	<input type="hidden" name="id" value="<?php echo $accountArr['id']?>" />
                </form>
                <div id="order-list"></div>
            </div>
			<?php if ($accountArr['status'] == 1):?>
			<div class="but-list">
				<button class="through-pay">通过</button>
				<button class="refuse-pay">退回</button>
			</div>
			<?php endif;?>
        </div>
	</div>
<div class="fb-content" id="payable-box" style="display:none;">
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
                <div class="fg-input"><input type="text" name="amount" disabled="disabled" value="<?php echo $accountArr['amount']?>"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">审核回复：</div>
                <div class="fg-input"><textarea name="reply" maxlength="150"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $accountArr['id']?>">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<div class="fb-content" id="payable-box-1" style="display:none;">
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
                <input type="hidden" name="id" value="<?php echo $accountArr['id']?>">
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
	maxNum:<?php echo $accountArr['amount']?>
});
var columns = [{field : 'ordersn',title : '订单号',width : '120',align : 'center'},
        	  	{field : 'union_name',title : '旅行社',width : '140',align : 'center'},
        	  	{field : false,title : '剩余可结算金额',width : '140',align : 'center',formatter:function(result) {
						return Math.round(result.supplier_cost - result.balance_money ,2);
            	  	}
        	  	},
        	  	{field : false,title : '信用欠款',width : '140',align : 'center',formatter:function(result) {
            	  		if (typeof result.apply_status != 'object') {
            	  			if (result.apply_status == 1) {
    							return resutl.real_amount;
    						} else if (result.apply_status == 2) {
    							return 0;
    						}
                	  	} else {
                    	  	return 0;
                    	}
            	  	}
        	  	},
        	  	{field : 'supplier_cost',title : '供应商成本',width : '140',align : 'center'},
        	  	{field : 'total_price',title : '订单金额',width : '140',align : 'center'},
        		{field : 'supplier_name',title : '供应商',align : 'center', width : '90'}]

$("#order-list").pageTable({
	columns:columns,
	url:'/admin/a/union_finance/supplier_account/getAccountOrder',
	pageSize:10,
	searchForm:'#form-detail',
	tableClass:'table table-bordered table_hover'
});

//通过
$('.through-pay').click(function(){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#payable-box')
	});
})
//拒绝
$('.refuse-pay').click(function(){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#payable-box-1')
	});
})

$('#refuse-form').submit(function(){
	$.ajax({
		url:'/admin/a/union_finance/supplier_account/refuse',
		data:$(this).serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.confirm(result.msg, {btn: ['确定'] }, function(){
					location.reload();
				})
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
var ts = true;
$('#through-form').submit(function(){
	if (ts == false) {
		return false;
	} else {
		ts = false;
	}
	$.ajax({
		url:'/admin/a/union_finance/supplier_account/through',
		data:$(this).serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			ts = true;
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.confirm(result.msg, {btn: ['确定'] }, function(){
					location.reload();
				})
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
