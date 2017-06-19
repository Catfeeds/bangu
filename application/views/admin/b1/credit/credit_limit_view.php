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
            <a href="#">额度审批</a>
        </div>

        <div class="page_content bg_gray search_box">
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav">
                        <li data-val="0"><a href="#" class="active" id="tab0">额度审批</a></li>
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
                              <label>还款时间:</label>
                                <input type="text" name="return_starttime" class="search_input" id="return_starttime" placeholder="开始时间"/>
                                <input type="text" name="return_endtime" class="search_input" id="return_endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                                      <label>订单编号:</label>
                                    <input type="text" id="sch_ordersn" name="sch_ordersn" class="search_input">
                            </div>


                             <div class="search_group show_select ul_kind ">
                                  <label>申请状态:</label>
                                  <select name="apply_status"  style="height: 23px;">
                                      <option value="-1">请选择</option>
                                    <!--<option value="0">申请中</option> -->
                                      <option value="1">申请中</option>
                                     <!--  <option value="2">经理拒绝</option> -->
                                      <option value="3">已授信</option>
                                      <option value="4">已还款</option>
                                       <option value="5">已拒绝</option>
                                    </select>
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
    <!--查看的信用额度审核-->
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
              <li class="on"  id="a_li" ><span class="time" id="s_addtime"></span><i></i><span class="txt">新增申请</span></li>
                <li class="" id="m_li" ><span class="time" id="s_maddtime" ></span><i></i><span class="txt">经理审批</span></li>
                <li class=""  id="s_li" ><span class="time" ></span><i></i><span class="txt">旅行社/供应商授权</span></li>
                <li id="reutrn_li" ><span class="time"></span><i></i><span class="txt">已还款</span></li>
            </ul>
        </div>
        <form method="post" action="#" id="addlimit-data" class="form-horizontal">
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
                    <tr height="40" class="t_apply">
                        <td class="order_info_title">供应商审核:</td>
                        <td colspan="" class="apply_supplier"></td>
                        <td class="order_info_title">审核时间:</td>
                        <td colspan="" class="apply_modtime"></td>
                    </tr>
         <!--             <tr height="40" id="apply_remark_t">
                  <td class="order_info_title"><i class="important_title">*</i>审核意见:</td>
                  <td colspan="3" class="s_reply" ><input type="text" name="apply_s_remark"   class="w_600"/></td>
         </tr> -->

                </table>
            </div>
       <!--      <div class="choose_title"><label><input type="checkbox" name="is_agree" class="" style="left:0px;opacity:1" />
                      同意审批后，授信额度风险由供应商承担。</label>
       </div> -->
   <!--          <div class="form_btn clear" id="opare_btn" >
     <input type="hidden" name="apply_id" id="apply_id">
     <input type="button" name="submit" value="提交审核" class="btn btn_blue"   id="through"  style="margin-left:285px;"  onclick="submit_credit(1)">
     <input type="button" name="" value="拒绝" class="btn btn_blue" id="refuse" style="margin-left:285px;"  onclick="submit_credit(-1)" >
     <input type="button" name="button" value="关闭" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
   </div> -->

  <!--          <div class="form_btn clear" id="order_pl" >
     <input type="hidden" name="order_id" id="order_id">
     <input type="button" name="submit" value="提交审核" class="btn btn_blue"   id="through_pl"  style="margin-left:285px;"  onclick="submit_order()">
     <input type="button" name="" value="拒绝" class="btn btn_blue" id="refuse_pl" style="margin-left:285px;"  onclick="refuse_order()" >
     <input type="button" name="button" value="关闭" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
            </div> -->

            <div class="form_btn clear" id="look_btn" >
            <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" style="margin-left:350px;position: relative;" >
             </div>
        </form>
    </div>
