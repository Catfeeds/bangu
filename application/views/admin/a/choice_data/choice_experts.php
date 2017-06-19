<div class="choice-box-1">
	<div class="cb-body">
		<h3 class="cb-title">选择管家</h3>
		<div class="cb-colse db-cancel">x</div>
		<div class="cb-search">
			<span class="cb-prompt"><!--已选择不可更改的信息提示--></span>
			<form action="#" method="post" id="cb-search-form">
				<input type="text" name="keyword" placeholder="姓名/昵称">
				<span id="cb-choice-city"></span>
				<input type="hidden" name="page_new" value="1">
				<input type="hidden" name="city_id" value="">
				<input type="hidden" name="province" value="">
				<input type="submit" value="搜索" id="db-submit">
			</form>
		</div>
		<div class="db-data-list">
			<ul id="db-data">
				<li class="db-data-row row-odd db-active">
					<div class="db-data-pic"><img src="" /></div>
					<ul>
						<li>
							<div class="db-row-title">姓名：</div>
							<div class="db-row-content">jiakairong</div>
						</li>
						<li>
							<div class="db-row-title">手机号：</div>
							<div class="db-row-content">18682327560</div>
						</li>
						<li>
							<div class="db-row-title">所在地：</div>
							<div class="db-row-content">广东省深圳市龙岗区坂田杨美村999巷666号11田杨美村999巷666号11</div>
						</li>
					</ul>
				</li>
				<li class="db-data-row">
					<div class="db-data-pic"><img src="" /></div>
					<ul>
						<li>
							<div class="db-row-title">姓名：</div>
							<div class="db-row-content">jiakairong</div>
						</li>
						<li>
							<div class="db-row-title">手机号：</div>
							<div class="db-row-content">18682327560</div>
						</li>
						<li>
							<div class="db-row-title">所在地：</div>
							<div class="db-row-content">广东省深圳市龙岗区坂田杨美村999巷666号11</div>
						</li>
					</ul>
				</li>
			</ul>
			<div class="db-pagination page-button">分页</div>
		</div>
		
		<div class="db-button">
			<div class="db-cancel">取消</div>
			<div class="db-submit">确认选择</div>
		</div>
	</div>
</div>
<script>
	function createExpertHtml() {
		$.ajax({
				url:'/admin/commonData/getExpertsData',
				type:'post',
				dataType:'json',
				data:$("#cb-search-form").serialize(),
				success:function(data){
					if ($.isEmptyObject(data.list)) {
						$("#db-data").html('<div class="db-msg">暂无数据</div>');
					} else {
						var html = '';
						$.each(data.list ,function(key ,val){
							if (key % 2 == 1) {
								html += '<li class="db-data-row row-odd" data-val="'+val.id+'" data-name="'+val.realname+'">';
							} else {
								html += '<li class="db-data-row" data-val="'+val.id+'" data-name="'+val.realname+'">';
							}
							html += '<div class="db-data-pic"><img src="'+val.small_photo+'" /></div>';
							html += '<ul><li>';
							html += '<div class="db-row-title">姓名：</div><div class="db-row-content">'+val.realname+'</div>';
							html += '</li><li>';
							html += '<div class="db-row-title">昵称：</div><div class="db-row-content">'+val.nickname+'</div>';	
							html += '</li><li>';		
							html += '<div class="db-row-title">所在地：</div><div class="db-row-content">'+val.cityname+'</div>';			
							html += '</li></ul></li>';	
						})
						$("#db-data").html(html);
					}
					$(".db-pagination").html(data.page_string);
					rowClick();
					pageClick();
					if ($(".choice-box-1").is(':hidden')) {
						$(".choice-box-1").show();
					}
					//$('html,body').animate({scrollTop:0}, 'slow');
				}
			});
	}
	
	function rowClick() {
		$(".db-data-row").click(function(){
			if ($(this).hasClass('db-active')) {
				$(this).removeClass('db-active');
			} else {
				$(this).addClass('db-active').siblings().removeClass('db-active');
			}
		})
	}
	function pageClick(){
		$(".db-pagination").find('li').click(function(){
			if (!$(this).hasClass('active')){
				$("#cb-search-form").find('input[name=page_new]').val($(this).find('a').attr('page_new'));
				createExpertHtml();
			}
		})
	}
	$("#cb-search-form").submit(function(){
		$("#cb-search-form").find('input[name=page_new]').val(1);
		createExpertHtml();
		return false;
	})
	$(".db-cancel").click(function(){
		$(".choice-box-1").hide();
	})
</script>