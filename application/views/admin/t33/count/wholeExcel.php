<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"  />
<title>平台管理系统</title>
<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/assets/ht/js/jquery-1.11.1.min.js"></script>
<style>
	.detail-add-but{
		margin-left: 120px;
		border: 1px solid rgb(204, 204, 204);
		width: 45px;
		text-align: center;
		border-radius: 3px;
		padding: 3px 0px;
		cursor: pointer;
	}
	#itab{
		position: fixed;
		top: 0px;
		z-index: 100;
		left: 20px;
		width: 95%;
		background: #fff;
	}
	.export-excel{
		width: 75px;
		float: right;
		border: 1px solid #ccc;
		height: 27px;
		text-align: center;
		line-height: 26px;
		border-radius: 3px;
		margin-top: 4px;
		cursor: pointer;
	}
	.export-excel:hover{
		background: #3EAFE0;
		color: #fff;
	}
	.chioce-list{
		margin: 25px 0px 0px 50px;
		border: 1px solid #ccc;
		position: absolute;
		width: 288px;
		padding: 10px;
		background: #fff;
		display:none;
	}
	.chioce-list li{
		float: left;
		width: 33%;
	}
	.chioce-list label{
		cursor:pointer;
	}
	.chioce-list .last-li{
		float: none;
		text-align: center;
		width: 100%;
		clear: both;
	}
	.last-li button{
		border: 1px solid #ccc;
		background: #fff;
		padding: 2px 4px;
		border-radius: 3px;
		cursor: pointer;
		margin-top: 10px;
	}
</style>
</head>
<body>
	
    <div class="page-body" id="bodyMsg" style="height: 100%;">
        <div class="order_detail" style="margin-top:48px;">
            
            <div class="table_con">
                <div class="itab" id="itab">
                    <ul id="tab-nav">
                        <li data-val="1"><a href="###" class="active">整体统计</a></li>
                        <li data-val="2"><a href="###">按销售人员统计</a></li>
                    </ul>
                    <div class="export-excel">导出excel</div>
                </div>
                <div class="tab_content">
                	<form class="search_form" style="z-index: 10;" method="post" id="search-form" action="">
                    	<div class="search_form_box clear" style="display:none;">
                        	<div class="search_group" >
                            	<label>营销人员</label>
                                <input type="text" name="name" id="chioce-expert" class="search_input" readonly="readonly"/>
                                <input type="hidden" name="ids">
                                <ul class="chioce-list">
                                	<?php foreach($expertAll as $v):?>
                                	<li>
                                		<label><input type="checkbox" name="expertid[]" value="<?php echo $v['expert_id']?>"><?php echo $v['expert_name']?></label>
                                	</li>
                                	<?php endforeach;?>
                                	<li class="last-li"><button>确认</button></li>
                                </ul>
                            </div>
                            <div class="search_group">
                            	<input type="submit" name="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    
                    <div class="table_list" style="display:block;" id="all-list-1">
                    	<table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>部门</th>
                                    <th>团号</th>
                                    <th>人数</th>
                                    <th>专线名</th>
                                </tr>
                            </thead>
                           
                            <tbody class="table-body">
                            	<?php 
                            		$count = 0;
                            		foreach($allData as $v):
                            			$num = $v['dingnum']+$v['childnum']+$v['childnobednum']+$v['oldnum'];
                            			$count = $count + $num;
                            	?>
                                <tr>
                                	<td><?php echo $v['depart_name']?></td>
                                	<td class="a_team" data-id="<?php echo $v['item_code']?>">
                                		<a href="javascript:void(0);"><?php echo $v['item_code']?></a>
                                	</td>
                                	<td><?php echo $num?></td>
                                	<td><?php echo $v['linename']?></td>
                                </tr>
								<?php endforeach;?>
								<tr>
                                	<td>总计</td>
                                	<td></td>
                                	<td><?php echo $count?></td>
                                	<td></td>
                                </tr>
                              </tbody>
                        </table>
                    
                    </div>
                    <div class="table_list" id="all-list-2" style="display:none;">
                    	<table class="table table-bordered table_hover">
                            <tbody class="table-body expert-info-list">
                            	<?php 
                            		$i = 0;
                            		foreach($expertData as $k=>$v):
                            		$num = 0;
                            	?>
                            	<?php if ($i > 0):?>
                            		<tr class="expert-info-<?php echo $k?>" style="height:29px;">
                            			<td colspan="4"></td>
                            		</tr>
                            	<?php endif;?>
                            	<tr class="expert-info-<?php echo $k?>">
                            		<td colspan="4"><?php echo $v['title']?></td>
                            	</tr>
	                            	<?php 
	                            		foreach($v['lower'] as $i):
	                            		$num = $num+$i['num'];
	                            	?>
	                                <tr class="expert-info-<?php echo $k?>">
	                                	<td><?php echo $i['name']?></td>
	                                	<td class="a_team" data-id="<?php echo $i['item_code']?>">
	                                		<a href="javascript:void(0);"><?php echo $i['item_code']?></a>
	                                	</td>
	                                	<td><?php echo $i['num']?></td>
	                                	<td><?php echo $i['linename']?></td>
	                                </tr>
	                                <?php endforeach;?>
                                <tr class="expert-info-<?php echo $k?>">
                                	<td>总计</td>
                                	<td></td>
                                	<td><?php echo $num;?></td>
                                	<td></td>
                                </tr>
								<?php $i++; endforeach;?>
								
                              </tbody>
                        </table>
                    
                    </div>
                </div>
            </div>
            
        </div>
	</div>
	
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
<script>
$("body").on("click",".a_team",function(){
	var id=$(this).attr("data-id");
    var title=id+"团号下的所有订单";
	window.top.openWin({
	  type: 2,
	  area: ['78%', '80%'],
	  title :title,
	  fix: true, //不固定
	  maxmin: true,
	  content: "<?php echo base_url('admin/t33/sys/approve/team_order');?>"+"/"+id
	});
});

