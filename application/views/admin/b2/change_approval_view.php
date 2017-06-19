    <!--Basic Styles-->
<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
<link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
<style>
body,h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, img, ol, p { font-family: "微软雅黑"; font-size: 13px;}
.page-body{margin:0;padding:0;padding:20px}
.table_list{display:none}
.breadcrumb{padding-left:10px;height:40px;background:#fff none repeat scroll 0 0;-webkit-box-shadow:0 0 10px 0 rgba(0,0,0,.5);-moz-box-shadow:0 0 10px 0 rgba(0,0,0,.5);box-shadow:0 0 10px 0 rgba(0,0,0,.5);box-shadow:0 0 10px 0 rgba(0,0,0,.5);line-height:40px}
.breadcrumb li{float:left;padding-right:10px;color:#777;text-shadow:none;-webkit-text-shadow:none}
.breadcrumb>li+li:before{padding:0 5px;color:#ccc;content:"/\00a0"}
.fa-home:before{content:''}
.page-content{display:block;margin-top:0;margin-right:0;margin-left:160px;padding:0;min-height:100%}
.fa-home{position:absolute;top:-3px;left:0;display:inline-block;width:16px;height:16px;background:url(../../../../assets/img/home.png) 0 0 no-repeat}
.bg_gray{background:0 0}
.nav-tabs>li{height:30px}
.table>tbody>tr>td{padding:10px 5px}
.nav-tabs>li.active>a,.nav-tabs>li.active>a:focus,.nav-tabs>li.active>a:hover{height:40px;background:#fff}
.boostCenter{padding:20px 0; padding-bottom:8px;}
.table_content{padding:0;}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.tab_content{ padding:0 !important; background: none;}
.box-title h4{ padding-left: 20px; font-size: 16px;}
.blockInput{ box-shadow:none !important;width: 100%; height: 40px; border:none !important; }
.order_info_table tr td{ padding: 0;}
.formBox { min-height:auto;}
.formBox label,.formBox input{ float: left;}
.formBox select{ height: 26px;}
.tableBox{ padding:0px 15px 15px; background: #fff;}
.table_td_border>tbody>tr>td { border: 1px solid #ddd !important;}
.btn-palegreen{ background-color:#0099CC !important; border-color:#09c !important;}
.btn-palegreen:hover{ background-color:#0099CC !important; border-color:#09c !important; opacity:0.9;}
.but-blue{ display:inline-block;padding:0 5px;color:#09c;}
.form-group{ margin:0; padding:10px; padding-left:0;}
.form-group label{ margin:0}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
input{ line-height:100%\9;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}
</style>
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<?php $this->load->view("admin/b2/common/js_view"); //加载公用css、js   ?>
<!--=================右侧内容区================= -->
<div class="page-content">
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url('admin/b2/home/index')?>">主页</a></li>
        <li class="active">改价退团审批</li>
    </ul>
</div>
    <div class="page-body" id="bodyMsg">
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray">
            <div class="table_content" style="padding-top:0 !important;">

                <div class="tab_content">
                <!-- 数据 -->
                    <div class="table_list" id="list">
                    <form action="<?php echo base_url();?>admin/b2/change_approval/ajax_approval_list" id='change_approval' name='change_approval' method="post">
                          <!-- 其他搜索条件,放在form 里面就可以了 -->
		            <div class="form-inline formBox shadow" style="padding-left:0;">
		             <div class="form-group">
		                    <label class="search_title col_span" >订单编号:</label>
		                    <input type="text" name="order_sn" class="form-control ie8_input" >
		             </div>

		                <div class="form-group">
		                    <label class="search_title col_span" >申请日期:</label>
		                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
		                    <label style="border:none;width:auto;">-</label>
		                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
		                </div>

		                <div class="form-group">
		                            <label class="search_title col_span" >申请状态:</label>
		                            <select name="apply_status" class="ie8_select">
		                                <option value="0">未审核</option>
		                                <option value="1">已通过</option>
		                                <option value="3">已拒绝</option>
		                            </select>
		                      </div>

		                      <div class="form-group">
		                            <label class="search_title col_span" >申请人:</label>
		                            <select name="expert" class="ie8_select">
		                                <option value=''>--请选择--</option>
		                              <?php if(!empty($expert_info)):?>
		                                <?php foreach($expert_info AS $val):?>
		                                <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
		                              <?php endforeach;?>
		                              <?php endif;?>
		                            </select>
		                      </div>
		                <button type="button" class="btn btn-darkorange" id="searchBtn" style="position: relative; top: 10px;"> 搜索 </button>
		            </div>
				<div class="tableBox" style="padding-left:0;">
                    <div id="change_approval_dataTable"><!--列表数据显示位置--></div>
                    <div class="row DTTTFooter">
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
                    <!--  End 数据  -->
                </div>
            </div>
        </div>
    </div>

<!-- ********=================================弹框操作==================================********-->


<div class="fb-content" id="refuse_form_modal" style="display:none;">
    <div class="box-title">
        <h4>审批拒绝</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
  <div class="fb-form">
    <form  class="form-horizontal" action="#" id='refuse_form' name='refuse_form' method="post">
                <table class="order_info_table table_td_border" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title" style="border: none !important;">拒绝理由:</td>
                        <td colspan="5" style="border: none !important;"><input type="text" name="refuse_remark" class="blockInput" style="border: 1px solid #dcdcdc !important;margin:2px 0 !important;" /></td>
                    </tr>
                </table>
                <div style="text-align:center;">
                  <input type="hidden" name="refuse_id" id="refuse_id" value=""/>
                   <input type="hidden" name="refuse_yf_id" id="refuse_yf_id" value=""/>
                   <input type="hidden" name="refuse_order_id" id="refuse_order_id" value=""/>
                   <input type="hidden" name="refuse_kind" id="refuse_kind" value=""/>
                  <input type="hidden" name="refuse_depart_id" id="refuse_depart_id" value=""/>
                  <input type="hidden" name="refuse_refund_id" id="refuse_refund_id" value=""/>
                  <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="margin:20px 0px;">
                </div>
              </form>
    </div>
</div>


<div class="fb-content" id="pass_form_modal" style="display:none;">
    <div class="box-title">
        <h4>审批通过</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;"></a>
        </span>
    </div>
  <div class="fb-form">
    <form  class="form-horizontal" action="#" id='pass_form' name='pass_form' method="post">
                <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">通过理由:</td>
                        <td colspan="5"><input type="text" name="pass_remark" class="blockInput"/></td>
                    </tr>
                </table>
                <div style="text-align:center;">
                  <input type="hidden" name="pass_id" id="pass_id" value=""/>
                  <input type="hidden" name="pass_order_id" id="pass_order_id" value=""/>
                  <input type="hidden" name="yf_id" id="yf_id" value=""/>
                  <input type="hidden" name="yf_kind" id="yf_kind" value=""/>
                  <input type="hidden" name="pass_depart_id" id="pass_depart_id" value=""/>
                  <input type="hidden" name="pass_refund_id" id="pass_refund_id" value=""/>

                  <!-- <input type="submit" class="btn btn-palegreen" data-bb-handler="success"  value="提交" style="margin:20px 0px;"> -->
                </div>
              </form>
    </div>
</div>



 <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>
 <script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript">
function refuse(obj,refuse_id,yf_id,refuse_order_id,refuse_kind,refuse_depart_id,refuse_refund_id){
  $("#refuse_id").val(refuse_id);
  $("#refuse_yf_id").val(yf_id);
  $("#refuse_order_id").val(refuse_order_id);
  $("#refuse_kind").val(refuse_kind);
  $("#refuse_depart_id").val(refuse_depart_id);
  $('#refuse_refund_id').val(refuse_refund_id);
/*  $(obj).remove();
  layer.confirm('是否确定拒绝？', { btn: ['是','否'] }, function(){
          $("#refuse_form").submit();
  },function(){});*/
   layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: '580px',
                    shadeClose: false,
                    content: $('#refuse_form_modal')
          });
}

function pass(obj,pass_id,order_id,yf_id,y_kind,pass_depart_id,pass_refund_id)
{
   $("#pass_id").val(pass_id);
   $("#pass_order_id").val(order_id);
   $("#yf_id").val(yf_id);
   $("#yf_kind").val(y_kind);
   $("#pass_depart_id").val(pass_depart_id);
   $("#pass_refund_id").val(pass_refund_id);
   
    layer.confirm('是否确定通过？', { btn: ['是','否'] }, function(){
       $("#pass_form").submit();
       $(obj).remove();
  },function(){});

/*    layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    area: '580px',
                    shadeClose: false,
                    content: $('#pass_form_modal')
          });*/
}


$(document).ready(function(){
            //审批通过表单提交
            $("#pass_form").submit(function(){
              //$("#pass_form").find("input[type=submit]").before("<span style='color:blue'>已提交,请稍候......</span>").remove();
                  $.post(
                         "<?php echo base_url();?>admin/b2/change_approval/pass_apply",
                        $('#pass_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                //console.log(data);
                                if (data.status == 200){
                                     tan_alert(data.msg);
                                    
                                }else{
                                	tan_alert(data.msg);
                                   
                                }
                        }
                    );
                    return false;
            });
            // End 审批通过表单提交

            //审批拒绝表单提交
            $("#refuse_form").submit(function(){
              if($(this).find("input[name=refuse_remark]").val()==""){
                tan('拒绝理由必填');
                return false;
              }
              $("#refuse_form").find("input[type=submit]").before("<span style='color:blue'>已提交,请稍候......</span>").remove();
                  $.post(
                         "<?php echo base_url();?>admin/b2/change_approval/refuse_apply",
                        $('#refuse_form').serialize(),
                        function(data){
                                data = eval('('+data+')');
                                if (data.status == 200){
                                	tan_alert(data.msg);
                                     
                                }else{
                                	tan_alert(data.msg);
                                     
                                }
                        }
                    );
                    return false;
            });
            // End 审批拒绝表单提交
$('#starttime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
$('#endtime').datetimepicker({
  lang:'ch', //显示语言
  timepicker:false, //是否显示小时
  format:'Y-m-d', //选中显示的日期格式
  formatDate:'Y-m-d',
  validateOnBlur:false,
});
    });

function trimStr(str){
	return str.replace(/(^\s*)|(\s*$)/g,"");
	}
//申请中列表
var apply_record_columns=[
        {field : 'ordersn',title : '订单编号',width : '30',align : 'center',

           formatter: function(value,rowData,rowIndex){
            return "<a target='_blank' href='<?php echo  base_url()?>admin/b2/order_manage/go_order_detail?order_id="+rowData['order_id']+"'>"+value+"</a>";
          }

        },
        {field : 'item',title : '申请类型',width : '45',align : 'center',formatter: function(value,rowData,rowIndex){
            var value_str;
            if(trimStr(value)=='退团')
            	value_str=value;
            else
            	value_str="改价";
            return "<font style=''>"+value_str+"</font>";
        }
        },
        {field : 'ys_amount',title : '退应收',align : 'right', width : '32',
        	formatter: function(value,rowData,rowIndex){
            	
                return "<font style='color:#008000'>"+value+"</font>";
              }
        },
        
        {field : 'yf_amount',title : '退应付',align : 'right', width : '32',
        	formatter: function(value,rowData,rowIndex){
        		if(trimStr(rowData.item)!="退团")
            		value="";
                return "<font style='color:#008000'>"+value+"</font>";
              }
        },
        {field : 'sk_money',title : '退已交款',align : 'right', width : '45',
        	formatter: function(value,rowData,rowIndex){
            	if(trimStr(rowData.item)!="退团")
            		value="";
        	
                return "<font style='color:#008000'>"+value+"</font>";
              }
           },
        //{field : 'tui_num',title : '退单人数',align : 'center', width : '40'},
        {field : 'total_price',title : '订单金额',align : 'right', width : '45'},
         {field : 'receive_amount',title : '已收款',align : 'right', width : '30'},
         {field : 'receive_amount',title : '未收款',align : 'right', width : '30',
         formatter: function(value,rowData,rowIndex){
            return rowData['total_price']-value;
          }
        },
        
        {field : 'addtime',title : '申请时间',align : 'center', width : '30'},
        {field : 'user_name',title : '申请人',align : 'center', width : '40'},
        {field : 'depart_name',title : '销售部门',align : 'center', width : '40'},
          {field : 'ys_status',title : '状态',align : 'center', width : '40',
              formatter: function(value,rowData,rowIndex){
                          if(value==1){
                            return "<span style='color:blue'>已通过</span>";
                          }else if(value==3){
                            return "<span style='color:red'>已拒绝</span>";
                          }else{
                            return "未提交";
                          }
              }
          },

        {field : 'ys_id',title : '操作',align : 'center', width : '40',
          formatter: function(value,rowData,rowIndex){
            var html="";
            if(rowData['ys_status']==1 || rowData['ys_status']==3){
                html = "";
            }else{
                 html  = "<a href='javascript:void(0);' onclick='refuse(this,"+value+","+rowData['yf_id']+","+rowData['order_id']+","+rowData['kind']+","+rowData['depart_id']+","+rowData['refund_id']+")' class='tab-button but-blue'>拒绝</a>";
                 html += "<a href='javascript:void(0);' onclick='pass(this,"+value+","+rowData['order_id']+","+rowData['yf_id']+","+rowData['kind']+","+rowData['depart_id']+","+rowData['refund_id']+")' class='tab-button but-blue'>通过</a>";
            }
            return html;
        }
      }
      ];

var isJsonp= false ;// 是否JSONP,跨域
$(document).ready(function(){
    initTableForm("#change_approval","#change_approval_dataTable",apply_record_columns,isJsonp ).load();
    $("#searchBtn").click(function(){
       initTableForm("#change_approval","#change_approval_dataTable",apply_record_columns,isJsonp ).load();
    });
});
</script>
