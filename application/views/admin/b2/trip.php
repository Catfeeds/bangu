

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office"  xmlns:w="urn:schemas-microsoft-com:office:word"  xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $line['data']['linename'];?></title>
<xml><w:WordDocument><w:View></w:View></xml>
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/layer.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/common/common.js"); ?>"></script>
<style>

/*公共部分*/

 body{ font: 12px/1.5 tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif; line-height:150%; margin: 0; padding:0; color:#333;height:auto !important;}
 div{ padding:0; margin:0;word-break:break-all;}
 span,p{word-break:break-all;}
 h1,h2,h3,h4,h5,h6,ul,li,dl,dt,dd,img,ol{margin:0; padding:0; border:none; list-style-type:none; font-family: '微软雅黑';font-weight:500 !important;}
 a{ text-decoration:none;color:#428bea;}
 em {FONT-STYLE: normal; FONT-WEIGHT: normal;font-family: Arial,Helvetica,sans-serif;}
 a:hover{ text-decoration:none}
 img { border:none;margin:0;}
 i,em { font-style:normal;}
 input:-webkit-autofill {-webkit-box-shadow: 0 0 0px 1000px white inset;}
 input,textarea,select { outline:none;border:1px solid #bbb;}
 ul { list-style: none;}
/* public */
.clear { zoom:1; clear:both; }
.clear:after { content:''; display:block; clear:both; }
.fl { float:left; }
.fr { float:right; }
*{ box-sizing:border-box ;margin:0;padding:0;}

#page { overflow-y : hidden ;overflow-x : hidden ;}
body { overflow-y : auto ;overflow-x : auto ;}
/*=====================表格================*/
table { border-spacing: 0; border-collapse: collapse;}
.table { width:100%;}
.table>thead.th-border>tr>th { border-right:1px solid #ddd;}
.tab_content { background-color: #fff; padding: 0px 10px 15px;position: relative;}
.tab_content.tabs_flat { -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none;}
.table_list { height:auto;}	
.h_100 { height:100px;}
.h_200 { height:200px;}
.table { background-color: #fff; margin-bottom: 0;}
.fc-border-separate thead tr, .table thead tr {
    background-color: #f2f2f2;
    background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgeG1sbnM9Imh0d…0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2xlc3NoYXQtZ2VuZXJhdGVkKSIgLz48L3N2Zz4=);
    background-image: -webkit-linear-gradient(top,#f5f5f5 0,#fdfdfd 100%); 
    background-image: -moz-linear-gradient(top,#f5f5f5 0,#fdfdfd 100%);
    background-image: -o-linear-gradient(top,#f5f5f5 0,#fdfdfd 100%);
    background-image: linear-gradient(to bottom,#f5f5f5 0,#fdfdfd 100%); 
    font-size: 12px;
}
.table thead>tr>th { border-bottom: 3px solid #ed4e2a; border-bottom: 0; font-size: 12px; font-weight: normal; padding: 10px 0; background: #F1F1F1;font-family:"Microsoft YaHei";}
.table>thead>tr>th,.table>tbody>tr>td { text-align:center;padding:3px 3px; vertical-align: top; border-top: 1px solid #e0e0e0;font-family:tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif;} 
td.control_td { position:relative;} 
.con_txt { display:inline-block;width:30px;position:absolute;left:0;top:-6px;height:30px;line-height:30px;cursor:pointer;}

.table thead.border>tr>th { vertical-align: bottom; border-bottom: 2px solid #ddd;}
.table.odd_bg>tbody>tr:nth-child(odd)>td { background:#f9f9f9;}
.table.even_bg>tbody>tr:nth-child(even)>td { background:#f9f9f9;}
.action_type { color:#428bea;}
.action_type:hover { text-decoration:underline !important;color:#2a6495 !important;}
.table-bordered { border: 1px solid #ddd;}
.table-bordered>tbody>tr>td { border: 1px solid #e0e0e0;}
.table tbody tr td { font-size:12px;}
.table tbody tr td span.btn { padding:4px 6px;}
.table tbody tr td a { display:inline-block;color:#09c !important;text-align: left;font-family:tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif;}
#page_div {background:#fff;padding-bottom:15px; }
.td_long a{float:left;}

.table_td_border>tbody>tr {
    height: 26px;
}
.table_td_border>tbody>tr>td {
    border: 1px solid #e0e0e0 !important;
    width:100px;
}
.small_title_txt {
    padding-bottom: 5px;
    border-bottom: 1px solid #ddd;
}
.content_part table {
    margin: 10px 0;
}
.small_title_txt .txt_info {
    font-weight: normal;
    font-size: 14px;
    padding-left: 15px;
    font-family: "微软雅黑";
    }
.content_part {
    margin-top: 17px;
    margin-bottom: 17px;
}
.order_info_table{
background:#fff;
border:1px solid #e0e0e0;
}
.order_info_table tr td {
    padding-left: 10px;
    font-size: 12px;
    font-family: "tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif" !important;
    color: #000;
    border: 1px solid #e0e0e0;
}

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
font-family: tahoma,arial,'Hiragino Sans GB','\5b8b\4f53',sans-serif;
  /*border: solid 1px blue;*/
/*   margin: 10mm 15mm 10mm 15mm; /* margin you want for the content */ */
}

.no_data{width:100%;float:left;height:50px;margin-top:24%;color:red;text-align:center;font-size:14px;}
.close_div{
  height:28px;
  text-align:right;
  width:700px;
  float:left;
  margin:4px 0;
  padding:0;
}
.btn_close{
	    background: #da411f;
	    width: 60px;
	    float:right;
	    margin-right: 20px;
	   
	    padding: 5px 10px;
	    border-radius: 3px;
	    color: #fff;
	    border: none;
	    text-align: center;
	    cursor: pointer;
	    line-height: 1.42857143;
	    color: #fff !important;
	    border: none !important;
	    font-weight: 400;
	    white-space: nowrap;
	    vertical-align: middle;
	    position:relative;
	}
	
 .three_p{margin:5px auto;width:100%;float:left;border-bottom:1px solid #ddd;padding-bottom:10px;font-size:12px;}
 .three_p font{color:#66C9F3;float:left;border:1px solid #66C9F3;padding:4px;margin-right:10px;}
 .three_p input{width:45px;padding-left:5px;background:#ebebe4;}
 .three_p p{float:left;}
	
	pre { 
	font-size:12px; 
white-space: pre-wrap; /* css-3 */ 
white-space: -moz-pre-wrap; /* Mozilla, since 1999 */ 
white-space: -pre-wrap; /* Opera 4-6 */ 
white-space: -o-pre-wrap; /* Opera 7 */ 
word-wrap: break-word; /* Internet Explorer 5.5+ */ 
} 


/***  行程  ***/
.trip_table{width:700px;border:1px solid #002060;}
.trip_table tr{line-height:20px;}
.trip_table tr th{background:#1F497D;color:#fff;}
.trip_table tr{background:#1F497D;}
.trip_table tr td{background:#fff;text-align:center;border:1px solid #002060;}

.trip_p{width:700px;height:24px;line-height:24px;color:#093c7c;font-size:12px;font-weight:bold;}

.trip_p2{width:700px;height:24px;line-height:24px;color:#093c7c;font-size:12px;font-weight:bold;border-bottom:2px solid #002060;}
.trip_p3{width:700px;height:24px;line-height:24px;color:#da0000;font-size:12px;font-weight:bold;}
.content_p{text-indent:20px;margin-bottom:10px;}

</style>
<style type="text/css" media=print>
.close_div{visibility:hidden;display : none;}   //不打印
</style>
</head>
<body>
	
    <!--=================右侧内容区================= -->
    <div class="page-body_detail" id="bodyMsg">
    
       
        
        <!-- ===============订单详情============ -->
        <div class="close_div">
        <span class="layui-layer-close btn btn_close" style="width:70px;" onclick="javascript:window.location.href='<?php echo base_url('admin/t33/login/createword?id=').$line['data']['id'].'&dayid='.$dayid;?>';">导出word</span>
        <span class="layui-layer-close btn btn_close" style="width:70px;" onclick="javascript:window.print();">打印行程</span>
        <!--  <span class="layui-layer-close btn btn_close" style="width:70px;" onclick="javascript:window.location.href='<?php echo base_url('admin/t33/sys/line/create_word?id=').$line['data']['id'];?>';">导出word</span> -->
        </div>
        <div class="clear" style="width:700px;margin:0 auto;">
          
            <?php if(isset($logo['logo'])):?>
           <div><img src="<?php echo isset($logo['logo'])==true?BANGU_URL.$logo['logo']:'';?>" alt="" style="width: 700px;max-height:100px;" /></div>
           <?php endif;?>
           <h1 style="color:#000;text-align:center;margin:10px auto;line-height:28px;">
           <?php 
           $arr=explode("·", $line['data']['linename']);
           if(empty($arr))
             echo $arr[0];
           else 
             echo $arr[1];
           	
           ?>
           </h1>
           <div><img src="<?php echo BANGU_URL.$line['data']['mainpic'];?>" alt="" style="width: 700px;" /></div>
           <div><?php echo $line['data']['features'];?></div>
            <!-- ===============基础信息============ -->
            <!--  价格 -->
            <table class="trip_table">
                <tr><th>成人价</th><th>老人价</th><th>儿童占床价</th><th>儿童不占床价</th></tr>
                <tr>
                     <td><?php echo isset($suit['adultprice'])==true?$suit['adultprice']:""; ?></td>
                     <td><?php echo isset($suit['oldprice'])==true?$suit['oldprice']:""; ?></td>
                     <td><?php echo isset($suit['childprice'])==true?$suit['childprice']:""; ?></td>
                     <td><?php echo isset($suit['childnobedprice'])==true?$suit['childnobedprice']:""; ?></td>
                </tr>
                 <tr>
                     <td></td>
                     <td><?php echo isset($line['data']['old_description'])==true?$line['data']['old_description']:""; ?></td>
                     <td><?php echo isset($line['data']['child_description'])==true?$line['data']['child_description']:""; ?></td>
                     <td><?php echo isset($line['data']['child_nobed_description'])==true?$line['data']['child_nobed_description']:""; ?></td>
                </tr>
            </table>
             <!--  行程预览 -->
             <p class="trip_p"><font>行程预览</font><font style='float: right;'>出团时间：<?php echo isset($suit['day'])==true?$suit['day']:'';?></font></p>
             <table class="trip_table">
                <tr><th>天数</th><th>行程安排</th><th>早餐</th><th>中餐</th><th>午餐</th><th>住宿酒店</th></tr>
                <?php if(!empty($list)):?>
                  <?php foreach ($list as $trip=>$trip_value):?>
                    <tr>
                    <td><?php echo '第'.$trip_value['day'].'天';?></td>
                    <td><?php echo $trip_value['title'];?></td>
                    <td><?php echo $trip_value['breakfirsthas'] == "1" ? $trip_value['breakfirst'] : "--";?></td>
                    <td><?php echo $trip_value['lunchhas'] == "1" ? $trip_value['lunch'] : "--";?></td>
                    <td><?php echo $trip_value['supperhas'] == "1" ? $trip_value['supper'] : "--";?></td>
                    <td><?php echo $trip_value['hotel'];?></td>
                    </tr>
                  <?php endforeach;?>
                <?php endif;?>
            </table>
             <!--  行程介绍 -->
             <p class="trip_p"><font>【行程介绍】</font></p>
              <?php if(!empty($list)):?>
                <?php foreach ($list as $k=>$v):?>
                  <p class="trip_p2"><font>第<?php echo $v['day'];?>天 <?php echo isset($v['title'])==true?$v['title']:""; ?></font></p>
                  <p style="text-indent:20px;line-height:20px;"><?php echo isset($v['jieshao'])==true?$v['jieshao']:""; ?></p>
                  <div style='margin-bottom:10px; '>
                   <?php if(!empty($v['pic_arr'])):?>
                            <?php foreach ($v['pic_arr'] as $k=>$v):?>
                               <img src="<?php echo BANGU_URL.$v;?>" style="height:184px;max-width:254px;" />
                            <?php endforeach;?>
                         <?php endif;?>
                  </div>
              <?php endforeach;?>
             <?php endif;?>
             <!--  保险说明、签证说明等等 -->
            <p class="trip_p"><font>接待标准</font></p>
              <p class="trip_p3"><font>【费用包含】</font></p>
	               <?php if(!empty($line['data']['feeinclude'])):?>
	               <p style='text-indext:20px;'><?php echo $line['data']['feeinclude'];?></p>
	               <?php endif;?>
              <p class="trip_p3"><font>【费用不含】</font></p>
	              <?php if(!empty($line['data']['feenotinclude'])):?>
	                <p style='text-indext:20px;'><?php echo $line['data']['feenotinclude'];?></p>
	              <?php endif;?>
              
          
             <p class="trip_p"><font>保险说明</font></p>
                  <?php if(!empty($line['data']['insurance'])):?>
	                <p class='content_p'><?php echo $line['data']['insurance'];?></p>
	              <?php endif;?>
	              
             <p class="trip_p"><font>签证说明</font></p>
                  <?php if(!empty($line['data']['visa_content'])):?>
	                <p class='content_p'><?php echo $line['data']['visa_content'];?></p>
	              <?php endif;?>
	              
             <p class="trip_p"><font>购物自费说明</font></p>
                  <?php if(!empty($line['data']['other_project'])):?>
	                <p class='content_p'><?php echo $line['data']['other_project'];?></p>
	              <?php endif;?> 
             
             <p class="trip_p"><font>特别约定</font></p>
                  <?php if(!empty($line['data']['special_appointment'])):?>
	                <p class='content_p'><?php echo $line['data']['special_appointment'];?></p>
	              <?php endif;?> 
             
             <p class="trip_p"><font>温馨提示</font></p>
                  <?php if(!empty($line['data']['beizu'])):?>
	                <p class='content_p'><?php echo $line['data']['beizu'];?></p>
	              <?php endif;?> 
	              
	        <p class="trip_p"><font>安全提示</font></p>
                  <?php if(!empty($line['data']['safe_alert'])):?>
	                <p class='content_p'><?php echo $line['data']['safe_alert'];?></p>
	              <?php endif;?> 
   
        </div>
	</div>

	    <!-- 导入供应商 弹层 -->
	 <div class="fb-content" id="choose_depart" style="display:none;/*height:350px;*/">
	    <div class="box-title">
	        <h5>word下载</h5>
	        <span class="layui-layer-setwin">
	            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
	        </span>
	    </div>
	    <div class="fb-form">
	        <form method="post" action="#" id="add-data" class="form-horizontal">
                <p >word已经生成，是否立即下载？</p>
	            <div class="form-group" style="margin-top:120px;">
	                <input type="hidden" name="id" value="">
	                <input type="button" class="fg-but layui-layer-close" value="取消">
	                <input type="button" class="fg-but btn_sure" value="确定">
	            </div>
	            <div class="clear"></div>
	        </form>
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
	
    $("body").on("click",".btn_word",function(){
        
		 var line_id=$(this).attr("data-id");

		 var url="<?php echo base_url('admin/t33/sys/line/create_word');?>";
	     var data={line_id:line_id};
	     var return_data=send_ajax_noload(url,data);
	       
	        if(return_data.code=="2000")
	        {
	        	//tan(return_data.data);
	        	layer.confirm('word已经生成，是否立即下载？', {
	  			  btn: ['确定','取消'] //按钮
	  			}, function(){

	  				window.location.href=return_data.data;
	  			 
	  			  
	  			}, function(){
	  			  
	  			});
	  			
	        }
	        else
	        {
	            tan(return_data.msg);
	        }
	        
		
	});


    </script>
	
	
</body>

</html>
