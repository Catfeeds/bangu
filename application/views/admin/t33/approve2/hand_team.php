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
    <div class="page-body_detail" id="bodyMsg">
    
       
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="tab_content" style="padding-bottom:10px;">
                    <div class="table_list">
                       <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group">
                                    <label>申请人</label>
                                    <input type="text" id="expert_name" name="" class="search_input" style="width:90px;"/>
                                </div>
                               
                               <div class="search_group">
                                    <label>申请部门</label>
                                    <input type="text" id="depart_id" onfocus="showMenu(this.id);" class="search_input" data-id="">

                                </div>
                               <div class="search_group">
                                    <label>交款金额</label>
                                    <input type="text" id="price_start" name="" class="search_input" style="float: none;width:70px;" /> 至 <input type="text" id="price_end" name="" class="search_input" placeholder="" style="float: none;width:70px;" />
                                    
                                </div>
                              <div class="search_group">
                                    <label>订单编号</label>
                                    <input type="text" id="ordersn" name="" class="search_input" style="width:120px;"/>
                                </div>
                                 <div class="search_group">
                                    <label>申请日期</label>
                                    <input class="search_input" type="text" id="starttime" data-date-format="yyyy-mm-dd" value=""  style="float: none;width:90px;"> ~ <input class="search_input" type="text" id="endtime" data-date-format="yyyy-mm-dd" value="" style="float: none;width:90px;">
       
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
                 
                <div class="div_submit" style="float: left;width:100%;margin:0 0 10px 0;">
                <a href='javascript:void(0)' class="checkall" style='float:left;margin:8px 10px 0 20px;'>全选</a>
                <a href='javascript:void(0)' class="notcheckall" style='float:left;margin:8px 20px 0 0px;'>反选</a>
                <span class="btn_hand btn btn_green" style="float:left;">提交</span>
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

var team_code="<?php echo $team_code;  ?>";
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
            var depart_id=$("#depart_id").attr("data-id");
            var ordersn=$("#ordersn").val();
            var type_value=$(".itab").attr("data-id");
            var price_start=$("#price_start").val();
            var price_end=$("#price_end").val();
            
            //接口数据
            var post_url="<?php echo base_url('admin/t33/sys/approve/api_hand')?>";
        	ajax_data={page:"1",team_code:team_code,depart_id:depart_id,ordersn:ordersn,expert_name:expert_name,starttime:starttime,endtime:endtime,price_start:price_start,price_end:price_end};
        	var list_data=object.send_ajax(post_url,ajax_data);  //数据结果
        	var total_page=list_data.data.total_page; //总页数
        	
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

		        	//分情况
		        	
		        		$(".tr_rows").html("<th>编号</th><th>销售姓名</th><th>营业部门</th><th>交款金额</th><th>交款方式</th><th>备注</th><th>订单号</th><th>团号</th><th>供应商</th><th>供应商负责人</th><th>申请时间</th><th>状态</th><th>审核时间</th><th>审核人</th>");

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
        	
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {
        	    	 
        	        str += "<tr>";

        	        str +=     "<td><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].id+"'>"+data[i].id+"</a></td>";
        	        str +=     "<td>"+data[i].expert_name+"</td>";
         	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td>"+data[i].money+"</td>";
        	        str +=     "<td>"+data[i].way+"</td>";
        	        str +=     "<td>"+data[i].remark+"</td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_order' data-id='"+data[i].order_id+"'>"+data[i].order_sn+"</a></td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_teamcode' data-id='"+data[i].item_code+"'>"+data[i].item_code+"</a></td>";
        	        str +=     "<td><a href='javascript:void(0)' class='a_supplier' data-id='"+data[i].supplier_id+"'>"+data[i].company_name+"</a></td>";
        	        str +=     "<td>"+data[i].supplier_fuze+"</td>";
        	       
        	        
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        
        	        var status_str="";
                    if(data[i].status=="1")
                    	status_str="待审核";
                    else if(data[i].status=="2")
                    	status_str="已通过";
                    else if(data[i].status=="3")
                    	status_str="已拒绝";
                    str +=     "<td>"+status_str+"</td>";

                   
        	        str +=     "<td>"+data[i].modtime+"</td>";
    	        	str +=     "<td>"+data[i].employee_name+"</td>";
    	        	
        	       

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
	   object.init();
	})
   
     //select 
	$(".div_status ul li").click(function(){
		var value=$(this).attr("value");
		type_value=value;
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
		var action=$(this).attr("action");
		if(action=="1")
		{
			var title="详情";
			var height="400px";
		}
		else
		{
			var title="审核";
			var height="540px";
		}
		window.top.openWin({
		  type: 2,
		  area: ['820px', height],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/hand_detail');?>"+"?id="+id+"&action="+action
		});
	});
	//添加按钮
	$("body").on("click",".a_add",function(){
		window.top.openWin({
		  type: 2,
		  area: ['820px', '540px'],
		  title :'新增收款',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/approve/hand_add');?>"
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
		  area: ['46%', '80%'],
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
			 list=value+","+list;
		   }	  
		 })
		if(list.length==0)  {tan('请勾选要申请的交款');return false;}
		//添加按钮
		 window.top.openWin({
			  type: 2,
			  area: ['1024px', '540px'],
			  title :'交款审核',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/t33/sys/approve/hand_submit');?>"+"?list="+list
			});
		
	});
	//点击团号
	$("body").on("click",".a_teamcode",function(){
		var team_code=$(this).attr("data-id");
		//添加按钮
		 window.top.openWin({
			  type: 2,
			  area: ['1124px', '540px'],
			  title :'列表',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/t33/sys/approve/hand_team_list');?>"+"?team_code="+team_code
			});
		
	});
	
	


});

function getValue(){
	window.location.reload();
}

</script>
</html>


