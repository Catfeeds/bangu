<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
.table-data thead th {
    font-size: 12px;
}
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>订单管理</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="1">待留位 </li>
			<li class="tab-red" data-val="2">已留位</li>
			<li class="tab-blue" data-val="3">已确定</li>
			<li class="tab-blue" data-val="4">已取消</li>
			<li class="tab-blue" data-val="5">退订列表</li>
		</ul>
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">产品标题：</span>
						<span ><input type="text" class="search-input" name="productname" placeholder="产品标题"></span>
					</li>
					<li class="search-list">
						<span class="search-title">供应商：</span>
						<span><input type="text" class="search-input" placeholder="供应商" id="company_name"  name="company_name"></span>
					</li>
					<li class="search-list">
						<span class="search-title">订单编号：</span>
						<span><input type="text" class="search-input" maxlength="12" name="ordersn" placeholder="订单编号"></span>
					</li>
					<li class="search-list">
						<span class="search-title">订单类型：</span>
						<span>
							<select name="user_type">
								<option value="-1">请选择</option>
								<option value="0">C端</option>
								<option value="1">B端</option>
							</select>
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">出团日期：</span>
						<span>
							<input type="text" id="starttime"  class="search-input" style="width:110px;" name="starttime" placeholder="开始日期" />
							<input type="text" id="endtime"  class="search-input" style="width:110px;"  name="endtime" placeholder="结束日期" />
					 	</span>
					</li>
					<li class="search-list">
						<span class="search-title">管家：</span>
						<span><input type="text" class="search-input" style="width:140px;" placeholder="管家" id="expert_name"  name="expert_name"></span>
					</li>
					<li class="search-list">
						<span class="search-title">出发地：</span>
						<span id='search-city'></span>
					</li>
					<li class="search-list">
						<span class="search-title">目的地：</span>
						<span>
							<input type="text" class="search-input" onclick="showDestBaseTree(this);" name="kindname" >
							<input type="hidden" name="destid">
						</span>
					</li>
					<li class="search-list">
						<input type="hidden" name="status" value="1">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<div class="detail-box order_refund" style="display:none;">
	<div class="db-body" style="width:600px;">
		<div class="db-title">
			<h4>退单</h4>
			<div class="db-close box-close">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-row">
					<div class="db-row-title">退单金额：</div>
					<div class="db-row-content"><input type="text" name="refund_money" /></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">退单理由：</div>
					<div class="db-row-content"><textarea name="reason"></textarea></div>
				</li>
			</ul>
			<div class="db-buttons">
				<input type="hidden" value="" name="refund_id" />
				<div class="box-close">关闭</div>
				<div class="refund_submit">确定</div>
			</div>
		</div>
	</div>
</div>
<div class="detail-box change-fee" style="display:none;">
	<div class="db-body" style="width:570px;">
		<div class="db-title">
			<h4>更改平台管理费</h4>
			<div class="db-close box-close">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-row">
					<div class="db-row-title">订单金额：</div>
					<div class="db-row-content"><input type="text" name="order-money" disabled="disabled" /></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">管理费：</div>
					<div class="db-row-content"><input type="text" name="fee_money" /></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">管理费率：</div>
					<div class="db-row-content"><input type="text" name="agent_rate" disabled="disabled" style="width:97%;" />%</div>
				</li>
			</ul>
			<div class="db-buttons">
				<input type="hidden" value="" name="oid" />
				<div class="box-close">关闭</div>
				<div class="change-submit">确定</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="/assets/js/admin/comboBox.js"></script>
<script src="/assets/js/jquery.extend.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>
function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1020px', '600px'],
		  title :'订单详情',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('/admin/a/orders/order/order_detail_info');?>?id="+id+'&type=1'
	});
}

