<!DOCTYPE html>
<html lang="en">
<!-- Head -->
<head>
	<title>平台管理系统</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width" />
	<!-- 使用高版本IE进行渲染，若安装GCF则使用chrome进行渲染 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<!-- 声明某些双核浏览器使用webkit进行渲染 -->
	<meta name="renderer" content="webkit">
	<meta charset="utf-8">
	<?php $this->load->view('admin/a/common/head');?>
	<!-- 用于站点的url跳转 -->
	<script type="text/javascript">
		var base_url = function(uri){
			return '<?=base_url() ?>' + uri;
		}
		var site_url = function(uri){
			return '<?=site_url('/') ?>' + uri;
		}	
		
	</script>
</head>
<!-- /Head -->
<!-- Body -->
<body>
	<!-- Navbar -->
	<?php //$this->load->view('admin/a/common/narbar'); ?>
	<!-- /Navbar -->
	<!-- Main Container -->
	<div class="main-container container-fluid">
		<!-- Page Container -->
		<div class="page-container">
			<!-- Page Sidebar -->
            <?php //$this->load->view('admin/a/common/sidebar'); ?>
            <!-- /Page Sidebar -->