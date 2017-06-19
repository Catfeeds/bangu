<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i> 
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">版块管理</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sale/plate/getPlate')?>" id='search_condition' class="search_condition_form" method="post">
			<input type="text" name="type_name" placeholder="输入版块名称搜索" />
			<input type="hidden" name="page_new" class="page_new" />
			<input type="submit" class="input_button" value="搜索" />
		</form>
		<div class="dataTables_wrapper form-inline no-footer">
			<table class="table table-striped table-hover table-bordered dataTable no-footer" >
				<thead id="pagination_title"></thead>
				<tbody id="pagination_data"></tbody>
			</table>
		</div>
		<div class="pagination" id="pagination"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">新增版块</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">版块名称<span class="input-must">*</span></label>
						<div class="col-sm-8 col_ts">
							<input class="form-control" name="typeName" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序<span class="input-must">*</span></label>
						<div class="col-sm-8 col_ts">
							<input class="form-control inputNumber" maxlength="4"  name="sort" type="text">
						</div>
					</div>
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片<span class="input-must">*</span></label>
						<div class="col-sm-8">
							 <input name="single_water" id="single_water" onchange="uploadImgFile(this)" type="file" style="float: left;margin:4px auto;">
                             <input name="plate_pic" type="hidden" id="plate_pic" />
                             <img id="show_pic" width="80" />
						</div>
					</div>
					
					<div class="form-group">
						<input type="hidden" value="" name="id">
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
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script>
//上传图片
function uploadImgFile(obj)
{
	var inputname = $(obj).attr("name");
	var hiddenObj = $(obj).nextAll("input[type='hidden']");

	var formData = new FormData($("#addFormData" )[0]);
	formData.append("inputname", inputname);
	$.ajax({
			type : "post",
			url : "/admin/a/sale/plate/upload_img",
			data : formData,
			dataType:"json",
			async: false,
      		cache: false,
      		contentType: false,
      		processData: false,
			success : function(data) {

				if(data.code=="2000")
				{
					hiddenObj.val(data.imgurl);
					$("#show_pic").hide();
					$(obj).parent().append("<img src='"+data.imgurl+"' width='80' />");
					$(obj).parent().parent().find(".olddiv").hide();
				}
				else
					alert(data.msg);
			},
			error:function(data){
				alert('请求异常');
			}
		});
}


var columns = [ {field : 'typeName',title : '版块名称',width : '120',align : 'center'},
        		{field : null,title : '图片' ,width : '120' ,align : 'center',formatter: function(item) {
            		var bangu_url="<?php echo base_url();?>";
        			var img = '<a href="javascript:void(0);" onclick=""><img src='+bangu_url+item.pic+' style="width:100px;" /></a>&nbsp;';
        			
        			return img;
        		}
	            },
        		
        		{field : 'sort',title : '排序',align : 'center', width : '160' ,length:15},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '<a href="javascript:void(0);" onclick="edit('+item.typeId+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			button += '<a href="javascript:void(0);" onclick="del('+item.typeId+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
ajaxGetData(columns ,inputId);

//搜索
$('#search_condition').submit(function(){
	$('input[name="page_new"]').val(1);
	ajaxGetData(columns ,inputId);
	return false;
})

//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[type='hidden']").val('');
	$("select[name='ishome']").val(0);
	$("#show_pic").attr("src","");
	$(".bootbox,.modal-backdrop").show();
	$(".modal-title").html('新增版块');
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/sale/plate/edit";
	} else {
		var url = "/admin/a/sale/plate/add";
	}
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

function edit(id) {
	$(".modal-title").html('编辑版块');
	$.post("/admin/a/sale/plate/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='typeName']").val(data.typeName);
		$("input[name='sort']").val(data.sort);
		$("input[name='plate_pic']").val(data.pic);
		$("input[name='id']").val(data.typeId);
		var bangu_url="<?php echo base_url();?>";
		$("#show_pic").attr("src",bangu_url+data.pic);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sale/plate/delete",{id:id},function(json){
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
