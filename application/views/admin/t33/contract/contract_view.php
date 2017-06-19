<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>合同管理</title>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.x-list-plain{z-index:111111111;}

.order_info_table tr td{padding:5px 10px !important;}
#add_contract_form input{height:24px;}
#receive_contract_form input,#cancel_contract_form input{height:24px;}

</style>

</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>合同发票管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">合同管理</a>
        </div>
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-value="0">
                        <li static="0"><a href="#tab1" class="active">未派发</a></li>
                        <li static="1"><a href="#tab1">已领用</a></li>
                        <li static="2"><a href="#tab1">未核销</a></li>
                        <li static="3"><a href="#tab1">已核销</a></li>
                        <li static="4"><a href="#tab1">已作废</a></li>
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">

                        <form class="search_form" id="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                    <div class="search_group" id="input_people">
                                        <label>录入人：</label>
                                        <input type="text"  name="input_people" class="search_input" style="width:90px;" />
                                    </div>

                                    <div class="search_group" id="num">
                                        <label>数量：</label>
                                        <input type="text"  name="start_num" class="search_input" style="float: none;width:90px;" /> ~ <input type="text"  name="end_num" class="search_input" style="float: none;width:90px;" />
                                    </div>
                                    <div class="search_group" id="input_date">
                                        <label>录入日期：</label>
                                        <input class="search_input starttime" type="text" name="start_input_date"  data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input endtime" type="text" name="end_input_date"  data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                                    </div>
                                     <div class="search_group" id="prefix">
                                        <label>前缀：</label>
                                        <input type="text" name="prefix" class="search_input" style="width:90px;" />
                                    </div>

                                    <div class="search_group"   id="receive_depart" style="display: none">
                                        <label>领用部门：</label>
                                        <input type="text" name="receive_depart" class="search_input" style="width:120px;" />
                                    </div>
                                     <div class="search_group" id="contract_sn" style="display: none">
                                        <label>合同号：</label>
                                        <input type="text" name="contract_sn" class="search_input" style="width:120px;" />
                                    </div>
                                    <div class="search_group" id="receive_date" style="display: none">
                                        <label>分配日期：</label>
                                        <input class="search_input starttime" type="text" name="start_receive_date"  data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input endtime" type="text" name="end_receive_date"  data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                                    </div>
                                     <div class="search_group" id="receive_people" style="display: none">
                                        <label>领用人：</label>
                                        <input type="text"  name="receive_people" class="search_input" style="width:90px;" />
                                    </div>
                                    <div class="search_group" id="order_sn" style="display: none">
                                        <label>订单号：</label>
                                        <input type="text"  name="order_sn" class="search_input" style="width:120px;" />
                                    </div>
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                                <div class="search_group">
                                    <span class="btn btn_green" style="margin-top:3px;" onclick="add_contract(this)" id="add_invoice">+新增合同</span>
                                </div>
                            </div>
                        </form>

                        <table class="table table-bordered table_hover">
                            <thead class="" >

                                <tr id="show_thd">
                                    <th>序号</th>
                                    <th>批次号</th>
                                    <th>录入日期</th>
                                    <th>合同类型</th>
                                    <th>前缀</th>
                                    <th>起始号码</th>
                                    <th>终止号码</th>
                                    <th>总数量</th>
                                    <th>已领用</th>
                                    <th>已使用</th>
                                    <th>未使用</th>
                                    <th>录入人</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody class="data_rows"></tbody>
                        </table>
                        <span class="btn btn_green" style="display:none;margin-top:3px;" onclick="write_off(this)" id="write_off">核销</span>
                        <!-- 暂无数据 -->
                        <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
                    </div>
                </div>
                <div id="page_div"></div>
            </div>
        </div>
    </div>
<!-- ****************************************************增加合同弹框**********************************************************************-->
    <div class="fb-content" id="add_contract_modal" style="display:none;">
        <div class="box-title">
            <h4>新增合同</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="jkxx fb-form" style="padding:10px;">
            <form id="add_contract_form" action="#" method="post">
                    <div class="content_part">
                    <a style="width: 100%;height: 100%;cursor: pointer;" onclick="append_td(this)">+新增合同</a>
                         <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                           
                            <tr height="30">
                                    <th class="order_info_title" width="10%">合同类型</th>
                                    <th class="order_info_title" width="10%">前缀</th>
                                    <th class="order_info_title" width="10%">合同起始编号</th>
                                    <th class="order_info_title" width="10%">合同结束编号</th>
                                    <th class="order_info_title" width="10%">数量</th>
                                    <th class="order_info_title" width="10%">备注</th>
                                    <th class="order_info_title" width="5%"></th>
                            </tr>
                            <tr>
                                    <td>
                                        <select name="contract_name[]">
                                            <option value="出境合同">出境合同</option>
                                            <option value="国内合同">国内合同</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input style="width:100%;"  type="text" name="prefix[]" value="" />
                                    </td>
                                    <td>
                                        <input style="width:100%;" onkeyup="cal_num(this)"  type="text" name="start_contract_num[]" value="0"/>
                                    </td>
                                    <td>
                                        <input style="width:100%;" onkeyup="cal_num(this)"  type="text" name="end_contract_num[]" value="0"/>
                                    </td>
                                    <td>
                                        <input style="width:100%;" readonly="readonly"  type="text" name="total_num[]" value="0"/>
                                    </td>
                                    <td>
                                        <input style="width:100%;"  type="text" name="remark[]" value=""/>
                                    </td>
                                    <td style="text-align: center">
                                       <!--  <span style="width:100%;height: 100%;color:red;text-align: center;cursor: pointer;" onclick="cancle_td(this)">X</span>
                                       --> 
                                    </td>
                            </tr>
                        </table>
                </div>
                <div class="form_btn" style="padding-bottom:30px;">
                    <input type="submit" name="submit" value="确认" class="btn btn_blue" style="margin-left:300px;height:100%;" />
                    <input type="reset" name="reset" value="取消" class="btn btn_gray layui-layer-close" style="margin-left:30px;height:32px;" />
                </div>
            </form>
        </div>
    </div>
