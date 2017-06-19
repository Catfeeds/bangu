<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>私人旅游定制_公司旅游定制_定制旅游线路—帮游旅行网</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="私人旅游定制,公司旅游定制,定制旅游线路" />
<meta name="description" content="帮游旅行网为广大出游客户提供专业时尚深入体验的私人旅游方案定制，公司旅游方案定制，优质个性旅游线路定制服务" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url("static/css/common.css")?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url("static/css/Custom_details.css")?>" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url("static/js/jquery-1.7.2.min.js")?>"></script>
<body class="body_content">
<div class="main_body"> 
<?php $this->load->view('common/header'); ?>
    <div class="main_con"> 
        <!--当前位置 -->
		<div class="place">
			<span>您的位置：</span>
			<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>
			<span class="_jiantou">></span>
			<a href="/line/line_custom/index" target="_blank" >定制列表</a>
			<span class="_jiantou">></span>
			<h1><a href="#" target="_blank" >定制单</a></h1>
		</div>
		<form action="" method="post" id="custom_form">
        <div class="comon_con"> 
            <!--上面管家 信息（选定） -->
            <div class="exp_title"><img src="../../../static/img/page/dz_wenzi.png"></div>
             <?php if (!empty($customArr['expert_id'])):?>
            <div class=" w_600 marg_auto relative over_hidd">
                <div class="w_300">
                    <div class="Selected_exp">选定该管家进行定制</div>
                    <div class="chosen"><img src="<?php echo $customArr['small_photo'];?>"></div>
                </div>
                <div class="w_300 fl">
                    <div class="rex_name"><span><?php echo $customArr['nickname']?></span></div>
                    <div class="rex_faction">满意度&nbsp;:&nbsp;<span><?php echo round($customArr['satisfaction_rate'] * 100);?>%</span></div>
                    <div class="rex_Integral">总积分&nbsp;:&nbsp;<span><?php echo $customArr['total_score']?></span></div>
                </div>
                <input type="hidden" name="expert_id" value="<?php echo $customArr['expert_id']?>">
            </div>
            <?php endif;?>
            <div class="input_box">
            	<div class="where_to_play">
            		<!--您想去那玩-->
            		<div class="to_play_title">您想去哪儿玩</div>
            		<!--出发城市-->
            		<div class="cust_input_box">
            			<div class="play_input_list">									<!--list_input 是重复外层的 div这个可以循环-->
            				<div class="to_play_list_name"><i>*</i>出发城市</div>     		<!--这个是左面的title_name  名字-->
            				<div class="wid_box">  										<!--给这个设定一个属性 和 下面点击的input一样的宽度    **1  --> 	
            					<div class="to_play_input">                 			<!--事件的input box 所有事件都用 这个 -->
            						<input type="text" name="startplace" value="<?php echo $customArr['cityname']?>" id="custom_startcity"/>
            						<input type="hidden" name="startcityId" id="startcityId" value="<?php echo $customArr['startplace']?>" />								
            					</div>
            				</div>
            			</div>
            			<!--目的地-->
            			<div class="play_input_list" style=" padding: 0;">								
            				<div class="to_play_list_name"><i>*</i>目的地</div>     	
            				<div class="to_play_input">
            					<div class="mudidi_input">
            						<input type="text" name="destOne" value="<?php echo $customArr['custom_type']?>" readonly class="mudidi_one" placeholder="出境/周边/国内"/>
            						<u class="pos_right"></u>
            					</div>
            					<ul class="input_list_hidden row_ree_one">
            						<li>出境游</li>
            						<li>国内游</li>
            						<li>周边游</li>
            					</ul>
            					<div class="mudidi_input">
            						<input type="text" name="destTwo" readonly class="mudidi_two" placeholder="选择目的地"/>	
            						<input type="hidden" name="destTwoId" value="<?php if($customArr['custom_type'] == '周边游'){ echo $customArr['endplace'];} else {echo $parentId;}?>" />
            						<u class="pos_right"></u>
            					</div>
            					<ul class="input_list_hidden row_ree_two">
            						
            					</ul>
            					<div class="mudidi_input">
            						<input type="text" id="expert_dest" name="expert_dest" <?php if($custom_type == '周边游') {echo 'disabled="disabled"';}?> class="mudidi_three" placeholder="选择目的地"/>
            						<input type="hidden" id="expert_dest_id" name="expert_dest_id" value="<?php if($custom_type != '周边游'){ if(!empty($customArr['endplace'])) echo $customArr['endplace'].',';}?>" />
            					</div>                 			
            				</div>
            				
            			</div>
                        <div class="dest_box">
                                <?php 
                                    if (!empty($destData) && $customArr['custom_type'] != '周边游') {
                                        echo '<div id="destButton" style="display:block;">';
                                        echo '<div class="selectedTitle">已选择:</div>';
                                        foreach($destData as $val) {
                                            echo '<span value="'.$val['id'].'" class="selectedContent">'.$val['name'];
                                            echo '<span onclick=\'delPlugin(this ,"expert_dest_id" ,"destButton");\' class="delPlugin">x</span></span>';
                                        }
                                        echo '</div>';
                                    } else {
                                        echo '<div id="destButton" >';
                                        echo '</div>';
                                    }
                                ?>
                            </div>
            			<!--出游方式-->
            			<div class="play_input_list relative ">
            				<!--一层 看有没有选中 -->
            				<div class="onr_dna">
            					<div class="to_play_list_name"><i>*</i>出游方式</div>     	
            					<div class="to_play_input <?php if(!empty($customArr['another_choose'])) echo 'disbl_put'?>">                 			
            						<input type="text" placeholder="请选择出游方式" readonly name="trip_way" value="<?php echo empty($customArr['trip_way']) ? '' : $customArr['trip_way'] ?>" class="<?php echo empty($customArr['another_choose']) ? '': 'disbl_put'?>"/>								
            						<u></u>											
            					</div>
            					<ul class="input_list_hidden Individual_click <?php if(!empty($customArr['another_choose'])) echo 'wid_207'?>">       <!--这个是隐藏的input 要在一个和input 一样宽度的 盒子下面  这样 只要设定 100% 就可以 自动识别了   **1  -->
            						<?php 
            							foreach($traffic as $val) {
											if ($val['description'] == '单项服务' || $val['description'] == '自由行') {
												echo "<li data-val='{$val['dict_id']}' class='Individual'>{$val['description']}</li>";
											} else {
												echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
											}
            							}
            						?>
            					</ul>
            				</div>
            				<!--单项服务-->
            				<div class="twr_dna twr_wid" <?php if(!empty($customArr['another_choose'])) echo 'style="display:block;"'?>>
            					<div class="to_play_list_name"><i>*</i>多项选择</div>     	
            					<div class="to_play_input_multi disbl_put">                 			
            						<input type="text" placeholder="请选择出游方式" readonly class="disblock clearfix"/>								
									<input type="hidden" name="another_choose" />
            						<u></u>												
            					</div>
            					<ul class="input_list_hidden_multi disbl_put2" id="choice_another_choose">       <!--这个是隐藏的input 要在一个和input 一样宽度的 盒子下面  这样 只要设定 100% 就可以 自动识别了   **1  -->
            						<?php 
            							if (!empty($customArr['another_choose'])) {
            								$anotherArr = explode(',', $customArr['another_choose']);
            							}
            							foreach($choose as $val) {
            								if (!empty($anotherArr)) {
            									if (in_array($val['description'] ,$anotherArr)) {
            										echo "<li class='clixk_text' data-val='{$val['dict_id']}'>{$val['description']}<i class='clixk_ok'></i></li>";
            									} else {
            										echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
            									}
            								} else {
            									echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
            								}
            							}
            						?>
            					</ul>
            				</div>
            			</div>
            		</div>
            	</div>
            	<div>
            		<!--您有什么定制要求-->
            		<div class="to_play_title">您有什么定制要求</div>
            		<div class="cust_input_box">										<!--list_input box_-->
            			<div class="switch_input_box">		<!--出行日期 和 文字描述 的切换 div-->
            				<span class="switch_period_one"><input name="datetype" value="1" checked="checked" type="radio"/>出行日期</span>
            				<span class="switch_period_two"><input name="datetype" value="2" type="radio"/>文字描述</span>
            			</div>	
            			<div class="play_input_list">
            				<div class="to_play_list_name"><i>*</i>出行日期</div>     		<!--这个是左面的title_name  名字-->
            				<div class="wid_box">  										<!--给这个设定一个属性 和 下面点击的input一样的宽度    **1  --> 	
            					<div class="to_play_input">
            						           			<!--事件的input box 所有事件都用 这个 -->
            						<input type="text" class="input_switch" name="startdate" value="<?php if (empty($customArr['id']) && !empty($customArr['startdate'])) echo $customArr['startdate']?>" readonly id="datetimepicker" placeholder="请选择出行日期"/>
            						<input type="text" class="input_period" name="estimatedate" placeholder="请输入出行日期."/>		
            						<s class="wid_ico_rili"></s>	<!--日历图标 _默认显示第一个日期图标-->
            						<s class="wid_ico_xieru"></s>	<!--写入图标 -->
            					</div>
            				</div>
            			</div>
            			<!--目的地-->
            			<div class="play_input_list">								
            				<div class="to_play_list_name"><i>*</i>人均预算</div>     	
            				<div class="to_play_input">                 			
            					<input type="text" placeholder="请输入您的预算（只能输入数字）" value="<?php echo empty($customArr['budget']) ? '' : $customArr['budget'];?>" name="budget" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>								
            					<div class="input_Company">元&nbsp;/&nbsp;人</div>												
            				</div>
            			</div>
            			<!--出游方式-->
            			<div class="play_input_list">								
            				<div class="to_play_list_name"><i>*</i>出游时长</div>     	
            				<div class="to_play_input">                 			
            					<input type="text" placeholder="希望出游时长（只能输入数字）" value="<?php echo empty($customArr['days']) ? '' : $customArr['days'];?>" maxlength="3" name="days" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
            					<div class="input_Company">天</div>								
            				</div>
            			</div>
            			<div class="input_box_requi">
            				<ul>
            					<li>
            						<span><i class="red_ico">*</i>酒店要求</span>	
            						<div class="li_input_box"><input type="text" value="<?php echo empty($customArr['hotelstar']) ? '无' : $customArr['hotelstar'];?>" readonly name="hotelstar" value="无"><u></u></div>
            						<ul class="input_hidden_list">
            							<?php 
	            							foreach($hotel as $val) {
	            								echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
	            							}
	            						?>
            						</ul>
            					</li>
            					<li>
            						<span><i class="red_ico">*</i>用房要求</span>
            						<div class="li_input_box"><input type="text" value="<?php echo empty($customArr['room_require']) ? '无' : $customArr['room_require'];?>" readonly name="room_require" value="无"><u></u></div>
            						<ul class="input_hidden_list">
            							<?php 
	            							foreach($room as $val) {	
	            								echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
	            							}
	            						?>
            						</ul>
            					</li>
            					<li>
            						<span><i class="red_ico">*</i>用餐要求</span>
            						<div class="li_input_box"><input type="text" value="<?php echo empty($customArr['catering']) ? '无' : $customArr['catering'];?>" readonly name="catering" value="无"><u></u></div>
            						<ul class="input_hidden_list">
            							<?php 
	            							foreach($catering as $val) {
	            								echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
	            							}
	            						?>
            						</ul>
            					</li>
            					<li>
            						<span><i class="red_ico">*</i>购物自费</span>
            						<div class="li_input_box"><input type="text" value="<?php echo empty($customArr['isshopping']) ? '无' : $customArr['isshopping'];?>" readonly name="isshopping" value="无"><u></u></div>
            						<ul class="input_hidden_list">
            							<?php 
	            							foreach($shopping as $val) {
	            								echo "<li data-val='{$val['dict_id']}'>{$val['description']}</li>";
	            							}
	            						?>
            						</ul>
            					</li>
            				</ul>
            			</div>
            			<!--出游方式-->
            			<div class="play_input_list">								
            				<div class="to_play_list_name">详细需求表述</div>     	
            				<textarea class="demand_expression" id="text_num" name="service_range" onkeyup="words_deal()"><?php echo empty($customArr['service_range']) ? '' : $customArr['service_range'];?></textarea>
            				<div class="Num_show"><i>150</i><span>/150</span></div>
                            
                            <ul class="tarea_tip" <?php if(!empty($customArr['service_range'])) echo 'style="display:none;"'; ?>>
                            	<li>1、以上各项都将对价格构成重大影响，改变任意一项将影响价格。</li>
                                <li>2、旅游目的地可提出您的个性化需求。</li>
                                <li>3、吃住行、游购娱各项需要可提出您的要求。</li>
                            </ul>
            			</div>
            			<div class="where_to_play">                                        		
            				<!--您想去那玩-->
            				<div class="to_play_title">您的定制信息资料</div>
            					<!--出发城市-->
            				<div class="cust_input_box">										
            					<div class="input_box_requi">
            						<ul>
            							<li>
            								<span><i class="red_ico">*</i>总人数</span>	
            								<div class="li_input_box"><input type="text" name="total_people" placeholder="0" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></div>
            								<div class="input_Company">人</div>
            							</li>
            							<li>
            								<span><i class="red_ico">*</i>用房数</span>
            								<div class="li_input_box"><input type="text" name="roomnum" placeholder="每次增加或减少0.5间房" value="1" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></div>
            								<i class="jian_top"></i>
                                            <i class="jian_bottom"></i>
                                            <div class="input_Company">间</div>
            							</li>
                                        
            						</ul>
            					</div>
            					<div class="detaileds">
            						<ul>
            							<li>
            								<span><i class="red_ico">*</i>成人</span>
            								<input class="max_one" type="text" name="people" maxlength="3" value="1" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
            								<div class="input_Company">人</div>
            							</li>
            							<li>
            								<span><i class="red_ico">*</i>占床儿童</span>
            								<input class="max_zroe" type="text" name="childnum" maxlength="3" value="0" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
            								<div class="input_Company">人</div>
            							</li>
            							<li>
            								<span><i class="red_ico">*</i>不占床儿童</span>
            								<input class="max_zroe" type="text" name="childnobednum" maxlength="3" value="0" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
            								<div class="input_Company">人</div>
            							</li>
            							<li>
            								<span><i class="red_ico">*</i>老人</span>
            								<input class="max_zroe" type="text" name="oldman" maxlength="3" value="0" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
            								<div class="input_Company">人</div>
            							</li>
            						</ul>
            					</div>
            					<div class="input_box_requi">
            						<ul>
            							<li>
            								<span><i class="red_ico">*</i>联系人</span>
            								<div class="li_input_box"><input type="text" name="linkname" placeholder="联系人"></div>
            							</li>
            							<li>
            								<span>微信号</span>
            								<div class="li_input_box"><input type="text" name="weixin" placeholder="微信号" ></div>
            							</li>
            						</ul>
            					</div>
            					<div class="input_box_requi">
            						<ul>
            							<li>
            								<span><i class="red_ico">*</i>手机号码</span>
            								<div class="li_input_box"><input type="text" name="mobile" maxlength="11" placeholder="手机号码" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"></div>
            								
            							</li>
            							<?php 
            								$userid = $this ->session ->userdata('c_userid');
            								if (empty($userid)):
            							?>
            							<li style="z-index: 1001">
            								<div class="verifications" id="verifications">发送验证码</div>
            								<div class="Ver_hidden">
                    							<div class="fication_box">
                    								<img style="-webkit-user-select: none" class="verifycode" src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()">
                    							</div>
                        						<div class="fill_box"><input type="text" name="vcode" ></div>
                        						<div class="btn_box"><input type="button" class="sendMobileCode" value="发送" ></div>
                        						<div class="btn_box"><input type="button" value="关闭" class="Close" ></div>
                    						</div>
            							</li>
            							<li>
            								<span><i class="red_ico">*</i>验证码</span>
            								<div class="li_input_box"><input type="text" name="code" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" placeholder="请输入收到的验证码" maxlength="4"></div>
            							</li>
            							<li>
            								<div class="not_receive">收不到验证码?<a href="/article/contact_us" target="_blank">联系客服</a></div>
            							</li>
            							<?php endif;?>
            						</ul>
            					</div>
            				</div>
            			</div>
            		</div>
            	</div>																
            </div>
            <div class="cust_tip">在您选定方案前，您的个人信息不会透露给管家或供应商</div>
            <input type="submit" style="cursor:pointer;" class="Submit" value="提交">
        </div>
        </form>
        <div class="cmd_right">
        	<div class="w_240 marg_auto">
            	<div class="list_Step_title">简单四步轻松定制出游</div>
            	<ul class="right_list_Step">
                	<li>1分钟发布旅游需求</li>
                    <li>坐等旅游管家设计方案</li>
                    <li>确认方案后在线支付</li>
                    <li style="height:42px;">快乐出游</li>
                </ul>
            </div>
        </div>
        <!--常见问题 title -->
        <div class="com_problem">常见问题<a href="<?php echo site_url('article/index-0.html')?>" target="_blank">更多>></a></div>
        <div class="cmd_right">
        	<div class="w_280" style=" padding-left: 55px;">
            	<ul class="right_problem_list">
                    <li style=" display: none;"><a  href="javascript:;" class="answer_click" >什么是定制旅游？</a></li>
                	<li class="answer_box" style="display: block;"><span>什么是定制旅游？</span>定制旅游是根据您的需求，为您量身定制出行方案的旅游方式。为您提供各种旅行方式,包括独立包团,中高端定制旅游,个性旅游定制服务等,旅游定制专家根据您需求灵活组合旅行要素,策划个性旅行方案,管家式服务,享受私家定制旅行, 并且可以根据您的人数,价位,目的地,出发日期,行程天数等需求为您定制合适的包团旅游方案,高效,方便,快捷的解决客户旅游人数多,旅游产品选择困难的问题。
                	</li>
                	
                    <li><a  href="javascript:;" class="answer_click">大众类需求可以发布定制吗？</a></li>
                    <li class="answer_box"><span>大众类需求可以发布定制吗？</span>不管您是大众、小众还是个性需求，我们的管家都会为您匹配需求、定向搜索或者专属定制您的旅游产品，您可以选择您满意的方案出行。</li>
                    
                    <li><a  href="javascript:;" class="answer_click">发布定制是免费的吗？</a></li>
                    <li class="answer_box"><span>发布定制是免费的吗？</span>是的！帮游网为每一位游客提供免费的旅游定制服务，自您发布需求24小时内，可以享受多套管家方案竞标服务，如果您没有选中任何一套方案，您无需支付任何费用。</li>
                    
                    <li><a  href="javascript:;" class="answer_click">没有账号可以直接定制吗？</a></li>
                    <li class="answer_box"><span>没有账号可以直接定制吗？</span>可以的, 为了更方便地为您服务.我们只需要验证手机号,系统会自动为您注册账号，账号名即为您的手机号.您在第一次登陆的时候点击忘记密码重新设置密码，也可以采用获取动态密码的方式登陆。</li>
                    
                    <li><a  href="javascript:;" class="answer_click">哪里可以查看我的方案？</a></li>
                    <li class="answer_box"><span>哪里可以查看我的方案？</span>您可以到“会员中心－我的定制单”查看并选择管家的竞标方案。</li>
                    
                    <li><a  href="javascript:;" class="answer_click">选择方案后我该做些什么？</a></li>
                    <li class="answer_box"><span>选择方案后我该做些什么？</span>当您选择适合您的方案后，您的专属管家会联系您，全程跟进服务，确保您的旅行无忧。</li>
                    
                </ul>
            </div>
        </div>
    </div>
    
        <?php $this->load->view('common/footer'); ?>
    
