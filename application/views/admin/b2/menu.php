<?php
$set_url= $this->uri->segment (3, 0);
$sub_url= $this->uri->segment (4, 0);

# 业务 模块导航
$business_arr = array(
		 array(site_url('admin/b2/order/index'),'我的订单','order'),
                        array(site_url('admin/b2/line_package/index'),'定制线路','line_package'),
		 array(site_url('/admin/b2/line_apply/index'),'售卖级别','line_apply'),
                        //array(site_url('admin/b2/line_grade/index'),'查看售卖级别','line_grade'),
		 array(site_url('admin/b2/grab_custom_order/index'),'定制抢单','grab_custom_order'),
		 array(site_url('admin/b2/inquiry_sheet/index'),'询价供应商','inquiry_sheet'),
		 array(site_url('admin/b2/refund/index'),'退款申请','refund'),
		 array(site_url('admin/b2/expert/account'),'我的账户','account'),
		 array(site_url('admin/b2/order/exiu'),'我的场景秀','exiu')
		 );
//array(site_url('b2/dest_apply/index'),'目的地申请'),

# 客户管理 模块导航
$cus_mg_arr = array(
		array(site_url('admin/b2/expert/customer'),'我的客户','customer'),
		array(site_url('admin/b2/complain/index'),'投诉维权','complain'),
		array(site_url('admin/b2/comment/index'),'客人点评','comment'),
		array(site_url('admin/b2/question/index'),'客人问答','question')
);


# 个人设置 模块导航

$setting_arr = array(
        array(site_url('admin/b2/essay/index'),'海外代购','essay'),
        array(site_url('admin/b2/travel/index'),'个人游记','travel'),
		array(site_url('admin/b2/opportunity/index'),'学习机会','opportunity'),
		array(site_url('admin/b2/upgrade/index'),'管家升级','upgrade'),
		array(site_url('admin/b2/expert/update'),'基本资料','update'),
		array(site_url('admin/b2/expert/security'),'安全中心','security'),
		array(site_url('admin/b2/expert/template'),'个性模板','template')
);
if($statis_msg['sum_msg']!=0){
    array_unshift($setting_arr,array(site_url('admin/b2/message/index'),'消息通知'."  <span style='color:#FF0000'>(".$statis_msg['sum_msg'].")</span>",'message'));
}else{
    array_unshift($setting_arr,array(site_url('admin/b2/message/index'),'消息通知','message'));
}
?>
<ul class="nav sidebar-menu">
                    <!--Dashboard-->
                    <li>
                        <a href="<?php echo site_url('admin/b2/home')?>">
                            <i class="menu-icon glyphicon glyphicon-home"></i>
                            <span class="menu-text">主页</span>
                        </a>
                    </li>
                    <li class="open">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-align-right"></i>
                            <span class="menu-text">业务平台</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                         <?php foreach ($business_arr as $item): ?>
                            <li <?php if(!empty($set_url)){ if($set_url=='expert'){ if($sub_url==$item[2]){ echo 'class="active"';}}else{ if($set_url==$item[2]){ echo 'class="active"';} }} ?>>
                                <a href="<?php echo $item[0];?>">
                                    <span class="menu-text"><?php echo $item[1];?></span>

                                </a>
                            </li>
                            <?php endforeach;?>

                        </ul>
                    </li>
                </ul>

<ul class="nav sidebar-menu">
                    <!--Dashboard-->

                    <li class="open">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-align-right"></i>
                            <span class="menu-text">客户管理</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                         <?php foreach ($cus_mg_arr as $item): ?>
                            <li <?php if(!empty($set_url)){ if($set_url=='expert'){ if($sub_url==$item[2]){ echo 'class="active"';}}else{ if($set_url==$item[2]){ echo 'class="active"';} }} ?>>
                                <a href="<?php echo $item[0];?>">
                                    <span class="menu-text"><?php echo $item[1];?></span>

                                </a>
                            </li>
                            <?php endforeach;?>

                        </ul>
                    </li>
                </ul>

<ul class="nav sidebar-menu">
                    <!--Dashboard-->

                    <li class="open">
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-align-right"></i>
                            <span class="menu-text">个人设置</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                         <?php foreach ($setting_arr as $item): ?>
                            <li <?php if(!empty($set_url)){ if($set_url=='expert'){ if($sub_url==$item[2]){ echo 'class="active"';}}else{ if($set_url==$item[2]){ echo 'class="active"';} }} ?>>
                                <a href="<?php echo $item[0];?>">
                                    <span class="menu-text"><?php echo $item[1];?></span>
                                </a>
                            </li>
                            <?php endforeach;?>

                        </ul>
                    </li>
                </ul>
