<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>管家升级</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="0">申请中 </li>
			<li class="tab-red" data-val="1">供应商已通过</li>
			<li class="tab-red" data-val="2">已通过</li>
			<li class="tab-blue" data-val="-2">已拒绝</li>
		</ul>
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">线路标题：</span>
						<span ><input class="search-input" type="text" placeholder="产品标题" name="linename" /></span>
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
						<span >
							<input class="search-input" type="text" onclick="showDestBaseTree(this);" name="kindname" />
							<input type="hidden" name="destid">
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">管家：</span>
						<span ><input class="search-input" type="text" placeholder="管家" id="expert" name="realname" /></span>
					</li>
					<li class="search-list">
						<input type="hidden" value="1" name="status">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div class="detail-box see-upgrade" style="display:none;">
	<div class="db-body">
		<div class="db-title">
			<h4>通过申请</h4>
			<div class="db-close box-close">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-data-row">
					<div class="db-row-title">管家姓名：</div>
					<div class="db-row-content up-name">jiakairong</div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">申请等级：</div>
					<div class="db-row-content up-grade"></div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">出发城市：</div>
					<div class="db-row-content up-cityname">jiakairong</div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">管家佣金：</div>
					<div class="db-row-content up-money"></div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">线路名称：</div>
					<div class="db-row-content up-linename">jiakairong</div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">供应商名称：</div>
					<div class="db-row-content up-supplier"></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">申请理由：</div>
					<div class="db-row-content up-remark"></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">拒绝原因：</div>
					<div class="db-row-content" ><textarea name="refuse_remark"></textarea></div>
				</li>
			</ul>
			<div class="db-buttons">
				<div class="box-close">关闭</div>
				<input type="hidden" name="up-id" >
				<div id="through-submit">通过</div>
				<div id="refuse-submit">拒绝</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>
var gradeArr = <?php echo empty($gradeArr) ? '' : json_encode($gradeArr);?>;
//申请中
var columns1 = [ {field : 'line_title',title : '线路标题',width : '260',align : 'center'},
		{field : 'supplier_name',title : '供应商',width : '60',align : 'center'},
		{field : 'cityname',title : '出发地',width : '55',align : 'center'},
		{field : null,title : '管家佣金',width : '100',align : 'center',formatter:function(item){
				return item.agent_rate_int+'元/人份';
			}
		},
		{field : 'expert_name',title : '管家名称',width : '50',align : 'center'},
		{field : 'apply_remark',title : '申请理由',width : '135',align : 'center'},
		{field : null,title : '申请前级别',width : '105',align : 'center',formatter:function(item){
				return typeof gradeArr[item.grade_before] == 'undefined' ? '' : gradeArr[item.grade_before];
			}
		},
		{field : null,title : '申请级别',align : 'center', width : '100',formatter:function(item){
				return typeof gradeArr[item.grade_after] == 'undefined' ? '' : gradeArr[item.grade_after];
			}
		},
		{field : null,title : '操作',align : 'center', width : '120',formatter: function(item){
			var button = "<a href='javascript:void(0)' onclick='see("+item.upgrade_id+" ,1)' class='tab-button but-blue'> 通过</a>&nbsp;";
			button += '<a href="javascript:void(0)" onclick="see('+item.upgrade_id+' ,2)" class="tab-button but-red"> 拒绝</a>&nbsp;';
			return button;
		}
	}];
//供应商通过
var columns5 = [ {field : 'line_title',title : '线路标题',width : '260',align : 'center'},
		{field : 'supplier_name',title : '供应商',width : '140',align : 'center'},
		{field : 'cityname',title : '出发地',width : '135',align : 'center'},
		{field : null,title : '管家佣金',width : '100',align : 'center',formatter:function(item){
				return item.agent_rate_int+'元/人份';
			}
		},
		{field : 'expert_name',title : '管家名称',width : '110',align : 'center'},
		{field : 'apply_remark',title : '申请理由',width : '135',align : 'center'},
		{field : null,title : '申请前级别',width : '105',align : 'center',formatter:function(item){
				return typeof gradeArr[item.grade_before] == 'undefined' ? '' : gradeArr[item.grade_before];
			}
		},
		{field : null,title : '申请级别',align : 'center', width : '100',formatter:function(item){
				return typeof gradeArr[item.grade_after] == 'undefined' ? '' : gradeArr[item.grade_after];
			}
		},
		{field : null,title : '操作',align : 'center', width : '120',formatter: function(item){
			var button = "<a href='javascript:void(0)' onclick='see("+item.upgrade_id+" ,1)' class='tab-button but-blue'> 通过</a>&nbsp;";
			button += '<a href="javascript:void(0)" onclick="see('+item.upgrade_id+' ,2)" class="tab-button but-red"> 拒绝</a>&nbsp;';
			return button;
		}
	}];