</div>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script> 

$('#datetimepicker').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false
});

var defaultChoice = $("#choice_another_choose").find(".clixk_text").length;
if (defaultChoice >0) {
	$(".clearfix").val('当前已选中'+defaultChoice+'项');
}

var custom_type = $('input[name=destOne]').val();
var destData = {};//保存获取的目的地数据
$.ajax({
	url:"/line/line_custom/getDestData",
	type:'post',
	dataType:'json',
	success:function(data) {
		destData = data;
		var html = '';
		$.each(data.top ,function(k ,v) {
			html += "<li data-val='"+v.id+"' onclick='changeCountryDest(this);'>"+v.name+"</li>";
		})
		//目的地第一层
		$(".row_ree_one").html(html);
		//定制列表样例 or 首页定制进入给默认值
		if (custom_type == '周边游') {
			getRoundTrip();
		} else {
			getProinceDest();
			getChoicePlugin();
		}
	}
});
//获取出境 or 国内游的下一级
function getProinceDest() {
	var type = $('input[name=destOne]').val();
	if (type == '出境游') {
		var data = destData[2];
	} else if (type == '国内游') {
		var data = destData[1];
	}
	getProvinceHtml(data);
}

//获取周边游目的地
function getRoundTrip() {
	$(".row_ree_two").html('');
	var startcity = $("#startcityId").val();
	$("#expert_dest").attr("disabled" ,true);
	$.ajax({
		url:'/line/line_custom/getRoundTrip',
		data:{cityId:startcity},
		type:'post',
		dataType:'json',
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				getProvinceHtml(data);
			} else {
				$("input[name=destTwo]").val('');
				$("input[name=destTwoId]").val('');
			}
		}
	});
}
//获取第二级目的地的html
var init_p = true;
function getProvinceHtml(data) {
	var html = '';
	var twoId = $('input[name=destTwoId]').val();
	var twoArr = twoId.split(',');
	
	if (init_p === true && !$.isEmptyObject(twoId)) {
		init_p = false;
		var num = 0;
		$.each(data ,function(key ,val){
			var active = false;
			for(var i in twoArr) {
				if (twoArr[i] == val.id) {
					active = true;
					num = num+1;
				}
			}
			if (active === true) {
				html += '<li data-val="'+val.id+'" class="prov-active" style="position: relative;" onclick="changeProvinceDest(this)">'+val.name+'<i class="clixk_ok"></i></li>';
			} else {
				html += '<li data-val="'+val.id+'" onclick="changeProvinceDest(this)">'+val.name+'</li>';
			}
			$('input[name=destTwo]').val('已选择'+num+'项');
		})
	} else{
		$.each(data ,function(key ,val){
			html += '<li data-val="'+val.id+'" onclick="changeProvinceDest(this)">'+val.name+'</li>';
		})
	}
		
	$(".row_ree_two").html(html);
}
function changeCountryDest(obj) {
	var name = $(obj).text();
	$("input[name=destOne]").val($(obj).text());
	$("input[name=destTwo]").val('');
	$("input[name=destTwoId]").val('');
	emptyDestCity();
	$(obj).parent().hide();
	if (name == '周边游') {
		getRoundTrip();
	} else {
		$("#expert_dest").attr("disabled" ,false);
		getProinceDest();
	}
}
//清空目的地第三级
function emptyDestCity() {
	$("#expert_dest").val('');
	$("#expert_dest_id").val('');
	$("#destButton").html('').hide();
}