<!-- ****************************************************End新增合同弹框**********************************************************************-->
<!-- ****************************************************查看合同列表弹框**********************************************************************-->
    <div class="fb-content" id="contract_list_modal" style="display:none;">
        <div class="box-title">
            <h4>合同列表</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="jkxx fb-form" style="padding:10px;">
            <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                         <thead class="" >
                            <tr height="30">
                                    <th class="order_info_title" width="8%">合同编号</th>
                                    <th class="order_info_title" width="5%">批次号</th>
                                    <th class="order_info_title" width="5%">订单号</th>
                                    <th class="order_info_title" width="5%">合同类型</th>
                                    <th class="order_info_title" width="5%">前缀</th>
                                    <th class="order_info_title" width="5%">合同编号</th>
                                    <th class="order_info_title" width="10%">使用时间</th>
                                    <th class="order_info_title" width="5%">使用人</th>
                                    <th class="order_info_title" width="5%">使用部门</th>
                                    <th class="order_info_title" width="5%">分配人</th>
                                    <th class="order_info_title" width="5%">核销状态</th>
                                    <th class="order_info_title" width="5%">作废备注</th>
                                    <th class="order_info_title" width="5%">操作</th>
                            </tr>
                            </thead>
                            <tbody id="invoice_list"></tbody>
                        </table>
            </div>
        </div>

<!-- ****************************************************End查看合同列表弹框**********************************************************************-->

<!-- ****************************************************查看合同详情弹框**********************************************************************-->
<div class="fb-content" id="contract_detail_modal" style="display:none;">
        <div class="box-title">
            <h4>领用记录</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
          
        <div class="jkxx fb-form" style="padding:10px;">
            <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                         <thead class="" >
                            <tr height="30">
                                    <th class="order_info_title" width="5%">领用日期</th>
                                    <th class="order_info_title" width="5%">合同前缀</th>
                                    <th class="order_info_title" width="5%">起始~结束编号</th>
                                    <th class="order_info_title" width="5%">领用数</th>
                                    <th class="order_info_title" width="5%">领用部门</th>
                                    <th class="order_info_title" width="5%">领用人</th>
                                    <th class="order_info_title" width="5%">分配人</th>
                                    <th class="order_info_title" width="5%">使用数量</th>
                                    <th class="order_info_title" width="3%">作废数量</th>
                                    <th class="order_info_title" width="5%">状态</th>
                                    
                            </tr>
                            </thead>
                            <tbody id="use_contract_list"></tbody>
            </table>
          </div>
</div>

<!-- ****************************************************End查看合同详情弹框**********************************************************************-->

<!-- ****************************************************作废合同弹框**********************************************************************-->
<div class="fb-content" id="cancel_invoice_modal" style="display:none;">
        <div class="box-title">
            <h4>作废合同</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="jkxx fb-form" style="padding:10px;">
        <form id="cancel_contract_form" action="#" method="post">
        <div class="content_part">
            <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                    <tr>
                        <td>操作人</td>
                        <td><?php echo $this->session->userdata("employee_loginName");?></td>
                    </tr>
                    <tr>
                        <td>作废日期</td>
                        <td id="cancel_date"></td>
                    </tr>
                    <tr>
                        <td>作废备注</td>
                        <td><input type="text" name="cancel_remark" value="" style="width:100%;"></td>
                    </tr>
            </table>
            </div>
            <div class="form_btn" style="padding-bottom:30px;">
                    <input type="hidden" name="hidden_cancel_date" id="hidden_cancel_date" value="">
                    <input type="hidden" name="hidden_list_id" id="hidden_list_id" value="">
                    <input type="hidden" name="hidden_use_id" id="hidden_use_id" value="">
                    <input type="submit" name="submit" value="确认" class="btn btn_blue" style="margin-left:226px;height:100%;" />
                </div>
        </form>

          </div>
</div>

<!-- ****************************************************End作废合同弹框**********************************************************************-->


<!-- ****************************************************查看已作废合同详情弹框**********************************************************************-->
<div class="fb-content" id="show_cancel_contract_modal" style="display:none;">
        <div class="box-title">
            <h4>已作废</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
           <div class="jkxx fb-form" style="padding:10px;">
            <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                         <thead class="" >
                            <tr height="30">
                                    <th class="order_info_title" width="3%">批次号</th>
                                    <th class="order_info_title" width="3%">合同类型</th>
                                    <th class="order_info_title" width="5%">前缀</th>
                                    <th class="order_info_title" width="5%">合同编号</th>
                                    <th class="order_info_title" width="5%">领用部门</th>
                                    <th class="order_info_title" width="5%">使用人</th>
                                    <th class="order_info_title" width="8%">作废时间</th>
                                    <th class="order_info_title" width="5%">作废人</th>
                                    <th class="order_info_title" width="5%">作废备注</th>
                            </tr>
                            </thead>
                            <tbody id="one_cancel_contract"></tbody>
            </table>
          </div>
</div>

<!-- ***********************************************End查看已作废详情弹框**********************************************************************-->

<!-- ***********************************************提交核销弹框**********************************************************************-->
<div class="fb-content" id="write_off_modal" style="display:none;">
    <div class="box-title">
        <h4>合同核销</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
    <form  class="form-horizontal" action="#" id='write_off_form' name='write_off_form' method="post">
        <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">核销日期:</td>
                        <td id="wirte_off_date"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">核销人:</td>
                        <td ><?php echo $this->session->userdata('employee_loginName');?></td>
                    </tr>
                </table>
                <div style="text-align:center;">
                  <input type="hidden" name="contract_ids" id="contract_ids" value=""/>
                  <input type="hidden" name="submit_date" id="submit_date" value=""/>
                  <input type="submit" name="submit" value="确认" class="btn btn_blue" style="margin-left:-5px;margin-top:13px;margin-bottom: 12px;" />
                </div>
              </form>
    </div>
</div>
<!-- ***********************************************End提交核销弹框**********************************************************************-->

