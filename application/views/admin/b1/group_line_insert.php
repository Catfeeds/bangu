<link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>		
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 

<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu" onclick="close_xiuxiu();">×</div>
	<div class="right_box"></div>
</div>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">新增产品</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->
<style type="text/css">
.main-container>.page-container { position:static;}
.page-content { min-width: 840px !important;}
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
 .selectedContent,.line-lable {
  color: #2dc3e8;
  height: 30px;
  line-height: 30px;
  position: relative;
  background: #edf6fa;
  border: 1px solid #d7e4ea;
  padding: 6px 20px 6px 12px;
  margin-right: 2px;
  vertical-align: middle;
}
.delPlugin{
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
		color: #000;
		font-size: 21px;
		font-weight: 700;
		opacity: 0.2;
		font-size:24px;
		top:-33px;
		right:-9px;
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
.choice_img { display:inline-block;width:80px;height:30px;line-height:30px;text-align:center;background:#00b7ee;color:#fff;cursor:pointer;border-radius:4px;}
.selectedTitle{float: left;padding-right: 10px;padding-top: 8px;}

#name_list { margin-left:5px;}

.zhutu{float: left;font-size: 10px;margin-top: 5px;margin-left: 10px;}

.checkbox { position:relative;width:60px;margin-left:15px;}
.checkbox label { position:absolute;left:0;top:4px;}
.checkbox input[type="checkbox"] { vertical-align:middle;margin-left:0 !important;position:absolute !important;left:0;top:0;}
.form-horizontal .form-group { margin:0 !important;}

.bv-form .widget-body { padding-left:0px;}
</style>
<script type="text/javascript">

</script>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav tabs-flat">
					<li class="home"><a href="#home11" data-toggle="tab"> 基础信息 </a></li>
					<li onclick="change_tab()"><a href="##"  data-toggle="tab" style="color: #aaa"> 行程安排 </a></li>
					<li onclick="change_tab()"><a href="##" data-toggle="tab" style="color: #aaa" > 设置价格 </a></li>	
					<li onclick="change_tab()"><a href="##"  data-toggle="tab" style="color: #aaa"> 费用说明 </a></li>
					<li onclick="change_tab()"><a href="##"  data-toggle="tab" style="color: #aaa"> 参团须知</a></li>		
					<li onclick="change_tab()"><a href="##"  data-toggle="tab" style="color: #aaa"> 产品标签 </a></li>
					<li onclick="change_tab()"><a href="##"  data-toggle="tab" style="color: #aaa"> 管家培训 </a><li>
				</ul>
					<?php
						$class_form = array(
							'data-bv-feedbackicons-validating' => 'glyphicon glyphicon-refresh', 
							'data-bv-feedbackicons-invalid' => 'glyphicon glyphicon-remove', 
							'data-bv-feedbackicons-valid' => 'glyphicon glyphicon-ok', 
							'data-bv-message' => 'This value is not valid', 
							'class' => 'form-horizontal bv-form', 
							//'onSubmit'=>'return CheckLine();',
							'method' => 'post', 
							'id' => 'registrationForm', 
							'novalidate' => 'novalidate' ,
                           	'enctype'=>'multipart/form-data'
						);
						echo form_open ( 'admin/b1/group_line_insert/insert', $class_form );
					?>
				<div class="tab-content tabs-flat" style="">
					<!-- 基础信息 -->
					<div class="tab-pane active" id="home11" style="padding-top:10px;">
						<div class="widget-body">
							<div id="registration-form">
                            	<input  type="hidden" name="line_classify" value="<?php if(!empty($line_type)){ echo $line_type ;}else{ echo 0;} ?>" />
                            	<table class="line_base_info table_form_content table_td_border" border="1" width="100%">
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路名称：</td>
                                        <td>&nbsp;&nbsp;
                                        	<input type="hidden" id="brand" value="<?php if(!empty($supplier[0])){ echo $supplier[0]['brand'];} ?>">
											<?php if(!empty($supplier[0])){ echo $supplier[0]['brand'];} ?>
                                        	<input type="text" placeholder="10字以内" id="lineprename" class="form_input w_450" name="lineprename"/>
                                            <input type="text" id="data_night" class="form_input w_40" name="data_night"/>晚
                                            <input type="text" id="data_num" class="form_input w_40" name="data_num"/><i class="important_title">*</i>天游
                                            <span class="title_txt red">线路名称+副标题总字数不超过50个字</span>
                                        </td>
                                    </tr>
                                    <!--<tr height="34" class="form_group" style="display:none;">
                                        <td class="form_title">线路全称：</td>
                                        <td><input type="text" placeholder="" id="linetitle" class="line_name form_input w_600" name="linetitle"></td>
                                    </tr> -->
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>副标题：</td>
                                        <td><input type="text" placeholder="需重点突出的信息,20字以内" id="linetitle" class="form_input w_600" name="linetitle"></td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>出发地：</td>
                                        <td>
                                        	<input type="text" placeholder="出发地-模糊搜索" class="form_input w_160 fl" id="startcity" name="startcity" autocomplete="off">
                                            <input type="hidden" name="lineCityId" id="lineCityId" value="">
                                            <div id="startcity-list" style="float:left;margin-top:4px;">
							     			</div>	
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>目的地：</td>
                                        <td>
                                          <?php if(!empty($line_type)){?>
                                                 <?php  if($line_type=="1"){ ?>
                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showCJDestTree(this);"  > 
                                                 <?php  }else if($line_type=="2"){ ?>
                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID" onfocus="showGNDestTree(this);" > 
                                                 <?php }else if($line_type=="3"){  ?>

                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID"  onfocus="showZBDestTree(this,$('#lineCityId').val());"   >
                                                 <?php  }else{?>
                                                       <input type="text" placeholder="目的地-模糊搜索" class="form_input w_160 fl" id="overcityID"  onfocus="showGNDestTree(this);" >
                                          <?php } } ?>
                                        <!--<input type="text" placeholder="目的地-模糊搜索" class="form_input w_120 fl" id="overcity_arr" name="overcity_arr"> -->
                                        	<input name="overcitystr" id="overcitystr" type="hidden" value="" >    
                                            <div id="ds-list" style="float:left;margin-top:4px;">
											</div>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title">主题游：</td>
                                        <td>
                                        	<span id="theme-list" class="btn btn-palegreen" >
												<span class="windowColor" id="theme_arr" data="" name="ds-lable" data-val="" style=" color: #fff !important;">选择主题游</span>
											</span>	
                                        	<input id="theme" type="hidden" name="theme" value="">
											<span style="color: red;margin-left:70px;">可自由选择是否加入主题游选项</span>	
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>提前：</td>
                                        <td>	
											<input type="text" placeholder="" id="linebefore" class="form_input" name="linebefore" value="0" style="width: 50px;"/>
											<span>天</span>
											<input type="text" placeholder="" id="linedatehour" class="form_input" name="linedatehour" value="0"  style="width: 50px;"/>
											<span>时</span>
											<input type="text" placeholder="" id="linedateminute" class="form_input" name="linedateminute" value="0"  style="width: 50px;"/>
											<span>分 截止报名</span>
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
                                             </div>  
                                        </td>
                                    </tr> 
                                    <input type="hidden" id="first_pay_rate"  value="100" name="first_pay_rate" style="width:35px;height:34px;"  />
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路特色：</td>
                                        <td>
                                        	<textarea placeholder="其他显示信息(600字以内)" style="width:600px;height:150px;" class="noresize w_600"  id="name_list" name="name_list"></textarea>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路宣传图：</td>
                                        <td><span onclick="change_avatar(this,0);" class="choice_img">选择图片</span>
											<span onclick="choice_picture(this,1)" class="choice_picture" >从相册选择</span> 
                                        	<div style="color: red; width: 280px;padding-left:5px; display: inline-block; height: 30px; line-height: 30px;">建议500*300。最多上传5张，选一张成为主图</div>
                                            <ul id="ThumbPic" style="margin-left:5px;margin-top:5px;"></ul>
                                            <input type="hidden" name="mainpic" value=""/>	
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>定制管家：</td>
                                        <td>
                                        <!--<input type="text" placeholder="" id="expert" class="" name="expert"  autocomplete="off" style="width: 100px;height:34px;"/> -->
                                      
                                  		<!--<input type="text"  id="depart_id" onfocus="showAllExpert(this.id);" autocomplete="off" style="width:180px;"/> -->
                                            <input type="text"  id="depart_id" class="form_input w_180 fl"  autocomplete="off" onfocus="showAllExpert(this.id,'');"   placeholder="输入营业部关键字搜索"  >
                                            <div id="expert-list" style="float:left;margin-top:4px;">       
											</div>	                      	

                                        </td>
                                    </tr>		
                                </table>
												
							</div>
						</div>
						<div style="margin-bottom: 100px;" class="div_bt_i">
							<label for="inputImg" class="col-sm-2 control-label no-padding-right"></label><label for="inputImg" class="col-sm-2 control-label no-padding-right"></label>
							<button class="btn btn-palegreen" type="button" id="sb_line" onclick="CheckLine()"><b  style="font-size:14px">保存&nbsp;&nbsp;并</b><span style="font-size:12px;padding-left:10px">下一步</span></button><i> </i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="user_shop_attrcolor" style="display: none;"></div>

<!-- 图片预览 -->
<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close" >×</button>
				<h4 class="modal-title">上传图片</h4>
			</div>
			<div class="modal-body" >
			 <span style="color:red;float:left;width:100%;margin-bottom:20px;">建议上传5张。最多上传5张，选取一张成为主图</span><br>
			   <div style="width: 100%;">
					<span>线路主图片:</span>
						<div id="OriginalPic" style="margin-bottom:30px;margin:0 auto 10px ;width:202px;"><span class="SliderPicBorder FlRight">
						<img style="max-height:130px" src=""></span>
						</div>
					<span>线路宣传图:</span>
					<ul id="ThumbPic">
					</ul>
				</div>
				<div style="width: 100%;float:left;margin:30px;">
					<!--<div id="infoimg"></div>-->
					<span onclick="change_avatar();" class="choice_img">选择图片</span>
				</div>
				<div style="margin-top:160px;"><input class="btn btn-palegreen " id="line_img_btn" type="button" style="float: right; margin-right: 2%; margin-top:-30px;" value="提交"></div>
			</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
  <!-- 新增的弹框 end-->
	<div class='avatar_box'></div>
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
              <?php if(!empty($dest_pic)){
                        foreach ($dest_pic as $k=>$v){
              ?>
                <li data-src="<?php echo $v['pic']; ?>" onclick="choice_this(this);"><i></i><img src="<?php echo $v['pic']; ?>"></li>
                <?php }}else{ ?>
                <li>暂无照片选择</li>
                <?php }?>
            </ul>
            <div class="zancun_img"><input type="hidden" id="zancun"><ul id="zancun_img_list"></ul></div>
            <div class="pagination picture_page"></div>
            <div class="queren"><span onclick="queren_choice(this);" class="btn">确认</span></div>
        </div>
    </div>
</div>
<!-- 加载编辑器 -->
<script src="<?php echo base_url() ;?>assets/js/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceStartCityJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<!-- 多图片上传的插件 -->
<script src="<?php echo base_url('assets/js/diyUpload0.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/webuploader.min.js') ;?>"></script>
<!-- 出发地 -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

 <!-- 城市数据 如果没有就空值  必须为数组   数组4个值  -->
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>


<?php $this->load->view("admin/expert_tree"); //加载树形营业部   ?>

<script type="text/javascript">
<!------------------------------------从相片中取图片--------------------------------------------->					                            				                            
//弹框相册图片选择
var imgArray = [];
function choice_picture(obj,index){
	
	if(index==1){
		$(".queren span").attr("data-val","ThumbPic");
		var len = $("#ThumbPic li").length;
		for(var i=0;i<len;i++){
			imgArray[i] = $("#ThumbPic li").eq(i).find("img").attr("src");
		}	
		$("#zancun_img_list").html($("#ThumbPic").html());
			
	}else{
		var id = "show_choice_pic"+index;
		$(obj).siblings(".div_url_val").find("ul").attr("id",id);
		$(".queren span").attr("data-val",id);
		var len = $(obj).siblings(".div_url_val").find(".url_val li").length;
		
		for(var i=0;i<len;i++){
			imgArray[i] = $(obj).siblings(".div_url_val").find(".url_val li").eq(i).find("img").attr("src");
		}
		$("#zancun_img_list").html($(obj).siblings(".div_url_val").find("ul").html());
		$("#zancun").val($(obj).siblings(".div_url_val").find("input").val());
		
	}

	for( var i = 0 ; i< imgArray.length ; i++ ){
		//alert(imgArray[i]);
		$("#picture_list li").each(function(){
			//alert(imgArray[i]);
			if( imgArray[i] == $(this).attr("data-src") ){
				$(this).addClass("on");
			}
		});
	}
	get_picture_page(1);

	$(".choice_photo_box").show();
	
}
//获取选图片
function get_picture_page(page_new){
	var type=$("select[name='dest_picture']").find("option:selected").val(); 
	$.post(
			"/admin/b1/product/get_product_pic",
		//	{'is':1,'pagesize':8},
			{'is':1,'pagesize':16,'page_new':page_new,'type':type},
			function(data) {
				data = eval('('+data+')');
				$('#picture_list').html('');
				$.each(data.list ,function(key ,val) {
					var str = '<li data-src="'+val.pic+'" onclick="choice_this(this);"><i></i>';
					str=str+'<img src="'+val.pic+'"></li>';
					$('#picture_list').append(str);
				})
				for( var i = 0 ; i< imgArray.length ; i++ ){
					 	$("#picture_list li").each(function(){
							if( imgArray[i] == $(this).attr("data-src") ){
								$(this).addClass("on");
							}
						});
			    }
				$('.picture_page').html(data.page_string);
				$('#picture_list').css({'z-index':'10000'}).show();

				//点击旅行社时执行
				$('.choice_tralve_agent').click(function() {
					$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
					$(this).css('border','2px solid green').addClass('active');
				})

				//点击分页
				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_picture_page(page_new);
				}) 
			}
		);

	for( var i = 0 ; i< imgArray.length ; i++ ){
		$("#picture_list li").each(function(){
			if( imgArray[i] == $(this).attr("data-src") ){
				$(this).addClass("on");
			}
		});
	}
}
function close_alert_box(){
	$(".choice_photo_box").hide();	
	$("#picture_list li").removeClass("on");
	$("#zancun").val("");
	$("#zancun_img_list").empty();
}
function queren_choice(obj){
	var src = $(".img_list").find(".on img").attr("src");
	var len = $(".show_choice_img").find(".choice_img_show img").length;
	var html = $("#zancun_img_list").html();
	var show_id = $(obj).attr("data-val");
	$("#"+show_id).html(html);
	if(show_id!="ThumbPic"){
		$("#"+show_id).siblings("input").val($("#zancun").val());	
	}
	$(".choice_photo_box").hide();	
	$("#picture_list li").removeClass("on");
	$("#zancun").val("");
	$("#zancun_img_list").empty();
	
	$('.weixuanzhong').click(function(){ 
		$("#ThumbPic li").find(".weixuanzhong").show();
		$(this).parent().find(".weixuanzhong").hide();
		$(this).parent().addClass('list_click').siblings().removeClass('list_click');
		var mainimg=$(this).parent().find('img').attr('src');
		$('input[name="mainpic"]').val(mainimg); 	
	})
}
$('.weixuanzhong').on("click",function(){ 
	$("#ThumbPic li").find(".weixuanzhong").show();
	$(this).parent().find(".weixuanzhong").hide();
	$(this).parent().addClass('list_click').siblings().removeClass('list_click');
	var mainimg=$(this).parent().find('img').attr('src');
	$('input[name="mainpic"]').val(mainimg); 	
})

