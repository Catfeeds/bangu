<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>回复方案</title>
 <link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
  .expert_offer_price { margin-bottom:10px;margin-top:5px;}
  .expert_offer_price div { float:left;margin-right:26px;height:40px;line-height:40px;}
  .expert_offer_price div span { display:inline-block;width:90px;padding-right:5px;text-align:right;}
  .expert_offer_price div input { width:54px;padding:5px 8px;height:20px;line-height:20px;text-align:center;}
  .price_explain { margin-bottom:10px;}
  .price_explain_title { float:left;color:#6cf;width:90px;padding-right:5px;text-align:right;}
  .price_explain textarea { width:705px;height:100px;padding:5px 8px;resize:none;}
  .project_name { height:44px;line-height:44px;margin-bottom:20px;}

  .travel_arrange { border:none;width:100%;}
  .travelDay { border-top:none !important;}
  .add_travel { display:block;float:none;margin-left:20px;width:60px;}
  .form_btn { margin-top:40px;}
  .form_btn input { margin-left:150px;}
  .traffic_type { width:721px;}
  .travel_content_title { width:80px;}
  .w_705 { width:705px !important;}
  .table_content { padding: 0 0 20px 0;}
  .project_number { height:40px;line-height:40px;font-family:"微软雅黑";}
  .project_number_title { border-radius:5px 0 0 5px;background:#868686;color:#fff;height:20px;line-height:20px;padding:10px 15px;}
  .project_number_info { text-align:center;border:1px solid #d2d2d2;border-left:none;width:80px;padding:7px 10px;display:inline-block;height:20px;line-height:20px;color:#2dc3e8;}

  .form_group input, .form_group select, .form_group textarea, .form_group span { margin-left:0;}

  .supplier_reply_check .text { margin-top:0;}

  #project_list li { position:relative;}
  #project_list .delete_this_project { position: absolute; height: 28px; line-height: 28px; width: 18px; font-size: 20px; cursor: pointer; top: -10px; right: 0px; z-index: 100; color: #ccc; font-weight: 700;z-index:100;}
  #project_list .delete_this_project:hover { color:#f30;}

  .input_field span.btn { margin-top:10px;}
</style>
</head>
<body class="iframe_body">

    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
        <!-- ===============我的位置============ -->
   <div class="current_page">
            <a href="<?php echo site_url('admin/b1/view')?>" class="main_page_link" target="main"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="<?php echo site_url('admin/b2/grab_custom_order/index')?>" target="main">供应商回复询价</a>
            <span class="right_jiantou">&gt;</span>回复询价单
        </div>

        <!-- ===============回复方案  start============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt">回复询价</h2>

            <form id="reply_form" method="post" action="#">
            <!-- ===============客人需求============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">管家需求</span>
                </div>
                <div class="project_number"><span class="project_number_title">编号:</span><span class="project_number_info"><?php echo $custom_info['c_id']?></span></div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">出发城市:</td>
                        <td width="320"><?php echo explode('|',$custom_info['startplace'])[0]?></td>
                        <td class="order_info_title">目的地城市:</td>
                        <td><?php echo explode('|',$custom_info['endplace_three'])[0]?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出游方式:</td>
                        <td><?php if(!empty($custom_info['another_choose']) && $custom_info['trip_way']!=null){ echo $custom_info['trip_way'].'/'.$custom_info['another_choose'];}else{echo $custom_info['trip_way'];}?></td>
                        <td class="order_info_title">定制类型:</td>
                        <td><span><?php echo $custom_info['custom_type']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出行日期:</td>
                        <td>
                        <?php  echo (!empty($custom_info['startdate']) && $custom_info['startdate']!="0000-00-00") ? $custom_info['startdate']:$custom_info['estimatedate'];?>
                        </td>

                        <td class="order_info_title">人均预算:</td>
                        <td>￥<?php echo $custom_info['budget']?>/人</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出游时长:</td>
                        <td colspan="3"><?php echo $custom_info['days']?>天</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">酒店要求:</td>
                        <td><?php echo $custom_info['hotelstar']?></td>
                        <td class="order_info_title">用餐要求:</td>
                        <td><?php echo $custom_info['catering']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">用房要求:</td>
                        <td><?php echo $custom_info['room_require']?></td>
                        <td class="order_info_title">购物自费:</td>
                        <td><?php echo $custom_info['isshopping']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">详细需求表述:</td>
                        <td colspan="3">
                        <?php echo $custom_info['service_range']?>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">总人数:</td>
                        <td><?php echo $custom_info['total_people']?></td>
                        <td class="order_info_title">用房数:</td>
                        <td><?php echo $custom_info['roomnum']?>间</td>
                    </tr>
                    <tr height="40">
                      <td class="order_info_title">成员构成:</td>
                        <td colspan="3">
                          成人&nbsp;<?php echo $custom_info['people']?>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
                          儿童占床&nbsp;<?php echo $custom_info['childnum']?>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
                          儿童不占床&nbsp;<?php echo $custom_info['childnobednum']?>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
                            老人&nbsp;<?php echo $custom_info['oldman']?>&nbsp;人&nbsp;&nbsp;
                        </td>
                    </tr>
                </table>
            </div>

            <!-- ===============管家报价============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">供应商报价</span>
                </div>
                <div class="expert_offer_price clear">
                  <div><span>成人价：</span><input type="text" name="price"  value=""/>元/人</div>
                    <div><span style="width:80px;">儿童占床价：</span><input type="text" name="childprice"  value=""/>元/人</div>
                    <div><span style="width:90px;">儿童不占床价：</span><input type="text" name="childnobedprice" value="" />元/人</div>
                    <div ><span style="width:55px;">老人价：</span><input type="text" name="oldprice" value=""/>元/人</div>
                    <div style="margin-right:0;"><span style="width:60px;">佣金：</span><input type="text" name="agent_rate" value=""/>元/人份</div>
                </div>
                <div class="price_explain clear">
                  <div class="price_explain_title">方案推荐：</div>
                    <textarea id="price_decription" name="reply_content" placeholder="字数不限"></textarea>
                </div>
            </div>
            <!-- ===============详细行程============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">详细行程</span>
                </div>
                <div class="price_explain clear">
                  <div class="price_explain_title">总体描述：</div>
                    <textarea name="travel_description" placeholder="字数不限"><?php echo $custom_info['plan_design']?></textarea>
                </div>
                <div class="table_content">
                    <ul class="tab_nav nav nav-tabs tab_shadow clear" id="project_list">
                        <li class="active" onclick='choice_this(this);'><a href="###">方案</a></li>
                    </ul>
                    <div class="tab_content">
                        <div class="table_list">
                          <div class="project_name clear">
                                <div class="price_explain_title">方案名称：</div>
                                <input type="text" placeholder="方案名称" class="travel_describe w_705" name="plan_name" value="<?php echo $custom_info['ca_title']?>"/>
                            </div>

                            <div class="travel_content" id="rout_line">
                            <!-- Start 详细行程开始-->
                            <?php if(!empty($custom_trip_data_list)):?>
                                   <div class="travel_arrange">
                            <?php $i=1;foreach ($custom_trip_data_list as $item): ?>
                                    <div class="travelDay">
                                      <span class="delete_day" style="display:none;">×</span>
                                      <div class="form_group clear">
                                        <div class="dayNum travel_content_title">第<i><?php echo $item['cj_day']?></i>天</div>
                                        <div class="input_field">
                                             <div class="traffic_type">
                                                <div class="traffic_content" contenteditable="true"><?php echo $item['cj_title']?></div>
                                                <?php if(empty($item['cj_title'])):?>
                                                <div class="title_text">出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div>
                                                <?php endif;?>
                                                <input type="hidden" name="travel_title[]" class="hidden_traffic" value='<?php echo $item['cj_title']?>'/>
                                               <input type="hidden" name="cj_id[]" value="<?php echo $item['cj_id']?>"/>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div  class="travel_content_title">城市间交通:</div>
                                        <div class="input_field"><input type="text" placeholder="交通方式" class="travel_describe w_705" name="traffic[]" value="<?php echo $item['transport']?>" /></div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">用餐:</div>
                                        <div class="foot">
                                            <div>
                                            <label class="check_ico">
                                            <?php if($item['breakfirsthas']==1):?>
                                                 <input type="checkbox" name="breakfirsthas[<?php echo $i;?>]" value="1" checked />
                                                 <span class="text checked"><span><i></i></span>早餐</span>
                                             <?php else:?>
                                                 <input type="checkbox"  name="breakfirsthas[<?php echo $i;?>]" value="1" />
                                                 <span class="text"><span><i></i></span>早餐</span>
                                            <?php endif;?>

                                            </label>
                                            <input type="text" placeholder="15字以内" name="breakfirst[<?php echo $i;?>]" value="<?php echo $item['breakfirst']?>"/>
                                            </div>

                                            <div>
                                            <label class="check_ico">
                                             <?php if($item['lunchhas']==1):?>
                                                <input type="checkbox" name="lunchhas[<?php echo $i;?>]" value="1" checked />
                                                <span class="text checked"><span><i></i></span>午餐</span>
                                             <?php else:?>
                                                    <input type="checkbox"  name="lunchhas[<?php echo $i;?>]" value="1" />
                                                    <span class="text"><span><i></i></span>午餐</span>
                                            <?php endif;?>

                                            </label>
                                            <input type="text" placeholder="15字以内" name="lunch[<?php echo $i;?>]" value="<?php echo $item['lunch']?>" />
                                            </div>

                                            <div style="margin-right:0;">
                                            <label class="check_ico">
                                            <?php if($item['supperhas']==1):?>
                                                <input type="checkbox" name="supperhas[<?php echo $i;?>]" value="1" checked />
                                                <span class="text checked"><span><i></i></span>晚餐</span>
                                            <?php else:?>
                                                <input type="checkbox"  name="supperhas[<?php echo $i;?>]" value="1" />
                                                <span class="text"><span><i></i></span>晚餐</span>
                                            <?php endif;?>

                                            </label>
                                            <input type="text" placeholder="15字以内" name="supper[<?php echo $i;?>]"  value="<?php echo $item['supper']?>" />
                                            </div>

                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">住宿:</div>
                                        <div class="input_field">
                                        <input type="text" placeholder="请输入入住酒店" class="travel_describe w_705" name="hotel[]" value="<?php echo $item['hotel']?>"/>
                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title"><i class="important_title">*</i>行程安排:</div>
                                        <div class="input_field">
                                    <textarea class="text_describe noresize" name="travel_content[]"><?php echo $item['cj_jieshao']?></textarea>
                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">行程图片:</div>

                                        <div class="input_field">
                                        <input type="hidden" class='url_val' name="pics_url[]" value="<?php echo $item['c_pic']?>"/>
                                         <?php if(isset($item['pic_arr'])&&count($item['pic_arr'])!=0):?>
                                         <?php foreach ($item['pic_arr'] as $val): ?>
                                      <div class="img_main">
                                    <div id="del_img" class="float_div" data-val="<?php echo $val;?>" onclick="cancle_pic(this)">×</div>
                                             <img style="width:180px; height:160px;" src="<?php echo $val;?>"   />
                                      </div>
                                     <?php endforeach;?>
                                     <?php endif;?>
                                      </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">&nbsp;</div>
                                         <input type="hidden" name="pic_id[]" value="<?php echo $item['cjp_id']?>"/>
                                        <div class="input_field"><span onclick="change_avatar(this)" class="btn btn_blue">上传图片</span></div>
                                      </div>
                                    </div>
                                 <?php $i++; endforeach;?>
                               <span class="btn btn_blue"  data-val="<?php echo $i;?>" onclick="add_travel(this)">+第<i><?php echo $i;?></i>天</span>
                                    </div>
                                  <?php endif;?>
                                <!-- End 详细行程结束 -->
                                <div class="form_btn clear">
                                   <!--  <input type="hidden" id="submit_type" name="submit_type" value="" /> -->
                                    <input type="hidden"  name="customize_id" value="<?php echo $c_id;?>"/>
                                    <input type="hidden"  name="e_id" value="<?php echo $eid;?>"/>
                                    <!-- <input type="submit"  name="keep_data" id="keep_data" value="暂存" class="btn btn_green" onclick="submit_form(this)"/> -->
                                    <input type="submit" name="go_submit" id="go_submit" value="提交方案" class="btn btn_green"/>
                                    <input type="button" name="reset" value="取消" class="btn btn_red" onclick="window.close()"/>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
  </div>
<!--===============交通工具============== -->
<div id="route_div" style="position: absolute;background: #fff;border: 1px solid #DDDBDB;display: none;z-index: 1000;">
    <div class="route"><img  src='<?php echo base_url();?>/assets/img/icons/route/plain.gif'></div>
    <div class="route"><img  src='<?php echo base_url();?>/assets/img/icons/route/bus.gif'></div>
    <div class="route"><img  src='<?php echo base_url();?>/assets/img/icons/route/ship.gif'></div>
    <div class="route"><img  src='<?php echo base_url();?>/assets/img/icons/route/train.gif'></div>
    <div style="display: inline-block;margin-left: 10px;padding: 0 5px;margin-top:7px;">点击图标，选择交通工具</div>
</div>

<!-- 美图秀秀 -->
<div id="img_upload">
    <div id="altContent"></div>
    <div class="close_xiu" onclick="close_xiuxiu();">×</div>
    <div class="avatar_box"></div>
</div>


<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script src="<?php echo base_url('assets/js/traffic_choose.js')?>"></script>
<script src="<?php echo base_url('assets/js/alertBox.js')?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>

<script type="text/javascript">


/*function submit_form(obj){
        var submit_name = $(obj).attr('name');
        if(submit_name=='keep_data'){
          $("#submit_type").val('0');
        }else{
         $("#submit_type").val('1');
        }
        return true;
}*/

function cancle_pic(obj){
         var final_arr =  new Array();;
         var pic_url= $(obj).parent().parent().find('.url_val').val();
         var src_url =  $(obj).siblings('img').attr('src');
         pic_url = pic_url.substr(0,pic_url.length - 1);
         var pic_url_arr = pic_url.split(';');
         for(var i=0;i<pic_url_arr.length;i++){
            if(pic_url_arr[i]!=src_url){
              final_arr.push(pic_url_arr[i]) ;
            }
        }
       var final_pic_url = final_arr.join(';')+';';
       $(obj).parent().parent().find('.url_val').val(final_pic_url);
       $(obj).parent().remove();
      }

  $('#reply_form').submit(function(){
      $("#keep_data").attr('disabled',true);
       $("#go_submit").attr('disabled',true);
      $.post(
        "<?php echo site_url('admin/b1/enquiry_order/insert_enquiry_grab');?>",
        $('#reply_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.code == 200) {
            alert(data.msg);
            window.opener.location.reload();
            window.close();
          } else {
            alert(data.msg);
            $("#keep_data").attr('disabled',false);
            $("#go_submit").attr('disabled',false);
          }
        }
      );
      return false;
    });


//美图秀秀上传图片
function change_avatar(obj){
    $('.avatar_box').show();
        var size='';
        size='500x300';
       /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
        xiuxiu.setLaunchVars("cropPresets", size);
        xiuxiu.embedSWF("altContent",5,'100%','100%');
           //修改为您自己的图片上传接口
        xiuxiu.setUploadURL("<?php echo base_url('admin/upload/uploadImgFileXiu'); ?>");
                xiuxiu.setUploadType(2);
                xiuxiu.setUploadDataFieldName("uploadFile");
        xiuxiu.onInit = function(){
            //默认图片
            xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
        }
        xiuxiu.onUploadResponse = function (data){
            data = eval('('+data+')');
            if (data.code == 2000){
                //行程上传图片
                 var line_photo_url="<div class='img_main'><div id='del_img' class='float_div' data-val='"+data.msg+"' onclick='cancle_pic(this)'>×</div><img style='width:180px; height:160px;' src='"+data.msg+"'/></div>";
                     var $fileInput = $(obj).parent().parent();
                    if($fileInput.prev().find('.img_main').length>=3){
                           alert('上传文件数量超过限制');
                    }else{
                        $fileInput.prev().find('.input_field').html($fileInput.prev().children('.input_field').html()+line_photo_url);
                        $fileInput.prev().find('.url_val').val($fileInput.prev().find('.url_val').val()+data.msg+';');
                    }
                close_xiuxiu();
            } else {
                alert(data.msg);
            }

        }
         $("#img_upload").show();
         $(".close_xiu").show();
}
//关闭美图秀秀
function close_xiuxiu(){
    $("#img_upload").hide()
    $('.avatar_box').hide();
    $(".close_xiu").hide();
}
</script>
</body>
</html>
