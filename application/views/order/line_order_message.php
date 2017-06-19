<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url() ?>static/css/travel.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>static/css/common.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>static/css/plugins/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/js/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>static/plugins/DatePicker/WdatePicker.js"></script>
<title>订单详情</title>

</head>
<style>
.travel_Pro_300{width: 300px;text-align: center;line-height: 40px;}
.travel_Pro_240{width: 240px;text-align: center;line-height: 40px;}
.travel_Pro_220{width: 220px;text-align: center;line-height: 40px;}
</style>
<body>

<!--头部开始-->
<div class="travel_head">
  <div class="travel_head_le fl"><a href="">您好，<?php if(!empty($member)){ echo $member['nickname'];} ?></a></div>
  <div class="travel_head_ri fr">
    <ul>
      <li><a href="/index/site_map">网站地图</a></li>
      <li><a href="<?php echo base_url() ?>order_from/order/line_order">我的订单</a></li>
      <li><a href="<?php echo base_url() ?>order_from/order/line_order" style="color:#ff6600;">会员中心</a></li>
    </ul>
  </div>
</div>
<!--头部结束-->

<!--导航开始-->
<div class="travel_nav fl">
  <div class="travel_top">
    <div class="travel_logo"><a href="/"><img src="<?php echo base_url() ?>static/img/logo.png"/></a></div>
    <div class="travel_column">
      <ul>
        <li><a href="<?php echo sys_constant::INDEX_URL?>">首页</a></li>
        <li><a href="<?php echo base_url() ?>base/member/profile">账户设置</a></li>
        <li><a href="<?php echo base_url() ?>order_from/order/line_order">会员中心</a></li>
        <li><a href="<?php echo base_url() ?>order_from/order/line_order">我的订单</a></li>
      </ul>
    </div>
  </div>
