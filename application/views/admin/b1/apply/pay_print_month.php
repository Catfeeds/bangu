<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款申请单</title>
<!--startprint1-->
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:32px;line-height:20px;background:#fff;float:left;width:80%;margin-top:0px;color:#000000;
}
.p_warp font{margin-right:50px;color: #000;font-family: tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif;}

.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}


.not-allow{cursor:not-allowed !important;opacity:0.5;}

.search_group{margin:0 10px 10px 10px !important;}
.search_group label{width:auto !important;}

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
  /*border: solid 1px blue;*/
  margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
}


/**/
fieldset{margin-bottom:10px;border:1px solid #000;}
.p_line{height:16px;line-height:16px;border-left:3px solid #000;padding-left:5px;margin:5px 0;font-weight:bold !important;}
.header_div{float:left;width:100%;border-bottom:2px solid #000;margin-bottom:5px;padding-bottom:5px;}
.header_div .p1{width:30%;float:left;}
.header_div .p2{width:40%;float:left;text-align:center;font-size:18px;font-weight:bold !important;}
.header_div .p3{width:30%;float:left;text-align:right;}

.footer_div{float:left;width:100%;margin-bottom:5px;margin-top:20px;}
.footer_div .p1,.footer_div .p2{width:75%;float:left;text-align:right;margin:10px 0;}

.printTable{}
.printTable td,.printTable>tbody>tr>td,.printTable>thead>tr>th{border: 1px solid #000!important;height: 24px;}
.printTable th,.printTable td{border: 1px solid #000!important;height: 24px;padding: 0 3px;}

.printf_div{padding: 15px 0 0 0 !important;width: 750px;margin: 0 auto;}

</style>
<style type="text/css" media=print>
.noprint{visibility:hidden;display : none;}   //不打印
</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="printf_div" id="printf_div" style="">
                  
                 <div class="header_div">
                   <p class="p1">页：<font>1/1</font></p>
                   <p class="p2">付款申请单</p>
                   <p class="p3">打印日期：<font><?php echo date("Y-m-d H:i:s");?></font></p>
                 </div>
                    
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
                   
                   <p class="p_line">订单列表</p>
                    <!-- 使用明细 -->
                    <div class="table_list">
                       
                        <table class="table table-bordered printTable">
                            <thead class="">
                                <tr class="tr_rows">
  
                                </tr>
                            </thead>
                            <tbody class="data_rows">
                         
      
                            </tbody>
                        </table>
                        
                       
                     
                         <div id="page_div" style="background: #fff;text-align:right;"></div>
                         
	                      <div class="footer_div">
		                   <p class="p1">供应商盖章签字：</p>
		                   <p class="p2">签字日期：</p>
		                 </div>
                       
                     
                    </div>  
                                  
                </div>
                <!--endprint1-->  
                <!-- 审核 -->
                       
					    <div class="fb-form noprint" id="print_div" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					            <div class="form-group" style="text-align:right;float:left;width:98%;background:#fff;border:none;margin:5px 10px !important;">
					               <div style="width:100%;float:left;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">

					                 <input type="button" class="fg-but btn_one" id="btn_printf" onclick="preview(1);" style="background:#da411f;" value="打印月结">
					                 
					                </div>
					            </div>
					   
					   <!-- 审核结束 -->   
               
            </div>

        </div>
        
    </div>



<script type="text/javascript">

    var id="<?php echo $id;?>";
    var action="<?php echo $action; ?>";
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
 
        init:function(){ //   打印的数据
           
            var ordersn=$("#ordersn").val();
            var productname=$("#productname").val();

            if(action=="1")
	        	$(".tr_rows").html('<th>付款单号</th><th>团号</th><th>本次结算金额</th><th>营业部</th><th>线路名称</th><th>人数</th><th>总团款</th><th>操作费</th><th>应付款</th><th>已付款</th><th>未付款</th>');
        	else if(action=="2")
        		$(".tr_rows").html('<th>付款单号</th><th>团号</th><th>本次结算金额</th><th>营业部</th><th>线路名称</th><th>人数</th><th>总团款</th><th>操作费</th><th>应付款</th><th>已付款</th><th>未付款</th>');
        	
            //接口数据
            var post_url="<?php echo base_url('admin/b1/apply/apply_order_log/api_pay_order')?>";
        	ajax_data={page:"1",id:id};
        	var return_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var str="";
        	if(return_data.code=="2000")
        	{
            	var data=return_data.data.result;

            	var amount_apply_total=jiesuan_money_total=balance_money_total=nopay_money_total=platform_fee_total=supplier_cost_total=all_people=0;
            	for(var i in data)
         	    {
             	    if(data[i].status=="2"||data[i].status=="1"||data[i].status=="4")
             	    {
                 	    
                     var no=i+1;
         	        str += "<tr>";

         	        var class_str="";
         	        var disabled_str="";
         	        if(data[i].status!="1")
         	        {
         	        class_str="not-allow";
         	        disabled_str="disabled";
         	        }
         	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-id='"+data[i].id+"' />";
   
         	       if(action=="2")
         	       str +=     "<td>"+input_str+"</td>"; //checkbox
         	       
         	        str +=     "<td>"+data[i].payable_id+"</td>";
         	        str +=     "<td>"+data[i].item_code+"</td>";
         	        str +=     "<td>"+data[i].amount_apply+"</td>";
         	    //    str +=     "<td>"+data[i].apply_percent+"</td>";
         	        str +=     "<td>"+data[i].depart_name+"</td>";
         	        str +=     "<td>"+data[i].productname+"</td>";
         	        str +=     "<td>"+data[i].total_people+"</td>";
         	        str +=     "<td>"+data[i].supplier_cost+"</td>";
                   //str +=     "<td>"+data[i].supplier_cost+"</td>";
                    str +=     "<td>"+data[i].platform_fee+"</td>";
         	        str +=     "<td>"+data[i].jiesuan_money+"</td>";
         	        str +=     "<td>"+data[i].balance_money+"</td>";
         	        str +=     "<td>"+data[i].nopay_money+"</td>";
                    // str +=     "<td>"+data[i].pay_percent+"</td>";

          	       str += "</tr>";
          	      

          	     //汇总
          	      all_people=object.accAdd(all_people,data[i].total_people);
          	      amount_apply_total=object.accAdd(amount_apply_total,data[i].amount_apply);
         	      jiesuan_money_total=object.accAdd(jiesuan_money_total,data[i].jiesuan_money);
         	      balance_money_total=object.accAdd(balance_money_total,data[i].balance_money);
         	      nopay_money_total=object.accAdd(nopay_money_total,data[i].nopay_money);
         	      platform_fee_total=object.accAdd(platform_fee_total,data[i].platform_fee); 
         	      supplier_cost_total=object.accAdd(supplier_cost_total,data[i].supplier_cost);
             	  
           	    
          	      i++;

          	      }  //if end
         	    } //for end
            	str +=     "<tr><td colspan='2' align=\"right\">总计：</td><td>"+amount_apply_total+"</td><td colspan='2'></td><td>"+all_people+"</td><td>"+supplier_cost_total+"</td><td>"+platform_fee_total+"</td><td>"+jiesuan_money_total+"</td><td>"+balance_money_total+"</td><td>"+nopay_money_total+"</td></tr>";

        	    //重写页眉处的页数
        	    
        	    $(".header_div .p1 font").html(return_data.data.page+"/"+return_data.data.total_page);
        	    
            	$(".no-data").hide();
        	}
        	else if(return_data.code=="4001")
        	{
	        	str="";
	        	$(".no-data").show();
	        }
        	else
        	{
        		layer.msg(return_data.msg, {icon: 1});
        		$(".no-data").hide();
	        }
        	//console.log(str);
	        $(".data_rows").html(str);
        	
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
 
      },
      accAdd:function(arg1, arg2){
    	  var r1, r2, m, c;
  	    try {
  	        r1 = arg1.toString().split(".")[1].length;
  	    }
  	    catch (e) {
  	        r1 = 0;
  	    }
  	    try {
  	        r2 = arg2.toString().split(".")[1].length;
  	    }
  	    catch (e) {
  	        r2 = 0;
  	    }
  	    c = Math.abs(r1 - r2);
  	    m = Math.pow(10, Math.max(r1, r2));
  	    if (c > 0) {
  	        var cm = Math.pow(10, c);
  	        if (r1 > r2) {
  	            arg1 = Number(arg1.toString().replace(".", ""));
  	            arg2 = Number(arg2.toString().replace(".", "")) * cm;
  	        } else {
  	            arg1 = Number(arg1.toString().replace(".", "")) * cm;
  	            arg2 = Number(arg2.toString().replace(".", ""));
  	        }
  	    } else {
  	        arg1 = Number(arg1.toString().replace(".", ""));
  	        arg2 = Number(arg2.toString().replace(".", ""));
  	    }
  	    return (arg1 + arg2) / m;
      }
      //object  end
    };


	

$(function(){
	object.init();
	
  

    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $("body").on("click",".btn_close",function()
    {
    	window.close();
    	
    });

});




function preview(oper)         
{  
	
	if (oper < 10)  
	{  
	
	/* bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
	sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域  
	eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域  
	prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)); //从开始代码向后取html  
	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html  

	window.document.body.innerHTML=prnhtml;   */
	window.print();  

	} 
	else 
	{  
		window.print();  
	}  
} 





</script>

</html>