var time = "<?php echo $time;?>";
var departId = <?php echo $departId;?>;
var name = "<?php echo $name;?>";
//导出excel
$('.export-excel').click(function(){
	var type = $('#tab-nav').find('.active').parent().attr('data-val');
	if (type == 1) {
		url = '/admin/t33/sys/count/depart_p_count/exportExcelAll';
		data = {time:time,departId:departId,name:name};
	} else {
		url = '/admin/t33/sys/count/depart_p_count/exportExcelExpert';
		data = {time:time,departId:departId,name:name,ids:$('input[name=ids]').val()};
	}
	
	$.ajax({
		url:url,
		data:data,
		type:'post',
		dataType:'json',
		success:function(result) {
			if (result.code == 2000) {
				window.location.href=result.msg;
			} else {
				layer.alert(result.msg, {icon: 2});
			}
		}
	});
	
})


$('#tab-nav').find('li').click(function(){
	if (!$(this).find('a').hasClass('active')) {
		var val = $(this).attr('data-val');
		$(this).find('a').addClass('active').parent().siblings().find('a').removeClass('active');
		if (val == 1) {
			$('#all-list-1').show();
			$('#all-list-2').hide();
			$('.search_form_box').hide();
		} else {
			$('#all-list-2').show();
			$('#all-list-1').hide();
			$('.search_form_box').show();
		}
	}
})

//选择管家
$('.last-li').find('button').click(function(){
	var name = '';
	var ids = '';
	$.each($('.chioce-list').find('li').find('label'),function(){
		if ($(this).find('input').attr('checked')) {
			name = $(this).text()+','+name;
			ids = $(this).find('input').val()+','+ids;
		}
	})
	$('input[name=ids]').val(ids);
	$('#chioce-expert').val(name);
	$('.chioce-list').hide();
})

$('#chioce-expert').click(function(){
	if ($('.chioce-list').find('li').length > 1) {
		$('.chioce-list').show();
	}
})

$('#search-form').submit(function(){
	if ($('#chioce-expert').val().length) {
		$('.expert-info-list').find('tr').hide();
		var idsArr = $('input[name=ids]').val().split(',');
		$.each(idsArr ,function(k ,v) {
			console.log(v);
			$('.expert-info-'+v).show();
		})
	} else {
		$('.expert-info-list').find('tr').show();
	}
	return false;
})
	
</script>
</body>
</html>
