<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:24px;line-height:24px;background:#fff;float:left;width:80%;margin-bottom:5px;margin-top:0px;color:#000000;
}
.p_warp font{margin-right:50px;}

.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}


.not-allow{cursor:not-allowed !important;opacity:0.5;}

/**/
fieldset{margin-bottom:10px;border:1px solid #dcdcdc;}
.p_line{height:16px;line-height:16px;border-left:3px solid #000;padding-left:5px;margin:5px 0;font-weight:bold !important;}
.header_div{float:left;width:100%;border-bottom:2px solid #000;margin-bottom:5px;padding-bottom:5px;display:none;}
.header_div .p1{width:30%;float:left;}
.header_div .p2{width:40%;float:left;text-align:center;font-size:18px;font-weight:bold !important;}
.header_div .p3{width:30%;float:left;text-align:right;}

.footer_div{float:left;width:100%;margin-bottom:5px;margin-top:20px;display:none;}
.footer_div .p1,.footer_div .p2{width:75%;float:left;text-align:right;margin:10px 0;}
</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" style="padding-bottom: 0px;">
                     <fieldset>
					    <legend>&nbsp;供应商信息&nbsp;</legend>
					     <p class="p_warp" style="margin:5px 0px 0px 20px !important;">
                    	
                    	<font>供应商名称：<?php echo isset($supplier['company_name'])==true?$supplier['company_name']:"";?></font>
                    	
                       </p>
					   <p class="p_warp" style="margin:0px 0px 10px 57px !important;">
                    	
                    	<font>户名：<?php echo isset($row['bankcompany'])==true?$row['bankcompany']:"";?></font>
                    	<font>银行账号：<?php echo isset($row['bankcard'])==true?$row['bankcard']:"";?></font>
                    	<font>银行名称+支行：<?php echo isset($row['bankname'])==true?$row['bankname']:"";?></font>
                    	
                       </p>
					</fieldset>
                   
                   <p class="p_line">基础信息</p>
                   
                    <!-- 使用明细 -->
                    <div class="content_part">
		                <!--  <div class="small_title_txt clear">
		                    <span class="txt_info fl">编号：<?php echo $k+1;?></span>
		                  
		                </div> -->
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
		                    
		                    <tr height="30"> 
		                        <td class="order_info_title">付款单号:</td>
		                        <td><?php echo $row['payable_id'];?></td>
		                        <td class="order_info_title">团号:</td>
		                        <td><a href="javascript:void(0)" class="a_team" data-id="<?php echo $row['item_code'];?>"><?php echo $row['item_code'];?></a></td>
		                    </tr>
		                     <tr height="30"> 
		                        <td class="order_info_title">申请金额:</td>
		                        <td style="color:#FF3300;"><?php echo $row['amount_apply'];?></td>
		                        <td class="order_info_title">订单成本:</td>
		                        <td><?php echo sprintf("%.2f",$row['supplier_cost']);?></td>
		                       <!--  <td class="order_info_title">申请比例:</td> -->
		                       <!--  <td><?php //echo $row['apply_percent'];?></td> -->
		                    </tr>
		                    <tr height="30">
		                        <td class="order_info_title">订单号:</td>
		                        <td><a href="javascript:void(0)" class="a_order" data-id="<?php echo $row['order_id'];?>"><?php echo $row['ordersn'];?></a></td>
		                   		<td class="order_info_title">产品名称:</td>
		                        <td><a href="javascript:void(0)" class="a_line" line-id="<?php echo $row['productautoid'];?>" line-name="<?php echo $row['productname'];?>"><?php echo $row['productname'];?></a></td>
		                    </tr>
		                    <tr height="30">
		                        <td class="order_info_title">出团日期:</td>
		                        <td><?php echo $row['usedate'];?></td>
		                        <td class="order_info_title">结算价:</td>
		                        <td><?php echo $row['jiesuan_money'];?></td>
		                    </tr>
		                    <tr height="30"> 
		                       
		                        <td class="order_info_title">已结算:</td>
		                        <td><?php echo $row['balance_money'];?></td>
		                        <td class="order_info_title">未结算:</td>
		                        <td>
		                        <?php 
		                        if($row['status']=="1"||$row['status']=="2")
		                        	echo $row['nopay_money2'];
		                        else
		                       		echo $row['nopay_money'];
		                        ?>
		                        </td>
		                    </tr>
		                   <!--   <tr height="30"> 
		                      
		                       <td class="order_info_title">结算比例:</td>
		                        <td><?php //echo $row['pay_percent'];?></td>
		                    </tr>--> 
		                    <tr height="30"> 
		                        <td class="order_info_title">操作费:</td>
		                        <td style="color:#FF3300;"><?php echo $row['all_platform_fee'];?></td>
		                        <td class="order_info_title">结算方式:</td>
		                        <td><?php echo $row['pay_way']=="0"?"现金":"转账";?></td>
		                    </tr>
		                     <tr height="30"> 
		                        <td class="order_info_title">销售:</td>
		                        <td><?php echo $row['expert_name'];?></td>
		                        <td class="order_info_title">营业部:</td>
		                        <td><?php echo $row['depart_name'];?></td>
		                    </tr>
		                    <tr height="30">
		                        <td class="order_info_title">审核状态:</td>
		                        <td colspan="3"><?php if($row['status']=="1") echo "申请中";else if($row['status']=="2") echo "待付款";else if($row['status']=="4") echo "已付款";elseif($row['status']=="3"||$row['status']=="5") echo "已拒绝";?></td>
		                    </tr>
		                     <tr height="30">
		                        <td class="order_info_title">备注:</td>
		                        <td colspan="3"><?php echo $row['remark'];?></td>
		                    </tr>
		                   
		                </table>
		            </div>
                        
                        <!-- 审核 -->
                       
                        <div class="fb-form" style="width:100%;overflow:hidden;">
	                        
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					         <?php if(!empty($pics)):?>
					         <div class="form-group" style="width:100%;float:left;margin:1px 10px !important;">
						                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">流水单</div>
						                <div class="fg-input" style="width:84%;float:left;">
						                
						                    <?php foreach ($pics as $k=>$v):?>
						                    <div style="margin-right: 20px;float:left;">
						                      <a href="javascript:void(0)" data-id="<?php echo $v['pic'];?>" class="a_pic"><img src="<?php echo base_url().$v['pic'];?>" style="height: 80px;float:left;" /></a><a href="javascript:void(0)" data-id="<?php echo $v['pic'];?>" class="a_pic" style="margin-top:50px;margin-left:2px;float:left;">大图</a>
						                    </div>
						                    <?php endforeach;?>
						                 
						                </div>
						            </div>
						    <?php endif;?>
						    <?php if($action=="2"):?>
					           <div class="form-group" style="width:100%;float:left;margin:1px 10px !important;">
					                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">流水单：</div>
					                <div class="fg-input" style="width:84%;float:left;">
					                   <input name="uploadFile" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    			       <input name="pic" id="code_pic" type="hidden" value="">
					                </div>
					            </div>
					            
					            <div class="form-group" style="width:100%;float:left;margin:1px 10px !important;">
					                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">审核意见：</div>
					                <div class="fg-input" style="width:84%;float:left;">
					                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:34px;width:90%;padding:5px;"></textarea>
					               
					                </div>
					            </div>
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <!-- <input type="button" class="fg-but btn_two btn_refuse" value="拒绝"> -->
					                 <input type="button" class="fg-but btn_one btn_approve" style="background:#da411f;" value="通过">
					                
					                </div>
					            </div>
					           <?php endif;?>
					           <!-- 退回 -->
					            <?php if($action=="3"):?>
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <?php if($row['status']=="2"||$row['status']=="4"):?>
					                  <input type="button" class="fg-but btn_one btn_back" style="background:#da411f;" value="退回">
					                 <?php endif;?>
					                </div>
					            </div>
					           <?php endif;?>
					           
					           
					        </form>
					    </div>
					    
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

    var id="<?php echo $apply_id;?>";  //apply 表
    var payable_order_id="<?php echo $payable_order_id;?>"; //apply_order表
   
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
        	
        },
        pageData:function(curr,page_size,data){  //生成表格数据

        },
        pageData2:function(curr,page_size,data){  //生成表格数据

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
	//object.init();
	
  //退回按钮
    $("body").on("click",".btn_back",function(){
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
        	
    		var list=[];
    		list.push(payable_order_id);
    		if(list.length==0)  {tan('该付款申请不存在');return false;}
           
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage_back');?>";
	        var data={apply_id:id,reply:reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	      
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	        	setTimeout(function(){t33_close_iframe_noreload();},200);
	    		//刷新页面
	    		 parent.$("#main")[0].contentWindow.parentfun2(payable_order_id);//父级容器不刷新，做其他动作达到刷新效果
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });
  //审核通过按钮
    $("body").on("click",".btn_approve",function(){
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
        	
    		var list=[];
    		list.push(payable_order_id);
    	
    		if(list.length==0)  {tan('该付款申请不存在');return false;}
            var code_pic=$("#code_pic").val();
       		
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage_deal');?>";
	        var data={apply_id:id,reply:reply,list:list,pic:code_pic};
	        var return_data=object.send_ajax_noload(url,data);
	      
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	        	//parent.$("#main")[0].contentWindow.window.location.reload();
	    		setTimeout(function(){t33_close_iframe_noreload();},200);
    		    //去掉“审核”按钮
				 parent.$("#main")[0].contentWindow.parentfun(payable_order_id);//父级容器不刷新，做其他动作达到刷新效果
    		     
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });
    $("body").on("click","#btn_submit",function(){
    	  

		object.init();
		
	});
    //审核拒绝: 提交按钮
    $("body").on("click",".btn_refuse",function(){
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
    		 var list=[];
    		 list.push(payable_order_id);
    		  
    		if(list.length==0)  {tan('该付款申请不存在');return false;}

    		   
	    	var refuse_reply=$("#reply").val();
	        if(refuse_reply=="") {tan('请填写审核意见');return false;}
	       
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage_refuse');?>";
	        var data={apply_id:id,reply:refuse_reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	      
	        if(return_data.code=="2000")
	        {
	        	
	    		tan2(return_data.data);
	    		//setTimeout(function(){t33_close_iframe();},200);
	    		
				 parent.$("#main")[0].contentWindow.parentfun(payable_order_id);//父级容器不刷新，做其他动作达到刷新效果
  		        //end
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });
    //大图
    $("body").on("click",".a_pic",function(){
    	var a_img=$(this).attr("data-id");
    	var bangu_url="<?php echo base_url() ?>";
    	
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
	//详情：团号下面的所有订单
	$("body").on("click",".a_team",function(){
		var id=$(this).attr("data-id");
	    var title=id+"团号下的所有订单";
		window.top.openWin({
		  type: 2,
		  area: ['78%', '80%'],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/team_order');?>"+"/"+id
		});
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


