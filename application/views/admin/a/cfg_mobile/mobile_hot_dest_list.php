<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>手机端热门目的地</li>
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
			<h4>手机端热门目的地</h4>
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
					<div class="fg-input"><input type="text" name="name" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">图片：</div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" name="showorder" /></div>
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
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>
var columns = [ {field : 'name',title : '名称',width : '200',align : 'center'},
                {field : 'kindname',title : '目的地',width : '150',align : 'center'},
                {field : 'cityname',title : '始发地',width : '150',align : 'center'},
                {field : null,title : '图片',width : '120',align : 'center',formatter:function(item){
                    	if ( typeof item.pic == 'string' && item.pic.length > 1) {
                    		return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                        } else {
							return '暂无图片';
                        }
						
                    }
                },
        		{field : null ,title : '是否显示' ,width : '100' ,align : 'center',formatter:function(item){
        				return item.is_show == 1 ? '显示' : '不显示';
        			}
        		},
        		{field : null,title : '是否可更改',width : '100',align : 'center',formatter:function(item){
        				return item.is_modify == 1 ? '可更改' :'不可更改';
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
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
	url:'/admin/a/cfg_mobile/mobile_hot_dest/getMHotDestData',
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
			names:['country','province','city'],
			callback:function(obj){
				formObj.find('input[name=name]').val('');
				$('#add-dest').find('select').val(0);
				$('#add-dest').find('select').eq(0).nextAll().html('').hide();
			}
		});
	}
});
//获取周边游目的地
function getRoundDest(cityId ,defaultVal) {
	$.ajax({
		url:'/common/selectData/getStartCityDest',
		data:{city:cityId},
		type:'post',
		dataType:'json',
		success:function(data) {
			if ($.isEmptyObject(data)) {
				alert('当前始发地城市没有配置周边游目的地，请先配置');
				$('#add-dest').find('select[name=dest_country]').val(0);
			} else {
				var html = '<option value="0">请选择</option>';
				$.each(data ,function(k ,v) {
					html += '<option value="'+v.dest_id+'">'+v.name+'</option>';
				})
				$('#add-dest').find('select[name=dest_province]').html(html).show();
				if (typeof defaultVal != 'undefined' && defaultVal >0) {
					$('#add-dest').find('select[name=dest_province]').val(defaultVal);
				}
			}
		}
	});
}


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

$("#add-data").submit(function(){
	var id = $(this).find('input[name=id]').val();
	var url = id > 0 ? '/admin/a/cfg_mobile/mobile_hot_dest/edit' :'/admin/a/cfg_mobile/mobile_hot_dest/add';
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data){
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_hot_dest/getMHotDestData',
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
	$.ajax({
		url:'/admin/a/cfg_mobile/mobile_hot_dest/getDetailJson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)){
				formObj.find('select[name=country]').val(data.country).change();
				formObj.find('select[name=province]').val(data.province).change();
				formObj.find('select[name=city]').val(data.startplaceid);
				
				formObj.find('input[name=kindname]').val(data.kindname);
				formObj.find('input[name=destid]').val(data.dest_id);
				formObj.find('input[name=showorder]').val(data.showorder);
				
				formObj.find('input[name=name]').val(data.name);
				formObj.find('input[name=pic]').val(data.pic);
				formObj.find('input[name=id]').val(data.id);
				formObj.find("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
				formObj.find("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
				$(".uploadImg").remove();
				if (typeof data.pic == 'string' && data.pic.length > 1) {
					$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
				}
				$(".fb-body,.mask-box").show();
			} else {
				alert('请确认您选择的数据');
			}
		}
	});
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/cfg_mobile/mobile_hot_dest/delHotDest",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/cfg_mobile/mobile_hot_dest/getMHotDestData',
					pageNumNow:1,
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
function callbackTree(id ,name ,data) {
	if (data.level == 0) {
		layer.alert('不可以选择第一级目的地', {icon: 2});
		$('#add-data').find('input[name=kindname]').val('');
		$('#add-data').find('input[name=destid]').val('');
	} else {
		$('#add-data').find('input[name=name]').val(name);
	}
}
</script>