</div>
<!--导航结束-->

	<div class="content w_1200 clear">
		<!--当前位置开始-->
		<div class="travel_main clear">
			<div class="travel_Position fl">
				您当前的位置是&nbsp;:&nbsp;<a href="/index/home">首页</a><span class="right_jiantou">&gt;</span><a href="<?php echo base_url() ?>order_from/order/line_order"">会员中心</a><span class="right_jiantou">&gt;</span><a
					href="<?php echo base_url() ?>order_from/order/line_order"">我的订单</a>
			</div>
		</div>
		<!--当前位置结束-->

		<!--内容-->
		<!--订单请求开始-->
		<div class="travel_main">
			<div class="travel_examine fl">
				<div class="travel_notice">
					<!--请求确认-->
					<!--请求确认-->
					<!--请求确认-->
					<h2>当前订单状态:<?php echo $order_info ['status'];	?></h2>
					<p></p>
				</div>

				<div class="travel_track clear">
					<!--进度跟踪-->
					<!--进度跟踪-->
					<!--进度跟踪-->
					<h2>进度跟踪</h2>

					<div class="travel_track_because clear">
						<span>处理时间</span> <span>处理信息</span>
					</div>
			        <?php foreach ($progress_info as $key => $value) {?>
			        <div class="travel_track_so clear">
						<span><?php echo $value['addtime'];?></span> <div><?php  echo $value['content'];?></div>
					</div>
			        <?php } ?>
			    </div>
			</div>
		</div>
		<!--内容-->
		<!--订单请求开始-->

		<!--内容-->
		<!--客服及订单信息-->
		<div class="travel_main">
			<div class="travel_customer clear">
				<h3 id="Stop">联系管家<span>手机号码:<span class="expert_id"></span></span><a>点击展开/收起</a></h3>
				
				<div id="im_st">
					<div class="travel_service clear">
						<div class="travel_head_photo">
						<!--头像图片-->
							<a href="" target="_blank"><img id="expert_photo" /></a>

						</div>
						<div class="travel_word">
							<img src="<?php echo base_url() ?>/static/img/user/Word_18.png" />
                            <div class="kefu_mingzi">您好！我是您的管家“托儿索”，有疑问请点击右侧'我要提问'~~</div>
							<div style=" font-size:14px;padding-left:20px; height:30px;line-height:30px;"></div>

						</div>
						<div class="travel_questions">
                            <a href="" target="_blank">
                               		 我要咨询
                            </a>

						</div>
					</div>
					<!-- 客服js -->
					<script>
						var get_b2_data_url="/kefu_webservices/get_b2_data";
						var eid="<?php echo $order_info ['expert_id'] ?>";
						var member_id="<?php $memberid=$this->session->userdata('c_userid');echo $memberid; ?>";
						$.ajax({
							url:get_b2_data_url,
							type:'GET',
							data:{eid:eid},
							dataType:'json',
							success:function(data){
								$('.kefu_mingzi').text("您好！我是您的管家'"+data[0]['nickname']+"',有问题请点我呦~~");
								$('.expert_id').text(data[0]['mobile']);
								$('.travel_questions a').attr("href",'<?php echo $web['expert_question_url'];?>'+"/kefu_member.html?mid="+member_id+"&eid="+eid);
								$('.travel_word a').attr("href",'<?php echo $web['expert_question_url'];?>'+"/kefu_member.html?mid="+member_id+"&eid="+eid);
								$('#expert_photo').attr("src",data[0]['photo']);
								$('.travel_head_photo a').attr("href",'/guanjia/'+eid+'.html');   // 将guanj改为guanjia,添加后缀.html 魏勇编辑
							}
						});
					</script>
					<div class="travel_information clear">
					   <!-- <a href="/file/c/contract.doc" style="font-size:12px;color:#2E29EF;">下载合同</a> -->
						
						<h4>订单信息
						<span style="margin-left:50px;">
                         <a href="javascript:void(0);" id="downloadContract" style="font-size:12px;color:#2E29EF; width:80px; display: inline-block;">
                         	<i style=" width:15px; height:15px; float:left; background:url(../../../static/img/xiazai_slee.png)"></i>下载合同
                         </a>
                        </span>
                        </h4>
						<div class="travel_infor_details">
							<ul>
								<li>订单编号:<span><?php echo $order_info ['ordersn'] ?></span></li>
								<li>预定时间:<span><?php echo $order_info ['addtime'] ?></span></li>
								<li>订单状态:<span><?php echo $order_info ['status'] ?> </span></li>
								<li>出发时间:<span><?php echo $order_info ['usedate'] ?></span></li>
								<li>归来时间:<span><?php echo $order_info ['endtime'] ?></span></li>
								<li>出发城市:<span><?php if(!empty($citystr)){ echo $citystr;}  ?></span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--内容-->
		<!--客服及订单信息-->

		<!--内容-->
		<!--产品开始-->
		<div class="travel_main">
			<div class="travel_Product clear">
				<!--此处为产品-->
				<ul>
					<li class="travel_Pro_220">产品名称</li>
					<li class="travel_Pro_240">单价</li>
					<li class="travel_Pro_240">人数</li>
					<li class="travel_Pro_100">积分抵扣现金</li>
					<li class="travel_Pro_100">优惠券抵扣现金</li>
					<li class="travel_Pro_100">保险费用</li>
					<li class="travel_Pro_100">优惠</li>
					<li class="travel_Pro_100">总价</li>
				</ul>
				<!---------------此处可以循环-------------------->
				<div class="travel_Product_xx clear">
					<ul>
						<li class="travel_Pro_220"><?php echo $product['productname'];?></li>
						<li class="travel_Pro_240">
						<?php if($product['unit']==1){ ?>
						<?php  echo (!empty($product['dingnum']) ? $product['price'].'/成人价':'').'&nbsp;'.(!empty($product['childnum'])  ?$product['childprice'].'/儿童占床价':'').'<br>&nbsp;'.(!empty($product['childnobednum']) ? $product['childnobedprice'].'/儿童不占床价':'').'&nbsp;'.(!empty($product['oldnum'])? $product['oldprice'].'/老人价':'');?>
						<?php }else{
							   echo $product['price'].'元/份';
						 }?>
						</li>
						<li class="travel_Pro_240">
						<?php if($product['unit']==1){ ?>
						<?php if(!empty($product['dingnum']) || !empty($product['dingnum'])){echo (!empty($product['dingnum'])?$product['dingnum'].'成人':'').'&nbsp;'.(!empty($product['childnum'])?$product['childnum'].'儿童占床':'').'<br>&nbsp;'.(!empty($product['childnobednum'])?$product['childnobednum'].'儿童不占床':'').'&nbsp;'.(!empty($product['oldnum'])?$product['oldnum'].'老人价':'');} ?>
						<?php }else{
							echo $product['suitnum'].'份/'.$product['suitname'].'(共'.$product['dingnum'].'人)';
						 }?>
						</li>
						<li class="travel_Pro_100">￥<?php if(!empty($product['jifenprice'])){echo $product['jifenprice'];}else{ echo '0';} ?></li>
						<li class="travel_Pro_100">￥<?php if(!empty($product['couponprice'])){echo $product['couponprice'];}else{ echo '0';} ?></li>
						<li class="travel_Pro_100"><?php if(!empty($product['settlement_price'])){echo $product['settlement_price'];}else{ echo '暂无保险费用';} ?></li>
						<li class="travel_Pro_100">￥<?php if(!empty($product['saveprice'])){echo $product['saveprice'];}else{ echo '0';} ?></li>
						<li class="travel_Pro_100 red">￥<?php echo ($product['total_price']+$product['settlement_price']);?></li>
					</ul>
				</div>
				<!---------------此处可以循环-------------------->
				<div class="travel_Contact clear">
					<!--联系人修改-->
					<ul>
						<h4>
							联系人信息
						</h4>
						<?php  foreach ($concact_info as $key => $value) {?>
						<li>联系人姓名:<span><?php echo $value['linkman']; ?></span></li>
						<li>手机:<span><?php echo $value['linkmobile']; ?></span></li>
						<li>E-mail:<span><?php echo $value['E-mail']; ?></span></li>
						<?php } ?>
					</ul>
                    <div id="form1" style="display:none;">
          				<form class="form-horizontal" onkeydown="if(event.keyCode==13)return false;" role="form" method="post" id="concactForm"  onsubmit="return CheckConcact(this);" action="<?php echo base_url();?>order_from/order/save_concact">
          				<?php  foreach ($concact_info as $key => $value) {?>
          					<input  type="hidden" id="next1" name="id" value=" <?php echo $value['id']; ?>">
               				<p><span>联系人姓名：</span><input type="text" name="linkman" value="<?php echo $value['linkman']; ?>"/></p>
                    		<p><span>手机：</span><input type="text" name="linkmobile" value="<?php echo $value['linkmobile']; ?>"/></p>
                    		<p><span>E-mail：</span><input type="text" name="mail" value="<?php echo $value['E-mail']; ?>"/></p>
                    		<p><span></span><button name="submit" id="update" type="submit">修改</button></p>
                    	<?php } ?>
                		</form>
          			</div>
				</div>
				<div class="travel_travel_r clear">
					<ul>
						<h4>
							出游人信息
						</h4>
					</ul>
				</div>
			</div>
		</div>
		<div class="travel_main">
			<div class="travel_travel clear">
				<!--此处为产品-->
 				 <?php $overArr=explode(',', $product['overcity']) ; if(in_array(1,$overArr)){ ?>
				<!-----------------------------------------此处为境外的栏目  开始 -------------------------------------->
                <div class="overseas_column">
				<ul>
					<li class="travel_trave_100">中文姓名</li>
					<li class="travel_trave_100">英文名</li>
					<li class="travel_trave_100">性别</li>
					<li class="travel_trave_100">证件类型</li>
					<li class="travel_trave_180">证件号</li>
					<li class="travel_trave_100">出生日期</li>
					<li class="travel_trave_180">签发地</li>
					<li class="travel_trave_100">签发日期</li>
                    <li class="travel_trave_100">有效期至</li>
                    <li class="travel_trave_100">手机号</li>
				</ul>
				<!---------------此处可以循环-------------------->
				<div class="travel_travel_xx clear">
				<?php foreach ($travel_info as $key => $value) { ?>
					<ul>
						<li class="travel_trave_100"><?php if(!empty($value['name'])){ echo  $value['name'];}else{ echo '&nbsp;';} ?></li>
						<li class="travel_trave_100"><?php if(!empty($value['enname'])){ echo  $value['enname'];}else{ echo '&nbsp;';} ?></li>
						<li class="travel_trave_100"><?php if($value['sex']==0){echo "女";}elseif($value['sex']=='1'){ echo "男";} ?></li>
                        <li class="travel_trave_100"><?php if(!empty($value['certificate_type'])){ echo $value['certificate_type']; }else{ echo '&nbsp;';}?></li>
						<li class="travel_trave_180"><?php if(!empty($value['certificate_no'])){ echo $value['certificate_no'];} ?></li>
						<li class="travel_trave_100"> <?php if(!empty($value['birthday'])){ echo $value['birthday'];} ?></li>
						<li class="travel_trave_180"><?php if(!empty($value['sign_place'])){ echo $value['sign_place'];} ?></li>
						<li class="travel_trave_100"><?php if(!empty($value['sign_time'])){echo   date('Y-m-d', strtotime($value['sign_time']));}else{ echo '&nbsp;';} ?></li>
					    <li class="travel_trave_100"><?php if(!empty($value['endtime'])){ echo date('Y-m-d',strtotime($value['endtime']));} ?></li>
                        <li class="travel_trave_100"><?php if(!empty($value['telephone'])){ echo $value['telephone'];} ?></li>
                    </ul>
					<?php } ?>
                </div>
				</div>
                <!-----------------------------------------此处为境外的栏目 结束-------------------------------------->
                	<?php }else{?>
                
                <!-----------------------------------------此处为境内的栏目  开始 -------------------------------------->
                <div class="overseas_column">
				<ul>
					
					<li class="travel_trave_200">姓名</li>
					<li class="travel_trave_200">性别</li>
					<li class="travel_trave_200">证件类型</li>
					<li class="travel_trave_200">证件号</li>
					<li class="travel_trave_200">出生日期</li>
                    <li class="travel_trave_200">手机号</li>
				</ul>
				<!---------------此处可以循环-------------------->
				<div class="travel_travel_xx clear">
				<?php foreach ($travel_info as $key => $value) { ?>
					<ul>
						<li class="travel_trave_200"><?php if(!empty($value['name'])){ echo  $value['name'];}else{ echo '&nbsp;';} ?></li>
						<li class="travel_trave_200"><?php if($value['sex']==0){echo "女";}elseif($value['sex']=='1'){ echo "男";} ?></li>
                        <li class="travel_trave_200"><?php if(!empty($value['certificate_type'])){ echo $value['certificate_type']; }else{ echo '&nbsp;';}?></li>
						<li class="travel_trave_200"><?php if(!empty($value['certificate_no'])){ echo $value['certificate_no'];} ?></li>
						<li class="travel_trave_200"> <?php if(!empty($value['birthday'])){ echo $value['birthday'];} ?></li>
                        <li class="travel_trave_200"><?php if(!empty($value['telephone'])){ echo $value['telephone'];} ?></li>
                    </ul>
					<?php } ?>
                </div>
				</div>
                <!-----------------------------------------此处为境外的栏目 结束-------------------------------------->
                <?php }?> 
                

				<div class="travel_careful">
					注: 1.身份证,军官证和其他类型的证件,需要填写,姓名性别及证件号码.<br /> <span>&nbsp;&nbsp;2.因私护照,台胞证和港澳通行证,需要填写姓名出生日期和证件有效期.</span>
				</div>
				<?php if(!empty($invoice_info)){ ?>
				<div class="travel_travel_r clear">
					<ul>
						<h4>
							发票信息
						</h4>
					</ul>
				</div>
				<?php }?>
			</div>
		</div>
	     <?php if(!empty($invoice_info)){ ?>
		<div class="travel_main">
			<div class="travel_invoice clear">
				<!--此处为产品-->
				<ul>
					<li class="travel_invo_200">发票抬头</li>
					<li class="travel_invo_300">配送地址</li>
					<li class="travel_invo_200">收件人</li>
					<li class="travel_invo_300">手机</li>
					<li class="travel_invo_100">金额</li>


				</ul>
				<!---------------此处可以循环-------------------->
				<div class="travel_invoice_xx clear">
					<?php  foreach ($invoice_info as $key => $value) {	?>
					<ul>
						<li class="travel_invo_200"><?php if(!empty($value['invoice_name'])){ echo $value['invoice_name']; }?></li>
						<li class="travel_invo_300" title="<?php if(!empty($value['address'])){ echo $value['address']; }?>" style="cursor:pointer;"><?php if(!empty($value['address'])){ echo $value['address']; }?></li>
						<li class="travel_invo_200"><?php if(!empty($value['receiver'])){ echo $value['receiver'];} ?></li>
						<li class="travel_invo_300"><?php if(!empty($value['telephone'])){echo $value['telephone'];}else{ echo '&nbsp;';}  ?></li>
					    <li class="travel_invo_100"><?php  if(!empty($value['total_price'])){echo $value['total_price'];} ?></li>

					</ul>
					<?php }?>
				</div>
				<!---------------此处可以循环-------------------->
				<div class="travel_invo_careful">
					<p>1.旅游和保险用的发票要分开,添加旅游用的发票自动生成保险费用发票.</p>
					<p>2.出游前填写的发票将于书友归来后5日内开具,请注意查收.</p>
					<p>3.发票开具有效期为旅游回来两个月内,如有疑问请来电咨询.</p>
					<p>4.发票开具后,若办理退款,需先退还原来的发票, 并保持发片顿兑奖联完好(如有兑奖联).</p>
				</div>
			</div>
		</div>
		<?php }?>
	</div>

