<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.registered_btn a{ padding:6px 4px; background: #2dc3e8;color: #fff; border-radius: 3px;  text-decoration: none}
	#myTab11{ margin-top: 20px;}
	.col-sm-4{top:7px;}
	
	.form-horizontal .control-label { line-height:150% !important;height:auto;}
	.form-horizontal .form-group { margin:0 !important;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">更改订单价</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
			    	<li class="active" name="tabs"><a href="#home1" data-toggle="tab"
						id="tab1"> 申请中 </a></li>  
					<li class="" name="tabs"><a href="#home2" data-toggle="tab"
						id="tab2"> 已通过 </a></li>
					<li class="" name="tabs"><a href="#home3" data-toggle="tab"
						id="tab3">已拒绝 </a></li>

				</ul>
				<div class="tab-content tabs-flat search_box">
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
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" >
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">订单编号：</label></div>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="ordersn" >
										</div>	

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
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" >
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">订单编号：</label></div>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="ordersn" >
										</div>	

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
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路编号</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linecode"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" ><label class="col-lg-4 control-label" >线路名称：</label>
										<div class="col-lg-4" style="width: 160px;">
											<input type="text" name="linename"
												class="form-control user_name_b1">
										</div></div>
										<div class="fg_div" >
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">订单编号：</label></div>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="ordersn" >
										</div>	

										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
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
		</div>
	</div>
</div>

<!-- 查看 -->
<div class="lookexpert modal fade in" style="display:none;">
	<div style="position:absolute;left:55%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:500px;height:360px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">更改订单价格</h4>
			    </div>
			    <div class="modal-body" style="overflow-y:auto;overflow-x:hidden;">
			    <div class="bootbox-body">
			       <form  class="form-horizontal" id="lookgiftFrom" method="post" action="">
			         <div class="gift_member">		
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3" style="width:20%">订单编号:</label>
			            <div class="col-sm-8 fl nickname">
			            	<span></span>
			            </div>
			        </div>
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3" style="width:20%">线路名称:</label>
			            <div class="col-sm-8 fl realname">
			            	<span></span>
			            </div>
			        </div>
	                <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3" style="width:20%">修改前价格:</label>
			            <div class="col-sm-8 fl prev_price">
			            	<span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3" style="width:20%">修改后价格:</label>
			            <div class="col-sm-8 fl next_price">
			            	<span></span>
			            </div>
			        </div>

			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3" style="width:20%">理由:</label>
			            <div class="col-sm-8 fl reason">
			            	<span><textarea rows="" cols="" style="width:220px;height:70px;" id="supplier_reason"></textarea></span>
			            </div>
			        </div>
			        <div class="form-group" style="padding-top:15px;">
			             <div style="float:right;padding-right:40px;">
			                  <input type="hidden" name="after_price" id="after_price" value="">
			                   <input type="hidden" name="line_id" id="line_id" value="">
			                  <input type="hidden" name="op_id" id="op_id" >
			                  <input type="button" class="btn btn-palegreen" data-bb-handler="success" id="through" onclick="return through_price(this)" value="通过" style="margin-right:30px;" />
			              	  <input type="button" class="btn btn-palegreen" data-bb-handler="success" id="refuse" onclick="return refuse_price(this)" value="拒绝" style="margin-right:30px;display: none;" />
			                  <input type="button" class="btn btn-palegreen bootbox-close-button" data-bb-handler="success" value="关闭" />
			             </div>
			        </div>
		          </div>
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>




<?php echo $this->load->view('admin/b1/common/order_price_script'); ?>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script type="text/javascript">
//查看管家信息
function look_div(id){
	$('#through').show();
    $('#refuse').hide();
	$('input[name="op_id"]').val(id);
	$('#supplier_reason').val('');
	$.post("/admin/b1/order_price/order_price_rowdata",{'id':id},function(json){
		var re = eval("("+json+")");
		if (re.status == 1) {
			if(re.data!=''){
				$('.nickname').html(re.data.ordersn);
				$('.realname').html(re.data.productname);
				$('.prev_price').html(re.data.before_price);
				$('.next_price').html(re.data.after_price);	
				$('#after_price').val(re.data.after_price);
				$('#line_id').val(re.data.line_id);
			//	$('.reason').html(re.data.expert_reason);
			}
		} else {
			alert(data.msg);
		}  
	})
	$('.lookexpert').show();
}
$('.bootbox-close-button').click(function(){
	$('.lookexpert ').hide();
});
//申请通过
function through_price(obj){
	var id =$('input[name="op_id"]').val();
	var reason=$('#supplier_reason').val();
	var price=$('#after_price').val();
	var line_id=$('#line_id').val();
	
	if(id>0){
		$.post("/admin/b1/order_price/up_order_price",{'id':id,reason:reason,price:price,line_id:line_id},function(json){
			 var data = eval("("+json+")");
     		 alert(data.msg);
     		 $('#tab1').click();
     		$('.bootbox-close-button').click();
		})
	}else{
		alert('操作失败!');
	}
}
//拒绝更改弹框
function refuse_div(id){
	$('#through').hide();
    $('#refuse').show();
	$('input[name="op_id"]').val(id);
	$('#supplier_reason').val('');
	$.post("/admin/b1/order_price/order_price_rowdata",{'id':id},function(json){
		var re = eval("("+json+")");
		if (re.status == 1) {
			if(re.data!=''){
				$('.nickname').html(re.data.ordersn);
				$('.realname').html(re.data.productname);
				$('.prev_price').html(re.data.before_price);
				$('.next_price').html(re.data.after_price);	
				$('#after_price').val(re.data.after_price);
			//	$('.reason').html(re.data.expert_reason);
			}
		} else {
			alert(data.msg);
		}  
	})
	$('.lookexpert').show();
}
//拒绝更改订单价格
function refuse_price(obj){
	var id =$('input[name="op_id"]').val();
	var reason=$('#supplier_reason').val();
	var price=$('#after_price').val();
	if(id>0){
		$.post("/admin/b1/order_price/refuse_order_price",{'id':id,reason:reason,price:price},function(json){
			 var data = eval("("+json+")");
     		 alert(data.msg);
     		 $('#tab1').click();
     		$('.bootbox-close-button').click();
		})
	}else{
		alert('操作失败!');
	}
}
</script>

