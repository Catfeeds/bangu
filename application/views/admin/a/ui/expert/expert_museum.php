
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">管家申请拍照列表</li>
		</ul>
	</div>
	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">未使用 </a></li>
		<li class="tab-red" id="tab1" name="tabs"><a href="#home1">已使用</a></li>
	</ul>
	<div class="tab-content tabs-flat">
		<!-- 未结算 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">管家名称：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="realname">
							</div>	
							<div class="" style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch0">
							</div>
						</div>
					</form>
					<div id="list">
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane " id="home1">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm1">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">管家名称：</label>
							<div class="" style="display:inline-block;padding-left:2px;">
						       <input class="form-control user_name_b1" type="text" name="realname">
							</div>	
							<div class="" style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch1">
							</div>
						</div>
					</form>

					<div id="list1"></div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />


<script type="text/javascript">
jQuery(document).ready(function(){
	// 第一个列表 未使用===============================================================
	jQuery("#btnSearch0").click(function(){
		page0.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/expert/expertData",form : '#listForm0',// 绑定一个查询表单的ID
			columns : [
				{title : '管家编号',width : '5%',align : 'center',
					formatter : function(value,rowData, rowIndex) {
						return rowIndex+1;
					}
				},
				{field : 'realname',title : '管家姓名',align : 'center', width : '10%'},
				{field : 'mobile',title :'管家联系电话',width : '10%',align : 'center'},
				{field : 'email',title : '邮箱号',align : 'center', width : '10%'},
				{field : 'idcard',title : '身份证',align : 'center', width : '10%'},
				{field : 'qrcode',title : '二维码',align : 'center', width : '15%',
					 formatter : function(value,rowData, rowIndex) {
						return '<img style="width:30px;height:30px;" src="'+rowData.qrcode+'">';
					} 
				},
				{field : 'name',title : '相馆名字',align : 'center', width : '10%'},
				{field : 'linkman',title : '相馆联系人',align : 'center', width : '10%'},
				{field : 'linkmobile',title : '相馆联系电话',align : 'center', width : '10%'},
				{field : 'addtime',title : '添加时间',align : 'center', width : '10%'}
			]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page0.load({"status":"0"});
	});
	// 第二个列表 已使用===============================================================
	var page1 = null;
	function initTab1(){
	    jQuery("#btnSearch1").click(function(){
				page1.load({"status":"1"});
	   });
		page1 = new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/expert/expertData",form : '#listForm1',// 绑定一个查询表单的ID
			columns : [
						{title : '管家编号',width : '5%',align : 'center',
							formatter : function(value,rowData, rowIndex) {
								return rowIndex+1;
							}
						},
						{field : 'realname',title : '管家姓名',align : 'center', width : '10%'},
						{field : 'mobile',title :'管家联系电话',width : '10%',align : 'center'},
						{field : 'email',title : '邮箱号',align : 'center', width : '10%'},
						{field : 'idcard',title : '身份证',align : 'center', width : '10%'},
						{field : 'qrcode',title : '二维码',align : 'center', width : '15%',
							formatter : function(value,rowData, rowIndex) {
								return '<img style="width:30px;height:30px;" src="'+rowData.qrcode+'">';
							} 
						},
						{field : 'name',title : '相馆名字',align : 'center', width : '10%'},
						{field : 'linkman',title : '相馆联系人',align : 'center', width : '10%'},
						{field : 'linkmobile',title : '相馆联系电话',align : 'center', width : '10%'},
						{field : 'addtime',title : '添加时间',align : 'center', width : '10%'}
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
		page1.load({"status":"1"});	
	}); 

});
</script>