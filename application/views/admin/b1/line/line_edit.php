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
	.col_wd{width:295px} 
   	/*树形结构样式*/
   	li.title {list-style: none;}
	ul.list {margin-left: 17px;}
	ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}
	.circle {
width:16px;height:16px;display: inline-block;font-size:20px;line-heigth:16px;text-align:center;color:#090;text-decoration:none

}	
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
					<li class="" id="scheduling">
                         <a class="routting" href="#profile12" data-toggle="tab" id="routting" name="rout" onclick="show_line_rout(<?php  if(!empty($data['id'])){echo $data['id']; }?>);" > 行程安排 </a>
                    </li>
					<li class="" id="set_price">
                         <a href="#profile10" data-toggle="tab" onclick="show_line_suit(<?php  if(!empty($data['id'])){echo $data['id']; }?>);" > 设置价格 </a>
                    </li>	
					<li class="" id="click_feedesc">
                         <a href="#profile14" data-toggle="tab" onclick="show_line_fee(<?php  if(!empty($data['id'])){echo $data['id']; }?>);" > 费用说明 </a>
                    </li>
                                                                
					<li class="" id="click_Bookings">
                         <a href="#profile16" data-toggle="tab"  onclick="show_line_offere(<?php  if(!empty($data['id'])){echo $data['id']; }?>);"  > 参团须知</a>
                    </li>		
					<li class="" id="click_tips">
                         <a href="#profile15" data-toggle="tab" onclick="show_line_label(<?php  if(!empty($data['id'])){echo $data['id']; }?>);"  > 产品标签 </a>
                    </li>
					<li class="" id="expert_training">
                        <a href="#profile17" data-toggle="tab"  onclick="show_line_train(<?php  if(!empty($data['id'])){echo $data['id']; }?>);" > 管家培训 </a>
                    <li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 基础信息 -->		
					<div class="tab-pane active" id="home11">
						<form action="<?php echo base_url()?>admin/b1/product/updateLine" accept-charset="utf-8" class="form-horizontal bv-form" method="post" id="lineInfo" novalidate="novalidate">		
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
                                                       <?php  if($data['line_classify']=="1"){ ?>
                                                                <option value="1" selected >境外游</option>
                                                       <?php  }else if($data['line_classify']=="2"){ ?>
                                                                <option value="2" selected >国内游</option> 
                                                        <?php }else if($data['line_classify']=="3"){  ?>
                                                                <option value="3" selected >周边游</option> 
                                                        <?php  }else{?>
                                                                <option value="2" selected >国内游</option> 
                                                        <?php } ?>
      
                                                 <?php  }else{ 
                                                    $line_overcity=explode(',', $data['overcity']);
                                                    if(in_array("2", $line_overcity)){
                                                         echo " <option value='1' selected>境外游</option>";
                                                    }else{
                                                         echo " <option value='2' selected>国内游</option>";
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
                                        	<input type="text" placeholder="出发地-模糊搜索" class="form_input w_160 fl" id="startcity" name="startcity" autocomplete="off" value="<?php if($data['line_classify']==3){foreach ($cityArr as $v):  echo $v['cityname']; endforeach; }?>">
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
                                            <?php if(!empty($data['line_classify'])){?>
                                                 <?php  if($data['line_classify']=="1"){ ?>
                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showCJDestTree(this);"  > 
                                                 <?php  }else if($data['line_classify']=="2"){ ?>
                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showGNDestTree(this);"> 
                                                 <?php }else if($data['line_classify']=="3"){  ?> 
                                                        <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showZBDestTree(this,$('#lineCityId').val());" >
                                                 <?php  }else{?>
                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showGNDestTree(this);" >
                                                 <?php } ?>
      
                                            <?php  }else{ 
                                                    $line_overcity=explode(',', $data['overcity']);
                                                    if(in_array("1", $line_overcity)){ ?>
                                                        <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showGNDestTree(this);" >
                                                <?php }else{ ?>
                                              			<input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showCJDestTree(this);" >
                                                      
                                             <?php  }	
                                             } ?>   
                                        	<!-- <input type="text" placeholder="目的地-模糊搜索" class="form_input w_120 fl" id="overcityArr" name="overcity_arr"> -->
                                        	<input name="overcitystr" id="overcitystr" type="hidden" value="<?php echo $data['overcity2'].',' ?>" >    
                                            <div id="ds-list" style="min-width:500px;float:left;margin-top:4px;">
                                            	<?php foreach ($overcity2_arr as $overcity):?>								
                            					<span class="selectedContent" value="<?php  if(!empty($overcity['dest_id'])){echo $overcity['dest_id']; }?>">
                            						<?php if(!empty($overcity['name'])){echo $overcity['name'];}  ?>
                            						<input type="hidden"  name="overcity[]" value="<?php  if(!empty($overcity['dest_id'])){echo $overcity['dest_id'];} ?>">
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
                                        <td>
                                           <input type="text" placeholder="" id="linebefore" class="form_input" name="linebefore" style="width: 50px;" value="<?php if(!empty($data['linebefore'])){echo $data['linebefore'];}else{ echo 0;}?>"/>
                                           <span>天</span>
                                           <input type="text" placeholder="" id="linedatehour" class="form_input" name="linedatehour" style="width: 50px;" 
                                            value="<?php  if(!empty($line_aff['hour'])){ echo $line_aff['hour']; }else{ echo 0;}?>"/>
                                           <span> 小时</span>
                                           <input type="text" placeholder="" id="linedateminute" class="form_input" name="linedateminute" style="width: 50px;" 
                                           value=" <?php  if(!empty($line_aff['minute'])){ echo $line_aff['minute']; }else{echo 0;}?> "/>
                                           <span> 分 截止报名</span>
                                           
                                        </td>
                                    </tr>   
                                     <tr height="34" class="form_group">
                                        <td class="form_title">上车地点：</td>
                                        <td>  
                                             <div  style="float:left;">
                                                  <input type="text" placeholder="" id="linebefore" class="form_input" name="car_address" style="width: 222px;" value=""/>
                                                  <span><a href="javascript:void(0)" onclick="add_car(this)" style="font-size:14px;">新增</a></span>
                                             </div>    
                                             <div id="car-list" style="min-width:500px;float:left;margin:4px 0px 0px 15px;">   
                                                <?php  if(!empty($carAddress)){
                                                    foreach ($carAddress as $key => $value) {
                                                ?>                
                                                      <span class="selectedContent" >
                                                             <?php echo $value['on_car']; ?>
                                                             <input  type="hidden" value="<?php echo $value['on_car']; ?>" name="car_addressArr[]" />
                                                             <span class="delCarAddress" onclick="delCarAddres(this)" >×</span>
                                                      </span>   
                                                 <?php }  }?>             
                                             </div>  
                                        </td>
                                    </tr> 
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路特色：</td>
                                        <td>
                                        	<textarea placeholder="其他显示信息(600字以内)" style="width:600px;height:150px;" class="noresize w_600"  id="name_list" name="name_list"><?php echo $data['features'];?></textarea>
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
                                                        	<div style="width:100px;height:60px;"><img  style="height:100%;" src="<?php echo $v['filepath']; ?>" ></div>
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
							<button class="btn btn-palegreen" type="button"  id="sb_line" ><b  style="font-size:14px">保存</b></button>
							<button class="btn btn-palegreen" type="button"  style="margin-left:150px;"  id="next_line"><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:4px">下一步</span></button><i> </i>
						</div>
						</form>
					</div>
					<!-- 行程安排 -->
					<div class="tab-pane" id="profile12">         
						<!-- ajax加载的内容 -->
					</div>
					<!-- 设置价格 -->	
					<div class="tab-pane" id="profile10">							
					</div>
					<!-- 费用说明 -->
					<div class="tab-pane" id="profile14">
					</div>

					<!-- 预定须知 -->
					<div class="tab-pane" id="profile16">
					
					</div>
                   	<!-- 产品标签  -->
					<div class="tab-pane" id="profile15">
					</div>
					
					<!-- 管家培训-->
			    	<div class="tab-pane" id="profile17">
					</div>
					<!-- 抽奖礼品-->
			     	<!--<div class="tab-pane" id="profile13" style="min-height:300px;">
					
				   </div>-->
			</div>
		</div>
	</div>

</div>
          

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
	            <span class="btn" onclick="search_img(this);">搜索</span>
            </div>
            <ul class="img_list clearfix" id="picture_list">
          
            </ul>
            <div class="zancun_img"><input type="hidden" id="zancun"><ul id="zancun_img_list"></ul></div>
            <div class="pagination picture_page"></div>
            <div class="queren"><span onclick="queren_choice(this);" class="btn">确认</span></div>
	    </div>
   	</div>
</div>
<!--行程安排的交通-->
<div id="route_div" style="position: absolute;background: #fff;border: 1px solid #DDDBDB;display: none;z-index: 1000;"><div class="route"><img alt="飞机" src="/assets/img/icons/route/plain.gif"></div><div class="route"><img alt="汽车" src="/assets/img/icons/route/bus.gif"></div><div class="route"><img alt="轮船" src="/assets/img/icons/route/ship.gif"></div><div class="route"><img alt="火车" src="/assets/img/icons/route/train.gif"></div><div style="display: inline-block;margin-left: 10px;padding: 0 5px;">点击图标，选择交通工具</div></div>

<div id="xiuxiu_box" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<script type="text/javascript" src="<?php echo base_url();?>assets/ht/js/common/common.js"></script>
<!--景点的设置end-->
<script src="<?php echo base_url('assets/js/app/b1/product/product.js')?>"></script>
<link href="<?php echo base_url('assets/css/product.css')?>" rel="stylesheet" />
<!-- 加载编辑器 -->
<script src="<?php echo base_url() ;?>assets/js/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ueditor/ueditor.all.min.js"></script>

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

<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<!--日期价格控件
<script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.dateTable.js')?>"></script>
-->
<script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.calendarTable.js')?>"></script>

<?php echo $this->load->view('admin/b1/common/citylist_script'); ?> 

<!--日期控件的插件 -->
<link href="<?php echo base_url();?>assets/js/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/js/calendar/dateFun.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/calendar/Calendarn.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/calendar/CalendarCfg.js"></script>

<script type="text/javascript">

//显示行程
 function show_line_rout(lineid){
            //行程安排的交通
        /*   $('body').append('<div id="route_div" style="position: absolute;background: #fff;border: 1px solid #DDDBDB;display: none;z-index: 1000;"><div class="route"><img alt="飞机" src="/assets/img/icons/route/plain.gif"></div><div class="route"><img alt="汽车" src="/assets/img/icons/route/bus.gif"></div><div class="route"><img alt="轮船" src="/assets/img/icons/route/ship.gif"></div><div class="route"><img alt="火车" src="/assets/img/icons/route/train.gif"></div><div style="display: inline-block;margin-left: 10px;padding: 0 5px;">点击图标，选择交通工具</div></div>');  */

              jQuery.ajax({ type : "POST",data :"id="+lineid,url : "<?php echo base_url()?>admin/b1/product/getLineRoutData",
                     success : function(result) { 
                               $('#profile12').html(result);   
                                //移入
                                jQuery("#rout_line").on("mouseenter", ".title_div",function(){
                                    if(routeTimeout){
                                //      clearTimeout(routeTimeout);
                                    }
                                });

                                //隐藏交通工具
                                jQuery("#rout_line").on("mouseleave", ".title_div",function(){
                                	clearTimeout(routeTimeout);
                                    routeTimeout = setTimeout("hideRoute();", 1000);
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

                            
                                var routeTimeout = null;
                                //离开赋值
                                jQuery("#rout_line").on("DOMNodeInserted", ".title_div",function(){
                                    var me = jQuery(this);
                                    var val = me.html();
                                //  me.next('input').val(val.replace(/\"/g,"'"));
                                 	var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头      
                                 	var end_ptn = /[ | ]*\n/g;            //过滤标签结束  
                                 	var space_ptn = /&nbsp;/ig;          //过滤标签结尾
                                 	var c1 = val.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
                                 // me.html(c1);
                                    me.nextAll('input').eq(0).val(c1); 
                                });  

                                jQuery("#rout_line").on("blur", ".title_div",function(){
                                     var me = jQuery(this);
                                     var val = me.html();
                                     var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头      
                                  	 var end_ptn = /[ | ]*\n/g;            //过滤标签结束  
                                     var space_ptn = /&nbsp;/ig;          //过滤标签结尾
                                     var c1 = val.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
                                    //me.html(c1);
                                     me.nextAll('input').eq(0).val(c1); 
                                });  
                                function chk(obj){
                                    
                                    if(obj.getElementsByTagName("img").length){
                                        document.getElementById('tips').textContent="";
                                    }
                                }
                                var route_obj = null;
                                $("#rout_line .title_div").click(function(){
                             	        clearTimeout(routeTimeout);
                                	    route_obj = null;
                                	    $(".onthis").removeClass("onthis");
                                	    $(this).addClass("onthis");
                                	    route_obj = $(this);
                                        var top = route_obj.offset().top+route_obj.outerHeight();
                                        var left = route_obj.offset().left;
                                        $("#route_div").css({left : left,top : top});
                                        $("#route_div").show();
                                        
                                });
                                var cd = document.getElementById('route_div');
                                cr = cd.getElementsByTagName("img");
                                for(var i = 0 ; i <cr.length; i ++ ){
                                	cr[i].onclick = function(){
                                		  insertNodeOverSelection($(".onthis")[0],jQuery(this)[0]);
                                     }
                                }
                                
                                 
                     }
            });
}
  //隐藏交通工具
    function hideRoute(){
  		 jQuery("#route_div").hide();
    } 

    var scrollFunc=function(e){ 
    	jQuery("#route_div").hide();
    } 
 
    if(document.addEventListener){ 
        document.addEventListener('DOMMouseScroll',scrollFunc,false); 
    }
    window.onmousewheel=document.onmousewheel=scrollFunc;//IE/Opera/Chrome 

    $(document).mouseup(function(e) {
    	var _con = $('#rout_line'); // 设置目标区域
    	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
    		jQuery("#route_div").hide();
    	}
    })
//保存行程
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
        jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineDayForm').serialize(),url : "<?php echo base_url()?>admin/b1/product/updateRouting", 
                beforeSend:function() {//ajax请求开始时的操作
                     $('#sb_rout,#next_rout').addClass("disabled");
                },
                complete:function(){//ajax请求结束时操作
                        $('#sb_rout,#next_rout').removeClass("disabled");
                },
                success : function(response) {  
                     if(response){
                         alert( '保存行程成功！' ); 
                         if(index==2){
                             //下一步
                            $("#scheduling").removeClass('active');
                            $("#profile12").removeClass('active');
                            $("#profile12").html('');
                            show_line_suit(<?php  if(!empty($data['id'])){echo $data['id']; }?>);   
                            
                            $("#set_price").css('display','block'); 
                            $("#set_price").addClass('active');
                            $("#profile10").addClass('active');
                            //$('#set_price').click();

                         } 
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
  
    
//显示设置价格
function show_line_suit(lineid){
    jQuery.ajax({ type : "POST",data :"id="+lineid,url : "<?php echo base_url()?>admin/b1/product/showLineSuit",
          success : function(result) {    
               $('#profile10').html(result);		     
          }
    });
}
//显示费用说明
function show_line_fee(lineid){
        jQuery.ajax({ type : "POST",data :"id="+lineid,url : "<?php echo base_url()?>admin/b1/product/showLineFee",
             success : function(result) {    
                     $('#profile14').html(result);
             }
        });
}
//显示参团须知
function show_line_offere(lineid){
        jQuery.ajax({ type : "POST",data :"id="+lineid,url : "<?php echo base_url()?>admin/b1/product/showLineOffere",
             success : function(result) {    
                     $('#profile16').html(result);
             }
        });
}
//显示线路标签
function show_line_label(lineid){
    jQuery.ajax({ type : "POST",data :"id="+lineid,url : "<?php echo base_url()?>admin/b1/product/showLineLabel",
         success : function(result) {    
                 $('#profile15').html(result);
         }
    });
}
//显示管家培训
function show_line_train(lineid){
    var  type_train=1;  // 区分是1,定制团的,2是线路
    var type="<?php echo $this->uri->segment(3,0); ?>";
    jQuery.ajax({ type : "POST",data :"id="+lineid+'&type='+type,url : "<?php echo base_url()?>admin/b1/product/showLineTrain",
         success : function(result) {    
                 $('#profile17').html(result);
         }
    });
}
//显示礼品
/*function show_line_gift(lineid){
             jQuery.ajax({ type : "POST",data :"id="+lineid,url : "<?php //echo base_url()?>admin/b1/product/showLineGift",
                         success : function(result) {    
                                 $('#profile13').html(result);
                         }
             });
}*/

$(document).ready(function() { 
    var  type='<?php if(!empty($type)){ echo $type;}  ?>';
    if(type==-1){
         $("#routting").click(); 
         $("#basc").removeClass('active');
         $("#home11").removeClass('active');
         $("#scheduling").css('display','block'); 
         $("#profile12").addClass('active');
         $("#scheduling").addClass('active');
    } 

	var line_classify=<?php if(!empty($data['line_classify'])){ echo $data['line_classify'];}else{ echo 0;} ?>; 
    get_city(line_classify); //加载出发地和目的地
    //出发城市获取
	var startcity=$('#lineCityId').val();
	if(startcity==''){
		startcity=0;
	}
  //  get_dest(line_classify,startcity);//加载目的地
}); 

//保存基础信息 
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
     var linedatehour=$('input[name="linedatehour"]').val();
     var linedateminute=$('input[name="linedateminute"]').val();
     if(isNaN(linebefore)){
              alert('提前报名填写格式不对');
              return false;
     }
     if(linedatehour=='' || linedateminute=='' || linedatehour==''){
            alert('提前报名的几天几时几分截止报名不能为空');
            return false;
     }else{
            if (isNaN(linedatehour)) {
                   alert('提前报名填写格式不对');
                   return false;
            }else if(linedatehour>24){
                   alert('提前报名几时截止报名已超过24小时');
                   return false;
            }
            if(isNaN(linedateminute)){
                  alert('提前报名填写格式不对');
                  return false;
            }else if(linedateminute>60){
                  alert('提前报名几分截止报名已超过60分钟');
                  return false;
            }

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
	// var ue = UE.getEditor('name_list');
	// str = ue.getContentTxt();  
	 var str = $("#name_list").val();

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
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#lineInfo').serialize()+"&type="+0,url : "<?php echo base_url()?>admin/b1/product/updateLine", 
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
                 //layer.msg('保存线路的基础信息成功！', {icon: 1});    
				//下一步行程安排
				if(index==2){
					//$("#routting").click();	
					$("#basc").removeClass('active');
					$("#home11").removeClass('active');
					$("#scheduling").css('display','block'); 
					$("#profile12").addClass('active');
					$("#scheduling").addClass('active');
                    show_line_rout(<?php  if(!empty($data['id'])){echo $data['id']; }else{ echo 0;}?>);
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


//新增上车地点
function add_car(obj){
       var car_address=$("input[name='car_address']").val();
       if(car_address==''){
           alert('请填写上车地点');
           return false;
       }
       var html='<span class="selectedContent">';
       html=html+car_address;
       html=html+'<input  type="hidden" value="'+car_address+'" name="car_addressArr[]" />';
       html=html+'<span id="delCarAddress"  onclick="delCarAddres(this)">×</span>';
       html=html+'</span>';

       $('#car-list').append(html);
       $("input[name='car_address']").val('');
}
//删除上车地点
function delCarAddres(obj){
      $(obj).parent().remove();
}

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




 //加载编辑器
// var ue = UE.getEditor('name_list'); 
 /*------------------------------------------------选择目的地-------------------------------------------------------*/          
/*function get_dest(type,startcity){
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
			var line_type=<?php  //if(!empty($line_type)){ echo $line_type;}else{ echo 0;} ?>;
			if(line_type==1){
                myArray.abroad=chioceDestJson.abroad;
			}else{
				myArray.domestic= chioceDestJson.domestic;
			}
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
}*/
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
			//	get_dest(line_classify,startcity);
			},
		});
		//get_dest(line_classify,startcity);
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
		//get_dest(line_classify,0); //加载目的地
		return false;
	}

}


function callbackTree(data_id,v){
 	$('#overcityID').val('');
	//选目的地
	var valObj=$("#overcitystr");
	var ids = valObj.val();
	var idArr = ids.split(",");
	var s = true;
	/* $.each(idArr ,function(key ,val) {
		if (data_id == val) {
			alert("此选项你已选择");
			s = false;
		}
	}) */
	if (s == false) {
		return false;
	} 

	ids += data_id+',';
	valObj.val(ids); 
	
	var valId="overcitystr";
	var buttonId="ds-list";
	var html = '<span class="selectedContent" value="'+data_id+'">'+v+'<input type="hidden" name="overcity[]" value="'+data_id+'"><span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
	$('#ds-list').append(html);
	$('#ds-list').css('display','block');
		
}
/*------------------------------------------------选择目的地end-------------------------------------------------------*/          

/* $("#line_classify").change(function(){
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
}); */


 </script>

<?php //echo $this->load->view('admin/b1/common/ztree_script'); ?>
<?php  echo $this->load->view('admin/common/tree_view'); ?>
<?php echo $this->load->view('admin/b1/common/upload_mainpic_script'); ?>
<?php //echo $this->load->view('admin/b1/common/product_edit_script'); ?>

  

