<style type="text/css">
	.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	.col_lb{ float: left; width: 16%; text-align: right;}
	.col_ts{ float: left;}
	.col-sm-10{ width: 83%;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">旅行社管理</li>
		</ul>
	</div>
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				
						<div class="table-toolbar">
							<a id="add_travel_agent" href="javascript:void(0);" class="btn btn-default" > 添加 </a>
						</div>

                       	<div class="tab-content" style="border:1px solid #ccc;">
                       	<form action="#" id='search_dest_line' method="post">

							<div class="col-xs-2">
								<div>
									<input type="text" class="form-control" placeholder="名称" name="search_name">
								</div>
							</div>
							<button type="button" class="btn btn-darkorange active" id="search_submit" style="margin: -2px 0 0 30px;">搜索</button>
						</form>
						<br/>
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>旅行社名称</th>
								            <th>添加时间</th>
								            <th style="width:55%;">备注</th>
								            <th>操作</th>
								        </tr>
								    </thead>
								    <tbody class='tbody_data'>
								    		<?php foreach($list as $val): ?>
								        		<tr>
								        			<td style="text-align:left;"><?php echo $val ['name']?></td>
										            <td ><?php echo $val['addtime']?></td>
										            <td ><?php echo $val['beizhu']?></td>
										            <td><a href='#' onclick="edit(<?php echo $val ['id']?>)" class="btn btn-info btn-xs edit"> 编辑</a></td>
									        	</tr>
									        <?php endforeach;?>
								    </tbody>
								</table>
								<div class="pagination"><?php echo $page_string?></div>
							</div>
						</div>
						</div>
					</div>
				
			</div>
		</div>
	<div style="display:none;position:absolute;overflow:visible;" class="bootbox modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">添加旅行社</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" id="form_travel_agent" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">旅行社名称</label>
						<div class="col-sm-10 col_ts" >
							<input class="form-control"  name="name" placeholder="请输入旅行社名称" type="text">
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">备注 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="beizhu" rows="6" cols="57"></textarea>
						</div>
					</div>
					
					<input type="hidden" value="" name="id">
					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input class="btn btn-palegreen submit" id="submit_form" value="提交" style="float: right; margin-right: 2%;" type="button">
					</div>
					</form>
				</div>
				</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal-backdrop fade in" style="display:none;"></div>

	<!-- /Page Body -->
	<script>
		$('.ajax_page').click(function(){
			var new_page = $(this).find('a').attr('page_new');
			get_ajax_page(new_page);
		})
		$('#search_submit').click(function(){
			get_ajax_page(1);
			return false;
		})
		//分页
		function get_ajax_page(new_page){
			var name = $('input[name="search_name"]').val();
			$.post(
					"<?php echo site_url('admin/a/manage/travel_agent')?>",
					{'page_new':new_page,'name':name,'is':1},
					function(data) {
						data = eval('('+data+')');
						$('.tbody_data').html('');
						$.each(data.list ,function(key ,val) {
							str = '<tr>';
							str += '<td>'+val.name+'</td>';
							str += '<td>'+val.addtime+'</td>';
							str += '<td>'+val.beizhu+'</td>';
							str += '<td><a href="#" onclick="edit('+val.id+')" class="btn btn-info btn-xs edit"> 编辑</a>';
							str += '</td></tr>';
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
		//添加旅行社弹出层
		$('#add_travel_agent').click(function() {
			$('input[name="name"]').val('');
			$('textarea[name="beizhu"]').val('');
			$('input[name="id"]').val('');
			$('.modal-title').html('添加旅行社');
			$('.bootbox').show();
			$('.modal-backdrop').show();
		})
		//执行旅行社的添加或编辑
		$('#submit_form').click(function(){
			var id = $('input[name="id"]').val();
			if (id.length > 0) {
				//编辑
				var url = '/admin/a/manage/edit_travel_agent';
			} else {
				var url = '/admin/a/manage/add_travel_agent';
			}
			$.post(
				url,
				$('#form_travel_agent').serialize(),
				function(data) {
					data = eval('('+data+')');
					if (data.code == 2000) {
						alert(data.msg);
						location.reload();
					} else {
						alert(data.msg);
					}
				}
			);
		})
		//编辑弹出层
		function edit(id) {
			$.post(
				"/admin/a/manage/get_one_json",
				{'id':id},
				function(data) {
					if (data.length < 1) {
						alert('请确认您选择的旅行社');
						return false;
					}
					data = eval('('+data+')');
					$('input[name="name"]').val(data.name);
					$('textarea[name="beizhu"]').val(data.beizhu);
					$('input[name="id"]').val(data.id);
					$('.modal-title').html('编辑旅行社');
					$('.bootbox').show();
					$('.modal-backdrop').show();
				}
			);
		}
		//关闭弹出层
		$('.bootbox-close-button').click(function(){
			$('.bootbox').hide();
			$('.modal-backdrop').hide();
		})
	</script>
