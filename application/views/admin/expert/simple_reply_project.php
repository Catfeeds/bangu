<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>回复方案</title>
 <link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">.
    #bodyMsg{ width: 1030px; margin: 0 auto;;}
	.expert_offer_price { margin-bottom:10px;margin-top:5px;}
	.expert_offer_price div { float:left;margin-right:26px;height:40px;line-height:40px;}
	.expert_offer_price div span { display:inline-block;width:90px;padding-right:5px;text-align:right;}
	.expert_offer_price div input { width:54px;padding:5px 8px;height:20px;line-height:20px;text-align:center;}
	.price_explain { margin-bottom:10px;}
	.price_explain_title { float:left;color:#6cf;width:90px;padding-right:5px;text-align:right;}
	.price_explain textarea { width:705px;height:100px;padding:5px 8px;resize:none;}
	.project_name {line-height:44px;margin-bottom:20px;}

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
	.form_group input, .form_group select, .form_group textarea, .form_group span { margin-left:0;}
	.supplier_reply_check .text { margin-top:0;}

	#project_list li { position:relative;}
	#project_list .delete_this_project { position: absolute; height: 28px; line-height: 28px; width: 18px; font-size: 20px; cursor: pointer; top: -10px; right: 0px; z-index: 100; color: #ccc; font-weight: 700;z-index:100;}
	#project_list .delete_this_project:hover { color:#f30;}
	.input_field span.btn { margin-top:10px;}
	.page-body{ margin: 0 auto !important;}
	.current_page{ height: 40px; line-height: 40px; }
    .iframe_body .page-body{ background: #fff;-webkit-box-shadow:0 0 10px #999; -moz-box-shadow:0 0 10px #999; box-shadow:0 0 10px #999;  }
    .content_part,.form_btn,.order_detail{ margin-bottom: 0 }
    .current_page{ width: 1020px; margin: 0 auto; height: 40px; line-height: 40px; position: relative; z-index: 1;}
    .page-body{ margin: 0 auto !important;}
    .project_number_title{ background: #056DAB;}
    .project_number_info{ border: 1px solid #056DAB; border-radius: 0 5px 5px 0; color: #056DAB;}
    .small_title_txt{ border-bottom: 1px solid #adbec6 !important; margin: 20px 0;}
    .btn_green{ background: #056DAB !important;}
    .tab_content{ box-shadow: none; border: 1px solid #adbec6;}
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a{ box-shadow: none; border-left: 1px solid #adbec6;border-right: 1px solid #adbec6; position: relative; top: 1px ;}
    .price_explain_title{ color: #056DAB;}
	.btn_blue, .btn_blue:focus{ background-color: #09c !important;}
    textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]{ border: 1px solid #bbb ;}
	.bodyBody { width:1000px;margin:0 auto;}
	
</style>
</head>
<body class="iframe_body">
<div class="current_page shadow">
    <a href="<?php echo site_url('admin/b2/home')?>" class="main_page_link" target="main"><i></i>主页</a>
    <span class="right_jiantou">&gt;</span>
    <a href="<?php echo site_url('admin/b2/grab_custom_order/index')?>" target="main">定制抢单</a>
    <span class="right_jiantou">&gt;</span>回复方案
</div>
<div class="bodyBody">
    <!--=================右侧内容区================= -->
    <div class="page-body shadow" id="bodyMsg">

        <!-- ===============我的位置============ -->

         <form id="reply_form" method="post" action="#">
            <div style="margin-top:30px">
            <textarea name="simple_aws" id="simple_aws" class="simple_aws"   placeholder="请输入100字以内简单回复" style="padding:5px;height:150px;width:100%;resize:none"></textarea>
            </div>
        <!-- ===============回复方案  start============ -->
        <div class="order_detail" style="margin-top:30px">

            <div id="form_content" style="display:none">
            <h2 class="lineName headline_txt">回复方案</h2>


            <!-- ===============客人需求============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">客人需求</span>
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
                        <td><?php echo $custom_info['custom_type']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出行日期:</td>
                        <td>
                        <?php  echo (!empty($custom_info['startdate']) && $custom_info['startdate']!='0000-00-00') ? $custom_info['startdate']:$custom_info['estimatedate'];?>
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
                    <span class="txt_info fl">管家报价</span>
                </div>
                <div class="expert_offer_price clear">
                	<div><span>成人价：</span><input type="text" name="people_price"  value="<?php echo $expert_baojia['price']?>"/>元/人</div>
                    <div><span style="width:80px;">儿童占床价：</span><input type="text" name="child_bed_price"  value="<?php echo $expert_baojia['childprice']?>"/>元/人</div>
                    <div><span style="width:90px;">儿童不占床价：</span><input type="text" name="child_no_bed_price" value="<?php echo $expert_baojia['childnobedprice']?>" />元/人</div>
                    <div style="margin-right:0;"><span style="width:55px;">老人价：</span><input type="text" name="old_people_price" value="<?php echo $expert_baojia['oldprice']?>"/>元/人</div>
                </div>
                <div class="price_explain clear">
                	<div class="price_explain_title">方案推荐：</div>
                    <textarea id="price_decription" name="price_decription" placeholder="字数不限"><?php echo $expert_baojia['price_description']?></textarea>
                </div>
            </div>

            <!-- ===============供应商回复============ -->
            <?php if(count($supplier_reply)>=1 && $supplier_reply[0]['eg_id']!=''):?>
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">供应商回复</span>
          </div>
                <table class="table table-bordered table_hover">
                    <span class="txt_info fl" style="color:red">(请选择:可多项选择供应商方案作为定制单回复方案给用户查看并选择。)</span>
                        </br>
                    <span class="txt_info fl" style="color:red">(方案:只能单项选择供应商方案作为询价单的使用方案。)</span>
                    <thead class="border">
                        <tr>
                            <th width="50">请选择</th>
                            <th>方案名称</th>
                            <th width="50">成人价</th>
                            <th width="50">老人价</th>
                            <th width="80">儿童占床价</th>
                            <th width="90">儿童不占床价</th>
                            <th>品牌名称</th>
                            <th width="60">联系人</th>
                            <th width="80">联系人电话</th>
                            <th width="60">负责人</th>
                            <th width="80">负责人电话</th>
                            <th width="80">方案</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $isuse_arr = array_map(function($element){return $element['isuse'];},$supplier_reply);
                        foreach($supplier_reply AS $item):?>
                    	<tr>
                        	   <td>
                                <label class="supplier_reply_check check_ico">
                                <input type="checkbox" name="supplier_reply" value="<?php echo $item['eg_id']?>"/>
                                <?php if(in_array($item['eg_id'],$choose_reply_id)):?>
                                   <span class="text checked" project_id="<?php echo $item['eg_id']?>" data-val="<?php echo $item['eg_title']?>">
                               <?php else:?>
                                   <span class="text" project_id="<?php echo $item['eg_id']?>" data-val="<?php echo $item['eg_title']?>">
                              <?php endif;?>
                                <span><i></i></span>
                                </span>
                                </label>
                            </td>
                            <td><?php echo $item['eg_title']?></td>
                            <td><?php echo $item['price']?></td>
                            <td><?php echo $item['oldprice']?></td>
                            <td><?php echo $item['childprice']?></td>
                            <td><?php echo $item['childnobedprice']?></td>
                            <td><?php echo $item['brand']?></td>
                            <td><?php echo $item['linkman']?></td>
                            <td><?php echo $item['link_mobile']?></td>
                            <td><?php echo $item['realname']?></td>
                            <td><?php echo $item['mobile']?></td>
                            <td>
                            <?php if(in_array(1,$isuse_arr)):?>
                                        <?php if($item['isuse']==1):?>
                                                 <span style="color:blue">已中标</span>
                                         <?php else:?>
                                                 <span style="color:red">未中标</span>
                                        <?php endif;?>
                            <?php else:?>
                                        <input type="radio" name="choose_supplier_plan" value="<?php echo $item['eg_id']?>" tag="0"/>
                            <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
            	</table>
            </div>
        <?php endif;?>

            <!-- ===============详细行程============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">详细行程</span>
                </div>
                <div class="price_explain clear">
                	<div class="price_explain_title">总体描述：</div>
                    <textarea name="travel_description" placeholder="字数不限"><?php echo $expert_baojia['plan_design']?></textarea>
                </div>
                <div class="table_content">
                    <ul class="tab_nav nav nav-tabs tab_shadow clear" id="project_list">
                        <li class="active" onclick='choice_this(this);'><a href="###">方案<i>1</i></a></li>
                        <?php if(!empty($choose_reply_id)):?>
                        <?php $k=2; foreach($choose_reply_id AS $vl):?>
                        <li project_id="<?php echo $vl?>" onclick="choice_this(this);"><a href="###">方案<i><?php echo $k?></i></a><span onclick="delete_tab(this)" class="delete_this_project">×</span></li>
                    <?php $k++; endforeach;?>
                    <?php endif;?>
                    </ul>
                    <div class="tab_content">
                        <div class="table_list">
                        	<div class="project_name clear">
                                    <div class="important_title" style="font-size:12px">*请填写方案名称,这样您的方案才会展示在用户定制方案列表中。</div>
                                    <div class="price_explain_title"><i class="important_title">*</i>方案名称：</div>
                                    <input type="text" placeholder="方案名称" class="travel_describe w_705" name="plan_name" value="<?php echo $expert_baojia['ca_title']?>"/>
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

                            </div>
                        </div>
                        <?php if(!empty($supplier_reply_arr)):?>
                            <?php foreach($supplier_reply_arr AS $k=>$val):?>
                            <div class="table_list" project_id="<?php echo $val['eg_id']?>">
                                    <div class='project_name clear'>
                                    <div class='price_explain_title'>方案名称：</div>
                                    <input type='text' placeholder='方案名称' class='travel_describe w_705' name=''disabled value='<?php  echo $k?>' style='border:none;padding-left:0;'>
                                    </div>
                                    <div class='travel_content'>
                                    <div class='travel_arrange'>
                                    <div class='travelDay'>
                                    <div class='form_group clear'>
                                    <div class='dayNum travel_content_title'>第<i><?php echo $val['day']?></i>天</div>
                                    <div class='input_field'>
                                    <div class='traffic_type' style='border:none;'>
                                    <div class='traffic_content' contenteditable='true' style='padding-left:0;'><?php echo $val['title']?></div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class='form_group clear'>
                                    <div class='travel_content_title'>城市间交通:</div>
                                    <div class='input_field'>
                                    <input type='text' placeholder='交通方式' class='travel_describe w_705' name='travel_describe' disabled value='<?php echo $val['transport']?>' style='border:none;padding-left:0;'/>
                                    </div>
                                    </div>
                                    <div class='form_group clear'>
                                    <div class='travel_content_title'>用餐:</div>
                                    <div class='foot'>
                                    <div>早餐：<?php echo $val['breakfirst']?></div>
                                    <div>午餐：<?php echo $val['lunch']?></div>
                                    <div>晚餐：<?php echo $val['supper']?>
                                    </div>
                                    </div>
                                    </div>
                                    <div class='form_group clear'>
                                    <div class='travel_content_title'>住宿:</div>
                                    <div class='input_field'>
                                    <input type='text' placeholder='请输入入住酒店' class='travel_describe w_705' disabled name='hotel' value='<?php echo $val['hotel']?>' style='border:none;padding-left:0;'/>
                                    </div>
                                    </div>
                                    <div class='form_group clear'>
                                    <div class='travel_content_title'>
                                    <i class='important_title'>*</i>行程安排:
                                    </div>
                                    <div class='input_field'>
                                    <div class='text_describe' style='padding: 0;border: none;line-height: 200%;height: auto;'>
                                    <?php echo $val['jieshao']?>
                                    </div>
                                    </div>
                                    </div>
                                    <div class='form_group clear' style='height:auto;'>
                                    <div class='travel_content_title'>行程图片:</div>
                                    <div class='input_field'>
                                    <?php if(!empty($val['pic_arr'])):?>
                                            <?php foreach($val['pic_arr'] AS $vl):?>
                                              <div class='img_main'><img style='width:180px; height:160px;' src='<?php echo $vl;?>' ></div>";
                                          <?php endforeach;?>
                                    <?php endif;?>
                                         </div>
                                         </div>
                            </div>
                            </div>
                            </div>
                            </div>
                        <?php endforeach;?>
                        <?php endif;?>

                    </div>
                </div>
            </div>
            </div>
            <div class="form_btn clear">
                        <input type="hidden" id="submit_type" name="submit_type" value="" />
                        <input type="hidden"  id="supply_id" name="supply_id" value="<?php echo implode(',',$choose_reply_id)?>"/>
                       <input type="hidden"  name="customize_id" value="<?php echo $c_id;?>"/>
                        <input type="hidden"  name="ca_id" value="<?php echo $ca_id;?>"/>
                        <input type="hidden" name="max_day" value="<?php echo $max_day?>" />
                        <input type="hidden" name="linkphone" value="<?php echo $custom_info['linkphone']?>"/>
                        <input type="hidden" name="is_simple" id="is_simple" value="1"/>
                        <input type="submit"  name="keep_data" id="keep_data" value="暂存" style="display:none" class="btn btn_green" onclick="submit_form(this)"/>
                        <input type="button"  data-status="1" value="添加方案(可选)" class="btn btn_red" onclick="operator_project(this)"/>
                         <input type="submit" name="go_submit" id="go_submit" value="提交方案" class="btn btn_green" onclick="submit_form(this)"/>

             </div>
            </form>
        </div>
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
jQuery(".supplier_reply_check .text").click(function(){
	var _this = $(this);
	var supply_id = $(this).attr("project_id");//供应商回复方案的ID
            var reply_title = $(this).attr("data-val"); //供应商回复方案的标题
	if (_this.hasClass("checked")) {
		$("#project_list li[project_id='"+supply_id+"']").remove();
		$(".table_list[project_id='"+supply_id+"']").remove();
		$("#project_list li").each(function(i){
			$(this).find("i").text(i+1);
		});
            $("#project_list li").click();
	}else {

                        $.post("<?php echo base_url('admin/b2/grab_custom_order/ajax_get_supplier_reply')?>",{eg_id:supply_id},
                          function(data){
                            data = eval('('+data+')');
                            result = data.msg;
                            var length = $("#project_list li").length;

                            var li = "<li project_id='"+supply_id+"' onclick='choice_this(this);'><a href='###'>"+reply_title+"</a><span onclick='delete_tab(this)' class='delete_this_project'>×</span></li>"
                             $("#project_list").append(li);
                                 var html = "<div class='table_list' project_id='"+supply_id+"'>";
                                        html += "<div class='project_name clear'><div class='price_explain_title'>方案名称：</div><input type='text' placeholder='方案名称' class='travel_describe w_705' name=''disabled value='"+reply_title+"' style='border:none;padding-left:0;'></div>";
                                        html += "<div class='travel_content'><div class='travel_arrange'>";
                                        if(result!=null && result!='' && result!=undefined){
                                            $.each(result ,function(key ,val){
                                            html += "<div class='travelDay'><div class='form_group clear'><div class='dayNum travel_content_title'>第<i>"+val['day']+"</i>天</div>";
                                        html += "<div class='input_field'><div class='traffic_type' style='border:none;'><div class='traffic_content' contenteditable='true' style='padding-left:0;'>"+val['title']+"</div>";
                                        html += "</div></div></div>";
                                        html += "<div class='form_group clear'><div class='travel_content_title'>城市间交通:</div><div class='input_field'><input type='text' placeholder='交通方式' class='travel_describe w_705' name='travel_describe' disabled value='"+val['transport']+"' style='border:none;padding-left:0;'/></div></div>";
                                        html += "<div class='form_group clear'><div class='travel_content_title'>用餐:</div><div class='foot'>";
                                        html += "<div>早餐："+val['breakfirst']+"</div>";
                                        html += "<div>午餐："+val['lunch']+"</div>";
                                        html += "<div>晚餐："+val['supper']+"</div></div></div>";
                                        html += "<div class='form_group clear'><div class='travel_content_title'>住宿:</div><div class='input_field'><input type='text' placeholder='请输入入住酒店' class='travel_describe w_705' disabled name='hotel' value='"+val['hotel']+"' style='border:none;padding-left:0;'/></div></div>";
                                        html += "<div class='form_group clear'><div class='travel_content_title'><i class='important_title'>*</i>行程安排:</div><div class='input_field'><div class='text_describe' style='padding: 0;border: none;line-height: 200%;height: auto;'>"+val['jieshao']+"</div></div></div>";
                                        html += "<div class='form_group clear' style='height:auto;'><div class='travel_content_title'>行程图片:</div><div class='input_field'>";
                                        if(val['pic_arr']!='' && val['pic_arr'].length>=1){
                                            $.each(val['pic_arr'],function(k,vl){
                                             html += "<div class='img_main'><img style='width:180px; height:160px;' src='"+vl+"' ></div>";
                                        });
                                        }

                                        html += "</div></div></div>";
                                         });
                                        }

                                        html += "</div></div></div>";
                                         $(".tab_content").append(html);
                                        $("#supply_id").val($("#supply_id").val()+supply_id+',');
                          });
		//此处ajax请求数据
		             /*$(".delete_this_project").click(function(){

		            });*/
	}
});

//控制单选按钮可以选择不选
$("input[name='choose_supplier_plan']").click(function(){
    if($(this).attr("tag")==1){
        $(this).attr("checked",false);
        $(this).attr("tag",0);
    }else{
        $(this).attr("tag",1);
    }
});

function delete_tab(obj){
                var supply_id =  $(obj).parent().attr("project_id");
                 $(".supplier_reply_check .text[project_id='"+supply_id+"']").removeClass("checked");
                 $(".table_list[project_id='"+supply_id+"']").remove();
                 $(obj).parent().remove();
                 $("#project_list li").each(function(i){
                   $(this).find("i").text(i+1);
                 });
                  //删除已经拼接好的供应商回复方案的ID
                   var s_ids = $("#supply_id").val();
                   var id_array = s_ids.split(',');
                  //删除对应的回复的ID
                  id_array.splice(id_array.indexOf(supply_id),1);
                  var final_id_str = id_array.join(',');
                  $("#supply_id").val(final_id_str);
                  $("#project_list li").click();
}

function submit_form(obj){
        var submit_name = $(obj).attr('name');
        if(submit_name=='keep_data'){
          $("#submit_type").val('0');
        }else{
         $("#submit_type").val('1');
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

  $('#reply_form').submit(function(){

      $("#keep_data").attr('disabled',true);
       $("#go_submit").attr('disabled',true);
      $.post(
        "<?php echo site_url('admin/b2/grab_custom_order/grab_simple_reply');?>",
        $('#reply_form').serialize(),
        function(data) {
          data = eval('('+data+')');
          if (data.status == 1) {
            alert(data.msg);
            window.opener.location="<?php echo base_url()?>admin/b2/grab_custom_order/index?tab=1";
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

//选择当前方案
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

//添加/取消方案
function operator_project(obj){
    var status = $(obj).attr('data-status');
    if(status==1){
        $("#form_content").show();
        $("#keep_data").show();
        $(obj).attr('data-status','2');
        $("#is_simple").val('2');
        $(obj).val('取消方案');
    }else{
        $("#form_content").hide();
        $("#keep_data").hide();
        $(obj).attr('data-status','1');
        $("#is_simple").val('1');
        $(obj).val('添加方案');
    }
}
</script>
</body>
</html>
