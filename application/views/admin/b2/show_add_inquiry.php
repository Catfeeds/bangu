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
    .line-lable{ color: #15b000;  border:1px solid #d7e4ea;background: #edf6fa; margin-right: 2px;padding: 6px 20px 6px 12px;}
    #ds-list{ margin: 0px;padding: 0px}
    #destSelected{ margin-top: 39px;}
    .selectedTitle { float: left;margin-left:-48px;}
    .order_request{ width: 45%;}
    .selectedContent{ margin-right: 5px;cursor: pointer;color: #15b000; background: #fff; padding: 4px; }
    .parentFileBox > .fileBoxUl{ margin-left: -10px;}
    .btn_blue, .btn_blue:focus{ background-color: #09c !important;}
    
</style>
<!-- <div class="bootbox modal fade in" id="add_inquiry_sheet_modal"> -->
<!-- <div class="modal-dialog"> -->
<div class="reply">
    <div class="reply_title">添加询价单</div>
        <div class="reply_content_detial">
            <form action="#" method="post" id="add_inquiry_form">
                <div class="guest_need">
                    <p>客人需求</p>
                        <div class="guest_need_detail" border="0" style="">
                            <!-- <div class="revertContextLeft"> -->
                            <div class="need_kj clear">
                                <div class=" col_div fl">
                                    <span class="revertNums fl">编号</span>
                                    <div class="fl"><span class="revertNum fl" id="go_id">新增后自动生成</span></div>
                                </div>
                            </div>
 
                            <div class="need_kj clear">
                                <div class=" col_div fl">
                                    <label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl col_tj">出行日期：</label>
                                    <div class=" fl" style="padding-left:10px;">
                                        <div class="input-group col-sm-10" style="width:200px;margin-left:-10px" >
                                            <input style="width:183px;" class="form-control date-picker"  name="start_time" id="start_time" type="text" data-date-format="yyyy-mm-dd"/>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class='order_request fl'>
                                    <label class="col_tj fl">目的地：</label>
                                    <div class="input_click relative fl custom_dest">
                                        <input type="text" id="custom_abroad" placeholder="请选择目的地">
                                        <input type="text" style="display:none;" id="custom_domestic" placeholder="请选择目的地">
                                        <input type="text" style="display:none;" id="custom_trip" placeholder="请选择目的地">
                                    </div>
                                    <input type="hidden" id="customDestId" name="customDestId" value=""/>
                                    <div id="destSelected"></div>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl">
                                    <lable  class="col_tj fl">出游方式：</lable>
                                    <div class="fl"  id="go_shopping">
                                        <select name="trip_way" onchange="one_choose(this)">
                                            <option value="">--请选择--</option>
                                            <?php foreach ($trip_way_data as $val) {
                                            echo "<option value='{$val ['description']}'>{$val ['description']}</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class='order_request fl' style="position:relative;margin-bottom:5px;">
                                    <label class="col_tj fl">单项选择：</label>
                                    <div class="fl" id="">
                                        <select name="choose_one" id="choose_one" disabled>
                                            <option value="">--请选择--</option>
                                            <?php foreach ($choose_one_data as $val) {
                                            echo "<option value='{$val ['description']}'>{$val ['description']}</option>";
                                            }?>
                                        </select>
                                    </div>
                                    <span style="position:absolute;left:108px;top:34px"><font color="red">(*选择了出游方式中的单项服务才可用)</font></span>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl">
                                    <lable class="col_tj fl">希望出游时长：</lable>
                                    <div class="fl"  id="go_days" ><input type="text" name="days" size="3">天</div>
                                </div>
                                <div class="fl" >
                                    <label class="col_tj fl">希望人均预算(¥)：</label>
                                    <div class="revertFont2 fl" id="go_budget"><input type="text" name="budget" value="">人</div>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl">
                                    <label  class="col_tj fl">酒店要求：</label>
                                    <div class="fl" id="go_hotel">
                                        <select name="go_hotel">
                                        <option value="">--请选择--</option>
                                        <?php foreach ($hotel_data as $val) {
                                        echo "<option value='{$val ['description']}'>{$val ['description']}</option>";
                                        }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="fl" >
                                    <label class="col_tj fl">购物自费：</label>
                                    <div class="fl"  id="go_shopping">
                                        <select name="go_shopping">
                                        <option value="">--请选择--</option>
                                        <?php foreach ($shopping_data as $val) {
                                        echo "<option value='{$val ['description']}'>{$val ['description']}</option>";
                                        }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl" class='order_request'>
                                    <label class="col_tj fl">用餐要求：</label>
                                    <div class="fl"  id="go_dining">
                                        <select name="go_dining">
                                            <option value="">--请选择--</option>
                                            <?php foreach ($catering_data as $val) {
                                            echo "<option value='{$val ['description']}'>{$val ['description']}</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="fl" >
                                    <label class="col_tj fl" >指定供应商：</label>
                                    <div class="fl"  id="go_suppliers">
                                        <select name="supplier_id">
                                            <option value="">--请选择--</option>
                                            <?php foreach ($suppliers as $val) {
                                            echo "<option value='{$val ['id']}'>{$val ['realname']}</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl" class='order_request'>
                                    <label class="col_tj fl">用房数：</label>
                                    <div class="fl" id="">
                                    <input type="text" name="room_num" size=""></div>
                                </div>
                                <div class="fl" >
                                    <label class="col_tj fl">用房要求：</label>
                                    <div class="fl"  id="go_shopping">
                                        <select name="room_require">
                                            <option value="">--请选择--</option>
                                            <?php foreach ($room_data as $val) {
                                            echo "<option value='{$val ['description']}'>{$val ['description']}</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl" class='order_request'>
                                     <label class="col_tj fl">成人：</label>
                                     <div class="fl" id=""><input type="text"  name="people" id="" value="">人</div>
                                </div>
                                <div class="fl" >
                                     <label class="col_tj fl">老人：</label>
                                     <div class="fl" id=""><input type="text"  name="oldman" id="" value="">人</div>
                                </div>
                            </div>
                            <div class="need_kj clear">
                                <div class=" col_div fl"  >
                                    <label class="col_tj fl">不占床儿童：</label>
                                    <div class="fl"  id=""><input  type="text"  name="childnobednum" id="" value="">人</div>
                                </div>
                                <!-- <div class="revertContextRight"> -->
                                <div class="fl" >
                                    <label class="col_tj fl">占床儿童：</label>
                                    <div class="fl"  id=""><input type="text"  name="childnum" id="" value="">人</div>
                                </div>
                            </div>
                            <div class="need_xuq clear">
                                <div class=" col_div fl"  style="width:100%;padding-bottom:15px;">
                                    <label class="col_tj fl">管家需求概述：</label>
                                    <div class="fl " style="width:77%" id=""><textarea  class="revertexplainTextarea" name="service_range" placeholder="详细描述您的需求"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="house_price">
                        <p>管家报价</p>
                        <div class="house_price_details">
                            <div class="col_details fl">
                                <label class="fl">成人价：</label>
                                <div height="40" class="fl"> <input type="text" id="num" value="" name="price">元/人</div>
                            </div>
                            <div class="col_details  fl">
                                <label class="fl">儿童占床价：</label>
                                <div height="40" class="fl"> <input type="text" id="num" value="" name="childprice">元/人</div>
                            </div>
                            <div class="col_details fl">
                                <label class="fl">儿童不占床价：</label>
                                <div height="40" class="fl"> <input type="text" id="num" value="" name="childnobedprice">元/人</div>
                            </div>
                            <div class=" fl">
                                <label class="fl">老人价：</label>
                                <div height="40" class="fl"> <input type="text" id="num" value="" name="oldprice">元/人</div>
                            </div>
                            <div class="price_description" style="margin-bottom:-100">
                                <span class="travel_title">价格说明：</span>
                                <textarea placeholder="字数不限" name="price_description" id=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div style="margin-top:5px;">
                        <p>详细行程：<!-- <span>2015-09-16 11:47:06</span> --></p>
                        <div style="margin-bottom:-100" class="travel_content">
                            <span class="travel_title">总体描述：</span>
                            <textarea id="travel_description" name="travel_description"></textarea>
                        </div>
                        <!-- <p>回复行程：</p> -->
                        <div class="reply_travel_1">
                            <div class="reply_travel">
                                <div class="day_num">第1天</div>
                                <div class="travel_day"><span class="travel_title">标题：</span>
                                    <input type="text" value="" name="travel_title[]">
                                </div>
                                <div class="travel_day"><span class="travel_title">交通：</span>
                                    <input type="text" name="traffic[]" value="">
                                </div>
                                <div class="form-group clear">
                                    <label class="col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts" for="inputEmail3">用餐：</label>
                                    <div class="form-inline ">
                                        <div class="col_ts col_yc">
                                            <div class="checkbox  col_ts " style="padding-top: 0px;">
                                                <label style="padding: 0px;text-align: center;width:68px;">
                                                    <input type="checkbox" value="1" name="breakfirsthas[1]"><span class="text">早餐</span>
                                                </label>
                                            </div>
                                            <div class="form-group col_ts ">
                                                <input type="text" placeholder="15个字以内" class="form-control small-width" style="width: 175px;" name="breakfirst[]" value="">
                                            </div>
                                        </div>
                                        <div class="col_ts col_yc">
                                            <div class="checkbox col_ts " style="padding-top: 0px;">
                                                <label style="padding: 0px;text-align: center;width:72px;">
                                                    <input type="checkbox" name="lunchhas[1]" value="1">
                                                    <span class="text">午餐</span>
                                                </label>
                                            </div>
                                            <div class="form-group col_ts ">
                                                <input type="text" placeholder="15个字以内" class="form-control user_name_b1" style="width: 175px;" name="lunch[]" value="">
                                            </div>
                                        </div>
                                        <div class="col_ts col_yc">
                                            <div class="checkbox col_ts" style="padding-top: 0px;width:72px;">
                                                <label style="padding: 0px;text-align: center;width:72px;">
                                                    <input type="checkbox" name="supperhas[1]" value="1">
                                                    <span class="text">晚餐</span>
                                                </label>
                                            </div>
                                            <div class="form-group" style="margin: 0px;">
                                                <input type="text" placeholder="15个字以内" name="supper[]" class="form-control user_name_b1" style="width: 175px;" value="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="travel_content">
                                    <span class="travel_title">行程：</span>
                                    <textarea id="textarea1" name="travel_content[]"></textarea>
                                </div>
                                <div class="travel_img">
                                    <span class="travel_title">行程图片：</span>
                                    <div id="demo1">
                                        <div id="as1" class="webuploader-container">
                                            <div class="webuploader-pick">+ 6/6图片上传</div>
                                            <div id="rt_rt_19va46mmd1mh2ib01h0sp4q1d811" style="position: absolute; top: 0px; left: 610px; width: 82px; height: 38px; overflow: hidden; bottom: auto; right: auto;">
                                                <input type="file" name="file" class="webuploader-element-invisible" multiple accept="">
                                                <label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255) none repeat scroll 0% 0%;"></label>
                                            </div>
                                        </div>
                                        <div class="div_url_val"><!--每个地方都必须要有,不然就没办法保存数据-->
                                            <input type="hidden" value="" name="pics_url[]" class="url_val">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span style="cursor:pointer" class="add_day" data-val="2" onclick="add_travel(this)"><b>+</b>第2天</span>
                        </div>
                    </div>
                    <div style="margin-top:25px">
                        行程附件:(<font color="red">*仅xls,word 文件</font>): <input type="file" style="display:inline" value="" id="replay_file" name="replay_file">
                        <input type="button" id="upfile_replay_file" value="上传">
                        <input type="hidden" value="" id="replay_file_url" name="replay_file_url">
                    </div>
                    <div class="reply_botton">
                        <input type="hidden" id="submit_type" name="submit_type" value="" />
                        <input type="submit" name="keep_enquiry" value="保存" class="reply_button2" style="padding:0px 5px" onclick="submit_form(this)"/>
                        <input type="submit" name="go_enquiry" value="保存并发单" class="reply_button1" style="padding:0px 5px" onclick="submit_form(this)"/>
                        <input type="button" name="cancle_go_inquiry" value="取消"  class="reply_button2" onclick="window.close()"/>
                    </div>
                </form>
            </div>
        </div>
<!--End 增加询价单-->

<script src="<?php echo base_url('assets/js/diyUpload.js') ;?>"></script>
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
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
$('#add_inquiry_form').submit(function(){
	$("#keep_enquiry").attr('disabled',true);
       $("#go_enquiry").attr('disabled',true);
	$.post(
	"<?php echo site_url('admin/b2/inquiry_sheet/add_inquiry');?>",
	$('#add_inquiry_form').serialize(),
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

function one_choose(obj){
	if($(obj).val()=="单项服务"){
		$("#choose_one").attr('disabled',false);
	}else{
		$("#choose_one").attr('disabled',true);
		$("#choose_one").val("");
	}
}

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

$('#as1').diyUpload({
	swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
	url:"<?php echo base_url('admin/b2/inquiry_sheet/up_pics')?>",
	success:function( data ) {

	//console.log($(this));
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
    var str_html = "<div class='reply_travel'><div class='day_num'>第"+day+"天</div><div class='travel_day'><span class='travel_title'>标题：</span><input type='text' name='travel_title[]'         value=''></div><div class='travel_day'><span class='travel_title'>交通：</span><input type='text' name='traffic[]' value=''></div><div class='form-group clear'><label             for='inputEmail3' class='col-sm-2 control-label no-padding-right label-width col_lb travel_title col_yc col_ts'>用餐：</label><div class='form-inline'><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox  col_ts'><label style='padding: 0px;text-align: center;width:68px;'><input type='checkbox' name='breakfirsthas["+day+"]' value='1' ><span class='text'>早餐</span></label> </div><div  class='form-group col_ts'> <input type='text' value='' name='breakfirst["+day+"]' style='width: 175px;' class='form-control small-width' placeholder='15个字以内'></div></div><div class='col_ts col_yc'><div style='padding-top: 0px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='lunchhas["+day+"]'><span class='text'>午餐</span></label></div><div  class='form-group col_ts'><input type='text' value='' name='lunch["+day+"]' style='width: 175px;' class='form-control user_name_b1'  placeholder='15个字以内'> </div></div><div class='col_ts col_yc'><div style='padding-top: 0px;width:72px;' class='checkbox col_ts'><label style='padding: 0px;text-align: center;width:72px;'><input type='checkbox' value='1' name='supperhas["+day+"]'><span class='text'>晚餐</span></label></div><div style='margin: 0px;' class='form-group'><input type='text' value='' style='width: 175px;' class='form-control user_name_b1' name='supper["+day+"]' placeholder='15个字以内'></div></div></div></div><div class='travel_content'><span class='travel_title'>行程：</span><textarea name='travel_content[]' id='textarea"+day+"'></textarea></div><div class='travel_img'><span class='travel_title'>行程图片：</span><div id='demo1'><div id='as"+day+"' ></div><div class='div_url_val'><input type='hidden' class='url_val' name='pics_url[]' value=''/></div></div></div></div>";
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
$('#start_time').datepicker();
</script>