<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>旅游体验师_<?php echo $experience_data['m_name']?>的个人旅游足迹—帮游旅行网</title>
<meta name="description" content="帮游旅行网旅游体验师<?php echo $experience_data['m_name']?>的个人旅游攻略、旅游计划分享主页，你可以在这看到该体验师的全部旅游足迹。" />
<meta name="keywords" content="旅游体验师,旅游攻略,旅行计划" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static'); ?>/css/common.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url('static'); ?>/css/experience_list.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<!--头部-->
 <?php $this->load->view('common/header'); ?>
<div class="Individual_position">您的位置:<a  href="<?php echo sys_constant::INDEX_URL?>">首页</a><span class="right_jiantou">></span><a href="<?php echo base_url('experience/member_experience')?>">体验师</a><span class="right_jiantou">></span>个人主页</div>
<div class="Individual_main clear">
    	<div class="Individual_left">
            <?php if(!empty($experience_data)):?>
        	<div class="Individual_Head_photo"><img src="<?php echo $experience_data['m_pic']?>"/></div>
        	<div class="Individual_Detailed">
            	<div class="Indiv_Deta_name"><?php echo $experience_data['m_name']?>
                <span>
                    <?php if($experience_data['m_sex']==1):?>
		<img src="<?php echo base_url('static/img/page/boy.png'); ?>"/>
                     <?php else:?>
                         <img src="<?php echo base_url('static/img/page/girl.png'); ?>"/>
                     <?php endif;?>
                </span>
            </div>
                <div class="Indiv_Deta_Consul"><span><?php echo empty($experience_data['consult_count']) ? 0:$experience_data['consult_count']?>人</span>咨询过</div>
                <div class="Indiv_Deta_Experience">旅行经历<span><?php echo empty($experience_data['trip_count']) ? 0:$experience_data['trip_count']?>次</span></div>
                <div class="Indiv_Deta_Motto"><?php echo $experience_data['m_talk']?></div>
<!--            	<div class="Consultant_experience">咨询体验师</div>-->
                <!--<div class="Individual_ejeit">
                	<div class="Individual_ejeit_title">轻松扫一扫,解决旅途烦恼</div>
                    <img alt="" src="">
                 </div>-->
            </div>
        <?php endif;?>
            <div class="After_Place">足迹</div>

            <div id="more">
            <ul class="Indiv_Place_list">
            <?php if(!empty($experience_trip_data)):?>
           <?php foreach ($experience_trip_data as $item):?>
           	    <li>
                	<div class="Indiv_list">
                            	<div class="Indiv_list_Address clear">
                                    	       <img src="<?php echo base_url('static/img/page/live_place.png'); ?>"/>
                                            <a href="<?php echo site_url('/experience/travel_note_detail?id='.$item['line_id'])?>"><?php echo $item['title']?></a>
                                            <span class="cancle_experience" data-val="<?php echo empty($item['title'])?'普通咨询':$item['title'].'|'.$item['line_id'].'|'.$experience_data['me_id'];?>">咨询体验师</span>
                                    </div>
                                    <div class="Indiv_list_User">
                                    	       <span><?php echo empty($item['comment_count']) ? 0:$item['comment_count']?></span><img src="<?php echo base_url('static/img/page/pinglun.png'); ?>"/><span class="zan_num" id="zan_num"><?php echo empty($item['praise_count']) ? 0 :$item['praise_count']?></span><img class="zan_click" src="<?php echo base_url('static/img/page/zan.png'); ?>" onclick="zan_click(this)" data-val="<?php echo $user_id;?>" data-tid="<?php echo $item['tid']?>"/>
                                    </div>
                                    <p><?php echo $item['content']?></p>
                         </div>
                          <div class="Indiv_list_photo">
                                <?php if(!empty($item['trip_pic_arr'])):?>
                                    <?php foreach ($item['trip_pic_arr'] as $value):?>
                                       <img src="<?php echo $value?>"/>
                                     <?php endforeach;?>
                                 <?php endif;?>
                        </div>
                </li>
                <?php endforeach;?>
                <div class="Load_list" id="Load_list">
                    <?php if($experience_trip_count>4):?>
                        <a href="javascript:;" data-val="<?php echo $eid?>" data-page="2" onclick="show_more(this)">加载更多</a>
                        <img src="<?php echo base_url('static'); ?>/img/load.png"/>
                    <?php endif;?>
                </div>
            <?php else:?>
                <li></li>
            <?php endif;?>
           </ul>
           </div>
   		</div>
        <!--列表-->
    <div class="Individual_right">
    	<div class="news_latest_title">最新体验师动态</div>
        <ul class="news_latest_list">
        <?php if(!empty($experience_news)):?>
            <?php foreach ($experience_news as $item):?>
        	<li>
            	<img src="<?php echo $item['litpic']?>"/>
                <div class="news_latest_list_Explain"><span><?php echo $item['nickname']?></span><i>更新游记</i>“<?php echo $item['title']?>”</div>
            </li>
        <?php endforeach;?>
        <?php endif;?>
        </ul>
    </div>

</div>

