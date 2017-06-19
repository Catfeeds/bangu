<link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>	
	
<style type="text/css">
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
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">编辑线路</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu" onclick="close_xiuxiu();">×</div>
	<div class="right_box"></div>
</div>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" id="basc"><a href="#home11" data-toggle="tab"> 基础信息 </a></li>	
					<li class="" id="scheduling"><a class="routting"   href="#profile12" data-toggle="tab" id="routting" name="rout"> 行程安排 </a></li>
					<li class="" id="set_price"><a href="#profile10" data-toggle="tab" > 设置价格 </a></li>	
					<li class="" id="click_feedesc"><a href="#profile14" data-toggle="tab"> 费用说明 </a></li>
					<li class="" id="click_Bookings"><a href="#profile16" data-toggle="tab"> 参团须知</a></li>		
					<li class="" id="click_tips"><a href="#profile15" data-toggle="tab"> 产品标签 </a></li>
					<li class="" id="expert_training"><a href="#profile17" data-toggle="tab"> 管家培训 </a><li>
					<li class="" id="supplierGift"><a href="#profile13" data-toggle="tab"> 抽奖礼品</a><li> 
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 基础信息 -->		
					<div class="tab-pane active" id="home11">
						<form action="<?php echo base_url()?>admin/b1/product/updateLine" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form" method="post" 
						id="lineInfo" novalidate="novalidate">		
						<input name="id" value="<?php  if(!empty($data['id'])){echo $data['id']; }?>" id="id" type="hidden" />
						<div class="widget-body">
							<div id="registration-form">
								<table class="line_base_info table_form_content table_td_border" border="1" width="100%">
                                    <tr height="34" class="form_group">
                                        <td class="form_title">线路类型：</td>
                                        <td>
                                        	<div class=" col_ip">
                                                <select style="width:150px;height:auto;" name="line_classify" id="line_classify">
                                                          <?php if(!empty($data['line_classify'])){?>
                                                    <option value="1" <?php if($data['line_classify']==1){ echo 'selected';} ?>>境外游</option>
                                                    <option value="2" <?php if($data['line_classify']==2){ echo 'selected';} ?>>国内游</option>
                                                    <option value="3" <?php if($data['line_classify']==3){ echo 'selected';} ?>>周边游</option>
                                                    <?php  }else{ 
                                                        $line_overcity=explode(',', $data['overcity']);
                                                        if(in_array("1", $line_overcity)){
                                                                echo " <option value='1' selected>境外游</option>";
                                                                echo " <option value='2'>国内游</option>";
                                                                echo " <option value='3'>周边游</option>";
                                                        }else{
                                                                echo " <option value='1'>境外游</option>";
                                                                echo " <option value='2' selected>国内游</option>";
                                                                echo " <option value='3'>周边游</option>";
                                                        }	
                                                     } ?>
                                                </select>
                                                <span style="color: red;padding-left:20px;"></span>
                                                </div>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路名称：</td>
                                        <td>&nbsp;&nbsp;
                                        	<input type="hidden" id="brand" value="<?php if(!empty($supplier[0])){ echo $supplier[0]['brand'];} ?>">
											<?php if(!empty($supplier[0])){ echo $supplier[0]['brand'];} ?>
                                        	<input type="text" placeholder="10字以内" value="<?php echo $data['lineprename'];?>" id="lineprename" class="form_input w_450" name="lineprename"/>
                                            <input type="text" value="<?php echo $data['linenight'];?>" id="data_night" class="form_input w_40" name="data_night"/>晚
                                            <input type="text" value="<?php echo $data['lineday'];?>" id="data_num" class="form_input w_40" name="data_num"/><i class="important_title">*</i>天游
                                            <span class="title_txt red">线路名称+副标题总字数不超过50个字</span>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>副标题：</td>
                                        <td><input type="text" placeholder="需重点突出的信息,20字以内" value="<?php echo $data['linetitle'];?>" id="linetitle" class="form_input w_600" name="linetitle"></td>
                                    </tr>                                   
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>出发地：</td>
                                        <td>
                                        	<input type="text" placeholder="出发地-模糊搜索" class="form_input w_120 fl" id="startcity" name="startcity" autocomplete="off" value="<?php if($data['line_classify']==3){foreach ($cityArr as $v):  echo $v['cityname']; endforeach; }?>">
                                            <input type="hidden" name="lineCityId" id="lineCityId" value="<?php if(!empty($citystr)){ echo $citystr;} ?>">
                                            <div id="startcity-list" style="min-width:500px;float:left;margin-top:4px;">
                                            	<?php if($data['line_classify']!=3){ 
                                                        foreach ($cityArr as $v):
                                                    ?>					
                                                        <span class="selectedContent" value="<?php echo $v['startplace_id']; ?>">
                                                    <?php echo $v['cityname']; ?>
                                                    <span class="delPlugin" onclick="delPlugin(this ,'lineCityId' ,'startcity-list');">×</span>
                                                </span>				  
                                            	<?php endforeach; }?>
							     			</div>	
                                            </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>目的地：</td>
                                        <td id="select_dest">
                                        	<input type="text" placeholder="目的地-模糊搜索" class="form_input w_120 fl" id="overcityArr" name="overcity_arr">
                                        	<input name="overcitystr" id="overcitystr" type="hidden" value="<?php echo $data['overcity2'].',' ?>" >    
                                           <div id="ds-list" style="min-width:500px;float:left;margin-top:4px;">
                                            	<?php foreach ($overcity2_arr as $overcity):?>								
					        <span class="selectedContent" value="<?php echo $overcity['id']; ?>">
						<?php echo $overcity['name']; ?>
						<span class="delPlugin" onclick="delPlugin(this ,'overcitystr' ,'ds-list');">×</span>
						</span>												  
					<?php endforeach;?>
				</div>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title">主题游：</td>
                                        <td id="select_theme">
                                        	<span id="theme-list" class="btn btn-palegreen" >
					<span id="theme_arr" data="<?php  if(!empty($themeid)){ echo $themeid[0]['id'];} ?>" name="ds-lable"  <?php if(!empty($themeid)){ echo 'style="color: #fff;"'; }?> data-val="<?php  if(!empty($themeid)){ echo $themeid[0]['id'];} ?>">
                                                    <?php if(!empty($themeid)){ echo $themeid[0]['name']; }else{echo '选择主题游'; }?>
                                                    </span>
                                                    <?php  if(!empty($themeid[0]['id'])){?>
                                                    <a name="delDestLable" href="###">×</a>	
                                                    <?php }?>
				</span>	
                                        	<input id="theme" type="hidden" name="theme" value="<?php  if(!empty($themeid)){ echo $themeid[0]['id'];} ?>">
				<span style="color: red;margin-left:70px;">可自由选择是否加入主题游选项</span>
                                        </td>
                                    </tr>    
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>提前：</td>
                                        <td><input type="text" placeholder="" id="linebefore" class="form_input" name="linebefore" style="width: 50px;" value="<?php echo $data['linebefore'];?>"/>
                                            <span>天截止报名</span>
                                        </td>
                                    </tr>   
                                    <input type="hidden" id="first_pay_rate"  value="<?php echo $data['first_pay_rate']*100;?>" name="first_pay_rate"/>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路特色：</td>
                                        <td>
                                        	<textarea placeholder="其他显示信息(600字以内)" style="width:600px;height:300px;" class="noresize w_600"  id="name_list" name="name_list"><?php echo $data['features'];?></textarea>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路宣传图：</td>
                                        <td><span onclick="change_avatar(this,0);" class="choice_img">选择图片</span>
				<span onclick="choice_picture(this,1)" class="choice_picture" >从相册选择</span> 
                                        	<div style="color: red; width: 280px;padding-left:5px; display: inline-block; height: 30px; line-height: 30px;">建议500*300。最多上传5张，选一张成为主图</div>
                                            <ul id="ThumbPic" style="margin-left:5px;margin-top:5px;">
												<?php if(!empty($imgurl)){ 
                                                    foreach ($imgurl as $k=>$v){
                                                                     if(!empty($v['filepath'])){
                                                    ?>
                                                     <li <?php if($v['filepath']==$data['mainpic']){ echo 'class="list_click"'; } ?> class="" >
                                                       <div class="img_main0" ><div class="float_img" id="del_img"  onclick="del_line_imgdata(this,<?php echo $v['pid']?>)">×</div>
                                                        <div style="width:100px;height:60px;"><img  style="height:100%;" src="<?php echo $v['filepath']; ?>"></div>
                                                        </div>
                                                        <div class="zhutu">设为主图片</div>
                                                        <div class="weixuanzhong" <?php if($v['filepath']==$data['mainpic']){ echo 'style="display:none"'; } ?> ></div>
                                                    </li>
                                                <?php } }}?>
                                            </ul>
                                            <input type="hidden" name="mainpic" value="<?php echo $data['mainpic'];?>"/>	 
                                        </td>
                                    </tr>
                                </table>
							</div>  
						</div>
						<div style="margin-bottom: 100px;" class="div_bt_i">
							<label for="inputImg" class="col-sm-2 control-label no-padding-right" style="text-align:right; width:17%"></label>
							<button class="btn btn-palegreen" type="button"  id="sb_line" onclick="return CheckLine();" ><b  style="font-size:14px">保存</b></button>
							<button class="btn btn-palegreen" type="button" onclick="return CheckLine();"  style="margin-left:150px;"  id="next_line"><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
						</div>
						</form>
					</div>
					<!-- 行程安排 -->
					<div class="tab-pane" id="profile12">
						<form action="<?php echo base_url()?>admin/b1/product/updateRouting" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form" name="fromRout"   method="post" 
						id="lineDayForm" novalidate="novalidate">
						<input type="hidden" class="LineRoutDay" value="<?php if(!empty($data ['lineday'])){echo $data ['lineday'];}else{ echo 0;} ?>"> 
						<div class="widget-body" id="rout_line">	         
						<!-- ajax加载的内容 -->
						<?php
							if($data ['lineday']>0){
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
									<div class="clear" id="tips" onclick="chk(this)" style="position:absolute; left:27px;top:4px;color:#888;min-width:500px">
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
                                                                                            value="<?php if(!empty($rout[$i]['transport'])){ echo $rout[$i]['transport'];} ?>"
                                                                                            class="form-control text-width" name="transport[<?php echo $i;?>]"
                                                                                            placeholder="100字以内,可不输，即为不显示" />
                                                                                     </div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb"
									for="inputEmail3">用餐</label>
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
								<label class="col-sm-2 control-label no-padding-right label-width col_lb"
									for="inputEmail3">行程图片</label>
									<div class="col-sm-10 col_ts" style="width: 730px;">
									    <div class="div_url_val" style="width: 720px;float:left;max-height:400px;">
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
						<?php } }?>
						</div>
							<div class="form-group" id="line_scenic">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style=" position: relative;">游玩景点</label>
								<div class="form-inline col_ts">
									<input class="showScenic" type="button" name="showScenic" id="showScenic" value="景点设置" />
								</div>
							
							</div> 
							 <div class="form-group" >
							 <label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style=" position: relative;"></label>
							 	<div class="form-inline col_ts" id="scenic_span">
							 	       	<?php if(!empty($spot)){ 
							 	       		foreach ($spot as $key => $value) {
							 	       	?>
								      	<span class="scenic_val"><?php echo $value['name'];?></span>
								     	<?php } }?>
								</div>
								<input type="hidden" name="scenicData" value="<?php if(!empty($spotid)){ echo $spotid;}?>">
								<input type="hidden" name="click_scenic_btn" value="">
							 </div>
							<div class="form-group" >
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">温馨提示</label>
									<div class="form-inline col_ts">
										<div class="form-group col_ts" style="margin: 0px;">
										     	<div class="col-sm-10 col_ts">
												<input type="text"  style="width: 700px;" id="line_beizhu"
													value="<?php if(!empty($data['line_beizhu'])){ echo $data['line_beizhu'];}else{ echo '往返抵离时间及景区人流调节缘故，导游领队有权调整游览时间顺序';} ?>"
													class="form-control text-width" name="line_beizhu"
													placeholder="温馨提示" />
											  	</div>
										   </div>
									 </div>
							 </div>	
						
						<!-- --end----- -->
						
						<div class="div_bt_i">
							<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:17%;"></label>
							<button class="btn btn-palegreen" type="button" id="sb_rout"  onclick="return CheckRouting(1);"><b  style="font-size:14px">保存</b></button>
							<button class="btn btn-palegreen" type="button"  id="next_rout" onclick="return CheckRouting(2);"   style="margin-left:150px;font-size:14px" ><b >保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
						</div>
						</form>
					</div>
					<!-- 设置价格 -->
					<input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
					<div class="tab-pane" id="profile10">	
						<div class="widget-body" style="padding: 0;">
							<div id="registration-form">
								<div id="day_price">
									<div style="margin-top: 10px;"> 	
									    <form action="<?php echo base_url()?>admin/b1/product/updateLinePrice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
											data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
											data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  id="linePriceForm" novalidate="novalidate">		 
											<input name="lineId" type="hidden" id="lineId" value="<?php echo $data['id'];?>" />

                                                                                                          <div style="margin-top:20px;" >
                                                                                                              <span style="padding-left: 5px;"><span style="color: red;">*</span>定金:</span>
                                                                                                               <input style="padding-left: 5px;width:60px;" class="price_input" type="text" placeholder="" value="<?php if(!empty($line_aff)){ echo $line_aff['deposit'];}else{ echo 0;} ?>" name="deposit" id="deposit" />
                                                                                                              <span>元</span>

                                                                                                              <span><span style="color: red;padding-left:10px;">*</span>提前:</span>
                                                                                                              <input style="padding-left: 5px;width:50px;display: inline-block;" type="text" value="<?php if(!empty($line_aff)){ echo $line_aff['before_day'];}else{ echo 0;} ?>" id="before_day" class="price_input" name="before_day"  />
                                                                                                              <span>天交清团费</span>
                                                                                                          </div>

									  	<div style="margin-top:20px;"><span><span style="color: red;">*</span>成人佣金:</span>
									  		<input style="padding-left: 5px;width:60px;display: inline-block;" type="text" value="<?php echo $data['agent_rate_int'];?>" id="agent_rate" class="form-control text-width price_input" name="agent_rate"  />
									  		<span>元/人份</span>
									          <span style="padding-left: 15px;">小童佣金:</span>
									  		<input style="padding-left: 5px;width:60px;display: inline-block;" type="text" value="<?php echo $data['agent_rate_child'];?>" id="agent_rate_child" class="form-control text-width price_input" name="agent_rate_child"  />
									  		<span>元/人份</span>
									  	</div>
									  	<div style="margin-top:15px;"><span style="color:red;">备注:</span></div> 
									    <div style="margin-top:10px;"> <span class=" col_price">儿童占床说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($data['child_description'])){ echo $data['child_description']; }?>" id="child_description" class="form-control text-width price_input col_wd" name="child_description"  /></div>
									    
									    <div style="margin-top:10px;"> <span class=" col_price">儿童不占床说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($data['child_nobed_description'])){ echo $data['child_nobed_description']; }?>" id="child_nobed_description"  class="form-control text-width price_input col_wd" name="child_nobed_description"  />
									     <span style="padding-left:10px;">提示：填写则在产品页面显示，不填则无显示</span>
									    </div>
									       
									    <div style="margin:10px 0px 10px 0px;"> <span class=" col_price">老人价说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($data['old_description'])){ echo $data['old_description'];} ?>" id="old_description"  class="form-control text-width price_input col_wd" name="old_description"  /></div>
									    
									    <div style="margin-bottom:30px;"> <span class=" col_price">特殊人群说明:</span>
									    <input type="text" placeholder="15字内 " value="<?php if(!empty($data['special_description'])){ echo $data['special_description'];} ?>" id="special_description" style="padding-left: 5px;display:inline-block;height:28px;" class="form-control text-width price_input col_wd" name="special_description"  /></div>
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
						
					</div>
					<!-- 费用说明 -->
					<div class="tab-pane" id="profile14">
						<form action="<?php echo base_url()?>admin/b1/product/updatelineFee" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  onsubmit="return CheckFee();"
						id="lineFeeForm" novalidate="novalidate">
							<div class="widget-body">
								<div id="registration-form">
									 <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
                                     <table class="departure_notice table_form_content table_td_border" border="1" width="800">                                
                                        <tbody>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用包含：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="feeinclude" id="feeinclude"><?php if(!empty($data['feeinclude'])){ echo $data['feeinclude'];} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用不含：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="feenotinclude" id="feenotinclude"><?php if(!empty($data['feenotinclude'])){ echo $data['feenotinclude'];} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">购物自费：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="other_project" id="other_project"><?php if(!empty($data['other_project'])){ echo $data['other_project'];}?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">保险说明：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="insurance" id="insurance"><?php if(!empty($data['insurance'])){ echo $data['insurance'];} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">签证说明：</td>
                                                <td><textarea class="form_textarea w_600 noresize" name="visa_content" id="visa_content"><?php if(!empty($data['visa_content'])){ echo$data['visa_content']; } ?></textarea></td>
                                            </tr>
                                        </tbody>
                                    </table>
									
								</div>
							</div>
					    	<div class="div_bt_i">
							<label for="inputImg" class="col-sm-2 control-label no-padding-right"style=" width:17%;"></label>
							<button  class="btn btn-palegreen" type="submit" id="sb_fee"><b  style="font-size:14px">保存</b></button>
							<button class="btn btn-palegreen" type="submit" style="margin-left:150px;" id="next_fee"><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
						</div>
						</form>
					</div>
					<!-- 预定须知 -->
					<div class="tab-pane" id="profile16">
						<form action="<?php echo base_url()?>admin/b1/product/updateBookNotice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="lineNoticeForm" novalidate="novalidate" onsubmit="return ChecklineNotice();" >
						<div class="widget-body">
                        	<input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
                    		<table class="departure_notice table_form_content table_td_border" border="1" width="800">                                
                                <tbody>
                                    <tr class="form_group">
                                        <td class="form_title w_100"><i class="important_title">*</i>温馨提示：</td>
                                        <td><textarea class="form_textarea w_600 noresize" name="beizu" id="editor"><?php if(!empty($data['beizu'])){ echo $data['beizu'];} ?></textarea></td>
                                    </tr>
                                    <tr class="form_group">
                                        <td class="form_title w_100"><i class="important_title">*</i>特别约定：</td>
                                        <td><textarea class="form_textarea w_600 noresize" name="special_appointment" id="special_appointment"><?php if(!empty($data['special_appointment'])){ echo $data['special_appointment'];} ?></textarea></td>
                                    </tr>
                                    <tr class="form_group">
                                        <td class="form_title w_100"><i class="important_title">*</i>安全提示：</td>
                                        <td><textarea class="form_textarea w_600 noresize" name="safe_alert" id="safe_alert"><?php if(!empty($data['safe_alert'])){ echo $data['safe_alert'];} ?></textarea></td>
                                    </tr>  
                                    <tr class="form_group">
                                            <td class="form_title w_100"><i class="important_title"></i>附件上传：</td>
                                            <td class="attachment_content">  <input type="file" id="upfile" name="upfile"  />
                                                     <input type="button"  id="updatafile" value="上传" style="padding: 3px;margin-left:15px" />
                                                     <?php if(!empty($protocol)){
                                                            foreach ($protocol as $key => $value) {
                                                     ?>
                                                    <div id="attachment_list">
                                                         <span class="selectedContent" value="">
                                                                  <?php echo $value['name']; ?>
                                                                  <input type="hidden" id="attachment_name" name="attachment_name[]" value="'+data.urlname+'" />
                                                                  <input type="hidden" id="attachment" name="attachment[]" value="<?php echo $value['url'];?>" />
                                                                 <span class="delPlugin" onclick="delSpan(this);">x</span>
                                                         </span>
                                                     </div>
                                                     <?php  }   }?>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>			
							
						</div>
						<div class="div_bt_i">
							<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:17%;"></label>
							<button class="btn btn-palegreen" id="sb_linenotice"><b  style="font-size:14px" >保存</b></button>
							<button class="btn btn-palegreen" id="next_linenotice"  type="submit" style="margin-left:150px;" ><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
						</div>
						</form>
					</div>
                   				<!-- 产品标签  -->
					<div class="tab-pane" id="profile15">
						<form action="<?php echo base_url()?>admin/b1/product/updateLabel" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="lineLabelForm" novalidate="novalidate" onsubmit="return updateLabel();" >
							<div class="widget-body">
								<div class="form-group" style="padding:0px 0px 10px 0px;">					
										<div class="col-sm-2 control-label no-padding-right label-width col_xl" style="float: none;width:100%;max-width: 810px;" for="inputEmail3" ><span style="color: red;">*</span>请点击以下标签进行选择：（客人根据兴趣寻找心仪的旅游线路时，会使用关键字标签进行搜索，若您不设标签将脱离于客人视线之外）
										<div class=" col_ip" style="width: 70%;padding-top: 5px;padding-left: 20px;">
									    	<input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" />
											<div class="col-lg-4 no-padding-left" id="select_attr" style="width:820px; float:left;">
													 <div class="pop_city_container">
													 	<div class="tab" id="line_attr_tab">
													 		
													 		 <?php if(!empty($attr)){
													 		 	$attr_data=explode(',', $data['linetype']);
													 			foreach ($attr as $k=>$v){?>
													 		 <?php 
															 		echo '<div class="city_item_in" ><span class="city_item_letter" >'.$v['attrname'].'</span>';
															 		foreach($v['two'] as $key=>$val){
                                                                            if (in_array($val['id'], $attr_data)) {$selected="attr-item-selected";}else{$selected=''; } 		
																			echo '<a href="##" title="'.$val['attrname'].'"  class="attr-item '.$selected.'" dataid="'.$val['id'].'">'.$val['attrname'].'</a>';
															 		}
															 		echo '</div>';
															 	}
															 } ?>
													 	</div>
													 </div>
													 <input name="linetype" value="<?php echo  $data['linetype'];?>" id="linetype" type="hidden" />													  
											</div>
										</div>
									</div>
								</div>
							 </div>
								<div class="registration-form">	
									<label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:10%;"></label>
									<button class="btn btn-palegreen" id="sb_label" ><b  style="font-size:14px">保存</b></button>
									<button class="btn btn-palegreen" id="next_label"  type="submit" style="margin-left:150px; "><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
								</div>
						</form>
					</div>
					
					<!-- 管家培训-->
			    	<div class="tab-pane" id="profile17">
						<form action="<?php echo base_url()?>admin/b1/product/updatelineTrain" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post" 
						id="lineTrainForm" novalidate="novalidate" onsubmit="return ChecklineTrain();" >
						<div class="widget-body">
						  <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" /> 
						
						 <div style="margin-left:6px;width:870px;color:red;"> 
						 <span>旅游管家在申请售卖权时，需认真阅读您的“管家培训”内容后才可得到资质。因此请您认真填写在售卖此条线路时，游客最经常问到的至少十个问题（多不限），并提供相对固定的参考答案。</span></div>
							<div class="form-group problem_content" style="margin-left:0.5%;margin-top:20px;display: -moz-inline;display: -webkit-inline; display: inline;">
								<?php if(!empty($train)){ 
								  if(count($train)<10){ 
									    $trainmun=count($train);   
								?>
								<?php  for($i = 0; $i < $trainmun; ++ $i) {  ?>
								<div class="problem_div">
									<div class="problem_title fl">
									       <span class="num">问题<?php echo $i+1; ?></span>
									       <input type="hidden"  name="train_id[]" value="<?php echo $train[$i]['id']; ?>"/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="<?php echo $train[$i]['question']; ?>" placeholder="请输入热门问题">
										<i class="icon icon_1"   onclick="del_train(this,<?php echo $train[$i]['id'] ;?>)"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"><?php echo $train[$i]['answer']; ?></textarea>
									</div>
								</div>
								<?php } ?>
								<?php  for($trainmun; $trainmun < 10; ++ $trainmun) {  ?>
								<div class="problem_div">
									<div class="problem_title fl">
									       <span class="num">问题<?php echo $trainmun+1; ?></span>
									       <input type="hidden"  name="train_id[]" value=""/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
										<i class="icon icon_1"   onclick="del_train(this,'')"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"></textarea>
									</div>
								</div>
								<?php } ?>
						                                <?php }else{ 
						                                	foreach ($train as $k=>$v){ 
								 ?>
								<div class="problem_div">
									<div class="problem_title fl">
									       <span class="num">问题<?php echo $k+1; ?></span>
									       <input type="hidden"  name="train_id[]" value="<?php echo $v['id']; ?>"/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="<?php echo $v['question']; ?>" placeholder="请输入热门问题">
										<i class="icon icon_1"   onclick="del_train(this,<?php echo $v['id'] ;?>)"></i>
									</div>
									<div class="delete_bomb">
									<span>点击按钮,删除此问题</span>
									</div>
									<div class="problem_answer">
										<label>A：</label>
										<textarea name="answer[]" placeholder="请输入参考答案"><?php echo $v['answer']; ?></textarea>
									</div>
								</div>	
								<?php } }}else{?>
						                                <?php $num=10;
						                                for($i = 0; $i < $num; ++ $i) {
						                                ?>
					                                	<div class="problem_div">
									<div class="problem_title fl">
									       <span  class="num">问题<?php echo $i+1; ?></span><input type="hidden"  name="train_id[]" value=""/>
									</div>
									<div class="hot_problem">
										<label>Q：</label>
										<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
										<i class="icon icon_1"    onclick="del_train(this,'')"></i>
									</div>
									<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>
									<div class="problem_answer">
										<label>A：</label><textarea name="answer[]" placeholder="请输入参考答案"></textarea>
									</div>
								</div>

                              						 <?php } }?>

							</div>
						</div>
						<div class="div_bt_i">
						      <div class="tjia_btn fl train_btn"  ><span >+添加</span></div>
							  <label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:20%;"></label>
							  <button  class="btn btn-palegreen"  type="submit" id="sb_linetrain"> <b  style="font-size:14px">保存</b></button>
							  <button class="btn btn-palegreen cjia_btn_1" type="submit" id="sb_linetrain" style="margin-left:150px; " ><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
						</div>
						</form>
					</div>
					    <!-- 抽奖礼品-->
			     	  	<div class="tab-pane" id="profile13" style="min-height:300px;">
							<div class="widget-body" style="width: 100%;">
							   <form action="<?php echo base_url()?>admin/b1/product/updatelineTrain" accept-charset="utf-8" method="post" 
									id="lineGiftForm" novalidate="novalidate" onsubmit="return ChecklineGift();"  >
									  <input name="id" value="<?php echo $data['id'];?>" id="id" type="hidden" /> 
								<div id="registration-form">
								   <div class="title_zif"><span>抽奖礼品</span>&nbsp;&nbsp;&nbsp;&nbsp;
								   	<span class="tianjia_btn"  id="addgift" style="cursor:pointer;padding:6px 10px;color:#fff;background-color:#2dc3e8">+添加</span>&nbsp;&nbsp;&nbsp;&nbsp;
								    <span class="tianjia_btn"  id="selgift" style="cursor:pointer;padding:6px 10px;color:#fff;background-color:#2dc3e8">+选择</span>
								   </div></br>
								   <div>
								        <input type="hidden" name="hasClass" id="hasClass" value="<?php if(!empty($gift)){ echo 1;}?>" >
								       <table  class="table table-striped table-hover table-bordered dataTable no-footer"> 
										    <thead class="gift_title">
										     <?php if(!empty($gift)){ ?>
										        <tr role="row">
										            <th style="width: 100px;text-align:center">礼品名称</th>
										            <th style="width: 80px;text-align:center" >有效期</th>
										            <th style="width: 60px;text-align:center" >图片</th>
										            <th style="width: 40px;text-align:center" >数量 </th>
										            <th style="width: 80px;text-align:center" >价值</th>
										            <th style="width: 60px;text-align:center" >状态</th>
										            <th style="width: 150px;text-align:center">操作</th>
										        </tr>
										       <?php }?>
										    </thead>
									 
										    <tbody class="gift_text">
								                               <?php if(!empty($gift)){ 
								                                		foreach ($gift as $k=>$v){	
								                                ?>
										           <tr class="gift_tr<?php echo $v['glid']; ?>">
											            <td style="text-align:center" class="sorting_1">
											            <?php echo $v['gift_name']; ?></td>
											            <td style="text-align:center" class=" "><input type="hidden"  value="<?php echo $v['id']; ?>"/><?php echo $v['starttime'].'至'.$v['endtime']; ?></td>
											            <td  style="text-align:center" class="center  "><img style="width:65px; height:65px; " src="<?php echo $v['logo']; ?>" ></td>
											            <td style="text-align:center" class=" "><?php if(!empty($v['gift_num'])){ echo $v['gift_num'];}else{ echo 0;}?>张</td>
											            <td style="text-align:center" class=" "><?php if(!empty($v['worth'])){ echo $v['worth'];}?></td>
											            <td style="text-align:center" class=" "><?php if($v['status']==0){ echo '上架';}elseif($v['status']==1){echo '下架';} ?></td>
											            <td style="text-align:center" class="caozuo ">
											            	    <span class="look_gift" onclick="look_gift(this)" data="<?php echo $v['id']; ?>">查看</span>
											            	 <!-- <span class="edit_gift" onclick="edit_gift(this)" data="<?php echo $v['id']; ?>">编辑</span> --> 
											            	    <span class="del_gift"  data="<?php echo $v['glid']; ?>" onclick="del_gift(this);">删除</span>
											            </td>
										          </tr>
										        <?php } }?>
											</tbody>
									</table>  
							</div>		
							</div>
								<div class="registration-form" style="margin:30px 0px 0px 570px;">	
									<button class="btn btn-palegreen"  type="submit" id="save_line_gift" style="display:none">保存</button>
								</div>
							</form>
						</div>
					</div>
					
					<div class="title_info_box" style="display:none;position:fixed;border:1px solid #f00;text-align:left;text-indent:30px;width:300px;padding:10px;background:#fff;z-index:999;color:#f00;font-size:14px;top:100px;right:20px;font-weight:600;">	
                       	
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
          
