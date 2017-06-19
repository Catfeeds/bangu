<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $web['title']?></title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="../../static/css/common.css" rel="stylesheet" type="text/css">
<link href="../../static/css/diy.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../../static/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body style=" background: #f3f3f3;">
<?php $this -> load -> view('common/header'); ?>
<div class="father_container clear   success_bg" style="margin-bottom:-150px;">
    <div class="container" style="padding-top:100px; padding-bottom:200px;" >
        <div class="success_nav">
            <div class="success_top">您的定制信息已提交，我们的旅游管家会尽快与您联系！</div>
            <?php 
            	if($this ->session ->userdata('new_member')):
            ?>
            <div class="become_vip">您已成为帮游会员，请至会员中心查询后续信息。</div>
            <?php endif;?>
            <div class="success_body">
                <div class="dingzhi_box">我的定制信息</div>
                <div class="dingzhi_list_title">您想去哪玩儿</div>
                <ul>
                    <li><span>出发地点：</span><i><?php echo $cityname?></i></li>
                    <li><span class="tan3">目的地:</span><i><?php echo $destName; ?></i></li>
                    <li><span>出游方式：</span><i><?php echo $trip_way; ?></i></li>
                    <?php if(!empty($another_choose)):?>
                    <li><span>多项服务：</span><i><?php echo $another_choose; ?></i></li>
                    <?php endif;?>
                </ul>
                <div class="dingzhi_list_title">您有什么定制要求</div>
                <ul>
                    <?php if (!empty($startdate)):?>
                    <li><span>出发时间 :</span><i><?php echo $startdate; ?></i></li>
                    <?php else: ?>
                    <li><span>出发时间:</span><i><?php echo $estimatedate; ?></i></li>
                    <?php endif; ?>
                    <li><span>希望人均预算：</span><i><?php echo $budget; ?></i></li>
                    <li><span>希望出游时长：</span><i><?php echo $days; ?></i></li>
                    <li><span>酒店要求：</span><i><?php echo $hotelstar; ?></i></li>
                    <li><span>用房要求：</span><i><?php echo $room_require; ?></i></li>
                    <li><span>要求用餐：</span><i><?php echo $catering; ?></i></li>
                    <li><span>自费购物：</span><i><?php echo $isshopping; ?></i></li>
                    
                </ul>   
                <div class="Details_stated"><span>详情需求表述&nbsp;:&nbsp;</span><i><?php echo empty($service_range) ?'无':$service_range?></i></div>    
                <div class="dingzhi_list_title">您有什么定制要求</div>
                <ul>
                    <li><span class="tan3">总人数:</span><i><?php echo $total_people; ?></i></li>
                    <li><span class="tan3">用房数:</span><i><?php echo $roomnum; ?></i></li>
                    <li class="relative_top"><span>成<div class="space"></div>人:</span><i class="padd_left"><?php echo $people; ?></i></li>
                    <li><span>占床儿童：</span><i><?php echo $childnum; ?></i></li>
                    <li><span>不占床儿童：</span><i><?php echo $childnobednum; ?></i></li>
                    <li class="relative_top"><span>老<div class="space"></div>人:</span><i class="padd_left"><?php echo $oldman; ?></i></li>
                    <li><span class="tan3">联系人:</span><i><?php echo $linkname; ?></i></li>
                    <li><span class="tan3">微信号:</span><i><?php echo $linkweixin; ?></i></li>
                    <li><span class="tan3">手机号:</span><i><?php echo $linkphone; ?></i></li>
                </ul>   
            </div> 
            <div class="success_bottom fr">
                <a class="success_a" href="<?php echo sys_constant::INDEX_URL?>">返回首页</a>
                <a href="<?php echo site_url('base/member/mycustom')?>">我的定制单</a>
            </div>
        </div>
    </div>
</div>
<?php  echo $this -> load -> view('common/footer'); ?> 
</body>
</html>  

