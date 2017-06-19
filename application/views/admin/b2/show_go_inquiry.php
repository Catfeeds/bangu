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
   .col_div{ width: 450px}
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
   <form action="#" method="post" id="go_inquiry_form">
        <div class="guest_need">
      <p>客人需求</p>
  <div style=""  border="0" class="guest_need_detail">
      <div class="need_kj clear">
      <div class=" col_div fl">
      <div class="c_bianhao fl"><span>编号</span><div><?php echo $c_id?></div></div>
    </div>
     <div class="">
        <label class="fl" style="margin-top:5px;">供&nbsp; 应&nbsp;  商：</label>
        <div class="fl" height="40">
        <select id="g_supplier_id" name="g_supplier_id">
                      <option value="">--全部--</option>
                      <?php foreach($suppliers AS $supp):?>
                        <option value="<?php echo $supp['id']?>"><?php echo !empty($supp['company_name'])?$supp['company_name']:$supp['realname'];?></option>
                     <?php endforeach;?>
        </select>
        </div>
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
     <label class="td_1" height="40">出行日期：</label>
    <span class="td_2" height="40"><?php if(!empty($grab_custom_data['estimatedate'])){ echo $grab_custom_data['estimatedate'].'(预估)'; }else{echo $grab_custom_data['startdate'].'(确认)';}?></span>
    </div>
    <!--  <div class="col_div fl">
     <label class="td_1" height="40">预估日期：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['estimatedate']?></span>
    </div> -->
    <div class=" fl">
    <label class="td_1"height="40">出游方式：</label>
    <span class="td_2" height="40"><?php if(!empty($grab_custom_data['another_choose'])){ echo $grab_custom_data['trip_way'].'/'.$grab_custom_data['another_choose']; }else{echo $grab_custom_data['trip_way'] ;}?></span>
    </div>
  </div>
    <div class="col_div fl">
      <label class="td_1" height="40">定制类型：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['custom_type']?></span>
        </div>
      <div class="col_div fl">
         <label class="td_1" height="40">购物自费：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['isshopping']?></span>
    </div>

  </div>
 <!-- <div class="need_kj clear">
  <div class="col_div fl">
    <label class="td_1"height="40">出游方式：</label>
    <span class="td_2" height="40"><?php if(!empty($grab_custom_data['another_choose'])){ echo $grab_custom_data['trip_way'].'/'.$grab_custom_data['another_choose']; }else{echo $grab_custom_data['trip_way'] ;}?></span>
    </div>
   <div class="fl">
    <label class="td_1" height="40">单项选择：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['another_choose']?></span>
    </div>
  </div>-->
  <div class="need_kj clear">
  <div class="col_div fl">
    <label class="td_1" height="40">希望出游时长：</label>
    <span class="td_2" height="40"><?php echo $grab_custom_data['days']?>&nbsp;天</span>
    </div>
    <div class="fl">
    <label class="td_1" height="40">希望人均预算：</label>
    <span class="td_2" height="40" class="c_red_color">￥ <b><?php echo $grab_custom_data['budget']?></b> /人</span>
    </div>
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

    <div class="">
     <label class="td_1" height="40">详细需求概述：</label>
    <span class="td_2" colspan=""><?php echo $grab_custom_data['service_range']?></span>
    </div>

      <!-- <tr>
        <td width="130" height="40">其他要求：</td>
        <td height="40" colspan="3"><textarea name="other_service" class="require_content"><?php echo $grab_custom_data['other_service']?></textarea></td>
        </tr> -->
</div>


<div class="house_price">
        <p>管家报价</p>
        <div class="house_price_details">
                  <div class="col_details fl">
                       <label class="fl">成人价：</label>
                       <span class="td_2" colspan="">￥<b><?php echo $grab_custom_data['price']?></b>/人</span>
                </div>
                 <div class="col_details  fl">
                      <label class="fl">儿童占床价：</label>
                      <span class="td_2" colspan="">￥<b><?php echo $grab_custom_data['childprice']?></b>/人</span>
                 </div>
                <div class="col_details fl">
                     <label class="fl">儿童不占床价：</label>
                      <span class="td_2" colspan="1">￥<b><?php echo  $grab_custom_data['childnobedprice']?></b>/人</span>
                </div>
                 <div class=" fl">
                     <label class="fl">老人价：</label>
                      <span class="td_2" colspan="">￥<b><?php echo $grab_custom_data['oldprice']?></b>/人</span>
    </div>
                </div>
              <div style="margin-bottom:-100" class="price_description">
                  <span class="travel_title">价格说明：</span>
                  <textarea id="" name="" placeholder="字数不限"><?php echo $grab_custom_data['price_description']?></textarea>
        </div>
        </div>
    <div class="c_reply_content_detial clear">
      <p style="margin-top:5px;">行程设计</p>
      <div class="c_travel_day"><span class="c_travel_title">总体描述：</span>
         <?php echo $grab_custom_data['service_range']?>
         </div>
