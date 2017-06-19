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
			<li class="active">录播用户操作日志</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">录播用户操作日志</span>
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
											<th style="text-align:center">主播id</th>
											<th style="text-align:center" >房间名</th>
											<th style="text-align:center">操作时间</th>
											<th style="text-align:center">备注</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($logs as $item): ?>
       									 <tr>
           								     <td class="sorting_1" style="text-align:center"><?php echo $item['id'];?></td>
           								     <td class=" " style="text-align:center"><?php echo $item['anchor_id'];?></td>
            								     <td  style="text-align:center">
												 <?php echo $item['room_name']?>
												 </td>
            								     <td class=" " style="text-align:center"><?php echo date("Y-m-d H:i:s",$item['addtime']);?></td>
										 <td class=" " style="text-align:center" ><?php echo $item['content'];?></td>
										 
									  

									  </tr>
									<?php endforeach;?>
									</tbody>
								</table>
								<div class="pagination"></div>
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



