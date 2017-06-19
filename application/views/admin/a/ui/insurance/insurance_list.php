<link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
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
			<li class="active">保险列表 </li>
		</ul>
	</div>

	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">保险列表 </a></li>	
	</ul>

	<div class="tab-content tabs-flat">
		<!-- 管家列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
			   <div class="form-group has-feedback">
						<div style="margin: 10px 0px 0px 12px;">
							 <input id="addinsure" class="btn btn-palegreen" type="button" onclick="add_insure()" value="新增保险">
					   </div>
				</div>
				<div id="registration-form">
				
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">保险类型：</label>
							<div style="display:inline-block;padding-left:2px;">
						      <select name="search_insurance_type">
									<option value="">请选择</option>
									<option value="2">境内</option>	
									<option value="1">境外</option>					      
						      </select>
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">保险种类：</label>
							<div style="display:inline-block;padding-left:2px;">
						      <select name="search_insurance_kind">
									<option value="">请选择</option>
		      	    				  <?php if(!empty($kind)){ 
								          foreach ($kind as $k=>$v){
								      	?>
								      	<option value="<?php echo $v['dict_id'] ?>"><?php echo $v['description'] ?> </option>
								      <?php } }?>
						      </select>
							</div>	
						    <label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">保险名称：</label>
							<div style="display:inline-block;">
						       <input class="search_input user_name_b1" style="width:100%" type="text" name="name" placeholder="保险名称">
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">保险公司：</label>
							<div style="display:inline-block;" >
								<input class="search_input user_name_b1" style="width:100%" type="text" name="commpany" placeholder="保险公司">
							</div>
						
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
							     <input type="button" value="搜索" style="width:70px" class="btn btn-palegreen" id="btnSearch0">  
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
<!-- ---------新增保险---------- -->
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in" >
		<div class="modal-dialog" style="width:800px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">新增保险</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="form_data_submit" method="post" action="#">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险类型</label>
									<div class="col-sm-8">
										<select name="insurance_type"  style="width:50%;float:left;">
										   <option value="2">境内</option>
										   <option value="1">境外</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险种类</label>
									<div class="col-sm-8">
										<select name="insurance_kind"  style="width:50%;float:left;">
										      <?php if(!empty($kind)){ 
										          foreach ($kind as $k=>$v){
										      	?>
										      	<option value="<?php echo $v['dict_id'] ?>"><?php echo $v['description'] ?> </option>
										      <?php } }?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险编号</label>
									<div class="col-sm-8">
										<input type="text"  style="width: 50%;" name="insurance_code" placeholder="保险编号" class="form-control" >
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险期限</label>
									<div class="col-sm-8">
										<input style="width:50%;float:left;"  type="text" class="form-control" name="insurance_date"  placeholder="保险期限">	
									    <span style="line-height:32px;">天</span>
									</div>
								</div>
								<!--<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>最小保险期限</label>
									<div class="col-sm-8">
										<input style="width:50%;float:left;"  type="text" class="form-control" name="min_date"  placeholder="最小保险期限">	
									    <span style="line-height:32px;">天</span>
									</div>
								</div>	-->	
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险名称</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_name" placeholder="保险名称" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险公司</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_company" placeholder="保险公司" class="form-control">
									</div>
								</div>
	
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险费用</label>
									<div class="col-sm-8">
										<input type="text" name="insurance_price"  class="form-control"   placeholder="保险费用" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>结算价(售卖)</label>
									<div class="col-sm-8">
										<input type="text" name="settlement_price"  class="form-control"   placeholder="结算价" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险描述</label>
									<div class="col-sm-8" style="width:80%">
										<textarea class="form-control content_required" rows="4" name='description' id="description" placeholder="保险描述"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">投保须知</label>
									<div class="col-sm-8" style="width:80%">
										<textarea class="form-control" rows="4" name='simple_explain' placeholder="投保须知"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
									<div class="col-sm-8" style="width:80%">
										<textarea class="form-control" rows="4" name='insurance_clause' placeholder="保险条款"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div></div>
									<div  onclick="submit_addinsure();" class="btn btn-default" style="left:55%;">保存</div>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<!-- ---------编辑保险---------- -->
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="editbootbox  modal fade in" >
		<div class="modal-dialog" style="width:800px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button opp_colse close"
						data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">新增保险</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="form_editdata_submit" method="post" action="#">
							   <div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险类型</label>
									<div class="col-sm-8">
										<select name="edit_insurance_type" id="edit_insurance_type" style="width:50%;float:left;">
										   <option value="2">境内</option>
										   <option value="1">境外</option>
										</select>
									</div>
								</div>	
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险种类</label>
									<div class="col-sm-8">
										<select name="edit_insurance_kind" id="edit_insurance_kind" style="width:50%;float:left;">
										      <?php if(!empty($kind)){ 
										          foreach ($kind as $k=>$v){
										      	?>
										      	<option value="<?php echo $v['dict_id'] ?>"><?php echo $v['description'] ?> </option>
										      <?php } }?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险编号</label>
									<div class="col-sm-8">
										<input type="text"  style="width: 50%;" name="edit_insurance_code" placeholder="保险编号" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险期限</label>
									<div class="col-sm-8">
										<input style="width:50%;float:left;"  type="text" class="form-control" name="edit_insurance_date"  placeholder="保险期限">
									    <span style="line-height:32px;">天</span>
									</div>
								</div>	
								<!-- <div class="form-group">
											<label for="inputEmail3"
												class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>最小保险期限</label>
											<div class="col-sm-8">
												<input style="width:50%;float:left;"  type="text" class="form-control" name="edit_min_date"  placeholder="最小保险期限">
											    <span style="line-height:32px;">天</span>
											</div>
										</div>	 -->		
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险名称</label>
									<div class="col-sm-8">
										<input type="text" name="edit_insurance_name" placeholder="保险名称" class="form-control" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险公司</label>
									<div class="col-sm-8">
										<input type="text" name="edit_insurance_company" placeholder="保险公司" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险费用</label>
									<div class="col-sm-8">
										<input type="text" name="edit_insurance_price"  class="form-control"   placeholder="保险费用" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>结算价(售卖)</label>
									<div class="col-sm-8">
										<input type="text" name="edit_settlement_price"  class="form-control"   placeholder="结算价" >
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right"><span style="color:red;">*</span>保险描述</label>
									<div class="col-sm-8" style="width:80%">
										<textarea class="form-control content_required" rows="4" name='edit_description' id="edit_description" placeholder="保险描述"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">投保须知</label>
									<div class="col-sm-8" style="width:80%">
										<textarea class="form-control" rows="4" name='edit_simple_explain' id="edit_simple_explain" placeholder="投保须知"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-3 control-label no-padding-right">保险条款</label>
									<div class="col-sm-8" style="width:80%">
										<textarea class="form-control" rows="4" name='edit_insurance_clause' id="edit_insurance_clause" placeholder="保险条款"></textarea>
									</div>
								</div>
								<div class="form-group">
									<div></div>
									<input type="hidden" name="insure_id" id="insure_id" value=""/>
									<div  onclick="submit_editInsure();" class="btn btn-default opp_eidt" style="left:55%;">保存</div>
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>

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
	page=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/insurance/insurance_list/indexData",form : '#listForm0',// 绑定一个查询表单的ID
		columns : [

			{field : 'id',title : '序号',width : '40',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					return rowIndex+1;
				}
			},
			{field : 'insurance_name',title : '保险类型',width : '60',align : 'center',
				formatter : function(value,rowData, rowIndex) {
					if(rowData.insurance_type==2){
						return '境内';
					}else if(rowData.insurance_type==1){
						return '境外';
					}else{
						return '境内';
					}
				}
			},
			{field : 'kind',title : '保险种类',width : '60',align : 'center'},
			
			{field : 'insurance_name',title : '保险名称',width : '100',align : 'center'},
			{ field : 'insurance_company',title:'保险公司',width : '100',align : 'center'},
			{field : 'insurance_date',title : '保险期限',width : '80',align : 'center',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.insurance_date+'天';
					}
				},
			{field : 'insurance_price',title : '保险费用',align : 'center',sortable : true,width : '80'},
			{field : 'settlement_price',title : '结算价',align : 'center',sortable : true,width : '80'},
			{field : '',title : '保险描述',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.description+'...';
					}
				},
			{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){	
					if(rowData.description!=''){
						return '';					
						//return '<div class="hide_info1 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:260px;min-height:40px;left:-60px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.description1+'</div></div>';
					}else{
						return '';
					}
				}
			},
			{field : 'simple_explain',title : '投保须知',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.simple_explain+'...';
					}
			},
			{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){	
				/* 	if(rowData.simple_explain!=''){				
					   return '<div class="hide_info2 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:260px;min-height:40px;left:-60px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.simple_explain1+'</div></div>';
					}else{ */
						return '';
					//}
				}
			},
			{field : 'insurance_clause',title : '保险条款',align : 'center', width : '100',
				formatter : function(value,	rowData, rowIndex){	
					return rowData.insurance_clause+'...';
					}
			},
			{field : '',title : '',align : 'center', width : '1',
				formatter : function(value,	rowData, rowIndex){	
					/* if(rowData.insurance_clause!=''){					
						return '<div class="hide_info3 hide_info" style="position:relative;width:1px;display:none;"><div style="position:absolute;width:260px;min-height:40px;left:-100px;z-index:999;top:25px;background:#fff;border:2px solid #ccc;border-radius:4px;padding:10px;text-indent:0.5em;text-align:left;">'+rowData.insurance_clause1+'</div></div>';
					}else{ */
						return '';
				//	}
				}
			},
			{field : '',title : '操作',align : 'center',width : '100',
				formatter : function(value,	rowData, rowIndex){					
					return '<a href="##" onclick="edit_insure('+rowData.id+');">修改</a> &nbsp;&nbsp;&nbsp;<a href="##" onclick="del_insure('+rowData.id+');">删除</a>';
				}
			}
		]
	});
	
}); 
//-----------------------------------保险列表数据 end----------------------------------------------

 $(document).ready(function(){
	$(".hide_info1").parent().parent().prev().addClass("description_txt");
	$(".hide_info2").parent().parent().prev().addClass("simple_explain_txt");
	$(".hide_info3").parent().parent().prev().addClass("insurance_clause_txt");
/* 	$(".description_txt,.simple_explain_txt,.insurance_clause_txt").hover(function(){
		$(this).next().find(".hide_info").show();
	},function(){
		$(this).next().find(".hide_info").hide();
	}); */
	$('.x-grid-cell-inner').parent().hover(function(){
		$(this).next().find(".hide_info").show();
	},function(){
		$(this).next().find(".hide_info").hide();
	});
}); 
 
