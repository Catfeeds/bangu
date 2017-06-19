<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>手机端热门线路</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">线路名称：</span>
						<span ><input class="search-input" type="text" name="name" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">时间：</span>
						<span >
							<input class="search-input" placeholder="开始时间" style="width: 110px;" type="text" id="stime" name="stime" />
							<input class="search-input" placeholder="结束时间" style="width: 110px;" type="text" id="etime" name="etime" />
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">始发地：</span>
						<span id="search-city"></span>
					</li>
					<li class="search-list">
						<input type="submit" value="搜索" class="search-button" />
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
			<h4>手机端热门线路</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">始发地：<i>*</i></div>
					<div class="fg-input" id="add-city"></div>
				</div>
				<div class="form-group">
					<div class="fg-title">线路类型：<i>*</i></div>
					<div class="fg-input">
						<select name="dest">
							<option value="0">请选择</option>
							<option value="1">出境游</option>
							<option value="2">国内游</option>
							<option value="3">周边游</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">选择线路：<i>*</i></div>
					<div class="fg-input">
						<input type="text" readonly="readonly" name="linename" id="clickChoiceLine" />
						<input type="hidden" name="lineId" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">开始时间：<i>*</i></div>
					<div class="fg-input"><input type="text" name="starttime" readonly="readonly" id="starttime" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">结束时间：<i>*</i></div>
					<div class="fg-input"><input type="text" name="endtime" readonly="readonly" id="endtime" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">图片：</div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">备注：</div>
					<div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否显示：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_show" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_show" checked="checked" value="1">是</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否可更改：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_modify" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_modify" checked="checked" value="1">是</label></li>
						</ul>
					</div>
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
<?php echo $this->load->view('admin/a/choice_data/choiceLine.php');  ?>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
var columns = [ {field : 'linename',title : '线路名称',width : '200',align : 'center' ,length:20},
                {field : false,title : '线路状态',width : '75',align : 'center' ,formatter:function(item){
	                	if (item.line_status == -1) {
							return '删除';
						} else if (item.line_status == 0) {
							return '保存';
						} else if (item.line_status == 1) {
							return '审核中';
						} else if (item.line_status == 2) {
							return '正常';
						} else if (item.line_status == 3) {
							return '下架';
						} else if (item.line_status == 4) {
							return '系统退回';
						}
                    }
                },
                {field : 'starttime',title : '开始时间',width : '75',align : 'center'},
                {field : 'endtime',title : '结束时间',width : '75',align : 'center'},
                {field : null,title : '图片',width : '80',align : 'center',formatter:function(item){
						return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                    }
                },
        		{field : null ,title : '是否显示' ,width : '70' ,align : 'center',formatter:function(item){
        				return showArr[item.is_show];
        			}
        		},
        		{field : 'cityname',title : '始发地',width : '80',align : 'center'},
        		{field : null,title : '是否可更改',width : '80',align : 'center',formatter:function(item){
        				return modifyArr[item.is_modify];
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '60'},
        		{field : 'beizhu',title : '备注',align : 'center', width : '120' ,length:15},
        		{field : null,title : '操作',align : 'center', width : '120',formatter: function(item) {
        			var button = '';
        			if (item.is_modify == 1) {
        				button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改</a>&nbsp;';
        			}
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="tab-button but-red">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg_mobile/mobile_hot_line/getMHotLineData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
var formObj = $("#add-data");
$.ajax({
	url:'/common/selectData/getStartplaceJson',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#add-city').selectLinkage({
			jsonData:data,
			width:'137px',
			names:['country','province','city'],
			callback:function(){
				formObj.find('input[name=lineId]').val(0);
				formObj.find('#clickChoiceLine').val('');
			}
		});
		$('#cb-choice-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});
//选择线路
$('#clickChoiceLine').click(function(){
	var destName = $('select[name=dest]').find('option:selected').html();
	var destId = $('select[name=dest]').val();
	var cityId = formObj.find('select[name=city]').val();
	var cityName = formObj.find('select[name=city]').find('option:selected').html();
	if (destId == 3) {
		if (cityId < 1) {
			alert('请选择始发地城市');
			return false;
		}
		$('.cb-prompt').html(cityName+destName);
		$('#cb-search-form').find('input[name=city_id]').val(cityId);
	} else {
		$('.cb-prompt').html(destName);
	}
	$('#cb-search-form').find('input[name=dest_id]').val(destId);
	createLineHtml();
})
$('.line-submit').click(function(){
	var activeObj = $('.db-data-line').find('.db-active');
	$('#clickChoiceLine').val(activeObj.attr('data-name'));
	formObj.find('input[name=lineId]').val(activeObj.attr('data-val'));
	$(".choice-box-line").hide();
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
$('#etime').datetimepicker({
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
//添加弹出层
$("#add-button").click(function(){
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('textarea').val('');
	formObj.find("input[name='is_show'][value=1]").attr("checked",true);
	formObj.find("input[name='is_modfiy'][value=1]").attr("checked",true);
	formObj.find("select").val(0);
	$("#add-city").find("select").eq(0).nextAll('select').hide();
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
})
$('select[name=dest]').change(function(){
	formObj.find('input[name=linename]').val('');
	formObj.find('input[name=lineId]').val('');
})
$("#add-data").submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id > 0 ? '/admin/a/cfg_mobile/mobile_hot_line/edit' :'/admin/a/cfg_mobile/mobile_hot_line/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_hot_line/getMHotLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".fb-body,.mask-box").hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

function edit(id) {
	$.ajax({
		url:'/admin/a/cfg_mobile/mobile_hot_line/getDetailJson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)){
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.startplaceid);
				formObj.find('input[name=linename]').val(data.linename);
				formObj.find('input[name=lineId]').val(data.line_id);
				formObj.find('input[name=starttime]').val(data.starttime);
				formObj.find('input[name=endtime]').val(data.endtime);
				formObj.find('input[name=showorder]').val(data.showorder);
				formObj.find('input[name=pic]').val(data.pic);
				formObj.find('input[name=id]').val(data.id);
				formObj.find('select[name=dest]').val(data.dest_type);
				formObj.find('textarea[name=beizhu]').val(data.beizhu);
				formObj.find("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
				formObj.find("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
				$(".uploadImg").remove();
				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
				$(".fb-body,.mask-box").show();
			} else {
				alert('请确认您选择的数据');
			}
		}
	});
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_mobile/mobile_hot_line/delHotLine",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_hot_line/getMHotLineData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		});
	}
}
</script>
