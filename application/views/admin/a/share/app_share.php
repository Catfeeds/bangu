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
            <a href="#">APP分享管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>分享代码</label>
                                <input type="text" name="code" class="search_input" />
                            </div>
                            <div class="search_group">
                            	<label>分享类型</label>
                                <select name="type">
                                	<option value="0">请选择</option>
                                	<option value="C">用户分享</option>
                                	<option value="B">管家分享</option>
                                </select>
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
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
var columns = [ {field : 'title',title : '分享标题',width : '140',align : 'center'},
        		{field : false,title : '分享类型',width : '100',align : 'center',formatter:function(item){
						return item.type=='C' ? '用户分享' : '管家分享';
            		}
            	},
        		{field : 'desc',title : '分享描述',width : '200',align : 'center'},
        		{field : 'link',title : '链接地址',width : '160',align : 'center'},
        		{field : 'imgUrl',title : '分享图标',align : 'center', width : '100'},
        		{field : 'code',title : '分享代码',align : 'center', width : '100'},
        		{field : 'remark',title : '说明',align : 'center', width : '140'},
        		{field : false,title : '操作',align : 'center', width : '80',formatter: function(item){
        			return '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">编辑</a>&nbsp;';
        		}
        	}];
        	
getData(1);
function getData(page) {
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/share/app_share/getData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

//编辑
function edit(id) {
	window.top.openWin({
		  type: 2,
		  area: ['650px', '600px'],
		  title :'编辑',
		  fix: true,
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/share/app_share/edit_app_share');?>?id="+id
	});
}
function showMsg(msg) {
	getData();
	layer.msg(msg ,{icon:1});
}
</script>
</html>


