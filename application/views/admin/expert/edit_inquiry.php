<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>转询价单</title>
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
 <link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
.expert_offer_price { margin-bottom:10px;margin-top:5px;}
.expert_offer_price div { float:left;margin-right:26px;height:40px;line-height:40px;}
.expert_offer_price div span { display:inline-block;width:90px;padding-right:5px;text-align:right;}
.expert_offer_price div input { width:54px;padding:5px 8px;height:20px;line-height:20px;text-align:center;}
.price_explain { margin-bottom:10px;}
.price_explain_title { float:left;color:#09c;width:90px;padding-right:5px;text-align:right;}
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
.project_number { height:50px;line-height:40px;font-family:"微软雅黑";}
.project_number_title { border-radius:5px 0 0 5px;background:#868686;color:#fff;height:20px;line-height:20px;padding:10px 15px;}
.project_number_info { text-align:center;border:1px solid #d2d2d2;border-left:none;width:80px;padding:7px 10px;display:inline-block;height:20px;line-height:20px;color:#2dc3e8;}

.supplier_reply_check .text { margin-top:0;}
.search_group { margin: 1px 0 0 0;}

.w_80 { width:80px !important;}
.form_input { height: 24px;line-height: 20px;padding: 5px 8px;margin:5px 0;display:inline-block;width:270px;}
.form_textarea { height:100px;padding:5px 8px;margin:2px 0;width:683px;}
.order_info_table tr td { padding-left:5px;}
select.form_select { height: 24px;line-height: 24px;padding: 5px 8px;margin:5px 0;width:270px;}
div.form_select { margin:2px 0;}

/*目的地选择*/
.to_play_input{ float: left; height: 38px; line-height: 38px; position: relative;box-sizing:border-box;margin:2px 0;z-index:199;}
.to_play_input input{ cursor:pointer;padding-left: 6px; height: 38px; line-height: 38px; float: left; color: #333;border: 1px solid #d5d5d5;position: relative;box-sizing:border-box;}
.to_play_input u{ background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) no-repeat;position: absolute; width: 10px; height: 5px; right: 20px; top: 16px; cursor: pointer;}

.to_play_input_multi{ float: left; height: 36px; line-height: 34px; position: relative;}
.to_play_input_multi input{ padding-left: 6px; height: 38px; line-height: 38px; float: left; color: #999;border: 1px solid #999;position: relative;box-sizing:border-box;}
.to_play_input_multi u{ background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) no-repeat;position: absolute; width: 10px; height: 5px; right: 10px; top: 14px; cursor: pointer;}

/*隐藏的list列表*/
.input_list_hidden{ position: absolute; top:38px; left: 100px; background: #fff; cursor: pointer; z-index: 100; display: none; border: 1px solid #d5d5d5; border-top:none;}
.input_list_hidden li{ padding-left: 8px;}
.input_list_hidden li:hover{ background: #ccc; }
.input_Company{position: absolute; top: 0; right: 10px; font-size: 14px; height: 38px; line-height: 38px; color: #333333position: relative;box-sizing:border-box;;}
.input_hidden_list{ position: absolute; top:38px;left: 100px; cursor: pointer; width:200px; background: #fff; z-index: 100; display: none; border: 1px solid #d5d5d5; border-top:none;}
.input_hidden_list li{width:194px !important;padding: 0 !important; padding-left: 8px !important; }
.input_hidden_list li:hover{ background: #ccc;}
.li_input_box input{ color: #999;}
.not_receive{ text-align: left; padding-left: 20px;}
.not_receive a{ color:#ff9900; padding-left: 5px;}

.input_list_hidden_multi{ position: absolute; top:38px;left: 100px; cursor: pointer; width:200px; background: #fff; z-index: 100; display: none; border: 1px solid #d5d5d5; border-top:none;}
.input_list_hidden_multi li{ padding: 0 !important; padding-left: 8px !important; border-top: 1px solid #ebebeb; position: relative;}
.input_list_hidden_multi li:hover{ background: #ccc;}

/*添加的对勾样式*/
.clixk_ok{ position:absolute; right: 5px; top: 10px; width:20px !important; height: 20px !important; background: url(<?php echo base_url();?>static/img/ok_msu.png) no-repeat ;}

.row_ree_one{ width: 198px; left: 0;}
.row_ree_two{ width: 231px; left: 214px;}
.mudidi_input{ float: left; position: relative;}
.mudidi_input input{ float: left;}
.mudidi_one{ width: 200px !important; margin-right: 14px;}
.mudidi_two{ width: 233px !important; margin-right: 14px;}
.mudidi_three{ width: 240px !important;}

#destButton{ height:32px; line-height:32px; float:left; width: 700px; margin:0px; display:none; margin-bottom: 5px;}
.selectedTitle{ position: relative; left: 0; padding-right:10px; float:left; text-align: right;}
.selectedContent{ height:24px; line-height:24px; background:#f54; float:left; margin-top:4px; padding:0 10px; padding-right:7px; color:#FFF; margin-right:10px; border-radius:2px;}
.delPlugin{ padding-bottom:6px; font-family: inherit; float:right; cursor:pointer; font-size:16px; padding:0 3px;}

.form_select .search_select .select_list li { height:30px;line-height:30px;}
#expert_dest[disabled=disabled] { background:#f2f2f2;cursor:text;}

.form_select1 { float:left;}
.form_select1 .search_select1 { position:relative;-webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;}
.form_select1 .search_select1 .show_select1 { width:180px;height:26px;line-height:26px;padding:5px 8px;background:#fff;border:1px solid #d5d5d5;cursor:pointer;color:#999;}
.form_select1 .search_select1 i { position:absolute; width: 7px; height: 4px; background: url(<?php echo base_url();?>assets/img/custom_list_ico1.png) 0px 0px no-repeat; right:10px; top: 18px;z-index:125;}
.form_select1 .search_select1 .select_list1 { border:1px solid #d5d5d5;background:#fff;border-top:0px;display:none;position:absolute;z-index:130;max-height:300px;overflow-x:hidden;overflow-y:auto;box-sizing:border-box;}
.form_select1 .search_select1 .select_list1 li { box-sizing:border-box;padding-left:8px;background:#fff;cursor:pointer;height:20px;line-height:20px;position:relative;}
.form_select1 .search_select1 .select_list1 li:hover { background:#bebebe;color:#fff;}
.form_select1 .search_select1 .select_list1 li.select { background-color: #f3f3f3; color: #999;}
.form_select1 .search_select1 .select_list1 li i { display:none;position: absolute; right: 5px; top: 5px; width: 20px; height: 20px; background: url(<?php echo base_url();?>static/img/ok_msu.png) no-repeat;}
.form_select1 .search_select1 .select_list1 li.select i { display:block;}
.form_select1 .search_select1 .select_list1 li { height:30px;line-height:30px;}
.click_num { color:#f90;padding:0 5px;}

.data_describe { height:25px;line-height:25px;margin:5px;}
.data_describe label { margin-right:20px;cursor:pointer;}
.data_describe label input { position:relative;width:15px;height:15px;top:4px;padding-right:3px;}

.input_field span.btn { margin-top: 10px;}
.current_page{ width: 1020px; margin: 0 auto; height: 40px ;line-height: 40px; position: relative; z-index: 1;}
.page-body{ margin: 0 auto !important;}
.project_number_title{ background: #09c;}
.project_number_info{ border: 1px solid #09c; border-radius: 0 5px 5px 0; color: #09c;}
.small_title_txt{ border-bottom:1px solid #adbec6 ;}

.shadow{ border: 1px solid #ddd;}
	.current_page{ width: 1010px; border-bottom: none;}
	.form_btn{ background: #fff;}
	.order_detail{ margin-bottom: 20px;}
	.table_td_border>tbody>tr>td{ border: 1px solid #ddd !important;}
.table_td_border>tbody>tr>td{}
</style>
</head>
<body class="iframe_body">
	<div class="current_page shadow">
	    <a href="<?php echo site_url('admin/b2/home')?>" class="main_page_link" target="main"><i></i>主页</a>
	    <span class="right_jiantou">&gt;</span>
	    <a href="<?php echo site_url('admin/b2/grab_custom_order/index')?>" target="main">定制抢单</a>
	    <span class="right_jiantou">&gt;</span>转询价单
	</div>
    <!--=================右侧内容区================= -->
    <div class="page-body shadow" id="bodyMsg">

        <!-- ===============我的位置============ -->
        

        <!-- ===============转询价单  start============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt">转询价单</h2>

            <form id="edit_form" method="post" action="#">
            <!-- ===============管家需求============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">管家需求</span>
                </div>
                <div class="project_number"><span class="project_number_title">编号:</span><span class="project_number_info"><?php echo $c_id?></span></div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">出发城市:</td>
                        <td width="320">
                        <?php $startplace_arr = explode('|',$grab_custom_data['startplace']);?>
                        <input type="text" id="startcity" name="startcity" class="form_input" value="<?php echo $startplace_arr[0]?>" placeholder="请选择出发城市"/>
                        <input type="hidden" id="startcityId" name="startcityId" value="<?php echo $startplace_arr[1]?>"/>
                        </td>
                        <td class="order_info_title">供应商:</td>
                        <td>
                        <select name="supplier_id" class="form_select">
                        	<option value="">请选择</option>
                            <?php foreach($supplier AS $item):?>
                                <?php if($grab_custom_data['supplier_id']==$item['id']):?>
                            <option value="<?php echo $item['id']?>" selected ><?php echo $item['company_name']?></option>
                                <?php else:?>
                            <option value="<?php echo $item['id']?>"><?php echo $item['company_name']?></option>
                               <?php endif;?>
                            <?php endforeach;?>
                        </select>
                        </td>
                   	</tr>
                    <tr>
                        <td class="order_info_title">目的地城市:</td>
                        <td colspan="3">
                            <div class="to_play_input">
			<div class="mudidi_input">
			<input type="text" id="destOne" name="destOne" value="<?php echo $grab_custom_data['custom_type']?>" data-val="<?php if($grab_custom_data['custom_type']=='国内游'){echo 2;}elseif($grab_custom_data['custom_type']=='出境游'){echo 1;}else{echo 'trip';}?>" readonly="" class="mudidi_one" placeholder="出境/周边/国内" autocomplete="off">
			<u class="pos_right"></u>
			</div>
            		            <ul class="input_list_hidden row_ree_one">

                                     </ul>
            			<div class="mudidi_input">
                                            <?php
                                            if($grab_custom_data['custom_type']!='周边游'){
                                               $endplace_two_arr = explode('|',$grab_custom_data['endplace_two']);
                                           }else{
                                               $endplace_two_arr = explode('|',$grab_custom_data['endplace_three']);
                                           }
                                            ?>
            			         <input type="text" id="destTwo" name="destTwo" value="<?php echo $endplace_two_arr[0];?>" readonly="" class="mudidi_two" placeholder="选择省份(二级目录)" autocomplete="off">
            			         <input type="hidden" id="destTwoId" name="destTwoId" value="<?php echo $endplace_two_arr[1];?>" autocomplete="off">
            			         <u class="pos_right"></u>
            			</div>
            			<ul class="input_list_hidden row_ree_two">							<!--这个是隐藏的input 要在一个和input 一样宽度的 盒子下面  这样 只要设定 100% 就可以 自动识别了   **1  -->
                                      </ul>
    			<div class="mudidi_input">
                                        <?php
                                        if(!empty($grab_custom_data['endplace_three'])){
                                             $endplace_three_arr = explode('|',$grab_custom_data['endplace_three']);
                                             $end_three_name_arr = explode(',',$endplace_three_arr[0]);
                                             $end_three_id_arr = explode(',',$endplace_three_arr[1]);
                                             $end_three_count = count($end_three_name_arr);
                                        }
                                        ?>
    			       <input type="text" id="expert_dest" name="expert_dest" class="mudidi_three" placeholder="选择市" autocomplete="off">
    			       <input type="hidden" id="expert_dest_id" name="expert_dest_id" value="<?php echo (isset($endplace_three_arr[1]) && $endplace_three_arr[1]!='') ? $endplace_three_arr[1].',' : '';?>" autocomplete="off">
    			</div>
            		</div>
                                <!-- 显示选择的目的地标签  -->

                                    <?php if(isset($end_three_id_arr) && !empty($end_three_id_arr) && $grab_custom_data['custom_type']!='周边游'):?>
                                         <div id="destButton" style="display:block;">
                                            <div class="selectedTitle">已选择:</div>
                                             <?php $k=0; foreach($end_three_id_arr AS $kl=>$v):?>
                                             <span class="selectedContent" value="<?php echo $v?>"><?php echo $end_three_name_arr[$k]?><span onclick="delPlugin(this ,'expert_dest_id' ,'destButton');" class="delPlugin">x</span></span>
                                             <?php $k++;endforeach;?>
                                        </div>
                                    <?php else:?>
                                        <div id="destButton">
                                        </div>
                                    <?php endif;?>

                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出游方式:</td>
                        <?php if($grab_custom_data['trip_way']=='自由行' || $grab_custom_data['trip_way']=='单项服务'):?>
                        <td colspan="1" id="travel_type">
                        	<div class="form_select">
                                <div class="search_select">
                                    <div class="show_select" status="1" style="width:270px;">
                                    <?php echo !empty($grab_custom_data['trip_way']) ? $grab_custom_data['trip_way'] : '请选择出游方式' ;?>
                                    </div>
                                    <ul class="select_list" id="travel_type_choice">
                                        <?php foreach($trip_way AS $item):?>
                                            <?php if(($item['description']=='自由行' || $item['description']=='单项服务')):?>
                                                        <li data-val="<?php echo $item['description']?>" class="right_select"><?php echo $item['description']?></li>
                                            <?php else:?>
                                                        <li data-val="<?php echo $item['description']?>"><?php echo $item['description']?></li>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </ul>
                                    <i></i>
                                </div>
                                <input type="hidden" name="trip_way" value="<?php echo $grab_custom_data['trip_way'];?>" class="select_value"/>
                            </div>
                        </td>
                        <td class="order_info_title more_service" style="display:table-cell;">多项服务:</td>
                        <td class="more_service" style="display:table-cell;">
                            <div class="form_select1">
                                <div class="search_select1">
                                    <div class="show_select1" status="1" style="width:270px;">
                                      <?php
                                        $choose_arr = explode(',',$grab_custom_data['another_choose']);
                                        $choose_count = count($choose_arr);
                                        if($choose_count>=1){
                                            echo "当前已选择<b class='click_num'>{$choose_count}</b>项";
                                        }else{
                                            echo '请选择出游方式';
                                        }
                                      ?>
                                      </div>
                                    <ul class="select_list1" id="more_service_choice">
                                      <?php foreach($choose AS $item):?>
                                            <?php if(in_array($item['description'],$choose_arr)):?>
                                                <li data-val="<?php echo $item['description']?>" class='select'><?php echo $item['description']?><i></i></li>
                                            <?php else:?>
                                                <li data-val="<?php echo $item['description']?>"><?php echo $item['description']?><i></i></li>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </ul>
                                    <i></i>
                                </div>
                                <input type="hidden" name="choose_one" value="<?php echo $grab_custom_data['another_choose'].',';?>" class="more_service_value"/>
                            </div>
                        </td>
                    <?php else:?>
                    <td colspan="3" id="travel_type">
                            <div class="form_select">
                                <div class="search_select">
                                    <div class="show_select" status="1" style="width:682px;"><?php echo !empty($grab_custom_data['trip_way']) ? $grab_custom_data['trip_way'] : '请选择出游方式' ;?></div>
                                    <ul class="select_list" id="travel_type_choice">
                                        <?php foreach($trip_way AS $item):?>
                                            <?php if(($item['description']=='自由行' || $item['description']=='单项服务')):?>
                                                        <li data-val="<?php echo $item['description']?>" class="right_select"><?php echo $item['description']?></li>
                                            <?php else:?>
                                                        <li data-val="<?php echo $item['description']?>"><?php echo $item['description']?></li>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </ul>
                                    <i></i>
                                </div>
                                <input type="hidden" name="trip_way" value="<?php echo $grab_custom_data['trip_way'];?>" class="select_value"/>
                            </div>
                        </td>
                        <td class="order_info_title more_service" style="display:none;">多项服务:</td>
                        <td class="more_service"  style="display:none;">
                            <div class="form_select1">
                                <div class="search_select1">
                                    <div class="show_select1" status="1" style="width:270px;">请选择出游方式</div>
                                    <ul class="select_list1" id="more_service_choice">
                                      <?php foreach($choose AS $item):?>
                                                <li data-val="<?php echo $item['description']?>"><?php echo $item['description']?><i></i></li>
                                        <?php endforeach;?>
                                    </ul>
                                    <i></i>
                                </div>
                                <input type="hidden" name="choose_one" value="" class="more_service_value"/>
                            </div>
                        </td>
                        <?php endif;?>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出行日期:</td>
                        <td colspan="3">
                        	<div class="data_describe">
                            <label data-val="1" onclick="click_this_type(this);"><input type="radio" name="travel_data"/>出行日期</label>
                            <label data-val="2" onclick="click_this_type(this);"><input type="radio" name="travel_data"/>文字描述</label>
                            </div>
                            <input type="text" data-val="1" id="datetimepicker" name="startdate" class="form_input" placeholder="YYYY-MM-DD" style="width:682px;" value="<?php echo $grab_custom_data['startdate']?>"/>
                        	  <input type="text" data-val="2" name="estimatedate" class="form_input" placeholder="只能手写输入" style="display:none;width:682px;" value="<?php echo $grab_custom_data['estimatedate']?>"/></td>

                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">人均预算:</td>
                        <td><input type="text" name="budget" class="form_input" placeholder="请输入您的预算(数字)" value="<?php echo $grab_custom_data['budget']?>"/>元/人</td>
                        <td class="order_info_title">出游时长:</td>
                        <td><input type="text" name="days" class="form_input" placeholder="" value="<?php echo $grab_custom_data['days']?>" />天</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">酒店要求:</td>
                        <td><select name="hotel_star" class="form_select">
                        	<option value="">请选择</option>
                            <?php foreach($hotel AS $item):?>
                                <?php if($grab_custom_data['hotelstar']==$item['description']):?>
                                <option value="<?php echo $item['description']?>" selected><?php echo $item['description']?></option>
                            <?php else:?>
                                <option value="<?php echo $item['description']?>"><?php echo $item['description']?></option>
                            <?php endif;?>
                            <?php endforeach;?>
                        </select></td>
                        <td class="order_info_title">用餐要求:</td>
                        <td>
                        <select name="catering" class="form_select">
                        	<option value="">请选择</option>
                                <?php foreach($catering AS $item):?>
                                <?php if($grab_custom_data['catering']==$item['description']):?>
                                <option value="<?php echo $item['description']?>" selected><?php echo $item['description']?></option>
                            <?php else:?>
                                <option value="<?php echo $item['description']?>"><?php echo $item['description']?></option>
                            <?php endif;?>
                            <?php endforeach;?>
                        </select>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">用房要求:</td>
                        <td><select name="room_require" class="form_select">
                        	<option value="">请选择</option>
                             <?php foreach($room AS $item):?>
                                <?php if($grab_custom_data['room_require']==$item['description']):?>
                                <option value="<?php echo $item['description']?>" selected><?php echo $item['description']?></option>
                            <?php else:?>
                                <option value="<?php echo $item['description']?>"><?php echo $item['description']?></option>
                            <?php endif;?>
                            <?php endforeach;?>
                        </select></td>
                        <td class="order_info_title">购物自费:</td>
                        <td><select name="shopping" class="form_select">
                        	<option value="">请选择</option>
                             <?php foreach($shopping AS $item):?>
                                  <?php if($grab_custom_data['isshopping']==$item['description']):?>
                                <option value="<?php echo $item['description']?>" selected><?php echo $item['description']?></option>
                            <?php else:?>
                                <option value="<?php echo $item['description']?>"><?php echo $item['description']?></option>
                            <?php endif;?>
                            <?php endforeach;?>
                        </select></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">详细需求表述:</td>
                        <td colspan="3"><textarea  name="service_range" class="form_textarea noresize"  placeholder="请安排多预留购物时间，行程安排不要太紧迫了..."><?php echo $grab_custom_data['service_range']?></textarea>
		</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">总人数:</td>
                        <td><input type="text" name="total_people" class="form_input" value="<?php echo $grab_custom_data['total_people']?>" style="width:107px;"/>人</td>
                        <td class="order_info_title">用房数:</td>
                        <td><input type="text" name="roomnum" class="form_input" value="<?php echo $grab_custom_data['roomnum']?>"/>间</td>
                    </tr>
                    <tr height="40">
                    	<td class="order_info_title">成员构成:</td>
                        <td colspan="3">
                        	成人&nbsp;<input type="text" name="people" class="form_input w_80"value="<?php echo $grab_custom_data['people']?>" />人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	儿童占床&nbsp;<input type="text" name="childnum" class="form_input w_80" value="<?php echo $grab_custom_data['childnum']?>"/>人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	儿童不占床&nbsp;<input type="text" name="childnobednum" class="form_input w_80" value="<?php echo $grab_custom_data['childnobednum']?>"/>人&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            老人&nbsp;<input type="text" name="oldman" class="form_input w_80" value="<?php echo $grab_custom_data['oldman']?>"/>人
                        </td>
                    </tr>
                </table>
            </div>

            <!-- ===============管家报价============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">管家报价</span>
                </div>
                <div class="expert_offer_price clear">
                	<div><span>成人价：</span><input type="text" name="price" class="" value="<?php echo $expert_baojia['price']?>"/>元/人</div>
                    <div><span style="width:80px;">儿童占床价：</span><input type="text" name="childprice" class="" value="<?php echo $expert_baojia['childprice']?>"/>元/人</div>
                    <div><span style="width:90px;">儿童不占床价：</span><input type="text" name="childnobedprice" class="" value="<?php echo $expert_baojia['childnobedprice']?>"/>元/人</div>
                    <div style="margin-right:0;"><span style="width:55px;">老人价：</span><input type="text" name="oldprice" class="" value="<?php echo $expert_baojia['oldprice']?>"/>元/人</div>
                </div>
                <div class="price_explain clear">
                	<div class="price_explain_title">方案推荐：</div>
                    <textarea name="price_description" placeholder="字数不限"><?php echo $expert_baojia['price_description']?></textarea>
                </div>
            </div>

            <!-- ===============详细行程============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">详细行程</span>
                </div>
                <div class="price_explain clear">
                	<div class="price_explain_title">总体描述：</div>
                    <textarea name="plan_design" placeholder="字数不限"><?php echo $expert_baojia['plan_design']?></textarea>
                </div>

                <div class="project_name clear">
                    <div class="price_explain_title">方案名称：</div>
                    <input type="text" placeholder="方案名称" class="travel_describe w_705" name="ca_title" value="<?php echo $expert_baojia['ca_title']?>" />
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
                                <?php else:?>
                                    <!-- *************************如果没有回复方案的时候**********************-->
                                          <div class="travel_arrange">
                                    <div class="travelDay">
                                      <span class="delete_day" style="display:none;" onclick="del_day(this)">×</span>
                                      <div class="form_group clear">
                                        <div class="dayNum travel_content_title">第<i>1</i>天</div>
                                        <div class="input_field">
                                             <div class="traffic_type">
                                                <div class="traffic_content" contenteditable="true"></div>
                                                <div class="title_text">出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div>
                                                <input type="hidden" name="travel_title[]" class="hidden_traffic" value=''/>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div  class="travel_content_title">城市间交通:</div>
                                        <div class="input_field"><input type="text" placeholder="交通方式" class="travel_describe w_705" name="traffic[]" value="" /></div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">用餐:</div>
                                        <div class="foot">
                                            <div>
                                            <label class="check_ico">
                                            <input type="checkbox" name="breakfirsthas[1]" value="1"/>
                                            <span class="text"><span><i></i></span>早餐</span>
                                            </label>
                                            <input type="text" placeholder="15字以内" name="breakfirst[1]" />
                                            </div>

                                            <div>
                                            <label class="check_ico">
                                            <input type="checkbox" name="lunchhas[1]" value="1"/>
                                            <span class="text"><span><i></i></span>午餐</span>
                                            </label>
                                            <input type="text" placeholder="15字以内" name="lunch[1]" />
                                            </div>

                                            <div style="margin-right:0;">
                                            <label class="check_ico">
                                            <input type="checkbox" name="supperhas[1]" value="1"/>
                                            <span class="text"><span><i></i></span>晚餐</span></label>
                                            <input type="text" placeholder="15字以内" name="supper[1]" />
                                            </div>

                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">住宿:</div>
                                        <div class="input_field"><input type="text" placeholder="请输入入住酒店" class="travel_describe w_705" name="hotel[]" /></div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title"><i class="important_title">*</i>行程安排:</div>
                                        <div class="input_field"><textarea class="text_describe noresize" name="travel_content[]"></textarea></div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">行程图片:</div>
                                        <div class="input_field">
                                            <input type="hidden" class='url_val' name="pics_url[]" value=""/>
                                        </div>
                                      </div>
                                      <div class="form_group clear">
                                        <div class="travel_content_title">&nbsp;</div>
                                        <div class="input_field">
                                        <span class="btn btn_blue" onclick="change_avatar(this);">上传图片</span>
                                        </div>
                                      </div>
                                    </div>
                                    <span class="btn btn_blue" data-val="2" onclick="add_travel(this)">+第<i>2</i>天</span>
                                </div>
                                <?php endif;?>
                                <!-- End 详细行程结束 -->
                    <div class="form_btn clear">
                                    <input type="hidden" id="submit_type" name="submit_type" value="" />
                                    <input type="hidden" id="expert_c_id" name="expert_c_id" value="<?php echo $expert_c_id;?>" />
                                    <input type="hidden"  name="customize_id" value="<?php echo $c_id;?>"/>
                                    <input type="hidden"  name="ca_id" value="<?php echo $ca_id;?>"/>
                                    <input type="hidden"  name="e_id" value="<?php echo $e_id;?>"/>
                                    <input type="submit"  name="keep_data" id="keep_data" value="保存" class="btn btn_green" onclick="submit_form(this)"/>
                                    <input type="submit" name="go_submit" id="go_submit" value="保存并发单" class="btn btn_green" onclick="submit_form(this)"/>
                                    <input type="button" name="reset" value="取消" class="btn btn_red" onclick="window.close()"/>
                    </div>
                </div>

            </div>
            </form>
        </div>
	</div>

<!--===============交通工具============== -->
<div id="route_div" style="position: absolute;background: #fff;border: 1px solid #DDDBDB;display: none;z-index: 1000;">
    <div class="route"><img alt="飞机" src='<?php echo base_url();?>/assets/img/icons/route/plain.gif'></div>
    <div class="route"><img alt="汽车" src='<?php echo base_url();?>/assets/img/icons/route/bus.gif'></div>
    <div class="route"><img alt="轮船" src='<?php echo base_url();?>/assets/img/icons/route/ship.gif'></div>
    <div class="route"><img alt="火车" src='<?php echo base_url();?>/assets/img/icons/route/train.gif'></div>
    <div style="display: inline-block;margin-left: 10px;padding: 0 5px;margin-top:7px;">点击图标，选择交通工具</div>
</div>

<!-- 美图秀秀 -->
<div id="img_upload">
    <div id="altContent"></div>
    <div class="close_xiu" onclick="close_xiuxiu();">×</div>
    <div class="avatar_box"></div>
</div>




<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script src="<?php echo base_url('assets/js/traffic_choose.js')?>"></script>
<script src="<?php echo base_url('assets/js/alertBox.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script type="text/javascript">
$('#datetimepicker').datetimepicker({
lang:'ch', //显示语言
timepicker:false, //是否显示小时
format:'Y-m-d', //选中显示的日期格式
formatDate:'Y-m-d',
validateOnBlur:false,
onSelectDate:validate_data
});
//作为日期选择之后的回调函数
function validate_data(choose_date){
var date_value = new Date(choose_date);
var date_str = date_value.getFullYear()+"-"+date_value.getMonth()+"-"+date_value.getDate();
var myDate = new Date();
myDate.setDate(myDate.getDate()+1);
var myDate_str = myDate.getFullYear()+"-"+myDate.getMonth()+"-"+myDate.getDate();
if((new Date(myDate_str))>(new Date(date_str))){
    alert('出行日期只能大于今天');
    $('#datetimepicker').val('');
    return false;
}
}


createChoicePluginPY({
data:{0:chioceStartCityJson['domestic']},
nameId:'startcity',
valId:'startcityId',
isHot:true,
hotName:'热门',
isCallback:true
});

//目的地
$.post("/line/line_custom/getDestData",{cityId:$("#startcityId").val()},function(data){
	var data = eval("("+data+")");
	var html = '';
	$.each(data.top ,function(k ,v) {
		html += "<li data-val='"+v.id+"'>"+v.name+"</li>";
	});
	//目的地第一层
	$(".row_ree_one").html(html);
            init_endplace(data); //初始化目的地,(转询价单)编辑的时候
	//绑定点击第一层目的地获取目的地地二层
	$(".row_ree_one").find("li").click(function(){
		var id = $(this).attr("data-val");
		var name = $(this).html();
		var html = '';
		if (name == '周边游') {
                                        if($("#startcityId").val()==0 || $("#startcityId").val()==''){
                                            alert('请先选择出发城市');
                                            return false;
                                        }
			$("#expert_dest").attr("disabled" ,"desabled");
			$.post("/line/line_custom/getRoundTrip",{cityId:$("#startcityId").val()},function(json) {
				var tripArr = eval("("+json+")");
				$.each(tripArr ,function(k ,v) {
					html += "<li data-val='"+v.id+"'>"+v.name+"</li>";
				});

				$(".row_ree_two").html(html);
				//点击第二层目的地获取地三层目的地
				$(".row_ree_two").find("li").click(function(){
					clickDestTwo(this ,data);
				})
			})
		} else {
			$("#expert_dest").removeAttr("disabled");
			$.each(data[id] ,function(k ,v) {
				html += "<li data-val='"+v.id+"'>"+v.name+"</li>";
			});
			$(".row_ree_two").html(html);
		}
		$(this).parent("ul").hide();
		$("input[name='destOne']").val(name);
		$("input[name='destTwo']").val('');
		$("input[name='destTwoId']").val(0);
		$("#pop_city_expert_dest,#suggest_city_expert_dest").remove(); //删除之前的第三级目的地选择插件
		$("#destButton").html('');
		$("#expert_dest_id").val('');
		$("#destButton").hide();
		//点击第二层目的地获取地三层目的地
		$(".row_ree_two").find("li").click(function(){
			clickDestTwo(this ,data);
		})
	});//绑定事件代码结束
})



function clickDestTwo(obj ,data) {
	$("#pop_city_expert_dest,#suggest_city_expert_dest").remove();//删除之前的第三级目的地选择插件
	$("#destButton").html('');
	$("#expert_dest_id").val('');
	$("#destButton").hide();
	var id = $(obj).attr("data-val");
	var name = $(obj).html();
	var html = '';
	if (typeof data[id] != 'undefined') {
		$.each(data[id] ,function(k ,v) {
			data[id][k]['name'] = v.name;
		})
		var pluginArr = {0:{name:$("input[name='destOne']").val(),two:{0:{name:name,three:data[id]}}}};
		createChoicePlugin({
			data:pluginArr,
			nameId:'expert_dest',
			valId:'expert_dest_id',
			width:500,
			number:5,
			buttonId:'destButton'
		});
	}
	//$(".row_ree_two").html(html);
	$(obj).parent("ul").hide();
	$("input[name='destTwo']").val(name);
	$("input[name='destTwoId']").val(id);
}

//转询价单的页面刚进来的时候保存数据
function init_endplace(data){
              //默认有数据的时候
            if($("#destOne").val()!=0 && $("#destOne").val()!=''){
                var dest_html='';
                if ($("#destOne").val() == '周边游') {
                        if($("#startcityId").val()==0 || $("#startcityId").val()==''){
                                            alert('请先选择出发城市');
                                            return false;
                        }
                     $("#expert_dest").attr("disabled" ,"desabled");
                    $.post("/line/line_custom/getRoundTrip",{cityId:$("#startcityId").val()},function(json) {
                        var tripArr = eval("("+json+")");
                        $.each(tripArr ,function(k ,v) {
                            dest_html += "<li data-val='"+v.id+"'>"+v.name+"</li>";
                        });

                     $(".row_ree_two").html(dest_html);
                //点击第二层目的地获取地三层目的地
                    $(".row_ree_two").find("li").click(function(){
                        clickDestTwo(this ,data);
                    })
              })
            } else {
                    var dest_type = $("#destOne").attr('data-val');
                    var dest_two_type = $("#destTwoId").val();
                    $("#expert_dest").removeAttr("disabled");
                    $.each(data[dest_type] ,function(k ,v) {
                        dest_html += "<li data-val='"+v.id+"'>"+v.name+"</li>";
                    });
                    $(".row_ree_two").html(dest_html);
                    $(".row_ree_two").find("li").click(function(){
                        clickDestTwo(this ,data);
                     });
                          if (typeof data[dest_two_type] != 'undefined') {
                                $.each(data[dest_two_type] ,function(k ,v) {
                                    data[dest_two_type][k]['name'] = v.name;
                                });
                                var pluginArr = {0:{name:$("input[name='destOne']").val(),two:{0:{name:$("#destTwo").val(),three:data[dest_two_type]}}}};
                                createChoicePlugin({
                                    data:pluginArr,
                                    nameId:'expert_dest',
                                    valId:'expert_dest_id',
                                    width:500,
                                    number:5,
                                    buttonId:'destButton'
                                });
                    }
                  }
            }   //if判断结束
}

var statu = true;
$("input[name='destTwo']").click(function(){
	if ($("input[name='destOne']").val().length ==0) {
		alert('请选择国内，出境，周边');
		$(this).parent().next().hide();
		return false;
	}else{
		if(statu){
			$(this).parent().next().slideDown("fast");
			statu = false;
		}else{
			$(this).parent().next().slideUp("fast");
			statu = true;
		}
	}

})
$("#expert_dest").click(function(){
	if ($(".row_ree_two").find("li").length == 0) {
		alert('请选择省份');
		return false;
	}
})

var foo = true;
$(".mudidi_one").click(function(){
	if(foo){
		$(this).parent().next().slideDown("fast");
		foo = false;
	}else{
		$(this).parent().next().slideUp("fast");
		foo = true;
	}
})
$("body").mouseup(function(e) {
	var _con = $('.mudidi_one');
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		$(".input_list_hidden").slideUp("fast");
		foo = true;
		statu = true;
	}
})

//出游方式选择
//$("#travel_type").nextAll().hide();
$("#travel_type_choice li").click(function(){
	$(".more_service_value").val('');
            $("#more_service_choice").siblings('.show_select1').html('请选择出游方式');
            $("#more_service_choice li").removeClass('select');
	if($(this).hasClass("right_select")){
		$("#travel_type").attr("colspan","1");
		$("#travel_type").nextAll().show();
		$(this).parent().siblings(".show_select").css("width","270px");
	}else{
		$("#travel_type").attr("colspan","3");
		$("#travel_type").nextAll().css("display","none");
		$(this).parent().siblings(".show_select").css("width","683px");

	}
});

//多项服务选择
var ss=true;
$(".show_select1").click(function(){
	var w1 = parseInt($(this).css("width"));
	var w2 = parseInt($(this).css("padding-left"));
	var w = w1+w2*2;
	$(this).siblings(".select_list1").css("width",w+2);
	if(ss){
		$(this).siblings("ul").slideDown("fast");
		ss=false;
	}else{
		$(this).siblings("ul").slideUp("fast");
		ss=true;
	}
});

$(document).mouseup(function(e) {
	var _con = $('.search_select1'); // 设置目标区域
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		$(".search_select1").find("ul").hide();
		ss=true;
	}
});


$("#more_service_choice li").click(function(){
	if($(this).hasClass("select")){
		$(this).removeClass("select");

		var len = $(this).parent().find(".select").length;
		$(".show_select1").html("当前已选择<b class='click_num'>"+len+"</b>项");
		if(len==0){
			$(".show_select1").html("请选择出游方式");
		}
		var value = $(this).parent().parent().siblings(".more_service_value").val();
		var val = $(this).attr("data-val");
		var v = value.replace(val+',','');
		$(this).parent().parent().siblings(".more_service_value").val(v);

	}else{

		$(this).addClass("select");
		var len = $(this).parent().find(".select").length;
		$(".show_select1").html("当前已选择<b class='click_num'>"+len+"</b>项");

		var value = $(this).parent().parent().siblings(".more_service_value").val();
		var val = $(this).attr("data-val");
		if(len==1){
			$(this).parent().parent().siblings(".more_service_value").val(val+',');
		}else{
			$(this).parent().parent().siblings(".more_service_value").val(value+val+",");
		}

	}
});

//出行日期方式
//
var startdate = '<?php echo $grab_custom_data['startdate']?>';

if(startdate!='' && startdate!=undefined && startdate!='0000-00-00'){
    $(".data_describe label").eq(0).click();
}else{
    $(".data_describe label").eq(1).click();
}
function click_this_type(obj){
	var status = $(obj).attr("data-val");
            if(status==1){
                $(obj).parent().parent().find("input[data-val=1]").show();
                $(obj).parent().parent().find("input[data-val=2]").hide();
                $(obj).parent().parent().find("input[data-val=2]").val('');
            }else{
                $(obj).parent().parent().find("input[data-val=2]").show();
                $(obj).parent().parent().find("input[data-val=1]").hide();
                $(obj).parent().parent().find("input[data-val=1]").val('');
            }


}




function submit_form(obj){
        var submit_name = $(obj).attr('name');
        if(submit_name=='keep_data'){
          $("#submit_type").val('1');
        }else{
         $("#submit_type").val('2');
        }
        return true;
}

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

  $('#edit_form').submit(function(){

      $("#keep_data").attr('disabled',true);
       $("#go_submit").attr('disabled',true);
      $.post(
        "<?php echo site_url('admin/b2/inquiry_sheet/edit_opera');?>",
        $('#edit_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.status == 200) {
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


function choice_this(obj){
    var index = $(obj).index();
    $(".table_list").hide();
    $(".table_list").eq(index).show();
    $(obj).siblings("li").removeClass("active");
    $(obj).addClass("active");
}


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
