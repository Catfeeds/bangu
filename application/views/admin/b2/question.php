<style type="text/css">
.nav-tabs{ background: none;box-shadow:none;-webkit-box-shadow:none; }
    .page-body .nav-tabs li{ padding: 0;background: #eaedf1;}
    .page-body{ padding: 20px;}
    .page-body .nav-tabs{ background: #fff; border-bottom: 1px solid #ddd;}
    .form-group input{ padding: 0; margin: 0; height:26px; line-height: 26px;}
    .form-group label{ margin:0; padding: 6px 5px; border: 1px solid #dedede; border-right: none}
    .table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px}
    .form-group{ margin-top: 0;}
	.form-group{ float:left}
	.ie8_input{ width:100px\9;}
	.ie8_select{ padding:5px 5px 6px 5px\9;}
	.ie8_pageBox{ width:50%\9; float:left\9}
	input{ line-height:100%\9;}
	.form-group1 input{ float:left}
	.form-control{ width: auto}
    .table>tbody>tr>td{ padding: 6px;}
	.tabbable { padding: 0 10px;background:#fff;}
	.tab-content { padding:10px 0 !important;}
</style>
<!-- Page Breadcrumb -->

                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
   <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                        <li><i class="fa fa-home"> </i> <a
            href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
                        <li class="active">客人问答</li>
                    </ul>
            </div>
 <!-- /Page Header -->
<!-- Page Body -->
	<div class="page-body" id="bodyMsg">
		<div class="widget">
			<!--  <div class="widget-body"> -->
			<div class="flip-scroll">
				<div class="tabbable">

					<ul id="myTab5" class="nav nav-tabs">

						<li  class="active">
						<a href="/admin/b2/question/index">已回复</a>
						</li>
						<li class="tab-red">
						<a href="/admin/b2/question/no_answer">未回复</a>
						</li>
					</ul>
					<div class="tab-content shadow">
						<div class="tab-pane active" id="tab1">
                            <div style=" width:100%; margin-bottom:10px;">
							<label>
								<form class="form-inline" method="post" action="<?php echo site_url('admin/b2/question/index')?>" style=" width:500px;" >

								 <div class="form-group form-group1" style="float:left;">
       							 <input type="text" class="form-control" name="linename" value="<?php echo $linename;?>" placeholder="模糊匹配" style=" display:inline; padding:0 10px;"/>


    							<button type="submit" class="btn btn-darkorange active fl" style="margin-left: 10px;">  线路搜索</button></div>

								</form>
							</label>
                            </div>
							<table class="table table-bordered table-hover">
								<thead>
								         <tr>
                                            <th style="text-align:center"> 会员 </th>
                                            <th style="text-align:center"> 线路 </th>
                                            <th style="text-align:center"> 最新时间 </th>
                                            <th style="text-align:center"> 咨询内容</th>
                                            <th style="text-align:center"> 回复内容</th>
                                            <th style="text-align:center"> 邮箱</th>

                                        </tr>
								</thead>
								<tbody>
               						 <?php foreach ($question_list as $item): ?>
                                        <tr>
                                        	<td style="text-align:center">
                                               <?php echo $item['truename'];?>
                                            </td>
                                            <td style="text-align:left" title="<?php echo $item['linename']?>">
                                                <?php echo empty($item['linename']) ? '客人提问' : str_cut($item['linename'] ,50);?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php echo $item['addtime'];?>
                                            </td>
                                            <td  style="text-align:center" title="<?php echo $item['content']?>">
                                                <?php echo str_cut($item['content'] ,50);?>
                                            </td>
                                            <td style="text-align:center" title="<?php echo $item['replycontent']?>">
                                                <?php echo str_cut($item['replycontent'] ,50);?>
                                            </td>
                                             <td style="text-align:center">
                                                <?php echo $item['email'];?>
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



<div id="question_myModal" style="display: none;">
<div class="bootbox-body">
    <form class="form-horizontal" role="form" method="post" action="<?php echo base_url();?>admin/b2/question/reply">
            <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">回复</label>
            <div class="col-sm-10">
                <textarea name="content" style="resize:none;width:100%;height:100%"></textarea>
                <input type="hidden" name="question_id" id="question_id" value=""/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>
</div>
</div>
