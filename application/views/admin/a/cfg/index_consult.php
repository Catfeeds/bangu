<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">资讯配置 </li>
		</ul>
	</div>
	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">资讯配置列表 </a></li>	
	</ul>
	
	<div class="tab-content tabs-flat">
	<!-- <div>
			<a class="btn btn-info btn-xs">添加</a>
		</div> -->
		<!-- 资讯列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
							<div style="float:left;margin-left:20px;padding:5px 10px 5px 10px">
							 <a class="btn btn-info btn-xs" id="add_consult" style="padding:5px 10px 5px 10px">添加</a>
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">类型：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <select name="consultType">
						      	 	<option value=''>请选择</option>
						       		<option value='1'>资讯</option>
						       		<option value='2'>旅游攻略</option>
						       </select>
							</div>
							<label class="control-label"  style="width: 85px;padding-right:0px;margin-top:4px;">标题：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="title">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch0">
							</div>
						</div>
					</form>
					<div id="list"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<div class="right_box" style="display:none;"></div>

<!-- 添加资讯 -->
<div class="eject_body details_expert" style="width:40%;left:30%;margin-bottom:80px;">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title ex_realname">添加资讯配置 </div>
	<div class="eject_content" style="position:relative;">
	<form class="form-horizontal" role="form" id="add_consult_form" method="post" action="#" >
	<div class="eject_subtitle"><span>资讯配置 </span></div>
	<!--  资讯配置   -->
		<div class="cfg_content">
			<div class="eject_content_list">
				<div class="eject_list_row" style="width:70%">
					<div class="eject_list_name " style="width:14%;padding-top:6px;"><span style="color: red;">*</span>资讯标题:</div>
					<div class="content_info ex_address">
		                 <input type="text" name="consult" style="width:200px;"autocomplete="off" />
		                 <input type="hidden" name="consult_id" style="width:200px;"/>
		                 <span class="select_consult" style="background:#2dc3e8;color:#fff;font-size:14px;border-radius:3px;padding:6px;">选择资讯</span>
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
			<div class="eject_content_list">
				<div class="eject_list_row">
					<div class="eject_list_name " style="width:20%;padding-top:6px;"><span style="color: red;">*</span>图片:</div>
					<div class="content_info ex_address">
						<span onclick="uploadImgFile(this,2)" style="background:#00b7ee;color:#fff;padding:5px 8px;border-radius:4px;cursor:pointer;float:left;margin-right:12px;">上传</span>
						<span class="cfg_span"><img src=""  style="max-width:150px;"></span>
						<input type="hidden" name="cfg_pic">
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
			<div class="eject_content_list">
				<div class="eject_list_row">
					<div class="eject_list_name " style="width:20%;padding-top:6px;"><span style="color: red;">*</span>位置:</div>
					<div class="content_info ex_address" id="location_div">
						<input type="radio" name="location" value="1" checked="checked" style="width:15px;height:15px;position:initial;opacity:1;">轮播
						<input type="radio" name="location" value="2" style="width:15px;height:15px;position:initial;opacity:1;">固定中间
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
			<div class="eject_content_list">
				<div class="eject_list_row">
					<div class="eject_list_name " style="width:20%;padding-top:6px;"><span style="color: red;">*</span>可更改:</div>
					<div class="content_info ex_address" id="modify_div">
						<input type="radio" name="is_modify" checked="checked" value="1" style="width:15px;height:15px;position:initial;opacity:1;">是
						<input type="radio" name="is_modify" value="0" style="width:15px;height:15px;position:initial;opacity:1;">否
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
			<div class="eject_content_list">
				<div class="eject_list_row">
					<div class="eject_list_name " style="width:20%;padding-top:6px;"><span style="color: red;">*</span>显示:</div>
					<div class="content_info ex_address" id="show_div">
						<input type="radio" name="is_show" checked="checked" value="1" style="width:15px;height:15px;position:initial;opacity:1;">是
						<input type="radio" name="is_show" value="0" style="width:15px;height:15px;position:initial;opacity:1;">否
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
			<div class="eject_content_list">
				<div class="eject_list_row">
					<div class="eject_list_name " style="width:15%;padding-top:6px;">排序:</div>
					<div class="content_info ex_address">
						<input type="text" id="showorder" name="showorder"  style="float:left;width:120px;" value="999"/>
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
			<div class="eject_content_list">
				<div class="eject_list_row">
					<div class="eject_list_name " style="width:12%;padding-top:6px;">备注:</div>
					<div class="content_info ex_address">
						<textarea rows="" cols="" name="beizhu" style="width:250px;height:80px;"></textarea>
					</div>
				</div>	
				<div style="clear:both;"></div>
			</div>
		</div>

		<div class="eject_botton">
			<input type="hidden" value="0" name="typeid" />
			<div class="ex_colse">关闭</div>
			<div class="ex_through" onclick="Checkconsult()">保存</div>
		</div>	
		</form>
	</div>						
