<!-- Page Header -->
<style>
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
input{ line-height:100%\9;}
.overflow:hidden{overflow:hidden}
.modal-body{ overflow:hidden}
.col-sm-10,.col-sm-2{ padding:0}
.form-group2{ width:100%; margin:0 !important; padding:0}
.form-group2 label{ width:15%; float:left; height:40px; line-height:40px;}
.form-group2 .col-sm-10{ float:left; width:35% !important; height:40px; line-height:40px;}
.form-group input{border-color: #bbb #bbb #bbb #bbb !important;}
.form-group3{ width:100%; margin:0 !important; padding:0}
.form-group3 label{ width:20%; float:left; height:40px; line-height:40px; text-align:center;}
.form-group3 .col-sm-10{ float:left; width:80% !important; height:40px; line-height:40px;}
.form-group3 .col-sm-10 input{ height:auto !important; line-height:100% !important; line-height:24px !important}
.form-group3 .col-sm-10  textarea{ line-height:20px !important}
.formBox { padding:0 10px 5px;}
#editabledatatable tbody>tr>td{ padding: 6px;}
.tab_content { padding:5px 10px 15px;}


</style>
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">我的订单</li>
    </ul>
</div>
<!-- Page Body -->
<div class="page-body" id="bodyMsg" style="background:#fff;">
    <div class="formBox shadow">
    <form class="form-inline clear" method="post" action="<?php echo site_url('admin/b2/order/index')?>" >
        <div class="form-group " >
            <label class="fl" >产品名称:</label>
            <input type="text" class="form-control fl" name="linename" value="<?php echo $order_linename;?>" style="width:180px;"/>
        </div>
        <div class="form-group fl" >
            <label class="fl" >目的地:</label>
            <select name="destination" data_v='destnation_check'  class="fl ie8_select" style="width: 128px;">
            <option value="">请选择:</option>
            <?php foreach ($dest as $item):?>
                <?php if ($item['id'] == $destnation_check): ?>
                    <option value="<?php echo $item['id'];?>" selected='selected'><?php echo $item['kindname'];?></option>
                <?php else: ?>
                    <option value="<?php echo $item['id'];?>"><?php echo $item['kindname'];?></option>
                <?php endif?>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group " >
            <label class="fl" >订单编号:</label>
            <input type="text" class="form-control fl" name="ordersn" value="<?php echo $order_ordersn;?>" style="width:120px;"/>
        </div>
        <div class="form-group " >
            <label class="fl">订单状态:</label>
            <select id="order_status" name="status" v='<?php echo  $order_status?>'  class="fl ie8_select">
                <option value=""  >请选择</option>
                <option value="0"  >待留位</option>
                <option value="1" >已预留位</option>
                <option value="4"  >已确认</option>
                <option value="5"  >已出行</option>
                <option value="6"  >已点评</option>
                <option value="7"  >已投诉</option>
                <option value="-3"  >退订中</option>
                <option value="-4"  >订单已取消/已退订</option>
             </select>
        </div>
        <div class="form-group">
            <label class="fl" >出团时间:</label>
            <input type="text" class="form-control" id="departure_date" name="usedate"  value="<?php echo $usedate ? $usedate:''?>" style="width:180px;"/>
        </div>
        
        <div class="form-group " >
            <label class="fl">支付状态:</label>
            <select id="pay_status" name="pay_status" v='<?php echo  $pay_status?>'  class="fl ie8_select">
                <option value=""  >请选择</option>
                <option value="0"  >未付款</option>
                <option value="1" >确认中</option>
                <option value="2"  >已收款</option>
                <option value="3"  >退款中</option>
                <option value="4"  >已退款</option>
            </select>
        </div>
		<div class="form-group">
        	<button type="submit" class="btn btn-darkorange active ">搜索</button>
        </div>
   </form>
</div>
 <script type="text/javascript">
        var selects = $("#order_status");
        var selects_pay = $("#pay_status");
        for(var i=0 ;selects && i <selects.length ; i++ ){
        	selects[i].value=selects[i].getAttribute('v');
        }
         for(var i=0 ;selects_pay && i <selects_pay.length ; i++ ){
          selects_pay[i].value=selects_pay[i].getAttribute('v');
        }
        </script>
    <div class="tab_content shadow boostmarginBottom20">
    <table class="table table-striped table-hover table-bordered dataTable no-footer " id="editabledatatable" aria-describedby="editabledatatable_info">
        <thead>
            <tr role="row">
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px;text-align:center">
                    订单编号
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px;text-align:center">
                    预定人
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 150px;text-align:center">
                    产品标题
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 80px;text-align:center">
                    参团人数
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    订单总价
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    出团日期
                </th>
                  <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    支付状态
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    订单状态
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    下单时间
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    供应商名称
                </th>
                <th  tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;text-align:center">
                    操作
                </th>
            </tr>
        </thead>
    <tbody>
</div>
    <?php foreach ($order_list as $item): ?>
        <tr>
            <td class="sorting_1" style="text-align:center"><?php echo $item['ordersn'];?></td>
            <td class=" " style="text-align:center"><a target="_blank" href="<?php echo base_url('admin/b2/order/order_detail_info') ;?>?id=<?php echo $item['order_id'];?>"><?php echo $item['nickname'];?></a></td>
            <td class="center  " style="text-align:center" title="<?php echo $item['linename'];?>"><a target="_blank" href="<?php echo base_url('admin/b2/order/order_detail_info') ;?>?id=<?php echo $item['order_id'];?>"><?php echo mb_substr($item['linename'],0,11,'utf-8').'...';?></a></td>
            <?php if($item['unit']>=2):?>
            <td class=" " style="text-align:center"><?php echo $item['dingnum'];?></td>
            <?php else:?>
            <td class=" " style="text-align:center"><?php echo $item['people_num'] ;?></td>
            <?php endif;?>
            <td class=" " style="text-align:center"><?php echo $item['order_amount'];?></td>
            <td class=" " style="text-align:center"><?php echo date('Y-m-d',strtotime($item['usedate']));?></td>
            <td class=" " style="text-align:center"><?php echo $item['ispay'];?></td>
            <td class=" " style="text-align:center"><?php echo $item['status'];?></td>
            <td class=" " style="text-align:center"><?php echo $item['addtime'];?></td>
            <td class=" " style="text-align:center"><a onclick="show_contact(this)" data-val=<?php echo $item['s_mobile'].'|'.$item['supplier_name']?>><?php echo $item['supplier_name'];?></a></td>
            <td class=" " style="text-align:center">
                <?php if($item['ispay_code']=='2' && $item['status_opera']<5 ):?>
                     <a onclick='return_group_line(this)' data-val='<?php echo $item['order_id'];?>'>订单转团/</a>
                <?php endif;?>
                <?php if($item['status_opera']=='0' && $item['ispay_code']=='0'):?>
                    <?php if($item['op_status']!='0'):?>
                    <a onclick='change_order_price(this)' data-val=<?php echo $item['order_id'].'|'.$item['total_price'].'|'.$item['settlement_price'];?>>修改订单价格</a>
                    <?php else:?>
                     <span style="color:blue">价格修改申请中</span>
                <?php endif;?>
                <?php else:?>
                   价格无法修改
                <?php endif;?>
            </td>
        </tr>
	<?php endforeach;?>
    </tbody>
</table>
<div class="pageBox"><ul class="pagination"><?php echo $this->page->create_page()?></ul></div>
<!--弹窗申请退款-->
<div id="change_myModal" style="display: none;" class="bootbox modal fade in">
    <div class="modal-dialog" style="margin:30px auto;width:600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">修改订单价格</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body">
                    <div>
                        <form class="form-horizontal" id="change_form" role="form" method="post" action="#">
                            <div class="form-group form-group3">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">订单金额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="change_amount" id="change_amount" value="" />
                                    <input type="hidden" class="form-control" name="old_amount" id="old_amount" value="" />
                                    <input type="hidden" class="form-control" id="hidden_order_id" name="order_id" value="" />
                                </div>
                            </div>
                            <div class="form-group form-group3">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">保险金额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled="disabled" name="insurance_amount" id="insurance_amount" value="" />
                                    <input type="hidden" class="form-control"  name="insur_amount" id="insur_amount" value="" />
                                </div>
                            </div>
                            <div class="form-group form-group3">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">修改理由</label>
                                <div class="col-sm-10">
                                    <textarea name="reason" id="change_reason" style="resize:none;width:100%;height:100%"></textarea>
                                </div>
                            </div>
                            <div class="form-group form-group3" style=" margin:0; padding:0;">
                                <input type="submit" id="sub_btn" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style=" background:#09c !important;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End 弹窗申请退款-->

<!--弹窗申请退款-->
<div id="supplier_myModal" style="display: none;" class="bootbox modal fade in">
    <div class="modal-dialog" style="margin:30px auto;width:600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">供应商联系方式</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body">
                    <div id="supplier_conctact"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End 弹窗申请退款-->

<!--弹窗订单转团-->
<div id="change_group_line" style="display: none;" class="bootbox modal fade in">
    <div class="modal-dialog" style="margin:30px auto;width:700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">订单转团</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body">
                    <div>
                        <form class="form-horizontal" id="return_order_form" role="form" method="post" action="#" onsubmit="return CheckOrderDate();">
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">订单编号:</label>
                                <div class="col-sm-10" style="width:190px;">
                                    <span id="show_ordersn">160470045709</span>
                                </div>
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">预定人:</label>
                                <div class="col-sm-10" style="width:190px;">
                                    <span  id="show_member">139****4138</span>
                                </div>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">产品标题:</label>
                                <div class="col-sm-10" style="width:190px;">
                                    <span  id="show_linename">品牌名八一 · 按2人...</span>
                                </div>
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">参团人数:</label>
                                <div class="col-sm-10" style="width:190px;">
                                    <span  id="show_peplecount">品牌名八一 · 按2人...</span>
                                </div>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">订单金额:</label>
                                <div class="col-sm-10" style="width:190px; ">
                                    <span id="show_orderprice">品牌名八一 · 按2人...</span>
                                </div>
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">出团日期:</label>
                                <div class="col-sm-10" style="width:190px; ">
                                    <span id="show_userdate" >品牌名八一 · 按2人...</span>
                                </div>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right" style ="width:150px;">修改订单出团日期:</label>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">套餐名称:</label>
                                <div class="col-sm-10" style="width:190px;">
                                    <select name="line_suit" id="line_suit" onchange="getpriceStart(this);" class="ie8_select" >
                                        <option>标准价</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">出团日期:</label>
                                <div class="col-sm-10" style="width:190px;  ">
                                    <select name="suit_date" id="suit_date"  onchange="get_total_price(this);" class="ie8_select">
                                        <option>请选择</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">订单总价格:</label>
                                <div class="col-sm-10" style="width:190px;">
                                    <span id="change_price" > 0</span>
                                </div>
                            </div>
                            <div class="form-group form-group2" style="width:98%;">
                            <input type="hidden" name="order_id" id="order_id">
                            <input type="hidden" name="settlement_price" id="settlement_price">
                            <input type="submit" id="sub_btn" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%; background:#09c !important">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End 弹窗订单转团-->
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>
<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
$('#departure_date').daterangepicker();
$('#departure_date').focus(function(){
    $(this).val('');
});
function show_contact(obj){
    var data = $(obj).attr('data-val').split('|');
    var html = "<table class='table'><tr ><th style='text-align:center'>供应商</th><th style='text-align:center'>联系电话</th></tr><tr><td style='text-align:center'>"+data[1]+"</td><td style='text-align:center'>"+data[0]+"</td></tr></table>";
    $("#supplier_conctact").html(html);
    $("#back_ground_modal").show();
    $("#supplier_myModal").show();
}
function change_order_price(obj){
    var order_data = $(obj).attr('data-val').split('|');
    $("#hidden_order_id").val(order_data[0]);
    $("#change_amount").val(order_data[1]);
    $("#old_amount").val(order_data[1]);
    $("#insurance_amount").val(order_data[2]);
    $("#insur_amount").val(order_data[2]);
    $("#back_ground_modal").show();
    $("#change_myModal").show();
}

function hidden_modal(){
    $("#change_myModal").hide();
    $("#back_ground_modal").hide();
    $("#supplier_myModal").hide();
    $("#hidden_order_amount").val('');
    $("#hidden_order_id").val('');
    $("#change_reason").val('');
    $("#supplier_conctact").html('');
    $('#change_group_line').hide();//订单转团
}

$('#change_form').submit(function(){
//$("#sub_btn").attr("disabled", true);
    $.post("<?php echo base_url();?>admin/b2/order/change_order_price",
        $('#change_form').serialize(),
        function(data) {
            data = eval('('+data+')');
            if (data.status == 1) {
                alert(data.msg);
                location.reload();
            } else {
                alert(data.msg);
                // $("#sub_btn").attr("disabled", false);
            }
        }
    );
    return false;
});

//订单转团--选订单线路的套餐价格
function return_group_line(obj){
    $('#change_group_line').show();//订单转团
    $("#change_price").html('');
    $("#suit_date").html('<option value="">请选择</option>');
    var orderid=$(obj).attr('data-val');
    if(orderid>0){
    jQuery.ajax({ type : "POST",data :"id="+orderid,url : "<?php echo base_url()?>admin/b2/order/get_line_suitprice",
        success : function(data) {
            var data=eval("("+data+")");
            $("#order_id").val(data.order.order_id);
            $("#settlement_price").val(data.order.settlement_price);
            $("#show_ordersn").html(data.order.ordersn);
            $("#show_member").html(data.order.nickname);
            $("#show_linename").html(data.order.linename);
            $("#show_peplecount").html(data.order.people_num);
            $("#show_orderprice").html(data.order.order_amount +'('+data.order.total_price+"+"+data.order.settlement_price+'(保险))');
            $("#show_userdate").html(data.order.usedate);
            //套餐
            var suit_str='';
            if(data.suit!=" "){
                $.each(data.suit,function(n,value) {
                    if(value['id']==data.order.suitid){
                        suit_str=suit_str+'<option value='+value['id']+'  selected="true" >'+value['suitname']+'</option>';
                    }else{
                        suit_str=suit_str+"<option value="+value['id']+">"+value['suitname']+"</option>";
                    }
                });
            }
            $("#line_suit").html(suit_str);
            //套餐日期
            var suitdate_str='<option value="" selected="true">请选择</option>';
            if(data.date!=" "){
                $.each(data.date,function(n,value) {
                    suitdate_str=suitdate_str+"<option value="+value['dayid']+"> 空位:"+value['number']+"人&nbsp;&nbsp;出团日期:"+value['day']+"</option>";
                });
            }
            $("#suit_date").html(suitdate_str);
        }
    });
    }else{
        alert('当前没有套餐日期选择');
    }
}

//套餐的日期价格
function  getpriceStart(obj){
    var id=$(obj).val();
    var orderid=$("#order_id").val();
    jQuery.ajax({ type : "POST",data :"id="+id+"&orderid="+orderid,url : "<?php echo base_url()?>admin/b2/order/get_price_date",
        success : function(data) {
            var data=eval("("+data+")");
            //  alert($(obj).val());
            if(data.status==1){
                //套餐日期
                var suitdate_str='<option value="" >请选择</option >';
                if(data.date!=" "){
                    $.each(data.date,function(n,value) {
                        suitdate_str=suitdate_str+"<option value="+value['dayid']+"> 空位:"+value['number']+"人&nbsp;&nbsp;出团日期:"+value['day']+"</option>";
                    });
                }
                $("#suit_date").html(suitdate_str);
            }else{
                alert(data.msg);
            }
        }
    });
}
//获取订单的总的价格
function get_total_price(obj){
    var id=$(obj).val();
    var orderid=$("#order_id").val();
    var settlement_price=$('#settlement_price').val();
    if (id>0) {
        jQuery.ajax({ type : "POST",data :"id="+id+"&orderid="+orderid,url : "<?php echo base_url()?>admin/b2/order/get_total_price",
            success : function(data) {
                var data=eval("("+data+")");
                //
                if(data.status==1){
                    var price=(parseInt(data.total_price)+parseInt(settlement_price));
                    $("#change_price").html(price+'('+data.total_price+'+'+settlement_price+'(保险))');
                }else{
                    alert(data.msg);
                }
            }
        });
    }else{
        alert('获取订单的总价格失败');
    }
}

function CheckOrderDate(){
    jQuery.ajax({ type : "POST",data : jQuery('#return_order_form').serialize(),url : "<?php echo base_url()?>admin/b2/order/return_order_date",
        success : function(data) {
            var data=eval("("+data+")");
            if(data.status==1){
                alert(data.msg);
                location.reload();
            }else{
                alert(data.msg);
            }
        }
    });
    return false;
}
</script>
