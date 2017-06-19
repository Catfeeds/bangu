<style type="text/css">
.guest_need {min-height: 375px;}
 .travel_content textarea,.price_description textarea {width:88%;}
  .travel_day input, .reply_travel  .travel_content textarea{ width: 85%}
 .need_kj input,.need_kj select { width: 220px; height: 35px; line-height: 35px;}
.need_xuq textarea{ width: 100%}
   .col_div{ width: 55%}
   .need_kj{ margin-bottom: 10px}
   .require_content{width:600px;}
   .guest_need .col_tj{text-align: right; width: 110px;line-height: 35px;}
   .col_ts{float: left; margin-bottom: 15px;}
     .col_yc{ margin-top: 10px;}
     #destSelected{ margin-top:40px}
     .selectedTitle{ margin-left: 64px;  float: left;}
     .selectedContent{color: #15b000;padding: 4px; background: #fff;cursor:pointer;}
     ..order_request{width:45%;}
</style>
<!-- <div class="bootbox modal fade in" id="add_inquiry_sheet_modal"> -->
  <!-- <div class="modal-dialog"> -->
    <div class="reply">
  <div class="reply_title">添加询价单</div>
  <div class="reply_content_detial">
    <form action="#" method="post" id="edit_enquiry_form">
                     <div class="guest_need">
                           <p>客人需求</p>
                               <div class="guest_need_detail" border="0" style="">
            <!-- <div class="revertContextLeft"> -->
            <div class="need_kj clear">
               <div class=" col_div fl">
                        <span class="revertNums fl">编号</span>
                      <div class="fl"><span class="revertNum fl" id="go_id"><?php echo $c_id?></span></div>
                                                                         </div>
                      <!-- <div class="fl" >
                  <label class="col_tj fl" >指定供应商：</label>
                  <div class="fl"  id="go_suppliers">
                <select name="go_suppliers" id="go_suppliers">
                <option value="">--请选择--</option>
               <?php foreach ($suppliers as $val) {
                if($val['id']==$grab_custom_data['supplier_id']){
                      echo "<option selected value='{$val ['id']}'>{$val ['realname']}</option>";
                    }else{
                       echo "<option value='{$val ['id']}'>{$val ['realname']}</option>";
                    }
               }?>
                </select>
                    </div>
              </div> -->

             </div>
               <div class="need_kj clear">
              <div class=" col_div fl">
                     <label class="col_tj fl">出发城市：</label>
                     <div class="fl" id="go_start_place">
                            <input type="text"  placeholder="出发城市" id="startplace"  name="startplace" value="<?php echo $grab_custom_data['startplace']?>"/>
                            <input type="hidden" name="startcityId" id="startcityId">
                     </div>
              </div>
              <div class='order_request fl'>
                   <label class="col_tj fl">目的地：</label>
                   <div class="input_click relative fl custom_dest">
                            <input type="text" id="custom_abroad" placeholder="请选择目的地">
                            <input type="text" style="display:none;" id="custom_domestic" placeholder="请选择目的地">
                            <input type="text" style="display:none;" id="custom_trip" placeholder="请选择目的地">
                    </div>
                    <input type="hidden" id="customDestId" name="customDestId" value="<?php echo $grab_custom_data['endplace_id']?>"/>
                    <div id="destSelected">
                      <div class="selectedTitle">已选择：</div>
                      <?php
                       $endplace_arr = explode(',', $grab_custom_data['endplace']);
                       $endplace_id_arr = explode(',', rtrim($grab_custom_data['endplace_id'],','));
                            if(!empty($endplace_arr)){
                              $arr_count = count($endplace_arr);
                              for ($i=0;$i<$arr_count;$i++) {
                              ?>
                              <span class="selectedContent" value="<?php echo $endplace_id_arr[$i]?>"><?php echo $endplace_arr[$i]?><span onclick="delPlugin(this ,'customDestId' ,'destSelected');" class="delPlugin">x</span></span>
                      <?php
                              }
                            }
                      ?>
                    </div>
            </div>
</div>
            </div>
             <div class="need_kj clear">
              <div class=" col_div fl">
                     <label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_tj">出行日期：</label>
                      <div class=" fl" style="padding-left:10px;">
                 <div class="input-group col-sm-10" style="width:220px;margin-left:-10px" >
                  <input class="form-control date-picker"  name="start_time" id="start_time" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $grab_custom_data['startdate']?>"/>
                             <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                             </span>
                   </div>
              </div>
              </div>
              <div class='order_request fl'>
                     <label class="col_tj fl">定制类型：</label>
                     <div class="fl" id="">
               <select name="custom_type" id="custom_type" onchange="choose_trip(this)">
                          <option value="">--请选择定制类型--</option>
                          <?php
                                if($grab_custom_data['custom_type']=="出境游"){
                                  echo "<option value='出境游' selected>出境游</option>";
                                }else{
                                  echo "<option value='出境游''>出境游</option>";
                                }
                                if($grab_custom_data['custom_type']=="国内游"){
                                  echo "<option value='国内游' selected>国内游</option>";
                                }else{
                                  echo "<option value='国内游''>国内游</option>";
                                }
                                if($grab_custom_data['custom_type']=="周边游"){
                                  echo "<option value='周边游' selected>周边游</option>";
                                }else{
                                  echo "<option value='周边游''>周边游</option>";
                                }
                            ?>
              </select>
                        </div>
              </div>
            </div>
             <div class="need_kj clear">
              <div class=" col_div fl">
                      <lable  class="col_tj fl">出游方式：</lable>
                    <div class="fl"  id="go_shopping">
               <select name="trip_way" id="trip_way" onchange="one_choose(this)">
                  <option value="">--请选择--</option>
                  <?php foreach ($trip_way_data as $val) {
                    if($val['description']==$grab_custom_data['trip_way']){
                      echo "<option selected  value='{$val ['description']}'>{$val ['description']}</option>";
                    }else{
                      echo "<option  value='{$val ['description']}'>{$val ['description']}</option>";
                    }
                  }?>
              </select>
              </div>
              </div>
              <div class='order_request fl'>
                     <label class="col_tj fl">单项选择：</label>
                     <div class="fl" id="">
                    <select name="choose_one" id="choose_one" >
                          <option value="">--请选择--</option>
                          <?php foreach ($choose_one_data as $val) {
                            if($val['description']==$grab_custom_data['another_choose']){
                      echo "<option selected  value='{$val ['description']}'>{$val ['description']}</option>";
                    }else{
                      echo "<option  value='{$val ['description']}'>{$val ['description']}</option>";
                    }
                          }?>
                    </select>
                        </div>
              </div>
            </div>

            <div class="need_kj clear">
              <div class=" col_div fl">
                  <lable class="col_tj fl">希望出游时长：</lable>
                  <div class="fl"  id="go_days" >
                        <input type="text" name="days" size="3" value="<?php echo $grab_custom_data['days']?>">天</div>
              </div>
              <div class="fl" >
                    <label class="col_tj fl">希望人均预算(¥)：</label>
                   <div class="revertFont2 fl" id="go_budget">
                   <input type="text" name="budget" value="<?php echo $grab_custom_data['budget']?>">人
                   </div>
               </div>
                             </div>
                             <div class="need_kj clear">
              <div class=" col_div fl">
                 <label  class="col_tj fl">要求酒店：</label>
                  <div class="fl" id="go_hotel">
                <select name="go_hotel" id="go_hotel">
                    <option value="">--请选择--</option>
                    <?php foreach ($hotel_data as $val) {
                     if($val['description']==$grab_custom_data['hotelstar']){
                      echo "<option selected  value='{$val ['description']}'>{$val ['description']}</option>";
                    }else{
                      echo "<option  value='{$val ['description']}'>{$val ['description']}</option>";
                    }
                    }?>
                </select>
                   </div>
              </div>
              <div class="fl" >
                   <label class="col_tj fl">购物自费：</label>
                    <div class="fl"  id="go_shopping">
                        <select name="go_shopping" id="go_shopping">
                        <option value="">--请选择--</option>
                        <?php foreach ($shopping_data as $val) {
                          if($val['description']==$grab_custom_data['isshopping']){
                                  echo "<option selected  value='{$val ['description']}'>{$val ['description']}</option>";
                          }else{
                                 echo "<option  value='{$val ['description']}'>{$val ['description']}</option>";
                          }
                        }?>
                        </select>
                    </div>
               </div>
                             </div>
                              <div class="need_kj clear">
              <div class=" col_div fl" class='order_request'>
                   <label class="col_tj fl">用餐要求：</label>
                <div class="fl"  id="go_dining">
                  <select name="go_dining" id="go_dining">
                    <option value="">--请选择--</option>
                    <?php foreach ($catering_data as $val) {
                       if($val['description']==$grab_custom_data['catering']){
                                  echo "<option selected  value='{$val ['description']}'>{$val ['description']}</option>";
                          }else{
                                 echo "<option  value='{$val ['description']}'>{$val ['description']}</option>";
                          }
                    }?>
                    </select>
                </div>
              </div>
               <div class="fl" >
                  <label class="col_tj fl" >指定供应商：</label>
                  <div class="fl"  id="go_suppliers">
                <select name="go_suppliers" id="go_suppliers">
                <option value="">--请选择--</option>
               <?php foreach ($suppliers as $val) {
                if($val['id']==$grab_custom_data['supplier_id']){
                      echo "<option selected value='{$val ['id']}'>{$val ['realname']}</option>";
                    }else{
                       echo "<option value='{$val ['id']}'>{$val ['realname']}</option>";
                    }
               }?>
                </select>
                    </div>
              </div>
              <!-- <div class="fl" >
                    <label class="col_tj fl">总人数：</label>
                  <div class="fl"   id="go_people">
                           <input type="text" name="peoples" size="5" value="去掉这个"></div>
              </div> -->
              </div>
                             <div class="need_kj clear">
              <div class=" col_div fl" class='order_request'>
                   <label class="col_tj fl">用房数：</label>
                  <div class="fl"   id="">
                           <input type="text" name="room_num"  value="<?php echo $grab_custom_data['roomnum']?>"/></div>
              </div>
              <div class="fl" >
                  <label class="col_tj fl">用房要求：</label>
                    <div class="fl"  id="go_shopping">
                    <select name="room_require" id="room_require">
                    <option value="">--请选择--</option>
                    <?php foreach ($room_data as $val) {
                        if($val['description']==$grab_custom_data['room_require']){
                                  echo "<option selected  value='{$val ['description']}'>{$val ['description']}</option>";
                          }else{
                                 echo "<option  value='{$val ['description']}'>{$val ['description']}</option>";
                          }
                    }?>
                    </select>
                    </div>
              </div>
              </div>
              <div class="need_kj clear">
              <div class=" col_div fl" class='order_request'>
                   <label class="col_tj fl">成人：</label>
                   <div class="fl" id=""><input type="text"  name="people" value="<?php echo $grab_custom_data['people']?>">人</div>
              </div>
              <div class="fl" >
                   <label class="col_tj fl">老人：</label>
                   <div class="fl" id=""><input type="text"  name="oldman" value="<?php echo $grab_custom_data['oldman']?>">人</div>
              </div>
              </div>
               <div class="need_kj clear">
              <div class=" col_div fl"  >
                    <label class="col_tj fl">不占床儿童：</label>
                    <div class="fl"  id=""><input  type="text"  name="childnobednum"  value="<?php echo $grab_custom_data['childnobednum']?>">人
                    </div>
              </div>
              <div class="fl" >
                   <label class="col_tj fl">占床儿童：</label>
                    <div class="fl"  id=""><input type="text"  name="childnum"  value="<?php echo $grab_custom_data['childnum']?>">人
                    </div>
              </div>
                    </div>

                     <div class="need_xuq clear">
              <div class=" col_div fl"  style="width:100%;padding-bottom:15px;">
                     <label class="col_tj fl">管家需求概述：</label>
                     <div class="fl " style="width:77%" id=""><textarea  class="revertexplainTextarea" name="service_range" placeholder="详细描述您的需求"><?php echo $grab_custom_data['service_range']?></textarea>
                     </div>
              </div>
                     </div>
                     </div>

                     <div class="house_price">
        <p>管家报价</p>
  <div class="house_price_details">
<div class="col_details fl">
<label class="fl">成人价：</label>
<div height="40" class="fl"> <input type="text" id="num" value="<?php echo $expert_baojia['price']?>" name="price">元/人</div>
</div>
<div class="col_details  fl">
<label class="fl">儿童占床价：</label>
<div height="40" class="fl"> <input type="text" id="num" value="<?php echo $expert_baojia['childprice']?>" name="childprice">元/人</div>
</div>
<div class="col_details fl">
<label class="fl">儿童不占床价：</label>
<div height="40" class="fl"> <input type="text" id="num" value="<?php echo $expert_baojia['childnobedprice']?>" name="childnobedprice">元/人</div>
</div>
<div class=" fl">
<label class="fl">老人价：</label>
<div height="40" class="fl"> <input type="text" id="num" value="<?php echo $expert_baojia['oldprice']?>" name="oldprice">元/人</div>
</div>
<div class="price_description" style="margin-bottom:-100">
<span class="travel_title">价格说明：</span>
<textarea placeholder="字数不限" name="price_description"><?php echo $expert_baojia['price_description']?></textarea>
</div>
</div>
    </div>
    <div style="margin-top:5px;">
      <p>详细行程：<!-- <span>2015-09-16 11:47:06</span> --></p>
      <div style="margin-bottom:-100" class="travel_content">
          <span class="travel_title">总体描述：</span>
          <textarea id="travel_description" name="travel_description"><?php echo $expert_baojia['plan_design']?></textarea>
        </div>

      <div class="reply_travel_1">
<?php $i=1;foreach ($custom_trip_data_list as $item): ?>
      <div class="reply_travel">
          <div class="day_num">第<?php echo $item['cj_day']?>天</div>
        <div class="travel_day"><span class="travel_title">标题：</span>
          <input type="text"  name="travel_title[]" value="<?php echo $item['cj_title']?>"/>
          <input type="hidden" name="cj_id[]" value="<?php echo $item['cj_id']?>">

        </div>
         <div class="travel_day"><span class="travel_title">交通：</span>
          <input type="text"  name="traffic[]" value="<?php echo $item['transport']?>">
        </div>
         <div class="form-group clear">
    <label class="col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts" for="inputEmail3">用餐：</label>
    <div class="form-inline ">
    <div class="col_ts col_yc">
      <div class="checkbox  col_ts " style="padding-top: 0px;">
        <label style="padding: 0px;text-align: center;width:72px;">
        <?php if($item['breakfirsthas']==1):?>
        <input type="checkbox"  name="breakfirsthas[<?php echo $i;?>]" value="1" checked />
      <?php else:?>
        <input type="checkbox"  name="breakfirsthas[<?php echo $i;?>]" value="1" />
      <?php endif;?>
        <span class="text">早餐</span>
          </label>
      </div>
      <div class="form-group col_ts ">
        <input type="text" placeholder="15个字以内" class="form-control small-width" style="width: 175px;" name="breakfirst[<?php echo $i;?>]" value="<?php echo $item['breakfirst']?>">
      </div>
      </div>
      <div class="col_ts col_yc">
      <div class="checkbox col_ts " style="padding-top: 0px;">
      <label style="padding: 0px;text-align: center;width:72px;">
       <?php if($item['lunchhas']==1):?>
           <input type="checkbox" name="lunchhas[<?php echo $i;?>]" value="1" checked />
            <?php else:?>
        <input type="checkbox"  name="lunchhas[<?php echo $i;?>]" value="1" />
      <?php endif;?>
          <span class="text">午餐</span>
        </label>
      </div>
      <div class="form-group col_ts ">
        <input type="text" placeholder="15个字以内" class="form-control user_name_b1" style="width: 175px;" name="lunch[<?php echo $i;?>]" value="<?php echo $item['lunch']?>">
      </div>
      </div>
                  <div class="col_ts col_yc">
      <div class="checkbox col_ts" style="padding-top: 0px;width:72px;">
        <label style="padding: 0px;text-align: center;width:72px;">
        <?php if($item['supperhas']==1):?>
        <input type="checkbox" name="supperhas[<?php echo $i;?>]" value="1" checked />
         <?php else:?>
        <input type="checkbox"  name="supperhas[<?php echo $i;?>]" value="1" />
      <?php endif;?>
          <span class="text">晚餐</span>
        </label>
      </div>
      <div class="form-group" style="margin: 0px;">
        <input type="text" placeholder="15个字以内" name="supper[<?php echo $i;?>]" class="form-control user_name_b1" style="width: 175px;" value="<?php echo $item['supper']?>">
      </div>
      </div>
    </div>
  </div>

        <div class="travel_content">
          <span class="travel_title">行程：</span>
          <textarea id="textarea1" name="travel_content[]"><?php echo $item['cj_jieshao']?></textarea>
        </div>
        <div class="travel_img"><span class="travel_title">行程图片：</span>
          <div id="demo1">
            <div id="as<?php echo $i?>" >
                 <div class="webuploader-pick">+ 6/6图片上传</div>
            </div>
             <div class="div_url_val"><!--每个地方都必须要有,不然就没办法保存数据-->
              <input type="hidden" class='url_val' name="pics_url[]" value="<?php echo $item['c_pic']?>"/>
              <input type="hidden" name="pic_id[]" value="<?php echo $item['cjp_id']?>"/>
            </div>
          </div>
            <div class="reply_deposit2 reply_deposit2_1" style="position:relative; top:0px; left:0;">
             <ul class="show_img">
                  <?php if(isset($item['pic_arr'])&&count($item['pic_arr'])!=0):?>
               <?php foreach ($item['pic_arr'] as $val): ?>
                  <li ><img src="<?php echo $val;?>"><span onclick="cancle_pic(this)"><img src="/assets/img/x_alt.png"></span></li>
               <?php endforeach;?>
             <?php endif;?>
              </ul>
          </div>
        </div>

      </div>
      <?php $i++; endforeach;?>
       <span style="cursor:pointer" class="add_day" data-val="<?php echo $i;?>" onclick="add_travel(this)" ><b>+</b>第<?php echo $i;?>天</span>
      </div>

   </div>
   <div style="margin-top:25px">
      行程附件:(<font color="red">*仅xls,word 文件</font>): <input type="file" style="display:inline" value="" id="replay_file" name="replay_file">
       <input type="button" id="upfile_replay_file" value="上传"/ style="padding-right:5px">
       <input type="hidden" value="" id="replay_file_url" name="replay_file_url"/>
      </div>
      <div class="reply_botton">
      <input type="hidden" id="submit_type" name="submit_type" value="" />
      <input type="hidden"  name="e_id" value="<?php echo $e_id;?>"/>
      <input type="hidden"  name="c_id" value="<?php echo $c_id;?>"/>
       <input type="hidden"  name="ca_id" value="<?php echo $ca_id;?>"/>
      <input type="hidden" name="max_day" value="<?php echo $max_day?>" />
        <input type="submit" name="go_enquiry" id="go_enquiry" class="reply_button1" value="提交供应商"  onclick="submit_form(this)"/>
        <input type="submit" name="keep_enquiry" id="keep_enquiry" class="reply_button1" value="保存草稿" onclick="submit_form(this)"/>
        <input type="button" class="reply_button2" value="取消" name="reset" onclick="window.close()"/>
      </div>
      </form>
      </div>
    </div>

<!-- </div> --><!--End 编辑询价单-->

<script src="<?php echo base_url('assets/js/diyUpload.js') ;?>"></script>
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
 <script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>

<script type="text/javascript">
var max_day = <?php echo $i--;?>;
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
  },
  error:function( err ) {
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
/*$('#textarea'+i).wangEditor({
    'menuConfig': [["fontFamily", "fontSize"], ["bold", "underline", "italic"], ["setHead", "foreColor", "backgroundColor", "removeFormat"], ["unOrderedList", "orderedList"], ["justifyLeft", "justifyCenter", "justifyRight"],  ["insertHr", "insertTable"], ["undo", "redo"], ["fullScreen"]]
});*/
}
$('#upfile_replay_file').on('click', function(){
            $.ajaxFileUpload({
                url:"<?php echo site_url('admin/b2/grab_custom_order/up_file');?>",
                secureuri:false,
                fileElementId:'replay_file',//file标签的id
                dataType: 'json',//返回数据的类型
                data:{filename:'replay_file'},
                success: function (data, status) {
                    if (data.status == 1) {
                      $(".replay_file").remove();
          $('#replay_file').after("<span class='replay_file' >上传成功</>");
          $('input[name="replay_file_url"]').val(data.url);
          $('#case_atta').attr('href',data.url);
                  } else {
              alert(data.msg);
                }
                },
                error: function (data, status, e) {
                      alert(data.msg);
                }
            });
        });


