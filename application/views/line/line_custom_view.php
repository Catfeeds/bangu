<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title;?></title>
<meta name="keywords" content="定制旅游,私人定制游,高端定制游,定制游价格">
<meta name="description" content="<?php echo $description;?>">
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static'); ?>/css/diy.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/plugins/choice_city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>

</head>
<body style="background:#fff; width: 100%;">
    <!-- 头部 -->
	<?php $this->load->view('common/header'); ?>
    <div class="custom_list_banner" style="background: url(../../static/img/page/dingzhiliebiao.jpg) no-repeat center top;"></div>
    <div class="search_style float" id="float">
    	
      <div class="formBottom">
      <div class="form_bxx"> 
        <form action="<?php echo $destUrl ?>" method="get" class="form_flo">
            <div class="mudidi_directory">
              <div class="dingzhi_title">定制案例:</div>
                <ul class="click_Source">
                    <li class="choice_all hiddenli_click" value="1000">
                    	<a href="/dzy" ><span style=" display: block;">全部案例</span></a>
                    </li>
                    <li value="0">
                        <div class="titleSource">出发时间</div>
                        <div class="monthBox">
                        <div class="monthZs">出发时间</div>
                        <ul class="clear choise_month months ">
                          <?php 
                            $a = 1;
                            for($a ; $a<=12 ;$a++)
                            {
                              if (isset($month) && $a == $month)
                              {
                                echo '<li class="hiddenli_click"><a href="'.$monthUrl.'_m-'.$a.'.html">'.$a.'月</a></li>';
                              }
                              else 
                              {
                                echo '<li><a href="'.$monthUrl.'_m-'.$a.'.html">'.$a.'月</a></li>';
                              }
                              
                            }
                          ?>
                        </ul>
                      </div>
                    </li>
                    <li value="1"> 
                        <div class="titleSource">人均预算</div>
                        <div class="priceBox">
                          <div class="priceZs">人均预算</div>
                          <ul class="choice_price">
                              <?php
                                foreach($priceArr as $val) {
                                  if ($val['maxprice'] <= 0) {
                                    $max = '以上';
                                  } else {
                                    $max = '-'.$val['maxprice'];
                                  }
                                  if (isset($minprice) && isset($maxprice) && $minprice == $val['minprice'] && $maxprice == $val['maxprice'])
                                  {
                                    echo '<li class="hiddenli_click"><a href="'.$priceUrl.'_pr-'.$val['minprice'].'-'.$val['maxprice'].'.html">'.$val['minprice'].$max.'<a></li>';
                                  }
                            else 
                            {
                              echo '<li><a href="'.$priceUrl.'_pr-'.$val['minprice'].'-'.$val['maxprice'].'.html">'.$val['minprice'].$max.'</a></li>';
                            }
                                }
                            ?>
                        </ul>
                        </div>
                    </li>                  
				</ul>
				<span class="custom_search_input fl">
				<input type="text" placeholder="搜索目的地" id="customDestName" value="<?php if(!empty($destName)){echo $destName;}?>" name="endplace"/>
				<i class="submit_condition"></i>
				<input type="hidden" name="customDestId" value="<?php if(!empty($destid)){echo $destid;}?>" id="customDestId">
				</span>
				<span class="Jump_dingzhi fl"><a href="<?php echo base_url('srdz');?>">我要定制</a></span>
                <div class="hidden_cumlist">
                    
                    
				      </div>
          </div>
		  </form>
		</div>
    </div>
	</div>
    <div class="w_1200" >
    	<div id="container">
	    	<div id="main" role="main">
				<ul id="tiles">
				<?php foreach($customData as $val):?>
				<li>
					<div class="list_cdimg">

						<a href="<?php echo site_url('dzy/'.$val['id'].'.html')?>">
  						<div class="dingzhi_img">
    							<img  data-original="<?php echo $val['pic']?>" src="<?php echo base_url('static'); ?>/img/loading0.gif" alt="<?php echo $val['question']?>">
  						</div>
              <div class="dingzhi_time">
             <?php 
                if (!empty($val['startdate'])) {
                  echo date('m月d日' ,strtotime($val['startdate']));
                } else {
                  echo $val['estimatedate'];
                }
              ?>
              </div> 
						</a>
						
					</div>

					<a href="<?php echo site_url('dzy/'.$val['id'].'.html')?>">
						<h3 class="text_fatil"><?php echo $val['question']?></h3>
					</a>
					<div class="Publish_yaoqiu">
						<span>购物：<?php echo $val['shopping']?></span>
						<span style="float:right; text-align:right;">人均：<i>¥<?php echo $val['budget']?></i></span>
					</div>
					<div class="Publish">
                                            <!-- 将guanj改为guanjia,添加后缀.html 魏勇编辑-->
						<a href="<?php echo site_url('guanjia/'.$val['eid'].'.html')?>">
							<img src="<?php echo $val['small_photo']?>" alt="<?php echo $val['nickname']?>" class="Publish_head_photo">
              <div class="Publ_laiz"> 案例来自:</div>
							<div class="Publish_name"><?php echo $val['nickname']?></div>
						</a>
						<div class="Publish_data">
            <a href="/srdz/c-<?php echo $val['id'].'.html'?>">
              <div class="wydz_btn" style="display:block">我要定制</div>
            </a>
           
            
						</div>
					</div>
				</li>
				<?php endforeach;?>
			    </ul>
          <div style=" display:block; width:100%; clear:both">
			       <ul class="pagination"><?php echo $this ->page->create_page();?></ul>
          </div>
			</div>
			<?php 
				if (count($customData) == 0):
			?>
            <div class="wanshi"><img src="../../../static/img/end_data.png"></div>
            <?php endif;?>
		</div>
    </div>
    <!-- 尾部 -->
