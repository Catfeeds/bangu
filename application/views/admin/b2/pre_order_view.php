<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>产品预订</title>
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
#list1 .x-grid-cell-inner a:nth-child(1) { }
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
.nav-tabs,.bg_gray{ background: #eaedf1;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #000;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px; font-size: 12px; font-family: "宋体"; color: #000;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.shadows{box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4); -webkit-box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);-moz-box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);}
.formBox{ padding:0; padding-bottom:5px; margin-bottom:5px;}
select{ height:24px; line-height:24px;}
.form-group{ margin-right: 20px; float:left;}
.form-group label{ height: 24px; line-height: 24px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #333; float: left; width: 64px;font-family: "宋体";}
.form-group input{ height: 24px; line-height: 24px; padding: 0  10px; float: left;width: 76px;}
.box-title h4{ height:40px; line-height:40px; background:#f1f1f1; text-indent:10px;}
.trip_every_day{ padding:20px 15px;}
.trip_every_day img{ padding:0px 5px; margin-top:5px;}
.trip_every_day .trip_day_title{ line-height:24px;}
.trip_content_left{ font-weight: bold;}
.trip_content_right{ padding-left:60px;}
.x-grid-cell-inner a{ display: inline-block; padding: 0 5px; color: #005580;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.min_w_1200{min-width: 1210px;}
.tab_content { padding:10px 0;}

.ipt_limit{margin-top:6px;background:#0099CC;color:#fff;border:none !important;cursor:pointer;border-radius:3px;padding:4px 8px;}
.btn-palegreen{ background-color:#0099CC !important; border-color:#09c !important;border-radius:3px;cursor:pointer;}
.btn-palegreen:hover{ background-color:#0099CC !important; border-color:#09c !important; opacity:0.9;}

#set_limit_div .depart_div{width:95%;height:38px;line-height:38px;float:left;margin-left:50px;}
#set_limit_div .first{margin-left:15px;}
#set_limit_div .depart_div font{color:#005580;} 
#set_limit_div .depart_div p{width:350px;float:right;margin-right:50;} 
#set_limit_div .depart_div p input{width:100px;margin-top:7px;padding-left:2px;} 

</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
</head>
<body>
<?php $this->load->view("admin/b2/common/dest_tree"); //加载树形目的地   ?>
<div class="page-content bg_gray">
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home')?>"> 主页 </a></li>
            <li class="active">产品预订</li>
        </ul>
    </div>
    
    <div style="height:40px;background:#fff;padding-left:20px;">
      <p style="font-size:14px;line-height:40px;float:left">现金额度:<span style="color:red"><?php echo number_format($account['cash_limit'],2);?></span></p>
      <p style="font-size:14px;line-height:40px; margin-left:20px;float:left">信用额度:<span style="color:red"><?php echo number_format($account['credit_limit'],2);?></span></p>
      <p style="font-size:14px;line-height:40px;margin-left:20px;float:left">总额度:<span style="color:red"><?php echo number_format($account['cash_limit']+$account['credit_limit'],2);?></span></p>
      <p style="font-size:14px;line-height:40px;margin-left:20px;float:left">
      <?php if($is_manage==1):?> <!--  <input type="button" class="ipt_limit btn_open_limit" value="额度管理"> --> <?php endif;?>
      </p>
    </div>
  
    <div class="page-body" id="bodyMsg" style="padding-top:0 !important;">

        <div class="table_content">
            <ul class="tab_nav nav nav-tabs tab_shadow clear" id="myTab">
                <li name="tabs" class="active tab_red" id="tab_list1" status="1"><a href="###">直属供应商</a></li>
                <!-- <li name="tabs"  class="tab-blue" id="tab_list2" status="2"><a href="###">非直属供应商</a></li> -->
               <?php if($expert_stauts==2 && $is_line==1){ ?> 
              <!-- <li name="tabs" class="tab_red" id="tab_list3" status="3"><a href="###">售卖线路</a></li>-->
               <?php }?>
            </ul>
            <div class="tab_content">
                <!-- 直属供应商数据 -->
                <div class="table_list" id="list1">
                    <form action="<?php echo base_url();?>admin/b2/pre_order/ajax_get_product" id='refund_list1' name='refund_list1' method="post">
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                         <div class="form-inline formBox shadow min_w_1200">
			              <div class="form-group">
			                <label class="search_title col_span" >线路类型:</label>
			                <!-- <select id="dest_select" name="destid" class="dest_select ie8_select">
			                   <option value="">--请选择--</option>
			                               </select> -->
			                <input type="text" id="dest_id"  onfocus="showMenu(this.id,this.value,0,0);" onkeyup="showMenu(this.id,this.value,0,0);" placeholder="输入关键字搜索" class="search_input" style="width:150px;padding:0 8px 0 7px;" />
			                <input type="hidden" name="destid" id="input_dest" value=""/>
			              </div>
			              <div class="form-group">
			                  <label class="search_title col_span" >行程天数:</label>
			                  <input class="search-input form-control" style="width:40px;" type="text" name="start_days" />
			                  <label style="border:none;width:auto;">至</label>
			                  <input class="search-input form-control" style="width:40px;" type="text" name="end_days" />
			              </div>
			              <div class="form-group">
			                    <label class="search_title col_span" >出发地:</label>
			                    <input class="search-input form-control ie8_input" type="text" id="start_place" name="start_place" style="width:100px" />
			              </div>
			              <div class="form-group">
			                    <label class="search_title col_span" >团号:</label>
			                    <input class="search-input form-control ie8_input" type="text" id="team_num" name="team_num" style="width:100px" />
			              </div>
			
			               <!--  <div class="form-group">
			                   <label class="search_title col_span" >线路编号:</label>
			                   <input type="text" name="linecode" class="form-control search-input ie8_input" >
			               </div> -->
			               <div class="form-group">
			                  <label class="search_title col_span" >产品标题:</label>
			                  <input type="text" name="linename" class="form-control search-input ie8_input" style="width:145px;" >
			               </div>
						
			                <div class="form-group">
			                      <label class="search_title col_span" >价格:</label>
			                      <input class="search-input form-control" style="width:40px;" type="text" name="start_price" />
			                      <label style="border:none;width:auto;">至</label>
			                      <input class="search-input form-control" style="width:40px;" type="text" name="end_price" />
			                </div>
			                <div class="form-group">
			                    <label class="search_title col_span" >出团时间:</label>
			                    <input class="search-input form-control starttime" style="width:70px;" type="text" placeholder="开始时间"  name="starttime" />
			                    <label style="border:none;width:auto;">-</label>
			                    <input class="search-input form-control endtime" style="width:70px;" type="text" placeholder="结束时间"  name="endtime" />
			                </div>
			                <input type="hidden" name="is_zhishu" value="1">
			                <button type="button" class="btn btn-darkorange" id="searchBtn1" style="position: relative; top: 10px; float: left;"> 搜索 </button>
			            </div>
                        <div id="refund_list_dataTable1"><!--列表数据显示位置--></div>
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
                <!--  End 直属供应商数据  -->
                <!-- 非直属供应商数据 -->
           <!--      <div class="table_list" id="list2">
                     <form action="<?php echo base_url();?>admin/b2/pre_order/ajax_get_product" id='refund_list2' name='refund_list2' method="post">
			            <div class="form-inline formBox shadow min_w_1200">
			              <div class="form-group">
			                <label class="search_title col_span" >线路类型:</label>
			               <input type="text" id="dest_select"  onfocus="showMenu(this.id);" class="search_input" style="width:150px;" />
			                <input type="hidden" name="destid"  value=""/>
			              </div>
			              <div class="form-group">
			                    <label class="search_title col_span" >行程天数:</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="start_days" />
			                    <label style="border:none;width:auto;">至</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="end_days" />
			                </div>
			                <div class="form-group">
			                    <label class="search_title col_span" >出发地:</label>
			                    <input class="search-input form-control ie8_input" type="text" id="start_place2" name="start_place" style="width:100px;" />
			                </div>
			
			                <div class="form-group">
			                    <label class="search_title col_span" >团号:</label>
			                    <input class="search-input form-control ie8_input" type="text" id="team_num" name="team_num" style="width:100px" />
			                </div>
			                <div class="form-group">
			                    <label class="search_title col_span" >出团时间:</label>
			                    <input class="search-input form-control starttime" style="width:80px;" type="text" placeholder="开始时间"  name="starttime" />
			                    <label style="border:none;width:auto;">-</label>
			                    <input class="search-input form-control endtime" style="width:80px;" type="text" placeholder="结束时间"  name="endtime" />
			                </div>
			
			                <div class="form-group">
			                    <label class="search_title col_span" >产品标题:</label>
			                    <input type="text" name="linename" class="form-control search-input ie8_input" style="width:104px;" >
			                </div>
			                   <div class="form-group">
			                    <label class="search_title col_span" >价格:</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="start_price" />
			                    <label style="border:none;width:auto;">至</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="end_price" />
			                </div>
			
			                  <input type="hidden" name="is_zhishu" value="2">
			                <button type="button" class="btn btn-darkorange" id="searchBtn2" style="position: relative; top: 10px;float: left;"> 搜索 </button>
			            </div>
                        <div id="refund_list_dataTable2"></div>
                        <div class="row DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap"  style=" text-align:center">
                                    <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>--> 
                <!-- End 非直属供应商数据 -->
                
                <!-- 售卖线路数据 -->
   <!--           <div class="table_list" id="list3">
                     <form action="<?php echo base_url();?>admin/b2/pre_order/get_sell_line" id='refund_list3' name='refund_list3' method="post">
			            <div class="form-inline formBox shadow min_w_1200">
			              <div class="form-group">
			                <label class="search_title col_span" >线路类型:</label>
			               <input type="text" id="dest_select"  onfocus="showMenu(this.id,this.value,0,0);" class="search_input" style="width:150px;" />
			                <input type="hidden" name="destid"  value=""/>
			              </div>
			               <div class="form-group">
			                    <label class="search_title col_span" >行程天数:</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="start_days" />
			                    <label style="border:none;width:auto;">至</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="end_days" />
			               </div>
			               <div class="form-group">
			                    <label class="search_title col_span" >出发地:</label>
			                    <input class="search-input form-control ie8_input" type="text" id="start_place2" name="start_place" style="width:100px;" />
			               </div>
			
			               <div class="form-group">
			                    <label class="search_title col_span" >团号:</label>
			                    <input class="search-input form-control ie8_input" type="text" id="team_num" name="team_num" style="width:100px" />
			               </div>
			
			               <div class="form-group">
			                    <label class="search_title col_span" >出团时间:</label>
			                    <input class="search-input form-control starttime" style="width:80px;" type="text" placeholder="开始时间"  name="starttime" />
			                    <label style="border:none;width:auto;">-</label>
			                    <input class="search-input form-control endtime" style="width:80px;" type="text" placeholder="结束时间"  name="endtime" />
			               </div>
			
			               <div class="form-group">
			                    <label class="search_title col_span" >产品标题:</label>
			                    <input type="text" name="linename" class="form-control search-input ie8_input" style="width:104px;" >
			               </div>
			               <div class="form-group">
			                    <label class="search_title col_span" >价格:</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="start_price" />
			                    <label style="border:none;width:auto;">至</label>
			                    <input class="search-input form-control" style="width:40px;" type="text" name="end_price" />
			               </div>
			
			                  
			                <button type="button" class="btn btn-darkorange" id="searchBtn3" style="position: relative; top: 10px;float: left;"> 搜索 </button>
			            </div>
                        <div id="refund_list_dataTable3"></div>
                        <div class="row DTTTFooter">
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap"  style=" text-align:center">
                                    
                                    <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>-->    
                <!-- End 售卖线路数据 -->
                
                
            </div>
        </div>
    </div>
</div>

<div class="fb-content" id="set_limit_div" style="display:none;">
    <div class="box-title">
        <!-- <h4>充值账户余额</h4> -->
        <h4>部门额度调整</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form data_list" style=" overflow: hidden; padding:15px;">
        <!-- 部门列表 -->
    </div>
</div>


 <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script type="text/javascript">
var tree_tag="";
 // 列数据映射配置
  var refund_list_columns=[
                  {field : 'desp',title : '团号',width : '120',align : 'left',
                       formatter: function(value,rowData,rowIndex){
                         if(value==null || value==""){
                            return "无团号";
                         }else{
                            return value;
                         }
                    }
                  },
                  {field : 'startplace',title : '出发城市',width : '70',align : 'center'},
                  {field : 'linename',title : '线路标题',width : '200',align : 'left',formatter: function(value,rowData,rowIndex){
                      var name = value+('标准价'==rowData['suitname']?'':rowData['suitname']);
                      return '<a href="###" dataid="'+rowData['lineid']+'" onclick="show_line_detail('+rowData['lineid']+',2)" >'+name+'</a>';
                  }},
                  {field : 'brand',title : '供应商',width : '100',align : 'center',formatter: function(value,rowData,rowIndex){
                      //var name = value+('标准价'==rowData['suitname']?'':rowData['suitname']);
                      return '<a href="###" dataid="'+rowData['supplier_id']+'" name="supplierDetail">'+rowData['brand']+'</a>';
                  }},
                  //{field : 'linecode',title : '线路编号',width : '90',align : 'center'},
//                {field : 'suitname',title : '套餐名称',width : '90',align : 'left'},
                  {field : 'day',title : '出团日期',width : '80',align : 'center'},
                  {field : 'before_day',title : '截至时间',width : '80',align : 'center',formatter: function(value,rowData,rowIndex){
                        var before_sec = rowData['before_day']*24*60*60;
                        if(before_sec==0 && rowData['p_hour']==0 &&rowData['p_minute']==0){
                              rowData['p_hour']='23';
                              rowData['p_minute']='59';
                        }
                        var sec = stringToDate(rowData['day'] + ' '+rowData['p_hour']+':'+rowData['p_minute']+':00')/1000;
                        var sec2 = Number(sec)-Number(before_sec);
                        var date = new Date(sec2*1000);
                        var years = date.getFullYear();
                        var months = date.getMonth()+1;
                        if (months >= 1 && months <= 9) {
                              months = "0" + months;
                        }
                        var days = date.getDate();
                         if (days >= 0 && days <= 9) {
                            days = "0" + days;
                          }
                        var hours = date.getHours();
                         if (hours >= 0 && hours <= 9) {
                            hours = "0" + hours;
                          }
                        var minutes = date.getMinutes();
                         if (minutes >= 0 && minutes <= 9) {
                            minutes = "0" + minutes;
                          }
                        return years+'-'+months+'-'+days+' '+hours+':'+minutes;
                  }},
                  {field : 'number',title : '余位',width : '60',align : 'center'},
                  {field : 'adultprice',title : '成人价',width : '70',align : 'center'},
                  //{field : 'oldprice',title : '老人价',width : '70',align : 'center'},
                  {field : 'childprice',title : '小童价格',width : '70',align : 'center'},
                  {field : 'childnobedprice',title : '小童不占',width : '70',align : 'center'},
                  {field : 'dayid',title : '已定人数',width : '90',align : 'center',
                         formatter: function(value,rowData,rowIndex){
                            rowData['total_dingnum'] = rowData['total_dingnum']==null ? 0 : rowData['total_dingnum'];
                            rowData['total_oldnum'] = rowData['total_oldnum']==null ? 0 : rowData['total_oldnum'];
                            rowData['total_childnum'] = rowData['total_childnum']==null ? 0 : rowData['total_childnum'];
                            rowData['total_childnobednum'] = rowData['total_childnobednum']==null ? 0 : rowData['total_childnobednum'];
                            return rowData['total_dingnum']+'+'+rowData['total_oldnum']+'+'+rowData['total_childnum']+'+'+rowData['total_childnobednum'];
                   		 }
                  },

			      {field:'dayid',title : '操作', align : 'center',width : '100',
			        formatter: function(value,rowData,rowIndex){
			          if(get_date_diff(rowData['day'],rowData['p_hour'],rowData['p_minute'],rowData['before_day'])){
			               var html =  "<a target='_blank' href='<?php echo base_url();?>order_from/order_info/order_basic?day_id="+value+"&expert_id="+rowData['eid']+"'>预定</a>";
			          }else{
			             var html =  "<a target='_blank' style='color:#999'>已停售</a>";
			          }
			                  //html += "<a target='_blank' href='<?php echo base_url();?>admin/b2/pre_order/show_travel?line_id="+rowData['lineid']+"'>行程</a>";
			                  html += "<a class='a_trip' data-id='"+rowData['lineid']+"' dayid='"+rowData['dayid']+"' href='javascript:void(0)'>行程</a>";
			
			                  return html;
			
			        }
			      }
  ];

  //售卖线路数据---@xml
    var sell_line_columns=[
             {field : 'desp',title : '团号',width : '120',align : 'left',
                   formatter: function(value,rowData,rowIndex){
                         if(value==null || value==""){
                            return "无团号";
                         }else{
                            return value;
                         }
                    }
              },
             {field : 'cityname',title : '出发城市',width : '70',align : 'center'},
             {field : 'linename',title : '线路标题',width : '200',align : 'left',formatter: function(value,rowData,rowIndex){
                   var name = value+('标准价'==rowData['suitname']?'':rowData['suitname']);
                   return '<a href="###" onclick="show_line_detail('+rowData['lineid']+',2)">'+name+'</a>';
             }},
             {field : 'brand',title : '供应商',width : '100',align : 'center',formatter: function(value,rowData,rowIndex){
 
                  return '<a href="###" dataid="'+rowData['supplier_id']+'" name="supplierDetail">'+rowData['brand']+'</a>';
             }},

             {field : 'day',title : '出团日期',width : '80',align : 'center'},
             {field : 'before_day',title : '截至时间',width : '80',align : 'center',formatter: function(value,rowData,rowIndex){
                    var before_sec = rowData['before_day']*24*60*60;
                    if(before_sec==0 && rowData['p_hour']==0 &&rowData['p_minute']==0){
                          rowData['p_hour']='23';
                          rowData['p_minute']='59';
                    }
                    var sec = stringToDate(rowData['day'] + ' '+rowData['p_hour']+':'+rowData['p_minute']+':00')/1000;
                    var sec2 = Number(sec)-Number(before_sec);
                    var date = new Date(sec2*1000);
                    var years = date.getFullYear();
                    var months = date.getMonth()+1;
                    if (months >= 1 && months <= 9) {
                          months = "0" + months;
                    }
                    var days = date.getDate();
                    if (days >= 0 && days <= 9) {
                         days = "0" + days;
                    }
                    var hours = date.getHours();
                    if (hours >= 0 && hours <= 9) {
                         hours = "0" + hours;
                    }
                    var minutes = date.getMinutes();
                    if (minutes >= 0 && minutes <= 9) {
                       minutes = "0" + minutes;
                    }
                    return years+'-'+months+'-'+days+' '+hours+':'+minutes;
               }},
               {field : 'number',title : '余位',width : '60',align : 'center'},
               {field : 'adultprice',title : '成人价',width : '70',align : 'center'},
               {field : 'childprice',title : '小童价格',width : '70',align : 'center'},
               {field : 'childnobedprice',title : '小童不占',width : '70',align : 'center'},
               {field : 'dayid',title : '已定人数',width : '90',align : 'center',
                    formatter: function(value,rowData,rowIndex){
                          rowData['total_dingnum'] = rowData['total_dingnum']==null ? 0 : rowData['total_dingnum'];
                          rowData['total_oldnum'] = rowData['total_oldnum']==null ? 0 : rowData['total_oldnum'];
                          rowData['total_childnum'] = rowData['total_childnum']==null ? 0 : rowData['total_childnum'];
                          rowData['total_childnobednum'] = rowData['total_childnobednum']==null ? 0 : rowData['total_childnobednum'];
                          return rowData['total_dingnum']+'+'+rowData['total_oldnum']+'+'+rowData['total_childnum']+'+'+rowData['total_childnobednum'];
                    }
               },

		      {field:'dayid',title : '操作', align : 'center',width : '100',
		        formatter: function(value,rowData,rowIndex){
		          if(get_date_diff(rowData['day'],rowData['p_hour'],rowData['p_minute'],rowData['before_day'])){
		               var html =  "<a target='_blank' href='<?php echo base_url();?>order_from/order_info/order_basic?day_id="+value+"&expert_id="+rowData['eid']+"'>预定</a>";
		          }else{
		               var html =  "<a target='_blank' style='color:#999'>已停售</a>";
		          }
		               //html += "<a target='_blank' href='<?php //echo base_url();?>admin/b2/pre_order/show_travel?line_id="+rowData['lineid']+"'>行程</a>";
		               html += "<a class='a_trip' data-id='"+rowData['lineid']+"' dayid='"+rowData['dayid']+"' href='javascript:void(0)'>行程</a>";
		
		               return html;
		
		        }
     	    }
 		 ];
  
var isJsonp= false ;// 是否JSONP,跨域
$(document).ready(function(){
     initTableForm("#refund_list1","#refund_list_dataTable1",refund_list_columns,isJsonp ).load();
     initTableForm("#refund_list3","#refund_list_dataTable3",sell_line_columns,isJsonp ).load();
      $("#myTab li").on("click",function(){
          $("#myTab li").removeClass("active");
          $(this).addClass("active");
          var index=$("#myTab li").index($(this))+1;
          if(index==2){
        	  initTableForm("#refund_list3","#refund_list_dataTable3",sell_line_columns,isJsonp ).load();
          }else{
        	  initTableForm("#refund_list"+index,"#refund_list_dataTable"+index,refund_list_columns,isJsonp ).load();
          }
         
      });

		$("#searchBtn1").click(function(){
		    initTableForm("#refund_list1","#refund_list_dataTable1",refund_list_columns,isJsonp ).load();
		});
		$("#searchBtn2").click(function(){
            initTableForm("#refund_list2","#refund_list_dataTable2",refund_list_columns,isJsonp ).load();
        });

		$("#searchBtn3").click(function(){
			initTableForm("#refund_list3","#refund_list_dataTable3",sell_line_columns,isJsonp ).load();
        });


});






function get_date_diff(startDate,hour,minute,linebefore){

    if(hour==0 ||  hour==''){
          hour='00';
     }
     if(minute==0 || minute==''){
        minute='00';
     }
     var before_sec = linebefore*24*60*60;
     if(before_sec==0 && hour=='00' && minute=='00'){
          hour='23';
          minute='59';
     }
     var sec = stringToDate(startDate + ' '+hour+':'+minute+':00')/1000;
     var sec2 = Number(sec)-Number(before_sec);
     var endTime2  = (new Date().getTime())/1000;
     if(endTime2>sec2){
        return false;
     }else{
      return true;
     }
}

function stringToDate(string) {
	var f = string.split(' ', 2);
	var d = (f[0] ? f[0] : '').split('-', 3);
	var t = (f[1] ? f[1] : '').split(':', 3);
	return (new Date(parseInt(d[0], 10) || null, (parseInt(d[1], 10) || 1) - 1,
		parseInt(d[2], 10) || null, parseInt(t[0], 10) || null, parseInt(
				t[1], 10) || null, parseInt(t[2], 10) || null));
}

/*将后台传过来的数据组装成树形结构*/
function listToTree(list,pid) {
  var ret = [];//一个存放结果的临时数组
  for(var i in list) {
    if(list[i].pid == pid) {//如果当前项的父id等于要查找的父id，进行递归
        list[i].children = listToTree(list, list[i].id);
        ret.push(list[i]);//把当前项保存到临时数组中
    }
  }
  return ret;//递归结束后返回结果
}

//最后拼接成一个完整的select数据
function creatSelectTree(d){
   var option="";
   for(var i=0;i<d.length;i++){
   if(d[i].children.length){//如果有子集
        option+="<option value='"+d[i].id+"'>"+tree_tag+d[i].kindname+"</option>";
      tree_tag+="&nbsp;&nbsp;&nbsp;";//前缀符号加一个符号
        option+=creatSelectTree(d[i].children);//递归调用子集
      tree_tag=tree_tag.slice(0,tree_tag.length-18);//每次递归结束返回上级时，前缀符号需要减一个符号
       }else{//没有子集直接显示
         option+="<option value='"+d[i].id+"'>"+tree_tag+d[i].kindname+"</option>";
        }
       }
    return option;//返回最终html结果
  }
//目的地
$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var dest_list = listToTree(data,0);
  $(".dest_select").append(creatSelectTree(dest_list));
});


//出发地
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.cityname,
        value : val.id,
    });
  });
  var comboBox = new jQuery.comboBox({
      id : "#start_place",
      name : "start_place_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
  var comboBox = new jQuery.comboBox({
      id : "#start_place2",
      name : "start_place_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
});

$('.starttime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
$('.endtime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});

// 打印行程 
$("body").on("click",".a_trip",function(){

    var line_id=$(this).attr("data-id");
    var dayid=$(this).attr("dayid");

	var win1 = window.open("<?php echo base_url('admin/b2/union/travel_print');?>"+"?id="+line_id+"&dayid="+dayid,'print','height=950,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes, resizable=yes,location=no, status=no');
	win1.focus();

})
//线路详情弹窗
	/*	$('.table_content').on("click",'[name="lineDetail"]',function(){
			var me = $(this);
			var dataid = me.attr("dataid");
			window.top.openWin({
				title:'线路详情',
				type: 2,
				area: ['1000px', '90%'],
				fix: false, //不固定
				maxmin: true,
				content: "<?php echo base_url();?>admin/b2/pre_order/line_detail?id="+dataid
			});

		});*/
//供应商详情弹窗
$('.table_content').on("click",'[name="supplierDetail"]',function(){
	var dataid = $(this).attr("dataid");
	window.top.openWin({
		title:'供应商详情',
		type: 2,
		area: ['600px', '300px'],
		fix: false, //不固定
		maxmin: true,
		content: "<?php echo base_url();?>admin/b2/pre_order/supplier_detail?id="+dataid
	});
});//end

function ajax_depart_limit(depart_id){

	$.ajax({
        url:"<?php echo base_url('admin/b2/pre_order/depart_list');?>",
        data:{},
        type:"post",
        async:false,
        dataType:"json",
        success:function(data){
            if(data.code==2000){
                var html="";
                for(var i in data.data){
                    var className="second";
                    if(data.data[i].pid=="0")
                        className="first";
						html+="<div class='depart_div "+className+"'>";
						html+="   <font>"+data.data[i].name+"</font>&nbsp;（现金："+toDecimal2(data.data[i].cash_limit)+"，信用："+toDecimal2(data.data[i].credit_limit)+"）";
						if(data.data[i].pid!="0"){
	 						var display_str=data.data[i].id==depart_id?'block':'none';
						html+="   <p class='input_p' style='display:"+display_str+";'>现金:<input type='text' class='ipt_cash' value='"+data.data[i].cash_limit+"' onkeyup='check_shuliang(this)' />&nbsp;&nbsp;信用:<input type='text' class='ipt_credit' value='"+data.data[i].credit_limit+"' onkeyup='check_shuliang(this)' /><input class='btn-palegreen btn_save_limit' depart-id='"+data.data[i].id+"' type='button' value='保存' style='width:36px;margin-left:15px;' />";
						html+="   </p>";
						}
						html+="</div>";
                }
            	$(".data_list").html(html);
 
             }else{

             }
            
        },
        error:function(data){
            tan('请求异常');
        }
        
   });	
}
//数量：正数、小数  
	function check_shuliang(obj){
		var value=$(obj).val();
		value=value.replace(/[^\- \d.]/g,'');  //   ;  /[^\- \d.]/g  正数、负数、小数 ;   /[^\d]/g   只能正数、小数 ;  
		$(obj).val(value);
	}
// 打开额度调整窗口
$("body").on("click",".btn_open_limit",function(){
        $.ajax({
            url:"<?php echo base_url('admin/b2/pre_order/depart_list');?>",
            data:{},
            type:"post",
            dataType:"json",
            success:function(data){
                if(data.code==2000){
                    var html="";
                    for(var i in data.data){
                        var className="second";
                        if(data.data[i].pid=="0")
                            className="first";
                        var background_str=i==1?'#ccc':'#fff';

 						html+="<div class='depart_div "+className+"' style='background:"+background_str+";'>";
 						html+="   <font>"+data.data[i].name+"</font>&nbsp;（现金："+toDecimal2(data.data[i].cash_limit)+"，信用："+toDecimal2(data.data[i].credit_limit)+"）";
 						if(data.data[i].pid!="0"){
 	 						var display_str=i==1?'block':'none';
 						html+="   <p class='input_p' style='display:"+display_str+";'>现金:<input type='text' class='ipt_cash' value='"+data.data[i].cash_limit+"' onkeyup='check_shuliang(this)' />&nbsp;&nbsp;信用:<input type='text' class='ipt_credit' onkeyup='check_shuliang(this)' value='"+data.data[i].credit_limit+"' /><input class='btn-palegreen btn_save_limit' depart-id='"+data.data[i].id+"' type='button' value='保存' style='width:36px;margin-left:15px;' />";
 						html+="   </p>";
 						}
 						html+="</div>";
                    }
                	$(".data_list").html(html);

                	layer.open({
                	        type: 1,
                	        title: false,
                	        closeBtn: 0,
                	        area: ['760px', '540px'],
                	        shadeClose: false,
                	        content: $('#set_limit_div')
                	});
                	 
                 }else{

                 }
                
            },
            error:function(data){
                tan('请求异常');
            }
            
       });		
});
//  保存额度修改
$("body").on("click",".btn_save_limit",function(){
	   var depart_id=$(this).attr("depart-id");
	   var cash_limit=$(this).parent().find('.ipt_cash').val();
	   var credit_limit=$(this).parent().find('.ipt_credit').val();
	   var that=$(this);
        $.ajax({
            url:"<?php echo base_url('admin/b2/pre_order/api_save_limit');?>",
            data:{depart_id:depart_id,cash_limit:cash_limit,credit_limit:credit_limit},
            type:"post",
            async:false,
            dataType:"json",
            success:function(data){
                if(data.code==2000){

                	tan_alert_noreload('修改成功');
                	ajax_depart_limit(data.depart_id);
                	 
                 }else{
                	 tan_alert_noreload(data.msg);
                	 ajax_depart_limit(data.depart_id);
                 }
                
            },
            error:function(data){
                tan('请求异常');
            }
            
       });		
});

$("body").on("mouseover ",".second",function(){
	  $(this).css({background:'#ccc'});
	  $(this).find("p").css("display","block");
	  $(this).siblings().find("p").css("display","none");
}).on("mouseout ",".second",function(){
	  $(this).css({background:'#fff'});
	  $(this).find("p").css("display","none");
});

		
</script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>
</body>
</html>
