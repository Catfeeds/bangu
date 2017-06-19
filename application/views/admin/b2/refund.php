<!-- Page Breadcrumb -->
<style type="text/css">
.bordered-right{ padding: 0 10px;}
.col_ts{ float: left;}
.col_top{ margin-top: 8px;}
.offer_reason,.other_reason { margin-left:90px;cursor:pointer;margin-bottom:0px;}
.offer_reason input,.other_reason input { float:left;position:relative;opacity:1;width:16px;z-index:999;left:0px;top:-3px;margin-right:10px;}
.other_reason_txt { display:none;margin-top:-10px;margin-left:100px;position:relative;}
#refund_reason { resize:none;width:100%;height:120px;padding-top:5px;}
.font_num_title { position:absolute;top:95px;right:25px;color:#666;}
.font_num_title i { color:#f00;}
.widget-body{ padding:5px 0px 15px; overflow: hidden;}
.div_account_list{ margin: 0; padding: 0}
.form-group input{ height:26px; line-height: 26px; padding: 0 10px;}
.form-group label{ height:26px; line-height: 26px; display: inline-block}
.input-group .form-control{ width: auto}
.input-group-addon{ float: left; padding: 8px 10px; width: 32px;}
.DTTTFooter { background-color: #fff;background-image: none;border: none;padding:15px;}
.input-sm{ padding: 0}
.form-group label{ height: 26px; line-height: 26px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666; float: left; margin-bottom: 0;}
.form-group input{ height:26px; line-height: 26px; padding: 0; padding-left: 10px; float: left;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.tab_content{ padding:5px 10px 15px;}
.shadow{ background: #fff;}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
input{ line-height:100%\9;}
.modal-body{ overflow:hidden}
.form-group1{ margin:0 !important; width:100%; margin: 5px 0 !important; overflow: hidden}
.form-group1 label{ width:20%; float:left; text-align:center}
.form-group1 .col-sm-10{ width:80%; float:left; padding:0}
.form-group1 .col-sm-10 input{ line-height:20px !important;}
.form-group2{ width:100%; margin:0 !important;}
.form-group2 label{ width:20%; float:left; border:none;}
.form-group2 label input{ width:auto !important; padding:0\9 !important; height:auto !important; position:relative; top:5px; line-height:12px;}
.tab_content { padding-top:0;}
.btn { padding:5px 12px;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
</style>
<!-- Page Header -->
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">退款申请</li>
    </ul>
</div>
<div class="widget-body bordered-right" style=" box-shadow: none;" >
<div class="col-xs-12 col-md-12 div_account_list">
    <form action="<?php echo base_url();?>admin/b2/refund/ajax_refund_list" id='refund_list' name='refund_list' method="post">
    <!-- 其他搜索条件,放在form 里面就可以了 -->
        <div class=" bordered-right shadow formBox">
           <div class="form-group" style="float: left;">
                <label>产品名称:</label>
                <input  style="display:inline;width:150px" type="text" class="form-control" name="productname" value="" />
            </div>
            <div class="form-group" style="float: left;">
                <label>订单编号:</label>
                <input  type="text" style="display:inline;width:120px" class="form-control" name="ordersn" value="" />
            </div>
            <div class="form-group" style="float: left;">
                 <label>出团日期:</label>
                 <input type="text" class="form-control" id="departure_date" name="departure_date"  style="display:inline;width:150px" value=""/>
            </div>
            <div class="form-group" style="float: left;">
                <label>供应商:</label>
                <select name="supplier_id" class="ie8_select">
                  <option value="">请选择</option>
                      <?php foreach ($suppliers as $item):?>
                      <option value="<?php echo $item['id'];?>"><?php echo $item['realname'];?></option>
                      <?php endforeach;?>
                </select>
            </div>
            <div class="form-group" style="float: left;">
                <button type="button" class="btn btn-darkorange active" id="searchBtn" style=" margin-left: 20px; padding: 3px 10px; " >搜索</button>
            </div>
        </div>
        <div class="tab_content shadow">
            <div class="sbibox">
                <div id="refund_list_dataTable"><!--列表数据显示位置--></div>

                <div class="row DTTTFooter">
                    <div class="col-sm-6" >
                        <div class="dataTables_info ie8_pageBox" id="editabledatatable_info">
                            第
                        <span class='pageNum'>0</span> /
                        <span class='totalPages'>0</span> 页 ,
                        <span class='totalRecords'>0</span>条记录,每页
                            <label>
                              <select name="pageSize" id='refund_Select'
                                class="form-control input-sm ie8_select" >
                                <option value="">
                                  --请选择--
                                </option>
                                <option value="5">
                                  5
                                </option>
                                <option value="10">
                                  10
                                </option>
                                <option value="15">
                                  15
                                </option>
                                <option value="20">
                                  20
                                </option>
                              </select>
                            </label>
                            条记录
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap" style="padding-top:4px;">
                          <!-- 分页的按钮存放 -->
                            <ul class="pagination"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!--弹窗申请退款-->
<div id="redund_myModal" style="display: none;" class="bootbox modal fade in">
    <div class="modal-dialog" style="margin:30px auto;width:600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">申请退款</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body">
                    <div>
                        <form class="form-horizontal" id="refund_form" role="form" method="post" action="#">
                            <div class="form-group form-group1">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">订单金额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control ie8_input" name="order_amount" id="order_amount" placeholder="订单金额" value="" readonly/>
                                </div>
                            </div>
                            <div class="form-group form-group1">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">退款金额</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="refund_amount" id="refund_amount" placeholder="退款金额" value=""/>
                                    <input type="hidden" class="form-control" id="hidden_order_sn" name="order_sn" value="" />
                                    <input type="hidden" class="form-control" id="hidden_order_id" name="order_id" value="" />
                                    <input type="hidden" class="form-control" id="hidden_order_linkmobile" name="order_linkmobile" value="" />
                                    <input type="hidden" class="form-control" id="hidden_order_amount" name="order_amount" value="" />
                                </div>
                            </div>
                            <div class="form-group form-group2">
                                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">退款原因</label>
                            </div>
                            <?php foreach($refund_reason AS $item):?>
                            <div class="form-group form-group2">
                                <label class="offer_reason clear">
                                    <input type="radio" name="cancle_reason" value="<?php echo $item['dict_id']?>"/><?php echo $item['description']?>
                                </label>
                            </div>
                            <?php endforeach;?>
                            <div class="form-group form-group2">
                                <label class="other_reason clear"><input type="radio" name="cancle_reason" value="-1"/>其他</label>
                            </div>
                            <div class="form-group form-group1">
                                <div class="col-sm-10 other_reason_txt" style=" margin-top:0;">
                                    <textarea name="reason_txt" id="refund_reason"></textarea>
                                </div>
                            </div>
                            <div class="form-group form-group1">
                                <input type="submit" id="sub_btn" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End 弹窗申请退款-->

<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>
<!--Bootstrap Date Range Picker-->
<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
  // 列数据映射配置
  var refund_list_columns=[ {field : 'ordersn',title : '订单编号',width : '150',align : 'center'},
      {field : 'predeter',title : '预定人',width : '120',align : 'center',
              formatter: function(value,rowData,rowIndex){
                  if(value==null || value==undefined){
                      return '';
                  }else{
                     return value;
                  }
                }
      },
      {field : 'producttitle',title : '产品标题',width : '230',align : 'center'},
      {field : 'people_num',title : '参团人数',align : 'center', width : '105'},
      {field : 'order_amount',title : '订单金额',align : 'center', width : '105'},
      {field : 'refund_amount',title : '申请退款金额',align : 'center', width : '120'},
      {field : 'supplier_name',title : '供应商',align : 'center', width : '100'},
      {field : 'depature_date',title : '出团日期',align : 'center', width : '120'},
      {field : 'refund_time',title : '退款时间',align : 'center', width : '200',
                formatter: function(value,rowData,rowIndex){
                  if(value==null || value==undefined){
                      return '';
                  }else{
                     return value;
                  }
                }
      },
      {field : 'client_mobile',title : '客户电话',align : 'center', width : '150'},
      {field : 'refund_reason',title : '退款原因',align : 'center', width : '200'},
     {field:'refund_status',title : '操作', align : 'center',width : '120',
        formatter: function(value,rowData,rowIndex){
          var html = "";
            switch(value){
              case '1':
              case '2':
                      html = "<a  id='bootbox-options' onclick='show_redund_dialog(this)' style='cursor: hand; cursor: pointer;' data-val='"+rowData['order_id']+"|"+rowData['order_amount']+"|"+rowData['ordersn']+"|"+rowData['linkmobile']+"'>退款</a>";
              break;
               case '3':
                    html = "退款申请中";
              break;
              case '4':
                     html = "已退款";
              break;
            default:
              html = "无";
            }
            return html;
        }
      }];
  var isJsonp= false ;// 是否JSONP,跨域
  initTableForm("#refund_list","#refund_list_dataTable",refund_list_columns,isJsonp ).load();
  $("#searchBtn").click(function(){
    initTableForm("#refund_list","#refund_list_dataTable",refund_list_columns,isJsonp ).load();
  });
  $('#refund_Select').change(function(){
    initTableForm("#refund_list","#refund_list_dataTable",refund_list_columns,isJsonp ).load();
  });
});

	//申请退款 备注滑动效果
	$(".other_reason").click(function(){
		$(".other_reason_txt").slideDown(300);
	});
	$(".offer_reason").click(function(){
		$(".other_reason_txt").slideUp(300);
	});
//字数计算
	//字数提示标签 <span class="font_num_title">已评论<i>0</i>字</span>
	$("#refund_reason").keyup(function(){
		var content = $(this).val();
		var fontNum = content.length;
		$(".font_num_title").find("i").html(fontNum);
	});



/*   $('#departure_date').focus(function(){
   $(this).val('');
   });*/
$('#departure_date').daterangepicker({
  format:'YYYY-MM-DD'
});

function show_redund_dialog(obj){
       var order_arr = $(obj).attr('data-val').split('|');
       $("#hidden_order_id").val(order_arr['0']);
       $("#hidden_order_sn").val(order_arr['2']);
       $("#hidden_order_amount").val(order_arr['1']);
       $("#hidden_order_linkmobile").val(order_arr['3']);
       $("#order_amount").val(order_arr['1']);
       $("#refund_amount").val(order_arr['1']);
       $("#back_ground_modal").show();
       $("#redund_myModal").show();
}

function hidden_modal(){
        $("#redund_myModal").hide();
        $("#back_ground_modal").hide();
         $("#hidden_order_sn").val('');
       $("#hidden_order_amount").val('');
       $("#refund_amount").val('');
       $("#order_amount").val('');
       $("#refund_reason").val('');
       $("#sub_btn").attr("disabled", false);
}

$('#refund_form').submit(function(){
    $("#sub_btn").attr("disabled", true);
      $.post(
        "<?php echo base_url();?>admin/b2/refund/apply_refund",
        $('#refund_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.status == 1) {
            alert(data.msg);
            location.reload();
          } else {
            alert(data.msg);
            $("#sub_btn").attr("disabled", false);
          }
        }
      );
      return false;
    });
</script>
