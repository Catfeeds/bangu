<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title;?></title>
	<meta name="keywords" content="<?php echo $keywords;?>" />
	<meta name="description" content="<?php echo $description;?>" />
  <link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
	<link href="<?php echo base_url('static'); ?>/css/line_list.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('static'); ?>/css/line_detail.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />

	<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('static/js/lubotu.js'); ?>"></script>
</head>

<body style="background:#fff; ">
<div>
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<!-- 头部轮播图 -->
<div class="lunbo">
    <div class="img_banner">
        <div class="img_list lubo">
            <ul class="lubo_box">
              <?php
                foreach ($rollPic as $key=>$val){
                  if ($key == 0) {
                    echo "<li style=' opacity: 1; z-index:1;filter:alpha(opacity=100);'><a href='{$val['link']}' style='background:url({$val['pic']}) center top no-repeat'></a></li>";
                  } else {
                    echo "<li><a href='{$val['link']}' style='background:url({$val['pic']}) center top no-repeat'></a></li>";
                  }
                }
              ?>
            </ul>
        </div>
    </div>
</div>
<!-- 头部轮播图结束 -->
<div class="container clear">
    <div class="weizhi">
			  <div class="place">
				    <span>您的位置：</span>
				    <a href="<?php echo sys_constant::INDEX_URL?>">首页</a>
				    <span class="_jiantou">></span>
				    <a href="/line/line_list">线路列表</a>
				    <?php if (array_key_exists($type ,$destNavArr)):?>
	           	 <span class="_jiantou">></span><h1><a href="#"><?php echo $destNavArr[$type]?></a></h1>
	          <?php endif;?>
			 </div>
    </div>
    <div class="containerContext">
      	<!-- 目的地，标签，游玩天数选择 -->
      	<div class="travelNav">
	        	<ul class="travelNavList clear">
	          	<?php
	          	  	foreach($destNavArr as $key =>$val) {
	          	  		if ($type == $key) {
							$active = 'travelNavListOn';
	          	  		} else {
	          	  			$active = '';
	          	  		}
	          	  		echo '<a href="'.site_url($key.'\/').'"><li class="travelNavListButton '.$active.'">'.$val.'</li></a>';
	          	  	}
	          	 ?>

	        	</ul>
            <div class="travelNavSelect">
					      <div class="mudidi_directory">
                    <h2>旅游线路:</h2>
                    <span class="zhanxian"><img src="../../../static/img/bottom.png"></span>
                    <ul class="click_Source" id="lineDestUl">
                    	<?php
                    		$k = 0;
                    		foreach($lineType as $key=>$val) {
                    			if($type == 'zhoubian' || $type == 'zhuti') {
                    				echo '<a href="'.$val['link'].'"><li>'.$val['kindname'].'</li></a>';
                    			} else {
                    				echo '<li data-val="'.$k.'">'.$val['kindname'].'</li>';
                    				$k ++;
                    			}
                    		}
                    	?>
                    </ul>
                    <div class="hidden_list" id="lineDestLower">
                    	<?php
                    		foreach($lineType as $key=>$val) {
                    			echo '<ul>';
                    			if (isset($val['lower'])) {
                      			foreach($val['lower'] as $v) {
                      				echo '<a href="'.$v['link'].'"><li>'.$v['kindname'].'</li></a>';
                      			}
                    			}
                    			echo '</ul>';
                    		}
                    	?>
                    </div>
                </div>
					      <div class="mudidi_directory2">
                    <h2>产品标签:</h2>
                    <span class="zhanxian"><img src="../../../static/img/bottom.png"></span>
                    <ul class="click_Source2" id="lineAttrUl">
                        <?php
                        	$k = 0;
                        	foreach($lineAttr as $key =>$val) {
                        		echo '<li data-val="'.$k.'">'.$val['attrname'].'</li>';
                        		$k ++;
                        	}
                        ?>
                    </ul>
                    <div class="hidden_list2" id="lineAttrLower">
                        <?php
                        	foreach($lineAttr as $key=>$val) {
                        		echo '<ul>';
                        		foreach($val['lower'] as $v) {
                        			echo '<a href="'.$v['link'].'"><li>'.$v['attrname'].'</li></a>';
                        		}
                        		echo '</ul>';
                        	}
                        ?>
                    </div>
                </div>
          	</div>
      	</div>
      <!-- 目的地，标签，游玩天数选择结束 -->
      <!-- 搜索标签 -->
        <?php
        	if(!empty($buttonArr)):
        ?>
    		<div class="userchoices">
    			  <span style="float:left;margin-right:18px;"><h2>您已选择:</h2></span>
            <ul class="choice">
              <?php
              	foreach($buttonArr as $val) {
              		echo '<li data-val="'.$val['link'].'"><span>'.$val['name'].'</span><em class="labelClose"></em></li>';
              	}
              ?>
      		</ul>
        </div>
        <?php endif;?>
        <!-- 搜索标签结束 -->
        <div class="toolbarList" id="toolbarList">
       	 <!-- 排序 -->
            <ul class='search_line_order'>
            		<li class="<?php if(empty($order)){echo 'toolbaron';}?> search_line">
            			  <a href="<?php echo $orderUrl.'_o-0.html'?>">帮游推荐</a>
            		</li>
            		<li class="<?php if(!empty($order) && $order == 1){echo 'toolbaron';}?> search_line">
              			<i class="xiaoliang"></i>
              			<a href="<?php echo $orderUrl.'_o-1.html'?>">销量</a>
            		</li>
            		<li class="<?php if(!empty($order) && $order == 2){echo 'toolbaron';}?> search_line">
              			<i class="xiaoliang"></i>
              			<a href="<?php echo $orderUrl.'_o-2.html'?>">好评</a>
            		</li>
            		<li class="<?php if(!empty($order) && $order == 3){echo 'toolbaron';}?> search_line">
              			<i class="xiaoliang"></i>
              			<a href="<?php echo $orderUrl.'_o-3.html'?>">天数</a>
            		</li>
            		<li class="<?php if(!empty($order) && $order == 4){echo 'toolbaron';}?> search_line">
              			<i class="xiaoliang"></i>
              			<a href="<?php echo $orderUrl.'_o-4.html'?>">价格</a>
            		</li>
            </ul>
            <div class="priceInput price">
                <span>
				            <input type="text" placeholder="最低价" value="<?php if(!empty($minprice)){echo $minprice;}?>" name='minPrice'>
                    —
                   <input placeholder="最高价" value="<?php if(!empty($maxprice)){echo $maxprice;}?>" name="maxPrice">
              </span>
            </div>

            <div class="priceInput price">
                  <span>线路名称：
                      <input placeholder="" name="lineKeyWord" value="<?php if(!empty($keyword)){echo $keyword;}?>" style="width:100px;">
                	</span>
            </div>
            <div id="pagerSats">
                <a href="<?php if($page+1 > $count) {echo $url.'_pa-'.$count.'.html';}else{echo $url.'_pa-'.($page+1).'.html';}?>"><span class="pagerGt">&gt;</span></a>
                <a href="<?php if($page-1 < 1) {echo $url.'_pa-1.html';}else{echo $url.'_pa-'.($page-1).'.html';}?>"><span class="pagerGt">&lt;</span></a>
                <span class='page_new_count' ><?php if($count == 0) {echo '0';} else{echo $page;}?>/<?php echo $count?></span>
            </div>
           <i class="search" id="searchLine" data-url="<?php echo $surl;?>"></i>
           <!--<a href="<?php //echo $surl;?>" id="searchLineUrl"></a>-->       <!--注释掉这个a标签-->
      </div>
      <!-- 排序价格搜索结束 -->

      <!-- 路线列表 -->
		  <div class="lineLists line_list_data">
			<?php
				foreach($lineArr as $key=>$val):
                                // seo优化，将cj改为chujing,并给链接加.html后缀;gn改为chujing,并给链接加.html后缀;
				//$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/cj/'.$val['lineid'] : '/gn/'.$val['lineid'];
                //$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html';
                $line_url = '/line/'.$val['lineid'].'.html';
			?>
			<div class="lineList">
      		<div class="fl line_list_img">
      				<a href="<?php echo $line_url;?>" target="_blank">
      					 <img style="display: inline;" class="lineListImg" alt="<?php echo $val['linename']?>" src="<?php echo base_url('static/img/loading0.gif'); ?>" data-original="<?php echo $val['mainpic']?>" />
      				</a>
      		</div>
      		<div class="fl lineListContext">
      				<div class="fl lineListIntroduce">
      					 <a href="<?php echo $line_url;?>" target="_blank">
        						<div class="lineListIntros">
        							<span class="lineListIntro"><?php echo $val['linename']?></span>
        							<span class="linelist_title2"><?php echo str_cut($val['linetitle'],45)?></span>
        						</div>
      					  </a>
        					<div class="recommends">
        						<span class="recommend">特色推荐：<?php echo strip_tags($val['features'])?></span>
        					</div>
      				</div>
      				<div class="fr lineListMessage">
      					  <div class="linelistPersonNum clear">
	      					    <div class="lineListprices">¥ <span class="lineListprice"><?php echo $val['lineprice']?> 起</span></div>
    	      					<div class="manyis clear">
      	      						<span class="manyi fl">满意度<span class="manyiduFont" style="padding:0 0 0 5px;">
      	      						<?php 
      	      							$satisfyscore = $val['sati_vr'] +$val['satisfyscore'];
      	      							if($satisfyscore > 0) {
      	      								if ($satisfyscore >100) {
      	      									echo '100%';
      	      								} else {
      	      									echo round($satisfyscore*100,0).'%';
      	      								}
      	      							} else {
      	      								echo '暂无';
      	      							}
      	      						?>
      	      						</span></span>
      	      						<span class="sale_people fl">已销<span class="manyiduFont"><?php echo $val['peoplecount']?></span>人</span>
    	      					</div>
      					  </div>
        					<div class="lineListButton">
          						<a><span class="follow_server_link" data-val='<?php echo $val['lineid']?>'>咨询管家</span></a>
          						<a href="<?php echo $line_url;?>" target="_blank"><span class="lijiyuding">去看看</span></a>
        					</div>
      				</div>
      		</div>
      		<div class="lineListFooter fl"></div>
      		<div class="lineListChufa" style=" width:200px;">
      				<i class="lineListMun_img"></i>
      				<span class="xinxi"></span>
      				<a href="<?php echo $line_url;?>" target="_blank">
      					  <span class="txt_link1"><?php echo $val['dates']?><span style="padding-left:5px;">更多</span></span>
      				</a>
      		</div>
      		<div class="lineListXPmun">
      				<div class="lineListMun">
        					<i class="lineListMun_img2"></i>
        					<span class="xinxi">评价：</span><?php echo $val['comment_count']?>
      				</div>
      		</div>
    			<div class="lineListZhusu">
      				<i class="zhusu_img"></i><span class="xinxi"></span>
      				<span>总积分:<?php echo $val['all_score']?></span>
    			</div>
    			<div class="lineListlink">
    				  <a class="txt_link" href="<?php echo site_url('youji');?>" target="_blank" style=" color:#164dff">体验分享<i></i></a>
    			</div>
    			<div class="lineListlink">
    				  <a class="txt_link" href="<?php echo $line_url;?>" target="_blank" style=" color:#164dff">看产品<i></i></a>
    			</div>
      </div>
      <?php endforeach;?>

			<p class="searchNoLine" <?php if(count($lineArr) >0){echo 'style="display:none;"';}?>>
				  <a href="<?php echo site_url('srdz')?>"><img src="<?php echo sys_constant::LINE_DEFAULT_PIC; ?>" /></a>
			</p>
      <div style="width: 100%; display: inline-block;">
      <ul class="pagination"><?php echo $this->page->create_page();?></ul>
      </div>
      </div>
      <!-- 路线列表结束 -->
    </div>
      <!-- 右侧排列 -->
      <!-- 注意 : 次地方采用绝对定位固定位置,如果页面头部高度有变化或者宽度有变化,请改变类名为containerRight的属性margin-right和margin-top-->
      <div class="experience_right_side fr" style="top:-10px;">
          <div class="right_side_content">
        	    <h4 class="hot_experience_line">销量排行</h4>
              <div>
                	<ul class="hot_experience_line_list clear">
                     	<?php
                     		foreach($hotLine as $key =>$val):
                     		//$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/cj/'.$val['id'] : '/gn/'.$val['id'];
                            //$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html';
                            $line_url = '/line/'.$val['id'].'.html';
                     	?>
                    	<li class="clear" title="<?php echo $val['linename'];?>">
                        	<div class="hot_line_info">
                          		<a href="<?php echo $line_url; ?>" target="_blank">
                                  <div class="hot_line_num fl"><span><?php echo $key+1;?></span></div>
                                  <div class="hot_line_txt fl"><?php echo str_cut($val['linename'] ,42)?><div class="hot_line_price fr">
                                  <span>¥ </span><?php echo $val['lineprice']?> </div></div>
                              </a>
                          </div>
                              <div class="hot_line_cover">
                                	<a href="<?php echo $line_url;?>" target="_blank">
                                	    <img src="<?php echo $val ['mainpic'] ?>" alt="<?php echo $val['linename']?>" width="230" height="130"/>
                                      <div class="cover_info">
                                        	<div class="cover_num fl"><span><?php echo $key+1?></span></div>
                                        	<div class="cover_txt fl"><?php echo str_cut($val['linename'],42)?><div class="cover_price fr">
                                          <span>¥</span> <?php echo $val['lineprice']?> </div></div>
                                      </div>
                                  </a>
                              </div>
                        </li>
                        <?php endforeach;?>
                    </ul>
              </div>
          </div>
      </div>
  	<!-- 内容结束 -->
    </div>
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
<?php $this->load->view('common/choice_expert'); ?>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script>
$(function(){ $(".lubo").lubo({});})

