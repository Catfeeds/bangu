<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<body>
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
                            	<label>产品编号</label>
                                <input type="text" name="linecode" class="search_input" placeholder="产品编号"/>
                            </div>
                            <div class="search_group">
                            	<label>产品名称</label>
                                <input type="text" name="linename" class="search_input" placeholder="产品名称"/>
                            </div>
                            <div class="search_group">
                            	<label>添加时间</label>
                              	<input type="text" name="startdate" id="startdate" class="search_input" placeholder=""/>
                             	<input type="text" name="enddate" id="enddate" class="search_input" placeholder=""/>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit"  class="search_button" value="搜索"/>
                            	<input type="button" id="add-button" class="search_button" value="添加"/>
                            </div>
                    	</div>
                    </form>
                    <div class="table_list" id="dataTable"></div> 
                </div>
            </div> 
        </div>
    </div>

<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>   
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
var columns = [ {field : 'linecode',title : '产品编号',width : '80',align : 'center'},
        		{field : 'linename',title : '产品',width : '250',align : 'left'},
        		{field : 'linedest',title : '目的地',align : 'center', width : '120'},
        		{field : 'addtime',title : '添加时间',align : 'center', width : '100'},
        		{field : false,title : '供应商',align : 'center', width : '100',
        			formatter: function(item){
            			return item.realname+'/'+item.mobile;
            		}
            	},
         		{field : false,title : '状态',width : '60',align : 'center',
        			formatter: function(item){
            			if(item.status==0){
                			return '未提交';
                		}else if(item.status==1){
                			return '审核中';
                    	}else if(item.status==2){
                    		return '上线';
                        }else if(item.status==3){
                        	return '审核拒绝';
                        }else if(item.status==4){
                        	return '已停售';
                        }else if(item.status==-1){
                        	return '已删除';
                        }else{
                            return item.status;
                        }
            		}
            	},
        		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.line_id+')" class="action_type">修改</a>&nbsp;';
        			return button;
        		}
        	}];
        	
getData(1);
function getData(page) {
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/basics/line_dest/get_line_dest',
		pageSize:15,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}

//编辑
function edit(id) {
	window.top.openWin({
		  type: 2,
		  area: ['900px', '500px'],
		  title :'编辑线路目的地',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/basics/line_dest/get_destData');?>?line_id="+id,
	});
}


$("body").find('#startdate').datetimepicker({
    lang:'ch', //显示语言
    timepicker:false, //是否显示小时
    format:'Y-m-d', //选中显示的日期格式
    formatDate:'Y-m-d',
    validateOnBlur:false,
});

$("body").find('#enddate').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
</script>
</html>



