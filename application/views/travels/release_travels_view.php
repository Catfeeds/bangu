<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/fabuyouji.css'); ?>" rel="stylesheet"/>
<link href="<?php echo base_url('static/css/common.css'); ?>" rel="stylesheet"/>
<script src="<?php echo base_url('static/js/jquery-1.11.1.min.js'); ?>" type="text/javascript"></script>
<title>发布游记</title>
<meta name="description" content="<?php echo $web['description']?>" />
<meta name="keywords" content="<?php echo $web['keyword']?>" />
</head>
<body>
    <?php $this -> load -> view('common/header'); ?>
    <div class="Release_dangqian">您的当前位置:<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>><a href="">游记</a>><a href="">写游记</a></div>
    <div class="Release_main">
        <div class="Rel_title">
            <span>游记标题</span>
            <input type="text" placeholder="给游记取个吸引眼球的名字吧">
        </div>
        <div class="Rel_title">
            <span>选择订单线路</span>
            <select>
                <option>请选择</option>
                <option>选择订单线路</option>
                <option>选择订单线路</option>
                <option>选择订单线路</option>
                <option>选择订单线路</option>
                <option>选择订单线路</option>
                <option>选择订单线路</option>
            </select>
        </div>
        <div class="Rel_title">
            <span style="float:left;">产品标签</span><span style="width:auto; float:right;line-height: 30px; color:#3a3dfe;">+添加标签</span>
            <ul class="Group_input">
                <li class="">
                   	<div class="on_box"><input type="text" value="选择年份" class="on"/></div>
                   	<ul class="hidden">
                       	<div class="close">关闭</div>
                       	<li>
                           	<div class="xila_title">类型</div>
                            <ul class="list_he">
                                <li>散拼团</li>
                                <li>小包团</li>
                                <li>两人成团</li>
                                <li>自助游</li>
                                <li>无购物</li>
                                <li>包资费</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           	</ul>
                       	</li>
                       	<li>
                           	<div class="xila_title">适合</div>
                            <ul class="list_he">
                                <li>亲子游</li>
                                <li>爸妈游</li>
                                <li>合家欢</li>
                                <li>自助游</li>
                                <li>无购物</li>
                                <li>包资费</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           </ul>
                       </li>
                       <li>
                           <div class="xila_title">体验</div>
                            <ul class="list_he">
                                <li>高端奢华</li>
                                <li>便宜不贵</li>
                                <li>两人成团</li>
                                <li>自助游</li>
                                <li>无购物</li>
                                <li>包资费</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           </ul>
                       </li>
                       <li>
                           	<div class="xila_title">价格</div>
                            <ul class="list_he">
                                <li>新品价</li>
                                <li>拍卖价</li>
                                <li>两人成团</li>
                                <li>自助游</li>
                                <li>无购物</li>
                                <li>包资费</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           	</ul>
                       	</li>
                       	<li>
                           	<div class="xila_title">行程</div>
                            <ul class="list_he">
                                <li>独家行程</li>
                                <li>餐饮特色</li>
                                <li>免费wifi</li>
                                <li>寒假</li>
                                <li>无购物</li>
                                <li>包资费</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           	</ul>
                       	</li>
                       	<li>
                           	<div class="xila_title">交通</div>
                            <ul class="list_he">
                                <li>飞机</li>
                                <li>汽车</li>
                                <li>火车</li>
                                <li>自行车</li>
                                <li>无购物</li>
                                <li>包资费</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           	</ul>
                       	</li>
                       	<li>
                           	<div class="xila_title">餐饮</div>
                            <ul class="list_he">
                                <li>自助餐</li>
                                <li>风味</li>
                                <li>小吃</li>
                                <li>海鲜</li>
                                <li>西餐</li>
                                <li>火锅</li>
                                <li>五领队</li>
                                <li>纯玩</li>
                                <li>铁定成团</li>
                           	</ul>
                       	</li>
                   	</ul>
                </li>
            </ul>
        </div>
        <div class="Rel_Personality">
            <span>游记简述</span>
            <textarea placeholder="写点心得,偶遇,桃花,你的游记随你任性."></textarea>
        </div>
        <div class="Upload_photo">
            <span style="width:100%"><img alt="" src="<?php echo base_url('static'); ?>/img/xiangji.png"><a href="">添加封面</a><span class="photo_tishi">请上传1200 x 720的照片,且不大于10M</span></span>
            <img alt="" src="<?php echo base_url('static'); ?>/img/Upload.jpg">
        </div>
        <div class="Text_box">
            <div class="Text_text"><div class="wenzi_center">游记正文</div></div>
        </div>
        <div class="mokuai">
        <div class="Text_bzbp_title">边走边拍<span>爱摄影，爱美景，还等什么，上传到边走边拍</span></div>
        <div class="shanghcuan clear"><input type="file"><img></div>
        <div class="bzbp_box">
            <ul>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
            </ul>
        </div>
        </div>
        <div class="mokuai">
        <div class="Text_bzbp_title">旅行酒店<span>高档酒店、山顶露营、便宜旅馆？爱吐槽、爱得瑟，我有我风格</span></div>
        <div class="shanghcuan clear"><input type="file"><img></div>
        <div class="bzbp_box">
            <ul>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
            </ul>
        </div>
        </div>
        <div class="mokuai">
        <div class="Text_bzbp_title">发现美食<span>我是吃货，横扫街边美食，发现深巷小店，美食我来曝光</span></div>
        <div class="shanghcuan clear"><input type="file"><img></div>
        <div class="bzbp_box">
            <ul>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
                <li><img src="<?php echo base_url('static'); ?>/img/list_05.png"></li>
            </ul>
        </div>
        </div>
        <div class="main_button">
            <div class="Publish">发布游记</div>
            <div class="caogao">保存草稿</div>
            <div class="xieyi"><input type="checkbox">我已阅读并同意《帮游旅游协议》</div>
        </div>
    </div>
   	<?php $this -> load -> view('common/footer'); ?>
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
	// 所有需要点击隐藏的元素
	var sourcePopEles = ['.on_box']; ///点击源
	var popEles = ['.hidden']; //弹出层
	$(document).click(function(e) {
		var target = $(e.target);
		var length = popEles.length;
		$(".close").click(function() {
			$(".hidden").hide();
			return false;
		});
		$(".xila_title").click(function() {
			return false;
		});
		for (var i = 0; i < length; i++) {
			if (target.closest(sourcePopEles[i]).length > 0) { //点击源
				//如果点击源.或者点击弹出的层
				if ($(popEles[i]).is(':visible')) {
					$(popEles[i]).hide();
				} else {
					$(popEles[i]).show();
				}
				e.stopPropagation();
			} else if (target.closest(popEles[i]).length > 0) { //弹出层
				e.stopPropagation();
				//设置值
				var value = $(target).html(); // 获取点击的值
				var data_id = $(target).attr('data_id'); //获取选中值的ID
				//设置到源的 input 里面
				$(sourcePopEles[i]).find("input").val(value); //展示
			} else if (target.closest(sourcePopEles[i]).length == 0 && target.closest(popEles[i]).length == 0) {
				//如果点击点不是源和弹出层
				$(popEles[i]).hide();
			}
		}
	});
});
</script>

