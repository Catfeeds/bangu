<style type="text/css">
  .td_1{width: 100px}
  .td_2{width: auto;}
.guest_need {min-height: 375px;}
 .travel_content textarea,.price_description textarea {width:88%;}
  .travel_day input, .reply_travel  .travel_content textarea{ width: 85%}
  .col_ts{float: left; margin-bottom: 15px;}
  .form-group{margin-bottom: 0px}
  .checkbox{ margin-top: 2px;}
  .col_yc{ margin-top: 10px;}
 /* .travel_day { margin-bottom: 0px}*/
  label{font-size: inherit;}
  .form-control, select{font-size: inherit;}
   .need_kj input,.need_kj select { width: 65px;}
   .col_div{ width: 55%}
   .need_kj{ margin-bottom: 10px}
   .require_content{width:600px;}
   .parentFileBox > .fileBoxUl{margin-left:-13px;}

</style>
<div class="reply">
  <div class="reply_title">转询价单</div>
  <div class="reply_content_detial">
    <form action="#" method="post" id="go_inquiry_form">
    <div class="guest_need">
      <p>客人需求</p>
  <div class="guest_need_detail" border="0" style="">
        <div class="need_kj clear">
        <div class=" col_div fl">
            <span class="bianma fl">编号：</span>
            <div style="margin-top:4px;">
            <span class="bianma_1"><?php echo $custom_info['c_id']?></span>
            </div>
        </div>

        </div>

      <div class="need_kj clear">
      <div class="col_div fl">
      <label class="fl">出发城市：</label>
          <div class=" col_mg fl">
                  <span><?php echo $custom_info['startplace']?></span>
            </div>

        </div>
        <div class=" fl">
        <label class="fl">目 &nbsp;的&nbsp; 地：</label>
        <div class="fl"> <span><?php echo $custom_info['endplace_name']?></span></div>

        </div>
        </div>

      <div class="need_kj clear">
      <div class=" col_div fl">
      <label class="fl">出行日期：</label>
        <div class=" fl">
       <span><?php if(!empty( $custom_info['estimatedate'])){echo $custom_info['estimatedate'].'(预估)'; }else{echo $custom_info['startdate'].'(确认)';}?></span>
        </div>
        </div>
         <div class="fl">
    <label class="fl" style="margin-top:5px;">供&nbsp; 应&nbsp;  商：</label>
        <div class="fl" height="40">
        <select id="g_supplier_id" name="g_supplier_id" style="width:200px">
                      <option value="">--全部--</option>
                      <?php foreach($suppliers AS $supp):?>
                        <option value="<?php echo $supp['id']?>"><?php echo !empty($supp['company_name'])?$supp['company_name']:$supp['realname'];?></option>
                     <?php endforeach;?>
        </select>
        </div>
    </div>
     <!--    <div class=" col_div fl">
      <label class="fl">预估日期：</label>
        <div class=" fl">
       <span><?php echo $custom_info['estimatedate']?></span>
        </div>
        </div>-->
        <div class="col_div fl">
        <label class="fl">定制类型：</label>
        <div class="fl">
             <span><?php echo $custom_info['custom_type']?></span>
      <!--   <input type="text" name="theme" value="2"/> -->
        </div>
        </div>
        <div class="fl">
       <label class="fl">出游方式：</label>
        <div class="fl">
                 <span><?php if(!empty( $custom_info['another_choose'])){echo  $custom_info['trip_way'].'/'.$custom_info['another_choose'];}else{ echo $custom_info['trip_way'];}?></span>
        </div>
        </div>
      </div>
      <div class="need_kj clear">
          <div class=" col_div fl">
        <label class="fl">希望出游时长：</label>
        <div height="40" class="fl"> <span><?php echo $custom_info['days']?> 天</span></div>
        </div>
        <div class="fl"><label class="fl">总人数：</label>
            <div class="fl"> <span><?php echo $custom_info['total_people']?></span>人</div>

        </div>
        </div>
         <div class="need_kj clear">
          <div class=" col_div fl">
        <label class="fl">出游人：</label>
        <div height="40" class="fl">  <span><?php echo $custom_info['people']?></span>&nbsp;(成人)&nbsp;/&nbsp;</div>
         <div class="fl"><span><?php echo $custom_info['childnum']?></span> &nbsp;(占床儿童)&nbsp;/&nbsp;</div>
          <div class="fl"> <span><?php echo $custom_info['childnobednum']?></span>&nbsp;(不占床儿童)&nbsp;/&nbsp;</div>
           <div class="fl"> <span><?php echo $custom_info['oldman']?></span>&nbsp;(老人)&nbsp;</div>
        </div>
        <div class="fl"><label class="fl">用房数：</label>
            <div class="fl"> <span><?php echo $custom_info['roomnum']?></span>间</div>

        </div>
        </div>
       <!--   <div class="need_kj clear">

     <div class="fl">
         <label class="fl">单项选择：</label>
        <div class="fl">
                 <span><?php echo $custom_info['another_choose']?></span>
        </div>
        </div>-->
        </div>
        <div class="need_kj clear">
        <div class="col_div fl">
        <label class="fl">希望人均预算：</label>
        <div class="fl">￥  <span><?php echo $custom_info['budget']?></span> /人</div>>
      </div>
        <div class="fl">
         <label class="fl">购物自费：</label>
        <div class="fl">
         <span><?php echo $custom_info['isshopping']?></span>
        </div>

        </div>
        </div>
        <div class="need_kj clear">
          <div class=" col_div fl">
         <label class="fl">要求酒店：</label>
        <div class="fl">
            <span><?php echo $custom_info['hotelstar']?></span>
        </div>
        </div>
        <div class="fl">
            <label class="fl">要求用餐：</label>
             <div class="fl" height="40"> <span><?php echo $custom_info['catering']?></span></div>
        </div>
        </div>
        <div class="need_kj clear">
        <div class=" col_div fl">
            <label class="fl">用房要求：</label>
             <div class="fl" height="40"><span><?php echo $custom_info['room_require']?></span></div>
             </div>
             <div class="fl">
             <label class="fl">详细需求概述：</label>
                <div class="fl"><span><?php echo $custom_info['service_range']?></span></div>

        </div>
        </div>

    </div>
    <div class="house_price">
        <p>管家报价</p>
        <div class="house_price_details">
                  <div class="col_details fl">
                       <label class="fl">成人价：</label>
                       <div class="fl" height="40"> <input type="text" name="price" value="" id="num">元/人</div>
                </div>
                 <div class="col_details  fl">
                      <label class="fl">儿童占床价：</label>
                      <div class="fl" height="40"> <input type="text" name="childprice" value="" id="num">元/人</div>
                 </div>
                <div class="col_details fl">
                     <label class="fl">儿童不占床价：</label>
                     <div class="fl" height="40"> <input type="text" name="childnobedprice"  value="" id="num">元/人</div>
                </div>
                 <div class=" fl">
                     <label class="fl">老人价：</label>
                     <div class="fl" height="40"> <input type="text" name="oldprice"  value="" id="num">元/人</div>
                </div>
              <div style="margin-bottom:-100" class="price_description">
                  <span class="travel_title">价格说明：</span>
                  <textarea id="price_decription" name="price_decription" placeholder="字数不限"></textarea>
        </div>
        </div>
    </div>
    <div style="margin-top:5px;">
      <p >详细行程：<!-- <span><?php echo $now_date;?></span> --></p>
      <div class="travel_content" style="margin-bottom:-100">
          <span class="travel_title">总体描述：</span>
          <textarea name="travel_description" id='travel_description'></textarea>
        </div>
      <!-- <p>回复行程：</p> -->
   <div class="reply_travel_1">
      <div class="reply_travel">
          <div class="day_num">第1天</div>
        <div class="travel_day"><span class="travel_title">标题：</span>
          <input type="text" name="travel_title[]" value="">
        </div>
         <div class="travel_day"><span class="travel_title">交通：</span>
          <input type="text" name="traffic[]" value="">
        </div>
         <div class="form-group clear">
    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts">用餐：</label>
    <div class="form-inline ">
    <div class="col_ts col_yc">
      <div style="padding-top: 0px;" class="checkbox  col_ts ">
        <label style="padding: 0px;text-align: center;width:68px;">
        <input type="checkbox" name="breakfirsthas[1]" value="1" ><span class="text">早餐</span>
          </label>
      </div>
      <div  class="form-group col_ts ">
        <input type="text" value="" name="breakfirst[]" style="width: 175px;" class="form-control small-width" placeholder="15个字以内">
      </div>
      </div>
      <div class="col_ts col_yc">
      <div style="padding-top: 0px;" class="checkbox col_ts ">
      <label style="padding: 0px;text-align: center;width:72px;">
           <input type="checkbox" value="1" name="lunchhas[1]">
          <span class="text">午餐</span>
        </label>
      </div>
      <div  class="form-group col_ts ">
        <input type="text" value="" name="lunch[]" style="width: 175px;" class="form-control user_name_b1"  placeholder="15个字以内">
      </div>
      </div>
                  <div class="col_ts col_yc">
      <div style="padding-top: 0px;width:72px;" class="checkbox col_ts">
        <label style="padding: 0px;text-align: center;width:72px;">
        <input type="checkbox" value="1" name="supperhas[1]">
          <span class="text">晚餐</span>
        </label>
      </div>
      <div style="margin: 0px;" class="form-group">
        <input type="text" value=""  style="width: 175px;" class="form-control user_name_b1" name="supper[]" placeholder="15个字以内">
      </div>
      </div>
    </div>
  </div>
        <div class="travel_content">
          <span class="travel_title">行程：</span>
          <textarea name="travel_content[]" id='textarea1'></textarea>
        </div>
        <div class="travel_img"><span class="travel_title">行程图片：</span>
          <div id="demo1">
            <div id="as1" ></div>
            <div class="div_url_val"><!--每个地方都必须要有,不然就没办法保存数据-->
              <input type="hidden" class='url_val' name="pics_url[]" value=""/>
            </div>
          </div>
        </div>

      </div>
       <span style="cursor:pointer" class="add_day" data-val="2" onclick="add_travel(this)"><b>+</b>第二天</span>
      </div>
   </div>
