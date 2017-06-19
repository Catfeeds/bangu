<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}



.con-list{width:100%;height:auto;margin-bottom:20px;}
.con-list .div_one{overflow:hidden;position:relative;width:330px;font-size:12px;height:155px;float:left;border:1px solid #ddd;margin:5px 10px 5px 0;padding:2px;}
.con-list .div_one .left{width:40%;float:left;}

.con-list .div_one .left img{width:100%;}
.con-list .div_one .right{width:58%;float:right;margin:0;padding:0;}
.con-list .div_one .right p{line-height:200%;overflow:hidden;}
.con-list .div_hover{border:1px solid #00886C;}
.con-list .div_on{border:1px solid #00886C;}
.con-list .div_one .left .pitch_img{position:absolute;width:32px;left:0;bottom:0;display:none;}
/*.con-list .div_one .right p font{font-weight:bold;}*/
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
            <a href="#">导入销售</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">导入销售</a></li> 
      
                    </ul>
                </div>
                <div class="tab_content" style="float:left;width:100%;">
                    <div class="table_list">
                        <form class="search_form" method="post" action="">
                            <div class="search_form_box clear" style="padding-right:0;">
                            
                            
                                <div class="search_group">
                                    <label>销售姓名：</label>
                                    <input type="text" id="realname" name="" class="search_input" style="width:100px;"/>
                                </div>
                                 <div class="search_group">
                                    <label>手机号：</label>
                                    <input type="text" id="mobile" name="" class="search_input" style="width:100px;"/>
                                </div>
                                
                                <div class="search_group">
                                    <label>所在地：</label>
                                    <div class="form_select">
                                        <div class="search_select div_kind">
                                            <div class="show_select ul_kind" data-value="" style="width:80px;">请选择</div>
                                            <ul class="select_list">
                                               
                                                <li value="1">境内</li>
                                                <li value="2">境外</li>
                                               
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                    </div>
                                    <!-- 二级 -->
                                    <div class="form_select two" style="display:none;">
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
                                    <input type="button" id="btn_submit" name="submit" class="search_button" value="搜索" style="margin-left:0;"/>
                                </div>
                                <span class="btn_import btn btn_green" style="margin-top:3px;">导入销售</span>
                              
                                
                            </div>
                        </form>
                        <div class="con-list">
                            <!--  <div class="div_one">
                               <div class="left">
                                 <a href="javascript:void(0)"><img src="http://192.168.10.202/file/upload/20150917/144246157011940.jpg" /></a>
                               </div>
                              <div class="right">
                                <p>名称：<font> <a href="javascript:void(0)">深圳海外国际旅行社</a></font></p>
                                <p>所在地：<font>中国湖北省咸宁市</font></p>
                                <p>类型：<font>境内供应商</font></p>
                               
                                <p>负责人：<font>李经理</font></p>
                                <p>联系电话：<font>15817399478</font></p>
                                 <p>入驻时间：<font>2015-06-01 06:58:18</font></p>
                               
                               </div>
                              
                             </div> -->
 
                        
                        </div>
                       
                        <!-- 暂无数据 -->
                        <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
                    </div>                   
                </div>
                <div style="height:20px;width: 100%;"></div>
                <div id="page_div"></div>
            </div>

        </div>
        
    </div>
   
    <!-- 选择营业部 弹层 -->
 <div class="fb-content" id="choose_depart" style="display:none;/*height:350px;*/">
    <div class="box-title">
        <h5>选择营业部</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin-top:60px;">
                <div class="fg-title" style="width:20%;">营业部：</div>
                <div class="fg-input" style="width:63%;">
                 <input type="text" id="depart_id" class="showorder" value="" data-id="" onfocus="showMenu(this.id);">
               
                </div>
            </div>
        
            <div class="form-group" style="margin-top:120px;">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but btn_choose" value="确定">
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
            
            var type=$(".div_kind .ul_kind").attr("data-value");
            var province=$("#province").attr("data-value");
            var city=$("#city").attr("data-value");
            var realname=$("#realname").val();
            var mobile=$("#mobile").val();
            

            //接口数据
        	ajax_data={page:"1",realname:realname,mobile:mobile,type:type,province:province,city:city};
        	var post_url="<?php echo base_url('admin/t33/expert/api_import_expert')?>";
        	var list_data=object.send_ajax(post_url,ajax_data); //数据结果
        	var total_page=list_data.data.total_page;   //总页数
        	
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
                	
        	        $(".con-list").html(html);
        	        
        	    }
        	    
        	})
        	flag=false;
        	//拉取select数据
        	//object.getArea_two(2); //境内
        	
        },
        pageData:function(curr,page_size,data){  //生成表格数据
        	    var base_url="<?php echo base_url();?>";
        	    var bangu_url="<?php echo BANGU_URL;?>";
    	 		var str = '', last = curr*page_size - 1;
        	    last = last >= data.length ? (data.length-1) : last;
        	    for(var i = 0; i <= last; i++)
        	    {

        	       str += "<div class='div_one'>";
        	       str += "  <div class='left'>";
        	       str += "    <a href='javascript:void(0)' class='a_detail' data-id='"+data[i].id+"' data-title='"+data[i].realname+"'><img src='"+bangu_url+data[i].small_photo+"' /></a>";
        	       str += "  <img src='"+base_url+"assets/ht/img/pitch.png' class='pitch_img' />";
        	       str += "  </div>";
        	       str += "  <div class='right'>";
        	       str += "     <p>姓名：<font><a href='javascript:void(0)' class='a_detail' data-id='"+data[i].id+"' data-title='"+data[i].realname+"'>"+data[i].realname+"</a></font></p>";
        	       str += "     <p>所在地：<font>"+data[i].countryname+data[i].provincename+data[i].cityname+"</font></p>";
        	       //类型
        	      // var type_str="";
                  // if(data[i].kind=="1") type_str="境内供应商";else if(data[i].kind=="2") type_str="个人";else if(data[i].kind=="3") type_str="境外供应商";

                    str += "     <p>销量：<font>"+data[i].people_count+"</font></p>";
        	      // str += "     <p>类型：<font>"+type_str+"</font></p>";
        	       str += "     <p>满意度：<font>"+data[i].satisfaction_rate+"</font></p>";
        	       str += "     <p>手机号：<font>"+data[i].mobile+"</font></p>";
        	       str += "     <p>入驻时间：<font>"+data[i].addtime+"</font></p>";
        	       str += "  </div>";
        	      
        	       str += "</div>";

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
        getArea_two:function(pid){  //获取二级地区
           
        
         	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
         	var post_data={pid:pid};
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
	
	$(".div_kind ul li").click(function(){

		var value=$(this).attr("value");
		$(".div_kind .ul_kind").attr("data-value",value);
		if(value=="1")
			object.getArea_two(2); //境内
		else if(value=="2")
			object.getArea_two(1); //境外
		
	})
	
	//鼠标移上去状态
	$("body").on("mouseover",".div_one",function(){
      $(this).addClass("div_hover");
    
	})
	//鼠标离开状态
	$("body").on("mouseout",".div_one",function(){

      $(this).removeClass("div_hover");
     
	})
	//点击选中、为选中状态
	$("body").on("click",".div_one",function(){
	
		if($(this).hasClass("div_on"))
		{
			$(this).removeClass("div_on");
			$(this).find(".pitch_img").css("display","none");
		}
		else
		{
			$(this).addClass("div_on");
			$(this).find(".pitch_img").css("display","block");
		}
		
    
	})
	
	//管家详情    on：用于绑定未创建内容
	$("body").on("click",".a_detail",function(){
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
	//导入管家弹窗
	$("body").on("click",".btn_import",function(){
		var data=[];
		$(".div_one").each(function(index){ 
			if($(this).hasClass("div_on"))
				data.push($(this).find(".a_detail").attr("data-id"));
		}); 
		if(data.length==0)
			tan4('请先勾选要导入的销售');
		else
		{  //导入
			layer.open({
				  type: 1,
				  title: false,
				  closeBtn: 0,
				  area: '500px',
				  //skin: 'layui-layer-nobg', //没有背景色
				  shadeClose: false,
				  content: $('#choose_depart')
				});

		}
		
	});
   //导入：提交
	   $(".btn_choose").click(function(){
		   var flag = COM.repeat('btn');//频率限制
	       if(!flag)
	       {
			   var data=[];
				$(".div_one").each(function(index){ 
					if($(this).hasClass("div_on"))
						data.push($(this).find(".a_detail").attr("data-id"));
				}); 
				//营业部
				var depart_id=$("#depart_id").attr("data-id");
	    		var depart_name=$("#depart_id").val();
	    		
				var url="<?php echo base_url('admin/t33/expert/api_import_expert_deal');?>";
				var post_data={ids:data,depart_id:depart_id,depart_name:depart_name};
				var return_data=object.send_ajax_noload(url,post_data);
				if(return_data.code=="2000")
				{
					layer.closeAll(); //关闭层
					tan2(return_data.data);
					$(".div_one").each(function(index){ 
						if($(this).hasClass("div_on"))
							$(this).hide();
					}); 
				}
				else
					tan(return_data.msg);

	    	}
      })

	

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


