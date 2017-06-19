<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $expert_detail[0]['dest']; ?>_私人旅游服务管家<?php echo $expert_detail[0]['nickname']; ?>的主页-帮游旅行网</title>
<meta name="keywords" content="旅游管家服务,私人旅游管家,企业旅游管家" />
<meta name="description" content="私人旅游服务管家<?php echo $expert_detail[0]['nickname']; ?>的个人主页，擅长台湾,马尔代夫,迪拜等旅游线路、提供景点、价格、攻略、签证、机票等多方面的旅游管家服务，记录<?php echo $expert_detail[0]['nickname']; ?>旅游管家的售卖产品，旅游定制记录、游客咨询记录，游客评价以及个人游记等信息。" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/common.css" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/expert_list.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('static'); ?>/css/pagination.css" />
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery.pagination.js"></script>

<!-- 设备判断：若是手机访问，跳转到wap网站（温文斌） -->
<script src="http://siteapp.baidu.com/static/webappservice/uaredirect.js" type="text/javascript"></script>
<?php if(in_array(gethostbyname($_SERVER["SERVER_NAME"]),array('120.25.217.197'))): ?>
<script type="text/javascript">
uaredirect("http://m.1b1u.com/expert/expert_detail?eid=<?php echo $expert_detail[0]['id'];?>")
</script>
<?php endif;?>

</head>
<body style="background:url('<?php if (!empty($expert_detail[0]['template'])){ echo $expert_detail[0]['template'];} else {echo base_url('static/img/page/background.png'); }?>') no-repeat fixed;background-size:cover;">
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<!-- 内容区 -->
<div class="container">
    <div class="main">
        <div style="padding-bottom:150px;margin-bottom: -195px;">
            <div class="w_1200 clear"
