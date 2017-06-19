<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款申请单</title>
<!--startprint1-->
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:20px;line-height:20px;background:#fff;float:left;width:80%;margin-top:0px;color:#000000;
}
.p_warp font{margin-right:50px;}

.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}


.not-allow{cursor:not-allowed !important;opacity:0.5;}

.p_line{height:16px;line-height:16px;border-left:3px solid #000;padding-left:5px;margin:5px 0;font-weight:bold !important;}


</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" id="printf_div" style="padding: 15px 0 0 0 !important;">
                  
                
                   
                   <p class="p_line">审核列表</p>
                    <!-- 使用明细 -->
                    <div class="table_list">
                       
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                   <?php if($action=="2"): //审核的时候显示checkbox ?>
                                   <th></th>
                                   <?php endif;?>
                                   <th>编号</th>
                                   <th>交款金额</th>
                                   <th>销售姓名</th>
                                   <th>营业部门</th>
                                   <th>备注</th>
                                   <th>订单号</th>
                                   <th>团号</th>
                                   <th>收款方式</th>
                                   <th>供应商</th>
                                   <th>供应商负责人</th>
                                   <th>流水单</th>
                                   <th>申请时间</th>
                                   <th>状态</th>

                                </tr>
                            </thead>
                            <tbody class="data_rows">
                               <?php $total_tongguo_money=0;if(!empty($list)):?>
                                 <?php foreach ($list as $k=>$v):?>
                                  <tr>
                                  
                                  
                                  <?php if($action=="2"): //审核的时候显示checkbox ?>
                                   <td>
                                   <?php 
                                   $class_str="";
                                   $disabled_str="";
                                   if($v['status']!="1")
                                   {
                                   	    $class_str="not-allow";
                                    	$disabled_str="disabled";
                                   }
                                   ?>
                                   <input type="checkbox" class="input_check <?php echo $class_str;?>" <?php echo $disabled_str;?> data-id="<?php echo $v['id'];?>" data-value="<?php echo $v['money'];?>" />
                                   </td>
                                <?php endif;?>
                                  
                                   <td><a href='javascript:void(0)' class='a_detail' data-id='<?php echo $v['id'];?>'><?php echo $v['id'];?></a></td>
                                   <td style="color:#FF6537;"><?php echo sprintf("%.2f",$v['money']);?></td>
                                   <td><?php echo $v['expert_name'];?></td>
                                   <td><?php echo $v['depart_name'];?></td>
                                   <td><?php echo $v['remark'];?></td>
                                   <td><a href='javascript:void(0)' class='a_order' data-id='<?php echo $v['order_id'];?>'><?php echo $v['order_sn'];?></a></td>
                                   <td><a href='javascript:void(0)' class='a_teamcode' data-id='<?php echo $v['item_code'];?>'><?php echo $v['item_code'];?></a></td>
                                   <td><?php echo $v['way'];?></td>
                                   <td><a href='javascript:void(0)' class='a_supplier' data-id='<?php echo $v['supplier_id'];?>'><?php echo $v['company_name'];?></a></td>
 								   <td><?php echo $v['supplier_fuze'];?></td>
                                   <td>
                                    <?php if(!empty($v['code_pic'])):?>
		                       	
		                       			 <a href="javascript:void(0)" class="a_pic" data-id="<?php echo isset($v['code_pic'])==true?$v['code_pic']:""; ?>">流水单图片</a>
		                            </td>
                                   <?php endif;?>
                                   </td>
                                   <td><?php echo $v['addtime'];?></td>
                                   <td><?php if($v['status']=="1") echo "待审核";else if($v['status']=="2") echo "已通过";else if($v['status']=="3") echo "已拒绝";?></td>
                                  </tr>
                                 <?php if($v['status']=="2") $total_tongguo_money+=$v['money'];endforeach;?>
                              <?php endif;?>
      
                               <tr>
                                <?php if($action=="2"):?>
                               <td width="76px">
                                <a href='javascript:void(0)' class="checkall" style='float:left;margin:0;'>全选</a>
                                <a href='javascript:void(0)' class="notcheckall" style='float:left;margin:0;'>反选</a>
                               </td>
                               <?php endif;?>
                               <td>总计</td>
                                <?php if($action=="2"):?>
                               <td style="color:#FF6537;" class="total_money">0.00</td>
                               <?php else:?>
                               <td style="color:#FF6537;" class="total_money2"><?php echo $total_tongguo_money;?></td>
                               <?php endif;?>
                               <td colspan="11"></td></tr>
      
                            </tbody>
                        </table>

                    </div>  
                                  
                </div>

                <!--endprint1-->  
                <!-- 审核 -->
                       <?php if($action=="2"):?>
                        <div class="fb-form" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					           
					           
					            <div class="form-group" style="width:100%;float:left;margin:0 0 0 0;">
					                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">审核意见：</div>
					                <div class="fg-input" style="width:84%;float:left;">
					                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:34px;width:90%;padding:5px;"></textarea>
					                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
					                </div>
					            </div>
					        
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <!-- <input type="button" class="fg-but btn_two btn_refuse" value="拒绝"> -->
                                                                    
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

   var list_id="<?php echo $list_id;?>";
   
	//js对象
	var object = object || {};
	var ajax_data={};
	
	object = {
        init:function(){ //初始化方法
            
        	
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

  //审核通过按钮
    $("body").on("click",".btn_approve",function(){
      
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
    		 var list="";
    	     $(".input_check").each(function(index,data){
    	     if($(this).is(':checked'))
    		 {
    			 var value=$(this).attr("data-id");
    			 list=value+","+list;
    		   }	  
    		 })
    		if(list.length==0)  {tan('请勾选要申请的交款');return false;}
     		
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve2/hand_submit_deal');?>";
	        var data={reply:reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	        	//setTimeout(function(){t33_close_iframe();},500);
	        	 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("已通过");
    				 }
    	    	  
    		      })
	        	
    		      parent.$("#main")[0].contentWindow.parentfun(list_id);//父级容器不刷新，做其他动作达到刷新效果
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
    		 var list="";
    	     $(".input_check").each(function(index,data){
    	     if($(this).is(':checked'))
    		 {
    			 var value=$(this).attr("data-id");
    			 list=value+","+list;
    		   }	  
    		 })
    		if(list.length==0)  {tan('请勾选要申请的交款');return false;}
     		
    		var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve2/hand_submit_refuse');?>";
	        var data={reply:reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	        	//setTimeout(function(){t33_close_iframe();},500);
	        	 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("已拒绝");
    				 }
    	    	  
    		      })
    		      parent.$("#main")[0].contentWindow.parentfun(list_id);//父级容器不刷新，做其他动作达到刷新效果
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
  
    	
    });
    //订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("data-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['80%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
		});
	});
	//供应商详情    on：用于绑定未创建内容
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("data-id");
		var supplier_name=$(this).html();
		
		window.top.openWin({
		  title:supplier_name,
		  type: 2,
		  area: ['46%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail');?>"+"?id="+supplier_id
		});
	});
	//全选
	$("body").on("click",".checkall",function(){
	
	       $(".input_check").each(function(index,data){
		       if($(this).hasClass("not-allow")==false)
		       {
	    	    $(this).attr("checked",true);
		       }
	    	  
		      })
		   cal();
	});
	//反选
	$("body").on("click",".notcheckall",function(){
	
	       $(".input_check").each(function(index,data){
	    	   if($(this).hasClass("not-allow")==false)
	    	   {
		    	   if($(this).is(':checked'))
				   {
		    	       $(this).attr("checked",false);
				   }
		    	   else
		    	   {
		    		   $(this).attr("checked",true);
		    	   }
	    	   }
	    	  
		      })
		  cal();
	});
	//点击团号
	$("body").on("click",".a_teamcode",function(){
		var team_code=$(this).attr("data-id");
		//添加按钮
		 window.top.openWin({
			  type: 2,
			  area: ['1024px', '540px'],
			  title :'列表',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/t33/sys/approve2/hand_team_list');?>"+"?team_code="+team_code
			});
		
	});
	//查看、审核按钮
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		var action=$(this).attr("action");
		if(action=="1")
		{
			var title="详情";
			var height="450px";
		}
		else
		{
			var title="审核";
			var height="450px";
		}
		window.top.openWin({
		  type: 2,
		  area: ['820px', height],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/hand_detail');?>"+"?id="+id+"&action="+action
		});
	});
	$(".input_check").click(function(){
		cal();
	})
	//图片放大
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
    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $("body").on("click",".btn_close",function()
    {
         parent.layer.close(index);
    });

});



function cal()
{
	 var money=0;
     $(".input_check").each(function(index,data){
     if($(this).is(':checked'))
	 {
		 var value=$(this).attr("data-value");
		 money+=parseInt(value);
	   }	  
      })
     
      $(".total_money").html(money.toFixed(2));
}




</script>

</html>


