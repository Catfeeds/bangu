<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="keywords" content="旅游曝光台,不文明旅游" />
<meta name="description" content="帮游旅行网（www.1b1u.com）为你曝光一些不文明旅游行为，大家可以在此了解一下关于事情的始末。" />
<title><?php if(!empty($common['title'])){ echo $common['title'];} ?>，旅游曝光台，帮游旅行网</title>
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
		<!-- 内容区 -->
	 	<div class="information clear w_1200">
	 		 <div class="informationContext fl">
	 		 	<div class="informationContext_list">
	 		 	           <p class="infList_details"><?php if(!empty($common['title'])){ echo $common['title'];} ?></p>
	 		 	           <div class="infList_source">
	 		 	        		 <p class="" style="float:right">
	 		 	        		 	 <span class="source_name">发布：</span>
	 		 	        		 	 <span class="source_span"><?php if(!empty($common['addtime'])){echo date('Y年m月d日', strtotime($common['addtime']));}?></span>
	 		 	        		 </p>
	 		 	        		
	 		 	           </div>
	 		 	           <div class="introduces_Zdetails">
		 		 	           <div class="introduces_details">
		 		 	           <?php  if(!empty($common['content'])){ echo $common['content'];}?>
		 		 	           </div >
		 		 	           <div class="introduces_details introduces_Zevaluate" style="width:120px;">
		 		 	          <!--  	 <p class="introduces_evaluate fl dianzan">
		 		 	           	 	 <i class="evaluate_icon_1" <?php  if(!empty($hit_zan)){ echo 'style="display: none;"';}?> ></i>
		 		 	           	 	 <i class="evaluate_icon_3" <?php  if(!empty($hit_zan)){ echo 'style="display: inherit;"';}?> ></i>
		 		 	           	 	 <span><?php if(!empty($zan['sum'])){ echo $zan['sum'];}else{ echo 0;} ?></span>
		 		 	           	 </p>--> 
		 		 	           	 <p class="introduces_evaluate share_fs fr">
		 		 	           	 	 <i class="evaluate_icon_2"></i>
		 		 	           	 	 <span style="padding-left:40px;">分享</span>
		 		 	           	 </p>
		 		 	           	 <div class="share_evaluate" style="left:33px;">
		 		 	           	 	 <ul class="clear">
		 		 	           	 		 <li>
		 		 	           	 		 	<a class="jiathis_button_weixin">
		 		 	           	 		 		<i class="shareIcon_1"></i>
		 		 	           	 		 		<span class="share_sp share">微信</span>
		 		 	           	 		 		
		 		 	           	 		 	</a>
		 		 	           	 		 </li>
		 		 	           	 		 <li>	 	
 											<a class="jiathis_button_qzone">
		 		 	           	 		 		<i class="shareIcon_2"></i>
		 		 	           	 		 		<span class="share">QQ空间</span>
		 		 	           	 		 	</a>
		 		 	           	 		 </li>
		 		 	           	 		 <li>
		 		 	           	 		    <a class="jiathis_button_tsina">
		 		 	           	 		 		<i class="shareIcon_3"></i>
		 		 	           	 		 		<span class="share_sp share">微博</span>
		 		 	           	 		 	</a>
		 		 	           	 		 </li>
		 		 	           	 		 <li>
		 		 	           	 		 	<a class="jiathis_button_cqq">
		 		 	           	 		 		<i class="shareIcon_4"></i>
		 		 	           	 		 		<span class="share">QQ好友</span>
		 		 	           	 		 	</a>
		 		 	           	 		 </li>
		 		 	           	 	 </ul>
		 		 	           	 	 <!-- 分享 -->
		 		 	           	 	 <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
		 		 	           	 </div> 
		 		 	           </div>
		 		 	</div>
		 		 	<div class="introduces_itemize">
		 		 		<?php if(!empty($prev_consult)){?>
		 		 		    <a href="/sc_detail-<?php echo  $prev_consult['id']; ?>.html"><p>上一条：<?php echo $prev_consult['title'];?></p></a>
		 		 		<?php }else{ ?>
		 		 		    <a href=""><p>上一条：暂无数据</p></a>
		 		 		<?php }?>
		 		 		<?php if(!empty($next_consult)){ ?>
		 		 			<a href="/sc_detail-<?php echo  $next_consult['id']; ?>.html"><p>下一条： <?php if(!empty($next_consult)){echo $next_consult['title'];}else{ echo '暂无数据';} ?></p></a>
		 		 		<?php }else{?>
		 		 		    <a href=""><p>下一条：暂无数据</p></a>
		 		 		<?php }?>
		 		 	</div>  
	 		 	</div>
	 		 	
	 		 </div>
	 	   <div class="information_rightSide fr">

	 		    <div class="rightSide_line clear">
		 		 	<p class="line_name">体验分享</p>
		 		 	<div class="hot_information">	
			 		 <?php if(!empty($tarvel)){
		 		 	     foreach ($tarvel as $k=>$val){
							switch($val['usertype']) {
								case 0: //用户
									$authorPic = $val['litpic'];
									if (!empty($val['meid']) && $val['mestatus'] == 1) {
										$type = 5;
									} else {
										$type = 0;
									}
									break;
								case 1: //管家
									$type = 1;
									break;
							}	
		 		 	?>
			 		 	<div class="line_gl">
			 		 		 <p class=" clear"><a href="<?php echo site_url('yj/'.$val['id'].'-'.$type); ?>"  target="_blank"><?php echo $k+1; ?>、<?php echo $val['title']; ?></a></p>
			 		 	</div>
			 		 <?php }}else{?>	
			 		 <div class="line_gl">
			 		 		 <p class=" clear"><a href="#">暂无数据</a></p>
			 		 	</div>
			 		 <?php }?>
			 		
		 		 	</div>
	 		 	</div>
	 		    <div class="rightSide_gl ">
	 		       <p class="line_name">旅游线路</p>
		 		 	<div class="hot_information">
		 		     <?php if(!empty($line)){
		 		 		foreach ($line as $k=>$v){
		 		 	?>
                                            <!-- 将cj改为line,添加后缀.html-->
		 		 	    <a href="<?php echo '/line/'.$v['id'].'.html'  ?>" target="_blank">
			 		 		<div class="line_jd">
			 		 			 <div class="line_jd_img">
			 		 			 	 <img class="" src="<?php echo $v['mainpic']; ?>">
			 		 			</div>
			 		 			 <div class="line_jd_detalis">
									 <p class="jd_title"><?php echo $k+1; ?>、<?php echo $v['linename']; ?>
									 </p>
									 <p class="jd_money">￥<?php echo $v['lineprice']; ?></p>
			 		 			 </div>
			 		 		</div>
			 		 	</a>
			 		 <?php } }else{ echo '<div class="line_jd">暂无数据</div>';}?>
		 		 	</div>
		 		</div>      
	 		</div> 	 
	 	</div>
	 </div>
	  <!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>   
	<?php $this->load->view('sc/com/foot');?>
