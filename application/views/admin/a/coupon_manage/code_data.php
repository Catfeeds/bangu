<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<?php  $this->load->view("admin/t33/common/js_view"); ?>
<style type="text/css">
.page_content { margin-top:0;}
.add_code { background:#F4F4F4;border:1px solid #ccc;width:110px;text-align:center;line-height:30px;margin:10px;display:inline-block;cursor:pointer;}
#form1 .form-group { width:45%;float:left;margin-bottom:0 !important;}
.input_info { width:100px !important;}
.form_label { float:left;line-height:25px;width:90px;text-align:right;padding-right:5px;}
.form_label i { color:#f00;}
.form_input { float:left;}
.form_btn span { display:inline-block;width:100px;text-align:center;line-height:30px;color:#333 !important;background:#fff;border:1px solid #aaa;cursor:pointer;}
.form_btn span:first-child { margin-left:200px;margin-right:100px;}
.form_btn span:hover { background:#eee;}
.table-bordered { border-collapse:collapse;}
.table>thead>tr>th { text-align: center;}
.data_rows tr td { text-align:center !important;}
.underline { text-decoration:underline;}
.form-horizontal .form-group input { padding:0 5px !important;}
.table tbody tr td a.not_click { color:#aaa !important;cursor: default !important;text-decoration:none !important;}
</style>
</head>
<body>
<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">      
            <span class="add_code">+兑换码</span>
            <!-- tab切换表格 -->
            <div class="table_content clear">
                <div class="tab_content">
                    <div class="table_list">
                       <table class="table table-bordered table_hover" id="dataTable">
                           <thead class="">
                               <tr>
                                   <th width="80">序号</th>
                                   <th width="100">兑换码金额</th>
                                   <th width="100">使用条件</th>
                                   <th width="80">张数</th>
                                   <th width="80">领用数</th>
                                   <th width="80">使用数</th>
                                   <th width="100">有效期至</th>
                                   <th>备注</th>
                                   <th width="120">操作</th>
                               </tr>
                           </thead>
                           <tbody class="data_rows">
                           </tbody>
                       </table>
                       <!-- 暂无数据 -->
                       <div class="no-data" style="display:none;">暂无数据!</div>
                   </div>
                </div>
                <div id="page_div"></div>                   
            </div>
        </div>
    </div>
 
<!--新增兑换码start -->    
<div class="fb-content" id="form1" style="display:none;">
    <div class="box-title">
        <h5>新增兑换码</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="form" class="form-horizontal">
           <div class="form-group">
                <div class="form_label"><i>*</i>兑换码金额</div>
                <div class="form_input"><input type="text" class="input_info" name="coupon_price" onkeyup="check_val(this);" oninput="number_check(this,1);" maxlength="3"/></div>
           </div>
           <!-- <div class="form-group">
                <div class="form_label"><i>*</i>使用条件，满</div>
                <div class="form_input"><input type="text" class="input_info" name="min_price" value="0" onkeyup="check_val(this);" oninput="number_check(this,2);" maxlength="7"/><span>可用，0表示不限制</span></div>
           </div> -->
           <div class="form-group">
                <div class="form_label"><i>*</i>张数</div>
                <div class="form_input"><input type="text" class="input_info" name="number" onkeyup="check_val(this);" oninput="number_check(this,3);" maxlength="9"/></div>
           </div>
           <div class="form-group">
                <div class="form_label"><i>*</i>有效期至</div>
                <div class="form_input"><input type="text" class="input_info" id="starttime" data-date-format="yyyy-mm-dd" name="time" ></div>
           </div>
            <div class="form-group" style="width:80%;">
                <div class="form_label">兑换码说明</div>
                <div class="form_input"><input type="text" class="input_info" style="width:460px !important;" name="decription" maxlength="30"/></div>
            </div>

            <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
            	<span class="sub_data" onclick="add_code();">确定</span>
                <span class="layui-layer-close cancle_add">取消</span>
            </div>
        </form>
    </div>
</div> 
<!--新增兑换码end -->     
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
//---------------------------------------列表数据---------------------------------------------------------

$(function(){
     object.init(); //加载
	 
	 //日历控件
	$('#starttime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onSelectDate:function(){
			var time1 = $("#starttime").val();
			var time2 = new Date();
			var year1 = time1.substr(0,4);
			var month1 = parseInt(time1.substr(5,2));
			var date1 = parseInt(time1.substr(8,2));
			var year2 = time2.getFullYear();
			var month2 = time2.getMonth()+1;
			var date2 = time2.getDate();
			if(year1<year2){
				alert("有效期必须在今天以后");
				$('#starttime').val("");
			}else{
				if(year1==year2&&month1<month2){
					alert("有效期必须在今天以后");
					$('#starttime').val("");
				}else{
					if(year1==year2&&month1==month2&&date1<=date2){
						alert("有效期必须在今天以后");
						$('#starttime').val("");
					}	
				}
			}
		}
	});
	 
})
function check_val(obj){
	var val = $(obj).val();
	val = val.replace(/\D/g,'')	;
	$(obj).val(val);
}
function number_check(obj,type){
	var val = parseInt($(obj).val());
	if(type==1){
		if(val>500){
			layer.msg("兑换金额不能超过500", {time:1500,icon: 7});
			$(obj).val(500);
		}		
	}else if(type==2){
		if(val>1000000){
			layer.msg("使用条件满上限不能超过一百万", {time:1500,icon: 7});
			$(obj).val(1000000);
		}
	}else if(type==3){
		if(val>100000000){
			layer.msg("张数不能超过一亿", {time:1500,icon: 7});
			$(obj).val(100000000);
		}
	}
}
function time_check(obj){
	$(obj).val("");
}
$(".search_button").click(function(){  //查询数据
     object.init();
     return false;
})
//js对象
var base_url = "<?php echo base_url();?>";
var flag=true;
var object = object || {};
var ajax_data={};
var post_url="<?php echo base_url('/admin/a/coupon_manage/code_data/coupon_list')?>";
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
                  str += "<tr>";
                  str +=     "<td>"+data[i].id+"</td>";
                  str +=     "<td>"+data[i].number+"元</td>";
				  str +=     "<td>满"+data[i].price+"可使用</td>";
                  str +=     "<td>"+data[i].c_sum+"</td>";
                  str +=     "<td>"+data[i].c_take+"</td>";
                  str +=     "<td>"+data[i].c_use +"</td>";
				  str +=     "<td>"+data[i].c_value_time+"</td>";
				  str +=     "<td>"+data[i].c_description+"</td>";
				  str +=     '<td><a href="javascript:void(0);" onclick="check('+data[i].id+')" class="action_type underline">查看</a>&nbsp;&nbsp;&nbsp;';
				  if(data[i].if_not==1){
					  str+='<a href="javascript:void(0);" onclick="edit('+data[i].id+',this)" class="action_type underline">作废</a></td>';
				  }else if(data[i].if_not==2){
					  str+='<a href="javascript:void(0);" class="action_type underline not_click">作废</a></td>';
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
//---------------------------------------------列表数据end---------------------------------------------------
//新增兑换码
var tag = true;
$(".add_code").click(function(){
	$("input[name=coupon_price]").val("");
	$("input[name=min_price]").val("0");
	$("input[name=number]").val("");
	$("input[name=time]").val("");
	$("input[name=decription]").val("");
	tag = true;
     layer.open({
           type: 1,
           title: false,
           closeBtn: 0,
           area: '750px',
          //skin: 'layui-layer-nobg', //没有背景色
           shadeClose: false,
           content: $('#form1')
      });
});

function add_code(){
	var coupon_price = parseInt($("input[name=coupon_price]").val());
	var number = $("input[name=number]").val();
	var time = $("input[name=time]").val();
	var min_price = parseInt($("input[name=min_price]").val());
	if(coupon_price.length<=0){
		layer.msg("请填写兑换码金额", {icon: 7});
		return false;
	}
	if(number.length<=0){
		layer.msg("请填写兑换码张数", {icon: 7});
		return false;
	}
	if(time.length<=0){
		layer.msg("请选择有效期", {icon: 7});
		return false;
	}
	if(min_price.length==0){
		layer.msg("请填写使用条件", {icon: 7});
		return false;
	}
	if(coupon_price>=min_price&&min_price!=0){
		console.log(coupon_price+"///"+min_price);
		layer.msg("兑换码金额不能超过使用条件", {icon: 7});
		return false;
	}
	if(tag){
		$.ajax({ 
			url:base_url+"admin/a/coupon_manage/code_data/add_code",
			type:"POST",
			data:$("#form").serialize(),
			async:false,
			dataType:"json",
			success:function(ret){
				//console.log(ret);
				if(ret.code==2000){				
					layer.msg("操作成功", {time: 1500,icon: 1});
					setTimeout(function(){
						$(".cancle_add").click();
						object.init();
						tag = false;
					},1000);			
				}else{
					layer.msg(ret.msg, {icon: 2});
					tag = true;
				}		
			},
			error:function(ret){
				layer.msg(ret.msg, {icon: 2});
				tag = true;
			}        
		});
	}	
}
function check(id){
	window.top.openWin({
		  type: 2,
		  area: ['1000px', '600px'],
		  title :'兑换码明细',
		  fix: true, //不固定
		  maxmin: true,
		  content: base_url+"admin/a/coupon_manage/code_data/code_detail?id="+id
	});
}
function edit(id,obj){
	layer.confirm('您确定要执行作废操作？', {
		btn: ['确定','取消'] //按钮
	}, function(){
		$.ajax({ 
			url:base_url+"admin/a/coupon_manage/coupon_data/coupon_void_all",
			type:"POST",
			data:{ id:id , type:6 },
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