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
            <div class="table_content clear">
                <div class="tab_content">
                        <form class="search_form" id="search-condition"method="post" action="">
                            <div class="search_form_box clear">

                                <div class="search_group">
                                    <label>会员名称：</label>
                                    <input type="text" name="member_name" class="" style="width:100px;"/>
                                </div>
                                <div class="search_group">
                                    <label>手机号码：</label>
                                    <input type="tel" name="mobile" class="" style="width:100px;"/>
                                </div>
                                <div class="" style="display: inline;">
		                            <label>注册日期：</label>
		                            <input type="text" class="" style="width:120px;" id="starttime" name="data" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'hourtime\',{d:-1});}'})"/>
		                            <span>~</span>
		                            <input type="text" class="" style="width:120px;" id="hourtime" name="hourtime"  onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime\',{d:1});}'})"/>
		                        </div>
		                        <div style="display: inline;">
		                            <label>最后登录：</label>
		                            <input type="text" class="" style="width:120px;" id="starttime_next" onFocus="WdatePicker({maxDate:'#F{$dp.$D(\'logintime\',{d:-1});}'})" name="lastdata"/>
		                            <span>~</span>
		                            <input type="text" class="" style="width:120px;" id="logintime" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'starttime_next\',{d:1});}'})" name="logintime"/>
		                        </div>
                                <div style="display: inline;">
                                    <input type="button" name="button" class="search_button" value="搜索"/>
                                </div>
                            </div>
                        </form>
                     <div class="table_list" id="dataTable">                     
                       <table class="table table-bordered table_hover">
                           <thead class="dataTables">
                               <tr>
		                           <th><input type="checkbox" class="allcheck" style="opacity:1;position: absolute;top: 47px;left:33px;"></th>
		                           <th>注册日期</th>
		                           <th>会员名称</th>
		                           <th>手机号</th>
		                           <th>最后登录</th>
		                       </tr>
                           </thead>
                           <tbody class="data_rows listcheck" id="listcheck">
                           </tbody>
                       </table>
                        <!-- 暂无数据 -->
                        <div class="addno-data" style="display:none;">木有数据哟！换个条件试试</div>
                     </div> 
                </div>
                <div class="search_group">
                	<div id="page_div"></div>
                </div>
                <div class="search_group" style="position: relative;top: 0px;left:0px;">
                	<input type="button" name="button" class="add_sub" value="确定选择"/>
                	
	            </div>
            </div>
        </div>
    </div>

    <div class="table_list" id="dataTable_choose" style="overflow-y: scroll;max-height: 350px;min-width: 1180px; display: inline-block;">                     
           <table class="table table-bordered table_hover">
               <thead class="dataTables_cho">
                   <tr>
                       <th><input type="checkbox" class="allchoose" style="opacity:1;position: relative;top:0px;left:46px;"></th>
                       <th>会员名称</th>
                       <th>手机号</th>
                   </tr>
               </thead>
               <tbody class="data_choose listchoose" id="listchoose">
               </tbody>
           </table>
            <div class="no-data" style="display:none;">木有数据哟！换个条件试试</div>
         </div> 
    </div>
    <div class="search_group">
    	<div id="page_divs"></div>
    </div>
    <div class="search_group" style="position: relative;top: 0px;left:0px;">
    	<input type="button" name="button" class="delete_sub" value="勾选删除"/>
    	<input type="button" name="button" class="grant_sub" value="全部发放"/>
    	<input type="button" name="button" class="choose_sub" value="选择发放"/>
    </div>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script type="text/javascript" src="/assets/js/My97DatePicker//WdatePicker.js"></script>
