<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<style type="text/css">
	.col_span{ float: left;margin-top: 6px}
	.col_ip{ float: left; }
.col-sm-10{width: 76.333%}
.modal{ position: fixed;}
</style>
<script src="//api.html5media.info/1.2.2/html5media.min.js"></script>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">视频列表</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->

				
						<div class="widget-header ">
							<span class="widget-caption">视频列表</span>
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
										<form class="form-inline" role="form"  method="get" action="<?php echo site_url('admin/a/live/video/index')?>">
										    <div class="form-group dataTables_filter col_ip" >

										        <input type="text" class="form-control" placeholder="视频名" name="name" value="<?php echo $name;?>">
										    </div>
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >

										        <input type="text" class="form-control" placeholder="主播名"  name="anchorname" value="<?php echo $anchorname;?>">
										    </div>
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >

										        <input type="text" class="form-control" placeholder="主播手机号"  name="mobile" value="<?php echo $mobile;?>">
										    </div>	
										    <div class="form-group dataTables_filter col_ip"style="padding-left:15px;" >
												<input type="text" id="starttime"  class="search-input" style="width:110px;" value="<?php echo $starttime;?>" name="starttime" placeholder="开始日期" />
												<input type="text" id="endtime"  class="search-input" style="width:110px;" value="<?php echo $endtime;?>"  name="endtime" placeholder="结束日期" />
										    </div>											
										    <div class="checkbox col_ip" style="margin-top:0px; padding-right:15px;" >

										        <label><span class=" col_span">房间类型</span>
												<select name="attr_id"  class="form-control input-sm " style="width:100px;float:left;">
													<option value="">请选择...</option>
													<?php foreach($all_room_attr as $v){ ?>
													<option value="<?php echo $v['categoryid'];?>"  <?php if($v['categoryid'] == $attr_id) echo "selected='selected'";?> ><?php echo $v['categoryname'];?></option>
													<?php } ?>
												</select>											
											
										        </label>
										    </div>
										    <div class="checkbox col_ip" style="margin-top:0px; padding-right:15px;" >

										        <label><span class=" col_span">状态</span>
												<select name="status"  class="form-control input-sm " style="width:100px;float:left;">
													<option value="2" <?php if(2 == $status) echo "selected='selected'";?>>已上架</option>
													<option value="1" <?php if(1 == $status) echo "selected='selected'";?>>已下架</option>	
													<option value="3" <?php if(3 == $status) echo "selected='selected'";?>>已删除</option>
													<option value="4" <?php if(4 == $status) echo "selected='selected'";?>>app首页推荐</option>													
												</select>											
											
										        </label>
										    </div>	
											
											
										    <button type="submit" class="btn btn-default" style="float:left;">
										        	搜索
										    </button>
										</form>	
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
											<th style="text-align:center">第三方视频id/房间id</th>
											<th style="text-align:center">标签</th>
											<th style="text-align:center" >视频</th>
											<th style="text-align:center">视频名</th>
											<th style="text-align:center">封面图</th>
											<th style="text-align:center">app首页推荐封面图</th>											
											<th style="text-align:center">添加时间</th>
											
											<th style="text-align:center">时长</th>
											<th style="text-align:center">观众人数</th>
											<th style="text-align:center">收藏数</th>
											<th style="text-align:center">主播名</th>
											<th style="text-align:center">手机号</th>
											<th style="text-align:center">关联线路id</th>	
											<th style="text-align:center">目的地id/名</th>												
											<th style="text-align:center">操作</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($pageData as $item): ?>
       									 <tr>
           								     <td class="sorting_1" style="text-align:center"><?php echo $item['id'];?></td>
											 <td class=" " style="text-align:center"><?php echo $item['record_id'];?>/<?php echo $item['room_id'];?></td>
           								     <td class=" " style="text-align:center"><?php echo $item['attrname'];?></td>
            								     <td title="<?php echo $item['video']?>" style="text-align:center">
												 