<!-- 批量价格录入的弹框 -->
<div style="display: none;" class="tbtsdgk">
	<div class="closetd">×</div>
	<form action="" class="form-horizontal"  role="form" id="applyPrice" method="post" onsubmit="return updataPrice(this);">
		<div align="center">
			<div class="widget-body" style=" width: 600px; margin-top: 100px;">
				<div id="registration-form" class="messages_show" style="">
				 	<table class="table table-bordered table-hover money_table">	  
						<tr>
								<td class="order_info_title"><span style="color: red;">*</span>选择日期：</td>
								
								<td  style="vertical-align : middle;height: 90px;"> 
									<textarea class="noresize" name="startDate" cols="" rows="" readonly="readonly" id="startDate" placeholder="请点击选择" 
										onclick="T2TCNCalendar.display(this, new Date(), AddDay('Y',1,new Date()), document.getElementById('xDate'),10,'checkboxNameX');" 
										style="overflow-y:hidden;height:100%;width:100%;padding: 0;margin: 0"
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
							<td colspan="2"><input id="inputEmail" type="text"  size=8 name="adult_price">元</td>
						</tr>
						<tr>
							<td class="order_info_title">儿童价</td>
							<td colspan="2"><input id="inputEmail" type="text" size=8  name="chil_price">元</td>
						</tr>
						<tr>
							<td class="order_info_title">儿童价不占床</td>
							<td colspan="2"><input id="inputEmail" type="text" size=8  name="chil_nobedprice">元</td>
						</tr>
						<tr>
							<td class="order_info_title">老人价</td>
							<td colspan="2"><input id="inputEmail" type="text" size=8  name="old_price">元</td>
						</tr>
						</tbody>
					</table>	
                    <div class="clear" style="padding:15px 0 10px;"><input class="btn btn-palegreen "  onclick="closePirce()" style="float: right;margin-right:180px;" type="button" value="关闭" /><input class="btn btn-palegreen"  style="float: right;margin-right:110px;" type="submit" value="确认"/></div>
				</div>
			</div>
		</div>
		</form >
	</div>
