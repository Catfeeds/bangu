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
fieldset{margin-bottom:10px;border:1px solid #dcdcdc;}
.p_line{height:16px;line-height:16px;border-left:3px solid #000;padding-left:5px;margin:5px 0;font-weight:bold !important;}
.header_div{float:left;width:100%;border-bottom:2px solid #000;margin-bottom:5px;padding-bottom:5px;display:none;}
.header_div .p1{width:30%;float:left;}
.header_div .p2{width:40%;float:left;text-align:center;font-size:18px;font-weight:bold !important;}
.header_div .p3{width:30%;float:left;text-align:right;}

.footer_div{float:left;width:100%;margin-bottom:5px;margin-top:20px;display:none;}
.footer_div .p1,.footer_div .p2{width:75%;float:left;text-align:right;margin:10px 0;}

.notice{background:red;}

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
               
                <div class="tab_content" id="printf_div" style="padding-top: 5px;">
                  
                 <div class="header_div">
                   <p class="p1">页：<font>1/1</font></p>
                   <p class="p2">付款申请单</p>
                   <p class="p3">打印日期：<font><?php echo date("Y-m-d H:i:s");?></font></p>
                 </div>
                    
                    <fieldset>
					    <legend>&nbsp;供应商信息&nbsp;</legend>
					     <p class="p_warp" style="margin:5px 0px 0px 20px !important;">
                    	
                    	<font>供应商名称：<?php echo isset($supplier['brand'])==true?$supplier['brand']:"";?></font>
                    	
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
                        <form class="search_form" method="post" action="" id="div_search">
                            <div class="search_form_box clear" style="padding-top: 4px;width:auto;">
                            
                                <div class="search_group">
                                    <label>金额</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:64px;" /> 至 <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:64px;" />
                                    
                                </div>
                                <div class="search_group" style="margin:0 10px 0 0px !important;">
                                    <label>团号</label>
                                    <input type="text" id="team_code" name="" class="search_input" placeholder="" style="width:90px;"/>
                                </div>
                                <div class="search_group" style="margin:0 10px 0 0px !important;">
                                    <label>产品名称</label>
                                    <input type="text" id="productname" name="" class="search_input" placeholder="" style="width:120px;"/>
                                </div>
                               <div class="search_group" style="margin:0 10px 0 0px !important;">
                                    <label>申请人</label>
                                    <input type="text" id="commit_name" name="" class="search_input" placeholder="" style="width:70px;"/>
                                </div>
                                      
                 
                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" style="margin-left: 0;" class="search_button" value="搜索"/>
                                </div>
                              
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr class="tr_rows">
  
                                </tr>
                            </thead>
                            <tbody class="data_rows">
                         
      
                            </tbody>
                        </table>
                        
                          <!-- 暂无数据 -->
                        <div class="no-data" style="display:none;height:50px;line-height:50px;">木有数据哟！换个条件试试</div>
                        
                     
                         <div id="page_div" style="background: #fff;text-align:right;display:none;"></div>
                         
	                      <div class="footer_div">
		                   <p class="p1">供应商盖章签字：</p>
		                   <p class="p2">签字日期：</p>
		                 </div>
                       
                     
                    </div>  
                                  
                </div>
                <!--endprint1-->  
                <!-- 审核 -->
                        <?php if($action=="2"):?>
                        <div class="fb-form" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					           
					          
					            <p style='width:96%;margin-left:10px;'>备注：<?php echo isset($row['remark'])==true?$row['remark']:"";?></p>
					            <div class="form-group" style="width:100%;float:left;margin:0 0 0 0;">
					                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">审核意见：</div>
					                <div class="fg-input" style="width:84%;float:left;">
					                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:34px;width:90%;padding:5px;"></textarea>
					                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
					                </div>
					            </div>
					        
					            <div class="form-group" style="text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <input type="button" class="fg-but btn_two btn_refuse" value="拒绝">
                                                                      <input type="button" class="fg-but btn_one"  style="background:#da411f;" onclick="drive(1);" value="导出excel">
					                 <input type="button" class="fg-but btn_one a_print_month" style="background:#da411f;" value="打印月结">
					                 <input type="button" class="fg-but btn_one btn_approve" style="background:#da411f;" value="通过">
					                 
					                </div>
					            </div>
					           
					        </form>
					    </div>
					     <?php else:?>
					    <div class="fb-form" id="print_div" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					            <div class="form-group" style="text-align:right;float:left;width:98%;background:#fff;border:none;margin:5px 10px !important;">
					               <div style="width:100%;float:left;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                <input type="button" class="fg-but btn_one"  style="background:#da411f;" onclick="drive(1);" value="导出excel">
					                 <input type="button" class="fg-but btn_one a_print_month" style="background:#da411f;" value="打印月结">
					                 
					                </div>
					            </div>
					    <?php endif;?>
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
        init:function(){ //初始化方法
            var team_code=$("#team_code").val();
            var productname=$("#productname").val();
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            var commit_name=$("#commit_name").val();
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_pay_order')?>";
        	ajax_data={page:"1",id:id,team_code:team_code,productname:productname,commit_name:commit_name,price_start:price_start,price_end:price_end};
        	var list_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var total_page=list_data.data.total_page; //总页数
        	if(total_page>1)
               $("#page_div").css("display","block");
                       
        	//调用分页
        	laypage({
        	    cont: 'page_div',
        	    pages: total_page,
        	    jump: function(ret){
        	    	
        	    	var html=""; //html内容
		        	ajax_data.page=ret.curr; //页数
		        	var return_data=null;  //数据
		        	if(ret.curr==1)
		        	{
		        		return_data=list_data;
		        	}
		        	else
		        	{
		        		return_data=object.send_ajax(post_url,ajax_data);
			        }

		        	if(action=="1")
			        	$(".tr_rows").html('<th width="40">付款号</th><th width="110">团号</th><th width="150">产品名称</th><th width="88">出团日期</th><th width="84">结算价</th><th width="60">操作费</th><th width="84">已结算</th><th width="84">本次结算</th><th width="84">未结算</th><th width="84">待付款</th><th width="34">人数</th><th width="60">订单号</th><th width="80">销售部门</th><th width="68">状态</th><th width="45">操作</th>');
		        	else if(action=="2")
		        		$(".tr_rows").html('<th width="38"></th><th width="40">付款号</th><th width="110">团号</th><th width="150">产品名称</th><th width="88">出团日期</th><th width="84">结算价</th><th width="60">操作费</th><th width="84">已结算</th><th width="84">本次结算</th><th width="84">未结算</th><th width="84">待付款</th><th width="34">人数</th><th width="60">订单号</th><th width="80">销售部门</th><th width="68">状态</th><th width="45">操作</th>');
                	
		        	//写html内容
		        	if(return_data.code=="2000")
		        	{
	                	html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
	                	$(".no-data").hide();
		        	}
		        	else if(return_data.code=="4001")
		        	{
			        	html="";
			        	$(".no-data").show();
			        }
		        	else
		        	{
		        		layer.msg(return_data.msg, {icon: 1});
		        		$(".no-data").hide();
			        }
                	
        	        $(".data_rows").html(html);
        	        
        	    }
        	    
        	})
        	
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;

        	    var amount_apply_total=jiesuan_money_total=balance_money_total=nopay_money_total=supplier_cost_total=platform_fee_total=to_pay_money_total=0;
        	    for(var i = 0; i <= last; i++)
        	    {
                    var no=i+1;
                    var class_str="";
                    var to=object.accAdd(data[i].amount_apply,data[i].balance_money);
                 
                    if(to>data[i].jiesuan_money)
                    {
                    	class_str="notice";
                    }
        	        str += "<tr class='"+class_str+"'>";

        	        var class_str="";
        	        var disabled_str="";
        	        if(data[i].status!="1")
        	        {
        	        class_str="not-allow";
        	        disabled_str="disabled";
        	        }
        	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-id='"+data[i].id+"' data-value='"+data[i].amount_apply+"' />";

        	        if(action=="2")
        	        str +=     "<td>"+input_str+"</td>"; //checkbox

        	        str +=     "<td>"+data[i].payable_id+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].item_code+"'>"+data[i].item_code+"</a></td>";
        	       
        	       
        	        
        	         str +=     "<td><a href='javascript:void(0)' class='a_line' line-id='"+data[i].productautoid+"' line-name='"+data[i].productname+"'>"+data[i].productname+"</a></td>";
        	       
        	        str +=     "<td>"+data[i].usedate+"</td>";
//         	        str +=     "<td>"+data[i].supplier_cost+"</td>";
        	        str +=     "<td>"+toDecimal2(data[i].jiesuan_money)+"</td>";
        	        str +=     "<td>"+toDecimal2(data[i].all_platform_fee)+"</td>";
        	        str +=     "<td>"+toDecimal2(data[i].balance_money)+"</td>";
        	        str +=     "<td  style='color:#FF3300;'>"+toDecimal2(data[i].amount_apply)+"</td>";
        	        
        	        
        	        if(data[i].status=="1" || data[i].status=="2")
         	            str +=     "<td>"+toDecimal2(data[i].nopay_money2)+"</td>";
         	        else
         	        	str +=     "<td>"+toDecimal2(data[i].nopay_money)+"</td>";
        	        
        	        str +=     "<td>"+(data[i].to_pay_money==""?'0.00':toDecimal2(data[i].to_pay_money))+"</td>";
        	        str +=     "<td>"+data[i].total_people+"</td>";
//         	        str +=     "<td>"+data[i].pay_percent+"</td>";
        	        

         	        var pay_way="<?php if($row['pay_way']=="0") echo "现金";else echo "转账";?>"; 
        	      /*   str +=     "<td>"+pay_way+"</td>"; */
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"' style='margin:0;'>"+data[i].ordersn+"</a></td>";
//         	        str +=     "<td>"+data[i].expert_name+"</td>";
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        
        	        var shenhe_status="申请中";
        	        if(data[i].status=="2")
        	        	shenhe_status="已审待付";
        	        else if(data[i].status=="3")
        	        	shenhe_status="已拒绝";
        	        else if(data[i].status=="4")
        	        	shenhe_status="已付款";
        	        else if(data[i].status=="5")
        	        	shenhe_status="已拒绝";
        	        str +=     "<td class='td_status'>"+shenhe_status+"</td>";

        	        var print_str="";
          	       if(data[i].status=="2"||data[i].status=="4")
          	    	  print_str="<a href='javascript:void(0)' class='a_print' data-id='"+data[i].id+"'>打印预付</a>";
          	    	str +=     "<td>"+print_str+"</td>";
        	      
         	       str += "</tr>";

         	       //汇总
         	       if(data[i].status=="2"||data[i].status=="1"||data[i].status=="4")
         	       {
         	         amount_apply_total=object.accAdd(amount_apply_total,data[i].amount_apply);
         	         jiesuan_money_total=object.accAdd(jiesuan_money_total,data[i].jiesuan_money);
         	         balance_money_total=object.accAdd(balance_money_total,data[i].balance_money);

         	         if(data[i].status=="1" || data[i].status=="2")
         	         	nopay_money_total=object.accAdd(nopay_money_total,data[i].nopay_money2);
         	         else
         	        	nopay_money_total=object.accAdd(nopay_money_total,data[i].nopay_money);
          	            
         	         platform_fee_total=object.accAdd(platform_fee_total,data[i].all_platform_fee);
         	         supplier_cost_total=object.accAdd(supplier_cost_total,data[i].supplier_cost);
         	         to_pay_money_total=object.accAdd(to_pay_money_total,data[i].to_pay_money);
         	       }
         	     
        	    }

        	    var check_str="";
        	    var apply_str="";
        	    if(action=="2")
        	    {
        	    	check_str+="<td><a href='javascript:void(0)' class='checkall' style='margin:0 2px;'>全选</a><a href='javascript:void(0)' class='notcheckall' style='margin:0 2px;'>反选</a></td><td colspan='2'>总计：</td>";
                    apply_str="<td style='color:#FF3300;' class='total_money'>0.00</td>";
                }
        	    else
        	    {
        	    	check_str+="<td colspan='2'>总计：</td>";
        	    	apply_str="<td style='color:#FF3300;' class='total_money'>"+toDecimal2(amount_apply_total)+"</td>";
        	    }
        	    str +=     "<tr>"+check_str+"<td colspan='2'></td><td>"+toDecimal2(jiesuan_money_total)+"</td><td>"+toDecimal2(platform_fee_total)+"</td><td>"+toDecimal2(balance_money_total)+"</td>"+apply_str+"<td>"+toDecimal2(nopay_money_total)+"</td><td>"+toDecimal2(to_pay_money_total)+"</td><td colspan='5'></td></tr>";
        	    
        	    return str;
           
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


	
var init_bdhtml="";	
$(function(){
	object.init();
	init_bdhtml=$("#print_div").html();
  //审核通过按钮
    $("body").on("click",".btn_approve",function(){
    
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
    	   var list=[];
  	       $(".input_check").each(function(index,data){
  	    	     if($(this).is(':checked'))
  				 {
  					 var value=$(this).attr("data-id");
  					 list.push(value);
  				 }
  	    	  
  		      })
  		  
  		   if(list.length==0)  {tan('请勾选要通过的订单');return false;}
  		   
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_deal');?>";
	        var data={apply_id:id,reply:reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	        	//parent.$("#main")[0].contentWindow.window.location.reload();
	    		setTimeout(function(){t33_close_iframe_noreload();},200);

	    		//刷新页面
	    		 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("已通过");
    				 }
    	    	  
    		      })

    		      //去掉“审核”按钮
				var num=0;
	    		$(".input_check").each(function(index,data){
		    	     if($(this).hasClass('not-allow')==false)
					 {
		    	    	 num=num+1;
					 }
		    	  
			      })
				  if(num==0)
    		      parent.$("#main")[0].contentWindow.parentfun(id);//父级容器不刷新，做其他动作达到刷新效果
  		        //end
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });
    $("body").on("click","#btn_submit",function(){
  

		object.init();
		
	});
    //审核拒绝: 提交按钮
    $("body").on("click",".btn_refuse",function(){
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
    		 var list=[];
    	       $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 var value=$(this).attr("data-id");
    					 list.push(value);
    				 }
    	    	  
    		      })
    		  
    		 if(list.length==0)  {tan('请勾选要拒绝的订单');return false;}
    		   
	    	var refuse_reply=$("#reply").val();
	        if(refuse_reply=="") {tan('请填写审核意见');return false;}
	       
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_refuse');?>";
	        var data={apply_id:id,reply:refuse_reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	       
	        if(return_data.code=="2000")
	        {
	        	
	    		tan2(return_data.data);
	    		setTimeout(function(){t33_close_iframe_noreload();},200);
	            //刷新本页面
	    		 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("已拒绝");
    				 }
    	    	  
    		      })
	    		//刷新父级页面
	    		//去掉“审核”按钮
				var num=0;
	    		$(".input_check").each(function(index,data){
		    	     if($(this).hasClass('not-allow')==false)
					 {
		    	    	 num=num+1;
					 }
		    	  
			      })
				  if(num==0)
    		      parent.$("#main")[0].contentWindow.parentfun(id);//父级容器不刷新，做其他动作达到刷新效果
  		        //end
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
  
    	
    });
    //
    $(".input_check").click(function(){
		cal();
	})
	//打印
	$("body").on("click",".a_print",function(){
		var id=$(this).attr("data-id");
		/*window.top.openWin({
		  type: 2,
		  area: ['900px', "576px"],
		  title :"打印预览",
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/pay_print');?>"+"?id="+id
		});*/
		var win1 = window.open("<?php echo base_url('admin/t33/sys/approve/pay_print');?>"+"?id="+id,'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});
  //打印月结
	$("body").on("click",".a_print_month",function(){
		
		/*window.top.openWin({
		  type: 2,
		  area: ['900px', "576px"],
		  title :"打印预览",
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/pay_print');?>"+"?id="+id
		});*/
		var win1 = window.open("<?php echo base_url('admin/t33/sys/approve/pay_print_month');?>"+"/"+id+"/1",'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});
    //订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("data-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['80%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
		});
	});
	//详情：团号下面的所有订单
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
	    var title=id+"团号下的所有订单";
		window.top.openWin({
		  type: 2,
		  area: ['78%', '80%'],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/team_order');?>"+"/"+id
		});
	});
	//线路详情    on：用于绑定未创建内容
	$("body").on("click",".a_line",function(){
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
	//全选
	$("body").on("click",".checkall",function(){
	
	       $(".input_check").each(function(index,data){
	    	   if($(this).hasClass("not-allow")==false)
		       {
	    	   $(this).attr("checked",true);
		       }
		      })
          cal();
	});
	//反选
	$("body").on("click",".notcheckall",function(){
	
	       $(".input_check").each(function(index,data){

		       if($(this).hasClass("not-allow")==false)
		       {
	    	   if($(this).is(':checked'))
			   {
	    	       $(this).attr("checked",false);
			   }
	    	   else
	    	   {
	    		   $(this).attr("checked",true);
	    	   }
		       }
	    	  
		      })
         cal();
	});
    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $("body").on("click",".btn_close",function()
    {
        parent.layer.close(index);
    	
    });

});




