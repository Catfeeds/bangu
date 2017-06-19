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
		border: none;
	}
	.export-excel{
		width: 75px;
		float: left;
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
	
    <div class="page-body" id="bodyMsg">
        <div class="order_detail">
            
            <div class="table_con">
                <div class="itab" id="itab">
                    <div class="export-excel">导出excel</div>
                </div>
                <div class="tab_content">
                    
                    <div class="table_list" style="display:block;" id="all-list-1">
                    	<table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th>营业部</th>
                                    <th>成团人数</th>
                                    <th>营业额</th>
                                </tr>
                            </thead>
                           
                            <tbody class="table-body">
                            	<?php 
                            		foreach($dataArr as $v):
                            	?>
                                <tr>
                                	<td><?php echo $v['depart_name']?></td>
                                	<td><?php echo $v['num']?></td>
                                	<td><?php echo $v['price']?></td>
                                </tr>
								<?php endforeach;?>
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
var year = <?php echo $year;?>;
var ids = "<?php echo $ids?>";
$('.export-excel').click(function(){
	$.ajax({
		url:'/admin/a/statistics/year_all_count/exportExcel',
		data:{year:year,ids:ids},
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
</script>
</body>
</html>
