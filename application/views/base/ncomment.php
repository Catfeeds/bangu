<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的评价_会员中心-帮游旅行网</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>"	rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css"	href="<?php echo base_url('static/css/user/user.css');?>"	rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>" rel="stylesheet" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/webuploader.html5only.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/eject_sc.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js"	type="text/javascript"></script>
</head>
<style>
.title_info_txt1,.title_info_txt2,.tset_1,.tset_2{ display:none;}
.webuploader-pick{ width:102px; margin-left:0px; z-index:1000;}
#as2 div:last-child{width:90px !important; height:24px !important; margin-top:10px !important; margin-left:5px !important;}
.parentFileBox{ top:42px; height:80px;}
.parentFileBox>.fileBoxUl{ top:0px; left:6px;}
.parentFileBox>.diyButton>a{ padding:3px 6px 3px 6px}
.parentFileBox>.diyButton{ position:absolute; top:0px;}
.diyStart{ top:0}
.diyCancelAll{ top:35px;}
</style>
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
				<div class="user_title">我的点评</div>
				<div class="consulting_warp">
					<div class="consulting_tab">
						<div class="hd cm_hd clear" style="border:none;">
							<ul class="click_par">
								<li class=" yi_ping"><a
									href="<?php echo base_url('base/member/comment'); ?>">已点评（<i
										class="link_green"><?php if(isset($did['num'])){ echo $did['num'];}else{ echo 0;} ?></i>）</a>
                                </li>
                            	<li class="on"><a href="<?php echo base_url('base/member/ncomment'); ?>">未点评（<i><?php if(!empty($allData)){echo $allData;}else{ echo 0;} ?></i>）</a></li>
							</ul>
						</div>
						<div class="bd cm_bd yi_ment">

                         <!--未点评-->
                        <div class="bd cm_bd wei_ment" >
							<!-- tab 切换已点评时的内容 -->
								<table class="common-table" style="position: relative;"
									border="0" cellpadding="0" cellspacing="0">
									<thead class="common_thead">
										<tr>
											<th width="100"><span class="td_left">订单编号</span></th>
											<th width="300">产品标题</th>
											<th width="150">参团人数</th>
											<th>订单金额</th>
											<th>出团日期</th>
											<th width="80">操作</th>
										</tr>
									</thead>
									<tbody class="common_tbody">
										<?php if (! empty ( $order )) {foreach ( $order as $k => $v ) {?>
										<tr class="tr">
										    <td  width="100" title=""><?php echo $v['ordersn']; ?></td>
											<td width="200"><span class="td_left">
                                                                                                <!-- 将cj,gn改为line,添加后缀.html-->
											<a href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['productautoid'].'.html' : '/line/'.$v['productautoid'].'.html'; ?>" target="_blank" title="<?php echo $v['productname']; ?>"><?php echo   $str = mb_strimwidth($v['productname'], 0, 30, '...', 'utf8'); ?></a>
											</span></td>

											<td><?php echo $v['membernum']; ?></td>
                                            <td><?php echo $v['order_price']; ?></td>
											<td><?php echo $v['usedate']; ?></td>
											<td class="detail_link pingjia"><a href="#evaluateButton" class="evaluateButton" expert_id="<?php echo $v['expert_id']; ?>" data="<?php echo $v['orderid']; ?>" lineid="<?php echo $v['productautoid']; ?>">评价</a></td>
										</tr>
										<?php } }else{?>
										<!-- 以下是没有点评记录时的状态 -->
										<tr>
											<td class="order_list_active" colspan="5">
												<p class="cow-title">您最近没有未点评记录！</p>
											</td>
										</tr>
									<?php  }?>
									</tbody>
								</table>
								<div class="pagination">
									<ul class="page"><?php if(! empty ( $order )){ echo $this->page->create_c_page();}?></ul>
								</div>
						</div>
					</div>
				</div>
			</div>
			<!-- 右侧菜单结束 -->
		</div>
	</div>
