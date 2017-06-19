<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
.button{padding: 2px 3px;cursor: pointer;background: #1a89ed;color: #fff;border: 1px solid #ccc;border-radius: 3px;}
.li{ width:auto !important; height:24px; line-height:24px; border-left: 1px solid #ccc; border-rigth: 1px solid #ccc; float:none !important; position: relative;}
.liBoxBig{ height:300px; overflow-y: auto;}
.li i {background: url(../../../static/img/ok_msu.png) no-repeat;width: 20px; height: 20px;margin-top: 5px; float: right;margin-right: 5px;}
.city_mune {font-weight:600;}
</style>
<!-- 图片 -->
<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu">×</div>
	<!--<div class="right_box"></div> -->
</div>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>管家管理</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="1">新申请 </li>
			<li class="tab-red" data-val="2">合作中</li>
			<li class="tab-blue" data-val="3">已拒绝</li>
			<li class="tab-blue" data-val="-1">已终止</li>
			<li class="tab-blue" data-val="-2">未提交</li>
			<li class="tab-blue" data-val="5">修改资料中</li>
		</ul>
		<div class="tab-content">
			<a id="add-button" href="<?php echo site_url('admin/a/experts/expert_list/add')?>" target="main" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">专家姓名：</span>
						<span ><input class="search-input" type="text" name="realname" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">专家昵称：</span>
						<span ><input class="search-input" type="text" name="nickname" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">手机号：</span>
						<span ><input class="search-input" type="text" name="mobile" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">邮箱：</span>
						<span ><input class="search-input" type="text" name="email" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">所在地：</span>
						<span id="search-city"></span>
					</li>
					<li class="search-list search-th" style="display:none;">
						<span class="search-title">审核人：</span>
						<span ><input type="text" id="admin" name="username" class="search-input" ></span>
					</li>
					<li class="search-list search-th" style="display:none;">
						<span class="search-title">更新日期：</span>
						<span>
							<input type="text" id="starttime" class="search-input" style="width:110px;" name="starttime" placeholder="开始日期" />
							<input type="text" id="endtime" class="search-input" style="width:110px;"  name="endtime" placeholder="结束日期" />
					 	</span>
					</li>
					<li class="search-list">
						<input type="hidden" value="1" name="status">
						<input type="submit" value="搜索" class="search-button" />
						<input type="button" value="导出" id="export_excel" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<div class="form-box stop-expert">
	<div class="fb-content">
		<div class="box-title">
			<h4>终止与管家合作</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" id="stop-expert" action="#" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">终止理由：<i>*</i></div>
					<div class="fg-input"><textarea name="reason" ></textarea></div>
				</div>
				<div class="form-group">
					<input type="hidden" name="stop_id" />
					<input type="button" class="fg-but fb-close" value="关闭" />
					<input type="submit" class="fg-but" value="确认终止" />
				</div>
			</form>
		</div>
	</div>
</div>

<div class="fb-content" id="talk-box" style="display:none;">
    <div class="box-title">
        <h4>修改个人描述</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="edit-talk-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">个人描述：<i>*</i></div>
                <div class="fg-input"><textarea name="talk"></textarea></div>
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

<div class="fb-content" id="dest-box" style="display:none;">
    <div class="box-title">
        <h4>修改擅长线路</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="edit-dest-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">选择擅长线路：<i>*</i></div>
                <div class="fg-input">
                	<input name="dest_name" readonly="readonly" type="text" />
                	<input name="destid" type="hidden" />
                	<ul class="liBoxBig">
                	<?php 
                		foreach($destArr as $val) {
                			if (!empty($val['lower'])) {
                				echo '<li class="city_mune li">'.$val['kindname'].'</li>';
                				foreach($val['lower'] as $v) {
                					echo '<li class="li" value="'.$v['id'].'">'.$v['kindname'].'</li>';
                				}
                			}
                		}
                	?>
                	</ul>
                </div>
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

<div class="fb-content" id="edit-info" style="display:none;">
    <div class="box-title">
        <h4>发起资料修改</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="edit-info-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">原因：<i>*</i></div>
                <div class="fg-input">
                	<textarea name="reason"></textarea>
                </div>
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

<div class="fb-content" id="vr-info" style="display:none;">
    <div class="box-title">
        <h4>收藏虚拟值修改</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="vr-form" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">虚拟值：<i>*</i></div>
                <div class="fg-input">
                	<input type="text" name="vr_num" >
                </div>
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

<div id="expertDetial"></div>
<!-- 上传头像的弹框 end-->
<div class='avatar_box'></div>
<!-- 尾部 -->
<?php echo $this->load->view('admin/a/expert/expert_line.php');  ?>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.dataDetail.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript">
$('input[name=vr_num]').verifNum();

//导出excel表格
$('#export_excel').click(function(){
	$.ajax({
		url:'/admin/a/experts/expert_list/exportExcel',
		data:$('#search-condition').serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
})

// 新申请
var columns1 = [ {field : false,title : '管家姓名',width : '120',align : 'center',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+' ,3);" style="color:#2DC3E8;">'+item.realname+'</a>';
			}
		},
		{field : 'nickname',title : '昵称',width : '110',align : 'center'},
		{field : 'mobile',title : '手机号',width : '100',align : 'center'},
		{field : 'email',title : '邮箱号',width : '110',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : false,title : '所在地',align : 'center', width : '260',formatter:function(item){
				var rd_name = typeof item.rd_name == 'object' ? '' : item.rd_name
				var cname = typeof item.cid_name == 'object' ? '' : item.cid_name
				return item.pd_name+cname+rd_name;
			}
		},
		{field : 'addtime',title : '申请时间',align : 'center', width : '180'},
		{field : false,title : '营业部',align : 'center', width : '180',formatter:function(result) {
				if (typeof result.union_name == 'object' || result.union_name.length < 1) {
					return '平台';
				} else {
					return result.union_name;
				}
			}
		},
		{field : false,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="detail('+item.id+' ,1)" class="tab-button but-blue"> 通过</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="detail('+item.id+' ,2)" class="tab-button but-red"> 退回</a>';
			return button;
		}
	}];
//合作中
var columns2 = [ {field : false,title : '姓名/昵称',width : '100',align : 'center',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+',3);" style="color:#2DC3E8;">'+item.realname+'/'+item.nickname+'</a>';
			}
		},
// 		{field : 'nickname',title : '昵称',width : '60',align : 'center'},
		{field : 'mobile',title : '手机号',width : '90',align : 'center'},
		{field : 'email',title : '邮箱号',width : '100',align : 'center'},
		//{field : 'idcard',title : '身份证',width : '120',align : 'center'},
		{field : false,title : '所在地',align : 'center', width : '80',formatter:function(item){
				var rd_name = typeof item.rd_name == 'object' ? '' : item.rd_name
				var cname = typeof item.cid_name == 'object' ? '' : item.cid_name
				return item.pd_name+cname+rd_name;
			}
		},
		{field : false,title : '营业部',align : 'center', width : '100',formatter:function(result) {
				if (typeof result.union_name == 'object' || result.union_name.length < 1) {
					return '平台';
				} else {
					return result.union_name;
				}
			}
		},
		{field : 'username',title : '审核人',align : 'center', width : '60'},
		{field : 'modtime',title : '更新时间',align : 'center', width : '100'},
		{field : 'company_name',title : '直属供应商',align : 'center', width : '80'},
		{field : 'apply_num',title : '售卖数量',align : 'center', width : '60'},
		{field : false,title : '操作',align : 'center', width : '120',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="stop('+item.id+')" class="tab-button but-red">终止合作</a>&nbsp;';
			button += '<a href="javascript:void(0);" data-val="'+item.id+'" data-name="'+item.realname+'" onclick="expertLine(this)" class="tab-button but-blue">售卖线路</a>';
			button += '<a href="javascript:void(0);" onclick="edit_info('+item.id+')" class="tab-button but-blue">发起资料修改</a>';
			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改</a>';
			if (item.supplier_id > 0) {
				button += '<a href="javascript:void(0);" onclick="relieve('+item.id+')" class="tab-button but-blue">解除直属关系</a>';
			} else {
				button += '<a href="javascript:void(0);" onclick="bind_supplier('+item.id+')" class="tab-button but-blue">绑定直属供应商</a>';
			}
			if (item.is_commit == 1) {
				button += '<a href="javascript:void(0);" onclick="hidden_c('+item.id+')" class="tab-button but-blue">隐藏</a>';
			} else {
				button += '<a href="javascript:void(0);" onclick="show_c('+item.id+')" class="tab-button but-blue">显示</a>';
			}
			return button;
		}
	}];
