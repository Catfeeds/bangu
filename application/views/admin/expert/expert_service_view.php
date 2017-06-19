<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管家上门服务</title>

<link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet" type="text/css">
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
<style type="text/css">
.h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, img, ol, p{ font-family: "微软雅黑"}
.nav-tabs,.bg_gray{ background: none;}
body { overflow-y : auto ;overflow-x : hidden ;font-family: "微软雅黑" !important;}
.last_time { border:5px solid #000;border-radius:2px;font-size:14px;}
.check_project { position:relative;}
.hide_project_title { display:none;position:absolute;top:15px;left:-140px;width:280px;border:1px solid #94A100;background:#f8f8f8;padding:5px 10px;line-height:25px;border-radius:3px;z-index:999;}
.hide_project_title p { text-align:left;}
.hide_project_title p a { padding-right:15px;}
.hide_project_title p a:hover { text-decoration:underline;}
.hide_project_title p span { padding-right:15px;}
.action_type { position:relative;}
.check_project .action_type i { width: 7px; height: 4px; background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) 0px 0px no-repeat; position: absolute; margin-left: 2px; top: 7px;}
.page-body{ padding: 20px; margin: 0}
.table_content{ margin: 0; padding: 0}
#list1 .x-grid-cell-inner .action_type{ width:50%;margin:0;}
#list1 .x-grid-cell-inner a:nth-child(1) { text-align:center;}
.x-grid-cell-inner .check_project { margin:0 10px 0 25px;}
.x-grid-cell-inner .action_type { margin:0 10px;}
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{ background: #fff}
.page-breadcrumbs {position: relative;min-height: 40px;line-height: 39px;padding: 0;display: block;z-index: 1;left: 0;}
.breadcrumb {padding-left: 10px;background: #fff none repeat scroll 0% 0%;height: 40px;line-height: 40px;box-shadow: 0 0 10px 0 rgba(0, 0, 0, .5);-webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .5);-moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .5);box-shadow: 0 0 10px 0 rgba(0, 0, 0, .5);}
.breadcrumb li {float: left;padding-right: 10px;color: #777;-webkit-text-shadow: none;text-shadow: none;}
.breadcrumb>li+li:before {padding: 0 5px;color: #ccc;content: "/\00a0";}
.page-content {display: block;margin-left: 160px;margin-right: 0;margin-top: 0;min-height: 100%;padding: 0;}
.fa-home {width: 16px;height: 16px;position: absolute;left: 0;top: -3px;background: url(../../../../assets/img/home.png) 0 0 no-repeat;display: inline-block;}
.fa-home::before { content: "";}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
#list1 .x-grid-cell-inner .action_type,.action_type{ width: auto; padding: 0 8px; background: #056DAB; color: #fff; border-radius: 2px;}
.action_type:hover{ color: #fff !important;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.tab_content { padding:10px 0;}
</style>
</head>
<body>
<!--=================右侧内容区================= -->



<div class="page-content">
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
        <li class="active">管家上门服务</li>
    </ul>
</div>
<div class="page-body" id="bodyMsg">
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">

            <div class="table_content">
                <ul class="tab_nav nav nav-tabs tab_shadow clear" id="myTab">
                    <li name="tabs" class="active tab-blue" id="tab_list1" progress="1"><a href="###">邀请中</a></li>
                    <li name="tabs"  class="tab-blue" id="tab_list2" progress="2"><a href="###">服务中</a></li>
                    <li name="tabs"  class="tab-blue" id="tab_list3" progress="3"><a href="###">已服务</a></li>
                    <li name="tabs" class="tab-blue" id="tab_list4" progress="4"><a href="###">已完成</a></li>
                    <li name="tabs" class="tab-blue" id="tab_list5" progress="-1"><a href="###">已拒绝</a></li>
                </ul>
                <div class="tab_content">
                <!-- 邀请中标签数据 -->
                    <div class="table_list" id="list1">
                    <form action="<?php echo base_url();?>admin/b2/expert_service/service_list" id='expert_service1' name='expert_service1' method="post">
                    <input type="hidden" name="progress" value="1"/>
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="expert_service_dataTable1"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="pageBox">
                          	<ul class="pagination"> </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!--  End 抢单标签数据  -->

                        <!-- 服务中数据 -->
                    <div class="table_list" id="list2">
                           <form action="<?php echo base_url();?>admin/b2/expert_service/service_list" id='expert_service2' name='expert_service2' method="post">
                           <input type="hidden" name="progress" value="2"/>
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="expert_service_dataTable2"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="pageBox">
                          	<ul class="pagination"> </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!-- End 已投标数据 -->

                    <!-- 已服务数据 -->
                    <div class="table_list" id="list3">
                     <form action="<?php echo base_url();?>admin/b2/expert_service/service_list" id='expert_service3' name='expert_service3' method="post">
                     <input type="hidden" name="progress" value="3"/>
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="expert_service_dataTable3"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="pageBox">
                          	<ul class="pagination"> </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!-- End 已中标数据 -->

                    <!-- 已完成数据 -->
                    <div class="table_list" id="list4">
                         <form action="<?php echo base_url();?>admin/b2/expert_service/service_list" id='expert_service4' name='expert_service4' method="post">
                         <input type="hidden" name="progress" value="4"/>
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="expert_service_dataTable4"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="pageBox">
                          	<ul class="pagination"> </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!-- End已取消数据 -->
                      <!-- 已完成数据 -->
                    <div class="table_list" id="list5">
                         <form action="<?php echo base_url();?>admin/b2/expert_service/service_list" id='expert_service5' name='expert_service5' method="post">
                         <input type="hidden" name="progress" value="-1"/>
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="expert_service_dataTable5"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="pageBox">
                          	<ul class="pagination"> </ul>
                          </div>
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
</div>
<!--   遮罩弹框   -->
<div class="bg_box" id="hide_box"></div>
<div id="box_content1" class="box_content" style="width:800px;min-height:200px;margin-left:-400px;">
    <div class="box_header">拒绝理由<span class="close_box" onclick="hidden_modal()">×</span></div>
    <div class="box_body">
      <form action="post" id="service_refused" name="service_refused">
          <textarea name="refused_reason" id="refused_reason"></textarea>
          <input type="hidden" name="sr_id" id="sr_id" value=""/>
          <input type="submit"  value="提交"/>
      </form>
    </div>
</div>

 <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>
<script type="text/javascript">
var columnArr=[];
//邀请数据列表
var expert_service_columns_1=[
      {field : 'addtime',title : '邀请时间',width : '105',align : 'center'},
      {field : 'address',title : '服务地址',width : '80',align : 'center'},
      {field : 'nickname',title : '邀请人',align : 'center', width : '85'},
      {field:'sr_id',title: '操作',align:'center',width:'200',
      formatter:function(value, rowData, rowIndex){
            var html="";
            html += "<a class='action_type'  data-val='"+value+"' onclick='promise(this)'>接受</a>  <a class='action_type'  data-val='"+value+"' onclick='refused(this)'>拒绝</a>";
            return html;
        }
      }];

//服务中列表
var expert_service_columns_2=[{field : 'addtime',title : '邀请时间',width : '105',align : 'center'},
      {field : 'service_time',title : '服务时间',align : 'center', width : '85'},
      {field : 'address',title : '服务地址',width : '80',align : 'center'},
      {field : 'nickname',title : '邀请人',align : 'center', width : '85'},
      {field:'sr_id',title: '操作',align:'center',width:'200',
      formatter:function(value, rowData, rowIndex){
            var html="";
            html += "<a class='action_type'  data-val='"+value+"' onclick='complete_service(this)'>完成服务</a> ";
            return html;
        }
      }];

//已服务
var expert_service_columns_3=[{field : 'addtime',title : '邀请时间',width : '105',align : 'center'},
      {field : 'service_time',title : '服务时间',align : 'center', width : '85'},
      {field : 'address',title : '服务地址',width : '80',align : 'center'},
      {field : 'nickname',title : '邀请人',align : 'center', width : '85'}];

//已完成
var expert_service_columns_4=[{field : 'addtime',title : '邀请时间',width : '105',align : 'center'},
      {field : 'service_time',title : '服务时间',align : 'center', width : '85'},
      {field : 'address',title : '服务地址',width : '80',align : 'center'},
      {field : 'nickname',title : '邀请人',align : 'center', width : '85'},
      {field:'score',title: '评分',align:'left',width:'200'},
      {field:'comment',title: '评论',align:'center',width:'200'},];

 //已拒绝
var expert_service_columns_5=[{field : 'addtime',title : '邀请时间',width : '105',align : 'center'},
      {field : 'address',title : '服务地址',width : '80',align : 'center'},
      {field : 'nickname',title : '邀请人',align : 'center', width : '85'},
      {field:'refuse',title: '拒绝理由',align:'center',width:'200',}];
columnArr[1] =   expert_service_columns_1;
columnArr[2] =   expert_service_columns_2;
columnArr[3] =   expert_service_columns_3;
columnArr[4] =   expert_service_columns_4;
columnArr[5] =   expert_service_columns_5;
var isJsonp= false ;// 是否JSONP,跨域


$(document).ready(function(){
    initTableForm("#expert_service1","#expert_service_dataTable1",columnArr[1],isJsonp ).load();
      $("#myTab li").on("click",function(){
          $("#myTab li").removeClass("active");
          $(this).addClass("active");
          var index=$("#myTab li").index($(this))+1;
          initTableForm("#expert_service"+index,"#expert_service_dataTable"+index,columnArr[index],isJsonp ).load();
      });
});

function promise(obj){
  var sr_id = $(obj).attr('data-val');
    $.post(
        "<?php echo site_url('admin/b2/expert_service/promise');?>",
        {'sr_id':sr_id},
        function(data) {
          data = eval('('+data+')');
          if (data.status == 200) {
            alert(data.msg);
            window.location.reload();
          } else {
            alert(data.msg);
           return false;
          }
        }
      );
}

function complete_service(obj){
    var sr_id = $(obj).attr('data-val');
    $.post(
        "<?php echo site_url('admin/b2/expert_service/complete_service');?>",
        {'sr_id':sr_id},
        function(data) {
          data = eval('('+data+')');
          if (data.status == 200) {
            alert(data.msg);
            window.location.reload();
          } else {
            alert(data.msg);
           return false;
          }
        }
      );
}
//弹框显示
function refused(obj){
        var sr_id = $(obj).attr('data-val');
        $("#sr_id").val(sr_id);
        $("#hide_box").show();
        $("#box_content1").show();
}
//隐藏弹框
function hidden_modal(){
  $("#hide_box").hide();
  $("#box_content1").hide();
  $("#sr_id").val('');
  $("#refused_reason").val('');
}

$("#service_refused").submit(function(){
         $.post(
        "<?php echo site_url('admin/b2/expert_service/refused');?>",
        $('#service_refused').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.status == 200) {
            alert(data.msg);
            window.location.reload();
          } else {
            alert(data.msg);
          }
        }
      );
      return false;
});

</script>
</body>
</html>
