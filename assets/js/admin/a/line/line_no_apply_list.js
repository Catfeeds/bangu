/**********管家升级js**********/
var grade = new Array();
grade[1] = '管家';
grade[2] = '初级专家';
grade[3] = '中级专家';
grade[4] = '高级专家';
function show_details(id ,is) {
	$.post("/admin/a/line_apply/get_one_json",{id:id},function(data) {
		if (data == false) {
			alert('请确认您选择的数据');
			return false;
		}
		if (is == 1) {
			$('.eu_refuse_remark,.ex_refuse').css('display','none');
			$('.ex_through').show();
		} else {
			$('.eu_refuse_remark,.ex_refuse').css('display','block');
			$('.ex_through').hide();
		}
		var data = eval('('+data+')')
		$('.eu_realname').html(data.expert_name);
		$('.eu_grade').html(grade[data.grade]);
		$('.eu_cityname').html(data.cityname);
		$('.eu_agent_rate').html(data.agent_rate+'%');
		$('.eu_line_title').html(data.line_title);
		$('.eu_supplier_name').html(data.supplier_name);
		$('input[name="eu_id"]').val(data.euid);
		$('textarea[name="apply_remark"]').val(data.apply_remark);
		$('.modal-backdrop,.eject_body').show();
	});	
}
//关闭弹出
$('.ex_colse').click(function(){
	$('.modal-backdrop,.eject_body').hide();
})
//通过
$('.ex_through').click(function(){
	var id = $('input[name="eu_id"]').val();
	$.post('/admin/a/line_apply/through',{id:id},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg)
		}
	})
	return false;
})
//拒绝
$('.ex_refuse').click(function(){
	var refuse_remark = $('textarea[name="refuse_remark"]').val();
	var id = $('input[name="eu_id"]').val();
	$.post('/admin/a/line_apply/refuse',{id:id,refuse_remark:refuse_remark},function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg)
		}
	})
	return false;
})

$('.submit_form').click(function(){
	$.post('/admin/a/search_condition/update',$('#search_condition_form').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg)
		}
	})
	return false;
})

function get_ajax_data (page_new) {
	$('input[name="page_new"]').val(page_new);
	var status = $('input[name="status"]').val();
	if (status == 1) {
		$('.operation').show();
	} else {
		
		$('.operation').css('display','none');
	}
	$.post("/admin/a/line_apply/get_expert_upgrade_json" ,$("#search_condition").serialize(),function(data) {
		var data = eval('('+data+')');
		$('.pagination_data').html('');
		var html = '';
		$.each(data.list ,function(key ,val) {
			html += '<tr>';
			html += '<td style="text-align:left;">'+val.line_title+'</td>';
			html += '<td>'+val.supplier_name+'</td>';
			html += '<td>'+val.cityname+'</td>';
			html += '<td>'+val.agent_rate+'%</td>';
			html += '<td>'+val.expert_name+'</td>';
			html += '<td title="'+val.apply_remark+'">'+val.apply_remark.substring(0,15)+'</td>';
			html += '<td>'+grade[val.grade]+'</td>';
			if (status == 1) {
				html += '<td><a href="javascript:void(0);" onclick="show_details('+val.euid+' ,1)" style="margin-bottom:5px;" class="btn btn-info btn-xs"> 通过</a>&nbsp;&nbsp;';
				html += '<a href="javascript:void(0);" onclick="show_details('+val.euid+' ,2)"  style="margin-bottom:5px;" class="btn btn-danger btn-xs">拒绝</a></td>';
			}
			html += '</tr>';
		})
		$('.pagination_data').append(html);
		$('.pagination').html(data.page_string);
		//分页搜索
		$('.ajax_page').click(function(){
			var page_new = $(this).find('a').attr('page_new');
			get_ajax_data(page_new);
		})
	})
}
//首次进入加载数据
get_ajax_data(1);
//条件搜索
$('#search_condition').submit(function(){
	get_ajax_data(1);
	return false;
})


