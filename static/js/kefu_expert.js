/**
	@author 旷明爱
	客服系统,
*/
	//获取当前url参数
	function GetQueryString(name) {
	   var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
	   var r = window.location.search.substr(1).match(reg);
	   if (r!=null) return (r[2]); return null;
	}
	
	
	//停止对话
	function stopmessage(){
		clearTimeout();
		var contextHead="";
		var content="<button type=\"button\" class=\"showbtn\"><span>谢谢您的理解与支持。如果您还有其他问题，请再次打开聊天</span></button>";
		var contextFoot="";
		context=contextHead+content+contextFoot;
		$('#chatlist').append(context);
	}
	///////////////////////////////////////////////
	///////////////////////////////////////////////
	//历史记录
	function get_history(page){
		var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		if(member_id==""){
			
		}
		var history_url='/kefu_webservices/get_all_message';		
		$.ajax({
			url:history_url,
			type:'GET',
			data:{mid:member_id,eid:expert_id,page:page},
			dataType:'jsonp',
			success:function(data){
				if(2000==data['code']){
				$('#history').empty();
				var historyData= data["data"];
				for(var i=0;i<historyData.length;i++){
					addHistoryList(historyData[i],i);
					}
				}
			}
		});
	}
	
	//增加历史记录列表
	function addHistoryList(historyData,index){		
		var contextHead="<li><div class=\"History_Eject_le color_gr\">";
		var user="<span>"+historyData['loginname']+"</span><i>"+historyData['addtime']+"</i></div><div class=\"History_Eject_conment fl\">"+historyData['content']+"";
		var contextFoot="</div></li>";
		var context=contextHead+user+contextFoot;
		$('#history').append(context);
	}
	  
	
	 
	function total(){		
		var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		var total_url="/kefu_webservices/get_total_message";
		$.ajax({
			url:total_url,
			type:'GET',
			data:{mid:member_id,eid:expert_id},
			dataType:'jsonp',
			success:function(data){
				if(2000==data['code']){	 
					$("#fenye").show();
					var totalData=data['total'];					
					if(totalData>=2){
						var options= "<option value =\"-1\">请选择页数</option>";
						for(var j=0;j<totalData;j++){
							var num=j+1;
							options=options+"<option value="+num+">"+num+"</option>";
						} 
						$('#fenye').html(options);
					}else{
						$("#fenye").hide();
					}
				}
			}
		});
	}	
	$("#fenye").change(function(){
		var page=$("#fenye").find("option:selected").text();
		get_history(page);
	});
	/////////////////////////////////
	/////////////////////////////////
	/////////////////////////////////
	/////////////////////////////////
	/////////////////////////////////
	 
	
	