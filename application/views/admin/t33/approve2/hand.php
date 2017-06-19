<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">



.not-allow{cursor:not-allowed !important;opacity:0.5;}

.itab ul li{list-style:inherit !important;}  /* tab内容 出现 。符号  */
.add_table{float:left;font-size:16px;cursor:pointer;margin-left:5px;}
.delete_table{float:left;font-size:10px;cursor:pointer;margin-left:5px;}

.new_table{width:94% !important;margin:10px 0 10px 6% !important;}
.new_table tr th{font-weight:normal;}

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/depart_tree"); //加载树形营业部   ?>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>交款结算管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">交款登记及确认</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab" data-id="1">
                  <ul> 
                     <li static="1"><a href="javascript:void(0)" class="active li_type">未确认</a></li> 
					 <li static="2"><a href="javascript:void(0)" class="li_type">已通过</a></li> 
					 <li static="3"><a href="javascript:void(0)" class="li_type">已退回</a></li>  
					  
                  </ul> 
                   
                </div>
                <div class="tab_content" style="padding-bottom:10px;">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="padding-right:0;">
                               <!-- 
                               <div class="search_group" style="width:56px;">
                               		<span class="a_add btn btn_green" style="margin:3px 20px 0 0px;">新增交款</span>
                               </div> -->
                               <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 74px;'>申请部门：</label>
                                    <input type="text" id="depart_id" onfocus="showMenu(this.id,this.value);" onkeyup="showMenu(this.id,this.value);" placeholder="输入关键字搜索" class="search_input" data-id="" style="width:178px;">

                                </div>                                
                               
                               <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 50px;'>订单号：</label>
                                    <input type="text" id="ordersn" name="" class="search_input" style="width:70px;"/>
                                </div>
                                <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 64px;'>交款金额：</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:78px;" /> ~ <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:78px;" />      
                                </div>
                                
                                <!-- 搜索按钮 -->
                                <div class="search_group" style="width:56px;">
                                    <input type="button" id="btn_submit" name="submit" style='margin-left:0px;' class="search_button" value="搜索"/>
                                </div>
                              	 <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 74px;'>申请日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value=""  style="float: none;width:78px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:78px;">
       
                                </div> 
                                 <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 50px;'>申请人：</label>
                                    <input type="text" id="expert_name" name="" class="search_input" style="width:70px;"/>
                                </div>
								
                               <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 64px;'>审核日期：</label>
                                    <input class="search_input" type="text" id="shen_start" data-date-format="yyyy-mm-dd" value="" style="float: none;width:78px;"> ~ <input class="search_input" type="text" id="shen_end" data-date-format="yyyy-mm-dd" value="" style="float: none;width:78px;">
       
                                </div>
                               <div class="search_group" style="margin-right:10px;">
                                    <label style='width: 40px;'>团号：</label>
                                    <input type="text" id="team_code" name="" class="search_input" style="width:100px;"/>
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
                 <?php if($action!="2"):?>
                <div class="div_submit" style="float: left;width:100%;margin:0 0 10px 0;">
                <a href='javascript:void(0)' class="checkall" style='float:left;margin:8px 5px 0 10px;'>全选</a>
                <a href='javascript:void(0)' class="notcheckall" style='float:left;margin:8px 20px 0 0px;'>反选</a>
                <span class="btn_hand btn btn_green" style="float:left;">提交</span>
               </div>
              <?php endif;?>
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

 <!-- 图片放大  弹层 -->
 <div class="fb-content" id="big_pic" style="display:none;/*height:350px;*/">
    <div class="box-title">
        <h5>流水单</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
       <img src="" class="a_img" style="height:400px;" />
    </div>
</div>

