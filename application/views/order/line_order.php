<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <title><?php echo $web['title']?></title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" /> -->
<title>会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<!--<link href="<?php echo base_url('static'); ?>/css/line_detail.css" rel="stylesheet" type="text/css" /> -->
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<style>
.title_info_txt1,.title_info_txt2,.tset_1,.tset_2{ display:none;}
#rt_rt_1a5vrdt1p1dok105afeo1hhl1n1{ width:80px !important; height:30px !important;}
#as2 div:last-child{width:90px !important; height:24px !important; margin-top:10px !important; margin-left:5px !important;}
.webuploader-pick{ width:102px; margin-left:0px; z-index:1000;}
.parentFileBox{ top:45px; height:80px; left:5px;}
.parentFileBox>.fileBoxUl{ top:0px;}
.parentFileBox>.diyButton>a{ padding:3px 6px 3px 6px} 
.parentFileBox>.diyButton{ position:absolute; top:0px;}
.diyStart{ top:0}
.diyCancelAll{ top:35px;}
</style>
</head>
<body>
<!-- 头部 -->

	<?php $this->load->view('common/header'); ?>
	<!-- 图片 -->
	<div id="img_upload">
		<div id="altContent"></div>
		<div class="close_xiu">×</div>
	</div>
	<div id="user-wrapper">
		<div class="order_container clear">
			<!--左侧菜单开始-->
			<?php $this->load->view('common/user_aside');  ?>
			<!--左侧菜单结束-->
			<!-- 右侧菜单开始 -->
			<div class="nav_right">
				<div class="user_title">会员中心</div>
				<div class="huiya_contop" style="padding:0;">
					<div class="fl user_tx">
						<img src="<?php if(!empty($member['litpic'])){ echo $member['litpic']; }  ?>" alt="" />
						<span><a href="javascript:void(0);" onclick="change_avatar();" class="user_tx_xg " >修改头像</a></span>
					</div>
					<div class="youbox">
						<div class="topcilogin">上次登录时间:<?php if(!empty($c_logintime)){echo $c_logintime;} ?></div>
						<!--昵称和手机号 -->
						<ul class="name_phon">
							<li><span>姓名：</span><i><?php  if(!empty($member['nickname'])){echo $member['nickname'];} ?></i></li>
							<li><span>手机号：</span><i><?php  if(!empty($member['mobile'])){echo $member['mobile'];} ?></i></li>
						</ul>
						<!--积分 -->
						<div class="jifen_box">
							<div class="jifen_list">可用<i><?php if(!empty($member['jifen'])){echo $member['jifen'];}else{ echo 0;} ?></i>积分</div>
							<div class="jifen_list" style="margin-left: 10px;">可用优惠券<i><?php  if(!empty($coupon_n)){ echo count($coupon_n);}else{ echo 0;} ?></i>张</div>
						</div>
						<!--消息通知 -->
						<ul class="xiaoxi_box">
							<li><a href="/base/customer_service">有<span><?php if(!empty($line_answer['num'])){ echo $line_answer['num'];}else{ echo 0;} ?></span>条管家回复信息</a></li>
							<!--<li><a href="/base/customer_service">有<span><?php if(!empty($expert_answer['num'])){ echo $expert_answer['num'];}else{ echo 0;} ?></span>位指定的管家回答了您的问题</a></li>-->
							<li><a href="/base/member/mycustom">有<span><?php if(!empty($custom_answer['num'])){ echo $custom_answer['num'];}else{ echo 0;} ?></span>位管家回复您的定制方案,您尚未查看</a></li>
							<li><a href="/base/system/message">有<span><?php if(!empty($notice_answer['num'])){ echo $notice_answer['num'];}else{ echo 0;} ?></span>条平台公告尚未查看</a></li>
						</ul>
					</div>
				</div>
				<div class="dingdan_xixi" style=" height:auto;">
					<div class="dingdan_title">订单信息</div>
					<div class="xixi_list">
						<ul>
							<li><a href="/order_from/order/line_order_1_0.html"><span>已留位</span><?php if(!empty($order['liuwei'])){ echo $order['liuwei'];}else{ echo 0;} ?></a></li>
							<li><a href="/order_from/order/line_order_54_0.html"><span>已付款</span><?php if(!empty($order_money['sum'])){ echo $order_money['sum'];}else{ echo 0;} ?></a></li>
							<li><a href="/order_from/order/line_order_4_0.html"><span>已确认</span><?php if(!empty($order['queren'])){ echo $order['queren'];}else{ echo 0;} ?></a></li>
							<!--<li><a href="/order_from/order/line_order_11_0.html"><span>收款拒绝</span><?php // if(!empty($order_refuse)){ echo count($order_refuse);}else{ echo 0;} ?></a></li>-->
							<li><a href="/order_from/order/line_order_44_0.html"><span>已退款</span><?php if(!empty($order['tuikuan'])){ echo $order['tuikuan'];}else{ echo 0;} ?></a></li>
							<li><a href="/order_from/order/line_order_64_0.html"><span>已取消</span><?php if(!empty($order['quxiao'])){ echo $order['quxiao'];}else{ echo 0;} ?></a></li>
							<li><a href="/base/customer_service/deal_complaint"><span>投诉回复</span><?php if(!empty($order['tousu'])){ echo $order['tousu'];}else{ echo 0;} ?></a></li>
							<li><a href="/order_from/order/line_order_5_0.html"><span>未评价</span><?php if(!empty($nocomment['num'])){ echo $nocomment['num'];}else{ echo 0;} ?></a></li>
							<li><a href="/order_from/order/line_order_55_0.html"><span>未发体验</span><?php if(!empty($order['travel'])){ echo  $order['travel'];}else{ echo 0;} ?></a></li>
							<li><a href="/order_from/order/line_order_66_<?php if(!empty($experience['order_id'])){echo $experience['order_id'];}else{ echo 0 ;}?>.html"><span>已被评为体验师</span><?php if(!empty($experience)){echo 1;}else{ echo 0;} ?></a></li>
						</ul>
					</div>
				</div>
				<div class="h_order_box">
					<div class="head">所有订单</div>
					<table class="common-table" style="position: relative;" border="0" cellpadding="0" cellspacing="0">
						<thead class="common_thead">
							<tr>
								<th></th>
								<th width="100">订单编号</th>
								<th >产品标题</th>
								<th width="60">参团人数</th>
								<th width="80">订单金额</th>
								<th width="90">出团日期</th>
								<th width="60">支付状态</th>
								<th width="60">订单状态</th>
								<th width="120">下单时间</th>
								<th width="60">操作</th>
							</tr>
						</thead>
						<tbody class="common_tbody clear odeindex">
							<?php if(!empty($all_order_list)){ ?>
							<?php foreach ( $all_order_list as $v ): ?>
							<tr>
								<td>
									<div class="title_info">
										<?php  if($v['ispay_code']==2 && $v['status_opera']==1 && isset($v['refuse_reason'])):?>
										<img class="title_img" src="/assets/img/u223.png">
										<div class="info_txt" id="info_txt">
											<p><?php echo $v['refuse_reason'];?></p>
										</div>
										<?php elseif($v['status_opera']==1 && $v['ispay_code']==0):?>
										<img class="title_img" src="/assets/img/u224.png">
										<div class="info_txt" id="info_txt">
											<p>已预留位,请尽快去付款.</p>
										</div>
										<?php endif;?>
									</div>
								</td>
								<td><?php echo $v['order_sn'];?></td>
								<td style="text-align: left;">
                                                                    <!-- 将cj和gn改为line,添加后缀.html-->
									<a class="line_title fl" title="<?php echo $v['linename']; ?>" href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html'; ?>" target="_blank"><?php echo   $v['linename'] ?></a>
								</td>
								<td><?php echo $v['people_num'];?></td>
								<td><?php echo $v['order_amount']+$v['settlement_price'];?></td>
								<td><?php echo $v['usedate'];?></td>
								<td class="color1"><?php echo $v['ispay'];?></td>
								<td class="color2"><?php echo $v['status'];?></td>
								<td><?php echo   date('Y-m-d H:i',strtotime($v['addtime']))?></td>
								<td class="detail_link">
									<!--订单转团-->
								            <?php  if($v['ispay_code']==2 && $v['trun_status']==0 ): ?>
								            	<?php  if($v['diff_price']>0): ?>
									<a data-val="<?php echo $v['order_id'].'|'.$v['diff_price'];?>" expert="<?php echo $v['expert_id'] ?>" supplier="<?php echo $v['supplier_id'] ?>"  href="<?php echo site_url('pay/order_pay/pay_type?oid='.$v['order_id']);?>" class="pay">付款</a>
								            	<?php endif;?>
									<?php  endif;?>
									
									<!--待用户付款-->
									<?php if($v['status_opera']==0 && $v['ispay_code']==0):?>
									<a data-val="<?php echo $v['order_id'].'|'.$v['order_amount'];?>" expert="<?php echo $v['expert_id'] ?>" supplier="<?php echo $v['supplier_id'] ?>"  href="<?php echo site_url('pay/order_pay/pay_type?oid='.$v['order_id']);?>" class="pay">付款</a>
									<a data-val="<?php echo $v['order_id'];?>" expert="<?php echo $v['expert_id'] ?>" supplier="<?php echo $v['supplier_id'] ?>"  href="#cancle_order" class="cancle_order">取消订单</a>
									<a href="<?php echo base_url('order_from/order/show_order_detail_'.$v['order_id'])?>.html"target="_blank">编辑订单</a>
									<!--待确认-->
									<?php elseif($v['status_opera']==1):?>
									<a href="<?php echo base_url('order_from/order/show_order_detail_'.$v['order_id'])?>.html"target="_blank">编辑订单</a>
									<!--已付款-->
									<?php elseif( ($v['status_opera']==4 || $v['status_opera']==1) && $v['ispay_code']==2):?>
									<a href="<?php echo base_url('order_from/order/show_order_detail_'.$v['order_id'])?>.html"target="_blank">编辑订单</a>
									<!--已完成-->
									<?php elseif($v['status_opera']>=5 && $v['ispay_code']==2):?>
									<a data-val="<?php echo $v['order_id'].'|'.$v['m_mobile'];?>" expert="<?php echo $v['expert_id'] ?>" supplier="<?php echo $v['supplier_id'] ?>"  href="#complaint" class="complaint">投诉</a>
									<!--已完成-->
									<?php if($v['commentid']>0){?>
										<!--<a href="#del_comment" onclick="del_comment(<?php //echo $v['commentid'].','.$v['order_id']; ?>)">删除评论</a>-->
									<?php }else{ ?>
									      	<a data-val="<?php echo $v['order_id'].'|'.$v['line_id'].'|'.$v['expert_id'];?>"expert="<?php echo $v['expert_id'] ?>" linename="<?php echo $v['linename'] ; ?>"  supplier="<?php echo $v['supplier_id'] ?>"  href="#evaluateButton" class="evaluateButton" >评论</a>
									<?php } ?>
									
									<a href="<?php echo base_url('order_from/order/show_order_message_'.$v['order_id'].'.html')?>"target="_blank">查看订单</a>
									<?php else: ?>
									<a href="<?php echo base_url('order_from/order/show_order_message_'.$v['order_id'].'.html')?>"target="_blank">查看订单</a>
									<?php endif;?>

								</td>
							</tr>
							<?php endforeach;?>
							<?php }else{?>
							<tr>
								<td class="order_list_active" colspan="10">
									<p class="cow-title">是不是没有和你心仪的出游线路？</p>
									<p class="cow-text">没关系，快去找旅游管家帮忙推荐或定制一个吧！<a href="<?php echo base_url('expert/expert_list')?>" target="_blank" class="s_forhelp">找管家帮帮忙</a></p>
								</td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<div class="pagination">
						<ul class="page"><?php if(!empty($all_order_list)){ echo $this->page->create_c_page();}?></ul>
					</div>
				</div>
			</div>
		<!-- 右侧菜单结束 -->
		</div>
	</div>
</div>
<!-- 操作的一系列弹框 -->
<!-- 退单弹出层内容 -->
<div id="fox" style="display: none; width: 500px; height: auto;">
	<!-- 此处放编辑内容 -->
	<div align="center">
		<div class="widget-body">
			<div id="registration-form" class="messages_show">
				<form action="<?php echo base_url('order_from/order/apply_refund_order');?>" name="apply_refund_order" id="apply_refund_order" method="post" onsubmit="return Checkpay(this);">
					<div class="pay_outline" style="width:500px;float:none;">
						<div class="pay_til">退单申请</div>
						<div class="tuidan" style="margin-left:0px;">
							<?php if(!empty($reason)){ ?>
							<?php foreach ($reason as $k=>$v){ ?>
							<p class="tuidan"><span><label class="offer_reason"><input type="radio" name="pay_reason" value="<?php echo $v['dict_id']; ?>"><?php echo $v['description'];?></label></span></p>
							<?php } } ?>
							<p><span><label class="other_reason"><input type="radio" name="pay_reason" value="-1">其他原因</label></span></p>
							<div class="hidden_content">
								<textarea placeholder="请填写您要表述的其他理由100字以内" name="back_reason" class="content text_num" id="back_reason"></textarea>
								<span class="font_num_title">剩余<i class="thismun">100</i>字</span>
							</div>
							<input type="hidden" style="padding-top: 10px;"name="refund_order_id" id="refund_order_id" value="" />
							<input type="hidden" style="padding-top: 10px;"name="expert" id="expert_id" value="" />
							<input type="hidden" style="padding-top: 10px;"name="supplier" id="supplier_id" value="" /><br>
							<input type="hidden" style="padding-top: 10px;"name="pay_mobile" id="pay_mobile" value="" />
							<input type="submit" value="提交" class="tijiao_le" style="margin-bottom:30px;"/>
							<input type="reset" value="取消" class="tijiao_ri" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end -->
<!-- 取消订单出层内容 -->
<div id="cancle_order"style="display: none; width: 500px; height:auto;">
	<!-- 此处放编辑内容 -->
	<div align="center">
		<div class="widget-body">
			<div id="registration-form" class="messages_show">
				<form action="" name="order_cancle" onsubmit="return CheckCancleOrder(this);" id="order_cancle" method="post">
					<div class="pay_outline" style="float:none;">
						<div class="pay_til">取消订单</div>
						<div>
							<?php if(!empty($reason)){ ?>
							<?php foreach ($reason as $k=>$v){ ?>
							<p class="cancel_oreder_reason"><span><label class="offer_reason"><input type="radio" name="reasons" value="<?php echo $v['dict_id']; ?>"><?php echo $v['description'];?></label></span></p><br>
							<?php }?>
							<p class="cancel_oreder_reason"><span><label class="other_reason"><input type="radio" name="reasons" value="-1">其他原因</label></span></p><br>
							<?php }?>
							<div class="hidden_content">
								<textarea placeholder="请填写您要表述的其他理由,100字以内" class="text_num" maxlength="100" name="cancle_reasons" id="cancle_reasons"></textarea>
								<span class="font_num_title">剩余<i class="thismun">100</i>字</span>
							</div>
							<input type="hidden" style="padding-top: 10px;"name="cancle_order_id" id="cancle_order_id" value="" />
							<input type="hidden" style="padding-top: 10px;"name="expert" id="cancle_expert" value="" />
							<input type="hidden" style="padding-top: 10px;"name="supplier" id="cancle_supplier" value="" /><br>
							<input type="submit" value="提交" class="tijiao_le" style="margin-bottom:30px;"/>
							<input type="reset" value="取消" class="tijiao_ri guanbi" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end -->
<!-- 点评出层内容 -->
<div id="evaluateButton" style="display: none; width: 720px;">
		<!-- 此处放编辑内容 -->
		<div class="eject_big">
			<div class="eject_back clear" style="height: auto;">
				<form class="form-horizontal" role="form" method="post"
					id="evaluateForm" onsubmit="return Checkevaluate();"
					action="<?php echo base_url();?>base/member/add_comment">
                    
					<div class="eject_title fl">
						<h3>评价订单</h3>
						<p class="comment_line">评价线路:</p>
					</div>
                    <div class="olumn">评价产品</div>
					<div class="eject_content fl">
						<div class="eject_content_right fl">
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>导游服务:</span>
									<ul class="score0">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>行程安排:</span>
									<ul class="score1">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>餐饮住宿:</span>
									<ul class="score2">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>旅游交通:</span>
									<ul class="score3">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="title_info_txt title_info_txt1">
								<span>产品满意度:&nbsp;<i style=" color:#f00;">50</i>&nbsp;%</span>
							</div>
                            <div class="title_info_txt title_info_txt2">
								<span>产品平均分:&nbsp;<i style=" color:#f00;">2.5</i>&nbsp;分</span>
							</div>
						</div>
					</div>
					<div class="eject-content_left fl">
						<div class="eject_content_left_s">

							<div class="eject_input_Slide">
								<textarea name="content" class="content" id="content" maxlength="200" placeholder="发表评论获得更多积分.."></textarea>
								<span class="font_num_title"><span>200</span><i>/200</i>
								</span>
							</div>
						</div>
					</div>

					<div class="eject_content2 fl">
						<div class="olumn">评价管家</div>
						<div class="eject_content_left-x clear">

							<div class="eject_right_one fl"
								style="margin-bottom: 10px; width: 200px; margin-left: 20px;">
								<div class="eject_xx_box">
									<span style="color: #666;">专业度:</span> 
									<input type="hidden" name="major" value="0" class="zyd" />
									<ul class="score4">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
							<div class="eject_right_one fl"
								style="margin-bottom: 10px; width: 200px; margin-left: 20px;">
								<div class="eject_xx_box">
									<span style="color: #666;">服务态度:</span> 
									<input type="hidden" name="serve" value="0" class="fwtd" />
									<ul class="score5">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
							<div class="expert_grade tset_1 fl">
								管家满意度:&nbsp;<span>0</span>&nbsp;%
							</div>
                           					 <div class="expert_grade tset_2 fl">
								管家平均分:&nbsp;<span>0</span>&nbsp;分
							</div>
                           					 <div class="eject_input_Evaluation fl">
								<textarea name="expert_comment" class="expert_comment" maxlength="200" placeholder="发表评论获得更多积分.."></textarea>
								<span class="font_num_title abs_tex"><span>200</span><i>/200</i>
								</span>
							</div>
                      					<div class="show_img fl">
								<p>以图为证</p>
								<div id="demo">
									<div id="as2" class="webuploader-container"></div>
									<!--<div class="title_info_txt title_info_txt3">
									<p>(注:上传图片送500积分)</p>
									</div> -->
								</div>
							</div>     
							<div class="grades"></div>
							<div class="pic_comment"></div>
							<div class="eject_button fl" style="padding-bottom: 2px;">
							 <input type="hidden" name="c_order_id" id="c_order_id"/> 
							 <input type="hidden" name="c_line_id" id="c_line_id" /> 
							 <input type="hidden" name="c_expert_id" id="c_expert_id" /> 
							 <input type="submit" name="submit" value="提交评价" class="commit" />
							</div>
						</div>
					</div>
			 </form>		
			</div>
		</div>
	</div>
<!-- end -->
<!-- 投诉出层内容 -->
<div id="complaint" style="display: none; width: 600px; height: 480px;">
	<!-- 此处放编辑内容 -->
	<div align="center">
		<div class="widget-body">
			<div id="registration-form" class="messages_show" style="position:relative;">
				<form action="<?php echo base_url('order_from/order/complaint');?>" name="complaint_order" id="complaint_order" method="post" onsubmit="return Checkcomplaint(this);">
					<div class="tousu_title">投诉维权</div>
					<ul class="tousu_list">
						<li><span>订单编号:</span><p id="order_ordersn"></p></li>
						<li><span>产品名称:</span><p id="order_linename">大优惠</p></li>
						<li><span>投诉人:</span><p id="complaint_name"></p></li>
						<li><span>联系电话:</span><input type="text" class="tousu_tel" name="complaint_mobile"></li>
						<li><span>投诉对象:</span><div class="fuxuan"><input type="radio" name="complain_type" value="1">管家</div><div class="fuxuan"><input type="radio" name="complain_type" value="2">线路产品</div><div class="fuxuan"><input type="radio" name="complain_type" value="1,2">全部</div></li>
						<li style="height:105px; position:relative;"><span>投诉内容:</span><textarea class="text_num" maxlength="100" onkeyup="words_deal()" name="complaint_content" style="width:400px; height:80px;margin-top:10px;padding:5px; border:1px solid #ccc;" class="complaint_content"></textarea>
							<span class="font_num_title" style="position:absolute;bottom:0px;width:80px;right:80px;color:#aaa; height:30px; line-height:30px;"><i class="thismun">100</i>/100</span>
						</li>
						<li style=" position:relative;">附件:<input type="file" id="upfile" name="upfile"  /><input type="button"  id="updatafile" value="上传"/><input type="hidden" id="attachment" name="attachment"  /><span style="position:absolute;top:0px;width:80px;right:80px;color:#aaa;">doc,docx</span></li>
						<li><span id="file_text" style="width:auto;"></span></li>
					</ul>
					<input type="hidden" name="complaint_order_id" id="complaint_order_id" value="" />
					<input type="hidden" style="padding-top: 10px;"name="expert" id="complaint_expert" value="" />
					<input type="hidden" style="padding-top: 10px;"name="supplier" id="complaint_supplier" value="" />
					<input type="submit" value="提交"class="tijiao_tousu"/>
					<input type="reset" value="取消" class="guanbi_tousu"/>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- 新增的弹框 end-->
<div class='avatar_box'></div>
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
<!-- end 操作的一系列弹框 -->
</body>
</html>
<script src="<?php echo base_url('static'); ?>/js/eject_sc.js" type="text/javascript"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script>
//订单左侧提示
$(document).on('mouseover', '.title_info', function(){
	$(this).find(".info_txt").show();
});
$(document).on('mouseout', '.title_info', function(){
	$(".info_txt").hide();
});
$(".other_reason").click(function(){
	$(this).parent().parent().siblings(".hidden_content").slideDown(300);
});
$(".offer_reason").click(function(){
	$(this).parent().parent().siblings(".hidden_content").slideUp(300);
});
//点击/移上 星星提示文字
$(".score0 li,.score1 li,.score2 li,.score3 li").hover(function(){
	$(this).parent().siblings("i").hide();
	$(this).parent().siblings("a").show();
	var index = $(this).index();
	if(index==0){
		$(this).parent().siblings("a").html("失望");
	}
	if(index==1){
		$(this).parent().siblings("a").html("不满");
	}
	if(index==2){
		$(this).parent().siblings("a").html("一般");
	}
	if(index==3){
		$(this).parent().siblings("a").html("满意");
	}
	if(index==4){
		$(this).parent().siblings("a").html("惊喜");
	}
},function(){
	$(this).parent().siblings("a").hide();
	$(this).parent().siblings("i").show();
});
$(".score0 li,.score1 li,.score2 li,.score3 li").click(function(){
	$(this).parent().siblings("a").hide();
	$(this).parent().siblings("i").show();
	var index = $(this).index();
	if(index==0){
		$(this).parent().siblings("i").html("失望");
	}
	if(index==1){
		$(this).parent().siblings("i").html("不满");
	}
	if(index==2){
		$(this).parent().siblings("i").html("一般");
	}
	if(index==3){
		$(this).parent().siblings("i").html("满意");
	}
	if(index==4){
		$(this).parent().siblings("i").html("惊喜");
	}
	//产品满意度
	var sco_mun=$(".score0,.score1,.score2,.score3").find(".hove").length;
	var mun= sco_mun*5;
	var fen= (sco_mun*5/20).toFixed(1);

	//alert(fen);
	//var muns = fen.substr(0,2);
	//alert(muns)
	$(".title_info_txt1").show();
	$(".title_info_txt2").show();
	$(".title_info_txt1").find("span").find("i").html(mun)
	$(".title_info_txt2").find("span").find("i").html(fen)
});

var img_arr='';
	$('#as2').diyUpload({
	url:"<?php echo base_url('line/line_detail/upfile')?>",
	success:function( data ) {
	//console.info( data );
	img_arr=img_arr+'<input type="hidden" name="img[]" value="'+data.url+'" />';
	$('.pic_comment').html(img_arr);
	},
	error:function( err ) {
	console.info( err );
	},
	//buttonText : '<img class="fl" src="<?php echo base_url('static'); ?>/img/user/u9.png"/><div class="img_num fl"><i>0</i>/5</div>',
	buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
	//buttonText : '上传',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:5,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
	});


//管家评分

$(".score4 li").click(function(){
	var sco4=$(".score4").find(".hove").length;
	var sco5=$(".score5").find(".hove").length;
	var mun= (sco4+sco5)/2;
	//alert(mun)
	$(".tset_1").show();
	$(".tset_2").show();
	$(".tset_1 span").html((sco5+sco4)*10);
	$(".tset_2 span").html(mun);
	
});
$(".score5 li").click(function(){
	var sco4=$(".score4").find(".hove").length;
	var sco5=$(".score5").find(".hove").length;
	var mun= (sco4+sco5)/2;
	$(".tset_1").show();
	$(".tset_2").show();
	$(".tset_1 span").html((sco5+sco4)*10);
	$(".tset_2 span").html(mun);
	//alert(mun)
});

//字数计算
//字数提示标签 <span class="font_num_title">已评论<i>0</i>字</span>
$("textarea").keyup(function(){
	var content = $(this).val();
	var fontNum = content.length;
	$(this).siblings(".font_num").find("i").html(fontNum);
});
/**
* 将上传获取的图片
*/
function uploadSuccess(file, file_data ){	
//   var imgurl='';
	var url	=file_data.replace("\"","");
	var imgurl='<li><i id="" onclick="del_imgdata(this,-1);"></i><img style="width:280px;height:160px;" src="/file/c/share/image/'+url+'><input type="hidden" id="editor_share_pic_1" value="/file/c/share/image/'+url+'" name="img_url[]"  /></li>';
	$('#pic_str').append(imgurl);
	$('#editor_pic_str').append(imgurl);
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setComplete();
		progress.setStatus("上传成功");
		progress.toggleCancel(false);
	} catch (ex) {
		this.debug(ex);
	}
}
//删除图片
function del_imgdata(obj,id){
	var pid=id;
	if (!confirm("确认删除？")) {
		window.event.returnValue = false;
	}else{
		$(obj).parent('li').remove();
	}
	$.post("<?php echo base_url()?>base/member/del_share_img", { data:id} , function(result) {
	});
}
//<!-- end-->
function change_avatar(){
	$('.avatar_box').show();

	/*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	xiuxiu.setLaunchVars("cropPresets", "300x300");
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
//JavaScript Document
$(function() {
(function() {
/* 退单弹层效果 */
	try {
		$(".fox").fancybox();
		$(".fox").click(function() {
		var order_id = $(this).attr('data-val');
		var expert = $(this).attr('expert');
		var supplier = $(this).attr('supplier');
		var pay_mobile=$(this).attr('pay_mobile');
		$("#refund_order_id").val(order_id);
		$("#expert_id").val(expert);
		$("#supplier_id").val(supplier);
		$("#pay_mobile").val(pay_mobile);
		$(".tijiao_ri").click();
		$(".hidden_content").hide();
	//退单的信息
	$.post("<?php echo site_url('order_from/order/get_user_pay_message')?>",{'id':order_id},function(data) {
	if(data){
		data = eval('('+data+')');
		$('input[name="pay_bankname"]').val(data.bankname);
		$('input[name="pay_bankcard"]').val(data.bankcard);
	}
	})
});
	} catch (err) {
}
	$(".tijiao_ri").click(function(){
	$(".fancybox-overlay").hide();
})

/*取消订单的弹层效果*/
try {
		$(".cancle_order").fancybox();
		$(".cancle_order").click(function() {
			var order_id = $(this).attr('data-val');
			$("#cancle_order_id").val(order_id);
			var expert = $(this).attr('expert');
			var supplier = $(this).attr('supplier');
			$("#cancle_expert").val(expert);
			$("#cancle_supplier").val(supplier);
			$(".tijiao_ri").click();
			$(".hidden_content").hide();
		});
	}catch (err) {
}

/*进入支付*/
$('#pay_form').submit(function() {
	var payment_method = $('input[name="payment_method"]:checked').val(); //支付方式  1-线上支付  0-线下支付
	if (payment_method == 1) {
		pay_money = $('input[name="pay_money"]').val();
		pay_order_id = $('input[name="pay_order_id"]').val();
		pay_type = $('input[name="pay_type"]').val();
	$.post("<?php echo site_url('pay/order_pay/get_into_pay')?>",{'pay_money':pay_money,'pay_order_id':pay_order_id,'pay_type':pay_type},function (data) {
		var pay_data = eval('('+data+')');
		if (pay_data.code == 2000) {
			$('#alipay_string').html(pay_data.msg);
		} else {
			alert(pay_data.msg);
		}
	}
	)
	} else {
		$.post("<?php echo site_url('order_from/order/pay')?>",
		$('#pay_form').serialize(),
		function (data) {
		var pay_data = eval('('+data+')');
		if (pay_data.code == 2000) {
			alert(pay_data.msg);
			location.reload();
		} else {
			alert(pay_data.msg);
		}
	}
	)
}
return false;
})
/*评论的弹层效果*/
try {
	$(".evaluateButton").fancybox();
	$(".evaluateButton").click(function() {
		//清除评论的内容
		$('.eject_xx_box').find('li').removeClass('hove');
		$('.eject_xx_box').find('i').css('display','none');//display: none;
		$('textarea[name="content"]').val('');
		$('textarea[name="expert_comment"]').val('');
		$('.fileBoxUl').html('');
		//去掉管家满意分
		$(".tset_1").hide();
		$(".tset_2").hide();
		$(".tset_1 span").html('0');
		$(".tset_2 span").html('0');
		//去掉产品满意分
		$(".title_info_txt1").hide();
    		$(".title_info_txt2").hide();
		$(".title_info_txt1").find("span").find("i").html('0')
		$(".title_info_txt2").find("span").find("i").html('0')
		
		$(".tijiao_ri").click();
		$(".eject_xx_box i").html("");
		//$(".expert_grade span").html("");
		
		$('.comment_line').val('');
		var linename=$(this).attr('linename');
		//var comment_line= $('.comment_line').html();
		$('.comment_line').html('评价线路:'+linename);
		$('expert_comment').val('');
		$('.score0 li').removeClass('hove');
		$('.score1 li').removeClass('hove');
		$('.score2 li').removeClass('hove');
		$('.score3 li').removeClass('hove');
		$('.score4 li').removeClass('hove');
		$('.score5 li').removeClass('hove');
		var data_arr = $(this).attr('data-val').split('|');
		$("#c_order_id").val(data_arr[0]);
		$("#c_line_id").val(data_arr[1]);
		$("#c_expert_id").val(data_arr[2]);
		$('#as').diyUpload({url:"<?php echo base_url('line/line_detail/upfile')?>",success:function( data ) {
			console.info( data );
			$("#pic_url").val($("#pic_url").val()+data.url+',');
		},
		error:function( err ) {
		console.info( err );
		},
		buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
		chunked:true,
		// 分片大小
		chunkSize:512 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
		fileNumLimit:5,
		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		accept: {}
	});
});
	}catch (err) {
}
/*投诉的弹层效果*/
try {
	$(".complaint").fancybox();
	$(".complaint").click(function() {
	var order_data = $(this).attr('data-val').split('|');
	var expert = $(this).attr('expert');
	var supplier = $(this).attr('supplier');
	$("#complaint_order_id").val(order_data[0]);
	$("#complaint_mobile").val(order_data[1]);
	$("#complaint_supplier").val(supplier);
	$("#complaint_expert").val(expert);
	$.post("<?php echo base_url('order_from/order/get_order_data')?>", { 'id':order_data[0]} , function(result) {
		var result = eval('('+result+')');
		$('#order_ordersn').html(result.ordersn);
		$('#order_linename').html(result.linename);
		$('#complaint_name').html(result.username);
	});
	$(".tijiao_ri").click();
});
	}catch (err) {
}
//关闭投诉
$('.guanbi_tousu').on('click', function() {
	$('.fancybox-close').click();
})

})(jQuery)
})
//投诉的上传文件
//function updatafile(){
$('#updatafile').on('click', function() {
	$.ajaxFileUpload({url:'/order_from/order/up_file',
	secureuri:false,
	fileElementId:'upfile',// file标签的id
	dataType: 'json',// 返回数据的类型
	data:{filename:'upfile'},
	success: function (data, status) {
	if (data.code == 200) {
		$('input[name="attachment"]').val(data.msg);
		$('#file_text').html(data.msg);
		alert("上传成功");
	} else {
		alert(data.msg);
	}
},
error: function (data, status, e) {
	alert("请选择不超过10M的doc,docx的文件上传");
	}
});
return false;
});
</script>
<script type="text/javascript">

