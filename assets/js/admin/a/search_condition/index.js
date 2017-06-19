/**********搜索条件设置js**********/
//添加弹出层
function add() {
	$('#search_condition_form').children().last('.form-group').prevAll().find('input').val('');
	$('select[name="pid"]').val(0);
	$('.modal-backdrop,.bootbox').show();
}
//编辑弹出
function edit(id) {
	$.post("/admin/a/search_condition/get_one_json",{id:id},function(data) {
		if (data == false) {
			alert('请确认您选择的数据');
			return false;
		}
		var data = eval('('+data+')');
		$('input[name="minvalue"]').val(data.minvalue);
		$('input[name="maxvalue"]').val(data.maxvalue);
		$('input[name="showorder"]').val(data.showorder);
		$('input[name="description"]').val(data.description);
		$('input[name="code"]').val(data.code);
		$('input[name="id"]').val(data.id);
		$('select[name="pid"]').val(data.pid);
		$('.modal-backdrop,.bootbox').show();
	})
}
function del(id) {
	$.post("/admin/a/search_condition/get_one_json",{id:id},function(data) {
		if (data == false) {
			alert('请确认您选择的数据');
			return false;
		}
		var data = eval('('+data+')');
		$('.sc_minvalue').html(data.minvalue);
		$('.sc_maxvalue').html(data.maxvalue);
		$('.sc_showorder').html(data.showorder);
		$('.sc_description').html(data.description);
		$('.sc_code').html(data.code);
		$('.sc_top_name').html(data.top_name);
		$('input[name="sc_id"]').val(data.id);
		$('.modal-backdrop,.eject_body').show();
	})
}
//删除
$('.sc_delete').click(function(){
	var id = $('input[name="sc_id"]').val();
	$.post("/admin/a/search_condition/delete",{'id':id},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg)
		}
	})
})
$('.ex_colse').click(function(){
	$('.modal-backdrop,.eject_body').hide();
})
//关闭弹出
$('.bootbox-close-button').click(function(){
	$('.modal-backdrop,.bootbox').hide();
})
//提交表单
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
	$.post("/admin/a/search_condition/get_json_data" ,$("#search_condition").serialize(),function(data) {
		var data = eval('('+data+')');
		$('.pagination_data').html('');
		var html = '';
		$.each(data.list ,function(key ,val) {
			if (typeof val.description == 'object') {
				var description = '';
			} else {
				var description = val.description;
			}
			if (typeof val.code == 'object') {
				var code = '';
			} else {
				var code = val.code;
			}
			if (typeof val.top_name == 'object') {
				var top_name = '';
			} else {
				var top_name = val.top_name;
			}
			html += '<tr>';
			html += '<td class="td_center">'+val.minvalue+'</td>';
			html += '<td class="td_center">'+val.maxvalue+'</td>';
			html += '<td>'+description+'</td>';
			html += '<td>'+top_name+'</td>';
			html += '<td>'+code+'</td>';
			html += '<td class="td_center">'+val.showorder+'</td>';
			html += '<td><a href="javascript:void(0);" onclick="edit('+val.id+')" class="btn btn-info btn-xs"> 编辑</a>&nbsp;&nbsp;';
			html += '<a href="javascript:void(0);" onclick="del('+val.id+')" class="btn btn-danger btn-xs"> 删除</a></td>';
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


