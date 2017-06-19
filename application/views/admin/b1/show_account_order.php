<!DOCTYPE html>
<!--
BeyondAdmin - w_1200 Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 1.0.0
Purchase: http://wrapbootstrap.com
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title>供应商管理系统</title>
    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="/bangu.ico" type="image/x-icon"/> 
    <!--Basic Styles-->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link id="bootstrap-rtl-link" href="" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/weather-icons.min.css');?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/css/hm.widget.css');?>" rel="stylesheet" />

    <!--Fonts-->
    <link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/demo.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/ht/css/base.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />
    <link href="" rel="stylesheet" />
    <link id="skin-link" href="" rel="stylesheet" type="text/css" />
    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
    <!--Basic Scripts-->
    <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <!--Beyond Scripts-->
    <script src="<?php echo base_url('assets/js/beyond.min.js');?>"></script>
    <script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
    <!-- /Page Breadcrumb -->
	<style type="text/css">
	body:before{ background:#fff;}
	* { box-sizing: border-box;}
	.th_head th {
		text-align: center;
	}
	
	.th_body td {
		text-align: center;
		width: 150px;
	}
	input[type="checkbox"], input[type="radio"]{
		position: relative;
	}
	.fl{
		float: left;
	}
	.tbtsd { left:15%;}
	.order_detail { margin:0;}
	.input-group .input-group-addon { float:left;}
	.form-control { height:auto;}
	.input-group input { width:220px !important;}
	</style>
</head>
<!-- /Head -->
<!-- Body -->
<body>


 <div class="page-body w_1000" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">您的位置：
            <a href="#" class="main_page_link"><i></i>首页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">供应商后台</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">结算管理</a>
        </div>
        <div class="order_detail">
            <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                <tr style="height:40px;">
                    <td class="order_info_title">创建时间:</td>
                    <td width="40%"><?php echo $create_time;?><input type="hidden" name="create_time" id="create_time"
                        value="<?php echo $create_time;?>" /></td>
                    <td class="order_info_title">创建人:</td>
                    <td width="40%"><?php echo $supplier;?><input type="hidden" name="creator" id="creator"
                        value="<?php echo $supplier;?>" /></td>
                </tr>
                <tr style="height:40px;">
                    <td class="order_info_title"><span style="color: red;">*</span>开始时间:</td>
                    <td width="40%">
                        <div class="input-group">
                            <input class="form-control date-picker" id="start_time" type="text" data-date-format="yyyy-mm-dd"> 
                        </div>
                    </td>
                    <td class="order_info_title">结束时间:</td>
                    <td width="40%">
                        <div class="input-group">
                            <input class="form-control date-picker" id="end_time" placeholder="不填写(默认当前时间)"  type="text" data-date-format="yyyy-mm-dd">
                        </div>
                    </td>
                </tr>
                <tr style="height:40px;">
                    <td class="order_info_title">备注:</td>
                    <td colspan="3"><textarea style="width: 650px;height:40px;resize:none;margin-top:4px;" name="baizhu" id="beizhu"></textarea></td>
                </tr>
                <tr style="height:40px;">
                    <td class="order_info_title"><span style="color: red;">*</span>开户银行:</td>
                    <td width="40%">
                        <div class="input-group">
                            <input class="form-control date-picker" id="bankname" placeholder="开户银行" type="text" name="bankname" value="<?php if(!empty($supplier_bank['bankname'])){ echo $supplier_bank['bankname'];} ?>"> 
                        </div>
                    </td>
                    <td class="order_info_title"><span style="color: red;">*</span>开户银行支行:</td>
                    <td width="40%">
                        <div class="input-group">
                            <input class="form-control date-picker" id="brand" placeholder="开户银行支行"  name="brand" type="text" value="<?php if(!empty($supplier_bank['brand'])){ echo $supplier_bank['brand'];} ?>" > 
                        </div>
                    </td>
                </tr>
                <tr style="height:40px;">
                    <td class="order_info_title"><span style="color: red;">*</span>开户人:</td>
                    <td>
                        <div class="input-group">
                            <input class="form-control date-picker" id="openman" placeholder="开户人" 
                                type="text" name="openman" value="<?php if(!empty($supplier_bank['openman'])){ echo $supplier_bank['openman'];} ?>"> 
                        </div>
                    </td>
                    <td class="order_info_title"><span style="color: red;">*</span>开户帐号:</td>
                    <td>
                        <div class="input-group">
                            <input class="form-control date-picker" id="bank_num" name="bank_num" placeholder="开户帐号" 
                                type="text" value="<?php if(!empty($supplier_bank['bank'])){ echo $supplier_bank['bank'];} ?>" > 
                        </div>
                    </td>
                </tr>
            </table>
            <div class="form_btn clear" style="text-align:center;">
                <input type="hidden" name='orderIds' id='orderIds' value="" />
                <input type="hidden" name='orderType' id="orderType" value="" />
                <input class="btn btn_blue" type="button" onclick="openAddOrder(this)"  style="margin-left:44%;" value="选择订单结算">
            </div>
            <div id="choose_order" style="margin-top:15px;"></div>
		</div>
    </div>

</div>


<!-- 未结算弹出框 -->
<div class="bgsd" style="display: none;"></div>
<div style="display: none;" class="tbtsd">
	<div class="closetd" style="opacity: 0.2; padding:0 0 0 8px;font-size: 20px; font-weight: 800;">×</div>
	<div align="center" style="height:100%;">
		<div class="widget-body" style="height:100%;">
			<div id="registration-form" class="messages_show" style="height:90%;overflow-y:auto;overflow-x:hidden;margin-top:35px; ">
				<form
					data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
					data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
					data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
					data-bv-message="This value is not valid"
					class="form-horizontal bv-form" method="post" id="listForm"
					novalidate="novalidate">
					<div class="form-group has-feedback">
						<label class="col-lg-4 control-labe fl" style="width:auto;top:6px;">订单编号：</label>
						<div class="col-lg-4 fl" style="width:220px;">
							<input type="text" name="ordersnid"
								class="form-control user_name_b1"> <input type="hidden"
								name="status" class="form-control user_name_b1" value='0'>
								<input type="hidden" name="starttime" value="" />
								<input type="hidden" name="endtime" value="" />
						</div>
						<label class="col-lg-4 control-labe fl" style="width:auto;top:6px;">状态：</label>
						<div class="col-lg-4 fl" style="width:110px;">
						      <select name="order_status" id="order_status" style="width:110px;height:32px;">
						      <option value=1 selected="selected">已出行</option>
						       <option value=2>已确定</option>
						      <option value=3>已退团</option>
						      </select>
						</div>
						<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
						<div class="col-lg-4 fl" style="width: 80;">
							<input type="button" value="搜索" id="searchBtn" class="btn btn-palegreen">
						</div>
					</div>
				</form>	
				<form action="<?php echo base_url();?>admin/b1/account/show_supplier_add_order" id='supplier_unsettled_order' name='supplier_unsettled_order' method="post" onSubmit="return check()">
					<div id="account_list"></div>
					<div style="margin-top: 15px;"><input type="submit" class="btn btn-info btn-xs" style="width:55px;height:30px;margin:10px;" value="提交">
                    <input type="button" onclick="javascript:window.opener=null;window.open('','_self');window.close();"  class="btn btn-info btn-xs" style="width:55px;height:30px;margin:10px;" value="关闭"></div>
                 </form>		
			</div>
		</div>
	</div>
</div>

</body>
<!--  /Body -->
</html>			
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script type="text/javascript">
   //     function openAddOrder(){
    //        var starttime=$('#start_time').val();
    //        var endtime=$('#end_time').val();
     //       window.open('<?php //echo base_url();?>admin/b1/account/show_supplier_order?starttime='+starttime+'&endtime='+endtime,
    //       	'newwindow','height=560,width=1600,top=50,left=50,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
    //    }
	    function openAddOrder(){
	   	    var starttime=$('#start_time').val();
	        var endtime=$('#end_time').val();
	        if(starttime==''){
		        alert('请选择结算的开始时间');
		        return false;
		    }
	        $('input[name="starttime"]').val(starttime);
	        $('input[name="endtime"]').val(endtime);     
	        // 查询
	        jQuery("#searchBtn").click();
	 	 	$(".bgsd,.tbtsd").show();
	 		
	    }
	    $(".closetd").click(function(e) {
		        $(".bgsd,.tbtsd").hide();
		   });
		   
	    $("#checkall").click(function(){
	        if(this.checked){
	            $("input[name='order[]']").each(function(){this.checked=true;});
	        }else{
	            $("input[name='order[]']").each(function(){this.checked=false;});
	        }
	    });
	    //选中复制
	    function check(){
	        //获取选中的ID,设置到上级页面
	        var order_sn= $("input[name='orderIds']").val();
	        var order_status= $("#order_status").val();
	        var orderArr=new Array();
	     //   var orderIds =order_sn ;
	        var orderIds='';
	    /*     if(order_sn !=''){
	        	orderArr=order_sn.split(",");
		     } */
	        $("input[name='order[]']").each(function(){ 
	            if(this.checked){
	            	orderIds+=$(this).val()+","; 
	          /*   	if(order_sn!=''){   
		                if($.inArray($(this).val(),orderArr) ==-1){
		                	orderIds+=$(this).val()+","; 
			             }
	            	}else{
	            		   orderIds+=$(this).val()+",";
		            } */
	            }
	        });
	        
	        $("input[name='orderType']").val(order_status);
	        $("input[name='orderIds']").val(orderIds);
	        refresh_order();
        	if(orderIds==''){
            	alert('请选择结算单');
           		return false;
            }
	        $('.closetd').click();
	        return false ; 
	    }

        // 根据 orderIds 异步获取数据,刷新下面的数据表格
        function addOrderData(){
        	var ids = $("#orderIds").val();
        	var start_time = $("#start_time").val();
        	var end_time = $("#end_time").val();
        	var beizhu = $("#beizhu").val();
        	var bankname=$("input[name='bankname']").val();
        	var brand=$("input[name='brand']").val();
        	var openman=$("input[name='openman']").val();
        	var bank_num=$("input[name='bank_num']").val();
        	var orderType=$("input[name='orderType']").val();
        	if(brand==''){
                   alert("请填写开户银行");
                   return false;
        	}
        	if(bankname==''){
        	       alert("请填写开户银行支行");
                   return false;
        	}
        	if(openman==''){
        	       alert("请填写开户人");
                   return false;
        	}
        	if(bank_num==''){
        	       alert("请填写开户帐号");
                   return false;
        	}

        	$.post("<?php echo base_url();?>admin/b1/account/add_supplier_order",
        			{
        				'order_ids':ids,	
        				'start_time':start_time,
        				'end_time':end_time,
        				'beizhu':beizhu,
        				'brand':brand,
        				'bankname':bankname,
        				'bank_num':bank_num,
        				'openman':openman,
        				'orderType':orderType
        			},
        			function(data){
        				 var data=eval("("+data+")");
            			if(data.status==1){
                				alert('添加成功');
                             			window.opener.location.reload();
                              			window.close();
                              			location.reload();
	                		 }else if(data.status==-2){
	                			 alert(data.msg);
	                    		}else{
	                    			 alert(data.msg);
					location.reload();
	                    		}          			
  			});
        }

        function refresh_order(){
        	var ids = $("#orderIds").val();
        	
        
        	$.post("<?php echo base_url();?>admin/b1/account/show_supplier_ajax_order",
        			{
        				'order_ids':ids,
        			},
        			function(data){
        				$("#choose_order").html('');
	        				var order_list = $.parseJSON(data);
	        				//con
	        				var str_html="";
	        				str_html += "<table class='table table-striped table-hover table-bordered dataTable no-footer' style=''> <tr class='th_head'>";
	        				str_html += "<th style='width:8%'>订单编号</th>";
	        				str_html += "<th style='width:30%'>产品标题</th>";
	        				str_html += "<th style='width:8%'>参团人数</th>";
	        				str_html += "<th style='width:8%'>出团日期</th>";
	        				str_html += "<th style='width:8%'>订单金额</th>";
	        				str_html += "<th style='width:8%'>管家佣金</th>";
	        				str_html += "<th style='width:8%'>平台使用费</th>";
	        				str_html += "<th style='width:8%'>实付金额</th>";
	        				str_html += "<th style='width:8%'>操作</th>";
	        				str_html += "</tr>";
	        				$.each(order_list,function(key,val){  
	        				//alert(val['order_id']);                              
	        					str_html += "<tr class='th_body' id='order-"+val['order_id']+"'>";
	        					str_html += "<td>"+val['ordersn']+"</td>";
	        					str_html += "<td>"+val['productname']+"</td>";
	        					str_html += "<td>"+val['people_num']+"</td>";
	        					str_html += "<td>"+val['usedate']+"</td>";
	        					str_html += "<td>"+val['order_amount']+"</td>";
	        					if(val['status']>3){ //已出团，已确定----- 管家佣金
	        						str_html += "<td>"+val['agent_fee']+"</td>";
	        					}else{
	        						 str_html += "<td>0</td>";
		        				}
	        					if(val['status']>3){ //已出团，已确定---------平台
		        						if(val['a_rate']==null){
			        						   str_html += "<td></td>";
				        				    }else{
				        						str_html += "<td>"+(val['a_rate'])+"</td>";
					        			}
		        				   }else{
		        					   str_html += "<td>0</td>";
			        			   }
	        		
			        			if(val['status']>3){ //已出团，已确定
			        				if(val['real_pay']==null){
			        					str_html += "<td></td>";
				        			}else{	
			        					str_html += "<td>"+val['real_pay']+"</td>";	
				        			}
				        		}else{
				        			str_html += "<td>"+(val['real_pay']-val['total_amount']).toFixed(2)+"</td>";	
					        	}

	        					str_html += "<td><a href='##' onclick='del_orderth(this,"+val['order_id']+")'>删除</a></td>";
	        					str_html +="</tr>";
	        				});
	        				str_html += "</table>"
	        				str_html +="<button onclick='addOrderData()'  class='btn btn-info btn-xs' style='width:55px;height:30px;margin:20px;' >保存</button>";
	        				str_html +="<button onclick='javascript:window.close();' class='btn btn-info btn-xs' style='width:55px;height:30px;margin:20px;'>关闭</button>";
	        				//if(order_list!=''){

	        				$("#choose_order").html(str_html);
		        			//}
  			});
        }
        function del_orderth(obj,id){
        	var ids = $("#orderIds").val();
        	var orderArr=ids.split(",");
        	var ordersn=''
		    for (var i = 0; i < orderArr.length; i++) {
                if (orderArr[i] != id) { 
                	if(i < orderArr.length-1){
                	     ordersn=ordersn+orderArr[i]+',';  
                	}else{
                		ordersn=ordersn+orderArr[i];  
                    }     
                }
      	  	}
        	$("#orderIds").val(ordersn);
            $("#order-"+id).remove();
        }
        $('#start_time').datepicker();
        $('#end_time').datepicker();
</script>
<?php echo $this->load->view('admin/b1/common/account_order_script'); ?>	