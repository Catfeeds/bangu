<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
select{display:inline-block;margin-right:5px;}
</style>
</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
 <!-- 添加供应商 弹窗 -->
<div class="fb-content" id="form1">
   
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
         <div class="list">
         <?php if(empty($list)):?>
         <div class="supplier_row" data-id="" data-supplier-id="<?php echo $supplier_id;?>" style="min-height: 208px;margin-top:30px;">
            <div class="form-group div13">
                <div class="fg-title" style="width:22% !important">银行名称：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder bankname" placeholder="银行名称" name="showorder" value=""></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">支行：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder brand"  placeholder="开户所在支行" name="showorder" value=""></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">银行卡号：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder bank"  placeholder="银行卡号" name="showorder" value=""></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">开户人：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder openman"  placeholder="开户人姓名" name="showorder" value=""></div>
            </div>
            
            </div>
            
         <?php else:?>
         
              <?php foreach ($list as $k=>$v):?>
         
           <div class="supplier_row" data-id="<?php echo $v['id'];?>" data-supplier-id="<?php echo $supplier_id;?>" style="min-height: 208px;">
            <div class="form-group div13">
                <div class="fg-title" style="width:22% !important">银行名称：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder bankname" placeholder="银行名称" value="<?php echo $v['bankname'];?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">支行：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder brand" placeholder="开户所在支行" value="<?php echo $v['brand'];?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">银行卡号：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder bank"  placeholder="银行卡号" value="<?php echo $v['bank'];?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title" style="width:22% !important">开户人：<i>*</i></div>
                <div class="small-input" style="width:60%;"><input type="text" class="showorder openman"  placeholder="开户人姓名" value="<?php echo $v['openman'];?>"></div>
            </div>
            
            </div>
           <?php endforeach;?>
        
         <?php endif;?>
        </div>
            <!-- 新增银行卡账户，暂时屏蔽改功能 -->
           <!-- <a href="javascipt:void(0)" class="add_div" style="margin-left:12%;">新增银行账户</a>-->
            <div class="form-group" style="margin-bottom:20px;margin-bottom:20px;">
               
              
                <input type="button" id="btn_close" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but" onclick="object.submitData()" value="确定">
        
            </div>
            <div class="clear"></div>
           
        </form>
    </div>
</div>

<script type="text/javascript">

var supplier_id="<?php echo $supplier_id;?>";
//js对象
var object = object || {};
var ajax_data={};
object = {
    init:function(){ //初始化方法
        
    	
    },
    submitData:function(){  //提交表单
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var bankname=$(".bankname").val();
	    	var brand=$(".brand").val();
	    	var bank=$(".bank").val();
	    	var openman=$(".openman").val();
	    	
	   
	    	if(bankname=="")  { tan('请填写银行名称');return false;}
	    	if(brand=="")  { tan('请填写支行');return false;}
	    	if(bank=="")  { tan('请填写银行卡号');return false;}
	    	if(openman=="")  { tan('请填写开户人');return false;}
	    	
	  
			var post_arr=[];//数组
			$(".supplier_row").each(function(index){ 
				
				var arr=[];
				var id=$(this).attr("data-id");
				var supplier_id=$(this).attr("data-supplier-id");
				var bankname=$(this).find(".bankname").val();
				var brand=$(this).find(".brand").val();
				var bank=$(this).find(".bank").val();
				var openman=$(this).find(".openman").val();
				post_arr[index]={
	                 'id':id,
	                 'supplier_id':supplier_id,
	                 'bankname':bankname,
	                 'brand':brand,
	                 'bank':bank,
	                 'openman':openman
					};
			});
			
	    	var post_url="<?php echo base_url('admin/t33/supplier/api_set_bank')?>";
	    	var return_data=object.send_ajax_noload(post_url,{post_arr:post_arr});
	    	
	    	if(return_data.code=="2000")
	    	{
	    		var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	    		tan2(return_data.data);
	    		setTimeout(function(){parent.layer.close(index);}, 500);  //0.2秒后消失
	    		
	        }
	    	else
	    	{
	        	tan(return_data.msg);
	        }
    	}
	 		
       
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
            	 setTimeout(function(){ layer.closeAll('loading');}, 200);  //0.2秒后消失
     
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
$(document).ready(function(){
	
	object.init();

	//新增账户html
	$(".add_div").click(function(){

		var html="";
		html += "<div class='supplier_row' data-id='' data-supplier-id='"+supplier_id+"' style='min-height: 208px;'>";
		html += "<div class='form-group div13'>";
		html += "      <div class='fg-title'>银行名称：<i>*</i></div>";
		html += "      <div class='small-input' style='width:60%;'><input type='text' class='showorder bankname' placeholder='银行名称'></div>";
		html += "</div>";
		html += "<div class='form-group div13'>";
		html += "      <div class='fg-title'>支行：<i>*</i></div>";
		html += "      <div class='small-input' style='width:60%;'><input type='text' class='showorder brand' placeholder='开户所在支行'></div>";
		html += "</div>";
		html += "<div class='form-group div13'>";
		html += "      <div class='fg-title'>银行卡号：<i>*</i></div>";
		html += "      <div class='small-input' style='width:60%;'><input type='text' class='showorder bank' placeholder='银行卡号'></div>";
		html += "</div>";
		html += "<div class='form-group div13'>";
		html += "      <div class='fg-title'>开户人：<i>*</i></div>";
		html += "      <div class='small-input' style='width:60%;'><input type='text' class='showorder openman' placeholder='开户人姓名'></div>";
		html += "</div>";
		html += "</div>";

		$(".list").append(html);
	})

	//关闭弹出
	var index = parent.layer.getFrameIndex(window.name); 
	$('#btn_close').click(function()
	{
	  
	     parent.layer.close(index);
	});


})






</script>


</html>


