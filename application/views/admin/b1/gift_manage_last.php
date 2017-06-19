<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/ht/css/base.css'); ?>" rel="stylesheet" />
<style type="text/css">
	* { box-sizing:border-box;}
	.order_info_table { margin-top:0;}
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.webuploader-pick{ left:0px;}
	.parentFileBox{float:left;width:100px;}
	.parentFileBox .fileBoxUl{display:none;};
	.parentFileBox .diyButton{float:left;};
	.form-group .col_ip{float:left; }
	.form-group .col_xl{ float: left;text-align:right; width: 135px;}
	.col_price{ width: 100px; float: left; text-align: right;padding-top: 4px;}
	.price_input{ margin-left: 5px; padding: 4px 2px;}
	.lp_div .col-sm-4{ width:83%;}
	.lp_div .col-sm-4 input{width: 90%; height: 30px;}
	.lp_div .col-sm-4 textarea{width: 90%; }
	.lp_div .col-sm-4 .jg_my{ line-height: 30px;}
	.lp_div .col-sm-4 .hege{float: left;font-size: 20px;padding:0px 7px;}
	.lookgfit_div  .col-sm-4{ top:7px;}
	.looklinegfit_div .col-sm-4{ top:7px;}
	.gift_zl table tr td{padding:5px;}
	
	.form-horizontal .form-group label,.form-horizontal .form-group .col-lg-4 { padding-left:0;}