</div>
<!-- 选择资讯弹出层 开始-->
<div class="eject_body sel_consult" >
	<div class="eject_colse colse_travel">X</div>
	<div class="eject_title">选择资讯</div>
	<div class="search_travel_input">
		<select name="consult_type" id="consult_type">
			<option value="">请选择</option>
			<option value="1">资讯</option>
			<option value="2">旅游攻略</option>
		</select>
		<input class="search_travel_condition" type="text" placeholder="请输入资讯标题" name="consult_name">
		<div class="search_button" style="margin-left:370px">搜索</div>
	</div>
	<div class="eject_content sel_content" style="clear: both;">
		<div class="choice_tralve_agent">海外国旅旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社深圳市口岸中国旅行社</div>
	</div>	
	<div class="pagination page_travel"></div>
	<div style="clear:both;"></div>
	<div class="eject_botton">
		<div class="eject_through">选择</div>
		<div class="eject_fefuse colse_travel">取消</div>
	</div>					
</div>							
<!-- 选择资讯弹出层结束 -->

<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<!-- 编辑器 -->
<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.all.min.js"></script>
<!-- 美图秀秀 -->
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<!-- 目的地 -->
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>


<script type="text/javascript">
jQuery(document).ready(function(){
	// 第一个列表 未使用===============================================================
	jQuery("#btnSearch0").click(function(){	
		page0.load();
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/cfg/index_consult/cfg_consult",form : '#listForm0',// 绑定一个查询表单的ID
				columns : [
							{title : '编号',width : '5%',align : 'center',
								formatter : function(value,rowData, rowIndex) {
									return rowIndex+1;
								}
							},
							{field : 'type',title : '类型',align : 'center', width : '10%',
								 formatter : function(value,rowData, rowIndex) {
									if(rowData.type==1){
										return '资讯';
								   }else if(rowData.type==2){
										return '旅游攻略';
								   }
								 }
							},
							{field : 'title',title : '位置',align : 'center', width : '10%',
								 formatter : function(value,rowData, rowIndex) {
										if(rowData.location==1){
											return '轮播';
									   }else if(rowData.location==2){
											return '固定中间';
									   }
								 }
							},	
							{field : 'title',title : '标题',align : 'center', width : '18%'},
							{field : '',title : '封面图',align : 'center', width : '10%',
								 formatter : function(value,rowData, rowIndex) {
										return '<img style="width:30px;height:30px;" src="'+rowData.cfpic+'">';
									} 
							},
							{field : 'is_modify',title : '可更改',align : 'center', width : '10%',
								 formatter : function(value,rowData, rowIndex) {
										 if(rowData.is_modify==1){
											 return '是';
										 }else{
											 return '否';
										  }	
									} 
							},
							{field : 'is_show',title : '显示',align : 'center', width : '10%',
								 formatter : function(value,rowData, rowIndex) {
									 if(rowData.is_show==1){
										 return '是';
									 }else{
										 return '否';
									 }	
								} 
							},
							{field : 'showorder',title : '排序',align : 'center', width : '10%'},
							{field : '',title : '操作',align : 'center', width : '15%',
								 formatter : function(value,rowData, rowIndex) {
									 if(rowData.is_modify==1){
										 return '<a href="##" onclick="editor_consult('+rowData.id+')" >编辑</a>';
									 }else{
										 return '';
									 }
								} 
							}
				]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page0.load();
	});

});


