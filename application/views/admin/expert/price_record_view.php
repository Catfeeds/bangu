<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格申请</title>
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css')?>" rel="stylesheet" type="text/css" />
<style type="text/css">

h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, img, ol, p{ font-family: "微软雅黑" !important; color: #444}
.last_time { border:5px solid #000;border-radius:2px;font-size:14px;}
.check_project { position:relative;}
.hide_project_title { display:none;position:absolute;top:15px;left:-235px;width:280px;border:1px solid #94A100;background:#f8f8f8;padding:5px 10px;line-height:25px;border-radius:3px;z-index:999;}
.hide_project_title p { text-align:left;}
.hide_project_title p a { padding-right:15px;}
.hide_project_title p a:hover { text-decoration:underline;}
.hide_project_title p span { padding-right:15px;}
.action_type { position:relative;}
.check_project .action_type i { width: 7px; height: 4px; background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) 0px 0px no-repeat; position: absolute; margin-left: 2px; top: 7px;}
#list1 .x-grid-cell-inner .action_type{ width:50%;margin:0;}
#list1 .x-grid-cell-inner a:nth-child(1) { text-align:center;}
.x-grid-cell-inner .check_project { margin:0 10px 0 25px;}
.x-grid-cell-inner .action_type { margin:0 10px;}
.DTTTFooter{ padding-top: 15px;}
.table_content{ padding: 0}
.page-breadcrumbs {position: relative;min-height: 40px;line-height: 39px; padding: 0; display: block;z-index: 1;left: 0;}
.fa-home:before {content: "\f015";}
.breadcrumb {padding-left: 10px; background: #fff none repeat scroll 0% 0%;height: 40px;line-height: 40px;box-shadow: none;}
.breadcrumb li {float: left;padding-right: 10px;color: #777;-webkit-text-shadow: none;text-shadow: none;}
.breadcrumb>li+li:before {padding: 0 5px;color: #ccc; content: "/\00a0";}
.page-content {display: block;margin-left: 160px;margin-right: 0; margin-top: 0;min-height: 100%;padding: 0;}

.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.tab_content { padding:5px 0 10px;}
</style>
</head>
<body>
<div class="page-content bg_gray">
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home')?>"> 主页 </a></li>
            <li class="active">价格申请</li>
        </ul>
    </div>
    <div class="page-body" id="bodyMsg">
        <div class="table_content">
            <ul class="tab_nav nav nav-tabs tab_shadow clear" id="myTab">
                <li name="tabs" class="active tab-blue" id="tab_list1" status="1"><a href="###">申请中</a></li>
                <li name="tabs"  class="tab-blue" id="tab_list2" status="2"><a href="###">已通过</a></li>
                <li name="tabs" class="tab-blue" id="tab_list3" status="3"><a href="###">已拒绝</a></li>
            </ul>
            <div class="tab_content">
                <!-- 抢单标签数据 -->
                <div class="table_list" id="list1">
                    <form action="<?php echo base_url();?>admin/b2/change_price_record/apply_ing" id='apply_record1' name='apply_record1' method="post">
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <input type="hidden" name="apply_status" value="0"/>
                        <div id="apply_record_dataTable1"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap" style=" text-align:center">
                                    <!-- 分页的按钮存放 -->
                                    <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--  End 抢单标签数据  -->
                <!-- 已投标数据 -->
                <div class="table_list" id="list2">
                    <form action="<?php echo base_url();?>admin/b2/change_price_record/apply_pass" id='apply_record2' name='apply_record2' method="post">
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <input type="hidden" name="apply_status" value="1"/>
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <div id="apply_record_dataTable2"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap"  style=" text-align:center">
                                    <!-- 分页的按钮存放 -->
                                    <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End 已投标数据 -->

                <!-- 已中标数据 -->
                <div class="table_list" id="list3">
                    <form action="<?php echo base_url();?>admin/b2/change_price_record/apply_refused" id='apply_record3' name='apply_record3' method="post">
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <input type="hidden" name="apply_status" value="2"/>
                        <div id="apply_record_dataTable3"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap"  style=" text-align:center">
                                    <!-- 分页的按钮存放 -->
                                    <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End 已中标数据 -->

                <!-- 已取消数据 -->
                <div class="table_list" id="list4">
                    <form action="<?php echo base_url();?>admin/b2/grab_custom_order/ajax_expired_order" id='grab_custom4' name='grab_custom4' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <div id="grab_custom_dataTable4"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap"  style=" text-align:center">
                                <!-- 分页的按钮存放 -->
                                <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End已取消数据 -->
            </div>
        </div>
    </div>
</div>


 <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>

<script type="text/javascript">
var columnArr=[];
//抢单数据列表
var apply_record_columns_1=[
    {field : 'ordersn',title : '订单编号',width : '30',align : 'center'},
    {field : 'nickname',title : '预定人',width : '30',align : 'center'},
    {field : 'productname',title : '产品标题',width : '60',align : 'center'},
    {field : 'usedate',title : '出团日期',align : 'center', width : '45'},
    {field : 'before_price',title : '修改前价格',align : 'center', width : '30'},
    {field : 'after_price',title : '修改后价格',align : 'center', width : '30'},
    {field : 'expert_reason',title : '管家申请理由',align : 'center', width : '30'},
    {field : 'addtime',title : '管家申请时间',align : 'center', width : '40'}
  ];

//已通过
var apply_record_columns_2=[
    {field : 'ordersn',title : '订单编号',width : '30',align : 'center'},
    {field : 'nickname',title : '预定人',width : '30',align : 'center'},
    {field : 'productname',title : '产品标题',width : '60',align : 'center'},
    {field : 'usedate',title : '出团日期',align : 'center', width : '45'},
    {field : 'before_price',title : '修改前价格',align : 'center', width : '30'},
    {field : 'after_price',title : '修改后价格',align : 'center', width : '30'},
    {field : 'expert_reason',title : '管家申请理由',align : 'center', width : '30'},
    {field : 'supplier_reason',title : '通过理由',align : 'center', width : '30'},
    {field : 'modtime',title : '确认时间',align : 'center', width : '30'},
    {field : 'addtime',title : '管家申请时间',align : 'center', width : '40'}
  ];

//已拒绝
var apply_record_columns_3=[
    {field : 'ordersn',title : '订单编号',width : '30',align : 'center'},
    {field : 'nickname',title : '预定人',width : '30',align : 'center'},
    {field : 'productname',title : '产品标题',width : '60',align : 'center'},
    {field : 'usedate',title : '出团日期',align : 'center', width : '60'},
    {field : 'before_price',title : '修改前价格',align : 'center', width : '30'},
    {field : 'after_price',title : '修改后价格',align : 'center', width : '30'},
    {field : 'expert_reason',title : '管家申请理由',align : 'center', width : '60'},
    {field : 'supplier_reason',title : '拒绝理由',align : 'center', width : '80'},
    {field : 'modtime',title : '确认时间',align : 'center', width : '30'},
    {field : 'addtime',title : '管家申请时间',align : 'center', width : '40'}
  ];

columnArr[1] = apply_record_columns_1;
columnArr[2] = apply_record_columns_2;
columnArr[3] = apply_record_columns_3;
var isJsonp= false ;// 是否JSONP,跨域
$(document).ready(function(){
    initTableForm("#apply_record1","#apply_record_dataTable1",columnArr[1],isJsonp ).load();
      $("#myTab li").on("click",function(){
          $("#myTab li").removeClass("active");
          $(this).addClass("active");
          var index=$("#myTab li").index($(this))+1;
          initTableForm("#apply_record"+index,"#apply_record_dataTable"+index,columnArr[index],isJsonp ).load();
      });
});
</script>
</body>
</html>