</div>
	<!--编辑评论弹出层内容 -->
	<div id="evaluateButton" style="display: none; width: 720px;">
		<!-- 此处放编辑内容 -->
		<div class="eject_big">
			<div class="eject_back clear" style="height: auto;">
				<form class="form-horizontal" role="form" method="post"
					id="evaluateForm" onsubmit="return Checkevaluate();"
					action="<?php echo base_url();?>base/member/add_comment">

					<div class="eject_title fl">
						<h3>评价订单</h3>
						<p class="comment_line">评价线路:<?php echo $v['productname']; ?></p>
					</div>
                    <div class="olumn">评价产品</div>
					<div class="eject_content fl">
						<div class="eject_content_right fl">
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>导游服务:</span>
									<ul class="score0">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>行程安排:</span>
									<ul class="score1">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>餐饮住宿:</span>
									<ul class="score2">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="eject_right_one">
								<div class="eject_xx_box">
									<span>旅游交通:</span>
									<ul class="score3">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<i></i> <a></a>
								</div>
							</div>
							<div class="title_info_txt title_info_txt1">
								<span>产品满意度:&nbsp;<i style=" color:#f00;">50</i>&nbsp;%</span>
							</div>
                            <div class="title_info_txt title_info_txt2">
								<span>产品平均分:&nbsp;<i style=" color:#f00;">2.5</i>&nbsp;分</span>
							</div>
						</div>
					</div>
					<div class="eject-content_left fl">
						<div class="eject_content_left_s">

							<div class="eject_input_Slide">
								<textarea name="content1" class="content1" id="content1" maxlength="200"></textarea>
								<span class="font_num_title"><span>200</span><i>/200</i>
								</span>
							</div>
						</div>
					</div>

					<div class="eject_content2 fl">
						<div class="olumn">评价管家</div>
						<div class="eject_content_left-x clear">

							<div class="eject_right_one fl"
								style="margin-bottom: 10px; width: 200px; margin-left: 20px;">
								<div class="eject_xx_box">
									<span style="color: #666;">专业度:</span>
									<input type="hidden" name="major" value="0" class="zyd" />
									<ul class="score4">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
							<div class="eject_right_one fl"
								style="margin-bottom: 10px; width: 200px; margin-left: 20px;">
								<div class="eject_xx_box">
									<span style="color: #666;">服务态度:</span>
									<input type="hidden" name="serve" value="0" class="fwtd" />
									<ul class="score5">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>

                            <div class="expert_grade tset_1 fl">
								管家满意度:&nbsp;<span>0</span>&nbsp;%
							</div>
                            <div class="expert_grade tset_2 fl">
								管家平均分:&nbsp;<span>0</span>&nbsp;分
							</div>
                            <div class="eject_input_Evaluation fl">
								<textarea name="content2" class="content2"></textarea>
								<span class="font_num_title abs_tex"><span>200</span><i>/200</i>
								</span>
							</div>
                      		<div class="show_img fl">
								<p>晒图片</p>
								<div id="demo">
									<div id="as2" class="webuploader-container"></div>
									<!--<div class="title_info_txt title_info_txt3">
									<p>(注:上传图片送500积分)</p>
									</div> -->
								</div>
							</div>

							<div class="grades"></div>
							<div class="pic_comment"></div>
							<div class="eject_button fl" style="padding-bottom: 2px;">
							<input type="hidden" name="orderid" />
							<input type="hidden" name="lineid" />
							<input type="hidden" name="expert_id" />
							<input type="submit" name="submit" value="提交评价" class="commit" />
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- end -->

	<!-- 追评弹出层内容 -->
	<div id="on_comment"
		style="display: none; width: 500px; height: 290px;">
		<!-- 此处放编辑内容 -->
	</div>


	<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>