<!-- ****************************************************领用合同弹框**********************************************************************-->
<div class="fb-content" id="receive_contract_modal" style="display:none;">
        <div class="box-title">
            <h4>领用合同</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
           <div class="jkxx fb-form" style="padding:10px;">
            <form id="receive_contract_form" action="#" method="post">
               <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                         <tr height="30">
                             <td width="89" style="text-align: right;">总数量</td>
                             <td width="241" style="text-align: left;" id="total_invoice_num"></td>
                             <td width="89" style="text-align: right;">可领用</td>
                             <td style="text-align: left;" id="can_use"></td>
                         </tr>
                         <tr height="30">
                             <td style="text-align: right;">分配日期</td>
                             <td style="text-align: left;" id="assign_date"></td>
                             <td style="text-align: right;">分配人</td>
                             <td style="text-align: left;" id="assign_people"><?php echo $this->session->userdata('employee_loginName');?></td>
                         </tr>
                         
                         <tr height="30">
                             <td style="text-align: right;">起始编号</td>
                             <td style="text-align: left;"><input type="text" id="start_input_code" name="start_input_code" value=""></td>
                             <td style="text-align: right;">结束编号</td>
                             <td style="text-align: left;">
                                <input type="text" name="end_input_code" id="end_input_code" onkeyup="calculate_num(this)" value="">
                                <span id="input_total_num">供0份</span>
                                <span id="error_tips" style="color:red"></span>
                             </td>
                         </tr>
                          
                         
                         <tr height="30">
                             <td style="text-align: right;">领用人</td>
                             <td style="text-align: left;"><input type="text" id="choose_receive_people" name="choose_receive_people" value=""></td>
                             <td style="text-align: right;">领用部门</td>
                             <td style="text-align: left;" id="choose_receive_depart">选择领用人之后才显示</td>
                         </tr>
                         
                         <tr height="30">
                             <td style="text-align: right;">备注</td>
                             <td colspan="3" style="text-align: left;"><input style="width:100%;" type="text" name="receive_remark" value=""></td>
                         </tr>
            </table>
            <div style="text-align:center;">
                  <input type="hidden" name="choose_depart_id" id="choose_depart_id" value="">
                  <input type="hidden" name="choose_depart_name" id="choose_depart_name" value="">
                  <input type="hidden" name="choose_depart_list" id="choose_depart_list" value="">
                  <input type="hidden" name="choose_can_num" id="choose_can_num" value="">
                  <input type="hidden" name="choose_use_num" id="choose_use_num" value="">
                  <input type="hidden" name="hidden_assign_date" id="hidden_assign_date" value="">
                  <input type="hidden" name="hidden_start_code" id="hidden_start_code" value="">
                  <input type="hidden" name="hidden_prefix" id="hidden_prefix" value="">
                  <input type="hidden" name="hidden_contract_id" id="hidden_contract_id" value="">
                  <input type="submit" name="submit" value="确认" class="btn btn_blue" style="margin-left:-5px;margin-top:13px;margin-bottom: 12px;height:100%;" />
                </div>
           </form>
          </div>
        <div class="jkxx fb-form" style="padding:10px;">
            <span style="">领用记录</span></hr>
            <table class="order_info_table table_td_border" border="1" id="add_contract_table" width="100%" cellspacing="0">
                         <thead class="" >
                            <tr height="30">
                                    <th class="order_info_title" width="4%">序号</th>
                                    <th class="order_info_title" width="5%">前缀</th>
                                    <th class="order_info_title" width="8%">起始~结束编号(已领)</th>
                                    <!-- <th class="order_info_title" width="5%">结束编号</th> -->
                                    <th class="order_info_title" width="5%">领用数量</th>
                                    <th class="order_info_title" width="5%">领用部门</th>
                                    <th class="order_info_title" width="5%">领用人</th>
                                    
                                    <th class="order_info_title" width="4%">使用数</th>
                                    <th class="order_info_title" width="4%">作废数</th>
                                    <th class="order_info_title" width="5%">分配人</th>
                                    <th class="order_info_title" width="5%">状态</th>
                            </tr>
                            </thead>
                            <tbody id="received_contract_list"></tbody>
            </table>
          </div>
</div>

<!-- ****************************************************End领用合同弹框********************************************************************-->

<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript">

//计算实际可以领用份数
function calculate_num(obj){
    var prefix = $("#hidden_prefix").val();
    var contract_id = $("#hidden_contract_id").val();
    var start_num = $("#start_input_code").val();
    var end_num = $(obj).val();
    if(end_num.length!=start_num.length){
    	$("#error_tips").html("起始编号长度应该等于结束编号");
        return false;
    }
    else
    	$("#error_tips").html("");
    var total_num = Number(end_num)-Number(start_num)+1;
    $.post("<?php echo base_url();?>admin/t33/sys/contract/get_can_use",
                 {'start_num':start_num,'end_num':end_num,'prefix':prefix,'contract_id':contract_id},
                 function(data){
                    data = eval('('+data+')');
                    $("#input_total_num").html('共'+data['can_use_count']+'份');
                    $("#choose_use_num").val(data['can_use_count']);
                }
     );
    $("#choose_can_num").val(total_num);
}
//新增合同
function add_contract(obj){
      layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '800px',
            shadeClose: false,
            content: $('#add_contract_modal')
            });
}

//增加某一行
function append_td(obj){
    var tr_str="<tr>";
    tr_str += "<td><select name='contract_name[]'><option value='出境合同'>出境合同</option><option value='国内合同'>国内合同</option></select></td>";
    tr_str += "<td><input style='width:100%;'  type='text' name='prefix[]' value=''/></td>";
    tr_str += "<td><input style='width:100%;' onkeyup='cal_num(this)'  type='text' name='start_contract_num[]' value='0'/></td>";
    tr_str += "<td><input style='width:100%;' onkeyup='cal_num(this)'  type='text' name='end_contract_num[]' value='0'/></td>";
    tr_str += "<td><input style='width:100%;'  type='text' name='total_num[]' value=''/></td>";
    tr_str += "<td><input style='width:100%;'  type='text' name='remark[]' value=''/></td>";
    tr_str += "<td style='text-align: center'><span style='width:100%;height: 100%;color:red;text-align: center;cursor: pointer;' onclick='cancle_td(this)'>删除</span></td>";
    tr_str += "</tr>";
    $("#add_contract_table").append(tr_str);
}

