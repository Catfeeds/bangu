<link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>		
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 

<div id="img_upload" style="z-index:1000">
	<div id="altContent"></div>
	<div class="close_xiu" onclick="close_xiuxiu();" style=" z-index:10003">×</div>
	<div class="right_box" style=" z-index:10004"></div>
</div>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<?php if(!empty($mold)){ ?>
		<li class="active">新增帮游产品</li>	
		<?php }else{?>
		<li class="active">新增产品</li>
		<?php } ?>
		
	</ul>
</div>
<!-- /Page Breadcrumb -->
<style type="text/css">
.form-control {
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	color: #555;
	display: block;
	font-size: 14px;
	height: 34px;
	line-height: 1.42857;
	padding: 6px 12px;
	margin: 0px 14% 0px 0px;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s
		ease-in-out 0s;
	width: 50%;
}
.col-sm-2 {
	width: 135px;
	 float: left;
	 text-align: right;
}

.col-sm-2s {
	width: 6.%;
}

/*.col-lg-4 {
	width: 9%;
}*/

.shop_insert_label {
	width: 1%;
	margin-left: -5%;
}

/*.shop_insert_labels {
	margin-left: -4%;
}*/

.shop_insert_label_j {
	margin-left: -5.5%;
	width: 72px;
}

.shop_insert_day {
	margin-left: -3%;
}

.shop_insert_days {
	margin-left: -1.5%;
}

input[type="checkbox"], input[type="radio"] {
	left: 0px;
	opacity: 100;
	position: static;
}

.shop_insert_input {
	width: 60px;
}

.col-lg-4-k {
	
}

.col-lg-4s {
	width: 9%;
}

.user_name_b1 {
	width: 100px;
}
 .selectedContent,.line-lable{
  color: #2dc3e8;
  height: 30px;
  line-height: 35px;
  position: relative;
  background: #edf6fa;
  border: 1px solid #d7e4ea;
  padding: 6px 20px 6px 12px;
  margin-right: 2px;
  vertical-align: middle;
  cursor: pointer;
}
 .selectedContent a{
  display: block;
  width: 24px;
  height: 32px;
  position: absolute;
  top: 0;
  right: 0;
  cursor: pointer;
  text-align: center
}
.tree-node-empty {
  height: 18px;
  width: 20px;
  float: left;
}

.table-class input[type=checkbox] {
	opacity: 100;
	position: inherit;
	left: 0px;
	z-index: 12;
	width: 16px;
	height: 16px;
	cursor: pointer;
	vertical-align: middle;
	margin: 0;
}
ul li{
  list-style: none;
    margin: 0;
}
.form-horizontal .control-label{ 
	padding-top: 0px;
	 line-height: 34px;
	}
/* 批量上传图片的样式*/
	.img_main{
	  width: 190px;
	  height: 190px;
	  overflow: hidden;
	
	}
	
	.float_div{
	 position:unset;
	width:17px;
	height:17px;
	border:1px solid lightgray;
	float:right;
	z-index:100;
	background-color: lightgray;
	color: #000;
	font-size: 21px;
	font-weight: 700;
	opacity: 0.2;
	}

	.float_img{ 
		position:absolute;
		height:16px;
		z-index:100;
		color: #00b7ee;
		font-size: 21px;
		font-weight: 700;
		opacity: 1;
		font-size:24px;
		top:-25px;
		right:-5px;
		cursor: pointer;
	}
	.webuploader-pick{ left:0px;}
	.parentFileBox{float:left;width:100px;}
	.parentFileBox .fileBoxUl{display:none;};
	.parentFileBox .diyButton{float:left;};      
    .checkbox input{display: none}
     input[type="file"]{ display: inline;}
    #myTab11 li{float:left; 
      margin-bottom: 0;
      border: 0 none;
      top: 2px;
       margin-bottom: -2px;
      display: block;
      position: relative;
    } 
     #myTab11 .home a{
         color: #262626;
		 border: 0;
		 border-top: 2px solid #2dc3e8;
		 border-bottom-color: transparent;
		 background-color: #fbfbfb;
         z-index: 12;
		 line-height: 16px;
         margin-top: -2px;
         box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15); 
     }  
.choice_img { display:inline-block;width:80px;height:35px;line-height:35px;text-align:center;background:#00b7ee;color:#fff;cursor:pointer;border-radius:4px;}
.selectedTitle{float: left;padding-right: 10px;padding-top: 8px;}

.list_click{ width: auto; }

.zhutu{float: left;font-size: 10px;margin-top: 5px;margin-left: 12px;}
.des_title{
	margin-left:50px;
	font-size:20px;
	display: inline-block;
	text-align: center;
	color: #fff;
	cursor: pointer;
	border-radius: 5px;
    display: inline-block;
    width: 160px;
    height: 80px;
	background:#ccc;
}
.des_title a {  display: inline-block;width:160px;height:80px;padding-top:50px;color:#fff;}
.des_title a.des_title1 { background: url(<?php echo base_url() ;?>assets/img/cj.png) center 5px no-repeat;}
.des_title a.des_title2 { background: url(<?php echo base_url() ;?>assets/img/gn.png) center 5px no-repeat;}
.des_title a.des_title3 { background: url(<?php echo base_url() ;?>assets/img/zb.png) center 5px no-repeat;}
a:link{text-decoration:none;}
a:visited{text-decoration:none;}
a:active{text-decoration:none;} 

</style>
<script type="text/javascript">

</script>
<div class="widget flat radius-bordered">
	<div class="widget-body" style=" height: 500px;">
		<div class="widget-main ">
			<div class="tabbable">

					<!--目的地-->
					<div class="tab-pane active" id="home1">
						<div style="margin-top:150px;margin-left:100px;">
							<div class="des_title">
								<a class="des_title1" href="<?php if(!empty($mold)){ ?>/admin/b1/product_insert?type=cjy&mold=c<?php }else{ ?>/admin/b1/product_insert?type=cjy<?php }?>">
								  出境游
								</a>
							</div>
							<div class="des_title">
								<a class="des_title2" href="<?php if(!empty($mold)){ ?>/admin/b1/product_insert?type=gny&mold=c<?php }else{ ?>/admin/b1/product_insert?type=gny<?php }?>">
								 国内游
								</a>
							</div>
							<div class="des_title">
								<a class="des_title3" href="<?php if(!empty($mold)){ ?>/admin/b1/product_insert?type=zby&mold=c<?php }else{ ?>/admin/b1/product_insert?type=zby<?php }?>">
								 周边游
								</a>
							</div>
							<input  type="hidden" name="des_data" value="0">
						</div>
					</div>
			</div>
		</div>
	</div>
</div>

			 
		
