<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<style type="text/css">
	.col_span{ float: left;margin-top: 6px}
	.col_ip{ float: left; }
.col-sm-10{width: 76.333%}

</style>
<script src="//api.html5media.info/1.2.2/html5media.min.js"></script>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">历史直播列表</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">历史直播列表</span>
							<div class="widget-buttons">
								<!-- <a href="#" data-toggle="maximize"> <i class="fa fa-expand"></i>
								</a> <a href="#" data-toggle="collapse"> <i class="fa fa-minus"></i>
								</a> <a href="#" data-toggle="dispose"> <i class="fa fa-times"></i>
								</a> -->
							</div>
						</div>		
		
		
		
		
						<div class="widget-body">
							<div role="grid" id="simpledatatable_wrapper"
								class="dataTables_wrapper form-inline no-footer">
								<div id="simpledatatable_filter" >
									<label>

									</label>
								</div>
								<div class="dataTables_length" id="simpledatatable_length">
									<label></label>
								</div>
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="simpledatatable" aria-describedby="simpledatatable_info">
									<thead>
										<tr role="row">
											<th style="text-align:center">编号</th>
											<th style="text-align:center">标签</th>
											<th style="text-align:center" >房间id</th>
											<th style="text-align:center">提交视频名</th>
											<th style="text-align:center">上传封面图</th>
											<th style="text-align:center">同步视频名</th>
											<th style="text-align:center">同步封面图</th>
											<th style="text-align:center" >视频</th>
											<th style="text-align:center" >同步次数</th>
											<th style="text-align:center" >最后一次同步时间</th>
											<th style="text-align:center">添加时间</th>
											<th style="text-align:center">开始时间/结束时间</th>
											<th style="text-align:center">观众人数</th>
											<th style="text-align:center">主播名</th>
											<th style="text-align:center">主播操作记录</th>
											<th style="text-align:center">操作</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($pageData as $item): ?>
       									 <tr>
           								     <td class="sorting_1" style="text-align:center"><?php echo $item['room_id'];?></td>
           								     <td class=" " style="text-align:center"><?php echo $item['attrname'];?></td>
            								     <td title="" style="text-align:center">
<?php echo $item['roomid']?>
												 </td>
            								     <td title="<?php echo $item['room_name']?>" style="text-align:center">
												 <?php echo $item['room_name']?>
												 </td>
            								     <td class=" " style="text-align:center">
												 <?php $item['pic'] = trim($item['pic']); if(!empty($item['pic'])){ ?>
												 <img src="<?php echo (strpos($item['pic'],'http://')===0)?$item['pic']:trim(base_url(''),'/').$item['pic'];?>" width="100px" />
												<?php }else{?>
												无图片
												<?php } ?>													 
												 </td>
             								     <td title="<?php echo $item['video_name']?>" style="text-align:center">
												 <?php echo $item['video_name']?>
												 </td>
            								     <td class=" " style="text-align:center">
												 <?php if(!empty($item['video_pic'])){ ?>
												 <img src="<?php echo (strpos($item['video_pic'],'http://')===0)?$item['video_pic']:trim(base_url(''),'/').$item['video_pic'];?>" width="100px" />
												<?php }else{?>
												无图片
												<?php } ?>												 
												 </td>
            								     <td  style="text-align:center">
	<?php if(!empty($item['video'])){ ?>											 
<video src="<?php echo $item['video']?>" width="320" height="200" controls preload></video>
	<?php }else{?>
	无视频
	<?php } ?>
												 </td> 
												<td class=" " style="text-align:center" ><?php echo $item['sync_num'];?></td>
												<td class=" " style="text-align:center"><?php echo ($item['sync_time']?date("Y-m-d H:i:s",$item['sync_time']):'0');?></td>												
												 <td class=" " style="text-align:center"><?php echo date("Y-m-d H:i:s",$item['createtime']);?></td>
												  <td class=" " style="text-align:center"><?php echo ($item['starttime']?date("Y-m-d H:i:s",$item['starttime']):'0');?>/<?php echo ($item['endtime']?date("Y-m-d H:i:s",$item['endtime']):'0');?></td>
										 <td class=" " style="text-align:center" ><?php echo $item['peoples'];?></td>
										 
									     <td title=""><?php echo $item['anchor_name']?></td>
										 <td title="">
										 <?php 
										 if($item['user_do_start_log']==1){
											 echo '<font color=blue >[点击开始直播或录播按钮</font>,时间：'.date("Y-m-d H:i:s",$item['user_do_start_time']).']<br/>'; 
										 }else{
											 echo '[没有点击开始直播或录播按钮]<br/>';
										 }
										 if($item['user_do_tui_log']==1){
											 echo '<font color=blue >[点击了退出直播或录播按钮</font>,时间：'.date("Y-m-d H:i:s",$item['user_do_tui_time']).']<br/>';
										 }else{
											 echo '[没有点击退出直播或录播按钮]<br/>';
										 }
										 ?>
 <a href="<?php echo site_url('admin/a/live/live_room_manage/roomuserlog?room_id='.$item['room_id'])?>"  class="btn btn-default btn-xs purple">录播用户操作日志</a>											 
										 </td>										 
									    <td class=" " style="text-align:center">
										<?php if($item['record_id']>0){?>
										已经同步
										<?php }else{?>
 <a href="http://api.1b1u.com/v2_5_0/live_desk/tmp_set_new_video?roomid=<?php echo $item['roomid']?>"  class="btn btn-default btn-xs purple">合并</a>										
 <a href="http://api.1b1u.com/v2_5_0/live_desk/tmp_add_new_video?roomid=<?php echo $item['roomid']?>"  class="btn btn-default btn-xs purple">同步</a>
										<?php } ?>
										</td>

									  </tr>
									<?php endforeach;?>
									</tbody>
								</table>
								<div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>	

	<!-- /Page Body -->