</div>
<!--订单信用额度申请-->
    <div class="fb-content" id="order_limit_approve" style="display:none;">
    <div class="box-title">
        <h4>额度审批</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
    <div class="status_box">
          <ul class="clear">
              <li class="on"  id="a_li" ><span class="time" id="s_addtime"></span><i></i><span class="txt">新增申请</span></li>
                <li class="" id="m_li" ><span class="time" id="s_maddtime" ></span><i></i><span class="txt">经理审批</span></li>
                <li class=""  id="s_li" ><span class="time" id="s_litime"></span><i></i><span class="txt">旅行社/供应商授权</span></li>
                <li id="reutrn_li" ><span class="time" id="r_time"></span><i></i><span class="txt">已还款</span></li>
            </ul>
        </div>
        <form method="post" action="#" id="addlimit-data" class="form-horizontal">
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
                    <tr height="40" >
                          <td class="order_info_title">审核意见:</td>
                          <td colspan="3" ><input type="text" name="ap_reply"   class="w_600"/></td>
                    </tr>

                </table>
            </div>
            <div class="choose_title"><label><input type="checkbox" name="is_agree" class="" style="left:0px;opacity:1" />
                           同意审批后，授信额度风险由供应商承担。</label>
            </div>

           <div class="form_btn clear" id="order_pl" >
              <input type="hidden" name="order_id" id="order_id">
              <input type="button" name="submit" value="提交审核" class="btn btn_blue"   id="through_pl"  style="margin-left:285px;"  onclick="submit_order()">
             <!--  <input type="button" name="" value="拒绝" class="btn btn_blue" id="refuse_pl" style="margin-left:285px;"  onclick="refuse_order()" >  -->
              <input type="button" name="button" value="关闭" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
          </div>

        </form>
    </div>
</div>

<!--拒绝订单信用额度申请-->
    <div class="fb-content" id="dis_limit_approve" style="display:none;">
    <div class="box-title">
        <h4>额度审批</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
    <div class="status_box">
          <ul class="clear">
              <li class="on"  id="a_li" ><span class="time" id="s_addtime"></span><i></i><span class="txt">新增申请</span></li>
                <li class="" id="m_li" ><span class="time" id="s_maddtime" ></span><i></i><span class="txt">经理审批</span></li>
                <li class=""  id="s_li" ><span class="time" id="s_litime"></span><i></i><span class="txt">旅行社/供应商授权</span></li>
                <li id="reutrn_li" ><span class="time" id="r_time"></span><i></i><span class="txt">已还款</span></li>
            </ul>
        </div>
        <form method="post" action="#" id="addlimit-data" class="form-horizontal">
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
                     <tr height="40" id="apply_remark_t">
                              <td class="order_info_title"><i class="important_title">*</i>审核意见:</td>
                              <td colspan="3" class="s_reply" ><input type="text" name="apply_s_remark"   class="w_600"/></td>
                     </tr>

                </table>
            </div>

           <div class="form_btn clear" id="order_pl" >
              <input type="hidden" name="order_id" id="order_id">
              <input type="button" name="" value="拒绝" class="btn btn_blue" id="refuse_pl" style="margin-left:285px;"  onclick="refuse_order()" > 
              <input type="button" name="button" value="关闭" class="layui-layer-close btn btn_gray" style="margin-left:80px;">
          </div>

        </form>
    </div>
