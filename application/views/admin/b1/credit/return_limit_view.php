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
.search_input { width:100px;}
</style>
<link href="/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<!--=================右侧内容区================= -->
     <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">额度还款查询</a>
        </div>

        <div class="page_content bg_gray">
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                        <li data-val="0"><a href="#" class="active" id="tab0">额度还款查询</a></li>
                    </ul>
                </div>
                <div class="tab_content" style="padding-top:5px;">
                  <form class="search_form" method="post" id="search-condition" action="">
                      <div class="search_form_box clear">
                             <div class="search_group">
                                      <label>申请编号:</label>
                                    <input type="text" id="sch_sn" name="sch_sn" class="search_input">
                            </div>

                            <div class="search_group search-time">
                              <label>申请时间:</label>
                                <input type="text" name="starttime" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" class="search_input" id="endtime" placeholder="结束时间"/>
                            </div>
                             <div class="search_group">
                                      <label>申请人:</label>
                                    <input type="text" id="sch_expertName" name="sch_expertName" class="search_input">
                            </div>
                            <div class="search_group search-time">
                                  <label>还款日期:</label>
                                  <input type="text" name="return_starttime" class="search_input" id="return_starttime" placeholder="开始时间"/>
                                  <input type="text" name="return_endtime" class="search_input" id="return_endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                                    <label>订单编号:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>
                             <div class="search_group show_select ul_kind ">
                                      <label>还款状态:</label>
                                      <select name="apply_status"  style="height: 23px;">
                                        <option value="0">请选择</option>
                                        <option value="1">未还款</option>
                                   <!--<option value="1">超时未还款</option>-->
                                        <option value="2">已还款</option>
                                      </select>
                            </div>
                             <!--还款查询-->
                            <div class="search_group search-time">
                                <label>只显示超时未还款</label>
                                 <input type="checkbox" id="checkdata" name="checkdata" style="margin-top: 4px;opacity:1;position: static;">
                            </div>
                            <div class="search_group">
                              <input type="button" name="submit" class="search_button" id="searchBtn0" value="搜索"/>
                            </div>

                      </div>
                    </form>
                    <div class="table_list" id="list"></div>
                </div>
            </div>
        </div>
    </div>
    <!--信用额度审核-->
    <div class="fb-content" id="limit_approve" style="display:none;">
    <div class="box-title">
        <h4>额度审批</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
    <div class="status_box">
          <ul class="clear">
                <li class="on" id="a_li"><span class="time" id="s_addtime"></span><i></i><span class="txt">新增申请</span></li>
                <li class="" id="m_li"><span class="time" id="s_maddtime" ></span><i></i><span class="txt">经理审批</span></li>
                <li class="" id="s_li"><span class="time" ></span><i></i><span class="txt">旅行社/供应商授权</span></li>
                <li id="reutrn_li" ><span class="time"></span><i></i><span class="txt">已还款</span></li>
            </ul>
        </div>
        <form method="post" action="#" id="" class="form-horizontal">
            <div class="form_con limit_apply">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">

                    <tr height="40">
                        <td class="order_info_title">编号:</td>
                        <td colspan="3" class="apply_sn" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请金额:</td>
                        <td colspan=""><span style="color:red;" class="apply_money"  ></span></td>
                        <td class="order_info_title"  >使用金额:</td>
                        <td class="apply_real_amount" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title" >申请日期:</td>
                        <td class="apply_addtime"  ></td>
                        <td class="order_info_title"  >还款日期:</td>
                        <td class="apply_endtime" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人:</td>
                        <td class="apply_people" ></td>
                        <td class="order_info_title">营业部:</td>
                        <td class="apply_departName" ></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明:</td>
                        <td colspan="3"  class="apply_remark" ></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">经理审核:</td>
                        <td colspan="" class="apply_manager_name"></td>
                        <td class="order_info_title">审核时间:</td>
                        <td colspan="" class="apply_m_addtime"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核意见:</td>
                        <td colspan="3" class="apply_m_remark">sdfdsf</td>
                    </tr>
                      <tr height="40">
                        <td class="order_info_title">供应商审核:</td>
                        <td colspan="" class="apply_supplier"></td>
                        <td class="order_info_title">审核时间:</td>
                        <td colspan="" class="apply_modtime"></td>
                    </tr>
                   <tr height="40">
                        <td class="order_info_title">审核意见:</td>
                        <td colspan="3" class="s_reply"></td>
                    </tr>
                </table>
            </div>
            <div class="form_btn clear">
                <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" style="margin-left:350px;position: relative;" >
            </div>
        </form>
    </div>
</div>

