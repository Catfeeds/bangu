<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>手机端专家榜单配置配置</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">专家姓名：</span>
						<span ><input class="search-input" type="text" name="realname" /></span>
					</li>
					<li class="search-list">
						<span class="search-title">所在地：</span>
						<span id="search-city"></span>
					</li>
					<li class="search-list">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>
<div class="form-box fb-body">
	<div class="fb-content">
		<div class="box-title">
			<h4>首页管家配置</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">所在地：<i>*</i></div>
					<div class="fg-input" id="add-city"></div>
				</div>
				<div class="form-group">
					<div class="fg-title">选择管家：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="realname" readonly="readonly" id="clickChoiceExpert" />
						<input type="hidden" name="expertId" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" class="showorder" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">头像：</div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
						<span>不上传则默认管家头像</span>
					</div>
				</div>
                                <div class="form-group">
					<div class="fg-title">封面：</div>
					<div class="fg-input">
						<input name="uploadFile1" id="uploadFile1" onchange="uploadImgFile(this);" type="file">
						<input name="smallpic" type="hidden" />
						<span>不上传则默认管家头像</span>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">备注：</div>
					<div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否显示：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_show" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_show" checked="checked" value="1">是</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否可更改：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_modify" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_modify" checked="checked" value="1">是</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<?php echo $this->load->view('admin/a/choice_data/choiceExpert.php');  ?>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
//新申请
var columns = [ {field : 'realname',title : '管家姓名',width : '120',align : 'center'},
		{field : 'cityname',title : '所在城市',width : '140',align : 'center' },
		{field : false,title : '头像',width : '120',align : 'center' ,formatter:function(item){
				return '<a href="'+item.pic+'" target="_blank">预览图片</a>';
			}
		},
                {field : false,title : '封面',width : '120',align : 'center' ,formatter:function(item){
				return '<a href="'+item.smallpic+'" target="_blank">预览图片</a>';
			}
		},
		{field : false,title : '是否显示',width : '80',align : 'center',formatter:function(item){
				return item.is_show == 1 ? '显示' : '不显示';
			}
		},
		{field : false,title : '是否可更改',align : 'center', width : '100',formatter:function(item){
				return item.is_modify == 1 ? '可更改' :'不可更改';
			}
		},
		{field : 'showorder',title : '排序',align : 'center', width : '60'},
		{field : 'beizhu',title : '备注',align : 'center', width : '200'},
		{field : false,title : '操作',align : 'center', width : '140',formatter: function(item){
			var button = '';
			if (item.is_modify == 1) {
				button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改</a>&nbsp;';
			}
			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="tab-button but-red">删除</a>';
			return button;
		}
	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg_mobile/mobile_champ_expert/getMHotExpertData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});

$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#add-city').selectLinkage({
			jsonData:data,
			width:'131px',
			names:['country','province','city'],
			callback:function(){
				$("#add-city").change(function(){
					$("#add-data").find("input[name='expertId']").val(0);
					$("#add-data").find("input[name='realname']").val('');
				})
			}
		});
	}
});
//添加弹出层
$("#add-button").click(function(){
	var formObj = $("#add-data");
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('input[type=file]').val('');
	formObj.find('textarea').val('');
	formObj.find("input[name='is_show'][value=1]").attr("checked",true);
	formObj.find("input[name='is_modfiy'][value=1]").attr("checked",true);
	formObj.find("select").val(0);
	$("#add-city").find("select").eq(0).nextAll('select').hide();
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
})

$("#add-data").submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id > 0 ? '/admin/a/cfg_mobile/mobile_champ_expert/edit' :'/admin/a/cfg_mobile/mobile_champ_expert/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_champ_expert/getMHotExpertData',
					pageNumNow:1,
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
				$(".fb-body,.mask-box").hide();
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})
//筛选管家
$("#clickChoiceExpert").click(function(){
	var cityObj = $("#add-city");
	var cityId = cityObj.find("select[name='city']").val();
	if (cityId < 1) {
		alert('请选择管家所在城市');
		return false;
	}
	var cityName = cityObj.find("select[name='city'] :selected").html();
	var provinceName = cityObj.find("select[name='province'] :selected").html();
	$("#cb-search-form").find('input[name=city_id]').val(cityId);
	$(".cb-prompt").html(provinceName+cityName);
	createExpertHtml();
})
//确认选择管家
$(".db-submit").click(function(){
	var obj = $("#db-data").find(".db-active");
	$("#add-data").find("input[name='expertId']").val(obj.attr('data-val'));
	$("#add-data").find("input[name='realname']").val(obj.attr('data-name'));
	$(".choice-box-1").hide();
})

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_mobile/mobile_hot_expert/delete",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_champ_expert/getMHotExpertData',
					searchForm:'#search-condition',
					tableClass:'table-data'
				});
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		});
	}
}
//编辑
function edit(id){
	$.ajax({
		url:'/admin/a/cfg_mobile/mobile_champ_expert/getDetailjson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)){
				var formObj = $("#add-data");
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.startplaceid);
				formObj.find('input[name=realname]').val(data.realname);
				formObj.find('input[name=expertId]').val(data.expert_id);
				formObj.find('input[name=showorder]').val(data.showorder);
				formObj.find('input[name=pic]').val(data.pic);
                                formObj.find('input[name=smallpic]').val(data.smallpic);
				formObj.find('input[name=id]').val(data.id);
				formObj.find('textarea[name=beizhu]').val(data.beizhu);
				formObj.find("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
				formObj.find("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
				$(".uploadImg").remove();
				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
                                $("#uploadFile1").after("<img class='uploadImg' src='" + data.smallpic + "' width='80'>");
				$(".fb-body,.mask-box").show();
			} else {
				alert('请确认您选择的数据');
			}
		}
	});
}
</script>
