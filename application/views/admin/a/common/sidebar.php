<?php //print_r($user_rosource);exit(); ?>
<style type="text/css">
	.page-sidebar .sidebar-menu > li > .submenu::before{ left:13px;}
	.page-sidebar .sidebar-menu > li > .submenu > li > a::before{left:11px;}
	.page-sidebar .sidebar-menu .submenu > li > a{padding-left: 18px;}
	.tab-content{margin-bottom:150px;}
</style>

<div class="page-sidebar" id="sidebar" style="overflow: scroll;">
	<!-- Sidebar Menu -->
	<ul class="nav sidebar-menu" data="jia">
		<!-- 第一级 -->
		<?php foreach($nav_list as $key =>$val):?>
			<li class="">
				<a href="<?php echo $val['uri']?>" class="<?php if (!empty($val['lower_nav'])) echo 'menu-dropdown' ;?>" >
					 <i class="menu-icon glyphicon glyphicon-tasks"></i>
					 <span	class="menu-text"><?php echo $val['name']?></span>
					 <i class="menu-expand"></i>
				</a>
				<ul class="submenu nav_list">
				<!-- 第二级 -->
				<?php 
					if (!empty($val['lower_nav'])) {
						foreach($val['lower_nav'] as $k =>$v) {
							echo "<li>";
							if ($v['uri'] == '#'){
								echo "<a href='#' class='menu-dropdown'> <span class='menu-text'>{$v['name']}</span><i class='menu-expand'></i></a>";
							} else {
								echo "<a href='{$v['uri']}' target='main' ><span class='menu-text'>{$v['name']}</span></a>";
							}
							// 第三级 
							if (!empty($v['lower'])) {
								echo '<ul class="submenu">';
								foreach($v['lower'] as $index =>$item) {
									echo "<li><a href='{$item['uri']}'  target='main'><span class='menu-text'>{$item['name']}</span></a></li>";
								}
								echo '</ul>';
							}
							echo "</li>";
						}
					}
					?>
				</ul>
			</li>
		<?php endforeach;?>
	</ul>
</div>


<script>
	$('.nav_list').find('li').click(function(){
		$('.nav_list').find('li').removeClass('active');
		$(this).addClass('active');
	
	});
	$('#refresh').click(function(){
		 document.getElementById('main').contentWindow.location.reload(true);
	});

	var height = parseInt($(window).height());
		bheight = height + 80;
		sheight = height - 80;
		$("#sidebar").css("height",sheight);	
		//$("body").css({"height":bheight,});
		$("body").css({"height":height});
		//$(".sidebar_body").css("height",height)
</script>