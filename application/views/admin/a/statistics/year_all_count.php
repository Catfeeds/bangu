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
		.tionRela span{position:absolute; top:0; left:0}
		.tionRela{position: relative; padding-left:60px;margin-top: 10px;}
		/*详情 end*/
		.search-select{width: 100px;height: 25px;}
		
		.union-list{
			width: 80%;
			margin-left: 10%;
		}
		.union-list .union-content{
			clear:both;
		}
		.depart-list li{
			float:left;
			margin: 10px 20px 10px 10px;
		}
		.depart-list{
			margin-left: 50px;
		}
		.depart-list label{
			cursor:pointer;
		}
		.depart-list .clear{
			clear:both;
		}

	</style>
</head>
<body style="margin-left:160px;">
    <div class="page-body" id="bodyMsg">
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>主页</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">全年营销统计</a>
        </div>
        
        <div class="page_content bg_gray">      
            <div class="table_content">
                <div class="tab_content">
                	<form class="search_form"  method="post" id="search-condition" action="">
                    	<div class="search_form_box clear">
<!--                         	<div class="search_group"> -->
<!--                             	<label>营业部</label> -->
<!--                                 <input type="text" name="name" class="search_input" /> -->
<!--                             </div> -->
                            <div class="search_group">
                            	<label>年份</label>
                                <select name="year" class="search-select">
                                	<option value="0">请选择</option>
                                	<?php 
                                		$now = date('Y' ,time());
                                		$i = 0;
                                		for($i ;$i<10 ;$i++) {
                                			$year = $now - $i +2;
                                			echo '<option value="'.$year.'">'.$year.'</option>';
                                		}
                                	?>
                                </select>
                            </div>
                            <div class="search_group">
                            	<input type="submit" class="search_button" value="查看"/>
                            </div>
                    	</div>
                    </form>
                    <ul class="union-list">
                    	<?php foreach($departArr as $v):?>
                    	<li class="union-content">
                    		<input type="checkbox" name="all">
                    		<?php echo $v['union_name'];?>
                    		<ul class="depart-list">
                    		<?php foreach($v['depart'] as $i):?>
                    			<li>
                    				<label><input type="checkbox" name="departId[]" value="<?php echo $i['depart_id']?>"><?php echo $i['depart_name']?></label>
                    			</li>
                    		<?php endforeach;?>
                    			<li class="clear"></li>
                    		</ul>
                    	</li>
                    	<?php endforeach;?>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
    
<script type="text/javascript" src="/assets/ht/js/layer.js"></script>
<script>
	$('input[name=all]').click(function(){
		if ($(this).attr('checked') == 'checked') {
			//全部选中
			$(this).nextAll('ul').find('input[type=checkbox]').attr('checked' ,true);
		} else {
			//取消全选
			$(this).nextAll('ul').find('input[type=checkbox]').attr('checked' ,false);
		}
	})
	
	$('#search-condition').submit(function(){
		var year = $('select[name=year]').val();
		if (year < 2000) {
			layer.alert('请选择年份', {icon: 2});
			return false;
		}
		var ids = '';
		$.each($('.depart-list').find('input[type=checkbox]') ,function(){
			if ($(this).attr('checked') == 'checked') {
				ids = ids+','+$(this).val();
			}
		})
		
		window.top.openWin({
			  type: 2,
			  area: ['1020px', '600px'],
			  title :year+'年全年营销体系收客人数统计',
			  fix: true, //不固定
			  maxmin: true,
			  content: "<?php echo base_url('admin/a/statistics/year_all_count/year_all_detail');?>"+"?year="+year+'&ids='+ids
		});
		return false;
	})
</script>
</html>


