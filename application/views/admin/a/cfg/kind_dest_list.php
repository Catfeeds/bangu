<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>首页分类目的地配置</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">一级分类：</span>
						<span >
							<select name="kind">
								<option value="0">请选择</option>
								<?php
									foreach($kind as $val) {
										echo '<option value="'.$val['id'].'">'.$val['name'].'</option>';
									}
								?>
							</select>
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">始发地：</span>
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
			<h4>首页分类目的地配置</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">始发地：<i>*</i></div>
					<div class="fg-input" id="add-city"></div>
				</div>
				<div class="form-group">
					<div class="fg-title">一级分类：<i>*</i></div>
					<div class="fg-input">
						<select name="kind" style="width:137px;">
							<option value="0">请选择</option>
							<?php 
								foreach($kind as $key =>$val) {
									echo '<option value="'.$val['id'].'" data-dest="'.$val['dest_id'].'">'.$val['name'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">目的地：<i>*</i></div>
					<div class="fg-input">
						<select name="dest_province" style="width:137px;">
							<option value="0">请选择</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">名称：<i>*</i></div>
					<div class="fg-input"><input type="text" name="name" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">图片：</div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
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
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
var columns = [ {field : 'name',title : '名称',width : '120',align : 'center'},
                {field : 'ikname',title : '所属一级分类',width : '120',align : 'center'},
                {field : 'kindname',title : '目的地',width : '120',align : 'center'},
                {field : 'cityname',title : '始发地',width : '120',align : 'center'},
                {field : null,title : '图片',width : '120',align : 'center',formatter:function(item){
						return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
	                }
	            },
        		{field : null ,title : '是否显示' ,width : '100' ,align : 'center',formatter:function(item){
        				return item.is_show == 1 ? '是' : '否';
        			}
        		},
        		{field : null,title : '是否可更改',width : '100',align : 'center',formatter:function(item){
        				return item.is_modify == 1 ? '是' :'否';
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : 'beizhu',title : '备注',align : 'center', width : '160'},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			//if (item.is_modify == 1) {
        				button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改</a>&nbsp;';
        				button += '<a href="javascript:void(0);" onclick="del('+item.id+')" class="tab-button but-blue">删除</a>&nbsp;';
        			//}
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg/index_kind_dest/getKindDestJson',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
$.ajax({
	url:'/common/selectData/getStartplaceJson',
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
			width:'137px',
			names:['country','province','city'],
			callback:function(){
				$("#add-city").change(function(){
					formObj.find('select[name=kind]').val(0);
					formObj.find('select[name=dest_province]').html('<option value="0">请选择</option>').nextAll('select').remove();
				})
			}
		});
	}
});

function del(id) {
	layer.confirm('您确定要删除吗？', {btn:['确认','取消']},function(){
		$.ajax({
			url:'/admin/a/cfg/index_kind_dest/del',
			data:{id:id},
			type:'post',
			dataType:'json',
			success:function(result) {
				if (result.code == '2000') {
					layer.alert(result.msg, {icon: 1});
					location.reload();
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
	});
}

//添加弹出层
$("#add-button").click(function(){
	var formObj = $("#add-data");
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('textarea').val('');
	formObj.find("input[name='is_show'][value=1]").attr("checked",true);
	formObj.find("input[name='is_modfiy'][value=1]").attr("checked",true);
	formObj.find("select").val(0);
	$("#add-city").find("select").eq(0).nextAll('select').hide();
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
})
var formObj = $("#add-data");
var destJson = <?php echo json_encode($destArr);?>
//一级分类变动，获取对应的下级目的地
formObj.find('select[name=kind]').change(function(){
	var dest_id = formObj.find('select[name=kind] :selected').attr('data-dest');
	var name = formObj.find('select[name=kind] :selected').html();
	formObj.find('select[name=dest_province]').html('<option value="0">请选择</option>').nextAll('select').remove();
	if (name == '周边游') {
		getTripDestHtml();
	} else {
		var html = getDestHtml(dest_id);
		formObj.find('select[name=dest_province]').append(html);
	}
});
//获取国内游 & 出境游的目的地
function getDestHtml(dest_id) {
	var html = '';
	if (typeof destJson[dest_id] == 'undefined') {
		return false;
	}
	$.each(destJson[dest_id] ,function(key ,val){
		html += '<option value="'+val.id+'">'+val.kindname+'</option>';
	})
	return html;
}
//目的地变动
formObj.find('select[name=dest_province]').change(function(){
	var name = formObj.find('select[name=kind] :selected').html();
	$(this).next('select').remove();
	if (name != '周边游') {
		var html = getDestHtml($(this).val());
		if (html != false || html.length > 1) {
			formObj.find('select[name=dest_province]').after('<select name="dest_city" style="width:137px;"><option value="0">请选择</option>'+html+'</select>');
		}
	}
	var defaultName = $('select[name=dest_province] :selected').html();
	if (defaultName == '请选择') {
		defaultName = '';
	}
	formObj.find('input[name=name]').val(defaultName);
	formObj.find('select[name=dest_city]').change(function(){
		var defaultName = $('select[name=dest_city] :selected').html();
		if (defaultName == '请选择') {
			defaultName = '';
		}
		formObj.find('input[name=name]').val(defaultName);
	})
});

//获取周边游的目的地
function getTripDestHtml(defaultVal) {
	var city = formObj.find('select[name=city]').val();
	if (city < 1) {
		formObj.find('select[name=kind]').val(0);
		alert('请选择始发地');
		return false;
	}
	$.ajax({
		url:'/admin/a/cfg/index_kind_dest/getTripDest',
		type:'post',
		data:{city:city},
		dataType:'json',
		success:function(data){
			if ($.isEmptyObject(data)) {
				formObj.find('select[name=kind]').val(0);
				alert('当前始发地下没有周边游目的地,请去周边游管理配置');
				return false;
			} else {
				var html = '';
				$.each(data ,function(key ,val){
					html += '<option value="'+val.dest_id+'">'+val.kindname+'</option>';
				})
				formObj.find('select[name=dest_province]').append(html);
				if (typeof defaultVal != 'undefined' && defaultVal >0) {
					formObj.find('select[name=dest_province]').val(defaultVal);
				}
			}
		}
	});
}

$("#add-data").submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id > 0 ? '/admin/a/cfg/index_kind_dest/edit' :'/admin/a/cfg/index_kind_dest/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg/index_kind_dest/getKindDestJson',
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

function edit(id) {
	$.post("/admin/a/cfg/index_kind_dest/getDetailJson" ,{id:id} ,function(data) {
		if ($.isEmptyObject(data)) {
			alert('请确认您选择的数据');
			return false;
		} else {
			var data = eval("("+data+")");
			formObj.find('select[name=country]').val(data.country).change();
			formObj.find('select[name=province]').val(data.province).change();
			formObj.find('select[name=city]').val(data.startplaceid);
			
			formObj.find("input[name='id']").val(data.id);
			formObj.find("input[name='pic']").val(data.pic);
			formObj.find("input[name='showorder']").val(data.showorder);
			formObj.find("textarea[name='beizhu']").val(data.beizhu);
			formObj.find("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
			formObj.find("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
			formObj.find("select[name='kind']").val(data.index_kind_id).change();
			if (data.index_kind_id == 3) {
				getTripDestHtml(data.dest_id);
			} else {
				if (data.level == 2) {
					formObj.find("select[name=dest_province]").val(data.dest_id).change();
				} else {
					formObj.find("select[name=dest_province]").val(data.dest_province).change();
					formObj.find("select[name=dest_city]").val(data.dest_id);
				}
			}
			
			formObj.find("input[name='name']").val(data.name);
			$(".uploadImg").remove();
			if (typeof data.pic != 'undefined' && data.pic.length > 0) {
				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
			}
			$(".fb-body,.mask-box").show();
		}
	})
}
</script>
