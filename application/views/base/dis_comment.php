<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的点评</title>
<link rel="icon" href="<?php echo site_url('/bangu.ico'); ?>" type="image/x-icon"/>
<link href="<?php echo base_url('static/css/common.css'); ?>"rel="stylesheet" />
<link href="<?php echo base_url('static/css/index.css'); ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/rest.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/user/user.css');?>" rel="stylesheet" />
<link type="text/css" href="<?php echo base_url('static/css/plugins/jquery.fancybox.css');?>" rel="stylesheet" />
<!--  弹框评论的样式 -->
<link href="<?php echo base_url('static'); ?>/css/line_detail.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('static'); ?>/css/plugins/diyUpload.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('static/js/jquery-1.11.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/user.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/jquery.fancybox.pack.js');?>"></script>
</head>
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
                    <div class="hd cm_hd clear">
                        <ul>
                            <li <?php if($type=='comment'){ echo 'class="on"';}?>><a
href="<?php echo base_url('base/member/comment'); ?>">已点评（<span
class="link_green">
                                <?php if(isset($did[0]['num'])){ echo $did[0]['num'];}else{ echo 0;} ?>
                                </span>） </a></li>
                            <li
<?php if(isset($type) && $type=='without'){ echo 'class="on"';}?>><a
href="<?php echo base_url('base/member/comment/without'); ?>">未点评（<span
class="link_green">
                                <?php if(isset($noid[0]['num'])){echo $noid[0]['num']; }else{ echo 0;} ?>
                                </span>） </a></li>
                        </ul>
                    </div>
                    <div class="bd cm_bd">
                        <!-- tab 切换已点评时的内容 -->
                        <ul>
                            <table class="common-table" style="position: relative;"
border="0" cellpadding="0" cellspacing="0">
                                <thead class="common_thead">
                                    <tr>
                                        <th width="300"><span class="td_left">订单信息</span></th>
                                        <th width="150">我的点评</th>
                                        <th width="200">点评时间</th>
                                        <th width="100">评分</th>
                                        <th width="">操作</th>
                                    </tr>
                                </thead>
                                <tbody class="common_tbody">
                                    <?php if (! empty ( $order )) {foreach ( $order as $k => $v ) {?>
                                    <tr class="tr">
                                        <td><span class="td_left"><a
href="<?php echo base_url('line/line_detail_'.$v['line_id'].'.html')?>"
target="_blank"><?php echo $v['productname']; ?></a></span></td>
                                        <td><?php echo   $str = mb_strimwidth($v['content'], 0, 40, '...', 'utf8'); ?></td>
                                        <td><?php echo $v['addtime']; ?></td>
                                        <td><?php if($v['level']==1){echo "差";}elseif($v['level']==2){echo "中";}elseif($v['level']==3){echo "好";} ?></td>
                                        <td><?php if(isset($v['status']) && $v['status']>=6){ ?>
                                            <a
data-val="<?php echo $v['cid']; ?>" class="evaluateButton"
href="#evaluateButton">编辑评论</a><br />
                                            &nbsp;&nbsp;&nbsp;<a
data-val="<?php echo $v['cid']; ?>" class="on_comment"
href="#on_comment">追评</a><br />
                                            <?php }else{ ?>
                                            <a
data-val="<?php echo $v['cid']; ?>"
name="<?php echo $v['cid']; ?>" class="dian_comment"
href="#dian_comment">&nbsp;&nbsp;&nbsp;点评</a><br />
                                            <?php } ?></td>
                                    </tr>
                                    <?php } }else{?>
                                    <!-- 以下是没有点评记录时的状态 -->
                                    <?php if($type=='comment'){ ?>
                                    <tr>
                                        <td class="order_list_active" colspan="5"><p class="cow-title">您最近没有已点评记录！</p></td>
                                    </tr>
                                    <?php }elseif($type=='without'){?>
                                    <tr>
                                        <td class="order_list_active" colspan="5"><p class="cow-title">您最近没有未点评记录！</p></td>
                                    </tr>
                                    <?php  }}?>
                                </tbody>
                            </table>
                            <div class="pagination">
                                <ul class="page">
                                    <?php if(! empty ( $order )){ echo $this->page->create_page();}?>
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
<!-- 点评弹出层内容 -->
<div id="dian_comment" style="display: none; width: 800px; height: 500px;">
    <!-- 此处放编辑内容 -->
    <div class="eject_big">
        <div class="eject_back clear">
        <form class="form-horizontal" role="form" method="post"
