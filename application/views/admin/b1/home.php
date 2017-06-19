<?php
$set_url= $this->uri->segment (3, 0);
$set_url0= $this->uri->segment (4, 0);
$mess=$this->session->userdata('mess');
$memuArr[0]['name']='产品管理';
$memuArr[0]['data']=array(
    array(site_url('admin/b1/product'),'产品汇总','product'),
    array(site_url('admin/b1/product_insert/destination'),'添加产品','product_insert'),
    array(site_url('admin/b1/group_line'),'定制团','group_line'),
    array(site_url('admin/b1/group_line_insert/destination'),'添加定制团','group_line_insert'),
    array(site_url('admin/b1/gift_manage'),'礼品管理','gift_manage'),
    array(site_url('admin/b1/line_review'),'线路点评','line_review'),
    array(site_url('admin/b1/travel_notes'),'线路游记','travel_notes'),
);

$memuArr[1]['name']='管家管理';
$memuArr[1]['data']=array(
        array(site_url('admin/b1/app_line'),'售卖管家','app_line'),
    array(site_url('admin/b1/expert_upgrade'),'管家升级','expert_upgrade'),
    array(site_url('admin/b1/directly_expert'),'直属管家','directly_expert'),
);

$memuArr[2]['name']='操作中心';
$memuArr[2]['data']=array(
        array(site_url('admin/b1/order'),'订单管理','order'),
        array(site_url('admin/b1/order_date'),'订单转团','order_date'),
    array(site_url('admin/b1/order_price'),'价格申请','order_price'),
    array(site_url('admin/b1/enquiry_order'),'回复询价','enquiry_order'),
    array(site_url('admin/b1/apply/apply_order'),'付款申请','apply_order'),
    array(site_url('admin/b1/apply/apply_order_log'),'付款申请记录','apply_order_log'),
    array(site_url('admin/b1/credit/credit_limit'),'额度审批','credit_limit'),
    array(site_url('admin/b1/credit/return_limit'),'额度还款查询','return_limit'),
);

$memuArr[3]['name']='结算管理';
$memuArr[3]['data']=array(
    array(site_url('admin/b1/account'),'C端结算','account'),
);

