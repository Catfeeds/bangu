<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<style type="text/css">
.up_img ul{list-style-type:none;} 
.up_img ul li{float:left;margin:0px 10px 0px 0px ;float: left;width: 130px;height:85px;text-align: center;} 
.up_img .float_img{ height: 22px;z-index: 100;color: #000;font-size: 21px;font-weight: 700;opacity: 0.2;font-size: 24px;cursor: pointer;float: right;}
.eject_list_name{width:10%;}
</style>
<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu" onclick="close_xiuxiu();">×</div>
	<div class="right_box"></div>
</div>
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
	    <li class="active" id="tab0" name="tabs"><a href="#home0">活动信息 </a></li>
		<li class="" id="tab1" name="tabs"><a href="#home1">活动城市 </a></li>	
		<li class="" id="tab2" name="tabs"><a href="#home2">活动分类 </a></li>	
		<li class="" id="tab3" name="tabs"><a href="#home3">活动线路</a></li>	
	</ul>
	
	<div class="tab-content tabs-flat">
		<!-- 活动列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
			<form id="add_actlist_form" class="form-horizontal" onsubmit="return CheckActivity();" action="#" method="post" role="form">
			<div class="eject_content" style="margin-bottom:60px;">
				<div class="eject_content_list">
					<div class="eject_list_row">
						<div class="eject_list_name "><span style="color: red;" >*</span>活动名称:</div>
						<div class="content_info">
						<input type="text" value="<?php if(!empty($activity)){ echo $activity[0]['name'];} ?>" name="name">
						<input class="form-control" type="hidden" name="act_id" value="<?php if(!empty($activity)){ echo $activity[0]['id'];} ?>">
						</div>
					</div>
				</div>
				<div class="eject_content_list">
					<div class="eject_list_row">
						<div class="eject_list_name "><span style="color: red;" >*</span>开始时间:</div>
						<div class="content_info">
						<input type="text" value="<?php if(!empty($activity)){ echo $activity[0]['starttime'];} ?>" name="starttime" id="a_starttime">
						</div>
					</div>
				</div>
				<div class="eject_content_list">
					<div class="eject_list_row">
						<div class="eject_list_name "><span style="color: red;" >*</span>结束日期:</div>
						<div class="content_info">
						<input type="text" value="<?php if(!empty($activity)){ echo $activity[0]['endtime'];} ?>" name="endtime" id="a_endtime">
						</div>
					</div>
				</div>
				<div class="eject_content_list">
					<div class="eject_list_row">
						<div class="eject_list_name ">说明:</div>
						<div class="content_info">
						    <textarea name="description" style="width:420px;height:100px">
						     <?php if(!empty($activity)){ echo $activity[0]['description'];} ?>
						    </textarea>
						</div>
					</div>
				</div>
				<div class="eject_content_list">
					<div class="eject_list_row">
						<div class="eject_list_name ">排序:</div>
						<div class="content_info">
						<input type="text" value="<?php if(!empty($activity)){ echo $activity[0]['showorder'];} ?>" name="title">
						</div>
					</div>
				</div>
				<div class="eject_content_list">
					<div class="eject_list_row">	
						<div class="content_info">
						  <input  style="width: 50px" class="btn btn-palegreen" type="submit" value="保存">
						</div>
					</div>
				</div>
			</div>
			</form>
		</div>
	</div>

		<!-- 活动城市 -->
		<div class="tab-pane" id="home1">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm1">
						<div class="form-group has-feedback">
							<div style="float:left;margin-left:20px;padding:5px 10px 5px 10px">
							 <a class="btn btn-info btn-xs" id="add_activity" style="padding:5px 10px 5px 10px">添加</a>
							</div>	
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px;">活动城市：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="cityname" id="act_startcity" placeholder="活动城市-模糊搜索">
						       <input type="hidden" name="act_startcityid" id="act_startcityid">
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
		<!-- 活动分类 -->
		<div class="tab-pane " id="home2">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm2">
						<div class="form-group has-feedback">
							<div style="float:left;margin-left:20px;padding:5px 10px 5px 10px">
							 <a class="btn btn-info btn-xs" id="add_act_tab" style="padding:5px 10px 5px 10px">添加</a>
							</div>
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px;">活动分类：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="name" placeholder="活动名称-模糊搜索">
							</div>	
							<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
							<div class="col-lg-4" style="width: 5%;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch2">
							</div>
						</div>
					</form>
					<div id="list2"></div>
				</div>
			</div>
		</div>
		<!-- 活动线路-->
		<div class="tab-pane " id="home3">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm3">
						<div class="form-group has-feedback">
							<div style="float:left;margin-left:20px;padding:5px 10px 5px 10px">
							 <a class="btn btn-info btn-xs" id="add_act_line" style="padding:5px 10px 5px 10px">添加</a>
							</div>
							<label class="col-lg-4 control-label"  style="width:85px;padding-right:0px;margin-top:6px;">活动分类：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="name" placeholder="活动分类-模糊搜索">
							</div>	
							<label class="col-lg-4 control-label"  style="width:85px;padding-right:0px;margin-top:6px;">活动线路：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="act_line" placeholder="活动线路-模糊搜索">
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
<!-- 添加活动城市 -->
<div style="display: none;" class="bootbox modal fade in" id="add_activity_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close">×</button>
				<h4 class="modal-title">添加活动城市</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="add_activity_form" method="post" action="#" onsubmit="return CheckActCity();">
						<div style="height: 400px; overflow-y: auto;">
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动名称:</label>
								<div class="col-sm-10 col_ts">
									<?php if(!empty($activity[0]['name'])){ echo $activity[0]['name'];} ?>
									<input type="hidden" class="form-control" name='act_id' value="<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>">
										<input type="hidden"  name='city_id' value="">
								</div>
							</div>
							<div class="form-group">
							    <label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动城市:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control"  name="startplace"  placeholder="活动城市" value="" id="d_startcity"/>
            					 	<input type="hidden" name="startcityId" id="startcityId" value="" />
            						<div id="startcityStr" style="line-height:45px;"></div>
								</div>
							</div>
							<div class="form-group">
							    <label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">轮播图片:</label>
								<div class="col-sm-10 col_ts">
									<span class="btn btn-info btn-xs" style="padding:5px;" onclick="change_avatar(this,1);">上传图片</span>
									<div class="up_img">
										<ul>
										<!-- <li>
											   <div class="img_idv">
											    	<div class="float_img">×</div>
											   		<div><img src="/file/upload/20151118/144781026019354.jpg" style="max-width:120px;"></div>
											   </div>
											</li> -->	
										</ul>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">是否显示:</label>
								<div class="col-sm-10 col_ts">
									<input type="radio" name="isopen" value="1" checked="checked" style="position:static;opacity:1">是
									<input type="radio" name="isopen" value="0" style="position:static;opacity:1">否
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
<!-- 添加活动分类 -->
<div style="display: none;" class="bootbox modal fade in" id="act_tab_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close">×</button>
				<h4 class="modal-title">添加活动分类</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="AddActTabForm" method="post" action="#" onsubmit="return CheckActTab();">
						<div style="height: 400px; overflow-y: auto;">
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动名称:</label>
								<div class="col-sm-10 col_ts">
									<?php if(!empty($activity[0]['name'])){ echo $activity[0]['name'];} ?>
									<input type="hidden" class="form-control" name='act_id' value="<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>">
									<input type="hidden"  name='act_tab_id' value="">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动城市:</label>
								<div class="col-sm-10 col_ts" id="act_citylist">
								   <select name="sel_startcity" id="sel_startcity">
								   
								   </select>
								</div>
							</div>
						<!-- <div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">线路名称:</label>
								<div class="col-sm-10 col_ts" id="act_line">
								   	<input class="form-control" id="ChoiceLine" name="linename" readonly="readonly" type="text">
									<input type="hidden" name="line_id" />
								</div>
							</div> -->	
							<div class="form-group">
							    <label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">名称:</label>
								<div class="col-sm-10 col_ts">
									<input type="text" class="form-control"  name="name" placeholder="名称" value="" id="name"/>

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
<!-- 添加活动线路 -->
<div style="display: none;" class="bootbox modal fade in" id="act_line_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close">×</button>
				<h4 class="modal-title">添加活动线路</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="AddActLineForm" method="post" action="#" onsubmit="return CheckActLine();">
						<div style="height: 400px; overflow-y: auto;">
							<input type="hidden" class="form-control" name='act_id' value="<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>">
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动城市:</label>
								<div class="col-sm-10 col_ts">
                          				<select name="sel_act_city" id="sel_act_city" onchange="select_act_city(this)">
                          				 <option>请选择</option>
                          				</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">活动分类:</label>
								<div class="col-sm-10 col_ts">
								        <select name="sel_act_tab" id="sel_act_tab">
								         <option>请选择</option>
								        </select>
								</div>
							</div>
						  <div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">线路名称:</label>
								<div class="col-sm-10 col_ts" id="act_line">
								   	<input class="form-control" id="ChoiceLine" name="linename" readonly="readonly" type="text">
									<input type="hidden" name="line_id" />
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
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<!-- 城市控件 -->
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<!-- 时间控件 -->
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<!-- 美图秀秀 -->
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<?php echo $this->load->view('admin/a/choice_data/choice_line.php');  ?>

<script type="text/javascript">


jQuery(document).ready(function(){
	// 第一个列表 活动信息===============================================================
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		//page0.load({"status":"0"});
	});
	
	// 第二个列表 活动城市===============================================================
	jQuery("#btnSearch1").click(function(){
		page0.load({"actid":"<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/activity/act_cityData",form : '#listForm1',// 绑定一个查询表单的ID
				columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'name',title : '活动名称',align : 'center', width : '10%'},
					{field : 'cityname',title : '城市',align : 'center', width : '10%'},
				    {field : 'addtime',title : '添加时间',align : 'center', width : '15%'},
				    {field : 'showorder',title : '排序',align : 'center', width : '15%'},
					{field : 'addtime',title : '是否显示',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							if(rowData.isopen==1){
								  return '是';
							   }else if(rowData.isopen==0){
									return '否';
								}else{
									return '是';
								}
						}
					},
					{field : '',title : '操作',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							return '<a onclick="edit_act('+rowData.cityid+')"  href="###" >编辑</a>';
						}
					},

				]
	});
	
	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery('#tab1').addClass('active');
		page0.load({"actid":"<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>"});
	});
	
	//第三个列表 活动分类===============================================================
	jQuery("#btnSearch2").click(function(){
		page1.load({"actid":"<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>"});
	});
	var data = '<?php echo $pageData1; ?>';
	page1=new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/activity/act_tabData",form : '#listForm2',// 绑定一个查询表单的ID
				columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},	
					{field : 'actname',title : '活动名称',align : 'center', width : '10%'},
					{field : 'cityname',title : '城市',align : 'center', width : '10%'},
					{field : 'name',title : '活动分类',align : 'center', width : '10%'},
				 /*    {field : 'addtime',title : '添加时间',align : 'center', width : '15%'}, */
				    {field : 'showorder',title : '排序',align : 'center', width : '15%'},
					{field : 'addtime',title : '是否显示',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							if(rowData.isopen==1){
								  return '是';
							   }else if(rowData.isopen==0){
									return '否';
								}else{
									return '是';
								}
						}
					},
					{field : '',title : '操作',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							return '<a onclick="edit_actTab('+rowData.tabid+','+rowData.actid+')"  href="###" >编辑</a>';
						}
					},

				]
	});
	
	jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery('#tab2').addClass('active');
		page1.load({"actid":"<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>"});
	});

	//第三个列表 活动线路===============================================================
		jQuery("#btnSearch3").click(function(){
		page2.load({"actid":"<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>"});
	});
	var data = '';
	page2=new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/activity/act_line",form : '#listForm3',// 绑定一个查询表单的ID
				columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},	
					{field : 'cityname',title : '城市',align : 'center', width : '10%'},
					{field : 'tabname',title : '活动分类',align : 'center', width : '10%'},
					{field : 'linename',title : '线路名称',align : 'center', width : '25%',
						formatter : function(value,rowData, rowIndex) {
							return '<a href="/line/line_detail_'+rowData.lineid+'.html" target="_blank">'+rowData.linename+'</a>';
						}
					},
					{field : 'lstatus',title : '线路状态',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							if(rowData.lstatus==2){
								return '上线';
							}else{
								return '下线';
							}	
						}
					},
				    {field : 'showorder',title : '排序',align : 'center', width : '8%'},
					 {field : '',title : '操作',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							return '<a onclick="del_lineTab('+rowData.id+')"  href="###" >删除</a>';
						}
					},

				]
	});
	jQuery('#tab3').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home3').addClass('active');
		jQuery('#tab3').addClass('active');
		page2.load({"actid":"<?php if(!empty($activity[0]['id'])){ echo $activity[0]['id'];} ?>"});
	});
});
//===================================活动基本信息=====================================================
	  // 时间控件
	$('#a_starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
	$('#a_endtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:true, //是否显示小时
		format:'Y-m-d H:i', //选中显示的日期格式
		formatDate:'Y-m-d H:i',
	});
	function CheckActivity(){
		  var name=$('#add_actlist_form').find('input[name="name"]').val();
		   if(name==''){
			  alert('活动名称不能为空!');
			  return false;
		   }
		   var starttime=$('#add_actlist_form').find('input[name="starttime"]').val();
		   if(starttime==''){
			   alert('开始时间不能为空!');
			   return false;
			}
		   var endtime=$('#add_actlist_form').find('input[name="endtime"]').val();
		   if(endtime==''){
			   alert('结束时间不能为空!');
			   return false;
			}
		   jQuery.ajax({ type : "POST",data : jQuery('#add_actlist_form').serialize(),url : "<?php echo base_url()?>admin/a/activity/add_activity", 
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
//===================================================活动城市script======================================================================
	//添加活动的弹框
	$('#add_activity').click(function(){
		 $('#add_activity_modal').find('#d_startcity').show(); 
		 $('.up_img').find('ul').html('');
		 $('#add_activity_modal').find('input[name="startcityId"]').val('');
		 $('#add_activity_modal').find('input[name="city_id"]').val('');
		 $('#add_activity_modal').find('#startcityStr').html(''); 
		 $('#add_activity_modal').find('textarea[name="showorder"]').val(''); 	
		 $("#add_activity_modal").show();
		 $(".modal-backdrop").show(); 
	});
	//出发城市获取
		createChoicePluginPY({
			data:{0:chioceStartCityJson['domestic']},
			nameId:'d_startcity',
			valId:'startcityId',
			isHot:true,
			hotName:'热门'
		});
		createChoicePluginPY({
			data:{0:chioceStartCityJson['domestic']},
			nameId:'act_startcity',
			valId:'act_startcityid',
			isHot:true,
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
	//添加活动城市
	function CheckActCity(){
		   jQuery.ajax({ type : "POST",data : jQuery('#add_activity_form').serialize(),url : "<?php echo base_url()?>admin/a/activity/add_ActCity", 
				success : function(response) {
		 		 var response=eval("("+response+")");
						 if(response.status==1){  
                              alert(response.msg);
                              $('.bootbox-close-button').click();
                              $('#tab1').click(); 
						 }else{
							 alert(response.msg);
						 }	    
					}
			});
		return false;
	}
	//编辑活动分类
	function edit_act(obj){ 
		$('input[name="city_id"]').val(obj);
		 $('.up_img').find('ul').html('');
		$.post("<?php echo base_url()?>admin/a/activity/ActCity_detail", {cityid:obj} , function(re) {
		     var re=eval("("+re+")");
			 $('#add_activity_modal').find('input[name="startplace"]').val(re.city[0].cityname); 
			 $('#add_activity_modal').find('input[name="startcityId"]').val(re.city[0].startcityid);
			 $('#add_activity_modal').find('textarea[name="showorder"]').val(re.city[0].showorder);
		 	 $('input[name="isopen"]').each(function(v){
			 	  if($(this).val()==re.city[0].isopen){
			 		   $(this).attr("checked",true);
				   }else{
					   $(this).attr("checked",false);
				   }
			}) 
	
			if(re.city[0].pic!=null){
				var obj2 = re.city[0].pic.split(";"); 
				 $(obj2).each(function(n,val){
					  var html=' <li> <div class="img_div"><div class="float_img" onclick="float_img(this)" >×</div>';
					  html=html+'<div><img src="'+val+'" style="max-width:120px;"></div>';
					  html=html+'<input name="pic[]" type="hidden" value="'+val+'"></div></li>';
			          $('.up_img').find('ul').append(html);	
				  })	
			}  
		})
		
		$("#add_activity_modal").show();
		$(".modal-backdrop").show(); 
    }
    //删除图片
     function float_img(obj){
   
        $(obj).parent().parent().remove();
     }

    	/************************************美图秀秀**************************************************/
	function change_avatar(obj,type){

			$('.avatar_box').show();
			var size='';
			if(type==0){
				size='500x300';
			 }else{
				size='640x340';	
			}
		   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
		   xiuxiu.setLaunchVars("cropPresets", size);
			xiuxiu.embedSWF("altContent",5,'100%','100%');
		       //修改为您自己的图片上传接口
			xiuxiu.setUploadURL("<?php echo site_url('admin/upload/uploadImgFileXiu'); ?>");
		        xiuxiu.setUploadType(2);
		        xiuxiu.setUploadDataFieldName("uploadFile");
			xiuxiu.onInit = function ()
			{
				//默认图片
				xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
			}
			xiuxiu.onUploadResponse = function (data)
			{
				data = eval('('+data+')');	
			    if (data.code == 2000){ 
		          if(type==1){ //行程上传图片
					  var html=' <li> <div class="img_div"><div class="float_img" onclick="float_img(this)">×</div>';
					  html=html+'<div><img src="'+data.msg+'" style="max-width:120px;"></div>';
					  html=html+'<input name="pic[]" type="hidden" value="'+data.msg+'"></div></li>';
			          $('.up_img').find('ul').append(html);					 
					}
					close_xiuxiu();
					
			    } else {
				    alert(data.msg);
			    }
			    
			}
		  
		    
			 $("#img_upload").show();
			 $(".close_xiu").show();
	}
	$(document).mouseup(function(e) {
	   var _con = $('#img_upload'); // 设置目标区域
	   if (!_con.is(e.target) && _con.has(e.target).length === 0) {
	       $("#img_upload").hide()
	       $('.avatar_box').hide();
	       $(".close_xiu").hide();
	   }
	})
	function close_xiuxiu(){
		$("#img_upload").hide()
	   $('.avatar_box').hide();	
		$(".close_xiu").hide();
	}
  //===================================================活动分类script======================================================================
  //添加活动的弹框
	$('#add_act_tab').click(function(){
		$('#sel_startcity').html('');
	    var act_id=$('input[name="act_id"]').val();
		$.post("<?php echo base_url()?>admin/a/activity/get_actTabCity", {actid:act_id} , function(re) {
			 var re=eval("("+re+")");
			 if(re.city!=''){
				 var html='<option value="">请选择</option>';
				 $.each(re.city,function(n,v) {
                        //  alert(v.cityname);
                       html=html+'<option value="'+v.id+'">'+v.cityname+'</option>';
				})
				$('#sel_startcity').append(html);
			  }
			
	    })	
		$("#act_tab_modal").show();
		$(".modal-backdrop").show(); 
	})
  //添加活动分类
  function  CheckActTab(){
		   jQuery.ajax({ type : "POST",data : jQuery('#AddActTabForm').serialize(),url : "<?php echo base_url()?>admin/a/activity/add_ActTab", 
				success : function(response) {
		 		 var response=eval("("+response+")");
						 if(response.status==1){  
                             alert(response.msg);
                            /*   $('.bootbox-close-button').click();*/
                             $('#tab2').click();
                             $('.bootbox-close-button').click();  
						 }else{
							 alert(response.msg);
						 }	   
					} 
			});
		  return false;
   }
   //编辑活动分类	   
   function  edit_actTab(obj,actid){
	   $('#AddActTabForm').find('#sel_startcity').html('');
	   $.post("<?php echo base_url()?>admin/a/activity/ActTab_detail", {tabid:obj,actid:actid} , function(data) {
		   var data=eval("("+data+")");
		   $('#AddActTabForm').find('input[name="name"]').val(data.tab.name);
		   $('#AddActTabForm').find('input[name="description"]').val(data.tab.description);
		   $('#AddActTabForm').find('input[name="showorder"]').val(data.tab.showorder);
		   var html='';
			 $.each(data.city,function(n,v) {
				if(data.tab.aac_id==v.id){
					var str='selected="selected"';
				}else{
					var str='';
				}
			//	alert(str);
                html=html+'<option value="'+v.id+'" '+str+'>'+v.cityname+'</option>';
			})
		   $('#AddActTabForm').find('#sel_startcity').append(html);	
	   }) 
	   $('input[name="act_tab_id"]').val(obj);
	   $("#act_tab_modal").show();
	   $(".modal-backdrop").show(); 
   }

	//筛选线路
	$("#ChoiceLine").click(function(){
		//$("#choiceLineBox").show();
		$("#searchLineData").find("select[name='start_city']").remove();
		$("#searchLineData").find("select[name='start_province']").val(0);
		createDataHtml();
	})
	//确认选择线路
	$(".submit_choice").click(function(){
		var actObj = $("#choiceLineBox").find(".choice_content").children(".cl_active");
		var id = actObj.attr("data-val");
		var name = actObj.attr("data-name");
		$("#act_line").find("input[name='line_id']").val(id);
		$("#act_line").find("input[name='linename']").val(name);
		$("#choiceLineBox").hide();
	})
//搜索
$('#search_condition').submit(function(){
	$('input[name="page_new"]').val(1);
	ajaxGetData(columns ,inputId);
	return false;
})
startCitySelect('choiceStartplace' ,140);
startCitySelect('search_start' ,140);
//=========================================================活动线路script==================================================
	//添加活动线路的弹框
	$('#add_act_line').click(function(){
		//alert(123);
		$('#AddActLineForm').find('input[name="linename"]').val('');
		$('#AddActLineForm').find('input[name="line_id"]').val('');
		$('#sel_act_tab').html('<option>请选择</option>');
		/*活动城市*/
		$('#sel_act_city').html('');
	    var act_id=$('#AddActLineForm').find('input[name="act_id"]').val();
		$.post("<?php echo base_url()?>admin/a/activity/get_actTabCity", {actid:act_id} , function(re) {
			 var re=eval("("+re+")");
			 if(re.city!=''){
				 var html='<option value="">请选择</option>';
				 $.each(re.city,function(n,v) {
                        //  alert(v.cityname);
                       html=html+'<option value="'+v.id+'">'+v.cityname+'</option>';
				})
				$('#sel_act_city').append(html);
			  }
			
	    })
	    	
		$("#act_line_modal").show();
		$(".modal-backdrop").show(); 
	})
	//城市联动活动分类
	function select_act_city(obj){
		var startcityid=$(obj).val();
		$.post("<?php echo base_url()?>admin/a/activity/get_actTabName", {startcityid:startcityid} , function(re) {
			 var re=eval("("+re+")");
			 $('#sel_act_tab').html('');
			 if(re.tabname!=''){
				 var html='<option value="">请选择</option>';
				 $.each(re.tabname,function(n,v) {
                       html=html+'<option value="'+v.id+'">'+v.name+'</option>';
				})
				$('#sel_act_tab').append(html);
			  }
		})
	}
	//添加线路
	function CheckActLine(){
		   jQuery.ajax({ type : "POST",data : jQuery('#AddActLineForm').serialize(),url : "<?php echo base_url()?>admin/a/activity/add_ActLinetab", 
				success : function(response) {
		 		 var response=eval("("+response+")");
						 if(response.status==1){  
                            alert(response.msg); 
                            $('#tab3').click(); 
                            $('.bootbox-close-button').click(); 
						 }else{
							 alert(response.msg);
						 }	   
					} 
			});
		  return false;    
    }
    //删除线路
   function del_lineTab(obj){
		 if (!confirm('删除该活动的线路')) {
	            window.event.returnValue = false;
	        }else{
	        	$.post("<?php echo base_url()?>admin/a/activity/del_lineTabid", {tablineid:obj} , function(response) {
	        		 var response=eval("("+response+")");
					 if(response.status==1){  
                        alert(response.msg); 
                        $('#tab3').click(); 
                        $('.bootbox-close-button').click(); 
					 }else{
						 alert(response.msg);
					 }	
		        }); 
		    }
   }

	function checkorder(){
		var tyle='<?php if(!empty($tyle)){ echo $tyle;} ?>';
		
		if(tyle !=''){
			if(tyle==1){ 
				$('#tab1').click();
			}else if(tyle==2){ 
				$('#tab2').click();
			}else if(tyle==3){ 
				$('#tab3').click();
			}else{
				$('#tab0').click();
			}
		 }

	}

	jQuery(document).ready(function(){	
		　checkorder();　 
	});  
	    
</script>
