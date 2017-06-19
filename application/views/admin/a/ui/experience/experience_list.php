<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />

<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">体验师管理 </li>
		</ul>
	</div>
	<div class="table-toolbar">
		  <a class="btn btn-info btn-xs" id="add_experience" onclick="add_experience(this)" style="padding:5px 10px 5px 10px">添加</a>
	</div>	
	<ul class="nav nav-tabs">
	    <li class="active" id="tab0" name="tabs"><a href="#home0">申请中 </a></li>
		<li class="" id="tab1" name="tabs"><a href="#home1">已通过 </a></li>	
		<li class="" id="tab2" name="tabs"><a href="#home2">已拒绝 </a></li>	
	</ul>
		
	<div class="tab-content ">
		<!-- 申请中 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm">
						<div class="form-group has-feedback">		
							<label class="control-label"  style="width: 85px;padding-right:0px;">会员名称：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="nickname" id="nickname">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">线路：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="linename" id="linename">
							</div>	
                            <label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
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
							<label class="control-label"  style="width: 85px;padding-right:0px;">会员名称：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="nickname" id="nickname">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">线路：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="linename" id="linename">
							</div>		
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
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
							<label class="control-label"  style="width: 85px;padding-right:0px;">会员名称：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="nickname" id="nickname">
							</div>	
							<label class="control-label"  style="width: 85px;padding-right:0px;">线路：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="linename" id="linename">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch2">
							</div>
						</div>
					</form>
					<div id="list2"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 添加体验师 -->
<div style="display:none;position:absolute;overflow:visible;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close" >×</button>
				<h4 class="modal-title">添加体验师</h4>
			</div>
			<div class="modal-body">
			<div class="bootbox-body">
			<div>
				<form class="form-horizontal" id="form_experience" method="post">
				 <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb"><span style="color: red;">*</span>会员名称</label>
					<div class="col-sm-6 col_ts"  style="width:50%">
							<input class="form-control"  name="agent_name"  placeholder="请输入会员名称" type="text">
							<input type="hidden" value="" name="agent_id">
					</div>
                    <div class="agent_name_button" style="height:25px;line-height:25px;background:#2dc3e8;color:#fff;font-size:14px;cursor:pointer;width:130px;float:right;left:-52px;position:relative;text-align:center;border-radius:3px;">点此可选择会员</div>
				</div>
				
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb"><span style="color: red;">*</span>订单线路</label>
					<div class="col-sm-10 col_ts" >
					       <select id="order_select" name="order_id" style="width:270px">
					              <option value="">请选择</option>
					       </select>
					</div>
				</div>
				
				<input type="hidden" value="" name="type_id">
				<div class="form-group form_submit">
					<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
					<input class="btn btn-palegreen submit" id="pass_form"  name="pass_form" value="通过" style="float: right; margin-right: 2%;" type="button">
					<input class="btn btn-palegreen submit" id="submit_form"  name="submit_form" value="保存" style="float: right; margin-right: 2%;" type="button">
				</div>
				</form>
			</div>
			</div>
			</div>
		</div>
	</div>
</div>
	
<!-- 选择旅行社弹出层 开始-->
<div class="eject_body">
	<div class="eject_colse colse_travel">X</div>
	<div class="eject_title">请选择会员</div>
	<div class="search_travel_input">
		<input class="search_travel_condition" type="text" placeholder="请输入会员" name="search_travel_name">
		<div class="search_button">搜索</div>
	</div>
	<div class="eject_content" style="clear: both;">
		<div class="choice_tralve_agent">海外国旅旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社深圳市口岸中国旅行社</div>
	</div>	
	<div class="pagination page_travel" style="padding-right:12px;"></div>
	<div style="clear:both;"></div>
	<div class="eject_botton">
		<div class="eject_through">选择</div>
		<div class="eject_fefuse colse_travel">取消</div>
	</div>					
</div>							
<!-- 选择旅行社 弹出层结束 -->
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />

