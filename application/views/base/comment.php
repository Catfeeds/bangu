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
.webuploader-pick{ width:102px; margin-left:0px; z-index:1000;}
.parentFileBox{ top:35px; height:80px;}
.parentFileBox>.fileBoxUl{ top:0px;}
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
								<li class="on yi_ping"><a
									href="<?php echo base_url('base/member/comment'); ?>">已点评（<i
										class="link_green"><?php if(isset($did['num'])){ echo $did['num'];}else{ echo 0;} ?></i>）</a>
                              						</li>
                            	<li class="wei_ping"><a href="<?php echo base_url('base/member/ncomment'); ?>">未点评（<i><?php if(isset($noid['num'])){ echo $noid['num'];}else{ echo 0;}?></i>）</a></li>
							</ul>
						</div>
						<div class="bd cm_bd yi_ment">
							<!-- tab 切换已点评时的内容 -->
								<table class="common-table" style="position: relative;"
									border="0" cellpadding="0" cellspacing="0">
									<thead class="common_thead">
										<tr>
											<th width="100"><span class="td_left">订单编号</span></th>
											<th width="200">产品标题</th>
											<th width="300">我的点评</th>
											<th width="150">点评时间</th>
											<th>线路评价</th>
											<th>管家评价</th>
											<th width="80">操作</th>
										</tr>
									</thead>
									<tbody class="common_tbody">
										<?php if (! empty ( $order )) {foreach ( $order as $k => $v ) {?>
										<tr class="tr">
									    	<td><?php echo $v['ordersn']; ?></td>
											<td width="200"><span class="td_left"> <a
                                                    <!-- 将cj,gn改为line,添加后缀.html-->
													<a href="<?php echo in_array(1 ,explode(',',$v['overcity'])) ? '/line/'.$v['line_id'].'.html' : '/line/'.$v['line_id'].'.html'; ?>"
													target="_blank" title="<?php echo $v['productname']; ?>"><?php echo   $str = mb_strimwidth($v['productname'], 0, 30, '...', 'utf8'); ?></a>
											</span></td>
											<td  width="300" >
												<span class="td_left" title="<?php echo $str = mb_strimwidth($v['content'], 0, 10000, '', 'utf8');?>"><?php echo $str = mb_strimwidth($v['content'], 0, 40, '...', 'utf8');?></span>
												<span class="td_left" title="<?php if(!empty($v['reply1'])){ echo '供应商回复：'.$str = mb_strimwidth($v['reply1'], 0, 100000, '...', 'utf8');}  ?>" style="color: blue"><?php if(!empty($v['reply1'])){ echo '供应商回复：'.$str = mb_strimwidth($v['reply1'], 0, 30, '...', 'utf8');}  ?></span>
												<span class="td_left" title="<?php if(!empty($v['reply2'])){ echo '平台回复：'.$str = mb_strimwidth($v['reply2'], 0, 100000, '...', 'utf8');}  ?>" style="color: red"><?php if(!empty($v['reply2'])){ echo '平台回复：'.$str = mb_strimwidth($v['reply2'], 0, 30, '...', 'utf8');}  ?></span>
												<span class="td_left" title="<?php if(!empty($v['reply'])){ echo '管家回复：'.$str = mb_strimwidth($v['reply'], 0, 100000, '...', 'utf8');}  ?>" style="color: blue"><?php if(!empty($v['reply'])){ echo '管家回复：'.$str = mb_strimwidth($v['reply'], 0, 30, '...', 'utf8');}  ?></span>
											</td>
											<td><?php echo $v['addtime']; ?></td>

											<td><?php if(!empty($v['avgscore1'])){ echo $v['avgscore1'].'分'; }else{ echo '0分';}?></td>
											<td><?php if(!empty($v['avgscore2'])){ echo $v['avgscore2'].'分';}else{echo '0分';} ?></td>

                                            							 <td class="detail_link">
											<?php if(isset($v['opare']) && $v['opare']>=1){ ?>
											<a data-val="<?php echo $v['cid']; ?>" class="evaluateButton" linename="<?php echo $v['productname']; ?>" href="#evaluateButton">编辑评论</a>
											<a data-val="<?php echo $v['cid']; ?>" class="on_comment" href="#on_comment">追评</a>
											<?php }else{ ?>
											<a data-val="<?php echo $v['cid']; ?>" class="on_comment" href="#on_comment">追评</a>
											<?php } ?>
											<a href="###" onclick="del_comment(<?php echo $v['cid'].','.$v['id']?>)">删除评价</a>
											</td>
										</tr>
										<?php } }else{?>
										<!-- 以下是没有点评记录时的状态 -->
										<?php if($type=='comment'){ ?>
										<tr>
											<td class="order_list_active" colspan="5">
												<p class="cow-title">您最近没有已点评记录！</p>
											</td>
										</tr>
										<?php }elseif($type=='without'){?>
										<tr>
											<td class="order_list_active" colspan="5">
												<p class="cow-title">您最近没有未点评记录！</p>
											</td>
										</tr>
									<?php  }}?>
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

	<!--编辑评论弹出层内容 -->
	<div id="evaluateButton" style="display: none; width: 720px;">
		<!-- 此处放编辑内容 -->
		<div class="eject_big">
			<div class="eject_back clear" style="height: auto;">
				<form class="form-horizontal" role="form" method="post"
					id="evaluateForm" onsubmit="return Checkevaluate();"
					action="<?php echo base_url();?>base/member/save_comment">

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
								<span>产品满意度:<i>50%</i></span>
							</div>
                            				<div class="title_info_txt title_info_txt2">
								<span>产品平均分:<i>2.5分</i></span>
							</div>
						</div>
					</div>
					<div class="eject-content_left fl">
						<div class="eject_content_left_s">

							<div class="eject_input_Slide">
								<textarea name="content1" class="content1" id="content1" maxlength="200"></textarea>
								<span class="font_num_title"><span>0</span><i>/200</i>
								</span>
							</div>
						</div>
					</div>

					<div class="eject_content2 fl">
						<div class="olumn">评价产品</div>
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
									<span style="color: #666;">服务态度:</span> <input type="hidden"
										name="serve" value="0" class="fwtd" />
									<ul class="score5">
										<li></li>
										<li></li>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</div>
							</div>
							<div class="expert_grade fl">
								管家评分:&nbsp;<span>0</span>&nbsp;分
							</div>
                           					<div class="eject_input_Evaluation fl">
								<textarea name="content2" class="content2"></textarea>
								<span class="font_num_title abs_tex"><span>0</span><i>/200</i>
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
								<input type="hidden" name="id" value="" id="comment_id" /> 
								<input type="hidden" name="type" value="updata" /> 
								<label class="hidden_name">
								<input type="checkbox" value="1" name="isanonymous" />匿名评价</label> 
								<input type="submit" name="submit" value="提交评价" class="commit" />
							</div>
						</div>
					</div>
			 		<script>
				 	   $(".content1,.content2").keyup(function(){
							var thisMum=$(this).val().length;
							//alert(thisMum);
							$(this).siblings(".font_num_title").find("span").html(200-thisMum);
							if(thisMum>=200){
								$("font_num_title span").html("0")
							}
						})
                   	</script>
			</div>
			</form>
		</div>
	</div>
	<!-- end -->

	<!-- 追评弹出层内容 -->
	<div id="on_comment" style="display: none; width: 500px; height: 290px;">
		<!-- 此处放编辑内容 -->
		<div class="bootbox-body">
		     <form class="form-horizontal" role="form" method="post" id="zhuipingForm"  action="<?php echo base_url();?>base/member/save_comment"  onsubmit="return CheckeCommentvalue();">
			      	  <div class="tousutitless">
				       <a href="#">
					   </a>
				  </div>
				  <input type="hidden" name="id" value="" />
				  <textarea class="zuiping" name="content1" placeholder="50字以内" ></textarea>
				  <input name="go_on" type="hidden" value="1">
				  <span class="tijiao_button fl"><input name="submit" type="submit"value="提交"/></span>
				  <span class="quxiao_button fl"><input class="guanbi" type="reset" value="取消"/></span>
		    </form>
		</div>
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
	var linename=$(this).attr('linename');
	var comment_line=$('.comment_line').html();
	$('.comment_line').html(comment_line+linename);
	var data=$(this).attr('data-val');
	$.post("<?php echo base_url('base/member/editcomment_ajax')?>", { data:data} , function(re) {
	var re =eval("("+re+")");
	if(re){
	json = eval(re.rows);
	for(var i=0; i<json.length; i++)
	{
	//匿名评论
	if(json[i].isanonymous==1){
	$('input[name="isanonymous"]').attr("checked", true);
	}else{
	$('input[name="isanonymous"]').attr("checked", false);
	}
	//旅行评论
	if(json[i].content){
	$('.content1').val(json[i].content);
	}else{
	$('.content1').val('');
	}

	//专家的评论
	if(json[i].expert_content){
	$('.content2').val(json[i].expert_content);
	}else{
	$('.content2').val('');
	}
	$('#comment_id').val(json[i].cid);

	//此段有冲突
	//星级数量
	var num1=json[i].score1;
	var num2=json[i].score2;
	var num3=json[i].score3;
	var num4=json[i].score4;
	var num5=json[i].score5;
	var num6=json[i].score6;

	var str='';
	var str2='';
	var str3='';
	var str4='';
	var str5='';
	var str6='';
	if(num1!='' && num1 !=0){
	for (var a = 0; a < json[i].score1 ; a++) {
		 var str=str+'<li class="hove"></li>';
	}
	for (var j = num1; j < 5; j++) {
		  var str=str+'<li></li>' ;
	};
	}else{
	 var str='<li></li><li></li><li></li><li></li><li></li>';
	}

	if(num2!='' && num2 !=0){
	for (var a = 0; a < json[i].score2 ; a++) {
		 var str2=str2+'<li class="hove"></li>';
	}
	for (var j = num2; j < 5; j++) {
		  var str2=str2+'<li></li>' ;
	};
	}else{
	 var str2='<li></li><li></li><li></li><li></li><li></li>';
	}
	if(num3!='' && num3 !=0){
	for (var a = 0; a < json[i].score3 ; a++) {
		 var str3=str3+'<li class="hove"></li>';
	}
	for (var j = num3; j < 5; j++) {
		  var str3=str3+'<li></li>' ;
	};
	}else{
	 var str3='<li></li><li></li><li></li><li></li><li></li>';
	}
	if(num4!='' && num4 !=0){
	for (var a = 0; a < json[i].score4 ; a++) {
		 var str4=str4+'<li class="hove"></li>';
	}
	for (var j = num4; j < 5; j++) {
		  var str4=str4+'<li></li>' ;
	};
	}else{
	 var str4='<li></li><li></li><li></li><li></li><li></li>';
	}
	if(num5!='' && num5 !=0){

	for (var a = 0; a < json[i].score5 ; a++) {
		 var str5=str5+'<li class="hove"></li>';
	}
	for (var j = num5; j < 5; j++) {
		  var str5=str5+'<li></li>' ;
	};
	}else{

	 var str5='<li></li><li></li><li></li><li></li><li></li>';
	}
	if(num6!='' && num6 !=0){

	 for (var a = 0; a < json[i].score6 ; a++) {
	 	 var str6=str6+'<li class="hove"></li>';
	 }
	 for (var j = num6; j < 5; j++) {
	 	  var str6=str6+'<li></li>' ;
	 };
	}else{

		 var str6='<li></li><li></li><li></li><li></li><li></li>';
	}
	$('.score0').html(str);
	$('.score1').html(str2);
	$('.score2').html(str3);
	$('.score3').html(str4);
	$('.score4').html(str5);
	$('.score5').html(str6);
	//星级数量end

	//专家评价
	$("input[name='Fruit']").each(function(){
	var v = $(this).val();
	var test= Math.floor(json[i].score5);
	if(test==v){
	$(this).attr("checked",true);
	}else{
	$(this).attr("checked",false);
	}
	});

	//图片的遍历
	var pic_str='';
	//   alert(json[i].pictures);
	if(json[i].pictures!=''){
	$('.Load_photo').remove();
	pic_str=pic_str+'<div class="Load_photo"><div class="parentFileBox"> <ul class="fileBoxUl"> ';
	if(json[i].pictures!=null){
		var pic_arr= new Array(); //定义一数组
		var pic_arr=json[i].pictures.split(",");
		for (n=0;n<pic_arr.length ;n++ )
		{
			pic_str=pic_str+'<li class="diyUploadHover" id="hidden_img'+n+'"><div class="viewThumb">' ;
			pic_str=pic_str+'<img alt="" src="'+pic_arr[n]+'"></div><input type="hidden" name="img[]" value="'+pic_arr[n]+'">' ;
			pic_str=pic_str+'<div data="'+n+'" class="diyCancel"></div></li> ' ;
		}
	}
	pic_str=pic_str+'</ul></div></div>' ;
	$('#demo').after(pic_str);
	}
	}



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
	buttonText : '<div class="img_num" style="border:1px solid #ff6600; background:#fff; color:#000; border-radius:3px; height:24px; line-heighr:24px; width:100px;color:#666;">上传图片<span>(<i>0</i>/5)</span></div>',
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

	//$("#evaluateButton").html(result);
	$(".diyCancel").click(function() {
	var n=$(this).attr('data');
	if(n>=0){
	$('#hidden_img'+n).remove();
	}
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
	});


	//管家评分

	$(" .score4 li").click(function(){
	var index = $(this).index();
	var val =$(".zyd").val();
	var count2 = parseInt($(".fwtd").val());
	var count;
	val =index+1;
	$(".zyd").val(val);
	count = (val+count2)/2;
	if(count2!=0){
	$(".expert_grade").show();
	$(".expert_grade span").html(count);
	}
	});
	$(".score5 li").click(function(){
	var index = $(this).index();
	var val = $(".fwtd").val();
	var count1 = parseInt($(".zyd").val());
	val =index+1;
	$(".fwtd").val(val);
	count = (count1+val)/2;
	if(count1!=0){
	$(".expert_grade").show();
	$(".expert_grade span").html(count);
	}
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
	} );

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
					var result =eval("("+result+")");
						$('.tousutitless').find('a').html(result.data.productname);
						$('#zhuipingForm').find('input[name="id"]').val(result.data.cid);
				}
			});
		});
	} catch (err) {

	}


	})(jQuery)
})
	//保存追评
    function CheckeCommentvalue(){

    	//不能超过100个字
        var content1= $('.zuiping').val();
        if(''==content1){
            alert('追评内容不能为空！');
            return false;
        }else{
    			//不能超过100个字
    		 var str=content1;
    		 var realLength = 0, len = str.length, charCode = -1;
    		 for (var a = 0; a < len; a++) {
    		 charCode = str.charCodeAt(a);
    		 if (charCode >= 0 && charCode <= 128)
    		 		realLength += 1;
    		 		else realLength += 1;
    		 }
	    	 if(realLength>50){
	    		alert('追评内容不能超过50个字');
	    		return false;
	    	 }
        }
    	jQuery.ajax({ type : "POST",data : jQuery('#zhuipingForm').serialize(),url : "<?php echo base_url();?>base/member/save_comment",
    		success : function(response) {
    			if(response){
    				alert( '提交成功！' );
    				location.reload();

    			}else{
    				alert( '失败失败' );
    				location.reload();
    			}
    		}
    	});
    	return false;
     }
     //关闭追评
   $(".guanbi").click(function(){
      $(".fancybox-overlay").hide();
    })
	//保存编辑评论
	function Checkevaluate(){
		//content1
		var content1= $('.content1').val();
		if(content1 !=''){
			/*  alert('评价线路不能为空！');
			return false;
			}else{ */
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
		//content1
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
		jQuery.ajax({ type : "POST",data : jQuery('#evaluateForm').serialize(),url : "<?php echo base_url();?>base/member/save_comment",
			success : function(response) {
				if(response){
					alert( '保存成功！' );
					location.reload();
					$('.fancybox-close').click();
				}else{
					alert( '保存失败' );
					location.reload();
					$('.fancybox-close').click();

				}
			}
		});

		return false;
	}



/* $(".click_par li").click(function(){
	$(this).addClass("on").siblings().removeClass("on");
	$(".link_green").removeClass("link_green");
	$(this).find("a").find("i").addClass("link_green")
}) */
</script>
<script>
$(".wei_ping").click(function(){
	$(".yi_ment").hide();
	$(".wei_ment").show();
});
$(".yi_ping").click(function(){
	$(".wei_ment").hide();
	$(".yi_ment").show();
});
//删除评论
function del_comment(id,orderid){
           if (!confirm("确定要删除该评价？")) {
                   window.event.returnValue = false;
       	}else{
       		if(id>0){
       			$.post("<?php echo site_url('order_from/order/del_line_comment')?>",{'id':id,'orderid':orderid},function (data) {
				var data = eval('('+data+')');
				if (data.status == 1) {
					alert(data.msg);
					location.reload();
				} else {
					alert(data.msg);
				}
			})

       		}else{
       			alert('删除失败!');	
       		}
       	}
       	return false;
}

</script>
</body>
</html>



