<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<title>会员中心</title>
<style type="text/css">
.close_xiu { top:105px !important;}
</style>
</head>
<body style=" font-size:12px;">
<!--===============头部开始===================== -->


<?php $this->load->view('common/header'); ?>
	<!-- 图片 -->
	<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu">×</div>
<!-- 	<div class="right_box"></div> -->
	</div> 

<div class="zhonxin_mian"> 
    <!--========左面导航========== --> 
<?php $this->load->view('common/user_aside');  ?> 
    <!--========右面导航========== -->
    <div class="zhongxin_right">
        <div class="zhongxin_con"> 
            <!--开始 -->
            <div class="huiya_contop">
                <!-- <div class="touxiang_box"><img src="/images/touxiang.png" /></div> -->
                <div class="fl user_tx">
						<img
							src="<?php if(!empty($member['litpic'])){ echo $member['litpic']; }  ?>"
							alt="" /> <span >
							<a href="javascript:void(0);" onclick="change_avatar();" class="user_tx_xg " >修改头像</a></span>
				</div>
                <div class="youbox">
                    <div class="topcilogin">上次登录时间:<?php if(!empty($c_logintime)){echo $c_logintime;} ?></div>
                    <!--昵称和手机号 -->
                    <ul class="name_phon">
                        <li><span>姓名：</span><i><?php  if(!empty($member['truename'])){echo $member['truename'];} ?></i></li>
                        <li><span>手机号：</span><i><?php  if(!empty($member['mobile'])){echo $member['mobile'];} ?></i></li>
                    </ul>
                    <!--积分 -->
                    <div class="jifen_box">
                    	<div class="jifen_list">可用积<i><?php if(!empty($member['jifen'])){echo $member['jifen'];}else{ echo 0;} ?></i>分</div>
                        <div class="jifen_duihuan"><a href="" target="_blank">积分兑换</a></div>
                        <div class="jifen_list">可用优惠券<i><?php if(!empty($coupon_n)){ echo count($coupon_n);}else{ echo 0;} ?></i>张</div>
                    </div>
                    <!--消息通知 -->
                    <ul class="xiaoxi_box">
                    	<li><a href="/base/customer_service">有<span>(<?php if(!empty($line_answer['num'])){ echo $line_answer['num'];}else{ echo 0;} ?>)</span>位管家回答了您的产品提问</a></li>
                        <li><a href="/base/customer_service">有<span>(<?php if(!empty($expert_answer['num'])){ echo $expert_answer['num'];}else{ echo 0;} ?>)</span>位指定的管家回答了您的问题</a></li>
                        <li><a href="/base/member/mycustom">有<span>(<?php if(!empty($custom_answer['num'])){ echo $custom_answer['num'];}else{ echo 0;} ?>)</span>位管家回答了您的定制信息</a></li>
                        <li><a href="/base/system/message">有<span>(<?php if(!empty($notice_answer['num'])){ echo $notice_answer['num'];}else{ echo 0;} ?>)</span>条消息通知您尚未查看</a></li>
                    </ul>
                </div>
            </div>
            <div class="dingdan_xixi" style="min-height:200px;">
            	<div class="dingdan_title">订单信息</div>
                <div class="xixi_list">
                	<ul>
                    	<li><a href="/order_from/order/line_order/non_pay"><span>已留位</span><?php if(!empty($order['liuwei'])){ echo $order['liuwei'];}else{ echo 0;} ?></a></li>
                        <li><a href="/order_from/order/line_order/non_pay"><span>已确认</span><?php if(!empty($order['queren'])){ echo $order['queren'];}else{ echo 0;} ?></a></li>
                        <li><a href="/order_from/order/line_order"><span>收款拒绝</span><?php if(!empty($order['jujue'])){ echo $order['jujue'];}else{ echo 0;} ?></a></li>
                        <li><a href="/order_from/order/line_order"><span>已退款</span><?php if(!empty($order['tuikuan'])){ echo $order['tuikuan'];}else{ echo 0;} ?></a></li>
                        <li><a href="/order_from/order/line_order"><span>已取消</span><?php if(!empty($order['quxiao'])){ echo $order['quxiao'];}else{ echo 0;} ?></a></li>
                        <li><a href="/base/customer_service/deal_complaint"><span>投诉回复</span><?php if(!empty($order['tousu'])){ echo $order['tousu'];}else{ echo 0;} ?></a></li>
                        <li><a href="/order_from/order/line_order/undone"><span>未评价</span><?php if(!empty($order['pinlun'])){ echo $order['pinlun'];}else{ echo 0;} ?></a></li>
                       <!--  <li><a href="##"><span>未发体验分享</span>15</a></li> -->
                       <!-- <li><a href="##"><span>已被评为体验师</span>15</a></li> --> 
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
     <!-- 新增的弹框 end-->
	<div class='avatar_box'></div>

	<?php $this->load->view('common/footer'); ?>
</body>
</html>
<script type="text/javascript">
	$(function(){
		//左面nav切换
		$(".click_nav").click(function(){
			$(this).siblings(".huiyuan_hidden").slideToggle(200);
		})
		$(".xiaoxi_box li").hover(function(){
			$(this).addClass("xiaoxi_hover")
			$(this).find("span").addClass("xiaoxi_hover")		
		},function(){
			$(this).removeClass("xiaoxi_hover")
			$(this).find("span").removeClass("xiaoxi_hover")	
			})
	})
	//修改图片
	function change_avatar(){ 
			$('.avatar_box').show();
			xiuxiu.setLaunchVars("cropPresets", "300x300");
		   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
			xiuxiu.embedSWF("altContent",5,'100%','100%');
		       //修改为您自己的图片上传接口
			xiuxiu.setUploadURL("<?php echo site_url('admin/upload/c_upload_file'); ?>");
		        xiuxiu.setUploadType(2);
		        xiuxiu.setUploadDataFieldName("upload_file");
			xiuxiu.onInit = function ()
			{
				//默认图片
				xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
			}
			xiuxiu.onUploadResponse = function (data)
			{
				data = eval('('+data+')');
				if (data.status == 1) {
					alert(data.msg);
					location.reload();
				} else {
					alert(data.msg);
				}
			}
			 $("#img_upload").show();
			 $('.close_xiu').show();
	}
	$(document).mouseup(function(e) {
        var _con = $('#img_upload'); // 设置目标区域
        if (!_con.is(e.target) && _con.has(e.target).length === 0) {
            $("#img_upload").hide()
            $('.avatar_box').hide();
            $('.close_xiu').hide();
        }
    })
     $('.close_xiu').click(function(){
    	 $("#img_upload").hide()
         $('.avatar_box').hide();
         $('.close_xiu').hide();
    })
</script>
