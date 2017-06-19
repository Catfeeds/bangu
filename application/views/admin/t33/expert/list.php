<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">



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
            <a href="#">我的销售</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab" data-id="1">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">销售列表</a></li> 
                        <li static="-1"><a href="#tab1">已停用</a></li> 
      
                    </ul>
                </div>
                
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear">
                                <div class="search_group">
                                    <label>销售姓名：</label>
                                    <input type="text" id="realname" name="" class="search_input" style="width:180px;"/>
                                </div>
                                
                                <div class="search_group">
                                    <label>手机号：</label>
                                    <input type="text" id="mobile" name="" class="search_input" style="width:100px;"//>
                                </div>
                                <div class="search_group">
                                    <label>昵称：</label>
                                    <input type="text" id="nickname" name="" class="search_input" style="width:100px;"//>
                                </div>
                                <div class="search_group">
                                    <label>邮箱：</label>
                                    <input type="text" id="email" name="" class="search_input" style="width:100px;"//>
                                </div>
                                <div class="search_group">
                                    <label>营业部：</label>
                                   <input type="text" id="depart_id" onfocus="showMenu(this.id,this.value);" onkeyup="showMenu(this.id,this.value);" placeholder="输入关键字搜索" class="search_input" data-id="" style="width:180px;"/>
                                </div>
                                <div class="search_group">
                                    <label>所在地：</label>
                                    <div class="form_select">
                                        <div class="search_select">
                                            <div class="show_select" id="country" data-value="" style="width:106px;">请选择</div>
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
                                	<span class="add_expert btn btn_green" style="margin:3px 20px 0 0;">添加销售</span>
                                </div>
                               
                              
                                
                            </div>
                        </form>
                        <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>销售姓名</th>
                                  <!--   <th>昵称</th> -->
                                    <th>手机号</th>
                                    <th>邮箱</th>
                                    <th>身份证</th>
                                    <th>所在地</th>
                                    <th>职位</th>
                                    <th>所属营业部</th>
                                    <th>申请时间</th>
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
            <div class="form-group select_div" style="margin-top:30px;display:none;">
                <div class="fg-title" style="width:15%;">指定新经理：</div>
                <div class="fg-input" style="width:80%;">
                  <input type="hidden" class="action" />
                  <select name="new_manage" style="width:100px;">
                    <option value="-1">请选择</option>
                  </select>
                </div>
            </div>
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

 <!-- 解除关系 弹层 -->
 <div class="fb-content" id="cancel_div" style="display:none;">
    <div class="box-title">
        <h5>解除关系</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
            <div class="form-group select_div" style="margin-top:30px;">
                <div class="fg-title" style="width:15%;">指定新经理：</div>
                <div class="fg-input" style="width:80%;">
                  <input type="hidden" class="expert_id" />
                  <select name="new_manage" style="width:100px;">
                    <option value="-1">请选择</option>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_cancel_expert" value="确定">
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
            var realname=$("#realname").val();
            var nickname=$("#nickname").val();
            var mobile=$("#mobile").val();
            var email=$("#email").val();
            var country=$("#country").attr("data-value");
            var province=$("#province").attr("data-value");
            var city=$("#city").attr("data-value");
            var depart_id=$("#depart_id").attr("data-id");
            var type=$(".itab").attr("data-id");

            //接口数据
            var post_url="<?php echo base_url('admin/t33/expert/api_expert_list')?>";
        	ajax_data={page:"1",realname:realname,type:type,nickname:nickname,mobile:mobile,email:email,country:country,province:province,city:city,depart_id:depart_id};

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
        	        str +=     "<td><a href='javascript:void(0)' class='a_detail' title='"+data[i].id+"'>"+data[i].realname+"</a></td>";
        	        /* str +=     "<td>"+data[i].nickname+"</td>"; */
        	        str +=     "<td>"+data[i].mobile+"</td>";
        	        str +=     "<td>"+data[i].email+"</td>";
        	        str +=     "<td>"+data[i].idcard+"</td>";
        	        str +=     "<td>"+data[i].countryname+data[i].provincename+data[i].cityname+"</td>";
        	       
        	        //类型
                    var type_str="";
                    if(data[i].is_dm=="1") type_str="经理";else type_str="销售";
                    str +=     "<td>"+type_str+"</td>";
                    
        	        str +=     "<td>"+data[i].depart_name+"</td>";
        	        str +=     "<td>"+data[i].addtime+"</td>";
        	        //状态
                    var zt_str="";
                    if(data[i].union_status=="-1") zt_str="停用";else if(data[i].union_status=="0") zt_str="审核中";else if(data[i].union_status=="1") zt_str="正常";
        	        
        	        str +=     "<td>"+zt_str+"</td>";
        	        //操作
        	        var status_str="";
                    if(data[i].union_status=="1")
                   		var status_str="<a href='javascript:void(0)' class='close_expert' title='"+data[i].id+"'>停用</a>";
                    else if(data[i].union_status=="-1")
                    	var status_str="<a href='javascript:void(0)' class='open_expert' title='"+data[i].id+"'>开启</a>";

                   var type_value=$(".itab").attr("data-id");
                   if(type_value=="1")
                   status_str += "<a href='javascript:void(0)' class='cancel_expert' title='"+data[i].id+"' is_dm='"+data[i].is_dm+"'>解除关系</a>";
                   
                   str +=     "<td><a href='javascript:void(0)' class='edit_expert' title='"+data[i].id+"'>修改</a>"+status_str+"</td>";
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
   $(".div_kind ul li").click(function(){

		var value=$(this).attr("value");
		$(".div_kind .ul_kind").attr("data-value",value);
		
		
	})
	$(".itab ul li").click(function(){
      var value=$(this).attr("static");
      $(".itab").attr("data-id",value);
      flag=true;
      object.init();
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
	//添加销售
	$(".add_expert").click(function(){
		
		window.top.openWin({
		  type: 2,
		  area: ['800px', '560px'],
		  title :'添加销售',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/expert/add');?>"
		});
	});
	//编辑销售
	$("body").on("click",".edit_expert",function(){
		var expert_id=$(this).attr("title");
		window.top.openWin({
		  type: 2,
		  area: ['800px', '560px'],
		  title :'编辑销售',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/expert/edit');?>"+"?id="+expert_id
		});
	});
	
	//销售详情    on：用于绑定未创建内容
	$("body").on("click",".a_detail",function(){
		var supplier_id=$(this).attr("title");
		var supplier_name=$(this).html();
		
		window.top.openWin({
		  title:supplier_name,
		  type: 2,
		  area: ['840px', '560px'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/expert/detail');?>"+"?id="+supplier_id
		});
	});
	//停用
	var stop_expert=null;  //要停用的供应商
	$("body").on("click",".close_expert",function(){
	   stop_expert=$(this).attr("title");
		$.ajax({
			type:"post",
			url:"<?php echo base_url('admin/t33/expert/depart_expert');?>",
			data:{expert_id:stop_expert},
			dataType:"json",
			async:false,
			success:function(data){
				
				if(data.code==2000)
				{
					var obj=data.data.list;
					var str="<option value='-1'>请选择</option>";
					for(var i in obj){
 						str+="<option value='"+obj[i].id+"'>"+obj[i].realname+"</option>";
					}
					$('#stop_div select').html(str);

					if(data.data.is_dm=="1")
					{
						$("#stop_div .select_div").css("display","block");
						$("#stop_div .action").val("1");
					}
					else
					{
						$("#stop_div .select_div").css("display","none");
						$("#stop_div .action").val("");
					}
					
					layer.open({
						  type: 1,
						  title: false,
						  closeBtn: 0,
						  area: '500px',
						  //skin: 'layui-layer-nobg', //没有背景色
						  shadeClose: false,
						  content: $('#stop_div')
						});
			    }
				else
				{
					tan_alert_noreload(data.msg);
				}
			},
			error:function(data){
				tan_alert_noreload('请求异常');
			}
			})
		
		
		
	});
	
	$("body").on("click",".btn_stop",function(){
		var reason=$("#reason").val();
		var new_manage=$("#stop_div select").select().val();
		var action=$("#stop_div .action").val();
		
		var url="<?php echo base_url('admin/t33/expert/frozenExpert')?>";
		var data={id:stop_expert,reason:reason,new_manage:new_manage,action:action};
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code=="2000")
		{
			layer.closeAll(); //关闭层
			tan2(return_data.data);
			$(".close_expert[title='"+stop_expert+"']").html("开启");
			$(".close_expert[title='"+stop_expert+"']").addClass("open_expert");
			$(".close_expert[title='"+stop_expert+"']").removeClass("close_expert");
			//t33_refresh();
		}
		else
		{
			tan(return_data.msg);
		}
	})
	//开启
	$("body").on("click",".open_expert",function(){
		var expert_id=$(this).attr("title");
		layer.confirm('您确定要启用该销售？', {
			  btn: ['确定','取消'] //按钮
			}, function(){
				//开启
				var url="<?php echo base_url('admin/t33/expert/recovery')?>";
				var data={id:expert_id};
				var return_data=object.send_ajax_noload(url,data);
				if(return_data.code=="2000")
				{
					tan2(return_data.data);
					$(".open_expert[title='"+expert_id+"']").html("停用");
					$(".open_expert[title='"+expert_id+"']").addClass("close_expert");
					$(".open_expert[title='"+expert_id+"']").removeClass("open_expert");
					//t33_refresh();
				}
				else
				{
					tan(return_data.msg);
				}
			 
			  
			}, function(){
			  
			});
		
	});
	//解除关系
	$("body").on("click",".cancel_expert",function(){
		var expert_id=$(this).attr("title");
		var is_dm=$(this).attr("is_dm");
		if(is_dm=="0"){//非经理
			layer.confirm('解除关系后，你将无法查看及操作该销售，确定要解除吗?', {
				  btn: ['确定','取消'] //按钮
				}, function(){
					var url="<?php echo base_url('admin/t33/expert/cancel_expert');?>";
					var data={id:expert_id}
					var return_data=object.send_ajax_noload(url,data);
					if(return_data.code=="2000")
					{
						tan2(return_data.data);
						$(".cancel_expert[title="+expert_id+"]").hide();
						//setTimeout(function(){window.location.reload();},500);	
						//window.location.reload();
					}
					else
					{
						tan(data.msg);
					}
				}, function(){
				  
				});
		}
		else{//经理
			$.ajax({
				type:"post",
				url:"<?php echo base_url('admin/t33/expert/depart_expert');?>",
				data:{expert_id:expert_id},
				dataType:"json",
				async:false,
				success:function(data){
					
					if(data.code==2000)
					{
						var obj=data.data.list;
						var str="<option value='-1'>请选择</option>";
						for(var i in obj){
	 						str+="<option value='"+obj[i].id+"'>"+obj[i].realname+"</option>";
						}
						$('#cancel_div .expert_id').val(expert_id);
						$('#cancel_div select').html(str);

						layer.open({
							  type: 1,
							  title: false,
							  closeBtn: 0,
							  area: '500px',
							  //skin: 'layui-layer-nobg', //没有背景色
							  shadeClose: false,
							  content: $('#cancel_div')
							});
				    }
					else
					{
						tan_alert_noreload(data.msg);
					}
				},
				error:function(data){
					tan_alert_noreload('请求异常');
				}
				})
		}
		
	})
	//解除关系
	$("body").on("click",".btn_cancel_expert",function(){

		var new_manage=$("#cancel_div select").select().val();
		var expert_id=$("#cancel_div .expert_id").val();
		
		var url="<?php echo base_url('admin/t33/expert/cancel_expert');?>";
		var data={id:expert_id,new_manage:new_manage,action:"1"}
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code=="2000")
		{
			tan_alert(return_data.data);
			$(".cancel_expert[title="+expert_id+"]").hide();
			//setTimeout(function(){window.location.reload();},500);	
			//window.location.reload();
		}
		else
		{
			tan(return_data.msg);
		}
	});


});



</script>
</html>


