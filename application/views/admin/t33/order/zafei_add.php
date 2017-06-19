<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url("assets/ht/css/jquery.datetimepicker.css"); ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/jquery.datetimepicker.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/layer.js"); ?>"></script>

<script type="text/javascript" src="<?php echo base_url("assets/ht/js/common/common.js"); ?>"></script>
<style type="text/css">

.btn_one{

    background: #da411f;
    width: 60px;
    height: 30px;
    margin-left: 20px;
    padding: 0px;
    border-radius: 3px;
    color: #fff;
    border: none;
    text-align: center;
    cursor: pointer;
  
}

.btn_two{
	float: right;
    width: auto;
    border: 0;
    margin-left: 10px;
    padding: 8px 14px !important;
    border-radius: 3px;
    background: #2DC3E8;
    color: #fff;
    cursor: pointer;
    position: relative !important; 
}

.showorder{
padding:7px 12px;
box-sizing:border-box;
border:1px solid #D5D5D5;
color:#000;
background-color:#fff;
}

.textarea{

width:80%;
margin:3px 0;
padding:7px 12px;

}
.div_hide{
float: left;margin-top:5px;
display:none;
}



</style>

</head>
<body>

<?php $this->load->view("admin/t33/common/depart_tree"); //加载树形营业部   ?>
    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="order_detail">
         <!-- 循环开始 -->
            <!-- ===============基础信息============ -->
            
          
		            <div class="content_part">
		               <form method="post" action="#" id="add-data" class="form-horizontal">
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
		                   
		                    <tr height="40">
		                        <td class="order_info_title">杂费名称<i style="color:red;">*</i>:</td>
		                        <td colspan="3"><input type="text" id="item" class="showorder" name="showorder" style="margin: 2px auto;"></td>
		                      
		                    </tr>
		                    
		                   
		                    <tr height="40">
		                    	<td class="order_info_title">营业部<i style="color:red;">*</i>:</td>
		                        <td colspan="3">
		                        
		                         <div style="width:100%;float:left;margin:14px 0 0 0;">
                                    <p style="width:198px;float:left;text-align:right;">可用</p><p style="width:218px;float:left;text-align:center;">扣款</p>
                                 </div>
                                 <div id="con" style="margin:5px 0 15px 0;">
		                          <div class="search_group" style="margin:5px 0 5px 0;">
                                       <div class="form_select">
	                                        <div class="search_select div_depart" data-value="-1">
	                                            <div class="show_select" style="padding-left: 2px;height:31px;line-height:31px;">请选择</div>
	                                            <ul class="select_list">
	                                                  <?php if(!empty($depart)):?>
	                                                    <?php foreach ($depart as $k=>$v):?>
	                                          			
	                                                     <li value="<?php echo $v['id']; ?>" data-amount="<?php echo $v['cash_limit']; ?>"><?php echo $v['name'];?></li>
	                                                    <?php endforeach;?>
		                                              <?php endif;?>
	                                            </ul>
	                                            <i></i>
	                                        </div>
                                        </div>
                                        <input type="text" id="p_old_amount" class="showorder" value="0.00" style="width:120px !important;color:#69B716;" name="showorder" readonly>
                                        <input type="text" id="p_amount" class="showorder" style="width:120px !important;" name="showorder">
                                   </div>
                                  <div style="width:100%;float:left;height:1px;"></div>
                                  <div id="add_con" style="width:100%;float:left;">
                                  </div>
                                </div>    
		                        </td>

		                    </tr>

		                    <tr height="40">
		                       
		                        <td class="order_info_title">说明:</td>
		                        <td colspan="3">
		                        <textarea name="" class="textarea" id="remark" maxlength="30" placeholder="说明" style="height:160px;"></textarea>
		                        </td>
		                    </tr>
		                   
		                </table>
		                </form>
		            </div>
          
          
    <!-- 循环结束 -->
  
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin:0 0 0px 0;text-align:right;float:left;width:98%;">
               <div style="width:100%;float:left;margin-top:20px;">
                 <input type="button" class="fg-but btn_one btn_submit" value="提交">
                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
               
                
                 
                </div>
            </div>
           
        </form>
    </div>
   
    <!-- 表单结束 -->
        </div>
	</div>
<script type="text/javascript">
function send_ajax_noload(url,data){  //发送ajax请求，无加载层
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

$(function(){
	
	//select 
	$(".div_depart ul li").click(function(){
		var value=$(this).attr("value");
		var data_amount=$(this).attr("data-amount");
		$(".div_depart").attr("data-value",value);

		$("#p_old_amount").val(data_amount);

		var url="<?php echo base_url('admin/t33/sys/order/api_child_depart');?>";
	    var data={pid:value};
	    var return_data=send_ajax_noload(url,data);
	    var str="";
	    if(return_data.code=="2000")
	    {
          for (var i in return_data.data)
          {
              str+=" <div class='search_group' style='margin:5px 0 5px 0;'><div class='form_select'>";
              str+="<p style='width:126px;float:left;height:30px;line-height:30px;'>"+return_data.data[i].name+"</p>";
              str+=" <input type='text' class='showorder' value='"+return_data.data[i].cash_limit+"' style='width:120px !important;color:#69B716;' name='showorder' readonly>";
              str+=" <input type='text' depart-id='"+return_data.data[i].id+"' class='p_amount showorder' style='width:120px !important;' name='showorder'>";
              
              str+="</div></div><div style='width:100%;float:left;height:1px;'></div>";
          }
         
	    }
	    $("#add_con").html(str);
	})
	
	//日历控件
	$('#addtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
});


//提交按钮
$("body").on("click",".btn_submit",function(){
	var flag = COM.repeat('btn');//频率限制
	if(!flag)
	{
		var item=$("#item").val();
		var p_amount=$("#p_amount").val();
		var p_depart_id=$(".div_depart").attr("data-value");
	    var description=$("#remark").val();
	
	    var list=[];
	    $(".p_amount").each(function(index,data){
	
	    	var amount=$(this).val();
	    	var depart_id=$(this).attr("depart-id");
	        var obj={
	                 amount:amount,
	                 depart_id:depart_id,
	                }
	        if(amount!="")
	        list.push(obj);
	        
	        })
	
	   
	    if(item=="") { tan('杂费名称不能为空');return false; }
	    if(p_depart_id=="-1") { tan('请选择营业部');return false; }
	  
	    var url="<?php echo base_url('admin/t33/sys/order/api_zafei_add');?>";
	    var data={item:item,p_amount:p_amount,p_depart_id:p_depart_id,list:list,description:description};
	    var return_data=send_ajax_noload(url,data);
	    if(return_data.code=="2000")
	    {
	    	
			tan2(return_data.data);
			setTimeout(function(){t33_close_iframe();},200);
	    }
	    else
	    {
	        tan(return_data.msg);
	    } 
	}
	
});



//关闭按钮
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$('.btn_close').click(function()
{
   
     parent.layer.close(index);
});

</script>
</body>

</html>
