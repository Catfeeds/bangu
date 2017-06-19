<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:0px;color:#000000;
}
.p_total{
height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:8px;font-weight:bold !important;
}

.p_expert{height:24px;line-height:24px;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:15px;
}
.p_expert font{margin-right:20%;}

.not-allow{cursor:not-allowed !important;opacity:0.5;}
</style>

</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>


<!--=================右侧内容区================= -->
    <div class="page-body-detail" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" style="padding-bottom: 0px !important;">
                  
                    <div class="content_part">
		              
		                 <table class="order_info_table table_td_border" border="1" width="80%" cellspacing="0">
		                     <tr height="40">
		                        <td class="order_info_title">线路名称:</td>
		                        <td colspan="7"><a href="javascript:void(0)" class="a_line" line-id="<?php echo $row['lineid'];?>" line-name="<?php echo $row['linename'];?>"><?php echo $row['linename'];?></a></td>
		                    </tr>
		                    <tr height="40">
		                       <td class="order_info_title">出团日期:</td>
		                       <td><?php echo $row['day'];?></td>
		                       <td class="order_info_title">人数:</td>
		                       <td><?php echo empty($row['total_people'])==true?'0':$row['total_people'];?></td>
		                       <td class="order_info_title">佣金:</td>
		                       <td><?php echo empty($row['total_platform_fee'])==true?'0':$row['total_platform_fee'];?></td>
		                       <td class="order_info_title">保险金额:</td>
		                       <td><?php echo empty($row['total_settlement_price'])==true?'0':$row['total_settlement_price'];?></td>
		                    </tr>
		                     <tr height="40">
		                       <td class="order_info_title">总金额:</td>
		                       <td><?php echo empty($row['total_money'])==true?'0':$row['total_money'];?></td>
		                       <td class="order_info_title">已交款:</td>
		                       <td><?php echo empty($row['total_receive_price'])==true?'0':$row['total_receive_price'];?></td>
		                       <td class="order_info_title">结算价:</td>
		                       <td><?php echo empty($row['total_supplier_cost'])==true?'0':$row['total_supplier_cost'];?></td>
		                       <td class="order_info_title">已结算:</td>
		                       <td><?php echo empty($row['total_balance_money'])==true?'0':$row['total_balance_money'];?>&nbsp;（
		                       <?php 
		                        $m=empty($row['total_balance_money'])==true?0:$row['total_balance_money'];
		                        $n=empty($row['total_jiesuan_money'])==true?0:$row['total_jiesuan_money'];
		                        if($n==0)
		                        {
		                        	  echo "0%";
		                        }
		                        else 
		                        {
		                      		 echo (round(($m/$n),4)*100).'%';
		                        }
		                       ?>
		                                                        ）</td>
		                    </tr>
		                   
		                   
		                </table>
		            </div>
                    <!-- 使用明细 -->
                    <div class="table_list">
                       
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th></th>
                                    <th>订单编号</th>
                                    <th>出团日期</th>
                                    <th>参团人数</th>
                                    <th>行程天数</th>
                                   
                                    <th>订单金额</th>
                                    <th>已收款</th>
                                    <th>结算价</th>
                                    <th>已结算</th>
                                    <th>操作费</th>
                                    <th>未结算</th>
                                    <th>保险金额</th>
                                    <th>销售部门</th>
                                    <th>销售员</th>
                                    <th>下单时间</th>
                                    <th>是否可以核算</th>
                                    <th>核算状态</th>
                                  
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
                        
                        <div class="div_submit" style="float: left;width:100%;margin:0 0 10px 0;display:none;">
		                <a href='javascript:void(0)' class="checkall" style='float:left;margin:8px 10px 0 0px;'>全选</a>
		                <a href='javascript:void(0)' class="notcheckall" style='float:left;margin:8px 20px 0 0px;'>反选</a>
		                
		               </div>
                         <div id="page_div" style="background: #fff;text-align:right;display:none;padding:0;margin-top:10px;"></div>
                      
                       
                     
                    </div>                   
                </div>
                
                                <div class="fb-form" style="width:100%;overflow:hidden;">
					              <form method="post" action="#" id="add-data" class="form-horizontal">
					           
					           
					               <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:8px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                <?php if($row['calculation']=="1"):?>
					                  <input type="button" class="fg-but btn_one btn_check" data-id="0" style="background:#da411f;" value="撤销核算">
					                 <?php else:?>
					                  <input type="button" class="fg-but btn_one btn_check" data-id="1" style="background:#da411f;" value="核算">
					                <?php endif; ?>
					                 
					                </div>
					                </div>
					                </form>
					            </div>
            </div>

        </div>
        
    </div>



