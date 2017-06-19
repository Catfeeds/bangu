<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">



.not-allow{cursor:not-allowed !important;opacity:0.5;}

.itab ul li{list-style:inherit !important;}  /* tab内容 出现 。符号  */

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/depart_tree"); //加载树形营业部   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>财务管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">杂费录入</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab" data-id="1">
                  <ul> 
                     <li static="1"><a href="javascript:void(0)" class="active li_type">杂费列表</a></li> 

                    </ul> 
                   
                </div>
                <div class="tab_content" style="padding-bottom:10px;">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="padding-right:0;">
                               <div class="search_group">
                                    <label>申请部门：</label>
                                    <input type="text" id="depart_id" onfocus="showMenu(this.id);" class="search_input" data-id="" style="width:202px;">

                                </div> 
                                <div class="search_group">
                                    <label>上级部门：</label>
                                    <input type="text" id="depart_pid" onfocus="showMenu(this.id);" class="search_input" data-id="" style="width:202px;">

                                </div> 
                                <div class="search_group">
                                    <label>杂费名称：</label>
                                    <input type="text" id="item" name="" class="search_input" style="width:100px;"/>
                                </div>                               
                               
                                
                                <div class="search_group">
                               		<span class="a_add btn btn_green" style="margin:3px 20px 0 20px;">新增杂费</span>
                               </div>
                              	<div class="search_group">
                                    <label>金额：</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:90px;" /> ~ <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:90px;" />      
                                </div>
                                 <div class="search_group">
                                    <label>添加日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value=""  style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:90px;">
       
                                </div>
								
                                <div class="search_group">
                                    <label>操作人：</label>
                                    <input type="text" id="employee_name" name="" class="search_input" style="width:100px;"/>
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
            var employee_name=$("#employee_name").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
          
            var depart_id=$("#depart_id").attr("data-id");
            var depart_pid=$("#depart_pid").attr("data-id");
            var item=$("#item").val();
           
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/order/api_zafei')?>";
        	ajax_data={page:"1",depart_id:depart_id,depart_pid:depart_pid,item:item,employee_name:employee_name,starttime:starttime,endtime:endtime,price_start:price_start,price_end:price_end};

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

		        	
			        $(".tr_rows").html("<th>编号</th><th>杂费名称</th><th>扣款</th><th>营业部</th><th>上级营业部</th><th>说明</th><th>操作人</th><th>添加时间</th>");
		        	
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
        	        str +=     "<td>"+data[i].id+"</td>";
        	        str +=     "<td>"+data[i].item+"</td>";
         	        str +=     "<td style='color:#FF3300;'>"+data[i].amount+"</td>";
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td>"+data[i].depart_pname+"</td>";
        	        str +=     "<td>"+data[i].description+"</td>";
        	        str +=     "<td>"+data[i].employee_name+"</td>";
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
    //select 
	$(".itab ul li").click(function(){
		var value=$(this).attr("static");
		$(".itab").attr("data-id",value);
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
	//日历控件
	$('#shen_start').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//日历控件
	$('#shen_end').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});

	//添加按钮
	$("body").on("click",".a_add",function(){
		window.top.openWin({
		  type: 2,
		  area: ['820px', '500px'],
		  title :'新增杂费',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/zafei_add');?>"
		});
	});
	
	
	
	
	


});

    

</script>
</html>