<?php foreach ($custom_trip_data_list as $item): ?>

      <div class="c_reply_travel  ">
      <p class="day_reply">第<?php echo $item['cj_day']?>天</p>
        <div class="c_travel_day"><span class="c_travel_title">标题：</span>
         <?php echo $item['cj_title']?>
        </div>
        <div class="c_travel_traffic"><span class="c_travel_title">交通：</span>
         <?php echo $item['transport']?>      </div>
          <div class="c_travel_meals"><span class="c_travel_title fl">用餐：</span>
             <div class="fl"><span>早餐:</span><?php echo $item['breakfirst'].'/'?></div>
             <div class="fl"><span>午餐:</span><?php echo $item['lunch'].'/'?></div>
             <div class="fl"><span>晚餐:</span><?php echo $item['supper'].'/'?></div>
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

     <div class="reply_botton">
           <input type="hidden" name="price" value="<?php echo $grab_custom_data['price']?>" />
        <input type="hidden" name="childnobedprice" value="<?php echo $grab_custom_data['childnobedprice']?>" />
         <input type="hidden" name="childprice" value="<?php echo $grab_custom_data['childprice']?>" />
        <input type="hidden" name="oldprice" value="<?php echo $grab_custom_data['oldprice']?>" />

        <input type="hidden" name="ca_id" value="<?php echo $ca_id?>" />
        <input type="hidden" name="c_id" value="<?php echo $c_id?>" />
        <input type="hidden" id="submit_type" name="submit_type" value="" />
        <input type="submit" name="keep_enquiry" value="保存" class="reply_button2" style="padding:0px 5px" onclick="submit_form(this)"/>
        <input type="submit" name="go_enquiry" value="保存并发单" class="reply_button1" style="padding:0px 5px" onclick="submit_form(this)"/>
        <input type="button" name="cancle_go_inquiry" value="取消"  class="reply_button2" onclick="window.close()"/>
      </div>
      </form>
  </div>
  </div>

<script src="<?php echo base_url('assets/js/diyUpload.js') ;?>"></script>
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript">
var max_day = "<?php echo $grab_custom_data['days']?>";
//  每次修改一个图片都修改一下数值
     function cancle_pic(obj){
         var final_arr =  new Array();;
         var pic_url= $(obj).parent().parent().parent().prev().find('.url_val').val();
         var src_url =  $(obj).parent('li').find('img').attr('src');
         pic_url = pic_url.substr(0,pic_url.length - 1);
         var pic_url_arr = pic_url.split(';');
         for(var i=0;i<pic_url_arr.length;i++){
            if(pic_url_arr[i]!=src_url){
              final_arr.push(pic_url_arr[i]) ;
            }
        }
       var final_pic_url = final_arr.join(';')+';';
       $(obj).parent().parent().parent().prev().find('.url_val').val(final_pic_url);
        $(obj).parent('li').remove();
      }

/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/
for(var i=1; i<=max_day;i++){
$('#as'+i).diyUpload({
       swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
	url:"<?php echo base_url('admin/b2/grab_custom_order/up_pics')?>",
	success:function( data ) {
		console.info( data );
	},
	error:function( err ) {
		console.info( err );
	},
	buttonText : '+ 6/6图片上传',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:6,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});
}


//转询价单表单提交
function submit_form(obj){
  var submit_name = $(obj).attr('name');
  if(submit_name=='keep_enquiry'){
      $("#submit_type").val('0');
  }else{
      $("#submit_type").val('1');
  }
  return true;
}

  $('#go_inquiry_form').submit(function(){
      $.post(
        "<?php echo site_url('admin/b2/grab_custom_order/go_inquiry_anwser');?>",
        $('#go_inquiry_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.code == 200) {
            alert(data.msg);
            window.opener.location.reload();
            window.close();
          } else {
            alert(data.msg);
          }
        }
      );
      return false;
    });

/*$('#trip_date').datepicker();
$('#trip_way option[value='+<?php echo $grab_custom_data['trip_way']?>+']').attr('selected',true);
$('#trip_theme option[value='+<?php echo $grab_custom_data['theme']?>+']').attr('selected',true);
$('#isshopping option[value='+<?php echo $grab_custom_data['isshopping']?>+']').attr('selected',true);
$('#hotelstart option[value='+<?php echo $grab_custom_data['hotel']?>+']').attr('selected',true);*/
</script>