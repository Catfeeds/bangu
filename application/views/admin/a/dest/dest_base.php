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
            <a href="#">目的地管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>目的地名称</label>
                                <input type="text" name="name" class="search_input" placeholder="目的地名称"/>
                            </div>
                            <div class="search_group">
                            	<label>上级</label>
                                <input type="text" name="parent_name" class="search_input" placeholder="目的地上级"/>
                            </div>
                            <div class="search_group">
                            	<label>状态</label>
                                <select name="isopen">
                                	<option value="-1" selected="selected">全部</option>
                                	<option value="1">启用</option>
                                	<option value="0">停用</option>
                                </select>
                            </div>
                            <div class="search_group">
                            	<label>是否热门</label>
                                <select name="ishot">
                                	<option value="-1" selected="selected">全部</option>
                                	<option value="1">是</option>
                                	<option value="0">否</option>
                                </select>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
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
<script>
var columns = [ {field : 'kindname',title : '名称',width : '120',align : 'center'},
        		{field : 'enname',title : '全拼',width : '200',align : 'center'},
        		{field : 'simplename',title : '简拼',width : '140',align : 'center'},
        		{field : 'parent_name',title : '上级',align : 'center', width : '60'},
        		{field : 'displayorder',title : '排序',align : 'center', width : '100'},
        		{field : false,title : '状态',align : 'center', width : '80',formatter:function(item){
						return item.isopen == 0 ? '停用' : '启用';
            		}
            	},
            	{field : false,title : '是否热门',align : 'center', width : '80',formatter:function(item){
						return item.ishot == 0 ? '否' : '是';
	        		}
	        	},
	        	{field : false,title : '类型',align : 'center', width : '80',formatter:function(item){
						return item.type == 1 ? '目的地' : '景点';
	        		}
	        	},
        		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
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
		url:'/admin/a/dest/dest_base/getDestBaseData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

//停用目的地
function disable(id) {
	layer.confirm('您确定要停用此目的地？', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/dest/dest_base/disable',
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
	layer.confirm('您确定要启用此目的地？', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/dest/dest_base/enable',
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
		  area: ['800px', '500px'],
		  title :'编辑目的地',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/dest/dest_base/edit_view');?>?id="+id
	});
}
//添加
$('#add-button').click(function(){
	window.top.openWin({
		  type: 2,
		  area: ['800px', '500px'],
		  title :'添加目的地',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/dest/dest_base/add_view');?>"
	});
})
</script>
</html>


