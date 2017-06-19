<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.layui-layer-page { margin-left:0 !important;}
</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/depart_tree"); //加载树形营业部   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    

        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="width:auto;min-width:auto;">
                                <div class="search_group">
                                    <label>名称</label>
                                    <input type="text" id="server_name" name="" class="search_input"/>
                                </div>

                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                                <span class="add_depart btn btn_green" style="margin:3px 20px 0 0;">添加服务类型</span>
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                	<th>序号</th>
                                    <th>服务类型名称</th>
                                    <th>描述</th>
                                    <th>排序</th>
                                    <th>操作时间</th>
                                    <th>操作</th>
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
   


 <!-- 添加营业部 弹层 -->
 <div class="fb-content" id="depart_div" style="display:none;">
    <div class="box-title">
        <h5>添加服务类型</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
           <div class="form-group">
                <div class="fg-title" style="width:18%;">服务名称：<i>*</i></div>
                <div class="fg-input" style="width:71%;"><input type="text" id="server_name" class="showorder" name="showorder"></div>
            </div>
            <div class="form-group">
                <div class="fg-title" style="width:18%;">排序：<i>*</i></div>
                <div class="fg-input" style="width:77%;"><input type="text" id="showorder" class="showorder" value="999"></div>
            </div>
          
             <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:24%;">描述：</div>
                <div class="fg-input" style="width:77%;"><textarea name=""remark"" id="remark" maxlength="30" placeholder="描述" style="height:160px;"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_add_server" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>


<script type="text/javascript">

	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var name=$("#name").val();
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/line/api_server_range')?>";
        	ajax_data={page:"1",name:name};
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
        	        str +=     "<td>"+(i+1)+"</td>";
           	        str +=     "<td>"+data[i].server_name+"</td>";
        	        str +=     "<td>"+data[i].description+"</td>";
        	        str +=     "<td>"+data[i].showorder+"</td>";
        	        str +=     "<td>"+data[i].modtime+"</td>";

        	        //操作
                   str +=     "<td><a href='javascript:void(0)' class='a_delete' data-id='"+data[i].id+"'>删除</a></td>";
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

var iframeid="<?php echo $iframeid;?>";

$(function(){
	object.init();
   
   $("#btn_submit").click(function(){
	   object.init();
	})
	//添加服务类型
	$(".add_depart").click(function(){
		
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '500px',
			  //skin: 'layui-layer-nobg', //没有背景色
			  shadeClose: false,
			  content: $('#depart_div')
			});
		
	});
    //删除    on：用于绑定未创建内容
	$("body").on("click",".a_delete",function(){
	    var id=$(this).attr("data-id");
	    var url="<?php echo base_url('admin/t33/sys/line/api_del_server');?>";
        var data={id:id};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	window.parent.document.getElementById(iframeid).contentWindow.fresh_server();
        	
        	t33_close();
			tan2(return_data.data);
			t33_refresh();
			
        }
        else
        {
            tan(return_data.msg);
        }
	});
	//添加服务提交按钮
	$("body").on("click",".btn_add_server",function(){

		var server_name=$("#depart_div #server_name").val();
		var showorder=$("#depart_div #showorder").val();

		var remark=$("#depart_div #remark").val();
        if(server_name=="") {tan('请填写服务类型名称');return false;}
        if(showorder=="") {tan('请填写排序');return false;}
    
        var url="<?php echo base_url('admin/t33/sys/line/api_add_server');?>";
        var data={server_name:server_name,showorder:showorder,remark:remark};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	window.parent.document.getElementById(iframeid).contentWindow.fresh_server(); //刷新父级容器
        	t33_close();
			tan2(return_data.data);
			t33_refresh();
        }
        else
        {
            tan(return_data.msg);
        }
		
	})



});



</script>
</html>


