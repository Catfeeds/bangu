<style>
.webuploader-pick{ left:0px;}
.parentFileBox{float:left;width:100px;}
.parentFileBox .fileBoxUl{display:none;};
.parentFileBox .diyButton{float:left; width: 100px;};
.img_main0{ position:relative;margin-top:10px;}
.page-body .nav-tabs li{ padding: 0}
.page-body{ padding: 20px;}
.page-body .nav-tabs{ background: none;box-shadow:none;}
.table>thead>tr>th, .table>tbody>tr>td{  padding: 10px 5px;}
.nav-tabs{background:none;-webkit-box-shadow:none;box-shadow:none;}
.float_img{height:21px;z-index:100;color: #000;font-size: 21px;font-weight: 700;opacity: 0.2;font-size:24px;cursor:pointer;width:20px;margin-left: 146px;}
.webuploader-pick{position: absolute;top: 165px;left: 75px;width: 82px;height: 38px;overflow: hidden;bottom: auto;right: auto;line-height: 38px;text-align: center;background: #09c;color: #fff;overflow: hidden;}
.revertexplainButton{ position: relative; margin-top: 100px; clear: both; overflow: hidden; height: 30px;}
.modal-content,.revert{ width: 1000px;}
.btn-blues{ background: #09c; color: #fff; border: none;}
.btn-blues:hover{ background: #09c; color: #fff;}

.webuploader-element-invisible{ width: 80px; height: 30px; line-height: 30px; padding-left: 0; opacity: 0;}
.inPut2,.inPut1{ position: absolute; background: #09c; border: none; color: #fff;border-radius: 2px;}
.inPut1{left:400px; top: 0;}
.inPut2{left:600px; top: 0;}
.img_main0{ position: relative;}
.tab-content{ box-shadow: none;padding:0 10px 15px !important;}
.float_img{ position: absolute; top: 3px; right: 3px; line-height: 20px; background: #09c; border-radius: 50%;}
.tabbable { background:#fff;}
label { margin-bottom:0;}
.table>tbody>tr>td{ padding: 6px;}
.form-group { margin-bottom:10px;}
</style>

<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"> </i>
			<a href="<?php echo site_url('admin/b2/expert/account')?>">首页</a>
		</li>
		<li class="active">我的代购</li>
	</ul>
</div>
<!-- /Page Header -->
<!-- Page Body -->
<div class="page-body" id="bodyMsg">
	<div class="widget">
		<!--  <div class="widget-body"> -->
		<div class="flip-scroll">
			<div class="tabbable">
				<!--<ul  class="nav nav-tabs">
					<li  class="active" id="myTab5">
					<a href="" name="add_data" >我的代购</a>
					</li>
				</ul> -->
				<div class="tab-content sh">
					<div class="tab-pane active" id="tab1">
						<label>
							<div class="form-group">
								<button id="mobanMsg" class="btn btn-blues">新增代购</button>
							</div>
						</label>
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="text-align:center">分享标题</th>
									<th style="text-align:center">时间</th>
									<!-- <th style="text-align:center">人气</th>-->
									<th style="text-align:center">被赞次数</th>
									<th style="text-align:center">照片数量</th>
									<th style="text-align:center">操作</th>
								</tr>
							</thead>
							<tbody>
           					 <?php if(!empty($essay_list)){
           					  foreach ($essay_list as $k=>$v){
           					 	?>
          						<tr>
									<td style="text-align:left" title="<?php echo $v['content']; ?> "><?php echo   $str = mb_strimwidth($v['content'], 0, 40, '...', 'utf8'); ?></td>
									<td style="text-align:center"><?php echo $v['addtime']; ?></td>
									<!-- <td style="text-align:center"><?php echo $v['popularity']; ?></td>-->
									<td style="text-align:center"><?php echo $v['praise_count']; ?></td>
							        <td style="text-align:center"><?php if(!empty( $v['picnum'])){  $num=explode(';', $v['picnum']); echo count($num); }else{ echo 0;} ?></td>
							        <td style="text-align:center"><a data="<?php echo $v['id']; ?>" class="edit_box">修改</a></td>
								</tr>
							<?php } }?>
							</tbody>
						</table>
						<div class="pagination"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!--新增代购-->
<div style="display:block;z-index:-1;top:-1000px;" class="bootbox modal fade in addEssay" id="addEssay">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content" style="width:1000px">
			<div class="modal-header">
				<button type="button" class="bootbox-close-button close" onclick="hidden_modal_inquiry()">×</button>
				<h4 class="modal-title">新增代购</h4>
			</div>
			<div class="modal-body" style="min-height: 300px;">
				<div class="bootbox-body">
					<div>
					<form class="form-horizontal" role="form" id="addEssaydd" method="post" action="<?php echo site_url('admin/b2/essay/add_essay')?>" >
					   <div class="revert" style="border:none;">
							<div class="revertContext" style="height:80px;border-bottom:none;">
							   	<div>
								   	<span class="fl">标题：</span>
								   	<textarea rows="" id="content" cols="" placeholder="200字以内" style="min-width:800px;height:55px;" name="content"></textarea>
							   	</div>
							</div>
							<p class="pic_text" style=" padding-left: 160px;">0/6张</p>
							<div class="revertexplain" style="height:auto;">
							   <div style="width:100%;float:left;">
								   	<ul id="ThumbPic">
									</ul>
							  	</div>
							   	<!--  上传图片的按钮 -->
								<div style="float:left;margin-top:10px;height:10px;margin-left:50px;">
									<div id="add_pic"></div>
								</div>


								<div class="revertexplainButton" style=" margin-top:10px;" >
									<input type="submit" value="提交" onclick="return click_date()" class="inPut1" style="padding:5px 8px;"/>
									<input type="button" onclick="hidden_modal_inquiry()" class="inPut2" value="关闭" style="padding:5px 8px;"/>
									<input type="reset" id="reset_form_inquiry" style="display:none"/>
								</div>
							</div>
							</div>
					   </form>
					</div>
				</div>
			</div>
	 	</div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;" id="back_addEssay"></div>
<!--end-->

<!-- 修改 -->
<div style="display:block;z-index:-1;top:-1000px;" class="bootbox modal fade in editEssay" id="editEssay">
	<div class="modal-dialog" style="width:1000px">
		<div class="modal-content"  style="width:1000px">
	<div class="modal-header">
		<button type="button" class="bootbox-close-button close" onclick="hidden_modal_inquiry()">×</button>
		<h4 class="modal-title">修改代购</h4>
	</div>
	<div class="modal-body">
		<div class="bootbox-body">
			<div>
			<form class="form-horizontal" role="form" id="edit" method="post" action="<?php echo site_url('admin/b2/essay/edit_essay')?>" >
			   <div class="revert" style="border:none;">
				<div class="revertContext" style="height:80px;border-bottom:none;">
					<div class=""><span class="fl">标题：</span>
					  <textarea  placeholder="200字以内" rows="" cols="" style="width:400px;height:50px;" id="eidt_content" name="eidt_content"></textarea>
					  <input type="hidden" name="essay_id" id="essay_id" >
					</div>
				</div>
				<p style="margin:10px 0px 0px 97px ; width:100px;" class="eidt_pic_text">0/6张</p>
				<div class="revertexplain" style="height:auto;">
				   <div style="width:100%;float:left;">
					   <ul id="eidt_ThumbPic">
						</ul>
				  </div>
				   <!--  上传图片的按钮 -->
					<div style="width:700px;float:left;margin-top:10px;height:55px;margin-left:50px;">
						<div id="eidt_pic"></div>

					</div>
					<div class="revertexplainButton" style=" margin-top:10px;" >
						<input type="submit" value="提交" class="inPut1" style="padding:5px 8px;" onclick="return click_editdate()" />
						<input type="button" onclick="hidden_modal_inquiry()" class="inPut2" style="padding:5px 8px;" value="关闭"/>
						<input type="reset" id="reset_form_inquiry" style="display:none"/>
					</div>
				</div>
			</div>
			   </form>
			</div>
		  </div>
	  </div>
	 </div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;" id="back_editEssay"></div>
<!-- end -->
<script src="<?php echo base_url('assets/js/webuploader.min.js') ;?>"></script>
<script src="<?php echo base_url('assets/js/diyUpload0.js') ;?>"></script>
<!-- 消息弹出框结束 -->
<script type="text/javascript">
	//多图片上传
	$("#add_pic, #eidt_pic").css({
			   	"position":"absolute",
			    "top": "-14px",
			    "left": "-4px",
			    "marginTop":" -65px"
			   })
	$('#add_pic').diyUpload({
		swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
		url:"<?php echo base_url('admin/b2/essay/upload_pics')?>",
		success:function( data ) {
			//console.info( data );
			//alert($('#ThumbPic').children('li').length);
			if($('#ThumbPic').children('li').length>5){
				alert('上传文件数量超过限制');
			}else{
				var html='<li style="list-style: none; margin:10px 0px 0px 10px;float:left;">';
			    html+='<div class="img_main0" onclick="click_div(this)" style="position:relative">';
			    html+='  <div id="del_img" class="float_img" onclick="del_line_imgdata(this,-1)">×</div>';
			    html+='<img style="width: 150px;height:100px;" src="'+data.url+'">';
			    html+='</div>';
			    html+='<input id="essay_imgss" type="hidden" name="essay_imgss[]" value="'+data.url+'">';
			    html+='</li>';
			   $("#ThumbPic").append(html);
			   $(".pic_text").html($('#ThumbPic').children('li').length+'/6张');
			   $("#add_pic").css({
			   	"position":"absolute",
			    "top": "-14px",
			    "left": "-4px",
			    "marginTop":" -65px"
			   })

			}

		},
		error:function( err ) {
			console.info( err );
		},
		buttonText : '选择图片',
		chunked:true,
		// 分片大小
		chunkSize:512 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
		fileNumLimit:50,
		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		accept: {}
	});
   //编辑按钮
   	$('#eidt_pic').diyUpload({

		swf: "<?php echo base_url('assets/js/swf/Uploader.swf')?>",
		url:"<?php echo base_url('admin/b2/essay/upload_pics')?>",
		success:function( data ) {
			//console.info( data );
			if($('#eidt_ThumbPic').children('li').length>5){
				alert('上传文件数量超过限制');
			}else{
				var html='<li style="list-style: none; margin:10px 0px 0px 10px;float:left;">';
			    html+='<div class="img_main0" onclick="click_div(this)" style="position:relative">';
			    html+='  <div id="del_img" class="float_img" onclick="del_line_imgdata(this,-1)">×</div>';
			    html+='<img style="width: 120px;height:80px;" src="'+data.url+'">';
			    html+='</div>';
			    html+='<input id="edit_imgss" type="hidden" name="edit_imgss[]" value="'+data.url+'">';
			    html+='</li>';
			   $("#eidt_ThumbPic").append(html);
			   $(".eidt_pic_text").html($('#eidt_ThumbPic').children('li').length+'/6张');
			}
		},
		error:function( err ) {
			console.info( err );
		},
		buttonText : '选择图片',
		chunked:true,
		// 分片大小
		chunkSize:512 * 1024,
		//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
		fileNumLimit:50,
		fileSizeLimit:500000 * 1024,
		fileSingleSizeLimit:50000 * 1024,
		accept: {}
	});

   //弹框
	$('#mobanMsg').click(function(){
		$('#content').html('');
		$('#ThumbPic').html('');
		$("#back_addEssay").show();
		$("#addEssay").css({'z-index':'999999',"top":"0px","left":"50%","margin-left":"-500px"});
	});
	//隐藏弹框
	function hidden_modal_inquiry(){
		$("#back_addEssay").hide();
		$("#back_editEssay").hide();
		$("#addEssay").css({'z-index':'-1','top':'-1000px'});
		$("#editEssay").css({'z-index':'-1','top':'-1000px'});
	}
  //修改弹框
   $('.edit_box').click(function(){
	    var id=$(this).attr('data');
		$.post(
				"<?php echo site_url('admin/b2/essay/get_essay')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					$.each(data ,function(key ,val){
						$('#eidt_content').val(val.content);
						$('#essay_id').val(val.id);
						//图片
						 var str=val.pic.split(";");
						 var html='';
						 if(val.pic!=''){
							  $.each(str ,function(i ,v){
									html+='<li style="list-style: none; margin:10px 0px 0px 10px;float:left;">';
								    html+='<div class="img_main0" onclick="click_div(this)">';
								    html+='  <div id="del_img" class="float_img" onclick="del_line_imgdata(this,-1)">×</div>';
								    html+='<img style="width: 150px;height:100px;" src="'+v+'">';
								    html+='</div>';
								    html+='<input id="edit_imgss" type="hidden" name="edit_imgss[]" value="'+v+'">';
								    html+='</li>';
						      });
						 }
						if(str!=''){
							$('.eidt_pic_text').html(str.length+'/6张');
						 }else{
							 $('.eidt_pic_text').html('0/6张');
						 }
						$('#eidt_ThumbPic').html(html);

					})
				}
			);

		$("#back_editEssay").show();
		$("#editEssay").css({'z-index':'999999',"top":"0px","left":"50%","margin-left":"-500px"});
  });

	//删除图片
	function del_line_imgdata(obj,id){
	    var pid=id;
			if (!confirm("确认删除？")) {
	          window.event.returnValue = false;
	      }else{
	            $(obj).parent().parent('li').remove();
	            $('.eidt_pic_text').html($("#eidt_ThumbPic li").length+'/6张');
	  	   }
	 }
//验证信息
function click_date(){
	var content=$('#content').val();
	if(content==''){
		alert('分享的标题不能为空！');
		return false;
	}else{
		//不能超过200个字
		 var str=content;
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var b = 0; b < len; b++) {
		 charCode = str.charCodeAt(b);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 }
	     if(realLength>200){
		     alert('不能超过200个字');
		     return false;
		 }
	}

}
function click_editdate(){

	var content=$('#eidt_content').val();
	if(content==''){
		alert('分享的标题不能为空！');
		return false;
	}else{
		//不能超过200个字
		 var str=content;
		 var realLength = 0, len = str.length, charCode = -1;
		 for (var b = 0; b < len; b++) {
		 charCode = str.charCodeAt(b);
		 if (charCode >= 0 && charCode <= 128)
		 		realLength += 1;
		 		else realLength += 1;
		 }
	     if(realLength>200){
		     alert('不能超过200个字');
		     return false;
		 }
	}
}
</script>