//点击第二级目的地
function changeProvinceDest(obj) {
	if ($(obj).find('.clixk_ok').length > 0) {
		//删除已选择的三级目的地
		delThreeDest($(obj).attr('data-val'));
		$(obj).removeClass('prov-active').find('i').remove();
	} else {
		$(obj).addClass('prov-active').css('position','relative').append('<i class="clixk_ok"></i>');
	}
	var type = $('input[name=destOne]').val();
	//emptyDestCity();
	getDestTwoSelected();
	if (type != '周边游') {
		getChoicePlugin();
	}
	
	//$(obj).parent().hide();
}
//获取选中的二级目的地
function getDestTwoSelected() {
	var maxnum = 'none'; //最多可选择	 none-无限制
	if (maxnum != 'none' && $('.row_ree_two').find('.prov-active').length > maxnum) {
		alert('二级目的地最多选择'+maxnum+'项');
		return false;
	}
	var ids = '';
	var num = 0;
	$.each($('.row_ree_two').find('.prov-active') ,function() {
		ids += $(this).attr('data-val')+',';
		num ++;
	})
	$("input[name=destTwo]").val('已选择'+num+'项');
	$("input[name=destTwoId]").val(ids);
}
//删除选择的第三级目的地
function delThreeDest(towId) {
	var towData = destData[towId];
	var ids = '';
	$.each($('#destButton').find('.selectedContent'),function(){
		var choiceId = $(this).attr('value');
		var obj = $(this);
		$.each(towData ,function(key ,item) {
			if (choiceId == item.id) {
				obj.remove();
			}
		})
	})
	$.each($('#destButton').find('.selectedContent'),function(){
		ids += $(this).attr('value')+',';
	})
	$('#expert_dest_id').val(ids);
}

