/**
	@author hejun
	客服系统
	客服列表
*/
	
	
	//获取当前url参数
	function GetQueryString(name) {
	   var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
	   var r = window.location.search.substr(1).match(reg);
	   if (r!=null) return (r[2]); return null;
	}
	//定时更新消息
	function refresh (){
		var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		var action=GetQueryString('action');
		var update_url='/kefu_list/mess_list';
		$.ajax({
		url:update_url,
		type:'GET',
		data:{member_id:member_id,expert_id:expert_id,action:action},
		dataType:'jsonp',
		success:function(data){
			if(2000==data['code']){
			var messageData= data["data"];
			console.log(messageData);
			for(var i=0;i<messageData.length;i++){
				addList(messageData[i],i);
				}
			}
		}
		});
		//messageRunHandler=setTimeout(refresh ,1000);
	}	
	//更新消息列表
	function addList(messageData,index){
		var contextHead="<li class=\"kf chatitem\">";
		var user="<span class=\"user_name\">"+messageData['group_id']+'&nbsp;&nbsp;['+messageData['addtime']+"]</span>";
		var content="<div class=\"chatinfo\">"+messageData['content']+"</div>";
		contextFoot="</div></li>";
		context=contextHead+user+content+contextFoot;
		$('#chatlist').append(context);
	}
	
	//停止对话
	function stopmessage(){
		clearTimeout();
		var contextHead="<li class=\"chatitem system_msg\">";
		var content="<button type=\"button\" class=\"showbtn\"><span>谢谢您的理解与支持。如果您还有其他问题，请再次打开聊天</span></button>";
		var contextFoot="</li>";
		context=contextHead+content+contextFoot;
		$('#chatlist').append(context);
	}
	
	//清除消息列表
	function clearList(){
		$('#chatlist').empty();
	}
	
	function ResetSize(){		
		self.resizeTo(320,500);	
	}
	window.onload=function(){
		//设置窗口大小
		ResetSize();
		//刷新数据
		refresh ();
	}
