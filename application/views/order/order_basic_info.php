<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $web['title']?></title>
	<meta name="description" content="<?php echo $web['description']?>" />
	<meta name="keywords" content="<?php echo $web['keyword']?>" />
	<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
	<link href="<?php echo base_url();?>/static/css/rest.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>/static/css/order.css" rel="stylesheet" />
	<link href="<?php echo base_url();?>/static/css/common.css" rel="stylesheet" />
	<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
	<style>
	body{padding-bottom: 80px !important}
		div{word-break: break-all;}
		#page {float: right;margin-top: 10px;}
		#page ul{margin-bottom:20px;margin-right: 94px;height:33px;}
		#page ul li{padding-right: 10px;padding-left: 10px;padding-top: 3px;padding-bottom: 3px;height:25px; border:1px solid #ccc;float: left;margin-left: 10px;cursor: pointer;}
		#page ul li:active{background-color: #ffae00;}
		#page ul li a {display:block;text-align: center;padding-top: 5px; color:#666;}
		.bj{background-color:#ffae00 !important;}
		.page_a{width:50px;}
		.page_b{width:25px;}
		#page .active{background-color: #ffae00;}
		/*提交订单固定定位的媒体*/
		@media(max-width: 1200px){
			.float_bottom{position: fixed;width: 100%;height: 60px;background: #8f9c00;z-index: 999;bottom: 0;left:0;margin:0;}
		}
		.textBox .inputBox input{ width:150px;}
		.areaBox{ width:993px;min-height:60px; line-height:20px;}
	</style>
</head>
<body style="background:#f8f8f8;font-size:12px;">
    <div class="header">
        <div  class="wid_1200">
            <a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url('static'); ?>/img/logo.png" class="shouye_logo" /></a>
            <div class="head_right">
                <div class="shoye_yelhead">
					<img src="<?php echo base_url('static'); ?>/img/shoye_dianhua.jpg">
					<?php
						$this->username=$this->session->userdata('c_username');
						if(!isset($this->username) ||empty($this->username)):
					?>
					<span class="userLoginInfo"><a href="/login">登陆</a>丨<a href="/register/index">注册</a></span>
					<?php else: ?>
					<span>
						<a href="/order_from/order/line_order" class="username">您好，<?php echo $this ->session ->userdata('c_loginname');?></a>
						<a href="/login/logout">退出</a>
					</span>
					<?php endif; ?>
				</div>
                <div class="shouye_nav">
                    <ul>
                    	<?php
                    		foreach($navData as $val) {
                    			echo "<li><a href='{$val['link']}'>{$val['name']}</a></li>";
                    		}
                    	?>
                        <li><a class="link_black" href="http://bbs.1b1u.com" target="_blank">帮游社区</a></li>
                        <li><a href="/travels/travels_list">体验分享</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
	<!-- 开始订单信息填写  -->
	<form method="post" id='info_form'>
		<div class="orderContent">
			<div class="orderMian">
				<div class="itmeText" style="margin-top: 0;">
					<div class="titleText">订单信息</div>
					<div class="textBox clear">
						<div class="inputBox">
							<label for="">产品名称：</label>
							<span style=" color:#8f9c00;"><?php echo $line['linename']?><i style=" color:#0092ff;">&nbsp;<?php echo $line['linetitle']?></i></span>
							<span style=" float:right; font-weight: normal; margin-right:20px;"></span>
						</div>
						<div class="inputBox">
							<label for="">供应商：</label>
							<span style="margin-right: 25px;color:#000; font-weight:normal;"><?php echo $supplier['company_name']?>&nbsp;&nbsp;<?php echo $supplier['brand']?></span>
						</div>
						<div class="inputBox">
							<label for="">出发城市：</label> <span><?php echo $cityname; ?></span>
						</div>
						<div class="inputBox timeBox clear">
							<div class="fl" style="float: left;">
								<label for="">出发日期：</label>
								<span class="span1"><?php echo $lineOrder['usedate']; ?></span>
							</div>
							<div class="fl" style="float: left;">
								<label for="">返回日期：</label>
								<span><?php echo $backdate; ?></span>
							</div>
						</div>
						<div class="inputBox clear">
							<label for="" class="fl">预定人数：</label>
                            <div class="reserve_person_num fl">
                            	<div class="fl">
                            		<span class="person_type fl"><?php echo $suitPrice['unit'] == 1 ? '成人' :$suitPrice['suitname'];?></span>
                            		<span class="preson_preice fl"><?php echo $suitPrice['unit'] == 1 ? $suitPrice['adultprice'].'元/人' :$suitPrice['adultprice'].'元/'.$suitPrice['unit'].'人套餐';?></span>
                                	<div class="adultsNum fr">
             							<div class="adultsNumDown" onclick="changeTraverNum('dingnum',2,1)">-</div>
              							<div class="adultsNums">
              								<input type="text"  name="dingnum" class="travelNumber" style="ime-mode:disabled;"  maxlength="2" value="<?php echo empty($lineOrder['adultnum']) ?1:$lineOrder['adultnum']?>">
              							</div>
              							<div class="adultsNumUp" onclick="changeTraverNum('dingnum',1,1)">+</div>
                                    </div>
                                </div>
                                <?php if ($suitPrice['childprice'] > 0 && $suitPrice['unit'] ==1):?>
                                <div class="fl">
                                	<span class="person_type fl">儿童占床</span>
                                	<span class="preson_preice fl"><?php echo $suitPrice['childprice']?>元/人</span>
                                	<div class="adultsNum fr">
             							<div class="childNumDown" onclick="changeTraverNum('childnum',2)">-</div>
              							<div class="childNums"><input type="text" name="childnum" class="travelNumber" style="ime-mode:disabled;" value="<?php echo empty($lineOrder['childnum']) ?0:$lineOrder['childnum'];?>" maxlength="2"></div>
              							<div class="childNumUp" onclick="changeTraverNum('childnum',1)">+</div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($suitPrice['childnobedprice'] > 0 && $suitPrice['unit'] ==1):?>
                                <div class="fl">
                                	<span class="person_type fl">儿童不占床</span>
                                	<span class="preson_preice fl"><?php echo $suitPrice['childnobedprice']?>元/人</span>
                                	<div class="adultsNum fr">
             							<div class="childNumDown2" onclick="changeTraverNum('childnobednum',2)">-</div>
              							<div class="childNums2"><input type="text" name="childnobednum" class="travelNumber" style="ime-mode:disabled;"  value="<?php echo empty($lineOrder['childnobednum']) ?0:$lineOrder['childnobednum'];?>"  maxlength="2"></div>
              							<div class="childNumUp2" onclick="changeTraverNum('childnobednum',1)">+</div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($suitPrice['oldprice'] > 0 && $suitPrice['unit'] ==1):?>
                                <div class="fl">
                                	<span class="person_type fl">老人</span>
                                	<span class="preson_preice fl"><?php echo $suitPrice['oldprice'];?>元/人</span>
                                	<div class="adultsNum fr">
             							<div class="oldNumsDown" onclick="changeTraverNum('oldnum',2)">-</div>
              							<div class="oldNums"><input type="text" name="oldnum"  value="<?php echo empty($lineOrder['oldnum']) ?0:$lineOrder['oldnum'];?>" class="travelNumber" style="ime-mode:disabled;" maxlength="2"></div>
              							<div class="oldNumsUp" onclick="changeTraverNum('oldnum',1)">+</div>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
						</div>
						<?php if (!empty($memberData)):?>
						<?php if (isset($mcData) && !empty($mcData)):?>
                       <div class="inputBox" style=" height:28px;">
							<label for="" style=" float:left;">优惠券：</label>
                            <div class="dropdown" id="memberCoupon">
                                <input class="input_select" readonly type="text" value="请选择优惠券"/>
                                <input type="hidden" name="member_coupon_id" />
                                <img src="../../../static/img/sanjiao_03.png" class="sanjiao">
                                <ul class="con_box" style=" width:200px">
                                	<?php
                                		foreach($mcData as $val) {
                                			echo '<li data-val="'.$val['mcid'].'" data-min="'.$val['min_price'].'" data-quota="'.$val['coupon_price'].'"><a href="javascript:void(0);">'.$val['name'].'</a></li>';
                                		}
                                	?>
                                </ul>
                            </div>
						</div>
						<?php endif;?>
                     	<!--  <div class="inputBox fl clear" style="width:auto !important;">
							<label for="" class="fl">使用积分：</label>
							<input type="text" name="jifen" value="" /><i style=" padding-left: 10px; color: #f00;">您可以使用<?php //echo $memberData['jifen']?>积分</i>
						</div>-->
						<?php endif;?>
						<div class="inputBox fl clear">
							<label for="name">联系人：</label> <span>
							<input type="text" id="name" maxlength="30" name="username" value='<?php if (!empty($memberData)){echo $memberData['truename'];}?>'  onkeyup="this.value=this.value.replace(/[^\w\u4e00-\u9fa5]+/g,'')" /><b>*</b>
							</span>
						</div>
						<div class="inputBox fl">
							<label for="">手机：</label> <span> <input maxlength="11"
								type="text" name="mobile" value='<?php if (!empty($memberData)){echo $memberData['mobile'];}?>' /><b>*</b>
							</span>
						</div>
						<div class="inputBox fl">
							<label for="">备用手机：</label> <span>
							<input type="text"  maxlength="100" name="spare_mobile" value='' />
							</span>
						</div>
						<div class="inputBox fl">
							<label for="">邮箱：</label> <span> <input type="text" id="mail"
								maxlength="100" name="email" value='<?php if (!empty($memberData)){echo $memberData['email'];}?>' /><b>*</b>
							</span>
						</div>
						<div class="inputBox clear">
							<label for="">备注：</label>
							<textarea rows="" cols="" name="spare_remark" class="areaBox"></textarea>
						</div>
					</div>
				</div>
				<!-- 游客信息 -->
				<div class="itmeText itmeText-2">
                    <div class="huise_title" style="margin-bottom:20px;">
					<div class="titleText" style=" float:left; margin-right:10px;">游客信息</div>
					<p class="info" style=" float:left; line-height:40px;">为了保障您的合法权益，请准确的填写出游人信息，出游人信息不完整会延误您的正常出游。因填写不完整、不准确造成的保险拒赔等问题，我公司不承担相应责任。</p>
                    </div>
					<div class="tourist_info pading_le">
	 <div style="margin-bottom:18px" class="exceldata">
	 	<input type="file" id="upfile" name="upfile"  />
	 	<input type="button"  id="saveDriveBtn" value="导入Excel"/>
	 </div>
              <div class="lanmu_Add traver_list1" style="display:none;">
              	<ul style="border-top:1px solid #ccc;" class="bord_red">
              		<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">序号</li>
                  <li style="margin-right:0px;"><i>*</i>姓名</li>
                  <li style="margin-right:0px; width:75px;"><i>*</i>性别</li>
              		<li><i>*</i>证件类型</li>
              		<li><i>*</i>证件号码</li>
              		<li><i>*</i>出生日期</li>
              		<li>手机号码</li>
              		<li style="padding:0;">操作</li>
              	</ul>
              </div>
     			 </div>
                 	<!--第二种表格 -->
                 <div class="jingwaide_Table traver_list2" style="display:none;">
                 	<ul style=" border-top:1px solid #ccc" class="bord_red">
                    	<li class="grade">编号</li>
                        <li class="chinese_name">姓名</li>
                        <li class="english_name"><i>*</i>英文名</li>
                        <li class="gender"><i>*</i>性别</li>
                        <li class="id_type"><i>*</i>证件类型</li>
                        <li class="zhengjian_number"><i>*</i>证件号</li>
                         <li class="date_birth"><i>*</i>出生日期</li>
                        <li class="issue_di"><i>*</i>签发地</li>
                        <li class="issue_date"><i>*</i>签发日期</li>
                        <li class="validity"><i>*</i>有效期至</li>
                        <li class="phone_number">手机号</li>
                    </ul>
                 </div>
			</div>
			<input type="hidden" name="insurance" value="">
			<?php if (!empty($insuranceData)):?>
			<div class="itmeText itmeText-4">
					<div class="titleText">保险方案</div>
                    <div class="pading_le whid_1000">
                    </div>
				</div>


			<div class="wid_1000 baoxian_list" style=" width: 1110px; margin-top: 20px; margin-left: 35px;">
				        <!-- 名头-->
				        <ul>
				            <li style=" width:300px;">名称</li>
				            <li style=" width:100px;">数量</li>
				            <li style=" width:365px;">说明</li>
				            <li style=" width:115px;">期限</li>
				            <li style=" width:115px;">单价</li>
				            <li style=" width:99px;" class="border_none">选择</li>
				        </ul>
				        <div class="baoxian_click">
				        	<?php foreach($insuranceData as $val):?>

							<div class="bxList">

					            <ul class="insurance-list">
					                <li style=" width:300px;">
					                	<?php echo $val['insurance_name']?>
					                </li>
					                <li style="width:100px;" class="insurance-number" data-num="<?php echo $countNum;?>">
					                <?php echo $countNum;?>
					                </li>
					                <li style=" width:365px;" class="bdBoxx">
					                	<?php echo str_cut($val['simple_explain'],80)?>
					                </li>
					                <li style=" width:115px;"><?php echo $line['lineday']?>天</li>
					                <li style=" width:115px;" class="insurance-price" data-price="<?php echo $val['settlement_price']?>"><?php echo $val['settlement_price']?>份</li>
					                <li style=" width:99px;" class="border_none">
					                	<label class="overoff" data-val="<?php echo $val['tid']?>">
											<span class="ikcSpan"></span>
					                	</label>
					                </li>
					            </ul>

					            <div class="bxCon">
					        		<div class="bxConList">
					        			<h2>保险类型</h2>
					        			<div><?php echo $val['dict_name']?></div>
					        		</div>
					        		<div class="bxConList">
					        			<h2>保险描述</h2>
					        			<div><?php echo $val['description'];?></div>
					        		</div>
					        		<div class="bxConList">
					        			<h2>保险说明</h2>
					        			<div><?php echo $val['simple_explain']?></div>
					        		</div>
					        	</div>
				            </div>
				            <?php endforeach;?>
				        </div>
				    </div>
				<?php endif;?>

				<div class="clear" style="width: 100%; height: 1px;"></div>
				<!-- 选择管家-->
				<div style="position: relative" class="clear">
					<div class="itme_Housekeeper">
						<div class="itme_Housekeeper_title">
							<h2>选择管家</h2>
							<i>旅游管家全程跟进一对一为您服务</i>
							<?php
								if (count($expert) > 5) {
									echo '<span class="choiceExpert">更多选择</span>';
								}
							?>
						</div>
						<div class="itme_House_list">
							<!-- 保存专家ID -->
							<input type="hidden" name="expert_id" />
							<ul class="line_expert">
							<?php
								$sel = '';
								foreach($expert as $key =>$val):
									if ($key == 5) {break;}
									if ($key == 1) {
										if (count($expert) == 1) {
											$sel = 'list_click';
										}
									}
							?>
							<li data-val="<?php echo $val['eid']?>" class="le_<?php echo $val['eid'] ?> <?php echo $sel;?>">
								<img title="" src="<?php echo $val['small_photo']?>">
									<div class="itme_House_xingxi">
                                                                            <!-- 将guanj改为guanjia,添加后缀.html 魏勇编辑-->
										<div class="Housek_name"><a href="/guanjia/<?php echo $val['eid'].'.html' ?>" target="_blank"><?php echo $val['nickname']?></a></div>
										<div class="Housek_Level">
									<?php
								if ($val['grade'] == 1) {
									echo '管家';
								} elseif ($val['grade'] == 2) {
									echo '初级专家';
								} elseif ($val['grade'] == 3) {
									echo '中级专家';
								} elseif ($val['grade'] == 4) {
									echo '高级专家';
								}
								?>

                                </div>
                                	 <div class="weixuanzhong"></div>
                                	<?php if (!empty($val['ecid'])):?>
									<div class="Housek_State">咨询过</div>
									<?php endif;?>

								</div>
                            </li>
							<?php endforeach;?>
						</ul>
						</div>
					</div>
				</div>
				<!-- 选择管家结束-->
				<!-- 预定须知 -->
				<div class="itmeText itmeText-4">
					<div class="titleText">参团须知</div>
                    <div class="pading_le whid_1000">
                    </div>
				</div>
                <!-- 温馨提示 -->
                <div class="itmeText itmeText-4">
					<div class="titleText back_none" ><span class="border_le "></span>温馨提示</div>
                    <div class="pading_le whid_1000">
                        <?php echo $line['line_beizhu']?>
                    </div>
                </div>
                <!-- 特别约定 -->
                <div class="itmeText itmeText-4">
					<div class="titleText back_none" ><span class="border_le"></span>特别约定</div>
                    <div class="pading_le whid_1000">
                        <?php echo $line['special_appointment']?>
                    </div>
                </div>
                <!-- 特别约定 -->
                <div class="itmeText itmeText-4">
					<div class="titleText back_none" ><span class="border_le"></span>安全须知</div>
                    <div class="pading_le whid_1000">
                        <?php echo $line['safe_alert']?>
                    </div>
                </div>
                <!-- 出游费用包含 -->
				<div class="itmeText itmeText-4">
					<div class="titleText">出游费用包含</div>
                    <div class="pading_le whid_1000">
                        <?php echo $line['feeinclude']?>
                    </div>
                </div>
				<!-- 出游费用不包含 -->
				<div class="itmeText itmeText-4">
					<div class="titleText">出游费用不包含</div>
                    <div class="pading_le whid_1000">
                        <?php echo $line['feenotinclude']?>
                    </div>
                </div>
				<!-- 保险方案 -->
				<?php if (count($insuranceData) > 0):?>

				<div class="itmeText itmeText-4" style="height:auto;">

			    <?php endif;?>
			    <!-- 保险方案结束 -->
				<!--在线合同-->
                <div class="itmeText itmeText-4">
					<div class="titleText">在线合同<span style="color:#f30; font-weight:normal; padding-left:12px;">请仔细阅读旅游合同，具体出游信息以您填写的订单为准。</span></div>
                    <div class="gundong_tract">
                        <div class="p_box_act"><?php if ($linetype == 1){echo $webData[0]['travel_contract_abroad'];} else {echo $webData[0]['travel_contract_domestic'];} ?></div>
                    </div>
				</div>
				</div>
			</div>
		</div>
		<div class="dingdanDou">
			<div class="dingdan_xieyi">
				<input type="checkbox" name="agree_check" value="1">
				<span>我已阅读并接受以上电子合同条款、保险条款、安全提示和其他所有内容，无需再次签署纸质合同</span>
			</div>
	</div>
<!--尾部-->
<!--固定定位的金额浮动-->
    <div class="float_bottom">
        <div class="float_con">
            <!-- 将cj和gn改为line,添加后缀.html-->
            <div class="flocon_le"><a href="<?php echo in_array(1 ,explode(',',$line['overcity'])) ? '/line/'.$line['id'].'.html' : '/line/'.$line['id'].'.html';?>"><&nbsp;返回</a></div>
            <div class="flocon_ri">
                <div class="yingfu">应付金额<span class="orderCountMoney" countMoney="<?php echo $money?>">¥<?php echo $money?></span></div>
                <div class="zhengdao orderMoneyInfo" >团费¥<?php echo $money?>&nbsp;-优惠券¥0&nbsp;-积分¥0&nbsp;+保险¥0&nbsp;</div>
            </div>
        </div>
        <div class="float_btn"><input type="submit" value="确认下单"></div>
    </div>
    </form>
<script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/static/js/id_card.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<?php $this->load->view('common/choice_expert'); ?>
<?php echo $this->load->view('common/login_box1');  ?>
<?php echo $this->load->view('common/retrieve_box1');  ?>

<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<!--上传excel文件-->
<script src="<?php echo base_url('static'); ?>/js/eject_sc.js" type="text/javascript"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>

<!--end-->
<script>
//提交订单
var s = true;
$('#info_form').submit(function(){
	if (s == false) {
		return false;
	} else {
		s = false;
	}
	submitForm();
	return false;
});
function submitForm() {
	var index = layer.msg('下单中，请稍后', { icon: 16, shade: 0.8,time: 200000 });
	var insurance = '';
	$('.insurance-list .overok').each(function(){
		insurance += $(this).attr("data-val")+',';
	})
	$('input[name=insurance]').val(insurance);
	$.post(
		"<?php echo site_url('order_from/order_info/create_order');?>",
		$('#info_form').serialize(),
		function(data) {
			s = true;
			layer.close(index);
			data = eval('('+data+')');
			if (data.code == 2000) {
				location.href="<?php echo site_url('pay/order_pay/pay_type')?>?oid="+data.msg;
				return false;
			} else if(data.code == 5000) {
				$("#verifycodeBox").trigger("click");
				 $('.login_box').css("display","block");
			} else if (data.code == 7000) {
				location.href="<?php echo site_url('line/line_list/index');?>";
			} else {
				//var lineGn = $(".list_click").length;
				alert(data.msg);
				if(data.msg == '请您同意合同条款后下单'){
					var  xieyi = $(".dingdan_xieyi").offset().top;
					$("html,body").animate({scrollTop:xieyi},300);
					$(".dingdan_xieyi").addClass("doudou")
				}
				if(data.msg == '请选择管家'){
					var  item = $(".itme_Housekeeper").offset().top;
					$("html,body").animate({scrollTop:item},300);
				}
			}
		}
	);
}
//登陆
$('#login_form1').submit(function(){
	var username = $("#login_form1").find("input[name='username']").val();
	$.post(
		"<?php echo site_url('login/do_login')?>",
		$('#login_form1').serialize(),
		function(data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				var html ="<a href='/order_from/order/line_order' class='username'>您好，"+username+"</a>";
				html += '<a href="/login/logout">退出</a>';
				$(".userLoginInfo").html(html);
				submitForm();
				$('.login_box').css("display","none");
			} else {
				$('#verifycode').trigger('click');
				$('.info span a').html(data.msg);
				$('.info span').show();
			}
		}
	);
	return false;
})
$('.startRegister').click(function(){
	$("#verifycodeBox1").trigger("click");
	$('.login_box').hide();
	$(".stered_content").show();
})
var rs = true;
$('#register').submit(function(){
	if (rs == false) {
		return false;
	} else {
		rs = false;
	}
	var mobile = $("#register").find("input[name='mobile']").val();
	$.post(
		"<?php echo site_url('register/doRegister')?>",
		$('#register').serialize(),
		function(data) {
			rs = true;
			data = eval('('+data+')');
			if (data.code == 2000) {
				var html ="<a href='/order_from/order/line_order' class='username'>您好，"+mobile+"</a>";
				html += '<a href="/login/logout">退出</a>';
				$(".userLoginInfo").html(html);
				submitForm();
				$('.stered_content').css("display","none");
			} else {
				$('#verifycode').trigger('click');
				//alert(data.msg);
				$('.input_html').html(data.msg);
				//$('.info span').show();
			}
		}
	);
	return false;
})
/********游客信息**********/
var linetype = <?php echo $linetype;?>;
var userJifen = <?php if(empty($memberData)){echo 0;}else{echo $memberData['jifen'];}?>;
var childprice = (<?php echo $suitPrice['childprice'];?>)*1;//儿童价格(占床位)
var childnobedprice = (<?php echo $suitPrice['childnobedprice'];?>)*1 //儿童价不占床位
var adultprice = (<?php echo $suitPrice['adultprice'];?>)*1;//成人价格
var oldprice = (<?php echo empty($suitPrice['oldprice']) ? 0 : $suitPrice['oldprice']?>)*1;//老人价格
var certificate = <?php echo json_encode($certificate);?>;//证件类型
var startname = "<?php echo $cityname; ?>";//出发城市
var suitNum = <?php echo $suitPrice['number'];?>; //余位
var unit = <?php echo $suitPrice['unit'] > 1 ? $suitPrice['unit'] : 1;?>;
var lineday = <?php echo $line['lineday']?>;
$('input[name="cityname"]').val(startname);//管家筛选

getTravelHtml(); //初始出游人填写栏
getOrderMoney();//初始价格

//出游人数量更改
$(".travelNumber").keyup(function(){
	var number = $(this).val().replace(/[^\d]/g,'');
	$(this).val(number);
	getOrderMoney();
	getTravelHtml();
}).blur(function(){
	var name = $(this).attr("name");
	var number = $(this).val();
	if (number.length == 0) {
		if (name == "dingnum")  {
			$(this).val(1);
			getOrderMoney();
			getTravelHtml();
		} else {
			$(this).val(0);
		}
	}
})
/**
 * @method 更改出游人数量
 * @param  inputName 计算后的数字显示的input的name值
 * @param  type  加减的类型   1：加     2：减
 * @param minNum 显示的最小值
 */
function changeTraverNum(inputName ,type ,minNum) {
	var minNum = typeof minNum == 'undefined' ? 0 : minNum;
	var inputObj = $("input[name='"+inputName+"']");
	var oldNum = Math.round(inputObj.val());
	var nowNum = type == 1 ? Math.round(oldNum + 1) : Math.round(oldNum - 1);
	if (nowNum < minNum || nowNum > 99) {
		return false;
	}
	inputObj.val(nowNum);
	getOrderMoney();
	getTravelHtml();
}
//计算订单价格并返回总人数
function getOrderMoney() {
	var insuranceMoney = 0;//保费
	var travelMoney = 0;//出游人价格
	var jifenMoney = 0;//积分抵扣金额
	var couponMoney = 0;//优惠券抵扣金额
	var numArr = getCountPeople();
	//更改保险人数
	$('.insurance-number').text(Math.round(numArr.count*unit));
	//订单的出游人总价格
	travelMoney = (numArr.dingnum*adultprice + numArr.childnum*childprice + numArr.childnobednum*childnobedprice + numArr.oldnum*oldprice).toFixed(0)*1;
	//积分抵扣金额
	var jifen = $("input[name='jifen']").val();
	jifenMoney = typeof jifen == 'undefined' ? 0 : (jifen/100).toFixed(2)*1;
	if (jifenMoney > travelMoney) {
		jifenMoney = travelMoney;
		$("input[name='jifen']").val(Math.round(jifenMoney*100));
	}
	//保险
	$('.insurance-list .overok').each(function(){
		var price = $(this).parent().prev().attr('data-price');//保险单价
		insuranceMoney = (insuranceMoney + price*numArr.count*unit).toFixed(2)*1;
	})
	//出游人价格变动时验证优惠券的使用
	if($("#memberCoupon").find("li").hasClass("selected")) {
		var min = $("#memberCoupon").find(".selected").attr("data-min");//满多少使用
		if (travelMoney < min*1) {
			$("#memberCoupon").find("input").val('');
			$("#memberCoupon").find("li").removeClass("selected");
		}
		//优惠券优惠金额
		var cm = $("#memberCoupon").find("ul").find(".selected").attr("data-quota");
		if (typeof couponMoney != 'undefined') {
			couponMoney = (cm*1).toFixed(2);
		}
	}
	//总价格
	//console.log(travelMoney+'---'+insuranceMoney+'---'+jifenMoney+'---'+couponMoney);
	//console.log(typeof travelMoney+'---'+typeof insuranceMoney+'---'+typeof jifenMoney+'---'+typeof couponMoney);
	var countMoney = (travelMoney*1 + insuranceMoney*1 - jifenMoney*1 - couponMoney*1).toFixed(2);
	if (countMoney <= 0) {
		countMoney = 0;
	}
	$(".orderCountMoney").html("¥"+countMoney).attr("countMoney",countMoney);
	$(".orderMoneyInfo").html("团费¥"+travelMoney+"&nbsp;-优惠券¥"+couponMoney+"&nbsp;-积分¥"+jifenMoney+"&nbsp;+保险¥"+insuranceMoney+"&nbsp;");
}

//填写积分
$("input[name='jifen']").keyup(function() {
	var oldJifen = $(this).val();
	var jifen = oldJifen.replace(/[^\d]/g,'');
	if (jifen > userJifen) {
		jifen = userJifen;
	} else if (jifen < 0) {
		jifen = 0;
	}
	$(this).val(jifen);
	getOrderMoney();
})

//生成出游人的信息填写栏
function getTravelHtml() {
	var numArr = getCountPeople();
	var number = numArr.count * unit;//unit 是多少人一份  线路套餐
	//console.log(number);
	var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1");
	var i = travelObj.find('ul').length;
	i = i == 0 ? 1 : i;
	if (number == 0) {
		travelObj.find('ul').eq(0).nextAll().remove();
		return false;
	} else if (i > number) { //填写栏大于出游人数，删除多余的填写栏
		var index = number  ;
		travelObj.find("ul").eq(index).nextAll('ul').remove();
		return false;
	}
	if (linetype == 1) { //境外
		for(i ; i<= number ;i++) {
			var html = '<ul>';
			html += '<li class="grade">'+i+'</li>';
			html += '<li class="chinese_name"><input type="text" name="name[]"></li>';
			html += '<li class="english_name"><input type="text" name="enname[]" placeholder="护照的英文名"></li>';

	        html += '<li class="gender">';
	        html += '<select name="sex[]">';
			html += '<option value="2" selected="selected">选择</option>';
			html += '<option value="1">男</option>';
			html += '<option value="0">女</option></select></li>';
	 		html += '<li class="id_type"><select  name="card_type[]"><option value="0">请选择</option>';
	 		$.each(certificate ,function(key ,val) {
	 			html += '<option value='+val.dict_id+'>'+val.description+'</option>';
	 		})
	 		html += '</select></li>';
	 		html += '<li class="zhengjian_number"><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]"></li>';
	 		html += '<li class="date_birth"><input type="text" id="datetimepicker'+i+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]" ></li>';
	 		html += '<li class="issue_di"><input type="text" name="sign_place[]" maxlength="11"></li>';
	 		html += '<li class="issue_date"><input type="text" id="sign_time'+i+'" class="date-time" name="sign_time[]" maxlength="10"></li>';
	 		html += '<li class="validity"><input type="text" id="endtime'+i+'" class="date-time" name="endtime[]" maxlength="10"></li>';
	 		html += '<li class="phone_number"><input type="text" name="tel[]" maxlength="11"></li>';
			html += "</ul>"
				travelObj.append(html).show();
				$('#datetimepicker'+i).datetimepicker({
					lang:'ch', //显示语言
					timepicker:false, //是否显示小时
					format:'Y-m-d', //选中显示的日期格式
					formatDate:'Y-m-d',
					validateOnBlur:false,
					yearStart:1930
				});
				$('#endtime'+i).datetimepicker({
					lang:'ch', //显示语言
					timepicker:false, //是否显示小时
					format:'Y-m-d', //选中显示的日期格式
					formatDate:'Y-m-d',
					validateOnBlur:false
				});
				$('#sign_time'+i).datetimepicker({
					lang:'ch', //显示语言
					timepicker:false, //是否显示小时
					format:'Y-m-d', //选中显示的日期格式
					formatDate:'Y-m-d',
					validateOnBlur:false
				});
				$('.date-time').isDate();
		}

	} else { //境内
		for(i ; i<= number ;i++) {
			var html = '<ul>';
			html += '<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">'+i+'</li>';
			html += '<li><input type="text" name="name[]"></li>';
	       		html += '<li style="margin-right:0px; width:75px;">';
	       		html += '<select name="sex[]">';
			html += '<option value="2" selected="selected">请选择</option>';
			html += '<option value="1">男</option>';
			html += '<option value="0">女</option></select></li>';
	 		html += '<li><select  name="card_type[]">';
			html += '<option value="0">请选择</option>';
	 		$.each(certificate ,function(key ,val) {
	 			html += '<option value='+val.dict_id+'>'+val.description+'</option>';
	 		})
	 		html += '</select></li>';
	 		html += '<li><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]"></li>';
	        html += '<li><input type="text" id="datetimepicker'+i+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]"></li>';
	        html += '<li><input type="text" name="tel[]" maxlength="11"></li>';
		    html += '<li style="padding:0;">';
	        html += '[<a href="javascript:void(0);" class="btn-del" onclick="delete_user(this)">清空</a>]';
	        html += '</li></ul>';
	        travelObj.append(html).show();
	        $('#datetimepicker'+i).datetimepicker({
				lang:'ch', //显示语言
				timepicker:false, //是否显示小时
				format:'Y-m-d', //选中显示的日期格式
				formatDate:'Y-m-d',
				validateOnBlur:false
			});
	        $('.date-time').isDate();

		}

	}
}
//获取总人数
function getCountPeople() {
	var dingnum = Math.round($("input[name='dingnum']").val());
	var childnum = $("input[name='childnum']").val();
	var childnobednum = $("input[name='childnobednum']").val();
	var oldnum = $("input[name='oldnum']").val();
	childnum = typeof childnum == 'undefined' ? 0 : Math.round(childnum);
	oldnum = typeof oldnum == 'undefined' ? 0 : Math.round(oldnum);
	childnobednum = typeof childnobednum == 'undefined' ? 0 : Math.round(childnobednum);
	var count = Math.round(dingnum + childnum + childnobednum + oldnum);
	return {'count':count,'dingnum':dingnum,'childnum':childnum,'childnobednum':childnobednum,'oldnum':oldnum};
}

