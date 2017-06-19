<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<?php  $this->load->view("admin/t33/common/js_view"); ?>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
 #choiceCheck .pr_resource {  width: 100%;margin-top:10px; }
 #choiceCheck li { padding-left: 40px; position: relative; }
 #choiceCheck .inputCheck {left: 20px;opacity: 1; }
 .lower-resource li { float: left; line-height: 25px;width: 160px !important; }
 #choiceCheck  input{width: 18px;}
 .pr_resource { padding-left:0 !important;}
 
</style>
</head>
<body>
<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>权限管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">角色管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">角色管理</a></li> 
                    </ul>
                </div>
                <div class="tab_content">
                        <form class="search_form" method="post" id="search-condition" action="">
                            <div class="search_form_box clear">

                                <div class="search_group">
                                    <label>名称：</label>
                                    <input type="text" name="name" class="search_input" style='width:120px;'/>
                                </div>

                                <div class="search_group">
                                    <input type="button" name="button" class="search_button" value="搜索"/>
                                </div>
                                <span class="alert_msg1 btn btn_green" style="margin-top: 3px;">添加角色</span>
                            </div>
                        </form>
                     <div class="table_list" id="dataTable"></div> 
                    <div class="table_list">
                       <table class="table table-bordered table_hover">
                           <thead class="">
                               <tr>
                                   <th style="width:140px;"> 角色名称</th>
                                   <th style="width:140px;">管理模块</th>
                                   <th style="width:140px;">管理员</th>
                                   <th style="width:120px;">描述</th>
                                   <th style="width:80px;">操作</th>
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


<!--添加角色的弹框-->
<div class="fb-content" id="form1" style="display:none;">
    <div class="box-title">
        <h5>角色管理</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="role_from" class="form-horizontal">
           <div class="form-group">
                <div class="fg-title">角色名称：<i>*</i></div>
                <div class="fg-input"><input type="text" class="role_name" name="role_name" ></div>
           </div>
        <!--    <div class="form-group">
             <div class="fg-title">选择管理员：<i>*</i></div>
             <div class="fg-input">
                 <div class="foot" id="employee_content">
                   <?php if(!empty($employee)){
                           foreach ($employee as $key => $value) {
                   ?>
                       <label class="check_ico" style="  margin-right: 20px;">
                             <input type="checkbox" name="eid[]" value="<?php echo  $value['id'];?>">
                             <span class="text"><span> <i></i></span><?php echo  $value['realname'];?></span>
                       </label>
                   <?php } } ?>
                   
                 </div>
             </div>
        </div> -->
            <div class="form-group">
                <div class="fg-title">选择模块：<i>*</i></div>
                <div class="fg-input" id="choiceCheck">
                     <ul class="directory_content">
                          <?php if(!empty($directory)){ 
                                foreach ($directory as $key => $value) {     
                            ?>
                           <li class="pr_resource">
                                <input class="inputCheck input_one" type="checkbox" value="<?php echo $value['pid']; ?>" name="directory[]">
                                <?php echo $value['pname']; ?>
                                     <ul class="lower-resource">
                                           <?php if(!empty($value['two'])){
                                                      foreach ($value['two'] as $k => $v) {                      
                                            ?>
                                            <li class="cl_resource"><label>
                                                <input class="inputCheck input_two" type="checkbox" value="<?php echo $v['directory_id']; ?>" name="directory[]">
                                                  <?php echo $v['name']; ?>  </label>                            
                                            </li>
                                            <?php }  } ?>
                                            <div class="clear"></div>
                                      </ul>
                           </li>
                           <?php } } ?>
                     </ul>
                </div>
            </div>

            <div class="form-group">
                <div class="fg-title">描述：</div>
                <div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
            </div>

            <div class="form-group">
                <input type="hidden" name="roleid" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but submit_role" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<!--添加角色的弹框end-->            
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
//---------------------------------------列表数据---------------------------------------------------------

$(function(){
     object.init(); //加载
})

  //js对象
  var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('admin/t33/role/role_list/getRoleJson')?>";

