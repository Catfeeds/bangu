<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:24px;line-height:24px;background:#fff;float:left;width:92%;margin-bottom:5px;margin-top:0px;color:#000000;
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
		                        <td><?php echo $row['item_code'];?></td>
		                    </tr>
		                     <tr height="30"> 
		                        <td class="order_info_title">申请金额:</td>
		                        <td style="color:#FF3300;"><?php echo $row['amount_apply'];?></td>
		                        <td class="order_info_title">订单号:</td>
		                        <td><?php echo $row['ordersn'];?></td>
		                    </tr>
		                    <tr height="30">
		                        <td class="order_info_title">出团日期:</td>
		                        <td><?php echo $row['usedate'];?></td>
		                   		<td class="order_info_title">产品名称:</td>
		                        <td><?php echo $row['productname'];?></td>
		                    </tr>

		                    <tr height="30"> 
		                        <td class="order_info_title">结算价:</td>
		                        <td><?php echo $row['supplier_cost'];?></td>
		                        <td class="order_info_title">已结算:</td>
		                        <td><?php echo $row['balance_money'];?></td>
		                    </tr>
		                    <tr height="30"> 
		                        <td class="order_info_title">结算申请中:</td>
		                        <td><?php echo $a_balance;?></td>
                                <td class="order_info_title">平台佣金:</td>
		                        <td style="color:#FF3300;"><?php echo $row['platform_fee'];?></td>
		                 
		                    </tr>

		                     <tr height="30"> 
		                        <td class="order_info_title">未结算:</td>
		                        <td><?php echo $row['supplier_cost']-$row['balance_money']-$row['platform_fee']-$a_balance;?></td>
		                        <td class="order_info_title">销售:</td>
		                        <td><?php echo $row['expert_name'];?></td>
		                        
		                    </tr>
		                    <tr height="30">
		                   		<td class="order_info_title">营业部:</td>
		                        <td><?php echo $row['depart_name'];?></td>
		                        <td class="order_info_title">审核状态:</td>
		                        <td ><?php if($row['status']=="1") echo "申请中";else if($row['status']=="2") echo "待付款";else if($row['status']=="4") echo "已付款";elseif($row['status']=="3"||$row['status']=="5") echo "已拒绝";?></td>
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
	
					           <!-- 退回 -->
					           
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                  <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                  <?php if($row['status']==0 ||$row['status']==1){ ?>
					                  <input type="button" value="取消" class="fg-but btn_one btn_back" style="background:#da411f;" onclick="update_account(this,<?php echo $row['id'];?>,<?php echo $row['order_id'];?>)" />  
					                   <?php }?>
					                </div>
					            </div>

					           
					           
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
       <img src="" class="a_img" style="min-height:400px;" />
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

	


//取消某个订单的结算
function update_account(obj,id,order_id){
      var re= $(obj).attr('checked');
      if(re!='checked'){
              if (!confirm("确定要去掉该申请单？")) {
                    window.event.returnValue = false;
              }else{
                     $.post("<?php echo base_url()?>admin/b1/apply/apply_order_log/cancel_apply_order", { id:id,order_id:order_id} , function(result) {
                              result = eval('('+result+')');
                              if(result.status==1){
                                   alert(result.msg);
                                   parent.location.reload();	                              
                                  // var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                                  // parent.layer.close(index);
                                   //刷新父类 
                              }else{
                            	  alert(result.msg);
                              }
                     });
            }
          
      }
}


//关闭按钮
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$('.btn_close').click(function()
{
     parent.layer.close(index);
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
		  area: '600px',
		  shadeClose: false,
		  content: $('#big_pic')
	});
});


</script>
</html>


