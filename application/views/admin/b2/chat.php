<!DOCTYPE html>
<html>
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	  <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
      <title>聊天窗口</title>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/kefu.css" />
      <script src="<?php echo base_url(); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
      <style type="text/css">     
      .chat_arrow{ 
          -webkit-border-radius:10px;  
          -moz-border-radius:10px;  
          border-radius:10px;
      }
      .chat_arrow:before{  
            position:absolute;  
		    content:"\00a0";  
		    width:0px;  
		    height:0px;  
		    border-width:8px 8px 8px 0;  
		    border-style:solid;  
		    border-color:transparent #e4e3e3 transparent transparent;  
		    top:15px;  
		    left:-8px;  
      }
      .right_arrow:before{ 
            position:absolute;  
		    content:"\00a0";  
		    display:inline-block;  
		    width:0px;  
		    height:0px;  
		    border-width:8px 0px 8px 8px;  
		    border-style:solid;  
		    border-color:transparent transparent transparent #9ccf31;  
		    right:-8px;  
		    top:15px;  
      }
      /* jquery下拉框  */
      
	.sj_title ul{z-index:1000;left:75%;width:25%; background:#171717;  border:1px solid #a9c9e2; position:absolute; display:none;}
		.sj_title ul li{height:30px; line-height:30px; text-indent:5px;border-bottom:1px solid #fff;}
		.sj_title ul li a{display:block; height:30px; color:#fff; text-decoration:none;}
      </style>
</head>
<body>
	  <div class="sj_title">
	      <img src="../../image/common/return.png" onclick="javascript:window.history.go(-1);" style="float:left;margin-top:10px;margin-left:3%;" />
	                  帮游在线客服
	      <img src="images/list.png" style="float:right;width:20px;height:20px;margin-right:3%;margin-top:10px;" id="dropdown" />
	       <ul>
	         <li onclick="open_history(api.pageParam.mid)"><a>历史记录</a></li>
	     
	      </ul>
	  </div>
    <div class="sj_box">       
        <div class="cation_conment">
            <ul>
 
            </ul>
        </div>
               <form class="User_Use_btn">
               		<input name="input" type="text" class="User_input" />
               		<input value="发送" type="button" class="User_Send" onclick="send_message(Request['mid'])" />
               	
               </form>
      <!--      </div>     -->
<!-- 表情弹出-->
        <div class="biaoqing_eject">
        <ul>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
            <li><img src="images/1.gif"></li>
        </ul>
    </div>
    </div>
</body>
</html>
<script type="text/javascript">
 
 $(function(){ 
      var mid=Request['mid'];
      update(mid);
 });
 function update(mid){
      var id=localStorage.getItem('id');
      $.ajax({
			type:"GET",
			url:apiDomain+"kefu_webservices/get_message",
			data:{eid:id,mid:mid,action:1},
			dataType:"jsonp",
			success:function(data){
			 
				var item; 
				var item2;
				$.each(data.data,function(i,result){ 
					
					     item='<li class="bangu">'+
					          '<img src="'+apiDomain+result['photo']+'"/>'+
					          '<span class="chat_arrow">'+result['content']+'</span></li>';
					$('.cation_conment ul').append(item); 
					$('.cation_conment ul').scrollTop( $('.cation_conment ul')[0].scrollHeight );
					
				}); 
				setTimeout(update(mid),2000);
			},
			error:function(){
			      alert("数据加载失败");
			}
		});
    }
 /*  发送消息  */
 function send_message(mid){
       var id=localStorage.getItem('id');
	 
	   var content=$(".User_input").val();
      $.ajax({
			type:"GET",
			url:apiDomain+"kefu_webservices/send_message",
			data:{eid:id,mid:mid,action:1,content:content},
			dataType:"jsonp",
			success:function(data){	
			    
		        		 
				var item; 			 
			    if(data.code=='2000')
				     item='<li class="yonghu">'+
				          '<img src="'+apiDomain+data.data.photo+'"/>'+
				          '<span class="right_arrow">'+data.data.content+'</span></li>';			
					$('.cation_conment ul').append(item); 	
				 content="";
		        $(".User_input").val(content );	
		        $('.cation_conment ul').scrollTop( $('.cation_conment ul')[0].scrollHeight );
			},
			error:function(){
			      alert("数据加载失败");
			}
		}); 
 }
 function open_history(mid){
          $(".sj_title ul").slideUp("fast");
          window.location.href="history.html?mid="+mid;
      }
</script>
<script type="text/javascript">
$(function(){
	$("#dropdown").click(function(){
		var ul = $(".sj_title ul");
		if(ul.css("display")=="none"){
			ul.slideDown("fast");
		}else{
			ul.slideUp("fast");
		}
	});
});
</script>