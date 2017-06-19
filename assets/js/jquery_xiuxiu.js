function change_avatar(){
		$('.avatar_box').show();
		
	   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
		xiuxiu.embedSWF("altContent",5,'100%','100%');
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('admin/upload/c_upload_file'); ?>");
	        xiuxiu.setUploadType(2);
	        xiuxiu.setUploadDataFieldName("upload_file");
		xiuxiu.onInit = function ()
		{
			//默认图片
			xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
		}
		xiuxiu.onUploadResponse = function (data)
		{
			data = eval('('+data+')');
			if (data.status == 1) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		}
		 $("#img_upload").show();
		 $(".close_xiu").show();
}
$(document).mouseup(function(e) {
    var _con = $('#img_upload'); // 设置目标区域
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $("#img_upload").hide()
        $('.avatar_box').hide();
        $(".close_xiu").hide();
    }
})
function close_xiuxiu(){
	$("#img_upload").hide()
    $('.avatar_box').hide();	
	$(".close_xiu").hide();
}