style="padding-top: 200px;position:relative; padding-bottom:150px;">
                <div id="left_short"> 
                    <a href="#">
                    <img id="touxiang"
		src="<?php echo $expert_detail[0]['small_photo']; ?>" alt="<?php echo $expert_detail[0]['nickname']; ?>" />
                    </a>
                    <div class="block b1">
                        <div class="_detai_left">
                            <!--定制和咨询两个按钮-->
                            <div class="_btn_sbu"> <a class="kefu _btn_http _back_red" >向我咨询</a>
                                <?php $memberid=$this->session->userdata('c_userid'); echo "<script>$('.kefu').click(function(){window.open('".$web['expert_question_url']."/kefu_member.html?mid=".$memberid."&eid=".$expert_detail[0]['id']."');});</script><script>$('.kefu_link').click(function(){window.open('".$web['expert_question_url']."/kefu_member.html?mid=".$memberid."&eid=".$expert_detail[0]['id']."');});</script>"; ?>
                                <a class="_btn_http _back_yellow"href="<?php echo base_url('srdz/e-'.$expertid.'.html')?>">找我定制</a> </div>
                            <!--管家的相关信息 -->
                            <div>
                                <div class="_exp_name"><span><?php echo $expert_detail[0]['nickname']; ?></span>
                                    <?php
        		if ($expert_detail[0]['sex'] == 1) {
					echo '<i><img src="'.base_url().'static/img/page/n2.png" /></i>';
				} else if($expert_detail[0]['sex'] == -1) {
					echo "<span style='font-size:12px;color:#acacac'>保密</span>";
				}else{
					echo '<i><img src="'.base_url().'static/img/page/n1.png" /></i>';
				}?>
                                </div>
                                <!--目的地-->
                                <div class="_exp_mudidi"><i></i><span><?php echo $expert_detail[0]['city']?></span></div>
                                <!--收藏管家-->
                                <div class="collect_expert clear"><i class="shoucang_img" data-val="<?php echo $user_id.'|'.$collection_count.'|'.$expertid?>" onclick="collect_expert(this)" style="background: url(<?php echo base_url('static'); ?>/img/shoucang.png);"></i><span style=" font-weight: normal; color: #5d7895;">收藏</span></div>
                                <?php /*session_start();*/$memberid=$this->session->userdata('c_userid'); ?>
                            </div>
                            <div class="_exp_results">
                                <div class="_results_main">
                                    <ul>
                                        <li><span>年满意度：</span><i><?php echo (empty($expert_detail[0]['satisfaction_rate']) || $expert_detail[0]['satisfaction_rate']==0) ? '100%' : ($expert_detail[0]['satisfaction_rate']*100).'%' ?></i></li>
                                        <li><span>年总积分：</span><i><?php echo $expert_detail[0]['total_score'] ?>分</i></li>
                                        <li><span>年已成交：</span><i><?php echo $expert_detail[0]['people_count'] ?>人</i></li>
                                        <li><span>年成交额：</span><i><?php echo intval($expert_detail[0]['turnover']) ?>元</i></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="d3" title="<?php echo stripslashes(addslashes(str_replace("\"","'",$expert_detail[0]['talk'])));?>" >
                            <div class="d3_img_1"><i></i></div>
                            <span class="geren_text"><?php echo str_replace("\"","'",str_cut($expert_detail[0]['talk'],"340",'...'));?></span> <span class=" d3_img_2"></span> </div>
                    </div>
                    <div class="block b2">
                        <p class="beGoodAt">上门服务</p>
                        <p class="goodAtContent"><?php echo $expert_detail[0]['visit_service'] ;?></p>
                        <p class="beGoodAt">擅长目的地</p>
                        <p class="goodAtContent"><?php echo $expert_detail[0]['dest'] ;?></p>
                        <p class="hobby">个人简介</p>
                        <p class="hobbyContent"><?php echo $expert_detail[0]['beizhu'] ;?></p>
                    </div>
                    <div class="block b2"> <img src="<?php echo base_url('static'); ?>/img/page/office_qrcode.jpg" /> </div>
                </div>
                <div id="right_long">
                    <div class="d1">
                        <ul class="item-fl tab1">
                            <li class="current" id="click_sell_product"
				onclick="show_sell_product(this)">售卖产品</li>
                            <!-- weiy comment -->
                            <!--<li id="click_trans_record" onclick="show_trans_record(this);">定制记录</li>
                            <li id="click_consultation_record"
				onclick="show_consultation_record(this);">咨询记录</li>-->
                            <li id="click_comment_record"
				onclick="show_comment_record(this);">游客评价</li>
                            <li id="click_honor_record" onclick="show_honor_record(this);" >个人荣誉</li>
                            <li id="click_tour_record" onclick="show_tour_record(this);" >个人游记</li>
                            <!--<li id="click_essay_record" onclick="show_essay_record(this);" style="border-right:none;width:120px;">海外代购</li>-->
                        </ul>
                    </div>
                    <div class="expert_introduce show" id="show_sell_product_div">
                        <?php if(!empty($sale_product)):?>
                        <div class="bg2 b1">
                            <ul class="list_jiandian">
                                <?php
                                	foreach ($sale_product as $key => $val):
                                            // 将cj,gn改为line,添加后缀.html 魏勇编辑
                                	$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html';
                                ?>
                                <?php if ($key < 6): ?>
                                <li <?php if ($key % 2 == 1): ?> class="mr0<?php endif; ?>"> <a href="<?php echo $line_url;?>"><img src="<?php echo $val['mainpic'];?>" title="<?php echo $val['linename']; ?>" /> </a> <a href="<?php echo $line_url;?>"> <span  class="neirong">
                                    <?php
                                                 	if(mb_strlen($val['linename'],'utf-8')>25){
                                                     		echo mb_substr($val['linename'],0,25,'utf-8').'...';
                                                 	}else{
                                                 		echo $val['linename'];
                                                 	}
                                                 ?>
                                    </span> </a> <span class="fr" style='font-family: "arial";'>¥ <?php echo $val['lineprice']?>起</span> </li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php else:?>
                        <div class="bg2 b1" style='text-align:center;'>
                            <div class="honorList" style=" background:#fff"> <img src='/static/img/page/noer_date.png' style="margin-top:20px;"></div>
                        </div>
                        <?php endif;?>
                        <?php if(!empty($sale_product)):?>
                        <a href="/all/e-<?php echo $expertid?>.html"class="more"> <span class="more_p"> 更多</span></a>
                        <?php endif;?>
                    </div>
                    <div class="expert_introduce" id="show_trans_record_div">
                        <div id="show_trans_record_div_1"></div>
                        <div id="tranc_Pagination" class="pagination" ></div>
                    </div>
                    <div class="expert_introduce" id="show_consultation_record_div">
                        <div class="bg2">
                            <div class="cansult_record_content">
                                <div class="cansult_record_type clear"> <span class="zixun fl" style="position:relative;top:18px;*top:10px;">咨询分类：</span>
                                    <div class="kindbar_list fl">
                                        <ul>
                                            <li data-val='' onclick="search_consultation(this)"
							class="kindbaron"><a>全部</a></li>
                                            <li data-val='1' onclick="search_consultation(this)"
							style="cursor: pointer"><a>交通</a></li>
                                            <li data-val='2' onclick="search_consultation(this)"
							style="cursor: pointer"><a>住宿</a></li>
                                            <li data-val='3' onclick="search_consultation(this)"
							style="cursor: pointer"><a>餐饮</a></li>
                                            <li data-val='4' onclick="search_consultation(this)"
							style="cursor: pointer"><a>景点</a></li>
                                            <input type="hidden" name="search_typeid" id="search_typeid"
							value="" />
                                        </ul>
                                    </div>
                                    <span class="quesButton fl" onclick="m_online_consultation(this)"
					data-val="<?php echo $user_id;?>">我要提问</span> </div>
                                <div id="show_consultation_record_div_1" style="background-color:#f4f4f4;"></div>
                                <div id="consultation_Pagination" class="pagination"
				style="position: relative;top:40px;+top:20px; float: right;height:80px;+height:0px; margin-right: 10px;+bottom: 0px; "></div>
                            </div>
                        </div>
                    </div>
                    <!-- 游客评价开始 -->
                    <div class="expert_introduce" id="show_comment_record_div">
                        <div id="show_comment_record_div_1"></div>
                        <div id="comment_Pagination" class="pagination"></div>
                    </div>
                    <!-- 游客评价结束 -->
                    <!-- 个人荣誉开始-->
                    <div class="expert_introduce" id="show_honor_record_div">
                        <ul>
                            <li>
                                <div class="bg2 b2">
                                    <div class="honorList">
                                        <!-- <div class="honorInfo" style="display:block"> <?php echo $expert_honor['travel_title']['travel_title'].'</br>'; ?> </div> -->
                                        <?php if(!empty($expert_honor['cer'])):?>
                                        <?php foreach ($expert_honor['cer'] as $key => $val): ?>
                                        <div class="honorInfo" style="display:block">
                                            <img src="<?php echo $val['certificatepic'].''; ?>">
                                            <span><?php echo $val['certificate'].''; ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php else:?>
                                        <div class="honorInfo" style='text-align:center;'> <img src='/static/img/page/noer_date.png' style="margin-top:-21px; margin-left:140px;"> </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--  个人荣誉结束   -->
                    <!--  个人游记开始   -->
                    <div class="expert_introduce" id="show_tour_record_div">
                        <div class="bg2" style=" min-height: 500px;">
                            <div class="tour_list" id="tour_list">
                                <?php foreach ($expert_travels as $item):?>
                                <div class="tour_list_1 clear">
                                    <!-- 将yj改为youji,添加后缀.html 魏勇编辑-->
                                    <div class="tour_list_fl"> <a href="<?php echo base_url('youji/'.$item['nid'].'-1'.'.html')?>"> <img src="<?php echo $item['tn_pic']?>"></a> </div>
                                    <div class="tour_list_fr">
                                        <p class="list_fr_title"><a href="<?php echo base_url('youji/'.$item['nid'].'-1'.'.html')?>"><?php echo $item['title']?></a></p>
                                        <div class="list_fr_xq">
                                            <div class="list_fr_time"><span><?php echo $item['addtime']?></span></div>
                                            <p class="praise"><i></i><span><?php echo $item['praise_count']?></span></p>
                                            <p class="add"><i></i><span><?php echo $item['comment_count']?></span></p>
                                            <!-- <div class="list_fr_nr">
                                                <p> <?php echo $item['content']?></span></p>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <div class="more_div"> <a href="#" class="list_more" > <span class="more_span" id="more_span"></span></a> </div>
                        </div>
                    </div>
                    <!--  个人游记结束   -->
                    <!--  我的随笔开始   -->
                    <div class="expert_introduce" id="show_essay_record_div">
                        <div id="show_essay_record_div_1">
                            <div class="bg2">
                                <div>
                                    <ul class="essay_list tourList" id="essay_list" style=" background:#fff">
                                    </ul>
                                    <div id="essay_pagination" style="float:right"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  我的随笔结束   -->
                </div>
            </div>
            <div style="display: none;" class="messages_letter"> <span class="messages_close"><img src="../../../static/img/x_ico1.png"></span>
                <form name="online_consultation" id="online_consultation" method="post">
                    <div class="question_type clear"> <span class="fl">提问类型:</span>
                        <ul class="fl">
                            <li>
                                <input type="radio" name="consultation_radio" checked="" value="1" />
                                交通</li>
                            <li>
                                <input type="radio" name="consultation_radio" value="2" />
                                住宿</li>
                            <li>
                                <input type="radio" name="consultation_radio" value="3" />
                                餐饮</li>
                            <li>
                                <input type="radio" name="consultation_radio" value="4" />
                                景点</li>
                        </ul>
                    </div>
                    <div class="question_content clear"><span class="fl">提问内容:</span>
                        <textarea class="questionContent fl" name="consultation_content"></textarea>
                        <input type="hidden" name="expert_id" value="<?php echo $expertid?>"/>
                    </div>
                    <div class="question_button">
                        <input type="submit" value="提 交" />
                    </div>
                </form>
            </div>
            <div class="messages_color" style="display: none;"></div>
        </div>
    </div>
