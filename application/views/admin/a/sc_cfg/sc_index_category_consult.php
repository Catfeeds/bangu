<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li>
				<i class="fa fa-home"> </i>
				<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
			</li>
			<li class="active">深窗首页分类咨询配置</li>
		</ul>
	</div>
	<div class="table-toolbar">
		<a id="addData" href="javascript:void(0);" class="btn btn-default">添加 </a>
	</div>
	<div class="tab-content">
		<form action="<?php echo site_url('admin/a/sc_cfg/sc_index_category/getDataList')?>" id='search_condition' class="search_condition_form" method="post"></form>
		<div id="dataTable"></div>
	</div>
</div>

<div style="display:none;" class="bootbox modal fade in" >
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close-button close" >×</button>
				<h4 class="modal-title">深窗首页分类咨询配置</h4>
			</div>
			<div class="modal-body">
				<div class="bootbox-body">
					<form class="form-horizontal" role="form" id="addFormData" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">分类模块<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<select name="category" id="category">
								<option value="">请选择</option>
								<?php foreach($category AS $k=>$val):?>
									<option value="<?php echo $val['id']?>"><?php echo $val['name']?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				<!--  <div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">属性标签<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<select name="article_attr" id="article_attr">
								<option value="">请选择</option>
								<?php foreach($article_attr AS $k=>$val):?>
									<option value="<?php echo $val['id']?>"><?php echo $val['attrname']?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>-->
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">资讯<span class="input-must">*</span></label>
						<div class="col-sm-10 col_ts">
							<select name="consult" id="consult">
								<option value="">请选择</option>
								<?php foreach($consult AS $k=>$val):?>
									<option value="<?php echo $val['id']?>"><?php echo $val['title']?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">是否置顶</label>
						<div class="col-sm-10 col_ts" id="top_div">
							<input type="radio" name="is_top" value="1" style="width:15px;height:15px;position:initial;opacity:1;" > 是
							<input type="radio" name="is_top"  value="0" style="width:15px;height:15px;position:initial;opacity:1;" checked="checked"> 否
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control inputNumber" placeholder="请输入正整数" maxlength="5"  name="showorder" type="text">
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
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<?php echo $this->load->view('admin/a/choice_data/choice_line.php');  ?>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
var columns = [
		/*{field : 'sca_name',title : '分类名称',width : '100',align : 'center'},*/
        		{field : 'sc_name',title : '模块名称',width : '100',align : 'center'},
        		{field : 'showorder',title : '排序',width : '100',align : 'center'},
        		{field : 'uc_title',title : '资讯',width : '100',align : 'center'},
        		{field : false,title : '置顶',width : '100',align : 'center',
        			 formatter : function(item) {
							if(item.is_top==1){
								return '是';
						   }else{
								return '否';
						   }
						 }
            	},

        		{field : false,title : '操作',align : 'center', width : '150',formatter: function(item) {
        			var button = '';
        			     button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="btn btn-default btn-xs purple">修改</a>&nbsp;';
        			    button += '<a href="javascript:void(0);" onclick="del('+item.id+');" class="btn btn-default btn-xs purple">删除</a>';
        			return button;
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/sc_cfg/sc_index_category_consult/getDataList',
	searchForm:'#search_condition',
});


//添加数据弹出
$("#addData").click(function(){
	$("input[name='id']").val('');
	$("input[name='showorder']").val('');
	$("#category").val('');
	$("#article_attr").val('');
	$("#consult").val('');
	$(".bootbox,.modal-backdrop").show();
})

$("#addFormData").submit(function() {
	var id = $(this).find("input[name='id']").val();
	if (id.length > 0) {
		var url = "/admin/a/sc_cfg/sc_index_category_consult/edit";
	} else {
		var url = "/admin/a/sc_cfg/sc_index_category_consult/add";
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
	$.post("/admin/a/sc_cfg/sc_index_category_consult/getOneData" ,{id:id} ,function(data) {
		var data = eval("("+data+")");
		 //-------------是否置顶----------------
		 var checked0='';
		 var checked1='';
		 if(data.is_top==1){
			     checked0='checked="checked"';
			}else if(data.is_top==0){
				 checked1='checked="checked"';
			}
		 var locationstr='<input type="radio" name="is_top" value="1" '+checked0+' style="width:15px;height:15px;position:initial;opacity:1;" >是';
		 locationstr=locationstr+'<input type="radio" name="is_top"'+checked1+' value="0" style="width:15px;height:15px;position:initial;opacity:1;">否';
		 $('#top_div').html(locationstr);
		//---------------end--------------
		$("input[name='id']").val(data.id);
		$("input[name='showorder']").val(data.showorder);
		$("select[name='category']").val(data.sc_index_category_id);
		$("select[name='article_attr']").val(data.article_attr_id);
		$("select[name='consult']").val(data.consult_id);
		$(".bootbox,.modal-backdrop").show();
	})
}

//删除
function del(id) {
	if (confirm("您确定要删除吗?")) {
		$.post("/admin/a/sc_cfg/sc_index_category_consult/delete",{id:id},function(json){
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
