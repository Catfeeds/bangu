<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">优惠券配置 </li>
		</ul>
	</div>
	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">优惠券配置 </a></li>	
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
							 <a class="btn btn-info btn-xs" id="add_mcoupon" style="padding:5px 10px 5px 10px">添加</a>
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">优惠券名：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="coupon_name">
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">用户名：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="member_name" id="member_name">
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
<!-- 添加会员优惠卷 -->
<div style="display: none;" class="bootbox modal fade in" id="add_mcoupon_modal">
	<div class="modal-dialog">
		<div class="modal-content" style="height:400px;">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close">×</button>
				<h4 class="modal-title">添加会员优惠卷</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="add_mcoupon_form" method="post" action="#" onsubmit="return CheckMcoupon();">
						<div style="height: 200px;">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">优惠券名:</label>
								<div class="col-sm-10 col_ts">
									<ul>
										<?php if(!empty($coupon)){
										         foreach ($coupon as $k=>$v){
										?>
										<li style="list-style-type:none;height:30px;width:180px;"><?php echo $v['name']; ?>
										<span style="float:right"><input type="text" name="coupon[]" style="width: 60px;">张</span>
										<input type="hidden" name="coupon_id[]" value="<?php echo $v['id']; ?>"/>
										</li>
									    <?php } }?> 
									</ul>							        	 
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3"
									class="col-sm-2 control-label no-padding-right col_lb">会员手机号:</label>
								<div class="col-sm-10 col_ts">
									 <input type="text" class="form-control" style="width:190px;" placeholder="会员手机号" name="sel_memberid" id="sel_memberid"> 
									<!-- <input type="text" class="form-control" style="width:190px;" placeholder="会员手机号" name="sel_moblie" id="sel_moblie"> -->
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
<!-- 出发地 -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<script type="text/javascript">

jQuery(document).ready(function(){
	// 第一个列表 未使用===============================================================
	jQuery("#btnSearch0").click(function(){
		page0.load({"status":"0"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/coupon/couponData",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [
					{title : '编号',width : '5%',align : 'center',
						formatter : function(value,rowData, rowIndex) {
							return rowIndex+1;
						}
					},
					{field : 'truename',title : '用户名',align : 'center', width : '10%'},
					{field : 'name',title :'优惠卷',width : '10%',align : 'center'},
					{field : 'use_range',title : '使用范围',align : 'center', width : '10%',
						formatter : function(value,rowData, rowIndex) {
							if(rowData.use_range==4){
								return '全网';
							}else if(rowData.use_range==3){
								return '区域';
							}else if(rowData.use_range==2){
								return '商家';
							}else if(rowData.use_range==1){
								return '线路';
							}
						}
					},
					{field : '',title : '使用时间',align : 'center', width : '20%',
						formatter : function(value,rowData, rowIndex) {
							return rowData.starttime+'至'+rowData.endtime;
						}
					},
					{field : 'min_price',title : '满多少使用',align : 'center', width : '15%'},
					{field : 'coupon_price',title : '优惠额度',align : 'center', width : '15%'}

			/* 		{field : '',title : '操作',align : 'center', width : '15%',
						formatter : function(value,rowData, rowIndex) {
							//<a onclick="edit_act('+rowData.act_id+')" href="###" >编辑</a>
							var html='<a href="###" data='+rowData.act_id+' onclick="look_act('+rowData.act_id+')" >查看</a>&nbsp;&nbsp;&nbsp;';
							return html;
						}
					}, */

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
	
//会员中心									           	 
$.post('/admin/a/coupon/get_member_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.mobile,
		    value : val.mid,
		    jb : val.mobile,
		    qp : val.mobile
		});
	})

	var comboBox = new jQuery.comboBox({
	    id : "#sel_memberid",
	    name : "memberid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    blurAfter : function(item, index) {// 选择后的事件
			if(jQuery('#memberid').val()==''){
				jQuery('#memberid').val('');
				jQuery('#sel_memberid').val('');
			}
	    },
	    data : array
	});
	
})

	//添加活动的弹框
	$('#add_mcoupon').click(function(){
		 $("#add_mcoupon_modal").show();
		 $(".modal-backdrop").show(); 
	});
	
	//添加活动
	function CheckMcoupon(){
			 var flag=false;
			 var a=true;
			 $('input[name="coupon[]"]').each(function(index){
  				if($(this).val()!=''){
  					flag=true;
  	  			}
  	  			if($(this).val()>10){
  	  			    a=false;
  	  	  		}
			 });
		     if(flag==false){
				alert('优惠券数量不能为空!');
				return false;	     
			 }
			 if(a==false){
				 alert('每张的优惠券数量不能大于10!');
				 return false;	 
			 }
		     jQuery.ajax({ type : "POST",data : jQuery('#add_mcoupon_form').serialize(),url : "<?php echo base_url()?>admin/a/coupon/add_mcoupon", 
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
	
	//关闭查看
	function ex_colse() {
		$('.modal-backdrop,.bootbox,.eject_body').hide();
	}


</script>

