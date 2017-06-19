
<!-- Page Breadcrumb -->

                <!-- /Page Breadcrumb -->
                <!-- Page Header -->
                <div class="page-header position-relative">
                    <div class="header-title">
                        <h1>
                            B2后台
                        </h1>
                    </div>
                    <div class="header-buttons">
                        <a class="sidebar-toggler" href="#">
                            <i class="fa fa-arrows-h"></i>
                        </a>
                        <a class="refresh" id="refresh-toggler" href="">
                            <i class="glyphicon glyphicon-refresh"></i>
                        </a>
                        <a class="fullscreen" id="fullscreen-toggler" href="#">
                            <i class="glyphicon glyphicon-fullscreen"></i>
                        </a>
                    </div>
                </div>
                <!-- /Page Header -->
                <!-- Page Body -->
               <div class="page-body" id="bodyMsg">
<form class="form-inline" method="post" action="<?php echo site_url('admin/b2/dest_apply/index')?>" >

    <div class="form-group">
        <label>目的地</label>
        <input type="text" class="form-control" name="destid" />
    </div>

    <div class="form-group">
        <label>状态</label>
        <select id="month" name="status" >
            <option value="-1" selected="selected">请选择</option>
            <option value="0">未通过</option>
            <option value="1">已通过</option>
        </select>
    </div>
    <button type="submit" class="btn btn-darkorange active" style="margin-left: 50px;">
        搜索
    </button>
</form><br /><br />
<table class="table table-striped table-hover table-bordered dataTable no-footer" id="editabledatatable" aria-describedby="editabledatatable_info">
    <thead>
        <tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px;">
                申请时间
            </th>
            <th class="sorting" tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 100px;">
                目的地
            </th>
            <th class="sorting" tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 150px;">
                状态
            </th>
            <th class="sorting" tabindex="0" aria-controls="editabledatatable" rowspan="1" colspan="1" style="width: 120px;">
                测试结果
            </th>

        </tr>
    </thead>

    <tbody>

    <?php foreach ($dest_apply_list as $item): ?>
        <tr>
            <td class="sorting_1"><?php echo $item['addtime'];?></td>
            <td class=" "><?php echo $item['kindname'];?></td>
            <td class="center  "><?php echo $item['status'];?></td>

            <td class=" "><?php echo '查看';?></td>

        </tr>
	<?php endforeach;?>


    </tbody>
</table>
<?php echo $page_link;?>
</div>
