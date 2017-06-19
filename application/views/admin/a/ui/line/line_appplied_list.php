<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.col_span{ float: left;margin-top: 6px}
	.col_ip{ float: left; }
	.form-group{ margin-top: 16px; }
	#adjust_grade .form-group{float:none;}
	#nav_form .form-group{float:none;}
	.tab-pane{margin-top: 40px;}
	.col_div{ width:84%;}
	.col_lb{ width:16%; text-align: right;}
</style>
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">管家申请售卖线路管理</li>
		</ul>
	</div>
	<!-- Page Body -->

	<div class="well">
		<ul id="myTab5" class="nav nav-tabs">
			
			<li class="active">
				<a href="<?php echo base_url(); ?>admin/a/line_apply/applied_line">已申请</a>
			</li>
		</ul>
		<div class="tab-content">

			<form class="form-inline" id="search_condition" method="post" action="<?php echo site_url('admin/a/line_apply/get_applied_line')?>">
				<div class="form-group dataTables_filter" >
					<span class="search_title col_span">供应商:</span>
					<input type="text" class="form-control col_ip" placeholder="供应商" id="company_name" name="company_name" style="width:200px;margin-right:20px;">
				</div>
				<div class="form-group dataTables_filter" style="margin-right:20px;">
					<span class="search_title col_span">管家:</span>
					<input type="text" id="expert_name" class="form-control col_ip" name="expert_name" style="width:100px;">
				</div>
				<div class="form-group dataTables_filter" style="margin-right:20px;">
					<span class="search_title col_span">目的地:</span>
					<input type="text" class="form-control col_ip" placeholder="目的地" id="destinations"  name="destinations" style="width:140px;">
				</div>
				<div class="form-group dataTables_filter" style="margin-right:20px;">
					<span class="search_title col_span">出发城市:</span>
					<input type="text" id="startcity" class="form-control col_ip"  placeholder="出发城市" name="startcity" style="width:140px;">
				</div>
				
				<div class="form-group" style="margin-right:20px;">
					<span class="search_title col_span">线路名称:</span>
					<input type="text" class="form-control col_ip" name="linename" style="width:200px;"/>
				</div>
				<input type="hidden" name="status" value="2">
				<input type="hidden" name="page_new" value="1">
				<button type="submit" class="btn btn-darkorange active" style="margin-left: 50px; margin-top:15px">搜索</button>
			</form>
			<div class="tab-pane active">
				<table class="table table-striped table-bordered table-hover dataTable no-footer">
					<thead class="pagination_title"></thead>
					<tbody class="pagination_data"></tbody>
				</table>
				<br/>
				<div class="pagination"></div>
			</div>
			</div>
		</div>
</div>

<div style="display:none;" class="bootbox modal fade in change_expert_grade" >
		<div class="modal-dialog">
			<div class="modal-content  clear">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">调整级别</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="adjust_grade" method="post">
					<div class="form-group ">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_lb">管家级别</label>
						<div class="col-sm-10 fl col_div">
							<select name="grade" style="width:100%;height:100%">
				               	<?php 
				               		foreach($gradeArr as $key =>$val) {
				               			echo "<option value='{$key}'>{$val}</option>";
				               		}
				               	?>
				             </select>
						</div>
					</div>
<!-- 					<div class="form-group"> -->
<!-- 						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_lb">备注</label> -->
<!-- 						<div class="col-sm-10 col_div fl"> -->
<!-- 							<textarea name="reason" style="resize:none;width:100%;height:100%" placeholder="备注"></textarea> -->
<!-- 						</div> -->
<!-- 					</div> -->
					<input type="hidden" value="" name="change_id">
					<div class="form-group form_submit">
						<input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>

