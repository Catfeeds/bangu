<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<?php if(!empty($consult[0]['type'])){
	 $city='';
	 if(isset($overcity)){foreach ($overcity as $key=>$val){ if(($key+1)<count($overcity)){  $city=$city.$val['name'].',';}else{ $city=$city.$val['name'];}}}
	 if($consult[0]['type']==1){?> 
		<title><?php echo $consult[0]['title']; ?>_最新<?php echo $city; ?>旅游资讯-帮游旅行网</title>
		<meta name="keywords" content="<?php echo $city; ?>旅游,<?php echo $city; ?>自驾游,<?php echo $city; ?>郊区旅游" />
		<meta name="description" content="帮游旅行网旅游资讯频道为大家提供最新<?php echo $city; ?>旅游资讯信息，让你的<?php echo $city; ?>旅程更加完美。" />
	<?php }else{?>
		<title><?php echo $consult[0]['title']; ?>_最新<?php echo $city; ?>旅游攻略—帮游旅行网</title>
		<meta name="keywords" content="<?php echo $city; ?>周边旅游_<?php echo $city; ?>旅游攻略" />
		<meta name="description" content="帮游旅行网旅游资讯频道为大家提供最新最全面的<?php echo $city; ?>旅游攻略，为您在<?php echo $city; ?>的旅程提供专业的出游指南。" />
	<?php } }else{?>
	    <title>资讯详情页-资讯列表-帮游旅行网</title>
	<?php }?>
	<link href="../../../static/css/common.css" rel="stylesheet" type="text/css">
	<link href="../../../static/css/information.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
	<script type="text/javascript" src="../../../static/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../../../static/js/jquery.SuperSlide.2.1.1.js"></script>
	<style type="text/css">
	body{text-align: center;margin: 0px auto;}
	</style>
</head>
<body>
      <div>
		 <!-- 头部 -->
		<?php $this->load->view('common/header'); ?>
		<!-- 内容区 -->
	 	<div class="information clear w_1200">
	 		 <div class="informationContext fl">
	 		 	<div class="informationContext_list">
	 		 	           <p class="infList_details"><?php if(!empty($consult[0]['title'])){ echo $consult[0]['title'];} ?></p>
	 		 	           <div class="infList_source">
	 		 	        		 <p class="">
	 		 	        		 	 <span class="source_name">来源：</span>
	 		 	        		 	 <span class="source_span">帮游旅游网</span>
	 		 	        		 </p>
	 		 	        		 <p class="">
	 		 	        		 	 <span class="source_name">发布：</span>
	 		 	        		 	 <span class="source_span"><?php if(!empty($consult[0]['addtime'])){echo date('Y年m月d日', strtotime($consult[0]['addtime']));}?></span>
	 		 	        		 </p>
	 		 	        		 <p class="">
	 		 	        		 	 <span class="source_name">作者：</span>
	 		 	        		 	 <span class="source_span"><?php  if(!empty($consult[0]['user_name'])){ echo $consult[0]['user_name'];}?></span>
	 		 	        		 </p>
	 		 	        		 <p class="">
	 		 	        		 	 <span class="source_name">人气：</span>
	 		 	        		 	 <span class="source_span"><?php  if(!empty($consult[0]['shownum'])){ echo $consult[0]['shownum'];}else{ echo 0;} ?></span>
	 		 	        		 </p>
	 		 	           </div>
	 		 	           <div class="introduces_Zdetails">
		 		 	           <div class="introduces_details">
		 		 	           <?php  if(!empty($consult[0]['content'])){ echo $consult[0]['content'];}?>
		 		 	           </div >
		 		 	           <div class="introduces_details introduces_Zevaluate">
		 		 	           	 <p class="introduces_evaluate fl dianzan">
		 		 	           	 	 <i class="evaluate_icon_1" <?php  if(!empty($hit_zan)){ echo 'style="display: none;"';}?> ></i>
		 		 	           	 	 <i class="evaluate_icon_3" <?php  if(!empty($hit_zan)){ echo 'style="display: inherit;"';}?> ></i>
		 		 	           	 	 <span><?php if(!empty($zan['sum'])){ echo $zan['sum'];}else{ echo 0;} ?></span>
		 		 	           	 </p>
		 		 	           	 <p class="introduces_evaluate share_fs fr">
		 		 	           	 	 <i class="evaluate_icon_2"></i>
		 		 	           	 	 <span>分享</span>
		 		 	           	 </p>
		 		 	           	 <div class="share_evaluate">
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
		 		 		    <a href="/lyzx/tours_<?php echo  $prev_consult['id']; ?>.html"><p>上一条：<?php echo $prev_consult['title'];?></p></a>
		 		 		<?php }else{ ?>
		 		 		    <a href=""><p>上一条：暂无数据</p></a>
		 		 		<?php }?>
		 		 		<?php if(!empty($next_consult)){ ?>
		 		 			<a href="/lyzx/tours_<?php echo  $next_consult['id']; ?>.html"><p>下一条： <?php if(!empty($next_consult)){echo $next_consult['title'];}else{ echo '暂无数据';} ?></p></a>
		 		 		<?php }else{?>
		 		 		    <a href=""><p>下一条：暂无数据</p></a>
		 		 		<?php }?>
		 		 	</div>  
	 		 	</div>
	 		 	
	 		 </div>
	 		 <div class="information_rightSide fr">
	 		         <div class="rightSide_line clear">
		 		 	<p class="line_name">
		 		 	<?php if(isset($overcity)){ echo $overcity[0]['name'];} ?>旅游线路
		 		 	</p>
		 		 	<div class="hot_information">
		 		 	<?php if(!empty($line)){
		 		 		foreach ($line as $k=>$v){
		 		 	?>
                                            <!-- 将cj改为line,添加后缀.html 魏勇编辑-->
		 		 	    <a href="<?php echo '/line/'.$v['id'].'.html'  ?>" target="_blank">
			 		 		<div class="line_jd">
			 		 			 <div class="line_jd_img">
			 		 			 	 <img class="" src="<?php echo $v['mainpic']; ?>" />
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
	 		           
		 		 <div class="rightSide_gl ">
		 		 	<p class="line_name">
		 		 	<?php //if(isset($overcity)){foreach ($overcity as $key=>$val){ if(($key+1)<count($overcity)){ echo $val['name'].',';}else{echo $val['name'];}}} ?>
		 		 	<?php if(isset($overcity)){ echo $overcity[0]['name'];} ?>旅游攻略</p>
		 		 	<div class="hot_information">
		 		 	<?php if(!empty($d_consult)){
		 		 	     foreach ($d_consult as $k=>$v){	
		 		 	?>
			 		 	<div class="line_gl">
			 		 		 <p class=" clear"><a href="<?php echo '/lyzx/tours_'.$v['id'].'.html';?>"  target="_blank"><?php echo $k+1; ?>、<?php echo $v['title']; ?></a></p>
			 		 	</div>
			 		 <?php }}else{?>	
			 		 <div class="line_gl">
			 		 		 <p class=" clear"><a href="#">暂无数据</a></p>
			 		 	</div>
			 		 <?php }?>
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
   $(function () {

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


