<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>旅游资讯_旅游攻略_旅游知识_最新旅游新闻-帮游旅行网</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
	<meta name="keywords" content="旅游资讯,国内游资讯,出境游资讯" />
	<meta name="description" content="帮游旅游资讯网为大家提供专业全面的旅游资讯内容分享，涵盖国内游资讯，出境游资讯，景点资讯，交通资讯，旅游攻略，旅游知识等你所需要的旅游信息。" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<link href="/static/css/common.css" rel="stylesheet" type="text/css">
	<link href="/static/css/information.css" rel="stylesheet" type="text/css">
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
   <div style="height:auto;">
     <!-- 头部 -->
	<?php $this->load->view('common/header'); ?>
	<!-- 内容区 -->
	 		 	<div class="information clear w_1200">
	 		 <div class="informationContext fl">
	 		 	<div class="scroll_pic">
	 		 	    <!-- 三张大图片 -->
	 		 		<div id="slideBox" class="slideBox">
						<div class="hd">
							 <ul>
							 <li><i></i></li>
							 <?php if(!empty($location)){ 
								foreach ($location as $k=>$v){
									if($k!=0){	
							?>
							 <li></li>
							<?php } } }?>	
							 </ul>
						</div>
						<div class="bd">
							<ul>
							<?php if(!empty($location)){ 
								foreach ($location as $k=>$v){
							?>
								<li>
									<a href="/lyzx/tours_<?php echo $v['consultid']; ?>.html" target="_blank">
										 <img src="<?php echo $v['pic']; ?>" />
										 <i></i>
									           <p class="title"><?php echo $v['title']; ?></p>
									           <p class="cover"></p>
									</a>
								</li>
							<?php } }?>	
							</ul>
						</div>
					</div>	
	 		 	</div>
	 		 	<div class="list_ftu clear">
	 		 		<div class="scenic fl">
                             <a href="/lyzx/tours_<?php if(!empty($middle[0])){ echo $middle[0]['consultid'];}else{ echo 0;} ?>.html" target="_blank">
	 		 				 <img src="<?php if(!empty($middle[0]['pic'])){ echo $middle[0]['pic'];} ?>">
	 		 				 <p class="cover"></p>
	 		 				 <p class="title"><?php if(!empty($middle[0]['title'])){ echo $middle[0]['title'];} ?></p>
	 		 		         </a>	
	 		 		</div>
	 		 		<div class="scenic fr">
	 		 			 	 <a href="/lyzx/tours_<?php if(!empty($middle[1])){ echo $middle[1]['consultid'];}else{ echo 0;} ?>.html" target="_blank">
	 		 				 <img src="<?php if(!empty($middle[1]['pic'])){ echo $middle[1]['pic'];} ?>">
	 		 				 <p class="cover"></p>
	 		 				 <p class="title"><?php if(!empty($middle[1]['title'])){ echo $middle[1]['title'];} ?></p>
	 		 		         </a>	
	 		 		</div>
	 		 	</div>
	 		 	<div class="informationContext_list zixun_list ">
	 		 	    <div class="informationContext_listTitle">
	 		 	         <p>最新资讯</p>
	 		 	         <a href="/lyzx_page-1-1.html" target="_blank"><span>更多</span></a>
	 		 	    </div>
		 		 	<div class="inf_scenic_list clear">
		 		 		<div class="infscenic_center">
			 		 		<div class="infscenic_detalis fl">
			 		 			<div class="detalis_img">
			 		 				 <a href="/lyzx/tours_<?php if(!empty($new_consult[0])){ echo $new_consult[0]['consultid'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 				 <img src="<?php if(!empty($new_consult)){ echo $new_consult[0]['pic']; }?>">
			 		 				 </a>
			 		 			</div>
			 		 		</div>
			 		 		<div class="detalis_text detalis_text_1 fr">
			 		 			 <p class="detalis_title"><a href="/lyzx/tours_<?php if(!empty($new_consult[0])){ echo $new_consult[0]['consultid'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 			 <?php if(!empty($new_consult)){ echo $new_consult[0]['title']; }?></a></p>
			 		 			 <div class="detalis_intro"><?php if(!empty($new_consult)){ echo mb_strimwidth(strip_tags($new_consult[0]['content']), 0,250, '...', 'utf8');  }?>
			 		 			  <a  href="/lyzx/tours_<?php if(!empty($new_consult[0])){ echo $new_consult[0]['consultid'];}else{ echo 0;} ?>.html"  target="_blank">...详情>></a>
			 		 			 </div>
			 		 			 <p class="detalis_time"><?php if(!empty($new_consult[0]['addtime'])){echo date('Y-m-d', strtotime($new_consult[0]['addtime']));}?></p>
			 		 		</div>
			 		 	</div>
		 		 	</div>
 		 	        <div class="informationContext_listDetalis clear">
 		 	            	<div class="listDetalis_top ">
	 		 	           	<ul>
	 		 	           	<?php if(!empty($new_consult)){
	 		 	           		foreach ($new_consult as $k=>$v){
                                 if( $k!=0){
	 		 	           	?>
	 		 	           		 <li>
	 		 	           		 	<a title="<?php echo $v['title']; ?>" href="/lyzx/tours_<?php echo $v['consultid']; ?>.html" target="_blank">	
	 		 	           		 		<p><?php echo $v['title']; ?></p>
	 		 	           		           </a> 
	 		 	           		 	 <span><?php echo date('m月d日', strtotime($v['addtime']));?>&nbsp;&nbsp;<?php echo date('H:i', strtotime($v['addtime']));?></span>
	 		 	           		 </li>
	 						<?php } } }?>
	 		 	           	</ul>
	 		 	           </div>     
 		 	       </div>
	 		 	</div>
	 		 	<div class="informationContext_list zixun_list ">
 		 	        <div class="informationContext_listTitle">
 		 	           	 <p>最新攻略</p>
 		 	           	 <a  href="/lyzx_page-2-1.html" target="_blank"><span>更多</span></a>
 		 	        </div>
		 		 	<div class="inf_scenic_list clear">
		 		 		<div class="infscenic_center">
			 		 		<div class="infscenic_detalis fl">
			 		 			<div class="detalis_img">
			 		 				 <a href="/lyzx/tours_<?php if(!empty($knowledge[0])){ echo $knowledge[0]['consultid'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 				 <img src="<?php if(!empty($knowledge)){ echo $knowledge[0]['pic']; }?>">
			 		 				 </a>
			 		 			</div>
			 		 		</div>
			 		 	
			 		 		<div class="detalis_text detalis_text_1 fr">
			 		 			 <p class="detalis_title"><a href="/lyzx/tours_<?php if(!empty($knowledge[0])){ echo $knowledge[0]['consultid'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 			 <?php if(!empty($knowledge)){ echo $knowledge[0]['title']; }?></a></p>
			 		 			 <div class="detalis_intro">
			 		 			 <?php if(!empty($knowledge)){ echo mb_strimwidth(strip_tags($knowledge[0]['content']), 0,250, '...', 'utf8');  }?>
			 		 			 <a href="/lyzx/tours_<?php if(!empty($knowledge[0])){ echo $knowledge[0]['consultid'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 			     ...详情>>
			 		 			 </a>
			 		 			 </div>
			 		 			 <p class="detalis_time"><?php if(!empty($knowledge[0]['addtime'])){ echo date('Y-m-d', strtotime($knowledge[0]['addtime']));}?></p>
			 		 		</div>
			 		 	</div>
		 		 	</div>
		 		 	<!-- 最新攻略列表 -->
 		 	        <div class="informationContext_listDetalis clear">
 		 	            <div class="listDetalis_top ">
	 		 	           	<ul>
	 		 	           		<?php if(!empty($knowledge)){
	 		 	           		foreach ($knowledge as $k=>$v){
                                 if( $k!=0){
	 		 	           		?>
	 		 	           		 <li>
	 		 	           		 	<a title="<?php echo $v['title']; ?>"  href="/lyzx/tours_<?php echo $v['consultid']; ?>.html" target="_blank">	
	 		 	           		 		<p><?php echo $v['title']; ?></p>
	 		 	           		           </a> 
	 		 	           		 	 <span><?php echo date('m月d日', strtotime($v['addtime']));?>&nbsp;&nbsp;<?php echo date('H:i', strtotime($v['addtime']));?></span>
	 		 	           		 </li>
	 						<?php } } }?>
	 		 	           	</ul>
	 		 	         </div> 
 		 	         </div>
	 		 	</div>
	 		 </div>
	 		 <div class="information_rightSide fr">
	 		        <div class="rightSide_top clear">
		 		 	<div class="hot_infTitle">
		 		 		 <p class="hot_sp1 ">热门资讯</p>
		 		 		 <p class="hot_sp2"><?php if(!empty($hot['shownum'])){ echo $hot['shownum'];}else{ echo 0;} ?>访问 <a href="/lyzx_page-1-1.html" target="_blank"><span>更多</span></a></p>
		 		 	</div>
		 		 	<div class="hot_information">
		 		 		 <a title="<?php if(!empty($hot_consult[0])){ echo $hot_consult[0]['title']; }?>"  href="/lyzx/tours_<?php if(!empty($hot_consult[0])){  echo $hot_consult[0]['consultid'];} ?>.html" target="_blank">
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
	
			 		 		<a title="<?php echo $v['title']; ?>"  href="/lyzx/tours_<?php echo $v['consultid']; ?>.html" target="_blank">	
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
		 			   <a title="<?php if(!empty( $hot_knowledge[0])){echo $hot_knowledge[0]['title'];} ?>" href="/lyzx/tours_<?php if(!empty($hot_knowledge[0])){ echo $hot_knowledge[0]['consultid']; }?>.html" target="_blank">
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
</body>
</html>
<script type="text/javascript">
    jQuery(".slideBox").slide({mainCell:".bd ul",autoPlay:true,effect:"leftLoop"})
    $(function(){
           $('.pagination .page_1').click(function(){
               $(this).addClass('active').siblings('.page_1').removeClass('active').addClass('page')
           });
	})	
</script>
   
