<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<style type="text/css">


</style>

<script type="text/javascript">

$(document).ready(function(){
	 var current = 0;
	 
	    document.getElementById('img_l').onclick = function(){
	     
	        current = (current+90)%360;
	        var obj=document.getElementById('target');
	        obj.style.transform = 'rotate('+current+'deg)';
	    }
	
})

function ImageSuofang(args) { 
            var oImg = document.getElementById("target"); 
            if (args) { 
			
                oImg.width = oImg.width * 1.2; 
                oImg.height = oImg.height * 1.2; 
            } 
            else { 
                oImg.width = oImg.width / 1.1; 
                oImg.height = oImg.height / 1.1; 
            } 
        }     
</script>

</head>
<body>



 <p style="float: left;width:100%;position:fixed;background:#fff;z-index:999;padding-top:5px;">
 <img id="img_big" onclick="ImageSuofang(true)" src="<?php echo base_url('assets/ht/img/icon_big.png');?>" style="height:24px;margin:0px 0 0 10px;float:left;cursor:pointer;" >

 <img id="img_small" onclick="ImageSuofang(false)" src="<?php echo base_url('assets/ht/img/icon_small.png');?>" style="height:24px;margin:0px 0 0 10px;float:left;cursor:pointer;" >
  
  <img id="img_l" src="<?php echo base_url('assets/ht/img/icon_l.png');?>" style="height:24px;margin:0px 0 0 10px;float:left;cursor:pointer;" >
  </p>
  
   <img id="target" src="<?php echo BANGU_URL.$url;?>" style="margin-top:24px;" />
  
 
 </body>

</html>