function preview(oper)         
{  
	
	if (oper < 10)  
	{  
	$("#div_search").hide();
    $(".header_div").css("display","block");
    $(".footer_div").css("display","block");
    $("#page_div").hide();
	object.init2();
	bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
	sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域  
	eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域  
	prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)); //从开始代码向后取html  
	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html  

	window.document.body.innerHTML=prnhtml;  
	
	window.print();  
	

	//取消打印时恢复数据
	window.location.reload();

	//object.init();
	//$("body").append(init_bdhtml);
	
	} 
	else 
	{  
		window.print();  
	}  
} 

//导出excel
function drive(){
	 var team_code=$("#team_code").val();
     var productname=$("#productname").val();
     var price_start=$("#price_start").val();
     var price_end=$("#price_end").val();
     var commit_name=$("#commit_name").val();
     var id="<?php echo $id;?>";
     
      jQuery.ajax({ type : "POST",async:false, data :{payable_id:id,team_code:team_code,productname:productname,commit_name:commit_name,price_start:price_start,price_end:price_end},url : "<?php echo base_url()?>admin/t33/login/drive_excel_data", 
           success : function(result) {
                  var result = eval('(' + result + ')');
                  if(result.status==1){
                           window.location.href="<?php echo base_url()?>"+result.file;  
                  }else{
                          alert(result.msg);
                  }  
           }
     });

}

function drive2(){
	 var list=[];
    $(".input_check").each(function(index,data){
 	     if($(this).is(':checked'))
			 {
				 var value=$(this).attr("data-id");
				 list.push(value);
			 }
 	  
	      })
	  
	 if(list.length==0)  {tan('请勾选要导出的订单');return false;}
	 
    var id="<?php echo $id;?>";
     jQuery.ajax({ type : "POST",async:false, data :{list:list},url : "<?php echo base_url()?>admin/t33/login/t33_drive_excel", 
          success : function(result) {
                 var result = eval('(' + result + ')');
                 if(result.status==1){
                          window.location.href="<?php echo base_url()?>"+result.file;  
                 }else{
                         alert(result.msg);
                 }  
          }
    });

}

function cal()
{
	 var money=0;
     $(".input_check").each(function(index,data){
     if($(this).is(':checked'))
	 {
		 var value=$(this).attr("data-value");
		 money=object.accAdd(money,toDecimal2(value));
		
	   }	  
    })
     
      $(".total_money").html(money.toFixed(2));
}

</script>

</html>


