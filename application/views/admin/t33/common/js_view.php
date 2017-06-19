<style type="text/css">
	.table_content { background:#fff;}
	.tab_content { padding:0 0 15px !important;}
	.search_form_box { width:1000px;padding: 10px 0px 0px 0 !important;}
	.search_form_box .search_group label { display:inline-block;width:64px;text-align:right;}
	.table tbody tr td a { margin:0 5px;}
</style>

<link href="<?php echo base_url("assets/ht/css/base.css"); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url("assets/ht/css/style.css"); ?>" rel="stylesheet">
<link href="<?php echo base_url("assets/ht/css/jquery.datetimepicker.css"); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/jquery-1.11.1.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/base.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/jquery.datetimepicker.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/layer.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/laypage.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/common/common.js?v=").time(); ?>"></script>
<script type="text/javascript">
	window.onload = function(){
		//$(".table>tbody>tr>td a").parent().css("padding","6px 10px");
	};

	//每页显示记录数：失去焦点时
	$(document).ready(function(){
	
		$(".pagesize").blur(function(){
			var pagesize=$(".pagesize").val();
			if(pagesize!="")
			object.init();
		})
		
	})
	
	//js 强制保留2位小数点
	function toDecimal2(x) { 
      var f = parseFloat(x); 
      if (isNaN(f)) { 
        return false; 
      } 
      var f = Math.round(x*100)/100; 
      var s = f.toString(); 
      var rs = s.indexOf('.'); 
      if (rs < 0) { 
        rs = s.length; 
        s += '.'; 
      } 
      while (s.length <= rs + 2) { 
        s += '0'; 
      } 
      return s; 
    } 
</script>