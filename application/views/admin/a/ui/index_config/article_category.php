<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">文章分类</li>
		</ul>
	</div>
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<!-- <div class="well with-header with-footer"> -->
						<div class="table-toolbar">
							<a id="add_expert" href="javascript:void(0);" class="btn btn-default" onclick="add()"> 添加 </a>
						</div>
                       	<div class="tab-content">
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>编号</th>
								            <th>分类名</th>
								            <th>是否显示</th>
								            <th>排序</th>
								            <th>操作</th>
								        </tr>
								    </thead>
								    <tbody>
								    		<?php foreach ($article_attr as $k=>$v){ ?>
								        		<tr>
										            <td><?php echo $v['id']; ?></td>
										            <td><?php echo $v['attr_name']; ?></td>
										            <td><?php if($v['ishome']==1){echo '是';}elseif($v['ishome']==0){echo '否';} ?></td>
										            <td><?php echo $v['showorder']; ?></td>
							                       			 <td>
										            	<a href='javascript:void(0);' onclick="edit(<?php echo $v['id']; ?>)" class="btn btn-info btn-xs edit"> 编辑</a>
										          		<a href='javascript:void(0);' onclick="del(<?php echo $v['id']; ?> , '<?php echo $v['attr_name']; ?>')" class="btn btn-danger btn-xs delete"> 删除</a>
										            </td>
									        	</tr>
									        <?php }?>
								    </tbody>
								</table>
							<div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>
	<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog" style="position:absolute;left:50%;margin-left:-300px;">
			<div class="modal-content" style="width:600px;">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">文章分类</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
				<form class="form-horizontal" role="form" id="category_form" method="post">
					<div class="form-group">
						
						<div class="col-sm-10 fr">
							<input class="form-control"  name="attr_name" type="text" style="width:470px;">
						</div>
                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right fr" style="padding-top:7px;">分类名</label>
					</div>

					<div class="form-group">
						
						<div class="col-sm-10 fr">
							<input class="form-control"  name="showorder" type="text" style="width:470px;">
						</div>
                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right fr" style="padding-top:7px;">排序</label>
					</div>

					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" id="is_show" style="padding-top:7px;width:100px;text-align:right;">是否显示</label>
						<div class="col-lg-4 col-sm-4 col-xs-4 fl" >
							<div class="radio">
							<label><input  class="colored-success" type="radio" value="1" name="is_show"><span class="text">显示</span></label>
							</div>
						</div>
						<div class="col-lg-4 col-sm-4 col-xs-4 fl" >
							<div class="radio">
							<label><input  class="colored-success"  type="radio" checked="checked"  value="0" name="is_show"><span class="text">不显示</span></label>
							</div>
						</div>
					</div>
					<input type="hidden" value="" name="updata">
					<input type="hidden" value="" name="cate_id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input id="sub" onclick="insert_article_category()" class="btn btn-palegreen submit" value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div style="display:none;position:absolute;overflow:visible;" class="modal fade in box-info" >
		<div class="modal-dialog" style="margin:30px auto;width:600px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">提示信息</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" role="form" id="del_form" method="post">
					<div class="form-group form-msg" style='margin-left: 30px;font-size: 14px;font-weight: 600;color: #ff7700;'>
						您确定要删除
					</div>
					<input type="hidden" value="" name="del_id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input class="btn btn-palegreen sub-delete" value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade in" style="display:none;"></div>
	<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
	<!-- /Page Body -->
	<script>

		$('.sub-delete').click(function(){
			id = $('input[name="del_id"]').val();
			$.post(
				"<?php echo site_url('admin/a/article/del_cate')?>",
				{'id':id},
				function (data) {

					if (data) {
						alert('删除成功');
						location.reload();
					} else {
						alert('删除失败');
						location.reload();
					}
				}
			);

		})
		$('.bootbox-close-button').click(function(){
			$('.modal-backdrop').css('display','none');
			$('.bootbox').css('display','none');
			$('.box-info').hide();
		})

		var nshow = ['不显示','显示'];
		function edit(id) {

			$.post(
				"<?php echo site_url('admin/a/article/get_category')?>",
				{'id':id},
				function(data) {

					data = eval('('+data+')');
					var attr_name = data.attr_name;
					var ishome = data.ishome;
					var showorder = data.showorder;
					$('input[name="attr_name"]').val(attr_name);

					$('input[name="showorder"]').val(showorder);
					$('input[name="updata"]').val('updata');
					$('input[name="cate_id"]').val(data.id);

 				   $('.col-xs-4').remove();
					$.each(nshow ,function (key ,val) {
						if (key == data.ishome) {
							var mchecked = "checked='checked'";
						} else {
							var mchecked = '';
						}
						var str = '<div class="col-lg-4 col-sm-4 col-xs-4 "  >';
						str += '<div class="radio"> ';
						str += '<label><input class="colored-success" '+mchecked+' type="radio" value="'+key+'" name="is_show"><span class="text">'+val+'</span></label>';
						str += '</div></div>';
						$('#is_show').after(str);
					});

					$('.modal-backdrop').show();
					$('.bootbox').show();
				}
			)
		}
		function add () {
			$('input[name="attr_name"]').val('');
			$('input[name="showorder"]').val('');
			$('input[name="updata"]').val('');
			$('input[name="cate_id"]').val('');
			$('.modal-backdrop').show();
			$('.bootbox').show();
		}
	//插入文章分类
		function insert_article_category(){
			$.post(
					"<?php echo site_url('admin/a/article/insert_artCategory')?>",
					$('#category_form').serialize(),
					function(data) {
					   data = eval('('+data+')');
					    if (data.status == 1) {
						alert(data.msg);
						location.reload();
					    } else {
						alert(data.msg);
					}
				    }
				);


			return false;
		}


	    function del(id ,name) {
			$('.form-msg').html('您确定要删除文章分类的&nbsp;<span style="color:red;">'+name+'</span>&nbsp;吗？');
			$('input[name="del_id"]').val(id);
			$('.box-info').show();
			$('.modal-backdrop').show();
		}

	</script>


