<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单详情</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<link href="/assets/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>

<style type="text/css">
	body:before { background:#fff;}
	.page-content { margin-left:0;}
	.order_detail { padding-bottom:40px;}
	.table_list { display:none;} 
	.table_list button { padding:3px 10px;margin-bottom:15px;}
	.txt_info { color:#000;font-weight:700 !important;}
	.tongguo i { display:inline-block;width:16px;height:16px;vertical-align:middle;background:url(/assets/ht/img/tongguo.gif) center center no-repeat;}
	.shenhe td:first-child { position:relative;}
	.shenhe i { display:inline-block;width:16px;height:16px;vertical-align:middle;background:url(/assets/ht/img/shenhe.gif) center center no-repeat;}
	.jujue i { display:inline-block;width:16px;height:16px;vertical-align:middle;background:url(/assets/ht/img/jujue.jpg) center center no-repeat;}
	.jujue td { color:#BCBCBC !important;}
	.table_hover>tbody>tr.add_fee:hover{ background-color:#fff!important}
	.jkxx .table_hover>tbody>tr:hover{ background-color:#fff!important}
	.table thead>tr>th { padding:5px 0;}
	.add_fee td { position:relative;padding:4px 8px !important;}
	.add_fee select,.add_fee input { width:80%;height:20px;}
	.other_obj { display:none;}
	.add_fee .save { display:inline-block;width:50px;text-align:center;box-sizing:border-box;background:url(/assets/ht/img/dui.png) 0px center no-repeat;color:#000;cursor:pointer;}
	.add_fee .cancle { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;background:url(/assets/ht/img/cuo.png) 0px center no-repeat;color:#000;cursor:pointer;}
	.zongji span { padding-right:200px;font-weight: 700;}
	
	.txt_info { line-height:28px;padding-left:0 !important;}
	.apple_tuiding { padding:0px 5px;margin-left:20px;position:relative;top:-3px;}
	input[type="checkbox"] { position:relative;opacity:1;left:0;width:auto;height:auto;}
	.layui-layer-page { margin-left:0 !important;}
	.title_txt { float:right;width:14%;display:inline-block;}
	.title_txt p { color:#f00;}

             /*行程安排*/
            .trip_info{position: absolute;top: 50px;left: 20%;z-index: 10000;background: #fff;width: 60%;padding: 10px 10px 20px 30px;display:none;margin-bottom:50px;}  
            .trip_day_title {padding:10px;clear: both;} 
            .trip_content_left,.trip_content_right{float:left;}     
            .trip_content_left{width:10%;}
            .trip_content_right{width:90%;}
            .trip_close{display: block;float: right;top: -20px;margin-top: -50px;font-weight: 600;cursor: pointer;}
         .order_info_table tr td.order_info_title{width: 100px;}
</style>
</head>
<body>
    <!--=================右侧内容区================= -->
    <div class="page-body w_1200" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">您的位置：
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">订单信息</a>
        </div>
        
        <!-- ===============订单详情============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt"><?php if(!empty($order_detail_info)){ echo  $order_detail_info['line_name']; }?></h2>
            
            <!-- ===============基础信息============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                    <span class="order_time fr"><?php if(!empty($order_detail_info)){ echo  $order_detail_info['addtime']; }?></span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">团号:</td>
                        <td colspan="3"><?php if(!empty($order_detail_info)){ echo  $order_detail_info['item_code']; }?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="3"><?php if(!empty($order_detail_info)){ echo  $order_detail_info['line_name']; }?><a href="#" class="see_trip" line_id="<?php echo $order_detail_info['lineid']?>" >【查看行程】</a></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单编号:</td>
                        <td><?php if(!empty($order_detail_info)){ echo  $order_detail_info['line_sn']; }?></td>
                        <td class="order_info_title">出发日期:</td>
                        <td><?php if(!empty($order_detail_info)){ echo  $order_detail_info['usedate']; }?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单状态:</td>
                        <td><?php if(!empty($order_detail_info)){ echo  $order_detail_info['status']; }?></td>
                        <td class="order_info_title">支付状态:</td>
                        <td>
                            <?php if(!empty($order_detail_info)){
                                     if($order_detail_info['ispay']==0){
                                                echo '待确认';
                                     }elseif($order_detail_info['ispay']==1){
                                                echo '待确认';
                                     }elseif($order_detail_info['ispay']==2){
                                                echo '已付款';
                                     }elseif($order_detail_info['ispay']==3){
                                                echo '退订中';
                                     }elseif($order_detail_info['ispay']==4){
                                                echo '已退订';
                                     }else if($order_detail_info['ispay']==5){
                                                 echo '未交款';
                                     }else if($order_detail_info['ispay']==6){
                                                 echo '已交款';
                                     }
                                 }  ?>
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">参团人数:</td>
                        <td style="width:45%;" >
                                <?php if($order_detail_info['unit']>=2):?>
                                       <span><?php echo $order_detail_info['suitnum'].'份/'.$order_detail_info['unit'].'人套餐'.'('.$order_detail_info['suitname'].')'; ?></span>
                                 <?php else:?>
                                        <span>成人:&nbsp;(<?php if(!empty($order_detail_info['dingnum'])){ echo $order_detail_info['dingnum']; }else{ echo 0;}?>人)</span>&nbsp;&nbsp;
                                        <span> 小童占床:&nbsp;(<?php if(!empty($order_detail_info['children'])){echo $order_detail_info['children'];}else{ echo 0;}?>人)</span>&nbsp;&nbsp;
                                        <span>小童不占床:&nbsp;(<?php if(!empty($order_detail_info['childnobednum'])){echo $order_detail_info['childnobednum'];}else{ echo 0;}?>)人</span>&nbsp;&nbsp;
                                <?php endif;?>
                        </td>
     
                    </tr>
                    
                    
                    <tr height="40">
                        <td class="order_info_title">平台佣金:</td>
                        <td colspan="3" >￥<?php echo $order_detail_info['platform_fee'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">管家:</td>
                        <td><?php if(!empty($order_detail_info)){ echo $order_detail_info['expert_name'].'/'.$order_detail_info['expert_mobile'];}   ?></td>
                        <td class="order_info_title">供应商:</td>
                        <td><?php if(!empty($order_detail_info)){ echo $order_detail_info['company_name'];}?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">预定人:</td>
                        <td><?php if(!empty($order_detail_info)){  echo $order_detail_info['linkman']; }?></td>
                        <td class="order_info_title">手机号:</td>
                        <td><?php if(!empty($order_detail_info)){  echo $order_detail_info['linkmobile']; }?></td>
                    </tr>
                      <tr height="40">
                        <td class="order_info_title">备用手机:</td>
                        <td><?php if(!empty($affil)){  echo $affil['spare_mobile']; }?></td>
                        <td class="order_info_title">备注:</td>
                        <td><?php if(!empty($affil)){  echo $affil['remark']; }?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">邮箱:</td>
                        <td colspan="3"><?php if(!empty($order_detail_info)){  echo $order_detail_info['link_email']; }?></td>
                    </tr>
                    <tr height="40">
                         <td class="order_info_title">已收款:</td>
                         <td  >￥<?php 
                               if($order_detail_info['user_type']==1){
                                     if(!empty($order_detail_info['total_receive_amount'] )){ echo $order_detail_info['total_receive_amount'] ;}else{echo 0;}
                               }else{
                                        if($order_detail_info['user_type']==0){
                                            echo $order_detail_info['total_price']+$order_detail_info['settlement_price'] ;
                                        }
                               }      
                               ?>
                         </td>
                         <td class="order_info_title">保险费用:</td>
                         <td >￥<?php if(!empty($order_detail_info)){ echo $order_detail_info['settlement_price'];}else{ echo 0;}?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">积分抵扣现金:</td>
                        <td>￥<?php if(!empty($order_detail_info['jifenprice'])){ echo $order_detail_info['jifenprice'];}else{ echo 0;}?></td>
                        <td class="order_info_title">优惠券抵扣现金:</td>
                        <td>￥<?php if(!empty($order_detail_info['couponprice'])){ echo $order_detail_info['couponprice'];}else{ echo 0;}?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">应付供应商:</td>
                        <td>
                        <?php if(!empty($order_detail_info)){ echo $order_detail_info['supplier_cost'];} ?>-
                        <?php if(!empty($order_detail_info)){ echo $order_detail_info['platform_fee'];} ?>(平台佣金)=
                          <?php if(!empty($order_detail_info)){ echo ($order_detail_info['supplier_cost']-$order_detail_info['platform_fee']); }?>元
                          <a href="/admin/b1/b_account/account_list/show_item_order?id=<?php if(!empty($order_detail_info)){ echo $order_detail_info['id'];} ?>" target="_blank" >
                          <button class="btn btn_green" style="margin-left:0;margin: 3px 0px;padding: 3px 10px;" >
                          申请预付款
                          </button></a>
                        </td>
                        <td class="order_info_title">已付供应商:</td>
                        <td><?php if(!empty($order_detail_info)){ echo $order_detail_info['balance_money'];}else{ echo 0;}?></td>
                    </tr>
                </table>
            </div>

            <div class="table_con">
                <div class="itab">
                    <ul> 
                        <li status="1"><a href="###" class="active">成本账单</a></li> 
                        <li status="2"><a href="###">参团名单</a></li> 
                        <li status="3"><a href="###">平台管理费</a></li> 
                       <!--   <li status="4"><a href="###">交款</a></li>  -->
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list" style="display:block;">
                    	<div class="small_title_txt clear" style="border-bottom:0;padding-left:0;margin-top:10px;">
                    <?php if($order_detail_info['status']!='已取消' ){
                           //   if($order_detail_info['balance_status']!=2){
                      ?>
                    	<button class="btn btn_green" onclick="add_fee(this);" style="margin-left:0;margin-bottom: 5px;" >新增费用</button>
                      <?php }?>
                        <span style="color:#ff0000">审核后计入总计</span>
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th style="width:5%">状态</th>
                                    <th style="width:15%">项目</th>
                                    <th style="width:20%">备注</th>
                                    <th style="width:10%">单价</th>
                                    <th  style="width:5%">数量</th>
                                    <th style="width:10%">小计</th>
                                    <th style="width:10%">录入人</th>
                                    <th style="width:10%">操作</th>
                                     <th style="width:15%">录入时间</th> 
                                </tr>
                            </thead>
                            <tbody class="yskr">
                                 <?php  if(!empty($bill_yf['data'])){
                                    foreach ($bill_yf['data'] as $key => $value) {                            
                                    
                                        $look='';
                                        if($value['status']==2){
                                              $cal='tongguo';
                                        }elseif ($value['status']==3 ||$value['status']==4 ) {
                                              $cal='jujue';
                                        }else{
                                              $cal='shenhe';
                                             //  $look='onclick="show_order_yf('.$value['id'].')"' ;
                                        }
                                 ?>
                                   <tr class="<?php echo $cal;?>">
                                           <td <?php // echo $look; ?> ><i></i></td>
                                           <td><?php echo  $value['item'];?></td>
                                           <td><?php echo  $value['remark'];?></td>
                                           <td><?php echo  $value['price'];?></td>
                                           <td><?php echo  $value['num'];?></td>
                                           <td><?php echo  $value['amount'];?></td> 
                                          
                                           <td><?php  if(!empty($value['user_id'])){ echo '<a href="##" onclick="show_user('.$value['user_id'].','.$value['user_type'].')">'.$value['user_name'].'<a>';}else{ echo '系统';}?></td> 
                                           <td>
                                           <?php if($value['status']==2){ //---已通过---?>

                                                   <span>已通过</span>  

                                           <?php  }else if($value['user_type']==1 && ($value['status']==1 or ($value['status']==0 and $value['kind']==3))){ //-----申请中---?>

                                                <?php if($value['kind']==2){  //退团退人?>
                                                    <a href="##" onclick="p_item_order(<?php echo $value['id'];?>,<?php echo $value['kind'];?>)">确认退团</a>            
                                                <?php }else{  //修改成本 ?>    
                                                    <a href="##" onclick="pass_tuituan_order(<?php echo $value['id'];?>,<?php echo $value['kind'];?>)">确认</a>
                                                <?php }  ?>

                                                &nbsp;&nbsp;

                                                <?php if($value['kind']!=2){?> 
                                                     <?php if($value['kind']==4){ ?>
                                                         <!--退团改价(不退人)-->
                                                         <a href="##" onclick="re_bill_order(<?php echo $value['id'];?>,-<?php echo $value['kind'];?>)">拒绝</a> 
                                                     <?php  }else{ ?>
                                                         <a href="##" onclick="re_tuituan_order(<?php echo $value['id'];?>,-<?php echo $value['kind'];?>)">拒绝</a>  
                                                     <?php } ?> 
                                                <?php } ?>    

                                           <?php   }else if($value['status']==4 || $value['status']==3){  //----拒绝-------?>

                                                  <span>已拒绝</span>    

                                            <?php  } else{   //供应商发起的申请中 ?>

                                                  <span>
                                                        <?php if($value['status']==0 && $value['user_type']==2){  ?>
                                                                待销售审核<a href='javascript:void(0)' onclick="dis_order_yf(<?php  echo $value['id'];?>)">(撤销)</a>
                                                        <?php }else if($value['kind']==2 && $value['status']==0){ ?>
                                                                等待销售经理审核     
                                                        <?php }else if($value['kind']==4 && $value['status']==0){?>
                                                                等待销售经理审核  
                                                        <?php  }else{ ?>
                                                                待销售审核
                                                        <?php  } ?>
                                                  </span>

                                           <?php } ?>
                                           </td>
                                            <td><?php echo  date("Y-m-d H:s",strtotime($value['addtime'])) ;?></td> 
                                   </tr>
                                 <?php } }  ?>
                                <tr class="zongji zongji1"><td colspan="9" style="text-align:right;"><span>总计：<i><?php  if(!empty($bill_yf['count_money'])){ echo $bill_yf['count_money']; }else{ echo 0;} ?></i>元 </span></td></tr>
                            </tbody>
                        </table>
     
                    </div>
                    <div class="table_list">
                        <div class="small_title_txt clear" style="border-bottom:0;padding-left:0;margin-top:10px;">
                          <?php if($order_detail_info['status']!='已取消'){
                                      //if($order_detail_info['balance_status']!='2'){
                            ?>
                            <button class="btn btn_green"  data-val="<?php if(!empty($order_id)){ echo $order_id;}?>"  onclick="drive_member(this);" style="margin-left:0;margin-bottom:0;">导出名单</button>
                                 <!-- <button class="btn btn_blue"  style="margin-left:30px;margin-bottom:0;" onclick="click_people(this)">锁定名单</button> -->
                           <?php }  ?>
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                  <?php if(!empty($order_inou[0]['inou'])){if($order_inou[0]['inou']==1){ ?>
                                      <tr>
                                        <th>序号</th>
                                        <th>姓名</th>
                                        <th>英文名</th>
                                        <th>性别</th>
                                        <th>证件类型</th>
                                        <th>证件号码</th>
                                        <th>出生年月日</th>
                                        <th>签发地</th>
                                        <th>签发日期</th>
                                        <th>有效期至</th>
                                         <th>手机号码</th>
                                       <!--   <th></th> -->
                                    </tr>
                                   <?php }else{ ?>
                                     <tr>
                                            <th>序号</th>
                                            <th>姓名</th>
                                            <th>性别</th>
                                            <th>证件类型</th>
                                            <th>证件号码</th>
                                            <th>出生年月日</th>
                                            <th>手机号码</th>
                                         <!--    <th></th> -->
                                    </tr>
                                   <?php }
                                     }else{?>
                                     <tr>
                                            <th>序号</th>
                                            <th>姓名</th>
                                            <th>性别</th>
                                            <th>证件类型</th>
                                            <th>证件号码</th>
                                            <th>出生年月日</th>
                                            <th>手机号码</th>
                                            <!--  <th></th> -->
                                    </tr>
                                   <?php  } ?>
                            </thead>
                            <tbody class="people_content">
                                <?php foreach ($order_people as $item): ?>
                                <?php if($item['id']!=''):?>
                                        <?php if(!empty($order_inou[0]['inou'])){ if($order_inou[0]['inou']==1){ ?>
                                            <tr class="tongguo">
                                                <td><?php echo $item['id']?></td>
                                                <td><?php  if(!empty($item['m_name'])){echo $item['m_name']; }?></td>
                                                <td><?php  if(!empty($item['enname'])){echo $item['enname']; }?></td>
                                                <td><?php  if($item['sex']==1){echo '男';}elseif($item['sex']==2){ echo '';}else{ echo '女' ; }?></td>
                                                <td><?php echo $item['certificate_type']?></td>
                                                <td><?php echo  $item['certificate_no'] ?></td> 
                                                <td><?php if($item['birthday']!='0000-00-00'){  echo $item['birthday']; }?></td>
                                                <td><?php echo  $item['sign_place'] ?></td>  
                                                <td><?php if($item['sign_time']!='0000-00-00'){  echo  $item['sign_time'] ;}?></td> 
                                                <td><?php if($item['endtime']!='0000-00-00'){ echo  $item['endtime'];} ?></td> 
                                                <td><?php echo $item['telephone'];?></td>
                           
                                            </tr>
                                            <?php }else{?>
                                              <tr class="tongguo">
                                                    <td><?php echo $item['id']?></td>
                                                    <td><?php  if(!empty($item['m_name'])){echo $item['m_name']; }?></td>
                                                    <td><?php  if($item['sex']==1){echo '男';}elseif($item['sex']==2){ echo '';}else{ echo '女' ; }?></td>
                                                    <td><?php echo $item['certificate_type']?></td>
                                                    <td><?php echo  $item['certificate_no'] ?></td> 
                                                    <td><?php if($item['birthday']!='0000-00-00'){  echo $item['birthday']; }?></td> 
                                                    <td><?php echo $item['telephone'];?></td>
                                       
                                              </tr>

                                             <?php   } ?>
                                       <?php }else{?>
                                            <tr class="tongguo">
                                                <td><?php echo $item['id']?></td>
                                                <td><?php  if(!empty($item['m_name'])){echo $item['m_name']; }?></td>
                                                <td><?php  if($item['sex']==1){echo '男';}elseif($item['sex']==2){ echo '';}else{ echo '女' ; }?></td>
                                                <td><?php echo $item['certificate_type']?></td>
                                                <td><?php echo  $item['certificate_no'] ?></td> 
                                                <td><?php if($item['birthday']!='0000-00-00'){  echo $item['birthday']; }?></td> 
                                                <td><?php echo $item['telephone'];?></td>
                                   
                                            </tr>
                                       <?php  } ?>
                                <?php endif;?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="table_list">
		              <div class="small_title_txt clear" style="border-bottom:0;padding-left:0;">
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th style="width:5%"></th>
                                    <th style="width:15%">项目</th>
                                    <th style="width:25%">备注</th>
                                    <th style="width:10%">单价</th>
                                    <th  style="width:8%">数量</th>
                                    <th  style="width:10%">小计</th>
                                    <th  style="width:12%">录入人</th>
                                    <th  style="width:15%">录入时间</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  if(!empty($bill_yj['data'])){
                                    foreach ($bill_yj['data'] as $key => $value) { 
                             ?>
                                 <?php 
                                            $look='';
                                            if($value['status']==2){  
                                                        $cls='tongguo';
                                            }else if($value['status']==3 || $value['status']==4){
                                                        $cls='jujue';
                                            }else{
                                                        $cls='shenhe';
                                                      //  $look='onclick="show_order_yf('.$value['id'].')"' ;
                                            }
                                    ?>
                                       <tr class="<?php echo $cls;?>">
                                            <td <?php //echo $look; ?>><i></i></td>
                                            <td><?php  echo  $value['item'];?></td>
                                            <td><?php  echo  $value['remark'];?></td>
                                            <td><?php  echo  $value['price'];?></td>
                                            <td><?php  echo  $value['num'];?></td>
                                            <td><?php  echo  $value['amount'];?></td> 
                                            <td><?php   if(!empty($value['user_id'])){echo '<a href="##" onclick="show_user('.$value['user_id'].','.$value['user_type'].')">'.$value['user_name'].'</a>';}else{ echo '系统';}?></td> 
                                            <td><?php echo  date("Y-m-d H:s",strtotime($value['addtime'])) ;?></td>
                                    </tr>
                            <?php }   }?>
                                <tr class="zongji zongji4"><td colspan="8" style="text-align:right;"><span>总计：<i><?php  if(!empty($bill_yj['count_money'])){ echo $bill_yj['count_money']; }else{ echo 0;} ?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <!--应收客人-->  
                    <div class="small_title_txt clear" style="margin-bottom:10px;padding-left:0;margin-top:20px;">
                           <span class="txt_info fl" style="color: red">应收客人</span>
                    </div>
                    <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th style="width:5%"></th>
                                    <th style="width:15%">项目</th>
                                    <th style="width:25%">备注</th>
                                    <th style="width:10%">单价</th>
                                    <th  style="width:8%">数量</th>
                                    <th  style="width:10%">小计</th>
                                    <th  style="width:12%">录入人</th>
                                    <th  style="width:15%">录入时间</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  if(!empty($order_ys)){
                                    foreach ($order_ys as $key => $value) { 
                             ?>
                                 <?php 
                                            $look='';
                                            if($value['status']==1){  
                                                 $cls='tongguo';
                                            }else if($value['status']==3 || $value['status']==4){
                                                 $cls='jujue';
                                            }else{
                                                 $cls='shenhe';
                                            }
                                    ?>
                                    <tr class="<?php echo $cls;?>">
                                        <td <?php //echo $look; ?>><i></i></td>
                                        <td><?php  echo  $value['item'];?></td>
                                        <td><?php  echo  $value['remark'];?></td>
                                        <td><?php  echo  $value['price'];?></td>
                                        <td><?php  echo  $value['num'];?></td>
                                        <td><?php  echo  $value['amount'];?></td> 
                                        <td><?php   if(!empty($value['user_id'])){echo '<a href="##" onclick="show_user('.$value['user_id'].','.$value['user_type'].')">'.$value['user_name'].'</a>';}else{ echo '系统';}?></td> 
                                        <td><?php echo  date("Y-m-d H:s",strtotime($value['addtime'])) ;?></td>
                                    </tr>
                            <?php }   }?>
                                <tr class="zongji zongji4"><td colspan="8" style="text-align:right;"><span>总计：<i><?php  if(!empty($all_ys['amount'])){ echo $all_ys['amount']; }else{ echo 0;} ?></i>元 </span></td></tr>
                            </tbody>
                        </table>    
                    <!--交款信息-->  
                    <div class="small_title_txt clear" style="margin-bottom:10px;padding-left:0;margin-top:20px;">
                           <span class="txt_info fl" style="color: red">交款信息</span>
                           <span style="line-height: 28px;font-weight:600 !important;color: #3fa95c;">
                           <?php if(!empty($limit)){ echo '('.(empty($limit['union_name'])?$limit['brand']:$limit['union_name']).'&nbsp;担保额度'.$limit['credit_limit'].'元'.'，担保意见：'.$limit['reply'].')';} ?>
                           </span>
                    </div>
                    <table class="table table-bordered table_hover">
                    <thead>
                        <tr>
                            <th align="center" width="30">状态</th>
                            <th align="center" width="98">交款时间</th>
                            <th align="center" width="50">金额</th>
                            <th align="center" width="200">备注</th>
                            <th align="center" width="80">交款方式</th>
                            <th align="center" width="80">交款人</th>
                            <th align="center" width="80">状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($receive)):?>
                        <?php foreach($receive AS $val):?>
                            <?php if($val['status']==3):?>
                                <tr class="jujue">
                            <?php elseif($val['status']==2):?>
                                <tr class="tongguo">
                            <?php elseif($val['status']==1):?>
                                <tr class="shenhe">
                            <?php elseif($val['status']==0):?>
                                <tr class="shenhe">
                            <?php endif;?>
                            <td><i></i></td>
                            <td><?php echo $val['addtime']?></td>
                            <td><?php echo $val['money']?></td>
                            <td><?php echo $val['remark']?></td>
                            <td>
                            <?php if($val['way']=="转账"){
                                  // echo $val['way'].'('.$val['bankname'].'/'.$val['bankcard'].')';
                                     echo $val['way'];
                                }else{
                                     echo $val['way'];
                                }
                               ?>
                           </td> 
                            <td><a href="##" <?php echo 'onclick="show_user('.$val['expert_id'].',1)"';?>><?php echo $val['realname']?></a></td>
                            <td>
                            <?php if($val['status']==3){ echo '已拒绝';} elseif ($val['status']==2) {
                               echo '已交款';}else if($val['status']==1){ echo '财务审核中'; }else if($val['status']==0){ echo '未交款（经理未提交)';}
                            ?></td>
                        </tr>
                    <?php endforeach;?>
                    <?php endif;?>
                        <tr class="zongji zongji4"><td colspan="8" style="text-align:right;"><span>总计：<i><?php  if(!empty($receive[0]['all_money'])){ echo $receive[0]['all_money']; }else{ echo 0;} ?></i>元 </span></td></tr>
                    </tbody>
                </table>                 


                    <!--保险明细-->
                     <?php if(!empty($insurance)){ ?>
                         <div class="small_title_txt clear" style="margin-bottom:10px;padding-left:0;margin-top:20px;">
                            <span class="txt_info fl">保险明细</span>
                          <!--   <button class="apple_tuiding" onclick="apple_tuiding(this);" style="margin-bottom:0;">锁定名单</button> -->
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th>保险名称</th>
                                    <th>保险公司</th>
                                    <th>保险期限</th>
                                    <th>数量</th>
                                    <th>单价</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php foreach ($insurance as $k=>$v){ ?>
                                <tr>
                                    <td><?php echo $v['insurance_name']; ?></td>
                                    <td><?php echo $v['insurance_company']; ?></td>
                                    <td><?php echo $v['insurance_date'].'天'; ?></td>
                                    <td><?php echo $v['number']; ?></td>
                                    <td><?php echo $v['in_price']; ?></td>
                                </tr> 
                                <?php }?>                                 
                            </tbody>
                        </table>
                    <?php }?>      
                     <!--保险明细end-->   
                     <!--发票明细-->
                     <?php if(!empty($invoice)){ ?>
                         <div class="small_title_txt clear" style="margin-bottom:10px;padding-left:0;margin-top:20px;">
                            <span class="txt_info fl">发票明细</span>
                          <!--   <button class="apple_tuiding" onclick="apple_tuiding(this);" style="margin-bottom:0;">锁定名单</button> -->
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th>发票抬头</th>
                                    <th>配送地址</th>
                                    <th>收件人</th>
                                    <th>手机</th>
                                    <th>金额</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php foreach ($invoice as $k=>$v){ ?>
                                <tr>
                                    <td><?php echo $v['invoice_name']; ?></td>
                                    <td><?php echo $v['address']; ?></td>
                                    <td><?php echo $v['receiver']; ?></td>
                                    <td><?php echo $v['telephone']; ?></td>
                                    <td><?php if(!empty($order_detail_info['total_price'])){ echo ($order_detail_info['total_price']+$order_detail_info['settlement_price']);}else{ echo 0;}?>
                                    </td>
                                </tr> 
                                <?php }?>                                 
                            </tbody>
                        </table>
                    <?php }?>      
                     <!--发票明细end-->  
                </div> 
            </div>       
                
        </div>
</div>
<!--线路详情-->
<div class="fb-content" id="line_trip" style="display:none;">
    <div class="box-title">
        <h4>线路行程</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="jkxx fb-form" style="padding:10px;" id="trip_info"> </div>
</div> 
<!--成本拒绝原因-->
<div class="fb-content" id="b_supplier_cost" style="display:none;" >
    <div class="box-title">
        <h4>成本修改</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                      <tr height="40">
                        <td class="order_info_title">审核意见:</td>
                        <td class="total_price"  colspan="3"  >
                               <textarea style="width:90%;" name="supplier_remark"></textarea>
                        </td>
                      </tr>
                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="hidden" id="bill_id" name="bill_id">
                  <input type="button" name="" value="确认" class="btn btn_blue" id="update" style="margin-left:210px;"  onclick="update_supplier_cost()" >
                   <input type="button" name="" value="拒绝" class="btn btn_blue" id="refuse" style="margin-left:210px;display: none;" onclick="refuse_supplier_cost()" >
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>
<!--退团退款操作-->
<!--     <div class="fb-content" id="b_tuituan_order" style="display:none;" >
<div class="box-title">
    <h4 class="title_tuituan_order">订单退团</h4>
    <span class="layui-layer-setwin">
        <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
    </span>
</div>
<div class="fb-form">
    <form method="post" action="#" id="apply-data" class="form-horizontal">
        <div class="form_con ">
          <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                  <tr height="40">
                    <td class="order_info_title">成本价:</td>
                    <td class="t_supplier_cost"></td>
                    <td class="order_info_title">平台管理费:</td>
                    <td class="t_platform_fee" ></td>
                  </tr>
                  <tr height="40">
                    <td class="order_info_title">结算价:</td>
                    <td class="t_up_money"></td>
                    <td class="order_info_title">已结算总额:</td>
                    <td class="t_balance_money" ></td>
                  </tr>
                  <tr height="40">
                    <td class="order_info_title">代收金额:</td>
                    <td class="" ></td>
                    <td class="order_info_title">授信额度:</td>
                    <td  class="t_credit_limit"> </td>
                  </tr>
                  <tr height="40">
            
                    <td class="order_info_title"> 未结算金额:</td>
                    <td class="t_p_amount">  </td>
                    <td class="order_info_title">退款金额:</td>
                    <td class="t_amount">   </td>
                  </tr>
                  <tr height="40" class="fow_account_pic">
                    <td class="order_info_title">上传流水单:</td>
                    <td  colspan="3">
                            <input type="file" id="upfile" name="upfile"  />
                            <input type="button"  id="updatafile" value="上传" style="padding: 3px;margin-left:15px" /> 
                            <input type="hidden" id="attachment" name="attachment"  />
                            <img style="width:45px;margin-left:80px;" class="fow_account" src="#">
                     </td>
                  </tr>
                  <tr height="40">
                    <td class="order_info_title">退已结算金额:</td>
                    <td class="" colspan="3"> <input type="text" name="t_meney"  style="height:30px;width:80px" />
                    <span style="color:red" >退已结算金额和未结算金额和平台管理费之和不能小于订单退款金额.</span>
                    </td>
                  </tr>
                  <tr height="40"  >
                    <td class="order_info_title">备注:</td>
                    <td class="total_price" colspan="3"><input type="text" name="t_remark"   class="w_500" style="height:30px" />  </td>
                  </tr>
            </table>
        </div>
        <div class="form_btn clear" >
              <input type="hidden" id="t_bill_id" name="t_bill_id">
              <input type="button" name="" value="确认" class="btn btn_blue" id="q_tuituan" style="margin-left:210px;"  onclick="q_tuituan_order()" >
              <input type="button" value="拒绝" class="btn btn_blue" id="r_tuituan" style="margin-left:210px;display: none;" onclick="r_tuituan_order()" >

              <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
        </div>
    </form>
</div>
</div> -->
<!--确认退团-->
    <div class="fb-content" id="tuituan_order_data" style="display:none;" >
    <div class="box-title">
        <h4 class="h_order_data">订单退团</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                    <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td class="q_supplier_cost"></td>
                        <td class="order_info_title">平台管理费:</td>
                        <td class="q_platform_fee" ></td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title">已结算:</td>
                        <td class="" ></td>
                        <td class="order_info_title">授信额度:</td>
                        <td  class="q_credit_limit"> </td>
                      </tr>
                      <tr height="40">
                        <td class="order_info_title"> 未结算金额:</td>
                        <td class="q_p_amount">  </td>
                         <td class="order_info_title">成本修改:</td>
                        <td class="q_amount">  </td>
                      </tr>

                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="hidden" id="p_bill_id" name="p_bill_id">
                  <!--提交给旅行社审核-->
                  <input type="button" name="" value="确认" class="btn btn_blue" id="pass_order_btn" style="margin-left:210px;"  onclick="pass_order()" >
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>
<!--拒绝成本修改-->
    <div class="fb-content" id="re_order_data" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">订单退团</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                    <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td class="s_supplier_cost"></td>
                        <td class="order_info_title">平台管理费:</td>
                        <td class="s_platform_fee" ></td>
                    </tr>
                    <tr height="40">
                         <td class="order_info_title">已结算总额:</td>
                         <td class="s_balance_money" ></td>
                         <td class="order_info_title">授信额度:</td>
                         <td  class="s_credit_limit"> </td>
                    </tr>
                    <tr height="40">
                          <td class="order_info_title"> 未结算金额:</td>
                          <td class="s_p_amount">  </td>
                          <td class="order_info_title">退款金额:</td>
                          <td class="s_amount">  </td>
                     </tr>

                     <tr height="40" class="s_bill_remark_tr">
                        <td class="order_info_title">审核意见:</td>
                        <td class="" colspan="3"> <input type="text" name="bill_remark"   style="height:30px;width:500px" />
                        </td>
                     </tr>
                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="hidden" id="s_bill_id" name="s_bill_id">

                  <input type="button" value="拒绝" class="btn btn_blue" id="ref_order_btn" style="margin-left:210px;"  onclick="ref_order()" >

                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>

<!--拒绝订单退团(不退人) -->
    <div class="fb-content" id="re_order_bill" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">订单退团</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
              <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top: 20px;">
                    <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td class="sr_supplier_cost"></td>
                        <td class="order_info_title">平台管理费:</td>
                        <td class="sr_platform_fee" ></td>
                    </tr>
                    <tr height="40">
                         <td class="order_info_title">已结算总额:</td>
                         <td class="sr_balance_money" ></td>
                         <td class="order_info_title">授信额度:</td>
                         <td  class="sr_credit_limit"> </td>
                    </tr>
                    <tr height="40">
                          <td class="order_info_title"> 未结算金额:</td>
                          <td class="sr_un_amount">  </td>
                          <td class="order_info_title">退款金额:</td>
                          <td class="sr_bill_money">  </td>
                     </tr>

                     <tr height="40" class="">
                        <td class="order_info_title">审核意见:</td>
                        <td class="" colspan="3"> <input type="text" name="sr_remark"   style="height:30px;width:500px" />
                        </td>
                     </tr>
                </table>
            </div>
            <div class="form_btn clear" >
                  <input type="hidden" id="sr_bill_id" name="sr_bill_id">

                  <input type="button" value="拒绝" class="btn btn_blue" id="ref_order_btn" style="margin-left:210px;"  onclick="dis_order_bill()" >

                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" id="refuse" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>
</body>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>

<?php echo $this->load->view('admin/b1/common/user_message_script'); ?>
<?php echo $this->load->view('admin/b1/common/step_flow_script'); ?>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".itab ul li").click(function(){
			var index = $(this).index();
			var nav_num = $(".itab").index($(this).parent());
			$(this).parent().find("a").removeClass("active");
			$(this).find("a").addClass("active");
			$(this).parent().parent().siblings(".tab_content").find(".table_list").hide();
			$(this).parent().parent().siblings(".tab_content").find(".table_list").eq(index).show();
		})
	});
	function project_select(obj){
		var val = $(obj).val();
		if(val=="其他"){
			$(obj).hide();
			$(obj).siblings("input").show();
		}
	}
	//应付供应商  新增成本
	function add_fee(obj){
		var str = '<tr class="add_fee"><td></td>';
			str+= '<td><select class="project_select" onchange="project_select(this);"><option value="成人价">成人价</option><option value="小孩占床">小孩占床</option><option value="小孩不占床">小孩不占床</option><option value="老人价">老人价</option><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" class="other_obj"/></td>';
			str+= '<td><input type="text" class="beizhu"/></td>';
			str+= '<td><input type="text" class="danjia" style="width:80px;" onblur="check_danjia(this);"/></td>';
			str+= '<td><input type="text" class="shuliang" style="width:55px;" onblur="check_shuliang(this);"/></td>';
			str+= '<td class="total_money"></td>';
                                       str+= '<td class=""></td>';
			str+= '<td><span class="save" id="save_button" onclick="save_add_cost(this);">保存</span><span class="cancle"  id="cancle_button" onclick="cancle_add_fee(this);">取消</span></td><td class="">自动生成</td></tr>';
			
			$(".zongji1").before(str);
			
	}
	//检测单价
	function check_danjia(obj){
          var price = $(obj).val();
          if(isNaN(price)){
                //    alert('填写格式不对');
                    layer.msg('填写格式不对', {icon: 2});
                    $(obj).val('');
                    $(obj).focus();
                    return false;
           }else{

                var num = $(obj).parent().siblings("td").find(".shuliang").val();
                var total;
                total = price*num;  
                $(obj).parent().siblings(".total_money").html(total);
          } 
	}
	//检测数量
	function check_shuliang(obj){
		  var num = $(obj).val();
          if(isNaN(num)){
              //  alert('填写格式不对');
                 layer.msg('填写格式不对', {icon: 2});
                $(obj).val('');
                $(obj).focus();
                return false;
           }else{
        		var price = $(obj).parent().siblings("td").find(".danjia").val();
        		var total;
        		total = price*num;	
        		$(obj).parent().siblings(".total_money").html(total);
           }
	}

    //--------------------------------------------修改成本价--------------------------------------------------
             //保存成本价
             function save_add_cost(obj){
                
                          var project = $(obj).parent().siblings("td").find(".project_select").val();
                          var price = $(obj).parent().siblings("td").find(".danjia").val();
                          var num = $(obj).parent().siblings("td").find(".shuliang").val();
                          var beizhu= $(obj).parent().siblings("td").find(".beizhu").val();
                          if(project=="其他"){
                                var other_obj = $(".other_obj").val();
                                if(other_obj.length<=0){
                                 //   alert("请填写项目名称");
                                    layer.msg('请填写项目名称', {icon: 2});
                                    $(obi).parent().siblings("td").find(".other_obj").focus();
                                    return false;
                                }
                                project=other_obj;
                           }
                          if(price.length==0){
                               // alert("请填写单价");
                                layer.msg('请填写单价', {icon: 2});
                                $(obj).parent().siblings("td").find(".danjia").focus();
                                return false;
                           }
                           if(num.length<=0){
                              //  alert("请填写数量");
                                layer.msg('请填写数量', {icon: 2});
                                $(obj).parent().siblings("td").find(".danjia").focus();
                                return false;
                         }
                     
                         if(price=='' || price==0){
                                // alert("请填写价格");
                                  layer.msg('请填写价格', {icon: 2});
                                  return false;
                         }
                 
                          var  orderid="<?php if(!empty($order_id)){ echo $order_id;}else{ echo 0;}?>";

                      jQuery.ajax({ type : "POST",async:false,data : { 'orderid':orderid,'project':project,'price':price,'num':num,'beizhu':beizhu,},url : "<?php echo base_url()?>admin/b1/order/add_order_cost", 
                                beforeSend:function() {//ajax请求开始时的操作
                                       $('#save_button').addClass("disabled");
                                        layer.load(1);//加载层
                                },
                                complete:function(){//ajax请求结束时操作
                                     $('#save_button').removeClass("disabled");
                                     layer.closeAll('loading'); //关闭层
                                },
                                success : function(result) { 
                                            var result =eval("("+result+")"); 
                                            if(result.status==1){
                                                alert(result.msg);
                                                var string='<tr class="shenhe">';
                                                string=string+'<td ><i></i></td>';
                                                string=string+'<td>'+result.data.item+'</td>';
                                                string=string+'<td>'+result.data.remark+'</td>';
                                                string=string+'<td>'+result.data.price+'</td>';
                                                string=string+'<td>'+result.data.num+'</td>';
                                                string=string+'<td>'+result.data.amount+'</td>';
                                                string=string+'<td>'+result.data.user_name+'</td>';
                                                string=string+'<td>审核中</td>';
                                                string=string+'<td>'+result.data.addtime+'</td>';
                                                string=string+'</tr>';
                                              $(".zongji1").before(string);
                                           //   alert(string);
                                               $(obj).parent().parent().remove();
                                                window.location.reload();  
                                             //   window.location.reload();
                                            }else{
                                                    alert(result.msg);
                                                   
                                            }
                                }
                      });

             }
             //改价/退团   通过
             function  pass_status(id){

                   var order_id="<?php if(!empty($order_id)){ echo $order_id;}else{ echo 0;}?>";
                   $.post("<?php echo site_url('admin/b1/order/through_oderprice')?>",
                    {'order_id':order_id,'id':id},
                    function(result) {
                            var result =eval("("+result+")"); 
                            if(result.status==1){
                                   // alert(result.msg);
                                    layer.msg(result.msg, {icon: 1});  
                            }else{
                                    alert(result.msg);
                            }
                    });
                   window.location.reload();
             }

             //改价/退团   拒绝
             function refuse_status(id){
       	             $('#refuse').show();
                     $('#update').hide();
                     $('input[name="bill_id"]').val(id);
                     layer.open({
                            type: 1,
                            title: false,
                            closeBtn: 0,
                            area: '600px',
                            //skin: 'layui-layer-nobg', //没有背景色
                            shadeClose: false,
                            content: $('#b_supplier_cost')
                     });  
             }
             //确认成本拒绝
             function refuse_supplier_cost(){
                   var supplier_remark=$('textarea[name="supplier_remark"]').val();
                   var id=$('input[name="bill_id"]').val();
                   var order_id="<?php if(!empty($order_id)){ echo $order_id;}else{ echo 0;}?>";
                   $.post("<?php echo site_url('admin/b1/order/refuse_oderprice')?>",
                   {'order_id':order_id,'id':id,'supplier_remark':supplier_remark},
                   function(result) {
                        var result =eval("("+result+")"); 
                        if(result.status==1){
                               //  alert(result.msg);
                               layer.msg(result.msg, {icon: 1});  
                               window.location.reload();
                        }else{
                               alert(result.msg);
                        }
                    });
             }
	//取消
	function cancle_add_fee(obj){
		$(obj).parent().parent().remove();
	}
	
	/* function apple_tuiding(obj){
		var choose = $(obj).parent().siblings("table").find("input[type='checkbox']:checked");
		if(choose.length<=0){
			alert("请选择退订名单");
			return false;
		}
		
		layer.open({
		      type: 1,
		      title: false,
		      closeBtn: 0,
		      area: '800px',
		      //skin: 'layui-layer-nobg', //没有背景色
		      shadeClose: false,
		      content: $('#form1')
		});

	} */
            //导出名单信息
             function  drive_member(obj){
                     var order_id = $(obj).attr('data-val');
                     $.post(
                              "<?php echo site_url('admin/b1/order/export_excel')?>",
                              {'id':order_id},
                              function(data) {
                                       data = eval('('+data+')');
                                      data = '<?php echo base_url();?>'+data;
                                      window.location.href=data;
                      });

             }
               /*********************************Start查看行程**********************************/
                        $('.see_trip').click(function(){
                                $('#trip_info').html('');
                                var lineid = $(this).attr('line_id');
                                $.post(
                                  "<?php echo site_url('admin/b1/order/get_line_jieshao')?>",
                                  {'id':lineid},
                                  function(data) {
                                    data = eval('('+data+')');
                                    $('.trip_every_day').remove();
                                    $.each(data ,function(key ,val) {
                                    if (val.breakfirsthas == 1) {
                                      breakfirsthas = '有';
                                    } else {
                                      breakfirsthas = '无';
                                    }
                                    if (val.lunchhas == 1) {
                                      lunchhas = '有';
                                    } else {
                                      lunchhas = '无';
                                    }
                                    if (val.supperhas == 1) {
                                      supperhas = '有';
                                    } else {
                                      supperhas = '无';
                                    }
                                    if (typeof val.breakfirst == 'object' || val.breakfirst.length == 0) {
                                      breakfirst = breakfirsthas;
                                    } else {
                                      breakfirst = val.breakfirst;
                                    }
                                    if (typeof val.lunch == 'object' || val.lunch.length == 0) {
                                      lunch = lunchhas;
                                    } else {
                                      lunch = val.lunch;
                                    }
                                    if (typeof val.supper == 'object' || val.supper.length == 0) {
                                      supper = supperhas;
                                    } else {
                                      supper = val.supper;
                                    }
                                    var picstr='';
                                    if(val.pic!=null){
                                       //   alert(val.pic);
                                           picArr= val.pic.split(';');
                                           $.each(picArr, function(p1, p2){

                                              picstr+='   <img src="'+p2+'" height="80" />';

                                            });  
                                    }
                                    str = '<div class="small_title_txt clear">';
                                //    str += '<div class="trip_day_title">';
                                    str += '   <span class="txt_info fl">第&nbsp;'+val.day+'&nbsp;天：</span></div>';
                                    str +='<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">';
                                    str += '<tr height="40"> <td class="order_info_title">标题:</td> <td colspan="3">'+val.title+'</td></tr>';
                                    str+='<tr height="40"> <td class="order_info_title">行程内容:</td><td colspan="3">'+val.jieshao+'</td> </tr>';
                                    str+='<tr height="40"><td class="order_info_title">用餐:</td>'; 
                                    str+='<td colspan="3" style="padding:5px;">';
                                    str += '<div class="trip_day_title">早餐：'+breakfirst+'<br/>中餐：'+lunch+'<br/>晚餐：'+supper+'<br/></td></tr>';
                                    str += '<tr height="40"> <td class="order_info_title">住宿情况:</td> <td colspan="3">'+val.hotel+'</td></tr>';
                                    str += '   <tr height="40"> <td class="order_info_title">交通情况:</td> <td colspan="3">'+val.transport+'</td> </tr>';
                                    str+='<tr height="40"><td class="order_info_title">相关图片:</td> <td colspan="3">'+picstr+'</td></tr>';
                                    str+='</table> </div>';

                                    $('#trip_info').append(str);
                                    });
                                    layer.open({
                                      type: 1,
                                      title: false,
                                      closeBtn: 0,
                                      area: ['800px','80%'],
                                      shadeClose: false,
                                      content: $('#line_trip')
                                    });
                                  });
                        });
                    /*********************************End查看行程**********************************/
            //锁定名单
            function click_people(obj){
                          var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';

                           $.post( "<?php echo site_url('admin/b1/order/up_people_lock')?>", {'orderid':orderid}, function(data) {
                                       data = eval('('+data+')');
                                       var inou='<?php if(!empty($order_inou[0]['inou'])){ echo $order_inou[0]['inou'];}else{echo 2;}?>';
                                       if(inou==1){  //境外
                                                $('.people_content').html('');
                                                $.each(data.order_people, function(key, val) {
                                                        if(val.sex==1){
                                                                var sexstr='男';
                                                        }else if(val.sex==2){
                                                               var sexstr='';
                                                        }else{
                                                                 var sexstr='女';
                                                        }
                                                        if(val.certificate_type==null){   var certificate_type='';  }
                                                        if(val.birthday=='0000-00-00'){  val.birthday='';  }
                                                        if(val.sign_time=='0000-00-00'){  val.sign_time='';  }
                                                        if(val.endtime=='0000-00-00'){  val.endtime='';  }
                                                        var str=''; 
                                                        str=str+'<tr>';  
                                                        str=str+'<td>'+val.id+'</td>';  
                                                        str=str+'<td>'+val.m_name+'</td>';  
                                                        str=str+'<td>'+val.enname+'</td>';  
                                                        str=str+'<td>'+sexstr+'</td>';  
                                                        str=str+'<td>'+certificate_type+'</td>';  
                                                        str=str+'<td>'+val.certificate_no+'</td>';   
                                                        str=str+'<td>'+val.birthday+'</td>';   
                                                        str=str+'<td>'+val.sign_place+'</td>'; 
                                                        str=str+'<td>'+val.sign_time+'</td>'; 
                                                        str=str+'<td>'+val.endtime+'</td>'; 
                                                        str=str+'<td>'+val.telephone+'</td>'; 
                                                        if(val.people_lock==1){
                                                                 str=str+'<td>已锁定</td>';
                                                        }else{
                                                              str=str+'<td>未锁定</td>';
                                                        }
                                                        str=str+'</tr>'; 
                                                        $('.people_content').append(str); 
                                               });
                            
                                       }else{   //境内
                                                   $('.people_content').html('');
                                                   $.each(data.order_people, function(key, val) {
                                                            if(val.sex==1){
                                                                    var sexstr='男';
                                                            }else if(val.sex==2){
                                                                     var sexstr='';
                                                            }else{
                                                                     var sexstr='女';
                                                            }
                                                            if(val.certificate_type==null){   var certificate_type='';  }
                                                            if(val.birthday=='0000-00-00'){  val.birthday='';  }
                                                            var str=''; 
                                                            str=str+'<tr>';  
                                                            str=str+'<td>'+val.id+'</td>';  
                                                            str=str+'<td>'+val.m_name+'</td>';   
                                                            str=str+'<td>'+sexstr+'</td>';  
                                                            str=str+'<td>'+certificate_type+'</td>';  
                                                            str=str+'<td>'+val.certificate_no+'</td>';   
                                                            str=str+'<td>'+val.birthday+'</td>';   
                                                            str=str+'<td>'+val.telephone+'</td>'; 
                                                            if(val.people_lock==1){
                                                                     str=str+'<td>已锁定</td>';
                                                            }else{
                                                                    str=str+'<td>未锁定</td>';
                                                            }
                                                            str=str+'</tr>'; 
                                                            $('.people_content').append(str); 
                                                   });
                                       }

                          });
            }
//--------------------------退团-----------------------------

//拒绝修改成本账单
function re_tuituan_order(bill_id,type){
           $('input[name="s_bill_id"]').val(bill_id);
           var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';
        
          $.post( "<?php echo site_url('admin/b1/order/get_tuituan_data')?>", {'orderid':orderid,'bill_id':bill_id}, function(data) {
                  data = eval('('+data+')');
                  $('.s_up_money').html(data.up_money);  
                  $('.s_supplier_cost').html(data.supplier_cost);
                  $('.s_platform_fee').html(data.platform_fee);
                  $('.s_balance_money').html(data.balance_money);
                  $('.s_credit_limit').html(data.credit_limit);  
                  $('.s_amount').html(data.amount);  
                  $('.s_p_amount').html(data.p_amount);  
                 $('.s_meney').html(data.s_refund_money);
          }); 


           if(type==-1){ //拒绝退团
                $('.s_balance_bill_tr').hide(); //退款金额
                $('.s_bill_remark_tr').show(); //退单理由
                $('input[name="bill_remark"]').val('');
                $('.s_order_data').html('成本价修改');
                $('.s_amount').prev().html('成本价修改');
             //   alert(123);
          }else if(type==-2){  //拒绝成本价修改
                $('.s_balance_bill_tr').hide(); //退款金额
                $('.s_bill_remark_tr').show(); //退单理由
                $('input[name="bill_remark"]').val('');
                $('.s_order_data').html('订单退团');
                $('.s_amount').prev().html('退款金额');
          }else if(type==-3){ //拒绝成本价修改
                $('.s_balance_bill_tr').hide(); //退款金额
                $('.s_bill_remark_tr').show(); //退单理由
                $('input[name="bill_remark"]').val('');
                $('.s_order_data').html('成本价修改');
                $('.s_amount').prev().html('成本价修改');
          }else if(type==-4){
                $('.s_balance_bill_tr').hide(); //退款金额
                $('.s_bill_remark_tr').show(); //退单理由
                $('input[name="bill_remark"]').val('');
                $('.s_order_data').html('订单退团');
                $('.s_amount').prev().html('退款金额');
          }
           $('#ref_order_btn').show();
           layer.open({
                  type: 1,
                  title: false,
                  closeBtn: 0,
                  area: '700px',
                  shadeClose: false,
                  content: $('#re_order_data')
           });

}
//确认修改成本弹框
function pass_tuituan_order(bill_id,type){
           $('input[name="p_bill_id"]').val(bill_id);
           var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';
        
          $.post( "<?php echo site_url('admin/b1/order/get_tuituan_data')?>", {'orderid':orderid,'bill_id':bill_id}, function(data) {
                  data = eval('('+data+')');
                  $('.q_up_money').html(data.up_money);  
                  $('.q_supplier_cost').html(data.supplier_cost);
                  $('.q_platform_fee').html(data.platform_fee);
                  $('.q_balance_money').html(data.balance_money);
                  $('.q_credit_limit').html(data.credit_limit);  
                  $('.q_amount').html(data.amount);  
                  $('.q_p_amount').html(data.p_amount);  
                 // $('input[name="q_meney"]').val(data.s_refund_money);
                 $('.q_meney').html(data.s_refund_money);
          }); 

          if(type==3){ //订单成本价修改
                $('.balance_bill_tr').show();
                $('.bill_remark_tr').hide();
                $('#pass_order_btn').show(); //确认按钮
               // $('#ref_order_btn').hide(); //拒绝按钮
                $('.h_order_data').html('成本价修改');
                 $('.q_amount').prev().html('成本价修改');
          }else if(type==2){ //退团
                $('.balance_bill_tr').show();
                $('.bill_remark_tr').hide();
                $('#pass_order_btn').show(); //确认按钮
               // $('#ref_order_btn').hide(); //拒绝按钮
                $('.h_order_data').html('订单退团');
                $('.q_amount').prev().html('退款金额');
          }else if(type==-1){ //拒绝退团
                $('.balance_bill_tr').hide(); //退款金额
                $('.bill_remark_tr').show(); //退单理由
                $('#pass_order_btn').hide(); //确认按钮
               // $('#ref_order_btn').show(); //拒绝按钮
                $('input[name="bill_remark"]').val('');
                $('.h_order_data').html('成本价修改');
                $('.q_amount').prev().html('成本价修改');
             //   alert(123);
          }else if(type==-2){  //拒绝成本价修改
                $('.balance_bill_tr').hide(); //退款金额
                $('.bill_remark_tr').show(); //退单理由
                $('#pass_order_btn').hide(); //确认按钮
              //  $('#ref_order_btn').show(); //拒绝按钮
                $('input[name="bill_remark"]').val('');
                $('.h_order_data').html('订单退团');
                $('.q_amount').prev().html('退款金额');
          }else if(type==-3){ //拒绝成本价修改
                $('.balance_bill_tr').hide(); //退款金额
                $('.bill_remark_tr').show(); //退单理由
                $('#pass_order_btn').hide(); //确认按钮
               // $('#ref_order_btn').show(); //拒绝按钮
                $('input[name="bill_remark"]').val('');
                $('.h_order_data').html('订单退团');
                $('.q_amount').prev().html('退款金额');
          }else if(type==4){
                $('.balance_bill_tr').show();
                $('.bill_remark_tr').hide();
                $('#pass_order_btn').show(); //确认按钮
               // $('#ref_order_btn').hide(); //拒绝按钮
                $('.h_order_data').html('订单退团');
                $('.q_amount').prev().html('退款金额');
          }

          layer.open({
                  type: 1,
                  title: false,
                  closeBtn: 0,
                  area: '700px',
                  shadeClose: false,
                  content: $('#tuituan_order_data')
           });

}
//确认订单退团
function pass_order(){
      var bill_id  =$('input[name="p_bill_id"]').val();
      var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';

      jQuery.ajax({ type : "POST",async:false,data : { 'orderid':orderid,'bill_id':bill_id},url : "<?php echo base_url()?>admin/b1/order/save_tuituan_order", 
          beforeSend:function() {//ajax请求开始时的操作
               layer.load(1);//加载层
          },
          complete:function(){//ajax请求结束时操作              
               layer.closeAll('loading'); //关闭层
          },
          success : function(result) { 
        	  data = eval('('+result+')');
	       	   if(data.status==1){
	               
	               layer.msg(data.msg, {icon: 1});  
	               window.location.reload();
	         }else{
	               alert(data.msg);
	         } 
          }
      });
   /*   $.post( "<?php //echo site_url('admin/b1/order/save_tuituan_order')?>", {
            'orderid':orderid,
            'bill_id':bill_id,
      },
      function(data) {
            data = eval('('+data+')');
            if(data.status==1){
                 
                   layer.msg(data.msg, {icon: 1});  
                   window.location.reload();
             }else{
                   alert(data.msg);
             }             
      });*/
}
//拒绝订单退团
function ref_order(){
       var supplier_remark= $('input[name="bill_remark"]').val();
       var id=$('input[name="s_bill_id"]').val();
       var order_id="<?php if(!empty($order_id)){ echo $order_id;}else{ echo 0 ;}?>";

       jQuery.ajax({ type : "POST",async:false,data : { 'order_id':order_id,'id':id,'supplier_remark':supplier_remark},url : "<?php echo base_url()?>admin/b1/order/refuse_oderprice", 
           beforeSend:function() {//ajax请求开始时的操作
                layer.load(1);//加载层
           },
           complete:function(){//ajax请求结束时操作              
                layer.closeAll('loading'); //关闭层
           },
           success : function(result) {
          	  data = eval('('+result+')');
          	  
 	       	   if(data.status==1){
 	               
 	 	       	   layer.msg(data.msg, {icon: 1});  
 		           window.location.reload();
 	         }else{
 	               alert(data.msg);
 	         } 
           }
       });
       
   /*    $.post("<?php //echo site_url('admin/b1/order/refuse_oderprice')?>",
            {'order_id':order_id,'id':id,'supplier_remark':supplier_remark},
            function(result) {
	             var result =eval("("+result+")"); 
	             if(result.status==1){
	                  layer.msg(result.msg, {icon: 1});  
	                  window.location.reload();
	             }else{
	                  alert(result.msg);
	             }
        });*/
}
//确认退团退人弹框
function p_item_order(bill_id,kind){
     var order_id="<?php if(!empty($order_id)){ echo $order_id;}else{ echo 0 ;}?>";
     layer.open({
           title:'确认退团',
           type: 2,
           area: ['700px', '35%'],
           fix: false, //不固定
           maxmin: true,
           content: "<?php echo base_url('admin/b1/order/retired_order_detail');?>"+"?bill_id="+bill_id+"&orderid="+order_id
     });
}

//撤销成本账单
function dis_order_yf(bill_id){
        $.post("<?php echo site_url('admin/b1/order/dis_oder_yf')?>",
        {'bill_id':bill_id},
        function(result) {
            var result =eval("("+result+")"); 
            if(result.status==1){
                  // alert(result.msg);
                  layer.msg(result.msg, {icon: 1});  
                  window.location.reload();       
            }else{
                  alert(result.msg);
            }
        });

} 
//上传流水单
$('#updatafile').on('click', function() {
        $.ajaxFileUpload({url:'/admin/b1/product/up_img',
        secureuri:false,
        fileElementId:'upfile',// file标签的id
        dataType: 'json',// 返回数据的类型
        data:{filename:'upfile'},
        success: function (data, status) {
             if (data.code == 200) {
                  $('input[name="attachment"]').val(data.msg);
                  $('.fow_account').attr('src',data.msg);
                  alert("上传成功");
             } else {
                  alert(data.msg);
             }
        },
        error: function (data, status, e) {
             alert("请选择不超过10M的doc,docx的文件上传");
        }
       });
       return false;
});
//退团拒绝(不退人)
function re_bill_order(bill_id,kind){
	
       $('input[name="sr_bill_id"]').val(bill_id);
       var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';
     
       $.post( "<?php echo site_url('admin/b1/order/get_tuituan_data')?>", {'orderid':orderid,'bill_id':bill_id}, function(data) {
               data = eval('('+data+')');
               $('.sr_supplier_cost').html(data.supplier_cost);
               $('.sr_platform_fee').html(data.platform_fee);
               $('.sr_balance_money').html(data.balance_money);
               $('.sr_credit_limit').html(data.credit_limit);  
               $('.sr_un_amount').html(data.up_money);  
               $('.sr_bill_money').html(data.amount);           
       }); 
    
       layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '700px',
           shadeClose: false,
           content: $('#re_order_bill')
      });
}

//拒绝退团
function dis_order_bill(){
	 var bill_id=$('input[name="sr_bill_id"]').val();
	 var supplier_remark=$('input[name="sr_remark"]').val();
	 var orderid='<?php if(!empty($order_id)){ echo $order_id;}else{echo 0;}?>';

     jQuery.ajax({ type : "POST",async:false,data : { 'orderid':orderid,'bill_id':bill_id,'supplier_remark':supplier_remark},url : "<?php echo base_url()?>admin/b1/order/refuse_order_bill", 
         beforeSend:function() {//ajax请求开始时的操作
              layer.load(1);//加载层
         },
         complete:function(){//ajax请求结束时操作              
              layer.closeAll('loading'); //关闭层
         },
         success : function(result) { 
       	  data = eval('('+result+')');
	       	   if(data.status==1){
	               
	 	       	   layer.msg(data.msg, {icon: 1});  
		           window.location.reload();
	         }else{
	               alert(data.msg);
	         } 
         }
     });
	 
  /*   $.post("<?php //echo site_url('admin/b1/order/refuse_order_bill')?>",
        {'orderid':orderid,'bill_id':bill_id,'supplier_remark':supplier_remark},
        function(result) {
             var result =eval("("+result+")"); 
             if(result.status==1){
                   layer.msg(result.msg, {icon: 1});  
                   window.location.reload();
             }else{
                   alert(result.msg);
             }
      });*/
    
}
</script>
</html>
