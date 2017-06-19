<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

</head>
<body>

<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--startprint1-->
<style type="text/css">

#bodyMsg{

margin:100px 0 0 200px;

}

#bodyMsg input{height:24px;line-height:24px;}
.btn_del{width:90px;}


</style>
<style type="text/css" media=print>
.noprint{visibility:hidden;display : none;}   //不打印
</style>
<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg" >
        <input type="text" class="mobile" /> <input type="button" class="btn_del" value="删除手机号" />
        
    </div>
   


<script type="text/javascript">

  
   
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

	

    $(document).ready(function(){

    	$(".btn_del").click(function(){

    	var mobile=$(".mobile").val();
    	if(mobile=="")  { tan('此号码不允许删除'); return false;}

    	var url="<?php echo base_url('admin/t33/home/api_del_mobile');?>";
		var data={mobile:mobile}
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code=="2000")
		{
			tan2(return_data.data);
			
			//window.location.reload();
		}
		else
		{
			tan(return_data.msg);
		}
    	

       })

    })

  
	
    




</script>

</html>


