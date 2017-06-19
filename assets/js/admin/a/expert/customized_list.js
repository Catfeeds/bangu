/******定制单页面******/
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
	$.post("/admin/a/expert/customized_page", $('#search_condition').serialize(), function(data) {
		var data = eval("(" + data + ")");
		$('.pagination_data').html('');
		// 遍历数据
		$.each(data.list, function(key, val) {
			var str = "<tr>";
			str += "<td class='td_center'>" + val.linkname + "</td>";
			str += "<td>" + val.linkphone + "</td>";
			str += "<td>" + val.startdate + "</td>";
			str += "<td class='td_center'>" + val.startplace + "</td>";
			str += "<td class='td_center'>" + val.endplace + "</td>";
			str += "<td class='td_center'>" + val.budget + "</td>";
			str += "<td class='td_center'>" + val.days + "</td>";
			str += "<td class='td_center'>" + val.people + "</td>";
			if (status == 3) {
				str += "<td><a href='javascript:void(0);' onclick='detailed("+val.id+" ,1)' class='btn btn-info btn-xs edit'>查看详情</a></td>";
			} else {
				str += "<td><a href='javascript:void(0);' onclick='detailed("+val.id+")' class='btn btn-info btn-xs edit'>查看详情</a></td>";
			}
			
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
// 查看定制单详细
function detailed(id ,is) {
	var status = $("input[name='status']").val();
	$.post("/admin/a/expert/get_one_customized_json",{'id':id,'status':status},function(data) {
		if (data.length < 1) {
			alert('请确认您选择的数据是否正确');
			return false;
		}
		var data = eval('('+data+')');
		$('.cus_linkname').html(data.linkname);
		$('.cus_linkphone').html(data.linkphone);
		$('.cus_startdate').html(data.startdate);
		$('.cus_budget').html(data.budget);
		$('.cus_startplace').html(data.startplace);
		$('.cus_endplace').html(data.endplace);
		$('.cus_days').html(data.days);
		$('.cus_people').html(data.people);
		$('.cus_trip_way').html(data.trip_way);
		$('.cus_hotelstar').html(data.hotelstar);
		$('.cus_catering').html(data.catering);
		$('.cus_isshopping').html(data.isshopping);
		$('.cus_service_range').val(data.service_range);
		$('.cus_grab').html(data.grab);
		$('.cus_reply').html(data.reply);
		if (is == 1) {
			$(".cus_bid").show();
			$('.cus_expert').html(data.realname);
			$('.cus_supplier').html(data.company_name);
		} else {
			$(".cus_bid").hide();
		}
		$('.eject_body').show();
		$('.modal-backdrop').show();
	});
}
$('.eject_colse').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();
})

