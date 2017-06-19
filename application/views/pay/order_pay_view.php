<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<title>支付</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/order.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>"></script>
</head>
<body class="clear" style="background: #eff0f1;">
<!--  头部 -->
<div class="pay_header">
	<div class="w_1200 clear">
    	<div class="pay_logo_img fl"><a href="<?php echo sys_constant::INDEX_URL?>"><img src="<?php echo base_url('static'); ?>/img/logo.png" style="margin-top:-3px;"/></a></div>
        <div class="pay_header_nav fr">
        	<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>
            <a href="/order_from/order/line_order">我的订单</a>
            <a href="#" style="border-right:none;">支付帮助</a>
        </div>
    </div>
</div>
<!--  主体内容 开始-->
<div class="main" style="min-height:840px; margin:0">
	<div class="main_center">
    	<div class="order_info clear">
        	<div class="order_info_txt fl">
            	<p class="order_num">订单提交成功，请您尽快付款！ 订单号：<?php echo $ordersn; ?><a href="<?php echo site_url('/order_from/order/show_order_message_' . $id.'.html'); ?>" target="_blank">订单详情</a></p>
                <p>请您在提交订单后<span class="time_prompt">24小时</span>内完成支付，否则订单会自动取消。</p>
            </div>
            <input type="hidden" name="orderid" value="<?php echo $id; ?>" />
        </div>
        <div class="pay_style">
        	<form action="" method="post" id="pay_form">
            	<div class="order_info_money fl">
            	<span>应付金额：<i><?php echo $money?></i>元</span><br/>
            	</div>
            	<div class="invoice_box clear">
                	<div class="invoice_dont_box"><label class="invoice_dont"><input type="radio" name="invoice" value="0" checked="checked"/><span>不要发票</span></label></div>
                	<div class="invoice_need_box"><label class="invoice_need"><input type="radio" name="invoice" value="1" /><span>需要发票</span></label></div>
					<div class="invoice_hidden">
                    	<ul>
                        	<li><span class="">发票抬头:</span><input type="text" name="title" /></li>
                            <li><span >发票明细:</span><input type="text" name="detail" class="clears" /></li>
                            <li><span>收件人:</span><input type="text" name="receiver" value="<?php echo $linkman; ?>" /></li>
                            <li><span>手机号:</span><input type="text" name="mobile" value="<?php echo $mobile; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" /></li>
                       		<li><span>寄送地址:</span><div id="choiseCity"></div></li>
                            <li><span>详细地址:</span><input type="text" name="address" /></li>
                        </ul>
                    </div>
                </div>
                <!--支付宝 -->
                <div class="pay_tab">
                	<ul>
                    	<li class="tab_click">支付宝第三方支付</li>
                    </ul>
                </div>
                <div class="pay_tab_conm">
                    <div class="card_con_bix">
                        <ul class="card_id_list">
                            <li><label><input type="radio" value="1" name="paystyle" /><img class="border" src="../../../static/img/pay/zhifubao.png" /></label></li>
                        	<a href="javascript:void(0);" onclick="pay(1);" class="pay_button fr">立即支付</a>
                        </ul>
                    </div>
                </div>
                <!--银行卡 -->
                <div class="pay_tab">
                	<ul>
                    	<li class="tab_click">银行卡快捷支付</li>
                    </ul>
                </div>
                <div class="pay_tab_conm">
                    <div class="card_con_bix">
                    	<!--格式 -->
                    	<div class="card_title">请选择银行卡支付</div>
                    	<ul class="card_id_list">
                    		<?php
                    			foreach($bankData as $val) {
                    				echo '<li><label><input type="radio" name="paystyle" value="'.$val['code'].'"/><img src="'.$val['pic'].'" /></label></li>';
                    			}
                    		?>
                        </ul>
                        <a href="javascript:void(0);" onclick="pay(1);" class="pay_button center">立即支付</a>
                    </div>
                </div>
                <div class="outline_pay">
                    <div class="pay_out_line clear">
                    	<label class="pay_style2">
                        	<input type="radio" name="paystyle"  class="fl" value="2"/>
                        	<span class="pay_outline fl">线下支付</span>
                        </label>
                         <div><span class="fl">填写付款人流水信息进行线下支付</span></div>
                        <span class="fl">填写付款人流水信息进行线下支付</span>
                    </div>

                    <div class="pay_outline_info">
                        <div class="untiy_osi">公司名称：深圳市海外国际旅行社有限公司</div>
                        <div class="untiy_osi">账号：44250100005800000182</div>
                        <div class="untiy_osi">银行：中国建设银行股份有限公司深圳住房城市建设支行
                        </div>
                    	<div><span>付款人开户名</span><input type="text" name="account_name" value=""/></div>
                        <div><span>付款人开户行</span><input type="text" name="bank_name" value=""/></div>
                        <div><span>付款人银行卡号</span>
                            <input type="text" id="card_before_four" name="card_before_four" placeholder="卡号前4位" style=" width: 100px;" maxlength='4' onblur="move_next(this)"/>
                            <div style=" float: left; padding: 0 10px"> —</div>
                            <input type="text" id="card_after_four" name="card_after_four" placeholder="卡号后4位" style=" width: 100px; margin-left: 0;" maxlength='4' onblur="validate_num(this)"/>
