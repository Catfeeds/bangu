<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>定制抢单</title>
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
<style type="text/css">
.page-body{ margin: 0}
body { overflow-y : auto ;}
.last_time { border:5px solid #000;border-radius:2px;font-size:14px;}
h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, img, ol, p{ font-family: "微软雅黑"}
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
.x-grid-cell-inner .check_project { margin:0px;}
.x-grid-cell-inner .action_type { margin:0 10px;}
.page-breadcrumbs {position: relative;min-height: 40px;line-height: 39px;padding: 0;display: block;z-index: 1;left: 0;}
.breadcrumb {padding-left: 10px;background: #fff none repeat scroll 0% 0%;height: 40px;line-height: 40px;box-shadow: none;}
.breadcrumb li { float: left; padding-right: 10px;color: #777;-webkit-text-shadow: none; text-shadow: none;}
.breadcrumb>li+li:before { padding: 0 5px; color: #ccc;content: "/\00a0"; }
.page-content {display: block;margin-left: 160px; margin-right: 0; margin-top: 0; min-height: 100%; padding: 0;}
.fa {display: inline-block;font-family: FontAwesome; font-style: normal;font-weight: normal;line-height: 1;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}
.breadcrumb > li > i {margin-left: 4px; margin-right: 2px; font-size: 20px;  position: relative;top: 2px;}
.page-content .breadcrumb i { font-size: 20px;color: #777;}
.table_content{ margin: 0; padding: 0}
.nav-tabs, .bg_gray{ background: none;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.pageBox{text-align: center; padding:15px;}
.tab_content{ padding-bottom: 0}
.page-content { min-width:1200px;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.tab_content { padding:5px 0 10px !important;}
</style>
</head>
<body>
    <div class="page-content">
<!--=================右侧内容区================= -->
        <div class="page-breadcrumbs">
            <ul class="breadcrumb">
                <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home')?>"> 主页 </a></li>
                <li class="active">定制抢单</li>
            </ul>
        </div>
        <div class="page-body" id="bodyMsg">

        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">

            <div class="table_content">
                <ul class="tab_nav nav nav-tabs tab_shadow clear" id="myTab">
                    <li name="tabs" class="active tab_red" id="tab_list1" status="1"><a href="###">抢单</a></li>
                    <li name="tabs"  class="tab-blue" id="tab_list2" status="5"><a href="###">已回复</a></li>
                    <li name="tabs"  class="tab-blue" id="tab_list3" status="2"><a href="###">已投标</a></li>
                    <li name="tabs" class="tab-blue" id="tab_list4" status="3"><a href="###">已中标</a></li>
                    <li name="tabs" class="tab-blue" id="tab_list5" status="4"><a href="###">已取消</a></li>
                </ul>
                <div class="tab_content">
                <!-- 抢单标签数据 -->
                    <div class="table_list" id="list1">
                    <form action="<?php echo base_url();?>admin/b2/grab_custom_order/ajax_grab_order" id='grab_custom1' name='grab_custom1' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="grab_custom_dataTable1"><!--列表数据显示位置--></div>
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
                              <!-- 已回复数据 -->
                    <div class="table_list" id="list2">
                         <form action="<?php echo base_url();?>admin/b2/grab_custom_order/ajax_replyed_order" id='grab_custom2' name='grab_custom4' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="grab_custom_dataTable2"><!--列表数据显示位置--></div>
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
                    <!-- End已回复数据 -->
                        <!-- 已投标数据 -->
                    <div class="table_list" id="list3">
                           <form action="<?php echo base_url();?>admin/b2/grab_custom_order/ajax_reply_order" id='grab_custom3' name='grab_custom3' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="grab_custom_dataTable3"><!--列表数据显示位置--></div>
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
                    <!-- 已中标数据 -->
                    <div class="table_list" id="list4">
                     <form action="<?php echo base_url();?>admin/b2/grab_custom_order/ajax_bid_order" id='grab_custom4' name='grab_custom4' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="grab_custom_dataTable4"><!--列表数据显示位置--></div>
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
                    <!-- 已取消数据 -->
                    <div class="table_list" id="list5">
                         <form action="<?php echo base_url();?>admin/b2/grab_custom_order/ajax_expired_order" id='grab_custom5' name='grab_custom5' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="grab_custom_dataTable5"><!--列表数据显示位置--></div>
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

 <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>

<script type="text/javascript">
var columnArr=[];
var tab_index = <?php echo $tab_index?>;

//抢单数据列表
var grab_custom_columns_1=[ {field : 'c_id',title : '编号',width : '30',align : 'center'},
      {field : 'startplace',title : '出发城市',width : '80',align : 'center'},
      {field : 'trip_way',title : '出游方式',width : '60',align : 'center'},
      //{field : 'custom_type',title : '定制类型',align : 'center', width : '65'},
      {field : ' ',title : '联系方式',align : 'center', width : '105',
        formatter : function(value, rowData, rowIndex){
            if(rowData['is_allow']==1){
              return rowData['linkname']+'----'+rowData['linkphone'];
            }else{
              return "允许后可见";
            }
        }},
      /*{field : 'startdate',title : '出行日期',align : 'center', width : '100',
        formatter : function(value, rowData, rowIndex){
            var html = "";
            if(value==null || value==undefined || value=='' || value=='0000-00-00'){
                html = rowData['estimatedate'];
            }else{
               html = value;
            }
            return html;
        }},*/
      {field : 'dest',title : '目的地',align : 'center', width : '200'},
      //{field : 'total_people',title : '总人数',align : 'center', width : '30'},
      //{field : 'budget',title : '人均预算',align : 'center', width : '40'},
      //{field : 'days',title : '游玩天数',align : 'center', width : '40'},
      {field:'c_id',title: '操作',align:'center',width:'200',
      formatter:function(value, rowData, rowIndex){
            var html="";
            html += "<a class='action_type'  href='<?php echo base_url('admin/b2/grab_custom_order/reply_project');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"' target='_blank'>抢单回复</a>";
           /* if(rowData['e_id']==null || rowData['e_id']==undefined || rowData['e_id']=='' || rowData['e_status']=='1'){
                                    html+="<a href='<?php echo base_url('admin/b2/grab_custom_order/turn_inquiry_sheet');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['e_id']+"' target='_blank' class='action_type'>转询价单</a>";
            }else{
                 html+="<a href='<?php echo base_url('admin/b2/grab_custom_order/show_turn_inquiry');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['e_id']+"' target='_blank' class='action_type'>查看询价单<i></i></a>";
            }*/
            return html;
        }
      }];

//已回复数据
var grab_custom_columns_2=[ {field : 'c_id',title : '编号',width : '30',align : 'center'},
      {field : 'startplace',title : '出发城市',width : '100',align : 'center'},
      {field : 'trip_way',title : '出游方式',width : '100',align : 'center'},
      //{field : 'custom_type',title : '定制类型',align : 'center', width : '100'},
      {field : ' ',title : '联系方式',align : 'center', width : '105',
        formatter : function(value, rowData, rowIndex){
            if(rowData['is_allow']==1){
              return rowData['linkname']+'----'+rowData['linkphone'];
            }else{
              return "允许后可见";
            }
        }},
       {field : 'startdate',title : '出行日期',align : 'center', width : '100',
        formatter : function(value, rowData, rowIndex){
            var html = "";
            if(value==null || value==undefined || value=='' || value=='0000-00-00'){
                html = rowData['estimatedate'];
            }else{
               html = value;
            }
            return html;
        }},
      {field : 'dest',title : '目的地',align : 'center', width : '200'},
      {field : 'total_people',title : '总人数',align : 'center', width : '100'},
      {field : 'budget',title : '人均预算',align : 'center', width : '100'},
      {field : 'days',title : '游玩天数',align : 'center', width : '100'},
      {field : 'cr_reply',title : '简单回复',align : 'center', width : '105'},
      {field:'cr_answer_id',title: '操作',align:'center',width:'200',
      formatter:function(value, rowData, rowIndex){
            var html="";
            if(value=='' || value==null || value==0){
                  html += "<a class='action_type' href='<?php echo base_url('admin/b2/grab_custom_order/reply_project');?>?c_id="+rowData['c_id']+"&ca_id="+value+"&reply_again=1' target='_blank'>添加方案</a>";
            }else{
                 html += "<a class='action_type' href='<?php echo base_url('admin/b2/grab_custom_order/reply_project');?>?c_id="+rowData['c_id']+"&ca_id="+value+"&reply_again=1' target='_blank'>再次发单</a>";
            }
            return html;
        }
      }];





//已投标列表
var grab_custom_columns_3=[ {field : 'c_id',title : '编号',width : '30',align : 'center'},
      {field : 'startplace',title : '出发城市',width : '100',align : 'center'},
      {field : 'trip_way',title : '出游方式',width : '100',align : 'center'},
      //{field : 'custom_type',title : '定制类型',align : 'center', width : '100'},
    {field : ' ',title : '联系方式',align : 'center', width : '100',
        formatter : function(value, rowData, rowIndex){
             if(rowData['is_allow']==1){
              return rowData['linkname']+'----'+rowData['linkphone'];
            }else{
              return "允许后可见";
            }
        }},
      {field : 'startdate',title : '出行日期',align : 'center', width : '100',
        formatter : function(value, rowData, rowIndex){
            var html = "";
            if(value==null || value==undefined || value=='' || value=='0000-00-00'){
                html = rowData['estimatedate'];
            }else{
               html = value;
            }
            return html;
        }},
      {field : 'dest',title : '目的地',align : 'center', width : '200'},
      {field : 'total_people',title : '总人数',align : 'center', width : '100'},
      {field : 'budget',title : '人均预算',align : 'center', width : '100'},
      {field : 'days',title : '游玩天数',align : 'center', width : '100'},
      {field:'c_id',title: '操作',align:'left',width:'260',
      formatter:function(value, rowData, rowIndex){
            var html="";
                    html += "<span class='check_project'><a class='action_type'>查看方案<i></i></a><div class='hide_project_title'>";
                   if(rowData['plan']!=undefined && rowData['plan'].length>0){
                                    var k_index = 1;
                                    $.each(rowData['plan'],function(key,val){
                                         if(val['isuse']==1){
                                          var string="<span style='padding-right:0;color:red'>已中标</span>";
                                        }else{
                                          var string="<span style='padding-right:0;color:blue'>未中标</span>";
                                        }
                                        html += "<p><a href='<?php echo base_url('admin/b2/grab_custom_order/show_reply_project');?>?c_id="+value+"&ca_id="+val['ca_id']+"' class='action_type' target='_blank'>方案"+k_index+"</a><span style='margin-left:-8px'>回复时间："+val['replytime']+"</span>"+string+"</p>";
                                        k_index++;
                                    });
                     }
                 html += "</div></span>"
                 if(rowData['c_status']==0){
                     html += "<a class='action_type' href='<?php echo base_url('admin/b2/grab_custom_order/reply_project');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&reply_again=1' target='_blank'>再次投标</a>";
                 }
                  if(rowData['e_id']==null || rowData['e_id']==undefined || rowData['e_id']=='' || rowData['e_status']=='1'){
                         html+="<a href='<?php echo base_url('admin/b2/grab_custom_order/turn_inquiry_sheet');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['e_id']+"' target='_blank' class='action_type'>转询价单<i></i></a>";
            }else{
                  html+="<a href='<?php echo base_url('admin/b2/grab_custom_order/show_turn_inquiry');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['e_id']+"' target='_blank' class='action_type'>查看询价单<i></i></a>";
            }
            return html;
        }
      }];

//已中标
var grab_custom_columns_4=[{field : ' ',title : ' ',width : '90',align : 'center',
 formatter : function(value, rowData, rowIndex){
            return "<img src='<?php echo base_url();?>assets/img/zhongbiao_icon.png' class='zhongbiao'/>";
        }},
      {field : 'c_id',title : '编号',width : '40',align : 'center'},
      {field : 'startplace',title : '出发城市',width : '80',align : 'center'},
      {field : 'trip_way',title : '出游方式',width : '230',align : 'center'},
      //{field : 'custom_type',title : '定制类型',align : 'center', width : '80'},
      {field : ' ',title : '联系方式',align : 'center', width : '100',
        formatter : function(value, rowData, rowIndex){
             if(rowData['is_allow']==1){
              return rowData['linkname']+'----'+rowData['linkphone'];
            }else{
              return "允许后可见";
            }
        }},
      {field : 'startdate',title : '出行日期',align : 'center', width : '200',
        formatter : function(value, rowData, rowIndex){
            var html = "";
            if(value==null || value==undefined || value=='' || value=='0000-00-00'){
                html = rowData['estimatedate'];
            }else{
               html = value;
            }
            return html;
        }},
      {field : 'dest',title : '目的地',align : 'center', width : '100'},
      {field : 'total_people',title : '总人数',align : 'center', width : '200'},
      {field : 'budget',title : '人均预算',align : 'center', width : '200'},
      {field : 'days',title : '游玩天数',align : 'center', width : '200'},
      {field:'c_id',title: '操作',align:'center',width:'200',
      formatter:function(value, rowData, rowIndex){
            var html="";
                    html += "<span class='check_project'><a class='action_type'>查看方案<i></i></a><div class='hide_project_title'>";
                   if(rowData['plan']!=undefined && rowData['plan'].length>0){
                                    var k_index = 1;
                                    $.each(rowData['plan'],function(key,val){
                                       if(val['isuse']==1){
                                          var string="<span style='padding-right:0;color:red'>已中标</span>";
                                        }else{
                                          var string="<span style='padding-right:0;color:blue'>未中标</span>";
                                        }
                                        html += "<p><a href='<?php echo base_url('admin/b2/grab_custom_order/show_reply_project');?>?c_id="+value+"&ca_id="+val['ca_id']+"' class='action_type' target='_blank'>方案"+k_index+"</a><span style='margin-left:-8px'>回复时间："+val['replytime']+"</span>"+string+"</p>";
                                        k_index++;
                                    });
                     }
                 html += "</div></span>"
            if(rowData['e_id']==null || rowData['e_id']==undefined || rowData['e_id']=='' || rowData['e_status']=='1'){
                                    html+="<a href='<?php echo base_url('admin/b2/grab_custom_order/turn_inquiry_sheet');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['e_id']+"' target='_blank' class='action_type'>转询价单</a>";
            }else{
                 html+="<a href='<?php echo base_url('admin/b2/grab_custom_order/show_turn_inquiry');?>?c_id="+value+"&ca_id="+rowData['ca_id']+"&e_id="+rowData['e_id']+"' target='_blank' class='action_type'>查看询价单<i></i></a>";
            }
            //html += "</span>";
            return html;
        }
      }];

//过期
var grab_custom_columns_5=[ {field : 'c_id',title : '编号',width : '30',align : 'center'},
      {field : 'startplace',title : '出发城市',width : '100',align : 'center'},
      {field : 'trip_way',title : '出游方式',width : '100',align : 'center'},
      //{field : 'custom_type',title : '定制类型',align : 'center', width : '100'},
    /*  {field : ' ',title : '联系方式',align : 'center', width : '105'},*/
       {field : 'startdate',title : '出行日期',align : 'center', width : '100',
        formatter : function(value, rowData, rowIndex){
            var html = "";
            if(value==null || value==undefined || value=='' || value=='0000-00-00'){
                html = rowData['estimatedate'];
            }else{
               html = value;
            }
            return html;
        }},
      {field : 'dest',title : '目的地',align : 'center', width : '200'},
      {field : 'total_people',title : '总人数',align : 'center', width : '100'},
      {field : 'budget',title : '人均预算',align : 'center', width : '100'},
      {field : 'days',title : '游玩天数',align : 'center', width : '100'}];




columnArr[1] =   grab_custom_columns_1;
columnArr[2] =   grab_custom_columns_2;
columnArr[3] =   grab_custom_columns_3;
columnArr[4] =   grab_custom_columns_4;
columnArr[5] =   grab_custom_columns_5;
var isJsonp= false ;// 是否JSONP,跨域


$(document).ready(function(){
    initTableForm("#grab_custom1","#grab_custom_dataTable1",columnArr[1],isJsonp ).load();
      $("#myTab li").on("click",function(){
          $("#myTab li").removeClass("active");
          $(this).addClass("active");
          var index=$("#myTab li").index($(this))+1;
          initTableForm("#grab_custom"+index,"#grab_custom_dataTable"+index,columnArr[index],isJsonp ).load();
      });
	$(document).on('mouseover', '.check_project', function(){
        $(this).find(".hide_project_title").show();
      });
	$(document).on('mouseout', '.check_project', function(){
        $(this).find(".hide_project_title").hide();
      });

   $("#myTab li").eq(tab_index).click();
});
</script>
</body>
</html>