//已拒绝
var columns3 = [ {field : false,title : '管家姓名',width : '150',align : 'center',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+',0);" style="color:#2DC3E8;">'+item.realname+'</a>';
			}
		},
		{field : 'nickname',title : '昵称',width : '140',align : 'center'},
		{field : 'mobile',title : '手机号',width : '100',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : false,title : '所在地',align : 'center', width : '260',formatter:function(item){
				var rd_name = typeof item.rd_name == 'object' ? '' : item.rd_name
				var cname = typeof item.cid_name == 'object' ? '' : item.cid_name
				return item.pd_name+cname+rd_name;
			}
		},
		{field : false,title : '营业部',align : 'center', width : '180',formatter:function(result) {
				if (typeof result.union_name == 'object' || result.union_name.length < 1) {
					return '平台';
				} else {
					return result.union_name;
				}
			}
		},
		{field : 'username',title : '审核人',align : 'center', width : '180'},
		{field : 'addtime',title : '申请时间',align : 'center', width : '180'},
		{field : 'modtime',title : '更新时间',align : 'center', width : '180'},
		{field : false,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="back('+item.id+')" class="tab-button but-blue">恢复合作</a>';
			return button;
		}}
	];
//已终止
var columns4 = [ {field : false,title : '管家姓名',width : '150',align : 'center',formatter:function(item){
				return '<a href="javascript:void(0);" onclick="detail('+item.id+',0);" style="color:#2DC3E8;">'+item.realname+'</a>';
			}
		},
		{field : 'nickname',title : '昵称',width : '140',align : 'center'},
		{field : 'mobile',title : '手机号',width : '100',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : false,title : '所在地',align : 'center', width : '260',formatter:function(item){
				var rd_name = typeof item.rd_name == 'object' ? '' : item.rd_name
				var cname = typeof item.cid_name == 'object' ? '' : item.cid_name
				return item.pd_name+cname+rd_name;
			}
		},
		{field : false,title : '营业部',align : 'center', width : '180',formatter:function(result) {
				if (typeof result.union_name == 'object' || result.union_name.length < 1) {
					return '平台';
				} else {
					return result.union_name;
				}
			}
		},
		{field : 'addtime',title : '申请时间',align : 'center', width : '180'},
		{field : false,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="recovery('+item.id+')" class="tab-button but-blue">恢复合作</a>';
			return button;
		}
	}];
