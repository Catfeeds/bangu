<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>订单详情</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/order_detail.css');?>" rel="stylesheet" />
	<style type="text/css">
		body:before { background:#fff;}
		.page_content { margin-top:0;}
        .add_code { background:#F4F4F4;border:1px solid #ccc;width:110px;text-align:center;line-height:30px;margin:10px;display:inline-block;cursor:pointer;}
        #form1 .form-group { width:45%;float:left;margin-bottom:0 !important;}
        .input_info { width:100px !important;}
        .form_label { float:left;line-height:25px;width:90px;text-align:right;padding-right:5px;}
        .form_label i { color:#f00;}
        .form_input { float:left;}
        .form_btn span { display:inline-block;width:100px;text-align:center;line-height:30px;color:#333 !important;background:#fff;border:1px solid #aaa;cursor:pointer;}
        .form_btn span:first-child { margin-left:200px;margin-right:100px;}
        .form_btn span:hover { background:#eee;}
        .table { width:1000px;}
        .table-bordered { border-collapse:collapse;}
        .table>thead>tr>th { text-align: center;}
        .data_rows tr td { text-align:center !important;}
        .underline { text-decoration:underline;}
	</style>
</head>
<body>
    <div class="fb-content" id="form1">
        <div class="box-title">
            <h5>新增类目优惠券</h5>
            <span class="layui-layer-setwin">
                <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
            </span>
        </div>
        <div class="fb-form">
            <form method="post" action="#" id="role_from" class="form-horizontal">
               <div class="form-group">
                    <div class="form_label"><i>*</i>兑换码金额</div>
                    <div class="form_input"><input type="text" class="input_info" name="money" ></div>
               </div>
               <div class="form-group">
                    <div class="form_label"><i>*</i>使用条件，满</div>
                    <div class="form_input"><input type="text" class="input_info" name="role_name" ><span>可用，0表示不限制</span></div>
               </div>
               <div class="form-group">
                    <div class="form_label"><i>*</i>优惠券张数</div>
                    <div class="form_input"><input type="text" class="input_info" name="number" ></div>
               </div>
               <div class="form-group">
                    <div class="form_label"><i>*</i>有效期至</div>
                    <div class="form_input"><input type="text" class="input_info" id="starttime" data-date-format="yyyy-mm-dd" name="data" ></div>
               </div>
                <div class="form-group" style="width:80%;">
                    <div class="form_label">备注</div>
                    <div class="form_input"><input type="text" class="input_info" style="width:460px !important;"/></div>
                </div>

                <div class="form-group form_btn" style="width:80%;padding-bottom:50px;padding-top:20px;">
                    <span class="sub_data">确定</span>
                    <span class="layui-layer-close">取消</span>
                </div>
            </form>
        </div>
    </div> 
</body>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script src="/assets/js/jquery.extend.js"></script>
<script type="text/javascript">

</script>
</html>