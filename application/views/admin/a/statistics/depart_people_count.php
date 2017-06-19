<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"  />
	<title>测试模板</title>
	<link href="/assets/ht/css/base.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
		.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
		.yourclass .layui-layer-content{ padding:20px;}
		/*详情 start*/
		.order_detail{margin-bottom: 20px;}
		.but-list{
			text-align: right;
			margin-top: 10px;
		}
		.but-list button{
			background: rgb(255, 255, 255) none repeat scroll 0% 0%;
			border: 1px solid rgb(204, 204, 204);
			padding: 3px;
			border-radius: 3px;
			cursor: pointer;
			margin-left: 10px;
		}
		.but-list button:hover{background: #2dc3e8;color: #fff;}
		.table_td_border > tbody > tr > td {
		    width: 40%;
		}
		.table thead > tr > th{
			border-right: 1px solid #ccc;
		}
		.tionRela span{position:absolute; top:0; left:0}
		.tionRela{position: relative; padding-left:60px;margin-top: 10px;}
		/*详情 end*/
		
		/*选择年月没有日 */
	.hideBody{ width:100%; height:100%; position: absolute; top:0; left:0; right:0; bottom:0; display:none;}
	.actoelnInput{ padding-left:10px;}
	.actoeln{ position:relative; display: inline-block; float: left;}
	.staticYear_hidden{ width:212px; background: #f9f9f9; border:1px solid #ccc; overflow:hidden; display:none; padding-bottom:5px; position: absolute; z-index:10;}
	.actoelnInput{ width:100px; height:24px; line-height:24px;}
	.siblclert{ width:150px; background:#fff; height:30px; overflow:hidden; margin: 0 auto; float:left; position: relative;}
	.siblclert ul { overflow:hidden; width:150px; margin: 5px auto; position: absolute; top:0;}
	.siblclert ul li{cursor:pointer; float:left; border:1px solid #ccc; width:50px; text-align:center; height:24px; line-height:24px;}
	.siblcCon{ margin:0 auto}
	.siblcCon ul { overflow: hidden; width:200px; margin: 0 auto; position:relative; left:-1px;}
	.siblcCon ul li{cursor:pointer; float:left; border:1px solid #ccc; width:50px; text-align:center; background:#fff; height:24px; line-height:24px;}
	.sib_left{ margin-left:3px !important;cursor:pointer;}
	.sib_left, .sib_right{ cursor:pointer; width:24px; background:#fff; border:1px solid #ccc; margin:5px 2px; float:left; height:24px; line-height:20px; text-align:center;}
	.blclertBox{ overflow:hidden;}
	.siblclert ul li.on{ background:#ccc;}
	
	.search-select{width: 60px;height: 25px;}
	.search-year,.search-quarter,.search-month{display:none;}
	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">营业部人头统计</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="get" id="search-condition" action="/admin/a/statistics/depart_people_count/index">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>统计方式</label>
                                <select class="search-select" name="type" >
                                	<option value="1" <?php if($type==1) {echo 'selected="selected"';}?>>月</option>
                                	<option value="2" <?php if($type==2) {echo 'selected="selected"';}?>>季</option>
                                	<option value="3" <?php if($type==3) {echo 'selected="selected"';}?>>年</option>
                                </select>
                            </div>
                            <!-- 月份选择 -->
                           	<div class="actoeln search-month" <?php if ($type == 1) { echo 'style="display:block;"'; } ?>>
                            	<input type="text" class="staticYear actoelnInput" readonly="readonly" value="<?php echo $starttime?>" name="starttime" placeholder="开始时间">
                                <input type="text" class="endingYear actoelnInput" readonly="readonly" value="<?php echo $endtime?>" name="endtime" placeholder="结束时间">
                                <div class="staticYear_hidden">
                                    <div class="blclertBox">
                                        <div class="sib_left"><</div>
                                        <div class="siblclert" id="yearLIst">
                                            <ul>
                                                
                                            </ul>
                                        </div>
                                        <div class="sib_Right">></div>
                                    </div>
                                    <div class="siblcCon">
                                        <ul>
                                            <li>1</li><li>2</li><li>3</li><li>4</li>
                                            <li>5</li><li>6</li><li>7</li><li>8</li>
                                            <li>9</li><li>10</li><li>11</li><li>12</li>
                                        </ul>
                                    </div>
                            	</div>
                            </div>
                            <!-- 季度选择 -->
                            <div class="actoeln search-quarter"  <?php if ($type == 2) { echo 'style="display:block;"'; } ?>>
                            	<?php 
                            		$year = date('Y' ,time());
                            		$options = '<option value="0">请选择</option>';
                            		
                            		$j = $year+1;
                            		$i = $year -10;
                            		for($j ;$j > $i ;$j--) {
                            			$options .= '<option value="'.$j.'-4">四季度/'.$j.'</option>';
                            			$options .= '<option value="'.$j.'-3">三季度/'.$j.'</option>';
                            			$options .= '<option value="'.$j.'-2">二季度/'.$j.'</option>';
                            			$options .= '<option value="'.$j.'-1">一季度/'.$j.'</option>';
                            		}
                            	?>
                            	<select class="search-select" style="width:100px;" name="start_quarter" >
                            		<?php echo $options;?>
                            	</select>
                            	<select class="search-select" style="width:100px;" name="end_quarter">
                            		<?php echo $options;?>
                            	</select>
                            </div>
                            
                            <!-- 年份选择 -->
                            <div class="actoeln search-year" <?php if ($type == 3) { echo 'style="display:block;"'; } ?>>
                            	<?php 
                            		$year = date('Y' ,time());
                            		$i = $year -10;
                            		$j = $year + 1;
                            		$options = '<option value="0">请选择</option>';
                            		for($j ;$j > $i ;$j--) {
                            			$options .= '<option value="'.$j.'">'.$j.'</option>';
                            		}
                            	?>
                            	<select class="search-select" style="width:100px;" name="start_year">
                            		<?php echo $options;?>
                            	</select>
                            	<select class="search-select" style="width:100px;" name="end_year">
                            		<?php echo $options;?>
                            	</select>
                            </div>
                            
                            <div class="search_group" style="margin-left:15px;">
                            	<label>营业部</label>
                                <input type="text" name="depart_name" value="<?php echo $name?>" placeholder="营业部名称">
                            </div>
                            
                            <div class="search_group">
                            	<input type="submit" class="search_button" value="搜索"/>
                            </div>
                    	</div>
                    </form>
                    
                    <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th rowspan="2" style="line-height: 55px;">营业部名称</th>
                                    <?php 
                                    	foreach($titleArr as $v)
                                    	{
                                    		echo '<th colspan="3">'.$v['title'].'</th>';
                                    	}
                                    ?>
                                    <th></th>
                                </tr>
                                <tr>
                                	<?php 
										foreach($titleArr as $v)
                                    	{
                                    		foreach($v['key'] as $k=>$i) {
                                    			echo '<th>'.$k.'</th>';
                                    		}
                                    	}
                                	?>
                                    <th>总计</th><!-- 此列单独计算 -->
                                </tr>
                            </thead>
                            <tbody class="table-body">
                            	<?php foreach($statisticsArr as $v):?>
                                <tr>
                                	<td><?php echo $v['depart_name']?></td>
                                	<?php 
                                		foreach($titleArr as $val){
                                			foreach($val['key'] as $k) {
                                				echo '<td class="depart-num">'.$v[$k].'</td>';
                                			}
                                		}
                                	?>
                                    <td>352</td> 
                                </tr>
								<?php endforeach;?>
                              </tbody>  
                              <?php if (!empty($statisticsArr)):?>
                              <tbody>
                                <!-- 单独计算 -->
                                 <tr>
                                	<td>总计</td>
                                    <?php 
                                		$i = 0;
                                		$column = count($titleArr);
                                		for($i ;$i<$column ;$i++) {
                                			echo '<td class="column-count"></td>';
                                			echo '<td class="column-count"></td>';
                                			echo '<td class="column-count"></td>';
                                		}
                                	?>
                                    <td class="column-count">3520</td> 
                                </tr>
                            </tbody>
                            <?php endif;?>
                        </table>
                        <?php if (empty($statisticsArr)):?>
	                   		<div style="height: 200px; line-height: 200px;display: block;" class="data-empty">木有数据哟！换个条件试试</div>
	                    <?php endif;?>
                        <ul class="page-list">
                        <?php echo $this ->page ->create_page();?>
                        </ul>
                </div>
            </div> 
        </div>
    </div>
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
var start_year = <?php echo empty($start_year) ? 0 : $start_year;?>;
var end_year = <?php echo empty($end_year) ? 0 : $end_year;?>;
var start_quarter = "<?php echo empty($start_quarter) ? 0 : $start_quarter;?>";
var end_quarter = "<?php echo empty($end_quarter) ? 0 : $end_quarter;?>";
$('select[name=start_year]').val(start_year);
$('select[name=end_year]').val(end_year);
$('select[name=start_quarter]').val(start_quarter);
$('select[name=end_quarter]').val(end_quarter);

$('.page-list').find('li').click(function(){
	layer.load(2);
})
$('input[type=submit]').click(function(){
	layer.load(2);
})

//最后一列总计
$.each($('.table-body').find('tr'),function(){
	var num = 0;
	$.each($(this).find('.depart-num'),function(){
		num = num + $(this).html()*1;
	})
	$(this).find('td').last().html(num);
})

//最后一行总计
$.each($('.column-count'),function(){
	var num = 0;
	var index = $(this).index();
	$.each($('.table-body').find('tr') ,function() {
		num = $(this).find('td').eq(index).html()*1 + num;
	})
	$(this).html(num);
})

//却换时间段搜索类型
$('select[name=type]').change(function(){
	var val = $(this).val();
	if (val == 1) {
		$('.search-month').show();
		$('.search-year,.search-quarter').hide();
	} else if (val == 2) {
		$('.search-quarter').show();
		$('.search-year,.search-month').hide();
	} else if (val == 3) {
		$('.search-year').show();
		$('.search-month,.search-quarter').hide();
	}
})

	window.onload =function(){
			//初始化
			
			var oYear =<?php echo date('Y' ,time());?>;
			
			var str = "";
			for(var i = 1; i <= 11 ; i ++){
				var year = oYear-10+i;
					if(i==10){
						str+="<li class='on'>"+year+"</li>";
					} else {
						str+="<li>"+year+"</li>";
					}
				}
			$("body").append("<div class='hideBody'></div>");
			$("#yearLIst ul").append(str);
			var Lilen = $(".siblclert ul li").length;
			
			$(".siblclert ul").css({
					"width":50*Lilen,
					"left":-(Lilen-3)*50
				});

		$(".staticYear").click(function(){
				$(".hideBody").show();
				$(this).addClass("objThis").siblings().removeClass("objThis");
				$(".staticYear_hidden").css("left","0px").show();
			})
			
		$(".endingYear").click(function(){
				$(".hideBody").show();
				$(".staticYear_hidden").css("left","105px");
				$(this).addClass("objThis").siblings().removeClass("objThis");
				$(".staticYear_hidden").show();
				
			})
			
		$(".siblclert ul li").click(function(){
				$(this).addClass("on").siblings().removeClass("on");
			})
			
		$(".siblcCon ul li").click(function(){
			var lines = $(this).parent().parent().siblings(".blclertBox").find(".siblclert").find("li");
			var isSib = false;
			var tmeDate;
			for(var i =0; i <lines.length; i++){
				
					if(lines.eq(i).hasClass("on")){
						isSib = true;
						tmeDate = lines.eq(i).html();
						}
				}
				if(isSib){
					$(this).parents(".staticYear_hidden").siblings(".objThis").val(tmeDate+"-"+siczome($(this).html()));
					$(this).parents(".staticYear_hidden").siblings(".objThis").removeClass("objThis")
					$(this).parents(".staticYear_hidden").hide();
					$(".hideBody").hide();
				
					}
			})
		
		$(".sib_left").click(function(){
			var ul = $(this).siblings(".siblclert").find("ul");
			var left = parseInt(ul.css("left"));
				if(left<0){
						ul.css("left",left+50);
					}else{
						return ;
						}
			})
		$(".sib_right").click(function(){
		var ul = $(this).siblings(".siblclert").find("ul");
		var left = parseInt(ul.css("left"));
			if(left>-(Lilen-3)*50){
					ul.css("left",left-50+"px");
				}else{
					return ;
					}
			})
		}
		
		$(".hideBody").live('click',function(){
				$(this).hide();
				$(".staticYear_hidden").hide();
			})
		
		//时间补0
		function siczome( num ){
			var sun = num;
			if(num<=9){
					sun ="0"+sun;
				}
				return sun;
			}
                            
</script>
</body>
</html>


