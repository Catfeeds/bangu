
<title>我的咨询</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/user/user.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>

</head>
<body>
	<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<div id="user-wrapper">
		<div class="container clear">
			<!--左侧菜单开始-->
<?php $this->load->view('common/user_aside');  ?>
<!--左侧菜单结束-->
			<!-- 右侧菜单开始 -->
			<div class="nav_right" style="min-height:645px">
				<div class="user_title">我的咨询</div>
				<div class="consulting_warp">
					<div class="consulting_tab">
						<div class="hd cm_hd clear">
							<ul>
								<li
									<?php if(!empty($tyle) && $tyle=='index'){ echo 'class="on"';} ?>><a
									href='<?php echo base_url(); ?>base/customer_service'>已回复（<span
										class="link_green"><?php if(!empty($did)){ echo $did; }else{ echo 0;}?></span>）
								</a></li>
								<li
									<?php if(!empty($tyle) && $tyle=='nod_server'){ echo 'class="on"';} ?>><a
									href='<?php echo base_url(); ?>base/customer_service/nodid'>未回复（<span
										class="link_green"><?php if(!empty($noid)){ echo $noid;}else{ echo 0;} ?></span>）
								</a></li>
							</ul>
						</div>
						<div class="bd cm_bd">
							<!-- tab 切换已回复时的内容 -->
							<ul>
								<table class="common-table" style="position: relative;" border="0" cellpadding="0" cellspacing="0">
									<thead class="common_thead">
										<tr>
											<th width="200"><span class="td_left">产品信息</span></th>
											<th width="150">最新时间</th>
											<th width="200">咨询内容</th>
											<th width="100">咨询对象</th>
											<th width="200">回复内容</th>
											<!-- 	<th width="80">操作</th>  -->
										</tr>
									</thead>
									<tbody class="common_tbody">
										<?php
										if (! empty ( $consulting )) {
											foreach ( $consulting as $k => $v ) {
												?>
										<tr class="tr">
											<td>
                                                                                            <!-- 将cj,gn改为line,添加后缀.html-->
											<span class="td_left"><a href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html'; ?>" target="_blank" title="<?php echo $v['linename'];?>"> <?php echo  $str = mb_strimwidth($v['linename'], 0,34, '...', 'utf8'); ?></a></span>
											</td>
											<td><?php echo $v['addtime']; ?></td>
											<td class="content_td" style="position: relative;width:30px;height:30px;line-height:18px;cursor: pointer;"><?php echo  $str = mb_strimwidth($v['content'], 0,20, '...', 'utf8'); ?>
												<div class="content_text" id="content_text" style="width:250px;text-align:left;border:2px solid #aaa;background:#fff;z-index:1;position:absolute;right:100px;top:15px;display:none;max-height:185px;line-height:28px;overflow-y:auto;">
													<p><?php if(!empty($v['content'])){ echo $v['content'];}else{echo '暂无';}  ?></p>	
												</div>
											</td>
											<td><?php if($v['expert_id']>0){ ?><?php echo $v['title']; ?>/<?php echo $v['nickname']; ?><?php } ?></td>
											<td title="<?php echo $v['replycontent']; ?>"><?php echo  $str = mb_strimwidth($v['replycontent'], 0,35, '...', 'utf8'); ?></td>

										</tr>
										<?php }}else{?>
										<!-- 以下是没有点评记录时的状态 -->
										<?php if($tyle=='did'){ ?>
										<tr>
											<td class="order_list_active" colspan="5">
												<p class="cow-title">您最近没有已回复记录！</p>
											</td>
										</tr>
										<?php }elseif($tyle=='nodid'){ ?>
										<tr>
											<td class="order_list_active" colspan="5">
												<p class="cow-title">您最近没有未回复记录！</p>
											</td>
										</tr>
									<?php }}?>
									</tbody>
								</table>

							
							</ul>
								<div class="pagination">
									<ul class="page"><?php  if(!empty($consulting)){ echo $this->page->create_c_page();}?></ul>
								</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 右侧菜单结束 -->
		</div>
	</div>
	</div>

<?php $this->load->view('common/footer'); ?>
</body>
</html>
<script type="text/javascript">
$(document).on('mouseover', '.content_td', function(){
	$(this).find(".content_text").show();
})
$(document).on('mouseout', '.content_td', function(){
	$(".content_text").hide();
});
</script>