<!--添加礼品弹框  编辑礼品   -->
<div class="lp_div modal fade in" style="display:none">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:600px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">添加新增礼品</h4>
			    </div>
			    <div class="modal-body"><div class="bootbox-body">
			       <form  class="form-horizontal" id="giftFrom" method="post" action="">	
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>礼品名称:</label>
			            <div class="col-sm-4 fl">
			            	<input name="line_id" value="<?php echo $data['id'];?>" id="line_id" type="hidden" />
			            	<input name="gift_id" value="" id="gift_id" type="hidden" />
			                <input type="text" style="height:30px;" name="gift_name">
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>有效期:</label>
			           <div class="col-sm-4 fl">
					<div style="width:200px; float:left;" class="input-group col-sm-10 ">
						<input type="text" data-date-format="yyyy-mm-dd" name="startdatetime" id="starttime" class="form-control date-picker fl" style="width:162px">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>				
					<span class="hege">-</span>
					<div style="width:200px;float:left" class="input-group col-sm-10 fl">
						<input type="text" data-date-format="yyyy-mm-dd"  name="enddatetime" id="endtime" class="form-control date-picker fl" style="width:162px">
						<span class="input-group-addon"> <i class="fa fa-calendar"></i></span>
					</div>			
			           </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>礼品总数量:</label>
			            <div class="col-sm-4 fl">
			               <input type="text" name="account" style="height:30px;float:left" />&nbsp;<span class="jg_my ">张</span>
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>添加的数量:</label>
			            <div class="col-sm-4 fl">
			               <input type="text" name="add_account" style="height:30px;float:left" />&nbsp;<span class="jg_my ">张</span>
			            </div>
			        </div>
			        <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl"  for="inputPassword3"><span style="color: red;">*</span>价值:</label>
			            <div class="col-sm-4 fl ">
			               <input type="text" name="worth" style="height:30px;float:left" />&nbsp;<span class="jg_my">元</span>
			            </div>
			        </div>
			        <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">图片:</label>
			            <div class="col-sm-4 fl " id="gift_pic" >
			              <img style="width:170px;height:150px;" src="">
			              <input type="hidden" name="logo" value=""/>
			              <span class="webuploader-pick" onclick="change_avatar(this,2);" >+/1上传图片</span>
			            </div>
			        </div>
			          <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>说明:</label>
			            <div class="col-sm-4 fl">
			               <textarea name="description"></textarea>
			            </div>
			        </div>
			        <div class="form-group">
			            <input type="button" style="float: right; margin-right: 2%;" value="提交" id="gift_button" class="btn btn-palegreen">        
			        </div>  
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<!-- 查看礼品结束 -->	
<div class="lookgfit_div modal fade in" style="display:none;">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:600px;height:500px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title gift_biaoti">礼品详情</h4>
			    </div>
			    <div class="modal-body"><div class="bootbox-body">
			       <form  class="form-horizontal" id="lookgiftFrom" method="post" action="">	
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">礼品名称:</label>
			            <div class="col-sm-4 fl gift_div_1 gift_div">
			            	<span></span>
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">有效期:</label>
			            <div class="col-sm-4 fl gift_div_2 gift_div" style="width:400px;">
							 <span></span>		
			            </div>
			        </div>
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">数量:</label>
			            <div class="col-sm-4 fl gift_div_3 gift_div">
			              <span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl"  for="inputPassword3">价值:</label>
			            <div class="col-sm-4 fl gift_div_4 gift_div">
			              <span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">图片:</label>
			            <div class="col-sm-4 fl gift_div_5 gift_div" id="gift_pic" >
			              <span></span>
			            </div>
			        </div>
			        <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">说明:</label>
			            <div class="col-sm-4 fl gift_div_6 gift_div">
			              <span></span>
			            </div>
			        </div>
 
			    </form>
			    </div>
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<!-- 结束  -->
<!-- 选择礼品 -->
<div style="display: none;" class="tbtsd">
	<div class="closetd" style="opacity: 0.2; padding:6px 0 0 5px;font-size: 35px; font-weight: 800;">×</div>
	<div align="center" style="height:100%;">
		<div class="widget-body" style="height:100%;">
			<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
				<form
					data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
					data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
					data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
					data-bv-message="This value is not valid"
					class="form-horizontal bv-form" method="post" id="listForm"
					novalidate="novalidate">
					<div class="form-group has-feedback">
						<label class="col-lg-4 control-labe fl" style="width:auto">礼品名称：</label>
						<div class="col-lg-4 fl" style="width:100px" id="linelist_div">
							<input type="text" placeholder="礼品名称-模糊搜索" name="title" class="form-control user_name_b1" style="padding-right:0px;width:170px;"> 
							<input type="hidden" name="linelistID" value="<?php echo $data['id'];?>"  class="form-control user_name_b1"> 
							<input type="hidden" name="lineGiftListID" id="lineGiftListID" value=""  class="form-control user_name_b1"> 
							
						</div>
						<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
						<div class="col-lg-4 fl" style="width: 80px;margin-left:100px;">
							<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
						</div>
					</div>
				</form>	
				<form action="" id='supplier_gift' name='supplier_unsettled_order' method="post" onSubmit="return checkgift()">
					<div id="gift_list"></div>
					<div><input type="hidden" name="line_id" value="<?php echo $data['id'];?>"/></div>
					<div style="margin-top: 15px;"><input type="submit" class="btn btn-info btn-xs" style="width:55px;height:30px;margin:10px;" value="提交">
                    <input type="button"  class="btn btn-info btn-xs close_gift" style="width:55px;height:30px;margin:10px;" value="关闭"></div>
                 </form>		
			</div>
		</div>
	</div>
