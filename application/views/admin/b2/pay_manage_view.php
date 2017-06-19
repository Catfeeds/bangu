<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('assets/js/base.js'); ?>"></script>
<style type="text/css">
.page-body{ padding: 20px; }
.x-grid-cell .check_order_id{opacity: 5;height: auto;position: static;cursor: pointer;}
.DTTTFooter{ border: none; background: #fff; padding: 0;}
.this_btn{ position: absolute; bottom:45px; left: 50%; margin-left: -60px;}
.table thead>tr>th{background-color: #fff}
.table_content { padding:0px;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.boostCenter{ padding: 20px 0; padding-bottom: 0;}
.xdsoft_datetimepicker{z-index: 111111111;}
.form-group input, .form-group label{ float: left;}
.formBox{ padding:0 10px 10px;}
.tableBox { padding:0 10px 15px; background: #fff;}
.order_info_title{ text-align:right; padding-right:10px;background: #f8f8f8;width:100px;}
.shengri_pt{ height:30px; line-height:30px; margin:5px 0}
.paddinrRight{ padding-left:10px}
.btn-palegreen{ background-color:#0099CC !important; border-color:#09c !important;}
.btn-palegreen:hover{ background-color:#0099CC !important; border-color:#09c !important; opacity:0.9;}
.order_info_table td{ padding:0 10px; border:1px solid #f2f2f2;}
.order_info_table tr td { font-family: "tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif";}
.fb-content .box-title, .form-box .box-title{ border-bottom:none;}
.box-title h4{ margin:0}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
input{ line-height:100%\9;}
#single_water{ width: 180px;}
#show_pic_modal{ position: fixed; top: 50px; left: 50%; margin-left: -280px; z-index: 20000000 !important; background: #fff;-webkit-background-clip: content; box-shadow: 1px 1px 50px rgba(0, 0, 0, .3);border-radius: 2px;-webkit-animation-fill-mode: both;animation-fill-mode: both; -webkit-animation-duration: .3s;animation-duration: .3s;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.formBox label { width:80px;}
table tr td i{color:red;margin-right:2px;}
</style>

<!--=================右侧内容区================= -->
<?php $this->load->view("admin/b2/common/js_view"); //加载公用css、js   ?>

<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
        <li class="active">交款管理</li>
    </ul>
</div>
    <div class="page-body" id="bodyMsg">
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray ">
	       <div class="table_content">
	            <ul class="tab_nav nav nav-tabs tab_shadow clear" id="myTab">
	                <li name="tabs" class="active tab_red" id="tab_list1" status="1"><a href="###">未提交</a></li>
	                 <li name="tabs"  class="tab-blue" id="tab_list2" status="2"><a href="###">已提交</a></li>
	                 <li name="tabs"  class="tab-blue" id="tab_list2" status="3"><a href="###">已通过</a></li>
	                 <li name="tabs"  class="tab-blue" id="tab_list2" status="4"><a href="###">已拒绝</a></li>
	            </ul>
            <div class="tab_content">
                <!-- 未提交 -->
                <div class="table_list" id="list1">
                  <form action="<?php echo base_url();?>admin/b2/pay_manage/ajax_pay_order" id='pay_order1' name='pay_order1' method="post" >
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <div class="formBox">
                        <div class="form-group">
		                    <label class="search_title col_span" >订单编号:</label>
		                    <input type="text" name="order_sn" class="form-control ie8_input" style="width:120px;" >
		             </div>
		             <div class="form-group">
	                       <label class="search_title col_span" >收款日期:</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
	                       <label style="border:none;width:auto;">-</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
                   	</div>
		              <div class="form-group">
                              <label class="search_title col_span" >收款人:</label>
                              <select name="expert" class="ie8_select">
                                  <option value=''>--请选择--</option>
                                <?php if(!empty($expert_info)):?>
                                  <?php foreach($expert_info AS $val):?>
                                  <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                              </select>
                        </div>
                        <input type="hidden" name="receive_status" value="0">
                        <div class="form-group">
		                	<button type="button" class="btn btn-darkorange" id="searchBtn1"> 搜索 </button>
                          </div>
                          </div>
                        <div id="pay_order_dataTable1"><!--列表数据显示位置--></div>
                        <div class="row DTTTFooter">
                        	<div class="col-sm-6 ie8_pageBox" style=" padding-top: 24px;">
	                          <a class=" btn btn-palegreen palegreen_xiugai btn_open_submit" id="submit_order">提交审核</a>
	                          <a class=" btn btn-palegreen palegreen_xiugai btn_open_hand">新增银行认款</a>
                                    <span style="margin-left: 10px; color:blue;font-size: 16px">本次交款金额：<span id="this_time_amount" style="color:red;font-size: 16px">0</span>   </span>
	                     </div>
                            <div class="col-sm-6">
                                <div class="dataTables_paginate paging_bootstrap" style=" text-align:center">
                                    <!-- 分页的按钮存放 -->
                                    <ul class="pagination"> </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--  End 未提交  -->
                <!-- 已提交 -->
                <div class="table_list" id="list2" style="display: none">
                    <form action="<?php echo base_url();?>admin/b2/pay_manage/ajax_pay_order" id='pay_order2' name='pay_order2' method="post" >
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
				<div class="formBox">
                        <div class="form-group">
		                    <label class="search_title col_span" >订单编号:</label>
		                    <input type="text" name="order_sn" class="form-control ie8_input" style="width:120px;" >
		             </div>
		             <div class="form-group">
	                       <label class="search_title col_span" >收款日期:</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime2" name="starttime" />
	                       <label style="border:none;width:auto;">-</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime2" name="endtime" />
                   	</div>
		              <div class="form-group">
                              <label class="search_title col_span" >收款人:</label>
                              <select name="expert" class="ie8_select">
                                  <option value=''>--请选择--</option>
                                <?php if(!empty($expert_info)):?>
                                  <?php foreach($expert_info AS $val):?>
                                  <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                              </select>
                        </div>
                        <input type="hidden" name="receive_status" value="1">
                        <div class="form-group">
		                	<button type="button" class="btn btn-darkorange" id="searchBtn2"> 搜索 </button>
                          </div>
                          </div>
                        <div id="pay_order_dataTable2"><!--列表数据显示位置--></div>
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
                <!-- End 已提交 -->
                 <!-- 已通过 -->
                <div class="table_list" id="list3" style="display: none">
                    <form action="<?php echo base_url();?>admin/b2/pay_manage/ajax_pay_order" id='pay_order3' name='pay_order3' method="post" >
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <div class="formBox">
                        <div class="form-group">
		                    <label class="search_title col_span" >订单编号:</label>
		                    <input type="text" name="order_sn" class="form-control ie8_input" style="width:120px;" >
		             </div>
		             <div class="form-group">
	                       <label class="search_title col_span" >收款日期:</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime3" name="starttime" />
	                       <label style="border:none;width:auto;">-</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime3" name="endtime" />
                   	</div>
		              <div class="form-group">
                              <label class="search_title col_span" >收款人:</label>
                              <select name="expert" class="ie8_select">
                                  <option value=''>--请选择--</option>
                                <?php if(!empty($expert_info)):?>
                                  <?php foreach($expert_info AS $val):?>
                                  <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                              </select>
                        </div>
                        <input type="hidden" name="receive_status" value="2">
                        <div class="form-group">
		                	<button type="button" class="btn btn-darkorange" id="searchBtn3"> 搜索 </button>
                          </div>
                          </div>
                        <div id="pay_order_dataTable3"><!--列表数据显示位置--></div>
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
                <!-- End 已通过 -->
                 <!-- 已拒绝 -->
                <div class="table_list" id="list3" style="display: none">
                    <form action="<?php echo base_url();?>admin/b2/pay_manage/ajax_pay_order" id='pay_order4' name='pay_order4' method="post" >
                        <!-- 其他搜索条件,放在form 里面就可以了 -->
                        <div class="formBox">
                        <div class="form-group">
		                    <label class="search_title col_span" >订单编号:</label>
		                    <input type="text" name="order_sn" class="form-control ie8_input" style="width:120px;" >
		             </div>
		             <div class="form-group">
	                       <label class="search_title col_span" >收款日期:</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime3" name="starttime" />
	                       <label style="border:none;width:auto;">-</label>
	                       <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime3" name="endtime" />
                   	</div>
		              <div class="form-group">
                              <label class="search_title col_span" >收款人:</label>
                              <select name="expert" class="ie8_select">
                                  <option value=''>--请选择--</option>
                                <?php if(!empty($expert_info)):?>
                                  <?php foreach($expert_info AS $val):?>
                                  <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
                                <?php endforeach;?>
                                <?php endif;?>
                              </select>
                        </div>
                        <input type="hidden" name="receive_status" value="3">
                        <div class="form-group">
		                	<button type="button" class="btn btn-darkorange" id="searchBtn3"> 搜索 </button>
                          </div>
                          </div>
                        <div id="pay_order_dataTable4"><!--列表数据显示位置--></div>
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
                <!-- End 已拒绝 -->
            </div>
        </div>
                </div>
              </div>



<div class="fb-content" id="receive_order_form" style="display:none;">
    <div class="box-title">
        <h4>提交审核</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
    <form  class="form-horizontal" action="#" id='pay_order_ids' name='pay_order_ids' method="post">
        <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">提交日期:</td>
                        <td id="now_date"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">交款金额:</td>
                        <td id="total_amount" style="color:red"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">交款备注:</td>
                        <td><input type="text" name="remark" style="width:95%;height: 100%"/></td>
                    </tr>

                </table>
                <div style="text-align:center;">
                  <input type="hidden" name="receive_ids" id="receive_ids" value=""/>
                  <input type="hidden" name="receive_price" id="receive_price" value="0"/>
                  <input type="hidden" name="submit_date" id="submit_date" value=""/>
                  <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交审核" style="margin:20px 0px;">
                </div>
              </form>
    </div>
</div>


<div class="fb-content" id="receive_detail" style="display:none;">
    <div class="box-title">
        <h4>交款详情</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form" style=" margin:15px;">
     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="border:1px solid #ddd">
                    <tr height="40">
                        <td class="order_info_title">编号:</td>
                        <td id="show_receive_sn" colspan=3></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">交款日期:</td>
                        <td id="receive_date"></td>
                        <td class="order_info_title">交款金额:</td>
                        <td id="receive_amount"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">交款人:</td>
                        <td id="receive_people"></td>
                        <td class="order_info_title">营业部:</td>
                        <td id="receive_depart"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">交款方式:</td>
                        <td id="receive_way" colspan=3></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">票据信息:</td>
                        <td id="receive_info" colspan=3></td>
                    </tr>
                    <tr height="20">
                        <td class="order_info_title">流水单:</td>
                        <td id="receive_info" colspan=3>
                          <a   data-pic="" onclick="show_water_pic(this)">查看</a>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td id="receive_remark" colspan=3></td>
                    </tr>
                </table>
    </div>
</div>

<div class="fb-content" id="new_payment_modal" style="display:none;">
    <div class="box-title">
        <!-- <h4>充值账户余额</h4> -->
        <h4>新增银行认款</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form" style=" overflow: hidden; padding:15px;">
    <form  class="form-horizontal" action="#" id='new_payment_form' name='new_payment_form' method="post">
        <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="border: 1px solid #ddd">
                    <tr height="40">
                         <td class="order_info_title">认款日期<i>*</i>:</td>
                        <td colspan="3" style="" class="paddinrRight">
                              <input type="text" id="datetimepicker"   class="shengri_pt date-time" name="pay_date">
                        </td>
                        <td class="order_info_title">认款金额<i>*</i>:</td>
                        <td colspan="3" style="" class="paddinrRight">
                              <input type="text" name="pay_amount" class="shengri_pt date-time" value="" style="width:160px;">
                        </td>
                    </tr>
                    <tr height="40">
                         <td class="order_info_title">认款人:</td>
                        <td colspan="3" style="" class="paddinrRight"><?php echo $real_name?></td>
                        <td class="order_info_title">营业部:</td>
                        <td colspan="3" style="" class="paddinrRight"><?php echo $depart_info['name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">认款方式<i>*</i>:</td>
                        <td  colspan="5" class="paddinrRight">
                                <select name="pay_way" id="pay_way" class="ie8_select">
                                  <!-- <option value="现金">现金</option>  -->
                                  <option value="转账">转账</option>
                                </select>
                                <input type="text" style=" padding:5px 10px" name="bank_info" id="bank_info" placeholder="开户银行" value=""/>
                              <input type="text" style=" padding:5px 10px" name="bank_num" id="bank_num" placeholder="银行账号" value=""/>
                        </td>
                    </tr>
              
                     <tr height="40">
                        <td class="order_info_title">是否加急:</td>
                        <td colspan="5"><input type="checkbox" name="is_urgent" value='1' style="opacity:1;position: static;"/></td>
                    </tr>
                   <!--  <tr height="40">
                       <td class="order_info_title">收款单号:</td>
                       <td colspan="5"><input type="text" name="voucher" style="width:95%;height: 30px"/></td>
                   </tr> -->
                  <tr height="40">
                        <td class="order_info_title">流水单<i>*</i>:</td>
                        <td colspan="5">
                        
                            <input name="single_water" id="single_water" onchange="upload_water(this);" type="file" style="float: left;margin:4px auto;">
                            <input name="single_water_pic" type="hidden" id="single_water_pic" />
                            
                            <div style="display: none;width:366px;float:right;" id="code_div">
                            
                             <img src="" id="code_pic" style="height:80px;float:left;margin:5px auto;" />
                             <a  id="show_water_pic" data-pic="" onclick="show_water_pic(this)" style="margin-top: 68px;margin-left: 5px;float:left;">查看大图</a>
                            </ddiv>
                        </td>
                       
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td colspan="5"><input type="text" name="pay_remark" style="width:95%;height: 30px;"/></td>
                    </tr>
                </table>
                <div style="text-align:center;">
                  <input type="hidden" name="pay_sn" id="pay_sn" value=""/>
                  <input type="hidden" name="union_id" id="union_id" value="<?php echo $depart_info['union_id']?>"/>
                  <input type="hidden" name="depart_id" id="depart_id" value="<?php echo $depart_info['id']?>"/>
                  
                  <input type="hidden" name="submit_type" id="submit_type" value="1"/>
                  <input type="button"  id="input_save" class="btn btn-palegreen"   value="保存" style="margin:20px 0px;">
                  <input type="button"  id="input_save_submit" class="btn btn-palegreen"   value="保存并提交" style="margin:20px 15px;">
                </div>
              </form>
    </div>
</div>

<!--***************************************Start 显示流水单******************************************************-->
<div class="fb-content" id="show_pic_modal" style="display:none; width: 340px;">
    <div class="box-title">
        <h4>流水单</h4>
        <span class="layui-layer-setwin">
            <a class="show_pic_modal_close">×</a>
        </span>
    </div>
    <div class="fb-form" style=" margin:15px;">
      <img src="" style="width:300px; height:300px">
    </div>
</div>
<!--***************************************End 显示流水单******************************************************-->

 <?php echo $this->load->view('admin/a/common/time_script'); ?>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>

//上传流水单
function upload_water(obj){
  var file_id = $(obj).attr("id");
  var inputObj = $(obj).nextAll("input[type='hidden']");
  $.ajaxFileUpload({
      url : '/admin/upload/uploadImgFile',
      secureuri : false,
      fileElementId : file_id,// file标签的id
      dataType : 'json',// 返回数据的类型
      data : {
        fileId : file_id
      },
      success : function(data, status) {
        if (data.code == 2000) {
          //inputObj.after("<span style='color:blue'>已上传</span>");
          inputObj.val(data.msg);
          $("#show_water_pic").attr('data-pic',data.msg);
          var bangu_url="<?php echo base_url();?>";
          $("#code_pic").attr("src",bangu_url+data.msg);
          $("#code_div").css("display","block");
          $("#single_water").css("margin","34px auto");
        } else {
          tan(data.msg);
        }
      },
      error : function(data, status, e)// 服务器响应失败处理函数
      {
        tan('上传失败(请选择jpg/jpeg/png的图片重新上传)');
      }
  });
}
//查看流水单图片：大图
function show_water_pic(obj){
        var pic_url = $(obj).attr('data-pic');
        if(pic_url==null || pic_url==""){
             tan('暂无流水单图片');
            return false;
        }else{
            $("#show_pic_modal").find('img').attr('src',pic_url);
            $("#show_pic_modal").show();
        }
}
// 获得充值方式：银行名称、银行卡号
function change_pay_way(){
       $.post("<?php echo base_url();?>admin/b2/pay_manage/get_depart_bank",{},function(data){
                          data = eval('('+data+')');
                          $("#bank_info").val(data['bankname']);
                          $("#bank_num").val(data['bankcard']);
                           $("#bank_info").show();
                           $("#bank_num").show();
                      }
             );      
}
//交款详情
function show_record(obj){
          var receive_id = $(obj).attr('data-id');
          $.post("<?php echo base_url();?>admin/b2/pay_manage/get_one_detail",
                      {'receive_id':receive_id},
                      function(data){
                          data = eval('('+data+')');
                          $("#show_receive_sn").html(data['voucher']);
                          $("#receive_date").html(data['addtime']);
                          $("#receive_amount").html(data['money']);
                          $("#receive_people").html(data['realname']);
                          $("#receive_depart").html(data['depart_name']);
                          $("#receive_way").html(data['way']);
                          $("#receive_info").html(data['invoice_type']+"   "+data['invoice_code']);
                          $("#receive_remark").html(data['remark']);
                          $("#receive_detail").find('a').attr('data-pic',data['code_pic']);
                           layer.open({
                              type: 1,
                              title: false,
                              closeBtn: 0,
                              area: '560px',
                              shadeClose: false,
                              content: $('#receive_detail')
                      });
                      }
                );
}
//交款全选：计算价格
function check(obj){
    if($(obj).is(':checked')){
         $("#receive_ids").val($("#receive_ids").val()+$(obj).val()+",");
          $("#receive_price").val(Number($(obj).attr('data-price'))+Number($("#receive_price").val()));
          $("#this_time_amount").html(Number($(obj).attr('data-price'))+Number($("#this_time_amount").html()));
          $("#total_amount").html(Number($(obj).attr('data-price'))+Number($("#total_amount").html()));
    }else{
          $("#receive_price").val(Number($("#receive_price").val())-Number($(obj).attr('data-price')));
          $("#receive_ids").val($("#receive_ids").val().replace($(obj).val()+',',''));
          $("#this_time_amount").html(Number($("#this_time_amount").html())-Number($(obj).attr('data-price')));
          $("#total_amount").html(Number($("#total_amount").html())-Number($(obj).attr('data-price')));
    }
}

//交款全选
function check_all(obj){
	    var is_check = $(obj).attr('data-check');
	    var total_amount = 0;
	    if($(obj).is(':checked')){
	        $("input[type='checkbox']").attr("checked", true);
	        var chks=$("input:checked");
	         $.each(chks, function(){
	            if($(this).val()!='check_all' && $(this).attr('name')!='is_urgent'){
	                $("#receive_ids").val($("#receive_ids").val()+$(this).val()+",");
	                total_amount = Number(total_amount) + Number($(this).attr('data-price'));
	            }
	        });
	         $("#total_amount").html(total_amount);
	         $("#receive_price").val(total_amount);
	         $("#this_time_amount").html(total_amount);
	    }else{
	        $("input[type='checkbox']").attr("checked", false);
	        $("#receive_ids").val('');
	        $("#receive_price").val('0');
	        $("#this_time_amount").html('0');
	        $("#total_amount").html('0');
	    }
}


/*function refuse_receive(obj){
    var receive_id = $(obj).attr('data-id');
     $.post("<?php echo base_url();?>admin/b2/pay_manage/refuse_receive",
                      {'receive_id':receive_id},
                      function(data){
                          data = eval('('+data+')');
                          alert(data.msg);
                           window.location.reload();
                      }
                );
}*/

//获取当前日期和时间
function current(){
    var d=new Date(),str='';
    str +=d.getFullYear()+'-'; //获取当前年份
    var month = d.getMonth()+1; //获取当前月份（0——11）
    month =(month<10 ? "0"+month:month);
    str += month+'-';
    str +=d.getDate()+' ';
    str +=d.getHours()+':';
    str +=d.getMinutes()+':';
    str +=d.getSeconds();
    return str;
}
//日历：认款日期
$('#datetimepicker').datetimepicker({
    lang:'ch', //显示语言
    timepicker:false, //是否显示小时
    format:'Y-m-d H:i:s', //选中显示的日期格式
    formatDate:'Y-m-d H:i:s',
    validateOnBlur:false,
    yearStart:1930
});
//日历：开始日期
$('#starttime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
//日历：结束日期
$('#endtime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});

$('#starttime2').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
$('#endtime2').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});

$('#starttime3').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
$('#endtime3').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});


function show_receive(obj){
    var type = $(obj).attr('data-type');
    var item_id = $(obj).attr('data-itemid');
     var rev_status = $(obj).attr('data-status');
    var html = "";
     var status_str = "";
    if(type=='1'){
      $(obj).html('-');
      $(obj).attr('data-type','2');
       $.post("<?php echo base_url();?>admin/b2/pay_manage/get_receiv_detail", { item_id:item_id,rev_status:rev_status} ,
        function(data) {
          data =  eval('('+data+')');
          html = '<tr class="order_table"><td colspan="12" style="padding:0;"><div style="padding:5px 5px 5px 30px;"><table class="table table-bordered" width="100%">';
           html+='<thead class="th-border"><tr>';
           html+='<th>编号</th>';
           html+='<th>交款金额</th>';
           html+='<th>销售名称</th>';
           html+='<th>营业部</th>';
           html+='<th>备注</th>';
           //html+='<th>订单号</th>';
          //html+='<th>团号</th>';
           html+='<th>交款方式</th>';
           html+='<th>添加时间</th>';
           html+='<th>状态</th>';
           html+='</tr></thead><tbody>';
          $.each(data,function(key,val){
             html+='<tr>';
             html+='<td>'+val.id+'</td>';
             html+='<td>'+val.money+'</td>';
             html+='<td>'+val.realname+'</td>';
             html+='<td>'+val.depart_name+'</td>';
             html+='<td>'+val.remark+'</td>';
             html+='<td>'+val.way+'</td>';
              html+='<td>'+val.addtime+'</td>';
              switch(val.status){
                  case "1":
                      status_str = "经理已提交";
                      break;
                  case "2":
                      status_str = "已审核";
                      break;
                  case "3":
                      status_str = "旅行社拒绝";
                      break;
                  case "4":
                      status_str = "经理已拒绝";
                      break;
                  case "5":
                      status_str = "待经理审核";
                      break;
                  case "6":
                      status_str = "供应商拒绝";
                      break;
                  default:
                      status_str ="未提交";
                      break;
              }
               html+='<td>'+status_str+'</td>';
             html+='</tr>';
          });
           html+='</tbody></table></div></td></tr>';
           $(obj).parent().parent().parent().after(html);
       });
    }else{
      $(obj).html('+');
      $(obj).attr('data-type','1');
      $(obj).parent().parent().parent().next().remove();
    }
}

/*
*银行认款（充值余额）:提交处理
*/
function receive_submit()
{
		 if($("#datetimepicker").val()==""){tan("交款日期必填");return false;}
	     if($("#new_payment_form").find("input[name='pay_amount']").val()==""){tan("交款金额必填"); return false; }
	     if($("#pay_way").val()=="转账")
		 {
	           if($("#bank_info").val()==""){tan("开户银行必填");return false;}
	           if($("#bank_num").val()==""){ tan("银行账号必填");return false;}
	     }
	     if($("#single_water_pic").val()==""){tan("请上传流水单");return false;}
	     $.post(
	               "<?php echo base_url();?>admin/b2/pay_manage/new_payment",
	               $('#new_payment_form').serialize(),
	               function(data){
	                       data = eval('('+data+')');
	                       if (data.status == 200)
		                   {
	                    	   tan_alert(data.msg);
	                       }
	                       else
		                   {
	                    	   tan(data.msg);
	                       }
	               }
	           );
	      return false;
}


$(document).ready(function(){
	       change_pay_way(); //获得充值方式：银行名称、银行卡号
	       //打开银行认款窗口
	       $("body").on("click",".btn_open_hand",function(){
	    	   layer.open({
                   type: 1,
                   title: false,
                   closeBtn: 0,
                   area: '760px',
                   shadeClose: false,
                   content: $('#new_payment_modal')
         		});
	       });
           //新增加交款申请: “保存”按钮
           $("body").on("click","#input_save",function(){
        	var flag = COM.repeat('btn');//频率限制
           	if(!flag)
           	{
        	   $("#submit_type").val("1");
        	   receive_submit();
           	}
           	
           });
          //新增加交款申请: “保存并提交”按钮
           $("body").on("click","#input_save_submit",function(){
        	   var flag = COM.repeat('btn');//频率限制
               if(!flag)
               {
	               $("#submit_type").val("2");
	        	   receive_submit();
               }
               
           });
           //打开提交审核窗口
	       $("body").on("click",".btn_open_submit",function(){
		   
	    	   if($("#receive_ids").val()!=""){
	    	        var now_date = current();
	    	        $("#now_date").html(now_date);
	    	        $("#total_amount").html($("#receive_price").val());

	    	        $("#submit_date").val(now_date);
	    	          layer.open({
	    	                    type: 1,
	    	                    title: false,
	    	                    closeBtn: 0,
	    	                    area: '560px',
	    	                    shadeClose: false,
	    	                    content: $('#receive_order_form')
	    	          });
	    	        }else{
	    	          tan('请选择要提交的交款！');
	    	       }
	       });
           //经理申请提交: “提交审核”按钮
            $("#pay_order_ids").submit(function(){
                  $.post(
                         "<?php echo base_url();?>admin/b2/pay_manage/submit_apply",
                        $('#pay_order_ids').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                	tan_alert(data.msg);
                                }else{
                                	tan(data.msg);
                                	
                                }
                        }
                    );
                    return false;
            });
            // End 经理申请提交#

  // 列数据映射配置：交款管理列表数据
  var columns_1=[
    {field : 'id',title : "<input type='checkbox' style='position:static;opacity:5;width:18px;height:13px' class='check_order_id'  onclick='check_all(this)' value='check_all'/>",width : '2%',align : 'center',
              formatter: function(value,rowData,rowIndex){
                     return "<input type='checkbox' class='check_order_id' onclick='check(this)' data-price="+rowData['toal_money']+"  value="+value+">";
              }
          },
       {field : 'id',title : '',width : '1%',align : 'center',
              formatter : function(value,rowData, rowIndex){
                  if(value!=null && value!=0 && value!=undefined && value!=''){
                    return "<span class='con_txt' onclick='show_receive(this);'  style='font-size:17px;cursor:pointer;width:100%;height:100%' data-type='1' data-status='0'  data-itemid='"+value+"'>+</span>";
                  }else{
                    return '';
                  }
                 }
        },
      {field : 'order_sn',title : '订单号',width : '3%',align : 'center',formatter:function(value,rowData,rowIndex){
            var html = "";
            html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
                        return html;
             }
        },
      {field : 'productname',title : '线路名称',width : '8%',align : 'center',
          formatter : function(value,  rowData, rowIndex){
              if(value==null || value=="" || value==undefined){
                  return '无';
              }else{
                  return value;
              }
         }},
       {field : 'addtime',title : '交款日期',width : '3%',align : 'center'},
      {field : 'toal_money',title : '交款金额',width : '2%',align : 'right'},
      {field : 'way',title : '交款方式',align : 'center', width : '3%',
          formatter : function(value,  rowData, rowIndex){
              if(value==null || value=="" || value==undefined){
                  return '无';
              }else{
                  return value;
              }
         }
     },
      {field : 'bankcard',title : '银行卡号',align : 'center', width : '6%',
          formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
      },
       {field : 'bankname',title : '交款银行',align : 'center', width : '3%',
         formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
        },
        {field : 'depart_name',title : '交款部门',align : 'center', width : '3%'},
        {field : 'realname',title : '交款人',align : 'center', width : '2%'},
        {field : 'remark',title : '备注',align : 'center', width : '6%'}
      ];

      var columns_2=[
      		{field : 'id',title : '',width : '1%',align : 'center',
              formatter : function(value,rowData, rowIndex){
                  if(value!=null && value!=0 && value!=undefined && value!=''){
                    return "<span class='con_txt' onclick='show_receive(this);'  style='font-size:17px;cursor:pointer;width:100%;height:100%' data-type='1' data-status='1'  data-itemid='"+value+"'>+</span>";
                  }else{
                    return '';
                  }
                 }
        },
	       {field : 'order_sn',title : '订单号',width : '2%',align : 'center',formatter:function(value,rowData,rowIndex){
            var html = "";
            html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
                        return html;
             }
        },
      {field : 'productname',title : '线路名称',width : '8%',align : 'center',
          formatter : function(value,  rowData, rowIndex){
              if(value==null || value=="" || value==undefined){
                  return '无';
              }else{
                  return value;
              }
         }},
       {field : 'addtime',title : '交款日期',width : '3%',align : 'center'},
      {field : 'toal_money',title : '交款金额',width : '2%',align : 'right'},
      {field : 'way',title : '交款方式',align : 'center', width : '3%',
          formatter : function(value,  rowData, rowIndex){
              if(value==null || value=="" || value==undefined){
                  return '无';
              }else{
                  return value;
              }
         }
     },
      {field : 'bankcard',title : '银行卡号',align : 'center', width : '6%',
          formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
      },
       {field : 'bankname',title : '交款银行',align : 'center', width : '3%',
         formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
        },
        {field : 'depart_name',title : '交款部门',align : 'center', width : '3%'},
        {field : 'realname',title : '交款人',align : 'center', width : '2%'},
        {field : 'remark',title : '备注',align : 'center', width : '6%'}
      ];

      var columns_3=[
	      {field : 'id',title : '',width : '1%',align : 'center',
	              formatter : function(value,rowData, rowIndex){
	                  if(value!=null && value!=0 && value!=undefined && value!=''){
	                    return "<span class='con_txt' onclick='show_receive(this);'  style='font-size:17px;cursor:pointer;width:100%;height:100%' data-type='1' data-status='2'  data-itemid='"+value+"'>+</span>";
	                  }else{
	                    return '';
	                  }
	                 }
	        },
	       {field : 'order_sn',title : '订单号',width : '2%',align : 'center',formatter:function(value,rowData,rowIndex){
            var html = "";
            html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
                        return html;
             }
        },
      {field : 'productname',title : '线路名称',width : '8%',align : 'center',
          formatter : function(value,  rowData, rowIndex){
              if(value==null || value=="" || value==undefined){
                  return '无';
              }else{
                  return value;
              }
         }},
       {field : 'addtime',title : '交款日期',width : '3%',align : 'center'},
      {field : 'toal_money',title : '交款金额',width : '2%',align : 'right'},
      {field : 'way',title : '交款方式',align : 'center', width : '3%',
          formatter : function(value,  rowData, rowIndex){
              if(value==null || value=="" || value==undefined){
                  return '无';
              }else{
                  return value;
              }
         }
     },
      {field : 'bankcard',title : '银行卡号',align : 'center', width : '6%',
          formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
      },
       {field : 'bankname',title : '交款银行',align : 'center', width : '3%',
         formatter : function(value,  rowData, rowIndex){
          if(value=="" || value==undefined){
              return '无';
          }else{
              return value;
          }
         }
        },
        {field : 'depart_name',title : '交款部门',align : 'center', width : '3%'},
        {field : 'realname',title : '交款人',align : 'center', width : '2%'},
        {field : 'remark',title : '备注',align : 'center', width : '6%'}
      ];
      var columns_4=[
           	      {field : 'id',title : '',width : '1%',align : 'center',
           	              formatter : function(value,rowData, rowIndex){
           	                  if(value!=null && value!=0 && value!=undefined && value!=''){
           	                    return "<span class='con_txt' onclick='show_receive(this);'  style='font-size:17px;cursor:pointer;width:100%;height:100%' data-type='1' data-status='2'  data-itemid='"+value+"'>+</span>";
           	                  }else{
           	                    return '';
           	                  }
           	                 }
           	        },
           	       {field : 'order_sn',title : '订单号',width : '2%',align : 'center',formatter:function(value,rowData,rowIndex){
                       var html = "";
                       html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
                                   return html;
                        }
                   },
                 {field : 'productname',title : '线路名称',width : '8%',align : 'center',
                     formatter : function(value,  rowData, rowIndex){
                         if(value==null || value=="" || value==undefined){
                             return '无';
                         }else{
                             return value;
                         }
                    }},
                  {field : 'addtime',title : '交款日期',width : '3%',align : 'center'},
                 {field : 'toal_money',title : '交款金额',width : '2%',align : 'right'},
                 {field : 'way',title : '交款方式',align : 'center', width : '3%',
                     formatter : function(value,  rowData, rowIndex){
                         if(value==null || value=="" || value==undefined){
                             return '无';
                         }else{
                             return value;
                         }
                    }
                },
                 {field : 'bankcard',title : '银行卡号',align : 'center', width : '6%',
                     formatter : function(value,  rowData, rowIndex){
                     if(value=="" || value==undefined){
                         return '无';
                     }else{
                         return value;
                     }
                    }
                 },
                  {field : 'bankname',title : '交款银行',align : 'center', width : '3%',
                    formatter : function(value,  rowData, rowIndex){
                     if(value=="" || value==undefined){
                         return '无';
                     }else{
                         return value;
                     }
                    }
                   },
                   {field : 'depart_name',title : '交款部门',align : 'center', width : '3%'},
                   {field : 'realname',title : '交款人',align : 'center', width : '2%'},
                   {field : 'remark',title : '备注',align : 'center', width : '6%'}
                 ];
var columnArr=[];
columnArr[1] =   columns_1;
columnArr[2] =  columns_2;
columnArr[3] =   columns_3;
columnArr[4] =   columns_4;

  var isJsonp= false ;// 是否JSONP,跨域
  initTableForm("#pay_order1","#pay_order_dataTable1",columns_1,isJsonp ).load();
   //initTableForm("#refund_list1","#refund_list_dataTable1",refund_list_columns,isJsonp ).load();
      $("#myTab li").on("click",function(){
          $("#myTab li").removeClass("active");
          $(this).addClass("active");
          var index=$("#myTab li").index($(this))+1;
        
          initTableForm("#pay_order"+index,"#pay_order_dataTable"+index,columnArr[index],isJsonp ).load();
      });


 $("#searchBtn1").click(function(){
    initTableForm("#pay_order1","#pay_order_dataTable1",columnArr[1],isJsonp ).load();
  });

 $("#searchBtn2").click(function(){
    initTableForm("#pay_order2","#pay_order_dataTable2",columnArr[2],isJsonp ).load();
  });

  $("#searchBtn3").click(function(){
    initTableForm("#pay_order3","#pay_order_dataTable3",columnArr[3],isJsonp ).load();
  });

});
 $(".show_pic_modal_close").click(function(){
      $("#show_pic_modal").hide();
  })
</script>
