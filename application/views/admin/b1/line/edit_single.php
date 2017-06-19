<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>单项产品</title>
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
    width: 60px;
    height: 30px;
    margin-left: 20px;
    padding: 0px;
    border-radius: 3px;
    color: #fff;
    border: none;
    text-align: center;
    cursor: pointer;
    color: #fff;
    background: #2DC3E8;
}

.showorder{
	padding: 3px 6px;
    margin: 2px 0px;
    box-sizing: border-box;
    border: 1px solid #D5D5D5;
    color: #000;
    background-color: #fff;
    width: 220px;
    height: 26px;
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
    margin-top:5px;
    padding: 0px;
    border-radius: 3px;
    color: #fff;
    border: none;
    text-align: center;
    cursor: pointer;
    outline: none;
    float:right;
}

</style>

</head>
<body>

<?php $this->load->view("admin/b1/common/dest_tree"); //加载树形目的地   ?>


    <!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
    
        
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
                                       <td class="order_info_title">销售对象<i>*</i>:</td>
                                       <td>
                                       <input type="text" id="sell_name" onfocus="showUnExpert(this.id,'');"class="showorder sell_object" data-value="<?php echo $row['sell_object']=="-1"?'-1':$row['sell_object'];?>" data-name="<?php echo $row['sell_object']=="-1"?$row['object_name']:$row['object_name'];?>" value="<?php echo $row['sell_object']=="-1"?$row['object_name']:$row['object_name'];?>" data-id="<?php echo $row['sell_object']=="-1"?$row['union_id']:$row['sell_object'];?>" placeholder="输入关键字搜索" /> 
                                       </td>
                                   <td class="order_info_title">出发城市<i>*</i>:</td>
                                   <td colspan="3"><input type="text" id="startplace" onfocus="showMenu_s_startplace(this.id);" class="showorder" data-id="<?php echo $row['startplace_id']?>" value="<?php echo $row['startplace']?>" /></td>
                               </tr> 
		                    <tr height="40"> 
		                        <td class="order_info_title">单项编号<i>*</i>:</td>
		                        <td colspan="3">
		                      	 <input type="text" id="linecode" class="showorder" name="showorder" value="<?php echo $row['linecode']?>" readonly />
		                        </td>
		   
		                    </tr>
		                    <tr height="40"> 
		                        <td class="order_info_title">单项名称<i>*</i>:</td>
		                        <td colspan="3">
		                      	 <input type="text" id="linename" class="showorder" name="showorder" style="width:400px;" value="<?php echo $row['linename']?>" />
		                        </td>
		   
		                    </tr>
		                    <tr height="40">
		                    	<td class="order_info_title">服务类型<i>*</i>:</td>
		                        <td colspan="3">
		                          <div class="search_group" style="margin:2px 0px;">
                                  
                                                        <div class="form_select">
                                                            <div class="search_select server_range" data-value="<?php echo $row['server_range']?>">
                                                                <div class="show_select"  style="padding: 3px 6px;height:26px;line-height:20px;"><?php echo $row['server_name']?></div>
                                                                <ul class="select_list">
                                                                
                                                              	     <?php if(!empty($server_list)):?>
                                                                        <?php foreach ($server_list as $k=>$v):?>
                                                              			<li value="<?php echo $v['id'];?>"><?php echo $v['server_name'];?></li>
                                                                       
                                                                        <?php endforeach;?>
                    	                                              <?php endif;?>
                    	                        
                                                                </ul>
                                                                <i></i>
                                                            </div>
                                                            <input type="hidden" name="" value="" class="select_value"/>
                                                            </div>
                                                         <!--    <a href="jsvascript:void(0)" class="a_server" style="margin:4px 8px;float:left;">管理</a> -->
                                                       </div>
                                     
		                        </td>

		                    </tr>
		                    
		                    
		        <!--              <tr height="40"> 

                   <td class="order_info_title">供应商<i>*</i>:</td>
                   <td>
                                                                                <?php echo $row['company_name']?>
                   </td>
                  
                                           
                                            </tr> -->
		                     <tr height="40"> 
		                        <td class="order_info_title">计划人数<i>*</i>:</td>
		                        <td><input type="text" id="number" class="showorder" name="showorder" value="<?php echo $row['number']?>"></td>
		                        <td class="order_info_title">计划时间<i>*</i>:</td>
		                        <td><input type="text" id="day" data-date-format="yyyy-mm-dd" class="showorder" value="<?php echo $row['day']?>"></td>
		                       
		                   
		                    </tr>
		                    <tr height="40">
		                       
		                        <td class="order_info_title">销售须知:</td>
		                        <td colspan="3">
		                        <textarea name="" class="textarea" id="remark" maxlength="30" placeholder="销售须知" style="height:160px;resize:none;"><?php echo $row['book_notice']?></textarea>
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
		                              <div><a href="<?php echo $v['file'];?>"><?php echo $v['file_name'];?></a></div>
		                             <?php endforeach;?>
		                          <?php endif;?>
		                          <form method="post" action="#" id="add-data" class="form-horizontal">
			                      	  <input name="uploadFile2" class="b_uploadFile" onchange="b_uploadFile(this);" type="file" style="width:180px;">
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
                         <td><input type="text" id="oldprice" class="showorder" name="showorder" value="<?php //echo $row['oldprice']?>">元</td>
                         <td><input type="text" id="oldjs" class="showorder" name="showorder" value="<?php //echo $row['oldprofit']?>">元</td>
                     </tr> -->
		                </table>
		                </form>
		            </div>
          
          
    <!-- 循环结束 -->
  
  <div class="fb-form" style="width:100%;overflow:hidden;">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           
            <div class="form-group" style="margin:0 0 0px 0;text-align:right;float:left;width:98%;">
               <div style="width:100%;float:left;margin-top:20px;">

                <!--  <input type="button" class="fg-but btn_one btn_submit" value="提交">
                <input type="button" class="fg-but btn_two btn_close" value="关闭"> -->
               
                 <?php if($row['line_kind']==3):?>
                 <?php if($row['status']!='2'):?>
                 <input type="button" class="fg-but btn_one btn_submit" value="重新提交">
                 <?php else:?>
                 <input type="button" class="fg-but btn_one btn_submit" value="提交">
                 <?php endif;?>
               <?php endif;?>
                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
                 
                </div>
            </div>
           
        </form>
    </div>
   
    <!-- 表单结束 -->
        </div>
	</div>
