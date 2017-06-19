<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的发票_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.SuperSlide.2.1.1.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>

<link type="text/css"href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>

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
    <div class="nav_right" style="position: relative;">
      <div class="consulting_warp">
      		<div class="consulting_tab">
             	<div class="hd cm_hd clear">
                    <ul><a href="#"><li>我的发票</li></a>
                          </ul>
				</div>
				<div class="bd cm_bd">
                    <!-- tab 切换制作中的内容 -->
                    <ul>
                        <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                          <thead class="common_thead">
                            <tr>
                              <th width="70" >订单编号</th>
                              <th width="100"><span>发票抬头</span></th>
                              <th width="70">收件人</th>
                              <th width="200">发票明细 </th>
                               <th width="200">详细地址 </th>
                              <th width="120">手机</th>
                              <th width="80">金额 </th>


                            </tr>
                          </thead>
                          <tbody class="common_tbody">
                         <?php if($row){
							foreach ($row as $k=>$v){
                         	?>
                            <tr>
                                <td ><a class="line_title fl "  href="<?php echo base_url('/order_from/order/show_order_message_'.$v['order_id'].'.html')?>"target="_blank"><?php echo $v['ordersn']; ?></a></td>
                                <td><?php echo $v['invoice_name']; ?></td>
                                <td  class="cg_a" title="<?php echo $v['receiver']; ?>"><?php echo $str = mb_strimwidth($v['receiver'], 0,28, '...', 'utf8'); ?></td>
                                <td ><span class="td_left" title="<?php echo $v['invoice_detail']; ?>"><?php echo  $str = mb_strimwidth($v['invoice_detail'], 0,45, '...', 'utf8'); ?></span></td>
                                  <td ><span class="td_left" title="<?php echo $v['address']; ?>"><?php echo  $str = mb_strimwidth($v['address'], 0,45, '...', 'utf8'); ?></span></td>
                           		<td><?php echo  $v['telephone']; ?></td>
                           		<td class="product_title"><?php echo  $v['total_price']; ?></td>
                            </tr>
						<?php } }else{?>
                            <!-- 以下是没有订单时的状态 -->
                            <tr>
                                  <td class="order_list_active" colspan="5">
                                        <p class="cow-title">您最近没有发票记录！</p>
                                   </td>
                            </tr>
                      <?php }?>
                          </tbody>
                        </table>
                        <div class="pagination">
							<ul class="page"><?php if(!empty($row)){echo $this->page->create_c_page();}?></ul>
						</div>
                    </ul>

            </div>
                    </ul>
				</div>
            </div>
             <!-- 弹出页面 -->
             <!-- 弹出制作中页面 -->
	         <div id="order_plan" style="display: none; width:600px; height:550px;">
		       <!-- ajax 返回的数据 -->
	         </div>
             <!-- end -->
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



</script>