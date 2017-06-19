 <link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
 <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
 <style type="text/css">
.page-body{ padding: 20px;}
.widget-body{box-shadow:none;-webkit-box-shadow:none;}
.table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px;}
.DTTTFooter{ background: none; box-shadow: none; border: none;}
.boostCenter{ padding: 20px 0; width: 100%;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.tab-content{ padding: 0 !important; background: none;}
.tableBox{ padding:0 10px 15px; background: #fff;}
.form-group label,.form-group input{ float: left;}

.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
input{ line-height:100%\9;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.formBox { padding:0 10px 10px;}
</style>
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
		<li class="active">额度使用明细</li>
	</ul>
</div>

<div class="page-body">
    <div class="shadow tab-content" style="background:#fff;">
        <form action="<?php echo base_url();?>admin/b2/credit_record/ajax_credit_record_list" id='record_list' name='record_list' method="post">
            <!-- 其他搜索条件,放在form 里面就可以了 -->
            <div class="form-inline formBox shadow">
                <div class="form-group">
                    <label class="search_title col_span" >使用日期:</label>
                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
                    <label style="border:none;width:auto;">-</label>
                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
                </div>
                 <div class="form-group">
                    <label class="search_title col_span" >订单编号:</label>
                    <input type="text" name="order_sn" class="form-control ie8_input" style="width:120px;" >
                </div>
                <div class="form-group">
                    <label class="search_title col_span" >子部门:</label>
                    <input type="text" name="child_depart" id="child_depart" class="form-control ie8_input" >
                </div>
                <button type="button" class="btn btn-darkorange" id="searchBtn" style="position: relative; top:10px;"> 搜索 </button>
            </div>
            <div class="tableBox">
	            <div id="record_list_dataTable"> <!--列表数据显示位置--> </div>
	            <div class="row DTTTFooter">
	           		<div></div>
	                <div>
	                    <div class="dataTables_paginate paging_bootstrap" style="float: none;">
	                        <!-- 分页的按钮存放 -->
	                       <div class="boostCenter">
	                            <ul class="pagination"> </ul>
	                        </div>
	                    </div>
	                </div>
	            </div>
            </div>
        </form>
    </div>
</div> <!--End -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
var depart_id = <?php echo $depart_id;?>;
$(document).ready(function(){
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

            //子部门
$.post('/admin/a/comboBox/get_child_depart', {'depart_id':depart_id}, function(data) {
    if(data){
        var data = eval('(' + data + ')');
        var array = new Array();
         $.each(data, function(key, val) {
                array.push({
                         text : val.name,
                         value : val.id,
            });
         });
        var comboBox = new jQuery.comboBox({
                id : "#child_depart",
                 name : "depart_id",// 隐藏的value ID字段
                query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
                selectedAfter : function(item, index) {},// 选择后的事件
                data : array
            });
    }


});
	// 列数据映射配置
	var record_list_columns=[
			      {field : 'addtime',title : '使用日期',width : '180',align : 'center'},
			      {field : 'order_sn',title : '订单号',width : '80',align : 'center',formatter:function(value,rowData,rowIndex){
                          var html = "";
                          html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
                          return html;
                       }
                  },
                  {field : 'realname',title : '额度使用人',width : '110',align : 'center',
                         formatter: function(value,rowData,rowIndex){
                                    if(value==null){
                                        return "无";
                                    }else{
                                        return value;
                                    }
                          }
                 },
			     {field : 'type',title : '说明',width : '260',align : 'left'},
			
           
			     {field : 'total_price',title : '订单金额',align : 'right', width : '90',
                          formatter: function(value,rowData,rowIndex){
                                    if(value==null){
                                        return "无";
                                    }else{
                                        return value;
                                    }
                          }
                  },
                  {field : 'sx_limit',title : '单团额度',align : 'right', width : '90',
                      formatter: function(value,rowData,rowIndex){
                      var value=value==0?'':value;
                      if(value>0)
                          value="+"+value;
                      var color_style="#008000";
                      if(value<0)
                     	 color_style="#FF0000";
                      return "<span style='color:"+color_style+"'>"+value+"</span>";
                   }
                 },
                 {field : 'receivable_money',title : '收款',align : 'right', width : '90',
                         formatter: function(value,rowData,rowIndex){
                         var value=value==0?'':value;
                         if(value>0)
                             value="+"+value;
                         var color_style="#008000";
                         if(value<0)
                        	 color_style="#FF0000";
                         return "<span style='color:"+color_style+"'>"+value+"</span>";
                      }
                 },
                 {field : 'cut_money',title : '扣款',align : 'right', width : '90',
                         formatter: function(value,rowData,rowIndex){
                         var value=value==0?'':value;
                         if(value>0)
                             value="+"+value;
                         var color_style="#008000";
                         if(value<0)
                        	 color_style="#FF0000";
                         return "<span style='color:"+color_style+"'>"+value+"</span>";
                      }
                 },
                 {field : 'refund_monry',title : '退款',align : 'right', width : '90',
                         formatter: function(value,rowData,rowIndex){
                         var value=value==0?'':value;
                         if(value>0)
                             value="+"+value;
                         var color_style="#008000";
                         if(value<0)
                        	 color_style="#FF0000";
                         return "<span style='color:"+color_style+"'>"+value+"</span>";
                      }
                 },
                
                 {field : 'cash_limit',title : '现金余额',align : 'right', width : '90'},
                 {field : 'credit_limit',title : '信用余额',align : 'right', width : '90'},
                 {field : 'credit_limit',title : '可用余额',align : 'right', width : '90',
                         formatter: function(value,rowData,rowIndex){
                         return Number(value)+Number(rowData['cash_limit']);
                       }
                 }

		       ];
	var isJsonp= false ;// 是否JSONP,跨域
	initTableForm("#record_list","#record_list_dataTable",record_list_columns,isJsonp ).load();
	$("#searchBtn").click(function(){
		initTableForm("#record_list","#record_list_dataTable",record_list_columns,isJsonp ).load();
	});

});
</script>
