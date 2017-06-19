<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<style type="text/css">
	.search_input { width:200px;}
	.control-label { text-align:right;}
	
	.eject_text_info textarea{ display: block; width: 100%;}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">营业部管家列表 </li>
		</ul>
	</div>
	<div class="table-toolbar">
		  <a class="btn btn-info btn-xs" id="add_activity" target="main" href="/admin/a/manage/add_sales_expert" style="padding:5px 10px 5px 10px">添加</a>
	</div>	
	<ul class="nav nav-tabs">
	    <li class="active" id="tab0" name="tabs"><a href="#home0">申请中 </a></li>
		<li class="" id="tab1" name="tabs"><a href="#home1">合作中 </a></li>	
		<li class="" id="tab2" name="tabs"><a href="#home2">已拒绝 </a></li>	
		<li class="" id="tab3" name="tabs"><a href="#home3">已终止</a></li>	
	</ul>
		
	<div class="tab-content ">
		<!-- 申请中 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm">
						<div class="form-group has-feedback">		
							<label class="control-label"  style="width: 85px;padding-right:0px;">管家名称：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="expertname" id="expertname" placeholder="管家名称-模糊搜索">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">营业部：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="departname" id="departtname" placeholder="营业部-模糊搜索">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div class="" style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch0">
							</div>
						</div>
					</form>
					<div id="list"></div>
				</div>
			</div>
		</div>

		<!-- 合作中 -->
		<div class="tab-pane" id="home1">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm1">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;">管家名称：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="expertname" id="expertname" placeholder="管家名称-模糊搜索">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">营业部：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="departname" id="departtname" placeholder="营业部-模糊搜索">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div class="" style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch1">
							</div>
						</div>
					</form>
					<div id="list1"></div>
				</div>
			</div>
		</div>
		<!-- 已拒绝 -->
		<div class="tab-pane " id="home2">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm2">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;">管家名称：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="expertname" id="expertname" placeholder="管家名称-模糊搜索">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">营业部：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="departname" id="departtname" placeholder="营业部-模糊搜索">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div class="" style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch2">
							</div>
						</div>
					</form>
					<div id="list2"></div>
				</div>
			</div>
		</div>
		<!-- 已终止-->
		<div class="tab-pane " id="home3">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm3">
						<div class="form-group has-feedback">
						   <label class="control-label"  style="width: 85px;padding-right:0px;">管家名称：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="expertname" id="expertname" placeholder="管家名称-模糊搜索">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">营业部：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="departname" id="departtname" placeholder="营业部-模糊搜索">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div class="" style="display:inline-block;padding-left:2px;">
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
<!-- 终止合作 -->
<div class="eject_body stop_expert">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title">终止与管家合作</div>
	<div class="eject_content">
		<div class="eject_content_text">
			<div class="eject_text_name">终止理由:</div>
			<div class="eject_text_info"><textarea rows="5" cols="50" name="reason" ></textarea></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="stop_id" />
			<div class="ex_colse">关闭</div>
			<div class="ex_stop">确认终止</div>
		</div>	
	</div>						
