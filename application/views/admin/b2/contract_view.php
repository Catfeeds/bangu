<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格申请</title>
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
#list1 .x-grid-cell-inner a:nth-child(1) { text-align:center;}
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
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd; font-size: 12px; font-family: "宋体"; color: #555;}
.shadows{box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4); -webkit-box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);-moz-box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);box-shadow: 0 0 25px 0 rgba(0, 0, 0, .4);}
.formBox{ padding:0; padding-bottom:5px; margin-bottom:5px;}
select{ height:24px; line-height:24px;}
.form-group{ margin-right: 20px; float:left;}
.form-group label{ height: 24px; line-height: 24px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666; float: left}
.form-group input{ height: 24px; line-height: 24px; padding: 0  10px; float: left;width: 76px;}
.box-title h4{ height:40px; line-height:40px; background:#f1f1f1; text-indent:10px;}
.trip_every_day{ padding:20px 15px;}
.trip_every_day img{ padding:0px 5px; margin-top:5px;}
.trip_every_day .trip_day_title{ line-height:24px;}
.trip_content_left{ font-weight: bold;}
.trip_content_right{ padding-left:60px;}
.x-grid-cell-inner a{ display: inline-block; padding: 0 5px; color: #09c;}
.table_content { padding-top:0 !important;}
.tab_content { padding:0 !important;}

.page-button{margin-top:20px;height:30px;}
.page-button li{padding: 5px 12px;border: 1px solid rgb(221, 221, 221);cursor: pointer;margin-right: 2px;list-style-type: none;float: left;}
.page-button .active-page{background:#2DC3E8;color:#fff;cursor: inherit;}
.page-button .disable-page{background: #e9e9e9;cursor: inherit;border: 1px solid #ccc;}
</style>
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
</head>
<body>
<div class="page-content bg_gray">
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home')?>"> 主页 </a></li>
            <li class="active">合同签署</li>
        </ul>
    </div>
    <div class="page-body" id="bodyMsg" style="padding-top:0 !important;">

        <div class="table_content">
        	<ul class="nav nav-tabs tab_shadow clear">
                <li class="active tab_red" data-val="0"><a href="###">未使用</a></li>
                <li class="tab_red" data-val="1"><a href="###">签署中</a></li>
                <li class="tab_red"  data-val="2"><a href="###">已签署</a></li>
                <li class="tab_red"  data-val="3"><a href="###">已核销</a></li>
                <li class="tab_red"  data-val="4"><a href="###">已作废</a></li>
                <li class="tab_red"  data-val="-1"><a href="###">申请作废中</a></li>
            </ul>
            <div class="tab_content">
                <!-- 抢单标签数据 -->
                <div class="table_list">
                <form id='search-condition' method="post">
               		<div class="form-inline formBox shadow">
		                <div class="form-group launch-contract">
		                    <label class="search_title col_span " >合同号:</label>
		                    <input class="search-input form-control ie8_input" type="text" name="contract_code" style="width:100px" />
		                </div>
		                <div class="form-group launch-contract">
                            <label class="search_title col_span " >客户:</label>
                            <input type="text"  name="guest_name" class="form-control search-input ie8_input" style="width:107px;"/>
                        </div>
		                <div class="form-group launch-contract">
                            <label class="search_title col_span " >订单号:</label>
                            <input type="text"  name="ordersn" class="form-control search-input ie8_input" style="width:107px;"/>
                        </div>
                        <div class="form-group">
                            <label class="search_title col_span name-title" >申请人:</label>
                            <input type="text"  name="expert_name" class="form-control search-input ie8_input" style="width:107px;"/>
                        </div>
                        <div class="form-group">
		                    <label class="search_title col_span time-title" >申请日期:</label>
		                    <input class="search-input form-control starttime" style="width:70px;" type="text" placeholder="开始时间"  name="starttime" />
		                    <label style="border:none;width:auto;">-</label>
		                    <input class="search-input form-control endtime" style="width:70px;" type="text" placeholder="结束时间"  name="endtime" />
		                </div>
		                <div style="float: left;">
			                <input type="hidden" name="status" value="0" />
			                <input type="submit" value="搜索" class="btn btn-darkorange" style="position: relative; top: 10px; float: left;padding: 3px 5px;" />
			                <?php if ($is_manage == 1):?>
			            	<input type="button" class="btn btn-darkorange form-but apply-contract" style="background: #3EAFE0 !important;padding: 3px 2px;margin: 10px;" value="申请电子合同" />
			            	<input type="button" class="btn btn-darkorange form-but see-record" style="background: #3EAFE0 !important;padding: 3px 2px;margin: 10px;" value="查看申请记录" />
		           			<?php endif;?>
		           		</div>
		            </div>
                    </form>
                    <div id="dataTable"><!--列表数据显示位置--></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fb-content" id="apply-abandoned" style="display:none;">
    <div class="box-title">
        <h4>申请作废</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <div class="fb-form">
    <form  class="form-horizontal" action="#" id='apply-form' name='pay_order_ids' method="post">
    	<div style="padding:20px;">
        	<div style="width: 13%; float: left;">作废理由:</div>
        	<div >
        		<textarea style="width: 85%;" name="remark" rows="5" ></textarea>
        	</div>
        </div>
    	<div style="text-align:right;padding-right:20px;">
        	<input type="hidden" name="id" />
            <input type="submit" class="btn btn-palegreen"  value="确认" style="margin:20px 0px;" />
            <input type="button" class="btn btn-palegreen layui-layer-close"  value="取消" style="margin:20px 0px;" />
        </div>
	</form>
    </div>
</div>

<div class="fb-content" id="apply-contract" style="display:none;">
    <div class="box-title">
        <h4>申请电子合同</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <div class="fb-form" style=" overflow: hidden; padding:15px;">
    <form  class="form-horizontal" action="#" id='apply-contract-form' name='new_payment_form' method="post">
        <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="border: 1px solid #ddd">
        	<tr style="height:30px;">
            	<td class="order_info_title">合同类型:</td>
                <td colspan="5">
                	<label><input type="radio" name="type" value="1" style="opacity:1;position: static;" />出境游合同</label>
                    <label><input type="radio" name="type" value="2" style="opacity:1;position: static;"/>国内游合同</label>
                </td>
                    </tr>
                    <tr style="height:30px;">
                        <td class="order_info_title">申请份数:</td>
                        <td colspan="5"><input type="text" name="num" style="width:120px;height: 25px;line-height:25px;box-sizing:border-box;padding:0 2px;"/>份</td>
                    </tr>
                    <tr>
                        <td class="order_info_title">申请说明:</td>
                        <td colspan="5" style="padding: 2px 10px;">
                        	<textarea name="reason" rows="4" style="width:95%;resize:none;"></textarea>
                        </td>
                    </tr>
                </table>
                <div style="text-align:center;">
                  <input type="submit" class="btn btn-palegreen"  value="申请" style="margin:20px 0px;" />
                </div>
              </form>
    </div>
</div>

<div class="fb-content" id="chioce-expert" style="display:none;">
    <div class="box-title">
        <h4>选择管家</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <div class="fb-form" style=" overflow: hidden; padding:15px;">
    <form  class="form-horizontal" action="#" id='chioce-expert-form' name='new_payment_form' method="post">
        <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="border: 1px solid #ddd">
        	<tr style="height:40px;">
            	<td class="order_info_title">管家:</td>
                <td colspan="5">
                	<?php foreach($expertArr as $v): ?>
                	<label style="  width: 30%;display: inline-block;  cursor: pointer;">
                		<input type="radio" name="expert_id" value="<?php echo $v['id']?>" style="opacity:1;position: static;" /><?php echo $v['realname']?>
                	</label>
                	<?php endforeach;?>
                </td>
            </tr>
        </table>
		<div style="text-align:right;">
			<input type="hidden" name="launch_id" />
			<input type="submit" class="btn btn-palegreen"  value="确认" style="margin:20px 0px;" />
		</div>
	</form>
    </div>
</div>


<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript">
$('input[name=num]').verifNum();


//查看申请记录
$('.see-record').click(function(){
	window.top.layer.open({
		  type: 2,
		  area: ['700px', '600px'],
		  title :'电子合同申请记录',
		  fix: true, //不固定
		  maxmin: true,
		  content: "/admin/b2/contract/seeApplyContract"
	});
})


//申请合同
$('.apply-contract').click(function(){
	$('#apply-contract-form').find('textarea[name=pay_remark]').val('');
	$('#apply-contract-form').find('input[name=num]').val('');
	$('#apply-contract-form').find('input[type=radio]').attr('checked' ,false);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#apply-contract')
	});
})

$('#apply-contract-form').submit(function(){
	$.ajax({
		url:'/admin/b2/contract/applyContract',
		data:$(this).serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			if (result.code == '2000') {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

//选择合同管家
function chioce_expert(id){
	$('input[name=launch_id]').val(id);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#chioce-expert')
	});
}

$('#chioce-expert-form').submit(function(){
	$.ajax({
		url:'/admin/b2/contract/chioceExpert',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				tabData(0);
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
var is_manage = <?php echo $is_manage?>;
var expert_id = <?php echo $expertData['id']?>
//未使用
var columns0 = [{field : 'addtime',title : '申请日期',width : '130',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'expert_name',title : '申请人',width : '90',align : 'center'},
                {field : 'launch_expert_name',title : '所属管家',width : '90',align : 'center'},
                {field : 'modtime',title : '发放日期',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '180', formatter: function(result) {
                    	var button = '';
                    	if (is_manage == 1) {
                        	//没有分配管家，或者分配的管家是经理自己
                        	if (result.launch_expert_id < 1 || result.launch_expert_id == expert_id) {
                        		button += '<a href="javascript:void(0);" onclick="launchContract(\''+result.launch_id+'\')">发起签署</a>&nbsp;';
                            }
                    		button += '<a href="javascript:void(0);" onclick="abandoned('+result.launch_id+')">申请作废</a>&nbsp;';
                    	} else {
                    		button += '<a href="javascript:void(0);" onclick="launchContract(\''+result.launch_id+'\')">发起签署</a>&nbsp;';
                        }
                        if (result.launch_expert_id < 1) {
                    		button += '<a href="javascript:void(0);" onclick="chioce_expert('+result.launch_id+')">分配</a>';
                        }
    	                return  button;
                	}
    			}];

//签署中
var columns1 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
            {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
					return result.type == 1 ? '出境游' : '国内游';
                }
            },
            {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
            {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
            {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
            {field : 'num',title : '合同人数',width : '80',align : 'center'},
            {field : 'expert_name',title : '发起人',width : '80',align : 'center'},
            {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
            {field : false,title : '操作', align : 'center',width : '160', formatter: function(result) {
                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
                	button += '<a href="javascript:void(0);" onclick="resend('+result.id+')">重新发送</a>&nbsp;';
                	button += '<a href="javascript:void(0);" onclick="abandoned('+result.id+')">申请作废</a>&nbsp;';
                	button += '<a href="/pdf/contract_pdf/createContractPdf?id='+result.id+'" target="_blank">下载合同</a>';
	                return  button;
            	}
			}];
//已签署			
var columns2 = [{field : 'addtime',title : '发起日期',width : '130',align : 'left'},
                {field : 'write_time',title : '签署时间',width : '130',align : 'left'},
                {field : false,title : '合同类型',width : '80',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '80',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '70',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '70',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '150', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
	                	button += '<a href="javascript:void(0);" onclick="abandoned('+result.id+')">申请作废</a>&nbsp';
	                	button += '<a href="/pdf/contract_pdf/createContractPdf?id='+result.id+'" target="_blank">下载合同</a>';
		                return  button;
                	}
    			}];
//已核销
var columns3 = [{field : 'addtime',title : '发起日期',width : '130',align : 'left'},
                {field : 'confirm_time',title : '核销时间',width : '130',align : 'left'},
                {field : false,title : '合同类型',width : '80',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '80',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '70',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '70',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '150', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>&nbsp;';
	                	button += '<a href="javascript:void(0);" onclick="abandoned('+result.id+')">申请作废</a>&nbsp';
	                	button += '<a href="javascript:void(0);" onclick="download('+result.id+')">下载合同</a>';
		                return  button;
                	}
    			}];
//已作废
var columns4 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
                {field : 'cancel_time',title : '作废时间',width : '140',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '90',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>';
		                return  button;
                	}
    			}];   
//已作废
var columns5 = [{field : 'addtime',title : '发起日期',width : '140',align : 'left'},
                {field : 'cancel_time',title : '申请作废时间',width : '140',align : 'left'},
                {field : false,title : '合同类型',width : '90',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : 'contract_code',title : '合同编号',width : '90',align : 'center'},
                {field : 'guest_name',title : '客人姓名',width : '90',align : 'center'},
                {field : 'guest_mobile',title : '客人电话',width : '90',align : 'center'},
                {field : 'num',title : '合同人数',width : '90',align : 'center'},
                {field : 'expert_name',title : '发起人',width : '90',align : 'center'},
                {field : 'order_sn',title : '订单号',width : '90',align : 'center'},
                {field : false,title : '操作', align : 'center',width : '100', formatter: function(result) {
	                	var button = '<a href="javascript:void(0);" onclick="see(\''+result.contract_code+'\')">查看</a>';
		                return  button;
                	}
    			}];     			
tabData(0);
function tabData(status) {
	$('#search-condition').find('input[type=text]').val('');
	$('.launch-contract').show();
	$('.name-title').html('发起人：');
	$('.time-title').html('发起日期：');
	if (status == 0) {
		$('.launch-contract').hide();
		$('.name-title').html('申请人：');
		$('.time-title').html('申请日期：');
		var columns = columns0;
		$('.form-but').show();
		var url = '/admin/b2/contract/getContractApply';
	} else if (status == 1) {
		var columns = columns1;
		$('.form-but').hide();
		var url = '/admin/b2/contract/getContractData';
	} else if (status == 2) {
		var columns = columns2;
		$('.form-but').hide();
		var url = '/admin/b2/contract/getContractData';
	} else if (status == 3) {
		var columns = columns3;
		var url = '/admin/b2/contract/getContractData';
		$('.form-but').hide();
	} else if (status == 4) {
		var columns = columns4;
		var url = '/admin/b2/contract/getContractData';
		$('.form-but').hide();
	} else if (status == -1) {
		var columns = columns5;
		var url = '/admin/b2/contract/getContractData';
		$('.form-but').hide();
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:url,
		pageSize:10,
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

$('.nav-tabs').find('li').click(function(){
	if (!$(this).hasClass('active')) {
		var type = $(this).attr('data-val');
		$(this).addClass('active').siblings().removeClass('active');
		$('input[name=status]').val(type);
		tabData(type);
	}
})

//申请作废合同
function abandoned(id) {
	$('textarea[name=remark]').val('');
	$('#apply-form').find('input[name=id]').val(id);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#apply-abandoned')
	});
}

function resend(id){
	$.ajax({
		url:'/admin/b2/contract/resendContract',
		data:{id:id},
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
}

$('#apply-form').submit(function(){
	$.ajax({
		url:'/admin/b2/contract/abandoned',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == '2000') {
				tabData(status);
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})


//查看合同
function see(code) {
	window.top.layer.open({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'合同信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b2/contract/seeLaunchContract');?>"+"?code="+code
	});
}

//发起合同
function launchContract(id) {
	window.top.layer.open({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'合同信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b2/contract/launchContract');?>?id="+id+'&first=1'
	});
}


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

</script>
</body>
</html>
