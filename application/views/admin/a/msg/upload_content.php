<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
    <style>
    .fg-input .inputRadio{ width: 16px !important;display: inline-block; position: relative; top: 8px;}
    .form-right{ text-align:right;}
	.form-horizontal .form-group .fg-but{ float:none}
   .fg-input label{cursor:pointer;  margin-right: 20px;}
   
    </style>
</head>
<body>
	<div class="fb-content">
	    <div class="fb-form">
	        <form method="post" action="#" id="add-form" class="form-horizontal">
	            <div class="form-group">
	                <div class="fg-title">url：</div>
	                <div class="fg-input"><input type="text" name="url" value="<?php if(!empty($url)){echo $url;}?>"></div>
	            </div>
	 			<div class="form-group">
	                <div class="fg-title">完成标志：<i>*</i></div>
	                <div class="fg-input">
	                	<?php if (empty($type)):?>
	                	<label><input type="radio" name="type" value="1" class="inputRadio">点击链接完成</label>
	                	<label><input type="radio" name="type" value="2" class="inputRadio">操作审核后完成</label>
	                	<label><input type="radio" name="type" value="3" class="inputRadio">点击信息后完成</label>
	                	<?php else:?>
	                	<label><input type="radio" name="type" value="1" <?php if($type ==1){echo 'checked="checked"';}?> class="inputRadio">点击链接完成</label>
	                	<label><input type="radio" name="type" value="2" <?php if($type ==2){echo 'checked="checked"';}?> class="inputRadio">操作审核后完成</label>
	                	<label><input type="radio" name="type" value="3" <?php if($type ==3){echo 'checked="checked"';}?> class="inputRadio">点击信息后完成</label>
	                	<?php endif;?>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">是否启用：<i>*</i></div>
	                <div class="fg-input">
	                	<?php if(empty($isopen)):?>
	                	<label><input type="radio" name="isopen" value="0" class="inputRadio">否</label>
	                	<label><input type="radio" name="isopen" value="1" checked="checked" class="inputRadio">是</label>
	                	<?php else:?>
	                	<label><input type="radio" name="isopen" value="0" <?php if($isopen ==0){echo 'checked="checked"';}?> class="inputRadio">否</label>
	                	<label><input type="radio" name="isopen" value="1" <?php if($isopen ==1){echo 'checked="checked"';}?> class="inputRadio">是</label>
	                	<?php endif;?>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">消息内容：<i>*</i></div>
	                <div class="fg-input"><textarea name="content"><?php if(!empty($content)){echo $content;}?></textarea></div>
	            </div>
	            <div class="form-group form-right">
	                <input type="hidden" name="id" value="<?php if(!empty($id)){echo $id;}?>">
	                <input type="submit" class="fg-but" value="确定">
	                <input type="button" class="fg-but layui-layer-close" value="取消">
	            </div>
	            <div class="clear"></div>
	        </form>
	    </div>
	</div>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
$('#add-form').submit(function(){
	$.ajax({
		url:'/admin/a/msg/content/upload',
		data:$(this).serialize(),
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
				parent.$("#main")[0].contentWindow.window.location.reload();
				parent.layer.close(index);
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

$('.layui-layer-close').click(function(){
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	parent.layer.close(index);
})

</script>
</html>