</style>
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<script src="/assets/js/jquery-1.11.1.min.js"></script>		
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="#">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">礼品管理</li>
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
					<li class="active" name="tabs"><a href="#home11" data-toggle="tab" id="tab0"> 礼品列表</a></li>
					<li class="" name="tabs"><a href="#profile11" data-toggle="tab" id="tab1"> 已发放</a></li>
				</ul>
				<div class="tab-content tabs-flat search_box">
				      <div class="title_zif"><span class="tianjia_btn"  id="addgift" style="cursor:pointer;display:inline-block;margin-bottom:10px;padding:6px 10px;color:#fff;background-color:#2dc3e8">+添加</span></div>
				    	<div id="home" class="tab-pane active">
								<div class="widget-body">
									<div id="registration-form">
										<form novalidate="novalidate" id="registrationForm" method="post" class="form-horizontal bv-form" data-bv-message="This value is not valid" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
											<div class="form-group has-feedback">
												<label style="width: 100px; float:left" class="col-lg-4 control-label">礼品名称：</label>
												<div style="width:20%;float:left" class="col-lg-4 w_160">
													<input style="width:100%"  type="text" class="form-control user_name_b1 w_140" name="title" >
												</div>
												<label style="width:auto;float:left" class="col-lg-4 control-label">起止时间：</label>
												<div style="width:10%;float:left" class="col-lg-4 w_160">
												   <div class="input-group">
											                     <span class="input-group-addon">
											                       <i class="fa fa-calendar"></i>
											                     </span>
											                     <input type="text" style="width:180px;" name="endtime1" id="endtime1" class="form-control w_140">
											          </div>
												</div>
												<label style="width: 2%;" class="col-lg-4 control-label">&nbsp;</label>
												<div style="width: 10%;float:left;margin-left:30px;" class="col-lg-4">
													<input type="button" id="searchfrom" class="btn btn-palegreen" value="搜索">
												</div>
											</div>
										</form>
										<div id="list"> </div>
									</div>
								</div>
							</div>
			              <!-- 已发放 -->
						  	<div id="home0" class="tab-pane">
								<div class="widget-body">
									<div id="registration-form">
										<form novalidate="novalidate" id="registrationForm0" method="post" class="form-horizontal bv-form" data-bv-message="This value is not valid" data-bv-feedbackicons-valid="glyphicon glyphicon-ok" data-bv-feedbackicons-invalid="glyphicon glyphicon-remove" data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
											<div class="form-group has-feedback">
												<label style="width: 100px; float:left" class="col-lg-4 control-label w_140">礼品名称：</label>
												<div style="width:20%;float:left" class="col-lg-4">
													<input style="width:100%" type="text" class="form-control user_name_b1 w_160" name="title" >
												</div>
												<label style="width:auto;float:left" class="col-lg-4 control-label">起止时间：</label>
												<div style="width:10%;float:left" class="col-lg-4 w_160">
												   <div class="input-group">
											                     <span class="input-group-addon">
											                               <i class="fa fa-calendar"></i>
											                     </span>
											                     <input type="text" style="width:180px;" name="endtime2" id="endtime2" class="form-control w_140">
											           </div>
												</div>
												<label style="width: 2%;" class="col-lg-4 control-label">&nbsp;</label>
												<div style="width: 10%;float:left;margin-left:30px;" class="col-lg-4">
													<input type="button" id="searchfrom0" class="btn btn-palegreen" value="搜索">
												</div>
							
											</div>
							
										</form>
										<div id="list1"></div>      
								</div>
							</div>				
						</div>
					</div>					
				</div>
			</div>
		</div>
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
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3"><span style="color: red;">*</span>数量:</label>
			            <div class="col-sm-4 fl">
			               <input  style="float:left" type="text" name="account" style="height:30px;" />&nbsp;<span class="jg_my ">张</span>
			            </div>
			        </div>
			          <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl"  for="inputPassword3"><span style="color: red;">*</span>价值:</label>
			            <div class="col-sm-4 fl ">
			               <input  style="float:left"  type="text" name="worth" style="height:30px;" />&nbsp;<span class="jg_my">元</span>
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
<!-- 新增礼品结束 -->
<div class="lookgfit_div modal fade in" style="display:none;">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:600px;height:500px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title">礼品详情</h4>
			    </div>
			    <div class="modal-body">
                	<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" id="lookgiftFrom">
                        <tbody>
                            <tr height="40">
                                <td class="order_info_title">礼品名称:</td>
                                <td class="gift_div_1"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">有效期:</td>
                                <td class="gift_div_2"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">数量:</td>
                                <td class="gift_div_3"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">价值:</td>
                                <td class="gift_div_4"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">图片:</td>
                                <td class="gift_div_5"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">说明:</td>
                                <td class="gift_div_6"><span></span></td>
                            </tr>
                        </tbody>
                    </table>               
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<!-- 查看礼品  -->
<!-- 查看线路礼品结束 -->
<div class="looklinegfit_div modal fade in" style="display:none;">
	<div style="position:absolute;left:50%;margin-left:-300px;" class="modal-dialog">
		  <div style="width:600px;" class="modal-content">
		       <div class="modal-header">
			       <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
			       <h4 class="modal-title">礼品详情</h4>
			    </div>
			    <div class="modal-body" style="height:100%;overflow-y:auto;overflow-x:hidden;">
                	<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0" id="lookgiftFrom">
                        <tbody>
                            <tr height="40">
                                <td class="order_info_title">礼品名称:</td>
                                <td class="gift_div_1"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">有效期:</td>
                                <td class="gift_div_2"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">数量:</td>
                                <td class="gift_div_3"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">价值:</td>
                                <td class="gift_div_4"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">图片:</td>
                                <td class="gift_div_5"><span></span></td>
                            </tr>
                            <tr height="40">
                                <td class="order_info_title">说明:</td>
                                <td class="gift_div_6"><span></span></td>
                            </tr>
                        </tbody>
                    </table>
			    <!--<div class="bootbox-body">
			       <form  class="form-horizontal" id="lookgiftFrom" method="post" action="">
			         <div class="gift_member">		
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">礼品名称:</label>
			            <div class="col-sm-4 fl gift_div_1">
			            	<span></span>
			            </div>
			        </div>
			         <div class="form-group">
			            <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">有效期:</label>
			            <div class="col-sm-4 fl gift_div_2" style="width:400px;">
							 <span></span>		
			            </div>
			        </div>
			         <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">数量:</label>
			            <div class="col-sm-4 fl gift_div_3">
			              <span></span>
			            </div>
			        </div>
			          <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl"  for="inputPassword3">价值:</label>
			            <div class="col-sm-4 fl gift_div_4">
			              <span></span>
			            </div>
			        </div>
			          <div class="form-group">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">图片:</label>
			            <div class="col-sm-4 fl gift_div_5" id="gift_pic" >
			              <span></span>
			            </div>
			        </div>
			          <div class="form-group ">
			              <label class="col-sm-2 control-label no-padding-right fl" for="inputPassword3">说明:</label>
			            <div class="col-sm-4 fl gift_div_6">
			              <span></span>
			            </div>
			        </div>
                 </div>
			    </form>
			    </div> -->
			     <div class="gift_zl">
			<!-- 		<table  class="table table-bordered dataTable no-footer " >
						<thead>
							<tr role="">
								 <th style="width: 100px;text-align:center;">序号 </th>
								 <th style="width: 150px;text-align:center;font-weight:500">会员昵称</th>
								<th style="width: 170px;text-align:center;font-weight:500">手机号</th>
								<th style="width: 170px;text-align:center;font-weight:500">中奖时间</th>
								<th style="width: 100px;text-align:center;font-weight:500">使用状态</th>
							</tr>
						</thead>
						<tbody class="">		
							<tr style="" class="" >
						           <td style="text-align:center"></td>
						           <td style="text-align:center"></td>
						           <td style="text-align:center"></td>
						           <td style="text-align:center"></td>
						           <td style="text-align:center"></td>
			                 </tr>	
			            </tbody> 
			         </table> -->
				 </div>                         		
		     </div>
		 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
