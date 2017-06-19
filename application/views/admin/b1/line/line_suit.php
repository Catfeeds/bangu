  <input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
<div class="widget-body" style="padding: 0;">
	<div id="registration-form">
		<div id="day_price">
			<div style="margin-top: 10px;"> 	
			    <form action="<?php echo base_url()?>admin/b1/product/updateLinePrice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
					data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
					data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  id="linePriceForm" novalidate="novalidate">		 
				<input name="lineId" type="hidden" id="lineId" value="<?php echo $data['id'];?>" />

                 <div style="margin-top:10px;" >
                      <span style="padding-left: 65px;"><span style="color: red;">*</span>定金:</span>
                      <?php if($data['line_classify']!=1 && $data['producttype']==0){?>
                        <input style="padding-left: 5px;width:60px;" class="price_input" type="text" placeholder=""  <?php if(empty($line_aff['deposit']) || $line_aff['deposit']=='0.00'){ echo 'disabled="disabled"';} ?>  value="<?php if(!empty($line_aff)){ echo $line_aff['deposit'];}else{ echo 0;} ?>" name="deposit" id="deposit" />  
                      <?php }else{?>
                        <input style="padding-left: 5px;width:60px;" class="price_input" type="text" placeholder="" value="<?php if(!empty($line_aff)){ echo $line_aff['deposit'];}else{ echo 0;} ?>" name="deposit" id="deposit" />

                      <?php }  ?>
                      <span>元/人份</span>

                      <span><span style="color: red;padding-left:10px;">*</span>提前:</span>
                      <input style="padding-left: 5px;width:50px;display: inline-block;" type="text" value="<?php if(!empty($line_aff)){ echo $line_aff['before_day'];}else{ echo 0;} ?>" id="before_day" class="price_input" name="before_day"  />
                      <span>天交清团费</span>
                 </div>

			  	<!-- <div style="margin-top:10px;"><span style="padding-left: 41px;"><span style="color: red;">*</span>成人佣金:</span>
			  		<input style="padding-left: 5px;width:60px;display: inline-block;" type="text" value="<?php //echo $data['agent_rate_int'];?>" id="agent_rate" class="form-control text-width price_input" name="agent_rate"  />
			  		<span>元/人份</span>
			  				          <span style="padding-left: 15px;">小童佣金:</span>
			  		<input style="padding-left: 5px;width:60px;display: inline-block;" type="text" value="<?php //echo $data['agent_rate_child'];?>" id="agent_rate_child" class="form-control text-width price_input" name="agent_rate_child"  />
			  		<span>元/人份</span>
			  	</div> -->
			  	<!-- <div style="margin-top:15px;"><span style="color:red;">备注:</span></div>  -->
			    <div style="margin-top:10px;"> <span class="col_price">儿童占床说明 :</span>
			    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="50字内 " value="<?php if(!empty($data['child_description'])){ echo $data['child_description']; }?>" id="child_description" class="form-control text-width price_input col_wd" name="child_description"  />
			    </div>
			    
			    <div style="margin-top:10px;"> <span class="col_price">儿童不占床说明 :</span>
			     <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="50字内 " value="<?php if(!empty($data['child_nobed_description'])){ echo $data['child_nobed_description']; }?>" id="child_nobed_description"  class="form-control text-width price_input col_wd" name="child_nobed_description"  />
			     <span style="padding-left:10px;">提示：填写则在产品页面显示，不填则无显示</span>
			    </div>
			       
			    <div style="margin:10px 0px 10px 0px;display: none;" > <span class=" col_price">老人价说明 :</span>
			    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="50字内 " value="<?php if(!empty($data['old_description'])){ echo $data['old_description'];} ?>" id="old_description"  class="form-control text-width price_input col_wd" name="old_description"  /></div>
			    
			    <div style="margin-bottom:20px;margin-top:10px;"> <span class="col_price">特殊人群说明:</span>
			    <input type="text" placeholder="50字内 " value="<?php if(!empty($data['special_description'])){ echo $data['special_description'];} ?>" id="special_description" style="padding-left: 5px;display:inline-block;height:28px;" class="form-control text-width price_input col_wd" name="special_description"  /></div>
			     <div style="margin-bottom:20px;"><span style="color: red;">提前截止收客： 如：01月05日出团，填入出团前 3天18时30份 截止收客,表示01月02日 18时30分后 无法预订</span></div>
				</form>
			  	<div class="cal-manager" >					    	
			    </div>
			</div>
			
		</div>
	</div>
