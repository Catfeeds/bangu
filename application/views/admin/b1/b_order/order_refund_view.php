<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
 <link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />

<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<!-- <script type="text/javascript" src="/assets/ht/js/base.js"></script> -->
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
<script type="text/javascript" src="/assets/ht/js/laypage.js"></script> 

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}

</style>
<link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<!--=================右侧内容区================= -->
     <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">额度审批</a>
        </div>
        
        <div class="page_content bg_gray search_box">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                          <li data-val="0"><a href="#" class="active" id="tab0">待确认退团</a></li> 
                          <li data-val="0"><a href="#" class="" id="tab1">已通过</a></li> 
                          <li data-val="0"><a href="#" class="" id="tab2">已拒绝</a></li> 
                    </ul>
                </div>
                <!--待确认-->
                <div class="tab_content"  style="padding-top:5px;">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear">
                             <div class="search_group">
                                      <label>线路编号:</label>
                                    <input type="text" id="sch_sn" name="linecode" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>线路名称:</label>
                                    <input type="text" id="sch_expertName" name="linename" class="search_input">
                            </div>
                            <div class="search_group search-time">
                              <label>订单编号:</label>
                                    <input type="text" id="sch_expertName" name="ordersn" class="search_input">
                            </div>
                            <div class="search_group search-time">
                              <label>出团日期</label>
                                <input type="text" id="sch_expertName" name="sch_expertName" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>团队编号:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>管家:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>目的地:</label>
                            <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>出发地:</label>
                            <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                              <input type="button" name="submit" class="search_button" id="searchBtn0" value="搜索"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list"></div> 
                </div>
                <!--已通过-->
                <div class="tab_content1" style="padding-top:5px;display:none">
                  <form class="searchForm1" method="post" id="search-condition" action="">
                       <div class="search_form_box clear">
                             <div class="search_group">
                                      <label>线路编号:</label>
                                    <input type="text" id="sch_sn" name="linecode" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>线路名称:</label>
                                    <input type="text" id="sch_expertName" name="linename" class="search_input">
                            </div>
                            <div class="search_group search-time">
                              <label>订单编号:</label>
                                    <input type="text" id="sch_expertName" name="ordersn" class="search_input">
                            </div>
                            <div class="search_group search-time">
                              <label>出团日期</label>
                                <input type="text" id="sch_expertName" name="sch_expertName" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>团队编号:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>管家:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>目的地:</label>
                            <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>出发地:</label>
                            <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                              <input type="button" name="submit" class="search_button" id="searchBtn1" value="搜索"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list1"></div> 
                </div>
                <!--已拒绝-->
                <div class="tab_content2" style="padding-top:5px;display:none">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear">
                             <div class="search_group">
                                      <label>线路编号:</label>
                                    <input type="text" id="sch_sn" name="linecode" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>线路名称:</label>
                                    <input type="text" id="sch_expertName" name="linename" class="search_input">
                            </div>
                            <div class="search_group search-time">
                              <label>订单编号:</label>
                                    <input type="text" id="sch_expertName" name="ordersn" class="search_input">
                            </div>
                            <div class="search_group search-time">
                              <label>出团日期</label>
                                <input type="text" id="sch_expertName" name="sch_expertName" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>团队编号:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>管家:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>目的地:</label>
                            <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                                      <label>出发地:</label>
                            <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                            <div class="search_group">
                              <input type="button" name="submit" class="search_button" id="searchBtn2" value="搜索"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list2"></div> 
                </div>

            </div> 
        </div>
    </div>
