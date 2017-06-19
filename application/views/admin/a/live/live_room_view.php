<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">直播室管理</li>
		</ul>
	</div>
	<div class="table-toolbar" >
	
	
<font id="hints" style="color:blue" >600秒后自动刷新</font>	

<script type="text/javascript">
var t;
t=600;
function shua()
{
	t=t-1;
	if(t>=0){
		document.getElementById("hints").innerHTML="离下次刷新时间还有 "+t+" 秒";
	}else{
		document.getElementById("hints").innerHTML="正在刷新...";
	}
	if (t==0)
	{
		document.location.reload();
	}
}
setInterval(shua,1000);
</script> 
		<a id="shuaxing" href="<?php echo site_url('admin/a/live/live_room_manage/index')?>" class="btn btn-default" >手动刷新 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/live/live_room_manage/ajaxRoomList')?>" id='search_condition' class="form-inline clear" method="post">
			<ul>
				<li class="search-list">
					<span class="search-title">房间类型：</span>
					<span >
						<select name="attrid" style="width:110px">
							<option value="">请选择...</option>
							<?php foreach($all_room_attr as $v){ ?>
							<option value="<?php echo $v['categoryid'];?>"><?php echo $v['categoryname'];?></option>
							<?php } ?>
						</select>
					</span>
					
					<span class="search-title">app首页推荐：</span>
					<span >
						<select name="status" style="width:110px">
							<option value="">请选择...</option>
							<option value="1">未推荐</option>							
							<option value="2">已经推荐</option>
						</select>
					</span>					
					<span >
						<input type="submit" value="搜索" class="search-button" />
					</span>	
				</li>
			</ul>		
		</form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">修改直播室</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">房间名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="roomName" type="text">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">在线人数<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="peoples" type="text">
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
						<input type="hidden" value="" name="room_id">
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


<script>
var columns = [
			{field : 'roomid',title : '房间ID',width : '100',align : 'center'},
        		{field :false,title : '房间名称',align : 'center', width : '100',formatter:function(item){
        				if(item.status==2){
        					return item.room_name+"<br/><font color=red>[app首页推荐]</font>";
        				}else{
        					return item.room_name;
        				}
        		}},
        		{field :false,title : '封面',align : 'center', width : '100',formatter:function(item){
        				return '<img src="<?php echo trim(base_url(''),'/');?>'+item.pic+'" width="100px" />';
        		}},				
        		{field :false,title : '视频',align : 'center', width : '80',formatter:function(item){
        				if(item.live_status==1){
        					return "<iframe src='/admin/a/live/live_room_manage/getRoomInfo?room_id="+item.roomid+"&iframeid=list"+item.roomid+"' width=300px height=200px border=0px > </iframe>";
        					//return "<span id='list"+item.roomid+"'  width=300px height=200px></span><div style='display:none;'><iframe src='/admin/a/live/live_room_manage/getRoomInfo?room_id="+item.roomid+"&iframeid=list"+item.roomid+"' width=300px height=200px border=0px > </iframe></div>";							
        				}else{
        					return "<span font='blue'>空闲</span>";
        				}
        		}},			
        		//{field : 'starttime',title : '开始时间',align : 'center', width : '80'},
        		{field : 'anchor_name',title : '主播名称',align : 'center', width : '80'},
        		{field : 'user_id',title : '主播账号',align : 'center', width : '80'},
        		{field : 'starttime',title : '开播时间',align : 'center', width : '80' },
        		{field : 'usetime',title : '已直播时长',align : 'center', width : '40'},
        		{field : 'attrname',title : '标签',align : 'center', width : '40'},				
        		{field :false,title : '直播状态',align : 'center', width : '80',formatter:function(item){
        				if(item.live_status==1){
        					return "<span font='red'>正在直播</span>";
        				}else{
        					return "<span font='blue'>空闲</span>";
        				}
        		}},
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
					var button = '<a href="javascript:void(0);" onclick="edit('+item.room_id+');" class="btn btn-default btn-xs purple">修改封面</a>';					
        			button += '<a href="/admin/a/live/live_room_manage/lookRoomInfo?room_id='+item.roomid+'" target="_blank" class="btn btn-default btn-xs purple">查看直播</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.room_id+');" class="btn btn-default btn-xs purple">关闭房间</a>';
					if(item.status==1){
        			button += '<a href="javascript:void(0);" onclick="indext('+item.room_id+');" class="btn btn-default btn-xs purple">app首页推荐</a>';
					}else{
        			button += '<a href="javascript:void(0);" onclick="indext('+item.room_id+');" class="btn btn-default btn-xs purple">取消app首页推荐</a>';						
					}			
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/live/live_room_manage/ajaxRoomList',
	searchForm:'#search_condition',
});

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

function edit(id) {
	$.post("/admin/a/live/live_room_manage/getOneData" ,{room_id:id} ,function(data) {
		var data = eval("("+data+")");
		console.log(data);
		$("input[name='roomName']").val(data.room_name);
		$("input[name='peoples']").val(data.peoples);	
		$("input[name='roomSort']").val(data.sort);		
		$("input[name='room_id']").val(data.room_id);
		$("input[name='pic']").val(data.pic);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	})
}

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='room_id']").val();
	if (id.length ==0) {	
		alert("房间id错误");
		return false;
	}
		var url = "/admin/a/live/live_room_manage/editRoom";

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

//删除
function del(id) {
	if (confirm("您确定要关闭房间吗?")) {
		$.post("/admin/a/live/live_room_manage/lockRoomInfo",{room_id:id},function(json){
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
	if (confirm("您确定要在app首页推荐该房间吗?")) {
		$.post("/admin/a/live/live_room_manage/indexRoomInfo",{room_id:id},function(json){
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



$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})
</script>
<!--
<link href="http://vjs.zencdn.net/5.5.3/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/ie8/1.1.1/videojs-ie8.min.js"></script>
<script src="http://vjs.zencdn.net/5.5.3/video.js"></script>-->