function search_img(obj){
	var html='';
	var type=$("select[name='dest_picture']").find("option:selected").val(); 
	$.post(
			"/admin/b1/product/get_product_pic",
			{'is':1,'pagesize':16,'page_new':1,'type':type},
			function(data) {
				data = eval('('+data+')');
				$('#picture_list').html('');
				$.each(data.list ,function(key ,val) {
					var str = '<li data-src="'+val.pic+'" onclick="choice_this(this);"><i></i>';
					str=str+'<img src="'+val.pic+'"></li>';
					$('#picture_list').append(str);
				})
			 	for( var i = 0 ; i< imgArray.length ; i++ ){
				 	$("#picture_list li").each(function(){
						if( imgArray[i] == $(this).attr("data-src") ){
							$(this).addClass("on");
						}
					});
			    }
				$('.picture_page').html(data.page_string);
				$('#picture_list').css({'z-index':'10000'}).show();

				//点击旅行社时执行
				$('.choice_tralve_agent').click(function() {
					$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
					$(this).css('border','2px solid green').addClass('active');
				})

				//点击分页
				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_picture_page(page_new);
				}) 
			}
		);
}
function choice_this(obj){
	var len = $("#zancun_img_list li").length;
	var src = $(obj).find("img").attr("src");
	var val = $("#zancun").val();
	var num = $(obj).attr("data-num");
	if($(obj).hasClass("on")){
		$(obj).removeClass("on");
		var v = val.replace(src+";","");
		$("#zancun").val(v);
		var ss = val.split(";");
		for( var i = 0 ; i< ss.length ; i++ ){
			$("#zancun_img_list li").each(function(){
				if( src == $(this).find("img").attr("src") ){
					$(this).remove();
				}
			});
		}
	}else{
		var show_id = $(".queren span").attr("data-val");
		if(show_id=="ThumbPic"){
			if(len>=5){
				alert("所选图片不能超过5张");
				return false;
			}
			if(len==0){
				var html = '<li class="list_click" ><div class="img_main0"><div class="float_img" id="del_img" onclick="del_line_imgdata(this,-1)">×</div>';
				html+= '<div style="height:60px;"><img style="height:100%;" src="'+src+'"></div></div>';
				html+= '<input id="line_imgss" type="hidden" name="line_imgss[]" value="'+src+'"><div class="zhutu">设为主图片</div><div class="weixuanzhong" style="display: none;"  ></div></li>';	
				   $('input[name="mainpic"]').val(src); 
			}else{
				var html = '<li><div class="img_main0"><div class="float_img" id="del_img" onclick="del_line_imgdata(this,-1)">×</div>';
				html+= '<div style="height:60px;"><img style="height:100%;" src="'+src+'"></div></div>';
				html+= '<input id="line_imgss" type="hidden" name="line_imgss[]" value="'+src+'"><div class="zhutu">设为主图片</div><div class="weixuanzhong"></div></li>';	
			}
			
		}else{
			if(len>=3){
				alert("所选图片不能超过3张");
				return false;
			}
			var html = '<li style="float:left;list-style:none;margin:0 20px 0px 0px" class="url_li">';
				html+= '<div class="img_main"><div id="del_img" class="float_div" onclick="del_imgdata(this,-1);" style="height:20px;width:12px; font-size:24px;cursor:pointer;">×</div>';
				html+= '<img received="" file="" src="'+src+'" style="width:215px;"></div></li>';
		}
		$(obj).addClass("on");

		$("#zancun_img_list").append(html);
		var v = val+src+";";
		$("#zancun").val(v);
	}

}
 
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

 //-----------------------------删除指定的信息---------------------------------