//=========================================================================================================================
/*-----------------------------------上传图片-----------------------------*/
var imgProportion = {1:"800x480",2:"800x480",3:"360x360"};
var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3"};
var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3"};
function uploadImgFile(obj ,type){
		var buttonObj = $(obj);
		xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
		xiuxiu.embedSWF(xiuBox[type],5,'100%','100%',xiuxiuEditor[type]);
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
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
				buttonObj.next("input").val(data.msg);
				if (type == 3) {
					alert("上传成功");
					buttonObj.after(data.msg);
					buttonObj.prev("input").val(data.msg);
				} else if (type == 2) {
					//buttonObj.css({'margin-top': '0px','margin-left': '110px'});
					$('.cfg_span').find("img").attr("src",data.msg);
					$('input[name="cfg_pic"]').val(data.msg);
						
				} else if (type == 1){
					$('.cover_span').find("img").attr("src",data.msg);
					$('input[name="cover_pic"]').val(data.msg);
				}
				closeXiu(type);
			} else {
				alert(data.msg);
			}
		}
		$("#xiuxiuEditor"+type).show();
		$('.avatar_box').show();
		$('.close_xiu').show();
		$('.right_box').show();
		return false;
}
$(document).mouseup(function(e) {
    var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3'); // 设置目标区域
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3").hide();
        $('.avatar_box').hide();
        $('.close_xiu').hide();
        $('.right_box').hide();
    }
})
function closeXiu(type) {
	$("#xiuxiuEditor"+type).hide();
	$('.avatar_box').hide();
	$('.close_xiu').hide();
	$('.right_box').hide();
}

/*------------美图秀秀end-------------------*/
 	
	//添加添加资讯的弹框
	$('#add_consult').click(function(){
		$('input[name="consult"]').val('');
		$('input[name="consult_id"]').val('');
		$('input[name="showorder"]').val('999');
		$('textarea[name="beizhu"]').val('');
		$('input[name="typeid"]').val('');
		$('input[name="cfg_pic"]').val('');
		$('.cfg_span').find("img").attr("src",'');
		var ue = UE.getEditor('consult_content');
		//对编辑器的操作最好在编辑器ready之后再做
 		ue.ready(function() {
					//设置编辑器的内容
		ue.setContent('');
		}); 
		$('.modal-backdrop').show();
		$('.details_expert').show(); 
	});

	//关闭添加资讯
	$('.ex_colse').click(function() {
		$('.modal-backdrop').hide();
		$('.details_expert').hide();
		$('.stop_expert').hide();
		$('.expert_info_line').hide();
	})
//------------------- 出发城市-------------------------
	$.post('/admin/a/statrplace/get_startcity_data', {}, function(data) {
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
		$('input[name="formcity"]').val('');
	})
//------------------- 出发城市end-------------------------
/*****************选择资讯社相关*************************/
	$('.colse_travel').click(function() {
		$('.sel_consult').hide();
	})
	//选择旅行社弹出层
	$('.select_consult').click(function() {
		$.post(
			"/admin/a/cfg/index_consult/get_consult",
			{'is':1,'pagesize':18},
			function(data) {
				data = eval('('+data+')');
				$('.sel_content').html('');
				$.each(data.list ,function(key ,val) {
					var str = '<div class="choice_tralve_agent" agent_id="'+val.id+'">'+val.title+'</div>';
					$('.sel_content').append(str);
				})
				$('.sel_content').append('<div style="clear:both;"></div>');
				$('.page_travel').html(data.page_string);

				$('input[name="search_travel_name"]').val('');
				$('.sel_content').css('min-height','200px');
				$('.sel_consult').css({'z-index':'10000','top':'10px','min-height':'400px'}).show();

				//点击旅行社时执行
				$('.choice_tralve_agent').click(function() {
					$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
					$(this).css('border','2px solid green').addClass('active');
				})

				//点击分页
				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_travel_data(page_new);
				})
			}
		);
	})
	//资讯分页
	function get_travel_data(page_new) {
		var name = $('input[name="consult_name"]').val();
		var type=$('#consult_type').val();
		$.post(
			"/admin/a/cfg/index_consult/get_consult",
			{'is':1,'pagesize':18,'page_new':page_new,'name':name,'type':type},
			function(data) {
				data = eval('('+data+')');
				$('.sel_content').html('');
				$.each(data.list ,function(key ,val) {
					var str = '<div class="choice_tralve_agent" agent_id="'+val.id+'">'+val.title+'</div>';
					$('.sel_content').append(str);
				})
				$('.sel_content').append('<div style="clear:both;"></div>');
				$('.page_travel').html(data.page_string);

				//点击资讯时执行
				$('.choice_tralve_agent').click(function() {
					$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
					$(this).css('border','2px solid green').addClass('active');
					
				})
				//点击分页
				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_travel_data(page_new);
				})
			}
		);
	}
	//点击搜索资讯
	$('.search_button').click(function(){
		get_travel_data(1);
	})
	//选择资讯
	$('.eject_through').click(function(){
		var active = $('.sel_content').find('.active');
		var agent_name = active.html();
		var agent_id = active.attr('agent_id');
		//alert(agent_id);
		$('input[name="consult"]').val(agent_name);
		$('input[name="consult_id"]').val(agent_id);
		$('.sel_consult').hide();
	})
