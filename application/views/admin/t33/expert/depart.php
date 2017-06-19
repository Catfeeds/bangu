<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}


/*财务人员模糊搜索*/

.ul_employee{
  border:1px solid #dcdcdc;
  min-height:200px;
  max-height:300px;
  overflow-y:scroll;
  display:none;
  z-index:999;
  width:140px;
  background:#fff;
  position:absolute;
  margin:0px 0 0 0px;
}
.ul_employee li{
width:138px !important;
padding:0 4px;
overflow:hidden;
height:20px;
}
.ul_employee li:hover{
background:#ccc;
cursor:pointer;
}


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
            <a href="#">营业部管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">营业部列表</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group" >
                                    <label style='width:74px;'>营业部名称：</label>
                                    <input type="text" id="name" style="width:120px;" class="search_input"/>
                                </div>
                                <div class="search_group">
                                    <label style='width: 74px;'>上级营业部：</label>
                                   <input type="text" id="depart_id" onfocus="showMenu2(this.id,this.value);" onkeyup="showMenu2(this.id,this.value);" placeholder="输入关键字搜索" class="search_input" data-id="">
                                </div>
                                <div class="search_group" style="width: 354px;">
                                    <label>联系人：</label>
                                    <input type="text" id="linkman" name="" class="search_input" style="width:120px;"/>
                                </div>

                 				
                                
                                 <div class="search_group">
                                    <label style='width:74px'>状态：</label>
                                    <div class="form_select">
                                        <div class="search_select div_kind">
                                            <div class="show_select ul_kind" data-value="" style="width:70px;">请选择</div>
                                            <ul class="select_list">
                                               
                                                <li data-value="1">正常</li>
                                                <li data-value="-1">停用</li>
                                               
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
                                <div class="search_group">
                                	<span class="add_depart btn btn_green" style="margin:3px 20px 0 20px;">添加营业部</span>
                                </div>
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>营业部名称</th>
                                    <!-- <th>上级营业部</th> -->
                                    <th>联系人</th>
                                    <th>联系电话</th>
                                    <th>添加时间</th>
                                    <th>备注</th>
                                    <th>状态</th>
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
   
 <!-- 停用供应商 弹层 -->
 <div class="fb-content" id="stop_div" style="display:none;">
    <div class="box-title">
        <h5>停用销售人员</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">停用理由：</div>
                <div class="fg-input" style="width:80%;"><textarea name="beizhu" id="reason" maxlength="30" placeholder="请填写停用理由" style="height:160px;"></textarea></div>
            </div>
        
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_stop" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

 <!-- 添加营业部 弹层 -->
 <div class="fb-content" id="depart_div" style="display:none;">
    <div class="box-title">
        <h5>添加营业部</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
           <div class="form-group">
                <div class="fg-title" style="width:18%;">部门名称：<i>*</i></div>
                <div class="fg-input" style="width:71%;"><input type="text" id="name" class="showorder" name="showorder"></div>
            </div>
            <div class="form-group">
                <div class="fg-title" style="width:18%;">联系人：<i>*</i></div>
                <div class="fg-input" style="width:77%;"><input type="text" id="linkman" class="showorder" name="showorder"></div>
            </div>
            
            <div class="form-group">
                <div class="fg-title" style="width:18%;">联系电话：<i>*</i></div>
                <div class="fg-input" style="width:77%;"><input type="text" id="linkmobile" class="showorder" name="showorder"></div>
            </div>
             <div class="form-group">
                <div class="fg-title" style="width:18%">上级部门：<i>*</i></div>
                <div class="fg-input" style="width:77%;"> <input type="text" id="depart_pid" class="showorder" value="" data-id="" onfocus="showMenu2(this.id,this.value);" onkeyup="showMenu2(this.id,this.value);" placeholder="输入关键字搜索"></div>
            </div>
             <div class="form-group">
                <div class="fg-title" style="width:18%">跟进财务：<i>*</i></div>
                <div class="fg-input" style="width:77%;"> 
                
                   <input type="text" name="" id="input_add_employee" class="showorder employee_id" placeholder="输入姓名进行搜索" data-value="" style="margin:0;width:140px;" />
     			   <ul class="select_list ul_employee">
                   </ul>
                </div>
            </div>
             <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:24%;">备注：</div>
                <div class="fg-input" style="width:77%;"><textarea name=""remark"" id="remark" maxlength="30" placeholder="备注" style="height:160px;"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_add_depart" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
    <!-- 修改营业部 弹层 -->
 <div class="fb-content" id="update_div" style="display:none;">
    <div class="box-title">
        <h5>修改营业部</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           <input type="hidden" id="depart_id" class="showorder" name="showorder">
           <div class="form-group">
                <div class="fg-title" style="width:18%;">部门名称：<i>*</i></div>
                <div class="fg-input" style="width:77%;"><input type="text" id="update_name" class="showorder" name="showorder"></div>
            </div>
            <div class="form-group">
                <div class="fg-title" style="width:18%;">联系人：<i>*</i></div>
                <div class="fg-input" style="width:77%;"><input type="text" id="update_linkman" class="showorder" name="showorder"></div>
            </div>
            <div class="form-group">
                <div class="fg-title" style="width:18%;">联系电话：<i>*</i></div>
                <div class="fg-input" style="width:77%;"><input type="text" id="update_linkmobile" class="showorder" name="showorder"></div>
            </div>
             <div class="form-group">
                <div class="fg-title" style="width:20%;">上级部门：<i>*</i></div>
                <div class="fg-input" style="width:77%;"> <input type="text" id="edit_pid" class="showorder" value="" data-id="" onfocus="showMenu2(this.id,this.value);" onkeyup="showMenu2(this.id,this.value);"></div>
            </div>
             <div class="form-group">
                <div class="fg-title" style="width:18%">跟进财务：<i>*</i></div>
                <div class="fg-input" style="width:77%;"> 
                
                   <input type="text" name="" id="input_edit_employee" class="showorder employee_id" placeholder="输入姓名进行搜索" data-value="" style="margin:0;width:140px;" />
     			   <ul class="select_list ul_employee">
                   </ul>
                </div>
            </div>
             <div class="form-group" style="margin-top:30px;">
                <div class="fg-title" style="width:18%;">备注：</div>
                <div class="fg-input" style="width:77%;"><textarea name=""remark"" id="update_remark" maxlength="30" placeholder="备注" style="height:160px;"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_edit_depart" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript">
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var name=$("#name").val();
            var linkman=$("#linkman").val();
            var status=$(".div_kind .ul_kind").attr("data-value");
            var pid=$("#depart_id").attr("data-id");
            if(pid==null||pid=="")  pid="-1";
            //接口数据
            var post_url="<?php echo base_url('admin/t33/expert/api_depart')?>";
        	ajax_data={page:"1",pid:pid,name:name,linkman:linkman,status:status};

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
        	    	 var higher_depart="";
                     if(data[i].pname2=="")
                     {
                         
                     }
                     else
                     {
                     	higher_depart=data[i].pname2;
                     	if(data[i].pname3!="")
                     		higher_depart=data[i].pname3+"<span class='right_jiantou' style='color:#000;'>&gt;</span>"+higher_depart;
                     	if(data[i].pname4!="")
                     		higher_depart=data[i].pname4+"<span class='right_jiantou' style='color:#000;'>&gt;</span>"+higher_depart;
                 		higher_depart += "<span class='right_jiantou' style='color:#000;'>&gt;</span>";
                     }

                     
        	        str += "<tr>";
        	        str +=     "<td>"+higher_depart+"<a href='javascript:void(0)' class='edit_depart' title='"+data[i].id+"'>"+data[i].name+"</a></td>";
                   
                    
        	       /*  str +=     "<td>"+higher_depart+"</td>"; */

           	        str +=     "<td>"+data[i].linkman+"</td>";
        	        str +=     "<td>"+data[i].linkmobile+"</td>";
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        str +=     "<td>"+data[i].remark+"</td>";
        	        
        	        //状态
                    var zt_str="";
                    if(data[i].status=="1") zt_str="正常";else zt_str="停用";
                    str +=     "<td>"+zt_str+"</td>";
        	        //操作
        	        var status_str="";
                    if(data[i].status=="1")
                   		var status_str="<a href='javascript:void(0)' class='stop_depart' data-id='"+data[i].id+"'>停用</a>";
                    else if(data[i].status=="-1")
                    	var status_str="<a href='javascript:void(0)' class='start_depart' data-id='"+data[i].id+"'>开启</a>";

                   status_str += "<a href='javascript:void(0)' class='set_bank' data-id='"+data[i].id+"'>银行账户</a>";
                   
                   str +=     "<td><a href='javascript:void(0)' class='edit_depart' title='"+data[i].id+"'>修改</a>"+status_str+"</td>";
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

		var value=$(this).attr("data-value");
		$(".div_kind .ul_kind").attr("data-value",value);
		flag=true;
		
	})
   $("#btn_submit").click(function(){
	   flag=true;
	   object.init();
	})
	//日历控件
	$('#date').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//添加营业部
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
	//添加营业部提交按钮
	$("body").on("click",".btn_add_depart",function(){
		var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
			var name=$("#depart_div #name").val();
			var linkman=$("#depart_div #linkman").val();
			var linkmobile=$("#depart_div #linkmobile").val();
			var remark=$("#depart_div #remark").val();
			var pid=$("#depart_pid").attr("data-id");
			var finance_id=$("#input_add_employee").attr("data-value");
			var finance_value=$("#input_add_employee").val();
			
	        if(name=="") {tan('请填写部门名称');return false;}
	        if(linkman=="") {tan('请填写联系人');return false;}
	        if(linkmobile=="") {tan('请填写联系人电话');return false;}
	        if(pid=="") {tan('请选择所属营业部');return false;}
	        if(finance_id==""||finance_value=="") {tan('请选择跟进财务人员');return false;}
	
	        var url="<?php echo base_url('admin/t33/expert/api_add_depart');?>";
	        var data={pid:pid,name:name,linkman:linkman,linkmobile:linkmobile,remark:remark,finance_id:finance_id};
	        var return_data=object.send_ajax_noload(url,data);
	        if(return_data.code=="2000")
	        {
	        	t33_close();
				tan2(return_data.data);
				t33_refresh();
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
    	}
		
	})
	//编辑营业部
	$("body").on("click",".edit_depart",function(){
		var expert_id=$(this).attr("title");
		
	    var url="<?php echo base_url('admin/t33/expert/api_depart_detail');?>";
        var data={id:expert_id};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	$("#update_div #update_name").val(return_data.data.name);
        	$("#update_div #update_linkman").val(return_data.data.linkman);
        	$("#update_div #update_linkmobile").val(return_data.data.linkmobile);
        	$("#update_div #update_remark").val(return_data.data.remark);
        	$("#update_div #edit_pid").val(return_data.data.p_name);
        	$("#update_div #edit_pid").attr("data-id",return_data.data.pid);
        	$("#update_div #depart_id").val(return_data.data.id); //depart_id
        	$("#update_div #input_edit_employee").val(return_data.data.realname); //跟进财务人员
        	$("#update_div #input_edit_employee").attr("data-value",return_data.data.finance_id); //跟进财务人员
        }
       
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '500px',
			  //skin: 'layui-layer-nobg', //没有背景色
			  shadeClose: false,
			  content: $('#update_div')
			});
	});
	//修改营业部提交按钮
	$("body").on("click",".btn_edit_depart",function(){
		
		var id=$("#update_div #depart_id").val();
		var pid=$("#edit_pid").attr("data-id");
		var name=$("#update_div #update_name").val();
		var linkman=$("#update_div #update_linkman").val();
		var linkmobile=$("#update_div #update_linkmobile").val();
		var remark=$("#update_div #update_remark").val();
		var finance_id=$("#input_edit_employee").attr("data-value");
		var finance_value=$("#input_edit_employee").val();
		
        if(name=="") {tan('请填写部门名称');return false;}
        if(linkman=="") {tan('请填写联系人');return false;}
        if(linkmobile=="") {tan('请填写联系人电话');return false;}
        if(pid=="") {tan('请选择所属营业部');return false;}
     
        if(finance_id==""||finance_value=="") {tan('请选择跟进财务人员');return false;}

        var url="<?php echo base_url('admin/t33/expert/api_edit_depart');?>";
        var data={pid:pid,id:id,name:name,linkman:linkman,linkmobile:linkmobile,remark:remark,finance_id:finance_id,finance_value:finance_value};
        var return_data=object.send_ajax_noload(url,data);
        if(return_data.code=="2000")
        {
        	t33_close();
			tan2(return_data.data);
			t33_refresh();
        }
        else
        {
            tan(return_data.msg);
        }
		
	})
	
	//停用
	$("body").on("click",".stop_depart",function(){
		var id=$(this).attr("data-id");
		layer.confirm('您确定要停用该营业部？', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				//开启
				var url="<?php echo base_url('admin/t33/expert/stop_and_start')?>";
				var data={id:id,status:"-1"};  //status : 1正常 ， -1停用
				var return_data=object.send_ajax_noload(url,data);
				if(return_data.code=="2000")
				{
					tan2(return_data.data);
					$(".start_depart[data-id='"+id+"']").html("停用");
					$(".start_depart[data-id='"+id+"']").addClass("stop_depart");
					$(".start_depart[data-id='"+id+"']").removeClass("start_depart");
					t33_refresh();
				}
				else
				{
					tan(return_data.msg);
				}
			 
			  
			}, function(){
			  
			});
		
	});
	//开启
	$("body").on("click",".start_depart",function(){
		var id=$(this).attr("data-id");
		layer.confirm('您确定要启用该营业部？', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				//开启
				var url="<?php echo base_url('admin/t33/expert/stop_and_start')?>";
				var data={id:id,status:'1'};
				var return_data=object.send_ajax_noload(url,data);
				if(return_data.code=="2000")
				{
					tan2(return_data.data);
					$(".stop_depart[title='"+id+"']").html("停用");
					$(".stop_depart[title='"+id+"']").addClass("start_expert");
					$(".stop_depart[title='"+id+"']").removeClass("stop_depart");
					t33_refresh();
				}
				else
				{
					tan(return_data.msg);
				}
			 
			  
			}, function(){
			  
			});
		
	});
	//营业部银行账户设置
	$("body").on("click",".set_bank",function(){
		var depart_id=$(this).attr("data-id");
		
		window.top.openWin({
		  type: 2,
		  area: ['500px', '370px'],
		  title :'设置银行账户',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/expert/depart_bank');?>"+"?depart_id="+depart_id
		});
	});

	
	//  点击元素以外任意地方隐藏该元素的方法
	$(document).click(function(){
		$(".select_list").css("display","none");

	});

	$(".employee_id").click(function(event){
	    event.stopPropagation();
	});
	$(".ul_kind").click(function(event){
	    event.stopPropagation();
	});
	
	
	//  财务人员搜索
	$("body").on("focus",".employee_id",function(){
		$(".ul_employee").css("display","block");
		employee_search();
	})
	$("body").on("keyup",".employee_id",function(){
		if($(this).val()=="")
			$(this).attr("data-value","");
		employee_search();
	})
	function employee_search()
	{
		var content=$(".employee_id").val();
		var send_url="<?php echo base_url('admin/t33/expert/api_employee_list');?>";
		var send_data={content:content};
		var return_data=object.send_ajax_noload(send_url,send_data); 
		var html="";
		for(var i in return_data.data)
		{
			html+="<li data-value="+return_data.data[i].id+">"+return_data.data[i].realname+"</li>";
		}
		$(".ul_employee").html(html);
	}
	$("body").on("click",".ul_employee li",function(){
		var id=$(this).attr("data-value");
		var con=$(this).html();
		$(".employee_id").val(con);
		$(".employee_id").attr("data-value",id);
		$(".employee_id").blur();
		$(".ul_employee").css("display","none");
	});

});



</script>
</html>


