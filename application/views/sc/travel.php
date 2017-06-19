<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>效果demo</title>
<link href="<?php echo base_url('file/sc/css/sc_index.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('file/sc/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('file/sc/js/jquery-tab.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>
<style type="text/css">
.tarvel_content a { color:#252525;}
.tarvel_content { font-family:"宋体";font-size:12px;}
.travel_title { border-bottom:1px solid #c2c2c2;height:40px;line-height:40px; clear:both;}
.travel_title .title_txt { color:#3f3f3f;font-weight:bold;padding:0 20px;font-size:16px;font-family: "微软雅黑";}
.travel_title .title_txt:hover { color:#D81510;text-decoration:underline;}
.problem_intrduce a:hover p { color:#D81510;}
.line_price { padding-top:5px;}
.sj { width: 0; height: 0; border-width: 0 5px 5px; border-style: solid; border-color: transparent transparent #c2c2c2; position: relative; top: -5px;left: 45px;}
.sj i { display: block; width: 0; height: 0; border-width: 0 10px 10px; border-style: solid; border-color: transparent transparent #fff; position: absolute; top: 1px; left: -10px;}
.right_link { color:#999;padding-right: 20px;position:absolute;right:0px;top:0px;height:40px;line-height:40px;font-family:"";}
.right_link a { padding: 0px 5px; color: #666;}

/*============旅游管家===========*/
.img_details { width:226px;height:226px;margin:1px;}
#img_href { display:block;position:relative;}
.cover_info { height:44px;position:absolute;width:100%;left:0;top:182px !important;color:#fff;font-family:"微软雅黑";background:rgba(0, 0, 0, .5);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);}

#img_href img { width:226px;height:226px;}
.travel_expert_list ul li a { height:110px !important;}
.gj_img_list { width:456px;}
.gj_img_list li { float:left;width:110px !important;height:110px !important;border:2px solid #fff;}
.gj_img_list li a img { width:110px;height:110px;}
.gj_img_list li.on { border:2px solid #cdc611;}
.expertName { font-size:18px;padding:0 5px;display:inline-block;width:72px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;line-height:44px;text-align:center;}
.place { font-size:14px;line-height:22px;padding:0 20px;background:url(<?php echo base_url();?>static/img/sc/weizhi.png) 0 center no-repeat;}
.expertGrade { line-height:22px;font-size:14px;}
.expertServe  { display:inline-block;width:144px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;line-height:22px;font-size:14px;}
</style>
</head>
<body>
<div class="tarvel_content">
	<div class="travel_title">
    	<a href="http://travel.shenchuang.com/" target="_blank"><span class="title_txt">深圳旅游&nbsp;|&nbsp;管家</span></a>
        <div class="sj"><i></i></div>
        <span class="right_link fr">
        	<a href="http://www.1b1u.com/guanj" target='_balnk'>旅游咨询</a>|
            <a href="http://www.1b1u.com/cj" target='_balnk'>旅游产品</a>|
            <a href="http://www.1b1u.com/dzy" target='_balnk'>个人定制</a>
        </span>
    </div>
    <div class="travel_info clearfix">
            <!-- 新闻 Start -->
    	<div class="text_info fl">
        	<div class="travel_problem">
            	<a href="<?php echo $url['sc_consult_detail'].'?id='.$swz1[0]['id']; ?>" target="_blank">
                    <div class="line_img"><img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo BANGU_URL.$swz1[0]['pic'];?>"/></div>
                </a>
                <div class="problem_intrduce">
                    <a href="<?php echo $url['sc_consult_detail'].'?id='.$swz1[0]['id']; ?>" target="_blank">
                    <p class="title"><?php echo $swz1[0]['title'];?></p></a>
                </div>
            </div>
            <ul class="problem_list">
            <?php foreach ($wz  as $k=>$v){?>
                <li><a href="<?php echo $url['sc_consult_detail'].'?id='.$v['id']?>" target="_blank"><?php echo $v['title']?></a></li>
                <?php }?>
            </ul>
        </div>
        <!-- 新闻 End-->
        <div class="line_info fr">
        	<div class="line_info_type">
                <ul>
                    <li class="current">出境游</li>
                    <li>国内游</li>
                    <li>周边游</li>
                    <li>主题游</li>
                    <li>旅游管家</li>
                </ul>
                <span></span>
            </div>
            <div class="line_content clearfix">
            <!-- 出境游 Start-->
                <div class="item_content">
                	<ul>
                    <?php foreach ($orderByLine['cj'] as $k=>$v) {?>
                    	<li class="on">
                            <!-- 将cj和gn改为line,添加后缀.html-->
                                <a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>"  target="_blank">
                        	<div class="list_img"><img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo BANGU_URL.$v['mainpic'];?>"/></div>
                        	<div class="line_detail_info">
                            	<span class="line_price">¥<i><?php echo $v['lineprice']?></i>元</span>
                                <span class="satisfaction">满意度:<i><?php echo (!empty($v['satisfyscore']) &&$v['satisfyscore']!=0) ? ($v['satisfyscore']*100) : 100 ?>%</i></span>
                                <p class="line_text"><?php echo $v['linename']?></p>
                            </div>
                            </a>
                        </li>
                    <?php }?>
                    </ul>
                </div>
                <!-- 出境游 End-->

                <!-- 国内游 Start-->
                <div class="item_content">
                	<ul>
                    <?php foreach ($orderByLine['gn'] as $k=>$v) {?>
                    	<li>
                            <!-- 将cj和gn改为line,添加后缀.html-->
                        <a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>" target="_blank">
                        	<div class="list_img"><img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo BANGU_URL.$v['mainpic'];?>"/></div>
                        	<div class="line_detail_info">
                            	<span class="line_price">¥<i><?php echo $v['lineprice'];?></i>元</span>
                                <span class="satisfaction">满意度:<i><?php echo (!empty($v['satisfyscore']) &&$v['satisfyscore']!=0) ? ($v['satisfyscore']*100) : 100 ?>%</i></span>
                                <p class="line_text"><?php echo $v['linename'];?></p>
                            </div>
                        </a>
                        </li>
                    <?php }?>
                    </ul>
                </div>
                <!-- 国内游 End-->

                <!-- 周边游 Start -->
                <div class="item_content">
                	<ul>
                    <?php foreach ($orderByLine['zb'] as $k=>$v) {?>
                    	<li>
                            <!-- 将cj和gn改为line,添加后缀.html-->
                        <a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>"  target="_blank">
                        	<div class="list_img"><img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo BANGU_URL.$v['mainpic'];?>"/></div>
                            <div class="line_detail_info">
                                <span class="line_price">¥<i><?php echo $v['lineprice'];?></i>元</span>
                                <span class="satisfaction">满意度:<i><?php echo (!empty($v['satisfyscore']) &&$v['satisfyscore']!=0) ? ($v['satisfyscore']*100) : 100 ?>%</i></span>
                                <p class="line_text"><?php echo $v['linename'];?></p>
                            </div>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <!-- 周边游 End -->

                <!-- 主题游 Start -->
                <div class="item_content">
                	<ul>
                    	 <?php foreach ($orderByLine['zt'] as $k=>$v) {?>
                        <li>
                        <a href="<?php echo $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>"  target="_blank">
                            <div class="list_img"><img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo BANGU_URL.$v['mainpic'];?>"/></div>
                            <div class="line_detail_info">
                                <span class="line_price">¥<i><?php echo $v['lineprice'];?></i>元</span>
                                <span class="satisfaction">满意度:<i><?php echo (!empty($v['satisfyscore']) &&$v['satisfyscore']!=0) ? ($v['satisfyscore']*100) : 100 ?>%</i></span>
                                <p class="line_text"><?php echo $v['linename'];?></p>
                            </div>
                            </a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <!-- 主题游 End -->

                <!-- 旅游管家 Start -->
                <div class="travel_expert_list clear">
                	<div class="img_details fl">
                            <!-- 添加后缀.html 魏勇编辑-->
                        <a href="<?php echo $url['guanj'].$expertData2[0]['eid'].'.html' ;?> " target="_blank" id="img_href"><img src="<?php echo site_url('static/img/loading1.gif'); ?>" data-original="<?php echo BANGU_URL.$expertData2[0]['pic']; ?>" class="gj_img">
                        	<div class="cover_info">
                                <span class="expertName fl"><?php echo $expertData2[0]['nickname']?></span>
                                <span class="place fl"><?php echo $expertData2[0]['cityname']?></span>
                                <span class="expertGrade fl"><?php echo $expertData2[0]['grade']?></span>
                                <span class="expertServe fl">上门服务 : <?php echo $expertData2[0]['door']?></span>
                            </div>
                        </a>
                    </div>
                	<ul class="gj_img_list fl">
					<?php if(count($expertData2)>0):?>
						<?php foreach($expertData2 as $key=>$val):?>
                        <li att="<?php echo $val['eid']?>">
                            <!-- 添加后缀.html-->
                            <a href="<?php echo  $url['guanj'].$val['eid'].'.html'?>" target="_blank">
                            	<img src="<?php echo site_url('static/img/loading1.gif'); ?>" data-original="<?php echo BANGU_URL.$val['pic']; ?>">
                            </a>
                        </li>
                        <?php endforeach;?>
                     <?php endif;?>
					</ul>
                </div>
                <!-- 旅游管家 End -->
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function(){
	$(".line_content>div").eq(0).show().siblings().hide();
	$(".item_content").each(function(){
		$(this).find("li").eq(2).css("margin-right","0px");
	});

	$(".travel_info").tab({
		currentClass:'current',
		tabNav:'.line_info_type>ul>li',
		tabContent:'.line_content>div',
		eventType:'mouseover'
	});
	$(".line_info_type ul li").hover(function(){
		var index = $(this).index();
		$(".line_content>div").eq(index).find("img").lazyload({
			effect : "fadeIn"
		});	
	});
	$(".item_content ul li").hover(function(){
		$(this).addClass("on").siblings().removeClass("on");
	});
	$(".gj_img_list li").eq(0).addClass("on");

	$(".gj_img_list li").hover(function(){
                $(this).addClass("on").siblings().removeClass("on");
                var src = $(this).find("img").attr("data-original");
				var href = $(this).find("a").attr("href");
                $(".gj_img").attr("src",src);
				$("#img_href").attr("href",href);
                var data_id =$(this).attr("att");
                $.ajax({
                    type:"post",
                    url: "/sc/index/expert_data_after/"+data_id,
                    dataType:"jsonp",
                    success:function(data){
                        var smfw="";
                        if(data.code=="4000"){
                            tan(data.msg);
                        }
                        if(data.code=="2000"){
                        if(data.data.door=="" || data.data.door==null){ smfw = '暂无';}else{ smfw = data.data.door; };
                             var html = '';
                            html+= "<span class='expertName fl'>"+data.data.nickname+"</span>";
                            html+= "<span class='place fl'>"+data.data.cityname+"</span>";
                            html+= "<span class='expertGrade fl'>"+data.data.grade+"</span>";
                            html+= "<span class='expertServe fl'>上门服务 : "+smfw+"</span>";
                        $(".cover_info").html(html);
                        }
                    },
                    error:function(){}
        });
    });
	
	
	$("img").lazyload({
		effect : "fadeIn"
	});

});
</script>
<?php $this->load->view('sc/com/foot');?>
</body>
</html>