//已终止
var columns5 = [ {field : 'realname',title : '管家姓名',width : '150',align : 'center'},
		{field : 'nickname',title : '昵称',width : '140',align : 'center'},
		{field : 'mobile',title : '手机号',width : '140',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : false,title : '所在地',align : 'center', width : '260',formatter:function(item){
				var rd_name = typeof item.rd_name == 'object' ? '' : item.rd_name
				var cname = typeof item.cid_name == 'object' ? '' : item.cid_name
				return item.pd_name+cname+rd_name;
			}
		},
		{field : false,title : '营业部',align : 'center', width : '180',formatter:function(result) {
				if (typeof result.union_name == 'object' || result.union_name.length < 1) {
					return '平台';
				} else {
					return result.union_name;
				}
			}
		},
		{field : 'addtime',title : '申请时间',align : 'center', width : '180'}];
//修改资料中
var columns6 = [ {field : 'realname',title : '管家姓名',width : '150',align : 'center'},
		{field : 'nickname',title : '昵称',width : '140',align : 'center'},
		{field : 'mobile',title : '手机号',width : '140',align : 'center'},
		{field : 'email',title : '邮箱号',width : '140',align : 'center'},
		{field : 'idcard',title : '身份证',width : '140',align : 'center'},
		{field : false,title : '所在地',align : 'center', width : '260',formatter:function(item){
				var rd_name = typeof item.rd_name == 'object' ? '' : item.rd_name
				var cname = typeof item.cid_name == 'object' ? '' : item.cid_name
				return item.pd_name+cname+rd_name;
			}
		},
		{field : false,title : '营业部',align : 'center', width : '180',formatter:function(result) {
				if (typeof result.union_name == 'object' || result.union_name.length < 1) {
					return '平台';
				} else {
					return result.union_name;
				}
			}
		},
		{field : 'addtime',title : '申请时间',align : 'center', width : '180'}];