<!--====================咨询体验师弹框=================== -->
<div class="private_letter_box">
	<div class="private_letter_content">
    	<span class="close_private_letter"><i></i></span>
    	<div class="private_title">咨询</div>
        <div class="write_content clear">
        <form id="consult_form" method="post">
        	<div class="private_object fl"><span class="title_name">发件人:</span><span class="title_name_content"><?php echo $this->session->userdata('c_username');?></span></div>
            <div class="private_object fr"><span class="title_name">收件人:</span><span class="title_name_content"><?php echo $experience_data['m_name']?></span></div>
            <div class="fl"><span class="title_name num_info">手机号:</span><input type="text" name="telphone" value="" class="write_input"/></div>
            <div class="fl"><span class="title_name num_info">微信号:</span><input type="text" name="weixin" value="" placeholder="请输入您的微信号" class="write_input"/></div>
            <div class="private_product_info fl"><span class="title_name">产品名称:</span><span id="product_name" class="title_name_content private_product_name"></span></div>
            <div class="fl" style="position:relative;"><span class="title_name">内容:</span><textarea name="question_txt" class="txt_content" placeholder="请编辑您要咨询的内容，100字以内"></textarea>
            	<span class="font_num_title">已写<i>0</i>字</span>
            </div>

            <div class="submit_button fl">
            <input type="hidden" name="c_line_id"  id="c_line_id" value=""/>
            <input type="hidden" name="me_id"  id="me_id" value=""/>
            <input type="submit" name="submit" value="发送" class="send_letter"/><input type="reset" class="cancel"/>
            	<span class="cancel_button">取消</span>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="bg_box"></div>

<!--尾部图片-->
<?php  echo $this->load->view('common/footer'); ?>
<script type="text/javascript">
$(function(){
	//咨询体验师弹框
	$(".cancle_experience").click(function(){
                           var line_title = $(this).attr('data-val').split('|');
                           $('#product_name').html(line_title[0]);
                           $('#c_line_id').val(line_title[1]);
                           $('#me_id').val(line_title[2]);
		  $(".private_letter_box,.bg_box").show();
	});
	$(".close_private_letter").click(function(){
                            $('#product_name').html('');
                            $('#c_line_id').val('');
		$(".private_letter_box,.bg_box").hide();
	});

	$(".close_private_letter").hover(function(){
		$(this).addClass("hover_this");
	},function(){
		$(this).removeClass("hover_this");
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
});


function show_more(obj){
    var html = "";
    var eid = $(obj).attr('data-val');
    var page = $(obj).attr('data-page');
    $.post(
        "<?php echo site_url('experience/exper_detail/get_more_trip');?>",
         {'eid':eid,'page':page},
        function(data){
            data = eval('('+data+')');
                if(data.length>0){
                    $.each(data ,function(key ,val){
                        if(val['comment_count']==null || val['comment_count']==undefined){
                            val['comment_count']=0;
                        }
                        if(val['praise_count']==null || val['praise_count']==undefined){
                            val['praise_count']=0;
                        }
                        html += "<li><div class='Indiv_list'><div class='Indiv_list_Address clear'><img src='<?php echo base_url('static/img/page/live_place.png'); ?>'/>";
                        html += "<a href='#'>"+val['title']+"</a><span class='cancle_experience'>咨询体验师</span></div>";
                        html += "<div class='Indiv_list_User'><span>"+val['comment_count']+"</span><img src='<?php echo base_url('static/img/page/pinglun.png'); ?>'/>";
                        html += "<span class='zan_num'>"+val['praise_count']+"</span><img class='zan_cilck' src='<?php echo base_url('static/img/page/zan.png'); ?>'/></div>";
                        html += "<p>"+val['content']+"</p></div>";
                        html += "<div class='Indiv_list_photo'>";
                        if(val['trip_pic_arr']!=null && val['trip_pic_arr']!=undefined){
                            $.each(val['trip_pic_arr'],function(k,v){
                                  html += "<img src='"+v+"'/>";
                            });
                        }
                        html += "</div> </li>";
                    });
                    page++;
                    $(obj).attr('data-page',page);
                    $(obj).parent().before(html);
            }else{
                $("#Load_list").hide();
            }
        });
}

		$(function () {
            $(".news_latest_list li").mouseleave(function () {
                $(this).find(".news_latest_list_Explain").hide();
            });
            $(".news_latest_list li").mouseover(function () {
                $(this).find(".news_latest_list_Explain").show();
            });
        });

		$(function () {
            $(".Consultant_experience").focus(function () {
                $(".Individual_ejeit").hide();
            });
            $(".Consultant_experience").mouseout(function () {
                $(".Individual_ejeit").show();
            });
        });


//点赞数量变化
/*$(function(){
	$(".zan_click").click(function(){
		var zan_num = parseInt($(this).siblings(".zan_num").text());
		zan_num+=1;
		$(this).siblings(".zan_num").text(zan_num);
		//alert(zan_num);

		//点赞数量 传到后台处理
		 $.post(
                                "<?php echo site_url('experience/exper_detail/xxx');?>",
                                 {'praise_count':zan_num,},
                                function(data){

                                });
	           });
});*/


function zan_click(obj){
  var user_id = $(obj).attr('data-val');
  var note_id = $(obj).attr('data-tid');
  //alert(user_id);
  if(user_id==''){
     $('.login_box').css("display","block");
  }else{
        var zan_num = parseInt($("#zan_num").text());
        zan_num+=1;
         $.post(
                                "<?php echo site_url('experience/exper_detail/zan_opera');?>",
                                 {'note_id':note_id},
                                function(data){
                                    data = eval('('+data+')');
                                    if(data['status']==200){
                                        $("#zan_num").text(zan_num);
                                    }else if(data['status']==300){
                                        alert(data['msg']);
                                    }else{
                                        alert('点赞失败');
                                    }
                                });
                }
}

$("#consult_form").submit(function(){
$.post(
                "<?php echo base_url('experience/exper_detail/ask_experince');?>",
                $('#consult_form').serialize(),
                function(data) {
                    data = eval('('+data+')');
                    if (data.status == 200) {
                        alert(data.msg);
                        location.reload();
                    }else if(data.status == -400){
                        alert(data.msg);
                        $(".private_letter_box,.bg_box").hide();
                        $('.login_box').css("display","block");
                    } else {
                        alert(data.msg);
                    }
                });
return false;

});
</script>



