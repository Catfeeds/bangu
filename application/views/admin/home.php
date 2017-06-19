<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
<meta charset="utf-8" />
<title>首页</title>
<meta name="description" content="Dashboard" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">-->
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<!--Basic Styles-->
<!--<link href="assets/css/bootstrap.min.css" rel="stylesheet" />-->
<link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet" />
<link id="bootstrap-rtl-link" href="" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/font-awesome.min.css')?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/weather-icons.min.css')?>" rel="stylesheet" />
<!--Fonts-->
<link href="<?php echo base_url('assets/css/fonts.css')?>" rel="stylesheet" type="text/css">
<!--Beyond styles-->
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css')?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/demo.min.css')?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/typicons.min.css')?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/animate.min.css')?>" rel="stylesheet" />
<link id="skin-link" href="" rel="stylesheet" type="text/css" />
<script src="assets/js/skins.min.js"></script>
</head>
<!-- /Head -->
<!-- Body -->
<body style="padding-top: 100px;">
	<div class="row">
		<div class="col-sm-6  col-md-6  col-md-offset-3">
			<div class="well with-header with-footer">
				<div class="header bordered-blue">帮游网欢迎您!</div>
				<div class="buttons-preview">
					<div class="btn-group btn-group btn-group-justified">
						<a class="btn btn-palegreen" href="<?php echo site_url('admin/b1/home')?>">供应商(B1)入口</a>
						<a class="btn btn-warning" href="<?php echo site_url('admin/b2/login')?>">专家(B2)入口</a>
						<a class="btn btn-blue" href="<?php echo site_url('admin/a/login')?>">平台(A)入口</a>
					</div>
				</div>
				<div class="footer">
					<code></code>
				</div>
			</div>
		</div>
	</div>
	<!--Basic Scripts-->
	<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>

	<!--Beyond Scripts-->
	<script src="<?php echo base_url('assets/js/beyond.min.js')?>"></script>
	<script src="<?php echo base_url('assets/js/backend/b2backend.js')?>"></script>
</body>
<!--  /Body -->
</html>
