<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>订单详情</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/order_detail.css');?>" rel="stylesheet" />
	<style type="text/css">
		body:before { background:#fff;}
		.page-content { margin-left:0;}
		.order_detail { padding-bottom:40px;}
		.table_list { display:none;}
		.txt_info { color:#000;font-weight:700 !important;}
		.tongguo i { display:inline-block;width:16px;height:16px;vertical-align:middle;background:url(/assets/ht/img/tongguo.gif) center center no-repeat;}
		.shenhe td:first-child { position:relative;}
		.shenhe i { display:inline-block;width:16px;height:16px;vertical-align:middle;background:url(/assets/ht/img/shenhe.gif) center center no-repeat;}
		.jujue i { display:inline-block;width:16px;height:16px;vertical-align:middle;background:url(/assets/ht/img/jujue.jpg) center center no-repeat;}
		.jujue td { color:#BCBCBC !important;}
		.table_hover>tbody>tr.add_fee:hover{ background-color:#fff!important}
		.jkxx .table_hover>tbody>tr:hover{ background-color:#fff!important}
		.table thead>tr>th { padding:5px 0;}
		.add_fee td { position:relative;padding:4px 8px !important;}
		.add_fee select,.add_fee input { width:80%;height:20px;}
		.other_obj { display:none;}
		.add_fee .save { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;margin-right:5%;background:url(/assets/ht/img/dui.png) 0px center no-repeat;color:#000;cursor:pointer;}
		.add_fee .cancle { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;margin-left:5%;background:url(/assets/ht/img/cuo.png) 0px center no-repeat;color:#000;cursor:pointer;}
		.zongji span { padding-right:200px;font-weight: 700;}
		.txt_info { line-height:28px;padding-left:0 !important;}
		.apple_tuiding { padding:0px 5px;margin-left:20px;position:relative;top:-3px;}
		input[type="checkbox"] { position:relative;opacity:1;left:0;width:auto;height:auto;}
		.layui-layer-page { margin-left:0;}
		.title_txt { float:right;width:14%;display:inline-block;}
		.title_txt p { color:#f00;}
	    label{margin-bottom: 0px}
	    th td{text-align:center;}
	    .but {background: #2DC3E8;border: 1px solid rgb(204, 204, 204);border-radius: 3px;padding: 5px;cursor: pointer;margin-bottom: 15px;color:#fff;}
		.tab_content{padding:0px;float:none;}
		.table_td_border>tbody>tr{height:30px;}
		#bodyMsg{padding-bottom:40px;}
		.table tr{line-height:26px;}
		.table th{text-align:center !important;}
		.table tr td{line-height:26px;text-align:center !important;padding-top: 5px;}
		.table tr td input{height:22px; padding-left: 3px;}
		.page-box .count-name{float: left;margin-top: 23px;}
		.page-box .count-num{color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;}
		.add-row-but .save{  display: inline-block;width: 38px;text-align: center;padding-left: 14px;box-sizing: border-box;margin-right: 5%;background: url(/assets/ht/img/dui.png) 0px center no-repeat;color: #000;cursor: pointer;}
		.add-row-but .cancle{  display: inline-block;width: 50px;text-align: center;padding-left: 5px;box-sizing: border-box;margin-left: 5%;background: url(/assets/ht/img/cuo.png) 0px center no-repeat;color: #000;cursor: pointer;}
		.content_part{padding:10px;margin-bottom:0px;}
		.table_con{padding:10px;}
		.oicon{width:42%;}
	</style>
</head>
<body>
<?php 
	//订单状态
	$statusArr = array(
		'-4' =>'已取消',	
		'-3' =>'取消中',
		'0' =>'待留位',
		'1' =>'已留位',
		'4' =>'已控位',
		'5' =>'已出行',
		'6' =>'已评论',
		'7' =>'已投诉'
	);
	//支付状态
	$payArr = array(
		'0' =>'未付款',
		'1' =>'已付款未确认',
		'2' =>'已付款已确认',
		'3' =>'退款中',
		'4' =>'退款完成',
		'5' =>'未交款',
		'6' =>'已交款'
	);
?>
    <div class="page-body w_1000" id="bodyMsg">
        <div class="order_detail">
            <h2 class="lineName headline_txt"><?php echo $orderData['productname']?></h2>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                    <span class="order_time fr"><?php echo $orderData['addtime']?></span>
                </div>
                <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                	<tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="3">
                        	<?php echo $orderData['productname']?>
                        	<?php if ($orderData['line_kind'] ==1):?>
                        	<a href="javascript:void(0);" suit-id="<?php echo $orderData['suitid']?>" usedate="<?php echo $orderData['usedate']?>" data-val="<?php echo $orderData['productautoid']?>" class="see_trip">【查看行程】</a>
                        	<?php endif;?>
                        </td>
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">团号:</td>
                        <td class="oicon"><?php echo $orderData['item_code']?></td>
                        <td class="order_info_title">订单编号:</td>
                        <td class="oicon"><?php echo $orderData['ordersn']?></td>
                    </tr>
                     <tr height="40">
                    	<td class="order_info_title">出发日期:</td>
                        <td class="oicon"><?php echo $orderData['usedate']?></td>
                        <td class="order_info_title">下单时间:</td>
                        <td class="oicon"><?php echo $orderData['addtime']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单状态:</td>
                        <td class="oicon"><?php echo array_key_exists($orderData['status'], $statusArr) ? $statusArr[$orderData['status']] : '未知'; ?></td>
                        <td class="order_info_title">支付状态:</td>
                        <td class="oicon"><?php echo array_key_exists($orderData['ispay'], $payArr) ? $payArr[$orderData['ispay']] : '未知';?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">参团人数:</td>
                        <td class="oicon">
                        <?php if($orderData['unit'] >= 2):?>
                        	<span><?php echo $orderData['suitname']?></span>&nbsp;&nbsp;
                            <span><?php echo $orderData['suitnum'].'人 /份'?> </span>&nbsp;&nbsp;
                            <span><?php echo $orderData['suitnum'].'*'.$orderData['price']?></span>
                        <?php else:?>
                        	<span>成人:(<?php echo $orderData['dingnum'].'*'.$orderData['price'] ?>)</span>&nbsp;
                            <span>小童占床:(<?php echo $orderData['childnum'].'*'.$orderData['childprice'] ?>)</span>&nbsp;
                            <span>小童不占床:(<?php echo $orderData['childnobednum'].'*'.$orderData['childnobedprice'] ?>)</span>
                        <?php endif;?>
                        </td>
                        <td class="order_info_title">线路类型:</td>
                        <td class="oicon">
                        <?php 
                        	if ($orderData['line_kind'] ==1) {
                        		if ($orderData['producttype'] ==0) {
                        			echo '正常线路';
                        		} else {
                        			echo '包团线路';
                        		}
                        	} elseif ($orderData['line_kind'] ==2) {
                        		echo '旅行社单项产品';
                        	} elseif ($orderData['line_kind'] ==3) {
                        		echo '供应商单项产品';
                        	}
                        ?>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单金额:</td>
                        <td class="oicon">￥<?php echo round($orderData['total_price']+$orderData['settlement_price'] ,2)?></td>
                        <td class="order_info_title">保险费用:</td>
                        <td class="oicon">￥<?php echo empty($orderData['settlement_price']) ? 0 : $orderData['settlement_price']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">已收款:</td>
                        <td class="oicon">￥<?php echo $moneyYs?></td>
                        <td class="order_info_title">平台佣金:</td>
                        <td class="oicon">￥<?php echo $orderData['platform_fee']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">管家佣金:</td>
                        <td class="oicon">￥<?php echo $orderData['agent_fee']?></td>
                        <td class="order_info_title">外交佣金:</td>
                        <td class="oicon">￥<?php echo $orderData['diplomatic_agent']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">应付供应商:</td>
                        <td class="oicon">￥<?php echo $orderData['supplier_cost']?></td>
                        <td class="order_info_title">已付供应商:</td>
                        <td class="oicon">￥<?php echo $orderData['balance_money']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">管家:</td>
                        <td class="oicon"><?php echo $orderData['expert_name']?>/<?php echo $orderData['expert_mobile'];?></td>
                        <td class="order_info_title">供应商:</td>
                        <td class="oicon"><?php echo $orderData['supplier_name'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">优惠劵:</td>
                        <td class="oicon"><?php echo $orderData['couponprice']?></td>
                        <td class="order_info_title">兑换码:</td>
                        <td class="oicon"><?php echo $orderData['redeemPrice'];?></td>
                    </tr>
                </table>
                <!-- 预订人信息 -->
                <div class="small_title_txt clear">
                    <span class="txt_info fl">预订人信息</span>
                </div>
                <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">预定人:</td>
                        <td class="oicon"><?php echo $orderData['linkman'];?></td>
                        <td class="order_info_title">邮箱:</td>
                        <td class="oicon"><?php echo $orderData['linkemail'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">手机号:</td>
                        <td class="oicon"><?php echo $orderData['linkmobile'];?></td>
                        <td class="order_info_title">备用手机号:</td>
                        <td class="oicon"><?php echo $orderData['spare_mobile'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td colspan="3"><?php echo $orderData['spare_remark'];?></td>
                    </tr>
                </table>
                
            </div>

            <div class="table_con">
                <div class="itab">
                    <ul id="tab-nav">
                        <li data-val="1"><a href="###" class="active">应收账单</a></li>
                        <li data-val="2"><a href="###">应付账单</a></li>
                        <li data-val="3"><a href="###">平台佣金账单</a></li>
                        <li data-val="4"><a href="###">保险账单</a></li>
                        <li data-val="5"><a href="###">参团人名单</a></li>
                        <li data-val="6"><a href="###">操作日志</a></li>
                        <li data-val="7"><a href="###">收款记录</a></li>
                        <li data-val="8"><a href="###">外交佣金账单</a></li>
                    </ul>
                </div>
                <form id="list-form" action="post">
                	<input type="hidden" name="orderId" value="<?php echo $orderData['id']?>">
                </form>
                <div class="tab_content">
                	<!-- 应收账单列表 -->
                    <div class="table_list" style="display:block;" id="bill-ys">
                    	<!-- C端下单并且是没有支付的订单，才可以更改应收 -->
                    	<?php if ($orderData['status'] <= 4 && $orderData['user_type'] == 0 && $type==1):?>
                    	<button class="but" onclick="add_row(this ,1);">新增应收</button>
                    	<?php endif;?>
                    	<table class="table table-bordered table_hover">
                    		<thead class="">
                    			<tr>
                    				<th style="width:100px;">单价</th>
                    				<th style="width:60px;">数量</th>
                    				<th style="width:100px;">小计</th>
                    				<th style="width:120px;">录入人</th>
                    				<th style="width:120px;">录入时间</th>
                    				<th style="width:350px;">备注</th>
                    				<th style="width:90px;">审核状态</th>
                    			</tr>
                    		</thead>
                    		<tbody class="">
                    			<?php foreach($ysArr as $val):?>
                    			<tr>
                    				<td style="text-align:center"><?php echo $val['price']?></td>
                    				<td style="text-align:center"><?php echo $val['num']?></td>
                    				<td style="text-align:center"><?php echo $val['amount']?></td>
                    				<td style="text-align:center"><?php echo $val['user_name']?></td>
                    				<td style="text-align:center"><?php echo $val['addtime']?></td>
                    				<td style="text-align:left"><?php echo $val['remark']?></td>
                    				<td style="text-align:center">
                    					<?php 
                    						if ($val['status'] == 0) {
                    							echo '申请中';
                    						} elseif ($val['status'] ==1){
                    							echo '已通过';
                    						} else {
                    							echo '已拒绝';
                    						}
                    					?>
                    				</td>
                    			</tr>
                    			<?php endforeach;?>
                    		</tbody>
                    	</table>
                    	<div class="page-box">
                    		<span class="count-name">总计：<span class="count-num" ><?php echo $orderData['total_price']?></span>元</span>
                    	</div>
                    </div>
                    
                    <!-- 应付账单 -->
                    <div class="table_list" id="bill-yf">
                    	<?php if ($orderData['user_type'] ==0 && $orderData['status'] <= 4  && $type==1):?>
                    	<button class="but " onclick="add_row(this ,2);" >新增应付</button>
                    	<?php endif;?>
                    	<table class="table table-bordered table_hover">
                    		<thead class="">
                    			<tr>
                    				<th style="width:100px;">单价</th>
                    				<th style="width:60px;">数量</th>
                    				<th style="width:100px;">小计</th>
                    				<th style="width:90px;">申请人</th>
                    				<th style="width:90px;">申请人类型</th>
                    				<th style="width:110px;">新增时间</th>
                    				<th style="width:300px;">备注</th>
                    				<th style="width:90px;">审核状态</th>
                    			</tr>
                    		</thead>
                    		<tbody class="">
                    			<?php foreach($yfArr as $val):?>
                    			<tr>
                    				<td style="text-align:center"><?php echo $val['price']?></td>
                    				<td style="text-align:center"><?php echo $val['num']?></td>
                    				<td style="text-align:center"><?php echo $val['amount']?></td>
                    				<td style="text-align:center"><?php echo $val['user_name']?></td>
                    				<td style="text-align:center">
                    				<?php 
                    					if (array_key_exists($val['user_type'], $userType)){echo $userType[$val['user_type']];}
                    				?>
                    				</td>
                    				<td style="text-align:left"><?php echo $val['addtime']?></td>
                    				<td style="text-align:left"><?php echo $val['remark']?></td>
                    				<td style="text-align:center">
                    					<?php 
                    						if ($val['status'] == 0) {
                    							echo '申请中';
                    						} elseif ($val['status'] ==1){
                    							echo '经理通过';
                    						} elseif ($val['status'] == 3) {
                    							echo '经理拒绝';
                    						} else {
                    							if ($val['depart_id'] >0) {
                    								if ($val['status'] ==2) {
                    									echo '供应商通过';
                    								} else {
                    									echo '供应商拒绝';
                    								}
                    							} else {
                    								if ($val['status'] ==2) {
                    									echo '平台通过';
                    								} else {
                    									echo '平台拒绝';
                    								}
                    							}
                    						}
                    					?>
                    				</td>
                    			</tr>
                    			<?php endforeach;?>
                    		</tbody>
                    	</table>
                    	<div class="page-box">
                    		<span class="count-name">总计：<span class="count-num" ><?php echo $orderData['supplier_cost']?></span>元</span>
                    	</div>
                    </div>
                    <!-- 平台管理费账单 -->
                    <div class="table_list" id="bill-yj">
                    	<?php if ($orderData['user_type'] == 0 && $orderData['status'] <= 4 && $type==1):?>
                    	<button class="but" onclick="add_row(this,3);">更改管理费</button>
                    	<?php endif;?>
                    	<table class="table table-bordered table_hover">
                    		<thead class="">
                    			<tr>
                    				<th style="width:100px;">单价</th>
                    				<th style="width:60px;">数量</th>
                    				<th style="width:100px;">小计</th>
                    				<th style="width:90px;">申请人</th>
                    				<th style="width:90px;">申请人类型</th>
                    				<th style="width:110px;">新增时间</th>
                    				<th style="width:300px;">备注</th>
                    				<th style="width:90px;">审核状态</th>
                    			</tr>
                    		</thead>
                    		<tbody class="">
                    			<?php foreach($yjArr as $val):?>
                    			<tr>
                    				<td style="text-align:center"><?php echo $val['price']?></td>
                    				<td style="text-align:center"><?php echo $val['num']?></td>
                    				<td style="text-align:center"><?php echo $val['amount']?></td>
                    				<td style="text-align:center"><?php echo $val['user_name']?></td>
                    				<td style="text-align:center">
                    				<?php 
                    					if (array_key_exists($val['user_type'], $userType)){echo $userType[$val['user_type']];}
                    				?>
                    				</td>
                    				<td style="text-align:left"><?php echo $val['addtime']?></td>
                    				<td style="text-align:left"><?php echo $val['remark']?></td>
                    				<td style="text-align:center">
                    					<?php 
                    						if ($val['status'] == 0) {
                    							echo '申请中';
                    						} elseif ($val['status'] ==1){
                    							echo '经理通过';
                    						} elseif ($val['status'] == 3) {
                    							echo '经理拒绝';
                    						} else {
                    							if ($val['union_id'] >0) {
                    								if ($val['status'] ==2) {
                    									echo '旅行社通过';
                    								} else {
                    									echo '旅行社拒绝';
                    								}
                    							} else {
                    								if ($val['status'] ==2) {
                    									echo '平台通过';
                    								} else {
                    									echo '平台拒绝';
                    								}
                    							}
                    						}
                    					?>
                    				</td>
                    			</tr>
                    			<?php endforeach;?>
                    		</tbody>
                    	</table>
                    	<div class="page-box">
                    		<span class="count-name">总计：<span class="count-num" ><?php echo $orderData['platform_fee']?></span>元</span>
                    	</div>
                    </div>
                    <div class="table_list" id="bill-bx"></div>
                    <div class="table_list" id="name-list"></div>
                    <div class="table_list" id="order-log"></div>
                    <div class="table_list" id="order-receivable"></div>
                    <div class="table_list" id="diplomatic-agent"></div>
                </div>
            </div>
        </div>
	</div>

</body>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="/assets/js/jquery.extend.js"></script>
<script type="text/javascript">
var orderid = <?php echo $orderData['id'];?>;

function add_row(obj ,type) {
	var html = '<tr>'+
					'<td><input type="text" name="price" onblur="calculation(this);" style="width:80px;"></td>'+
					'<td><input type="text" name="num" onblur="calculation(this);" style="width:50px;"></td>'+
					'<td><input type="text" name="amount" readonly="readonly" style="width:80px;"></td>'+
					'<td><?php echo $this->realname; ?></td>';
					if (type == 2 || type ==3) {
						html += '<td>平台</td>';
					}
			html+=	'<td><?php echo date('Y-m-d H:i:s' ,time()); ?></td>'+
					'<td><input type="text" name="remark" style="width:280px;"></td>'+
					'<td class="add-row-but">'+
						'<span class="save" onclick="add_bill(this ,'+type+');">保存</span>'+
						'<span class="cancle" onclick="cancle(this);">取消</span>'+
					'</td>'+
				'</tr>';
	$(obj).next('table').find('tbody').append(html);
	$(obj).next('table').find('input[name=price]').verifNum({digit:2,isNegative:true});
	$(obj).next('table').find('input[name=num]').verifNum({});
}
//保存新增的应收
var bill = true;
function add_bill(obj ,type) {
	if (bill == false) {
		return false;
	} else {
		bill = false;
	}
	var trObj = $(obj).parents('tr');
	var price = trObj.find('input[name=price]').val();
	var num = trObj.find('input[name=num]').val();
	var remark = trObj.find('input[name=remark]').val();
	if (price == 0 || (price.substring(0,1)=='-') && price.length ==1) {
		layer.alert('请填写单价', {icon: 2,title:'错误提示'});
		bill = true;
		return false;
	}
	if (num < 1) {
		layer.alert('请填写数量', {icon: 2,title:'错误提示'});
		bill = true;
		return false;
	}
	if (remark.length < 1) {
		layer.alert('请填写备注', {icon: 2,title:'错误提示'});
		bill = true;
		return false;
	}
	var index = layer.msg('提交中，请稍后', { icon: 16, shade: 0.8,time: 200000 });
	if (type == 1) {
		url = '/admin/a/orders/order/addOrderYs';
	} else if (type == 2) {
		url = '/admin/a/orders/order/addOrderYf';
	} else {
		url = '/admin/a/orders/order/addOrderYj';
	}
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:{'id':orderid,'price':price,'num':num,'remark':remark},
		success:function(result) {
			layer.close(index);
			bill = true;
			if (result.code == 2000) {
				layer.confirm('操作成功', {btn: ['确认']},function(index){
							window.location.reload(); 
						});
			} else {
				layer.alert(result.msg, {icon: 2,title:'错误提示'});
			}
		}
	});
}

//删除增加的账单信息填写行
function cancle(obj){
	$(obj).parents('tr').remove();
}

function calculation(obj) {
	var trObj = $(obj).parents('tr');
	var price = trObj.find('input[name=price]').val();
	var num = trObj.find('input[name=num]').val();
	if (price == 0 || num ==0) {
		var amount = '';
	} else {
		var amount = (price*1 * (num*1)).toFixed(2);
	}
	if (amount == 0) {
		amount = '';
	}
	trObj.find('input[name=amount]').val(amount);
}

$(".see_trip").click(function(){
	var line_id=$(this).attr('data-val');
	var suit_id=$(this).attr('suit-id');
	var usedate=$(this).attr('usedate');
	window.top.openWin({
		  type: 2,
		  area: ['860px', '600px'],
		  title :'线路行程',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/lines/line/trip');?>"+"?id="+line_id+"&usedate="+usedate+"&suit_id"+suit_id
	});
})
$(".trip_close").click(function(){
	$(".trip_info_box,.mask_layer").hide();
	$("body").css("overflow","auto");
})
function openWin(settings){
	layer.open(settings);
}
//更改管理费
$('#update-fee').click(function(){
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#fee-box')
	});
})

var maxNum = <?php echo round($orderData['total_price'] - $orderData['platform_fee'] ,2);?>;
var oldFee = <?php echo $orderData['platform_fee'];?>;
$('input[name=platform_fee]').verifNum({
	digit:2,
	isNegative:true,
	maxNum:maxNum,
	minNum:'-'+oldFee,
	callback:function() {
		var fee = $('input[name=platform_fee]').val();
		var firstStr = fee.substring(0,1);
		if (firstStr == '-') {
			var num = fee.substring(1);
			$('input[name=fee]').val((oldFee-num).toFixed(2));
		} else {
			$('input[name=fee]').val((fee*1+oldFee).toFixed(2));
		}
	}
});


var f = true;
$('#form-fee').submit(function() {
	if (f == true) {
		f = false;
	} else {
		return false;
	}
	$.ajax({
		url:'/admin/a/orders/order/updatePlatformFee',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			f = true;
			if (result.code == '2000') {
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


//tab切换
$('#tab-nav').find('li').click(function(){
	var type = $(this).attr('data-val');
	$(this).find('a').addClass('active');
	$(this).siblings().find('a').removeClass('active');
	if (type == 1) {
		$('#bill-ys').show().siblings().hide();
	} else if (type == 2) {
		$('#bill-yf').show().siblings().hide();
	} else if (type == 3) {
		$('#bill-yj').show().siblings().hide();
	} else if (type == 4) {
		$('#bill-bx').show().siblings().hide();
	} else if (type == 5) {
		$('#name-list').show().siblings().hide();
	} else if (type == 6) {
		$('#order-log').show().siblings().hide();
	} else if (type == 7) {
		$('#order-receivable').show().siblings().hide();
	} else if (type == 8) {
		$('#diplomatic-agent').show().siblings().hide();
	}
})
//外交佣金
var userArr = {1:'管家',2:'供应商',3:'平台',4:'联盟'};
var billWj = [ {field : 'amount',title : '小计',width : '100',align : 'center'},
       		{field : 'num',title : '数量',width : '60',align : 'center'},
    		{field : 'price',title : '单价',width : '100',align : 'center'},
    		{field : false,title : '录入人类型',align : 'center', width : '90',formatter:function(result) {
					if (typeof userArr[result.user_type] == 'undefined') {
						return '未知';
					} else {
						return userArr[result.user_type];
					}
        		}
    		},
    		{field : false,title : '录入人',align : 'center', width : '120',formatter:function(result) {
					if (result.user_type == 1) {
						return result.expert_name;
					} else if (result.user_type ==2) {
						return result.supplier_name;
					} else if (result.user_type == 3) {
						return result.admin_name;
					} else  if (result.user_type == 4) {
						return result.employee_name;
					} else {
						return '';
					}
        		}
    		},
    		{field : 'addtime',title : '录入时间',align : 'center', width : '120'},
    		{field : 'remark',title : '备注',align : 'center', width : '200'}]

var money = <?php echo $orderData['diplomatic_agent'];?>;
$("#diplomatic-agent").pageTable({
	columns:billWj,
	url:'/admin/a/orders/order/getOrderBillWj',
	pageSize:20,
	searchForm:'#list-form',
	tableClass:'table table-bordered table_hover',
	isStatistics:true,
	statisticsContent:'<span style="float: left;margin-top: 23px;">总计：<span style="color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;">'+money+'</span>元</span>'
});

//保险账单
var billBx = [ {field : 'amount',title : '小计',width : '120',align : 'center'},
       		{field : 'num',title : '数量',width : '120',align : 'center'},
    		{field : 'price',title : '单价',width : '110',align : 'center'},
    		{field : 'insurance_name',title : '保险名称',align : 'center', width : '140'},
    		{field : false,title : '保险所属',align : 'center', width : '160',formatter:function(result) {
					return result.belong_id == 0 ? '帮游' : result.union_name;
        		}
    		}]

var money = <?php echo $orderData['settlement_price'];?>;
$("#bill-bx").pageTable({
	columns:billBx,
	url:'/admin/a/orders/order/getBillBxJson',
	pageSize:20,
	searchForm:'#list-form',
	emptyMsg:'没有购买保险',
	emptyHeight:100,
	tableClass:'table table-bordered table_hover',
	isStatistics:true,
	statisticsContent:'<span style="float: left;margin-top: 23px;">总计：<span style="color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;">'+money+'</span>元</span>'
});


//参团人名单
var nameColumns1 = [ {field : 'name',title : '姓名',width : '120',align : 'center'},
       		{field : false,title : '性别',width : '120',align : 'center' ,formatter:function(result) {
					if (result.sex == 0) {
						return '女';
					} else if (result.sex == 1) {
						return '男';
					} else {
						return '保密';
					}
           		}
			},
    		{field : 'certificate_name',title : '证件类型',width : '110',align : 'center'},
    		{field : 'certificate_no',title : '证件号码',align : 'center', width : '140'},
    		{field : 'birthday',title : '出生日期',align : 'center', width : '160'},
    		{field : 'telephone',title : '手机号',align : 'center', width : '160'}]

var nameColumns2 = [ {field : 'name',title : '姓名',width : '90',align : 'center'},
                     {field : 'enname',title : '英文名',width : '110',align : 'center'},
                	{field : false,title : '性别',width : '50',align : 'center' ,formatter:function(result) {
         					if (result.sex == 0) {
         						return '女';
         					} else if (result.sex == 1) {
         						return '男';
         					} else {
         						return '保密';
         					}
                    	}
         			},
             		{field : 'certificate_name',title : '证件类型',width : '90',align : 'center'},
             		{field : 'certificate_no',title : '证件号码',align : 'center', width : '150'},
             		{field : 'birthday',title : '出生日期',align : 'center', width : '90'},
             		{field : 'sign_place',title : '签发地',align : 'center', width : '120'},
             		{field : 'sign_time',title : '签发日期',align : 'center', width : '90'},
             		{field : 'endtime',title : '有效期至',align : 'center', width : '90'},
             		{field : 'telephone',title : '手机号',align : 'center', width : '100'}]

var linetype = <?php echo $linetype;?>;
if (linetype == 1) {
	$("#name-list").pageTable({
		columns:nameColumns2,
		url:'/admin/a/orders/order/getOrderNameJson',
		pageSize:20,
		searchForm:'#list-form',
		tableClass:'table table-bordered table_hover',
	});
} else {
	$("#name-list").pageTable({
		columns:nameColumns1,
		url:'/admin/a/orders/order/getOrderNameJson',
		pageSize:20,
		searchForm:'#list-form',
		tableClass:'table table-bordered table_hover',
	});
}


//操作日志
var logColumns = [ {field : false,title : '操作人类型',width : '120',align : 'center',formatter:function(result) {
					if (result.op_type == 1) {
						return '管家';
					} else if (result.op_type == 2) {
						return '供应商';
					} else if (result.op_type == 3) {
						return '平台';
					} else if (result.op_type == 4) {
						return '旅行社';
					} else if (result.op_type == 0) {
						return '用户';
					}
				}
			},
       		{field : false,title : '操作人',width : '120',align : 'center' ,formatter:function(result) {
	       			if (result.op_type == 1) {
						return result.expert_name;
					} else if (result.op_type == 2) {
						return result.supplier_name;
					} else if (result.op_type == 3) {
						return result.admin_name;
					} else if (result.op_type == 4) {
						return result.employee_name;
					} else if (result.op_type == 0) {
						return result.username;
					}
           		}
       		},
    		{field : 'addtime',title : '操作时间',width : '110',align : 'center'},
    		{field : 'content',title : '操作内容',align : 'center', width : '140'}]

$("#order-log").pageTable({
	columns:logColumns,
	url:'/admin/a/orders/order/getOrderLogJson',
	pageSize:20,
	searchForm:'#list-form',
	tableClass:'table table-bordered table_hover'
});


//收款记录
var columns = [ {field : 'money',title : '收款金额',width : '120',align : 'center'},
       		{field : 'addtime',title : '收款时间',width : '120',align : 'center'},
    		{field : 'way',title : '收款方式',width : '110',align : 'center'},
    		{field : false,title : '状态',align : 'center', width : '140',formatter:function(result) {
					if (result.status == 2) {
						return '已通过';
					} else if (result.status == 3) {
						return '已拒绝';
					} else if (result.status == 1) {
						return '审核中';
					}
        		}
    		},
    		{field : 'remark',title : '收款备注',width : '110',align : 'center'}
    		]

$("#order-receivable").pageTable({
	columns:columns,
	url:'/admin/a/orders/order/getOrderReceivable',
	pageSize:20,
	searchForm:'#list-form',
	emptyMsg:'暂无收款记录',
	tableClass:'table table-bordered table_hover'
});
</script>
</html>