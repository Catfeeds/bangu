<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />

<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb"  style="width:100%;margin-left:0px;">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">直播会员 </li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">申请中 </a></li>
		<li class="" id="tab1" name="tabs"><a href="#home1">已通过 </a></li>
		<li class="" id="tab2" name="tabs"><a href="#home2">已拒绝 </a></li>
		<li class="" id="tab3" name="tabs" style="display:none;" ><a href="#home3">普通用户 </a></li>		
	</ul>

	<div class="tab-content tabs-flat">
		<!-- 申请中 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
			
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">姓名：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="realname">
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">主播名：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="name">
							</div>	
						    <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">手机号：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="mobile">
							</div>

							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">地区：</label>
							<div style="display:inline-block;padding-left:2px;" id="search-area">
							</div>
<!--
						    <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px">类型：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <select  class="search_input user_name_b1" name="type" >
							   <option value="-1">请选择...</option>
												<option value="0">普通用户</option>
												<option value="1">达人</option>
												<option value="2">领队</option>
												<option value="3">管家</option>
												</select>	
							</div>								
-->
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
		<!--已通过-->
		<div class="tab-pane " id="home1">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm1">
						<div class="form-group has-feedback">
			
						        <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">姓名：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="realname" placeholder="姓名-模糊搜索">
							</div>
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">主播名：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						      	 <input class="form-control user_name_b1" type="text" name="name" placeholder="主播名-模糊搜索">
							</div>
						    	<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">手机号：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="mobile" placeholder="手机号">
							</div>
				
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">地区：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;" id="search-area1">
							</div>
							<!--
						    <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">类型：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <select  class="form-control user_name_b1" name="type" >
												<option value="1">达人</option>
												<option value="2">领队</option>
												<option value="3">管家</option>
												</select>	
							</div>								
							-->
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
		<!--已拒绝-->
		<div class="tab-pane " id="home2">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm2">
						<div class="form-group has-feedback">
		
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">姓名：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="realname" placeholder="姓名-模糊搜索">
							</div>
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">主播名：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						      	 <input class="form-control user_name_b1" type="text" name="name" placeholder="主播名-模糊搜索">
							</div>
						    <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">手机号：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="mobile" placeholder="手机号">
							</div>
			
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">地区：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;" id="search-area2">
							</div>
							<!--
						    <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">类型：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <select  class="form-control user_name_b1" name="type" >
												<option value="1">达人</option>
												<option value="2">领队</option>
												<option value="3">管家</option>
												</select>	
							</div>								
							-->
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
		
		<!--普通用户-->
		<div class="tab-pane " id="home3">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm3">
						<div class="form-group has-feedback">
			
						        <label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">姓名：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="realname" placeholder="姓名-模糊搜索">
							</div>
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">主播名：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						      	 <input class="form-control user_name_b1" type="text" name="name" placeholder="主播名-模糊搜索">
							</div>
						    	<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">手机号：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="mobile" placeholder="手机号">
							</div>
				
							<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;margin-top:6px">地区：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;" id="search-area1">
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
<div id="expertDetial"></div>
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<!-- 管家详情 -->
<?php  //echo $this->load->view('admin/a/expert/expert_line.php');  ?>
<script src="<?php echo base_url("assets/js/jquery.dataDetail.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>

