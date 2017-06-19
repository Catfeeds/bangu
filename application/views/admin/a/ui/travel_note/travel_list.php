<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">游记管理1</li>
		</ul>
	</div>
		<ul class="nav nav-tabs">
			<li class="active" status="1"><a>审核中 </a></li>
			<li class="tab-red" status="2"><a>已拒绝</a></li>
			<li class="tab-blue" status="3"><a>已下线</a></li>
			<li class="tab-blue" status="4"><a>全部游记</a></li>
		</ul>
		<div class="tab-content">
			<form action="<?php echo site_url("admin/a/travel_note/travel_list")?>" id='search_condition' class="form-inline" method="post">
				<div class="form-group dataTables_filter search_div fl">
					<span class="search_title fl">游记标题:</span>
					<input type="text" class="form-control fl" name="title">
				</div>
				<div class="form-group dataTables_filter search_div fl">
					<span class="search_title fl" style="position:relative;">发布时间:</span>
					<input type="text" class="form-control fl" id="reservation2" name="time" >
				</div>
				<div class="form-group dataTables_filter search_div travel_type fl" style="display:none;">
					<span class="search_title fl" style="position:relative;">游记状态:</span>
					<select name="travle_status fl" style="width:100px;">
						<option value="0">请选择：</option>
						<option value="1">审核中</option>
						<option value="2">已下线</option>
						<option value="3">正常</option>
					</select>
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
		<div class="travel_close">关闭</div>
		<div class="travel_through">通过</div>
		<div class="travel_refuse">拒绝</div>
		<div class="travel_offline">下线</div>
		<div class="travel_overhead">顶置</div>
		<div class="travel_essence">加精</div>
		<div class="travel_no_essence">取消加精</div>
	</div>
</div>
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
//审核中
var columns1 = [ {field : 'tncaddtime',title : '申诉时间',width : '150',align : 'left'},
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
		{field : 'supplier_name',title : '供应商名称',align : 'center', width : '200',length:15},
		//{field : 'email',title : '申诉',align : 'center', width : '200'},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(val){
			var button = '<a href="javascript:void(0);" onclick="show_travel('+val.tnid+' ,3)"  class="btn btn-info btn-xs">查看申诉</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="show_travel('+val.tnid+' ,1)" class="btn btn-info btn-xs"> 通过</a>&nbsp;';
			button += '<a href="javascript:void(0);" onclick="show_travel('+val.tnid+' ,2)" class="btn btn-danger btn-xs">拒绝</a>';	
			return button;
		}
	}];
//已拒绝
var columns2 = [ {field : 'tncaddtime',title : '申诉时间',width : '150',align : 'left'},
		{field : 'title',title : '游记标题',width : '',align : 'left',length:10},
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
		{field : 'moaddtime',title : '下单时间',align : 'center', width : '150'}
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
		{field : 'moaddtime',title : '下单时间',align : 'center', width : '150'}
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
		{field : 'moaddtime',title : '下单时间',align : 'center', width : '150'},
		{field : null,title : '状态',align : 'center', width : '100',formatter:function(val){
				if (typeof val.tncid == "string" && val.status == 0) {
					return '审核中';
				} else if (val.is_show == 1) {
					return '正常';
				} else if (val.is_show == 0) {
					return '下线';
				}
			}
		},
		{field : null,title : '操作',align : 'center', width : '200',formatter: function(item){
			var button = '';
			if (typeof item.tncid == "string" && item.status == 0) {
				button += '<a href="javascript:void(0);" onclick="show_travel('+item.id+' ,4)" class="btn btn-info btn-xs">下线</a>';
			} else if (item.is_show == 1) {
				button += '<a href="javascript:void(0);" onclick="show_travel('+item.id+' ,4)" class="btn btn-info btn-xs">下线</a>&nbsp;';
				if (item.showorder > 1) {
					button += '<a href="javascript:void(0);" onclick="show_travel('+item.id+' ,5)" class="btn btn-info btn-xs">置顶</a>&nbsp;';
				}
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
		$("#search_condition").attr("action","/admin/a/travel_note/travel_list");	
	} else {
		$("#search_condition").attr("action","/admin/a/travel_note/travel_all");	
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

function show_travel(id ,is) {
	$.post("/admin/a/travel_note/get_travel_one_json",{id:id},function(data){
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
		//$('.main_content').html(data.content);
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
		$('.travel_button div').show();
		if (is == 1 || is == 2 || is == 3) {
			if (is == 3) {
				$('.travel_offline,.travel_overhead,.travel_essence,.travel_no_essence').css('display','none');
			} else if (is== 2) {
				$('.travel_offline,.travel_overhead,.travel_essence,.travel_through,.travel_no_essence').css('display','none');
			} else {
				$('.travel_offline,.travel_overhead,.travel_essence,.travel_refuse,.travel_no_essence').css('display','none');
			}
			$('.travel_supplier,.travel_reason').show();
			$('.supplier_complain .content_title').html('供应商申诉内容：('+data.taddtime+')');
			$('.complain_content').html(data.reason);
		} else {
			$('.travel_supplier,.travel_reason').hide();
			if (is == 4) {
				if (typeof data.tid == 'string') {
					$('.travel_supplier,.travel_reason').show();
					$('.supplier_complain .content_title').html('供应商申诉内容：('+data.taddtime+')');
					$('.complain_content').html(data.reason);
					$('.travel_offline').html('下线并通过申诉审核');
				} else {
					$('.travel_offline').html('下线');
				}
				$('.travel_overhead,.travel_essence,.travel_refuse,.travel_through,.travel_no_essence').css('display','none');
			} else if(is == 5) {
				$('.travel_offline,.travel_essence,.travel_refuse,.travel_through,.travel_no_essence').css('display','none');
			} else if (is == 6) {
				$('.travel_offline,.travel_overhead,.travel_refuse,.travel_through,.travel_no_essence').css('display','none');
			} else if (is == 7) {
				$('.travel_offline,.travel_overhead,.travel_refuse,.travel_through,.travel_essence').css('display','none');
			}
		}
		$('input[name="travel_id"]').val(data.id);
		$('.travel_info').show();
		$('.modal-backdrop').show();
	})
}
$('.travel_close').click(function(){
	$('.travel_info').hide();
	$('.modal-backdrop').hide();
})
//通过申诉申请
$('.travel_through').click(function(){
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	$.post("/admin/a/travel_note/through_complain",{id:id,remark:remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//拒绝申诉申请
$('.travel_refuse').click(function(){
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	$.post("/admin/a/travel_note/refuse_complain",{id:id,remark:remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//下线
$('.travel_offline').click(function(){
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	$.post("/admin/a/travel_note/show_change",{id:id,remark:remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})

//加精
$('.travel_essence').click(function(){
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	$.post("/admin/a/travel_note/essence_change",{id:id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//取消加精
$(".travel_no_essence").click(function(){
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	$.post("/admin/a/travel_note/cancelEssence",{id:id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//顶置
$('.travel_overhead').click(function(){
	var status = $('input[name="status"]').val();
	var id = $('input[name="travel_id"]').val();
	$.post("/admin/a/travel_note/showorder_change",{id:id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			change_status(status);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})					
</script>