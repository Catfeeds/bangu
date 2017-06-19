<style type="text/css">
.c_reply{width: 95%;}
  .c_travel_content div,.c_travel_day{ width:70%; font-size: 13px;}
  .c_travel_img div ul{ margin-left: 70px;}.c_travel_img div { width: 100%}
  .c_travel_img div ul{ width: auto}
.c_travel_title{ font-weight: 500; color: #333;}
  .td_2{width: auto;}
  .c_reply_travel{width: 100%}
  .c_travel_title{font-size: 13px;}
   label{font-size: inherit;}
  .form-control, select{font-size: inherit;}
   .need_kj input,.need_kj select { height: 35px; width: 230px;}
   .col_div{ width: 450px;font-size: 12px}
   .need_kj{ margin-bottom: 10px;font-size: 12px;}
   .require_content{width:300px;}
     .c_travel_content{ min-height: 40px; line-height: 40px;}
     .house_price span{ line-height:25px;}
     .c_guest_need{min-height: 360px;}
</style>
<div class="c_reply">
  <div class="c_reply_title">查看回复方案</div>
    <div class="c_guest_need" >
    	<p>客人需求</p>
      <!--   <table width="80%" border="0" class="c_guest_need_detail"> -->
        <?php if(!empty($grab_custom_data)):?>

  <div class="need_kj clear">
      <div class=" col_div fl">
      <div class="c_bianhao fl"><span>编号</span><div><?php echo $c_id?></div></div>
    </div>

  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
    <label class="td_1"height="40">出发城市：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['startplace']?></span>
    </div>
    <div class="fl">
    <label class="td_1" height="40">目 的 地：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['endplace_name']?></span>
    </div>
  </div>
   <div class="need_kj clear">
    <div class="col_div fl">
    <label class="td_1" height="40">定制类型：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['custom_type']?></span>
    </div>
    <div class="fl">
   <label class="td_1" height="40">希望人均预算：</label>
      <span class="td_2" height="40" class="c_red_color">￥ <b><?php echo $grab_custom_data['budget']?></b> /人</span>
    </div>
  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
     <label class="td_1" height="40">出行日期：</label>
     <?php if(!empty($grab_custom_data['startdate'])):?>
    <span class="td_2" height="40"><?php echo $grab_custom_data['startdate']?>(确定)</span>
  <?php else:?>
     <span class="td_2" height="40"><?php echo $grab_custom_data['estimatedate']?>(预估)</span>
   <?php endif;?>
    </div>
    <div class="fl">
    <label class="td_1" height="40">希望出游时长：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['days']?>&nbsp;天</span>
    </div>
  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
    <label class="td_1"height="40">出游方式：</label>
    <span class="td_2" height="40"><?php if(!empty($grab_custom_data['another_choose'])){echo $grab_custom_data['trip_way'].'/'.$grab_custom_data['another_choose'];}else{echo $grab_custom_data['trip_way'];} ?></span>
    </div>
   <!--  <div class="fl">
    <label class="td_1" height="40">单项选择：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['another_choose']?></span>
    </div> -->
  </div>

   <div class="need_kj clear">
  <div class="col_div fl">
     <label class="td_1" height="40">总人数：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['total_people']?>&nbsp;&nbsp;人</span>
    </div>
    <div class="fl">
    <label class="td_1" height="40">用房数：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['roomnum']?></span>间

    </div>
  </div>
   <div class="need_kj clear">
  <div class="col_div fl">
    <label class="fl">出游人：</label>
        <div height="40" class="fl">  <span><?php echo $grab_custom_data['people']?></span>&nbsp;(成人)&nbsp;/&nbsp;</div>
         <div class="fl"><span><?php echo $grab_custom_data['childnum']?></span> &nbsp;(占床儿童)&nbsp;/&nbsp;</div>
          <div class="fl"> <span><?php echo $grab_custom_data['childnobednum']?></span>&nbsp;(不占床儿童)&nbsp;/&nbsp;</div>
           <div class="fl"> <span><?php echo $grab_custom_data['oldman']?></span>&nbsp;(老人)&nbsp;</div>
</div>
<div class="fl">
    <label class="td_1" height="40">用房要求：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['room_require']?></span>
    </div>
  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
    <label class="td_1" height="40">要求用餐：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['catering']?></span>
</div>
<div class="fl">
    <label class="td_1" height="40">要求酒店：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['hotelstar']?></span>
    </div>
  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
    <label class="td_1" height="40">购物自费：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['isshopping']?></span>
</div>
<div class="fl">
   <label class="td_1" height="40">详细需求概述：</label>
    <span class="td_2" colspan=""><?php echo $grab_custom_data['service_range']?></span>
    </div>

  </div>

    <!--  <div class="need_kj clear">
    <div class="fl">
      <label class="td_1" height="40">详细需求概述：</label>
    <span class="td_2" colspan=""><?php echo $grab_custom_data['service_range']?></span>
    </div>
    </div> -->

    <!-- <div style="font-size:12px;">
     <label class="td_1" height="40">详细需求概述：</label>
    <span class="td_2" colspan=""><?php echo $grab_custom_data['service_range']?></span>
    </div> -->



  <?php endif;?>
<!-- </table> -->

    </div>
    <div class="house_price">
        <p>管家报价</p>
        <div class="house_price_details">
                  <div class="col_details fl">
                       <label class="fl">成人价：</label>
                       <div height="40" class="fl"> <span class="td_2" colspan="1">￥<b><?php echo $grab_custom_data['price']?></b>/人</span></div>
                </div>
                 <div class="col_details  fl">
                      <label class="fl">儿童占床价：</label>
                      <div height="40" class="fl"> <span class="td_2" colspan="">￥<b><?php echo $grab_custom_data['childprice']?></b>/人</span></div>
                 </div>
                <div class="col_details fl">
                     <label class="fl">儿童不占床价：</label>
                     <div height="40" class="fl"><span class="td_2" colspan="1">￥<b><?php echo $grab_custom_data['childnobedprice']?></b>/人</span></div>
                </div>
                 <div class=" fl">
                     <label class="fl">老人价：</label>
                     <div height="40" class="fl"> <span class="td_2" colspan="">￥<b><?php echo $grab_custom_data['oldprice']?></b>/人</span></div>
                </div>
              <div class="price_description" style="margin-bottom:-100">
                  <label class="fl">价格说明：</label>
                  <span><?php echo $grab_custom_data['price_description']?></span>
        </div>
        </div>
    </div>
    <div class="c_reply_content_detial">
      <p style="margin-top:5px;">行程设计</p>
      <div class="c_travel_traffic"><span class="">总体描述：</span>
        <?php if(!empty($grab_custom_data['plan_design'])){ echo $grab_custom_data['plan_design'];}else{ echo '暂无信息';} ?>     </div>
<?php foreach ($custom_trip_data_list as $item): ?>


      <div class="c_reply_travel">
      <p class="day_reply">第<?php echo $item['cj_day']?>天</p>
        <div class="c_travel_day"><span class="c_travel_title">标题：</span>
         <?php echo $item['cj_title']?>
        </div>
        <div class="c_travel_traffic"><span class="c_travel_title">交通：</span>
         飞机        </div>
          <div class="c_travel_meals"><span class="c_travel_title fl">用餐：</span>
             <div class="fl"><span>早餐</span>(自助) /</div>
             <div class="fl"><span>午餐</span>(自助)/ </div>
             <div class="fl"><span>晚餐</span>(自助) </div>
          </div>
        <div class="c_travel_content"> <span class="c_travel_title">行程：</span>
        	<div><?php echo $item['cj_jieshao']?></div>
        </div>
        <div class="c_travel_img clear">
          <span class="c_travel_title">行程图片：</span>
          <div>
          <ul class="clear">
           <?php if(isset($item['pic_arr'])&&count($item['pic_arr'])!=0):?>
               <?php foreach ($item['pic_arr'] as $val): ?>
                  <li ><img src="<?php echo $val;?>"></li>
               <?php endforeach;?>
             <?php endif;?>
          </ul>
          </div>
        </div>

      </div>
      <?php endforeach;?>
     <div class="c_travel_content"> <span class="c_travel_title">附件：</span>
          <div>
            <?php if(!empty($grab_custom_data['attachment'])):?>
              <a href='<?php echo base_url().$grab_custom_data['attachment']?>'>附件下载</a>
              <?php else:?>
              暂无附件
            <?php endif;?>
          </div>
        </div>
      <div>
        	<span class="c_close_page" style="padding:5px 30px;background:#57b5e3;border-radius:5px;cursor:pointer;color:#fff;margin-left:40%;position:relative;">关闭</span>
      </div>
      <div style="height:100px;width:100%;"></div>
    </div>
</div>
<script type="text/javascript">
	$(function(){
		$('.c_close_page').click(function(){
			window.close();
		});
	});
</script>