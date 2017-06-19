<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/citylist/city.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/file/common/plugins/ueditor/themes/default/css/ueditor.css"/>
<link rel="stylesheet" href="/file/common/plugins/kindeditor/themes/default/default.css" />
<link rel="stylesheet" href="/file/common/plugins/kindeditor/plugins/code/prettify.css" />
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">资讯管理 </li>
		</ul>
	</div>
	<ul class="nav nav-tabs tabs-flat">
		<li class="active" id="tab0" name="tabs"><a href="#home0">资讯列表 </a></li>
		<li class="" id="tab1" name="tabs"><a href="#home1">旅游攻略 </a></li>		
	</ul>

	<div class="tab-content tabs-flat">
		<div>
			<a class="btn btn-info btn-xs" id="add_consult" style="padding:5px 10px 5px 10px;margin-bottom:10px;">添加</a>
		</div>
		<!-- 资讯列表 -->
		<div class="tab-pane active" id="home0">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm0">
						<div class="form-group has-feedback">
						<!--  	<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">类型：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <select name="consultType">
						      	 	<option value=''>请选择</option>
						       		<option value='1'>资讯</option>
						       		<option value='2'>旅游攻略</option>
						       </select>
							</div>-->
							<label class="control-label"  style="width: 85px;padding-right:0px;">标题：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="title">
						         <input type="hidden" name="status" value="1">
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
		<!-- 旅游攻略 -->
		<div class="tab-pane" id="home1">
			<div class="widget-body">
				<div id="registration-form">
					<form class="form-horizontal bv-form" method="post" id="listForm1">
						<div class="form-group has-feedback">
						<!-- <div style="float:left;margin-left:20px;padding:5px 10px 5px 10px">
							 <a class="btn btn-info btn-xs" id="add_consult" style="padding:5px 10px 5px 10px">添加</a>
							</div> -->	
							<!--<label class="col-lg-4 control-label"  style="width: 85px;padding-right:0px;">类型：</label>
							<div class="col-lg-4" style="width:auto;padding-left:2px;">
						       <select name="consultType">
						      	 	<option value=''>请选择</option>
						       		<option value='1'>资讯</option>
						       		<option value='2'>旅游攻略</option>
						       </select>
							</div>  -->
							<label class="control-label"  style="width: 85px;padding-right:0px;">标题：</label>
							<div style="display:inline-block;padding-left:2px;">
						       <input class="search_input user_name_b1" type="text" name="title">
							</div>	
							<label class="control-label" style="width: 2%;">&nbsp;</label>
							<div style="display:inline-block;padding-left:2px;">
								<input type="button" value="搜索" class="btn btn-palegreen" id="btnSearch1">
							</div>
						</div>
					</form>
					<div id="list1"></div>
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
<div class="eject_body details_expert" style="width:48%;left:20%;margin-bottom:80px;">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title ex_realname">添加资讯</div>
	<div class="eject_content" style="position:relative;">
	<form class="form-horizontal" role="form" id="add_consult_form" method="post" action="#" >
	<div class="eject_subtitle"><span>基本内容</span></div>
	   <div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name" style="width:14%;"><span style="color: red;">*</span>类型:</div>
				<div class="content_info ex_address" id="type_data">
				<select name="type">
					<option value=''>请选择</option>
					<option value="1">资讯</option>
					<option value="2">旅游攻略</option>
				</select> 
				</div>
			</div>	
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name" style="width:14%;"><span style="color: red;">*</span>标签:</div>
				<div class="content_info ex_address" id="type_data">
				<select name="tag" id="content_tag">
					<option value=''>请选择</option>
				    <?php if($tag){
                     foreach ($tag as $k=>$v){
				    ?>
					<option value='<?php echo  $v['id']; ?>'><?php echo $v['attrname']; ?></option>
					<?php } }?>
				</select> 
				</div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name " style="width:14%;padding-top:6px;"><span style="color: red;">*</span>标题:</div>
				<div class="content_info ex_address" style="width:85%"><input type="text" name="c_title" /></div>
			</div>	
			<div style="clear:both;"></div>
		</div>
		
		<div class="eject_content_list">
			<div class="eject_list_row" style="width:85%">
				<div class="eject_list_name " style="width:8%;padding-top:6px;"><span style="color: red;">*</span>目的地:</div>
				<div class="content_info ex_address">
					<input type="text" id="overcityArr" style="width: 21%;float:left;margin-right:12px;"/>
					<input type="hidden" id="overcitystr" name="overcitystr" value=""/> 
					<div id="ds-list" style="margin-top:6px;width:650px;"></div>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name " style="width:14%;padding-top:6px;"><span style="color: red;"></span>主题:</div>
				<div class="content_info ex_address">
				 	<span id="theme-list" class="btn btn-palegreen" >
							<span id="theme_arr" data="" name="ds-lable" data-val="">选择主题游</span>
					</span>							
					<input id="theme" type="hidden" name="theme" value="">
				</div>
			</div>	
			<div style="clear:both;"></div>
		</div>
	   <div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name "  style="width:14%;"><span style="color: red;">*</span>封面图:</div>
				<div class="content_info ex_address">
					<span onclick="uploadImgFile(this,1)" style="background:#00b7ee;color:#fff;padding:5px 8px;border-radius:4px;cursor:pointer;float:left;margin-right:12px;">上传</span>
					<span class="cover_span"><img src=""  style="max-width:150px;"></span>
					<input type="hidden" name="cover_pic" id="cover_pic">
				</div>
			</div>	
			<div style="clear:both;"></div>
		</div>

		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name " style="width:14%;padding-top:6px;"><span style="color: red;">*</span>热门:</div>
				<div class="content_info ex_address" id="ishot_div">
				<input type="radio" name="ishot" value="1" style="width:15px;height:15px;position:initial;opacity:1;">是
				<input type="radio" name="ishot" value="0" checked="checked" style="width:15px;height:15px;position:initial;opacity:1;">否
				</div>
			</div>	
			<div style="clear:both;"></div>
		</div>
		<!--  <div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name " style="width:14%;padding-top:6px;"><span style="color: red;"></span>来源:</div>
				<div class="content_info ex_address" style="width:85%"><input type="text" name="channel" value="帮游旅游网 " /></div>
			</div>	
			<div style="clear:both;"></div>
		</div>-->
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name "><span style="color: red;">*</span>文本内容:</div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row" style="width:100%;">
				<textarea class="eject_list_name" id="consult_content" name="content" style="width:98%;height:400px;">
				
				</textarea>
			</div>
		</div>
		<div class="eject_botton" style="border-top:none">
			<input type="hidden" value="0" name="typeid" />
			<div class="ex_colse">关闭</div>
			<div class="ex_through" onclick="Checkconsult()">保存</div>
		</div>	
		</form>
	</div>						