<script type="text/javascript">

var m_date="";
		                              
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

     var radio_value="<?php echo $row['type'];?>";
	 if(radio_value=="2")
     {
         $(".part1").show();
         $(".part2").hide();
     }
     else
     {
     	  $(".part1").hide();
           $(".part2").show();
     }
	
	//服务类型
	//$("body").on("click",".server_range ul li",function(){
	
	$(".server_range ul li").click(function(){
		var value=$(this).attr("value");
		$(".server_range").attr("data-value",value);
	})
	//销售对象
	$(".sell_object ul li").click(function(){
		var value=$(this).attr("value");
		var name=$(this).html();
		$(".sell_object").attr("data-value",value);
		$(".sell_object").attr("data-name",name);
	})
	$(".agent_object ul li").click(function(){
		var value=$(this).attr("value");
		$(".agent_object").attr("data-value",value);
	})
	//供应商
	$(".supplier_id ul li").click(function(){
		var value=$(this).attr("value");
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


	//服务类型管理    on：用于绑定未创建内容
	$("body").on("click",".a_server",function(){
     //   alert(window.name);
		window.top.openWin({
		  title:"服务类型管理",
		  type: 2,
		  area: ['50%', '80%'],
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b1/line_single/server_range');?>"+"?iframeid="+window.name
		});
	});
	
});


