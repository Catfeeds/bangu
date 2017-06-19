<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
		/*详情 start*/
		.order_detail{margin-bottom: 20px;}
		.but-list{
			text-align: right;
			margin-top: 10px;
		}
		.but-list button{
			background: rgb(255, 255, 255) none repeat scroll 0% 0%;
			border: 1px solid rgb(204, 204, 204);
			padding: 3px;
			border-radius: 3px;
			cursor: pointer;
			margin-left: 10px;
		}
		.but-list button:hover{background: #2dc3e8;color: #fff;}
		.table_td_border > tbody > tr > td {
		    width: 40%;
		}
		.tionRela span{position:absolute; top:0; left:0}
		.tionRela{position: relative; padding-left:60px;margin-top: 10px;}
		/*详情 end*/
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">注册用户导出</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group search-time">
                            	<label>注册日期</label>
                                <input type="text" name="starttime" value="<?php echo $starttime?>" class="search_input" id="starttime" placeholder="开始时间"/>
                                <input type="text" name="endtime" value = '<?php echo $endtime?>'class="search_input" id="endtime" placeholder="结束时间"/>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            	<input type="button" class="search_button export-button" value="导出">
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>

var columns = [ {field : 'flownums',title : '流量',width : '50',align : 'center'},
        		{field : 'activate_status',title : '激活状态',width : '80',align : 'center'},
        		{field : 'user_type',title : '用户类型',width : '70',align : 'center'},
        		{field : 'loginname',title : '用户名',align : 'center', width : '60'},
        		{field : 'nickname',title : '昵称',align : 'center', width : '60'},
        		{field : 'truename',title : '真实姓名',align : 'center', width : '60'},
        		{field : 'mobile',title : '手机',align : 'center', width : '60'},
        		{field : 'email',title : '邮箱',align : 'center', width : '100'},
        		{field : 'jointime',title : '注册时间',align : 'center', width : '100'},
        		{field : 'register_channel',title : '注册渠道',align : 'center', width : '70'}];
        	
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/statistics/export_user/get_user_data',
	pageSize:10,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

$('.export-button').click(function(){
	$.ajax({
		url:'/admin/a/statistics/export_user/exportExcel',
		data:$('#search-condition').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})


$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false
});
</script>
</html>