var orderPay = {'0':'未付款','1':'已付款待确认','2':'已付款已确认','3':'退订中','4':'已退订','5':'未交款','6':'已交款'};
//待留位
var columns1 = [ {field : 'ordersn',title : '订单编号',width : '80',align : 'left'},
		{field : false,title : '类型',width : '40',align : 'center' ,formatter:function(item) {
				return item.user_type == 1 ? 'B端' : 'C端';
			}
		},
		{field : 'supplier_name',title : '供应商',width : '100',align : 'left'},
		{field : 'cityname',title : '出发地',width : '70',align : 'center'},
		{field : null,title : '产品标题',align : 'left', formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+')">'+item.productname+'</a>';
			}
		},
		{field : null,title : '人数',align : 'center', width : '50',formatter:function(item){
				return (item.dingnum*1+item.childnum*1+item.childnobednum*1).toFixed(0);
			}
		},
		{field : null,title : '总金额',align : 'center', width : '60',formatter:function(item){
				return (item.total_price*1 + item.settlement_price*1).toFixed(2);
			}
		},
		{field : 'usedate',title : '出团日期',align : 'center', width : '70'},
		{field : null,title : '支付状态',align : 'center', width : '80',formatter:function(item){
				return orderPay[item.ispay]
			}
		},
		{field : 'addtime',title : '下单时间',align : 'left', width : '75'},
		{field : 'expert_name',title : '专家',align : 'center', width : '60'},
		{field : null,title : '操作',align : 'center', width : '60',formatter: function(item){
			if(item.ispay == 0) {
				return '<a href="javascript:void(0);" onclick="cancel('+item.id+')" class="tab-button but-blue">取消</a>&nbsp;';
			} else {
				return '';
			}
		}
	}];
//已留位
var columns2 = [ {field : 'ordersn',title : '订单编号',width : '80',align : 'left'},
        {field : false,title : '类型',width : '30',align : 'center' ,formatter:function(item) {
     			return item.user_type == 1 ? 'B端' : 'C端';
     		}
     	},        
		{field : 'supplier_name',title : '供应商',width : '100',align : 'left'},
		{field : 'cityname',title : '出发地',width : '50',align : 'center'},
		{field : null,title : '产品标题',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+')">'+item.productname+'</a>';
			}
		},
		{field : null,title : '人数',align : 'center', width : '40',formatter:function(item){
				return (item.dingnum*1+item.childnum*1+item.childnobednum*1).toFixed(0);
			}
		},
		{field : null,title : '总金额',align : 'center', width : '50',formatter:function(item){
				return (item.total_price*1 + item.settlement_price*1).toFixed(2);
			}
		},
		{field : 'count_money',title : '支付金额',align : 'center', width : '60'},
		{field : 'usedate',title : '出团日期',align : 'left', width : '70'},
		{field : null,title : '支付状态',align : 'center', width : '80',formatter:function(item){
				return orderPay[item.ispay]
			}
		},
		{field : 'lefttime',title : '留位时间',align : 'left', width : '70'},
		{field : 'expert_name',title : '专家',align : 'center', width : '40'},
		{field : null,title : '操作',align : 'center', width : '40',formatter: function(item){
			button = '';
			if(item.ispay == 2) {
				button += '<a href="javascript:void(0);" money="'+item.count_money+'" val="'+item.id+'" onclick="order_refund(this);"  class="tab-button but-blue">退单</a>&nbsp;';
			} else if (item.ispay == 0) {
				button += '<a href="javascript:void(0);" onclick="cancel('+item.id+')" class="tab-button but-blue">取消</a>';
			}
			return button;
		}
	}];
