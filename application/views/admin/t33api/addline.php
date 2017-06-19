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
    </style>


<!-- /Head -->
<!-- Body -->

<link href="<?php echo base_url() ;?>assets/css/b1_product.css" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/product.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="/assets/js/jquery-1.11.1.min.js"></script>		
 <script src="<?php echo base_url('assets/js/jQuery-plugin/dateTable/jquery.calendarTable.js')?>"></script>
</head>
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav tabs-flat">
					<li class="home" id="line_basc"><a href="#home11" data-toggle="tab">添加产品</a></li>	
					<!-- <li class="" id="expert_training"><a href="#profile17" data-toggle="tab"> 管家培训 </a><li> -->
					<li ><a class="routting"   onclick="change_tab()" href="#profile12" data-toggle="tab" id="routting" name="rout"> 行程安排 </a></li>
					<li ><a href="#profile10"  onclick="change_tab()" data-toggle="tab" > 设置价格 </a></li>	
					<!-- <li ><a href="#profile11"  onclick="change_tab()" data-toggle="tab" > 库存 </a></li> -->	
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
                                               <select style="width:150px;height:auto;" name="line_classify" id="line_classify">
                                                    <option value="1">境外游</option>
                                                    <option value="2">国内游</option>
                                                    <option value="3">周边游</option>
                                                </select>
                                                <span style="color: red;padding-left:20px;"></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路名称：</td>
                                        <td>&nbsp;&nbsp;
                                        	<input type="hidden" id="brand" value="">
                                        	<input type="text" placeholder="10字以内" value="" id="linename" class="form_input w_450" name="linename"/>
                                            <input type="text" value="" id="linenight" class="form_input w_40" name="linenight"/>晚
                                            <input type="text" value="" id="lineday" class="form_input w_40" name="lineday"/><i class="important_title">*</i>天游
                                            <span class="title_txt red">线路名称+副标题总字数不超过50个字</span>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>副标题：</td>
                                        <td><input type="text" placeholder="需重点突出的信息,20字以内" value="" id="linetitle" class="form_input w_600" name="linetitle"></td>
                                    </tr>                                   
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>出发地：</td>
                                        <td>
                                        	<input type="text" placeholder="出发地" class="form_input w_180 fl" id="startcity" name="startcity" autocomplete="off" value="">
                                            <input type="hidden" name="lineCityId" id="lineCityId" value="">
                                           
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>目的地：</td>
                                        <td id="select_dest">
                                        	<input type="text" placeholder="目的地" class="form_input w_180 fl" id="overcity" name="overcity">
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title">主题游：</td>
                                        <td id="select_theme">
                                        <input type="text" placeholder="主题游" class="form_input w_180 fl" id="themeid" name="themeid">
                                        </td>
                                    </tr>  
                                    <tr height="34" class="form_group">
                                        <td class="form_title">上车地点：</td>
                                        <td id="select_dest">
                                        	<input type="text" placeholder="上车地点" class="form_input w_180 fl" id="car_address" name="car_address">
                                        </td>
                                    </tr>  
                                    <tr height="34" class="form_group">
                                        <td class="form_title">提前：</td>
                                        <td>
                                              <input type="text" placeholder="" id="linebefore" class="form_input" name="linebefore" style="width: 50px;" value=""/>
                                              <span>天</span>
                                              <input type="text" placeholder="" id="linedatehour" class="form_input" name="hour" style="width: 50px;" 
                                                    value=""/>
                                              <span> 小时</span>
                                              <input type="text" placeholder="" id="linedateminute" class="form_input" name="minute" style="width: 50px;" 
                                                   value=""/>
                                              <span> 分 截止报名</span>
                                        </td>
                                    </tr>  

                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>线路特色：</td>
                                        <td>
                                        	<textarea placeholder="其他显示信息(600字以内)" style="width:300px;height:120px;" class="noresize w_600"  id="features" name="features"></textarea>
                                        </td>
                                    </tr>
                                    <tr height="34" class="form_group">
                                        <td class="form_title"><i class="important_title">*</i>主图片：</td>
                                        <td>
                                         	<input type="text"  id="file" class="form_input w_180 fl"  name="mainpic" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310265115399.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
                                         	<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" >
											<input type="text"  id="file" class="form_input w_180 fl"  value="/file/upload/20170425/149310298924142.jpg" name="line_img[]" > 
                                        </td>
                                    </tr>   
                                    <tr height="34" class="form_group">
                                        <td class="form_title">产品标签：</td>
                                        <td>
                                            <input type="text"  id="depart_id" class="form_input w_180 fl"  autocomplete="off"  name="linetype" >

                                        </td>
                                    </tr>
                                </table>
								<table class="departure_notice table_form_content table_td_border" border="1" width="800">                                
                                        <tbody>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用包含：</td>
                                                <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="feeinclude" id="feeinclude"></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100"><i class="important_title">*</i>费用不含：</td>
                                                <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="feenotinclude" id="feenotinclude"></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">购物自费：</td>
                                                <td  style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="other_project" id="other_project"></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">保险说明：</td>
                                                <td  style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="insurance" id="insurance"></textarea></td>
                                            </tr>
                                            <tr class="form_group">
                                                <td class="form_title w_100">签证说明：</td>
                                                <td  style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="visa_content" id="visa_content"></textarea></td>
                                            </tr>
	                                        <tr class="form_group">
		                                        <td class="form_title w_100"><i class="important_title">*</i>温馨提示：</td>
		                                        <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="beizu" id="editor"></textarea></td>
		                                    </tr>
		                                    <tr class="form_group">
		                                        <td class="form_title w_100"><i class="important_title">*</i>特别约定：</td>
		                                        <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="special_appointment" id="special_appointment"></textarea></td>
		                                    </tr>
		                                    <tr class="form_group">
		                                        <td class="form_title w_100"><i class="important_title">*</i>安全提示：</td>
		                                        <td style="height:120px;"><textarea  style="height:110px;" class="form_textarea w_600 noresize" name="safe_alert" id="safe_alert"></textarea></td>
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
						
								<div class="problem_div">
									<div class="problem_title fl">
									       <span class="num">问题</span>
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

							</div>
						</div>
						<div>
						     
							  <label for="inputImg" class="col-sm-2 control-label no-padding-right" style=" width:20%;"></label>
							  <button  class="btn btn-palegreen"  type="button" id="sub_line"> <b  style="font-size:14px">保存</b></button>
						</div>
					</form>	
					</div>

					<div class="title_info_box" style="display:none;position:fixed;border:1px solid #f00;text-align:left;text-indent:30px;width:300px;padding:10px;background:#fff;z-index:999;color:#f00;font-size:14px;top:100px;right:20px;font-weight:600;">	
                       	
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
          				
<script type="text/javascript">


jQuery('#sub_line').click(function(){
	jQuery.ajax({ type : "POST",data : jQuery('#lineInfo').serialize(),async:false,url : "<?php echo base_url()?>t33Api/line/addlineData", 
			success : function(result) {
				var result=eval("("+result+")");
				if(result.code==200){
					alert(result.msg);
					window.location.href="/t33Api/line/edit?linecode="+result.linecode.linecode;
				}else{
					alert(result.msg);
				}
				///t33api/line/edit?linecode=L32222
			}
	});
	return false;
});

function change_tab(){
	
	 $("#myTab11").find('li').removeClass('active');
	 $("#line_basc").addClass('active');
	 alert('请选添加产品');
	 return false;
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