$("#datetimepicker").keydown(function(){
	var  input_box = $("#datetimepicker").val();
	alert(input_box);
})
$(".effectiveDate").keydown(function(e){
	var str = $(this).val();
	var keyCode = e.which;
	if (keyCode != 8) {
		str = str.replace(/[^\d-]/g,'');
		if (str.length == 4) {
			str = str+'-';
		} else if (str.length == 7) {
			str = str+'-';
		} else if (str.length > 10) {
			str = str.substring(0,10);
		}
	}
	$(this).val(str);
 })
 //.blur(function(){
// 	var pregStr = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
// 	alert(pregStr.test($(this).val));
// 	if (!/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test($(this).val)) {
// 		$(this).val('');
// 	}
// })
//清空出游人信息
function delete_user(obj) {
	$(obj).parent('li').parent('ul').find('input').val('');
	$(obj).parent('li').parent('ul').find('select').val(0);
}
/***********出游人信息结束***************/

/*************线路管家筛选*********************/

//管家咨询咨询管家服务弹框
$(".choiceExpert").click(function(){
	var lineid = <?php echo $line['id'];?>;//线路ID
	$("#choiceExpertForm").find("input[name='line_id']").val(lineid);
	$("#lineExpertList").choiceExpert({type:2});
	$.fn.choiceExpert.clickExpert = function(){
		$("#lineExpertList > li").click(function(){
			$(this).addClass("list_click").siblings("li").removeClass("list_click");
            $("#lineExpertList li").find(".weixuanzhong").show();
            $(this).find(".weixuanzhong").hide();
		})
		return false;
	}
	$.fn.choiceExpert.determine = function(){
		$(".determine_button").unbind('click');
		$(".determine_button").click(function(){
			if ($("#lineExpertList").find("li").hasClass("list_click")) {
				var nickname = $("#lineExpertList .list_click .Housek_name").text();
				var expertid = $("#lineExpertList .list_click").attr("data-val");
				var img = $("#lineExpertList .list_click img").attr("src");
				var grade = $("#lineExpertList .list_click .Housek_Level").text();
				var a = true;
				$(".line_expert li").each(function(index){
					if (expertid == $(this).attr("data-val")) {
						//选中的管家在页面有显示
						$(this).addClass("list_click").siblings("li").removeClass("list_click");
						a = false;
					}
				})
				if (a == true) { //原页面没有此管家，将第一个替换
					var firstObj = $(".line_expert li").first();
					firstObj.attr("data-val" ,expertid).addClass("list_click").siblings("li").removeClass("list_click");
					firstObj.children("img").attr("src" ,img);
					firstObj.find(".Housek_name").children("a").text(nickname);
					firstObj.find(".Housek_Level").text(grade);
				}
				$('input[name="expert_id"]').val(expertid);
				$("#choiceExpertBox").hide();
                $(".line_expert li").find(".weixuanzhong").show();
                $(".list_click").find('.weixuanzhong').hide();
			} else {
				alert("请选择管家");
			}
			return false;
		})
	}
});

  $('.line_expert li').click(function(){
  	$(".line_expert li").find(".weixuanzhong").show();
  	$(this).find(".weixuanzhong").hide();
  	$(this).addClass('list_click').siblings().removeClass('list_click');
  	$('input[name="expert_id"]').val($(this).attr('data-val'));
})
</script>
<script type="text/javascript">
	$('input[name=expert_id]').attr(''); //刷新页面重置单选专家
	/* 单选顾问 */
	;(function($){
	$.fn.hradio = function(options){
	var self = this;
	return $(':radio+label',this).each(function(){
	$(this).addClass('hRadio');
	if($(this).prev().is("checked"))
	$(this).addClass('hRadio_Checked');
	}).click(function(event){
	$(this).parents("li").siblings().find("label").removeClass("hRadio_Checked");
	if(!$(this).prev().is(':checked')){
	$(this).addClass("hRadio_Checked");
	$(this).prev()[0].checked = true;
	}
	event.stopPropagation();
	})
	.prev().hide();
	}
	})(jQuery)