//已确认
var columns3 = [ {field : 'ordersn',title : '订单编号',width : '80',align : 'left'},
                 {field : false,title : '类型',width : '30',align : 'center' ,formatter:function(item) {
          			return item.user_type == 1 ? 'B端' : 'C端';
          		}
          	},
		{field : 'supplier_name',title : '供应商',width : '100',align : 'left'},
		{field : 'cityname',title : '出发地',width : '50',align : 'center'},
		{field : null,title : '产品标题',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+')">'+item.productname+'</a>';
			}
		},
		{field : null,title : '人数',align : 'center', width : '30',formatter:function(item){
				return (item.dingnum*1+item.childnum*1+item.childnobednum*1).toFixed(0);
			}
		},
		{field : null,title : '总金额',align : 'center', width : '50',formatter:function(item){
				return (item.total_price*1 + item.settlement_price*1).toFixed(2);
			}
		},
		{field : 'count_money',title : '支付金额',align : 'center', width : '60'},
		{field : 'usedate',title : '出团日期',align : 'left', width : '70'},
		{field : null,title : '支付状态',align : 'center', width : '70',formatter:function(item){
				return orderPay[item.ispay]
			}
		},
		{field : 'confirmtime_supplier',title : '确认时间',align : 'left', width : '70'},
		{field : 'expert_name',title : '专家',align : 'center', width : '50'},
		{field : null,title : '操作',align : 'center', width : '40',formatter: function(item){
			var button = '';
			if (item.status >= 4 && item.balance_status == 0 && item.user_type == 0 && item.union_status == 0) {
				button += '<a href="javascript:void(0);" money="'+item.total_price+'" data-fee="'+item.platform_fee+'" data-agent="'+item.agent_rate+'" data-val="'+item.id+'" onclick="changeFee(this);" class="tab-button but-blue">改管理费</a>&nbsp;';
			}
			if (item.status == 4 && item.ispay == 2) {
				button += '<a href="javascript:void(0);" money="'+item.count_money+'" val="'+item.id+'" onclick="order_refund(this);" class="tab-button but-blue">退单</a>';
			}
			return button;
		}
	}];
//已取消
var columns4 = [ {field : 'ordersn',title : '订单编号',width : '80',align : 'left'},
                 {field : false,title : '类型',width : '30',align : 'center' ,formatter:function(item) {
           			return item.user_type == 1 ? 'B端' : 'C端';
           		}
           	},
		{field : 'supplier_name',title : '供应商',width : '100',align : 'left'},
		{field : 'cityname',title : '出发地',width : '50',align : 'center'},
		{field : null,title : '产品标题',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+')">'+item.productname+'</a>';
			}
		},
		{field : null,title : '人数',align : 'center', width : '30',formatter:function(item){
				return (item.dingnum*1+item.childnum*1+item.childnobednum*1).toFixed(0);
			}
		},
		{field : null,title : '总金额',align : 'center', width : '60',formatter:function(item){
				return (item.total_price*1 + item.settlement_price*1).toFixed(2);
			}
		},
		{field : 'count_money',title : '支付金额',align : 'center', width : '50'},
		{field : 'usedate',title : '出团日期',align : 'left', width : '70'},
		{field : null,title : '支付状态',align : 'center', width : '50',formatter:function(item){
				return orderPay[item.ispay]
			}
		},
		{field : 'canceltime',title : '取消时间',align : 'left', width : '70'},
		{field : 'expert_name',title : '专家',align : 'center', width : '50'}
	];
//已退订
var columns5 = [ {field : 'ordersn',title : '订单编号',width : '80',align : 'left'},
                 {field : false,title : '类型',width : '30',align : 'center' ,formatter:function(item) {
           			return item.user_type == 1 ? 'B端' : 'C端';
           		}
           	},
		{field : 'supplier_name',title : '供应商',width : '100',align : 'left'},
		{field : 'cityname',title : '出发地',width : '50',align : 'center'},
		{field : null,title : '产品标题',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+')">'+item.productname+'</a>';
			}
		},
		{field : null,title : '人数',align : 'center', width : '30',formatter:function(item){
				return (item.dingnum*1+item.childnum*1+item.childnobednum*1).toFixed(0);
			}
		},
		{field : null,title : '总金额',align : 'center', width : '50',formatter:function(item){
				return (item.total_price*1 + item.settlement_price*1).toFixed(2);
			}
		},
		{field : 'count_money',title : '支付金额',align : 'center', width : '60'},
		{field : 'usedate',title : '出团日期',align : 'left', width : '70'},
		{field : null,title : '支付状态',align : 'center', width : '50',formatter:function(item){
				return orderPay[item.ispay]
			}
		},
		{field : false,title : ' 退订时间',align : 'left', width : '70',
			formatter:function(item){
				if(item.canceltime!=null){
					return item.canceltime+'&nbsp;&nbsp;&nbsp;&nbsp;';
				}else{
					return '';
				}	
			}
		},
		{field : 'expert_name',title : '专家',align : 'center', width : '50'}
	];
