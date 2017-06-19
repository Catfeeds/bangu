 <!--Basic Styles-->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
<style>
    .page-body{ margin: 0; padding: 0; padding: 20px;}
.table_list{display:none;}
    .breadcrumb {
    padding-left: 10px;
    background: #fff none repeat scroll 0% 0%;
    height: 40px;
    line-height: 40px;
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);
    -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);
    -moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, .2);
}


.breadcrumb li {
    float: left;
    padding-right: 10px;
    color: #777;
    -webkit-text-shadow: none;
    text-shadow: none;
}

.breadcrumb>li+li:before {
    padding: 0 5px;
    color: #ccc;
    content: "/\00a0";
}
    
    .page-content {
    display: block;
    margin-left: 160px;
    margin-right: 0;
    margin-top: 0;
    min-height: 100%;
    padding: 0;
} 
.fa-home {
    width: 16px;
    height: 16px;
    position: absolute;
    left: 0;
    top: -3px;
    background: url(../../../../assets/img/home.png) 0 0 no-repeat;
    display: inline-block;
}
    .bg_gray{ background: none;}
    .nav-tabs>li{ height:30px;}
    .table>tbody>tr>td{ padding: 10px 5px;}
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus{ height: 40px; background: #fff}
    .boostCenter{ padding: 20px 0}
    .table_content{ padding: 0}
</style>
<div class="page-content">
    <div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
        <li class="active">退团审批</li>
    </ul>
</div>
<!--=================右侧内容区================= -->
    <div class="page-body" id="bodyMsg">
        <!-- ===============我的位置============ -->
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">
            <div class="table_content">
                <ul class="tab_nav nav nav-tabs tab_shadow clear" id="myTab" style="height:38px; background:none;">
                    <li name="tabs" class="active tab_red" id="tab_list1" status="1"><a href="###">申请中</a></li>
                    <li name="tabs"  class="tab-blue" id="tab_list2" status="2"><a href="###">已通过</a></li>
                    <li name="tabs" class="tab-green" id="tab_list3" status="3"><a href="###">已拒绝</a></li>
                </ul>
                <div class="tab_content">
                <!-- 申请中数据 -->
                    <div class="table_list" id="list1">
                    <form action="<?php echo base_url();?>admin/b2/league_approval/ajax_league_list" id='league_approval1' name='league_approval1' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <input type="hidden" name="league_status" value="0"/>
                    <div id="league_approval_dataTable1"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div>
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="boostCenter">
                                <ul class="pagination"> </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!--  End 申请中数据  -->
                        <!-- 已通过数据 -->
                    <div class="table_list" id="list2">
                          <form action="<?php echo base_url();?>admin/b2/league_approval/ajax_league_list" id='league_approval2' name='league_approval2' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <input type="hidden" name="league_status" value="1"/>
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <div id="league_approval_dataTable2"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div>
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="boostCenter">
                                <ul class="pagination"> </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!-- End 已通过数据 -->

                    <!-- 已拒绝数据 -->
                    <div class="table_list" id="list3">
                    <form action="<?php echo base_url();?>admin/b2/league_approval/ajax_league_list" id='league_approval3' name='league_approval3' method="post">
                    <!-- 其他搜索条件,放在form 里面就可以了 -->
                    <input type="hidden" name="league_status" value="3"/>
                    <div id="league_approval_dataTable3"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
                      <div>
                        <div class="dataTables_paginate paging_bootstrap">
                          <!-- 分页的按钮存放 -->
                          <div class="boostCenter">
                                <ul class="pagination"> </ul>
                            </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    </div>
                    <!-- End 已拒绝数据 -->
                </div>
            </div>
        </div>
    </div>

<!-- ********=================================弹框操作==================================********-->
<!-- 通过审批表单-->
<div style="display:none;" class="bootbox modal fade in" id="pass_modal">
    <div class="modal-dialog">
        <div class="modal-content" style="width:760px;">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">审批通过</h4>
            </div>
            <div class="modal-body" >
                    <form class="form-horizontal" role="form" id="pass_form" method="post" action="">
            <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">备注</label>
            <div class="col-sm-10">
                <textarea name="pass_remark" style="resize:none;width:100%;height:100%"></textarea>
                <input type="hidden" name="pass_id" id="pass_id" value=""/>
                <input type="hidden" name="pass_order_id" id="pass_order_id" value=""/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>

            </div>
        </div>
    </div>
</div>
<!--end 通过审批-->

<!-- 通过审批表单-->
<div style="display:none;" class="bootbox modal fade in" id="refuse_modal">
    <div class="modal-dialog">
        <div class="modal-content" style="width:760px;">
            <div class="modal-header">
                <button type="button" class="bootbox-close-button close" onclick="hidden_modal()">×</button>
                <h4 class="modal-title">审批拒绝</h4>
            </div>
            <div class="modal-body" >
                    <form class="form-horizontal" role="form" id="refuse_form" method="post" action="">
            <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">备注</label>
            <div class="col-sm-10">
                <textarea name="refuse_remark" style="resize:none;width:100%;height:100%"></textarea>
                <input type="hidden" name="refuse_id" id="refuse_id" value=""/>
            </div>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="float: right; margin-right: 2%;">
        </div>
    </form>
            </div>
        </div>
    </div>
</div>
</div>
<!--end 通过审批-->
<!--背景弹框-->
<div class="modal-backdrop fade in" style="display:none;" id="back_ground_modal"></div>
<!--end 背景弹框-->

 <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>
<script type="text/javascript">
var columnArr=[];


//隐藏弹框
function hidden_modal(){
  $("#back_ground_modal").hide();
  $("#refuse_modal").hide();
  $("#pass_modal").hide();
  $("#refuse_remark").val('');
  $("#pass_remark").val('');
  $("#pass_id").val('');
  $("#refuse_id").val('');
}

function refuse(refuse_id){
  $("#refuse_id").val(refuse_id);
  $("#back_ground_modal").show();
  $("#refuse_modal").show();
}

function pass(pass_id,order_id){
  $("#pass_id").val(pass_id);
  $("#pass_order_id").val(order_id);
   $("#back_ground_modal").show();
  $("#pass_modal").show();
}


$(document).ready(function(){
            //审批通过表单提交
            $("#pass_form").submit(function(){
                  $.post(
                         "<?php echo base_url();?>admin/b2/league_approval/pass_apply",
                        $('#pass_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                /*console.log(data);*/
                                if (data.status == 200){
                                     alert(data.msg);
                                     location.reload();
                                }else{
                                    alert(data.msg);
                                }
                        }
                    );
                    return false;
            });
            // End 审批通过表单提交

            //审批拒绝表单提交
            $("#refuse_form").submit(function(){
                  $.post(
                         "<?php echo base_url();?>admin/b2/league_approval/refuse_apply",
                        $('#refuse_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                console.log(data);
                                if (data.status == 200){
                                     alert(data.msg);
                                     location.reload();
                                }else{
                                    alert(data.msg);
                                }
                        }
                    );
                    return false;
            });
            // End 审批拒绝表单提交
    });





//申请中列表
var league_record_columns_1=[
        {field : 'ordersn',title : '订单编号',width : '30',align : 'center'},
        {field : 'productname',title : '产品标题',width : '60',align : 'center'},
        {field : 'item',title : '应收项目',align : 'center', width : '45'},
        {field : 'num',title : '数量',align : 'center', width : '30'},
        {field : 'price',title : '单价',align : 'center', width : '30'},
        {field : 'amount',title : '小计',align : 'center', width : '30'},
        {field : 'addtime',title : '申请时间',align : 'center', width : '30'},
        {field : 'remark',title : '备注',align : 'center', width : '40'},
        {field : 'id',title : '操作',align : 'center', width : '40',
          formatter: function(value,rowData,rowIndex){
            var html = "<a href='javascript:void(0);' onclick='refuse("+value+")' class='tab-button but-blue'>拒绝</a>&nbsp&nbsp&nbsp";
                 html += "<a href='javascript:void(0);' onclick='pass("+value+","+rowData['order_id']+")' class='tab-button but-blue'>通过</a>";
                 return html;
        }
      }
      ];
//已通过
var league_record_columns_2=[
        {field : 'ordersn',title : '订单编号',width : '30',align : 'center'},
        {field : 'productname',title : '产品标题',width : '60',align : 'center'},
        {field : 'item',title : '应收项目',align : 'center', width : '45'},
        {field : 'num',title : '数量',align : 'center', width : '30'},
        {field : 'price',title : '单价',align : 'center', width : '30'},
        {field : 'amount',title : '小计',align : 'center', width : '30'},
        {field : 'addtime',title : '申请时间',align : 'center', width : '30'},
        {field : 'remark',title : '备注',align : 'center', width : '40'}
      ];
//已拒绝
var league_record_columns_3=[
       {field : 'ordersn',title : '订单编号',width : '30',align : 'center'},
        {field : 'productname',title : '产品标题',width : '60',align : 'center'},
        {field : 'item',title : '应收项目',align : 'center', width : '45'},
        {field : 'num',title : '数量',align : 'center', width : '30'},
        {field : 'price',title : '单价',align : 'center', width : '30'},
        {field : 'amount',title : '小计',align : 'center', width : '30'},
        {field : 'addtime',title : '申请时间',align : 'center', width : '30'},
        {field : 'remark',title : '备注',align : 'center', width : '40'}
      ];
columnArr[1] =   league_record_columns_1;
columnArr[2] =   league_record_columns_2;
columnArr[3] =   league_record_columns_3;
var isJsonp= false ;// 是否JSONP,跨域
$(document).ready(function(){
    initTableForm("#league_approval1","#league_approval_dataTable1",columnArr[1],isJsonp ).load();
      $("#myTab li").on("click",function(){
          $("#myTab li").removeClass("active");
          $(this).addClass("active");
          var index=$("#myTab li").index($(this))+1;
          initTableForm("#league_approval"+index,"#league_approval_dataTable"+index,columnArr[index],isJsonp ).load();
      });
});
</script>