<div style="margin-top:25px">
      行程附件:(<font color='red'>*仅xls,word 文件</font>): <input type="file" name="replay_file" id="replay_file" value="" style="display:inline"/>
       <input type="button" value="上传" id="upfile_replay_file" />
       <input type="hidden" name="replay_file_url" id="replay_file_url" value=""/>
      </div>
      <div class="reply_botton">
    <input type="hidden" id="submit_type" name="submit_type" value="" />
      <input type="hidden" name="customize_id" value="<?php echo $c_id?>"/>
       <input type="hidden" name="ca_id" value="<?php echo $ca_id?>"/>
      <input type="hidden" name="max_day" value="<?php echo $max_day?>"/>
       <input type="submit" name="keep_enquiry" value="保存" class="reply_button2" style="padding:0px 5px" onclick="submit_form(this)"/>
        <input type="submit" name="go_enquiry" value="保存并发单" class="reply_button1" style="padding:0px 5px" onclick="submit_form(this)"/>
        <input type="button" name="cancle_go_inquiry" value="取消"  class="reply_button2" onclick="window.close()"/>
      </div>
    </form>
  </div>
</div>
<script src="<?php echo base_url('assets/js/diyUpload.js') ;?>"></script>
<script type="text/javascript">
$('#as1').diyUpload({
     swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
  url:"<?php echo base_url('admin/b2/grab_custom_order/up_pics')?>",
  success:function( data ) {},
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
  duplicate:false,

  accept: {}
});