</div>
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
</div>
</body>
</html>
<script type="text/javascript">

function init_collect_start(){
var c_userid = "<?php echo $user_id?>";
var collect_count = "<?php echo $collection_count?>";
if(collect_count==0){
$('.shoucang_img').css('background','url(../../static/img/shoucang.png)');
}else{
$('.shoucang_img').css('background','url(../../static/img/shoucang2.png)');
}

}
init_collect_start();

//显示右侧客服图标
$(".return_top ul li").eq(0).css("display","block");

var pageSize =5;
var pageIndex = 0;
var totalheight = 0;     //定义一个总的高度变量


//初始化查询的值
$(document).ready(function(){
//跳转到游客评论
var type_url = "<?php echo $_SERVER['REQUEST_URI'];?>";
var type = window.location.href;
var s = "#";
var index = type.indexOf(s);
var str = type.substr(index+1);
$("#click_"+str).click();

$("#search_typeid").val('');
});
//点击咨询小标签异步查询记录
function search_consultation(obj){
var typeid = $(obj).attr('data-val');
$(obj).addClass('kindbaron');
$(obj).siblings().removeClass("kindbaron");
$("#search_typeid").val(typeid);
show_consultation_record($("#click_consultation_record"));
}
//显示定制记录
function show_trans_record(obj){
$(obj).addClass('current');
$("#click_sell_product").removeClass('current');
$("#click_consultation_record").removeClass('current');
$("#click_comment_record").removeClass('current');
$("#click_honor_record").removeClass('current');
$("#click_tour_record").removeClass('current');
$("#click_essay_record").removeClass('current');

$.post('<?php echo base_url()?>expert/expert_detail/get_trans_record',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex},
function(msg){
var msg = eval('('+msg+')');
var total = msg.total;
var startdate = "";
var html = '<ul class="kj">';
if(total!=0){
$.each(msg.result,function(key,value){
    html += "<li><div class='bg2 b2' style='padding-bottom:0;'><div class='box_service'>";
html += "<div class='z1'><img src='"+value['litpic']+"' alt=''><h1>"+value['truename']+"</h1>&nbsp;&nbsp;&nbsp;"+"<span>"+value['addtime']+"</span>"+"<a href='<?php echo base_url()?>dzy/"+value['c_id']+"'><span style='position:relative;padding:0 60px;display:block;font-size:14px;margin-top: 15px;margin-left:10px; min-height:18px;color:blue;'>"+value['question']+"</span></a>"+"</div>";
if(value['startdate']!="" && value['startdate']!="0000-00-00"){
            startdate = value['startdate'];
}else{
            startdate = value['estimatedate'];
}
html += "<div class='z2'><ul class='item-fl fl'><li><label>时间</label><span>"+startdate+"</span></li><li><label>出发地</label><span>"+value['startplace']+"</span></li><li><label>目的地</label><span>"+value['endplace_name']+"</span></li><li><label>人数</label><span>成人"+value['people']+"人</span></li><li><label>预算</label><span>"+value['budget']+"/人</span></li></ul></div>";
html +=  "<div class='z3'><dl><dt>总体描述</dt><dd>"+value['plan_design']+"</dd></dl></div>";
/*html +="<div class='z4'><dl><dd>服务态度："+value['score1']+"</dd><dd>方案设计："+value['score2']+"</dd><dd>服务质量："+value['score3']+"</dd></dl></div>";*/
html += "</div></div></li>";
});
}else{
     html += "<li><div class='bg2 b2'><div class='box_service' style='text-align:center;min-height:800px;'><img src='/static/img/page/noer_date.png'></div></div></li>";
     $("#tranc_Pagination").css('display','none');
    }
html += '</ul>';
$('#show_trans_record_div_1').html(html);
//分页-只初始化一次

$("#tranc_Pagination").pagination(total, {
'items_per_page'      : pageSize,
'num_display_entries' : 11,
'num_edge_entries'    : 0,
'prev_text'           : "上一页",
'next_text'           : "下一页",
'callback'            : tranc_select_page
});

});
$("#show_trans_record_div").css('display','block');
$("#show_sell_product_div").css('display','none');
$("#show_consultation_record_div").css('display','none');
$("#show_comment_record_div").css('display','none');
$("#show_honor_record_div").css('display','none');
$("#show_tour_record_div").css('display','none');
$("#show_essay_record_div").css('display','none');
}




