
<link rel="stylesheet" href="/assets/css/b1_admin.css">
<style type="text/css">
</style>


<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
			
			<li><?php if(!empty($supplier['brand'])){ echo $supplier['brand'];} ?>-<?php if(!empty($supplier['login_name'])){ echo $supplier['login_name'];} ?>&nbsp;&nbsp;你好,您上次登录时间是&nbsp;&nbsp;<span  style="color:#009dd9"><?php if(!empty($logindatetime)){ echo $logindatetime;} ?></span></li>
	     
	</ul>
</div>

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
                    <div class="enterprise_information clear">
                           <div class="view_title"><span>供应商信息</span></div>
                                 <ul class="enterprise_ul enterprise  clear">
                                 <li class="fl"><label>负责人姓名：</label><span><?php if(!empty($supplier['realname'])){ echo $supplier['realname'];} ?></span></li>
                                 <li class="fl"><label>负责人手机号：</label><span><?php if(!empty($supplier['mobile'])){ echo $supplier['mobile'];} ?></span></li>
                                 <li class="fl"><label>负责人邮箱：</label><span><?php if(!empty($supplier['email'])){ echo $supplier['email'];} ?></span></li>
								</ul>
								<ul class="enterprise_ul enterprise  clear">

                                 <li class="fl"><label>联系人姓名：</label><span><?php if(!empty($supplier['linkman'])){ echo $supplier['linkman'];} ?></span></li>
                                 <li class="fl"><label>联系人手机号：</label><span><?php if(!empty($supplier['link_mobile'])){ echo $supplier['link_mobile'];} ?></span></li>
                                 <li class="fl" style=" width: 280px"><label>联系人邮箱：</label><span><?php if(!empty($supplier['linkemail'])){ echo $supplier['linkemail'];} ?></span></li>
                                 </ul>
                     </div>
                     <div class="statistical_information clear">
                           <div class="view_title"><span>统计信息</span></div>
                           <ul class="enterprise_ul enterprise_1 clear">
                                 <li class="fl"><span><?php if(!empty($statistics['satisfactory'])){ echo $statistics['satisfactory']*100;}else{ echo 0;} ?></span>% <label>年满意度</label></li>
                                 <li class="fl"><span><?php  if(!empty($statistics['complain'])){ echo $statistics['complain']*100;}else{ echo 0;} ?></span>%<label>年投诉率</label></li>
                                 <li class="fl"><span><?php if(!empty($statistics['number_sales'])){ echo $statistics['number_sales'];}else{ echo 0;} ?></span>人<label>年销售量</label></li>
                                 <li class="fl"><span>￥<?php if(!empty($statistics['business'])){ echo $statistics['business'];}else{ echo 0;} ?> </span><label>年营业额</label></li>
                                 <li class="fl"><span><?php if(!empty($statistics['integral'])){ echo $statistics['integral'];}else{ echo 0;} ?></span><label>年总积分</label></li>
                           </ul>
                     </div>
                     <div class="dynamic_monitoring clear bordereds">
                           <!-- <div class="view_title"><span>动态监控</span></div> -->
                                 <div  class="dynamic_order clear">
		                              <div class="dynamic_title">订单动态  <span>你有以下订单动态信息未查看---(请点击查看详情)</span></div>
		                                  <ul class="enterprise_ul clear">
		                                  <li class="fl">
	                                     	   	 <a href="/admin/b1/order?type=2">
		                                     	   	 <span class="<?php if(!empty($dynamic[4]['confirm_order'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 	<?php if(!empty($dynamic[4]['confirm_order'])){ if($dynamic[4]['confirm_order']>99){echo '99+';}else{ echo $dynamic[4]['confirm_order'];}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php if(!empty($orderName[1]['name'])){echo  $orderName[1]['name'];}else{ echo '待确认订单';} ?></a>
                                     	  </li>
		                                   <li class="fl">
			                                  <a href="/admin/b1/order?type=01">
				                                <span class="<?php if(!empty($dynamic[5]['leave_order'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[5]['leave_order'])){if($dynamic[5]['leave_order']>99){'99+';}else{ echo $dynamic[5]['leave_order'];}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	&nbsp;&nbsp;<?php //echo  $orderName[0]['name'];?>已确认订单</a>
                                     	   	</li>
                                     
                                 	     	<li class="fl">
                                     	      <a href="/admin/b1/order?cancel=1">
	                                     	      <span class="<?php if(!empty($dynamic[0]['cancel'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                 	      	<?php if(!empty($dynamic[0]['cancel'])){ if($dynamic[0]['cancel']>99){echo '99+';}else{echo $dynamic[0]['cancel'];}}else{ echo 0;} ?>
                                     	      </span>
                                 	      
                                 	      	&nbsp;&nbsp;<?php  if(!empty($orderName[2]['name'])){echo  $orderName[2]['name']; }else{ echo '订单已取消';}?></a>
                                 	     	</li> 
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/order?type=3">
		                                     	   	 <span class="<?php if(!empty($dynamic[2]['c_refund'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[2]['c_refund'])){ if($dynamic[2]['c_refund']>99){ echo '99+';}else{echo $dynamic[2]['c_refund'] ;}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php  if(!empty($orderName[3]['name'])){ echo  $orderName[3]['name'];}else{ echo '客人申请退款';}?></a>
                                     	   	</li>          
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/order?type=33">
		                                     	   	 <span class="<?php if(!empty($dynamic[3]['b2_refund'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[3]['b2_refund'])){ if($dynamic[3]['b2_refund']>99){echo '99+';}else{echo $dynamic[3]['b2_refund'];}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php if(!empty($orderName[4]['name'])){echo  $orderName[4]['name'];}else{ echo '管家申请退款';} ?></a>
                                     	   	</li>
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/order?type=4">
		                                     	   	 <span class="<?php if(!empty($dynamic[1]['a_refund'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[1]['a_refund'])){ if($dynamic[1]['a_refund']>99){echo '99+';}else{ echo $dynamic[1]['a_refund'] ;} }else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php  if(!empty($orderName[5]['name'])){echo  $orderName[5]['name'];}else{echo '平台已退款';}?></a>
                                     	   	</li>
          
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/order?status=7">
		                                     	   	 <span class="<?php if(!empty($dynamic[7]['c_complain'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[7]['c_complain'])){if($dynamic[7]['c_complain']>99){echo '99+';}else{ echo $dynamic[7]['c_complain'];}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php if(!empty($orderName[6]['name'])){ echo  $orderName[6]['name'];}else{ echo '客人已投诉';}?></a>
                                     	   	 </li>
                                     	   	 <li class="fl">
	                                     	   	 <a href="/admin/b1/order?status=6">
		                                     	   	 <span class="<?php if(!empty($dynamic[6]['c_comment'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[6]['c_comment'])){ if($dynamic[6]['c_comment']>99){echo '99+';}else{echo $dynamic[6]['c_comment'];}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php  if(!empty($orderName[7]['name'])){echo  $orderName[7]['name'];}else{ echo '客人发评价';}?></a>
		                                     </li>
		                                     <li class="fl">
	                                     	   	 <a href="/admin/b1/travel_notes?type=1">
		                                     	   	 <span class="<?php if(!empty($dynamic[8]['c_experience'])){ echo 'ha_data';}else{echo 'no_data';}?>">
                                     	   	 <?php if(!empty($dynamic[8]['c_experience'])){ if($dynamic[8]['c_experience']>99){echo '99+';}else{echo $dynamic[8]['c_experience'];}}else{ echo 0;} ?>
	                                     	   	 </span>
                                     	   	 
                                     	   	 &nbsp;&nbsp;<?php  if(!empty($orderName[8]['name'])){echo $orderName[8]['name'];}else{echo '客人发体验';}?>
                                     	   	 </a>
		                                     </li>
		                                 </ul>
                                    </div>
                                    <div  class="dynamic_custom clear">
	                                     <div class="dynamic_title">定制单动态  <span>你有以下定制单信息---(请点击查看详情)</span></div>
		                                 <ul class="enterprise_ul">
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/enquiry_order">
		                                     	   	 <span class="<?php if(!empty($custom['inquiry'])){ echo 'ha_data';}else{echo 'no_data';}?>">
		                                     	   	 	<?php if(!empty($custom['inquiry'])){ if($custom['inquiry']>99){echo '99+';}else{ echo $custom['inquiry'];}}else{ echo 0;} ?>
		                                     	   	 </span>
	                                     	   	 
	                                     	    &nbsp;&nbsp; 抢询价单</a>
                                     	   	</li>
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/enquiry_order?type=1">
		                                     	   	 <span class="<?php if(!empty($custom['inquiry_1'])){ echo 'ha_data';}else{echo 'no_data';}?>">
		                                     	   	 	<?php if(!empty($custom['inquiry_1'])){ if($custom['inquiry_1']>99){echo '99+';}else{ echo $custom['inquiry_1'];}}else{ echo 0;} ?>
		                                     	   	 </span>
	                                     	   	&nbsp;&nbsp; 指定单</a>
                                     	   	</li>
                                     	   	<li class="fl">
	                                     	   	 <a href="/admin/b1/enquiry_order?type=4">
		                                     	   	 <span class="<?php if(!empty($custom['bidding'])){ echo 'ha_data';}else{echo 'no_data';}?>">
		                                     	   	 <?php if(!empty($custom['bidding'])){if($custom['bidding']>99){echo '99+';}else{ echo $custom['bidding'];}}else{ echo 0;} ?>
		                                     	   	 </span>
	                                     	   	 
	                                     	   	 &nbsp;&nbsp;管家中标单</a>
                                     	   	</li> 
		                                  </ul>
                                    </div>
                                    <div  class="dynamic_custom clear">
	                                     <div class="dynamic_title">产品汇总动态  <span>你有以下产品信息---(请点击查看详情)</span></div>
	                                      <ul class="enterprise_ul clear">
                                     	   <!--  <li class="fl">
	                                     	     <a href="/admin/b1/product?type=1">
	                                     	     <span class="<?php //if(!empty($line['line_num1'])){ echo 'ha_data';}else{echo 'no_data';}?>">
	                                     	     <?php// if(!empty($line['line_num1'])){if($line['line_num1']>99){echo '99+';}else{ echo $line['line_num1'];}}else{ echo 0;} ?>
	                                     	     </span>
	                                     	     </a>
	                                     		  &nbsp;&nbsp;审核中线路数量
                                     	       </li>  -->  
    	                                     	<li class="fl">
    		                                     	<a href="/admin/b1/product?type=2">
    			                                     	<span class="<?php if(!empty($line['line_num2'])){ echo 'ha_data';}else{echo 'no_data';}?>">
    			                                     	<?php if(!empty($line['line_num2'])){if($line['line_num2']>99){echo '99+';}else{ echo $line['line_num2'];}}else{ echo 0;} ?>
    			                                     	</span>
    		                                     	   	 
    		                                     	   	 &nbsp; &nbsp;已核准</a>
    	                                     	</li>            
    	                                 	   	<li class="fl" style="margin-left:0px">
    	                                     	   	 <a href="/admin/b1/product?type=3">
    		                                     	   	 <span class="<?php if(!empty($line['line_num3'])){ echo 'ha_data';}else{echo 'no_data';}?>">
    		                                     	   	 <?php if(!empty($line['line_num3'])){ if($line['line_num3']>99){echo '99+';}else{echo $line['line_num3'];}}else{ echo 0;} ?>
    		                                     	   	 </span>
    	                                     	   	 
    	                                     	   	 &nbsp;&nbsp;已退回</a>
    	                                 	       	</li>  
                                         	   	<li class="fl">
    	                                     	   	 <a href="/admin/b1/product?type=0">
    		                                     	   	 <span class="<?php if(!empty($line['line_num0'])){ echo 'ha_data';}else{echo 'no_data';}?>">
    		                                     	   	 <?php if(!empty($line['line_num0'])){if($line['line_num0']>99){echo '99+';}else{ echo $line['line_num0'];}}else{ echo 0;} ?>
    		                                     	   	 </span>
    	                                     	   	 
    	                                     	  	 &nbsp;&nbsp;已下架</a>
                                         	   	</li>
		                                    </ul>
	                                   </div>
                                       <div  class="housekeeper_statistics clear">
	                                        <div class="dynamic_title exper_title">管家统计  <!-- <span>(直属管家显示0时)没有直属管家,立即<a href="#">注册</a>直属管家</span> --></div>
	                                     	 <ul class="housekeeperDynamic">
	                                     	   	 <!-- <li class="col_li fl"><label style="text-align:left;">截至目前有</label></li> -->
	                                     	 
	                                     	   	 <li class="fl">
		                                     	   	 <a href="/admin/b1/app_line?type=1">
			                                     	   	 <span class="<?php if(!empty($expert['expert_number'])){ echo 'ha_data';}else{echo 'no_data';}?>">
			                                     	   	 <?php if(!empty($expert['expert_number'])){if($expert['expert_number']>99){echo '99+';}else{ echo $expert['expert_number'];}}else{ echo 0;} ?>
			                                     	   	 </span>
			                                     	   	 &nbsp;&nbsp;管家
		                                     	   	 </a>
	                                     	   	 </li>
	                                     	   	 <li class="fl">
		                                     	   	<a href="/admin/b1/app_line?type=2">
			                                     	   	 <span class="<?php if(!empty($expert['expert1_number'])){ echo 'ha_data';}else{echo 'no_data';}?>">
			                                     	   	 <?php if(!empty($expert['expert1_number'])){ if($expert['expert1_number']>99){echo '99+';}else{echo $expert['expert1_number'];}}else{ echo 0;} ?>
			                                     	   	 </span>
			                                     	   	 &nbsp;&nbsp;初级专家
		                                     	   	</a>
	                                     	   	 </li>
	                                     	   	 <li class="fl">
		                                     	   	<a href="/admin/b1/app_line?type=3">
			                                     	   	 <span class="<?php if(!empty($expert['expert2_number'])){ echo 'ha_data';}else{echo 'no_data';}?>">
			                                     	   	 <?php if(!empty($expert['expert2_number'])){ if($expert['expert2_number']>99){echo '99+';}else{echo $expert['expert2_number'];}}else{ echo 0;} ?>
			                                     	   	 </span>
			                                     	   	 &nbsp;&nbsp;中级专家
		                                     	   	</a>
	                                     	   	 </li>
	                                     	   	 <li class="fl">
		                                     	   	<a href="/admin/b1/app_line?type=4">
			                                     	   	 <span class="<?php if(!empty($expert['expert3_number'])){ echo 'ha_data';}else{echo 'no_data';}?>">
			                                     	   	 <?php if(!empty($expert['expert3_number'])){ if($expert['expert3_number']>99){echo '99+';}else{echo $expert['expert3_number'];}}else{ echo 0;} ?>
			                                     	   	 </span>
			                                     	   	&nbsp;&nbsp; 高级专家
		                                     	   	</a>
	                                     	   	 </li>
	                                     	     	<li class="fl"><a href="/admin/b1/directly_expert">
		                                     	     	<span  class="<?php if(!empty($expert['under_expert'])){ echo 'ha_data';}else{echo 'no_data';}?>" ><?php if(!empty($expert['under_expert'])){ echo $expert['under_expert'];}else{ echo 0;} ?>
		                                     	     	</span>&nbsp;&nbsp;专家申请</a>
	                                     	     	</li>
	                                     	  
	                                     	     	<li class="fl">
		                                     	   	 <a href="/admin/b1/directly_expert?type=2">
			                                     	   	 <span class="<?php if(!empty($expert['expert3_number'])){ echo 'ha_data';}else{echo 'no_data';}?>">
			                                     	   	 <?php if(!empty($expert['opare_expert'])){ if($expert['opare_expert']>99){echo '99+';}else{echo $expert['opare_expert'];}}else{ echo 0;} ?>
			                                     	   	 </span>
			                                     	   	&nbsp;&nbsp;平台批复专家
		                                     	   	 </a>
	                                     	    	</li>
	                                     	 </ul>
                                       </div> 
                                   	 <!--    <div  class="dynamic_exper clear">
	                                     	  	 <div class="dynamic_title ">管家动态  </div>
		                                     	   <ul>
		                                     	   	 <li class="col_li fl">截至目前有</li>
		                                     	   	 <li class="fl"><a href="#">您有<span>(999)</span>位专家提出申请</a></li>
		                                     	   	 <li class="fl"><a href="#">您有<span>(999)</span>位管家提问</a></li>
		                                     	   	 <li class="fl"><a href="#">您有<span>(999)</span>位新专家申请得到平台批复/退回</a></li>
		                                     	   
		                                     	   </ul>
                                                 </div> -->
                                    <!--            <div  class="application_for clear">
	                                     	   <div class="dynamic_title">结款申请  </div>
	                                     	   <div class="product_div">你有<span>(25)</span>位管家结款申请，<a href="/admin/b1/account">请点击查看详情</a></div>
                                                    </div>  -->
                                       <div  class="platform_announced clear">
	                                       <div class="dynamic_title">平台公告  </div>
	                                       <div class="product_div">你有&nbsp;<span  class="<?php if(!empty($platform['publish'])){ echo 'ha_data';}else{echo 'no_data';}?>"><?php if(!empty($platform['publish'])){ if($platform['publish']>99){echo '99+';}else{echo $platform['publish'];}}else{ echo 0;} ?> </span>&nbsp;条平台公告尚未查看，<a href="/admin/b1/messages">请点击查看详情</a></div>
                                      </div>             
                             </div>
                       </div> 
				</div>
            </div>
      </div>


