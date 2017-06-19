<link href="<?php echo base_url('assets/css/b2_admin.css');?>" rel="stylesheet" />
<!-- 申请拍照 -->
<link href="<?php echo base_url(); ?>assets/css/registerb-2.css" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bens {
    background: #09c;
    outline: none;
    border: none;
    color: #fff;
    border-radius: 2px;
    padding: 5px 8px !important;
}
  .conmen_zhong span{ height: 27px; line-height: 27px; }
  a:hover{ color: #fff;text-decoration: none;}
</style>
<!--shadow-->
<div class="page-body column" style=" padding:20px;">
	<div class="person_info boostBlue">
    	<div class="person_info_txt shadow">
          <!--  <div class="person_photo fl"><img src="<?php echo $home_data['small_photo']?>" onclick="change_avatar();" style="cursor:pointer"></div>-->
          <div class="person_photo fl"><img src="<?php echo $home_data['small_photo']?>" style="cursor:pointer"></div>
            <div class="person_introduce fl ">
                <div class="fl" style="margin-right:35%;"><label>真实姓名：</label><?php echo $home_data['realname']?></div>
                <!-- <div class="">账户名：<?php echo $home_data['login_name']?></div> -->
                <div class="last_login_time">上次登录时间：<?php echo $last_login_time?></div>
                <div class="nichen clear" ><label>昵称：</label><?php echo $home_data['nickname']?></div>
                <?php if(!empty($expert_museum)){ ?>
                <div class="nichen clear" style="margin-top:0px;float:left;"><label>已申请：</label><?php if($expert_museum['status']==1){echo '<a href="###"  onclick="apply_take_photos(this);" >已拍摄</a>';}else{echo '<a href="###"  onclick="apply_take_photos(this);">未拍摄</a>';} ?></div>
                <?php }else{?>
              	<div class="conmen_zhong" style="font-size:12px;margin:-10px 0px 0px 16px;float:left;"><span style="background:#ff9933;" class="apply_take_photo" onclick="apply_take_photos(this);">申请拍照</span>
              	<?php }?>
                <?php if($is_commit==0 && $e_status!=1):?>
                
                  <a class='bens' href="<?php echo base_url('admin/b2/expert/update?apply_bangu=1')?>">申请帮游管家</a>
                </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <!--  拍照弹框  -->
		<div class="bg" style="display:none;"></div>
		<div class="take_photo_box" style="display:none;height:auto;">
			<div class="box_header" style="height:40px; ">申请免费拍照<span class="close_photo_box" onClick="close_photo_box(this)">×</span></div>
		    <form action="" method="post" id="photo_shop_form">
		    	<div class="choose_address clear">
		    		  <div class="erweima address_list"><img src="<?php if(!empty($expert_museum)){ echo $expert_museum['qrcode'];}else{ echo '/file/qrcodes/0_qr.png';} ?>"/>
		    		  	<span style="float:left;width:30px;margin-top:10px;padding-left:10px;">注:</span>
		                	<div style="float:left;width:350px;margin-top:10px;">
		                    	<p style=" margin-bottom:5px;">1、请自行将二维码截图保存，拍摄完成后提供给摄影师扫描确认。</p>
		      					<p style=" margin-bottom:5px;">2、二维码扫描确认后将失效，每人仅有一次拍摄机会，切记在拍摄前避免被误扫。</p>
		                    </div>
		    		  </div>
		        	  <?php if(!empty($expert_museum)){ //管家已申请的信息
		        	  ?>
			        	  <div class="address_list">
			           			<label><span class="shop_name">地址 : <?php echo $expert_museum['name']; ?></span>—><span class="shop_address"><?php echo $expert_museum['address']; ?></span></label>
			           			<p style="padding-left:10px">联系人：<?php echo $expert_museum['linkman']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：<?php echo $expert_museum['linkmobile']; ?></p>
			             </div>
		        	  <?php
						 }else{   //管家未申请的照相馆信息
		        	  ?>
			        	  <?php  if(!empty($museum)){
			        		foreach ($museum as $k=>$v){
			        	  ?>
			             <div class="address_list">
			            	<?php echo $k+1 ?>.<label><input type="radio" style="left:0px;opacity:1;" name="photo_shop" value="<?php echo $v['id'] ?>"/>
			           		<span class="shop_name"><?php echo $v['name']; ?></span>—><span class="shop_address"><?php echo $v['address']; ?></span></label>
			           		<p>联系人：<?php echo $v['linkman']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：<?php echo $v['linkmobile']; ?></p>
			             </div>
			             <?php } } ?>
		            	 <div class="address_list"><span id="submit_address" onClick="click_submit(this);">确认</span><input type="submit" name="submit" value="确认" style="display:none;"/></div>
		             <?php }?>
		        </div>
		    </form>
		</div>
		<!-- 拍照弹框 end -->

    </div>

    <div class="boostBorder boostBlue" style=" margin-bottom:3px;">
        <div class="clear col_person shadow" >
            <div class="zongxiao clear" style=" margin-left:15px;">
                <div class="sales_numbers fl" >您截至目前已销<span ><?php echo $home_data['people_count']?></span>人</div>
                <div class="sales_money fl">总营业额<span ><?php echo number_format($home_data['total_turnover'],2)?></span>元</div>
                <div class="total_integral fl">总积分<span ><?php echo $home_data['total_score']?></span>分</div>
           </div>
             <!--<div class=" fl" style=" border:1px solid #e1e1e1; height:22px; margin-left:3%;"></div> -->
            <div class="zongpg clear" style=" margin-top:20px;">
                 <div class="col_li published_information fl"><i class="icon5 icon"></i>满意度<span><?php echo ($home_data['satisfaction_rate']*100).'%'?></span></div>
                <div class="col_li put_questions fl" style=""><i class="icon6 icon"></i>投诉率<span><?php echo ($home_data['complain_rate']*100).'%'?></span></div>
            </div>
        </div>
    </div>

    <div class="order_information clear">
        <div class="boostBlue boostBorder boostmarginBottom20">
            <div class="work_content clear shadow">
              <span class="content_title fl">我的查询:</span>

                <ul class="fl clear" style="">
                 <li class=" fl"><a href="<?php echo base_url()?>admin/b2/question/no_answer"><!-- <i class="icon8 "></i> --> <?php if($home_data['client_ask']==0):?>
                    <span class="no_data"><?php echo $home_data['client_ask']?></span>
                  <?php elseif ($home_data['client_ask']>0 && $home_data['client_ask']<100):?>
                    <span class="ha_data"><?php echo $home_data['client_ask']?></span>
                  <?php else:?>
                    <span class="ha_data">99+</span>
                  <?php endif;?>&nbsp;客人提问

                        </a></li>
                    <li class="fl"><a href="<?php echo base_url()?>admin/b2/message/system"><!-- <i class="icon7 icon "></i> -->  <?php if($home_data['unread_sys_msg']==0):?>
                    <span class="no_data"><?php echo $home_data['unread_sys_msg']?></span>
                  <?php elseif ($home_data['unread_sys_msg']>0 && $home_data['unread_sys_msg']<100):?>
                    <span class="ha_data"><?php echo $home_data['unread_sys_msg']?></span>
                  <?php else:?>
                    <span class="ha_data">99+</span>
                  <?php endif;?>&nbsp;平台新公布
                 <!--   <span class="ha_data"><?php echo $home_data['unread_sys_msg']?></span> -->

                   </a></li>
                  <li class="fl"><a href="<?php echo base_url('admin/b2/grab_custom_order/index')?>"><!-- <i class="icon1 "></i> --> <?php if($home_data['guest_order']==0):?>
                    <span class="no_data"><?php echo $home_data['guest_order']?></span>
                  <?php elseif ($home_data['guest_order']>0 && $home_data['guest_order']<100):?>
                    <span class="ha_data"><?php echo $home_data['guest_order']?></span>
                  <?php else:?>
                    <span class="ha_data">99+</span>
                  <?php endif;?>&nbsp;抢定制单
                   </a></li>


                    <li class="fl"><a href="<?php echo base_url('admin/b2/grab_custom_order/index?tab=2')?>">
                    <?php if($home_data['guest_awser_order']==0):?>
                    <span class="no_data"><?php echo $home_data['guest_awser_order']?></span>
                  <?php elseif ($home_data['guest_awser_order']>0 && $home_data['guest_awser_order']<100):?>
                    <span class="ha_data"><?php echo $home_data['guest_awser_order']?></span>
                  <?php else:?>
                    <span class="ha_data">99+</span>
                  <?php endif;?>&nbsp;客人回单
                    </a></li>


                     <li class="fl"><a href="<?php echo base_url('admin/b2/inquiry_sheet/index?tab=1')?>"><?php if($home_data['supplier_awser_order']==0):?>
                    <span class="no_data"><?php echo $home_data['supplier_awser_order']?></span>
                  <?php elseif ($home_data['supplier_awser_order']>0 && $home_data['supplier_awser_order']<100):?>
                    <span class="ha_data"><?php echo $home_data['supplier_awser_order']?></span>
                  <?php else:?>
                    <span class="ha_data">99+</span>
                  <?php endif;?>&nbsp;供应商回单
                    </a></li>
                </ul>
           </div>
       </div>



       <div class="order_information clear">
        <div class="boostBlue boostBorder boostmarginBottom20 shadow">
           <span  class="fl" style=" border-top: 1px solid #e4e4e4;">&nbsp;&nbsp;&nbsp;订单信息 : </span>
           <div class="order_details clear">
              <ul class="clear" style="max-width:1000px;padding-top:10px">
               <?php foreach ($order_status as $key => $value):?>
              <li class="fl">
              <a  href="<?php echo base_url()?>admin/b2/order/index?<?php echo 'status='.$value['order_status'].'&pay_status='.$value['order_ispay']?>">
                 <?php if($value['order_ispay']==0 && $value['order_status']==-4){
                  if($home_data['cancel_order']==0){
                    echo " <span class='no_data'>".$home_data['cancel_order']."</span>";
                  }elseif($home_data['cancel_order']>0 && $home_data['cancel_order']<100){
                    echo " <span class='ha_data'>".$home_data['cancel_order']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==0 && $value['order_status']==0){
                  //echo $home_data['client_kongwei'];
                  if($home_data['client_kongwei']==0){
                    echo " <span class='no_data'>".$home_data['client_kongwei']."</span>";
                  }elseif($home_data['client_kongwei']>0 && $home_data['client_kongwei']<100){
                    echo " <span class='ha_data'>".$home_data['client_kongwei']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==0 && $value['order_status']==1){
                  //echo $home_data['supplier_kongwei'];
                  if($home_data['supplier_kongwei']==0){
                    echo " <span class='no_data'>".$home_data['supplier_kongwei']."</span>";
                  }elseif($home_data['supplier_kongwei']>0 && $home_data['supplier_kongwei']<100){
                    echo " <span class='ha_data'>".$home_data['supplier_kongwei']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==1 && $value['order_status']==1){
                  //echo $home_data['client_pay'];
                  if($home_data['client_pay']==0){
                    echo " <span class='no_data'>".$home_data['client_pay']."</span>";
                  }elseif($home_data['client_pay']>0 && $home_data['client_pay']<100){
                    echo " <span class='ha_data'>".$home_data['client_pay']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==2 && $value['order_status']==1){
                  //echo $home_data['admin_receive'];
                  if($home_data['admin_receive']==0){
                    echo " <span class='no_data'>".$home_data['admin_receive']."</span>";
                  }elseif($home_data['admin_receive']>0 && $home_data['admin_receive']<100){
                    echo " <span class='ha_data'>".$home_data['admin_receive']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==2 && $value['order_status']==4){
                  //echo $home_data['supplier_confirm'];
                  if($home_data['supplier_confirm']==0){
                    echo " <span class='no_data'>".$home_data['supplier_confirm']."</span>";
                  }elseif($home_data['supplier_confirm']>0 && $home_data['supplier_confirm']<100){
                    echo " <span class='ha_data'>".$home_data['supplier_confirm']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==2 && $value['order_status']==6){
                  //echo $home_data['client_comment'];
                  if($home_data['client_comment']==0){
                    echo " <span class='no_data'>".$home_data['client_comment']."</span>";
                  }elseif($home_data['client_comment']>0 && $home_data['client_comment']<100){
                    echo " <span class='ha_data'>".$home_data['client_comment']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==2 && $value['order_status']==7){
                  //echo $home_data['client_complain'];
                  if($home_data['client_complain']==0){
                    echo " <span class='no_data'>".$home_data['client_complain']."</span>";
                  }elseif($home_data['client_complain']>0 && $home_data['client_complain']<100){
                    echo " <span class='ha_data'>".$home_data['client_complain']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==3 && $value['order_status']==-3){
                  //echo $home_data['tuiding'];
                  if($home_data['tuiding']==0){
                    echo " <span class='no_data'>".$home_data['tuiding']."</span>";
                  }elseif($home_data['tuiding']>0 && $home_data['tuiding']<100){
                    echo " <span class='ha_data'>".$home_data['tuiding']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==4 && $value['order_status']==-4){
                  //echo $home_data['yituiding'];
                  if($home_data['yituiding']==0){
                    echo " <span class='no_data'>".$home_data['yituiding']."</span>";
                  }elseif($home_data['yituiding']>0 && $home_data['yituiding']<100){
                    echo " <span class='ha_data'>".$home_data['yituiding']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                }elseif($value['order_ispay']==2 && $value['order_status']==5){
                  //echo $home_data['go_start'];
                  if($home_data['go_start']==0){
                    echo " <span class='no_data'>".$home_data['go_start']."</span>";
                  }elseif($home_data['go_start']>0 && $home_data['go_start']<100){
                    echo " <span class='ha_data'>".$home_data['go_start']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
                } ?>
              <span  class="details_span"><?php echo $value['description']?>&nbsp;</span>
              </a>
              </li>
                <?php endforeach;?>
                <li class="fl">
              <a  href="<?php echo base_url('travels/travels_list')?>" target='_blank'>
              <?php if($home_data['tiyan']==0){
                    echo " <span class='no_data'>".$home_data['tiyan']."</span>";
                  }elseif($home_data['tiyan']>0 && $home_data['tiyan']<100){
                    echo " <span class='ha_data'>".$home_data['tiyan']."</span>";
                  }else{
                    echo " <span class='ha_data'>99+</span>";
                  }
              ?>
              <span  class="details_span">客人发体验&nbsp;</span>
              </a>
              </li>
              </ul>
           </div>
            </div>
           </div>

    </div>





    <div class="order_information clear">
        <div class="boostBlue boostBorder boostmarginBottom20 shadow">
           <span style="" class="fl">&nbsp;&nbsp;&nbsp;售卖级别申请 : </span>
           <div class="Application_sale clear">
              <ul style="padding-top:10px;" class="clear">
                  <li class="fl">
                                <a href="<?php echo base_url('')?>admin/b2/upgrade/search?apply_grade=2&apply_status=2">
                                 <?php if($home_data['level_count_2']==0):?>
                                         <span class="no_data"><?php echo $home_data['level_count_2']?></span>
                                  <?php elseif($home_data['level_count_2']>0 &&$home_data['level_count_2']<100):?>
                                         <span class="ha_data"><?php echo $home_data['level_count_2']?></span>
                                   <?php else:?>
                                           <span class="ha_data">99+</span>
                                 <?php endif;?><label>初级专家</label>&nbsp;<i class="icon9 icon_ca"></i>
                                </a>
                   </li>

                  <li class="fl">
                                <a href="<?php echo base_url('')?>admin/b2/upgrade/search?apply_grade=3&apply_status=2">
                                <?php if($home_data['level_count_3']==0):?>
                                         <span class="no_data"><?php echo $home_data['level_count_3']?></span>
                                <?php elseif($home_data['level_count_3']>0 &&$home_data['level_count_3']<100):?>
                                        <span class="ha_data"><?php echo $home_data['level_count_3']?></span>
                                <?php else:?>
                                        <span class="ha_data">99+</span>
                                <?php endif;?>
                                <label>中级专家</label>&nbsp;<i class="icon9 icon_ca"></i>
                                </a>
                  </li>

                  <li class="fl">
                                <a href="<?php echo base_url('')?>admin/b2/upgrade/search?apply_grade=4&apply_status=2">
                                <?php if($home_data['level_count_4']==0):?>
                                        <span class="no_data"><?php echo $home_data['level_count_4']?></span>
                                <?php elseif($home_data['level_count_4']>0 &&$home_data['level_count_4']<100):?>
                                        <span class="ha_data"><?php echo $home_data['level_count_4']?></span>
                                <?php else:?>
                                        <span class="ha_data">99+</span>
                                <?php endif;?>
                                <label>高级专家</label>&nbsp;<i class="icon9 icon_ca"></i>
                                </a>
                  </li>
              </ul>
           </div>
            <div>
    </div>
</div>
<script type="text/javascript">
function apply_take_photos(obj){
	$(".take_photo_box").show();
	$(".bg").show();
}

//关闭选择照相馆弹框
function close_photo_box(obj){
	$(".take_photo_box").hide();
	$(".bg").hide();
}
//提交申请拍照
function click_submit(obj){

	//photo_shop_form
	jQuery.ajax({ type : "POST",data : jQuery('#photo_shop_form').serialize(),url : "<?php echo base_url()?>admin/b2/home/save_expert_museum",
		 success : function(data) {
			 var data=eval("("+data+")");
			  if(data.status==1){
				  alert(data.msg);
				  location.reload();
				  }else{
					  alert(data.msg);
				}
			}
		});
	return false;


}
</script>