<script type="text/javascript">
jQuery(document).ready(function(){
	// 第一个列表 申请中===============================================================
	var page0=null;
	jQuery("#btnSearch0").click(function(){	
		page0.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/live/anchor/indexData",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [
						{title : '编号',width : '5%',align : 'center',
							formatter : function(value,rowData, rowIndex) {
								return rowIndex+1;
							}
						},
						{field : 'realname',title : '姓名',align : 'center', width : '10%'},
						/*{field : 'name',title : '主播名',align : 'center', width : '15%'},*/
						{field : 'mobile',title : '手机号码',align : 'center', width : '15%'},
						/*{field : 'idcard',title : '身份证照',align : 'center', width : '10%'},*/
						/*{title : '所在地',align : 'center', width : '10%',
							formatter:function(value,rowData,rowIndex){
								return rowData.provincename+rowData.cityname;
							}
						},*/
						{title : '类型',align : 'center', width : '10%',
							formatter:function(value,rowData,rowIndex){
								if(rowData.type==1){
									return '达人';									
								}else if(rowData.type==2){
									return '领队';									
								}else if(rowData.type==3){
									return '管家';									
								}else{
									return '普通用户';										
								}

							}
						},						
						{field : 'applytime',title : '申请时间',align : 'center', width : '10%'},
						{field : '',title : '操作',align : 'center', width : '15%',
							formatter : function(value,rowData, rowIndex) {
								var str='';
									str=str+' <a href="##" onclick="detail('+rowData.anchor_id+',1)" >通过</a> ';
									str=str+'<a href="##" onclick="detail('+rowData.anchor_id+',2)" >拒绝</a> ';
								return str;
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
	// 第二个列表 已通过===============================================================
	var page1 = null;
	function initTab1(){
	    jQuery("#btnSearch1").click(function(){
				page1.load({"status":"2"});
	   });
	var data = '<?php echo $pageData; ?>';
	page1 = new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/live/anchor/indexData",form : '#listForm1',// 绑定一个查询表单的ID
			columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '姓名',align : 'center', width : '10%'},
					/*{field : 'name',title : '主播名',align : 'center', width : '15%'},*/
					{field : 'mobile',title : '手机号码',align : 'center', width : '15%'},
					/*{field : 'idcard',title : '身份证照',align : 'center', width : '10%'},*/
					/*{title : '所在地',align : 'center', width : '10%',
						formatter:function(value,rowData,rowIndex){
							return rowData.provincename+rowData.cityname;
						}
					},*/
					{title : '类型',align : 'center', width : '10%',
						formatter:function(value,rowData,rowIndex){
							if(rowData.type==1){
								return '达人';									
							}else if(rowData.type==2){
								return '领队';									
							}else if(rowData.type==3){
								return '管家';									
							}else{
								return '普通用户';										
							}

						}
					},						
					{field : 'modtime',title : '通过时间',align : 'center', width : '10%'},
					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							var str='';
								str=str+' <a href="##" onclick="detail2('+rowData.anchor_id+',1)" >查看</a> ';
							return str;
						} 
					}						
					/*{field : 'room_id',title : '房间号',align : 'center', width : '10%'},*/
			]
		});
	}
 	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery('#tab1').addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"2"});	
	}); 
    	// 第三个列表 已已拒绝===============================================================
	var page2 = null;
	function initTab2(){
	    jQuery("#btnSearch2").click(function(){
			page2.load({"status":"3"});
	   });
	var data = '<?php echo $pageData; ?>';
	page2 = new jQuery.paging({renderTo:'#list2',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/live/anchor/indexData",form : '#listForm2',// 绑定一个查询表单的ID
			columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '姓名',align : 'center', width : '10%'},
					//{field : 'name',title : '主播名',align : 'center', width : '15%'},
					{field : 'mobile',title : '手机号码',align : 'center', width : '15%'},
					// {field : 'idcard',title : '身份证照',align : 'center', width : '10%'},
					/*{title : '所在地',align : 'center', width : '10%',
						formatter:function(value,rowData,rowIndex){
							return rowData.provincename+rowData.cityname;
						}
					},*/
					{title : '类型',align : 'center', width : '10%',
						formatter:function(value,rowData,rowIndex){
							if(rowData.type==1){
								return '达人';									
							}else if(rowData.type==2){
								return '领队';									
							}else if(rowData.type==3){
								return '管家';									
							}else{
								return '普通用户';										
							}

						}
					},						
					{field : 'modtime',title : '拒绝时间',align : 'center', width : '10%'},
					{field : 'refuse_reason',title : '拒绝理由',align : 'center', width : '10%'},
					{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							var str='';
								str=str+' <a href="##" onclick="detail2('+rowData.anchor_id+',1)" >查看</a> ';
							return str;
						} 
					}					
			]
		});
	}
 	jQuery('#tab2').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home2').addClass('active');
		jQuery('#tab2').addClass('active');
		if(null==page2){
			initTab2();
		}
		page2.load({"status":"3"});	
	}); 
	
	// 第四个列表 普通用户===============================================================
	var page3 = null;
	function initTab3(){
	    jQuery("#btnSearch3").click(function(){
				page3.load({"status":"0"});
	   });
	var data = '<?php echo $pageData; ?>';
	page3 = new jQuery.paging({renderTo:'#list3',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/live/anchor/indexData",form : '#listForm3',// 绑定一个查询表单的ID
			columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'realname',title : '姓名',align : 'center', width : '10%'},
					//{field : 'name',title : '主播名',align : 'center', width : '15%'},
					{field : 'mobile',title : '手机号码',align : 'center', width : '15%'},
					/*{field : 'idcard',title : '身份证照',align : 'center', width : '10%'},*/
					/*{title : '所在地',align : 'center', width : '10%',
						formatter:function(value,rowData,rowIndex){
							return rowData.provincename+rowData.cityname;
						}
					},*/
					{title : '类型',align : 'center', width : '10%',
						formatter:function(value,rowData,rowIndex){
							if(rowData.type==1){
								return '达人';									
							}else if(rowData.type==2){
								return '领队';									
							}else if(rowData.type==3){
								return '管家';									
							}else{
								return '普通用户';										
							}

						}
					},						
					{field : 'modtime',title : '通过时间',align : 'center', width : '10%'}
					/*{field : 'room_id',title : '房间号',align : 'center', width : '10%'},*/
			]
		});
	}
 	jQuery('#tab3').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home3').addClass('active');
		jQuery('#tab3').addClass('active');
		if(null==page3){
			initTab3();
		}
		page3.load({"status":"0"});	
	}); 	
	

});
//------------------直播详情页-------------------------
function detail(id ,type) {
//	var type = type;
	if (type == 0) {
		var butDatas = {};
	} else if (type == 1) {
		var butDatas = {'through_anchor':'通过'};
	} else if (type == 2) {
		var butDatas = {'refuse_anchor':'拒绝'};
	}
	$.ajax({
	//	url:'/admin/a/experts/expert_list/getExpertDetails',
		url:'/admin/a/live/anchor/getLiveAnchor',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('数据查询错误');
			} else {
				/*if (data.sex == 0) {
					var sex = '女';
				} else if (data.sex == 1) {
					var sex = '男';
				} else {
					var sex = '保密'
				}
				var live_anchor = data.live_anchor;
				if (data.live_anchor) {
					live_anchor = '<img src="'+data.live_anchor+'" width="100px"  height="100px">';
				}			
				var photo = data.photo;
				if (data.photo) {
					photo = '<img src="'+data.photo+'" width="100px"  height="100px">';
				}*/				
				var idcard = data.idcard;
				if (data.idcard) {
					idcard = '<img src="'+data.idcard+'" width="100px"  height="100px">';
				}
				var idcardconpic = data.idcardconpic;
				if (data.idcardconpic) {
					idcardconpic = '<img src="'+data.idcardconpic+'" width="100px"  height="100px">';
				}
				var holdidcardpic = data.holdidcardpic;
				if (data.idcardconpic) {
					holdidcardpic = '<img src="'+data.holdidcardpic+'" width="100px"  height="100px">';
				}
				var countryname = typeof data.countryname == 'object' ? '' : data.countryname;
				var provincename = typeof data.provincename == 'object' ? '' : data.provincename;
				var cityname = typeof data.cityname == 'object' ? '' : data.cityname;
				var address = countryname+provincename+cityname;
				
				var expertType = '主播申请人' ;
				var jsonData = [{	title:'基本信息',type:'list',data:[
							{title:'姓名',val:data.realname},
					            	{title:'手机号',val:data.mobile},
					            	/*{title:'主播名',val:data.name},
					            	{title:'性别',val:sex},*/
							{title:'身份证号',val:data.idcardnum},		
							/*{title:'个人签名',val:data.comment},
							{title:'背景照片',val:live_anchor},*/
					            	/*{title:'头像照片',val:photo},*/
					            	{title:'身份证正面照片',val:idcard},
					            	{title:'身份证反面照片',val:idcardconpic},
					            	{title:'手持身份证照片',val:holdidcardpic},									
				            	]},
				            	
				            ];
				if (type == 2) {
					jsonData.push({title:'拒绝原因',type:'list',data:[
					              		{'title':'拒绝原因',val:{name:'refuse_reasion'},type:'textarea',isComplete:true}
					              	]
	              				});
				}
				$("#expertDetial").dataDetail({
					title:expertType+'：'+data.realname,
					jsonData:jsonData,
					butDatas:butDatas,
					isSimple:false,
					id:data.anchor_id,
					butClick:buttonClick
				});
			}
		}
	});
}

