<!DOCTYPE html>
<!--
BeyondAdmin - w_1200 Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 1.0.0
Purchase: http://wrapbootstrap.com
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title>供应商管理系统</title>
    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- 声明某些双核浏览器使用webkit进行渲染 -->

    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
    <link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
    <!--Basic Styles-->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/weather-icons.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/hm.widget.css');?>" rel="stylesheet" /> 
	<link type="text/css" href="<?php echo base_url('assets/css/turn_price_form.css');?>" rel="stylesheet" />
    <!--Fonts-->
    <link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet">
    <!--Beyond styles-->
    <link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/demo.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url('assets/ht/css/base.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/common.css')?>" rel="stylesheet" />
    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
    <!--Basic Scripts-->
    <script src="<?php echo base_url('assets/js/jquery-1.8.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <!--Beyond Scripts-->
    <script src="<?php echo base_url('assets/js/beyond.min.js');?>"></script>
    <script src="<?php echo base_url('assets/ht/js/layer.js');?>"></script>
   
    <style type="text/css">
    	#top { position:fixed;top:0;left:0;width:100%;z-index: 1000;}
		.main-container { padding-top:60px;}
		#sidebar { overflow-y:auto;overflow-x:hidden;position:fixed;left:0;top:40px;}
		.page-sidebar:before { position:relative;}
        .page-sidebar .menu-dropdown  {
             background-color: #fff;
         }
        .page-sidebar .menu-dropdown  {
            color: #262626;
        }
