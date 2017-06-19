<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">游记管理</li>
		</ul>
	</div>
		<ul class="nav nav-tabs">
			<li class="active" status="1"><a>审核中 </a></li>
			<li class="tab-red" status="2"><a>已拒绝</a></li>
			<li class="tab-blue" status="3"><a>已下线</a></li>
			<li class="tab-blue" status="4"><a>全部游记</a></li>
		</ul>
		<div class="tab-content">
			<form action="<?php echo site_url("admin/a/travel_note/getTravelComplainJson")?>" id='search_condition' class="form-inline" method="post">
				<div class="form-group dataTables_filter search_div fl">
					<span class="search_title fl" style="position:relative;top:4px;">游记标题:</span>
					<input type="text" class="form-control fl" name="title">
				</div>
				<div class="form-group dataTables_filter search_div fl">
					<span class="search_title fl time_name" style="position:relative;top:4px;">申诉时间:</span>
					<input type="text" class="form-control fl" style="width:120px;" placeholder="开始时间" id="starttime" name="starttime" >
					<input type="text" class="form-control fl" style="width:120px;" placeholder="结束时间" id="endtime" name="endtime" >
				</div>
				<input type="hidden" value="1" name="status">
				<input type="hidden" value="1" name="page_new" class="page_new" />
				<button type="submit" class="btn btn-darkorange active fl"  style="margin:10px;">搜索</button>
			</form>
			<br/>
			<div class="dataTables_wrapper form-inline no-footer">
				<table class="table table-striped table-hover table-bordered dataTable no-footer" >
					<thead id="pagination_title"></thead>
					<tbody id="pagination_data"></tbody>
				</table>
			</div>
			<div class="pagination" id="pagination"></div>
		</div>
	
</div>
<!--游记详细 -->
<div class="travel_info">
	<div class="travel_explain">
		<div class="travel_title">沙巴之旅,享受路程</div>
		<div class="travel_author">——管家&nbsp;:&nbsp;玺凡&nbsp;&nbsp;(2015-07-05 13:25:32)</div>
	</div>
	<div class="travel_close close_switch">X</div>
	<div class="travel_name travel_ln">线路名称：天堂10日游</div>
	<div class="travel_name travel_sn">供应商名称：中国移动有限公司</div>
	<div class="clear"></div>
<!-- 	<div class="travel_content"> -->
<!-- 		<div><span class="content_title">主要内容：</span><span class="main_content"></span></div> -->
<!-- 	</div> -->
	<div class="travel_content">
		<div><span class="content_title">吃：</span><span class="eat_content"></span></div>
		<div class="travel_pic eat_pic">
			<img src="" width="250" height="150" />
		</div>
	</div>
	<div class="travel_content">
		<div><span class="content_title">住：</span><span class="live_content"></span></div>
		<div class="travel_pic live_pic">
			<img src="" width="250" height="150" />
		</div>
	</div>
	<div class="travel_content">
		<div><span class="content_title">行：</span><span class="co_content"></span></div>
		<div class="travel_pic co_pic">
			<img src="" width="250" height="150" />
		</div>
	</div>
	<div class="travel_content travel_supplier" style="display:none;">
		<div class="supplier_complain"><span class="content_title">供应商申诉内容：</span><span class="complain_content"></span></div>
	</div>
	<div class="travel_content travel_reason" style="display:none;">
		<div class=""><span class="content_title">处理意见：</span><textarea name="remark" cols="80" rows="5"></textarea></div>
	</div>
	<div class="travel_button">
		<input type="hidden" name="travel_id" value="" />
		<input type="hidden" name="complain_id" value="" />
		<input type="hidden" name="type" value="" />
		<div class="travel_close">关闭</div>
		<div class="submit_button">通过</div>
	</div>
</div>
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>


//审核中
var columns1 = [ {field : 'addtime',title : '申诉时间',width : '150',align : 'left'},
		{field : 'title',title : '游记标题',width : '200',align : 'left',length:20},
		{field : 'shownum',title : '浏览人数',width : '100',align : 'center'},
		{field : 'number',title : '参团人数',align : 'center', width : '100'},
		{field : null,title : '发布人类型',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return '管家'
				} else {
					if (typeof item.meid == "string" && item.mestatus == 1) {
						return '体验师'
					} else {
						return '会员'
					}
				}
			}
		},
		{field : null,title : '发布人名称',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return item.realname;
				} else {
					return item.truename;
				}
			}
		},
		{field : 'usedate',title : '出团日期',align : 'center', width : '120'},
		{field : 'supplier_name',title : '供应商名称',align : 'center', width : '200',length:15},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(val){
			var button = '<a href="javascript:void(0);" onclick="show_travel('+val.travel_note_id+' ,3 ,'+val.id+')"  class="btn btn-info btn-xs">查看申诉</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="show_travel('+val.travel_note_id+' ,1 ,'+val.id+')" class="btn btn-info btn-xs"> 通过</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="show_travel('+val.travel_note_id+' ,2 ,'+val.id+')" class="btn btn-danger btn-xs">拒绝</a>';	
			return button;
		}
	}];
