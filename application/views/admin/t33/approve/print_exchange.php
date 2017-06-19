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


/* 去掉页眉页脚  */
@page {
  size: auto;  /* auto is the initial value */
  margin: 0mm; /* this affects the margin in the printer settings */
}
html {
  background-color: #FFFFFF;
  margin: 0px; /* this affects the margin on the HTML before sending to printer */
}
body {
font-family: tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif;
  /*border: solid 1px blue;*/
/*   margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */ */
}
.p_line{height:16px;line-height:16px;margin:5px 0;text-align:center;}
.td_left{text-align:left !important;}
.printTable{}
.printTable td,.printTable>tbody>tr>td,.printTable>thead>tr>th{border: 1px solid #000!important;height: 24px;}
.printTable th,.printTable td{border: 1px solid #000!important;height: 24px;padding: 0 3px;}
.p_content{width: 100%;margin: 0 auto;text-align: center;}
.printf_div{padding: 15px 0 0 0 !important;width: 750px;margin: 0 auto;}

</style>
<style type="text/css" media=print>
.noprint{visibility:hidden;display : none;}   //不打印
</style>
<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg" >
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray" style="width: 100%;">      
            <!-- tab切换表格 -->
            <div class="p_content" style="">
                <div id="printf_div" class="printf_div">
                    <div style="margin: 0px 3px;font-size: 12px;">
                    </br>
                    <p class="p_line" style="font-family: Microsoft YaHei;font-size: 14px;text-align: center;">提现确认单</p>
                    <!-- 收款确认单-->
                    <div class="table_list" style="margin: 0 auto;text-align: center;">
                        <table class="table_list printTable" style="border: 1px solid #000;" border="1" width="100%">
                            <tbody class="data_rows">
                               <tr><td colspan="6" class="td_left">申请信息</td></tr>
                              
                               <tr><td width="90px">管家：</td><td class="td_left" width="120px"><?php echo $exchange['expert_name'];?></td><td width="90px">申请时间：</td><td class="td_left" width="150px"><?php echo $exchange['addtime'];?></td><td width="90px">金额：</td><td class="td_left"><?php echo $exchange['amount'];?></td></tr>
                               <tr><td width="90px">银行名称：</td><td class="td_left" width="120px"><?php echo $exchange['bankname'];?></td><td width="90px">银行卡号：</td><td class="td_left" width="150px"><?php echo $exchange['bankcard'];?></td><td width="90px">持卡人：</td><td class="td_left"><?php echo $exchange['cardholder'];?></td></tr>
                               <tr><td width="90px">备注：</td><td class="td_left" colspan="5"><?php echo $exchange['beizhu'];?></td></tr>
                               <tr><td width="90px">明细：</td><td class="td_left" colspan="5">
                                <?php if(!empty($exchange_depart)): ?>
		                          <?php foreach ($exchange_depart as $k=>$v):?>
		                               <p class="<?php if(($k+1)==count($exchange_depart)) echo 'tx_p2';else echo 'tx_p';?>"><font>部门：<?php echo $v['depart_name'];?> </font> <font>提现金额： <?php echo $v['amount'];?>元</font></p>
		                          <?php endforeach;?>
		                         <?php endif;?>
                               </td></tr>
                               <tr><td colspan="6" class="td_left">审核信息</td></tr>
                               <tr><td>审核人：</td><td class="td_left"><?php echo $exchange['employee_name'];?></td><td>审核时间：</td><td class="td_left" colspan="3"><?php echo $exchange['modtime'];?></td></tr>
                               <tr><td width="90px">状态：</td><td class="td_left"><?php if($exchange['status']=="0") echo "申请中";else if($exchange['status']=="1") echo "已通过";else if($exchange['status']=="2") echo "已拒绝";?></td><td>审核备注：</td><td class="td_left" colspan="3"><?php echo $exchange['remark'];?></td></tr>
                            </tbody>
                        </table>
                    </div>  
                     <!-- 收款记录明细 -->
                   
                           </div>       
                </div>

                <!--endprint1-->  
                 <div class="fb-form noprint" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                                             
					                 <input type="button" class="fg-but btn_one" onclick="preview(1);" style="background:#da411f;" value="打印">
					                 
					                </div>
					            </div>
					           
					        </form>
				   </div>
               
            </div>

        </div>
        
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

	
$(function(){

  
	
    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $("body").on("click",".btn_close",function()
    {
        //          parent.layer.close(index);
    	window.close();
    });

});


function preview(oper)         
{  
	
	if (oper < 10)  
	{
		
        	//打印
//         	 $(".pagehead").show();
//         		bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
//         		sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域  
//         		eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域  
//         		prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)); //从开始代码向后取html  
//         		prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html  
//         		window.document.body.innerHTML=prnhtml;  
        		window.print();  
        		//取消打印时恢复数据
//         		window.location.reload();
      

	} 
	else 
	{  
		window.print();  
	}  
} 
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
      $(".total_money").html(money);
}




</script>

</html>


