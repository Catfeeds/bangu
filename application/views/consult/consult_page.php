<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if($type==1){?> 
		<title>国内游资讯_出境游资讯_景区资讯_旅游新闻-帮游旅行网</title>
		<meta name="keywords" content="旅游资讯,国内游资讯,交通资讯" />
		<meta name="description" content="帮游旅行网旅游资讯频道为大家提供全面的国内、出境旅游资讯、景区资讯，交通资讯、旅游新闻、旅游知识等旅游信息。" />
	<?php }else{?>
		<title>旅游攻略_国内旅游攻略_出境旅游攻略_2016最新出行指南-帮游旅行网</title>
		<meta name="keywords" content="旅游攻略,出行指南" />
		<meta name="description" content="帮游旅行网旅游资讯频道为大家提供最新最全面的旅游攻略，包括国内旅游攻略和出境旅游攻略，为您的旅程提供专业的出游指南。" />
	<?php }?>
	<link href="../../../static/css/common.css" rel="stylesheet" type="text/css">
	<link href="../../../static/css/information.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
	<script type="text/javascript" src="../../../static/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../../../static/js/jquery.SuperSlide.2.1.1.js"></script>
	<style type="text/css">
	/*ie6*/
	body{text-align: center;margin: 0px auto;}
	body{behavior:url("csshover.htc");}
	</style>
