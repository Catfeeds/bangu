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
            <a href="#">旅行社管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="1"><a href="#" class="active">已启用</a></li> 
                        <li data-val="0"><a href="#" class="">已停用</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                	<div class="add_btn btn_green" onclick="add_content();">添加</div>
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>内容</label>
                                <input type="text" name="content" class="search_input" />
                            </div>
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
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
var type = {1:'点击链接完成',2:'操作审核后完成',3:'点击信息后完成'};
var columns1 = [ {field : 'content',title : '消息内容',width : '300',align : 'left'},
        		{field : 'url',title : 'url',width : '140',align : 'center'},
        		{field : false,title : '完成标志',width : '110',align : 'center',formatter:function(result){
            			if (typeof type[result.type] == 'undefined') {
                			return '';
                		} else {
                			return type[result.type];
                    	}
            		}
        		},
        		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">编辑</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="disable('+item.id+');" class="action_type">停用</a>';
        			return button;
        		}
        	}];
var columns2 = [ {field : 'content',title : '消息内容',width : '300',align : 'center'},
         		{field : 'url',title : 'url',width : '140',align : 'center'},
         		{field : false,title : '完成标志',width : '110',align : 'center',formatter:function(result){
	         			if (typeof type[result.type] == 'undefined') {
	            			return '';
	            		} else {
	            			return type[result.type];
	                	}
             		}
         		},
         		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
         			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">编辑</a>&nbsp;';
         			button += '<a href="javascript:void(0);" onclick="enable('+item.id+');" class="action_type">启用</a>';
         			return button;
         		}
         	}];
        	
getData(1 ,1);
var searchObj = $('#search-condition');
$('.tab-nav').find('li').click(function(){
	var status = $(this).attr('data-val');
	searchObj.find('input[type=text]').val('');
	searchObj.find('input[name=status]').val(status);
	getData(status ,1);
})
function getData(status ,page) {
	if (status == 0) {
		var columns = columns2;
	} else if (status == 1) {
		var columns = columns1;
	}
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/msg/content/getContentData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

function edit(id){
	window.top.openWin({
		  type: 2,
		  area: ['600px', '500px'],
		  title :'编辑消息内容',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/msg/content/uploadContent');?>?id="+id
	});
}


function add_content(){
	window.top.openWin({
		  type: 2,
		  area: ['600px', '500px'],
		  title :'添加消息内容',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/msg/content/uploadContent');?>"
	});
}

//停用消息
function disable(id) {
	layer.confirm('您确定要停用此消息?', {btn: ['确定','取消']},
			function(index){
				layer.close(index);
				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
				$.ajax({
					url:'/admin/a/msg/content/disable',
					data:{id:id},
					type:'post',
					dataType:'json',
					success:function(result) {
						if (result.code == 2000) {
							getData(1 ,pageNow);
							layer.alert(result.msg, {icon: 1});
						} else {
							layer.alert(result.msg, {icon: 2});
						}
					}
				});
			},  
			function(){}
		);
}


//启用消息
function enable(id) {
	layer.confirm('您确定要启用此消息?', {btn: ['确定','取消']},
			function(index){
				layer.close(index);
				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
				$.ajax({
					url:'/admin/a/msg/content/enable',
					data:{id:id},
					type:'post',
					dataType:'json',
					success:function(result) {
						if (result.code == 2000) {
							getData(0 ,pageNow);
							layer.alert(result.msg, {icon: 1});
						} else {
							layer.alert(result.msg, {icon: 2});
						}
					}
				});
			},  
			function(){}
		);
}
</script>
</html>


