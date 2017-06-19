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
    width: 70px;
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

.part2 p input{width:11%;height:24px;padding:2px 0 2px 5px;margin-left:10px;}

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
            <div class="table_content" style="padding-bottom:0;">
               
		        <div class="content_part" style="margin-bottom:0;">
		          <!-- 散拼 -->
		                <div class=" clear" style="border-bottom: 1px solid #69B716;width:640px;padding:2px 15px;color:#69B716;">
		                    <span class="txt_info fl">散拼</span>
		                </div> 
		                 <table class="order_info_table table_td_border tb1" border="0" width="100%" cellspacing="0" style="border: none;">
		                    <tr height="40">
		                        <td class="order_info_title" style="width:80px !important;">计算方式:</td>
		                        <td colspan="3">
		                         <label class="label"><input type="radio" name="type" value="1" class="btn_radio" <?php if((isset($agent['type'])==true&&$agent['type']=="1")||isset($agent['type'])==false) echo "checked";?> />人群</label>
		                         <label class="label"><input type="radio" name="type" value="2" class="btn_radio" <?php if(isset($agent['type'])==true&&$agent['type']=="2") echo "checked";?> />比例</label>
		                         <label class="label"><input type="radio" name="type" value="3" class="btn_radio" <?php if(isset($agent['type'])==true&&$agent['type']=="3") echo "checked";?> />天数</label>
		                        </td>
		                   		
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">佣金设置:</td>
		                        <td colspan="3">
		                           <div class="part1 div_set" id="div1">
		                             <p><font>成人(元/人)：</font><input type="text" class="man" value="<?php echo isset($agent['man'])==true?$agent['man']:'';?>" /><font>老人(元/人)：</font><input type="text" class="oldman" value="<?php echo isset($agent['man'])==true?$agent['oldman']:'';?>" /></p>
		                             
		                             <p><font>儿童占床(元/人)：</font><input type="text" class="child" value="<?php echo isset($agent['man'])==true?$agent['child']:'';?>" /><font>儿童不占床(元/人)：</font><input type="text" class="childnobed" value="<?php echo isset($agent['man'])==true?$agent['childnobed']:'';?>" /></p>
		                            
		                           </div>
		                           <div class="part1 div_set" id="div2" style="display:none;"> 
		                             <p><font>比例（如0.1）：</font><input type="text" class="agent_rate" value="<?php echo isset($agent['agent_rate'])==true?$agent['agent_rate']:'';?>" /></p>
		                            
		                           </div>
		                           <div class="part2 div_set" id="div3" style="display:none;">
		                             <div class="div_p">
		                             <?php if(empty($days)):?>
		                             <p>
		                             	<input type="text" class="day" />天
		                             	<input type="text" class="money" />元/成人
		                             	<input type="text" class="money_childbed" />元/儿童占床
		                             	<input type="text" class="money_child" />元/儿童不占床
		                             </p>
		                              <?php else:?>
		                                <?php foreach ($days as $k=>$v):?>
		                               	<p data-id="<?php echo $v['id'];?>">
		                               		<input type="text" class="day" value="<?php echo isset($v['day'])==true?$v['day']:'';?>" />天
		                               		<input type="text" class="money" value="<?php echo isset($v['money'])==true?$v['money']:'';?>" />元/成人
		                               		<input type="text" class="money_childbed" value="<?php echo isset($v['money_childbed'])==true?$v['money_childbed']:'';?>" />元/儿童占床
		                               		<input type="text" class="money_child" value="<?php echo isset($v['money_child'])==true?$v['money_child']:'';?>" />元/儿童不占床
		                               		<a href="javascript:void(0)" class="a_delete" data-id="<?php echo $v['id'];?>" style="margin-left:10px;">删除</a>
		                               	</p>
		                                <?php endforeach;?>
		                              <?php endif;?>
		                              
		                             </div>
		                            <a href="javascript:void(0)" class="a_add" style="margin-left:10px;">新增行数</a>
		                           </div>
		                        </td>
		                       
		                    </tr>
		                </table>
		                
		         </div>
		          <!-- 包团 -->
		                <div class=" clear" style="border-bottom: 1px solid #69B716;width:640px;padding:2px 15px;color:#69B716;">
		                    <span class="txt_info fl">包团</span>
		                </div> 
		                 <table class="order_info_table table_td_border tb1" border="0" width="100%" cellspacing="0" style="border: none;">
		                    <tr height="40">
		                        <td class="order_info_title" style="width:100px !important;">计算方式:</td>
		                        <td colspan="3">
		                         <label class="label"><input type="radio" name="type_two" value="1" class="btn_radio2" <?php if((isset($agent2['type'])==true&&$agent2['type']=="1")||isset($agent2['type'])==false) echo "checked";?> />人群</label>
		                         <label class="label"><input type="radio" name="type_two" value="2" class="btn_radio2" <?php if(isset($agent2['type'])==true&&$agent2['type']=="2") echo "checked";?> />比例</label>
		                         <label class="label"><input type="radio" name="type_two" value="3" class="btn_radio2" <?php if(isset($agent2['type'])==true&&$agent2['type']=="3") echo "checked";?> />天数</label>
		                        </td>
		                   		
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">佣金设置:</td>
		                        <td colspan="3">
		                           <div class="part1 div_set2" id="div4">
		                             <p><font>成人(元/人)：</font><input type="text" class="man2" value="<?php echo isset($agent2['man'])==true?$agent2['man']:'';?>" /><font>老人(元/人)：</font><input type="text" class="oldman2" value="<?php echo isset($agent2['man'])==true?$agent2['oldman']:'';?>" /></p>
		                             
		                             <p><font>儿童占床(元/人)：</font><input type="text" class="child2" value="<?php echo isset($agent2['child'])==true?$agent2['child']:'';?>" /><font>儿童不占床(元/人)：</font><input type="text" class="childnobed2" value="<?php echo isset($agent2['man'])==true?$agent2['childnobed']:'';?>" /></p>
		                            
		                           </div>
		                           <div class="part1 div_set2" id="div5" style="display:none;"> 
		                             <p><font>比例（如0.1）：</font><input type="text" class="agent_rate2" value="<?php echo isset($agent2['agent_rate'])==true?$agent2['agent_rate']:'';?>" /></p>
		                            
		                           </div>
		                           <div class="part2 div_set2" id="div6" style="display:none;">
		                             <div class="div_p2">
		                             <?php if(empty($days2)):?>
		                             <p>
		                             	<input type="text" class="day" />天
		                             	<input type="text" class="money" />元/成人
		                             	<input type="text" class="money_childbed" />元/儿童占床
		                             	<input type="text" class="money_child" />元/儿童不占床
		                             </p>
		                             <?php else:?>
		                                <?php foreach ($days2 as $k=>$v):?>
		                               	<p data-id="<?php echo $v['id'];?>">
			                               	<input type="text" class="day" value="<?php echo isset($v['day'])==true?$v['day']:'';?>" />天
			                               	<input type="text" class="money" value="<?php echo isset($v['money'])==true?$v['money']:'';?>" />元/成人
			                               	<input type="text" class="money_childbed" value="<?php echo isset($v['money_childbed'])==true?$v['money_childbed']:'';?>" />元/儿童占床
			                               	<input type="text" class="money_child" value="<?php echo isset($v['money_child'])==true?$v['money_child']:'';?>" />元/儿童不占床
			                               	<a href="javascript:void(0)" class="a_delete" data-id="<?php echo $v['id'];?>" style="margin-left:10px;">删除</a>
		                               	</p>
		                                <?php endforeach;?>
		                              <?php endif;?>
		                              
		                             </div>
		                            <a href="javascript:void(0)" class="a_add2" style="margin-left:10px;">新增行数</a>
		                           </div>
		                        </td>
		                       
		                    </tr>
		                </table>
		                
		         </div>
		         <!-- 包团 -->
		    </div>
           
    <!-- 循环结束 -->
  
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form-group" style="margin:0 0 30px 0;text-align:center;float:left;width:94%;">
               <div style="width:100%;float:left;margin-top:0px;">
                 <input type="button" class="fg-but btn_one btn_approve" value="保存设置">
                 
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
//散拼
var init_type="<?php echo isset($agent['type'])==true?$agent['type']:'';?>"; 
var init_man="<?php echo isset($agent['man'])==true?$agent['man']:'';?>"; 
var init_oldman="<?php echo isset($agent['oldman'])==true?$agent['oldman']:'';?>"; 
var init_child="<?php echo isset($agent['child'])==true?$agent['child']:'';?>"; 
var init_childnobed="<?php echo isset($agent['childnobed'])==true?$agent['childnobed']:'';?>"; 

