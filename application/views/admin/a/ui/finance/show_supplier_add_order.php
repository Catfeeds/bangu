<style type="text/css">
.th_head th{
	text-align:center;
}
.th_body td{
	text-align:center;
	width:150px;
}
td,th{padding:8px 3px;}
.td_b{ text-align: right;}

</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<div>
<form name="">
<table >
<tr>
<td class="td_b"><b>创建时间:</b></td>
<td><?php echo $create_time;?>
<input  type="hidden" name="create_time" id="create_time" value="<?php echo $create_time;?>"/>
</td>
<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
<td class="td_b"><b>创建人:</b></td>
<td><?php echo $creator;?>
<input type="hidden" name="creator" id="creator" value="<?php echo $creator;?>"/>
</td>
</tr>

<tr>
<td class="td_b"><b>供应商:</b></td>
<td>
 <input type="text" style=" display:inline; width:200px;height:35px;line-height:35px;" placeholder="选择供应商" id="supplier_id"  name="supplier_id" value=""  />
 <font color='red'>*</font>
</td>
</tr>

  <tr>
 <td class="td_b"><b>开始时间:</b></td>
 <td>
   <div class="input-group" style="width:250px;">
	<input class="form-control date-picker"  id="start_time" type="text" data-date-format="yyyy-mm-dd">
	           <span class="input-group-addon">
	                      <i class="fa fa-calendar"></i>
	           </span>
   </div>
 </td>
 <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
<td class="td_b"><b>结束时间:</b></td>
<td>
   <div class="input-group">
	<input class="form-control date-picker"  id="end_time" type="text" data-date-format="yyyy-mm-dd">
	           <span class="input-group-addon">
	                      <i class="fa fa-calendar"></i>
	           </span>
   </div>
</td>
</tr>
<tr>
<td class="td_b"><b>开户银行:</b></td>
 <td>
   <div class="input-group">
    <input class="form-control "  id="bank_name" type="text" name="bank_name" value="">
   </div>
 </td>
 <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
<td class="td_b"><b>银行支行:</b></td>
<td>
   <div class="input-group">
    <input class="form-control "  id="brand" name="brand" type="text" value="">
   </div>
</td>
</tr>

<tr>
    <td class="td_b"><b>银行卡号:</b></td>
 <td>
   <div class="input-group">
    <input class="form-control "  id="bank_num" type="text" name="bank_num" value="">
   </div>
 </td>
 <td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
<td class="td_b"><b>开户人姓名:</b></td>
<td>
   <div class="input-group">
    <input class="form-control "  id="openman" name="openman" type="text" value="">
   </div>
</td>
</tr>
<tr>
<td class="td_b"><b>备注:</b></td>
<td><textarea name="baizhu" id="beizhu"></textarea></td>
</tr>
</table>
</form>
</div>
<hr/>


<input  type="hidden"  name='orderIds' id='orderIds'  value=""/><!--用来保存选中的ID-->
<input  type="hidden"  name='order_status' id='order_status'  value=""/><!--用来保存选中的订单状态-->