getData(1);
//导航栏切换
$('.nav-tabs li').click(function(){
	var formObj = $('#search-condition');
	formObj.find("input[type='text']").val('');
	formObj.find("select").val(0).eq(0).nextAll("select").hide();
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('data-val');
	$('input[name="status"]').val(status);
	
	getData(1);
})
function getData(page) {
	var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	var status = $('input[name="status"]').val();
	if (status == 1) {
		$('.search-th').hide();
		var columns = columns1;
	} else if (status == 2) {
		$('.search-th').show();
		var columns = columns2;
	} else if (status == 3) {
		$('.search-th').show();
		var columns = columns3;
	} else if (status == -1) {
		$('.search-th').hide();
		var columns = columns4;
	} else if (status == -2) {
		$('.search-th').hide();
		var columns = columns5;
	} else if (status == 5) {
		$('.search-th').hide();
		var columns = columns6;
	}
	
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/experts/expert_list/getExpertData',
		pageSize:10,
		pageNumNow:page || pageNow,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
}

//隐藏，不在C端显示
function hidden_c(id) {
	layer.confirm('您确定隐藏此管家', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/experts/expert_list/hidden_expert',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(result) {
				if (result.code == 2000) {
					getData();
					layer.closeAll();
					layer.msg(result.msg, {icon: 1});
				} else {
					layer.msg(result.msg, {icon: 2});
				}
			}
		});
		
	});
}
//在C端显示
function show_c(id) {
	layer.confirm('您确定显示此管家', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/experts/expert_list/show_expert',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(result) {
				if (result.code == 2000) {
					getData();
					layer.closeAll();
					layer.msg(result.msg, {icon: 1});
				} else {
					layer.msg(result.msg, {icon: 2});
				}
			}
		});
		
	});
}

//绑定直属供应商
function bind_supplier(id) {
	window.top.openWin({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'绑定直属供应商',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/experts/expert_list/bind_supplier');?>"+"?id="+id
	});
}

function relieve(id) {
	layer.confirm('您确认解除此管家的直属关系？', {btn:['确认' ,'取消']},function(){
		$.ajax({
			url:'/admin/a/experts/expert_list/relieve_bind',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(result) {
				if (result.code == 2000) {
					layer.confirm(result.msg, {btn:['确认']},function(){
						getData();
						layer.closeAll();
					});
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
		
	});
}

$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});

function edit(id) {
	window.top.openWin({
		  type: 2,
		  area: ['800px', '600px'],
		  title :'修改管家资料',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/a/experts/expert_list/edit_view');?>"+"?id="+id
	});
}

//发起资料修改
function edit_info(id) {
	$('#edit-info-form').find('input[name=id]').val(id);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#edit-info')
	});
}

