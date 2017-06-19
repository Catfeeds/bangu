<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
</head>
<body>
	
    <!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
              
        <!-- ===============订单详情============ -->
        <div class="order_detail_d" style="margin: auto 3px;">
          
            <!-- ===============基础信息============ -->
            <div class="content_part">
                 <div class="small_title_txt clear">
                    <span class="txt_info fl">线路名称:<?php  echo $order['productname'];?></span>
                  <!--   <span class="order_time fr">2015-10-20 14:43:20</span> -->
                 </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">       
                    <tr height="40">
                        <td class="order_info_title">出团日期:</td>
                        <td><?php  echo $order['usedate'];?></td>
                        <td class="order_info_title">订单序号:</td>
                        <td><?php  echo $order['ordersn'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单人数:</td>
                        <td><?php  echo ($order['dingnum']+$order['childnobednum']+$order['childnum']+$order['oldnum']);?>人</td>
                        <td class="order_info_title">退订人数:</td>
                        <td style="color:red;"><?php  echo $refund['member'];?>人</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td><?php  echo $order['supplier_cost'];?></td>
                        <td class="order_info_title">已结算:</td>
                        <td><?php  echo $refund['balance_money'];?></td>
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">未结算:</td>
                        <td><?php  echo $refund['p_amount'];?></td>
                        <td class="order_info_title">授信额度:</td>
                        <td><?php  echo $refund['credit_limit'];?></td>
                        
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">平台佣金:</td>
                        <td><?php  echo $order['platform_fee'];?></td>
                        <td class="order_info_title">退供应商:</td>
                        <td style="color:red;"><?php  echo $refund['amount'];?></td>
                    </tr>

                </table>
                <div style="margin-top:30px;"> 
                    <input type="button" name="" value="确认" class="btn btn_blue" id="confirm_order_btn" style="margin-left:210px;"  onclick="confirm_order()" >
                    <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
                </div>
            </div>
            
            <!-- ===============参团人============ -->
           
        </div>
	</div>

</body>

</html>

<script type="text/javascript">

function confirm_order(){  
	
   var bill_id=<?php  if(!empty($bill_id)){ echo $bill_id;}else{ echo 0;}  ?>;
   var orderid=<?php  if(!empty($orderid)){ echo $orderid;}else{ echo 0;}  ?>;


   jQuery.ajax({ type : "POST",async:false,data : { 'bill_id':bill_id,'orderid':orderid},url : "<?php echo base_url()?>admin/b1/order/save_confirm_order", 
       beforeSend:function() {//ajax请求开始时的操作
            layer.load(1);//加载层
       },
       complete:function(){//ajax请求结束时操作              
            layer.closeAll('loading'); //关闭层
       },
       success : function(result) { 
     	  data = eval('('+result+')');
	       	   if(data.status==1){
	               
	 	       	   layer.msg(data.msg, {icon: 1});  
		 	       parent.location.reload();
	         }else{
	               alert(data.msg);
	         } 
       }
   });

   
  /* $.post("<?php //echo site_url('admin/b1/order/save_confirm_order')?>",
    {'bill_id':bill_id,'orderid':orderid},
    function(result,status) {
           var result =eval("("+result+")"); 
           if(status=="success"){
              if(result.status==1){
                    alert(result.msg);
                    parent.location.reload();
              }else{
                    alert(result.msg);
              }
           }
    });*/
}
//关闭按钮
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$('#refuse').click(function()
{
     parent.layer.close(index);
});

</script>