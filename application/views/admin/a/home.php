<!DOCTYPE html>
<html lang="en">
<head>
<title>平台管理系统</title>
<link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="viewport" content="width=device-width" />
<!-- 使用高版本IE进行渲染，若安装GCF则使用chrome进行渲染 -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<!-- 声明某些双核浏览器使用webkit进行渲染 -->
<meta name="renderer" content="webkit">

<link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="/assets/css/font-awesome.min.css" rel="stylesheet" />
<link href="/assets/css/weather-icons.min.css" rel="stylesheet" />
<link href="/assets/css/xiuxiu.css" rel="stylesheet" />
<link href="/assets/css/eject.css" rel="stylesheet" />
<!--Fonts-->
<link href="/assets/css/fonts.css" rel="stylesheet" type="text/css">

<!--Beyond styles-->
<link id="beyond-link" href="/assets/css/beyond.min.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/demo.min.css" rel="stylesheet" />
<link href="/assets/css/typicons.min.css" rel="stylesheet" />
<link href="/assets/css/animate.min.css" rel="stylesheet" />
<link href="/assets/css/dataTables.bootstrap.css" rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>

<link rel="stylesheet" type="text/css" href="/assets/css/home.css"/>
<style type="text/css">
	.page-sidebar .sidebar-menu > li > .submenu::before{ left:13px;}
	.page-sidebar .sidebar-menu > li > .submenu > li > a::before{left:11px;}
	.page-sidebar .sidebar-menu .submenu > li > a{padding-left: 18px;}
	.tab-content{margin-bottom:150px;}
</style>
</head>
<body>
	<!-- 头部 -->
	<div class="navbar" style="height:80px;" >
	<div class="navbar-inner" style="height:82px;">
		<div class="navbar-container">
			<div class="navbar-header pull-left">
				<a href="<?php echo base_url();?>" class="navbar-brand" style="line-height:35px;"><img src="../../../../static/img/logo.png" />
				</a>
			</div>
			<div class="navbar-header pull-right">
				<div class="navbar-account">
					<ul class="account-area">
						<li>
							<a class="login-area dropdown-toggle" data-toggle="dropdown" style="padding-top:10px;">
								<div class="avatar" title="View your public profile">
									<img src="<?php echo $admin_photo; ?>">
								</div>
								<section>
									<h2>
										<span class="profile"><span style="font-size:14px; color:#fff;"><?php echo $this ->realname; ?></span></span>
									</h2>
								</section>
							</a>
							<ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
								<li class="username"><a><?php echo $this ->realname; ?></a></li>
								<!--Avatar Area-->
								<li>
									<div class="avatar-area">
										<img src="<?php echo $admin_photo;?>" class="avatar">
										<span class="caption change_avatar">更换头像</span>
									</div>
								</li>
								 
								<!--Avatar Area-->
								<li class="edit">
									<a href="<?php echo site_url('admin/a/pri/adminUser');?>"  target='main' class="pull-left">个人中心</a>
									<a href="<?php echo site_url('admin/a/pri/adminUser/editPassword');?>" target="main" class="pull-right">修改密码</a>
								</li>								
								<li class="dropdown-footer"><a href="javascript:void(0);">注销</a>
								</li>
							</ul>
						</li>
						<!-- /Account Area -->	
						<br>
						<li><a href="<?php echo $eqixiu_url ?>/adminc.php" target="_blank" style="margin: 5px 0px 0px 20px;font-size: 14px;">场景秀管理</a></li>					
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--  -->
<div class='avatar_box'></div>
<div class='opac_box'></div>
<div id="altContent"></div>
<div class="close_xiu" style="">X</div>

	<!-- 头部结束 -->
	<!-- Main Container -->
	<div class="main-container container-fluid">
		<div class="page-container">
			<div class="page-sidebar" id="sidebar" style="overflow: scroll;">
				<ul class="nav sidebar-menu">
					<!-- 第一级 -->
					<?php foreach($nav_list as $key =>$val):?>
						<li class="">
							<a href="<?php echo $val['url']?>" class="menu-dropdown" >
								 <i class="menu-icon glyphicon glyphicon-tasks"></i>
								 <span	class="menu-text"><?php echo $val['name']?></span>
								 <i class="menu-expand"></i>
							</a>
							<ul class="submenu nav_list">
							<!-- 第二级 -->
							<?php 
								if (!empty($val['lower'])) {
									foreach($val['lower'] as $k =>$v) {
										if ($v['name'] == '管家列表') {
echo '<li><a href="'.$v['url'].'" target="main" ><span class="menu-text">'.$v['name'].'</span><span style="color:red;padding-left:5px;">('.$expertCount.')</span></a></li>';
										} 
										elseif ($v['name'] == '供应商列表') {
echo '<li><a href="'.$v['url'].'" target="main" ><span class="menu-text">'.$v['name'].'</span><span style="color:red;padding-left:5px;">('.$supplierCount.')</span></a></li>';
										} 
										else {
											echo '<li><a href="'.$v['url'].'" target="main" ><span class="menu-text">'.$v['name'].'</span></a></li>';
										}
										
									}
								}
								?>
							</ul>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
            <!-- /Page Sidebar -->
			<iframe name="main" id="main"></iframe>
		</div>
	</div>
	<!-- /Main Container -->
	<!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
	<script src="/assets/js/skins.min.js"></script>
	<!--Basic Scripts-->
	<script src="/assets/js/bootstrap.min.js"></script>
	<!--Beyond Scripts-->
	<script src="/assets/js/beyond.min.js"></script>
	<script src="/assets/js/backend/b2backend.js"></script>
	<script src="/assets/js/xiuxiu/xiuxiu.js"></script>
<script>
$('.change_avatar').click(function(){
		$('.avatar_box').show();
		
	   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
		xiuxiu.embedSWF("altContent",5);
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('admin/upload/a_upload_photo'); ?>");
	        xiuxiu.setUploadType(2);
	        xiuxiu.setUploadDataFieldName("upload_file");
		xiuxiu.onInit = function ()
		{
			//默认图片
			xiuxiu.loadPhoto("/assets/img/default_photo.png");
		}	
		xiuxiu.onUploadResponse = function (data)
		{
			data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		}
		var width = $(window).width();
		
		 $("#xiuxiuEditor").show().css({'top':'29px','left':Math.round(width/2)+'px'});
		 $('.close_xiu').show();
})
$(document).mouseup(function(e) {
    var _con = $('#xiuxiuEditor'); // 设置目标区域
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $("#xiuxiuEditor").hide()
        $('.avatar_box').hide();
        $('.close_xiu').hide();
    }
})
$('.close_xiu').click(function(){
	 $("#xiuxiuEditor").hide()
     $('.avatar_box').hide();
     $('.close_xiu').hide();
})
$('.dropdown-footer').click(function(){
	if (confirm('您确定要退出吗？')) {
		location.href="/admin/a/login/logout";
	}
})
	
		$('.nav_list').find('li').click(function(){
			$('.nav_list').find('li').removeClass('active');
			$(this).addClass('active');
		
		});
		$('#refresh').click(function(){
			 document.getElementById('main').contentWindow.location.reload(true);
		});
	
		var height = parseInt($(window).height());
			bheight = height;
			sheight = height - 80;
			$("#sidebar").css("height",sheight);	
			$("body").css({"height":height});
</script>
</body>
</html>