<style type="text/css">
    .form-group{margin-right:20px; margin-top: 8px;}
    .form-group label{margin-top: 8px;}
    .page-body{padding:10px 20px 24px}
</style>
<!-- Page Breadcrumb -->

                <!-- /Page Breadcrumb -->
                <!-- Page Header 
                <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
                        <li class="active">我的场景秀</li>
                    </ul>
            </div>-->
                <!-- /Page Header -->
                <!-- Page Body -->
               <div class="page-body" id="bodyMsg">  
			   <!-- 内网  e.51ubang.com  外网  e.1b1u.com  -->
               <iframe style="border:0;" id="eqixiu" src='' width="100%" height="900px" style="border: none">  
               </iframe>	
<script>
var eqixiuUrl="<?php if(!empty($ip)){ print_r($ip[0]['eqixiu_url'] )  ;} ?>";
var username="<?php if(!empty($expert)){echo $expert[0]['mobile'];} ?>";
var password="<?php if(!empty($expert)){echo $expert[0]['password'];} ?>";
$(function(){
	eqixiuUrl =eqixiuUrl+"/1b1uinner.html?password="+password+"&username="+username;
	document.getElementById("eqixiu").src= eqixiuUrl;
});

</script>