/*****************选择资讯结束***********************/
	//添加活动
	function Checkconsult(){
		//选择资讯
 		var consult_id=$('input[name="consult_id"]').val();
		if(consult_id==''){
			alert('请选择资讯!');
			return false;
		} 
		var consult_id=$('input[name="consult_id"]').val();
		if(consult_id==''){
			alert('请选择资讯!');
			return false;
		} 
		var cfg_pic=$('input[name="cfg_pic"]').val();
		if(cfg_pic==''){
			alert('请上传图片');
			return false;
		}

		 jQuery.ajax({ type : "POST",data : jQuery('#add_consult_form').serialize(),url : "<?php echo base_url()?>admin/a/cfg/index_consult/add_cfg_consult", 
				success : function(response) {
		 		 var response=eval("("+response+")");
						 if(response.status==1){  
                              alert(response.msg);
                              $('.ex_colse').click(); 
                              $('#tab0').click();
						 }else{
							 alert(response.msg);
						 }	       
					}
			});
			
		return false;
	}
	//编辑资讯
	function editor_consult(obj){
		var id=obj;
		var checked0='';
		var checked1='';
		var checked2='';
		var checked3='';
		var checked4='';
		var checked5='';
		jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/a/cfg/index_consult/get_consult_rowdata",
			success : function(res) {
				 var res=eval("("+res+")");
				 if(res.status==1){
					
					 //-------------位置----------------
					 if(res.data.location==1){
						     checked0='checked="checked"';
						}else if(res.data.location==2){
							 checked1='checked="checked"';
						}
					 var locationstr='<input type="radio" name="location" value="1" '+checked0+' style="width:15px;height:15px;position:initial;opacity:1;">轮播';
					 locationstr=locationstr+'<input type="radio" name="location" '+checked1+' value="2" style="width:15px;height:15px;position:initial;opacity:1;">固定中间';
					 $('#location_div').html(locationstr);
					 //--------------可更改-----------------
					 if(res.data.is_modify==1){
						     checked2='checked="checked"';
						}else if(res.data.is_modify==0){
							 checked3='checked="checked"';
						}
					 var modifystr=' <input type="radio" name="is_modify" value="1" '+checked2+' style="width:15px;height:15px;position:initial;opacity:1;">是';
					 modifystr=modifystr+'<input type="radio" name="is_modify"  value="0" '+checked3+' style="width:15px;height:15px;position:initial;opacity:1;">否';
					 $('#modify_div').html(modifystr);
					//---------------显示------------------
					 if(res.data.is_show==1){
						    checked4='checked="checked"';
						}else if(res.data.is_show==0){
							checked5='checked="checked"';
						}
					var showstr=' <input type="radio" name="is_show" '+checked4+' value="1" style="width:15px;height:15px;position:initial;opacity:1;">是';
					showstr=showstr+'<input type="radio" name="is_show" '+checked5+'  value="0" style="width:15px;height:15px;position:initial;opacity:1;">否';
					$('#show_div').html(showstr);
					 
					 $('input[name="consult"]').val(res.data.title);
					 $('input[name="consult_id"]').val(res.data.consult_id);
					  $('.cfg_span').find("img").attr("src",res.data.pic);
					 $('input[name="cfg_pic"]').val(res.data.pic);
					 $('input[name="typeid"]').val(res.data.id)  
					 $('textarea[name="beizhu"]').val(res.data.beizhu);
					 $('input[name="showorder"]').val(res.data.showorder);
					 
					}else{
						alert(res.msg);
				}
			}
		});
		var ue = UE.getEditor('consult_content');
	 
		$('.modal-backdrop').show();
		$('.details_expert').show();	
	}

</script>