//售卖产品
function show_sell_product(obj){
$("#show_trans_record_div").css('display','none');
$("#show_sell_product_div").css('display','block');
$("#show_consultation_record_div").css('display','none');
$("#show_comment_record_div").css('display','none');
$("#show_honor_record_div").css('display','none');
$("#show_tour_record_div").css('display','none');
$("#show_essay_record_div").css('display','none');

$(obj).addClass('current');
$("#click_trans_record").removeClass('current');
$("#click_consultation_record").removeClass('current');
$("#click_comment_record").removeClass('current');
$("#click_honor_record").removeClass('current');
$("#click_tour_record").removeClass('current');
$("#click_essay_record").removeClass('current');
}

//咨询记录
function show_consultation_record(obj){

$(obj).addClass('current');
$("#click_sell_product").removeClass('current');
$("#click_trans_record").removeClass('current');
$("#click_comment_record").removeClass('current');
$("#click_honor_record").removeClass('current');
$("#click_tour_record").removeClass('current');
$("#click_essay_record").removeClass('current');


var typeid = $("#search_typeid").val();
$.post('<?php echo base_url()?>expert/expert_detail/get_consultation_record',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex+1,'typeid':typeid},
function(msg){
msg = eval('('+msg+')');
var total = msg.total;
var html = "<div class='bg2 hg'><ul class='consult'>";
if(total!=0){
$.each(msg.result,function(key,value){
html += "<li>";
if(value['linename']==null || value['linename']==''){
	value['linename']='客人问答';
}
 html +="<a style='color:blue' href='<?php echo base_url()?>line/line_detail_"+value['l_id']+".html'><h1 style='font-size: 18px;'>"+value['linename']+"</h1></a>";
html += "<div class='l1_txt' style='margin-top:20px;'> <i ></i><label>咨询内容：</label><p>"+value['content']+"</p></div>";
if(value['replycontent']!=null){
	html +="<div class='l2_txt'><label>管家回复：</label><p>"+value['replycontent']+"</p></div>";
}
html += "</li>";
});
}else{
html += "<li style='text-align:center;'><img src='/static/img/page/noer_date.png'></li>";
$("#consultation_Pagination").css('display','none');
}
html += '</ul></div>';
$('#show_consultation_record_div_1').html(html);
//分页-只初始化一次
$("#consultation_Pagination").pagination(total, {
'items_per_page'      : pageSize,
'num_display_entries' : 11,
'num_edge_entries'    : 0,
'prev_text'           : "上一页",
'next_text'           : "下一页",
'callback'            : consultation_select_page
});
});

