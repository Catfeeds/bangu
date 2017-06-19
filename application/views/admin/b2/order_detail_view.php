<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/b2b_order_detail.css');?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/v2/b2_base.css');?>">
<style type="text/css">
*{"tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif" !important}
h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, img, ol, p{ font-family: "微软雅黑";}
input, textarea {padding-left: 0px;}
.jingwaide_Table{width:1053px;}
.people_type{width:95px;}
.xdsoft_datetimepicker{z-index: 111111111;}
.page-body{ width: 1200px; margin: 0 auto !important;background:#fff;}
.current_page{ width: 1200px; height: 40px;line-height: 40px; margin: 0 auto; position: relative; z-index: 1;padding-left:0;}
.order_info_table{border-color: #ddd;border: 1px solid #ddd;}
.table_td_border>tbody>tr>td {border: 1px solid #e0e0e0 !important;}
.small_title_txt{border-bottom:none;}
.itab{ width: 100%;height:31px;line-height: 30px; position: relative; border-bottom:1px solid #ddd;}
.itab ul{ float: left; overflow: hidden;height:30px;line-height: 30px;position:relative;top:2px;}
.itab ul li{ float: left; padding: 0 15px;box-sizing:border-box;background:#eaedf1;}
.itab ul li.active { border-top: 2px solid  #09c; border-left: 1px solid #ddd; border-right: 1px solid #ddd; background: #fff;}
.itab ul li.active a { color:#333;}
.itab ul li a{ height: 100%; width: 100%; display: inline-block;  text-align: center; color: #777;}

.tab_content{ box-shadow: none; border:1px solid #ddd ;border-top:0;}
.table-bordered>thead>tr>td{ border-bottom: none;}.
.table-bordered>tbody>tr>td  border: 1px solid #ddd !important; }
.fc-border-separate thead tr, .table thead tr{ background-image: none; background: #fff;}
.thisatble tbody tr td{  padding: 0;}
.thisatble tbody tr td label input{ margin-top: 13px;}
.table thead tr { background: #fff;}
.btn_blue,.btn_blue:hover{ background: #09c !important; color: #fff;;}
.adultsNum{ margin-top: 3px;}
#sure_submit{ background: #09c !important; color: #fff;border: none; border-radius: 2px;}
.bens{ background: #09c; outline: none; border: none; color: #fff;border-radius: 2px; padding: 5px 8px !important;}
.trip_day_title{ overflow: hidden;}
.trip_every_day{ background: #fff; margin-bottom: 20px;}
.current_page{ width: 1200px; border-bottom: 0;}
.trip_content_right img{ padding:0 5px;}
.layui-layer-content{ border-top:10px soldi #fff; border-right:10px soldi #fff}

.order_detail { padding:10px 10px 100px 10px;margin-top:3px;}

.small_title_txt { padding-top:10px;}
.table_list button { margin-top:10px;}
.small_title_txt .txt_info { line-height:40px;}
#add_trip_info{ overflow-y: auto; max-height: 600px;}
.jingwaide_Table ul li input{ height:24px; line-height:24px;}
.jingwaide_Table ul li{overflow: hidden;}

#edit_travel_form input{padding:2px 0;margin:5px 0;height:24px;line-height:24px;font-size:12px;}
#edit_travel_form select{width:80px;color:#000000;}
#edit_travel_form .btn_edit_people{padding:3px 12px;}

#div_contract{float:right;width:77%;}
#div_invoice{float:right;width:71%;}
.tab_del{border:1px solid #2a6496;height:20px;padding:0 4px;}
.tab_del b {cursor:pointer;margin:0 4px;display:inline-block; width:12px; height:2px; background:#f00; font-size:0; line-height:0;vertical-align:middle;-webkit-transform: rotate(45deg);}
.tab_del b:after { content:'.'; display:block; width:12px; height:2px; background:#f00;-webkit-transform: rotate(-90deg);}

</style>

<?php $this->load->view("admin/b2/common/js_view"); //加载公用css、js   ?>
	<div class="current_page shadow" style="border-bottom:none">您的位置：
        <a href="#" class="main_page_link"><i></i>主页</a>
        <span class="right_jiantou">&gt;</span>
        <a href="#">订单信息</a>
    </div>
    <!--=================右侧内容区================= -->
    <div class="page-body w_1200 shadow" id="bodyMsg">
        <!-- ===============我的位置============ -->


        <!-- ===============订单详情============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt"><?php echo $order_detail_info['line_name']?></h2>

            <!-- ===============基础信息============ -->
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                    <span class="order_time fr"><?php echo $order_detail_info['addtime']?></span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="30">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="3"><?php echo $order_detail_info['line_name']?><a href="javascript:void(0);" line_id="<?php echo $order_detail_info['lineid']?>" class="see_trip">【查看行程】</a></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">订单编号:</td>
                        <td><?php echo $order_detail_info['line_sn']?></td>
                         <td class="order_info_title">团号:</td>
                        <td ><?php echo $order_detail_info['item_code'];?></td>

                    </tr>
                    <tr height="30">
                        <td class="order_info_title">订单状态:</td>
                        <td><?php echo $order_detail_info['status']?></td>
                        <td class="order_info_title">支付状态:</td>
                        <td><?php echo $order_detail_info['ispay']?></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">参团人数:</td>
                        <td style="width:45%;">
                             <?php if($order_detail_info['unit']>=2):?>
                                    <span><?php echo $order_detail_info['suitname']?></span>&nbsp;&nbsp;
                                    <span><?php echo $order_detail_info['dingnum'].'/'.$order_detail_info['unit'].'人份'?> </span>&nbsp;&nbsp;
                                    <span><?php echo $order_detail_info['suitnum'].'*'.$order_detail_info['ding_price']?></span>
                                <?php else:?>
                                    <span>成人:&nbsp;(<?php if(!empty($order_detail_info['dingnum'])){ echo $order_detail_info['dingnum'].' 人'; }else{echo '0 人';}?>)</span>&nbsp;&nbsp;
                                        <span> 小童占床:&nbsp;(<?php if(!empty($order_detail_info['children'])){echo $order_detail_info['children'].' 人';}else{ echo '0 人';}?>)</span>&nbsp;&nbsp;
                                     <span>小童不占床:&nbsp;(<?php if(!empty($order_detail_info['childnobednum'])){echo $order_detail_info['childnobednum'].' 人';}else{ echo '0 人';}?>)</span>&nbsp;&nbsp;
                                        <span> 老人:&nbsp;(<?php if(!empty($order_detail_info['oldnum'])){echo $order_detail_info['oldnum'].' 人';}else{ echo '0 人';}?>)</span>
                                <?php endif;?>
                        </td>
                        <td class="order_info_title">已收款:</td>
                        <td><?php echo !empty($order_detail_info['total_receive_amount']) ? $order_detail_info['total_receive_amount'] : 0;?></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">订单金额:</td>
                        <td ><?php echo $order_detail_info['order_price']+$order_detail_info['settlement_price']?></td>
                        <td class="order_info_title">未收款:</td>
                        <td > <?php echo $order_detail_info['total_price']-$order_detail_info['total_receive_amount'];?></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">保险费用:</td>
                        <td >￥<?php if(!empty($order_detail_info['settlement_price'])){ echo $order_detail_info['settlement_price'];}else{ echo '0';}?></td>
                        <td class="order_info_title">出发日期:</td>
                        <td><?php echo $order_detail_info['usedate']?></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">应付供应商:</td>
                        <td><?php echo $order_detail_info['supplier_cost']?></td>
                        <td class="order_info_title">已付供应商:</td>
                        <td><?php echo $order_detail_info['balance_money']?></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">管家:</td>
                        <td><?php echo $order_detail_info['expert_name']?>/<?php echo $order_detail_info['expert_mobile'];?></td>
                        <td class="order_info_title">供应商:</td>
                        <td><?php echo $order_detail_info['company_name'];?>（<span style="color: #428BEA"><?php echo $supplier[0]['linkman'];?>/<?php echo $supplier[0]['link_mobile'];?></span>）</td>
                    </tr>
                    <tr height="30">
                    	<td class="order_info_title">预定人:</td>
                        <td colspan="3"><?php echo $order_detail_info['linkman'];?>&nbsp;&nbsp;&nbsp;联系电话：<?php echo $order_detail_info['linkmobile'];?> &nbsp;&nbsp;&nbsp;备用电话:<?php echo empty($order_detail_info['spare_mobile'])?'无':$order_detail_info['spare_mobile'];?>&nbsp;&nbsp;&nbsp;邮箱:<?php echo $order_detail_info['link_email'];?>&nbsp;&nbsp;&nbsp;备注:<?php echo empty($order_detail_info['remark'])?'无': $order_detail_info['remark'];?></td>
                    </tr>
                    <?php if($order_detail_info['order_type']=='1'):?>
                       <tr height="30">
                           <td class="order_info_title">合同编号:</td>
                           <td colspan="3">
                           <input type="text" id="contract_sn" name="contract_sn" value=""/>
                           <a style="top:0px;margin-right:10px;" class="apple_tuiding bens" data-orderid="<?php echo $order_detail_info['id'];?>" onclick="add_contract(this)">新增合同</a>
                            <div id="div_contract">
                             <?php if(!empty($use_contract))://纸质合同 ?>
                                 <?php foreach ($use_contract as $k=>$v):?>
                                    <label class="tab_del contract_label"><?php echo $v['contract_code'];?>
                                     <?php if($v['confirm_status']!='2'):?>
                                    <b data-type="1" data-id="<?php echo $v['id'];?>"></b>
                                    <?php endif;?>
                                    </label>
                                 <?php endforeach;?>
                             <?php endif;?>
                             
                             <?php if(!empty($use_online_contract))://在线合同 ?>
                                 <?php foreach ($use_contract as $k=>$v):?>
                                    <label class="tab_del contract_label"><?php echo $v['contract_code'];?>
                                     <?php if($v['status']!='3'):?>
                                    <b data-type="2" data-id="<?php echo $v['id'];?>"></b>
                                    <?php endif;?>
                                    </label>
                                 <?php endforeach;?>
                             <?php endif;?>
                            </div>
                           </td>
                       </tr>
                       <?php endif;?>


                        <tr height="30">
                           <td class="order_info_title">收据/发票:</td>
                           <td colspan="3">
                               <select name="select_invoice_receipt" id="select_invoice_receipt">
                                    <option value="">--请选择--</option>
                                    <option value='1'>发票</option>
                                    <option value='2'>收据</option>
                               </select>
                               <input type="text" id="invoice_receipt_sn" name="invoice_receipt_sn" value=""/>
                               <a style="top:0px" class="apple_tuiding bens" data-orderid="<?php echo $order_detail_info['id'];?>" onclick="add_invoice_receipt(this)">新增</a>
                               
                              <div id="div_invoice">
                              
                                <?php if(!empty($use_invoice))://发票 ?>
                                 <?php foreach ($use_invoice as $k=>$v):?>
                                    <label class="tab_del invoice_label">发票：<?php echo $v['invoice_code'];?>
                                     <?php if($v['confirm_status']!='2'):?>
                                    <b data-type="1" data-id="<?php echo $v['id'];?>"></b>
                                    <?php endif;?>
                                    </label>
                                 <?php endforeach;?>
                                <?php endif;?>
                                
                                <?php if(!empty($use_receipt))://收据 ?>
                                <?php foreach ($use_receipt as $k=>$v):  ?>
                                    <label class="tab_del invoice_label">收据：<?php echo $v['receipt_code'];?>
                                     <?php if($v['confirm_status']!='2'):?>
                                    <b data-type="2" data-id="<?php echo $v['id'];?>"></b>
                                    <?php endif;?>
                                    </label>
                                 <?php endforeach;?>
                                <?php endif;?>
                                </div>
                           </td>
                       

                </table>
            </div>

            <div class="table_con">
                <div class="itab">
                    <ul>
                        <li status="1" class="active"><a href="###" >应收客人</a></li>
                         <?php if($order_detail_info['diplomatic_agent']>0):?>
                            <li status="2"><a href="###">外交佣金</a></li>
                        <?php endif;?>
                         <?php if($order_detail_info['status_opera']!=2 && $order_detail_info['status_opera']!=3 || $order_detail_info['status_opera']!=10 || $order_detail_info['status_opera'] !=11):?>
                             <li status="3"><a href="###">应付供应商</a></li>
                        <li status="4"><a href="###">已收款</a></li>
                        <?php endif;?>


                        <!-- <li status="5"><a href="###">平台管理费</a></li> -->
                    </ul>
                </div>
                <div class="tab_content">

                <!--***********************************Start应收客人****************************************-->
                    <div class="table_list" style="display:block;">
                            <?php if($order_detail_info['status_opera']==2 || $order_detail_info['status_opera']==3 || $order_detail_info['status_opera']==10 || $order_detail_info['status_opera']==11 || $order_detail_info['status_opera']==-4 || empty($travels_people)  /*|| $order_detail_info['balance_complete']==2 || $order_detail_info['ys_lock']==1 || $order_detail_info['yj_lock']==1 || $order_detail_info['wj_lock']==1*/):?>
                            <button style="margin-right:10px;background:#808080"" class="bens" >调整应收</button>
                        <?php else:?>
                          <button style="margin-right:10px;" class="bens" onclick="add_fee(this);">调整应收</button>
                        <?php endif;?>
                         <?php if($apply_limit_zhong['credit_limit']>0):?>
                              <a href='javascript:void(0)' onclick="cancle_apply(this);" order-id="<?php echo $order_id; ?>" expert-id="<?php echo $userid;?>" style="margin:0 0 0 4px;">取消额度审批</a>
                          <?php endif;?>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th align="center" width="30">状态</th>
                                    <th align="center" width="90">项目</th>
                                    <th align="center">备注</th>
                                    <th align="center" width="70">单价</th>
                                    <th align="center" width="30">数量</th>
                                    <th align="center" width="70">小计</th>
                                    <th align="center" width="98">录入时间</th>
                                    <th align="center" width="98">录入人</th>
                                </tr>
                            </thead>
                            <tbody id="ys_data_list">
                            <?php if(!empty($ys_data)):?>
                                <?php foreach($ys_data AS $val):?>
                                    <?php if($val['status']==3):?>
                                        <tr class="jujue">
                                    <?php elseif($val['status']==1):?>
                                        <tr class="tongguo">
                                    <?php else:?>
                                        <tr class="shenhe">
                                    <?php endif;?>

                                    <td style="width:70px;"><i></i> <?php if($val['status']=='0') echo '审核中';else if($val['status']=="1") echo "已通过";else if($val['status']=='3') echo '已拒绝';?></td>
                                    <td align="center"><?php echo $val['item']?></td>
                                    <td align="center"><?php echo $val['remark']?></td>
                                    <td align="center"><?php echo $val['price']?></td>
                                    <td align="center"><?php echo $val['num']?></td>
                                    <td align="center"><?php echo $val['amount']?></td>
                                    <td align="center"><?php echo $val['addtime']?></td>
                                    <td align="center"><?php echo $val['e_name']?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                                <tr class="zongji zongji1"><td colspan="8" style="text-align:right;"><span>总计：<i><?php echo $sum_ys?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                        <div class="small_title_txt clear" style="margin-bottom:10px;padding-left:0;margin-top:20px;">
                            <span class="txt_info fl">参团名单</span>
                            <!-- 申请退订  按钮 -->
                              <?php if((empty($travels_people)&&$sum_ys==0) || $order_detail_info['status_opera']==2 || $order_detail_info['status_opera']==3  || $order_detail_info['status_opera']==10 || $order_detail_info['status_opera']==11 || /*$order_detail_info['status_opera']==-3 ||*/ $order_detail_info['status_opera']==-4 || $order_detail_info['balance_complete']==2/* || $order_detail_info['ys_lock']==1*/):?>
                                   <button class="apple_tuiding bens" style="margin-bottom:0;margin-left:20px;background:#808080">申请退订</button>
                              <?php else:?>
                                   
                                   <?php if(($order_detail_info['status_opera']==-3&&$sum_ys>0) || $order_detail_info['status_opera']==4 || $order_detail_info['status_opera']==5 || $order_detail_info['status_opera']==6 ||  $order_detail_info['status_opera']==7 ||  $order_detail_info['status_opera']==8):?>
                                        <button class="apple_tuiding bens" onclick="apply_tuiding(this);" style="margin-bottom:0;">申请退订</button>
                                   <?php else:?>
                                        <button class="apple_tuiding bens" style="margin-bottom:0;margin-left:20px;background:#808080">申请退订</button>
                                   <?php endif;?>
                             <?php endif;?>
                           <!-- 添加参团人  按钮 -->
                              <?php if(empty($travels_people) || $lineData['status'] !=2 || $order_detail_info['status_opera']==2 || $order_detail_info['status_opera']==3  || $order_detail_info['status_opera']==10 || $order_detail_info['status_opera']==11 || $order_detail_info['status_opera']==-3 || $order_detail_info['status_opera']==-4 || $order_detail_info['balance_complete']==2/* || $order_detail_info['ys_lock']==1*/):?>
                                   <button class="apple_tuiding bens"  style="margin-bottom:0;margin-left:20px;background:#808080">添加参团人</button>
                              <?php else:?>
                                   <button class="apple_tuiding bens" onclick="add_people(this);" style="margin-bottom:0;margin-left:20px;">添加参团人</button>
                              <?php endif;?>
                        </div>
                        <table class="table table-bordered table_hover thisatble">
                            <thead>
                                <tr>
                                    <td align="center" width="35"><input type="checkbox" name="choose_all" id="choose_all" value="" onclick="choose_all(this)"/></td>
                                    <td align="center">姓名</td>
                                    <td align="center">证件号码</td>
                                    <td align="center">手机号码</td>
                                    <td align="center">性别</td>
                                    <td align="center">类型</td>
                                     <td align="center">操作</td>
                                 </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($travels_people)):?>
                                <?php foreach($travels_people AS $item):?>
                                <tr>
                                    <td>
                                    <label style="width:100%;height:100%;">
                                        <input data-cost="<?php echo $item['cost']?>" data-price="<?php echo $item['price']?>" type="checkbox" data-role="traver_id" name="traver_id[]" value="<?php echo $item['id']?>"/>
                                    </label>
                                    </td>
                                    <td height="30" align="center"><?php echo $item['name']?></td>
                                    <td height="30" align="center"><?php echo $item['certificate_no']?></td>
                                    <td height="30" align="center"><?php echo $item['telephone']?></td>
                                     <?php if($item['sex']==1):?>
                                     <td height="30" align="center">男</td>
                                     <?php elseif($item['sex']==2):?>
                                     <td height="30" align="center">保密</td>
                                    <?php else:?>
                                     <td height="30" align="center">女</td>
                                    <?php endif;?>
                                     <?php if($item['people_type']==1):?>
                                    <td height="30" align="center">成人</td>
                                    <?php elseif($item['people_type']==2):?>
                                   <td height="30" align="center">老人</td>
                                    <?php elseif($item['people_type']==3):?>
                                    <td height="30" align="center">儿童占床</td>
                                    <?php else:?>
                                    <td height="30" align="center">儿童不占床</td>
                                    <?php endif;?>
                                    <td height="30" align="center"><a style="margin-left: 0px" class="apple_tuiding"  data-id="<?php echo $item['id']?>" onclick="edit_travel(this)">修改</a></td>
                                    </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                            </tbody>

                        </table>
                    </div>
                    <!--***********************************End应收客人****************************************-->

                    <!--***********************************Start外交佣金****************************************-->
                    <?php if($order_detail_info['diplomatic_agent']>0):?>
                     <div class="table_list" >
                        <!-- <button onclick="add_commission(this);" class="bens">佣金调整</button> -->
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <!-- <th align="center" width="30">状态</th> -->
                                    <th align="center" width="90">项目</th>
                                    <th align="center">备注</th>
                                    <th align="center" width="70">单价</th>
                                    <th align="center">数量</th>
                                    <th align="center" width="70">小计</th>
                                    <th align="center" width="120">录入人</th>
                                </tr>
                            </thead>
                            <tbody class="yskr" id="diplomatic_agent_list">
                               <?php if(!empty($commission_data)):?>
                                <?php foreach($commission_data AS $val):?>
                                  <!--   <?php if($val['status']==2):?>
                                      <tr class="jujue">
                                  <?php elseif($val['status']==1):?>
                                      <tr class="tongguo">
                                  <?php else:?>
                                      <tr class="shenhe">
                                  <?php endif;?>
                                  <td><i></i></td> -->
                                  <tr>
                                    <td><?php echo $val['item']?></td>
                                    <td><?php echo $val['remark']?></td>
                                    <td><?php echo $val['price']?></td>
                                    <td><?php echo $val['num']?></td>
                                    <td><?php echo $val['amount']?></td>
                                    <td><?php echo $val['user_name']?></td>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                                <tr class="zongji zongji1"><td colspan="8" style="text-align:right;" id="sum_diplomatic_agent"><span>总计：<i><?php echo $sum_commission?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif;?>
                    <!--***********************************End 外交佣金****************************************-->

                    <!--***********************************Start应付专线供应商****************************************-->
	       <div class="table_list">
                        <div class="small_title_txt clear" style="border-bottom:0;padding-left:0;">
                        	<span class="txt_info fl">应付专线供应商</span>
                        	 <?php if( $order_detail_info['status_opera']==-4 || empty($travels_people) ):?>
                              <button class="apple_tuiding add_cost bens" style="margin-bottom:0;margin-left:20px;background:#808080">调整应付</button>
                        	<?php else:?>
                              <button class="apple_tuiding add_cost bens" onclick="add_cost(this);" style="margin-bottom:0;">调整应付</button>
                        	<?php endif;?>


                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th align="center" width="30">状态</th>
                                    <th align="center" width="90">项目</th>
                                    <th align="center">备注</th>
                                    <th align="center" width="70">单价</th>
                                    <th align="center">数量</th>
                                    <th align="center" width="70">小计</th>
                                    <th align="center" width="98">新增时间</th>
                                    <th align="center" width="98">录入人</th>
                                    <th align="center" width="120">操作</th>

                                </tr>
                            </thead>
                            <tbody id="yf_data_list">
                                <?php if(!empty($yf_data)):?>
                                <?php foreach($yf_data AS $val):?>
                                    <?php if($val['status']==4 || $val['status']==3):?>
                                        <tr class="jujue">
                                    <?php elseif($val['status']==2):?>
                                        <tr class="tongguo">
                                    <?php else:?>
                                        <tr class="shenhe">
                                    <?php endif;?>
                                    <td><i></i></td>
                                    <td><?php echo $val['item'];?></td>
                                    <td><?php echo $val['remark'];?></td>
                                    <td><?php echo $val['price'];?></td>
                                    <td><?php echo $val['num'];?></td>
                                    <td><?php echo $val['amount'];?></td>
                                    <td><?php echo $val['addtime'];?></td>
                                    <td><?php echo $val['user_name'];?></td>
                                     <?php if( $val['user_type']==2 && $val['status']==0):?>
                                     <td>
                                     <a data-id="<?php echo $val['id']?>" data-order="<?php echo $val['order_id']?>" onclick="pass_b1(this)">通过</a>
                                     <a data-id="<?php echo $val['id']?>" data-order="<?php echo $val['order_id']?>" onclick="refuse_b1(this)">拒绝</a>
                                     </td>
                                        <?php else:?>
                                        <td></td>
                                    <?php endif;?>
                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                                <tr class="zongji zongji2"><td colspan="9" style="text-align:right;"><span>总计：<i><?php echo $sum_yf;?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                        <div class="small_title_txt clear" style="border-bottom:0;padding-left:0;">
                            <span class="txt_info fl">保险明细</span>
                        </div>
                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th align="center">保险名称</th>
                                    <th align="center">保险公司</th>
                                    <th align="center">保险期限</th>
                                    <th align="center">数量</th>
                                    <th align="center">金额</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($order_insurance)):?>
                        <?php foreach($order_insurance AS $item):?>
                          <tr>
                                <td align="center"><?php echo $item['insurance_name']?></td>
                                <td align="center"><?php echo $item['insurance_company']?></td>
                                <td align="center"><?php echo $item['insurance_date'].'天'?></td>
                                <td align="center"><?php echo $item['number']?></td>
                                <td align="center"><?php echo sprintf("%.2f", $item['amount']/$item['number']);?></td>
                        </tr>
                      <?php endforeach;?>
                  <?php endif;?>
                            </tbody>
                        </table>
                    </div>
                    <!--***********************************End应付专线供应商****************************************-->

                    <!--***********************************Start已收款****************************************-->
                    <div class="table_list">
                        <div style="margin-top: 10px;margin-bottom: 0px;color:#3fa95c;font-weight:bold"><?php echo $apply_limit_pass;?></div>
                        <div class="small_title_txt clear" style="border-bottom:0;padding-left:0;">
                         <?php if($order_detail_info['status_opera']==2 || $order_detail_info['status_opera']==3  || $order_detail_info['status_opera']==10 || $order_detail_info['status_opera']==11 || $order_detail_info['status_opera']==-4  /*|| $order_detail_info['balance_complete']==2*/):?>
                              <button class="apple_tuiding add_cost bens"  style="margin-bottom:0;margin-left:20px;background:#808080">新增已收</button>
                        <?php else:?>
                             <button class="apple_tuiding add_cost bens" onclick="add_fee2(this);" style="margin-left:0;margin-bottom:0;">新增已收</button>
                        <?php endif;?>
                        <?php if($apply_limit_zhong['credit_limit']>0):?>
                              <a href='javascript:void(0)' onclick="cancle_apply(this);" order-id="<?php echo $order_id; ?>" expert-id="<?php echo $userid;?>" style="margin:0 0 0 4px;">取消额度审批</a>
                        <?php endif;?>
                        <!--<button class="apple_tuiding add_cost bens" onclick="add_fee2(this);" style="margin-left:0;margin-bottom:0;">新增已收</button>-->
                        <span id="unreceive_amount" style="font-size: 16px;color: red;margin-left: 30px">未收款: <?php echo $order_detail_info['total_price']-$order_detail_info['total_receive_amount'];?></span>
                        </div>

                        <table class="table table-bordered table_hover">
                            <thead>
                                <tr>
                                    <th align="center" width="30">状态</th>
                                    <th align="center" width="98">交款时间</th>
                                    <th align="center" width="10%">金额</th>
                                    <th align="center" width="15%">备注</th>
                                    <th align="center" width="27%">交款方式</th>
                                    <th align="center" width="10%">流水单</th>
                                     <th align="center" width="98">是否加急</th>
                                    <th align="center" width="98">交款人</th>
                                </tr>
                            </thead>
                            <tbody id="receive_data_list">
                                   <?php if(!empty($receive_data)):?>
                                 <?php foreach($receive_data AS $val):?>
                               <!--<?php if($val['status']==3 || $val['status']==4 || $val['status']==6):?>
                                   <tr class="jujue">
                               <?php elseif($val['status']==2):?>
                                   <tr class="tongguo">
                               <?php else:?>
                                   <tr class="shenhe">
                               <?php endif;?> -->
                               		<tr>
                                    <td>
                                    <?php
                                    	switch($val['status']){
										case '1':
											echo "经理已提交";
										  break;
										case '2':
										  	echo "已审核";
										  break;
										  case '3':
										  	echo "旅行社拒绝";
										  break;
										  case '4':
										  	echo "经理已拒绝";
										  break;
										  case '5':
										  	echo "待经理审核";
										  break;
										  case '6':
										  	echo "供应商拒绝";
										  break;
										default:
											echo "未提交";
										  break;
									}
						?>
                                    </td>
                                    <td><?php echo $val['addtime']?></td>
                                    <td><?php echo $val['money']?></td>
                                    <td><?php echo $val['remark']?></td>
                                    <td>
                                    <?php if($val['way']=="转账"){
                                            echo $val['way'].'('.$val['bankname'].'/'.$val['bankcard'].')';
                                         }else{
                                            echo $val['way'];
                                        }?>
                                    </td>
                                     <td><a   data-pic="<?php echo $val['code_pic']?>" onclick="show_water_pic(this)">查看</a></td>
                                      <td><?php  if($val['is_urgent']==1){ echo '是';}else{echo '否';}?></td>
                                    <td><?php echo $val['realname']?></td>

                                </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                                <tr class="zongji zongji3"><td colspan="8" style="text-align:right;"><span>总计：<i><?php echo $sum_receive?></i>元 </span></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <!--***********************************End 已收款****************************************-->
                </div>
            </div>
        </div>
	</div>

		<!--*************************************** Start 拒绝供应商修改成本******************************************************-->
	<div class="fb-content" id="refuse_reasom_modal" style="display:none;">
        <div class="box-title">
            <h4>拒绝理由</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="jkxx fb-form" style="padding:10px;">
            <form id="refuse_reasom_form" action="#" method="post">
                    <div class="content_part">
                         <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                            <tr height="30">
                               <td class="order_info_title">拒绝理由:</td>
                                <td> <input style="width:100%;height: 100%" type="text" name="refuse_b1_reason"> </td>
                            </tr>
                        </table>
                </div>
                <div class="form_btn" style="padding-bottom:30px;">
                    <input type="hidden" name="refuse_b1_id" id="refuse_b1_id" value="" />
                    <input type="hidden" name="refuse_b1_order_id" id="refuse_b1_order_id" value="" />
                    <input type="button" name="submit" value="确认" class="btn btn_blue btn_refuse_reasom" style="margin-left:360px;" />
                </div>
            </form>
        </div>
    </div>
<!--*************************************** End 拒绝供应商修改成本******************************************************-->

	<!--*************************************** Start 申请退订******************************************************-->
	<div class="fb-content" id="form1" style="display:none;">
        <div class="box-title">
            <h4>退团信息</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="jkxx fb-form" style="padding:10px;">
            <form id="tuituan_form" action="#" method="post">
                    <div class="content_part">
                         <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                            <tr height="30">
                               <td class="order_info_title">订单人数:</td>
                                <td>
                                    <?php if($order_detail_info['unit']>=2):?>
                                            <?php echo $order_detail_info['unit'].'*'.$order_detail_info['suitnum'].' 人'?>
                                    <?php else:?>
                                        <?php echo $order_detail_info['dingnum']+$order_detail_info['children']+$order_detail_info['childnobednum']+$order_detail_info['oldnum'].'人';?>
                                    <?php endif;?>
                                </td>
                                <td class="order_info_title">退订人数:</td>
                                <td colspan="3" id="tui_num">0</td>
                            </tr>
                            <tr height="30">
                                <td class="order_info_title">应收总金额:</td>
                                <td><?php echo $order_detail_info['total_price']?></td>
                                 <td class="order_info_title">已交款总额:</td>
                                <td><?php echo $sum_receive_total?></td>
                                <td class="order_info_title">未确认交款:</td>
                                <td><?php echo $sum_receive_pending?></td>
                            </tr>
                            <tr height="30">
                                <td class="order_info_title">已结算:</td>
                                <td><?php echo $order_detail_info['balance_money']?></td>
                                 <td class="order_info_title">结算价:</td>
                                <td colspan="3"><?php echo $order_detail_info['supplier_cost']?></td>

                            </tr>
                             <tr height="30">
                             <td class="order_info_title">申请额度:</td>
                                <td colspan="6"><?php echo $apply_limit['credit_limit'];?></td>
					  </tr>
                             <tr height="30">
                                <td class="order_info_title">成人:</td>
                                <td colspan="6">单价:<?php echo isset($suit_price_data['adultprice'])==true?$suit_price_data['adultprice']:'0';?>;
                                                                                 结算价: <?php
                                               if(isset($suit_price_data['line_kind'])&&$suit_price_data['line_kind']=="1")  //普通线路
                                                  echo $suit_price_data['adultprice']-$suit_price_data['agent_rate_int'];
                                               else   //单项
                                               	  echo isset($suit_price_data['adultprofit'])==true?$suit_price_data['adultprofit']:'0';
                                       ?>
                                </td>
                                <!--
                                <td class="order_info_title">老人:</td>
                                <td colspan="3">单价:<?php echo $suit_price_data['oldprice']?>;    结算价: <?php echo $suit_price_data['oldprice']-$order_detail_info['agent_rate_int']?></td>
 								-->
                            </tr>
                            <tr height="30">
                                <td class="order_info_title">占床儿童:</td>
                                <td >单价:<?php echo isset($suit_price_data['childprice'])==true?$suit_price_data['childprice']:"0";?>;
                                	结算价: <?php
                                				if(isset($suit_price_data['line_kind'])&&$suit_price_data['line_kind']=="1") //普通线路
                                					echo $suit_price_data['childprice']-$suit_price_data['agent_rate_child'];
                                				else   //单项
                                					echo isset($suit_price_data['childprofit'])==true?$suit_price_data['childprofit']:'0';
                                	       ?>
                                </td>
                                <td class="order_info_title">不占床儿童:</td>
                                <td colspan="3">单价:<?php echo isset($suit_price_data['childnobedprice'])==true?$suit_price_data['childnobedprice']:"";?>;
                                  	结算价: <?php
                                  			if(isset($suit_price_data['line_kind'])&&$suit_price_data['line_kind']=="1")  //普通线路
                                  	 			echo $suit_price_data['childnobedprice']-$suit_price_data['agent_rate_child'];
                                  			else   //单项
                                  				echo isset($suit_price_data['childnobedprice'])==true?$suit_price_data['childnobedprice']:'0';
                                  	 ?>
                                  	 </td>
                            </tr>
                        </table>
                </div>
            <div class="content_part">
                <p style="font-size: 13px;color:#000;font-weight: bold;">退款信息<span style="padding-left:30px;color:red">退款金额请填写负数对冲</span></p>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="30">
                        <td class="order_info_title">退应收:</td>
                        <td><input type="text" name="refund_ys" id="refund_ys" value="0" onfocus="remove_zero(this)" onblur="add_zero(this)" onkeyup="cal_yj(this)"/></td>
                        <td class="order_info_title">退已交款:</td>
                        <td>
                            <?php if($order_detail_info['total_price']==$sum_receive):?>
                            <input type="text" name="refund_yj" id="refund_yj"  readonly value="0"/>
                        <?php else:?>
                            <input type="text" name="refund_yj" id="refund_yj" onkeyup="check_danjia(this);" onfocus="remove_zero(this)" onblur="add_zero(this)" value="0"/>
                        <?php endif;?>
                        </td>
                        <td class="order_info_title">退供应商:</td>
                        <td><input type="text" name="refund_yf" id="refund_yf" onkeyup="check_danjia(this);" onfocus="remove_zero(this)" onblur="add_zero(this)" value="0"/></td>
                    </tr>
                </table>
            </div>
            <div class="content_part" style="display:none">
                        <p style="font-size: 13px;color:#000;font-weight: bold;">客人银行账号信息</p>
                         <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                            <tr height="30">
                               <td class="order_info_title">持卡人:</td>
                                <td><input type="text" name="card_holder" id="card_holder" value=""/></td>
                                <td class="order_info_title">开户行:</td>
                                <td ><input type="text" name="open_bank" id="open_bank" value=""/></td>
                                <td class="order_info_title">支行名称:</td>
                                <td ><input type="text" name="branch_bank" id="branch_bank" value=""/></td>
                            </tr>
                            <tr height="30">
                                <td class="order_info_title">银行帐号:</td>
                                <td colspan="5"><input type="text" name="card_num" id="card_num" value="" style="width:100%"/></td>
                            </tr>
                            <tr height="30">
                                <td class="order_info_title">备注:</td>
                                <td colspan="5"><input type="text" name="beizhu" id="beizhu" value="" style="width:100%"/></td>
                            </tr>
                        </table>
                </div>
                <div class="form_btn" style="padding-bottom:30px;">
                    <input type="hidden" name="tuituan_id" id="tuituan_id" value="" />
                    <input type="hidden" name="tuituan_order_id" id="tuituan_order_id" value="" />
                    <input type="hidden" name="suit_day_id" value="<?php echo isset($suit_price_data['dayid'])==true?$suit_price_data['dayid']:'0';?>"/>
                    <input type="hidden" name="pass_depart_id" value="<?php  echo $order_detail_info['depart_id'];?>"/>
                    <input type="button" name="submit" value="确认退团" class="btn btn_blue btn_refund_submit" style="margin-left:330px;" />
                     <input type="button" name="button" value="关闭" class="btn_close btn_blue layui-layer-close" style="margin-left:20px;height:24px;" />
                </div>
            </form>
        </div>
    </div>
<!--*************************************** End 申请退订******************************************************-->
<!--***************************************Start 添加参团人******************************************************-->
    <div class="fb-content" id="add_trip_people" style="display:none;">
        <div class="box-title">
            <h4>添加参团人</h4>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <form id="add_people_form" action="#" method="post">
        <div class="jkxx fb-form" style="padding:10px;" id="add_trip_info">
                <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="30">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="7"><?php echo $order_detail_info['line_name']?></td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">出发日期:</td>
                        <td colspan="3" style="width:40%"><?php echo $order_detail_info['usedate']?></td>
                        <td class="order_info_title">余位:</td>
                        <td colspan="3" style="width:40%"><?php echo isset($suit_price_data['number'])==true?$suit_price_data['number']:'0';?></td>
                    </tr>

                    <?php if($order_detail_info['unit']<2):?>
                    <tr height="30" >
                        <td class="order_info_title">成人价:</td>
                        <td><?php  echo $order_detail_info['ding_price'];?></td>
                        <td class="order_info_title">儿童不占:</td>
                        <td><?php  echo $order_detail_info['childnobedprice'];?></td>
                         <td class="order_info_title">儿童占床:</td>
                        <td><?php  echo $order_detail_info['childprice'];?></td>
                        <!-- <td class="order_info_title" style="width:13%">老人价:</td>
                        <td><?php  echo $order_detail_info['oldprice'];?></td> -->
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">新增参团人:</td>
                        <td colspan="7">
                                    <div class="adultsNum">
                                    <span >成人:</span>
                                        <div class="adultsNumDown" onclick="changeTraverNum(this,1,2,0)">-</div>
                                        <div class="adultsNums">
                                            <input type="text" name="dingnum" class="travelNumber" style="ime-mode:disabled;" maxlength="3" value="0">
                                        </div>
                                        <div class="adultsNumUp" onclick="changeTraverNum(this,1,1,0)">+</div>
                                    </div>
                                    <?php if (isset($suit_price_data['childnobedprice']) && $suit_price_data['childnobedprice'] >0):?>
                                    <div class="adultsNum">
                                    <span >小童不占:</span>
                                        <div class="adultsNumDown" onclick="changeTraverNum(this,4 ,2,0)">-</div>
                                        <div class="adultsNums">
                                            <input type="text" name="childnobed_num" class="travelNumber" style="ime-mode:disabled;" maxlength="3" value="0">
                                        </div>
                                        <div class="adultsNumUp" onclick="changeTraverNum(this,4 ,1,0)">+</div>
                                    </div>
                                    <?php else:?>
                                    	<input type="hidden" name="childnobed_num" value="0">
                                    <?php endif;?>
                                    <?php if (isset($suit_price_data['childprice']) && $suit_price_data['childprice'] >0):?>
                                    <div class="adultsNum">
                                    <span >小童占床:</span>
                                        <div class="adultsNumDown" onclick="changeTraverNum(this,3,2,0)">-</div>
                                        <div class="adultsNums">
                                            <input type="text" name="child_num" class="travelNumber" style="ime-mode:disabled;" maxlength="3" value="0">
                                        </div>
                                        <div class="adultsNumUp" onclick="changeTraverNum(this,3 ,1,0)">+</div>
                                    </div>
                                    <?php else:?>
                                   		<input type="hidden" name="child_num" value="0">
                                    <?php endif;?>
                                   <!--  <div class="adultsNum">
                                   <span >老人:</span>
                                       <div class="adultsNumDown" onclick="changeTraverNum(this,2 ,2,0)">-</div>
                                       <div class="adultsNums">
                                           <input type="text" name="old_num" class="travelNumber" style="ime-mode:disabled;" maxlength="2" value="0">
                                       </div>
                                       <div class="adultsNumUp" onclick="changeTraverNum(this,2 ,1,0)">+</div>
                                   </div> -->
                       </td>
                    </tr>
                    <tr height="30">
                        <td class="order_info_title">金额:</td>
                        <td colspan="7" class="people_price" >
                                        <span >成人:<i id="adult_price">0</i></span>
                                        <span >小童不占床:<i id="child_nobed_price">0</i></span>
                                        <span > 小童占床:<i id="child_price">0</i></span>
                                        <!-- <span> 老人:<i id="old_price">0</i></span> -->
                        </td>
                    </tr>
                     <tr height="30">
                        <td class="order_info_title">可用现金余额:</td>
                        <td colspan="3" class="people_price" >
                          <span id="add_can_cash"></span>
                        </td>
                        <td class="order_info_title">现金余额交款:</td>
                        <td colspan="3" class="people_price" >
                          <input type="checkbox" name="add_people_cash" id="add_people_cash" value="1" disabled />
                        </td>
                    </tr>
                <?php else:?>
                        <tr height="30" >
                            <td class="order_info_title">套餐名称:</td>
                            <td colspan="3">
                            <?php  echo $order_detail_info['suitname'];?>
                            </td>
                            <td class="order_info_title">套餐价格:</td>
                            <td colspan="3">
                            <?php  echo "<span style='color:red'>".$order_detail_info['ding_price']."/".$order_detail_info['unit']."人套餐</span>";?>
                            </td>
                        </tr>

                        <tr>
                         <td class="order_info_title">新增参团人:</td>
                         <td colspan="7">
                               <div class="adultsNum">
                                    <span>份数:</span>
                                        <div class="adultsNumDown" onclick="changeTraverNum(this,1,2,1)">-</div>
                                        <div class="adultsNums">
                                            <input type="text" name="dingnum" class="travelNumber" style="ime-mode:disabled;" maxlength="2" value="0">
                                        </div>
                                        <div class="adultsNumUp" onclick="changeTraverNum(this,1,1,1)">+</div>
                                    </div>
                         </td>
                        </tr>
                        <tr>
                             <td class="order_info_title">金额:</td>
                             <td colspan="7" class="people_price">
                                        <i id="suit_price">0</i>
                            </td>
                        </tr>
                        <tr height="30">
                        <td class="order_info_title">可用现金余额:</td>
                        <td colspan="3" class="people_price" >
                          <span id="add_can_cash2"></span>
                        </td>
                        <td class="order_info_title">现金余额交款:</td>
                        <td colspan="3" class="people_price" >
                          <input type="checkbox" name="add_people_cash" id="add_people_cash2" value="1" disabled />
                        </td>
                    </tr>
                <?php endif;?>
                </table>
                <!--Start 线路类型显示添加参团人的表格 (国内游)-->
                        <?php if($line_type==2):?>
                          <div class="lanmu_Add traver_list2" >
                             <ul style="border-top:1px solid #ccc;" class="bord_red clear">
                               <li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">序号</li>
                             <li style="margin-right:0px;"><i>*</i>姓名</li>
                             <li style="margin-right:0px; width:75px;"><i>*</i>性别</li>
                               <li><i>*</i>证件类型</li>
                               <li><i>*</i>证件号码</li>
                               <li><i>*</i>出生日期</li>
                               <li>手机号码</li>
                               <li style="padding:0;">类别</li>
                           </ul>
                          </div>
                        <?php else:?>
                    <!--第二种表格(境外游) -->
                    <div class="jingwaide_Table traver_list1" >
                            <ul style=" border-top:1px solid #ccc" class="bord_red clear">
                                <li class="grade">编号</li>
                                <li class="chinese_name">姓名</li>
                                <li class="english_name"><i>*</i>英文名</li>
                                <li class="gender"><i>*</i>性别</li>
                                <li class="id_type"><i>*</i>证件类型</li>
                                <li class="zhengjian_number"><i>*</i>证件号</li>
                                 <li class="date_birth"><i>*</i>出生日期</li>
                                <li class="issue_di"><i>*</i>签发地</li>
                                <li class="issue_date"><i>*</i>签发日期</li>
                                <li class="validity"><i>*</i>有效期至</li>
                                <li class="phone_number">手机号</li>
                                <li class="people_type">类别</li>
                            </ul>
                    </div>
             <?php endif;?>
                <!-- End -->
                <div style="margin-top:15px">
                <button type="button" id="sure_submit" class="btn_add_people" style="margin-left: 400px;width: 65px;height: 30px;">确认添加</button>
                <input type="button" name="button" value="关闭" class="btn_close btn_blue layui-layer-close" style="margin-left:20px;height:24px;" />
                 <input type="hidden" name="add_order_id" value="<?php echo $order_id;?>"/>
                 <input type="hidden" name="add_order_sn" value="<?php echo $order_detail_info['line_sn'];?>"/>
                 <input type="hidden" name="line_type" value="<?php echo $line_type?>"/>
                 <input type="hidden" name="line_id" value="<?php echo $order_detail_info['lineid']?>"/>
                 <input type="hidden" name="s_agent_rate" value="<?php echo $order_detail_info['s_agent_rate']?>"/>

                 <input type="hidden" name="agent_rate_child" value="<?php echo $order_detail_info['agent_rate_child']?>"/>
                 <input type="hidden" name="agent_rate_int" value="<?php echo $order_detail_info['agent_rate_int']?>"/>
                 <input type="hidden" name="overcity2" value="<?php echo $order_detail_info['overcity2']?>"/>

                <input type="hidden" name="suit_day_id" value="<?php echo isset($suit_price_data['dayid'])==true?$suit_price_data['dayid']:'0';?>"/>
                <input type="hidden" name="adult_price" value="<?php echo isset($suit_price_data['adultprice'])==true?$suit_price_data['adultprice']:'0';?>"/>
                <input type="hidden" name="old_price" value="<?php echo isset($suit_price_data['oldprice'])==true?$suit_price_data['oldprice']:'0';?>"/>
                <input type="hidden" name="child_price" value="<?php  echo isset($suit_price_data['childprice'])==true?$suit_price_data['childprice']:'0';?>"/>
                <input type="hidden" name="child_nobed_price" value="<?php  echo isset($suit_price_data['childnobedprice'])==true?$suit_price_data['childnobedprice']:'0';?>"/>

                <input type="hidden" name="order_unit" value="<?php  echo $order_detail_info['unit'];?>"/>
                <input type="hidden" name="sale_depart_id" value="<?php  echo $order_detail_info['depart_id'];?>"/>
                <input type="hidden" name="lineday" value="<?php  echo $order_detail_info['lineday'];?>"/>
                <input type="hidden" name="supplier_id" value="<?php  echo $order_detail_info['supplier_id'];?>"/>
                </div>
         </div>
         </form>
    </div>

<!--***************************************End 添加参团人******************************************************-->

<!--***************************************Start 显示流水单******************************************************-->
<div class="fb-content" id="show_pic_modal" style="display:none;">
    <div class="box-title">
        <h4>流水单</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form" style=" margin:15px;">
      <img src="" style="width:300px; height:300px">
    </div>
</div>
<!--***************************************End 显示流水单******************************************************-->

<!--***************************************Start 修改人员信息******************************************************-->
<div class="fb-content" id="show_edit_man_modal" style="display:none;">
    <div class="box-title">
        <h4>编辑出团人</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form" style=" margin:15px;">
      <form id="edit_travel_form" action="#" method="post">
                   <div class="content_part">
                         <table id="edit_travel_info" class="order_info_table table_td_border" border="1" width="100%" cellspacing="0"></table>
                	</div>
                <div class="form_btn" style="padding-bottom:30px;">
                    <input type="hidden" name="edit_travel_id" id="edit_travel_id" value="" />
                    <input type="button" name="submit" value="保存" class="btn btn_blue btn_edit_people" style="margin-left:280px;" />
                    <input type="button" name="button" value="关闭" class="btn_close btn_blue layui-layer-close" style="margin-left:20px;" />
                </div>
            </form>
    </div>
</div>
<!--***************************************End 修改人员信息******************************************************-->

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.extend.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/base.js"); ?>"></script>


<script type="text/javascript">

		//1、检测套餐是否删除
		function check_suit()
		{
			var suit_row=<?php echo empty($suit_price_data)==true?'-1':$suit_price_data['dayid'];?>;
			if(suit_row=="-1")
			{
				tan_msg('线路套餐已删除，无法进行操作');
				return false;
			}
			else
				return true;
		
		}
		//2、全局变量
            var op_order_id = <?php echo $order_id;?>;
            var op_order_sn = <?php echo $order_sn;?>;
            //线路类型 1:出境; 2:国内
            var op_line_type= <?php echo $line_type?>;
            //证书类型
            var certificate = <?php echo json_encode($certificate); ?>;
            //余位剩余多少
            var surplus_num = <?php echo isset($suit_price_data['number'])==true?$suit_price_data['number']:'0';?>;
            var adultprice      = <?php  echo isset($suit_price_data['adultprice'])==true?$suit_price_data['adultprice']:'0';?>;
            var childprice      = <?php  echo isset($suit_price_data['childprice'])==true?$suit_price_data['childprice']:'0';?>;
            var childnobedprice = <?php  echo isset($suit_price_data['childnobedprice'])==true?$suit_price_data['childnobedprice']:'0';?>;
            var oldprice = <?php  echo isset($suit_price_data['oldprice'])==true?$suit_price_data['oldprice']:'0';?>;
            var unit = <?php  echo !empty($order_detail_info['unit']) ? $order_detail_info['unit'] : 1;?>;
            var bankcard = <?php echo '\''.$union_bank['bankcard'].'\''?>;
            var bankname = <?php echo '\''.$union_bank['bankname'].'\''?>;
            var depart_id = <?php echo $order_detail_info['depart_id'];?>;
            //var balance_money = <?php echo $order_detail_info['balance_money'];?>;
	     //3、"添加参团人" 弹窗
          function add_people(obj)
          {
          	 if(!check_suit()) return false;//套餐检测，套餐删除时无法进行操作
             $('#add_trip_people').find("input[name='dingnum']").val(0);
             $('#add_trip_people').find("input[name='childnobed_num']").val(0);
             $('#add_trip_people').find("input[name='child_num']").val(0);
             $('#add_trip_people').find("input[name='old_num']").val(0);
             $("#adult_price").html(0);
             $("#child_nobed_price").html(0);
             $("#child_price").html(0);
             $("#old_price").html(0);
             $('#add_trip_people').find('ul[class^=people_type_]').remove();
             $.post("<?php echo base_url();?>admin/b2/order_manage/get_limit",
                          {'order_id':op_order_id},
                          function (data){
                              data = eval('('+data+')');
                              if(data['is_add']){
                               $("#add_can_cash").html(data['cash_limit']);
                               if(data['cash_limit']>0){
                                  $("#add_people_cash").attr("checked",'true');
                                  //$("#add_people_cash").removeAttr("disabled");
                               }else{
                                  $("#add_people_cash").attr("checked",'false');
                                  $("#add_people_cash").attr("disabled","disabled");
                               }

                               $("#add_can_cash2").html(data['cash_limit']);
                               if(data['cash_limit']>0){
                                  $("#add_people_cash2").attr("checked",'true');
                                  //$("#add_people_cash2").removeAttr("disabled");
                               }else{
                                  $("#add_people_cash2").attr("checked",'false');
                                  $("#add_people_cash2").attr("disabled","disabled");
                               }

                                layer.open({
                                      type: 1,
                                      title: false,
                                      closeBtn: 0,
                                      area: '956px',
                                      shadeClose: false,
                                      content: $('#add_trip_people')
                              });
                            }else{
                              tan_alert('有未审核的应收或者应付账单,请先审核完');
                              return false;
                            }
             });

          }
        //4、"添加参团人" 数据提交
        $("body").on("click",".btn_add_people",function(){
        	   var flag = COM.repeat('btn');//频率限制
               if(!flag)
               {
                   $.post(
                               "<?php echo base_url();?>admin/b2/order_manage/add_people",
                               $('#add_people_form').serialize(),
                               function(data){
                                       data = eval('('+data+')');
                                       console.log(data);
                                       if (data.status == 200){
                                            layer.alert(data.msg, {icon: 1,title:'提交成功'});
                                            window.location.reload();
                                       }else{
                                           //tan(data.msg);
                                           layer.alert(data.msg, {icon: 2,title:'错误提示'});
                                           $("#add_people_form").find('button').show();
                                       }
                               }
                       );
               }
               
           });
          
        //5、"退团" 弹窗
      	function apply_tuiding(obj)
      	{
      		var choose = $("input[data-role=traver_id]:checked");
            var not_choose =  $("input[data-role=traver_id]").not("input:checked");
            var diff_cost  = 0;
            var diff_price = 0;
            var choose_id="";
      		if(unit>=2 &&(choose.length!=0 && not_choose.length!=0 ))
      		{
      			  tan_alert_noreload("套餐线路必须全部退团");
                  return false;
            }
            else
            {
                var i=0;
                 $(choose).each(function(){
                	 if(i>0){
                  		choose_id = choose_id + ',';
                     }
                 	choose_id = choose_id + $(this).val();
                 	
                 	diff_cost  = Number(diff_cost)+Number($(this).attr('data-cost'));
                 	diff_price = Number(diff_price)+Number($(this).attr('data-price'));
                 	i++;
                 });
                 //choose_id=choose_id.substring(0,choose_id.length-1);
                 $("#tuituan_id").val(choose_id);
                 $("#tui_num").html(choose.length);
                 $("#tuituan_order_id").val(op_order_id);
                 // balance_money
                 layer.open({
                              type: 1,
                              title: false,
                              closeBtn: 0,
                              area: '800px',
                              shadeClose: false,
                              content: $('#form1')
                    });
              }
      	}
        //全选退团
        function choose_all(obj)
        {
            var choose_id='';
            if($(obj).is(':checked')){
                $(obj).parent().parent().parent().siblings("tbody").find("input[type='checkbox']").attr("checked",true);
                var choose = $(obj).parent().parent().parent().siblings("tbody").find("input[type='checkbox']:checked");
                $(choose).each(function(){
                        choose_id += $(this).val()+',';
                });
                choose_id=choose_id.substring(0,choose_id.length-1);
                $("#tuituan_id").val(choose_id);
            }else{
                $(obj).parent().parent().parent().siblings("tbody").find("input[type='checkbox']").attr("checked", false);
                $("#tuituan_id").val('');
            }
        }
        //6、"退团" 数据提交
        
        $("body").on("click",".btn_refund_submit",function(){
       	     var flag = COM.repeat('btn');//频率限制
             if(!flag)
             {
            	 //$(this).find("input[type='submit']").hide();
                 var reg = new RegExp("^-[0-9]+(.[0-9]{1,3})?$");
                 var ys_value=$("#refund_ys").val().replace(/(^\s*)|(\s*$)/g, ""); //去掉字符串左右空格
                 var yj_value=$("#refund_yj").val().replace(/(^\s*)|(\s*$)/g, "");
                 var yf_value=$("#refund_yf").val().replace(/(^\s*)|(\s*$)/g, "");
                 if(ys_value!=0 && !reg.test(ys_value)){
                     layer.alert('应收款必填合法负数或者0', {icon: 2,title:'错误提示'});
                    //alert('应收款必填合法负数或者0');
                    return false;
                 }
                  if(yj_value!=0 && !reg.test(yj_value)){
                     layer.alert('退已交款款必填合法负数或者0', {icon: 2,title:'错误提示'});
                   // alert('退已交款款必填合法负数或者0');
                    return false;
                 }
                 if(yf_value!=0 && !reg.test(yf_value)){
                    layer.alert('退供应商款必填合法负数或者0', {icon: 2,title:'错误提示'});
                    //alert('退供应商款必填合法负数或者0');
                    return false;
                 }
                  $.post(
                         "<?php echo base_url();?>admin/b2/order_manage/apply_tuituan_price",
                        $('#tuituan_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                      //layer.alert(data.msg, {icon: 1,title:'提交成功'});
                                     //location.reload();
                                    tan_alert(data.msg);
                                }else{
                                    layer.alert(data.msg, {icon: 2,title:'错误提示'});
                                     $('#tuituan_form').find("input[type='submit']").show();
                                }
                        }
                    );
                   
             }
              
        });
        // 7、添加应收
        function project_select(obj)
		{
			var val = $(obj).val();
			if(val=="其他"){
				$(obj).hide();
				$(obj).siblings("input").show();
			}
		}
    	function add_fee(obj)
    	{
            $.post("<?php echo base_url();?>admin/b2/order_manage/get_limit",
                  {'order_id':op_order_id},
                    function (data)
                    {
                         data = eval('('+data+')');
                         var str = '<tr class="add_fee"><td></td>';
                         str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" name="other_item" class="other_obj"/></td>';
                         str+= '<td><input type="text" class="beizhu"/></td>';
                         str+= '<td><input type="text" class="danjia" style="width:80px;" onkeyup="check_danjia(this);"/></td>';
                         str+= '<td><input type="text" class="shuliang" style="width:55px;" onkeyup="check_shuliang(this);"/></td>';
                         str+= '<td class="total_money"></td>';
                         if(data['cash_limit']>0){
                               str+= '<td ><input type="checkbox" value="1" name="is_cash" id="is_cash" class="is_cash" checked="checked" disabled="true"/>余额<span style="color:blue">'+data['cash_limit']+'</span></td>';
                          }else{
                               str+= '<td ><input type="checkbox" value="1" name="is_cash" id="is_cash" class="is_cash" checked="checked" disabled/>余额<span style="color:red">'+data['cash_limit']+'</span></td>';
                         }
                         str+= '<td ><span class="save" onclick="save_add_fee(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
                         $(".zongji1").before(str);
                   }
               );
    	}
    	//8、添加应付
		function add_cost(obj)
		{
			    var str = '<tr class="add_fee"><td></td>';
				str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" name="other_item" class="other_obj"/></td>';
				str+= '<td><input type="text" class="beizhu"/></td>';
				str+= '<td><input type="text" class="danjia" style="width:80px;" onkeyup="check_danjia(this);"/></td>';
				str+= '<td><input type="text" class="shuliang" style="width:55px;" onkeyup="check_shuliang(this);"/></td>';
				str+= '<td class="total_money"></td>';
				str+= '<td colspan="3"><span class="save" onclick="save_add_supplier(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
				$(".zongji2").before(str);
		}
		//9、添加已交款 
		function add_fee2(obj)
		{
	          $.post("<?php echo base_url();?>admin/b2/order_manage/get_limit",
	                  {'order_id':op_order_id},
	                  function (data)
	                  {
	                      data = eval('('+data+')');
	                      if(data['cash_limit']>0)
	                      {
	                           var str = '<tr class="add_fee"><td></td><td></td>';
	                           str+= '<td><input type="text" class="jine" onkeyup="check_danjia(this);" /></td>';
	                           str+= '<td><input type="text" class="beizhu" style=""/></td>';
	                           str+= '<td><select class="jkfs" onchange="change_pay_way(this)" style="width:69px;line-height:24px;height:24px;">';
	                           // if(data['cash_limit']>0){
	                                str+= '<option value="账户余额">账户余额</option></select><span>余额:<font style="color:blue;">'+data['cash_limit']+'</font></span>';
	                           // }
	                           /*str+= '<option value="转账">转账</option><option value="现金">现金</option></select>';
	                             if(data['cash_limit']<=0){
	                                str+= '<input type="text" style=" height:24px; line-height:24px;width:110px;" name="bank_info" id="bank_info" placeholder="开户银行" value="'+bankname+'"/><input type="text" style="height:24px; line-height:24px;width:110px;" name="bank_num" id="bank_num" placeholder="银行账号" value="'+bankcard+'"/>';
	                             }else{
	                                 str+= '<span id="balance_cash_limit" style="color:blue">'+data['cash_limit']+'</span><input type="text" style="display:none;height:24px; line-height:24px;width:110px;" name="bank_info" id="bank_info" placeholder="开户银行" value="'+bankname+'"/><input type="text" style="display:none;height:24px; line-height:24px;width:110px;" name="bank_num" id="bank_num" placeholder="银行账号" value="'+bankcard+'"/>';
	                          }*/
	                           str+='</td>';
	                           str+='<td><input name="single_water" id="single_water" onchange="upload_water(this);" type="file"><input name="single_water_pic" type="hidden" /></td>';
	                           str+='<td><input name="urgent" id="urgent"  type="checkbox" value="1">加急</td>';
	                           str+= '<td ><span class="save" onclick="save_add_fee2(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
	                           $(".zongji3").before(str);
	                       }
	                      else
	                       {
	                    	   tan_alert_noreload('账户余额不足，请联系财务充值');
	                           return false;
	                       }
	                   }
	                );
		}
		//10、调整外交佣金
        function add_commission(obj)
        {
                var str = '<tr class="add_fee"><td></td>';
                str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text"  name="other_item" class="other_obj"/></td>';
                str+= '<td><input type="text" class="beizhu"/></td>';
                str+= '<td><input type="text" class="danjia" style="width:80px;" onkeyup="check_danjia(this);"/></td>';
                str+= '<td><input type="text" class="shuliang" style="width:55px;" onkeyup="check_shuliang(this);"/></td>';
                str+= '<td class="total_money"></td>';
                str+= '<td><span class="save" onclick="save_add_commission(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
                $(".zongji1").before(str);
        }
         //平台管理费  新增管理费
    	function add_manage_fee(obj)
    	{
    		var str = '<tr class="add_fee"><td></td>';
    			str+= '<td><select class="project_select" onchange="project_select(this);"><option value="团费">团费</option><option value="综费">综费</option><option value="房差">房差</option><option value="其他">其他</option></select><input type="text" name="other_item" class="other_obj"/></td>';
    			str+= '<td><input type="text" class="beizhu"/></td>';
    			str+= '<td><input type="text" class="danjia" style="width:80px;" onkeyup="check_danjia(this);"/></td>';
    			str+= '<td><input type="text" class="shuliang" style="width:55px;" onkeyup="check_shuliang(this);"/></td>';
    			str+= '<td class="total_money"></td>';
    			str+= '<td><span class="save" onclick="save_add_fee(this);">保存</span><span class="cancle" onclick="cancle_add_fee(this);">取消</span></td></tr>';
    			$(".zongji4").before(str);

    	}
		//11、添加应收：保存数据
		function save_add_fee(obj)
		{
			var project = $(obj).parent().siblings("td").find(".project_select").val();
			var price = $(obj).parent().siblings("td").find(".danjia").val();
			var num = $(obj).parent().siblings("td").find(".shuliang").val();
	        var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
	        var other_item = $(obj).parent().siblings("td").find(".other_obj").val();
	        var cash = $(obj).parent().siblings("td").find(".is_cash");
	        if(cash.is(':checked')){
	                var is_cash = 1;
	            }else{
	                var is_cash = 0;
	        }
	        var reg = new RegExp("^[0-9]*[1-9][0-9]*$");
	        var reg2 = new RegExp("^-?[0-9]+(.[0-9]{1,3})?$");
			if(project=="其他")
		    {
				var other_val = $(obj).parent().siblings("td").find(".other_obj").val();
	            if(other_val=="")
	            {
	                 layer.alert('请填写项目名称', {icon: 2,title:'错误提示'});
	                 //alert("请填写项目名称");
	                 $(obj).parent().siblings("td").find(".other_obj").focus();
	                 return false;
	            }
			}
			if(price==""||price==null){
	                 layer.alert('请填写单价', {icon: 2,title:'错误提示'});
				     //alert("请填写单价为合法数字");
				     $(obj).parent().siblings("td").find(".danjia").focus();
				     return false;
			}
			if(num==""||num==null){  //!reg.test(num)
	                layer.alert('请填写数量', {icon: 2,title:'错误提示'});
				    //alert("请填写数量为整数");
				    $(obj).parent().siblings("td").find(".danjia").focus();
				     return false;
			}
	       
	        $.post("<?php echo base_url();?>admin/b2/order_manage/apply_change_price",
	               {'change_order_id':op_order_id,'item':project,'price':price,'num':num,'beizhu':beizhu,'depart_id':depart_id,'is_cash':is_cash,'other_item':other_item},
	               function (data)
	               {
	                    data = eval('('+data+')');
	                    if(data.status==200)
	                    {
	                        if(data.msg.num==0 || data.msg.num==1 || data.msg.num=='' || data.msg.num==null )
	                        {
	                             var total = data.msg.price;
	                        }
	                        else
	                        {
	                             var total = data.msg.price*data.msg.num;
	                        }
	                        var html = "<td><i></i>已通过</td><td align='center'>"+data.msg.item+"</td><td align='center'>"+data.msg.beizhu+"</td><td align='center'>"+data.msg.price+"</td><td align='center'>"+data.msg.num+"</td><td align='center'>"+total+"</td><td align='center'>"+data.msg.addtime+"</td><td align='center'>"+data.msg.realname+"</td>";
	                        if(data.msg.status==1)
	                        {
	                            $(obj).parent().parent().html(html).removeClass('shenhe').addClass('tongguo');
	                        }
	                        else
	                        {
	                            $(obj).parent().parent().html(html).removeClass('shenhe').addClass('shenhe');
	                        }
	                     }
	                     else
	                     {
	                            layer.alert(data.msg, {icon: 2,title:'错误提示'});
	                     }
	                }
	           );
		}
	    //12、添加应付：保存数据
	    function save_add_supplier(obj)
	    {
	        var reg = new RegExp("^\\+?[1-9][0-9]*$");
	        var project = $(obj).parent().siblings("td").find(".project_select").val();
	        var price = $(obj).parent().siblings("td").find(".danjia").val();
	        var num = $(obj).parent().siblings("td").find(".shuliang").val();
	        var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
	        var other_item =  $(obj).parent().siblings("td").find(".other_obj").val();
	     
	        if(project=="其他"){
	           var other_val = $(obj).parent().siblings("td").find(".other_obj").val();
	            if(other_val==""){
	                 layer.alert('请填写项目名称', {icon: 2,title:'错误提示'});
	                //alert("请填写项目名称");
	                $(obj).parent().siblings("td").find(".other_obj").focus();
	                return false;
	            }
	        }
	        if(price==""||price==null){
	            //alert("请填写单价");
	            layer.alert('请填写单价', {icon: 2,title:'错误提示'});
	            $(obj).parent().siblings("td").find(".danjia").focus();
	            return false;
	        }
	        if(num==""||num==null){
	            //alert("请填写数量");
	             layer.alert('请填写数量', {icon: 2,title:'错误提示'});
	            $(obj).parent().siblings("td").find(".danjia").focus();
	            return false;
	        }
	        var index = layer.msg('提交中,请稍后..', { icon: 16, shade: 0.8,time: 200000 });
	        $.post("<?php echo base_url();?>admin/b2/order_manage/apply_suplier_pay",
	                {'supplier_order_id':op_order_id,'item':project,'price':price,'num':num,'beizhu':beizhu,'other_item':other_item},
	                function (data){
	                     layer.close(index);
	                    data = eval('('+data+')');
	                    if(data.status==200){
	                        if(data.msg.num==0 || data.msg.num==1 || data.msg.num=='' || data.msg.num==null ){
	                             var total = data.msg.price;
	                        }else{
	                            var total = data.msg.price*data.msg.num;
	                        }

	                        var html = "<td><i></i></td><td align='center'>"+data.msg.item+"</td><td align='center'>"+data.msg.beizhu+"</td><td align='center'>"+data.msg.price+"</td><td align='center'>"+data.msg.num+"</td><td align='center'>"+total+"</td><td align='center'>"+data.msg.addtime+"</td><td align='center'>"+data.msg.realname+"</td><td></td>";
	                        $(obj).parent().parent().html( html).removeClass('shenhe').addClass('shenhe');
	                }else{
	                        layer.alert(data.msg, {icon: 2,title:'错误提示'});
	                    }
	                }
	            );
	    }
		//13、添加已交款： 保存数据
		function save_add_fee2(obj)
		{
			var price = $(obj).parent().siblings("td").find(".jine").val();
			var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
			var receive_way = $(obj).parent().siblings("td").find(".jkfs").val();
	        var bank_info = $(obj).parent().siblings("td").find("input[name='bank_info']").val();
	        var bank_num = $(obj).parent().siblings("td").find("input[name='bank_num']").val();
	        var water_pic = $(obj).parent().siblings("td").find("input[type='hidden']").val();
	        var urgent = $(obj).parent().siblings("td").find("input[type='checkbox']");
	        if(urgent.is(':checked'))
	        {
	            var is_urgent = 1;
	        }
	        else
	        {
	            var is_urgent = 0;
	        }
			if(price.length==0)
		    {
	            layer.alert('请填写金额', {icon: 2,title:'错误提示'});
	    		//alert("请填写金额");
	    		return false;
			}
			if(receive_way=="转账")
		    {
	            if(bank_info==""){
	                layer.alert('请填写银行信息', {icon: 2,title:'错误提示'});
	                //alert("请填写银行信息");
	                 return false;
	               }
	           if(bank_num==""){
	                 layer.alert('请填写银行帐号', {icon: 2,title:'错误提示'});
	                 //alert("请填写银行帐号");
	                  return false;
	               }
			}
	        //var index = layer.msg('提交中,请稍后..', { icon: 16, shade: 0.8,time: 200000 });
	        $.post("<?php echo base_url();?>admin/b2/order_manage/apply_receive",
	                {'receive_order_id':op_order_id,'receive_order_sn':op_order_sn,'way':receive_way,'price':price,'beizhu':beizhu,'bank_info':bank_info,'bank_num':bank_num,'water_pic':water_pic,'is_urgent':is_urgent},
	                 function (data){
	                                    layer.close(index);
	                                    data = eval('('+data+')');
	                                    if(data.status==200){
	                                         if(data.msg.is_urgent==1){
	                                                  var string="是";
	                                         }else{
	                                                      var string="否";
	                                         }
	                                        var html = "<td><i></i></td><td align='center'>"+data.msg.addtime+"</td><td align='center'>"+data.msg.price+"</td><td align='center'>"+data.msg.beizhu+"</td><td align='center'>"+data.msg.way;
	                                        if(data.msg.bank_info!='' && data.msg.bank_info!=undefined ){
	                                            html += "("+data.msg.bank_info+"/"+data.msg.bank_num+")";
	                                        }
	                                         html += "</td><td><a data-pic='"+data.msg.water_pic+"' onclick='show_water_pic(this)'>查看</a></td> <td>"+string+"</td><td align='center'>"+data.msg.realname+"</td>";
	                                        $(obj).parent().parent().html( html).removeClass('shenhe').addClass('shenhe');
	                                }else{
	                                     layer.alert(data.msg, {icon: 2,title:'错误提示'});
	                                    //alert(data.msg);
	                                    }
	                                }
	                );
		}
		 //14、调整外交佣金：保存数据
	    function save_add_commission(obj)
	    {
	        var project = $(obj).parent().siblings("td").find(".project_select").val();
	        var price = $(obj).parent().siblings("td").find(".danjia").val();
	        var num = $(obj).parent().siblings("td").find(".shuliang").val();
	        var beizhu = $(obj).parent().siblings("td").find(".beizhu").val();
	        var other_item = $(obj).parent().siblings("td").find(".other_obj").val();
	        if(project=="其他"){
	            var other_val = $(obj).parent().siblings("td").find(".other_obj").val();
	            if(other_val==""){
	                alert("请填写项目名称");
	                $(obj).parent().siblings("td").find(".other_obj").focus();
	                return false;
	            }
	        }
	        if(price.length==0){
	            alert("请填写单价");
	            $(obj).parent().siblings("td").find(".danjia").focus();
	            return false;
	        }
	        if(num.length<=0){
	            alert("请填写数量");
	            $(obj).parent().siblings("td").find(".danjia").focus();
	            return false;
	        }
	         $.post("<?php echo base_url();?>admin/b2/order_manage/apply_commission",
	           {'agent_order_id':op_order_id,'item':project,'price':price,'num':num,'beizhu':beizhu,'other_item':other_item},
	                function (data){
	                        data = eval('('+data+')');
	                       //console.log(data);
	                        if(data.status==200){
	                           if(data.msg.num==0 || data.msg.num==1 || data.msg.num=='' || data.msg.num==null ){
	                               var total = data.msg.price;
	                             }else{
	                                var total = data.msg.price*data.msg.num;
	                            }
	                            var html = "<td><i></i></td><td align='center'>"+data.msg.item+"</td><td align='center'>"+data.msg.beizhu+"</td><td align='center'>"+data.msg.price+"</td><td align='center'>"+data.msg.num+"</td><td align='center'>"+total+"</td><td align='center'>"+data.msg.realname+"</td>";
	                            $(obj).parent().parent().html( html).removeClass('shenhe').addClass('shenhe');
	                        }else{
	                            alert(data.msg);
	                        }
	                     }
	            );
	    }
	   //14、取消按钮
		function cancle_add_fee(obj)
		{
			$(obj).parent().parent().remove();
		}
       //15、"编辑参团人"弹窗:  1出境,2国内
        function edit_travel(obj){
        	var travel_man_id = $(obj).attr('data-id');
        	var html = "";
        	 $.post("<?php echo base_url();?>admin/b2/order_manage/ajax_get_one_travel",
                {'travel_man_id':travel_man_id},
                function(data){
                    data = eval('('+data+')');
                    		html = "<tr height='30'>";
                    		html += "<td class='order_info_title'>姓名:</td>";
                           html += "<td><input style='width:100%' type='text' name='travel_name' id='travel_name' value='"+data['name']+"'></td>";
                           html += "</tr>";
                           if(op_line_type==1){
        	                   html += "<tr height='30'>";
        	                   html += "<td class='order_info_title'>英文名:</td>";
        	                   html += "<td><input style='width:100%' type='text' name='travel_en_name' id='travel_en_name' value='"+data['enname']+"'></td>";
        	                   html += "</tr>";
                           }
                           html += "<tr height='30'>";
                           html += "<td class='order_info_title'>性别:</td>";
                           html += "<td><select name='sex'>";
                           if(data['sex']==1){
                           	 html += "<option value='1' selected ='selected'>男</option>";
                           	 html += "<option value='0'>女</option>";
                           }else{
                           	html += "<option value='1'>男</option>";
                           	 html += "<option value='0' selected ='selected'>女</option>";
                           }
                           html += "</select></td>";
                           html += "</tr>";
                           html += "<tr height='30'>";
                           html += "<td class='order_info_title'>证件类型:</td><td><select name='certificate_type'>";
                           //data['certificate_type']
                            $.each(certificate ,function(key ,val) {
                            	if(data['certificate_type']==val.dict_id){
                            		html += "<option value='"+val.dict_id+"' selected='selected'>"+val.description+"</option>";
                            	}else{
                            		html += "<option value='"+val.dict_id+"'>"+val.description+"</option>";
                            	}
                             });
                           html += "</select></td></tr>";
                           html += "<tr height='30'>";
                           html += "<td class='order_info_title'>证件号码:</td>";
                           html += "<td><input style='width:100%' type='text' name='cer_num' id='cer_num' value='"+data['certificate_no']+"'></td>";
                           html += "</tr>";
                           html += "<tr height='30'>";
                           html += "<td class='order_info_title'>出生日期:</td>";
                           html += "<td><input type='text' style='width:100%' name='birthday' id='birthday' value='"+data['birthday']+"'></td>";
                           html += "</tr>";
                            html += "<tr height='30'>";
                           html += "<td class='order_info_title'>联系电话:</td>";
                           html += "<td><input type='text' style='width:100%' name='telephone' id='telephone' value='"+data['telephone']+"'></td>";
                           html += "</tr>";
                           $("#edit_travel_id").val(data['id']);
                    		$("#edit_travel_info").html(html);
        	            $('#birthday').datetimepicker({
        	                                lang:'ch', //显示语言
        	                                timepicker:false, //是否显示小时
        	                                format:'Y-m-d', //选中显示的日期格式
        	                                formatDate:'Y-m-d',
        	                                validateOnBlur:false,
        	                                yearStart:1930
        	             });
        	             layer.open({
        	                    type: 1,
        	                    title: false,
        	                    closeBtn: 0,
        	                    area: ['700px','400px'],
        	                    shadeClose: false,
        	                    content: $('#show_edit_man_modal')
        	         		 });
                }
            );
        }
       //16、"编辑参团人"提交按钮
       $("body").on("click",".btn_edit_people",function(){
     	    var flag = COM.repeat('btn');//频率限制
            if(!flag)
            {
        	  $.post(
                     "<?php echo base_url();?>admin/b2/order_manage/edit_people",
                    $('#edit_travel_form').serialize(),
                    function(data){
                            data = eval('('+data+')');
                            if (data.status == 200){
                            	tan_alert(data.msg);
                                
                            }else{
                            	tan_alert(data.msg);
                            }
                    }
                );
           }
            
        });
   //17、 计算已交款：
   function cal_yj(obj)
   {
      	 check_danjia(obj);
         var ys_val = $(obj).val();
         if($("#refund_yj").attr('readonly')!=undefined){
              $("#refund_yj").val(ys_val);
         }
    }
   function remove_zero(obj)
   {
	   if($(obj).val()==0)
		   $(obj).val("");
   }
   function add_zero(obj)
   {
	   if($(obj).val()=="")
		   $(obj).val("0");
   }
   
    //18、 单价：正数、负数、小数  
   	function check_danjia(obj){
   		var value=$(obj).val();
   		value=value.replace(/[^\- \d.]/g,'');  //   ;  /[^\- \d.]/g  正数、负数、小数 ;   /[^\d]/g   只能正数、小数 ;  
   		$(obj).val(value);
   		cal_total(obj);
   	}
   	//19、数量：正数、小数  
   	function check_shuliang(obj){
   		var value=$(obj).val();
   		value=value.replace(/[^\d]/g,'');  //   ;  /[^\- \d.]/g  正数、负数、小数 ;   /[^\d]/g   只能正数、小数 ;  
   		$(obj).val(value);
   		cal_total(obj);
   	}
   	//小计：计算
   	function cal_total(obj)
   	{
   		var price = $(obj).parent().parent().find(".danjia").val();
   		var num = $(obj).parent().parent().find(".shuliang").val();
	    var total;
	    if(price==null||price=="") price=0;
	    if(num==null||num=="") num=1;
	    total =toDecimal2(price*num);
	    $(obj).parent().parent().find(".total_money").html(total);
   	}
      /* //17、检测数量
	  function check_shuliang(obj)
	  {
	   		var num = $(obj).val();
	   		var price = $(obj).parent().siblings("td").find(".danjia").val();
	   		var total;
	   		total = price*num;
	   		if(num==0 || num=='' || num==1){
	                 $(obj).parent().siblings(".total_money").html(price);
	                 //$(obj).parent().siblings("td").find(".shuliang").val(0);
	           }else{
	                 $(obj).parent().siblings(".total_money").html(total);
	           }
	  }
   	  //18、检测单价
      function check_danjia(obj)
   	  {
   		   var price = $(obj).val();
   		   var num = $(obj).parent().siblings("td").find(".shuliang").val();
   		   var total;
           total = price*num;
           alert(total);
           if(num==0 || num=='' || num==1){
                  $(obj).parent().siblings(".total_money").html(price);
                  //$(obj).parent().siblings("td").find(".shuliang").val(0);
           }else{
                  $(obj).parent().siblings(".total_money").html(total);
           }
   	   } */
       //20、查看行程
       $("body").on("click",".see_trip",function(){
              var line_id=$(this).attr("line_id");
             //  弹窗查看行程 
             var win1 = window.open("<?php echo base_url('admin/b2/union/travel_print');?>"+"?id="+line_id,'print','height=950,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes, resizable=yes,location=no, status=no');
             win1.focus();
       });

       //20.1、删除合同
       $("body").on("click",".contract_label b",function(){
              var data_id=$(this).attr("data-id");
              var data_type=$(this).attr("data-type");

              layer.confirm('是否要删除该合同？', { btn: ['是','否'] }, function(){
                  //"是"操作
              $.post(
                      "<?php echo base_url();?>admin/b2/order_manage/del_contract",
                      {data_type:data_type,data_id:data_id},
                     function(data){
                             data = eval('('+data+')');
                             if (data.status == 200){
                             	tan_alert(data.msg);
                                $(this).parent().remove();
                             }else{
                             	tan_alert(data.msg);
                             }
                     }
                 );
        		  //end
             },function(){
                    //"否"操作
                 }
             );
       });
       //20.2、删除发票、收据
       $("body").on("click",".invoice_label b",function(){
              var data_id=$(this).attr("data-id");
              var data_type=$(this).attr("data-type");
              var type_name="发票";
              if(data_type=="1")  type_name="发票"; else type_name="收据";
              layer.confirm('是否要删除该'+type_name+'？', { btn: ['是','否'] }, function(){
                  //"是"操作
              $.post(
                      "<?php echo base_url();?>admin/b2/order_manage/del_invoice",
                      {data_type:data_type,data_id:data_id},
                     function(data){
                             data = eval('('+data+')');
                             if (data.status == 200){
                             	tan_alert(data.msg);
                                $(this).parent().remove();
                             }else{
                             	tan_alert(data.msg);
                             }
                     }
                 );
        		  //end
             },function(){
                    //"否"操作
                 }
             );
       });
       
       
   	   //21、拒绝供应商修改成本  弹窗
	   	function refuse_b1(obj)
	    {
	         var order_id = $(obj).attr('data-order');
	         var id = $(obj).attr('data-id');
	         $("#refuse_b1_id").val(id);
	         $("#refuse_b1_order_id").val(order_id);
	          layer.open({
	                  type: 1,
	                  title: false,
	                  closeBtn: 0,
	                  area: '800px',
	                  shadeClose: false,
	                  content: $('#refuse_reasom_modal')
	            });
	    }
	    //22、拒绝供应商修改成本：数据提交
	    $("body").on("click",".btn_refuse_reasom",function(){
	    	 var flag = COM.repeat('btn');//频率限制
	         if(!flag)
	         {
	    	     $.post("<?php echo base_url();?>admin/b2/order_manage/refuse_b1",
                     $('#refuse_reasom_form').serialize(),
                     function(data){
                         data = eval('('+data+')');
                         tan_alert(data['msg']);
                         
                     }
                 );
	        }
	    })
	    //23、同意修改供应商成本
	    function pass_b1(obj)
	    {
	        $(obj).remove();
	        var order_id = $(obj).attr('data-order');
	        var id = $(obj).attr('data-id');
	        $(obj).remove();
	        $.post("<?php echo base_url();?>admin/b2/order_manage/pass_b1",
	                {'order_id':order_id,'id':id},
	                function (data){
	                    data = eval('('+data+')');
	                    tan_alert(data['msg']);
	                   
	                }
	            );
      }
      //24、撤销额度申请
		function cancle_apply(obj)
		{
		  var order_id = $(obj).attr('order-id');
		  var expert_id = $(obj).attr('expert-id');
		  $.post("<?php echo base_url();?>admin/b2/credit_approval/ajax_cancle_order_apply",
		        {'order_id':order_id,'expert_id':expert_id},
		        function(data){
		            data = eval('('+data+')');
		
		            if(data.status == 200){
		                tan_alert(data.msg);
		                
		            }else{
		            	tan_alert(data.msg);
		            }
		        }
		    );
		}
		//25、新增合同
		function add_contract(obj){
		    var contract_sn = $("#contract_sn").val();
		    var order_id = $(obj).attr('data-orderid');
		    if(contract_sn=="") {tan("请输入合同编号");return false;}
		    $.post("<?php echo base_url();?>admin/b2/order_manage/add_contract",
		           {'contract_sn':contract_sn,'order_id':order_id,'op_line_type':op_line_type},
		                  function(data){
		                          data = eval('('+data+')');
		                          //console.log(data);
		                          if(data['status']=='200'){
		                               
		                                var str="<label class='tab_del contract_label'>"+data.data.contract_code+"";
		                                    str+="<b data-type='"+data.data.type+"' data-id='"+data.data.data_id+"'></b>";
		                                    str+="</label>";
		                        	  $("#div_contract").append(str);
		                                
		                          }else{
		                                tan(data['msg']);
		                          }
		                 }
		            );
		}
		//26、新增发票和收据
		function add_invoice_receipt(obj)
		{
		    var invoice_receipt_sn = $("#invoice_receipt_sn").val();
		    var order_id = $(obj).attr('data-orderid');
		    var add_type = $("#select_invoice_receipt").val();
		    if(add_type==''){
		        tan('请选择是新增发票还是收据');
		        return false;
		    }
		    if(invoice_receipt_sn=="") { if(add_type=="1") tan('请输入发票编号');else tan('请输入收据编号'); return false; }
		    $.post("<?php echo base_url();?>admin/b2/order_manage/add_invoice_receipt",
		                  {'invoice_receipt_sn':invoice_receipt_sn,'order_id':order_id,'add_type':add_type},
		                  function(data){
		                       data = eval('('+data+')');
		                      if(data['status']=='200'){
		                    	  type_name="发票";
			                      if(add_type=="1")
				                      type_name="发票";
			                      else
				                      type_name="收据";
		                    	  var str="<label class='tab_del invoice_label'>"+type_name+"："+data.data.code+"";
                                  str+="<b data-type='"+data.data.type+"' data-id='"+data.data.data_id+"'></b>";
                                  str+="</label>";
                      	 		  $("#div_invoice").append(str);
		                      }else{
		                            tan(data['msg']);
		                      }
		                  }
		        );
		}
	  //27、上传、查看流水单图片
	  function upload_water(obj)
		{
		  var file_id = $(obj).attr("id");
		  var inputObj = $(obj).nextAll("input[type='hidden']");
		  $.ajaxFileUpload({
		      url : '/admin/upload/uploadImgFile',
		      secureuri : false,
		      fileElementId : file_id,// file标签的id
		      dataType : 'json',// 返回数据的类型
		      data : {
		        fileId : file_id
		      },
		      success : function(data, status){
		        if (data.code == 2000) {
		            inputObj.nextAll("span").remove();
		            inputObj.after("<span style='color:blue'>已上传|<a data-pic='"+data.msg+"' onclick='show_water_pic(this)'>查看</a></span>");
		            inputObj.val(data.msg);
		            $("#show_water_pic").attr('data-pic',data.msg);
		        } else {
		        	tan_alert_noreload(data.msg);
		        }
		      },
		      error : function(data, status, e)// 服务器响应失败处理函数
		      {
		    	  tan_alert_noreload('上传失败(请选择jpg/jpeg/png的图片重新上传)');
		      }
		  });
		}
		function show_water_pic(obj)
		{
		        var pic_url = $(obj).attr('data-pic');
		        if(pic_url==null || pic_url==""){
		             tan('暂无流水单图片');
		            return false;
		        }
		        $("#show_pic_modal").find('img').attr('src',pic_url);
		        layer.open({
		                    type: 1,
		                    title: false,
		                    closeBtn: 0,
		                    area: ['340px','400px'],
		                    shadeClose: false,
		                    content: $('#show_pic_modal')
		        });
		}
		//28、交款方式切换
		function change_pay_way(obj)
		{
		    var bankname_str = '';
		    if($(obj).val()=="转账")
		    {
		      $.post("<?php echo base_url();?>admin/b2/pay_manage/get_depart_bank",
		              {'bank_id':''},
		              function(data)
		              {
		                          data = eval('('+data+')');
		                          $("#bank_info").val(data['bankname']);
		                          $("#bank_num").val(data['bankcard']);
		                           $(obj).siblings("#bank_info").show();
		                           $(obj).siblings("#bank_num").show();
		                           $("#balance_cash_limit").hide();
		               }
		            );
		    }
		    else if($(obj).val()=="账户余额")
		    {
		           $("#bank_info").val('');
		           $("#bank_num").val('');
		           $(obj).siblings("#bank_info").hide();
		           $(obj).siblings("#bank_num").hide();
		           $("#balance_cash_limit").show();
		    }else
		    {
		           $("#bank_info").val('');
		           $("#bank_num").val('');
		           $(obj).siblings("#bank_info").hide();
		           $(obj).siblings("#bank_num").hide();
		           $("#balance_cash_limit").hide();
		    }
		}
	  /******   DOM加载    ***********/ 
	     $(document).ready(function(){

	       // 1、tab切换
		   $(".itab ul li").click(function(){
				var index = $(this).index();
				var nav_num = $(".itab").index($(this).parent());
				$(this).siblings().removeClass("active");
				$(this).addClass("active");
				$(this).parent().parent().siblings(".tab_content").find(".table_list").hide();
				$(this).parent().parent().siblings(".tab_content").find(".table_list").eq(index).show();
                if($(this).attr('status')==4){
                            reload_receive();
                     }else if($(this).attr('status')==1){
                            reload_ys();
                     }else if($(this).attr('status')==3){
                            reload_yf();
                     }else if($(this).attr('status')==2){
                            reload_diplomatic();
                     }
		   });

           //2、异步重新加载：交款
           function reload_receive()
           {
                  var order_id = op_order_id;
                  $.post("<?php echo base_url('admin/b2/order_manage/ajax_show_receive')?>",
                           {'order_id':order_id},
                           function(data){
                                            data = eval('('+data+')');
                                            var html_str = "";
                                            var receive_status="";
                                            $.each(data ,function(key ,val) {
                                                if(key!="no_receive_amount" && key!="sum_receive"){
                                                    /*if(val['status']==3 || val['status']==4 || val['status']==6){
                                                        html_str += "<tr class='jujue'>";
                                                    }else if(val['status']==2){
                                                        html_str += "<tr class='tongguo'>";
                                                    }else{
                                                        html_str += "<tr class='shenhe'>";
                                                    }*/
                                                      switch(val['status']){
										case '1':
											receive_status="经理已提交";
										  break;
										case '2':
										  	receive_status="已审核";
										  break;
										  case '3':
										  	receive_status="旅行社拒绝";
										  break;
										  case '4':
										  	receive_status="经理已拒绝";
										  break;
										  case '5':
										  	receive_status="待经理审核";
										  break;
										  case '6':
										  	receive_status="供应商拒绝";
										  break;
										default:
											receive_status="未提交";
										  break;
									}
                                    html_str += "<tr>";
                                    html_str +="<td>"+receive_status+"</td>";
                                    html_str +="<td>"+val['addtime']+"</td>";
                                    html_str +="<td>"+val['money']+"</td>";
                                    html_str +="<td>"+val['remark']+"</td>";
                                    if(val['way']=='转账')
                                    {
                                       html_str +="<td>"+val['way']+"("+val['bankname']+"/"+val['bankcard']+")"+"</td>";
                                    }else{
                                       html_str +="<td>"+val['way']+"</td>";
                                    }
                                   html_str +="<td><a   data-pic='"+val['code_pic']+"' onclick='show_water_pic(this)'>查看</a></td>";
                                   if(val['is_urgent']==1){
                                       html_str +="<td>是</td>";
                                   }else{
                                       html_str +="<td>否</td>";
                                   }
                                   html_str +="<td>"+val['realname']+"</td>";
                                   html_str +="</tr>";

                                  }
                           });
                       html_str +="<tr class='zongji zongji3'><td colspan='8' style='text-align:right;'><span>总计：<i>"+data['sum_receive']+"</i>元 </span></td></tr>";

                       $("#receive_data_list").html(html_str);
                       $("#unreceive_amount").html('未收款:'+data['no_receive_amount']);
                 });
              }

             //3、异步重新加载：应收
             function reload_ys()
             {
                   var order_id = op_order_id;
                   $.post("<?php echo base_url('admin/b2/order_manage/ajax_show_ys')?>",
                           {'order_id':order_id},
                           function(data){
                                            data = eval('('+data+')');
                                            var html_str = "";
                                            var status_ys="";
                                            $.each(data ,function(key ,val) 
                                            {
                                                if(key!="sum_ys"){
                                                        if(val['status']==3 ){
                                                            html_str += "<tr class='jujue'>";
                                                            status_ys +="已拒绝";
                                                        }else if(val['status']==1){
                                                            html_str += "<tr class='tongguo'>";
                                                            status_ys +="已通过";
                                                        }else{
                                                            html_str += "<tr class='shenhe'>";
                                                            status_ys +="审核中";
                                                        }
                                                        html_str +="<td><i></i></td>";
                                                        html_str +="<td>"+val['item']+"</td>";
                                                        html_str +="<td>"+val['remark']+"</td>";
                                                        html_str +="<td>"+val['price']+"</td>";
                                                        html_str +="<td>"+val['num']+"</td>";
                                                        html_str +="<td>"+val['amount']+"</td>";
                                                        html_str +="<td>"+val['addtime']+"</td>";
                                                        html_str +="<td>"+val['e_name']+"</td>";
                                                        html_str +="</tr>";

                                                }
                                            });
                                             html_str +="<tr class='zongji zongji3'><td colspan='8' style='text-align:right;'><span>总计：<i>"+data['sum_ys']+"</i>元 </span></td></tr>";
                                             $("#receive_data_list").html(html_str);
                 });
             }

            //4、异步重新加载：应付
            function reload_yf()
            {
                  var order_id = op_order_id;
                  $.post("<?php echo base_url('admin/b2/order_manage/ajax_show_yf')?>",
                          {'order_id':order_id},
                          function(data){
                                            data = eval('('+data+')');
                                            var html_str = "";
                                            var status_yf="";
                                            $.each(data ,function(key ,val) {
                                                if(key!="sum_yf"){
                                                        if(val['status']==4 || val['status']==3 ){
                                                            html_str += "<tr class='jujue'>";
                                                            status_yf ="已拒绝";
                                                        }else if(val['status']==2){
                                                            html_str += "<tr class='tongguo'>";
                                                            status_yf ="已通过";
                                                        }else{
                                                            html_str += "<tr class='shenhe'>";
                                                            status_yf ="审核中";
                                                        }
                                                        html_str +="<td style='width:70px;'><i></i>"+status_yf+"</td>";
                                                        html_str +="<td>"+val['item']+"</td>";
                                                        html_str +="<td>"+val['remark']+"</td>";
                                                        html_str +="<td>"+val['price']+"</td>";
                                                        html_str +="<td>"+val['num']+"</td>";
                                                        html_str +="<td>"+val['amount']+"</td>";
                                                        html_str +="<td>"+val['addtime']+"</td>";
                                                        html_str +="<td>"+val['user_name']+"</td>";
                                                        if(val['user_type']==2 && val['status']==0){
                                                             html_str +="<td><a data-id="+val['id']+" data-order="+val['order_id']+" onclick='pass_b1(this)''>通过</a><a data-id="+val['id']+" data-order="+val['order_id']+" onclick='refuse_b1(this)''>拒绝</a></td>";
                                                        }else{
                                                             html_str +="<td></td>";
                                                        }
                                                        html_str +="</tr>";
                                                }
                                            });
                                             html_str +="<tr class='zongji zongji2'><td colspan='9' style='text-align:right;'><span>总计：<i>"+data['sum_yf']+"</i>元 </span></td></tr>";
                                             $("#yf_data_list").html(html_str);
                });
           }
          //5、异步重新加载：外交佣金
          function reload_diplomatic()
          {
                   var order_id = op_order_id;
                   $.post("<?php echo base_url('admin/b2/order_manage/ajax_show_diplomatic')?>",
                           {'order_id':order_id},
                            function(data){
                                            data = eval('('+data+')');

                                            var html_str = "";
                                            $.each(data ,function(key ,val) {
                                                if(key!="sum_commission"){
                                                    html_str +="<tr>";
                                                        html_str +="<td>"+val['item']+"</td>";
                                                        html_str +="<td>"+val['remark']+"</td>";
                                                        html_str +="<td>"+val['price']+"</td>";
                                                        html_str +="<td>"+val['num']+"</td>";
                                                        html_str +="<td>"+val['amount']+"</td>";
                                                        html_str +="<td>"+val['user_name']+"</td>";
                                                        html_str +="</tr>";
                                                }
                                            });

                                             html_str +="<tr class='zongji zongji1'><td colspan='8' style='text-align:right;'><span>总计：<i>"+data['sum_commission']+"</i>元 </span></td></tr>";
                                              //console.log(html_str);
                                             $("#diplomatic_agent_list").html(html_str);
                });
           }
                 
	});// DOM加载完毕


/**
 * @param  type  加减的类型   1：加     2：减
 * @param  people_type 出游人类型 1:'成人',2:'老人',3:'儿童占床',4:'儿童不占床'
 */
function changeTraverNum(obj,people_type, type,is_suit) 
{
        var travelObj = op_line_type == 1 ? $(".traver_list1") : $(".traver_list2");
        var typeArr = {1:'成人',2:'老人',3:'儿童占床',4:'儿童不占床'};
        if(is_suit!=1)
        {
          //不是套餐订单,就是普通一个一个的添加
                var people_len = travelObj.find('.people_type_'+people_type).length;
                var len = travelObj.find('ul').length;
                len = len == 0 ? 1 : len;
                if(type==1)
                {
                   if(len>surplus_num){
                            alert('已经超过余位数量');
                            return false;
                   }
                   if (op_line_type == 1) 
                   { //境外
                         var html = '<ul class="people_type_'+people_type+'">';
                             html += '<li class="grade">'+len+'</li>';
                             html += '<li class="chinese_name"><input type="text" name="name[]"></li>';
                             html += '<li class="english_name"><input type="text" name="enname[]" placeholder="英文名"></li>';
                             html += '<li class="gender">';
                             html += '<select name="sex[]" style="width:100%">';
                             html += '<option value="2" selected="selected">选择</option>';
                             html += '<option value="1">男</option>';
                             html += '<option value="0">女</option></select></li>';
                             html += '<li class="id_type"><select name="card_type[]" style="width: 80px;"><option value="0">请选择</option>';
                          $.each(certificate ,function(key ,val) {
                             html += '<option value="'+val.dict_id+'" style="max-width: 80px;">'+val.description+'</option>';
                          });
                             html += '</select></li>';
                             html += '<li class="zhengjian_number"><input type="text"  class="zhengjian_pt" name="card_num[]"></li>';
                             html += '<li class="date_birth"><input type="text" id="datetimepicker'+len+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]" ></li>';
                             html += '<li class="issue_di"><input type="text" name="sign_place[]" maxlength="11"></li>';
                             html += '<li class="issue_date"><input type="text" id="sign_time'+len+'" class="date-time" name="sign_time[]" maxlength="10"></li>';
                             html += '<li class="validity"><input type="text" id="endtime'+len+'" class="date-time" name="endtime[]" maxlength="10"></li>';
                             html += '<li class="phone_number"><input type="text" name="tel[]" maxlength="11"></li>';
                             html += '<li class="people_type">'+typeArr[people_type]+'</li>';
                             html += '<input type="hidden" name="people_type[]" value="'+people_type+'">';
                             html += "</ul>";
                             travelObj.append(html);
                             $('#datetimepicker'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false,
                                                yearStart:1930
                               });
                               $('#endtime'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false
                                });
                                $('#sign_time'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false
                                 });
                                $('.date-time').isDate();

                    }
                    else 
                    { //境内
                            var html = '<ul class="people_type_'+people_type+'">';
                                html += '<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">'+len+'</li>';
                                html += '<li><input type="text" name="name[]"></li>';
                                html += '<li style="margin-right:0px; width:75px;">';
                                html += '<select name="sex[]">';
                                html += '<option value="2" selected="selected">请选择</option>';
                                html += '<option value="1">男</option>';
                                html += '<option value="0">女</option></select></li>';
                                html += '<li><select  name="card_type[]" >';
                                html += '<option value="0" >请选择</option>';
                             $.each(certificate ,function(key ,val) {
                                html += '<option value="'+val.dict_id+'">'+val.description+'</option>';
                             })
                                html += '</select></li>';
                                html += '<li><input type="text"  class="zhengjian_pt" name="card_num[]"></li>';
                                html += '<li><input type="text" id="datetimepicker'+len+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]"></li>';
                                html += '<li><input type="text" name="tel[]" maxlength="11"></li>';
                                html += '<li style="padding:0;">';
                                html += '<a href="javascript:void(0);" class="btn-del" >'+typeArr[people_type]+'</a>';
                                html += '<input type="hidden" name="people_type[]" value="'+people_type+'">';
                                html += '</li></ul>';
                                travelObj.append(html);
                                $('#datetimepicker'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false
                                });
                                $('.date-time').isDate();
                     }
                 }
                else
                {
                      travelObj.find('.people_type_'+people_type).eq(people_len-1).remove();
                }
                people_len = travelObj.find('.people_type_'+people_type).length;
                switch(people_type){
                                    case 1:
                                        $("#adult_price").html(people_len*adultprice);
                                        break;
                                    case 2:
                                        $("#old_price").html(people_len*oldprice);
                                        break;
                                    case 3:
                                        $("#child_price").html(people_len*childprice);
                                        break;
                                    case 4:
                                        $("#child_nobed_price").html(people_len*childnobedprice);
                                        break;
                 }
                 $(obj).parent().find("input").val(people_len);
       }
       else
       { //是套餐订单,只能一套一套的添加
                 var people_len = travelObj.find('.people_type_'+people_type).length;
                 var len = travelObj.find('ul').length;
                 len = len == 0 ? 1 : len;
                 var left_num = (surplus_num-len)/unit;
                 if(type==1)
                 {
                       if(left_num<1){
                                alert('已经超过余位数量');
                                return false;
                        }
                       if (op_line_type == 1) 
                       { //境外
                               for (var i=1;i<=unit;i++)
                                   {
                                        var html = '<ul class="people_type_'+people_type+'">';
                                        html += '<li class="grade">'+len+'</li>';
                                        html += '<li class="chinese_name"><input type="text" name="name[]"></li>';
                                        html += '<li class="english_name"><input type="text" name="enname[]" placeholder="英文名"></li>';

                                        html += '<li class="gender">';
                                        html += '<select name="sex[]" style="width:100%">';
                                        html += '<option value="2" selected="selected">选择</option>';
                                        html += '<option value="1">男</option>';
                                        html += '<option value="0">女</option></select></li>';
                                        html += '<li class="id_type"><select name="card_type[]" style="width: 80px;"><option value="0">请选择</option>';
                                        $.each(certificate ,function(key ,val) {
                                            html += '<option value="'+val.dict_id+'" style="max-width: 80px;">'+val.description+'</option>';
                                        })
                                        html += '</select></li>';
                                        html += '<li class="zhengjian_number"><input type="text"  class="zhengjian_pt" name="card_num[]"></li>';
                                        html += '<li class="date_birth"><input type="text" id="datetimepicker'+len+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]" ></li>';
                                        html += '<li class="issue_di"><input type="text" name="sign_place[]" maxlength="11"></li>';
                                        html += '<li class="issue_date"><input type="text" id="sign_time'+len+'" class="date-time" name="sign_time[]" maxlength="10"></li>';
                                        html += '<li class="validity"><input type="text" id="endtime'+len+'" class="date-time" name="endtime[]" maxlength="10"></li>';
                                        html += '<li class="phone_number"><input type="text" name="tel[]" maxlength="11"></li>';
                                        html += '<li class="people_type">'+typeArr[people_type]+'</li>';
                                        html += '<input type="hidden" name="people_type[]" value="'+people_type+'">';
                                        html += "</ul>";
                                            travelObj.append(html);
                                            $('#datetimepicker'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false,
                                                yearStart:1930
                                            });
                                            $('#endtime'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false
                                            });
                                            $('#sign_time'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false
                                            });
                                            $('.date-time').isDate();
                                   }

                      }
                      else 
                      { //境内
                           for (var i=0; i<unit; i++)
                           {
                                            var html = '<ul class="people_type_'+people_type+'">';
                                            html += '<li class="lv_xuanxiang" style=" margin-right:0px;width:49px;">'+len+'</li>';
                                            html += '<li><input type="text" name="name[]"></li>';
                                            html += '<li style="margin-right:0px; width:75px;">';
                                            html += '<select name="sex[]">';
                                            html += '<option value="2" selected="selected">请选择</option>';
                                            html += '<option value="1">男</option>';
                                            html += '<option value="0">女</option></select></li>';
                                            html += '<li><select  name="card_type[]" >';
                                            html += '<option value="0" >请选择</option>';
                                            $.each(certificate ,function(key ,val) {
                                                html += '<option value="'+val.dict_id+'">'+val.description+'</option>';
                                            })
                                            html += '</select></li>';
                                            html += '<li><input type="text"  class="zhengjian_pt" name="card_num[]"></li>';
                                            html += '<li><input type="text" id="datetimepicker'+len+'" style="ime-mode:disabled;" maxlength="10" class="shengri_pt date-time" name="birthday[]"></li>';
                                            html += '<li><input type="text" name="tel[]" maxlength="11"></li>';
                                            html += '<li style="padding:0;">';
                                            html += '<a href="javascript:void(0);" class="btn-del" >'+typeArr[people_type]+'</a>';
                                            html += '<input type="hidden" name="people_type[]" value="'+people_type+'">';
                                            html += '</li></ul>';

                                            travelObj.append(html);
                                            $('#datetimepicker'+len).datetimepicker({
                                                lang:'ch', //显示语言
                                                timepicker:false, //是否显示小时
                                                format:'Y-m-d', //选中显示的日期格式
                                                formatDate:'Y-m-d',
                                                validateOnBlur:false
                                            });
                                            $('.date-time').isDate();
                                            len++;
                            }
                        }
               }
               else
               {
                      for(var i=0; i<unit; i++){
                                     travelObj.find('.people_type_'+people_type).last().remove();
                      }
               }
               people_len = travelObj.find('.people_type_'+people_type).length;
               $(obj).parent().find("input").val(people_len/unit);
               $("#suit_price").html(adultprice*people_len/unit);
     }
}


//(废弃)
function choose_bank(obj)
{
    var bank_id = $(obj).find("option:selected").attr("data-id");
    $.post("<?php echo base_url();?>admin/b2/pay_manage/get_depart_bank",
                      {'bank_id':bank_id},
                      function(data){
                          data = eval('('+data+')');
                          $("#bank_num").val(data[0]['bankcard']);
                      }
            );
}
//新增发票(废弃)
function add_invoice(obj){
    var invoice_sn = $("#invoice_sn").val();
    var order_id = $(obj).attr('data-orderid');
    $.post("<?php echo base_url();?>admin/b2/order_manage/add_invoice",
                      {'invoice_sn':invoice_sn,'order_id':order_id,'op_line_type':op_line_type},
                      function(data){
                           data = eval('('+data+')');
                          if(data['status']=='200'){
                                var str_invoice_code = $("#added_invoice").html();
                                if(str_invoice_code.length>0){
                                    $("#added_invoice").html(str_invoice_code+','+data['msg']);
                                }else{
                                    $("#added_invoice").html(data['msg']);
                                }
                          }else{
                                tan(data['msg']);
                          }
                      }
            );
}

//新增收据(废弃)
function add_receipt(obj)
{
    var receipt_sn = $("#receipt_sn").val();
    var order_id = $(obj).attr('data-orderid');
    $.post("<?php echo base_url();?>admin/b2/order_manage/add_receipt",
                      {'receipt_sn':receipt_sn,'order_id':order_id,'op_line_type':op_line_type},
                      function(data){
                           data = eval('('+data+')');
                          if(data['status']=='200'){
                                var str_receipt_code = $("#added_receipt").html();
                                if(str_receipt_code.length>0){
                                    $("#added_receipt").html(str_receipt_code+','+data['msg']);
                                }else{
                                    $("#added_receipt").html(data['msg']);
                                }

                          }else{
                                tan(data['msg']);
                          }
                      }
            );
}
//(废弃)
function openWin(settings)
{
    var idx = layer.open(settings);
    if(settings.full==true){
        layer.full(idx);
    }
}

</script>
