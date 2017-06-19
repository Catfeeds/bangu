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
            <a href="#" class="main_page_link"><i></i>营业部管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">提现审核</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                     <li static="0"><a href="#tab1" class="active li_type">提现审核</a></li> 
					 <li static="1"><a href="#tab1" class="li_type">已通过</a></li> 
					 <li static="2"><a href="#tab1" class="li_type">已退回</a></li> 
					    
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                
                                 <div class="search_group">
                                    <label>申请日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value=""  style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:90px;">
       
                                </div>
                                <div class="search_group">
                                    <label>申请人：</label>
                                    <input type="text" id="expert_name" name="" class="search_input" style="width:90px;"/>
                                </div>
								<!-- <div class="search_group">
                                    <label>结算状态：</label>
                                    <div class="form_select">
                                        <div class="search_select div_status">
                                            <div class="show_select ul_status" data-value="0">待审核</div>
                                            <ul class="select_list">
                                                    <li data-value="-1">全部</li>
                                                    <li data-value="0">待审核</li>
	                                                <li data-value="1">已通过</li>
	                                                <li data-value="2">已拒绝</li>
	         
                                              
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                        </div>
                               </div> -->
                               <div class="search_group">
                                    <label>审核日期：</label>
                                    <input class="search_input" type="text" id="shen_start" data-date-format="yyyy-mm-dd" value="" style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="shen_end" data-date-format="yyyy-mm-dd" value="" style="float: none;width:90px;">
       
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
   
 <!-- 审核通过 弹层 -->
 <div class="fb-content" id="approve_div" style="display:none;">
    <div class="box-title">
        <h5>同意交款申请</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
           
            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">审核意见：</div>
                <div class="fg-input" style="width:80%;">
                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:160px;"></textarea>
                <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>
                </div>
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
        <h5>拒绝交款申请</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">拒绝原因：</div>
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
    var action="<?php echo $action;?>";
	type_value="0";  //类型：默认-1全部，0待审核，1已通过、2已拒绝
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var expert_name=$("#expert_name").val();
           
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var shen_start=$("#shen_start").val();
            var shen_end=$("#shen_end").val();
           

            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_exchange')?>";
        	ajax_data={page:"1",type:type_value,expert_name:expert_name,starttime:starttime,endtime:endtime,shen_start:shen_start,shen_end:shen_end};

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
			        	//$(".tr_rows").html("<th>编号</th><th>申请日期</th><th>流水号</th><th>银行名称</th><th>银行账户</th><th>持卡人</th><th>可提现金额</th><th>申请提现金额</th><th>申请人</th><th>状态</th><th>操作</th>");
		        	//else if(type_value=="1")
		        		//$(".tr_rows").html("<th>编号</th><th>申请日期</th><th>流水号</th><th>银行名称</th><th>银行账户</th><th>持卡人</th><th>可提现金额</th><th>申请提现金额</th><th>审核日期</th><th>申请人</th><th>状态</th><th>操作</th>");
		        	//else if(type_value=="2")
		        		$(".tr_rows").html("<th>编号</th><th>申请日期</th><th>流水号</th><th>银行名称</th><th>银行账户</th><th>持卡人</th><th>申请提现金额</th><th>审核日期</th><th>申请人</th><th>状态</th><th>操作</th>");

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
        	        str +=     "<td>"+data[i].addtime+"</td>";
          	        str +=     "<td>"+data[i].serial_number+"</td>";
          	        str +=     "<td>"+data[i].bankname+"</td>";
         	        str +=     "<td>"+data[i].bankcard+"</td>";
        	        str +=     "<td>"+data[i].cardholder+"</td>";
        	        //str +=     "<td>"+data[i].amount_before+"</td>";
        	        str +=     "<td style='color:#FF6537;'>"+data[i].amount+"</td>";

        	       /* if(type_value=="1"||type_value=="2")
        	        {
        	        str +=     "<td>"+data[i].modtime+"</td>";
        	        }*/

        	        str +=     "<td>"+data[i].modtime+"</td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";

        	        var status_str="";
        	        if(data[i].status=="0")
            	        status_str="待审核";
        	        else if(data[i].status=="1")
        	        	status_str="已通过";
        	        else if(data[i].status=="2")
        	        	status_str="已拒绝";
        	        str +=     "<td>"+status_str+"</td>";
        	       
        	       
        	        var do_str="<a href='javascript:void(0)' class='a_detail' action='1' data-id='"+data[i].id+"'>查看</a>";
        	        do_str += "<a href='javascript:void(0)' class='a_print' data-id='"+data[i].id+"'>打印</a>";
        	        if(data[i].status=="0"&&action!=2)
        	        {
	        	        do_str += "<a href='javascript:void(0)' class='a_detail' action='2' data-id='"+data[i].id+"'>审核</a>";
        	        }
        	       
        	        str +=     "<td>"+do_str+"</td>";
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
    //tap
	$(".itab ul li").click(function(){
		 type_value=$(this).attr("static");
		 flag=true;
		 object.init();
		
	})
   $("#btn_submit").click(function(){
	   flag=true;
	   object.init();
	})
   
     //select 
	$/* (".div_status ul li").click(function(){
		var value=$(this).attr("data-value");
		type_value=value;
		$(".div_status .ul_status").attr("data-value",value);
	}) */
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


	//查看、审核按钮
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		var action=$(this).attr("action");
		if(action=="1")
		{
			var title="详情";
			var height="220px";
		}
		else
		{
			var title="审核";
			var height="480px";
		}
		window.top.openWin({
		  type: 2,
		  area: ['640px', height],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/exchange_detail');?>"+"/"+id+"/"+action
		});
	});

	//打印单条
	$("body").on("click",".a_print",function(){
		var id=$(this).attr("data-id");
		
		var win1 = window.open("<?php echo base_url('admin/t33/sys/approve/print_exchange');?>"+"?id="+id,'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});


});

function getValue(){
	window.location.reload();
}

</script>
</html>


