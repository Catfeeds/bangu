<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>旅游管家_私人旅游管家_定制旅游-帮游旅行网</title>
<meta name="keywords" content="旅游管家服务,私人旅游管家,定制旅游,旅游管家">
<meta name="description" content="帮游旅游网提供数万名旅游管家专业咨询服务和私人定制游服务，出境游、国内游、周边游、主题游超过五万种旅游定制产品供您选择。">
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url()?>static/css/common.css" rel="stylesheet" />
<link href="<?php echo base_url()?>static/css/expert_list.css" rel="stylesheet" />
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url()?>static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.lazyload.js'); ?>"></script>
<style>
.sex_baomi {font-size: 11px;font-weight: 400;color: #acacac;margin-left: 5px;font-family: "宋体";}
</style>
</head>
<body style=" background:#fff">
	<!-- 头部 -->
	<?php $this->load->view('common/header'); ?>
	<!-- 内容区 -->
	
		
			<div id="banner_expert" class="expert_list_banner" style="background: url(<?php echo base_url()?>static/img/page/haibao.jpg) no-repeat center top;"></div>
				
			<div class="container expert_list_box " style="margin-bottom: 50px; width: auto;">
			<div class="main">
			<div class="place">
				<span>您的位置：</span>
				<a href="<?php echo sys_constant::INDEX_URL?>">首页</a>
				<span class="_jiantou">></span><h1><a href="#">旅游管家</a></h1>
			</div>
			<div class="w_1200 clear">
				<!-- 条件搜索开始 -->
                                 <!-- 将guanj改为guanjia 魏勇编辑-->
				<form action="<?php echo site_url('guanjia') ?>" id="searchExpert" method="post">
				<div class="tiaoxuan clear expertSearch">
					<span class="tiaoxuan_txt">挑选管家</span><i class="line_img"></i>
					
					<span class="expert_area" style="margin-left: 10px;">所在地区:</span>
					<input type="text" value="<?php echo $cityName ?>" id="expertCityName" name="expertCityName" />
					<input type="hidden" name="expertCityId" id="cityNameId" value="<?php echo $cityId ;?>">
					<?php if (!empty($sexArr) && is_array($sexArr)):?>
					<div class="xingbie_box">
						<span>性别 :</span>
						<div id="expertAge" class="age_box">
							<div class="expertAge_box">
								<div class="expertAge_showbox expert_age"> 
								<?php if ($sex=='1') {echo ('男');} elseif($sex=='2') {echo '女';} else{echo '不限';}?>
								</div>
								<ul class="expertAge_option">
									<?php 
										foreach($sexArr as $key =>$val) {
											if ((!empty($sex) || $sex === 0) && $key == $sex) {
												echo '<li value="'.$key.'" class="selected">'.$val.'</li>';
											} else {
												echo '<li value="'.$key.'">'.$val.'</li>';
											}
										}
									?>
								</ul>
								<!-- 保存选择的管家年龄 -->
								<input type="hidden" value="<?php if(!empty($sex)) {echo $sex ;}?>" name="sex" />
							</div>
						</div>
					</div>
					<?php endif;?>
					
					<?php if(!empty($expertGrade)):?>
					<div class="jibie_box">
						<span>级别 :</span>
						<div id="expertAge" class="age_box">
							<div class="expertAge_box">
							<div class="expertAge_showbox expert_age">
								<?php if (array_key_exists($grade, $expertGrade)){echo $expertGrade[$grade];}else{echo '不限';}?>
							</div>
								<ul class="expertAge_option">
                                <?php
									foreach ( $expertGrade as $key =>$val ) {
										if ($key == $grade) {
											echo "<li value='{$key}' class='selected'>{$val}</li>";
										} else {
											echo "<li value='{$key}'>{$val}</li>";
										}
									}
								?>
                            </ul>
								<!-- 保存选择的管家级别 -->
								<input type="hidden" value="<?php echo $grade;?>" name="grade" />
							</div>
						</div>
					</div>
					<?php endif;?>
					<span class="productType">线路种类:</span>
					<input type="text" name="expertDestName" id="expertDestName" value="<?php if(!empty($destName)) {echo $destName;}?>" placeholder="产品类型" />
					<input type="hidden" name="expertDestId" id="expertDestId" value="<?php if(!empty($destId)){echo $destId;}?>">
					<!--上门服务-->
					<?php if(!empty($expertGrade)):?>
					<div class="jibie_box">
						<span>上门服务 :</span>
						<div id="visit_service" class="age_box">
							<div class="expertAge_box">
							<div class="expertAge_showbox expert_age"><?php if(array_key_exists($visit_service ,$regionArr)){echo $regionArr[$visit_service];} else {echo '不限';}?></div>
								<ul class="expertAge_option">
                                <?php
									foreach ( $regionArr as $key =>$val ) {
										if ($key == $visit_service) {
											echo "<li value='{$key}' class='selected'>{$val}</li>";
										} else {
											echo "<li value='{$key}'>{$val}</li>";
										}
									}
								?>
                           		</ul>
								<!-- 上门服务 -->
								<input type="hidden" value="<?php echo $visit_service?>" name="visit_service" />
							</div>
						</div>
					</div>
					<?php endif;?>
					<span class="expert_name">管家昵称:</span>
					<input type="text" name="expertName" value="<?php if(!empty($expertName)){echo $expertName;}?>" placeholder="管家昵称"
                     onkeyup=cleanSpelChar(this)>

					<!-- 排序 -->
					<input type="hidden" name="order" value="<?php echo empty($order) ? 1 : $order;?>" />
					<input type="hidden" name="page" value="<?php echo empty($page) ? 1 : $page;?>" />
					<i class="submitButton"></i>
				</div>
				</form>
				<!-- 条件搜索结束 -->
				<div class="left_content">
					<div id="toolbar_list" class="bgcolor" style="background-color: #f7f7f7;">
						<ul>
							<li class='<?php if($order==1){echo 'toolbaron';}?>' onclick="showOrder(1)"><a href="javascript:;">综合排行<i class="daoxu"></i></a></li>
							<li class='<?php if($order==2){echo 'toolbaron';}?>' onclick="showOrder(2)"><a href="javascript:;">年满意度<i class="daoxu"></i></a></li>
							<li class='<?php if($order==3){echo 'toolbaron';}?>' onclick="showOrder(3)"><a href="javascript:;">年销人数<i class="daoxu"></i></a></li>
							<li class='<?php if($order==4){echo 'toolbaron';}?>' onclick="showOrder(4)"><a href="javascript:;">年成交额<i class="daoxu"></i></a></li>	
						</ul>
						<input type="hidden" value="0" name="is_order" />
						<div id="pager_stats" class="page_new_ajax">
							<span><?php if(empty($page)){echo 0;}else{echo $page;}?>/<?php if(empty($page_count)){echo 0;}else{echo $page_count;}?></span>
							<a href="javascript:void(0);" id="prev_page"><span class="page_ico">&lt;</span></a>
							<a href="javascript:void(0);" id="next_page"><span class="page_ico">&gt;</span></a>
						</div>
					</div>
					<!-- 专家列表 -->
					<ul class="list_experts_item expert_list_page">
						<?php 
							if (!empty($expertData) && is_array($expertData)):
							foreach($expertData as $key=>$val):
						?>
						<li>
						<div class="box_expert">
							<?php 
								if ($val['online'] == 0) {
									$src = base_url('static/img/page/lixian.png');
								} elseif ($val['online'] == 1) {
									$src = base_url('static/img/page/guapai.png');
								} elseif ($val['online'] == 2) {
									$src = base_url('static/img/page/zaixian.png');
								} 
							?>
							
                                                        <!-- seo优化，将guanj改为guanj/,将guanj/n改为guanjia/n.html-->
							<a href="<?php echo site_url('guanjia/'.$val['eid'].'.html')?>" target="_blank">
								<img class="photo" src="<?php echo base_url('static/img/loading1.gif')?>" data-original="<?php echo $val['small_photo']?>" alt="旅游管家<?php echo $val['nickname']?>" height="165" width="165">
							</a>
							<div class="profile">
								
								<div class="desc">
									<!--<img class="exp_state" src="<?php echo $src;?>" />-->
									<div class="content fl">
										<div class="flo_ri_lian">
											<a href="<?php echo site_url('guanjia/'.$val['eid'].'.html'.'#comment_record')?>" target="_blank" class="attrMore fl">查看评价(<?php echo $val['comment_count']?>)</a>
											<a href="<?php echo site_url('guanjia/'.$val['eid'].'.html')?>" target="_blank" class="attrMore fr allpaddri">
												<span>个人主页</span>
											</a>
										</div>
										<h3>
											<div class="exper_nama_list">
												<a href="<?php echo site_url('guanjia/'.$val['eid'].'.html')?>" target="_blank"><?php echo $val['nickname']?></a>
												<?php
													if ($val['sex'] == 1) {
														echo '<img src="'.base_url('static/img/page/n2.png').'" />';
													} elseif ($val['sex'] == 0) {
														echo '<img src="'.base_url('static/img/page/n1.png').'" />';
													} else {
														echo '<span class="sex_baomi">保密</span>';
													}
												?>
												
											</div>
											<span class="haopinglv col_red">
												<a style=" color:#333;">最高级别：</a>
												<a style=" background:#f30; color:#fff; height:20px; line-height:20px; display:inline-block; padding:0 5px;">
													<?php if (array_key_exists($val['grade'] ,$expertGrade)) {echo $expertGrade[$val['grade']];} else {echo '管家';} ?>
												</a>
											</span>
										</h3>
										<p class="text_box" title="<?php echo $val['talk']?>"><?php echo $val['talk']?></p>
									</div>
									<div class="fr zone_count">
										<p class="p1 padd_ri">
											<span class="txt">年满意度</span>
											<span class="count" style="font-size:15px;">
											<?php if($val['satisfaction_rate'] == 0 || $val['satisfaction_rate'] > 1) {echo '100';} else {echo round($val['satisfaction_rate']*100);}?>
											</span><i>%</i>
										</p>
										<p class="p1">
											<span class="txt">年销人数</span><span class="count" style="font-size:14px;"><?php echo $val['people_count']?></span><i>人</i>
										</p>
										<p class="p1">
											<span class="txt">年成交额</span><span class="count"><?php echo intval($val['order_amount'])?></span><i>元</i>
										</p>
										<p class="p1">
											<span class="txt">年总积分</span><span class="count"><?php echo $val['total_score']?></span><i>分</i>
										</p>
										<p class="link_button">
											<a href="<?php echo site_url('srdz/e-'.$val['eid'].'.html')?>" target="_blank">
												<span class="customButton">找我定制</span>
											</a>
											<a href="<?php echo $web['expert_question_url'].'/kefu_member.html?mid='.$this ->session ->userdata('c_userid').'&eid='.$val['eid']; ?>" target="_blank">
												<span class="consultButton">找我咨询</span>
											</a>
										</p>
									</div>
								</div>
								<p></p>
								<div class="attr">
									<i class="serviceImg fl"></i>
									<span class="span1 fl" title="擅长目的地：<?php echo $val['expertDest']?>">擅长目的地：<?php echo $val['expertDest']?></span>
									<i class="subjectImg fl"></i>
									<span class="sczt fl" title="免费上门服务：<?php echo $val['expertCity']?>">免费上门服务：<?php echo $val['expertCity']?></span>
									
								</div>
								
							</div>
						</div>
						</li>
						<?php endforeach;endif;?>
					</ul>
					<!-- 分页 -->
					<div>
						<ul class="pagination"><?php echo $page_string;?></ul>
					</div>
					<!-- 没有数据显示 -->
					<?php if(!isset($expertData) || empty($expertData)):?>
					<div class="searchNoExpert">
						<img src="<?php echo sys_constant::EXPERT_DEFAULT_PIC; ?>" />
					</div>
					<?php endif;?>
				</div>
				
				<!-- 定制记录开始 -->
				<div class="right_content" style=" width: 228px;">
					<div class="dingzhi">定制记录</div>
					<!-- 向上翻页 -->
					<div class="dztb customize_page_on"></div>
					
					<div class="renav" style=" overflow:hidden; height: 500px; position: relative;">
						<ul class="roll_box">
            			<?php foreach ( $customer_lines as $key => $val ) : ?>
							<li style=" height: 124px;"><div class="fangan customize_data">
                				<h2>管家
                                                    <!-- 将guanj改为guanjia,添加后缀.html 魏勇编辑-->
                					<a href="<?php echo base_url('guanjia/'.$val['e_id'].'.html');?>" class="expert_link">
                						<?php echo $val['nickname'] ?>
                					</a>已完成定制
								</h2>
								<div class="person">
									<div>
                                                                            <!-- 添加后缀.html-->
										<a href="<?php echo site_url('dzy/'.$val['id'].'.html')?>">
											<img width="60" height="60" src="<?php echo $val['litpic']?>" />
										</a>
										<h3><?php echo mb_substr($val['linkname'] ,0 ,1)?>**
											<span style="font-size: 12px; font-weight: normal;"><?php echo date('m-d H:i' ,strtotime($val['addtime']))?></span>
										</h3>
										<a href="<?php echo site_url('dzy/'.$val['id'].'.html')?>">
											<div style="width: 140px; height: 40px; float: left; overflow: hidden; line-height: 20px; margin-top: 2px;"><?php echo $val['question']?>...</div>
										</a>
									</div>
								</div>
								<div class="white"></div>
							</div></li>
            				<?php endforeach; ?>
            			</ul>
            		</div>
            		<!-- 向下翻页 -->
           			<div class="dztb2 customize_page_down"></div>
				</div>
				<!-- 定制记录结束 -->
			</div>
		</div>
	</div>
<?php $this->load->view('common/footer'); ?>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceAreaJson.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script type="text/javascript">
//地区获取
createChoicePlugin({
	data:chioceAreaJson,
	nameId:'expertCityName',
	valId:'cityNameId',
	isCallback:true,
	callbackFuncName:callbackFunc,
	blurDefault:true
});
//选择管家所在地后获取所在地的区域 
function callbackFunc() {
	$("#visit_service").find(".expertAge_showbox").html("不限");
	$("#visit_service").find("input[name='visit_service']").val("");
	var cityid = $("#cityNameId").val();
	$.post("/common/area/getRegionData",{cityid:cityid},function(data){
		var data = eval("("+data+")");
		var html = "<li data-val='0'>不限</li>";
		$.each(data ,function(key ,val){
			html += "<li data-val='"+val.id+"'>"+val.name+"</li>";
		})
		$("#visit_service").find("ul").html(html);
		$("#visit_service ul li").click(function(){
			$(this).addClass("selected");
			$("#visit_service").find(".expertAge_showbox").html($(this).text());
			$("#visit_service").find("input[name='visit_service']").val($(this).attr("data-val"));
			$("#visit_service").find("ul").hide();
		})
	})
}

//目的地
 $.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:'expertDestName',
		valId:'expertDestId',
		blurDefault:true
	});
});
function createUrl(page) {
	var page = typeof(page) == 'undefined' ? 1 : page;
	var cityid = $("#cityNameId").val();
	var cityName = $("#expertCityName").val();
	var sex = $("input[name=sex]").val();
	var grade = $("input[name=grade]").val();
	var desName = $("#expertDestName").val();
	var destid = $("#expertDestId").val();
	var visit_service = $("input[name=visit_service]").val();
	var nickname = $("input[name=expertName]").val();
	var order = $("input[name=order]").val();
	var url = '/guanjia/';            // 将guanj改为guanjia 魏勇编辑
	if (cityid >0 && cityName.length > 0) {
		url += '_c-'+cityid;
	}
	if (sex == 1 || sex == 2) {
		url += '_s-'+sex;
	}
	if (grade > 0) {
		url += '_g-'+grade;
	}
	if (destid >0 && desName.length > 0) {
		url += '_d-'+destid;
	}
	if (visit_service > 0) {
		url += '_vs-'+visit_service;
	}
	if (nickname.length > 0) {
		url += '_na-'+nickname;
	}
	if (page > 0) {
		url += '_p-'+page;
	}
	if (order > 0) {
		url += '_o-'+order;
	}
	if (url == '/guanjia/') {     // 将guanj改为guanjia 魏勇编辑
		location.href = '/guanjia/';    // 将guanj改为guanjia/ 魏勇编辑
	} else {
		location.href = url+'.html';
	}
}


