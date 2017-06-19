<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>旅游体验师_旅游体验师招募—帮游旅行网</title>
<meta name="description" content="帮游旅行网招募一些爱旅行、乐分享的旅游体验师通过在旅途中自己的亲身体验将旅游攻略,旅行计划分享出来给大家提供旅游参考，成为旅游体验师，将获得免费旅游的机会。" />
<meta name="keywords" content="旅游体验师,旅游体验师招募,旅游攻略,旅行计划" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link rel="stylesheet" href="<?php echo base_url();?>static/css/common.css" />
<link rel="stylesheet" href="<?php echo base_url();?>static/css/experience_list.css" />
<link href="<?php echo base_url('static/css/plugins/choice_city.css'); ?>" rel="stylesheet" />
<link href="/assets/js/jQuery-plugin/citylist/city.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url();?>static/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<?php $this->load->view('common/header'); ?>

<div class="main w_1200">
	<div class="now_station">
    	您的位置：<a href="<?php echo sys_constant::INDEX_URL?>">首页</a><span class="right_jiantou">></span><a href="#">体验师</a>
    </div>
    <!--最美体验师-->
	<div class="beautiful_experience">
    	<div class="beautiful_experience_title">最美体验师</div>
        <div class="beautiful_experience_img">
        	<ul class="clear">
        		<?php foreach($beauty_list as $val):?>
            	<li class="beautiful_qiehuan_yichu">
                	<a href="<?php echo base_url("tys/{$val['member_id']}");?>">
                	<img src="<?php echo $val['pic']?>" width='285' height='285' class="qiehuan_yuan" />
                    	<div class="beautiful_qiehuan">
                        	<?php echo $val['nickname']?><i></i>
                        </div>
                	</a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
    <div class="experience_list clear">
    <!--体验师列表 开始-->
    	<div class="experience_left_side fl">
    	<!-- 搜索条件开始 -->
        	<div class="experience_search clear">
        	<form action="" method="post" id="experience_search">
            	<span class="tiaoxuan">挑选体验师</span>
                <i class="line_icon"></i>
                <span>所在地：</span>
                <input type="text" name="city" class="live_place" id="cityName" placeholder="请选择" />
                <input type="hidden" name="city_id" id="cityId" />
                <span>去过的地方：</span>
                <input type="text" name="dest_name" class="go_place" id="dest_name" placeholder="请选择" />
                <input type="hidden" name="dest_id" id="dest_id" />
                <span>性别：</span>
                <select name="sex">
                	<option value="0">不限</option>
                    <option value="1">男</option>
                    <option value="2">女</option>
                </select>
                <span>年龄：</span>
                <select name="age">
                	<option value="0">不限</option>
                   	<?php
                   		foreach($age_search as $val) {
							if ($val['minvalue'] < 1) {
								echo "<option value='{$val['minvalue']}-{$val['maxvalue']}'>{$val['maxvalue']}以下</option>";
							} elseif ($val['maxvalue'] < 1) {
								echo "<option value='{$val['minvalue']}-{$val['maxvalue']}'>{$val['minvalue']}以上</option>";
							} else {
								echo "<option value='{$val['minvalue']}-{$val['maxvalue']}'>{$val['minvalue']}-{$val['maxvalue']}</option>";
							}
                   		}
                   	?>
                </select>
                <div class="experience_search_box fr">
                	<input type="hidden" name="page_new" />
            		<input type="text" name="nickname" value="<?php echo $key_word;?>"  placeholder="关键字"/><i class="search_icon search_form_experience"></i>
            	</div>
            </form>
            </div>
           <!-- 搜索条件结束 -->
            <div class="experience_list_detail clear">
            	<!-- 列表数据 -->
            	<ul class="clear experience_list_data"> </ul>
            </div>
            <!-- 分页 -->
            <ul class="pagination"></ul>
            <div class="searchNoExper" style="display:none;"><img src="<?php echo base_url('static'); ?>/img/page/no_experience.png" /></div>
        </div>
        <!--体验师列表 结束-->

        <!--热门体验线路 开始-->
        <div class="experience_right_side fr">
        <div class="right_side_content">
        	<div class="hot_experience_line">热门体验线路</div>
            <div>
            	<ul class="hot_experience_line_list clear">
                 	<?php 
                 		foreach($hot_list as $key =>$val):
                                    // 将cj,gn改为line,添加后缀.html 魏勇编辑
                 		$line_url = in_array(1 ,explode(',',$val['overcity'])) ? '/line/'.$val['id'].'.html' : '/line/'.$val['id'].'.html';
                 	?>
                	<li class="clear">
                    	<div class="hot_line_info">
                    		<a href="<?php echo $line_url;?>">
                            <div class="hot_line_num fl">NO.<span><?php echo $key+1?></span></div>
                            <div class="hot_line_txt fl"><?php echo str_cut($val['linename'] ,54)?><div class="hot_line_price fr"><span>¥ </span><?php echo $val['lineprice']?> </div></div>

                            </a>
                        </div>
                        <div class="hot_line_cover">
                        	<a href="<?php echo $line_url;?>">
                        	<img src="<?php echo base_url('static'); ?>/img/page/hot_line_1.png" alt="" />
                            <div class="cover_info">
                            	<div class="cover_num fl">NO.<span><?php echo $key+1?></span></div>
                            	<div class="cover_txt fl"><?php echo str_cut($val['linename'] ,54)?><div class="cover_price fr"><span>¥</span> <?php echo $val['lineprice']?> </div></div>

                            </div>
                            </a>
                        </div>
                    </li>
                    <?php endforeach;?>

                </ul>
            </div>
        </div>
        </div>
        <!--热门体验线路 结束-->
    </div>