</div>
<script src="<?php echo base_url('assets/js/jQuery-plugin/paging/jquery-paging.js');?>"></script>
<link href="<?php echo base_url('assets/js/jQuery-plugin/paging/css/jquery.paging.css?v=2');?>" rel="stylesheet" />
<!-- 编辑器 -->
<script charset="utf-8" src="/file/common/plugins/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/lang/zh_CN.js"></script>
<script charset="utf-8" src="/file/common/plugins/kindeditor/plugins/code/prettify.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<!-- 美图秀秀 -->
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<!-- 目的地 -->
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<!-- 出发地 -->
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>

 <?php echo $this->load->view('admin/b1/common/citylist_script'); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	// 第一个列表 未使用===============================================================
	var page0=null;
	jQuery("#btnSearch0").click(function(){	
		page0.load({"status":"1"});
	});
	var data = '<?php echo $pageData; ?>';
	page0=new jQuery.paging({renderTo:'#list',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/consult/consultData",form : '#listForm0',// 绑定一个查询表单的ID
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
							{field : 'title',title : '标题',align : 'center', width : '15%'},
							{field : '',title : '封面图',align : 'center', width : '10%',
								 formatter : function(value,rowData, rowIndex) {
										return '<img style="width:30px;height:30px;" src="'+rowData.pic+'">';
									} 
							},
							{field : 'shownum',title : '人气',align : 'center', width : '10%'},
							{field : 'hitpraise',title : '点赞数',align : 'center', width : '10%'},
							{field : 'addtime',title : '添加时间',align : 'center', width : '10%'},
							{field : 'ishot',title :'热门',width : '10%',align : 'center',
								 formatter : function(value,rowData, rowIndex) {
										if(rowData.ishot==1){
												return '是';
										   }else{
												return '否';
										   }
									} 
							},
							{field : '',title : '操作',align : 'center', width : '15%',
								 formatter : function(value,rowData, rowIndex) {
										return '<a href="##" onclick="editor_consult('+rowData.id+')" >编辑</a>';
									} 
							}
				]
	});
	
	jQuery('#tab0').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home0').addClass('active');
		jQuery('#tab0').addClass('active');
		page0.load({"status":"1"});
	});
	// 第二个列表 已使用===============================================================
	var page1 = null;
	function initTab1(){
	    jQuery("#btnSearch1").click(function(){
				page1.load({"status":"2"});
	   });
	    var data = '<?php echo $pageData; ?>';
		page1 = new jQuery.paging({renderTo:'#list1',record:jQuery.parseJSON(data),url : "<?php echo base_url()?>admin/a/consult/consultData",form : '#listForm1',// 绑定一个查询表单的ID
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
						{field : 'title',title : '标题',align : 'center', width : '15%'},
						{field : '',title : '封面图',align : 'center', width : '10%',
							 formatter : function(value,rowData, rowIndex) {
									return '<img style="width:30px;height:30px;" src="'+rowData.pic+'">';
								} 
						},
						{field : 'shownum',title : '人气',align : 'center', width : '10%'},
						{field : 'hitpraise',title : '点赞数',align : 'center', width : '10%'},
						{field : 'addtime',title : '添加时间',align : 'center', width : '10%'},
						{field : 'ishot',title :'热门',width : '10%',align : 'center',
							 formatter : function(value,rowData, rowIndex) {
									if(rowData.ishot==1){
											return '是';
									   }else{
											return '否';
									   }
								} 
						},
						{field : '',title : '操作',align : 'center', width : '15%',
							 formatter : function(value,rowData, rowIndex) {
									return '<a href="##" onclick="editor_consult('+rowData.id+')" >编辑</a>';
								} 
						}
			]
		});
	}
 	jQuery('#tab1').click(function(){
		jQuery('.tab-pane').removeClass('active');
		jQuery('li[name="tabs"]').removeClass('active');
		jQuery('#home1').addClass('active');
		jQuery('#tab1').addClass('active');
		if(null==page1){
			initTab1();
		}
		page1.load({"status":"2"});	
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
	//目的地(所有)

 $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"overcityArr",
			valId:"overcitystr",
			width:640,
			number:8,
			buttonId:'ds-list'
	});
});
 	//编辑器
	KindEditor.ready(function(K) {
        window.editor = K.create('#consult_content');
    });	
	//添加添加资讯的弹框
	$('#add_consult').click(function(){
		$('#theme-list').find('a').remove();
		$('input[id="theme"]').val('');//主题
	    $('#theme_arr').html('选择主题游');
	    $('#theme_arr').css('color','#999');
		$('input[name="typeid"]').val('');
		$('input[name="c_title"]').val('');// 标题
		$('#ds-list').html(''); //目的地
		$('input[name="channel"]').html('帮游旅游网 '); //来源
		$('input[name="overcitystr"]').val('');
		$('input[name="cover_pic"]').val(''); //封面图
		$('.cover_span').find("img").attr("src",'');
		$('#consult_content').html('');     //清除编辑内容               
	    editor.sync();
	    editor.html('');
 
		$('.eject_body').css('z-index','100')

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
	//添加活动
	function Checkconsult(){
	    //类型
	    var selectText = $("select[name='type']").find("option:selected").val();
		//标题
		var title=$('input[name="c_title"]').val();
		if(title==''){
			alert('标题不能为空!');
			return false;
		}
		//目的地
		var overcitystr=$('#overcitystr').val();
		if(overcitystr==''){
			alert('请选择目的地');
			return false;
		}
		//封面图
		var cover_pic=$('#cover_pic').val();
		if(cover_pic==''){
			alert('请上传封面图');
			return false;
		}
		//文本内容
	    editor.sync();
	    html = document.getElementById('consult_content').value; // 原生API
	    html = $('#consult_content').val(); // jQuery
	    if(html==''){
	    	alert('请填写文本内容');
			return false;
		}
		 jQuery.ajax({ type : "POST",data : jQuery('#add_consult_form').serialize(),url : "<?php echo base_url()?>admin/a/consult/add_consult", 
				success : function(response) {
		 		 var response=eval("("+response+")");
						 if(response.status==1){  
                              alert(response.msg);
                              $('.ex_colse').click(); 
                              if(selectText==1){
                            	  $('#tab0').click();
                              }else if(selectText==2){
                            	  $('#tab1').click();
                              }else{
                            	  $('#tab0').click();
                              }
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
		jQuery.ajax({ type : "POST",data :"id="+id,url : "<?php echo base_url()?>admin/a/consult/get_consult",
			success : function(res) {
				$('#theme-list').find('a').remove();
				 var res=eval("("+res+")");
				 if(res.status==1){
					 //-----------是否热门-----------
					 var htr0='';
					 var htr1='';
					 if(res.data.ishot==1){
						var htr0='checked="checked"';	 
					 }else{
						var htr1='checked="checked"';	
					 }
					 var str='<input type="radio" name="ishot" value="1" '+htr0+' style="width:15px;height:15px;position:initial;opacity:1;">是';
					 str=str+'<input type="radio" name="ishot" value="0" '+htr1+' style="width:15px;height:15px;position:initial;opacity:1;">否';
					 $('#ishot_div').html(str); 
					 //-------------类型-----------------
					 typestr0='';
					 typestr1='';
					 if(res.data.type==1){
						  var typestr0='selected';
					   }else if(res.data.type==2){
						   var typestr1='selected';
					   }
					  var 	typedata='<option value="">请选择</option><option '+typestr0+' value="1">资讯</option><option '+typestr1+' value="2">旅游攻略</option>';
					  $('#type_data').find('select[name="type"]').html(typedata);
					 //-----------------目的地--------------------
					 var  desthtml='';
					 var dest=res.dest;
				 	 $.each(dest, function(name, value) {
					 	 var overstr="delPlugin(this ,'overcitystr' ,'ds-list');";
					 	 var deststr='<span onclick="'+overstr+'" class="delPlugin">x</span>';
						 desthtml=desthtml+'<span value="'+value.id+'" class="selectedContent" >'+value.name+deststr+'</span>'; 
						
					 });
					 $('#ds-list').html(desthtml);
					 //------------------主题活动------------------
					 if(res.data.themeid>0){
					     $('input[id="theme"]').val(res.data.themeid);
						 $('#theme_arr').html(res.data.themename);
						 $('#theme-list').append('<a name="delDestLable" data="'+res.data.themeid+'" href="###">×</a>');
						 $('#theme_arr').css('color','#fff'); 
					 }else{
						 $('#theme-list').find('a').remove();
						 $('input[id="theme"]').val('');//主题
						 $('#theme_arr').html('选择主题游');
						 $('#theme_arr').css('color','#999');
					 }
					 if(res.data.channel!=''){
						 $('input[name="channel"]').html(res.data.channel); //来源
					 }else{
						 $('input[name="channel"]').html('帮游旅游网 '); //来源
					 }
					//选择标签
					
					var article_attr_id=res.data.article_attr_id;
					$("#content_tag option").each(function (){ 
						if(article_attr_id==$(this).val()){
							$(this).attr("selected", true); 
						}else{
							$(this).attr("selected", false); 
						}
				    }); 
						
					//-----------------end----------------------
					 $('input[name="c_title"]').val(res.data.title);
					 $('input[name="overcitystr"]').val(res.data.dest_id);
					 $('.cover_span').find("img").attr("src",res.data.pic);
					 $('input[name="cover_pic"]').val(res.data.pic);
					 $('input[name="typeid"]').val(res.data.id)
					 
                     $('#consult_content').html(res.data.content);                   
					 editor.sync();
					 // 设置HTML内容
					 editor.html(res.data.content);
						
					}else{
						alert(res.msg);
				}
			}
		});
		//var ue = UE.getEditor('consult_content');
		$('.eject_body').css('z-index','100')
		$('.modal-backdrop').show();
		$('.details_expert').show();	
	}
 	/*------------------------------------------------主题游-------------------------------------------------------*/
 	var labelFromtheme = new Array();
 	labelFromtheme ['主题游'] = new Array(<?php if(!empty($themeData)){ echo $themeData;} ?>);
 	$(function(){
 	 	//formcity
 	    //#cityName 为文本框，    citysFlight城市初始化全部数据  labelFromcity 初始化TAB  //hotList热门城市
 		$('#theme_arr').querycity({'data':themeFlight,'tabs':labelFromtheme,'hotList':'',onchange:function(id,val){
	 		  //添加主题游
			  $('#theme-list').find('a[name="delDestLable"]').remove();  
			  $('input[name="theme"]').val(id);	
		   	  $('#theme_arr').html(val); 
		   	  $('#theme-list').append('<a name="delDestLable" data="'+id+'" href="###">×</a>'); 
		   	  $('#theme_arr').css('color','#fff');   
		    	 
 		}});
 		  $('#pop_city_theme_arr').css({'top':'412px','left':'487.875px'});
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
 	  
</script>