<!--退团操作-->
    <div class="fb-content" id="b_tuituan_order" style="display:none;" >
    <div class="box-title">
        <h4 class="title_tuituan_order">退款退团确认</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                      <tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td class="t_linename" colspan="3"></td>
                      </tr>
                       <tr height="40">
                        <td class="order_info_title">出团日期:</td>
                        <td class="t_usedata"></td>
                        <td class="order_info_title">退订人数:</td>
                        <td class="t_refund_member" ></td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title">成本价:</td>
                        <td class="t_supplier_cost"></td>
                        <td class="order_info_title">平台管理费:</td>
                        <td class="t_platform_fee" ></td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title">代收金额:</td>
                        <td class="" ></td>
                        <td class="order_info_title">授信额度:</td>
                        <td  class="t_credit_limit"> </td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td class="t_up_money"></td>
                        <td class="order_info_title">已结算:</td>
                        <td class="t_balance_money" ></td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title"> 未结算金额:</td>
                        <td class="t_p_amount">  </td>
                        <td class="order_info_title">退款金额:</td>
                        <td class="t_amount">   </td>
                      </tr>
                      <tr height="40" class="fow_account_pic">
                        <td class="order_info_title">上传流水单:</td>
                        <td  colspan="3">
                                <input type="file" id="upfile" name="upfile"  />
                                <input type="button"  id="updatafile" value="上传" style="padding: 3px;margin-left:15px" /> 
                                <input type="hidden" id="attachment" name="attachment"  />
                                <img style="width:45px;margin-left:80px;" class="fow_account" src="#">
                         </td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title">退已结算金额:</td>
                        <td class="" colspan="3"> <input type="text" name="t_meney"  style="height:30px;width:80px" />
                        <span style="color:red" >退已结算金额和未结算金额和平台管理费之和不能小于订单退款金额.</span>
                        </td>
                      </tr>
                      <tr height="40"  >
                        <td class="order_info_title">备注:</td>
                        <td class="total_price" colspan="3"><input type="text" name="t_remark"   class="w_500" style="height:30px" />  </td>
                      </tr>
                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="hidden" id="t_bill_id" name="t_bill_id">
                  <!--提交给旅行社审核-->
                  <input type="button" name="" value="确认" class="btn btn_blue" id="q_tuituan" style="margin-left:210px;"  onclick="q_tuituan_order()" >
                  <input type="button" value="拒绝" class="btn btn_blue" id="r_tuituan" style="margin-left:210px;display: none;" onclick="r_tuituan_order()" >

                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>
<!--确认退团-->
    <div class="fb-content" id="tuituan_order_data" style="display:none;" >
    <div class="box-title">
        <h4 class="h_order_data">退款退团确认</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                    <tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td class="q_linename" colspan="3"></td>
                     </tr>
                     <tr height="40">
                        <td class="order_info_title">出团日期:</td>
                        <td class="q_usedata"></td>
                        <td class="order_info_title">退订人数:</td>
                        <td class="q_refund_member" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">成本价:</td>
                        <td class="q_supplier_cost"></td>
                        <td class="order_info_title">平台管理费:</td>
                        <td class="q_platform_fee" ></td>
                      </tr>
                       <tr height="40">
                        <td class="order_info_title">代收金额:</td>
                        <td class="" ></td>
                        <td class="order_info_title">授信额度:</td>
                        <td  class="q_credit_limit"> </td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td class="q_up_money"></td>
                        <td class="order_info_title">已结算总额:</td>
                        <td class="q_balance_money" ></td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title"> 未结算金额:</td>
                        <td class="q_p_amount">  </td>
                         <td class="order_info_title">退款金额:</td>
                        <td class="q_amount">  </td>
                      </tr>
                      <tr height="40" class="balance_bill_tr">
                        <td class="order_info_title">退已结算金额:</td>
                        <td colspan="3" class="q_meney"> <!-- <input type="text" name="q_meney" disabled  style="height:30px;width:80px" /> -->
                        </td>
                      </tr>
                     <tr height="40" class="bill_remark_tr">
                        <td class="order_info_title">审核意见:</td>
                        <td class="" colspan="3"> <input type="text" name="bill_remark"   style="height:30px;width:500px" />
                        </td>
                      </tr>
                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="hidden" id="p_bill_id" name="p_bill_id">
                  <!--提交给旅行社审核-->
                  <input type="button" name="" value="确认" class="btn btn_blue" id="pass_order_btn" style="margin-left:210px;"  onclick="pass_order()" >

                  <input type="button" value="拒绝" class="btn btn_blue" id="ref_order_btn" style="margin-left:210px;display:none"  onclick="ref_order()" >

                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>
<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
<!---->
<!--  <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script> -->

<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>

<?php echo $this->load->view('admin/b1/common/user_message_script'); ?>

