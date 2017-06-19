<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
 
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
</style>
<link href="<?php echo base_url("assets/ht/css/jquery.datetimepicker.css"); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/ht/js/laypage.js"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>

</head>
<body>


<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">

        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>产品管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">单项产品</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul data-id="2"> 
                        <li static="2" id="table1"><a href="javascript:void(0)" class="active">售卖中</a></li> 
                        <li static="3"  id="table2"><a href="javascript:void(0)">已停售</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <!-- <div class="search_group">
                                    <label>目的地</label>
                                    <input type="text" id="dest_id" data-id="" name="" onfocus="showMenu(this.id);" class="search_input" style="width:150px;" />
                                </div> -->
                                 <div class="search_group">
                                    <label>产品标题</label>
                                    <input type="text" id="linename" name="" class="search_input" style="width:120px;" />
                                </div>
                                   <div class="search_group">
                                    <label>价格</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:70px;" /> 至 <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:70px;" />
                                    
                                </div>
                                <div class="search_group">
                                    <label>出发地</label>
                                    <input type="text" id="startplace" name="" class="search_input" style="width:90px;" />
                                </div>
                               
                                <div class="search_group">
                                    <label>出团日期</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:90px;">
                                </div>
               
                                 <div class="search_group">
                                    <label>团号</label>
                                    <input type="text" id="linecode" name="" class="search_input" style="width:120px;" />
                                </div>
                                <div class="search_group">
                                    <label>行程天数</label>
                                    <input type="text" id="days_start" name="" class="search_input" style="float: none;width:70px;" /> 至 <input type="text" id="days_end" name="" class="search_input" placeholder="" style="float: none;width:70px;" />
                                    
                                </div>
                               
   
                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                              
                                
                            </div>
                            <div class="search_form_box clear" style="padding:0 0 10px 0;">
                            <span class="a_add btn btn_green" style="margin:3px 20px 0 0;">新增单项</span>
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
	var value="2"; //导航tab值
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
        //    var dest_id=$("#dest_id").attr("data-id");
            var type=$(".itab ul").attr("data-id"); //1是直属供应商，2是非直属供应商

            //接口数据
            var post_url="<?php echo base_url('admin/b1/line_single/api_single')?>";
            ajax_data={page:"1",type:type,startplace:startplace,linename:linename,linecode:linecode,starttime:starttime,endtime:endtime,days_start:days_start,days_end:days_end,price_start:price_start,price_end:price_end};
        	var list_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var total_page=list_data.data.total_page; //总页数
        	
        
        	//调用分页
        	laypage({
        	    cont: 'page_div',
        	    pages: total_page,
        	    jump: function(ret){

        	    	var html="";  //html内容
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
		        	
		        	if(value=="2")
			        	$(".tr_rows").html("<th>团号</th><th>产品标题</th><th>出发地</th><th>出团日期</th><th>供应商名称</th><th>成人价</th><th>儿童价</th><th>不占床儿童价</th><th>余位</th><th>已订人数</th><th>操作</th>");
		        	else if(value=="3")
		        		$(".tr_rows").html("<th>团号</th><th>产品标题</th><th>出发地</th><th>出团日期</th><th>供应商名称</th><th>成人价</th><th>儿童价</th><th>不占床儿童价</th><th>余位</th><th>已订人数</th>");
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
            //end
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	    var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {

        	        str += "<tr>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_update' data-id='"+data[i].id+"'>"+data[i].linecode+"</a></td>";
        	        str +=     "<td style='text-align:left;'>"+data[i].linename+"</td>";
        	        
        	        str +=     "<td>"+data[i].startplace+"</td>";
        	        str +=     "<td>"+data[i].day+"</td>";
        	       

        	        str +=     "<td style='text-align:left;'>"+data[i].company_name+"-"+data[i].brand+"</td>";
        	        str +=     "<td>"+data[i].adultprice+"</td>";
        	        str +=     "<td>"+data[i].childprice+"</td>";
        	        str +=     "<td>"+data[i].childnobedprice+"</td>";
        	       // str +=     "<td>"+data[i].room_fee+"</td>";
        	        str +=     "<td>"+data[i].number+"</td>";
        	   //     str +=     "<td>"+data[i].employee_name+"</td>";
        	        str +=     "<td>"+(data[i].total_dingnum==null?'0':data[i].total_dingnum)+"+"+(data[i].total_oldnum==null?'0':data[i].total_oldnum)+"+"+(data[i].total_childnobednum==null?'0':data[i].total_childnobednum)+"</td>";
        	       
        	        //操作
        	         var status_str="";
                   if(data[i].line_kind==3){
                  		status_str += "<a href='javascript:void(0)' class='a_update' data-id='"+data[i].id+"'>修改</a>&nbsp;&nbsp;";
                  		status_str += "<a href='javascript:void(0)' class='a_copy' data-id='"+data[i].id+"'>复制</a>&nbsp;&nbsp;";
                 		status_str += "<a href='javascript:void(0)' class='a_offline' line-id='"+data[i].line_id+"''>下线</a>";
                   }else{
                   		status_str += "<a href='javascript:void(0)' class='a_update' data-id='"+data[i].id+"'>查看</a>&nbsp;&nbsp;";
                   }
                   
                 
                   if(data[i].status=="2")
                   {
                 	  str +=     "<td>"+status_str+"</td>";
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
	//选择事件
	$(".itab ul li").click(function(){
		$(".itab ul li").find('a').removeClass('active');
		$(this).find('a').addClass('active');
		value=$(this).attr("static");
		if(value=="2")
		{		
			$(".a_add").show();
		}
		else if(value=="3")
		{

			$(".a_add").hide();
		}		
		$(".itab ul").attr("data-id",value);
		object.init();
   })
   
   
   $("#btn_submit").click(function(){
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
	//添加单项项目按钮
	$("body").on("click",".a_add",function(){
		layer.open({
		  type: 2,
		  //full:true,
		  area: ['960px', '650px'],
		  title :'新增单项',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b1/line_single/add_single');?>"
		});
	});
	//修改    on：用于绑定未创建内容
	$("body").on("click",".a_update",function(){
		var id=$(this).attr("data-id");
		layer.open({
		  title:"编辑",
		  type: 2,
		  area: ['960px', '650px'],  // 50%,90%
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b1/line_single/update_single');?>"+"?id="+id
		});
	});
	
	//供应商详情    on：用于绑定未创建内容
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("data-id");
		var supplier_name=$(this).html();
		
		window.top.openWin({
		  title:supplier_name,
		  type: 2,
		  area: ['46%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail');?>"+"?id="+supplier_id
		});
	});
	//下线    on：用于绑定未创建内容
	$("body").on("click",".a_offline",function(){
		var line_id=$(this).attr("line-id");
		layer.confirm('确定要下线该单项产品吗', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				var url="<?php echo base_url('admin/b1/line_single/api_line_offline');?>";
				var data={line_id:line_id}
				var return_data=object.send_ajax_noload(url,data);
				if(return_data.code=="2000")
				{
					//tan2(return_data.data);
					//setTimeout(function(){window.location.reload();},500);	
					window.location.reload();
				}
				else
				{
					tan(data.msg);
				}
			}, function(){
			  
			});
	});
	//复制   on：用于绑定未创建内容
	$("body").on("click",".a_copy",function(){
		var id=$(this).attr("data-id");
		layer.confirm('确定要复制该单项产品吗', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				var url="<?php echo base_url('admin/b1/line_single/api_single_copy');?>";
				var data={id:id}
				var return_data=object.send_ajax_noload(url,data);
				if(return_data.code=="2000")
				{
					//tan2(return_data.data);
					//setTimeout(function(){window.location.reload();},500);	
					window.location.reload();
				}
				else
				{
					tan(data.msg);
				}
			}, function(){
			  
			});
	});
	
});



</script>



<?php  //$this->load->view("admin/t33/common/dest_tree"); //加载树形目的地   ?>