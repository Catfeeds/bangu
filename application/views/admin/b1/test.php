<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试模板</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
</style>
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
</head>
<body>
 打印为匹配的数据
 <input type="text" name="s_startdate" value="" id="startdate"/>
 <input type="text" name="s_endtdate" value=""  id="enddate"/>
 <input type="button" value="提交" onclick="get_line_dest()" />
 <br/> <br/>
 <input type="text" name="up_startdate" value="" id="startdate" />
 <input type="text" name="up_endtdate" value="" id="enddate" />
 <input type="button" value="提交" onclick="update_line_dest()"/> 

 <div class="msg"></div>
 <link href="/assets/ht/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery.datetimepicker.js"></script>
 <script>


 $("body").find('#startdate').datetimepicker({
       lang:'ch', //显示语言
       timepicker:false, //是否显示小时
       format:'Y-m-d', //选中显示的日期格式
       formatDate:'Y-m-d',
       validateOnBlur:false,
 });

 $("body").find('#enddate').datetimepicker({
     lang:'ch', //显示语言
     timepicker:false, //是否显示小时
     format:'Y-m-d', //选中显示的日期格式
     formatDate:'Y-m-d',
     validateOnBlur:false,
});
 //打印为匹配的数据
 function get_line_dest(){
	 var startdate=$("input[name='s_startdate']").val();
	 var endtdate=$("input[name='s_endtdate']").val();
	// $('.msg').html('数据加载中...');
    jQuery.ajax({ type : "POST",async:false,data : {startdate:startdate,endtdate:endtdate},url : "<?php echo base_url()?>admin/b1/test/sel_line_dest", 
          success : function(result) { 
        	  $('.msg').html(result);
           }
     });
     
 }

 //替换目的地
 function update_line_dest(){
	 var startdate=$("input[name='up_startdate']").val();
	 var endtdate=$("input[name='up_endtdate']").val();
     jQuery.ajax({ type : "POST",async:false,data : {startdate:startdate,endtdate:endtdate},url : "<?php echo base_url()?>admin/b1/test/up_line_dest", 
           success : function(result) { 
                 var result =eval("("+result+")"); 
                 //$('.msg').html(result);
           }
     });
 }
</script>
</body>
</html>

