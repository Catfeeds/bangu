<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active"> 友情链接管理</li>
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
                       	<form action="#" id='search_dest_line' method="post">

							<div class="col-xs-2">
								<div>
									<input type="text" class="form-control" placeholder="链接名" name="search_name">
								</div>
							</div>
							<button type="button" class="btn btn-darkorange active" id="search_submit" style="margin: -2px 0 0 30px;">搜索</button>

						</form>
						<br/>
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>链接名</th>
 								            <th>链接地址</th>
								            <th>链接类型</th>
								            <th>图片</th>
								            <th>排序</th>
								            <th>操作</th>
								        </tr>
								    </thead>
								    <tbody class='tbody_data'>
								    		<?php foreach($list as $val): ?>
								        		<tr>									            
										            <td ><?php echo $val['name']?></td>
										            <td><?php echo $val['url']?></td>
										            <td><?php echo $val ['link_type']?></td>
										            <td><?php echo $val ['icon'] ?></td>
										            <td><?php echo $val ['showorder']?></td>
										            <td>
										            	<a href='#' onclick="edit(<?php echo $val ['id']?>)" class="btn btn-info btn-xs edit"> 编辑</a>
										          		<a href='#' onclick="del(<?php echo $val ['id']?> )" class="btn btn-danger btn-xs delete"> 删除</a>
										            </td>
									        	</tr>
									        <?php endforeach;?>
								    </tbody>
								</table>
								<div class="pagination"><?php echo $page_string?></div>
							</div>
						</div>
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>
	<!-- 添加体验师 -->
	<div style="display:none;" class="bootbox modal fade in" >
		<div class="modal-dialog" style="position:absolute;left:50%;margin-left:-300px;">
			<div class="modal-content" style="width:600px;">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">添加友情链接</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" id="form_data" method="post">
					<div class="form-group form-input clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">链接名</label>
						<div class="col-sm-8 fl" >
							<input class="form-control"  name="name"   type="text" style="width:420px;">
						</div>
					</div>
					<div class="form-group form-input clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">链接</label>
						<div class="col-sm-8 fl">
							<input class="form-control"  name="url" type="text" style="width:420px;">
						</div>
					</div>
					
					<div class="form-group form-input clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">排序</label>
						<div class="col-sm-8 fl">
							<input class="form-control"  name="showorder" type="text" style="width:420px;">
						</div>
					</div>
					
					<div class="form-group clear">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">链接类型</label>
						<div class="col-sm-8 fl">
							<input  name="link_type" class="input_radio" value="1" type="radio"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;图片
							<input  name="link_type" class="input_radio" value="2" type="radio">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;合作
							<input  name="link_type" class="input_radio" value="3" type="radio">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;文字
						</div>
					</div>

					<div class="form-group form-input clear">
				    	<label for="inputEmail3" class="col-sm-2 control-label no-padding-right fl" style="padding-top:7px;width:100px;text-align:right;">图片</label>
				    	<div class="col-sm-8 fl">
				     		<input type="file" id="upload_pic" name="upload_pic" value=""/>
				     		<input type="hidden" name="icon">(100*36)
				     		<input type="button" value="上传" id="upfile_pic" />
				    	</div>
				    	<input type="hidden" value="" name="id" />
				    </div>

					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input class="btn btn-palegreen" id="submit_form"  value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 添加体验师结束 -->
	
	<div style="display:none;position:absolute;overflow:visible;" class="modal fade in box-info" >
		<div class="modal-dialog" style="margin:30px auto; ;width:600px;">
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
<!-- 弹出层底层 -->
<div class="modal-backdrop fade in" style="display:none;"></div>

	<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
	<!-- /Page Body -->
	<script>
		$('input[name="search_name"]').val('');
		$('.ajax_page').click(function(){
			var page_new = $(this).find('a').attr('page_new');
			get_ajax_page(page_new);
		})
		$('#search_submit').click(function(){
			get_ajax_page(1);
			return false;
		})
		//分页
		function get_ajax_page(page_new){
			var name = $('input[name="search_name"]').val();
			$.post(
					"<?php echo site_url('admin/a/index_friend_link/friend_link_list')?>",
					{'page_new':page_new,'name':name,'is':1},
					function(data) {
						data = eval('('+data+')');
						$('.tbody_data').html('');
						$.each(data.list ,function(key ,val) {
							str = '<tr>';
							str += '<td>'+val.name+'</td>';
							str += '<td>'+val.url+'</td>';
							str += '<td>'+val.link_type+'</td>';
							str += '<td>'+val.icon+'</td>';
							str += '<td>'+val.showorder+'</td>';
							str += '<td><a href="#" onclick="edit('+val.id+')" class="btn btn-info btn-xs edit"> 编辑</a>';
							str += '<a href="#" onclick="del('+val.id+' ,\''+val.name+'\')" class="btn btn-danger btn-xs delete"> 删除</a>';
							str += '</tr>';
							$('.tbody_data').append(str);
						});
						$('.pagination').html(data.page_string);

						$('.ajax_page').click(function(){
							var new_page = $(this).find('a').attr('page_new');
							get_ajax_page(new_page);
						})
					}
				);
		}
		/*****************添加最美体验师****************/
		function add () {
			$('.form-input').find('input').val('');
			$('#upfile_pic').val('上传');
			$('.input_radio').css({'opacity':1,'left':'20px','position': 'relative'});
			$('input[name="link_type"][value="3"]').prop('checked' ,true);
			$('.upload_pic').remove();
			$('.modal-backdrop').show();
			$('.bootbox').show();
		}
		function edit(id) {
			$.post(
				"<?php echo site_url('admin/a/index_friend_link/get_one_json')?>",
				{'id':id},
				function(data) {
					if (data.length < 1) {
						alert('您选择的记录有误')
						return false;
					}
					data = eval('('+data+')');
					$('input[name="name"]').val(data.name);
					$('input[name="url"]').val(data.url);
					$('input[name="icon"]').val(data.icon);
					$('#upload_pic').next('.upload_pic').remove();
					if (data.icon.length > 1) {
						$('#upload_pic').after("<img class='upload_pic' src='"+data.icon+"' width='80' height='80'>");
					}
					$('input[name="id"]').val(data.id);
					$('input[name="showorder"]').val(data.showorder);

					$('.input_radio').css({'opacity':1,'left':'20px','position': 'relative'});
					$('input[name="link_type"][value="'+data.link_type+'"]').prop('checked' ,true);

					$('.modal-backdrop').show();
					$('.bootbox').show();
				}
			);
		}
		
		$('#submit_form').click(function(){
			$.post(
				"<?php echo site_url('admin/a/index_friend_link/edit_friend_link')?>",
				$('#form_data').serialize(),
				function(data) {
					data = eval('('+data+')');
					if (data.code == 2000) {
						alert(data.msg)
						window.location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
		})
		/**********添加结束************/
		
		$('.bootbox-close-button').click(function(){
			$('.modal-backdrop').css('display','none');
			$('.bootbox').css('display','none');
			$('.box-info').hide();
		})

		
		//上传图片
		$('#upfile_pic').on('click', function(){
			ajax_upload_file('upload_pic' ,'icon' ,'friend_link');
	    });

		//删除数据
	    function del(id) {
			$('.form-msg').html('您确定删除此数据吗？');
			$('input[name="del_id"]').val(id);
			$('.box-info').show();
			$('.modal-backdrop').show();
		}
		$('.sub-delete').click(function(){
			var id = $('input[name="del_id"]').val();
			$.post(
				"<?php echo site_url('admin/a/index_friend_link/delete')?>",
				{'id':id},
				function(data) {
					data = eval('('+data+')');
					if (data.code == 2000) {
						alert(data.msg);
						window.location.reload();
					} else {
						alert(data.msg);
					}
				}
			)
		})
	</script>
