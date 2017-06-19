<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/share_page.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="js/zzsc.js" type="text/javascript"></script>
<title>分享图片</title>
</head>
<body>
    <!-- 头部 -->
	<?php $this->load->view('common/header'); ?>
    <div class="page_main">
        <div class="page_title">分享图片</div>
    <div class="otoShare_conment" style="margin-top:10px;">
            <ul>
				<?php foreach($share_img as $val){ ?>
					<li>
						<!--<a class="a1" href="/share/share_detail/img_share?share_id=<?php echo $val['id'] ?>" target="_blank">-->
							<img alt="" src="<?php echo $val['cover_pic']; ?>" />
						</a>
						<div class="he_30"></div> 
						<span>
							<div class="fenxiang_renqi">人气:<?php echo $val['praise_count']; ?></div>
							<div class="fenxiang_zan">
								<img alt=""	src="<?php echo base_url('static'); ?>/img/page/zan_05.png" style=" width:auto; height:auto;" />赞:<?php echo $val['popularity']; ?>							
							</div>
						</span>
					</li>
				<?php } ?>                
            </ul>
            <?php echo $this->page->create_page(); ?>
        </div>
    </div>
    
<div class="hidden">
	<span class="close">关闭</span>
<div class="xianshi"><img src="../../../static/img/daren_big.jpg" alt=""></div>
	<div class="show">
		<a href="javascript:;" class="next"><</a>
		<a href="javascript:;" class="prev">></a>
		<div class="itemshow">
			<ul class="items">
				<li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
				<li><a href="javascript:void(0);"><img src="../../../static/img/zb_img.png" alt=""></a></li>
                <li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
				<li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
                <li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
				<li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
                <li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
				<li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
                <li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
				<li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
                <li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
				<li><a href="javascript:void(0);"><img src="../../../static/img/daren_big.jpg" alt=""></a></li>
			</ul>
		</div>
	</div>
</div>
   
    
    
     <!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
</body>
</html>
<script type="text/javascript">
     $(function(){
		     //参数设置
					var tLen = 0, 
							vNum = 5, 
							mNum = 1, 
							mTime = 300, 
							iShow = $(".show .itemshow ul"),
							iItems = $(".show .itemshow ul li"),
							mLen = iItems.eq(0).width() * mNum, 
							cLen = (iItems.length - vNum) * iItems.eq(0).width(); 

					iShow.css({width:iItems.length*iItems.eq(0).width()+'px'});
					//下一张
					$(".show .prev").on({
						click:function(){
								if(tLen < cLen){
									if((cLen - tLen) > mLen){
										iShow.animate({left:"-=" + mLen + "px"}, mTime);
										tLen += mLen;
									}else{
										iShow.animate({left:"-=" + (cLen - tLen) + "px"}, mTime);
										tLen += (cLen - tLen);
									}
								}
						}
					});
					//上一张
					$(".show .next").on({
						click:function () {
							if(tLen > 0){
								if(tLen > mLen){
									iShow.animate({left: "+=" + mLen + "px"}, mTime);
									tLen -= mLen;
								}else{
									iShow.animate({left: "+=" + tLen + "px"}, mTime);
									tLen = 0;
								}
							}
						}
					})
					//替换点击的src地址
					$(".items li img").click(function(){
						var thissrc=$(this).attr("src")
							$(".xianshi img").attr("src",thissrc);
						})
						//描边样式
						$(".items li img").click(function(){
								$(".items li img").css("border","3px solid #ccc");
								$(this).css("border","3px solid #f54");
								$(this).css("po","3px solid #f54");
							})
							//关闭按钮
							$(".close").click(function(){
									$(".hidden").hide();
								})
				});
</script>


   <script type="text/javascript">
    $(function(){
        $(".page_list ul li img").click(function(){
            $(".page_list ul li img").css("border","1px solid #ccc"); 
            $(this).css("border","1px solid #f54");
            
            $(".page_list ul li span").hide();
            $(this).next("span").show();
            $(".eject_box").fadeIn("show");
        });
        $(".photo_box").blur(function(){
            $(this).hide();
        })
   $(function(){
       $(".geren_title_left").click(function(){
           $(".eject_box").fadeIn("show");
           
       })
        $(".otoShare_conment ul li").click(function(){
           $(".hidden").fadeIn("show");
           
       })
    })
    }); 
	//鼠标滑过显示阴影上移动30px
       $(function(){
    $(".otoShare_conment ul li").mousemove(function(){
        $(this).find("span").stop().animate({bottom: '15px'}, 100);
        });
    $(".otoShare_conment ul li").mouseout(function(){
        $(this).find("span").stop().animate({bottom: '-15px'}, 100);
        });
     });
</script>

















	