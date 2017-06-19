<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>聊天</title>
<style>
	*{
		margin:0px;
		padding:0px;
	}
	li{list-style-type: none;}
	.main{
		width: 500px;
	    border: 1px solid #ccc;
	    margin: 100px auto;
	    padding: 20px;
	}
	.content{
		height: 500px;
		overflow: hidden;
	}
	.content li{
		height: 25px;
		line-height: 25px;
	}
	.chat-write .write-content{
		width: 70%;
		height: 32px;
		border: 1px solid #ccc;
		border-radius: 5px;
		padding-left: 10px;
	}
	.chat-write .send-out{
		height: 33px;
		padding: 0px 5px;
		background: #2DC3E8;
		border: 1px solid #ccc;
		border-radius: 3px;
		color: #fff;
		cursor: pointer;
	}
	.username{margin-right:10px;}
</style>
</head>
<body>
	<div class="main">
		<div class="content">
			<ul>
				
			</ul>	
		</div>
		<div class="chat-write">
			<form method="post" id="send-ou-content">
				<input type="text" class="write-content" name="content">
				<input type="submit" value="发送" class="send-out">
			</form>
		</div>
	</div>
<script src="<?php echo base_url() ;?>assets/js/jquery-1.11.1.min.js"></script>
<script>
	$("#send-ou-content").submit(function(){
		if ($('.write-content').val().length < 1) {
			return false;
		}
		$.ajax({
			url:'/api/v2_3_2/z/insertChat',
			data:{'content':$('.write-content').val(),room_id:1,user_id:3,room_code:123456,nickname:'小小鸟',anchor_id:1},
			dataType:'json',
			type:'post',
			success:function(data) {
				if (data.code == 2000) {
					$('.write-content').val('');
				} else {
					alert('发送失败');
				}
			}
		});
		return false;
	})
	getNews();
	function getNews(){
		$.ajax({
				url:'/api/v2_3_2/getChat/getLiveChat',
				dataType:'json',
				type:'post',
				data:{room_id:1,room_code:123456},
				success:function(data) {
					if (data.code == 2000) {
						$('.write-content').val('');
						var msgArr = data.data.rows;
						if (msgArr['type'] == 1) {
							
							//普通聊天内容
							$('.content').find('ul').append('<li><span class="username">' +msgArr['nickname']+':</span>'+msgArr['content']+'</li>');
						} else {
							//礼物
							$('.content').find('ul').append('<li><span class="username">'+msgArr['nickname']+':</span>&nbsp;&nbsp;赠送给主播'+msgArr['number']+msgArr['unit']+msgArr['gift_name']+'<img src="'+msgArr['pic']+'" style="width: 30px;">X'+msgArr['number']+'</li>');
						}
						
						getNews();
					} else {
						alert(data.msg);
					}
					
				}
			});
	}
</script>
</body>
</html>