<div class="page-content">
	<!-- Page Breadcrumb -->
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">仪表盘</li>
		</ul>
	</div>
	<!-- /Page Breadcrumb -->
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="well with-header with-footer">
					<div class="table-toolbar">
						<a  href="<?php echo site_url('admin/a/expert/expert_list')?>"
							class="btn btn-default"> 返回专家列表</a>
		
					</div>
					<div class="widget">
						<div class="widget-header ">
							<span class="widget-caption">专家线路详情</span>
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
										            	供应商
										        </label>
										        <input type="text" class="form-control" placeholder="专家名称">
										    </div>
										    <div class="form-group dataTables_filter">
										        <label class="sr-only" >
										            	目的地
										        </label>
										        <input type="text" class="form-control"  placeholder="目的地">
										    </div>
										    <div class="form-group dataTables_filter">
										        <label class="sr-only" >
										            	线路名称
										        </label>
										        <input type="text" class="form-control"  placeholder="线路名称">
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
											<th >线路编号</th>
											<th >线路标题</th>
											<th >订单金额</th>
											<th >佣金比例</th>
											<th >问答数量</th>
											<th >供应商名称</th>
											<th >级别</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($line as $v):?>	
										<tr class="odd">
																					
											<td class=" "><?php echo $v['线路编号'] ;?></td>
											<td class=" "><?php echo $v['线路名称'] ;?></td>
											<td class=" "><?php echo $v['订单金额'] ;?></td>
											<td class="center  "><?php echo $v['佣金比例'] ;?></td>
											<td class=" "><?php echo $v['问答数量'] ;?></td>
											<td><?php echo $v['供应商名称'] ;?></td>
											<td>
												<?php 
													if ($v['grade'] == 0) {
														echo '初级';
													} elseif($v['grade'] == 1) {
														echo '中级';
													} elseif($v['grade'] == 2) {
														echo '高级';
													}
													
												?>
											</td>
											
										</tr>										
										<?php endforeach;?>							
									</tbody>
								</table>
								<div class="pagination"><?php echo $this->page->create_page()?></div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
	<!-- /Page Body -->
</div>
