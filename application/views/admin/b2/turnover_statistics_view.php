<!-- Page Breadcrumb -->
<style type="text/css">
    .col_ts{ float: left;}
    .col_top{ margin-top: 8px;}
    table.table{ margin-top: 10px;}
  .offer_reason,.other_reason { margin-left:90px;cursor:pointer;margin-bottom:0px;}
  .offer_reason input,.other_reason input { float:left;position:relative;opacity:1;width:16px;z-index:999;left:0px;top:-3px;margin-right:10px;}
  .other_reason_txt { display:none;margin-top:-10px;margin-left:100px;position:relative;}
  #refund_reason { resize:none;width:100%;height:120px;padding-top:5px;}
  .font_num_title { position:absolute;top:95px;right:25px;color:#666;}
  .font_num_title i { color:#f00;}
    .page-body{ padding: 20px;}
    .table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px;}
    .DTTTFooter{ background: none; border: none;}
    .boostCenter{ padding: 20px 0}
</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">营业额统计</li>
    </ul>
</div>
<div class="page-body">
    <div class="bodyBox shadow">
        <form action="<?php echo base_url();?>admin/b2/turnover_statistics/ajax_get_turnover" id='turnover_list' name='turnover_list' method="post">


            <!-- 其他搜索条件,放在form 里面就可以了 -->
           <!--  <div class="form-group" style="display:inline-block">
                <span class="search_title col_span" >产品名称:</span>
                <input type="text"  placeholder="产品名称" name="linename" >
            </div>

             <div class="form-group" style="display:inline-block">
                <span class="search_title col_span" >产品编号:</span>
                <input type="text"  placeholder="产品编号" name="line_code" >
            </div>

            <div class="form-group" style="display:inline-block">
                <span class="search_title col_span" >目的地:</span>
                <input class="search-input" type="text" placeholder="目的地" id="destinations" name="kindname" />
            </div>

             <div class="form-group" style="display:inline-block">
                <span class="search_title col_span" >供应商:</span>
                <input class="search-input" type="text" placeholder="供应商" id="company_name" name="supplier" />
            </div>

               <div class="form-group" style="display:inline-block">
                <span class="search_title col_span" >上线时间:</span>
                <input class="search-input" style="width:110px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />-
              <input class="search-input" style="width:110px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
            </div>
            <button type="button" class="btn btn-darkorange" id="searchBtn"> 搜索 </button> -->

        <div id="turnover_list_dataTable"><!--列表数据显示位置--></div>
        <div class="row DTTTFooter">
            <div class="col-sm-6" ></div>
            <div class="col-sm-6">
                <div class="dataTables_paginate paging_bootstrap">
                  <!-- 分页的按钮存放 -->
                    <div class="boostCenter">
                        <ul class="pagination"> </ul>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>



<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
  // 列数据映射配置
  var turnover_list_columns=[
      {field : 'usedate',title : '出团日期',width : '90',align : 'center'},
      {field : 'ordersn',title : '订单编号',width : '200',align : 'center'},
      {field : 'productname',title : '线路名称',width : '200',align : 'center'},
                  {field : 'total_price',title : '应收款',width : '200',align : 'center'},
                  {field : 'ys',title : '已收',width : '200',align : 'center'},
                  {field : 'yt',title : '已退',width : '200',align : 'center'},
                  {field : 'wsk',title : '未收',width : '200',align : 'center'}
             ];
  var isJsonp= false ;// 是否JSONP,跨域
  initTableForm("#turnover_list","#turnover_list_dataTable",turnover_list_columns,isJsonp ).load();
  $("#searchBtn").click(function(){
    initTableForm("#turnover_list","#turnover_list_dataTable",turnover_list_columns,isJsonp ).load();
  });
});


//目的地
$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.kindname,
        value : val.id,
        jb : val.simplename,
        qp : val.enname
    });
  })
  var comboBox = new jQuery.comboBox({
      id : "#destinations",
      name : "destid",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {// 选择后的事件

      },
      data : array
  });
});


//商家名字
$.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.company_name,
        value : val.id,
    });
  })
  var comboBox = new jQuery.comboBox({
      id : "#company_name",
      name : "supplier_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {// 选择后的事件

      },
      data : array
  });
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