function add_travel(obj){
      var day = $(obj).attr('data-val');
      var str_html = "<div class='reply_travel'><div class='day_num'>第"+day+"天</div><div class='travel_day'><span class='travel_title'>标题：</span><input type='text' name='travel_title[]' value=''></div><div class='travel_day'><span class='travel_title'>交通：</span><input type='text' name='traffic[]' value=''></div><div class='form-group clear'><label for='inputEmail3' class='col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts'>用餐：</label><div class='form-inline'><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox  col_ts'><label style='padding: 0px;text-align: center;width:68px;'><input type='checkbox' name='breakfirsthas["+day+"]' value='1' ><span class='text'>早餐</span></label> </div><div  class='form-group col_ts'> <input type='text' value='' name='breakfirst[]' style='width: 175px;' class='form-control small-width' placeholder='15个字以内'></div></div><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='lunchhas["+day+"]'><span class='text'>午餐</span></label></div><div  class='form-group col_ts'><input type='text' value='' name='lunch[]' style='width: 175px;' class='form-control user_name_b1'  placeholder='15个字以内'> </div></div><div class='col_ts col_yc'><div style='padding-top: 0px;width:72px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='supperhas["+day+"]'><span class='text'>晚餐</span></label></div><div style='margin: 0px;' class='form-group'><input type='text' value='' style='width: 175px;' class='form-control user_name_b1' name='supper[]' placeholder='15个字以内'></div></div></div></div><div class='travel_content'><span class='travel_title'>行程：</span><textarea name='travel_content[]' id='textarea"+day+"'></textarea></div><div class='travel_img'><span class='travel_title'>行程图片：</span><div id='demo1'><div id='as"+day+"' ></div><div class='div_url_val'><input type='hidden' class='url_val' name='pics_url[]' value=''/></div></div></div></div>";
             $(obj).before(str_html);
            $('#as'+day).diyUpload({
                swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
                url:"<?php echo base_url('admin/b2/grab_custom_order/up_pics')?>",
                success:function( data ) {},
                error:function( err ) {console.info( err );},
                buttonText : '+ 6/6图片上传',
                chunked:true,
                chunkSize:512 * 1024,
                fileNumLimit:6,
                fileSizeLimit:500000 * 1024,
                fileSingleSizeLimit:50000 * 1024,
                duplicate:false,
                accept: {}
            });
            day++;
            $(obj).attr('data-val',day);
            $(obj).html('<b>+</b>第 '+day+' 天');
}


$('#upfile_replay_file').on('click', function(){
            $.ajaxFileUpload({
                url:'<?php echo site_url('admin/b2/grab_custom_order/up_file');?>',
                secureuri:false,
                fileElementId:'replay_file',//file标签的id
                dataType: 'json',//返回数据的类型
                data:{filename:'replay_file'},
                success: function (data, status) {
                    if (data.status == 1) {
                      $(".replay_file").remove();
          $('#replay_file').after("<span class='replay_file' >上传成功</>");
          $('input[name="replay_file_url"]').val(data.url);
                  } else {
              alert(data.msg);
                }
                },
                error: function (data, status, e) {
                      alert(data.msg);
                }
            });
        });


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
        "<?php echo site_url('admin/b2/grab_custom_order/go_inquiry');?>",
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
</script>