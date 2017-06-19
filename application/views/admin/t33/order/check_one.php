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


<?php 

$this->load->view("admin/t33/common/js_view"); //加载公用css、js  
$this->load->view("admin/t33/common/dest_tree"); //加载树形营业部

?>


<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>订单管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">订单核算</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-value="1"> 
                        <li static="1"><a href="#tab1" class="active">未核算</a></li> 
                        <li static="2"><a href="#tab1">已核算</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                            	<div class="search_group">
                                    <label>产品名称：</label>
                                    <input type="text" id="productname" name="" class="search_input" style="width:150px;" />
                                </div>
                                <div class="search_group">
                                    <label>订单编号：</label>
                                    <input type="text" id="ordersn" name="" class="search_input" style="width:90px;" />
                                </div>
                               
                                <div class="search_group">
                                    <label>出团日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                                </div>
                                <div class="search_group">
                                    <label>销售姓名：</label>
                                    <input type="text" id="expert_name" name="" class="search_input" style="width:90px;" />
                                </div>
                                 <div class="search_group">
                                    <label>供应商：</label>
                                    <input type="text" id="supplier_name" name="" class="search_input" style="width:150px;" />
                                </div>
                                
                                
                                 <div class="search_group">
                                    <label>出发地：</label>
                                    <input type="text" id="startplace" name="" class="search_input" style="width:90px;" />
                                </div>
                                 <div class="search_group">
                                    <label>目的地：</label>
                                    <input type="text" id="dest_id" onfocus="showMenu(this.id);" placeholder="输入关键字搜索" onkeyup="showMenu(this.id,this.value);" name="" class="search_input" style="width:204px;" />
                                </div>
                                 <div class="search_group" style="width:212px;">
                                    <label>团号：</label>
                                    <input type="text" id="team_code" name="" class="search_input" style="width:90px;" />
                                </div>
                                
                               
                                <div class="search_group">
                                    <label>营业部：</label>
                                   <input type="text" id="depart_id" onfocus="showMenu_depart(this.id,this.value);" onkeyup="showMenu_depart(this.id,this.value);" placeholder="输入关键字搜索" class="search_input" data-id="" style="width:180px;"/>
                                </div>
                                <div class="search_group">
                                    <label style="width:120px;">营业部(含子营业部)：</label>
                                   <input type="text" id="big_depart_id" onfocus="showMenu2(this.id,this.value);" onkeyup="showMenu2(this.id,this.value);" placeholder="输入关键字搜索" class="search_input" data-id="" style="width:180px;"/>
                                </div>
                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin:0;">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                               
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
									<th width="64">操作</th>
                                    <th width="70">订单编号</th>
                                    <th width="100">团号</th>
                                    <th width="70">营业部</th>

                                    <th width="150">产品名称</th>
                                    <th width="50">参团人数</th>
                                    <th width="70">订单金额</th>
                                    <th width="70">结算价</th>
                                    <th width="70">操作费</th>
                                    <th width="80">出团日期</th>
                                    <th width="60">订单状态</th>
                                    <th width="70">销售员</th>
                                    <th width="90">供应商</th>
                                    <th width="70">核算状态</th>
                                    

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
                
                <!--  -->
            </div>

        </div>
        
    </div>
   

   

