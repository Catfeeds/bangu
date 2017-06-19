<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<?php  $this->load->view("admin/t33/common/js_view"); ?>

<style type="text/css">
.page_content { margin-top:0;padding-top:5px;}
.search_form  { margin:0;}
.search_form_box { width:100%;}
.search_form_box .search_group label { width:auto;}
.search_group { margin-right:20px;}
.search_input { height:auto !important;line-height:23px !important;padding:0 2px !important;border:1px solid #bbb !important;font-size:13px !important;}
.search_button { margin:0;}
.table-bordered { border-collapse:collapse;}
.data_rows tr td { text-align:center !important;}
.underline { text-decoration:underline;}
.page_content { padding-top:0;}
.code_info { padding:0 10px;}
.order_info_table { border:0;}
.order_info_title { background:#fff !important;width:80px !important;}
.order_info_table tr td { border:0;}
.table tbody tr td a.not_click { color:#aaa !important;cursor: default !important;text-decoration:none !important;}
.table_list { min-height:200px;}
</style>
</head>
<body>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">      
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">               
            <!-- tab切换表格 -->
            <div class="code_info">
                <table class="order_info_table" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">优惠券类型</td>
                        <td colspan="3" style="padding-left:20px;"><span class="coupon_type"></span></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">适用范围</td>
                        <td colspan="3" style="padding-left:20px;"><span class="coupon_range"></span></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><i class="red">*</i>优惠券金额</td>
                        <td style="width:60px;text-align:right;"><span class="coupon_price"></span>元</td>
                        <td class="order_info_title" style="width:200px !important;"><i class="red">*</i>使用条件，满</td>
                        <td><span class="min_price" style="margin-right:15px;"></span>使用，0表示不限制</td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><i class="red">*</i>张数</td>
                        <td style="width:60px;text-align:right;"><span class="number"></span>张</td>
                        <td class="order_info_title" style="width:200px !important;"><i class="red">*</i>有效期至</td>
                        <td><span class="time"></span></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明</td>
                        <td colspan="3" style="padding-left:20px;"><span class="decription"></span></td>
                    </tr>
                </table>
            </div>
            <div class="table_content clear">
                <div class="tab_content">
                        <form class="search_form" id="search-condition"method="post" action="">
                            <div class="search_form_box clear">

                                <div class="search_group">
                                    <label>会员名称：</label>
                                    <input type="text" name="member_name" class="search_input" style="width:120px;"/>
                                </div>
                                <div class="search_group">
                                    <label>会员手机：</label>
                                    <input type="tel" name="mobile" class="search_input" style="width:120px;"/>
                                </div>
                                <div class="search_group">
                                    <label>优惠券代码</label>
                                    <input type="tel" name="coupon_code" class="search_input" style="width:120px;"/>
                                </div>
                                <div class="search_group">
                                    <label>状态：</label>
                                    <div class="form_select" style="margin-right:0;">
                                        <div class="search_select div_order">
                                            <div class="show_select status" data-value="2" style="width:96px;">未领用</div>
                                            <ul class="select_list">
                                            		<li value="1">未领用</li>
                                                    <li value="2">已领用</li>
                                                    <li value="3">已使用</li>
                                                    <li value="4">已作废</li>
                                                    <li value="5">全部</li>
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="status" value="1" class="select_value"/>
                                     </div>
                                </div>
                                <div class="search_group">
                                    <input type="button" name="button" class="search_button" value="搜索"/>
                                </div>
                            </div>
                        </form>
                     <div class="table_list" id="dataTable">                     
                       <table class="table table-bordered table_hover">
                           <thead class="">
                               <tr>
                                   <th>序号</th>
                                   <th>状态</th>
                                   <th>会员名称</th>
                                   <th>优惠券代码</th>
                                   <th>使用日期</th>
                                   <th>有效期至</th>
                                   <th>领用日期</th>
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

    <div class="fb-content form1" id="form_type" style="display:none;">
        <div class="box-title">
            <h5>查看类目</h5>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="role_from" class="form-horizontal">
                <div class="table_list" id="dataTable_type">                     
                           <table class="table table-bordered table_hover">
                               <thead class="form2_add_type">
                                   <tr>
                                       <th>类目名称</th>
                                   </tr>
                               </thead>
                               <tbody class="data_rows_type listcheck" id="listcheck_addty">
                               </tbody>
                           </table>
                            <!-- 暂无数据 -->
                            <div class="no-datas" style="display:none;">木有数据哟！</div>
                         </div>

              </div>
              <div class="form-group" style="width:100%;">
                <div id="page_div_type"></div>
              </div>
            </form>
        </div>
    </div>

    <div class="fb-content form1" id="form_product" style="display:none;">
        <div class="box-title">
            <h5>查看产品</h5>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="role_from" class="form-horizontal">
                <div class="table_list" id="dataTable_type">                     
                           <table class="table table-bordered table_hover">
                               <thead class="form2_add_type">
                                   <tr>
                                        <th>线路编号</th>
                                       <th>产品名称</th>
                                   </tr>
                               </thead>
                               <tbody class="data_rows_product listcheck" id="listcheck_addty">
                               </tbody>
                           </table>
                            <!-- 暂无数据 -->
                            <div class="no-datas" style="display:none;">木有数据哟！</div>
                         </div>

              </div>
              <div class="form-group" style="width:100%;">
                <div id="page_div_type"></div>
              </div>
            </form>
        </div>
    </div>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
$(function(){
	get_data();
	object.init();
})
$(".search_button").click(function(){  //查询数据
	object.init();
	return false;
})
var id = "<?php echo $id;?>";
var type = "<?php echo $type;?>";
var base_url = "<?php echo base_url();?>";
var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('/admin/a/coupon_manage/coupon_data/search_coupon')?>";
function get_data(){
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/coupon_data/coupon_details",
		type:"POST",
		data:{ id:id , type:type },
		async:false,
		dataType:"json",
		success:function(ret){
			//console.log(ret);
      var c_str="";
      var range = ""
      if(type==1){
            c_str="全站优惠券";
            range="APP整站";
          }else if(type==2){
            c_str="类目优惠券";
            range="<a id='check_type' href='javascript:void(0);'>查看类目</a>";
          }else if(type==3){
            c_str="店铺优惠券";
             range=ret.data.brand;
          }else if(type==4){
            c_str="产品优惠券";
            range="<a id='check_product' href='javascript:void(0);''>查看产品</a>";
          }else if(type==5){
            c_str="注册优惠券";
            range="APP整站";
          }
          $(".coupon_type").html(c_str);
          $(".coupon_range").html(range);
			if(ret.code==2000){				
				$(".coupon_price").html(ret.data.number);
				$(".min_price").html(ret.data.price);
				$(".number").html(ret.data.c_sum);
				$(".time").html(ret.data.c_value_time);
				$(".decription").html(ret.data.c_description);
			}else{
				layer.msg(ret.msg, {time:1500,icon: 2});
			}		
		},
		error:function(ret){
			layer.msg(ret.msg, {time:1500,icon: 2});
		}        
	});
}
//js对象

object = {
      init:function(){ //初始化方法
          var member_name=$("input[name='member_name']").val(); 
          var mobile=$("input[name='mobile']").val(); 
		  var status=$("input[name='status']").val();
		  var coupon_code=$("input[name='coupon_code']").val();
          //接口数据
          ajax_data={page:"1",id:id,member_name:member_name,mobile:mobile,status:status,coupon_code:coupon_code,pageSize:10}; 
          var list_data=object.send_ajax(post_url,ajax_data); //请求ajax 
          var total_page; //分页数
		  if(list_data.code==2000){
			  total_page=Math.ceil(list_data.data.pagedata.count/10); //分页数
		  }else{
			  total_page=0;
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
						  html=object.pageData(ret.curr,return_data.data.pagedata.pageSize,return_data.data.coupon_data);
						  $(".no-data").hide();
					}
					else if(return_data.code=="4001")
					{
						  html="";
						  $(".no-data").show();
					}
					else
					{
						layer.msg(return_data.msg, {icon: 2});
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
				  var c_status=data[i].c_status;
				  var c_str;
				  if(c_status==1){
					  c_str="未领用";
				  }else if(c_status==2){
					  c_str="已领用";
				  }else if(c_status==3){
					  c_str="已使用";
				  }else if(c_status==4){
					  c_str="已作废";
				  }
                  str += "<tr>";
                  str +=     "<td>"+data[i].id+"</td>";
                  str +=     "<td>"+c_str+"</td>";
                  str +=     "<td>"+data[i].nickname+"</td>";
        				  str +=     "<td>"+data[i].code+"</td>";
        				  
                  str +=     "<td>"+data[i].use_time+"</td>";
                  str +=     "<td>"+data[i].c_value_time+"</td>"; 
                  str +=     "<td>"+data[i].take_time+"</td>";
                   	
                  if(c_status==1||c_status==2){
					  str +=     '<td><a href="javascript:void(0);" onclick="zuofei('+data[i].id+',this)" class="action_type underline">作废</a></td>';
				  }else{
					  str +=     '<td><a href="javascript:void(0);" class="action_type underline not_click">作废</a></td>';
				  }            
                  str += "</tr>";
              }
              return str;
           
        },
      send_ajax:function(url,data){  //发送ajax请求，有加载层
            var ret;
            $.ajax({ url:url,type:"POST",data:data,async:false,dataType:"json",
                 success:function(data){
                      ret=data;					  
                 },
                 error:function(data){
                      ret=data;
                 }        
            });
              return ret;
      },
}

$(document).on("click","#check_type",function(){
  console.log(id);
    layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '600px',
           shadeClose: false,
           content: $('#form_type')
    });
    $.ajax({ url:base_url+"admin/a/coupon_manage/coupon_data/coupon_dest_looks",type:"get",data:{id:id},async:false,dataType:"json",
                 success:function(rlt){
                      laypage({
                        cont: 'page_div_type',
                        pages: 0,
                        jump: function(ret){ 
                            var str="";
                            
                            if(rlt.code=="2000"){
                                  for(var i = 0; i < rlt.data.length; i++)
                                  {
                                      str += "<tr>";
                                      str += "<td>"+rlt.data[i].name+"</td>";
                                      str += "</tr>";
                                  }
                                  
                            }
                            if(rlt.code=="4001")
                            {
                                str="";
                                $(".no-datas").show();
                            }
                            else
                            {
                              //layer.msg(rlt.msg, {icon: 2});
                              $(".no-datas").hide();
                            }
                            $(".data_rows_type").html(str);
                        }    
                    })           
                 },
                 error:function(rlt){
                     
                 }        
            });
    
})
$(document).on("click","#check_product",function(){
  console.log(id);

    layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '600px',
           shadeClose: false,
           content: $('#form_product')
    });
    $.ajax({ url:base_url+"admin/a/coupon_manage/coupon_data/coupon_line_looks",type:"get",data:{id:id},async:false,dataType:"json",
                 success:function(rlt){
                      laypage({
                        cont: 'page_div_type',
                        pages: 0,
                        jump: function(ret){ 
                            var str="";
                            
                            if(rlt.code=="2000"){
                                  for(var i = 0; i < rlt.data.length; i++)
                                  {
                                      str += "<tr>";
                                      str += "<td>"+rlt.data[i].linecode+"</td>";
                                      str += "<td>"+rlt.data[i].linename+"</td>";
                                      str += "</tr>";
                                  }
                            }
                            if(rlt.code=="4001")
                            {
                                str="";
                                $(".no-datas").show();
                            }
                            else
                            {
                              //layer.msg(rlt.msg, {icon: 2});
                              $(".no-datas").hide();
                            }
                            $(".data_rows_product").html(str);
                        }    
                    })           
                 },
                 error:function(rlt){
                     
                 }        
            });
    
})

