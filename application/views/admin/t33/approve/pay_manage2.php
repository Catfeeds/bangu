<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
.show_select


.table>thead>tr>th, .table>tbody>tr>td {
padding: 3px 1px !important; 
}

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>付款管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">付款管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                    <li static="1"><a href="#tab1" data-id="0" class="active li_type">付款管理列表</a></li> 
                       <!--  <li static="1"><a href="#tab1" data-id="0" class="active li_type">付款申请</a></li> 
					    <li static="1"><a href="#tab1" data-id="1" class="li_type">已付款</a></li> 
					    <li static="1"><a href="#tab1" data-id="2" class="li_type">已拒绝</a></li>  -->
					    
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                              
                               
							  <div class="search_group" style="margin-right:10px;">
                                    <label>付款状态：</label>
                                    <div class="form_select" style="margin-right:0">
                                        <div class="search_select div_status">
                                            <div class="show_select ul_status" data-value="2" style="width:126px;width:96px;">待付款</div>
                                            <ul class="select_list">
                                                    <li data-value="-1">全部</li>
                                                    <li data-value="2">待付款</li>
	                                                <li data-value="4">已付款</li>
	                                                <li data-value="5">已拒绝</li>
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                        </div>
                               </div>
                               <div class="search_group" style="margin-right: 10px;">
                                    <label style="width: 64px;">产品名称：</label>
                                    <input type="text" id="productname" name="" class="search_input" placeholder="" style="width:90px;"/>
                                </div>
                                <div class="search_group" style="margin-right: 10px;">
                                    <label style="width: 64px;">出团日期：</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value=""  style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:90px;">
                                </div>
                                <div class="search_group" style="margin-right:10;">
                                    <label style="width: 40px;">金额：</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:60px;" /> ~ <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:60px;" />
                                    
                                </div>
                                
                                 <div class="search_group" style="margin-right: 10px;">
                                    <label >订单号：</label>
                                    <input type="text" id="ordersn" name="" class="search_input" style="width:90px;"/>
                                </div>
                                
                                 <div class="search_group" style="margin-right: 10px;">
                                    <label style="width: 50px;">供应商：</label>
                                    <input type="text" id="supplier_name" name="" class="search_input" style="width:105px;"/>
                                </div>
                                 <div class="search_group" style="margin-right: 10px;">
                                    <label style="width: 40px;">团号：</label>
                                    <input type="text" id="team_code" name="" class="search_input" style="width:90px;"/>
                                </div>
                                <div class="search_group" style="margin-right: 10px;">
                                    <label style="width: 50px;">申请人：</label>
                                    <input type="text" id="commit_name" name="" class="search_input" placeholder="" style="width:70px;"/>
                                </div>
                                 <div class="search_group" style="margin-right: 10px;">
                                    <label style="width: 64px;">付款单号：</label>
                                    <input type="text" id="payable_id" name="" class="search_input" placeholder="" style="width:70px;"/>
                                </div>
                               <!-- 搜索按钮 -->
                                <div class="search_group" style="margin-right:0;">
                                    <input type="button" id="btn_submit" name="submit" style='margin-left: 0;' class="search_button" value="搜索"/>
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
                 <!-- 分页 -->
                <div id="foot_page">
                 <div id="page_div"></div>
                 <div class="pagesize_div">
		           <label><span>每页显示</span><input class='pagesize' type='text' /><span>条</span></label>
		          </div>
                </div>
                <!-- 分页 -->
            </div>

        </div>
        
    </div>
   
 <!-- 审核通过 弹层 -->
 <div class="fb-content" id="approve_div" style="display:none;">
    <div class="box-title">
        <h5>同意付款申请</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
           
            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%">审核意见：</div>
                <div class="fg-input" style="width:80%;">
                <textarea name="beizhu" id="reply" maxlength="30" placeholder="请填写审核意见" style="height:160px;"></textarea>
                <!--  <p style="font-size: 12px;">（审核通过后，若该交款下的订单有未还款的信用额度，将先进行偿还，剩余金额再存入现金额度）</p>-->
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
        <h5>拒绝付款申请</h5>
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
	type_value="2";  //类型：默认2（待付款），4已付款、5已拒绝
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var item_company=$("#item_company").val();
            var supplier_name=$("#supplier_name").val();
            var starttime=$("#starttime").val();
            var endtime=$("#endtime").val();
            
            var ordersn=$("#ordersn").val();
            var team_code=$("#team_code").val();

            var productname=$("#productname").val();
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            var commit_name=$("#commit_name").val();
            var payable_id=$("#payable_id").val();
            
            var pagesize=$(".pagesize").val();
            if(pagesize!=""&&typeof(pagesize)!="undefined")
            {
            if(parseInt(pagesize)!=pagesize) {tan('每页显示条数必须是整数');return false;}
            }
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_pay_manage2')?>";
        	ajax_data={page:"1",pagesize:pagesize,type:type_value,payable_id:payable_id,supplier_name:supplier_name,starttime:starttime,endtime:endtime,productname:productname,price_start:price_start,price_end:price_end,team_code:team_code,ordersn:ordersn,commit_name:commit_name};

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
			        	//$(".tr_rows").html("<th>编号</th><th>供应商</th><th>付款金额</th><th>收款单位</th><th>银行名称</th><th>支行</th><th>银行卡号</th><th>备注</th><th>申请时间</th><th>操作</th>");
		        	//else if(type_value=="1")
		        		//$(".tr_rows").html("<th>编号</th><th>供应商</th><th>付款金额</th><th>收款单位</th><th>银行名称</th><th>支行</th><th>银行卡号</th><th>备注</th><th>申请时间</th><th>旅行社审核时间</th><th>审核人姓名</th><th>旅行社回复</th><th>操作</th>");
		        	//else if(type_value=="2")

		        		$(".tr_rows").html("<th></th><th>付款单号</th><th>团号</th><th>订单号</th><th>产品名称</th><th>出团日期</th><th>订单成本</th><th>结算价</th><th>申请金额</th><th>已结算</th><th>操作费</th><th>未结算</th><th>结算方式</th><th>销售员</th><th>销售部门</th><th>审核状态</th>");


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

        	        var do_str="<a href='javascript:void(0)' class='a_detail' action='1' data-id='"+data[i].id+"'>查看</a>";

        	        if(data[i].status=="2")
        	        do_str += "<a href='javascript:void(0)' class='a_detail a_shenhe' action='2' data-id='"+data[i].id+"'>审核</a>";

        	        if(data[i].status=="2"||data[i].status=="4")
        	        {
        	        	do_str += "<a href='javascript:void(0)' class='a_detail a_back' action='3' data-id='"+data[i].id+"'>退回</a>";
            	    }
        	        str +=     "<td style='width:50px;'>"+do_str+"</td>";
        	        str +=     "<td style='width:40px;'>"+data[i].payable_id+"</td>";
        	        str +=     "<td style='width:136px;'><a href='javascript:void(0)' class='a_team' data-id='"+data[i].item_code+"'>"+data[i].item_code+"</a></td>";
        	        
        	      

        	       /*  str +=     "<td style='width:40px;'>"+data[i].apply_percent+"</td>"; */

        	        str +=     "<td style='width:80px;'><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].ordersn+"</a></td>";
           	       
        	        str +=     "<td style='width:120px;'>"+data[i].productname+"</td>";
        	        str +=     "<td style='width:78px;'>"+data[i].usedate+"</td>";
        	        str +=     "<td style='width:60px;'>"+toDecimal2(data[i].supplier_cost)+"</td>";
        	        str +=     "<td style='width:60px;'>"+toDecimal2(data[i].supplier_cost)+"</td>";
        	        str +=     "<td  style='color:#FF3300;width:80px;'>"+toDecimal2(data[i].amount_apply)+"</td>";
        	        str +=     "<td style='width:60px;'>"+toDecimal2(data[i].balance_money)+"</td>";
        	        str +=     "<td style='width:60px;'>"+toDecimal2(data[i].all_platform_fee)+"</td>"; //color:#e8831b;

        	        if(data[i].status=="1" || data[i].status=="2")
        	       		str +=     "<td style='width:60px;'>"+toDecimal2(data[i].nopay_money2)+"</td>";
        	        else
        	        	str +=     "<td style='width:60px;'>"+toDecimal2(data[i].nopay_money)+"</td>";

        	        /* str +=     "<td style='width:40px;'>"+data[i].pay_percent+"</td>"; */

        	        
        	        
        	        var pay_way="转账";
        	        if(data[i].pay_way=="0")
        	        	pay_way="现金";
        	        str +=     "<td style='width:40px;'>"+pay_way+"</td>";
        	       
        	        str +=     "<td style='width:40px;'>"+data[i].expert_name+"</td>";
        	        str +=     "<td style='width:80px;'>"+data[i].depart_name+"</td>";
        	        
        	        var shenhe_status="";
        	        if(data[i].status=="1")
        	        	shenhe_status="待提交";
        	        else if(data[i].status=="2")
        	        	shenhe_status="待付款";
        	        else if(data[i].status=="4")
        	        	shenhe_status="已付款";
        	        else if(data[i].status=="5"||data[i].status=="3")
        	        	shenhe_status="已拒绝";
        	        str +=     "<td class='td_status' style='width:46px;'>"+shenhe_status+"</td>";
    	        	
        	      

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
   $("#btn_submit").click(function(){
	   flag=true;
	   object.init();
	})
 
     //select 
	$(".div_status ul li").click(function(){
		var value=$(this).attr("data-value");
		type_value=value;
		$(".div_status .ul_status").attr("data-value",value);
		flag=true;
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
	var apply_id="";
	
	//申请来源
	$("body").on("click",".a_detail",function(){
		var id=$(this).attr("data-id");
		var action=$(this).attr("action");
		if(action=="1")
			var title="详情";
		else
			var title="审核";
		window.top.openWin({
		  type: 2,
		  area: ['820px', '540px'],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/pay_manage_detail2');?>"+"/"+id+"/"+action
		});
	});
	  //订单详情    on：用于绑定未创建内容
	$("body").on("click",".a_order",function(){
		var order_id=$(this).attr("data-id");
	
		window.top.openWin({
		  title:"订单详情",
		  type: 2,
		  area: ['70%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/order/order_detail');?>"+"?id="+order_id
		});
	});
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
	//供应商详情
	$("body").on("click",".a_supplier",function(){
		var supplier_id=$(this).attr("data-id");
		
		window.top.openWin({
		  type: 2,
		  area: ['600px', '300px'],
		  title :'供应商详情',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail');?>"+"?id="+supplier_id
		});
	});
	

});

//供弹窗层调用
function parentfun(id){
	$(".a_shenhe[data-id="+id+"]").hide();
}
//供弹窗层调用
function parentfun2(id){
	$(".a_back[data-id="+id+"]").hide();
}

</script>
</html>