$("#show_trans_record_div").css('display','none');
$("#show_sell_product_div").css('display','none');
$("#show_consultation_record_div").css('display','block');
$("#show_comment_record_div").css('display','none');
$("#show_honor_record_div").css('display','none');
$("#show_tour_record_div").css('display','none');
$("#show_essay_record_div").css('display','none');

}

//游客评论
function show_comment_record(obj){
$("#show_trans_record_div").css('display','none');
$("#show_sell_product_div").css('display','none');
$("#show_consultation_record_div").css('display','none');
$("#show_comment_record_div").css('display','block');
$("#show_honor_record_div").css('display','none');
$("#show_tour_record_div").css('display','none');
$("#show_essay_record_div").css('display','none');

$.post('<?php echo base_url()?>expert/expert_detail/get_comment_record',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex},
function(msg){
msg = eval('('+msg+')');
var total = msg.total;
var html = "<ul><li><div class='bg2 b2'><div class='tourList'>";
if(total!=0){
        $.each(msg.result,function(key,value){
            html +="<div class='tourSplit clear'><div class='tourInfo'> <img  src='"+value['litpic']+"'/><h1>"+value['truename']+"</h1><span>"+value['addtime']+"</span></div>";
            html +="<div class='tourImg'><p style='color:#444444;font-size:13px;'><span style='color:#f30'>对线路评论:</span>"+value['content']+"</p><div>";
            if(value['c_pic_arr']!=undefined && value['c_pic_arr'].length>=1){
            	$.each(value['c_pic_arr'],function(k,v){
            	html += "<img src='"+v+"'/>";
            	});
            }
            if(value['expert_content']==null || value['expert_content']==''){
            	value['expert_content'] = '暂无评价';
            }
             html +="<div class='expimg_box'><p><span>对管家的评价:</span>"+value['expert_content']+"</p></div>";
//                                 html +="</div></div><div class='z4'><dl class='publish'><dd class='publish_1'>服务态度："+value['score1']+"</dd><dd class='publish_2'>方案设计： "+value['score2']+"</dd><dd class='publish_2'>服务质量： "+value['score3']+"</dd></dl>";
html +="</div></div><div class='z4'><dl class='publish'><dd class='publish_1'>线路评分：<span style='color:#f30;font-size:15px; margin-right:3px;'>"+value['avgscore1']+"</span>分</dd><dd class='publish_2'>管家评分：<span style='color:#f30;font-size:15px; margin-right:3px;'> "+value['avgscore2']+"</span>分</dd></dl>";
              html +="</div></div>";
     });
}else{
  html += "<div  style='text-align:center;' ><img src='/static/img/page/noer_date.png' style='margin-top:12px;'></div>";
   $("#comment_Pagination").css('display','none');
}
html += '</div></div></li></ul>';
$('#show_comment_record_div_1').html(html);

$(".tourSplit").eq(0).css("border-top","none");
//分页-只初始化一次
if($("#comment_Pagination").html().length == ''){
$("#comment_Pagination").pagination(total, {
'items_per_page'      : pageSize,
'num_display_entries' : 11,
'num_edge_entries'    : 0,
'prev_text'           : "上一页",
'next_text'           : "下一页",
'callback'            : comment_select_page
});
}
});

$(obj).addClass('current');
$("#click_sell_product").removeClass('current');
$("#click_consultation_record").removeClass('current');
$("#click_trans_record").removeClass('current');
$("#click_honor_record").removeClass('current');
$("#click_tour_record").removeClass('current');
$("#click_essay_record").removeClass('current');
}


