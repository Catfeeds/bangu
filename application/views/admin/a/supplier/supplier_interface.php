<!DOCTYPE html>
<html>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
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
            <a href="#">供应商对接管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="1"><a href="#" class="active">供应商列表</a></li> 
                       <!--  <li data-val="0"><a href="#" class="">已停用</a></li>  -->
                    </ul>
                </div>
                <div class="tab_content">
                	<div class="add_btn btn_green" onclick="add();">添加</div>
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>供应商名称</label>
                                <input type="text" name="supplier_name"  id="supplier_name" class="search_input" placeholder="供应商名称" />
                            </div>
                            <div class="search_group">
                            	<label>负责人</label>
                                <input type="text" name="realname" class="search_input"  placeholder="供应商品牌" />
                            </div>
                            <div class="search_group">
                            	<label>手机号</label>
                                <input type="text" name="mobile" class="search_input"  placeholder="手机号" />
                            </div>
                             <div class="search_group">
                            	<label>供应商品牌</label>
                                <input type="text" name="brand" class="search_input"  placeholder="供应商品牌" />
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
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script> 
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>

var columns1 = [ {field : 'company_name',title : '供应商名称',width : '250',align : 'center'},
        		{field : 'brand',title : '品牌名称',width : '200',align : 'center'},
        		{field : 'realname',title : '负责人',width : '200',align : 'center',},
        		{field : 'mobile',title : '联系电话',width : '200',align : 'center'},
        		{field : 'appkey',title : '供应商应用ID',width : '250',align : 'center'},
        		{field : 'secret',title : '秘钥',width : '250',align : 'center'}
       
        	];
/* var columns2 = [ {field : 'title',title : '消息标题',width : '200',align : 'center'},
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
         	}]; */
        	
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
		var columns = columns1;
	} else if (status == 1) {
		var columns = columns1;
	}
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		//url:'/admin/a/msg/main/getMsgMainData',
		url:'/admin/a/supplier/get_supplier_secretkey',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}



function add(){
	window.top.openWin({
		  type: 2,
		  area: ['1000px', '600px'],
		  title :'添加供应商',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('/admin/a/supplier/add_interface');?>"
	});
}


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
	    id : "#supplier_name",
	    name : "supplier_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
</script>
</html>


