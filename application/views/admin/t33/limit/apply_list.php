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
            <a href="#"><?php if(empty($action)) echo "单团额度审批";else echo "单团额度查询";?></a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" data-id="1" class="active li_type"><?php if(empty($action)) echo "单团额度审批";else echo "单团额度查询";?></a></li> 
					<!--     <li static="1"><a href="#tab1" data-id="3" class="li_type">已通过</a></li> 
					    <li static="1"><a href="#tab1" data-id="4" class="li_type">已还款</a></li> 
					    <li static="1"><a href="#tab1" data-id="5" class="li_type">已拒绝</a></li>  -->
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">           
                               <div class="search_group">
                                    <label>营业部：</label>
                                    <input type="text" id="depart_id" onfocus="showMenu(this.id);" class="search_input" data-id="" style="width:202px;">

                                </div>                             	
                                <div class="search_group">
                                    <label>经理姓名：</label>
                                    <input type="text" id="manager_name" name="" class="search_input" style="width:90px;"/>
                                </div>
                                <div class="search_group">
                                    <label>申请人：</label>
                                    <input type="text" id="expert_name" name="" class="search_input" style="width:90px;"/>
                                </div>
                                 <div class="search_group">
                                    <label>申请日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:80px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" placeholder="" style="float: none;width:80px;">
                                    
                                    
                                </div>
                                <div class="search_group">
                                    <label>审核状态：</label>
                                    <div class="form_select">
                                        <div class="search_select div_status">
                                            <div class="show_select ul_status" data-value="1" style="width:70px;">待审核</div>
                                            <ul class="select_list">
                                                    
                                                    <li data-value="-2">全部</li>
	                                                <li data-value="1">待审核</li>
	                                                <li data-value="3">已通过</li>
	                                                <li data-value="4">已还款</li>
	                                                <li data-value="5">已拒绝</li>
	                                               
                                              
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
                                <tr class="tr_rows">
                                	<th>申请编号</th>
                                    <th>申请人</th>
                                    <th>申请的信用额度</th>
                                    <th>已交款</th>
                                    <th>订单编号</th>
                                    <th>营业部门</th>
                                    <th>经理姓名</th>
                                    <th>供应商</th>
                                    <th>申请时间</th>
                                    <th>申请备注</th>
                                    <th>经理审核时间</th>
                                   
                                    <th>经理审批备注</th>
                                   
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
   
 <!-- 审核通过 弹层 -->
 <div class="fb-content" id="approve_div" style="display:none;">
    <div class="box-title">
        <h5>同意申请</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">审核意见：<i>*</i></div>
                <div class="fg-input" style="width:80%;"><textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:160px;"></textarea></div>
            </div>
        
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_approve" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
 <!-- 额度审核拒绝  弹层 -->
 <div class="fb-content" id="refuse_div" style="display:none;">
    <div class="box-title">
        <h5>拒绝申请</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">拒绝原因：<i>*</i></div>
                <div class="fg-input" style="width:80%;"><textarea name="beizhu" id="refuse_reply" maxlength="30" placeholder="请填写拒绝原因" style="height:160px;"></textarea></div>
            </div>
        
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_refuse" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>



<script type="text/javascript">
	type_value="1";  //类型：默认-2全部，1申请中，3已通过、4已还款、5已拒绝   
	var action=" <?php echo $action;?>";
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var expert_name=$("#expert_name").val();
            var manager_name=$("#manager_name").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var depart_id=$("#depart_id").attr("data-id");

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/limit/api_apply')?>";
        	ajax_data={page:"1",type:type_value,depart_id:depart_id,expert_name:expert_name,manager_name:manager_name,starttime:starttime,endtime:endtime};

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
		        	
			       if(action==2) //没有操作按钮
			        	$(".tr_rows").html("<th>申请编号</th><th>申请人</th> <th>申请的信用额度</th><th>已交款</th> <th>订单编号</th> <th>营业部门</th> <th>申请时间</th><th>还款时间</th><th>申请备注</th><th>状态</th><th>旅行社审批回复</th><th>审批人</th>");
				   else  
			    	   $(".tr_rows").html("<th>申请编号</th><th>申请人</th> <th>申请的信用额度</th><th>已交款</th> <th>订单编号</th> <th>营业部门</th> <th>申请时间</th><th>还款时间</th><th>申请备注</th><th>状态</th><th>旅行社审批回复</th><th>审批人</th><th>操作</th>");

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
        	        str +=     "<td>"+data[i].id+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_expert' data-id='"+data[i].expert_id+"' data-title='"+data[i].expert_name+"'>"+data[i].expert_name+"</a></td>";
        	        str +=     "<td style='color:#FF6537;'>"+data[i].credit_limit+"</td>";

         	        var receive_price="0.00";
         	        if(data[i].receive_price!="")
         	        	receive_price=data[i].receive_price;
        	        str +=     "<td>"+toDecimal2(receive_price)+"</td>";
        	        
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"' >"+data[i].ordersn+"</a></td>";
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	       
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        str +=     "<td>"+data[i].return_time+"</td>";
        	        str +=     "<td>"+data[i].remark+"</td>";

        	        var status_str="";
                    if(data[i].status=="1")
                    	status_str="待审核";
                    else if(data[i].status=="3")
                    	status_str="已通过";
                    else if(data[i].status=="4")
                    	status_str="已还款";
                    else if(data[i].status=="5")
                    	status_str="未还款";
                    else if(data[i].status=="-1")
                    	status_str="已撤销";
                    else if(data[i].status=="0")
                    	status_str="申请中";
                    str +=     "<td>"+status_str+"</td>";
                    str +=     "<td>"+data[i].reply+"</td>";
                    str +=     "<td>"+data[i].realname+"</td>";
                    
	        	    /*if(type_value=="3"||type_value=="4"||type_value=="5")
	        	    {
	                    str +=     "<td>"+data[i].reply+"</td>";
	                    str +=     "<td>"+data[i].realname+"</td>";
	        	    }*/
        	      
        	        //操作
        	        var approve_str="<a href='javascript:void(0)' class='a_detail' action='1' data-id='"+data[i].id+"'>查看</a>";
	        	    if(data[i].status=="1")
	        	    {
	                   approve_str+="<a href='javascript:void(0)' class='a_detail a_shenhe' action='2' data-id='"+data[i].id+"'>审核</a>";
	           
	        	    }
	        	   
	        	    if(action!=2)
	        	    str +=     "<td>"+approve_str+"</td>";
	        	    
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
	

	//销售详情    on：用于绑定未创建内容
	$("body").on("click",".a_expert",function(){
		var expert_id=$(this).attr("data-id");
		var expert_name=$(this).attr("data-title");
		window.top.openWin({
		  title:expert_name,
		  type: 2,
		  area: ['840px', '600px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/expert/detail');?>"+"?id="+expert_id
		});
	});
	//审核    on：用于绑定未创建内容
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		var action=$(this).attr("action");
		var title="";
		if(action=="1")
		{
			title="详情";
			var height="340px";
		}
		else
		{
			title="额度审批";
			var height="570px";
		}
		window.top.openWin({
		  title:title,
		  type: 2,
		  area: ['800px', height],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/limit/apply_detail');?>"+"?id="+id+"&action="+action
		});
	});
	//订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("data-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['850px', '90%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id+"&action=2"
		});
	});
	


});


//供弹窗层调用
function parentfun(id){
	
	$(".a_shenhe[data-id="+id+"]").hide();
	
}
</script>
</html>


