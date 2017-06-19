<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>价格申请</title>
<link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css')?>" rel="stylesheet" type="text/css" />
<style>
.table_content{
	width: 80%;
	height: 230px;
    border: 1px solid #ccc;
}
.but-list{
  text-align: right;
  width: 80%;
  margin: 20px 0px;
}
.but-list button{
  background: #3EAFE0;
  border: 1px solid #ccc;
  padding: 5px 8px;
  border-radius: 4px;
  cursor: pointer;
  color: #fff;
}
</style>
</head>
<body>
<h4 style="text-align: center;font-weight: 600 !important;">请签署姓名</h4>
<div class="page-content bg_gray" style="margin-left: 15%;position: relative;">
	<div class="table_content" id="sign-content"> </div>
	<?php if (!empty($sign_pic)):?>
	<!-- 管家存在签署的图片 -->
	<div class="table_content sign-pic" style="position: absolute;top: 0;">
		<img src="<?php echo $sign_pic?>" />
	</div>
	<?php endif;?>
	<div class="but-list">
		<button class="submit-but" <?php if(!empty($sign_pic)){echo 'style="display:none;"';}?>>上传</button>
		<button class="use-sign" <?php if(empty($sign_pic)){echo 'style="display:none;"';}?>>使用签名</button>
		<button class="sign-reset">重签</button>
		<button class="cancel-but">关闭</button>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script src="/assets/js/jSignature-master/libs/modernizr.js"></script>
<script src="/assets/js/jSignature-master/libs/jSignature.min.noconflict.js"></script>

<script type="text/javascript">
//var signObj =  $("#sign-content").jSignature();
var signObj = $("#sign-content").empty().jSignature({'height':'100%' ,'width':'100%'});

$('.submit-but').click(function(){
	var datapair = signObj.jSignature("getData", "image");
	var base64 = datapair[1];

	//上传至服务器
	$.ajax({
		url:'/admin/b2/contract/imgHandle',
		type:'post',
		data:{'str':base64},
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
				//parent.$("#main")[0].contentWindow.window.location.reload();
				window.top.layer.open({
					  type: 2,
					  area: ['900px', '600px'],
					  title :'合同信息',
					  fix: true, //不固定
					  maxmin: true,
					  content: "<?php echo base_url('admin/b2/contract/launchContract');?>?id="+<?php echo $contractId;?>
				});
				parent.layer.close(index);
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});

})

$('.use-sign').click(function(){
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	//parent.$("#main")[0].contentWindow.window.location.reload();
	window.top.layer.open({
		  type: 2,
		  area: ['900px', '600px'],
		  title :'合同信息',
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('admin/b2/contract/launchContract');?>?id="+<?php echo $contractId;?>
	});
	parent.layer.close(index);
})

$('.cancel-but').click(function(){
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	//parent.$("#main")[0].contentWindow.window.location.reload();
	parent.layer.close(index);
})

//重新签字
$('.sign-reset').click(function(){
	if ($('.sign-pic').length) {
		//若管家签字的图片存在，则隐藏
		$('.sign-pic,.use-sign').hide();
		$('.submit-but').show();
	} else {
		signObj.jSignature('reset');
	}
})
</script>
</body>
</html>
