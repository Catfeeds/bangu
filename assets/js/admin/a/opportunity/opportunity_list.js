/**
 * @method 培训公告js
 */
// 添加培训公告的弹出层
function popLayer() {
	$('.bootbox').show();
	$('.modal-backdrop,.opp_srelease').show();
	$('.opp_eidt').css('display','none');
	$("#form_data_submit").find('input,textarea').val('');
	$('.input_cx_data').css({'width':'270px','height':'35px'});
};
// 添加培训公告，提交表单
function submit_opp(is) {
	//$("#form_data_submit").find('input,textarea').trigger('blur');
	$('input[name="is"]').val(is)
//	if ($("#form_data_submit").find('input,textarea').hasClass('error')) {
//		alert("请填写完整");
//		return false;
//	}
	$.post("/admin/a/opportunity/add_opportunity",$('#form_data_submit').serialize(),function(data) {
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
	return false;
}
//编辑弹出
function show_details(id) {
	$.post("/admin/a/opportunity/get_one_json",{'id':id},function(data) {
		if (data == false) {
			alert('请确认您选择的数据');
			return false;
		}
		var data = eval('('+data+')');
		$('input[name="title"]').val(data.title);
		$('input[name="spend"]').val(data.spend);
		$('input[name="address"]').val(data.address);
		$('input[name="begintime"]').val(data.begintime);
		$('input[name="endtime"]').val(data.endtime);
		$('input[name="starttime"]').val(data.starttime);
		$('input[name="people"]').val(data.people);
		$('input[name="sponsor"]').val(data.sponsor);
		$('input[name="attachment"]').val(data.attachment);
		$('textarea[name="content"]').val(data.content);
		$('textarea[name="description"]').val(data.description);
		$('input[name="id"]').val(id);
		$('.opp_srelease').css('display','none');
		$('.bootbox').show();
		$('.modal-backdrop,.opp_eidt').show();
		
	})
}

// 上传附件
$('#upload_file').on('click', function() {  
	$.ajaxFileUpload({  
		url:'/admin/upload/up_file',  
		secureuri:false,  
		fileElementId:'upfile',// file标签的id
		dataType: 'json',// 返回数据的类型
		data:{filename:'upfile'},
		success: function (data, status) {  
			if (data.code == 2000) {
				$('input[name="attachment"]').val(data.msg);
				alert("上传成功");
			} else {
			 	alert(data.msg);
			}
		},  
		error: function (data, status, e) {  
		 	alert("请选择不超过10M的doc|txt|xls|docx的文件上传");  
		}  
	});  
 	return false;
});
//培训公告详情
function details(id) {
	$.post("/admin/a/opportunity/get_one_json",{'id':id},function(data) {
		if (data == false) {
			alert("请确认您选择的数据是否正确");
			return false;
		}
		var data = eval('('+data+')');
		$('.eject_botton').find('div').show();
		if (data.status == 0) {
			$('.opp_cancel').css('display','none');
		} else if (data.status == 1) {
			$('.opp_release').css('display','none');
			$('.opp_delete').css('display','none');
		} else if (data.status == 2) {
			$('.opp_release').css('display','none');
			$('.opp_cancel').css('display','none');
		}
		
		$('.opp_sponsor').html(data.sponsor);
		$('.opp_title').html(data.title);
		$('.opp_people').html(data.people);
		$('.opp_apply').html(data.apply_count);
		$('.opp_status').html(data.sname);
		$('.opp_address').html(data.address);
		$('.opp_starttime').html(data.starttime);
		$('.opp_endtime').html(data.endtime);
		$('.opp_publisher_type').html(data.publisher_type);
		$('.opp_publisher_name').html(data.publisher_name);
		$('.opp_content').html(data.content);
		$('.opp_description').html(data.description);
		$('input[name="id"]').val(data.id);
		$('.opp_addtime').html(data.begintime);
		$('.opp_spend').html(data.spend+'分钟');
		
		$('.eject_body').show();
		$('.modal-backdrop').show();
	})
	
}
//关闭详情
$('.opp_colse').click(function(){
	$('.eject_body').hide();
	$('.modal-backdrop').hide();
})
//删除公告
$('.opp_delete').click(function(){
	var id = $('input[name="id"]').val();
	$.post("/admin/a/opportunity/status_change",{'id':id,'is':3},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
})
//取消公告
$('.opp_cancel').click(function(){
	var id = $('input[name="id"]').val();
	$.post("/admin/a/opportunity/status_change",{'id':id,'is':2},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
})
//发布公告
$('.opp_release').click(function(){
	var id = $('input[name="id"]').val();
	$.post("/admin/a/opportunity/status_change",{'id':id,'is':1},function(data){
		var data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	});
})


// 分页
$('.ajax_page').click(function() {
	var page_new = $(this).find('a').attr('page_new');
	get_ajax_data(page_new);
})
$('#form_opportunity').submit(function(){
	get_ajax_data(1);
	return false;
})

// ajax获取数据
function get_ajax_data(page_new) {
	var status = $('select[name="status"] :selected').val();
	var title = $('input[name="title"]').val();
	$.post(
		"/admin/a/opportunity/opportunity_list",
		{'page_new':page_new,'is':1,'title':title,'status':status},
		function(data) {
			data = eval('('+data+')');	
			$('.body_list').html('');
			// 遍历数据
			$.each(data.list ,function(key ,val) {
				button_str = '<a href="javascript:void(0);" onclick="details('+val.id+')" class="btn btn-info btn-xs edit">查看</a>';
				var str = '<tr class="odd">';
				str += '<td style="width:20%; text-align:left;">'+val.title+'</td>';
				str += '<td style="width:20%;">'+val.address+'</td>';
				str += '<td>'+val.begintime+'</td>';
				str += '<td>'+val.endtime+'</td>';
				str += '<td style="width:15%;">'+val.sponsor+'</td>';
				str += '<td  class="td_center">'+status+'</td>';
				str += '<td  class="td_center">'+val.people+'</td>';
				str += '<td>'+button_str+'</td>';
				str += '</tr>';
				$('.body_list').append(str);
			})
			
			$('.pagination').html(data.page_string);
			$('.ajax_page').click(function() {
				var page_new = $(this).find('a').attr('page_new');
				get_ajax_data(page_new);
			})
		}
	);
}
var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:'11:00'
		});
	}else
		this.setOptions({
			minTime:'8:00'
		});
};
$('#opp_begintime').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$('#opp_starttime').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$('#opp_endtime').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});