//个人荣誉
function show_honor_record(obj){
$("#show_honor_record_div").css('display','block');
$("#show_sell_product_div").css('display','none');
$("#show_consultation_record_div").css('display','none');
$("#show_comment_record_div").css('display','none');
$("#show_trans_record_div").css('display','none');
$("#show_tour_record_div").css('display','none');
$("#show_essay_record_div").css('display','none');

$(obj).addClass('current');
$("#click_sell_product").removeClass('current');
$("#click_consultation_record").removeClass('current');
$("#click_comment_record").removeClass('current');
$("#click_trans_record").removeClass('current');
$("#click_tour_record").removeClass('current');
$("#click_essay_record").removeClass('current');
}

//定制记录分页
function tranc_select_page(pageIndex, jq){
$.post('<?php echo base_url()?>expert/expert_detail/get_trans_record',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex+1},
function(msg){
msg = eval('('+msg+')');
var html = '<ul>';
$.each(msg.result,function(key,value){
html += "<li><div class='bg2 b2'><div class='box_service'>";
html += "<div class='z1'><img src='"+value['litpic']+"' alt=''><h1>"+value['truename']+"</h1>&nbsp;&nbsp;&nbsp;"+"<span>"+value['addtime']+"</span>"+
"<a href='<?php echo base_url()?>line/line_custom_detail/index?icd="+value['c_id']+"'><span style='position: relative; padding: 0 60px;display: block;font-size: 14px;margin-top: 15px;margin-left: 10px;min-height:15px;color: blue;'>"+value['question']+"</span></a>"+"</div>";
html +=   "<div class='z2'><ul class='item-fl'><li><label>时间</label><span>"+value['startdate']+"</span></li><li><label>出发地</label><span>"+value['startplace']+"</span></li><li><label>目的地</label><span>"+value['endplace_name']+"</span></li><li><label>人数</label><span>成人"+value['people']+"人</span></li><li><label>预算</label><span>"+value['budget']+"/人</span></li></ul></div>";
html +=  "<div class='z3'><dl><dt>总体描述</dt><dd>"+value['plan_design']+"</dd><dt>方案特色</dt><dd>"+value['plan_feature']+"</dd></dl></div>";
/* html +="<div class='z4'><dl><dd>服务态度："+value['score1']+"</dd><dd>方案设计："+value['score2']+"</dd><dd>服务质量："+value['score3']+"</dd></dl></div>";*/
html += "</div></div></li>";
});
html += '</ul>';
$('#show_trans_record_div_1').html(html);
});
}

//咨询记录分页
function consultation_select_page(pageIndex, jq){

var typeid = $("#search_typeid").val();
$.post('<?php echo base_url()?>expert/expert_detail/get_consultation_record',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex+1,'typeid':typeid},
function(msg){
msg = eval('('+msg+')');
var html = "<div class='bg2'><ul class='consult'>";
$.each(msg.result,function(key,value){
html += "<li>";
if(value['linename']==null || value['linename']==''){
	value['linename']='客人问答';
}
if(value['l_id']!=0 && value['l_id']!=null){
 html +="<a style='color:blue' href='<?php echo base_url()?>line/line_detail_"+value['l_id']+".html'><h1 style='font-size: 20px;'>"+value['linename']+"</h1></a>";
}else{
	 html +="<h1 style='font-size: 20px;'>"+value['linename']+"</h1>";
}

html += "<div class='l1_txt' style='margin-top:20px;'> <i></i><label>咨询内容：</label><p>"+value['content']+"</p></div>";
if(value['replycontent']!=null){
	html +="<div class='l2_txt'><label>管家回复：</label><p>"+value['replycontent']+"</p></div>";
}
html += "</li>";
});
html += '</ul></div>';
$('#show_consultation_record_div_1').html(html);
});
}


//评论分页
function comment_select_page(pageIndex, jq){
$.post('<?php echo base_url()?>expert/expert_detail/get_comment_record',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex+1},
function(msg){
msg = eval('('+msg+')');
var total = msg.total;
    var html = "<ull><li><div class='bg2 b2'><div class='tourList '>";
     $.each(msg.result,function(key,value){
            html +="<div class='tourSplit clear'><div class='tourInfo'> <img  src='"+value['litpic']+"'/><h1>"+value['truename']+"</h1><span>"+value['addtime']+"</span></div>";
            html +="<div class='tourImg'><p style='color:#444444;font-size:13px;'><span style='color:#f30'>对线路评论:</span>"+value['content']+"</p><div>";
            if(value['c_pic_arr']!=undefined && value['c_pic_arr'].length>=1){
            	$.each(value['c_pic_arr'],function(k,v){
            	html += "<img src='"+v+"'/>";
            	});
            }
            if(value['expert_content']==null || value['expert_content']==''){
            	value['expert_content'] = '暂无评价';
            }
            html +="<div class='expimg_box'><p><span>对管家的评价:</span>"+value['expert_content']+"</p></div>";
//                                 html +="</div></div><div class='z4'><dl class='publish'><dd class='publish_1'>服务态度："+value['score1']+"</dd><dd class='publish_2'>方案设计： "+value['score2']+"</dd><dd class='publish_2'>服务质量： "+value['score3']+"</dd></dl>";
            html +="</div></div><div class='z4'><dl class='publish'><dd class='publish_1'>线路评分：<span style='color:#f30;font-size:15px; margin-right:3px;'>"+value['avgscore1']+"</span>分</dd><dd class='publish_2'>管家评分：<span style='color:#f30;font-size:15px; margin-right:3px;'> "+value['avgscore2']+"</span>分</dd></dl>";
             html +="</div></div>";
     });
html += '</div></div></li></ul>';
$('#show_comment_record_div_1').html(html);
$(".tourSplit").eq(0).css("border-top","none");
});


}