function delExperID(obj,id){
	$(obj).parent().remove();
}

//-----------------------------------------end-----------------------------------------------------				
//添加基础信息
function CheckLine(){
	
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
/*     if(''==linetitle.val()){
    	 alert('副标题不能为空');  
	   linetitle.focus();
		return false;
	} */

	//行程天数的判断
	var data_num=$('#data_num').val();
	if(isNaN(data_num) || data_num<0){
		alert("行程天数填写格式不对");
		return false;
	}
	if(data_num>31){
		
		alert('行程天数的天数不能超过31天');
		return false;
	}
	
	var data_night = $('#data_night').val();
	if(isNaN(data_night) || data_night<0){
		
		alert("行程天数填写格式不对");
		return false;
	}
	//限制出发地的选择


	//限制目的地的选择
 	var overcitystr = $('#overcitystr');
	if(''==overcitystr.val()){
		
		alert('目的地不能为空！');
		return false;
	} 
    
	var data_num = $('#data_num');
	if(''==data_num.val()){
		
		data_num.focus();
		return false;
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
	 var linebefore=$('input[name="linebefore"]').val();
             var  linedatehour=$('input[name="linedatehour"]').val();
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
	var lineprice = $('#lineprice');
	if(''==lineprice.val()){
		
		lineprice.focus();
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

	var str = $("#name_list").val();  
	 if(str>0){
		/*  alert('线路特色不能为空！');
		 return false; */
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var i = 0; i < len; i++) {
		 charCode = str.charCodeAt(i);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 }
		// alert(realLength);
	     	if(realLength>600){
	     		
		    	 alert('线路特色的字符的数量不能超过600个字');
		     	return false;
		 }
     }

	//线路图片
	var line_pics_arr = $('#line_pics_arr').val();
	if(line_pics_arr==''){
		
		alert('线路图片不能为空!');
		return false;
	}
	
	//路线主图片
	var lineurl=$('#lineurl').val()
	if(lineurl==''){
		
		alert('路线主图片不能为空!');
		return false;
	}
/*	var expertid=$('input[name="expertid"]').val()
	if(expertid==''){
		$("#sb_line").removeAttr("disabled");
		alert('定制管家不能为空!');
		return false;
	}*/
	//admin/b1/group_line_insert/insert
	jQuery.ajax({ type : "POST",data : jQuery('#registrationForm').serialize(),async:false,url : "<?php echo base_url()?>admin/b1/group_line_insert/insert", 
	        beforeSend:function() {//ajax请求开始时的操作
                 $('#sb_line').addClass("disabled");
                 layer.load(1);//加载层
            },
            complete:function(){//ajax请求结束时操作
                 $('#sb_line').removeClass("disabled");
                 layer.closeAll('loading'); //关闭层
            },
		    success : function(response) {
		
			var obj = eval('(' + response + ')');
			if(obj.status==1){
				alert( '保存成功' );
				//window.location.href="/admin/b1/group_line/toLineEdit?id="+obj.line_id+'&type=-1';
				var union_id =<?php echo $union_id; ?>;
				if(union_id==1){
					window.location.href="/admin/b1/group_line/toLineEdit?id="+obj.line_id+'&type=-1';	
				}else{
					window.location.href="/admin/b1/b_group_line/toLineEdit?id="+obj.line_id+'&type=-1';
				}
				
			}else{
				alert(obj.msg);
			}
		}
	});	
	return false;
}

 /**************end***************/
</script>
			 
			 
<?php echo $this->load->view('admin/b1/common/citylist_script'); ?>	
 <script type="text/javascript">
 
   /*------------------------------------------------出发城市-------------------------------------------------------*/
   //出发城市
/*$.post('/admin/b1/product/get_startcity_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.cityname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#startcity",
	    name : "formcity",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    blurAfter : function(item, index) {// 选择后的事件
			if(jQuery('#formcity').val()==''){
				jQuery('#formcity').val('');
				jQuery('#startcity').val('');
			}
	    },
	    data : array
	});
	
})*/
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
  
function change(obj) {
      var text = obj.value;   // 获取input的值
      obj.value ='';  
 }
 function change_tab(){
	alert('基础信息没保存');
	 return false;
 } 

//加载编辑器
 //var ue = UE.getEditor('name_list');

 /************************************美图秀秀**************************************************/
 function change_avatar(){
		$('.avatar_box').show();
		
	   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	   xiuxiu.setLaunchVars("cropPresets", '500x300');
		xiuxiu.embedSWF("altContent",5,'100%','100%');
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('admin/upload/uploadImgFileXiu'); ?>");
	        xiuxiu.setUploadType(2);
	        xiuxiu.setUploadDataFieldName("uploadFile");
		xiuxiu.onInit = function ()
		{
			//默认图片
			xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
		}
		xiuxiu.onUploadResponse = function (data)
		{
			data = eval('('+data+')');	
		    if (data.code == 2000) {
		    
				if($('#ThumbPic').children('li').length>4){
					alert('上传文件数量超过限制');
				}else{
			               var  slength=$('#ThumbPic').children('li').length;
				    if(slength==0){
			    		    var html='<li class="list_click" style="">';
					    html+='<div class="img_main0">'; 
					    html+='<div class="float_img" id="del_img"  onclick="del_line_imgdata(this,-1)">×</div>'; 
					    html+='<div style="height:60px;"><img  style="height:100%;" src="'+data.msg+'"></div>'; 
					    html+='</div>';
					    html+='	<input type="hidden" id="line_imgss" value="'+data.msg+'" name="line_imgss[]" />';
					    html+='<div class="zhutu">设为主图片</div>'; 
					    html+='<div class="weixuanzhong" style="display: none;" ></div>'; 
					    html+='</li>';
					    $('input[name="mainpic"]').val(data.msg); 
				    }else{
					   var html='<li class="" style="">';
					    html+='<div class="img_main0">'; 
					    html+='<div class="float_img" id="del_img"  onclick="del_line_imgdata(this,-1)">×</div>'; 
					    html+='<div style="height:60px;"><img  style="height:100%;" src="'+data.msg+'"></div>'; 
					    html+='</div>';
					    html+='	<input type="hidden" id="line_imgss" value="'+data.msg+'" name="line_imgss[]" />';
					    html+='<div class="zhutu">设为主图片</div>'; 
					    html+='<div class="weixuanzhong" ></div>'; 
					    html+='</li>';
				    }

				   $("#ThumbPic").append(html);
				   $('.weixuanzhong').click(function(){  //选主图片
						$("#ThumbPic li").find(".weixuanzhong").show();
						$(this).parent().find(".weixuanzhong").hide();
						$(this).parent().addClass('list_click').siblings().removeClass('list_click');
						var mainimg=$(this).parent().find('img').attr('src');
						$('input[name="mainpic"]').val(mainimg); 	
				   })
				}

				   //默认上传的第一张的主图片
				$('input[name="line_imgss[]"]').each(function(i, val){
					if(i==0){	
						$("#OriginalPic").find("img").attr("src",$(this).val());//css
						$("#OriginalPic").find("img").css("max-height","130px");
					}
				})
				close_xiuxiu();
			  /*  $('#'+fileId).next('input').val(data.msg);
			   $('#'+fileId).nextAll('.fangda_box').show().find('img').attr('src',data.msg) */
		    } else {
			    alert(data.msg);
		    }
		    
		}
	  
	    
		 $("#img_upload").show();
		 $(".close_xiu").show();
}
$(document).mouseup(function(e) {
    var _con = $('#img_upload'); // 设置目标区域
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $("#img_upload").hide()
        $('.avatar_box').hide();
        $(".close_xiu").hide();
    }
})
function close_xiuxiu(){
	$("#img_upload").hide()
    $('.avatar_box').hide();	
	$(".close_xiu").hide();
}