function send(id,obj){
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/code_data/code_send",
		type:"POST",
		data:{ id:id },
		async:false,
		dataType:"json",
		success:function(ret){
			console.log(ret);
			if(ret.code==2000){				
				layer.msg("操作成功", {time: 1500,icon: 1});
				$(obj).attr("onclick","").addClass("not_click");;
			}else{
				layer.msg(ret.msg, {icon: 2});
			}		
		},
		error:function(ret){
			layer.msg(ret.msg, {icon: 2});
		}        
	});
}
function zuofei(id,obj){
	layer.confirm('您确定要执行作废操作？', {
		btn: ['确定','取消'] //按钮
	}, function(){
		$.ajax({ 
			url:base_url+"admin/a/coupon_manage/coupon_data/coupon_void",
			type:"POST",
			data:{ id:id },
			async:false,
			dataType:"json",
			success:function(ret){
				console.log(ret);
				if(ret.code==2000){				
					layer.msg("操作成功", {time: 1500,icon: 1});
					$(obj).attr("onclick","").addClass("not_click");;
				}else{
					layer.msg(ret.msg, {icon: 2});
				}		
			},
			error:function(ret){
				console.log(ret);
				layer.msg(ret.msg, {icon: 2});
			}        
		});
	}, function(){
	
	});
}

</script>
</html>
