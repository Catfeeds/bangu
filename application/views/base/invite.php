<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>邀请管家服务_会员中心-帮游旅行网</title>
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
<script type="text/javascript"	src="<?php echo base_url('static/js/eject_sc.js');?>"></script>
</head>
<style>
.abb{ color: #fff; border-bottom: 2px solid #ffae00 !important; color: #ffae00;}
.fuwu li{ padding: 0 !important;}
.fuwu li a{ display: block; padding: 0 20px; border-bottom: 2px solid #fff;}

.over{ overflow:hidden;}
.view_service_box{ width:100%; height:100%; background:url(../../../../static/img/plugins/fancybox_overlay.png); position:fixed; top:0; z-index: 1000;}
.view_content{ position:relative;}
.view_service{ width:600px; height:420px; background:#fff; margin:0 auto; position: absolute; left:50%; margin-left:-300px; top:50%; margin-top:-200px;}
.view_close{ background: url(../../../../static/img/plugins/fancybox_sprite.png) no-repeat; position: absolute; right:-18px; top:-18px; width:36px; height:36px; z-index:100;}

.inc_xixi{ padding-left:2em;}
.inc_xixi li{ height:20px; line-height:20px; margin:5px 0}
.inc_xixi li span{ width:80px; text-align:right; float:left}
.inc_xixi li i{ color:#666;}
.door_line_title{ width:100%; background:#f2f2f2; margin:10px 0 10px 0; height:30px; line-height:30px; text-indent:2em; float:left}

.door_stars{ height:30px; float:left}
.door_stars li{ background:url(../../../../static/img/page/star.png) no-repeat; width:20px; height:20px; float:left;}
.door_title{ width:600px; text-align:center; height:30px; line-height:30px; font-size:16px; background:#e4e4e4;}
.hover{ background:url(../../../../static/img/page/star.png) no-repeat 0 -27px !important;}
.thisclick{ background:url(../../../../static/img/page/star.png) no-repeat 0 -27px;}
.pingfen{ float:left; width:90%; padding-left:5%;}
.grade{ color:#f54; float: left; padding-left:10px;}
.fenshu{ float:right; padding-right:120px;}
.door_text{ width:80%; margin-left:2em; height:80px; border:1px solid #e4e4e4; padding:5px; line-height:18px; font-size:12px; color:#666;}
.zishu_bix{ position:absolute; bottom:5px; right:96px;}
.clear_mun{ height:30px; line-height:30px;}

.door_submit{ margin-left:260px; width:60px; margin-top:10px;}
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
            <div class="user_title">未完成服务</div>
            <div class="consulting_warp">
                <div class="consulting_tab">
                    <div class="hd cm_hd clear" style="border:none;">
                        <ul class="click_par fuwu">
                            <li><a class="abb"  href="<?php echo base_url('base/invite_service/invite')?>">未完成</a></li>
                            <li ><a  href="<?php echo base_url('base/invite_service/complete_service')?>" >已完成</a> </li>
                            <li><a href="<?php echo base_url('base/invite_service/refused_service')?>">已拒绝</a></li>
                        </ul>
                    </div>
                    <div class="bd cm_bd">
                        <!-- tab 切换已点评时的内容 -->
                        <ul>
                            <table  class="common-table" style="position:relative;" border="0" cellpadding="0" cellspacing="0">
                                <thead class="common_thead">
                                    <tr>
                                        <th width="50" >编号</th>
                                        <th width="70">管家昵称</th>
                                        <th width="100">邀请服务地址</th>
                                        <th width="200">邀请时间</th>
                                        <th width="120">服务进度</th>
                                    </tr>
                                </thead>
                                <tbody class="common_tbody">
                                    <?php if($row){foreach ($row as $k=>$v){?>
                                    <tr>
                                        <td ><?php echo $v['sr_id']; ?></td>
                                        <td><?php echo $v['nickname']; ?></td>
                                        <td  class="cg_a" title="<?php echo $v['address']; ?>"><?php echo $str = mb_strimwidth($v['address'], 0,28, '...', 'utf8'); ?></td>
                                        <td ><?php echo  $v['addtime']?></td>
                                        <td ><?php if($v['progress']==1):?>
                                            邀请中
                                            <?php elseif($v['progress']==2):?>
                                            服务中
                                            <?php else:?>
                                            <a style="color:blue;cursor:pointer" id="comment_service" data-val="<?php echo $v['sr_id']?>" onclick="comment_service(this)">点评服务</a>
                                            <?php endif;?></td>
                                    </tr>
                                    <?php } }else{?>
                                    <!-- 以下是没有订单时的状态 -->
                                    <tr>
                                        <td class="order_list_active" colspan="5"><p class="cow-title">您最近没有邀请管家服务记录！</p></td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                            <div class="pagination">
                                <ul class="page">
                                    <?php if(!empty($row)){ echo $this->page->create_c_page();}?>
                                </ul>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- 右侧菜单结束 -->
    </div>
</div>

<!--点评服务弹框 -->

<div class="view_service_box" style="display:none;">
    <div class="view_service">
    <form id="comment_service_form" method="post" action="#">
    	<span class="view_close"></span>
        <div class="view_content">
        	<div class="door_title">点评服务</div>
            <ul class="inc_xixi">
                <li><span>邀请人&nbsp;:&nbsp;</span><i id="invitor"></i></li>
                <li><span>邀请时间&nbsp;:&nbsp;</span><i id="invite_date"></i></li>
                <li><span>服务时间&nbsp;:&nbsp;</span><i id="service_date"></i></li>
                <li><span>服务地址&nbsp;:&nbsp;</span><i id="service_address"></i></li>
            </ul>
            <div class="door_line_title">服务评分</div>
            <div class="pingfen">
                <ul class="door_stars">
                    <li value="1"></li>
                    <li value="2"></li>
                    <li value="3"></li>
                    <li value="4"></li>
                    <li value="5"></li>
                </ul>
                <div class="grade">一般</div>
                <div class="fenshu">管家评分<i class="fenshu_mun">0</i>分</div>

            </div>
            <div class="door_line_title">服务评论</div>
            <textarea name="comment_text" class="door_text" maxlength="150" placeholder="快来给本次服务评论吧!"></textarea>
            <span class="zishu_bix"><i class="clear_mun">150</i>/150</span>
        </div>
        <input type="hidden" name="service_id" id="service_id" value=""/>
        <input type="hidden" name="comment_score" id="comment_score" value="0"/>
        <input type="submit"  class="door_submit" value="提交点评"/>
        </form>
    </div>
</div>
<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
<script type="text/javascript">
function comment_service(obj){
	var sr_id = $(obj).attr('data-val');
	$("#service_id").val(sr_id);
	$.post("<?php echo base_url('base/invite_service/get_service_info')?>",{'service_id':sr_id},function(result){
	    result = eval('('+result+')');
                $("#invitor").html(result['nickname']);
                $("#invite_date").html(result['addtime']);
                $("#service_date").html(result['service_time']);
                $("#service_address").html(result['address']);
	});
	$(".view_service_box").fadeIn("slow");
	$("html").addClass("over");

	//关闭弹框
	$(".view_close").click(function(){
		$(".view_service_box").fadeOut("slow");
		$("html").removeClass("over");
	});
}

//---------------------------------移入星星------------------------------//
	$(".door_stars li").hover(function(){
		var thisVal=$(this).val()
		$(".door_stars li").each(function(){
			if($(this).val()<=thisVal){
				$(this).addClass("hover");
				$(".thisclick").css("background","url(../../../../static/img/page/star.png) no-repeat")
			}else{
				$(this).removeClass("hover");
				$(".thisclick").css("background","url(../../../../static/img/page/star.png) no-repeat")
			}
        });
		var thislen=$(".hover").length;
		//alert(thislen);
		if(thislen==1){
			$(".grade").html("失望")
		}
		if(thislen==2){
			$(".grade").html("不满")
		}
		if(thislen==3){
			$(".grade").html("一般")
		}
		if(thislen==4){
			$(".grade").html("满意")
		}
		if(thislen==5){
			$(".grade").html("惊喜")
		}
//---------------------移除星星--------------------------//
	},function(){
		$(".door_stars li").removeClass("hover");
		$(".thisclick").css("background","url(../../../../static/img/page/star.png) no-repeat 0 -27px")	;
		var thislen=$(".thisclick").length;
		//alert(thislen);
		if(thislen==1){
			$(".grade").html("失望")
		}
		if(thislen==2){
			$(".grade").html("不满")
		}
		if(thislen==3){
			$(".grade").html("一般")
		}
		if(thislen==4){
			$(".grade").html("满意")
		}
		if(thislen==5){
			$(".grade").html("惊喜")
		}
		if(thislen==0){
			$(".grade").html("")
		}
	});
//--------------------------------------点击星星-------------------------------//
	$(".door_stars li").click(function(){
		var thisclick=$(this).val();
		$(".door_stars li").each(function(){
			if($(this).val()<=thisclick){
				$(this).addClass("thisclick");
			}else{
				$(this).removeClass("thisclick").removeClass("hover");
			}
       		 });
		var thislen=$(".thisclick").length;
		if(thislen==1){
			$(".fenshu_mun").html("1")
		}
		if(thislen==2){
			$(".fenshu_mun").html("2")
		}
		if(thislen==3){
			$(".fenshu_mun").html("3")
		}
		if(thislen==4){
			$(".fenshu_mun").html("4")
		}
		if(thislen==5){
			$(".fenshu_mun").html("5")
		}
		if(thislen==0){
			$(".fenshu_mun").html("0")
		}
		$("#comment_score").val(thisclick);
	});
//--------------------------显示150字数------------------------//
	$(".door_text").keyup(function(){
		var thisMun=$(this).val().length;
		//alert(thisMun);
		if(thisMun<150){
			$(".clear_mun").html(150-thisMun);
		}else{
			$(".clear_mun").html("0");
		}
	});

	$("#comment_service_form").submit(function(){
	      $.post(
	        "<?php echo site_url('base/invite_service/comment_service');?>",
	        $('#comment_service_form').serialize(),
	        function(data) {
	          data = eval('('+data+')');
	          if (data.status == 200) {
	            alert(data.msg);
	            window.location="<?php echo base_url('base/invite_service/complete_service')?>";
	          } else {
	            alert(data.msg);
	          }
	        });
	      return false;
	});
</script>
</body>
</html>
