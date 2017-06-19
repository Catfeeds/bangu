<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<!-- 图片 -->
<style>
.add_btn{ float:left; width:auto !important;  position: relative; top:50px; left:10px;}
#imghead{ float:left;}
</style>
<div id="img_upload">
	<div id="altContent"></div>
	<div class="close_xiu">×</div>
	<!--<div class="right_box"></div> -->
</div>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>手机视频上传</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs" id= "data-id">
			<li class="active" data-val="1">视频上传 </li>
			<li class="tab-red" data-val="2">短视频上传</li>
		</ul>
		<div class="tab-content">
 			<a id="add-button" href="javascript:void(0);" class="but-default" >添加</a>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div class="form-box fb-body">
	<div class="fb-content">
		<div class="box-title">
			<h4>手机视频上传</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">视频标签：<i>*</i></div>
					<div class="fg-input">
						<select name="dict_id">
							<option value="0">请选择</option>
							<?php foreach ($dict_data as $key=>$val):?>
							<option value="<?php echo $val['dict_id'];?>"><?php echo $val['description'];?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">目的地：<i>*</i></div>
					<div class="fg-input" >
						<input type="text" name="city_name" onclick="showDestBaseTree(this)" />
						<input type="hidden" name="city" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">选择管家：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="realname" readonly="readonly" id="clickChoiceExpert" />
						<input type="hidden" name="expertId" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">关联线路：</div>
					<div class="fg-input">
						<input type="text" readonly="readonly" name="linename" id="clickChoiceLine" />
						<input type="hidden" name="lineId" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">视频名称：<i>*</i></div>
					<div class="fg-input"><input type="text" name="video_name" /></div>
					<span>限8个字以内</span>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" class="showorder" name="sort" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">视频：<i>*</i></div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadVideoFile(this);" type="file">
						<input name="video" type="hidden" />
					</div>
				</div>
                <div class="form-group">
					<div class="fg-title">封面：<i>*</i></div>
					<img src="#" style="width: 250px; height: 120px;" id="imghead">
					<input class="add_btn" type="button" onclick="uploadIf(this);" value="上传">
					<input type="hidden" name="pic" id="pic" />
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
<!-- 					<input type="hidden" name="city_name" /> -->
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
					<input type="hidden" name="src_w" id="src_w_id" />
					<input type="hidden" name="src_h" id="src_h_id" />
					<input type="hidden" name="img_url" id="img_url" />
				</div>
				<div class="clear"></div>
			</form>
		</div>		
	</div>
	<form action="#" id='search-condition' class="search-condition" method="post">
			<input type="hidden" value="1" name="status">
		</form>
		<div id="dataTable"></div>
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<!-- 尾部 -->
<?php echo $this->load->view('admin/a/choice_data/choice_experts.php');  ?>
<?php echo $this->load->view('admin/a/choice_data/choice_lines.php');  ?>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript">
var currId;
// 视频上传
var columns1 = [ {field : 'realname',title : '管家姓名',width : '150',align : 'center'},
		{field : 'description',title : '视频标签',width : '140',align : 'center'},
		{field : 'dest_name',title : '目的地',width : '140',align : 'center'},
		{field : false,title : '关联线路',width : '140',align : 'center',formatter:function(item){
				if(item.line_ids ==0) {
					return '';
					}else{
						return item.linename;
					}
			}
		},
		{field : 'name',title : '视频名称',width : '140',align : 'center'},
		{field :false,title : '视频',align : 'center', width : '100',formatter:function(item){
			return '<video src="'+item.video+'" width="710" height="309" controls></video>';
		}},
		{field :false,title : '封面',align : 'center', width : '100',formatter:function(item){
			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.pic+'" width="200" />';
		}},
		{field : 'sort',title : '顺序',width : '140',align : 'center'},
		{field : 'addtime',title : '添加时间',align : 'center', width : '180'},
	];
