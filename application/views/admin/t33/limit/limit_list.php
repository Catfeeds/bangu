<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.show_select
</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/depart_tree"); //加载树形营业部   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>额度管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">额度还款查询</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                     <li static="1"><a href="#tab1" data-id="0" class="active li_type">额度还款查询</a></li> 
                       <!--  <li static="1"><a href="#tab1" data-id="0" class="active li_type">未使用</a></li> 
					    <li static="1"><a href="#tab1" data-id="1" class="li_type">已使用</a></li> 
					    <li static="1"><a href="#tab1" data-id="2" class="li_type">已还款</a></li>  -->
					    
                    </ul>
                </div>
                <div class="tab_content" style="padding:0;">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">                                
                                <div class="search_group">
                                    <label>营业部：</label>
                                    <input type="text" id="depart_id" onfocus="showMenu(this.id);" class="search_input" data-id="" style="width:202px;">

                                </div>
                               	<div class="search_group">
                                    <label>销售姓名：</label>
                                    <input type="text" id="expert_name" name="" class="search_input" style="width:90px;" />
                                </div>
                               <div class="search_group">
                                    <label>订单编号：</label>
                                    <input type="text" id="ordersn" name="" class="search_input" style="width:90px;" />
                                </div>
                                 <div class="search_group">
                                    <label>申请日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:80px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:80px;">
                        
                                 </div>
                                <div class="search_group">
                                    <label>还款状态：</label>
                                    <div class="form_select" style="margin-right:0;">
                                        <div class="search_select div_status">
                                            <div class="show_select ul_status" data-value="-1" style="width:70px;" >全部</div>
                                            <ul class="select_list">
                                          		    <li data-value="-2">全部</li>
                                                    <li data-value="0">未使用</li>
	                                                <li data-value="1">未还款</li>
	                                                <li data-value="2">已还款</li>
	                                                <li data-value="-1">已撤销</li>
	         
                                              
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>
                               </div>
                               <div class="search_group">
                                    <label>还款日期：</label>
                                    <input class="search_input" type="text" id="returntime_start" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="returntime_end" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                        
                                 </div>
                 
                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                              
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr class="tr_rows">
                                    <th>销售姓名</th>
                                    <th>营业部门</th>
                                    <th>申请的信用额度</th>
                                    <th>实际使用的信用额度</th>
                                    <th>已还款金额</th>
                                    <th>生成时间</th>
                                   
                                    <th>操作</th>
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
                <div id="page_div"></div>
            </div>

        </div>
        
    </div>
   




<script type="text/javascript">
	type_value="-2";  //类型：默认-2，-1已撤销，0未使用，1已使用、2已还款
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var expert_name=$("#expert_name").val();
           
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var depart_id=$("#depart_id").attr("data-id");
            var ordersn=$("#ordersn").val();

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/limit/api_limit_list')?>";
        	ajax_data={type:type_value,depart_id:depart_id,ordersn:ordersn,expert_name:expert_name,starttime:starttime,endtime:endtime};

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

		        	//分情况
		        	//if(type_value=="0")
			        	//$(".tr_rows").html("<th>申请编号</th><th>销售姓名</th><th>营业部门</th><th>申请额度金额</th><th>实际使用的额度</th><th>已还款金额</th><th>申请时间</th><th>还款时间</th>");
		        	//else if(type_value=="1")
		        		//$(".tr_rows").html("<th>申请编号</th><th>销售姓名</th><th>营业部门</th><th>申请额度金额</th><th>实际使用的额度</th><th>已还款金额</th><th>相关订单</th><th>申请时间</th><th>还款时间</th>");
		        	//else if(type_value=="2")
		        		$(".tr_rows").html("<th>申请编号</th><th>销售姓名</th><th>营业部门</th><th>申请额度金额</th><th>实际使用的额度</th><th>已还款金额</th><th>相关订单</th><th>申请时间</th><th>状态</th><th>还款时间</th>");

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
        	//end
        	
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {
        	    	 
        	        str += "<tr>";
        	        str +=     "<td>"+data[i].apply_id+"</td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";
         	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].id+"'>"+data[i].apply_amount+"</a></td>";

        	        if(type_value=="0")
            	        var real_amount_str="";
        	        else 
            	        var real_amount_str=data[i].real_amount;
        	        str +=     "<td>"+real_amount_str+"</td>";
        	        str +=     "<td>"+data[i].return_amount+"</td>";
        	        
        	        
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].ordersn+"</a></td>";
        	        str +=     "<td>"+data[i].apply_time+"</td>";
        	        var status_str="";
                    if(data[i].status=="0")
                    	status_str="未使用";
                    else if(data[i].status=="1")
                    	status_str="未还款";
                    else if(data[i].status=="2")
                    	status_str="已还款";
                    else if(data[i].status=="-1")
                    	status_str="已撤销";
                    str +=     "<td>"+status_str+"</td>";
        	        str +=     "<td>"+data[i].return_time+"</td>";
        	       
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
    //select 
	$(".div_kind ul li").click(function(){
		var value=$(this).attr("value");
		$(".div_kind .ul_kind").attr("data-value",value);

	})
	 //select 
	$(".div_status ul li").click(function(){
		var value=$(this).attr("data-value");
		type_value=value;
		$(".div_status .ul_status").attr("data-value",value);
		flag=true;
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
	//日历控件
	$('#returntime_start').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//日历控件
	$('#returntime_end').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//申请来源
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		
		window.top.openWin({
		  type: 2,
		  area: ['800px', '340px'],
		  title :'额度申请单',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/limit/limit_detail');?>"+"?id="+id
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

	

});



</script>
</html>


