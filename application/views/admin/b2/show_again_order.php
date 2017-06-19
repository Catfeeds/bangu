<style type="text/css">

  .td_2{width: auto;}
  .td_2 input{ padding-left: 8px}
  .travel_day input,.travel_content textarea{width:72%;}
 .reply_content_detial textarea,.travel_content textarea{padding-left: 8px;}
  .reply_botton input{background: #00b7ee; border-radius: 4px;}
/*  .go_inquiry_form{ font-size: inherit;}*/
  label{font-size: inherit;}
  .form-control, select{font-size: inherit;}
   .need_kj input,.need_kj select { height: 30px; width: 230px;line-height: 30px;}
   .col_div{ width: 450px;}
   .need_kj{ margin-bottom: 10px}
   .require_content{width:300px;}
 /*  #go_inquiry_form{width:80%}*/
 .c_require_content { height:50px; width:600px;resize:none;font-size:16px;}
.day_reply{ color: #6cf;text-align: center;}
.c_travel_traffic,.c_travel_meals{height: 40px;line-height: 40px}
.house_price_details span{ line-height: 25px}
.guest_need{ min-height: 385px}
</style>
<div class="reply">
  <div class="reply_title">转询价单</div>
   <form id="again_inquiry_form" method="post" action="#">
        <div class="guest_need">
      <p>客人需求</p>
  <div class="guest_need_detail" border="0" style="">
      <div class="need_kj clear">
      <div class=" col_div fl">
      <div class="c_bianhao fl"><span>编号</span><div><?php echo $c_id?></div></div>
    </div>
     <div class="">
        <label style="margin-top:5px;" class="fl">供&nbsp; 应&nbsp;  商：</label>
        <div height="40" class="fl">
       <select name="supplier_id">
              <option value="">--全部--</option>
              <?php foreach ($suppliers as $val) {
                echo "<option value='{$val ['id']}'>{$val ['realname']}</option>";
              }?>
  </select>
        </div>
  </div>
  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
    <label height="40" class="td_1">出发城市：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['startplace']?></span>
    </div>
    <div class="fl">
    <label height="40" class="td_1">目 的 地：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['endplace']?></span>
    </div>
  </div>
   <div class="need_kj clear">
  <div class="col_div fl">
     <label height="40" class="td_1">出行日期：</label>
    <span height="40" class="td_2"><?php if(!empty($grab_custom_data['estimatedate'])){echo $grab_custom_data['estimatedate'].'(预估)';}else{ echo $grab_custom_data['startdate'].'(确认)';}?></span>
    </div>
    <!--   <div class="col_div fl">
     <label height="40" class="td_1">预估日期：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['estimatedate']?></span>
    </div> -->
      <div class=" fl">
    <label height="40" class="td_1">出游方式：</label>
    <span height="40" class="td_2"><?php if(!empty($grab_custom_data['another_choose'])){ echo $grab_custom_data['trip_way'].'/'.$grab_custom_data['another_choose'];}else{ echo $grab_custom_data['trip_way'];}?></span>
    </div>

  </div>
  <div class="need_kj clear">
    <div class="col_div fl">
      <label height="40" class="td_1">定制类型：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['custom_type']?></span>
        </div>
      <div class=" fl">
         <label height="40" class="td_1">购物自费：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['isshopping']?></span>
    </div>

  </div>
  <!--<div class="need_kj clear">

   <div class="fl">
    <label height="40" class="td_1">单项选择：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['another_choose']?></span>
    </div>
  </div> -->
  <div class="need_kj clear">
  <div class="col_div fl">
    <label height="40" class="td_1">希望出游时长：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['days']?>&nbsp;天</span>
    </div>
    <div class="fl">
    <label height="40" class="td_1">希望人均预算：</label>
    <span height="40" class="td_2">￥ <b><?php echo $grab_custom_data['budget']?></b> /人</span>
    </div>
  </div>
   <div class="need_kj clear">
  <div class="col_div fl">
     <label height="40" class="td_1">总人数：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['total_people']?>&nbsp;&nbsp;人</span>
    </div>
    <div class="fl">
    <label height="40" class="td_1">用房数：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['roomnum']?></span>间

    </div>
  </div>
   <div class="need_kj clear">
  <div class="col_div fl">
    <label class="fl">出游人：</label>
        <div class="fl" height="40">  <span><?php echo $grab_custom_data['people']?></span>&nbsp;(成人)&nbsp;/&nbsp;</div>
         <div class="fl"><span><?php echo $grab_custom_data['childnum']?></span> &nbsp;(占床儿童)&nbsp;/&nbsp;</div>
          <div class="fl"> <span><?php echo $grab_custom_data['childnobednum']?></span>&nbsp;(不占床儿童)&nbsp;/&nbsp;</div>
           <div class="fl"> <span><?php echo $grab_custom_data['oldman']?></span>&nbsp;(老人)&nbsp;</div>
</div>
<div class="fl">
    <label height="40" class="td_1">用房要求：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['room_require']?></span>
    </div>
  </div>
  <div class="need_kj clear">
  <div class="col_div fl">
    <label height="40" class="td_1">要求用餐：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['catering']?></span>
</div>
<div class="fl">
    <label height="40" class="td_1">要求酒店：</label>
    <span height="40" class="td_2"><?php echo $grab_custom_data['hotelstar']?></span>
    </div>
  </div>

    <div class="">
     <label height="40" class="td_1">详细需求概述：</label>
    <span colspan="" class="td_2"><?php echo $grab_custom_data['service_range']?></span>
    </div>
</div>

    </div>
<div class="house_price">
        <p>管家报价</p>
        <div class="house_price_details">
                  <div class="col_details fl">
                       <label class="fl">成人价：</label>
                       <span colspan="" class="td_2">￥<b><?php echo $expert_baojia['price']?></b>/人</span>
                </div>
                 <div class="col_details  fl">
                      <label class="fl">儿童占床价：</label>
                      <span colspan="" class="td_2">￥<b><?php echo $expert_baojia['childprice']?></b>/人</span>
                 </div>
                <div class="col_details fl">
                     <label class="fl">儿童不占床价：</label>
                      <span colspan="1" class="td_2">￥<b><?php echo $expert_baojia['childnobedprice']?></b>/人</span>
                </div>
                 <div class=" fl">
                     <label class="fl">老人价：</label>
                      <span colspan="" class="td_2">￥<b><?php echo $expert_baojia['oldprice']?></b>/人</span>
    </div>
                </div>
              <div class="price_description" style="margin-bottom:-100">
                  <label class="travel_title" style="width:70px;">价格说明：</label>
                  <span><?php echo $expert_baojia['price_description']?></span>
        </div>
        </div>
    <div class="c_reply_content_detial clear">
      <p style="margin-top:5px;">行程设计</p>
      <div class="c_travel_day"><span class="c_travel_title">总体描述：</span>
      <?php echo $expert_baojia['plan_design']?>
                  </div>

      <div class="c_reply_travel  ">
      <?php foreach ($custom_trip_data_list as $item): ?>
<p class="day_reply">第<?php echo $item['cj_day']?>天</p>
      <div class="c_reply_travel">
        <div class="c_travel_day"><span class="c_travel_title">标题：</span>
         <?php echo $item['cj_title']?>
        </div>
        <div class="c_travel_traffic"><span class="c_travel_title">交通：</span>
         <?php echo $item['transport']?>        </div>
          <div class="c_travel_meals"><span class="c_travel_title fl">用餐：</span>
             <div class="fl"><span>早餐</span><?php echo $item['breakfirst'].' / '?></div>
             <div class="fl"><span>午餐</span><?php echo $item['lunch'].' / '?></div>
             <div class="fl"><span>晚餐</span><?php echo $item['supper']?></div>
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
      </div>
          </div>

     <div class="reply_botton">
           <input type="hidden"  name="price" value="<?php echo $expert_baojia['price']?>">
        <input type="hidden"  name="childnobedprice" value="<?php echo $expert_baojia['childnobedprice']?>" >
         <input type="hidden"  name="childprice" value="<?php echo $expert_baojia['childprice']?>">
        <input type="hidden" name="oldprice" value="<?php echo $expert_baojia['oldprice']?>" >
       <input type="hidden"  name="e_id" value="<?php echo $e_id;?>"/>
      <input type="hidden"  name="c_id" value="<?php echo $c_id;?>"/>
       <input type="hidden"  name="ca_id" value="<?php echo $ca_id;?>"/>
       <input type="hidden"  name="user_type" value="<?php echo $grab_custom_data['user_type']?>"/>
       <input type="hidden" id="submit_type" name="submit_type" value="" />
<input type="submit" name="keep_enquiry" value="保存" class="reply_button2" style="padding:0px 5px" onclick="submit_form(this)"/>
<input type="submit" name="go_enquiry" value="保存并发单" class="reply_button1" style="padding:0px 5px" onclick="submit_form(this)"/>
<input type="button" name="cancle_go_inquiry" value="取消"  class="reply_button2" onclick="window.close()"/>
      </div>
      </form>
  </div>

<script type="text/javascript">
function submit_form(obj){
  var submit_name = $(obj).attr('name');
  if(submit_name=='keep_enquiry'){
  $("#submit_type").val('0');
  }else{
  $("#submit_type").val('1');
  }
  return true;
}
$('#again_inquiry_form').submit(function(){
  $("#keep_enquiry").attr('disabled',true);
       $("#go_enquiry").attr('disabled',true);
  $.post(
  "<?php echo site_url('admin/b2/inquiry_sheet/again_inquiry');?>",
  $('#again_inquiry_form').serialize(),
        function(data) {
                data = eval('('+data+')');
                if (data.code == 200) {
                alert(data.msg);
                window.opener.location.reload();
                window.close();
                } else {
                alert(data.msg);
                $("#keep_enquiry").attr('disabled',false);
                     $("#go_enquiry").attr('disabled',false);
                }
        }
  );
  return false;
});

</script>