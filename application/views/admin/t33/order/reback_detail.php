<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:24px;line-height:24px;border-bottom: 1px solid #dddddd;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:28px;color:#000000;font-weight:bold !important;
}
.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}

.tx_p{height:30px;line-height:30px;padding:10px auto;border-bottom:1px solid #f2f2f2;}
.tx_p font,.tx_p2 font{margin-right:30px;margin-left:20px;width:110px;display:inline-block;}
.tx_p2{height:30px;line-height:30px;padding:10px auto;border:none;}


.small_title{padding-bottom:1px;border-bottom:1px solid #ddd;margin-top:4px;}
.small_title .txt_info { font-weight:normal;font-size:14px;padding-left:15px;font-family:"微软雅黑";font-weight:bold;}
.small_title .order_time { margin-left:18px;font-size:12px;color:red;}

</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg" style="min-width:580px;">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content"  style="padding-bottom: 0px;">
               
                <div class="tab_content" style="padding-bottom: 0px;">
                   
                    <!-- 营业部信息 -->
                    
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">线路名称:</td>
                        <td colspan="3"><a href="javascript:void(0)" class="a_line" line-id="<?php echo $bill['line_id']?>" line-name="<?php echo $bill['line_name']?>"><?php echo isset($bill['line_name'])==true?$bill['line_name']:""; ?></a></td>
                        <td class="order_info_title">订单序号:</td>
                        <td><a href="javascript:void(0)" class="a_order" data-id="<?php echo $bill['order_id']?>"><?php echo isset($bill['ordersn'])==true?$bill['ordersn']:""; ?></a></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">出团日期:</td>
                        <td><?php echo isset($bill['usedate'])==true?$bill['usedate']:""; ?></td>
                        <td class="order_info_title">订单人数:</td>
                        <td><?php 
                        if($bill['suitnum']>0)
                       		$number=$bill['dingnum'];
                        else 
                        	$number=$bill['dingnum']+$bill['childnum']+$bill['oldnum']+$bill['childnobednum'];
                        echo $number; 
                        ?>人</td>
                        <td class="order_info_title">退订人数:</td>
                        <td style="color:red;"><?php echo isset($bill['num'])==true?$bill['num']:""; ?>人</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">订单金额:</td>
                        <td><?php echo isset($bill['total_price'])==true?$bill['total_price']:""; ?></td>
                        <td class="order_info_title">已交款:</td>
                        <td><?php echo empty($bill['receive_price'])==true?"0.00":$bill['receive_price']; ?></td>
                        <td class="order_info_title">未交款:</td>
                        <td>
                        <?php 
                        $yishou = isset($bill['receive_price'])==true?$bill['receive_price']:"0";
                        echo $bill['total_price']-$yishou;
                        
                         ?></td>
                        
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">结算价:</td>
                        <td><?php echo isset($bill['jiesuan_price'])==true?$bill['jiesuan_price']:""; ?></td>
                        <td class="order_info_title">已结算:</td>
                        <td><?php echo empty($bill['balance_money'])==true?"0.00":$bill['balance_money']; ?></td>
                        <td class="order_info_title">未结算:</td>
                        <td>
                        <?php 
                       echo $bill['nopay_money'];
                        
                         ?></td>
                        
                    </tr>
                    
                     <tr height="40">
                        <td class="order_info_title">代收:</td>
                        <td><?php echo isset($bill['amount'])==true?$bill['amount']:""; ?></td>
                        <td class="order_info_title" style="width:100px;">授信额度:</td>
                         <td><?php echo empty($bill['apply_amount'])==true?"0.00":$bill['apply_amount']; ?></td>
                         <td class="order_info_title">操作费:</td>
                        <td><?php echo isset($bill['all_platform_fee'])==true?$bill['all_platform_fee']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">退款金额:</td>
                        <td style="color:red;"><?php echo isset($bill['refund_money'])==true?$bill['refund_money']:"0"; ?><a href="javascript:void(0)" class="a_pic" data-id="<?php echo isset($bill['core_pic'])==true?$bill['core_pic']:""; ?>" style="margin-left:20px;" >流水单</a></td>
                        <td class="order_info_title" style="width:100px;">供应商:</td>
                        <td colspan="3">
                        <a href="javascript:void(0)" class="a_supplier" data-id="<?php echo $bill['supplier_id']?>" data-name="<?php echo $bill['company_name']?>"><?php echo isset($bill['company_name'])==true?$bill['company_name']:""; ?></a>
                        </td>
                       
                    </tr>
 
                   </table>
                  </div>
                   <!-- 退款信息 -->
                    <div>
                    <div class="small_title clear">
	                    <span class="txt_info fl">退款信息</span>
	                    <span class="order_time fl">#退平台佣金请填写负数对冲#</span>
	                </div>
	                 <form method="post" action="#" id="add-data" class="form-horizontal">
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                   
                    <tr height="40">
                        <td class="order_info_title">退应收:</td>
                        <td><?php echo isset($bill['ys_money'])==true?$bill['ys_money']:""; ?></td>
                        <td class="order_info_title">退已交款:</td>
                        <td><?php echo isset($bill['sk_money'])==true?$bill['sk_money']:""; ?></td>
                        <td class="order_info_title">退供应商:</td>
                        <td><?php echo isset($bill['yf_money'])==true?$bill['yf_money']:""; ?></td>
                    </tr>
                    <tr height="40">
                       <!-- 
                        <td class="order_info_title">退平台佣金:</td>
                        <td style="color:red;">
                        <?php if($action=="1"):?>
                        <?php echo isset($bill['union_money'])==true?$bill['union_money']:""; ?>
                      	<?php else:?>
                      	<input type="text" class="platform_fee" style="height:30px;padding-left:2px;" value="-0.00<?php //echo sprintf("%.2f",$bill['num']*$bill['platform_fee']); ?>" />
                        <?php endif;?>
                        </td>
                         -->
                        <td class="order_info_title">流水单:</td>
		                <td colspan="5">
		                     <?php if(!empty($bill['code_pic'])):?>
		                     <img src="<?php echo isset($bill['code_pic'])==true?BANGU_URL.$bill['code_pic']:""; ?>" style="height: 80px;margin:5px auto;float:left;" /><a href="javascript:void(0)" class="a_pic" data-id="<?php echo isset($bill['code_pic'])==true?$bill['code_pic']:""; ?>" style="margin-left:20px;margin-top:62px;float:left;" >大图</a>
		                	 <?php else:?>
		                	   <?php if($action=="2"):?>
		                         <input name="uploadFile" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    			 <input name="pic" id="code_pic" type="hidden" value="">
                    		 <?php endif;?>
                    	     <?php endif;?>
		                </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">审核备注:</td>
                         <td colspan="5">
                        <?php if($action=="1"):?>
                       
                          <?php echo isset($bill['u_remark'])==true?$bill['u_remark']:""; ?>
                         
                      	<?php else:?>
                      
                      	 <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核备注" style="height:90px;width:60%;padding:5px;margin:5px auto;"></textarea>
   						</td>
                        <?php endif;?>
                        
                       
                    </tr>
                   
                   </table>
                   </form>
                  </div>
                   <!-- 客户信息 -->
                    <div>
                    <div class="small_title clear">
	                    <span class="txt_info fl">客人退款账号</span>
	                 
	                </div>
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                   
                    <tr height="40">
                        <td class="order_info_title">持卡人:</td>
                        <td><?php echo isset($bill['holder'])==true?$bill['holder']:""; ?></td>
                        <td class="order_info_title">开户银行:</td>
                        <td><?php echo isset($bill['bank'])==true?$bill['bank']:""; ?></td>
                        <td class="order_info_title">支行名称:</td>
                        <td><?php echo isset($bill['brand'])==true?$bill['brand']:""; ?></td>
                   </tr>
                      <tr height="40">
                        <td class="order_info_title">银行账号:</td>
                        <td colspan="5"><?php echo isset($bill['account'])==true?$bill['account']:""; ?></td>
                       
                    </tr>
                      <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td colspan="5"><?php echo isset($bill['remark'])==true?$bill['remark']:""; ?></td>
                       
                    </tr>
                   
                   
                   </table>
                  </div>

                        <!-- 审核 -->
                        <?php if($action=="2"):?>
                        <div class="fb-form" style="width:100%;overflow:hidden;margin-top:10px;">
					        <div class="form-horizontal">

					            <div class="form-group" style="margin:0 10px 0px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:8px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                <!--  <input type="button" class="fg-but btn_two btn_refuse" value="拒绝"> -->
					                 <input type="button" class="fg-but btn_one btn_approve" style="background:#da411f;" value="通过">
					                 
					                </div>
					            </div>
					           
					        </div>
					    </div>
					    <?php endif;?>
					   <!-- 审核结束 -->
                     
                    </div>                   
                </div>
               
            </div>

        </div>
        
    </div>

   <!-- 图片放大  弹层 -->
 <div class="fb-content" id="big_pic" style="display:none;/*height:350px;*/">
    <div class="box-title">
        <h5>流水单</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
       <img src="" class="a_img" style="height:400px;" />
    </div>
</div>

<script type="text/javascript">

    var id="<?php echo $id;?>";
    var supplier_refund_id="<?php echo isset($bill['supplier_refund_id'])==true?$bill['supplier_refund_id']:'';?>";
   
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
	
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {
                    var no=i+1;
        	        str += "<tr>";
        	        str +=     "<td>"+no+"</td>";
        	        str +=     "<td style='color:#FF3300;'>"+data[i].agent_fee+"</td>";
        	        str +=     "<td>"+data[i].ordersn+"</td>";
        	        str +=     "<td>"+data[i].productname+"</td>";
        	        str +=     "<td>"+data[i].usedate+"</td>";
        	        str +=     "<td>"+data[i].order_price+"</td>";
        	        str +=     "<td>"+data[i].supplier_cost+"</td>";
        	        str +=     "<td>"+data[i].diplomatic_agent+"</td>";
        	        str +=     "<td>"+data[i].settlement_price+"</td>";
        	        str +=     "<td>"+data[i].item_code+"</td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";
        	        
        	      
         	       str += "</tr>";
        	    }
        	    return str;
           
        },
        send_ajax:function(url,data){  //发送ajax请求，有加载层
        	  layer.load(2);//加载层
	          var ret;
	    	  $.ajax({
	        	 url:url,
	        	 type:"POST",
	             data:data,
	             async:false,
	             dataType:"json",
	             success:function(data){
	            	 ret=data;
	            	 setTimeout(function(){
	           		  layer.closeAll('loading');
	           		}, 200);  //0.2秒后消失
	             },
	             error:function(data){
	            	 ret=data;
	            	 //layer.closeAll('loading');
	            	 layer.msg('请求失败', {icon: 2});
	             }
	                     
	        	});
	      	    return ret;
    	  
          
        },
        send_ajax_noload:function(url,data){  //发送ajax请求，无加载层
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
      //object  end
    };

	
$(function(){

	object.init();
	//日历控件
	$('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//日历控件
	$('#endtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//搜索按钮
    $("#btn_submit").click(function(){
		   object.init();
		})
	//供应商详情
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("data-id");
		
		window.top.openWin({
		  type: 2,
		  area: ['600px', '300px'],
		  title :'供应商详情',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail');?>"+"?id="+supplier_id
		});
	});
    $("body").on("click",".a_pic",function(){
    	var a_img=$(this).attr("data-id");
    	var bangu_url="<?php echo BANGU_URL ?>";
    	
    	$(".a_img").attr("src",bangu_url+a_img);
	    layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '500px',
			  shadeClose: false,
			  content: $('#big_pic')
			});
    });
	//订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
	var order_id=$(this).attr("data-id");

	window.top.openWin({
	  title:"订单详情",
	  type: 2,
	  area: ['70%', '80%'],
	  fix: true, //不固定
	  maxmin: true,
	  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
	});
});
  //线路详情    on：用于绑定未创建内容
	$("body").on("click",".a_line",function(){
		var line_id=$(this).attr("line-id");
		var line_name=$(this).attr("line-name");
		window.top.openWin({
		  title:line_name,
		  type: 2,
		  area: ['1000px', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/line/detail');?>"+"?id="+line_id
		});
	});
  //审核通过按钮
    $("body").on("click",".btn_approve",function(){
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var union_money=$(".platform_fee").val();
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/order/api_reback_deal');?>";
	        var code_pic=$("#code_pic").val();
	       
	        var data={id:id,union_money:union_money,supplier_refund_id:supplier_refund_id,reply:reply,code_pic:code_pic};
	        var return_data=object.send_ajax_noload(url,data);
	       
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	    		setTimeout(function(){t33_close_iframe();},200);
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });

    //审核拒绝: 提交按钮
    $("body").on("click",".btn_refuse",function(){

    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var refuse_reply=$("#reply").val();
	        if(refuse_reply=="") {tan('请填写审核意见');return false;}
	       
	        var url="<?php echo base_url('admin/t33/sys/order/api_reback_refuse');?>";
	        var data={id:id,reply:refuse_reply};
	        var return_data=object.send_ajax_noload(url,data);
	       
	        if(return_data.code=="2000")
	        {
	        	
	    		tan2(return_data.data);
	    		setTimeout(function(){t33_close_iframe();},200);
	    		
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });

    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $('.btn_close').click(function()
    {
         parent.layer.close(index);
    });

});



</script>
</html>