id="commentForm" onsubmit="return Checkcomment();"
action="<?php echo base_url();?>base/member/save_comment">
            <div class="eject_title">发布点评</div>
            <div class="eject_content clear">
                <div class="eject-content_left fl">
                    <div class="eject_content_left_s">
                        <h3>请您对此次旅行进行评价</h3>
                        <div class="eject_input_Slide">
                            <textarea name="comment"></textarea>
                        </div>
                    </div>
                </div>
                <div class="eject_content_right fr">
                    <div class="eject_right_one">
                        <div class="eject_xx_box" value='0'> <span>导游服务:</span>
                            <ul class="c_score0">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                        </div>
                        <div class="eject_right_one">
                            <div class="eject_xx_box" value='1'> <span>行程安排:</span>
                                <ul class="c_score1">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                        <div class="eject_right_one">
                            <div class="eject_xx_box" value='2'> <span>餐饮住宿:</span>
                                <ul class="c_score2">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                        <div class="eject_right_one">
                            <div class="eject_xx_box" value='3'> <span>旅游交通:</span>
                                <ul class="c_score3">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                        <div class="eject_right_one">
                            <div class="eject_xx_box" value='4'> <span>综合评价:</span>
                                <ul class="c_score4">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="eject_content clear">
                <div id="demo">
                    <div id="as"></div>
                </div>
                <div class="eject_content2 clear">
                    <div class="eject_content_left-x clear">
                        <h3>请您对您管家进行评价</h3>
                        <div class="eject_Satisfied">
                            <label>
                                <input name="Fruit" type="radio" value="1" />
                                失望 </label>
                            <label>
                                <input name="Fruit" type="radio" value="2" />
                                不满意 </label>
                            <label>
                                <input name="Fruit" type="radio" value="3" />
                                一般 </label>
                            <label>
                                <input name="Fruit" type="radio" value="4" />
                                满意 </label>
                            <label>
                                <input name="Fruit" type="radio" value="5" />
                                超赞 </label>
                        </div>
                        <div class="eject_input_Evaluation">
                            <textarea name="expert_comment"></textarea>
                        </div>
                        <div class="c_grades"></div>
                        <div class="eject_button">
                            <input type="hidden" name="hidden_id" value="" />
                            <input type="hidden" name="moid" value="" />
                            <input type="hidden" name="type" value="add"  />
                            <input type="submit" name="submit" value="提交评价" class="commit" />
                            <span class="close">关闭</span> </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </div>
</div>
<!-- end -->

<!-- 尾部 -->
<?php $this->load->view('common/footer'); ?>
</body>
</html>
<script src="<?php echo base_url('static'); ?>/js/eject_sc.js" type="text/javascript"></script>
<script src="<?php echo base_url('static'); ?>/js/diyUpload.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('static'); ?>/js/webuploader.html5only.min.js"></script>
<script type="text/javascript">
/**************************     图片上传     ******************************/
/*
* 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
* 其他参数同WebUploader
*/



$(function() {

(function() {

//点评
try {
$(".dian_comment").fancybox();
$(".dian_comment").click(function() {
$('.c_score0 li').removeClass('hove');
$('.c_score1 li').removeClass('hove');
$('.c_score2 li').removeClass('hove');
$('.c_score3 li').removeClass('hove');
$('.c_score4 li').removeClass('hove');
var data=$(this).attr('data-val');
var name=$(this).attr('name');
$('input[name="hidden_id"]').val(data);
$('input[name="moid"]').val(name);

$('#as').diyUpload({
url:"<?php echo base_url('line/line_detail/upfile')?>",
success:function( data ) {
console.info( data );
},
error:function( err ) {
console.info( err );
},
buttonText : '+ 5/5图片上传',
chunked:true,
// 分片大小
chunkSize:512 * 1024,
//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
fileNumLimit:5,
fileSizeLimit:500000 * 1024,
fileSingleSizeLimit:50000 * 1024,
accept: {}
});
});

}catch (err) {
}

})(jQuery)
})

//保存点击评论
function Checkcomment(){

//获取星级分数
var score0=$(".c_score0 .hove").length;
var score1=$(".c_score1 .hove").length;
var score2=$(".c_score2 .hove").length;
var score3=$(".c_score3 .hove").length;
var score4=$(".c_score4 .hove").length;
var str='';
str=str+'<input type="hidden" name="score0" value="'+score0+'" /><input type="hidden" name="score1" value="'+score1+'" />';
str=str+'<input type="hidden" name="score2" value="'+score2+'" /><input type="hidden" name="score3" value="'+score3+'" />';
str=str+'<input type="hidden" name="score4" value="'+score4+'" />';

$('.c_grades').html(str);
jQuery.ajax({ type : "POST",data : jQuery('#commentForm').serialize(),url : "<?php echo base_url();?>base/member/save_diancomment",
success : function(response) {
if(response){
alert( '保存成功！' );
location.reload();
$('.fancybox-close').click();
}else{
$('.fancybox-close').click();
location.reload();
alert( '保存失败' );

}
}
});

return false;

}

/*$('.webuploader-pick').mouseenter(function(){
$('.webuploader-pick').addClass('webuploader-pick-hover');
});

$('.webuploader-pick').mouseleave(function(){
$('.webuploader-pick').removeClass('webuploader-pick-hover');
});*/

</script>