</div>
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<?php echo $this->load->view('admin/a/expert/expert_detail.php');  ?>
<?php echo $this->load->view('admin/a/expert/expert_line.php');  ?>
<script type="text/javascript">
jQuery(document).ready(function(){

	// 第一个列表 申请中===============================================================
	jQuery("#btnSearch0").click(function(){
		page0.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/manage/pageData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '管家姓名',align : 'center', width : '10%'},
					{field : 'mobile',title :'手机号码',width : '10%',align : 'center'},
					{field : 'email',title : '邮箱',align : 'center', width : '10%'},
					{field : 'idcard',title : '身份号',align : 'center', width : '10%'},
					{field : 'username',title : '所属地',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
								return rowData.country+rowData.province+rowData.city;	
						}
					},
					{field : 'name',title : '营业部',align : 'center', width : '10%'},
					{field : 'addtime',title : '添加时间',align : 'center', width : '15%'},

					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							var html='';
							var url="'/admin/a/experts/expert_list/getExpertDetails'";
							html=html+'<a href="###" data='+rowData.act_id+' onclick="expertDetails('+rowData.expert_id+' ,1,'+url+')"  >通过</a>&nbsp;&nbsp;&nbsp;';
							return html;
						}
					}

				]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page0.load({"status":"1"});
	});
	
	//第二个列表 合作中===============================================================
	jQuery("#btnSearch1").click(function(){
		page1.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/manage/pageData",form : '#listForm1',// 绑定一个查询表单的ID
		columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '管家姓名',align : 'center', width : '10%'},
					{field : 'mobile',title :'手机号码',width : '10%',align : 'center'},
					{field : 'email',title : '邮箱',align : 'center', width : '10%'},
					{field : 'idcard',title : '身份号',align : 'center', width : '10%'},
					{field : 'username',title : '所属地',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							return rowData.country+rowData.province+rowData.city;	
						}
					},
					{field : 'name',title : '营业部',align : 'center', width : '10%'},
					{field : 'addtime',title : '添加时间',align : 'center', width : '15%'},

					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='<a href="###" data='+rowData.act_id+' onclick="stop('+rowData.expert_id+')" >终止合作</a>&nbsp;&nbsp;&nbsp;';
							//html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=0&id='+rowData.act_id+'" >退回</a>&nbsp;&nbsp;&nbsp;';
							return html;
						}
					}

				]
	});
	
	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery('#tab1').addClass('active');
		page1.load({"status":"2"});
	});

	//第三个列表 已拒绝===============================================================
		jQuery("#btnSearch2").click(function(){
		page2.load({"status":"3"});
	});
	var data = '';
	page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/manage/pageData",form : '#listForm2',// 绑定一个查询表单的ID
		columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '管家姓名',align : 'center', width : '10%'},
					{field : 'mobile',title :'手机号码',width : '10%',align : 'center'},
					{field : 'email',title : '邮箱',align : 'center', width : '10%'},
					{field : 'idcard',title : '身份号',align : 'center', width : '10%'},
					{field : 'username',title : '所属地',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							return rowData.country+rowData.province+rowData.city;	
						}
					},
					{field : 'name',title : '营业部',align : 'center', width : '10%'},
					{field : 'addtime',title : '添加时间',align : 'center', width : '15%'}

			/* 		{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='<a href="###" data='+rowData.act_id+' onclick="look_act('+rowData.act_id+')" >通过</a>&nbsp;&nbsp;&nbsp;';
							//html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=0&id='+rowData.act_id+'" >退回</a>&nbsp;&nbsp;&nbsp;';
							return html;
						}
					}, */

				]
	});
	jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery('#tab2').addClass('active');
		page2.load({"status":"3"});
	});
	//第四个列表 已终止===============================================================
	jQuery("#btnSearch3").click(function(){
		page3.load({"status":"-1"});
	});
	var data = '';
	page3=new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/manage/pageData",form : '#listForm3',// 绑定一个查询表单的ID
		columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '管家姓名',align : 'center', width : '10%'},
					{field : 'mobile',title :'手机号码',width : '10%',align : 'center'},
					{field : 'email',title : '邮箱',align : 'center', width : '10%'},
					{field : 'idcard',title : '身份号',align : 'center', width : '10%'},
					{field : 'username',title : '所属地',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							return rowData.country+rowData.province+rowData.city;	
						}
					},
					{field : 'name',title : '营业部',align : 'center', width : '10%'},
					{field : 'addtime',title : '添加时间',align : 'center', width : '15%'},

					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='<a href="###" data='+rowData.act_id+' onclick="recovery('+rowData.expert_id+')" >恢复合作</a>&nbsp;&nbsp;&nbsp;';
							//html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=0&id='+rowData.act_id+'" >退回</a>&nbsp;&nbsp;&nbsp;';
							return html;
						}
					}

				]
	});
	jQuery('#tab3').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home3').addClass('active');
		jQuery('#tab3').addClass('active');
		page3.load({"status":"-1"});
	});
});
//=======================================================================================================================================
//关闭管家详情
$('.ex_colse').click(function() {
	$('.modal-backdrop').hide();
	$('.details_expert').hide();
	$('.stop_expert').hide();
	$('.expert_info_line').hide();
})
//通过申请
var ts = true;
$('.ex_through').click(function() {
	if (ts == false) {
		return false;
	} else {
		ts = false;
	}
	var id = $('input[name="id"]').val();
	$.post("/admin/a/experts/expert_list/through_expert",{'id':id},function(data){
		ts = true;
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			$('#tab0').click();
			$('.ex_colse').click();
		} else {
			alert(data.msg);
		}
	});
})
//终止合作
function stop(id) {
	$('input[name="stop_id"]').val(id);
	$('textarea[name="reason"]').val('');
	$('.stop_expert').show();
	$('.modal-backdrop').show();
}
//终止与管家合作
var ss = true;
$('.ex_stop').click(function(){
	if (ss == false) {
		return false;
	} else {
		ss = false;
	}
	var id = $('input[name="stop_id"]').val();
	var reason = $('textarea[name="reason"]').val();
	$.post("/admin/a/experts/expert_list/stop_expert",{'id':id,'reason':reason},function(data){
		ss = true;
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			$('#tab1').click();
			$('.ex_colse').click();
		} else {
			alert(data.msg);
		}
	});
})
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
				alert(data.msg);
				$('#tab3').click();
				$('.ex_colse').click();
			} else {
				alert(data.msg);
			}
		})
	}
	return false;
}
</script>
