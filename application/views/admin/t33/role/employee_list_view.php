<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<?php  $this->load->view("admin/t33/common/js_view"); ?>

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
</style>
</head>
<body>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>权限管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">员工管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">员工管理</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                        <form class="search_form" id="search-condition"method="post" action="">
                            <div class="search_form_box clear">

                                <div class="search_group">
                                    <label>姓名：</label>
                                    <input type="text" name="search_name" class="search_input" style="width:120px;"/>
                                </div>
                                <div class="search_group">
                                    <label>手机号：</label>
                                    <input type="text" name="search_moblie" class="search_input" style="width:120px;"/>
                                </div>

                                <div class="search_group">
                                    <input type="button" name="button" class="search_button" value="搜索"/>
                                </div>
                                 <span class="alert_msg1 btn btn_green" style="margin-top:3px;">添加员工</span>
                            </div>
                        </form>
                     <div class="table_list" id="dataTable">                     
                           <table class="table table-bordered table_hover">
                               <thead class="">
                                   <tr>
                                       <th>员工账号</th>
                                       <th>姓名</th>
                                       <th>手机号</th>
                                       <th>邮箱</th>
                                       <th>添加时间</th>
                                      <th>角色</th>
                                       <th>启用</th>
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
<!--添加菜单的弹框-->
<div class="fb-content" id="form1" style="display:none;">
    <div class="box-title">
        <h5>员工管理</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="employee_from" class="form-horizontal ">
           <div class="form-group">
                <div class="fg-title">选择角色：<i>*</i></div>
                <div class="fg-input">
                       <ul class="role_content">
                       <?php if(!empty($roleData)){
                              foreach ($roleData as $key => $value) {
                      ?>
                         <li><label><input type="radio" class="fg-radio" <?php if($key=='0') echo 'checked';?> name="roleid" value="<?php echo  $value['roleid'];?>"><?php echo  $value['rolename'];?></label></li>
                      <?php } } ?> 
                    </ul>
                </div>
           </div>
          <div class="form-group div2">
                <div class="fg-title">账号：<i>*</i></div>
                <div class="fg-input"><input type="text" class="loginname" name="loginname" value="登录账号"></div>
            </div>
            <div class="form-group">
                <div class="fg-title">密码：<i>*</i></div>
                <div class="fg-input">
                       <input type="password" name="password" id="password" placeholder="登录密码" >
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">确认密码：<i>*</i></div>
                <div class="fg-input"><input type="password" class="repass" placeholder="确认登录密码" name="repass" value=""></div>
            </div>
            <div class="form-group">
                <div class="fg-title">消息角色：<i>*</i></div>
                <div class="fg-input">
                       <ul class="role_content">
                       <?php if(!empty($msgrole)){
                              foreach ($msgrole as $k => $v) {
                      ?>
                         <li><label><input type="checkbox" class="fg-radio input_checkbox" name="checkbox[]" value="<?php echo  $v['id'];?>"><?php echo  $v['role'];?></label></li>
                      <?php } } ?> 
                    </ul>
                </div>
           </div>
             <div class="form-group">
                <div class="fg-title">真实姓名：<i>*</i></div>
                <div class="fg-input"><input type="text" class="realname" name="realname" value=""></div>
            </div>
            <div class="form-group">
                <div class="fg-title">手机号码：<i>*</i></div>
                <div class="fg-input"><input type="text" class="mobile" name="mobile" value=""></div>
            </div>
              <div class="form-group">
                <div class="fg-title">邮箱：<i></i></div>
                <div class="fg-input"><input type="text" class="email" name="email" value=""></div>
            </div>
            <div class="form-group">
                <div class="fg-title">是否启用：<i>*</i></div>
                <div class="fg-input">
                    <ul>
                        <li><label><input type="radio" class="fg-radio" name="isopen" value="0">否</label></li>
                        <li><label><input type="radio" class="fg-radio" name="isopen" checked="checked" value="1">是</label></li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">备注：</div>
                <div class="fg-input"><textarea name="remark" maxlength="30" placeholder="最多30个字"></textarea></div>
            </div>

            <div class="form-group">
                <input type="hidden" name="employee_id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but submit_employee" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<!--添加菜单的弹框end-->
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
//-------------------------------------------数据列表--------------------------------------------------------
/*var columns = [ {field : 'loginname',title : '员工账号',width : '200',align : 'center'},
                {field : 'realname',title : '姓名',width : '200',align : 'center'},
                {field : 'mobile',title : '手机号',width : '140',align : 'center'},
                {field : 'email',title : '邮箱',align : 'center', width : '250'},
                {field : 'addtime',title : '添加时间',align : 'center', width : '100'},
                {field : 'rolename',title : '角色',align : 'center', width : '120'},
                {field : '',title : '启用',align : 'center', width : '100',
                      formatter: function(item){
                            if(item.status==1){
                                  return '已启用';
                            }else{
                                  return '不启用';
                            }
                      }
                },
                {field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
                      var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="action_type">修改</a>&nbsp;';
                //    button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="action_type">删除</a>';
                      return button;
                }
            }];   

$("#dataTable").pageTable({
    columns:columns,
    url:'/admin/t33/role/employee_list/getEmployeeJson',
    pageNumNow:1,
    pageSize:5,
    searchForm:'#search-condition',
    tableClass:'table table-bordered table_hover',
});*/
$(function(){
     object.init(); //加载
})

  //js对象