</div>
<!--分页-->
<script src="/assets/js/jQuery-plugin/paging/jquery-paging.js"></script>
<link href="/assets/js/jQuery-plugin/paging/css/jquery.paging.css" rel="stylesheet" />
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<!---->
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
  page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/b1/credit/credit_limit/indexData",form : '#search-condition',// 绑定一个查询表单的ID
        columns : [

          {field : 'id',title : '申请编号',width : '60',align : 'center'},
          {field : 'realname',title : '申请人',width : '70',align : 'center',
                formatter : function(value,rowData, rowIndex){
                      return '<a href="##" onclick="show_user('+rowData.expert_id+',1)">'+rowData.realname+'</a>';
                },
          },
          {field : 'credit_limit',title : '申请金额',align : 'right',sortable : true,width : '80',
              formatter : function(value,rowData, rowIndex){
                   if(rowData.status==1){
                                return '<a href="#" onclick="through_credit('+rowData.id+',4)">'+rowData.credit_limit+'</a>&nbsp;&nbsp;&nbsp;';
                   }else{
                                return '<a href="#" onclick="through_credit('+rowData.id+',2)">'+rowData.credit_limit+'</a>&nbsp;&nbsp;&nbsp;';
                    }
               },
          },
          {field : 'real_amount',title : '使用金额',align : 'right', width : '80',
                formatter : function(value,rowData, rowIndex){
                    if(value==''){
                          value=0;
                    }
                    if(rowData.status==1){
                                return '<a href="#" onclick="through_credit('+rowData.id+',4)">'+value+'</a>';
                    }else{
                                return '<a href="#" onclick="through_credit('+rowData.id+',2)">'+value+'</a>';
                    }
                }
          },
          {field : 'return_amount',title : '已还款金额',align : 'right', width : '80',
                formatter : function(value,rowData, rowIndex){
                              if(rowData.return_amount==''){
                                      rowData.return_amount='0.00';
                              }
                             if(rowData.status==1){
                                        return '<a href="#" onclick="through_credit('+rowData.id+',4)">'+rowData.return_amount+'</a>';
                            }else{
                                        return '<a href="#" onclick="through_credit('+rowData.id+',2)">'+rowData.return_amount+'</a>';
                            }
                }
          },

          {field : 'addtime',title : '申请日期',align : 'center', width : '110'},
          {field : 'return_time',title : '还款日期',align : 'center', width : '90'},
          {field : 'remark',title : '申请说明',align : 'center', width : '100'},
          {field : 'ordersn',title : '订单编号',width : '100',align : 'center'},
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
          {field : 's_realname',title : '供应商审核人',align : 'center', width : '100',
                formatter : function(value,rowData, rowIndex){
                      if(rowData.status==1){
                             return '';
                      }else{
                        return rowData.s_realname;
                      }
                }
          },
          {field : '',title : '审核状态',align : 'center',width : '80',
              formatter : function(value,rowData, rowIndex){
                //return '<a href="#" onclick="through_credit('+rowData.id+',1)">授信中</a>';
                   if(rowData.status==0){
                        return '未提交';
                   }else if(rowData.status==1){
                        return '申请中';
                   }else if(rowData.status==2){
                        return '经理拒绝';
                   }else if(rowData.status==3){
                        return '已授信';
                   }else if(rowData.status==4){
                        return '已还款';
                   }else if(rowData.status==5){
                        return '已拒绝';
                   }else{
                      return '';
                   }
              }
          },
             {field : '',title : '操作',align : 'center',width : '100',
                    formatter : function(value,rowData, rowIndex){
                          if(rowData.status==1){
                              //  if(rowData.order_status==3){
                                     var str='';
                                     str=str+'<a href="#" onclick="through_order_credit('+rowData.id+',3)">通过</a>&nbsp;&nbsp;&nbsp;';
                                     str=str+'<a href="#" onclick="refuse_order_credit('+rowData.id+',-3)">拒绝<a>';
                                     return str;
                        /*        }else{
                                    var str='';
                                    str=str+'<a href="#" onclick="through_credit('+rowData.id+',1)">通过</a>&nbsp;&nbsp;&nbsp;';
                                    str=str+'<a href="#" onclick="through_credit('+rowData.id+',-1)">拒绝<a>';
                                    return str;
                                }*/
                          }else{
                                   return '';
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
//查看额度申请申请
function through_credit(id,style){
       layer.open({
              type: 1,
              title: false,
              closeBtn: 0,
              area: '800px',
              //skin: 'layui-layer-nobg', //没有背景色
              shadeClose: false,
              content: $('#limit_approve')
      });

      $('input[name="order_id"]').val('');
      $('#limit_approve').find('input[name="apply_id"]').val('');
      jQuery.ajax({ type : "POST",data :"apply_id="+id,url : "<?php echo base_url()?>admin/b1/credit/credit_limit/get_credit_row",
              success : function(data) {
                    data = eval('('+data+')');
                    if(data.credit.m_addtime=="1000-01-01 00:00:00"){
                            data.credit.m_addtime='';
                    }
                    if(data.credit.modtime=="1000-01-01 00:00:00"){
                          data.credit.modtime='';
                    }
                    $('input[name="order_id"]').val(data.credit.order_id);
                    $('#limit_approve').find('.apply_money').html(data.credit.credit_limit); //申请额度
                    $('#limit_approve').find('input[name="apply_id"]').val(data.credit.id);
                    $('#limit_approve').find('.apply_sn').html(data.credit.id); //申请编号
                    $('#limit_approve').find('.apply_addtime').html(data.credit.addtime); //申请时间
                    $('#limit_approve').find('.apply_endtime').html(data.credit.return_time); //返还时间
                    $('#limit_approve').find('.apply_people').html(data.credit.expert_name);//申请人
                    $('#limit_approve').find('.apply_departName').html(data.credit.depart_name); //营业部
                    $('#limit_approve').find('.apply_remark').html(data.credit.remark); //申请说明
                    $('#limit_approve').find('#s_addtime').html(data.credit.addtime);
                    $('#limit_approve').find('.apply_manager_name').html(data.credit.manager_name);  //审核经理
                    $('#limit_approve').find('.apply_m_addtime').html(data.credit.m_addtime); //审核时间
                    $('#limit_approve').find('.apply_m_remark').html(data.credit.m_remark);   //审核说明
                    $('#limit_approve').find('.apply_supplier').html(data.credit.realname);  //供应商审核
                    $('#limit_approve').find('.apply_modtime').html(data.credit.modtime);
                    if(data.credit.real_amount==null){
                        data.credit.real_amount=0;
                    }
                    $('#limit_approve').find('.apply_real_amount').html(data.credit.real_amount); //使用的金额

                    $('#limit_approve').find('#m_li').addClass("on");   //经理通过
                    $('#limit_approve').find('#m_li').find('.time').html(data.credit.m_addtime);
                   $('#limit_approve').find('#s_li').removeClass("on");    //供应商或旅行社通过
                    $('#limit_approve').find('#s_li').find('.time').html('');
                    $('#limit_approve').find('#reutrn_li').removeClass("on");   //还款
                   $('#limit_approve').find('#reutrn_li').find('.time').html('');
                    if(data.credit.status==1){  //申请中
                          $('#limit_approve').find('.t_apply').hide();  //屏蔽供应商信息
                          $('#limit_approve').find('#m_li').addClass("on");
                          $('#limit_approve').find('#m_li').find('.time').html(data.credit.m_addtime);
                          $('#limit_approve').find('#s_li').removeClass("on");
                          $('#limit_approve').find('#s_li').find('.time').html('');
                         // $('#limit_approve').find('#limit_approve').find('.s_reply').html('<input type="text" name="apply_s_remark"   class="w_600"/>');
                    }else{
                  //    alert(data.credit.reply);
                          $('#limit_approve').find('.s_reply').html(data.credit.reply);
                    }
                    if(data.credit.status==3){ //授信中
                          $('#limit_approve').find('#limit_approve').find('.t_apply').show();  //显示供应商信息
                          $('#limit_approve').find('#m_li').addClass("on");
                          $('#limit_approve').find('#m_li').find('.time').html(data.credit.m_addtime);
                          $('#limit_approve').find('#s_li').addClass("on");
                          $('#limit_approve').find('#s_li').find('.time').html(data.credit.modtime);
                    }
                    if(data.credit.status==4){  //已还款
                              $('#limit_approve').find('#limit_approve').find('.t_apply').show();  //显示供应商信息
                              $('#limit_approve').find('#m_li').addClass("on");
                              $('#limit_approve').find('#m_li').find('.time').html(data.credit.m_addtime);
                              $('#limit_approve').find('#s_li').addClass("on");
                              $('#limit_approve').find('#s_li').find('.time').html(data.credit.modtime);
                              $('#limit_approve').find('#reutrn_li').addClass("on");
                              $('#limit_approve').find('#reutrn_li').find('.time').html(data.credit.return_time);
                    }
                    jQuery('#tab0').click();
             }
      })
}

//-----------------------订单信用额度申请-------------------------------
function through_order_credit(id,style){
      layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '800px',
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: false,
            content: $('#order_limit_approve')
     });
      $('#order_limit_approve').find('input[name="ap_reply"]').val('');
      $('#order_limit_approve').find('input[name="order_id"]').val('');
      $('#order_limit_approve').find('input[name="apply_id"]').val('');
      jQuery.ajax({ type : "POST",data :"apply_id="+id,url : "<?php echo base_url()?>admin/b1/credit/credit_limit/get_credit_row",
              success : function(data) {
                                data = eval('('+data+')');
                                if(data.credit.m_addtime=="1000-01-01 00:00:00"){
                                        data.credit.m_addtime='';
                                }
                                $('#order_limit_approve').find('input[name="order_id"]').val(data.credit.order_id);
                                $('#order_limit_approve').find('.apply_money').html(data.credit.credit_limit); //申请额度
                                $('#order_limit_approve').find('input[name="apply_id"]').val(data.credit.id);
                                $('#order_limit_approve').find('.apply_sn').html(data.credit.id); //申请编号
                                $('#order_limit_approve').find('.apply_addtime').html(data.credit.addtime); //申请时间
                                $('#order_limit_approve').find('.apply_endtime').html(data.credit.return_time); //返还时间
                                $('#order_limit_approve').find('.apply_people').html(data.credit.expert_name);//申请人
                                $('#order_limit_approve').find('.apply_departName').html(data.credit.depart_name); //营业部
                                $('#order_limit_approve').find('.apply_remark').html(data.credit.remark); //申请说明
                                $('#order_limit_approve').find('#s_addtime').html(data.credit.addtime);
                                $('#order_limit_approve').find('.apply_manager_name').html(data.credit.manager_name);  //审核经理
                                $('#order_limit_approve').find('.apply_m_addtime').html(data.credit.m_addtime); //审核时间
                                $('#order_limit_approve').find('.apply_m_remark').html(data.credit.m_remark);   //审核说明
                                $('#order_limit_approve').find('.apply_supplier').html(data.credit.realname);  //供应商审核
                                $('#order_limit_approve').find('.apply_modtime').html(data.credit.modtime);
                                if(data.credit.real_amount==null){
                                    data.credit.real_amount=0;
                                }
                                $('#order_limit_approve').find('.apply_real_amount').html(data.credit.real_amount); //使用的金额

                                $('#order_limit_approve').find('#m_li').addClass("on");   //经理通过
                                $('#order_limit_approve').find('#m_li').find('.time').html(data.credit.m_addtime);

                                jQuery('#tab0').click();
             }
      })

}
//----------------------------拒绝信用额度----------------------------------
function refuse_order_credit(id,style){
      layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '800px',
            //skin: 'layui-layer-nobg', //没有背景色
            shadeClose: false,
            content: $('#dis_limit_approve')
     });

      $('#dis_limit_approve').find('input[name="order_id"]').val('');
      $('#dis_limit_approve').find('input[name="apply_id"]').val('');
      jQuery.ajax({ type : "POST",data :"apply_id="+id,url : "<?php echo base_url()?>admin/b1/credit/credit_limit/get_credit_row",
              success : function(data) {
                                data = eval('('+data+')');
                                if(data.credit.m_addtime=="1000-01-01 00:00:00"){
                                        data.credit.m_addtime='';
                                }
                                $('#dis_limit_approve').find('input[name="order_id"]').val(data.credit.order_id);
                                $('#dis_limit_approve').find('.apply_money').html(data.credit.credit_limit); //申请额度
                                $('#dis_limit_approve').find('input[name="apply_id"]').val(data.credit.id);
                                $('#dis_limit_approve').find('.apply_sn').html(data.credit.id); //申请编号
                                $('#dis_limit_approve').find('.apply_addtime').html(data.credit.addtime); //申请时间
                                $('#dis_limit_approve').find('.apply_endtime').html(data.credit.return_time); //返还时间
                                $('#dis_limit_approve').find('.apply_people').html(data.credit.expert_name);//申请人
                                $('#dis_limit_approve').find('.apply_departName').html(data.credit.depart_name); //营业部
                                $('#dis_limit_approve').find('.apply_remark').html(data.credit.remark); //申请说明
                                $('#dis_limit_approve').find('#s_addtime').html(data.credit.addtime);
                                $('#dis_limit_approve').find('.apply_manager_name').html(data.credit.manager_name);  //审核经理
                                $('#dis_limit_approve').find('.apply_m_addtime').html(data.credit.m_addtime); //审核时间
                                $('#dis_limit_approve').find('.apply_m_remark').html(data.credit.m_remark);   //审核说明
                                $('#dis_limit_approve').find('.apply_supplier').html(data.credit.realname);  //供应商审核
                                $('#dis_limit_approve').find('.apply_modtime').html(data.credit.modtime);
                                if(data.credit.real_amount==null){
                                    data.credit.real_amount=0;
                                }
                                $('#dis_limit_approve').find('.apply_real_amount').html(data.credit.real_amount); //使用的金额

                                $('#dis_limit_approve').find('#m_li').addClass("on");   //经理通过
                                $('#dis_limit_approve').find('#m_li').find('.time').html(data.credit.m_addtime);

                                jQuery('#tab0').click();
             }
      })

}