function getChoicePlugin() {
	var id = $('input[name=destTwoId]').val();
	if (id < 1) {
		return false;
	}
	var data = getChoiceDestData();
	var pluginArr = {
			0:{
				name:$("input[name='destOne']").val(),
				two:data
			}
	};
	createChoicePlugin({
		data:pluginArr,
		nameId:'expert_dest',
		valId:'expert_dest_id',
		width:500,
		number:5,
		buttonId:'destButton'
	});
}
//获取第三级目的地数据
function getChoiceDestData() {
	var data = {};
	var key = 0;
	$.each($('.row_ree_two').find('.prov-active') ,function() {
		data[key] = {name:$(this).text(),three:destData[$(this).attr('data-val')]};
		key ++ ;
	})
	return data;
}

$("input[name='destTwo']").click(function(){
	if ($("input[name='destOne']").val().length < 1) {
		alert('请选择国内，出境，周边');
		return false;
	}
})
$("#expert_dest").click(function(){
	if ($("input[name=destTwoId]").val() < 1) {
		alert('请选择第二级目的地');
		return false;
	}
})

//出发城市获取
	createChoicePluginPY({
		data:{0:chioceStartCityJson['domestic']},
		nameId:'custom_startcity',
		valId:'startcityId',
		isHot:true,
		hotName:'热门',
		isCallback:true,
		callbackFuncName:callbackFunc
	});