$('#addgift').click(function(){
	$('.gift_biaoti').html('添加礼品');
	$('#giftFrom').find('input[name="gift_id"]').val('');
    $('#giftFrom').find('input[name="gift_name"]').val('');
    $('#giftFrom').find('input[name="startdatetime"]').val('');
    $('#giftFrom').find('input[name="enddatetime"]').val('');
    $('#giftFrom').find('input[name="account"]').val('');
    $('#giftFrom').find('input[name="worth"]').val('');
    $('#giftFrom').find('input[name="logo"]').val('');
    $('#giftFrom').find("img").attr("src",'');
    $('#giftFrom').find('textarea[name="description"]').val('');
    
	 $('.lp_div').show();
 })
 $('.bootbox-close-button').click(function(){
	$('.bootbox').hide();
	$('.lp_div').hide();
	$('.lookgfit_div').hide();
	$('.looklinegfit_div ').hide();
});
/*线路的抽奖礼品*/
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:true, //是否显示小时
	format:'Y-m-d H:i', //选中显示的日期格式
	formatDate:'Y-m-d H:i',
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:true, //是否显示小时
	format:'Y-m-d H:i', //选中显示的日期格式
	formatDate:'Y-m-d H:i',
}); 


/************************************美图秀秀**************************************************/
function change_avatar(obj,type){
	
		$('.avatar_box').show();
		var size='';
		if(type==0){
			size='500x300';
		 }else{
			size='400x400';	
		}
	   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
	   xiuxiu.setLaunchVars("cropPresets", size);
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
		    if (data.code == 2000){ 
		       if(type==2){   //礼品上传图片
				  
				    $('#gift_pic').find("img").attr("src",data.msg);
				    $('input[name="logo"]').val(data.msg);
				    
				}
				close_xiuxiu();	
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

//礼品的新增,编辑
$('#gift_button').click(function(){
   var gift_name= $('#giftFrom').find('input[name="gift_name"]').val();
   var starttime= $('#giftFrom').find('input[name="startdatetime"]').val();
   var endtime= $('#giftFrom').find('input[name="enddatetime"]').val();
   var account= $('#giftFrom').find('input[name="account"]').val();
   var worth= $('#giftFrom').find('input[name="worth"]').val();
   var  logo=$('#giftFrom').find('input[name="logo"]').val();
   var description=$('#giftFrom').find('textarea[name="description"]').val(); 
   if(gift_name==''){
	   alert('礼品名称不能为空!');
	   return false;
   }
   if(starttime=='' && endtime==''){
	   alert('有效日期不能为空!');
	   return false;
   }
   if(account==''){
	   alert('礼品的数量不能为空!');
	   return false;
   }
   if(worth==''){
	   alert('礼品的价值不能为空!');
	   return false;
   }
		
   jQuery.ajax({ type : "POST",data : jQuery('#giftFrom').serialize(),url : "<?php echo base_url()?>admin/b1/gift_manage/addGift", 
		success : function(data) {
			 var data=eval("("+data+")");
			 if(data.status==1){  //添加礼品
				 alert(data.msg);
				 $('#tab0').click();
			 }else if(data.status==2){  //修改礼品 
				 alert(data.msg);
				 $('#tab0').click();
		     }else{
				 alert(data.msg);
			 }
			 
		}
	});

	$('.bootbox-close-button').click();
})


//查看礼品
function look_gift(obj){
	var id=$(obj).attr('data');
	if(id>0){
		   jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/editGift", 
				success : function(data) {
					 var data=eval("("+data+")");
					 if(data.status==1){
						   $('#lookgiftFrom').find('.gift_div_1 span').html(data.gift.gift_name);
						   $('#lookgiftFrom').find('.gift_div_2 span').html(data.gift.starttime+'至'+data.gift.endtime);
						   $('#lookgiftFrom').find('.gift_div_3 span').html(data.gift.account+'张');	
						   $('#lookgiftFrom').find('.gift_div_4 span').html(data.gift.worth+'元');
						   $('#lookgiftFrom').find('.gift_div_5 ').html('<img style="width:170px;height:150px;" src="'+data.gift.logo+'">');
						   $('#lookgiftFrom').find('.gift_div_6 span').html(data.gift.description);							    
					 }else{
						 alert(data.msg);
					 }
				}
			});
		   $('.lookgfit_div').show();
	}else{
	   alert('暂不能查看,请重新刷新页面;');	
	}
}