<script type="text/javascript">
jQuery(document).ready(function(){

	// 第一个列表 申请中===============================================================
	jQuery("#btnSearch0").click(function(){
		page0.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/experience/pageData",form : '#listForm',// 绑定一个查询表单的ID
		columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'nickname',title : '会员姓名',align : 'center', width : '10%'},
					{field : 'mobile',title : '手机号',align : 'center', width : '10%'},
					{field : 'ordersn',title :'订单编号',width : '10%',align : 'center'},
					{field : 'productname',title : '订单线路',align : 'center', width : '20%'},

					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='';
							html=html+'<a href="###" data='+rowData.act_id+' onclick="ex_through('+rowData.id+',1)"  >通过</a>&nbsp;&nbsp;&nbsp;';
							html=html+'<a href="###" data='+rowData.act_id+' onclick="ex_through('+rowData.id+',2)"  >拒绝</a>&nbsp;&nbsp;&nbsp;';
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
		page0.load({"status":"0"});
	});
	
	//第二个列表 合作中===============================================================
	jQuery("#btnSearch1").click(function(){
		page1.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page1=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/experience/pageData",form : '#listForm1',// 绑定一个查询表单的ID
		columns : [

					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'nickname',title : '会员姓名',align : 'center', width : '10%'},
					{field : 'mobile',title : '手机号',align : 'center', width : '10%'},
					{field : 'ordersn',title :'订单编号',width : '10%',align : 'center'},
					{field : 'productname',title : '订单线路',align : 'center', width : '20%'}

	/* 				{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='<a href="###" data='+rowData.act_id+' onclick="stop('+rowData.expert_id+')" >终止合作</a>&nbsp;&nbsp;&nbsp;';
							//html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=0&id='+rowData.act_id+'" >退回</a>&nbsp;&nbsp;&nbsp;';
							ret urn html;
						}
					}, */

				]
	});
	
	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery('#tab1').addClass('active');
		page1.load({"status":"1"});
	});

	//第三个列表 已拒绝===============================================================
		jQuery("#btnSearch2").click(function(){
		page2.load({"status":"-1"});
	});
	var data = '';
	page2=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/experience/pageData",form : '#listForm2',// 绑定一个查询表单的ID
		columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'nickname',title : '会员姓名',align : 'center', width : '10%'},
					{field : 'mobile',title : '手机号',align : 'center', width : '10%'},
					{field : 'ordersn',title :'订单编号',width : '10%',align : 'center'},
					{field : 'productname',title : '订单线路',align : 'center', width : '20%'}

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
		page2.load({"status":"-1"});
	});

});
//=======================================================================================================================================
//添加体验师
function add_experience(obj){
	$('input[name="type_id"]').val('');
	$('input[name="agent_name"]').val('');
	$('input[name="agent_id"]').val('');
	$('#order_select').html('<option value="">请选择</option>');
	$('.modal-title').html('添加体验师');
	$('.bootbox').show();
	$('.modal-backdrop').show();
}
//提价体验师表单
$('#submit_form,#pass_form').click(function() {
	var name=$(this).attr('name');
	$('input[name="type_id"]').val(name);
	var url = '/admin/a/experience/add_experience';
	$.post(
	url,
	$('#form_experience').serialize(),
		function(data) {
			data = eval('('+data+')');
			if (data.status == 1) {
				alert(data.message);
				$('#tab0').click();
				$('.bootbox-close-button').click();
			} else {
				alert(data.message);
			}
		}
   );
   return false;
	
})

//通过申请
var ts = true;
function ex_through(obj,type){
	var status=0;
    if(type==1){
    	status=1;
    }else if(type==2){
    	status='-1';
    } 
	$.post("/admin/a/experience/update_experience",{'id':obj,'status':status},function(data){
		ts = true;
		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.message);
			$('#tab0').click();
		//	$('.ex_colse').click();
		} else {
			alert(data.message);
		}
	}); 
}


/*****************选择会员*************************/
$('.colse_travel').click(function() {
	$('.eject_body').hide();
})
//选择旅行社弹出层
$('.agent_name_button').click(function() {
	$.post(
		"/admin/a/experience/get_member_list",
		{'is':1,'pagesize':18},
		function(data) {
			data = eval('('+data+')');
			$('.eject_content').html('');
			$.each(data.list ,function(key ,val) {
				var str = '<div class="choice_tralve_agent" agent_id="'+val.mid+'">'+val.nickname+'</div>';
				$('.eject_content').append(str);
			})
			$('.eject_content').append('<div style="clear:both;"></div>');
			$('.page_travel').html(data.page_string);

			$('input[name="search_travel_name"]').val('');
			$('.eject_content').css('min-height','200px');
			$('.eject_body').css({'z-index':'10000','top':'10px','min-height':'400px'}).show();

			//点击旅行社时执行
			$('.choice_tralve_agent').click(function() {
				$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
				$(this).css('border','2px solid green').addClass('active');
			})

			//点击分页
			$('.ajax_page').click(function(){
				var page_new = $(this).find('a').attr('page_new');
				get_travel_data(page_new);
			})
		}
	);
})
//会员
function get_travel_data(page_new) {
	var name = $('input[name="search_travel_name"]').val();
	$.post(
		"/admin/a/experience/get_member_list",
		{'is':1,'pagesize':18,'page_new':page_new,'name':name},
		function(data) {
			data = eval('('+data+')');
			$('.eject_content').html('');
			$.each(data.list ,function(key ,val) {
				var str = '<div class="choice_tralve_agent" agent_id="'+val.mid+'">'+val.nickname+'</div>';
				$('.eject_content').append(str);
			})
			$('.eject_content').append('<div style="clear:both;"></div>');
			$('.page_travel').html(data.page_string);

			//点击旅行社时执行
			$('.choice_tralve_agent').click(function() {
				$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
				$(this).css('border','2px solid green').addClass('active');
				
			})
			//点击分页
			$('.ajax_page').click(function(){
				var page_new = $(this).find('a').attr('page_new');
				get_travel_data(page_new);
			})
		}
	);
}
//点击搜索会员
$('.search_button').click(function(){
	get_travel_data(1);
})
//选择会员
$('.eject_through').click(function(){
	var active = $('.eject_content').find('.active');
	var agent_name = active.html();
	var agent_id = active.attr('agent_id');
	 $('#order_select').html('<option value="">请选择</option>');
	//筛选会员的订单
	$.post(
	"/admin/a/experience/get_member_order",
	{'memberid':agent_id,},
	function(data) {
		data = eval('('+data+')');
		if(data.status==1){
			$str=''
			 $.each(data.member,function(n,value) {
				 $str=$str+'<option value='+value.id+'>'+value.productname+'</option>'	;
			 })
			 $('#order_select').append($str);
		}       
	}
	);
	
	$('input[name="agent_name"]').val(agent_name);
	$('input[name="agent_id"]').val(agent_id);
	$('.eject_body').hide();
})
/*********************************选择会员**结束**********************************/
</script>