//删除某一行
function cancle_td(obj){
    $(obj).parent().parent().remove();
}

//计算每一行总数量
function cal_num(obj){
    var end_num = Number($(obj).parent().parent().find("input[name='end_contract_num[]']").val());
    var start_num = Number($(obj).parent().parent().find("input[name='start_contract_num[]']").val());
    var total_num = end_num-start_num;
    $(obj).parent().parent().find("input[name='total_num[]']").val(total_num+1);
}


//查看合同列表
function show_contract_list(obj){
    //#contract_list_modal; #invoice_list
    var contract_list_str = "";
    var contract_id = $(obj).attr('data-id');
    var use_id = $(obj).attr('data-useid');
     $.post("<?php echo base_url();?>admin/t33/sys/contract/get_contract_list",
                 {'contract_id':contract_id,use_id:use_id},
                 function(data){
                    data = eval('('+data+')');
                    $.each(data, function(name, value) {
                          contract_list_str += "<tr>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['contract_code']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['batch']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['ordersn']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['contract_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['prefix']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['contract_code']+"</td>";

                          contract_list_str += "<td style='height:35px;text-align:center'>"+(value['use_time']==null ? '' : value['use_time'])+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['expert_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['depart_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+(value['assign_people']==null ? '' : value['assign_people'])+"</td>";
                          if(value['confirm_status']==1){
                            var confirm_status = "未核销";
                          }else if(value['confirm_status']==2){
                            var confirm_status = "已核销";
                          }else{
                            var confirm_status = "未使用";
                          }
                          contract_list_str += "<td style='height:35px;text-align:center'>"+confirm_status+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['cancel_remark']+"</td>";
                          if(/*value['confirm_status']!=2 && value['use_id']>0 && */value['confirm_status']==1&&value['cancel_status']==0){
                            contract_list_str += "<td style='height:35px;text-align:center'><a style='cursor:pointer' onclick='cancel_contract(this)' data-useid='"+value['use_id']+"'  data-id='"+value['id']+"'>作废</a></td>";
                        }else{
                            contract_list_str += "<td style='height:35px;text-align:center'></td>";
                        }

                          contract_list_str += "</tr>";
                    });
                   $("#invoice_list").html(contract_list_str);
                   layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: ['840px', '650px'],
                        shadeClose: false,
                        content: $('#contract_list_modal')
                    });
           }
     );
}


//查看合同详情
function show_detail(obj){
    var contract_list_str = "";
    var one_contract = "";
    var contract_id = $(obj).attr('data-id');
     $.post("<?php echo base_url();?>admin/t33/sys/contract/get_contract_detail",
                 {'contract_id':contract_id},
                 function(data){
                    data = eval('('+data+')');
                    one_contract += "<tr>";
                    one_contract += "<td style='height:35px;text-align:center'>"+data['contract']['contract_name']+"</td>";
                    one_contract += "<td style='height:35px;text-align:center'>"+data['contract']['prefix']+"</td>";
                    one_contract += "<td style='height:35px;text-align:center'>"+data['contract']['start_code']+"</td>";
                    one_contract += "<td style='height:35px;text-align:center'>"+data['contract']['end_code']+"</td>";
                    one_contract += "<td style='height:35px;text-align:center'>"+data['contract']['num']+"</td>";
                    one_contract += "<td style='height:35px;text-align:center'>"+data['contract']['remark']+"</td>";
                    one_contract += "</tr>";
                    $("#one_contract").html(one_contract);
                    $.each(data, function(name, value) {
                        if(name=="contract" || name=="no_use_contract"){
                            return ;
                        }else{
                          contract_list_str += "<tr>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['addtime']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['prefix']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['start_code']+' ~ '+value['end_code']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['num']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['depart_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['expert_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['employee_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['use_num']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['cancel_num']+"</td>";
                          var is_recover_str="";
                          if(value['is_recover']=='1')
                              is_recover_str="<span style='color:red'>已收回</span>";
                          else
                              is_recover_str="<span color='red'>已领用</span>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+is_recover_str+"</td>";
                          contract_list_str += "</tr>";
                        }
                    });
                   $("#use_contract_list").html(contract_list_str);
                   layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: ['840px', '650px'],
                        shadeClose: false,
                        content: $('#contract_detail_modal')
                    });
           }
     );
}



//作废合同
function cancel_contract(obj){
    var list_id     = $(obj).attr('data-id');
    var use_id    = $(obj).attr('data-useid');
    var now_date =  new Date().Format("yyyy-MM-dd");
    $("#cancel_date").html(now_date);
    $("#hidden_cancel_date").val(now_date);
    $("#hidden_list_id").val(list_id);
    $("#hidden_use_id").val(use_id);
     layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '500px',
            shadeClose: false,
            content: $('#cancel_invoice_modal')
       });
}

