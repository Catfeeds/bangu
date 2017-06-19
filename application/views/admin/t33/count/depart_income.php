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
	.siblcCon ul { overflow: hidden; width:202px; margin: 0 auto; position:relative; left:-1px;border-top:1px solid #ccc;border-left:1px solid #ccc;}
	.siblcCon ul li{cursor:pointer; float:left; border-right:1px solid #ccc; border-bottom:1px solid #ccc; width:50px; text-align:center; background:#fff; height:24px; line-height:24px;}
	.sib_left{ margin-left:3px !important;cursor:pointer;}
	.sib_left, .sib_right{ cursor:pointer; width:24px; background:#fff; border:1px solid #ccc; margin:5px 2px; float:left; height:24px; line-height:20px; text-align:center;}
	.blclertBox{ overflow:hidden;}
	.siblclert ul li.on{ background:#ccc;}
	
	.search-select{width: 60px;height: 25px;}
	.search-year,.search-quarter,.search-month{display:none;}
	
	.posTh{ position: relative;}
	.price_icon_top { width:0; height:0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-bottom: 4px solid #ccc; position: absolute; top: 7px; right:5px; margin-left: 2px;  cursor: pointer; }
	.price_icon_bottom { width:0; height:0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 4px solid #ccc; position: absolute; top: 15px; right:5px; margin-left: 2px;  cursor: pointer; }
	.price_icon_top.active { border-bottom-color: #333; }
	.price_icon_bottom.active { border-top-color: #333; }
	</style>
</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
    <div class="page-body" id="bodyMsg" >
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">营业部收入统计</a>
        </div>
        
        <div class="page_content bg_gray" style="min-height:400px;">    
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form" method="get" id="search-condition" action="/admin/t33/sys/count/depart_income/index">
                    	<div class="search_form_box clear">
                        	<div class="search_group">
                            	<label>查询月份：</label>
                            </div>
                            <!-- 月份选择 -->
                           	<div class="actoeln search-month" style="display:block;">
                            	<input type="text" class="staticYear actoelnInput" readonly="readonly" value="<?php echo $starttime?>" name="starttime" placeholder="开始时间">
                                <input type="text" class="endingYear actoelnInput" readonly="readonly" value="<?php echo $endtime?>" name="endtime" placeholder="结束时间">
                                <div class="staticYear_hidden">
                                    <div class="blclertBox">
                                        <div class="sib_left"><</div>
                                        <div class="siblclert" id="yearLIst">
                                            <ul>
                                                
                                            </ul>
                                        </div>
                                        <div class="sib_right">></div>
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
                            
                            <div class="search_group" style="margin-left:15px;">
                            	<label>营业部：</label>
                                <input type="text" name="name" value="<?php echo $name?>" style="height:24px;line-height:22px;">
                            </div>
                            <div class="search_group">
                            	<input type="hidden" class="search_button" name="by_type" value="<?php echo $by_type?>"/>
                            	<input type="hidden" class="search_button" name="by_time" value="<?php echo $by_time?>"/>
                            	<input type="submit" class="search_button" value="搜索"/>
                            	<input type="button" class="search_button" id="export-excel" value="导出excel"/>
                            </div>
                    	</div>
                    </form>
                    
                    <table class="table table-bordered table_hover">
                            <thead class="">
                                <tr>
                                    <th >营业部名称</th>
                                    <?php 
                                    	foreach($titleArr as $v)
                                    	{
                                    		echo '<th data-val="'.$v['key'].'">'.$v['title'].'</th>';
                                    	}
                                    ?>
                                    <th class="posTh" data-val="total">
                                    	<i class="price_icon_top <?php if ($by_type=="asc"){echo 'active';}?>"></i>
                                    	<i class="price_icon_bottom <?php if ($by_type=="desc"){echo 'active';}?>"></i>总收入
                                    </th>
                                </tr>
                            </thead>
                           
                            <tbody class="table-body">
                            	<?php foreach($statisticsArr as $v):?>
                                <tr>
                                	<td><?php echo $v['depart_name']?></td>
                                	<?php 
                                		foreach($titleArr as $val){
                                			echo '<td class="depart-num">';
											echo '<a data-val="'.$v['depart_id'].'" data-name="'.$v['depart_name'].'" data-time="'.$val['title'].'" href="javascript:void(0);" onclick="chioce(this);">'.$v[$val['key']].'</a>';
											echo '</td>';
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
                        
                </div>
            </div> 
        </div>
    </div>
    
<div class="fb-content" id="chioce-box" style="display:none;">
    <div class="box-title">
        <h4>选择报表格式</h4>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
        <form method="post" action="#" id="disable-union" class="form-horizontal">
            <div class="form-group">
                <div class="fg-title">停用原因：<i>*</i></div>
                <div class="fg-input"><textarea name="remark" maxlength="150"></textarea></div>
            </div>
            <div class="form-group">
                <input type="hidden" name="id" value="">
                <input type="button" class="fg-but layui-layer-close" value="取消">
                <input type="submit" class="fg-but" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
$('#export-excel').click(function(){
	$.ajax({
		url:'/admin/t33/sys/count/depart_income/exportExcel',
		data:$('#search-condition').serialize(),
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

$('.page-list').find('li').click(function(){
	layer.load(2);
})
$('input[type=submit]').click(function(){
	layer.load(2);
})

//选择报表格式
function chioce(obj) {
	var departId = $(obj).attr('data-val');
	var name = $(obj).attr('data-name');
	var type = $(obj).attr('data-type');
	var time = $(obj).attr('data-time');

	var timeArr = time.split('-');
	var title = name+timeArr[1]+'月份人数统计';

	window.top.openWin({
		  type: 2,
		  area: ['860px', '600px'],
		  title :title,
		  fix: true, //不固定
		  maxmin: true,
		  content: "<?php echo base_url('/admin/t33/sys/count/depart_income/wholeExcel');?>"+"?id="+departId+'&time='+time+'&name='+name
	});

	return false;
}


//最后一列总计
$.each($('.table-body').find('tr'),function(){
	var num = 0;
	$.each($(this).find('.depart-num'),function(){
		if ($(this).find('a').length) {
			num = num + $(this).find('a').html()*1;
		} else {
			num = num + $(this).html()*1;
		}
	})
	$(this).find('td').last().html(num);
})

//最后一行总计
$.each($('.column-count'),function(){
	var num = 0;
	var index = $(this).index();
	$.each($('.table-body').find('tr') ,function() {
		if ($(this).find('td').eq(index).find('a').length) {
			num = $(this).find('td').eq(index).find('a').html()*1 + num;
		} else {
			num = $(this).find('td').eq(index).html()*1 + num;
		}
	})
	$(this).html(num);
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
		
		$(".posTh i").click(function(){
			$(".posTh i").removeClass("active");
			$(this).addClass("active");
			if($(this).hasClass('price_icon_top')){
				$('input[name=by_type]').val('asc');
				$('input[name=by_time]').val($(this).parent().attr('data-val'));
			}else{
				$('input[name=by_type]').val('desc');
				$('input[name=by_time]').val($(this).parent().attr('data-val'));
			}
			$('#search-condition').submit();
		})                   
</script>
</body>
</html>


