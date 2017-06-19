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



/* 销售对象 */
.ul_expert{
  border:1px solid #dcdcdc;
  min-height:150px;
  max-height:300px;
  overflow-y:scroll;
  display:none;
  z-index:999;
  width:120px;
  background:#fff;
  position:absolute;
}
.ul_expert li{
padding:0 4px;
}
.ul_expert li:hover{
background:#ccc;
cursor:pointer;
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
		                       <td class="order_info_title">收款日期<i style='color:red;'>*</i>:</td>
		                        <td> <input type="text" id="addtime" value="<?php echo $m_date;?>" data-date-format="yyyy-mm-dd" class="showorder" name="showorder"></td>
		                        <td class="order_info_title">收款金额<i style='color:red;'>*</i>:</td>
		                        <td><input type="text" id="money" class="showorder" name="showorder"></td>
		                    </tr>
		                    <tr height="40"> 
		                       
		                       <td class="order_info_title">销售对象<i style='color:red;'>*</i>:</td>
		                        <td>
		                         <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <input type="text" class="showorder expert_id" placeholder="输入关键字搜索" data-value="" style="margin:0;width:120px;padding:7px 5px;" depart-id="" depart-name="" />
                                        <a href="javascript:void(0)" onclick="javascript:$('.expert_id').val('');">清空</a>
                                         <ul class="select_list ul_expert">
                                                
                                          </ul>
                                          <i></i>
                                     </div>
                                   </div>
                                </td>
		                        <td class="order_info_title">营业部<i style='color:red;'>*</i>:</td>
		                        <td class="td_depart">
		                        
		                        </td>
		                       
		                   
		                    </tr>
		                   
		                    <tr height="40">
		                    	<td class="order_info_title">收款方式<i style='color:red;'>*</i>:</td>
		                        <td colspan="3">
		                          <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <div class="search_select div_way">
                                            <div class="show_select ul_way" data-value="现金" style="padding-left: 4px;height:31px;line-height:31px;">现金</div>
                                            <ul class="select_list">
                                            
                                          			<li value="1">现金</li>
                                                    <li value="2">转账</li>
	                        
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                        </div>
                                   </div>
                                     <div class="div_hide">
	                                     <input type="text" id="bankname" class="showorder" value="<?php echo $user['bankname'];?>" placeholder="银行名称" name="showorder">
	                                     <input type="text" id="bankcard" class="showorder" value="<?php echo $user['bankcard'];?>" placeholder="银行账号" name="showorder">
                                     </div>
		                        </td>

		                    </tr>
		                    
		                    <tr height="40">
		                        <td class="order_info_title">凭证号<i style='color:red;'>*</i>:</td>
		                        <td><input type="text" id="code" class="showorder" name="showorder"></td>
		                        <!--  
		                        <td class="order_info_title">发票类型<i style='color:red;'>*</i>:</td>
		                        <td>
		                          <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <div class="search_select div_type">
                                            <div class="show_select ul_type" data-value="收据" style="padding-left: 4px;height:31px;line-height:31px;">收据</div>
                                            <ul class="select_list">
                                          			<li value="1">收据</li>
                                                    <li value="2">发票</li>
	                        
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                        </div>
                                 </div>
		                        </td>
		                        -->
		                        <td class="order_info_title">上传流水单:</td>
		                        <td>
		                         <input name="uploadFile" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    			 <input name="pic" id="code_pic" type="hidden" value="">
		                        </td>
		                    </tr>
		                    <!--  
		                     <tr height="40"> 
		                        <td class="order_info_title">收据号<i style='color:red;'>*</i>:</td>
		                        <td><input type="text" id="invoice_code" class="showorder" name="showorder"></td>
		                        <td class="order_info_title">收款单号<i style='color:red;'>*</i>:</td>
		                        <td><input type="text" id="voucher" class="showorder" name="showorder"></td>
		                       
		                   
		                    </tr>-->
		                    <tr height="40">
		                       
		                        <td class="order_info_title">备注:</td>
		                        <td colspan="3">
		                        <textarea name="" class="textarea" id="remark" maxlength="30" placeholder="备注" style="height:160px;"></textarea>
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
	$(".div_expert ul li").click(function(){
		var value=$(this).attr("value");
		var depart_id=$(this).attr("depart-id");
		var depart_name=$(this).attr("depart-name");
	  
		$(".div_expert .ul_expert").attr("data-value",value);
		$(".div_expert .ul_expert").attr("depart-id",depart_id);
        $(".td_depart").html(depart_name);
		
	})
	//select 
	$(".div_way ul li").click(function(){
		var value=$(this).attr("value");
		var str=$(this).html();
		if(value=="2")
		$(".div_hide").css("display","block");
		else
	    $(".div_hide").css("display","none");
	   
		$(".div_way .ul_way").attr("data-value",str);
	})
	   //select 
	$(".div_type ul li").click(function(){
		var value=$(this).attr("value");
		var str=$(this).html();
		type_value=value;
		$(".div_type .ul_type").attr("data-value",str);
	})
	//日历控件
	$('#addtime').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
});

