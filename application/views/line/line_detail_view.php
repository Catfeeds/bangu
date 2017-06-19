<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<?php if($type == 'cj'):?>
<title><?php echo $line_data['linename']?>__出境旅游线路-帮游旅行网</title>
<meta name="keywords" content="出境旅游,出国游游<?php echo $line_data['destName']?>" />
<meta name="description" content="帮游旅游网提供 <?php echo $line_data['linename']?>优质出国旅游线路，为您的旅途提供线路规划、景点、价格、门票、攻略等一站式出国旅游服务" />
<?php elseif($type == 'gn'):?>
<title><?php echo $line_data['linename']?>_国内旅游线路-帮游旅行网</title>
<meta name="keywords" content="国内游,国内旅游景点,国内旅游价格,<?php echo $line_data['destName']?>" />
<meta name="description" content="帮游旅游网提供<?php echo $line_data['linename']?>等国内旅游线路，为您的旅途提供线路、景点、价格、攻略等一站式国内旅游服务" />
<?php elseif($type == 'zt'):?>
<title><?php echo $line_data['linename']?>__主题旅游线路-帮游旅行网</title>
<meta name="keywords" content="主题游,主题旅游,主题游路线,巽寮湾旅游<?php echo $line_data['theme_name']?>" />
<meta name="description" content="帮游旅游网数万名资深旅游管家为您量身定制<?php echo $line_data['linename']?>，为您规划蜜月游、亲子游、海岛游、周末游、爸妈游、主题旅游攻略等各式各样的旅游主题服务" />
<?php elseif($type == 'zb'):?>
<title><?php echo $line_data['linename']?>__周边旅游线路-帮游旅行网</title>
<meta name="keywords" content="周边游,<?php echo $this ->session->userdata('city_location')?>周边游,<?php echo $line_data['destName']?>" />
<meta name="description" content="帮帮游旅游网提供<?php echo $line_data['linename']?>优质周边旅游线路，为您规划好您所在城市的周边旅游线路、价格，旅游景点推荐、攻略、旅游管家等周边旅游服务" />
<?php endif;?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" charset="utf-8" name="viewport" content="width=device-width,initial-scale=1,user-scalable=no" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" type="text/css" />
<!-- 头尾 -->
<link href="<?php echo base_url('static'); ?>/css/line_detail.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>" rel="stylesheet" />
<!-- 私有 -->

<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js?v=2.0.6');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery.pagination.js"></script>
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/pagination.css" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />

<!-- 日历价格 列表 -->
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/map.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/calendar.js"></script>
<script type="text/javascript">
with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion='+~(-new Date()/36e5)];
</script>
<script type="text/javascript">
    window.onscroll=function(){
        if ($(window).scrollTop() >950 ) {
            $(".detailNav").addClass("detailNavFloat");
        } else {
            $(".detailNav").removeClass("detailNavFloat");
        }
			if ($(window).scrollTop()==270) {
        }
    }
</script>

<!-- 设备判断：若是手机访问，跳转到wap网站（温文斌） -->
<script src="http://siteapp.baidu.com/static/webappservice/uaredirect.js" type="text/javascript"></script>
<?php if(in_array(gethostbyname($_SERVER["SERVER_NAME"]),array('120.25.217.197'))): ?>
<script type="text/javascript">
uaredirect("http://m.1b1u.com/line/line_detail?lineid=<?php echo $line_data['id'];?>")
</script>
<?php endif;?>

