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
			<li class="active">最美体验师管理</li>
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
									<input type="text" class="form-control" placeholder="体验师昵称" name="search_name">
								</div>
							</div>
							<button type="button" class="btn btn-darkorange active" id="search_submit" style="margin: -2px 0 0 30px;">搜索</button>

						</form>
						<br/>
							<div class="tab-pane active">
								<table class="table table-hover">
								    <thead class="bordered-darkorange">
								        <tr>
								            <th>体验师昵称</th>
 								            <th>链接地址</th>
								            <th>图片</th>
								            <th>是否显示</th>
								            <th>是否可更改</th>
								            <th style="width:15%;">备注</th>
								            <th>排序</th>
								            <th>操作</th>
								        </tr>
								    </thead>
								    <tbody class='tbody_data'>
								    		<?php foreach($list as $val): ?>
								        		<tr>									            
										            <td ><?php echo $val['nickname']?></td>
										            <td><?php echo $val['link']?></td>
										            <td><?php echo $val ['pic']?></td>
										            <td><?php echo $val ['is_show'] ?></td>
										            <td><?php echo $val ['is_modify'] ?></td>
										            <td title="<?php echo $val['beizhu']?>"><?php echo $val['sub_beizhu']?></td>
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
	<div style="display:none;position:absolute;overflow:visible;" class="bootbox modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button close" >×</button>
					<h4 class="modal-title">添加最美体验师</h4>
				</div>
				<div class="modal-body">
				<div class="bootbox-body">
				<div>
					<form class="form-horizontal" id="add_beauty_experience" method="post">
					<div class="form-group add_beauty">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">选择体验师</label>
						<div class="col-sm-10 col_ts" >
							<input class="form-control"  name="nickname" placeholder="请点击选择" readonly type="text">
							<input name='member_id' type="hidden">
						</div>
					</div>
					<div class="form-group edit_beauty">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">链接</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="link" type="text">
						</div>
					</div>
					
					<div class="form-group add_beauty">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">排序</label>
						<div class="col-sm-10 col_ts">
							<input class="form-control"  name="showorder" type="text">
						</div>
					</div>
					
					<div class="form-group edit_beauty">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">是否可更改</label>
						<div class="col-sm-10 col_ts">
							<input  name="is_modify" class="input_radio" value="0" type="radio"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;不可更改
							<input  name="is_modify" class="input_radio" value="1" type="radio">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;可更改
						</div>
					</div>
					<div class="form-group edit_beauty">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">是否显示</label>
						<div class="col-sm-10 col_ts">
							<input  name="is_show" class="input_radio" value="0" type="radio">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;不显示
							<input  name="is_show" class="input_radio" value="1" type="radio">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;显示
						</div>
					</div>

					<div class="form-group add_beauty">
				    	<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">图片</label>
				    	<div class="col-sm-10 col_ts">
				     		<input type="file" id="upload_pic" name="upload_pic" value=""/>
				     		<input type="hidden" name="pic">
				     		<input type="button" value="上传" id="upfile_pic" />
				    	</div>
				    </div>

					<div class="form-group add_beauty">
						<label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">备注 </label>
						<div class="col-sm-10 col_ts">
							<textarea name="beizhu" rows="6" cols="57"></textarea>
						</div>
						<!-- 编辑时保存数据ID -->
						<input type="hidden" value="" name="id" />
					</div>

					<div class="form-group form_submit">
						<input class="btn btn-palegreen bootbox-close-button " value="关闭" style="float: right; margin-right: 2%; " type="button">
						<input class="btn btn-palegreen" id="submit_add_experience"  value="提交" style="float: right; margin-right: 2%;" type="button">
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
		<div class="modal-dialog">
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
	
<!-- 选择体验师弹出层 开始-->
<div class="eject_body">
	<div class="eject_colse colse_travel">X</div>
	<div class="eject_title">选择体验师</div>
	<div class="search_travel_input">
		<input class="search_travel_condition" type="text" placeholder="请输入体验师昵称" name="search_member_nickname">
		<div class="search_button">搜索</div>
	</div>
	<div class="eject_content" style="clear: both;">
		<div class="choice_experience">
			<div class="eject_experience_pic"><img src='' ></div>
			<div class="eject_experience_info">
				<div class="experience_detailed">
					<div class="experience_nickname">昵&nbsp;&nbsp;&nbsp;称:</div>
					<div class="experience_content">中华人民共和国</div>
				</div>
				<div style="clear:both;"></div>
				<div class="experience_detailed">
					<div class="experience_nickname">手机号:</div>
					<div class="experience_content">18682327560</div>
				</div>
			</div>
		</div>
		<div class="choice_experience">
			<div class="eject_experience_pic"><img src='' ></div>
			<div class="eject_experience_info">
				<div class="experience_detailed">
					<div class="experience_nickname">昵&nbsp;&nbsp;&nbsp;称:</div>
					<div class="experience_content">中华人民共和国</div>
				</div>
				<div style="clear:both;"></div>
				<div class="experience_detailed">
					<div class="experience_nickname">手机号:</div>
					<div class="experience_content">18682327560</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="pagination page_experience"></div>
	<div style="clear:both;"></div>
	<div class="eject_botton">
		<div class="eject_through">选择</div>
		<div class="eject_fefuse colse_travel">取消</div>
	</div>					