//领用
function received(obj){
    var contract_id = $(obj).attr('data-id');
    var contract_list_str = "";
    $("#end_input_code").val('');
    $("#choose_receive_people").val("");
    $("#input_total_num").html("共0份");
    var prefix = "";
     $.post("<?php echo base_url();?>admin/t33/sys/contract/get_contract_detail",
                 {'contract_id':contract_id},
                 function(data){
                    data = eval('('+data+')');
                     if(data['no_use_contract']=='' || data['no_use_contract']==0 || data['no_use_contract']==undefined){
                        //tan_alert_noreload('已经没有可以领用的发票了');
                        //return false;
                    }
                    prefix = data['contract']['prefix'];
                    $.each(data, function(name, value) {
                        if(name=="contract" || name=="no_use_contract"){
                            return ;
                        }else{
                          contract_list_str += "<tr>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['id']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+prefix+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['start_code']+' ~ '+value['end_code']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['num']+"</td>";
                          //contract_list_str += "<td style='height:35px;text-align:center'>"+value['end_code']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['depart_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['expert_name']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['use_num']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['cancel_num']+"</td>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+value['employee_name']+"</td>";
                          var is_recover_str="";
                          if(value['is_recover']=='1')
                              is_recover_str="<span style='color:red'>已收回</span>";
                          else
                              is_recover_str="<span color='red'>已领用</span>";
                          contract_list_str += "<td style='height:35px;text-align:center'>"+is_recover_str+"</td>";
                          
                          contract_list_str += "</tr>";
                        }
                    });
                   $("#received_contract_list").html(contract_list_str);
                   $("#total_invoice_num").html(data['contract']['start_code']+' ~ '+data['contract']['end_code']+'&nbsp;&nbsp;&nbsp;     共'+data['contract']['num']+'份');
                   var can_use_num = Number(data['contract']['num'])-Number(data['contract']['use_num']);
                   $("#can_use").html(can_use_num+'份');
                   var now_date = new Date().Format("yyyy-MM-dd");
                   $("#assign_date").html(now_date);
                   $("#hidden_start_code").val(data['no_use_contract']['code']!='' ? data['no_use_contract']['code'] : "无");
                    $("#start_contract_code").html(data['no_use_contract']['code']!='' ? data['no_use_contract']['code'] : "无");

                    $("#hidden_assign_date").val(now_date);
                    $("#hidden_prefix").val(prefix);
                    $("#hidden_contract_id").val(data['contract']['id']);
                    //理论能用多少
                    //$("#choose_can_num").val(can_use_num);
                    //实际使用多少
                    //$("#choose_use_num").val();
                   layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: ['840px', '650px'],
                        shadeClose: false,
                        content: $('#receive_contract_modal')
                    });
           }
     );
}


//回收合同
function recycle(obj){
    var use_id = $(obj).attr('data-useid');
    var contract_id = $(obj).attr('data-id');
   
    var use_num = $(obj).attr('data-usenum');
    if(use_num>0)  //
    {
	    layer.confirm('已有部分编号被使用，已使用的编号不会被收回，确定要收回？', { btn: ['是','否'] }, function(){
	        //"是"操作
	    $.post(
            "<?php echo base_url();?>admin/t33/sys/contract/recycle_contract",
                     {'use_id':use_id,'contract_id':contract_id},
                     function(data){
                        data = eval('('+data+')');
                        if (data.status == 200){
                            tan_alert(data.msg);
                            //window.location.reload();
                        }else{
                        	tan_alert_noreload(data.msg);
                            //window.location.reload();
                         }
                    }
   			);
			  //end
	   },function(){
	          //"否"操作
	       }
	   );
    }
    else
    {
    	 $.post(
    	            "<?php echo base_url();?>admin/t33/sys/contract/recycle_contract",
    	                     {'use_id':use_id,'contract_id':contract_id},
    	                     function(data){
    	                        data = eval('('+data+')');
    	                        if (data.status == 200){
    	                            tan_alert(data.msg);
    	                            //window.location.reload();
    	                        }else{
    	                        	tan_alert_noreload(data.msg);
    	                            //window.location.reload();
    	                         }
    	                    }
    	   );
   	}
}

//核销合同
function write_off(obj){
   var now_date =  new Date().Format("yyyy-MM-dd");
   $("#wirte_off_date").html(now_date);
   $("#submit_date").val(now_date);
    layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '500px',
            shadeClose: false,
            content: $('#write_off_modal')
       });

}

//核销的时候选择当前数据
function choose_contract(obj){
    if($(obj).is(':checked')){
        $("#contract_ids").val($("#contract_ids").val()+$(obj).val()+",");
    }else{
        $("#contract_ids").val($("#contract_ids").val().replace($(obj).val()+',',''));
    }
}

