<style type="text/css">
	.eject_list_name{ width: 20%; text-align: right;margin-right: 15px;}
</style>
<div class="page-content">
	<div class="page-breadcrumbs">
		<ul class="breadcrumb">
			<li><i class="fa fa-home"> </i> <a href="<?php echo site_url('admin/a/')?>"> 首页 </a></li>
			<li class="active">站点配置</li>
		</ul>
	</div>
	<!-- Page Body -->
	<div class="page-body">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="well with-header with-footer" style="position:relative">
				<form method = "post" action="#" id="web_form">
					<div class="web_body" >
						<div class="eject_content">
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">网站标题:</div>
									<div class="content_info"><input type="text" name="title" value="<?php echo $title?>"></div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">网站地址:</div>
									<div class="content_info"><input type="text" name="url" value="<?php echo $url?>"></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">网站名称:</div>
									<div class="content_info"><input type="text" name="webname" value="<?php echo $webname?>"></div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">icon地址:</div>
									<div class="content_info"><input type="text" name="icon" value="<?php echo $icon?>"></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">关键词:</div>
									<div class="content_info"><input type="text" name="keyword" value="<?php echo $keyword?>"></div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">公司名称:</div>
									<div class="content_info"><input type="text" name="companyname" value="<?php echo $companyname?>"></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">备案号:</div>
									<div class="content_info"><input type="text" name="icp" value="<?php echo $icp?>"></div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">订单自动取消时间:</div>
									<div class="content_info"><input type="text" name="ordor_cancel_ms" value="<?php echo $ordor_cancel_ms?>"></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">管理费率:</div>
									<div class="content_info"><input type="text" name="agent_rate" value="<?php echo $agent_rate * 100?>">%</div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">客服平台域名：</div>
									<div class="content_info"><input type="text" name="expert_question_url" value="<?php echo $expert_question_url?>"></div>
								</div>
							</div>
							
							<!-- 
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">用户咨询管家url:</div>
									<div class="content_info"><input type="text" name="member_question_url" value="<?php echo $member_question_url?>"></div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name "></div>
									<div class="content_info"></div>
								</div>
							</div>
							 -->
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">供应商使用说明书:</div>
									<div class="content_info">
										<input type="file" name="upSupplierBook" id="upSupplierBook" onchange="upload_book(this);">
										<input type="hidden" name="supplier_use_book" value="<?php echo $supplier_use_book?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">供应商查看说明书提示时间:</div>
									<div class="content_info">
									<input type="text" name="supplier_pop_hour" value="<?php echo $supplier_pop_hour?>">
									</div>
									
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">管家使用说明书:</div>
									<div class="content_info">
									<input type="file" name="upExpertBook"  id="upExpertBook" onchange="upload_book(this)">
									<input type="hidden" name="expert_use_book" value="<?php echo $expert_use_book?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">供应商查看说明书提示时间:</div>
									<div class="content_info">
									<input type="text" name="expert_pop_hour" value="<?php echo $expert_pop_hour?>">
									</div>
									
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">管理员使用说明书:</div>
									<div class="content_info">
										<input type="file" name="upAdminBook"  id="upAdminBook" onchange="upload_book(this);">
										<input type="hidden" name="admin_use_book" value="<?php echo $admin_use_book?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">供应商查看说明书提示时间:</div>
									<div class="content_info">
									<input type="text" name="admin_pop_hour" value="<?php echo $admin_pop_hour?>">
									</div>
									
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">手机客服定时刷新毫秒:</div>
									<div class="content_info">
										<input type="text" name="chat_interval_m"  id="upAdminBook" value="<?php echo $chat_interval_m;?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">PC定时刷新毫秒:</div>
									<div class="content_info">
									<input type="text" name="chat_interval" value="<?php echo $chat_interval?>">
									</div>
									
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">境内旅游合同:</div>
									<div class="content_info">
										<input type="file" name="contract_domestic"  id="contract_domestic" onchange="upload_book(this);">
										<input type="hidden" name="travel_contract_domestic_url" value="<?php echo $travel_contract_domestic_url?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">境外旅游合同:</div>
									<div class="content_info">
										<input type="file" name="contract_abroad"  id="contract_abroad" onchange="upload_book(this);">
										<input type="hidden" name="travel_contract_abroad_url" value="<?php echo $travel_contract_abroad_url?>">
									</div>
									
								</div>
							</div>
							
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">备注:</div>
									<div class="content_info"><textarea rows="7" cols="37" name="description"><?php echo $beizhu?></textarea></div>
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">描述:</div>
									<div class="content_info"><textarea rows="7" cols="37" name="description"><?php echo $description?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">海外营业执照:</div>
									<div class="content_info">
										<input type="file" name="business"  id="business" onchange="upload_book(this);">
										<input type="hidden" name="business_licence" value="<?php echo $business_licence?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">海外经营许可:</div>
									<div class="content_info">
										<input type="file" name="business_two"  id="business_two" onchange="upload_book(this);">
										<input type="hidden" name="business_licence_two" value="<?php echo $business_licence_two?>">
									</div>
									
								</div>
							</div>
							<div class="eject_content_list">
								<div class="eject_list_row">
									<div class="eject_list_name ">帮游科技执照:</div>
									<div class="content_info">
										<input type="file" name="business_three"  id="business_three" onchange="upload_book(this);">
										<input type="hidden" name="business_licence_three" value="<?php echo $business_licence_three?>">
									</div>
									
								</div>
								<div class="eject_list_row">
									<div class="eject_list_name ">帮游旅行执照:</div>
									<div class="content_info">
										<input type="file" name="business_four"  id="business_four" onchange="upload_book(this);">
										<input type="hidden" name="business_licence_four" value="<?php echo $business_licence_four?>">
									</div>
									
								</div>
							</div>
							<div class="eject_content_list">

								<div class="eject_list_row">
									<div class="eject_list_name ">营业执照说明:</div>
									<div class="content_info"><textarea rows="7" cols="37" name="business_licence_description"><?php echo $business_licence_description?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">国内旅游合同模板:</div>
									<div class="content_info"><textarea  id="travel_contract_domestic" name="travel_contract_domestic"><?php echo $travel_contract_domestic?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">国外旅游合同模板:</div>
									<div class="content_info"><textarea id="travel_contract_abroad" name="travel_contract_abroad"><?php echo $travel_contract_abroad?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">预订步骤:</div>
									<div class="content_info"><textarea  id="bookstep" name="bookstep"><?php echo $bookstep?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">拍卖流程:</div>
									<div class="content_info"><textarea id="auction_flow" name="auction_flow"><?php echo $auction_flow?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">品牌荣誉:</div>
									<div class="content_info"><textarea id="honor" name="honor"><?php echo $honor?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">企业信用:</div>
									<div class="content_info"><textarea id="credit" name="credit"><?php echo $credit?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">企业简介:</div>
									<div class="content_info"><textarea id="summary" name="summary"><?php echo $summary?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">企业文化:</div>
									<div class="content_info"><textarea id="culture" name="culture"><?php echo $culture?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">招聘说明:</div>
									<div class="content_info"><textarea id="hire_desc" name="hire_desc"><?php echo $hire_desc?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">友情链接说明:</div>
									<div class="content_info"><textarea id="friendlink_desc" name="friendlink_desc"><?php echo $friendlink_desc?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">隐私说明:</div>
									<div class="content_info"><textarea id="privacy_desc" name="privacy_desc"><?php echo $privacy_desc?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">联系我们:</div>
									<div class="content_info"><textarea id="contactus" name="contactus"><?php echo $contactus?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">补充条款:</div>
									<div class="content_info"><textarea id="supplement_clause" name="supplement_clause"><?php echo $supplement_clause?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">安全提示:</div>
									<div class="content_info"><textarea id="safety_tips" name="safety_tips"><?php echo $safety_tips?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">违约责任:</div>
									<div class="content_info"><textarea id="breach_tips" name="breach_tips"><?php echo $breach_tips?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">旅游合同:</div>
									<div class="content_info"><textarea id="contract" name="contract"><?php echo $contract?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">用户注册协议:</div>
									<div class="content_info"><textarea id="protocol_user" name="protocol_user"><?php echo $protocol_user?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">管家注册协议:</div>
									<div class="content_info"><textarea id="protocol_expert" name="protocol_expert"><?php echo $protocol_expert?></textarea></div>
								</div>
							</div>
							<div class="eject_content_list_text">
								<div class="eject_list_row">
									<div class="eject_list_name ">供应商注册协议:</div>
									<div class="content_info"><textarea id="protocol_supplier" name="protocol_supplier"><?php echo $protocol_supplier?></textarea></div>
								</div>
							</div>
						</div>					
					</div>	
					<div class="table-toolbar">
						<input type="hidden" name="id" value="<?php echo $id?>">
						<a href="javascript:void(0);" class="btn btn-default" onclick="edit_web(<?php echo $id?>)"> 保存</a>
					</div>		
					</form>	
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 编辑器 -->
<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.config.js"></script>
<script src="<?php echo base_url() ;?>file/common/plugins/ueditor/ueditor.all.min.js"></script>
<script src="<?php echo base_url() ;?>assets/js/ajaxfileupload.js"></script>
<script>
//上传文件
function upload_book(obj) {
	var fileId = $(obj).attr('name');
	 $.ajaxFileUpload({  
         url:'<?php echo site_url('admin/a/web/up_file');?>',  
         secureuri:false,  
         fileElementId:fileId,//file标签的id  
         dataType: 'json',//返回数据的类型  
         data:{filename:fileId},
         success: function (data, status) {  
           	if (data.status == 1) {
           			switch(fileId) {
           				case 'upAdminBook':
           					$('input[name="admin_use_book"]').val(data.url);
               				break;
           				case 'upExpertBook':
           					$('input[name="expert_use_book"]').val(data.url);
           					break; 
           				case 'upSupplierBook':
							$('input[name="supplier_use_book"]').val(data.url);
           					break;
           				case 'contract_abroad':
           					$('input[name="travel_contract_abroad_url"]').val(data.url);
               				break;
           				case 'contract_domestic':
           					$('input[name="travel_contract_domestic_url"]').val(data.url);
           					break;
           				case 'business_two':
           					$('input[name="business_licence"]').val(data.url);
               				break;
           				case 'business':
           					$('input[name="business_licence_two"]').val(data.url);
               				break;
           				case 'business_three':
           					$('input[name="business_licence_three"]').val(data.url);
               				break;
           				case 'business_four':
           					$('input[name="business_licence_four"]').val(data.url);
               				break;
           			}
					alert('上传成功');
	            } else {
					alert(data.msg);
		        }
         },  
         error: function (data, status, e) {  
         	alert("请选择不超过10M的doc|txt|xls|docx的文件上传");   
         }  
     });  
     return false;
}
//上传合同
/*function upload_contract(obj){
	var fileId = $(obj).attr('name');
	 $.ajaxFileUpload({  
        url:'<?php echo site_url('admin/a/web/up_contract_file');?>',  
        secureuri:false,  
        fileElementId:fileId,//file标签的id  
        dataType: 'json',//返回数据的类型  
        data:{filename:fileId},
        success: function (data, status) {  
          	if (data.status == 1) {
          			switch(fileId) {
          				case 'contract_abroad':
          					$('input[name="travel_contract_abroad_url"]').val(data.url);
              				break;
          				case 'contract_domestic':
          					$('input[name="travel_contract_domestic_url"]').val(data.url);
          					break;
          			}
					alert('上传成功');
	            } else {
					alert(data.msg);
		        }
        },  
        error: function (data, status, e) {  
        	alert("请选择不超过10M的doc|txt|xls|docx的文件上传");   
        }  
    });  
    return false;
}
*/

var ue = UE.getEditor('travel_contract_domestic');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('travel_contract_abroad');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('breach_tips');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('contract');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('protocol_user');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('protocol_expert');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('protocol_supplier');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('bookstep');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('auction_flow');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('honor');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('credit');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('summary');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('culture');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('hire_desc');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('friendlink_desc');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('privacy_desc');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('contactus');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('supplement_clause');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});
var ue = UE.getEditor('safety_tips');
ue.ready(function() {
    //设置编辑器的内容
     $('.edui-editor').css({'width':'900px','height':'300px'});
     $('.edui-editor-iframeholder').css({'width':'100%','height':'80%'});
    ue.setContent();
   
});

function edit_web() {
	$.post(
			"<?php echo site_url('admin/a/web/edit_web')?>",
			$('#web_form').serialize(),
			function(data) {
				data = eval('('+data+')');
				if (data.code == 2000) {
					alert(data.msg);
					window.location.reload();
				} else {
					alert(data.msg);
				}
			}
		)
}
	
</script>