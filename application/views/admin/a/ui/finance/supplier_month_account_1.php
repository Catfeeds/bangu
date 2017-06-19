<style type="text/css">
   .form-group{ float: left; padding-right: 5px;}
    .nav-tabs{ margin-top: 20px}
</style>
<div class="page-content">
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
            <li class="active">供应商结算</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Body -->


                     <ul id="myTab5" class="nav nav-tabs">
                                            <li class="tab-red"><a href="<?php echo base_url(); ?>admin/a/finance/supplier_month_account" >未结算</a></li>
                                            <li class="active"><a href="<?php echo base_url(); ?>admin/a/finance/supplier_month_account_Settled" >已结算</a></li>
                                 </ul>

            <div class="tab-content">
                    <label>
                        <form class="form-inline" role="form" action="<?php echo base_url();?>admin/a/finance/supplier_month_account_Settled" method="post">
                            <div class="form-group dataTables_filter">
                               <input type="text" name="search_name"
                                    class="form-control" placeholder="供应商" value="<?php echo $search_name;?>">
                            </div>
                            <div class="form-group dataTables_filter" style="width:200px;">
                                    <div class="controls">
                                        <div class="input-group">
                                            <span class="input-group-addon"> <i class="fa fa-calendar">
                                            </i>
                                            </span> <input type="text" class="form-control" placeholder="创建日期"
                                                id="create_date" name="create_date" value="<?php echo $create_date;?>">
                                        </div>
                                    </div>
                            </div>
                               <div class="form-group dataTables_filter">
                               <input type="text" name="operator" class="form-control" placeholder="操作人" value="<?php echo $operator;?>">
                            </div>
                            <div class="form-group dataTables_filter">
                               <input type="text" name="supplier_brand" class="form-control" placeholder="供应商品牌" value="<?php echo $supplier_brand;?>">
                            </div>
                            <button type="submit" class="btn btn-darkorange" style="float:left;">搜索</button>
                        </form>
                    </label>


                    <table class="table table-striped table-hover table-bordered dataTable no-footer"
                        id="editabledatatable" aria-describedby="editabledatatable_info" style="font-size:13px;">
                        <thead>
                            <tr role="row">
                                <th class="sorting_disabled" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 120px;text-align:center">流水号</th>
                                <th class="sorting_disabled" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 300px;text-align:center">结算日期</th>
                                <th class="sorting_disabled" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 120px;text-align:center">创建日期</th>
                                <th class="sorting_disabled" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 120px;text-align:center">应付金额</th>
                                <th class="sorting_disabled" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 120px;text-align:center">结算金额</th>
                                <th class="sorting_disabled" tabindex="0" rowspan="1"
                                    colspan="1" style="width: 120px;text-align:center">供应商</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;text-align:center">备注</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;text-align:center">操作人</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;text-align:center">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach ($supplier_month_account_list as $item): ?>
                            <tr>
                                <td style="text-align:center"><?php echo $item['id']?></td>
                                <td style="text-align:center"><?php echo $item['startdatetime'].' 至 '.$item['enddatetime'].' 结算单 '?></td>
                                <td style="text-align:center"><?php echo $item['addtime']?></td>
                                <td style="text-align:center"><?php echo $item['amount']?></td>
                                <td style="text-align:center"><?php echo $item['real_amount']?></td>
                                <td style="text-align:center"><?php echo $item['company_name']?></td>
                                <td style="text-align:center"><?php echo $item['beizhu']?></td>
                                 <td style="text-align:center"><?php echo $item['realname']?></td>
                                <td style="text-align:center">
                                        <a target="_blank" class="btn btn-info btn-xs edit"
                                     href="<?php echo base_url();?>admin/a/finance/show_month_detail?id=<?php echo $item['id'];?>&starttime=<?php echo $item['startdatetime'];?>&endtime=<?php echo $item['enddatetime'];?>&addtime=<?php echo $item['addtime']?>&expert=<?php echo $item['realname']?>&beizhu=<?php echo $item['beizhu']?>">
                                     明细
                                    </a>
                                    <a data-val="<?php echo $item['id'];?>|<?php echo $item['userid'];?>|<?php echo $item['real_amount']?>" class="btn btn-info btn-xs edit" onclick="show_cancle_dialog(this)">
                                     撤销
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                     <div class="pagination"><?php echo $this->page->create_page()?></div>
                     </div>


    <!-- /Page Body -->
</div>
<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
$('#create_date').daterangepicker();

function show_cancle_dialog(obj){
    $(obj).removeAttr('onclick');
        $(obj).css('color','grey');
var mounth_data_arr = $(obj).attr('data-val').split('|');
        $.post("<?php echo base_url()?>admin/a/finance/ajax_cancle",
        {
            'mounth_id':mounth_data_arr[0],
            'userid':mounth_data_arr[1],
            'real_amount':mounth_data_arr[2],
             'user_type' : 2
        },
        function(data){
           data = eval('('+data+')');
            alert(data['msg']);
            location.reload();
        });
}
</script>