<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content  clear">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">删除记录</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="nav_form" method="post">
					<div class="form-group ">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_lb">线路标题</label>
						<div class="col-sm-10 fl col_div">
							<input class="form-control" disabled  name="line_title" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_lb">供应商名称</label>
						<div class="col-sm-10 col_div fl">
							<input class="form-control" disabled name="supplier_name" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_lb">专家姓名</label>
						<div class="col-sm-10 col_div fl">
							<input class="form-control" disabled name="expertName" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_lb">专家级别</label>
						<div class="col-sm-10 col_div fl">
							<input class="form-control" disabled name="grade" type="text">
						</div>
					</div>
					<p style="color:red;">请谨慎操作，您删除后管家将没有此线路的售卖权，但他可以重新申请!</p>
					<input type="hidden" value="" name="is">
					<input type="hidden" value="" name="line_id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input id="submit_line" class="btn btn-palegreen submit" value="删除" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
					
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade in" style="display:none;"></div>

<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script src="<?php echo base_url('assets/js/admin/common.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/admin/comboBox.js') ;?>"></script>
<script type="text/javascript">
var grade = <?php echo json_encode($gradeArr);?>;
var columns = [ {field : 'line_title',title : '线路标题',width : '260',align : 'left'},
		{field : 'supplier_name',title : '供应商',width : '200',align : 'center'},
		{field : 'cityname',title : '出发地',width : '140',align : 'center'},
		{field : null,title : '佣金比例',align : 'center', width : '100',formatter:function(item){
				return (item.agent_rate*100).toFixed(2)+'%';
			}
		},
		{field : 'expert_name',title : '管家名称',align : 'center', width : '120'},
		{field : null,title : '管家级别',align : 'center', width : '100',formatter:function(item){
				return grade[item.grade];
			}
		},
		{field : null,title : '操作',align : 'center', width : '200',formatter:function(item){
				var button = '<button class="btn btn-palegreen" grade="'+item.grade+'" data-val="'+item.laid+'" onclick="change_grade(this)">调整级别</button>&nbsp;';
				button += '<button class="btn btn-sky" id="bootbox-confirm" data-val="'+item.laid+'" onclick="show_delet_dialog(this)">删除</button>';
				return button;
			}
		},
	];
//初始加载
get_ajax_page_data(columns); 

//搜索
$('#search_condition').submit(function(){
	var status = $('input[name="status"]').val();
	$('input[name="page_new"]').val(1);
	get_ajax_page_data(columns); 
	return false;	
})
//更改级别
function change_grade(obj){
    var laid = $(obj).attr('data-val');
    var grade = $(obj).attr('grade');
    $("input[name='change_id']").val(laid);
	$('#adjust_grade').find('select[name="grade"]').val(grade);
    $('.modal-backdrop,.change_expert_grade').show();
}
$("#adjust_grade").submit(function(){
	$.post("/admin/a/line_apply/change_expert_grade",$("#adjust_grade").serialize(),function(json){
		var data = eval('('+json+')');
		if (data.code == 2000) {
			 $('.modal-backdrop,.change_expert_grade').hide();
			alert(data.msg);
			get_ajax_page_data(columns);
		} else {
			alert(data.msg);
		}
	})
	return false;
})

function show_delet_dialog(obj){
	 var id = $(obj).attr('data-val');
	 $.post(
			"<?php echo site_url('admin/a/line_apply/get_line_json')?>",
			{'id':id},
			function(data) {
				data = eval('('+data+')');
				$('input[name="line_title"]').val(data.line_title);
				$('input[name="supplier_name"]').val(data.supplier_name);
				$('input[name="expertName"]').val(data.expert_name);
				$('input[name="line_id"]').val(data.laid);
				$('input[name="grade"]').val(grade[data.grade]);
				$('.modal-backdrop').show();
				$('.bootbox').show();
			}
		);
}
$('#submit_line').click(function(){
	id = $('input[name = "line_id"]').val();
	var page_new = $('input[name="page_new"]').val();
	$.post( "/admin/a/line_apply/delete_line", {'id':id}, function (data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				get_ajax_page_data(columns);
				$('.modal-backdrop,.bootbox').hide();
			} else {
				alert(data.msg);
			}
		}
	);
})
$('.bootbox-close-button').click(function(){
	$('.modal-backdrop').hide();
	$('.bootbox').hide();
})
</script>