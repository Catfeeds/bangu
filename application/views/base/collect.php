<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>线路收藏_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
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
		<div class="nav_right">
			<div class="user_title">线路收藏</div>
				<div class="consulting_warp activist_warp">
					<div class="consulting_tab">
						<div class="hd cm_hd clear">
							<ul>
								<li 
									<?php if(!empty($tyle) && $tyle=='nodid'){ echo 'class="on"';} ?>>我的收藏（<span class="link_green"><?php if(isset($row)){echo count($row) ;}else{ echo 0;}?></span>）
								</li>
							</ul>
						</div>
						<div class="bd cm_bd">
						<!-- tab 切换待处理时的内容 -->
								<table class="common-table" style="position: relative;" border="0" cellpadding="0" cellspacing="0">
									<thead class="common_thead">
										<tr>
											<th width="40"><span class="td_left">编号</span></th>
											<th width="180">产品名称</th>
											<!--<th width="80">供应商</th> -->
											<th width="80">收藏时间</th>
										</tr>
									</thead>
									<tbody class="common_tbody" class="clear">
										<?php if(!empty($row)){ ?>
										<?php foreach ($row as $k=>$v){ ?>
										<tr>
											<td>
												<span class="td_left"><?php echo $v['id']; ?></span>
											</td>
											<td class="product_title">
                                                                                            <!-- 将cj,gn改为line,添加后缀.html-->
												<a class="fl" href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html'; ?>" title="<?php echo  $v['linename'];?>" target="_blank"><?php echo  $str = mb_strimwidth($v['linename'], 0,80, '...', 'utf8'); ?></a>
											</td>
										<!--<td ><p class="td_left" title="<?php echo $v['nickname']; ?>"><?php echo  $str = mb_strimwidth($v['nickname'], 0,35, '...', 'utf8'); ?></p></td> -->
											<td><?php echo $v['addtime']; ?></td>

										</tr>
										<?php }?>
										<?php }else{?>
										<!-- 以下是没有点评记录时的状态 -->
										<tr>
											<td class="order_list_active" colspan="7">
												<p class="cow-title">您最近没有收藏记录！</p>
											</td>
										</tr>
									<?php }?>
									</tbody>
								</table>
								<div class="pagination">
									<ul class="page"><?php if(!empty($row)){echo $this->page->create_c_page();}?></ul>
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