<script type="text/javascript">
$(function() {
	$(".mc dl dt").removeClass("cur");
	$("#user_nav_4 dt").addClass("cur");

(function() {
//编辑评论
try {
	$(".evaluateButton").click(function() {
	//清除评论的内容
	$('.eject_xx_box').find('li').removeClass('hove');
	$('.eject_xx_box').find('i').css('display','none');//display: none;
	$('#content1').val('');
	$('.content2').val('');
	$('.fileBoxUl').html('');
	//去掉管家满意分
	$(".tset_1").hide();
	$(".tset_2").hide();
	$(".tset_1 span").html('0');
	$(".tset_2 span").html('0');
	//去掉产品满意分
	$(".title_info_txt1").hide();
	$(".title_info_txt2").hide();
	$(".title_info_txt1").find("span").find("i").html('0')
	$(".title_info_txt2").find("span").find("i").html('0')

	var orderid=$(this).attr('data');
	var lineid=$(this).attr('lineid');
	var expert_id=$(this).attr('expert_id');
	$('input[name="orderid"]').val(orderid);
	$('input[name="lineid"]').val(lineid);
	$('input[name="expert_id"]').val(expert_id);
	$.post("<?php echo base_url('base/member/AddCommentData')?>", { orderid:orderid} , function(re) {
	var re =eval("("+re+")");
	$('.comment_line').html(re.order.productname);
if(re){
	json = eval(re.rows);
	//多个上传图片
	var img_arr='';
	$('#as2').diyUpload({
	url:"<?php echo base_url('line/line_detail/upfile')?>",
	success:function( data ) {
	console.info( data );
	img_arr=img_arr+'<input type="hidden" name="img[]" value="'+data.url+'" />';
	$('.pic_comment').html(img_arr);
},
	error:function( err ) {
	console.info( err );
},
	//buttonText : '<img class="fl" src="<?php echo base_url('static'); ?>/img/user/u9.png"/><div class="img_num fl"><i>0</i>/5</div>',
	buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span></span></div>',
	//buttonText : '上传',
	chunked:true,
	// 分片大小
	chunkSize:512 * 1024,
	//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
	fileNumLimit:5,
	fileSizeLimit:500000 * 1024,
	fileSingleSizeLimit:50000 * 1024,
	accept: {}
});

	/*  ------------------星级数量的触发事件-----------------------   */
function drawStar(box,num){
	$(box).find("li").each(function(index){
//console.log(" drawStar   :"+num +","+index);
	if(num>=index){
		$(this).addClass("hove");
	} else{
		$(this).removeClass("hove");
	}
});
}


//点击/移上 星星提示文字
$(".score0 li,.score1 li,.score2 li,.score3 li").hover(function(){
	$(this).parent().siblings("i").hide();
	$(this).parent().siblings("a").show();
	var index = $(this).index();
	if(index==0){
		$(this).parent().siblings("a").html("失望");
	}
	if(index==1){
		$(this).parent().siblings("a").html("不满");
	}
	if(index==2){
		$(this).parent().siblings("a").html("一般");
	}
	if(index==3){
		$(this).parent().siblings("a").html("满意");
	}
	if(index==4){
		$(this).parent().siblings("a").html("惊喜");
	}
	},function(){
		$(this).parent().siblings("a").hide();
		$(this).parent().siblings("i").show();
	});
	$(".score0 li,.score1 li,.score2 li,.score3 li").click(function(){
		$(this).parent().siblings("a").hide();
		$(this).parent().siblings("i").show();
	var index = $(this).index();
	if(index==0){
		$(this).parent().siblings("i").html("失望");
	}
	if(index==1){
		$(this).parent().siblings("i").html("不满");
	}
	if(index==2){
		$(this).parent().siblings("i").html("一般");
	}
	if(index==3){
		$(this).parent().siblings("i").html("满意");
	}
	if(index==4){
		$(this).parent().siblings("i").html("惊喜");
	}
	//产品满意度
	var sco_mun=$(".score0,.score1,.score2,.score3").find(".hove").length;
	var mun= sco_mun*5;
	var fen= (sco_mun*5/20).toFixed(1);
	$(".title_info_txt1").show();
	$(".title_info_txt2").show();
	$(".title_info_txt1").find("span").find("i").html(mun)
	$(".title_info_txt2").find("span").find("i").html(fen)
});

//管家评分
$(".score4 li").click(function(){
	var sco4=$(".score4").find(".hove").length;
	var sco5=$(".score5").find(".hove").length;
	var mun= (sco4+sco5)/2;

	$(".tset_1").show();
	$(".tset_2").show();
	$(".tset_1 span").html((sco5+sco4)*10);
	$(".tset_2 span").html(mun);

});
$(".score5 li").click(function(){
	var sco4=$(".score4").find(".hove").length;
	var sco5=$(".score5").find(".hove").length;
	var mun= (sco4+sco5)/2;
	$(".tset_1").show();
	$(".tset_2").show();
	$(".tset_1 span").html((sco5+sco4)*10);
	$(".tset_2 span").html(mun);

});
$(".eject_xx_box").each(function(index, element) {
	$(this).find("li").each(function(index){
	$(this).click(function(){
	//console.log(" li click :"+index+","+$(this.parentNode.parentNode));
	$(this.parentNode.parentNode).attr("value",index) ;//根据第几个，设置上级的上级的value
	//TODO 设置隐藏域的值
	});
}); //点击
$(this).find("li").each(function(index){
	$(this).mouseover(function(){
	//console.log(" li mouseover :"+index);
	//鼠标移进 /*根据第几个，把之前的全部亮了*/
	drawStar($(this.parentNode.parentNode),  index );
	});
});

	$(this).each(function(index){
		$(this).mouseout(function(){
		//console.log(" box mouseout " +index);
		//大的移出去，根据value 来画星星
			drawStar( $(this),  $(this).attr("value")  );
		});
	});
}) ;
	/*  -----------------星级数量的触发事件end---------------------   */
	}else{
	//alert('暂无评论！');
	}
});
	});
	$(".evaluateButton").fancybox();
	}catch (err) {
	}

	/* 追评评论弹层效果 */
try {
	$(".on_comment").fancybox();
	$(".on_comment").click(function() {
	var data=$(this).attr('data-val');
	$.post("<?php echo base_url('base/member/gocomment_ajax')?>", { data:data} , function(result) {
	if(result){
		$("#on_comment").html(result);
	}else{
		$("#on_comment").html(result);
	}
});
});
	} catch (err) {

	}
	})(jQuery)
})