//已通过
var columns2 = [ {field : 'line_title',title : '线路标题',width : '260',align : 'center'},
		{field : 'supplier_name',title : '供应商',width : '140',align : 'center'},
		{field : 'cityname',title : '出发地',width : '135',align : 'center'},
		{field : null,title : '管家佣金',width : '100',align : 'center',formatter:function(item){
				return item.agent_rate_int+'元/人份';
			}
		},
		{field : 'expert_name',title : '管家名称',width : '110',align : 'center'},
		{field : 'apply_remark',title : '申请理由',width : '135',align : 'center'},
		{field : null,title : '申请前级别',width : '105',align : 'center',formatter:function(item){
				return typeof gradeArr[item.grade_before] == 'undefined' ? '' : gradeArr[item.grade_before];
			}
		},
		{field : null,title : '申请级别',align : 'center', width : '100',formatter:function(item){
				return typeof gradeArr[item.grade_after] == 'undefined' ? '' : gradeArr[item.grade_after];
			}
		}];
//已拒绝
var columns3 = [ {field : 'line_title',title : '线路标题',width : '260',align : 'center'},
		{field : 'supplier_name',title : '供应商',width : '140',align : 'center'},
		{field : 'cityname',title : '出发地',width : '135',align : 'center'},
		{field : null,title : '管家佣金',width : '100',align : 'center',formatter:function(item){
				return item.agent_rate_int+'元/人份';
			}
		},
		{field : 'expert_name',title : '管家名称',width : '110',align : 'center'},
		{field : 'apply_remark',title : '申请理由',width : '135',align : 'center'},
		{field : null,title : '申请前级别',width : '105',align : 'center',formatter:function(item){
				return typeof gradeArr[item.grade_before] == 'undefined' ? '' : gradeArr[item.grade_before];
			}
		},
		{field : null,title : '申请级别',align : 'center', width : '100',formatter:function(item){
				return typeof gradeArr[item.grade_after] == 'undefined' ? '' : gradeArr[item.grade_after];
			}
		},
		{field : 'refuse_remark',title : '拒绝原因',width : '135',align : 'center'}];
$("#dataTable").pageTable({
	columns:columns1,
	url:'/admin/a/experts/expert_upgrade/getUpgradeData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
var formObj = $('#search-condition');
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('data-val');
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('input[name=status]').val(status);
	if (status == 0) {
		var columns = columns1;
	} else if (status == 1) {
		var columns = columns5;
	} else if (status == 2) {
		var columns = columns2;
	} else if (status == -2) {
		var columns = columns3;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/experts/expert_upgrade/getUpgradeData',
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
})
function see(upid ,type) {
	$.ajax({
		url:'/admin/a/experts/expert_upgrade/getUpgradeDetail',
		type:'post',
		dataType:'json',
		data:{upgradeId:upid},
		success:function(data) {
			if ($.isEmptyObject(data)) {
				alert('请确认您选择的数据');
			} else {
				$('.up-name').html(data.expert_name);
				$('.up-grade').html(typeof gradeArr[data.grade_after] == 'undefined' ? '' : gradeArr[data.grade_after]);
				$('.up-cityname').html(data.cityname);
				$('.up-money').html(data.money);
				$('.up-linename').html(data.line_title);
				$('.up-supplier').html(data.supplier_name);
				$('.up-remark').html(data.apply_remark);
				$('input[name=up-id]').val(data.id);
				if (type == 1) {
					$('#refuse-submit').hide();
					$('#through-submit').show();
					$('textarea[name=refuse_remark]').parents('li').hide();
				} else {
					$('#refuse-submit').show();
					$('#through-submit').hide();
					$('textarea[name=refuse_remark]').parents('li').show();
				}
				$('.see-upgrade,.mask-box').fadeIn(500);
			}
		}
	});
}
//拒绝申请
$('#refuse-submit').click(function(){
	$.ajax({
		url:'/admin/a/experts/expert_upgrade/refuse',
		type:'post',
		data:{upgradeId:$('input[name=up-id]').val(),remark:$('textarea[name=refuse_remark]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_upgrade/getUpgradeData',
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
//通过申请
$('#through-submit').click(function(){
	$.ajax({
		url:'/admin/a/experts/expert_upgrade/through',
		type:'post',
		data:{upgradeId:$('input[name=up-id]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/experts/expert_upgrade/getUpgradeData',
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
//管家名字
$.post('/admin/a/comboBox/get_expert_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.realname,
		    value : val.id,
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#expert",
	    name : "expert_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
</script>