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
.label{margin:10px;}

.part1{
 margin:5px auto;
 
}
.part1 p{height:30px;line-height:30px;width:100%;float:left;margin:5px auto;}
.part1 p font{width:25%;display:block;float:left;text-align:right;}
.part1 p input{width:20%;float:left;height:24px;padding:2px 0 2px 5px;}

.part2{
 margin:5px auto;
 
}
.part2 p{height:30px;line-height:30px;width:100%;float:left;margin:5px auto;}

.part2 p input{width:20%;height:24px;padding:2px 0 2px 5px;margin-left:10px;}

.content_part table{border:none !important;margin-top:20px !important;}

.table_td_border>tbody>tr>td{border:none !important;background:#fff !important;}
</style>

</head>
<body>

    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="">
         <!-- 循环开始 -->
            <!-- ===============基础信息============ -->
            <div class="table_content">
                <div class="itab" data-id="<?php echo $agent_type;?>">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">散拼</a></li> 
                        <li static="2"><a href="#tab1">包团</a></li> 
                    </ul>
                </div>
		        <div class="content_part">
		                <!--  <div class="small_title_txt clear">
		                    <span class="txt_info fl">编号：<?php echo $k+1;?></span>
		                  
		                </div> -->
		                 <table class="order_info_table table_td_border tb1" border="0" width="100%" cellspacing="0" style="border: none;">
		                    <tr height="40">
		                        <td class="order_info_title" style="width:100px !important;">佣金计算模式:</td>
		                        <td colspan="3">
		                         <label class="label"><input type="radio" name="type" value="1" class="btn_radio" <?php if((isset($agent['type'])==true&&$agent['type']=="1")||isset($agent['type'])==false) echo "checked";?> />人群</label>
		                         <label class="label"><input type="radio" name="type" value="2" class="btn_radio" <?php if(isset($agent['type'])==true&&$agent['type']=="2") echo "checked";?> />比例</label>
		                         <label class="label"><input type="radio" name="type" value="3" class="btn_radio" <?php if(isset($agent['type'])==true&&$agent['type']=="3") echo "checked";?> />天数</label>
		                        </td>
		                   		
		                    </tr>
		                    <tr height="40" style='border-top:1px solid #e0e0e0; '>
		                       <td class="order_info_title">设置:</td>
		                        <td colspan="3">
		                           <div class="part1 div_set" id="div1">
		                             <p><font>成人：</font><input type="text" class="man" value="<?php echo isset($agent['man'])==true?$agent['man']:'';?>" />元/人</p>
		                             <p><font>老人：</font><input type="text" class="oldman" value="<?php echo isset($agent['man'])==true?$agent['oldman']:'';?>" />元/人</p>
		                             <p><font>儿童占床：</font><input type="text" class="child" value="<?php echo isset($agent['man'])==true?$agent['child']:'';?>" />元/人</p>
		                             <p><font>儿童不占床：</font><input type="text" class="childnobed" value="<?php echo isset($agent['man'])==true?$agent['childnobed']:'';?>" />元/人</p>
		                           </div>
		                           <div class="part1 div_set" id="div2" style="display:none;"> 
		                             <p><font>比例（如0.1）：</font><input type="text" class="agent_rate" value="<?php echo isset($agent['agent_rate'])==true?$agent['agent_rate']:'';?>" /></p>
		                            
		                           </div>
		                           <div class="part2 div_set" id="div3" style="display:none;">
		                             <div class="div_p">
		                             <?php if(empty($days)):?>
		                             <p><input type="text" class="day" />天<input type="text" class="money" />元/人</p>
		                              <?php else:?>
		                                <?php foreach ($days as $k=>$v):?>
		                               	<p data-id="<?php echo $v['id'];?>"><input type="text" class="day" value="<?php echo isset($v['day'])==true?$v['day']:'';?>" />天<input type="text" class="money" value="<?php echo isset($v['money'])==true?$v['money']:'';?>" />元/人<a href="javascript:void(0)" class="a_delete" data-id="<?php echo $v['id'];?>" style="margin-left:10px;">删除</a></p>
		                                <?php endforeach;?>
		                              <?php endif;?>
		                              
		                             </div>
		                            <a href="javascript:void(0)" class="a_add" style="margin-left:10px;">新增行数</a>
		                           </div>
		                        </td>
		                       
		                    </tr>
		                </table>
		                
		         </div>
		    </div>
           
    <!-- 循环结束 -->
  
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:94%;">
               <div style="width:100%;float:left;margin-top:0px;">
                 <input type="button" class="fg-but btn_one btn_approve" value="确定">
                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
              
                
                 
                </div>
            </div>
           
        </form>
    </div>
  
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
var supplier_id="<?php echo $supplier_id;?>";

$(document).ready(function(){

	$(".itab ul li").click(function(){
       var value=$(this).attr("static");
       $(".itab").attr("data-id",value);

	   //ajax请求
	    var url="<?php echo base_url('admin/t33/supplier/api_yj_type');?>";
	    var data={supplier_id:supplier_id,type:value};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
		    //内容
		    $(".man").val(return_data.data.agent.man);
		    $(".oldman").val(return_data.data.agent.oldman);
		    $(".child").val(return_data.data.agent.child);
		    $(".childnobed").val(return_data.data.agent.childnobed);
		    $(".agent_rate").val(return_data.data.agent.agent_rate);
		    
		    
		    var str="";
		    for(var i in return_data.data.days)
		    {
			    str+="<p><input class='day' type='text' value='"+return_data.data.days[i].day+"' />天<input class='money' type='text' value='"+return_data.data.days[i].money+"' />元/人";
                str+="<a href='javascript:void(0)' class='a_delete' data-id='"+return_data.data.days[i].id+"' style='margin-left:10px;'>删除</a>";
			    str+="</p>";
			}
		    $(".div_p").html(str);
		    //tab
	    	var type="1";
	    	if(!$.isEmptyObject(return_data.data.agent))
	    		type=return_data.data.agent.type;
	    	$(".div_set").hide();
	    	$("#div"+type).show();
	    	

	    	$(".btn_radio:[value="+type+"]").attr("checked","checked");
	    }
	    else
	    {
	        tan(return_da);
	    }
	})
	
	var type="<?php echo isset($agent['type'])==true?$agent['type']:'1';?>";
	var agent_type="<?php echo isset($agent_type)==true?$agent_type:'1';?>";
	
	$(".div_set").hide();
	$("#div"+type).show();
	$(".itab li a").removeClass("active");
	$(".itab li[static="+agent_type+"] a").addClass("active");
	
})
//审核通过按钮
$("body").on("click",".btn_approve",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var type=$('input:radio:checked').val();
		var man=$('.man').val();
		var oldman=$('.oldman').val();
		var child=$('.child').val();
		var childnobed=$('.childnobed').val();
		var agent_rate=$('.agent_rate').val();
		var agent_type=$(".itab").attr("data-id");

		var day_arr=[];//数组
		$(".div_p p").each(function(index){ 

			var arr=[];
			var id=$(this).attr("data-id");
			var day=$(this).find(".day").val();
			var money=$(this).find(".money").val();
			
			day_arr[index]={
                 'id':id,
                 'day':day,
                 'money':money
				};
		});
		
	    var url="<?php echo base_url('admin/t33/supplier/api_set_yj');?>";
	    var data={supplier_id:supplier_id,agent_type:agent_type,type:type,man:man,oldman:oldman,child:child,childnobed:childnobed,agent_rate:agent_rate,day_arr:day_arr};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
	    	tan2(return_data.data);
			setTimeout(function(){t33_close_iframe_noreload();},200);
	
			//刷新页面
			//parent.$("#main")[0].contentWindow.getValue();
	    }
	    else
	    {
	        tan(return_data.msg);
	    }
	}
	
});


$("body").on("click",".btn_radio",function(){
	var value=$(this).val();
	$(".div_set").hide();
	$("#div"+value).show();
	

});
$("body").on("click",".a_add",function(){
	var html="<p><input type='text' class='day' />天<input type='text' class='money' />元/人<a href='javascript:void(0)' class='a_delete' style='margin-left:10px;'>删除</a></p>";
	$(".div_p").append(html);

});
$("body").on("click",".a_delete",function(){
	 var url="<?php echo base_url('admin/t33/supplier/api_delete_agent');?>";
	 var id=$(this).attr("data-id");
    var data={id:id};
    var return_data=send_ajax_noload(url,data);
    if(return_data.code=="2000")
    {
    	$(this).parent().remove(); //js
    	tan2(return_data.data);
    }
    else
    {
        tan(return_data.msg);
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