//查看已作废合同数据
function show_cancel(obj){
    var list_id = $(obj).attr('data-id');
    var td_str = "";
    $.post(
            "<?php echo base_url();?>admin/t33/sys/contract/show_cancel_contract",
            {'list_id':list_id},
            function(data){
                  data = eval('('+data+')');
                  //cancel_invoice_modal
                  //#one_cancel_contract
                  td_str += "<tr>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['batch']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['contract_name']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['prefix']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['contract_code']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['depart_name']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['expert_name']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['cancle_time']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['cancle_people']+"</td>";
                  td_str += "<td style='height:35px;text-align:center'>"+data['cancel_remark']+"</td>";
                  td_str += "</tr>";
                  $("#one_cancel_contract").html(td_str);
                  layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: '840px',
                        shadeClose: false,
                        content: $('#show_cancel_contract_modal')
                });
            }
    );
}




	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var input_people=$("input[name='input_people']").val();
            var contract_sn=$("input[name='contract_sn']").val();
            var start_num = $("input[name='start_num']").val();
            var end_num = $("input[name='end_num']").val();
            var start_input_date=$("input[name='start_input_date']").val();
            var end_input_date=$("input[name='end_input_date']").val();
            var prefix=$("input[name='prefix']").val();
            var receive_depart = $("input[name='receive_depart']").val();
            var start_receive_date = $("input[name='start_receive_date']").val();
            var end_receive_date = $("input[name='end_receive_date']").val();
            var receive_people = $("input[name='receive_people']").val();
            var order_sn = $("input[name='order_sn']").val();
             var type=$(".itab ul").attr("data-value"); ///tab 切换
             ajax_data={
                                page:"1",
                                input_people:input_people,
                                contract_sn:contract_sn,
                                start_num:start_num,
                                end_num:end_num,
                                start_input_date:start_input_date,
                                end_input_date:end_input_date,
                                prefix:prefix,
                                receive_depart:receive_depart,
                                start_receive_date:start_receive_date,
                                end_receive_date:end_receive_date,
                                receive_people:receive_people,
                                order_sn:order_sn,
                                type:type
                            };
            if(type==0){
                var post_url="<?php echo base_url('admin/t33/sys/contract/api_contract_list')?>";
                var th_str = "<th>序号</th><th>批次号</th><th>录入日期</th><th>合同类型</th><th>前缀</th><th>起始~结束编号</th><th>总数量</th><th>已领用</th><th>已使用</th><th>未使用</th><th>录入人</th><th>备注</th><th>操作</th>";
                $("#add_invoice").show();
                $("#input_people").show();
                $("#input_date").show();
                 $("#prefix").show();
                 $("#num").show();
                $("#receive_depart").hide();
                $("#receive_date").hide();
                $("#receive_people").hide();
                 $("#order_sn").hide();
                 $("#contract_sn").hide();
            }else if(type==1){
                var post_url="<?php echo base_url('admin/t33/sys/contract/api_contract_list')?>";
                var th_str = "<th>序号</th><th>批次号</th><th>领用日期</th><th>合同类型</th><th>前缀</th><th>起始~结束编号</th><th>总数量</th><th>起始~结束编号(已领)</th><th>领用数</th><th>领用人</th><th>领用部门</th><th>分配人</th><th>使用数量</th><th>作废数量</th><th>备注</th><th>操作</th>";
                $("#add_invoice").hide();
                $("#input_people").hide();
                $("#input_date").hide();
                $("#order_sn").hide();
                $("#contract_sn").hide();
                $("#prefix").show();
                $("#receive_depart").show();
                $("#receive_date").show();
                $("#receive_people").show();
                $("#num").show();
            }else if(type==2){
                var post_url="<?php echo base_url('admin/t33/sys/contract/api_contract_list')?>";
                var th_str = "<th></th><th>序号</th><th>批次号</th><th>订单号</th><th>合同类型</th><th>前缀</th><th>合同编号</th><th>使用时间</th><th>使用人</th><th>使用部门</th><th>分配人</th><th>操作</th>";
                $("#add_invoice").hide();
                $("#input_people").hide();
                $("#input_date").hide();
                $("#num").hide();
                $("#receive_depart").show();
                $("#receive_date").show();
                $("#receive_people").show();
                $("#order_sn").show();
                $("#prefix").hide();
                $("#contract_sn").show();

            }else if(type==3){
                var post_url="<?php echo base_url('admin/t33/sys/contract/api_contract_list')?>";
                var th_str = "<th>序号</th><th>批次号</th><th>订单号</th><th>合同类型</th><th>前缀</th><th>合同编号</th><th>使用时间</th><th>使用人</th><th>使用部门</th><th>核销人</th><th>核销时间</th>";
                $("#add_invoice").hide();
                $("#input_people").hide();
                $("#input_date").hide();
                $("#num").hide();
                $("#receive_depart").show();
                $("#receive_date").show();
                $("#receive_people").show();
                $("#order_sn").show();
                $("#prefix").hide();
                $("#contract_sn").show();
            }else{
                var post_url="<?php echo base_url('admin/t33/sys/contract/api_contract_list')?>";
                var th_str = "<th></th><th>序号</th><th>批次号</th><th>领用日期</th><th>合同类型</th><th>前缀</th><th>合同编号</th><th>作废时间</th><th>作废人</th><th>使用部门</th><th>分配人</th><th>操作</th>";
                $("#add_invoice").hide();
                $("#input_people").hide();
                $("#input_date").hide();
                $("#num").hide();
                $("#receive_depart").show();
                $("#receive_date").show();
                $("#receive_people").show();
                $("#order_sn").show();
                $("#prefix").show();
                $("#contract_sn").show();
            }
            $("#show_thd").html(th_str);
        	var list_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var total_page=list_data.data.total_page; //总页数
        	//调用分页
        	laypage({
        	    cont: 'page_div',
        	    pages: total_page,
        	    jump: function(ret){
        	    		var html="";  //html内容
		        	ajax_data.page=ret.curr; //页数
		        	var return_data=null;  //数据
		        	if(ret.curr==1){
		        	     return_data=list_data;
		        	}else{
		        	     return_data=object.send_ajax(post_url,ajax_data);
			}
		        	//写html内容
		        	if(return_data.code=="2000"){
		        	     if(type==0){//未领用
                                                $("#write_off").hide();
                                                //$("#add_invoice").show();
                                                html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
                                            }else if(type==1){//已领用
                                                $("#write_off").hide();
                                                //$("#add_invoice").hide();
                                                html=object.pageData1(ret.curr,return_data.data.page_size,return_data.data.result);
                                            }else if(type==2){//未核销
                                                $("#write_off").show();
                                                //$("#add_invoice").hide();
                                                html=object.pageData2(ret.curr,return_data.data.page_size,return_data.data.result);
                                            }else if(type==3){//已核销
                                                $("#write_off").hide();
                                                //$("#add_invoice").hide();
                                                html=object.pageData3(ret.curr,return_data.data.page_size,return_data.data.result);
                                            }else{//已作废
                                                $("#write_off").hide();
                                                //$("#add_invoice").hide();
                                                html=object.pageData4(ret.curr,return_data.data.page_size,return_data.data.result);
                                            }
                                        $(".no-data").hide();
		        	}else if(return_data.code=="4001"){
                                                $("#write_off").hide();
			        	html="";
			        	$(".no-data").show();
			 }else{
                                                $("#write_off").hide();
		        		layer.msg(return_data.msg, {icon: 1});
		        		$(".no-data").hide();
			}
        	                   $(".data_rows").html(html);
        	    }
        	});
            //end
        },
        pageData:function(curr,page_size,data){  //未领用生成表格数据
    	 var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++){
        	        str += "<tr class='order_type2'>";
        	        str +=     "<td>"+data[i].id+"</td>";
                    str +=     "<td>"+data[i].batch+"</td>";
        	        str +=     "<td>"+data[i].addtime+"</td>";
         	        str +=     "<td >"+data[i].contract_name+"</td>";
         	       // str +=     "<td><a href='javascript:void(0)' onclick='show_contract_list(this)' data-id='"+data[i].id+"'>"+data[i].prefix+"</a></td>";
          	       str +=     "<td style='color:#09c;'>"+data[i].prefix+"</td>";
          	        str +=     "<td>"+data[i].start_code+" ~ "+data[i].end_code+"</td>";
         	        //str +=     "<td>"+data[i].end_code+"</td>";
         	        str +=     "<td>"+data[i].num+"</td>";
        	        str +=     "<td>"+data[i].use_num+"</td>";
                    str +=     "<td>"+data[i].cu_use_num+"</td>";
                    var no_use_num = data[i].use_num-data[i].cu_use_num;
                    str +=     "<td>"+no_use_num+"</td>";
        	        str +=     "<td>"+data[i].employee_name+"</td>";
        	        str +=     "<td>"+data[i].remark+"</td>";
        	        //操作
        	         var use_str="<a href='javascript:void(0)' class='a_order' onclick='received(this)' data-id='"+data[i].id+"'>领用</a>";
                    if(parseInt(data[i].use_num)>=parseInt(data[i].num))
                    	use_str="<span style='color:#999'>已领完</span>&nbsp;"+"<a href='javascript:void(0)' class='a_order' onclick='show_detail(this)' data-id='"+data[i].id+"'>领用记录</a>";;
                   str +=     "<td><a href='javascript:void(0)' class='a_order' onclick='show_contract_list(this)' data-id='"+data[i].id+"'>查看</a>"+use_str+"</td>";
        	       str += "</tr>";
        	    }
        	    return str;
        },
         pageData1:function(curr,page_size,data){  //已领用生成表格数据
         var str = '', last = curr*page_size - 1;
                last = last >= data.length ? (data.length-1) : last;
                for(var i = 0; i <= last; i++){
                    str += "<tr class='order_type2'>";
                    str +=     "<td>"+data[i].id+"</td>";
                    str +=     "<td>"+data[i].batch+"</td>";
                    str +=     "<td>"+data[i].addtime+"</td>";
                    str +=     "<td >"+data[i].contract_name+"</td>";
                    //str +=     "<td>"+data[i].prefix+"</td>";
                    str +=     "<td style='color:#09c;'>"+data[i].prefix+"</td>";
                    str +=     "<td>"+data[i].start_code+" ~ "+data[i].end_code+"</td>";
                    str +=     "<td>"+data[i].total_num+"</td>";
                    str +=     "<td>"+data[i].use_start_code+" ~ "+data[i].use_end_code+"</td>";
                    //str +=     "<td>"+data[i].end_code+"</td>";
                   
                    str +=     "<td>"+data[i].receive_num+"</td>";
                    str +=     "<td>"+data[i].employee_name+"</td>";
                    str +=     "<td>"+data[i].depart_name+"</td>";
                    str +=     "<td>"+data[i].employee_name+"</td>";
                    str +=     "<td>"+data[i].use_num+"</td>";
                    str +=     "<td>"+data[i].cancel_num+"</td>";
                    str +=     "<td>"+data[i].remark+"</td>";
                    //操作
                   str +=     "<td><a href='javascript:void(0)' class='a_order' onclick='show_contract_list(this)' data-useid='"+data[i].use_id+"'>查看</a><a href='javascript:void(0)' class='a_order' onclick='recycle(this)' data-usenum='"+data[i].use_num+"' data-useid='"+data[i].use_id+"' data-id='"+data[i].id+"'>收回</a></td>";
                   str += "</tr>";
                }
                return str;
        },
         pageData2:function(curr,page_size,data){  //未核销生成表格数据
         var str = '', last = curr*page_size - 1;
                last = last >= data.length ? (data.length-1) : last;
                for(var i = 0; i <= last; i++){
                    str += "<tr class='order_type2'>";
                    if(data[i].confirm_status==1 && data[i].cancel_status==0){
                        str +=     "<td><input type='checkbox' value='"+data[i].id+"' name='choose_invoce' onclick='choose_contract(this)'/></td>";
                    }else{
                        str +=     "<td></td>";
                    }

                    str +=     "<td>"+data[i].id+"</td>";
                    str +=     "<td>"+data[i].batch+"</td>";
                    str +=     "<td >"+data[i].ordersn+"</td>";
                    str +=     "<td>"+data[i].contract_name+"</td>";
                    //str +=     "<td>"+data[i].prefix+"</td>";
                    str +=     "<td style='color:#09c;'>"+data[i].prefix+"</td>";
                    str +=     "<td>"+data[i].contract_code+"</td>";
                    str +=     "<td>"+data[i].use_time+"</td>";
                    str +=     "<td>"+data[i].expert_name+"</td>";
                    str +=     "<td>"+data[i].depart_name+"</td>";
                    str +=     "<td>"+data[i].assign_people+"</td>";
                    //操作
                     if(/*data[i].confirm_status!=2 && data[i].use_id>0 &&*/ data[i].confirm_status==1&&data[i].cancel_status==0){
                        str += "<td><a href='javascript:void(0)' style='cursor:pointer' class='a_order' onclick='cancel_contract(this)' data-useid='"+data[i].use_id+"' data-id='"+data[i].id+"'>作废</a></td>";
                    }else{
                        str += "<td></td>";
                    }
                    str +=     "</tr>";
                }
                return str;
        },
         pageData3:function(curr,page_size,data){  //已核销生成表格数据
         var str = '', last = curr*page_size - 1;
                last = last >= data.length ? (data.length-1) : last;
                for(var i = 0; i <= last; i++){
                    str += "<tr class='order_type2'>";
                    str +=     "<td>"+data[i].id+"</td>";
                   str +=     "<td>"+data[i].batch+"</td>";
                    str +=     "<td >"+data[i].ordersn+"</td>";
                    str +=     "<td>"+data[i].contract_name+"</td>";
                    //str +=     "<td>"+data[i].prefix+"</td>";
                    str +=     "<td style='color:#09c;'>"+data[i].prefix+"</td>";
                    str +=     "<td>"+data[i].contract_code+"</td>";
                    str +=     "<td>"+data[i].use_time+"</td>";
                    str +=     "<td>"+data[i].expert_name+"</td>";
                    str +=     "<td>"+data[i].depart_name+"</td>";
                    str +=     "<td>"+data[i].write_off_people+"</td>";
                    str +=     "<td>"+data[i].modtime+"</td>";
                   str += "</tr>";
                }
                return str;
        },
         pageData4:function(curr,page_size,data){  //已作废生成表格数据
         var str = '', last = curr*page_size - 1;
                last = last >= data.length ? (data.length-1) : last;
                for(var i = 0; i <= last; i++){
                    str += "<tr class='order_type2'>";
                    if(data[i].confirm_status==1 && data[i].cancel_status==0){
                        str +=     "<td><input type='checkbox' value='"+data[i].id+"' name='choose_invoce' onclick='choose_contract(this)'/></td>";
                    }else{
                        str +=     "<td></td>";
                    }
                    str +=     "<td>"+data[i].id+"</td>";
                    str +=     "<td>"+data[i].batch+"</td>";
                    str +=     "<td >"+data[i].use_time+"</td>";
                    str +=     "<td>"+data[i].contract_name+"</td>";
                    //str +=     "<td>"+data[i].prefix+"</td>";
                    str +=     "<td style='color:#09c;'>"+data[i].prefix+"</td>";
                    str +=     "<td>"+data[i].contract_code+"</td>";
                    str +=     "<td>"+data[i].cancle_time+"</td>";
                    str +=     "<td>"+data[i].cancle_people+"</td>";
                    str +=     "<td>"+data[i].depart_name+"</td>";
                    str +=     "<td>"+data[i].assign_people+"</td>";
                    //操作
                   str +=     "<td><a href='javascript:void(0)' class='a_order' onclick='show_cancel(this)' data-id='"+data[i].id+"'>已作废</a></td>";
                   str += "</tr>";
                }
                return str;
        },
        send_ajax:function(url,data){  //发送ajax请求，有加载层
        	  layer.load(2);//加载层
	          var ret;
	    	  $.ajax({
	        	 url:url,
	        	 type:"POST",
	             data:data,
	             async:false,
	             dataType:"json",
	             success:function(data){
	            	 ret=data;
                                    //console.log(data);
	            	 setTimeout(function(){
	           		  layer.closeAll('loading');
	           		}, 200);  //0.2秒后消失
	             },
	             error:function(data){
	            	 ret=data;
	            	 //layer.closeAll('loading');
	            	 layer.msg('请求失败', {icon: 2});
	             }

	        	});
	      	return ret;
        },
        send_ajax_noload:function(url,data){  //发送ajax请求，无加载层
      	      //没有加载效果
	var ret;
    	  $.ajax({
        	 url:url,
        	 type:"POST",
             data:data,
             async:false,
             dataType:"json",
             success:function(data){
            	 ret=data;
             },
             error:function(){
            	 ret=data;
             }
        	});
      	return ret;
      }
    };
 //object  end