function m_online_consultation(obj){

var member_id = $(obj).attr('data-val');
if(member_id!=''){
$(".messages_color,.messages_letter").show();
$(".messages_close").click(function(e) {
$(".messages_color,.messages_letter").hide();
});
}else{
$('.login_box').css("display","block");
}

}

$('#online_consultation').submit(function(){
$.post(
"<?php echo site_url('expert/expert_detail/online_consultation');?>",
$('#online_consultation').serialize(),
function(data)

{
data = eval('('+data+')');
if (data.status == 1) {
	alert(data.msg);
	$("#search_typeid").val('');
	$(".messages_color,.messages_letter").hide();
	show_consultation_record($("#click_consultation_record"));
} else {
	alert(data.msg);
	$("#search_typeid").val('');
	$(".messages_color,.messages_letter").hide();
	show_consultation_record($("#click_consultation_record"));
}
}
);
return false;
});
//个人游记
function show_tour_record(obj){
$("#show_tour_record_div").css('display','block');
$("#show_sell_product_div").css('display','none');
$("#show_consultation_record_div").css('display','none');
$("#show_comment_record_div").css('display','none');
$("#show_trans_record_div").css('display','none');
$("#show_honor_record_div").css('display','none');
$("#show_essay_record_div").css('display','none');

$(obj).addClass('current');
$("#click_sell_product").removeClass('current');
$("#click_consultation_record").removeClass('current');
$("#click_comment_record").removeClass('current');
$("#click_trans_record").removeClass('current');
$("#click_honor_record").removeClass('current');
$("#click_essay_record").removeClass('current');
var scroll_page = 2;
$(window).scroll( function() {
totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop());     //浏览器的高度加上滚动条的高度
if ($(document).height() <= totalheight)     //当文档的高度小于或者等于总的高度的时候，开始动态加载数据
{
$("#more_span").html("<img src='<?php echo base_url('static/img/load_2.gif')?>'/>");
$.post("<?php echo base_url()?>expert/expert_detail/expert_travels",{"expertid":<?php echo $expertid?>,"scroll_page":scroll_page},function(data){
data = eval('('+data+')');

        var str = "";
        $.each(data.result,function(key,val){
               str += "<div class='tour_list_1 clear'>";
               str += "<div class='tour_list_fl'>";

               str += "<a href='<?php echo base_url()?>yj/"+val['nid']+"-1'>";
               str += "<img src='"+val['tn_pic']+"'>";
               str += " </a></div>";
               str+= "<div class='tour_list_fr'><p class='list_fr_title'><a href='<?php echo base_url()?>yj/"+val['nid']+"-1'>"+val['title']+"</p>";
               str+= "<div class='list_fr_xq'><div class='list_fr_time'><span>"+val['addtime']+"</span></div>";
               str+= "<p class='praise'><i></i><span>"+val['praise_count']+"</span></p>";
               str+= "<p class='add'><i></i><span>"+val['comment_count']+"</span></p>";
               /*str+= "<div class='list_fr_nr'><p><span>"+val['content']+"</span></p></div>";*/
               str+= "</div></div>";
               str+= "</div>";
        });
if(data.result.length>4){
        //$("#more_span").empty();
        $("#tour_list").append(str);
        window.scrollTo(0,parseFloat($(window).height()/1.5));
        scroll_page++;
    }else if(data.result.length>0 && data.result.length<=4){
        $("#more_span").empty();
        $("#tour_list").append(str);
        $("#more_span").html("<img src='<?php echo base_url('static/img/end_data.png')?>'/>");
        //window.scrollTo(0,parseFloat($(window).height()/1.5));
        scroll_page++;
    }else{
        $("#more_span").html("<img src='<?php echo base_url('static/img/end_data.png')?>'/>");
        //window.scrollTo(0,parseFloat($(window).height()/1.5));
        return false;
    }
});
}
});
}

