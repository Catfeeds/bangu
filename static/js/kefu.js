/**
	@author hejun
	客服系统
*/
	
	
	//获取当前url参数
	function GetQueryString(name) {
	   var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
	   var r = window.location.search.substr(1).match(reg);
	   if (r!=null) return (r[2]); return null;
	}
	
	//点击列表操作
	$("#kefu_list").on('click','li',function(evt){
			$("#kefu_list li").removeClass("kefu_on");
			//$(this).addClass("kefu_on");
        evt.preventDefault(); // 阻止默认的跳转操作
        var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		var action=GetQueryString('action');
		var id=$(this).attr('data-id');
		var url="";
		if(action==1){
			member_id=id;
			url="/kefu?member_id="+member_id+"&expert_id="+expert_id+"&action="+action;
		}else if(action==0){
			expert_id=id;
			url="/kefu?member_id="+member_id+"&expert_id="+expert_id+"&action="+action;
		}
        document.title=null; // 分配新的页面标题
        if(history.pushState){
        var state=({
        	url: url, title: null
        });
        	window.history.pushState(state, null, url);
        	window.location.reload();
        }else{ 
            alert('浏览器版本不支持聊天，请更新高版本浏览器'); } // 如果不支持，使用旧的解决方案
	});
	
	
	//发送消息动作
	function send_message(){
		var send_url='/kefu/send';
		var content=document.getElementById("inarea");
		var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		var action=GetQueryString('action');
		var chatlist=$('#chatlist');
		if(content.value==""){
			alert('发送内容不能为空！');
		}else{
			$.get(send_url, { content: content.value,member_id:member_id,expert_id:expert_id,action:action},function(data){
				var jsonData = $.parseJSON(data);
				if(jsonData.code == '2000'){//成功
					document.getElementById("inarea").value="";	
					//console.log(jsonData);
					var contextHead="<div class=\"service_Chat_ri\">";
					var content="<img src=' "+jsonData.data['photo']+" '/><span><i></i>"+jsonData.data['content']+"</span>";
					var contextFoot="</div>";
					context=contextHead+content+contextFoot;
					chatlist.append(context);
					chatlist.scrollTop( chatlist[0].scrollHeight );
				}else{//发送失败
					alert('发送失败');
				} 
			});
		}	
	}
	//获取专家列表和用户列表
	function list_refresh(){
		var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		var action=GetQueryString('action');		
		var b2_list_url='/kefu_webservices/get_message_list?mid='+member_id+'&eid='+expert_id+'&action='+action;
		$.ajax({
			url:b2_list_url,
			type:'GET',
			data:{mid:member_id,eid:expert_id,action:action},
			dataType:'jsonp',
			success:function(data){
				//console.log(data);
				if(2000==data['code']){				
					var b2_listData= data["data"];
					var temp="";
					console.log(b2_listData);
					if(action==1){
						for(var i=0;i<b2_listData.length;i++){
							if(i==0){
								temp=temp+"<li class=\"kefu_on\" data-id='"+b2_listData[i]['member_id']+"'><img src='"+b2_listData[i]['photo']+"'><span>"+b2_listData[i]['loginname']+"</span></li>";
							}else{
								temp=temp+"<li data-id='"+b2_listData[i]['member_id']+"'><img src='"+b2_listData[i]['photo']+"'><span>"+b2_listData[i]['loginname']+"</span></li>";
							}
						}
					}else if(action==0){
						for(var i=0;i<b2_listData.length;i++){
							if(i==0){
								temp=temp+"<li class=\"kefu_on\" data-id='"+b2_listData[i]['expert_id']+"'><img src='"+b2_listData[i]['photo']+"'><span>"+b2_listData[i]['loginname']+"</span></li>";
							}else{
								temp=temp+"<li data-id='"+b2_listData[i]['expert_id']+"'><img src='"+b2_listData[i]['photo']+"'><span>"+b2_listData[i]['loginname']+"</span></li>";
							}
						}
					}				
					$('#kefu_list').html(temp);
					if(action==1){
						$('#kefu_list').find('li[data-id="'+member_id+'"]') .addClass("kefu_on").siblings().removeClass("kefu_on");
					}else if(action==0){
						$('#kefu_list').find('li[data-id="'+expert_id+'"]') .addClass("kefu_on").siblings().removeClass("kefu_on");
					}					
				}
			}
		});
	}
	
	//定时更新消息
	function refresh (){
		var member_id=GetQueryString('member_id');
		var expert_id=GetQueryString('expert_id');
		var action=GetQueryString('action');
		var update_url='/kefu/receive';
		$.ajax({
		url:update_url,
		type:'GET',
		data:{member_id:member_id,expert_id:expert_id,action:action},
		dataType:'jsonp',
		success:function(data){
			if(2000==data['code']){				
				var messageData= data["data"];			
				for(var i=0;i<messageData.length;i++){
				addList(messageData[i],i);
				}
			}
		}
		});
		messageRunHandler=setTimeout(refresh ,2000);
	}	
	//更新消息列表
	function addList(messageData,index){
		var contextHead="<div class=\"service_Chat_le\">";
		var user="<img src=' "+messageData['photo']+" ' /><span><i></i>"+messageData['content']+"</span>";
		var contextFoot="</div>";
		var context=contextHead+user+contextFoot;
		var chatlist=$('#chatlist');
		chatlist.append(context);
		chatlist.scrollTop( chatlist[0].scrollHeight );
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
	
	//清除消息列表
	function clearList(){
		$('#chatlist').empty();
	}
	
	//绑定发送消息按钮
	document.getElementById("submit_btn").onclick=function(){
		send_message();
	}
	
	function ResetSize(){		
			
	}
	//获取当前时间
	function CurentTime()
    { 
        var now = new Date();        
        var year = now.getFullYear();       //年
        var month = now.getMonth() + 1;     //月
        var day = now.getDate();            //日        
        var hh = now.getHours();            //时
        var mm = now.getMinutes();          //分
        var ss = now.getSeconds();           //秒        
        var clock = year + "-";        
        if(month < 10)
            clock += "0";        
        clock += month + "-";        
        if(day < 10)
            clock += "0";            
        clock += day + " ";        
        if(hh < 10)
            clock += "0";            
        clock += hh + ":";
        if (mm < 10) clock += '0'; 
        clock += mm + ":";          
        if (ss < 10) clock += '0'; 
        clock += ss; 
        return(clock); 
    }
	function enterOnclick(e){
		var currKey=0,e=e||event;
		currKey=e.keyCode||e.which||e.charCode;
		if(currKey==13){
			send_message();
		}
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
	function time_start(){
		alert('您已经很长时间没有发送信息了,再过30秒,系统将会自动关闭窗口');
		$(".likai_box").show();
		t=setTimeout('window.close();', 30000);
	}
	function init(){
		var action=GetQueryString('action');
		if(action==1){
			var mid=GetQueryString('member_id');
			if(mid==""){				
				console.log('访客用户');				
				$('#card_click').text('会员名片');
				$('.service_playinter_name').text("访客咨询您");
				$('.tab_card_mation li').eq(0).hide();
				$('.tab_card_mation li').eq(1).hide();
				$('.tab_card_mation li').eq(2).hide();
				$('#card img').attr("src","/static/img/kefu_photo.png");
				$('div.tab_card_Stars ul li').hide();
			}else if(mid==null){
				$('#card_click').text('会员名片');				
				console.log('b2列表页');
			}else if(!isNaN(mid)){
				var get_c_data_url="/kefu_webservices/get_c_data";
				$.ajax({
					url:get_c_data_url,
					type:'GET',
					data:{mid:mid},
					dataType:'json',
					success:function(data){
						//console.log(data);
						$('#card_click').text('会员名片');
						$('.service_playinter_name').text(" "+data[0]['loginname']+"咨询您");
						$('.tab_card_mation li').eq(0).text("姓名:"+data[0]['loginname']);
						$('.tab_card_mation li').eq(1).hide();
						$('.tab_card_mation li').eq(2).hide();
						$('#card img').attr("src",data[0]['photo']);
						$('div.tab_card_Stars ul li').hide();
					}
				});
			}
		}else{
			if(action==0){		
				var get_b2_data_url="/kefu_webservices/get_b2_data";
				var eid=GetQueryString('expert_id');				
				$.ajax({
					url:get_b2_data_url,
					type:'GET',
					data:{eid:eid},
					dataType:'json',
					success:function(data){
						//console.log(data);
						$('.service_playinter_name').text("管家 "+data[0]['loginname']+"为您服务");
						$('.tab_card_mation li').eq(0).text("管家:"+data[0]['loginname']);
						$('.tab_card_mation li').eq(1).text(""+data[0]['sex']?'性别:男':'性别:女');
						$('.tab_card_mation li').eq(2).text("级别:"+data[0]['title']);
						$('#card img').attr("src",data[0]['photo']);
						$('div.tab_card_Stars ul li').eq(0).text("好评率:"+(data[0]['service_score']=="null")?"好评率:暂无统计":"好评率:"+data[0]['service_score']);
						$('div.tab_card_Stars ul li').eq(1).text("服务评分:"+(data[0]['service_score']=="null")?"服务评分:暂无统计":"服务评分:"+data[0]['service_score']);					
						$('div.tab_card_Stars ul li').eq(2).text("专业评分:"+(data[0]['profession_score']=="null")?"专业评分:暂无统计":"专业评分:"+data[0]['profession_score']);
						if(data[0]['online']==0){
							$('.service_playinter_name').text("管家"+data[0]['loginname']+"不在线 ,您可以通过手机号:'"+data[0]['mobile']+"'联系该管家。");
							$('#inarea').attr('disabled','disabled');
							$('#submit_btn').attr('disabled','disabled');
						}
						
					}
				});
			}
		}		
	}
	window.onload=function(){
		//初始化
		init();
		//刷新数据
		refresh ();
		//列表刷新
		list_refresh();
		//enter发送
		document.onkeydown=enterOnclick;
		document.addEventListener('visibilitychange', function() {
			  document.hidden ? t=setTimeout('time_start()', 300000):clearTimeout(t) ;
		});		
		$(".User_History").click(function(){
			var mid=GetQueryString('member_id');
			if(mid==""){
				alert('访客用户暂不提供查看历史记录');
			}else{
				$(".History_Eject").show();
				get_history();
				total();
			}
		});		
		$(".History_Eject_hide").click(function(){
			$(".History_Eject").hide();
		});	
		
	}