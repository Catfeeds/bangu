<div class="page-content">
    <!-- Page Breadcrumb -->
    <div class="page-breadcrumbs">
        <ul class="breadcrumb">
            <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
            <li class="active">管家结算</li>
        </ul>
    </div>
    <!-- /Page Breadcrumb -->
    <!-- Page Body -->


                     <ul id="myTab5" class="nav nav-tabs">
                                            <li class="active"><a href="<?php echo base_url(); ?>admin/a/finance/expert_month_account" >未结算</a></li>
                                            <li class="tab-red"><a href="<?php echo base_url(); ?>admin/a/finance/expert_month_account_Settled" >已结算</a></li>
                                 </ul>

            <div class="tab-content">
                    <label>
                        <form class="form-inline" role="form" action="<?php echo base_url();?>admin/a/finance/expert_month_account" method="post">
                          <div style="float:left;">
                                 <a class="btn btn-info btn-xs" target="_blank" class="btn btn-info btn-xs edit"
                                     href="<?php echo base_url();?>admin/a/finance/show_expert_add_order" style=" padding:6px 7px; margin-right:55px; font-size:12px;">新增结算单
                                     </a>
                           </div>
                            <div class="form-group dataTables_filter">
                               <input type="text" name="search_name"
                                    class="form-control" placeholder="管家" value="<?php echo $search_name;?>">
                            </div>
                            <div class="form-group dataTables_filter"style="width:250px">
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
                            <button type="submit" class="btn btn-darkorange" style="flaot:left;">搜索</button>
                        </form>
                    </label>
                   <!--  <div>
                    <a class="btn btn-info btn-xs" target="_blank" class="btn btn-info btn-xs edit" href="<?php echo base_url();?>admin/a/finance/show_expert_add_order">新增结算单
                    </a>
                    </div> -->

                    <table class="table table-striped table-hover table-bordered dataTable no-footer"
                        id="editabledatatable" aria-describedby="editabledatatable_info">
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
                                    colspan="1" style="width: 120px;text-align:center">专家</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;text-align:center">备注</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;text-align:center">操作人</th>
                                    <th class="sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;text-align:center">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php foreach ($expert_month_account_list as $item): ?>
                            <tr>
                                <td style="text-align:center"><?php echo $item['id']?></td>
                                <td style="text-align:center"><?php echo $item['startdatetime'].' 至 '.$item['enddatetime'].' 结算单 '?></td>
                                <td style="text-align:center"><?php echo $item['addtime']?></td>
                                <td style="text-align:center"><?php echo $item['amount']?></td>
                                <td style="text-align:center"><?php echo $item['real_amount']?></td>
                                <td style="text-align:center"><?php echo $item['realname']?></td>
                                <td style="text-align:center"><?php echo $item['beizhu']?></td>
                                 <td style="text-align:center"><?php echo $item['realname_operator']?></td>
                                <td style="text-align:center">
                                    <a target="_blank" class="btn btn-info btn-xs edit"
                                     href="<?php echo base_url();?>admin/a/finance/show_month_detail?id=<?php echo $item['id'];?>&starttime=<?php echo $item['startdatetime'];?>&endtime=<?php echo $item['enddatetime'];?>&addtime=<?php echo $item['addtime']?>&expert=<?php echo $item['realname']?>&beizhu=<?php echo $item['beizhu']?>">
                                     明细
                                    </a>
                                    <a data-val="<?php echo $item['id'];?>|<?php echo $item['userid'];?>|<?php echo $item['real_amount']?>" class="btn btn-info btn-xs edit" onclick="show_pass_dialog(this)">
                                    确认
                                    </a>

                                    <a data-val="<?php echo $item['id'];?>|<?php echo $item['userid'];?>|<?php echo $item['real_amount']?>" class="btn btn-info btn-xs edit" onclick="edit_amount_dialog(this)">
                                    修改
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

<div style="display:none;" class="bootbox modal fade in" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close-button close" >×</button>
                <h4 class="modal-title">结算金额修改</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body">
                    <form class="form-horizontal" role="form" id="editAmount" method="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">结算金额<span class="input-must">*</span></label>
                        <div class="col-sm-10 col_ts">
                            <input type="text" class="form-control"  name="newAmount" id="newAmount" value="">
                            <input type="hidden" class="form-control"  name="oldAmount" id="oldAmount" value="">
                            <input type="hidden" class="form-control"  name="account_id" id="account_id" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label no-padding-right col_lb">修改原因<span class="input-must">*</span></label>
                        <div class="col-sm-10 col_ts">
                           <textarea name="edit_reason" id="edit_reason"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="" name="id">
                        <input class="close-button form-button" value="关闭" type="button">
                        <input class="form-button" value="提交" type="submit">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>



<script src="<?php echo base_url(); ?>assets/js/datetime/moment.js"></script>
<script src="<?php echo base_url(); ?>assets/js/datetime/daterangepicker.js"></script>
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">

$('#create_date').daterangepicker();
    function show_pass_dialog(obj){
        $(obj).removeAttr('onclick');
        $(obj).css('color','grey');
        var mounth_data_arr = $(obj).attr('data-val').split('|');
        $.post("<?php echo base_url()?>admin/a/finance/ajax_pass",
        {
            'mounth_id':mounth_data_arr[0],
            'userid':mounth_data_arr[1],
            'real_amount':mounth_data_arr[2],
            'user_type' : 1
        },
        function(data){
             bootbox.dialog({
                    message: '确认成功',
                    title: "通过",
                    buttons: {
                        success: {
                            label: "Success",
                            className: "btn-success",
                             callback: function() {
                                 location.reload();
                             }
                         },
                    }
            });
        });
    }

    $("#editAmount").submit(function() {
    $.post('/admin/a/finance/ajax_edit_amount',$(this).serialize(),function(data){
        var data = eval("("+data+")");
        if (data.code == 200) {
            alert(data.msg);
            location.reload();
        } else {
            alert(data.msg);
        }
    })
    return false;
})


    function edit_amount_dialog(obj){
        var data_arr = $(obj).attr('data-val').split('|');
        $("#account_id").val(data_arr[0]);
        $("#oldAmount").val(data_arr[2]);
        $("#newAmount").val(data_arr[2]);
        $(".bootbox,.modal-backdrop").show();
    }


    $(".close-button").click(function(){
        $("#account_id").val('');
        $("#oldAmount").val('');
        $("#newAmount").val('');
        $("#edit_reason").val('');
        $(".bootbox,.modal-backdrop").hide();
})



</script>

