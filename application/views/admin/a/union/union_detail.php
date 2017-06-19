<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>平台管理系统</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<style>
	.detail-add-but{
		margin-left: 120px;
		border: 1px solid rgb(204, 204, 204);
		width: 45px;
		text-align: center;
		border-radius: 3px;
		padding: 3px 0px;
		cursor: pointer;
	}
</style>
</head>
<body>
	
    <div class="page-body" id="bodyMsg">
        <div class="order_detail">
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">联系人姓名:</td>
                        <td class="w_40_p"><?php echo $unionData['linkman']?></td>
                        <td class="order_info_title">联系人电话:</td>
                        <td class="w_40_p"><?php echo $unionData['linkmobile']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行卡号:</td>
                        <td class="w_40_p"><?php echo $unionData['bankcard']?></td>
                        <td class="order_info_title">银行名称:</td>
                        <td class="w_40_p"><?php echo $unionData['bankname']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">开户分行:</td>
                        <td class="w_40_p"><?php echo $unionData['branch']?></td>
                        <td class="order_info_title">持卡人:</td>
                        <td class="w_40_p"><?php echo $unionData['cardholder']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">添加时间:</td>
                        <td><?php echo $unionData['addtime']?></td>
                    </tr>
                </table>
            </div>
            
            <div class="table_con">
                <div class="itab">
                    <ul id="tab-nav">
                        <li data-val="1"><a href="###" class="active">营业部</a></li>
                        <li data-val="2"><a href="###">供应商</a></li>
                    </ul>
                </div>
                <div class="tab_content">
                	<form class="search_form" method="post" id="depart-form" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>营业部</label>
                                <input type="text" name="depart_name" class="search_input" placeholder="营业部名称"/>
                            </div>
                            <div class="search_group">
                            	<label>联系人</label>
                                <input type="text" name="linkman" class="search_input" placeholder="联系人姓名"/>
                            </div>
                            <div class="search_group">
                            	<label>手机号</label>
                                <input type="text" name="mobile" class="search_input" placeholder="手机号"/>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="union_id" value="<?php echo $unionData['id']?>">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    
                    <form class="search_form" method="post" id="supplier-form" action="" style="display:none;">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>供应商</label>
                                <input type="text" name="name" class="search_input" placeholder="供应商"/>
                            </div>
                            <div class="search_group">
                            	<label>负责人</label>
                                <input type="text" name="linkman" class="search_input" placeholder="负责人姓名"/>
                            </div>
                            <div class="search_group">
                            	<label>手机号</label>
                                <input type="text" name="mobile" class="search_input" placeholder="手机号"/>
                            </div>
                            <div class="search_group">
                            	<input type="hidden" name="union_id" value="<?php echo $unionData['id']?>">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                
                    <div class="table_list" style="display:block;" id="depart-list"></div>
                    <div class="table_list" id="supplier-list" style="display:none;"></div>
                </div>
            </div>
            
        </div>
	</div>
	
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
$('#tab-nav').find('li').click(function(){
	if ($(this).find('.active').length == 1) {
		return false;
	}
	$(this).find('a').addClass('active');
	$(this).siblings().find('a').removeClass('active');
	var val = $(this).attr('data-val');
	if (val == 1) {
		$('#depart-form,#depart-list').show();
		$('#supplier-form,#supplier-list').hide();
	} else {
		$('#depart-form,#depart-list').hide();
		$('#supplier-form,#supplier-list').show();
	}
})

//营业部
var deparColumns = [{field : 'name',title : '营业部名称',width : '140',align : 'center'},
        			{field : 'linkman',title : '联系人',width : '140',align : 'center'},
        			{field : 'linkmobile',title : '联系电话',align : 'center', width : '140'},
        			{field : 'addtime',title : '添加时间',align : 'center', width : '140'},
        			{field : 'cash_limit',title : '申请额度',align : 'center', width : '140'},
        			{field : 'credit_limit',title : '信用额度',align : 'center', width : '140'}];

$("#depart-list").pageTable({
	columns:deparColumns,
	url:'/admin/a/unions/union/getUnionDepart',
	pageSize:10,
	searchForm:'#depart-form',
	emptyMsg:'还没有营业部哦！',
	emptyHeight:100,
	tableClass:'table table-bordered table_hover'
});


//供应商
var columns = [ {field : 'company_name',title : '供应商名称',width : '100',align : 'center'},
				{field : 'brand',title : '品牌名称',width : '80',align : 'center'},
	            {field : false,title : '所在地',width : '120',align : 'center',formatter:function(result) {
		        		var address = result.country+result.province+result.city;
		            	return typeof address == 'string' ? address.replace('null' ,'') : address;
		            }
		        },
		        {field : 'addtime',title : '入驻日期',width : '120',align : 'center'},
	            {field : 'realname',title : '负责人',width : '100',align : 'center'},
	            {field : 'mobile',title : '联系电话',width : '100',align : 'center'},
	            {field : 'email',title : '电子邮箱',align : 'center', width : '110'}]
	            	
	$("#supplier-list").pageTable({
		columns:columns,
		url:'/admin/a/unions/union/getUnionSupplier',
		pageSize:10,
		searchForm:'#supplier-form',
		emptyHeight:100,
		tableClass:'table table-bordered table_hover'
	});
	
</script>
</body>
</html>