</head>
<body>
        <div>
	   <!-- 头部 -->
	   <?php $this->load->view('common/header'); ?>
	 	<div class="information clear w_1200">
	 		 <div class="informationContext fl">
	 		 	<div class="informationContext_list">
	 		 	           <div class="informationContext_listTitle"><p><?php if(!empty($type)){if($type==2){ echo '最新攻略';}else{echo '资讯列表';}}else{ echo '资讯列表';} ?></p></div>
		 		 	<div class="inf_scenic_list clear" >
		 		 	           <div class="infscenic_center">
			 		 		<div class="infscenic_detalis fl">
			 		 			<div class="detalis_img">
			 		 				 <a href="/lyzx/tours_<?php if(!empty($consult[0])){ echo $consult[0]['id'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 				 <img src="<?php if(!empty($consult[0])){ echo $consult[0]['pic'];}else{ echo 0;} ?>"></a>
			 		 			</div>
			 		 		</div>
			 		 	
			 		 		<div class="detalis_text detalis_text_1 fr">
			 		 			 <p class="detalis_title">
			 		 			 <a title="<?php if(!empty($consult[0]['title'])){echo $consult[0]['title'];} ?>" href="/lyzx/tours_<?php if(!empty($consult[0])){ echo $consult[0]['id'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 			 <?php if(!empty($consult[0]['title'])){echo $consult[0]['title'];} ?>
			 		 			 </a>
			 		 			 </p>
			 		 			 <div class="detalis_intro">
			 		 			<?php if(!empty($consult[0]['content'])){echo mb_strimwidth(strip_tags($consult[0]['content']), 0,250, '...', 'utf8');} ?> 
			 		 			 <a href="/lyzx/tours_<?php if(!empty($consult[0])){ echo $consult[0]['id'];}else{ echo 0;} ?>.html"  target="_blank">...详情>></a>
			 		 			 </div>
			 		 			 <p class="detalis_time"><?php if(!empty($consult[0]['addtime'])){ echo date('Y-m-d', strtotime($consult[0]['addtime']));}?></p>
			 		 		</div>
			 		 	</div>
		 		 	</div>
 		 	           <div class="informationContext_listDetalis clear"> 
	 		 	           <div class="listDetalis_top">
	 		 	           	<ul>
	 		 	           	<?php if(!empty($consult)){ 
 		 	           		foreach ($consult as $k=>$v){
							if($k!=0){	
 		 	           	?>
 		 	           		 <li>
 		 	           		 	 <a title="<?php echo $v['title'] ?>" href="/lyzx/tours_<?php echo $v['id']; ?>.html" target="_blank"><p><?php echo $v['title'] ?></p></a>
 		 	           		 	 <span><?php echo date('m月d日', strtotime($v['addtime']));?>&nbsp;&nbsp;<?php echo date('H:i', strtotime($v['addtime']));?></span>
 		 	           		 </li>
 		 	           	<?php } } }?>
	 		 	           	</ul>
	 		 	           </div>
 		 	           </div>
	 		 	</div>
	 		 	<div class="pagination fr">
 						 <ul class="page"> 	
							<?php echo $this->page->create_page();?>
						 </ul> 
					</div>
	 		 </div>
	 		 <div class="information_rightSide fr">
	 		           <div class="rightSide_top clear">
		 		 	<div class="hot_infTitle">
		 		 		 <p class="hot_sp1 ">热门资讯</p>
		 		 		 <p class="hot_sp2"><?php if(!empty($hot['shownum'])){ echo $hot['shownum'];}else{ echo 0;} ?>访问<a href="/lyzx_page-1-1.html" target="_blank"><span>更多</span></a></p>
		 		 	</div>
		 		 	<div class="hot_information">
				 	   <a href="/lyzx/tours_<?php if(!empty($hot_consult[0])){  echo $hot_consult[0]['consultid'];} ?>.html" target="_blank">
			 		 		<div class="hot_informationList  hot_two">
			 		 			 <div class="hot_word_img">
			 		 			 	<img class="" src="<?php if(!empty($hot_consult[0])){ echo $hot_consult[0]['pic'];} ?>">
			 		 			</div>
			 		 			 <p class="hot_informationText"><?php if(!empty($hot_consult[0])){ echo $hot_consult[0]['title']; }?></p>
			 		 		</div>
			 		 	</a>
		 		 	<?php if(!empty($hot_consult)){
		 		 	      foreach ($hot_consult as $k=>$v){
						  if($k!=0){
		 		 		?>
	
			 		 		<a title="<?php echo $v['title']; ?>" href="/lyzx/tours_<?php echo $v['consultid']; ?>.html" target="_blank">	
			 		 		<div class="hot_informationList hot_two hot_word">
			 		 			
			 		 			 <p class="hot_informationText"><?php echo $k; ?>、<?php echo $v['title']; ?></p>
			 		 		</div>
			 		 	</a>
					<?php } } }?>
		 		 	</div>
	 		 	</div>
	 		           
		 		 <div class="rightSide_bottom fr">
		 		 	<div class="knowledge_infTitle">
		 		 		 <p class="hot_hr "></p>
		 		 		 <span class="hot_sp">旅游攻略</span>
		 		 		 <a href="/lyzx_page-2-1.html" target="_blank"><span class="hot_more">更多</span></a>
		 		 	</div>
		 		 	<div class="hot_information">
 						<a href="/lyzx/tours_<?php if(!empty($hot_knowledge[0])){ echo $hot_knowledge[0]['consultid']; }?>.html" target="_blank">
			 		 		<div class="hot_informationList  hot_two">
			 		 			 <div class="hot_word_img">
			 		 			 	<img class="" src="<?php if(!empty( $hot_knowledge[0])){ echo $hot_knowledge[0]['pic']; }?>">
			 		 			</div>
			 		 			 <p class="hot_informationText"><?php if(!empty( $hot_knowledge[0])){echo $hot_knowledge[0]['title'];} ?></p>
			 		 		</div>
			 		 	</a>
			 		   <?php if(!empty($hot_knowledge)){
		 		 	      foreach ($hot_knowledge as $k=>$v){
						  if($k!=0){
		 		 		?>
			 		 	<a title="<?php echo $v['title']; ?>" href="/lyzx/tours_<?php echo $v['consultid']; ?>.html" target="_blank">	
			 		 		<div class="hot_informationList hot_two hot_word">
			 		 			
			 		 			 <p class="hot_informationText"><?php echo $k; ?>、<?php echo $v['title']; ?></p>
			 		 		</div>
			 		 	</a>
						<?php } } }?>
		 		 	</div>
		 		</div> 	
	 		</div> 	
	 	</div>
	 </div>
	 <!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
	 <script type="text/javascript">
     	jQuery(".slideBox").slide({mainCell:".bd ul",autoPlay:true})
          $(function(){
                  $('.pagination .page_1').click(function(){
                          $(this).addClass('active').siblings('.page_1').removeClass('active').addClass('page')
                  }); 
          	})
      </script>
</body>
</html>
