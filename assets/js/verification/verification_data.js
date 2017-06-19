//(function($) {
	//验证整数(非必填)
	$('.positive_int').focus(function(){
		$(this).css({'border':'1px solid #D5D5D5'}).removeClass('error');
	}).blur(function(){
		//验证规则
		var preg_int = /^[0-9]{1,5}$/;
		var positive_int = $(this).val();
		if (positive_int.length > 0) {
			if (!preg_int.test(positive_int)) {
				$(this).css({'border':'1px solid red'}).addClass('error');
			} else {
				$(this).css({'border':'1px solid #D5D5D5'}).removeClass('error');
			}
		}
	})
	//验证整数(必填)
	$('.positive_int_required').focus(function(){
		$(this).css({'border':'1px solid #D5D5D5'}).removeClass('error');
	}).blur(function(){
		//验证规则
		var preg_int = /^[0-9]{1,5}$/;
		var positive_int = $(this).val();
		if (!preg_int.test(positive_int)) {
			$(this).css({'border':'1px solid red'}).addClass('error');
		} else {
			$(this).css({'border':'1px solid #D5D5D5'}).removeClass('error');
		}
	})
	//验证正整数(大于0)(必填)
	$('.pi_required').focus(function(){
		$(this).css({'border':'1px solid #D5D5D5'}).removeClass('error');
	}).blur(function(){
		var preg_int = /^[0-9]{1,8}$/;
		var positive_int = $(this).val();
		if (positive_int == 0) {
			$(this).css({'border':'1px solid red'}).addClass('error');
			return false;
		}
		if (!preg_int.test(positive_int)) {
			$(this).css({'border':'1px solid red'}).addClass('error');
		} else {
			$(this).css({'border':'1px solid #D5D5D5'}).removeClass('error');
		}
	})
	
	
	//关闭弹出框
	$('.bootbox-close-button').click(function(){
		//关闭同时将input控件的边框颜色变回去
		$('input').css('border','1px solid #D5D5D5');
		$('.bootbox').hide();
		$('.modal-backdrop').hide();
	})
	
	
	/**
	 * @method ajax上传文件(文件上传地址统一使用一个)
	 * @param file_id file控件的ID同时也是file控件的name值
	 * @param name 上传返回的图片路径写入的input的name值
	 * @param prefix 图片保存的前缀
	 */
	function ajax_upload_file(file_id ,name ,prefix) {
		$.ajaxFileUpload({
		      url:'/admin/upload/ajax_upload_file',
		      secureuri:false,
		      fileElementId:file_id,//file标签的id
		      dataType: 'json',//返回数据的类型
		      data:{filename:file_id,prefix:prefix},
		      success: function (data, status) {
			      if (data.code == 2000) {
			          $('#'+file_id).next('.upload_pic').remove();
					  $('#'+file_id).after("<img class='upload_pic' src='"+data.msg+"' width='80' height='80'>");
					  $('input[name="'+name+'"]').val(data.msg);
				  } else {
					  alert(data.msg);
				  }
			  },
			  error: function (data, status, e)//服务器响应失败处理函数
	          {
	              alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
	          }
		});
	}
/*******************ajax分页开始***************************/	
//	$('.ajax_page').click(function() {
//		if ($(this).hasClass('active')) { //点击当前页，不执行下面的
//			return false;
//		}
//		var page_new = $(this).find('a').attr('page_new');
//		get_ajax_page(page_new);
//	})
//	//条件搜索
//	$('#sf_condition').submit(function() {
//		get_ajax_page(1);
//		return false;
//	})
//	/**
//	* @method ajax分页
//	* @param {intval} page_new 第几页
//	*/
//	function get_ajax_page(page_new) {
//		$('input[name="page_new"]').val(page_new);
//		$.post(
//			page_url,
//			$('#sf_condition').serialize(),
//			function(data) {
//				var data = eval('('+data+')');
//				$('.body_data').html('');
//				$.each(data.list ,function(kay ,val) {
//					var string = "<tr>";
//						string += "<td>"+val.type+"</td>";
//						string += "<td title='"+val.username+"'>"+val.sub_username+"</td>";
//						string += "<td title='"+val.name+"'>"+val.sub_name+"</td>";
//						string += "<td>"+val.starttime+"</td>";
//						string += "<td>"+val.endtime+"</td>";
//						
//						string += "<td>"+val.number+"</td>";
//						string += "<td>"+val.use_range_name+"</td>";
//						string += "<td>"+val.min_price+"</td>";
//						string += "<td>"+val.coupon_price+"</td>";
//						if (val.status == 1) {
//							string += "<td><a href='javascript:void(0)' onclick='edit("+val.id+")' class='btn btn-default btn-xs purple'><i class='fa fa-edit'></i>修改</a>";
//						}
//						$('.body_data').append(string);
//				})
//				$('.pagination').html(data.page_string);
//	
//				$('.ajax_page').click(function() {
//					if ($(this).hasClass('active')) { //点击当前页，不执行下面的
//						return false;
//					}
//					var page_new = $(this).find('a').attr('page_new');
//					get_ajax_page(page_new);
//				})
//			}
//		);
//	}

	
/*******************ajax分页结束***************************/	
	
//})(jQuery);