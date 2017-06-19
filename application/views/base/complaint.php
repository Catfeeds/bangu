<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>投诉维权</title>
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
				<div class="user_title"  >投诉维权</div>
				<div class="consulting_warp activist_warp">
					<div class="consulting_tab">
						<div class="hd cm_hd clear">
							<ul>
								<li
									<?php if(!empty($tyle) && $tyle=='nodid'){ echo 'class="on"';} ?>><a
									href="<?php echo base_url('base/customer_service/complaint'); ?>">待处理（<span
										class="link_green"><?php if(isset($noid[0]['num'])){echo $noid[0]['num'] ;}else{ echo 0;}?></span>）
								</a></li>
								<li
									<?php if(!empty($tyle) && $tyle=='did'){ echo 'class="on"';} ?>><a
									href="<?php echo base_url('base/customer_service/deal_complaint'); ?>">已处理（<span
										class="link_green"><?php if(isset($did[0]['num'])){echo $did[0]['num'] ; }else{ echo 0;}?></span>）
								</a></li>
							</ul>
						</div>
						<div class="bd cm_bd">
							<!-- tab 切换待处理时的内容 -->
								<table class="common-table" style="position: relative;"
									border="0" cellpadding="0" cellspacing="0">
									<thead class="common_thead">
										<tr>
											<th width="120">订单编号</th>
											<th width="160"><span class="td_left">投诉时间</span></th>
											<th width="240">投诉内容</th>
											<th width="180">产品名称</th>
											<th width="80">投诉对象</th>
											<th width="80">状态</th>
											<th width="100">联系电话</th>
											<th width="100">回复</th>

										</tr>
									</thead>
									<tbody class="common_tbody">
										<?php
										if (! empty ( $complaint )) {
											foreach ( $complaint as $key => $val ) {
												?>
										<tr>
											<td><?php echo $val['ordersn']; ?></td>
											<td><span class="td_left"><?php echo $val['addtime']; ?></span></td>
											<td class="reason_td" style="position: relative;width:30px;height:30px;line-height:18px;cursor: pointer;">
											   <?php echo  $str = mb_strimwidth($val['reason'], 0,25, '...', 'utf8'); ?>
											   <div class="reason_text" id="info_text" style="width:260px;text-align:left;border:2px solid #aaa;line-height:28px;background:#fff;z-index:1;position:absolute;right:100px;top:15px;display:none;max-height:185px;overflow-y:auto;">
													<p><?php if(!empty($val['reason'])){ echo $val['reason'];}else{echo '暂无';}  ?></p>
												</div>
											</td>
											<td class="product_title"><a
												title="<?php echo $val['productname']; ?>"
                                                                                                <!-- 将cj,gn改为line,添加后缀.html-->
												href="<?php echo in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; ?>"
												target="_blank"><?php echo  $str = mb_strimwidth($val['productname'], 0,25, '...', 'utf8'); ?></a></td>

											<!--  <td><?php echo $val['realname']; ?></td>-->
											<td>
											 <?php if(!empty($val['complain_type'])){
											 	$name=explode(',', $val['complain_type']);
											 	foreach ($name as $k=>$v){
											 		if($v==2){
											 			 echo '供应商';
											 		}else if($v==1){
											 			 echo '专家,';
											 		}
											 	}											 	
											 } ?>
											</td>
											<td><?php if($val['status']==0){echo "未处理";}elseif($val['status']==1){ echo '已处理';} ?></td>
											<td><?php echo $val['mobile']; ?></td>
											<td class="title_text" style="position: relative;width:30px;height:30px;line-height:18px;cursor: pointer;"><?php echo  $str = mb_strimwidth($val['remark'], 0,15, '...', 'utf8'); ?>
													<div class="info_text" id="info_text" style="width:260px;text-align:left;border:2px solid #aaa;line-height:28px;background:#fff;z-index:1;position:absolute;right:40px;top:15px;display:none;max-height:185px;overflow-y:auto;">
													<p>平台回复:<?php if(!empty($val['remark'])){ echo $val['remark'];}else{echo '暂无';}  ?></p>
													<p>供应商回复:<?php  if(!empty($val['supplier_reply'])){ echo $val['supplier_reply'];}else{ echo '暂无';} ?></p>	
												</div>
											</td>
										</tr>
										<?php }}else{?>
										<!-- 以下是没有点评记录时的状态 -->
										<?php if($tyle=='nodid'){ ?>
										<tr>
											<td class="order_list_active" colspan="7">
												<p class="cow-title">您最近没有待处理记录！</p>
											</td>
										</tr>
										<?php }elseif($tyle=='did'){ ?>
										<tr>
											<td class="order_list_active" colspan="7">
												<p class="cow-title">您最近没有已处理记录！</p>
											</td>
										</tr>
									<?php }}?>
									</tbody>
								</table>
								<div class="pagination">
									<ul class="page"><?php if(!empty($complaint)){echo $this->page->create_c_page();}?></ul>
								</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 右侧菜单结束 -->
		</div>
	</div>

	<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
</body>
</html>
<script type="text/javascript">

$(document).on('mouseover', '.title_text', function(){
	$(this).find(".info_text").show();
})
$(document).on('mouseout', '.title_text', function(){
	$(".info_text").hide();
});
$(document).on('mouseover', '.reason_td', function(){
	$(this).find(".reason_text").show();
})
$(document).on('mouseout', '.reason_td', function(){
	$(".reason_text").hide();
});


</script>

