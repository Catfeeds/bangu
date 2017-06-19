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
            <a href="#" class="main_page_link"><i></i>产品管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">产品管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-id="1"> 
                        <li static="1"><a href="javascript:void(0)" class="active">直属供应商</a></li> 
                        <li static="2"><a href="javascript:void(0)">非直属供应商</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:64px;'>目的地：</label>
                                    <input type="text" id="dest_id" data-id="" placeholder="输入关键字搜索" onfocus="showMenu(this.id,this.value);" onkeyup="showMenu(this.id,this.value);" class="search_input" style="width:150px;" />
                                </div>
                                 <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:64px;'>出发地：</label>
                                    <input type="text" id="startplace" name="" class="search_input" style="width:90px;" />
                                </div>
                                
                                <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:64px;'>出团日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:80px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:80px;">
                                </div>
                                
                               
                                 <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:40px;'>价格：</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:60px;" /> 至 <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:60px;" />
                                    
                                </div>
                                <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:64px;'>产品标题：</label>
                                    <input type="text" id="linename" name="" class="search_input" style="width:150px;" />
                                </div>
                                <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:64px;'>产品编号：</label>
                                    <input type="text" id="linecode" name="" class="search_input" style="width:90px;" />
                                </div>
                                <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:40px;'>团号：</label>
                                    <input type="text" id="team_code" name="" class="search_input" style="width:110px;" />
                                </div>
                               <div class="search_group" style='margin-right: 10px;'>
                                    <label style='width:64px;'>行程天数：</label>
                                    <input type="text" id="days_start" name="" class="search_input" style="float: none;width:30px;" /> 至 <input type="text" id="days_end" name="" class="search_input" placeholder="" style="float: none;width:30px;" />
                                    
                                </div>
                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin-right:0;">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                               
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr class="tr_rows">
                                  <!--   <th>团号</th>
                                    <th>产品标题</th>
                                    <th>出发地</th>
                                    <th>截止日期</th>
                                    <th>出团日期</th>
                                    <th>供应商名称</th>
                                    <th>成人价格</th>
                                    <th>老人价格</th>
                                    <th>儿童价格</th>
                                    <th>不占床儿童价</th>
                                    <th>余位</th>
                                    <th>已订人数</th>
                                    <th>操作</th> -->
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
	var value="1"; //导航tab值
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var startplace=$("#startplace").val();
            var linename=$("#linename").val();
            var linecode=$("#linecode").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var days_start=$("#days_start").val();
            var days_end=$("#days_end").val();
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            var dest_id=$("#dest_id").attr("data-id");
            var team_code=$("#team_code").val();
            var type=$(".itab ul").attr("data-id"); //1是直属供应商，2是非直属供应商

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/line/api_line_list')?>";
            ajax_data={page:"1",type:type,startplace:startplace,dest_id:dest_id,linename:linename,linecode:linecode,starttime:starttime,endtime:endtime,days_start:days_start,days_end:days_end,price_start:price_start,price_end:price_end,team_code:team_code};

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
		        	
		        	$(".tr_rows").html('<th width="100">团号</th><th>产品标题</th><th width="100">出发地</th><th width="65">截止日期</th><th width="80">出团日期</th><th width="130">供应商</th><th width="55">成人价</th><th width="55">小童价</th><th width="60">小童不占</th><th width="55">单房差</th><th width="50">余位</th><th width="80">已订人数</th><th width="50">操作</th>');
