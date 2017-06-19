<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="viewport"content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/lyfx.css" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/fenxiang-list.css" rel="stylesheet" />
<script src="<?php echo base_url('static'); ?>/js/jquery-1.2.6.min.js" type=text/javascript></script>
<script src="<?php echo base_url('static'); ?>/js/zzsc.js" type=text/javascript></script>
<script src="<?php echo base_url('static'); ?>/js/fenxiang_list.js" type=text/javascript></script>
<script src="<?php echo base_url('static'); ?>/js/jquery.lazyload.min.js" type=text/javascript></script>
<title>最新分享</title>
</head>
<body style="background:#f8f8f8;">
	<!-- 头部 -->
	<?php $this->load->view('common/header'); ?>
    <!--    banner-->
	<div class="lvShare_banner">
		<img alt="" src="<?php echo base_url('static'); ?>/img/page/lyshare_02.png">
	</div>
	<div class="share_box">
		<!--    zxShare  最新分享-->
		<div class="zxShare">
			<div class="zxShare_conment">
				<div class="box_box" id=sales-product>
					<div class="module-title">
						<h3 class="title_txt">
							最新分享<span><a href="<?php echo base_url('share/share_detail/more_share?type=1'); ?>">更多>></a></span>
						</h3>
					</div> 
					<div class="js j_index_carouseProduct" id="sales-product-main" style="width: 1200px;">
						<ul class="share_list_ul">
				      	<?php foreach($new_share as $val) { ?>      
				          <li class="order1" onclick="share_list_ul(this);" val="<?php echo $val['id']?>">
				          	<a class="a1" href="javascript:void(0);" >
				          		<img alt="<?php echo $val['content']; ?>"
                                src="<?php echo base_url('static'); ?>/img/loading3.gif"
                                 data-original="<?php echo $val['cover_pic']; ?>" />
				          	</a>
							<div class="he_35"></div> <span><?php echo str_cut($val['content'],110); ?></span>
						</li>
						<?php } ?>
				      	</ul>
					</div>
				</div>
			</div>
		</div>
		<!--    drShare  分享达人-->
		<div class="drShare">
			<div class="drShare_title title_txt">
				分享达人<span><a href="<?php echo base_url('share/share_detail/more_share_man'); ?>">更多>></a></span>
			</div>
			<div class="drShare_conment">
				<ul class="drShare_list">
				<?php foreach($share_man as $val){ ?>
					<li><a class="a1" href="/share/share_detail/personal_share?share_man=<?php echo $val['mid'] ?>" target="_blank" > <img alt="<?php echo $val['truename']; ?>" src="<?php echo $val['litpic']; ?>" data-original="<?php echo $val['litpic']; ?>" /></a>
						<div class="drShare_xbox">
							<div class="drShare_name"><?php echo $val['truename']; ?></div>
							<div class="drShare_Number"><span>分享数：</span><?php echo $val['share_count'];?>条</div>
							<div class="drShare_Popularity"><span>人气：</span><?php echo $val['share_popularity'];?></div>
						</div></li>
				<?php } ?>
				</ul>
			</div>
		</div>
		<!--    otoShare  分享图片-->
		<div class="otoShare">
			<div class="otoShare_title title_txt">分享图片<span><a href="<?php echo base_url('share/share_detail/more_share?type=2'); ?>">更多>></a></span>
			</div>
			<div class="otoShare_conment">
				<ul class="share_list_ul">
				<?php foreach($share_img as $val){ ?>
					<li onclick="share_list_ul(this);" val="<?php echo $val['id']?>">
						<a class="a1" href="javascript:void(0);">
							<img alt="" src="<?php echo base_url('static'); ?>/img/loading3.gif" data-original="<?php echo $val['cover_pic']; ?>" />
						</a>
						<div class="he_30"></div> 
						<span>
							<div class="fenxiang_renqi">人气:<?php echo $val['popularity']; ?></div>
							<div class="fenxiang_zan">
								<img alt="" src="<?php echo base_url('static'); ?>/img/page/zan_05.png" data-original="<?php echo base_url('static'); ?>/img/page/zan_05.png" />赞:<?php echo $val['praise_count']; ?>							
							</div>
						</span>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
 <div class="hidden"> 
 <div class="heise">
 <div class="biaoti share_title"><h2>dasdasdasd</h2></div><span class="close"><h3>×</h3></span> 
<div class="scrolltab">
	<span id="sLeftBtnA" onclick="prev_pic();" class="sLeftBtnABan"></span>
	<span id="sRightBtnA" onclick="next_pic();" class="sRightBtnA"></span>
    <div class="yonghu">
    	<span>发布时间:<i class="share_addtime">2017-05-05 30:15:25</i></span>
    	<span>人气:<i class="share_popularity">20518</i></span><span>
   		<img src="../../../static/img/tour_icon_1.png" class="user_share_praise" />:<i class="share_praise_count">2518</i></span>
    </div>
    
	<ul class="ulBigPic clear">
		<li class="liSelected">
			<span class="sPic">
				<i class="iBigPic">
				<a href="javascript:void(0);" target="_blank" title="东南亚民族风的家 品味跨时空异域情怀">
				<img alt="大图" width="560" height="420" src="../../../static/img/cj_img.png" /></a></i>			
			</span>
		</li>
	</ul>
    <div class="yonghupx"></div>
	<div class="dSmallPicBox">
		<div class="dSmallPic">
			<ul class="ulSmallPic" style="width:9999px;left:0px" rel="stop">
				<!--这里放li是显示下面小图片-->
			</ul>
		</div>
		<span id="sLeftBtnB"  class="sLeftBtnBBan"></span>
		<span id="sRightBtnB"  class="sRightBtnB"></span>
	</div>
</div>
</div>
</div>

	<?php $this->load->view('common/footer'); ?>
<?php echo $this->load->view('common/login_box1');  ?>
</body>
</html>
<script>
    //上面的最新分享
	
	//向上移动动画
    $(".j_index_carouseProduct ul li").mousemove(function(){
        $(this).find("span").stop().animate({bottom: '33px'}, 100);
        });
    $(".j_index_carouseProduct ul li").mouseout(function(){
        $(this).find("span").stop().animate({bottom: '-2px'}, 100);
        });
    //向上移动动画
    $(".otoShare_conment ul li").mousemove(function(){
        $(this).find("span").stop().animate({bottom: '15px'}, 100);
        });
    $(".otoShare_conment ul li").mouseout(function(){
        $(this).find("span").stop().animate({bottom: '-15px'}, 100);
        });
		
		//点击关闭
        $(".close").click(function(){
           // location.reload();
            $(".hidden").hide();
        })
        //查看分享的相册
        function share_list_ul(obj){
        	 var id = $(obj).attr('val');
         	$.post("/share/share_detail/get_share_detail", { id: id },  function(json) {
 				var data = eval("("+json+")");
 				var html = "";
 				var str = "";
 				$.each(data.picData ,function(key ,val) {
 					html += '<li class="liSelected" key="'+key+'"><span class="sPic">';
 					html += '<i class="iBigPic"><a href="javascript:void(0);" >';
 					html += '<img width="862" height="438" src="'+val.pic+'" /></a></i></span>';
 					str += '<li class="liSelected">';
 					str += '<span class="sPic"><img src="'+val.pic+'" onclick="change_pic(this);" key="'+key+'" width="135" height="100" /></span>';
 					str += '</li>';
 				})
 				$(".share_title").find("h2").html(data.shareData.content.substring(0,20));
 				$(".share_addtime").html(data.shareData.addtime);
 				$(".share_popularity").html(data.shareData.popularity);
 				$(".share_praise_count").html(data.shareData.praise_count);
 				$(".user_share_praise").attr("val" ,data.shareData.id);
				if (data.is_praise == 1) {
					//用户点赞了，更改图标
					
				}
 				
 				$(".ulSmallPic").html(str);
 				$(".ulBigPic").html(html);
 				$(".hidden").fadeIn("show");
				 var tedkey=parseInt($(".ulBigPic .liSelected").attr("key"));
				 //alert(tedkey);
				$('.ulSmallPic li').siblings("li").css('border','1px solid #fff');
				$('.ulSmallPic li span img').css('border','1px solid #fff');
				$('.ulSmallPic li').eq(tedkey).css('border','1px solid #f54');
				$('.ulSmallPic li span img').eq(tedkey).css('border','1px solid #f54');
				$(".ulSmallPic li").click(function(){
						$(this).siblings("li").css('border','1px solid #fff');
						$(".ulSmallPic li").find("img").css('border','1px solid #fff');
						$(this).css('border','1px solid #f54');
						$(this).find("img").css('border','1px solid #f54');
					})
				 
             }) 
        }
    	function change_pic(obj) {
			var key = parseInt($(obj).attr("key"));
			$(".ulBigPic").find("li").hide().removeClass('liSelected');
			$(".ulBigPic").find("li").eq(key).addClass('liSelected').show();
        }
		function prev_pic(){
			var k = parseInt($(".ulBigPic").find(".liSelected").attr("key"));
			var max = parseInt($(".ulBigPic").find('li').length) -1;
			if ( k == 0) {
				return false;
			}
			var i = k - 1;
			$(".ulBigPic").find("li").hide().removeClass('liSelected');
			$(".ulBigPic").find("li").eq(i).addClass('liSelected').show();
		}
		function next_pic(){
			var k = parseInt($(".ulBigPic").find(".liSelected").attr("key"));
			var max = parseInt($(".ulBigPic").find('li').length) -1;
			if (k == max) {
				return false;
			}
			var i = k + 1;
			$(".ulBigPic").find("li").hide().removeClass('liSelected');
			$(".ulBigPic").find("li").eq(i).addClass('liSelected').show();
		}
		
		//点赞
		var s = true;
		$(".user_share_praise").click(function(){
			if (s == false) {
				return false;
			} else {
				s = false;
			}
			var userid = '<?php echo $this ->session ->userdata('c_userid');?>';
			if (userid == false) {
				 $('.login_box').css("display","block");
				 s = true;
				return false;
			}
			var id = $(this).attr('val');
			var praise = ($(".share_praise_count").html()) * 1;
			$.post("/share/share_detail/change_share_praise",{share_id:id},function(json){
				s = true;
				var data = eval('('+json+')');
				if (data.code == 2000) {
					if (data.msg == 1) {
						//增加点赞
						praise = praise + 1;
					} else {
						//取消点赞
						praise = (praise - 1) * 1;
						if (praise == 0) {
							praise = '0';
						}
					}
					$(".share_praise_count").html(praise)
				} else {
					alert(data.msg);
				}
			})
		})
		$("#login_form1").submit(function(){
			var username = $("#login_form1").find('input[name="username"]').val();
			$.post(
					"<?php echo site_url('login/do_login')?>",
					$('#login_form1').serialize(),
					function(data) {
						data = eval('('+data+')');
						if (data.code == 2000) {
							alert("登陆成功");
							$('.login_box').css("display","none");
							$(".header_top_fr").find('a').eq(2).remove();
							$(".header_top_fr").find('a').eq(1).remove();
							$(".header_top_fr").find('a').eq(0).after('<a href="/login/logout">退出</a>');
							$(".header_top_fr").find('a').eq(0).after('<a href="/order_from/order/line_order" class="username">您好，'+username+'</a>');
						} else {
							$('#verifycode').trigger('click');
							$('.info span a').html(data.msg);
							$('.info span').show();
						}
					}
				);
				return false;
		})
        
		//替换图片的src地址;用来显示大图
		$(".scroll_list ul li").click(function(){
			var src = $(this).find("img").attr("src");
				$(".xiashi img").attr("src",src);
			})
			
			

</script>

<script type="text/javascript">
	//lazy() ; //初始化 
//	$(document).scroll(function(){//滚动的时候调用
//		lazy();
//	});  
//	function lazy(){
//		var winH = $(window).height();
//		var scrollTop = parseInt($(document).scrollTop());
//		$('img').each(function(i){
//			var imgTop = parseInt($('img').eq(i).offset().top);
//			//log("第:"+i+"  winH:"+winH+"imgTop:"+imgTop+",scrollTop:"+scrollTop);
//			if( (imgTop<=scrollTop+winH+50 )&& $(this).is(":visible")  )     {
//				$('img').eq(i).attr('src',$('img').eq(i).attr('data-original'));
//			}
//		});
//	}
</script>
<script type="text/javascript"> 
$(function() { 
    $(".drShare_conment img").lazyload({
		effect : "fadeIn" 
		});
	$(".otoShare img").lazyload({
		effect : "fadeIn" 
		});
	$(".zxShare img").lazyload({
		effect : "fadeIn" 
		});
}); 
 
</script> 
