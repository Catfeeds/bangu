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
   <link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/product.css" rel="stylesheet" />
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
.problem_answer label{margin-top: -100px;}
.problem_answer textarea{height: 60px;}
    </style>


<!-- /Head -->
<!-- Body -->


<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jquery-1.11.1.min.js"></script>		
 <script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.calendarTable.js')?>"></script>
</head>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" id="basc"><a href="#home11" data-toggle="tab">添加产品</a></li>	
					<!-- <li class="" id="expert_training"><a href="#profile17" data-toggle="tab"> 管家培训 </a><li> -->
					<li class="" id="scheduling"><a class="routting"   href="#profile12" data-toggle="tab" id="routting" name="rout"> 行程安排 </a></li>
					<li class="" id="set_price"><a href="#profile10" data-toggle="tab" > 设置价格 </a></li>
					<!--<li class="" id="set_stock"><a href="#profile11"  data-toggle="tab" > 库存 </a></li>	-->
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 基础信息 -->		
					<div class="tab-pane active" id="home11">	
					<form action="<?php echo base_url()?>t33Api/line/get_line" accept-charset="utf-8" enctype="multipart/form-data"  method="post" 
						id="lineInfo" novalidate="novalidate">					
						<input name="id" value="<?php  if(!empty($data['id'])){echo $data['id']; }?>" id="id" type="hidden" />
						<div class="widget-body">
							<div id="registration-form">
                            	<table class="line_base_info table_form_content table_td_border" border="1" width="100%">
                                    <tr height="34" class="form_group">
                                        <td class="form_title">线路类型：</td>
                                        <td>
                                        	<div class=" col_ip">
                                               <input type="hidden" name="linecode" value="<?php if(!empty($line->linecode)){ echo $line->linecode;} ?>">
                                               <?php  if($line->line_classify==1){
                                               	   echo '出境游';
                                               }elseif($line->line_classify==2){
                                              	   echo '国内游';
                                               }else if($line->line_classify==3){
                                               	   echo '周边游';
                                               }  ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路名称：</td>
                                        <td>&nbsp;&nbsp;
                                        	<input type="hidden" id="brand" value=""><?php if(!empty($line->sp_brand)){ echo $line->sp_brand;} ?>
                                        	<input type="text" placeholder="10字以内" value="<?php if(!empty($line->lineprename)){ echo $line->lineprename;} ?>" id="linename" class="form_input w_450" name="linename"/>
                                            <input type="text" value="<?php if(!empty($line->linenight)){ echo $line->linenight;} ?>" id="linenight" class="form_input w_40" name="linenight"/>晚
                                            <input type="text" value="<?php if(!empty($line->lineday)){ echo $line->lineday;} ?>" id="lineday" class="form_input w_40" name="lineday"/><i class="important_title">*</i>天游
                                            <span class="title_txt red">线路名称+副标题总字数不超过50个字</span>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>副标题：</td>
                                        <td><input type="text" placeholder="需重点突出的信息,20字以内" value="<?php if(!empty($line->linetitle)){ echo $line->linetitle;} ?>" id="linetitle" class="form_input w_600" name="linetitle"></td>
                                    </tr>                                   
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>出发地：</td>
                                        <td>
                                        	<input type="text" placeholder="出发地" class="form_input w_180 fl" id="startcity" name="startcity" autocomplete="off" value="<?php if(!empty($line->startcity)){ echo $line->startcity;} ?>">
                                            <input type="hidden" name="lineCityId" id="lineCityId" value="">
                                           
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>目的地：</td>
                                        <td id="select_dest">
                                        	<input type="text" placeholder="目的地" class="form_input w_180 fl" id="overcity" name="overcity" value="<?php if(!empty($line->overcity)){ echo $line->overcity;} ?>">
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title">主题游：</td>
                                        <td id="select_theme">
                                        <input type="text" placeholder="主题游" class="form_input w_180 fl" id="themeid" name="themeid" value="<?php if(!empty($line->themeid)){ echo $line->themeid;} ?>">
                                        </td>
                                    </tr>  
                                    <tr height="34" class="form_group">
                                        <td class="form_title">上车地点：</td>
                                        <td id="select_dest">
                                        	<input type="text" placeholder="上车地点" value="<?php if(!empty($line->car_address)){ echo $line->car_address;} ?>" class="form_input w_180 fl" id="car_address" name="car_address" />
                                        </td>
                                    </tr>  
                                    <tr height="34" class="form_group">
                                        <td class="form_title">提前：</td>
                                        <td>
                                              <input type="text" placeholder="" id="linebefore" class="form_input" name="linebefore" style="width: 50px;" value="<?php if(!empty($line->linebefore)){ echo $line->linebefore;} ?>"/>
                                              <span>天</span>
                                              <input type="text" placeholder="" id="linedatehour" class="form_input" name="hour" style="width: 50px;" value="<?php if(!empty($line->hour)){ echo $line->hour;} ?>"/>
                                              <span> 小时</span>
                                              <input type="text" placeholder="" id="linedateminute" class="form_input" name="minute" style="width: 50px;"  value="<?php if(!empty($line->minute)){ echo $line->minute;} ?>"/>
                                              <span> 分 截止报名</span>
                                        </td>
                                    </tr>  

                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路特色：</td>
                                        <td>
                                        	<textarea placeholder="其他显示信息(600字以内)" style="width:300px;height:120px;" class="noresize w_600"  id="features" name="features"><?php if(!empty($line->features)){ echo $line->features;} ?></textarea>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>主图片：</td>
                                        <td>
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="<?php if(!empty($line->mainpic)){ echo $line->mainpic;} ?>" name="mainpic" >
<!--                                          	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310265115399.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" > -->
                                        </td>
                                    </tr>   
                                    <tr height="34" class="form_group">
                                        <td class="form_title">产品标签：</td>
                                        <td>
                                            <input type="text"  id="depart_id" class="form_input w_180 fl"  autocomplete="off"  name="linetype"  value="<?php if(!empty($line->linetype)){ echo $line->linetype;} ?>">

                                        </td>
                                    </tr>
                                </table>
								<table class="departure_notice table_form_content table_td_border" border="1" width="800">                                
                                        <tbody>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用包含：</td>
                                                <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="feeinclude" id="feeinclude"><?php if(!empty($line->feeinclude)){ echo $line->feeinclude;} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用不含：</td>
                                                <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="feenotinclude" id="feenotinclude"><?php if(!empty($line->feenotinclude)){ echo $line->feenotinclude;} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">购物自费：</td>
                                                <td  style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="other_project" id="other_project"><?php if(!empty($line->other_project)){ echo $line->other_project;} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">保险说明：</td>
                                                <td  style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="insurance" id="insurance"><?php if(!empty($line->insurance)){ echo $line->insurance;} ?></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">签证说明：</td>
                                                <td  style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="visa_content" id="visa_content"><?php if(!empty($line->visa_content)){ echo $line->visa_content;} ?></textarea></td>
                                            </tr>
	                                        <tr class="form_group">
		                                        <td class="form_title w_100"><i class="important_title">*</i>温馨提示：</td>
		                                        <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="beizu" id="editor"><?php if(!empty($line->beizu)){ echo $line->beizu;} ?></textarea></td>
		                                    </tr>
		                                    <tr class="form_group">
		                                        <td class="form_title w_100"><i class="important_title">*</i>特别约定：</td>
		                                        <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="special_appointment" id="special_appointment"><?php if(!empty($line->special_appointment)){ echo $line->special_appointment;} ?></textarea></td>
		                                    </tr>
		                                    <tr class="form_group">
		                                        <td class="form_title w_100"><i class="important_title">*</i>安全提示：</td>
		                                        <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="safe_alert" id="safe_alert"><?php if(!empty($line->safe_alert)){ echo $line->safe_alert;} ?></textarea></td>
		                                    </tr> 

                                        </tbody>
                                 </table>	

							</div>  
						</div>
						
						<div class="widget-body">
						 <div style="margin-left:6px;width:870px;color:red;"> 
						 	<span>管家培训 </span>
						 	<span style="padding:5px;background:#2dc3e8;color:#fff;border-radius:4px;cursor:pointer;" class="train_btn">+添加</span>
						 </div>
							<div class="form-group problem_content" style="margin-left:0.5%;margin-top:20px;">
						
	                           <?php  if(!empty($train)){   foreach ($train as $k=>$v){  ?>
	                                <div class="problem_div">
										<div class="problem_title fl">
										       <span class="num">问题<?php  echo $k+1;?></span>
										       <input type="hidden"  name="train_id[]" value="<?php if(!empty($v->id)){echo $v->id;} ?>"/>
										</div>
										<div class="hot_problem">
											<label>Q：</label>
											<input  type="text" name="question[]"  value="<?php if(!empty($v->question)){echo $v->question;} ?>" placeholder="请输入热门问题">
											<i class="icon icon_1" onclick="del_train(this,<?php if(!empty($v->id)){echo $v->id;}else{ echo 1;} ?>)"></i>
										</div>
										<div class="delete_bomb">
										<span>点击按钮,删除此问题</span>
										</div>
										<div class="problem_answer">
											<label>A：</label>
											<textarea name="answer[]" placeholder="请输入参考答案"><?php if(!empty($v->answer)){echo $v->answer;} ?></textarea>
										</div>
									</div>
	                                 	
	                            <?php   }  ?>	 
	                              	
	                           <?php  }else{?>
	                            	
	                            	<div class="problem_div">
										<div class="problem_title fl">
										       <span class="num">问题1</span>
										       <input type="hidden"  name="train_id[]" value=""/>
										</div>
										<div class="hot_problem">
											<label>Q：</label>
											<input  type="text" name="question[]"  value="" placeholder="请输入热门问题">
											<i class="icon icon_1"   onclick="del_train(this,1)"></i>
										</div>
										<div class="delete_bomb">
										<span>点击按钮,删除此问题</span>
										</div>
										<div class="problem_answer">
											<label>A：</label>
											<textarea name="answer[]" placeholder="请输入参考答案"></textarea>
										</div>
									</div>
									
	                           <?php  } ?>
				
							</div>
						</div>
						<div>
						     
							  <label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:20%;"></label>
							  <button  class="btn btn-palegreen"  type="button" id="sub_line"> <b  style="font-size:14px">保存</b></button>
						</div>
					</form>	
					</div>
					
					<!-- 行程安排 -->
					<div class="tab-pane" id="profile12">
						<form action="<?php echo base_url()?>admin/b1/product/updateRouting" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
						data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
						data-bv-message="This value is not valid" class="form-horizontal bv-form" name="fromRout"  method="post" 
						id="lineDayForm" novalidate="novalidate">

						<div class="widget-body" id="rout_line">	         
						 <input type="hidden"   name="linecode" value="<?php if(!empty($line->linecode)){ echo $line->linecode;} ?>"/>
						<div class="line_rout_comment" >
		<!--  		<span style="padding:5px;background:#2dc3e8;color:#fff;border-radius:4px;cursor:pointer;" id="add_route">添加</span>
						<span style="padding:5px;background:#2dc3e8;color:#fff;border-radius:4px;cursor:pointer;" id="del_route">删除</span>-->		
						<?php
							$lineday=$line->lineday;
							if($lineday>0){
						
							for($i = 0; $i < $lineday; ++ $i) {
						?>

						<div class="lineDayDiv">
							<div class="form-group">					
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style="font-size:14px;">
								<span style="color: red;">*</span>第</label>
								<div class="col-sm-10 col_ts"  style=" width:auto;min-width:43%;position:relative;">
							   		 <input type="text"  style="width:50px;" name="day[]" value="<?php if(!empty($rout[$i]->day)){ echo $rout[$i]->day;} ?>"/>天
								</div>								
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style="font-size:14px;">
								<span style="color: red;">*</span>标题</label>
								<div class="col-sm-10 col_ts"  style=" width:auto;min-width:43%;position:relative;">
							   		 <input type="text" style="width:700px;" id="username"class="form-control text-width" name="title[]" value='<?php if(!empty($rout[$i]->title)){ echo $rout[$i]->title;} ?>' />
								</div>
							</div>
							<div class="form-group">
								<!-- 往返交通 -->
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3"><span style="color: red;"></span>城市间交通</label>
								<div class="form-inline col_ts">
									<div class="form-group col_ts" style="margin: 0px;">
									     	<div class="col-sm-10 col_ts">
											<input type="text"  style="width: 700px;" 
												value="<?php if(!empty($rout[$i]->transport)){ echo $rout[$i]->transport;} ?>"
												class="form-control text-width" name="transport[]"
												placeholder="100字以内,可不输，即为不显示" />
										  	</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb"
									for="inputEmail3">用餐</label>
								<div class="form-inline ">
									<div class="checkbox  col_ts" style="padding-top: 0px;">
										<label style="padding: 0px;text-align: center;width:76px;">
										<input type="checkbox"  <?php if(!empty($rout[$i]->breakfirsthas)){ if($rout[$i]->breakfirsthas==1){echo "checked";} } ?>  onclick="di_check(this)" value="1"/>早餐
										<input type="hidden" name="breakfirsthas[]" value="<?php if(!empty($rout[$i]->breakfirsthas)){ if($rout[$i]->breakfirsthas==1){echo 1;}else{echo 0;} }else{ echo 0;} ?>" />
										</label>
									</div>
									<div class="form-group col_ts" style="margin: 0px;">
										<input type="text" placeholder="15字以内"
											class="form-control small-width" style="width: 132px;"
											name="breakfirst[]" value=" <?php if(!empty($rout[$i]->breakfirst)){ echo $rout[$i]->breakfirst; } ?> ">
											
									</div>
						
									<div class="checkbox col_ts" style="padding-top: 0px;">
									<label style="padding: 0px;text-align: center;width:76px;">	
									     <input type="checkbox" <?php if(!empty($rout[$i]->lunchhas)){ if($rout[$i]->lunchhas==1){echo "checked";} } ?> onclick="di_check(this)"  value="1" />
									     <input type="hidden" name="lunchhas[]" value="<?php if(!empty($rout[$i]->lunchhas)){ if($rout[$i]->lunchhas==1){echo 1;}else{echo 0;} }else{ echo 0;} ?>" />
											午餐
										</label>
									</div>
									<div class="form-group col_ts" style="margin:0px;">
										<input type="text" placeholder="15字以内" name="lunch[]"
											class="form-control user_name_b1" style="width: 132px;" value="<?php if(!empty($rout[$i]->lunch)){ echo $rout[$i]->lunch; } ?>">
									</div>
						            <div style="float:left;">
									<div class="checkbox col_ts" style="padding-top: 0px;width:80px;">
										<label style="padding: 0px;text-align: center;width:76px;"> 
										<input type="checkbox"  <?php if(!empty($rout[$i]->supperhas)){ if($rout[$i]->supperhas==1){echo "checked";} } ?> onclick="di_check(this)" value="1"/>
										 <input type="hidden" name="supperhas[]" value="<?php if(!empty($rout[$i]->supperhas)){ if($rout[$i]->supperhas==1){echo 1;}else{echo 0;} }else{ echo 0;} ?>" />
											晚餐
										</label>
									</div>
									<div class="form-group" style="margin: 0px;">
										<input type="text" placeholder="15字以内" name="supper[]"
											class="form-control user_name_b1" style="width: 132px;"value="<?php if(!empty($rout[$i]->supper)){ echo $rout[$i]->supper; } ?>">
									</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">住宿</label>
									<div class="form-inline col_ts">
										<div class="form-group col_ts" style="margin: 0px;">
									     	<div class="col-sm-10 col_ts">
											<input type="text"  style="width: 700px;" id="hotel" value="<?php if(!empty($rout[$i]->hotel)){ echo $rout[$i]->hotel; } ?>"
												class="form-control text-width" name="hotel[]"
												placeholder="酒店名称,200字以内(包含字符)" />
										  	</div>
										 </div>
								 </div>
							</div>	
						
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb"
									for="inputEmail3"><span style="color: red;">*</span>行程</label>
								<div class="col-sm-10 col_ts" style="width:84%">
								<textarea id="editor_id"  name="jieshao[]" style="width: 50%; height:180px; padding:2px 0px 0px 5px;"><?php if(!empty($rout[$i]->jieshao)){ echo $rout[$i]->jieshao; } ?></textarea>	
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">行程图片</label>
								<div class="col-sm-10 col_ts" style="width: 730px;">
									  <div class="div_url_val" style="width: 728px;float:left;max-height:400px;">
									   <!--每个地方都必须要有,不然就没办法保存数据-->
				 
											<input type="hidden" name="line_pic_arr[]" class="line_pic_val" value="">  		 
						              </div>
									  <div style="width:105px;float:left;"><span onclick="change_avatar(this,1);" class="choice_img">选择图片</span></div>
									  <span onclick="choice_picture(this,1)" class="choice_picture" >从相册选择</span> 
									  <span style="margin-left:20px;position:relative;" >最多上传3张图片,图片格式gif,jpg,png,jpeg</span> 
								</div>
							</div>
						</div>
						<?php    
                         }}
						?> 	
						</div>

						</div>

						<div class="form-group" style="padding:15px 0px 20px 0px;">
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
							<button class="btn btn-palegreen" type="button" id="sb_rout" ><b  style="font-size:14px">保存</b></button>

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
									    <form action="/admin/b1/product/updateLinePrice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
											data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
											data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  id="linePriceForm" novalidate="novalidate">		 
										  <input name="linecode" type="hidden" id="linecode" value="<?php if(!empty($line->linecode)){ echo $line->linecode;}else{ echo 0;}?>" />
                                         <div style="margin-top:20px;" >
                                             <span style="padding-left: 5px;"><span style="color: red;">*</span>定金:</span>
                                             <input style="padding-left: 5px;width:60px;" class="price_input" type="text" placeholder="" value="<?php if(!empty($price->deposit)){ echo $price->deposit;} ?>" name="deposit" id="deposit" />
                                             <span>元</span>

                                             <span>提前:</span>
                                             <input style="padding-left: 5px;width:50px;display: inline-block;" type="text" value="<?php if(!empty($price->before_day)){ echo $price->before_day;} ?>" id="before_day" class="price_input" name="before_day"  />
                                             <span>天交清团费</span>
                                        </div>

									  <div style="margin-top:15px;"><span style="color: red;">备注:</span></div> 
									    <div style="margin-top:10px;"> <span class=" col_price">儿童占床说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($price->child_description)){ echo $price->child_description;} ?>" id="child_description" class="form-control text-width price_input col_wd" name="child_description"  /></div>
									    
									    <div style="margin-top:10px;"> <span class=" col_price">儿童不占床说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($price->child_nobed_description)){ echo $price->child_nobed_description;} ?>" id="child_nobed_description"  class="form-control text-width price_input col_wd" name="child_nobed_description"  />
									     <span style="padding-left:10px;">提示：填写则在产品页面显示，不填则无显示</span>
									    </div>
									       
									    <div style="margin:10px 0px 10px 0px;"> <span class=" col_price">老人价说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($price->old_description)){ echo $price->old_description;} ?>" id="old_description"  class="form-control text-width price_input col_wd" name="old_description"  /></div>
									    
									    <div style="margin-bottom:30px;"> <span class=" col_price">特殊人群说明:</span>
									    <input type="text" placeholder="15字内 " value="<?php if(!empty($price->special_description)){ echo $price->special_description;} ?>" id="special_description" style="padding-left: 5px;display:inline-block;height:28px;" class="form-control text-width price_input col_wd" name="special_description"  /></div>
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
					
					<!-- 库存 -->
				<!--   <input type="hidden" value="<?php echo date('Y-m-01', strtotime('0 month'));?>" id="selectMonth" name="selectMonth" />
					<div class="tab-pane" id="profile11">	
						<div class="widget-body" style="padding: 0;">
							<div id="registration-form">
								<div id="day_price">
									<div style="margin-top: 10px;"> 	
									    <form action="/admin/b1/product/updateLinePrice" accept-charset="utf-8" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh" 
											data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" 
											data-bv-message="This value is not valid" class="form-horizontal bv-form"  method="post"  id="linePriceForm" novalidate="novalidate">		 
										  <input name="linecode" type="hidden" id="linecode" value="<?php if(!empty($line->linecode)){ echo $line->linecode;}else{ echo 0;}?>" />
                                         <div style="margin-top:20px;" >
                                             <span style="padding-left: 5px;"><span style="color: red;">*</span>定金:</span>
                                             <input style="padding-left: 5px;width:60px;" class="price_input" type="text" placeholder="" value="<?php if(!empty($price->deposit)){ echo $price->deposit;} ?>" name="deposit" id="deposit" />
                                             <span>元</span>

                                             <span>提前:</span>
                                             <input style="padding-left: 5px;width:50px;display: inline-block;" type="text" value="<?php if(!empty($price->before_day)){ echo $price->before_day;} ?>" id="before_day" class="price_input" name="before_day"  />
                                             <span>天交清团费</span>
                                        </div>

									  <div style="margin-top:15px;"><span style="color: red;">备注:</span></div> 
									    <div style="margin-top:10px;"> <span class=" col_price">儿童占床说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($price->child_description)){ echo $price->child_description;} ?>" id="child_description" class="form-control text-width price_input col_wd" name="child_description"  /></div>
									    
									    <div style="margin-top:10px;"> <span class=" col_price">儿童不占床说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($price->child_nobed_description)){ echo $price->child_nobed_description;} ?>" id="child_nobed_description"  class="form-control text-width price_input col_wd" name="child_nobed_description"  />
									     <span style="padding-left:10px;">提示：填写则在产品页面显示，不填则无显示</span>
									    </div>
									       
									    <div style="margin:10px 0px 10px 0px;"> <span class=" col_price">老人价说明 :</span>
									    <input style="padding-left: 5px;display:inline-block;height:28px;" type="text" placeholder="15字内 " value="<?php if(!empty($price->old_description)){ echo $price->old_description;} ?>" id="old_description"  class="form-control text-width price_input col_wd" name="old_description"  /></div>
									    
									    <div style="margin-bottom:30px;"> <span class=" col_price">特殊人群说明:</span>
									    <input type="text" placeholder="15字内 " value="<?php if(!empty($price->special_description)){ echo $price->special_description;} ?>" id="special_description" style="padding-left: 5px;display:inline-block;height:28px;" class="form-control text-width price_input col_wd" name="special_description"  /></div>
										</form>
										
									  	<div class="cal-manager" >					    	
									    </div>
									</div>
									
								</div>
							</div>
						</div>
						<div style="margin-top: 10px;">
							<button class="btn btn-palegreen" style="margin-left:350px;" id="saveNextPriceBtn">保存</button><i> </i>
						</div>
						
					</div>-->	
					
					<div class="title_info_box" style="display:none;position:fixed;border:1px solid #f00;text-align:left;text-indent:30px;width:300px;padding:10px;background:#fff;z-index:999;color:#f00;font-size:14px;top:100px;right:20px;font-weight:600;">	
                       	
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
          