</body>
</html>
<script type="text/javascript">
   $(function () {
/* 		$('.share_fs i').click(function  () {
			var _show=$('.evaluate_icon_1').is(":visible");
			if (_show) {	
				$('.evaluate_icon_1').hide();
				$('.evaluate_icon_3').show();
			}else{
				$('.evaluate_icon_3').hide();
				$('.evaluate_icon_1').show();
			};
	
		}) */
		$('.share_fs ').click(function  () {
             $('.share_evaluate').toggle();
		})
		 //点赞
		 $('.dianzan').click(function  () {
				var user_id = "<?php echo $this->session->userdata('c_userid');?>";
				var consult_id="<?php  if(!empty($consult[0]['id'])){ echo $consult[0]['id'];}  ?>";
				 if(user_id==undefined || user_id==''){
				        $('.login_box').css("display","block");
				        return false;
				 }else{
					 $.post("<?php echo base_url('consult/consult_detail/click_praise')?>",
			            {'user_id':user_id,'consult_id':consult_id},
			            function(data){
			                data = eval('('+data+')');
			                if(data.status==1){
			                    alert(data.msg);
			                    location.reload();
			                }else{
			                    alert(data.msg);
			                }
					  }); 
				 }
				var _show=$('.evaluate_icon_1').is(":visible");
				if (_show) {	
					$('.evaluate_icon_1').hide();
					$('.evaluate_icon_3').show();
				}else{
					$('.evaluate_icon_3').hide();
					$('.evaluate_icon_1').show();
				};
		 })
   })
  
   
</script>