//提交按钮
$("body").on("click",".btn_submit",function(){

	var dest_id=$("#dest_id").attr("data-id");
	var startplace=$("#startplace").attr("data-id");
	var linecode=$("#linecode").val();
	var linename=$("#linename").val();
	
	var server_range=$(".server_range").attr("data-value");
	var sell_object=$(".sell_object").attr("data-value");
      var sell_object_id=$(".sell_object").attr("data-id");
	var object_name=$(".sell_object").attr("data-name");
	var supplier_id=$(".supplier_id").attr("data-value");
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

    var agent_object=$(".agent_object").attr("data-value");
    var item=$(".radio:checked").val();
    var agent_rate=$("#agent_rate").val();
    var adult_agent=$("#adult_agent").val();
    var child_agent=$("#child_agent").val();
    var childnobed_agent=$("#childnobed_agent").val();
    var old_agent=$("#old_agent").val();

   
    if(dest_id=="") { tan('目的地不能为空');return false; }
    if(startplace=="") { tan('出发城市不能为空');return false; }
    if(linecode=="") { tan('单项编号不能为空');return false; }
    if(linename=="") { tan('单项名称不能为空');return false; }
  
    //if(server_range=="-1") { tan('请选择服务类型');return false; }
    //if(sell_object=="-1") { tan('请选择销售对象');return false; }
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
    
    if(agent_object=="-1") { tan('请选择佣金收取对象');return false; }
   
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

    var url="<?php echo base_url('admin/b1/line_single/api_update_single');?>";
    var id="<?php echo $row['id'];?>"; //b_single_affiliated 表id
    var data={
    	    id:id,
    	    dest_id:dest_id,
    	    startplace:startplace,
    	    linecode:linecode,
    	    linename:linename,
    	    server_range:server_range,
    	    sell_object:sell_object,
         sell_object_id:sell_object_id,
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
    	    item:item,
    	    agent_rate:agent_rate,
    	    adult_agent:adult_agent,
    	    child_agent:child_agent,
    	    childnobed_agent:childnobed_agent,
    	    old_agent:old_agent,
    	    line_classify:line_classify
    	    };
    var return_data=send_ajax_noload(url,data);
    if(return_data.code=="2000")
    {
    		
    		
    		parent.location.reload();
    		//window.location.href="admin/b1/line_single";
    		$('.btn_close').click();
                         //$('.table1').click();
		//tan2(return_data.data);
		//setTimeout(function(){t33_close_iframe();},200);

		//刷新页面
		//parent.$("#main")[0].contentWindow.getValue();
		//  window.location.reload();
		//  parent.location.reload();
		
	     window.location.href="admin/b1/line_single";
    }
    else
    {
        tan(return_data.msg);
    }
	
     	
});


//计算

function cal()
{
  var type=$(".agent_object").attr("data-value"); //1是营业部，佣金算在销售价；2是供应商，佣金算在结算价
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
	  if(rate=="1")
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
      }
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
	 var url="<?php echo base_url('admin/b1/line_single/api_server_range');?>";
     var data={};
     var return_data=send_ajax_noload(url,data);
     var html="";
     for ( var i in return_data.data.result)
     {   
         html+="<li value='"+return_data.data.result[i].id+"'>"+return_data.data.result[i].server_name+"</li>";
         
     }
     $(".server_range ul").html(html);
}

function b_uploadFile(obj)
{
	var inputname = $(obj).attr("name");
	var hiddenObj = $(obj).nextAll("input[type='hidden']");

	var formData = new FormData($("form" )[0]);
	formData.append("inputname", inputname);
	$.ajax({
			type : "post",
			url : "/admin/b1/line_single/upload_file",
			data : formData,
			dataType:"json",
			async: false,
      		cache: false,
      		contentType: false,
      		processData: false,
			success : function(data) {

				if(data.code=="2000")
				{
					var value=hiddenObj.val();
					hiddenObj.val(data.imgurl+","+value);

					var filename=hiddenObj.attr("data-name");
					hiddenObj.attr("data-name",data.filename+","+filename);

					$(obj).parent().append("<font>"+data.filename+"上传成功</font>");
					$(obj).parent().parent().find(".olddiv").hide();
				}
				else
					alert(data.msg);
			},
			error:function(data){
				alert('请求异常');
			}
		});
}


/*   $("body").on("focus","#sell_name",function(){
          $(".ul_expert").css("display","block");
          expert_search();
  }) */

/*   $("body").on("keyup","#sell_name",function(){
          expert_search();
  })
  function expert_search()
  {
        var content=$("#sell_name").val();
        showUnionExpert("sell_name",content);
  } */

</script>
</body>

</html>