</div>
<div class="messages_color" style="display: none;"></div>
<!-- 结束 -->
<!-- 行程安排的交通 -->
<div id="route_div" style="position: absolute;background: #fff;border: 1px solid #DDDBDB;display: none;z-index: 1000;">
		<div class="route"><img alt="飞机" src="/assets/img/icons/route/plain.gif"></div>
		<div class="route"><img alt="汽车" src="/assets/img/icons/route/bus.gif"></div>
		<div class="route"><img alt="轮船" src="/assets/img/icons/route/ship.gif"></div>
		<div class="route"><img alt="火车" src="/assets/img/icons/route/train.gif"></div>
		<div style="display: inline-block;margin-left: 10px;padding: 0 5px;">点击图标，选择交通工具</div>
</div>
<!-- end -->
  <!-- 新增的弹框 end-->
	<div class='avatar_box'></div>
<!-- 加载编辑器 -->
<!--  相册图片选择 -->
<div class="choice_photo_box" style="display: none;">
	<div class="box_content">
    	<div class="box_header">相册选择<span class="close_box" onclick="close_alert_box();">×</span></div>
	        <div class="box_body">
	            <div class="img_search"><!-- <input type="text" placeholder="搜索目的地图片"> -->
	            <select style="width:130px;" name="dest_picture">
	                 <option value="" >请选择</option>
	                 <?php if(!empty($dest_two)){ 
	                 	foreach ($dest_two as $k=>$v){
	                 ?>
	                 <option value="<?php echo $v['dest_id']; ?>"><?php echo $v['kindname']; ?></option>
	                 <?php } }?>
	            </select>
	            <span class="btn" onclick="search_img(this);">搜索</span></div>
	            <ul class="img_list clearfix" id="picture_list">
	          
	            </ul>
	            <div class="zancun_img"><input type="hidden" id="zancun"><ul id="zancun_img_list"></ul></div>
	            <div class="pagination picture_page"></div>
	            <div class="queren"><span onclick="queren_choice(this);" class="btn">确认</span></div>
	        </div>
   	</div>
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
<div id="xiuxiu_box" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<script type="text/javascript" src="<?php echo base_url();?>assets/ht/js/common/common.js"></script>
<!--景点的设置end-->
<!--<script src="<?php echo base_url('assets/js/picture_choice_box.js')?>"></script> -->
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.dateTable.js')?>"></script>
<link href="<?php echo base_url('assets/css/product.css')?>" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<!-- 加载编辑器 -->
<script src="<?php echo base_url() ;?>assets/js/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ueditor/ueditor.all.min.js"></script>
<!--日期控件的插件 -->
<link href="<?php echo base_url();?>assets/js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/calendar/dateFun.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/calendar/Calendarn.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/calendar/CalendarCfg.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<!-- 多图片上传的插件 -->
<script src="<?php echo base_url('assets/js/diyUpload0.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/webuploader.min.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 
 <!-- 城市数据 如果没有就空值  必须为数组   数组4个值  -->
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<!-- 出发地 -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<!--景点设置-->
<?php echo $this->load->view('admin/b1/common/scenic_script'); ?>
<script type="text/javascript">	
$(document).ready(function() { 
	var line_classify=<?php if(!empty($data['line_classify'])){ echo $data['line_classify'];}else{ echo 0;} ?>; 
            get_city(line_classify); //加载出发地和目的地
            //出发城市获取
	var startcity=$('#lineCityId').val();
	if(startcity==''){
		startcity=0;
	}
            get_dest(line_classify,startcity);//加载目的地
}); 
<!------------------------------------设置价格------------------------------------------- -->			             
(function(){
	window.priceDate = null;
	function initProductPrice(){
		var url = '<?php echo base_url()?>admin/b1/product/getProductPriceJSON';
		priceDate = new jQuery.priceDate({  record:'', renderTo:".cal-manager",comparableField:"day",
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
					if(data){
						dayid = data.dayid;
						childnobedprice = data.childnobedprice;
						
						adultprice=data.adultprice;
						childprice=data.childprice;
						number = data.number;
						oldprice = data.oldprice;
					}

					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="price"' );
					var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled"" readonly="readonly"' : 'class="day"' );
					var html = '<div class="day"><span><label class="dayNum">'+settings.day+'</a>'+getCopyDown(settings.isLastRow)+'</label></span><span class="num"><input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input '+ flag +' value="'+dayid+'" type="hidden" name="dayid">空位<input style="text-align:right" type="text" '+ flag +' value="'+number+'" name="number">份</span></div>';
					//html = html + '<div class="cell-price">¥<input type="text" style="width: 52px;" '+(settings.disabled ? '':'placeholder="市场参考价"' )+' '+ flag +' value="'+refprice+'"  size="4" name="refprice">元</div>';
					html = html + '<div class="cell-price">¥<input type="text" style="width: 70px;"'+(settings.disabled ? '':'placeholder="成人价"' )+' '+ flag +' value="'+adultprice+'"  size="4" name="adultprice">元</div>';
		        			html = html +'<div class="cell-price">¥<input type="text" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩占床"' )+' '+ flag +' value="'+childprice+'" size="4" name="childprice">元</div>';
		        			html = html +'<div class="cell-price">¥<input type="text" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩不占床"' )+' '+ flag +' value="'+childnobedprice+'" size="4" name="childnobedprice">元</div>';
		        			html = html +'<div class="cell-price">¥<input type="text" style="width: 70px;" '+(settings.disabled ? '':'placeholder="老人价"' )+' '+ flag +' value="'+oldprice+'" size="4" name="oldprice">元</div><div class="cell-price">';
		        			/*html = html +'销售:<input type="radio" name="is_sell" value="1" class="price" style="opacity: 1;position: static;width:15px;">是<input type="radio" name="is_sell" value="1" class="price" style="opacity: 1;position: static;width:15px;" >否</div>';*/
		        			//html = html +'<select '+flag+' style="font-weight:1;width:74px;" ><option value="1">销售</option><option value="0">停售</option></select>';
		        			return html;
				},dayFormatter1:function(settings,data){
					var dayid= '';
					var number= '';
					var adultprice= '';
					var childprice= '';
					var childnobedprice = '';
					var groupId='';
					var oldprice='';
					if(data){
						dayid = data.dayid;
						childnobedprice = data.childnobedprice;
						adultprice=data.adultprice;
						childprice=data.childprice;
						number = data.number;
						oldprice = data.oldprice;
					}
					var flag = ( settings.disabled ? ' class="disableText" disabled="disabled" readonly="readonly"' : 'class="price"' );
					var day_flag = ( settings.disabled ? ' class="disableText" disabled="disabled" readonly="readonly"' : 'class="day"' );
					var html = '<div class="day"><span><label class="dayNum">'+settings.day+'</a>'+getCopyDown(settings.isLastRow)+'</label></span><span class="num"><input '+ day_flag +' value="'+settings.date+'" type="hidden" name="day"><input '+ flag +' value="'+dayid+'" type="hidden" name="dayid">数量<input style="text-align:right" type="text" '+ flag +' value="'+number+'" name="number">份</span></div>';
					//html = html + '<div class="cell-price">¥<input type="text" style="width: 52px;" '+(settings.disabled ? '':'placeholder="市场参考价"' )+' '+ flag +' value="'+refprice+'"  size="4" name="refprice[]">元</div>';
					html = html + '<div class="cell-price">¥<input type="text" style="width: 70px;" '+ flag +' value="'+adultprice+'"  placeholder="套餐价格" size="4" name="adultprice">元</div>';
		        			html = html +'<input type="hidden" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩占床"' )+' '+ flag +' value="'+childprice+'" size="4" name="childprice">';
		        			html = html +'<input type="hidden" style="width: 70px;" '+(settings.disabled ? '':'placeholder="小孩不占床"' )+' '+ flag +' value="'+childnobedprice+'" size="4" name="childnobedprice">';
		        			html = html +'<input type="hidden" style="width: 70px;" '+(settings.disabled ? '':'placeholder="老人价"' )+' '+ flag +' value="'+oldprice+'" size="4" name="oldprice">';
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
             var agent_rate = $('#agent_rate').val();
	if(''==agent_rate){
		alert("管家佣金填写不能为空");
		$('#agent_rate').focus();
		return false;
	}else{
		if(isNaN(agent_rate) || agent_rate<0){
			alert("管家佣金填写价格必须大于0");
			return false;
		}
	}  

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
	    	 if(realLength>15){
		    	alert('儿童占床说明已经超过15个字');
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
	     	if(realLength>15){
		     	alert('儿童不占床说明已经超过15个字');
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
	     	if(realLength>15){
		     	alert('老人价说明已经超过15个字');
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
	     	if(realLength>15){
		     	alert('特殊人群说明已经超过15个字');
		     	return false;
		} 
	 }	 
		var a = true;
		$(".cell-price  input[class=price]").each(function(index){
			var adultPrice= $(this).val(); 
			if(!isIntGreatZero(adultPrice)){
				 alert("价格只能是大于等于0的整数价格,您输入的 "+adultPrice+" 有误");
				//找到月份，月份的tab点击一下。
				var node =$(this).parent().parent().find("input[name='day']");
				var date=$(node).val() ;
				date=date.substr(0,8)+"01";		
				$("li[data="+date+"]").click();
				 
		    	 	$(this).focus();
		    		a = false;
		    		return false;
			}  
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
                                    $('#sb_rout,#next_rout').addClass("disabled");
                                },
                                complete:function(){//ajax请求结束时操作
                                    $('#sb_rout,#next_rout').removeClass("disabled");
                                },
			success : function(response) {
				var response = eval('(' + response + ')');
				if(response.status==1){
					alert( '保存报价成功！' ); 
					jQuery('.selected').attr("packageId",response.suitId);
					jQuery('.selected').attr("suitId",response.suitId);
				   	jQuery( 'input[name="suitId"]').val(response.suitId);
				   	if(index==1){     //下一步
						$("#set_price").removeClass('active');
						$("#profile10").removeClass('active');
						$("#click_feedesc").css('display','block');
						$("#click_feedesc").addClass('active');
						$("#profile14").addClass('active');  
					}
				    	priceDate.loadData();
				}else{
					 alert( '保存失败' );
				}
			}
		});
	    return false;
	});	
})();

