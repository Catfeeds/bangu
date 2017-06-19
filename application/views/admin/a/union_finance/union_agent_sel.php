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
		.search-time input{width:110px;}
		.search_admin {display:none;}
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
            <a href="#">联盟佣金查询</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>名称</label>
                                <input type="text" name="union_name" class="search_input" placeholder="联盟名称"/>
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
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>

<script>
function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1020px', '600px'],
		  title :'旅行社佣金详细',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('/admin/a/union_finance/union_agent_sel/detail');?>"+"?id="+id
	});
}


var columns = [ {field : 'union_name',title : '旅行社',width : '120',align : 'center'},
        		{field : 'total_turnover',title : '累计营业额',width : '120',align : 'center'},
        		{field : 'not_settle_agent',title : '未结算佣金',width : '100',align : 'center'},
        		{field : 'settle_agent',title : '已结算佣金',align : 'center', width : '120'},
        		{field : false,title : '累计佣金',align : 'center', width : '120' ,formatter:function(result) {
						return (result.settle_agent *1 + result.not_settle_agent*1).toFixed(2);
            		}
        		},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
        				return '<a href="javascript:void(0)" onclick="detail('+result.id+')" class="action_type">查看详细</a>';
            		}
        		}]

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/union_finance/union_agent_sel/getUnionAgentJson',
	pageSize:10,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});
</script>
</html>