$(".search_button").click(function(){  //查询数据
	flag=true;
     object.init();
     return false;
})

object = {
      init:function(){ //初始化方法

          var name=$("input[name='name']").val(); 
         
          //接口数据
          ajax_data={page:"1",name:name}; 

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
                  str += "<tr>";
                  str +=     "<td>"+data[i].rolename+"</td>";
                  str +=     " <td>"+data[i].directory+"</td>";
                  str +=     "<td>"+data[i].admin+"</td>";
                  str +=     "<td>"+data[i].remark+"</td>";

                  var a_str="";
                  if(data[i].union_id!=0)
                  a_str='<a href="javascript:void(0);" onclick="edit('+data[i].roleid+')" class="action_type">修改</a>&nbsp;';
                  str +=    '<td>'+a_str+'</td>';
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
//---------------------------------------------列表数据end---------------------------------------------------
//添加角色弹框
$(".alert_msg1").click(function(){
    
     $("#employee_content input[name='eid[]']").each(function(){ 
           var id=$(this).val();
          $(this).next().removeClass('checked');
          $(this).attr("checked",false);
      })
  
     $("#choiceCheck input[name='directory[]']").each(function(){ 
          $(this).attr("checked",false);    
      })
     $('#role_from').find('input[name="role_name"]').val('');
     $('#role_from').find('textarea[name="beizhu"]').val(''); 
     $('input[name="roleid"]').val(''); 
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: ['850px', '80%'],
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
});


//编辑菜单
function edit(roleid){
  $('input[name="roleid"]').val(roleid);
  jQuery.ajax({ type : "POST",data :"roleid="+roleid,url : "<?php echo base_url()?>admin/t33/role/role_list/getRoleRow",
  success : function(data) {
                 var data=eval("("+data+")");
                 $('#role_from').find('input[name="role_name"]').val(data.role.rolename);
                 $('#role_from').find('textarea[name="beizhu"]').val(data.role.remark);
                 var checkbox_html='';
                //--------------------------------选模块-----------------------------

                     $("#choiceCheck input[name='directory[]']").each(function(index){ 
                         $obj=$(this);
                         var id=$(this).val();
                         $obj.prop({checked:false}); //先全部不勾选
                    	 $.each(data.roleDirectory, function(a, b)
                        {
                           
                            if(b.directory_id==id)
                            {
                                  $obj.prop({checked:true});
                            }
                            else
                            {
                                if($obj.is(':checked')==false)  //已经勾选上的不进行操作
                            	$obj.prop({checked:false});
                            	
                            }
                            
                      })
                });
              //--------------------------------选模块-----------------------------
           }
      });

      layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: ['850px', '80%'],
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
}

//当点击二级菜单input时，若该级父级菜单下有勾选的input，则这个父级菜单input也要勾选
$(".input_two").click(function(){
       $obj=$(this);
       var action=false;
	   $obj.parent().parent().find(".input_two").each(function(){
           
		   if($(this).is(':checked'))
			   action=true;
  
		  })
      $obj.parent().parent().parent().find(".input_one").prop({checked:action});
})
//当点击一级菜单input时，全选及反选
$(".input_one").click(function(){

	if($(this).is(':checked'))
	{
		$(this).parent().find(".input_two").each(function(){
	            $(this).prop({checked:true});
		 })
		
	}
   else
   {
	   $(this).parent().find(".input_two").each(function(){
           $(this).prop({checked:false});
	 })
   }

    /* $obj=$(this);
       var action=false;
	   $obj.parent().parent().find(".input_two").each(function(){
           
		   if($(this).is(':checked'))
			   action=true;
  
		  })
	  alert(action);
      $obj.parent().parent().parent().find(".input_one").prop({checked:action});*/
})
//添加编辑角色
$(".submit_role").click(function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
      var name=$('#role_from').find('input[name="role_name"]').val();
      if(name==''){
           tan('角色名称不能为空');
           return false;
      }

      $.post("/admin/t33/role/role_list/add_role",$('#role_from').serialize(),function(data){
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
</script>
</html>