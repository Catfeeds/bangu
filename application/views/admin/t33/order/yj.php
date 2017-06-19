<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}


.not-allow{cursor:not-allowed !important;opacity:0.5;}

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>财务管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">操作费结算</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-value="-1"> 
                        <li static="-1"><a href="#tab1" class="active">未结算</a></li>
                        <li static="0"><a href="#tab1">申请中</a></li> 
                        <li static="1"><a href="#tab1">已通过</a></li> 
                        <li static="2"><a href="#tab1">已拒绝</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                            	
                                <div class="search_group" style="margin-right: 10px;">
                                    <label style="width:60px;">订单编号：</label>
                                    <input type="text" id="ordersn" name="" class="search_input" style="width:90px;" />
                                </div>
                               <div class="search_group" style="margin-right: 10px;">
                                    <label style="width:60px;">产品名称：</label>
                                    <input type="text" id="productname" name="" class="search_input" style="width:90px;" />
                                </div>
                                <div class="search_group" style="margin-right: 10px;">
                                    <label style="width:60px;">出团日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:76px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:76px;">
                                </div>
                                 <div class="search_group" style="margin-right: 10px;">
                                    <label style="width:40px;">团号：</label>
                                    <input type="text" id="item_code" name="" class="search_input" style="width:90px;" />
                                </div>
                                
              
                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin-right: 0px;">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" style="margin-left:10px;" value="搜索"/>
                                </div>
                               
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr class="tr_th">
                                    <th></th>
                                    <th>平台佣金+外交佣金</th>
                               		<th>可结算佣金</th>
                               		<th>已结算佣金</th>
                                    <th>订单编号</th>
                                  
                                    <th>产品名称</th>
                                    <th>出团日期</th>
                                   
                                    <th>订单金额</th>
                                   
                                    <th>结算金额</th>
                                    <th>已结算</th>
                                    <th>未结算</th>
                                    <th>团号</th>
                                    <th>结算状态</th>
                                   
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
                        <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
                    </div>                   
                </div>
            
                <div class="div_submit" style="float: left;width:100%;margin-bottom:10px;">
                 <a href='javascript:void(0)' class="checkall" style='float:left;margin:8px 10px 0 0px;'>全选</a>
		         <a href='javascript:void(0)' class="notcheckall" style='float:left;margin:8px 20px 0 0px;'>反选</a>
		         <span class="btn_apply btn btn_green" style="margin:0px 20px 0 0px;float:left;">提交结算</span>
                <p style="width:20%;float:left;height:30px;line-height:30px;">申请结算金额总计：<span style="color:#ff0000;" class="total_price">0</span> 元</p>
                </div>
                <div id="page_div" style="text-align:right;"></div>
                
            </div>

        </div>
        
    </div>
   
   <!--   弹层 -->
 <div class="fb-content" id="choose_depart" style="display:none;/*height:350px;*/">
    <div class="box-title">
        <h5>申请结算佣金</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin-top:60px;">
           		 <div class="fg-title" style="width:80% !important;margin-left:10px;text-align:left;">申请时间：<font class="addtime" style="margin-left:15px;">2323</font></div>
                
                 <div class="fg-title" style="width:80% !important;margin-left:10px;text-align:left;margin-top:5px;">佣金总计：<font class="total_price" style="margin-left:15px;color:#ff0000;">0</font></div>
               
                <div class="fg-title" style="width:20%;margin-top:5px;">备注：<i>*</i></div>
                <div class="fg-input" style="width:73%;margin-top:5px;">
                <textarea name="beizhu" id="reply" maxlength="30" placeholder="" style="height:160px;width:100%;padding:5px;"></textarea>
                </div>
            </div>
        
            <div class="form-group" style="margin-top:120px;">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_approve" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
   

