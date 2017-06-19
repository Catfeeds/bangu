<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
	<style>
	.form-horizontal .form-group .fg-title{width: 18% !important;}
	.form-horizontal .form-group .fg-input{width: 79% !important;}
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">线路虚拟值管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>线路编号</label>
                                <input type="text" name="linecode" class="search_input" placeholder="线路编号"/>
                            </div>
                            <div class="search_group">
                            	<label>线路名称</label>
                                <input type="text" name="linename" class="search_input" placeholder="线路名称"/>
                            </div>
                            <div class="search_group">
                            	<label>出发地</label>
                                <input type="text" name="startcity" id="startcity" class="search_input" placeholder="出发地"/>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
    
<div class="fb-content" id="vr-box" style="display:none;">
    <div class="box-title">
        <h4>修改虚拟值</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="vr-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">收藏虚拟值：<i>*</i></div>
                <div class="fg-input"><input type="text" name="collect_num_vr"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">满意度虚拟值：<i>*</i></div>
                <div class="fg-input"><input type="text" name="sati_vr"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">成交量虚拟值：<i>*</i></div>
                <div class="fg-input"><input type="text" name="order_num_vr"></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script>
$('input[name=collect_num_vr]').verifNum();
$('input[name=sati_vr]').verifNum({maxNum:1,digit:2});
$('input[name=order_num_vr]').verifNum();
var columns = [ {field : 'linecode',title : '产品编号',width : '150',align : 'center'},
        		{field : 'linename',title : '产品标题',width : '230',align : 'center'},
        		{field : 'supplier_name',title : '供应商',width : '140',align : 'center'},
        		{field : 'cityname',title : '出发地',align : 'center', width : '120'},
        		{field : 'collect_num_vr',title : '收藏虚拟值',align : 'center', width : '80'},
        		{field : 'sati_vr',title : '满意度虚拟值',align : 'center', width : '80'},
        		{field : 'order_num_vr',title : '成交量虚拟值',align : 'center', width : '80'},
        		{field : false,title : '操作',align : 'center', width : '100',formatter: function(item){
        			var button = '<a href="javascript:void(0);" data-collect="'+item.collect_num_vr+'" data-sati="'+item.sati_vr+'" data-order="'+item.order_num_vr+'" onclick="vr('+item.id+' ,this)" class="action_type">修改虚拟值</a>&nbsp;';
        			return button;
        		}
        	}];
        	
getData(1 ,1);
function getData(page) {
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/vr/line_vr/get_line_data',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

//修改收藏虚拟值
function vr(id ,obj) {
	var formObj = $('#vr-form');
	formObj.find('input[name=collect_num_vr]').val($(obj).attr('data-collect'));
	formObj.find('input[name=sati_vr]').val($(obj).attr('data-sati'));
	formObj.find('input[name=order_num_vr]').val($(obj).attr('data-order'));
	formObj.find('input[name=id]').val(id);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#vr-box')
	});
}
$('#vr-form').submit(function(){
	$.ajax({
		url:'/admin/a/vr/line_vr/update_vr',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				getData();
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
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
</script>
</html>


