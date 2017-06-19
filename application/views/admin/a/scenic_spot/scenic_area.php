<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>景点地区管理</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">地区：</span>
						<span id='search-city'></span>
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
			<h4>景点地区管理</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="form-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">选择城市：</div>
					<div class="fg-input" id="add-city"></div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
					<input type="hidden" name="country" />
					<input type="hidden" name="province" />
					<input type="hidden" name="city" />
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
<script src="/assets/js/jquery-select-search.js"></script>
<script>
var columns = [ {field : 'country',title : '国家',width : '160',align : 'center'},
		{field : 'province',title : '省份',width : '140',align : 'center'},
		{field : 'city',title : '城市',width : '140',align : 'center'},
		{field : null,title : '操作',align : 'center', width : '170',formatter: function(item){
			return '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">编辑</a>&nbsp;';
		}
	}];

$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/scenic/scenic_area/getScenicAreaData',
	pageNumNow:1,
	searchForm:'#search-condition',
	tableClass:'table-data'
});
var addFormObj = $('#form-data');
$('#add-button').click(function(){
	addFormObj.find('input[type=text]').val('');
	addFormObj.find('input[type=hidden]').val('');
	addFormObj.find('select').val(0).change();
	$('.mask-box,.fb-body').show();
})

function edit(id) {
	$.ajax({
		url:'/admin/a/scenic/scenic_area/getBelongDetail',
		data:{id:id},
		type:'post',
		dataType:'json',
		success:function(data) {
			if ($.isEmptyObject(data)) {
				alert('数据错误');
			} else {
				addFormObj.find('input[name=id]').val(data.id);
				addFormObj.find('select[name=country_id]').val(data.country_id).change();
				addFormObj.find('select[name=province_id]').val(data.province_id).change();
				addFormObj.find('select[name=city_id]').val(data.city_id);
				$('.mask-box,.fb-body').show();
			}
		}
	});
}

addFormObj.submit(function(){
	var country = addFormObj.find('select[name=country_id]').find('option:selected').text();
	var province = addFormObj.find('select[name=province_id]').find('option:selected').text();
	var city = addFormObj.find('select[name=city_id]').find('option:selected').text();
	if (typeof city == 'undefined' || city == '请选择'){
		city = '';
	}
	if (typeof province == 'undefined' || province == '请选择'){
		province = '';
	}
	addFormObj.find('input[name=province]').val(province);
	addFormObj.find('input[name=city]').val(city);
	addFormObj.find('input[name=country]').val(country);
	var id = addFormObj.find('input[name=id]').val();
	var url = id>0 ? '/admin/a/scenic/scenic_area/edit' : '/admin/a/scenic/scenic_area/add';
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:addFormObj.serialize(),
		success:function(data) {
			if (data.code == 2000) {
				var pageNow = id>0 ? page : 1;
				$("#dataTable").pageTable({
					columns:columns,
					url:'/admin/a/scenic/scenic_area/getScenicAreaData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:pageNow
				});
				$('.mask-box,.fb-body').hide();
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

$.ajax({
	url:"/admin/a/scenic/scenic_area/getAllScenicArea",
	dataType:'json',
	type:'post',
	success:function(data) {
		if (!$.isEmptyObject(data)) {
			$('#search-city').selectSearch({
				jsonData:data,
				names:['country','province','city'],
				hiddenVals:['country_id' ,'province_id' ,'city_id']
			});
		}
	}
});

$.ajax({
	url:'/common/selectData/getAreaAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#add-city').selectLinkage({
			jsonData:data,
			width:'131px',
			names:['country_id','province_id','city_id']
		});
	}
});
</script>									