//排序
function showOrder(type) {
	$(this).addClass("toolbaron").siblings().removeClass("toolbaron");
	$("input[name='order']").val(type);
	createUrl();
	return false;
}

$(".submitButton").click(function(){
	createUrl();
	return false;
})
var page_count = <?php if(!empty($page_count)){echo $page_count;}else{echo 0;}?>;

$("#prev_page").click(function(){
	var page = $(".pagination").find(".active").find("a").attr("page_new");
	if (typeof page == 'undefined') {
		return false;
	}
	page = Math.round(page*1 -1);
	page = page < 1 ? 1 : page;
	createUrl(page);
})

$("#next_page").click(function(){
	var page = $(".pagination").find(".active").find("a").attr("page_new");
	if (typeof page == 'undefined') {
		return false;
	}
	page = Math.round(page*1 +1);
	page = page > page_count ? page_count : page;
	createUrl(page);
})

$(".ajax_page").click(function(){
	if (!$(this).hasClass("active")) {
		var page = $(this).find("a").attr("page_new");
		createUrl(page);
		return false;
	}
})

</script>
<script type="text/javascript">
  $(document).ready(function(){
  // 所有需要点击隐藏的元素
 var sourcePopEles=['.nianling_click','.xingbie_click','.jibie_click'];///点击源
  var popEles=['.nl_hidden','.xb_hidden','.jb_hidden'];  //弹出层
  $(document).click(function(e){
    var target = $(e.target);
    var length = popEles.length  ;
    for(var i =0 ;i <length ;i++) {
      if(target.closest(sourcePopEles[i]).length > 0  ){ //点击源
        //如果点击源.或者点击弹出的层
        if ($(popEles[i]).is(':visible')) {
        	 $(popEles[i]).hide();
        } else {
        	 $(popEles[i]).show();
         }
        e.stopPropagation();
      }else if (target.closest(popEles[i]).length > 0 ){ //弹出层
        $(popEles[i]).hide();
        e.stopPropagation();
        //设置值
        var value = $(target).html() +"";/// 获取点击的值
        //设置到源的 input 里面
        $(sourcePopEles[i]).find("input").val(value) ;//展示
      } else if(target.closest(sourcePopEles[i]).length==0 &&  target.closest(popEles[i]).length == 0   ){
        //如果点击点不是源和弹出层
        $(popEles[i]).hide();
      }
    }
  });
});
</script>
<script type="text/javascript">
$(function(){
	//下拉框效果
	var foo=true;
	$(".expertAge_showbox").click(function(){
		$(".expertAge_showbox").siblings(".expertAge_option").hide();
		$(this).siblings(".expertAge_option").show();
	});
	$(".expertAge_option li").click(function(){
        var values=$(this).html();
		var val = $(this).attr("value");
 		$(this).parent().hide();
 		$(this).addClass('selected').siblings().removeClass('selected');
 		$(this).parent().siblings("input").val(val);
 		$(this).parent().prev("div").html(values);
	});
	 $(document).mouseup(function(e) {
          var _con = $('.expertAge_box'); // 设置目标区域
          if (!_con.is(e.target) && _con.has(e.target).length === 0) {
              $(".expertAge_box").find("ul").hide()
          }
      })
});
</script>
<script>
    //懒加载
    $(function(){
        $("img").lazyload({
            effect : "fadeIn"
        });
    })
</script>
<script>
// 定制记录 滚动效果
$(function(){ 
	var $this = $(".renav"); 
	var liLen = $(".roll_box li").length;
	var scrollTimer; 
	$this.hover(function(){ 
			clearInterval(scrollTimer); 
		},function(){ 
			scrollTimer = setInterval(function(){ 
				if(liLen<5){
					clearInterval(scrollTimer); 
				}else{
					scrollNews( $this ); 
				}
		}, 2000 ); 
	}).trigger("mouseleave"); 
	
	
function scrollNews(){ 
	var $this = $(".renav"); 
	var $self = $this.find("ul"); 
	var lineHeight = $self.find("li:first").height(); 
	$self.animate({ "margin-top" : -lineHeight +"px" },600 , function(){ 
		$self.css({"margin-top":"0px"}).find("li:first").appendTo($self); 
	}) 
	
} 

}); 

function cleanSpelChar(th){     
    if(/["'<>%;)(&+/*-=_]/.test(th.value)){           
    $(th).val(th.value.replace(/["'<>%;)(&+*-/=_]/,""));     
    } 
}

</script>
</body>
</html>