<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查看询价单</title>
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
    .form_btn { padding-top:40px;padding-bottom:30px;}
    .form_btn span  { margin-left:400px;}

    .traffic_type { width:721px;}
    .travel_content_title { width:80px;}
    .w_705 { width:705px !important;}
    .table_content { padding: 0 0 20px 0;}
    .project_number { height:50px;line-height:40px;font-family:"微软雅黑";}
    .project_number_title { border-radius:5px 0 0 5px;background:#868686;color:#fff;height:20px;line-height:20px;padding:10px 15px;}
    .project_number_info { text-align:center;border:1px solid #d2d2d2;border-left:none;width:80px;padding:7px 10px;display:inline-block;height:20px;line-height:20px;color:#2dc3e8;}
    .supplier_reply_check .text { margin-top:0;}

    .price_explain_info { width:705px;height:auto;resize:none;padding:0;border:none;float:left;}
    .text_describe { padding:0;border:none;line-height:200%;height:auto;}
    .travel_describe { border:none !important;padding-left:0;}
    .traffic_type { border:none;}
    .traffic_content { padding-left:0;}
    
    .page-body{ margin: 0 auto !important;}
	.current_page{ height: 40px; line-height: 40px; }
    .iframe_body .page-body{ background: #fff; border: 1px solid #ddd;}
    .content_part,.form_btn,.order_detail{ margin-bottom: 0 }
    .current_page{ width: 1020px; margin: 0 auto; height: 40px; line-height: 40px; position: relative; z-index: 1;}
    .page-body{ margin: 0 auto !important;}
    .project_number_title{ background: #09c;}
    .project_number_info{ border: 1px solid #09c; border-radius: 0 5px 5px 0; color: #09c;}
    .small_title_txt{ border-bottom: 1px solid #adbec6 !important; margin: 20px 0;}
    .btn_green{ background: #09c !important;}
    .tab_content{ box-shadow: none; border: 1px solid #adbec6;}
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a{ box-shadow: none; border-left: 1px solid #adbec6;border-right: 1px solid #adbec6; position: relative; top: 1px ;}
    .price_explain_title{ color: #09c;}
    textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]{ border: 1px solid #adbec6 ;}
    .shadow{ border: 1px solid #ddd;}
	.current_page{ width: 1010px; border-bottom: none;}
	.form_btn{ background: #fff;}
	.order_detail{ margin-bottom: 20px;}
	.table_td_border>tbody>tr>td{ border: 1px solid #ddd !important;}
</style>
</head>
<body class="iframe_body">
<div class="bodyBody">
	<!-- ===============我的位置============ -->
    <div class="current_page shadow">
        <a href="<?php echo site_url('admin/b2/home')?>" class="main_page_link" target="main"><i></i>主页</a>
        <span class="right_jiantou">&gt;</span>
        <a href="<?php echo site_url('admin/b2/grab_custom_order/index')?>" target="main">定制抢单</a>
        <span class="right_jiantou">&gt;</span>查看询价单
    </div>
    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">

        <!-- ===============回复方案  start============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt">查看询价单</h2>

            <!--<form action="" method="post"> -->
            <!-- ===============管家需求============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">管家需求</span>
                </div>
                <div class="project_number"><span class="project_number_title">编号:</span><span class="project_number_info"><?php echo $c_id?></span></div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">出发城市:</td>
                        <td width="320"><?php echo explode('|',$grab_custom_data['startplace'])[0]?></td>
                        <td class="order_info_title">目的地城市:</td>
                        <td><?php echo explode('|',$grab_custom_data['endplace_three'])[0]?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出游方式:</td>
                        <td><?php if(!empty($grab_custom_data['another_choose']) && $grab_custom_data['trip_way']!=null){ echo $grab_custom_data['trip_way'].'/'.$grab_custom_data['another_choose'];}else{echo $grab_custom_data['trip_way'];}?></td>
                        <td class="order_info_title">定制类型:</td>
                        <td><?php echo $grab_custom_data['custom_type']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出行日期:</td>
                        <td><?php  echo (!empty($grab_custom_data['startdate']) && $grab_custom_data['startdate']!='0000-00-00') ? $grab_custom_data['startdate']:$grab_custom_data['estimatedate'];?></td>
                        <td class="order_info_title">供应商:</td>
                        <td><?php echo $grab_custom_data['s_name']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">人均预算:</td>
                        <td>￥<?php echo $grab_custom_data['budget']?>/人</td>
                        <td class="order_info_title">出游时长:</td>
                        <td colspan="3"><?php echo $grab_custom_data['days']?>&nbsp;&nbsp;人</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">酒店要求:</td>
                        <td><?php echo $grab_custom_data['hotelstar']?></td>
                        <td class="order_info_title">用餐要求:</td>
                        <td><?php echo $grab_custom_data['catering']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">用房要求:</td>
                        <td><?php echo $grab_custom_data['room_require']?></td>
                        <td class="order_info_title">购物自费:</td>
                        <td><?php echo $grab_custom_data['isshopping']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">详细需求表述:</td>
                        <td colspan="3">
                            <?php echo $grab_custom_data['service_range']?>
        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">总人数:</td>
                        <td><?php echo $grab_custom_data['total_people']?></td>
                        <td class="order_info_title">用房数:</td>
                        <td><?php echo $grab_custom_data['roomnum']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">成员构成:</td>
                        <td colspan="3">
                            成人&nbsp;<?php echo $grab_custom_data['people']?>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
                            儿童占床&nbsp;<?php echo $grab_custom_data['childnum']?>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
                            儿童不占床&nbsp;<?php echo $grab_custom_data['childnobednum']?>&nbsp;人&nbsp;&nbsp;&nbsp;&nbsp;
                            老人&nbsp;<?php echo $grab_custom_data['oldman']?>&nbsp;人&nbsp;&nbsp;
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
                    <div><span>成人价：</span>￥<?php echo $expert_baojia['price']?>元/人</div>
                    <div><span style="width:80px;">儿童占床价：</span>￥<?php echo $expert_baojia['childprice']?>元/人</div>
                    <div><span style="width:90px;">儿童不占床价：</span>￥<?php echo $expert_baojia['childnobedprice']?>元/人</div>
                    <div style="margin-right:0;"><span style="width:55px;">老人价：</span>￥<?php echo $expert_baojia['oldprice']?>元/人</div>
                </div>
                <div class="price_explain clear">
                    <div class="price_explain_title">方案推荐：</div>
                    <div class="price_explain_info"><?php echo $expert_baojia['price_description'];?></div>
                </div>
            </div>

            <!-- ===============详细行程============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">详细行程</span>
                </div>
                <div class="price_explain clear">
                    <div class="price_explain_title">总体描述：</div>
                    <div class="price_explain_info"><?php echo $expert_baojia['plan_design'];?></div>
                </div>

                <div class="project_name clear">
                    <div class="price_explain_title">方案名称：</div>
                    <input type="text" placeholder="方案名称" class="travel_describe w_705" disabled name="" value="<?php echo $expert_baojia['ca_title'];?>"/>
                </div>
                <div class="travel_content" id="rout_line">
                <!-- Start 详细行程开始-->
                    <?php if(!empty($custom_trip_data_list)):?>
                    <div class="travel_arrange">
                        <?php $i=1;foreach ($custom_trip_data_list as $item): ?>
                        <div class="travelDay">
                          <span class="delete_day" style="display:none;">×</span>
                          <div class="form_group clear">
                            <div class="dayNum travel_content_title">第<i><?php echo $item['cj_day'];?></i>天</div>
                            <div class="input_field">
                                 <div class="traffic_type">
                                    <div class="traffic_content" style='padding-left:0;'><?php echo $item['cj_title'];?></div>
                                </div>
                            </div>
                          </div>
                          <div class="form_group clear">
                            <div  class="travel_content_title">城市间交通:</div>
                            <div class="input_field"><input type="text" placeholder="交通方式" class="travel_describe w_705" disabled name="travel_describe" value="<?php echo $item['transport'];?>"/></div>
                          </div>
                          <div class="form_group clear">
                            <div class="travel_content_title">用餐:</div>
                            <div class="foot">
                                <div>早餐：<?php echo $item['breakfirst'];?></div>
                                <div>午餐：<?php echo $item['lunch'];?></div>
                                <div>晚餐：<?php echo $item['supper'];?></div>
                            </div>
                          </div>
                          <div class="form_group clear">
                            <div class="travel_content_title">住宿:</div>
                            <div class="input_field"><input type="text" placeholder="请输入入住酒店" class="travel_describe w_705" disabled name="hotel" value="<?php echo $item['hotel']?>"/></div>
                          </div>
                          <div class="form_group clear">
                            <div class="travel_content_title"><i class="important_title">*</i>行程安排:</div>
                            <div class="input_field"><div class="text_describe"><?php echo $item['cj_jieshao'];?></div></div>
                          </div>
                          <div class="form_group clear">
                            <div class="travel_content_title">行程图片:</div>

                            <div class="input_field">
                                         <?php if(isset($item['pic_arr'])&&count($item['pic_arr'])!=0):?>
                                         <?php foreach ($item['pic_arr'] as $val): ?>
                                      <div class="img_main">
                                             <img style="width:180px; height:160px;" src="<?php echo $val;?>"/>
                                      </div>
                                     <?php endforeach;?>
                                     <?php endif;?>
                            </div>
                          </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                    </div>
                    <div class="form_btn clear">
                        <span class="close_page btn btn_green" onclick="window.close()">关闭</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

