<div class="form-box fb-body add-box">
	<div class="fb-content">
		<div class="box-title">
			<h4>添加供应商</h4>
			<span class="fb-close">x</span>
		</div>
		<div class="fb-form" style="overflow-y: auto;height: 500px;">
			<form method="post" id="add-supplier" action="#" class="form-horizontal" >
				<div class="form-group">
					<div class="fg-title">创建时间：</div>
					<div class="fg-input" style="margin-top: 8px;">
						<?php echo date('Y-m-d H:i:s')?>
						<span style="display: inline-block;margin-left: 20px;">创建人：<?php echo $this ->realname;?></span>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">供应商类型：<i>*</i></div>
					<div class="fg-input">
						<ul>
							<li><label class="choice-type"><input type="radio" checked="checked" class="fg-radio" name="type" value="1">境内供应商</label></li>
							<li><label class="choice-type"><input type="radio" class="fg-radio" name="type" value="3">境外供应商</label></li>
							<li><label class="choice-type"><input type="radio" class="fg-radio" name="type" value="2">个人</label></li>
						</ul>
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">负责人手机号：<i>*</i></div>
					<div class="fg-input"><input type="text" name="mobile" maxlength="11" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">设置密码：<i>*</i></div>
					<div class="fg-input"><input type="text" name="password" maxlength="20" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">确认密码：<i>*</i></div>
					<div class="fg-input"><input type="text" name="repass" maxlength="20" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">负责人姓名：<i>*</i></div>
					<div class="fg-input"><input type="text" name="realname" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title card-name">身份证扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg9" onchange="uploadImgFile(this);" id="uploadImg9">
						<input type="hidden" name="idcardpic">
					</div>
				</div>
				<div class="form-group">
					<div class="fg-title">所在地：<i>*</i></div>
					<div class="fg-input" id="add-area"></div>
				</div>
				<div class="form-group">
					<div class="fg-title">供应商品牌：<i>*</i></div>
					<div class="fg-input"><input type="text" name="brand" placeholder="若没有，可填写公司简称+部门名,最多5个字" maxlength="5" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">主营业务：<i>*</i></div>
					<div class="fg-input"><input type="text" name="expert_business" maxlength="30" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">联系人：<i>*</i></div>
					<div class="fg-input"><input type="text" name="linkman" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">联系人手机号：<i>*</i></div>
					<div class="fg-input"><input type="text" name="link_mobile" maxlength="11" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">电话：</div>
					<div class="fg-input"><input type="text" name="tel" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">传真：</div>
					<div class="fg-input"><input type="text" name="fax" /></div>
				</div>
				<div class="form-group">
					<div class="fg-title">电子邮箱：<i>*</i></div>
					<div class="fg-input"><input type="text" name="email" maxlength="50" /></div>
				</div>
				<!-- 以上三种供应商类型公用 -->
				<div class="form-group supplier-da">
					<div class="fg-title">所属企业名称：<i>*</i></div>
					<div class="fg-input"><input type="text" name="company_name" /></div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">营业执照扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg4" onchange="uploadImgFile(this);" id="uploadImg4">
						<input type="hidden" name="business_licence">
					</div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">经营许可证扫描件：<i>*</i></div>
					<div class="fg-input">
						<input type="file" name="uploadImg5" onchange="uploadImgFile(this);" id="uploadImg5">
						<input type="hidden" name="licence_img">
					</div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">经营许可证编号：<i>*</i></div>
					<div class="fg-input"><input type="text" name=licence_img_code /></div>
				</div>
				<div class="form-group supplier-da">
					<div class="fg-title">法人代表姓名：<i>*</i></div>
					<div class="fg-input"><input type="text" name="corp_name" maxlength="20"/></div>
				</div>
				<div class="form-group supplier-d">
					<div class="fg-title">法人代表身份证扫描件：</div>
					<div class="fg-input">
						<input type="file" name="uploadImg1" onchange="uploadImgFile(this);" id="uploadImg1">
						<input type="hidden" name="corp_idcardpic">
					</div>
				</div>
				<div class="form-group">
					<input type="button" class="fg-but fb-close" value="取消" />
					<input type="submit" class="fg-but" value="确定" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
	</div>
</div>
<script>
$('.choice-type').click(function(){
	var type = $(this).find('input').val();
	if (type == 1) {
		$('.supplier-d,.supplier-da').show();
		$('.card-name').text('身份证扫描件：');
	} else if(type == 3) {
		$('.supplier-da').show();
		$('.supplier-d').hide();
		$('.card-name').text('有效证件扫描件：');
	} else if (type == 2) {
		$('.supplier-d,.supplier-da').hide();
		$('.card-name').text('身份证扫描件：');
	}
})


//弹框添加供应商
var addObj = $('#add-supplier');
$('#add').click(function(){
	addObj.find("input[type='text']").val('');
	addObj.find("input[type='hidden']").val('');
	addObj.find("input[type='password']").val('');
	$("select[name='type']").val(1);
	$(".uploadImg").remove();
	addObj.find('select').val(0).change();
	$(".add-box,.mask-box").fadeIn(300);
});

$("#add-supplier").submit(function() {
	$.post("/admin/a/supplier/add_supplier",$(this).serialize(),function(data){
		data = eval('('+data+')');
		if (data.code == 2000) {
			alert(data.msg);
			location.reload();
		} else {
			alert(data.msg);
		}
	})
	return false;
})
</script>