//删除图片
function del_line_imgdata(obj,id){ 
    var pid=id;
		if (!confirm("确认删除？")) {
          window.event.returnValue = false;
      }else{
    	      var main_pics=$("#OriginalPic").find("img").attr('src');
    	      var pic=$(obj).parent().find("img").attr("src");
	    	  	if(pic==main_pics){
	    	  		$("#OriginalPic").find("img").attr("src",'');
	    		 //   $(obj).parent().find("img").attr("src",'');
	    			$("#main_pics").val('');
	        	}
    	      
             $(obj).parent().parent('li').remove(); 
            // return false;   		
  	   }	
 }

//定制管家
$.post('/admin/b1/group_line/get_expert_data', {}, function(data) {
		var data = eval('(' + data + ')');
		var array = new Array();
		$.each(data, function(key, val) {
			array.push({
			    text : val.realname,
			    value : val.id,
			    jb : val.nickname,
			    qp : val.nickname
			});
		})
		var comboBox = new jQuery.comboBox({
		    id : "#expert",
		    name : "expertid",// 隐藏的value ID字段
		    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
		    blurAfter : function(item, index) {// 选择后的事件
				if(jQuery('#expertid').val()==''){
					jQuery('#expertid').val('');
					jQuery('#expert').val('');
				}
		    },
		    data : array
		});
		
	})
	
