<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>首页推荐目的地</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">名称：</span>
						<span ><input class="search-input" type="text" name="name" /></span>
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
			<h4>首页推荐目的地</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">始发地：<i>*</i></div>
					<div class="fg-input" id="add-city"></div>
				</div>
				<div class="form-group">
					<div class="fg-title">目的地：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="kindname" onclick="showDestBaseTree(this)" />
						<input type="hidden" name="destid">
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">名称：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="name" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">头像：</div>
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
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
var columns = [ {field : 'name',title : '名称',width : '120',align : 'center' ,length:20},
                {field : 'kindname',title : '目的地名称',width : '150',align : 'center'},
                {field : 'cityname',title : '始发地',width : '150',align : 'center'},
                {field : null,title : '图片',width : '120',align : 'center',formatter:function(item){
						return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                    }
                },
        		{field : null ,title : '是否显示' ,width : '100' ,align : 'center',formatter:function(item){
        				return item.is_show == 1 ? '显示' :'不显示';
        			}
        		},
        		{field : null,title : '是否可更改',width : '100',align : 'center',formatter:function(item){
        				return item.is_modify == 1 ? '可更改' :'不可更改';
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : 'beizhu',title : '备注',align : 'center', width : '160' ,length:15},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			if (item.is_modify == 1) {
        				button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改</a>&nbsp;';
        			}
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg/index_dest_love/getDestLoveData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
var formObj = $("#add-data");
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
			names:['country','province','city']
		});
	}
});

function callbackTree(id ,name ,data) {
	if (data.level == 0) {
		layer.alert('不可以选择第一级目的地', {icon: 2});
		$('#add-data').find('input[name=kindname]').val('');
		$('#add-data').find('input[name=destid]').val('');
	} else {
		$('#add-data').find('input[name=name]').val(name);
	}
}
// $.ajax({
// 	url:'/common/selectData/getDestAll',
// 	dataType:'json',
// 	type:'post',
// 	data:{level:3},
// 	success:function(data){
// 		$('#add-dest').selectLinkage({
// 			jsonData:data,
// 			width:'137px',
// 			names:['dest_country','dest_province','dest_city'],
// 			callback:function() {
// 				var city = $("#add-dest").find('select[name=dest_city]').find('option:selected').html();
// 				var province = $("#add-dest").find('select[name=dest_province]').find('option:selected').html();
// 				if (typeof city != 'object' && city != '请选择') {
// 					formObj.find('input[name=name]').val(city);
// 				} else if (typeof province != 'object' && province != '请选择') {
// 					formObj.find('input[name=name]').val(province);
// 				} else {
// 					formObj.find('input[name=name]').val('');
// 				}
// 			}
// 		});
// 	}
// });
//添加弹出层
$("#add-button").click(function(){
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('textarea').val('');
	formObj.find("input[name='is_show'][value=1]").attr("checked",true);
	formObj.find("input[name='is_modfiy'][value=1]").attr("checked",true);
	formObj.find("select").val(0);
	$("#add-city").find("select").eq(0).nextAll('select').hide();
	$("#add-dest").find("select").eq(0).nextAll('select').hide();
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
})

$("#add-data").submit(function() {
	var id = $(this).find("input[name='id']").val();
	var url = id > 0 ? '/admin/a/cfg/index_dest_love/edit' : '/admin/a/cfg/index_dest_love/add';
	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			$("#dataTable").pageTable({
				columns:columns,
				url:'/admin/a/cfg/index_dest_love/getDestLoveData',
				pageNumNow:1,
				searchForm:'#search-condition',
				tableClass:'table-data'
			});
			alert(data.msg);
			$(".fb-body,.mask-box").hide();
		} else {
			alert(data.msg);
		}
	})
	return false;
})

function edit(id) {
	$.ajax({
		url:'/admin/a/cfg/index_dest_love/getDetailJson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if ($.isEmptyObject(data)) {
				alert('请确认您选择的数据正确');
			} else {
				formObj.find('input[name=id]').val(data.id);
				formObj.find('input[name=pic]').val(data.pic);
				formObj.find('input[name=showorder]').val(data.showorder);
				formObj.find('textarea[name=beizhu]').val(data.beizhu);
				formObj.find('input[name=is_show][value='+data.is_show+']').attr('checked',true);
				formObj.find('input[name=is_modfiy][value='+data.is_modify+']').attr('checked',true);
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.startplaceid).change();
				formObj.find('input[name=kindname]').val(data.kindname);
				formObj.find('input[name=destid]').val(data.dest_id);
				
				formObj.find('input[name=name]').val(data.name);
				$(".uploadImg").remove();
				if (typeof data.pic == 'string' && data.pic.length > 1) {
					$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
				}
				$(".fb-body,.mask-box").show();
			}
		}
	});
}
</script>