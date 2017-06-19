<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
select{display:inline-block;margin-right:5px;}
</style>
</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
 <!-- 添加供应商 弹窗 -->
<div class="fb-content" id="form1">
	<table class="order_info_table table_td_border" border="1" style="width:95%;margin-left:20px;" cellspacing="0">
		<tr height="40">
                        <td class="order_info_title">团号:</td>
                        <td colspan="3"><?php echo $order['item_code']; ?></td>
                        <td class="order_info_title">出团日期:</td>
                        <td colspan="3"><?php echo $order['usedate']; ?></td>
                    </tr>
		<tr height="40">
                        <td class="order_info_title">订单号:</td>
                        <td colspan="3"><?php echo $order['ordersn']; ?></td>
                        <td class="order_info_title">已交款:</td>
                        <td colspan="3"><?php if(!empty($receive)){ echo $receive['total_receive_amount'];}?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td colspan="3"><?php echo $order['supplier_cost']; ?></td>
                        <td class="order_info_title">佣金:</td>
                        <td colspan="3"><?php echo $order['platform_fee']; ?></td>
                    </tr>
                      <tr height="40">
                        <td class="order_info_title">已结算:</td>
                        <td colspan="3"><?php echo $order['balance_money']; ?></td>
                        <td class="order_info_title">未结算:</td>
                        <td colspan="3"><?php echo ($order['supplier_cost']-$order['balance_money']-$order['a_balance']); ?></td>
                    </tr>
	</table>
	<p class="p_line" style="margin-left:20px;margin-top:10px">申请记录</p>
              <!-- 使用明细 -->
                    <div class="table_list">
        	  	<table class="table table-bordered table_hover" style="width:95%;margin-left:20px;margin-top:10px;">
	                    <thead>
	                        <tr>
	                            <th width="10%">审核状态</th>
	                            <th width="10%">申请金额</th>
	                            <th width="10%">订单号</th> 
	                            <th width="10%">结算总价</th>
	                            <th width="10%">结算申请中</th>
	                            <th width="10%">已结算</th>
	                            <th width="10%">未结算</th>
	                            <th width="10%">团号</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php  if(!empty($payable)){
	                    		foreach ($payable as $key => $value) {              		
	                    	?>
	                        <tr>
	                            <td>
	                            <?php  if($value['status']==0){ echo '申请中';
	                        		}else if($value['status']==1){
	                            		echo '申请中';
	                            		}elseif ($value['status']==2) {
	                            			echo '已通过';
	                            		}elseif ($value['status']==3) {
	                            			echo '已拒绝';
	                            		}elseif ($value['status']==4) {
	                            			echo '已付款';
	                            		}elseif ($value['status']==5) {
	                            			echo '已拒绝';
	                            		} ?>
	                            </td>
	                            <td><?php echo $value['amount_apply']; ?></td>
	                            <td><?php echo $value['ordersn']; ?></td>
	                            <td><?php echo $value['supplier_cost']; ?></td>
	                            <td><?php echo $value['a_balance']; ?></td>
	                            <td><?php echo $value['balance_money']; ?></td>	                           
	                            <td><?php echo $value['un_balance']; ?></td>
	                            <td><?php echo $value['item_code']; ?></td>
	                        </tr>
	                      <?php }  } ?>
	                      </tbody>
	           </table>
                    </div>  
                    <div class="table_list" style="margin-top:20px;">
                    <form class="form-horizontal bv-form" method="post" id="batchForm" >
                    	           <div  class="pay_div clear" >
                    	           
                    	         		<input type="hidden" name="orderid" value="<?php echo $order['id']; ?>" class="pay_input w_100" >
                    	                    <div class="fl" style="width:100%;padding:6px;">
		                            <lable class="pay_span" style="margin-left:33px;">申请金额：</lable>
		                            <div style="width: 300px;display: inline-block;"><input type="text" name="apply_money" value="" class="pay_input w_100" ></div>
	
		                </div>
		                  <div class="fl" style="width:100%;padding:6px;">
		                            <lable class="pay_span" style="margin-left:33px;">收款单位：</lable>
		                            <div style="width: 300px;display: inline-block;"><?php if(!empty($company_name)){ echo $company_name;} ?></div>
		                            <lable class="pay_span" >付款方式：</lable>
		                            <select name="pay_way" id="pay_way"  class="pay_input " style="margin-left:5px;width:60px;padding:0;">
		                              <option value="1">转账</option>
		                            </select>
		                </div>
	                          <div class="fl" style="width:100%;padding:6px;">
	                            	<lable class="pay_span">银行名称+支行：</lable>
	                            	<input type="text" name="p_bankname" class="pay_input w_300" value="<?php if(!empty($bank)){ echo $bank['bankname'].$bank['brand'];} ?>">
	                            	<lable class="pay_span">开户公司：</lable>
	                            	<input type="text" name="p_bankcompany" value="<?php if(!empty($bank)){ echo $bank['openman'];} ?>" class="pay_input w_300" >
	                            
	                          </div>
	                          <div class="fl" style="width:100%;padding:6px;">
	                          	<lable class="pay_span" style="margin-left:33px;">银行卡号：</lable>
	                           	 <input type="text" name=" p_bankcard" value="<?php if(!empty($bank)){ echo $bank['bank'];} ?>"class="pay_input w_300" size="25">
	                          </div>
	                          <div class="fl" style="width:100%;padding:6px;">
	                          	  <lable class="pay_span" style="margin-left:33px;"> 申请备注：</lable>
	                            	<input type="text" name="p_remark" class="pay_input" size="100" style="width:600px;">
	                            
	                          </div>
	                          <div style="margin:20px 300px;float:left;"><input type="button" value="提交申请" class="btn btn_green" id="batchData"  ></div>    
	                      </div>
	           </form>
                    </div>
</div>

<script type="text/javascript">
 //申请
jQuery('#batchData').click(function(){

  $.post("/admin/t33/sys/order/p_payable_apply",$('#batchForm').serialize(),function(data){
              data = eval('('+data+')');
               if(data.status==1){
                    alert(data.msg);
                     window.location.reload(); 
               }else{
                     alert(data.msg);
               }
  })
});


</script>


</html>


