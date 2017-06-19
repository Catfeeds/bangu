<!-- 管家详情 -->
<div class="eject_body details_expert">
	<div class="eject_colse ex_colse">X</div>
	<div class="eject_title ex_realname">境内管家：贾开荣</div>
	<div class="eject_content" style="position:relative;">
	<div class="eject_subtitle"><span>基本信息</span></div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">手机号:</div>
				<div class="content_info ex_mobile"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">邮箱号:</div>
				<div class="content_info ex_email"></div>
			</div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">性别:</div>
				<div class="content_info ex_sex"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">昵称:</div>
				<div class="content_info ex_nickname"></div>
			</div>	
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row abroad_expert">
				<div class="eject_list_name ">证件类型:</div>
				<div class="content_info ex_idcardtype"></div>
			</div>	
		</div>
		
		<div class="eject_content_list domestic_expert">
			<div class="eject_list_row">
				<div class="eject_list_name ">身份证:</div>
				<div class="content_info ex_idcard"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">微信号:</div>
				<div class="content_info ex_weixin"></div>
			</div>
			
		</div>
		<div class="eject_content_list abroad_expert">
			<div class="eject_list_row">
				<div class="eject_list_name ">证件号:</div>
				<div class="content_info ex_idcard"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">微信号:</div>
				<div class="content_info ex_weixin"></div>
			</div>
		</div>
		
		<div class="eject_content_list domestic_expert">
			<div class="eject_list_row">
				<div class="eject_list_name ">身份证扫描件:</div>
				<div class="content_info ex_idcardpic"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">管家头像:</div>
				<div class="content_info ex_photo"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list abroad_expert">
			<div class="eject_list_row">
				<div class="eject_list_name ">证件扫描件:</div>
				<div class="content_info ex_idcardpic"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">管家头像:</div>
				<div class="content_info ex_photo"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">擅长线路:</div>
				<div class="content_info ex_destname"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">个人简介:</div>
				<div class="content_info ex_beizhu"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row">
				<div class="eject_list_name ">所在地:</div>
				<div class="content_info ex_address"></div>
			</div>
			<div class="eject_list_row">
				<div class="eject_list_name ">上门服务地区:</div>
				<div class="content_info ex_cityname"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list">
			<div class="eject_list_row" style="width:100%;">
				<div class="eject_list_name " style="width:15%;">个人描述:</div>
				<div class="content_info ex_talk"></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_subtitle"><span>从业经历</span></div>
		<div class="eject_table">
			<table class="table table-striped table-hover table-bordered dataTable no-footer" >
				<thead>
					<tr>
						<th>起止时间</th>
						<th>所在企业</th>
						<th>职务</th>
						<th>工作描述</th>
					</tr>
				</thead>
				<tbody class="resume_list"> </tbody>
			</table>
		</div>
		<div class="eject_content_list refuse_reasion" style="display:none;">
			<div class="eject_list_row" style="width:100%;">
				<div class="eject_list_name " style="width:15%;">退回原因:</div>
				<div class="content_info" style="width:79%;"><textarea style="width:100%;" rows="5" name="refuse_reasion"></textarea></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_content_list bridge_reason" style="display:none;">
			<div class="eject_list_row" style="width:100%;">
				<div class="eject_list_name " style="width:15%;">拒绝原因:</div>
				<div class="content_info" style="width:79%;"><textarea style="width:100%;" rows="5" name="reason"></textarea></div>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div class="eject_botton">
			<input type="hidden" value="" name="id" />
			<input type="hidden" value="" name="mapid" />
			<div class="ex_colse">关闭</div>
			<div class="ex_refuse">退回</div>
			<div class="bridge_refuse">拒绝</div>
			<div class="ex_through">通过</div>
		</div>	
	</div>						
