<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}


.order_info_table tr td.order_info_title{

width:100px !important;

}

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" style="">
                    <p style="height:24px;line-height:24px;border-bottom: 1px solid #dddddd;background:#fff;float:left;width:100%;margin-bottom:5px;color:#000000;font-weight:bold !important;">营业部信息</p>
                    <!-- 营业部信息 -->
                    <div>
                     <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                   
                    <tr height="40">
                        <td class="order_info_title">所属旅行社:</td>
                        <td><?php echo isset($depart['union_name'])==true?$depart['union_name']:""; ?></td>
                        <td class="order_info_title">联系电话:</td>
                        <td><?php echo isset($depart['linkmobile'])==true?$depart['linkmobile']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">联系人:</td>
                        <td><?php echo isset($depart['linkman'])==true?$depart['linkman']:""; ?></td>
                        <td class="order_info_title">上级部门:</td>
                        <td><?php echo isset($depart['pname'])==true?$depart['pname']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行-支行:</td>
                        <td><?php echo isset($depart['bankcard'])==true?$depart['bankname']."-".$depart['branch']:""; ?></td>
                        <td class="order_info_title">银行卡号:</td>
                        <td><?php echo isset($depart['bankcard'])==true?$depart['bankcard']:""; ?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title" style="font-weight:bold;color:#e8831b;width:8%;">现金余额:</td>
                        <td><?php echo isset($depart['cash_limit'])==true?$depart['cash_limit']:""; ?></td>
                        <td class="order_info_title" style="font-weight:bold;color:#e8831b;width:8%;">信用余额:</td>
                        <td><?php echo isset($depart['credit_limit'])==true?$depart['credit_limit']:""; ?></td>
                    </tr>
                     
                   
                </table>
                    </div>
                    <p style="height:24px;line-height:24px;border-bottom: 1px solid #dddddd;background:#fff;float:left;width:100%;margin-bottom:5px;margin-top:28px;color:#000000;font-weight:bold !important;">使用明细</p>
                    <!-- 使用明细 -->
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="padding-top: 4px;width:540px !important;">
                            
                                <div class="search_group">
                                    <label>使用日期</label>
                                    <input type="text" id="starttime" data-date-format="yyyy-mm-dd" class="search_input" style="float:none;width:90px;" /> -  <input type="text" id="endtime" data-date-format="yyyy-mm-dd" class="search_input" style="float:none;width:90px;" />
                                </div>
                                <div class="search_group">
                                    <label>订单编号</label>
                                    <input type="text" id="ordersn" name="" class="search_input" placeholder="订单编号"/>
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
                                    <th width="136">使用日期</th>
                                    <th width="50">销售姓名</th>
                                    <th width="160">说明</th>
                                    <th width="66">订单编号</th>
                                    <th width="60">订单金额</th>
                                    <th width="60">授信额度</th>
                                    <th width="60">收款</th>
                                    <th width="60">扣款</th>
                                    <th width="60">退款</th>
                                    <th width="60">现金余额</th>
                                    <th width="60">信用余额</th>
                                  
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
                        <div class="no-data" style="display:none;height:410px;">木有数据哟！换个条件试试</div>
                    </div>                   
                </div>
                <div id="page_div" style="padding-top: 0;"></div>
            </div>

        </div>
        
    </div>



<script type="text/javascript">

    var depart_id="<?php echo $depart_id;?>";
    var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var ordersn=$("#ordersn").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/limit/api_limit_log')?>";
        	ajax_data={page:"1",depart_id:depart_id,starttime:starttime,endtime:endtime,ordersn:ordersn};
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
		        	if(ret.curr==1&&flag==true)
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
        	flag=false;
        	
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {

        	        str += "<tr>";
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";
        	        
        	        str +=     "<td>"+data[i].type+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].order_sn+"</a></td>";
        	        str +=     "<td>"+data[i].order_price+"</td>";

         	        if(data[i].sx_limit>0)
            	    {
        	        	str +=     "<td style='color:#008000;'>+"+data[i].sx_limit+"</td>";
            	    }
        	        else if(data[i].sx_limit==0)
        	        {
        	        	 str +=     "<td></td>";
            	    }
        	        else
        	        {
        	        	 str +=     "<td style='color:#ff0000;'>"+data[i].sx_limit+"</td>";
            	    }
            	    //
            	     if(data[i].receivable_money>0)
            	    {
        	        	str +=     "<td style='color:#008000;'>+"+data[i].receivable_money+"</td>";
            	    }
        	        else if(data[i].receivable_money==0)
        	        {
        	        	 str +=     "<td></td>";
            	    }
        	        else
        	        {
        	        	 str +=     "<td style='color:#ff0000;'>"+data[i].receivable_money+"</td>";
            	    }
        	        //
        	         if(data[i].cut_money>0)
            	    {
        	        	str +=     "<td style='color:#008000;'>+"+data[i].cut_money+"</td>";
            	    }
        	        else if(data[i].cut_money==0)
        	        {
        	        	 str +=     "<td></td>";
            	    }
        	        else
        	        {
        	        	 str +=     "<td style='color:#ff0000;'>"+data[i].cut_money+"</td>";
            	    }
             	    //
             	    if(data[i].refund_monry>0)
            	    {
        	        	str +=     "<td style='color:#008000;'>+"+data[i].refund_monry+"</td>";
            	    }
        	        else if(data[i].refund_monry==0)
        	        {
        	        	 str +=     "<td></td>";
            	    }
        	        else
        	        {
        	        	 str +=     "<td style='color:#ff0000;'>"+data[i].refund_monry+"</td>";
            	    }
        	      
        	      
        	        str +=     "<td>"+data[i].cash_limit+"</td>";
        	        str +=     "<td>"+data[i].credit_limit+"</td>";
        	        
        	       
        	      
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


});



</script>
</html>


