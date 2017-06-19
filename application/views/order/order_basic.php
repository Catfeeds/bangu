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
		/*.people-price{display:none;}*/
		.person_type{ width: 100px; font-weight: bold;}
   		.adultsNum{ margin-left: 40px;}
   		.settlenTitle, .settlenPay, .settlenComp{ display: inline-block;}
   		.settlenPay{ padding-left:20px;text-align: right; color: #f30 !important;}
   		.people-price{ width:auto;}
		.fg-btn{ width:inherit; padding:5px 10px; line-height:inherit;}
		.childNums input, .adultsNums input, .childNums2 input, .oldNums input{width: 40px !important;}
		.childNums, .adultsNums, .childNums2, .oldNums{width: 40px !important;}
		.reserve_person_num>div{ width:750px !important;}
		
		.float_con{ width:67.5%;}
		.float_btn{ width:15%;}
		.float_btn input{ background:#1F6179; color:#fff; border-radius:5px; font-size: 20px;}
		.float_lin{ width: 15%; height: 50px;;margin-top: 5px;margin-left: 5px;float: left; margin-right:1%;}
		.float_lin input{ height:100%; width:100%; border-radius:5px; outline:none;  border:none; color:#fff;  font-size: 20px; background:#1F6179; cursor:pointer}
		.fixDicog{position: fixed; width:1200px;z-index: 999;bottom: 0;left: 50%;
  margin-left: -600px;}
  		.float_bottom{  position: relative;}
  		.floatFootText{font-size:14px; padding: 0 10px; height:30px; line-height:30px; background:#fff; color:#f30; border:1px solid #e1e1e1;  text-align: right;}
		/*提交订单固定定位的媒体*/
		@media(max-width: 1200px){
			.fixDicog{position: fixed;height: 60px; width:1200px;background: #8f9c00;z-index: 999;bottom: 0;left: 50%;}
		}
		.textBox .inputBox { margin-bottom:10px;line-height:20px;}
		.rb-row{width: 18%;float: left;}
		.rb-row input[type=text]{border: 1px solid #a7a6aa;height: 22px;}
		.rb-row select{border: 1px solid #a7a6aa;height: 26px;width: 70px;}
		span.preson_preice.fl.people-price { width:100px;}
		.xdsoft_datetimepicker { z-index:11111111111;}
		.textBox .inputBox input{ width:150px;}
		.areaBox{ width:946px;min-height:60px; line-height:20px;}
	</style>
</head>
<body style="background:#f8f8f8;font-size:12px;">
    <div class="header">
        <div  class="wid_1200">
            <a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url('static'); ?>/img/logo.png" class="shouye_logo" /></a>
            <div class="head_right">
                <div class="shoye_yelhead">
					<img src="<?php echo base_url('static'); ?>/img/shoye_dianhua.jpg">
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
	<form method="post" id='submit-order'>
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
						<div class="inputBox" style="display:inline-block;width:311px;">
							<label for="">出发城市：</label> <span><?php echo $cityname; ?></span>
						</div>
						
<!-- 						<div class="inputBox PackageBox" > -->
<!-- 							<label>套餐：</label> -->
<!-- 							<ul class="Package suit-list"> -->
<!-- 								<li data-val="22"><a class="PackActive">xxxxx</a></li> -->
<!-- 							</ul> -->
<!-- 						</div> -->
						<input type="hidden" name="suitid" value="<?php echo $suitPrice['suitid']; ?>">
						<input type="hidden" name="suitPriceId" value="<?php echo $suitPrice['dayid']?>">
						<input type="hidden" name="lineid" value="<?php echo $line['id'];?>">
						<div class="inputBox departRelative" style="display:inline-block;">
							
							<label for="">出发日期：</label>
<!-- 							<span >请选择</span> -->
							<span ><?php echo $suitPrice['day']?></span>
<!-- 							<ul class="departTime suit-price"> -->
<!-- 								<li data-val="333">2016-08-12</li> -->
<!-- 							</ul> -->
						</div>
						<?php if (!empty($onCar)):?>
                        <div class="inputBox">
							<label for="">集合地点：</label>
							<span>
								<?php
									$num = count($onCar)-1;
									foreach($onCar as $k =>$v){
										if ($num == $k) {
											echo $v['on_car'];
										} else{
											echo $v['on_car'].',';
										}
									}
								?>
							</span>
						</div>
						<?php endif;?>
						<?php if ($line['deposit'] > 0): ?>
                        <div class="inputBox">
							<label for="">定金：</label> 
							<span style="color:#f00;" class="deposit-price"><?php echo $line['deposit']?></span>
						</div>
						<?php endif;?>
						<div class="inputBox clear">
							<label for="" class="fl">预定人数：</label>
                            <div class="reserve_person_num fl">
                            	<div class="fl ">
                            		<span class="person_type fl"><?php echo $suitPrice['unit'] == 1 ? '成人' :$suitPrice['suitname'];?></span>
                            		<span class="preson_preice fl people-price"><?php echo $suitPrice['unit'] == 1 ? $suitPrice['adultprice'].'元/人' :$suitPrice['adultprice'].'元/'.$suitPrice['unit'].'人套餐';?></span>
                                	<div class="adultsNum fl">
             							<div class="adultsNumDown" onclick="changeTraverNum('dingnum',2,1 ,1)">-</div>
              							<div class="adultsNums">
              								<input type="text"  name="dingnum" class="travelNumber" style="ime-mode:disabled;"  maxlength="4" value="1">
              							</div>
              							<div class="adultsNumUp" onclick="changeTraverNum('dingnum',1,1 ,1)">+</div>
                                    </div>
                                    <div class="Settlement_pay">
                                    	<div class="settlenBox">
                                    		<span class="settlenTitle">结算价</span>
                                    		<?php if ($line['line_kind'] == 2 || $line['line_kind'] == 3):?>
                                    		<span class="settlenPay"><?php echo $suitPrice['adultprofit']?></span>
                                    		<?php else:?>
                                    		<span class="settlenPay"><?php echo round($suitPrice['adultprice'] - $suitPrice['agent_rate_int'] ,2)?></span>	
                                    		<?php endif;?>
                                    		<span class="settlenComp">元/人</span>	
                                    	</div>
                                    </div>



                                </div>
                                <?php if ($suitPrice['childprice'] > 0 && $suitPrice['unit'] ==1):?>
                                <div class="fl">
                                	<span class="person_type fl">儿童占床</span>
                                	<span class="preson_preice fl people-price"><?php echo $suitPrice['childprice']?>元/人</span>
                                	<div class="adultsNum fl">
             							<div class="childNumDown" onclick="changeTraverNum('childnum',2 ,0 ,3)">-</div>
              							<div class="childNums"><input type="text" name="childnum" class="travelNumber" style="ime-mode:disabled;" value="0" maxlength="3"></div>
              							<div class="childNumUp" onclick="changeTraverNum('childnum',1 ,0 ,3)">+</div>
                                    </div>
                                    <div class="Settlement_pay">
                                    	<div class="settlenBox">
                                    		<span class="settlenTitle">结算价</span>
                                    		<?php if ($line['line_kind'] == 2 || $line['line_kind'] == 3):?>
                                    		<span class="settlenPay"><?php echo $suitPrice['childprofit']?></span>
                                    		<?php else:?>
                                    		<span class="settlenPay"><?php echo round($suitPrice['childprice'] - $suitPrice['agent_rate_child'] ,2)?></span>	
                                    		<?php endif;?>
                                    		<span class="settlenComp">元/人</span>	
                                    	</div>
                                    </div>
                                    
                                </div>
                                <?php endif;?>
                                <?php if ($suitPrice['childnobedprice'] > 0 && $suitPrice['unit'] ==1):?>
                                <div class="fl">
                                	<span class="person_type fl">儿童不占床</span>
                                	<span class="preson_preice fl people-price"><?php echo $suitPrice['childnobedprice']?>元/人</span>
                                	<div class="adultsNum fl">
             							<div class="childNumDown2" onclick="changeTraverNum('childnobednum',2 ,0 ,4)">-</div>
              							<div class="childNums2"><input type="text" name="childnobednum" class="travelNumber" style="ime-mode:disabled;"  value="0"  maxlength="3"></div>
              							<div class="childNumUp2" onclick="changeTraverNum('childnobednum',1 ,0 ,4)">+</div>
                                    </div>
                                    <div class="Settlement_pay">
                                    	<div class="settlenBox">
                                    		<span class="settlenTitle">结算价</span>
                                    		<?php if ($line['line_kind'] == 2 || $line['line_kind'] == 3):?>
                                    		<span class="settlenPay"><?php echo $suitPrice['childnobedprofit']?></span>
                                    		<?php else:?>
                                    		<span class="settlenPay"><?php echo round($suitPrice['childnobedprice'] - $suitPrice['agent_rate_childno'] ,2)?></span>	
                                    		<?php endif;?>
                                    		<span class="settlenComp">元/人</span>	
                                    	</div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($suitPrice['oldprice'] > 0 && $suitPrice['unit'] ==1):?>
<!--                                 <div class="fl"> -->
<!--                                 	<span class="person_type fl">老人</span> -->
<!--                                 	<span class="preson_preice fl people-price"><?php //echo $suitPrice['oldprice'];?>元/人</span>
<!--                                 	<div class="adultsNum fl"> -->
<!--              							<div class="oldNumsDown" onclick="changeTraverNum('oldnum',2 ,0 ,2)">-</div>
<!--               							<div class="oldNums"><input type="text" name="oldnum"  value="0" class="travelNumber" style="ime-mode:disabled;" maxlength="3"></div>
<!--               							<div class="oldNumsUp" onclick="changeTraverNum('oldnum',1 ,0 ,2)">+</div>
<!--                                     </div> -->
<!--                                     <div class="Settlement_pay"> -->
<!--                                     	<div class="settlenBox"> -->
<!--                                     		<span class="settlenTitle">结算价</span> -->
                                    		<?php if ($line['line_kind'] == 2 || $line['line_kind'] == 3):?>
<!--                                     		<span class="settlenPay"><?php echo $suitPrice['oldprofit']?></span>
<!--                                     		<?php else:?>
<!--                                     		<span class="settlenPay"><?php echo round($suitPrice['oldprice'] - $line['agent_rate_int'] ,2)?></span>	
<!--                                     		<?php endif;?>
<!--                                     		<span class="settlenComp">元/人</span>	 -->
<!--                                     	</div> -->
<!--                                     </div> -->
<!--                                 </div> -->
                                <?php endif;?>
                            </div>
						</div>
						<div class="inputBox fl clear">
							<label for="name"><b style="color:#f30;">*</b>联系人：</label> <span> 
							<input type="text" id="name" maxlength="30" name="username" value=''  onkeyup="this.value=this.value.replace(/[^\w\u4e00-\u9fa5]+/g,'')" />
							</span>
						</div>
						<div class="inputBox fl">
							<label for=""><b style="color:#f30;">*</b>手机：</label> <span> <input maxlength="11"
								type="text" name="mobile" value='' />
							</span>
						</div>
						<div class="inputBox fl">
							<label for="">备用手机：</label> <span>
							<input type="text" maxlength="100" name="spare_mobile"/>
							</span>
						</div>
						<div class="inputBox fl">
							<label for="">邮箱：</label> <span> <input type="text" id="mail"
								maxlength="100" name="email" value='' />
							</span>
						</div>
						<div class="inputBox clear">
							<label for="">备注：</label>
							<textarea rows="" name="spare_remark" cols="" class="areaBox"></textarea>
						</div>
					</div>
				</div>

				<div class="itmeText itmeText-2">
                    <div class="huise_title" style="margin-bottom:20px;">
						<div class="titleText" style=" float:left; margin-right:10px;">收款信息</div>
						<p class="info" style=" float:left; line-height:40px;"></p>
                    </div>
                    <?php if ($depart['cash_limit'] > 0):?>
                    <div style="padding-left: 40px;padding-bottom: 20px;">
                    	<input type="hidden" name="isBalance" value="1">
<!--                     	<input type="checkbox" name="isBalance" value="1" checked="checked"> -->
                    	账户余额交款
                    	<?php 
                    		if ($suitPrice['adultprice'] >$depart['cash_limit']){
                    			$cash= $depart['cash_limit'];
                    			$msg = '余额不足';
                    		} else {
                    			$cash= $suitPrice['adultprice'];
                    			$msg = '余额充足';
                    		}
                    		// 押金订单
                    		if ($line['deposit'] > 0 && $line['deposit'] < $cash) {
                    			$cash = $line['deposit'];
                    			if ($line['deposit'] > $depart['cash_limit']) {
                    				$msg = '余额不足';
                    			} else {
                    				$msg = '余额充足';
                    			}
                    		}
                    	?>
                    	
                    	<input style="height: 22px;width:100px;  border: none;" type="text"  name="cash"  readonly="readonly" value="<?php echo  $cash?>">
                    	<span style="color:red;" class="depart-balance"><?php echo $msg?></span>
                    	
                    </div>
                    <?php endif;?>
                    
					<!-- <div class="tourist_info pading_le user-payment" <?php //if($suitPrice['adultprice'] < $depart['cash_limit']) {echo "style='display:none;'";} ?>> -->
					<div class="tourist_info pading_le user-payment" style='display:none;'>
						<div class="rb-row" style="width: 15%;">
							<label>收款金额</label>
							<input type="text" name="rb_money" style="width:100px;">
						</div>
						<div class="rb-row">
							<label>备注</label>
							<input type="text" name="rb_remark">
						</div>
						<div class="rb-row" style="width:42%;">
							<label>交款方式</label>
							<select name="rb_way">
								<option value="转账">转账</option>
								<option value="现金">现金</option>
							</select>
							<input type="text" name="rb_bankname" value="<?php echo empty($bankData['bankname']) ? '' : $bankData['bankname']?>" placeholder="银行名称" style="margin-left: -3px;">
							<input type="text" name="rb_bankcard" maxlength="19" value="<?php echo empty($bankData['bankcard']) ? '' : $bankData['bankcard']?>" placeholder="银行卡号" style="margin-left: -2px;width: 200px;">
						</div>
						<div class="rb-row">
							<label>流水单</label>
							<input type="file" name="upload_pic" id="upload_pic" onchange="uploadPic(this)" value="" style="width: 76%;">
							<input type="hidden" name="rb_pic" value="">
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
			                  	<li style="margin-right:0px;">姓名</li>
			                  	<li style="margin-right:0px; width:75px;">性别</li>
			              		<li>证件类型</li>
			              		<li>证件号码</li>
			              		<li>出生日期</li>
			              		<li>手机号码</li>
			              		<li style="padding:0;">出游人类型</li>
			              	</ul>
		              	</div>
     			 </div>
                 	<!--第二种表格 -->
                 <div class="jingwaide_Table traver_list2" style="display:none;">
                 	<ul style=" border-top:1px solid #ccc" class="bord_red">
                    	<li class="grade">编号</li>
                        <li class="chinese_name">姓名</li>
                        <li class="english_name">英文名</li>
                        <li class="gender">性别</li>
                        <li class="id_type">证件类型</li>
                        <li class="zhengjian_number">证件号</li>
                         <li class="date_birth">出生日期</li>
                        <li class="issue_di">签发地</li>
                        <li class="issue_date">签发日期</li>
                        <li class="validity">有效期至</li>
                        <li class="phone_number">手机号</li>
                        <li class="chuyou_info">出游人类型</li>
                    </ul>

                 </div>
			</div>
			<input type="hidden" name="insurance" value="">
			<?php if (!empty($insuranceData)):?>
			<div class="itmeText itmeText-4">
				<div class="titleText">保险方案</div>
              	<div class="pading_le whid_1000"></div>
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
					                <li style="width:100px;" class="insurance-number" data-num="1">                                        
					                1
					                </li>
					                <li style=" width:365px;" class="bdBoxx"> 
					                	<?php echo str_cut($val['simple_explain'],80)?>
					                </li>
					                <li style=" width:115px;"><?php echo $line['lineday']?>天</li>
					                <li style=" width:115px;" class="insurance-price" data-price="<?php echo $val['settlement_price']?>"><?php echo $val['settlement_price']?>元</li>
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
						</div>
						<div class="itme_House_list">
							<!-- 保存专家ID -->
							<input type="hidden" name="expert_id" value="<?php echo $expert['id']?>" />
							<ul class="line_expert">
							<li class="list_click">
								<img title="" src="<?php echo $expert['small_photo']?>">
									<div class="itme_House_xingxi">
                                                                            <!-- guanj改为guanjia,添加后缀.html 魏勇编辑-->
										<div class="Housek_name"><a href="/guanjia/<?php echo $expert['id'].'.html' ?>" target="_blank"><?php echo $expert['nickname']?></a></div>
										<div class="Housek_Level">
									<?php
								if ($expert['grade'] == 1) {
									echo '管家';
								} elseif ($expert['grade'] == 2) {
									echo '初级专家';
								} elseif ($expert['grade'] == 3) {
									echo '中级专家';
								} elseif ($expert['grade'] == 4) {
									echo '高级专家';
								}
								?>
                               
                                </div>
                                	 <div class="weixuanzhong" style="display:none;"></div>
								</div>
                            </li>
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
<!--                 <div class="itmeText itmeText-4"> -->
<!-- 					<div class="titleText">在线合同<span style="color:#f30; font-weight:normal; padding-left:12px;">请仔细阅读旅游合同，具体出游信息以您填写的订单为准。</span></div>-->
<!--                     <div class="gundong_tract"> -->
<!--                        <div class="p_box_act"><?php //if ($linetype == 1){echo $webData[0]['travel_contract_abroad'];} else {echo $webData[0]['travel_contract_domestic'];} ?></div>-->
<!--                     </div> -->
<!-- 				</div> -->
				
				</div>
			</div>
		</div>
		<div class="dingdanDou">
<!-- 			<div class="dingdan_xieyi"> -->
<!-- 				<input type="checkbox" name="agree_check" value="1"> -->
<!-- 				<span>我已阅读并接受以上电子合同条款、保险条款、安全提示和其他所有内容，无需再次签署纸质合同</span> -->
<!-- 			</div> -->
	</div>
<!--尾部-->
<!-- 额度申请数据保存 -->
<input type="hidden" name="applyType">
<input type="hidden" name="applyQuota">
<input type="hidden" name="returnTime">
<input type="hidden" name="remarkText">

<input type="hidden" name="orderType" value="1">
<!-- end 额度申请数据保存 -->

<!--固定定位的金额浮动-->
	<div class="fixDicog">
		<div class="floatFootText">【临时保存】订单不提交供应商，可以修改价格后再提交，【确认订单】将直接扣款<span class="price-prompt" style="font-size:17px;"></span>元账户余额并直接确认给供应商</div>
	    <div class="float_bottom">
	        <div class="float_con">
	            <!-- 将cj和gn改为line,添加后缀.html-->
	            <div class="flocon_le"><a href="<?php echo in_array(1 ,explode(',',$line['overcity'])) ? '/line/'.$line['id'].'.html' : '/line/'.$line['id'].'.html';?>"><&nbsp;返回</a></div>
	            <div class="flocon_ri">
	                <div class="yingfu" style="margin-left:10px;">利润<span class="profitMoney">¥1</span></div>
	                <div class="yingfu" style="margin-left:10px;">总应付<span class="costMoney">¥1</span></div>
	                <div class="yingfu">应收金额<span class="orderCountMoney" data-price="">¥<?php echo $suitPrice['adultprice']?></span></div>
	                <div class="zhengdao orderMoneyInfo" >团费¥<?php echo $suitPrice['adultprice']?>&nbsp;+保险¥0&nbsp;</div>
	            </div>
	        </div>
	        <div class="float_lin">
	        	<input type="button" id="temporary" value="临时保存" />
	        </div>
	        <div class="float_btn">
	        	<input type="submit" value="确认下单">
	        </div>
	    </div>
    </div>
    </form>
    
<!-- 管家申请额度 -->
<div class="fb-content" id="apply-quota" style="display:none;">
    <div class="box-title">
        <h4>申请信用额度</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="expert-apply-quota" class="form-horizontal">
            <div class="form-group">
            	<div style="color: red;">
            		<span style="margin-right: 15px;">营业部现金额度：<span class="depart-cash-limit" >2000</span></span>
            		<span>营业部信用额度：<span class="depart-credit-limit">2000</span></span>
            	</div>
            	<div class="fg-over" style=" overflow: hidden;">
            		<div class="fg-title"><i>*</i>申请对象：</div>
                	<div class="fg-input">
                		<select name="apply_type">
                			<option value="0">请选择</option>
                			<option value="1">旅行社-<?php echo $expert['union_name']?></option>
                			<option value="2">供应商-<?php echo $supplier['company_name']?></option>
                		</select>
                	</div>
            	</div>
            	<div class="fg-over chiose-supplier" style=" overflow: hidden;display:none;">
            		<div class="fg-title"><i>*</i>选择供应商：</div>
                	<div class="fg-input">
                		<select name="apply_supplier">
                			<option value="0">请选择</option>
                			<?php 
//                 				foreach($unionSupplier as $v) {
//                 					echo '<option value="'.$v['supplier_id'].'">'.$v['supplier_name'].'</option>';
//                 				}
                			?>
                		</select>
                	</div>
            	</div>
            	<div class="fg-over" style=" overflow: hidden;">
            		<div class="fg-title"><i>*</i>还款日期：</div>
                	<div class="fg-input"><input type="text" name="return_time" readonly id="return_time" ></div>
            	</div>
            	<div class="fg-over" style=" overflow: hidden;">
            		<div class="fg-title"><i>*</i>申请额度：</div>
                	<div class="fg-input"><input type="text" disabled="disabled" name="quota" ></div>
            	</div>
            	<div class="fg-over">
            		<div class="fg-title"><i>*</i>申请理由：</div>
                	<div class="fg-input"><textarea name="remark" ></textarea></div>
                </div>
                <div class="fg-over" style="text-align: center; padding-left:30px">
                	<input type="submit" class="fg-but fg-btn " value="申请并提交">
<!--                 	<input type="button" id="no-apply" class="fg-but fg-btn " value="不申请并提交"> -->
	            	<input type="hidden" name="apply_id" value="<?php echo $expert['id']?>">
	            	<input type="button" class="fg-but fg-btn layui-layer-close" value="取消">
                </div>
                
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>/static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>/static/js/id_card.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>

<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>

<!--上传excel文件-->
<script src="<?php echo base_url('static'); ?>/js/eject_sc.js" type="text/javascript"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<!--end-->

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
$('input[name=rb_money]').verifNum({digit:2});
$('input[name=rb_bankcard]').verifNum();

//交款金额验证
$('input[name=rb_money]').keyup(function(e){
	var money = $(this).val()*1;//填写金额
	var price = $('.orderCountMoney').attr('data-price')*1; //订单金额
	var balance = $('input[name=cash]').val()*1;//现金余额交款
	
	if ($('input[name=isBalance]').is(':checked')) {
		//用户使用现金余额交款
		var difference = price-balance;
	} else {
		//用户不使用现金余额交款
		var difference = price;
	}
	if (money > difference) {
		$(this).val(difference);
	}
})

$('input[name=isBalance]').click(function(){
	if ($('input[name=isBalance]').is(':checked')) {
		//选中
		var balance = $('input[name=cash]').val()*1;//现金余额交款
		var price = $('.orderCountMoney').attr('data-price')*1; //订单金额
		
		if (price > balance) {
			//$('.user-payment').show(); //订单金额大于用户使用余额交款金额则显示交款输入框
		} else {
			//$('.user-payment').hide();
		}
	} else  {
		//不选中
		//$('.user-payment').show();
	}
})


//选择交款方式
$('select[name=rb_way]').change(function(){
	var way = $(this).val();
	if (way == '转账') {
		$(this).nextAll('input').show();
	} else {
		$(this).nextAll('input').hide();
	}
});
//上传交款流水单
function uploadPic(obj){
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadImgFile',
	    secureuri : false,
	    fileElementId : 'upload_pic',// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : { fileId : 'upload_pic' },
	    success : function(data, status) {
		    if (data.code == 2000) {
			    $('input[name=rb_pic]').val(data.msg);
			    layer.alert('上传成功', {icon: 1,title:'成功提示'});
		    } else {
		    	layer.alert(data.msg, {icon: 2,title:'错误提示'});
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
	    	layer.alert('上传失败(请选择jpg/jpeg/png的图片重新上传)', {icon: 2,title:'错误提示'});
	    }
	});
}


var priceJson = <?php echo  empty($priceArr) ? '{}' : json_encode($priceArr)?>;
var suitJson = <?php echo  empty($suitArr) ? '{}' : json_encode($suitArr)?>;
var adultprice = <?php echo $suitPrice['adultprice']?>;
var childprice = <?php echo $suitPrice['childprice']?>;
var childnobedprice = <?php echo $suitPrice['childnobedprice']?>;
var oldprice = <?php echo empty($suitPrice['oldprice']) ? 0 :$suitPrice['oldprice']?>;
var unit = <?php echo $suitPrice['unit'];?>;
var linetype = <?php echo $linetype;?>;
var certificate = <?php echo json_encode($certificate) ?>;
var agent_rate_int = <?php echo $suitPrice['agent_rate_int'];?>;//成人佣金
var agent_rate_child = <?php echo $suitPrice['agent_rate_child'];?>;//小孩佣金
var agent_rate_childno = <?php echo $suitPrice['agent_rate_childno'];?>;//小孩佣金
var line_kind = <?php echo $line['line_kind']?>;//产品类型
var childprofit = <?php echo empty($suitPrice['childprofit']) ? 0 : $suitPrice['childprofit']?>;
var childnobedprofit = <?php echo empty($suitPrice['childnobedprofit']) ? 0 : $suitPrice['childnobedprofit']?>;
var adultprofit = <?php echo empty($suitPrice['adultprofit']) ? 0 : $suitPrice['adultprofit']?>;
var oldprofit = <?php echo empty($suitPrice['oldprofit']) ? 0 : $suitPrice['oldprofit']?>;
var cash_limit = <?php echo empty($depart['cash_limit']) ? 0 : $depart['cash_limit']?>; //营业部现金额度
var deposit = <?php echo empty($line['deposit']) ? 0 : $line['deposit']?>;//押金
$('input[name=quota]').verifNum();
//$('input[name=cash]').verifNum({maxNum:cash_limit});

//申请额度
var s = true;
$('#expert-apply-quota').submit(function(){
	if (s == false) {
		return false;
	} else {
		s = false;
	}
	var index = layer.msg('下单中，请稍后', { icon: 16, shade: 0.8,time: 200000 });
	$('input[name=applyType]').val($(this).find('select[name=apply_type]').val());
	$('input[name=applyQuota]').val($(this).find('input[name=quota]').val());
	$('input[name=returnTime]').val($(this).find('input[name=return_time]').val());
	$('input[name=remarkText]').val($(this).find('textarea[name=remark]').val());
	$('input[name=orderType]').val(2);
	
	$.ajax({
		//url:'/order_from/order_info/createOrderB2Apply',
		url:'/order_from/order_info/createOrderB2_test',
		data:$('#submit-order').serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			layer.close(index);
			s = true;
			if (result.code == 2000) {
				location.href="/order_from/order_info/success_b2/"+result.orderid;
			} else if (result.code == 6000){
				$('#expert-apply-quota').find('input[name=quota]').val(result.quota);
				$('.depart-cash-limit').html(result.cash_limit);
				$('.depart-credit-limit').html(result.credit_limit);
				layer.alert(result.msg, {icon: 2,title:'错误提示'});
			}else {
				layer.alert(result.msg, {icon: 2,title:'错误提示'});
			}
		}
	});
	return false;
})

//临时保存
var tem = true;
$('#temporary').click(function(){
	if (tem == false) {
		return false;
	} else {
		tem = false;
	}
	var index = layer.msg('下单中，请稍后', { icon: 16, shade: 0.8,time: 200000 });
	$('input[name=orderType]').val(3);
	$.ajax({
		//url:'/order_from/order_info/createOrderB2NoApply',
		url:'/order_from/order_info/createOrderB2_test',
		data:$('#submit-order').serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			layer.close(index);
			tem =true;
			if (result.code == 2000) {
				location.href="/order_from/order_info/success_b2/"+result.orderid;
			} else {
				layer.alert(result.msg, {icon: 2,title:'错误提示'});
			}
		}
	});
})

//提交订单
var so = true;
$('#submit-order').submit(function(){
	if (so == false) {
		return false;
	} else {
		so = false;
	}
	var index = layer.msg('下单中，请稍后', { icon: 16, shade: 0.8,time: 200000 });
	var insurance = '';
	$('.insurance-list .overok').each(function(){
		insurance += $(this).attr("data-val")+',';
	})
	$('input[name=insurance]').val(insurance);
	$('input[name=orderType]').val(1);
// 	$('input[name=orderType]').val(3);
	$.ajax({
		//url:'/order_from/order_info/createOrderB2',
		url:'/order_from/order_info/createOrderB2_test',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		complete:function(){//ajax请求结束时操作
			so = true;
		},
		success:function(result) {
			layer.close(index);
			if (result.code == 2000) {
				location.href="/order_from/order_info/success_b2/"+result.orderid;
			} 
			else if (result.code == 4005){
				//营业部现金余额不足
				layer.alert('现金余额小于您所填写的数值', {icon: 2,title:'错误提示'});
				$('input[name=cash]').verifNum({maxNum:result.msg,digit:2});
				$('.depart-balance').html('余额不足');
			}
			else if (result.code == 5000) {
				$('input[name=quota]').val(result.money);
				$('.depart-cash-limit').html(result.cash_limit);
				$('.depart-credit-limit').html(result.credit_limit);
				//营业部额度不足,管家没有申请额度
				layer.confirm('额度不足', 
						{btn: ['申请额度','取消']},
// 						{btn: ['申请额度','不申请，临时保存订单','取消']},
						function(index){
							layer.close(index);
							layer.open({
								  type: 1,
								  title: false,
								  closeBtn: 0,
								  area: '560px',
								  shadeClose: false,
								  content: $('#apply-quota')
							});
						}, 
// 						function(){
// 							//不申请额度，但提交订单
// 							var no = true;
// 							if (no == true) {
// 								if (no == false) {
// 									return false;
// 								} else {
// 									no = false;
// 								}
// 								$.ajax({
// 									url:'/order_from/order_info/createOrderB2NoApply',
// 									data:$('#submit-order').serialize(),
// 									dataType:'json',
// 									type:'post',
// 									success:function(result) {
// 										no =true;
// 										if (result.code == 2000) {
// 											location.href="/order_from/order_info/success_b2/"+result.orderid;
// 										} else {
// 											layer.alert(result.msg, {icon: 2,title:'错误提示'});
// 										}
// 									}
// 								});
// 							}
// 						}, 
						function(){}
					);
				//layer.alert('您的额度不足以抵扣当前订单价格，请交款或申请额度！', {icon: 2,title:'错误提示'});
			} else if (result.code == 6000){
				//营业部额度不足,管家了申请额度但额度不足
				layer.alert('你当前的额度不足抵扣本次团款，请充值或重新申请额度！', {icon: 2,title:'错误提示'});
			} else if (result.code == 7000) {
				//营业部额度不足,管家有正在申请中额度的记录
				//您有正在申请中的信用额度，请先处理
				layer.alert('您有正在申请中的信用额度，请先处理', {icon: 2,title:'错误提示'});
			}else {
				layer.alert(result.msg, {icon: 2,title:'错误提示'});
			}
		}
	});
	return false;
})
$('#return_time').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		validateOnBlur:false
	});


//出游人数量更改 {1:'成人',2:'老人',3:'儿童占床',4:'儿童不占床'};
$(".travelNumber").keyup(function(){
	var number = $(this).val().replace(/[^\d]/g,'');
	var name = $(this).attr('name');
	if (name == 'dingnum') {
		var type = 1;
	} else if (name == 'childnum') {
		var type = 3;
	} else if (name == 'childnobednum') {
		var type = 4;
	} else if (name == 'oldnum') {
		var type = 2;
	}
	$(this).val(number);
	getOrderMoney();
	//getTravelHtml(type);
}).blur(function(){
	var name = $(this).attr("name");
	var number = $(this).val();
	
	if (number.length == 0) {
		if (name == "dingnum") {
			$(this).val(1);
			getOrderMoney();
			getTravelHtml(1);
		} else {
			$(this).val(0);
		}
	} else {
		if (name == 'dingnum') {
			var type = 1;
		} else if (name == 'childnum') {
			var type = 3;
		} else if (name == 'childnobednum') {
			var type = 4;
		} else if (name == 'oldnum') {
			var type = 2;
		}
		
		getTravelHtml(type);
	}
})

/**
 * @method 更改出游人数量
 * @param  inputName 计算后的数字显示的input的name值
 * @param  type  加减的类型   1：加     2：减
 * @param  people_type 出游人类型
 * @param minNum 显示的最小值
 */
function changeTraverNum(inputName ,type ,minNum ,people_type) {
	var minNum = typeof minNum == 'undefined' ? 0 : minNum;
	var inputObj = $("input[name='"+inputName+"']");
	var oldNum = Math.round(inputObj.val());
	var nowNum = type == 1 ? Math.round(oldNum + 1) : Math.round(oldNum - 1);
	if (nowNum < minNum || nowNum > 9999) {
		return false;
	}
	inputObj.val(nowNum);
	getOrderMoney();
	getTravelHtml(people_type);
}

getOrderMoney();
//计算订单价格并返回总人数
function getOrderMoney() {
	var insuranceMoney = 0;//保费
	var travelMoney = 0;//出游人价格
	var numArr = getCountPeople();
	//更改保险人数
	$('.insurance-number').text(Math.round(numArr.count*unit));
	//订单的出游人总价格
	travelMoney = (numArr.dingnum*adultprice + numArr.childnum*childprice + numArr.childnobednum*childnobedprice + numArr.oldnum*oldprice).toFixed(0)*1;

	//管家佣金(利润)
	if (line_kind == 2 || line_kind == 3) {
		var adultAgent = numArr.dingnum*(adultprice-adultprofit);
		var oldAgent = numArr.oldnum*(oldprice-oldprofit);
		var childAgent = numArr.childnum*(childprice-childprofit);
		var childnobedAgent = numArr.childnobednum*(childnobedprice-childnobedprofit);
		
		var profit = (adultAgent+oldAgent+childAgent+childnobedAgent).toFixed(2);
	} else {
		var profit = ((numArr.dingnum+numArr.oldnum)*agent_rate_int + numArr.childnum*agent_rate_child + numArr.childnobednum*agent_rate_childno).toFixed(2);
	}
	
	//供应商成本(应付金额)
	var costMoney = (travelMoney - profit).toFixed(2);
	//保险
	$('.insurance-list .overok').each(function() {
		var price = $(this).parent().prev().attr('data-price');//保险单价
		insuranceMoney = (insuranceMoney + price*numArr.count*unit).toFixed(2)*1;
	})

	//总价格
	var countMoney = (travelMoney*1 + insuranceMoney*1).toFixed(2);
	if (countMoney <= 0) {
		countMoney = 0;
	}
	
	if (deposit > 0) {
		//线路有押金
		//总押金
		var countDeposit = (numArr.dingnum+numArr.oldnum+numArr.childnum+numArr.childnobednum)*deposit;
		$('.deposit-price').html(countDeposit.toFixed(2));
		//营业部现金余额大于总押金
		if (cash_limit >= countDeposit) {
			//用户可以输入的现金余额为总押金
			var maxCash = countDeposit;
		}
	}
	
	//有押金的情况或者押金总额小于营业部现金余额
	if (typeof maxCash == 'number') {
		if (countMoney > maxCash) {
			//$('.user-payment').show();
			$('input[name=cash]').val(maxCash);
			
			$('input[name=cash]').unbind().verifNum({maxNum:maxCash,digit:2});

			if (maxCash < cash_limit) {
				$('.depart-balance').html('余额充足');
			} else {
				$('.depart-balance').html('余额不足');
			}
		} else {
			//$('.user-payment').hide();
			$('input[name=cash]').val(countMoney);
			$('input[name=cash]').unbind().verifNum({maxNum:countMoney,digit:2});
			if (countMoney < cash_limit) {
				$('.depart-balance').html('余额充足');
			} else {
				$('.depart-balance').html('余额不足');
			}
		}
	} else {
		if (countMoney > cash_limit) {
			//$('.user-payment').show();
			$('input[name=cash]').val(cash_limit);
			$('.depart-balance').html('余额不足');
			$('input[name=cash]').unbind().verifNum({maxNum:cash_limit,digit:2});
		} else {
			//$('.user-payment').hide();
			$('input[name=cash]').val(countMoney);
			$('.depart-balance').html('余额充足');
			$('input[name=cash]').unbind().verifNum({maxNum:countMoney,digit:2});
			
		}
	}

	$('.price-prompt').html(countMoney);
	$(".costMoney").html("¥"+costMoney);
	$(".profitMoney").html("¥"+profit);
	$(".orderCountMoney").html("¥"+countMoney).attr('data-price' ,countMoney);
	$(".orderMoneyInfo").html("团费¥"+travelMoney+"&nbsp;+保险¥"+insuranceMoney+"&nbsp;");
}
//选择保险
$(".overoff").click(function(){
	$(this).toggleClass("overok");
	getOrderMoney();//计算订单价格
})

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
//初始化人数
function initPeopleNum() {
	$('input[name=dingnum]').val(1);
	$('input[name=childnum]').val(0);
	$('input[name=childnobednum]').val(0);
	$('input[name=oldnum]').val(0);
}

//初始化出游人信息栏
initTravelInput();
function initTravelInput() {
	var dingnum = $('input[name=dingnum]').val();
	var childnum = $('input[name=childnum]').val();
	var childnobednum = $('input[name=childnobednum]').val();
	var oldnum = $('input[name=oldnum]').val();

	var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1");
	var len = travelObj.find('ul').length;

	var i = 0;
	dingnum = (dingnum*unit).toFixed(0);
	for(i ;i<dingnum ;i++) {
		
		if (linetype == 1) {
			createAbroad(1 ,len);
		} else {
			createDomestic(1 ,len);
		}
		len ++;
	}
	var i = 0;
	for(i ;i<childnum ;i++) {
		
		if (linetype == 1) {
			createAbroad(3 ,len);
		} else {
			createDomestic(3 ,len);
		}
		len ++;
	}
	var i = 0;
	for(i ;i<childnobednum ;i++) {
		
		if (linetype == 1) {
			createAbroad(4 ,len);
		} else {
			createDomestic(4 ,len);
		}
		len ++;
	}
	var i = 0;
	for(i ;i<oldnum ;i++) {
		
		if (linetype == 1) {
			createAbroad(2 ,len);
		} else {
			createDomestic(2 ,len);
		}
		len ++;
	}
	
}

var t;
var totalNum=0;
var load_index;
//生成出游人的信息填写栏
function getTravelHtml(people_type) {
	var numArr = getCountPeople();
	var number = numArr.count * unit;//unit 是多少人一份  线路套餐
	var people_type = people_type || 1;
	//console.log(number);
	var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1");
	var len = travelObj.find('ul').length;
	len = len == 0 ? 1 : len;
	
	if (number == 0) {
		travelObj.find('ul').eq(0).nextAll().remove();
		return false;
	} else if (len > number) { //填写栏大于出游人数，删除多余的填写栏
		var i = len - number -1;
		var a = 0;
		for(a ;a<i ;a++) {
			travelObj.find(".people_type_"+people_type).last().remove();
		}
		return false;
	}
	load_index = layer.msg('名单加载中', { icon: 16, shade: 0.8,time: 200000 });

	if (linetype == 1) { //境外
// 		for(len ; len<= number ;len++) {
// 			createAbroad(people_type ,len);
// 		}
		//加载层-风格4
// 		var intv = setInterval(function(){
// 			if(len<= number){
// 				createAbroad(people_type ,len);
// 				len++;
// 			}else{
// 				clearInterval(intv);
// 				layer.close(load_index);     
// 			}
// 	    }, 5);
		totalNum = len;
		forEeachAbroad(number,people_type);
	} else { //境内
// 		for(len ; len<= number ;len++) {
// 			createDomestic(people_type ,len);
// 			if(number%100){
// 				setTimeout()
// 			}
// 		}
		totalNum = len;
		forEeachDomestic(number,people_type);
		     
// 		var intv = setInterval(function(){
// 			if(len<= number){
// 				createDomestic(people_type ,len);
// 				len++;
// 			}else{
// 				clearInterval(intv);
// 				layer.close(load_index);
// 			}
// 	    }, 5);
	}
}

function forEeachDomestic(number,people_type){
	for(totalNum ; totalNum<= number ;totalNum++) {
		if(totalNum%30==0){
			clearTimeout(t);
			createDomestic(people_type ,totalNum);
			if(totalNum>=number){
				layer.close(load_index);
			}
			totalNum++;
			t=setTimeout("forEeachDomestic("+number+","+people_type+")",50);
			break;
		}else{
			createDomestic(people_type ,totalNum);
			if(totalNum>=number){
				layer.close(load_index);
			}
		}
	}
}

function forEeachAbroad(number,people_type){
	for(totalNum ; totalNum<= number ;totalNum++) {
		if(totalNum%30==0){
			clearTimeout(t);
			createAbroad(people_type ,totalNum);
			if(totalNum>=number){
				layer.close(load_index);
			}
			totalNum++;
			t=setTimeout("forEeachDomestic("+number+","+people_type+")",50);
			break;
		}else{
			createAbroad(people_type ,totalNum);
			if(totalNum>=number){
				layer.close(load_index);
			}
		}
	}
}

function createAbroad(people_type ,len) {
	var typeArr = {1:'成人',2:'老人',3:'儿童占床',4:'儿童不占床'};
	var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1");
	
	var html = '<ul class="people_type_'+people_type+'">';
	html += '<li class="grade">'+len+'</li>';
	html += '<li class="chinese_name"><input type="text" name="name[]"></li>';
	html += '<li class="english_name"><input type="text" name="enname[]" placeholder="护照的英文名"></li>';

    html += '<li class="gender">';
    html += '<select name="sex[]">';
	html += '<option value="2" selected="selected">选择</option>';
	html += '<option value="1">男</option>';
	html += '<option value="0">女</option></select></li>';
	html += '<li class="id_type"><select name="card_type[]" style="width: 80px;"><option value="0">请选择</option>';
	$.each(certificate ,function(key ,val) {
		html += '<option value="'+val.dict_id+'" style="max-width: 80px;">'+val.description+'</option>';
	})
	html += '</select></li>';
	html += '<li class="zhengjian_number"><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]"></li>';
	html += '<li class="date_birth"><input type="text" id="datetimepicker'+len+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]" ></li>';
	html += '<li class="issue_di"><input type="text" name="sign_place[]" maxlength="11"></li>';
	html += '<li class="issue_date"><input type="text" id="sign_time'+len+'" class="date-time" name="sign_time[]" maxlength="10"></li>';
	html += '<li class="validity"><input type="text" id="endtime'+len+'" class="date-time" name="endtime[]" maxlength="10"></li>';
	html += '<li class="phone_number"><input type="text" name="tel[]" maxlength="11"></li>';
    html += '<li class="chuyou_info">'+typeArr[people_type]+'</li>';
	html += '<input type="hidden" name="people_type[]" value="'+people_type+'">';
	html += "</ul>"
		travelObj.append(html).show();
		$('#datetimepicker'+len).datetimepicker({
			lang:'ch', //显示语言
			timepicker:false, //是否显示小时
			format:'Y-m-d', //选中显示的日期格式
			formatDate:'Y-m-d',
			validateOnBlur:false,
			yearStart:1930
		});
		$('#endtime'+len).datetimepicker({
			lang:'ch', //显示语言
			timepicker:false, //是否显示小时
			format:'Y-m-d', //选中显示的日期格式
			formatDate:'Y-m-d',
			validateOnBlur:false
		});
		$('#sign_time'+len).datetimepicker({
			lang:'ch', //显示语言
			timepicker:false, //是否显示小时
			format:'Y-m-d', //选中显示的日期格式
			formatDate:'Y-m-d',
			validateOnBlur:false
		});
		$('.date-time').isDate();
}

function createDomestic(people_type ,len) {
	var typeArr = {1:'成人',2:'老人',3:'儿童占床',4:'儿童不占床'};
	var travelObj = linetype == 1 ? $(".traver_list2") : $(".traver_list1");

	var html = '<ul class="people_type_'+people_type+'">';
	html += '<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">'+len+'</li>';
	html += '<li><input type="text" name="name[]"></li>';
   	html += '<li style="margin-right:0px; width:75px;">';
   	html += '<select name="sex[]">';
	html += '<option value="2" selected="selected">请选择</option>';
	html += '<option value="1">男</option>';
	html += '<option value="0">女</option></select></li>';
	html += '<li><select  name="card_type[]">';
	html += '<option value="0" style="width: 80px;">请选择</option>';
	$.each(certificate ,function(key ,val) {
		html += '<option value="'+val.dict_id+'" style="max-width: 80px;">'+val.description+'</option>';
	})
	html += '</select></li>';
	html += '<li><input type="text" onblur="birthday(this)" class="zhengjian_pt" name="card_num[]"></li>';
    html += '<li><input type="text" id="datetimepicker'+len+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]"></li>';
    html += '<li><input type="text" name="tel[]" maxlength="11"></li>';
    html += '<li style="padding:0;">';
    html += '<a href="javascript:void(0);" class="btn-del" >'+typeArr[people_type]+'</a>';
    html += '<input type="hidden" name="people_type[]" value="'+people_type+'">';
    html += '</li></ul>';
   
    travelObj.append(html)
    travelObj.show().parent().show();
    $('#datetimepicker'+len).datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		validateOnBlur:false
	});
    $('.date-time').isDate();
}

