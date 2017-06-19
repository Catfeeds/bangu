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
	
	.table thead>tr>th { padding:5px 0;font-weight:normal;border-right:1px solid #ddd;}
	.table thead>tr>th:last-child { border-right:0;}
	.apple_tuiding { padding:0px 5px;margin-left:20px;position:relative;top:-3px;}
	input[type="checkbox"] { position:relative;opacity:1;left:0;width:auto;height:auto;}
	.layui-layer-page { margin-left:0;}
	.title_txt { float:right;width:14%;display:inline-block;}
	.title_txt p { color:#f00;}
	
	.close_page { padding-top:50px;height:60px;background:#fff;text-align:center;}
	
	select { padding:0;}
	
	.data_list { padding:10px 10px;}
	.data_list_con { float:left;width:50%;box-sizing:border-box;}
	.data_list_con:nth-child(2n+1) { padding-right:30px;}
	.data_list_con:nth-child(2n) { padding-left:30px;}
	
	.small_title_txt { padding-bottom:0;margin-bottom:10px;position:relative;}
	.btn.layui-layer-close { position:relative;}
	.check_btn { display:inline-block;position:absolute;right:10px;bottom:3px;padding:2px 20px;border:1px solid #ddd;border-radius:3px;cursor:pointer;font-size:12px;}

	.btn_close{
	    background: #2DC3E8;
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
	.btn_check{
	    background: #da411f;
	    width: 70px;
	
	    margin-left: 20px;
	    margin-bottom: 40px;
	    padding: 5px 10px;
	    border-radius: 3px;
	    color: #fff;
	    border: none;
	    text-align: center;
	    cursor: pointer;
	}
	
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
    <div class="fb-form">
        <!-- ===============订单详情============ -->
        <div class="order_detail">
            <h2 class="lineName headline_txt"><?php echo $order['productname'];?></h2>
            
            <!-- ===============基础信息============ -->
          <div class="content_part">
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
                        <td><?php echo $order['receive_price'];?></td>
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
                        <td><?php echo $order['company_name'];?>（<?php echo $order['linkman'];?>/<?php echo $order['supplier_mobile'];?>/<?php echo $order['supplier_telephone'];?>）</td>
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
                        <td><?php echo $order['invoice_code'];?></td>
                        <td class="order_info_title">收据/发票:</td>
                        <td>
                        <?php 
                        
                        echo isset($order['contract_code'])==true?$order['contract_code']:'';
                        echo "&nbsp;";
                        echo isset($order['receipt_code'])==true?$order['receipt_code']:'';
                        
                        ?>
                        
                        </td>
                    </tr>
                </table>
            </div>
     		
            <div class="data_list clear">
                <div class="data_list_con">
                    <div class="small_title_txt clear">
                        <span class="txt_info fl">应收客人（<i><?php if($order['ys_lock']=="1") echo "已核算";else echo "未核算";?></i>）</span>
                        <!--  
                        <span class="check_ys check_btn" data-value="<?php echo $order['ys_lock'];?>"><?php if($order['ys_lock']=="1") echo "撤销核算";else echo "核算";?></span>
                        -->
                    </div>
                    <table class="table table-bordered table_hover">
                        <thead>
                            <tr>
<!--                           		<th>状态</th> -->
                                <th>项目</th>
                                <th>金额</th>
                                <th>数量</th>
                                <th>小计</th>
                                <th>审核状态</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php $total_yf=0;if(!empty($order['ys'])):  //应收客人  ?>
                              <?php foreach ($order['ys'] as $k2=>$v2):?>
                              
                               <tr class="<?php if($v2['status']=='0') echo 'shenhe';else if($v2['status']=='1') echo 'tongguo';else if($v2['status']=='3') echo 'jujue'; ?>">
                                <!-- <td><i></i></td> -->
                                <td><?php echo isset($v2['item'])==true?$v2['item']:'';?></td>
                                <td><?php echo isset($v2['price'])==true?$v2['price']:'';?></td>
                                <td><?php echo $v2['num'];?></td>
                                <td><?php echo isset($v2['amount'])==true?$v2['amount']:'';?></td>
                                 <td><i></i><?php if($v2['status']=='0') echo '申请中';else if($v2['status']=="1") echo "已通过";else if($v2['status']=='3') echo '已拒绝'; ?></td>
                            </tr>
                            
                              <?php endforeach;?>
                         <?php endif;?>
                           
                                                       
                        </tbody>
                    </table>
                </div>
                <div class="data_list_con">
                    <div class="small_title_txt clear">
                        <span class="txt_info fl">应付供应商（<i><?php if($order['yf_lock']=="1") echo "已核算";else echo "未核算";?></i>）</span>
                      <!--  
                        <span class="check_yf check_btn" data-value="<?php echo $order['yf_lock'];?>"><?php if($order['yf_lock']=="1") echo "撤销核算";else echo "核算";?></span>  
                       -->
                    </div>
                    <table class="table table-bordered table_hover">
                        <thead>
                            <tr>
                            	<!-- <th>状态</th> -->
                                <th>项目</th>
                                <th>金额</th>
                                <th>数量</th>
                                <th>小计</th>
                                <th>审核状态</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php $total_yf=0;if(!empty($order['yf'])):  //应付供应商   ?>
                              <?php foreach ($order['yf'] as $k=>$v):?>
                              
                               <tr class="<?php if($v['status']=='0'||$v['status']=="1") echo 'shenhe';else if($v['status']=='2') echo 'tongguo';else if($v['status']=='3'||$v['status']=='4') echo 'jujue'; ?>">
                               <!--  <td><i></i></td> -->
                                <td><?php echo isset($v['item'])==true?$v['item']:'';?></td>
                                <td><?php echo isset($v['price'])==true?$v['price']:'';?></td>
                                <td><?php echo $v['num']+$v['oldnum']+$v['childnum']+$v['childnobednum'];?></td>
                                <td><?php echo isset($v['amount'])==true?$v['amount']:'';?></td>
                                <td><i></i><?php if($v['status']=='0') echo '申请中';else if($v['status']=="1") { if($v['user_type']=="1") echo "待销售审核";else echo"待供应商审核";} else if($v['status']=='2') echo '已通过';else if($v['status']=='3'||$v['status']=='4') echo '已拒绝'; ?></td>
                            </tr>
                            
                              <?php endforeach;?>
                         <?php endif;?>                          
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="data_list clear">
            	<div class="data_list_con">
                    <div class="small_title_txt clear">
                        <span class="txt_info fl">应付保险供应商（<i><?php if($order['bx_lock']=="1") echo "已核算";else echo "未核算";?></i>）</span>
                        <!--  
                        <span class="check_bx check_btn" data-value="<?php echo $order['bx_lock'];?>"><?php if($order['bx_lock']=="1") echo "撤销核算";else echo "核算";?></span>
                        -->
                    </div>
                    <table class="table table-bordered table_hover">
                        <thead>
                            <tr>
                                <th>项目</th>
                                <th>金额</th>
                                <th>数量</th>
                                <th>小计</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_yf=0;if(!empty($order['bx'])):  //应付供应商保险   ?>
                              <?php foreach ($order['bx'] as $k3=>$v3):?>
                              
                               <tr>
                                <td><?php echo isset($v3['insurance_name'])==true?$v3['insurance_name']:'';?></td>
                                <td><?php echo isset($v3['price'])==true?$v3['price']:'';?></td>
                                <td><?php echo $v3['num'];?></td>
                                <td><?php echo isset($v3['amount'])==true?$v3['amount']:'';?></td>
                            </tr>
                            
                              <?php endforeach;?>
                         <?php endif;?>                                   
                        </tbody>
                    </table>
                </div>
                
                <div class="data_list_con">
                    <div class="small_title_txt clear">
                        <span class="txt_info fl">操作费（<i><?php if($order['wj_num']=="0"&&$order['yj_num']=="0") echo "已核算";else echo "未核算";?></i>）</span>
                    
                        <span class="check_yj check_btn" data-value="<?php echo $order['yj_lock'];?>"><?php if($order['wj_num']=="0"&&$order['yj_num']=="0") echo "撤销核算";else echo "核算";?></span>  
                        
                    </div>
                    <table class="table table-bordered table_hover fee_table">
                        <thead>
                            <tr>
                           		<!-- <th>状态</th> -->
                                <th>项目</th>
                                <th>金额</th>
                                <th>数量</th>
                                <th>小计</th>
                                <th>收取对象</th>
                                <th>核算状态</th>
                                <th>审核状态</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_yf=0;if(!empty($order['yj'])):  //平台佣金   ?>
                              <?php foreach ($order['yj'] as $k4=>$v4):?>
                              
                               <tr class="<?php if($v4['status']=='0'||$v4['status']=="1") echo 'shenhe';else if($v4['status']=='2') echo 'tongguo';else if($v4['status']=='3'||$v4['status']=='4') echo 'jujue'; ?>">
                               <!--  <td><i></i></td> -->
                                <td><?php echo isset($v4['item'])==true?$v4['item']:'';?></td>
                                <td><?php echo isset($v4['price'])==true?$v4['price']:'';?></td>
                                <td><?php echo $v4['num'];?></td>
                                <td><?php echo isset($v4['amount'])==true?$v4['amount']:'';?></td>
                                <td>供应商</td>
                                <td class="td_lock"><?php echo $v4['is_lock']=='1'?'已核算':'未核算';?></td>
                                <td><i></i><?php if($v4['status']=='0') echo '申请中';else if($v4['status']=="1") echo "待旅行社审核";else if($v4['status']=='2') echo '已通过';else if($v4['status']=='3'||$v4['status']=='4') echo '已拒绝'; ?></td>
                            </tr>
                            
                              <?php endforeach;?>
                         <?php endif;?>   
                         
                          <?php $total_yf=0;if(!empty($order['wj'])):  //外交佣金   ?>
                              <?php foreach ($order['wj'] as $k5=>$v5):?>
                              
                               <tr class="<?php if($v5['status']=='0') echo 'shenhe';else if($v5['status']=='1') echo 'tongguo';else echo 'jujue'; ?>">
                                <!-- <td><i></i></td> -->
                                <td><?php echo isset($v5['item'])==true?$v5['item']:'';?></td>
                                <td><?php echo isset($v5['price'])==true?$v5['price']:'';?></td>
                                <td><?php echo $v5['num'];?></td>
                                <td><?php echo isset($v5['amount'])==true?$v5['amount']:'';?></td>
                                <td>营业部</td>
                                <td class="td_lock"><?php echo $v5['is_lock']=='1'?'已核算':'未核算';?></td>
                                <td><i></i><?php if($v5['status']=='0') echo '申请中';else if($v5['status']=="1") echo "已通过";else  echo '已拒绝'; ?></td>
                            </tr>
                            
                              <?php endforeach;?>
                         <?php endif;?>        
                                                        
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- 
            <div class="data_list clear">
             <div class="data_list_con" style="float: right;padding-right:0;">
                    <div class="small_title_txt clear">
                        <span class="txt_info fl">外交佣金（<i><?php if($order['wj_lock']=="1") echo "已核算";else echo "未核算";?></i>）</span>
                        <span class="check_wj check_btn" data-value="<?php echo $order['wj_lock'];?>"><?php if($order['wj_lock']=="1") echo "撤销核算";else echo "核算";?></span>  
                    </div>
                    <table class="table table-bordered table_hover">
                        <thead>
                            <tr>
                           		<th>状态</th>
                                <th>项目</th>
                                <th>金额</th>
                                <th>数量</th>
                                <th>小计</th>
                                <th>审核状态</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_yf=0;if(!empty($order['wj'])):  //平台佣金   ?>
                              <?php foreach ($order['wj'] as $k5=>$v5):?>
                              
                               <tr class="<?php if($v5['status']=='0') echo 'shenhe';else if($v5['status']=='1') echo 'tongguo';else echo 'jujue'; ?>">
                                <td><i></i></td>
                                <td><?php echo isset($v5['item'])==true?$v5['item']:'';?></td>
                                <td><?php echo isset($v5['price'])==true?$v5['price']:'';?></td>
                                <td><?php echo $v5['num'];?></td>
                                <td><?php echo isset($v5['amount'])==true?$v5['amount']:'';?></td>
                                <td><?php if($v5['status']=='0') echo '申请中';else if($v5['status']=="1") echo "已通过";else  echo '已拒绝'; ?></td>
                            </tr>
                            
                              <?php endforeach;?>
                         <?php endif;?>                                  
                        </tbody>
                    </table>
                </div>
            </div>
            -->
            <div class="close_page">
            <?php 

            if($order['ys_lock']=="1"&&$order['yf_lock']=="1"&&$order['yj_lock']=="1"&&$order['bx_lock']=="1"&&$order['wj_lock']=="1")
            {$value="0";$html="一键撤销";}
            else 
            {$value="1";$html="一键核算";}
            ?>
           <!-- <span class="layui-layer-close btn btn_check" data-value="<?php echo $value;?>"><?php echo $html;?></span> --> 
    
            <span class="layui-layer-close btn btn_close">关闭</span></div>
		</div>
	</div>
</div>
   
</body>

</html>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript">


 function send_ajax_noload(url,data){  //发送ajax请求，无加载层
      //没有加载效果
    var ret;
	  $.ajax({
  	   url:url,
  	   type:"POST",
       data:data,
       async:false,
       dataType:"json",
       success:function(data){
      	 ret=data;
      	
       },
       error:function(){
      	 ret=data;
       }
               
  	});
	    return ret;

}

 var order_id="<?php echo $order_id;?>";
	$(document).ready(function(){
		
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
		$(".btn_close").click(function(){
			t33_close_iframe_noreload();
		})
        //应收 按钮
		$(".check_ys").click(function(){
			  var old=$(this).attr("data-value");
              var value=null;//传递的值
              if(old=="1")
                  value="0";
              else
            	  value="1";
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:value,action:'ys'};
              var return_data=send_ajax_noload(url,post_data);
              
              if(return_data.code=="2000")
              {
                  if(old=="1")
                  {
                      $(this).html("核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("未核算");
                      
                  }
                  else
                  {
                	  $(this).html("撤销核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("已核算");
                      
                  }
              }
              else
              {
                 
                  tan(return_data.msg);
              }
	    })
	    //应付 按钮
		$(".check_yf").click(function(){
			  var old=$(this).attr("data-value");
              var value=null;//传递的值
              if(old=="1")
                  value="0";
              else
            	  value="1";
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:value,action:'yf'};
              var return_data=send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                  if(old=="1")
                  {
                      $(this).html("核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("未核算");
                  }
                  else
                  {
                	  $(this).html("撤销核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("已核算");
                  }
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
	     //保险 按钮
		$(".check_bx").click(function(){
			  var old=$(this).attr("data-value");
              var value=null;//传递的值
              if(old=="1")
                  value="0";
              else
            	  value="1";
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:value,action:'bx'};
              var return_data=send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                  if(old=="1")
                  {
                      $(this).html("核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("未核算");
                  }
                  else
                  {
                	  $(this).html("撤销核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("已核算");
                  }
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
	     //平台佣金 按钮
		$(".check_yj").click(function(){
			  var old=$(this).attr("data-value");
              var value=null;//传递的值
              if(old=="1")
                  value="0";
              else
            	  value="1";
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:value,action:'yj'};
              var return_data=send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                  if(old=="1")
                  {
                      $(this).html("核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("未核算");
                      $(".td_lock").html("未核算");
                   
                      parent.$("#main")[0].contentWindow.parentfun(order_id,'已撤销核算');//父级容器不刷新，做其他动作达到刷新效果
                  }
                  else
                  {
                	  $(this).html("撤销核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("已核算");
                      $(".td_lock").html("已核算");
                      parent.$("#main")[0].contentWindow.parentfun(order_id,'已核算');//父级容器不刷新，做其他动作达到刷新效果
                  }
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
	     //外交佣金 按钮
		$(".check_wj").click(function(){
			  var old=$(this).attr("data-value");
              var value=null;//传递的值
              if(old=="1")
                  value="0";
              else
            	  value="1";
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:value,action:'wj'};
              var return_data=send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                  if(old=="1")
                  {
                      $(this).html("核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("未核算");
                  }
                  else
                  {
                	  $(this).html("撤销核算");
                      $(this).attr("data-value",value);
                      $(this).parent().find("i").html("已核算");
                  }
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
	     //一键核算、一键撤销核算 按钮
		$(".btn_check").click(function(){
			  var value=$(this).attr("data-value");
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:value,action:'all'};
              var return_data=send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                  if(value=="0")
                  {
                      $(".check_btn").html("核算");
                      $(".check_btn").attr("data-value","0");
                      $(".check_btn").parent().find("i").html("未核算");

                      $(this).attr("data-value","1");
                      $(this).html("一键核算");
                      
                  }
                  else
                  {
                	  $(".check_btn").html("撤销核算");
                      $(".check_btn").attr("data-value",value);
                      $(".check_btn").parent().find("i").html("已核算");

                      $(this).attr("data-value","0");
                      $(this).html("一键撤销");
                     
                  }
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
		
	});

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
	
</script>

