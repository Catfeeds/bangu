<style type="text/css">
.x-grid-cell .check_order_id{
  opacity: 5;
  position: relative;
  left: auto;
  line-height: 30px;
  z-index: 12;
  width: 13px;
  cursor: pointer;
}
.x-column-header .check_order_id{
  opacity: 5;
  position: relative;
  left: auto;
  line-height: 30px;
  z-index: 12;
  width: 13px;
  cursor: pointer;
}
.page-content { margin-left: 0; }
.page-body { position:relative;margin:0 auto;width:1200px;left:-80px;}

</style>
<div class=" div_account_list page-body">
<form action="<?php echo base_url();?>admin/b2/pay_manage/ajax_pay_order" id='pay_order' name='pay_order' method="post" onSubmit="return check()">
<div id="pay_order_dataTable"><!--列表数据显示位置--></div>
<div class="row DTTTFooter">
<div class="col-sm-6" >
<div class="dataTables_info" id="editabledatatable_info"></div>
</div>
  <div class="col-sm-6">
    <div class="dataTables_paginate paging_bootstrap">
      <!-- 分页的按钮存放 -->
      <ul class="pagination"> </ul>
    </div>
  </div>
</div>
<tr>
  <td>
      <input type="submit" value="提交"/>
  </td>
  <td>
      <input type="button" value="关闭" onclick="javascript:window.opener=null;window.open('','_self');window.close();"/>
  </td>
</tr>
</form>
</div>

<div class=" div_account_list page-body">
<form action="#" id='pay_order_ids' name='pay_order_ids' method="post">
      <input type="hidden" name="receive_ids" id="receive_ids" value=""/>
</form>
</div>
<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script>
$('#departure_date').daterangepicker();
/*function chooseAll(obj){
        if($(obj).checked){
            $("input[name='order[]']").each(function(){this.checked=true;});
        }else{
            $("input[name='order[]']").each(function(){this.checked=false;});
        }
    }*/

function check(){
    //获取选中的ID,设置到上级页面
    var orderIds ="" ;
    $("input[name='receive_id[]']").each(function(){
        if(this.checked){
            orderIds+=$(this).val()+",";
        }
    });
    if(orderIds!=""){
         $("#receive_ids").val(orderIds);
         $("#pay_order_ids").submit();
    }else{
          alert('你还未选择任何订单!');
    }
     return false ;
}


$(document).ready(function(){

           //新增加交款申请提交
            $("#pay_order_ids").submit(function(){
                  $.post(
                         "<?php echo base_url();?>admin/b2/pay_manage/submit_apply",
                        $('#pay_order_ids').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                     alert(data.msg);
                                     window.location.reload();
                                }else{
                                    alert(data.msg);
                                }
                        }
                    );
                    return false;
            });
            // End 新增加交款


  // 列数据映射配置
  var columns=[ {field : 'id',title : "",width : '4%',align : 'center',
              formatter: function(value,rowData,rowIndex){
                  return "<input type='checkbox' class='check_order_id' name='receive_id[]'' id='order_check'  value="+value+">";
              } },
      {field : 'order_id',title : '订单ID',width : '6%',align : 'center'},
       {field : 'addtime',title : '申请日期',align : 'center', width : '8%'},
      {field : 'money',title : '收款金额',width : '8%',align : 'center'},
      {field : 'voucher',title : '收款单号',width : '16%',align : 'center'},
      {field : 'way',title : '收款方式',align : 'center', width : '6%'},
      {field : 'bankcard',title : '银行卡号',align : 'center', width : '6%',
          formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
      },
       {field : 'bankname',title : '银行名称',align : 'center', width : '6%',
         formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
        },
        {field : 'invoice_type',title : '发票类型',align : 'center', width : '6%'},
        {field : 'invoice_code',title : '收据号码',align : 'center', width : '8%'},
        {field : 'remark',title : '备注',align : 'center', width : '6%'}
      ];


  var isJsonp= false ;// 是否JSONP,跨域
  initTableForm("#pay_order","#pay_order_dataTable",columns,isJsonp ).load();

  $('#unsettled_order_Select').change(function(){
    initTableForm("#pay_order","#pay_order_dataTable",columns,isJsonp ).load();
  });
 $("#searchBtn").click(function(){
    initTableForm("#pay_order","#pay_order_dataTable",columns,isJsonp ).load();
  });
});
</script>