$(function(){
	object.init();
	//tab切换事件
	$(".itab ul li").click(function(){
	    var value=$(this).attr("static");
	    $(".itab ul").attr("data-value",value);
                $("input[type='text']").val('');
                $("input[type='hidden']").val('');
	    object.init();
  	 });
   	$("#btn_submit").click(function(){
	   object.init();
	});
	//日历控件
	$('.starttime').datetimepicker({
    	   lang:'ch', //显示语言
    	   timepicker:false, //是否显示小时
    	   format:'Y-m-d', //选中显示的日期格式
    	   formatDate:'Y-m-d'
	});
	//日历控件
	$('.endtime').datetimepicker({
        	   lang:'ch', //显示语言
        	   timepicker:false, //是否显示小时
        	   format:'Y-m-d', //选中显示的日期格式
        	   formatDate:'Y-m-d'
	});

            $("#add_contract_form").submit(function(){
                $.post(
                    "<?php echo base_url();?>admin/t33/sys/contract/add_contract",
                     $('#add_contract_form').serialize(),
                     function(data){
                        data = eval('('+data+')');
                        if (data.status == 200){
                            tan_alert(data.msg);
                            //window.location.reload();
                        }else{
                        	tan_alert_noreload(data.msg);
                            //window.location.reload();
                         }
                    }
                    );
                    return false;
            });

            $("#cancel_contract_form").submit(function(){
                $.post(
                    "<?php echo base_url();?>admin/t33/sys/contract/cancel_contract",
                     $('#cancel_contract_form').serialize(),
                     function(data){
                        data = eval('('+data+')');
                        if (data.status == 200){
                        	$('.layui-layer-close').trigger('click');
                            tan_alert_noreload(data.msg);
                            object.init();
                        }else{
                        	$('.layui-layer-close').trigger('click');
                            tan_alert_noreload(data.msg);
                            object.init();
                         }
                    }
                    );
                    return false;
            });

            //合同核销提交
            $("#write_off_form").submit(function(){
                  $.post(
                         "<?php echo base_url();?>admin/t33/sys/contract/write_off_cantract",
                        $('#write_off_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                	$('.layui-layer-close').trigger('click');
                                    tan_alert_noreload(data.msg);
                                    object.init();
                                }else{
                                	$('.layui-layer-close').trigger('click');
                                    tan_alert_noreload(data.msg);
                                    object.init();
                                }
                        }
                    );
                    return false;
            });
            // End 合同核销提交#


               //领用合同提交
            $("#receive_contract_form").submit(function(){
                  $.post(
                         "<?php echo base_url();?>admin/t33/sys/contract/receive_contract",
                        $('#receive_contract_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                     tan_alert(data.msg);
                                     //window.location.reload();
                                }else{
                                    tan_alert_noreload(data.msg);
                                     //window.location.reload();
                                }
                        }
                    );
                    return false;
            });
            // End 领用合同提交#


//旅行社下的营业部的管家
$.post('/admin/t33/sys/contract/get_union_expert_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.realname,
        value : val.id,
        depart_list : val.depart_list,
        union_name : val.union_name,
        union_id : val.union_id,
        depart_name : val.depart_name,
        depart_id : val.depart_id
    });
  });
  var comboBox = new jQuery.comboBox({
      id : "#choose_receive_people",
      name : "choose_expert_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {
        $("#choose_receive_depart").html(item.depart_name);
        $("#choose_depart_id").val(item.depart_id);
        $("#choose_depart_name").val(item.depart_name);
        $("#choose_depart_list").val(item.depart_list);
        //$("#choose_can_num").val(item.);
        //$("#choose_depart_list").val(item.depart_list);
      }, // 选择后的事件
      data : array
  });
});
});

</script>
</html>