<div class="footes"><?php  echo $this->load->view('common/footer'); ?></div>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script type="text/javascript">
//目的地
 $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"customDestName",
		valId:"customDestId",
		blurDefault:true
	});
});
//点击搜索
$('.submit_condition').click(function(){
	var destid = $("#customDestId").val();
	var destName = $("#customDestName").val();
	var url = $(this).parents("form").attr("action");
	if (destid > 0) {
		url = url+'_d-'+destid;
	}
	if (destName.length >0) {
		url = url+'_dn-'+destName;
	}
	if (url == '/dzy/' || url == '/dzy') {
		location.href="/dzy";
	} else {
		location.href=url+'.html';
	}
})
    //鼠标移入标签筛选 float 部分
  $(function(){
      $(".click_Source>li").hover(function(){
          $(this).find(".monthBox, .priceBox").show();
      },function(){
          $(this).find(".monthBox, .priceBox").hide();
      });
})
</script>
</body>
</html>
<script type="text/javascript">
    (function ($){
      function applyLayout() {
        $tiles.imagesLoaded(function() {
          // Destroy the old handler
          if ($handler.wookmarkInstance) {
            $handler.wookmarkInstance.clear();
          }
          // Create a new layout handler.
          $handler = $('li', $tiles);
          $handler.wookmark(options);
        });
      }
	  var onloads = false;
	  var page_size = 10; //每页10条
	  $('input[name="page_size"]').val(page_size);
	  var page = 2;//从第二页获取数据
      applyLayout();
      $window.bind('scroll.wookmark', onScroll);
  	//月份选择
  	$('.choise_month li').click(function() {
  		$(this).addClass('custom_active').siblings().removeClass('custom_active');
  		$(this).parent().hide();
  		$('input[name="month"]').val($(this).attr('value'));
  		get_ajax_page();
  	})
  	//价格选择
      $('.choice_price li').click(function() {
  		$(this).addClass('custom_active').siblings().removeClass('custom_active');
        $(this).parent().hide();
  		$('input[name="minprice"]').val($(this).attr('min'));
  		$('input[name="maxprice"]').val($(this).attr('max'));
  		get_ajax_page();
  	})
  	//点击全部
  	$('.choice_all').click(function(){
  		$('.choise_month,.choise_price li').find('.custom_active').removeClass('custom_active');
  		$('input[name="endplace"]').val('');
  		$('input[name="month"]').val(0);
  		$('input[name="minprice"]').val(0);
  		$('input[name="maxprice"]').val(0);
		$(".hiddenli_click").removeClass();
  		get_ajax_page();
		
    });
 //一定高度是自动固定定位
 </script>
 <script>
 	h=$("#float").offset().top;
 //alert(h)
    window.onscroll=function(){
    	//alert(h)
        if ($(window).scrollTop() >635 ) {
            $("#float").addClass("fix_title_nav");
        } else {
            $("#float").removeClass("fix_title_nav");
        }
    }
</script>
<script>
$(function(){
  		$(".dingzhi_img img").lazyload({
            effect : "fadeIn"
        });
  	})
</script>



