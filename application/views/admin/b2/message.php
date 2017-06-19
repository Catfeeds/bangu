<style type="text/css">
.col_st {float: left;}
.messages_color {background: rgba(255,255,255,0.4);}
.page-body{ padding: 20px}
.page-body .nav-tabs{ background: #fff; border-bottom: 1px solid #ddd;}
.page-body .nav-tabs li{ padding: 0; background: #eaedf1;}
.form-group{ margin-top: 0;}
.form-group{ margin-right: 20px;}
.form-group label{ height: 26px; line-height: 26px; border: 1px solid #dedede; border-right:none; padding: 0 6px; color: #666; float: left}
.tab-content{ box-shadow: none;}
.form-group input{ height:26px; line-height: 26px; padding: 0; padding-left: 10px; float: left;}
.table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px}
.messages_close{ background: #056DAB; color: #fff; width: 80px; height:30px; padding: 5px 8px; position: fixed; border-radius: 2px; top: 75%; left: 50%;}
.messages_letter{ box-shadow: 0 0 40px rgba(0, 0, 0, .5);}
.btn-xs{ font-size:12px;}
.form-group{ float:left}
.ie8_input{ width:100px\9;}
.ie8_select{ padding:5px 5px 6px 5px\9;}
.ie8_pageBox{ width:50%\9; float:left\9}
input{ line-height:100%\9;}
.has-feedback{ float:none !important;}
.tabbable { padding:0 10px;background:#fff;}
.nav-tabs { box-shadow:none;}
label { margin-bottom:0;}
.table>tbody>tr>td{ padding: 6px;}
.formBox { padding:0 0 15px 0;}
.tab-content { padding:15px 0 !important;}
</style>
<!-- Page Header -->
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i> <a
			href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
		<li class="active">消息通知</li>
	</ul>
</div>
<!-- Page Body -->
<div class="page-body" id="bodyMsg">
	<div class="widget">
		<!--  <div class="widget-body"> -->
		<div class="flip-scroll">
			<div class="tabbable">
				<ul id="myTab5" class="nav nav-tabs">
					<li class="active">
						<a href="<?php echo base_url(); ?>admin/b2/message/index">
						业务通知
						<?php if($statis_msg['buniess']>0):?>
						<span style="color: #FF0000"><?php echo '('.$statis_msg['buniess'].')'?></span>
						<?php endif;?>
						</a>
					</li>
					<li class="tab-red">
						<a href="<?php echo base_url(); ?>admin/b2/message/system">
						平台公告
						<?php if($statis_msg['sys']>0):?>
						<span style="color: #FF0000"><?php echo '('.$statis_msg['sys'].')'?></span>
						<?php endif;?>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<label style="width:100%; padding:0;">
							<form class="form-inline formBox" method=get action="<?php echo site_url('admin/b2/message/search')?>">
								<div class="form-group col_st">
									<label style="">标题:</label>
									<input type="text" class="form-control" name="title" value="<?php if(isset($title)){ echo $title;} ?>" style="display: inline; width: 200px;" />
								</div>
								<div class="form-group col_st" style="margin-left: 4px;">
									<label>接收时间:</label> <select name="time" class="ie8_select">
										<option value="" <?php if(empty($time)){ echo 'selected="selected"';} ?>>请选择</option>
										<option value="1" <?php if(isset($time) && !empty($time)){if($time==1){ echo 'selected="selected"';}} ?>>近一个月</option>
										<option value="2" <?php if(isset($time) && !empty($time)){if($time==2){ echo 'selected="selected"';}} ?>>近两个月</option>
										<option value="3" <?php if(isset($time) && !empty($time)){if($time==3){ echo 'selected="selected"';}} ?>>近三个月</option>
									</select>
								</div>

								<button type="submit" class="btn btn-darkorange active"
									style="margin-left: 10px; margin-top: -px;">搜索</button>
							</form>
						</label>

						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="text-align: center">消息编号</th>
									<th style="text-align: center">消息标题</th>
									<th style="text-align: center">接收时间</th>
									<!-- <th style="text-align:center">接收时间</th> -->
									<th style="text-align: center">阅读状态</th>
									<th style="text-align: center">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($msg_list as $item): ?>
								<tr>
									<td style="text-align: center">
					                   <?php echo $item['id']?>
					                </td>
									<td style="text-align: left">
										<a href="#" data="<?php echo $item['id'];?>" name="show"><?php echo $item['title']?></a>
									</td>
									<td style="text-align: center">
											<?php echo $item['addtime']?>
									 </td>
									<!-- <td style="text-align:center">
                     					<?php echo $item['modtime']?>
           	 						</td> -->
									<td style="text-align: center">
				                     	<?php if($item['read']==1):?>
				                     		<span style="color: #0000FF">已读</span>
				                     	<?php else:?>
				                     		<span style="color: #FF0000">未读</span>
				                     	<?php endif;?>
						           	</td>
									<td style="text-align: center">
										<a onclick="delete_msg(this)" class="delete" data-val="<?php echo $item['id']?>">删除</a>
									</td>
								</tr>
						       <?php endforeach;?>
						</tbody>
						</table>
                        <div class="boostCenter" style="padding-top:20px;">
                            <div class="pagination"><?php echo $this->page->create_page()?></div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 消息弹出框 -->
<div style="display: none;" class="messages_letter">

	<div align="center" class="messages_show"></div>
	<!-- 消息内容 -->
	<div align="center" class="messages_show" style="height:100%;">
		<div class="widget-body"  style="height:140px;">
			<div id="registration-form">
				<h1>业务通知：</h1>
				<div class="form-title"></div>
				<div class="form-group has-feedback">
					<label class="col-lg-4 control-label" style="width: 34%; border: none;" id="issue_addtime">发布时间：</label>
					<label class="col-lg-4 control-label" style="width: 20%; border: none;" id="issue_people"></label>
				</div>
			</div>
		</div>
		<div style="margin: 0 0px 0px 0px;width:95%;height:55%;line-height:30px;overflow-y:auto;overflow-x:hidden;" id="issue_content">内容</div>
		<div class="messages_close">关闭</div>
	</div>
</div>
<div class="messages_color" style="display: none;"></div>
<!-- 消息弹出框结束 -->
<script type="text/javascript">
                     					
$(document).ready(function() { 

	$('.news_num', window.parent.document).html("("+<?php if(!empty($statis_msg['sum_msg'])){echo $statis_msg['sum_msg'];}else{ echo 0;} ?>+")");
});
	
jQuery('.table-hover').on("click", 'a[name="show"]',function(){
	var data=jQuery(this).attr('data');

	$(".messages_color,.messages_letter").show();
	$(".messages_close").click(function(e) {
		$.post("<?php echo base_url()?>admin/b2/message/get_message_num", { data:data} , function(result) {
			 var result = eval('(' + result + ')');
			$(".messages_color,.messages_letter").hide();
			$('.news_num', window.parent.document).html("("+result.mess.sum_msg+")");
			location.reload();
		});
	});

	$.post("<?php echo base_url()?>admin/b2/message/ajax_data", { data:data} , function(result) {
		  var result = eval('(' + result + ')');
		 	if(result.status==1){
		 	
			 	$('.messages_letter').find('h1').html('业务通知:'+result.data.title);
			 	$('#issue_addtime').html('发布时间：'+result.data.addtime);
				$('#issue_content').html(result.data.content);
			}else{
				alert('暂无通告！');
			}
	});

});

function delete_msg(obj){
	var msg_id = $(obj).attr('data-val');
	if(confirm('是否要删除该条消息?')){
		$.post("<?php echo base_url()?>admin/b2/message/ajax_delete_msg",
		{ 'msg_id':msg_id} ,
		function(result) {
			result = eval('('+result+')');
			if(result.status==200){
				alert(result.msg);
				location.reload();
			}else{
				alert(result.msg);
			}
		});
	}
}
</script>
