<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
<meta charset="utf-8" />
<title>管家管理系统</title>
<meta name="description" content="Dashboard" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" />
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
<script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
<style type="text/css">
	body{ font-family: "微软雅黑";}
	body:before{ background-color: #EAEDF1;}
	.breadcrumb>li>a{ color: #09c;}
	.th_head th {text-align: center;}
	.th_body td {text-align: center;width: 150px;}
	input[type="checkbox"], input[type="radio"]{position: relative;}
	.fl{float: left;}
	
	.shadow {border: 1px solid #ddd; box-shadow:none}
	.tab-content{ width: 1020px; margin: 0 auto;}
	.td_b{ height:34px; line-height: 34px; display: block; width: 80px;float: left; font-weight: bold;}
	.td_p{ height: 34px; line-height: 34px;float: left;}
	.tableBox{margin-left: 200px;}
	.tableBox tr{ margin: 10px 0;display: block;}
	.inputBox{ width:360px; float: left; margin: 5px 0; margin-right:50px; overflow: hidden;}
	.bigbox{ width: 1000px; padding-left: 0px; margin: 0 100px; overflow: hidden;}
	.input-group{ width: 262px !important;}
	.textareaBox{ float: left; width: 100%; margin: 5px 0; line-height: 20px;}
	.textareaThis{min-width: 600px; min-height: 100px; padding: 5px}
	.add_orderBox{ width: 100%; margin: 20px 0;  float: left; text-align: center; margin-left: -100px;}
	.page-breadcrumbs{ width: 1020px; margin: 0 auto; background: #fff; border-bottom: none;}
	.addCorder,.addCorder:hover{text-decoration:none;cursor:hand; background: #09c; padding: 3px 8px; color: #fff; cursor: pointer; border-radius: 1px; margin-left: 3px;}
</style>
</head>
<body>
	
<div class="page-breadcrumbs shadow">
	<ul class="breadcrumb">
		<li>
		<i class="fa fa-home"></i> <a href="#">首页</a></li>
		<li class="active">我的帐户</li>
	</ul>
</div>

<div class="shadow tab-content">
	<form name="" class="bigbox">
		<table class="tableBox" >
			<div class="inputBox">
				<div class="td_b">创建时间：</div>
				<div class="td_p"><?php echo $create_time;
					?>
					<input  type="hidden" name="create_time" id="create_time" value="<?php echo $create_time;?>"/>
				</div>
			</div>
			
			<div class="inputBox">
				<div class="td_b">创建人：</div>
				<div class="td_p"><?php echo $creator;
					?>
					<input type="hidden" name="creator" id="creator" value="<?php echo $creator;?>"/>
					<input type="hidden" name="expert_id" id="expert_id" value="<?php echo $expert_id;?>"/>
				</div>
			</div>
			
			<div class="inputBox">
				<div class="td_b">开始时间：</div>
				<div class="td_p">
					<div class="input-group">
						<input class="form-control date-picker"  id="start_time" type="text" data-date-format="yyyy-mm-dd">
						<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
					</div>
				</div>
			</div>
			
			<div class="inputBox">
				<div class="td_b">结束时间：</div>
				<div class="td_p">
					<div class="input-group">
						<input class="form-control date-picker"  id="end_time" type="text" data-date-format="yyyy-mm-dd">
						<span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
					</div>
				</div>
			</div>
			
			<div class="inputBox">
				<div class="td_b">开户银行：</div>
				<div class="td_p">
					<div class="input-group">
						<input class="form-control "  id="bank_name" type="text" name="bank_name" value="<?php echo $expert_info['bankname']?>">
					</div>
				</div>
			</div>
			
			<div class="inputBox">
				<div class="td_b">银行支行：</div>
				<div class="td_p">
					<div class="input-group">
						<input class="form-control "  id="brand" name="brand" type="text" value="<?php echo $expert_info['branch']?>">
					</div>
				</div>
			</div>
			
			<div class="inputBox">
			    <div class="td_b">银行卡号：</div>
				<div class="td_p">
				   <div class="input-group">
						<input class="form-control "  id="bank_num" type="text" name="bank_num" value="<?php echo $expert_info['bankcard']?>">
				   </div>
				</div>
			</div>
			
			<div class="inputBox">
				<div class="td_b">开户人姓名：</div>
				<div class="td_p">
				   <div class="input-group">
				    	<input class="form-control "  id="openman" name="openman" type="text" value="<?php echo $expert_info['cardholder']?>">
				   </div>
				</div>
			</div>
			
			<div class="textareaBox">
				<div class="td_b">备注：</div>
				<textarea name="baizhu" id="beizhu" class="textareaThis"></textarea>
			</div>
			
			<div class="add_orderBox">
				<input  type="hidden"  name='orderIds' id='orderIds'  value=""/> <!--用来保存选中的ID-->  
				已选择订单 <a data-val='' id="add_order_a" onclick="openAddOrder(this)" target="_blank" class="addCorder">新增结算单</a>
				<div id="choose_order"></div>
			</div>
		</table>
	</form>
</div>
</body>
<script src="<?php echo base_url();?>assets/js/datetime/bootstrap-datepicker.js"></script>
<script src="/assets/js/jQuery-plugin/combo/jquery.comboBox.js"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>

<script type="text/javascript">
        function openAddOrder(){
            var expertId=$("#expert_id").val() ;
            var start_time = $("#start_time").val();
            var end_time = $("#end_time").val();
            var beizhu  = $("#beizhu").val();

             var bank_name=$("#bank_name").val() ;
            var brand = $("#brand").val();
            var bank_num = $("#bank_num").val();
            var openman  = $("#openman").val();


            if(start_time=='' || start_time=='undefine'){
            	alert('请选择结算的开始时间');
                         return false;
              }
            if(end_time=='' || end_time=='undefine'){
            	alert('如不选择结算时间,将默认为今天的日期时间');
              }
            window.open('<?php echo base_url();?>admin/b2/expert/show_expert_unsettled_order?expertId='+expertId+'&start_time='+start_time+'&end_time='+end_time+'&beizhu='+beizhu,
            	'newwindow','height=560,width=1600,top=50,left=50,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');
        }

        // 根据 orderIds 异步获取数据,刷新下面的数据表格
        function addOrderData(){
        	var ids = $("#orderIds").val();
        	var expert_id = $("#expert_id").val();
        	var start_time = $("#start_time").val();
        	var end_time = $("#end_time").val();
        	var beizhu = $("#beizhu").val();

            var bank_name=$("#bank_name").val() ;
            var brand = $("#brand").val();
            var bank_num = $("#bank_num").val();
            var openman  = $("#openman").val();

                if(bank_name=='' || bank_name=='undefine'){
                alert('请填写银行名称');
                         return false;
              }
            if(brand=='' || brand=='undefine'){
                alert('银行支行必填');
                return false;
              }
              if(bank_num=='' || bank_num=='undefine'){
                        alert('银行卡号必填');
                         return false;
              }
            if(openman=='' || openman=='undefine'){
                alert('开户人必填');
                 return false;
              }

        	$.post("<?php echo base_url();?>admin/b2/expert/add_expert_order",
        			{
        				'order_ids':ids,
        				'expert_id':expert_id,
        				'start_time':start_time,
        				'end_time':end_time,
        				'beizhu':beizhu,
                        'bank_name':bank_name,
                        'brand':brand,
                        'bank_num':bank_num,
                        'openman':openman
        			},
        			function(data){
                        data = eval('('+data+')');
                        if(data.code==200){
                               alert(data.msg);
                               window.opener.location.reload();
                               window.close();
                        }else{
                            alert(data.msg);
                        }
  			});

        }

        function refreshOrder(){
        	var ids = $("#orderIds").val();
        	var expert_id = $("#expert_id").val();
        	$.post("<?php echo base_url();?>admin/b2/expert/show_expert_ajax_order",
        			{
        				'order_ids':ids,
        				'expert_id':expert_id
        			},
        			function(data){
        				$("#choose_order").html('');
        				var order_list = $.parseJSON(data);
        				var str_html="";
        				str_html += "<table class='table table-striped table-hover table-bordered dataTable no-footer'> <tr class='th_head'>";
        				str_html += "<th>订单编号</th>";
        				str_html += "<th>产品标题</th>";
        				str_html += "<th>参团人数</th>";
        				str_html += "<th>出团日期</th>";
        				str_html += "<th>订单金额</th>";
        				str_html += "<th>管家结算金额</th>";
        				str_html += "</tr>";
        				$.each(order_list,function(key,val){
        					str_html += "<tr class='th_body'>";
        					str_html += "<td>"+val['order_id']+"</td>";
        					str_html += "<td>"+val['productname']+"</td>";
        					str_html += "<td>"+val['people_num']+"</td>";
        					str_html += "<td>"+val['usedate']+"</td>";
        					str_html += "<td>"+val['order_price']+"</td>";
                                                            str_html += "<td>"+(val['agent_fee']*1).toFixed(2)+"</td>";
        					str_html +="</tr>";
        				});
        				str_html += "</table>"
        				str_html +="<button onclick='addOrderData()'>保存</button>";
        				str_html +="<button onclick='javascript:window.close();'>关闭</button>";
        				$("#choose_order").append(str_html);

  			});
        }
        $('#start_time').datepicker();
        $('#end_time').datepicker();
</script>