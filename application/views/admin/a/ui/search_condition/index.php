<style type="text/css">
.search_title {
	float: left;
	margin-top: 5px;
}

.search_div {
	float: left;
}
</style>
<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a
				href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">搜索条件设置</li>
		</ul>
	</div>

	<!-- <div class="well with-header with-footer"> -->
		<div class="widget-body">
			<div class="table-toolbar">
				<a onclick="add();" href="javascript:void(0);" class="btn btn-default"> 添加 </a>
			</div>
			<div class="flip-scroll">
				<form class="form-inline clear" action="#" id="search_condition" method="post">
					<div class="form-group dataTables_filter search_div">
						<span class="search_title">顶级搜索:</span> 
						<select name="top" style="width: 130px;">
							<option value="0">请选择</option>
							<?php 
								foreach($top as $val) {
									echo "<option value='{$val['id']}'>{$val['description']}</option>";
								}
							?>
						</select>
					</div>

					<input type="hidden" name="page_new" value="1">
					<button type="submit" class="btn btn-default" style="margin-top: 10px;">搜索</button>
				</form>
				<br />

				<div class="dataTables_wrapper form-inline no-footer">
					<table
						class="table table-striped table-hover table-bordered dataTable no-footer">
						<thead class="bordered-darkorange">
							<tr>
								<th>最低值</th>
								<th>最高值</th>
								<th>描述</th>
								<th>上级</th>
								<th>标识码</th>
								<th>排序</th>
								<th>操作</th>
							</tr>
						</thead>
						<tbody class="pagination_data"></tbody>
					</table>

				</div>
				<div class="pagination"></div>
			</div>
		</div>
<!-- 	</div> -->
</div>
<div class="modal-backdrop fade in bc_close" style="display: none"></div>
	<div style="display: none; position: absolute; z-index: 9999; overflow: visible;" class="bootbox  modal fade in" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="bootbox-close-button bc_close close" onclick="close();">×</button>
					<h4 class="modal-title">添加搜索条件</h4>
				</div>
				<div class="modal-body">
					<div class="bootbox-body">
							<form class="form-horizontal" role="form" id="search_condition_form" method="post" action="#">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">最低值</label>
									<div class="col-sm-10">
										<input class="form-control positive_int" maxlength="8" placeholder="请填写整数" name="minvalue" type="text">
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">最高值</label>
									<div class="col-sm-10">
										<input class="form-control positive_int" maxlength="8" placeholder="请填写整数" name="maxvalue" type="text">
									</div>
								</div>
								

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label no-padding-right">上级</label>
									<div class="col-sm-10">
										<select name="pid"  style="width:100px;">
											<option value="0">请选择</option>
											<?php 
												foreach($top as $val) {
													echo "<option value='{$val['id']}'>{$val['description']}</option>";
												}
											?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">描述</label>
									<div class="col-sm-10">
										<input class="form-control " name="description" maxlength="20" type="text">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">标识码</label>
									<div class="col-sm-10">
										<input class="form-control " name="code" placeholder="例：CON_LINE_DAY " type="text">
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3"
										class="col-sm-2 control-label no-padding-right">排序</label>
									<div class="col-sm-10">
										<input class="form-control positive_int" maxlength="4" placeholder="请填写整数" name="showorder" type="text">
										<input type="hidden" name="id" >
									</div>
								</div>
								<div class="form-group">
									
									<input class="btn btn-palegreen bootbox-close-button" onclick="close();" value="取消" style="float: right; margin-right: 2%;" type="button"> 
									<input class="btn btn-palegreen submit_form"  value="确认提交" style="float: right; margin-right: 2%;" type="submit">
								</div>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="eject_body details_expert">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title">删除搜索条件</div>
	<div class="eject_content">
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">最小值:</div>
				<div class="content_info sc_minvalue"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">最大值:</div>
				<div class="content_info sc_maxvalue"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">上级:</div>
				<div class="content_info sc_top_name"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">描述:</div>
				<div class="content_info sc_description"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">标识码:</div>
				<div class="content_info sc_code"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">排序:</div>
				<div class="content_info sc_showorder"></div>
			</div>
			<div style="clear:both;"></div>
		</div>

		<div class="eject_botton">
			<input type="hidden" value="" name="sc_id" />
			<div class="ex_colse">关闭</div>
			<div class="sc_delete">确认删除</div>
		</div>	
	</div>						
</div>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/admin/a/search_condition/index.js") ;?>"></script>