function add_insure(){
    $('.opp_srelease').css('display','none');
	$('.bootbox').show();
	$('.modal-backdrop,.opp_eidt').show();
}
//关闭弹框
$('.opp_colse').click(function(){
	$('.bootbox,.editbootbox').hide();
	$('.modal-backdrop').hide();
})
//新增保险
function submit_addinsure(){
	var insurance_name =$('input[name="insurance_name"]').val();
	var insurance_company=$('input[name="insurance_company"]').val();
	var insurance_date=$('input[name="insurance_date"]').val();
//	var min_date=$('input[name="min_date"]').val();
	var insurance_code=$('input[name="insurance_code"]').val();
	var insurance_price=$('input[name="insurance_price"]').val();
	var settlement_price=$('input[name="settlement_price"]').val();
	var description=$('#description').val();
	
	if(insurance_name==''){
		alert('保险名称不能为空!');
		return false;
	}
	if(insurance_company==''){
		alert('保险公司不能为空!');
		return false;
	}
	if(insurance_date==''){
		alert('保险期限不能为空!');
		return false;
	}else{
		if(!(/^(\+|-)?\d+$/.test( insurance_date )) || insurance_date < 0){
			alert("保险期限填写格式不对");
		    return ;  
		}
	}
/*             if(min_date==''){
		alert('最小保险期限不能为空!');
		return false;
             }else{
		if(!(/^(\+|-)?\d+$/.test( min_date )) || min_date < 0){
			alert("最小保险期限填写格式不对");
		    return ;  
		}
	}*/

	if(insurance_code==''){
		alert('保险编号不能为空!');
		return false;
	}
	if(insurance_price==''){
		alert('保险费用不能为空!');
		return false;
	}else{
		if(isNaN(insurance_price) || insurance_price<0){
			   alert("保险费用填写格式不对");
			   return false;
		}
	}
	if(settlement_price==''){
		alert('结算价不能为空!');
		return false;
	}else{
		if(isNaN(settlement_price) || settlement_price<0){
			   alert("结算价填写格式不对");
			   return false;
		}
	}
	if(parseInt(settlement_price)<parseInt(insurance_price)){
		alert('结算价应比保险费用大!');
		return false;
	}
	if(description==''){
		alert('保险描述不能为空!');
		return false;
	}
	

	$.post("/admin/a/insurance/insurance_list/addInsure",$('#form_data_submit').serialize(),function(data) {
 		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
			location.reload();
		} 
	});
	return false;
}
//编辑保险的弹框
function edit_insure(id){
    $('input[name="insure_id"]').val(id);
    $.post("/admin/a/insurance/insurance_list/sel_insure",{'id':id},function(re) {
    	var re = eval('('+re+')');
		if (re.status == 1) {
			//alert(re.data.settlement_price);
			$('input[name="edit_insurance_name"]').val(re.data.insurance_name);
			$('input[name="edit_insurance_company"]').val(re.data.insurance_company);
			$('input[name="edit_insurance_date"]').val(re.data.insurance_date);
		//	$('input[name="edit_min_date"]').val(re.data.min_date);
			$('input[name="edit_insurance_price"]').val(re.data.insurance_price);
			$('#edit_simple_explain').val(re.data.simple_explain);
			$('#edit_description').val(re.data.description);
			$('#edit_insurance_clause').val(re.data.insurance_clause);
			$('input[name="edit_settlement_price"]').val(re.data.settlement_price);
		            $('input[name="edit_insurance_code"]').val(re.data.insurance_code);
		    $("#edit_insurance_type option").each(function() { 
		        if ($(this).val() ==re.data.insurance_type) {  
		                $(this).attr("selected", true);  
		         }else{
		        	 $(this).attr("selected", false); 
			     }  
		     });  
		    $("#edit_insurance_kind option").each(function() { 
		        if ($(this).val() ==re.data.insurance_kind) {  
		                $(this).attr("selected", true);  
		         }else{
		        	 $(this).attr("selected", false); 
			     }  
		     });  
		} else {
			alert(data.msg);
		} 
    });
	$('.editbootbox').show();
	$('.modal-backdrop,.opp_eidt').show();
}
//保存编辑
function submit_editInsure(){
	var insurance_name =$('input[name="edit_insurance_name"]').val();
	var insurance_company=$('input[name="edit_insurance_company"]').val();
	var insurance_date=$('input[name="edit_insurance_date"]').val();
	//var min_date=$('input[name="edit_min_date"]').val();
	var insurance_price=$('input[name="edit_insurance_price"]').val();
	var settlement_price=$('input[name="edit_settlement_price"]').val();
	var insurance_code=$('input[name="edit_insurance_code"]').val();
	var description=$('#edit_description').val();
	
	if(insurance_name==''){
		alert('保险名称不能为空!');
		return false;
	}
	if(insurance_company==''){
		alert('保险公司不能为空!');
		return false;
	}
	if(insurance_date==''){
		alert('保险期限不能为空!');
		return false;
	}else{
		if(!(/^(\+|-)?\d+$/.test( insurance_date )) || insurance_date < 0){
		    alert("保险期限填写格式不对");
		    return ;  
		}
	}
/*	if(min_date==''){
		alert('最小保险期限不能为空!');
		return false;
	}else{
		if(!(/^(\+|-)?\d+$/.test( min_date )) || min_date < 0){
		    alert("最小保险期限填写格式不对");
		    return ;  
		}
	}*/

	if(insurance_code==''){
		alert('保险编号不能为空!');
		return false;
	}

	if(insurance_price==''){
		alert('保险费用不能为空!');
		return false;
	}else{
		if(isNaN(insurance_price) || insurance_price<0){
			   alert("保险费用写格式不对");
			   return false;
		}
	}

	if(settlement_price==''){
		alert('结算价不能为空!');
		return false;
	}else{
		if(isNaN(settlement_price) || settlement_price<0){
			   alert("结算价填写格式不对");
			   return false;
		}
	}
//	alert(insurance_price);
//	alert(settlement_price);
	if(parseInt(settlement_price)<parseInt(insurance_price)){
		alert('结算价应比保险费用大!');
		return false;
	}
	if(description==''){
		alert('保险描述不能为空!');
		return false;
	}
	$.post("/admin/a/insurance/insurance_list/editInsure",$('#form_editdata_submit').serialize(),function(data) {
 		var data = eval('('+data+')');
		if (data.status == 1) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
			location.reload();
		} 
	});
	return false;
}
//删除
function del_insure(id){
	 if (!confirm("确定要删除？")) {
         window.event.returnValue = false;
     }else{
	    $.post("/admin/a/insurance/insurance_list/del_insure",{'id':id},function(data) {
	 		var data = eval('('+data+')');
			if (data.status == 1) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
				location.reload();
			} 
		});
     }
	return false;
}
$(document).on('mouseover', '.hide_info3', function(){
	$(this).next().find(".hide_info").show();
});
$(document).on('mouseout', '.hide_info3', function(){
	$(this).next().find(".hide_info").hide();
});
</script>

