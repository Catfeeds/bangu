
<style type="text/css">

.nav-tabs.tabs-flat {margin-left: 10px;}
.widget-main {}
.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
.search .col-lg-4{ padding-left: 0px;}
.has-feedback .form-control{ padding-right: 12px; }
.search_box .widget-body { padding-top:15px;}
.w_160 { width:160px !important;} 
/*树形结构*/
li {list-style: circle;font-size: 12px;}
li.title {list-style: none;}
ul.list {margin-left: 17px;}
ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}
</style>

<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
			<li class="active">供应商后台</li>
		<li class="active">跟团线路</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li name="tabs" class="active"><a href="###" id="tab0">待提交 </a></li>
					<li name="tabs" class=""><a href="###" id="tab1">审核中 </a></li>
					<li name="tabs" class=""><a href="###" id="tab2">已上线 </a></li>
					<li name="tabs" class=""><a href="###" id="tab3">已退回 </a></li>
					<li name="tabs" class=""><a href="###" id="tab4">已停售 </a></li>
					<li name="tabs" class=""><a href="###" id="tab5">已删除 </a></li>
					<li style="background:none">
					<a href="/admin/b1/product_insert/destination?mold=c" style=" padding:0px 0px;">
						<input type="button" name="submit" class="search_button" id="add_cline" value="添加帮游产品" style="width: 90px;height: 32px;">
					</a>
					</li>
				</ul>
				<div></div>
				<div class="tab-content tabs-flat search_box">
					<!-- 待提交 -->
					<div class="tab-pane active" id="tab_content0">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="listForm" novalidate="novalidate" style="width:100%">
									<div class="form-group has-feedback search">
									<label class="col-lg-4 control-label  col_lb w80" style=" float:left ;padding-right:0;">产品名称：</label>
										<div class="col-lg-4 w_160" style=" float:left"><input type="text" name="productName" class="form-control user_name_b1"/></div>  
										<label class="col-lg-4 control-label col_lb w80" style=" float:left;padding-right:0;">产品编号：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
								    	<label class="col-lg-4 control-label col_lb w80" style="width: auto; float:left;padding-right:0;">目的地：</label>					 
										<div class="col-lg-4 w_160" style="float:left;margin-right:20px;">
										     <input id="cityName" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										     <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
										</div>
										<div class="col-lg-4 w80" style=" float:left"><input type="button" value="搜索" id="searchBtn0" class="btn btn-palegreen"/></div>
									</div>
								</form>
								<div id="list"></div>
							</div>
						</div>
					</div>
					
					<!-- 审核中 -->
					<div class="tab-pane " id="tab_content1">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="listForm1" novalidate="novalidate">
									<div class="form-group has-feedback search">
										<label class="col-lg-4 control-label w80" style="float:left; width: 100px;">产品名称：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="productName" class="form-control user_name_b1"/></div>
										<!--<label class="col-lg-4 control-label" style="width: 100px;  float:left">产品编号：</label>
										<div class="col-lg-4" style="width: 160px;  float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
										<label class="col-lg-4 control-label" style="width: 100px;  float:left">行程天数：</label>
										<div class="col-lg-4" style="width: 100px;  float:left"><input type="text" name="lineday" class="form-control user_name_b1"></div>
										<div class="col-lg-4" style="width: 10%; float:left"><input type="button" value="搜索" id="searchBtn1" class="btn btn-palegreen"/></div>-->
										<label class="col-lg-4 control-label col_lb w80" style="float:left; width: 100px; ">产品编号：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
								    	<label class="col-lg-4 control-label col_lb w80" style="float:left; width: 100px;">目的地：</label>
										<div class="col-lg-4 w_160" style="float:left;margin-right:20px;">
										    <input id="cityName0" name="cityName"  type="text" class="form-control user_name_b1" onfocus="b1_showCGZDestTree(this);" />
										    <input  id="destcity0"  name="destcity" type="hidden" value=""  />
										</div>
										<div class="col-lg-4 w80" style=" float:left"><input type="button" value="搜索" id="searchBtn1" class="btn btn-palegreen"/></div> 
									</div>
								</form>
								<div id="list1"></div>
							</div>
						</div>
					</div>					
					<!-- 已上线 -->
					<div class="tab-pane " id="tab_content2">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="listForm2" novalidate="novalidate">
									<div class="form-group has-feedback search">
								    	<label class="col-lg-4 control-label w80" style="float:left; width: 100px;">产品名称：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="productName" class="form-control user_name_b1"/></div>
										<!--<label class="col-lg-4 control-label" style="width: 100px;  float:left">产品编号：</label>
										<div class="col-lg-4" style="width: 160px; float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
										<label class="col-lg-4 control-label" style="width: 100px;  float:left">行程天数：</label>
										<div class="col-lg-4" style="width: 100px;  float:left"><input type="text" name="lineday" class="form-control user_name_b1"></div>-->
										<label class="col-lg-4 control-label col_lb" style="width: 100px; float:left ">产品编号：</label>
										<div class="col-lg-4 w_160" style=" float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>			
										<label class="col-lg-4 control-label col_lb w80" style="float:left; width: 100px;">目的地：</label>
										<div class="col-lg-4 w_160" style="float:left;margin-right:20px;">
										    <input id="cityName2" name="cityName"  type="text" class="form-control user_name_b1" onfocus="b1_showCGZDestTree(this);" />
										    <input  id="destcity2"  name="destcity" type="hidden" value=""  />
										</div>
										<div class="col-lg-4 w80" style="width: 10%;float:left"><input type="button" value="搜索" id="searchBtn2" class="btn btn-palegreen"/></div>
									</div>
								</form>
								<div id="list2"></div>
							</div>
						</div>
					</div>
					
					<!-- 已退回 -->
					<div class="tab-pane" id="tab_content3">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="listForm3" novalidate="novalidate">
									<div class="form-group has-feedback search">
									 	<label class="col-lg-4 control-label w80" style="float:left; width: 100px;">产品名称：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="productName" class="form-control user_name_b1"/></div>
									<!--<label class="col-lg-4 control-label" style="width: 100px;  float:left">产品编号：</label>
										<div class="col-lg-4" style="width: 160px; float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
										<label class="col-lg-4 control-label" style="width: 100px;  float:left">行程天数：</label>
										<div class="col-lg-4" style="width: 100px; float:left"><input type="text"  name="lineday" class="form-control user_name_b1"></div>-->
										<label class="col-lg-4 control-label col_lb" style="width: 100px;  float:left ">产品编号：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text"  name="sn" class="form-control user_name_b1"></div>
								    	<label class="col-lg-4 control-label col_lb" style="width: 100px; float:left">目的地：</label> 
										<div class="col-lg-4 w_160" style="float:left;margin-right:20px;" >
										    <input id="cityName3" name="cityName"  type="text" class="form-control user_name_b1" onfocus="b1_showCGZDestTree(this);"/>
										    <input  id="destcity3"  name="destcity" type="hidden" value=""  />
										</div>
										<div class="col-lg-4 w80" style="float:left"><input type="button" value="搜索" id="searchBtn3" class="btn btn-palegreen"/></div>
									</div>
								</form>
								<div id="list3"></div>
							</div>
						</div>
					</div>
					<!-- 已停售 -->
					<div class="tab-pane" id="tab_content4">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="listForm4" novalidate="novalidate">
									<div class="form-group has-feedback search">
									 	<label class="col-lg-4 control-label w80" style="float:left; width: 100px;">产品名称：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="productName" class="form-control user_name_b1"/></div>
		
										<label class="col-lg-4 control-label col_lb" style="width: 100px;  float:left ">产品编号：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
								    	<label class="col-lg-4 control-label col_lb" style="width: 100px; float:left">目的地：</label> 
										<div class="col-lg-4 w_160" style="float:left;margin-right:20px;" >
										    <input id="cityName4" name="cityName"  type="text" class="form-control user_name_b1"  onfocus="b1_showCGZDestTree(this);" />
										    <input  id="destcity4"  name="destcity" type="hidden" value=""  />
										</div>
										<div class="col-lg-4 w80" style="float:left"><input type="button" value="搜索" id="searchBtn4" class="btn btn-palegreen"/></div>
									</div>
								</form>
								<div id="list4"></div>
							</div>
						</div>
					</div>
					<!--已删除-->
					<div class="tab-pane" id="tab_content5">
						<div class="widget-body">
							<div id="registration-form">
								<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" id="listForm5" novalidate="novalidate">
									<div class="form-group has-feedback search">
									 	<label class="col-lg-4 control-label w80" style="float:left; width: 100px;">产品名称：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="productName" class="form-control user_name_b1"/></div>
		
										<label class="col-lg-4 control-label col_lb" style="width: 100px;  float:left ">产品编号：</label>
										<div class="col-lg-4 w_160" style="float:left"><input type="text" name="sn" class="form-control user_name_b1"></div>
								    	<label class="col-lg-4 control-label col_lb" style="width: 100px; float:left">目的地：</label> 
										<div class="col-lg-4 w_160" style="float:left;margin-right:20px;" >
										    <input id="cityName5" name="cityName"  type="text" class="form-control user_name_b1"  onfocus="b1_showCGZDestTree(this);" />
										    <input  id="destcity5"  name="destcity" type="hidden" value=""  />
										</div>
										<div class="col-lg-4 w80" style="float:left"><input type="button" value="搜索" id="searchBtn5" class="btn btn-palegreen"/></div>
									</div>
								</form>
								<div id="list5"></div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
 <!--  <div id="menuContent" class="menuContent" style="display:none; position: absolute;">
	<ul id="treeDemo" class="ztree" style="margin-top:0;"></ul>
