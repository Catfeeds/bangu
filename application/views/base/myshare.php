<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的定制单</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.SuperSlide.2.1.1.js');?>"></script>
<link type="text/css"href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<!--<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>-->
</head>
<style>
.share_eject, .editor_share_box{ width:100%; height:100%; display:none; overflow:hidden; position:absolute; top:0; left:0; background:
rgba(0,0,0,0.6);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);  position: fixed; padding-top:200px;}
#share, #editor_share{ background:#FFF; border-radius:5px;}
.heise{ width:100%; height:100%; background:#960; position:99;}
</style>

<body>
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<div id="user-wrapper">
  <div class="container clear"> 
 	<!--左侧菜单开始-->
		<?php $this->load->view('common/user_aside');  ?>
	<!--左侧菜单结束-->
    <!-- 右侧菜单开始 -->
    <div class="nav_right" style="position: relative;">
      <div class="user_title">我的分享</div>
      <div class="consulting_warp">
      		<div class="consulting_tab">
            	<div class=" cm_hd_1 clear">
                    <ul>
                      <li ><span style="color: #949494; font-size:12px;">分享 &nbsp;:</span><em style="color: #f60; font-size:14px;">&nbsp;<?php if(!empty($share)){echo $share;}else{ echo 0;} ?></em></li>
            		  <li ><span style="color: #949494; font-size:12px;">人气&nbsp;:</span><em style="color: #f60; font-size:14px;">&nbsp;<?php if(!empty($hits[0]['hits_num'])){ echo $hits[0]['hits_num']; }else{ echo 0;} ?></em></li>
            		  <li ><span style="color: #949494; font-size:12px;">被赞&nbsp;:</span><em style="color: #f60; font-size:14px;">&nbsp;<?php if(!empty($praise[0]['praise_num'])){ echo $praise[0]['praise_num'];}else{ echo 0;} ?></em></li>
                 	  <li ><button class="share" href="#share">+&nbsp;新增分享</button></li>
                    </ul>
				</div>
				<div class="bd cm_bd">
                    <!-- tab 分享的内容 -->
                    <ul>
                        <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                          <thead class="common_thead">
                            <tr>
                              <th width="35%"><span class="td_left">分享标题</span></th>
                              <th width="25%">时间</th>
                              <th width="10%">人气</th>
                              <th width="10%">被赞次数</th>
                              <th width="10%">照片数量</th>
                              <th width="10%">操作</th>
                            </tr>
                          </thead>
                          <tbody class="common_tbody">
                          <?php if(!empty($row)){ ?>
                          <?php foreach($row as $k=>$v){ ?>
                            <tr>
                                <td><span class="td_left"><?php echo  $str = mb_strimwidth($v['content'], 0,45, '...', 'utf8'); ?></span></td>
                                <td><?php echo $v['addtime'] ?></td>
                                <td><?php echo $v['Hits'] ?></td>
                                <td><?php echo $v['praise'] ?></td>
                                <td><?php echo $v['pic'] ?></td>
                                <td class="detail_link">
                                    <a class="share_table_tbody_modify editor_share" data="<?php echo $v['id']; ?>"  href="#editor_share">修改</a><br/>
                                    
                                </td>
                            </tr>
                          <?php }?>
                         <?php }else{?>
                          <!-- 以下是没有分享数据时的状态 -->
                            <tr>
                                  <td class="order_list_active" colspan="5">
                                        <p class="cow-title">您最近没有分享记录！</p>
                                   </td>
                            </tr>
                           <?php }?>
                          </tbody>
                        </table>
                         <div class="pagination">
						   <ul class="page"><?php if(! empty ( $row )){ echo $this->page->create_page();}?></ul>
					   </div>
                    </ul>
                   
				</div>
            </div> 
      </div>
      <!-- 新增的弹框 -->
      <div class="share_eject">
	      <div id="share" style=" margin:0 auto; width:900px; min-height:500px;">
		       <div class="">
		            <div class="share_new_window_top">
		                 <span class="share_new_window_top_span">新增分享</span> 
		            </div>
		            <form  style="float:none;" role="form" method="post" id="shareForm" onsubmit="return addShareFrom();" action="">
		            <div class="share_new_window_body">
		                <div class="share_new_window_body_1">
		                <span>标题：</span>
		                <input type="text" name="title">
		                <div>
		      
		                <div class="share_new_window_body_btn">
	                		 <div id="content">			
										<div>
											<span id="spanButtonPlaceHolder"></span> 
												<input id="btnCancel" type="hidden" value="取消所有上传" onClick="swfu.cancelQueue();"	disabled="disabled"
												style="margin-left: 2px; font-size: 8pt; height: 29px;" />
										</div>	
								</div>
												
		                   <!--   <input type="button" value="上传图片">   -->
		                  <!--    <span>4</span>&nbsp/&nbsp<i>10</i>张 -->
		                </div>
		                 <div style="overflow-y:auto;overflow-x:hidden;max-height: 430px;">
			                <ul class="clear" id="pic_str">
			                    <!-- <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>
			                    <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>
			                    <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>
			                    <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>  --> 
			                </ul>
		                </div>
		                <div class="share_new_window_body_botton">
		                    <input type="submit" name="submit" value="保存" class="commit" />
		                    <input type="button" id="close_button" value="关闭">
		                </div>    
		            </div>
		        </div> 
		      </div>
		       </form>
		    </div>
	    </div>
     </div>
      <!-- 新增的弹框 end--> 
      
      <!-- 修改的弹框 -->
      <div class="editor_share_box">
	      <div id="editor_share" style="margin:0 auto; width:900px; min-height:500px;">    
		          
		            <div class="share_new_window_top">
		                 <span class="share_new_window_top_span">修改</span> 
		            </div> 
		            <form  style="float:none;" role="form" method="post" id="editshareForm" onsubmit="return editorShare();" action="" >
		            <div class="share_new_window_body">
		
		                <div class="share_new_window_body_1">
		                <span>标题：</span>
		                <input type="text" name="editor_title">
		                <div >
		                <div class="share_new_window_body_btn">
	                		 <div id="content">			
									<div>
										<span id="spanButtonPlaceHolder1"></span> 
											<input id="btnCancel1" type="hidden" value="取消所有上传" onClick="swfu1.cancelQueue();"	disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
										</div>	
								</div>									
		                   <!--   <input type="button" value="上传图片">   -->
		                    <!-- <span>4</span>&nbsp/&nbsp<i>10</i>张 -->
		                </div>
		                <div style="overflow-y:auto;overflow-x:hidden;max-height:430px;">
			                <ul class="clear" id="editor_pic_str">
			                    <!-- <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>
			                    <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>
			                    <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>
			                    <li><i></i><img src="<?php echo base_url('static'); ?>/img/page/img_demo.jpg" alt=""></li>  --> 
			                </ul>
		                </div>
		                <div class="share_new_window_body_botton">
		                    <input type="hidden" name="editor_id" value="" />
		                     <input type="hidden" name="editor_pic_arr" value="" />
		                     <input type="submit" name="submit" value="保存" class="commit"   />
		                    <input type="button" id="edit_close_button" value="关闭">
		                </div>	
		                       
		            </div>            
		         </div>  
		     </from>
		    </div>      	    
	    </div>
	    </div>
      <!-- 修改的弹框 end--> 
      
    </div>
    <!-- 右侧菜单结束 --> 
  </div>
</div>
<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
</body>
</html>

<script type="text/javascript" src="/file/common/plugins/swfupload2/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/file/common/plugins/swfupload2/js/swfupload.queue.js"></script>
<script type="text/javascript" src="/file/common/plugins/swfupload2/js/fileprogress.js"></script>
<script type="text/javascript" src="/file/common/plugins/swfupload2/js/handlers.js"></script>
<script type="text/javascript">
var swfu;
var swfu1;
window.onload = function() {
	var settings = {
		flash_url :"/file/common/plugins/swfupload2/swfupload/swfupload.swf",
		upload_url: "/file/common/plugins/swfupload2/c_upload.php",
		post_params: {"PHPSESSID" : "<?php echo $this->session->userdata('session_id'); ?>"},
		file_size_limit : "100 MB",
		file_types : "*.*",
		file_types_description : "All Files",
		file_upload_limit : 20,  //配置上传个数
		file_queue_limit : 0,
		custom_settings : {
			progressTarget : "fsUploadProgress",
			cancelButtonId : "btnCancel"
		},
		debug: false,

		// Button settings
		button_image_url: "/file/common/plugins/swfupload2/images/TestImageNoText_65x29.png",
		button_width: "65",
		button_height: "29",
		button_placeholder_id: "spanButtonPlaceHolder",
		button_text: '<span class="theFont">上传</span>',
		button_text_style: ".theFont { font-size: 16; }",
		button_text_left_padding: 12,
		button_text_top_padding: 3,

		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,
		queue_complete_handler : queueComplete
	};
	
	swfu = new SWFUpload(settings);

	var settings1 = {
			flash_url :"/file/common/plugins/swfupload2/swfupload/swfupload.swf",
			upload_url: "/file/common/plugins/swfupload2/c_upload.php",
			post_params: {"PHPSESSID" : "<?php echo $this->session->userdata('session_id'); ?>"},
			file_size_limit : "100 MB",
			file_types : "*.*",
			file_types_description : "All Files",
			file_upload_limit : 20,  //配置上传个数
			file_queue_limit : 0,
			custom_settings : {
				progressTarget : "fsUploadProgress1",
				cancelButtonId : "btnCancel1"
			},
			debug: false,

			// Button settings
			button_image_url: "/file/common/plugins/swfupload2/images/TestImageNoText_65x29.png",
			button_width: "65",
			button_height: "29",
			button_placeholder_id: "spanButtonPlaceHolder1",
			button_text: '<span class="theFont">上传</span>',
			button_text_style: ".theFont { font-size: 16; }",
			button_text_left_padding: 12,
			button_text_top_padding: 3,

			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			queue_complete_handler : queueComplete
		};
		
	   swfu1 = new SWFUpload(settings1);

};

/**
 * 将上传获取的图片
 */
 
 function uploadSuccess(file, file_data ){
	 //   var imgurl='';
		var url	=file_data.replace("\"","");	
	    var imgurl='<li><i id="" onclick="del_imgdata(this,-1);"></i><img style="width:280px;height:160px;" src="/file/c/share/image/'+url+'><input type="hidden" id="editor_share_pic_1" value="/file/c/share/image/'+url+'" name="img_url[]"  /></li>';
        $('#pic_str').append(imgurl);  
        $('#editor_pic_str').append(imgurl);    
		try {
			var progress = new FileProgress(file, this.customSettings.progressTarget);
			progress.setComplete();
			progress.setStatus("上传成功");
			progress.toggleCancel(false);

		} catch (ex) {
			this.debug(ex);
		}
} 

 


//删除图片
function del_imgdata(obj,id){ 
    var pid=id;
		if (!confirm("确认删除？")) {
          window.event.returnValue = false;
      }else{
      	 $(obj).parent('li').remove();
  	   }
	$.post("<?php echo base_url()?>base/member/del_share_img", { data:id} , function(result) {
		
	});
 }

//添加新增
function addShareFrom(){
    var title=$('input[name="title"]').val(); 
    var img_url='';
    $('#pic_str').find("input[id='editor_share_pic_1']").each(function () {
        if ($(this).val() != "") {
        	img_url=$(this).val();
        }
    });
    if(title==''){
        alert('标题不能为空！');
        return false;
    }
    
    if(img_url==""){
    	alert('分享图片不能为空！');
    	return false;
    }
    
    
	jQuery.ajax({ type : "POST",data : jQuery('#shareForm').serialize(),url : "<?php echo base_url();?>base/member/add_share", 
		success : function(response) {
			if(response){
				alert('添加成功！');		
				location.reload();
				$('.fancybox-close').click();
			}else{
				alert('添加失败！');
				location.reload();
				$('.fancybox-close').click();
				
			}
		}
	});
	return false;
 } 

 //保存编辑页面
 function editorShare(){

	// var share_img='';
	 var title=$('input[name="editor_title"]').val();
     var img_url='';
     $('#editor_pic_str').find('input[name="img_url[]"]').each(function () {
         if ($(this).val() != "") {
         	img_url=$(this).val();
         }
     });
     var share_img='';
     $('input[id="editor_share_pic_1"]').each(function () {  
         share_img=share_img+this.value+';';  
    });
    $('input[name="editor_pic_arr"]').val(share_img); 

     if(title==''){
         alert('标题不能为空！');
         return false;
      }
     //
    if(img_url==''){
         alert('分享图片不能为空！');
         return false;
      } 

 	jQuery.ajax({ type : "POST",data : jQuery('#editshareForm').serialize(),url : "<?php echo base_url();?>base/member/editor_share", 
		success : function(response) {
			if(response){
				alert('修改成功！');	
				location.reload();
				$('.fancybox-close').click();
			}else{
				alert('修改失败！');
				location.reload();
				$('.fancybox-close').click();
				
			}
		}
	});
		
		return false;
 }
 
	$(function(){
		$(".share").click(function(){
			$(".share_eject").show(true);
			$('input[name="title"]').val('');
			 $('#pic_str').html('');
		})
		
		$("#close_button").click(function(){
			$(".share_eject").hide(true)
			})

       //修改分享
		$(".editor_share").click(function(){
			$(".editor_share_box").show(true);
				$('#editor_pic_str').html(''); 
	            var id= $(this).attr('data');
				$.post("<?php echo base_url()?>base/member/by_shareid", { id:id} , function(data) {	
					    var pic_url='';		
					    var data =eval("("+data+")");	     
					         $('input[name="editor_id"]').val(id);	
						     json = eval(data.share_content); 	
							 $(data.share_content).each(function(index,item){ 
								 $('input[name="editor_title"]').val(item.content);		
							 });
							 $(data.share_pic).each(function(index,it){ 	 
								 var pic_url='<li><i id="" onclick="del_imgdata(this,'+it.id+');"></i><img style="width:280px;height:160px;" src="'+it.pic+'"><input type="hidden" value="'+it.pic+'" name="img_url[]"  /></li>';
								  $('#editor_pic_str').append(pic_url); 	
							 });	 		  
				});	
			})
		
	 	$("#edit_close_button").click(function(){
			$(".editor_share_box").hide(true)
		}) 
})


  
</script>