//查看线路礼品
function look_line_gift(obj){
	var id=$(obj).attr('data');
	var lineid=$(obj).attr('line');
	$('.gift_zl').html('');
	if(id>0){
		   jQuery.ajax({ type : "POST",data :"id="+id+'&line='+lineid,url : "<?php echo base_url()?>admin/b1/gift_manage/lookLineGift", 
				success : function(data) {
					 var data=eval("("+data+")");
					 if(data.status==1){
						   $('.member_mesg').remove(); 
						   $('.looklinegfit_div ').find('.gift_div_1 span').html(data.gift.gift_name);
						   $('.looklinegfit_div ').find('.gift_div_2 span').html(data.gift.starttime+'至'+data.gift.endtime);
						   $('.looklinegfit_div ').find('.gift_div_3 span').html(data.gift.account+'张');	
						   $('.looklinegfit_div ').find('.gift_div_4 span').html(data.gift.worth+'元');
						   $('.looklinegfit_div ').find('.gift_div_5 ').html('<img style="width:100px;height:100px;" src="'+data.gift.logo+'">');
						   $('.looklinegfit_div ').find('.gift_div_6 span').html(data.gift.description);
						   var mgaddtime=data.gift.mgaddtime;
						   var str="";
						   if(mgaddtime==''){
							     str="暂没中奖";    
							}else{
								str=mgaddtime;
							}	
						   $('.looklinegfit_div ').find('.gift_div_7 span').html(str);
						   var mgstatus=data.gift.mgstatus;
						   var str0='';
						   if(mgstatus!=''){
							   if(mgstatus==0){
								   str0='未使用';
							    }else if(mgstatus==1){
							    	 str0='已使用';
								}else if(mgstatus==2){
									 str0='已过期';
								}
						   }
						   $('.looklinegfit_div ').find('.gift_div_8 span').html(str0);
						
						   if(data.memberArr!=''){ 
							   var titleStr='<table  class="table table-bordered dataTable no-footer " ><thead>';
							   titleStr=titleStr+'<tr role=""><th style="width: 100px;text-align:center;">序号 </th>';  
							   titleStr=titleStr+'<th style="width: 150px;text-align:center;font-weight:500">会员昵称</th>'; 
							   titleStr=titleStr+'<th style="width: 170px;text-align:center;font-weight:500">手机号</th>';
							   titleStr=titleStr+'<th style="width: 170px;text-align:center;font-weight:500">中奖时间</th>';
							   titleStr=titleStr+'<th style="width: 100px;text-align:center;font-weight:500">使用状态</th></tr></thead><tbody class="">';
							  　 $.each(data.memberArr, function(i, val){ 
 
								     if(val.status==0){
								    	str='未使用';
									  }else if(val.status==1){
										  str='已使用';
									  }else if(val.status==2){
										  str='已过期';
									  }
								     titleStr=titleStr+'<tr style="" class="" >'; 
								     titleStr=titleStr+' <td style="text-align:center">'+i+'</td>'; 		
								     titleStr=titleStr+' <td style="text-align:center">'+val.nickname+'</td>';
								     titleStr=titleStr+' <td style="text-align:center">'+val.mobile+'</td>';
								     titleStr=titleStr+' <td style="text-align:center">'+val.addtime+'</td>';
								     titleStr=titleStr+' <td style="text-align:center">'+str+'</td>';
								      　 							    								      
							　}); 
							   titleStr=titleStr+'</tbody>';
							   $('.gift_zl').append(titleStr); 
							 }
					 }else{
						 alert(data.msg);
					 }
				}
			});
		   $('.looklinegfit_div').show();
	}else{
	   alert('暂不能查看,请重新刷新页面;');	
	}
}
//$('.edit_gift').click(function(){
function edit_gift(obj){
	$('.gift_biaoti').html('编辑礼品');
	var id=$(obj).attr('data');
	var gift_id=$('#giftFrom').find('#gift_id').val(id);
	if(id>0){
		   jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/product/editGift", 
				success : function(data) {
					 var data=eval("("+data+")");
					 if(data.status==1){	
						    $('#giftFrom').find('input[name="gift_name"]').val(data.gift.gift_name);
						    $('#giftFrom').find('input[name="startdatetime"]').val(data.gift.starttime);
						    $('#giftFrom').find('input[name="enddatetime"]').val(data.gift.endtime);
						    $('#giftFrom').find('input[name="account"]').val(data.gift.account);
						    $('#giftFrom').find('input[name="worth"]').val(data.gift.worth);
						    $('#giftFrom').find('input[name="logo"]').val(data.gift.logo);
						    $('#giftFrom').find("img").attr("src",data.gift.logo);
						    $('#giftFrom').find('textarea[name="description"]').val(data.gift.description); 
					 }else{
						 alert(data.msg);
					 }
				}
			});
		   $('.lp_div').show();
	}else{
	   alert('暂不能修改,请重新刷新页面;');	
	}
	
}
//礼品的下架
function up_gift(obj){
	var str='';
	var id=$(obj).attr('data');
	var status=$(obj).attr('status');
	if(status==1){
		str="下架该产品？";
	}else{
		str="上架该产品？";
   }
	if(id>0){
		 if (!confirm(str)) {
	            window.event.returnValue = false;
	        }else{
	        	 jQuery.ajax({ type : "POST",data :"id="+id+'&status='+status,url : "<?php echo base_url()?>admin/b1/gift_manage/upGift", 
	        		 success : function(data) {
	        			 var data=eval("("+data+")");
	        			  alert(data.msg);
	        			  $('#tab0').click();
	        		/* 	  if(status==1){
		        			  $('#tab0').click();
		        		  }else if(status==0){
		        			  $('#tab1').click();
			        	  } */
						
		        	 }
	        	 })
		    }
	}else{
		alert('操作失败!');
	}
}

