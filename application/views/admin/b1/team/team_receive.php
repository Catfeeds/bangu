<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>


<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<!-- <script type="text/javascript" src="/assets/ht/js/base.js"></script> -->
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
<script type="text/javascript" src="/assets/ht/js/laypage.js"></script> 

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.search_input { width:90px;}
.tab_content { padding-left:0;}
.page-content { }
</style>
<link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<!--=================右侧内容区================= -->
     <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">团队收款列表</a>
        </div>
        
        <div class="page_content bg_gray search_box">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="0"><a href="#" class="active" id="tab0">团队收款表</a></li> 
                    </ul>
                </div>
                <div class="tab_content" style="padding-top:5px;">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear" style="padding-right:0;">
                            <div class="search_group">
                                      <label>线路编号:</label>
                                    <input type="text" id="linencode" name="linencode" class="search_input" />
                            </div>
                             <div class="search_group">
                                      <label>线路名称:</label>
                                    <input type="text" id="linename" name="linename" class="search_input" />
                            </div>
                            <div class="search_group">
                                      <label>团号:</label>
                                    <input type="text" id="linensn" name="linensn" class="search_input" />
                            </div>
                            <div class="search_group input-group">
                                <label>出团日期</label>
                                <input class="search_input" type="text"  name="starttime" id="starttime" value="<?php echo date("Y-m-d",time())?>" style="width:90px;" />
                                <span class="fl">~</span>
                                <input class="search_input" type="text" name="endtime" id="endtime"  value="<?php  echo date("Y-m-d",strtotime("+30 day")); ?>" style="width:90px;"/>
                            </div>
                            <div class="search_group">
                                <label>行程天数</label>
                                <input type="text" name="s_lineday" class="search_input" style="width:30px;"/>
                                <span class="fl">~</span>
                                <input type="text" name="e_lineday" class="search_input" style="width:30px;"/>
                            </div>

                            <div class="search_group" style="margin-right:0;">
                              <input type="button" name="submit" class="search_button" id="searchBtn0" value="搜索"/>
                            </div>
                      </div>
                    </form>
                    <div class="table_list" id="list"></div>
                </div>
            </div> 
        </div>
    </div>
<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/ht/js/layer.js"></script> 
<!---->
 <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
//-------------------------------------------数据列表--------------------------------------------------------
jQuery(document).ready(function(){
  var page=null;
  // 查询
  jQuery("#searchBtn0").click(function(){
    page.load({"status":"0"});
    $('.all_account').html(0);   //结算总金额
  });
  var data = '<?php echo $pageData; ?>';
  page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/team/team_receive/indexData",form : '#search-condition',// 绑定一个查询表单的ID
        columns : [
          
          {field : 'id',title : '',width : '32',align : 'center',
                formatter : function(value,rowData, rowIndex){  
                     if(rowData.mom_num>0){
                            return '<span class="con_txt" onclick="show_order(this,1);"  style="font-size:17px"  data-id="'+rowData.dayid+'" data-suitid="'+rowData.suit_id+'" >+</span>';
                      }else{
                          return '';
                      } 
                     
                 },
          },
          {field : 'desp',title : '团号',width : '80',align : 'center',
                     formatter : function(value,rowData, rowIndex){  
                            if(rowData.line_kind==2 || rowData.line_kind==2){ 
                                    return rowData.linecode;
                            }else{
                                     return rowData.desp;
                            }
                     }
           },
          {field : 'linecode',title : '线路编号',width : '80',align : 'center' },
          {field : 'linename',title : '产品标题',align : 'center',sortable : true,width : '100',
              formatter : function(value,rowData, rowIndex){  
                    if(rowData.line_kind==1){
                             return '<a href="javascript:void(0)" onclick="show_line_detail('+rowData.lineid+',1)" data="'+rowData.lineid+'">'+rowData.linename+'</a>';
                     }else{
                             return rowData.linename;
                     }                
               },
          },
          {field : 'day',title : '出团日期',align : 'center', width : '80' },
          {field : 'number',title : '团队人数',align : 'center', width : '70'  },
          {field : 'addtime',title : '已订人数',align : 'center', width : '100',
                    formatter: function(value,rowData,rowIndex){
                            rowData.total_dingnum = rowData.total_dingnum=='' ? 0 :rowData.total_dingnum;
                            rowData.total_oldnum= rowData.total_oldnum=='' ? 0 : rowData.total_oldnum;
                            rowData.total_childnum= rowData.total_childnum=='' ? 0 : rowData.total_childnum;
                            rowData.total_childnobednum= rowData.total_childnobednum=='' ? 0 : rowData.total_childnobednum;
                           return rowData.total_dingnum+'+'+rowData.total_oldnum+'+'+rowData.total_childnum+'+'+rowData.total_childnobednum;
                    }
          },
          {field : 't_total_price',title : '应收总计',align : 'right', width : '80'},
          {field : 'pay_money',title : '已收款总额',align : 'right', width : '80'}, 
          {field : 't_supplier_cost',title : '结算价总计',width : '80',align : 'right'},
          {field : 'unfund_money',title : '未结算',width : '80',align : 'right'},
          {field : 't_balance_money',title : '已结算',align : 'right', width : '80'}
        ]
  });
  
      jQuery('#tab0').click(function(){
            jQuery('.tab-pane').removeClass('active');
            jQuery('li[name="tabs"]').removeClass('active');
            jQuery('#home0').addClass('active');
            jQuery(this).parent().addClass('active');
            page.load({"status":"0"});
            $('.all_account').html(0);   
      }); 
});
  