//我的随笔
function show_essay_record(obj){
$("#show_essay_record_div").css('display','block');
$("#show_tour_record_div").css('display','none');
$("#show_sell_product_div").css('display','none');
$("#show_consultation_record_div").css('display','none');
$("#show_comment_record_div").css('display','none');
$("#show_trans_record_div").css('display','none');
$("#show_honor_record_div").css('display','none');
$.post('<?php echo base_url()?>expert/expert_detail/expert_travel_note',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex},
function(msg){
msg = eval('('+msg+')');
var total = msg.total;
var html = "";
if(total!=0){
        $.each(msg.result,function(key,value){
        	html += "<li>";
        	html += "<p class='essay_title'>"+value['es_content']+"</p><div class='essay_img'>";
        	if(value['e_pic_arr']){
        		$.each(value['e_pic_arr'],function(k,v){
        		html +="<img src='"+v+"'>";
        	});
        	}

        	html += "</div><div class='clear'><span class='essay_time fl'>"+value['ee_addtime']+"</span><span class='zan_num fr'><i onclick='praise(this)' data-val='<?php echo $this->session->userdata('c_userid');?>|"+value['es_id']+"'></i><em>"+value['praise_count']+"</em></span></div>";
        	html += "</li>";
     });
}else{
  html += "<div  style='text-align:center;' ><img src='/static/img/page/noer_date.png' style='margin-top:12px;'></div>";
   $("#essay_pagination").css('display','none');
}
$('#essay_list').html(html);
//分页-只初始化一次
if($("#essay_pagination").html().length == ''){
$("#essay_pagination").pagination(total, {
'items_per_page'      : pageSize,
'num_display_entries' : 11,
'num_edge_entries'    : 0,
'prev_text'           : "上一页",
'next_text'           : "下一页",
'callback'            : note_select_page
});
}
});

$(obj).addClass('current');
$("#click_tour_record").removeClass('current');
$("#click_sell_product").removeClass('current');
$("#click_consultation_record").removeClass('current');
$("#click_comment_record").removeClass('current');
$("#click_trans_record").removeClass('current');
$("#click_honor_record").removeClass('current');
}

//随笔分页
function note_select_page(pageIndex, jq){
$.post('<?php echo base_url()?>expert/expert_detail/expert_travel_note',
{"expertid":<?php echo $expertid?>,"pageSize":pageSize,'pageIndex':pageIndex+1},
function(msg){
msg = eval('('+msg+')');
var html = "";
$.each(msg.result,function(key,value){
 html += "<li>";
 html += "<p class='essay_title'>"+value['es_content']+"</p><div class='essay_img'>";
  if(value['e_pic_arr']){
        		$.each(value['e_pic_arr'],function(k,v){
        		html +="<img src='"+v+"'>";
    			 });
     }
    html += "</div><div class='clear'><span class='essay_time fl'>"+value['ee_addtime']+"</span><span class='zan_num fr'><i onclick='praise(this)' data-val='<?php echo $this->session->userdata('c_userid');?>|"+value['es_id']+"'></i><em>"+value['praise_count']+"</em></span></div>";
    html += "</li>";
 });

$('#essay_list').html(html);
});
}


//收藏或者取消收藏专家
function collect_expert(obj){
//这个对应三个值,分别是 账户ID,是否有收藏(0,1),线路ID
var expert_info = $(obj).attr('data-val').split('|');
if(expert_info[0]==''){  //收藏操作之前必须要先登录
/*alert('请先登录!');
location.href="<?php echo base_url('login')?>";*/
$('.login_box').css("display","block");
}else{
if(expert_info[1]==0){//如果没有收藏过,就要添加收藏
$.post("<?php echo base_url('expert/expert_detail/add_cancle_expert')?>",
{'c_member_id':expert_info[0],'collect_count':expert_info[1],'expert_id':expert_info[2]},
function(data){
data = eval('('+data+')');
if(data.status==200){
expert_info[1]=1;
$(obj).attr('data-val',expert_info.join("|"));
alert('收藏成功');
$('.shoucang_img').css('background','url(../../static/img/shoucang2.png)');
}else if(data.status==400){
$('.login_box').css("display","block");
}
});
}else{ //如果已经收藏过,就要取消收藏
$.post("<?php echo base_url('expert/expert_detail/add_cancle_expert')?>",
{'c_member_id':expert_info[0],'collect_count':expert_info[1],'expert_id':expert_info[2]},
function(data){
data = eval('('+data+')');
if(data.status==200){
expert_info[1]=0;
$(obj).attr('data-val',expert_info.join("|"));
alert('取消收藏成功');
$('.shoucang_img').css('background','url(../../static/img/shoucang.png)');
}
});
}
}
}



function praise(obj){
var arr = $(obj).attr('data-val').split('|');
//console.log($(obj).next());
if(arr[0]==''){  //收藏操作之前必须要先登录
$('.login_box').css("display","block");
}else{
$.post("<?php echo base_url('expert/expert_detail/click_praise')?>",
{'c_id':arr[0],'eesy_id':arr[1]},
function(data){
	data = eval('('+data+')');
	if(data.status==200){
		alert(data.msg);
		$(obj).next().html(data.praise_count);
	}else{
		alert(data.msg);
	}
});
}
}
$(".kindbar_list ul li").hover(function(){

	$(this).addClass("current");
},function(){
	$(this).removeClass("current");

})

</script>