var isIE=!!window.ActiveXObject;
var isIE6=isIE&&!window.XMLHttpRequest;
var isIE8=isIE&&!!document.documentMode;
var isIE7=isIE&&!isIE6&&!isIE8;
if (isIE6){
    $(".xiaoliang").remove();
    $(".lineListFooter").remove();
}
</script>
<script>
$(function(){
	//管家咨询获取线路的管家
	$(".follow_server_link").click(function(){
		var lineid = $(this).attr("data-val");//线路ID
		$("#choiceExpertForm").find("input[name='line_id']").val(lineid);
		$("#lineExpertList").choiceExpert();
		$(".determine_button").hide(); //隐藏确定按钮
	});
	//点击线路属性导航，改变颜色以及将下级展示出来
	$("#lineAttrUl").find("li").click(function(){
		var key = $(this).attr("data-val");
		$(this).css("background","#f2f2f2").siblings().css("background","#fff");
		$("#lineAttrLower").find("ul").eq(key).show().siblings().hide();
	})
	//点击目的地导航，改变颜色以及将下级展示出来
	$("#lineDestUl").find("li").click(function(){
		var key = $(this).attr("data-val");
		$(this).css("background","#f2f2f2").siblings().css("background","#fff");
		$("#lineDestLower").find("ul").eq(key).show().siblings().hide();
	})
	//搜索价格or线路名称
	$("#searchLine").click(function(){
		var minprice = $("input[name='minPrice']").val();
		var maxprice = $("input[name='maxPrice']").val();
		var keyword = $("input[name='lineKeyWord']").val();
		var url = $(this).attr("data-url");
		if (minprice >0 || maxprice >0) {
			if (minprice == 0) {
				minprice = 0;
			}
			if (maxprice == 0) {
				maxprice = 0;
			}
			url = url+'_p-'+minprice+'-'+maxprice;
		}
		if (keyword.length >0) {
			url = url+'_kw-'+keyword;
		}
                // 将cj改为chujing,gn改为guonei,zb改为zhoubian,zt改为zhuti
		//if (url == '/all/' || url=='/cj/' || url=='/gn/' || url == '/zb/' || url == '/zt/') {
                if (url == '/all/' || url=='/chujing/' || url=='/guonei/' || url == '/zhoubian/' || url == '/zhuti/') {
                    /** 将url.leng - 1改为url.length,以保留后面的斜杠    魏勇编辑**/
			location.href=url.substring(0 ,url.length );
		} else {
			location.href=url+'.html';
		}
	})
	//删除搜索的显示按钮
	$(".labelClose").click(function(){
		var href=$(this).parent("li").attr("data-val");
		location.href=href;
	})
})
</script>