function submit_form(obj){
        var submit_name = $(obj).attr('name');
        if(submit_name=='keep_enquiry'){
        $("#submit_type").val('0');
        }else{
        $("#submit_type").val('1');
        }
        return true;
}
//编辑方案表单提交
  $('#edit_enquiry_form').submit(function(){
      $("#keep_enquiry").attr('disabled',true);
       $("#go_enquiry").attr('disabled',true);
      $.post(
        "<?php echo site_url('admin/b2/inquiry_sheet/edit_opera');?>",
        $('#edit_enquiry_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.status == 1) {
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

$('#start_time').datepicker();
function choose_trip(obj){

  if($(obj).val()=="出境游" || $(obj).val()==""){
    $("#custom_abroad").show();
    $("#custom_domestic").hide();
    $("#custom_trip").hide();
  }else if($(obj).val()=="国内游"){
    $("#custom_abroad").hide();
    $("#custom_domestic").show();
    $("#custom_trip").hide();
  }else if($(obj).val()=="周边游"){
    $("#custom_abroad").hide();
    $("#custom_domestic").hide();
    $("#custom_trip").show();
  }
  $("#customDestId").val('');
  $("#destSelected").html('');

}

/************************出发地选择*********************************/
	createChoicePluginPY({
		data:{0:chioceStartCityJson.domestic},
		nameId:"startplace",
		valId:"startcityId",
		width:500,
		isHot:true,
		hotName:'热门出发城市',
	});
/************************END 出发地选择***************************/
/******************目的地选择***************************/
 $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	createChoicePlugin({
		data:{0:chioceDestJson['domestic']},
		nameId:"custom_domestic",
		valId:"customDestId",
		number:5,
		buttonId:'destSelected',
		width:500
	});
 	//出境目的地
	createChoicePlugin({
		data:{0:chioceDestJson.abroad},
		nameId:"custom_abroad",
		valId:"customDestId",
		number:5,
		buttonId:'destSelected',
		width:500
	});
 	//周边目的地
	createChoicePlugin({
		data:{0:chioceDestJson['trip']},
		nameId:"custom_trip",
		valId:"customDestId",
		number:5,
		buttonId:'destSelected',
		width:500
	});
});


/******************END 目的地选择***************************/
function add_travel(obj){
var day = $(obj).attr('data-val');
var str_html = "<div class='reply_travel'><div class='day_num'>第"+day+"天</div><div class='travel_day'><span class='travel_title'>标题：</span><input type='text' name='travel_title[]' value=''></div><div class='travel_day'><span class='travel_title'>交通：</span><input type='text' name='traffic[]' value=''></div><div class='form-group clear'><label for='inputEmail3' class='col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts'>用餐：</label><div class='form-inline'><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox  col_ts'><label style='padding: 0px;text-align: center;width:68px;'><input type='checkbox' name='breakfirsthas["+day+"]' value='1' ><span class='text'>早餐</span></label> </div><div  class='form-group col_ts'> <input type='text' value='' name='breakfirst["+day+"]' style='width: 175px;' class='form-control small-width' placeholder='15个字以内'></div></div><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='lunchhas["+day+"]'><span class='text'>午餐</span></label></div><div  class='form-group col_ts'><input type='text' value='' name='lunch["+day+"]' style='width: 175px;' class='form-control user_name_b1'  placeholder='15个字以内'> </div></div><div class='col_ts col_yc'><div style='padding-top: 0px;width:72px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='supperhas["+day+"]'><span class='text'>晚餐</span></label></div><div style='margin: 0px;' class='form-group'><input type='text' value='' style='width: 175px;' class='form-control user_name_b1' name='supper["+day+"]' placeholder='15个字以内'></div></div></div></div><div class='travel_content'><span class='travel_title'>行程：</span><textarea name='travel_content[]' id='textarea"+day+"'></textarea></div><div class='travel_img'><span class='travel_title'>行程图片：</span><div id='demo1'><div id='as"+day+"' ></div><div class='div_url_val'><input type='hidden' class='url_val' name='pics_url[]' value=''/></div></div></div></div>";
$(obj).before(str_html);
$('#as'+day).diyUpload({
swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
url:"<?php echo base_url('admin/b2/inquiry_sheet/up_pics')?>",
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
/*$('#trip_way option[value='+<?php echo $grab_custom_data['trip_way']?>+']').attr('selected',true);
$('#custom_type option[value='+<?php echo $grab_custom_data['custom_type']?>+']').attr('selected',true);
$('#go_shopping option[value='+<?php echo $grab_custom_data['isshopping']?>+']').attr('selected',true);
$('#go_hotel option[value='+<?php echo $grab_custom_data['hotelstar']?>+']').attr('selected',true);
$('#go_dining option[value='+<?php echo $grab_custom_data['catering']?>+']').attr('selected',true);
$('#room_require option[value='+<?php echo $grab_custom_data['room_require']?>+']').attr('selected',true);
$('#go_suppliers option[value='+<?php echo $grab_custom_data['supplier_id']?>+']').attr('selected',true);*/
</script>