//已拒绝
var columns2 = [ {field : 'addtime',title : '申诉时间',width : '150',align : 'left'},
		{field : 'title',title : '游记标题',width : '200',align : 'left',length:20},
		{field : 'shownum',title : '浏览人数',width : '100',align : 'center'},
		{field : 'number',title : '参团人数',align : 'center', width : '100'},
		{field : null,title : '发布人类型',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return '管家'
				} else {
					if (typeof item.meid == "string" && item.mestatus == 1) {
						return '体验师'
					} else {
						return '会员'
					}
				}
			}
		},
		{field : null,title : '发布人名称',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return item.realname;
				} else {
					return item.truename;
				}
			}
		},
		{field : 'remark',title : '处理意见',align : 'center', width : '150',length:15},
		{field : 'usedate',title : '出团日期',align : 'center', width : '120'},
		{field : 'orderAddtime',title : '下单时间',align : 'center', width : '150'}
	];	
//已下线
var columns3 = [ {field : 'addtime',title : '发布时间',width : '150',align : 'left'},
		{field : 'title',title : '游记标题',width : '',align : 'left',length:20},
		{field : 'shownum',title : '浏览人数',width : '100',align : 'center'},
		{field : 'number',title : '参团人数',align : 'center', width : '100'},
		{field : null,title : '发布人类型',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return '管家'
				} else {
					if (typeof item.meid == "string" && item.mestatus == 1) {
						return '体验师'
					} else {
						return '会员'
					}
				}
			}
		},
		{field : null,title : '发布人名称',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return item.realname;
				} else {
					return item.truename;
				}
			}
		},
		{field : 'usedate',title : '出团日期',align : 'center', width : '120'},
		{field : 'orderAddtime',title : '下单时间',align : 'center', width : '150'}
	];
//全部游记
var columns4 = [ {field : 'addtime',title : '发布时间',width : '150',align : 'left'},
		{field : 'title',title : '游记标题',width : '',align : 'left',length:20},
		{field : 'shownum',title : '浏览人数',width : '100',align : 'center'},
		{field : 'number',title : '参团人数',align : 'center', width : '100'},
		{field : null,title : '发布人类型',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return '管家'
				} else {
					if (typeof item.meid == "string" && item.mestatus == 1) {
						return '体验师'
					} else {
						return '会员'
					}
				}
			}
		},
		{field : null,title : '发布人名称',align : 'center', width : '120',formatter:function(item){
				if (item.usertype == 1) {
					return item.realname;
				} else {
					return item.truename;
				}
			}
		},
		{field : 'usedate',title : '出团日期',align : 'center', width : '120'},
		{field : 'orderAddtime',title : '下单时间',align : 'center', width : '150'},
		{field : null,title : '状态',align : 'center', width : '100',formatter:function(val){
				if (typeof val.status == 2) {
					return '审核中';
				} else if (val.status == 1) {
					return '正常';
				} else if (val.status == -2) {
					return '下线';
				}
			}
		},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '';
			if (item.status == 1) {
				button += '<a href="javascript:void(0);" onclick="show_travel('+item.id+' ,4)" class="btn btn-info btn-xs">下线</a>&nbsp;';
				
				if (item.is_essence == 0) {
					button += '<a href="javascript:void(0);" onclick="show_travel('+item.id+' ,6)" class="btn btn-danger btn-xs">设为精华</a>';
				} else if (item.is_essence == 1) {
					button += '<a href="javascript:void(0);" onclick="show_travel('+item.id+' ,7)" class="btn btn-danger btn-xs">取消精华</a>';
				}
			}
			return button;
		}
	}];
//初始加载
var initial_status = $('input[name="status"]').val();
change_status(initial_status); 

//导航栏切换
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('status')
	if (status == 1 || status == 2) {
		$(".time_name").html("申诉时间");
		$("#search_condition").attr("action","/admin/a/travel_note/getTravelComplainJson");	
	} else {
		$(".time_name").html("发布时间");
		$("#search_condition").attr("action","/admin/a/travel_note/getTravelNoteJson");	
	}
	$('input[name="status"]').val(status);
	$('input[name="page_new"]').val(1);
	change_status(status);
})
//搜索
$('#search_condition').submit(function(){
	var status = $('input[name="status"]').val();
	$('input[name="page_new"]').val(1);
	change_status(status);
	return false;	
})

