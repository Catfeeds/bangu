<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style>
		#bodyMsg{padding: 10px;}
		
		.tab-body{border-top:1px solid #ccc;border-left:1px solid #ccc;border-bottom:1px solid #ccc;width:100%;}
		.tab-body thead tr{height:40px;}
		.tab-body thead tr th{border-right:1px solid #ccc;font-size: 13px;}
		.title-people{display: inline-block;width: 20%;float: left;border-right: 1px solid #ccc;height: 40px;line-height: 40px;}
		.title-content{display: inline-block;width: 55%;line-height: 40px;}
		.title-ident{  display: inline-block;float: left;width: 25%;border-right: 1px solid #ccc;line-height: 40px;}
		.table-body tr{border-top: 1px solid #ccc;font-size: 13px;text-align: center;}
		.table-body tr td{border-right: 1px solid #ccc;}
		
		.row-block{border-bottom: 1px solid #ccc;}
		.row-content{border-bottom: 1px solid #ccc;}
		.row-con-title{display: inline-block;width: 26.8%;float: left;border-right: 1px solid #ccc;}
		.row-con-con{display: inline-block;width: 73%;padding:5px;text-align: left;}
		
		.row-block-ident{display: inline-block;float: left;width: 25%;border-right: 1px solid #ccc;}
		.row-block-con{width:75%;margin-left:25%;}
		
		.width10{width:10%;}
		.width20{width:20%;}
		.width70{width:70%;}
    </style>
</head>
<body>
    <div class="page-body" id="bodyMsg">
    	<table class="tab-body">
    		<thead>
    			<tr>
    				<th class="width10">消息步骤</th>
    				<th class="width20">步骤说明</th>
    				<th class="width70">
    					<span class="title-ident">触发条件</span>
    					<span class="title-people">接收人群</span>
    					<span class="title-content">消息内容</span>
    				</th>
    			</tr>
    		</thead>
    		<?php foreach($stepArr as $val):?>
    		<tbody class="table-body">
    			<tr>
    				<td><?php echo $titleArr[$val['step']]?></td>
    				<td><?php echo $val['description']?></td>
    				<td>
    					<?php if (!empty($val['through'])):?>
    					<div class="row-block">
    						<div class="row-block-ident">上一步审核通过发送</div>
    						<div class="row-block-con">
    							<?php foreach($val['through'] as $v):?>
	    						<div class="row-content">
		    						<div class="row-con-title"><?php echo $typeArr[$v['user_type']]?></div>
		    						<div class="row-con-con"><?php echo $v['content']?></div>
		    					</div>
		    					<?php endforeach;?>
    						</div>
    					</div>
    					<?php endif;?>
    					<?php if (!empty($val['ordinary'])):?>
    					<div class="row-block">
    						<div class="row-block-ident"></div>
    						<div class="row-block-con">
    							<?php foreach($val['ordinary'] as $v):?>
	    						<div class="row-content">
		    						<div class="row-con-title"><?php echo $typeArr[$v['user_type']]?></div>
		    						<div class="row-con-con"><?php echo $v['content']?></div>
		    					</div>
		    					<?php endforeach;?>
    						</div>
    					</div>
    					<?php endif;?>
    					<?php if (!empty($val['refuse'])):?>
    					<div class="row-block">
    						<div class="row-block-ident">上一步审核拒绝发送</div>
    						<div class="row-block-con">
    							<?php foreach($val['refuse'] as $v):?>
	    						<div class="row-content">
		    						<div class="row-con-title"><?php echo $typeArr[$v['user_type']]?></div>
		    						<div class="row-con-con"><?php echo $v['content']?></div>
		    					</div>
		    					<?php endforeach;?>
    						</div>
    					</div>
    					<?php endif;?>
    				</td>
    			</tr>
    		</tbody>
    		<?php endforeach;?>
    	</table>
    </div>
<script>
$('.row-content').each(function(){
	var height = $(this).height();
	$(this).find('.row-con-title').css('line-height',height+'px');
})
$('.table-body').each(function(){
	$(this).find('.row-block').last().css({'border-bottom':'none'});
})
$('.row-block').each(function(){
	$(this).find('.row-content').last().css({'border-bottom':'none'});
	var height = $(this).find('.row-block-con').height();
	$(this).find('.row-block-ident').css({'line-height':height+'px','height':height+'px'});
})
</script>
</body>
</html>


