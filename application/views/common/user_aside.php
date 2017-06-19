<!--左侧菜单开始-->
<?php
$url= $this->uri->segment (2, 0);
$url0= $this->uri->segment (3, 0);
//$this->load->model( 'member_model', 'member');

//启用session
/* $this->load->library('session');
$userid=$this->session->userdata('c_userid');
$where_re['memberid']=$userid;
$where_re['status >=']=5;
$res=$this->member->get_data('u_member_order',$where_re); */
?>

<!-- 隐藏菜单图片 在后面加了  style=" background: none" -->
<div class="aside">
	<div id="asideInner" class="aside_inner">
		<div class="mc">
			<dl style="" id="user_nav_1">
				<dt>
					<i class="user_icon icon_order" style=" background: none"></i>会员中心<b></b>
				</dt>
				<dd>
				   	<div class="item <?php if(isset($title)&& $title=='首页'){ echo 'cur'; } ?> "  >
						<a href="<?php echo base_url('order_from/order/line_order'); ?>">首页 </a>
					</div>
				   <!--  <div class="item <?php if(!empty($title)&& $title=='我的分享'){ echo 'cur'; } ?> " >
					   <a href="<?php echo base_url('base/member/myshare'); ?>">我的分享 <span
							class="item_tip tip_new"></span></a>
					</div> -->
				    <div class="item <?php if(!empty($title)&& $title=='定制团线路'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/member/group_line'); ?>">定制团线路 </a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='我的定制单'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/member/mycustom'); ?>">我的定制单 </a>
					</div>
					<!--  <div class="item <?php if(!empty($title)&& $title=='我的体验'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/travel/index'); ?>">我的体验</a>
					</div>-->
				    <div class="item <?php if(!empty($title)&& $title=='我的发票'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/member/invoice'); ?>">我的发票 </a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='我的积分'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/member/integral'); ?>">我的积分 </a>
					</div>
                    <!--  收藏 管家 -->
					<div class="item <?php if(!empty($title)&& $title=='管家收藏'){echo 'cur';} ?>" >
						<a  href="<?php echo base_url('base/member/collect_expert'); ?>">管家收藏 </a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='管家服务'){echo 'cur';} ?>" >
						<a  href="<?php echo base_url('base/invite_service/invite'); ?>">管家服务 </a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='线路收藏'){ echo 'cur'; } ?>" >
						<a href="<?php echo base_url('base/member/collect'); ?>">线路收藏</a>
					</div>
				</dd>
			</dl>
			<dl style="" id="user_nav_2">
				<dt class="">
					<i class="user_icon icon_member" style=" background: none"></i><a class="a_url"
						href="<?php echo base_url('base/travel/index'); ?>">我的体验</a>
				</dt>
				<dd></dd>
			</dl>
			<dl style="" id="user_nav_3">
				<dt>
					<i class="user_icon icon_personal" style=" background: none"></i>我的资料<b></b>
				</dt>
				<dd>
					<div class="item <?php if(!empty($title)&& $title=='基本资料'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/member/profile'); ?>">基本资料 </a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='修改密码'){echo 'cur';} ?>">
						<a href="<?php echo base_url('base/member/updata_password'); ?>">修改密码</a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='通知消息'){echo 'cur';} ?>" >
						<a href="<?php echo base_url('base/system/message'); ?>">通知消息</a>
					</div>

				</dd>
			</dl>
			<dl style="" id="user_nav_4">
				<dt class="">
					<i class="user_icon icon_member" style=" background: none"></i><a class="a_url"
						href="<?php echo base_url('base/member/comment'); ?>">我的评价</a>
				</dt>
				<dd></dd>
			</dl>
			<dl style="" id="user_nav_5">
				<dt>
					<i class="user_icon icon_community" style=" background: none"></i>客服中心<b></b>
				</dt>
				<dd>
					<div class="item <?php if(!empty($title)&& $title=='我的咨询'){echo 'cur';} ?>">
						<a href="<?php echo base_url('base/customer_service'); ?>">我的咨询 </a>
					</div>
					<div class="item <?php if(!empty($title)&& $title=='投诉维权'){echo 'cur';} ?>">
						<a href="<?php echo base_url('base/customer_service/complaint'); ?>">投诉维权</a>
					</div>

				</dd>
			</dl>
            <?php if(!empty($res) && count($res)>0){ ?>
        <!--   <dl style="" id="user_nav_5">
				<dt class="">
					<i class="user_icon icon_experience"></i><a class="a_url"
						href="<?php echo base_url('base/customer_service/experience_architect'); ?>">体验师申请</a>
				</dt>
				<dd></dd>
			</dl> -->
            <?php } ?>
			<dl style="" id="user_nav_6">
				<dt class="">
					<i class="user_icon icon_money" style=" background: none"></i><a class="a_url"
						href="<?php echo base_url('base/coupon/coupon_used_0_1.html'); ?>">我的优惠券</a>
				</dt>
				<dd></dd>
			</dl>
            <dl style="" id="user_nav_7">
				<dt class="">
					<i class="user_icon icon_gift" style=" background: none"></i><a class="a_url"
						href="<?php echo base_url('base/gift/gift_list'); ?>">我的礼品</a>
				</dt>
				<dd></dd>
			</dl>
		</div>
	</div>
</div>

<!--左侧菜单结束-->