</head>
<body>
<div class="wrap">
<?php echo $this->load->view('common/header');  ?>
<div class="container">
    <!-- 位置导航 -->
    <p class="youPlace">您的位置:<a href="<?php echo sys_constant::INDEX_URL?>" style="color:#a9a9a9;">首页</a><span class="right_jiantou">></span><a href="<?php echo base_url();?>line/line_list" style="color:#a9a9a9;">线路列表</a><span class="right_jiantou">></span>线路详情</p>
    <!-- 位置导航结束 -->
    <!-- 预定信息 -->
    <div class="detail_1 clear">
        <div class="detail" style=" margin-bottom:30px">
            <!-- 左部 -->
            <h2 class="detailsInfoTit clear"><?php echo $line_data['linename'];?><i style="color:#666;font-weight:500;margin-left:15px;"><?php echo $line_data['linetitle'];?></i><span>产品编号<?php echo $line_data['linecode'];?></span></h2>
            <div class="detailLeft">
                <!-- 线路相册 -->
                <div class="photoBar">
                    <!-- 图片显示 -->
                    <div class="photoShow">
                        <ul>
                        <?php
                            foreach ($album_data as $key=>$val){
                                if ($key == 0) {
                                    echo '<li value="'.($key).'" class="Index"><a><img src="'.$val['filepath'].'"/></a></li>';
                                } else {
                                     echo '<li value="'.($key).'"><img src="'.$val['filepath'].'" /></li>';
                                }
                            }
                        ?>
                            <li style="background:#fff;"><a href=""></a></li> <!-- 背景 -->
                        </ul>
                    </div>
                    <!-- 左右切换 -->
                    <div class="SwitchBox">
                        <div class="SwitchLeft"></div>
                        <div class="photoSwitch">
                            <ul class="switch_ul">
                                <?php
                                    foreach ($album_data as $key=>$val){
                                        if ($key == 0) {
                                            echo '<li value="'.($key).'" class="on"><a><img src="'.$val['filepath'].'"/></a></li>';
                                        } else {
                                             echo '<li value="'.($key).'"><img src="'.$val['filepath'].'" /></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <div class="SwitchRight"></div>
                    </div>
                </div>
                <!-- 线路相册结束 -->
                <!-- 日历 -->
                <div class="tourCalendarFors">
                    <div class="tour_calendar">
                        <div id='calendar' class="clearfix"></div>
                    </div>
                    <script type="text/javascript">
            	var _lineid='<?php echo $line_data['id'];?>'; //线路ID
            	var _suitid='<?php if(!empty($suit_data)){echo $suit_data[0]['id'];}?>'; // 套餐ID
            	var _selectDate=' ' ; //选择日期
            	var calendarPriceMap = new Map(); //价格日历数据存放
             	getCalendarData(); // 获取数据,更新日历
             	$('input[name="suit_id"]').val(_suitid);
			</script>
                </div>
                <!-- 日历结束 -->
            </div>
            <!-- 左部结束 -->
            <!-- 右部 -->
            <div class="detailRight item" id="item11" style="clear:none; border:none; margin:0;">
                <!-- 订单线路信息 -->
                <div class="detailsInfo">
                    <div class="detailsList">
                        <dl class="line_price_detail clear" >
                            <dd class="cxj" style="margin-top:5px !important;_margin-left:0px">促销价:</dd>
                            <dd class="cxj_num"> <span class="promotion_price"><em class="money_ico" style="font-size:18px !important;">¥</em><?php echo $minPrice;?><i>元/
                                <?php if($line_data['units']>1){ echo $line_data['units'];};?>
                                人</i></span><span class="cost_price"><em class="money_ico">¥</em><?php echo $line_data['lineprice']+$line_data['saveprice'];?></span> </dd>
                            <dd class="follow_service"><span class="follow_server_link"><i></i>咨询管家</span></dd>
                        </dl>
                        <dl style=" overflow:hidden; height:30px; padding-top:10px; border-bottom:1px solid #ebebeb;padding-left:43px;">
                            <div class="detail_shumu" style="text-align:left;width:20%;">已销:<span style="padding-left:13px;"><?php echo $line_data['sales']?$line_data['sales']:0;?></span></div>
                            <div class="detail_shumu" style="width:30%;">总积分:<span><?php echo (empty($line_data['all_score'])|| $line_data['all_score']==0.0) ? 0 : $line_data['all_score'];?>分</span></div>
                            <div class="detail_shumu" style="width:23%;">评价:<span><?php echo $comment_total;?></span></div>
                            <div class="detail_shumu" style="width:26%;border-right:none;">满意度:<span>
                                <?php if($line_data['satisfyscore']>0){echo round(($line_data['satisfyscore']*100),0).'%';}else{ echo "100%";}?>
                                </span></div>
                        </dl>
                        <dl style=" width:100%; height:40px;">
                            <dd style=" line-height:30px; margin-left:43px;_margin-left:17px;">套餐:</dd>
                            <dd>
                                <div class="buttonsSuit">
                                <?php if(!empty($suit_data)):?>
                                    <?php foreach ($suit_data as $key=>$val):?>
                                    <span data-unit="<?php echo $val['unit']?>" onclick="change_price_type(this)" suitid='<?php echo $val['id'];?>' <?php if($key==0):?> class='spanon spanoff' <?php else:?> class='spanoff' <?php endif;?>> <?php echo $val['suitname'];?></span>
                                    <?php endforeach;?>
                                <?php else:?>
                                    暂无套餐
                                <?php endif;?>
                                </div>
                            </dd>
                        </dl>
                        <dl style="height:40px;">
                            <dd style=" line-height:32px;margin-left:20px;_margin-left:5px; float:left;">出发日期:</dd>
                            <dd style=" float:left; width: 372px; _width: 322px;">
                                <div id="expertAge">
                                    <div class="expertAge_box">
                                        <div class="expertAge_showbox line_price" date='' style="">请选择出发日期</div>
                                        <!--保存搜索的价格-->
                                        <input type="hidden" name="suit_id" value=''/>
                                        <input type="hidden" id="usedate" name="usedate" value=''/>
                                        <!-- 套餐ID ,隐藏域-->
                                        <ul class="expertAge_option">
                                        </ul>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <dl style="height:35px;">
                            <dd style=" line-height:26px;margin-left:20px;_margin-left:5px;">出游人数:</dd>
                             <dd class="travel_num" style="margin-left:0px;">
                            <?php if(!empty($suit_data) && $suit_data[0]['unit']>=2):?>
                                <div class="adultsNum">
                                    <input type="text" name="adults" id="adultsNums" value="1"/>
                                    <span  class="beings">份/<?php echo $suit_data[0]['unit']?>人套餐</span>
                                 </div>
                        <?php else:?>
                                <div class="adultsNum">
                                    <input type="text" name="adults" id="adultsNums" value="1"/>
                                    <span  class="beings">成人</span>
                                </div>
                                <div class="adultsNum">
                                    <input type="text" name="old" id="oldNums" value="0"/>
                                    <span  class="beings">老人</span>
                                </div>
                                <div class="adultsNum">
                                    <input type="text" name="child" id="childNums" value="0"/>
                                    <span class="beings">占床儿童</span>
                                </div>
                                <div class="adultsNum">
                                    <input type="text" name="childnobed" id="childnobedNums" value="0"/>
                                    <span  class="beings">不占床儿童</span>
                                </div>
                        <?php endif;?>
                        </dd>
                        </dl>
                        <dl class="title_txt">
                            <dd style="margin-left:85px;_margin-left:36px;">
                                <div class="childStandard">儿童标准</div>
                                <div class="childStandardContext">
                                    <div> <span class="childStandardBor"></span> <span class="childStandardBZ">儿童占床标准:</span>
                                        <p  class="title_text_info" style="display:inline">
                                            <?php if(!empty($line_data['child_description'])){echo $line_data['child_description'];}else{echo "无";}?>
                                        </p>
                                    </div>
                                    <div> <span class="childStandardBor"></span> <span class="childStandardBZ">儿童不占床标准:</span>
                                        <p  class="title_text_info" style="display:inline">
                                            <?php if(!empty($line_data['child_nobed_description'])){echo $line_data['child_nobed_description'];}else{echo "无";}?>
                                        </p>
                                    </div>
                                </div>
                            </dd>
                            <dd>
                                <div class="childStandard">老人标准</div>
                                <div class="childStandardContext">
                                    <div> <span class="childStandardBor" style="left:107px;"></span> <span class="childStandardBZ">老人标准:</span>
                                        <p  class="title_text_info" style="display:inline">
                                            <?php if(!empty($line_data['old_description'])){echo $line_data['old_description'];}else{echo "无";}?>
                                        </p>
                                    </div>
                                </div>
                            </dd>
                            <dd>
                                <div class="childStandard">特殊人群标准</div>
                                <div class="childStandardContext">
                                    <div> <span class="childStandardBor" style="left:210px;"></span> <span class="childStandardBZ">特殊人群标准:</span>
                                        <p  class="title_text_info" style="display:inline">
                                            <?php if(!empty($line_data['special_description'])){echo $line_data['special_description'];}else{echo "无";}?>
                                        </p>
                                    </div>
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <br />
                    <br />
                    <script>
            	function kefu_url_line(obj){
                            	var lineid = $(obj).attr('data-val');
                            	var url='/kefu_webservices/get_b2_one_data?lineid='+lineid;
                            	var memberid='<?php $memberid=$this->session->userdata('c_userid');?>';
                				$.get(url,{lineid:lineid},function(data){
                					var b2_one_dataObj=JSON.parse(data);
                					//console.log(b2_one_dataObj);
                					if(b2_one_dataObj == "" || b2_one_dataObj == undefined || b2_one_dataObj == null){alert('此线路下没有专家！');}else{
                						var expertid=b2_one_dataObj[0]['id'];
                						window.open('<?php echo $web['expert_question_url'];?>'+'/kefu?mid='+memberid+'&eid='+expertid);
                					}
                				});
                         }
      		</script>
                    <div class="buttonSub">
                        <div class="buttonSubmit">
                        	<span class="reserveButton">立即预定</span>
                        	<span class="collectButton" id="collect_start_button" onclick="collect_line(this)" data-val="<?php echo $c_userid.'|'.$collection_count.'|'.$line_id?>">
                        	<i class="shoucang_img" style="background:url(<?php echo base_url('static'); ?>/img/shoucang.png)"></i>
                            <div style="color:#666;">收藏商品</div>
                            <!-- 未收藏 上一行 背景图片是  shoucang.png,  已收藏 是  shoucang.png   判断是否输出2就行 -->
                            </span>
                        </div>
                        <span class="calltall">您也可以拨打24h客服电话<span style=" color:#F00; font-size:13px;">400-6939-800</span>咨询或者下单</span> </div>
                </div>
                <!-- 订单线路信息结束 -->

                <!-- 线路介绍 -->
                <div class="detailReferral_box">
                    <div class="detailReferral">
                        <div class="Recommend">
                            <div class="Recommend_title">
                                <h2>特色推荐</h2>
                            </div>
                            <div class="teristic_list"><?php echo $line_data['features'];?></div>
                        </div>
                        <!-- <div class="xiala_Recommend"><img id="xiala_Recommend" src="<?php echo base_url('static'); ?>/img/bottom.png"/></div> -->
                    </div>

                </div>
                <!-- 线路介绍结束 -->
            </div>
            <!-- 右部结束 -->
        </div>
        <div class="detail">
            <!-- 预定信息结束 -->
            <!-- 线路介绍导航 -->
            <div class="box_box">
                <div class="detailNav" id="menu">
                    <div class="detailNavList">
                        <h2><a class="detailNvOn one" id="detailNav1" href="#item1" >行程介绍</a></h2>
                        <h2><a class="two" id="detailNav2" href='#item2'>费用说明</a></h2>
                        <!--<a class="six"  id="detailNav6" href='#item6'>购物自费</a>-->
                        <h2><a class="five"  id="detailNav3" href='#item3'>参团须知</a></h2>
                        <?php if(isset($line_data['visa_content']) && !empty($line_data['visa_content'])){?>
                        <h2><a class="four" id="detailNav4" href='#item4'>签证须知</a></h2>
                        <?php }?>
                        <h2><a class="three"  id="detailNav5" href='#item5'>预定须知</a></h2>
                        <!--<a class="seven"  id="detailNav7" href='#item7'>违约条款</a> -->
                        <h2><a class="eight"  id="detailNav8" href='#item8'>游客点评<i style=" color:#F00;">(<?php echo $comment_total;?>)</i></a></h2>
                        <h2><a class="nine" id="detailNav9" href='#item9'>游记分享<i style=" color:#F00;">(
                            <?php if(!empty($line_data['sharecount'])){echo $line_data['sharecount'];}else{echo "0";}?>
                            )</i></a></h2>
                        <h2><a class="ten" id="detailNav10" href='#item10'>在线留言<i style=" color:#F00;">(
                            <?php if(!empty($line_data['online'])){echo $line_data['online'];}else{echo "0";}?>
                            )</i></a></h2>
                        <span class="yuding_box elaiwen">立即预定</span> </div>
                </div>
            </div>
            <!-- 线路介绍导航结束 -->
            <!-- 行程介绍 -->
            <div class="productPresentation">
                <?php if(!empty($line_property)):?>
                <div class="travelTyle">
                    <dl class="clear">
                        <dd class="travelTyleTitle">线路标签:</dd>
                        <dd class="travelTyleoptions">
                            <?php foreach ($line_property as $key=>$val):?>
                            <?php foreach ($val as $k=>$v):?>
                            <span><?php echo $v['attrname'];?></span>
                            <?php endforeach;?>
                            <?php endforeach;?>
                        </dd>
                    </dl>
                </div>
                <?php endif;?>
            </div>
            <div class="productPresentation item" id="item1">
                <div class="journeyTitle clear"> <span>行程介绍</span> </div>
                <div class="journey">
                <?php if(!empty($jieshao)):?>
                    <?php for ($k=0;$k<$line_data['lineday'];$k++):?>
                    <div class="journeylines">
                        <div class="journeyLinesDays"> <img alt="" src="<?php echo base_url('static'); ?>/img/page/33.png"> <span class="LinesDays">D<?php echo $k+1;?></span> </div>
                        <!-- 第一天行程 -->
                        <div class="contexts">
                            <div><span class="linesTitle tltles"><?php echo $jieshao[$k]['theme'];?></span></div>
                            <!--===============行程图片=============== -->
                        </div>
                        <div class="contexts">
                            <div><span class="linesCon"> <?php echo $jieshao[$k]['introduce'];?></span></div>
                        </div>
                        <?php if($jieshao[$k]['breakfirsthas']==1 || $jieshao[$k]['lunchhas']==1 || $jieshao[$k]['supperhas']==1){?>
                        <div class="contexts">
                            <div> <img src="../../../static/img/canyin.png" class="title_ico" style=" margin: 0;"> <span class="linesTitle linesTitle_small">
                                <?php if($jieshao[$k]['breakfirsthas']=="1"){ if(empty($jieshao[$k]['dejeuner'])){ echo '早餐:包含';}else{echo '早餐: '.$jieshao[$k]['dejeuner']; }}?>
                                &nbsp;
                                <?php if($jieshao[$k]['lunchhas']=="1"){ if(empty($jieshao[$k]['lunch'])){ echo '午餐:包含';}else{ echo '午餐: '.$jieshao[$k]['lunch']; }}?>
                                &nbsp;
                                <?php if($jieshao[$k]['supperhas']=="1"){ if(empty($jieshao[$k]['supper'])){ echo '晚餐:包含';}else{ echo '晚餐: '.$jieshao[$k]['supper']; }}?>
                                </span> </div>
                        </div>
                        <?php }?>
                        <!-- 第一天住宿 -->
                        <?php if(!empty($jieshao[$k]['hotel'])){?>
                        <div class="contexts">
                            <div><img src="../../../static/img/zhusu.png" class="title_ico"><span class="linesTitle linesTitle_small"><?php echo $jieshao[$k]['hotel'];?></span> </div>
                        </div>
                        <?php }?>
                        <?php if(!empty($jieshao[$k]['traffic'])){?>
                        <!-- 第一天交通 -->
                        <div class="contexts">
                            <div><img src="../../../static/img/jiaotong.png" class="title_ico"><span class="linesTitle linesTitle_small"><?php echo trim($jieshao[$k]['traffic'],',');?></span></div>
                        </div>
                        <?php }?>
                        <div class="travel_introduce_img">
                            <!--===============行程图片=============== -->
                            <ul class="clear">
                                <?php if(isset($jieshao[$k]['pic_arr']) && !empty($jieshao[$k]['pic_arr'])):?>
                                <?php foreach ($jieshao[$k]['pic_arr'] AS $va):?>
                                <li><img src="<?php echo $va;?>" alt=""/></li>
                                <?php endforeach;?>
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                    <?php endfor;?>
                <?php endif;?>
                    <?php if(count($jieshao)>=2):?>
                    <div id="productPresentationPackDown" style="display: none;">更多</div>
                    <?php endif;?>
                    <?php if(!empty($line_data['line_beizhu'])){echo '<span style="font-weight: bold;color:#333">温馨提示:</span>'.$line_data['line_beizhu'] ;}?>
                </div>
            </div>
            <div id="productPresentationPackUp">收起^</div>
            <!-- 行程介绍结束 -->
            <!-- 费用说明 -->
            <div class="kostenindicatie item" id="item2">
                <div class="kostenindicatieTitle"> <span>费用说明</span> </div>
                <div class="kostenindicatieContext">
                    <div class="Inclusions"> <span>费用包括</span><br />
                        <?php if(isset($line_data['feeinclude']))echo $line_data['feeinclude'];?>
                    </div>
                    <div class="NoInclusions"> <span>费用不包括</span><br />
                        <?php echo $line_data['feenotinclude'];?> </div>
                    <?php if(!empty($line_data['insurance'])){?>
                    <div class="NoInclusions"> <span>保险说明</span><br />
                        <?php echo $line_data['insurance'];?> </div>
                    <?php }?>
                    <?php if(!empty($line_data['other_project'])){?>
                    <div class="NoInclusions"> <span>购物自费</span><br />
                        <?php echo $line_data['other_project'];?> </div>
                    <?php }?>
                </div>
            </div>
            <!-- 费用说明结束 -->
            <!-- 自费项目开始 -->
            <!-- <?php if(!empty($line_data['other_project'])){?>
  	<div class="visanotice ownpayobject item" id="item6">
    	<div class="visanoticeTitle"> <span>购物自费</span> </div>
    	<div class="visanoticeContent ownpayobjectContent">
   	<!-- <?php if(!empty($line_data['other_project'])){echo $line_data['other_project'] ;}else{echo "没有自费项目";}?>
    </div>
  	</div>
  	<?php }?> -->
            <!-- 自费项目结束 -->

            <!-- 参团须知 -->
            <div class="warmprompt item" id="item3">
                <div class="warmpromptTitle"> <span>参团须知</span> </div>
                <div class="warmpromptContext">
                    <!-- <span><?php if(isset($line_data['beizu']))echo $line_data['beizu'];?></span>  -->
                    <?php if(!empty($line_data['special_appointment'])){?>
                    <div class="NoInclusions"> <span>特别约定</span><br />
                        <?php echo $line_data['special_appointment'];?> </div>
                    <?php }?>
                    <div class="NoInclusions"> <span>温馨提示</span><br />
                        <?php echo $line_data['beizu'];?> </div>
                    <?php if(!empty($line_data['safe_alert'])){?>
                    <div class="NoInclusions"> <span>安全提示</span><br />
                        <?php echo $line_data['safe_alert'];?> </div>
                    <?php }?>
                </div>
            </div>
            <!-- 参团须知结束 -->
            <!-- 签证须知 -->
            <?php if(isset($line_data['visa_content']) && !empty($line_data['visa_content'])){?>
            <div class="visanotice item" id="item4">
                <div class="visanoticeTitle"> <span>签证须知</span> </div>
                <div class="visanoticeContext">
                    <?php if(isset($line_data['visa_content']))echo $line_data['visa_content'];?>
                </div>
            </div>
            <?php }?>
            <!-- 签证须知结束 -->
            <!-- 预定须知 -->
            <div class="Bookings item" id="item5">
                <div class="BookingsTitle"> <span>预定须知</span> </div>
                <div class="BookingsContext">
                    <div> <img src="<?php echo base_url('static'); ?>/img/page/02.png"> </div>
                    <!--<div class="BookingsList"> <?php if(isset($line_data['book_notice']))echo $line_data['book_notice'];?> </div> -->
                </div>
            </div>
            <!-- 预定须知结束 -->
            <!-- 违约条款开始 -->
            <!--<div class="visanotice defaultclause item" id="item7">
    <div class="warmpromptTitle"> <span>违约条款</span> </div>
    <div class="warmpromptContext defaultclauseContent">
    	<div class="defaultclause_detail">
        	<div class="defaultclause_title">1、旅行社违约: </div>
            <p>行程前30日至16日，退还全额旅游费，支付旅游费用总额30%的违约金。</p>
            <p>行程前15日至8日，退还全额旅游费，支付旅游费用总额50%的违约金。</p>
            <p>行程前7日至1日，退还全额旅游费，支付旅游费用总额60%的违约金。</p>
            <p>行程开始当日，退还全额旅游费，支付旅游费用总额80%的违约金。</p>
            <p>凡订购产品的行程日期部分或全部涉及节假日时段，退还全额旅游费用，支付旅游费用总额80%的违约金。</p>
     		<div class="defaultclause_title">2、旅行者违约：</div>
            <p>在行程前解除合同的，必要的费用扣除标准为：</p>
            <p>行程前30日至16日，收取旅游费用总额30%的违约金。</p>
            <p>行程前15日至8日，收取旅游费用总额60%的违约金。</p>
            <p>行程前7日至1日，收取旅游费用总额80%的违约金。</p>
            <p>凡订购产品的行程日期部分或全部涉及节假日时段，退还全额旅游费用，支付旅游费用总额100%的违约金。</p>
        </div>
    </div>
  </div> -->
            <!-- 违约条款结束 -->

            <!-- 游客点评 -->
            <div class="touristcomment item" id="item8">
                <div class="touristcommentTitle"> <span>游客点评</span> </div>
                <div class="touristcommentContext">
                    <div class="touristcommentMessage clear">
                        <div class="touristcommentMessage1"> <span>
                            <p class="satisfaction">
                                <?php if(empty($line_data['satisfyscore']) || $line_data['satisfyscore']==0){echo "暂无";}else{echo ($line_data['satisfyscore'] *100).'%';}?>
                            </p>
                            <p>满意度</p>
                            </span> <span>
                            <p class="introduce"> 点评来自
                                <e style="color:red; font-size:18px;"><?php echo empty($line_data['peoplecount'])?0:$line_data['peoplecount'];?></e>
                                位游客的旅游真实感受 </p>
                            </span> <span style="margin-top:24px;">
                            <p class="evaluate">出游回来可点评产品</p>
                            <a onclick="publish_comment(this)" data-val="<?php echo $c_userid?>" class="evaluateButton">发表评论</a> </span> </div>
                        <div class="touristcommentMessage2"> <span>
                            <input type="radio" name="dianping" checked=true flag="0" onclick="show_comment_type(this)">
                            全部点评(<?php echo $comment_total;?>)</span> <span>
                            <input type="radio" name="dianping" flag="1" onclick="show_comment_type(this)">
                            失望(
                            <?php if(array_key_exists(1,$comment_count_array)){echo $comment_count_array['1'];}else{echo 0;}?>
                            ) </span> <span>
                            <input type="radio" name="dianping" flag="2"onclick="show_comment_type(this)">
                            不满(
                            <?php if(array_key_exists(2,$comment_count_array)){echo $comment_count_array['2'];;}else{echo 0;}?>
                            ) </span> <span>
                            <input type="radio" name="dianping" flag="3" onclick="show_comment_type(this)">
                            一般(
                            <?php if(array_key_exists(3,$comment_count_array)){echo $comment_count_array['3'];;}else{echo 0;}?>
                            ) </span> <span>
                            <input type="radio" name="dianping" flag="4" onclick="show_comment_type(this)">
                            满意(
                            <?php if(array_key_exists(4,$comment_count_array)){echo $comment_count_array['4'];;}else{echo 0;}?>
                            ) </span> <span>
                            <input type="radio" name="dianping" flag="5" onclick="show_comment_type(this)">
                            惊喜(
                            <?php if(array_key_exists(5,$comment_count_array)){echo $comment_count_array['5'];;}else{echo 0;}?>
                            ) </span> <span>
                            <input type="radio" name="dianping" flag="6" onclick="show_comment_type(this)">
                            有照片 </span>
                            <input type="hidden" name="data-flag" value="0" />
                        </div>
                        <div id="comment_list">
                            <!-- 游客点评列表 -->
                        </div>
                        <div id="comment_Pagination" class="pagination" style="  position:relative; bottom: -15px; float: right; margin-right: 45px;margin-bottom: 10px;">
                            <!-- 分页 -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- 游客点评结束 -->
            <!-- 游客分享 -->
            <!--样式与游客点评一致-->
            <div class="touristcomment1 item clear" id="item9">
                <div class="touristcommentTitle"> <span>游记分享</span> </div>
                <div class="touristcommentContext">
                    <div id="share_list">
                        <!-- 游客分享列表 -->
                    </div>
                    <div id="comment_Pagination_share" class="pagination" style="position: relative; bottom: -14px; float: right; margin-right: 45px;">
                        <!-- 分页 -->
                    </div>
                </div>
            </div>
            <!-- 游客分享结束 -->
            <!-- 在线留言 -->
            <div class="onlineconsultant item" id="item10">
                <div class="onlineconsultantTitle"> <span class="onlineconsultantTitles">在线留言</span>
                    <?php $c_user = $this->session->userdata('c_username');if(empty($c_user)):?>
                    <span class="onlineconsultantLable">帮游会员才能进行提问,请先<a href="<?php echo base_url();?>login">登录</a>。没有帮游账户?请<a href="<?php echo base_url();?>register">立即注册</a>，惊喜不断!</span>
                    <?php endif;?>
                </div>

                <!-- 在线留言数据  -->
             <div class="sultation_list">
              <div class="sultation_top_tate">
                  <div class="sultation_list_title">留言类型:</div>
                  <ul class="sultation_state">
                     <li> <input type="radio" name="sultation_lis" flag="0" onclick="show_online_type(this)" checked="true"> <span>全部</span></li>
                      <li> <input type="radio" name="sultation_lis" flag="1" onclick="show_online_type(this)"> <span>住宿</span></li>
                      <li><input type="radio" name="sultation_lis"  flag="2" onclick="show_online_type(this)"> <span>交通</span></li>
                      <li><input type="radio" name="sultation_lis"  flag="3" onclick="show_online_type(this)"><span>导游</span></li>
                      <li><input type="radio" name="sultation_lis"  flag="4" onclick="show_online_type(this)"><span>行程</span></li>
                      <li><input type="radio" name="sultation_lis"  flag="5" onclick="show_online_type(this)"><span>预定行程</span></li>
                      <input type="hidden" name="online_type" value="" />
                  </ul>
              </div>
              <div id="online_list">
                <!--在线留言列表-->

               </div>

              <div id="online_Pagination" class="pagination" style="position: relative; bottom: -25px; float: right; margin-right: 45px;">
                        <!-- 分页 -->
                    </div>
          </div>
            <!-- End 在线留言数据  -->


                <form name="online_consultation" id="online_consultation" method="post">
                    <div class="onlineconsultantContext clear"> <span class="questionType fl">提问类型: </span> <span class="inputTroup fl">
                        <input type="radio" name="consultation_radio" checked="" value="1" />
                        住宿&nbsp;&nbsp;
                        <input type="radio" name="consultation_radio" value="2" />
                        交通&nbsp;&nbsp;
                        <input type="radio" name="consultation_radio" value="3" />
                        导游&nbsp;&nbsp;
                        <input type="radio" name="consultation_radio" value="4" />
                        行程&nbsp;&nbsp;
                        <input type="radio" name="consultation_radio" value="5" />
                        预订过程&nbsp;&nbsp; </span> <br />
                        <br />
                        <span class="questionArea">提问内容: </span> <br />
                        <br />
                        <textarea class="questionContent" name="consultation_content"> </textarea>
                        <br />
                        <span class="email"> 请填写邮箱，详细解答会同时发送至您的邮箱。E-mail:
                        <input type="email" class="emailAddress" name="consultation_email" />
                        </span> <br />
                        <br />
                        <div> <span class="email"> 验证码： </span>
                            <input class="yanzheng" name="verify_code" id="verify_code" value="" />
                            &nbsp;&nbsp; <img calss="yanzheng" style="-webkit-user-select: none; position:relative; top:11px;_top:3px; border:1px solid #999;" id="verifycode_tool" src="<?php echo base_url('tools');?>" onclick="this.src='<?php echo base_url('tools');?>?'+Math.random()"> </div>
                        <br />
                        <br />
                        <input class="fabiao" type="submit" value="提交咨询" />
                        <input type="reset" style="display: none;" id="reset_consultation" />
                        <input type="hidden" name="consultation_productid" value="<?php echo $productid?>" />
                    </div>
                </form>
            </div>
        </div>
        <!-- 在线咨询结束 -->
        <!-- 右部定制信息 -->
        <div class="Rightdetail">
            <div class="MyHaveDetail">
                <h3><a href="<?php echo base_url('dzy'); ?>"><img src="<?php echo base_url('static'); ?>/img/wodedingzhi.png"/></a></h3>
            </div>
            <div class="hotConsultantExpert clear"> <span class="title_info fl">热门咨询专家</span> <span class="exchange_page fr" id="next_experts" onclick="next_page_expert(this)" data-page="2">换一批</span> </div>
            <div class="hotExperts" id="r_hotExperts">
                <?php
                $i = 0;
                foreach ($right_expert as $key=>$val):
                	if ($i >4) {break;}
                	++$i ;
                ?>
                <!-- guanj改为guanjia 魏勇编辑-->
                <div class="hotExpertList" > <img style="width:200px; height:200px; border-top:1px solid #dedede;" src="<?php echo $val['small_photo']?>" onClick="javascript:window.location.href='<?php echo base_url('guanjia/'.$val['id'].'.html');?>' " />
                    <div class="expertConsultButton"> <a href="<?php echo base_url('srdz/e-'.$val['id']).'.html'; ?>"> <span class="customizationButton">找我定制</span> </a> <a href="<?php $memberid=$this->session->userdata('c_userid');echo $web['expert_question_url'].'/kefu_member.html?mid='.$memberid.'&eid='.$val['id']; ?>" target="_blank"> <span class="consultButton">找我咨询</span> </a> </div>
                    <div class="dl_box">
                        <dl class="dl_box_name">
                            <dd > <span class="expertName" title="<?php echo $val['nickname'];?>">
                                <?php if($len = mb_strlen($val['nickname'],'utf8')<4) echo $val['nickname'];else echo mb_substr($val['nickname'],0,3)."…";?>
                                </span> </dd>
                            <dd> <span class="expertCity"><i></i><?php echo $val['city'];?></span> </dd>
                            <dd style="width:40px;float:right;" title="<?php echo $val['grade'];?>"> <span class="expertType">
                                <?php if($len = mb_strlen($val['grade'],'utf8')<4) echo $val['grade'];else echo mb_substr($val['grade'],0,2);?>
                                </span> </dd>
                        </dl>
                        <br />
                        <div class="bottomLine"></div>
                        <dl style="padding-top:7px; color:#808080;">
                            <dd><span>成交量</span></dd>
                            <dd><span>评论</span></dd>
                            <dd><span>满意度</span></dd>
                        </dl>
                        <br />
                        <dl style="color:#808080;">
                            <dd><span><?php echo $val['scheme'];?></span></dd>
                            <dd><span><?php echo $val['comment_count'];?></span></dd>
                            <dd><span><?php echo (empty($val['satisfaction_rate']) || $val['satisfaction_rate']==0) ? '暂无':($val['satisfaction_rate']*100).'%';?></span></dd>
                        </dl>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
            <div class="experience_right_side fr" style="margin-top:20px;">
                <div class="right_side_content">
                    <h4 class="hot_experience_line">销量排行</h4>
                    <div>
                        <ul class="hot_experience_line_list clear">
                            <?php
                            	if (!empty($hot_line)):
                            	foreach($hot_line as $key =>$val):
                            	//$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/cj/'.$val['id'] : '/gn/'.$val['id'];
                                $line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html';
                            ?>
                            <li class="clear">
                                <div class="hot_line_info"> <a href="<?php echo $line_url; ?>" target="_blank">
                                    <div class="hot_line_num fl"> <span><?php echo $key+1;?></span> </div>
                                    <div class="hot_line_txt fl">
                                        <?php if($len = mb_strlen($val['linename'],'utf8')<18) echo $val['linename']; else echo mb_substr($val['linename'],0,17)."...";?>
                                        <div class="hot_line_price fr"><span>¥ </span><?php echo $val['lineprice']?> </div>
                                    </div>
                                    </a> </div>
                                <div class="hot_line_cover"> <a href="<?php echo $line_url;?>" target="_blank"> <img src="<?php echo $val ['mainpic'] ?>" alt="" width="200" height="120"/>
                                    <div class="cover_info">
                                        <div class="cover_num fl"><span><?php echo $key+1?></span></div>
                                        <div class="cover_txt fl">
                                            <?php if($len = mb_strlen($val['linename'],'utf8')<18) echo $val['linename']; else echo mb_substr($val['linename'],0,17)."...";?>
                                            <div class="cover_price fr"><span>¥</span> <?php echo $val['lineprice']?> </div>
                                        </div>
                                    </div>
                                    </a> </div>
                            </li>
                            <?php endforeach;endif;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- 右部定制信息结束 -->
    </div>
    <!-- 内容结束 -->
    <!-- 取消订单出层内容 -->

    <!-- end -->
</div>
<!--====================咨询体验师弹框=================== -->
<div class="private_letter_box">
    <div class="private_letter_content"> <span class="close_private_letter"><i></i></span>
        <div class="private_title">咨询</div>
        <div class="write_content clear">
            <form action="" method="post">
                <div class="private_object fl"><span class="title_name">发件人:</span><span class="title_name_content">会员昵称</span></div>
                <div class="private_object fr"><span class="title_name">收件人:</span><span class="title_name_content">体验师昵称</span></div>
                <div class="fl"><span class="title_name num_info">手机号:</span>
                    <input type="text" name="" value="18787878787" class="write_input"/>
                </div>
                <div class="fl"><span class="title_name num_info">微信号:</span>
                    <input type="text" name="" value="" placeholder="请输入您的微信号" class="write_input"/>
                </div>
                <div class="private_product_info fl"><span class="title_name">产品名称:</span><span class="title_name_content private_product_name">韩国济州3晚4日跟团游(华南众游韩2日游）</span></div>
                <div class="fl" style="position:relative;"><span class="title_name">内容:</span>
                    <textarea name="" class="txt_content" placeholder="请编辑您要咨询的内容，100字以内"></textarea>
                    <span class="font_num_title">已写<i>0</i>字</span> </div>
                <div class="submit_button fl">
                    <input type="submit" name="submit" value="发送" class="send_letter"/>
                    <input type="reset" class="cancel"/>
                    <span class="cancel_button">取消</span> </div>
            </form>
        </div>
    </div>
</div>
<div class="bg_box"></div>
<?php echo $this->load->view('common/footer');  ?>
<?php $this->load->view('common/choice_expert'); ?>
</body>
</html>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script src="<?php echo base_url('static'); ?>/js/eject_sc.js" type="text/javascript"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery.jcarousellite.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script>
 //overflow: hidden;  detailLeft

 var isIE=!!window.ActiveXObject;
var isIE6=isIE&&!window.XMLHttpRequest;
var isIE8=isIE&&!!document.documentMode;
var isIE7=isIE&&!isIE6&&!isIE8;
if (isIE6){
    $(".detailLeft").css("overflow","hidden")
    //alert("ie6")
}

</script>
<script>


$(document).ready(function(){

        //每次进入这个页面就将该线路的浏览量加一
        var lineid = <?php echo $line_data['id'];?>;//线路ID
        $.post("<?php echo base_url('line/line_detail/add_shownum')?>",{'l_id':lineid},function(res){});



    $(window).scroll(function(){
        var top = $(document).scrollTop();          //定义变量，获取滚动条的高度
        var menu = $("#menu");                      //定义变量，抓取#menu
        var items = $(".item");
        var curId = "";                             //定义变量，当前所在的楼层item #id
        items.each(function(){
            var m = $(this);                        //定义变量，获取当前类
            var itemsTop = m.offset().top;
            var ien = $(".one").offset().top;
            if(top-2 > itemsTop-50){
                curId = "#" + m.attr("id");
            }else{
            	$(".one").removeClass("detailNvn");
            }
            var this_top=$(".productPresentation").offset().top;
        	if(ien<this_top){
        		$(".one").addClass("detailNvn");
        	}
        });
		var curLink = menu.find(".detailNavOn");
        if( curId && curLink.attr("href") != curId ){

            $(".detailNavList a").removeClass("detailNavOn");
            menu.find( "[href=" + curId + "]" ).addClass("detailNavOn");
			$(".padding_top").removeClass("padding_top")
			$(curId).addClass("padding_top");
			$("#item11").removeClass("padding_top");
        }
    });
	var lastId ="";
	var endId ="" ;

	$(".detailNavList a").click(function(){
		$(".one").removeClass("detailNvn");
		 //获取 id 截取第一个
		var href= $(this).attr("href");
		endId= $(this).attr("id");
		$(".padding_top").removeClass("padding_top")
		$(href).addClass("padding_top")
		$("#item11").removeClass("padding_top");
		$("html,body").animate({scrollTop:$(href).offset().top},0)
	});

});

</script>
<script type="text/javascript">

$(function(){

	//管家咨询咨询管家服务弹框
	$(".follow_server_link").click(function(){
		var lineid = <?php echo $line_data['id'];?>;//线路ID
		$("#choiceExpertForm").find("input[name='line_id']").val(lineid);
		$("#lineExpertList").choiceExpert();
		$(".determine_button").hide(); //隐藏确定按钮
	});

	//分享 鼠标移上效果
	$(".consultButton").hover(function(){
		$(".share_style").show();
	},function(){
		$(".share_style").hide();
	});

//出发时间 下拉框效果
	$(".expertAge_showbox").click(function(){
		$(".expertAge_showbox").siblings(".expertAge_option").hide();
		$(this).siblings(".expertAge_option").show();
	});
	 $(document).mouseup(function(e) {
          var _con = $('.expertAge_box'); // 设置目标区域
          if (!_con.is(e.target) && _con.has(e.target).length === 0) {
              $(".expertAge_box").find("ul").hide()
          }
      })
	$(".jCarouselLite").jCarouselLite({
		btnNext: "#btnNext",
		btnPrev: "#btnPrev",
		scroll: 1,
		speed: 240,
		circular: false,
		visible: 5
	});
});
</script>
<script type="text/javascript">

//页面加载完了之后,初始化收藏状态
function init_collect_start(){
      var c_userid = "<?php echo $c_userid?>";
      var collect_count = "<?php echo $collection_count?>";
      if(collect_count==0){
    	  $('.shoucang_img').css('background','url(../../static/img/shoucang.png)');
      }else{
    	  $('.shoucang_img').css('background','url(../../static/img/shoucang2.png)');
      }

}

//收藏或者取消收藏线路
function collect_line(obj){
   //这个对应三个值,分别是 账户ID,是否有收藏(0,1),线路ID
    var line_info = $(obj).attr('data-val').split('|');
    if(line_info[0]==''){  //收藏操作之前必须要先登录
       /*alert('请先登录!');
       location.href="<?php echo base_url('login')?>";*/
       $('.login_box').css("display","block");
    }else{
      if(line_info[1]==0){//如果没有收藏过,就要添加收藏
        $.post("<?php echo base_url('line/line_detail/add_cancle_collect')?>",
        {'c_member_id':line_info[0],'collect_count':line_info[1],'line_id':line_info[2]},
        function(data){
          data = eval('('+data+')');
          if(data.status==200){
            line_info[1]=1;
            $(obj).attr('data-val',line_info.join("|"));
            alert('收藏成功');
            $('.shoucang_img').css('background','url(../../static/img/shoucang2.png)');
          }else if(data.status==400){
            $('.login_box').css("display","block");
          }
        });
      }else{ //如果已经收藏过,就要取消收藏
          $.post("<?php echo base_url('line/line_detail/add_cancle_collect')?>",
          {'c_member_id':line_info[0],'collect_count':line_info[1],'line_id':line_info[2]},
          function(data){
            data = eval('('+data+')');
            if(data.status==200){
              line_info[1]=0;
              $(obj).attr('data-val',line_info.join("|"));
              alert('取消收藏成功');
              $('.shoucang_img').css('background','url(../../static/img/shoucang.png)');
            }
          });
      }
    }
}



/**************************     用户分享线路到其他社区     ******************************/

window._bd_share_config = {
    slide : [{
      bdImg : 0,
      bdPos : "right",
      bdTop : 200
    }]
  }

/**************************     图片上传     ******************************/

/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/

$('#as').diyUpload({
	url:"<?php echo base_url('line/line_detail/upfile')?>",
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );
	},
	buttonText : '+ 5/5图片上传',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:5,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});
</script>
<script type="text/javascript">
	$(function(){
		$(".close").click(function(){
			$(".fancybox-close").click();
		});
	});
</script>
<script src="<?php echo base_url('static'); ?>/js/line-gallery.js" type="text/javascript"></script><!-- 相册 -->

<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/calendar.js"></script>
<script type="text/javascript">
        $(function(){
                  //初始化收藏状态(就是星星是亮还是暗的)
                  init_collect_start();
                  $(".salesRanking .salesRankingNo").eq(0).find(".salesRankingimg").fadeTo("slow", 0.99);
                  $(".salesRankingNo").hover(function(){
                          $(".salesRankingimg").hide();
                          $(this).children(".salesRankingimg").fadeTo("slow", 0.99);
                  });
        })
</script>
<!-- 收缩行程介绍效果 -->
<script type="text/javascript">
        $(function(){
                $("#productPresentationPackUp").click(function(){
                        $(this).hide();
                        $("#productPresentationPackDown").show();
                        $(".journey .journeylines:not(:first)").hide();
		window.location.href="#kostenindicatie";
                });
                $("#productPresentationPackDown").click(function(){$(this).hide();$("#productPresentationPackUp").show();$(".journey .journeylines").show();});
        });
</script>

<!-- 显示隐藏专家的定制按钮 -->
<script type="text/javascript">
      $(function(){
            $(".hotExperts").children().hover(function(){$(".expertConsultButton").eq($(this).index()).show();},function(){$(".expertConsultButton").eq($(this).index()).hide();});

      })

</script>
<script type="text/javascript">
/*儿童、老人、特殊人群标准显示隐藏*/
        $(function(){
                $(".childStandard").hover(function(){
                  $(this).siblings(".childStandardContext").show()
                },function(){
                	$(this).siblings(".childStandardContext").hide();
                });
        });
        /*显示隐藏产品推荐*/
        $(function(){
        	  $(".fang").click(function(){$(".detailReferralContext1").hide();$(".detailReferralContext2").show();$(this).hide();$(".shou").show();});
        	  $(".shou").click(function(){$(".detailReferralContext2").hide();$(".detailReferralContext1").show();$(this).hide();$(".fang").show();});
        });
		$(function(){
			$("#ThumbPic").css("width","505px")
		})
</script>
<script type="text/javascript">

</script>
<!-- 立即预定 -->
<script type="text/javascript">

var pageSize =10;
var pageIndex = 0;
var share_pageSize = 10;
var share_pageIndex = 0;

	$(function(){
		//立即预定
		$(".reserveButton").click(function(){
			var sid = $(".spanon").attr("suitid"); //套餐ID
			var anum = $("#adultsNums").val(); //成人数量
			var onum = $("#oldNums").val(); //老人数量
			var cnum = $("#childNums").val(); //儿童占床数量
			var cnnum = $("#childnobedNums").val(); //儿童不占床数量
			var line_id = <?php echo $line_data['id']?>;//线路ID
			//var usedate = $('.expertAge_option').find('.selected').attr('value');
			var usedate = $('#usedate').val();
			$.post(
				"<?php echo site_url('order_from/order_info/verification_info')?>",
				{'suit_id':sid,'line_id':line_id,'usedate':usedate,'childnum':cnum,'adultnum':anum,'oldNums':onum,'childnobedNums':cnnum},
				function(data) {
					var data = eval('('+data+')');
					if (data.code == 2000) {
						location.href="<?php echo site_url('order_from/order_info/order_basic_info')?>";
					} else {
						alert(data.msg);
					}
				}
			);
		});

			show_comment_list();
			show_share_list();
                                     show_online_list();
		});

	$('#online_consultation').submit(function(){
			$.post(
				"<?php echo site_url('line/line_detail/online_consultation');?>",
				$('#online_consultation').serialize(),
				function(data) {
					data = eval('('+data+')');
					if (data.status == 1) {
						alert(data.msg);
						$("#verifycode_tool").trigger("click");
						$("#reset_consultation").trigger("click");
					} else if(data.status == -2){
						$('.login_box').css("display","block");
					}else{
						alert(data.msg);
						$("#verifycode_tool").trigger("click");
						$("#verify_code").val('');
					}
				}
			);
			return false;
		});

	//评论分页
	function comment_select_page(pageIndex, jq){
			var flag = $("input[name='data-flag']").val();

     $.post('<?php echo base_url();?>line/line_detail/customer_comments',{"id":<?php echo $line_data['id'];?>,"flag":flag,"pageSize":pageSize,"pageIndex":pageIndex+1},function(data){
    		var data = eval('('+data+')');
			var total = data.total;
			var	str = "";
			$.each(data.result,function(key,value){
					var name = (null==value['truename']|| 'null'==value['truename'])?"匿名":value['truename'];

					str += "<div class='commentContext clear'><dl class='commentContextPic'><dd style='width: 90px;height:90px; border-radius:90px;'><img src='"+value['litpic']+"' style='width: 90px;height:90px;' /></dd><dd style='color:#0b0b0b;font-size:12px;width:90px;text-align:center;'>";
						//str +=value['truename']+"</dd><dd class='cancle_experience_button' onclick='show_experience_box();'>咨询体验师</dd></dl>";
					   str += name+"</dd></dl>";
					str += "<dl class='commentContextCon'><dd class='commentContextMY'><span class='manyichengdu'>";
					if(value['avgscore1']>=1&&value['avgscore1']<2){
                        str +="失望";
                    }else if(value['avgscore1']<3){
                        str += "不满";
                    }else if(value['avgscore1']<4){
                        str += "一般";
                    }else if(value['avgscore1']<5){
                        str += "满意";
                    }else if(value['avgscore1']==5){
                        str += "惊喜";
                    }
					str += "</span><span>导游服务："+value['score1']+"</span><span>行程安排："+value['score2']+"</span><span>饮食住宿："+value['score3']+"</span><span>旅行交通："+value['score4']+"</span></dd>";
					str += "<dd class='commentContextPJ' title='"+value['content']+"'><span class='fl'>评价内容：</span><div class='com_pj_text'>"+value['content']+"</div></dd><dd class='commentContentIMG'>";
					if(value['pictures']){
                        for(var i=0;i<value['pictures'].length;i++){
                            if(null==value['pictures'][i] && 'null'==value['pictures'][i]){
                            	str += "<div class='comment_img_list'><img class='comment_small_img' src='"+value['pictures'][i]+"'/><img class='comment_big_img' src=''/></div>";
                            }
                        }
                    }

					//供应商回复
                                                            if(value['supplier_reply']!=null && value['supplier_reply']!=''){
                                                                str += "<dd class='commentContextPJ yellow_title mar_top' title='"+value['supplier_reply']+"' style='float:right; padding-right:10px;'><span>【供应商回复】:&nbsp;</span><div class='com_pj_text2'>"+value['supplier_reply']+"</div></dd><dd class='commentContentIMG'>";
                                                                /*str += "</dd><dd class='commentContextPJ' style='height:30px;line-height:30px;font-size:14px;color:#808080;  padding-bottom:5px; border-bottom:1px solid #f0f2f5; margin-bottom:10px;float:right;'><span>"+value['addtime']+"</span></dd>";*/
                                                            }


                    //平台回复
                                                             if(value['admin_reply']!=null && value['admin_reply']!=''){
                           str += "<dd class='commentContextPJ red_title mar_top' title='"+value['admin_reply']+"' style='float:right; padding-right:10px;'><span>【平台回复】:&nbsp;</span><div class='com_pj_text3'>"+value['admin_reply']+"</div></dd><dd class='commentContentIMG '>";
                           /*str += "</dd><dd class='commentContextPJ' style='height:30px;line-height:30px; padding-bottom:5px; margin-bottom:10px;font-size:14px;color:#808080;float:right;'><span>"+value['addtime']+"</span></dd>";*/

                                                             }
                    str += "</dl></div>";
                    });
			$("#comment_list").html(str);
			//评论、分享图片放大缩小
			$(".comment_small_img").click(function(){
				$(".comment_big_img").hide();
				var src = $(this).attr("src");
				$(this).siblings(".comment_big_img").attr("src",src).show();
			});
			$(".comment_big_img").click(function(){
				$(this).hide();
			});

     });

	}

	//评论类别
	function show_comment_type(obj){
		var flag= $(obj).attr('flag');
		$("input[name='data-flag']").val(flag);
		show_comment_list();
	}

            //显示在线留言类别
            function show_online_type(obj){
                var flag= $(obj).attr('flag');
                $("input[name='online_type']").val(flag);
                show_online_list();
            }
            //客人在线留言列表
            function show_online_list(){
			   var typeid = $("input[name='online_type']").val();
				$.post('<?php echo base_url();?>line/line_detail/ajax_online_msg',{"id":<?php echo $line_data['id'];?>,"typeid":typeid,"pageSize":pageSize,"pageIndex":pageIndex+1},function(data){
					var data = eval('('+data+')');
					var total = data.total;
					var str = "";
					if(total!==0){
					$.each(data.result,function(key,value){
						str += "<ul class='sultation_bott'><li><div class='guest_Speak'><div class='guest_name'><i></i>"+value['nickname']+": </div><span class='guest_message'>"+value['content']+"</span></div><div class='platform_Speak'><div class='platform_name'>"+value['e_name']+": </div><span class='platform_message'>"+value['replycontent']+"</span></div></li></ul>";
					 });
			  //分页-只初始化一次
				$("#online_Pagination").pagination(total,{
							items_per_page      : pageSize,
							num_display_entries : 11,
							num_edge_entries    : 0,
							prev_text           : "上一页",
							next_text           : "下一页",
							callback            : online_select_page
						});
					}else{
						str +="<div class='commentContext' style='border:none; height:60px; line-height:60px;'><div style='font-size:14px; text-align:center'>本产品暂无留言,如果你有任何疑问,直接戳下方提问.</div></div>";
					}
					$("#online_list").html(str);
				});
            }

            //在线留言列表分页
            function online_select_page(pageIndex, jq){
                var typeid = $("input[name='online_type']").val();
                 $.post('<?php echo base_url();?>line/line_detail/ajax_online_msg',{"id":<?php echo $line_data['id'];?>,"typeid":typeid,"pageSize":pageSize,"pageIndex":pageIndex+1},function(data){
                                            var data = eval('('+data+')');
                                            var total = data.total;
                                            var str = "";
                                            if(total!==0){
                                            $.each(data.result,function(key,value){
                                                str += "<ul class='sultation_bott'><li><div class='guest_Speak'><div class='guest_name'><i></i>"+value['nickname']+": </div><span class='guest_message'>"+value['content']+"</span></div><div class='platform_Speak'><div class='platform_name'>"+value['e_name']+": </div><span class='platform_message'>"+value['replycontent']+"</span></div></li></ul>";
                                             });
                                            }else{
                                                str +="<div class='commentContext' style='border:none;'><h2 style='font-size:20px;color:red'>无数据</h2></div>";
                                            }
                                            $("#online_list").html(str);
                                        });
            }


	//评论列表
	function show_comment_list(){
		var flag = $("input[name='data-flag']").val();
		$.post('<?php echo base_url();?>line/line_detail/customer_comments',{"id":<?php echo $line_data['id'];?>,"flag":flag,"pageSize":pageSize,"pageIndex":pageIndex+1},function(data){
			var data = eval('('+data+')');
			var total = data.total;
			var	str = "";
			if(total!==0){
			$.each(data.result,function(key,value){

					var name = (null==value['truename']|| 'null'==value['truename'])?"匿名":value['truename'];

					str += "<div class='commentContext clear'><dl class='commentContextPic'><dd style='width: 90px;height:90px; border-radius:90px;'><img src='"+value['litpic']+"' style='width: 90px;height:90px;' /></dd><dd style='color:#0b0b0b;font-size:12px;width:90px;text-align:center;'>";

						//str += value['truename']+"</dd><dd class='cancle_experience_button' onclick='show_experience_box();'>咨询体验师</dd></dl>";
					str += name+"</dd></dl>";

					str += "<dl class='commentContextCon'><dd class='commentContextMY'><span class='manyichengdu'>";
					if(value['avgscore1']>=1&&value['avgscore1']<2){
						str +="失望";
					}else if(value['avgscore1']<3){
						str += "不满";
					}else if(value['avgscore1']<4){
						str += "一般";
					}else if(value['avgscore1']<5){
						str += "满意";
					}else if(value['avgscore1']==5){
						str += "惊喜";
					}
					str += "</span><span>导游服务："+value['score1']+"</span><span>行程安排："+value['score2']+"</span><span>饮食住宿："+value['score3']+"</span><span>旅行交通："+value['score4']+"</span></dd>";
					str += "<dd class='commentContextPJ' title='"+value['content']+"'><span class='fl'>评价内容：</span><div class='com_pj_text'>"+value['content']+"</div></dd><dd class='commentContentIMG'>";

					if(value['pictures']){
						for(var i=0;i<value['pictures'].length;i++){
							if(null!=value['pictures'][i] && 'null'!=value['pictures'][i] && '0'!=value['pictures'][i]){
								str += "<div class='comment_img_list'><img class='comment_small_img' src='"+value['pictures'][i]+"'/><img class='comment_big_img' src=''/></div>";
							}
						}
					}

					str += "</dd><dd style='min-height:20px;line-height:20px;font-size:14px;color:#808080; padding-bottom:5px; margin-bottom:10px;float: left; width:828px;'><span>"+value['addtime']+"</span></dd>";

					//供应商回复
                                                            if(value['supplier_reply']!=null && value['supplier_reply']!=''){
                                                                str += "<dd class='commentContextPJ yellow_title mar_top' title='"+value['supplier_reply']+"' style='float:right; padding-right:10px;'><span>【供应商回复】:&nbsp;</span><div class='com_pj_text2'>"+value['supplier_reply']+"</div></dd><dd class='commentContentIMG'>";
                                                                /*str += "</dd><dd class='commentContextPJ' style='height:30px;line-height:30px;font-size:14px;color:#808080;  padding-bottom:5px; border-bottom:1px solid #f0f2f5; margin-bottom:10px;float:right;'><span>"+value['addtime']+"</span></dd>";*/
                                                            }


					//平台回复
                                                             if(value['admin_reply']!=null && value['admin_reply']!=''){
					       str += "<dd class='commentContextPJ red_title mar_top' title='"+value['admin_reply']+"' style='float:right; padding-right:10px;'><span>【平台回复】:&nbsp;</span><div class='com_pj_text3'>"+value['admin_reply']+"</div></dd><dd class='commentContentIMG '>";
					       /*str += "</dd><dd class='commentContextPJ' style='height:30px;line-height:30px; padding-bottom:5px; margin-bottom:10px;font-size:14px;color:#808080;float:right;'><span>"+value['addtime']+"</span></dd>";*/

                                                             }
					str += "</dl></div>";
					});
						if(total>pageSize){
							 //分页-只初始化一次
								$("#comment_Pagination").pagination(total,{
											items_per_page      : pageSize,
											num_display_entries : 11,
											num_edge_entries    : 0,
											prev_text           : "上一页",
											next_text           : "下一页",
											callback            : comment_select_page
										});
							}
				}else{
					str +="<div class='commentContext' style='border:none; height:60px; line-height:60px;'><div style='font-size:14px; text-align:center'>本产品暂无点评信息,游客出游归来可发表评论.</div></div>";
				}
			$("#comment_list").html(str);
			//评论、分享图片放大缩小
			$(".comment_small_img").click(function(){
				$(".comment_big_img").hide();
				var src = $(this).attr("src");
				$(this).siblings(".comment_big_img").attr("src",src).show();
			});
			$(".comment_big_img").click(function(){
				$(this).hide();
			});
		});
	}


	//分享  分页
	function share_select_page(share_pageIndex, jq){
     $.post('<?php echo base_url();?>line/line_detail/customer_share',{"id":<?php echo $line_data['id'];?>,"pageSize":share_pageSize,"pageIndex":share_pageIndex+1},function(data){
    		var data = eval('('+data+')');
			var total = data.total;
			var	str = "";
			$.each(data.result,function(key,value){
					str += "<div class='commentContext over'><dl class='commentContextPic'><dd style='width: 90px;height:90px;border-radius:90px' ><img src='"+value['litpic']+"' style='width: 90px;height:90px;border-radius:90px' /></dd><dd style='color:#0b0b0b;font-size:14px;width:90px;text-align:center;'>"+value['nickname']+"</dd></dl>";
					str += "<dl class='commentContextCon'><dd class='commentContextPJ' title='"+value['title']+"'>游记标题：<a href='<?php echo base_url()?>yj/"+value['tn_id']+"-"+value['usertype']+" '> "+value['title']+"</a></dd><dd class='commentContentIMG'>";
					if(value['pic']){
						for(var i=0;i<value['pic'].length && i<4;i++){
							str += "<div class='comment_img_list'><img class='comment_small_img' src='"+value['pic'][i]+"'/><img class='comment_big_img' src=''/></div>";
						}
					}
					str += "</dd><dd style='height:50px;line-height:50px;font-size:14px;color:#808080;'><span>发表时间：</span><span>"+value['addtime']+"</span></dd></dl></div>";
					});
			$("#share_list").html(str);
			//评论、分享图片放大缩小
			$(".comment_small_img").click(function(){
				$(".comment_big_img").hide();
				var src = $(this).attr("src");
				$(this).siblings(".comment_big_img").attr("src",src).show();
			});
			$(".comment_big_img").click(function(){
				$(this).hide();
			});
     });
	}
	//游客分享
	function show_share_list(){
		$.post('<?php echo base_url();?>line/line_detail/customer_share',{"id":<?php echo $line_data['id'];?>,"pageSize":share_pageSize,"pageIndex":share_pageIndex+1},function(data){
			var data = eval('('+data+')');
			var total = data.total;
			var	str = "";
			if(total!==0){

			$.each(data.result,function(key,value){
					str += "<div class='commentContext fl'><dl class='commentContextPic'><dd style='width: 90px;height:90px;border-radius:90px'><img src='"+value['litpic']+"' style='width: 90px;height:90px;border-radius:90px'  /></dd><dd style='color:#0b0b0b;font-size:14px;width:90px;text-align:center;'>"+value['nickname']+"</dd></dl>";
					str += "<dl class='commentContextCon'><dd class='commentContextPJ' title='"+value['title']+"'>游记标题：<a href='<?php echo base_url()?>yj/"+value['tn_id']+"-"+value['usertype']+" ' > "+value['title']+"</a></dd><dd class='commentContentIMG'>";
					if(value['pic']){
						for(var i=0;i<value['pic'].length && i<4;i++){
							str += "<div class='comment_img_list'><img class='comment_small_img' src='"+value['pic'][i]+"'/><img class='comment_big_img' src=''/></div>";
						}
					}
					str += "</dd><dd><span style='height:30px;line-height:30px;font-size:14px;color:#808080;'>发表时间：</span><span>"+value['addtime']+"</span></dd></dl></div>";
					});
								if(total>share_pageSize){
									//分页-只初始化一次
									$("#comment_Pagination_share").pagination(total,{
												items_per_page      : share_pageSize,
												num_display_entries : 11,
												num_edge_entries    : 0,
												prev_text           : "上一页",
												next_text           : "下一页",
												callback            : share_select_page
											});
								}
                    			}else{
                    				str +="<div class='commentContext' style='border:none; height:60px; line-height:60px;'><div style='font-size:14px; text-align:center'>本产品暂无游记分享,敬请期待.</div></div>";
                    			}
                    			$("#share_list").html(str);
                    			//评论、分享图片放大缩小
                    			$(".comment_small_img").click(function(){
                    				$(".comment_big_img").hide();
                    				var src = $(this).attr("src");
                    				$(this).siblings(".comment_big_img").attr("src",src).show();
                    			});
                    			$(".comment_big_img").click(function(){
                    				$(this).hide();
                    			});

		});
	}
	//咨询体验师弹框
	function show_experience_box(obj){
		$(".private_letter_box,.bg_box").show();
	}
	$(".close_private_letter,.close_expert_server").hover(function(){
		$(this).addClass("hover_this");
	},function(){
		$(this).removeClass("hover_this");
	});

	$(".close_private_letter").click(function(){
		$(".private_letter_box,.bg_box").hide();
	});
	//弹框 取消操作
	$(".cancel_button").click(function(){
		$(".cancel").trigger("click");
		$(".private_letter_box,.bg_box").hide();
	});
function publish_comment(obj){
  var user_id = $(obj).attr('data-val');
  if(user_id==''){
     $('.login_box').css("display","block");
  }else{
      location.href="<?php echo base_url('/order_from/order/line_order/undone')?>";
  }
}
</script>
<script type="text/javascript">
   function next_page_expert(obj){
      var now_page = $(obj).attr('data-page');
      $.post('<?php echo base_url();?>line/line_detail/ajax_right_expert',
        {'line_id':<?php echo $line_id?>,"now_page":now_page},
        function(data){
          var data = eval('('+data+')');
          var str = "";
          if(data.length>0){
            $.each(data,function(key,val){
              str += "<div class='hotExpertList'>";
              // guanj改为guanjia 魏勇编辑
              str += "<img style='width:200px; height:200px; border-top:1px solid #dedede;' src='"+val['small_photo']+"' onClick='javascript:window.location.href='<?php echo base_url()?>guanjia/"+val['id']+".html'>";
              str += "<div class='expertConsultButton' style='display:none'> <a href='<?php echo base_url(); ?>srdz/e-"+val['id']+".html'> <span class='customizationButton'>找我定制</span> </a> <a target='_blank'  href='<?php $memberid=$this->session->userdata('c_userid');echo $web['expert_question_url'].'/kefu_member.html?mid='.$memberid.'&eid='; ?>"+val['id']+"' data-val='<?php echo $line_id;?>'> <span class='consultButton'>找我咨询</span> </a> </div>";
              str += "<div class='dl_box'><dl class='dl_box_name'>";
              if(val['nickname'].length<4){
                var nickname = val['nickname'];
              }else{
                var nickname = val['nickname'].substring(0,3)+'...';
              }
              str += " <dd > <span class='expertName'>"+nickname+"</span> </dd>";
              str += "<dd> <span class='expertCity'><i></i>"+val['city']+"</span> </dd>";
              str += "<dd style='width:40px;float:right;'> <span class='expertType'>"+val['grade']+"</span></dd></dl><br/>";
              str += " <div class='bottomLine'></div><dl style='padding-top:7px; color:#808080;'><dd> <span>成交量</span> </dd><dd> <span>评论</span> </dd><dd> <span>满意度</span> </dd></dl><br/>";
              str += "<dl style='color:#808080;'>";
              str += "<dd> <span>"+val['scheme']+"</span> </dd>";
              str += "<dd> <span>"+val['comment_count']+"</span> </dd>";
              str += "<dd> <span>";
              if(val['satisfaction_rate']!=null && val['satisfaction_rate']!=0){
                str += ((val['satisfaction_rate']*100).toFixed())+"%";
              }else{
                str += "暂无";
              }
              "</span> </dd>";
              str += "</dl></div></div>";
            });
            $("#r_hotExperts").html(str);
            now_page++;
            $(obj).attr('data-page',now_page);
          }else if(now_page >1){
            $(obj).attr('data-page',1);
            next_page_expert($("#next_experts"));
          }
          $(".hotExperts").children().hover(function(){$(".expertConsultButton").eq($(this).index()).show();},function(){$(".expertConsultButton").eq($(this).index()).hide();});
        });

  	}
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

</script>
<script type="text/javascript">

$(".yuding_box").click(function(){
    $("html,body").animate({scrollTop:$("#item11").offset().top},600);

})
$(function(){
    $("#page").css("margin-left","74px");
})

function change_price_type(obj){
    var suit_unit = $(obj).attr('data-unit');
    var html_str = "";
    if(suit_unit>=2){
         html_str = "<div class='adultsNum'><input type='text' name='adults' id='adultsNums' value='1'/><span  class='beings'>份"+suit_unit+"人套餐</span> </div>";
    }else{
        html_str = "<div class='adultsNum'><input type='text' name='adults' id='adultsNums' value='1'/><span  class='beings'>成人</span></div><div class='adultsNum'><input type='text' name='old' id='oldNums' value='0'/><span  class='beings'>老人</span></div><div class='adultsNum'><input type='text' name='child' id='childNums' value='0'/><span class='beings'>占床儿童</span></div><div class='adultsNum'><input type='text' name='childnobed' id='childnobedNums' value='0'/><span  class='beings'>不占床儿童</span></div>";
    }
    $(".travel_num").html(html_str);
}
</script>