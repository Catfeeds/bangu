<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<style>
	.detail-add-but{
		margin-left: 120px;
		border: 1px solid rgb(204, 204, 204);
		width: 45px;
		text-align: center;
		border-radius: 3px;
		padding: 3px 0px;
		cursor: pointer;
	}
	
	.but-list{
		text-align: right;
		margin-bottom: 30px;
	}
	.but-list button{
		background: rgb(255, 255, 255) none repeat scroll 0% 0%;
		border: 1px solid rgb(204, 204, 204);
		padding: 3px;
		border-radius: 3px;
		cursor: pointer;
	}
	.print-but{
		text-align: center;
	}
	.print-but a {
		padding: 3px 5px;
		border: 1px solid #ccc;
		border-radius: 3px;
		cursor: pointer;
	}
</style>
</head>
<body id="detail-body">
    <div class="page-body" id="bodyMsg">
        <div class="order_detail" style="min-width: auto; min-width: inherit;">
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">基础信息</span>
                </div>
                 <table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">
                    <tr height="40">
                        <td class="order_info_title">旅行社:</td>
                        <td colspan="3" class="w_40_p"><?php echo $itemApply[0]['unionName']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行名称:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['bankname']?></td>
                        <td class="order_info_title">支行名称:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['branch']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">银行卡号:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['bankcard']?></td>
                        <td class="order_info_title">持卡人:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['cardholder']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">请款金额:</td>
                        <td class="w_40_p"><?php echo $money?></td>
                        <td class="order_info_title">发票类型:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['invoice_type']?></td>
                    </tr>
                    <tr height="40">
                        <td class="order_info_title">收据号:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['invoice_code']?></td>
                        <td class="order_info_title">收款单号:</td>
                        <td class="w_40_p"><?php echo $itemApply[0]['voucher']?></td>
                    </tr>
                </table>
            </div>
            
            
            <div class="content_part">
                <div class="small_title_txt clear">
                    <span class="txt_info fl">待转款记录</span>
                </div>

                <div id="order-list">
                	<table class="table table-bordered table_hover">
                		<thead class="">
                			<tr>
                				<th style="width:100px;text-align:center;">请款金额</th>
                				<th style="width:110px;text-align:center;">订单号</th>
                				<th style="width:100px;text-align:center;">本次交款金额</th>
                				<th style="width:110px;text-align:center;">交款部门</th>
                				<th style="width:110px;text-align:center;">交款人</th>
                				<th style="width:140px;text-align:center;">审核备注</th>
                			</tr>
                		</thead>
                		<tbody class="">
                			<?php 
                				foreach ($itemApply as $v):
                			?>
                			<tr>
                				<td style="text-align:center"><?php echo $v['allow_money']?></td>
                				<td style="text-align:center">
                					<a href="/admin/a/orders/order/order_detail_info?id=<?php echo $v['order_id']?>" target="_blank"><?php echo $v['ordersn']?></a>
                				</td>
                				<td style="text-align:center"><?php echo $v['money']?></td>
                				<td style="text-align:center"><?php echo $v['depart_name']?></td>
                				<td style="text-align:center"><?php echo $v['expert_name']?></td>
                				<td style="text-align:center"><?php echo $v['a_remark']?></td>
                			</tr>
                			
                			<?php endforeach;?>
                			
                		</tbody>
                	</table>
	                <div class="page-box">
	                	<span style="float: left;margin-top: 23px;">总计请款：<span style="color: rgb(255, 102, 0);font-size: 16px;font-weight: 700;"><?php echo $money?></span>元</span>
	                </div>
                </div>
            </div>
            
            <?php if ($itemApply[0]['a_status'] == 1):?>
            <div class="fb-content" id="union-box" >
			    <div class="fb-form">
			        <form method="post" action="#" id="add-form" class="form-horizontal">
			            <div class="form-group">
			                <div class="fg-title">转款凭证：</div>
			                <div class="fg-input">
			                	<input name="uploadFile" id="uploadFile" onchange="uploadImgFile(this);" type="file">
								<input name="pic" type="hidden" />
			                </div>
			            </div>
			            <div class="form-group">
			                <div class="fg-title">审核备注：</div>
			                <div class="fg-input"><textarea rows="5" name="remark" cols="50"></textarea></div>
			            </div>
			
						<input type="hidden" name="ids" value="<?php echo $ids;?>">
			            <div class="but-list">
							<button class="through-but">通过</button>
							<button class="refuse-but">退回</button>
						</div>
			            <div class="clear"></div>
			        </form>
			    </div>
			</div>
			<?php endif;?>
			
        </div>
	</div>
	<?php if ($itemApply[0]['a_status'] == 2):?>
	<div class="print-but"><a href="javascript:void(0);" onclick="printme()" target="_self">打印</a></div>
	<?php endif;?>
	
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script src="<?php echo base_url("assets/js/admin/common.js") ;?>"></script>
<script type="text/javascript" src="/assets/ht/js/common/common.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
function printme(){
	$('.print-but').hide();
	//document.body.innerHTML=document.getElementById('detail-body').innerHTML;
	//document.body.innerHTML=window.document.body.innerHTML;
	
	bdhtml=window.document.getElementById('detail-body').innerHTML;
	sprnstr=""; //声明一个字符串，用于表示打印的起始位置
	eprnstr=""; //标示打印的结束位置
	prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);

	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
	
	window.document.body.innerHTML
	//pagesetup_null();
	window.print();
	$('.print-but').show();
}   

function pagesetup_null(){                
    var     hkey_root,hkey_path,hkey_key;
    hkey_root="HKEY_CURRENT_USER"
    hkey_path="\\Software\\Microsoft\\Internet Explorer\\PageSetup\\";
    try{
                    var RegWsh = new ActiveXObject("WScript.Shell");
                    hkey_key="header";
                RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
                hkey_key="footer";
                RegWsh.RegWrite(hkey_root+hkey_path+hkey_key,"");
        }catch(e){}
}
//通过
$('.through-but').click(function(){
	$.ajax({
		url:'/admin/a/union_finance/item_apply/through',
		data:$('#add-form').serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			if (result.code == 2000) {
				layer.confirm(result.msg, {btn:['确认']},function(){
					t33_close_iframe();
				});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})

$('.refuse-but').click(function(){
	$.ajax({
		url:'/admin/a/union_finance/item_apply/refuse',
		data:$('#add-form').serialize(),
		dataType:'json',
		type:'post',
		success:function(result) {
			if (result.code == 2000) {
				layer.confirm(result.msg, {btn:['确认']},function(){
					t33_close_iframe();
				});
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	return false;
})
</script>
</body>
</html>
