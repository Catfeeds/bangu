<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">首页分类目的地线路设置</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sc_cfg/sc_dest_line/getDestLineData')?>" id='search_condition' class="search_condition_form" method="post">
			<!-- <span id="search_dest"></span>
			<input type="text" name="search_name" class="input_text" placeholder="线路名称" />
			<span id="search_start"></span>
			<input type="submit" class="input_button" value="搜索" /> -->
		</form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">首页分类目的地线路</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">分类目的地<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<span id="addDestForm"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">线路名称<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<input class="form-control" id="ChoiceLine" name="linename" readonly="readonly" type="text">
							<input type="hidden" name="line_id" />
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片</label>
						<div class="col-sm-10">
							<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
							<input name="pic" type="hidden" />
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否显示</label>
						<div class="col-sm-10">
							<select name="is_show" style="width:100%;">
								<option value="0">不显示</option>
								<option value="1" selected="selected">显示</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">是否更改</label>
						<div class="col-sm-10">
							<select name="is_modify" style="width:100%;">
								<option value="0">可更改</option>
								<option value="1">不可更改</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">备注 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="beizhu" rows="6" style="width:100%;"></textarea>
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
<?php echo $this->load->view('admin/a/choice_data/choice_line.php');  ?>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [ {field : 'linename',title : '线路名称',width : '250',align : 'center'},
                {field : 'kindname',title : '目的地',width : '75',align : 'center'},
                {field : false,title : '图片',width : '120',align : 'center',formatter:function(item){
			return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                    }
                },
        		{field : false ,title : '是否显示' ,width : '100' ,align : 'center',formatter:function(item){
        				return showArr[item.is_show];
        			}
        		},
        		{field : false,title : '是否可更改',width : '100',align : 'center',formatter:function(item){
        				return modifyArr[item.is_modify];
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : 'beizhu',title : '备注',align : 'center', width : '160' },
        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			if (item.is_modify == 0) {
        				button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			}
        			button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/sc_cfg/sc_dest_line/getDestLineData',
	searchForm:'#search_condition',
});


$.post("/admin/a/sc_cfg/sc_dest_line/getKindDestJson",{},function(data){
	var data = eval("("+data+")");
	var html = '<select name="kind_id" style="width:140px;"><option value="0">请选择分类目的地</option>';
	$.each(data ,function(key ,val){
		html += '<option value="'+val.id+'">'+val.name+'</option>';
	})
	html += '</select>'
	$("#search_dest").html(html);
	$("#addDestForm").html(html);

	$("select[name='kind_id']").change(function(){
		var kind_id = $(this).val();
		$(this).next("select").remove();

		if (kind_id > 0) {
			var str = '<select name="sc_dest_id" style="width:200px;"><option value="0">请选择分类目的地</option>';
			$.each(data[kind_id]['lower'] ,function(k ,v){
				str += '<option value="'+v.dest_id+'" data-dest="'+v.dest_id+'">'+v.name+'</option>';
			})
			str += '</select>';
		}
		$(this).after(str);

		$("select[name='sc_dest_id']").change(function(){
			$("input[name='linename']").val('');
			$("input[name='line_id']").val('');
		})
	})

})


//添加数据弹出
$("#addData").click(function(){
	$("#addFormData").find("input[type='text']").val('');
	$("#addFormData").find("input[type='hidden']").val('');
	$("select[name='is_show']").val(1);
	$("select[name='is_modify']").val(0);
	$(".uploadImg").remove();
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/sc_cfg/sc_dest_line/edit";
	} else {
		var url = "/admin/a/sc_cfg/sc_dest_line/add";
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
	$.post("/admin/a/sc_cfg/sc_dest_line/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		$("input[name='id']").val(data.id);
		$("#addFormData").find("input[name='pic']").val(data.pic);
		$("input[name='showorder']").val(data.showorder);
		$("textarea[name='beizhu']").val(data.beizhu);
		$("select[name='is_show']").val(data.is_show);
		$("select[name='is_modify']").val(data.is_modify);
		$("#addDestForm").find("select[name='kind_id']").val(data.index_kind_id).change();
		$("#addDestForm").find("select[name='sc_dest_id']").val(data.dest_id);
		$("input[name='linename']").val(data.linename);
		$("input[name='line_id']").val(data.line_id);
		$(".uploadImg").remove();
		$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/kind_dest_line/delete",{id:id},function(json){
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
//筛选线路
$("#ChoiceLine").click(function(){
	var destid = $("#addFormData").find("select[name='sc_dest_id'] :selected").attr("data-dest");
	if (typeof destid == 'undefined' || destid < 1) {
		var destid = $("#addFormData").find("select[name='destTwo']").val();
		if (typeof destid == 'undefined' || destid < 1) {
			alert('请选择目的地');
			return false;
		}
	}
	$("input[name='line_dest']").val(destid);
	createDataHtml();
})
//确认选择线路
$(".submit_choice").click(function(){
	var actObj = $("#choiceLineBox").find(".choice_content").children(".cl_active");
	var id = actObj.attr("data-val");
	var name = actObj.attr("data-name");
	$("#addFormData").find("input[name='line_id']").val(id);
	$("#addFormData").find("input[name='linename']").val(name);
	$("#choiceLineBox").hide();
})

$(".close-button").click(function(){
	$(".bootbox,.modal-backdrop").hide();
})
</script>
