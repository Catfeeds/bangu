<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="#"> 首页 </a></li>
			<li class="active">仪表盘</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="well with-header with-footer">

					<div class="widget">
						<div class="widget-header ">
							<span class="widget-caption">目的地申请列表</span>
							<div class="widget-buttons">
								<a href="#" data-toggle="maximize"> <i class="fa fa-expand"></i>
								</a> <a href="#" data-toggle="collapse"> <i class="fa fa-minus"></i>
								</a> <a href="#" data-toggle="dispose"> <i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="widget-body">
							<div role="grid" id="simpledatatable_wrapper"
								class="dataTables_wrapper form-inline no-footer">
								<div id="simpledatatable_filter" >
									<label>
										<form class="form-inline" role="form" action="">
										    <div class="form-group dataTables_filter">
										        <label class="sr-only" >
										            	专家名称
										        </label>
										        <input type="text" class="form-control" placeholder="专家名称">
										    </div>
										    <div class="form-group dataTables_filter">
										        <label class="sr-only" >
										            	目的地
										        </label>
										        <input type="text" class="form-control"  placeholder="目的地">
										    </div>
										    <div class="checkbox">
										        <label>
										            <select name="editabledatatable_length" class="form-control input-sm">
													    <option value="0">
													        	请选择
													    </option>
													    <option value="1">
													        	未通过
													    </option>
													    <option value="2">
													        	已通过
													    </option>
													    <option value="3">
													        	待审核
													    </option>
													</select>
										        </label>
										    </div>
										    <button type="submit" class="btn btn-default">
										        	搜索
										    </button>
										</form>
									</label>
								</div>
								<div class="dataTables_length" id="simpledatatable_length">
									<label></label>
								</div>
								<table
									class="table table-striped table-bordered table-hover dataTable no-footer"
									id="simpledatatable" aria-describedby="simpledatatable_info">
									<thead>
										<tr role="row">											
											<th class="sorting_disabled" tabindex="0"  rowspan="1" colspan="1"style="width: 213px;">申请时间</th>
											<th class="sorting_disabled" rowspan="1" colspan="1"style="width: 408px;">目的地</th>
											<th class="sorting_disabled" tabindex="0"  rowspan="1" colspan="1" style="width: 143px;">状态</th>
											<th class="sorting_disabled" tabindex="0"  rowspan="1" colspan="1" style="width: 143px;">专家名称</th>
											<th class="sorting_disabled" rowspan="1" colspan="1" style="width: 231px;">测验结果</th>
										</tr>
									</thead>
									<tbody>
										<tr class="odd">											
											<td class=" ">shuxer</td>
											<td class=" "><a href="mailto:shuxer@gmail.com">shuxer@gmail.com</a>
											</td>
											<td class=" ">120</td>
											<td class="center  ">12 Jan 2012</td>
											<td class=" ">20</td>
										</tr>										
										<tr class="even">
											
											<td class=" ">user1wow</td>
											<td class=" "><a href="mailto:userwow@gmail.com">userwow@gmail.com</a>
											</td>
											<td class=" ">20</td>
											<td class="center  ">12.12.2012</td>
											<td class=" ">20</td>
										</tr>
										<tr class="odd">
											
											<td class=" ">weep</td>
											<td class=" "><a href="mailto:userwow@gmail.com">good@gmail.com</a>
											</td>
											<td class=" ">20</td>
											<td class="center  ">19.11.2010</td>
											<td class=" ">20</td>
										</tr>										
									</tbody>
								</table>
								<div class="row DTTTFooter">									
									<div class="col-sm-6">
										<div class="dataTables_paginate paging_bootstrap"
											id="simpledatatable_paginate">
											<ul class="pagination">
												<li class="prev disabled"><a href="#">Prev</a></li>
												<li class="active"><a href="#">1</a></li>
												<li class="next disabled"><a href="#">Next</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /Page Body -->
</div>
