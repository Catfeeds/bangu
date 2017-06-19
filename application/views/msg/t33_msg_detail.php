<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style>
		.page-body{padding: 20px !important;}
		.send-title{text-align:center;font-weight: 600;}
		.send-content{margin: 10px 0px 20px 0px;}
		.but-list{text-align: center;}
		.but-list a{font-weight: 600;padding: 3px 5px;border: 1px solid #ccc;display: inline-block;margin-top: 20px;border-radius: 3px;}
	</style>
</head>
<body>
    <div class="page-body" id="bodyMsg">
    	<div class="send-body">
    		<p class="send-title"><?php echo $sendArr['title']?></p>
    		<p class="send-content"><?php echo $sendArr['content']?></p>
    	</div>
        <div class="table_list" id="dataTable">
        	<?php if (!empty($sendStepArr)):?>
        	<table class="table table-bordered table_hover">
        		<thead class="">
        			<tr>
        				<th style="width:60px;text-align:center;">步骤</th>
        				<th style="width:150px;text-align:center;">步骤 说明</th>
        				<th style="width:120px;text-align:center;">审核日期</th>
        				<th style="width:100px;text-align:center;">审核人</th>
        				<th style="width:100px;text-align:center;">状态</th>
        			</tr>
        		</thead>
        		<tbody class="">
        			<?php $count = count($sendStepArr);?>
        			<?php 
        				$i = 0;
        				foreach($sendStepArr as $v):
        					$i ++;
        			?>
        			<tr>
        				<td style="text-align:center"><?php echo $v['step']?></td>
        				<td style="text-align:center"><?php echo $v['description']?></td>
        				<td style="text-align:center"><?php echo $v['modtime']?></td>
        				<td style="text-align:center"><?php echo $v['name']?></td>
        				<td style="text-align:center">
        				<?php 
        					if ($v['status'] == 0) {
        						echo '待审核';
        					} elseif ($v['status'] ==1) {
        						echo '待审核';
        					} elseif ($v['status'] ==2) {
        						echo '<span style="color:#69B716;">已通过</span>';
        					} elseif ($v['status'] ==3) {
        						echo '<span style="color:red;">已拒绝</span>';
        					}
        				?>
        				</td>
        			</tr>
        			<?php if ($v['status'] == 3){ break;}?>
        			<?php endforeach;?>
        		</tbody>
        	</table>
        	<?php endif;?>
        </div>
        <?php if (!empty($sendArr['url'])):?>
        <div class="but-list">
        	<a href="<?php echo $sendArr['url']?>">前往操作页面</a>
        </div>
        <?php endif;?>
	</div>

<script src="<?php echo base_url() ;?>assets/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/assets/ht/js/base.js"></script>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
</script>
</html>