</div>
<div style="margin-top: 10px;">
	<button class="btn btn-palegreen" id="savePriceBtn" type="button">临时保存</button>
	<button class="btn btn-palegreen" style="margin-left:150px;" id="saveNextPriceBtn"><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
</div>
<!-- 批量价格录入的弹框 -->
<div style="display: none;" class="tbtsdgk">
	<div class="closetd">×</div>
	<form action="" class="form-horizontal"  role="form" id="applyPrice" method="post" >
		<div align="center">
			<div class="widget-body" style=" width: 600px; margin-top: 100px;">
				<div id="registration-form" class="messages_show" style="">
				 	<table class="table table-bordered table-hover money_table">	  
						<tr>
							<td class="order_info_title"><span style="color: red;">*</span>选择日期：</td>
							
							<td  style="vertical-align : middle;height: 90px;" colspan="3"> 
								<textarea style="min-height:80px; width:100%"  class="noresize" name="startDate" cols="" rows="" readonly="readonly" id="startDate" placeholder="请点击选择" 
									onclick="T2TCNCalendar.display(this, new Date(), AddDay('Y',1,new Date()), document.getElementById('xDate'),10,'checkboxNameX');" 
								    onpropertychange="this.style.height = this.scrollHeight + 'px';" oninput="this.style.height = this.scrollHeight + 'px';"></textarea>
									<input type="text" id="xDate" style="display:none">
							</td>
													
						</tr>
					   	<tr>
					    	<td class="order_info_title"><span style="color: red;">*</span>空位</td>
							<td colspan="3">
								<input name="line_id" value="<?php echo $data['id'];?>" id="line_id" type="hidden" />		
								<input name="suit_id" value="" id="suit_id" type="hidden" />
								<input name="suit_name" value="" id="suit_name" type="hidden" />
								<input name="suit_unit" value="" id="suit_unit" type="hidden" />
								<input name="typeid" value="" id="typeid" type="hidden" />
								<input id="inputEmail" type="text" size=8 class="people"  name="people">份
							</td>
						</tr>
						<tr>
							<td class="order_info_title"><span style="color: red;">*</span>成人价</td>
							<td><input id="inputEmail" type="text"  size=8 name="adult_price">元</td>
							<td class="order_info_title"><span style="color: red;">*</span>成人佣金</td>
							<td><input id="inputEmail " type="text"  size=8 name="agent_rate_int" class="agent_rate_int">元</td>
						</tr>
						<tr>
							<td class="order_info_title">儿童价</td>
							<td><input id="inputEmail" type="text" size=8  name="chil_price">元</td>
							<td class="order_info_title">儿童佣金</td>
							<td><input id="inputEmail" type="text" size=8  name="agent_rate_child" class="agent_rate_child">元</td>
						</tr>
						<tr>
							<td class="order_info_title">儿童价不占床</td>
							<td ><input id="inputEmail" type="text" size=8  name="chil_nobedprice">元</td>
							<td class="order_info_title">儿童不占佣金</td>
							<td><input id="inputEmail" type="text" size=8  name="agent_rate_childno" class="agent_rate_childno">元</td>
						</tr>
						<tr>
							<td class="order_info_title">单房价</td>
							<td><input id="inputEmail" type="text" size=8  name="room_fee"  class="room_fee">元</td>
							<td class="order_info_title">单房价佣金</td>
							<td><input id="inputEmail" type="text" size=8  name="agent_room_fee" class="agent_room_fee">元</td>
						</tr>
			
						<tr>
							<td class="order_info_title">提前</td>
							<td colspan="3">

								<input id="inputEmail" type="text" size=8  name="p_befor_day" value="<?php if(!empty($data["linebefore"])){ echo $data["linebefore"];} ?>">天
								<input id="inputEmail" type="text" size=8  name="p_hour" value="<?php if(!empty($line_aff["hour"])){ echo $line_aff["hour"];} ?>">时
								<input id="inputEmail" type="text" size=8  name="p_minute" value="<?php if(!empty($line_aff["minute"])){ echo $line_aff["minute"];} ?>">分
							</td>
						</tr>
						
					</table>	
                    <div class="clear" style="padding:15px 0 10px;">
                    <input class="btn btn-palegreen "  onclick="closePirce()" style="float: right;margin-right:180px;" type="button" value="关闭" />
                    <button class="btn btn-palegreen"  id="more_price" style="float: right;margin-right:110px;" type="button" onclick="return updataPrice(this);">确认</button></div>
				</div>
			</div>
		</div>
		</form >
	</div>