//初始加载
change_status(1);
//导航栏切换
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	$("#search_condition").find('input').val('');
	$("#search_condition").find('select').val(0).change;
	var status = $(this).attr('data-val')
	$('input[name="status"]').val(status);
	change_status(status);
})

//根据状态加载数据
function change_status(status) {
	if (status == 1) {
		var columns = columns1;
	} else if (status == 2) {
		var columns = columns2;
	} else if (status == 3) {
		var columns = columns3;
	} else if (status == 4) {
		var columns = columns4;
	} else if (status == 5) {
		var columns = columns5;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/orders/order/getOrderData',
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
}


function changeFee(obj) {
	var changeObj = $('.change-fee');
	changeObj.find('input[name=oid]').val($(obj).attr('data-val'));
	changeObj.find('input[name=agent_rate]').val(($(obj).attr('data-agent')*100).toFixed(2));
	changeObj.find('input[name=order-money]').val($(obj).attr('money'));
	changeObj.find('input[name=fee_money]').val($(obj).attr('data-fee'));
	$('.change-fee,.mask-box').show();
}

$('input[name=fee_money]').verifNum({
		callback:function() {
			var money = $('input[name=order-money]').val();
			var agent = $('input[name=fee_money]').val();
			$('input[name=agent_rate]').val((agent/money *100).toFixed(2));
		}
	});

$('.change-submit').click(function(){
	var status = $('input[name="status"]').val();
	var changeObj = $('.change-fee');
	$.ajax({
			url:'/admin/a/orders/order/changeAgentRate',
			type:'post',
			dataType:'json',
			data:{orderid:changeObj.find('input[name=oid]').val(),fee:changeObj.find('input[name=fee_money]').val()},
			success:function(data) {
				if (data.code == 2000) {
					change_status(status);
					alert(data.msg);
					$('.change-fee,.mask-box').hide();
				} else {
					alert(data.msg);
				}
			}
		});
})

$.ajax({
	url:'/common/selectData/getDestAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-dest').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['dest_country','dest_province','dest_city']
		});
	}
});
$.ajax({
	url:'/common/selectData/getStartplaceJson',
	dataType:'json',
	type:'post',
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});

$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
//取消订单
function cancel(id) {
	if (confirm('您确定要取消此订单')) {
		var status = $('input[name="status"]').val();
		$.post("/admin/a/orders/order/cancel",{id:id},function(json) {
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				change_status(status);
			} else {
				alert(data.msg);
			}
		})
	}
}

//退单
function order_refund(obj) {
	var money = $(obj).attr('money');
	var id = $(obj).attr('val');
	$("input[name='refund_id']").val(id);
	$("input[name='refund_money']").val(money);
	$("textarea[name='reason']").val('');
	$(".order_refund,.mask-box").show();
}
var i = true;
$(".refund_submit").click(function(){
	if (i == false) {
		return false;
	} else {
		i = false;
	}
	var money = $("input[name='refund_money']").val();
	var id = $("input[name='refund_id']").val();
	var status = $("input[name='status']").val();
	var reason = $("textarea[name='reason']").val();
	$.post("/admin/a/orders/order/refund_order",{id:id,money:money,reason:reason},function(json){
		i = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$(".order_refund,.mask-box").hide();
		} else {
			alert(data.msg);
		}
	});
})
</script>									