//根据状态加载数据
function change_status(status) {
	var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
	if (status == 1) { //审核中
		ajaxGetData(columns1 ,inputId);
	} else if(status == 2) { //已拒绝
		ajaxGetData(columns2 ,inputId);
	} else if (status == 3) { //已下线
		ajaxGetData(columns3 ,inputId);
	} else if (status == 4) {
		ajaxGetData(columns4 ,inputId);
	}
}
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

function show_travel(id ,is ,complain_id) {
	$.post("/admin/a/travel_note/getTravelDetail",{id:id},function(data){
		if (data == false) {
			alert('请确认您选择的游记是否正确');
			return false;
		}
		var data = eval('('+data+')');
		if (data.usertype == 1) {
			var type = '管家';
			var name = data.realname;
		} else if (data.usertype == 0) {
			if (typeof data.mestatus == 'string' && data.mestatus == 1) {
				var type = '体验师';
			} else {
				var type = '会员';
			}
			var name = data.truename;
		}
		$('.travel_title').html(data.title);
		$('.travel_author').html('——'+type+'&nbsp;&nbsp;'+name+'&nbsp;&nbsp;('+data.addtime+')');
		$('.travel_sn').html('供应商名称：'+data.supplier_name);
		$('.travel_ln').html('线路名称：'+data.productname);
		$('.eat_content').html(data.content1);
		$('.live_content').html(data.content2);
		$('.co_content').html(data.content3);
		$('.eat_pic,.live_pic,.co_pic').find('img').remove();
		
		if (typeof data.pic1 !== 'undefined') {
			$.each(data.pic1 ,function(key ,val) {
				if (val.length > 1) {
					$('.eat_pic').append('<img src="'+val+'" width="250" height="150" />');
				}
			})
		}
		if (typeof data.pic2 !== 'undefined') {
			$.each(data.pic2 ,function(key ,val) {
				if (val.length > 1) {
					$('.live_pic').append('<img src="'+val+'" width="250" height="150" />');
				}
			})
		}
		if (typeof data.pic3 !== 'undefined') {
			$.each(data.pic3 ,function(key ,val) {
				if (val.length > 1) {
					$('.co_pic').append('<img src="'+val+'" width="250" height="150" />');
				}
			})
		}
		if (is == 1) { //申诉通过
			$(".submit_button").html("通过");
			$(".travel_reason,.submit_button,.travel_supplier").show();
		} else if (is == 2) { //申诉拒绝
			$(".submit_button").html("拒绝");
			$(".travel_reason,.submit_button,.travel_supplier").show();
		} else if (is == 3) {//查看申诉
			$(".travel_supplier").show();
			$(".travel_reason,.submit_button").hide();
		} else if (is == 4) { //下线游记
			$(".submit_button").html("下线").show();
			$(".travel_reason,.travel_supplier").hide();
		} else if (is == 5) { //置顶游记
			$(".submit_button").html("置顶").show();
			$(".travel_reason,.travel_supplier").hide();
		} else if (is == 6) { //加精游记
			$(".submit_button").html("加精").show();
			$(".travel_reason,.travel_supplier").hide();
		} else if (is == 7) { //取消游记加精
			$(".submit_button").html("取消加精").show();
			$(".travel_reason,.travel_supplier").hide();
		}
		$("input[name='type']").val(is);
		$('input[name="travel_id"]').val(data.id);
		if (typeof complain_id != 'undefined') {
			$("input[name='complain_id']").val(complain_id);
		} else {
			$("input[name='complain_id']").val('');
		}
		$('.travel_info').show();
		$('.modal-backdrop').show();
	})
}

$('.travel_close').click(function(){
	$('.travel_info').hide();
	$('.modal-backdrop').hide();
})

$(".submit_button").click(function(){
	var type = $("input[name='type']").val();
	if (type == 1) { //申诉通过
		var url = "/admin/a/travel_note/through_complain";
	} else if (type == 2) { //申诉拒绝
		var url = "/admin/a/travel_note/refuse_complain";
	} else if (type == 3) {//查看申诉
		return false;
	} else if (type == 4) { //下线游记
		var url = "/admin/a/travel_note/show_change";
	} else if (type == 5) { //置顶游记
		var url = "/admin/a/travel_note/showorder_change";
	} else if (type == 6) { //加精游记
		var url = "/admin/a/travel_note/essence_change";
	} else if (type == 7) { //取消游记加精
		var url = "/admin/a/travel_note/cancelEssence";
	}
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	var complain_id = $("input[name='complain_id']").val();
	$.post(url,{id:id,remark:remark,complain_id:complain_id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.modal-backdrop,.travel_info').hide();
		} else {
			alert(data.msg);
		}
	})
})				
</script>