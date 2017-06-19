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

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>供应商管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">我的供应商</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab" data-id="1">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">供应商列表</a></li> 
                        <li static="-1"><a href="#tab1">停用</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group">
                                    <label style='width: 74px;'>供应商名称：</label>
                                    <input type="text" id="supplier_name" style="width:120px;" class="search_input" />
                                </div>
                                 <div class="search_group">
                                    <label>品牌名称：</label>
                                    <input type="text" id="brand" style="width:120px;" class="search_input" />
                                </div>
                                <div class="search_group">
                                    <label>手机号：</label>
                                    <input type="text" id="mobile" style="width:120px;" class="search_input" style="width:120px;"/>
                                </div>
                               
                                <div class="search_group" style="margin-right:0;width:200px;">
                                    <label>邮箱：</label>
                                    <input type="text" id="email" style="width:120px;" class="search_input" style="width:120px;"/>
                                </div>
                                
                                <div class="search_group">
                                    <label style='width: 74px;'>所在地：</label>
                                    <div class="form_select">
                                        <div class="search_select">
                                            <div class="show_select" id="country" data-value="" style="width:100px;">请选择</div>
                                            <ul class="select_list select_one">

                                            </ul>
                                            <i></i>
                                        </div>
                                        
                                    </div>
                                    <!-- 二级 -->
                                    <div class="form_select two" style="display: none;">
                                        <div class="search_select">
                                            <div class="show_select" id="province" data-value="">请选择</div>
                                            <ul class="select_list select_two">
     
                                            </ul>
                                            <i></i>
                                        </div>
                                        
                                    </div>
                                    <!-- 三级 -->
                                    <div class="form_select three" style="display: none;">
                                        <div class="search_select">
                                            <div class="show_select" id="city" data-value="">请选择</div>
                                            <ul class="select_list select_three">
         
                                            </ul>
                                            <i></i>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                               
                               <!-- 搜索按钮 -->
                                <div class="search_group">
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索"/>
                                </div>
                                <div class="search_group">
                                	<span class="add_supplier btn btn_green" style="margin:3px 20px 0 20px;">添加供应商</span>
                                </div>
                               
                               <!--  <span class="alert_msg7 btn btn_green">添加供应商(div)</span>
                                <span class="alert_msg2 btn btn_green">确认框</span>
                                <span class="alert_msg1 btn btn_green">消息提示框1</span>
                                <span class="alert_msg4 btn btn_green">消息提示框2</span>
                                <span class="alert_msg13 btn btn_green">加载层</span> -->
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>供应商名称</th>
                                    <th width="70">供应商代码</th>
                                    <th>所在地</th>
                                    <th width="75">品牌名称</th>
                                    <th width="60">负责人</th>
                                    <th width="90">联系电话</th>
                                    <th width="120">电子邮箱</th>
                                   
                                    <th width="125">入驻时间</th>
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
        <h5>停用供应商</h5>
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
   