//--------------信用审批(暂已屏蔽)-----------------
function submit_credit(type){
       var apply_id=$('#limit_approve').find('input[name="apply_id"]').val();
       var reply=$('#limit_approve').find('input[name="apply_s_remark"]').val();
       var formParam = jQuery('#addlimit-data').serialize();
       jQuery.ajax({ type : "POST",async:false, data :formParam+"&type="+type ,url : "<?php echo base_url()?>admin/b1/credit/credit_limit/update_credit",
              success : function(data) {
                          data = eval('('+data+')');
                          if(data.status==1){
                                  alert(data.msg);
                                  $('.layui-layer-close').click();
                          }else{
                                alert(data.msg);
                          }
              }
       });

      jQuery('#tab0').click();
}
//------------------下单的额度审批--------------------
function submit_order(){
          var orderid=$('#order_limit_approve').find('input[name="order_id"]').val();
          var ap_reply=$('#order_limit_approve').find('input[name="ap_reply"]').val();
  
          var is_agree=$('#order_limit_approve').find('input[name="is_agree"]').is(':checked');

          if(!is_agree){
                alert('请同意审批');
                return false;

          }

         $.post("<?php echo base_url()?>admin/b1/order/add_order_debit", { orderid:orderid,ap_reply:ap_reply} , function(result) {
                    var result =eval("("+result+")");
                    if(result.status==1){
                            alert(result.msg);
                            $('#tab0').click();
                           // $('#order_limit_approve').find('input[name="return_time"]').val('');
                            $('.layui-layer-close').click();
                            window.location.reload(); 
                    }else{
                            alert(result.msg);
                    }
          });
             
}
//-----------------------------下单额度拒绝------------------------
function refuse_order(){
      var orderid=$('#dis_limit_approve').find('input[name="order_id"]').val();
      var s_reply= $('#dis_limit_approve').find('input[name="apply_s_remark"]').val();
 /*     if(s_reply==''){
            alert('请填写审核意见');
            return false;
      }*/
    $.post("<?php echo base_url()?>admin/b1/order/refuse_order_debit", { orderid:orderid,s_reply:s_reply} , function(result) {
      var result =eval("("+result+")");
            if(result.status==1){
                    alert(result.msg);
                    $('.layui-layer-close').click();
                    $('#tab0').click();
                    window.location.reload(); 
            }else{
                   alert(result.msg);
            }
    });
    
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
$('#return_starttime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
$('#return_endtime').datetimepicker({
      lang:'ch', //显示语言
      timepicker:false, //是否显示小时
      format:'Y-m-d', //选中显示的日期格式
      formatDate:'Y-m-d',
      validateOnBlur:false,
});
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