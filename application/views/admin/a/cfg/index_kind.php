<style type="text/css">
.page-content{ min-width: auto !important; }
</style>

<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>首页一级分类</li>
	</ul>
	<div class="page-body">
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<div class="form-box fb-body">
	<div class="fb-content">
		<div class="box-title">
			<h4>首页一级分类</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form">
			<form method="post" action="#" id="add-data" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">分类名称：<i>*</i></div>
					<div class="fg-input">
						<input type="text" name="name" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">图片：<i>*</i></div>
					<div class="fg-input">
						<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
						<input name="pic" type="hidden" />
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">目的地：</div>
					<div class="fg-input">
						<select name="dest_id">
							<option value="0">请选择</option>
							<?php
								foreach($destData as $val) {
									echo '<option value="'.$val['id'].'">'.$val['kindname'].'</option>';
								}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">排序：</div>
					<div class="fg-input"><input type="text" name="showorder" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">备注：</div>
					<div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否显示：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_show" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_show" checked="checked" value="1">是</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">是否可更改：</div>
					<div class="fg-input">
						<ul>
							<li><label><input type="radio" class="fg-radio" name="is_modify" value="0">否</label></li>
							<li><label><input type="radio" class="fg-radio" name="is_modify" checked="checked" value="1">是</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<input type="hidden" name="id" />
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script>
var columns = [ {field : 'name',title : '分类名称',width : '120',align : 'center' ,length:20},
                {field : 'kindname',title : '目的地',width : '120',align : 'center'},
                {field : null,title : '大图',width : '120',align : 'center',formatter:function(item){
						return "<a href='"+item.pic+"' target='_blank'>图片预览</a>";
                    }
                },
                {field : null,title : '小图',width : '120',align : 'center',formatter:function(item){
						return "<a href='"+item.smallpic+"' target='_blank'>图片预览</a>";
	                }
	            },
        		{field : null ,title : '是否显示' ,width : '100' ,align : 'center',formatter:function(item){
        				return item.is_show == 1 ? '是' : '否';
        			}
        		},
        		{field : null,title : '是否可更改',width : '100',align : 'center',formatter:function(item){
        				return item.is_modify == 1 ? '是' :'否';
        			}
        		},
        		{field : 'showorder',title : '排序',align : 'center', width : '80'},
        		{field : 'beizhu',title : '备注',align : 'center', width : '160' ,length:15},
        		{field : null,title : '操作',align : 'center', width : '150',formatter: function(item) {
//         			if (item.is_modify == 1) {
        				return '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">修改</a>&nbsp;';
//         			} else {
//             			return '';
//             		}
        		}
        	}];
$("#dataTable").pageTable({
	columns:columns,
	url:'/admin/a/cfg/index_kind/getIndexkindJson',
	pageNumNow:1,
	tableClass:'table-data'
});

//添加弹出层
$("#add-button").click(function(){
	var formObj = $("#add-data");
	formObj.find('input[type=text]').val('');
	formObj.find('input[type=hidden]').val('');
	formObj.find('textarea').val('');
	formObj.find("input[name='is_show'][value=1]").attr("checked",true);
	formObj.find("input[name='is_modfiy'][value=1]").attr("checked",true);
	formObj.find("select").val(0);
	$('.uploadImg').remove();
	$(".fb-body,.mask-box").show();
})

$("#add-data").submit(function() {
	var id = $(this).find("input[name='id']").val();
	var url = id >0 ? '/admin/a/cfg/index_kind/edit' : '/admin/a/cfg/index_kind/add';
	$.ajax({
			url:url,
			type:'post',
			dataType:'json',
			data:$(this).serialize(),
			success:function(data){
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns,
						url:'/admin/a/cfg/index_kind/getIndexkindJson',
						pageNumNow:1,
						tableClass:'table-data'
					});
					alert(data.msg);
					$(".fb-body,.mask-box").hide();
				} else {
					alert(data.msg);
				}
			}
		});
	return false;
})

function edit(id) {
	$.ajax({
		url:'/admin/a/cfg/index_kind/getDetailJson',
		type:'post',
		dataType:'json',
		data:{id:id},
		success:function(data){
			if (!$.isEmptyObject(data)) {
				$("input[name='name']").val(data.name);
				$("select[name='dest_id']").val(data.dest_id);
				$("input[name='id']").val(data.id);
				$("input[name='pic']").val(data.pic);
				$("input[name='showorder']").val(data.showorder);
				$("textarea[name='beizhu']").val(data.beizhu);
				$("input[name='is_show'][value="+data.is_show+"]").attr("checked",true);
				$("input[name='is_modfiy'][value="+data.is_modfiy+"]").attr("checked",true);
				$(".uploadImg").remove();
				$("#uploadFile").after("<img class='uploadImg' src='" + data.pic + "' width='80'>");
				$(".fb-body,.mask-box").show();
			}
		}
	});
}
</script>