</div>

<!--====================咨询体验师弹框=================== -->
<div class="private_letter_box">
	<div class="private_letter_content">
    	<span class="close_private_letter"><i></i></span>
    	<div class="private_title">咨询</div>
        <div class="write_content clear">
        <form action="" method="post">
        	<div class="private_object fl"><span class="title_name">发件人:</span><span class="title_name_content">会员昵称</span></div>
            <div class="private_object fr"><span class="title_name">收件人:</span><span class="title_name_content">体验师昵称</span></div>
            <div class="fl"><span class="title_name num_info">手机号:</span><input type="text" name="" value="18787878787" class="write_input"/></div>
            <div class="fl"><span class="title_name num_info">微信号:</span><input type="text" name="" value="" placeholder="请输入您的微信号" class="write_input"/></div>
            <div class="private_product_info fl"><span class="title_name">产品名称:</span>
            	<span id="expertAge">
                    <div class="expertAge_box" style="width:340px;height:32px;text-align:left;border:1px solid #aaa;">
                      <div class="expertAge_showbox line_price" style="width:342px;background-position:310px 14px;">韩国济州3晚4日跟团游(华南众游韩2日游）</div>
                      <ul class="expertAge_option">
                           <li class="selected" value="">韩国济州3晚4日跟团游(华南众游韩2日游）</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）1</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）2</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）3</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）4</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）5</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）6</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）7</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）8</li>
                           <li value="">韩国济州3晚4日跟团游(华南众游韩2日游）9</li>
                      </ul>
                    </div>
                </span>
            </div>
            <div class="fl" style="position:relative;"><span class="title_name">内容:</span><textarea name="" class="txt_content" placeholder="请编辑您要咨询的内容，100字以内"></textarea>
            	<span class="font_num_title">已写<i>0</i>字</span>
            </div>
            <div class="submit_button fl"><input type="submit" name="submit" value="发送" class="send_letter"/><input type="reset" class="cancel"/>
            	<span class="cancel_button">取消</span>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="bg_box"></div>



<?php $this->load->view('common/footer'); ?>
<script type="text/javascript" src="<?php echo base_url()?>static/js/lazyload-min.js"></script>
<script  type="text/javascript" src="<?php echo base_url()?>assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script src="/assets/js/jQuery-plugin/citylist/citylist.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script type="text/javascript">
createChoicePlugin({
	data:chioceAreaJson,
	nameId:"cityName",
	valId:"cityId",
	isHot:true,
	hotName:'热门城市',
});
//目的地
 $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"dest_name",
		valId:"dest_id"
	});
});
 //刷新页面初始化
$("#experience_search").find('input').val('');
$("#experience_search").find('select').val(0);
$("input[name='nickname']").val('<?php echo $key_word?>');