<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<!--模糊查询-->
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<?php echo $this->load->view('admin/b1/common/user_message_script'); ?>

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
  page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/credit/return_limit/indexData",form : '#search-condition',// 绑定一个查询表单的ID
        columns : [

            {field : 'id',title : '申请编号',width : '60',align : 'center'},
            {field : 'realname',title : '申请人',width : '70',align : 'center',
                formatter : function(value,rowData, rowIndex){
                      return '<a href="##" onclick="show_user('+rowData.expert_id+',1)">'+rowData.realname+'</a>';
                },
           },
            {field : 'credit_limit',title : '申请金额',align : 'right',sortable : true,width : '80',
                    formatter : function(value,rowData, rowIndex){

                                      return '<a href="##" onclick="through_credit('+rowData.id+')" >'+rowData.credit_limit+'</a>';

                     }
            },
           {field : 'real_amount',title : '使用金额',align : 'right', width : '80',
                formatter : function(value,rowData, rowIndex){
                           return '<a href="#"  onclick="through_credit('+rowData.id+')" >'+value+'</a>';
                }
          },
          {field : 'return_amount',title : '已还款金额',align : 'right', width : '80',
                formatter : function(value,rowData, rowIndex){
                       if(rowData.return_amount==''){
                                rowData.return_amount='0.00';
                       }
                     return '<a href="#" onclick="through_credit('+rowData.id+')" >'+rowData.return_amount+'</a>';
                }
          },
            {field : 'addtime',title : '申请日期',align : 'center', width : '110'},
            {field : 'return_time',title : '还款日期',align : 'center', width : '90'},
            {field : 'remark',title : '申请说明',align : 'center', width : '100'},
            {field : 'ordersn',title : '订单编号',width : '100',align : 'center',
                     formatter : function(value,rowData, rowIndex){
                                if(rowData.ordersn==0){
                                      return '';
                                }else{
                                      return rowData.ordersn;
                                }
                     }
            },
            {field : 'depart_name',title : '营业部名称',width : '100',align : 'center'},
            {field : 'manager_name',title : '经理名称',align : 'center', width : '100'},
            {field : 'm_addtime',title : '经理审核时间',align : 'center', width : '100',
                      formatter : function(value,rowData, rowIndex){
                                if(rowData.m_addtime=='1000-01-01 00:00:00'){
                                        return '';
                                }else{
                                        return rowData.m_addtime;
                                }
                     }
            },
            {field : 's_realname',title : '供应商审核人',align : 'center', width : '100'},
            {field : '',title : '审核状态',align : 'center',width : '80',
                    formatter : function(value,rowData, rowIndex){
                          if(rowData.status==0){
                                return '未提交';
                           }else if(rowData.status==1){
                                return '经理通过';
                           }else if(rowData.status==2){
                                return '经理拒绝';
                           }else if(rowData.status==3){
                                return '已授信';
                           }else if(rowData.status==4){
                                return '已还款';
                           }else if(rowData.status==5){
                                return '已拒绝';
                           }
                   }
            }
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


//通过申请
function through_credit(id){
      layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '800px',
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: false,
            content: $('#limit_approve')
      });
      $('#limit_approve').find('input[name="apply_id"]').val('');
      jQuery.ajax({ type : "POST",data :"apply_id="+id,url : "<?php echo base_url()?>admin/b1/credit/credit_limit/get_credit_row",
              success : function(data) {
                    data = eval('('+data+')');
                      if(data.credit.m_addtime=="1000-01-01 00:00:00"){
                            data.credit.m_addtime='';
                    }
                    $('#limit_approve').find('.apply_money').html(data.credit.credit_limit);
                    $('#limit_approve').find('input[name="apply_id"]').val(data.credit.id);
                    $('#limit_approve').find('.apply_sn').html(data.credit.id);
                    $('#limit_approve').find('.apply_addtime').html(data.credit.addtime);
                    $('#limit_approve').find('.apply_endtime').html(data.credit.return_time);
                    $('#limit_approve').find('.apply_real_amount').html(data.credit.real_amount);
                    $('#limit_approve').find('.apply_people').html(data.credit.expert_name);
                    $('#limit_approve').find('.apply_departName').html(data.credit.depart_name);
                     $('#limit_approve').find('.apply_remark').html(data.credit.remark);
                    $('#limit_approve').find('#s_addtime').html(data.credit.addtime);
                    $('#limit_approve').find('.apply_manager_name').html(data.credit.manager_name);
                     $('#limit_approve').find('.apply_m_addtime').html(data.credit.m_addtime);
                    $('#limit_approve').find('.apply_m_remark').html(data.credit.m_remark);
                    $('#limit_approve').find('.apply_supplier').html(data.credit.realname);
                     $('#limit_approve').find('.apply_modtime').html(data.credit.modtime);
                    $('#limit_approve').find('.s_reply').html(data.credit.reply);
                     if(data.credit.status==1){
                          $('#m_li').addClass("on");
                          $('#m_li').find('.time').html(data.credit.m_addtime);
                    }
                    if(data.credit.status==3){
                          $('#m_li').addClass("on");
                          $('#m_li').find('.time').html(data.credit.m_addtime);
                          $('#s_li').addClass("on");
                          $('#s_li').find('.time').html(data.credit.modtime);
                    }
                    if(data.credit.status==4){  //已还款
                              $('#m_li').addClass("on");
                              $('#m_li').find('.time').html(data.credit.m_addtime);
                              $('#s_li').addClass("on");
                              $('#s_li').find('.time').html(data.credit.modtime);
                              $('#reutrn_li').addClass("on");
                              $('#reutrn_li').find('.time').html(data.credit.return_time);
                    }

                 //   jQuery('#tab0').click();
             }
      })
}

 $.post('/admin/b1/credit/credit_limit/get_expertDpart_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.realname,
        value : val.id,
        jb : val.realname,
        qp : val.realname
    });
  })
  var comboBox = new jQuery.comboBox({
       id : "#sch_expertName",
       name : "expert_id",// 隐藏的value ID字段
       query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
       blurAfter : function(item, index) {// 选择后的事件
        if(jQuery('#sch_expertName').val()==''){
          //   jQuery('#sch_expertName').val('');
            //jQuery('#sch_union_name').val('');
        }
       },
       data : array
  });
})
</script>
</html>