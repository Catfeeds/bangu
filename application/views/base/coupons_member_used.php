<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的优惠券</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.SuperSlide.2.1.1.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>

<link type="text/css"href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
<style>
	.coupon_ka_und{background-color: #ccc;color: #fff;font-weight: bold;margin-top: 10px;position: relative;}
</style>
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
      <div class="user_title">我的优惠券</div>
      <div class="consulting_warp">
      	<div class="consulting_tab">
	            	  <div class="hd cm_hd clear">
	                     <ul>
	                          <!--   <li><a href="<?php echo base_url().'base/coupon'; ?>">全部</a></li>-->
	                          <li class="<?php if(empty($typeid) || $typeid==0){ echo 'on';} ?>"> <a href="<?php echo base_url().'base/coupon/coupon_used_0_1.html'; ?>">未使用(<?php if(!empty($coupon_all)){ echo $coupon_all;}else{ echo 0;} ?>)</a></li>
	                          <li class="<?php if(!empty($typeid)){ if($typeid==1){echo 'on';}} ?>"><a href="<?php echo base_url().'base/coupon/coupon_used_1_1.html'; ?>">已使用(<?php if(!empty($coupon_u_all)){ echo $coupon_u_all;}else{ echo 0;} ?>)</a></li>
	                          <li class="<?php if(!empty($typeid)){ if($typeid==-1){echo 'on';}} ?>"><a href="<?php echo base_url().'base/coupon/coupon_used_2_1.html'; ?>">已过期(<?php if($coupon_o_all){ echo $coupon_o_all;}else{echo 0; } ?>)</a></li>
	             		  </ul>
	                          
	               </div>
				<div class="yhk">
			<?php if(!empty($coupon)){ ?>
                     	   <div class=" had_used clear">
                     	       <!--  <p class="not_used_tt"> 已使用</p> -->
                     	        <dl class="coupon_ka">
                     	        <?php foreach ($coupon as $k=>$v){ ?>
                     	             <dt class="coupon_ka_1">
	                     	   	<div class="coupon_my">
	                     	   		 <div class="money"> 
	                     	   		      <span class=" money_fh">￥</span>
	                     	   		      <span class="money_jq"><?php echo $v['coupon_price']; ?></span>
	                     	   		 </div>
	                     	   		 <div class="coupon_ff">
	                     	   		      <span class="wz">优惠券</span></br>
	                     	   		      <span class="el">coupons</span></br>
	                     	   		      <span class="gk"><?php echo $v['name']; ?></span>
	                     	   		 </div>
	                     	   		 <div class="time">
	                     	   		        <span class="time_1">有效期 :</span>
	                     	   		        <span class="time_2"><?php echo date('Y.m.d', strtotime($v['starttime'])); ?>-<?php echo  date('Y.m.d', strtotime($v['endtime']));?></span>
	                     	   		 </div>
	                     	             </div>
	                     	             <div class="coupon_my_img"> 
	                     	             	  <?php if(empty($typeid) || $typeid==0){ ?>
	                     	             	   <a href="<?php echo $v['use_url']; ?>"> 
	                     	             	   <img src="../../static/img/user/coupon.png">
	                     	             	   </a>
	                     	             	 <?php }else if(!empty($typeid)){ if($typeid==1){?>
	                     	             	   <img src="../../static/img/user/coupon_3.png">
	                     	             	 <?php }else if($typeid==-1){?>
	                     	             	 	<img src="../../static/img/user/coupon_4.png">
	                     	             	 <?php } }?>
	                     	             	 
	                     	             </div>
                                       </dt>  
                                    <?php }?>  
                     	       </dl>
                     	   </div>
          		 <?php }else{ echo '暂无数据';} ?>
          					 <div class="pagination">
							       <ul class="page"><?php if(! empty ( $coupon )){ echo $this->page->create_c_page();}?></ul>
							</div>
                     </div>
				</div>
            </div> 
      </div>
    </div>
    <!-- 右侧菜单结束 --> 
  </div>
<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">
$(function(){
/* 	$(".money_jq").each(function(){
 var thimony=$(this).html();
 //alert(thimony);
 if(thimony==10){
 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
 }if(thimony==20){
 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
 }if(thimony==30){
 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
 }if(thimony==50){
 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
 }if(thimony==100){
 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
 }
}) */
$(".money_jq").each(function(){
	var type='<?php if(!empty($typeid)){echo $typeid;} ?>';
	var thimony=$(this).html();
	if(type==0){             //未使用  
	    //alert(thimony);
	    if(thimony==10){
	    	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_10");
	    }if(thimony==20){
	    	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_20");
	    }if(thimony==30){
	    	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_30");
	    }if(thimony==50){
	    	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_50");
	    }if(thimony==100){
	    	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_100");
	    }
	}else{       //已使用,已过期
		 if(thimony==10){
			 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
			 }if(thimony==20){
			 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
			 }if(thimony==30){
			 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
			 }if(thimony==50){
			 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
			 }if(thimony==100){
			 	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_und");
			 }
	}
})
	$(".money_jq").each(function(){
     var thimony=$(this).html();
     //alert(thimony);
     if(thimony==10){
     	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_10");
     }if(thimony==20){
     	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_20");
     }if(thimony==30){
     	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_30");
     }if(thimony==50){
     	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_50");
     }if(thimony==100){
     	$(this).parent().parent().parent("dt").removeClass("coupon_ka_1").addClass("coupon_ka_100");
     }
	})
	
$(".mc dl dt").removeClass("cur");
$("#user_nav_6 dt").addClass("cur");
})
</script>
</body>

