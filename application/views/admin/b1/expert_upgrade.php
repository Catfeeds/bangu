<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.registered_btn a{ padding:6px 4px; background: #2dc3e8;color: #fff; border-radius: 3px;  text-decoration: none}
	#myTab11{ margin-top: 20px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">管家升级管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
			    	<li class="active" name="tabs"><a href="#home1" data-toggle="tab" id="tab1"> 申请中 </a></li>  
					<li class="" name="tabs"><a href="#home2" data-toggle="tab" id="tab2"> 供应商通过 </a></li>
					<li class="" name="tabs"><a href="#home3" data-toggle="tab" id="tab3">平台通过 </a></li>
					<li class="" name="tabs"><a href="#home4" data-toggle="tab" id="tab4"> 已拒绝 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 申请中  -->
					<div class="tab-pane active" id="home1">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">线路标题：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="linename" >
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">出发城市：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text"  id="startcity" name="startcity" style="width:130px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">目的地：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									    <!--  <input class="form-control user_name_b1" type="text" id="destinations" name="destinations"style="width:100px;"> --> 
									    	  <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">管家：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" id="expert" name="expert" style="width:80px;">
										</div>	
	
						            	
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch">
										</div>
									</div>
								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 合作中  -->
					<div class="tab-pane " id="home2">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm1"
									novalidate="novalidate">
									<div class="form-group has-feedback">
									  	<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">线路标题：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="linename" >
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">出发城市：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text"  id="startcity1" name="startcity" style="width:130px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">目的地：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									     <!--   <input class="form-control user_name_b1" type="text"  id="destinations1" name="destinations1" style="width:100px;">-->
									     	<input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										     <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">管家：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" id="expert1" name="expert" style="width:80px;">
										</div>	
						            
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch1">
										</div>
									</div>
								</form>

								<div id="list1"></div>
							</div>
						</div>
					</div>
					<!-- 已拒绝 -->
					<div class="tab-pane " id="home3">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm2"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">线路标题：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="linename" >
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">出发城市：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text"  id="startcity2" name="startcity" style="width:130px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">目的地：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									    <!--   <input class="form-control user_name_b1" type="text"  id="destinations2" name="destinations2" style="width:100px;">-->
									    	 <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										     <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">管家：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" id="expert2" name="expert" style="width:80px;">
										</div>	
						            	
										<label class="col-lg-4 control-label"style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch2">
										</div>
									</div>
								</form>

								<div id="list2"></div>
							</div>
						</div>
					</div>
					<!-- 已终止  -->
					<div class="tab-pane " id="home4">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm3"
									novalidate="novalidate">
									<div class="form-group has-feedback">
										  	<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">线路标题：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="linename" >
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">出发城市：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text"  id="startcity3" name="startcity" style="width:130px;">
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">目的地：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									     <!--<input class="form-control user_name_b1" type="text"  id="destinations3" name="destinations3" style="width:100px;">-->
									    	 <input id="cityName"  style="width: 150px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										     <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>	
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">管家：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									      <input class="form-control user_name_b1" type="text" id="expert3" name="expert" style="width:80px;">
										</div>	
						            
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch3">
										</div>
									</div>
								</form>

								<div id="list3"></div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 管家升级 -->
<div class="lookexpert modal fade in" style="display:none;">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:650px;height:380px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">管家升级</h4>
			    </div>
			    <div class="modal-body" style="height:450px;overflow-y:auto;overflow-x:hidden;">
			    <div class="bootbox-body">
			       <form  class="form-horizontal" id="expert_upgrade_from" method="post" action="">
			         <div class="gift_member">		
			         <div class="form-group">
			         	    <input type="hidden" name="upgrade_id" id="upgrade_id" >
			         	    <input type="hidden" name="expert_type" id="expert_type" >
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3" id="reason">通过原因:</label>
			            <div class="col-sm-4 fl nickname">
			            	<span><textarea style="width:390px;height:200px;" name="supplier_reason" id="supplier_reason"></textarea></span>
			            </div>
			  
			        </div>
			        <div class="form-group">
				<input type="button" class="btn btn-palegreen"
					data-bb-handler="success"  onclick="sb_expert_upgrade()" value="提交"
					style="margin-left: 40%;">
					<input type="button" class="btn btn-palegreen bootbox-close-button"
					data-bb-handler="success" value="关闭"
					style="margin-left: 4%;">
			       </div>

                 			</div>
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>



<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<?php echo $this->load->view('admin/b1/common/expert_upgrade_script'); ?>

<script type="text/javascript">
//查看管家信息
function look_div(id){
	$('input[name="upgrade_id"]').val(id);
	$('#supplier_reason').val('');
	$('#expert_type').val('1');
	$('#reason').html('通过原因:');
	$('.lookexpert').show();
}
//通过,拒绝管家升级
function  sb_expert_upgrade(){
	jQuery.ajax({ type : "POST",data : jQuery('#expert_upgrade_from').serialize(),url : "<?php echo base_url()?>admin/b1/expert_upgrade/update_expertGrade", 
		success : function(data) {
 			var data=eval("("+data+")");
			 if(data.status==1){ 
			          $('#tab1').click(); 
				alert(data.msg);
				$('.lookexpert ').hide();		
			 }else{
			 	$('.lookexpert ').hide();
				alert(data.msg);
			 }	
		}
	});
}
$('.bootbox-close-button').click(function(){
	$('.lookexpert ').hide();
});

//终止合作
function re_expert(id){
	$('input[name="upgrade_id"]').val(id);
	$('#supplier_reason').val('');
	$('#expert_type').val('2');
	$('#reason').html('拒绝原因:');
	$('.lookexpert').show();
}

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
	var comboBox = new jQuery.comboBox({
	    id : "#startcity1",
	    name : "startcity_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
	var comboBox = new jQuery.comboBox({
	    id : "#startcity3",
	    name : "startcity_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
	var comboBox = new jQuery.comboBox({
	    id : "#startcity4",
	    name : "startcity_id",// 隐藏的value ID字段
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
	    /*	var expert_id=$('#expert_id').val();
	    	alert(expert_id);
	    	if (expert_id=='') {
	    		$('input[name="expert"]').val('');
	    	};*/
	    },
	    data : array
	});

	var comboBox = new jQuery.comboBox({
	    id : "#expert1",
	    name : "expert_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件
	    	//alert(id);

	    },
	    data : array
	});
	var comboBox = new jQuery.comboBox({
	    id : "#expert2",
	    name : "expert_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
	var comboBox = new jQuery.comboBox({
	    id : "#expert3",
	    name : "expert_id",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
//目的地
var oleft = 0 ; 
var oTop = 0;
function b1_showCGZDestTree(obj,cityid){
	oleft = 0 ; 
	oTop = -40 ;
	treeInputObj = obj;
	var url = '/common/get_data/getTripDestBaseArr';
	var zNodes = commonTree(obj ,url ,cityid);
	
	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword(obj ,zNodes ,event);
	})
}
</script>
<?php  echo $this->load->view('admin/common/tree_view'); ?>	