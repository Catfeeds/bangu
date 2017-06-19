<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>线路数量统计</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="1">城市线路 统计</li>
			<li class="tab-red" data-val="2">省份线路统计</li>
			<li class="tab-red" data-val="3">全国出发线路</li>
		</ul>
		<div class="tab-content">
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">选择城市：</span>
						<span id="search-city"></span>
					</li>
					<li class="search-list">
						<input type="hidden" name="type" value="1" />
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
		</div>
		<ul class="statistics">
			<?php 
				foreach($countArr as $val)
				{
					echo '<li>'.$val['name'].'('.$val['count'].')</li>';
				}
			?>
			<li><div class="statistics-msg"></div></li>
		</ul>
	</div>
</div>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script>
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
	}
});
$("#search-condition").submit(function(){
	getDataHtml();
	return false;
})
$('.nav-tabs li').click(function(){
	if (!$(this).hasClass('active')) {
		$(this).addClass('active').siblings().removeClass('active');
		$("#search-condition").find('input[name=type]').val($(this).attr('data-val'));
		$('#search-city').find('select').val(0).eq(0).nextAll().hide();
		$(".statistics").html('');
		if ($(this).attr('data-val') == 3) {
			$('#search-condition').hide();
		} else {
			$('#search-condition').show();
		}
		getDataHtml();
	}
})
function getDataHtml(){
	$.ajax({
		url:'/admin/a/statistics/line_count/getSearchJson',
		type:'post',
		dataType:'json',
		data:$('#search-condition').serialize(),
		success:function(data){
			if ($.isEmptyObject(data)){
				$(".statistics").html('<li class="statistics-msg">此地区没有线路，换个地区试试</li>');	
			} else {
				var html = '';
				$.each(data ,function(key ,val){
					html += '<li>'+val.name+'('+val.count+')</li>';
				})
				$(".statistics").html(html);
			}
		}
	})
} 
</script>