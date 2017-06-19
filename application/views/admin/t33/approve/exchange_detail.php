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
.tx_p font,.tx_p2 font{margin-right:30px;margin-left:20px;display:inline-block;}
.tx_p2{height:30px;line-height:30px;padding:10px auto;border:none;}
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
                    <div>
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                   
                    <tr height="40">
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo isset($exchange['addtime'])==true?$exchange['addtime']:""; ?></td>
                        <td class="order_info_title">申请人:</td>
                        <td><?php echo isset($exchange['expert_name'])==true?$exchange['expert_name']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行名称:</td>
                        <td><?php echo isset($exchange['bankname'])==true?$exchange['bankname']:""; ?></td>
                        <td class="order_info_title">银行卡号:</td>
                        <td><?php echo isset($exchange['bankcard'])==true?$exchange['bankcard']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">持卡人:</td>
                        <td><?php echo isset($exchange['cardholder'])==true?$exchange['cardholder']:""; ?></td>
                        <td class="order_info_title" style="width:100px;">申请提现金额:</td>
                         <td><?php echo isset($exchange['amount'])==true?$exchange['amount']:""; ?></td>
                    </tr>
                   
                    <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td colspan="3"><?php echo isset($exchange['beizhu'])==true?$exchange['beizhu']:""; ?></td>
                       
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">明细:</td>
                        <td colspan="3">
                        <?php if(!empty($exchange_depart)): ?>
                          <?php foreach ($exchange_depart as $k=>$v):?>
                               <p class="<?php if(($k+1)==count($exchange_depart)) echo 'tx_p2';else echo 'tx_p';?>"><font>部门：<?php echo $v['depart_name'];?> </font> <font>提现金额： <?php echo $v['amount'];?>元</font></p>
                          <?php endforeach;?>
                         <?php endif;?>
                        
                        
                        
                        </td>
                       
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
	
  //审核通过按钮
    $("body").on("click",".btn_approve",function(){
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve/api_exchange_deal');?>";
	
	        var data={id:id,reply:reply,status:'1'};
	        var return_data=object.send_ajax_noload(url,data);
	       
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	    		setTimeout(function(){t33_close_iframe();},200);
	
	    		//刷新页面
	    		parent.$("#main")[0].contentWindow.getValue();
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
	       
	        var url="<?php echo base_url('admin/t33/sys/approve/api_exchange_deal');?>";
	        var data={id:id,reply:refuse_reply,status:'2'};
	        var return_data=object.send_ajax_noload(url,data);
	      
	        if(return_data.code=="2000")
	        {
	        	
	    		tan2(return_data.data);
	    		setTimeout(function(){t33_close_iframe();},200);
	    		//刷新页面
	    		parent.$("#main")[0].contentWindow.getValue();
	    		
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


