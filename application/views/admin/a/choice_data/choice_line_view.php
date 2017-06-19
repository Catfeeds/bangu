<style>
.search-list{display: inline-block;margin-top: 10px;}
</style>
<div class="choice-box-line" style="display: block;">
	<div class="cb-search">
		<span class="cb-prompt"><!--已选择不可更改的信息提示--></span>
		<form action="#" method="post" id="cb-search-form">
			<ul style="margin: 10px 20px;">
				<li class="search-list">
					<span class="search-title">始发地：<?php echo $startcity?></span>
					<input type="hidden" name="startplaceid" value="<?php echo $startplaceid;?>">
				</li>
				<li class="search-list">
					<span class="search-title">线路名称：</span>
					<span ><input class="search-input" type="text" name="linename" /></span>
				</li>
				<li class="search-list">
					<span class="search-title">线路编号：</span>
					<span ><input class="search-input" type="text" name="linecode" /></span>
				</li>
				<?php if ($is_search_city != 1):?>
				<li class="search-list">
					<span class="search-title">始发地：</span>
					<span>
						<input class="search-input" type="text" value="<?php echo $startcity;?>" onclick="showStartplaceTree(this);" name="startcity" />
						<input type="hidden" name="startplaceid" value="<?php echo $startplaceid;?>">
					</span>
				</li>
				<?php endif;?>
				<li class="search-list">
					<span class="search-title">
						<input type="checkbox" name="all_city" <?php if($all_city>0){echo 'checked';}?> value="<?php echo $all_city?>">全国出发
					</span>
				</li>
				<li class="search-list">
					<input type="hidden" name="type" value="<?php echo $type;?>">
					<input type="hidden" name="page" value="1">
					<input type="hidden" name="pageSize" value="9">
					<input type="submit" value="搜索" class="search-button" />
				</li>
			</ul>
			<span id="cb-choice-city"></span>
		</form>
	</div>
	<div class="db-data-list">
		<ul class="db-data-line"></ul>
		<div class="db-pagination page-button"></div>
	</div>
	
	<div class="db-button">
		<div class="db-submit line-submit">确认选择</div>
	</div>
</div>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script>
createLineHtml();
var lineData;
function createLineHtml() {
	var index;
	$.ajax({
		url:'/admin/commonData/getLineData',
		type:'post',
		dataType:'json',
		data:$("#cb-search-form").serialize(),
		beforeSend:function(){
			index = layer.load(0 ,{shade:[0.3 ,'#fff']});
		},
		complete:function(){
			layer.close(index);
		},
		success:function(data){
			lineData = data.list;
			if ($.isEmptyObject(data.list)) {
				$(".db-pagination").html('');
				$(".db-data-line").html('<div class="db-msg">换个搜索条件试试</div>');
			} else {
				var html = '';
				$.each(data.list ,function(key ,val){
                    var url = '/line/'+val.lineid + '.html';
					if (key % 2 == 1) {
						html += '<li class="db-data-row row-odd" data-val="'+key+'" >';
					} else {
						html += '<li class="db-data-row" data-val="'+key+'">';
					}
					html += '<div class="db-data-pic"><img src="'+val.mainpic+'" /></div>';
					html += '<ul><li>';
					html += '<div class="db-row-title">线路名：</div><div class="db-row-content">';
					html += '<a href="/admin/a/lines/line/detail?id='+val.lineid+'&type=1" target="_blank">'+val.linename+'</a></div>';
					html += '</li><li>';
					html += '<div class="db-row-title">供应商：</div><div class="db-row-content">'+val.company_name+'</div>';	
					html += '</li><li>';		
					html += '<div class="db-row-title">始发地：</div><div class="db-row-content">'+val.cityname;
					var price = typeof val.s_price == 'object' ? 0 : val.s_price;
					html += '<span style="float:right;margin-right:10px;color: #ff0000;">¥'+price+'</span></div>';			
					html += '</li></ul></li>';	
				})
				$(".db-data-line").html(html);
			}
			$(".db-pagination").html(data.page_string);
			$('html, body').animate({scrollTop:0}, 'slow');
			rowClick();
			pageClick();
			if ($(".choice-box-line").is(':hidden')) {
				$(".choice-box-line").show();
			}
		}
	});
}
//选择线路
$('.line-submit').click(function(){
	var key = $('.db-data-line').find('.db-active').attr('data-val');
	if (key) {
		if (typeof parent[0].choiceLineCallback == 'function') {
			//choiceLineCallback是父页面的函数，用于选择线路的后续操作，将传递选中的线路数据
			parent[0].choiceLineCallback(lineData[key]);
			//关闭自己
			var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
			parent.layer.close(index); //再执行关闭 
		}
	} else {
		layer.alert('请选择线路', {icon: 2});
	}
})

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
			$("#cb-search-form").find('input[name=page]').val($(this).find('a').attr('page_new'));
			createLineHtml();
		}
	})
}
$("#cb-search-form").submit(function(){
	$("#cb-search-form").find('input[name=page]').val(1);
	createLineHtml();
	return false;
})
</script>