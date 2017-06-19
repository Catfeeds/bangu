<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>消息通知</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo base_url() ;?>assets/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?php echo base_url() ;?>assets/css/weather-icons.min.css" rel="stylesheet" />
	<script src="<?php echo base_url() ;?>assets/js/jquery-1.11.1.min.js"></script>
	<!--[if lte IE 8]>
		<link href="/assets/css/ie8-style.css" rel="stylesheet" />
	<![endif]-->
	<!--[if lte IE 9]>
		<link href="/assets/css/ie8-style.css" rel="stylesheet" />
	<![endif]-->
</head>
<body>
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">消息通知</a>
        </div>
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>标题</label>
                                <input type="text" name="title" class="search_input" placeholder="消息标题"/>
                            </div>
                            <div class="search_group">
                            	<label>状态</label>
                                <select name="status" style="width:186px;">
                                	<option value="-1" selected="selected">请选择</option>
                                	<option value="0">未读</option>
                                	<option value="1">已读</option>
                                	<option value="2">已完成</option>
                                </select>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="expert_id" value="<?php echo $expert_id;?>">
                            	<input type="hidden" name="supplier_id" value="<?php echo $supplier_id;?>">
                            	<input type="hidden" name="employee_id" value="<?php echo $employee_id;?>">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>
    
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>

<script>
var columns = [ {field : 'title',title : '消息标题',width : '140',align : 'center'},
        		{field : 'sendman',title : '发起人',width : '100',align : 'center'},
        		{field : 'content',title : '消息内容',width : '300',align : 'center'},
        		{field : 'addtime',title : '发送时间',align : 'center', width : '110'},
        		{field : false,title : '消息状态',align : 'center', width : '90',formatter:function(result){
						if (result.status == 0) {
							return '未读';
						} else if (result.status == 1) {
							return '已读';
						} else if (result.status == 2) {
							return '已完成';
						} else {
							return '未知';
						}
            		}
        		},
        		{field : false,title : '操作',align : 'center', width : '80',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="see('+item.id+')" class="action_type">查看</a>&nbsp;';
        			return button;
        		}
        	}];

$("#dataTable").pageTable({
	columns:columns,
	url:'/msg/t33_msg_list/getMsgSendData',
	pageSize:10,
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

function see(id) {
	window.top.openWin({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'消息详细',
		  fix: true, //不固定
		  maxmin: true,
			content: "<?php echo base_url('msg/t33_msg_list/detail');?>"+"?id="+id
	});
}
</script>
</html>


