     <?php if($type=='scheme'){
       if(!empty($data)){ ?><!-- ---------------------------------------定制单查看------------------------------------------------- -->
	              <div class="confirm_title">
                 	<span>我的定制单</span>
                 </div>
                 <div style=" padding:0 20px;">
                  <div class="confirm_guest_demand">
                  	 <p  class="confirm_guest_demand_title">我的需求</p>
                           <ul>
                                  <li class="fl" style=" width:100%;">
                                      <div class="serial_number">
                                        <span class="confirm_guest_demand_span_1 number_1 fl" style="width:50px; text-align: center;">编号</span>
                                        <span class="confirm_guest_demand_span_2 number_2 fl" style="width:50px; text-align: center; background: #fff; border-top:1px solid #666; border-bottom:1px solid #666;"><?php echo $data[0]['id']; ?></span>
                                      </div>
                                  </li>
                                  <li class="fl">
                                        <span class="confirm_guest_demand_span_1 ">出发城市：</span>
                                        <span class="confirm_guest_demand_span_2"><?php echo $data[0]['startplace']; ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">目的地：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(isset($data[0]['dest'])){foreach ($data[0]['dest'] as $key=>$val){ if(($key+1)<count($data[0]['dest'])){ echo $val['name'].'/';}else{echo $val['name'];}}} ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1">出游日期：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($data[0]['estimatedate'])&& $data[0]['estimatedate']!=null && $data[0]['estimatedate']!='0000-00-00'){echo $data[0]['estimatedate'];}else{echo $data[0]['startdate'];} ?></span>
                                  </li>

                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">出游方式：</span>

                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($data[0]['another_choose'])){ echo $data[0]['description'].'/'.$data[0]['another_choose'];}else{ echo $data[0]['description'];} ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">购物自费：</span>
                                        <span class=" confirm_guest_demand_span_2  demand_money"><?php echo $data[0]['isshopping']; ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">要求酒店：</span>
                                        <span class=" confirm_guest_demand_span_2  demand_money"><?php echo $data[0]['hotel']; ?> </span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">要求用餐：</span>
                                        <span class=" confirm_guest_demand_span_2  demand_money"><?php echo $data[0]['catering']; ?> </span>
                                  </li>
                                 <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1">总人数：</span>
                                        <span class="confirm_guest_demand_span_2" style=" color:#f30;"><?php echo $data[0]['total_people']; ?>
                                        <i style="color:#000;">(<u><?php echo $data[0]['people']; ?></u>成人/<u><?php echo $data[0]['childnum']; ?></u>占床儿童/<u><?php echo $data[0]['childnobednum']; ?></u>不占床儿童/<u><?php echo $data[0]['oldman']; ?></u>老人)</i></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1">用房数：</span>
                                        <span class="confirm_guest_demand_span_2"><u><?php if(!empty($data[0]['roomnum'])){ echo $data[0]['roomnum'];}else{echo 0; } ?></u>间</span>
                                  </li>

                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">用房要求：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($data[0]['room_require'])){ echo $data[0]['room_require'];}?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">希望出游时长：</span>
                                        <span class="confirm_guest_demand_span_2"><?php echo $data[0]['days']; ?>天</span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">联系人：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($data[0]['linkname'])){ echo $data[0]['linkname'];}?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">希望人均预算：</span>
                                     <span class="confirm_guest_demand_span_2 "><?php echo $data[0]['budget']; ?>元/人</span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">手机号：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($data[0]['linkphone'])){ echo $data[0]['linkphone'];}?></span>
                                  </li>
                                  <li class="fl" style="height:auto; min-height:42px;">
                                  	 <span class="confirm_guest_demand_span_1 ">详细需求表述：</span>
                                     <span class="confirm_guest_demand_span_2" title="<?php echo $data[0]['service_range']; ?>" style=" color:#999"><?php  if(!empty($data[0]['service_range'])){echo $data[0]['service_range']; }else{echo '无';}?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">微信号：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($data[0]['linkweixin'])){ echo $data[0]['linkweixin'];}else{echo '无';}?></span>
                                  </li>
                           </ul>
                  </div>
                 </div>
                 <div style=" padding:0 20px;">
                  <div class="confirm_information ">
                        <span class="confirm_information_title">方案信息</span>
                        <div class="program_detial">
                        <!-- 循环回复方案 开始-->
                        <?php if(!empty($solution)){ ?>
                        <?php foreach ($solution as $k=>$v){  if($k<10){?>
                        	<div class="program_drtial_list">
                            	<div class="program_text">
                                	<i class="sanjiao_ico"></i>
                                        <!-- 将guanj改为guanjia 魏勇编辑-->
                                    <div class="expert_img fl"><a target="_blank" href="<?php echo base_url(); ?>guanjia/<?php echo $v['expert_id']; ?>"><img src=<?php if(!empty($v['small_photo'])){ echo '"'.$v['small_photo'].'"';}else{  echo "<?php echo base_url('static'); ?>/img/user/expert_img2.png"; }?>/></a></div>
                                    <div class="program_text_info fl">
                                        <!-- 将guanj改为guanjia 魏勇编辑-->
                                        <div class="fl exp_present" style="font-size:13px;"><span class="expert_name"><a target="_blank" href="<?php echo base_url(); ?>guanjia/<?php echo $v['expert_id']; ?>"><?php echo $v['realname'] ?></a></span>回复方案</div>
                                        <span class="fr"><span style=" color:#000;">状态:</span><?php if($v['isuse']==1){ echo '已夺标';}elseif($v['reply']==0){ echo '已投标';}else{echo '已投标';}?> </span>
									   <!--  当前第几个方案-->
                                       <div class="wera_scheme">
                                        <div class="present_wave"><?php echo !empty($v['ca_title']) ? $v['ca_title'] : '无标题' ?><!-- 方案<?php echo $k+1; ?> --></div>
                                        <div class="text_info fl">方案推荐: <?php echo $v['price_description']; ?></div>
                                        <div class="text_info fl">总体描述: <?php echo $v['solution']; ?></div>

                                        <div class="operate fr">
                                        	<a class="huifu view" value="<?php echo $v['id']; ?>" data-status="<?php if(isset($status)){ echo $status; } ?>" href="#">查看</a>
                                        	<a  href="<?php echo $web['expert_question_url'];?>/kefu_member.html?mid=<?php echo $this ->session ->userdata('c_userid')?>&eid=<?php echo $v['expert_id']?>" target="_blank" >咨询</a>
                                        	<?php
                                        	    if($v['isuse']==1){  
													echo '已选择此方案';
                                        	    }elseif ($v['isuse']==0){
	                                        		if(isset($status) && $status==3){ //status=3,待选方案
                                                        if($v['reply']==0){ //判断管家是否有回复方案
	                                        			   echo '<a class="sel_solution" href="#" data="'.$v['cid'].'" answer="'.$v['id'].'" expert="'.$v['expert_id'].'">选择此方案</a>' ;
	                                        			}elseif($v['reply']>0){
	                                        				echo '';
	                                        			}
	                                        		}else{
	                                        			echo '';
	                                        		}
                                             	}elseif($v['isuse']==-1){
                  				                      echo '已否定';
      										 	}?>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <i class="lf_line_ico"></i>
                                <div class="program_time clear">
                                	<div class="time_text fl"> <?php echo date('H:i', strtotime($v['addtime']));?> <br/> <?php echo date('m月d日', strtotime($v['addtime']));?></div>
                                    <div class="time_ico fr"></div>
                                </div>
                            </div>
                            <?php }else{echo '<div class="program_drtial_list" style="float:right;padding-right:20px;"><a href="###" id="show_more">更多>>></a></div>';?>
                               <div class="program_drtial_list" id="show_more_list" style="display: none;">
                            	<div class="program_text">
                                	<i class="sanjiao_ico"></i>
                                        <!-- 将guanj改为guanjia 魏勇编辑-->
                                    <div class="expert_img fl"><a target="_blank" href="<?php echo base_url(); ?>guanjia/<?php echo $v['expert_id']; ?>"><img src=<?php if(!empty($v['small_photo'])){ echo '"'.$v['small_photo'].'"';}else{  echo "<?php echo base_url('static'); ?>/img/user/expert_img2.png"; }?>/></a></div>
                                    <div class="program_text_info fl">
                                        <!-- 将guanj改为guanjia 魏勇编辑-->
                                        <div class="fl exp_present" style="font-size:13px;"><span class="expert_name"><a target="_blank" href="<?php echo base_url(); ?>guanjia/<?php echo $v['expert_id']; ?>"><?php echo $v['realname'] ?></a></span>回复方案</div>
                                        <span class="fr"><span style=" color:#000;">状态:</span><?php if($v['isuse']==1){ echo '已夺标';}elseif($v['reply']==0){ echo '已投标';}else{echo '已投标';}?> </span>
									   <!--  当前第几个方案-->
                                       <div class="wera_scheme">
                                        <div class="present_wave">方案<?php echo $k+1; ?></div>
                                        <div class="text_info fl"><?php echo $v['solution']; ?></div>
                                        <div class="operate fr">
                                        	<a class="huifu view" value="<?php echo $v['id']; ?>" data-status="<?php if(isset($status)){ echo $status; } ?>" href="#">查看</a>
                                        	<a  href="<?php echo $web['expert_question_url'];?>/kefu_member.html?mid=<?php echo $this ->session ->userdata('c_userid')?>&eid=<?php echo $v['expert_id']?>" target="_blank" >咨询</a>
                                        	<?php
                                        	    if($v['isuse']==1){ 
													 echo '已选择此方案';
                                        	    }elseif ($v['isuse']==0){
	                                        		if(isset($status) && $status==3){ //status=3,待选方案
                                                        if($v['reply']==0){ //判断管家是否有回复方案
	                                        			   echo '<a class="sel_solution" href="#" data="'.$v['cid'].'" answer="'.$v['id'].'" expert="'.$v['expert_id'].'">选择此方案</a>' ;
	                                        			}elseif($v['reply']>0){
	                                        				echo '';
	                                        			}
	                                        		}else{
	                                        			echo '';
	                                        		}
                                             	}elseif($v['isuse']==-1){
                  				                      echo '已否定';
      										 	}?>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <i class="lf_line_ico"></i>
                                <div class="program_time clear">
                                	<div class="time_text fl"> <?php echo date('H:i', strtotime($v['addtime']));?> <br/> <?php echo date('m月d日', strtotime($v['addtime']));?></div>
                                    <div class="time_ico fr"></div>
                                </div>
                            </div>
                            <?php } }
      							 }else{ echo '暂无方案信息';}?>
                        <!-- 循环回复方案 结束-->
                        </div>
                  </div>
                  </div>
                  	<!--选中时的提示 -->
				<div class="solution_hidden">
                	<p>您确定选择次方案?</p>
                    <p>选择后您的联系方式会显示给管家</p>
                    <div class="queren_btn fl">确定</div><div class="quxiao_btn fl">取消</div>
                </div>
                  <!-- 弹出行程 -->
	              <div class="order_new_window_confirm" id="order_new_window_confirm" style="bottom: 30px; position:absolute; left:50%; margin-left:-400px;position: fixed;width:0 auto; margin-top:-45px;z-index:9999;">
	              </div>
	             <!-- end -->

	<?php }else{echo '暂无信息记录';} }elseif($type=='reply_scheme'){?>
	<!-- ---------------------------------------定制单详情弹框------------------------------------------------- -->
	  <div class="confirm_title">
                 	<span>方案详情</span>
                 	<i class="user_icon icon_order_1 GY2 "></i>
                 </div>
                 <div style=" height:90%;  overflow-x: auto; overflow-y: scroll;">
                  <div class="confirm_guest_demand">
                  	 <p  class="confirm_guest_demand_title">我的需求</p>
                                <ul>
                                    <li class="fl" style="width:100%;">
                                      <div class="serial_number">
                                        <span class="confirm_guest_demand_span_1 number_1 fl" style="width:50px; text-align: center;">编号</span>
                                        <span class="confirm_guest_demand_span_2 number_2 fl" style="width:50px; text-align: center; background: #fff; border-top:1px solid #666; border-bottom:1px solid #666;"><?php echo $customize['id']; ?></span>
                                          </div>
                                  </li>
                                   <li class="fl">
                                        <span class="confirm_guest_demand_span_1 ">出发城市：</span>
                                        <span class="confirm_guest_demand_span_2"><?php echo $customize['startplace']; ?></span>
                                  </li>
                                   <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">目的地：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(isset($customize['dest'])){foreach ($customize['dest'] as $key=>$val){ if(($key+1)<count($customize['dest'])){ echo $val['name'].'/';}else{echo $val['name'];}}} ?></span>
                                  </li>

                                     <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1">出游日期：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($customize['estimatedate'])&& $customize['estimatedate']!=null && $customize['estimatedate']!='0000-00-00'){ echo $customize['estimatedate'];}else{ echo $customize['startdate'];} ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">出游方式：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($customize['another_choose'])){ echo $customize['description'].'/'.$customize['another_choose'];}else{ echo $customize['description'];} ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">购物自费：</span>
                                        <span class=" confirm_guest_demand_span_2  demand_money"><?php echo $customize['isshopping']; ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">要求酒店：</span>
                                        <span class=" confirm_guest_demand_span_2  demand_money"><?php echo $customize['hotel']; ?> </span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">要求用餐：</span>
                                        <span class=" confirm_guest_demand_span_2 demand_money"><?php echo $customize['catering']; ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1">总人数：</span>
                                        <span class="confirm_guest_demand_span_2" style=" color:#f30;"><?php echo $customize['total_people']; ?>
                                        <i style="color:#000;">(<u><?php echo $customize['people']; ?></u>成人/<u><?php echo $customize['childnum']; ?></u>占床儿童/<u><?php echo $customize['childnobednum']; ?></u>不占床儿童/<u><?php echo $customize['oldman']; ?></u>老人)</i></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1">用房数：</span>
                                        <span class="confirm_guest_demand_span_2"><u><?php if(!empty($customize['roomnum'])){ echo $customize['roomnum'];}else{echo 0; } ?></u>间</span>
                                  </li>

                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">用房要求：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($customize['room_require'])){ echo $customize['room_require'];}else{echo 0; } ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">希望出游时长：</span>
                                        <span class="confirm_guest_demand_span_2"><?php echo $customize['days']; ?>天</span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">联系人：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($customize['linkname'])){ echo $customize['linkname'];} ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">希望人均预算：</span>
                                     <span class="confirm_guest_demand_span_2 "><?php echo $customize['budget']; ?>元/人</span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">手机号：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($customize['linkphone'])){ echo $customize['linkphone'];} ?></span>
                                  </li>

                                  <li class="fl" style="height:auto; max-height:42px;">
                                  	 <span class="confirm_guest_demand_span_1 ">详细需求表述：</span>
                                     <span class="confirm_guest_demand_span_2" title="<?php echo $customize['service_range']; ?>"><?php echo $customize['service_range']; ?></span>
                                  </li>
                                  <li class="fl">
                                  	 <span class="confirm_guest_demand_span_1 ">微信号：</span>
                                        <span class="confirm_guest_demand_span_2"><?php if(!empty($customize['linkweixin'])){ echo $customize['linkweixin'];} ?></span>
                                  </li>
                           </ul>
                  </div>
                  <div class="solution_hidden">
                	<p>您确定选择此方案?</p>
                    <p>选择后您的联系方式会显示给管家</p>
                    <div class="queren_btn fl">确定</div><div class="quxiao_btn fl">取消</div>
                  </div>
                     <div class="steward_quote">
                         <h3>管家报价</h3>
                        <ul>
                            <li>成人价:<span><i>¥</i><?php  if(!empty($rout)){echo $rout[0]['price'];}else{echo 0;} ?><i>/人</i></span></li>
                            <li>儿童占床:<span><i>¥</i><?php  if(!empty($rout)){echo $rout[0]['childpirce'];}else{echo 0;} ?><i>/人</i></span></li>
                            <li>儿童不占床:<span><i>¥</i><?php  if(!empty($rout)){echo $rout[0]['childnobedprice'];}else{echo 0;} ?><i>/人</i></span></li>
                            <li>老人:<span><i>¥</i><?php  if(!empty($rout)){echo $rout[0]['oldprice'];}else{echo 0;} ?><i>/人</i></span></li>
                         </ul>
                        <div class="description">方案推荐:<span><?php  if(!empty($rout)){echo $rout[0]['price_description'];} ?></span></div>
                     </div>
                  <div class="confirm_information" >

                          <span class="confirm_information_title font_size">行程设计</span>
                          	 <div class="describe"><div class="zi_duiqi">总体描述:</div><span><?php  if(!empty($rout)){echo $rout[0]['plan_design'];}else{ echo '暂无信息';} ?></span></div>
                          	 <div class="describe"><div class="zi_duiqi">方案名称:</div><span><?php  if(!empty($rout)){echo $rout[0]['title'];}else{ echo '暂无信息';} ?></span></div>
                             <ul class="confirm_information_ul">
                             <?php if(!empty($rout)){ ?>
                             <?php foreach ($rout as $k=>$v){ ?>
                             	  <li class="fate_title"><div class="zi_duiqi"></div><span>第<?php echo $v['day']; ?>天:</span></li>
                                  <li class="fate_list"><div class="zi_duiqi"><i>标题:</i></div><span><?php echo $v['cjtitle']; ?></span></li>
                                  <li class="fate_list"><div class="zi_duiqi"><i>交通:</i></div><span><?php if(!empty($v['transport'])){ echo $v['transport'];}else{ echo '&nbsp;';} ; ?></span></li>
                                  <li class="fate_list"><div class="zi_duiqi"><i>用餐:</i></div>
                                  <span>
                                                                                     早餐(<?php if($v['breakfirsthas']==1){ if(!empty($v['breakfirst'])){echo $v['breakfirst'];}else{echo '含';} }else{echo '无';}?>)
                                  /午餐(<?php if($v['lunchhas']==1){ if(!empty($v['lunch'])){echo $v['lunch']; }else{ echo '含';} }else{ echo '无';}?>)
                                  /晚餐(<?php if($v['supperhas']==1){ if(!empty($v['supper'])){echo $v['supper'];}else{echo '含';} }else{echo '无';}?>)
                                  </span>
                                  </li>
                                  <li class="fate_list"><div class="zi_duiqi"><i>住宿:</i></div><span><?php echo $v['hotel']; ?></span></li>
                                  <li>
                                       <i>行程内容:</i><span style=" padding:10px 0; padding-left:12px; clear:both;"><?php echo $v['jieshao']; ?></span>
                                  </li>
                                   <li>
                                        <i>行程图片:</i>
                                        <div class="tour_img">
                                        <?php $pic_arr=explode(';', $v['pic']);
                                            foreach($pic_arr as $key=>$value){
                                            if(!empty($value)){
                                          ?>
                                         <img src="<?php echo $value; ?>"style="max-width:200px;" >
                                         <?php } }?>
                                        </div>
                                  </li>

                              <?php }?>
                              <?php }else{ if(!empty($v['attachment'])){ echo '<li style="text-align:center;margin-top:30px;">暂无行程</li>';}}?>
                             </ul>
                            <?php if(!empty($rout[0]['attachment'])){ ?>
                             <a href="<?php echo $rout[0]['attachment'] ?>" class="download_travel_introduce fl"><img src="<?php echo base_url('static'); ?>/img/page/word_download.jpg" />行程介绍</a>
                             <?php }?>
                  </div>

	       </div>
            <?php
               if(isset($rout[0]['isuse'])){
                if($rout[0]['isuse']==0){
                      if(isset($status) && $status==3){  //可选方案
	                       echo '<input type="button" class="btn_pitch" id="sel_solution" data="'.$rout[0]['id'].'" answer="'.$rout[0]['caid'].'" expert="'.$rout[0]['expert_id'].'"  value="选择此方案"> ' ;
	                   }
                  }
               }
      		?>


	 <?php  }?>

<script type="text/javascript">
var num = $(".lf_line_ico").length;
$(".lf_line_ico").eq(num-1).hide();
$(function(){

	$(".fancybox-inner").css("overflow-x","relative")
	$(".fancybox-inner").css("overflow-y","auto")
	$(".quxiao_btn").click(function(){
		$(".solution_hidden").hide();
	})
	$(".fancybox-inner").css("background","#eee")

	$(".GY2").click(function(){
		$('.order_new_window_confirm').hide();
  	});
})

</script>