<script type="text/javascript">
    var action="<?php  echo $action;?> ";
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	var type_value="1";
	object = {
        init:function(){ //初始化方法
            var expert_name=$("#expert_name").val();
           
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            var shen_start=$("#shen_start").val();
            var shen_end=$("#shen_end").val();
            var depart_id=$("#depart_id").attr("data-id");
            var ordersn=$("#ordersn").val();
            var type_value=$(".itab").attr("data-id");
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            var ordersn=$("#ordersn").val();
            var team_code=$("#team_code").val();
            
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve2/api_hand')?>";
        	ajax_data={page:"1",type:type_value,team_code:team_code,ordersn:ordersn,depart_id:depart_id,ordersn:ordersn,expert_name:expert_name,starttime:starttime,endtime:endtime,shen_start:shen_start,shen_end:shen_end,price_start:price_start,price_end:price_end};
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
		        	if(type_value=="1")
			        	$(".tr_rows").html("<th style='width:30px;'></th><th style='width:30px;'></th><th width='76px'>操作</th><th width='60px'>订单号</th><th width='60'>销售姓名</th><th width='120'>营业部门</th><th width='60'>交款金额</th><th width='130'>团号</th><th>备注</th><th width='126'>申请时间</th><th width='50'>状态</th>");
		        	else if(type_value=="2")
		        		$(".tr_rows").html("<th style='width:30px;'></th><th width='76px'>操作</th><th width='60px'>订单号</th><th width='60'>销售姓名</th><th width='120'>营业部门</th><th width='60'>交款金额</th><th width='70'>团号</th><th>备注</th><th>申请时间</th><th width='50'>状态</th><th>审核时间</th><th width='50'>审核人</th><th>审核意见</th>");
		        	else if(type_value=="3")
		        		$(".tr_rows").html("<th style='width:30px;'></th><th width='76px'>操作</th><th width='60px'>订单号</th><th width='60'>销售姓名</th><th width='120'>营业部门</th><th width='60'>交款金额</th><th width='70'>团号</th><th>备注</th><th>申请时间</th><th width='50'>状态</th><th>审核时间</th><th width='50'>审核人</th><th>审核意见</th>");

		        	//写html内容
		        	if(return_data.code=="2000")
		        	{
	                	html=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
	                	$(".no-data").hide();
	                	if(type_value=="1")
	                	    $(".div_submit").show();
	                	else
	                		$(".div_submit").hide();
		        	}
		        	else if(return_data.code=="4001")
		        	{
			        	html="";
			        	$(".div_submit").hide();
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
                
        	        var class_str="";
         	        var disabled_str="";
         	        if(data[i].approve_status!="1")
         	        {
         	        class_str="not-allow";
         	        disabled_str="disabled";
         	        }
         	        var input_str="<input type='checkbox' class='input_check "+ class_str +"' "+disabled_str+" data-id='"+data[i].batch+"' order-id='"+data[i].order_id+"' style='margin:0 !important;' />";
         	        
         	        if(type_value=="1"&&action!=2)
         	        str +=     "<td style='text-align:center;'>"+input_str+"</td>"; 
         	        
         	       var span_str="<span class='btn_open add_table' data-id='"+data[i].batch+"' order-id='"+data[i].order_id+"'>+</span>";
       	            str +=     "<td>"+span_str+"</td>";
        	        var do_str="<a href='javascript:void(0)' class='a_detail' action='1' data-id='"+data[i].batch+"' order-id='"+data[i].order_id+"'>查看</a>";

        	        if(data[i].approve_status=="1" && action!=2)
        	        {
        	            do_str += "<a href='javascript:void(0)' class='a_detail a_shenhe' action='2' data-id='"+data[i].batch+"' order-id='"+data[i].order_id+"'>审核</a>";
        	        }
             	    if(data[i].approve_status=="2")
            	        do_str += "<a href='javascript:void(0)' class='a_print' action='1' data-id='"+data[i].batch+"' order-id='"+data[i].order_id+"'>打印</a>";
        	        str +=     "<td>"+do_str+"</td>";

        	        var is_urgent="";
        	        if(data[i].total_is_urgent>0)
        	        	is_urgent="<span style='color:red;'>(急)</span>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].order_sn+"</a>"+is_urgent+"</td>";
        	        
        	       
        	       /*  str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].batch+"' order-id='"+data[i].order_id+"'>"+data[i].batch+"</a>"+is_urgent+"</td>"; */
        	        
        	        
        	        str +=     "<td>"+data[i].expert_name+"</td>";
         	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td style='color:#FF6537;'>"+data[i].total_amount+"</td>";
        	       
        	        str +=     "<td>"+data[i].team_code+"</td>";
        	        str +=     "<td>"+data[i].remark+"</td>";

        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        
        	        var status_str="";
                    if(data[i].approve_status=="1")
                    	status_str="待审核";
                    else if(data[i].approve_status=="2")
                    	status_str="已通过";
                    else if(data[i].approve_status=="3")
                    	status_str="已拒绝";
                    str +=     "<td>"+status_str+"</td>";

                    if(data[i].approve_status=="2"||data[i].approve_status=="3")
                    {
        	        str +=     "<td>"+data[i].modtime+"</td>";
    	        	str +=     "<td>"+data[i].employee_name+"</td>";
    	        	str +=     "<td>"+data[i].reply+"</td>";
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
    //select 
	$(".itab ul li").click(function(){
		var value=$(this).attr("static");
		type_value=value;
		$(".itab").attr("data-id",value);
		flag=true;
		object.init();
		
	})
   $("#btn_submit").click(function(){
	   flag=true;
	   object.init();
	})
   
     //select 
	$(".div_status ul li").click(function(){
		var value=$(this).attr("value");
		$(".div_status .ul_status").attr("data-value",value);
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


	//查看、审核按钮
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		var order_id=$(this).attr("order-id");
		var action=$(this).attr("action");
		if(action=="1")
		{
			var title="详情";
			var height="550px";
		}
		else
		{
			var title="审核";
			var height="550px";
		}
		window.top.openWin({
		  type: 2,
		  area: ['860px', height],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/hand_submit2');?>"+"?batch="+id+"&order_id="+order_id+"&action="+action+"&status="+type_value
		});
	});
	//查看、审核按钮(单条)
	$("body").on("click",".a_one_detail",function(){
		var id=$(this).attr("data-id");
		var action=$(this).attr("action");
		if(action=="1")
		{
			var title="详情";
			var height="350px";
		}
		else
		{
			var title="审核";
			var height="350px";
		}
		window.top.openWin({
		  type: 2,
		  area: ['680px', height],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/hand_detail');?>"+"?id="+id+"&action="+action
		});
	});
	//打印多条
	$("body").on("click",".a_print",function(){
		var id=$(this).attr("data-id");
		var order_id=$(this).attr("order-id");
		/*
		window.top.openWin({
		  type: 2,
		  area: ['900px', "550px"],
		  title :"打印预览",
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/hand_print');?>"+"?id="+id+"&status="+type_value
		});*/
		var win1 = window.open("<?php echo base_url('admin/t33/sys/approve2/hand_print');?>"+"?batch="+id+"&order_id="+order_id+"&status="+type_value,'print','height=1090,width=710,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});
	//打印单条
	$("body").on("click",".a_print_one",function(){
		var id=$(this).attr("data-id");
		/*
		window.top.openWin({
		  type: 2,
		  area: ['900px', "550px"],
		  title :"打印预览",
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/hand_print');?>"+"?id="+id+"&status="+type_value
		});*/
		var win1 = window.open("<?php echo base_url('admin/t33/sys/approve2/hand_print_one');?>"+"?id="+id+"&status="+type_value,'print','height=1090,width=765,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
		win1.focus();
	});
	//添加按钮
	$("body").on("click",".a_add",function(){
		window.top.openWin({
		  type: 2,
		  area: ['820px', '500px'],
		  title :'新增收款',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve2/hand_add');?>"
		});
	});
	 //订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("data-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['70%', '90%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
		});
	});
	//供应商详情    on：用于绑定未创建内容
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("data-id");
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
	//全选
	$("body").on("click",".checkall",function(){
	
	       $(".input_check").each(function(index,data){
	    	   $(this).attr("checked",true);
	    	  
		      })

	});
	//反选
	$("body").on("click",".notcheckall",function(){
	
	       $(".input_check").each(function(index,data){
	    	   if($(this).is(':checked'))
			   {
	    	       $(this).attr("checked",false);
			   }
	    	   else
	    	   {
	    		   $(this).attr("checked",true);
	    	   }
	    	  
		      })

	});
	//提交按钮
	$("body").on("click",".btn_hand",function(){
		 var list="";
	     $(".input_check").each(function(index,data){
	     if($(this).is(':checked'))
		 {
			 var value=$(this).attr("data-id");
			 if(value!=""&&value!=null)
			 list=value+","+list;
		   }	  
		 })
		if(list.length==0)  {tan('请勾选要申请的交款');return false;}
		//添加按钮
		 window.top.openWin({
			  type: 2,
			  area: ['900px', '550px'],
			  title :'交款审核',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/t33/sys/approve2/hand_submit2');?>"+"?ids="+list+"&action=2"+"&status="+type_value
			});
		
	});
	//点击团号
	$("body").on("click",".a_teamcode",function(){
		var team_code=$(this).attr("data-id");
		//添加按钮
		 window.top.openWin({
			  type: 2,
			  area: ['1024px', '540px'],
			  title :'列表',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/t33/sys/approve2/hand_team_list');?>"+"?team_code="+team_code
			});
		
	});
	//图片放大
	$("body").on("click",".a_pic",function(){
		var a_img=$(this).attr("data-id");
		var bangu_url="<?php echo BANGU_URL ?>";
		
		$(".a_img").attr("src",bangu_url+a_img);
	    layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '500px',
			  shadeClose: false,
			  content: $('#big_pic')
			});
	});
	//展开表格
	$("body").on("click",".add_table",function(){
		var id=$(this).attr("data-id");
		var order_id=$(this).attr("order-id");
		var url="<?php echo base_url('admin/t33/sys/approve2/api_hand_detail');?>";
	    var data={batch:id,order_id:order_id,status:type_value};
	    var return_data=object.send_ajax_noload(url,data);
	    var tr_str="";
	    if(return_data.code=="2000")
	    {
		     for(var i in return_data.data.result)
		    {
		    	tr_str+="<tr>";

                var do_str="";
                do_str += "<a href='javascript:void(0)' class='a_print_one' action='1' data-id='"+return_data.data.result[i].id+"'>打印</a>";
                /* tr_str+="<td>"+do_str+"</td>"; */
                
		        var is_urgent="";
    	        if(return_data.data.result[i].is_urgent==1)
    	        	is_urgent="<span style='color:red;'>(急)</span>";
    	        	
		    	tr_str+="<td><a href='javascript:void(0)' class='a_one_detail' action='1' data-id='"+return_data.data.result[i].id+"'>"+return_data.data.result[i].id+"</a>"+is_urgent+"</td>";
		    	tr_str+="<td style='color:#FF6537;'>"+return_data.data.result[i].money+"</td>";
		    	tr_str+="<td>"+return_data.data.result[i].expert_name+"</td>";
		    	tr_str+="<td>"+return_data.data.result[i].depart_name+"</td>";
		    	tr_str+="<td>"+return_data.data.result[i].remark+"</td>";
		    	tr_str+="<td><a href='javascript:void(0)' class='a_order' data-id='"+return_data.data.result[i].order_id+"'>"+return_data.data.result[i].order_sn+"</a></td>";
		    	tr_str+="<td><a href='javascript:void(0)' class='a_teamcode' data-id='"+return_data.data.result[i].item_code+"'>"+return_data.data.result[i].item_code+"</a></td>";
		    	//tr_str+="<td>"+return_data.data.result[i].way+"</td>";
		    	tr_str+="<td><a href='javascript:void(0)' class='a_supplier' data-id='"+return_data.data.result[i].supplier_id+"'>"+return_data.data.result[i].brand+"</td>";
		    	//tr_str+="<td>"+return_data.data.result[i].supplier_fuze+"</td>";
		    	tr_str+="<td>"+return_data.data.result[i].code+"</td>";
		    	tr_str+="<td><a href='javascript:void(0)' class='a_pic' data-id='"+return_data.data.result[i].code_pic+"'>流水单</a></td>";
		    	
		    	tr_str+="<td>"+return_data.data.result[i].addtime+"</td>";
		    	var zt_str="";
		    	if(return_data.data.result[i].status=="1")
		    		zt_str="待审核";
		    	else if(return_data.data.result[i].status=="2")
		    		zt_str="已通过";
		    	else if(return_data.data.result[i].status=="3")
		    		zt_str="已拒绝";
		    	tr_str+="<td>"+zt_str+"</td>";
		    	tr_str+="</tr>";
			} 
	    	
	    }
	    else if(return_data.code=="4001")
	    {
	    	
	    }

		var html="";
		cols_num="11";
		  if(type_value!="0") cols_num="14";
		html+="<tr><td colspan='"+cols_num+"'><table class='table table-bordered table_hover new_table'>";
		html+="<th>编号</th><th>交款金额</th><th>销售姓名</th><th>营业部</th><th>备注</th><th>订单号</th><th>团号</th><th>供应商</th><th>凭证号</th><th>流水单</th><th>申请时间</th><th>状态</th>";
		html+=tr_str;
		html+="</table></td></tr>";
		$(this).parent().parent().after(html);
		$(this).text("—");
		$(this).addClass("delete_table").removeClass("add_table");
	});
	//展开表格
	$("body").on("click",".delete_table",function(){
		$(this).parent().parent().next().remove();
		$(this).text("+");
		$(this).addClass("add_table").removeClass("delete_table");
	})
	


});

//供弹窗层调用
function parentfun(id){
	var arr=id.split(",");
	for(var i=0;i<arr.length;i++)
	{
		//alert(arr[i])
		//receivable_num
		var url="<?php echo base_url('admin/t33/sys/approve2/receivable_num');?>";
	    var data={id:arr[i],status:'1'};
	    var return_data=object.send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
		    //if(return_data.data=="0")
	    	//$(".a_shenhe[data-id="+arr[i]+"]").hide();
	    }
	    else if(return_data.code=="4001")
	    {
	    	$(".a_shenhe[data-id="+arr[i]+"]").hide();
	    }
	    else
	    {
		}
		
	}
	
}

</script>
</html>