<!------------------------------------设置价格 end--------------------------------------------->
//保存基础信息
//function CheckLine(){　 
jQuery('#sb_line,#next_line').click(function(){
     var flag = COM.repeat('btn');//频率限制
    if(!flag)
    {
	var linename = $('#lineprename');
	if(''==linename.val()){
		alert('线路名称不能为空');
		linename.focus();
		return false;
	}else{    
		//不能超过36个字
	   	var num1 = $("#lineprename").val().length;
		var num2 = $("#linetitle").val().length;
		var num3 =$("#brand").val().length;
		num = num1+num2+num3+5;
		if(num>50){
			alert('提示:线路名称和副标题的总字数已超过50个字');
			return false;
		}
	}
     
  	 var  linetitle=$('#linetitle');
   	if(''==linetitle.val()){
	  	alert('副标题不能为空');
	 	linetitle.focus();
		return false;	
	 }
	var data_num = $('#data_num');
	if(''==data_num.val()){
		data_num.focus();
		return false;
	}
	//行程天数的判断
	var data_num=$('#data_num').val();
	if(isNaN(data_num) || data_num<0){
		alert("行程天数填写格式不对");
		return false;
	}
	var data_night = $('#data_night').val();
	if(isNaN(data_night) || data_night<0){
		alert("行程天数填写格式不对");
		return false;
	}else{
		if(data_num>31){
			alert('行程天数的天数不能超过31天');
			return false;
		}
	}
	//出发地不能为空
	var startcity=$('#lineCityId').val();
	if(startcity==''){
		alert('出发地不能为空！');
		return false;
	}
	var formcity=$('#formcity').val();

	if(formcity==''){
		alert('请选择出发地下拉菜单的出发地！');
		return false;
	}
	//限制目的地的选择
	var overcitystr=$('#overcitystr').val();
	if(overcitystr==''){
		alert('目的地不能为空！');
		return false;
	}
           var linebefore=$('input[name="linebefore"]').val();
           if(linebefore==''){
                    alert('提前报名的天数不能为空');
                    return false;
           }
	var line_pics_arr=$('#ThumbPic').find('li').length;
	if(line_pics_arr<1){
		alert('线路宣传图不能为空！');
		return false;
	} 
	var i=$('#ThumbPic').find('li').hasClass('list_click');
	if(i==false){
		alert('线路宣传图的主图片不能为空！');
		return false;
	} 
	 var ue = UE.getEditor('name_list');
	 str = ue.getContentTxt();  
	
	 if(str<=0){
		 alert('线路特色不能为空！');
		 return false;
    	 }else{	
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var i = 0; i < len; i++) {
		 charCode = str.charCodeAt(i);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 }
		 
	    	 if(realLength>600){
		     	alert('线路特色的字符的数量不能超过600个字');
		     	return false;
		 }
    	 }

	 var index=$(this).index();　
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineInfo').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateLine", 
                    beforeSend:function() {//ajax请求开始时的操作
                        $('#sb_line,#next_line').addClass("disabled");
                    },
                    complete:function(){//ajax请求结束时操作
                        $('#sb_line,#next_line').removeClass("disabled");
                    },
		success : function(response) {
			var obj = eval('(' + response + ')');
			if(obj.status==1){
				alert( '保存线路的基础信息成功！' );
				//下一步行程安排
				if(index==2){
					$("#routting").click();	
					$("#basc").removeClass('active');
					$("#home11").removeClass('active');
					$("#scheduling").css('display','block'); 
					$("#profile12").addClass('active');
					$("#scheduling").addClass('active');
				}			
	
				//遍历图片
				if(obj.imgurl_str!=''){
				    	var pic=obj.imgurl_str;
				    	var html='';
				    	$.each(pic, function(key, val) {
					    	if(val!=''){
						    	if(obj.mainpic==val['filepath']){ 						    	
						    		html+='<li class="list_click" style="">'; 
						    		var zhutu='<div class="weixuanzhong" style="display:none"></div>';
							    }else{
							    	html+='<li class="" style="">';
							    	var zhutu='<div class="weixuanzhong"></div>';
								}
							    html+='<div class="img_main0">'; 
							    html+='<div class="float_img" id="del_img"  onclick="del_line_imgdata(this,'+val['pid']+')">×</div>'; 
							    html+='<div style="height:60px;"><img  style="height:100%;" src="'+val['filepath']+'"></div>'; 
							    html+='</div>';
							    html+='<div class="zhutu">设为主图片</div>'+zhutu; 
							    html+='</li>';	
						}
				    	})
				    	 $("#ThumbPic").html(html);
				} 
			}else{
				alert( obj.msg );				
			} 
		}
	});
	return false;
    }
});
//添加管家培训
$(".train_btn").on('click', function () {

	var l=$(".problem_div").length - 1;
	var n=$(".problem_div").length +1;
	var train_html ='<div class="problem_title fl"> <span  class="num">问题'+n+'</span><input type="hidden"  name="train_id[]" value=""/></div>';
	train_html=train_html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]" placeholder="请输入热门问题"><i class="icon icon_1"  onclick="del_train(this,-1)"></i></div>';
	train_html=train_html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
	train_html=train_html+'<div class="problem_answer"><label>A：</label><textarea name="answer[]" placeholder="请输入参考答案"></textarea></div>';

	if(l==-1){    
		var trlen = $(".problem_content");           
		trlen.html("<div class='problem_div'>"+train_html+"</div>"); 
	}else{
		var trlen = $(".problem_div").eq(l);           
		trlen.after("<div class='problem_div'>"+train_html+"</div>"); 
	}
	$('.icon_1').hover(function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').show();
	},function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').hide();
	});    
     
});
//删除管家培训
function del_train(obj,id){    
	var index = $(".icon_1").index(obj);
	if(id!='' && id>0){
		if (!confirm("确定要删除？")) {
	            	window.event.returnValue = false;
	        	}else{
			jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/deleteTrain",
				success : function(response) {
					if(response){
						alert('删除成功！');
						$(".problem_div").eq(index).remove();
						$(".problem_div").each(function(i){
							var index = $(".problem_div").index(this);
							//var num = parseInt($(this).find(".num").html());
							$(this).find(".num").html('问题'+(index+1));
						});
					}else{
						alert('删除失败！');
					}
				}
			});
	       	 }
	}else{
		//alert('删除成功！');
		$(".problem_div").eq(index).remove();
		$(".problem_div").each(function(i){
			var index = $(".problem_div").index(this);
			//var num = parseInt($(this).find(".num").html());
			$(this).find(".num").html('问题'+(index+1));
		});
	}	
}

