<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<style type="text/css">
	.col-lg-4 { float: left;}
	.form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
	.registered_btn a{ padding:8px 4px; background: #2dc3e8;color: #fff; border-radius: 3px;  text-decoration: none}
	#myTab11{ margin-top: 20px;}
	#registration-form { padding-top:15px;}
	.pagination { padding-bottom:20px;}
	#select select { width:100px;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">售卖管家</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered search_box">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
			<!--  <span class="registered_btn"><a href="/admin/b1/app_line/registered_expert">注册直属管家</a></span> -->
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs">
					<a href="#home11" data-toggle="tab" id="tab0"> 售卖管家 </a></li>
				</ul>
				<div class="tab-content tabs-flat">
					<!-- 未结算 -->
					<div class="tab-pane active" id="tab_content0">
						<div class="widget-body">
							<div id="registration-form">
								<form
									data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
									data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
									data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
									data-bv-message="This value is not valid"
									class="form-horizontal bv-form" method="post" id="listForm"
									novalidate="novalidate">
									<div class="form-group has-feedback">
                                    	<div class="fl">
										<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">线路名称：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
									       <input class="form-control user_name_b1" type="text" name="linename">
										</div>	
                                        </div>
                                        <div class="fl">
										<label class="col-lg-4 control-label"  style="width: 100px;padding-right:0px;">出发地：</label>
										<div class="col-lg-4" style="width:auto;padding-left:2px;">
											<input type="text" id="startcity" class="form-control" name="startcity" autocomplete="off" style="width:100px;" >	
											<input type="hidden" name="formcity" id="formcity" value="">
										</div>	
										</div>
                                        <div class="fl">
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">目的地：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											  <input id="cityName"  style="width: 120px;" type="text" name="cityName"  onfocus="b1_showCGZDestTree(this);" class="form-control user_name_b1" />
										      <input  id="destcity"  name="destcity" type="hidden" value=""  /> 
											<!--  <div id="select">
											<?php if(!empty($destinations)){?>
											  <select name="dest_id" id="dest_id">
													<option value='-1'>请选择</option>
											  <?php foreach ($destinations as $k=>$v) {?>
											   <option value='<?php echo $v['id']; ?>'> <?php echo $v['description']; ?></option>
											   <?php }?>
											  </select>					
											<?php } ?>
											</div>-->
										</div>
										</div>
                                        <div class="fl">			
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">管家：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											<!-- <select name="expert">
												<option value="">请选择</option>
											<?php //foreach ($expert as $k=>$v) {?>
											  <option value="<?php // echo $v['id']; ?>"> <?php // echo $v['realname']; ?></option>
											  <?php // }?>
											</select> -->
											<input type="text" id="expertname" class="form-control" name="expertname" autocomplete="off" style="width:100px;" >
										</div>
                                        </div>
                                        <div class="fl">
										<label class="col-lg-4 control-label" style="width: 100px;padding-right:0px;">管家级别：</label>
										<div class="col-lg-4" style="width: auto;padding-left:2px;">
											<select name="expert_grade" style="width:100px;">
												 <option value="">请选择</option>
												 <option value="1" <?php if(!empty($type)){ if($type==1){ echo 'selected';}} ?>> 管家</option>
												 <option value="2"  <?php if(!empty($type)){ if($type==2){ echo 'selected';}} ?>> 初级专家</option>	 
												 <option value="3" <?php if(!empty($type)){ if($type==3){ echo 'selected';}} ?>> 中级专家</option>	
												 <option value="4"  <?php if(!empty($type)){ if($type==4){ echo 'selected';}} ?>> 高级专家</option>	
											</select>
										</div>
                                        </div>
                                        <div class="fl">
										<input type="hidden" name="status" value="2" >
										<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
										<div class="col-lg-4" style="width: 5%;padding-left:2px;">
											<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch">
										</div>
                                        </div>
									</div>
								</form>

								<div id="list"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<!--弹窗提示-->
<div id="redund_myModal_1" style="display: none;">
	<div class="bootbox-body">
		<form class="form-horizontal" role="form" method="post"
			action="<?php echo base_url().'admin/b1/app_line/refuse';?>">

			<div class="form-group">
				<label for="inputPassword3"
					class="col-sm-2 control-label no-padding-right">原因</label> <input
					type="hidden" class="form-control" id="hidden_line_sn"
					name="line_id" value="" />
				<div class="col-sm-10">
					<textarea name="reason"
						style="resize: none; width: 100%; height: 100%">原因</textarea>
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-palegreen"
					data-bb-handler="success" value="提交"
					style="float: right; margin-right: 2%;">
			</div>
		</form>
	</div>
</div>


<!--调整级别的弹窗-->
<div id="update_expert" style="display: block;"></div>
<!-- 管家搜索 -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>

<?php echo $this->load->view('admin/b1/common/app_line_script'); ?>
<?php echo $this->load->view('admin/b1/common/time_script'); ?>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">

$(document).on('mouseover', '.title_info', function(){
		
		var lineid=$(this).attr('lineid');
		var expert=$(this).attr('expert');
		var string='管家';
		var remark='';
		//type : "POST",data :"id="+id,
		jQuery.ajax({ type : "POST",data :'lineid='+lineid+'&expert='+expert,url : "<?php echo base_url();?>admin/b1/app_line/get_expert_refuse", 
			success : function(data) {
				data = eval('('+data+')');
		        if(data.status==1){	
					if(data.res.grade_after==1){
						var string='管家';
					}else if(data.res.grade_after==2){
						var string='初级专家';
					}else if(data.res.grade_after==3){
					    	var string='中级专家';
					}else if(data.res.grade_after==4){
						var string='高级专家';
					}
					remark=data.res.refuse_remark;
					var html='';
					html=html+'<div class="info_txt" id="info_txt" style="width:340px;text-align:left;border:1px solid #aaa;background:#fff;z-index:999;position:absolute;left:40px;top:0;display:none;">';
					html=html+'<p>您申请的"'+string+'"请求未通过.</p><p>原因:'+remark+'</p></div>';     
					$('.title_info').append(html);
						
              	}else{
            	     alert(re.msg);	  
             	} 

			}
		
		});

	
		$(this).find(".info_txt").show();

	});
$(document).on('mouseout', '.title_info', function(){
		$(".info_txt").hide();
	});

/*弹窗提示*/
function show_receive_dialog(obj){

       var id = $(obj).attr('data');

       $("#hidden_line_sn").val(id);

       bootbox.dialog({
             message: $("#redund_myModal_1").html(),
             title: "提示",
       });
}
/*调整级别的弹窗*/
function show_expert(obj){
	
	var id = $(obj).attr('data');
	var name = $(obj).attr('data-val');
	var expert_id = $(obj).attr('expert_id');
	var lineid=$(obj).attr('lineid');

    $("#update_expert").html('<div id="expert_text"></div>');
	$("#update_expert").css("display","block");
	
	 var from='<form class="form-horizontal" id="AdjustFrom" role="form" method="post" action="<?php echo base_url();?>admin/b1/app_line/adjustLevel" onsubmit="return AdjustLevel();" >'+
		   '<div class="form-group">'+
	      ' <label for="inputPassword2" class="col-sm-2 control-label no-padding-right" style= "float:left; width:16%;text-align:right">专家级别</label>'+
	      ' <div class="col-sm-10" id="selexpert" style= "float:left;">	'+
	      '<select name="selexpert" id="selexpert"><option value="">请选择</option>'+
	      '<option value="1">管家</option>'+
		  '<option value="2">初级专家</option>'+
			'<option value="3">中级专家</option>'+
		    '<option value="4">高级专家</option></select>'+
	      ' </div>	</div> <div class="form-group" style= " clear:both;">'+
	    ' <input type="hidden" class="form-control" id="hidden_id" name="id" value="'+id+'" />'+
	    ' <input type="hidden" class="form-control" id="expert_id" name="expert_id" value="'+expert_id+'" />'+
	    ' <input type="hidden" class="form-control" id="lineid" name="lineid" value="'+lineid+'" />'+
	     '<label for="inputPassword3" class="col-sm-2 control-label no-padding-right" style=" float:left; text-align:right; width:16%;">申请理由</label>'+
	     '<div class="col-sm-10" style=" float:left";> <textarea name="reason" style="resize:none;width:100%;height:100%" ></textarea>'+
	    ' </div></div> <div class="form-group">'+
	    '<input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;"></div></form>';

 
    bootbox.dialog({
             message: $("#expert_text").html(from),
             title: "申请级别",
    }); 
}

//ajax调整专家级别
function AdjustLevel(){

	jQuery.ajax({ type : "POST",data : jQuery('#AdjustFrom').serialize(),url : "<?php echo base_url();?>admin/b1/app_line/adjustLevel", 
		success : function(re) {
    		re = eval('('+re+')');
	          if(re.status==1){
	        	     alert(re.msg);
	        		 jQuery('#tab0').click();
	        		 $('.bootbox-close-button').click();
              }else{
            	     alert(re.msg);	  
              }

		}
	});
	
	
	return false;
}

//申请中目的地的二级联动    
$('select[name="dest_id"]').change(function(){

	$('#pdest_id').remove();
	$('#cdest_id').remove();
	var dest_id = $('select[name="dest_id"] :selected').val();	
	$.post("<?php echo base_url()?>admin/b1/app_line/get_destinations", { id:dest_id} , function(data) {
		if(data){		
			data = eval('('+data+')');
	  		$('#dest_id').after("<select name='pdest_id' id='pdest_id'><option value='-1'>请选择</option></select>");
			$.each(data ,function(key ,val){
				str = "<option value='"+val.id+"'>"+val.kindname+"</option>";
				$('#pdest_id').append(str);		
			})
			$('#pdest_id').change(function(){
				$('#cdest_id').remove();
				var pdest_id = $('select[name="pdest_id"] :selected').val();
				pdest(pdest_id);
			})	
		            
		}else{
			 $('#select').append(result); 
		}  
	});
});

function pdest(id){	   
		$.post("<?php echo base_url()?>admin/b1/app_line/get_destinations", { id:id} , function(data) {
			if(data){		
				data = eval('('+data+')');
				if(data!=''){
			  		$('#pdest_id').after("<select name='cdest_id' id='cdest_id'><option value='-1'>请选择</option></select>");
					$.each(data ,function(key ,val){					
						str = "<option value='"+val.id+"'>"+val.kindname+"</option>";
						$('#cdest_id').append(str);
					})  
				}
			}else{
				 $('#select').append(result); 
			}  
		});
}

//已申请申请目的地的二级联动    
$('select[name="dest_id1"]').change(function(){

	$('#pdest_id1').remove();
	$('#cdest_id1').remove();
	var dest_id = $('select[name="dest_id1"] :selected').val();	
	$.post("<?php echo base_url()?>admin/b1/app_line/get_destinations", { id:dest_id} , function(data) {
		if(data){		
			data = eval('('+data+')');
	  		$('#dest_id1').after("<select name='pdest_id1' id='pdest_id1'><option value='-1'>请选择</option></select>");
			$.each(data ,function(key ,val){
				str = "<option value='"+val.id+"'>"+val.kindname+"</option>";
				$('#pdest_id1').append(str);		
			})
			$('#pdest_id1').change(function(){
				var pdest_id = $('select[name="pdest_id1"] :selected').val();
				pdest1(pdest_id)
			})	
		            
		}else{
			 $('#select1').append(result); 
		}  
	});
});

function pdest1(id){	   
		$.post("<?php echo base_url()?>admin/b1/app_line/get_destinations", { id:id} , function(data) {
			if(data){		
				data = eval('('+data+')');
				if(data!=''){
			  		$('#pdest_id1').after("<select name='cdest_id1' id='cdest_id1'><option value='-1'>请选择</option></select>");
					$.each(data ,function(key ,val){					
						str = "<option value='"+val.id+"'>"+val.kindname+"</option>";
						$('#cdest_id1').append(str);
					})  
				}
			}else{
				 $('#select1').append(result); 
			}  
		});
}

//始发地联动
$('select[name="province"]').change(function(){

 	var province_id = $('select[name="province"] :selected').val();
	$('#formcity').remove();	
	$.post(
		"<?php echo site_url('admin/b1/product_insert/get_area')?>",
		{'id':province_id},
		function(data) {
			data = eval('('+data+')');
			$('#province').after("<select name='formcity' id='formcity'><option value='-1'>请选择</option></select>");
			$.each(data ,function(key ,val){
				str = "<option value='"+val.id+"'>"+val.cityname+"</option>";
				$('#formcity').append(str);
			})
		} 
	);
})

//管家查询搜索
 $.post('/admin/b1/app_line/get_expert_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		if(val.realname==null){
			val.realname='';
		}
		array.push({
		    text : val.realname,
		    value : val.id,
		    jb : val.realname,
		    qp : val.realname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#expertname",
	    name : "expertid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    blurAfter : function(item, index) {// 选择后的事件
			if(jQuery('#expertid').val()==''){
				jQuery('#expertid').val('');
				jQuery('#expertname').val('');
			}
	    },
	    data : array
	});
 
})

 
 //出发地检索功能
 //出发城市获取
$.post("/common/area/get_line_startplace",{},function(json) {
	var data = eval("("+json+")");
	createChoicePluginPY({
		data:data,
		nameId:'startcity',
		valId:'formcity',
		width:500,
		isHot:true,
		hotName:'热门城市',
		number:1,
		//blurDefault:true
		buttonId:'startcity-list'
	});
});


//目的地
var oleft = 0 ; 
var oTop = 0;
function b1_showCGZDestTree(obj,cityid){
	oleft = 0 ; 
	oTop = -40 ;
	treeInputObj = obj;
	var url = '/common/get_data/getTripDestBaseArr';
	var zNodes = commonTree(obj ,url ,cityid);
	
	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword(obj ,zNodes ,event);
	})
}
</script>

<?php  echo $this->load->view('admin/common/tree_view'); ?>	
