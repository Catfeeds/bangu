<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">文章列表</li>
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
								            <th>标题</th>
								            <th>添加时间</th>
								            <th>更新时间</th>
								            <th>排序</th>
								            <th>操作</th>
								        </tr>
								    </thead>
								    <tbody>
								    		<?php foreach ($art as $k=>$v){ ?>
								        		<tr>
										            <td><?php echo $v['id']; ?></td>
										            <td><?php echo $v['attr_name']; ?></td>
										            <td style="text-align:left;"><?php echo $v['title']; ?></td>
										            <td><?php echo $v['addtime']; ?></td>
										            <td><?php echo $v['modtime']; ?></td>
										            <td><?php echo $v['showorder']; ?></td>
							                        <td>
										            	<a href='javascript:void(0);' onclick="edit(<?php echo $v['id']; ?>)" class="btn btn-info btn-xs edit">编辑</a>
										          		<a href='javascript:void(0);' onclick="del(<?php echo $v['id']; ?>,'<?php echo $v['title']; ?>')" class="btn btn-danger btn-xs delete"> 删除</a>
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
				<form class="form-horizontal" role="form" id="article_form" method="post">
					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" id="art_category"  style="padding-top:7px;width:100px;text-align:right;">分类名</label>
						<div class="col-sm-8  col-xs-4 fl" >
							<select name="attr_name">
							<?php foreach ($article_attr as $k=>$v){?>
							<option value="<?php echo $v['id']; ?>"><?php echo $v['attr_name']; ?></option>
							<?php }?>
							</select>
						</div>
					</div>

					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">标题</label>
						<div class="col-sm-8 fl">
							<input class="form-control"  name="title" type="text" style="width:420px;">
						</div>
					</div>
					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">内容</label>
						<div class="col-sm-8 fl">
							<textarea rows="" cols="" id="editor" name="content" style="width:420px;"></textarea>
						</div>
					</div>
					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">排序</label>
						<div class="col-sm-8 fl">
							<input class="form-control"  name="showorder" type="text" style="width:420px;">
						</div>
					</div>
	               <input type="hidden" value="" name="updata">
					<input type="hidden" value="" name="art_id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input id="sub" onclick="insert_article()" class="btn btn-palegreen submit" value="提交" style="float: right; margin-right: 2%;" type="button">
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
					<form class="form-horizontal" role="form" id="nav_form" method="post">
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
	<!-- 编辑器 -->
	<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.config.js"></script>
   <script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.all.min.js"></script>
	<!-- /Page Body -->
	<script>

		$('.sub-delete').click(function(){
			id = $('input[name="del_id"]').val();
			$.post(
				"<?php echo site_url('admin/a/article/del_art')?>",
				{'id':id},
				function (data) {

					if (data) {
						alert('删除成功！');
						location.reload();
					} else {
						alert(data.msg);
					}
				}
			)

		})
		$('.bootbox-close-button').click(function(){
			$('.modal-backdrop').css('display','none');
			$('.bootbox').css('display','none');
			$('.box-info').hide();
		})

		function edit(id) {

			$.post(
				"<?php echo site_url('admin/a/article/get_art')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					var attrid = data.attrid;
					var title = data.title;
					var content = data.content;
					var showorder = data.showorder;
					$('input[name="title"]').val(title);
					$('textarea[name="content"]').val(content);
					$('input[name="showorder"]').val(showorder);
					$('input[name="updata"]').val('updata');
					$('input[name="art_id"]').val(data.id);
					var ue = UE.getEditor('editor');
					//对编辑器的操作最好在编辑器ready之后再做
					ue.ready(function() {
					    //设置编辑器的内容
					    ue.setContent(content);
					});

 				   $('.col-xs-4').remove();

					var str = '<div class="col-sm-8  col-xs-4" >';
					str += '<select name="attr_name"> ';
					<?php foreach ($article_attr as $k=>$v){?>
					var cate_id=<?php echo $v['id']; ?>;
					   if(cate_id==attrid){
					       str += '<option value="<?php echo $v['id']; ?>" selected = "selected" ><?php echo $v["attr_name"]; ?></option>';
					   }else{
						   str += '<option value="<?php echo $v['id']; ?>"  ><?php echo $v["attr_name"]; ?></option>';
						}
					<?php }?>
					str += '</select></div>';
					$('#art_category').after(str);



					$('.modal-backdrop').show();
					$('.bootbox').show();
				}
			)
		}
		function add () {

			$('input[name="title"]').val('');
			$('textarea[name="content"]').val('');
			$('input[name="showorder"]').val('');
			$('.modal-backdrop').show();
			$('.bootbox').show();

		}
	//插入文章分类
		function insert_article(){

			$.post(
					"<?php echo site_url('admin/a/article/insert_art')?>",
					$('#article_form').serialize(),
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
			$('.form-msg').html('您确定要删除文章的&nbsp;<span style="color:red;">'+name+'</span>&nbsp;吗？');
			$('input[name="del_id"]').val(id);
			$('.box-info').show();
			$('.modal-backdrop').show();
		}
	    var ue = UE.getEditor('editor');
	</script>