</script>
<script type="text/javascript">
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
				//alert('上传成功!');
				var start = 1;
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
					
					var ulObj = travelObj.find('ul').eq(start);
					ulObj.find('input[name="name[]"]').val(value.name);
					ulObj.find('input[name="card_num[]"]').val(value.card_num);
					ulObj.find('input[name="birthday[]"]').val(value.birthday);
					
					$.each(ulObj.find('select[name="sex[]"]').find('option'),function() {
						if ($(this).text() == value.sex) {
							$(this).attr('selected','selected');
						}
					})
					$.each(ulObj.find('select[name="card_type[]"]').find('option'),function() {
						if ($(this).text() == value.card_type) {
							$(this).attr('selected','selected');
						}
					})
					if (linetype == 1) {
						ulObj.find('input[name="tel[]"]').val(value.phone_number);
						ulObj.find('input[name="enname[]"]').val(value.enname);
						ulObj.find('input[name="sign_place[]"]').val(value.sign_place);
						ulObj.find('input[name="sign_time[]"]').val(value.sign_time);
						ulObj.find('input[name="endtime[]"]').val(value.endtime);
					} else {
						ulObj.find('input[name="tel[]"]').val(value.tel);
					}
					start ++;
				});
			
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
});


</script>
</body>
</html>