<!-- end -->
<script type="text/javascript">	
	
/*设置价格*/			             
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
					var before_day='<?php if(!empty($data["linebefore"])){ echo $data["linebefore"];} ?>';
					var hour='<?php if(!empty($line_aff["hour"])){ echo $line_aff["hour"];} ?>';
					var minute='<?php if(!empty($line_aff["minute"])){ echo $line_aff["minute"];} ?>';
					var agent_rate_int='';
					var agent_rate_child='';
					var date_flag='';
					date_flag=settings.disabled;
					var day=''; 
					if(data){
						day=data.day;
						dayid = data.dayid;
						childnobedprice = data.childnobedprice;
						adultprice=data.adultprice ;
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
						//console.log(data);
						var str0='<span style="color:#F40" >';
						str1='<span>';
						time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
						
					}
					var date='<?php echo date('Y-m-d',time()); ?>';
					if(settings.date>=date){
						date_flag=false;
						
					}
					//有价格,月份做一个提示
					 $('.headList').find('li').each(function(){
						    var val=$(this).children().text();
						    var dt=$(this).attr('data');

						    if(settings.date>=date){
						    	var arr=dt.split('-');
						    	var te=arr[0]+'-'+arr[1];

						        var ft=day.split('-');
						    	var ty=ft[0]+'-'+ft[1];

						    	if(te==ty){
						    		
						    		 $(this).find('a').html('<span class="circle">●</span>'+ft[1]+'月');
							    } 
						    }              
				     });
				   
					//console.log(data);
					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
					var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );

					var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
					html += date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span style="color:#F40">'+adultprice+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==adultprice?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+adultprice+'"  size="10" name="adultprice"/><span>元</span></p>';
					html+= date_flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span style="color:#F40">'+agent_rate_int+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==agent_rate_int?'placeholder="佣金" ':'style="color:#F40" ')+'class="price"  value="'+agent_rate_int+'"  size="10" name="agent_rate_int"/><span>元</span></p>';

					html+= date_flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span style="color:#F40" >'+childprice+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==childprice?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+childprice+'"  size="10" name="childprice"/><span>元</span></p>';
					html+=date_flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span style="color:#F40" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==agent_rate_child?'placeholder="佣金" ':'style="color:#F40" ')+' class="price" value="'+agent_rate_child+'"  size="10" name="agent_rate_child"/><span>元</span></p>';

					html+=  date_flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span style="color:#F40" >'+childnobedprice+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==childnobedprice?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+childnobedprice+'"  size="10" name="childnobedprice"/><span>元</span></p>';
					html+=date_flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span style="color:#F40" >'+agent_rate_childno+"<span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text"  '+(''==agent_rate_childno?'placeholder="佣金" ':'style="color:#F40" ')+' class="price"   value="'+agent_rate_childno+'"  size="10" name="agent_rate_childno"/><span>元</span></p>';
					
					html+=date_flag ? '<p class="singleRow" >'+(''==number?'':'<span style="color:#F40" >'+number+"</span><span>份</span>")+'</p>': '<p class="singleRow"><input type="text" class="price" value="'+number+'"  '+(''==number?'placeholder="余位" ':'style="color:#F40" ')+' size="10" name="number"/><span>份</span></p>';

					html+=date_flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span style="color:#F40" >'+room_fee+"<span><span>元</span>")+'</p>': '<p><span class="lab"></span><input type="text" '+(''==room_fee?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+room_fee+'"  size="10" name="room_fee"/><span>元</span></p>';
					html+=date_flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span style="color:#F40"  >'+agent_room_fee+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text"  '+(''==agent_room_fee?'placeholder="佣金" ':'style="color:#F40" ')+'  class="price"  value="'+agent_room_fee+'"  size="10" name="agent_room_fee"/><span>元</span></p>';

					html+=date_flag ? '<p class="singleRow" >'+(''==adultprice?'':'<span>'+time+"</span>")+'</p>':'<p class="singleRow"><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+' class="shortInput price"  value="'+before_day+'"  size="4" name="before_day"/><span>天</span><input type="text"  '+(''==adultprice?'':'style="color:#F40" ')+'  class="shortInput price"  value="'+hour+'"  size="4" name="hour"/><span>时</span><input type="text"  '+(''==adultprice?'':'style="color:#F40" ')+'   class="shortInput price"  value="'+minute+'"  size="4" name="minute"/><span>分</span></p>';

		        	return html;
				},dayFormatter1:function(settings,data){
					var day=''; 
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
					var before_day='<?php if(!empty($data["linebefore"])){ echo $data["linebefore"];} ?>';
					var hour='<?php if(!empty($line_aff["hour"])){ echo $line_aff["hour"];} ?>';
					var minute='<?php if(!empty($line_aff["minute"])){ echo $line_aff["minute"];} ?>';
					var agent_rate_int='';
					var agent_rate_child='';
					date_flag=settings.disabled; 
					if(data){
						day=data.day;
						dayid = data.dayid;
						childnobedprice = data.childnobedprice;
						adultprice=data.adultprice ;
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
						//console.log(data);
						var str0='<span style="color:#F40" >';
						str1='<span>';
					    time=str0+before_day+str1+'<span>天</span>'+str0+hour+str1+'<span>时</span>'+str0+minute+str1+'<span>分</span>';
					}
					//有价格,月份做一个提示
					 $('.headList').find('li').each(function(){
						    var val=$(this).children().text();
						    var dt=$(this).attr('data');

						    if(settings.date>=date){
						    	var arr=dt.split('-');
						    	var te=arr[0]+'-'+arr[1];

						        var ft=day.split('-');
						    	var ty=ft[0]+'-'+ft[1];

						    	if(te==ty){
						    		 $(this).find('a').html('<span class="circle">●</span>'+ft[1]+'月');
							    } 
						    }           
				     });
					var date='<?php echo date('Y-m-d',time()); ?>';
					if(settings.date>=date){
					
						date_flag=false;	
					}
		
					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
					var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );

					var html='<input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input  value="'+dayid+'" type="hidden" name="dayid">';
					html += date_flag ? '<p>'+(''==adultprice?'':'<span style="float: left;">售价：</span><span style="color:#F40">'+adultprice+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==adultprice?'placeholder="售价" ':'style="color:#F40" ')+'class="price"  value="'+adultprice+'"  size="10" name="adultprice"/><span>元</span></p>';
					html+= date_flag ? '<p>'+(''==agent_rate_int?'':'<span style="float: left;">佣金：</span><span style="color:#F40">'+agent_rate_int+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==agent_rate_int?'placeholder="佣金" ':'style="color:#F40" ')+'class="price"  value="'+agent_rate_int+'"  size="10" name="agent_rate_int"/><span>元</span></p>';

					html+= date_flag ? '<p>'+(''==childprice?'':'<span style="float: left;">售价：</span><span style="color:#F40" >'+childprice+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==childprice?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+childprice+'"  size="10" name="childprice"/><span>元</span></p>';
					html+=date_flag ? ' <p>'+(''==agent_rate_child?'':'<span style="float: left;">佣金：</span><span style="color:#F40" >'+agent_rate_child+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==agent_rate_child?'placeholder="佣金" ':'style="color:#F40" ')+' class="price" value="'+agent_rate_child+'"  size="10" name="agent_rate_child"/><span>元</span></p>';

					html+=  date_flag ? '<p>'+(''==childnobedprice?'':'<span style="float: left;">售价：</span><span style="color:#F40" >'+childnobedprice+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text" '+(''==childnobedprice?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+childnobedprice+'"  size="10" name="childnobedprice"/><span>元</span></p>';
					html+=date_flag ? '<p>'+(''==agent_rate_childno?'':'<span style="float: left;">佣金：</span><span style="color:#F40" >'+agent_rate_childno+"<span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text"  '+(''==agent_rate_childno?'placeholder="佣金" ':'style="color:#F40" ')+' class="price"   value="'+agent_rate_childno+'"  size="10" name="agent_rate_childno"/><span>元</span></p>';
					
					html+=date_flag ? '<p class="singleRow" >'+(''==number?'':'<span style="color:#F40" >'+number+"</span><span>份</span>")+'</p>': '<p class="singleRow"><input type="text" class="price" value="'+number+'"  '+(''==number?'placeholder="余位" ':'style="color:#F40" ')+' size="10" name="number"/><span>份</span></p>';

					html+=date_flag ? '<p>'+(''==room_fee?'':'<span style="float: left;">售价：</span><span style="color:#F40" >'+room_fee+"<span><span>元</span>")+'</p>': '<p><span class="lab"></span><input type="text" '+(''==room_fee?'placeholder="售价" ':'style="color:#F40" ')+' class="price"  value="'+room_fee+'"  size="10" name="room_fee"/><span>元</span></p>';
					html+=date_flag ? '<p>'+(''==agent_room_fee?'':'<span style="float: left;">佣金：</span><span style="color:#F40"  >'+agent_room_fee+"</span><span>元</span>")+'</p>':'<p><span class="lab"></span><input type="text"  '+(''==agent_room_fee?'placeholder="佣金" ':'style="color:#F40" ')+'  class="price"  value="'+agent_room_fee+'"  size="10" name="agent_room_fee"/><span>元</span></p>';

					html+=date_flag ? '<p class="singleRow" >'+(''==adultprice?'':'<span>'+time+"</span>")+'</p>':'<p class="singleRow"><input type="text" '+(''==adultprice?'':'style="color:#F40" ')+' class="shortInput price"  value="'+before_day+'"  size="4" name="before_day"/><span>天</span><input type="text"  '+(''==adultprice?'':'style="color:#F40" ')+'  class="shortInput price"  value="'+hour+'"  size="4" name="hour"/><span>时</span><input type="text"  '+(''==adultprice?'':'style="color:#F40" ')+'   class="shortInput price"  value="'+minute+'"  size="4" name="minute"/><span>分</span></p>';

		            return html;
				}
			});


	}

	initProductPrice()

	function isIntGreatZero(val){ //大于等于0的整数
		var intPattern = /^[0-9]+$/g ;
        return   !(    val   && val!=''  &&  !intPattern.test(val)   ); 
	}
  //保存日期价格
   jQuery('#savePriceBtn,#saveNextPriceBtn').click(function(){

	   var deposit=$('input[name="deposit"]').val();
       if(deposit==''){
                alert('定金不能为空');
                $('#deposit').focus();
                return false;
       }
       var before_day=$('input[name="before_day"]').val();
       if(before_day==''){
                alert('提前几天交团款为空');
                $('#before_day').focus();
                return false;
       }
       var index=$(this).index();
/*             var agent_rate = $('#agent_rate').val();
	if(''==agent_rate){
		alert("管家佣金填写不能为空");
		$('#agent_rate').focus();
		return false;
	}else{
		if(isNaN(agent_rate) || agent_rate<0){
			alert("管家佣金填写价格必须大于0");
			return false;
		}
	}*/  

	//不能超过15个字	
	var child_description = $('#child_description').val();
	if(child_description!=''){
		 var str=child_description;
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var c = 0; c < len; c++) {
		 charCode = str.charCodeAt(c);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 } 
	    	 if(realLength>50){
		    	alert('儿童占床说明已经超过50个字');
		     	return false;
		 } 
	 }
	var child_nobed_description = $('#child_nobed_description').val();
	if(child_nobed_description!=''){
		 var str=child_nobed_description;
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var c = 0; c < len; c++) {
		 charCode = str.charCodeAt(c);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 } 
	     	if(realLength>50){
		     	alert('儿童不占床说明已经超过50个字');
		    	return false;
		} 
	 }
	var old_description = $('#old_description').val();
	if(old_description!=''){
		 var str=old_description;
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var c = 0; c < len; c++) {
		 charCode = str.charCodeAt(c);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 } 
	     	if(realLength>50){
		     	alert('老人价说明已经超过50个字');
		     	return false;
		} 
	 }
	var special_description = $('#special_description').val();
	if(special_description!=''){
		 var str=special_description;
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var c = 0; c < len; c++) {
		 charCode = str.charCodeAt(c);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 } 
	     	if(realLength>50){
		     	alert('特殊人群说明已经超过50个字');
		     	return false;
		} 
	 }	 
		var a = true;
		$(".cell-price  input[class=price]").each(function(index){
			var adultPrice= $(this).val(); 
		/*	if(!isIntGreatZero(adultPrice)){
				 alert("价格只能是大于等于0的整数价格,您输入的 "+adultPrice+" 有误");
				//找到月份，月份的tab点击一下。
				var node =$(this).parent().parent().find("input[name='day']");
				var date=$(node).val() ;
				date=date.substr(0,8)+"01";		
				$("li[data="+date+"]").click();
				 
		    	 	$(this).focus();
		    		a = false;
		    		return false;
			}  */
 			var adultPrice1= $(this).attr('name'); 
			if(adultPrice1=='adultprice'){
				if($(this).val()=='0'){	   //成人价不能为零
					//找到月份，月份的tab点击一下。
					var node =$(this).parent().parent().find("input[name='day']");
					var date=$(node).val() ;
				    	var re=$(this).parents('.package-con').attr('id'); 
					for(var i=0;i<4;i++){ 
				    	 	if(re==('tab_body'+i)){
					    	 	alert('第'+(i+1)+'个套餐的日期是'+date+'的成年价不能为0');
					    	}
					 }
					date=date.substr(0,8)+"01";		
					$("li[data="+date+"]").click();
			    		$(this).focus();
			    	 	a = false;
                     
			    	 	return false;
				}else if($(this).val()>0){
					var number =$(this).parent().parent().find("input[name='number']").val();
					if(number=='0' || number==''|| number<0){ //空位不能为空
						var node =$(this).parent().parent().find("input[name='day']");
						var date=$(node).val() ;
					   	var re=$(this).parents('.package-con').attr('id'); 
						for(var i=0;i<4;i++){ 
					    		 if(re==('tab_body'+i)){
						    	 	alert('第'+(i+1)+'个套餐的日期是'+date+'的空位大于等于0的正整数');
						    	 }
						 }
					//	alert(date+'的空位大于等于0的正整数');	
						date=date.substr(0,8)+"01";	
						$("li[data="+date+"]").click();		
						$(this).parent().parent().find("input[name='number']").focus();
						a = false;
					   	return false;
					}
				}
			} 
		});	 
		if (a == false) {
			return false;
		}
		
		var formParam = jQuery('#linePriceForm').serialize();
		var price = JSON.stringify(priceDate.getValues());
	    jQuery.ajax({ type : "POST",async:false, data :formParam+"&prices="+price ,url : "<?php echo base_url()?>admin/b1/product/saveSuit", 
                beforeSend:function() {//ajax请求开始时的操作
                    $('#saveNextPriceBtn,#savePriceBtn').addClass("disabled");
                },
                complete:function(){//ajax请求结束时操作
                    $('#saveNextPriceBtn,#savePriceBtn').removeClass("disabled");
                },
    			success : function(response) {
    				var response = eval('(' + response + ')');
    				if(response.status==1){
    					alert( '保存报价成功！' ); 
    					jQuery('.selected').attr("packageId",response.suitId);
    					jQuery('.selected').attr("suitId",response.suitId);
    				   	jQuery( 'input[name="suitId"]').val(response.suitId);
    				   	if(index==1){     //下一步
    				   		show_line_fee(<?php  if(!empty($data['id'])){echo $data['id']; }?>);	
    						$("#set_price").removeClass('active');
    						$("#profile10").removeClass('active');
    						$("#click_feedesc").css('display','block');
    						$("#click_feedesc").addClass('active');
    						$("#profile14").addClass('active');  
    					}
    				    priceDate.loadData();
    				}else{
    					alert( response.msg );
    				}
    			}
		});
	    return false;
	});	
})();