//出发城市选择后回调
function callbackFunc() {
	var destOneName = $("input[name='destOne']").val();
	$("#expert_dest").removeAttr("disabled");
	if (destOneName == '周边游') {
		$("input[name='destOne']").val('');
		$("input[name='destTwo']").val('');
		$("input[name='destTwoId']").val('');
	}
}

var codeStatus = true;
$(".sendMobileCode").click(function(){
	if (codeStatus == false) {
		return false;
	} else {
		codeStatus = false;
	}
	var mobile = $("#custom_form").find("input[name='mobile']").val();
	var vcode = $("#custom_form").find("input[name='vcode']").val();
// 	if (!isMobile(mobile)) {
// 		codeStatus = true;
// 		alert("请填写正确的手机号");
// 		return false;
// 	}
	$.post("/send_code/sendMobileCode",{mobile:mobile,verifycode:vcode,type:3},function(json){
		codeStatus = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			$(".Ver_hidden").hide();
			countdown("verifications");
		} else {
			alert(data.msg);
			$(".verifycode").trigger("click");
		}
	})
})

var s = true;
$("#custom_form").submit(function(){
	if (s == false) {
		return false;
	} else {
		s = false;
	}
	var another_choose = '';
	var len = $("#choice_another_choose").find("li").length;
	var a = 0;
	for(a ;a<len ;a++) {
		if ($("#choice_another_choose").find("li").eq(a).hasClass("clixk_text")) {
			another_choose += $("#choice_another_choose").find("li").eq(a).text()+',';
		}
	}
	$("input[name='another_choose']").val(another_choose);
	$.post("/line/line_custom/createCustom" ,$("#custom_form").serialize(),function(json){
		s = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			location.href='/line/line_custom/custom_success_'+data.msg+'.html';
		} else {
			alert(data.msg);
		}
	})
	return false;
})
  
