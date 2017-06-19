<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>供应商管理系统</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
</head>
<body>
	
    <div class="page-body w_1200" id="bodyMsg">
    
        <div class="current_page">您的位置：
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">付款详细</a>
        </div>
        
        <div class="order_detail">
            <h2 class="lineName headline_txt">付款详细信息</h2>
        
           <div class="content_part">
                   <div class="small_title_txt clear">
                       <span class="txt_info fl">订单信息</span>
                   </div>
                    <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                       <tr height="40">
                           <td class="order_info_title">订单编号:</td>
                           <td><?php if(!empty($order[0]['ordersn'])){ echo $order[0]['ordersn'];} ?></td>
                           <td class="order_info_title">参团人数:</td>
                           <td><?php if(!empty($order[0]['dingnum'])){ echo $order[0]['dingnum'].'成人&nbsp;'.$order[0]['childnum'].'小孩(占床)&nbsp;'.$order[0]['childnobednum'].'小孩(不占床)&nbsp;'.$order[0]['oldnum'].'老人';} ?></td>
                       </tr>
                      <tr height="40">
                           <td class="order_info_title">线路名称:</td>
                           <td><?php if(!empty($order[0]['productname'])){ echo $order[0]['productname'];} ?></td>
                           <td class="order_info_title">订单成本价:</td>
                           <td><?php if(!empty($order[0]['supplier_cost'])){ echo $order[0]['supplier_cost'];} ?></td>
                       </tr>
                   </table>
           </div>
            <?php  if(!empty($order[0])){
                       if($order[0]['balance_status']!=1 && $order[0]['balance_status']!=2){    
             ?>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">申请付款</span>
                </div>
                <form id="apply_from" class="form-horizontal" action="#" method="post" role="form">
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title"><span style="color: red;">*</span>收款单位:</td>
                        <td><input  tyle="text"  style="padding: 9px;width: 270px;" name="item_company"  /></td>
                          <td class="order_info_title"><span style="color: red;">*</span>银行名称+支行:</td>
                        <td>
                        <input  tyle="text" name="bankname"  style="padding: 9px;width: 270px;" value="<?php if(!empty($bankArr['bankname'])){echo $bankArr['bankname'].$bankArr['brand'];} ?>" />   
                        </td>
                    </tr>
                    <tr height="40">          
                        <td class="order_info_title"><span style="color: red;">*</span>开户人:</td>
                        <td>
                        <input  tyle="text"  name="bankpeople" style="padding: 9px;width: 270px;" value="<?php if(!empty($bankArr['openman'])){echo $bankArr['openman'];} ?>" />
                        </td>
                         <td class="order_info_title"><span style="color: red;">*</span>开户帐号:</td>
                        <td><input  tyle="text"  name="bankcard" style="padding: 9px;width: 270px;" value="<?php if(!empty($bankArr['bank'])){echo $bankArr['bank'];} ?>" /></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><span style="color: red;">*</span>申请金额</td>
                        <td><input  tyle="text" name="pay_money" style="padding: 9px;width: 270px;" /></td>
                    <!-- <td class="order_info_title"></td>
                    <td></td> -->
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请备注:</td>
                        <td colspan="3"><textarea style="padding:20px;width: 248px;" name="remark"></textarea></td>
                    </tr>
                </table>
                <div>
                   <input type="hidden" name="orderid" value="<?php if(!empty($orderid)){ echo $orderid;} ?>">
                   <input id="btn_submit" class="btn btn_green" type="button" onclick="submit_apply()" value="申请付款" name="submit">
                </div>
                </form>
            </div> 
            <?php } } ?>
           <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">付款详细</span>
                </div>
                <div id="item-list">
                    
                    <table class="table table-bordered table_hover">
                            <thead class="">
                                 <tr>
                                     <th style="width:90px;text-align:center;">编号</th>
                                     <th style="width:120px;text-align:center;">订单号</th>
                                     <th style="width:140px;text-align:center;">银行卡号</th>
                                     <th style="width:140px;text-align:center;">银行名称+支行</th>
                                     <th style="width:90px;text-align:center;">开户人</th>
                                     <th style="width:90px;text-align:center;">申请金额</th>
                                     <th style="width:100px;text-align:center;">申请时间</th>
                                     <th style="width:90px;text-align:center;">状态</th>
                                </tr>
                            </thead>
                            <tbody class="">
                                <?php if(!empty($payable)){
                                            foreach ($payable as $key => $value) {
                                ?>
                                            <tr>
                                                     <td style="text-align:center"><?php echo $key+1; ?></td>
                                                    <td style="text-align:center"><?php echo $value['ordersn']; ?></td>
                                                    <td style="text-align:center"><?php echo $value['bankcard']; ?></td>
                                                    <td style="text-align:center"><?php echo $value['bankname']; ?></td>
                                                    <td style="text-align:center"><?php echo $value['bankcompany']; ?></td>
                                                    <td style="text-align:center"><?php echo $value['amount_apply']; ?></td>
                                                    <td style="text-align:center"><?php echo $value['addtime']; ?></td>
                                                    <td style="text-align:center">
                                                    <?php  if($value['status']==0){
                                                                        echo '申请中';
                                                                }elseif($value['status']==1){
                                                                        echo '旅行社通过';
                                                                }elseif($value['status']==2){
                                                                        echo '旅行社退回';
                                                                }elseif($value['status']==3){
                                                                        echo '已通过';
                                                                } elseif($value['status']==4){
                                                                        echo '平台退回';
                                                                }  
                                                        ?>
                                                    </td>
                                            </tr>
                                <?php  } }else{  }  ?>
                            </tbody>
                     </table>
                </div>
            </div>

        </div>
	</div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>

</script>
</body>
</html>
<script type="text/javascript">
function submit_apply(){

    $.post("/admin/b1/apply/apply_order/add_apply_money",$('#apply_from').serialize(),function(data){
               data = eval('('+data+')');
               if(data.status==1){
                     alert(data.msg);
                     location.reload();
                    //$('.opp_colse,.bc_close').click();
               }else{
                      alert(data.msg);   
                   //   location.reload(); 
               }    
        })
    return false;
}
</script>