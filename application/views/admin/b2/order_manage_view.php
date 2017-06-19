 <style type="text/css">
.widget-body{box-shadow:none;-webkit-box-shadow:none;}
.page-body{ padding: 20px;}
.DTTTFooter{ background: none; border: none;}
.boostCenter{ padding: 20px 0; width: 100%;}
.table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px}
.fc-border-separate thead tr, .table thead tr{ background: #fff; border: 1px solid #ddd;}
.table>thead>tr>th, .table>tbody>tr>td{ border: 1px solid #ddd; padding: 10px 5px;}
.table thead.bordered-darkorange > tr > th { border: 1px solid #ddd;}
.table thead > tr > th { background: #fff; border: 1px solid #ddd;}
.formBox label{ margin-bottom: 0; float: left; width: 65px;}
.formBox input{ float: left;}
.formBox{ padding-bottom: 10px; padding-right: 0;padding-left:10px;}
.pageBox{ padding:0 10px 15px;}
.notA{ display: inline-block; padding: 0 5px; color: #09c;}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
input{ line-height:100%\9;}

.layui-layer-page{ margin-left: 80px;}
.thisBorder{ border: 1px solid #ddd;}
.thisBorder tr td { padding-left: 10px;border: 1px solid #f2f2f2;}
.order_info_title { background: #f8f8f8;text-align:right;}
.important_title  { color:#f00;font-size: 20px; top: 5px; position: relative; font-weight: normal;font-style: normal;}
.cBtn{ background: #0087B4; color: #fff; margin-right: 20px; border: none; margin-bottom: 20px;border:none !important;}
.cBtn:hover{color:#fff;background: #0087B4 !important;}
.input_text{padding:4px 0;}
.w_600{width:206px;}
/*进度样式
 * class="on_show" 完全蓝色
 * class="on_show" 一半蓝色  当前进度
 *
 */
.status_box ul{ overflow: hidden; padding-top: 10px;}
.status_box ul li{ width: 25%; float: left; position: relative;}
.status_box ul li .time, .status_box ul li .txt{ width: 100%;height: 20px; display: inline-block; text-align: center; margin-bottom: 30px;}
.status_box ul li .txt{ margin-bottom: 0;}
.status_box ul li i{ width: 20px;height: 20px; line-height: 20px; background: #eee; display: inline-block; position: absolute; top: 25px; left: 50%; margin-left: -10px; border-radius: 50%; z-index: 1;}
.status_box ul li em{ width: 100%;height: 2px; line-height: 20px; background: #eee; display: inline-block; position: absolute; top: 35px; left: 0;}
.status_box ul li strong{ display: none; width: 50%;height: 2px; line-height: 20px; background: #eee; display: inline-block; position: absolute; top: 35px; left: 0;}
.status_box ul li.on i{ background: #09c;}
.status_box ul li.on strong{ background: #09c; width: 50%; left: 0; display: block;}
.status_box ul li.on_show i{ background: #09c;}
.status_box ul li.on_show strong{ background: #09c; width: 100%; left: 0; display: block;}

.box-title h4 { margin:0;}
.table>tbody>tr>td.x-grid-cell{ padding: 6px;}


#show_pic_modal {
    position: fixed;
    top: 75px;
    left: 50%;
    margin-left: -109px;
    z-index: 20000000 !important;
    background: #fff;
    -webkit-background-clip: content;
    box-shadow: 1px 1px 50px rgba(0, 0, 0, .3);
    border-radius: 2px;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation-duration: .3s;
    animation-duration: .3s;
}


 </style>
 <link href="/assets/js/jQuery-plugin/combo/css/jquery.comboBox.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />

<?php $this->load->view("admin/b2/common/js_view"); //加载公用css、js   ?>

<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
        <li class="active">订单管理</li>
    </ul>
</div>

<div class="page-body">
<?php $this->load->view("admin/b2/common/dest_tree"); //加载树形目的地   ?>
    <div class="table_content" style=" padding-bottom: 0;background:#fff;">
        <form action="<?php echo base_url();?>admin/b2/order_manage/ajax_get_orders" id='order_list' name='order_list' method="post">
        <!-- 其他搜索条件,放在form 里面就可以了 -->
            <div class="form-inline formBox shadow">
		<div class="form-group">
                    <label class="search_title col_span" >产品名称:</label>
                    <input type="text" name="linename" class="form-control" style="width:120px;" >
             </div>

            <div class="form-group">
                    <label class="search_title col_span" >团队编号:</label>
                    <input type="text" name="team_num" class="form-control" style="width:100px;" >
             </div>

             <div class="form-group">
                    <label class="search_title col_span" >订单编号:</label>
                    <input type="text" name="order_sn" class="form-control ie8_input" style="width:100px" >
             </div>

		<div class="form-group">
                    <label class="search_title col_span" >出团日期:</label>
                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="开始时间" id="starttime" name="starttime" />
                    <label style="border:none ; width:auto;">-</label>
                    <input class="search-input form-control" style="width:90px;" type="text" placeholder="结束时间" id="endtime" name="endtime" />
             </div>
			<?php if($is_manage==1):?>
            <div class="form-group" style="margin-right:5px;">
                <label class="search_title col_span" >管家:</label>
                <select name="expert" class="ie8_select">
                        <option value=''>--请选择--</option>
                    <?php if(!empty($expert_info)):?>
                        <?php foreach($expert_info AS $val):?>
                        <option value="<?php echo $val['id']?>"><?php echo $val['realname']?></option>
                    <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <?php endif;?>
              <div class="form-group">
                    <label class="search_title col_span" >供应商:</label>
                    <input class="search-input form-control" style="width:120px;" type="text" id="supplier" name="supplier" />
                </div>

 				<div class="form-group">
                    <label class="search_title col_span" >出发地:</label>
                    <input class="search-input form-control" type="text" id="start_place" name="start_place" style="width: 100px;" />
                </div>
                
                <div class="form-group" >
                    <label class="search_title col_span" >订单状态:</label>
                    <select name="order_stastus" >
                      <option value="">--请选择--</option>
                      <option value="9">未提交</option>
                      <option value="10">等待经理审核</option>
                      <option value="2">向旅行社申请额度中</option>
                      <option value="3">向供应商申请额度中</option>
                      <option value="4">已确认</option>
                      <option value="8">行程结束</option>
                      <option value="6">已点评</option>
                      <option value="-4">已取消</option>
                    </select>
                </div>
                
               <div class="form-group">
                    <label class="search_title col_span" >目的地:</label>
                    <input class="" type="text" id="end_place" onfocus="showMenu(this.id,this.value,-44,16);" onkeyup="showMenu(this.id,this.value,-44,16);" placeholder="输入关键字搜索" name="end_place" style="width: 180px;" />
                    <input type="hidden" name="destid" id="input_dest" value=""/>
                </div>
               

                
                <button type="button" class="btn btn-darkorange" id="searchBtn" style="position: relative; top: 10px;float:left;"> 搜索 </button>
            </div>
			<div class="pageBox shadow">
	            <div id="order_list_dataTable"><!--列表数据显示位置--></div>
	            <div class="row DTTTFooter">
	                <div style="width:100%; overflow: hidden; text-align: center;">
	                    <div class="dataTables_paginate paging_bootstrap" style="float:none;">
	                        <!-- 分页的按钮存放 -->
	                        <div class="boostCenter"><ul class="pagination"></ul></div>
	                    </div>
	                </div>
	            </div>
            </div>
        </form>

    </div>
</div>
<!--End -->

<!--********************************Start信用申请*************************************-->
<div class="fb-content" id="limit_apply" style="display:none;">
    <div class="box-title">
        <h4>新增额度&nbsp;&nbsp;&nbsp;&nbsp;申请单</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <div class="status_box">
          <ul class="clear">
              <li class="on">
                  <span class="time current_time"></span><i></i><em></em><strong></strong><span class="txt">新增申请</span>
              </li>
              <li >
                  <span class="time"></span><i></i><em></em><strong></strong><span class="txt">经理审批</span>
              </li>
              <li >
                <span class="time"></span><i></i><em></em><strong></strong><span class="txt">旅行社/供应商授权</span>
              </li>
              <li>
                <span class="time"></span><i></i><em></em><strong></strong><span class="txt">已还款</span>
              </li>
          </ul>
        </div>
        <form method="post" action="#" id="apply_credit_form" class="form-horizontal">
            <div class="form_con limit_apply" style="padding: 10px;">
                <table class="order_info_table table_td_border thisBorder" width="100%" cellspacing="0" border="1">
                    <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请额度：</td>
                        <td colspan="3"><input type="text" class="w_200" name="apply_amount" value="" readonly style="background-color:#f1f1f1"/></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">编号：</td>
                        <td colspan="3" class="gtivo-left" id="td_sn"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请对象：</td>
                        <td colspan="3" class="gtivo-left" >
                            <select name="apply_type" id="apply_type" onchange="change_apply_type(this)" class="ie8_select">
                                <option value="1">旅行社-<?php echo $expert_info[0]['union_name']?></option>
                                <option value="2" class="option_supplier"></option>
                            </select>
                           
                        </td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title"><i class="important_title">*</i>申请日期：</td>
                        <td><input type="text" class="w_200 input_text" id="datetimepicker1" name="apply_date" value="" /></td>
                        <td class="order_info_title"><i class="important_title">*</i>还款日期：</td>
                        <td><input type="text" class="w_200 input_text" id="datetimepicker2" name="return_date" value="" /></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">申请人：</td>
                        <td class="gtivo-left" id="apply_people"></td>
                        <td class="order_info_title">营业部：</td>
                        <td class="gtivo-left" id="apply_depart"></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">说明：</td>
                        <td colspan="3"><input type="text" class="w_600 input_text" name="apply_remark"/></td>
                    </tr>
                </table>
            </div>
            <div class="form_btn clear">
                <input type="hidden" name="pay_code" id="pay_code" value="">
                <!-- <input type="hidden" name="min_apply_amount" id="min_apply_amount" value=""> -->
              <input type="hidden" name="manager_id"  value="">
             <input type="hidden" name="manager_name"  value="">
             <input type="hidden" name="depart_name"  value="">
             <input type="hidden" name="depart_id"  value="">
             <input type="hidden" name="is_manage"  value="<?php echo $is_manage?>">
             <input type="hidden" name="expert_id"  value="">
             <input type="hidden" name="expert_name"  value="">
             <input type="hidden" name="apply_order_id"  value="">
                <input type="submit" name="submit" value="提交审核" class="btn btn_blue cBtn" style="margin-left:280px;">
                <input type="reset" name="reset" value="关闭" class="layui-layer-close cBtn btn btn_gray">
            </div>
        </form>
    </div>
</div>
<!--********************************End 信用申请*************************************-->

<script type="text/javascript" src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>


<script type="text/javascript">
var is_manage = <?php echo $is_manage;?>;
	$(document).ready(function(){
	// 列数据映射配置
	var order_list_columns=[
			{field : 'ordersn',title : '订单号',width : '60',align : 'center',formatter:function(value,rowData,rowIndex){
                      var html = "";
                            html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+rowData['order_id']+"'>"+value+"</a>";
                            return html;
                          }},

                  {field : 'md_status',title : '状态',align : 'center', width : '60',
                      formatter:function(value,rowData,rowIndex){
                        switch(value){
                        		  case '-6':
							return '经理拒绝';
                            		  break;
                                  case '-4':
                                    if(rowData['ispay']==0){
                                      return '已取消';
                                    }else if(rowData['ispay']>=4 || rowData['ispay']<=6){
                                      return '已退订';
                                    }
                                    break;
                                  case '-3':
                                    return '退订中';
                                    break;
                                  case '-2':
                                    return '旅行社拒绝';
                                    break;
                                  case '-1':
                                    return '供应商拒绝';
                                    break;
                                  case '0':
                                    return '待留位';
                                    break;
                                  case '1':
                                    return '已预留位';
                                    break;
                                  case '2':
                                    return '<div title="向旅行社申请额度中">申请中</div>';
                                    break;
                                  case '3':
                                	return '<div title="向供应商申请额度中">申请中</div>';
                                    break;
                                  case '4':
                                    return '已确认';
                                    break;
                                  case '5':
                                    return '已出行';
                                    break;
                                  case '6':
                                    return '已点评';
                                    break;
                                  case '7':
                                    return '已投诉';
                                    break;
                                  case '8':
                                    return '行程结束';
                                  break;
                                  case '9':
                                    return '未提交';
                                  break;
                                  case '10':
                                  case '11':
                                    return '等待经理审核';
                                  break;
                                  default: return '订单状态';break;
                                }
                      }
                  },

               {field : 'linename',title : '线路标题',width : '200',align : 'left',formatter: function(value,rowData,rowIndex){
                     
                      return '<a href="###" dataid="'+rowData['line_id']+'"onclick="show_line_detail('+rowData['line_id']+',2)" >'+value+'</a>';
                }},
                  {field : 'team_code',title : '团队编号',width : '126',align : 'left'},
                  {field : 'usedate',title : '出团日期',align : 'center', width : '80'},
                //  {field : 'lineday',title : '天数',width : '70',align : 'left'},

//                   {field : 'linkman',title : '订单联系人',width : '90',align : 'left'},
//                   {field : 'linkmobile',title : '联系电话',width : '100',align : 'left'},
//                   {field : 'linecode',title : '线路编号',width : '70',align : 'left'},
			{field : 'unit',title : '人数',align : 'center', width : '50',formatter:function(value,rowData,rowIndex){
				if(value>=2){
					return rowData['dingnum'];
				}else{
					return rowData['people_num'];
				}
			}},
			{field : 'order_amount',title : '订单金额',align : 'right', width : '70'},
                  {field : 'supplier_cost',title : '结算价',align : 'right', width : '70'},
                  {field : 'agent_fee',title : '毛利',align : 'right', width : '60'},

                  {field : 'depart_name',title : '销售部门',align : 'center', width : '100'},
                  {field : 'realname',title : '销售员',align : 'center', width : '60'},

// 			{field : 'addtime',title : '下单时间',align : 'center', width : '110'},
 			{field : 'supplier_name',title : '供应商',width : '110',align : 'left',formatter: function(value,rowData,rowIndex){
                      
                      return '<a href="###" dataid="'+rowData['supplier_id']+'" name="supplierDetail">'+rowData['supplier_name']+'</a>';
                  }},
			
			{field:'order_id',title : '操作', align : 'center',width : '70',
				formatter: function(value,rowData,rowIndex){
                          var html = "";
						html = "<a class='notA' target='_blank' href='<?php echo site_url('admin/b2/order_manage/go_order_detail')?>?order_id="+value+" '>详情</a>";
                                    if(rowData['md_status']==9 || rowData['md_status']==-1 || rowData['md_status']==-2 || rowData['md_status'] == -6){
                                          var opra_name = "";
                                          if(rowData['md_status']==9){
                                              opra_name = "提交";
                                          }else{
                                             opra_name = "再次提交";
                                          }
                                          html += "<a class='notA' data-depart='"+rowData['depart_id']+"'' supplier-name='"+rowData['supplier_name']+"' data-line='"+rowData['line_id']+"'' data-order='"+value+"' onclick='resubmit(this)'>"+opra_name+"</a>"
                                    }
                                    if(rowData['md_status']==9){
                                      html += "<a class='notA' data-depart='"+rowData['depart_id']+"'' data-line='"+rowData['line_id']+"'' data-order='"+value+"' onclick='cancle_order(this)'>取消</a>"
                                    }
                                    return html;
				}
			}
		         ];
	var isJsonp= false ;// 是否JSONP,跨域
// 	var page = initTableForm("#order_list","#order_list_dataTable",order_list_columns,isJsonp );
	var url = $("#order_list").attr('action');
	var page = new jQuery.paging({renderTo:"#order_list_dataTable",url:url,form:"#order_list",columns:order_list_columns,rowCallback:function(index,record){
			if(record.md_status==9){
				return "row-red";
			}
		}});
	page.load();
	$("#searchBtn").click(function(){
// 		initTableForm("#order_list","#order_list_dataTable",order_list_columns,isJsonp ).load();
		page.load();;
	});
	//出发地
$.post('/admin/a/comboBox/get_startcity_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.cityname,
        value : val.id,
    });
  })
  var comboBox = new jQuery.comboBox({
      id : "#start_place",
      name : "start_place_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
});


	//目的地
/*$.post('/admin/a/comboBox/get_destinations_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.kindname,
        value : val.id,
    });
  })
  var comboBox = new jQuery.comboBox({
      id : "#end_place",
      name : "end_place_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
});*/

	//供应商
$.post('/admin/a/comboBox/get_supplier_data', {}, function(data) {
  var data = eval('(' + data + ')');
  var array = new Array();
  $.each(data, function(key, val) {
    array.push({
        text : val.company_name/*+'--'+val.company_name*/,
        value : val.id,
    });
  })
  var comboBox = new jQuery.comboBox({
      id : "#supplier",
      name : "supplier_id",// 隐藏的value ID字段
      query : [ "jp", "qp" ],// 查询列默认 可以不填写 默认查询text匹配的数据
      selectedAfter : function(item, index) {}, // 选择后的事件
      data : array
  });
});


    $('#datetimepicker1').datetimepicker({
                                    lang:'ch', //显示语言
                                    timepicker:false, //是否显示小时
                                    format:'Y-m-d', //选中显示的日期格式
                                    formatDate:'Y-m-d',
                                    validateOnBlur:false,
                                    yearStart:1930
                                });
    $('#datetimepicker2').datetimepicker({
                                    lang:'ch', //显示语言
                                    timepicker:false, //是否显示小时
                                    format:'Y-m-d', //选中显示的日期格式
                                    formatDate:'Y-m-d',
                                    validateOnBlur:false,
                                    yearStart:1930
                                });
 $('#datetimepicker').datetimepicker({
    lang:'ch', //显示语言
    timepicker:false, //是否显示小时
    format:'Y-m-d H:i:s', //选中显示的日期格式
    formatDate:'Y-m-d H:i:s',
    validateOnBlur:false,
    yearStart:1930
});

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


 $("#apply_credit_form").submit(function(){
                    if($('#apply_credit_form').find("input[name='apply_amount']").val()==""){
                            tan("申请额度必填");
                            return false;
                     }
                    /* if($('#apply_credit_form').find("input[name='apply_amount']").val()<$("#min_apply_amount").val()){
                            alert("申请额度最低应为:"+$("#min_apply_amount").val());
                            return false;
                     }*/
                     /* if($('#apply_type').val()==2){
                           if($("#apply_supplier").val()=="0"){
                                alert("供应商必选");
                                return false;
                           }
                     } */
                     if($("#datetimepicker1").val()==""){
                    	 tan("申请日期必填");
                         return false;
                     }
                     if($("#datetimepicker2").val()==""){
                    	 tan("还款日期必填");
                            return false;
                     }

                      if($("#datetimepicker1").val()>$("#datetimepicker2").val()){
                    	  tan("还款日期必须大于申请日期");
                            return false;
                     }

                    $('#apply_credit_form').find("input[type='submit']").val("正在提交...").css({"background":"#808080","cursor":"none"}).attr("disabled",true);
                    $.post(
                         "<?php echo base_url();?>admin/b2/order_manage/submit_apply_order",
                        $('#apply_credit_form').serialize(),
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

});



//1:旅行社; 2: 供应商
function change_apply_type(obj){
 /* if($(obj).val()==2){
    $("#apply_supplier").show();
  }else{
    $("#apply_supplier").hide();
  }*/
}


 function resubmit(obj){
  var order_id = $(obj).attr('data-order');
  var line_id   = $(obj).attr('data-line');
  var depart_id = $(obj).attr('data-depart');
  var supplier_name=$(obj).attr('supplier-name');

  $(".option_supplier").html("供应商-"+supplier_name);

  var index = layer.msg('提交中,请稍后..', { icon: 16, shade: 0.8,time: 200000 });
  $.post('/admin/b2/order_manage/resubmit_order',
    {'order_id':order_id,  'line_id':line_id, 'depart_id':depart_id},
    function(data) {
      layer.close(index);
      data = eval('('+data+')');
      if(data['status']==200){
    	  tan_alert(data['msg']);
        
      }else if(data['status']==201){
          var pay_sn = (new Date().getTime())+''+(Math.ceil(Math.random()*1000));
          pay_sn = 'A'+pay_sn.substr(pay_sn.length-6);
          $("#pay_code").val(pay_sn);
          $("#td_sn").html(pay_sn);
          $('#apply_credit_form').find("input[name='apply_amount']").val(data['msg']['diff_amount']);
          $('#apply_credit_form').find("input[name='manager_id']").val(data['msg']['manager_id']);
          $('#apply_credit_form').find("input[name='manager_name']").val(data['msg']['manager_name']);
          $('#apply_credit_form').find("input[name='depart_name']").val(data['msg']['depart_name']);
          $('#apply_credit_form').find("input[name='depart_id']").val(data['msg']['depart_id']);
          $('#apply_credit_form').find("input[name='expert_id']").val(data['msg']['expert_id']);
          $('#apply_credit_form').find("input[name='apply_order_id']").val(data['msg']['order_id']);
          $('#apply_credit_form').find("input[name='expert_name']").val(data['msg']['expert_name']);
          $("#apply_depart").html(data['msg']['depart_name']);
          $("#apply_people").html(data['msg']['expert_name']);
           layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                area: '700px',
                shadeClose: false,
                content: $('#limit_apply')
          });
      }else{
    	  tan_alert_noreload(data['msg']);
      }
    });
 }

 //取消订单
 function cancle_order(obj)
 {
      var order_id = $(obj).attr('data-order');
      var line_id   = $(obj).attr('data-line');
      var depart_id = $(obj).attr('data-depart');

      layer.confirm('是否取消订单？', { btn: ['是','否'] }, function(){
          //"是"操作
    	  $.post('/admin/b2/order_manage/cancle_order',
    			    {'order_id':order_id,  'line_id':line_id, 'depart_id':depart_id},
    			    function(data) 
    			    {
    			      data = eval('('+data+')');
    			      if(data['status']==200){
    			    	  tan_alert(data['msg']);
    			      }else{
    			          tan_alert(data['msg']);
    			          			       
    			      }
    			    }
    			  );
		  //end
     },function(){
            //"否"操作
         }
     );
      
     
      
     
 }
 
 //线路详情弹窗
	/*$('.table_content').on("click",'[name="lineDetail"]',function(){
		var me = $(this);
		var dataid = me.attr("dataid");

		window.top.openWin({
			title:'线路详情',
			type: 2,
			area: ['1000px', '90%'],
			fix: false, //不固定
			maxmin: true,
			content: "<?php echo base_url();?>admin/b2/pre_order/line_detail?id="+dataid
		});


	});*/
 //供应商详情弹窗
	$('.table_content').on("click",'[name="supplierDetail"]',function(){
		var dataid = $(this).attr("dataid");
		window.top.openWin({
			title:'供应商详情',
			type: 2,
			area: ['600px', '300px'],
			fix: false, //不固定
			maxmin: true,
			content: "<?php echo base_url();?>admin/b2/pre_order/supplier_detail?id="+dataid
		});

	});//end


</script>
<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>