</script>

<script>
//  switch_period_one 和 switch_period_two的input切换效果
$(function(){
    $(".footer").css("background","#fff")
	$(".switch_period_one").click(function(){
		$(this).find("input").attr("checked","checked")	
		$(".input_switch").show();
		$(".input_period").hide();
		$(".wid_ico_xieru").hide();
		$(".wid_ico_rili").show();
	});				
	$(".switch_period_two").click(function(){
		$(this).find("input").attr("checked","checked")	
		$(".input_switch").hide();
		$(".input_period").show();
		$(".wid_ico_xieru").show();
		$(".wid_ico_rili").hide();
	});	
});

$(function(){
	// 下拉效果
	$(".to_play_input").click(function(){
		$(this).siblings(".input_list_hidden").slideDown("fast");
       
	});
	//取值  赋值
	$(".input_list_hidden li").click(function(){
		var thisHtml= $(this).html();
		//alert(thisHtml);
		$(this).parent().siblings().find("input").val(thisHtml);
		$(this).parent().hide();
	});
	 $("body").mouseup(function(e) {
		var _con = $('.input_list_hidden');
		if (!_con.is(e.target) && _con.has(e.target).length === 0) {
			$(".input_list_hidden").slideUp("fast");
		}
	})
});
	//第二个下拉效果