//行程安排
jQuery("#myTab11").on("click",'.routting',function(){　 
	// $("#rout_line").html('');
    	var type='rout';
    	var id=<?php if(!empty($data['id'])){echo $data['id'];}?>;
    	var lineday=$('.LineRoutDay').val();
    	var data_num=$('input[name="data_num"]').val();
    	var flag=parseInt(data_num)-parseInt(lineday);
    	if(flag>0){
	    	$.get("<?php echo base_url()?>admin/b1/product/lookRout", { id:id,type:type,lineday:lineday,data_num:data_num} , function(result) {
				if(result){
				//	alert(data_num);
					$('.LineRoutDay').val(data_num);
					//$('#line_beizhu').remove();
					$("#rout_line").append(result);	
					var img_arr='';			
				   	var day_id=$('#lineday').val();		
		 		 	$('.title_div').each(function(){
		 		 		var title  = jQuery(this);
		 		 		if($.trim(title.html())==''){
		 		 			title.next('div').show();
		 		 		}else{
		 		 			title.next('div').hide();
		 		 		}	
		 		 	}) 	       
				}else{	
					//$('#line_beizhu').remove();
					$("#rout_line").html(result);			 	
				}	  
			});
     	}else{

     		$('.LineRoutDay').val(data_num);
    		var TwoFlag=parseInt(lineday)-parseInt(data_num);
    		var data_num=parseInt(data_num);
     		if(TwoFlag>0){
		         	for (var i = data_num; i < lineday; i++){
	             		$('.line_rout_comment'+i).remove();
	             	}
         		}    	
       	 }
    });
    
//行程安排的提交表单
//function CheckRouting(){
//jQuery('#sb_rout,#next_rout').click(function(){
    function CheckRouting(index){
		var daynum=$('input[name="data_num"]').val();
		if(daynum!=''&& daynum!='0'){
			for(var i=0;i<daynum;i++){ 
				//行程内容
				var n=0;
				n=i+1;
				var username= $('#username'+i)
				if(''==username.val()){
					alert('第'+n+'天标题不能为空！');
					//return false;
				}
				var transport=$("input[name='transport["+i+"]']").val();
				if(transport!=''){
					//不能超过100个字
					 var str=transport;
					 var realLength = 0, len = str.length, charCode = -1;
					 for (var a = 0; a < len; a++) {
					 charCode = str.charCodeAt(a);
					 if (charCode >= 0 && charCode <= 128)
					 		realLength += 1;
					 		else realLength += 1;
					 }
					 
				     	if(realLength>100){
					    	var n=0;
				    	 	n=i+1;
					     	alert('第'+n+'天城市间交通的描述不能超过20个字');
					     	return false;
					 }
				}
				
				//早餐
				var breakfirst=$("input[name='breakfirst["+i+"]']").val();
				if(breakfirst!=''){
					//不能超过10个字
					 var str=breakfirst;
					 var realLength = 0, len = str.length, charCode = -1;
					 for (var a = 0; a < len; a++) {
					 charCode = str.charCodeAt(a);
					 if (charCode >= 0 && charCode <= 128)
					 		realLength += 1;
					 		else realLength += 1;
					 }
					 
				    	 if(realLength>15){
					    	var n=0;
				    	     	n=i+1;
					     	alert('第'+n+'天早餐的描述不能超过15个字');
					    	return false;
					 }
				}
		
				//午餐
				var lunch=$("input[name='lunch["+i+"]']").val();
				if(lunch!=''){
					//不能超过200个字
					 var str=lunch;
					 var realLength = 0, len = str.length, charCode = -1;
					 for (var b = 0; b < len; b++) {
					 charCode = str.charCodeAt(b);
					 if (charCode >= 0 && charCode <= 128)
					 	realLength += 1;
					 	else realLength += 1;
					 }
					 
				    	 if(realLength>15){
				    		var n=0;
				    	    	n=i+1;
					    	alert('第'+n+'天午餐的描述不能超过15个字');
					     	return false;
					 }
				}
				//晚餐
				var supper=$("input[name='supper["+i+"]']").val();
				if(supper!=''){
					//不能超过15个字
					 var str=supper;
					 var realLength = 0, len = str.length, charCode = -1;
					 for (var c = 0; c < len; c++) {
					 charCode = str.charCodeAt(c);
					 if (charCode >= 0 && charCode <= 128)
					 	realLength += 1;
					 	else realLength += 1;
					 }
					 
				     	if(realLength>15){
				    	       var n=0;
				    	       n=i+1;
					       alert('第'+n+'天晚餐的描述不能超过15个字');
					       return false;
					 }
				}
				var hotel=$("input[name='hotel["+i+"]']").val();
				if(hotel!=''){
					//不能超过200个字
					 var str=hotel;
					 var realLength = 0, len = str.length, charCode = -1;
					 for (var c = 0; c < len; c++) {
					 charCode = str.charCodeAt(c);
					 if (charCode >= 0 && charCode <= 128)
					 	realLength += 1;
					 	else realLength += 1;
					 }
					 
				     	if(realLength>200){
				    		 var n=0;
				    	 	 n=i+1;
					    	 alert('第'+n+'天住宿的描述不能超过200个字');
					     	 return false;
					 }
				}
				
				var editor_id= $('#editor_id'+i);
				if(''==editor_id.val()){
					var n=i+1;
		           			alert('第'+n+'行程内容不能为空');
					//return false;
				}
				var pic_ar = $("input[name='line_pic_arr["+i+"]']").val();
				if(pic_ar !=''){
					var n=i+1;
					var imgdata_arr=pic_ar.split(";");
					if(imgdata_arr.length>7){
						alert('第'+n+'天的行程图片最多只能上传6张');
						return false;
					}
				}
			}
		}
                       //   var index=$(this).index();　
		jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineDayForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateRouting", 
                                beforeSend:function() {//ajax请求开始时的操作
                                    $('#sb_rout,#next_rout').addClass("disabled");
                                },
                                complete:function(){//ajax请求结束时操作
                                    $('#sb_rout,#next_rout').removeClass("disabled");
                                },
			success : function(response) {	
			 	 if(response>0){
		
	 		 		alert( '保存行程成功！' ); 
                                                                   if(index==2){
                                                                	//下一步
            						$("#scheduling").removeClass('active');
            						$("#profile12").removeClass('active');
            						$("#set_price").css('display','block'); 
            						$("#set_price").addClass('active');
            						$("#profile10").addClass('active');	
                                                                }
				
		 		 	 //遍历行程
		 			var id=" <?php  if(!empty($data['id'])){echo $data['id']; }else{ echo 0;}?> ";
		 		//	alert(id);
	 			   	jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/getLineRoutData",
		 			   	success : function(result) {	
		 				 	$('#rout_line').html(result);
							var img_arr='';			
						   	var day_id=$('#lineday').val();		
				 		 	$('.title_div').each(function(){
				 		 		var title  = jQuery(this);
				 		 		if($.trim(title.html())==''){
				 		 			title.next('div').show();
				 		 		}else{
				 		 			title.next('div').hide();
				 		 		}	
				 		 	})
		 			   	}
	 		 	    	});
	
				}else{
					if(response){
						alert( '保存行程失败！' );
                                                                return false;
					}
					//下一步
					$("#scheduling").removeClass('active');
					$("#profile12").removeClass('active');
					$("#set_price").css('display','block'); 
					$("#set_price").addClass('active');
					$("#profile10").addClass('active');
				}   
			}
		});
	
	return false;
}
//});
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
    	jQuery("input[name='old_price']").val('');  
    			
	$(".closetd").click(function(e) {
	       $(".bgsd,.tbtsdgk").hide();
	}); 

}
//费用说明的提交表单
//function CheckFee(){
jQuery('#sb_fee,#next_fee').click(function(){
  	 var feeinclude=$('#feeinclude').val();
  	 if(feeinclude==0){
  		alert('费用包含不能为空！');
		 return false;
	  }
	 var feenotinclude=$('#feenotinclude').val();
  	 if(feenotinclude==0){
  		 alert('费用不包含不能为空！');
		 return false;
	  }
	  var index=$(this).index();　
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineFeeForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updatelineFee", 
		success : function(response) {			
		 	 if(response!='' && response!='0'){ 	 
				alert( '保存成功！' );	
				if(index==2){
                                                                    	//下一步				
					$("#click_feedesc").removeClass('active');
					$("#profile14").removeClass('active');
					$("#click_Bookings").css('display','block'); 
					$("#click_Bookings").addClass('active');
					$("#profile16").addClass('active'); 
				}
	
			}else{
				alert( '保存失败' );
			}   
		}
	});
	return false;
});

