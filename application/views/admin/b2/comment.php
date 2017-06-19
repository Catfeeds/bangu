<style>
    .page-body{ padding: 20px;}
    .form-group input{ padding: 0; margin: 0; height:26px;line-height: 26px;;}
    .boostCenter{ width:100%; text-align:center; padding:5px 15px 15px 15px; background: #fff;}
    .well.with-footer{ padding-bottom: 20px;}
    .table>thead>tr>th, .table>tbody>tr>td{ padding: 10px 5px}
    .well.with-header { padding: 0; box-shadow: none;}
    .form-group{ margin-top: 0;}
    .headerBox{ padding: 10px;}
    .tableBox{ padding: 10px;padding-top:0;}
    .well{ background: none;}
    .shadow{ background: #fff;}
    .table>tbody>tr>td{ padding: 6px;}
</style>
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"> </i> <a
			href="<?php echo site_url('admin/b2/home/index')?>"> 主页 </a></li>
		<li class="active">客人点评</li>
	</ul>
</div>
<!-- /Page Header -->
<!-- Page Body -->
<div class="page-body" id="bodyMsg">

	<div class="well with-header with-footer">
        <div class="shadow headerBox">
            <form class="form-inline clear" method="post"
                action="<?php echo site_url('admin/b2/comment/index')?>">

                <div class="form-group fl">
                     <input type="text" class="form-control" name="linename" value="<?php echo $linename;?>" style=" padding:0 10px;"/>
                </div>
                <button type="submit" class="btn btn-darkorange active fl" style="margin-left: 10px;">线路搜索</button>
            </form>
		</div>
		<div class="tableBox shadow">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th style="text-align: center;width: 300px;">线路</th>
						<th style="text-align: center;width: 100px;">会员</th>
						<th style="text-align: center;width: 300px;">内容</th>
						<th style="text-align: center;width: 150px;">评论时间</th>
						<th style="text-align: center;width: 70px;">评分</th>
						<!-- <th style="text-align: center"></th> -->
					</tr>
				</thead>
				<tbody>
	                 <?php foreach ($comment_list as $item): ?>
	                 <tr>
						<td style="text-align: left" title="<?php echo $item['line_name']?>"> <?php echo $item['line_name'];?> </td>
						<td style="text-align: center"> <?php echo $item['member_name'];?></td>
						<td style="text-align: left;position: relative;" class="comment_content">
	                        <?php echo $item['content'] ; ?>
	                        <style>
	.content_reply{position: absolute;width: 420px;background: #fff;left: 20%;top: -20px;display:none;border:2px solid #ccc;padding:20px;margin-bottom:20px;z-index:100;}
	.content_title{float:left;width:100px;}
	.content_content{float:left;width:270px;padding-right:20px;margin-bottom:20px;}
							</style>
							<div class="content_reply" >
								<div class="content_row">
									<div class="content_title">评论内容:</div>
									<div class="content_content"><?php echo $item['content']?></div>
								</div>
								<div class="content_row">
									<div class="content_title" style='color:#0066CC'>平台回复:</div>
									<div class="content_content" style='color:#0066CC'><?php echo empty($item['a_reply'])?'空':$item['a_reply']?></div>
									<div class="content_title" style='color:#9900FF;'>供应商回复:</div>
									<div class="content_content" style='color:#9900FF;'><?php echo empty($item['s_reply'])?'空':$item['s_reply']?></div>
								</div>
							</div>
						</td>
						<td style="text-align: center"> <?php echo $item['addtime'];?> </td>
						<td style="text-align: center"> <?php echo $item['score'];?> </td>
						<!-- <td style="text-align: center">
							<a style="cursor: pointer;" onclick="show_comment_dialog(this)" data-val="<?php echo $item['comment_id'];?>">回复</a></td> -->
					</tr>
	                <?php endforeach;?>
	            </tbody>
			</table>
		</div>
        <div class="boostCenter">
		  <div class="pagination"><?php echo $this->page->create_page()?></div>
        </div>

	</div>

</div>




<div id="comment_myModal" style="display: none;">
	<div class="bootbox-body">
		<form class="form-horizontal" role="form" method="post"
			action="<?php echo base_url();?>admin/b2/comment/client_comment">
			<div class="form-group">
				<label for="inputPassword3"
					class="col-sm-2 control-label no-padding-right">回复</label>
				<div class="col-sm-10">
					<textarea name="content"
						style="resize: none; width: 100%; height: 100%"></textarea>
					<input type="hidden" name="comment_id" id="comment_id" value="" />
				</div>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-palegreen"
					data-bb-handler="success" value="提交"
					style="float: right; margin-right: 2%;">
			</div>
		</form>
	</div>
</div>

<script src="<?php echo base_url() ;?>assets/js/bootbox/bootbox.js"></script>
<script type="text/javascript">
$('.comment_content').mousemove(function(){
	$(this).find('.content_reply').show();
}).mouseout(function(){
	$(this).find('.content_reply').hide();
})


function show_comment_dialog(obj){
     var comment_id = $(obj).attr('data-val');
     $("#comment_id").val(comment_id);
      bootbox.dialog({
                    message: $("#comment_myModal").html(),
                    title: "评论回复",
        });
 /*      $.post(
    "<?php echo base_url();?>b2/comment/client_comment",
    {'comment_id':comment_id },
    function (data) {
         bootbox.dialog({
                    message: '申请线路成功',
                    title: "申请路线",
                    buttons: {
            success: {
                label: "Success",
                className: "btn-success",
                 callback: function() {
                     location.reload();
                 }
             },
        }
                });

    }
);
*/
}
</script>
