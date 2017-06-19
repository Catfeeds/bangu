<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>

<script type="text/javascript" src="<?php echo base_url("assets/ht/js/layer.js"); ?>"></script>

<script type="text/javascript" src="<?php echo base_url("assets/ht/js/common/common.js"); ?>"></script>

<style type="text/css">

.btn_one{

    background: #da411f;
    width: 60px;
    height: 30px;
    margin-left: 20px;
    padding: 0px;
    border-radius: 3px;
    color: #fff;
    border: none;
    text-align: center;
    cursor: pointer;
  
}

.btn_two{
	float: right;
    width: auto;
    border: 0;
    margin-left: 10px;
    padding: 8px 14px !important;
    border-radius: 3px;
    background: #2DC3E8;
    color: #fff;
    cursor: pointer;
    position: relative !important; 
}

.no_data{width:100%;float:left;height:50px;margin-top:24%;color:red;text-align:center;font-size:14px;}

.fb-content .box-title, .form-box .box-title{

	padding: 10px 15px 10px 20px;
    background-color: #F5F5F5;
    border-bottom: 1px solid #E5E5E5;
    position: relative;
 }
 
.fb-content .box-title span, .form-box .box-title span{
       position: absolute;
    right: 20px;
    top: 5px;
    cursor: pointer;
    font-size: 18px;
    font-weight: 600;
    color: #aaa;
    word-break: break-all;
    line-height: initial;
   
}
.layui-layer-setwin .layui-layer-close1{
	background-position: 0 -40px;
    cursor: pointer;
    width: 25px;
    height: 25px;
    background: none;
    color: #000;
    font-size: 24px;
    text-align: center;
    line-height: 25px;
}

</style>

