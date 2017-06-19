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
<?php $this->load->view("admin/t33/common/dest_tree"); //加载树形目的地   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>财务管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">单团核算</a>
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
                                    <label>出团日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                                </div>
                                <div class="search_group">
                                    <label>供应商：</label>
                                    <input type="text" id="supplier_name" name="" class="search_input" style="width:90px;" />
                                </div>
                                <div class="search_group">
                                    <label>团号：</label>
                                    <input type="text" id="team_code" name="" class="search_input" style="width:120px;" />
                                </div>
                                 
                                <div class="search_group">
                                    <label>目的地：</label>
                                    <input type="text" id="dest_id" onfocus="showMenu(this.id);" name="" class="search_input" style="width:150px;" />
                                </div>
                                <div class="search_group">
                                    <label>价格：</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:90px;" /> ~ <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:90px;" />
                                    
                                </div>
                                <div class="search_group">
                                    <label>出发地：</label>
                                    <input type="text" id="startplace" name="" class="search_input" style="width:90px;" />
                                </div>
                                <div class="search_group" style="margin-right:0;">
                                    <label>行程天数：</label>
                                    <input type="text" id="day_start" name="" class="search_input" style="float: none;width:30px;" /> ~ <input type="text" id="day_end" name="" class="search_input" placeholder="" style="float: none;width:30px;" />
                                    
                                </div>
                               
                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin-right:0;">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索" style="margin-left:22px;"/>
                                </div>
                               
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>团号</th>
                                 
                                    <th>产品名称</th>
                                    <th>出发地</th>
                                    <th>出团日期</th>
                                    <th>供应商</th>
                                    <th>订单数</th>
                                    <th>总人数</th>
                                    <th>总金额</th>
                                    <th>总佣金</th>
                                    
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
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var productname=$("#productname").val();
            var team_code=$("#team_code").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var supplier_name=$("#supplier_name").val();
            
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            var day_start=$("#day_start").val();
            var day_end=$("#day_end").val();
            
            var startplace=$("#startplace").val();
            var order_code=$(".itab ul").attr("data-value");
            var dest_id=$("#dest_id").attr("data-id");

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/order/api_check_list')?>";
            ajax_data={page:"1",productname:productname,team_code:team_code,starttime:starttime,endtime:endtime,supplier_name:supplier_name,price_start:price_start,price_end:price_end,day_start:day_start,day_end:day_end,dest_id:dest_id,startplace:startplace,order_code:order_code};

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
        	        str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].description+"'>"+data[i].description+"</a></td>";
    
         	        str +=     "<td class='td_long'><a href='javascript:void(0)' onclick='show_line_detail("+data[i].lineid+",2)'  line-id='"+data[i].lineid+"' line-name='"+data[i].linename+"'>"+data[i].linename+"</a></td>";
         	        str +=     "<td>"+data[i].startplace+"</td>"; 
         	        str +=     "<td>"+data[i].day+"</td>";
          	        str +=     "<td>"+data[i].company_name+"</td>";
          	        str +=     "<td>"+(data[i].order_num==""?'0':data[i].order_num)+"</td>";
          	        str +=     "<td>"+(data[i].total_people==""?'0':data[i].total_people)+"</td>";  
          	        str +=     "<td>"+(data[i].total_money==""?'0':data[i].total_money)+"</td>";  
          	        str +=     "<td>"+(data[i].total_money==""?'0':data[i].total_platform_fee)+"</td>";  
          	      
        	        //操作
        	        var status_str="<a href='javascript:void(0)' class='a_detail' data-id='"+data[i].description+"' action='1'>核算</a>";
        	        if(data[i].calculation=="1")
                   		 status_str="<a href='javascript:void(0)' class='a_detail' data-id='"+data[i].description+"' action='2'>撤销核算</a>";

                   str +=     "<td>"+status_str+"</td>";
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

	//tab切换事件
	$(".itab ul li").click(function(){

		    var value=$(this).attr("static");
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
	//详情：团号下面的所有订单
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		var action=$(this).attr("action");
	    var title="核算";
		window.top.openWin({
		  type: 2,
		  area: ['960px', '580px'],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/team_order');?>"+"/"+id+"/"+action
		});
	});
	


});
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


