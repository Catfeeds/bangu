<style type="text/css">
	.table thead th{ text-align: center;}
	
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">营销管理 / 优惠券管理</li>
		</ul>
	</div>
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<ul id="myTab5" class="nav nav-tabs">
<!-- 					<li class="tab-red"><a href="#">申请中</a></li> -->
					<li class="tab-red active"><a href="<?php echo site_url('admin/a/coupon/coupon_list?status=1');?>">已生效</a></li>
<!-- 					<li class="tab-red "><a href="#">已拒绝</a></li> -->
				</ul>
				<div class="tab-content">
					<div class="table-toolbar">
						<a id="add_coupon" href="javascript:void(0);" class="btn btn-default"> 添加 </a>
					</div>
					
						<form class="form-inline" id="search_form_coupon" method="post" action="#">
							<div class="form-group dataTables_filter" style="float:left">
								<label class="sr-only"> 拥有者类型 </label>
								<select name="type">
									<option value="0">请选择</option>
									<option value="3">平台</option>
									<option value="2">商家</option>
								</select>
							</div>
							
							<div class="form-group" style="float:left">
							
								<div class="col-sm-10">
									<input type="text" class="form-control" id="reservation" placeholder="开始时间" name="starttime" >
								</div>
							</div>
							<!-- 主要作用：可以使用表单提交分页数 -->
							<input type="hidden" name="page_new">
							<input type="hidden" name="status" value="">
							<button type="submit" class="btn btn-darkorange">搜索</button>
						</form>
					<br/>
					<div class="tab-pane active">
						<table class="table table-striped table-bordered table-hover dataTable no-footer">
							<thead class="bordered-darkorange">
								<tr>
									<th>拥有者类型</th>
									<th>拥有者名称</th>
									<th>优惠券名称</th>
									<th>开始时间</th>
									<th>结束时间</th>
									<th>总量</th>
									<th>使用范围</th>
									<th>最低使用价格</th>
									<th>优惠额度</th>
								    <th>操作</th>
								</tr>
							</thead>
							<tbody class="body_data">
								<?php foreach ( $list as $v ): ?>
								<tr>
									<td class="td_center"><?php echo $v['type']?></td>
									<td class="td_center" style="width:10%;"><?php echo $v['username']?></td>
									<td class="td_center" style="width:15%;"><?php echo $v['name']?></td>
									<td class="td_center"><?php echo $v['starttime']?></td>
									<td class="td_center"><?php echo $v['endtime']?></td>
									<td class="td_center"><?php echo $v['number']?></td>
									<td class="td_center"><?php echo $v['use_range_name']?></td>
									<td class="td_center"><?php echo $v['min_price']?></td>
									<td class="td_center"><?php echo $v['coupon_price']?></td>
									<td>
										<?php if ($status == 1):?>
										<a href='#' onclick="edit(<?php echo $v['id']?>)" class="btn btn-info btn-xs edit">
											修改
										</a>
										         	    	
										<?php elseif($status == 2):?>
											<a href='#' onclick="see_info(<?php echo $v['id']?>,1)" class="btn btn-danger btn-xs delete">
												下线
											</a>  
										<?php elseif ($status == 3):?>
											<a href='#' onclick="see_info(<?php echo $v['id']?>,2)" class="btn btn-danger btn-xs delete">
												删除
											</a>  
										<?php endif;?>
									</td>
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
<div style="display: none;position: absolute;z-index: 9999;overflow: visible;" class="bootbox  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button bc_close close" >×</button>
					<h4 class="modal-title">添加优惠券</h4>
				</div>
				<!-- 添加优惠券开始 -->
				<div class="modal-body">
					<form class="form-horizontal" id="coupon_form" method="post" >
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">开始结束时间 </label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="reservation2" name="time" >
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">总量</label>
							<div class="col-sm-10">
								<input type="text" class="form-control pi_required"  placeholder="请填写正整数"  name="number" >
							</div>
						</div>
						<div class="form-group eidt_dis">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right" >使用范围</label>
							<div class="col-lg-2 col-sm-4 col-xs-4" >
								<div class="radio show_0">
								<label><input  class="colored-success" type="radio" checked="checked" value="4" name="use_range"><span class="text">全网</span></label>
								</div>
							</div>
<!-- 							<div class="col-lg-2 col-sm-4 col-xs-4" > -->
<!-- 								<div class="radio show_1"> -->
<!-- 								<label><input  class="colored-success"  type="radio"  disabled value="3" name="use_range"><span class="text">区域</span></label> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 							<div class="col-lg-2 col-sm-4 col-xs-4" > -->
<!-- 								<div class="radio show_1"> -->
<!-- 								<label><input  class="colored-success"  type="radio" disabled  value="2" name="use_range"><span class="text">商家</span></label> -->
<!-- 								</div> -->
<!-- 							</div> -->
<!-- 							<div class="col-lg-2 col-sm-4 col-xs-4" > -->
<!-- 								<div class="radio show_1"> -->
<!-- 								<label><input  class="colored-success"  type="radio" disabled  value="1" name="use_range"><span class="text">线路</span></label> -->
<!-- 								</div> -->
<!-- 							</div> -->
						</div>
						<div class="form-group eidt_dis">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">使用最低价</label>
							<div class="col-sm-10">
								<input type="text" class="form-control positive_int" placeholder="请填写正整数，不填默认为0"  name="min_price" >
							</div>
						</div>
						<div class="form-group eidt_dis">
							<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">优惠额度</label>
							<div class="col-sm-10">
								<input type="text" class="form-control pi_required" placeholder="请填写正整数"  name="coupon_price" >
							</div>
						</div>
						<div class="form-group">
					    	<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">图片</label>
					    	<div class="col-sm-10">
					     		<input type="file" id="pic_file" name="pic_file" value=""/>
					     		<input type="hidden" name="pic">
					     		<input type="button" value="上传" id="upfile_pic" />
					    	</div>
					    </div>
						
						<div class="form-group">
							<input type="hidden" name="id" >
							<input type="button" class="btn btn-palegreen bootbox-close-button " aria-hidden="true"  type="button" value="关闭" style="float: right; margin-right: 2%; " />
							<input type="button" id="submit_coupon" class="btn btn-palegreen" value="确认" style="float: right; margin-right: 2%;" />
						</div>
					</form>
				</div>
				<!-- 添加优惠券结束 -->
				
		</div>
	</div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>


