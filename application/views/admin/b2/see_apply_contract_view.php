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
<body style="height:auto;">
    <div class="page-body" id="bodyMsg" style=" margin-top: 30px !important;">

        <div class="table_content">
            <div class="tab_content">
                <!-- 抢单标签数据 -->
                <div class="table_list">
                    <div id="dataTable"><!--列表数据显示位置--></div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
//未使用
var columns = [{field : 'addtime',title : '申请日期',width : '130',align : 'left'},
                {field : false,title : '合同类型',width : '80',align : 'center',formatter:function(result) {
    					return result.type == 1 ? '出境游' : '国内游';
                    }
                },
                {field : false,title : '申请份数',width : '80',align : 'center',formatter:function(result) {
						return '<span style="color:red;">'+result.num+'</span>/份';
                    }
                },
                {field : false,title : '状态',width : '70',align : 'center' ,formatter:function(result) {
						if (result.status == 0) {
							return '申请中';
						} else if(result.status == 1) {
							return '已通过';
						} else if (result.status == 2) {
							return '<span style="color:red;">已拒绝</span>';
						}
                    }
                },
                {field : 'expert_name',title : '申请人',width : '90',align : 'center'},
                {field : 'employee_name',title : '审核人',width : '90',align : 'center'}];
 			

	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/b2/contract/getApplyContract',
		pageSize:10,
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});

</script>
</body>
</html>