//短视频上传
var columns2 = [ {field : 'realname',title : '管家姓名',width : '150',align : 'center'},
		{field : 'description',title : '视频标签',width : '140',align : 'center'},
		{field : 'dest_name',title : '目的地',width : '140',align : 'center'},
		{field : false,title : '关联线路',width : '140',align : 'center',formatter:function(item){
				if(item.line_ids ==0) {
					return '';
				}else{
					return item.linename;
				}
		}
		},
		{field : 'name',title : '视频名称',width : '140',align : 'center'},
		{field :false,title : '视频',align : 'center', width : '100',formatter:function(item){
			return '<video src="'+item.video+'" width="347" height="480" controls></video>';
		}},
		{field :false,title : '封面',align : 'center', width : '100',formatter:function(item){
			return '<img src="<?php echo trim(base_url(''),'/');?>'+item.pic+'" width="200" />';
		}},
		{field : 'sort',title : '顺序',width : '140',align : 'center'},
		{field : 'addtime',title : '添加时间',align : 'center', width : '180'},
		];
$("#dataTable").pageTable({
	columns:columns1,
	url:'/admin/a/cfg_mobile/mobile_video/getVideoData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
//导航栏切换
$('.nav-tabs li').click(function(){
	var formObj = $('#search-condition');
	formObj.find("select").val(0).eq(0).nextAll("select").hide();
	$(this).addClass('active').siblings().removeClass('active');
	var status = $(this).attr('data-val');
	$('input[name="status"]').val(status);
	if (status == 1) {
		$('.search-th').hide();
		var columns = columns1;
	} else if (status == 2) {
		$('.search-th').show();
		var columns = columns2;
	}
	$("#dataTable").pageTable({
		columns:columns,
		url:'/admin/a/cfg_mobile/mobile_video/getVideoData',
		pageNumNow:1,
		searchForm:'#search-condition',
		tableClass:'table-data'
	});
})


//获取目的地
// $.ajax({
// 	url:'/common/selectData/getDestAll',
// 	dataType:'json',
// 	type:'post',
// 	data:{level:3},
// 	success:function(data){
// 		$('#search-city').selectLinkage({
// 			jsonData:data,
// 			width:'110px',
// 			names:['country','province','city']
// 		});
// 		$('#add-city').selectLinkage({
// 			jsonData:data,
// 			width:'131px',
// 			names:['country','province','city'],
// 			callback:function(){
// 				$("#add-city").change(function(){
// 					$("#add-data").find("input[name='expertId']").val(0);
// 					$("#add-data").find("input[name='realname']").val('');
// 					$("#add-data").find("input[name='lineId']").val(0);
// 					$("#add-data").find("input[name='linename']").val('');
// 					$("#cb-search-form").find("input[name='keyword']").val('');
// 					$("#cb-line-search-form").find("input[name='keyword']").val('');
// 					$("#cb-line-search-form").find("input[name='lineid']").val('');
// 				})
// 			}
// 		});
// 	}
// });
//添加弹出层
$("#add-button").click(function(){	
	var Dadd= $("#data-id").find(".active").attr("data-val");
	var formObj = $("#add-data");
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('input[type=file]').val('');
	formObj.find("select").val(0);
	$("#add-city").find("select").eq(0).nextAll('select').hide();
	$("#add-data").find("input[name='id']").val(Dadd);
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
	$(".uploadvideo").remove();
	$("#imghead").attr("src","");
	currId = Dadd;
})

function FunCity(){
	var Chtml;
	var Cval = $("#add-city").find("select").eq(2).val();
	var elect = $("#add-city").find("select").eq(2);
	for( var i = 0 ; i <elect.find("option").length; i ++){
		if(Cval == elect.find("option").eq(i).val()){
			Chtml = elect.find("option").eq(i).html();
			return Chtml;
		}
	}
}
//提交
$("#add-data").submit(function(){
	var chinaCity = FunCity();
	//$(this).find('input[name=city_name]').val(chinaCity);
	var id = $(this).find('input[name=id]').val();
	var url = '/admin/a/cfg_mobile/mobile_video/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				alert(data.msg);
				$(".fb-body,.mask-box").hide();
				var status = $('input[name="id"]').val();
				if (status == 1) {
					var columns = columns1;
				} else if (status == 2) {
					var columns = columns2;
				}
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_video/getVideoData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
/**
 * @method ajax上传视频文件(文件上传地址统一使用一个)
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 视频保存的前缀
 */
function uploadVideoFile(obj) {
	var file_id = $(obj).attr("id");
	var inputObj = $(obj).nextAll("input[type='hidden']");
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadVideoFile',
	    secureuri : false,
	    fileElementId : file_id,// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	    	fileId : file_id
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	inputObj.siblings(".uploadvideo").remove();
		    	inputObj.after("<video class='uploadvideo' src='" + data.msg.url + "' width='100' height='80'></video>");
		    	inputObj.val(data.msg.url);
		    	$("#src_w_id").val(data.msg.src_w);
		    	$("#src_h_id").val(data.msg.src_h);
		    	$("#img_url").val(data.msg.img_url);
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败(请尝试重新上传)');
	    }
	});
}

//筛选管家
$("#clickChoiceExpert").click(function(){
	var cityObj = $("#add-city");
	var cityId = cityObj.find("select[name='city']").val();
	var provinceId = cityObj.find("select[name='province']").val();
	$("#cb-search-form").find('input[name=city_id]').val(cityId);
	$("#cb-search-form").find('input[name=province]').val(provinceId);
	createExpertHtml();
})
//确认选择管家
$(".db-submit").click(function(){
	var obj = $("#db-data").find(".db-active");
	$("#add-data").find("input[name='expertId']").val(obj.attr('data-val'));
	$("#add-data").find("input[name='realname']").val(obj.attr('data-name'));
	$("#cb-search-form").find('input[name=keyword]').val('');
	$(".choice-box-1").hide();
})

//选择线路
$('#clickChoiceLine').click(function(){
	var destName = $('select[name=province]').find('option:selected').html();
	var destId = $('select[name=province]').val();
	var cityId = $("#add-data").find('select[name=city]').val();
	var cityName = $("#add-data").find('select[name=city]').find('option:selected').html();
	if (cityId < 1) {
		alert('请选择目的地');
		return false;
	}
	$('.cb-prompt').html(destName+cityName);
	$('#cb-line-search-form').find('input[name=city_id]').val(cityId);
	$('#cb-line-search-form').find('input[name=dest_id]').val(destId);
	createLineHtml();
})
$('.line-submit').click(function(){
	var activeObj = $('.db-data-line').find('.db-active');
	$('#clickChoiceLine').val(activeObj.attr('data-name'));
	$("#add-data").find('input[name=lineId]').val(activeObj.attr('data-val'));
	$("#cb-line-search-form").find("input[name='keyword']").val('');
	$("#cb-line-search-form").find("input[name='lineid']").val('');
	$(".choice-box-line").hide();
})
/*-----------------------------------上传图片-----------------------------*/
	var imgProportion = {1:"710x309",2:"347:480",3:"5:5",4:"332:222"};
	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4"};
	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4"};
	function uploadImgFile(obj ,type){			
			var buttonObj = $(obj);
			xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
			xiuxiu.embedSWF(xiuBox[type],5,'100%','100%',xiuxiuEditor[type]);
		       //修改为您自己的图片上传接口
			xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadvideoFileXiu'); ?>");
		    xiuxiu.setUploadType(2);		    
		    xiuxiu.setUploadDataFieldName("uploadFile");		   
			xiuxiu.onInit = function ()
			{				
				//默认图片
				xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg", false, xiuxiuEditor[type]);
			}			
			xiuxiu.onUploadResponse = function (data)
			{
				
				data = eval('('+data+')');
				if (data.code == 2000) {
					buttonObj.next("input").val(data.msg);

					if (type == 3) {
						//alert("上传成功");
						//buttonObj.after(data.msg);
						buttonObj.prev("input").val(data.msg);
						buttonObj.next("span").html(data.msg);
					} else if (type == 2) {
						//buttonObj.css({'margin-top': '0px','margin-left': '110px'});
						buttonObj.prev("img").attr("src",data.msg);
						buttonObj.next('input').val(data.msg);
					} else if (type == 1){
						//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="photo"]').val(data.msg);
					}else if(type == 4){
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="big_photo"]').val(data.msg);
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
	    var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4'); // 设置目标区域
	    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
	        $("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4").hide();
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


	/*-------------------------------*/
	
	function uploadIf( obj ){
		uploadImgFile( obj ,currId);
		}
	
	function callbackTree(id ,name ,data) {
		if (data.level <= 1) {
			$('#add-data').find('input[name=city_name]').val('');
			$('#add-data').find('input[name=city]').val('');
			layer.alert('目的地要选到第三级', {icon: 2});
		}
	}
</script>