<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
.control-label{width:100px;}
.form-horizontal .form-group input{ width:70%;}
.form-horizontal .form-group textarea{    width:100%; height: 120px;}
</style>
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb"  style="width:100%;margin-left:0px;">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">订单保险列表 </li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">订单保险列表 </a></li>	
	</ul>

	<div class="tab-content tabs-flat">
		<!-- 管家列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
				
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">导出：</label>
							<div style="display:inline-block;padding-left:2px;">
							      <select name="if_insurance" id="if_insurance">
									<option value="">请选择</option>
									<option value="1">已导出</option>	
									<option value="0">未导出</option>					      
							      </select>
							</div>
						    <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">已购买：</label>
							<div style="display:inline-block;padding-left:2px;">
							      <select name="is_buy" id="is_buy">
									<option value="">请选择</option>
									<option value="1">已购买</option>	
									<option value="0">未购买</option>					      
							      </select>
							</div>

							 <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">线路名称：</label>
							<div style="display:inline-block;">
						       <input class="form-control user_name_b1" style="width:100%" type="text" name="line_name">
							</div>
							
						    <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">订单编号：</label>
							<div style="display:inline-block;">
						       <input class="form-control user_name_b1" style="width:100%" type="text" name="ordersn">
							</div>
							
	    					<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">出团日期：</label>
							<div style="display:inline-block;padding-right:0px; width:125px;float:left" >
						       <input class="form-control user_name_b1" type="text" name="starttime" id="starttime" value="<?php echo date("Y-m-d",strtotime("+1 day")); ?>" style="width:100%" placeholder="开始时间">
							</div>
						   <!-- <div class="col-lg-4" style="width:auto;padding-right:0px; width:110px;float:left" >
						       <input class="form-control user_name_b1"  type="text" name="endtime" id="endtime"  readonly="readonly"  style="width:100%" placeholder="结束时间">
							</div>-->
						
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
							     <input type="button" value="搜索" style="width:70px" class="btn btn-palegreen" id="btnSearch0">  
							</div>
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
							     <input type="button" value="导出"  class="btn" style="background-color:#2dc3e8;width:70px" id="derive">  
							</div>
						</div>
					</form>
					<div id="list"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="expertDetial"></div>
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />

<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
//-----------------------------------保险列表数据----------------------------------------------
jQuery(document).ready(function(){
	/*未结算 */
	var page=null;
	// 查询
	jQuery("#btnSearch0").click(function(){
		page.load({"status":"2"});
	});
	var data = '<?php echo $pageData; ?>';
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/insurance/insurance_order/indexData",form : '#listForm0',// 绑定一个查询表单的ID
		columns : [

			{field : 'ordersn',title : '订单编号',width : '80',align : 'center'},
			{field : 'productname',title : '线路名称',align : 'center',sortable : true,width : '120'},
			{field : 'usedate',title : '出团日期',align : 'center',sortable : true,width : '80'},
			{field : 'name',title : '姓名',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.name!=''){
						return rowData.name;					
					}else{
						return rowData.enname;
					}
				}
			},
			{field : 'sex',title : '性别',align : 'center', width : '80',
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.sex==0){
						return '女';					
					}else if(rowData.sex==1){
						return '男';
					}
				}
			},
			{field : 'birthday',title : '出生日期',align : 'center', width : '100'},
			{field : 'telephone',title : '手机号码',align : 'center', width : '100'},
			{field : 'certificate',title : '证件类型',align : 'center', width : '100'},	
			{field : 'certificate_no',title : '证件号码',align : 'center', width : '100'},
			{field : 'insurance_name',title : '保险名称',align : 'center', width : '100'},
			{field : 'is_down',title : '是否导出',align : 'center', width : '100',
				//isbuy_insurance
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.is_down==1){
						return '已导出';					
					}else {
						return '未导出';
					}
				}
			},
			{field : 'is_buy',title : '购买',align : 'center', width : '100',
				//isbuy_insurance
				formatter : function(value,rowData, rowIndex){	
					if(rowData.is_buy==1){
						return '已购买';					
					}else {
						return '未购买';
					}
				}
			}
			// {field : 'is_buy',title : '操作',align : 'center', width : '80',
			// 	//isbuy_insurance
			// 	formatter : function(value,rowData, rowIndex){	
			// 		if(rowData.is_buy==1){
			// 			return '';					
			// 		}else {
			// 			return '<a href="#" onclick="edit_people(rowData.id)">编辑</a>';
			// 		}
			// 	}
			// },
		]
	});
	
}); 
//-----------------------------------保险列表数据 end----------------------------------------------
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});

//导出订单保险信息
$("#derive").click(function(){ 
	
 	var if_insurance=$('#if_insurance').val();
	var line_name=$('input[name="line_name"]').val();
	var ordersn=$('input[name="ordersn"]').val();
	var starttime=$('input[name="starttime"]').val();
	var is_buy=$('#is_buy').val();

	$.post("<?php echo base_url()?>admin/a/insurance/insurance_order/derive_orderData", {if_insurance:if_insurance,line_name:line_name,ordersn:ordersn,starttime:starttime,is_buy:is_buy} , function(result) {
		if(result){
			var file_url = eval('(' + result + ')');
			//$('#tab0').click();
			jQuery("#btnSearch0").click();
			window.location.href="<?php echo base_url()?>"+file_url;		
		}
	});
})
//编辑出游人
/*function edit_people(id){
        	if(id>0){
           		$.post("<?php echo base_url()?>admin/a/insurance/insurance_order/order_people", {id:id} , function(result) {	
           			if(result){
				var data = eval('(' + result + ')');
					
			}
		});

        	}else{
        		alert('获取数据失败');
       	}
}*/
</script>


