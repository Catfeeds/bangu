<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
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
            <a href="#">旅行社管理</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="itab">
                    <ul class="tab-nav"> 
                        <li data-val="1"><a href="#" class="active">已启用</a></li> 
                        <li data-val="-1"><a href="#" class="">已停用</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                	<div class="add_btn btn_green" onclick="add_union();">添加</div>
                	<form class="search_form" method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>旅行社</label>
                                <input type="text" name="name" class="search_input" placeholder="旅行社名称"/>
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
    
<div class="fb-content" id="disable-box" style="display:none;">
    <div class="box-title">
        <h4>停用旅行社</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="disable-union" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">停用原因：<i>*</i></div>
                <div class="fg-input"><textarea name="remark" maxlength="150"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<div class="fb-content" id="union-box" style="display:none;">
    <div class="box-title">
        <h4>旅行社管理</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">旅行社名称：<i>*</i></div>
                <div class="fg-input"><input type="text" name="union_name"></div>
            </div>
 			<div class="form-group">
                <div class="fg-title">联系人：<i>*</i></div>
                <div class="fg-input"><input type="text" name="linkman"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">联系人手机：<i>*</i></div>
                <div class="fg-input"><input type="text" name="linkmobile"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">管理员账号：<i>*</i></div>
                <div class="fg-input"><input type="text" name="loginname"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">管理员姓名：<i>*</i></div>
                <div class="fg-input"><input type="text" name="realname"></div>
            </div>
            <div class="form-group union-admin">
                <div class="fg-title">管理员密码：<i>*</i></div>
                <div class="fg-input"><input type="text" name="password"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">选择所在地：<i>*</i></div>
                <div class="fg-input" id="form-city"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">银行名称：<i>*</i></div>
                <div class="fg-input"><input type="text" name="bankname"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">银行卡号：<i>*</i></div>
                <div class="fg-input"><input type="text" name="bankcard"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">开户支行：<i>*</i></div>
                <div class="fg-input"><input type="text" name="branch"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">持卡人：<i>*</i></div>
                <div class="fg-input"><input type="text" name="cardholder"></div>
            </div>

            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<div class="order_detail" id="detail-box" style="display:none;">
	<form method="post" id="detail-form">
		<input type="hidden" name="detail_id" value="" />
	</form>
	<h2 class="lineName headline_txt">旅行社详细</h2>
</div>  
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>

<script>
$('input[name=bankcard]').verifNum();
$('input[name=linkmobile]').verifNum();

function detail(id) {
	window.top.openWin({
		  type: 2,
		  area: ['1020px', '600px'],
		  title :'旅行社信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/unions/union/detail');?>"+"?id="+id
	});
}

var columns1 = [ {field : false,title : '旅行社名称',width : '120',align : 'center',formatter:function(item) {
						return '<a href="javascript:void(0);" onclick="detail('+item.id+')" >'+item.union_name+'</a>';
					}
				},
        		{field : 'linkman',title : '联系人',width : '140',align : 'center'},
        		{field : 'linkmobile',title : '联系手机',width : '140',align : 'center'},
        		{field : 'username',title : '最后修改人',align : 'center', width : '60'},
        		{field : 'addtime',title : '添加时间',align : 'center', width : '200'},
        		{field : 'loginname',title : '分配账号',align : 'center', width : '200'},
        		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="disable('+item.id+');" class="action_type">停用</a>';
        			return button;
        		}
        	}];
var columns2 = [ {field : false,title : '旅行社名称',width : '120',align : 'center',formatter:function(item) {
						return '<a href="javascript:void(0);" onclick="detail('+item.id+')" >'+item.union_name+'</a>';
					}
				},
        		{field : 'linkman',title : '联系人',width : '140',align : 'center'},
        		{field : 'linkmobile',title : '联系手机',width : '140',align : 'center'},
        		{field : 'username',title : '最后修改人',align : 'center', width : '60'},
        		{field : 'addtime',title : '添加时间',align : 'center', width : '200'},
        		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">修改</a>&nbsp;';
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
	if (status == -1) {
		var columns = columns2;
	} else if (status == 1) {
		var columns = columns1;
	}
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/unions/union/getUnionJson',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table table-bordered table_hover'
	});
}
//添加旅行社
function add_union() {
	var addObj = $('#add-form');
	addObj.find('input[type=text]').val('');
	addObj.find('input[type=hidden]').val('');
	addObj.find('select').val(0);
	addObj.find('select').eq(0).nextAll().hide();
	$('.union-admin').show();
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#union-box')
	});
}

//编辑旅行社
function edit(id) {
	$.ajax({
		url:'/admin/a/unions/union/getUnionDetail',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(result) {
			if ($.isEmptyObject(result)) {
				layer.alert('木有找到旅行社哟!', {icon: 2});
			} else {
				var editObj = $('#add-form');
				editObj.find('input[name=union_name]').val(result.union_name);
				editObj.find('input[name=linkman]').val(result.linkman);
				editObj.find('input[name=linkmobile]').val(result.linkmobile);
				editObj.find('input[name=bankcard]').val(result.bankcard);
				editObj.find('input[name=bankname]').val(result.bankname);
				editObj.find('input[name=branch]').val(result.branch);
				editObj.find('input[name=cardholder]').val(result.cardholder);
				editObj.find('input[name=id]').val(result.id);
				editObj.find('select[name=country]').val(result.country).change();
				editObj.find('select[name=province]').val(result.province).change();
				editObj.find('select[name=city]').val(result.city);
				$('.union-admin').hide();
				layer.open({
					  type: 1,
					  title: false,
					  closeBtn: 0,
					  area: '560px',
					  shadeClose: false,
					  content: $('#union-box')
				});
			}
		}
	});
}

$('#add-form').submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id < 1 ? '/admin/a/unions/union/add' : '/admin/a/unions/union/edit';
	var status = $('#search-condition').find('input[name=status]').val();
	$.ajax({
		url:url,
		data:$(this).serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			if (result.code == 2000) {
				getData(status);
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

//停用旅行社
function disable(id) {
	$('#disable-union').find('input[name=id]').val(id);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#disable-box')
	});
}

$('#disable-union').submit(function(){
	var id = $(this).find('input[name=id]').val();
	var remark = $(this).find('textarea[name=remark]').val();
	$.ajax({
		url:'/admin/a/unions/union/disable',
		data:{id:id,remark:remark},
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				getData(1);
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

//启用旅行社
function enable(id) {
	layer.msg('您确定要启用用此旅行社吗？', {
		time: 0, //不自动关闭
		btn: ['确定', '取消'],
		yes: function(index){
			$.ajax({
				url:'/admin/a/unions/union/enable',
				data:{id:id},
				type:'post',
				dataType:'json',
				beforeSend:function() {//ajax请求开始时的操作
					layer.close(index);
					layer.load(2);
    			},
    			complete:function(){//ajax请求结束时操作
    				layer.closeAll('loading');
    			},
				success:function(result) {
					if (result.code == 2000) {
						getData(-1);
						layer.alert(result.msg, {icon: 1});
					} else {
						layer.alert(result.msg, {icon: 2});
					}
				}
			});
		}
	});
}

$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#form-city').selectLinkage({
			jsonData:data,
			width:'145px',
			names:['country','province','city']
		});
	}
});
</script>
</html>


