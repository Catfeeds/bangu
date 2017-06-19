<style type="text/css">
	.title_div img{padding: 5px;}
</style>
<?php
		if(isset($changeRout)&&!empty($changeRout)){   //之前修改天数后的天数
			$a=$changeRout; 
			if($data['lineday']>0){
				$num = $data ['lineday'];
				for($i = $a; $i < $num; ++ $i) {
?>

<div class="line_rout_comment<?php echo $i;?>" >
<input name="lineday" id="lineday" value="<?php if(!empty($data ['lineday'])){ echo $data ['lineday'];}?>" type="hidden" />
<div class="lineDayDiv">

	<div class="form-group">
	<label class="col-sm-2 control-label no-padding-right label-width col_lb"
		for="inputEmail3" style="font-size:14px;"><span style="color: red;">*</span>第<?php echo $i+1; ?>天</label>
	<div class="col-sm-10 col_ts"  style=" width:auto;min-width:43%;position:relative;">
	<input name="daynum" value="<?php echo $num; ?>" id="daynum" type="hidden" />
		<div name="title" class="title_div text-width" contenteditable="true" style=" width: 612px;" ><?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?> </div>
		<div class="clear" id="tips" onclick="chk(this)" style="position:absolute; left:27px;top:8px;color:#888;min-width:500px">
		<div name="tips" >出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div></div>
		<input type="hidden" style="width: 650px;" id="username<?php echo $i; ?>" class="form-control text-width" name="title[<?php echo $i;?>]" value='<?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?>' />
	</div>
	</div> 

	<input name="id" value="<?php if(!empty($data['id'])){ echo $data['id'];}?>" id="id" type="hidden" />
	<input name="routid[<?php echo $i;?>]" value="<?php if(isset($rout)&&!empty($rout[$i]['id'])){ echo $rout[$i]['id'];}?>" id="id" type="hidden" /> 
	<input name="day[<?php echo $i;?>]"	value="<?php echo $i+1; ?>" id="id" type="hidden" />

	<div class="form-group">
		<!-- 往返交通 -->
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3"><span style="color: red;"></span>城市间交通</label>
		<div class="form-inline col_ts">
                                         <div class="col-sm-10 col_ts">
                                            <input type="text"  style="width: 612px;" 
                                                value="<?php if(isset($rout[$i])){ if(!empty($rout[$i]['transport'])){echo $rout[$i]['transport'];}else{ echo '无'; }} ?>"
                                                class="form-control text-width" name="transport[<?php echo $i;?>]"
                                                placeholder="100字以内,可不输，即为不显示" />
                                         </div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">用餐</label>
		<div class="form-inline ">

			<div class="checkbox  col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;">
				<input type="checkbox" name="breakfirsthas[<?php echo $i;?>]"
					value="1"
					<?php if(!empty($rout[$i])){ if($rout[$i]['breakfirsthas']==1){ echo 'checked="checked"';}} ?> />早餐
					</label>
			</div>
			<div class="col_ts" style="margin: 0px;">
				<input type="text" placeholder="15字以内"
					class="form-control small-width" style="width: 132px;"
					name="breakfirst[<?php echo $i;?>]"
					value="<?php if(!empty($rout[$i])){ echo $rout[$i]['breakfirst'];} ?>">
			</div>

			<div class="checkbox col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;">	
			    	 <input type="checkbox" name="lunchhas[<?php echo $i;?>]"
					value="1" 
					<?php if(!empty($rout[$i])){ if($rout[$i]['lunchhas']==1){ echo 'checked="checked"';}} ?> />
					午餐
				</label>
			</div>
			<div class="col_ts" style="margin: 0px;">
				<input type="text" placeholder="15字以内" name="lunch[<?php echo $i;?>]"
					class="form-control user_name_b1" style="width: 132px;"
					value="<?php if(!empty($rout[$i])){ echo $rout[$i]['lunch'];} ?>">
			</div>

			<div class="checkbox col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;"> 
				<input type="checkbox" name="supperhas[<?php echo $i;?>]" value="1"
					<?php if(!empty($rout[$i])){ if($rout[$i]['supperhas']==1){ echo 'checked="checked"';}} ?> />
					晚餐
				</label>
			</div>
			<div class="" style="margin: 0px;">
				<input type="text" placeholder="15字以内" name="supper[<?php echo $i;?>]"
					class="form-control user_name_b1" style="width: 132px;"
					value="<?php if(!empty($rout[$i])){ echo $rout[$i]['supper'];} ?>">
			</div>

		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">住宿</label>
			<div class="form-inline col_ts">
                                            <div class="col-sm-10 col_ts">
                                            <input type="text"  style="width: 613px;" id="hotel<?php echo $i;?>"
                                                value="<?php if(!empty($rout[$i])){ echo $rout[$i]['hotel'];} ?>"
                                                class="form-control text-width" name="hotel[<?php echo $i;?>]"
                                                placeholder="酒店名称,200字以内(包含字符)" />
                                            </div>
		   </div>
	</div>	

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3"><span style="color: red;">*</span>行程</label>
		<div class="col-sm-10 col_ts" style="width:84%">
		<textarea id="editor_id<?php echo $i; ?>"  name="jieshao[<?php echo $i; ?>]" style="width:612px; height:180px; padding:2px 0px 0px 5px;"><?php if(!empty($rout[$i])){ echo $rout[$i]['jieshao'];} ?></textarea>	
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">行程图片</label>
			<div class="col-sm-10 col_ts" style="width: 730px;">
			    <div class="div_url_val" style="width: 728px;float:left;max-height:400px;">
			    <!--每个地方都必须要有,不然就没办法保存数据-->
					  <ul class="url_val">
					  <?php  if(!empty($rout[$i]['pic'])){ 
					      $img_str=explode(';', $rout[$i]['pic']);
					      if(!empty($img_str)){
					       foreach ($img_str as $k=>$vl){ 
							if(!empty($vl)){	?> 
					      	    <li class="url_li" style="float:left;list-style:none;margin:0 20px 0px 0px">
									<div class="img_main">
										<div id="del_img" class="float_div" onclick="del_imgdata(this,-1);" style="height:20px;width:12px; font-size:24px;cursor:pointer;">×</div>
											<img style="width:215px;" src="<?php  echo $vl; ?>" file="" received="">
										</div>
								</li>
					      	 
					  <?php }	} }  }?>
					  </ul>	 
					  <input type="hidden" name="line_pic_arr[<?php echo $i; ?>]" class="line_pic_val" value="<?php if(!empty($rout[$i]['pic'])){ echo $rout[$i]['pic'];} ?>">  		 
            	 </div>
            	 <div style="width:105px;float:left;"><span onclick="change_avatar(this,1);" class="choice_img">选择图片</span></div>
                 <span onclick="choice_picture(this,<?php echo $i+2; ?>)" class="choice_picture" >从相册选择</span> 
                 <span style="margin-left:20px;position:relative;" >最多上传3张图片,图片格式gif,jpg,png,jpeg</span> 

		</div>
	</div>
</div>
</div>
<?php } } }elseif(isset($linetype) && !empty($linetype)){ //遍历行程  ?>  
	
	<?php
if(!empty($data['lineday'])){
if($data['lineday']>0){
	$num = $data ['lineday'];
	for($i = 0; $i < $num; ++ $i) {
		?>
<div class="line_rout_comment<?php echo $i;?>" >
<input name="lineday" id="lineday" value="<?php if(!empty($data ['lineday'])){ echo $data ['lineday'];}?>" type="hidden" />
<div class="lineDayDiv">
	<div class="form-group">
	<label class="col-sm-2 control-label no-padding-right label-width col_lb"
		for="inputEmail3" style="font-size:14px;"><span style="color: red;">*</span>第<?php echo $i+1; ?>天</label>
	<div class="col-sm-10 col_ts"  style=" width:auto;min-width:43%;position:relative;">
	<input name="daynum" value="<?php echo $num; ?>" id="daynum" type="hidden" />
		<div name="title" class="title_div text-width" contenteditable="true" style=" width: 612px;" ><?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?> </div>
		<div class="clear" id="tips" onclick="chk(this)" style="position:absolute; left:27px;top:8px;color:#888;min-width:500px">
		<div name="tips" >出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div></div>
		<input type="hidden" style="width: 650px;" id="username<?php echo $i; ?>" class="form-control text-width" name="title[<?php echo $i;?>]" value='<?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?>' />
	</div>
	</div> 

	<input name="id" value="<?php if(!empty($data['id'])){ echo $data['id'];}?>" id="id" type="hidden" />
	<input name="routid[<?php echo $i;?>]" value="<?php if(isset($rout)&&!empty($rout[$i]['id'])){ echo $rout[$i]['id'];}?>" id="id" type="hidden" /> 
	<input name="day[<?php echo $i;?>]"	value="<?php echo $i+1; ?>" id="id" type="hidden" />
	
	<div class="form-group">
		<!-- 往返交通 -->
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3"><span style="color: red;"></span>城市间交通</label>
		<div class="form-inline col_ts">
                                         <div class="col-sm-10 col_ts">
                                            <input type="text"  style="width: 612px;" 
                                                value="<?php if(isset($rout[$i])){ if(!empty($rout[$i]['transport'])){echo $rout[$i]['transport'];}else{ echo '无'; }} ?>"
                                                class="form-control text-width" name="transport[<?php echo $i;?>]"
                                                placeholder="100字以内,可不输，即为不显示" />
                                         </div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">用餐</label>
		<div class="form-inline ">

			<div class="checkbox  col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;">
				<input type="checkbox" name="breakfirsthas[<?php echo $i;?>]"
					value="1"
					<?php if(!empty($rout[$i])){ if($rout[$i]['breakfirsthas']==1){ echo 'checked="checked"';}} ?> />早餐
					</label>
			</div>
			<div class="col_ts" style="margin: 0px;">
				<input type="text" placeholder="15字以内"
					class="form-control small-width" style="width: 132px;"
					name="breakfirst[<?php echo $i;?>]"
					value="<?php if(!empty($rout[$i])){ echo $rout[$i]['breakfirst'];} ?>">
			</div>

			<div class="checkbox col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;">	
			    	 <input type="checkbox" name="lunchhas[<?php echo $i;?>]"
					value="1"
					<?php if(!empty($rout[$i])){ if($rout[$i]['lunchhas']==1){ echo 'checked="checked"';}} ?> />
					午餐
				</label>
			</div>
			<div class="col_ts" style="margin: 0px;">
				<input type="text" placeholder="15字以内" name="lunch[<?php echo $i;?>]"
					class="form-control user_name_b1" style="width: 132px;"
					value="<?php if(!empty($rout[$i])){ echo $rout[$i]['lunch'];} ?>">
			</div>

			<div class="checkbox col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;"> 
				<input type="checkbox" name="supperhas[<?php echo $i;?>]" value="1"
					<?php if(!empty($rout[$i])){ if($rout[$i]['supperhas']==1){ echo 'checked="checked"';}} ?> />
					晚餐
				</label>
			</div>
			<div class="" style="margin: 0px;">
				<input type="text" placeholder="15字以内" name="supper[<?php echo $i;?>]"
					class="form-control user_name_b1" style="width: 132px;"
					value="<?php if(!empty($rout[$i])){ echo $rout[$i]['supper'];} ?>">
			</div>

		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">住宿</label>
			<div class="form-inline col_ts">
                                            <div class="col-sm-10 col_ts">
                                            <input type="text"  style="width: 613px;" id="hotel<?php echo $i;?>"
						value="<?php if(isset($rout[$i])){ if(!empty($rout[$i]['hotel'])){echo $rout[$i]['hotel'];}else{ echo '无'; }} ?>"
						class="form-control text-width" name="hotel[<?php echo $i;?>]"
						placeholder="酒店名称,200字以内(包含字符)" />
                                            </div>
		   </div>
	</div>	

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3"><span style="color: red;">*</span>行程</label>
		<div class="col-sm-10 col_ts" style="width:84%">
		<textarea id="editor_id<?php echo $i; ?>"  name="jieshao[<?php echo $i; ?>]" style="width:612px; height:180px; padding:2px 0px 0px 5px;"><?php if(!empty($rout[$i])){ echo $rout[$i]['jieshao'];} ?></textarea>	
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">行程图片</label>
			<div class="col-sm-10 col_ts" style="width: 730px;">
			    <div class="div_url_val" style="width: 728px;float:left;max-height:400px;">
			    <!--每个地方都必须要有,不然就没办法保存数据-->
					  <ul class="url_val">
					  <?php  if(!empty($rout[$i]['pic'])){ 
					      $img_str=explode(';', $rout[$i]['pic']);
					      if(!empty($img_str)){
					       foreach ($img_str as $k=>$vl){ 
							if(!empty($vl)){	?> 
					      	    <li class="url_li" style="float:left;list-style:none;margin:0 20px 0px 0px">
									<div class="img_main">
										<div id="del_img" class="float_div" onclick="del_imgdata(this,-1);" style="height:20px;width:12px; font-size:24px;cursor:pointer;">×</div>
											<img style="width:215px;" src="<?php  echo $vl; ?>" file="" received="">
										</div>
								</li>
					      	 
					  <?php }	} }  }?>
					  </ul>	 
					  <input type="hidden" name="line_pic_arr[<?php echo $i; ?>]" class="line_pic_val" value="<?php if(!empty($rout[$i]['pic'])){ echo $rout[$i]['pic'];} ?>">  		 
            	 </div>
            	 <div style="width:105px;float:left;"><span onclick="change_avatar(this,1);" class="choice_img">选择图片</span></div>
                 <span onclick="choice_picture(this,<?php echo $i+2; ?>)" class="choice_picture" >从相册选择</span> 
                 <span style="margin-left:20px;position:relative;" >最多上传3张图片,图片格式gif,jpg,png,jpeg</span> 

		</div>
	</div>
</div>
	
</div>
	<?php  } ?>
<!-- 	<div class="form-group" id="line_beizhu">
	<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">温馨提示</label>
		<div class="form-inline col_ts">
			<div class="form-group col_ts" style="margin: 0px;">
			     	<div class="col-sm-10 col_ts">
					<input type="text"  style="width: 700px;" id="line_beizhu"
						value="<?php //if(!empty($data['line_beizhu'])){ echo $data['line_beizhu'];}else{ echo '因往返抵离时间及景区人流调节缘故，导游领队有权调整游览时间顺序';} ?>"
						class="form-control text-width" name="line_beizhu"
						placeholder="温馨提示" />
				  	</div>
			   </div>
		 </div>
 </div> -->
	<?php } }?>
<?php }else{echo "暂无行程信息可填";}?>
		