</div>-->
<?php echo $this->load->view('admin/b1/common/product_script'); ?>
<script src="/assets/js/jquery-1.11.1.min.js"></script>

<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script>

function updataLineTab(){
	var type='<?php if(!empty($type)){ echo $type;} ?>';

	if(type!=''){
		if(type==1){   //待审核
			$('#tab1').click();
		}else if(type==2){ //上线的tab
			$('#tab2').click();
		}else if(type==3){ //退回的tab
			$('#tab3').click();
		}
	}
}

jQuery(document).ready(function(){	
	updataLineTab();
}); 
//目的地
var oleft = 0 ; 
var oTop = 0;
function b1_showCGZDestTree(obj,cityid){
	oleft = 0 ; 
	oTop = -40 ;
	treeInputObj = obj;
	var url = '/common/get_data/getTripDestBaseArr';
	var zNodes = commonTree(obj ,url ,cityid);
	
	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword(obj ,zNodes ,event);
	})
}

/********************目的地的选择*********************/
/*  $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
		createChoicePlugin({
			data:chioceDestJson,
			nameId:"cityName",
			valId:"destcity"
		});
		createChoicePlugin({
			data:chioceDestJson,
			nameId:"cityName0",
			valId:"destcity0"
		});
		createChoicePlugin({
			data:chioceDestJson,
			nameId:"cityName2",
			valId:"destcity2"
		});
		createChoicePlugin({
			data:chioceDestJson,
			nameId:"cityName3",
			valId:"destcity3"
		});
		createChoicePlugin({
			data:chioceDestJson,
			nameId:"cityName4",
			valId:"destcity4"
		});
}); */

function callbackTree(id,name){
	$(treeInputObj).next('input').val(id);
}
//添加c端的产品add_cline
jQuery('#add_cline').click(function(){
	
})

//ztree
</script>

<?php  echo $this->load->view('admin/common/tree_view'); ?>	