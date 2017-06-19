<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<link href="<?php echo base_url('assets/css/product.css')?>" rel="stylesheet" />
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="<?php echo site_url('admin/b1/home')?>">首页</a></li>
		<li >产品管理</li><li class="active">编辑产品</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<style type="text/css">

.tree-node-empty {
  height: 18px;
  width: 20px;
  float: left;
}

.shop_insert_label {
	width: 1%;
	margin-left: -5%;
}

.shop_insert_labels {
	margin-left: -4%;
}

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


.shop_insert_input {
	width: 60px;
}

.label-width {
	width: 120px;
}

.text-width {
	width: 600px;
}

.small-width {
	width: 110px;
}

.user_name_b1 {
	width: 100px;
}
.line-lable {
  color: #15b000;
  height: 26px;
  line-height: 26px;
  position: relative;
  background: #edf6fa;
  border: 1px solid #d7e4ea;
  padding: 6px 20px 6px 12px;
  margin-right: 2px;
    vertical-align: middle;
}
.line-lable a{
  display: block;
  width: 24px;
  height: 32px;
  position: absolute;
  top: 0;
  right: 0;
  cursor: pointer;
  text-align: center;
  font-size: 21px;
  font-weight: 700;
  color: #000;
  text-shadow: 0 1px 0 #fff;
  filter: alpha(opacity=20);
  opacity: .2;
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
/*批量价格弹框的样式*/
 .tbtsdgk{
position:fixed;background: none repeat scroll 0 0 #fff;top:15%;left:35%;z-index: 131;margin:auto;width:35%;
margin-right:20px;
}
.closetd{opacity: 0.2; padding:4px 0 0 6px;font-size: 20px; font-weight: 800;}

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
/* 屏蔽设置价格*/
.cal-manager .add-package{display:none;}
.form-list{display:none;}
.del-package{display:none;}
.reserve_table td .lprice {
  color:#F40;
}
</style>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">	
					<!-- <li class="active"><a href="#home11" data-toggle="tab"> 基础信息 </a></li>	 -->	
					<li class="active"><a href="#profile10" data-toggle="tab" id="set_price"> 设置价格 </a></li>
				</ul>
				<div class="tab-content tabs-flat" style="padding: 0px 12px">
					<!-- 设置价格 -->
					<input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
					<div class="tab-pane active" id="profile10">	
						<div class="widget-body" style="padding: 0;">
							<div id="registration-form">
								<div id="day_price">
									<div style="margin-top: 10px;"> 	
									    <form action="<?php echo base_url()?>admin/b1/product/updateLinePrice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
											data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
											data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  id="linePriceForm" novalidate="novalidate">		 
											<input name="lineId" type="hidden" id="lineId" value="<?php echo $data['id'];?>" />
											<div class="widget-body" style="padding: 0;">
													<div id="registration-form">
														<div id="day_price">
															<div style="margin-top: 10px;">
															  	<span style="color: red;height:30px;display:block;font-size:14px;">如需下架，请把库存改为0</span>
															  	
															</div>
															
														</div>
													</div>
										       </div>
										</form>
										     <div class="cal-manager" >
									
											 </div>
									</div>
									
								</div>
							</div>
						</div>
						<div style="margin-top: 30px;margin-left:20px;">
							<button class="btn btn-palegreen" id="savePriceBtn" type="button">保存</button>
						</div>
						
					</div>
		
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 批量价格录入的弹框 -->

<div style="display: none;" class="tbtsdgk">
	<div class="closetd">×</div>
	<form action="" class="form-horizontal"  role="form" id="applyMoney" method="post" onsubmit="return updataPrice(this);">
		<div align="center">
			<div class="widget-body">
				<div id="registration-form" class="messages_show" style="padding-top:25px;">
				 	<table class="table table-bordered table-hover money_table">
				  
						<tr class="account_money_width" >
								<td  style="vertical-align : middle;width:70px;">选择时间段：</td>
								<td  style="vertical-align : middle;padding-top:25px;">
									<div class="input-group" >
									<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
									</span>
									<input id="departure_date" class="form-control date-picker" type="text"  name="start_time">
									</div><i>&nbsp;&nbsp;</i>
								</td>
								<td  style="vertical-align : middle;padding-top:25px;">
									<div class="input-group">
									<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
									</span>
									<input id="departure_date" class="form-control date-picker" type="text"  name="end_time">
									</div><i>&nbsp;&nbsp;</i>
								</td>							
							</tr>
					     <tr><td colspan="3">价格的录入:提醒：成人、儿童必填一项。</td></tr>
					     <tr><td>空位</td>
						<td colspan="2">
						<input id="inputEmail" type="text" size=8 class="people"  name="people">人</td>
						</tr>
					     <tr><td>市场价</td>
						<td colspan="2">
						<input id="inputEmail" type="text" size=8 class="market_price"  name="market_price">元</td>
						</tr>
						<tr><td>成人价</td>
						<td colspan="2"><input id="inputEmail" type="text"  size=8 name="adult_price">元</td>
						</tr>
						<tr><td>儿童价</td>
						<td colspan="2"><input id="inputEmail" type="text" size=8  name="chil_price">元</td>
						</tr>
						<tr><td colspan="3"><input class="btn btn-palegreen"  style="float: right;margin-right:20px;" type="submit" value="确认"/ ></td></tr>
						</tbody>
					</table>	
				</div>
			</div>
		</div>
		</form >
	</div>
<div class="bgsd" style="display: none;"></div>

<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>


<script src="<?php echo base_url('assets/js/admin/jquery.b2_date.js')?>"></script>
<script type="text/javascript">
(function(){

	window.priceDate = null;
	function initProductPrice(){
		var url = '<?php echo base_url()?>admin/b1/product/getProductPriceJSON';

		priceDate = new jQuery.calendarTable({  record:'', renderTo:".cal-manager",comparableField:"day",
		      url :url,
		      params : function(){ 
		        return jQuery.param( { "lineId":jQuery('#lineId').val()  ,"suitId":jQuery('#suitId').val()  ,"startDate":jQuery('#selectMonth').val() } );
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

	
	jQuery('#savePriceBtn').click(function(){
		
		var a = true;
		$(".cell-price  input[name=adultprice]").each(function(index){
			var adultPrice= $(this).val(); 
 			var adultPrice1= $(this).attr('name'); 
			if(adultPrice1=='adultprice'){
			   if($(this).val()>0){
					var number =$(this).parent().parent().find("input[name='number']").val();
					var node =$(this).parent().parent().find("input[name='day']");
					var date=$(node).val() ;
				    var re=$(this).parents('.package-con').attr('id'); 
					for(var i=0;i<4;i++){ 
				    	 if(re==('tab_body'+i)){
						   	if(isNaN(number) && number!=''){
						   	   alert('第'+(i+1)+'个套餐的日期是'+date+'的空位必须是正整数');
								a = false;
							   	return false;	
							}
					     }
				    		
					 }
				}
			} 
		});	 
		if (a == false) {
			return false;
		}
		
			var formParam = jQuery('#linePriceForm').serialize();
			var price = JSON.stringify(priceDate.getValues());
		    jQuery.ajax({ type : "POST",data :formParam+"&prices="+price ,url : "<?php echo base_url()?>admin/b1/product/saveSuitPrice", 
					success : function(response) {
						var response = eval('(' + response + ')');
						if(response.status==1){
							alert(response.msg ); 
							 priceDate.loadData();
		   
						  }else{
							 alert(response.msg);
						  }
					}
			});
			
	});


})();


</script>