</script>

<script type="text/javascript">
    $(function(){
    $(".itme_paihang li").click(function(){
        $(".itme_paihang li").removeClass("itme_on");
        $(this).addClass("itme_on");
    });
});
</script>
<!-- 管家筛选弹框 -->
<script type="text/javascript">
    $(function(){
   var foo=true;
    $(".expertAge_showbox").click(function(){
        $(".expertAge_showbox").siblings(".expertAge_option").hide();
        $(this).siblings(".expertAge_option").show();
    });
    $(".expertAge_option li").hover(function(){
        $(this).addClass('hover').siblings().removeClass('hover');
    },function(){
        $(this).removeClass('hover');
    });
    $(".expertAge_option li").click(function(){
        var values=$(this).html();
        $(this).parent().hide();
        $(this).addClass('selected').siblings().removeClass('selected');
        $(this).parent().siblings().html(values);

    });
     $(document).mouseup(function(e) {
          var _con = $('.expertAge_box'); // 设置目标区域
          if (!_con.is(e.target) && _con.has(e.target).length === 0) {
              $(".expertAge_box").find("ul").hide()
          }
      })
});
</script>
<script type="text/javascript">
        $(function(){
            $("#input_1").click(function(){
                $(".invoice_form").hide();
            })
            $("#input_2").click(function(){
                $(".invoice_form").show();
            })
            $(".Core").click(function(){
                $(this).parent().next(".hide_detail_box").toggle(300);
            })
        })
