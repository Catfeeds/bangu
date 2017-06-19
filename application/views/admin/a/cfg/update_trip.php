<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style>
		.form-horizontal .form-group input[type=radio]{width:auto;}
		.form-horizontal .form-group label{width: 60px;display: inline-block;}
 		.posInput{ position: relative; top:7px;}
	</style>
</head>
<body>
    <div class="fb-content">
	    <div class="fb-form">
	        <form method="post" action="#" id="add-form" class="form-horizontal">
	            <div class="form-group">
	                <div class="fg-title">出发城市：<i>*</i></div>
	                <div class="fg-input">
	                	<input type="text" name="cityname" id="cityname" value="<?php echo empty($cityname) ? '' : $cityname ?>" onclick="showStartplaceTree(this);">
	                	<input type="hidden" name="cityid" value="<?php echo empty($startplaceid) ? '' : $startplaceid ?>">
	                </div>
	            </div>
	 			<div class="form-group">
	                <div class="fg-title">目的地：<i>*</i></div>
	                <div class="fg-input">
	                	<input type="text" name="kindname" id="kindname" value="<?php echo empty($kindname) ? '' : $kindname ?>" onclick="showDestBaseTree(this);">
	                	<input type="hidden" name="destid" value="<?php echo empty($neighbor_id) ? '' : $neighbor_id ?>">
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="fg-title">是否启用：<i>*</i></div>
	                <div class="fg-input">
	                	<?php if (isset($isopen)):?>
	                	<label><input type="radio" name="isopen" value="1" <?php echo $isopen==1 ? 'checked="checked"' : '';?> class="posInput">是</label>
	                	<label><input type="radio" name="isopen" value="0" <?php echo $isopen==0 ? 'checked="checked"' : '';?> class="posInput">否</label>
	                	<?php else:?>
	                	<label><input type="radio" name="isopen" value="1" checked="checked" class="posInput">是</label>
	                	<label><input type="radio" name="isopen" value="0" class="posInput">否</label>
	                	<?php endif;?>
	                </div>
	            </div>
	            <div class="form-group">
	                <input type="hidden" name="id" value="<?php echo empty($id) ? '' : $id ?>">
	                <input type="button" class="fg-but" onclick="t33_close_iframe_noreload();" value="取消">
	                <input type="submit" class="fg-but" value="确定">
	            </div>
	            <div class="clear"></div>
	        </form>
	    </div>
	</div>
<?php $this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
	$('#add-form').submit(function(){
		var id = $(this).find('input[name=id]').val();
		var url = id >0 ? '/admin/a/round_trip/edit' : '/admin/a/round_trip/add';
		$.ajax({
			url:url,
			data:$(this).serialize(),
			type:'post',
			dataType:'json',
			success:function(result) {
				if(result.code == 2000) {
					layer.confirm(result.msg, {btn:['确认']},function(){
						parent[0].getData();
						t33_close_iframe_noreload();
					});
				} else {
					layer.alert(result.msg, {icon: 2});
				}
			}
		});
		return false;
	})
</script>
</html>