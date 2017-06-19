<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">

/*分割线 :p*/
.p_warp{
height:24px;line-height:24px;border-bottom: 1px solid #dddddd;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:28px;color:#000000;font-weight:bold !important;
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
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" style="padding-bottom: 0px;min-height:670px;">
                    <p class="p_warp" style="margin-top:0px;">结算单信息</p>
                    <!-- 营业部信息 -->
                    <div>
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                   
                    <tr height="40">
                        <td class="order_info_title">申请时间:</td>
                        <td><?php echo isset($bill['addtime'])==true?$bill['addtime']:""; ?></td>
                        <td class="order_info_title">申请人:</td>
                        <td><?php echo isset($bill['expert_name'])==true?$bill['expert_name']:""; ?></td>
                    </tr>
                     <tr height="40">
                        <td class="order_info_title">开始时间:</td>
                        <td><?php echo isset($bill['start_time'])==true?$bill['start_time']:""; ?></td>
                        <td class="order_info_title">结束时间:</td>
                        <td><?php echo isset($bill['end_time'])==true?$bill['end_time']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">备注:</td>
                        <td colspan="3"><?php echo isset($bill['reason'])==true?$bill['reason']:""; ?></td>
                       
                    </tr>
                   
                   </table>
                  </div>
                    <p class="p_warp">结算订单列表</p>
                    <!-- 使用明细 -->
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="padding-top: 4px;">
                            
                                <div class="search_group">
                                    <label>订单编号</label>
                                    <input type="text" id="ordersn" name="" class="search_input" placeholder="订单编号"/>
                                </div>
                                <div class="search_group">
                                    <label>产品名称</label>
                                    <input type="text" id="productname" name="" class="search_input" placeholder="产品名称"/>
                                </div>
                             
                                      
                 
                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                              
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>序号</th>
                                    <th>利润</th>
                                    <th>订单序号</th>
                                    <th>产品名称</th>
                                    <th>出团日期</th>
                                    <th>订单金额</th>
                                    <th>成本</th>
                                    <th>外交佣金</th>
                                    <th>保险费用</th>
                                    <th>审核状态</th>
                                    <th>销售姓名</th>
                                  
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
                        
                        <p class="p_total">总计：<font style="color:#FF6600;" class="total_money"><?php echo isset($bill['amount'])==true?$bill['amount']:""; ?></font>元</p>
                         <div id="page_div" style="background: #fff;text-align:right;"></div>
                        <p class="p_expert"><font>销售银行账户：<?php echo isset($bill['bankcard'])==true?$bill['bankcard']:""; ?></font><font>开户银行：<?php echo isset($bill['bankname'])==true?$bill['bankname']:""; ?></font><font>开户人：<?php echo isset($bill['cardholder'])==true?$bill['cardholder']:""; ?></font></p>
                        <!-- 审核 -->
                        <?php if($action=="2"):?>
                        <div class="fb-form" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					           
					           
					            <div class="form-group" style="width:100%;float:left;margin:0 0 0 0;">
					                <div class="fg-title" style="width:8% !important;float:left;text-align:left;">审核意见：<i>*</i></div>
					                <div class="fg-input" style="width:84%;float:left;">
					                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:160px;width:100%;padding:5px;"></textarea>
					                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
					                </div>
					            </div>
					        
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:48px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                 <input type="button" class="fg-but btn_two btn_refuse" value="拒绝">
					                 <input type="button" class="fg-but btn_one btn_approve" style="background:#da411f;" value="通过">
					                 
					                </div>
					            </div>
					           
					        </form>
					    </div>
					    <?php endif;?>
					   <!-- 审核结束 -->
                     
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
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_bill_order')?>";
        	ajax_data={page:"1",id:id,productname:productname,ordersn:ordersn};
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
                    var no=i+1;
        	        str += "<tr>";
        	        str +=     "<td>"+no+"</td>";
        	        str +=     "<td style='color:#FF3300;'>"+data[i].agent_fee+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].ordersn+"</a></td>";
        	        str +=     "<td>"+data[i].productname+"</td>";
        	        str +=     "<td>"+data[i].usedate+"</td>";
        	        str +=     "<td>"+data[i].total_price+"</td>";
        	        str +=     "<td>"+data[i].supplier_cost+"</td>";
        	        str +=     "<td>"+data[i].diplomatic_agent+"</td>";
        	        str +=     "<td>"+data[i].settlement_price+"</td>";

        	        var status_str="";
        	        if(data[i].status=="0")
        	        {
        	        	status_str="待审核";
            	    }
        	        else if(data[i].status=="1")
        	        {
        	        	status_str="已通过";
            	    }
        	        else if(data[i].status=="2")
        	        {
        	        	status_str="已拒绝";
            	    }
        	        str +=     "<td>"+status_str+"</td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";
        	        
        	      
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
	//搜索按钮
    $("#btn_submit").click(function(){
		   object.init();
		})
	//营业部额度使用记录
	$("body").on("click",".a_detail",function(){
		var depart_id=$(this).attr("data-id");
		
		window.top.openWin({
		  type: 2,
		  area: ['800px', '700px'],
		  title :'额度使用详情',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/limit/limit_log');?>"+"?depart_id="+depart_id
		});
	});
  //审核通过按钮
    $("body").on("click",".btn_approve",function(){

    	var reply=$("#reply").val();
       
        var url="<?php echo base_url('admin/t33/sys/approve/api_bill_deal');?>";
        var data={id:id,reply:reply};
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
            tan(data.msg);
        }
    	
    });

    //审核拒绝: 提交按钮
    $("body").on("click",".btn_refuse",function(){
    	
    	var refuse_reply=$("#reply").val();
        if(refuse_reply=="") {tan('请填写审核意见');return false;}
       
        var url="<?php echo base_url('admin/t33/sys/approve/api_bill_refuse');?>";
        var data={id:id,reply:refuse_reply};
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
            tan(data.msg);
        }
    	
    });
    //订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("data-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['1200px', '80%'],
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