/*设置价格 end*/

function closePirce(){
	$('.closetd').click();
}
//价格录入的弹框
function onPrice(obj,type){
	var suitId='';
	suitId=$(obj).parents('li').find('input[name="suitId"]').val(); 
	var typeid=1;
	if(type==1){ //普通价格
 	    var suitName=$(obj).parents('.form-list').find('input[name="suitName"]').val(); 	   
		if(suitName==''){
		        alert('请填写套餐名');
		        return false;
		}
		var typeid=1;
	}else if(type==0){ //标准价格
		var typeid=-1; 
	}

 	$(".bgsd,.tbtsdgk").show();
  	var lineId=jQuery('#lineId').val();  
   	var unit=jQuery('#unit').val();
  	$("input[name='suit_id']").val(suitId);
   	$("input[name='suit_name']").val(suitName);
  	$("input[name='suit_unit']").val(unit);
   	$("input[name='typeid']").val(typeid);
    jQuery("#startDate").val('');
    jQuery("input[name='people']").val(''); 
    jQuery("input[name='adult_price']").val(''); 
	jQuery("input[name='chil_price']").val('');
	jQuery("input[name='chil_nobedprice']").val('');
	jQuery(".room_fee").val('');  
	jQuery(".agent_room_fee").val('');  
	jQuery(".agent_rate_childno").val('');  	
	jQuery(".agent_rate_child").val('');  
	jQuery(".agent_rate_int").val('');  	
	$(".closetd").click(function(e) {
	       $(".bgsd,.tbtsdgk").hide();
	}); 
}

 //录入批量价格
