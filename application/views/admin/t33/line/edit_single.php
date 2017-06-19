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
/*添加数据表单*/
.form-box{position: absolute;top: 0px;left: 0px;width:100%;z-index: 120;display:none;}
.fb-content .fb-content,.form-box .fb-content{margin: 30px auto;padding-bottom: 15px;width: 560px;background: rgb(255, 255, 255) none repeat scroll 0% 0%;box-shadow: 0px 5px 40px rgba(0, 0, 0, 0.5);}
.fb-content .box-title,.form-box .box-title{padding: 10px 15px 10px 20px;background-color: #F5F5F5;border-bottom: 1px solid #E5E5E5;position:relative;}
.box-title h4{font-size:18px;font-weight: 500;}
.box-title span a { width:25px;height:25px;background:none;color:#000;font-size:24px;text-align:center;line-height:25px;}
.fb-content .box-title span,.form-box .box-title span{position:absolute;right:20px;top:5px;cursor: pointer;font-size: 18px;font-weight: 600;color: #aaa;}
.form-horizontal .form-group{margin: 15px 20px !important;overflow: hidden;}
.form-horizontal .form-group .fg-title{width: 22%;line-height:33px;display: block;float: left;text-align: right;margin-right: 10px;overflow:hidden;}
.form-horizontal .form-group .fg-title i{color:red;}
.p_adult,.p_child,.p_childnobed{margin-left:20px;width:80%;}



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
    float:right;
  
}

.btn_two{
	float: right;
    width: auto;
    border: 0;
    margin-left: 10px;
    padding: 7px 16px !important;
    height:30px;
    border-radius: 3px;
    background: #2DC3E8;
    color: #fff;
    cursor: pointer;
    position: relative !important; 
}

.showorder{
padding:3px 6px;
margin:2px 0px;
box-sizing:border-box;
border:1px solid #D5D5D5;
color:#000;
background-color:#fff;
width: 220px;
height: 26px
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

.p1{width:100%;border-bottom:1px solid #dcdcdc;font-family:"tahoma";padding-bottom:2px;}
.order_info_title i{color:red;margin:0 1px;}

form font{margin-right:10px;}
.part2 input{width:70px;}



.one_step{
  margin:200px 16%;
  float:left;
  width:68%;
}
.choose_div{
	margin-left: 50px;
    font-size: 20px;
    display: inline-block;
    text-align: center;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    display: inline-block;
    width: 160px;
    height: 80px;
    background: #ccc;
}
.choose_div a{
    display: inline-block;
    width: 160px;
    height: 80px;
    padding-top: 50px;
    color: #fff;
}

.a1{
 background: url(<?php echo base_url();?>/assets/ht/img/cj.png) center 5px no-repeat;
}
.a2{
 background: url(<?php echo base_url();?>/assets/ht/img/cj.png) center 5px no-repeat;
}
.a3{
 background: url(<?php echo base_url();?>/assets/ht/img/cj.png) center 5px no-repeat;
}


.btn_use{
	background: #69B716;
    width: 60px;
    height: 25px;
    margin-left: 20px;
    margin-top:1px;
    padding: 0px;
    border-radius: 1px;
    color: #fff;
    border: none;
    text-align: center;
    cursor: pointer;
    outline: none;
    float:right;
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

/*服务类型*/

.ul_server_range{
  border:1px solid #dcdcdc;
  min-height:150px;
  max-height:300px;
  overflow-y:scroll;
  display:none;
  z-index:999;
  width:150px;
  background:#fff;
  position:absolute;
}
.ul_server_range li{
padding:0 4px;
}
.ul_server_range li:hover{
background:#ccc;
cursor:pointer;
}

/*供应商*/

.ul_supplier{
  border:1px solid #dcdcdc;
  min-height:150px;
  max-height:300px;
  overflow-y:scroll;
  display:none;
  z-index:999;
  width:220px;
  background:#fff;
  position:absolute;
}
.ul_supplier li{
padding:0 4px;
}
.ul_supplier li:hover{
background:#ccc;
cursor:pointer;
}

.add_car,.delete_car{margin-left:5px;}

</style>

</head>
<body>

<?php $this->load->view("admin/t33/common/dest_tree"); //加载树形目的地   ?>


    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
        <!-- <div class="one_step" data-value="">
            <div class="choose_div">
              <a href="javascript:void(0)" class="a1" data-id="A">出境</a>
            </div>
            <div class="choose_div">
             <a href="javascript:void(0)" class="a2" data-id="B">国内</a>
            </div>
            <div class="choose_div">
             <a href="javascript:void(0)" class="a3" data-id="C">周边</a>
            </div>
        </div> -->
        
        <!-- =============== 新增单项 ============ -->
        <div class="order_detail">
         <!-- 循环开始 -->
            <!-- ===============基础信息============ -->
            
          
		            <div class="content_part">
		               <form method="post" action="#" id="add-data" class="form-horizontal">
		                 <!-- 基础信息 -->
		                 <p class="p1">基础信息</p>
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top:5px;">
		                   
		                    <tr height="40">
		                     
		                        <td class="order_info_title">出发城市<i>*</i>:</td>
		                        <td><input type="text" id="startplace" onfocus="showMenu_startplace(this.id);" class="showorder" data-id="<?php echo $row['startplace_id']?>" value="<?php echo $row['startplace']?>"></td>
		                        
		                         <td class="order_info_title">销售对象<i>*</i>:</td>
		                        <td>
		                         <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <input type="text" name="" value="<?php echo $row['sell_object']=="-1"?"全公司":$row['object_name']?>" class="showorder expert_id sell_object" placeholder="输入关键字搜索" data-value="<?php echo $row['sell_object']?>" style="margin:0;width:120px;" />
                                        <a href="javascript:void(0)" onclick="javascript:$('.expert_id').val('');">清空</a>
                                         <ul class="select_list ul_expert">
                                                  <li data-value="-1">全公司</li>
                                                   <!--
                                                  <?php if(!empty($expert_list)):?>
                                                    <?php foreach ($expert_list as $k=>$v):?>
                                          			<li value="<?php echo $v['id'];?>"><?php echo $v['realname'];?></li>
                                                   
                                                    <?php endforeach;?>
	                                              <?php endif;?> -->
                                          </ul>
                                          <i></i>
                                     </div>
                                   </div>
		                        </td>
		                    </tr>
		                    <tr height="40"> 
		                        <td class="order_info_title">单项编号<i>*</i>:</td>
		                        <td>
		                      	 <input type="text" id="linecode" class="showorder" name="showorder" value="<?php echo $row['linecode']?>" readonly>
		                        </td>
		                        <td class="order_info_title">上车地点:</td>
		                        <td class="td_car">
		                         <?php if(!empty($car_lsit)):?>
		                          <?php foreach ($car_lsit as $m=>$n):?>
		                          <div>
		                      	    <input type="text" class="showorder input_car" name="showorder" style="width:120px;" data-id="<?php echo $n['id'];?>" value="<?php echo $n['on_car'];?>">
		                      	    <?php if($m=="0"):?>
		                      	    <a href="javascript:void(0)" class="add_car">添加</a>
		                      	    <?php else:?>
		                      	     <a href="javascript:void(0)" class="delete_car">删除</a>
		                      	   <?php endif;?>
		                      	    
		                      	 </div>
		                      	  <?php endforeach;?>
		                      	  
		                      	  <?php else:?>
		                      	   <div>
		                      	    <input type="text" class="showorder input_car" name="showorder" style="width:120px;">
		                      	    <a href="javascript:void(0)" class="add_car">添加</a>
		                      	 </div>
		                      	  
		                      	 <?php endif;?>
		                      	 
		                      	 
		                        </td>
		   
		                    </tr>
		                    <tr height="40"> 
		                        <td class="order_info_title">单项名称<i>*</i>:</td>
		                        <td colspan="3">
		                      	 <input type="text" id="linename" class="showorder" name="showorder" style="width:675px;" value="<?php echo $row['linename']?>">
		                        </td>
		   
		                    </tr>
		                      <!--  
		                    <tr height="40">
 							  
 							    <td class="order_info_title">名单模板<i>*</i>:</td>
		                        <td>
		                          <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <div class="search_select div_type">
                                            <div class="show_select ul_type" data-value="收据" style="padding-left: 4px;height:26px;line-height:26px;">名单模板</div>
                                            <ul class="select_list">
                                          			<li value="1">张三</li>
                                                    <li value="2">李四</li>
	                        
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                        </div>
                                 </div>
		                        </td>
		                    </tr>
		                    -->
		                    
		                     <tr height="40"> 
		                       <td class="order_info_title">服务类型<i>*</i>:</td>
		                        <td>
		                          <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <input type="text" name="" value="<?php echo $row['server_name']?>" class="showorder server_range" placeholder="输入关键字搜索" data-value="<?php echo $row['server_range']?>" style="margin:0;width:150px;" />
                                        <a href="javascript:void(0)" onclick="javascript:$('.server_range').val('');">清空</a> <a href="jsvascript:void(0)" class="a_server" style="margin:3px 5px;">管理</a>
                                         <ul class="select_list ul_server_range">
                                                  
                                                 
                                          </ul>
                                          <i></i>
                                     </div>
                                   </div>
                                     
		                        </td>
		                        <td class="order_info_title">供应商<i>*</i>:</td>
		                        <td>
		                        <!--  
		                        <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                        <div class="search_select supplier_id" data-value="<?php echo $row['supplier_id']?>">
                                            <div class="show_select" style="padding-left: 4px;height:26px;line-height:26px;width:180px;overflow:hidden;"><?php echo $row['company_name']?></div>
                                            <ul class="select_list" style="width:180px;">
                                                  <?php if(!empty($supplier['result'])):?>
                                                    <?php foreach ($supplier['result'] as $k=>$v):?>
                                          			<li value="<?php echo $v['id'];?>"><?php echo $v['company_name'];?></li>
                                                   
                                                    <?php endforeach;?>
	                                              <?php endif;?>
                                            </ul>
                                            <i></i>
                                        </div>
                                        <input type="hidden" name="" value="" class="select_value"/>
                                        </div>
                                   </div>
                               -->
                               <?php echo $row['company_name']?>
		                        </td>
		                       
		                   
		                    </tr>
		                     <tr height="40"> 
		                        <td class="order_info_title">计划人数<i>*</i>:</td>
		                        <td><input type="text" id="number" class="showorder" name="showorder" value="<?php echo $row['number']?>"></td>
		                        <td class="order_info_title">计划时间<i>*</i>:</td>
		                        <td><input type="text" id="day" data-date-format="yyyy-mm-dd" class="showorder" value="<?php echo $row['day']?>"></td>
		                       
		                   
		                    </tr>
		                    <tr height="40">
		                       
		                        <td class="order_info_title">销售须知:</td>
		                        <td colspan="3">
		                        <textarea name="" class="textarea" id="remark" placeholder="销售须知" style="width:675px;height:160px;"><?php echo $row['book_notice']?></textarea>
		                        </td>
		                    </tr>
		                    <tr height="40"> 
		                        <td class="order_info_title">行程文件:</td>
		                        <td colspan="3">
		                          <?php 
		                              $m_path="";
		                              $m_name="";
		                              if(!empty($files)):?>
		                              <?php 
		                              
		                              foreach ($files as $k=>$v):
		                              $m_path=$v['file'].",".$m_path;
		                              $m_name=$v['file_name'].",".$m_name;
		                              ?>
		                              <div><a href="<?php echo BANGU_URL.$v['file'];?>"><?php echo $v['file_name'];?></a></div>
		                             <?php endforeach;?>
		                          <?php endif;?>
		                          <form method="post" action="#" id="add-data" class="form-horizontal">
			                      	  <input name="uploadFile2" class="uploadFile" onchange="uploadFile(this);" type="file" style="width:180px;">
	                    			  <input name="pic" id="single_file" data-name="<?php echo $m_name;?>" type="hidden" value="<?php echo $m_path;?>">
                    			  </form>
		                        </td>
		   
		                    </tr>
		                </table>
		                 <!-- 产品报价 -->
		                 <p class="p1">产品报价</p>
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top:5px;">
		                   
		                    <tr height="40">
		                        <td class="order_info_title" style="text-align:center;">费用类型</td>
		                        <td class="order_info_title" style="text-align:center;">销售价</td>
		                        <td class="order_info_title" style="text-align:center;">结算价</td>
		                    </tr>
		                    <tr height="40"> 
		                 		<td>成人价<i style='color: red;'>*</i>:</td>
		                        <td><input type="text" id="adultprice" class="showorder" name="showorder" value="<?php echo $row['adultprice']?>">元</td>
		                        <td><input type="text" id="adultjs" class="showorder" name="showorder" value="<?php echo $row['adultprofit']?>">元</td>
		   
		                    </tr>
		                    <tr height="40"> 
		                 		<td>儿童占床价:</td>
		                        <td><input type="text" id="childprice" class="showorder" name="showorder" value="<?php echo $row['childprice']?>">元</td>
		                        <td><input type="text" id="childjs" class="showorder" name="showorder" value="<?php echo $row['childprofit']?>">元</td>
		                    </tr>
		                    <tr height="40"> 
		                 		<td>儿童不占床价:</td>
		                        <td><input type="text" id="childnobedprice" class="showorder" name="showorder" value="<?php echo $row['childnobedprice']?>">元</td>
		                        <td><input type="text" id="childnobedjs" class="showorder" name="showorder" value="<?php echo $row['childnobedprofit']?>">元</td>
		                    </tr>
		                 <!--    <tr height="40"> 
                                              <td>老人价:</td>
                         <td><input type="text" id="oldprice" class="showorder" name="showorder" value="<?php echo $row['oldprice']?>">元</td>
                         <td><input type="text" id="oldjs" class="showorder" name="showorder" value="<?php echo $row['oldprofit']?>">元</td>
                     </tr> -->
		                </table>
		                <?php if(!empty($row['single_agent_id'])):?>
		                 <!-- 基础信息 -->
		                 <p class="p1">平台佣金</p>
		                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top:5px;">
		                   
		                    
		                    <tr height="40">
		                    	<td class="order_info_title" style="width:110px !important;">佣金收取对象<i>*</i>:</td>
		                        <td colspan="3">
		                          <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                          <label><input type="radio" name="agent_object" <?php echo "checked"; //echo $row['object']=="1"?"checked":"";?> value="1" class="agent_object"/>营业部</label>
                                         <!--  
                                          <label style="margin-left:20px;"><input type="radio" name="agent_object" <?php echo $row['object']=="2"?"checked":"";?> value="2" class="agent_object"/>供应商</label>
                                         -->
                                    </div>
                                 </div>
		                        </td>
 							
		                    </tr>
		                    <!-- 
		                     <tr height="40"> 
		                       <td class="order_info_title">佣金计算类别<i>*</i>:</td>
		                        <td colspan="3">
		                          <div class="search_group" style="margin:5px 0px;">
                                  
                                    <div class="form_select">
                                          <label><input type="radio" name="item" <?php echo $row['type']=="2"?"checked":"";?> value="1" class="radio" />团费比例</label>
                                          <label style="margin-left:20px;"><input type="radio" name="item" <?php echo $row['type']=="1"?"checked":"";?> value="2" class="radio"/>按人头</label>
                                       
                                    </div>
                                 </div>
		                        </td>
		                       
		                   
		                    </tr> -->
		                     <tr height="40"> 
		                     
		                        <td class="order_info_title">佣金:</td>
		                        <td colspan="3">
		                        <!--  
		                        <div class="part1" style="width:340px;">
		                        <input type="text" id="agent_rate" class="showorder" name="showorder" style="width: 120px" value="<?php echo $row['agent_rate'];?>">（如：80% 则输入0.8）
		                        <input type="button" value="计算" class="btn_use" />
		                        </div>
		                        -->
		                         <div class="part2" style="width:640px;">
		                         <label>成人：<input type="text" id="adult_agent" class="showorder" name="showorder" value="<?php echo $row['adult_agent'];?>">元</label>
		                         <label>小孩占床：<input type="text" id="child_agent" class="showorder" name="showorder" value="<?php echo $row['child_agent'];?>">元</label>
		                         <label>小孩不占床：<input type="text" id="childnobed_agent" class="showorder" name="showorder" value="<?php echo $row['childnobed_agent'];?>">元</label>
		                         <!--  <label>老人：<input type="text" id="old_agent" class="showorder" name="showorder" value="<?php echo $row['old_agent'];?>">元</label>-->
		                       <!--  <input type="button" value="计算" class="btn_use" /> -->
		                        </div>
		                        </td>
		                       
		                       
		                   
		                    </tr>
		
		                </table>
		                <?php endif;?>
		                
		                <div class="table_div">
		                <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" style="margin-top:5px;">
		                
		                     </table>
		                    </div>
		                    
		                </form>
		            </div>
          
          
    <!-- 循环结束 -->
  
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin:0 0 0px 0;text-align:right;float:left;width:98%;">
               <div style="width:100%;float:left;margin-top:20px;">
                <input type="button" class="fg-but btn_two btn_close" value="关闭">
               <?php if(!empty($row['single_agent_id'])):?>
                 <?php if($row['status']!='2'):?>
                 <input type="button" class="fg-but btn_one btn_submit" value="重新提交">
                 <?php else:?>
                 <input type="button" class="fg-but btn_one btn_submit" value="提交">
                 <?php endif;?>
               <?php endif;?>
                
               
                
                 
                </div>
            </div>
           
        </form>
    </div>
   
    <!-- 表单结束 -->
        </div>
	</div>
	
 <!-- 添加营业部 弹层 -->
 <div class="fb-content" id="single_div" style="display:none;">
    <div class="box-title">
        <h5>佣金确认</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group">
              <p class="p_adult">成人价：  管家佣金：<font class="ding_expert_fee">0</font>元，平台佣金：<font class="ding_platform_fee">0</font>元</p>
            </div>
            <div class="form-group">
              <p class="p_child">儿童占床价：  管家佣金：<font class="child_expert_fee">0</font>元，平台佣金：<font class="child_platform_fee">0</font>元</p>
               
            </div>
            
            <div class="form-group">
              <p class="p_childnobed">儿童不占床价：  管家佣金：<font class="childnobed_expert_fee">0</font>元，平台佣金：<font class="childnobed_platform_fee">0</font>元</p>
                
            </div>
           
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close btn_two" value="重新填写">
                <input type="button" class="fg-but btn_add_single btn_one" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>		
	
<script type="text/javascript">

var m_date="";
var sell_object="<?php echo $row['sell_object'];?>";
var object_name="<?php echo $row['sell_object']=="-1"?"全公司":$row['object_name'];?>";
var server_range="<?php echo $row['server_range'];?>";
var server_name="<?php echo $row['server_name'];?>";
var agent_object="<?php echo $row['object'];?>";
		                              
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


var line_classify;
$(function(){

     //var radio_value="<?php echo $row['type'];?>";
	 /* if(radio_value=="2")
     {
         $(".part1").show();
         $(".part2").hide();
     }
     else
     {
     	  $(".part1").hide();
           $(".part2").show();
     } */
     
	//添加上车地点
	$(".add_car").click(function(){

		var str="<div><input type='text' class='input_car showorder' name='showorder' style='width:120px;'><a href='javascript:void(0)' class='delete_car'>删除</a></div>";
		$(".td_car").append(str);

	 })
	 $("body").on("click",".delete_car",function(){
		 $(this).parent().remove();
	 })
		 
	//服务类型
	//$("body").on("click",".server_range ul li",function(){
	
	$(".server_range ul li").click(function(){
		var value=$(this).attr("data-value");
		$(".server_range").attr("data-value",value);
	})
	//销售对象
	$(".sell_object ul li").click(function(){
		var value=$(this).attr("data-value");
		var name=$(this).html();
		$(".sell_object").attr("data-value",value);
		$(".sell_object").attr("data-name",name);
	})
	/* if(agent_object=="1")
		$(".table_div").show();
	else
		$(".table_div").hide(); */
	
	/* $(".agent_object").click(function(){
		var value=$(this).attr("value");
		
		if(value=="2")
			$(".table_div").hide();
		else
			$(".table_div").show();
	}) */
	//供应商
	$(".supplier_id ul li").click(function(){
		var value=$(this).attr("data-value");
		$(".supplier_id").attr("data-value",value);

		var send_url="<?php echo base_url('admin/t33/sys/line/api_supplier');?>";
		var send_data={supplier_id:value};
		var return_data=send_ajax_noload(send_url,send_data); 
		
		var initcode=linecode+return_data.data.code+return_data.data.liushui_code;
		$("#linecode").val(initcode);
		
	})
	//佣金计算类别
	$(".radio").click(function(){
	
        var value=$(this).val();
        if(value=="1")
        {
            $(".part1").show();
            $(".part2").hide();
        }
        else
        {
        	  $(".part1").hide();
              $(".part2").show();
        }
	})
	//境外、国内、周边
	var linecode;
	$(".choose_div a").click(function(){
       var value=$(this).attr("data-id");
       $(".one_step").attr("data-value",value);
       $(".one_step").css("display","none");
	   $(".order_detail").css("display","block");	

	    //单项编号  AFIT-160929nyfq001   第一个A：（出境A、国内B、省内周边C） ； FIT固定要加；160929 年月日 ； nyfq 供应商代码； 001 旅行社对应供应商流水号
	 
	    var type=$(".one_step").attr("data-value");
	    if(type="A")
	    	line_classify="1";
	    else if(type="B")
	    	line_classify="2";
	    else if(type="C")
	    	line_classify="3";
		var m_date="<?php echo $m_date;?>";
		linecode= "FIT"+type+"-"+m_date;
		$("#linecode").val(linecode);
		 
	})
	//按百分比计算  结算价
	$(".btn_use").click(function(){
		cal();
	})
	//按百分比计算  结算价
	$("#agent_rate").keyup(function(){
	  
	})
	//按人头计算 结算价
	$("#adult_agent").keyup(function(){
     
	})
	$("#child_agent").keyup(function(){
     
	})
	$("#childnobed_agent").keyup(function(){
      
	})
	$("#old_agent").keyup(function(){
      
	})
 	//日历控件
	$('#day').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
		onClose:function(){
			m_date=$("#day").val();
			m_date = m_date.replace(/-/g,"").substring(2);

		    var temp="<?php echo $row['linecode']?>";
		    var a=temp.substring(0,5); //AFIT-
		    var b=temp.substring(11,temp.length); 
		    if(m_date.length=="6")
			$("#linecode").val(a+m_date+b);
		}
	});

//////销售对象搜索
//点击元素以外任意地方隐藏该元素的方法
$(document).click(function(){
	$(".select_list").css("display","none");

});
$(".expert_id").click(function(event){
    event.stopPropagation();
});
$(".supplier_id").click(function(event){
    event.stopPropagation();
});
$(".server_range").click(function(event){
    event.stopPropagation();
});
$(".show_select").click(function(event){
    event.stopPropagation();
});


	$("body").on("focus",".expert_id",function(){
		$(".ul_expert").css("display","block");
		expert_search();
	})
	$("body").on("blur",".expert_id",function(){
		if($(this).attr("data-value")==sell_object)
			$(this).val(object_name);
	
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
		var html="<li data-value='-1'>全公司</li>";
		for(var i in return_data.data)
		{
			html+="<li data-value="+return_data.data[i].id+">"+return_data.data[i].realname+"</li>";
		}
		$(".ul_expert").html(html);
	}
	$("body").on("click",".ul_expert li",function(){

		var id=$(this).attr("data-value");
		var con=$(this).html();
		$(".expert_id").val(con);
		$(".expert_id").attr("data-value",id);
		$(".expert_id").blur();
		$(".ul_expert").css("display","none");
	});
//////服务类型搜索

	$("body").on("focus",".server_range",function(){
		$(".ul_server_range").css("display","block");
		server_range_search();
	})
	$("body").on("keyup",".server_range",function(){
		server_range_search();
	})
	$("body").on("blur",".server_range",function(){
		if($(this).attr("data-value")==server_range)
			$(this).val(server_name);
	
	})
	function server_range_search()
	{
		var content=$(".server_range").val();
		var send_url="<?php echo base_url('admin/t33/sys/line/api_single_server');?>";
		var send_data={content:content};
		var return_data=send_ajax_noload(send_url,send_data); 
		var html="";
		for(var i in return_data.data)
		{
			html+="<li data-value="+return_data.data[i].id+">"+return_data.data[i].server_name+"</li>";
		}
		$(".ul_server_range").html(html);
	}
	$("body").on("click",".ul_server_range li",function(){

		var id=$(this).attr("data-value");
		var con=$(this).html();
		$(".server_range").val(con);
		$(".server_range").attr("data-value",id);
		$(".server_range").blur();
		$(".ul_server_range").css("display","none");
	});

	//服务类型管理    on：用于绑定未创建内容
	$("body").on("click",".a_server",function(){
		window.top.openWin({
		  title:"服务类型管理",
		  type: 2,
		  area: ['48%', '60%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/t33/sys/line/server_range');?>"+"?iframeid="+window.name
		});
	});
	
});

$("body").on("focus",".supplier_id",function(){
	$(".ul_supplier").css("display","block");
	supplier_search();
})
$("body").on("keyup",".supplier_id",function(){
	supplier_search();
})
function supplier_search()
{
	var content=$(".supplier_id").val();
	var send_url="<?php echo base_url('admin/t33/sys/line/api_single_supplier');?>";
	var send_data={content:content};
	var return_data=send_ajax_noload(send_url,send_data); 
	var html="";
	for(var i in return_data.data.result)
	{
		html+="<li data-value="+return_data.data.result[i].id+">"+return_data.data.result[i].company_name+"</li>";
	}
	$(".ul_supplier").html(html);
}
$("body").on("click",".ul_supplier li",function(){

	var id=$(this).attr("data-value");
	var con=$(this).html();
	$(".supplier_id").val(con);
	$(".supplier_id").attr("data-value",id);
	$(".supplier_id").blur();
	$(".ul_supplier").css("display","none");
});
	
//佣金确认
$("body").on("click",".btn_submit",function(){
	var dest_id=$("#dest_id").attr("data-id");
	var startplace=$("#startplace").attr("data-id");
	var linecode=$("#linecode").val();
	var linename=$("#linename").val();

	var car_list=[];
	$(".input_car").each(function(index,data){
        var on_car=$(this).val();
        if(on_car!="")
        {
		var obj={on_car:on_car};
        car_list.push(obj);
        }
   })

	var server_range=$(".server_range").attr("data-value");
	var server_range_value=$(".server_range").val();
	var sell_object=$(".sell_object").attr("data-value");
	var sell_object_value=$(".sell_object").val();
	var object_name=$(".sell_object").val();
	var supplier_id=$(".supplier_id").attr("data-value");
	var supplier_id_value=$(".supplier_id").val();
    var number=$("#number").val();
    var day=$("#day").val();
    var remark=$("#remark").val();

    var single_file_path=$("#single_file").val();
    var single_file_name=$("#single_file").attr("data-name");

    var adultprice=$("#adultprice").val();
    var childprice=$("#childprice").val();
    var childnobedprice=$("#childnobedprice").val();
    var oldprice=$("#oldprice").val();
    var adultjs=$("#adultjs").val();
    var childjs=$("#childjs").val();
    var childnobedjs=$("#childnobedjs").val();
    var oldjs=$("#oldjs").val();

    var agent_object=$(".agent_object:checked").val();
    var item=$(".radio:checked").val();
    var agent_rate=$("#agent_rate").val();
    var adult_agent=$("#adult_agent").val();
    var child_agent=$("#child_agent").val();
    var childnobed_agent=$("#childnobed_agent").val();
    var old_agent=$("#old_agent").val();

   
    //if(dest_id=="") { tan('目的地不能为空');return false; }
    if(startplace=="") { tan('出发城市不能为空');return false; }
  
    if(sell_object_value=="") { tan('请选择销售对象');return false; }
    //if(car_list.length==0)  {tan('上车地点不能为空');return false;}
    if(linename=="") { tan('单项名称不能为空');return false; }

   
    if(server_range_value=="") { tan('请选择服务类型');return false; }
    
    if(supplier_id_value=="") { tan('请选择供应商');return false; }
    if(number=="") { tan('计划人数不能为空');return false; }
    //if(day==""||m_date=="") { tan('请点击选择计划时间');return false; }
  
    //if(single_file_path=="") { tan('行程文件不能为空');return false; }
    if(adultprice=="") { tan('成人销售价不能为空');return false; }
    //if(childprice=="") { tan('儿童占床销售价不能为空');return false; }
    //if(childnobedprice=="") { tan('儿童不占床销售价不能为空');return false; }
    //if(oldprice=="") { tan('老人销售价不能为空');return false; }
    if(adultjs=="") { tan('成人结算价不能为空');return false; }
    //if(childjs=="") { tan('儿童占床结算价不能为空');return false; }
    //if(childnobedjs=="") { tan('儿童不占床结算价不能为空');return false; }
    //if(oldjs=="") { tan('老人结算价不能为空');return false; }
    
    if(agent_object=="-1") { tan('请选择佣金收取对象');return false; }
   
    if(item=="1")
    {
    	 //if(agent_rate=="") { tan('佣金比不能为空');return false; }
    }
    else if(item=="2")
    {
	    //if(adult_agent=="") { tan('成人佣金不能为空');return false; }
	    //if(child_agent=="") { tan('儿童占床佣金不能为空');return false; }
	    //if(childnobed_agent=="") { tan('儿童不占床佣金不能为空');return false; }
	    //if(old_agent=="") { tan('老人佣金不能为空');return false; }
    }
    //弹窗
    if(agent_object==1)
         $(".ding_expert_fee").html(accSub(accSub(adultprice,adultjs),adult_agent));
    else
    	 $(".ding_expert_fee").html(accSub(adultprice,adultjs));
	$(".ding_platform_fee").html(adult_agent);
	if(childprice!=""&&childjs!=""&&childprice!=0&&childjs!=0)
	{
		$(".p_child").css("display","block");
		if(agent_object==1)
		    $(".child_expert_fee").html(accSub(accSub(childprice,childjs),child_agent));
		else
			$(".child_expert_fee").html(accSub(childprice,childjs));
			
	    $(".child_platform_fee").html(child_agent);
	}
	else
	{
		$(".p_child").css("display","none");
	}
	
	if(childnobedprice!=""&&childnobedjs!=""&&childnobedprice!=0&&childnobedjs!=0)
	{
		$(".p_childnobed").css("display","block");
		if(agent_object==1)
			$(".childnobed_expert_fee").html(accSub(accSub(childnobedprice,childnobedjs),childnobed_agent));
		else
			$(".childnobed_expert_fee").html(accSub(childnobedprice,childnobedjs));
	    $(".childnobed_platform_fee").html(childnobed_agent);
	}
	else
	{
		$(".p_childnobed").css("display","none");
	}
	
	layer.open({
		  type: 1,
		  title: false,
		  closeBtn: 0,
		  area: '500px',
		  //skin: 'layui-layer-nobg', //没有背景色
		  shadeClose: false,
		  content: $('#single_div')
		});
	
});
//提交按钮
$("body").on("click",".btn_add_single",function(){

	//var dest_id=$("#dest_id").attr("data-id");
	var startplace=$("#startplace").attr("data-id");
	var linecode=$("#linecode").val();
	var linename=$("#linename").val();

	var car_list=[];
	$(".input_car").each(function(index,data){
        var on_car=$(this).val();
        var id=$(this).attr("data-id");
        if(on_car!="")
        {
		var obj={on_car:on_car,id:id};
        car_list.push(obj);
        }
   })
	
	var server_range=$(".server_range").attr("data-value");
	var server_range_value=$(".server_range").val();
	var sell_object=$(".sell_object").attr("data-value");
	var sell_object_value=$(".sell_object").val();
	var object_name=$(".sell_object").val();
	var supplier_id=$(".supplier_id").attr("data-value");
	var supplier_id_value=$(".supplier_id").val();
    var number=$("#number").val();
    var day=$("#day").val();
    var remark=$("#remark").val();

    var single_file_path=$("#single_file").val();
    var single_file_name=$("#single_file").attr("data-name");
   
    var adultprice=$("#adultprice").val();
    var childprice=$("#childprice").val();
    var childnobedprice=$("#childnobedprice").val();
    var oldprice=$("#oldprice").val();
    var adultjs=$("#adultjs").val();
    var childjs=$("#childjs").val();
    var childnobedjs=$("#childnobedjs").val();
    var oldjs=$("#oldjs").val();

    var agent_object=$(".agent_object:checked").val();
    var item=$(".radio:checked").val();
    var agent_rate=$("#agent_rate").val();
    var adult_agent=$("#adult_agent").val();
    var child_agent=$("#child_agent").val();
    var childnobed_agent=$("#childnobed_agent").val();
    var old_agent=$("#old_agent").val();

   
    //if(dest_id=="") { tan('目的地不能为空');return false; }
    if(startplace=="") { tan('出发城市不能为空');return false; }
    if(sell_object_value=="") { tan('请选择销售对象');return false; }
    //if(car_list.length==0)  {tan('上车地点不能为空');return false;}
    if(linename=="") { tan('单项名称不能为空');return false; }
  
    if(server_range_value=="") { tan('请选择服务类型');return false; }
    
    //if(supplier_id=="-1") { tan('请选择供应商');return false; }
    if(number=="") { tan('计划人数不能为空');return false; }
    if(day=="") { tan('计划时间不能为空');return false; }
    //if(remark=="") { tan('销售须知不能为空');return false; }
    //if(single_file_path=="") { tan('行程文件不能为空');return false; }
    if(adultprice=="") { tan('成人销售价不能为空');return false; }
    //if(childprice=="") { tan('儿童占床销售价不能为空');return false; }
    //if(childnobedprice=="") { tan('儿童不占床销售价不能为空');return false; }
    //if(oldprice=="") { tan('老人销售价不能为空');return false; }
    if(adultjs=="") { tan('成人结算价不能为空');return false; }
    //if(childjs=="") { tan('儿童占床结算价不能为空');return false; }
    //if(childnobedjs=="") { tan('儿童不占床结算价不能为空');return false; }
    //if(oldjs=="") { tan('老人结算价不能为空');return false; }
    
    if(agent_object=="") { tan('请选择佣金收取对象');return false; }
   
    if(item=="1")
    {
    	 //if(agent_rate=="") { tan('佣金比不能为空');return false; }
    }
    else if(item=="2")
    {
       
	    //if(adult_agent=="") { tan('成人佣金不能为空');return false; }
	    //if(child_agent=="") { tan('儿童占床佣金不能为空');return false; }
	   // if(childnobed_agent=="") { tan('儿童不占床佣金不能为空');return false; }
	    //if(old_agent=="") { tan('老人佣金不能为空');return false; }
    }
    
    if($(".ding_expert_fee").html()<0||$(".child_expert_fee").html()<0||$(".childnobed_expert_fee").html()<0)
    {tan('管家佣金不能小于0');return false;}
    if($(".ding_platform_fee").html()<0||$(".child_platform_fee").html()<0||$(".childnobed_platform_fee").html()<0)
    {tan('平台佣金不能小于0');return false;}
    
    var url="<?php echo base_url('admin/t33/sys/line/api_update_single');?>";
    var id="<?php echo $row['id'];?>"; //b_single_affiliated 表id
    var data={
    	    id:id,
    	    startplace:startplace,
    	    linecode:linecode,
    	    linename:linename,
    	    server_range:server_range,
    	    sell_object:sell_object,
    	    object_name:object_name,
    	    supplier_id:supplier_id,
    	    number:number,
    	    day:day,
    	    book_notice:remark,
    	    single_file_path:single_file_path,
    	    single_file_name:single_file_name,
    	    adultprice:adultprice,
    	    childprice:childprice,
    	    childnobedprice:childnobedprice,
    	    oldprice:oldprice,
    	    adultjs:adultjs,
    	    childjs:childjs,
    	    childnobedjs:childnobedjs,
    	    oldjs:oldjs,
    	    agent_object:agent_object,
    	    //item:item,
    	    //agent_rate:agent_rate,
    	    adult_agent:adult_agent,
    	    child_agent:child_agent,
    	    childnobed_agent:childnobed_agent,
    	   /*  old_agent:old_agent, */
    	    line_classify:line_classify,
    	    car_list:car_list
    	    };
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


//计算

function cal()
{
  var type=$(".agent_object:checked").attr("value"); //1是营业部，佣金算在销售价；2是供应商，佣金算在结算价
  var rate=$(".radio:checked").val();  // 1是按比例，2是按人头
  
  var value1=$("#adultprice").val();
  var value2=$("#childprice").val();
  var value3=$("#childnobedprice").val();
  var value4=$("#oldprice").val(); //4个销售价

  var value5=$("#adultjs").val();
  var value6=$("#childjs").val();
  var value7=$("#childnobedjs").val();
  var value8=$("#oldjs").val(); //4个结算价

  var adult_agent=$("#adult_agent").val();
  var child_agent=$("#child_agent").val();
  var childnobed_agent=$("#childnobed_agent").val();
  var old_agent=$("#old_agent").val();
  var agent_rate=$("#agent_rate").val();
  
  if(type=="1")
  {
      if(rate=="1")
      {
    	  $("#adultprice").val(accAdd(value1,accMul(agent_rate,value1)));
          $("#childprice").val(accAdd(value2,accMul(agent_rate,value2)));
          $("#childnobedprice").val(accAdd(value3,accMul(agent_rate,value3)));
          $("#oldprice").val(accAdd(value4,accMul(agent_rate,value4)));
      }
      else
      {
    	  $("#adultprice").val(accAdd(value1,adult_agent));
          $("#childprice").val(accAdd(value2,child_agent));
          $("#childnobedprice").val(accAdd(value3,childnobed_agent));
          $("#oldprice").val(accAdd(value4,old_agent));
      }
  }
  else if(type=="2")
  {
	  /* if(rate=="1")
      {
		  $("#adultjs").val(accAdd(value5,accMul(agent_rate,value5)));
          $("#childjs").val(accAdd(value6,accMul(agent_rate,value6)));
          $("#childnobedjs").val(accAdd(value7,accMul(agent_rate,value7)));
          $("#oldjs").val(accAdd(value8,accMul(agent_rate,value8)));
      }
	  else
	  {
		  $("#adultjs").val(accAdd(value5,adult_agent));
          $("#childjs").val(accAdd(value6,child_agent));
          $("#childnobedjs").val(accAdd(value7,childnobed_agent));
          $("#oldjs").val(accAdd(value8,old_agent));
      } */
  }
  
 
}

/**
 ** 加法函数，用来得到精确的加法结果
 ** 说明：javascript的加法结果会有误差，在两个浮点数相加的时候会比较明显。这个函数返回较为精确的加法结果。
 ** 调用：accAdd(arg1,arg2)
 ** 返回值：arg1加上arg2的精确结果
 **/
function accAdd(arg1, arg2) {
    var r1, r2, m, c;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    c = Math.abs(r1 - r2);
    m = Math.pow(10, Math.max(r1, r2));
    if (c > 0) {
        var cm = Math.pow(10, c);
        if (r1 > r2) {
            arg1 = Number(arg1.toString().replace(".", ""));
            arg2 = Number(arg2.toString().replace(".", "")) * cm;
        } else {
            arg1 = Number(arg1.toString().replace(".", "")) * cm;
            arg2 = Number(arg2.toString().replace(".", ""));
        }
    } else {
        arg1 = Number(arg1.toString().replace(".", ""));
        arg2 = Number(arg2.toString().replace(".", ""));
    }
    return (arg1 + arg2) / m;
}
/**
 ** 减法函数，用来得到精确的减法结果
 ** 说明：javascript的减法结果会有误差，在两个浮点数相减的时候会比较明显。这个函数返回较为精确的减法结果。
 ** 调用：accSub(arg1,arg2)
 ** 返回值：arg1加上arg2的精确结果
 **/
function accSub(arg1, arg2) {
    var r1, r2, m, n;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度
    n = (r1 >= r2) ? r1 : r2;
    return ((arg1 * m - arg2 * m) / m).toFixed(n);
}

/**
 ** 乘法函数，用来得到精确的乘法结果
 ** 说明：javascript的乘法结果会有误差，在两个浮点数相乘的时候会比较明显。这个函数返回较为精确的乘法结果。
 ** 调用：accMul(arg1,arg2)
 ** 返回值：arg1乘以 arg2的精确结果
 **/
function accMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length;
    }
    catch (e) {
    }
    try {
        m += s2.split(".")[1].length;
    }
    catch (e) {
    }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

/** 
 ** 除法函数，用来得到精确的除法结果
 ** 说明：javascript的除法结果会有误差，在两个浮点数相除的时候会比较明显。这个函数返回较为精确的除法结果。
 ** 调用：accDiv(arg1,arg2)
 ** 返回值：arg1除以arg2的精确结果
 **/
function accDiv(arg1, arg2) {
    var t1 = 0, t2 = 0, r1, r2;
    try {
        t1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
    }
    try {
        t2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
    }
    with (Math) {
        r1 = Number(arg1.toString().replace(".", ""));
        r2 = Number(arg2.toString().replace(".", ""));
        return (r1 / r2) * pow(10, t2 - t1);
    }
}

//关闭按钮
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
$('.btn_close').click(function()
{
     parent.layer.close(index);
});

/*   异步刷新 “服务类型”   */
function fresh_server()
{
	 var url="<?php echo base_url('admin/t33/sys/line/api_server_range');?>";
     var data={};
     var return_data=send_ajax_noload(url,data);
     var html="";
     for ( var i in return_data.data.result)
     {   
         html+="<li value='"+return_data.data.result[i].id+"'>"+return_data.data.result[i].server_name+"</li>";
         
     }
     $(".server_range ul").html(html);
}

</script>
</body>

</html>