//------------------直播详情页-------------------------
function detail2(id ,type) {
//	var type = type;

		var butDatas = {};

	$.ajax({
	//	url:'/admin/a/experts/expert_list/getExpertDetails',
		url:'/admin/a/live/anchor/getLiveAnchor',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('数据查询错误');
			} else {
				/*if (data.sex == 0) {
					var sex = '女';
				} else if (data.sex == 1) {
					var sex = '男';
				} else {
					var sex = '保密'
				}
				var live_anchor = data.live_anchor;
				if (data.live_anchor) {
					live_anchor = '<img src="'+data.live_anchor+'" width="100px"  height="100px">';
				}			
				var photo = data.photo;
				if (data.photo) {
					photo = '<img src="'+data.photo+'" width="100px"  height="100px">';
				}*/				
				var idcard = data.idcard;
				if (data.idcard) {
					idcard = '<img src="'+data.idcard+'" width="100px"  height="100px">';
				}
				var idcardconpic = data.idcardconpic;
				if (data.idcardconpic) {
					idcardconpic = '<img src="'+data.idcardconpic+'" width="100px"  height="100px">';
				}
				var holdidcardpic = data.holdidcardpic;
				if (data.idcardconpic) {
					holdidcardpic = '<img src="'+data.holdidcardpic+'" width="100px"  height="100px">';
				}
				var countryname = typeof data.countryname == 'object' ? '' : data.countryname;
				var provincename = typeof data.provincename == 'object' ? '' : data.provincename;
				var cityname = typeof data.cityname == 'object' ? '' : data.cityname;
				var address = countryname+provincename+cityname;
				
				var expertType = '用户信息' ;
				var jsonData = [{	title:'基本信息',type:'list',data:[
							{title:'姓名',val:data.realname},
					            	{title:'手机号',val:data.mobile},
					            	/*{title:'主播名',val:data.name},
					            	{title:'性别',val:sex},*/
							{title:'身份证号',val:data.idcardnum},		
							/*{title:'个人签名',val:data.comment},
					            	{title:'背景照片',val:live_anchor},
					            	{title:'头像照片',val:photo},*/
					            	{title:'身份证正面照片',val:idcard},
					            	{title:'身份证反面照片',val:idcardconpic},
					            	{title:'手持身份证照片',val:holdidcardpic},									
				            	]},
				            	
				            ];

				$("#expertDetial").dataDetail({
					title:expertType+'：'+data.realname,
					jsonData:jsonData,
					butDatas:butDatas,
					isSimple:false,
					id:data.anchor_id,
					butClick:buttonClick
				});
			}
		}
	});
}


