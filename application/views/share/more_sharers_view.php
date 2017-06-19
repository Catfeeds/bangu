<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" /> 
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/share_page.css'); ?>" rel="stylesheet" />
<title>分享达人</title>
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>
</head>
<style>
.page_nav{float: right;margin-top:35px;padding:0px 8px 30px;}
.page_nav li{list-style: none;float: left;border: 1px solid #d3d3d3;height: 25px; line-height:25px;}
.page_nav .page{background-color: #EEE;margin-left: 10px;}
.page_nav .page a { color:#333;display:block;width: 25px;text-align: center;} 
.page_nav .active{background-color:#ffae00;margin-left: 10px; color:#FFF; border: 1px solid #fff;}
.page_nav .total, .page_nav .last, .page_nav .next,.page_nav .lastest{background-color: #EEE;margin-left: 10px;}
.page_nav .active a{ color:#fff;display:block;width: 25px;text-align: center;}
.page_nav .total a, .page_nav .last a, .page_nav .next a, .page_nav .lastest a{display:block;width: 50px;text-align: center;}
.page_nav li:HOVER{background-color:#ffae00;}
.total:hover{ color:#FFF;}
.ajax_page:hover{ color:#FFF;}
</style>
<body>
    <?php $this->load->view('common/header'); ?>
    <div class="page_main">
        <div class="page_title">分享达人</div>
        <div class="page_list">
            <ul>
           	<?php foreach ($share_man as $val){ ?>
                   <li>
                   		<a class="a1"	href="/share/share_detail/personal_share?share_man=<?php echo $val['mid'] ?>" target="_blank"> 
							<img alt="<?php echo $val['truename']; ?>"	src="<?php echo base_url('static'); ?>/img/loading3.gif" data-original="<?php echo $val['litpic']; ?>" />
						</a>
						<div class="drShare_xbox">
							<div class="drShare_name"><?php echo $val['truename']; ?></div>
							<div class="drShare_Number">分享数:<?php echo $val['share_count'];?>条</div>
							<div class="drShare_Popularity">人气:<?php echo $val['share_popularity'];?></div>
						</div>
					</li>
            <?php } ?>
            </ul>
           
        </div>  
         <ul class="page_nav"><?php echo $this->page->create_page(); ?></ul>      
    </div>  
    <?php $this->load->view('common/footer'); ?>
    <script type="text/javascript">
    $(function(){
        $(".eject_box").hide();
        $(".page_list ul li img").mouseover(function(){
            $(".page_list ul li img").css("border","1px solid #ccc");
            $(this).css("border","1px solid #f54");
            $(".page_list ul li span").hide();        });
        $(".close").click(function(){
            $(".eject_box").hide(); 
        });
    }); 
</script>
<script>
	$(function(){
		 $(".page_main img").lazyload({ 
        effect : "fadeIn" 
    });
})
</script>
</body>
</html>