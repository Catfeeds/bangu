
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
		<li class="active">回复询价</li>
	</ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<ul id="myTab11" class="nav nav-tabs tabs-flat">
					<li class="active" name="tabs"><a href="#home0" data-toggle="tab"
						id="tab0"> 抢询价单</a></li>
					<li class="" name="tabs"><a href="#home1" data-toggle="tab"
						id="tab1"> 指定单</a></li>
					<li class="" name="tabs"><a href="#home2" data-toggle="tab"
						id="tab2"> 已回复</a></li>
					<li class="" name="tabs"><a href="#home3" data-toggle="tab"
						id="tab3"> 已中标</a></li>
					<li class="" name="tabs"><a href="#home4" data-toggle="tab"
						id="tab4"> 已过期</a></li>
				</ul>
				<div class="tab-content  tabs-flat" style="padding-top:10px;">
					<!-- 新询价单 -->
					<div class="tab-pane active" id="home0">
						<div class="widget-body">
							<div id="registration-form">
								<div id="list"></div>
							</div>
						</div>
					</div>
					<!-- 指定单 -->
					<div class="tab-pane active" id="home1">
						<div class="widget-body">
							<div id="registration-form">
								<div id="list1"></div>
							</div>
						</div>
					</div>


					<!-- 已回复 -->
					<div class="tab-pane" id="home2">
						<div class="widget-body">
							<div id="registration-form">
								<div id="list2"></div>
							</div>
						</div>
					</div>
					<!-- 已中标 -->
					<div class="tab-pane active" id="home3">
						<div class="widget-body">
							<div id="registration-form">
								<div id="list3"></div>
							</div>
						</div>
					</div>

					<!-- 已过期 -->
					<div class="tab-pane" id="home4">
						<div class="widget-body">
							<div id="registration-form">
								<div id="list4"></div>
							</div>
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
</div>
<!-- 已完成  查看回复的弹框-->
<div id="reply_scheme_text" style="display: none;">

</div>
<!--弹框结束 -->
<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<?php echo $this->load->view('admin/b1/common/enquiry_order_script'); ?>
<script type="text/javascript">
$(document).on('mouseover', '.title_info', function(){
		$(this).find(".info_txt").show();
	});
$(document).on('mouseout', '.title_info', function(){
		$(".info_txt").hide();
	});

/*询价单  回复*/
jQuery('#list').on("click", 'a[name="reply"]',function(){
	var data=jQuery(this).attr('data');
	$("#enquiry_grab_id").val(data);
    bootbox.dialog({
           message: $("#reply_text").html(),
           title: "回复资源询价单",
  	});

});
// 已完成 查看数据
jQuery('#list1').on("click", 'a[name="reply_scheme"]',function(){

	$("#reply_scheme_text").html('<div id="reply_scheme_data"></div>');

	var data=jQuery(this).attr('data');
	$.post("<?php echo base_url()?>admin/b1/enquiry_order/get_enquiry_reply", { data:data} , function(result) {
	 	if(result){
		 	var html='<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action=""><div class="form-group" id="reply_scheme_content">';
	 		 result = eval('('+result+')');
	 		    $.each(result,function(index,val){
				html=html+'<div class="col-sm-10"><span>'+val['company_name']+'</span><p>'+val['reply']+'</p></div>';
				html=html+'<div class="col-sm-4"style="margin-bottom:25px;"><a href="'+val['attachment']+'">行程文件</a></div>';
			 });
			 html=html+'</div></from>';
         	bootbox.dialog({
                message: $("#reply_scheme_data").html(html),
                title: "查看方案",
                className: "reply_scheme_text"
         	});
		}else{
			var html='暂无数据';
		 	bootbox.dialog({
                message: $("#reply_scheme_data").html(html),
                title: "查看方案",
                className: "reply_scheme_text"
         	});
		}
	});

});
//回复的判断
function CheckeReply(obj){
	 var reson= obj.reason.value;
	 if(reson==''){
		 alert('回复内容不能为空');
		 return false;
	 }
	 var price= obj.price.value;
	 if(price==''){
		 alert('报价不能为空');
		 return false;
	 }else{
		 if(isNaN(price)){
				alert("报价填写填写格式不对");
				return false;
			}
		}
}
//转定制团
/*jQuery('#list3').on("click", 'a[name="return_enquiry"]',function(){
	var id=jQuery(this).attr('data');
	var expert_id=jQuery(this).attr('expert_id');
	var isuse=jQuery(this).attr('isuse');
	var eid=jQuery(this).attr('eid');
	var grabid=jQuery(this).attr('grabid');
	var answer_id=jQuery(this).attr('answer_id');
	$.post("<?php echo base_url()?>admin/b1/enquiry_order/return_groupLine", { id:id,expert_id:expert_id,isuse:isuse,eid:eid,grabid:grabid,answer_id:answer_id} , function(data) {
		if(data>0){
			alert('转定制团成功!请前往定制团编辑定制团线路');
			window.location.href="/admin/b1/group_line/toLineEdit?id="+data;
		}else{
			alert(result.msg);
		}

		 jQuery('#tab3').click();
	});

});*/
//转定制团
function return_enquiry(obj){
	var id=$(obj).attr('data');
	var expert_id=$(obj).attr('expert_id');
	var isuse=$(obj).attr('isuse');
	var eid=$(obj).attr('eid');
	var grabid=$(obj).attr('grabid');
	$.post("<?php echo base_url()?>admin/b1/enquiry_order/return_groupLine", { id:id,expert_id:expert_id,isuse:isuse,eid:eid,grabid:grabid} , function(data) {
		var obj = eval('(' + data + ')');	
		if(obj.status==1){
			alert('转定制团成功!请前往定制团编辑定制团线路和添加套餐库存');
			window.location.href="/admin/b1/group_line/toLineEdit?id="+obj.id;
		}else{
			alert(obj.msg);
		}

		 jQuery('#tab3').click();
	});
}
//首页跳转的刷选
function checkorder(){
	var type='<?php if(!empty($type)){ echo $type;} ?>';
	var cancel='<?php if(!empty($cancel)){ echo $cancel;} ?>';
	var status='<?php if(!empty($status)){ echo $status;} ?>';

	if(type !=''){
		 if(type==4){ //已退款
			 jQuery('#tab3').click();
		 }else if(type==1){
			 jQuery('#tab1').click();
		 }
	}

}

jQuery(document).ready(function(){
	　checkorder();　
});
</script>