<!--<div style="width:100%;height:100px;background:#000;"></div> -->
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
</body>
</html>

<!-- 弹出层 -->
<script type="text/javascript">

$('#downloadContract').click(function(){
	var url = '/order_from/order/show_order_contract/'+<?php echo $order_info['id']; ?>;
	var pay = <?php echo $order_info['ispay_code']?>;
	if (pay != 2){
		alert('请支付后下载合同');
	}else{
		location.href=url;
	}
})

$(document).ready(function() {
    $(".various1").fancybox();
	$(".various2").fancybox({
		 maxHeight    : 360,
	});
	$(".various3").fancybox();
	$(".various4").fancybox({
		 maxHeight    : 360,
	});
	$(".various4").click(function() {
		$('input[name="name"]').val('');
		$('input[name="certificate_no"]').val('');
		$('input[name="endtime"]').val('');
		$('input[name="country"]').val('');
		$('input[name="telephone"]').val('');
		$('input[name="birthday"]').val('');
	});
});

$(document).ready(function(){
  $("#Stop").click(function(){
    $("#im_st").slideToggle(800);
  });

});
//保存游客信息
function CheckConcact(obj){
    var linkman= obj.linkman.value;
    var linkmobile= obj.linkmobile.value;
    var  mail= obj.mail.value;

    //去掉空格
    var linkmobile=linkmobile.replace(/(^\s*)|(\s*$)/g, "");
    var mail=mail.replace(/(^\s*)|(\s*$)/g, "");
	   var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;


	   if(linkmobile==''){
	   		alert('手机号码不能为空！');
	       return false;
	   }else if(!myreg.test(linkmobile)){
	   		alert('请输入有效的手机号码！');
	       return false;
	   }

	   var Regex = /^(?:\w+\.?)*\w+@(?:\w+\.)*\w+$/;
		if(mail==''){
	   		alert('邮件不能为空！');
	       return false;
	    } else if(!Regex.test(mail)){
	   	   alert('请输入正确的邮件格式！');
	       return false;
	    }

      if(linkman==''){
      		alert('联系人姓名不能为空');
		       return false;
      }

		jQuery.ajax({ type : "POST",data : jQuery('#concactForm').serialize(),url : "<?php echo base_url()?>order_from/order/save_concact",
			success : function(response) {
			 	 if(response){
				 	 alert('修改成功');
					 location.reload();
				}else{
					 alert('修改失败');
					 location.reload();
				}
			}
		});

		return false;
}


