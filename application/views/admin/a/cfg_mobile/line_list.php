<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<style>

.eject_title .comment_line{ height:40px; line-height:40px;}
.eject_content{ float:left;}
i{ font-style: normal;}
.eject_input_Slide, .eject_input_Slide textarea{ width:636px;}
.eject-content_left{float:left;}
.page-content{ min-width: auto !important; }


.title_info_txt1,.title_info_txt2,.tset_1,.tset_2{ display:none;}
#rt_rt_1a5vrdt1p1dok105afeo1hhl1n1{ width:80px !important; height:30px !important;}
#as2 div:last-child{width:90px !important; height:24px !important; margin-top:10px !important; margin-left:5px !important;}
.webuploader-pick{ width:102px; margin-left:0px; z-index:1000;}
.parentFileBox{ top:45px; height:80px; left:5px;}
.parentFileBox>.fileBoxUl{ top:0px;}
.parentFileBox>.diyButton>a{ padding:3px 6px 3px 6px} 
.parentFileBox>.diyButton{ position:absolute; top:0px;}
.diyStart{ top:0}
.diyCancelAll{ top:35px;}

.form-horizontal{float:none}
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>线路排序</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">产品编号：</span>
						<span ><input class="search-input" type="text" placeholder="产品编号" name="code" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">产品标题：</span>
						<span ><input class="search-input" type="text" placeholder="产品标题" name="linename" /></span>
					</li>
					<li class="search-list" >
						<span class="search-title">上线时间：</span>
						<span>
							<input class="search-input" style="width:110px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
							<input class="search-input" style="width:110px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
						</span>
					</li>
					<li class="search-list" id="line-time">
						<span class="search-title search-tile">更新时间：</span>
						<span>
							<input class="search-input" style="width:110px;" type="text" placeholder="开始时间" id="stime" name="stime" />
							<input class="search-input" style="width:110px;" type="text" placeholder="结束时间" id="etime" name="etime" />
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">出发城市：</span>
						<span ><input class="search-input" type="text" placeholder="出发城市" id="startcity" name="startcity" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">供应商：</span>
						<span ><input class="search-input" type="text" placeholder="供应商" id="company_name" name="supplier" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">目的地：</span>
						<span ><input class="search-input" type="text" placeholder="目的地" id="destinations" name="kindname" /></span>
					</li>
					<li class="search-list">
						<input type="hidden" value="1" name="status">
						<input type="submit" value="搜索" class="search-button" />
						<!--<input type="button" value="导出" id="export_excel" class="search-button" />-->
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>


<div class="form-box fb-body">
	<div class="fb-content">
		<div class="box-title">
			<h4>线路排序配置</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" class="showorder" name="showorder" /></div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>



<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>

<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>


//已审核
var columns2 = [ {field : 'linecode',title : '产品编号',width : '60',align : 'center'},
		{field : null,title : '产品标题',width : '200',align : 'left',formatter:function(item){
				return '<a href="javascript:void(0);"  onclick="show_line_detail('+item.line_id+',2)" >'+item.linename+'</a>';
			}
		},
		{field : 'cityname',title : '出发地',width : '100',align : 'center'},
                {field : 'dest_name',title : '目的地',width : '100',align : 'center'},
		{field : 'online_time',title : '上线时间',width : '110',align : 'center'},
//		{field : 'confirm_time',title : '审核时间',width : '115',align : 'left'},
//		{field : 'linkman',title : '录入人',width : '80',align : 'center'},
		{field : 'company_name',title : '供应商',align : 'center', width : '140'},
                {field : 'displayorder',title : '排序',align : 'center', width : '140'},
//		{field : 'username',title : '产品审核人',align : 'center', width : '100'},
		{field : null,title : '操作',align : 'center', width : '80',formatter: function(item){
			var button = '<a href="javascript:void(0)" data-name="'+item.linename+'" onclick="edit('+item.line_id+')" class="tab-button but-blue"> 排序修改</a>';
//			button += '<a href="javascript:void(0)" onclick="disabled('+item.line_id+')" class="tab-button but-red">下线</a>&nbsp;';
//			button += '<a href="javascript:void(0)" onclick="vr_num('+item.line_id+' ,'+item.collect_num_vr+')" class="tab-button but-red">收藏虚拟值</a>';
			return button;
		}
	}];
    