</script>
<!-- 用身份证号截取生日效果-->
<script type="text/javascript">
    function get_birthday(lue){
        if (lue.length < 14) {
			return '';
        }
		var year=lue.substr(6,4);
		var month=lue.substr(10,2);
		var gay=lue.substr(12,2);
		var data=year+"-"+month+"-"+gay;
		return data;
	}
	function birthday(obj) {
		var text=$(obj).val();
        $(obj).parent().next().find(".shengri_pt").val(get_birthday(text));
	}
</script>
<!--/*仿select效果*/-->
<script type="text/javascript">
$(function() {
    $(".input_select").click(function() {
        var ul = $(".dropdown ul");
        if (ul.css("display") == "none") {
            ul.slideDown("fast");
        } else {
            ul.slideUp("fast");
        }
    });
	$(".con_box li:last-child").css("border-bottom","0px");
	//选择优惠券
    $(".dropdown ul li a").click(function() {
    	var numArr = getCountPeople();
    	//订单的出游人总价格
    	var travelMoney = (numArr.dingnum*adultprice + numArr.childnum*childprice + numArr.childnobednum*childnobedprice + numArr.oldnum*oldprice).toFixed(0);
    	var min = $(this).parent("li").attr("data-min");
    	if (travelMoney*1 < min*1) {
    		$(".input_select").val('');
            $("input[name='member_coupon_id']").val(0);
            $(".dropdown ul").hide();
			alert("没有达到使用条件");
			return false;
        }
        var txt = $(this).text();
       //console.log(txt);
        $(".input_select").val(txt);
        $("input[name='member_coupon_id']").val($(this).parent("li").attr("data-val"));
        $(this).parent("li").addClass("selected").siblings().removeClass("selected");
        var value = $(this).attr("rel");
        //要在选中之后调用
        getOrderMoney();
        $(".dropdown ul").hide();
    });
    $(document).mouseup(function(e) {
        var _con = $('.dropdown'); // 设置目标区域
        if (!_con.is(e.target) && _con.has(e.target).length === 0) {
            $(".dropdown").find("ul").hide()
        }
    })
});
</script>
<!--订单保险的切换效果-->
<script>
$(function() {
//保险部分的切换效果

$(".bdBoxx").click(function() {
	if($(this).parents().siblings(".bxCon").is(":hidden")) {
		$(".bxCon").slideUp();
		$(this).parents().siblings(".bxCon").slideToggle();
	}else{
		$(".bxCon").slideUp();
	}
})

$(".baoxian_put").click(function() {
	$(this).siblings(".bxCon").toggle();
})

$(".overoff").click(function(){
	$(this).toggleClass("overok");
	getOrderMoney();//计算订单价格
})
//弹出注册的关闭
$(".close_login_box").click(function() {
	$(".login_box").hide();
})
$(".expertAge_option li").css("padding", "0")
})
</script>