$memuArr[4]['name']='基础设置';
$memuArr[4]['data']=array(
    array(site_url('admin/b1/sxiu'),'我的场景秀','sxiu'),
    array(site_url('admin/b1/user_line'),' 投诉维权','user_line'),
    array(site_url('admin/b1/bank'),'开户银行','bank'),
    array(site_url('admin/b1/user_aq'),'安全中心','user_aq'),
    array(site_url('admin/b1/opportunity'),'培训公告','opportunity'),
    array(site_url('admin/b1/user'),'资料修改','user'),
);
if($mess['sum_msg']!=0){
    array_push($memuArr[4]['data'],array(site_url('admin/b1/messages'),'消息通知'."  <span style='color:#FF0000'>(".$mess['sum_msg'].")</span>",'messages'));
}else{
    array_push($memuArr[4]['data'],array(site_url('admin/b1/messages'),'消息通知','messages'));
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
    <title>供应商管理系统</title>
    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- 声明某些双核浏览器使用webkit进行渲染 -->

    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >

<!--     <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png');?>" type="image/x-icon"> -->
    <link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
    <!--Basic Styles-->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/weather-icons.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/hm.widget.css');?>" rel="stylesheet" />
    
    <link type="text/css" href="<?php echo base_url('assets/css/turn_price_form.css');?>" rel="stylesheet" />
    <!-- 城市选择 -->
     <link href="/assets/js/jQuery-plugin/citylist/city.css" rel="stylesheet" />
    <!--Fonts-->
    <link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet">
    <!-- 多图片上传 -->
    <link href="<?php echo base_url('assets/css/diyUpload.css');?>" rel="stylesheet" />  
    <!--Beyond styles-->
    <link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/demo.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/ht/css/base.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/common.css')?>" rel="stylesheet" />
    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
    <!--Basic Scripts-->
    <script src="<?php echo base_url('assets/js/jquery-1.8.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <!--Beyond Scripts-->
    <script src="<?php echo base_url('assets/js/beyond.min.js');?>"></script>
    <script src="<?php echo base_url('assets/ht/js/layer.js');?>"></script>
    <style type="text/css">
        #top { position:fixed;top:0;left:0;width:100%;z-index: 1000;}
        .main-container { padding-top:60px;}
        #sidebar { overflow-y:auto;overflow-x:hidden;position:fixed;left:0;top:60px;}
        .page-sidebar:before { position:relative;}
           .page-sidebar .menu-dropdown  {
                background-color: #fff;
            }
            .page-sidebar .menu-dropdown  {
                color: #262626;
            }
    </style>
<script type="text/javascript"> 
$(function(){
    var isIE=!!window.ActiveXObject;
    var isIE8=isIE&&!!document.documentMode;
if(navigator.userAgent.indexOf("MSIE")>0){   
      if(navigator.userAgent.indexOf("MSIE 6.0")>0){   
        location.href('/admin/update'); 
      }   
      if(navigator.userAgent.indexOf("MSIE 7.0")>0){  
        location.href('/admin/update'); 
      }   
         
      if(navigator.userAgent.indexOf("MSIE 9.0")>0){  
        
        return false;
      } 
      if(navigator.userAgent.indexOf("MSIE 10.0")>0){  
        
        return false;
      } 
      if(navigator.userAgent.indexOf("MSIE 11.0")>0){  
         
        return false;
      } 
      if(isIE8){//这里是重点，你懂的
        location.href('/admin/update');
      }  
    } 
});

function heightAuto(){
    var top_h = document.getElementById('top').offsetHeight;//头部的高度
    var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
    var w_h = window.innerHeight;// 获取窗口高度
    var w1 = window.innerWidth;// 获取窗口高度
    var Lh = w_h - top_h;//
    var w = w1- 160;
    document.getElementById('main').style.width = w + "px";
    document.getElementById('main').style.minHeight = Lh + "px";
    document.getElementById('left_nav').style.height = "100%";

}

</script>

</head>

<body id="page" onload="heightAuto();" style="background: #f8f8f8;">

<!--  ===========  头部内容  start=============== -->
<div class="navbar" id="top">
        <div class="navbar-inner clear">
            <div class="navbar-header fl">
                <a href="http://bangu.com/admin/t33/home/index" class="navbar-brand" style="padding:0;">
                    <!--<img src="/assets/ht/img/logo.png" /> --><span style="display:block;line-height:60px;width:250px;text-align:center;color:#fff;font-size:26px;">wwww.1b1u.com</span>
                </a>
            </div>
            <div class="header_right fr">
                <!--<div class="user_photo"><img src="http://bangu.com/assets/ht/img/face.png" onclick="change_avatar();"/></div> -->
                <div class="user_info">
                    <p style="line-height:60px;">
                        <span><!--账户名 ：温文斌 -->&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <span class="logout_img" onclick="supplier_loginout();"><img src="<?php echo base_url();?>assets/ht/img/logout.png" title="退出"></span>
                    </p>
    
                </div>
            </div>
        </div>
    </div>
<!--  ===========  头部内容 end =============== -->



<div class="main_container" id="mainBody">
    <!--  ===========  左侧导航 start =============== -->
    <div class="aside nui-scroll" id="left_nav">
        <div id="asideInner" class="aside_inner">
            <div class="mc">
                <dl id="user_nav_1">
                    <dt class="home_link">
                        <i class="mian_page small_ico"></i>
                        <a class="a_url" href="/admin/b1/view">供应商主页</a>
                    </dt>
                    <dd></dd>
                </dl>
                <?php foreach ($memuArr as $key => $value) { ?>
                   <dl class="user_nav">
                        <dt>
                            <i class="small_ico"></i><?php echo $value['name']; ?><b></b>
                        </dt>
                        <dd style="display: none;">
                            <?php  foreach ($value['data'] as $item) { ?>
                            <div class="item">
                                <a href="<?php echo $item[0];?>" target="main"><?php echo $item[1];?></a>
                            </div>
                            <?php } ?>
                            <!-- <div class="item">
                                <a href="http://bangu.com/admin/t33/sys/line/line_list" target="main">产品详情</a>
                            </div> -->
                        </dd>
                    </dl>
                <?php } ?>

            </div>
        </div>
    </div>
    <!--  ===========  左侧导航 end =============== -->

    <!--  ===========  右侧页面 start =============== -->
    <iframe name="main" id="main" src="/admin/b1/view/first_page" class="nui-scroll" frameBorder="0" scrolling="auto"></iframe>
    <!--  ===========  右侧页面 end =============== -->

</div>

<div id="val_box" class="val_box" style="display:none;"></div>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript">
//当浏览器窗口大小改变时，设置显示内容的高度  
window.onresize=function(){ 
    var top_h = document.getElementById('top').offsetHeight;//头部的高度
    var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
    var w_h = window.innerHeight;// 获取窗口高度
    var w1 = window.innerWidth;// 获取窗口高度
    var Lh = w_h - top_h;//
    var w = w1- 160;
    document.getElementById('main').style.width = w + "px";
    document.getElementById('main').style.minHeight = Lh + "px";
    document.getElementById('left_nav').style.height = "100%";
}  

function openWin(settings){
    layer.open(settings);
}
var data;
function passData(){
    /*var val = $("#val_box").html();
    data = val;*/
    //console.log(data); 
     //document.getElementById("main").contentWindow.getValue();
    //$("#main")[0].contentWindow.getValue(); //用jquery调用需要加一个[0]
}

function supplier_loginout(){
    if(confirm('确定要退出吗?')){
        location.href="<?php echo base_url('admin/b1/home/login_out')?>";
    }
}

//左侧导航
    $(".user_nav dt").click(function(){
        
        if ($(this).hasClass("up")) {
            $(this).removeClass("up");
            $(this).siblings().slideUp("fast");
        }else {
            $(".user_nav dt").removeClass("up");
            $(".user_nav dd").slideUp("fast");
            $(this).addClass("up");
            $(this).siblings().slideDown("fast");
        }
    })  
    $(".mc dl dd .item").click(function(){
        $(".mc dl dd .item").removeClass("cur");
        $(this).addClass("cur");
    });
    $("#user_nav_1 dt").click(function(){
        $(".mc dl dd .item").removeClass("cur");
    });
</script>
</body>
</html>