</div>
<script>
function expertDetails(expertid ,type ,url) {
	var status = $('input[name="status"]').val();
	$.post(url,{'id':expertid},function(data) {
		if (data == false) {
			alert("请确认您选择的专家正确");
			return false;
		}
		var data = eval('('+data+')');
		$(".expert_certificate").remove();
		if (data.type == 1) {
			$('.ex_realname').html('境内管家:'+data.realname);
			//荣誉证书
			createCertificate(data.certificate);
			$(".abroad_expert").hide();
			$(".domestic_expert").show();
		} else {
			$('.ex_realname').html('境外管家:'+data.realname);
			$(".abroad_expert").show();
			$(".domestic_expert").hide();
			$(".ex_idcardtype").html(data.idcardtype);
		}
		
		$('.ex_mobile').html(data.mobile);
		$('.ex_email').html(data.email);
		if (typeof data.ra_name == 'object') {
			var ra_name = '';
		} else {
			var ra_name = data.ra_name;
		}
		if (typeof data.cia_name == 'object') {
			var cia_name = '';
		} else {
			var cia_name = data.cia_name;
		}
		$('.ex_address').html(data.ca_name+data.pa_name+cia_name+ra_name);
		if (data.sex == 0) {
			$('.ex_sex').html('女');
		} else if (data.sex == 1) {
			$('.ex_sex').html('男');
		} else {
			$('.ex_sex').html('保密');
		}
		$(".ex_nickname").html(data.nickname);
		$('.ex_idcard').html(data.idcard);
		$('.ex_weixin').html(data.weixin);
		$('.ex_idcardpic').html('<a href="'+data.idcardpic+'" target="_blank"><img src="'+data.idcardpic+'" width="80" /></a>');
		$('.ex_photo').html('<a href="'+data.small_photo+'" target="_blank"><img src="'+data.small_photo+'" width="80" /></a>');

		$('.ex_destname').html(data.destName);
		$('.ex_beizhu').html(data.beizhu);
		$('.ex_cityname').html(data.cityname);
		$('.ex_talk').html(data.talk);

		//个人从业经历
		var html = '';
		$.each(data.resume ,function(index ,item){
			html += '<tr>';
			html += '<td>'+item.starttime+'&nbsp;到&nbsp;'+item.endtime+'</td>';
			html += '<td>'+item.company_name+'</td>';
			html += '<td>'+item.job+'</td>';
			html += '<td title="'+item.description+'">'+item.description.substring(0,10)+'</td>';
			html += '</tr>';
		})
		$('.resume_list').html(html);
		
		$('input[name="id"]').val(data.id);
		if (typeof data.mapid != 'undefined') {
			$("input[name='mapid']").val(data.mapid);
		}

		switch(type) {
			case 1:
				$('.ex_refuse,.refuse_reasion,.bridge_refuse,.bridge_reason').hide();
				$('.ex_through').show();
				break;
			case 2:
				$('.ex_refuse,.refuse_reasion').show();
				$('.ex_through,.bridge_refuse,.bridge_reason').hide();
				$('.refuse_reasion').find(".eject_list_name ").html("退回原因：");
				$('.refuse_reasion').find(".content_info ").find("textarea").removeAttr("disabled" ,"disabled");
				break;
			case 3://管家资料审核拒绝
				$('.ex_refuse,.ex_through').hide();
				$('.bridge_refuse,.refuse_reasion,.bridge_reason').show();
				$('.refuse_reasion').find(".eject_list_name ").html("修改原因：");
				$('.refuse_reasion').find(".content_info ").find("textarea").val(data.map_reason).attr("disabled" ,"disabled");
				break;
			default:
				$('.ex_through,.ex_refuse,.refuse_reasion,.bridge_refuse,.bridge_reason').hide();
				break;
		}

		$('.modal-backdrop').show();
		$('.details_expert').show();
	});
}


/**
 * @method 生成荣誉证书的html
 * @param  certificate 荣誉证书的数组
 */
function createCertificate(certificate) {
	var html = '<div class="eject_subtitle expert_certificate"><span>荣誉证书</span></div>';
	html += '<div class="eject_table expert_certificate">';
	html += '<table class="table table-striped table-hover table-bordered dataTable no-footer" >';
	html += '<thead><tr><th>证书名称</th><th>扫描件</th></tr></thead>';
	html += '<tbody class="certificate_list">';
	
	$.each(certificate ,function(key ,val){
		html += '<tr>';
		html += '<td>'+val.certificate+'</td>';
		if (typeof val.certificatepic != 'object' && val.certificatepic.length > 1) {
			html += '<td><a href="'+val.certificatepic+'" target="_blank"><img src="'+val.certificatepic+'" style="width:50px;"></a></td>';
		} else {
			html += '<td></td>';
		}
		html += '</tr>';
	})
	html += '</tbody>';			
	html += '</table></div>';
	$('.refuse_reasion').before(html);
}
</script>
