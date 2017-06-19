<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.registered_btn a{ padding:8px 4px; background: #2dc3e8;color: #fff; border-radius: 3px;  text-decoration: none}
	#myTab11{ margin-top: 20px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">我的场景秀</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">

                 <iframe id="eqixiu" src='' width="100%" height="900px" style="border: none">  
               </iframe>	
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
var eqixiuUrl="<?php if(!empty($ip)){ print_r($ip[0]['eqixiu_url'] )  ;} ?>";
var username="<?php if(!empty($supplier)){echo $supplier[0]['mobile'];} ?>";
var password="<?php if(!empty($supplier)){echo $supplier[0]['password'];} ?>";
$(function(){
	eqixiuUrl =eqixiuUrl+"/1b1uinner.html?password="+password+"&username="+username;
	document.getElementById("eqixiu").src= eqixiuUrl;
});

</script>

