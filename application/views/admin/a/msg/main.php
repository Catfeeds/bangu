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
            <a href="#">消息管理</a>
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
                	<div class="add_btn btn_green" onclick="add();">添加</div>
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>标题</label>
                                <input type="text" name="title" class="search_input" />
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
var type = {1:'下订单',2:'额度申请',3:'交款系列',4:'付款系列',5:'改应收',6:'改应付(销售发起)',7:'改应付(供应商发起)',8:'改外交佣金',9:'改平台佣金',10:'退款系列',11:'新增参团人',12:'认款系列',13:'线路审核'};
var columns1 = [ {field : 'title',title : '消息标题',width : '200',align : 'center'},
        		{field : 'code',title : '编号',width : '140',align : 'center'},
        		{field : false,title : '业务类型',width : '120',align : 'center',formatter:function(result){
            			if (typeof type[result.type] == 'undefined') {
            				return '';
                		} else {
                			return type[result.type];
                    	}
            		}
        		},
        		{field : 'addtime',title : '添加时间',width : '140',align : 'center'},
        		{field : 'admin_name',title : '操作人',width : '140',align : 'center'},
        		{field : 'remark',title : '备注',width : '200',align : 'center'},
        		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">编辑</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="see('+item.id+');" class="action_type">查看节点</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="node('+item.id+');" class="action_type">配置节点</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="disable('+item.id+');" class="action_type">停用</a>';
        			return button;
        		}
        	}];
var columns2 = [ {field : 'title',title : '消息标题',width : '200',align : 'center'},
         		{field : 'code',title : '编号',width : '140',align : 'center'},
         		{field : false,title : '业务类型',width : '120',align : 'center',formatter:function(result){
	        			if (typeof type[result.type] == 'undefined') {
	        				return '';
	            		} else {
	            			return type[result.type];
	                	}
	        		}
	    		},
         		{field : 'addtime',title : '添加时间',width : '140',align : 'center'},
         		{field : 'admin_name',title : '操作人',width : '140',align : 'center'},
         		{field : 'remark',title : '备注',width : '200',align : 'center'},
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
		url:'/admin/a/msg/main/getMsgMainData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

function see(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1000px', '600px'],
		  title :'查看消息节点',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/msg/main/see_point');?>?id="+id
	});
}

//配置节点
function node(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1000px', '600px'],
		  title :'配置消息节点',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/msg/main/add_point');?>?id="+id
	});
}

function edit(id){
	window.top.openWin({
		  type: 2,
		  area: ['600px', '500px'],
		  title :'编辑消息标题',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/msg/main/uploadMain');?>?id="+id
	});
}


function add(){
	window.top.openWin({
		  type: 2,
		  area: ['600px', '500px'],
		  title :'添加消息标题',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/msg/main/uploadMain');?>"
	});
}

//停用消息
function disable(id) {
	layer.confirm('您确定要停用?', {btn: ['确定','取消']},
			function(index){
				layer.close(index);
				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
				$.ajax({
					url:'/admin/a/msg/main/disable',
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
	layer.confirm('您确定要启用?', {btn: ['确定','取消']},
			function(index){
				layer.close(index);
				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
				$.ajax({
					url:'/admin/a/msg/main/enable',
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