<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<!--线路详情-->
<?php echo $this->load->view('admin/b1/common/line_detail_script'); ?>
<script>
//-------------------------------------------数据列表--------------------------------------------------------
jQuery(document).ready(function(){
  var page=null;
  // 查询
  jQuery("#searchBtn0").click(function(){
      page.load({"status":"1"});
  });
  var data = '<?php echo $pageData; ?>';
  page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/b_order/order_refund/indexData",form : '#search-condition',// 绑定一个查询表单的ID
        columns : [
          {field : 'ordersn',title : '订单编号',width : '60',align : 'center'},
          {field : 'linesn',title : '团队编号',width : '80',align : 'center'},
          {field : 'linecode',title : '线路编号',width : '80',align : 'center'},
          {field : 'linename',title : '线路名称',align : 'center',sortable : true,width : '150',
               formatter : function(value,rowData, rowIndex){
                  return '<a href="javascript:void(0)" class="line_detail" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
              }
          },
          {field : 'num',title : '参团人数',align : 'center', width : '60' },
          {field : 'usedate',title : '出团日期',align : 'center', width : '100'  },
          {field : 'lineday',title : '行程天数',align : 'center', width : '80'},
          {field : 'receive_price',title : '已交款',align : 'center', width : '80'},
          {field : 'credit_limit',title : '额度申请',align : 'center', width : '80'},
          {field : 'supplier_cost',title : '成本价',width : '80',align : 'center'},
          {field : 'platform_fee',title : '平台佣金',width : '80',align : 'center'}, 
          {field : 'balance_cost',title : '结算价',width : '80',align : 'center'},
          {field : 'un_money',title : '未结算',width : '80',align : 'center'},
          {field : 'amount',title : '供应商退款',align : 'center', width : '80'},
          {field : 'realname',title : '销售员',align : 'center', width : '100'},
          {field : '',title : '操作',align : 'center',width : '100',
                formatter : function(value,rowData, rowIndex){
                     if((-rowData.amount)>rowData.s_money){  //退团金额大于未结算,退已结算金额
                          if(rowData.re_status=='0'){
                                var str='待确认退款 '; 
                          }else if (rowData.re_status=='1'){
                              var str='<a href="##"  data="'+rowData.order_id+'" onclick="pass_tuituan_order('+rowData.bill_id+','+rowData.kind+')" >通过</a>'; 
                              str=str+'<a  href="##" data="'+rowData.order_id+'" onclick="pass_tuituan_order('+rowData.bill_id+','+(-rowData.kind)+')"  >拒绝</a>';
                          }else if(rowData.re_status=='2'){
                               var str='<a href="##" data="'+rowData.order_id+'" onclick="q_tuituan('+rowData.bill_id+','+rowData.kind+')" >退款退团</a>'; 
                                str=str+'<a  href="##" data="'+rowData.order_id+'" onclick="pass_tuituan_order('+rowData.bill_id+','+(-rowData.kind)+')"  >拒绝</a>';
                          }else{
                                var str='<a href="##" data="'+rowData.order_id+'" onclick="q_tuituan('+rowData.bill_id+','+rowData.kind+')" >退款退团</a>'; 
                                str=str+'<a  href="##" data="'+rowData.order_id+'" onclick="pass_tuituan_order('+rowData.bill_id+','+(-rowData.kind)+')"  >拒绝</a>';
                          }
                     }else{    
                            var str='<a href="##" data="'+rowData.order_id+'"  onclick="pass_tuituan_order('+rowData.bill_id+','+rowData.kind+')" >通过</a>';
                            str=str+'<a  href="##" data="'+rowData.order_id+'"  onclick="pass_tuituan_order('+rowData.bill_id+','+(-rowData.kind)+')"  >拒绝</a>';
                     } 
                     return str;     
                }
           }
        ]
  });
      jQuery('#tab0').click(function(){
            jQuery('.tab_content').css('display','block');
            jQuery('.tab_content2').css('display','none');
            jQuery('.tab_content1').css('display','none');
            jQuery('#tab2').removeClass('active');
            jQuery('#tab1').removeClass('active');
            jQuery('#tab0').addClass('active');
            page.load({"status":"1"}); 
      }); 
});
//---------------------已通过------------------
 var page1=null;
  function initTab1(){
  // 查询
  jQuery("#searchBtn1").click(function(){
      page1.load({"status":"2"});
  });
// var data = '<?php echo $pageData; ?>'; 
  page1=new jQuery.paging({renderTo:'#list1',url : "<?php echo base_url()?>admin/b1/b_order/order_refund/indexData",form : '#searchForm1',// 绑定一个查询表单的ID
        columns : [
          {field : 'ordersn',title : '订单编号',width : '60',align : 'center'},
          {field : 'linesn',title : '团队编号',width : '80',align : 'center'},
          {field : 'linecode',title : '线路编号',width : '80',align : 'center'},
          {field : 'linename',title : '线路名称',align : 'center',sortable : true,width : '150',
               formatter : function(value,rowData, rowIndex){

                  return '<a href="javascript:void(0)" class="line_detail" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
              }
          },
          {field : 'num',title : '参团人数',align : 'center', width : '60' },
          {field : 'usedate',title : '出团日期',align : 'center', width : '100'  },
          {field : 'lineday',title : '行程天数',align : 'center', width : '80'},
          {field : 'receive_price',title : '已交款',align : 'center', width : '80'},
          {field : 'credit_limit',title : '额度申请',align : 'center', width : '80'},
          {field : 'supplier_cost',title : '成本价',width : '80',align : 'center'},
          {field : 'platform_fee',title : '平台佣金',width : '80',align : 'center'}, 
          {field : 'balance_cost',title : '结算价',width : '80',align : 'center'},
          {field : 'un_money',title : '未结算',width : '80',align : 'center'},
          {field : 'amount',title : '供应商退款',align : 'center', width : '80'},
           {field : 'refund_money',title : '退结算金额',align : 'center', width : '80'},
          {field : 'realname',title : '销售员',align : 'center', width : '100'}
/*          {field : '',title : '操作',align : 'center',width : '100',
                    formatter : function(value,rowData, rowIndex){
                          if(rowData.status==1){
                                if(rowData.is_orderid>0){
                                     var str='';
                                     str=str+'<a href="#" onclick="through_credit('+rowData.id+',3)">通过</a>&nbsp;&nbsp;&nbsp;';
                                     str=str+'<a href="#" onclick="through_credit('+rowData.id+',-3)">拒绝<a>';
                                     return str;
                                }else{
                                    var str='';
                                    str=str+'<a href="#" onclick="through_credit('+rowData.id+',1)">通过</a>&nbsp;&nbsp;&nbsp;';
                                    str=str+'<a href="#" onclick="through_credit('+rowData.id+',-1)">拒绝<a>';
                                    return str;
                                }
                          }else{
                                   return '';
                          }
                    }
           }*/
        ]
    });
  }
  
  jQuery('#tab1').click(function(){ 
          jQuery('.tab_content').css('display','none');
          jQuery('.tab_content2').css('display','none');
          jQuery('.tab_content1').css('display','block');
           jQuery('#tab2').removeClass('active');
          jQuery('#tab1').addClass('active');
           jQuery('#tab0').removeClass('active');
          jQuery(this).parent().addClass('active');
          if(null==page1){
                 initTab1();
          }
          page1.load({"status":"2"});
  });
