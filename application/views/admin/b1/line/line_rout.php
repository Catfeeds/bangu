
<!--地图加载-->

<!--景点设置-->
<?php echo $this->load->view('admin/b1/common/scenic_script'); ?>


<form action="<?php echo base_url()?>admin/b1/product/updateRouting"   class="form-horizontal bv-form" name="fromRout"   method="post" id="lineDayForm" >
<input type="hidden" class="LineRoutDay" value="<?php if(!empty($data ['lineday'])){echo $data ['lineday'];}else{ echo 0;} ?>"> 

<div class="widget-body" id="rout_line">	

<?php if(isset($linetype) && !empty($linetype)){ //遍历行程  ?>  	
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
	<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style="font-size:14px;">
	<span style="color: red;">*</span>第<?php echo $i+1; ?>天</label>
	<div class="col-sm-10 col_ts"  id="r_title"  style=" width:auto;min-width:43%;position:relative;">
	    <input name="daynum" value="<?php echo $num; ?>" id="daynum" type="hidden" />
		<div name="title" class="title_div text-width" contenteditable="true" style=" width: 612px;" ><?php if(!empty($rout[$i])){ echo $rout[$i]['title']; }?> </div>
		<div class="clear" id="tips" onclick="chk(this)" style="position:absolute;left:27px;top:4px;color:#888;min-width:500px">
		<div name="tips" style="color:gray;">出发城市 + 交通工具 + 目的地城市，若无城市变更，仅需填写行程城市即可</div></div>
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
					name="breakfirst[<?php echo $i;?>]"    onblur="show_sel(this)";
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
					class="form-control user_name_b1" style="width: 132px;" onblur="show_sel(this)";
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
					class="form-control user_name_b1" style="width: 132px;"   onblur="show_sel(this)";
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
	<?php } }?>
<?php }else{echo "暂无行程信息可填";}?>		

<!--  <div class="form-group" id="line_scenic">
	<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style=" position: relative;">游玩景点</label>
	<div class="form-inline col_ts">
		<input class="showScenic" type="button" name="showScenic" id="showScenic" value="景点设置" />
	</div>

</div> -->
 <!--  <div class="form-group" >
 <label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style=" position: relative;"></label>
 	<div class="form-inline col_ts" id="scenic_span">
 	       	<?php //if(!empty($spot)){ 
 	       		//foreach ($spot as $key => $value) {
 	       	?>
	      	<span class="scenic_val"><?php //echo $value['name'];?></span>
	     	<?php //} }?>
	</div>
	<input type="hidden" name="scenicData" value="<?php //if(!empty($spotid)){ echo $spotid;}?>">
	<input type="hidden" name="click_scenic_btn" value="">
 </div>-->
<div class="form-group" >
	<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">温馨提示</label>
	<div class="form-inline col_ts">
    	<div class="form-group col_ts" style="margin: 0px;">
         	<div class="col-sm-10 col_ts">
    		<input type="text"  style="width: 613px;" id="line_beizhu"
    			value="<?php if(!empty($data['line_beizhu'])){ echo $data['line_beizhu'];}else{ echo '往返抵离时间及景区人流调节缘故，导游领队有权调整游览时间顺序';} ?>"
    			class="form-control text-width" name="line_beizhu"
    			placeholder="温馨提示" />
    	  	</div>
    	</div>
	</div>
 </div>	
</div>
<div class="div_bt_i">
	<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:17%;"></label>
	<button class="btn btn-palegreen" type="button" id="sb_rout"  onclick="return CheckRouting(1);"><b  style="font-size:14px">保存</b></button>
	<button class="btn btn-palegreen" type="button"  id="next_rout" onclick="return CheckRouting(2);"   style="margin-left:150px;font-size:14px" ><b >保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
</div>


