<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">活动管理 </li>
		</ul>
	</div>
	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">活动列表 </a></li>	
	</ul>
	
	<div class="tab-content tabs-flat">
<!-- 		<div>
				<a class="btn btn-info btn-xs">添加</a>
		</div> -->
		<!-- 活动列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							<div style="float:left;margin-left:20px;padding:5px 10px 5px 10px">
							 <a class="btn btn-info btn-xs" id="add_activity" style="padding:5px 10px 5px 10px">添加</a>
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top: 4px;">活动名称：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="name">
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
	</div>
</div>
<!-- 添加活动 -->
<div style="display: none;" class="bootbox modal fade in" id="add_activity_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close">×</button>
				<h4 class="modal-title">添加活动</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="add_activity_form" method="post" action="#" onsubmit="return CheckActivity();">
						<div style="height: 400px; overflow-y: auto;">
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动名称:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control" placeholder="活动名称"   name='name' >
									<input type="hidden" class="form-control" name='act_id' >
								</div>
							</div>
							<div class="form-group">
								<!--  <label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动城市:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control"  name="startplace" placeholder="活动城市" value="" id="custom_startcity"/>
            					 	<input type="hidden" name="startcityId" id="startcityId" value="" />
            						<div id="startcityStr" style="line-height:45px;"></div>
								</div>-->
							</div>
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">开始时间:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control" maxlength="100" placeholder="开始时间" name="starttime" id="starttime">
								</div>
							</div>

							<div class="form-group">
								<label for="inputPassword3"
									class="col-sm-2 control-label no-padding-right col_lb">结束日期:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control" maxlength="11" name="endtime" placeholder="结束日期"  id="endtime">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3"
									class="col-sm-2 control-label no-padding-right col_lb">说明:</label>
								<div class="col-sm-10 col_ts">
									<textarea rows="" cols="" placeholder="说明"  style="width:100%;height:80px;" name="description">
									
									</textarea>
								</div>
							</div>
							
							<div class="form-group">
								<label for="inputPassword3"
									class="col-sm-2 control-label no-padding-right col_lb">排序:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control" maxlength="11" name="showorder" value="999" >
								</div>
							</div>	
													
						<div class="form-group">
							<input type="button"  class="btn btn-palegreen bootbox-close-button" type="button" value="取消" style="float: right; margin-right: 2%;" />
							 <input type='submit' class="btn btn-palegreen" value='提交' style="float: right; margin-right: 2%;" />
						</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- 详情页面 -->
<div class="eject_body details_activity" >
	<div class="eject_colse ex_colse" onclick="ex_colse();">X</div>
	<div class="eject_title">活动详情</div>
	<div class="eject_content" style="position:relative;">
		<div class="eject_content_list clear">
			<div class="eject_list_row">
				<div class="eject_list_name ">活动名称：</div>
				<div class="content_info d_name"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">添加人：</div>
				<div class="content_info d_adminman"></div>
			</div>
			
		</div>
		<div class="eject_content_list clear">
			<div class="eject_list_row">
				<div class="eject_list_name ">开始日期：</div>
				<div class="content_info d_starttime"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">结束日期：</div>
				<div class="content_info d_endtime"></div>
			</div>
		</div>
		<div class="eject_content_list clear">
			<div class="eject_list_row"  style="width:90%">
				<div class="eject_list_name " style="width:16%">活动城市：</div>
				<div class="content_info d_startcity" style="width:80%"></div>
			</div>
		</div>

		<div class="eject_content_list clear">
			<div class="eject_list_row" style="width:90%">
				<div class="eject_list_name " style="width:16%">活动说明：</div>
				<div class="content_info d_description" style="width:80%">
					
				</div>	
			</div>		
			<div style="clear:both;"></div>
		</div>

		<div class="eject_botton">
			<input type="hidden" value="" name="sid" />
			<div class="ex_colse" onclick="ex_colse();">关闭</div>
		</div>	
	</div>						
</div>
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<!-- 城市控件 -->
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<!-- 时间控件 -->
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
	// 第一个列表 未使用===============================================================
	jQuery("#btnSearch0").click(function(){
		page0.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/activity/actData",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'name',title : '活动名称',align : 'center', width : '10%'},
					{field : 'starttime',title :'开始日期',width : '10%',align : 'center'},
					{field : 'endtime',title : '结束日期',align : 'center', width : '10%'},
					{field : 'username',title : '添加人',align : 'center', width : '10%'},
					{field : 'addtime',title : '添加时间',align : 'center', width : '15%'},

					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='<a href="###" data='+rowData.act_id+' onclick="look_act('+rowData.act_id+')" >查看</a>&nbsp;&nbsp;&nbsp;';
							html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=0&id='+rowData.act_id+'" >编辑</a>&nbsp;&nbsp;&nbsp;';
							html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=1&id='+rowData.act_id+'" >活动城市</a>&nbsp;&nbsp;&nbsp;';
							html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=2&id='+rowData.act_id+'" >活动分类</a>&nbsp;&nbsp;&nbsp;';
							html=html+'<a target="main" href="/admin/a/activity/edit_activity?tyle=3&id='+rowData.act_id+'" >活动线路</a>&nbsp;&nbsp;&nbsp;';
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
	
});