<script type="text/javascript">
	var flag=true;
	//js对象
	var object = object || {};
	var ajax_data={};
	object = {
        init:function(){ //初始化方法
            var supplier_name=$("#supplier_name").val();
            var mobile=$("#mobile").val();
            var email=$("#email").val();
            var country=$("#country").attr("data-value");
            var province=$("#province").attr("data-value");
            var city=$("#city").attr("data-value");
            var brand=$("#brand").val();
            var status=$(".itab").attr("data-id");

            //接口数据
            var post_url="<?php echo base_url('admin/t33/supplier/supplier_list')?>";
        	ajax_data={page:"1",supplier_name:supplier_name,status:status,brand:brand,mobile:mobile,email:email,country:country,province:province,city:city};

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
        	//拉取select数据
        	object.getArea(0);
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {
   
        	        str += "<tr>";
        	        str +=     "<td class='td_long'><a href='javascript:void(0)' class='a_detail' title='"+data[i].id+"'>"+data[i].company_name+"</a></td>";
        	        str +=     "<td>"+data[i].code+"</td>";
        	        str +=     "<td>"+data[i].countryname+data[i].provincename+data[i].cityname+"</td>";
        	        str +=     "<td>"+data[i].brand+"</td>";
        	        str +=     "<td>"+data[i].realname+"</td>";
        	        str +=     "<td>"+data[i].mobile+"</td>";
        	        str +=     "<td>"+data[i].email+"</td>";
        	      
        	        //状态
                    var zt_str="";
                    if(data[i].supplier_status=="-1") zt_str="停用";else if(data[i].supplier_status=="1") zt_str="正常";
        	        
        	        
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        str +=     "<td>"+zt_str+"</td>";
        	        //操作
        	        var status_str="";
                   
                    if(data[i].supplier_status=="-1")
                        status_str+="<a href='javascript:void(0)' class='open_supplier' title='"+data[i].id+"'>开启</a>";
                    else
                    {
                        status_str+="<a href='javascript:void(0)' class='close_supplier' title='"+data[i].id+"'>停用</a>";
                        		
                    }

                   status_str += "<a href='javascript:void(0)' class='set_bank' title='"+data[i].id+"'>银行账户</a>";
                   status_str += "<a href='javascript:void(0)' class='set_yj' title='"+data[i].id+"'>佣金设置</a>";
                   str +=     "<td><a href='javascript:void(0)' class='edit_supplier' title='"+data[i].id+"'>修改</a><a href='javascript:void(0)' class='copy_supplier' title='"+data[i].id+"'>复制</a>"+status_str+"</td>";
        	       str += "</tr>";
        	    }
        	    return str;
           
        },
        getArea:function(pid){  //获取一级地区
        	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
        	var post_data={pid:pid};
        	var return_data=object.send_ajax_noload(post_url,post_data);
        	if(return_data.code=="2000")
        	{
        		var json=return_data.data;
        		var str="";
	        	for(var i in json)
	        	{
		        	str += "<li value='"+json[i].id+"' class='li_one' onclick='object.getArea_two(this)'>"+json[i].name+"</li>";
		        		
	            }
	           
	            $(".select_one").html(str);
        	}
         },
        getArea_two:function(obj){  //获取二级地区
        	var value=$(obj).attr("value");
    		var con=$(obj).html();
    		$("#country").attr("data-value",value);
            $("#country").html(con);
            $(".select_one").css("display","none");
    		
         	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
         	var post_data={pid:value};
         	var return_data=object.send_ajax_noload(post_url,post_data);
         	if(return_data.code=="2000")
         	{
         		var json=return_data.data;
         		var str="";
 	        	for(var i in json)
 	        	{
 		        	str += "<li value='"+json[i].id+"' class='li_two' onclick='object.getArea_three(this)'>"+json[i].name+"</li>";
 		        		
 	            }
 	           
 	            $(".select_two").html(str);
 	            $(".two").css("display","block");
         	}
          },
        getArea_three:function(obj){  //获取三级地区

          	var value=$(obj).attr("value");
      		var con=$(obj).html();
      		$("#province").attr("data-value",value);
            $("#province").html(con);
            $(".select_two").css("display","none");
      		
           	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
           	var post_data={pid:value};
           	var return_data=object.send_ajax_noload(post_url,post_data);
           	if(return_data.code=="2000")
           	{
           		var json=return_data.data;
           		var str="";
   	        	for(var i in json)
   	        	{
   		        	str += "<li value='"+json[i].id+"' class='li_three' onclick='object.getArea_four(this)'>"+json[i].name+"</li>";
   		        		
   	            }
   	           
   	            $(".select_three").html(str);
   	            $(".three").css("display","block");
           	}
            },
        getArea_four:function(obj){ //

              	var value=$(obj).attr("value");
          		var con=$(obj).html();
          		$("#city").attr("data-value",value);
                $("#city").html(con);
                $(".select_three").css("display","none");

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

	$(".itab ul li").click(function(){
       var value=$(this).attr("static");
       $(".itab").attr("data-id",value);
       flag=true;
       object.init();
    })
	//选择事件
	$("#country").click(function(){
		 $(".select_one").css("display","block");
   })
   //选择事件
	$("#province").click(function(){
		 $(".select_two").css("display","block");
   })
   //选择事件
	$("#city").click(function(){
		 $(".select_three").css("display","block");
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
	//添加供应商
	$(".add_supplier").click(function(){
		
		window.top.openWin({
		  type: 2,
		  area: ['800px', '560px'],
		  title :'添加供应商',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/add');?>"
		});
	});
	//编辑供应商
	$("body").on("click",".edit_supplier",function(){
		var supplier_id=$(this).attr("title");
		window.top.openWin({
		  type: 2,
		  area: ['800px', '560px'],
		  title :'编辑供应商',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/edit');?>"+"?id="+supplier_id
		});
	});
	//供应商银行账户设置
	$("body").on("click",".set_bank",function(){
		var supplier_id=$(this).attr("title");
		window.top.openWin({
		  type: 2,
		  area: ['500px', '370px'],
		  title :'设置银行账户',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/bank');?>"+"?id="+supplier_id
		});
	});
	//佣金设置
	$("body").on("click",".set_yj",function(){
		var supplier_id=$(this).attr("title");
		window.top.openWin({
		  type: 2,
		  area: ['700px', '460px'],
		  title :'佣金设置',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/set_yj2');?>"+"?id="+supplier_id
		});
	});
	//供应商详情    on：用于绑定未创建内容
	$("body").on("click",".a_detail",function(){
		var supplier_id=$(this).attr("title");
		var supplier_name=$(this).html();
		
		window.top.openWin({
		  title:supplier_name,
		  type: 2,
		  area: ['800px', '560px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/detail2');?>"+"?id="+supplier_id
		});
	});
	//停用
	var stop_supplier=null;  //要停用的供应商
	$("body").on("click",".close_supplier",function(){
		stop_supplier=$(this).attr("title");
		
		layer.open({
			  type: 1,
			  title: false,
			  closeBtn: 0,
			  area: '500px',
			  //skin: 'layui-layer-nobg', //没有背景色
			  shadeClose: false,
			  content: $('#stop_div')
			});
		
	});
	
	$("body").on("click",".btn_stop",function(){
		var reason=$("#reason").val();
		var url="<?php echo base_url('admin/t33/supplier/frozenSupplier')?>";
		var data={id:stop_supplier,reason:reason};
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code=="2000")
		{
			layer.closeAll(); //关闭层
			tan2(return_data.data);
			$(".close_supplier[title='"+stop_supplier+"']").html("开启");
			$(".close_supplier[title='"+stop_supplier+"']").addClass("open_supplier");
			$(".close_supplier[title='"+stop_supplier+"']").removeClass("close_supplier");
			
		}
		else
		{
			tan(return_data.msg);
		}
	})
	//开启
	$("body").on("click",".open_supplier",function(){
		var supplier_id=$(this).attr("title");
		layer.confirm('您确定要启用该供应商？', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				//开启
				var url="<?php echo base_url('admin/t33/supplier/recovery')?>";
				var data={id:supplier_id};
				var return_data=object.send_ajax_noload(url,data);
				if(return_data.code=="2000")
				{
					tan2(return_data.data);
					$(".open_supplier[title='"+supplier_id+"']").html("停用");
					$(".open_supplier[title='"+supplier_id+"']").addClass("close_supplier");
					$(".open_supplier[title='"+supplier_id+"']").removeClass("open_supplier");
					
				}
				else
				{
					tan(return_data.msg);
				}
			 
			  
			}, function(){
			  
			});
		
	});
	/*复制*/
	//
	$("body").on("click",".copy_supplier",function(){
		var supplier_id=$(this).attr("title");
		window.top.openWin({
		  type: 2,
		  area: ['500px', '470px'],
		  title :'复制供应商  - 补充信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/supplier/copy');?>"+"?id="+supplier_id
		});
	});
	

	/* //alertBox("消息提示框测试");
	$(".alert_msg1").click(function(){
		layer.alert('见到你真的很高兴', {icon: 1});
	});

	
	
	$(".alert_msg2").click(function(){
		layer.confirm('您确定要删除？', {
			  btn: ['确定','取消'] //按钮
			}, function(){
			  layer.msg('已删除', {icon: 1});
			}, function(){
			  
			});
	});
	
	$(".alert_msg4").click(function(){
		layer.msg('操作成功', {icon: 1});
	});
	
	
	$(".alert_msg7").click(function(){
		layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '560px',
		  //skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: true,
		  content: $('#form1')
		});
	});
	
	
	$(".alert_msg13").click(function(){
		//加载层-风格3
		layer.load(2);
		//此处演示关闭
		setTimeout(function(){
		  layer.closeAll('loading');
		}, 2000);
	}); */
	

});


/**用于子父iframe传值*/
function getValue()
{
	var data = parent.$('#val_box').text();
	layer.msg('得到了'+data);
}
/**用于子父iframe传值*/

</script>
</html>


