/**
*	@emthod 专家列表页js
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
	$.post("/admin/a/expert/expert_list", $('#search_condition').serialize(), function(data) {
		var data = eval("(" + data + ")");
		$('.pagination_data').html('');
		if (status == 1 || status == 2) {
			$('.operation').css('display','block');
		} else {
			$('.operation').css('display','none');
		}
		// 遍历数据
		$.each(data.list, function(key, val) {
			if (typeof val.cid_name == "object") {
				var cid_name = "";
			} else {
				var cid_name = val.cid_name;
			}
			if (typeof val.rd_name == "object") {
				var rd_name = "";
			} else {
				var rd_name = val.rd_name;
			}
			if (typeof val.cd_name == "object") {
				var cd_name = "";
			} else {
				var cd_name = val.cd_name;
			}
			if (typeof val.pd_name == "object") {
				var pd_name = "";
			} else {
				var pd_name = val.pd_name;
			}
			if (status == 1) {
				var button_str = '<a href="javascript:void(0);" onclick="details('+val.id+' ,1)" class="btn btn-info btn-xs"> 通过</a>&nbsp;';
				button_str += '<a href="javascript:void(0);" onclick="details('+val.id+' ,2)" class="btn btn-danger btn-xs"> 退回</a>';
			} else if (status == 2) {
				var button_str = '<a href="javascript:void(0);" onclick="stop('+val.id+')" class="btn btn-danger btn-xs">终止合作</a>';
			} else {
				var button_str = '';
			}
			
			var str = "<tr>";
			if (status == 1 || status == 3) {
				str += "<td class='td_center' onclick='details("+val.id+" ,0)' style='cursor:pointer;color:#2DC3E8;'>"+val.realname+"</td>";
			} else {
				str += "<td class='td_center' onclick='see_expert("+val.id+")' style='cursor:pointer;color:#2DC3E8;'>"+val.realname+"</td>";
			}
			str += "<td>"+val.mobile+"</td>";
			str += "<td >"+val.idcard+"</td>";
			str += "<td title='"+cd_name+pd_name+cid_name+rd_name+"'>"+cid_name+rd_name+"</td>";
			if (status == 1 || status == 2) {
				str += "<td>"+button_str+"</td>";
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
//查看管家详情(审核中的与已拒绝的)
function details(id ,is) {
	var status = $('input[name="status"]').val();
	$.post("/admin/a/expert/get_expert_json",{'id':id},function(data) {
		if (data == false) {
			alert("请确认您选择的专家正确");
			return false;
		}
		var data = eval('('+data+')');
		$('.ex_realname').html(data.realname);
		$('.ex_mobile').html(data.mobile);
		$('.ex_qq').html(data.qq);
		$('.ex_idcard').html(data.idcard);
		if (typeof data.idcardpic != 'object') {
			$('.ex_idcardpic').html('<img src="'+data.idcardpic+'" width="80" />');
		}
		
		$('.ex_industry').html(data.industry);
		$('.ex_company').html(data.company_name);
		$('.ex_address').html(data.ca_name+data.pa_name+data.cia_name+data.ra_name);
		$('input[name="id"]').val(data.id);
		
		if (status == 1) {
			$('.eject_botton').css('display','block');
		} else {
			$('.eject_botton').css('display','none');
		}
		$('.ex_through,.ex_refuse').css('display','block');
		if (is == 1) {
			$('.ex_refuse').css('display','none');
		} else if (is == 2) {
			$('.ex_through').css('display' ,'none');
		}
		$('.modal-backdrop').show();
		$('.details_expert').show();
	});
}
//查看管家详情（合作中与已终止）
function see_expert(id) {
	$.post("/admin/a/expert/get_expert_apply_info",{'id':id},function(data){
		if (data == false) {
			alert('请确认您选择的专家');
			return false;
		}
		var data = eval('('+data+')');
		
		if(typeof data.expert.small_photo == "object") {
			var photo_str = "";
		} else {
			var photo_str = "<img src='"+data.expert.small_photo+"' width='80' height='80' />";
		}
		if(typeof data.expert.idcardpic == "object") {
			var idcardpic_str = "";
		} else {
			var idcardpic_str = "<img src='"+data.expert.idcardpic+"' width='80' height='80' />";
		}
		//管家基础信息
		$('.el_realname').html(data.expert.realname);
		$('.el_mobile').html(data.expert.mobile);
		$('.el_email').html(data.expert.email);
		$('.el_idcard').html(data.expert.idcard);
		$('.el_photo').html(photo_str);
		$('.el_idcardpic').html(idcardpic_str);
		$('.el_address').html(data.expert.ca_name+data.expert.pa_name+data.expert.cia_name+data.expert.ra_name);
		$('.el_theme').html(data.expert.theme);
		$('.el_business').html(data.expert.business);
		$('.el_talk').html(data.expert.talk);
		$('input[name="expert_id"]').val(data.expert.id);
		//管家售卖线路
		expert_apply_line(data.apply ,data.supplier ,data.dest ,data.page_string)
		
		$('.modal-backdrop').show();
		$('.expert_info_line').show();
	});
}
/**
 * @method 管家售卖线路
 * @param line 线路数据
 * @param suppiler 商家数据
 * @param dest 目的地数据
 * @param page_str 分页字符串
 */
