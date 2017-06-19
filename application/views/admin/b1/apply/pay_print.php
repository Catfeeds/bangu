<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款申请单</title>
<!--startprint1-->
<style type="text/css">


/* 去掉页眉页脚  */
@page {
  size: auto;  /* auto is the initial value */
  margin: 0mm; /* this affects the margin in the printer settings */
}
html {
  background-color: #FFFFFF;
  margin: 0px; /* this affects the margin on the HTML before sending to printer */
}
body {
  /*border: solid 1px blue;*/
  margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */
}




.p_line{height:16px;line-height:16px;margin:5px 0;text-align:center;}

.td_left{text-align:left !important;}
.td_right{text-align:right !important;}
.printTable td,.printTable>tbody>tr>td,.printTable>thead>tr>th{border: 1px solid #000!important;;}

.printf_div{padding: 15px 0 0 0 !important;width: 720px;margin: 0 auto;}
.pagehead p{float:left;width:600px;margin:2px 0 2px 30px;}
</style>
<style type="text/css" media=print>
.noprint{visibility:hidden;display : none;}   //不打印
</style>
</head>
<body>
<?php 

function toChineseNumber($money){
	$money = round($money,2);
	$cnynums = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖");
	$cnyunits = array("元","角","分");
	$cnygrees = array("拾","佰","仟","万","拾","佰","仟","亿");
	@list($int,$dec) = explode(".",$money,2);

	$dec = @array_filter(array($dec[1],$dec[0]));
	$ret = array_merge($dec,array(implode("",cnyMapUnit(str_split($int),$cnygrees)),""));
	$ret = implode("",array_reverse(cnyMapUnit($ret,$cnyunits)));
	return str_replace(array_keys($cnynums),$cnynums,$ret);
}
function cnyMapUnit($list,$units) {
	$ul=count($units);
	$xs=array();
	foreach (array_reverse($list) as $x) {
		$l=count($xs);
		if ($x!="0" || !($l%4))
			$n=($x=='0'?'':$x).(@$units[($l-1)%$ul]);
		else $n=@is_numeric($xs[0][0])?$x:'';
		array_unshift($xs,$n);
	}
	return $xs;
}
$chinese=toChineseNumber($row['amount_apply']);
?>

<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content_detail bg_gray">      
            
            <!-- tab切换表格 -->
            <div class="table_content">
               
                <div class="printf_div" id="printf_div">
                  
                   
                  
                     <p class="p_line"><?php echo $row['union_name'];?></p>
                    <p class="p_line" style="font-size: 16px;">团队成本预付款单</p>
                     <div style="float: left;width:100%;margin-bottom:0px;" class="pagehead">
                    <p style="float: left;width:50%;">申请时间：<?php echo $row['addtime'];?></p><p style="float: right;width:40%;text-align:right;">打印时间：<?php echo date("Y-m-d H:i:s");?></p>
                    </div>
                    <!-- 收款确认单-->
                    <div class="table_list">
                       
                        <table class="table table-bordered table_hover printTable">
                            
                            <tbody class="data_rows">
                               <tr><td class="td_right" width="100px">付款单号：</td><td width="220px" class="td_left"><?php echo $row['id'];?></td><td class="td_right" width="100px">品牌名称：</td><td class="td_left"><?php echo $row['brand'];?></td></tr>
                               <tr><td class="td_right">供应商：</td><td class="td_left"><?php echo $row['company_name'];?></td><td class="td_right" width="100px">总结算：</td><td class="td_left"><?php echo $row['supplier_cost'];?></td></tr>
                               <tr><td class="td_right">原币付款金额：</td><td colspan="3" class="td_left">(CNY) <?php echo $row['amount_apply'];?></td></tr>
                               <tr><td class="td_right">付款金额：</td><td colspan="3" class="td_left">大写（人民币）：<?php echo $chinese;?> 
                                   &nbsp;&nbsp;&nbsp;小写（人民币）：<?php echo $row['amount_apply'];?>
                                  </td>
                               </tr>
                               <tr><td class="td_right">付款方式：</td><td colspan="3" class="td_left"><?php if($row['pay_way']=="0") echo "现金";else echo "转账";?></td></tr>
                               <!--  
                               <tr><td class="td_right">收款方：</td><td colspan="3" class="td_left"><?php //echo $row['bankcompany'];?></td></tr>
                               <tr><td class="td_right">开户行：</td><td class="td_left"><?php //echo $row['bankname'];?></td><td class="td_right">账号：</td><td class="td_left"><?php echo $row['bankcard'];?></td></tr>
                               -->
                               <tr><td class="td_right">备注：</td><td colspan="3" class="td_left"><?php echo $row['remark'];?></td></tr>
                               <tr><td class="td_right">申请人：</td><td class="td_left"><?php echo $row['expert_name'];?></td><td class="td_right">经办人：</td><td class="td_left"><?php echo $row['employee_name'];?></td></tr>
      
                            </tbody>
                        </table>
                   <?php if($row['p_status']==3 || $row['p_status']==5){ ?>
                         <div style="top:85px;margin-left: 409px;z-index:999999;position: absolute;"><img src="/assets/img/refuse.png" ></div>
                  <?php  } ?>
       
                     <!-- 收款记录明细 -->
                   <p class="p_line">付款申请明细</p>
                   
                    <div class="table_list">
                       
                        <table class="table table-bordered table_hover printTable">
                            <thead class="">
                                <tr>
                                   <th width="130">团号</th>
                                   <th width="70">订单号</th>
                                   <th width="180">线路名称</th>
                                   <th width="60">应收款</th>
                                   <th width="60">已交款</th>
                                   <th width="60">项目</th>
                                   <th width="60">总价</th>
                                   <th width="110">销售部门</th>
                                   <th width="60">销售</th>
                                  
                                </tr>
                            </thead>
                            <tbody class="data_rows">
                               <?php if(!empty($list)):?>
                                 <?php foreach ($list as $k=>$v):?>
                                  <tr>
                                  
                                   <td rowspan="2"><?php echo $v['item_code'];?></td>
                                   <td rowspan="2"><?php echo $v['ordersn'];?></td>
                                   <td rowspan="2" align="left" style="text-align: left;"><?php echo $v['productname'];?></td>
                                   <td rowspan="2"><?php echo $v['total_price'];?></td>
                                   <td rowspan="2"><?php echo $v['receive_total'];?></td>
                                   <td>操作费</td>
                                   <td><?php echo $v['platform_fee'];?></td>
                                   <td><?php echo $v['depart_name'];?></td>
                                   <td><?php echo $v['expert_name'];?></td>
                                  </tr>
                                  <tr>
                                   <td>结算金额</td>
                                   <td><?php echo $v['amount_apply'];?></td>
                                   <td><?php echo $v['depart_name'];?></td>
                                   <td><?php echo $v['expert_name'];?></td>
                                  </tr>
                                 <?php endforeach;?>
                              <?php endif;?>
      
                               <tr>
                               
                               <td colspan="5" style="text-align:right;font-weight:bold;padding-left:15px;">总计：</td>
                               <td colspan="4" class="td_right">（人民币） <?php echo sprintf("%.2f",($v['amount_apply']));?></td>
                              
                                </tr>
      
                            </tbody>
                        </table>

                    </div>  
                   </div>       
                </div>
                
                
					<div style="float: left;width:100%;margin-bottom:0px;" class="pagehead">
                    <p>抬头：<?php echo $row['bankcompany'];?></p>
                    <p>账号：<?php echo $row['bankcard'];?></p>
                    <p>开户行：<?php echo $row['bankname'];?></p>
                    </div>
                <!--endprint1-->  
                 <div class="fb-form noprint" style="width:100%;overflow:hidden;">
					        <form method="post" action="#" id="add-data" class="form-horizontal">
					           
					           
					           
					            <div class="form-group" style="margin:0 0 30px 0;text-align:right;float:left;width:98%;background:#fff;border:none;">
					               <div style="width:100%;float:left;margin-top:0px;border:none;">
					                 <input type="button" class="fg-but btn_two btn_close" value="关闭">
					                                             
					                 <input type="button" class="fg-but btn_one" onclick="preview(1);" style="background:#da411f;" value="打印">
					                 
					                </div>
					            </div>
					           
					        </form>
				   </div>
               
            </div>

        </div>
        
    </div>
   


<script type="text/javascript">

   var list_id="<?php echo $list_id;?>";
   
	//js对象
	var object = object || {};
	var ajax_data={};
	
	object = {
        init:function(){ //初始化方法

        },
        send_ajax:function(url,data){  //发送ajax请求，有加载层
        	  layer.load(2);//加载层
	          var ret;
	    	  $.ajax({
	        	 url:url,
	        	 type:"POST",
	             data:data,
	             async:false,
	             dataType:"json",
	             success:function(data){
	            	 ret=data;
	            	 setTimeout(function(){
	           		  layer.closeAll('loading');
	           		}, 200);  //0.2秒后消失
	             },
	             error:function(data){
	            	 ret=data;
	            	 //layer.closeAll('loading');
	            	 layer.msg('请求失败', {icon: 2});
	             }
	                     
	        	});
	      	    return ret;
    	  
          
        },
        send_ajax_noload:function(url,data){  //发送ajax请求，无加载层
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
      
      //object  end
    };

	
$(function(){

  
	
    //关闭按钮
    var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
    $("body").on("click",".btn_close",function()
    {
        // parent.layer.close(index);
    	window.close();
    });

});


function preview(oper)         
{  
	
	if (oper < 10)  
	{
		//var reply=$("#reply").val();
        //var url="<?php echo base_url('admin/t33/sys/approve/api_print_ok');?>";
        //var data={id:list_id};
        //var return_data=object.send_ajax_noload(url,data);

        //if(return_data.code=="2000")
       // {
        	//打印
        	 //$(".pagehead").show();
        		/* bdhtml=window.document.body.innerHTML;//获取当前页的html代码  
        		sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域  
        		eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域  
        		prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)); //从开始代码向后取html  
        		prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html  

        		window.document.body.innerHTML=prnhtml;   */
        		
        		window.print();  

        		//取消打印时恢复数据
        		window.location.reload();
       // }
       // else
       // {
            tan(return_data.msg);
        //}

	} 
	else 
	{  
		window.print();  
	}  
} 
function cal()
{
	 var money=0;
     $(".input_check").each(function(index,data){
     if($(this).is(':checked'))
	 {
		 var value=$(this).attr("data-value");
		 money+=parseInt(value);
	   }	  
      })
      $(".total_money").html(money);
}




</script>

</html>