<div class="routeData"  style="display:none">
	<div class="form-group">					
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style="font-size:14px;">
		<span style="color: red;">*</span>第</label>
		<div class="col-sm-10 col_ts"  style=" width:auto;min-width:43%;position:relative;">
	   		 <input type="text"  style="width:50px;" name="day[]"/>天
		</div>								
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3" style="font-size:14px;">
		<span style="color: red;">*</span>标题</label>
		<div class="col-sm-10 col_ts"  style=" width:auto;min-width:43%;position:relative;">
	   		 <input type="text" style="width:700px;" id="username"class="form-control text-width" name="title[]" value='' />
		</div>
	</div>
	<div class="form-group">
		<!-- 往返交通 -->
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3"><span style="color: red;"></span>城市间交通</label>
		<div class="form-inline col_ts">
			<div class="form-group col_ts" style="margin: 0px;">
			     	<div class="col-sm-10 col_ts">
					<input type="text"  style="width: 700px;" 
						value=""
						class="form-control text-width" name="transport[]"
						placeholder="100字以内,可不输，即为不显示" />
				  	</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb"
			for="inputEmail3">用餐</label>
		<div class="form-inline ">
			<div class="checkbox  col_ts" style="padding-top: 0px;">
				<label style="padding: 0px;text-align: center;width:76px;">
				<input type="checkbox" onclick="di_check(this)" value="1"/>早餐
				<input type="hidden"  name="breakfirsthas[]" value="0" />
				</label>
			</div>
			<div class="form-group col_ts" style="margin: 0px;">
				<input type="text" placeholder="15字以内"
					class="form-control small-width" style="width: 132px;"
					name="breakfirst[]" value="">
			</div>

			<div class="checkbox col_ts" style="padding-top: 0px;">
			<label style="padding: 0px;text-align: center;width:76px;">	
			     <input type="checkbox" onclick="di_check(this)" value="1" />
			     <input type="hidden" name="lunchhas[]" value="0" />
					午餐
				</label>
			</div>
			<div class="form-group col_ts" style="margin:0px;">
				<input type="text" placeholder="15字以内" name="lunch[]"
					class="form-control user_name_b1" style="width: 132px;" value="">
			</div>
            <div style="float:left;">
			<div class="checkbox col_ts" style="padding-top: 0px;width:80px;">
				<label style="padding: 0px;text-align: center;width:76px;"> 
				<input type="checkbox" onclick="di_check(this)" value="1"/>
					晚餐
				<input type="hidden" name="supperhas[]" value="0" />
				</label>
			</div>
			<div class="form-group" style="margin: 0px;">
				<input type="text" placeholder="15字以内" name="supper[]"
					class="form-control user_name_b1" style="width: 132px;"value="">
			</div>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">住宿</label>
			<div class="form-inline col_ts">
				<div class="form-group col_ts" style="margin: 0px;">
			     	<div class="col-sm-10 col_ts">
					<input type="text"  style="width: 700px;" id="hotel" value=""
						class="form-control text-width" name="hotel[]"
						placeholder="酒店名称,200字以内(包含字符)" />
				  	</div>
				 </div>
		 </div>
	</div>	

	<div class="form-group">
		<label class="col-sm-2 control-label no-padding-right label-width col_lb"
			for="inputEmail3"><span style="color: red;">*</span>行程</label>
		<div class="col-sm-10 col_ts" style="width:84%">
		<textarea id="editor_id"  name="jieshao[]" style="width: 50%; height:180px; padding:2px 0px 0px 5px;"></textarea>	
		</div>
	</div>
	<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right label-width col_lb" for="inputEmail3">行程图片</label>
				<div class="col-sm-10 col_ts" style="width: 730px;">
					  <div class="div_url_val" style="width: 728px;float:left;max-height:400px;">
					   <!--每个地方都必须要有,不然就没办法保存数据-->
 
							<input type="hidden" name="line_pic_arr[]" class="line_pic_val" value="">  		 
		              </div>
					  <div style="width:105px;float:left;"><span onclick="change_avatar(this,1);" class="choice_img">选择图片</span></div>
					  <span onclick="choice_picture(this,1)" class="choice_picture" >从相册选择</span> 
					  <span style="margin-left:20px;position:relative;" >最多上传3张图片,图片格式gif,jpg,png,jpeg</span> 
				</div>
			</div>
