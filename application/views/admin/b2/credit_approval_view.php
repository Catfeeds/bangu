
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
.last_time { border:5px solid #000;border-radius:2px;font-size:14px;}
.check_project { position:relative;}
.hide_project_title { display:none;position:absolute;top:15px;left:-235px;width:280px;border:1px solid #94A100;background:#f8f8f8;padding:5px 10px;line-height:25px;border-radius:3px;z-index:999;}
.hide_project_title p { text-align:left;}
.hide_project_title p a { padding-right:15px;}
.hide_project_title p a:hover { text-decoration:underline;}
.hide_project_title p span { padding-right:15px;}
.action_type { position:relative;}
.check_project .action_type i { width: 7px; height: 4px; background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) 0px 0px no-repeat; position: absolute; margin-left: 2px; top: 7px;}
.fa-home:before{ content:""}
#list1 .x-grid-cell-inner .action_type{ width:50%;margin:0;}
#list1 .x-grid-cell-inner a:nth-child(1) { text-align:center;}
.x-grid-cell-inner .check_project { margin:0 10px 0 25px;}
.x-grid-cell-inner .action_type { margin:0 10px;}
.table_list{display:none;}

.breadcrumb { padding-left: 10px;background: #fff none repeat scroll 0% 0%;  height: 40px;line-height: 40px;box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2); -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);-moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);}
.breadcrumb li { float: left;padding-right: 10px;color: #777;-webkit-text-shadow: none;text-shadow: none;}
.breadcrumb>li+li:before {padding: 0 5px;color: #ccc; content: "/\00a0";}
.page-content {display: block;margin-left: 160px;margin-right: 0;margin-top: 0;min-height: 100%; padding: 0;}
.fa-home {width: 17px;height: 18px;position: absolute;left: 0;top: 6px;background: url(../../../../assets/img/home.png) 0 0 no-repeat; display: inline-block; background-size: cover;}

.table_content{ padding: 0}
.page-body{ padding: 20px}
.page-body .nav-tabs{ background: none; box-shadow: none}
.page-body .nav-tabs li{ padding: 0}
.table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px;}
.DTTTFooter{ background: none; box-shadow: none; border: none; padding:0 ;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.tab_content{ padding-bottom: 0;}
.boostCenter{ padding: 20px 0; padding-bottom:8px;}
.search_title .form-group{display: inline-block;float: left}
.x-grid-cell .check_order_id{opacity: 5;height: auto;position: static;cursor: pointer;}

.table_td_border tr td{ border:1px solid #f2f2f2;}
.table_td_border input{ padding:5px 10px}
.order_info_title{ text-align: right;background:#f8f8f8;width:120px;}
.important_title{ padding: 0 3px; color: #f30;font-style: normal;}
.gtivo-left{ padding-left: 10px;}
.form_btn{ margin-bottom: 20px;}
.form_btn input,.form_btn input:hover{ background: #09c; color: #fff; border: none;}
.btn_gray{ margin-left: 50px;}

.btn-palegreen{ background-color:#0099CC !important; border-color:#09c !important;}
.btn-palegreen:hover{ background-color:#0099CC !important; border-color:#09c !important; opacity:0.9;}
.order_info_title{ padding:0 10px;}
.order_info_table td{ padding:0 10px;}
.box-title h4{ margin:0;}


.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
/*进度样式
 * class="on_show" 完全蓝色
 * class="on_show" 一半蓝色  当前进度
 *
 */
.status_box ul{ overflow: hidden; padding-top: 10px;}
.status_box ul li{ width: 25%; float: left; position: relative;}
.status_box ul li .time, .status_box ul li .txt{ width: 100%;height: 20px; display: inline-block; text-align: center; margin-bottom: 30px;}
.status_box ul li .txt{ margin-bottom: 0;}
.status_box ul li i{ width: 20px;height: 20px; line-height: 20px; background: #eee; display: inline-block; position: absolute; top: 25px; left: 50%; margin-left: -10px; border-radius: 50%; z-index: 1;}
.status_box ul li em{ width: 100%;height: 2px; line-height: 20px; background: #eee; display: inline-block; position: absolute; top: 35px; left: 0;}
.status_box ul li strong{ display: none; width: 50%;height: 2px; line-height: 20px; background: #eee; display: inline-block; position: absolute; top: 35px; left: 0;}
.status_box ul li.on i{ background: #09c;}
.status_box ul li.on strong{ background: #09c; width: 50%; left: 0; display: block;}
.status_box ul li.on_show i{ background: #09c;}
.status_box ul li.on_show strong{ background: #09c; width: 100%; left: 0; display: block;}

.xdsoft_datetimepicker{z-index: 111111111;}
.tab_content{ box-shadow: none; background: none; padding: 0;}
.shadow{ background: none;}
.tableBox{ background: #fff; padding:0 10px 15px;}
.form-group label,.form-group input{ float: left;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
.formBox { padding:0 10px 10px;}
/*进度样式
 * <i></i><em></em><strong></strong> 勿删除
 */

/*
<div class="status_box">
    <ul class="clear">
        <li class="on_show">
            <span class="time current_time">2016-8-24 11:03</span><i></i><em></em><strong></strong><span class="txt">新增申请</span>
        </li>
        <li class="on_show">
            <span class="time"></span><i></i><em></em><strong></strong><span class="txt">经理审批</span>
        </li>
        <li class="on"><span class="time"></span><i></i><em></em><strong></strong><span class="txt">旅行社/供应商授权</span></li>
        <li><span class="time"></span><i></i><em></em><strong></strong><span class="txt">已还款</span></li>
    </ul>
</div>
*/

.table tbody tr td a {text-decoration:underline;}

</style>
</head>
<body>
<?php $this->load->view("admin/b2/common/js_view"); //加载公用css、js   ?>
<!--=================右侧内容区================= -->
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
        <li class="active">额度申请</li>
    </ul>
</div>
<div class="page-body" id="bodyMsg">
    <!-- =============== 右侧主体内容  ============ -->
    <div class="page_content bg_gray">
        <div class="table_content">
            <div class="">
                <div class="tab_content">

                    <div class="table_list shadow" id="list" style="background:#fff;">
                    	<div>
	                        <!-- <button class=" btn btn-palegreen palegreen_xiugai" onclick="new_apply()">新增申请</button> -->

	                    </div>
	                    <form action="<?php echo base_url();?>admin/b2/credit_approval/ajax_credit_list" id='credit_approval' name='credit_approval' method="post">
	                     	<!-- 其他搜索条件,放在form 里面就可以了 -->
				            <div class="form-inline formBox ">
					            <div class="form-group">
					                <label class="search_title col_span" >申请单号:</label>
					                <input type="text" name="apply_sn" class="form-control ie8_input" style="width:110px;" >
					            </div>
				                <div class="form-group">
				                    <label class="search_title col_span" >申请日期:</label>
				                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
				                    <label style="border:none ; width:auto;">-</label>
				                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
				                </div>
				                <div class="form-group">
				                    <label class="search_title col_span" >还款日期:</label>
				                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime2" name="starttime2" />
				                    <label style="border:none ; width:auto;">-</label>
				                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime2" name="endtime2" />
				                </div>
				                <div class="form-group">
		                            <label class="search_title col_span" >申请状态:</label>
		                            <select name="apply_status" class="ie8_select">
		                                <option value=''>--请选择--</option>
		                                <option value="0">未提交</option>
		                                <option value="1">申请中</option>
		                                <option value="2">经理拒绝</option>
		                                <option value="3">已授信</option>
		                                <option value="4">已还款</option>
		                                <option value="5">已拒绝</option>
		                                <option value="-1">已撤销</option>
		                            </select>
		                      	</div>
								<div class="form-group">
				                    <label class="search_title col_span" >订单号:</label>
				                    <input class="search-input form-control" style="width:110px;" type="text" id="order_sn" name="order_sn" />
			                  	</div>
			                    <?php if($is_manage==1):?>
			                    <div class="form-group">
		                            <label class="search_title col_span" >申请人:</label>
		                            <select name="expert" class="ie8_select">
		                                <option value=''>--请选择--</option>
		                              	<?php if(!empty($expert_info)):?>
		                                <?php foreach($expert_info AS $val):?>
		                                <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
		                              	<?php endforeach;?>
		                              	<?php endif;?>
		                            </select>
			                    </div>
			                    <?php endif;?>
				                <input type="hidden" name="is_manage" value="<?php echo $is_manage?>"/>
				                <button type="button" class="btn btn-darkorange" id="searchBtn" style="float:left;position: relative; top:10px;"> 搜索 </button>
                                <?php if($is_manage==1):?>
                                <span class=" btn btn-palegreen palegreen_xiugai" onClick="submit_apply()" style="float:left;position: relative; top:10px;margin-left:20px; padding:3px 10px;">提交申请</span>
                                <?php endif;?>
				            </div>
							<div class="tableBox">
								<div id="credit_approval_dataTable"><!--列表数据显示位置--></div>
			                    <div class="row DTTTFooter">
			                        <div class="dataTables_paginate paging_bootstrap" style="float: none;">
				                        <!-- 分页的按钮存放 -->
				                        <div class="boostCenter">
				                        <ul class="pagination"> </ul>
				                        </div>
			                        </div>
			                    </div>
		                    </div>
	                    </form>
                    </div>
                </div>
          	</div>
        </div>
    </div>
</div>


<!--********************************Start信用申请*************************************-->
<div class="fb-content" id="limit_apply" style="display:none;">
    <div class="box-title">
        <h4>新增额度&nbsp;&nbsp;&nbsp;&nbsp;申请单</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
      	<div class="status_box">
	        <ul class="clear">
	            <li class="on">
	                <span class="time current_time"></span><i></i><em></em><strong></strong><span class="txt">新增申请</span>
	            </li>
	            <li >
	                <span class="time"></span><i></i><em></em><strong></strong><span class="txt">经理审批</span>
	            </li>
	           	<li >
	           		<span class="time"></span><i></i><em></em><strong></strong><span class="txt">旅行社/供应商授权</span>
	           	</li>
	           	<li>
	           		<span class="time"></span><i></i><em></em><strong></strong><span class="txt">已还款</span>
	           	</li>
	        </ul>
        </div>
        <form method="post" action="#" id="apply_credit_form" class="form-horizontal">
            <div class="form_con limit_apply" style="padding: 10px;">
                <table class="order_info_table table_td_border" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请额度：</td>
                        <td colspan="3"><input type="text" class="w_200" name="apply_amount" value=""/></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">编号：</td>
                        <td colspan="3" class="gtivo-left" id="td_sn"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请对象：</td>
                        <td colspan="3" class="gtivo-left" >
                            <select name="apply_type" id="apply_type" onChange="change_apply_type(this)" class="ie8_select">
                                <option value="1">旅行社</option>
                                <option value="2">供应商</option>
                            </select>
                            <select name="apply_supplier" id="apply_supplier" style="display:none; margin-left:30px" class="ie8_select">
                              	<option value="0">选择供应商</option>
                              	<?php
	                                foreach($unionSupplier as $v) {
	                                  echo '<option value="'.$v['supplier_id'].'">'.$v['supplier_name'].'</option>';
	                                }
                              	?>
                            </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请日期：</td>
                        <td><input type="text" class="w_200" id="datetimepicker1" name="apply_date" value="" /></td>
                        <td class="order_info_title"><i class="important_title">*</i>还款日期：</td>
                        <td><input type="text" class="w_200" id="datetimepicker2" name="return_date" value="" /></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人：</td>
                        <td class="gtivo-left"><?php echo $real_name;?></td>
                        <td class="order_info_title">营业部：</td>
                        <td class="gtivo-left"><?php echo $depart_name;?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明：</td>
                        <td colspan="3"><input type="text" class="w_600" name="apply_remark"/></td>
                    </tr>
                </table>
            </div>
            <div class="form_btn clear">
                <input type="hidden" name="pay_code" id="pay_code" value="">
                <input type="hidden" name="manager_id"  value="<?php echo $manager_id;?>">
                <input type="hidden" name="manager_name"  value="<?php echo $manager_name;?>">
                <input type="hidden" name="depart_name"  value="<?php echo $depart_name;?>">
                <input type="hidden" name="is_manage"  value="<?php echo $is_manage;?>">
                <input type="submit" name="submit" value="提交审核" class="btn btn_blue" style="margin-left:220px;">
                <input type="reset" name="reset" value="关闭" class="layui-layer-close btn btn_gray">
            </div>
        </form>
    </div>
</div>
<!--********************************End 信用申请*************************************-->

<!--********************************Start 查看信用申请*************************************-->
<div class="fb-content" id="show_apply" style="display:none;">
    <div class="box-title">
        <h4>额度申请详情</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
      	<div class="status_box">
          	<ul class="clear" id="show_apply_status">
                <li ><!--状态位置加上 class="on", 如果前面有li, 就把前面的li加上on_show-->
                    <span class="time"></span><i></i><em></em><strong></strong><span class="txt">新增申请</span>
                </li>
                <li >
                    <span class="time "></span><i></i><em></em><strong></strong><span class="txt">经理审批</span>
                </li>
                <li >
                <span class="time"></span><i></i><em></em><strong></strong><span class="txt">旅行社/供应商授权</span>
                </li>
                <li>
                <span class="time"></span><i></i><em></em><strong></strong><span class="txt">已还款</span>
                </li>
            </ul>
        </div>
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form_con limit_apply" style="padding: 10px;">
              <table class="order_info_table table_td_border" width="100%" cellspacing="0">
                  <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请额度：</td>
                        <td colspan="3" id="show_apply_amount"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">编号：</td>
                        <td colspan="3" class="gtivo-left" id="show_apply_code"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请对象：</td>
                        <td colspan="3" class="gtivo-left" id="show_apply_obj"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请日期：</td>
                        <td id="show_apply_date"></td>
                        <td class="order_info_title"><i class="important_title">*</i>还款日期：</td>
                        <td id="show_return_date"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人：</td>
                        <td class="gtivo-left" id="show_apply_people"></td>
                        <td class="order_info_title">营业部：</td>
                        <td class="gtivo-left" id="show_apply_depart"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明：</td>
                        <td colspan="3" id="show_apply_remark"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>
<!--********************************End 查看信用申请*************************************-->


<!--****************************************Start 经理提交***************************************************-->
<div class="fb-content" id="m_approval_modal" style="display:none;">
    <div class="box-title">
        <h4>经理提交审核</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
	    <form  class="form-horizontal" action="#" id='m_approval_form' name='m_approval_form' method="post">
	        <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
	            <tr height="40">
	                <td class="order_info_title">总金额金额:</td>
	                <td>
	                    <input type="text" name="total_amount" id="total_amount" readonly value="" style="color:#428bca">
	                </td>
	            </tr>
	            <tr height="40">
	                <td class="order_info_title">提交备注:</td>
	                <td><input type="text" name="m_remark" style="width:95%;height: 100%"/></td>
	            </tr>
	            <tr height="40">
	                <td class="order_info_title">通过/拒绝:</td>
	                <td>
	                    <input style="opacity: 5; height: auto; position: static; cursor: pointer" type="radio" name="m_approval_status" value="1" checked="checked" />通过
	                    <input style="opacity: 5; height: auto; position: static; cursor: pointer;margin-left:20px;" type="radio" name="m_approval_status" value="2" />拒绝
	                </td>
	            </tr>
	        </table>
	        <div style="text-align:center;">
		        <input type="hidden" name="approval_ids" id="approval_ids" value=""/>
		        <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交审核" style="margin:20px 0px;">
	        </div>
	    </form>
    </div>
</div>
<!--***********************************End 经理提交**********************************************************-->

<script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">

var isJsonp= false ;// 是否JSONP,跨域
var is_manage = <?php echo $is_manage;?>;
function new_apply(){
  var pay_sn = (new Date().getTime())+''+(Math.ceil(Math.random()*1000));
  pay_sn = 'A'+pay_sn.substr(pay_sn.length-6);
  $("#pay_code").val(pay_sn);
  $("#td_sn").html(pay_sn);
       layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '700px',
            shadeClose: false,
            content: $('#limit_apply')
      });
}

//撤销申请
function cancle_apply(obj){
  var apply_id = $(obj).attr('data-appid');
  var apply_use_id = $(obj).attr('data-useid');
  $.post("<?php echo base_url();?>admin/b2/credit_approval/ajax_cancle_apply",
        {'apply_id':apply_id,'apply_use_id':apply_use_id},
        function(data){
            data = eval('('+data+')');
            if(data.status == 200){
                alert(data.msg);
                window.location.reload();
            }else{
                alert(data.msg);
            }
        }
    );
}


function submit_apply(){
  	if($("#approval_ids").val()!=""){
      	layer.open({
	        type: 1,
	        title: false,
	        closeBtn: 0,
	        area: '560px',
	        shadeClose: false,
	        content: $('#m_approval_modal')
	      });
	}else{
	    tan('你还未选择任何订单!');
   }
}

function choose(obj){
    if($(obj).is(':checked')){
         $("#approval_ids").val($("#approval_ids").val()+$(obj).val()+",");
          $("#total_amount").val(Number($(obj).attr('data-price'))+Number($("#total_amount").val()));

    }else{
          $("#total_amount").val(Number($("#total_amount").val())-Number($(obj).attr('data-price')));
          $("#approval_ids").val($("#approval_ids").val().replace($(obj).val()+',',''));
    }
}

//查看申请进度和详情弹框
function show_apply(obj){
  var apply_id = $(obj).attr('data-id');
    $.post("<?php echo base_url();?>admin/b2/credit_approval/ajax_one_data",
                 {id:apply_id},
                  function(data){
                       data = eval('('+data+')');
                       data = data[0];
                      $("#show_apply_amount").html(data['credit_limit']);
                      $("#show_apply_code").html(data['code']);
                      $("#show_apply_date").html(data['addtime']);
                      $("#show_return_date").html(data['return_time']);
                      $("#show_apply_people").html(data['expert_name']);
                      $("#show_apply_depart").html(data['depart_name']);
                      $("#show_apply_remark").html(data['remark']);
                      if(data['company_name']!=null){
                        $("#show_apply_obj").html(data['company_name']);
                      }else{
                        $("#show_apply_obj").html(data['union_name']);
                      }
                      if(data['status']==1 || data['status']==2){
                        $("#show_apply_status").find('li').eq(0).addClass('on_show').find('.time').html(data['addtime']);
                        $("#show_apply_status").find('li').eq(1).addClass('on').find('.time').html(data['m_addtime']);
                      }else if(data['status']==3 || data['status']==5 ){
                        $("#show_apply_status").find('li').eq(0).addClass('on_show').find('.time').html(data['addtime']);
                        $("#show_apply_status").find('li').eq(1).addClass('on_show').find('.time').html(data['m_addtime']);
                        $("#show_apply_status").find('li').eq(2).addClass('on').find('.time').html(data['modtime']);
                      }else if(data['status']==4){
                        $("#show_apply_status").find('li').eq(0).addClass('on_show').find('.time').html(data['addtime']);
                        $("#show_apply_status").find('li').eq(1).addClass('on_show').find('.time').html(data['m_addtime']);
                        $("#show_apply_status").find('li').eq(2).addClass('on_show').find('.time').html(data['modtime']);
                        $("#show_apply_status").find('li').eq(3).addClass('on').find('.time').html(data['real_return_time']);
                      }else{
                        $("#show_apply_status").find('li').eq(0).addClass('on').find('.time').html(data['addtime']);
                      }
                       layer.open({
                        type: 1,
                        title: false,
                        closeBtn: 0,
                        area: '700px',
                        shadeClose: false,
                        content: $('#show_apply')
                    });
                  }
            );
}


//1:旅行社; 2: 供应商
function change_apply_type(obj){
  if($(obj).val()==2){
    $("#apply_supplier").show();
  }else{
    $("#apply_supplier").hide();
  }
}


$(document).ready(function(){

    $("#apply_credit_form").submit(function(){
                    if($('#apply_credit_form').find("input[name='apply_amount']").val()==""){
                            alert("申请额度必填");
                            return false;
                     }
                     if($('#apply_type').val()==2){
                           if($("#apply_supplier").val()=="0"){
                                alert("供应商必选");
                                return false;
                           }
                     }
                     if($("#datetimepicker1").val()==""){
                                alert("申请日期必填");
                                return false;
                     }

                     if($("#datetimepicker2").val()==""){
                            alert("还款日期必填");
                            return false;
                     }
                    $('#apply_credit_form').find("input[type='submit']").before("<span style='color:blue'>已提交,请等待.....</span>").remove();
                    $.post(
                         "<?php echo base_url();?>admin/b2/credit_approval/new_apply",
                        $('#apply_credit_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                     tan_alert(data.msg);
                                     //window.location.reload();
                                }else{
                                	tan_alert(data.msg);
                                    //window.location.reload();
                                }
                        }
                    );
          return false;
    });

$("#m_approval_form").submit(function(){
                    $.post(
                         "<?php echo base_url();?>admin/b2/credit_approval/manager_submit",
                        $('#m_approval_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                	tan_alert(data.msg);
                                     //window.location.reload();
                                }else{
                                	tan_alert_noreload(data.msg);
                                   // window.location.reload();
                                }
                        }
                    );
          return false;
    });

  $('#datetimepicker1').datetimepicker({
                                    lang:'ch', //显示语言
                                    timepicker:false, //是否显示小时
                                    format:'Y-m-d', //选中显示的日期格式
                                    formatDate:'Y-m-d',
                                    validateOnBlur:false,
                                    yearStart:1930
                                });
    $('#datetimepicker2').datetimepicker({
                                    lang:'ch', //显示语言
                                    timepicker:false, //是否显示小时
                                    format:'Y-m-d', //选中显示的日期格式
                                    formatDate:'Y-m-d',
                                    validateOnBlur:false,
                                    yearStart:1930
                                });
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

    //数据列表中的多选按钮
  var check_obj = {field : 'id',title : "选择",width : '4%',align : 'center',
              formatter: function(value,rowData,rowIndex){
                    if(rowData['status']!=0){
                      return "<input type='checkbox' disabled='disabled' class='check_order_id bkStaic' name='pay_id[]' id='pay_check'  value="+value+">";
                    }else{
                      return "<input type='checkbox' class='check_order_id' onclick='choose(this)' data-price='"+rowData['credit_limit']+"' name='pay_id[]'  value="+value+">";
                    }
              }};
var credit_approval_columns=[
      {field : 'code',title : '编号',width : '60',align : 'center'},
      {field : 'ordersn',title : '订单号',width : '60',align : 'center',formatter:function(value,rowData,rowIndex){
          var html = "";
          html = "<a class='notA' style='text-decoration:none;' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
          return html;
       }
  	 },
      {field : 'expert_name',title : '销售名称',width : '65',align : 'center'},
      {field : 'credit_limit',title : '申请额度',width : '65',align : 'right' ,
       formatter: function(value,rowData,rowIndex){
                return "<a data-id='"+rowData['id']+"' onclick='show_apply(this)' style='color:#008000 !important;'>"+value+"</a>";
            }},
        {field : 'real_amount',title : '使用额度',align : 'right', width : '65',
            formatter: function(value,rowData,rowIndex){
                if(value!=null){
                    return "<span style='/*color:#428bca;*/text-align:right'>"+value+"</span>";
                }else{
                    return "<span style='/*color:#428bca;*/text-align:right'>0</span>";
                }
            }
        },

        {field : 'return_amount',title : '已还款金额',align : 'right', width : '65',
                 formatter: function(value,rowData,rowIndex){
                if(value!=null){
                    return "<span style='/*color:#428bca;*/text-align:right'>"+value+"</span>";
                }else{
                    return "<span style='/*color:#428bca;*/text-align:right'>0</span>";
                }
              }
            },
      {field : 'addtime',title : '申请时间',align : 'center', width : '65'},
      {field : 'return_time',title : '还款时间',align : 'center', width : '65'},
      {field : 'remark',title : '申请说明',width : '60',align : 'center'},
      {field : 'm_remark',title : '经理审批意见',width : '60',align : 'center'},
      {field : 'reply',title : '审批意见',width : '60',align : 'center'},
       
        {field : 'company_name',title : '审批人',width : '60',align : 'center' ,
       formatter: function(value,rowData,rowIndex){
                          if(value!=null){
                               return value;
                          }else if(value==null && rowData['union_name']!=null){
                              return rowData['union_name'];
                        }else if(value==null && rowData['union_name']==null && rowData['realname']!=null){
                                return rowData['realname'];
                        }
            }},

       {field : 'status',title : '状态',width : '60',align : 'center',
       formatter: function(value,rowData,rowIndex){
                    switch(value){
                            case '0':
                                return "未提交";
                            break;
                            case '1':
                                return "申请中";
                            break;
                            case '2':
                                return "经理拒绝";
                            break;
                            case '3':
                                return "已授信";
                            break;
                            case '4':
                                 return "已还款";
                            break;
                            case '5':
                                 return "已拒绝";
                            break;
                            case '-1':
                                 return "已撤销";
                            break;
                    }
              }},
        /*      {field : 'status',title : '操作',width : '60',align : 'center',
                  formatter: function(value,rowData,rowIndex){

                          switch(value){
                                case '0':
                                case '1':
                                    return "<a data-appid='"+rowData['id']+"' data-useid='"+rowData['ep_id']+"' onclick='cancle_apply(this)'>撤销</a>";
                                    break;
                                case '3':
                                    if(rowData['ep_status'] != null && rowData['ep_status'] == 0){
                                      return "<a data-appid='"+rowData['id']+"' data-useid='"+rowData['ep_id']+"' onclick='cancle_apply(this)'>撤销</a>";
                                    }else{
                                        return "无操作";
                                    }
                                    break;
                                default:
                                     return "无操作";
                                break;
                    }
              }}*/
      ];

      //只有是经理的时候才可以出现多选按钮
      if(is_manage==1){
        credit_approval_columns.unshift(check_obj);
      }
      initTableForm("#credit_approval","#credit_approval_dataTable",credit_approval_columns,isJsonp ).load();
       $("#searchBtn").click(function(){
          initTableForm("#credit_approval","#credit_approval_dataTable",credit_approval_columns,isJsonp ).load();
      });





});

</script>
