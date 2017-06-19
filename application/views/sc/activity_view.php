<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="webkit" name="renderer">
<meta content="”IE=Edge,chrome=1″" http-equiv="”X-UA-Compatible”">
<meta name="keywords" content="3月旅游,3月旅游费用,3月旅游推荐" />
<meta name="description" content="深圳之窗旅游频道联合帮游旅行网为你提供3月份适合去旅游的国内、出境以及周边游目的地线路供大家选择参考，3月低价而优质的旅游汇聚在此" />
<title>5月去哪里旅游？_5月旅游报价_5月旅游推荐-帮游网-深圳之窗网</title>
<link href="<?php echo base_url('static/css/sc/shenchuang.css'); ?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('static/js/sc/jquery-1.11.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/sc/jquery.SuperSlide.2.1.1.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>

<!-- <img class="lazy" src="img/grey.gif" data-original="img/example.jpg"  width="640" heigh="480"> -->

<!--[if IE]>
<style> 
.icon{ display:none;}
.ie6_ico{ display:none;}
</style>

<![endif]-->
</head>
<body>
    <div class="header">
        <div class="Schuang_content">
            <div class="header_img">
               	<a href="http://www.1b1u.com/"><img class="logo_1" src="<?php echo base_url('static/img/sc/shenchuang_logo.jpg'); ?>"></a>
            </div>
            <div class="fl">
                <ul class="index_con">
        				<?php foreach ($nav  as $k=>$v){?>
        					<li><a href="<?php echo  base_url($v['link']);?>"  target="_blank"><?php echo $v['name']?></a></li>
        				<?php }?>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="banner_bg" style="background: url(<?php echo base_url('static/img/sc/sc_baner3-1.jpg'); ?>) center top no-repeat; height:720px; min-width:1200px;">
                      
        </div>
        <div class="scenic_intro">
              <div class="scenic_main ">
                  <div class="boutique_fq clear">
                        <div class="nar_title" id="recommend" style="background: url(<?php echo base_url('static/img/sc/sc_icon_2.png'); ?>) center 50px no-repeat; height:180px;">
                             
                        </div>
                        <div class="slideTxtBox">
                            <div class="hd">
                                <ul>
                  							<?php  if(empty($quality_line)){echo '';}else{ foreach ($quality_line  as $k=>$v) {?>
                  								<li>
                                                                                    <!-- 将cj和gn改为line,添加后缀.html-->
                  								<a target="_blank" href="<?php  $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html';  echo  base_url($line_url ); ?>"  ><?php 		if (   strlen($v['linename'])>17  ) 	 { echo mb_substr($v['linename'],0,17,'utf-8') . '...' ;}else{  echo ($v['linename']);  }	?></a>
                  								<?php if($k=0){ ?><i class="icon"></i><?php }else{	echo "<i></i>";}?>
                  								</li>
                  							<?php }}?>
                                </ul>
                            </div>
                            <div class="bd">
							               <?php if(empty($quality_line)){echo '';}else{ foreach ($quality_line  as $k=>$v) {?>
                                <div class="con"><!-- 将cj和gn改为line,添加后缀.html-->
                                    <a target="_blank" href="<?php $line_url = in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html';  echo  base_url($line_url );  ?>"> 
                                        
                                        <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo $v['pic']; ?>" width="700" height="400" class="photo">
                                        <div class="Price_intro">
                                            <p class="start_point">
                                            
                                            
                                                <span><?php   if (   strlen($v['linename'])>13  ) 	 { echo mb_substr($v['linename'],0,12,'utf-8') . '...' ;}else{  echo ($v['linename']);  }   ?></span>
                                                
                                            </p>
                                            <p class="hotel"><?php  if (   strlen($v['linetitle'])>13  ) 	 { echo mb_substr($v['linetitle'],0,12,'utf-8') . '...' ;}else{  echo ($v['linetitle']);  }     ?>  </p>
                                            <p class="bu_jiage">
                                                <span>帮游价：</span>
                                                <span class="my">￥<?php echo $v['lineprice']?></span>
                                            </p>
                                            <p class="money">
                                                <span>￥<?php echo $v['marketprice']?>起 </span>
                                                <span>团期：<?php echo $v['ordertime']?></span>
                                            </p>
                                        </div>
                                    </a>
                                </div>
							               <?php }}?>
                            </div>
                        <script type="text/javascript">jQuery(".boutique_fq .slideTxtBox").slide({effect:"top"});</script>
                        </div>
                        <div class="super_fq">
                            <div class="nar_title" id="special" style="background: url(<?php echo base_url('static/img/sc/sc_icon5.png'); ?>) center 50px no-repeat; height:180px;">
                                
                            </div>
                            <dl class="">
							               <?php if(empty($recommend_line[0])){ echo ' ';} else{?>
                                <dt class="super_dt fl">
                                    <!-- 将cj和gn改为line,添加后缀.html-->
                                    <a target="_blank" href="<?php $line_url = in_array(1 ,explode(',',$recommend_line[0]['overcity'])) ? '/line/'.$recommend_line[0]['lineid'].'.html' : '/line/'.$recommend_line[0]['lineid'].'.html'; echo  base_url($line_url );   ?>">
                                        <img src="<?php echo $recommend_line[0]['pic']; ?>">
                                        <div class="super_cover">
                                            <p class="line_name line"><?php echo $recommend_line[0]['linename']; ?><span><?php echo $recommend_line[0]['linetitle']; ?></span></p>
                                            <div class="super_jg super_my">
                                                <p>￥<i><?php echo $recommend_line[0]['lineprice']; ?></i>起<b>￥<?php echo $recommend_line[0]['marketprice']?></b></p>
                                                <button class="btn">立即购买</button>
                                            </div>
                                        </div>
                                    </a>
                                </dt>
							                 <?php }?>
                                <dd class="fr">
								                <?php if(empty($recommend_line[1])){ echo ' ';} else{?>
                                    <div class="super_top">
                                        <!-- 将cj和gn改为line,添加后缀.html-->
                                        <a target="_blank"  href="<?php $line_url = in_array(1 ,explode(',',$recommend_line[1]['overcity'])) ? '/line/'.$recommend_line[1]['lineid'].'.html' : '/line/'.$recommend_line[1]['lineid'].'.html'; echo  base_url($line_url );   ?>">
                                        
                                        <img src="<?php echo $recommend_line[1]['pic']; ?>">
                                        </a>
                                        <div class="top_cover">
                                            <p class="line_top line"><?php echo $recommend_line[1]['linename']; ?><span><?php echo $recommend_line[1]['linetitle']; ?></span></p>
                                            <div class="jg_top super_my">
                                                  <p>￥<i><?php echo $recommend_line[1]['lineprice']; ?></i>起<b>￥<?php echo $recommend_line[1]['marketprice']?></b></p>
                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                    <a target="_blank" href="<?php $line_url = in_array(1 ,explode(',',$recommend_line[0]['overcity'])) ? '/line/'.$recommend_line[0]['lineid'].'.html' : '/line/'.$recommend_line[0]['lineid'].'.html'; echo  base_url($line_url );   ?>"><button class="btn"> 立即购买</button>
                                            </div>
                                        </div>
                                    </div>
                								<?php }?>
                								<?php if(empty($recommend_line[2])){ echo ' ';} else{?>
                                    <div class="super_bottom super_top">
                                        <!-- 将cj和gn改为line,添加后缀.html-->
                                        <a target="_blank"  href="<?php $line_url = in_array(1 ,explode(',',$recommend_line[2]['overcity'])) ? '/line/'.$recommend_line[2]['lineid'].'.html' : '/line/'.$recommend_line[2]['lineid'].'.html'; echo  base_url($line_url );  ?>">
                                        
                                        <img src="<?php echo $recommend_line[2]['pic']; ?>">
                                        </a>
                                        <div class="top_cover">
                                            <p class="line_top line"><?php echo $recommend_line[2]['linename']; ?><span><?php echo $recommend_line[2]['linetitle']; ?></span></p>
                                            <div class="jg_top super_my">
                                                  <p>￥<i><?php echo $recommend_line[2]['lineprice']; ?></i>起<b>￥<?php echo $recommend_line[2]['marketprice']?></b></p>
                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                  <a target="_blank" href="<?php $line_url = in_array(1 ,explode(',',$recommend_line[0]['overcity'])) ? '/line/'.$recommend_line[0]['lineid'].'.html' : '/line/'.$recommend_line[0]['lineid'].'.html'; echo  base_url($line_url );   ?>"><button class="btn">立即购买</button>
                                            </div>
                                        </div>
                                    </div>
									               <?php }?>
                                </dd>
                            </dl>
                        </div>
                        <div class="housekeeper clear">
                            <div class="nar_title" id="guanjia" style="background: url(<?php echo base_url('static/img/sc/sc_icon_9.png'); ?>) center 50px no-repeat; height:180px;">
                                
                            </div>
                            <div id="slideBox" class="slideBox">
                                <div class="bd secpor" style=" width:1000px;">
                                    <ul>
                                        <li>
                                            <dl class="img_box">
                                                <dt class="img_details">
                                                    <!-- 添加后缀.html 魏勇编辑-->
                                                    <a class='hreds'  target="_blank"  href="<?php echo $url['guanj'].$expertData1[0]['eid'].'.html' ;?>" ><img src="<?php echo base_url($expertData1[0]['pic']); ?>" class="gj_img" /></a>
                                                </dt>
                                                <dd class="gj_img_list">
													                       <?php foreach($expertData2 as $key=>$val){?>
                                                    <!-- 添加后缀.html 魏勇编辑-->
                                        			 <div class="imges_box"><a  target="_blank" href="<?php echo  $url['guanj'].$val['eid'].'.html'?>" att="<?php echo $val['eid'];?>"><img src="<?php echo $val['pic'];?>"></a></div>	
                                        			<?php }?>
                                                </dd>
                                            </dl>
                                            <div class="gj_intor">
                                                <!-- 添加后缀.html 魏勇编辑-->
                                                <div class="gj_name"><a  target="_blank" href="<?php echo $url['guanj'].$expertData1[0]['eid'].'.html' ;?> "><?php echo $expertData1[0]['nickname']?></a></div>
                                                <div class="guanjia_xiqin">
                                                   <p class="exper_p">
                                                        <span class="guaji_til">最高级别</span>
                                                        <span class="exper_til">管家</span>
                                                   </p>
                                                   <p class="exper_p">
                                                       <i class="city_ico"></i>
                                                        <span class="exper_til" style="color:#5d7895;"><?php echo $expertData1[0]['cityname']?></span>
                                                   </p>
                                                   <p class="exper_p">
                                                       <span class="guaji_til">上门服务</span>
                                                       <span class="exper_til"><?php echo $expertData1[0]['door']?></span>
                                                   </p>
                                                   <p class="exper_p">
                                                       <span class="guaji_til">擅长产品</span>
                                                       <span class="exper_til"><?php echo $expertData1[0]['end']?></span>
                                                   </p>
                                                </div>
                                                <p class="exper_xq"><?php echo $expertData1[0]['talk']?></p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
              </div>
              <div class="content_partition">
                  <div class="partition_nr">
                  <div class="partition_nav" id="zhoubian">
                      <div class="nar_title" style="background: url(<?php echo base_url('static/img/sc/sc_til_zhoubian.png'); ?>) center 50px no-repeat; height:180px;">
                          
                      </div>
                      <div class="partition">
                           <div class="partition_fl fl">
                                 <div class="partition_img" style="background: url(<?php echo base_url('static/img/sc/bg_zhoubian.png'); ?>) 2px -8px no-repeat;  width: 262px; height: 555px;">
                                      
                                 </div>
                                 <div class="product_intro">
                                      <ul>
                                      <?php if(empty($zb[0]['lineid'])){echo '';}else{?>
                                      <?php foreach ($zb as $key=>$val){?>
                                           <li>
                                                <div class="jd_img fl">
                                                     
                                                     <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?> ">
                                                </div>
                                                <div class="jd_line fr">
                                                    <!-- 将cj和gn改为line,添加后缀.html-->
                                                      <p class="title" ><a href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; echo  base_url($line_url);?>" target="_blank" ><?php echo (mb_substr($val['linename'],0,14,'utf-8') . '...'); ?></a></p>
                                                     <p class="partition_my">
                                                          <span class="span_1">帮游价：</span>
                                                          <span class="span_2">￥<b><?php echo $val['lineprice']; ?></b></span>
                                                      </p>
                                                </div>
                                           </li>
                                      <?php }}?>
                                      </ul>
                                 </div>
                                 <div class="check_more fr">
                                     <a href="<?php echo $url['l_zb']?>"    target="_blank" >  <button>查看更多>></button> </a>
                                 </div>
                                  </div>
                                     <div class="partition_fr fr">
                                        <ul class="nav_ul">
                                           <?php foreach ($zb_dest as $key=>$val){?>
                                            <?php  if($key=="0"){ echo "<li class='cursor '>";}else{echo "<li class=''>";}  if (   strlen($val['kindname'])>12  )    { echo mb_substr($val['kindname'],0,8,'utf-8') . '...' ;}else{  echo ($val['kindname']);  } ?><?php  if($key=="0"){ echo "<i class='icon '></i>";}else{echo "<i class=''></i>";}?></li>
                                        <?php }?>
                                        </ul> 

                                        <div class="nav_intro">
                                          <ul class="nav_ul_2">
                                        <?php if(empty($zb_dest_list1)){echo '';}else{  foreach ($zb_dest_list1 as $key=>$val){?>
                                            <li>
                                                <div class="img_div">
                                                    <!-- 将cj和gn改为line,添加后缀.html-->
                                                    <a target="_blank"   href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                    
                                                    <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                    </a>
                                                </div>
                                                <div class="jd_text">
                                                    <p class="title"><?php  if (   strlen($val['linename'])>13  )    { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  } ?></p>
                                                    <div class="buy_my">
                                                        <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                        <!-- 将cj和gn改为line,添加后缀.html-->
                                                        <a target="_blank"   href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php }}?>
                                                       
                                          </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                   <?php if(empty($zb_dest_list2)){echo '';}else{ foreach ($zb_dest_list2 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank" href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  )    { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a target="_blank"   href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
                                                  <?php }}?>
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                <?php if(empty($zb_dest_list3)){echo '';}else{ foreach ($zb_dest_list3 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank" href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  )    { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank" href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
                                                  <?php }}?>
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                 <?php if(empty($zb_dest_list4)){echo '';}else{ foreach ($zb_dest_list4 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a target="_blank"   href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  )    { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  } ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank" href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
                                                  <?php }}?>
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                            <?php if(empty($in_dest_list5)){echo '';}else{ foreach ($zb_dest_list5 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank" href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  )    { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  } ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a target="_blank"  href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
                                                    <?php }}?>
                                                </ul>
                                          </div>
                                          </div>
                                     </div>
                                </div>
                       
                                <div class="partition_nav" id="guonei">
                                <div class="nar_title" style="background: url(<?php echo base_url('static/img/sc/sc_til_guonei.png'); ?>) 250px 51px no-repeat; height:180px;">
                                     
                                </div>
                                <div class="partition">
                                     <div class="partition_fl fl">
                                           <div class="partition_img" style="background: url(<?php echo base_url('static/img/sc/bg_guonei.png'); ?>) center -9px no-repeat;  width: 260px; height: 555px;">
                                            
                                           </div>
                                           <div class="product_intro">
                                                <ul>
                        												<?php if(empty($in[0]['lineid'])){echo '';}else{?>
                        												<?php foreach ($in as $key=>$val){?>
                                                     <li>
                                                          <div class="jd_img fl">
                                                               
                                                               <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?> ">
                                                          </div>
                                                          <div class="jd_line fr">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                                <p class="title" ><a   href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; echo  base_url($line_url);?>" target="_blank" ><?php echo (mb_substr($val['linename'],0,14,'utf-8') . '...'); ?></a></p>
                                                               <p class="partition_my">
                                                                    <span class="span_1">帮游价：</span>
                                                                    <span class="span_2">￥<b><?php echo $val['lineprice']; ?></b></span>
                                                                </p>
                                                          </div>
                                                     </li>
												                            <?php }}?>
                                                </ul>
                                           </div>
                                           <div class="check_more fr">
                                              <a target="_blank"  href="<?php echo $url['l_gn']?>"     >  <button>查看更多>></button></a>
                                           </div>
                                     </div>
                                     <div class="partition_fr fr">
                                          <ul class="nav_ul">
                    										  <?php foreach ($in_dest as $key=>$val){?>
                    												<?php  if($key=="0"){ echo "<li class='cursor '>";}else{echo "<li class=''>";}         if (   strlen($val['kindname'])>12  ) 	 { echo mb_substr($val['kindname'],0,8,'utf-8') . '...' ;}else{  echo ($val['kindname']);  }          ?><?php  if($key=="0"){ echo "<i class='icon '></i>";}else{echo "<i class=''></i>";}?></li>
                    										  <?php }?>
                                            </ul>	
                    									     <div class="nav_intro">
                                              <ul class="nav_ul_2">
                    										     <?php  if(empty($in_dest_list1)){echo '';}else{ foreach ($in_dest_list1 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank"  href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">

                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"  href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
										                              <?php }}?>
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                   <?php if(empty($in_dest_list2)){echo '';}else{ foreach ($in_dest_list2 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank"  href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"  href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
												                            <?php }}?>
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                <?php if(empty($in_dest_list3)){echo '';}else{ foreach ($in_dest_list3 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a   target="_blank"  href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"  href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
												                          <?php }}?>
                                                </ul>
                                          </div>
										                      <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                 <?php if(empty($in_dest_list4)){echo '';}else{ foreach ($in_dest_list4 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a   target="_blank"   href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"	href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
												                          <?php }}?>
                                                </ul>
                                          </div>
										                      <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                    <?php if(empty($in_dest_list5)){echo '';}else{ foreach ($in_dest_list5 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank" 	href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"	href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
											                             <?php }}?>
                                                </ul>
                                          </div>
                                     </div>
                                </div>
                            </div>
                            <div class="partition_nav" id="chujing">
                                <div class="nar_title" style="background: url(<?php echo base_url('static/img/sc/sc_til_chujing.png'); ?>) center 51px no-repeat; height:180px;">
                                    
                                </div>
                                <div class="partition">
                                     <div class="partition_fl fl">
                                           <div class="partition_img" style="background: url(<?php echo base_url('static/img/sc/bg_chujing.png'); ?>) center -7px no-repeat;  width: 262px; height: 555px;">
 

                                           </div>
                                           <div class="product_intro">
                                                <ul>
                            										  <?php if(empty($ou[0]['lineid'])){echo '';}else{?>
                            											<?php foreach ($ou as $key=>$val){?>
                                                     <li>
                                                          <div class="jd_img fl">
                                                               
                                                               <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?> ">
                                                          </div>
                                                          <div class="jd_line fr">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                                <p class="title" ><a   href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['lineid'].'.html' : '/line/'.$val['lineid'].'.html'; echo  base_url($line_url);?>" target="_blank" ><?php echo (mb_substr($val['linename'],0,14,'utf-8') . '...'); ?></a></p>
                                                               <p class="partition_my">
                                                                    <span class="span_1">帮游价：</span>
                                                                    <span class="span_2">￥<b><?php echo $val['lineprice']; ?></b></span>
                                                                </p>
                                                          </div>
                                                     </li>
												                          <?php }}?>
                                                </ul>
                                           </div>
                                           <div class="check_more fr">
                                              <a  href="<?php echo $url['l_cj']?>"    target="_blank" >  <button>查看更多>></button> </a>
                                           </div>
                                     </div>
                                     <div class="partition_fr fr">
                                          <ul class="nav_ul">
                                            <?php foreach ($ou_dest as $key=>$val){?>
                      											<?php  if($key=="0"){ echo "<li class='cursor '>";}else{echo "<li class=''>";}  if (   strlen($val['kindname'])>12  ) 	 { echo mb_substr($val['kindname'],0,8,'utf-8') . '...' ;}else{  echo ($val['kindname']);  } ;?><?php  if($key=="0"){ echo "<i class='icon '></i>";}else{echo "<i class=''></i>";}?></li>
                      										  <?php }?>
                                            </ul>	
			  
                      				              <div class="nav_intro">
                                                                <ul class="nav_ul_2">
                      										  <?php  if(empty($ou_dest_list1)){echo '';}else{ foreach ($ou_dest_list1 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a   target="_blank"		href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  } ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"	href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
										                              <?php }}?>   
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                   <?php if(empty($ou_dest_list2)){echo '';}else{ foreach ($ou_dest_list2 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a  target="_blank"	href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"	href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
												                          <?php }}?>
                                                </ul>
                                          </div>
                                          <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                <?php if(empty($ou_dest_list3)){echo '';}else{ foreach ($ou_dest_list3 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a target="_blank"	 href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a target="_blank"	 href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
												                            <?php }}?>
                                                </ul>
                                          </div>
										                      <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                                 <?php if(empty($ou_dest_list4)){echo '';}else{ foreach ($ou_dest_list4 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a 	target="_blank"	href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  }  ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"	href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
												                            <?php }}?>
                                                </ul>
                                          </div>
										                      <div class="nav_intro"  style="display:none;">
                                                <ul class="nav_ul_2">
                                            <?php if(empty($ou_dest_list5)){echo '';}else{ foreach ($ou_dest_list5 as $key=>$val){?>
                                                      <li>
                                                          <div class="img_div">
                                                              <!-- 将cj和gn改为line,添加后缀.html-->
                                                              <a target="_blank"	href="<?php echo $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; ?>">
                                                              <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo base_url($val['mainpic']); ?>">
                                                              </a>
                                                          </div>
                                                          <div class="jd_text">
                                                              <p class="title"><?php  if (   strlen($val['linename'])>13  ) 	 { echo mb_substr($val['linename'],0,13,'utf-8') . '...' ;}else{  echo ($val['linename']);  } ?></p>
                                                              <div class="buy_my">
                                                                  <p>￥<span><?php echo $val['lineprice']; ?></span>起</p>
                                                                  <!-- 将cj和gn改为line,添加后缀.html-->
                                                                  <a  target="_blank"	href="<?php  $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html'; echo  base_url($line_url);?>"><button>立即抢购</button></a>
                                                              </div>
                                                          </div>
                                                      </li>
											                             <?php }}?>
                                                </ul>
                                          </div>
                                        </ul>
                                     </div>
                                </div>
                            </div>
                      </div> 
                  </div>
              </div>
              <div class="more_marvellous">
                  <div class="marvellous_nr">
                      <div class="nar_title" style="background: url(<?php echo base_url('static/img/sc/sc_icon_3.png'); ?> ) center 60px no-repeat; width:1000px; height:200px;">
                      </div>
                      <div class="img_list">
                          <ul>
						              <?php if(empty($pics_3)){echo '';}else{ foreach ($pics_3 as $key=>$val){?>
                              <li>
                                  <a target="_blank"	 href="<?php  if($val['pid']==1){  echo $url['cj'].$val['dest_id'].$url['wei'] ;}elseif( $val['pid']==2){  echo $url['gn'].$val['dest_id'].$url['wei']   ;}else{   if  ( $pics_3[$key]['pid'][0]['pid']==1  ){   echo $url['cj'].$val['dest_id'].$url['wei'] ;  } elseif (    $pics_3[$key]['pid'][0]['pid']==2     ){       echo $url['gn'].$val['dest_id'].$url['wei'] ;       }
                                  }?>">
                                  
                                  <img src="<?php echo site_url('static/img/loading0.gif'); ?>" data-original="<?php echo $val['pic']; ?> ">
                                  <div class="xinqin_boto"><?php echo $val['name'];?></div>
                                  </a>     
                              </li>
						              <?php }}?>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>

          <div class="main_bottom clear w_1200">
                  <div class="main_bottom_introduce">
                      <!-- 底部文章 -->
                      <div class="question_line">
                          <div class="question_line_content">
                              <ul>
                                  <li class="question_line_title"><h3>预订常见问题</h3></li>
                                  <li>
                                      <a target="_blank" href="http://www.1b1u.com/article/index-1.html#id1">纯玩是什么意思？</a>
                                  </li>
                                  <li>
                                      <a target="_blank" href="http://www.1b1u.com/article/index-27.html#id27">单房差是什么？</a>
                                  </li>
                                  <li>
                                      <a target="_blank" href="http://www.1b1u.com/article/index-3.html#id3">什么是自助游？</a>
                                  </li>
                                   <li>
                                      <a target="_blank" href="http://www.1b1u.com/article/index-31.html#id31">对于支付团款的建议？</a>
                                  </li>
                              </ul>
                          </div>
                          <div class="question_line_content">
                              <ul>
                                  <li class="question_line_title"><h3>付款和发票</h3></li>
                                  <li><a href="http://www.1b1u.com/article/index-29.html#id29" target="_blank">能不能脱团自己玩？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-17.html#id17" target="_blank">关于旅游合同问题解答</a></li>
              										<li><a href="http://www.1b1u.com/article/index-12.html#id12" target="_blank">出门旅游买什么保险较好？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-26.html#id26" target="_blank">行程中常见问题</a></li>
              										<li><a href="http://www.1b1u.com/article/index-14.html#id14" target="_blank">预订酒店的问题</a></li> 
                              </ul>
                          </div>
                          <div class="question_line_content">
                              <ul>
                                  <li class="question_line_title"><h3>预定旅游合同</h3></li>
                                  <li><a href="http://www.1b1u.com/article/index-6.html#id6" target="_blank">外地游客怎样付款？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-8.html#id8" target="_blank">对于支付团款的建议</a></li>
              										<li><a href="http://www.1b1u.com/article/index-5.html#id5" target="_blank">本地游客如何付款？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-24.html#id24" target="_blank">如何获取发票？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-7.html#id7" target="_blank">定金支付比例如何？</a></li>
                              </ul>
                          </div>
                          <div class="question_line_content">
                              <ul>
                                  <li class="question_line_title"><h3>管家服务总则</h3></li>
                                  <li><a href="http://www.1b1u.com/article/index-46.html#id46" target="_blank">管家资格考核</a></li>
              										<li><a href="http://www.1b1u.com/article/index-43.html#id43" target="_blank">旅游服务规则</a></li>
              										<li><a href="http://www.1b1u.com/article/index-40.html#id40" target="_blank">抢单规则</a></li>
              										<li><a href="http://www.1b1u.com/article/index-45.html#id45" target="_blank">管家等级规则</a></li>
              										<li><a href="http://www.1b1u.com/article/index-42.html#id42" target="_blank">支付与退款</a></li>
                              </ul>
                          </div>
                          <div class="question_line_content">
                              <ul>
                                  <li class="question_line_title"><h3>其他事项</h3></li>
                                  <li><a href="http://www.1b1u.com/article/index-21.html#id21" target="_blank">合同的签订</a></li>
              										<li><a href="http://www.1b1u.com/article/index-9.html#id9" target="_blank">传真能签合同吗？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-11.html#id11" target="_blank">范本是正规旅游合同吗？</a></li>
              										<li><a href="http://www.1b1u.com/article/index-23.html#id23" target="_blank">关于门市签约</a></li>
              										<li><a href="http://www.1b1u.com/article/index-10.html#id10" target="_blank">旅游合同范本</a></li>
                              </ul>
                          </div>
                      </div>
                      <!-- 底部文章结束 -->
                      <div class="why_bangu">
                          <img data-original="<?php echo base_url('static/img/sc/why_bangu.png'); ?>" src="<?php echo base_url('static/img/sc/why_bangu.png'); ?>" style="display: block;">
                      </div>
                      <!-- 图片类型友情链接 -->
                      <div class="integrity_server">
                          <ul>
                          <?php foreach ($friend_link as $key=>$link):?>
                              <li>
                                  <a target="_blank" href="<?php echo $link['url'];?>">
                                      <img data-original="" alt="<?php echo $link['name'];?>" src="<?php echo BANGU_URL.$link['icon']; ?>">
                                  </a>
                              </li>
                          <?php endforeach;?>     
                          </ul>
                      </div>
                  </div>
                      <!-- 文字类型友情链接 -->
                  <div class="web_links">
                      <div class="web_links_titile fl">友情链接:</div>
                      <div class="web_links_content fr">
                          <a target="_blank" href="http://www.feiren.com/">腾邦国际</a>
                          <a target="_blank" href="http://www.51766.com/">51766旅游网</a>
                          <a target="_blank" href="">途牛旅游网</a>
                          <a target="_blank" href="http://www.ly.com/">同城旅游</a>
                          <a target="_blank" href="http://www.mipang.com/">米胖旅游</a>
                          <a target="_blank" href="http://jipiao.kuxun.cn/">酷讯机票</a>
                          <a target="_blank" href="http://travel.ifeng.com/">凤凰旅游</a>
                          <a target="_blank" href="http://www.lvmama.com/">驴妈妈旅游</a>
                          <a target="_blank" href="http://www.17u.net/">旅交汇</a>
                          <a target="_blank" href="http://www.qunar.com/">去哪儿机票</a>
                          <a target="_blank" href="http://www.8264.com/">户外资料网</a>
                          <a target="_blank" href="http://www.8264.com/">淘宝旅行</a>
                          <a target="_blank" href="http://www.aoyou.com/">遨游旅游网</a>
                          <a target="_blank" href="http://lxs.cncn.com/49923">中国武夷山</a>
                          <a target="_blank" href="">阳光旅行网</a>
                          <a target="_blank" href="http://www.baicheng.com/">百程旅行网</a>
                          <a target="_blank" href="http://www.cthy.com/">中国旅游信息</a>
                          <a target="_blank" href="http://www.ktrip.com.cn/">神舟国旅</a>
                          <a target="_blank" href="http://www.ctcnn.com/">劲旅网</a>
                          <a target="_blank" href="http://www.qyer.com/">穷游网</a>
                          <a target="_blank" href="http://www.mafengwo.cn/">蚂蜂窝旅游</a>
                          <a target="_blank" href="http://www.yododo.com/">游多多旅行网</a>
                          <a target="_blank" href="http://www.hao123.com/">hao123</a>
                          <a target="_blank" href="http://www.lyoudyw.com/">第一旅游网</a>
                          <a target="_blank" href="http://www.bytsw.com/">北京旅游网</a>
                          <a target="_blank" href="http://www.qianzhengdaiban.com/">中国签证资讯网</a>
                          <a target="_blank" href="http://cats.org.cn/">中国旅行社协会</a>
                          <a target="_blank" href="http://www.5iucn.com/">吾爱旅游网</a>
                          <a target="_blank" href="http://www.gz-travel.net/">贵州旅游在线网</a>
                          <a target="_blank" href="http://www.xinnong.net/">新农网</a>
                          <a target="_blank" href="">新疆旅游</a>
                          <a target="_blank" href="">潇湘</a>
                          <a target="_blank" href="">小说</a>
                          <a target="_blank" href="http://lxs.cncn.com/40664/n190368">云南旅游</a>
                          <a target="_blank" href="">美图秀秀</a>
                          <a href="/article/friend_link">更多友情链接&gt;&gt;</a>      
                      </div>
                  </div>
              </div>
              <div class="foot_img" style="background: url(<?php echo base_url('static/img/sc/foot_back.png'); ?>) 100% 0 no-repeat; width:1200px;height:140px;">
                
              </div>  
              <div class="foot_dibu">

                  <!-- dasda -->
                  <div class="footer_content">
                  <div class="footer_links">
                      <p class="guild_link">
                        <a rel="nofollow" href="/admin/b2/login">管家登录</a>|
                        <a rel="nofollow" href="/admin/b1/index">供应商登录</a>|
                        <a target="_blank" rel="nofollow" href="/article/privacy_desc">隐私声明</a>|
                        <a rel="nofollow" href="http://www.1b1u.com/index/site_map">网站地图</a>|
                        <a target="_blank" rel="nofollow" href="http://www.1b1u.com/article/recruit">加入我们</a>|
                        <a target="_blank" rel="nofollow" href="http://www.1b1u.com/article/contact_us">联系我们</a>| 
                        <a target="_blank" rel="nofollow" href="http://www.1b1u.com/article/about_us-introduce" >关于我们</a>| 
                        <a target="_blank" rel="nofollow" href="http://www.1b1u.com/lyzx">旅游资讯</a>
                      </p>
                      <p class="siteinfo">&nbsp;Copyright © 2006-2015 &nbsp;&nbsp; http://www.1b1u.com&nbsp;&nbsp;帮游旅行网&nbsp;&nbsp;版权所有 &nbsp;&nbsp;|&nbsp;<a href="/article/license">公司资质</a>&nbsp;&nbsp;|&nbsp;&nbsp; ICP证：粤ICP备15067822号</p>
                      <!--<p class="siteinfo">*本网站部分图片来自网络，若侵犯到您的权益，请尽快与帮游网联系。</p>-->
                    </div>
                </div>

              </div>  
          </div>
        <div class="ie6_ico">
        <div class="bar_left_icon">
            <div class="bar_details"> 
                <ul>