<?php echo $this->load->view('admin/a/common/time_script'); ?>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
$('.ajax_page').click(function() {
	if ($(this).hasClass('active')) { //点击当前页，不执行下面的
		return false;
	}
	var page_new = $(this).find('a').attr('page_new');
	get_ajax_page(page_new);
})
//条件搜索
$('#search_form_coupon').submit(function() {
	get_ajax_page(1);
	return false;
})

/**
* @method ajax分页
* @param {intval} page_new 第几页
*/
function get_ajax_page(page_new) {
	$('input[name="page_new"]').val(page_new);
	$.post(
		"/admin/a/coupon/get_ajax_data",
		$('#search_form_coupon').serialize(),
		function(data) {
			var data = eval('('+data+')');
			$('.body_data').html('');
			$.each(data.list ,function(kay ,val) {
				var string = "<tr>";
					string += "<td>"+val.type+"</td>";
					string += "<td>"+val.username+"</td>";
					string += "<td>"+val.name+"</td>";
					string += "<td>"+val.starttime+"</td>";
					string += "<td>"+val.endtime+"</td>";
					
					string += "<td>"+val.number+"</td>";
					string += "<td>"+val.use_range_name+"</td>";
					string += "<td>"+val.min_price+"</td>";
					string += "<td>"+val.coupon_price+"</td>";
					if (val.status == 1) {
						string += "<td><a href='javascript:void(0)' onclick='edit("+val.id+")' class='btn btn-default btn-xs purple'><i class='fa fa-edit'></i>修改</a>";
					}
					$('.body_data').append(string);
			})
			$('.pagination').html(data.page_string);

			$('.ajax_page').click(function() {
				if ($(this).hasClass('active')) { //点击当前页，不执行下面的
					return false;
				}
				var page_new = $(this).find('a').attr('page_new');
				get_ajax_page(page_new);
			})
		}
	);
}


//添加弹出层
$('#add_coupon').click(function(){
	clean_input();
	$('.modal-title').html('添加优惠券');
	$('input[name="number"]').removeClass('positive_int').addClass('pi_required');
	$('.bootbox').css('z-index','2999').show();
	$('.modal-backdrop').css('z-index','2888').show();
	$('.eidt_dis').css('display','block');
	$('#pic_file').next('.pic').remove();
})
//添加 /编辑优惠券
$('#submit_coupon').click(function(){
	var id = $('input[name="id"]').val();
	if (id.length > 0) {
		var url = "<?php echo site_url('admin/a/coupon/edit_coupon')?>";
	} else {
		var url = "<?php echo site_url('admin/a/coupon/add_coupon')?>";
	}
// 	$('input').trigger('blur');
// 	if ($('input').hasClass('error')) {
// 		alert('请填写完整')
// 		return false;
// 	}
	$.post(
		url,
		$('#coupon_form').serialize(),
		function (data) {
			data = eval('('+data+')');
			if (data.code == 2000) {
				alert(data.msg);
				location.reload();
			} else {
				alert(data.msg);
			}
		}
	);
	return false;
})
//修改弹出
function edit(id) {
	$.post(
		"<?php echo site_url('admin/a/coupon/get_one_json')?>",
		{'id':id},
		function(data) {
			if (data.length > 1) {
				data = eval('('+data+')');
				clean_input();
				$('#pic_file').next('.pic').remove();
				//赋值数据
				$('input[name="time"]').val(data.time);
				$('input[name="number"]').val(data.number);
				$('input[name="id"]').val(data.id);
				if (data.pic.length > 1) {
					
					$('#pic_file').after("<img class='pic' src='"+data.pic+"' width='80' height='80'>");
					$('input[name="pic"]').val(data.msg);
				}
				
				//显示弹出框
				$('.modal-title').html('编辑优惠券');
				$('input[name="number"]').removeClass('pi_required').addClass('positive_int');
				$('.bootbox').css('z-index','2999').show();
				$('.modal-backdrop').css('z-index','2888').show();
				$('.eidt_dis').css('display','none');
				
				return false;
			} else {
				alert('请确认您选择的记录');
			}
			
		}
	);
}
function clean_input() {
	$('input[name="time"]').val('');
	$('input[name="pic"]').val('');
	$('input[name="pic_file"]').val('');
	$('input[name="number"]').val('');
	$('input[name="id"]').val('');
	$('input[name="min_price"]').val('');
	$('input[name="coupon_price"]').val('');
}

//上传文件
$('#upfile_pic').on('click', function() {
	//若要更改文件上传的请求地址请更改js文件中的请求地址(assets/js/verification/verification_data.js)
	ajax_upload_file('pic_file' ,'pic' ,'coupon');
});
</script>