function buttonClick(){

	//通过主播申请
	var ts = true;
	$(".through_anchor").click(function(){
		var id = $(this).attr('data-val');
		var type=1;
		if (ts == false) {
			return false;
		} else {
			ts = false;
		}
		$.post("/admin/a/live/anchor/through_anchor",{'id':id,type:type},function(data){
			ts = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				$('#btnSearch0').click();
			} else {
				alert(data.msg);
				$('#btnSearch0').click();
			}
			$(".detail-close").click();
		});
	})
	//拒绝主播申请
	var rs = true;
	$(".refuse_anchor").click(function(){
		if (rs == false) {
			return false;
		} else {
			rs = false;
		}
		var id = $(this).attr('data-val');
		var refuse_reasion = $("textarea[name='refuse_reasion']").val();
		if(!refuse_reasion){
			alert('请输入拒绝原因');
			rs = true;
			return false;
		}
		var type=2;
		$.post("/admin/a/live/anchor/through_anchor",{'id':id,'type':type,'refuse_reasion':refuse_reasion},function(data){
			rs = true;
			var data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				$('#btnSearch0').click();
			} else {
				alert(data.msg);
				$('#btnSearch0').click();
			}
			$(".detail-close").click();
		});
	})
}


//地区联动
$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-area').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#search-area1').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#search-area2').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
	}
});

</script>



