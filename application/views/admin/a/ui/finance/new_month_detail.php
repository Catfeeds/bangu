<link href="<?php echo base_url();?>assets/css/v2/base.css" rel="stylesheet" type="text/css">
<style type="text/css">
body { background:#fff;}
body:before { background:#fff;}
.main_content { width:1000px;margin:0 auto;padding-top:20px;}
.lineName { padding-bottom:20px;padding-top:0;}
.tab-content{
    -webkit-box-shadow: inherit;
    -moz-box-shadow: inherit;
    box-shadow: inherit;
}

/*
.table thead th{ text-align: center;}
	.table tbody td{text-align: center;}
	#form_refund_search .form-group{float:left;padding-right: 5px;}
	.form-group{  padding-right: 5px;}
	.table-toolbar{margin-left: 5px;}
	.form-inline .form-group{ margin-bottom: 15px;}
	*/
</style>

<!--startprint1-->
<div class="main_content" id="web_print">
	<div class="content_part">

         <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
           <tr height="40">
               <td class="order_info_title">创建时间:</td>
               <td><?php echo $addtime;?></td>
               <td class="order_info_title">创建人:</td>
               <td><?php echo $creator['creator'];?></td>
           </tr>

            <tr height="40">
               <td class="order_info_title">开户银行:</td>
               <td><?php echo $creator['bankname'];?></td>
               <td class="order_info_title">银行支行:</td>
               <td><?php echo $creator['brand'];?></td>
           </tr>
            <tr height="40">
               <td class="order_info_title">开户人:</td>
               <td><?php echo $creator['openman'];?></td>
               <td class="order_info_title">银行卡号:</td>
               <td><?php echo $creator['bank'];?></td>
           </tr>

              <tr height="40">
               <td class="order_info_title">结算单号:</td>
               <td colspan="3" style="padding:5px 10px;"><?php echo $account_month_id;?></td>
           </tr>
           <tr height="40">
               <td class="order_info_title">备注:</td>
               <td colspan="3" style="padding:5px 10px;"><?php echo $beizhu;?></td>
           </tr>
                </table>
    </div>
    <!--===============已选择订单================ -->
    <div class="content_part">
        <div class="small_title_txt clear">
            <span class="txt_info fl">已选择订单</span>
            <span class="order_time fr"></span>
        </div>
    <div class="tab-content">
        <form action="<?php echo site_url('admin/a/finance/get_order_list')?>" id='search_condition' class="form-inline clear" method="post">
            <input type="hidden" name="page_new" class="page_new" value=""/>
            <input type="hidden" name="account_month_id" class="account_month_id" value="<?php echo $account_month_id?>"/>
        </form>
        <div class="dataTables_wrapper form-inline no-footer">
            <table class="table table-striped table-hover table-bordered dataTable no-footer" >
                <thead id="pagination_title"></thead>
                <tbody id="pagination_data"></tbody>
            </table>
        </div>
        <div class="pagination" id="pagination"></div>
    </div>
    <div class="tab-content">
        <div class="dataTables_wrapper form-inline no-footer">
            <table class="table table-striped table-hover table-bordered dataTable no-footer" >
            <thead>
                <tr>
                        <th style="width: 20px;text-align:center;">╲</th>
                        <th style="width:100px;text-align:center;">订单总金额</th>
                        <th style="width:100px;text-align:center;">管家佣金总金额</th>
                        <th style="width:100px;text-align:center;">平台管理费总金额</th>
                        <?php if($creator['account_type']==1):?>
                        <th style="width:100px;text-align:center;">管家佣金结算总金额</th>
                    <?php else:?>
                        <th style="width:100px;text-align:center;">供应商结算总金额</th>
                    <?php endif;?>
                </tr>
            </thead>
            <tbody>
                <tr>
                        <td style="text-align:center;">总计</td>
                        <td style="text-align:center;"><?php echo $sum_price['sum_total_price']?></td>
                        <td style="text-align:center;"><?php echo $sum_price['sum_agent_fee']?></td>
                        <td style="text-align:center;"><?php echo $sum_price['sum_platform_price']?></td>
                        <td style="text-align:center;"><?php echo $sum_price['sum_amount']?></td>
                </tr>
            </tbody>
            </table>
        </div>
        <div class="pagination" id="pagination"></div>
    </div>
    </div>
    <!--===============修改记录================ -->
    <div class="content_part">
        <div class="small_title_txt clear">
            <span class="txt_info fl">修改记录</span>
            <span class="order_time fr"></span>
        </div>
         <div class="tab-content">
        <form action="<?php echo site_url('admin/a/finance/get_edit_list')?>" id='search_condition2' class="form-inline clear" method="post">
            <input type="hidden" name="page_new" class="page_new" />
            <input type="hidden" name="account_month_id" class="account_month_id" value="<?php echo $account_month_id?>"/>
        </form>
        <div class="dataTables_wrapper form-inline no-footer">
            <table class="table table-striped table-hover table-bordered dataTable no-footer" >
                <thead id="pagination_title2"></thead>
                <tbody id="pagination_data2"></tbody>
            </table>
        </div>
        <div class="pagination" id="pagination2"></div>
    </div>
    </div>
</div>
<!--endprint1-->

<div style="width:80px; text-align: center;height: 40px;line-height: 40px;margin: 50px auto;background: #2dc3e8;color:#fff;border-radius: 4px;cursor: pointer;">
<span id="btnPrint" onclick="preview(1)" style="display:block">打印</span>


</div>

<div style="display:none;" class="bootbox modal fade in" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close-button close" >×</button>
                <h4 class="modal-title">备注修改</h4>
            </div>
            <div class="modal-body">
                <div class="bootbox-body">
                    <form class="form-horizontal" role="form" id="addFormData" method="post">
                    <div class="form-group">
                        <div class="col-sm-10 col_ts">
                            <textarea name="beizhu" rows="6" style="width:100%;" placeholder="备注修改"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <input name="account_order_id" id="account_order_id" type="hidden" value=""/>
                        <input name="month_account_id" id="month_account_id" type="hidden" value=""/>
                        <input class="close-button form-button" value="关闭" type="button"/>
                        <input class="form-button" value="提交" type="submit"/>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade in" style="display:none;"></div>



<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script src="<?php echo base_url("assets/js/jQuery-plugin/jquery.jqprint-0.3.js") ;?>"></script>

<script type="text/javascript">
var columns = [
                        {field : 'ordersn',title : '订单编号',width : '100',align : 'center'},
                        {field : 'productname',title : '产品标题',width : '150',align : 'center'},
                        {field : 'people_num',title : '人数',align : 'center', width : '40'},
                        {field : 'usedate',title : '出团日期',align : 'center', width : '100' ,length:20},
                        {field : null,title : '订单金额',align : 'center', width : '90',formatter:function(item){
                                return (item.total_price*1).toFixed(2);
                        }},
                        {field : null,title : '管家佣金',align : 'center', width : '80' ,length:20,formatter:function(item){
                                return (item.agent_fee*1).toFixed(2);
                        }},
                        {field : 'platform_fee',title : '管理费',align : 'center', width : '80',length:20},
                        {field : 'invoice_entity',title : '发票主体',align : 'center', width : '90'},
                        {field : null,title : '结算金额',align : 'center', width : '80' ,length:20, formatter:function(item){
                                return (item.total_price-item.platform_fee-item.agent_fee).toFixed(2);
                        }},
                        {field : null,title : '备注',align : 'center', width : '160' ,length:20,formatter: function(item) {
                            if(item.beizhu==""){
                                item.beizhu="无";
                            }
                            var txt = '';
                            txt += '<div style="min-height:40px" data-id="'+item.mao_id+'|'+item.ma_id+'" onclick="editor_this(this);">'+item.beizhu+'</div>';
                            txt += '<textarea class="editor_box" style="position:absolute;width:100%;box-sizing:border-box;top:0;left:0;resize:none;display:none;" onmouseout="check_editor(this);">'+item.beizhu+'</textarea>';
                            return txt;
                        }},
                        {field : null,title : '修改备注',align : 'center', width : '150',formatter: function(item) {
                            var button = '';
                            button += '<a href="javascript:void(0);" data-id="'+item.mao_id+'|'+item.ma_id+'" onclick="edit_beizhu(this);" class="btn btn_blue ">修改</a>';
                            return button;
                        }
                        }
            ];
var columns2 = [
                {field : 'ad_name',title : '修改人',width : '100',align : 'center'},
                {field : 'addtime',title : '修改时间',width : '150',align : 'center'},
                {field : null,title : '修改前金额',align : 'center', width : '80', formatter:function(item){
                                return (item.before_amount*1).toFixed(2);
                        }},
                {field : null,title : '修改后金额',align : 'center', width : '160' ,length:20, formatter:function(item){
                                return (item.after_amount*1).toFixed(2);
                        }},
                 {field : 'remark',title : '修改原因',align : 'center', width : '80'}
                 ];
var inputId = {'formId':'search_condition','title':'pagination_title','body':'pagination_data','page':'pagination'};
var inputId2 = {'formId':'search_condition2','title':'pagination_title2','body':'pagination_data2','page':'pagination2'};
ajaxGetData(columns ,inputId);
ajaxGetData(columns2 ,inputId2);

function edit_beizhu(obj){
    var mount_id_arr = $(obj).attr('data-id').split("|");
    $.post("<?php echo base_url('admin/a/finance/get_account_remark')?>",{'account_id':mount_id_arr[0]},
                function(data){
                    data = eval('('+data+')');
                    $("textarea[name='beizhu']").val(data[0]['beizhu']);
                    $("#account_order_id").val(mount_id_arr[0]);
                    $("#month_account_id").val(mount_id_arr[1]);
                    $(".bootbox,.modal-backdrop").show();
                });
}


//编辑备注
function editor_this(obj){
    var beizhu_txt = $(obj).html();
    var h = $(obj).parent().parent().height();
    $(obj).parent().css({"height":h+"px","box-sizing":"border-box","position":"relative"});
    $(obj).siblings("textarea").css("height",h+"px").show();
    $(obj).siblings("textarea").focus().css("border","1px solid #f60");
}
function check_editor(obj){
       var data_txt = $(obj).siblings("div").html();
        var data_val = $(obj).val();
         var mount_id_arr = $(obj).siblings("div").attr('data-id').split("|");
        if(data_val===data_txt){
            if(confirm("你没有修改任何内容,确认取消？")){
                    $(obj).siblings("div").html(data_val);
                    hide_editor();
            }
        }else{
           if(confirm("是否保存编辑的内容？")){
                    $(obj).siblings("div").html(data_val);
                     $.post("/admin/a/finance/edit_account_remark",{"account_order_id":mount_id_arr[0],"month_account_id":mount_id_arr[1],"beizhu":data_val},function(data){
                        var data = eval("("+data+")");
                        if (data.code == 2000) {
                            alert(data.msg);
                           ajaxGetData(columns ,inputId);
                           //hide_editor();
                          self.opener.location.reload();
                        } else {
                            alert(data.msg);
                        }
                    });

            }
        }
}

function hide_editor(){
    $(".editor_box").hide();
}

$("#addFormData").submit(function() {
    var url = "/admin/a/finance/edit_account_remark";
    $.post(url,$(this).serialize(),function(data){
        var data = eval("("+data+")");
        if (data.code == 2000) {
            alert(data.msg);
           ajaxGetData(columns ,inputId);
          self.opener.location.reload();
           $(".close-button").trigger('click');
        } else {
            alert(data.msg);
        }
    })
    return false;
});

// function  print_web(){
//     $("#web_print").jqprint({
//         debug: false,
//         importCSS: true,
//         printContainer: true



//     });
// }

$(".close-button").click(function(){
    $(".bootbox,.modal-backdrop").hide();
    $("textarea[name='beizhu']").val('');
    $("#account_order_id").val('');
     $("#month_account_id").val('');
})



</script>

<script>
function preview(oper) {
    if (oper < 10){
        bdhtml=window.document.body.innerHTML;//获取当前页的html代码
        sprnstr="<!--startprint"+oper+"-->";//设置打印开始区域
        eprnstr="<!--endprint"+oper+"-->";//设置打印结束区域
        prnhtml=bdhtml.substring(bdhtml.indexOf(sprnstr)+18); //从开始代码向后取html
        prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));//从结束代码向前取html
        window.document.body.innerHTML=prnhtml;
        window.print();
        window.document.body.innerHTML=bdhtml;
    } else {
        window.print();
    }
}
</script>

























