<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">周边游管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>出发城市</label>
                                <input type="text" name="cityname"  class="search_input" onclick="showStartplaceTree(this);"/>
                                <input type="hidden" name="cityid">
                            </div>
                            <div class="search_group">
                            	<label>目的地</label>
                                <input type="text" name="kindname" onclick="showDestBaseTree(this);" class="search_input"/>
                           		<input type="hidden" name="destid">
                            </div>
                            <div class="search_group">
                            	<label>是否启用</label>
                                <select name="isopen">
                                	<option value="-1" selected="selected">全部</option>
                                	<option value="1">是</option>
                                	<option value="0">否</option>
                                </select>
                            </div>
                            <div class="search_group">
                            	<input type="submit" class="search_button" value="搜索"/>
                            	<input type="button" id="add-button" class="search_button" value="添加"/>
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
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>
var columns = [ {field : 'cityname',title : '出发城市',width : '150',align : 'center'},
        		{field : 'kindname',title : '目的地',width : '150',align : 'center'},
        		{field : false,title : '状态',align : 'center', width : '150',formatter:function(item){
						return item.isopen == 0 ? '停用' : '启用';
            		}
            	},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">修改</a>&nbsp;';
					if (item.isopen == 1) {
						button += '<a href="javascript:void(0);" onclick="disable('+item.id+');" class="action_type">停用</a>';
					} else {
						button += '<a href="javascript:void(0);" onclick="enable('+item.id+');" class="action_type">启用</a>';
					}
        			return button;
        		}
        	}];
        	
getData(1);
function getData(page) {
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/round_trip/getRoundData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

//停用目的地
function disable(id) {
	layer.confirm('您确定要停用此配置？', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/round_trip/disable',
			type:'post',
			dataType:'json',
			data:{'id':id},
			success:function(result) {
				if (result.code == '2000') {
					getData();
					layer.alert(result.msg, {icon: 1});
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		})
	});
}
//启用目的地
function enable(id) {
	layer.confirm('您确定要启用此配置？', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/round_trip/enable',
			type:'post',
			dataType:'json',
			data:{'id':id},
			success:function(result) {
				if (result.code == '2000') {
					getData();
					layer.alert(result.msg, {icon: 1});
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		})
	});
}
//编辑
function edit(id) {
	window.top.openWin({
		  type: 2,
		  area: ['600px', '400px'],
		  title :'编辑周边游',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/round_trip/update_trip');?>?id="+id
	});
}
//添加
$('#add-button').click(function(){
	window.top.openWin({
		  type: 2,
		  area: ['600px', '400px'],
		  title :'添加周边游',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/round_trip/update_trip');?>"
	});
})
</script>
</html>