<!--                             <input type="hidden" name="card_num" id="card_num" value=""/> -->
                        </div>
                        <div><span>流水号</span><input type="text" name="receipt" value=""/></div>
                        <div class="clear" style="margin-top:-6px; position: relative; z-index: 10;">
                        	<span>流水单扫描件</span>
                        	<input type="file" name="receipt_img" id="receipt_img" class="file fl" value=""/>
                        	<input type="button" value="上传" id="upfile_receipt_file" class="fl"/>
                        	<div class="file_cover">选择文件</div>
                        	<input type="hidden" name="receipt_img_url" id="receipt_img_url"  value=""/>
                        </div>
                        <div style="margin-top:-10px;"><span>付款金额</span><i class="pay_money">¥<?php echo $money?></i></div>
                        <input type="hidden" name="pay_order_id" value="<?php echo $id?>"/>
                        <input type="hidden" name="pay_money" value="<?php echo $money?>"/>
                        <input type="hidden" name="ispay" value="<?php echo $ispay?>"/>
                        <input type="hidden" name="diff_price" value="<?php echo $diff_price?>"/>
                        <input type="submit" name="submit" value="确认付款" class="submit_button"/>
                        <div id="img_show" class="img_show"></div><!--用于上传之后显示图片-->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--  主体内容   结束-->
<div id="alipay_string" style="display:none;"></div>
<!-- 尾部 -->
<?php $this -> load -> view('common/footer'); ?>
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script type="text/javascript">

//上传的流水图片放大缩小
$(".img_show_src").on('click' ,function(){
    alert(1);
            var thisImg = $(this).find('img')[0].src;
            $(this).append('<img class="enlarge" src='+thisImg+'>')
            },function(){
                       $(".enlarge").remove();
            })
            $(".img_show_div span").click(function(){
            $(this).parent().remove();
 });



chinaPCR("choiseCity" ,71);
var s = true;
function pay(type) {
	if (s == false) {
		return false;
	} else {
		s = false;
	}
	$.post("/pay/order_pay/get_into_pay",$("#pay_form").serialize(),function(json){
		s = true;
		var data = eval('('+json+')');
		if (data.code == 2000) {
			$('#alipay_string').html(data.msg);
		} else if (data.code == 3000){
			location.href=data.msg;
		} else {
			alert(data.msg);
		}
	})
}
$('#pay_form').submit(function(){
    var paystyle = $('input[name="paystyle"]:checked').val();
    if(paystyle==1){
        alert('你选的是线上支付');
        return false;
    }else{
            $.post(
                "<?php echo site_url('order_from/order/pay');?>",
                $('#pay_form').serialize(),
                function(data) {
                    data = eval('('+data+')');
                    if (data.code == 2000) {
                        alert(data.msg);
                        window.history.back(-1);
                        return false;
                    } else {
                        alert(data.msg);
                         //window.history.back(-1);
                        return false;
                    }

                }
            );
            return false;
    }

});

$('#upfile_receipt_file').on('click', function(){
                if($("#img_show").children(".img_show_div").length==3){
                    alert('最多只能上传三张图片');
                    return false;
                }

                $.ajaxFileUpload({
                    url:"<?php echo site_url('order_from/order/upload_receipt');?>",
                    secureuri:false,
                    fileElementId:'receipt_img',//file标签的id
                    dataType: 'json',//返回数据的类型
                    data:{filename:'receipt_img'},
                    success: function (data, status) {
                        if (data.status == 1) {
                             var html = '  ';
                             html +='<div class="img_show_div"> ';
                             html +='    <div  class="img_show_src"><img id="" src="'+data.url+'" /></div> ';
                             html +='    <span onclick="delPic(this)">×</span>';
                             html +=' </div>';
                             $("#img_show").append(html);
                             //当鼠标放上去的时候,图片变大
                             $("#receipt_img_url").val($("#receipt_img_url").val()+';'+data.url);
                                   $(".img_show_src").hover(function(){
                                             var thisImg = $(this).find('img')[0].src;
                                                $(this).append('<img class="enlarge" src='+thisImg+'>');
                                         },function(){
                                                $(".enlarge").remove();
                                    });

                        } else {
                            alert(data.msg);
                        }
                    },
                    error: function (data, status, e) {
                            alert(data.msg);
                    }
                });
            });

function delPic(obj){
    var pic_values = $("#receipt_img_url").val();
    if (pic_values.substr(0,1)==';'){
            pic_values=pic_values.substr(1);
    }
    pic_values_arr =  pic_values.split(';');
    var pic_url = $(obj).prev().find('img').attr('src');
     pic_values_arr.splice($.inArray(pic_url, pic_values_arr),1);
    pic_values = ';'+pic_values_arr.join(";");
    $("#receipt_img_url").val(pic_values);
    $(obj).parent().remove();
}

$(function(){
	//=======================支付切换
	$(".pay_style2").click(function(){
		$(".pay_outline_info").slideDown(400);
	});
	$(".pay_style1").click(function(){
		$(".pay_outline_info").slideUp(400);
	});
	//=======================发票切换
	 $(".invoice_dont").click(function() {
        $(".invoice_hidden").slideUp(400);
    })
	$(".invoice_need").click(function() {
        $(".invoice_hidden").slideDown(400);
		$(".pay_outline_info").slideUp(400);
    })
});


function move_next(obj){
    var g = /^[0-9]*[0-9][0-9]*$/;
    var input_num = $(obj).val();
    if(!g.test(input_num) || input_num.length!=4){
        alert("请填写卡号前四位数字");
        $(obj).focus();
        return false;
    }else{
            $("#card_after_four").focus();
    }
}

function validate_num(obj){
     var g = /^[0-9]*[0-9][0-9]*$/;
    var input_num = $(obj).val();
      if(!g.test(input_num) || input_num.length!=4){
        alert("请填写卡号后四位数字");
        $(obj).focus();
        return false;
    }/*else{
            $("#card_num").val($("#card_before_four").val()+'-'+input_num);
    }*/
}
</script>
</body>
</html>