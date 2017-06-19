<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php if($type==1){?> 
		<title>常见问题列表-帮游旅行网</title>
		<meta name="keywords" content="旅游资讯,国内游资讯,交通资讯" />
		<meta name="description" content="帮游旅行网旅游资讯频道为大家提供全面的国内、出境旅游资讯、景区资讯，交通资讯、旅游新闻、旅游知识等旅游信息。" />
	<?php }else{?>
		<title>常见问题列表-帮游旅行网</title>
		<meta name="keywords" content="旅游攻略,出行指南" />
		<meta name="description" content="帮游旅行网旅游资讯频道为大家提供最新最全面的旅游攻略，包括国内旅游攻略和出境旅游攻略，为您的旅程提供专业的出游指南。" />
	<?php }?>
	<link href="../../../static/css/common.css" rel="stylesheet" type="text/css">
	<link href="../../../static/css/information.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
	<script type="text/javascript" src="../../../static/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../../../static/js/jquery.SuperSlide.2.1.1.js"></script>
</head>
<body>
        <div>
	   <!-- 头部 -->
	   <?php $this->load->view('common/header'); ?>
	 	<div class="information clear w_1200">
	 		 <div class="informationContext fl">
	 		 	<div class="informationContext_list" style="min-height:445px;">
	 		 	    <div class="informationContext_listTitle">
	 		 	    <ul class="fl index_nav">
	 		 	   		 <li <?php if($type==1){echo 'class="on"';} ?>><a href="/common_list-1-1.html">出境</a></li>
	 		 	   		 <li <?php if($type==2){echo 'class="on"';} ?>><a href="/common_list-2-1.html">国内</a></li>
	 		 	   		 <li <?php if($type==4){echo 'class="on"';} ?>><a href="/common_list-4-1.html">周边</a></li>
	 		 	   		 <li <?php if($type==3){echo 'class="on"';} ?>><a href="/common_list-3-1.html">主题</a></li>
	 		 	    </ul>
	 		 	    </div>
		 		 	<!--<div class="inf_scenic_list clear" >
		 		 	     <div class="infscenic_center">
			 		 		<div class="infscenic_detalis fl">
			 		 			<div class="detalis_img">
			 		 				 <a href="/lyzx/tours_<?php if(!empty($common[0])){ echo $common[0]['id'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 				 <img src="<?php if(!empty($common[0]['pic'])){ echo $common[0]['pic'];}else{ echo 0;} ?>"></a>
			 		 			</div>
			 		 		</div>
			 		 	
			 		 		<div class="detalis_text detalis_text_1 fr">
			 		 			 <p class="detalis_title">
			 		 			 <a title="<?php if(!empty($common[0]['title'])){echo $common[0]['title'];} ?>" href="/lyzx/tours_<?php if(!empty($common[0])){ echo $common[0]['id'];}else{ echo 0;} ?>.html"  target="_blank">
			 		 			 <?php if(!empty($common[0]['title'])){echo $common[0]['title'];} ?>
			 		 			 </a>
			 		 			 </p>
			 		 			 <div class="detalis_intro">
			 		 			<?php if(!empty($common[0]['content'])){echo mb_strimwidth(strip_tags($common[0]['content']), 0,250, '...', 'utf8');} ?> 
			 		 			 <a href="/lyzx/tours_<?php if(!empty($common[0])){ echo $common[0]['id'];}else{ echo 0;} ?>.html"  target="_blank">...详情>></a>
			 		 			 </div>
			 		 			 <p class="detalis_time"><?php if(!empty($common[0]['addtime'])){ echo date('Y-m-d', strtotime($common[0]['addtime']));}?></p>
			 		 		</div>
			 		 	</div>
		 		 	</div>--> 
 		 	           <div class="informationContext_listDetalis clear"> 
	 		 	           <div class="listDetalis_top">
	 		 	           	<ul>
	 		 	           	<?php if(!empty($common)){ 
 		 	           		foreach ($common as $k=>$v){
							
 		 	            	?>
 		 	           		 <li>
 		 	           		 	 <a title="<?php echo $v['title'] ?>" href="/common_detail-<?php echo $v['id']; ?>.html" target="_blank"><p><?php echo $v['title'] ?></p></a>
 		 	           		 	 <span><?php echo date('m月d日', strtotime($v['addtime']));?>&nbsp;&nbsp;<?php echo date('H:i', strtotime($v['addtime']));?></span>
 		 	           		 </li>
 		 	           	   <?php } } ?>
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
		 		 		 <p class="hot_sp1 ">体验的分享</p>
		 		 		 <p class="hot_sp2"><?php if(!empty($hot['shownum'])){ echo $hot['shownum'];}else{ echo 0;} ?>访问<a href="/yj" target="_blank"><span>更多</span></a></p>
		 		 	</div>
		 		 	<div class="hot_information">
		 		 	<?php if(!empty($tarve)){ ?>
				 	   <a href="/yj/<?php if(!empty($tarve[0])){ echo $tarve[0]['id'];}else{ echo 0;} ?>-<?php if($tarve[0]['expert_id']>0){echo '0';}else{echo '1';} ?>" target="_blank">
			 		 		<div class="hot_informationList  hot_two">
			 		 			 <div class="hot_word_img">
			 		 			 	<img class="" src="<?php if(!empty($tarve[0])){ echo $tarve[0]['cover_pic'];} ?>">
			 		 			</div>
			 		 			 <p class="hot_informationText"><?php if(!empty($tarve[0])){ echo $tarve[0]['title']; }?></p>
			 		 		</div>
			 		 	</a>
		 		 	<?php 
		 		 	      foreach ($tarve as $k=>$v){
						  if($k!=0){
		 		 		?>
	
			 		 		<a title="<?php echo $v['title']; ?>" href="/yj/<?php echo $v['id']; ?>-<?php if($v['expert_id']>0){echo '0';}else{echo '1';} ?>" target="_blank">	
			 		 		<div class="hot_informationList hot_two hot_word">
			 		 			
			 		 			 <p class="hot_informationText"><?php echo $k; ?>、<?php echo $v['title']; ?></p>
			 		 		</div>
			 		 	</a>
					<?php } } ?>
					<?php }else{ echo '<a><div style="height:50px;line-height:45px;padding-left:27px;">暂无相关数据</div></a>';  }?>
		 		 	</div>
	 		 	</div>
	 		           
		 		 <div class="rightSide_bottom fr">
		 		 	<div class="knowledge_infTitle">
		 		 		 <p class="hot_hr "></p>
		 		 		 <span class="hot_sp">旅游线路</span>
                                                 <!-- 将cj改为cj/,gn改为guonei/,zb改为zhoubian/,zt改为zhuti/
		 		 		 <a href="<?php if($type==1){echo '/chujing/';}elseif ($type==2){echo '/guonei/';}elseif ($type==4){echo '/zhoubian/';}elseif($type==3){echo '/zhuti/';}else{echo '/guonei/';} ?>" target="_blank"><span class="hot_more">更多</span></a>
		 		 	</div>
		 		 	<div class="hot_information">
		 		 	   <?php if(!empty($line)){ ?>
                                                 <!-- 将cj,gn改为line,添加后缀.html 魏勇编辑-->
 						<a href="<?php if(!empty($line[0]['overcity'])){ echo in_array(1 ,explode(',',$line[0]['overcity'])) ? '/line/'.$line[0]['id'].'.html' : '/line/'.$line[0]['id'].'.html';} ?>" target="_blank">
			 		 		<div class="hot_informationList  hot_two">
			 		 			 <div class="hot_word_img">
			 		 			 	<img class="" src="<?php if(!empty( $line[0])){ echo $line[0]['mainpic']; }?>">
			 		 			</div>
			 		 			 <p class="hot_informationText"><?php if(!empty( $line[0])){echo $line[0]['linename'];} ?></p>
			 		 		</div>
			 		 	</a>
			 		   <?php 
		 		 	      foreach ($line as $k=>$v){
						  if($k!=0){
		 		 		?>
                                                 <!-- 将cj,gn改为line,添加后缀.html 魏勇编辑-->
			 		 	<a title="<?php echo $v['linename']; ?>" href="<?php  echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['id'].'.html' : '/line/'.$v['id'].'.html'; ?>" target="_blank">	
			 		 		<div class="hot_informationList hot_two hot_word">
			 		 			 <p class="hot_informationText"><?php echo $k; ?>、<?php echo $v['linename']; ?></p>
			 		 		</div>
			 		 	</a>
						<?php } } ?>
						<?php }else{ echo '<a><div style="height:50px;line-height:45px;">暂无相关数据</div></a>'; }?>
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