.hamerr{ height:40px;}
.hamerr i {
    float: left;
    margin-top: 5px;
    margin-left: 10px;
    display: inline-block;
    width: 20px;
    height: 28px;
    background: url(../../../../assets/img/lingdang.png) no-repeat;
    background-position: 0px 0px;
    background-size: cover;
}
.hamerr span {
    float: left;
    background: #f90;
    width: 30px;
    height: 20px;
    color: #fff;
    margin: 10px 14px;
    margin-left: 8px;
    text-align: center;
    line-height: 19px;
    border-radius: 4px;
}
	.main-container>.page-container { position:static;}
	.close_xiu{  z-index: 100000;}
	.form-horizontal .control-label{ line-height: 34px; }
	.pop_city_container a{ width: 72px; border:1px solid #fff;text-align: center; padding-left: 0 }
	.attr-item-selected{ border:1px solid #d7e4ea !important }
	.form-group .col_xl{ height: 30px; line-height: 30px; }
	.line-lable, .selectedContent{ cursor: pointer; }
	.float_div{ position: relative; }
	/* .#ThumbPic li{ width: auto; padding:10px;  }     */
	#calendarDiv{ position: fixed !important; top:100px !important; left:50%; margin-left: -140px  }
	.showScenic{ width: 100px; padding: 0; margin-left: 15px; height: 30px;line-height: 30px; background: #0099FF; outline: none; border: none; color: #FFF3F3; border-radius: 5px;}
	#name_list { margin-left: 5px;}
	.form_group .form_input,.form_group select{ box-sizing:content-box;}
	.pop_city_container .city_item_letter { line-height:32px;}
	.problem_title { line-height:40px;}
	.checkbox { position:relative;width:60px;margin-left:15px;}
	.checkbox label { position:absolute;left:0;top:4px;}
	.checkbox input[type="checkbox"] { vertical-align:middle;margin-left:0 !important;position:absolute !important;left:0;top:0;}
	.form-horizontal .form-group { margin:0 !important;}
	.bv-form .widget-body { padding-left:0px;}	
	.page-content { min-width: 840px !important;}

	    #myTab11 li{float:left; 
      margin-bottom: 0;
      border: 0 none;
      top: 2px;
       margin-bottom: -2px;
      display: block;
      position: relative;
	  background: #eaedf1;
      border-right: 1px solid #fff;
    } 
	#myTab11 li a { color:#777 !important;}
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
    /* 屏蔽设置价格*/
.cal-manager .add-package{display:none;}
.form-list{display:none;}
.del-package{display:none;}
.reserve_table td .lprice {
  color:#F40;
}
    </style>


<!-- /Head -->
<!-- Body -->

<link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/product.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jquery-1.11.1.min.js"></script>		

</head>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav tabs-flat">
					<li class="home" id="line_basc"><a href="#home11" data-toggle="tab">库存</a></li>	
	
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 基础信息 -->		
				   <input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
					<div class="tab-pane active" id="home11">	
						<div class="widget-body" style="padding: 0;">
							<div id="registration-form">
								<div id="day_price">
									<div style="margin-top: 10px;"> 	
									    <form action="/admin/b1/product/updateLinePrice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
											data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
											data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  id="linePriceForm" novalidate="novalidate">		 
										  <input name="linecode" type="hidden" id="linecode" value="<?php if(!empty($linecode)){ echo $linecode;}else{ echo 0;}?>" />

										</form>
										<!-- 日期价格 -->
									  	<div class="cal-manager" >					    	
									    </div>
									</div>
									
								</div>
							</div>
						</div>
						<div style="margin-top: 10px;">
							<button class="btn btn-palegreen" style="margin-left:350px;" id="saveNextPriceBtn">保存</button><i> </i>
						</div>
						
					</div>

					<div class="title_info_box" style="display:none;position:fixed;border:1px solid #f00;text-align:left;text-indent:30px;width:300px;padding:10px;background:#fff;z-index:999;color:#f00;font-size:14px;top:100px;right:20px;font-weight:600;">	
                       	
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
   <script src="<?php echo base_url('assets/js/admin/jquery.b2_date.js')?>"></script>       				
<script type="text/javascript">


(function(){

	window.priceDate = null;
	function initProductPrice(){
		var url = '<?php echo base_url()?>t33api/line/getProductPriceJSON';

		priceDate = new jQuery.calendarTable({  record:'', renderTo:".cal-manager",comparableField:"day",
		      url :url,
		      params : function(){ 
		        return jQuery.param( { "linecode":'<?php if(!empty($linecode)){ echo $linecode;}else{ echo 0;}?>'  ,"startDate":<?php echo date('Y-m-01', strtotime('0 month'));?>  } );
		      },
		      monthTabChange : function(obj,date){
		        jQuery('#selectMonth').val(date); 
		      },
			dayFormatter:function(settings,data){
				var dayid= '';
				var number= '';
				var adultprice= '';
				var childprice= '';
				var childnobedprice = '';
				var groupId='';
				var oldprice='';
			    var room_fee='';
			    var agent_rate_childno='';
			    var agent_room_fee='';
			    var agent_rate_int='';
			    var agent_rate_child='';
			    var time='';
			    var before_day='';
			    var hour='';
			    var minute='';
			    var date_flag=settings.disabled;
				if(data){
					dayid = data.dayid;
					childnobedprice = data.childnobedprice;
					
					adultprice=data.adultprice;
					childprice=data.childprice;
					number = data.number;
					oldprice = data.oldprice;
					room_fee=data.room_fee;
				    agent_rate_childno=data.agent_rate_childno;
				    agent_room_fee=data.agent_room_fee;
				    before_day=data.before_day;
				    hour=data.hour;
				    minute=data.minute;
				    agent_rate_int=data.agent_rate_int;
				    agent_rate_child=data.agent_rate_child;
				    var str0='<span style="color:#F40" >';
           			str1='<span>';
            		time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
            		var date="<?php echo date('Y-m-d',time());?>";
            		if(data.day>=date){
            			date_flag=false;
                	}
				}
			
			          var  flag=true;
			          var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
			          var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );

			          var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
			          html += flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+adultprice+"</span><span>元</span>")+'</p>':'';
			          html+= flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_int+"</span><span>元</span>")+'</p>':'';

			          html+= flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childprice+"</span><span>元</span>")+'</p>':'';
			          html+=flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'';

			          html+=  flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childnobedprice+"</span><span>元</span>")+'</p>':'';
			          html+=flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_childno+"</span><span>元</span>")+'</p>':'';
			          
			          html+=date_flag ? '<p class="singleRow" >'+(''==number?'':'<span class="lprice" >'+number+"</span><span>份</span>")+'</p>': '<p class="singleRow"><input type="hidden"  class="price"  value="'+adultprice+'"  size="10" name="adultprice"/><input type="text" '+(''==adultprice?'':'style="border-bottom: 1px solid #666!important;color:#F40"')+' class="price" value="'+number+'"  size="10" name="number"/>'+(''==adultprice?'':'<span>份</span>')+'</p>';

			          html+=flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span class="lprice" >'+room_fee+"</span><span>元<span>")+'</p>': '';
			          html+= flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_room_fee+"</span><span>元</span>")+'</p>':'';

			        //  html+=flag ? '<p class="singleRow" >'+(''==adultprice?'':time)+'</p>':'';
			          html+=date_flag ? '<p class="singleRow" >'+(''==time?'':'<span>'+time+"</span>")+'</p>':'<p class="singleRow"><input type="hidden"  class="price"  value="'+adultprice+'"  size="10" name="adultprice"/><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+'  style=""  class="shortInput price"  value="'+before_day+'"  size="4" name="before_day"/><span>天</span><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+'   class="shortInput price"  value="'+hour+'"  size="4" name="hour"/><span>时</span><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+'   class="shortInput price"  value="'+minute+'"  size="4" name="minute"/><span>分</span></p>';
			          return html;
			},dayFormatter1:function(settings,data){
				var dayid= '';
				var number= '';
				var adultprice= '';
				var childprice= '';
				var childnobedprice = '';
				var groupId='';
				var oldprice='';
			    var room_fee='';
			    var agent_rate_childno='';
			    var agent_room_fee='';
			    var agent_rate_int='';
			    var agent_rate_child='';
			    var time='';
			    var before_day='';
			    var hour='';
			    var minute='';
			    var date_flag=settings.disabled;
				if(data){
					dayid = data.dayid;
					childnobedprice = data.childnobedprice;
					
					adultprice=data.adultprice;
					childprice=data.childprice;
					number = data.number;
					oldprice = data.oldprice;
					room_fee=data.room_fee;
				    agent_rate_childno=data.agent_rate_childno;
				    agent_room_fee=data.agent_room_fee;
				    before_day=data.before_day;
				    hour=data.hour;
				    minute=data.minute;
				    agent_rate_int=data.agent_rate_int;
				    agent_rate_child=data.agent_rate_child;
				    var str0='<span style="color:#F40" >';
       				str1='<span>';
        			time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
        			var date="<?php echo date('Y-m-d',time());?>";
        			if(data.day>=date){
            			date_flag=false;
                	}
				}
			
			          var  flag=true;
			          var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
			          var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );

			          var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
			          html += flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+adultprice+"</span><span>元</span>")+'</p>':'';
			          html+= flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_int+"</span><span>元</span>")+'</p>':'';

			          html+= flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childprice+"</span><span>元</span>")+'</p>':'';
			          html+=flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'';

			          html+=  flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span class="lprice" >'+childnobedprice+"</span><span>元</span>")+'</p>':'';
			          html+=flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_rate_childno+"</span><span>元</span>")+'</p>':'';
			          
			          html+=date_flag ? '<p class="singleRow" >'+(''==number?'':'<span class="lprice" >'+number+"</span><span>份</span>")+'</p>': '<p class="singleRow"><input type="hidden"  class="price"  value="'+adultprice+'"  size="10" name="adultprice"/><input type="text" '+(''==adultprice?'':'style="border-bottom: 1px solid #666!important;color:#F40"')+' class="price" value="'+number+'"  size="10" name="number"/>'+(''==adultprice?'':'<span>份</span>')+'</p>';

			          html+=flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span class="lprice" >'+room_fee+"</span><span>元<span>")+'</p>': '';
			          html+= flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span class="lprice" >'+agent_room_fee+"</span><span>元</span>")+'</p>':'';

			        //  html+=flag ? '<p class="singleRow" >'+(''==adultprice?'':time)+'</p>':'';
			          html+=date_flag ? '<p class="singleRow" >'+(''==time?'':'<span>'+time+"</span>")+'</p>':'<p class="singleRow"><input type="hidden"  class="price"  value="'+adultprice+'"  size="10" name="adultprice"/><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+'  style=""  class="shortInput price"  value="'+before_day+'"  size="4" name="before_day"/><span>天</span><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+'   class="shortInput price"  value="'+hour+'"  size="4" name="hour"/><span>时</span><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+'   class="shortInput price"  value="'+minute+'"  size="4" name="minute"/><span>分</span></p>';
			          return html;
			}
			});
		
	}
	initProductPrice()

	
	//保存日期价格
	jQuery('#saveNextPriceBtn').click(function(){
			var formParam = jQuery('#linePriceForm').serialize();
			var price = JSON.stringify(priceDate.getValues());
		    jQuery.ajax({ type : "POST",async:false, data :formParam+"&prices="+price ,url : "<?php echo base_url()?>t33api/line/get_suit_stock", 
	             beforeSend:function() {//ajax请求开始时的操作
	                 $('#saveNextPriceBtn').addClass("disabled");
	             },
	             complete:function(){//ajax请求结束时操作
	                $('#saveNextPriceBtn').removeClass("disabled");
	             },
	 			success : function(result) {
	 				var result=eval("("+result+")");
	 				if(result.code==200){
	 					  alert( result.msg );
	 					  priceDate.loadData();
		 			}else{
		 				alert( result.msg );
			 		}
	
	 			}
			});
		    return false;
		});


})();
 </script>