</div>
						

<script type="text/javascript">
/*设置价格*/			             
(function(){
	window.priceDate = null;
	function initProductPrice(){
		var url = '<?php echo base_url()?>t33Api/line/getProductPriceJSON';
		priceDate = new jQuery.calendarTable({  record:'', renderTo:".cal-manager",comparableField:"day",
			url :url,
			params : function(){ 
				return jQuery.param( { "linecode":'<?php if(!empty($line->linecode)){ echo $line->linecode;}else{ echo 0;}?>' ,"startDate":<?php echo date('Y-m-01', strtotime('0 month'));?> } );
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

	initProductPrice();
	
	//保存日期价格
	jQuery('#saveNextPriceBtn').click(function(){
			var formParam = jQuery('#linePriceForm').serialize();
			var price = JSON.stringify(priceDate.getValues());
		    jQuery.ajax({ type : "POST",async:false, data :formParam+"&prices="+price ,url : "<?php echo base_url()?>t33api/line/updateLinrPrice", 
	             beforeSend:function() {//ajax请求开始时的操作
	                 $('#saveNextPriceBtn,#savePriceBtn').addClass("disabled");
	             },
	             complete:function(){//ajax请求结束时操作
	                $('#saveNextPriceBtn,#savePriceBtn').removeClass("disabled");
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
/* ----------------------------------设置价格 end-------------------------------------------- */
//保存价格   
//function ChecklineTrain(){	
jQuery('#sub_line').click(function(){
	jQuery.ajax({ type : "POST",data : jQuery('#lineInfo').serialize(),async:false,url : "<?php echo base_url()?>t33Api/line/edit_line_api", 
			success : function(result) {
				var result=eval("("+result+")");
				alert(result.msg);
			}
	});
	return false;
});

//添加行程
jQuery('#add_route').click(function(){
	var str=$('.routeData').html();
	$(".lineDayDiv").last().after('<div class="lineDayDiv">'+str+'</div>')
});
//删除行程
jQuery('#del_route').click(function(){
	$(".lineDayDiv").last().remove();
});
//添加,编辑行程
jQuery('#sb_rout').click(function(){
	jQuery.ajax({ type : "POST",data : jQuery('#lineDayForm').serialize(),async:false,url : "<?php echo base_url()?>t33Api/line/updateRouting", 
		success : function(result) {
			var result=eval("("+result+")");
			alert(result.msg);
		}
	});
	return false;
});

//di_check
function di_check(obj){
	var flag=$(obj).is(':checked');
	
	if(flag){
		$(obj).parent().find("input").attr('value',1);
	}else{
		$(obj).parent().find("input").attr('value',0);
	}
}



//添加管家培训
$(".train_btn").on('click', function () {


	var l=$(".problem_div").length - 1;
	var n=$(".problem_div").length +1;

	//if(n<4){
		//var str='<i class="important_title" >*</i>';
	//}else{
		var str='';	
	//}

	var train_html ='<div class="problem_title fl"> <span  class="num">'+str+'问题'+n+'</span><input type="hidden"  name="train_id[]" value=""/></div>';
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
							if(index<3){
								var str='<i class="important_title" >*</i>';
							}else{
								var str='';	
							}

							$(this).find(".num").html(str+'问题'+(index+1));
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
			if(index<3){
				//var str='<i class="important_title" >*</i>';
				var str='';
			}else{
				var str='';	
			}
			$(this).find(".num").html(str+'问题'+(index+1));
		});
	}	
}
 </script>




