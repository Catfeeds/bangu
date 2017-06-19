/**
*	@emthod 供应商列表页js
*	@authod jiakairong
*/
// 分页数据获取
$('.ajax_page').click(function() {
	if ($(this).hasClass('active')) {
		return false;
	}
	var page_new = $(this).find('a').attr('page_new');
	get_ajax_data(page_new);
})
// 条件搜索
$('#search_condition').submit(function() {
	get_ajax_data(1);
	return false;
})

// 点击导航状态
//$('.nav-tabs').find('li').click(function() {
//	$(this).addClass('active').siblings().removeClass('active');
//	$('input[name="status"]').val($(this).attr('status'));
//	get_ajax_data(1);
//})
// 分页数据展示
function get_ajax_data(page_new) {
	$('input[name="page_new"]').val(page_new);
	$.post("/admin/a/supplier/supplier_list_4", $('#search_condition').serialize(), function(data) {
		var data = eval("(" + data + ")");
		$('.pagination_data').html('');

		// 遍历数据
		$.each(data.list, function(key, val) {
			if (typeof val.cname == "object") {
				var cname = '';
			} else {
				var cname = val.cname;
			}
			if (typeof val.pname == "object") {
				var pname = '';
			} else {
				var pname = val.pname;
			}
			if (typeof val.ciname == "object") {
				var ciname = '';
			} else {
				var ciname = val.ciname;
			}
			if (typeof val.rname == "object") {
				var rname = '';
			} else {
				var rname = val.rname;
			}
			
			var str = "<tr>";
			str += "<td>"+val.company_name+"</td>";
			str += "<td>"+cname+pname+ciname+rname+"</td>";
			str += "<td>"+val.addtime+"</td>";
			str += "<td>"+val.supplier_name+"</td>";
			str += "<td>"+val.supplier_idcard+"</td>";
			str += "<td>"+val.supplier_mobile+"</td>";
			str += "<td>"+val.reason+"</td>";
			//str += "<td></td>";
			str += "</tr>";
			$(".pagination_data").append(str);
		});
		$('.pagination').html(data.page_string);
		$('.ajax_page').click(function() {
			if ($(this).hasClass('active')) {
				return false;
			}
			var page_new = $(this).find('a').attr('page_new');
			get_ajax_data(page_new);
		})
	});
}