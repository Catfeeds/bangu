<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:24px;line-height:24px;background:#fff;float:left;width:80%;margin-bottom:5px;margin-top:0px;color:#000000;
}
.p_warp font{margin-right:50px;}

.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}


.not-allow{cursor:not-allowed !important;opacity:0.5;}

/**/
fieldset{margin-bottom:10px;border:1px solid #dcdcdc;}
.p_line{height:16px;line-height:16px;border-left:3px solid #000;padding-left:5px;margin:5px 0;font-weight:bold !important;}
.header_div{float:left;width:100%;border-bottom:2px solid #000;margin-bottom:5px;padding-bottom:5px;display:none;}
.header_div .p1{width:30%;float:left;}
.header_div .p2{width:40%;float:left;text-align:center;font-size:18px;font-weight:bold !important;}
.header_div .p3{width:30%;float:left;text-align:right;}

.footer_div{float:left;width:100%;margin-bottom:5px;margin-top:20px;display:none;}
.footer_div .p1,.footer_div .p2{width:75%;float:left;text-align:right;margin:10px 0;}
</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" style="padding-bottom: 0px;">
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
                    
                            <div class="search_form_box clear" style="padding-top: 4px;width:auto;">
                            
                                <div class="search_group">
                                    <label style="width:30px;">金额</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:70px;" /> 至 <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:70px;" />
                                    
                                </div>
                                <div class="search_group">
                                    <label style="width:30px;">团号</label>
                                    <input type="text" id="team_code" name="" class="search_input" placeholder="" style="width:120px;"/>
                                </div>
                                <div class="search_group">
                                    <label style="width:60px;">产品名称</label>
                                    <input type="text" id="productname" name="" class="search_input" placeholder="" style="width:150px;"/>
                                </div>
                               <div class="search_group">
                                    <label style="width:40px;">申请人</label>
                                    <input type="text" id="expert_name" name="" class="search_input" placeholder="" style="width:120px;"/>
                                </div>
                                      
                 
                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                              
                              
                                
                            </div>
                      
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                	<th></th>
                                    <th>订单号</th>
                                    <th>申请金额</th>
                                    <th>申请比例</th>
                                   
                                    <th>产品名称</th>
                                    <th>出团日期</th>
                                    <th>订单成本</th>
                                    <th>结算价</th>
                                    <th>已结算</th>
                                    <th>未结算</th>
                                    <th>已结算比例</th>
                                    <th>平台佣金</th>
                                    <th>结算方式</th>
                                    <th>团号</th>
                                    <th>销售员</th>
                                    <th>销售部门</th>
                                    <th>审核状态</th>
                                  
                                   <!--  <th>操作</th> -->
                                </tr>
                            </thead>
                            <tbody class="data_rows">
                            <!--  <tr>
                                    <td style="text-align:left"> <a target="_blank" href="http://localhost/admin/b2/line_apply/line_detial_apply?id=673">海外技术部马尔代夫欢乐岛Fun</a></td>
                                    <td>
                                                                                           中国
                                    </td>
                                    <td>深圳市</td>
                                    <td>1%</td>
                                    <td>深圳海外国际技术部</td> 
                                    <td>1%</td>
                                    <td>深圳海外国际技术部</td> 
                                    <td>
                                    <a href="javascript:void(0)">修改</a>
                                    <a href="javascript:void(0)">停用</a>
                                    <a href="javascript:void(0)">启用</a>
                                    </td>
                                </tr>--> 
      
                            </tbody>
                        </table>
                          <!-- 暂无数据 -->
                        <div class="no-data" style="display:none;height:50px;line-height:50px;">木有数据哟！换个条件试试</div>
                        
                        <p class="p_total">总计：<font style="color:#FF6600;" class="total_money"><?php echo isset($row['amount'])==true?$row['amount']:"";?></font>元</p>
                         <div id="page_div" style="background: #fff;text-align:right;display:none;"></div>
                      
                        <!-- 审核 -->
                       
                        <div class="fb-form" style="width:100%;overflow:hidden;">
	                        
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					         <?php if(!empty($pics)):?>
					         <div class="form-group" style="width:100%;float:left;margin:1px 10px !important;">
						                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">流水单</div>
						                <div class="fg-input" style="width:84%;float:left;">
						                
						                    <?php foreach ($pics as $k=>$v):?>
						                    <div style="margin-right: 20px;float:left;">
						                      <a href="javascript:void(0)" data-id="<?php echo $v['pic'];?>" class="a_pic"><img src="<?php echo base_url().$v['pic'];?>" style="height: 80px;float:left;" /></a><a href="javascript:void(0)" data-id="<?php echo $v['pic'];?>" class="a_pic" style="margin-top:50px;margin-left:2px;float:left;">大图</a>
						                    </div>
						                    <?php endforeach;?>
						                 
						                </div>
						            </div>
						    <?php endif;?>
						    <?php if($action=="2"):?>
					           <div class="form-group" style="width:100%;float:left;margin:1px 10px !important;">
					                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">流水单：</div>
					                <div class="fg-input" style="width:84%;float:left;">
					                   <input name="uploadFile" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    			       <input name="pic" id="code_pic" type="hidden" value="">
					                </div>
					            </div>
					            
					            <div class="form-group" style="width:100%;float:left;margin:1px 10px !important;">
					                <div class="fg-title" style="width:8% !important;;float:left;text-align:left;">审核意见：</div>
					                <div class="fg-input" style="width:84%;float:left;">
					                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:34px;width:90%;padding:5px;"></textarea>
					               
					                </div>
					            </div>
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <input type="button" class="fg-but btn_two btn_refuse" value="拒绝">
					                 <input type="button" class="fg-but btn_one btn_approve" style="background:#da411f;" value="通过">
					                
					                </div>
					            </div>
					           <?php endif;?>
					           <!-- 退回 -->
					            <?php if($action=="3"):?>
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <input type="button" class="fg-but btn_one btn_back" style="background:#da411f;" value="退回">
					              
					                </div>
					            </div>
					           <?php endif;?>
					           
					           
					        </form>
					    </div>
					    
					   <!-- 审核结束 -->
                     
                    </div>                   
                </div>
               
            </div>

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

    var id="<?php echo $id;?>";
    var shenhe_status="<?php if($row['status']=="1") echo "待付款";else if($row['status']=="3") echo "已付款";else if($row['status']=="4") echo "已拒绝";?>";
   
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
        	  var team_code=$("#team_code").val();
              var productname=$("#productname").val();
              var price_start=$("#price_start").val();
              var price_end=$("#price_end").val();
              var expert_name=$("#expert_name").val();

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_pay_order')?>";
        	ajax_data={page:"1",id:id,team_code:team_code,productname:productname,expert_name:expert_name,price_start:price_start,price_end:price_end};
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

		        	//写html内容
		        	if(return_data.code=="2000")
		        	{
			        	var action="<?php echo $action;?>";  //2是审核，对应pageData；3是退回，对应pageData2 
			        	if(action=="2"||action=="1")
	                	     html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
			        	else if(action=="3")
			        		 html=object.pageData2(ret.curr,return_data.data.page_size,return_data.data.result);
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
        	    var amount_apply_total=jiesuan_money_total=balance_money_total=nopay_money_total=platform_fee_total=supplier_cost_total=0;
        	    for(var i = 0; i <= last; i++)
        	    {
                    var no=i+1;
        	        str += "<tr>";

        	        var class_str="";
        	        var disabled_str="";
        	        if(data[i].status!="2")
        	        {
        	        class_str="not-allow";
        	        disabled_str="disabled";
        	        }
        	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-id='"+data[i].id+"' />";
        	        
        	        str +=     "<td>"+input_str+"</td>"; //checkbox
        	        
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].ordersn+"</a></td>";
         	       
        	        str +=     "<td  style='color:#FF3300;'>"+data[i].amount_apply+"</td>";
        	        str +=     "<td>"+data[i].apply_percent+"</td>";
        	        str +=     "<td>"+data[i].productname+"</td>";
        	       
        	        str +=     "<td>"+data[i].usedate+"</td>";
        	        str +=     "<td>"+data[i].supplier_cost+"</td>";
        	        str +=     "<td>"+data[i].jiesuan_money+"</td>";
        	        str +=     "<td>"+data[i].balance_money+"</td>";
        	        str +=     "<td>"+data[i].nopay_money+"</td>";
        	        str +=     "<td>"+data[i].pay_percent+"</td>";
        	        str +=     "<td style='color:#e8831b;'>"+data[i].platform_fee+"</td>";
        	        
        	        var pay_way="<?php if($row['pay_way']=="0") echo "现金";else echo "转账";?>"; 
        	        str +=     "<td>"+pay_way+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].item_code+"'>"+data[i].item_code+"</a></td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        
        	        var shenhe_status="";
        	        if(data[i].status=="1")
        	        	shenhe_status="待提交";
        	        else if(data[i].status=="2")
        	        	shenhe_status="待付款";
        	        else if(data[i].status=="4")
        	        	shenhe_status="已付款";
        	        else if(data[i].status=="5"||data[i].status=="3")
        	        	shenhe_status="已拒绝";
        	        str +=     "<td class='td_status'>"+shenhe_status+"</td>";
        	      
         	       str += "</tr>";
         	   
         	      if(data[i].status=="4")
        	       {
           	    
	        	      amount_apply_total=object.accAdd(amount_apply_total,data[i].amount_apply);
	        	      jiesuan_money_total=object.accAdd(jiesuan_money_total,data[i].jiesuan_money);
	        	      balance_money_total=object.accAdd(balance_money_total,data[i].balance_money);
	        	      nopay_money_total=object.accAdd(nopay_money_total,data[i].nopay_money);
	        	      platform_fee_total=object.accAdd(platform_fee_total,data[i].platform_fee);
	        	     supplier_cost_total=object.accAdd(supplier_cost_total,data[i].supplier_cost);
        	       }
       	       
        	    }
        	    str +=     "<tr><td><a href='javascript:void(0)' class='checkall'>全选</a><a href='javascript:void(0)' class='notcheckall'>反选</a></td><td>总计：</td><td>"+amount_apply_total+"</td><td colspan='3'></td><td>"+supplier_cost_total+"</td><td>"+jiesuan_money_total+"</td><td>"+balance_money_total+"</td><td>"+nopay_money_total+"</td><td></td><td style='color:#e8831b;'>"+platform_fee_total+"</td><td colspan='5'></td></tr>";
        	    
        	    return str;
           
        },
        pageData2:function(curr,page_size,data){  //生成表格数据
        	
	 		var str = '', last = curr*page_size - 1;
    	    last = last >= data.length ? (data.length-1) : last;
    	    var amount_apply_total=jiesuan_money_total=balance_money_total=nopay_money_total=platform_fee_total=supplier_cost_total=0;
    	    for(var i = 0; i <= last; i++)
    	    {
                var no=i+1;
    	        str += "<tr>";

    	        var class_str="";
    	        var disabled_str="";
    	        if(data[i].status=="1")
    	        {
    	        class_str="not-allow";
    	        disabled_str="disabled";
    	        }
    	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-id='"+data[i].id+"' />";
    	        
    	        str +=     "<td>"+input_str+"</td>"; //checkbox
    	        
    	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].ordersn+"</a></td>";
     	       
    	        str +=     "<td  style='color:#FF3300;'>"+data[i].amount_apply+"</td>";
    	        str +=     "<td>"+data[i].apply_percent+"</td>";
    	        str +=     "<td>"+data[i].productname+"</td>";
    	       
    	        str +=     "<td>"+data[i].usedate+"</td>";
    	        str +=     "<td>"+data[i].supplier_cost+"</td>";
    	        str +=     "<td>"+data[i].jiesuan_money+"</td>";
    	        str +=     "<td>"+data[i].balance_money+"</td>";
    	        str +=     "<td>"+data[i].nopay_money+"</td>";
    	        str +=     "<td>"+data[i].pay_percent+"</td>";
    	        str +=     "<td style='color:#e8831b;'>"+data[i].platform_fee+"</td>";
    	        
    	        var pay_way="<?php if($row['pay_way']=="0") echo "现金";else echo "转账";?>"; 
    	        str +=     "<td>"+pay_way+"</td>";
    	        str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].item_code+"'>"+data[i].item_code+"</a></td>";
    	        str +=     "<td>"+data[i].expert_name+"</td>";
    	        str +=     "<td>"+data[i].depart_name+"</td>";
    	        
    	        var shenhe_status="";
    	        if(data[i].status=="1")
    	        	shenhe_status="待提交";
    	        else if(data[i].status=="2")
    	        	shenhe_status="待付款";
    	        else if(data[i].status=="4")
    	        	shenhe_status="已付款";
    	        else if(data[i].status=="5"||data[i].status=="3")
    	        	shenhe_status="已拒绝";
    	        str +=     "<td class='td_status'>"+shenhe_status+"</td>";
    	      
     	       str += "</tr>";
     	   
     	      if(data[i].status=="4")
    	       {
       	    
        	      amount_apply_total=object.accAdd(amount_apply_total,data[i].amount_apply);
        	      jiesuan_money_total=object.accAdd(jiesuan_money_total,data[i].jiesuan_money);
        	      balance_money_total=object.accAdd(balance_money_total,data[i].balance_money);
        	      nopay_money_total=object.accAdd(nopay_money_total,data[i].nopay_money);
        	      platform_fee_total=object.accAdd(platform_fee_total,data[i].platform_fee);
        	     supplier_cost_total=object.accAdd(supplier_cost_total,data[i].supplier_cost);
    	       }
   	       
    	    }
    	    str +=     "<tr><td><a href='javascript:void(0)' class='checkall'>全选</a><a href='javascript:void(0)' class='notcheckall'>反选</a></td><td>总计：</td><td>"+amount_apply_total+"</td><td colspan='3'></td><td>"+supplier_cost_total+"</td><td>"+jiesuan_money_total+"</td><td>"+balance_money_total+"</td><td>"+nopay_money_total+"</td><td></td><td style='color:#e8831b;'>"+platform_fee_total+"</td><td colspan='5'></td></tr>";
    	    
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

	
$(function(){
	object.init();
	
  //退回按钮
    $("body").on("click",".btn_back",function(){
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
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage_back');?>";
	        var data={apply_id:id,reply:reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	      
	        if(return_data.code=="2000")
	        {
	        	tan2(return_data.data);
	        	setTimeout(function(){t33_close_iframe_noreload();},200);
	    		//刷新页面
	    		 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("待提交");
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
    		      parent.$("#main")[0].contentWindow.parentfun2(id);//父级容器不刷新，做其他动作达到刷新效果
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
    	
    });
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
    		  
    		if(list.length==0)  {tan('请勾选要退回的订单');return false;}
            var code_pic=$("#code_pic").val();
       		
	    	var reply=$("#reply").val();
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage_deal');?>";
	        var data={apply_id:id,reply:reply,list:list,pic:code_pic};
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
    					 $(this).parent().parent().find(".td_status").html("已付款");
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
	       
	        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage_refuse');?>";
	        var data={apply_id:id,reply:refuse_reply,list:list};
	        var return_data=object.send_ajax_noload(url,data);
	      
	        if(return_data.code=="2000")
	        {
	        	
	    		tan2(return_data.data);
	    		//setTimeout(function(){t33_close_iframe();},200);
	    		
				//刷本新页面
	    		 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("已拒绝");
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
    //大图
    $("body").on("click",".a_pic",function(){
    	var a_img=$(this).attr("data-id");
    	var bangu_url="<?php echo base_url() ?>";
    	
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
	//全选
	$("body").on("click",".checkall",function(){
	
	       $(".input_check").each(function(index,data){
	    	   if($(this).hasClass("not-allow")==false)
		       {
	    	   $(this).attr("checked",true);
		       }
		      })

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

	});
    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $('.btn_close').click(function()
    {
         parent.layer.close(index);
    });

});



</script>
</html>