// 		        	if(value=="1")
// 		        	else if(value=="2")
// 		        		$(".tr_rows").html("<th>团号</th><th>产品标题</th><th>出发地</th><th>截止日期</th><th>出团日期</th><th>供应商</th><th>成人价</th><th>小童价</th><th>小童不占</th><th>单房差</th><th>余位</th><th>已订人数</th><th>操作</th>");
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
        	        str +=     "<td style='text-align:left;'>"+data[i].team_code+"</td>";
        	        str +=     "<td style='text-align:left;'><a href='javascript:void(0)' onclick='show_line_detail("+data[i].lineid+",2)' line-id='"+data[i].lineid+"' line-name='"+data[i].linename+"'>"+data[i].linename+"</a></td>";
        	        
        	        str +=     "<td>"+data[i].startplace+"</td>";
        	        str +=     "<td>提前"+data[i].linebefore+"天</td>";
        	        str +=     "<td>"+data[i].day+"</td>";

        	        str +=     "<td class='td_long' ><a href='javascript:void(0)' class='a_supplier' supplier_id='"+data[i].supplier_id+"'>"+data[i].company_name+" - "+data[i].linkman+"</a></td>";
        	        str +=     "<td>"+data[i].adultprice+"</td>";
        	        str +=     "<td>"+data[i].childprice+"</td>";
        	        str +=     "<td>"+data[i].childnobedprice+"</td>";
                   str +=     "<td>"+data[i].room_fee+"</td>";
        	        str +=     "<td>"+data[i].number+"</td>";
        	        str +=     "<td>"+(data[i].total_dingnum==""?'0':data[i].total_dingnum)+"+"+(data[i].total_childnum==""?'0':data[i].total_childnum)+"+"+(data[i].total_childnobednum==""?'0':data[i].total_childnobednum)+"</td>";
        	       
        	        //操作
        	        var status_str="";
                   /*  if(data[i].status=="2")
                   		var status_str="<a href='javascript:void(0)' class='close_expert' title='"+data[i].id+"'>停用</a>";
                    else if(data[i].status=="-1")
                    	var status_str="<a href='javascript:void(0)' class='open_expert' title='"+data[i].id+"'>开启</a>";
 */
                   status_str += "<a href='javascript:void(0)' class='a_trip' line-id='"+data[i].lineid+"' dayid='"+data[i].id+"'>行程</a>";
                   
                   str +=     "<td><a href='javascript:void(0)' class='a_detail' line-id='"+data[i].lineid+"' line-name='"+data[i].linename+"'>详情</a>"+status_str+"</td>";
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

	//选择事件
	$(".itab ul li").click(function(){
		value=$(this).attr("static");
		$(".itab ul").attr("data-id",value);
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
	//供应商详情    on：用于绑定未创建内容
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("supplier_id");
		var supplier_name=$(this).html();
		
		window.top.openWin({
		  title:supplier_name,
		  type: 2,
		  area: ['600px', '300px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail');?>"+"?id="+supplier_id
		});
	});
	//线路详情    on：用于绑定未创建内容
	$("body").on("click",".a_detail",function(){
		var line_id=$(this).attr("line-id");
		var line_name=$(this).attr("line-name");
		window.top.openWin({
		  title:line_name,
		  type: 2,
		  area: ['1000px', '70%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/line/detail');?>"+"?id="+line_id
		});
	});

	//线路行程    on：用于绑定未创建内容
	$("body").on("click",".a_trip",function(){
		var line_id=$(this).attr("line-id");
		var dayid=$(this).attr("dayid");
		/*window.top.openWin({
		  title:"行程",
		  type: 2,
		  area: ['840px', '600px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/line/trip');?>"+"?id="+line_id
		});*/
		var win1 = window.open("<?php echo base_url('admin/t33/sys/line/trip');?>"+"?id="+line_id+"&dayid="+dayid,'print','height=950,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=yes, resizable=yes,location=no, status=no');
		win1.focus();
	});
	


});

function show_line_detail(line_id,type){
	var line_id=line_id;
	window.top.openWin({
		title:'线路详情',
		type: 2,
		area: ['1100px', '80%'],
		fix: false, //不固定
		maxmin: true,
		content: "<?php echo base_url('common/line/show_line_detail');?>"+"?id="+line_id+"&type="+type
	});	
}

</script>
</html>