//=========================================================================================================================
	//添加活动的弹框
	$('#add_activity').click(function(){
		 $('#add_activity_modal').find('input[name="act_id"]').val(''); 
		 $('#add_activity_modal').find('input[name="startcityId"]').val('');
		 $('#add_activity_modal').find('#startcityStr').html(''); 
		 $('#add_activity_modal').find('input[name="name"]').val(''); 
		 $('#add_activity_modal').find('input[name="starttime"]').val(''); 
		 $('#add_activity_modal').find('input[name="endtime"]').val(''); 
		 $('#add_activity_modal').find('textarea[name="description"]').val('');
		 $('#add_activity_modal').find('textarea[name="showorder"]').val(''); 
		 
		 $("#add_activity_modal").show();
		 $(".modal-backdrop").show(); 
	});
	//出发城市获取
		createChoicePluginPY({
			data:{0:chioceStartCityJson['domestic']},
			nameId:'custom_startcity',
			valId:'startcityId',
			number:50,	
			isHot:true,
			buttonId:'startcityStr',
			hotName:'热门'
		});
  // 时间控件
	$('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
	$('#endtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
	//添加活动
	function CheckActivity(){
		
		   jQuery.ajax({ type : "POST",data : jQuery('#add_activity_form').serialize(),url : "<?php echo base_url()?>admin/a/activity/add_activity", 
				success : function(response) {
		 		 var response=eval("("+response+")");
						 if(response.status==1){  
                              alert(response.msg);
                              $('.bootbox-close-button').click();
                              $('#tab0').click(); 
						 }else{
							 alert(response.msg);
						 }	
						
                        
					}
			});
		return false;
	}
	//查看活动
	function look_act(obj){
		$.post("<?php echo base_url()?>admin/a/activity/activity_detail", {actid:obj} , function(re) {
		     var re=eval("("+re+")");
		    // alert(re.data.activity.cityname);
			 //活动信息
			 $('.details_activity').find('.d_name').html(re.data.activity.name);
			 $('.details_activity').find('.d_adminman').html(re.data.activity.username);
			 $('.details_activity').find('.d_starttime').html(re.data.activity.starttime);
			 $('.details_activity').find('.d_endtime').html(re.data.activity.endtime);
			 $('.details_activity').find('.d_description').html(re.data.activity.description);
			 //活动城市
			 var city='&nbsp;&nbsp;';
			 if(re.data.activity_city!=''){
				 $.each(re.data.activity_city,function(n,value) {
					 city=value.cityname+'&nbsp;&nbsp;'+city;
				 });
			 }
			 $('.details_activity').find('.d_startcity').html(city);
		 });
	  // alert(obj);
		$('.details_activity,.modal-backdrop').show();
		$('.details_activity').css('width','40%');
	}
	//关闭查看
	function ex_colse() {
		$('.modal-backdrop,.bootbox,.eject_body').hide();
	}

	//编辑
	function edit_act(obj){ 
		$('input[name="act_id"]').val(obj);
		$('#add_activity_modal').find('#startcityStr').html(''); 
		$.post("<?php echo base_url()?>admin/a/activity/activity_detail", {actid:obj} , function(re) {
		     var re=eval("("+re+")");
			 $('#add_activity_modal').find('input[name="name"]').val(re.data.activity.name); 
			 $('#add_activity_modal').find('input[name="starttime"]').val(re.data.activity.starttime); 
			 $('#add_activity_modal').find('input[name="endtime"]').val(re.data.activity.endtime); 
			 $('#add_activity_modal').find('textarea[name="description"]').val(re.data.activity.description);
			 $('#add_activity_modal').find('textarea[name="showorder"]').val(re.data.activity.showorder);
			 //活动城市 没有用到
			 var cityid='';
			 var str=''
			 if(re.data.activity_city!=''){
				 $.each(re.data.activity_city,function(n,value) {
					 cityid=cityid+value.startcityid+',';
					 var startcityIdstr="'startcityId'";
					 var startcityStr0="'startcityStr'";
					 str='<span class="selectedContent" value="'+value.startcityid+'" >'+value.cityname+'<span onclick="delPlugin1(this,'+startcityIdstr+' ,'+startcityStr0+');" class="delPlugin">x</sapn></span>';
					 $('#add_activity_modal').find('#startcityStr').append(str); 
				});
				
				 $('#add_activity_modal').find('input[name="startcityId"]').val(cityid); 
			 }
			  
		})
		
		$("#add_activity_modal").show();
		$(".modal-backdrop").show(); 
    }
    /*活动城市没有用到*/
	function delPlugin1(obj ,valId ,buttonId) {
		var actid=$('input[name="act_id"]').val();
		var valObj = $("#"+valId);
		var buttonObj = $("#"+buttonId);
		var id = $(obj).parent("span").attr("value");
		var ids = valObj.val();
		valObj.val(ids.replace(id+',',''));
		$(obj).parent("span").remove();
		if (buttonObj.children("span").length == 0) {
			buttonObj.html('');
			buttonObj.hide();
		}
		//alert(id);actid
		//删除活动城市
		$.post("<?php echo base_url()?>admin/a/activity/del_city_activity", {actid:actid,cityid:id} , function(re) {
		})
	}
</script>