已选择订单 <a data-val='' id="add_order_a" onclick="openAddOrder(this)" target="_blank" style="text-decoration:underline;cursor:hand">新增结算单</a>
<div id="choose_order"></div>
 <script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
 <script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript">
        function openAddOrder(){
            var supplier_id=$("#supplier_select_id").val() ;
            var start_time = $("#start_time").val();
            var end_time = $("#end_time").val();
            var beizhu  = $("#beizhu").val();
            if(supplier_id=='undefine' || supplier_id==''){
                alert('供应商不能为空');
                $("#supplier_id").val('');
                 return false;
            }
            if(start_time=='' || start_time=='undefine'){
            	alert('请选择结算的开始时间');
                return false;
              }
            window.open('<?php echo base_url();?>admin/a/finance/show_supplier_unsettled_order?supplierId='+supplier_id+'&start_time='+start_time+'&end_time='+end_time+'&beizhu='+beizhu,
            	'newwindow','height=560,width=1600,top=50,left=50,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
        }

        // 根据 orderIds 异步获取数据,刷新下面的数据表格
        function addOrderData(){
        	var ids = $("#orderIds").val();
        	var supplier_id = $("#supplier_select_id").val();
        	var start_time = $("#start_time").val();
        	var end_time = $("#end_time").val();
            var order_status = $("#order_status").val();
        	var beizhu = $("#beizhu").val();

                 var bank_name=$("#bank_name").val() ;
            var brand = $("#brand").val();
            var bank_num = $("#bank_num").val();
            var openman  = $("#openman").val();


                if(bank_name=='' || bank_name=='undefine'){
                alert('请填写银行名称');
                         return false;
              }
            if(brand=='' || brand=='undefine'){
                alert('银行支行必填');
                return false;
              }
              if(bank_num=='' || bank_num=='undefine'){
                        alert('银行卡号必填');
                         return false;
              }
            if(openman=='' || openman=='undefine'){
                alert('开户人必填');
                 return false;
              }


        	$.post("<?php echo base_url();?>admin/a/finance/add_supplier_order",
        			{
        				'order_ids':ids,
        				'supplier_id':supplier_id,
        				'start_time':start_time,
        				'end_time':end_time,
        				'beizhu':beizhu,
                                                'order_status':order_status,
                                                'bank_name':bank_name,
                                               'brand':brand,
                                                'bank_num':bank_num,
                                                 'openman':openman
        			},
        			function(data){
                                        data = eval('('+data+')');
                                        if(data.code==200){
                                               alert(data.msg);
                                               window.opener.location.reload();
                                               window.close();
                                        }else{
                                            alert(data.msg);
                                        }
                                    });

        }

        function refreshOrder(){
        	var ids = $("#orderIds").val();
            var order_status = $("#order_status").val();
        	var supplier_id = $("#supplier_select_id").val();
        	$.post("<?php echo base_url();?>admin/a/finance/show_supplier_ajax_order",
        			{
        				'order_ids':ids,
        				'supplier_id':supplier_id,
                                                'order_status':order_status
        			},
        			function(data){
        				$("#choose_order").html('');
        				var order_list = $.parseJSON(data);
        				var str_html="";
                                                var s_amount = 0;
        				str_html += "<table class='table table-striped table-hover table-bordered dataTable no-footer'> <tr class='th_head'>";
        				str_html += "<th>订单编号</th>";
        				str_html += "<th>产品标题</th>";
        				str_html += "<th>参团人数</th>";
        				str_html += "<th>出团日期</th>";
        				str_html += "<th>订单金额</th>";
        				str_html += "<th>结算金额</th>";
        				str_html += "</tr>";
        				$.each(order_list,function(key,val){
        					str_html += "<tr class='th_body'>";
        					str_html += "<td>"+val['ordersn']+"</td>";
        					str_html += "<td>"+val['productname']+"</td>";
        					str_html += "<td>"+val['people_num']+"</td>";
        					str_html += "<td>"+val['usedate']+"</td>";
        					str_html += "<td>"+val['total_price']+"</td>";
                                                             if(val['mo_status']==-4 &&val['mo_ispay']==4){
                                                                s_amount = (val['total_price']-val['real_refund_amount']).toFixed(2);
                                                             }else{
                                                                s_amount = (val['total_price']-val['total_price']*val['agent_rate']-val['agent_fee']).toFixed(2);
                                                            }
        					str_html += "<td>"+s_amount+"</td>";

        					str_html +="</tr>";
        				});
        				str_html += "</table>"
        				str_html +="<button onclick='addOrderData()'>保存</button>";
        				str_html +="<button onclick='javascript:window.close();'>关闭</button>";
        				$("#choose_order").append(str_html);

  			});
        }

        $.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
    var data = eval('(' + data + ')');
    var array = new Array();
    $.each(data, function(key, val) {
        if(val.brand==null){
            val.brand='';
        }
        array.push({
            text : val.company_name+'-'+val.brand,
            value : val.id,
            jb : val.company_name,
            qp : val.brand
        });
    });
    var comboBox = new jQuery.comboBox({
        id : "#supplier_id",
        name : "supplier_select_id",// 隐藏的value ID字段
        query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
        selectedAfter : function(item, index) {// 选择后的事件
            $(this).val(item.text);
                 $.post('/admin/a/finance/show_supplier_bank_info',{'supplier_id':item.value},function(res){
                res = eval('('+res+')');
                $("#bank_name").val(res['bankname']);
                $("#brand").val(res['brand']);
                $("#bank_num").val(res['bank']);
                $("#openman").val(res['openman']);
            });
        },
        data : array
    });
});

        $('#start_time').datepicker();
        $('#end_time').datepicker();
</script>