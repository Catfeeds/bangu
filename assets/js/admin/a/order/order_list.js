/**
*	@emthod 订单列表页js
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
$('.nav-tabs').find('li').click(function() {
	$(this).addClass('active').siblings().removeClass('active');
	$('input[name="status"]').val($(this).attr('status'));
	get_ajax_data(1);
})
// 分页数据展示
function get_ajax_data(page_new) {
	$('input[name="page_new"]').val(page_new);
	var status = $('input[name="status"]').val();
	if (status == 1) {
		$('.title_time').html('下单时间');
		$('.title_pay_money').css('display','none');
	} else if (status == 2) {
		$('.title_time').html('留位时间');
		$('.title_pay_money').css('display','block');
	} else if (status == 3) {
		$('.title_time').html('确认时间');
		$('.title_pay_money').css('display','block');
	} else if (status == 4) {
		$('.title_time').html('取消时间');
		$('.title_pay_money').css('display','block');
	}
	$.post("/admin/a/order/order_list", $('#search_condition').serialize(), function(data) {
		var data = eval("(" + data + ")");
		$('.pagination_data').html('');
		// 遍历数据
		$.each(data.list, function(key, val) {
			var str = "<tr>";
			str += "<td>"+val.ordersn+"</td>";
			str += "<td title='"+val.supplier_name+"'>"+val.sub_supplier_name+"</td>";
			str += "<td class='td_center'>"+val.cityname+"</td>";
			str += "<td style='text-align:left;'title='"+val.productname+"'><a href='/admin/a/order/order_detail_info?id="+val.id+"' target='_blank'>"+val.sub_productname+"</a></td>";
			str += "<td class='td_center'>"+val.people_num+"</td>";
			str += "<td class='td_center'>"+val.total_price+"</td>";
			if (status == 2 || status == 3 || status == 4) {
				if (typeof val.count_money == "object") {
					var money = 0;
				} else {
					var money = val.count_money 
				}
				str += "<td>"+money+"</td>";
			}
			str += "<td>"+val.usedate+"</td>";
			str += "<td class='td_center'>"+val.ispay+"</td>";
			if (status == 1) {
				str += "<td class='content_time'>"+val.addtime+"</td>";
			} else if (status == 2) {
				str += "<td class='content_time'>"+val.lefttime+"</td>";
			} else if (status == 3) {
				str += "<td class='content_time'>"+val.confirmtime_supplier+"</td>";
			} else if (status == 4) {
				str += "<td class='content_time'>"+val.canceltime+"</td>";
			}
			str += "<td class='td_center'>"+val.expert_name+"</td>";
			
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