<!--景点的设置-->
<div class="scenicBox">
	<div class="scenicPadding">
		<div class="muenScenic"><a>目的地</a>  <span> 日本, 韩国, 新家谱</span></div>
		<div class="scenicTab">
			<ul>
				<!-- <li class="dataShow">日本</li>
				<li>韩国</li>
				<li>新家谱</li> -->
			</ul>
		</div>
		<div class="fastInput">
			<input type="text" name="searchSport" id="searchSport" placeholder="快速关键字搜索景点" />
			<img src="<?php echo base_url('assets/img/seachBtn.png'); ?>" onclick="search_scenic(this)"/>
			<span> 请务必按照游览顺序添加景点</span>
			<div class="">
			</div>
		</div>
		<div class="BarBox">
			<div class="addBar callout">
				<!--<ul class="destBar"></ul>-->
					<!-- <li><div class="liFog">富士山2<span>( fu shi shan )</span></div></li>
					<li><div class="liFog">富士山8<span>( fu shi shan )</span></div></li> -->
			</div>
			<div class="bthBar callout">
				<input type="button" name="addBar" id="addBar" value="添加" />
				<input type="button" name="removeBar" id="removeBar" value="删除" />
			</div>
			<div class="romoveBar callout">
				<ul>

				     <?php if(!empty($spot)){ 
						foreach ($spot as $key => $value) {
					 ?>			
					<li data-type="<?php echo $value['city_id']; ?>">
						<div class="sortNum">(<?php  echo $key+1;?>)</div>
						<div class="liFog" data="<?php echo $value['spot_id']; ?>"><?php if($value['status']==0){echo $value['name'].'<span style="color: #ff0000;">(待审核)</span>';}else{echo $value['name'];} ?><span></span>
						</div>
						
						<?php if($key==0){?>
							<div class="sortTop firstSort"></div>
							<div class="sortBottom"></div>
						<?php }else{ ?>
							<div class="sortTop"></div>
							<div class="sortBottom lastSort"></div>
						<?php } ?>
					</li>
					<?php } } ?>
				</ul>
				
				<input type="button" value="新增景点" class="NewlyScenic">
			</div>
		</div>
		<div class="scenicBtnBox"><input type="button" name="scenicButton" id="scenicButton" value="确定" /></div>
		<div class="NewlyMank"></div>
		<!--添加景点-->
		<div class="NewlyBox box-shadow">
		    <div class="db-body" style="  padding-bottom: 50px;">
			<div class="db-title">
				<h4 style="text-align: center;">景点管理</h4>
				<div class="db-close close-scenic">x</div>
			</div>
			<form method="post" action="#" id="form-data"  >
			<div class="db-content">
				<ul class="db-row-body">
					<li class="db-data-row">
						<div class="db-row-title">景点名称：</div>
						<div class="db-row-content">
						<input type="text" name="name" maxlength="10" placeholder="10字以内"  style="height:28px;" />
						</div>
					</li>
					<li  class="db-row">
						<div class="db-row-title">图片：</div>
						<div class="db-row-content" >
							<span class="form-but" id="upload-img">上传图片</span>
							<span><i style="color: red;margin-right: 2px;">*</i>建议上传图片剪切尺寸大小尽量保持一致</span>
							<ul class="pic-list" id="pic-list">
							</ul>
							<input type="hidden" name="piclist">
						</div>
					</li>
					<li class="db-row google-box" >
						<div class="db-row-title">定位详细地址：</div>
						<span class="full-screen get-into">全屏</span>
						<span class="full-screen sign-out" style="display: none;">确认并退出</span>
						<div id="google-map">
							<input type="text" id="address" name="address" style="width: 88%;" placeholder="请输入地址定位">
							<span id="location">定位</span>
							<ul id="address-list">
								<li data-key="1">深圳市世界之窗</li>
								<li data-key="1">深圳市欢乐谷</li>
								<li data-key="1">中国广东省深圳市世界之窗</li>
								<li data-key="1">深圳市世界之窗深圳市世界之窗深圳市世界之窗</li>
							</ul>
						</div>
						<div class="db-row-content" id="map" style="width:85%;height:400px;"></div>
					</li>
				</ul>
				<div class="db-buttons" style="margin-right:20px">
					<input type="hidden" name="lat" value=""/>
					<input type="hidden" name="index" value=""/>
					<input type="hidden" name="lng" value=""/>
					<input type="hidden" name="geohash" value=""/>
					<input type="hidden" name="city_id" value=""/>
					<div class="close-scenic-btn">关闭</div>
					<div id="submit-but">确定</div>
				</div>
			</div>
			</form>
			</div>
		</div>
		<!--添加景点end-->
	</div>
</div>

</form>
	
	

<script type="text/javascript">
     

 //行程标题的提示
 $(function(){

	//一下兼容各种浏览器，但不支持tab切换到div的情况
	jQuery("#rout_line").on("click", ".title_div",function(e){
		var titleDiv = jQuery(this);
		if(titleDiv){
		      	titleDiv.next('div').hide();
		}		
	});
	jQuery("#rout_line").on("click", "#tips",function(e){
		jQuery(this).hide();
		jQuery(this).prev().focus();
	});
	
	jQuery("#rout_line").on("blur", ".title_div",function(){
		 var titleDiv = jQuery(this);
		 if($.trim(titleDiv.html())==''){ 
		      	titleDiv.next('div').show(); 
		  }else{
		      	titleDiv.next('div').hide();
		  }
	});

 	$('.title_div').each(function(){
 		var title  = jQuery(this);
 		if($.trim(title.html())==''){
 			title.next('div').show();
 		}else{
 			title.next('div').hide();
 		}	
 	})  

}) 


jQuery("#rout_line").on("paste", ".title_div",function(e){
        var pastedText = '';
        if (window.clipboardData && window.clipboardData.getData) { // IE
            	pastedText = window.clipboardData.getData('Text');
        } else {
          	 	pastedText = e.originalEvent.clipboardData.getData('Text');//e.clipboardData.getData('text/plain');
        }
        var str = removeHTMLTag(pastedText);
        jQuery(this).html( str );
        return false;
 });
 function removeHTMLTag(str) {
        str = str.replace(/<\/?[^>]*>/g,''); //去除HTML tag
        str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
        str=str.replace(/&nbsp;/ig,'');//去掉&nbsp;
       return str;
 }
function closePirce(){
	$('.closetd').click();
}

//填写内容勾选用餐
function show_sel(obj){
	if($(obj).val()=='无'|| $(obj).val()==''){
		$(obj).parent().prev().find('input[type="checkbox"]').attr("checked", false);
	}else{
		$(obj).parent().prev().find('input[type="checkbox"]').attr("checked", true);
	}
	 
}
function chk(obj){
    
    if(obj.getElementsByTagName("img").length){
        document.getElementById('tips').textContent="";
    }
}
</script>