$(function() {
	$(window).load(function(){
		$('.pay_online_radio input:radio').attr('checked',true);
	})
	$('.share_new_window').css('display','none');
	$('.pay_online_radio input:radio').click(function () {
	$('.pay_outline_radio input:radio').attr('checked',false);
	$(".pay_online_radio2").css('display','block');
	$(".pay_online_2").css('display','none');
	if(!!$(this).attr("checked")){
		$(this).attr('checked',false);
	}else{
		$(this).attr('checked',true);
	}
})
$('.pay_outline_radio input:radio').click(function () {
	$('.pay_online_radio input:radio').attr('checked',false);
})
$('.pay_outline_radio input:radio').click(function () {
	$('.pay_online_radio2').css('display','none');
	$('.pay_online_2').css('display','block');
	if(!!$(this).attr("checked")){
		$(this).attr('checked',false);
	}else{
		$(this).attr('checked',true);
	}
});
});
$('#comment_order_form').submit(function(){
	$.post("<?php echo site_url('order_from/order/comment');?>",
		$('#comment_order_form').serialize(),
		function(data) {
			data = eval('('+data+')');
			if (data.status == 200) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		}
	);
	return false;
});
function Checkevaluate(){
 
	var content= $('#content').val();
	if(content!=''){
		//不能超过100个字
		var str=content;
		var realLength = 0, len = str.length, charCode = -1;
		for (var a = 0; a < len; a++) {
		charCode = str.charCodeAt(a);
		if (charCode >= 0 && charCode <= 128)
			realLength += 1;
		else realLength += 1;
		}
		if(realLength>200){
			alert('线路的评价内容不能超过200个字');
			return false;
		}
	}
	
    	//专家的评论expert_comment
	var expert_comment= $('.expert_comment').val();
	if(expert_comment!=''){
	//不能超过100个字
	var str=expert_comment;
	var realLength = 0, len = str.length, charCode = -1;
	for (var a = 0; a < len; a++) {
		charCode = str.charCodeAt(a);
		if (charCode >= 0 && charCode <= 128)
			realLength += 1;
		else realLength += 1;
	}
		if(realLength>200){
			alert('评价管家的内容不能超过200个字');
			return false;
		}
	}

	//获取星级分数
	var score0=$(".score0 .hove").length;
	var score1=$(".score1 .hove").length;
	var score2=$(".score2 .hove").length;
	var score3=$(".score3 .hove").length;
	var score4=$(".score4 .hove").length;
	var score5=$(".score5 .hove").length;
	if(score0==0){
		alert('导游服务评分不能为空');
		return false;
	}
	if(score1==0){
		alert('行程安排评分不能为空');
		return false;
	}
	if(score2==0){
		alert('餐饮住宿评分不能为空');
		return false;
	}
	if(score3==0){
		alert('旅游交通评分不能为空');
		return false;
	}
	if(score4==0){
		alert('管家专业度评分不能为空');
		return false;
	}
	if(score5==0){
		alert('管家服务态度评分不能为空');
		return false;
	}
	var str='';
	str=str+'<input type="hidden" name="score0" value="'+score0+'" /><input type="hidden" name="score1" value="'+score1+'" />';
	str=str+'<input type="hidden" name="score2" value="'+score2+'" /><input type="hidden" name="score3" value="'+score3+'" />';
	str=str+'<input type="hidden" name="score4" value="'+score4+'" /><input type="hidden" name="score5" value="'+score5+'" />';
	$('.grades').html(str);

	jQuery.ajax({ type : "POST",data : jQuery('#evaluateForm').serialize(),url : "<?php echo base_url();?>order_from/order/comment",
	success : function(data) {
		data = eval('('+data+')');
		if(data.status==200){
			alert( data.msg );
			location.reload();
			$('.fancybox-close').click();
		}else{
			alert( data.msg );
			$('.fancybox-close').click();
			location.reload();
		}
	}
	});
	return false;
}
//验证投诉
function Checkcomplaint(obj){
	//$('complaint_content').val();
	var photo=obj.complaint_mobile.value;
	var telephone=photo.replace(/(^\s*)|(\s*$)/g, "");
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	var content=obj.complaint_content.value;
	if(content==''){
		alert('投诉内容不能为空！');
		return false;
	}else{
		//不能超过100个字
		var str=content;
		var realLength = 0, len = content.length, charCode = -1;
		for (var a = 0; a < len; a++) {
		charCode = str.charCodeAt(a);
	if (charCode >= 0 && charCode <= 128)
		realLength += 1;
		else realLength += 1;
	}

	if(realLength>100){
		alert('投诉内容不能超过一百个字');
		return false;
		}
	}
	if(telephone==''){
		alert('手机号码不能为空！');
		return false;
	}else if(!myreg.test(telephone)){
		alert('请输入有效的手机号码！');
		return false;
	}

	jQuery.ajax({ type : "POST",data : jQuery('#complaint_order').serialize(),url : "<?php echo base_url('order_from/order/complaint');?>",
		success : function(data) {
			var data = eval('('+data+')');
			if (data.status == 1) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;

}

//退款
function Checkpay(obj){
var len = $("input[name='pay_reason']:checked").length;
if(len<1){
	alert('请选择你要取消订单的理由');
	return false;
}else{
	var val= $("input[name='pay_reason']:checked").val();
	if(val==-1){
		var back_reason=$('#back_reason').val();
	if(back_reason==''){
		alert('其他原因的填写不能为空！');
		return false;
	}
}
}

jQuery.ajax({ type : "POST",data : jQuery('#apply_refund_order').serialize(),url : "<?php echo base_url('order_from/order/apply_refund_order');?>",
success : function(data) {
	if(data){
		alert('退单成功！');
		location.reload();
	}else{
		alert('退单失败！');
		location.reload();
	}
}
});
return false;
}

//取消订单的验证
function CheckCancleOrder(obj){

var len = $("input[name='reasons']:checked").length;

	if(len<1){
		alert('请选择你要取消订单的理由');
		return false;
	}else{
		var val= $("input[name='reasons']:checked").val();
		if(val==-1){
			var cancle_reasons=$('#cancle_reasons').val();
			if(cancle_reasons==''){
				alert('其他原因的填写不能为空！');
				return false;
			}
		}
	}

	jQuery.ajax({ type : "POST",data : jQuery('#order_cancle').serialize(),url : "<?php echo base_url('order_from/order/cancle_order');?>",
	success : function(data) {
	if(data){
		alert('取消订单成功！');
		location.reload();
	}else{
		alert('取消订单失败！');
		location.reload();
		}
	}
	});
	return false;
}
//关闭按钮
$(".guanbi").click(function() {
	$(".fancybox-close").click();
});
$(function(){
	$(".text_num").keyup(function(){
		var this_mun=$(this).val().length;
		if(this_mun>100){
			alert("哎呀!已经超出字数显示了!!")
		};
		$(".thismun").html(100-this_mun);
		if($(".thismun").html()<0){
			$(".thismun").html("0");
		}else{
			$(".thismun").html(this_Html);
		}
	})
})

$(".content,.expert_comment").keyup(function(){
	var thisMum=$(this).val().length;
	//alert(thisMum);
	$(this).siblings(".font_num_title").find("span").html(200-thisMum);
	if(thisMum>=200){
		$("font_num_title span").html("0")	
	}
});
//删除评论
function del_comment(id,orderid){
           if (!confirm("确定要删除该评价？")) {
                   window.event.returnValue = false;
       	}else{
       		if(id>0){
       			$.post("<?php echo site_url('order_from/order/del_line_comment')?>",{'id':id,'orderid':orderid},function (data) {
				var data = eval('('+data+')');
				if (data.status == 1) {
					alert(data.msg);
					location.reload();
				} else {
					alert(data.msg);
				}
			})

       		}else{
       			alert('删除失败!');	
       		}
       	}
       	return false;
}
</script>
