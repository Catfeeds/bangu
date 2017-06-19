<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单详情</title>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<style type="text/css">
	body:before { background:#fff;}
	.page-content { margin-left:0;}
	.fb-form { background:#fff;}
	.order_detail { padding-bottom:30px;}
	.table_list { display:none;} 
	.table_list button { padding:3px 10px;margin-bottom:15px;}
	.txt_info { color:#000;font-weight:700 !important;line-height:28px;padding-left:0 !important;}
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
	.add_s_cost .save { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;margin-right:5%;background:url(/assets/ht/img/dui.png) 0px center no-repeat;color:#000;cursor:pointer;}
	.add_s_cost .cancle { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;margin-left:5%;background:url(/assets/ht/img/cuo.png) 0px center no-repeat;color:#000;cursor:pointer;}

	.add_fee .save { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;margin-right:5%;background:url(/assets/ht/img/dui.png) 0px center no-repeat;color:#000;cursor:pointer;}
	.add_fee .cancle { display:inline-block;width:50px;text-align:center;padding-left:5px;box-sizing:border-box;margin-left:5%;background:url(/assets/ht/img/cuo.png) 0px center no-repeat;color:#000;cursor:pointer;}
	.zongji span { padding-right:200px;font-weight: 700;}
	
	.apple_tuiding { padding:0px 5px;margin-left:20px;position:relative;top:-3px;}
	input[type="checkbox"] { position:relative;opacity:1;left:0;width:auto;height:auto;}
	.layui-layer-page { margin-left:0;}
	.title_txt { float:right;width:14%;display:inline-block;}
	.title_txt p { color:#f00;}
	
	.close_page { background:#fff;text-align:center;}
	
	.btn.layui-layer-close { position:relative;}
	select { padding:0;}
	
	.btn_close{
	    background: #da411f;
	    width: 60px;
	
	    margin-left: 20px;
	    margin-bottom: 40px;
	    padding: 5px 10px;
	    border-radius: 3px;
	    color: #fff;
	    border: none;
	    text-align: center;
	    cursor: pointer;
	}
	
	.total_div{margin-bottom:4px;}
	.total_div p{line-height: 18px;}
	.total_div p font{margin-right:34px;margin-left:0px;}

	
	.add_cost{
	background: #09c;
    outline: none;
    border: none;
    color: #fff;
    border-radius: 2px;
    padding: 5px 8px !important;
    cursor:pointer;
	}
	.not_add_cost{
	background: #808080;
    outline: none;
    border: none;
    color: #fff;
    border-radius: 2px;
    padding: 5px 8px !important;
    cursor:pointer;
	}
	.fb-form { margin:0 auto;}
</style>
</head>
<body>
<div class="fb-content" id="form1" style="display:block;">
    <!-- <div class="box-title">
        <h4>订单信息</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div> -->
    <div class="fb-form" style="width:810px;">
        <!-- ===============订单详情============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt"><?php echo $order['productname'];?></h2>
            
            <!-- ===============基础信息============ -->
            <div class="content_part" style="margin-bottom:10px; ">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                    <span class="order_time fr"><?php echo $order['addtime'];?></span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="3"><?php echo $order['productname'];?><a href="javascript:void(0)" class="a_trip" data-id="<?php echo $order['productautoid'];?>">【查看行程】</a></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单编号:</td>
                        <td><?php echo $order['ordersn'];?></td>
                        <td class="order_info_title">团号:</td>
                        <td><?php echo $order['item_code'];?></td>
                       
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出发日期:</td>
                        <td><?php echo $order['usedate'];?></td>
                        <td class="order_info_title">订单状态:</td>
                        <td><?php echo $order['order_status'];?></td>
                       
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">参团人数:</td>
                        <td style="width:45%;">成人: <?php echo $order['dingnum'];?>&nbsp;&nbsp;小童占床: <?php echo $order['childnum'];?>&nbsp;&nbsp;小童不占床: <?php echo $order['childnobednum'];?>&nbsp;&nbsp;<!-- 单房差: --> <?php //echo $order['oldnum'];?></td>
                         <td class="order_info_title">支付状态:</td>
                        <td><?php echo $order['order_pay'];?></td>
                       
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单金额:</td>
                        <td><?php echo $order['total_price']+$order['settlement_price'];?> 元</td>
                        <td class="order_info_title">已收款:</td>
                        <td><?php echo empty($order['receive_price'])==true?0:$order['receive_price'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">保险费用:</td>
                        <td colspan="3"><?php echo $order['settlement_price'];?>元</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">应付供应商:</td>
                        <td>供应商成本（<?php echo $order['supplier_cost'];?>元） - 平台佣金（<?php echo $order['platform_fee'];?>元） = <?php echo $order['jiesuan_money'];?>元</td>
                        <td class="order_info_title">已付供应商:</td>
                        <td><?php echo $order['balance_money'];?> <button class="apple_tuiding add_cost"  onclick="add_payable()" style="margin-top:10px;">申请预付款</button> </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">管家:</td>
                        <td><?php echo $order['expert_name'];?>/<?php echo $order['mobile'];?></td>
                        <td class="order_info_title">供应商:</td>
                        <td><?php echo $order['brand'];?>（<?php echo $order['linkman'];?>/<?php echo $order['supplier_mobile'];?>/<?php echo $order['supplier_telephone'];?>）</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">预定人:</td>
                        <td><?php echo $order['order_linkman'];?></td>
                        <td class="order_info_title">手机号:</td>
                        <td><?php echo $order['order_linkmobile'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">邮箱:</td>
                        <td><?php echo $order['linkemail'];?></td>
                        <td class="order_info_title">备用手机号:</td>
                        <td><?php echo $order['spare_mobile'];?></td>
                    </tr>
                    <tr height="40">
     
                        <td class="order_info_title">订单备注:</td>
                        <td colspan="3"><?php echo $order['remark'];?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">合同编号:</td>
                        <td><?php echo $contract['contract_code'];?></td>
                        <td class="order_info_title">收据/发票:</td>
                        <td>
                        <?php 
                        
                        echo isset($invoice['invoice_code'])==true?$invoice['invoice_code']:'';
                        echo "&nbsp;";
                        echo isset($receipt['receipt_code'])==true?$receipt['receipt_code']:'';
                        
                        ?>
                        
                        </td>
                    </tr>
                </table>
            </div>
             <div class="total_div">
             <p><font>应收客人总计：
            <?php  $t_ys="0";
                  if(!empty($order['ys']))
                  {
                  	foreach ($order['ys'] as $k=>$v)
                  	{
                  		if($v['status']=="1") $t_ys+=$v['amount'];
                  	}
                  }
                  echo $t_ys;
            ?>
                               元</font><font>已交款总计：
            <?php  $t_sk="0";
                  if(!empty($order['sk']))
                  {
                  	foreach ($order['sk'] as $k=>$v)
                  	{
                  		if($v['status']=="2") $t_sk+=$v['money'];
                  	}
                  }
                  echo $t_sk;
            ?>
                               元</font><font>供应商成本总计：
            <?php  $t_yf="0";
                  if(!empty($order['yf']))
                  {
                  	foreach ($order['yf'] as $k=>$v)
                  	{
                  		if($v['status']=="2") $t_yf+=$v['amount'];
                  	}
                  }
                  echo $t_yf;
            ?>
           	  元</font><font>平台佣金总计：
              <?php  $t_yj="0";
                  if(!empty($order['yj']))
                  {
                  	foreach ($order['yj'] as $k=>$v)
                  	{
                  		if($v['status']=="2") $t_yj+=$v['amount'];
                  	}
                  }
                  echo $t_yj;
            ?>
                            元</font><font>外交佣金总计：
              <?php  $t_wj="0";
                  if(!empty($order['wj']))
                  {
                  	foreach ($order['wj'] as $k=>$v)
                  	{
                  		if($v['status']=="1") $t_wj+=$v['amount'];
                  	}
                  }
                  echo $t_wj;
            ?>
                               元</font><!-- <font>保险总计： -->
            <?php  $t_bx="0";
                 /*  if(!empty($order['bx']))
                  {
                  	foreach ($order['bx'] as $k=>$v)
                  	{
                  		$t_bx+=$v['amount'];
                  	}
                  }
                  echo $t_bx; */
            ?>
                             
                            <!--   元</font> --></p> </div>
            <div class="table_con">
                <div class="itab">
                    <ul> 
                        <li status="1"><a href="###" class="active">应收客人</a></li> 
                        
                        <li status="2"><a href="###">供应商成本</a></li> 
                        <li status="3"><a href="###">平台佣金</a></li> 
                        <li status="4"><a href="###">外交佣金</a></li> 
                        <li status="5"><a href="###">保险</a></li> 
                        <li status="6"><a href="###">参团名单</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                  <!-- 应收客人 -->
                    <div class="table_list"  style="display:block;">
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                   
                                    <th>项目</th>
                                  
                                    <th>金额</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                    <th>录入时间</th>
                                    <?php if(empty($action)):?>
                                    <th>审核状态</th>
                                    <?php endif;?>
                                </tr>
                            </thead>
                            <tbody class="yskr">
                             <?php $total_ys=0;if(!empty($order['ys'])):  //应收客人   ?>
                              <?php foreach ($order['ys'] as $k5=>$v5):?>
                                  <tr class="<?php if($v5['status']=='0') echo 'shenhe';else if($v5['status']=='1') echo 'tongguo';else if($v5['status']=='3') echo 'jujue'; ?>">    <!-- tongguo、shenhe、jujue -->
                                   <!--  <td width="10%"><i></i></td> -->
                                    <td width="30%"><?php echo isset($v5['item'])==true?$v5['item']:'';?></td>
                                    <td width="10%"><?php echo isset($v5['price'])==true?$v5['price']:'';?></td>
                                    <td width="10%"><?php echo $v5['num'];?></td>
                                    <td width="10%"><?php echo isset($v5['amount'])==true?$v5['amount']:'';?></td>
                                    <td width="15%"><?php echo isset($v5['addtime'])==true?$v5['addtime']:'';?></td> 
                                     <?php if(empty($action)):?>
                                    <td width="10%"><i></i><?php if($v5['status']=='0') echo '申请中';else if($v5['status']=="1") echo "已通过";else if($v5['status']=='3') echo '已拒绝'; ?></td>
                                     <?php endif;?>
                                  </tr>
                                  <?php if($v5['status']=='1') $total_ys+=$v5['amount'];?>
                              <?php endforeach;?>
                             <?php endif;?>
                              
                                <tr class="zongji zongji1"><td colspan="8" style="text-align:right;"><span>总计：<i><?php echo sprintf("%.2f",$total_ys);?></i>元 </span></td></tr>
                            </tbody>
                        </table>     
                         <!-- 已交款 -->
                         <p style='margin:20px 0 4px 0;font-size:13px;font-weight:bold;'><font style='margin: 0 0 0 10px;'>已交款</font>
                         <?php if(!empty($expert_limit)):?>
                         <font style="color: #3fa95c;">(<?php echo $expert_limit['union_id']=="0"?$expert_limit['brand']:$expert_limit['union_name'];?>担保额度：<?php echo $expert_limit['real_amount'];?>元，担保意见：<?php echo $expert_limit['reply'];?>)</font>
                         <?php endif;?>
                         </p>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                   
                                    <th>交款方式</th>
                                  
                                    <th>金额</th>
                                    <th>备注</th>
                                    <th>交款人</th>
                                    <th>交款部门</th>
                                    <th>录入时间</th>
                                    <th>审核状态</th>
                                </tr>
                            </thead>
                            <tbody class="yskr">
                             <?php $total_sk=0;if(!empty($order['sk'])):  //已交款   ?>
                              <?php foreach ($order['sk'] as $k8=>$v8):?>
                                  <tr class="<?php if($v8['status']=='0'||$v8['status']=='1'||$v8['status']=='5') echo 'shenhe';else if($v8['status']=='2') echo 'tongguo';else echo 'jujue'; ?>">    <!-- tongguo、shenhe、jujue -->
                                   
                                    <td width="10%"><?php echo isset($v8['way'])==true?$v8['way']:'';?></td>
                                    <td width="10%"><?php echo isset($v8['money'])==true?$v8['money']:'';?></td>
                                    <td width="20%"><?php echo isset($v8['remark'])==true?$v8['remark']:'';?></td>
                                    <td width="10%"><?php echo isset($v8['expert_name'])==true?$v8['expert_name']:'';?></td>
                                    <td width="10%"><?php echo isset($v8['depart_name'])==true?$v8['depart_name']:'';?></td>
                                    <td width="15%"><?php echo isset($v8['addtime'])==true?$v8['addtime']:'';?></td> 
                                    <td width="11%"><i></i><?php if($v8['status']=='0') echo '待经理提交';else if($v8['status']=='1') echo '待旅行社审核';else if($v8['status']=="2") echo "旅行社已通过";else if($v8['status']=='3') echo '旅行社已拒绝';else if($v8['status']=='4') echo '经理已拒绝';else if($v8['status']=='5') echo '待经理审核';else if($v8['status']=='6') echo '供应商拒绝'; ?></td>
                                  </tr>
                                  <?php if($v8['status']=='2') $total_sk+=$v8['money'];?>
                              <?php endforeach;?>
                             <?php endif;?>
                              
                                <tr class="zongji zongji1"><td colspan="8" style="text-align:right;"><span>总计：<i><?php echo sprintf("%.2f",$total_sk);?></i>元 </span></td></tr>
                            </tbody>
                        </table>                     
                    </div>
                    
                    
                   <!-- 成本账单（应付供应商） -->
                    <div class="table_list">
              <!--      <button class="apple_tuiding <?php // if($order['yj_lock']=="0") echo "add_cost";else echo "not_add_cost";?>"  onclick="add_supplier_cost(this);" style="margin-left:0;margin-bottom:0;">新增费用</button> -->

                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                   
                                    <th>项目</th>
                                    <th>备注</th>
                                    <th>单价</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                    <th>录入人</th>
                                    <th>录入时间</th>
                                    <th>审核状态</th>
                                </tr>
                            </thead>
                            <tbody class="yskr">
                             <?php $total_yf=0;if(!empty($order['yf'])):  //应付供应商   ?>
                              <?php foreach ($order['yf'] as $k=>$v):?>
                                  <tr class="<?php if($v['status']=='0'||$v['status']=='1') echo 'shenhe';else if($v['status']=='2') echo 'tongguo';else if($v['status']=='3'||$v['status']=='4') echo 'jujue'; ?>">    <!-- tongguo、shenhe、jujue -->
                                   
                                    <td width="15%"><?php echo isset($v['item'])==true?$v['item']:'';?></td>
                                    <td width="20%"><?php echo isset($v['remark'])==true?$v['remark']:'';?></td>
                                    <td width="8%"><?php echo isset($v['price'])==true?$v['price']:'';?></td>
                                    <td width="8%"><?php echo $v['num']+$v['oldnum']+$v['childnum']+$v['childnobednum'];?></td>
                                    <td width="8%"><?php echo isset($v['amount'])==true?$v['amount']:'';?></td> 
                                    <td width="8%"><?php echo isset($v['user_name'])==true?$v['user_name']:'';?></td>
                                    <td width="13%"><?php echo isset($v['addtime'])==true?$v['addtime']:'';?></td>
                                    <td width="10%"><i></i>
                                   	 <?php 
	                                   	if($v['status']=='0'){
	                                   		if($v['kind']==2){
	                                   			echo '待销售经理审核';	
	                                   		}else{
	                                   			if($v['user_type']=="1"){
                                                    //if($order['line_kind']=="1")  //非单项线路
	                                   				    echo "<a href='##' onclick='on_cost(".$v['id'].")' >通过</a>&nbsp;<a href='##' onclick='re_cost(".$v['id'].")'>拒绝</a>";
                                                    //else   //单项线路
                                                    	//echo "待供应商审核";
	                                   			}else{
	                                   				echo "待销售审核";
	                                   			}		
	                                   		}	
	                                   	}elseif($v['status']=="1"){ 
	                                   		if($v['user_type']=="1"){
	                                   			if($v['kind']==2){  //退团退人
	                                   				echo "<a href='##' onclick='confirm_order(".$v['id'].")' style='margin:0px'>通过</a>";
	                                   			}else{
                                                    // if($order['line_kind']=="1")   //非单项线路
	                                   				      $o_str="<a href='##' onclick='on_cost(".$v['id'].")' style='margin:0px' >通过</a> &nbsp;";
	                                   				      if($v['kind']==4){  //退团改价(不退人)
														  	  $o_str=$o_str."<a href='##' onclick='re_bill_order(".$v['id'].",".$v['kind'].")'>拒绝</a>";
														  }else{
														      $o_str=$o_str."<a href='##' onclick='re_cost(".$v['id'].")'>拒绝</a>";
														  }
														  echo $o_str;
                                                     //else   //单项线路
                                                     	// echo "待供应商审核";
	                                   			}
	                                   			
	                                   		}else{
	                                   			echo"待销售审核";	
	                                   		} 
	                                 	}elseif($v['status']=='2'){
	                                   		echo '已通过';	
	                                   	}elseif($v['status']=='3'||$v['status']=='4'){
	                                   		echo '已拒绝'; 
	                                   	} 
                                   	?>
                                    </td>
                                  </tr>
                                  <?php if($v['status']=='2') $total_yf+=$v['amount'];?>
                              <?php endforeach;?>
                             <?php endif;?>
                              
                                <tr class="zongji zongji1"><td colspan="9" style="text-align:right;"><span>总计：<i><?php echo sprintf("%.2f",$total_yf);?></i>元 </span></td></tr>
                            </tbody>
                        </table>                        
                    </div>
                      <!-- 平台佣金 -->
                    <div class="table_list">
						<div class="small_title_txt clear" style="border-bottom:0;padding-left:0;float:left;margin-top:10px;">
						
                             <button class="apple_tuiding <?php if($order['yj_lock']=="0") echo "add_cost";else echo "not_add_cost";?>" <?php //if($order['yj_lock']!="0") echo "disabled";?> onclick="add_manage_fee(this);" style="margin-left:0;margin-bottom:0;">平台佣金调整</button> 
                         
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th>项目</th>
                                    <th>备注</th>
                                    <th>单价</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                    <th>录入人</th>
                                    <th>录入时间</th>
                                    <th>审核状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_yj=0.00;if(!empty($order['yj'])):  //佣金   ?>
	                              <?php foreach ($order['yj'] as $k2=>$v2):?>
	                                  <tr class="<?php if($v2['status']=='0'||$v2['status']=="1") echo 'shenhe';else if($v2['status']=='2') echo 'tongguo';else if($v2['status']=='3'||$v2['status']=='4') echo 'jujue'; ?>">    <!-- tongguo、shenhe、jujue -->
	                                   <!--  <td width="10%"><i></i></td> -->
	                                    <td width="15%"><?php echo isset($v2['item'])==true?$v2['item']:'';?></td>
	                                    <td width="20%"><?php echo isset($v2['remark'])==true?$v2['remark']:'';?></td>
	                                    <td width="8%"><?php echo isset($v2['price'])==true?$v2['price']:'';?></td>
	                                    <td width="8%"><?php echo $v2['num'];?></td>
	                                    <td width="8%"><?php echo isset($v2['amount'])==true?$v2['amount']:'';?></td> 
	                                    <td width="8%"><?php echo isset($v2['user_name'])==true?$v2['user_name']:'';?></td>
	                                    <td width="13%"><?php echo isset($v2['addtime'])==true?$v2['addtime']:'';?></td>
	                                    <td width="10%"><i></i><?php if($v2['status']=='0') echo '申请中';else if($v2['status']=="1") echo "待旅行社审核";else if($v2['status']=='2') echo '已通过';else if($v2['status']=='3'||$v2['status']=='4') echo '已拒绝'; ?></td>
	                                  </tr>
	                                  <?php if($v2['status']=='2') $total_yj+=$v2['amount'];?>
	                              <?php endforeach;?>
                                <?php endif;?>
                                <tr class="zongji zongji2"><td colspan="9" style="text-align:right;"><span>总计：<i><?php echo sprintf("%.2f",$total_yj);?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                    </div>
                     <!-- 外交佣金 -->
                    <div class="table_list">
						<div class="small_title_txt clear" style="border-bottom:0;padding-left:0;float:left;margin-top:10px;">
						
                             <button class="apple_tuiding <?php if($order['wj_lock']=="0") echo "add_cost";else echo "not_add_cost";?>" <?php //if($order['wj_lock']!="0") echo "disabled";?> onclick="add_wj_fee(this);" style="margin-left:0;margin-bottom:0;">外交佣金调整</button> 
                         
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                  
                                    <th>项目</th>
                                    <th>备注</th>
                                    <th>单价</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                    <th>录入人</th>
                                    <th>录入时间</th>
                                    <th>审核状态</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_wj=0.00;if(!empty($order['wj'])):  //佣金   ?>
	                              <?php foreach ($order['wj'] as $k7=>$v7):?>
	                                  <tr class="tongguo">    <!-- tongguo、shenhe、jujue -->
	                                   
	                                    <td width="15%"><?php echo isset($v7['item'])==true?$v7['item']:'';?></td>
	                                    <td width="20%"><?php echo isset($v7['remark'])==true?$v7['remark']:'';?></td>
	                                    <td width="8%"><?php echo isset($v7['price'])==true?$v7['price']:'';?></td>
	                                    <td width="8%"><?php echo $v7['num'];?></td>
	                                    <td width="8%"><?php echo isset($v7['amount'])==true?$v7['amount']:'';?></td> 
	                                    <td width="8%"><?php echo isset($v7['user_name'])==true?$v7['user_name']:'';?></td>
	                                    <td width="13%"><?php echo isset($v7['addtime'])==true?$v7['addtime']:'';?></td>
	                                    <td width="10%"><i></i><?php if($v7['status']=='1') echo '已通过'; ?></td>
	                                  </tr>
	                                  <?php if($v7['status']=='1') $total_wj+=$v7['amount'];?>
	                              <?php endforeach;?>
                                <?php endif;?>
                                <tr class="zongji zongji3"><td colspan="9" style="text-align:right;"><span>总计：<i><?php echo sprintf("%.2f",$total_wj);?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                    </div>
                     <!-- 保险 -->
                    <div class="table_list">
						<table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th width="28%">项目</th>
                                  
                                    <th width="18%">金额</th>
                                    <th width="18%">数量</th>
                                    
                                    <th width="18%">小计</th>
                                    <th width="18%">录入时间</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if(!empty($order['bx'])):  //应付供应商保险   ?>
                              <?php foreach ($order['bx'] as $k4=>$v4):?>
                                <tr>
                                    <td><?php echo isset($v4['insurance_name'])==true?$v4['insurance_name']:'';?></td>
                                    <td><?php echo isset($v4['price'])==true?$v4['price']:'';?></td>
                                    <td><?php echo isset($v4['num'])==true?$$v4['num']:'';?></td>
                                    <td><?php echo isset($v4['amount'])==true?$v4['amount']:'';?></td>
                                    <td><?php echo isset($v4['addtime'])==true?$v4['addtime']:'';?></td>
                                </tr>
                                
                                <?php endforeach;?>
                              <?php endif;?>  
                                          
                            </tbody>
                        </table>
                    </div>
					<!-- 参团名单 -->
                    <div class="table_list">
						<table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>联系方式</th>
                                    <th>证件类型</th>
                                    <th>证件号</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if(!empty($order['visitor'])):?>
                               <?php foreach ($order['visitor'] as $k3=>$v3):?>
                                <tr>
                                    <td><?php echo isset($v3['name'])==true?$v3['name']:'';?></td>
                                    <td><?php echo isset($v3['telephone'])==true?$v3['telephone']:'';?></td>
                                    <td><?php echo isset($v3['typename'])==true?$v3['typename']:'';?></td>
                                    <td><?php echo isset($v3['certificate_no'])==true?$v3['certificate_no']:'';?></td>
                                </tr>
                                <?php endforeach;?>
                              <?php endif;?>                            
                            </tbody>
                        </table>
                    </div>
                   <!-- end -->
                   
  
                </div> 
            </div>       
                
        </div>        
        
    	<div class="close_page"><span class="layui-layer-close btn btn_close">关闭</span></div>
	</div>
</div>
   
</body>

</html>
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

		$(".btn_close").click(function(){
			t33_close_iframe_noreload();
		})

		//线路行程    on：用于绑定未创建内容
		$("body").on("click",".a_trip",function(){
			var line_id=$(this).attr("data-id");
			window.top.openWin({
			  title:"行程",
			  type: 2,
			  area: ['840px', '600px'],
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/t33/sys/line/trip');?>"+"?id="+line_id
			});
		});
		
	});
	function project_select(obj){
		var val = $(obj).val();
		if(val=="其他"){
			$(obj).hide();
			$(obj).siblings("input").show();
		}
	}
	//应收客人  新增费用
	function add_fee(obj){
		var str = '<tr class="add_fee"><td></td>';
			str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" class="other_obj"/></td>';
			str+= '<td><input type="text" class="beizhu"/></td>';
			str+= '<td><input type="text" class="danjia" style="width:80px;" onblur="check_danjia(this);"/></td>';
			str+= '<td><input type="text" class="shuliang" style="width:55px;" onblur="check_shuliang(this);"/></td>';
			str+= '<td class="total_money"></td>';
			str+= '<td>录入人</td>';
			str+= '<td><span class="save" onclick="save_add_fee(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
			
			$(".zongji1").before(str);
			
	}
	var my_date;
	//平台管理费  新增管理费
	function add_manage_fee(obj){
		var yj_lock="<?php echo $order['yj_lock'];?>";
		if(yj_lock=="1")  {tan("订单已核算，无法修改平台佣金");return false;}
		var employee_name="<?php echo $order['employee_name'];?>";
		my_date=getNowFormatDate();
		var str = '<tr class="add_fee">';
			str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" class="other_obj"/></td>';
			str+= '<td><input type="text" class="beizhu"/></td>';
			str+= '<td><input type="text" class="danjia" style="width:80px;" onkeyup="check_nember(this)" onblur="check_danjia(this);"/></td>';
			str+= '<td><input type="text" class="shuliang" style="width:55px;" onkeyup="check_nember2(this)" onblur="check_shuliang(this);"/></td>';
			str+= '<td class="total_money"></td>';
			str+= '<td>'+employee_name+'</td>';
			str+= '<td>'+my_date+'</td>';
			str+= '<td><span class="save" onclick="save_add_fee(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
			
			$(".zongji2").before(str);
			
	}
	//供应商成本
	/* function add_supplier_cost(obj){
	 	var html='<tr class="add_s_cost">';
	 	html+='<td width="10%"><i></i></td>';
	 	html+= '<td width="12%" ><select class="project_select" onchange="project_select(this);"><option value="成人价">成人价</option><option value="小孩占床">小孩占床</option><option value="小孩不占床">小孩不占床</option><option value="老人价">老人价</option><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" class="other_obj"/></td>';
		html+= '<td width="15%" ><input type="text" class="beizhu" "style="width:60px;"/></td>';
	 	html+='<td width="8%"><input type="text" class="danjia" style="width:50px;" onblur="check_danjia(this);"/></td>';
	 	html+=' <td width="8%"><input type="text" class="shuliang" style="width:50px;" onblur="check_shuliang(this);"/></td>';
	 	html+='<td width="8%"></td>';
	 	html+= '<td  width="8%" class="total_money" ></td>';
                     html+= '<td  width="13%"></td>';
		html+= '<td width="10%"><span class="save" onclick="save_supplier_cost(this);" style="margin-left: 10px;">保存</span><span class="cancle" onclick="cancle_supplier_cost(this);">取消</span></td></tr>';
	 	html+=" </tr>";

	 	$(".zongji1").before(html);
	 		
	 }*/
	 //通过成本价修改
	 function on_cost(bill_id){
	 	var orderid="<?php if(!empty($order['id'])){ echo $order['id'];}else{ echo 0;}?>";
	        /*  $.post( "<?php //echo site_url('admin/t33/sys/order/save_tuituan_order')?>", {
	                'orderid':orderid,
	                'bill_id':bill_id,
	          },
	          function(data) {
	                data = eval('('+data+')');
	                if(data.status==1){
	                     //  alert(data.msg);
                         layer.msg(data.msg, {icon: 1});
	                     window.location.reload();
	                }else{
	                         
                         layer.msg(data.msg, {icon: 2});
                         window.location.reload();
	               }             
	          })*/

	    	  jQuery.ajax({ type : "POST",async:false,data : { 'bill_id':bill_id,'orderid':orderid},url : "<?php echo base_url()?>admin/t33/sys/order/save_tuituan_order", 
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
				        	// alert(data.msg)
				        	 tan(data.msg);;
				         } 
			       }
			  });
	 }
	 //拒绝成本价的修改
	function re_cost(bill_id){  
	      var orderid="<?php if(!empty($order['id'])){echo $order['id'];}else{ echo 0;} ?>";

    	  jQuery.ajax({ type : "POST",async:false,data : { 'bill_id':bill_id,'orderid':orderid},url : "<?php echo base_url()?>admin/t33/sys/order/refuse_oderprice", 
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
			        	// alert(data.msg)
			        	 tan(data.msg);;
			         } 
		       }
		  });
	}

	//外交佣金  新增外交佣金
	function add_wj_fee(obj){
		var wj_lock="<?php echo $order['wj_lock'];?>";
		if(wj_lock=="1")  {tan("订单已核算，无法修改外交佣金");return false;}
		
		var employee_name="<?php echo $order['employee_name'];?>";
		my_date=getNowFormatDate();
		var str = '<tr class="add_fee">';
			str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" class="other_obj"/></td>';
			str+= '<td><input type="text" class="beizhu"/></td>';
			str+= '<td><input type="text" class="danjia" style="width:80px;" onkeyup="check_nember(this)" onblur="check_danjia(this);"/></td>';
			str+= '<td><input type="text" class="shuliang" style="width:55px;" onkeyup="check_nember2(this)" onblur="check_shuliang(this);"/></td>';
			str+= '<td class="total_money"></td>';
			str+= '<td>'+employee_name+'</td>';
			str+= '<td>'+my_date+'</td>';
			str+= '<td><span class="save" onclick="save_add_wj(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
			
			$(".zongji3").before(str);
			
	}
	/*当前时间*/
	function getNowFormatDate() {
	    var date = new Date();
	    var seperator1 = "-";
	    var seperator2 = ":";
	    var month = date.getMonth() + 1;
	    var strDate = date.getDate();
	    if (month >= 1 && month <= 9) {
	        month = "0" + month;
	    }
	    if (strDate >= 0 && strDate <= 9) {
	        strDate = "0" + strDate;
	    }
	    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
	            + " " + date.getHours() + seperator2 + date.getMinutes()
	            + seperator2 + date.getSeconds();
	    return currentdate;
	}
	/*正则：正数、负数、小数  */
	function check_nember(obj){
		var value=$(obj).val();
		value=value.replace(/[^\- \d.]/g,'');  //   ;  /[^\- \d.]/g  正数、负数、小数 ;   /[^\d]/g   只能正数、小数 ;  
		$(obj).val(value);
	}
	/*正则：正数、小数  */
	function check_nember2(obj){
		var value=$(obj).val();
		value=value.replace(/[^\d]/g,'');  //   ;  /[^\- \d.]/g  正数、负数、小数 ;   /[^\d]/g   只能正数、小数 ;  
		$(obj).val(value);
	}
	//检测单价
	function check_danjia(obj){
		
		var price = $(obj).val()||0;
		var num = $(obj).parent().siblings("td").find(".shuliang").val()||0;
		var total;
		total = price*num;	
		$(obj).parent().siblings(".total_money").html(total);
	}
	//检测数量
	function check_shuliang(obj){
		
		var num = $(obj).val();
		var price = $(obj).parent().siblings("td").find(".danjia").val();
		var total;
		total = price*num;	
		$(obj).parent().siblings(".total_money").html(total);
	}
	//保持平台佣金调整
	function save_add_fee(obj){
		var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
		var project = $(obj).parent().siblings("td").find(".project_select").val();
		var price = $(obj).parent().siblings("td").find(".danjia").val();
		var num = $(obj).parent().siblings("td").find(".shuliang").val();
		var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
		var order_id="<?php echo $order['id'];?>";
		var last_project=project;
		if(project=="其他"){
			var other_obj = $(".other_obj").val();
			if(other_obj.length<=0){
				tan("请填写项目名称");
				$(obi).parent().siblings("td").find(".other_obj").focus();
				return false;
			}
			last_project=other_obj;
		}
		/* if(beizhu==""){
			tan("请填写备注");
			$(obj).parent().siblings("td").find(".beizhu").focus();
			return false;
		} */
		if(price.length==0){
			tan("请填写单价");
			$(obj).parent().siblings("td").find(".danjia").focus();
			return false;
		}
		if(num.length<=0){
			tan("请填写数量");
			$(obj).parent().siblings("td").find(".danjia").focus();
			return false;
		}

		$.ajax({
			 url:"<?php echo base_url('admin/t33/sys/order/update_platform_fee');?>",
        	 type:"POST",
             data:{order_id:order_id,project:last_project,price:price,num:num,beizhu:beizhu,my_date:my_date},
             async:true,
             dataType:"json",
             success:function(data){
            	 if(data.code=="2000")
            	 {
                	 var employee_name="<?php echo $order['employee_name'];?>";
                	 $(obj).parent().parent().addClass("tongguo");
                	 //$(".add_fee td:eq(0)").html("<i></i>");
                	 $(obj).parent().parent().find("td:eq(0)").html(last_project);
                	 $(obj).parent().parent().find("td:eq(1)").html(beizhu);
                	 $(obj).parent().parent().find("td:eq(2)").html(price);
                	 $(obj).parent().parent().find("td:eq(3)").html(num);
                	 $(obj).parent().parent().find("td:eq(4)").html(num*price);
                	 $(obj).parent().parent().find("td:eq(5)").html(employee_name);
                	 $(obj).parent().parent().find("td:eq(7)").html("<i></i>已通过");
                 }
            	 else
            	 {
                	 tan(data.msg);
                 }
             },
             error:function(data){
             }
			})
    	}
	}
	//保存外交佣金调整
	function save_add_wj(obj){
		var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
		var project = $(obj).parent().siblings("td").find(".project_select").val();
		var price = $(obj).parent().siblings("td").find(".danjia").val();
		var num = $(obj).parent().siblings("td").find(".shuliang").val();
		var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
		var order_id="<?php echo $order['id'];?>";
		var last_project=project;
		if(project=="其他"){
			var other_obj = $(".other_obj").val();
			if(other_obj.length<=0){
				tan("请填写项目名称");
				$(obi).parent().siblings("td").find(".other_obj").focus();
				return false;
			}
			last_project=other_obj;
		}
		/* if(beizhu==""){
			tan("请填写备注");
			$(obj).parent().siblings("td").find(".beizhu").focus();
			return false;
		} */
		if(price.length==0){
			tan("请填写单价");
			$(obj).parent().siblings("td").find(".danjia").focus();
			return false;
		}
		if(num.length<=0){
			tan("请填写数量");
			$(obj).parent().siblings("td").find(".danjia").focus();
			return false;
		}

		$.ajax({
			 url:"<?php echo base_url('admin/t33/sys/order/update_wj');?>",
        	 type:"POST",
             data:{order_id:order_id,project:last_project,price:price,num:num,beizhu:beizhu,my_date:my_date},
             async:true,
             dataType:"json",
             success:function(data){
            	 if(data.code=="2000")
            	 {
                	 var employee_name="<?php echo $order['employee_name'];?>";
            		 $(obj).parent().parent().addClass("tongguo");
            		 $(obj).parent().parent().find("td:eq(0)").html(last_project);
            		//$(obj).parent().parent().find("td:eq(0)").html("<i></i>");
            		 $(obj).parent().parent().find("td:eq(1)").html(beizhu);
            		 $(obj).parent().parent().find("td:eq(2)").html(price);
            		 $(obj).parent().parent().find("td:eq(3)").html(num);
            		 $(obj).parent().parent().find("td:eq(4)").html(num*price);
            		 $(obj).parent().parent().find("td:eq(5)").html(employee_name);
            		 $(obj).parent().parent().find("td:eq(7)").html("<i></i>已通过");
                	 
                	  
                 }
            	 else
            	 {
                	 tan(data.msg);
                 }
             },
             error:function(data){
             }
			})
    	}
	}
	//已收款  新增成本  保存
	function save_add_fee2(obj){
		var jine = $(obj).parent().siblings("td").find(".jine").val();
		var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
		var jkfs = $(obj).parent().siblings("td").find(".jkfs").val();

		if(jine.length==0){
			alert("请填写金额");
			$(obj).parent().siblings("td").find(".jine").focus();
			return false;
		}
		if(beizhu.length==0){
			alert("请填写备注");
			$(obj).parent().siblings("td").find(".beizhu").focus();
			return false;
		}
		if(jkfs.length<=0){
			alert("请填写交款方式");
			$(obj).parent().siblings("td").find(".jkfs").focus();
			return false;
		}
	}
	//取消
	function cancle_add_fee(obj){
		$(obj).parent().parent().remove();
	}
	//取消
	function cancle_supplier_cost(obj){
		$(obj).parent().parent().remove();
	}
	
	//付款申请
	function add_payable(){
		var orderid="<?php echo $order['id'];?>";
		window.top.openWin({
		  title:"申请预付款",
		  type: 2,
		  area: ['840px', '600px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/get_payable');?>"+"?orderid="+orderid
		});
	}

	//单项退团拒绝(不退人)
	function re_bill_order(bill_id,kind){
		
		 var orderid='<?php if(!empty($order['id'])){ echo $order['id'];}else{echo 0;}?>';

	     jQuery.ajax({ type : "POST",async:false,data : { 'orderid':orderid,'bill_id':bill_id},url : "<?php echo base_url()?>admin/t33/sys/order/refuse_order_bill", 
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
	}
	//确认订单退团退人
	function confirm_order(bill_id){  		
		   var orderid='<?php if(!empty($order['id'])){ echo $order['id'];}else{echo 0;}?>';
		   jQuery.ajax({ type : "POST",async:false,data : { 'bill_id':bill_id,'orderid':orderid},url : "<?php echo base_url()?>admin/t33/sys/order/save_confirm_order", 
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

	}
</script>

