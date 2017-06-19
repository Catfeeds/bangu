<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邀请管家服务_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>"	rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"	href="<?php echo base_url('static/css/user/user.css');?>"	rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
<script type="text/javascript"	src="<?php echo base_url('static/js/eject_sc.js');?>"></script>
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
<div class="user_title">未完成服务</div>
<div class="consulting_warp">
<div class="consulting_tab">
<div class="hd cm_hd clear" style="border:none;">
<style>
.abb{ color: #fff; border-bottom: 2px solid #ffae00 !important; color: #ffae00;}
.fuwu li{ padding: 0 !important;}
.fuwu li a{ display: block; padding: 0 20px; border-bottom: 2px solid #fff;}
</style>
<ul class="click_par fuwu">
<li><a   href="<?php echo base_url('base/invite_service/invite')?>">未完成</a></li>
<li ><a  href="<?php echo base_url('base/invite_service/complete_service')?>" >已完成</a> </li>
<li><a class="abb" href="<?php echo base_url('base/invite_service/refused_service')?>">已拒绝</a></li>
</ul>
</div>

<div class="bd cm_bd">
<!-- tab 切换已点评时的内容 -->
<ul>
<table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                          <thead class="common_thead">
                            <tr>
                              <th width="50" >编号</th>
                              <th width="70">管家昵称</th>
                              <th width="100">邀请服务地址</th>
                              <th width="200">邀请时间</th>
                              <th width="70">服务进度</th>
                              <th width="120">拒绝理由</th>
                            </tr>
                          </thead>
                          <tbody class="common_tbody">
                         <?php if($row){foreach ($row as $k=>$v){?>
                            <tr>
                                <td ><?php echo $v['sr_id']; ?></td>
                                <td><?php echo $v['nickname']; ?></td>
                                <td  class="cg_a" title="<?php echo $v['address']; ?>"><?php echo $str = mb_strimwidth($v['address'], 0,28, '...', 'utf8'); ?></td>
                                <td ><?php echo  $v['addtime']?></td>
                                <td >已拒绝 </td>
                                <td class="refuse_text" style="position: relative;width:30px;height:30px;line-height:18px;cursor: pointer;">
                                <?php echo  $str = mb_strimwidth($v['refuse'], 0,25, '...', 'utf8'); ?>
	                                <div class="info_text" id="info_text" style="width:260px;text-align:left;border:2px solid #aaa;line-height:28px;background:#fff;z-index:1;position:absolute;right:40px;top:15px;display:none;max-height:185px;overflow-y:auto;">
									<p><?php if(!empty( $v['refuse'])){ echo  $v['refuse'];}else{echo '暂无';}  ?></p>
	
									</div>
                                </td>
                            </tr>
						<?php } }else{?>
                            <!-- 以下是没有订单时的状态 -->
                            <tr>
                                  <td class="order_list_active" colspan="5">
                                        <p class="cow-title">您最近没有邀请管家服务记录！</p>
                                   </td>
                            </tr>
                      <?php }?>
                          </tbody>
                        </table>
	<div class="pagination">
	<ul class="page"><?php if(!empty($row)){ echo $this->page->create_c_page();}?></ul>
	</div>
</ul>
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

$(document).on('mouseover', '.refuse_text', function(){
	$(this).find(".info_text").show();
})
$(document).on('mouseout', '.refuse_text', function(){
	$(".info_text").hide();
});
</script>

