<!DOCTYPE html>
<html>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style>
.tab_content>form input[type=text]{ width:160px;}
</style>
<head>
	<meta charset="utf-8"  />
	<title>供应商对接管理</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">T33线路</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="1"><a href="#" class="active">待审核</a></li> 
                        <li data-val="2"><a href="#" class="">已通过</a></li>
                        <li data-val="3"><a href="#" class="">已拒绝</a></li>  
                    </ul>
                </div>
                <div class="tab_content">
                	
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear" style="width:1200px;">
                        	<div class="search_group">
                            	<label>产品编号:</label>
                                <input type="text" name="linecode"  id="linecode" class="search_input" placeholder="产品编号" />
                            </div>
                            <div class="search_group">
                            	<label>产品标题:</label>
                                <input type="text" name="linename" class="search_input"  placeholder="产品标题" />
                            </div>
                            <div class="search_group">
                            	<label>上线时间:</label>
                                <input type="text" name="starttime" class="search_input" id="starttime" style="width:100px;" placeholder="开始时间" />
                                <input type="text" name="endtime" class="search_input" id="endtime" style="width:100px;"  placeholder="结束时间" />
                            </div>
                            <div class="search_group">
                            	<label class="search-title" >更新时间:</label>
                                <input type="text" name="mod_time" class="search_input" id="mod_time" style="width:100px;" placeholder="开始时间" />
                                <input type="text" name="mod_endtime" class="search_input" id="mod_endtime" style="width:100px;"  placeholder="结束时间" />
                            </div>
                            <div class="search_group">
                            	<label>出发城市:</label>
                                <input type="text" name="startcity" id="startcity" class="search_input"  placeholder="出发城市" />
                            </div>
                            <div class="search_group">
                            	<label style="width:52px">供应商:</label>
                                <input type="text" name="supplier"  id="supplier" class="search_input"  placeholder="供应商" />
                            </div>
                            <div class="search_group">
                            	<label style="width:52px" >目的地:</label>
                                <input type="text" name="destinations" id="destinations" class="search_input"  placeholder="目的地" />
                            </div>
                             <div class="search_group">
                            	<label style="width:52px" >审核人:</label>
                                <input type="text" name="realname" id="realname" class="search_input"  placeholder="审核人" />
                            </div>
<!--                             
                             <div class="search_group">
                            	<label>线路类型:</label>
                                <select name="line_classify">
                                	<option value="">请选择</option>
                                 	<option value="2">国内游</option>
                                  	<option value="1">境外游</option>
                                  	<option value="3">周边游</option>
                                </select>
                            </div> -->
                            <div class="search_group">
                            	<input type="hidden" name="status" value="1">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
    <script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script> 
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>

var columns1 = [ {field : 'linecode',title : '产品编号',width : '80',align : 'center'},
        		{field : null,title : '产品标题',align : 'left',
						formatter:function(item){
							return '<a href="javascript:void(0);" onclick="show_line_detail('+item.id+',2)" >'+item.linename+'</a>';
						}
				},
        		{field : 'startplace',title : '出发地',width : '140',align : 'center',},
        		{field : 'online_time',title : '上线时间',width : '140',align : 'center'},
        		{field : 'modtime',title : '更新时间',width : '120',align : 'center'},
        		{field : 'lineday',title : '天数',width : '60',align : 'center'},
        		{field : 's_name',title : '录入人',width : '100',align : 'center'},
        		{field : 'company_name',title :'供应商',width :'120',align : 'center'},
        		{field : 'union_name',title : '旅行社',width : '140',align : 'center'}
        	];
 var columns2 = [
				{field : 'linecode',title : '产品编号',width : '80',align : 'center'},
        		{field : null,title : '产品标题',align : 'left',
						formatter:function(item){
							return '<a href="javascript:void(0);" onclick="show_line_detail('+item.id+',2)" >'+item.linename+'</a>';
						}
				},
        		{field : 'startplace',title : '出发地',width : '120',align : 'center',},
        		{field : 'online_time',title : '上线时间',width : '140',align : 'center'},
        		{field : 'confirm_time',title : '审核时间',width : '140',align : 'center'},
        		{field : 'lineday',title : '天数',width : '60',align : 'center'},
        		{field : 's_name',title : '录入人',width : '100',align : 'center'},
        		{field : 'company_name',title :'供应商',width :'120',align : 'center'},
        		{field : 'employee_name',title : '产品审核人',width : '100',align : 'center'},
        		{field : 'union_name',title : '旅行社',width : '140',align : 'center'}
                 ];
 var columns3 = [
 				{field : 'linecode',title : '产品编号',width : '80',align : 'center'},
        		{field : null,title : '产品标题',align : 'left',
						formatter:function(item){
							return '<a href="javascript:void(0);" onclick="show_line_detail('+item.id+',2)" >'+item.linename+'</a>';
						}
				},
        		{field : 'startplace',title : '出发地',width : '120',align : 'center',},
        		{field : 'online_time',title : '上线时间',width : '140',align : 'center'},
        		{field : 'modtime',title : '更新时间',width : '140',align : 'center'},
        		{field : 'lineday',title : '天数',width : '60',align : 'center'},
        		{field : 's_name',title : '录入人',width : '100',align : 'center'},
        		{field : 'company_name',title :'供应商',width :'120',align : 'center'},
        		{field : 'employee_name',title : '产品审核人',width : '100',align : 'center'},
        		{field : 'union_name',title : '旅行社',width : '140',align : 'center'}
               ];
        	
getData(1 ,1);
function getData(status ,page) {
	$('.search-title').html('更新时间：');
	if (status == 1) {  //审核中
		var columns = columns1;
	} else if (status == 2) {  //已通过
		var columns = columns2;
		$('.search-title').html('审核时间：');
	}else if(status == 3){   //已拒绝
		var columns = columns3;
	}
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/lines/t33_line/get_line_list',
		pageSize:15,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}
var searchObj = $('#search-condition');
$('.tab-nav').find('li').click(function(){
	var status = $(this).attr('data-val');
	searchObj.find('input[type=text]').val('');
	searchObj.find('input[name=status]').val(status);
	
	getData(status ,1);
})

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
$('#mod_endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#mod_time').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});

//搜索栏商家名字下拉
$.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.company_name,
		    value : val.id,
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#supplier",
	    name : "supplier_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})

//目的地
$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.kindname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#destinations",
	    name : "destid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})

//出发城市
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.cityname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#startcity",
	    name : "startcity_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//审核人
$.post('/admin/a/lines/line/get_admin_user?type=2', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.realname,
		    value : val.id,
		    jb : '',
		    qp :''
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#realname",
	    name : "adminid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
</script>
</html>

<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