</div>


<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">修改视频</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">视频名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="roomName" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">在线人数<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="people" type="text">
						</div>
					</div>					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="roomSort" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">房间封面图<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input name="uploadFile" id="uploadFile" onchange="uploadImgFilelive(this);" type="file">
							<input name="pic" type="hidden" />
						</div>
					</div>

					<div class="form-group">
						<input type="hidden" value="" name="video_id">
						<input class="close-button form-button" value="关闭" type="button">
						<input class="form-button" value="提交" type="submit">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal-backdrop fade in" style="display:none;"></div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url() ;?>assets/js/jquery.extend.js"></script>
<script src="<?php echo base_url() ;?>assets/js/admin/common.js"></script>
						
<script type="text/javascript">

function edit(id) {
	$.post("/admin/a/live/video/getOneData" ,{video_id:id} ,function(data) {
		var data = eval("("+data+")");
		console.log(data);
		$("input[name='roomName']").val(data.name);
		$("input[name='people']").val(data.people);	
		$("input[name='roomSort']").val(data.sort);		
		$("input[name='video_id']").val(data.id);
		$("input[name='pic']").val(data.pic);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	})
}

/**
 * @method ajax上传图片文件(文件上传地址统一使用一个)
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function uploadImgFilelive(obj) {
	var file_id = $(obj).attr("id");
	var inputObj = $(obj).nextAll("input[type='hidden']");
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadImgFilelive',
	    secureuri : false,
	    fileElementId : file_id,// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	    	fileId : file_id
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	inputObj.siblings(".uploadImg").remove();
		    	inputObj.after("<img class='uploadImg' src='" + data.msg + "' width='80'>");
		    	inputObj.val(data.msg);
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
	    }
	});
}
$("#addFormData").submit(function() {
	var id = $(this).find("input[name='video_id']").val();
	if (id.length ==0) {	
		alert("视频id错误");
		return false;
	}
		var url = "/admin/a/live/video/editVideo";

	$.post(url,$(this).serialize(),function(data){
		var data = eval("("+data+")");
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	})
	return false;
})
$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})
function delvideo(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/live/video/del_video",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}
function downvideo(id) {
	if (confirm("您确定要下架吗?")) {
		$.post("/admin/a/live/video/down_video",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}
function upvideo(id) {
	if (confirm("您确定要上架吗?")) {
		$.post("/admin/a/live/video/up_video",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}

//app首页推荐
function indext(id) {
	if (confirm("您确定要在app首页推荐该视频吗?")) {
		$.post("/admin/a/live/video/indexVideoInfo",{id:id},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		});
	}
}


$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
</script>