<script type="text/javascript">

    var type_value="1";
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
            var supplier_name=$("#supplier_name").val();
            var expert_name=$("#expert_name").val();
            var destname=$("#dest_id").val();
            var dest_id=$("#dest_id").attr("data-id");
            var startplace=$("#startplace").val();
            var order_code=$(".itab ul").attr("data-value");
            var team_code=$("#team_code").val();
            var depart_id=$("#depart_id").attr("data-id");//营业部
            var big_depart_id=$("#big_depart_id").attr("data-id"); //营业部（含子营业部）

            if(depart_id!=""&&big_depart_id!="") {tan('营业部和营业部(含子营业部)搜索条件不能同时选择');return false;}
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/order/api_check_one_list')?>";
            ajax_data={page:"1",team_code:team_code,productname:productname,ordersn:ordersn,starttime:starttime,endtime:endtime,supplier_name:supplier_name,expert_name:expert_name,dest_id:dest_id,destname:destname,startplace:startplace,order_code:order_code,depart_id:depart_id,big_depart_id:big_depart_id};

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
        	    skip: true, //是否开启跳页
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
		        	//ret.curr=curpage;
                	//$("#page_div .laypage_curr").removeClass("laypage_curr");
                	//$("#page_div a[data-page=""]").trigger("click");
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
        	        //操作
        	        var status_str="<a href='javascript:void(0)' class='a_check' order-id='"+data[i].id+"'>核算</a>";
        	        if(type_value=="2")
                   		 status_str="<a href='javascript:void(0)' style='margin:0 1px;' class='a_cancel_check' order-id='"+data[i].id+"'>撤销核算</a>";

                    str +=     "<td>"+status_str+"</td>";
                   
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' order-id='"+data[i].id+"'>"+data[i].ordersn+"</a></td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_team' data-id='"+data[i].item_code+"'>"+data[i].item_code+"</a></td>"; 
         	        
         	        str +=     "<td>"+data[i].depart_name+"</td>";
         	        str +=     "<td class='td_long'><a href='javascript:void(0)' onclick='show_line_detail("+data[i].productautoid+",2)' line-id='"+data[i].productautoid+"' line-name='"+data[i].productname+"'>"+data[i].productname+"</a></td>";
         	        
          	        str +=     "<td>"+data[i].total_people+"</td>";
          	        str +=     "<td>"+data[i].all_price+"</td>";
          	        str +=     "<td>"+data[i].supplier_cost+"</td>";
          	        str +=     "<td>"+data[i].caozuo_fee+"</td>";
          	        str +=     "<td>"+data[i].usedate+"</td>";  

          	       
          	        str +=     "<td>"+data[i].order_status+"</td>";
        	        str +=     "<td>"+data[i].expertname+"</td>";
        	        str +=     "<td>"+data[i].brand+"</td>";

        	        var shenhe_str="未核算";
          	        if(type_value=="2")
          	        	shenhe_str="已核算";
          	        str +=     "<td>"+shenhe_str+"</td>";
        	       
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
	            	 layer.closeAll('loading');
	            	 /*setTimeout(function(){
	           		  layer.closeAll('loading');
	           		}, 200);*/  //0.2秒后消失
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

	//tab切换事件
	$(".itab ul li").click(function(){

		    var value=$(this).attr("static");
		    type_value=value;
		    $(".itab ul").attr("data-value",value);
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
	//团号下面的所有订单
	$("body").on("click",".a_team",function(){
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
	//订单核算    on：用于绑定未创建内容
	
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("order-id");
		window.top.openWin({
		  title:"订单核算",
		  type: 2,
		  area: ['70%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/check_detail');?>"+"?id="+order_id
		});
	});
	
	 //核算
	 $("body").on("click",".a_check",function(){
			  var order_id=$(this).attr("order-id");
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:"1",action:'yj'};
              var return_data=object.send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                 $(this).parent().html("已核算");
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
	  //取消核算
	  $("body").on("click",".a_cancel_check",function(){
			  var order_id=$(this).attr("order-id");
              var url="<?php echo base_url('admin/t33/sys/order/do_check_one')?>";
              var post_data={order_id:order_id,value:"0",action:'yj'};
              var return_data=object.send_ajax_noload(url,post_data);
             
              if(return_data.code=="2000")
              {
                 $(this).parent().html("已撤销核算");
              }
              else
              {
                  tan(return_data.msg);
              }
	    })
	


});

//供弹窗层调用
function parentfun(id,str){

	$(".a_check[order-id="+id+"]").parent().html(str);
	$(".a_cancel_check[order-id="+id+"]").parent().html(str);
	
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


