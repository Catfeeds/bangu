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

	/*   交通工具选择   */
	.traffic_type { width:750px;display:inline-block;border:1px solid #d5d5d5;background:#fff;height:35px;line-height:35px;position:relative;}
	.traffic_content { outline:none;height:35px;line-height:35px;padding:0 10px;}
	.title_text { position:absolute;top:8px;left:10px;color:#888;max-width:750px;height:18px;line-height:18px;}
	#route_div .route { float:left;display: inline-block; padding: 8px 8px;}
	#route_div .route img { vertical-align:middle;cursor:pointer;}
	.traffic_content img { padding:5px 5px 8px 5px;}
</style>
<div class="reply">
  <div class="reply_title">询价单</div>
  <div class="reply_content_detial">
    <form id="edit_form" method="post" action="#">
    <div class="guest_need">
      <p>客人需求</p>
  <div style="" border="0" class="guest_need_detail">
        <div class="need_kj clear">
        <div class=" col_div fl">
            <span class="bianma fl">编号：</span>
            <div style="margin-top:4px;">
            <span class="bianma_1"><?php echo $c_id?></span>
            </div>
        </div>

        </div>
      <div class="need_kj clear">
      <div class="col_div fl">
      <label class="fl">出发城市：</label>
          <div class=" col_mg fl">
                  <span><?php echo $grab_custom_data['startplace']?></span>
            </div>

        </div>
        <div class=" fl">
        <label class="fl">目 &nbsp;的&nbsp; 地：</label>
        <div class="fl"> <span><?php echo $grab_custom_data['endplace_name']?></span></div>

        </div>
        </div>

      <div class="need_kj clear">
      <div class=" col_div fl">
      <label class="fl">出行日期：</label>
        <div class=" fl">
       <span><?php if(!empty($grab_custom_data['estimatedate'])){ echo $grab_custom_data['estimatedate'].'(预估)';}else{echo $grab_custom_data['startdate'].'(确认)';}?></span>
        </div>
        </div>
         <div class="  fl">
        <label class="fl">希望出游时长：</label>
        <div class="fl" height="40"> <span><?php echo $grab_custom_data['days']?> 天</span></div>
        </div>
   <!-- <div class=" col_div fl">
      <label class="fl">预估日期：</label>
        <div class=" fl">
       <span><?php echo $grab_custom_data['estimatedate']?></span>
        </div>
        </div>  -->
        <div class="col_div fl">
        <label class="fl">定制类型：</label>
        <div class="fl">
             <span><?php echo $grab_custom_data['custom_type']?></span>
      <!--   <input type="text" name="theme" value="2"/> -->
        </div>
        </div>
        <div class="  fl">
       <label class="fl">出游方式：</label>
        <div class="fl">
                 <span><?php if(!empty($grab_custom_data['another_choose'])){ echo $grab_custom_data['trip_way'].'/'.$grab_custom_data['another_choose'];}else{ echo $grab_custom_data['trip_way'];}?></span>
        </div>
        </div>
      </div>
      <div class="need_kj clear">
          <div class=" col_div fl">
        <label class="fl">用房要求：</label>
             <div height="40" class="fl"><span><?php echo $grab_custom_data['room_require']?></span></div>
        </div>
        <div class="fl"><label class="fl">总人数：</label>
            <div class="fl"> <span>1</span><?php echo $grab_custom_data['total_people']?></div>

        </div>
        </div>
         <div class="need_kj clear">
          <div class=" col_div fl">
        <label class="fl">出游人：</label>
        <div class="fl" height="40">  <span><?php echo $grab_custom_data['people']?></span>&nbsp;(成人)&nbsp;/&nbsp;</div>
         <div class="fl"><span><?php echo $grab_custom_data['childnum']?></span> &nbsp;(占床儿童)&nbsp;/&nbsp;</div>
          <div class="fl"> <span><?php echo $grab_custom_data['childnobednum']?></span>&nbsp;(不占床儿童)&nbsp;/&nbsp;</div>
           <div class="fl"> <span><?php echo $grab_custom_data['oldman']?></span>&nbsp;(老人)&nbsp;</div>
        </div>
        <div class="fl"><label class="fl">用房数：</label>
            <div class="fl"> <span><?php echo $grab_custom_data['roomnum']?></span>间</div>

        </div>
        </div>
        <!--   <div class="need_kj clear">


    	<div class="fl">
         <label class="fl">单项选择：</label>
        <div class="fl">
                 <span><?php echo $grab_custom_data['another_choose']?></span>
        </div>
        </div>
        </div>-->
        <div class="need_kj clear">
        <div class="col_div fl">
        <label class="fl">希望人均预算：</label>
        <div class="fl">￥  <span><?php echo $grab_custom_data['budget']?></span> /人</div>
      </div>
        <div class="fl">
         <label class="fl">购物自费：</label>
        <div class="fl">
         <span><?php echo $grab_custom_data['isshopping']?></span>
        </div>

        </div>
        </div>
        <div class="need_kj clear">
          <div class=" col_div fl">
         <label class="fl">要求酒店：</label>
        <div class="fl">
            <span><?php echo $grab_custom_data['isshopping']?></span>
        </div>
        </div>
        <div class="fl">
            <label class="fl">要求用餐：</label>
             <div height="40" class="fl"> <span><?php echo $grab_custom_data['hotelstar']?></span></div>
        </div>
        </div>
        <div class="need_kj clear">

             <div class="fl">
             <label class="fl">详细需求概述：</label>
                <div class="fl"><span><?php echo $grab_custom_data['service_range']?></span></div>

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
    <div style="margin-top:5px;" id="rout_line">
      <p>详细行程：<!-- <span>2015-09-21 16:45:47</span> --></p>
      <div style="margin-bottom:-100" class="travel_content">
          <span class="travel_title">总体描述：</span>
          <textarea id="travel_description" name="travel_description"><?php echo $expert_baojia['plan_design']?></textarea>
        </div>
      <!-- <p>回复行程：</p> -->
<div class="reply_travel_1">
<?php $i=1;foreach ($custom_trip_data_list as $item): ?>
      <div class="reply_travel">
          <div class="day_num">第<?php echo $item['cj_day']?>天</div>
        <!--<div class="travel_day"><span class="travel_title">标题：</span>
          <input type="text"  name="travel_title[]" value="<?php echo $item['cj_title']?>"/>
          <input type="hidden" name="cj_id[]" value="<?php echo $item['cj_id']?>">

        </div> -->
        <div class="travel_day">
        	<span class="travel_title">标题：</span>
            <div class="traffic_type">
                <div class="traffic_content" contenteditable="true"><?php echo $item['cj_title']?></div>
                <div class="title_text">出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div>
                <input type="hidden" name="travel_title[]" class="hidden_traffic" value="<?php echo $item['cj_title']?>"/>
                <input type="hidden" name="cj_id[]" value="<?php echo $item['cj_id']?>"/>
            </div>
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

<!--===============交通工具============== -->
<div id="route_div" style="position: absolute;background: #fff;border: 1px solid #DDDBDB;display: none;z-index: 1000;">
    <div class="route"><img alt="飞机" src="<?php echo base_url();?>/assets/img/icons/route/plain.gif"></div>
    <div class="route"><img alt="汽车" src="<?php echo base_url();?>/assets/img/icons/route/bus.gif"></div>
    <div class="route"><img alt="轮船" src="<?php echo base_url();?>/assets/img/icons/route/ship.gif"></div>
    <div class="route"><img alt="火车" src="<?php echo base_url();?>/assets/img/icons/route/train.gif"></div>
    <div style="display: inline-block;margin-left: 10px;padding: 0 5px;margin-top:7px;">点击图标，选择交通工具</div>
</div>
<script src="<?php echo base_url('assets/js/diyUpload.js') ;?>"></script>
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
 <script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script type="text/javascript">
//行程安排 交通工具
var route_obj = null;
jQuery("#rout_line").on("click",'.traffic_type',function(){　
	$(".traffic_type").removeClass("check_this");
	$(this).addClass("check_this");
	$(this).find(".title_text").hide();
	$(this).find(".traffic_content").focus();
	route_obj = jQuery(this);
	var top = route_obj.offset().top+route_obj.outerHeight()-80;
	var left = route_obj.offset().left;
	jQuery("#route_div").css({left : left,top : top});
	jQuery("#route_div").show();
});

jQuery("#route_div").on("click", ".route img",function(){
	$(".check_this").find(".traffic_content").siblings(".title_text").hide();
	var v = jQuery(this).parent().html();
	insertNodeOverSelection(route_obj[0],jQuery(this)[0]);
 	var val = $(".check_this").find(".traffic_content").html();
	$(".check_this").find(".hidden_traffic").val(val);
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

jQuery("#rout_line").on("blur", ".traffic_content",function(){
	var me = jQuery(this);
	var val = me.html();
	var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头
	var end_ptn = /[ | ]*\n/g;            //过滤标签结束
	var space_ptn = /&nbsp;/ig;          //过滤标签结尾
	var value = val.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");

	if(value.length<=0){
		me.siblings(".title_text").show();
	}else{
		me.siblings('.hidden_traffic').val(value);
	}
	routeTimeout = setTimeout("hideRoute();", 300);
});

//移入
jQuery("#rout_line").on("mouseenter", ".traffic_content",function(){
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

//移除交通工具层 隐藏
jQuery("#route_div").mouseenter(function(){
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

//移除交通工具层 隐藏
jQuery("#route_div").mouseleave(function(){
	routeTimeout = setTimeout("hideRoute();", 800);
});

//隐藏交通工具
function hideRoute(){
	jQuery("#route_div").hide();
}
var routeTimeout = null;


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
  $('#edit_form').submit(function(){
      $("#keep_enquiry").attr('disabled',true);
       $("#go_enquiry").attr('disabled',true);
      $.post(
        "<?php echo site_url('admin/b2/inquiry_sheet/edit_opera_2');?>",
        $('#edit_form').serialize(),
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


function add_travel(obj){
var day = $(obj).attr('data-val');
var str_html = "<div class='reply_travel'><div class='day_num'>第"+day+"天</div><div class='travel_day'><span class='travel_title'>标题：</span><div class='traffic_type'><div class='traffic_content' contenteditable='true'></div><div class='title_text'>出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div><input type='hidden' name='travel_title[]' value=''class='hidden_traffic'/></div></div><div class='travel_day'><span class='travel_title'>交通：</span><input type='text' name='traffic[]' value=''></div><div class='form-group clear'><label for='inputEmail3' class='col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts'>用餐：</label><div class='form-inline'><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox  col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' name='breakfirsthas["+day+"]' value='1' ><span class='text'>早餐</span></label> </div><div  class='form-group col_ts'> <input type='text' value='' name='breakfirst["+day+"]' style='width: 175px;' class='form-control small-width' placeholder='15个字以内'></div></div><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='lunchhas["+day+"]'><span class='text'>午餐</span></label></div><div  class='form-group col_ts'><input type='text' value='' name='lunch["+day+"]' style='width: 175px;' class='form-control user_name_b1'  placeholder='15个字以内'> </div></div><div class='col_ts col_yc'><div style='padding-top: 0px;width:72px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='supperhas["+day+"]'><span class='text'>晚餐</span></label></div><div style='margin: 0px;' class='form-group'><input type='text' value='' style='width: 175px;' class='form-control user_name_b1' name='supper["+day+"]' placeholder='15个字以内'></div></div></div></div><div class='travel_content'><span class='travel_title'>行程：</span><textarea name='travel_content[]' id='textarea"+day+"'></textarea></div><div class='travel_img'><span class='travel_title'>行程图片：</span><div id='demo1'><div id='as"+day+"' ></div><div class='div_url_val'><input type='hidden' class='url_val' name='pics_url[]' value=''/></div></div></div></div>";
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
</script>