//保存编辑评论
function Checkevaluate(){
	var content1= $('.content1').val();
	if(content1 !=''){
		//不能超过100个字
		var str=content1;
		var realLength = 0, len = str.length, charCode = -1;
		for (var a = 0; a < len; a++) {
			charCode = str.charCodeAt(a);
			if (charCode >= 0 && charCode <= 128)
			realLength += 1;
			else realLength += 1;
		}
		if(realLength>200){
			alert('线路的评价不能超过200个字');
			return false;
		}
	}

	var content2= $('.content2').val();
	if(content2 !=''){
		//不能超过100个字
		var str=content2;
		var realLength = 0, len = str.length, charCode = -1;
		for (var a = 0; a < len; a++) {
			charCode = str.charCodeAt(a);
			if (charCode >= 0 && charCode <= 128)
			realLength += 1;
			else realLength += 1;
		}
		if(realLength>200){
			alert('评价管家不能超过200个字');
			return false;
		}
	}

	var score0=$(".score0 .hove").length;
	var score1=$(".score1 .hove").length;
	var score2=$(".score2 .hove").length;
	var score3=$(".score3 .hove").length;
	var score4=$(".score4 .hove").length;
	var score5=$(".score5 .hove").length;
	if(score0==0){
		alert('导游服务评分不能为空');
		return false;
	}
	if(score1==0){
		alert('行程安排评分不能为空');
		return false;
	}
	if(score2==0){
		alert('餐饮住宿评分不能为空');
		return false;
	}
	if(score3==0){
		alert('旅游交通评分不能为空');
		return false;
	}
	if(score4==0){
		alert('管家专业度评分不能为空');
		return false;
	}
	if(score5==0){
		alert('管家服务态度评分不能为空');
		return false;
	}
	var str='';
	str=str+'<input type="hidden" name="score0" value="'+score0+'" /><input type="hidden" name="score1" value="'+score1+'" />';
	str=str+'<input type="hidden" name="score2" value="'+score2+'" /><input type="hidden" name="score3" value="'+score3+'" />';
	str=str+'<input type="hidden" name="score4" value="'+score4+'" /><input type="hidden" name="score5" value="'+score5+'" />';
	$('.grades').html(str);
	jQuery.ajax({ type : "POST",data : jQuery('#evaluateForm').serialize(),url : "<?php echo base_url();?>base/member/add_comment",
		success : function(re) {
			var re =eval("("+re+")");
			if(re.status==1){
				alert(re.msg );
				location.reload();
				$('.fancybox-close').click();
			}else{
				alert(re.msg );
				location.reload();
				$('.fancybox-close').click();

			}
		}
	});

	return false;
}



$(".click_par li").click(function(){
	$(this).addClass("on").siblings().removeClass("on");
	$(".link_green").removeClass("link_green");
	$(this).find("a").find("i").addClass("link_green")
})
$(".wei_ping").click(function(){
	$(".yi_ment").hide();
	$(".wei_ment").show();
});
$(".yi_ping").click(function(){
	$(".wei_ment").hide();
	$(".yi_ment").show();
});


//评论的限制字数
$(".content1,.content2").keyup(function(){
	var thisMum=$(this).val().length;
	$(this).siblings(".font_num_title").find("span").html(200-thisMum);
	if(thisMum>=200){
		$("font_num_title span").html("0")
	}
})


</script>
</body>
</html>