<video src="<?php echo $item['video']?>" width="320" height="200" controls preload></video>

												 </td>
            								     <td title="<?php echo $item['name']?>" style="text-align:center">
												 <?php echo $item['name']?>
												 <?php if($item['status']==3){ ?>
												 <br/><font color=red>[app首页推荐]</font>
												 <?php } ?>
												 </td>
            								     <td class=" " style="text-align:center">
												 <?php if($item['pic']){?>
												 <img src="<?php echo (strpos($item['pic'],'http://')===0)?$item['pic']:trim(base_url(''),'/').$item['pic'];?>" width="100px" />
												 <?php } ?>
												 </td>
            								     <td class=" " style="text-align:center">
												 <?php if($item['app_index_tui_pic']){?>
												 <img src="<?php echo (strpos($item['app_index_tui_pic'],'http://')===0)?$item['app_index_tui_pic']:trim(base_url(''),'/').$item['app_index_tui_pic'];?>" width="100px" />
												 <?php } ?>
												 </td>
												 												 
            								     <td class=" " style="text-align:center"><?php echo date("Y-m-d H:i:s",$item['addtime']);?></td>
									     <td class=" " style="text-align:center"><?php echo $item['time'];?></td>
										 <td class=" " style="text-align:center" ><?php echo $item['people'];?></td>
										 
									     <td class=" " style="text-align:center"><?php echo $item['collect'];?></td>
									     <td title=""><?php echo $item['anchorname']?></td>
									     <td title=""><?php echo $item['mobile']?></td>	
									     <td title=""><?php echo $item['line_ids']?></td>	
									     <td title=""><?php echo $item['dest_id']?>/<?php echo $item['dest_name']?></td>											 
									    <td class=" " style="text-align:center">

										<?php if($item['status']==1){?>
									    <a href="javascript:void(0);" onclick="downvideo('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">下架</a>
										<?php }else if($item['status']==2){ ?>
										
										<?php }else{?>
									    <a href="javascript:void(0);" onclick="upvideo('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">上架</a>
										<?php } ?>
									
										<?php if($item['status']!=2){?>
										<a href="javascript:void(0);" onclick="edit('<?php echo $item['id'];?>');" class="btn btn-default btn-xs purple">修改视频</a>										
									    <a href="javascript:void(0);" onclick="delvideo('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">删除</a>
										<?php if($item['status']!=3){?>
									    <a href="javascript:void(0);" onclick="indext('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">app首页推荐</a>										
										<?php }else if($item['status']==3){ ?>
									    <a href="javascript:void(0);" onclick="indext('<?php echo $item['id'];?>');"  class="btn btn-default btn-xs purple">取消app首页推荐</a>
										<?php } ?>											
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
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">视频分类<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<select name="vattrid" id="vattrid"  class="form-control input-sm " style="width:100px;float:left;">
								<option value="">请选择...</option>
								<?php foreach($all_room_attr as $v){ ?>
								<option value="<?php echo $v['categoryid'];?>" ><?php echo $v['categoryname'];?></option>
								<?php } ?>
							</select>						
						</div>
					</div>					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">视频名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="roomName" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">关联线路id<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="line_ids" id="line_ids" type="text">(多个线路id用英文状态的逗号[,]隔开)
						</div>
					</div>					

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">目的地<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<span id="destname"></span>
							<div class="fg-input" id="add-city"></div>
							<!--<input class="search-input" placeholder="目的地" id="destinations" name="kindname" type="text">
							<input name="destid" id="destid" value="" type="hidden">-->
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
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">点赞数<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="likenum" type="text">
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
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">app首页推荐封面图<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input name="uploadFile1" id="uploadFile1" onchange="uploadImgFilelive(this);" type="file">
							<input name="app_index_tui_pic" type="hidden" />
						</div>
					</div>					

					<div class="form-group">
					<input type="hidden" name="city_name" />
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
<link href="<?php echo base_url() ;?>assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<script src="<?php echo base_url() ;?>assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
						
<script type="text/javascript">
//目的地
/*$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
	var data = eval('(' + data + ')');
	var array = new Array();
	$.each(data, function(key, val) {
		array.push({
		    text : val.kindname,
		    value : val.id,
		    jb : val.simplename,
		    qp : val.enname
		});
	})
	var comboBox = new jQuery.comboBox({
	    id : "#destinations",
	    name : "destid",// 隐藏的value ID字段
	    query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
	    selectedAfter : function(item, index) {// 选择后的事件

	    },
	    data : array
	});
})
*/
//获取目的地
$.ajax({
	url:'/common/selectData/getDestAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
		$('#search-city').selectLinkage({
			jsonData:data,
			width:'110px',
			names:['country','province','city']
		});
		$('#add-city').selectLinkage({
			jsonData:data,
			width:'131px',
			names:['country','province','city'],
			callback:function(){
				$("#add-city").change(function(){

				})
			}
		});
	}
});
function edit(id) {
	$.post("/admin/a/live/video/getOneData" ,{video_id:id} ,function(data) {
		var data = eval("("+data+")");
		console.log(data);
		$("#vattrid").val(data.attr_id);
		$("#destname").html('当前是：'+data.dest_name);
		$("#line_ids").val(data.line_ids);		
		$("input[name='roomName']").val(data.name);
		$("input[name='people']").val(data.people);	
		$("input[name='roomSort']").val(data.sort);
		$("input[name='likenum']").val(data.like_num);		
		$("input[name='video_id']").val(data.id);
		$("input[name='pic']").val(data.pic);
		$("input[name='app_index_tui_pic']").val(data.app_index_tui_pic);		
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$("#uploadFile1").after("<img class='uploadImg' src='" + data.app_index_tui_pic + "' width='80'>");		
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



