
<!-- Page Breadcrumb -->
<style>
.page-body{ padding: 20px;}
    .bodyCon{ background: #fff; width: 600px;height: 500px; overflow: hidden; position: absolute; top:50%; left: 50%; margin-left: -300px; margin-top:40px;}
    .groupTitle{ height:40px; line-height: 40px; background: #fff; text-indent: 10px; border-bottom:1px solid #ddd}
    .fileImg{ width: 100%; padding-top: 40px;}
    .fileImg img{ width: 80%; margin-left: 10%;}
    .fileTip{ text-indent: 10%; height:30px; line-height: 30px; margin-top: 10px;}
    .form-horizontal .form-group input{ width: 60px; background: #2dc3e8; color: #fff; padding:0 !important}
    .buttonFile{text-align: center;} 
	.form-horizontal .form-group input[type=submit], .form-horizontal .form-group input[type=button]{ padding:0 !important}
</style>
                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">个性模版</li>
    </ul>
</div>
                <!-- Page Body -->
<div class="page-body" id="bodyMsg">
    <div class="bodyCon shadow">
<!--    
        <div id="myModal" style="display:none;">
            <div class="row">
                <div class="col-md-12">
                    <img src="<?php echo base_url('assets/img/avatars/Nicolai-Larson.jpg')?>" style="width:65px; height:65px;">
                    <img src="<?php echo base_url('assets/img/avatars/Matt-Cheuvront.jpg')?>" style="width:65px; height:65px;">
                    <img src="<?php echo base_url('assets/img/avatars/Stephanie-Walter.jpg')?>" style="width:65px; height:65px;">
                    <img src="<?php echo base_url('assets/img/avatars/Javi-Jimenez.jpg')?>" style="width:65px; height:65px;">
                    <img src="<?php echo base_url('assets/img/avatars/Nicolai-Larson.jpg')?>" style="width:65px; height:65px;">
                </div>
            </div>
        </div>
-->

        <form class="form-horizontal form-bordered" role="form" id="templateForm" onsubmit="return update_template();" method="post" action="<?php echo site_url('admin/b2/expert/template_update');?>" enctype="multipart/form-data">
            <div class="form-group" style=" margin:0">
                <div style="height:40px">
                    <div class="groupTitle">背景图片预览: </div>
                </div>
                <div class="fileImg">
                    <img id="tmp_img" src="<?php if(!empty($template_info)){ echo $template_info; }else{ echo "/assets/img/img_demo.jpg" ;}?>" alt="">
                    <div class="fileTip">推荐尺寸:1449*900</div>
                    <div class="buttonFile">
                        <input class="btn btn-default " type="button" value="上传图片"  id="upfile_tmp_file" />
                        <button class="btn btn-palegreen" id="mobanMsg" type="submit">保存</button>
                    </div>
                </div>
                <input type="hidden" name="tmp_file_url" id="tmp_file_url" value=""/>
            </div>
        </from>
    </div>
</div>

<script type="text/javascript">
        
window.onload=function(){
	 var this_click= document.getElementById('upfile_tmp_file');
	 var eject_line= "上传失败";
	 this_click.onclick= function (){
		$('.avatar_box').show();
		

		   /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
		   xiuxiu.setLaunchVars("cropPresets", '1449:900');
			xiuxiu.embedSWF("altContent",5,'100%','100%');
			
		       //修改为您自己的图片上传接口
			xiuxiu.setUploadURL("<?php echo site_url('admin/upload/uploadImgFileXiu'); ?>");
		        xiuxiu.setUploadType(2);
		        xiuxiu.setUploadDataFieldName("uploadFile");
			xiuxiu.onInit = function ()
			{
				//默认图片
				xiuxiu.loadPhoto("/assets/img/default_photo.png");
			}
			xiuxiu.onUploadResponse = function (data)
			{
				data = eval('('+data+')');
				if (data.code == 2000) {
		
					$("#tmp_img").attr("src",data.msg);
					$("#tmp_file_url").val(data.msg);
				
					$(".close_xiu").click();
				} else {
					alert(eject_line);
				}
				$(".close_xiu").click();
			}
			
			$("#xiuxiuEditor").show().css('margin-top','60px');
			$('.close_xiu').css('margin-top','60px');
			$('.close_xiu').show();
	}
	$(document).mouseup(function(e) {
     var _con = $('#xiuxiuEditor'); // 设置目标区域
     if (!_con.is(e.target) && _con.has(e.target).length === 0) {
         $("#xiuxiuEditor").hide()
         $('.avatar_box').hide();
         $('.close_xiu').hide();
     }
 })
 $('.close_xiu').click(function(){
 	 $("#xiuxiuEditor").hide()
      $('.avatar_box').hide();
      $('.close_xiu').hide();
 })
	
}
               
//修改模板
function update_template(){
	jQuery.ajax({ type : "POST",data : jQuery('#templateForm').serialize(),url : "<?php echo base_url()?>admin/b2/expert/template_update", 
		success : function(response) {
			 var response=eval("("+response+")");
				 if(response.status==1){  
					 alert(response.msg);
				 }else{
					alert(response.msg);
				 }
			}
	});
	return false;
}




</script>