$("#dataTable").pageTable({
	columns:columns2,  
	url:'/admin/a/cfg_mobile/line/getLineData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
var formObj = $('#search-condition');
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('data-val');
	formObj.find('input[type=text]').val('');
	formObj.find('select').val(0);
	formObj.find('input[type=hidden]').val('');
	formObj.find('input[name=status]').val(status);
	$('.search-tile').html('更新时间：');
	if (status == 1) {
            alert('here')
		var columns = columns1;
	} else if (status == 2) {
		$('.search-tile').html('审核时间：');
		var columns = columns2;
	} else if (status == 3) {
		var columns = columns3;
	} else if (status == 4) {
		var columns = columns4;
	} else if (status == 5) {
		var columns = columns5;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/lines/line/getLineData',
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
	$('.admin-box').find('input[name=admin]:checked').each(function(){
		$(this).attr('checked' ,false);
	})
})
//退回线路申请
var refuseObj = $('.line-refuse');
function refuse(lineid) {
	refuseObj.find('textarea[name=refuse_remark]').val('');
	refuseObj.find('input[name=refuse_id]').val(lineid);
	$('.line-refuse,.mask-box').fadeIn(500);
}
$('#refuseForm').submit(function(){
	$.ajax({
		url:'/admin/a/lines/line/refuse',
		type:'post',
		data:{lineid:refuseObj.find('input[name=refuse_id]').val(),refuse_remark:refuseObj.find('textarea[name=refuse_remark]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/cfg_mobile/line/getLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				closebox();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
//通过线路申请
var throughObj = $('#throughForm');
function through(lineid) {
	if (confirm('您确定要通过？')) {
		$.ajax({
			url:'/admin/a/lines/line/through',
			type:'post',
			data:{lineid:lineid},
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns1,
						url:'/admin/a/cfg_mobile/line/getLineData',
						pageNumNow:1,
						searchForm:'#search-condition',
						tableClass:'table-data'
					});
					closebox();
				} else {
					alert(data.msg);
				}
			}
		});
		return false;
	}
}

//下线线路
var disabledObj = $('#disabledForm');
function disabled(lineid) {
	disabledObj.find('input[name=disabled_id]').val(lineid);
	disabledObj.find('textarea[name=reason]').val('');
	$('.line-disabled,.mask-box').fadeIn(500);
}
disabledObj.submit(function(){
	$.ajax({
		url:'/admin/a/lines/line/disable',
		type:'post',
		data:{lineid:disabledObj.find('input[name=disabled_id]').val(),reason:disabledObj.find('textarea[name=reason]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns2,
					url:'/admin/a/cfg_mobile/line/getLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				closebox();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

function stop(lineid) {
	if (confirm('您确定停售此线路?')) {
		$.ajax({
			url:'/admin/a/lines/line/stopsale',
			type:'post',
			data:{lineid:lineid},
			dataType:'json',
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns4,
						url:'/admin/a/cfg_mobile/line/getLineData',
						pageNumNow:1,
						searchForm:'#search-condition',
						tableClass:'table-data'
					});
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
$('#choice-admin').click(function(){
	$('.admin-box,.mask-box').show();
})
$('#admin-submit').submit(function(){
	var ids = '';
	var name = '';
	$(this).find('input[name=admin]:checked').each(function(){
		ids += $(this).val()+',';
		name += $(this).attr('data-name')+' ';
	})
	formObj.find('input[name=admin_id]').val(ids);
	$('#choice-admin').val(name);
	$('.admin-box,.mask-box').hide();
	return false;
})

//修改收藏虚拟值
function vr_num(id ,num) {
	$('#vr-form').find('input[name=id]').val(id);
	num = typeof num == 'object' ? 0 : num;
	$('#vr-form').find('input[name=vr_num]').val(num);
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  shadeClose: false,
		  content: $('#vr-info')
	});
}
$('#vr-form').submit(function(){
	$.ajax({
		url:'/admin/a/lines/line/vr_num',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
// 				var pageNow = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
// 				$("#dataTable").pageTable({
// 					columns:columns2,
// 					url:'/admin/a/lines/line/getLineData',
// 					pageSize:10,
// 					pageNumNow:pageNow,
// 					searchForm:'#search-condition',
// 					tableClass:'table table-bordered table_hover'
// 				});
				$('.layui-layer-close').trigger('click');
				layer.alert(result.msg, {icon: 1});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})


//目的地
$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.kindname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#destinations",
	    name : "destid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//出发城市
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.cityname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#startcity",
	    name : "startcity_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//商家名字
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
	    id : "#company_name",
	    name : "supplier_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
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
$('#stime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#etime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});

//编辑
function edit(id){
	$.ajax({
		url:'/admin/a/cfg_mobile/line/getDetailjson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)){
				var formObj = $("#add-data");
				
				formObj.find('input[name=showorder]').val(data.order);
				formObj.find('input[name=id]').val(data.id);
//				formObj.find('textarea[name=beizhu]').val(data.beizhu);
//				formObj.find("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
//				formObj.find("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
//				$(".uploadImg").remove();
//				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
//                                $("#uploadFile1").after("<img class='uploadImg' src='" + data.smallpic + "' width='80'>");
				$(".fb-body,.mask-box").show();
			} else {
				alert('请确认您选择的数据');
			}
		}
	});
}

$("#add-data").submit(function(){
//	var id = $(this).find('input[name=id]').val();
//        var showorder  = $(this).find('input[name=showorder]').val();
	var url = '/admin/a/cfg_mobile/line/edit';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
//				$("#dataTable").pageTable({
//					columns:columns2,
//					url:'/admin/a/cfg_mobile/line/getLineData',
//					pageNumNow:1,
//					searchForm:'#search-condition',
//					tableClass:'table-data'
//				});
				alert(data.msg);
                                location.reload();
				$(".fb-body,.mask-box").hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})


</script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>