</head>
<body>

    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="order_detail">
         <!-- 循环开始 -->
            <!-- ===============基础信息============ -->
            
            <?php if(!empty($list)):?>
              <?php foreach ($list as $k=>$v):?>
		            <div class="content_part">
		                <!--  <div class="small_title_txt clear">
		                    <span class="txt_info fl">编号：<?php echo $k+1;?></span>
		                  
		                </div> -->
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
		                   
		                    <tr height="30">
		                       <td class="order_info_title">认款日期:</td>
		                        <td><?php echo $v['addtime'];?></td>
		                        <td class="order_info_title">认款金额:</td>
		                        <td style="color: #FF6537;font-size: 14px;font-weight: bold;"><?php echo sprintf("%.2f",$v['money']);?></td>
		                    </tr>
		                    <tr height="30"> 
		                        <td class="order_info_title">认款人:</td>
		                        <td><?php echo $v['expert_name'];?></td>
		                        <td class="order_info_title">营业部:</td>
		                        <td><?php echo $v['depart_name'];?></td>
		                       
		                   
		                    </tr>
		                   
		                    <tr height="30"> 
		                        <td class="order_info_title">收款方式:</td>
		                        <td><?php echo $v['way'];?></td>
		                        <td class="order_info_title">凭证号:</td>
		                        <td colspan="3"><?php echo $v['code'];?></td>
		                       
		                   
		                    </tr>
		                  
		                     <tr height="30"> 
		                        <td class="order_info_title">银行名称:</td>
		                        <td><?php echo $v['bankname'];?></td>
		                        <td class="order_info_title">银行卡号:</td>
		                        <td><?php echo $v['bankcard'];?></td>
		                       
		                   
		                    </tr>
		                    <tr height="30">
		                        <td class="order_info_title">流水单号:</td>
		                        <td></td>
		                        <td class="order_info_title">备注:</td>
		                        <td><?php echo $v['remark'];?></td>
		                       
		                    </tr>
		                     <tr height="30">
		                         <td class="order_info_title">流水单:</td>
		                        <td colspan="3">
		                        <?php $code_pic=isset($v['code_pic'])==true?$v['code_pic']:'';?>
		                        <img id="target" title="点击查看大图" class="a_pic" data-id="<?php echo isset($v['code_pic'])==true?$v['code_pic']:""; ?>" src="<?php echo BANGU_URL.$code_pic;?>" style="height:300px;margin:5px auto;float:left;max-width:650px;cursor:pointer;" >
		                        <!--  
		                        <img id="img_big" src="<?php echo base_url('assets/ht/img/icon_big.png');?>" style="height:24px;margin:270px 0 0 10px;float:left;cursor:pointer;" >
		                        <img id="img_small" src="<?php echo base_url('assets/ht/img/icon_small.png');?>" style="height:24px;margin:270px 0 0 10px;float:left;cursor:pointer;" >
		                         <img id="img_l" src="<?php echo base_url('assets/ht/img/icon_l.png');?>" style="height:24px;margin:270px 0 0 10px;float:left;cursor:pointer;" >
		                        -->
		                       <a href="javascript:void(0)" id="target" title="点击查看大图" class="a_pic" data-id="<?php echo isset($v['code_pic'])==true?$v['code_pic']:""; ?>" style="margin-left:20px;margin-top:270px;float:left;" >大图</a>
		                       
		                       
		                         
		                        </td>
		                        
		                    </tr>
		                   
		                </table>
		            </div>
            <?php endforeach;?>
            <?php else:?>
              <div class="no_data">暂无数据</div>
            <?php endif;?>
    <!-- 循环结束 -->
  <?php if($action=="2"):?>
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div style="width:100%;float:left;margin: 0px;padding: 0px">
                <div class="fg-title" style="width:11% !important;float:left;text-align:center;height: 24px;vertical-align: middle;">流水单号：<i style="color:red;">*</i></div>
                <div class="fg-input" style="width:86%;float:left;">
                <input type="text" name="voucher" id="voucher" maxlength="30" placeholder="请填写流水单号" style="height:24px;width:100%;padding:5px;"></textarea>
                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
                </div>
            </div>
        
            <div class="form-group" style="margin:0 0 10px 0;text-align:right;float:left;width:98%;">
               <div style="width:100%;float:left;margin-top:20px;">
                 <input type="button" class="fg-but btn_one btn_approve" value="通过">
                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
                 <input type="button" class="fg-but btn_two btn_refuse" value="拒绝">
                
                 
                </div>
            </div>
           
        </form>
    </div>
    <?php endif;?>
    <!-- 表单结束 -->
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
var apply_id="<?php echo $apply_id;?>";
//审核通过按钮
$("body").on("click",".btn_approve",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var voucher=$("#voucher").val();
	    var url="<?php echo base_url('admin/t33/sys/approve2/api_hand_bank_deal');?>";
	    var data={item_id:apply_id,voucher:voucher};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
	    	tan2(return_data.data);
			setTimeout(function(){t33_close_iframe_noreload();},200);
	
			//刷新页面
			parent.$("#main")[0].contentWindow.parentfun(apply_id);//父级容器不刷新，做其他动作达到刷新效果
	    }
	    else
	    {
	        tan(return_data.msg);
	    }
	}
	
});
$("body").on("click",".a_pic",function(){
	var a_img=$(this).attr("data-id");
	var bangu_url="<?php echo BANGU_URL ?>";
	
	$(".a_img").attr("src",bangu_url+a_img);
	
	window.top.openWin({
		  title:"流水单图片",
		  type: 2,
		  area: ['840px', '560px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/pic_detail?url=');?>"+a_img
		});
});
//订单详情    on：用于绑定未创建内容
$("body").on("click",".a_order",function(){
	var order_id=$(this).attr("order-id");
	window.top.openWin({
	  title:"订单详情",
	  type: 2,
	  area: ['70%', '80%'],
	  fix: true, //不固定
	  maxmin: true,
	  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
	});
});

//审核拒绝: 提交按钮
$("body").on("click",".btn_refuse",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var refuse_reply=$("#reply").val();
	    if(refuse_reply=="") {tan('请填写审核意见');return false;}
	   
	    var url="<?php echo base_url('admin/t33/sys/approve2/api_hand_bank_refuse');?>";
	    var data={item_id:apply_id,reply:refuse_reply};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
	    	
			tan2(return_data.data);
			setTimeout(function(){t33_close_iframe_noreload();},200);
			
			//刷新页面
			parent.$("#main")[0].contentWindow.parentfun(apply_id);//父级容器不刷新，做其他动作达到刷新效果

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




</script>
</body>

</html>