//----------------------------------------数据列表end--------------------------------------------------------------------
//收款列表
  function show_order(obj,type){
    $(obj).parent().parent().parent().after('');
      if(type==1){
           var dayid = $(obj).attr("data-id");
           var suitid = $(obj).attr("data-suitid");
           $.post("<?php echo base_url()?>admin/b1/team/team_receive/get_team_order", { dayid:dayid,suitid:suitid} , function(result) {
                  var result =eval("("+result+")"); 
                   if(result.status==1){ 
                          var html = '<tr class="order_table"><td colspan="12" style="padding:0;"><div style="padding:5px 5px 5px 30px;"><table class="table table-bordered" width="100%">';
                           html+='<thead class="th-border"><tr>';
                           html+='<th>订单编号</th>';
                           html+='<th>参团人数</th>';
                           html+='<th>出团日期</th>';
                           html+='<th>行程天数</th>';
                           html+='<th>下单时间</th>';
                           html+='<th>下单类型</th>';
                            html+='<th>销售员</th>';
                           html+='<th>订单状态</th>';
                           html+='<th>已收款</th>';
                           html+='<th>结算价</th>'; 
                           html+='<th>未结算</th>';
                           html+='<th>已结算</th>';
                           html+='</tr></thead><tbody>';
                           if(result.data!=''){
                                  $.each(result.data, function(key,val) { 
                                          if(val.user_type==1){
                                              var user_name="管家下单";
                                          }else{
                                             var user_name="用户下单";
                                          }     
                                          if(val.order_status==4){
                                              order_type="已确认";
                                          }else if(val.order_status==5){
                                              order_type="出团中";
                                          }else if(val.order_status==6){
                                              order_type="已点评";
                                          }else if(val.order_status==7){
                                              order_type="已投诉";
                                          }else if(val.order_status==8){
                                              order_type="行程结束";
                                          }else{
                                            order_type="";
                                          }    
                                          if(val.pay_money==null){
                                            val.pay_money='';
                                          }      
                                          html+='<tr>';
                                          html+='<td>'+val.ordersn+'</td>';
                                          html+='<td>'+val.order_member+'</td>';
                                          html+='<td>'+val.usedate+'</td>';
                                          html+='<td>'+val.lineday+'</td>';
                                          html+='<td>'+val.addtime+'</td>';
                                          html+='<td>'+user_name+'</td>';
                                          html+='<td>'+val.realname+'</td>';
                                          html+='<td>'+order_type+'</td>';
                                          html+='<td>'+val.pay_money+'</td>'; 
                                          html+='<td>'+val.t_supplier_cost+'</td>';     
                                          html+='<td>'+val.unfund_money+'</td>'; 
                                          html+='<td>'+val.t_balance_money+'</td>'; 
                                    
                                          html+='</tr>';
                                  });
                            }else{
                                 html+='<tr>';
                                 html+='<td colspan="12" style="letter-spacing:10px"><span style="font-weight: bold;color: red;">暂无订单数据</span></td>';
                                 html+='</tr>';
                            }
                        html+='</tbody></table></div></td></tr>';
                        $(obj).parent().parent().parent().after(html);
                        $(obj).html("-").attr("onclick","show_order(this,2);");

                   }else{

                   }  
           });  
    

      }else{
            $(obj).html("+").attr("onclick","show_order(this,1);");
            $(obj).parent().parent().parent().next().remove();
      }
     
  }

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
</html>