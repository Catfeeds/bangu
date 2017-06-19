  //用户的提示消息
function getNewMsg(chatDomain){
	// http://chat.1b1u.com:8080  这个地址需要从后天读取
	var send_url=chatDomain+"/chat!getMsgCount.do" ;
	var c_userid = "";	
	$.ajax({
		url : send_url,
		dataType:"jsonp",
		type : 'POST',
		data : {
			'mid' : c_userid,
			'action':0
		},
		success : function(jsonData) {
			if (jsonData.code == '2000') {//成功
				if(jsonData.data >0){//有新消息
					//显示泡泡
					$(".chat_ico").show();
				}else{
					//隐藏泡泡
					 $(".chat_ico").hide();
				}
			} else {
				//alert('获取消息失败');
			}
		}
	});
}