var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('admin/t33/role/employee_list/getEmployeeJson')?>";

$(".search_button").click(function(){  //查询数据
	flag=true;
    object.init();
    return false;
})

object = {
      init:function(){ //初始化方法
          var search_name=$("input[name='search_name']").val(); 
          var search_moblie=$("input[name='search_moblie']").val(); 
           
          //接口数据
          ajax_data={page:"1",search_name:search_name,search_moblie:search_moblie}; 

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
                  var isopen=data[i].status;

                  if(isopen==1){
                      var isopenstr="启用";
                  }else{
                      var isopenstr="不启用";
                  }
                  str += "<tr>";
                  str +=     "<td>"+data[i].loginname+"</td>";
                  str +=     " <td>"+data[i].realname+"</td>";
                  str +=     "<td>"+data[i].mobile+"</td>";
                  str +=     "<td>"+data[i].email+"</td>";
                  str +=     "<td>"+data[i].addtime+"</td>";
                  str +=     "<td>"+data[i].rolename+"</td>";
                  str +=     "<td>"+isopenstr+"</td>";
                  str +=    '<td><a href="javascript:void(0);" onclick="edit('+data[i].id+')" class="action_type">修改</a>&nbsp;</td>';
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
//添加员工弹框
$(".alert_msg1").click(function(){
	 $("#password").attr("placeholder","登录密码");
     $(".repass").attr("placeholder","确认登录密码");
      $('#employee_from').find('input[name="loginname"]').val('');
      $('#employee_from').find('input[name="realname"]').val('');
      $('#employee_from').find('input[name="mobile"]').val('');
      $('#employee_from').find('textarea[name="remark"]').val('');
      $('#employee_from').find('input[name="email"]').val('');
      $('#employee_from').find('input[name="password"]').val('');
      $('#employee_from').find('input[name="repass"]').val('');
      $('#employee_from').find('input[name="employee_id"]').val('');
      $(".div2").css("display","block");
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '600px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
});
//添加员工
$(".submit_employee").click(function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
     $.post("/admin/t33/role/employee_list/add_employee",$('#employee_from').serialize(),function(data){
           data = eval('('+data+')');
           if (data.code == 2000) {
               tan2(data.msg);
               setTimeout(function(){t33_close();},800);
               t33_refresh();
                
           } else if(data.code == 5000){
                tan(data.msg); 
           }else {
        	   tan(data.msg); 
           }
     })
      
     return false;
	}
});
//编辑员工
function edit(employee_id){
      jQuery.ajax({ type : "POST",data :"employee_id="+employee_id,url : "<?php echo base_url()?>admin/t33/role/employee_list/getEmployeeRow",
           success : function(data) {
                var data=eval("("+data+")");
                if(data.code==2000){
                      $('#employee_from').find('input[name="password"]').val('');
                      $('#employee_from').find('input[name="repass"]').val('');
                      $('#employee_from').find('input[name="loginname"]').val(data.employee.loginname);
                      $('#employee_from').find('input[name="realname"]').val(data.employee.realname);
                      $('#employee_from').find('input[name="mobile"]').val(data.employee.mobile);
                      $('#employee_from').find('textarea[name="remark"]').val(data.employee.remark);
                      $('#employee_from').find('input[name="email"]').val(data.employee.email);
                      $('#employee_from').find('input[name="employee_id"]').val(data.employee.id);
                      $(".div2").css("display","none");

                      $("#password").attr("placeholder","不填默认原密码");
                      $(".repass").attr("placeholder","不填默认原密码");
                  
                      //选择角色
                     $('input[name="roleid"]').each(function (index,domEle){
                           var val=$(this).val();
                           if(data.employee.role_id==val){
                                    $(this).attr("checked","checked"); 
                                 //   $(this).attr("checked",false); 
                           }else{
                                    $(this).attr("checked",false); 
                           }
                     });
                     //是否启用
                     $('input[name="isopen"]').each(function (index,domEle){ 
                              var id=$(this).val();
                              if(id==data.employee.status){
                                  $(this).attr("checked","checked"); 
                              }else{
                                    $(this).attr("checked",false); 
                              }
                     });   

                     //消息角色
                     var arr=[];
                     for(var i in data.msgrole)
                     {
                         arr.push(data.msgrole[i].role_id);
                     }
                     $('.input_checkbox').each(function (index,domEle){ 
                         var id=$(this).val();
                         
                         if(arr.indexOf(id)>=0){
                             $(this).attr("checked","checked"); 
                         }else{
                               $(this).attr("checked",false); 
                         }
                     });  
                     //end
                       
                }else{
                     alert(data.msg);
                }
           }
      });

      layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '600px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
}
</script>
</html>