//保存游客信息
function CheckInformation(obj){
	<?php  if(!empty($travel_info)){ foreach ($travel_info as $k=>$v){?>
    var name = $("#name_info<?php echo $k; ?>").val();
    var certificate_type = $("#certificate_type<?php echo $k; ?>").val();
    var certificate_no = $("#certificate_no<?php echo $k; ?>").val();
    var telephone = $("#telephone<?php echo $k; ?>").val();

    //去掉空格
     var telephone=telephone.replace(/(^\s*)|(\s*$)/g, "");
	 var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

	   if(name==''){
      		alert('联系人姓名不能为空');
		       return false;
      }
/* 	   if(telephone==''){
	   		alert('手机号码不能为空！');
	       return false;
	   }else if(!myreg.test(telephone)){
	   		alert('请输入有效的手机号码！');
	       return false;
	   } */
	 if(telephone!=''){
		   if(!myreg.test(telephone)){
		   		alert('请输入有效的手机号码！');
		       return false;
		   }
	  }
	//身份证验证
   if(certificate_type==37){
 	   var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
	   if(!reg.test(certificate_no))
	   {
		   alert("身份证输入不合法");
	       return false;
	   }
   }

	<?php } }?>

	jQuery.ajax({ type : "POST",data : jQuery('#lineinformationForm').serialize(),url : "<?php echo base_url()?>order_from/order/ajax_data",
		success : function(response) {
		 	 if(response){
				alert( '保存成功！' );
                location.reload();
			}else{
				alert( '保存失败' );
				location.reload();
			}
		}
	});

	return false;
}