//包团
var init_type2="<?php echo isset($agent2['type'])==true?$agent2['type']:'1';?>";
var init_man2="<?php echo isset($agent2['man'])==true?$agent2['man']:'';?>"; 
var init_oldman2="<?php echo isset($agent2['oldman'])==true?$agent2['oldman']:'';?>"; 
var init_child2="<?php echo isset($agent2['child'])==true?$agent2['child']:'';?>"; 
var init_childnobed2="<?php echo isset($agent2['childnobed'])==true?$agent2['childnobed']:'';?>";

function check_change()
{
	var type=$('.btn_radio:checked').val();
	var man=$('.man').val();
	var oldman=$('.oldman').val();
	var child=$('.child').val();
	var childnobed=$('.childnobed').val();
	var agent_rate=$('.agent_rate').val();

	var type2=$('.btn_radio2:checked').val();
	var man2=$('.man2').val();
	var oldman2=$('.oldman2').val();
	var child2=$('.child2').val();
	var childnobed2=$('.childnobed2').val();
	var agent_rate2=$('.agent_rate2').val();
   
	if(init_type!=type||init_type2!=type2||init_man!=man||init_man2!=man2||init_oldman!=oldman||init_oldman2!=oldman2||init_child!=child||init_child2!=child2||init_childnobed!=childnobed||init_childnobed2!=childnobed2)
	 	return true; //有变化
	else
		return false; //无变化
	
}
$(document).ready(function(){
	var type="<?php echo isset($agent['type'])==true?$agent['type']:'1';?>"; 
	var type2="<?php echo isset($agent2['type'])==true?$agent2['type']:'1';?>"; 
	$(".div_set").hide();
	$("#div"+type).show();

	$(".div_set2").hide();
	if(type2=="1")
		$("#div4").show();
	else if(type2=="2")
		$("#div5").show();
	else if(type2=="3")
		$("#div6").show();
	
})
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
//审核通过按钮
$("body").on("click",".btn_approve",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		//散拼
		var type=$('.btn_radio:checked').val();
		var man=$('.man').val();
		var oldman=$('.oldman').val();
		var child=$('.child').val();
		var childnobed=$('.childnobed').val();
		var agent_rate=$('.agent_rate').val();
		var day_arr=[];//数组
		$(".div_p p").each(function(index){ 

			var arr=[];
			var id=$(this).attr("data-id");
			var day=$(this).find(".day").val();
			var money=$(this).find(".money").val();
			var money_child=$(this).find(".money_child").val();
			var money_childbed=$(this).find(".money_childbed").val();
			
			day_arr[index]={
                 'id':id,
                 'day':day,
                 'money':money,
                 'money_child':money_child,
                 'money_childbed':money_childbed
				};
		});
		//包团
		var type2=$('.btn_radio2:checked').val();
		var man2=$('.man2').val();
		var oldman2=$('.oldman2').val();
		var child2=$('.child2').val();
		var childnobed2=$('.childnobed2').val();
		var agent_rate2=$('.agent_rate2').val();
		var day_arr2=[];//数组
		$(".div_p2 p").each(function(index){ 

			var arr=[];
			var id=$(this).attr("data-id");
			var day=$(this).find(".day").val();
			var money=$(this).find(".money").val();
			var money_child=$(this).find(".money_child").val();
			var money_childbed=$(this).find(".money_childbed").val();
			
			day_arr2[index]={
                 'id':id,
                 'day':day,
                 'money':money,
                 'money_child':money_child,
                 'money_childbed':money_childbed
				};
		});
		//alert(type2)
		if(check_change()){
			var str="散拼按";
			if(type=="1")
				str+="人群";
			else if(type=="2")
				str+="比例";
			else if(type=="3")
				str+="天数";
			str+="、包团按";
			if(type2=="1")
				str+="人群";
			else if(type2=="2")
				str+="比例";
			else if(type2=="3")
				str+="天数";
			str+="计算佣金";
			
			layer.confirm('确定要保存所做修改:'+str+'？', {btn: ['确定','取消'] },function(){
				//设置
				var url="<?php echo base_url('admin/t33/supplier/api_set_yj2');?>";
			    var data={supplier_id:supplier_id,type:type,man:man,oldman:oldman,child:child,childnobed:childnobed,agent_rate:agent_rate,day_arr:day_arr,
			    		type2:type2,man2:man2,oldman2:oldman2,child2:child2,childnobed2:childnobed2,agent_rate2:agent_rate2,day_arr2:day_arr2,
			    	    };
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
			    //设置 end
			},function(){
				
				}
			);
			
		}
		else
		{
			//设置
			var url="<?php echo base_url('admin/t33/supplier/api_set_yj2');?>";
		    var data={supplier_id:supplier_id,type:type,man:man,oldman:oldman,child:child,childnobed:childnobed,agent_rate:agent_rate,day_arr:day_arr,
		    		type2:type2,man2:man2,oldman2:oldman2,child2:child2,childnobed2:childnobed2,agent_rate2:agent_rate2,day_arr2:day_arr2,
		    	    };
		    var return_data=send_ajax_noload(url,data);
		    //设置 end
			 parent.layer.close(index); //关闭窗口
		}
	    
	}
	
});