function expert_apply_line(line ,supplier ,dest ,page_str) {
	//写入商家的下拉框
	$.each(supplier ,function(key ,val) {
		if (typeof val.company_name == "object") {
			var s_name = val.realname;
		} else {
			var s_name = val.company_name;
		}
		var str = "<option value='"+val.id+"'>"+s_name+"</option>";
		$('select[name="search_supplier"]').append(str);
	})
	//写入目的地下拉框
	$('select[name="search_dest"]').html('<option value="0">请选择目的地</option>');
	$.each(dest ,function(key ,val) {
		var dstr = "<option value='"+val.id+"'>"+val.kindname+"</option>";
		$('select[name="search_dest"]').append(dstr);
	})
	//写入列表数据
	$('.expert_line_data').html('');
	$.each(line ,function(key ,val) {
		if (typeof val.company_name == "object") {
			var s_name = val.realname;
		} else {
			var s_name = val.company_name;
		}
		if (val.grade == 1) {
			var grade_name = "管家";
		} else if (val.grade == 2) {
			var grade_name = "初级专家";
		} else if (val.grade == 3) {
			var grade_name = "中级专家";
		} else if (val.grade == 4) {
			var grade_name = "高级专家";
		}
		var tr_str = "<tr>";
		tr_str += "<td class='td_center'>"+val.linecode+"</td>";
		tr_str += "<td>"+val.linename+"</td>";
		tr_str += "<td class='td_center'>"+val.lineprice+"</td>";
		tr_str += "<td class='td_center'>"+val.agent_rate+"%</td>";
		tr_str += "<td class='td_center'>"+val.satisfyscore*100+"%</td>";
		tr_str += "<td class='td_center'>"+val.comment+"</td>";
		tr_str += "<td class='td_center'>"+val.sales+"</td>";
		tr_str += "<td class='td_center'>"+grade_name+"</td>";
		tr_str += "<td>"+s_name+"</td>";
		tr_str += "</tr>";
		$('.expert_line_data').append(tr_str);
	})
	$('.ela_page').html(page_str)
	
	// 管家售卖线路分页
	$('.ajax_page').click(function(){
		if ($(this).hasClass('active')) {
			return false;
		}
		var page_new = $(this).find('a').attr('page_new');
		get_expert_apply_ajax(page_new);
	})
	$('#search_expert_apply').submit(function(){
		get_expert_apply_ajax(1);
		return false;
	})
}
//售卖线路分页
function get_expert_apply_ajax(page_new) {
	$('input[name="page"]').val(page_new);
	$.post("/admin/a/expert/get_expert_apply",$('#search_expert_apply').serialize(),function(data){
		var data = eval('('+data+')');
		$('.expert_line_data').html('');
		$.each(data.list ,function(key ,val) {
			if (typeof val.company_name == "object") {
				var s_name = val.realname;
			} else {
				var s_name = val.company_name;
			}
			if (val.grade == 1) {
				var grade_name = "管家";
			} else if (val.grade == 2) {
				var grade_name = "初级专家";
			} else if (val.grade == 3) {
				var grade_name = "中级专家";
			} else if (val.grade == 4) {
				var grade_name = "高级专家";
			}
			var tr_str = "<tr>";
			tr_str += "<td class='td_center'>"+val.linecode+"</td>";
			tr_str += "<td>"+val.linename+"</td>";
			tr_str += "<td class='td_center'>"+val.lineprice+"</td>";
			tr_str += "<td class='td_center'>"+val.agent_rate+"%</td>";
			tr_str += "<td class='td_center'>"+val.satisfyscore*100+"%</td>";
			tr_str += "<td class='td_center'>"+val.comment+"</td>";
			tr_str += "<td class='td_center'>"+val.sales+"</td>";
			tr_str += "<td class='td_center'>"+grade_name+"</td>";
			tr_str += "<td>"+s_name+"</td>";
			tr_str += "</tr>";
			$('.expert_line_data').append(tr_str);
		})
		$('.ela_page').html(data.page_string)
		$('.ajax_page').click(function(){
			if ($(this).hasClass('active')) {
				return false;
			}
			var page_new = $(this).find('a').attr('page_new');
			get_expert_apply_ajax(page_new);
		})
	})
}