<script>
		//客服js
     function kefu_url_line(obj){
      	var lineid = $(obj).attr('data-val');
      	var url='/kefu_webservices/get_b2_one_data?lineid='+lineid;
      	var memberid='<?php echo $this->session->userdata('c_userid');?>';
	$.get(url,{lineid:lineid},function(data){
		var b2_one_dataObj=JSON.parse(data);
		//console.log(b2_one_dataObj);
		if(b2_one_dataObj == "" || b2_one_dataObj == undefined || b2_one_dataObj == null){alert('此线路下没有在线管家！');}else{
			var expertid=b2_one_dataObj[0]['id'];
			window.open('<?php echo $web['expert_question_url']; ?>'+'/kefu_member.html?mid='+memberid+'&eid='+expertid);
		}
	});
}
</script>

<script>
	$(function(){
		$(".ajax_page").css("border","none")
	})
      $(".zhanxian").click(function(){
          $(this).siblings(".click_Source").toggleClass("height_auto")
      });

	var j = true;
      $(".zhanxian").click(function(){
          $(this).siblings(".click_Source2").toggleClass("height_auto");
          if (j == true) {
        	  $(this).find("img").attr("src",'../../../static/img/top.png');
        	  j = false;
          } else {
        	  $(this).find("img").attr("src",'../../../static/img/bottom.png');
        	  j = true;
          }

      });
</script>
</body>
</html>
<script type="text/javascript">
$(function(){
		//右侧边栏 鼠标移上效果
		$(".hot_experience_line_list li").eq(0).find(".hot_line_info").hide();
		$(".hot_experience_line_list li").eq(0).find(".hot_line_cover").fadeTo("slow", 0.99)
		$(".hot_experience_line_list li").hover(function(){
				$(".hot_line_info").show();
				$(".hot_line_cover").hide();
				$(this).children(".hot_line_info").hide();
				$(this).children(".hot_line_cover").fadeTo("slow", 0.99);
		});
})

$(document).on("mouseover",".choice li",function(){
	$(this).addClass("current_this");
});
$(document).on("mouseout",".choice li",function(){
	$(this).removeClass("current_this");
});
</script>
<script type="text/javascript">
$('#click_show_more').click(function() {
	$('#more_lines').show();
});
</script>
<script type="text/javascript">
	$(function(){
        $("img").lazyload({
            effect : "fadeIn"
        });
    })
</script>
