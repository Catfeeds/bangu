<!DOCTYPE html>
<!--
BeyondAdmin - w_1200 Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 1.0.0
Purchase: http://wrapbootstrap.com
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title>B1后台管理系统</title>
    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png');?>" type="image/x-icon">
    <!--Basic Styles-->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/weather-icons.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/hm.widget.css');?>" rel="stylesheet" />

    <!--Fonts-->
    <link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/demo.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />
    <link href="" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
    <!--Basic Scripts-->
    <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <!--Beyond Scripts-->
    <script src="<?php echo base_url('assets/js/beyond.min.js');?>"></script>
    <script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
    
</head>
<!-- /Head -->
<!-- Body -->
<body>
      <div class="navbar">
        <div class="navbar-inner">
            <div class="navbar-container">
                <!-- Navbar Barnd -->
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            Ubang.com
                        </small>
                    </a>
                </div>
                <!-- /Navbar Barnd -->
                <!-- Sidebar Collapse -->
                <div class="sidebar-collapse" id="sidebar-collapse">
                    <i class="collapse-icon fa fa-bars"></i>
                </div>
                <!-- /Sidebar Collapse -->
                <!-- Account Area and Settings --->
                <div class="navbar-header pull-right">
                   
                    
                        <!-- Settings -->
                    </div>
                </div>
                <!-- /Account Area and Settings -->
            </div>
        </div>
    </div>
    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
     

<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="#">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">结算管理</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<div class="tab-content tabs-flat">
					<!-- 未结算 -->
					<div class="tab-pane active" id="tab_content0">
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
										<label class="col-lg-4 control-label" style="width:auto">订单编号：</label>
										<div class="col-lg-4" style="width:15%">
											<input type="text" placeholder="订单编号" name="ordersn"
												class="form-control user_name_b1"> <input type="hidden"
												name="status" class="form-control user_name_b1" value='0'>
												<input type="hidden" name="starttime" value="<?php if(!empty($starttime)){ echo $starttime;} ?>" />
												<input type="hidden" name="endtime" value="<?php if(!empty($endtime)){ echo $endtime;} ?>" />
										</div>
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;">
											<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
										</div>
									</div>
								</form>	
								<form action="<?php echo base_url();?>admin/b1/account/show_supplier_add_order" id='supplier_unsettled_order' name='supplier_unsettled_order' method="post" onSubmit="return check()">
									<div id="list"></div>
									<div style="margin-top: 15px;"><input type="submit" value="提交">
	                              <input type="button" onclick="javascript:window.opener=null;window.open('','_self');window.close();" value="关闭"></div>
                              </form>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
$("#checkall").click(function(){
    if(this.checked){
        $("input[name='order[]']").each(function(){this.checked=true;});
    }else{
        $("input[name='order[]']").each(function(){this.checked=false;});
    }
});
function check(){
    //获取选中的ID,设置到上级页面
    var orderIds ="" ;
    $("input[name='order[]']").each(function(){
        if(this.checked){
            orderIds+=$(this).val()+",";
        }

    });
     window.opener.document.getElementById('orderIds').value= orderIds;
     window.opener.refresh_order();
     window.close();
    return false ; 
}
</script>
<?php echo $this->load->view('admin/b1/common/account_order_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>