//管家详情---管家基础信息与售卖线路切换
$('.eb_title').click(function(){
	//点击的是已选中的则不向下执行
	if ($(this).hasClass('eb_active')) {
		return false;
	}
	$(this).removeClass('ebn_active').addClass('eb_active');
	$(this).siblings('.eb_title').removeClass('eb_active').addClass('ebn_active'); 
	if ($(this).hasClass('sale_line')) {
		$('.expert_basics_info').css('display','none');
		$('.expert_sale_line').css('display','block');
	} else {
		$('.expert_basics_info').css('display','block');
		$('.expert_sale_line').css('display','none');
	}
	
})

//关闭管家详情
$('.ex_colse').click(function() {
	$('.modal-backdrop').hide();
	$('.details_expert').hide();
	$('.stop_expert').hide();
	$('.expert_info_line').hide();
})
//退回申请
$('.ex_refuse').click(function() {
	var id = $('input[name="id"]').val();
	$.post("/admin/a/expert/expert_to_examine",{'id':id,'is':2},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
})
//通过申请
$('.ex_through').click(function() {
	var id = $('input[name="id"]').val();
	$.post("/admin/a/expert/expert_to_examine",{'id':id,'is':1},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
})
//终止与管家合作
$('.ex_stop').click(function(){
	var id = $('input[name="stop_id"]').val();
	var reason = $('textarea[name="reason"]').val();
	$.post("/admin/a/expert/stop_expert",{'id':id,'reason':reason},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
})

function stop(id) {
	$('input[name="stop_id"]').val(id);
	$('textarea[name="reason"]').val('');
	$('.stop_expert').show();
	$('.modal-backdrop').show();
}

$('.bootbox-close-button').click(function(){
	$('#add_expert_form').find('input').css('border', '1px solid #D5D5D5');
	$('.modal-backdrop').hide();
    $('.bootbox').hide();
})
$('#add_expert').click(function() {
	$('#add_expert_form').find('input,textarea').val('');
	$('#add_expert_form').find('select').val(0);
	$('#country').nextAll('select').remove();
	$('.form-group').find('.bootbox-close-button').val('取消');
	$('.submit_add').val('添加并审核');
	$('#upfile_photo,#upfile_idcard').val('上传');
	$('.modal-backdrop').show();
	$('.bootbox').show();
	$('.upload_pic').remove();
	
})
$('#upfile_photo').on('click', function() {
	//上传头像
	ajax_upload_file('photo' ,'small_photo' ,'expert_photo');
});
//添加专家
$('#add_expert_form').submit(function(){
	$('#add_expert_form').find('input').trigger('blur');
	if ($('#add_expert_form').find('input').hasClass('error')) {
		return false;
	}
	$.post("/admin/a/expert/add_expert",$('#add_expert_form').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			//重置随机码
			var code = create_rand_code();
			$('input[name="rand_code"]').val(code);
			alert(data.msg);
		}
	});
	return false;
});
//上传身份证扫描件
$('#upfile_idcard').on('click', function() {
	ajax_upload_file('cardpic' ,'idcardpic' ,'expert_card');
});

//目的地选择
$('select[name="search_dest"]').change(function(){
	var dest_id = $('select[name="search_dest"] :selected').val();
	$(this).nextAll('select').remove();
	if (dest_id == 0) {
		return false;
	}
	
	$.post("/admin/a/expert/get_destinations",{id:dest_id},function(data) {
		if (data == false) {
			return false;
		}
		var data = eval('('+data+')');
		$('select[name="search_dest"]').after("<select name='search_dest_two' ><option value='0'>请选择</option></select>");
		$.each(data ,function(key ,val) {
			var str = "<option value='"+val.id+"'>"+val.kindname+"</option>";
			$('select[name="search_dest_two"]').append(str);
		})
		
		$('select[name="search_dest_two"]').change(function(){
			var id = $('select[name="search_dest_two"] :selected').val();
			$(this).next('select').remove();
			if (id == 0) {
				return false;
			}
			$.post("/admin/a/expert/get_destinations",{id:id},function(data) {
				if (data == false) {
					return false;
				}
				var data = eval('('+data+')');
				$('select[name="search_dest_two"]').after("<select name='search_dest_three' ><option value='0'>请选择</option></select>");
				$.each(data ,function(key ,val) {
					var str = "<option value='"+val.id+"'>"+val.kindname+"</option>";
					$('select[name="search_dest_three"]').append(str);
				})
			})	
		})
	})	
})

//地区选择
$('select[name="country"]').change(function(){
		var country_id = $('select[name="country"] :selected').val();
		$('#province_id').remove();
		$('#city_id').remove();
		$('#region_id').remove();
		if (country_id == 0) {
			return false;
		}
		$('#province_id').remove();
		$('#city_id').remove();
		$('#region_id').remove();
		if (country_id == 0) {
			return false;
		}
		$.post(
			"/admin/a/expert/get_area_json",
			{'id':country_id},
			function(data) {
				if (data == false) {
					return false;
				}
				data = eval('('+data+')');
				$('#country').after("<select name='province' id='province_id' style='width:150px;'><option value='0'>请选择</option></select>");
				$.each(data ,function(key ,val){
					str = "<option value='"+val.id+"'>"+val.name+"</option>";
					$('#province_id').append(str);
				})
				$('#province_id').change(function(){
					var province_id = $('select[name="province"] :selected').val();
					province(province_id)
				})
			}
		);
	})

	$('select[name="country_id"]').change(function(){
		var country_id = $('select[name="country_id"] :selected').val();
		$('#province_id').remove();
		$('#city_id').remove();
		$('#region_id').remove();
		if (country_id == 0) {
			return false;
		}
		$.post(
			"/admin/a/expert/get_area_json",
			{'id':country_id},
			function(data) {
				if (data == false) {
					return false;
				}
				data = eval('('+data+')');
				$('#country_id').after("<select name='province' id='province_id' style='width:150px;'><option value='0'>请选择</option></select>");
				$.each(data ,function(key ,val){
					str = "<option value='"+val.id+"'>"+val.name+"</option>";
					$('#province_id').append(str);
				})
				$('#province_id').change(function(){
					var province_id = $('select[name="province"] :selected').val();
					province(province_id)
				})
			}
		);
	})
	$('select[name="province"]').change(function(){
		var province_id = $('select[name="province"] :selected').val();
		$('#city_id').remove();
		$('#region_id').remove();
		province(province_id)
	})
	function province(id) {
		$('#city_id').remove();
		$('#region_id').remove();
		if (id == 0) {
			return false;
		}
		$.post(
			"/admin/a/expert/get_area_json",
			{'id':id},
			function(data) {
				if (data == false) {
					return false;
				}
				data = eval('('+data+')');
				$('#province_id').after("<select name='city' id='city_id' style='width:150px;'><option value='0'>请选择</option></select>");
				$.each(data ,function(key ,val){
					str = "<option value='"+val.id+"'>"+val.name+"</option>";
					$('#city_id').append(str);
				})
				$('#city_id').change(function(){
					var city_id = $('select[name="city"] :selected').val();
					city(city_id)
				})
			}
		);
	}
	function city(id) {
		$('#region_id').remove();
		if (id == 0) {
			return false;
		}
		$.post(
			"/admin/a/expert/get_area_json",
			{'id':id},
			function(data) {
				if (data == false) {
					return false;
				}
				data = eval('('+data+')');
				$('#city_id').after("<select name='region' id='region_id' style='width:150px;'><option value='0'>请选择</option></select>");
				$.each(data ,function(key ,val){
					str = "<option value='"+val.id+"'>"+val.name+"</option>";
					$('#region_id').append(str);
				})

			}
		);
	}




