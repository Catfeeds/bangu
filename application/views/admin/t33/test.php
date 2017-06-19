<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>测试</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<style type="text/css">
.main div{ margin:10px 20px;}
.btn button { padding:5px;cursor:pointer;}

p{margin-bottom:10px;}
button,input{border:1px solid #999; padding:5px 10px; margin:0 10px 10px 0;}
button{ cursor:pointer;}
</style>
</head>
<body>

<div class="main" style="width:100%;height:800px;margin:100px 200px;">
	<p><strong><label>银行卡名称识别：</label></strong><input id="name" onblur="getBankName(this);"></p>
	<!--<div class="content">
    	这是一个新的页面，您可以通过父窗口得到这里的DOM(点击右上角关闭按钮试试)，从而操作这里的一切。也可以在这里操作父窗口。
    </div>
    <div class="btn">
        <button id="add">让层自适应iframe</button>
        <button id="new">在父层弹出一个层</button>
        <button id="transmit">给父页面传值</button>
        <button id="closeIframe">关闭iframe</button>
    </div> -->
</div>


</body>
<script type="text/javascript">
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	//alert(window.name);
	//console.log(index);
	//让层自适应iframe
	$('#add').on('click', function(){
		$('.content').append('插入很多酱油。插入很多酱油。插入很多酱油。插入很多酱油。插入很多酱油。插入很多酱油。插入很多酱油。');
		parent.layer.iframeAuto(index);
	});
		
	//在父层弹出一个层
	$('#new').on('click', function(){
		parent.layer.msg('Hi, man', {shade: 0.3})
	});
	
	//给父页面传值
	$('#transmit').on('click', function(){
		parent.$('.home_link a').text('我被改变了');
		parent.layer.tips('Look here', '#parentIframe', {time: 5000});
		parent.layer.close(index);
	});
	
	//关闭iframe
	$('#closeIframe').click(function(){
		var val = $('#name').val();
		/*if(val === ''){
			parent.layer.msg('请填写标记');
			return;
		}*/
		var data = ['哈哈大文化','19','达瓦达瓦'];
		parent.$('#val_box').text(data);
		parent.$("#main")[0].contentWindow.getValue(); //用jquery调用需要加一个[0]
		//window.top.passData();
		
		//parent.layer.msg('您将标记 [ ' +val + ' ] 成功传送给了父窗口');
		parent.layer.close(index);
	});
	function getBankName(obj){
		var bankCard = $(obj).val();
		if (bankCard == null || bankCard == "") {
			return "";
		}
		$.getJSON("<?php echo base_url();?>assets/ht/js/bankData.json", {}, function (data) {
			var bankBin = 0;
			var isFind = false;
			for (var key = 10; key >= 2; key--) {
				bankBin = bankCard.substring(0, key);
				$.each(data, function (i, item) {
					if (item.bin == bankBin) {
						isFind = true;
						console.log(item.bankName.split("-"));
						var data = item.bankName.split("-");
						alert(data[0]);
						//return item.bankName;
						
					}
				});

				if (isFind) {
					break;
				}
			}

			if (!isFind) {
				alert("未知发卡银行");
				//return "未知发卡银行";
			}
		});
	}
</script>
</html>