var line_type=<?php if(!empty($line_type)){ echo $line_type;}else{ echo 0;} ?>;
if(line_type==3){
	//出发城市获取
	createChoicePluginPY({
		data:chioceStartCityJson,
		nameId:'startcity',
		valId:'lineCityId',
		width:500,
		isHot:true,
		hotName:'热门城市',
		blurDefault:true,
		isCallback:true,
		callbackFuncName:function() {
			//切换周边游目的地
			/*$.post("/common/area/getRoundTripData",{'startcity':$('#lineCityId').val()},function(json) {
				var data = eval("("+json+")");
				var myArray = new Object();
				myArray.trip=data;
				createChoicePlugin({
					data:myArray,
					nameId:"overcity_arr",
					valId:"overcitystr",
					width:640,
					number:11,
					buttonId:'ds-list'
				});
			});
			return false;*/
		},
	});

}else{
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
			buttonId:'startcity-list'
		});
	});
}
 	/*------------------------------------------------选择目的地-------------------------------------------------------*/
	//目的地(所有)
	
/* 	 $.post("/common/area/getRoundTripData",{},function(json) {
		var data = eval("("+json+")");
		var myArray = new Object();
		if(line_type==3){  //周边游
			myArray.trip=data;
		}else if(line_type==2){ //国内游
			myArray.domestic= chioceDestJson.domestic;
		}else if(line_type==1){ //出境游
			myArray.abroad=chioceDestJson.abroad;
		}
		//所有目的地
		createChoicePlugin({
			data:myArray,
			nameId:"overcity_arr",
			valId:"overcitystr",
			width:640,
			number:11,
			buttonId:'ds-list'
		});
	}); */


  $("body").on("focus","#depart_id",function(){
          $(".ul_expert").css("display","block");
          expert_search();
  })
  $("body").on("blur","#depart_id",function(){
    //   if($(this).attr("data-value")==sell_object)
    //   $(this).val(object_name);
  
  })
  $("body").on("keyup","#depart_id",function(){
          expert_search();
  })
  function expert_search()
  {
        var content=$("#depart_id").val();
        showAllExpert("depart_id",content);
  }

  function callbackTree(data_id,v){
	 	$('#overcityID').val('');
		//选目的地
		var valObj=$("#overcitystr");
		var ids = valObj.val();
		var idArr = ids.split(",");
		var s = true;
	/* 	$.each(idArr ,function(key ,val) {
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
 </script>	
  <?php  echo $this->load->view('admin/common/tree_view'); ?>	 
<?php //echo $this->load->view('admin/b1/common/ztree_script'); ?>
<!-- 线路属性弹出框结束 -->
