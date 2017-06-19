<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的定制单_会员中心-帮游旅行网</title>
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
                    <div class="bd cm_bd"> 
                        <!-- tab 切换制作中的内容 -->
                            <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                                <thead class="common_thead">
                                    <tr>
                                        <th width="4%"><span class="td_left">编号</span></th>
                                        <th width="9%">出行日期</th>
                                        <th width="8%">出发城市</th>
                                        <th width="8%">目的地</th>
                                        <th width="9.5%">希望人均预算</th>
                                        <th width="9.5%">希望出游时长</th>
                                        <th width="9.5%">出游总人数</th>
                                        <th width="8%">回复方案</th>
                                        <th width="7%">状态</th>
                                        <th width="7.5%">操作</th>
                                    </tr>
                                </thead>
                                <tbody class="common_tbody">
                                    <?php if(!empty($row)){ ?>
                                    <?php foreach ($row as $k=>$v){ ?>
                                    <tr>
                                        <td><?php echo $v['id'] ;?></td>
                                        <td><?php if(!empty($v['estimatedate'])&& $v['estimatedate']!=null && $v['estimatedate']!='0000-00-00'){ echo $v['estimatedate'];}else{echo $v['startdate']; }?></td>
                                        <td><?php echo $v['startplace']; ?></td>
                                        <td><?php if(isset($v['dest'])){foreach ($v['dest'] as $key=>$val){ if(($key+1)<count($v['dest'])){ echo $val['name'].'/';}else{echo $val['name'];}}} ?></td>
                                        <td style="color: #e83b37;"><span>￥</span><?php echo $v['budget']; ?><span>元</span></td>
                                        <td><?php echo $v['days']; ?>天</td>
                                        <td><?php echo $v['total_people']; ?></td>
                                        <td><?php echo $v['replies']; ?></td>
                                        <!-- -2、已取消，0、已过期，1、制作中，2、已确定，3、待选方案 ,-3已过期 -->
                                        <td><?php
											if($v['status']=='-2'){ echo '已取消';
											}elseif($v['status']=='-3'){echo '已过期';
											}elseif($v['status']=='0'){echo '已过期';
											}elseif ($v['status']=='1'){echo '制作中';
											}elseif ($v['status']=='2'){echo '已确定';
											}elseif($v['status']=='3'){echo '待选方案 ';
											}elseif($v['status']=='4'){ echo '已完成';}
										?></td>
                                        <td class="detail_link"><?php
										if($v['status']=='-2' || $v['status']=='-3' || $v['status']=='0'){
											echo '<a class="order_plan" href="#order_plan" data="'.$v['id'].'"  status= "'.$v['status'].'">查看</a>';
										}elseif ($v['status']=='1'){
											echo '<a class="order_plan" href="#order_plan" data="'.$v['id'].' "  status= "'.$v['status'].'" >查看</a><br/><a class="cancel" href="#" data="'.$v['id'].'">取消</a>';
										}elseif($v['status']=='2'){
											echo '<a class="order_plan" href="#order_plan" data="'.$v['id'].'"  status= "'.$v['status'].'" >查看</a><br>';
											//是否已转定制单,转了就可以下单
											if($v['line_id']>0){ 
                                                 // 将cj改为chujing,gn改为guonei,添加后缀.html
												// $url= in_array(1 ,explode(',',$v['overcity'])) ? '/cj/'.$v['line_id'] : '/gn/'.$v['line_id'];
                                                 $url= in_array(1 ,explode(',',$v['overcity'])) ? '/chujing/'.$v['line_id'].'.html' : '/guonei/'.$v['line_id'].'.html';
												echo '<a target="_blank" class="return_order" lineid="'.$v['line_id'].'" data="'.$v['id'].'" href="'.$url.'" target="_blank" >下单</a>';
											};
										}elseif($v['status']=='3'){
											echo '<a class="order_plan" href="#order_plan" data="'.$v['id'].'" status= "'.$v['status'].'">选方案</a>';
										}elseif($v['status']=='4'){
                                              // 将cj,gn改为line,添加后缀.html
											 // $url=in_array(1 ,explode(',',$v['overcity'])) ? '/cj/'.$v['line_id'] : '/gn/'.$v['line_id'];
                                            $url=in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html';
											if(empty($v['line_id'])){$v['line_id']=0;}
											echo '<a class="order_plan" href="#order_plan" data="'.$v['id'].'"  status= "'.$v['status'].'">查看</a><br/><a href="'.$url.'" target="_blank">定制线路</a>';										
										
										}
										?></td>
                                    </tr>
                                    <?php }?>
                                    <?php }else{?>
                                    <!-- 以下是没有订单时的状态 -->
                                    <tr>
                                        <td class="order_list_active" colspan="5"><p class="cow-title">您最近没有定制的记录！</p></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="pagination">
                                <ul class="page">
                                    <?php if(!empty($row)){echo $this->page->create_c_page();}?>
                                </ul>
                            </div>
                    </div>
                </div>
                <!-- 弹出页面 --> 
                <!-- 弹出制作中页面 -->
                <div id="order_plan" style="display: none; width:780px; height:700px;background:#eee; position:relative;"> 
                    <!-- ajax 返回的数据 --> 
                </div>
                <!-- end --> 
                <!-- 取消定制单弹框 -->
                <div id="cancle_custom_order" style="display: none; width:600px; height:400px;background:#fff;">
                    <div class="cancle_order_title">取消定制单</div>
                    <div class="cancle_order_content">
                        <form action="" method="post">
                            <ul class="cancle_reason">
                                <li>
                                    <input type="radio" name="" />
                                    <label>没有合适的定制方案</label>
                                </li>
                                <li>
                                    <input type="radio" name="" />
                                    <label>定制单信息填写有误，重新下单</label>
                                </li>
                                <li>
                                    <input type="radio" name="" />
                                    <label>行程有变，不能及时出行</label>
                                </li>
                                <li>
                                    <input type="radio" name="" />
                                    <label>其他原因</label>
                                </li>
                            </ul>
                            <div class="cancle_txt">
                                <textarea name="" class="cancle_introduce" placeholder="请填写您要表述的其他理由"></textarea>
                                <span class="font_num_title">已写<i>0</i>字</span> </div>
                            <div class="cancle_button clear">
                                <input type="submit" name="submit" value="提交" style="margin-right:80px;"/>
                                <input type="reset" name="reset" value="取消" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- 右侧菜单结束 --> 
    </div>
</div>
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
$(".cancle_introduce").keyup(function(){
	var content = $(this).val();
	var fontNum = content.length;
	$(".font_num_title i").html(fontNum);
});

$(function(){
/* 查看方案 */
try {
$(".order_plan").fancybox();
$(".order_plan").click(function() {
	var order_id = $(this).attr('data');
	var status = $(this).attr('status');
	/***********************判断是否登录**************************/
	$.post("<?php echo base_url('base/member/get_member_login')?>", { data:order_id} , function(flag) {
		if(flag>0){

			/***********************判断是否登录end**************************/
			//查看行程
			$.post("<?php echo base_url('base/member/scheme')?>", { data:order_id,status:status} , function(result) {
				if(result){
					$("#order_plan").html(result);
					/*查看回复方案*/
					$('.view').click(function(){
						
						/***********************判断是否登录*****************************/
						$.post("<?php echo base_url('base/member/get_member_login')?>", { data:1} , function(vflag) {
							if(vflag>0){ 
								var vflag0=1;
							}else{
								var vflag0=0;
								alert('您的登录账号停留时间已过期，请重新登录');
								window.location.href="/login";
								return false;
								
							}
						});
						/***********************判断是否登录end**************************/
						
						var id = $(this).attr('value');
						var status=$(this).attr('data-status');
						$.post("<?php echo base_url('base/member/reply_scheme')?>", { id:id,cu_id:order_id,status:status} , function(data) {
							$('#order_new_window_confirm').html(data);
							/* 选择此方案*/
							$("#sel_solution").click(function() {
								var ans_id=$(this).attr('answer');
								var expert_id=$(this).attr('expert');
								$(function(){
									$(".solution_hidden").show();
								})
								var c_id=$(this).attr('data');
							
								/*选方案*/
								$('.queren_btn').click(function() {
									$.post("<?php echo base_url('base/member/sel_scheme')?>", { ans_id:ans_id,cust_id:order_id,expert_id:expert_id} , function(data) {
										if(data){
											alert('已选择此方案');
											location.reload();
										}else{
											alert('选择方案失败');
											location.reload();
										}
									});
								});
							});
						});
						$('.order_new_window_confirm').show();
					});
					/* 选择此方案*/
					$(".sel_solution").click(function() {
						var ans_id=$(this).attr('answer');
						var expert_id=$(this).attr('expert');
						$(function(){
							$(".solution_hidden").show();
						})
						var c_id=$(this).attr('data');
						/*选方案*/
						$('.queren_btn').click(function() {
							$.post("<?php echo base_url('base/member/sel_scheme')?>", { ans_id:ans_id,cust_id:order_id,expert_id:expert_id} , function(data) {
								if(data){
									alert('已选择此方案');
									location.reload();
								}else{
									alert('选择方案失败');
									location.reload();
								}
							});
						});
					});
					//显示更多方案
					$("#show_more").click(function() {
						$(this).parent().hide();
						$('#show_more_list').show();
					});
				}else{
					$("#order_plan").html(result);
				}
			});
			
		}else{
			var flag0=0;
			alert('您的登录账号停留时间已过期，请重新登录');
			window.location.href="/login";
			return false;
		}
	});


});
} catch (err) {

}
	//取消定制单
	$('.cancel').click(function(){
		if (!confirm("确定要取消吗？")) {
			window.event.returnValue = false;
		}else{
			var c_id = $(this).attr('data');
			$.post("<?php echo base_url('base/member/cancel_custom')?>", { c_id:c_id} , function(data) {
				if(data){
					alert('取消成功！');
					location.reload();
				}else{
					alert('取消失败！');
					location.reload();
				}
			});
		}
	});
	//下单
	$('.return_order').click(function(){
		var lineid=$(this).attr('lineid');
		var c_id=$(this).attr('data');
		$.post("<?php echo base_url('base/member/update_custom')?>", { c_id:c_id,lineid:lineid} , function(data) { });
	});
});
</script>