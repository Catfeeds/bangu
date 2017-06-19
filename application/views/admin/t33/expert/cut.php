<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>


<style type="text/css">

.container{width:88%;margin:0 auto;margin-top:20px;}
.container .section img{width:440px;}
.foot{width:100%;float:right;height:30px;}
.foot input{background:#da411f;color:#fff;border-radius:3px;width:60px;height:30px;border:none;cursor:pointer;}

.jcrop-holder{float:left;}


</style>

</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
 <!-- 添加供应商 弹窗 -->
<div class="fb-content" id="form1">

   <div class="container">
	
	<div class="section">
		
		<div class="row imgchoose"><img src="<?php echo base_url().$img_url;?>" id="target" data-value="<?php echo $img_url;?>" /></div>
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<div style="width:200px;height:200px;margin:30% 0px 10px 10px;overflow:hidden; float:left;"><img class="preview" style="width:200px;height:200px;" id="preview3" src="<?php echo base_url().$img_url;?>" /></div>
			<div style="width:130px;height:130px;margin:38% 0px 10px 10px;overflow:hidden; float:left;"><img class="preview" style="width:130px;height:130px;" id="preview2" src="<?php echo base_url().$img_url;?>" /></div>
			
		
		
	</div>
	
           <div class="foot" style="margin-top:10px;text-align:right !important;"> 
           		 <input type="button" id="btn_sure" class="btn_sure" onclick="" style="margin-right:10px;" value="确定">
                <input type="button" id="btn_close" class="btn_close"  value="取消">
               
           </div>
</div>
    
</div>
<link href="<?php echo base_url("assets/ht/js/jcrop/jquery.Jcrop.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/jcrop/jquery.Jcrop.min.js"); ?>"></script>
<script type="text/javascript">

var iframeid="<?php echo $iframeid;?>";

$(function() {
	
	
    $('#target').Jcrop({
					minSize: [360,360],
					setSelect: [0,0,360,360],
					onChange: updatePreview,
					onSelect: updatePreview,
					onSelect: updateCoords,
					aspectRatio: 1
				},
				function(){
		
				var bounds = this.getBounds();
				boundx = bounds[0];
				boundy = bounds[1];
				jcrop_api = this;
			});
    //头像裁剪
	var jcrop_api, boundx, boundy;
	
	function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('请选择图片上合适的区域');
		return false;
	};
	function updatePreview(c){
		if (parseInt(c.w) > 0){
			var rx = 112 / c.w;
			var ry = 112 / c.h;
			$('#preview').css({
				width: Math.round(rx * boundx) + 'px',
            	height: Math.round(ry * boundy) + 'px',
            	marginLeft: '-' + Math.round(rx * c.x) + 'px',
            	marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
		}
		{
			var rx = 130 / c.w;
			var ry = 130 / c.h;
			$('#preview2').css({
            	width: Math.round(rx * boundx) + 'px',
            	height: Math.round(ry * boundy) + 'px',
            	marginLeft: '-' + Math.round(rx * c.x) + 'px',
            	marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
		}
		{
			var rx = 200 / c.w;
			var ry = 200 / c.h;
			$('#preview3').css({
				width: Math.round(rx * boundx) + 'px',
				height: Math.round(ry * boundy) + 'px',
				marginLeft: '-' + Math.round(rx * c.x) + 'px',
				marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
		}
	};
	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	$("#btn_sure").click(function(){
		var img = $("#target").attr("data-value");
		var x = $("#x").val();
		var y = $("#y").val();
		var w = $("#w").val();
		var h = $("#h").val();

		var new_width=$(".jcrop-holder").width();
		var new_height=$(".jcrop-holder").height();
		
		if( checkCoords() ){
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/t33/expert/do_cut');?>",
				data: {"img":img,"x":x,"y":y,"w":w,"h":h,new_width:new_width,new_height:new_height},
				dataType: "json",
				success: function(data){
					if( data.code=="2000" ){
						
						//alert(window.name)
						//alert(iframeid);
						//window.parent.document.getElementById('layui-layer-iframe1').contentWindow.update_cut(data.data.big);
						window.parent.document.getElementById(iframeid).contentWindow.update_cut(data.data.big);
						
						parent.layer.close(index);

					} else {
						tan(data.msg);
					}
				}
			});
		}
	});

	
	$('#btn_close').click(function()
	{
	    
	     parent.layer.close(index);
	});
	
});
</script>
</body>


</html>


