<style type="text/css">
.form-control {
	background-color: #fff;
	background-image: none;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	color: #555;
	display: block;
	font-size: 14px;
	height: 34px;
	line-height: 1.42857;
	padding: 6px 12px;
	transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s
		ease-in-out 0s;
	width: 20%;
}

.col-sm-2 {
	width: 5.5%;
	height: 32px;
}
.col_ts{ float: left;}
body:before { background:#fff;}
.widget-body{ background:#fff;}
.form_group .form_input { height:auto;}
</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">开户银行</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div id="registration-form" style="margin-bottom:100px;">
		<form id="bank_info" class="form-horizontal" role="form" method="post" action="#">
        	<table class="line_base_info table_form_content table_td_border" border="1" width="800">
                <tbody>
                    <tr height="50" class="form_group">
                        <td class="form_title">登录账号：</td>
                        <td>&nbsp;&nbsp;<?php if(!empty($login_name)){ echo $login_name ; }?></td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">开户银行：</td>
                        <td>&nbsp;&nbsp;
                        <?php if(empty($bank_info)){ ?>
                        	<input type="text" placeholder="开户银行" id="bankname" class="form_input w_600" name="bankname" value="" />
                       <?php }else{?>
                        	<?php if(!empty($bank_info['bankname'])){echo $bank_info['bankname'];}  ?>
                        <?php } ?>
                        <!-- <input type="text" placeholder="开户银行" id="bankname" class="form_input w_600" name="bankname" value="" /> --></td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">开户银行支行：</td>
                        <td>&nbsp;&nbsp;
                        <?php if(empty($bank_info)){ ?>
                        	<input type="text" placeholder="开户银行支行" id="brand" class="form_input w_600" name="brand" value=""/>
                       <?php }else{?>
                        	<?php if(!empty($bank_info['bankname'])){echo $bank_info['bankname'];}  ?>
                        <?php } ?>
                        <!-- <input type="text" placeholder="开户银行支行" id="brand" class="form_input w_600" name="brand" value=""/> --></td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">开户人：</td>
                        <td>&nbsp;&nbsp;
                        <!-- <input type="text" placeholder="开户人" id="openman" class="form_input w_600" name="openman" value=""/> -->
                        <?php if(empty($bank_info)){ ?>
                        	<input type="text" placeholder="开户人" id="openman" class="form_input w_600" name="openman" value="" />
                        <?php }else{?>
                        	<?php if(!empty($bank_info['openman'])){echo $bank_info['openman'];} ?>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr height="50" class="form_group">
                        <td class="form_title">开户账号：</td>
                        <td>&nbsp;&nbsp;
                        <!-- <input type="text" placeholder="开户帐号" id="bank_num" class="form_input w_600" name="bank_num" value=""/> -->
                         <?php if(empty($bank_info)){ ?>
                        	<input type="text" placeholder="开户帐号" id="bank_num" class="form_input w_600" name="bank_num" value=""/> 
                        <?php }else{?>
                        	<?php  if(!empty($bank_info['bank'])){echo $bank_info['bank'];}?>
                        <?php } ?>
                        </td>
                    </tr> 
                </tbody>
            </table>
			<input type="hidden"  id="bank_info_id"  name="bank_info_id" value="<?php if(!empty($bank_info['id'])){echo $bank_info['id'];} ?>"/>
			
			  <?php if(empty($bank_info)){ ?>
                  <div class="form_btn clear">
              		  <button class="btn btn-palegreen" type="submit" style="margin-left:360px;">保存</button>
          		  </div>    	
              <?php }?>
          <!--   <div class="form_btn clear">
                <button class="btn btn-palegreen" type="submit" style="margin-left:360px;">保存</button>
            </div>--> 
		</form>
		</div>

	</div>
</div>
<script type="text/javascript">
$(function(){
	   $('#bank_info').submit(function() {
               $.post("/admin/b1/bank/add_bank",$('#bank_info').serialize(),function(result) {
               	result = eval('('+result+')');
               	if(result['code']==200){
               		alert(result['msg']);
               		window.location.reload();
               	}else{
               		alert(result['msg']);
               		return false;
               	}
		   });
               return false;
       	 }
    	);
/*	$("#y_pW").blur(function(){
		var pw1 = $(this).val();
		if(pw1.length<=0){
			$(".info").eq(0).html("原密码不能为空");
			return false;
		}else{
			$(".info").eq(0).html("");
		}
	});
	$("#x_pW").blur(function(){
		var pw2 = $(this).val();
		if(pw2.length<=0){
			$(".info").eq(1).html("新密码不能为空");
			return false;
		}else if(pw2.length<=5){
			$(".info").eq(1).html("密码长度过低(6-20位字符)");
			return false;
		}else{
			$(".info").eq(1).html("");
		}
	});
	$("#z_pW").blur(function(){
		var pw2 = $("#x_pW").val();
		var pw3 = $(this).val();
		if(pw3.length<=0){
			$(".info").eq(2).html("请再次输入新密码");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
		if(pw3!=pw2){
			$(".info").eq(2).html("两次输入的密码不一致");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
	});
	$(".btn-palegreen").click(function(){
		var pw1 = $("#y_pW").val();
		var pw2 = $("#x_pW").val();
		var pw3 = $("#z_pW").val();
		if(pw1.length<=0){
			$(".info").eq(0).html("原密码不能为空");
			return false;
		}else{
			$(".info").eq(0).html("");
		}
		if(pw2.length<=0){
			$(".info").eq(1).html("新密码不能为空");
			return false;
		}else if(pw2.length<=5){
			$(".info").eq(1).html("密码长度过低(6-20位字符)");
			return false;
		}else{
			$(".info").eq(1).html("");
		}
		if(pw3.length<=0){
			$(".info").eq(2).html("请再次输入新密码");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
		if(pw3!=pw2){
			$(".info").eq(2).html("两次输入的密码不一致");
			return false;
		}else{
			$(".info").eq(2).html("");
		}
	});*/
});

</script>