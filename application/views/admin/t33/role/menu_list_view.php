<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<style type="text/css">
.search_form_box .search_group label{width:70px;height:20px;line-height:28px;padding:0;margin:0;}
.search_form_box .search_group input{background:#fff !important;}
</style>
</head>
<body>

<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="<?php echo base_url('admin/t33/role/menu_list/index');?>" class="main_page_link"><i></i>菜单管理</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">菜单管理</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
                <div class="itab">
                    <ul> 
                        <li static="1"><a href="#tab1" class="active">菜单管理</a></li> 
                        <li static="1"><a href="<?php echo base_url('admin/t33/role/menu_list/all_order');?>">所有订单</a></li> 
                       
                    </ul>
                </div>
                <div class="tab_content">
                    <div class="table_list">
                        <form class="search_form" method="post" id="search-condition" action="">
                            <div class="search_form_box clear">
                            <div class="search_group">
                                     <label>上级目录：</label>
                                     <div class="form_select">
                                          <div class="search_select">
                                                <select name="sch_directory" id="sch_directory" style="width:137px;height:28px;">
                                                     <option value="0">默认顶级菜单</option>
                                                     <?php if(!empty($pdirectory)){ 
                                                            foreach ($pdirectory as $key => $value) {       
                                                      ?>
                                                     <option value="<?php echo $value['directory_id'] ;?>"><?php echo $value['name'] ;?></option>
                                                     <?php }  }?>
                                               </select>
                                          </div>
                                     </div>
                           </div> 
                          <div class="search_group">
                                <label style="width:40px;">名称：</label>
                                    <input type="text" style="height:26px;" name="sch_name" class="search_input" placeholder="名称"/>
                                </div>

                                <div class="search_group">
                                    <input type="button" name="submit" class="search_button" value="搜索"/>
                                </div>
                                 <span class="alert_msg1 btn btn_green" style="margin-top:3px;">添加菜单</span>
                            </div>
                            </div>
                        </form>
                     </div>
                     <div class="table_list" id="dataTable">
                           <table class="table table-bordered table_hover">
                               <thead class="">
                                   <tr>
                                       <th style="width:140px"> 名称</th>
                                       <th style="width:140px">url地址</th>
                                       <th style="width:140px">上级</th>
                                      
                                       <th style="width:140px">排序</th>
                                      <th style="width:140px">是否启用</th>
                                       <th style="width:150px">描述</th>
                                       <th style="width:100px">操作</th>
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
<!--添加菜单的弹框-->
<div class="fb-content" id="form1" style="display:none;">
    <div class="box-title">
        <h5>菜单管理</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="menu_from" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">选择上一级：</div>
                <div class="fg-input" id="add-city">
                     <select name="pid" id="directory_pid" style="width:137px">
                           <option value="0">默认顶级菜单</option>
                           <?php if(!empty($pdirectory)){ 
                                  foreach ($pdirectory as $key => $value) {       
                            ?>
                           <option value="<?php echo $value['directory_id'] ;?>"><?php echo $value['name'] ;?></option>
                           <?php }  }?>
                     </select>
                </div>
            </div>
           
          <div class="form-group">
                <div class="fg-title">名称：<i>*</i></div>
                <div class="fg-input"><input type="text" class="name" name="name" value=""></div>
            </div>
            <div class="form-group">
                <div class="fg-title">url地址：<i>*</i></div>
                <div class="fg-input">
                       <input type="text" name="directory_url" >
                </div>
            </div>
            <div class="form-group">
                <div class="fg-title">排序：</div>
                <div class="fg-input"><input type="text" class="showorder" name="showorder" value="999"></div>
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
                <div class="fg-title">描述：</div>
                <div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
            </div>

            <div class="form-group">
                <input type="hidden" name="directory_id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but submit_menu" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>
<!--添加菜单的弹框end-->

<script>
//-------------------------------------------数据列表--------------------------------------------------------
/*var columns = [ {field : 'name',title : '名称',width : '200',align : 'center'},
                {field : 'url',title : 'url地址',width : '200',align : 'center'},
                {field : 'pname',title : '上级',width : '140',align : 'center'},
                {field : 'rolename',title : '角色',align : 'center', width : '250'},
                {field : 'showorder',title : '排序',align : 'center', width : '100'},
                {field : 'description',title : '描述',align : 'center', width : '200'},
                {field : '',title : '启用',align : 'center', width : '100',
                      formatter: function(item){
                            if(item.isopen==1){
                                  return '已启用';
                            }else{
                                  return '不启用';
                            }
                      }
                },
                {field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
                      var button = '<a href="javascript:void(0);" onclick="edit('+item.directory_id+')" class="action_type">修改</a>&nbsp;';
                //    button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="action_type">删除</a>';
                      return button;
                }
            }];        
$("#dataTable").pageTable({
    columns:columns,
    url:'/admin/t33/role/menu_list/getDirectoryJson',
    pageNumNow:1,
    pageSize:10,
    searchForm:'#search-condition',
    tableClass:'table table-bordered table_hover',
});*/

$(function(){
     object.init(); //加载
})
$(".search_button").click(function(){  //查询数据
     object.init();
     return false;
})
  //js对象
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('admin/t33/role/menu_list/getDirectoryJson')?>";
object = {
      init:function(){ //初始化方法
          var sch_directory=$("#sch_directory").val();
          var sch_name=$("input[name='sch_name']").val(); 
          
          //接口数据
          ajax_data={page:"1",sch_name:sch_name,sch_directory:sch_directory}; 
          var list_data=object.send_ajax(post_url,ajax_data); //请求ajax
          var total_page=list_data.data.total_page; //分页数
          
          //调用分页
          laypage({
              cont: 'page_div',
              pages: total_page,
              jump: function(ret){
                  
		            	    var html=""; //html内容
		            	    
		            	    $(".data_rows").html(html);
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
		
				        	//写html内容
                            if(return_data.code=="2000")
                            {
                                  html+=object.pageData(ret.curr,return_data.data.page_size,return_data.data.result);
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

        },
        pageData:function(curr,page_size,data){  //生成表格数据 
              var str = '', last = curr*page_size - 1;
              last = last >= data.length ? (data.length-1) : last;
              for(var i = 0; i <= last; i++)
              {
                var openstr=data[i].isopen;
                if(openstr==1){
                    openstr='启用';
                }else{
                    openstr='不启用';
                }
                  str += "<tr>";


                  var higher_depart="";
                  if(data[i].pname=="")
                  {
                      
                  }
                  else
                  {
                  	higher_depart=data[i].pname;
              		higher_depart += "<span class='right_jiantou' style='color:#000;'>&gt;</span>";
                  }
                  
                  str +=     "<td>"+higher_depart+"<a href='javascript:void(0);' onclick='edit("+data[i].directory_id+")' class='action_type'>"+data[i].name+"</a></td>";
                  str +=     " <td>"+data[i].url+"</td>";
                  str +=     "<td>"+data[i].pname+"</td>";
                 
                  str +=     "<td>"+data[i].showorder+"</td>";
                  str +=     "<td>"+data[i].isopen+"</td>";
                  str +=     "<td>"+data[i].description+"</td>";
                  str +=    '<td><a href="javascript:void(0);" onclick="edit('+data[i].directory_id+')" class="action_type">修改</a>&nbsp;</td>';
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
//添加菜单弹框
$(".alert_msg1").click(function(){
	 $('#menu_from').find('input[name="name"]').val('');
     $('#menu_from').find('input[name="directory_url"]').val('');
     $("#directory_pid option[value=0]").attr("selected", true); 
     $('#menu_from').find('textarea[name="beizhu"]').val('');
     $('#menu_from').find('input[name="roleid[]"]').val(''); 
     $('#menu_from').find('input[name="directory_id"]').val('');
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '700px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
});
//添加菜单
$(".submit_menu").click(function(){
	
      var name=$('#menu_from').find('input[name="name"]').val();
      var url=$('#menu_from').find('input[name="directory_url"]').val();
      var showorder=$('#menu_from').find('input[name="showorder"]').val();
      var description=$('#menu_from').find('textarea[name="beizhu"]').val();
      var roleid=$('#menu_from').find('input[name="roleid[]"]').val(); 
     /*  if( $("#directory_pid option:selected").val()=="0")
      {
    	  tan('请选择上一级菜单');
          return false;
      }  */
      if(name==''){
           tan('名称不能为空');
           return false;
      }
     if(url==''){
    	 tan('地址不能为空');
           return false;
      }
      $.post("/admin/t33/role/menu_list/add_directory",$('#menu_from').serialize(),function(data){
           data = eval('('+data+')');
           if (data.code == 2000) {
        	   tan2(data.msg);
               setTimeout(function(){t33_close();},800);
               t33_refresh();
           } else if(data.code == 5000){
                tan(data.msg); 
           }else {
                layer.alert(data.msg, {icon: 2});
           }
     })
  //  $('#form1').hide();
  //$('.layui-layer-close').click();   
     return false;
});
//编辑菜单
function edit(directory_id){
      jQuery.ajax({ type : "POST",data :"directory_id="+directory_id,url : "<?php echo base_url()?>admin/t33/role/menu_list/getDirectoryRow",
           success : function(data) {
                var data=eval("("+data+")");
                var count=$("#directory_pid option").length; 
                var pid=data.directory.pid;
                for(var i=0;i<count;i++){  //选择上一级
                   var value= $("#directory_pid").get(0).options[i].value;  
                   $("#directory_pid option[value='"+pid+"']").attr("selected", true); 
                } 
                var isopen=data.directory.isopen;
                if(isopen==0){
                      $("input[name='isopen'][value=0]").attr("checked",true); 
                }else{
                      $("input[name='isopen'][value=1]").attr("checked",true); 
                }
              var checkbox_html='';
             
               <?php if(!empty($roleData)){
                  foreach ($roleData as $key => $value) {
               ?>
/*                      $.each(data.role, function(key, val) {
                     var roleid=<?php echo $value['roleid']; ?>;
                     checkbox_html=checkbox_html+'<label class="check_ico" style="  margin-right: 20px;">';
                    
                     if(val.roleid==roleid){   
                          checkbox_html=checkbox_html+'<input type="checkbox" checked name="roleid[]" value="<?php echo  $value['roleid'];?>">';                       
                           checkbox_html=checkbox_html+'<span class="text checked"><span> <i></i></span><?php echo  $value['rolename'];?></span>';
                          
                     }else{
                          checkbox_html=checkbox_html+'<input type="checkbox" name="roleid[]" value="<?php echo  $value['roleid'];?>">';
                           checkbox_html=checkbox_html+'<span class="text"><span> <i></i></span><?php echo  $value['rolename'];?></span>';
                    }
                    checkbox_html=checkbox_html+'</label>';
                     })*/
               <?php } } ?>

                $.each(data.role, function(a, b) {
                     $("#menu_from input[name='roleid[]']").each(function(){ 
                            var id=$(this).val() ;
                            if(b.roleid==id){
                                   $(this).next().addClass('checked');
                                  $(this).attr("checked","checked");
                            }
                      })
                });

             //   $('#role_content').html(checkbox_html);
                $('#menu_from').find('input[name="name"]').val(data.directory.name);
                $('#menu_from').find('input[name="directory_url"]').val(data.directory.url);
                $('#menu_from').find('input[name="showorder"]').val(data.directory.showorder);
                $('#menu_from').find('textarea[name="beizhu"]').val(data.directory.description);
                $('#menu_from').find('input[name="directory_id"]').val(data.directory.directory_id);

           }
      });

      layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '700px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
}
</script>
</html>