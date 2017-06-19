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
                        <td class="order_info_title">所属旅行社:</td>
                        <td colspan="3" ><?php echo $departData['union_name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">联系人:</td>
                        <td class="w_40_p"><?php echo $departData['linkman']?></td>
                        <td class="order_info_title">所属部门:</td>
                        <td class="w_40_p"><?php echo $departData['pname']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">联系电话:</td>
                        <td class="w_40_p"><?php echo $departData['linkmobile']?></td>
                        <td class="order_info_title"></td>
                        <td class="w_40_p"></td>
                    </tr>
                </table>
            </div>
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">额度使用日志</span>
                </div>
                <form class="search_form" method="post" id="log-form" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>使用日期</label>
                                <input type="text" name="starttime" id="starttime" style="width:110px;" class="search_input" placeholder="开始时间"/>
                                <input type="text" name="endtime" id="endtime" style="width:110px;" class="search_input" placeholder="开始时间"/>
                            </div>
                            <div class="search_group">
                            	<label>订单号</label>
                                <input type="text" name="ordersn" class="search_input" placeholder="订单号"/>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="depart_id" value="<?php echo $departData['id']?>">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                   </form>
                <div id="log-list"></div>
            </div>
            
        </div>
	</div>
	
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script>
var columns = [ {field : 'addtime',title : '使用日期',width : '135',align : 'center'},
	            {field : 'type',title : '说明',width : '130',align : 'center'},
	            {field : false,title : '订单号',width : '90',align : 'center',formatter:function(result) {
		            	if (typeof result.order_sn == 'string') {
							return '<a href="/admin/a/orders/order/order_detail_info?id='+result.order_id+'" target="_blank">'+result.order_sn+'</a>';
		            	} else {
			            	return '';
			            }
		         	}
				},
	            {field : false,title : '订单金额',width : '90',align : 'center' ,formatter:function(result) {
	            	    return result.order_price == 0 ? '' : result.order_price;
		            }
	            },
	            {field : false,title : '收款',width : '90',align : 'center',formatter:function(result) {
						return result.receivable_money == 0 ? '' :'<span class="green">'+result.receivable_money+'</span>';
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
						return result.cash_limit == 0 ? '' : (result.cash_limit*1).toFixed(2);
		            }
	            },
	            {field : false,title : '信用余额',width : '90',align : 'center',formatter:function(result) {
						return result.credit_limit == 0 ? '' : (result.credit_limit*1).toFixed(2);
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
		searchForm:'#log-form',
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
</script>
</body>
</html>
