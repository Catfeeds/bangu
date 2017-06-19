<style type="text/css">
             .col-lg-4{ float: left;}     
             .form-horizontal .control-label{ padding-top: 0px; line-height: 34px;}
			 .pagination { padding-bottom:30px;}    
			 #registration-form { padding-top:15px;}
</style>
	<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a
			href="/admin/b1/view">首页</a></li>
		<li class="active">供应商后台</li>
        <li class="active">线路点评</li>
	</ul>
</div>

<!-- /Page Header -->
 <div class="widget flat radius-bordered search_box">                                                
	<div class="widget-body">
		<div id="registration-form">
			<form data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
				data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
				data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
				data-bv-message="This value is not valid"
				class="form-horizontal bv-form" method="post" id="registrationForm"
				novalidate="novalidate">
				<div class="form-group has-feedback">			
					<label class="col-lg-4 control-label " style="width:auto;">产品名称：</label>
					<div class="col-lg-4 " style="width: 20%;">
						<input type="text" name="productname"
							class="form-control user_name_b1" >
					</div>
					<label class="col-lg-4 control-label" style="width: 2%;">&nbsp;</label>
					<div class="col-lg-4" style="width: 10%;">
						<input type="button" value="搜索" class="btn btn-palegreen" id='searchBtn'>
					</div>
				</div>
			</form>
				<div id="user_line" class="clear"></div>
	  </div>
  </div>
</div>

<!-- 回复弹框-->
 <div class="fb-content" id="reply_text" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">线路点评</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply-data" class="form-horizontal">
            <div class="form_con ">
                   <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">回复内容</label>
                <div class="col-sm-10">
                <input type="hidden" value="" name="reply_comment_id">
                    <textarea name="reason" id="reason" style="resize:none;width:100%;height:120px;text-indent:0.5em;"></textarea>
                </div>
            </div>
            </div>
            <div class="form_btn clear" >
                  <input type="button" value="提交" class="btn btn_blue" style="margin-left:250px;"  onclick="add_replay(this)" >
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>
<!--弹框结束 -->

<!-- 申请弹框-->
 <div class="fb-content" id="supplier_replay" style="display:none;" >
    <div class="box-title">
        <h4 class="s_order_data">线路点评</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="apply" class="form-horizontal">
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label no-padding-right">申诉内容</label>
                <div class="col-sm-10">
                <input type="hidden" value="" name="comment_id">
                    <textarea name="appeal_reason" id="appeal_reason" style="resize:none;width:100%;height:120px;text-indent:0.5em;"></textarea>
                </div>
            </div>
            <div class="form_btn clear" >
                  <input type="button" value="提交" class="btn btn_blue" style="margin-left:250px;"  onclick="s_replay(this)" >
                  <input type="button" name="" value="关闭" class="layui-layer-close btn btn_blue" style="margin-left:80px;"  >
            </div>
        </form>
    </div>
</div>

<!--线路详情-->
<?php echo $this->load->view('admin/common/line_detail_script'); ?>

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<!--弹框结束 -->
<script type="text/javascript">
//回复
jQuery('#user_line').on("click", 'a[name="reply"]',function(){
	  $('textarea[name="reason"]').val();
	  var id = jQuery(this).attr('data');
	  $.post(
			"<?php echo site_url('admin/b1/line_review/get_review')?>",
			{'id':id},
			function(data) {
				data = eval('('+data+')');
				//alert(data.res.reply1);
				if(data.res.reply1!=null || data.res.reply1!=''){
				    $('textarea[name="reason"]').val(data.res.reply1);	
				}			
			} 
	   );
		 
	  $('input[name="reply_comment_id"]').val(id);

	  layer.open({
          type: 1,
          title: false,
          closeBtn: 0,
          area: '600px',
          shadeClose: false,
          content: $('#reply_text')
      });
	  
});

	
//申诉
jQuery('#user_line').on("click", 'a[name="replay_data"]',function(){

	  var id = jQuery(this).attr('data');
	  $('input[name="comment_id"]').val(id); 
	  layer.open({
          type: 1,
          title: false,
          closeBtn: 0,
          area: '600px',
          shadeClose: false,
          content: $('#supplier_replay')
      });
});
//申诉内容的提交
function s_replay(obj){
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#apply').serialize(),url : "<?php echo base_url()?>admin/b1/line_review/insert_appeal", 
		 success : function(response) { 
				var response = eval('(' + response + ')'); 
				if(response.status==1){
					 alert(response.msg);
					 window.location.reload();
			    }else{
			    	 alert(response.msg);
				}   
		 }
     });
	    
	 return false;
}

//提交申请
function add_replay(obj){
	var reason= $('#reply_text').find("textarea[name='reason']").val();
	jQuery.ajax({ type : "POST",async:false,data : jQuery('#apply-data').serialize(),url : "<?php echo base_url()?>admin/b1/line_review/reply", 
		 success : function(response) { 
				var response = eval('(' + response + ')'); 
			    alert(response.msg);
			    window.location.reload();
		 }

     });
	    
	 return false;
}

</script>

<?php echo $this->load->view('admin/b1/common/line_review_script'); ?>
