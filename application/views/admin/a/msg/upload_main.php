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
	                <div class="fg-title">标题：<i>*</i></div>
	                <div class="fg-input"><input type="text" name="title" value="<?php if(!empty($title)){echo $title;}?>"></div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">编号：<i>*</i></div>
	                <div class="fg-input">
	                	<?php if (empty($code)):?>
	                	<input type="text" name="code" value="">
	                	<?php else:?>
	                	<input type="text" name="code" readonly="readonly" value="<?php echo $code;?>">
	                	<?php endif;?>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">业务类型：<i>*</i></div>
	                <div class="fg-input">
	                	<?php 
	                		$typeArr = array(
	                				1 =>'下订单',
	                				2 =>'额度申请',
	                				3 =>'交款系列',
	                				4 =>'付款系列',
	                				5 =>'改应收',
	                				6 =>'改应付(销售发起)',
	                				7 =>'改应付(供应商发起)',
	                				8 =>'改外交佣金',
	                				9 =>'改平台佣金',
	                				10 =>'退款系列',
	                				11 =>'新增参团人',
	                				12 =>'认款系列',
	                				13 =>'线路审核'
	                		);
	                		if(empty($type)):
	                	?>
	                	<select name="type">
	                		<option value="0">请选择</option>
	                		<?php foreach($typeArr as $k=>$v):?>
	                		
	                		<option value="<?php echo $k?>"><?php echo $v?></option>
	                		<?php endforeach;?>
	                	</select>
	                	<?php else:?>
	                	<input type="hidden" name="type" value="<?php echo $type?>">
	                	<input type="text" name="type_name" readonly="readonly" value="<?php if (array_key_exists($type, $typeArr)){echo $typeArr[$type];}?>">
	                	<?php endif;?>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">是否启用：<i>*</i></div>
	                <div class="fg-input">
	                	<?php if(empty($id)):?>
	                	<label><input type="radio" name="isopen" value="0" class="inputRadio">否</label>
	                	<label><input type="radio" name="isopen" value="1" checked="checked" class="inputRadio">是</label>
	                	<?php else:?>
	                	<label><input type="radio" name="isopen" value="0" <?php if($isopen ==0){echo 'checked="checked"';}?> class="inputRadio">否</label>
	                	<label><input type="radio" name="isopen" value="1" <?php if($isopen ==1){echo 'checked="checked"';}?> class="inputRadio">是</label>
	                	<?php endif;?>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">备注：</div>
	                <div class="fg-input"><textarea name="remark"><?php if(!empty($remark)){echo $remark;}?></textarea></div>
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
		url:'/admin/a/msg/main/upload',
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


