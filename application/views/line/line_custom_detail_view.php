<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $expert_line['question']?>_定制旅游线路-帮游旅行网</title>
<meta name="description" content="帮游旅游网数万名资深旅游管家为您和公司量身定制优质而个性的<?php echo $expert_line['question']; ?>，为您提供定制旅游线路、景点、价格、攻略等全面而有个性的定制旅游服务" />
<meta name="keywords" content="定制游线路,私人定制游,高端定制游,<?php echo $expert_line['question']; ?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static'); ?>/css/diy.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
<!-- 内容区 -->
<?php $this->load->view('common/header'); ?>
<div class="father_container clear">
    <div class="container w_1200">
        <!--<div class="custom_column"> <span><a href="<?php echo sys_constant::INDEX_URL?>">首页</a></span> <span>></span> <span> <a href="<?php echo base_url('dzy')?>">定制列表</a></span> <span>></span> <span> <a href="">定制详情</a></span> </div> -->
        <div class="place">
			<span>您的位置：</span>
			<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>
			<span class="_jiantou">></span>
			<a href="<?php echo base_url('dzy')?>">定制列表</a>
			<span class="_jiantou">></span>
			<h1><a href="#">定制详情</a></h1>
		</div>
        <div class="custom_details_head clear">
            <div style="position:relative;"> <img class="head_bg" src="<?php echo $expert_line['c_pic']?>">
                <div class="head_cover">
                    <p class="cover_1"><?php echo $expert_line['question']?> </p>
                    <div  class=" zj_detail"> <img src="<?php echo $expert_line['small_photo']?>">
                        <div class="detail_wz">
                            <div> <span>发表时间 :</span>&nbsp; <span><?php echo $expert_line['addtime']?></span> </div>
                            <div class="detail_name"> <span><?php echo $expert_line['expert_name']?></span>
                                <p class="name_1"><span>年销人数 :</span> &nbsp; <i><?php echo $expert_line['people_count']?></i></p>
                                <p class="name_2"><span>年总积分 :</span> &nbsp; <i><?php echo $expert_line['total_score']?></i></p>
                            </div>
                            <div class="detail_gj"> <span><?php echo $expert_line['e_grade']?></span>
                                <p class="name_3"><span>擅长目的地 :</span> &nbsp;<i><?php echo $expert_line['good_dest']?></i></p>
                            </div>
                        </div>
                        <span  class=" detail_money">￥<?php echo $expert_line['budget']?>/人</span> </div>
                </div>
            </div>
        </div>
        <div class="details_survey ">
            <div class="title ">
                <p>行程概况</p>
            </div>
        </div>
        <div class="details_list clear">
            <?php if(!empty($custom_data)):?>
            <?php foreach ($custom_data as $item):?>
            <div class="list_1 list_2">
                <div class="list_day_1"> <i></i> <span class="day ">第<?php echo $item['day'];?>天</span>
                    <div  class="round_kj"> <span class="round"></span> </div>
                </div>
                <div class="nr_1">
                    <div class="details_list_nr_1 details_list_nr_2 clear">
                        <p class="place seees"><?php echo $item['title'];?></p>
                        <p class="trip"> <span>行程：</span> </p>
                        <div class="trip_w"><?php echo $item['jieshao'];?></div>
                        <div class="img_list" >
                            <ul>
                                <?php if(!empty($item['trip_pic_arr'])):?>
                                <?php foreach ($item['trip_pic_arr'] as $pic):?>
                                <li> <img src="<?php echo $pic;?>"> </li>
                                <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>
<?php  echo $this->load->view('common/footer'); ?>
<script type="text/javascript">

</script>