</div>							
<!-- 选择体验师弹出层结束 -->

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
					"<?php echo site_url('admin/a/beauty_experience/index')?>",
					{'page_new':page_new,'name':name,'is':1},
					function(data) {
						data = eval('('+data+')');
						$('.tbody_data').html('');
						$.each(data.list ,function(key ,val) {
							str = '<tr>';
							str += '<td>'+val.nickname+'</td>';
							str += '<td>'+val.link+'</td>';
							str += '<td>'+val.pic+'</td>';
							str += '<td>'+val.is_show+'</td><td>'+val.is_modify+'</td>';
							str += '<td title="'+val.beizhu+'">'+val.sub_beizhu+'</td><td>'+val.showorder+'</td>';
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
			$('textarea[name="beizhu"]').val('');
			$('.add_beauty').find('input').val('');
			$('#upfile_pic').val('上传');
			$('.edit_beauty').css('display','none');
			$('.upload_pic').remove();
			$('.modal-backdrop').show();
			$('.bootbox').show();
		}
		function edit(id) {
			$.post(
				"<?php echo site_url('admin/a/beauty_experience/get_beauty_experience_json')?>",
				{'id':id},
				function(data) {
					if (data.length < 1) {
						alert('您选择的体验师有误')
						return false;
					}
					data = eval('('+data+')');
					$('input[name="nickname"]').val(data.nickname);
					$('input[name="member_id"]').val(data.mid);
					$('input[name="link"]').val(data.link);
					$('input[name="pic"]').val(data.pic);
					$('#upload_pic').next('.upload_pic').remove();
					if (data.pic.length > 1) {
						$('#upload_pic').after("<img class='upload_pic' src='"+data.pic+"' width='80' height='80'>");
					}
					$('input[name="id"]').val(data.id);
					$('input[name="beizhu"]').val(data.beizhu);
					$('input[name="showorder"]').val(data.showorder);

					$('.input_radio').css({'opacity':1,'left':'20px','position': 'relative'}).removeAttr('checked');
					$('input[name="is_show"][value="'+data.is_show+'"]').prop('checked' ,true);
					$('input[name="is_modify"][value="'+data.is_modify+'"]').prop('checked' ,true);
					$('.edit_beauty').css('display','block');

					$('.modal-backdrop').show();
					$('.bootbox').show();
				}
			);
		}
		
		$('#submit_add_experience').click(function(){
			var id = $('input[name="id"]').val();
			if (id.length < 1) {
				var url = "<?php echo site_url('admin/a/beauty_experience/add_beauty_experience')?>";
			} else {
				var url = "<?php echo site_url('admin/a/beauty_experience/edit_beauty_experience')?>";
			}
			$.post(
				url,
				$('#add_beauty_experience').serialize(),
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
		
		
		
		/******选择体验师*******/
		$('input[name="nickname"]').click(function(){
			get_experience_ajax(1);
		})
		$('.search_button').click(function(){
			get_experience_ajax(1);
		})
		
		function get_experience_ajax(page_new) {
			var nickname = $('input[name="search_member_nickname"]').val();
			//获取体验师数据
			$.post(
				"<?php echo site_url('admin/a/beauty_experience/get_experience_json')?>",
				{'nickname':nickname,'page_new':page_new},
				function(data) {
					data = eval('('+data+')');
					$('.eject_content').html('');
					$.each(data.list ,function(key ,val) {
						var string = '<div class="choice_experience">';
						string += '<div class="eject_experience_pic"><img src="'+val.litpic+'" ></div>';
						string += '<div class="eject_experience_info">';
						string += '<div class="experience_detailed">';
						string += '<div class="experience_nickname" member_id = "'+val.mid+'">昵&nbsp;&nbsp;&nbsp;称:</div>';
						string += '<div class="experience_content">'+val.nickname+'</div></div>';
						string += '<div style="clear:both;"></div>';
						string += '<div class="experience_detailed">';
						string += '<div class="experience_nickname">手机号:</div>';
						string += '<div class="experience_content">'+val.mobile+'</div>';
						string += '</div></div></div>';
						$('.eject_content').append(string);
					})	
				
					$('.page_experience').html(data.page_string);
					$('.eject_content').css('min-height','300px');
					$('.eject_body').css({'z-index':'10000','margin-top':'-80px','min-width':'760px'}).show();

					$('.ajax_page').click(function(){
						var page_new = $(this).find('a').attr('page_new');
						get_experience_ajax(page_new);
					})

					//选择体验师改变样式
					$('.choice_experience').click(function(){
						$(this).css('border','1px solid green').addClass('ex_active').siblings().css('border','1px solid #ccc').removeClass('ex_active');
					})
				}
			)
		}
		//确认选择体验师
		$('.eject_through').click(function(){
			var member_id = $('.ex_active').find('.experience_nickname').attr('member_id');
			var nickname = $('.ex_active').find('.experience_content').html();
			$('input[name="nickname"]').val(nickname);
			$('input[name="member_id"]').val(member_id);
			$('.eject_body').hide();
		})
		//关闭体验师弹出
		$('.colse_travel').click(function(){
			$('.eject_body').hide();
		})
		/******选择体验师结束*******/

		
		$('.bootbox-close-button').click(function(){
			$('.modal-backdrop').css('display','none');
			$('.bootbox').css('display','none');
			$('.box-info').hide();
			$('.line-list').hide();
		})

		
		//上传图片
		$('#upfile_pic').on('click', function(){
			ajax_upload_file('upload_pic' ,'pic' ,'config_experience');
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
				"<?php echo site_url('admin/a/beauty_experience/delete')?>",
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
