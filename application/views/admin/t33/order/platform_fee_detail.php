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
</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg" style="min-width:580px;">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content"  style="padding-bottom: 0px;">
               
                <div class="tab_content" style="padding-bottom: 0px;">
                   
                    <!-- 营业部信息 -->
                    <div>
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                   
                    <tr height="40">
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo isset($bill['addtime'])==true?$bill['addtime']:""; ?></td>
                        <td class="order_info_title">订单编号:</td>
                        <td><a href="javascript:void(0)" class="a_order" data-id="<?php echo $bill['order_id']?>"><?php echo isset($bill['ordersn'])==true?$bill['ordersn']:""; ?></a></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">单价:</td>
                        <td><?php echo isset($bill['price'])==true?$bill['price']:""; ?></td>
                        <td class="order_info_title">数量:</td>
                        <td><?php echo isset($bill['num'])==true?$bill['num']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">小计:</td>
                        <td><?php echo isset($bill['amount'])==true?$bill['amount']:""; ?></td>
                        <td class="order_info_title" style="width:100px;">项目:</td>
                         <td><?php echo isset($bill['item'])==true?$bill['item']:""; ?></td>
                    </tr>
                   <tr height="40">
                        <td class="order_info_title">申请供应商:</td>
                        <td colspan="3"><?php echo isset($bill['user_name'])==true?$bill['user_name']:""; ?></td>
                       
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td colspan="3"><?php echo isset($bill['remark'])==true?$bill['remark']:""; ?></td>
                       
                    </tr>
                   
                   
                   </table>
                  </div>

                        <!-- 审核 -->
                        <?php if($action=="2"):?>
                        <div class="fb-form" style="width:100%;overflow:hidden;margin-top:10px;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					           
					           
					            <div class="form-group" style="width:100%;float:left;margin:0 0 0 0;">
					                <div class="fg-title" style="width:12%;float:left;text-align:left;">审核意见：<i>*</i></div>
					                <div class="fg-input" style="width:86%;float:left;">
					                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:160px;width:100%;padding:5px;"></textarea>
					                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
					                </div>
					            </div>
					        
					            <div class="form-group" style="margin:0 10px 0px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:8px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <input type="button" class="fg-but btn_two btn_refuse" value="拒绝">
					                 <input type="button" class="fg-but btn_one btn_approve" style="background:#da411f;" value="通过">
					                 
					                </div>
					            </div>
					           
					        </form>
					    </div>
					    <?php endif;?>
					   <!-- 审核结束 -->
                     
                    </div>                   
                </div>
               
            </div>

        </div>
        
    </div>



<script type="text/javascript">

    var id="<?php echo $id;?>";
   
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
  //审核通过按钮
    $("body").on("click",".btn_approve",function(){

    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/order/api_platform_fee_deal');?>";
	       
	        var data={id:id,reply:reply};
	        var return_data=object.send_ajax_noload(url,data);
	       
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	    		setTimeout(function(){t33_close_iframe();},200);
	        }
	        else
	        {
	            tan(data.msg);
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
	       
	        var url="<?php echo base_url('admin/t33/sys/order/api_platform_fee_refuse');?>";
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


