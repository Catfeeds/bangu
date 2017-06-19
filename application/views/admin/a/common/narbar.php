<div class="navbar" style="height:80px;" >
	<div class="navbar-inner" style="height:82px;">
		<div class="navbar-container">
			<!-- Navbar Barnd -->
			<div class="navbar-header pull-left">
				<a href="<?php echo base_url();?>" class="navbar-brand" style="line-height:35px;"><img src="../../../../static/img/logo.png" />
				</a>
			</div>
			<!-- /Navbar Barnd -->
			<!-- Account Area and Settings --->
			<div class="navbar-header pull-right">
				<div class="navbar-account">
					<ul class="account-area">
						<li><a class="login-area dropdown-toggle" data-toggle="dropdown" style="padding-top:10px;">
								<div class="avatar" title="View your public profile">
									<img src="<?php echo $this ->session ->userdata('a_photo'); ?>">
								</div>
								<section>
									<h2>
										<span class="profile"><span style="font-size:14px; color:#fff;"><?php echo $username; ?></span></span>
									</h2>
								</section>
						</a> <!--Login Area Dropdown-->
							<ul
								class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
								<li class="username"><a><?php echo $username; ?></a></li>
								<!--Avatar Area-->
								<li>
									<div class="avatar-area">
										<img src="<?php echo $this ->session ->userdata('a_photo');?>" class="avatar">
										<span class="caption change_avatar">更换头像</span>
									</div>
								</li>
								 
								<!--Avatar Area-->
								<li class="edit"><a href="<?php echo site_url('admin/a/per_list/perivi_list');?>"  target='main' class="pull-left">个人中心</a>
									<a href="#" class="pull-right">设置</a></li>								
								<li class="dropdown-footer"><a href="javascript:void(0);">注销</a>
								</li>
							</ul> <!--/Login Area Dropdown--></li>
						<!-- /Account Area -->	
						<br>
						<li><a href="<?php echo $eqixiu_url ?>/adminc.php" target="_blank" style="margin: 5px 0px 0px 20px;font-size: 14px;">场景秀管理</a></li>					
					</ul>					
					<!-- Settings -->
				</div>
			</div>
			<!-- /Account Area and Settings -->
		</div>
	</div>
</div>
<!--  -->
<div class='avatar_box'></div>
<div class='opac_box'></div>
<div id="altContent"></div>
<div class="close_xiu" style="">X</div>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
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
			 $("#xiuxiuEditor").show().css({'top':'-60px','left':'20px'});
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
</script>
