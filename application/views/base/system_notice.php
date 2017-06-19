<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>通知消息</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.SuperSlide.2.1.1.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>

<link type="text/css"href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>

<style>
 .show_notice_box{ width:100%; height:100%; display:none; overflow:hidden; position:absolute; top:0; left:0; background:
rgba(0,0,0,0.6);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);  position: fixed; padding-top:200px;}
 #show_notice{ background:#FFF; border-radius:5px;}
</style>

</head>

<body>
<!-- 头部 -->
<?php $this->load->view('common/header'); ?>
<div id="user-wrapper">
  <div class="container clear"> 
   	<!--左侧菜单开始-->
		<?php $this->load->view('common/user_aside');  ?>
		<!--左侧菜单结束-->
    <!-- 右侧菜单开始 -->
    <div class="nav_right" style="position: relative;">
      <div class="user_title">通知消息</div>
      <div class="consulting_warp">
      		<div class="consulting_tab">
            	<div class="hd cm_hd clear">
                    <ul><li  ><a href="<?php echo base_url(); ?>base/system/message">业务通知</a></li>
                    <li class="on"> <a href="<?php echo base_url(); ?>base/system/notice">平台公告</a></li></ul>
				</div>
				<div class="bd cm_bd">
                    <!-- tab 切换制作中的内容 -->
                        <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                          <thead class="common_thead">
                            <tr>
                              <th width="120"><span class="">消息编号</span></th>
                              <th>消息标题</th>
                              <th width="120">发送时间</th>
                             <!--  <th width="60">状态</th> -->
                   
                              
                            </tr>
                          </thead>
                          <tbody class="common_tbody">
                       <?php if(!empty($row)){ 
                          foreach ($row as $k=>$v){
                       	?>
                            <tr>
                                <td><?php echo $v['id'] ?></td>
                                <td class="detail_link" style="text-align:left;"><a href="#show_notice" data="<?php echo $v['id']; ?>" class="show_notice" title="<?php echo $v['title']; ?>" ><?php if($v['isread']==1){echo '<span style=" color:#ccc;">[已读]</span>';}else{ echo '<span style="color:#f00;">[未读]<span>';}?> <?php echo  $str = mb_strimwidth($v['title'], 0,30, '...', 'utf8'); ?></a></td>
                                <td><?php echo $v['addtime'] ?></td>
                                <!-- <td></td> -->
                            </tr>
                          <?php } ?>
                         <?php }else{?>
                            <!-- 以下是没有订单时的状态 -->
                            <tr>
                                  <td class="order_list_active" colspan="5">
                                        <p class="cow-title">您最近没有点评记录！</p>
                                   </td>
                            </tr>
                          <?php }?>
                          </tbody>
                        </table>
                        <div class="pagination">
							<ul class="page"><?php if(!empty($row)){echo $this->page->create_page();}?></ul>
						</div>        
				</div>
            </div> 
             <!-- 弹出页面 -->
             <!-- 弹出制作中页面 --> 
	         <div id="order_plan" style="display: none; width:600px; height:550px;">
		       <!-- ajax 返回的数据 -->
	         </div>
             <!-- end -->   
      </div>
    </div>
    <!-- 右侧菜单结束 --> 
  </div>
</div>

    <!-- 弹出消息页面 --> 
    <div class="show_notice_box">
       <div id="show_notice"  style=" width:550px; height:400px;margin:0 auto;">
       <!-- ajax 返回的数据 -->
          <div style="padding:30px 30px 0px 15px;height:300px;overflow: auto;" >
       			<span style="font-size:18px;padding-top:20px;" id="title"></span>
				<p id="content" style="padding-top: 20px;">

				</p>
				<p id="file_url" style="padding-top: 20px;"></p>
		 </div>
		 <input type="button" id="edit_close_button" style="margin-left:220px;width:100px;height:30px;" value="关闭">
	   </div>
	</div>
      <!-- end --> 
      
<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
</body>
</html>

<script type="text/javascript">
$(function(){
	/* 系统消息 */
	try {
	//	$(".show_notice").fancybox();
		$(".show_notice").click(function() {
			$(".show_notice_box").show(true);			
			var id = $(this).attr('data');
			 $.post("<?php echo base_url('base/system/get_notice_content')?>", { id:id} , function(data) {
				 var data =eval("("+data+")"); 
				 $('#title').html(data.title);
 				 $('#content').html(data.content); 
 				 var str='';
 				 if(data.attachment !='' || data.attachment !='null'){
	 				 $str='附件：<a href="'+data.attachment+'">下载</a>';
 	 		     }
 				  $('#file_url').html($str); 
 				  
 			/* 	 $('.fancybox-close').click(function() {
 					location.reload();
 				}); */
			});
	     });	 
		} catch (err) {

		}
        //关闭消息的弹框
		$("#edit_close_button").click(function(){
			$(".show_message_box").hide(true);
			location.reload();
		})
})
	
</script>

