/**
*	@emthod 游记管理页js
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
		var url = "/admin/a/travel_note/travel_list";
		$('.complain').show();
		$('.time,.status,.travel_all,.travel_type').css('display','none');
	} else if (status == 2) {
		var url = "/admin/a/travel_note/travel_list";
		$('.complain,.status,.travel_all,.travel_type').css('display','none');
		$('.time').show();
	} else if (status == 3) {
		var url = "/admin/a/travel_note/travel_all";
		$('.complain,.status,.travel_all,.travel_type').css('display','none');
		$('.time').show();
	} else if (status == 4) {
		var url = "/admin/a/travel_note/travel_all";
		$('.complain').css('display','none');
		$('.time,.status,.travel_all,.travel_type').show();
	}
	$.post(url, $('#search_condition').serialize(), function(data) {
		var data = eval("(" + data + ")");
		$('.pagination_data').html('');
		// 遍历数据
		$.each(data.list, function(key, val) {
			if (val.usertype == 1) {
				var name = val.realname;
				var type = '管家';
			} else {
				if (typeof val.meid == "string" && val.mestatus == 1) {
					var type = '体验师';
				} else {
					var type = '会员';
				}
				var name = val.truename;
			}
			var str = "<tr>";
			if (status == 1 || status == 2) {
				str += "<td>"+val.tnaddtime+"</td>";
			} else {
				str += "<td>"+val.addtime+"</td>";
			}
			str += "<td>"+val.title+"</td>";
			str += "<td class='td_center'>"+val.browse+"</td>";
			str += "<td class='td_center'>"+val.number+"</td>";
			str += "<td>"+type+"</td>";
			str += "<td>"+name+"</td>";
			str += "<td>"+val.usedate+"</td>";
			if (status == 1) {
				str += "<td>"+val.supplier_name+"</td>";
				str += "<td><a href='javascript:void(0);' onclick='show_travel("+val.tnid+" ,3)' >查看申诉</a></td>";
				str += '<td><a href="javascript:void(0);" onclick="show_travel('+val.tnid+' ,1)" class="btn btn-info btn-xs"> 通过</a>&nbsp;';
				str += '<a href="javascript:void(0);" onclick="show_travel('+val.tnid+' ,2)" class="btn btn-danger btn-xs">拒绝</a></td>';
			} else if(status == 2 || status == 3) {
				str += "<td>"+val.moaddtime+"</td>";
			} else if (status == 4) {
				if (typeof val.tncid == "string" && val.status == 0) {
					var sname = '审核中';
					var button = '<a href="javascript:void(0);" onclick="show_travel('+val.id+' ,4)" class="btn btn-info btn-xs">下线</a>';
				} else if (val.is_show == 1) {
					var sname = '正常';
					var button = '<a href="javascript:void(0);" onclick="show_travel('+val.id+' ,4)" class="btn btn-info btn-xs">下线</a>&nbsp;';
					if (val.showorder > 1) {
						button += '<a href="javascript:void(0);" onclick="show_travel('+val.id+' ,5)" class="btn btn-info btn-xs">置顶</a>&nbsp;';
					}
					if (val.is_essence == 0) {
						button += '<a href="javascript:void(0);" onclick="show_travel('+val.id+' ,6)" class="btn btn-danger btn-xs">设为精华</a>';
					}
				}else if (val.is_show == 0) {
					var sname = '下线';
					var button = '';
				}
				str += "<td>"+val.moaddtime+"</td>";
				str += "<td>"+sname+"</td>";
				str += '<td>'+button+'</td>';
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

function show_travel(id ,is) {
	$.post("/admin/a/travel_note/get_travel_one_json",{id:id},function(data){
		if (data == false) {
			alert('请确认您选择的游记是否正确');
			return false;
		}
		var data = eval('('+data+')');
		
		if (data.usertype == 1) {
			var type = '管家';
			var name = data.realname;
		} else if (data.usertype == 0) {
			if (typeof data.mestatus == 'string' && data.mestatus == 1) {
				var type = '体验师';
			} else {
				var type = '会员';
			}
			var name = data.truename;
		}
		$('.travel_title').html(data.title);
		$('.travel_author').html('——'+type+'&nbsp;&nbsp;'+name+'&nbsp;&nbsp;('+data.addtime+')');
		$('.travel_sn').html('供应商名称：'+data.supplier_name);
		$('.travel_ln').html('线路名称：'+data.productname);
		$('.main_content').html(data.content);
		$('.eat_content').html(data.content1);
		$('.live_content').html(data.content2);
		$('.co_content').html(data.content3);
		$('.eat_pic,.live_pic,.co_pic').find('img').remove();
		if (typeof data.pic1 !== 'undefined') {
			$.each(data.pic1 ,function(key ,val) {
				if (val.length > 1) {
					$('.eat_pic').append('<img src="'+val+'" width="250" height="150" />');
				}
			})
		}
		if (typeof data.pic2 !== 'undefined') {
			$.each(data.pic2 ,function(key ,val) {
				if (val.length > 1) {
					$('.live_pic').append('<img src="'+val+'" width="250" height="150" />');
				}
			})
		}
		if (typeof data.pic3 !== 'undefined') {
			$.each(data.pic3 ,function(key ,val) {
				if (val.length > 1) {
					$('.co_pic').append('<img src="'+val+'" width="250" height="150" />');
				}
			})
		}
		$('.travel_button div').show();
		if (is == 1 || is == 2 || is == 3) {
			if (is == 3) {
				$('.travel_offline,.travel_overhead,.travel_essence').css('display','none');
			} else if (is== 2) {
				$('.travel_offline,.travel_overhead,.travel_essence,.travel_through').css('display','none');
			} else {
				$('.travel_offline,.travel_overhead,.travel_essence,.travel_refuse').css('display','none');
			}
			$('.travel_supplier,.travel_reason').show();
			$('.supplier_complain .content_title').html('供应商申诉内容：('+data.taddtime+')');
			$('.complain_content').html(data.reason);
		} else {
			$('.travel_supplier,.travel_reason').hide();
			if (is == 4) {
				if (typeof data.tid == 'string') {
					$('.travel_supplier,.travel_reason').show();
					$('.supplier_complain .content_title').html('供应商申诉内容：('+data.taddtime+')');
					$('.complain_content').html(data.reason);
					$('.travel_offline').html('下线并通过申诉审核');
				} else {
					$('.travel_offline').html('下线');
				}
				$('.travel_overhead,.travel_essence,.travel_refuse,.travel_through').css('display','none');
			} else if(is == 5) {
				$('.travel_offline,.travel_essence,.travel_refuse,.travel_through').css('display','none');
			} else if (is == 6) {
				$('.travel_offline,.travel_overhead,.travel_refuse,.travel_through').css('display','none');
			}
		}
		$('input[name="travel_id"]').val(data.id);
		$('.travel_info').show();
		$('.modal-backdrop').show();
	})
}
$('.travel_close').click(function(){
	$('.travel_info').hide();
	$('.modal-backdrop').hide();
})
//通过申诉申请
$('.travel_through').click(function(){
	var page_new = $('input[name="page_new"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	$.post("/admin/a/travel_note/through_complain",{id:id,remark:remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			get_ajax_data(page_new);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//拒绝申诉申请
$('.travel_refuse').click(function(){
	var page_new = $('input[name="page_new"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	$.post("/admin/a/travel_note/refuse_complain",{id:id,remark:remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			get_ajax_data(page_new);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//下线
$('.travel_offline').click(function(){
	var page_new = $('input[name="page_new"]').val();
	var id = $('input[name="travel_id"]').val();
	var remark = $('textarea[name="remark"]').val();
	$.post("/admin/a/travel_note/show_change",{id:id,remark:remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			get_ajax_data(page_new);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})

//加精
$('.travel_essence').click(function(){
	var page_new = $('input[name="page_new"]').val();
	var id = $('input[name="travel_id"]').val();
	$.post("/admin/a/travel_note/essence_change",{id:id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			get_ajax_data(page_new);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})
//顶置
$('.travel_overhead').click(function(){
	var page_new = $('input[name="page_new"]').val();
	var id = $('input[name="travel_id"]').val();
	$.post("/admin/a/travel_note/showorder_change",{id:id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			get_ajax_data(page_new);
			$('.travel_info').hide();
			$('.modal-backdrop').hide();
		} else {
			alert(data.msg);
		}
	})
})




