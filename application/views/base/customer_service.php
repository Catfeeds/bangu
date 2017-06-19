
<title>我的咨询_会员中心-帮游旅行网</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/user/user.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/webuploader.html5only.min.js');?>"></script>
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
								<table class="common-table" style="position: relative;"
									border="0" cellpadding="0" cellspacing="0">
									<thead class="common_thead">
										<tr>
											<th width="200"><span class="td_left">产品信息</span></th>
											<th width="150">最新时间</th>
											<th width="200">咨询内容</th>
											<th width="100">咨询对象</th>
											<th width="200">回复内容</th>
											<!--  <th width="80">操作</th>-->
										</tr>
									</thead>
									<tbody class="common_tbody">
									<?php
									if (! empty ( $consulting )) {
										foreach ( $consulting as $k => $v ) {
											?>
										<tr class="tr">
											<td><span class="td_left">
                                                                                                <!-- 将cj,gn改为line,添加后缀.html-->
												<a href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html'; ?>" target="_blank" title="<?php echo $v['linename'];?>"> <?php echo  $str = mb_strimwidth($v['linename'], 0,34, '...', 'utf8'); ?></a>
												</span>
											</td>
											<td><?php echo $v['addtime']; ?></td>
											<td class="content_td" style="position: relative;width:30px;height:30px;line-height:18px;cursor: pointer;"><?php echo  $str = mb_strimwidth($v['content'], 0,20, '...', 'utf8'); ?>
												<div class="content_text" id="content_text" style="width:250px;text-align:left;line-height:28px;border:2px solid #aaa;background:#fff;z-index:1;position:absolute;right:100px;top:15px;display:none;max-height:185px;overflow-y:auto;">
													<p><?php if(!empty($v['content'])){ echo $v['content'];}else{echo '暂无';}  ?></p>	
												</div>
											</td>
											<td><?php if($v['expert_id']>0){ ?><?php echo $v['title']; ?>/<?php echo $v['nickname']; ?><?php } ?></td>
											<td class="replycontent_td" style="position: relative;width:30px;height:30px;line-height:18px;cursor: pointer;">
											 <?php echo  $str = mb_strimwidth($v['replycontent'], 0,20, '...', 'utf8'); ?>
												<div class="replycontent_text" id="replycontent_text" style="width:250px;text-align:left;line-height:28px;border:2px solid #aaa;background:#fff;z-index:1;position:absolute;right:100px;top:15px;display:none;max-height:185px;overflow-y:auto;">
													<p><?php if(!empty($v['replycontent'])){ echo $v['replycontent'];}else{echo '暂无';}  ?></p>	
												</div>
											</td>
											<!-- <td><span class="td_left" style="text-align: center;"><a class="replay" href="#replay" data-val="<?php echo $v['id']; ?>" lineid="<?php echo $v['line_id'];?>">回复</a></span>
											</td> -->
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
	<!-- 回复内容 -->
	<div id="replay" style="display: none; width: 500px; height: 230px;">
		<!-- 此处放编辑内容 -->
		<div class="bootbox-body">
			<form class="form-horizontal" role="form" method="post"
				id="customerForm" onsubmit="return checkForm(this)"
				action="<?php echo base_url();?>base/member/save_customer">
				<input type="hidden" name="pid" value="" /> <input type="hidden"
					name="lineid" value="" />
				<textarea class="zuiping" name="content" id="content"
					style="height: 165px"></textarea>
				<span class="tijiao_button fl" style="margin-top: 10px;"><input
					name="go_on" type="submit" value="提交" /></span>
			</form>

		</div>
	</div>
<?php $this->load->view('common/footer'); ?>
</body>
</html>

<script type="text/javascript">
/* 追评评论弹层效果 */
try {
	$(".replay").fancybox();
	$(".replay").click(function() {
		var id= $(this).attr('data-val');
		var lineid= $(this).attr('lineid');
		$('input[name="pid"]').val(id);
		$('input[name="lineid"]').val(lineid);
	});
	} catch (err) {

}
//保存回复
function checkForm(obj){
	var content= $('#content').val();
	var id=$('input[name="pid"]').val();
	if(content==''){
		alert('回复内容不能为空!');
		return false;
	}
	$.post(
		"<?php echo site_url('base/customer_service/save_repaly_customer')?>",
		$('#customerForm').serialize(),
		function(data) {
			data = eval('('+data+')');
			if (data.status == -1) {
				alert(data.msg);
				location.reload();
			} else if(data.status ==1) {
				alert(data.msg);
				location.reload();
			}
		}
	);
	
	return false;

}

$(document).on('mouseover', '.content_td', function(){
	$(this).find(".content_text").show();
})
$(document).on('mouseout', '.content_td', function(){
	$(".content_text").hide();
});
$(document).on('mouseover', '.replycontent_td', function(){
	$(this).find(".replycontent_text").show();
})
$(document).on('mouseout', '.replycontent_td', function(){
	$(".replycontent_text").hide();
});

</script>

