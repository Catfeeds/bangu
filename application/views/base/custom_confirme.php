<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的定制单</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.SuperSlide.2.1.1.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>

<link type="text/css"href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>

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
      <div class="user_title">我的定制单</div>
      <div class="consulting_warp">
      		<div class="consulting_tab">
            	<div class="hd cm_hd clear">
                    <ul><a href="<?php echo base_url('base/member/mycustom?tyle=onmake');?>"><li>制作中</li></a>
                   <a href="<?php echo base_url('base/member/mycustom?tyle=confirme');?>"> <li class="on"> 已确认</li></a>
                    <a href="<?php echo base_url('base/member/mycustom?tyle=canc');?>"><li>已取消</li></a></ul>
				</div>
				<div class="bd cm_bd">
                    <!-- tab 切换制作中的内容 -->
                    <ul>
                        <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                          <thead class="common_thead">
                            <tr>
                              <th width="4%"><span class="td_left">编号</span></th>
                              <th width="8%">出游时间</th>
                              <th width="10%">出发城市</th>
                              <th width="10%">目的地</th>
                              <th width="10%">人均预算</th>
                              <th width="5%">游玩天数</th>
                              <th width="5%">出游人数</th>
                              <th width="12%">服务要求</th>
                              <th width="12%">其他要求</th>
                              <th width="5%">抢单数</th>
                              <th width="7%">回复方案</th>
                              <th width="5%">操作</th>
                              
                            </tr>
                          </thead>
                          <tbody class="common_tbody">
                          <?php if(!empty($row1)){ ?>
                          <?php foreach ($row1 as $key=>$val){ ?>
                            <tr>
                                <td><?php echo $val['id'] ;?></td>
                                <td><?php echo $val['startdate'] ;?></td>
                                <td><?php echo $val['startplace']; ?></td>
                                <td><?php echo $val['endplace']; ?></td>
                                <td style="color: #e83b37;"><span>￥</span><?php echo $val['budget']; ?><span>/无</span></td>
                                <td><?php echo $val['days']; ?></td>
                                <td><?php echo $val['people']; ?></td>
                                <td><?php  echo  $str = mb_strimwidth($val['service_range'], 0,15, '...', 'utf8');?></td>
                                <td><?php echo  $str = mb_strimwidth($val['other_service'], 0,15, '...', 'utf8'); ?></td>
                                <td><?php echo $val['rob']; ?></td>
                                <td><?php echo $val['replies']; ?>条</td>
                                <td class="detail_link">
                                      <a class="order_plan" href="#order_plan" data="<?php echo $val['id'] ;?>">查看方案</a><br/>
                                </td>
                            </tr>
                            <?php }?>
                            <?php }else{?> 
                            <!-- 以下是没有订单时的状态 -->
                            <tr>
                                  <td class="order_list_active" colspan="5">
                                        <p class="cow-title">您最近没有记录！</p>
                                   </td>
                            </tr>
                            <?php }?>
                          </tbody>
                        </table>
                        <div class="pagination">
							<ul class="page"><?php if(!empty($row1)){echo $this->page->create_page();}?></ul>
						</div>
                    </ul>
				</div>
            </div> 
             <!-- 弹出页面 -->
             <!-- 弹出制作中页面 --> 
	         <div id="order_plan" style="display: none;  width:600px; height:550px;">
		      
	         </div>
             <!-- end -->
         

      </div>
    </div>
    <!-- 右侧菜单结束 --> 
  </div>
</div>
<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>
</body>
</html>

<script type="text/javascript">
$(function(){
	/* 查看方案 */
	try {
		$(".order_plan").fancybox();
		$(".order_plan").click(function() {		
			var order_id = $(this).attr('data');
			 $.post("<?php echo base_url('base/member/scheme')?>", { data:order_id} , function(result) {
					if(result){									
						 $("#order_plan").html(result);	 			
						 //查看回复方案							 
						 $('.view').click(function(){				
							 var id = $(this).attr('value');
							 $.post("<?php echo base_url('base/member/reply_scheme')?>", { id:id,cu_id:order_id} , function(data) {	
								 $('#order_new_window_confirm').html(data);					 
							 });	 
							 $('.order_new_window_confirm').show();
						 }); 
						 $('.close_dd').click(function(){
                                 alert(111);
							 });
						               
					}else{
						 $("#order_plan").html(result); 	
					} 
			 });	
	     });	 
		} catch (err) {

		}
})

	
</script>