//保存添加的出游人信息
function AddInformation(obj){

	    var name= obj.name.value;
	    var telephone= obj.telephone.value;
	    var certificate_type= obj.certificate_type.value;
	    var certificate_no= obj.certificate_no.value;
	    //去掉空格
	    var telephone=telephone.replace(/(^\s*)|(\s*$)/g, "");
		   var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;

		   if(name==''){
	      		alert('联系人姓名不能为空');
			       return false;
	      }
		   if(telephone==''){
		   		alert('手机号码不能为空！');
		       return false;
		   }else if(!myreg.test(telephone)){
		   		alert('请输入有效的手机号码！');
		       return false;
		   }
		//身份证验证

	   if(certificate_type==37){
	 	   var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
		   if(!reg.test(certificate_no))
		   {
			   alert("身份证输入不合法");
		       return false;
		   }
	   }
	jQuery.ajax({ type : "POST",data : jQuery('#InformationFrom').serialize(),url : "<?php echo base_url()?>order_from/order/save_info",
		success : function(response) {
		 	 if(response){
				 alert( '保存成功！' );
                 location.reload();
			}else{
				alert( '保存失败' );
				  location.reload();
			}
		}
	});

	return false;

}
//保存发票
function CheckInvoice(obj){
	 var invoice_name=obj.invoice_name.value;
	 var address=obj.address.value;
	 var telephone= obj.telephone.value;
	 var receiver=obj.receiver.value;
	 if(invoice_name==''){
		 alert('抬头发票不能为空！');
	       return false;
	 }
	 if(address==''){
		 alert('配送地址不能为空！');
	       return false;
	 }
	 if(receiver==''){
		 alert('收件人为空！');
	       return false;
	  }
     telephone=telephone.replace(/(^\s*)|(\s*$)/g, "");
     var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
	 if(telephone==''){
	   		alert('手机号码不能为空！');
	       return false;
	  }else if(!myreg.test(telephone)){
	   		alert('请输入有效的手机号码！');
	       return false;
	  }

	//telephone
	jQuery.ajax({ type : "POST",data : jQuery('#invoiceForm').serialize(),url : "<?php echo base_url()?>order_from/order/ajax_invoice",
		success : function(response) {
		 	 if(response){
				alert( '保存成功！' );
                 location.reload();
			}else{
				alert( '保存失败' );
				  location.reload();
				  location.reload();
			}
		}
	});

	return false;
}
</script>