$('#edit-info-form').submit(function(){
	$.ajax({
		url:'/admin/a/experts/expert_list/edit_info',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
				$("#dataTable").pageTable({
					columns:columns2,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageSize:10,
					pageNumNow:pageNow,
					searchForm:'#search-condition',
					tableClass:'table table-bordered table_hover'
				});
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

function detail(id ,type) {
//	var type = type;
	if (type == 0) {
		var butDatas = {};
	} else if (type == 1) {
		var butDatas = {'through':'通过'};
	} else if (type == 2) {
		var butDatas = {'refuse':'退回'};
	}else if(type==3){
		var butDatas = {};
	}
	$.ajax({
		url:'/admin/a/experts/expert_list/getExpertDetails',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('数据查询错误');
			} else {
				if (data.sex == 0) {
					var sex = '女';
				} else if (data.sex == 1) {
					var sex = '男';
				} else {
					var sex = '保密'
				}
				var ra_name = typeof data.ra_name == 'object' ? '' : data.ra_name;
				var cia_name = typeof data.cia_name == 'object' ? '' : data.cia_name;
				var pa_name = typeof data.pa_name == 'object' ? '' : data.pa_name;
				var ca_name = typeof data.ca_name == 'object' ? '' : data.ca_name;
				var address = ca_name+pa_name+cia_name+ra_name;
				// 从业经历
				var resume = new Array();
				if (!$.isEmptyObject(data.resume)) {
					$.each(data.resume ,function(key ,val){
						resume[key] = {'起止时间':val.starttime+'到'+val.endtime,'所在企业':val.company_name,'职务':val.job,'工作描述':val.description};
					})
				}
				//荣誉证书
				var certificate = new Array();
				if (!$.isEmptyObject(data.certificate)) {
					$.each(data.certificate ,function(key ,val){
						certificate[key] = {'证书名称':val.certificate,'扫描件':'<img class="small-img" src="'+val.certificatepic+'" />',};
					})
				}
				var expertPhotocss='background:#1a89ed;border-radius:3px;margin-right:10px;outline:none;border:none;padding:4px 5px !important;color:#fff;';
				var expert_photo="'"+data.small_photo+"'";
				var expertType = data.type == 1 ? '境内管家' : '境外管家';

				if (data.status ==2) {
					dest_html = data.destName+'&nbsp;<button onclick="edit_dest('+data.id+',\''+data.destName+'\',\''+data.expert_dest+'\')" class="button">修改</button>';
					talk_html = data.talk+'&nbsp;<button onclick="edit_talk('+data.id+' ,\''+data.talk+'\')" class="button">修改</button>';
				} else {
					dest_html = data.destName;
					talk_html = data.talk;
				}
	            if(type==3 ||type==2 ||type==1){  //手机端管家图像
	            	var jsonData = [{title:'基本信息',type:'list',data:[
	            	            	{title:'手机号',val:data.mobile},
	            	            	{title:'邮箱号',val:data.email},
            	            		{title:'姓名',val:data.realname},
            	            		{title:'昵称',val:data.nickname},
            	            		{title:'性别',val:sex},
            	            		{title:'微信号',val:data.weixin},
            	            		{title:'身份证正面',val:data.idcardpic,type:'img'},
            	            		{title:'管家头像',val:data.small_photo,type:'img'},
            	            		{title:'身份证反面',val:data.idcardconpic,type:'img'},
            	            		{title:'管家背景',val:data.big_photo,type:'img'},
            	            		{title:'手机端管家头像<input type="button" value="上传" onclick="change_avatar(this,'+data.id+','+expert_photo+');" style="'+expertPhotocss+'">',id:'you',val:data.mobile_photo,type:'img'},
            	            		{title:'身份证号',val:data.idcard},
            	            		{title:'所在地',val:address},
            	            		{title:'擅长线路',val:dest_html},
            	            		{title:'毕业院校',val:data.school},
            	            		{title:'旅游从业',val:data.profession},
            	            		{title:'工作年限',val:data.working},
            	            		{title:'上门服务地区',val:data.cityname},
            	            		{title:'个人描述',val:talk_html,isComplete:true},
	            	            	]},
	            	            	{title:'从业经历',type:'table',data:resume},
	            	            	{title:'荣誉证书',type:'table',data:certificate}
	            	            ];
		            }else{
		            	var jsonData = [{title:'基本信息',type:'list',data:[
            	            			{title:'手机号',val:data.mobile},
            	            			{title:'邮箱号',val:data.email},
            	            			{title:'姓名',val:data.realname},
            	            			{title:'昵称',val:data.nickname},
            	            			{title:'性别',val:sex},
            	            			{title:'微信号',val:data.weixin},
            	            			{title:'身份证号',val:data.idcard},
            	            			{title:'身份证正面',val:data.idcardpic,type:'img'},
            	            			{title:'管家头像',val:data.small_photo,type:'img'},
            	            			{title:'身份证反面',val:data.idcardconpic,type:'img'},
            	            			{title:'管家背景',val:data.big_photo,type:'img'},
            	            			{title:'所在地',val:address},
            	            			{title:'擅长线路',val:dest_html},
            	            			{title:'个人简介',val:data.beizhu},
            	            			{title:'上门服务地区',val:data.cityname},
            	            			{title:'个人描述',val:talk_html,isComplete:true},
            	            		]},
            	            			{title:'从业经历',type:'table',data:resume},
            	            			{title:'荣誉证书',type:'table',data:certificate}
            	                ];
			        }
				if (type == 2) {
					jsonData.push({title:'退回原因',type:'list',data:[
					              		{'title':'退回原因',val:{name:'refuse_reasion'},type:'textarea',isComplete:true}
					              	]
	              				});
				}
				$("#expertDetial").dataDetail({
					title:expertType+'：'+data.realname,
					jsonData:jsonData,
					butDatas:butDatas,
					isSimple:false,
					id:data.id,
					butClick:buttonClick
				});
			}
		}
	});
}

function edit_talk(id ,content) {
	$('#talk-box').find('textarea[name=talk]').val(content.trim());
	$('#talk-box').find('input[name=id]').val(id);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#talk-box')
	});
}

