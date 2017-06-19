<!doctype html>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的游记_会员中心-帮游旅行网</title>
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
      <div class="consulting_warp">
      		<div class="consulting_tab">
             	<div class="hd cm_hd clear">
                    <ul><li><a href="#">我的游记</a></li>
                          <a href="/base/travel/write_travels" target="_blank"><span style="float:right;"> 写游记</span></a>
                     </ul>
				</div>
				<div class="bd cm_bd">
                    <!-- tab 切换制作中的内容 --> 
                        <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                          <thead class="common_thead">
                            <tr>
                              <th width="10%"><span class="td_left">发表时间</span></th>
                              <th width="20%">标题 </th>
                              <th width="30%">订单线路 </th>
                              <th width="10%">浏览量</th>
                              <th width="10%">评论量 </th>
                              <th width="20%">操作</th>
                            </tr>
                          </thead>
                          <tbody class="common_tbody">
                          <?php if(!empty($row)){
                            foreach ($row as $k=>$v){
                          	?>
                            <tr>
                                <td><?php  echo  date('Y-m-d', strtotime($v['addtime'])) ; ?></td>
                                <td  class="cg_a" title="<?php if($v['status']==1){ echo $v['title'];}?>"><?php if($v['status']==0){ echo '<a target="_blank" href="/yj/'.$v['id'].'-0">【草稿】</a>';}elseif($v['status']==1){ echo  '<a target="_blank" href="/yj/'.$v['id'].'-0">'.$str = mb_strimwidth($v['title'], 0,30, '...', 'utf8').'</a>';} ?></td>
                                <!-- 将cj,gn改为line,添加后缀.html-->
                                <td class="product_title"><a  target="_blank" href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html'; ?>"
									target="_blank" title="<?php echo $v['linename']; ?>"><?php echo $str = mb_strimwidth($v['linename'], 0,48, '...', 'utf8');?></a></td>
                                <td><?php echo $v['shownum']; ?></td>
                                <td ><?php echo $v['comment_count']; ?></td>
                                <td class="detail_link">
                                    <a href="/base/travel/release_travels_<?php echo $v['id']; ?>.html" target="_blank" >编辑</a>&nbsp;&nbsp;
                                      <a href="" class="del_travel" data-val="<?php echo $v['id']; ?>"> 删除</a><br>
                                </td>

                            </tr>
                            <?php } }else{?>
                            <!-- 以下是没有订单时的状态 -->
                            <tr>
                                  <td class="order_list_active" colspan="5">
                                        <p class="cow-title">您最近没有游记记录！</p>
                                   </td>
                            </tr>
                           <?php }?>
                          </tbody>
                        </table>
                        <div class="pagination">
							<ul class="page"><?php if(!empty($row)){echo $this->page->create_c_page();}?></ul>
						</div> 
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

<!-- 尾部 -->
	<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">
                          	
$(".mc dl dt").removeClass("cur");	
$("#user_nav_2 dt").addClass("cur");

$('.del_travel').click(function(){
	var id=$(this).attr('data-val');
	if (confirm("是否要删除？")) {
		$.post("<?php echo base_url()?>base/travel/del_traval", {id:id} , function(result) {
			result = eval('('+result+')');
	          if(result.status==1){
	        	   alert(result.msg);
	        	   location.reload();
                }else{
              	   alert(result.msg);
              	   location.reload();
                }
		});
		return false;
   }

})

</script>