//参团须知 的提交表单
jQuery('#sb_linenotice,#next_linenotice').click(function(){
//function ChecklineNotice(){
	    var editor=$('#editor').val();
	    if(editor==''){
	   	         alert('温馨提示内容不能为空');
		         return false;
	      }
	     var special_appointment=$('#special_appointment').val();
	     if(special_appointment==''){
	    	 alert('特别约定不能为空');
		 return false;
	     }

	     var safe_alert=$('#safe_alert').val();
	     if(safe_alert==''){
	    	 	alert('安全提示内容不能为空！！');
			 return false;
	      }
		var index=$(this).index();　
		jQuery.ajax({ type : "POST",async:false, data : jQuery('#lineNoticeForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateBookNotice", 
			success : function(response) {		
			 	 if(response!='' && response!='0'){
					alert( '保存成功！' ); 
					if(index==2){
						 //下一步			
						$("#click_Bookings").removeClass('active');
						$("#profile16").removeClass('active');
						$("#click_tips").css('display','block');
						$("#click_tips").addClass('active');
						$("#profile15").addClass('active');		
					}
			
				}else{
					alert( '保存失败' );
				}   
			}
		});
	
	return false;
});

//产品标签
//function updateLabel(){
jQuery('#sb_label,#next_label').click(function(){
	//限制线路属性的选择
	var linetype=$('#linetype').val();
	if(linetype==''){
		alert('线路属性不能空！');
		return false;
	}
	 var index=$(this).index();　
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineLabelForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/lineLabelForm", 
		success : function(response) {
		 	 if(response!='' && response!='0'){	 	 
				alert( '保存成功！' );
				if(index==2){
					//下一步						
					$("#click_tips").removeClass('active');
					$("#profile15").removeClass('active');
		
					$("#expert_training").addClass('active');
					$("#profile17").addClass('active'); 
				}
			
			}else{
				alert( '保存失败' );
			}   
		}
	});
	
	return false;
});
//温馨提示
//function ChecklineTrain(){	
jQuery('#sb_linetrain,#next_inetrain').click(function(){
	 var index=$(this).index();　
	var html='';
		jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineTrainForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateTrain", 
			success : function(response) {
			 var response=eval("("+response+")");
			  if(response.status==1){
				   
				var train_len= response.train.length
				$.each(response.train,function(n,value) {
				    	html=html+'<div class="problem_div"><div class="problem_title fl">';
					html=html+'<span class="num">问题'+(n+1)+'</span>'; 
					html=html+'<input type="hidden"  name="train_id[]" value="'+value.id+'"/></div>';
					html=html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]"  value="'+value.question+'" placeholder="请输入热门问题">';  
					html=html+'<i class="icon icon_1"   onclick="del_train(this,'+value.id+')"></i></div>';  
					html=html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
					html=html+'<div class="problem_answer"><label>A：</label>';
					html=html+'<textarea name="answer[]" placeholder="请输入参考答案">'+value.answer+'</textarea></div></div>';    
				})
				if(train_len>10){
					$('.problem_content').html(html);
				}else{
					var len=train_len;
					for(var i=10;train_len<i;i--){
						len=len+1;
					    	html=html+'<div class="problem_div"><div class="problem_title fl">';
						html=html+'<span class="num">问题'+len+'</span>'; 
						html=html+'<input type="hidden"  name="train_id[]" value=""/></div>';
						html=html+'<div class="hot_problem"><label>Q：</label><input  type="text" name="question[]"  value="" placeholder="请输入热门问题">';  
						html=html+'<i class="icon icon_1"   onclick="del_train(this,"")"></i></div>';  
						html=html+'<div class="delete_bomb"><span>点击按钮,删除此问题</span></div>';
						html=html+'<div class="problem_answer"><label>A：</label>';
						html=html+'<textarea name="answer[]" placeholder="请输入参考答案"></textarea></div></div>';    
					}
					$('.problem_content').html(html);
				}
				alert(response.msg);

				if(index==3){
					//下一步						
					$("#expert_training").removeClass('active');
					$("#profile17").removeClass('active');
		
					$("#supplierGift").addClass('active');
					$("#profile13").addClass('active');
				}
					//window.location.href="/admin/b1/product";
				//	window.opener.location.reload(); 	 
				}else{
					alert(response.msg);  
				}   
			}
		});
	return false;
});
//保存礼品
function ChecklineGift(){
	 jQuery.ajax({ type : "POST",data : jQuery('#lineGiftForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/save_gift_data", 
		 success : function(data) {	
			 var data=eval("("+data+")");
			 if(data.status==1){
				 alert(data.msg);
				//  window.location.href="/admin/b1/product";
				  window.close();
				//  window.opener.location.reload(); 
			 }else{
				alert(data.msg);
			}
		}
	});	 
	return false;
}

 //录入批量价格
function updataPrice(obj){ 
	 
	var people= obj.people.value; // 市场价
	var adult_price= obj.adult_price.value;  //成人价 
	var chil_price= obj.chil_price.value;	//儿童价
	var chil_nobedprice= obj.chil_nobedprice.value;
	var old_price= obj.old_price.value;
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
	 if(old_price!=''){
	         if(!(/^[0-9]+$/g.test(old_price))){
	       	  	alert('老人价只能是正整数');
	              	return false;
	          }   
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
	   jQuery.ajax({ type : "POST",data : jQuery('#applyPrice').serialize(),url : "<?php echo base_url()?>admin/b1/product/updataSuitPrice", 
                            
		success : function(response) {
 			var response=eval("("+response+")");
			 if(response.status==1){  
				 priceDate.loadData();
				// $('.cal-manager').find('.package-tab').eq(0).click();  
			 }else{
				 alert('日期价格插入表里出错,需要重新保存');
			 }	
		}
	  });
	$('.closetd').click();
	return false;
//	var start = new Date().getTime();//起始时间
/*   	$("td").each(function(i){
    		var day=jQuery(this).find("input[name='day']").val();	
    	   	var val=jQuery(this).find("input[name='day']").attr("disabled");
    	   	//alert();
    	    	if(val!='disabled'){     
    			if (typeof(day) != "undefined") {
		      		 if($.inArray(day,startDateArr) !=-1){
		    	      	        	jQuery(this).find("input[name='adultprice']").val(adult_price); 
		    	     	        	jQuery(this).find("input[name='childprice']").val(chil_price); 
		    	     	        	jQuery(this).find("input[name='number']").val(people); 
		    	     	        	jQuery(this).find("input[name='childnobedprice']").val(chil_nobedprice);
		    	     	        	jQuery(this).find("input[name='oldprice']").val(old_price);  	
                			} 
    			}  
    	  	}
    	}); */
/**/
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


var route_obj = null;
jQuery("#rout_line").on("click", ".title_div",function(){
	if(jQuery(this).attr('name')=='title'){
		route_obj = jQuery(this);
		var top = route_obj.offset().top+route_obj.outerHeight();
		var left = route_obj.offset().left;
		jQuery("#route_div").css({left : left,top : top});
		jQuery("#route_div").show()
	}
});

jQuery("#route_div").on("click", ".route img",function(){
	var v = jQuery(this).parent().html();
	insertNodeOverSelection(route_obj[0],jQuery(this)[0]);
	route_obj.next().hide();
 	//jQuery("#route_div").hide();
});


//移入
jQuery("#rout_line").on("mouseenter", ".title_div",function(){
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

//隐藏交通工具
jQuery("#rout_line").on("mouseleave", ".title_div",function(){
	routeTimeout = setTimeout("hideRoute();", 500);
});

//移除交通工具层 隐藏
jQuery("#route_div").mouseenter(function(){
	if(routeTimeout){
		clearTimeout(routeTimeout);
	}
});

//移除交通工具层 隐藏
jQuery("#route_div").mouseleave(function(){
	routeTimeout = setTimeout("hideRoute();", 500);
});

//隐藏交通工具
function hideRoute(){
	jQuery("#route_div").hide();
}
var routeTimeout = null;
//离开赋值
jQuery("#rout_line").on("DOMNodeInserted", ".title_div",function(){
	var me = jQuery(this);
	var val = me.html();
//	me.next('input').val(val.replace(/\"/g,"'"));
	var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头      
   	 var end_ptn = /[ | ]*\n/g;            //过滤标签结束  
    	var space_ptn = /&nbsp;/ig;          //过滤标签结尾
    	var c1 = val.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
 //	me.html(c1);
 	me.nextAll('input').eq(0).val(c1); 
});  

jQuery("#rout_line").on("blur", ".title_div",function(){
	var me = jQuery(this);
	var val = me.html();
//	me.next('input').val(val.replace(/\"/g,"'"));
	var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头      
	var end_ptn = /[ | ]*\n/g;            //过滤标签结束  
	var space_ptn = /&nbsp;/ig;          //过滤标签结尾
	var c1 = val.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
	//me.html(c1);
	me.nextAll('input').eq(0).val(c1); 
});  


function change(obj) {
   	 var text = obj.value;   // 获取input的值
    	obj.value ='';  
}

</script>


<?php echo $this->load->view('admin/b1/common/citylist_script'); ?>	
 <script type="text/javascript">
 jQuery(document).ready(function() {
 	
 	/*------------------------------------------------主题游-------------------------------------------------------*/
 	var labelFromtheme = new Array();
 	labelFromtheme ['主题游'] = new Array(<?php if(!empty($themeData)){ echo $themeData;} ?>);
 	$(function(){
 	 	//formcity
 	             //#cityName 为文本框，    citysFlight城市初始化全部数据  labelFromcity 初始化TAB  //hotList热门城市
 		$('#theme-list').querycity({'data':themeFlight,'tabs':labelFromtheme,'hotList':'',onchange:function(id,val){
	 	 	//添加主题游
			$('#theme-list').find('a[name="delDestLable"]').remove();  
			$('input[name="theme"]').val(id);	
			$('#theme_arr').html(val); 
			$('#theme-list').append('<a name="delDestLable" data="'+id+'" href="###">×</a>'); 
			$('#theme_arr').css('color','#fff');   	  
 		}});
 	});
 	
 });
 //主题游
  $('#theme-list').on("click", 'a[name="delDestLable"]',function(){
	  var html='选择主题游';
	  $('input[name="theme"]').val('');	
   	  $('#theme_arr').html(html); 
   	  $('#theme-list').find('a[name="delDestLable"]').remove();  
  })

// 删除table
 $('#ds-list').on("click", 'a[name="delDestLable"]',function(){
        var id= $(this).attr('data');
        var value=$("input[name='overcity2']").attr('value');
        $("#ds-"+id).remove();
        if(value!=''){
        	var id_arr=value.split(",");
        	var id_str='';
  	for (var i = 0; i < id_arr.length; i++) {
	           if (id_arr[i] != id) { 
	                    if(i < id_arr.length-2){
	                    		id_str=id_str+id_arr[i]+','; 
	                    }else{
	                    		id_str=id_str+id_arr[i];  
	                    }
	           }
      	 }
  	 $("input[name='overcity2']").val(id_str); 
        }
  })
  
 /*------------------------------------------------线路属性-------------------------------------------------------*/ 
 jQuery(document).ready(function() {
	 
	 jQuery('.attr-item').on("click",function(){

		 var me = jQuery(this);
		 if(me.hasClass('attr-item-selected')){
			jQuery(this).removeClass('attr-item-selected');
			var dataid=jQuery(this).attr('dataid');
			var linetyle=$('input[name="linetype"]').val();
			//alert(dataid);
			var tyle_arr=linetyle.split(",");
             		var id_str='';
		      	for (var i = 0; i < tyle_arr.length; i++) {
			           if (tyle_arr[i] != dataid) { 
				           	if(tyle_arr[i]!=''){
				           	 	if(id_str!=''){
						            id_str=id_str+','+tyle_arr[i]; 
						}else{
						            id_str=id_str+tyle_arr[i];  
						}
				           	}      
			          }
      	  	 	}
			 $('input[name="linetype"]').val(id_str);
			 
		 }else{
			 var attr_len=$('.pop_city_container').find('.attr-item-selected').length;
			 if(attr_len>7){
                			alert('你选择的产品标签已经超过8个了');
                 			return false;
			 }else{
				 jQuery(this).addClass('attr-item-selected')
				 var dataid=jQuery(this).attr('dataid');
				 var linetyle=$('input[name="linetype"]').val();
				 var id_str='';
				 
				if(linetyle!=''){
					id_str=linetyle+','+dataid;
				}else{
					id_str=dataid;
				}
				$('input[name="linetype"]').val(id_str);
			 }
		 }
	 });

	 
 });
//删除table
 $('#attr-list').on("click", 'a[name="delAttrLable"]',function(){
        	var id= $(this).attr('data');
        	var value=$("input[name='linetype']").attr('value');
       	$("#ds-"+id).remove();
        	if(value!=''){
        		var id_arr=value.split(",");
        		var id_str='';
	  	for (var i = 0; i < id_arr.length; i++) {
	                 	if (id_arr[i] != id) { 
		                   	if(i < id_arr.length-2){
		                    		id_str=id_str+id_arr[i]+','; 
		                   	}else{
		                    		id_str=id_str+id_arr[i];  
		                  	}
	                	}
	      	}
  	 	$("input[name='linetype']").val(id_str); 
       	}
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
 
//选保险
$("#sel_insure").on('click', function () {
	var id=$(this).attr("checked");
 	if(id=='checked'){
 		$('.form-insure').css('display','block');
	}else{
		$('.form-insure').css('display','none');
	} 
})
$('input[name="insure_data[]"]').on('click', function () {
	var id=$(this).attr("checked");
	if(id!='checked'){
		var i=$(this).parent('.col-sm-10').find('input[name="isdefault"]').attr("checked",false);
	}
})
$('input[name="isdefault"]').on('click', function () {
	var a=$(this).attr('checked')
	if(a=='checked'){
		var b=$(this).parent('span').parent('.col-sm-10').find('input[name="insure_data[]"]').attr("checked");
		if(b!='checked'){
			alert('请选择默认值对应的保险,再选默认值');
			$(this).attr('checked',false);
		}
	}
})

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
		 if(titleDiv.html().trim()==''){ 
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

function chk(obj){
	if(obj.getElementsByTagName("img").length){
		document.getElementById('tips').textContent="";
	}
}

 //加载编辑器
 var ue = UE.getEditor('name_list'); 

//删除管家培训问题
$(function () {  
	$('.icon_1').hover(function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').show();
	},function(){
		var _this=$(this);
		_this.parent().siblings('.delete_bomb').hide();
	});
})
 /*------------------------------------------------选择目的地-------------------------------------------------------*/          
function get_dest(type,startcity){
	var line_classify=type;
	$.post("/common/area/getRoundTripData",{'startcity':startcity},function(json) {
		var data = eval("("+json+")");
		var myArray = new Object();
		if(line_classify==3){  //周边游		
			myArray.trip=data;
		}else if(line_classify==2){ //国内游
			myArray.domestic= chioceDestJson.domestic;
		}else if(line_classify==1){ //境外游
			myArray.abroad=chioceDestJson.abroad;
		}else{
			var line_type=<?php  if(!empty($line_type)){ echo $line_type;}else{ echo 0;} ?>;
			if(line_type==1){
                                                myArray.abroad=chioceDestJson.abroad;
			}else{
				myArray.domestic= chioceDestJson.domestic;
			}
		//	alert(line_type);
		}

		createChoicePlugin({
			data:myArray,
			nameId:"overcityArr",
			valId:"overcitystr",
			width:640,
			number:11,
			buttonId:'ds-list'
		});
	});
	return false;
}
function get_city(line_classify){
	if(line_classify==3){
		//出发城市获取
		var startcity=$('#lineCityId').val();
		if(startcity==''){
			startcity=0;
		}
		createChoicePluginPY({
			data:chioceStartCityJson,
			nameId:'startcity',
			valId:'lineCityId',
			width:500,
			isHot:true,
			hotName:'热门城市',
			//blurDefault:true,
			isCallback:true,
			callbackFuncName:function() {	
				var startcity=$('#lineCityId').val();
				if(startcity==''){
					startcity=0;
				}		
				//切换周边游目的地
				get_dest(line_classify,startcity);
			},
		});
		get_dest(line_classify,startcity);
		return false;

	}else{		
		//alert(line_classify);
		 //出发城市获取
		$.post("/common/area/get_line_startplace",{},function(json) {
			var data = eval("("+json+")");
			createChoicePluginPY({
				data:data,
				nameId:'startcity',
				valId:'lineCityId',
				width:500,
				isHot:true,
				hotName:'热门城市',
				number:10,
				//blurDefault:true
				buttonId:'startcity-list',
			});
		});
		get_dest(line_classify,0); //加载目的地
		return false;
	}

}
 	
$("#line_classify").change(function(){
	var id=$(this).val();
	if(id==3){
	         	$("#lineCityId").val('');
	         	$('#startcity-list').html('');
	         	$('#ds-list').html('');
	         	$('input[name="overcitystr"]').val('');
	         	get_city(id);
	}else{
	           $('input[name="startcity"]').val('');
	         	$("#lineCityId").val('');
	         	//lineCityId
	         	$('#startcity-list').html('');
	         	$('#ds-list').html('');
	         	$('input[name="overcitystr"]').val('');
	            get_city(id);  
	}
});

//删除附件
function delSpan(obj){
        $(obj).parent().parent('#attachment_list').remove();
}
//上传附件
$('#updatafile').on('click', function() {
            $.ajaxFileUpload({url:'/admin/b1/product/up_attachment',
            secureuri:false,
            fileElementId:'upfile',// file标签的id
            dataType: 'json',// 返回数据的类型
            data:{filename:'upfile'},
            success: function (data, status) {
                     if (data.status == 1) {
                          alert("上传成功");
                          var str='';
                          str=str+'<div id="attachment_list">';
                          str=str+'<span class="selectedContent" value="">'+data.urlname;
                          str=str+'<input type="hidden" id="attachment_name" name="attachment_name[]" value="'+data.urlname+'" />';
                          str=str+' <input type="hidden" id="attachment" name="attachment[]" value="'+data.url+'" />';
                          str=str+' <span class="delPlugin" onclick="delSpan(this);">x</span>';
                          str=str+'</span></div>';
                          $('.attachment_content').append(str); 
                     } else {
                          alert(data.msg);
                     }
            },
             error: function (data, status, e) {
                 alert("请选择不超过10M的doc,docx的文件上传");
            }
           });
        return false;
});
 </script>
<?php echo $this->load->view('admin/b1/common/upload_mainpic_script'); ?>
<?php echo $this->load->view('admin/b1/common/product_edit_script'); ?>

  