<script type="text/javascript">

	type_value="-1";//类型：默认-1未结算，0申请中，1已通过、2已拒绝  
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var productname=$("#productname").val();
            var ordersn=$("#ordersn").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var item_code=$("#item_code").val();

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/order/api_yj')?>";
            ajax_data={page:"1",type_value:type_value,productname:productname,ordersn:ordersn,starttime:starttime,endtime:endtime,item_code:item_code};

            var list_data;
        	var total_page;
        	if(flag==true)
        	{
        	    list_data=object.send_ajax(post_url,ajax_data);  //数据结果
        	    total_page=list_data.data.total_page; //总页数
        	}
        	
        
        	//调用分页
        	laypage({
        	    cont: 'page_div',
        	    pages: total_page,
        	    jump: function(ret){

        	    	var html="";  //html内容
		        	ajax_data.page=ret.curr; //页数
		        	var return_data=null;  //数据
		        	if(ret.curr==1&&flag==true)
		        	{
		        		return_data=list_data;
		        	}
		        	else
		        	{
		        		return_data=object.send_ajax(post_url,ajax_data);
			        }
			        
                    if(type_value=="-1")
                       $(".tr_th").html("<th></th><th>平台佣金+外交佣金</th><th>可结算佣金</th><th>已结算佣金</th><th>订单编号</th><th>产品名称</th><th>出团日期</th> <th>订单金额</th><th>结算价</th><th>已结算</th><th>操作费</th><th>未结算</th><th>团号</th>");
                    else
                        $(".tr_th").html("<th>本次结算佣金</th><th>已结算佣金</th><th>订单编号</th><th>产品名称</th><th>出团日期</th> <th>订单金额</th><th>结算价</th><th>已结算</th><th>操作费</th><th>未结算</th><th>团号</th><th>状态</th>");
		        	//写html内容
		        	if(return_data.code=="2000")
		        	{
			        	if(type_value=="-2"||type_value=="-1")
		        			$(".div_submit").show();
			        	else
			        		$(".div_submit").hide();
	                	html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
	                	$(".no-data").hide();
		        	}
		        	else if(return_data.code=="4001")
		        	{
			        	html="";
			        	$(".div_submit").hide();
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
        	flag=false;
            //end
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {
                  
        	        str += "<tr>";
        	        var class_str="";
        	        var disabled_str="";
        	       /*  if(data[i].apply_status!="")
        	        {
        	        class_str="not-allow";
        	        disabled_str="disabled";
        	        } */
        	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-value='"+data[i].platform_fee_jiesuan+"' order-id='"+data[i].id+"' />";

        	        if(type_value=="-1")
        	        {
        	        str +=     "<td>"+input_str+"</td>"; //checkbox
        	        str +=     "<td>"+data[i].all_platform_fee+"</td>";  //总佣金
        	        }

        	        if(type_value=="-1")
        	        {
        	            str +=     "<td style='color:#FF3300;'>"+data[i].platform_fee_jiesuan+"</td>";  //可结算佣金
        	        }
        	        else
        	        {
        	        	 str +=     "<td style='color:#FF3300;'>"+data[i].apply_money+"</td>";  //本次结算金额
            	    }
        	         
        	        str +=     "<td>"+data[i].union_balance+"</td>";  //已结算佣金
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' order-id='"+data[i].id+"'>"+data[i].ordersn+"</a></td>";
        	      
         	        str +=     "<td class='td_long'><a href='javascript:void(0)' onclick='show_line_detail("+data[i].productautoid+",2)' line-id='"+data[i].productautoid+"' line-name='"+data[i].productname+"'>"+data[i].productname+"</a></td>";
         	        str +=     "<td>"+data[i].usedate+"</td>"; 
      
         	       
        	        str +=     "<td>"+data[i].total_price+"</td>"; //订单金额
       
        	        str +=     "<td>"+data[i].jiesuan_money+"</td>";  //结算价=供应商成本-平台佣金
        	        str +=     "<td>"+data[i].balance_money+"</td>";  //已结算
        	        str +=     "<td>"+data[i].all_platform_fee+"</td>";  //未结算
        	        str +=     "<td>"+data[i].nopay_money+"</td>";  //未结算

  
        	        str +=     "<td>"+data[i].item_code+"</td>";

        	        if(type_value!="-1")
        	        {
	        	        var status_str="";
	        	        if(data[i].apply_status=="0")
	        	        	status_str="申请中";
	        	        else if(data[i].apply_status=="1")
	        	        	status_str="已通过";
	        	        else if(data[i].apply_status=="2")
	        	        	status_str="已拒绝";
	        	        str +=     "<td class='td_status'>"+status_str+"</td>";
        	        }
                  
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

	$(".itab ul li").click(function(){
		var value=$(this).attr("static");
		type_value=value;
		$(".itab").attr("data-value",value);
		flag=true;
		object.init();
	})
   
   $("#btn_submit").click(function(){
	   flag=true;
	   object.init();
	})
	//日历控件
	$('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//日历控件
	$('#endtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	
	//线路详情    on：用于绑定未创建内容
	/*$("body").on("click",".a_line",function(){
		var line_id=$(this).attr("line-id");
		var line_name=$(this).attr("line-name");
		window.top.openWin({
		  title:line_name,
		  type: 2,
		  area: ['1000px', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php //echo base_url('admin/t33/sys/line/detail');?>"+"?id="+line_id
		});
	});*/
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
		      cal();
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
		      cal();
	});
	//结算：checkbox
   $("body").on("click",".input_check",function(){
	   cal();
   });
   function cal()
   {
	   var total=0;
	   $(".input_check").each(function(index,data){
	    	     if($(this).is(':checked'))
				 {
					 var value=$(this).attr("data-value");
					 total+=parseFloat(value);
				 }
	    	  
		      })
		  $(".total_price").html(total);
    }
   //弹窗
   $("body").on("click",".btn_apply",function(){
	   var list=[];
       $(".input_check").each(function(index,data){
    	     if($(this).is(':checked'))
			 {
				 var value=$(this).attr("data-value");
				 list.push(value);
			 }
    	  
	      })
	  
	   if(list.length==0)  {tan('请选择要申请结算的订单');return false;}
	   
	   var addtime=CurentTime();
	   $(".addtime").html(addtime);
	   layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '500px',
			  //skin: 'layui-layer-nobg', //没有背景色
			  shadeClose: false,
			  content: $('#choose_depart')
			});
	});
	 //审核通过按钮
	   $("body").on("click",".btn_approve",function(){
		   var flag = COM.repeat('btn');//频率限制
	       if(!flag)
	        {
	           var list=[];
	           $(".input_check:checked").each(function(index,data){
		    	     if($(this).is(':checked'))
					 {
						 var order_id=$(this).attr("order-id");
						 var money=$(this).attr("data-value");
						 //list.push(order_id);
						 list[index]={
	                          'order_id':order_id,
	                          'money':money
							};
					 }
		    	  
			      }) 
			   var reply=$("#reply").val();
		   	   //if(reply=="")  {tan('请填写备注');return false;}
			      
		       var url="<?php echo base_url('admin/t33/sys/order/api_submit_yj');?>";
		       var data={list:list,reply:reply};
		       var return_data=object.send_ajax_noload(url,data);
		       if(return_data.code=="2000")
		       {
		       	tan2(return_data.data);
		        //关闭层
		   		setTimeout(function(){	layer.closeAll();},500);
		       	 $(".input_check").each(function(index,data){
	    	    	     if($(this).is(':checked'))
	    				 {
	    					 $(this).addClass("not-allow");
	    					 $(this).attr("disabled",true);
	    					 $(this).attr("checked",false);
	    					 $(this).parent().parent().find(".td_status").html("已提交");
	    				 }
	    	    	  
	    		      })
		
		   		//刷新页面
		   		
		       }
		       else
		       {
		           tan(return_data.msg);
		       }
	    	}
	   });

	   //end

});

function CurentTime()
{ 
    var now = new Date();
   
    var year = now.getFullYear();       //年
    var month = now.getMonth() + 1;     //月
    var day = now.getDate();            //日
   
    var hh = now.getHours();            //时
    var mm = now.getMinutes();          //分
   
    var clock = year + "-";
   
    if(month < 10)
        clock += "0";
   
    clock += month + "-";
   
    if(day < 10)
        clock += "0";
       
    clock += day + " ";
   
    if(hh < 10)
        clock += "0";
       
    clock += hh + ":";
    if (mm < 10) clock += '0'; 
    clock += mm; 
    return(clock); 
} 

//线路详情 
function show_line_detail(line_id,type){
	var line_id=line_id;
	layer.open({
		title:'线路详情',
		type: 2,
		area: ['1200px', '80%'],
		fix: false, //不固定
		maxmin: true,
		content: "<?php echo base_url('common/line/show_line_detail');?>"+"?id="+line_id+"&type="+type
	});	
}
</script>
</html>


