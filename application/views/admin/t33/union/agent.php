<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}



.input_edit{padding:4px;display:none;width:90px;margin:0 auto;text-align:center;}

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>


<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>佣金管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">外交佣金设置</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">外交佣金设置</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group">
                                    <label style='width:74px;'>目的地名称：</label>
                                    <input type="text" id="dest_name" name="" class="search_input" style="width:120px;"/>
                                </div>
                               <div class="search_group">
                                    <label style='width:40px;'>分类：</label>
                                    <div class="form_select">
                                        <div class="search_select div_type">
                                            <div class="show_select ul_type" data-value="" style='width:70px;'>全部</div>
                                            <ul class="select_list">
                                               
                                                <li value="2">境内</li>
                                                <li value="1">境外</li>
                                               
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>

                                </div>
                                <div class="search_group">
                                    <label style='width:40px;'>状态：</label>
                                    <div class="form_select">
                                        <div class="search_select div_kind">
                                            <div class="show_select ul_kind" data-value="" style='width:70px;'>全部</div>
                                            <ul class="select_list">
                                               
                                                <li value="1">未设置</li>
                                                <li value="2">已设置</li>
                                               
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>

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
                                    <!-- <th>上级营业部</th> -->
                                    <th>目的地名称</th>
                                    <th>成人外交佣金</th>
                                    <th>儿童占床外交佣金</th>
                                    <th>儿童不占床外交佣金</th>
                                    <th>老人占床佣金</th>
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

	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var dest_name=$("#dest_name").val();
            
            var type=$(".div_kind .ul_kind").attr("data-value");
            var pid=$(".div_type .ul_type").attr("data-value"); //境内境外
           
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/union/api_agent_list')?>";
        	ajax_data={page:"1",dest_name:dest_name,type:type,pid:pid};
        	var list_data=object.send_ajax(post_url,ajax_data);  //数据结果
        	var total_page=list_data.data.total_page;   //总页数

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
        	        str +=     "<td>"+data[i].id+"</td>";
                  
           	        str +=     "<td>"+data[i].kindname+"</td>";
        	        str +=     "<td><font class='font_edit font_adult'>"+data[i].adult_agent+"</font><input type='text' class='input_edit adult_agent' /></td>";
        	        str +=     "<td><font class='font_edit font_child'>"+data[i].child_agent+"</font><input type='text' class='input_edit child_agent' /></td>";
        	        str +=     "<td><font class='font_edit font_childnobed'>"+data[i].childnobed_agent+"</font><input type='text' class='input_edit childnobed_agent' /></td>";
        	        str +=     "<td><font class='font_edit font_old'>"+data[i].old_agent+"</font><input type='text' class='input_edit old_agent' /></td>";
        	        
        	     
                   
                   str +=     "<td class='td_edit'><a href='javascript:void(0)' class='edit_agent' agent-id='"+data[i].agent_id+"' dest-id='"+data[i].id+"'>修改</a></td>";
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
	$(".div_type ul li").click(function(){

		var value=$(this).attr("value");
		$(".div_type .ul_type").attr("data-value",value);
		
		
	})
   $("#btn_submit").click(function(){
	   object.init();
	})
	//日历控件
	$('#date').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	
	//编辑按钮
	$("body").on("click",".edit_agent",function()
	{
		 $(this).parent().parent().find(".font_edit").css("display","none");
         $(this).parent().parent().find(".input_edit").css("display","block");

         var a=$(this).parent().parent().find(".font_adult").html();
         var b=$(this).parent().parent().find(".font_child").html();
         var c=$(this).parent().parent().find(".font_childnobed").html();
         var d=$(this).parent().parent().find(".font_old").html();

         $(this).parent().parent().find(".adult_agent").val(a);
         $(this).parent().parent().find(".child_agent").val(b);
         $(this).parent().parent().find(".childnobed_agent").val(c);
         $(this).parent().parent().find(".old_agent").val(d);

         var dest_id=$(this).attr("dest-id");
         var agent_id=$(this).attr("agent-id");
         var str="<a href='javascript:void(0)' class='edit_save' agent-id='"+agent_id+"' dest-id='"+dest_id+"'>保存</a><a href='javascript:void(0)' class='edit_cancel' agent-id='"+agent_id+"' dest-id='"+dest_id+"'>取消</a>"
         $(this).parent(".td_edit").html(str);
		
	})//end
	
	//取消按钮
	$("body").on("click",".edit_cancel",function()
	{
		 $(this).parent().parent().find(".input_edit").css("display","none");
		 $(this).parent().parent().find(".font_edit").css("display","block");
         
         var dest_id=$(this).attr("dest-id");
         var agent_id=$(this).attr("agent-id");
         var str="<a href='javascript:void(0)' class='edit_agent' agent-id='"+agent_id+"' dest-id='"+dest_id+"'>修改</a>"
         $(this).parent(".td_edit").html(str);
		
	})//end
	//保存按钮
	$("body").on("click",".edit_save",function()
	{
		 var dest_id=$(this).attr("dest-id");  //目的地id
         var agent_id=$(this).attr("agent-id"); //id

		 var a=$(this).parent().parent().find(".adult_agent").val();
		 var b=$(this).parent().parent().find(".child_agent").val();
		 var c=$(this).parent().parent().find(".childnobed_agent").val();
		 var d=$(this).parent().parent().find(".old_agent").val();

		 $(this).parent().parent().find(".font_adult").html(a);
         $(this).parent().parent().find(".font_child").html(b);
         $(this).parent().parent().find(".font_childnobed").html(c);
         $(this).parent().parent().find(".font_old").html(d);

            var url="<?php echo base_url('admin/t33/sys/union/api_edit_agent')?>";
			var data={agent_id:agent_id,dest_id:dest_id,adult_agent:a,child_agent:b,childnobed_agent:c,old_agent:d};  //
			var return_data=object.send_ajax_noload(url,data);
			if(return_data.code=="2000")
			{
				tan2(return_data.data);


				//改变按钮
			     $(this).parent().parent().find(".input_edit").css("display","none");
				 $(this).parent().parent().find(".font_edit").css("display","block");
		         
		        
		        var str="<a href='javascript:void(0)' class='edit_agent' agent-id='"+agent_id+"' dest-id='"+dest_id+"'>修改</a>"
		        $(this).parent(".td_edit").html(str);
			}
			else
			{
				tan(return_data.msg);
			}
         
       
		
	})//end
	

});



</script>
</html>