function edit_dest(id ,name ,destid) {
	$('#dest-box').find('input[name=dest_name]').val(name);
	$('#dest-box').find('input[name=destid]').val(destid);
	$('#dest-box').find('input[name=id]').val(id);
	$('.liBoxBig').find('li').find('i').remove();
	
	var destArr = destid.split(',');
	$.each(destArr ,function(k ,v) {
		$('.liBoxBig').find('li').each(function(){
			var value = $(this).attr('value');
			if (value == v) {
				$(this).append("<i></i>");
			}
		})
	})
	
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#dest-box')
	});
}

$('#edit-talk-form').submit(function(){
	var content = $(this).find('textarea').val();
	if (content.length < 1) {
		layer.alert('请填写个人描述', {icon: 2});
		return false;
	}
	$.ajax({
		url:'/admin/a/experts/expert_list/update_talk',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
				$(".detail-box,.maskLayer").hide();
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

$('#edit-dest-form').submit(function(){
	$.ajax({
		url:'/admin/a/experts/expert_list/update_dest',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
				$(".detail-box,.maskLayer").hide();
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

function buttonClick(){
	//通过管家申请
	var ts = true;
	$(".through").click(function(){
		var id = $(this).attr('data-val');
		if (ts == false) {
			return false;
		} else {
			ts = false;
		}
		$.post("/admin/a/experts/expert_list/through_expert",{'id':id},function(data){
			ts = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".detail-box,.maskLayer").hide();
			} else {
				alert(data.msg);
			}
		});
	})
	//拒绝管家申请
	var rs = true;
	$(".refuse").click(function(){
		if (rs == false) {
			return false;
		} else {
			rs = false;
		}
		var id = $(this).attr('data-val');
		var refuse_reasion = $("textarea[name='refuse_reasion']").val();
		$.post("/admin/a/experts/expert_list/refuse_expert",{'id':id,refuse_reasion:refuse_reasion},function(data){
			rs = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".detail-box,.maskLayer").hide();
			} else {
				alert(data.msg);
			}
		});
	})
}
//终止与管家合作
var ss = true;
$("#stop-expert").submit(function(){
	if (ss == false) {
		return false;
	} else {
		ss = false;
	}
	$.post("/admin/a/experts/expert_list/stop_expert",$(this).serialize(),function(data){
		ss = true;
		var data = eval('('+data+')');
		if (data.code == 2000) {
			$("#dataTable").pageTable({
				columns:columns2,
				url:'/admin/a/experts/expert_list/getExpertData',
				pageNumNow:1,
				searchForm:'#search-condition',
				tableClass:'table-data'
			});
			alert(data.msg);
			$('.stop-expert,.mask-box').hide();
		} else {
			alert(data.msg);
		}
	});
	return false;
});
//恢复与管家合作
var res = true;
function recovery(id) {
	if (res == false) {
		return false;
	} else {
		res = false;
	} 
	var status = $('input[name="status"]');
	if (confirm('确定要恢复与管家的合作')) {
		$.post("/admin/a/experts/expert_list/recovery",{id:id},function(json){
			res = true;
			var data = eval('('+json+')');
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns4,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		})
	} else {
		res = true;
	}
	return false;
}

function back(id) {
	if (res == false) {
		return false;
	} else {
		res = false;
	} 
	var status = $('input[name="status"]');
	if (confirm('确定要恢复与管家的合作')) {
		$.post("/admin/a/experts/expert_list/back",{id:id},function(json){
			res = true;
			var data = eval('('+json+')');
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns4,
					url:'/admin/a/experts/expert_list/getExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		})
	} else {
		res = true;
	}
	return false;
}
function stop(id) {
	$('input[name="stop_id"]').val(id);
	$('textarea[name="reason"]').val('');
	$('.stop-expert,.mask-box').show();
}

function change_avatar(obj,expert_id,url){
	$('.avatar_box').show();

	/*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	xiuxiu.setLaunchVars("cropPresets", "375x265");
	xiuxiu.embedSWF("altContent",5,'100%','100%');
    //修改为您自己的图片上传接口
	//xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
	xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/expert_moblie_img'); ?>");
    xiuxiu.setUploadType(2);
    xiuxiu.setUploadDataFieldName("uploadFile");
    xiuxiu.setUploadArgs({expertid:expert_id});
	xiuxiu.onInit = function ()
	{
		//默认图片
		xiuxiu.loadPhoto("<?php echo site_url();?>"+url);
	}
	xiuxiu.onUploadResponse = function (data)
	{
		data = eval('('+data+')');
		if (data.code == 2000) {
			alert('上传成功！');
			$(obj).parent().parent().find("img").attr("src",data.msg);
			$('.close_xiu').click();
			
		} else {
			alert(data.msg);
		}
	}
	$("#img_upload").show();
	$('.close_xiu').show();
}
$(document).mouseup(function(e) {
	var _con = $('#img_upload'); // 设置目标区域
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		$("#img_upload").hide()
		$('.avatar_box').hide();
		$('.close_xiu').hide();
	}
})
$('.close_xiu').click(function(){
	$("#img_upload").hide()
	$('.avatar_box').hide();
	$('.close_xiu').hide();
})
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$.post('/admin/a/comboBox/getAdminData', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.realname,
		    value : val.id
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#admin",
	    name : "admin_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})

$(".liBoxBig .li").click(function(){
	if($(this).hasClass('city_mune')){
		return false;
	}
	
	var len = $('.liBoxBig').find('li').find('i').length;
	if($(this).find("i").length == 0){
		if(len >=5) {
			layer.alert('擅长目的地最多可以选择5个', {icon: 2});
			return false;
		}
		$(this).append("<i></i>");
		
	}else{
		$(this).find("i").remove();
	}
	var name = '';
	var ids = '';
	$('.liBoxBig').find('li').each(function(){
		if ($(this).find('i').length) {
			name = name+','+$(this).text();
			ids = ids+','+$(this).attr('value');
		}
	})
	$('#dest-box').find('input[name=destid]').val(ids);
	$('#dest-box').find('input[name=dest_name]').val(name);
})
</script>