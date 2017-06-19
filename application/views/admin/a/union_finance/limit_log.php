<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
		.search-time input{width:110px;}
		/*详情 start*/
		.order_detail{margin-bottom: 20px;}
		.but-list{
			text-align: right;
			margin-top: 10px;
		}
		.but-list button{
			background: rgb(255, 255, 255) none repeat scroll 0% 0%;
			border: 1px solid rgb(204, 204, 204);
			padding: 3px;
			border-radius: 3px;
			cursor: pointer;
			margin-left: 10px;
		}
		.but-list button:hover{background: #2dc3e8;color: #fff;}
		.table_td_border > tbody > tr > td {
		    width: 40%;
		}
		/*详情 end*/
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">信用额度查询管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                            <div class="search_group">
                            	<label>营业部</label>
                                <input type="text" name="depart_name" class="search_input" placeholder="营业部名称"/>
                            </div>
                            <div class="search_group">
                            	<label>旅行社</label>
                                <input type="text" name="union_name" class="search_input" placeholder="旅行社名称"/>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
    
<div class="order_detail" id="detail-box" style="display:none;">
	<h2 class="lineName headline_txt">额度使用详细</h2>
</div>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
var columns = [ {field : 'name',title : '营业部',width : '110',align : 'center'},
        		{field : 'union_name',title : '旅行社',width : '160',align : 'center'},
        		{field : false,title : '信用额度',width : '100',align : 'center',formatter:function(result){
						return (result.credit_limit*1).toFixed(2);
	        		}
	    		},
        		{field : false,title : '现金额度',align : 'center', width : '120',formatter:function(result){
						return (result.cash_limit*1).toFixed(2);
            		}
        		},
        		{field : false,title : '操作',align : 'center', width : '120',formatter:function(result) {
						return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
            		}
        		}]
        		
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/union_finance/limit_log/getDepartQuota',
	pageSize:30,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1100px', '600px'],
		  title :'营业部额度使用详细',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/union_finance/limit_log/detail');?>"+"?id="+id
	});
}


function detail1(id ,type) {
	$.ajax({
		url:'/admin/a/union_finance/limit_log/depart_detail',
		type:'post',
		data:{id:id},
		dataType:'json',
		success:function(result) {
			if ($.isEmptyObject(result)) {
				layer.alert('没有数据', {icon: 2});
			} else {
				$('#detail-box').find('h2').nextAll().remove();
				//基础信息
				var columnData = [
							{title:'所属旅行社',content : result.union_name , type : 'all'},
							{title:'联系人',content : result.linkman},
							{title:'所属部门',content : result.pname},
							{title:'联系电话',content : result.linkmobile}
						];
				createDetailTab('基础信息' ,columnData ,$('#detail-box'));
				
				//关联订单
				getSettlementOrder(result.id ,$('#detail-box') ,result.amount);
				//按钮
				createDetailBut({'layui-layer-close':'关闭'} ,$('#detail-box'));
				layer.open({
					  type: 1,
					  title: false,
					  closeBtn: 0,
					  area: '1200px',
					  shadeClose: false,
					  content: $('#detail-box')
				});
			}
		}
	});
}
//额度使用日志
function getSettlementOrder(id ,boxObj) {
	$('#detail-form').find('input[name=detail_id]').val(id);
	var html = '<div class="content_part"><div class="small_title_txt clear"><span class="txt_info fl">额度使用日志</span></div></div>';
	html += '<form method="post" id="detail-form">';
	html += '<div class="search_form_box clear">';
	
	html += '<div class="search_group"><label>使用日期</label>';
	html += '<input type="text" name="starttime" class="search_input" style="width:110px;" id="starttime" placeholder="开始时间"/>';
	html += '<input type="text" name="endtime" class="search_input" style="width:110px;" id="endtime" placeholder="结束时间"/>';
	html += '</div>';
        
	html += '<div class="search_group"><label>订单编号</label>';
	html += '<input type="text" name="ordersn" class="search_input" placeholder="订单编号"/>';
	html += '</div>';

	html += '<div class="search_group">';
	html += '<input type="hidden" name="detail_id" value="'+id+'" /><input type="submit" name="submit" class="search_button" value="搜索"/>';
	html += '</div>';
	
	html += '</div></form>';
	html += '<div id="log-list"></div>';
	boxObj.append(html);

	var columns = [ {field : 'addtime',title : '使用日期',width : '150',align : 'center'},
	            {field : 'type',title : '说明',width : '130',align : 'center'},
	            {field : false,title : '订单号',width : '120',align : 'center',formatter:function(result) {
		            	if (typeof result.ordersn == 'string') {
							return '<a href="/admin/a/orders/order/order_detail_info?id='+result.order_id+'" target="_blank">'+result.ordersn+'</a>';
		            	} else {
			            	return '';
			            }
		         	}
				},
	            {field : false,title : '订单金额',width : '100',align : 'center' ,formatter:function(result) {
	            		return (result.total_price*1 + result.settlement_price*1).toFixed(2);
		            }
	            },
	            {field : false,title : '收款',width : '90',align : 'center',formatter:function(result) {
						return result.receivable_money == 0 ? '' :'<span class="green">+'+result.receivable_money+'</span>';
		            }
	            },
	            {field : false,title : '扣款',width : '90',align : 'center',formatter:function(result) {
						return result.cut_money == 0 ? '' :'<span class="red">'+result.cut_money+'</span>';
		            }
	            },
	            {field : false,title : '退款',width : '90',align : 'center',formatter:function(result) {
						return result.refund_monry == 0 ? '' :'<span class="green">'+result.refund_monry+'</span>';
		            }
	            },
	            {field : false,title : '单团额度',width : '90',align : 'center',formatter:function(result) {
		            	if (result.sx_limit <0) {
							return '<span class="red">'+result.sx_limit+'</span>';
			            } else if (result.sx_limit >0) {
			            	return '<span class="green">'+result.sx_limit+'</span>';
			            } else {
				            return '';
				        }
		            }
	            },
	            {field : false,title : '现金余额',width : '90',align : 'center',formatter:function(result) {
						return result.cash_limit == 0 ? '' : result.cash_limit;
		            }
	            },
	            {field : false,title : '信用余额',width : '90',align : 'center',formatter:function(result) {
						return result.credit_limit == 0 ? '' : result.credit_limit;
		            }
	            },
	            {field : false,title : '可用余额',align : 'center', width : '90',formatter:function(result) {
	            		return (result.cash_limit*1 + result.credit_limit*1).toFixed(2);
		            }
	            }]
	            	
	$("#log-list").pageTable({
		columns:columns,
		url:'/admin/a/union_finance/limit_log/getLimitLogData',
		pageSize:10,
		searchForm:'#detail-form',
		tableClass:'table table-bordered table_hover'
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
}

</script>
</html>


