<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<?php  $this->load->view("admin/t33/common/js_view"); ?>

<style type="text/css">
.page_content { margin-top:0;padding-top:5px;}
.search_form  { margin:0;}
.search_form_box .search_group label { width:auto;}
.search_group { margin-right:20px;}
.search_input { height:auto !important;line-height:23px !important;padding:0 2px !important;border:1px solid #bbb !important;font-size:13px !important;}
.search_button { margin:0;}
.table-bordered { border-collapse:collapse;}
.data_rows tr td { text-align:center !important;}
.underline { text-decoration:underline;}
.table_list { min-height:300px;}

.table tbody tr td a.not_click,span { color:#aaa !important;cursor: default !important;text-decoration:none !important;}


</style>
</head>
<body>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">      
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">               
            <!-- tab切换表格 -->
            <div class="table_content clear">
                <div class="tab_content">
                        <form class="search_form" id="search-condition"method="post" action="">
                            <div class="search_form_box clear">

                                <div class="search_group">
                                    <label>会员名称：</label>
                                    <input type="text" name="name" class="search_input" style="width:120px;"/>
                                </div>
                                <div class="search_group">
                                    <label>会员手机：</label>
                                    <input type="tel" name="mobile" class="search_input" style="width:120px;"/>
                                </div>
								<div class="search_group">
                                    <label>优惠券代码：</label>
                                    <input type="text" name="code" class="search_input" style="width:160px;"/>
                                </div>
                                <div class="search_group">
                                    <label>状态：</label>
                                    <div class="form_select" style="margin-right:0;">
                                        <div class="search_select div_order">
                                            <div class="show_select status" data-value="2" style="width:96px;">已领用</div>
                                            <ul class="select_list">
                                                    <li value="2">已领用</li>
                                                    <li value="3">已使用</li>
                                                    <li value="5">全部</li>
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="status" value="2" class="select_value"/>
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
                                   <th>会员名称</th>
                                   <th>手机号</th>
                                   <th>优惠卷类型</th>
                                   <th>适用范围</th>
                                   <th>优惠券代码</th>
                                   <th>优惠券金额</th>
                                   <th>使用条件</th>
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

<!-- 修改 -->
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
     object.init(); //加载
})
$(".search_button").click(function(){  //查询数据
     object.init();
     return false;
})
//js对象
var base_url = "<?php echo base_url();?>";
var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('/admin/a/coupon_manage/coupon_record/coupon_list')?>";
object = {
      init:function(){ //初始化方法
          var name=$("input[name='name']").val(); 
          var mobile=$("input[name='mobile']").val(); 
          var code=$("input[name='code']").val();
		  var status=$("input[name='status']").val();
		  
          //接口数据
          ajax_data={page:"1",name:name,mobile:mobile,code:code,status:status,pageSize:15}; 
          var list_data=object.send_ajax(post_url,ajax_data); //请求ajax 
          var total_page; //分页数
		  if(list_data.code==2000){
			  total_page=Math.ceil(list_data.data.pagedata.count/15); //分页数
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
                console.log(data[i])
    				  var c_type=data[i].type;
    				  var c_str;
              var d_str;
    				  if(c_type==1){
    					  c_str="全站优惠券";
                d_str=data[i].use_range;
    				  }else if(c_type==2){
    					  c_str="类目优惠券";
                d_str='<a href="javascript:void(0);" onclick="check_type('+data[i].param+')" id="check_type1" class="underline" >'+data[i].use_range+'</a>';
    				  }else if(c_type==3){
    					  c_str="店铺优惠券";
                d_str=data[i].use_range;
    				  }else if(c_type==4){
    					  c_str="产品优惠券";
                d_str='<a href="javascript:void(0);" onclick="check_product('+data[i].param+')" id="check_product1" class="underline" >'+data[i].use_range+'</a>';
    				  }else if(c_type==5){
    					  c_str="注册优惠券";
                d_str=data[i].use_range;
    				  }else if(c_type==6){
    					  c_str="兑换码";
                d_str=data[i].use_range;
    				  }
                      str += "<tr>";
                      str +=     "<td>"+data[i].id+"</td>";
                      str +=     "<td>"+data[i].nickname+"</td>";
    				          str +=     "<td>"+data[i].mobile+"</td>";
                      str +=     "<td>"+c_str+"</td>";
                      str +=     "<td>"+d_str+"</td>";
                      str +=     "<td>"+data[i].code+"</td>";
                      str +=     "<td>"+data[i].number +"元</td>";
                      str +=     "<td>满"+data[i].price+"可使用</td>";
    				  if(data[i].use_time==0){
    					  str +=     "<td>&nbsp;</td>";
    				  }else{
    					  str +=     '<td><a href="javascript:void(0);" class="underline" onclick="order_detail('+data[i].id+')">'+data[i].use_time+'</a></td>';
    				  }
    				  str +=     "<td>"+data[i].c_value_time+"</td>";
    				  str +=     "<td>"+data[i].take_time+"</td>";
    				  if(data[i].c_status==3){
    					  str +=    '<td><span class="not_click">作废</span></td>';
    				  }else{
    					  str +=    '<td><a href="javascript:void(0);" onclick="edit('+data[i].id+','+c_type+',this)" class="action_type underline">作废</a></td>';
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
//-------------------------------------------数据列表end--------------------------------------------------------
function order_detail(id){
  $.ajax({
      url:base_url+"admin/a/coupon_manage/coupon_record/get_order_id",
      type:"POST",
      data:{ id:id  },
      dataType:"json",
      success:function(ret){
        console.log(ret); 
        if(ret.code==2000){
          var _id=ret.data.id   
          window.top.openWin({
                type: 2,
                area: ['1020px', '600px'],
                title :'订单详情',
                fix: true, //不固定
                maxmin: true,
                content: base_url+"admin/a/orders/order/order_detail_info?id="+_id+'&type=1'
            });
        }else{
          layer.msg(ret.msg, {icon: 2});  
        }   
      },
      error:function(ret){    
        console.log(ret);
        layer.msg("操作失败", {icon: 2});
      }        
    });
}
function edit(id,type,obj){
  layer.confirm('您确定要执行作废操作？', {
    btn: ['确定','取消'] //按钮
  }, function(){
    $.ajax({
      url:base_url+"admin/a/coupon_manage/coupon_data/coupon_void",
      type:"POST",
      data:{ id:id , type:type },
      async:false,
      dataType:"json",
      success:function(ret){
        console.log(ret); 
        if(ret.code==2000){   
          layer.msg("操作成功", {time: 1500,icon: 1});
          $(obj).attr("onclick","").addClass("not_click");
        }else{
          layer.msg(ret.msg, {icon: 2});  
        }   
      },
      error:function(ret){    
        console.log(ret);
        layer.msg("操作失败", {icon: 2});
      }        
    });
  }, function(){
  
  });
}


function check_type(id){
 
  //console.log('11');
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
    
}

function check_product(id){
  
  //console.log('11');
 
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
    
}
</script>
</html>
