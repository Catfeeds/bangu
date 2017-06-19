<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
		.search-time input{width:110px;}
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">营业部银行卡管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>旅行社</label>
                                <input type="text" name="union_name" class="search_input" placeholder="旅行社"/>
                            </div>
                            <div class="search_group">
                            	<label>营业部</label>
                                <input type="text" name="depart_name" class="search_input" placeholder="营业部"/>
                            </div>
                            <div class="search_group">
                            	<label>营业部状态</label>
                                <select style="width:100px;" name="status">
                                	<option value="0">请选择</option>
                                	<option value="1">正常</option>
                                	<option value="-1">关闭</option>
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

<div class="fb-content" id="bank-box" style="display:none;">
    <div class="box-title">
        <h4>银行卡管理</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">旅行社：</div>
                <div class="fg-input"><input type="text" name="union_name" disabled="disabled"></div>
            </div>
 			<div class="form-group">
                <div class="fg-title">营业部：</div>
                <div class="fg-input"><input type="text" name="depart_name" disabled="disabled"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">银行名称：<i>*</i></div>
                <div class="fg-input"><input type="text" name="bankname"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">银行卡号：<i>*</i></div>
                <div class="fg-input"><input type="text" name="bankcard"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">开户支行：<i>*</i></div>
                <div class="fg-input"><input type="text" name="branch"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">持卡人：<i>*</i></div>
                <div class="fg-input"><input type="text" name="cardholder"></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="depart_id" value="">
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
<script>
$('input[name=bankcard]').verifNum();
//申请中
var columns = [ {field : 'depart_name',title : '营业部',width : '140',align : 'center'},
        		{field : 'union_name',title : '旅行社',width : '140',align : 'center'},
        		{field : false,title : '营业部状态',width : '100',align : 'center',formatter:function(result) {
						return result.status == 1 ? '正常' : '关闭';
            		}
        		},
        		{field : 'bankname',title : '银行名称',align : 'center', width : '120'},
        		{field : 'branch',title : '开户支行',align : 'center', width : '120'},
        		{field : 'bankcard',title : '银行卡号',align : 'center', width : '120'},
        		{field : 'cardholder',title : '持卡人',align : 'center', width : '120'},
        		{field : false,title : '操作',align : 'center', width : '90',formatter:function(result) {
						return '<a href="javascript:void(0);" onclick="edit('+result.departId+')" class="action_type">编辑</a>';
            		}
        		}]

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/unions/depart_bank/getDepartBankJson',
	pageSize:10,
	searchForm:'#search-condition',
	tableClass:'table table-bordered table_hover'
});

function edit(id) {
	$.ajax({
		url:'/admin/a/unions/depart_bank/detail',
		data:{depart_id:id},
		type:'post',
		dataType:'json',
		success:function(result) {
			if (!$.isEmptyObject(result)) {
				var formObj = $('#add-form');
				formObj.find('input[name=union_name]').val(result.union_name);
				formObj.find('input[name=depart_name]').val(result.depart_name);
				formObj.find('input[name=depart_id]').val(result.departId);
				formObj.find('input[name=bankcard]').val(result.bankcard);
				formObj.find('input[name=bankname]').val(result.bankname);
				formObj.find('input[name=branch]').val(result.branch);
				formObj.find('input[name=cardholder]').val(result.cardholder);
				layer.open({
					  type: 1,
					  title: false,
					  closeBtn: 0,
					  area: '560px',
					  shadeClose: false,
					  content: $('#bank-box')
				});
			} else {
				layer.alert('营业部不存在', {icon: 2});
			}
		}
	});
}

$('#add-form').submit(function(){
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/unions/depart_bank/update',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/unions/depart_bank/getDepartBankJson',
					pageSize:10,
					searchForm:'#search-condition',
					tableClass:'table table-bordered table_hover',
					pageNumNow:pageNow
				});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
</script>
</html>


