<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <title>消息列表</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/kefu.css" />	
    <style type="text/css">
          header{
               height:50px;
               line-height: 50px;
               text-align: center;
               background-color:#f8f8f8;
               color:#000;
               
          }
          .news_list{
              border-bottom:1px solid #ccc;
              position:relative;
              font-size:14px;
          }
          .news_subtitle{
              color:#c9c9c9;
              position:absolute;
              bottom:5px;
          }
          .news_head_sculpture{
              width:36px;
              height:36px;
              padding:5px 15px;
          }
          .news_title{
              position:absolute;
              top:5px;         
          }
    </style>
</head>
<body>
      <header>
                       消息
      </header>
      <div id="newslist">
        
         
         
      </div>
</body>
</html>
<script type="text/javascript" src="../script/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="../script/common.js"></script>
<script type="text/javascript">
     $(function(){
	//	var key=localStorage.getItem('key');
	//	if(key==null || key==""){			
    //        	open_login();         
	//	}else{
			
	//	}  
	   open_news();
	});   
        function open_news(){           
		   var id=localStorage.getItem('id');		   
		   $.ajax({
					type:"GET",
					url:apiDomain+"kefu_webservices/get_message_list",
					data:{eid:id,action:1},
					dataType:"jsonp",
					success:function(data){	
					   
					    $('#newslist').html("");				  
						var item; 
						$.each(data.data,function(i,result){ 
							item = '<div class="news_list" onclick="open_chat('+result['member_id']+','+result['expert_id']+');">'+							
							'<img class="news_head_sculpture" src="'+apiDomain+result['photo']+'"/>'+
							'<span class="news_title">'+result['loginname']+'</span>'+
							'<span class="news_subtitle">'+result['lastcontent']+'</span>'+
							'</div>';							
							$('#newslist').append(item); 
						}); 
						setTimeout(open_news(),2000);
					},
					error:function(){
					      alert("数据加载失败");
					}
				});
        }
        
	function open_login(){
        window.location.href="my.html";
	}
      function open_chat(mid,eid){
          window.location.href="news/chat.html?mid"+mid+"&eid="+eid+"&action=1";
      }
</script>