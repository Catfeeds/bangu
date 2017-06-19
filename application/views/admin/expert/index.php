<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />

<title>管家管理系统</title>
<style type="text/css">
	/*========================  右侧悬浮  返回顶部  ===============================*/
ul { list-style:none;}
.return_top { display:block;position:fixed;bottom: 60px; right:0; width: 40px; height:85px; z-index:9999;}
.return_top ul li { width:40px;height:40px;background:#09c;margin-bottom:5px;}
.return_top ul li a { width:40px;height:40px;position:relative;display:block;top:0px;left:0px;text-align:center;}
.return_top i{ width:30px;height:15px;background:url(<?php echo base_url('static'); ?>/img/return_top_ico.png) 0 0 no-repeat;position:absolute;top:12px;left:5px;}
.kefu_link .kefu_logo { width:35px;height:30px;position:relative;left:-1px;top:5px;}
.return_top ul li:hover { filter:alpha(opacity=70); /*IE滤镜，透明度60%*/-moz-opacity:0.7; /*Firefox私有，透明度60%*/opacity:0.7;/*其他，透明度60%*/}
.kefu_message { position:absolute;left:40px;top:-15px;width:    20px;height:16px;display:none;}

.kefu_ico { display:none;}

#msg_title { display:none;position:fixed;left:0;top:0;background:rgba(0,0,0,0.7);width:100%;height:100%; z-index: 9999;}
#msg_title .msg_content { width:300px;height:200px;border:1px solid #2dc3e8;background:#fff;position:absolute;left:50%;top:50%;margin-left:-150px;margin-top:-100px;border-radius:4px;}
#msg_title .msg_content .title { background:#2dc3e8;color:#fff;height:30px;line-height:30px;font-size:15px;padding-left:10px;font-weight: bold;}
#msg_title .msg_content p { height:50px;line-height:50px;font-size:14px;text-align:center;margin-top:30px;}
#msg_title .msg_content div span { display:block;width:80px;text-align:center;height:30px;line-height:30px;border-radius:3px;cursor:pointer;margin-top:25px;}
#msg_title .msg_content div span:hover { filter:alpha(opacity=70);-moz-opacity:0.7; opacity:0.7;}
.link_url { margin-left:40px;background:#2dc3e8;}
.link_url a { color:#fff;}
.later_handle { margin-right:40px;background:#ddd;}
.user_nav dd{display:none;}
.HcloseBtn{ float: right; width: 200px; height: 40px;}
.HcloseBtn img{ width: 36px; height: 36px; line-height: 36px; margin-top: 5px;}
.Hmatter{float: right;border-left:1px solid #0087b4; cursor: pointer;height:40px;line-height:40px;}
.Hmatter i{ float: left; margin-top: 5px; margin-left: 10px; display: inline-block; width: 20px; height: 28px; background: url(../../../../assets/img/lingdang.png) no-repeat; background-position: 0px 0px; background-size: cover;}
.Hmatter span{ float: left; background: #f90; width: 30px; height: 20px; color: #fff; margin:10px 14px; margin-left: 8px; text-align: center; line-height: 19px; border-radius: 4px;}
.header_right{ padding: 0;}
.userOname{ cursor: pointer; height: 40px; line-height: 40px; font-size: 14px; text-align: center; border-left:1px solid #0087b4; border-right:1px solid #0087b4; color: #fff;}
.userMune{ background: #fff; display: none;}
.userMune li{ height: 40px; line-height: 40px; text-align: center; border: 1px solid #eaedf1; border-top:none;}
.userMune li a{ color: #666; font-size: 13px; display: block;}
.userMune li:hover{background: #eaedf1;}
.userOn{ background: #0087b4; box-shadow: 0 1px 3px rgba(0,0,0,0.1);}
.HmatterHidden{ display: none; width: 400px; position: absolute; top: 40px; right: 0; height: auto; background: #fff; border: 1px solid #eaedf1;}
.HmatTitle{ height: 40px; line-height: 40px; background: #eaedf1;border: 1px solid #eaedf1; box-shadow: 0 1px 2px rgba(0,0,0,0.175); padding-left: 10px; font-size: 13px; color: #666;}
.Hmatleft{ width: 300px; line-height: 24px;float: left;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; padding: 5px 10px;}
.Hmatleft a{overflow: hidden;white-space: nowrap;text-overflow: ellipsis; display:block; width:100%;}
.Hmatleft span{ color: #666; float: left; background: #fff; margin: 3px 0px;width: auto;}
.Hmatright{ float: right; margin-right: 5px;}
.Hmatright input{ margin-top: 16px; padding: 5px 8px; border-radius: 2px; background: #eaedf1; cursor: pointer; font-family: "微软雅黑";}
.HmatListy li{ border-bottom: 1px solid  #eaedf1; overflow: hidden; width:100%;}
.Hmatr_more{ width: 100%; text-align: center; height: 50px;line-height: 50px;}
.Hmatr_more a{  display: block;width: 100%;height: 100%;}
.hamerr{ height:40px;}
.closeThiss{ float:right !important; background:#fff !important;border:1px solid #999; color:#666 !important; padding:2px 5px;}
#main { width: 100%; padding-left: 160px;box-sizing:border-box;}
</style>
   
</head>

<body id="page">
<!--  ===========  头部内容  start=============== -->
<div class="navbar" id="top">
    <div class="navbar-inner clear">
        <div class="navbar-header fl">
            <a href="<?php echo base_url()?>" class="navbar-brand">
                <!--<img src="<?php echo base_url();?>assets/img/logo.png" />-->
               	帮游管家管理系统
            </a>
        </div>
        <div class="header_right fr">
            <div class="HcloseBtn uklist clickthis" onclick="show_change(this)" >
            	<!--<img src="<?php echo base_url() ;?>assets/ht/img/logout.png"/>-->
            	<div class="userOname"><?php echo $this->session->userdata('nickname').(!empty($expert_info['depart_name']) ? '('.$expert_info['depart_name'].')' : '()')?></div>
                <ul class="userMune change-status">
                    <li><a href="#" onclick="online_status(this)" data-val="2">在线</a></li>
                    <li>
                        <a href="javascript:void(0);" onclick="online_status(this)" data-val="1">挂牌</a>
                    </li>
                    <li><a href="javascript:void(0);" onclick="online_status(this)" data-val="0">退出</a></li>
                </ul>
            </div>
            <div class="Hmatter uklist clickthis">
            	<div class="hamerr"><i></i><span><?php if(!empty($statis_msg['sum_msgess'])){echo $statis_msg['sum_msgess'];}else{ echo 0;}?></span></div>
            	<?php if (!empty($statis_msg['msg_arr'])):?>
            	<div class="HmatterHidden thisshow">
	            	<div class="HmatTitle">站内消息通知<span class="closeThiss">关闭</span></div>
	            	<ul class="HmatListy">
	            		<?php foreach($statis_msg['msg_arr'] as $key=>$val):?>
	            		<li>
		            		<div class="Hmatleft">
		            			<a href="#"><?php echo $val['content']?></a>
		            			<span><?php echo $val['addtime']?></span>
		            		</div>

		            		<div class="Hmatright">
		            			<input type="button" class="see-msg-but" data-val="<?php echo $val['id']?>" value="查看消息" />
		            		</div>
	            		</li>
						<?php endforeach;?>

	            	</ul>
	            	<div class="Hmatr_more">
	            		<a href="/msg/t33_msg_list/msg_list?expertid=<?php echo $this->session->userdata('expert_id')?>" target="main">查看全部</a>
	            	</div>
	            </div>
	            <?php endif;?>
            </div>

        </div>
    </div>
</div>

<!--  ===========  头部内容 end =============== -->

<div class="main_container" id="mainBody">
	<!--  ===========  左侧导航 start =============== -->
    <div class="aside" id="left_nav" style="height:100%;">
        <div id="asideInner" class="aside_inner nui-scroll" style="height:100%;width:100%;">
            <div class="mc">
                <dl id="user_nav_1">
                    <dt class="home_link">
                        <i class="mian_page small_ico"></i>
                        <a class="a_url" href="<?php echo site_url('admin/b2/home')?>" target="main">主页</a>
                    </dt>
                    <dd></dd>
                </dl>
                  <?php
                    $is_manage=$this->session->userdata('is_manage');
                    $expert_id = $this ->session ->userdata('expert_id');
                    $e_status=$this->session->userdata('e_status');
                    $is_commit = $this ->session ->userdata('is_commit');
                    $union_status = $this ->session ->userdata('union_status');
                    if($is_manage==1 && $union_status=1){
                ?>
                <dl style="" class="user_nav">
                    <dt>
                        <i class="small_ico"></i><a>同行销售中心<b></b></a>
                    </dt>
                    <dd>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/pre_order/index')?>" target="main">产品预订</a>
                        </div>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/reserve/index')?>" target="main">单项预订</a>
                        </div>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/group_line/index')?>" target="main">定制线路预订</a>
                        </div>
                         <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/order_manage/index')?>" target="main">我的订单</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/pay_manage/index')?>" target="main">交款管理</a>
                        </div>
                        <div class="item" >
                             <a href="<?php echo site_url('admin/b2/change_approval/index')?>" target="main">改价/退团审批</a>
                        </div>

                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/credit_approval/index')?>" target="main">额度申请</a>
                        </div>

                        <!--<div class="item" >
                            <a href="###" target="main">结算申请</a>
                        </div>-->

                         <div class="item" >
                            <a href="<?php echo site_url('admin/b2/credit_record/index')?>" target="main">额度使用明细</a>
                        </div>
						<div class="item" >
                            <a href="<?php echo site_url('admin/b2/contract/index')?>" target="main">合同签署</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('msg/t33_msg_list/msg_list?expertid='.$expert_id)?>" target="main">业务通知</a>
                        </div>
                    </dd>
                </dl>
                <?php }else if($is_manage==0 && $union_status=1){?>
                    <dl style="" class="user_nav">
                     <dt>
                        <i class="small_ico"></i><a>同行销售中心<b></b></a>
                    </dt>
                     <dd>
                    <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/pre_order/index')?>" target="main">产品预订</a>
                        </div>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/reserve/index')?>" target="main">单项预订</a>
                        </div>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/group_line/index')?>" target="main">定制线路预订</a>
                        </div>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/order_manage/index')?>" target="main">我的订单</a>
                        </div>
                         <div class="item" >
                            <a href="<?php echo site_url('admin/b2/credit_approval/index')?>" target="main">额度申请</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/contract/index')?>" target="main">合同签署</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('msg/t33_msg_list/msg_list?expertid='.$expert_id)?>" target="main">业务通知</a>
                        </div>
                        </dd>
                            </dl>
                    <?php }?>
                    <?php if($e_status==2){?>
                <dl style="" class="user_nav">
                    <dt>
                        <i class="small_ico"></i><a>帮游业务平台<b></b></a>
                    </dt>
                    <dd>
                        <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/order/index')?>" target="main">我的订单</a>
                        </div>
                         <div class="item"  >
                            <a href="<?php echo site_url('admin/b2/change_price_record/index')?>" target="main">价格申请</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/line_package/index')?>" target="main">定制线路</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('/admin/b2/line_apply/index')?>" target="main">申请产品</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/grab_custom_order/index')?>" target="main">定制抢单</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/inquiry_sheet/index')?>" target="main">询价供应商</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/refund/index')?>" target="main">退款申请</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/expert/account')?>" target="main">我的账户</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/exiu')?>" target="main">我的场景秀</a>
                        </div>
                    </dd>
                </dl>
                <dl style="" class="user_nav">
                    <dt>
                        <i class="small_ico"></i><a>客户管理<b style="margin-left:78px;"></b></a>
                    </dt>
                    <dd>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/expert/customer')?>" target="main">我的客户</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/complain/index')?>" target="main">投诉维权</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/comment/index')?>" target="main">客人点评</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/question/index')?>" target="main">客人问答</a>
                        </div>
                        <div class="item" >
                            <a href="<?php echo site_url('admin/b2/expert_service/index')?>" target="main">上门服务</a>
                        </div>
                    </dd>
                </dl>
                 <?php }?>
                <dl style="" class="user_nav">
                    <dt>
                        <i class="small_ico"></i><a>个人设置<b style="margin-left:78px;"></b></a>
                    </dt>
                    <dd>
                       <!--  <div class="item">
                            <a href="<?php echo site_url('admin/b2/message/index')?>" target="main">消息通知</a>
                        </div> -->
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/essay/index')?>" target="main">海外代购</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/travel/index')?>" target="main">个人游记</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/opportunity/index')?>" target="main">学习机会</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/upgrade/index')?>" target="main">管家升级</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/expert/update')?>" target="main">个人主页</a>
                        </div>
                         <div class="item">
                            <a href="<?php echo site_url('admin/b2/personal_page/index')?>" target="main">基本资料</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/expert/security')?>" target="main">安全中心</a>
                        </div>
                        <div class="item">
                            <a href="<?php echo site_url('admin/b2/expert/template')?>" target="main">个性模板</a>
                        </div>
                    </dd>
                </dl>
			     <dl style="" class="user_nav">
	                    <dt>
	                        <i class="small_ico"></i><a href="<?php echo site_url('admin/b2/message/index')?>" target="main" >消息通知
	                        <span class="news_num" style="display:<?php if($statis_msg['sum_msg']!=0){ echo "inline-block";}else{ echo "none";}?>;" >(<?php echo $statis_msg['sum_msg'];?>)</span> 
	                        </a>
	                    </dt>
			 	</dl>

            </div>
        </div>
        <div class="right_ico"><span onclick="show_left_nav(this);"><i></i></span></div>
    </div>
    <!--  ===========  左侧导航 end =============== -->

	<!--  ===========  右侧页面 start =============== -->
	<iframe name="main" id="main" src="<?php echo base_url('admin/b2/home');?>" class="nui-scroll" frameBorder="0" scrolling="auto"></iframe>
	<!--  ===========  右侧页面 end =============== -->

<!-- 右侧返回顶部 -->
    <div class="return_top">
        <ul>
            <li><a href="<?php $expert_id=$this->session->userdata('expert_id'); echo $web_config['expert_question_url'].'/kefu_expert.html?eid='.$expert_id; ?>" title="我的客户" class="kefu_link" target="_blank"><img class="kefu_logo" src="<?php echo base_url('static'); ?>/img/kefu_ico.png"/><img class="kefu_message" src="<?php echo base_url('assets'); ?>/img/kefu_msg.gif"/></a></li>
            <li><a href="#" title="返回顶部" class="return_top"><i></i></a></li>
        </ul>
    </div>

</div>

<!--  ===========  美图秀秀  =============== -->
<div id="altContent"></div>
<div class="close_xiu" style="">X</div>
<div class='avatar_box'></div>

<!--====================消息提示框===================== -->
<div id="msg_title" status="0">
    <div class="msg_content">
        <div class="title">您有新的消息！</div>
        <p>您有新的客人咨询，请及时跟进处理。</p>
        <div class="clear">
            <span class="link_url fl"><a href="<?php $expert_id=$this->session->userdata('expert_id'); echo $web_config['expert_question_url'].'/kefu_expert.html?eid='.$expert_id; ?>">立即处理</a></span>
            <span class="later_handle fr" onclick="close_msg();">暂缓处理</span>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script type="text/javascript">
$('.see-msg-but').click(function(){

	window.top.openWin({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'消息详细',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('msg/t33_msg_list/detail');?>"+"?id="+$(this).attr('data-val')
	});

})

$(function(){
	iFrameHeight() ;
})
//左侧导航收放
function show_left_nav(obj){
	if($(obj).hasClass("on")){
		$(".aside").animate({width:"160px"},200);
		$("#asideInner").animate({width:"160px"},200);
		$("#asideInner").css("overflow-y","auto");
		$("#main").css("padding-left","160px");
		$(obj).removeClass("on");
	}else{
		$(".aside").animate({width:"10px"},200);
		$("#asideInner").animate({width:"0px"},200);
		$("#asideInner").css("overflow-y","hidden");
		var x = $("#main").css("padding-left");
		$("#main").css("padding-left","10px");
		$(obj).addClass("on");
	}
}
function iFrameHeight() {
		var top_h = document.getElementById('top').offsetHeight;//头部的高度
		var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
		//var w_h = $(window).height();
		var w_h = document.documentElement.clientHeight;// 获取窗口高度
		var Lh = w_h - top_h;
		document.getElementById('main').style.minHeight = Lh + "px";

	}
function openWin(settings){
	var idx = layer.open(settings);
	if(settings.full==true){
		layer.full(idx);
	}
}
//当浏览器窗口大小改变时，设置显示内容的高度
window.onresize=function(){
	var top_h = document.getElementById('top').offsetHeight;//头部的高度
	var left_h = document.getElementById('asideInner').offsetHeight;//左侧导航实际高度
	//var w_h = $(window).height();
	var w_h = document.documentElement.clientHeight;// 获取窗口高度
	var Lh = w_h - top_h;//
	document.getElementById('main').style.minHeight = Lh + "px";
	/*if(Lh>=left_h){
		document.getElementById('left_nav').style.height = left_h + "px";
	}else{
		document.getElementById('left_nav').style.height = Lh + "px";
	}*/
}


function expert_loginout(){
	if(confirm('确定要退出吗?')){
		location.href="<?php echo site_url('admin/b2/login/logout')?>";
	}
}


	var foo=true;
	$(".choose_static").click(function(){
		if(foo){
			$(this).find('ul').show();
			foo=false;
		}else{
			$(this).find('ul').hide();
			foo=true;
		}
	});
	$(document).mouseup(function(e){
		var _con = $('.change-status');   // 设置目标区域
		if(!_con.is(e.target) && _con.has(e.target).length === 0){
			$(".change-status").hide();
			foo = true;
		}
	});
	function show_change() {
		$('.change-status').show();
	}

	function online_status(obj){
		var online_status = $(obj).attr('data-val');
		var send_url="<?php echo $web_config['expert_question_url'].'/chat!updateExpertStatus.do'?>" ;
		if(online_status==0){

			if(confirm('确定要退出吗?')){
                $.ajax({
                          url : send_url,
                          dataType:"jsonp",
                          type : 'POST',
                          data : {
                              'expert_id' : <?php echo $this->session->userdata('expert_id')?>,
                              'newStatus':online_status
                          },
                          success : function(jsonData) {
                              location.href="<?php echo site_url('admin/b2/login/logout')?>";
                          }
                      });
                  }
			
			
		}else{
			$.ajax({
						url : send_url,
						dataType:"jsonp",
						type : 'POST',
						data : {
							'expert_id' : <?php echo $this->session->userdata('expert_id')?>,
							'newStatus':online_status
						},
						success : function(jsonData) {
							$("#online_txt").html($(obj).html());
							$('.change-status').hide();
						}
					});
		}

	}

	function addEvent(obj,type,fn){
	    if(obj.attachEvent){
	        obj.attachEvent('on'+type,function(){
	            fn.call(obj);
	        })
	    }else{
	        obj.addEventListener(type,fn,false);
	    }
	}

	$(".return_top").css("display","block");
    function alert_unread_message(){
        $.post("<?php echo base_url('admin/b2/home/get_unread_bus_msg')?>",
                {'minutes':1},
                function(data){
                    data = eval('('+data+')');
                    if(data>=1){
                        $.messager.lays(300, 200);
                        $.messager.show(0, "<a href='<?php echo base_url('admin/b2/message/index');?>'>你有未读新消息</a>",300000);
                    }
                });

    }

    /***
    *
    * 根据管家ID 获取最新未读人数.
    *
    * */
    function getNewMsg(){
        var send_url="<?php echo $web_config['expert_question_url'].'/chat!getMsgCount.do'?>" ;
            $.ajax({
                url : send_url,
                dataType:"jsonp",
                type : 'POST',
                data : {
                    'expert_id' : <?php echo $this->session->userdata('expert_id')?>,
                    'action':1
                },
                success : function(jsonData) {
                    if (jsonData.code == '2000') {//成功
                        if(jsonData.data >0){//有新消息
                            //显示泡泡
		var status = $("#msg_title").attr("status");
		if(status==0){
			$("#msg_title").show();
		}
                        $(".kefu_message").show();
                        }else{
                            //隐藏泡泡
                             $(".kefu_message").hide();
                        }
                    } else {
                    }
                }
            });

    }

	//关闭消息提示框
	function close_msg(){
		$("#msg_title").attr("status","1").hide();
	}

//头部修改头像
function change_avatar(){
	$('.avatar_box').show();
	xiuxiu.setLaunchVars("cropPresets", '360x360');
	/*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	xiuxiu.embedSWF("altContent",5,'100%','100%');
	   //修改为您自己的图片上传接口
	xiuxiu.setUploadURL("<?php echo site_url('admin/upload/b2_upload_photo'); ?>");
		xiuxiu.setUploadType(2);
		xiuxiu.setUploadDataFieldName("upload_file");
	xiuxiu.onInit = function ()
	{
		//默认图片
		xiuxiu.loadPhoto("/assets/img/default_photo.png");
	}
	xiuxiu.onUploadResponse = function (data)
	{
		data = eval('('+data+')');
		if (data.code == 2000) {
			$('input[name="big_photo"]').val(data.msg);
			window.location.reload();
		} else {
			alert(data.msg);
		}
	}

	$("#xiuxiuEditor").show().css({'top':'-60px','left':'20px'});
	$('.close_xiu').show();
}
$(document).mouseup(function(e) {
	var _con = $('#xiuxiuEditor'); // 设置目标区域
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		$("#xiuxiuEditor").hide()
		$('.avatar_box').hide();
		$('.close_xiu').hide();
	}
})
$('.close_xiu').click(function(){
	 $("#xiuxiuEditor").hide()
	 $('.avatar_box').hide();
	 $('.close_xiu').hide();
})

</script>

<script>
// $(document).click(function(e){
// 	  var no_con = $('.header_right'); // 设置目标区域
//           if (!no_con.is(e.target) && no_con.has(e.target).length === 0) {
// 			$(".thisshow").hide();

//           }
// })

$('.Hmatr_more').find('a').click(function(){
	$(".uklist").removeClass("userOn");
	$(".uklist").find(".thisshow").hide();

	//更改左侧导航
	var navObj = $('.user_nav');
	navObj.eq(0).find('dd').show();
	navObj.find('dd').find('.item').removeClass('cur');
	navObj.eq(0).find('.item').each(function(){
		if ($(this).find('a').text() == '业务通知') {
			$(this).addClass('cur');
		}
	})
})

$(".hamerr").click(function(){
	if($(this).parent().hasClass("userOn")){
		$(this).parent().removeClass("userOn");
		$(this).parent().find(".thisshow").hide();
	}else{
		$(".clickthis").find(".thisshow").hide();
		$(".clickthis").removeClass("userOn");
		$(this).parent().addClass("userOn");
		$(this).parent().find(".thisshow").show();
	}
})
$(".closeThiss").click(function(){
	$(".uklist").removeClass("userOn");
	$(".uklist").find(".thisshow").hide();
})



// $(window.frames["main"].document).click(function(){
// 	alert(1)
// })
</script>

</body>
</html>