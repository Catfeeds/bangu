<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管家收藏_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>"rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"href="<?php echo base_url('static/css/user/user.css');?>"rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
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
			<div class="nav_right">
				<div class="user_title">定制团线路</div>
				<div class="consulting_warp activist_warp">
					<div class="consulting_tab">
						<div class="hd cm_hd clear">
							<ul>
								<li
									<?php if(!empty($tyle) && $tyle=='nodid'){ echo 'class="on"';} ?>>定制团线路（<span
										class="link_green"><?php if(isset($row)){echo count($row) ;}else{ echo 0;}?></span>）
								</li>
								
							</ul>
						</div>
						<div class="bd cm_bd">                                            
                            <div class="keeper_coll">
                             <ul>
                                 <li>编号</li>
                                 <li>管家名称</li>
                                 <li>管家级别</li>
                                 <li style="width:400px;">定制线路</li>
                                 <li>推荐时间</li>
                             </ul>
                             <?php if(!empty($row)){ ?>
                                      <?php foreach ($row as $k=>$v){ ?>
                             <ul>
                                 <li><?php echo ($k+1); ?></li>
                               <!-- 将guanj改为guanjia 魏勇编辑-->
                                 <li title="管家名称"><a target="_blank" href="/guanjia/<?php echo $v['expert_id']; ?>" style="text-decoration:underline;"><?php echo  $v['realname']; ?></a></li>
                                 <li><?php 
                                       if($v['grade']==1){	 echo '管家';}elseif($v['grade']==2){ echo '初级专家';}elseif($v['grade']==3){ echo '中级专家';}elseif($v['grade']==4){echo '高级专家';} ?>
                                 </li>
                                 <!-- 将cj,gn改为line,添加后缀.html-->
                                 <li  style="width:400px;"><a style="color:#005ea7;" target="_blank" href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['lineid'].'.html' : '/line/'.$v['lineid'].'.html'; ?>"><?php echo $v['linename']; ?></a></li>
                                 <li><?php echo $v['addtime']; ?></li>
                             </ul>
                             <?php }?>
						     <?php }else{
						          echo '您最近没有该会员的定制团线路！'; 
  							  }?>
                             </div>
                             <div class="pagination">
								 <ul class="page"><?php if(!empty($row)){echo $this->page->create_c_page();}?></ul>
							 </div>
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
function up_expert(obj){
	alert('该管家不在线!');
	return false;
}
</script>

