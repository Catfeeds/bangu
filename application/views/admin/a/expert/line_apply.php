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
		<li class="active"><span>/</span>售卖权管理</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">线路标题：</span>
						<span ><input class="search-input" type="text" placeholder="线路标题" name="linename" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">出发城市：</span>
						<span >
							<input class="search-input" type="text" placeholder="出发城市" onclick="showStartplaceTree(this);" name="startcity" />
							<input type="hidden" name="startcity_id">
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">供应商：</span>
						<span ><input class="search-input" type="text" placeholder="供应商" id="company_name" name="supplier" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">目的地：</span>
						<span >
							<input class="search-input" type="text" placeholder="目的地" onclick="showDestBaseTree(this);" name="kindname" />
							<input type="hidden" name="destid">
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">管家：</span>
						<span ><input class="search-input" type="text" placeholder="管家" id="expert" name="realname" /></span>
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
<div class="form-box fb-body apply-change">
	<div class="fb-content">
		<div class="box-title">
			<h4>管家级别调整</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="changeForm" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">选择级别：<i>*</i></div>
					<div class="fg-input">
						<select name="grade">
							<option value="0">请选择</option>
							<?php
								foreach($grade as $v){
									echo '<option value="'.$v['grade'].'">'.$v['title'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="change_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<div class="form-box fb-body apply-delete">
	<div class="fb-content">
		<div class="box-title">
			<h4>删除管家售卖线路</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="deleteForm" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">线路标题：</div>
					<div class="fg-input"><input type="text" name="linename" disabled="disabled" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">供应商名称：</div>
					<div class="fg-input"><input type="text" name="supplier_name" disabled="disabled" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">管家姓名：</div>
					<div class="fg-input"><input type="text" name="realname" disabled="disabled" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">管家级别：</div>
					<div class="fg-input"><input type="text" name="gradename" disabled="disabled" /></div>
				</div>
				<div class="form-group" style="color:red;">请谨慎操作，您删除后管家将没有此线路的售卖权，但他可以重新申请!</div>
				<div class="form-group">
					<input type="hidden" name="delete_id">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but but-red" value="确人删除" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>
var columns = [ {field : 'linename',title : '线路标题',width : '260',align : 'center'},
		{field : 'supplier_name',title : '供应商',width : '200',align : 'center'},
		{field : 'cityname',title : '出发地',width : '140',align : 'center'},
		{field : null,title : '管家佣金',align : 'center', width : '90',formatter:function(item){
				return item.agent_rate_int+'元/人份';
			}
		},
		{field : 'expert_name',title : '管家名称',align : 'center', width : '120'},
		{field : 'grade_name',title : '管家级别',align : 'center', width : '80'},
		{field : null,title : '操作',align : 'center', width : '120',formatter:function(item){
			var button = "<a href='javascript:void(0)' onclick='changeGrade("+item.apply_id+" ,"+item.grade+")' class='tab-button but-blue'>调整级别</a>&nbsp;";
				button += '<a href="javascript:void(0)" onclick="del('+item.apply_id+')" class="tab-button but-red">删除</a>';
				return button;
			}
		}
	];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/experts/line_apply/getLineApplyData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
//删除管家售卖线路
var delObj = $('#deleteForm');
function del(aid) {
	$.ajax({
		url:'/admin/a/experts/line_apply/getApplyDetail',
		data:{applyId:aid},
		type:'post',
		dataType:'json',
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				delObj.find('input[name=linename]').val(data.linename);
				delObj.find('input[name=supplier_name]').val(data.company_name);
				delObj.find('input[name=gradename]').val(data.grade_name);
				delObj.find('input[name=realname]').val(data.realname);
				delObj.find('input[name=delete_id]').val(aid);
				$('.apply-delete,.mask-box').fadeIn(500);
			} else {
				alert('请确认您的数据');
			}
		}
	});
}
delObj.submit(function(){
	$.ajax({
		url:'/admin/a/experts/line_apply/deleteLineApply',
		type:'post',
		data:{applyId:delObj.find('input[name=delete_id]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/experts/line_apply/getLineApplyData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				closebox();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
//调整级别
var changeObj = $('#changeForm');
function changeGrade(aid ,grade) {
	changeObj.find('select[name=grade]').val(grade);
	changeObj.find('input[name=change_id]').val(aid);
	$('.apply-change,.mask-box').fadeIn(500);
}
changeObj.submit(function(){
	$.ajax({
		url:'/admin/a/experts/line_apply/changeGrade',
		type:'post',
		data:{grade:changeObj.find('select[name=grade]').val(),applyId:changeObj.find('input[name=change_id]').val()},
		dataType:'json',
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/experts/line_apply/getLineApplyData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				closebox();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
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