$(function(){
	$(".li_input_box").click(function(){
		$(this).siblings(".input_hidden_list").slideDown("fast");
        $(".zIndex").removeClass("zIndex");
        $(this).addClass("zIndex");
	})
	$(".input_hidden_list li").click(function(){
		var thisHtml= $(this).html();
		$(this).parent().siblings(".li_input_box").find("input").val(thisHtml);
		$(this).parent().hide();
	})
	$("body").mouseup(function(e) {
		var _con = $('.input_hidden_list');
		if (!_con.is(e.target) && _con.has(e.target).length === 0) {
			$(".input_hidden_list").slideUp("fast");
		}
	})
})
//显示验证码
$(function(){
	$(".verifications").click(function(){
		$(".verifycode").trigger("click");
		$(".Ver_hidden").stop().fadeToggle("slow")	
	})
	$(".Close").click(function(){
		$(".Ver_hidden").fadeOut("fast");
	})
	//点击其他地方 隐藏	
	$("body").mouseup(function(e) {
		var _con = $('.Ver_hidden');
		if (!_con.is(e.target) && _con.has(e.target).length === 0) {
			$(".Ver_hidden").fadeOut("fast");
		}
	})
})  

 //出游方式的下拉
$(function(){
	//
    $(".mudidi_input").click(function(){
        $(this).next(".input_list_hidden").slideDown(" fast")
        $(".zIndex").removeClass("zIndex");
        $(this).parent().addClass("zIndex");

    })
});
$("body").mouseup(function(e) {
    var _con = $('.input_list_hidden');
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $(".input_list_hidden").slideUp("fast");
    }
})

//常见问题的弹出下拉效果
$(function(){
	$(".answer_click").click(function(){
		$(this).parent().hide().siblings("li").show();
		
		$(this).parent().next(".answer_box").show().siblings(".answer_box").hide();
	})
}) 
	