/****  交款人搜索    *****/

//点击元素以外任意地方隐藏该元素的方法
$(document).click(function(){
	$(".select_list").css("display","none");

});
$(".expert_id").click(function(event){
event.stopPropagation();
});
$(".ul_way").click(function(event){
	event.stopPropagation();
});


$("body").on("focus",".expert_id",function(){
	$(".ul_expert").css("display","block");
	expert_search();
})
$("body").on("keyup",".expert_id",function(){
	expert_search();
})
function expert_search()
{
	var content=$(".expert_id").val();
	var send_url="<?php echo base_url('admin/t33/sys/line/api_single_expert');?>";
	var send_data={content:content};
	var return_data=send_ajax_noload(send_url,send_data); 
	var html="";
	for(var i in return_data.data)
	{
		html+="<li data-value="+return_data.data[i].id+" depart-id="+return_data.data[i].depart_id+" depart-name="+return_data.data[i].depart_name+">"+return_data.data[i].realname+"</li>";
	}
	$(".ul_expert").html(html);
}
$("body").on("click",".ul_expert li",function(){

	var id=$(this).attr("data-value");
	var depart_id=$(this).attr("depart-id");
	var depart_name=$(this).attr("depart-name");
	var con=$(this).html();
	$(".expert_id").val(con);
	$(".expert_id").attr("data-value",id);
	$(".expert_id").attr("depart-id",depart_id);
	$(".expert_id").attr("depart-name",depart_name);
	$(".td_depart").html(depart_name);
	$(".expert_id").blur();
	$(".ul_expert").css("display","none");
});
//提交按钮
$("body").on("click",".btn_submit",function(){

	var addtime=$("#addtime").val();
	var money=$("#money").val();
	var expert_id=$(".expert_id").attr("data-value");
	var expert_value=$(".expert_id").val();
	var depart_id=$(".expert_id").attr("depart-id");
	
	var way=$(".ul_way").attr("data-value");
	var type=$(".ul_type").attr("data-value");
    var bankname=$("#bankname").val();
    var bankcard=$("#bankcard").val();
    var invoice_code=$("#invoice_code").val();
    var voucher=$("#voucher").val();
    var remark=$("#remark").val();
    var code=$("#code").val();

   
    if(addtime=="") { tan('收款日期不能为空');return false; }
    if(money=="") { tan('收款金额不能为空');return false; }
    if(parseInt(money)<="0") { tan('收款金额需大于0');return false; }
    if(expert_value=="") { tan('交款人不能为空');return false; }
   
    if(way=="") { tan('请选择收款方式');return false; }
  
    if(way=="转账")
    {
    	 if(bankname=="") { tan('银行名称不能为空');return false; }
    	 if(bankcard=="") { tan('银行卡号不能为空');return false; }
    }
    if(code=="") { tan('凭证号不能为空');return false; }
   /*  if(type=="") { tan('请选择发票类型');return false; }
    if(invoice_code=="") { tan('收据号不能为空');return false; }
    if(voucher=="") { tan('收款单号不能为空');return false; } */
    //if(remark=="") { tan('备注不能为空');return false; }

    var code_pic=$("#code_pic").val();
    
    var url="<?php echo base_url('admin/t33/sys/approve2/api_hand_add');?>";
    var data={expert_id:expert_id,depart_id:depart_id,addtime:addtime,money:money,way:way,bankname:bankname,bankcard:bankcard,remark:remark,code_pic:code_pic,code:code};
    var return_data=send_ajax_noload(url,data);
    if(return_data.code=="2000")
    {
    	
		tan2(return_data.data);
		setTimeout(function(){t33_close_iframe();},200);

		//刷新页面
		parent.$("#main")[0].contentWindow.getValue();
		
	
    }
    else
    {
        tan(return_data.msg);
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