<script>
$(function(){
	//get_data();
	object.init();
	//tomFormat:'H-m-s'
	// });
})
$(".search_button").click(function(){  //查询数据
	object.init();
	return false;
})
//js对象
var sub_datas=[];
var id = "<?php echo $id;?>";
var type = "<?php echo $type;?>";
var base_url = "<?php echo base_url();?>";
var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('/admin/a/coupon_manage/coupon_data/get_user_data')?>";
object = {
      init:function(){ //初始化方法
          var member_name=$("input[name='member_name']").val(); 
          var mobile=$("input[name='mobile']").val(); 
		  var res_time1=$("input[name='data']").val();
		  var res_time2=$("input[name='hourtime']").val();
		  var login_time1=$("input[name='lastdata']").val();
		  var login_time2=$("input[name='logintime']").val();
          //接口数据
          ajax_data={page:"1",id:id,type:type,member_name:member_name,mobile:mobile,res_time1:res_time1,res_time2:res_time2,login_time1:login_time1,login_time2:login_time2,pageSize:10}; 
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
              		//checkeds();
              		//console.log(sub_datas)               
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
						  $(".addno-data").hide();
					}
					else if(return_data.code=="4001")
					{
						  html="";
						  $(".addno-data").show();
					}
					else
					{
						layer.msg(return_data.msg, {icon: 2});
						$(".addno-data").hide();
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
		                  str += '<td><input type="checkbox" value="'+data[i].mid+'" style="opacity:1;position: relative;top:0px;left:0px;"></td>';
		                  str += "<td>"+data[i].jointime+"</td>";
		                  str += "<td>"+data[i].nickname+"</td>";
		                  str += "<td>"+data[i].mobile+"</td>";
		                  str += "<td>"+data[i].login_time+"</td>";
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
$(".grant_sub").click(function(){ 
	var member_name=$("input[name='member_name']").val(); 
	  var mobile=$("input[name='mobile']").val(); 
	  var res_time1=$("input[name='data']").val();
	  var res_time2=$("input[name='hourtime']").val();
	  var login_time1=$("input[name='lastdata']").val();
	  var login_time2=$("input[name='logintime']").val();
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/coupon_data/coupon_send_all",
		type:"POST",
		data:{ id:id,type:type,member_name:member_name,mobile:mobile,res_time1:res_time1,res_time2:res_time2,login_time1:login_time1,login_time2,login_time2 },
		async:false,
		dataType:"json",
		success:function(ret){
			console.log(ret);
			if(ret.code==2000){				
				layer.msg("操作成功", {time: 3000,icon: 1});
				setTimeout(function(){
				var index = parent.layer.getFrameIndex(window.name); 
				parent.layer.close(index);
					},3000);
			}else{
				layer.msg(ret.msg, {icon: 2});
			}		
		},
		error:function(ret){
			layer.msg(ret.msg, {icon: 2});
		}        
	});
})
$(".choose_sub").click(function(){
	var ids = '';
	$.each($(".dataTables_cho").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		//if (checkObj.attr('checked') == 'checked') {
			ids = checkObj.val()+','+ids;
		//}
	})
	$.ajax({ 
		url:base_url+"admin/a/coupon_manage/coupon_data/send_user_coupon",
		type:"POST",
		data:{ id:id,type:type,user_id:ids },
		async:false,
		dataType:"json",
		success:function(ret){
			//console.log(ret);
			if(ret.code==2000){				
				layer.msg("操作成功", {time: 3000,icon: 1});
				setTimeout(function(){
				var index = parent.layer.getFrameIndex(window.name); 
				parent.layer.close(index);
					},3000);
				// $("span .layui-layer-close").click();
				

			}else{
				layer.msg(ret.msg, {icon: 2});
			}		
		},
		error:function(ret){
			layer.msg(ret.msg, {icon: 2});
		}        
	});
})

$(document).on("click",".allcheck",function(){
    if(this.checked){   
        $(".listcheck :checkbox").prop("checked", true);  
    }else{   
		$(".listcheck :checkbox").prop("checked", false);
    }   
});
$(document).on("click",".allchoose",function(){
    if(this.checked){   
        $(".listchoose :checkbox").prop("checked", true);  
    }else{   
		$(".listchoose :checkbox").prop("checked", false);
    }   
});
$("#listcheck").click(function(){
	var chknum = $("#listcheck :checkbox").size();//选项总个数
	console.log(chknum);
	var chk = 0;
	$("#listcheck :checkbox").each(function () {  
        if($(this).prop("checked")==true){
			chk++;
		}
    });
    console.log(chk);
	if(chknum==chk){//全选
		$(".allcheck").prop("checked",true);
	}else{//不全选
		$(".allcheck").prop("checked",false);
	}
})
$("#listchoose").click(function(){
	var chknum = $("#listchoose :checkbox").size();//选项总个数
	console.log(chknum);
	var chk = 0;
	$("#listchoose :checkbox").each(function () {  
        if($(this).prop("checked")==true){
			chk++;
		}
    });
    console.log(chk);
	if(chknum==chk){//全选
		$(".allchoose").prop("checked",true);
	}else{//不全选
		$(".allchoose").prop("checked",false);
	}
})

$(".add_sub").click(function(){
	//console.log(sub_datas);
	$.each($(".dataTables").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		var nickname = $(this).find('td').eq(2).text();
		var mobile = $(this).find('td').eq(3).text();
		if (checkObj.attr('checked') == 'checked') {
			           
            var sub = new Object();
            sub.id = checkObj.val();
            sub.nickname = nickname;
            sub.mobile = mobile;
            sub_datas.push(sub);
		}
	})
	var hash = {};
	sub_datas = sub_datas.reduce(function(item, next) {
	    hash[next.id] ? '' : hash[next.id] = true && item.push(next);
	    return item
	}, []);
	//console.log(sub_datas);
	if(sub_datas.length>50){
		alert("选择数据量不能大于50条");
		return false;
	}else{
		choose_data(sub_datas);
	}
	
})
$(".delete_sub").click(function(){
	
	var sub_data = []
	$.each($(".dataTables_cho").next('tbody').find('tr') ,function(){
		var checkObj = $(this).find('td').eq(0).find('input');
		var nickname = $(this).find('td').eq(1).text();
		var mobile = $(this).find('td').eq(2).text();
		if (checkObj.attr('checked') != 'checked') {
			           
            var sub = new Object();
            sub.id = checkObj.val();
            sub.nickname = nickname;
            sub.mobile = mobile;
            sub_data.push(sub)
            
		}
	})
		sub_datas=sub_data;
	console.log(sub_data);
	choose_data(sub_data);
})

function choose_data(data){
	var total_page=Math.ceil(data);
     //console.log(data);
     laypage({
      cont: 'page_divs',
      pages: total_page,
      jump: function(){ 
      		var str="";
		   for(var i = 0; i < data.length; i++)
              {
                  str += "<tr>";
                  str += '<td><input type="checkbox" value="'+data[i].id+'" style="opacity:1;position: relative;top:0px;left:46px;"></td>';
                  str += "<td>"+data[i].nickname+"</td>";
                  str += "<td>"+data[i].mobile+"</td>";
                  str += "</tr>";
              }
              $(".data_choose").html(str);
      }    
  })
}
</script>
</html>
