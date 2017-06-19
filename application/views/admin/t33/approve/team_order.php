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
               
                <div class="tab_content" style="padding-bottom: 0px;">
                  
                    <p class="p_warp">备注：<?php echo isset($row['remark'])==true?$row['remark']:"";?></p>
                    <!-- 使用明细 -->
                    <div class="table_list">
                       
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>订单编号</th>
                                    <th>团号</th>
                                    <th>产品名称</th>
                                    <th>出团日期</th>
                                    <th>参团人数</th>
                                    <th>行程天数</th>
                                    
                                    <th>订单金额</th>
                                    <th>已收款</th>
                                    <th>结算价</th>
                                    <th>已结算</th>
                                    <th>操作费</th>
                                    <th>未结算</th>
                                    <th>销售部门</th>
                                    <th>销售员</th>
                                    <th>下单时间</th>
                                    
                                  
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
                        
                       
                         <div id="page_div" style="background: #fff;text-align:right;"></div>
                      
                       
                     
                    </div>                   
                </div>
               
            </div>

        </div>
        
    </div>



<script type="text/javascript">

    var id="<?php echo $id;?>";
  	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var ordersn=$("#ordersn").val();
            var productname=$("#productname").val();

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_team_order')?>";
        	ajax_data={page:"1",team_id:id};
        	var list_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var total_page=list_data.data.total_page; //总页数
        	 
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
        	    for(var i = 0; i <= last; i++)
        	    {
        	    	str += "<tr>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' order-id='"+data[i].id+"'>"+data[i].ordersn+"</a></td>";
        	        str +=     "<td>"+data[i].item_code+"</td>";
         	        str +=     "<td><a href='javascript:void(0)' class='a_line' line-id='"+data[i].productautoid+"' line-name='"+data[i].productname+"'>"+data[i].productname+"</a></td>";
         	        str +=     "<td>"+data[i].usedate+"</td>"; 
          	        str +=     "<td>"+data[i].total_people+"</td>"; 
         	        str +=     "<td>"+data[i].lineday+"</td>";
         	        
        	        str +=     "<td>"+toDecimal2(data[i].total_price)+"</td>"; //订单金额
        	        str +=     "<td>"+toDecimal2(data[i].receive_price==""?'0':data[i].receive_price)+"</td>"; //已收款
        	        str +=     "<td>"+toDecimal2(data[i].supplier_cost)+"</td>";  //结算价=供应商成本-平台佣金
        	        str +=     "<td>"+toDecimal2(data[i].balance_money)+"</td>";  //已结算
        	        str +=     "<td>"+toDecimal2(data[i].all_platform_fee)+"</td>";  //平台佣金
        	        str +=     "<td>"+toDecimal2(data[i].nopay_money)+"</td>";  //未结算

        	       
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td>"+data[i].expertname+"</td>";
        	       
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        
        	      
                   
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
    $("body").on("click",".btn_approve",function(){

    	var reply=$("#reply").val();
        if(reply=="") {tan('请填写审核意见');return false;}
       
        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_deal');?>";
        var data={apply_id:id,reply:reply};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	tan2(return_data.data);
    		setTimeout(function(){t33_close_iframe();},200);

    		//刷新页面
    		//parent.$("#main")[0].contentWindow.getValue();
        }
        else
        {
            tan(return_data.msg);
        }
    	
    });

    //审核拒绝: 提交按钮
    $("body").on("click",".btn_refuse",function(){
    	
    	var refuse_reply=$("#reply").val();
        if(refuse_reply=="") {tan('请填写审核意见');return false;}
       
        var url="<?php echo base_url('admin/t33/sys/approve/api_pay_refuse');?>";
        var data={apply_id:id,reply:refuse_reply};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	
    		tan2(return_data.data);
    		setTimeout(function(){t33_close_iframe();},200);

    		//刷新页面
    		parent.$("#main")[0].contentWindow.getValue();
    		
    	
        }
        else
        {
            tan(return_data.msg);
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
	
    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $('.btn_close').click(function()
    {
         parent.layer.close(index);
    });

});



</script>
</html>