<!--                     <li><a href="#recommend">超值推荐<span>></span></a></li> -->
<!--                     <li><a href="#special">平民特价<span>></span></a></li> -->
<!--                     <li><a href="#guanjia">旅游管家<span>></span></a></li> -->
                    
                    <li><a href="#zhoubian">周边游<span>></span></a></li>
                    <li><a href="#guonei">国内游<span>></span></a></li>
                    <li><a href="#chujing">出境游<span>></span></a></li>
                    <!-- <li><a href="<?php echo $url['l_zt']?>">主题游<span>></span></a></li>
                    <li><a href="<?php echo $url['l_dzy']?>">定制游<span>></span></a></li> -->
                </ul>
            </div>
        </div>
        </div>
	<script type="text/javascript">
      $(function () {
          //精品预售切换图片列表
          $(".slideTxtBox li").hover(function(){
               var _this=$(this);
               _this.siblings().find('i').removeClass('icon');
               _this.find('i').addClass("icon")
               $(".tempWrap").find("img").lazyload({ })
          });
          //境内外切换图片列表
          $(".nav_ul li").click(function(){
              var _this=$(this);
              var idx=_this.index();
              _this.addClass("cursor").siblings('li').removeClass("cursor");
              _this.children('i').addClass("icon ").siblings('i').removeClass("icon ");
              _this.parents().siblings(".partition_fr .nav_intro:eq("+idx+")").show().siblings(".partition_fr .nav_intro").hide();
              $(".img_list ul li").find("img").lazyload({
                effect : "fadeIn"
              })

          });
          //管家的切换图片
          jQuery(".housekeeper .slideBox").slide({mainCell:".bd ul",autoPlay:false,effect:"leftLoop"});

      })
      $(".gj_img_list img").hover(function(){
          var src = $(this).attr("src");
          $(".gj_img_list img").removeClass("img_cuttor");
          $(this).addClass("img_cuttor");
		 
          $(".gj_img").attr("src",src);
		 
		 	var kks =$(this).parent().attr("att");
			 var base_url="<?php echo base_url()?>";
			 $.ajax({
			type:"post",
			url: base_url+"sc/index/expert_data_after/"+kks,
			dataType:"JSONP",
			success:function(data){
				var smfw="";
				if(data.code=="4000"){
 					tan(data.msg);
				}
				if(data.code=="2000"){
				if(data.data.door=="" || data.data.door==null){ smfw = '暂无';}else{ smfw = data.data.door; };
				var html = '';
					html += "<div class='gj_name'><a href='data.data.id'>"+data.data.nickname+"</a></div>";
					html += "<div class='guanjia_xiqin'>  <p class='exper_p'>	 <span class='guaji_til'>最高级别</span><span class='exper_til'>"+data.data.grade+"</span> </p>   ";
					html += "<p class='exper_p'>  <i class='city_ico'></i>  <span class='exper_til' style='color:#5d7895;'>"+data.data.cityname+"</span>  </p>";
					html += "<p class='exper_p'> <span class='guaji_til'>上门服务</span> <span class='exper_til'>"+smfw+"</span>  </p>";
					html += " <p class='exper_p'> <span class='guaji_til'>擅长产品</span> <span class='exper_til'>"+data.data.end+"</span> </p>";
					html += " </div>  <p class='exper_xq'>"+data.data.talk+"</p>  </div> ";
        		    $('.gj_intor').html(html);
   				    $(".hreds").attr('href','http://www.1b1u.com/guanj/'+data.data.eid);
				}
			},
			error:function(){}
		});
      });
      //左侧 固定定位
      $(function () {
          var showON= $(".scenic_intro").offset().top; 
          var zhutiSet=$(".more_marvellous").offset().top; //5. 主题游set
          var zhutiHei=$(".more_marvellous").outerHeight(true); //5. 主题游hei 
          window.onscroll=function(){
          //左面菜单 
          if($(window).scrollTop()>showON-100 && $(window).scrollTop() <zhutiHei+zhutiSet-500){
              $(".bar_left_icon").fadeIn(500);
          }else{
              $(".bar_left_icon").fadeOut(500);
          }}
      });
      $(function(){
        $("img").lazyload({});
        $(".super_fq").find("img").lazyload({ })
        $(".img_list ul li").find("img").lazyload({})

      })

  </script>
<?php $this->load->view('sc/com/foot');?>
</body>
</html>