function updataPrice(obj){ 
    	var people= $('#applyPrice').find('input[name="people"]').val(); // 市场价
    	var adult_price= $('#applyPrice').find('input[name="adult_price"]').val();//成人价 
    	var chil_price= $('#applyPrice').find('input[name="chil_price"]').val();//儿童价
    	var chil_nobedprice= $('#applyPrice').find('input[name="chil_nobedprice"]').val();
    	var old_price= $('#applyPrice').find('input[name="old_price"]').val();
    	var p_befor_day= $('#applyPrice').find('input[name="p_befor_day"]').val();
    	var p_hour= $('#applyPrice').find('input[name="p_hour"]').val();
    	var p_minute= $('#applyPrice').find('input[name="p_minute"]').val();
    	var deposit=$('input[name="deposit"]').val();
    	
/*	
	var people= obj.people.value;
	var adult_price= obj.adult_price.value;  
	var chil_price= obj.chil_price.value;	
	var chil_nobedprice= obj.chil_nobedprice.value;
	var old_price= obj.old_price.value;*/
       var startDate=$("#startDate").val();
        if(people==''){
    	    alert("空位填写不能为空!");
    		return false; 
        }else if(isNaN(people)){
    	    alert("空位写不合理!");
    	    return false;  
        }else if(!(/^[0-9]+$/g.test(people))){
    	    alert("空位只能是正整数!");
    	    return false; 
        }

        if(adult_price==''){
    	    alert("成人价 填写不能为空!");
    		return false; 
    	}else if(isNaN(adult_price)){ 
    	    alert("成人价 填写不合理");
    		return false; 
    	}else if(adult_price<=0){
    	    alert("成人价只能是大于0的整数");
    		return false;
    	}else if(!(/^[0-9]+$/g.test(adult_price))){
    	      alert('成人价只能是正整数');
    	      return false;
    	}
    	if(chil_price!=''){
	          if(!(/^[0-9]+$/g.test(chil_price))){
	        	    alert('儿童价只能是正整数');
	              	return false;
	           }   
    	} 
    	if(chil_nobedprice!=''){
	         if(!(/^[0-9]+$/g.test(chil_nobedprice))){
        	        alert('儿童价不占床只能是正整数');
	              	return false;
	          }   
        } 

        if(isNaN(p_befor_day)){
             alert('提前报名填写格式不对');
             return false;
        }
        if (isNaN(p_hour)) {
             alert('提前报名填写格式不对');
             return false;
        }else if(p_hour>24){
             alert('提前报名几时截止报名已超过24小时');
             return false;
        }
        if(isNaN(p_minute)){
             alert('提前报名填写格式不对');
             return false;
        }else if(p_minute>60){
              alert('提前报名几分截止报名已超过60分钟');
              return false;
        }

        var typeid=$("input[name='typeid']").val(); 
    	var suitName=$("input[name='suitName']").val();
   	    if(typeid!=-1){
	    	if(suitName==''){
	    	        alert('套餐名称不能为空!');
	    	        return false;
	    	}
    	 }
	
	  //提价日期价格    
	   jQuery.ajax({ type : "POST",data : jQuery('#applyPrice').serialize()+"&deposit="+deposit,url : "<?php echo base_url()?>admin/b1/product/updataSuitPrice", 
		 beforeSend:function() {//ajax请求开始时的操作
	           $('#more_price').addClass("disabled");
	           $('#saveNextPriceBtn,#savePriceBtn').addClass("disabled");
	     },
	     complete:function(){//ajax请求结束时操作
	           $('#more_price').removeClass("disabled");
	           $('#saveNextPriceBtn,#savePriceBtn').removeClass("disabled");
	     },

		success : function(response) {
 			 var response=eval("("+response+")");
			 if(response.status==1){  
				priceDate.loadData();
				$('.closetd').click();
			 }else{
			 	alert(response.msg);
			 	priceDate.loadData();
			 }	
		}
	  });
	// priceDate.loadData();
	
	 
	return false;
}


//清空价格
 function clearPrice(obj){
 	
	 suitId=jQuery(obj).parents('li').find('input[name="suitId"]').val(); 
	 if (!confirm("确定要清空该套餐的价格?")) {
        		 window.event.returnValue = false;
    	 }else{
		jQuery.ajax({ type : "POST",data :"id="+suitId,url : "<?php echo base_url()?>admin/b1/product/deleteSuitprice",
			success : function(data) {
				 var data=eval("("+data+")");
				 if(data.status==1){  
					 alert(data.msg);
					 priceDate.loadData();
				 }else if(data.status==-1){
					 alert(data.msg);
					 priceDate.loadData();
				 }
			}
		});
   	 }
} 


</script>