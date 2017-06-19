 <style type="text/css">
     .form-group{ margin:10px 0px;}
 </style>
 <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
 <div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i> <a
			href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
		<li class="active">查看售卖线路级别</li>
	</ul>
</div>

 <div class="col-xs-12 col-md-12 div_account_list">
<form action="<?php echo base_url();?>admin/b2/line_grade/line_grade_list" id='line_grade' name='line_grade' method="post">
		<!-- 其他搜索条件,放在form 里面就可以了 -->
		<div class="widget-body bordered-right">
	<div class="form-group" style="display:inline-block;">
		<lable>供应商:</lable>
		<select name="supplier_id">
		<option value="">--请选择--</option>
		<?php
			foreach($suppliers as $val){
				echo "<option value='{$val ['id']}'>{$val ['company_name']}</option>";
			}
		?>
		</select>
	</div>
	<!-- <div class="form-group" style="display:inline-block;width:20%;">
		目的地:
		<select name="destination">
		<option value="">--请选择--</option>
		<?php
			foreach($destinations as $val){
				echo "<option value='{$val ['id']}'>{$val ['kindname']}</option>";
			}
		?>
		</select>

	</div> -->
	<div class="form-group" style="display:inline;width:20%;">
		级别:
		<select name="grade">
		<option value="">--请选择--</option>
		<option value="1">管家</option>
		<option value="2">初级专家</option>
		<option value="3">中级专家</option>
		<option value="4">高级专家</option>
		</select>

	</div>
	<div class="form-group" style="display:inline-block;">
		<lable style="width:55px; float:left; margin-top:5px;">目的地:</lable><input type="text" class="form-control" placeholder="目的地" id="destinations"  name="destination" style="display:inline;width:75%;">
	</div>
	<div class="form-group" style="display:inline-block;">
		<lable style="width:55px; float:left;margin-top:5px;">线路名称</lable><input type="text" class="form-control" name="line_name" value="" style="display:inline;width:75%;">
	</div>
	<!-- <div class="form-group dataTables_filter" style="display:inline-block;width:20%;">
		<input type="text" class="form-control" placeholder="线路名称"   name="line_name" style="width:140px;">
	</div> -->
	<div class="form-group" style="display:inline-block;">
		<button type="button" class="btn btn-darkorange active" id="searchBtn" >
        			搜索
    		</button>
    	</div>
</div>
<div id="line_grade_dataTable">
			<!--列表数据显示位置-->
</div>
<div class="row DTTTFooter">
<div class="fl" >
	<div class="dataTables_info" id="editabledatatable_info">
		第
		<span class='pageNum'>0</span> /
		<span class='totalPages'>0</span> 页 ,
		<span class='totalRecords'>0</span>条记录,每页
		<label>
			<select name="pageSize" id='line_grade_Select'
				class="form-control input-sm" >
				<option value="">
					--请选择--
				</option>
				<option value="5">
					5
				</option>
				<option value="10">
					10
				</option>
				<option value="15">
					15
				</option>
				<option value="20">
					20
				</option>
			</select>
		</label>
		条记录
	</div>
</div>
	<div class="fr"style=" margin-top:3px;">
		<div class="dataTables_paginate paging_bootstrap">
			<!-- 分页的按钮存放 -->
			<ul class="pagination"> </ul>
		</div>
	</div>
</div>
</form>
</div> <!--End -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
	// 列数据映射配置
	var line_grade_columns=[ {field : 'linecode',title : '线路编号',width : '90',align : 'center'},
			{field : 'linename',title : '线路标题',width : '200',align : 'left'},
			{field : 'lineprice',title : '售价',width : '200',align : 'center'},
			{field : 'agent_rate',title : '佣金',align : 'center', width : '110'},
			{field : 'satisfyscore',title : '满意度',width : '80',align : 'center'},
			{field : 'comment_count',title : '评论数',width : '80',align : 'center'},
			{field : 'peoplecount',title : '销量',width : '80',align : 'center'},
			{field : 'grade',title : '级别',width : '80',align : 'center'},
			{field : 'mobile',title : '供应商联系方式',width : '80',align : 'center'},
			{field : 'company_name',title : '供应商名称',align : 'center', width : '200'}
		         ];
	var isJsonp= false ;// 是否JSONP,跨域
	initTableForm("#line_grade","#line_grade_dataTable",line_grade_columns,isJsonp ).load();
	$("#searchBtn").click(function(){
		initTableForm("#line_grade","#line_grade_dataTable",line_grade_columns,isJsonp ).load();
	});
	$('#line_grade_Select').change(function(){
		initTableForm("#line_grade","#line_grade_dataTable",line_grade_columns,isJsonp ).load();
	});

	//目的地
$.post('/admin/b2/comboBox/get_destinations_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.kindname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	});
	//console.log(array);
	var comboBox = new jQuery.comboBox({
	    id : "#destinations",
	    name : "overcity",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
});
});


</script>