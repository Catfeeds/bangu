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

.p_day{
   height:24px;line-height:24px;
}


</style>

</head>
<body>

    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="">
         <!-- 循环开始 -->
            <!-- ===============基础信息============ -->
            
           
		            <div class="content_part">
		                <!--  <div class="small_title_txt clear">
		                    <span class="txt_info fl">编号：<?php echo $k+1;?></span>
		                  
		                </div> -->
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
		                    <tr height="40">
		                        <td class="order_info_title">线路名称:</td>
		                        <td colspan="3"><a href="javascript:void(0)" class="a_detail" line-id="<?php echo $line['id'];?>" line-name="<?php echo $line['linename'];?>"><?php echo $line['linename'];?></a></td>
		                   		
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">行程天数:</td>
		                        <td colspan="3"><?php echo $line['lineday']."天".$line['linenight'].'晚';?></td>
		                       
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">类型:</td>
		                        <td colspan="3"><?php echo $agent_type=="1"?'散拼':'包团';?></td>
		                       
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">佣金:</td>
		                        <td colspan="3">
		                       <?php 
		                       if(!empty($agent))
		                       {
					                if($agent['type']=="1")
					                	 echo "成人：".$agent['man']."&nbsp;老人：".$agent['oldman']."&nbsp;儿童占床：".$agent['child']."&nbsp;儿童不占床：".$agent['childnobed'];
					                else if($agent['type']=="2")
					                	 echo (round($agent['agent_rate'],2)*100)."%";
					                else if($agent['type']=="3")
					                {
					                	if(!empty($days))
					                	{
					                		foreach ($days as $k=>$v)
					                		{
					                			echo "<p class='p_day'>{$v['day']}天 - {$v['money']}/人</p>";
					                		}
					                	}
					                }
		                       }
				                ?>
		                        </td>
		                   <tr height="40">
		                       <td class="order_info_title">审核意见:</td>
		                        <td colspan="3">
		                        <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:34px;width:90%;padding:8px;margin:5px auto;"></textarea>
		                        </td>
		                       
		                    </tr>
		                    </tr>
		                   
		                   
		                   
		                </table>
		            </div>
           
    <!-- 循环结束 -->
  
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:94%;">
               <div style="width:100%;float:left;margin-top:20px;">
                 <input type="button" class="fg-but btn_one btn_approve" value="通过">
                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
                 <input type="button" class="fg-but btn_two btn_refuse" value="拒绝">
                
                 
                </div>
            </div>
           
        </form>
    </div>
  
    <!-- 表单结束 -->
        </div>
	</div>
	



	
<script type="text/javascript">

var lineid="<?php echo $lineid;?>";
				                
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
var id="<?php echo $id;?>";
//审核通过按钮
$("body").on("click",".btn_approve",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var reply=$("#reply").val();
	    var url="<?php echo base_url('admin/t33/sys/line/api_setting_deal');?>";
	    var data={id:id,reply:reply};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
	    	tan2(return_data.data);
			setTimeout(function(){t33_close_iframe_noreload();},200);
			//刷新页面
			parent.$("#main")[0].contentWindow.parentfun(lineid,'已通过');//父级容器不刷新，做其他动作达到刷新效果
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
    layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '500px',
		  shadeClose: false,
		  content: $('#big_pic')
		});
});

//线路详情    on：用于绑定未创建内容
	$("body").on("click",".a_detail",function(){
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

//审核拒绝: 提交按钮
$("body").on("click",".btn_refuse",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var reply=$("#reply").val();
		if(reply=="") {tan('审核意见不能为空');return false;}
	    var url="<?php echo base_url('admin/t33/sys/line/api_setting_refuse');?>";
	    var data={id:id,reply:reply};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
	    	
			tan2(return_data.data);
			setTimeout(function(){t33_close_iframe_noreload();},200);
	
			//刷新页面
			parent.$("#main")[0].contentWindow.parentfun(lineid,'已拒绝');//父级容器不刷新，做其他动作达到刷新效果

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