//删除礼品
function del_gift(obj,type){
	var id=$(obj).attr('data');
	if(id>0){
		 if (!confirm('删除该礼品')) {
	            window.event.returnValue = false;
	        }else{
	        	 jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/gift_manage/delGift", 
	        		 success : function(data) {
	        			 var data=eval("("+data+")");
	        			  alert(data.msg);
	        			  if(data.status==1){
	        				  $('#tab0').click();
		        		  }
		        	 }
	        	 })
		    }
	}else{
		alert('操作失败!');
	}
}
//线路礼品的删除
function del_line_gift(obj,type){
	var id=$(obj).attr('data');
	if(id>0){
		 if (!confirm('删除该线路就的礼品')) {
	            window.event.returnValue = false;
	        }else{
	     	
	         jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/b1/gift_manage/delLineGift", 
	        		 success : function(data) {
	        			 var data=eval("("+data+")");
	        			  alert(data.msg);
	        			  if(data.status==1){
	        				  $('#tab1').click();
		        		  }
		        	 }
	        	 })
	        	 
		    }
	}else{
		alert('操作失败!');
	}

}
$('#endtime1').datetimepicker({
	lang:'ch', //显示语言
	timepicker:true, //是否显示小时
	format:'Y-m-d H:i', //选中显示的日期格式
	formatDate:'Y-m-d H:i',
}); 
$('#endtime2').datetimepicker({
	lang:'ch', //显示语言
	timepicker:true, //是否显示小时
	format:'Y-m-d H:i', //选中显示的日期格式
	formatDate:'Y-m-d H:i',
}); 
</script>
<?php echo $this->load->view('admin/b1/common/gift_manage_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>







