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
			<li class="active">营业部管理</li>
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
									<input type="text" class="search_input" placeholder="名称" name="search_name">
								</div>
							</div>
							<button type="button" class="btn btn-darkorange active" id="search_submit" style="margin: -2px 0 0 30px;">搜索</button>
						</form>
						<br/>
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>营业部名称</th>
								        
								            <th>添加时间</th>
								            <th style="width:45%;">备注</th>
								            <th>操作</th>
								        </tr>
								    </thead>
								    <tbody class='tbody_data'>
								    		<?php foreach($list as $val): ?>
								        		<tr>
								        			<td style="text-align:left;"><?php echo $val ['name']?></td>
								        	
										            <td ><?php echo $val['addtime']?></td>
										            <td style="text-align:left;"><?php echo $val['beizhu']?></td>
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
					<h4 class="modal-title">添加营业部</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" id="form_sells_depart" method="post">
					<!--  <div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">旅行社名称</label>
						<div class="col-sm-6 col_ts"  style="width:50%">
							<input class="form-control"  name="agent_name"  placeholder="请输入旅行社名称" type="text">
							<input type="hidden" value="" name="agent_id">
						</div>
                        <div class="agent_name_button" style="height:35px;line-height:35px;background:#2dc3e8;color:#fff;font-size:14px;cursor:pointer;width:150px;float:right;left:-62px;position:relative;text-align:center;border-radius:3px;">点此可选择旅行社</div>
					</div>-->
					
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">营业部名称</label>
						<div class="col-sm-10 col_ts" >
							<textarea name="name" rows="6"  placeholder="请输入营业部名称，多个以逗号分隔" cols="57"></textarea>
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
	
<!-- 选择旅行社弹出层 开始-->
<div class="eject_body">
	<div class="eject_colse colse_travel">X</div>
	<div class="eject_title">选择旅行社</div>
	<div class="search_travel_input">
		<input class="search_travel_condition" type="text" placeholder="请输入旅行社名称" name="search_travel_name">
		<div class="search_button">搜索</div>
	</div>
	<div class="eject_content" style="clear: both;">
		<div class="choice_tralve_agent">海外国旅旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社深圳市口岸中国旅行社</div>
	</div>	
	<div class="pagination page_travel"></div>
	<div style="clear:both;"></div>
	<div class="eject_botton">
		<div class="eject_through">选择</div>
		<div class="eject_fefuse colse_travel">取消</div>
	</div>					
</div>							
<!-- 选择旅行社 弹出层结束 -->
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
					"<?php echo site_url('admin/a/manage/sells_depart')?>",
					{'page_new':new_page,'name':name,'is':1},
					function(data) {
						data = eval('('+data+')');
						$('.tbody_data').html('');
						$.each(data.list ,function(key ,val) {
							str = '<tr>';
							str += '<td>'+val.name+'</td>';
						//	str += '<td>'+val.agent_name+'</td>';
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
			$('textarea[name="name"]').val('');
			$('textarea[name="beizhu"]').val('');
			$('input[name="id"]').val('');
			$('input[name="agent_name"]').val('');
			$('input[name="agent_id"]').val('');
			$('.modal-title').html('添加营业部');
			$('.bootbox').show();
			$('.modal-backdrop').show();
		})
		//执行营业部的添加或编辑
		$('#submit_form').click(function(){
			var id = $('input[name="id"]').val();
			if (id.length > 0) {
				//编辑
				var url = '/admin/a/manage/edit_sells_depart';
			} else {
				var url = '/admin/a/manage/add_sells_depart';
			}
			$.post(
				url,
				$('#form_sells_depart').serialize(),
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
				"/admin/a/manage/get_depart_one_json",
				{'id':id},
				function(data) {
					if (data.length < 1) {
						alert('请确认您选择的旅行社');
						return false;
					}
					data = eval('('+data+')');
					$('textarea[name="name"]').val(data.name).attr('placeholder','');
					$('textarea[name="beizhu"]').val(data.beizhu);
					$('input[name="id"]').val(data.id);
					$('input[name="agent_id"]').val(data.agent_id);
					$('input[name="agent_name"]').val(data.agent_name);
					$('.modal-title').html('编辑营业部');
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
		
		/*****************选择旅行社相关*************************/
		$('.colse_travel').click(function() {
			$('.eject_body').hide();
		})
		//选择旅行社弹出层
		$('.agent_name_button').click(function() {
			$.post(
				"/admin/a/manage/travel_agent",
				{'is':1,'pagesize':18},
				function(data) {
					data = eval('('+data+')');
					$('.eject_content').html('');
					$.each(data.list ,function(key ,val) {
						var str = '<div class="choice_tralve_agent" agent_id="'+val.id+'">'+val.name+'</div>';
						$('.eject_content').append(str);
					})
					$('.eject_content').append('<div style="clear:both;"></div>');
					$('.page_travel').html(data.page_string);

					$('input[name="search_travel_name"]').val('');
					$('.eject_content').css('min-height','200px');
					$('.eject_body').css({'z-index':'10000','top':'10px','min-height':'400px'}).show();

					//点击旅行社时执行
					$('.choice_tralve_agent').click(function() {
						$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
						$(this).css('border','2px solid green').addClass('active');
					})

					//点击分页
					$('.ajax_page').click(function(){
						var page_new = $(this).find('a').attr('page_new');
						get_travel_data(page_new);
					})
				}
			);
		})
		//旅行社分页
		function get_travel_data(page_new) {
			var name = $('input[name="search_travel_name"]').val();
			$.post(
				"/admin/a/manage/travel_agent",
				{'is':1,'pagesize':18,'page_new':page_new,'name':name},
				function(data) {
					data = eval('('+data+')');
					$('.eject_content').html('');
					$.each(data.list ,function(key ,val) {
						var str = '<div class="choice_tralve_agent" agent_id="'+val.id+'">'+val.name+'</div>';
						$('.eject_content').append(str);
					})
					$('.eject_content').append('<div style="clear:both;"></div>');
					$('.page_travel').html(data.page_string);

					//点击旅行社时执行
					$('.choice_tralve_agent').click(function() {
						$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
						$(this).css('border','2px solid green').addClass('active');
						
					})
					//点击分页
					$('.ajax_page').click(function(){
						var page_new = $(this).find('a').attr('page_new');
						get_travel_data(page_new);
					})
				}
			);
		}
		//点击搜索旅行社
		$('.search_button').click(function(){
			get_travel_data(1);
		})
		//选择旅行社
		$('.eject_through').click(function(){
			var active = $('.eject_content').find('.active');
			var agent_name = active.html();
			var agent_id = active.attr('agent_id');
			//alert(agent_id);
			$('input[name="agent_name"]').val(agent_name);
			$('input[name="agent_id"]').val(agent_id);
			$('.eject_body').hide();
		})
		/*****************选择旅行社相关**结束***********************/
	</script>