<script type="text/javascript">
$(function(){
	$('.consultantName').hradio();
});

//导入游客
function CheckDrive(){
	alert(123);
}
var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1"); //判断境内外
if(linetype==1){
          	//添加下载模板
	$('#upfile').before('<a href="/file/c/travel_out.xlsx"  style="margin-right:15px;color:#0092ff;">下载模板</a>');
}else{
	//添加下载模板
           $('#upfile').before('<a href="/file/c/travel_in.xlsx" style="margin-right:15px;color:#0092ff;">下载模板</a>');

}

$('#saveDriveBtn').click(function(){
	var numArr = getCountPeople();
	var number = numArr.count * unit;//unit 是多少人一份  线路套餐
	var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1"); //判断境内外

             $.ajaxFileUpload({url:'/order_from/order_people/index',
		secureuri:false,
		fileElementId:'upfile',// file标签的id
		dataType: 'json',// 返回数据的类型
		data:{filename:'upfile','number':number,'linetype':linetype},
		success: function (data, status) {
			if (data.code == 200) {
				alert('上传成功!');
				var title='';
				if(linetype==1){
					title+='<ul style=" border-top:1px solid #ccc" class="bord_red">';
					title+='<li class="grade">编号</li>';
					title+='<li class="chinese_name">姓名</li>';
                				title+='<li class="english_name"><i>*</i>英文名</li>';
                				title+='<li class="gender"><i>*</i>性别</li>';
                    				title+='<li class="id_type"><i>*</i>证件类型</li>';
                    				title+='<li class="zhengjian_number"><i>*</i>证件号</li>';
                    				title+='<li class="date_birth"><i>*</i>出生日期</li>';
                    				title+='<li class="issue_di"><i>*</i>签发地</li>';
                    				title+='<li class="issue_date"><i>*</i>签发日期</li>';
                     				title+='<li class="validity"><i>*</i>有效期至</li>';
                    				title+='<li class="phone_number">手机号</li>';
                    				title+='</ul>';
				}else{
					title+='<ul style="border-top:1px solid #ccc;" class="bord_red">';
					title+='<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">序号</li>';
					title+='<li style="margin-right:0px;"><i>*</i>姓名</li>';
					title+='<li style="margin-right:0px; width:75px;"><i>*</i>性别</li>';
					title+='<li><i>*</i>证件类型</li>';
                                			title+='<li><i>*</i>证件号码</li>';
                                			title+='<li><i>*</i>出生日期</li>';
                                			title+='<li>手机号码</li>';
              				title+='<li style="padding:0;">操作</li>';
                  				title+='</ul>';
				}
				travelObj.html(title).show();
				$.each(data.people,function(n,value) {
					if(value.name==null){
						value.name='';
					}
					if(value.card_num==null){
						value.card_num='';
					}
					if(value.birthday==null){
						value.birthday='';
					}

					if(linetype==1){     //境外
						if(value.enname==null){
							value.enname='';
						}

						if(value.sign_place==null){
							value.sign_place='';
						}
						if(value.sign_time==null){
							value.sign_time='';
						}
						if(value.endtime==null){
							value.endtime='';
						}
						if(value.phone_number==null){
							value.phone_number='';
						}

					            if(value.sex=="男"){
							var sexstr='<option value="2">请选择</option>';
							sexstr+='<option value="1" selected="selected" >男</option>';
							sexstr+='<option value="0">女</option>';
						}else if(value.sex=="女"){
							var sexstr='<option value="2">请选择</option>';
							sexstr+='<option value="1"  >男</option>';
							sexstr+='<option value="0" selected="selected">女</option>';
						}else{
							var sexstr='<option value="2"  selected="selected">请选择</option>';
							sexstr+='<option value="1"  >男</option>';
							sexstr+='<option value="0">女</option>';
						}

						var html = '<ul>';
						html += '<li class="grade">'+(n+1)+'</li>';
						html += '<li class="chinese_name"><input type="text" name="name[]" value="'+value.name+'"></li>';
						html += '<li class="english_name"><input type="text" name="enname[]" placeholder="护照的英文名" value="'+value.enname+'"></li>';
						html += '<li class="gender">';
						html += '<select name="sex[]">'+sexstr+'</select></li>';
				 		html += '<li class="id_type"><select  name="card_type[]"><option value="0">请选择</option>';
				 		$.each(certificate ,function(key ,val) {
				 		            if(val.description==value.card_type){
					 			html += '<option value='+val.dict_id+'  selected="selected" >'+val.description+'</option>';
					 		}else{
					 			html += '<option value='+val.dict_id+'>'+val.description+'</option>';
					 		}
				 		})
				 		html += '</select></li>';
				 		html += '<li class="zhengjian_number"><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]" value="'+value.card_num+'"></li>';
				 		html += '<li class="date_birth"><input type="text" id="datetimepicker'+(n+1)+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]"  value="'+value.birthday+'"></li>';
				 		html += '<li class="issue_di"><input type="text" name="sign_place[]" maxlength="11" value="'+value.sign_place+'"></li>';
				 		html += '<li class="issue_date"><input type="text" id="sign_time'+(n+1)+'" class="date-time" name="sign_time[]" maxlength="10" value="'+value.sign_time+'" ></li>';
				 		html += '<li class="validity"><input type="text" id="endtime'+(n+1)+'" class="date-time" name="endtime[]" maxlength="10" value="'+value.endtime+'"></li>';
				 		html += '<li class="phone_number"><input type="text" name="tel[]" maxlength="11" value="'+value.phone_number+'"></li>';
						html += "</ul>"

					}else{    //境内
						if(value.tel==null){
							value.tel='';
					             }
						if(value.sex=="男"){
							var sexstr='<option value="2">请选择</option>';
							sexstr+='<option value="1" selected="selected" >男</option>';
							sexstr+='<option value="0">女</option>';
						}else if(value.sex=="女"){
							var sexstr='<option value="2">请选择</option>';
							sexstr+='<option value="1"  >男</option>';
							sexstr+='<option value="0" selected="selected">女</option>';
						}else{
							var sexstr='<option value="2"  selected="selected">请选择</option>';
							sexstr+='<option value="1"  >男</option>';
							sexstr+='<option value="0">女</option>';
						}
						var html = '<ul>';
						html += '<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">'+(n+1)+'</li>';
						html += '<li><input type="text" name="name[]" value="'+value.name+'"></li>';
					       	html += '<li style="margin-right:0px; width:75px;">';
					       	html += '<select name="sex[]">'+sexstr+'</select></li>';
					 	html += '<li><select  name="card_type[]">';
						html += '<option value="0">请选择</option>';
					 	$.each(certificate ,function(key ,val) {
					 		if(val.description==value.card_type){
					 			html += '<option value='+val.dict_id+'  selected="selected" >'+val.description+'</option>';
					 		}else{
					 			html += '<option value='+val.dict_id+'>'+val.description+'</option>';
					 		}
					 	})
					 	html += '</select></li>';
					 	html += '<li><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]" value="'+value.card_num+'"></li>';
					        	html += '<li><input type="text" id="datetimepicker'+(n+1)+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]" value="'+value.birthday+'"></li>';
					       	html += '<li><input type="text" name="tel[]" maxlength="11" value="'+value.tel+'"></li>';
						html += '<li style="padding:0;">';
					      	html += '[<a href="javascript:void(0);" class="btn-del" onclick="delete_user(this)">清空</a>]';
					       	html += '</li></ul>';
					}


					travelObj.append(html).show();  //显示出游人
					var i=n+1;
				             $('#datetimepicker'+i).datetimepicker({
						lang:'ch', //显示语言
						timepicker:false, //是否显示小时
						format:'Y-m-d', //选中显示的日期格式
						formatDate:'Y-m-d',
						validateOnBlur:false
					});
					$('.date-time').isDate();
				});

				if(data.mun<number){  //导入不够追加
					for(var a =data.mun; a< number ;a++) {
					            if(linetype==1){     //境外
							var sexstr='<option value="2"  selected="selected">请选择</option>';
							sexstr+='<option value="1"  >男</option>';
							sexstr+='<option value="0">女</option>';

							var html = '<ul>';
							html += '<li class="grade">'+(a+1)+'</li>';
							html += '<li class="chinese_name"><input type="text" name="name[]" ></li>';
							html += '<li class="english_name"><input type="text" name="enname[]" placeholder="护照的英文名" ></li>';
							html += '<li class="gender">';
							html += '<select name="sex[]">'+sexstr+'</select></li>';
					 		html += '<li class="id_type"><select  name="card_type[]"><option value="0">请选择</option>';
					 		$.each(certificate ,function(key ,val) {
						 		html += '<option value='+val.dict_id+'>'+val.description+'</option>';
					 		})
					 		html += '</select></li>';
					 		html += '<li class="zhengjian_number"><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]"></li>';
					 		html += '<li class="date_birth"><input type="text" id="datetimepicker'+(a+1)+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]" ></li>';
					 		html += '<li class="issue_di"><input type="text" name="sign_place[]" maxlength="11" ></li>';
					 		html += '<li class="issue_date"><input type="text" id="sign_time'+(a+1)+'" class="date-time" name="sign_time[]" maxlength="10"  ></li>';
					 		html += '<li class="validity"><input type="text" id="endtime'+(a+1)+'" class="date-time" name="endtime[]" maxlength="10"></li>';
					 		html += '<li class="phone_number"><input type="text" name="tel[]" maxlength="11"></li>';
							html += "</ul>"


						}else{    //境内

							var sexstr='<option value="2"  selected="selected">请选择</option>';
							sexstr+='<option value="1"  >男</option>';
							sexstr+='<option value="0">女</option>';
							var html = '<ul>';
							html += '<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">'+(a+1)+'</li>';
							html += '<li><input type="text" name="name[]" ></li>';
						       	html += '<li style="margin-right:0px; width:75px;">';
						       	html += '<select name="sex[]">'+sexstr+'</select></li>';
						 	html += '<li><select  name="card_type[]">';
							html += '<option value="0">请选择</option>';
						 	$.each(certificate ,function(key ,val) {
						 		html += '<option value='+val.dict_id+'>'+val.description+'</option>';
						 	})
						 	html += '</select></li>';
						 	html += '<li><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]"></li>';
						        	html += '<li><input type="text" id="datetimepicker'+(a+1)+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]"></li>';
						       	html += '<li><input type="text" name="tel[]" maxlength="11" ></li>';
							html += '<li style="padding:0;">';
						      	html += '[<a href="javascript:void(0);" class="btn-del" onclick="delete_user(this)">清空</a>]';
						       	html += '</li></ul>';
						}

						travelObj.append(html).show();

					             $('#datetimepicker'+(a+1)).datetimepicker({
							lang:'ch', //显示语言
							timepicker:false, //是否显示小时
							format:'Y-m-d', //选中显示的日期格式
							formatDate:'Y-m-d',
							validateOnBlur:false
						});
						$('.date-time').isDate();
					}
				}

			} else {
				alert(data.msg);
			}
		},
		error: function (data, status, e) {
			alert("Excel的文件内容格式不对");
			//console.log(data);
		}
	});
	return false;
});

</script>



</body>
</html>