//分页
$('.ajax_page').click(function(){
	var page_new = $(this).find('a').attr('page_new');
	get_ajax_page(page_new);
})
$('.search_form_experience').click(function(){
	get_ajax_page(1);
})
get_ajax_page(1);
function get_ajax_page (page_new) {
		$('input[name="page_new"]').val(page_new);
		$.post(
			"<?php echo site_url('experience/member_experience/search_ajax_list')?>",
			$("#experience_search").serialize(),
			function(data) {
				$('.experience_list_data').html('');
				$('.pagination').html('');
				if (data == false) {
					$('.searchNoExper').show();
					return false;
				} else {
					$('.searchNoExper').hide();
				}
				data = eval('('+data+')');

				//循环遍历体验师数据
				var str = '';
				$.each(data.list ,function(key ,val) {
					if (val.city_name == null) {
						city = '';
					} else {
						city = val.city_name;
					}
					if (val.talk == null) {
						talk = '';
					} else {
						talk = val.talk;
					}
					 str += '<li>';
					var exper_url = "/tys/"+val.member_id;
					/*头像*/
					str += '<div class="experience_list_img fl">';
					str += '<a href="'+exper_url+'"><img width="200" height="200" src="'+val.litpic+'" /></a>';
					str += '</div>';
					/*姓名*/
					str += '<div class="experience_info fr">';
					str += '<div class="experience_info_txt">';
					if (val.sex == 1) {
						var url = "<?php echo  base_url();?>static/img/page/boy.png";
					} else {
						var url = "<?php echo  base_url();?>static/img/page/girl.png";
					}
					str += '<a href="'+exper_url+'"><span class="experience_name">'+val.nickname+'<img src="'+url+'" alt="" class="sex_img"/></span></a>';
					/*个性宣言*/
					str += '<div class="experience_txt"><p>'+talk+'</p></div>';
					/*地区*/
					str += '<div class="position">';
					str += '<i class="live_place_icon"></i><span class="live_place_txt">所在地：'+city+'</span>';
					str += '<i class="go_place_icon"></i><span class="go_place_txt">去过的地方：'+val.dest_name+'</span>';
					/*个人主页*/
					str += '<a href="'+exper_url+'"><span id="person_page_link">TA的主页>></span></a>';
					str += '</div></div>';
					/*旅行经历*咨询人数*/
					str += '<div class="serve_info">';
					str += '<div class="travel_num">';
					str += '<span>'+val.order_count+'次</span><br/>';
					str += '旅行经历</div>';
					str += '<div class="cousnel_num"><span>'+val.consult_count+'人</span><br/>咨询过';
					str += '</div></div>';
					/*二维码*/
					str += '<div class="counsel_button"><span>咨询体验师</span>';
					//str += '<div class="hide_code"><p class="shao_erweima">轻松扫一扫，解决旅途烦恼</p>';
					//str += '<img src="'+val.qrcode+'" />';
					str += '</div></div></div></li>';
				})
				$('.experience_list_data').html(str);
				//分页
				$('.pagination').html(data.page_string);

				$('.ajax_page').click(function(){
					var page_new = $(this).find('a').attr('page_new');
					get_ajax_page(page_new);
				})
				$(".experience_list_detail ul li").hover(function(){
					$(this).find('div').eq(1).css("border-color","#ffae00");
				},function(){
					$(this).find('div').eq(1).css("border-color","#f2f2f2");
				});

				$(".close_private_letter").hover(function(){
					$(this).addClass("hover_this");
				},function(){
					$(this).removeClass("hover_this");
				});
				//咨询体验师弹框
				$(".counsel_button").click(function(){
					$(".private_letter_box,.bg_box").show();
				});
				$(".close_private_letter").click(function(){
					$(".private_letter_box,.bg_box").hide();
				});

				//字数计算
				$(".txt_content").keyup(function(){
					var content = $(this).val();
					var fontNum = content.length;
					$(this).siblings(".font_num_title").find("i").html(fontNum);
				});
				//弹框 取消操作
				$(".cancel_button").click(function(){
					$(".cancel").trigger("click");
					$(".private_letter_box,.bg_box").hide();
				});

				$(".expertAge_showbox").click(function(){
					$(".expertAge_showbox").siblings(".expertAge_option").hide();
					$(this).siblings(".expertAge_option").show();
				});

				$(".expertAge_option li").click(function(){
					var values=$(this).html();
					var val = parseInt($(this).attr("value"));
					$(this).parent().hide();
					$(this).addClass('selected').siblings().removeClass('selected');
					$(this).parent().siblings("input").val(val);
					$(this).parent().siblings().html(values);
				});

				$(".expertAge_option li").eq();
				 $(document).mouseup(function(e) {
					  var _con = $('.expertAge_box'); // 设置目标区域
					  if (!_con.is(e.target) && _con.has(e.target).length === 0) {
						  $(".expertAge_box").find("ul").hide()
					  }
				  })

			}
		);
}

$(function(){

	//右侧边栏 鼠标移上效果
	$(".hot_experience_line_list li").eq(0).find(".hot_line_info").hide();
	$(".hot_experience_line_list li").eq(0).find(".hot_line_cover").fadeTo("slow", 0.99)
	$(".hot_experience_line_list li").hover(function(){
		$(".hot_line_info").show();
		$(".hot_line_cover").hide();
		$(this).children(".hot_line_info").hide();
		$(this).children(".hot_line_cover").fadeTo("slow", 0.99);
	},function(){});
});
</script>

</body>
</html>
