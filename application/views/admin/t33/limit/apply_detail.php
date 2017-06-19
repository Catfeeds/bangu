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
		               
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
		                   
		                    <tr height="40">
		                       <td class="order_info_title" style="width:14%;">相关订单编号:</td>
		                        <td><a href="javascript:void(0)" class="a_order" data-id="<?php echo $v['order_id']?>"><?php echo $v['ordersn'];?></a></td>
		                        <td class="order_info_title" style="width:14%;">申请人:</td>
		                        <td><?php echo $v['expert_name'];?></td>
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">申请的信用额度:</td>
		                        <td><?php echo $v['credit_limit'];?></td>
		                        <td class="order_info_title">营业部门:</td>
		                        <td><?php echo $v['departname'];?></td>
		                    </tr>
		                    <tr height="40"> 
		                        <td class="order_info_title">经理姓名:</td>
		                        <td><?php echo $v['manager_name'];?></td>
		                        <td class="order_info_title">申请对象:</td>
		                        <td>
		                        <?php 
		                        if($v['supplier_id']=="0")
		                        	echo "旅行社—".$v['union_name'];
		                        else 
		                        	echo "供应商—".$v['company_name'];
		                        ?></td>
		                       
		                   
		                    </tr>
		                   
		                   <tr height="40"> 
		                        <td class="order_info_title">申请时间:</td>
		                        <td><?php echo $v['addtime'];?></td>
		                        <td class="order_info_title">还款时间:</td>
		                        <td><?php echo $v['return_time'];?></td>
		                    <tr height="40">
		                       
		                        <td class="order_info_title">申请备注:</td>
		                        <td colspan="3"><?php echo $v['remark'];?></td>
		                    </tr>
		                   
		                    </tr>
		                     <tr height="40"> 
		                        <td class="order_info_title">经理审批时间:</td>
		                        <td><?php echo $v['m_addtime'];?></td>
		                        <td class="order_info_title">经理审批备注:</td>
		                        <td><?php echo $v['m_remark'];?></td>
		                    </tr>
		                      <tr height="40"> 
		                        <td class="order_info_title">旅行社审批人:</td>
		                        <td><?php echo $v['employee_name'];?></td>
		                        <td class="order_info_title">旅行社审批备注:</td>
		                        <td><?php echo $v['reply'];?></td>
		                    </tr>
		                    <tr height="40">
		                        
		                        <td class="order_info_title">状态:</td>
		                        <td colspan="3">
		                        <?php 
		                        if($v['status']=="1")
		                         	echo "申请中";
		                        elseif($v['status']=="3")
		                        	echo "已通过";
		                        elseif($v['status']=="4")
		                       		 echo "已还款";
		                        elseif($v['status']=="5")
		                        	echo "已拒绝";
		                        elseif($v['status']=="-1")
		                       		 echo "已撤销";
		                        elseif($v['status']=="0")
		                       		 echo "申请中";
		                        ?>
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
           
           
            <div class="form-group" style="width:100%;float:left;">
                <div class="fg-title" style="width:11% !important;float:left;text-align:center;">审核意见：<i style="color:red;">*</i></div>
                <div class="fg-input" style="width:80%;float:left;">
                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:160px;width:100%;padding:5px;"></textarea>
                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
                </div>
            </div>
        
            <div class="form-group" style="margin:0 0 0px 0;text-align:right;float:left;width:98%;">
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
		var reply=$("#reply").val();
	    var url="<?php echo base_url('admin/t33/sys/limit/api_apply_deal');?>";
	    var data={apply_id:apply_id,reply:reply};
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


//审核拒绝: 提交按钮
$("body").on("click",".btn_refuse",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var refuse_reply=$("#reply").val();
	    if(refuse_reply=="") {tan('请填写审核意见');return false;}
	   
	    var url="<?php echo base_url('admin/t33/sys/limit/api_apply_refuse');?>";
	    var data={apply_id:apply_id,reply:refuse_reply};
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


//关闭按钮
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$('.btn_close').click(function()
{
     parent.layer.close(index);
});

</script>
</body>

</html>