//textarea 限制字数 150字 words_deal 
function words_deal()
{
	var curLength=$("#text_num").val().length;
	if(curLength>150)
	{
		var num=$("#text_num").val().substr(0,150);
		$("#text_num").val(num);
		$(".Num_show i").html("0")
		alert("超过字数限制！" );
	}else{
		$(".Num_show i").html(150-$("#text_num").val().length);
	}
}

//仿提示字的格式
$(".tarea_tip").click(function(){
	$(this).hide();
	$("#text_num").focus();
});
//提示字还原
$("#text_num").blur(function(){
	var thisMum=$(this).val().length;
	//alert(thisMum)	
	if(thisMum==0){
		$(".tarea_tip").show();
	}
})

//  单项服务和自由行
$(function(){
//点击改变本身的样式i   单项服务
	$(".Individual_click li").click(function(){
		if($(this).hasClass("Individual")){
			$(this).parent().siblings(".to_play_input").addClass("disbl_put");
			$(this).parent().siblings(".to_play_input").find("input").addClass("disbl_put");	
			$(this).parent().parent().addClass("onr_wid");
			$(this).parent().addClass("wid_207");
			$(".input_list_hidden_multi").find("li").find("i").remove();
			$(".clearfix").val("请选择出游方式");
			//把 2显示
			$(".twr_dna").show();
			$(".tht_dna").hide();
		}
		if($(this).hasClass("reedom")){
			$(this).parent().siblings(".to_play_input").addClass("disbl_put");
			$(this).parent().siblings(".to_play_input").find("input").addClass("disbl_put");	
			$(this).parent().parent().addClass("onr_wid");
			$(this).parent().addClass("wid_207");
			$(".input_list_hidden_multi").find("li").find("i").remove();
			$(".clearfix").val("请选择出游方式");
			//把 2显示
			$(".twr_dna").hide();
			$(".tht_dna").show();

		}
		if($(this).hasClass("Individual") || $(this).hasClass("reedom")){
		}else{
			$(this).parent().siblings(".to_play_input").removeClass("disbl_put");
			$(this).parent().siblings(".to_play_input").find("input").removeClass("disbl_put");	
			$(this).parent().parent().removeClass("onr_wid");
			$(this).parent().removeClass("wid_207");
			$(".clearfix").val("请选择出游方式");
			$(".tht_dna").hide();
			$(".twr_dna").hide();
		}
	})							
})
//输入的人数 最后为0 或者 为 1
$(function(){
	$(".max_zroe").blur(function(){
		len = $(this).val().length;
		if(len==0){
			$(this).val("0")
		}
	})
	$(".max_one").blur(function(){
		len = $(this).val().length;
		if(len==0){
			$(this).val("1")
		}else{
			return false;
		}
	})	

})


//多项选择的多选效果 
$(function(){
	//多项选择的对勾 选中
	$(".to_play_input_multi").click(function(){
		$(this).next(".input_list_hidden_multi").slideDown("fast")
	});
	$(".input_list_hidden_multi").find("li").click(function(){
		var thisHtml = $(this).text();
		var val = $(this).parent().siblings(".to_play_input_multi").find("input").val();
		var length = $(this).find("i").length;
		//var newtext = val.replace(thisHtml,"t"); 
		if(length>0){
			$(this).find("i").remove();
			$(this).removeClass("clixk_text");
		}else{
			$(this).append("<i class='clixk_ok'></i>");
			$(this).addClass("clixk_text");
		}
		//最多可以选择6项
		var clixk_Len=$(this).parent('ul').find(".clixk_text").length;
		console.log(clixk_Len);
		if(clixk_Len>6){
			$(this).find("i").remove();
			$(this).removeClass("clixk_text");
			alert("最多可以选择6项服务");
		}
		$(".clearfix").val("当前已选中"+clixk_Len+"项");
	});
});
	


//每次增加或减少0.5建房间数
$(".jian_top").click(function(){
	var thisVal = $(this).siblings(".li_input_box").find("input").val();
	var parseIn = Number(thisVal)
	$(this).siblings(".li_input_box").find("input").val(parseIn+0.5);	
});
$(".jian_bottom").click(function(){
	var thisVal = $(this).siblings(".li_input_box").find("input").val();
	var parseIn = Number(thisVal)
	$(this).siblings(".li_input_box").find("input").val(parseIn-0.5);
	//不得少于一间房
	if(parseIn<1){
		$(this).siblings(".li_input_box").find("input").val("0");
	}	
});


//全部隐藏//
$("body").mouseup(function(e) {
	var _con = $('.input_list_hidden_multi');
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		$(".input_list_hidden_multi").slideUp("fast");
	};
});
	
	
	
</script>
</body>
</html>