//--------------------已拒绝--------------------
 var page2=null;
  function initTab2(){
  // 查询
  jQuery("#searchBtn2").click(function(){
      page2.load({"status":"4"});
  });
// var data = '<?php echo $pageData; ?>'; 
  page2=new jQuery.paging({renderTo:'#list2',url : "<?php echo base_url()?>admin/b1/b_order/order_refund/indexData",form : '#searchForm1',// 绑定一个查询表单的ID
        columns : [
          {field : 'ordersn',title : '订单编号',width : '60',align : 'center'},
          {field : 'linesn',title : '团队编号',width : '80',align : 'center'},
          {field : 'linecode',title : '线路编号',width : '80',align : 'center'},
          {field : 'linename',title : '线路名称',align : 'center',sortable : true,width : '150',
              formatter : function(value,rowData, rowIndex){

                  return '<a href="javascript:void(0)" class="line_detail" data="'+rowData.lid+'" >'+rowData.linename+'</a>';
              }
          },
          {field : 'num',title : '参团人数',align : 'center', width : '60' },
          {field : 'usedate',title : '出团日期',align : 'center', width : '100'  },
          {field : 'lineday',title : '行程天数',align : 'center', width : '80'},
          {field : 'receive_price',title : '已交款',align : 'center', width : '80'},
          {field : 'credit_limit',title : '额度申请',align : 'center', width : '80'},
          {field : 'supplier_cost',title : '成本价',width : '80',align : 'center'},
          {field : 'platform_fee',title : '平台佣金',width : '80',align : 'center'}, 
          {field : 'balance_cost',title : '结算价',width : '80',align : 'center'},
          {field : 'un_money',title : '未结算',width : '80',align : 'center'},
          {field : 'amount',title : '供应商退款',align : 'center', width : '80'},
          {field : 'realname',title : '销售员',align : 'center', width : '100'}
        ]
    });
  }
  
  jQuery('#tab2').click(function(){ 
          jQuery('.tab_content').css('display','none');
          jQuery('.tab_content2').css('display','block');
          jQuery('.tab_content1').css('display','none');
          jQuery('#tab2').addClass('active');
          jQuery('#tab1').removeClass('active');
           jQuery('#tab0').removeClass('active');
          jQuery(this).parent().addClass('active');
          if(null==page2){
                initTab2();
          }
          page2.load({"status":"4 "});
  });

