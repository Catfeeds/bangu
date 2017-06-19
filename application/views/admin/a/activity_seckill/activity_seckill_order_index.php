<link rel="stylesheet" href="/file/common/plugins/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/file/common/plugins/kindeditor/plugins/code/prettify.css" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">秒杀商品订单管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<!--<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>-->
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/activity_seckill/getOrderDataList')?>" id='search_condition' class="search_condition_form" method="post">
		
			<ul>
				<li class="search-list">
					<span class="search-title">产品名称：</span>
					<span >
						<input class="search_input user_name_b1" type="text" name="goods_name">
					</span>
					<span class="search-title">订单号：</span>
					<span >
						<input class="search_input user_name_b1" type="text" name="ordersn">
					</span>	
					<span class="search-title">支付订单号：</span>
					<span >
						<input class="search_input user_name_b1" type="text" name="paysn">
					</span>	
					<span class="search-title">买家手机号：</span>
					<span >
						<input class="search_input user_name_b1" type="text" name="buyername">
					</span>	
					订单状态：					
					<select name="payment" style="width:110px">
						<option value="0" selected="selected">请选择..</option>												
						<option value="10">未付款</option>
						<option value="20">已付款</option>
						<option value="40">未兑换</option>
						<option value="30">已兑换</option>													
					</select>
					<span >
						<input type="submit" value="搜索" class="search-button" />
					</span>	
				</li>
			</ul>		
		
		</form>
		<div id="dataTable"></div>
	</div>
</div>


<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>

<script>
var columns = [
{field : 'order_id',title : '订单id',width : '100',align : 'center'},
{field : 'order_sn',title : '订单号',width : '100',align : 'center'},
{field : 'pay_sn',title : '支付号',width : '100',align : 'center'},
{field : 'buyer_name',title : '买家用户名',width : '100',align : 'center'},
{field : 'seckill_goods_id',title : '商品id',width : '100',align : 'center'},
		{field : 'seckill_goods_name',title : '商品名称',width : '100',align : 'center'},
        		{field : false,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.seckill_goods_image+"' target='_blank'><img src='"+item.seckill_goods_image+"' width='50px' height='50px'/></a>";
                   	 }
                	},
                	{field : 'seckill_goods_price',title : '原始价格',width : '100',align : 'center'},
                	{field : 'seckill_price',title : '秒杀价格',width : '100',align : 'center'},
                	{field : 'seckill_goods_num',title : '购买数量',width : '100',align : 'center'},
					{field : 'order_amount',title : '订单金额',width : '100',align : 'center'},
                	{field : 'seckill_goods_start_time',title : '秒杀开始时间',width : '100',align : 'center'},
                	{field : 'seckill_goods_end_time',title : '秒杀结束时间',width : '100',align : 'center'},					
                	{field : 'seckill_goods_exchange_end_time',title : '兑换结束时间',width : '100',align : 'center'},
                	{field : false,title : '付款方式',width : '100',align : 'center',formatter:function(item){
                		if(item.payment_code=='sdkalipay'){    // 魏勇编辑,将alipay改为sdkalipay
                			return '支付宝';
						}else if(item.payment_code=='sdkwxpay'){   // 魏勇编辑,将wxpay改为sdkwxpay
                			return '微信';							
						}else{
							return '';
						}
                	}},					
					{field : 'payment_time',title : '付款时间',width : '100',align : 'center'},
                	{field : false,title : '订单状态',width : '100',align : 'center',formatter:function(item){
                		if(item.order_state==10){
                			return '未付款';
						}else if(item.order_state==20){
                			return '已付款';							
						}else if(item.order_state==30){
                			return '已兑换';													
                		}else{
                			return '已取消';
                		}
                	}},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
					if(item.order_state==20){
						button += '<a href="javascript:void(0);" onclick="duihuan('+item.order_id+')" class="btn btn-default btn-xs purple">兑换</a>&nbsp;';
        			}
					return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/activity_seckill/getOrderDataList',
	searchForm:'#search_condition',
});



//删除
function duihuan(order_id) {
	if (confirm("您确定要兑换吗?")) {
		$.post("/admin/a/activity_seckill/duihuan",{'order_id':order_id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}
$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})


</script>