<script type="text/javascript">

    var id="<?php echo $id;?>";  //团号
    var action="<?php echo $action;?>"; //1是核算、2是撤销核算
  	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var ordersn=$("#ordersn").val();
            var productname=$("#productname").val();

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/order/api_team_order')?>";
        	ajax_data={page:"1",team_id:id};
        	var list_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var total_page=list_data.data.total_page; //总页数
        	if(total_page>1)
            	$("#page_div").css("display","block");
        	else
        		$("#page_div").css("display","none");
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
		        		return_data=object.send_ajax_noload(post_url,ajax_data);
			        }

		        	//写html内容
		        	if(return_data.code=="2000")
		        	{
	                	html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
	                	$(".div_submit").css("display","block");
	                	$(".no-data").hide();
		        	}
		        	else if(return_data.code=="4001")
		        	{
			        	html="";
			        	$(".div_submit").css("display","none");
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
        	    for(var i = 0; i <= last; i++)
        	    {
        	    	str += "<tr>";

        	    	var class_str="";
         	        var disabled_str="";
         	        if(action=="1")
         	        {
	         	        if(data[i].yf_lock=="1"&&data[i].ys_lock=="1"&&data[i].yj_lock=="1"&&data[i].bx_lock=="1")
	         	        {
	         	        class_str="not-allow";
	         	        disabled_str="disabled";
	         	        }
         	        }
         	        else if(action=="2")
         	        {
         	        	if(data[i].yf_lock=="0"||data[i].ys_lock=="0"||data[i].yj_lock=="0"||data[i].bx_lock=="0")
 	         	        {
 	         	        class_str="not-allow";
 	         	        disabled_str="disabled";
 	         	        }
         	        }
         	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-id='"+data[i].id+"' />";
         	        
         	        str +=     "<td>"+input_str+"</td>"; 
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' order-id='"+data[i].id+"'>"+data[i].ordersn+"</a></td>";
         	        str +=     "<td>"+data[i].usedate+"</td>"; 
          	        str +=     "<td>"+data[i].total_people+"</td>"; 
         	        str +=     "<td>"+data[i].lineday+"</td>";
         	       
        	        str +=     "<td>"+toDecimal2(data[i].total_money)+"</td>"; //订单金额+保险
        	        str +=     "<td>"+(data[i].receive_price==""?'0.00':toDecimal2(data[i].receive_price))+"</td>"; //已收款
        	        str +=     "<td>"+toDecimal2(data[i].supplier_cost)+"</td>";  //结算价=供应商成本-平台佣金
        	        str +=     "<td>"+toDecimal2(data[i].balance_money)+"</td>";  //已结算
        	        str +=     "<td>"+toDecimal2(data[i].all_platform_fee)+"</td>";  //平台佣金
        	        str +=     "<td>"+toDecimal2(data[i].nopay_money)+"</td>";  //未结算
        	        str +=     "<td>"+toDecimal2(data[i].settlement_price)+"</td>";  //保险
        	       
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td>"+data[i].expertname+"</td>";
        	       
        	        str +=     "<td>"+data[i].addtime+"</td>";

        	        var cando_str="";
        	        if(data[i].yf_no_approve=="0"&&data[i].yj_no_approve=="0"&&data[i].ys_no_approve=="0")
        	        {
        	        	cando_str="是";
        	        	str +=     "<td class='td_status'>"+cando_str+"</td>";
        	        }
        	        else
        	        {
        	        	cando_str="否";
        	        	str +=     "<td style='color:red;'>"+cando_str+"</td>";
        	        }
        	        

        	        var status_str="未核算";
        	        if(data[i].yf_lock=="1"&&data[i].ys_lock=="1"&&data[i].yj_lock=="1"&&data[i].bx_lock=="1")
        	        	status_str="已核算";
        	        str +=     "<td class='td_status'>"+status_str+"</td>";
        	      
                   
        	       str += "</tr>";
        	    }
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
 
      }
      //object  end
    };

	
$(function(){
	object.init();
	
  //审核通过按钮
    $("body").on("click",".btn_check",function(){
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
		  
		if(list.length==0)  {tan('请勾选要核算的订单');return false;}
			
    	var action=$(this).attr("data-id");
        var url="<?php echo base_url('admin/t33/sys/order/do_check');?>";
        var data={team_code:id,list:list,action:action};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	tan2(return_data.data);
        	parent.$("#main")[0].contentWindow.window.location.reload();
    		//setTimeout(function(){t33_close_iframe();},200);

    		//刷新页面
	    		 $(".input_check").each(function(index,data){
    	    	     if($(this).is(':checked'))
    				 {
    					 $(this).addClass("not-allow");
    					 $(this).attr("disabled",true);
    					 $(this).attr("checked",false);
    					 $(this).parent().parent().find(".td_status").html("已核算");
    				 }
    	    	  
    		      })
        }
        else
        {
            tan(return_data.msg);
        }
    	}
    	
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
    //订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("order-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['70%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
		});
	});
	//全选
	$("body").on("click",".checkall",function(){
	
	       $(".input_check").each(function(index,data){
		       if($(this).hasClass('not-allow')==false)
		       {
	    	   $(this).attr("checked",true);
		       }
	    	  
		      })

	});
	//反选
	$("body").on("click",".notcheckall",function(){
	
	       $(".input_check").each(function(index,data){
	    	   if($(this).hasClass('not-allow')==false)
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