$("body").on("click",".btn_radio",function(){
	var value=$(this).val();
	$(".div_set").hide();
	$("#div"+value).show();
});
$("body").on("click",".btn_radio2",function(){
	var value=$(this).val();
	$(".div_set2").hide();
	if(value=="1")
		$("#div4").show();
	else if(value=="2")
		$("#div5").show();
	else if(value=="3")
		$("#div6").show();
});

$("body").on("click",".a_add",function(){
	var html="<p>"+
				"<input type='text' class='day' />天"+
				"<input type='text' class='money' />元/成人"+
				"<input type='text' class='money_childbed' />元/儿童占床"+
				"<input type='text' class='money_child' />元/儿童不占床"+
				"<a href='javascript:void(0)' class='a_delete' style='margin-left:10px;'>删除</a>"+
			"</p>";
			
	//var html="<p><input type='text' class='day' />天<input type='text' class='money' />元/人<a href='javascript:void(0)' class='a_delete' style='margin-left:10px;'>删除</a></p>";
	$(".div_p").append(html);
});
$("body").on("click",".a_add2",function(){
	var html="<p>"+
				"<input type='text' class='day' />天"+
				"<input type='text' class='money' />元/成人"+
				"<input type='text' class='money_childbed' />元/儿童占床"+
				"<input type='text' class='money_child' />元/儿童不占床"+
				"<a href='javascript:void(0)' class='a_delete' style='margin-left:10px;'>删除</a>"+
			"</p>";
	//var html="<p><input type='text' class='day' />天<input type='text' class='money' />元/人<a href='javascript:void(0)' class='a_delete' style='margin-left:10px;'>删除</a></p>";
	$(".div_p2").append(html);
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

$('.btn_close').click(function()
{
   
     parent.layer.close(index);
});

</script>
</body>

</html>