//----------------------------------------数据列表end--------------------------------------------------------------------

//--------------------------退团-----------------------------
//供应商退款申请表退款
function q_tuituan(bill_id,type){
           $('input[name="t_bill_id"]').val(bill_id);
           $('input[name="t_remark"]').val('');
           $('input[name="attachment"]').val('');
           $('input[name="t_meney"]').val(''); 
            $('.fow_account').attr('src',''); 
            if(type==2){
                     $('.title_tuituan_order').html('订单退团');
                     $('.t_amount').prev().html('退款金额');
            }else{
                     $('.title_tuituan_order').html('成本价修改');
                     $('.t_amount').prev().html('结算价修改');
            }

           var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';
           $.post( "<?php echo site_url('admin/b1/order/get_tuituan_data')?>", {'orderid':orderid,'bill_id':bill_id}, function(data) {
                      data = eval('('+data+')');
                      $('.t_up_money').html(data.up_money); 
                      $('.t_supplier_cost').html(data.supplier_cost);  
                      $('.t_platform_fee').html(data.platform_fee);  
                      $('.t_balance_money').html(data.balance_money);
                      $('.t_credit_limit').html(data.credit_limit);  
                      $('.t_amount').html(data.amount);  
                      $('.t_p_amount').html(data.p_amount);  
                      $('.t_linename').html(data.linename);   
                      $('.t_usedata').html(data.usedate);  
                  //    $('.t_ordernum').html(data.ordernum);  
                      $('.t_refund_member').html(data.member);  
           });
           layer.open({
                  type: 1,
                  title: false,
                  closeBtn: 0,
                  area: '700px',
                  shadeClose: false,
                  content: $('#b_tuituan_order')
           });
}
//供应商退款申请表
function q_tuituan_order(){
            var bill_id=$('input[name="t_bill_id"]').val(); //账单id
            var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>'; //订单id
            var t_remark= $('input[name="t_remark"]').val();
            var core_pic=$('input[name="attachment"]').val(); 
            var t_meney=$('input[name="t_meney"]').val(); 
            if(isNaN(t_meney)){
                    alert('填写格式不对');
                    $('input[name="t_meney"]').val('');
                    $('input[name="t_meney"]').focus();
                    return false;
           }
            $.post( "<?php echo site_url('admin/b1/order/save_tuituan_data')?>", {
                'orderid':orderid,
                'bill_id':bill_id,
                't_remark':t_remark,
                'core_pic':core_pic,
                't_meney':t_meney
            },
            function(data) {
                      data = eval('('+data+')');
                      if(data.status==1){
                            alert(data.msg);
                            //window.location.reload();
                            $('.layui-layer-close').click();
                            $('#tab0').click();
                      }else{
                            alert(data.msg);
                     }             
           });
}
//确认退团弹框
function pass_tuituan_order(bill_id,type){
           $('input[name="p_bill_id"]').val(bill_id);
           var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';
        
          $.post( "<?php echo site_url('admin/b1/order/get_tuituan_data')?>", {'orderid':orderid,'bill_id':bill_id}, function(data) {
                  data = eval('('+data+')');
                  $('.q_up_money').html(data.up_money);  
                  $('.q_supplier_cost').html(data.supplier_cost);
                  $('.q_platform_fee').html(data.platform_fee);
                  $('.q_balance_money').html(data.balance_money);
                  $('.q_credit_limit').html(data.credit_limit);  
                  $('.q_amount').html(data.amount);  
                  $('.q_p_amount').html(data.p_amount);  
                 // $('input[name="q_meney"]').val(data.s_refund_money);
                  $('.q_meney').html(data.s_refund_money);
                  $('.q_linename').html(data.linename);   
                  $('.q_usedata').html(data.usedate);  
                  //    $('.t_ordernum').html(data.ordernum);  
                  $('.q_refund_member').html(data.member);  
          }); 

          if(type==1){ //订单成本价修改
                $('.balance_bill_tr').show();
                $('.bill_remark_tr').hide();
                $('#pass_order_btn').show(); //确认按钮
                $('#ref_order_btn').hide(); //拒绝按钮
                $('.h_order_data').html('成本价修改');
                 $('.q_amount').prev().html('结算价修改');
          }else if(type==2){ //退团
                $('.balance_bill_tr').show();
                $('.bill_remark_tr').hide();
                $('#pass_order_btn').show(); //确认按钮
                $('#ref_order_btn').hide(); //拒绝按钮
                $('.h_order_data').html('订单退团');
                  $('.q_amount').prev().html('退款金额');
          }else if(type==-1){ //拒绝退团
                $('.balance_bill_tr').hide(); //退款金额
                $('.bill_remark_tr').show(); //退单理由
                $('#pass_order_btn').hide(); //确认按钮
                $('#ref_order_btn').show(); //拒绝按钮
                $('input[name="bill_remark"]').val('');
                $('.h_order_data').html('成本价修改');
                $('.q_amount').prev().html('结算价修改');
             //   alert(123);
          }else if(type==-2){  //拒绝成本价修改
                $('.balance_bill_tr').hide(); //退款金额
                $('.bill_remark_tr').show(); //退单理由
                $('#pass_order_btn').hide(); //确认按钮
                $('#ref_order_btn').show(); //拒绝按钮
                $('input[name="bill_remark"]').val('');
                $('.h_order_data').html('订单退团');
                $('.q_amount').prev().html('退款金额');
          }

          layer.open({
                  type: 1,
                  title: false,
                  closeBtn: 0,
                  area: '700px',
                  shadeClose: false,
                  content: $('#tuituan_order_data')
           });

}
//确认订单退团
function pass_order(){
          var bill_id  =$('input[name="p_bill_id"]').val();
          var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';
          $.post( "<?php echo site_url('admin/b1/order/save_tuituan_order')?>", {
                'orderid':orderid,
                'bill_id':bill_id,
          },
          function(data) {
                     data = eval('('+data+')');
                     if(data.status==1){
                            alert(data.msg);
                         //   window.location.reload();
                         $('.layui-layer-close').click();
                           $('#tab0').click();

                      }else{
                            alert(data.msg);
                      }             
          });
}
//拒绝订单退团
function ref_order(){
            var supplier_remark= $('input[name="bill_remark"]').val();
            var id=$('input[name="p_bill_id"]').val();
            var order_id="<?php if(!empty($order_id)){ echo $order_id;}else{ echo 0 ;}?>";

           $.post("<?php echo site_url('admin/b1/order/refuse_oderprice')?>",
                {'order_id':order_id,'id':id,'supplier_remark':supplier_remark},
                function(result) {
                           var result =eval("("+result+")"); 
                            if(result.status==1){
                                     alert(result.msg);
                                   //  window.location.reload();
                                   $('.layui-layer-close').click();
                                    $('#tab0').click();
                            }else{
                                    alert(result.msg);
                            }
            });
}

//上传流水单
$('#updatafile').on('click', function() {
            $.ajaxFileUpload({url:'/admin/b1/product/up_img',
            secureuri:false,
            fileElementId:'upfile',// file标签的id
            dataType: 'json',// 返回数据的类型
            data:{filename:'upfile'},
            success: function (data, status) {
                     if (data.code == 200) {
                          $('input[name="attachment"]').val(data.msg);
                          $('.fow_account').attr('src',data.msg);
                          alert("上传成功");
                     } else {
                          alert(data.msg);
                     }
            },
             error: function (data, status, e) {
                 alert("请选择不超过10M的doc,docx的文件上传");
            }
           });
        return false;
});




</script>
</html>