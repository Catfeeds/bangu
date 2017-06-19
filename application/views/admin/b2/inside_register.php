<!DOCTYPE html>
<html>
<head>
<title>注册</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta charset="utf-8">

<link href="<?php echo base_url(); ?>assets/css/registerb-2.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('static/css/w_960.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
<style>
input { line-height: 32px; }
#login_error { border-radius: 3px; background: red; text-align: center; font-weight: 600; color: #fff; display: none; }
.uploadFileBut1, .uploadFileBut2 { width: 49px; position: absolute; border: 1px solid #60af00;color: #000; height: 24px; text-align: center; margin-left: 110px; line-height: 22px; border-radius: 3px; cursor: pointer; margin-top: 6px; }
.uploadFileBut3 { padding: 5px; border-radius: 2px; height:22px; line-height: 22px; cursor: pointer; border: 1px solid #ccc; }
.uploadFileBut4 { border-radius: 2px; line-height: 26px; cursor: pointer; border: 1px solid #60af00 !important; height: 26px; }
.blanks .choiseDest { border: 1px solid #3385ff; padding: 3px 7px 3px 5px; line-height: 23px; margin-left: 10px; }
.blanks .choiseDest span { margin-left: 13px; color: red; cursor: pointer; }
.uploadFileBut1{}
.tile_prompt{ color: #f00; height: 20px; line-height: 20px; width: 1000px; margin:0 auto;}
.address_list label p { padding:3px 0 3px 48px;}
.erweima span { float:left;width:30px;margin-top:10px;padding-left:10px;}
.erweima div { float:left;width:350px;margin-top:10px;}
.erweima div p { margin-bottom:5px;}
</style>

</head>
<body style=" background: #f2f2f2;position: relative;">
<div class="bg">
    <div class="take_photo_box" style="height:auto;">
        <div class="box_header">申请免费拍照<span class="close_photo_box" onClick="close_photo_box(this)">×</span></div>
        <form action="" method="post" id="photo_shop_form">
            <div class="choose_address clear">
                <div class="erweima address_list"><img src="<?php echo base_url(); ?>file/qrcodes/0_qr.png"/>
                	<span>注：</span>
                	<div>
                    	<p>1、请自行将二维码截图保存，拍摄完成后提供给摄影师扫描确认。</p>
      					<p>2、二维码扫描确认后将失效，每人仅有一次拍摄机会，切记在拍摄前避免被误扫。</p>
                    </div>
                </div>
                <?php if(!empty($museum)){
                    foreach ($museum as $k=>$v){
                ?>
                <div class="address_list"><?php echo $k+1 ?>.<label><input type="radio" name="photo_shop" value="<?php echo $v['id'] ?>"/><span class="shop_name"><?php echo $v['name']; ?></span>—><span class="shop_address"><?php echo $v['address']; ?></span>
                		<p>联系人：<?php echo $v['linkman']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;联系电话：<?php echo $v['linkmobile']; ?></p>
                	</label>

                </div>
                <?php } }?>
                <div class="address_list"><span id="submit_address" onClick="click_submit(this);">确认</span><input type="submit" name="submit" value="确认" style="display:none;"/></div>
            </div>
        </form>
    </div>
</div>


<!--头部-->
<div  class="wa_wp">
    <div class="wa"> <a href="/"><img src="<?php echo base_url(); ?>static/img/logo.png" alt=""></a> <span class="wa_sapn_1">管家申请</span>
        <div><span class="wa_sapn_2"><a href="/admin/b2/login">管家登录</a></span><span class="wa_sapn_4"><a href="/">返回帮游旅行首页</a></span></div>
    </div>
<!--
    <script language="javascript">
function correctPNG(obj) {

    for(var i=0; i<document.images.length; i++){

        var img = document.images[i]
        var imgName = img.src.toUpperCase()
        if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
        {
        var imgID = (img.id) ? "id='" + img.id + "' " : ""
        var imgClass = (img.className) ? "class='" + img.className + "' " : ""
        var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
        var imgStyle = "display:inline-block;" + img.style.cssText
        if (img.align == "left") imgStyle = "float:left;" + imgStyle
        if (img.align == "right") imgStyle = "float:right;" + imgStyle
        if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
        var strNewHTML = "<span "+ imgID + imgClass + imgTitle + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";" + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader" + "(src='" + img.src + "', sizingMethod='scale');\"></span>"
        img.outerHTML = strNewHTML
        i = i-1
        }
    }
}

</script>
-->



</div>
<div class="wrap">
<div  class="wrap_top_cl"><span>管家申请</span></div>
<?php
	if (!empty($expert)) {
		if ($expert['status'] == 1) {
			echo '<div class="tile_prompt">您的申请正在审核中...</div>';
		} elseif ($expert['status'] == 3) {
			echo '<div class="tile_prompt">'.$expert['refuse_reasion'].'</div>';
		}
	}
?>
<!--<div class="tile_prompt">您的申请正在审核中...</div>-->
<div class="qieh_title">
	<?php if (!empty($expert)):?>
		<div class="jingnei">
	        <input type="radio" name="title" value="1" <?php if ($expert['type'] ==1) { echo 'checked';}?>>境内
	    </div>
	    <div class="jingwei">
	        <input type="radio" name="title" value="2"  <?php if ($expert['type'] ==2) { echo 'checked';}?>>境外
	    </div>
	<?php else:?>
	    <div class="jingnei">
	        <input type="radio" name="title" value="1" checked>境内
	    </div>
	    <div class="jingwei">
	        <input type="radio" name="title" value="2">境外
	    </div>
    <?php endif;?>
</div>
<form class="jingnei_box" <?php if (!empty($expert) && $expert['type'] != 1){echo 'style="display:none;"';}?>>
    <div class="reg_conment">
        <!--上面 -->
        <div class="conmen_top">
            <p style=" color:#f30">*为必填项 </p>
            <div class="enroll_title">
                <div class="enroll_perch"><!--占位符 --></div>
                <span>申请账号</span></div>
            <ul class="relative">
                <li class="relative"><span><i>*</i>手机号:</span>
                    <input type="text" name="mobile"  id="mosj" value="<?php if(!empty($expert['mobile'])) {echo $expert['mobile'];}?>" maxlength="11" class="shouji"/>
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">手机号用做登录名,不能为空</h3></div>
                    </div>
                </li>
                <li class="relative"><span><i>*</i>设置密码:</span>
                    <input type="password" name="password" maxlength="20" class="mima"/>
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">6-20位登录密码,区分大小写</h3></div>
                    </div>
                </li>
                <li class="relative"><span><i>*</i>确认密码:</span>
                    <input type="password" name="repass" maxlength="20" class="zaici"/>
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">两次密码相同</h3></div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="personal_details">
            <!--个人信息 -->
            <div class="enroll_title">
                <div class="enroll_perch"><!--占位符 --></div>
                <span>个人信息</span>您的个人隐秘信息将得到保护</div>
            <ul>
                <li class="relative">
                	<span><i>*</i>昵称:</span>
                	<input type="text" name="nickname" value="<?php if(!empty($expert)) {echo $expert['nickname'];}?>" maxlength="4" class="nicheng"/>
                    <div class="ti_box" style="width:105px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">只能输入2-4位汉字</h3></div>
                    </div>
                </li>
                <li style="width:285px;">
                	<span><i>*</i>性别:</span>
                    <div class="nan">
                    	<input type="radio" name="sex" value="1" <?php if (!empty($expert) && $expert['sex'] ==1){echo 'checked';}?> style=" width:12px;" class="last_border" />男
                    </div>
                    <div class="nv">
                    	<input type="radio" name="sex" value="0" <?php if (!empty($expert) && $expert['sex'] ==0){echo 'checked';}?> style=" width:12px;" class="last_border" />女
                    </div>
                </li>
                <li class="shangchuan2 width_auto">
                	<?php if (empty($expert)):?>
                	<span style=" width:100px; padding-top:3px"><i>*</i>上传头像:</span>
                    <div class="img_block" style="display:none;"><img src="../../../../static/img/Upload.jpg"></div>
                    <div onclick="uploadImgFile(this,2);" class="uploadFileBut2">上传</div>
                    <input type="hidden" name="photo" />
                    <?php else:?>
                    <span style=" width:100px; padding-top:3px"><i>*</i>上传头像:</span>
                    <div class="img_block" ><img src="<?php echo $expert['small_photo']?>"></div>
                    <div onclick="uploadImgFile(this,2);" class="uploadFileBut2">上传</div>
                    <input type="hidden" name="photo" value="<?php echo $expert['small_photo']?>" />
                    <?php endif;?>
                </li>
            </ul>
            <ul>
                <li class="relative">
                	<span><i>*</i>真实姓名:</span>
                	<input type="text" name="realname" value="<?php if(!empty($expert)) {echo $expert['realname'];}?>" class="xingming" />
                    <div class="ti_box" style=" width:96px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">可输入汉字和字母</h3></div>
                    </div>
                </li>
                <li class="relative" style="width:285px;">
                	<span><i>*</i>身份证号:</span>
                    <input type="text" name="idcard" maxlength="18" value="<?php if(!empty($expert)) {echo $expert['idcard'];}?>" class="shenfenid shenfenzheng" style=" width:175px;" />
                    <div class="ti_box" style=" width:124px; left:284px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">请输入18位身份证号码</h3></div>
                    </div>
                </li>
                <li class="shangchuan1 width_auto">
                	<?php if (empty($expert)):?>
                	<span style=" width:100px; padding-top:3px"><i>*</i>身份证扫描件:</span>
                    <div class="img_block" style="display:none;"><img src="../../../../static/img/Upload.jpg" class="img_fangda"></div>
                    <div onclick="uploadImgFile(this,1);" class="uploadFileBut1">上传</div>
                    <input type="hidden" name="idcardpic" />
                    <?php else:?>
                    <span style=" width:100px; padding-top:3px"><i>*</i>身份证扫描件:</span>
                    <div class="img_block" ><img src="<?php echo $expert['idcardpic']?>"></div>
                    <div onclick="uploadImgFile(this,1);" class="uploadFileBut1">上传</div>
                    <input type="hidden" name="idcardpic" value="<?php echo $expert['idcardpic']?>" />
                    <?php endif;?>
                </li>
            </ul>

        </div>
        <div class="conmen_top">
            <ul class="relative">
                <li class="relative">
                	<span><i>*</i>电子邮箱:</span>
                    <input type="text" value="<?php if(!empty($expert)) {echo $expert['email'];}?>" name="email" maxlength="100" class="youxiang" class="w_250" style="width:250px;" />
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">请输入邮箱格式</h3></div>
                    </div>

                <div class="file_ID_fan">
                    <span><i>*</i>身份证反面:</span>
                    <div onclick="uploadImgFile(this,1);" class="uploadFileBut1 fan">上传</div>
                    <?php if (empty($expert)):?>
                    <input type="hidden" name="idcardconpic" value="">
                    <img src="" class="fan_mian img_fangda" style="display: none;">
                    <?php else:?>
                    <input type="hidden" name="idcardconpic" value="<?php echo $expert['idcardconpic']?>">
                    <img src="<?php echo $expert['idcardconpic']?>" class="fan_mian img_fangda">
                    <?php endif;?>
                </div>
                </li>
                <li>
                	<span><i></i>微信号码:</span>
                	<input type="text" name="weixin" value="<?php if(!empty($expert)) {echo $expert['weixin'];}?>" class="w_250" />
                </li>
            </ul>
        </div>
        <!--旅游从业简历 -->
        <div class="conmen_zhong">
            <div class="blanks" style="width:375px;float: left; padding:10px 0;">
                <div class="Belongs_city"><span><i>*</i>所属城市:</span> <span id="expertAddress1" class="city_list_box"></span> </div>
            </div>
            <div class="visit_serve">
                <div class="blanks">
                    <div class="fl" style=" clear:both; width:auto; float:left;display:none;"><span class="fl" style="width:68px;"><i>*</i>上门服务:</span>
                        <ul class="chen_list visit_service_list">
                            <!--<li><input type="checkbox" name="visit_service[]" value="0" onclick="checkAll(this);">   全部</li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="Good_at_line">
                <div class="goog_goin">
                    <div id="create_box" class="create_box"></div>
                    <span class="goog_goin_title"><i>*</i>擅长线路:</span>
                    <div class="longs_blue" style=" adding-left: 10px;"/>最多选择5项目的地</div>
                    <input type="hidden" name="expert_dest" value="<?php if (!empty($expert)) {echo $expert['expert_dest'];}?>" id="expertDestId1">
                    <ul class="city_longs">
                       <?php
                       		if (!empty($expert)) {
                       			$defaultArr = explode(',' ,$expert['expert_dest']);
                       			foreach($destArr as $val) {
                       				if (!empty($val['lower'])) {
                       					echo '<li class="city_mune">'.$val['kindname'].'</li>';
                       					foreach($val['lower'] as $v) {
                       						if (in_array($v['id'], $defaultArr)) {
                       							echo '<li value="'.$v['id'].'" class="active-dest">'.$v['kindname'].'<i class="clixk_ok"></i></li>';
                       						} else {
                       							echo '<li value="'.$v['id'].'">'.$v['kindname'].'</li>';
                       						}
                       					}
                       				}
                       			}
                       		} else {
                       			foreach($destArr as $val) {
                       				if (!empty($val['lower'])) {
                       					echo '<li class="city_mune">'.$val['kindname'].'</li>';
                       					foreach($val['lower'] as $v) {
                       						echo '<li value="'.$v['id'].'">'.$v['kindname'].'</li>';
                       					}
                       				}
                       			}
                       		}
                       ?>
                    </ul>
                    <ul class="generated_city">
                        <?php
                        	if (!empty($dest)) {
                        		foreach($dest as $val){
                        			echo '<li value="'.$val['id'].'">'.$val['kindname'].'<span>X</span></li>';
                        		}
                        	}
                        ?>
                    </ul>

                </div>

            </div>
            <!--荣誉证书 -->
            <div class="conmen_zhong">
                <div class="mingtou">荣誉证书:</div>
                <span onclick="addCertificate(this);" class=" button_modality">添加</span><i class="color">注：外旅局授予证书、省市级优秀导游、旅游顾问证、导游资格证、领队资格证、旅行社部门经理资格证、旅行社总经理资格证</i>
                <div class="jingli_list list_two listCertificate">
                    <ul style="">
                        <li style=" width:448px;">证书名称</li>
                        <li style=" width:400px;">扫描件</li>
                        <li class="last_border" style=" width:48px;">操作</li>
                    </ul>
                    <?php if (empty($certificate)):?>
                    <ul>
                        <li style=" width:448px;">
                            <input style="width:400px; border-bottom: 1px solid #ccc;" type="text" name="certificate[]" placeholder="请输入证件名称" class="bornone">
                        </li>
                        <li style=" width:400px;">
                            <input type="button" onclick="uploadImgFile(this,3);"  value="上传" class="uploadFileBut4" style=" float: left; margin-left: 50px; margin-top: 3px;" >
                            <input type="hidden" name="certificatepic[]" readonly style="border:none;width:200px;" >
                        </li>
                        <li class="last_border" style="width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>
                    </ul>
                    <?php else:?>
                    	<?php foreach($certificate as $key=>$val):?>
                    	<ul>
                        <li style=" width:448px;">
                            <input style="width:400px; border-bottom: 1px solid #ccc;" value="<?php echo $val['certificate']?>" type="text" name="certificate[]" placeholder="请输入证件名称" class="bornone">
                        </li>
                        <li style=" width:400px;">
                            <input type="button" onclick="uploadImgFile(this,3);"  value="上传" class="uploadFileBut4" style=" float: left; margin-left: 50px; margin-top: 3px;" >
                            <?php echo $val['certificatepic']?>
                            <input type="hidden" value="<?php echo $val['certificatepic']?>" name="certificatepic[]" readonly style="border:none;width:200px;" >
                        </li>
                        <li class="last_border" style="width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>
                    </ul>
                    	<?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
            <!--个人描述 -->
            <div class="conmen_zhong relative">
                <div class="mingtou"><i>*</i>个人描述</div>
                <textarea class="text_num" placeholder="个人介绍展示，150字以内" maxlength="150" name="talk"><?php if(!empty($expert)){echo $expert['talk'];}?></textarea>
                <div class="num_info"><span>150</span><i>/150</i></div>
            </div>
            <!--个人简历 -->
            <div class="enroll_title">
                <div class="enroll_perch"><!--占位符 --></div>
                <span class="back_none">个人简历</span>专业的简历是您通过管家资质审核的关键
            </div>
            <div class=" color_red">以下显示于管家页面(旅游从业年限可累加并详述如下）</div>
            <div class="blanks " style=" padding-left:0;">
                <div class="vacancy">毕业院校
                    <input type="text" name="school" value="<?php if(!empty($expert)){echo $expert['school'];}?>" placeholder="学校名称"/>
                    &nbsp;&nbsp;,&nbsp;&nbsp;  旅游从业
                    <input type="text" placeholder="岗位名称" value="<?php if(!empty($expert)){echo $expert['profession'];}?>" name="job_name" />
                    &nbsp;&nbsp;,&nbsp;&nbsp;
                    <input type="text"placeholder="工作年限" value="<?php if(!empty($expert)){echo $expert['working'];}?>" name="year" />  年
                </div>
            </div>
            <div class="conmen_zhong" style="margin-top:10px;">
            <div class="title_box">
            	<span onclick="addExperience(this);" style=" margin-right:20px;" class=" button_modality">添加经历</span>
            	<i>以下不公开显示，仅做管家资质审核用（非旅游从业可不填）</i>
            </div>
            <div class="jingli_list listExperience" style="margin-left:20px;width: 980px;">
                <ul style=" width:980px;_width:980px;">
                    <li style=" width:200px;">起止时间</li>
                    <li style=" width:170px;">所在企业</li>
                    <li style=" width:100px;">职务</li>
                    <li style=" width:446px;">工作描述</li>
                    <li class="last_border" style=" width:48px;">操作</li>
                </ul>
                <?php if(empty($resume)):?>
                <ul style=" width:980px;_width:980px;">
                    <li style=" width:200px;">
                        <input type="text" placeholder="开始时间" readonly onclick="WdatePicker()" name="starttime[]" maxlength="10" style="ime-mode:disabled;">
                        <i class="col_bla">至</i>
                        <input type="text" readonly onclick="WdatePicker()" name="endtime[]" maxlength="10" style="ime-mode:disabled;" placeholder="结束时间">
                    </li>
                    <li style=" width:170px;">
                        <input type="text" name="company_name[]" placeholder="所在企业">
                    </li>
                    <li style=" width:100px;">
                        <input type="text" name="job[]" placeholder="职务">
                    </li>
                    <li style=" width:446px;">
                        <input type="text" name="description[]" placeholder="工作描述,限30个字以内" style="width:420px;" maxlength="30">
                    </li>
					<li class="last_border" style=" width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>
                </ul>
                <?php else:?>
                	<?php foreach($resume as $key=>$val):?>
                	<ul style=" width:980px;_width:980px;">
	                    <li style=" width:200px;">
	                        <input type="text" placeholder="开始时间" value="<?php echo $val['starttime']?>" readonly onclick="WdatePicker()" name="starttime[]" maxlength="10" style="ime-mode:disabled;">
	                        <i class="col_bla">至</i>
	                        <input type="text" readonly onclick="WdatePicker()" value="<?php echo $val['endtime']?>" name="endtime[]" maxlength="10" style="ime-mode:disabled;" placeholder="结束时间">
	                    </li>
	                    <li style=" width:170px;">
	                        <input type="text" value="<?php echo $val['company_name']?>" name="company_name[]" placeholder="所在企业">
	                    </li>
	                    <li style=" width:100px;">
	                        <input type="text" value="<?php echo $val['job']?>" name="job[]" placeholder="职务">
	                    </li>
	                    <li style=" width:446px;">
	                        <input type="text" value="<?php echo $val['description']?>" name="description[]" placeholder="工作描述,限30个字以内" style="width:420px;" maxlength="30">
	                    </li>
						<li class="last_border" style=" width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>
	                </ul>
                	<?php endforeach;?>
                <?php endif;?>
            </div>
        </div>

        <!--=======================  申请免费拍照  ======================= -->
        <div class="enroll_title">
            <div class="enroll_perch"><!--占位符 --></div>
            <span class="back_none" style="width:110px;">申请免费拍照</span>点击下面的申请按钮根据提示获取免费拍照资格
        </div>
        <div class="take_photos">
      		<input type="hidden" name="expert_qrcode" value="">
      		<input type="hidden" name="expert_museum" value="<?php if(!empty($expert_museum['mid'])){ echo $expert_museum['mid'];} ?>">
        	<?php if(empty($expert_qrcode)){ ?><span class="apply_take_photo" onclick="apply_take_photos(this);">申请拍照</span> <?php }?>
        	<?php if(!empty($expert_museum)){ ?>
        	<div class="photo_shop_info clear">
        	  <img src='<?php echo $expert_museum['qrcode'];?>' >
        	  <p style="margin-top:60px;" >凭此二维码免费拍照一张，申请后请于5个工作日内前往，请提前一天预约。</p>
        	  <p class="photo_shop_name" style="margin-top:20px;"><?php echo $expert_museum['name'];?></p>
        	  <p class="photo_shop_address" style="margin-top:20px;"><?php echo $expert_museum['address'];?></p>
        	  <input type="hidden" value="<?php  echo $expert_museum['mid'];?>">
        	</div>
        	<?php }?>
        </div>


          <div class="conmen_top" style=" padding-top:5px;">
            <ul class="relative">
                <li>
                	<span class="titl_head" style="width:64px;"><i>*</i>验证码:</span>
                	<input type="text" name="code" maxlength="18" style="width:150px;"/>
                	<img style="height:32px;margin-top:7px;border:1px solid #ccc; width:69px;" id='verifycode1' src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()">
                </li>
             <!--    <div class="huoqu_hidden" id="yanzheng">
            	<input class="yanzheng_shuru" type="text" name="vcode" maxlength="4" placeholder="输入四位验证码" style="ime-mode:disabled;">
            <div style="float:right; height:40px;width:91px;">
            	<img style="height:39px;border:1px solid #ccc; width:88px;" id='verifycode1' src="<?php echo base_url(); ?>tools/captcha/index" onclick="this.src='<?php echo base_url();?>tools/captcha/index?'+Math.random()">
            </div>
               <div class="tijiao" id="submitSendCode">提交</div>
                <div class="guanbi">关闭</div>
            <div class="info info3"><i></i><b></b></div>
            </div>
             -->
            </ul>
        </div>
            <div class="xieyi">
            <input type="checkbox" value="1" name="isAgree"/>
                同意<a href="/service/expert_agreement" target="_blank">&lt;&lt;帮游管家服务总则及合作协议&gt;&gt;</a></div>
            <input type="hidden" name="expert_id" value="<?php if(!empty($expert)){echo $expert['id'];}?>" />
            <input type="hidden" name="type" />
            <input type="hidden" name="resume_list" />
            <input type="hidden" name="certificate_list" />
            <input type="button" value="提交审核" onclick="submitForm(this);" class="jnbtns"/>
        </div>
    </div>
</form>
<!-- 境外管家注册 -->
<form class="jingwai_box" <?php if (empty($expert) || $expert['type'] != 2){echo 'style="display:none;"';}?>>
    <div class="reg_conment">
        <!--上面 -->
        <div class="conmen_top">
        <p style=" color:#f30">*为必填项 </p>
            <!--申请账号 -->
            <div class="enroll_title">
                <div class="enroll_perch"><!--占位符 --></div>
                <span>申请账号</span></div>
            <ul class="relative">
                <li class="relative"><span><i>*</i>邮箱号码:</span>
                    <input type="text" name="email" maxlength="60" value="<?php if (!empty($expert['email'])){echo $expert['email'];}?>" autofocus placeholder="" class="youxiang"  />
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">请输入邮箱格式</h3></div>
                    </div>
                </li>
                <li class="relative"><span><i>*</i>设置密码:</span>
                    <input type="password" name="password" maxlength="20" placeholder="" class="mima"/>
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">6-20位登录密码,区分大小写</h3></div>
                    </div>
                </li>
                <li class="relative"><span><i>*</i>确认密码:</span>
                    <input type="password" name="repass" maxlength="20" placeholder="" class="zaici"/>
                    <div class="ti_box">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">两次密码相同</h3></div>
                    </div>
                </li>

            </ul>
        </div>
        <div class="personal_details">
            <!--个人信息 -->
            <div class="enroll_title">
                <div class="enroll_perch"><!--占位符 --></div>
                <span>个人信息</span>您的个人隐秘信息将得到保护</div>
            <ul>
                <li class="relative"> <span><i>*</i>昵称:</span>
                    <input type="text" name="nickname" value="<?php if(!empty($expert)){echo $expert['nickname'];}?>" maxlength="5" class="nicheng"/>
                    <div class="ti_box" style="width:105px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">只能输入2-4位汉字</h3></div>
                    </div>
                </li>
                </li>
                <li style="width:285px;"><span><i>*</i>性别:</span>
                    <div class="nan">
                        <input type="radio" name="sex" value="1" <?php if (!empty($expert) && $expert['sex'] == 1){echo 'checked';}?> style=" width:12px;" class="last_border" />男</div>
                    <div class="nv">
                        <input type="radio" name="sex" value="0" <?php if (!empty($expert) && $expert['sex'] == 0){echo 'checked';}?> style=" width:12px;" class="last_border" />女</div>
                </li>
                <?php if (empty($expert)):?>
                <li class="shangchuan2 width_auto" style=" padding-top: 5px;"><span style=" width:100px; padding-top:3px"><i>*</i>上传头像:</span>
                    <div class="img_block" style="display:none;"><img src="../../../../static/img/Upload.jpg"></div>
                    <div onclick="uploadImgFile(this,2);" class="uploadFileBut2">上传</div>
                    <input type="hidden" name="photo" />
                </li>
                <?php else:?>
                <li class="shangchuan2 width_auto" style=" padding-top: 5px;"><span style=" width:100px; padding-top:3px"><i>*</i>上传头像:</span>
                    <div class="img_block"><img src="<?php echo $expert['small_photo']?>"></div>
                    <div onclick="uploadImgFile(this,2);" class="uploadFileBut2">上传</div>
                    <input type="hidden" name="photo" value="<?php echo $expert['small_photo']?>" />
                </li>
                <?php endif;?>
            </ul>
            <ul>
                <li class="relative">
                	<span><i>*</i>真实姓名:</span>
                	<input type="text" name="realname" value="<?php if(!empty($expert)){echo $expert['realname'];}?>" class="xingming" />
                    <div class="ti_box" style=" width:96px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">可输入汉字和字母</h3></div>
                    </div>
                </li>


                </li>
                <li class="relative" style=" width: 285px;">
                	<span><i>*</i>手机号码:</span>
                    <input type="text" name="mobile" maxlength="11" value="<?php if(!empty($expert)){echo $expert['mobile'];}?>" style="width:175px;"class="shouji" />
                    <div class="ti_box" style="left:284px; width:100px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">手机号用做登录名</h3></div>
                    </div>
                </li>
                <li style=" width: 305px;">
                	<span style=" width: 100px;"><i></i>微信号码:</span>
                	<input type="text" name="weixin" style="width:175px;" value="<?php if (!empty($expert)){echo $expert['weixin'];}?>"/>
                </li>

            </ul>
        </div>
        <div class="conmen_top">
            <ul class="relative">
                <li style="width:355px;"> <span><i>*</i>证件类型:</span><input type="text" name="idcardtype" value="<?php if(!empty($expert)){echo $expert['idcardtype'];}?>" /></li>

                <li class="relative"  style="width:285px;"><span><i>*</i>证件号码:</span>
                    <input type="text" name="idcard" maxlength="18" value="<?php if(!empty($expert)){echo $expert['idcard'];}?>" class="shenfenid zhengjian" style="width:175px;" />
                    <div class="ti_box" style=" width:86px; left:284px;">
                        <div class="tri"></div>
                        <div class="ti"><i class="tri_defa"></i><h3 class="html_jiwai">请输入证件号码</h3></div>
                    </div>
                </li>

                <?php if(empty($expert)):?>
                <li class="shangchuan1 width_auto" style="width:350px; padding-top: 5px;"><span style=" width:100px; padding-top:3px"><i>*</i>证件扫描件:</span>
                    <div class="img_block" style="display:none;"><img src="../../../../static/img/Upload.jpg" class="img_fangda"></div>
                    <div onclick="uploadImgFile(this,1);" class="uploadFileBut1">上传</div>
                    <input type="hidden" name="idcardpic" />
                </li>
                <?php else:?>
                <li class="shangchuan1 width_auto" style="width:350px; padding-top: 5px;"><span style=" width:100px; padding-top:3px"><i>*</i>证件扫描件:</span>
                    <div class="img_block"><img src="<?php echo $expert['idcardpic']?>"></div>
                    <div onclick="uploadImgFile(this,1);" class="uploadFileBut1">上传</div>
                    <input type="hidden" name="idcardpic" value="<?php echo $expert['idcardpic'];?>" />
                </li>
                <?php endif;?>
            </ul>
        </div>
        <!--旅游从业简历 -->
        <div class="conmen_zhong">
            <div class="blanks" style="width:360px;float: left; padding:10px 0;">
                <div class="Belongs_city"><span><i>*</i>所属城市:</span> <span id="expertAddress2" class="city_list_box"></span> </div>
            </div>
            <div class="visit_serve" style=" width:275px">
                <div class="blanks">
                    <div class="fl" style=" clear:both; width:auto; float:left"><span class="fl" style="width:68px;"><i>*</i>上门服务:</span>
                        <ul class="chen_list " style=" width:100px;">
            			    <li><input type='radio' name='visit_service' <?php if(!empty($expert['visit_service'])){echo 'checked';}?> value='1'>是</li>
						    <li><input type='radio' name='visit_service' <?php if(!empty($expert) && empty($expert['visit_service'])){echo 'checked';}?> value='0'>否</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="wai_box_fife">
                    <div class="file_ID_fan" style="top:0px;width:280px;">
                        <span style=" background:none;color:#666;"><i>*</i>身份证反面:</span>
                        <div onclick="uploadImgFile(this,1);" class="uploadFileBut1 fan">上传</div>
                        <?php if (empty($expert)):?>
	                    <input type="hidden" name="idcardconpic" value="">
	                    <img src="" class="fan_mian img_fangda" style="display: none;">
	                    <?php else:?>
	                    <input type="hidden" name="idcardconpic" value="<?php echo $expert['idcardconpic']?>">
	                    <img src="<?php echo $expert['idcardconpic']?>" class="fan_mian img_fangda">
	                    <?php endif;?>
                    </div>
                </div>
            <div class="Good_at_line">
                <div class="goog_goin">
                    <div id="create_box" class="create_box"></div>
                    <span class="goog_goin_title"><i>*</i>擅长线路:</span>
                    <input type="hidden" name="expert_dest" value="<?php if (!empty($expert)) {echo $expert['expert_dest'];}?>" id="expertDestId2" />
                  	<div class="longs_blue" style=" padding-left: 10px;"/>最多选择5项目的地</div>
                    <ul class="city_longs">
                       <?php
                       		if (!empty($expert)) {
                       			$defaultArr = explode(',' ,$expert['expert_dest']);
                       			foreach($destArr as $val) {
                       				if (!empty($val['lower'])) {
                       					echo '<li class="city_mune">'.$val['kindname'].'</li>';
                       					foreach($val['lower'] as $v) {
                       						if (in_array($v['id'], $defaultArr)) {
                       							echo '<li value="'.$v['id'].'" class="active-dest">'.$v['kindname'].'<i class="clixk_ok"></i></li>';
                       						} else {
                       							echo '<li value="'.$v['id'].'">'.$v['kindname'].'</li>';
                       						}
                       					}
                       				}
                       			}
                       		} else {
                       			foreach($destArr as $val) {
                       				if (!empty($val['lower'])) {
                       					echo '<li class="city_mune">'.$val['kindname'].'</li>';
                       					foreach($val['lower'] as $v) {
                       						echo '<li value="'.$v['id'].'">'.$v['kindname'].'</li>';
                       					}
                       				}
                       			}
                       		}
                       ?>
                    </ul>
                    <ul class="generated_city">
                        <?php
                        	if (!empty($dest)) {
                        		foreach($dest as $val){
                        			echo '<li value="'.$val['id'].'">'.$val['kindname'].'<span>X</span></li>';
                        		}
                        	}
                        ?>
                    </ul>


                </div>
            </div>
            <!--个人描述 -->
            <div class="conmen_zhong relative">
                <div class="mingtou"><i>*</i>个人描述</div>
                <textarea class="text_num" placeholder="个人介绍展示，150字以内" maxlength="150" name="talk"><?php if(!empty($expert)){echo $expert['talk'];}?></textarea>
                <div class="num_info"><span>150</span><i>/150</i></div>
            </div>
            <!--个人简历 -->
            <div class="enroll_title">
                <div class="enroll_perch"><!--占位符 --></div>
                <span class="back_none">个人简历</span>专业的简历是您通过管家资质审核的关键</div>
            <div class=" color_red">以下显示于管家页面(旅游从业年限可累加并详述如下）</div>
            <div class="blanks " style=" padding-left:0;">
                <div class="vacancy">毕业院校
                    <input type="text" name="school" value="<?php if(!empty($expert)){echo $expert['school'];}?>" placeholder="学校名称"/>
                    &nbsp;&nbsp;,&nbsp;&nbsp;  旅游从业
                    <input type="text" placeholder="岗位名称" value="<?php if(!empty($expert)){echo $expert['profession'];}?>" name="job_name" />
                    &nbsp;&nbsp;,&nbsp;&nbsp;
                    <input type="text"placeholder="工作年限" value="<?php if(!empty($expert)){echo $expert['working'];}?>" name="year" />  年
                </div>
            </div>
            <div class="conmen_zhong" style="margin-top:10px;">
            <div class="title_box"><span onclick="addExperience(this);" style=" margin-right:20px;" class=" button_modality">添加经历</span><i>以下不公开显示，仅做管家资质审核用（非旅游从业可不填）</i></div>
            <div class="jingli_list listExperience" style="margin-left:20px;width: 980px;">
                <ul>
                    <li style=" width:200px;">起止时间</li>
                    <li style=" width:170px;">所在企业</li>
                    <li style=" width:100px;">职务</li>
                    <li style=" width:446px;">工作描述</li>
                    <li class="last_border" style=" width:48px;">操作</li>
                </ul>
                <?php if(empty($resume)):?>
                <ul>
                    <li style=" width:200px;">
                        <input type="text" placeholder="开始时间" readonly onclick="WdatePicker()" name="starttime[]" maxlength="10" style="ime-mode:disabled;">
                        <i class="col_bla">至</i>
                        <input type="text" readonly onclick="WdatePicker()" name="endtime[]" maxlength="10" style="ime-mode:disabled;" placeholder="结束时间">
                    </li>
                    <li style=" width:170px;">
                        <input type="text" name="company_name[]" placeholder="所在企业">
                    </li>
                    <li style=" width:100px;">
                        <input type="text" name="job[]" placeholder="职务">
                    </li>
                    <li style=" width:446px;">
                        <input type="text" name="description[]" placeholder="工作描述,限30个字以内" style="width:420px;" maxlength="30">
                    </li>
                    <li class="last_border" style=" width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>
                </ul>
                <?php else:?>
                	<?php foreach($resume as $key=>$val):?>
                	<ul>
	                    <li style=" width:200px;">
	                        <input type="text" placeholder="开始时间" value="<?php echo $val['starttime']?>" readonly onclick="WdatePicker()" name="starttime[]" maxlength="10" style="ime-mode:disabled;">
	                        <i class="col_bla">至</i>
	                        <input type="text" readonly onclick="WdatePicker()" value="<?php echo $val['endtime']?>" name="endtime[]" maxlength="10" style="ime-mode:disabled;" placeholder="结束时间">
	                    </li>
	                    <li style=" width:170px;">
	                        <input type="text" value="<?php echo $val['company_name']?>" name="company_name[]" placeholder="所在企业">
	                    </li>
	                    <li style=" width:100px;">
	                        <input type="text" value="<?php echo $val['job']?>" name="job[]" placeholder="职务">
	                    </li>
	                    <li style=" width:446px;">
	                        <input type="text" value="<?php echo $val['description']?>" name="description[]" placeholder="工作描述,限30个字以内" style="width:420px;" maxlength="30">
	                    </li>
	                    <li class="last_border" style=" width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>
	                </ul>
                	<?php endforeach;?>
                <?php endif;?>
            </div>
        </div>

        <!--=======================  申请免费拍照  ======================= -->
        <div class="enroll_title">
            <div class="enroll_perch"><!--占位符 --></div>
            <span class="back_none" style="width:110px;">申请免费拍照</span>点击下面的申请按钮根据提示获取免费拍照资格
        </div>
<!--         <div class="take_photos"> -->
<!--         	<input type="hidden" name="expert_qrcode" value=""> -->
<!--         	<input type="hidden" name="expert_museum" value=""> -->
<!--       		<span class="apply_take_photo" onclick="apply_take_photos(this);">申请拍照</span>-->

<!--         </div> -->

        <div class="take_photos">
      		<input type="hidden" name="expert_qrcode" value="">
      		<input type="hidden" name="expert_museum" value="<?php if(!empty($expert_museum['mid'])){ echo $expert_museum['mid'];} ?>">
        	<?php if(empty($expert_qrcode)){ ?><span class="apply_take_photo" onclick="apply_take_photos(this);">申请拍照</span> <?php }?>
        	<?php if(!empty($expert_museum)){ ?>
        	<div class="photo_shop_info clear">
        	  <img src='<?php echo $expert_museum['qrcode'];?>' >
        	  <p style="margin-top:60px;"> 凭此二维码免费拍照一张，申请后请于5个工作日内前往，请提前一天预约。</p>
        	  <p class="photo_shop_name" style="margin-top:20px;"><?php echo $expert_museum['name'];?></p>
        	  <p class="photo_shop_address" style="margin-top:20px;"><?php echo $expert_museum['address'];?></p>
        	  <input type="hidden" value="<?php  echo $expert_museum['mid'];?>">
        	</div>
        	<?php }?>
        </div>

          <div class="conmen_top" style=" padding-top:5px;">
            <ul class="relative">
                <li><span class="titl_head" style="width:64px;">
                	<i>*</i>验证码:</span>
                	<input type="text" name="code" maxlength="18" style="width:150px;"/>
                	<img style="height:32px;margin-top:7px;border:1px solid #ccc; width:69px;" id='verifycode2' src="/tools/captcha/index" onclick="this.src='/tools/captcha/index?'+Math.random()">
                </li>
 <!--                <div class="huoqu_hidden2" id="yanzheng" style=" top:40px; left:120px;">
	            	<input class="yanzheng_shuru" type="text" name="vcode" maxlength="4" placeholder="输入四位验证码" style="ime-mode:disabled;">
	           		<div style="float:right; height:40px;width:91px;">
	            		<img style="height:39px;border:1px solid #ccc; width:88px;" id='verifycode2' src="/tools/captcha/index" onclick="this.src='/tools/captcha/index?'+Math.random()">
	           		</div>
	                <div class="tijiao" id="submitSendCode1">提交</div>
	               	    <div class="guanbi">关闭</div>
	          		<div class="info info3"><i></i><b></b></div>
           		</div>   -->
            </ul>
        </div>
            <div class="xieyi">
            <input type="checkbox" value="1" name="isAgree"/>
            <input type="hidden" name="expert_id" value="<?php if(!empty($expert)){echo $expert['id'];}?>" />
                	同意<a href="/service/expert_agreement" target="_blank">&lt;&lt;帮游管家服务总则及合作协议&gt;&gt;</a></div>
            <input type="hidden" name="type" />
            <input type="hidden" name="resume_list" />
            <input type="hidden" name="certificate_list" />
            <input type="button" value="提交审核" onclick="submitForm(this);" class="jnbtns"/>
        </div>
    </div>
</form>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<div class="right_box" style="display:none;"></div>

<!--=====================申请免费照相弹框=================== -->

<script type="text/javascript" src="<?php echo base_url('static/plugins/DatePicker/WdatePicker.js'); ?>"></script>
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>



<script>
//目的地(所有)

var isIE=!!window.ActiveXObject;
var isIE6=isIE&&!window.XMLHttpRequest;
var isIE8=isIE&&!!document.documentMode;
var isIE7=isIE&&!isIE6&&!isIE8;
if (!isIE6){
	//所有目的地
	createChoicePlugin({
			data:chioceDestJson,
			nameId:"expertDestName1",
			valId:"expertDestId1",
			width:660,
			number:5,
			buttonId:'destList1'
	});
		createChoicePlugin({
			data:chioceDestJson,
			nameId:"expertDestName2",
			valId:"expertDestId2",
			width:660,
			number:5,
			buttonId:'destList2'
		});
}else{
alert("ie6")

}

//提交表单
var s = true;
function submitForm(obj) {
	if (s == false) {
		return false;
	} else {
		s = false;
	}
	var formObj = $(obj).parents('form');
	var expert_id = $(obj).parents("form").find("input[name='expert_id']").val();
	var type = $("input[name='title']:checked").val();

	formObj.find("input[name='type']").val(type);

	var destid = '';
	$.each(formObj.find('.city_longs').find('li'),function(){
		if ($(this).hasClass('active-dest')) {
			destid += $(this).attr('value')+',';
		}
	})
	formObj.find('input[name=expert_dest]').val(destid);

	if (expert_id > 0) {
		var url = "/admin/b2/register/updateExpert";
	} else {
		var url = "/admin/b2/register/expertInsiderAdd";
	}

	$.post(url,$(obj).parents("form").serialize(),function(json){
		s = true;
		var data = eval("("+json+")");
		if (data.code == 2000) {
			alert('您提交的信息正在审核中,请您耐心等待,审核结果会以短信通知您!');
			location.href="/";
		} else {
			alert(data.msg);
		}
	})
}
//发送手机验证码
var codeStatus = true;
//$("#submitSendCode").click(function(){
$("#btnSendCode1").click(function(){

	if (codeStatus == false) {
		return false;
	} else {
		codeStatus = false;
	}
	try{
		var mobile = $(this).parents("form").find("input[name='mobile']").val();
		//var vcode = ($(this).parents("form").find("input[name='vcode']").val()).toLowerCase();
		if (!isMobile(mobile)) {
			throw   new  Error( "请填写正确的手机号" );
		}

		$.post("/send_code/sendMobileCode",{mobile:mobile,type:4,verifycode:"无"},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				countdown("btnSendCode1");
				$(".huoqu_hidden").hide();
			} else {
				codeStatus = true;
				alert(data.msg);
			}
			$("#verifycode1").trigger("click");
		});
	} catch(err) {
		alert(err.message);
		codeStatus = true;
	}
})
//发送邮箱验证码
var codeStatus = true;
$("#btnSendCode2").click(function(){
	if (codeStatus == false) {
		return false;
	} else {
		codeStatus = false;
	}
	try{
		var email = $(this).parents("form").find("input[name='email']").val();
		//var vcode = ($(this).parents("form").find("input[name='vcode']").val()).toLowerCase();
		if (!isEmail(email)) {
			throw   new  Error( "请填写正确的邮箱号" );
		}
		$.post("/send_code/sendEmailCode",{email:email,type:1,verifycode:"无"},function(json){
			var data = eval("("+json+")");
			if (data.code == 2000) {
				countdown("btnSendCode2");
				$(".huoqu_hidden2").hide();
				alert("请进入您的邮箱查看验证码");
			} else {
				codeStatus = true;
				alert(data.msg);
			}
			$("#verifycode2").trigger("click");
		});
	} catch(err) {
		$("#verifycode2").trigger("click");
		alert(err.message);
		codeStatus = true;
	}
})

//上传文件
var imgProportion = {1:"5:3",2:"360x360",3:"5:3",9:'5:3'};
var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",9:"xiuxiu_box9"};
var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",9:"xiuxiuEditor9"};
function uploadImgFile(obj ,type){
		var buttonObj = $(obj);
		xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
		xiuxiu.embedSWF(xiuBox[type],5,'100%','100%',xiuxiuEditor[type]);
	       //修改为您自己的图片上传接口
		xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
	    xiuxiu.setUploadType(2);
	    xiuxiu.setUploadDataFieldName("uploadFile");

		xiuxiu.onInit = function ()
		{
			//默认图片
			xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
		}
		xiuxiu.onUploadResponse = function (data)
		{
			data = eval('('+data+')');
			if (data.code == 2000) {
				buttonObj.next("input").val(data.msg);
				if (type == 3) {
					//alert("上传成功");
					buttonObj.after(data.msg);
				} else if (type == 2) {
					//buttonObj.css({'margin-top': '0px','margin-left': '110px'});

					buttonObj.prev("div").show().find("img").attr("src",data.msg);
				} else if (type == 1){
					//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
					if (buttonObj.hasClass('fan')) {
						buttonObj.nextAll("img").show().attr("src",data.msg);
					} else {
						buttonObj.prev("div").show().find("img").attr("src",data.msg);
					}
				}
				closeXiu(type);
			} else {
				alert(data.msg);
			}
		}
		$("#xiuxiuEditor"+type).show();
		$('.avatar_box').show();
		$('.close_xiu').show();
		$('.right_box').show();
		return false;
}
$(document).mouseup(function(e) {
    var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3'); // 设置目标区域
    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
        $("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3").hide();
        $('.avatar_box').hide();
        $('.close_xiu').hide();
        $('.right_box').hide();
    }
})
function closeXiu(type) {
	$("#xiuxiuEditor"+type).hide();
	$('.avatar_box').hide();
	$('.close_xiu').hide();
	$('.right_box').hide();
}
//删除简历以及证书的li
function deleteLi(obj){
// 	if ($(obj).parents("ul").parent("div").find("ul").length <= 2 || type == 1) {
// 		$(obj).parents("ul").find("input[type='text']").val('');
// 	} else {
		$(obj).parents("ul").remove();
//	}
}

var province = <?php if (!empty($expert)){echo $expert['province'];}else{echo 0;}?>;
var city = <?php if (!empty($expert)){echo $expert['city'];}else{echo 0;}?>;
var expertType = <?php if (!empty($expert)){echo $expert['type'];}else{echo 0;}?>;
var visit_service = "<?php if(!empty($expert)){echo $expert['visit_service'];}else{echo 0;}?>";

//添加荣耀证书
function addCertificate(obj) {
	var html = '<ul>';
	html += '<li style=" width:448px;"><input type="text" style=" width:400px;" name="certificate[]" placeholder="请输入证件名称"></li>';
	html += '<li style=" width:400px;">';
	html += '<input type="button" onclick="uploadImgFile(this,3);"  value="上传" class="uploadFileBut4" style=" float: left; margin-left: 50px; margin-top: 3px;">';
	html += '<input type="hidden" name="certificatepic[]" readonly style="border:none;width:200px;" >';
	html += '</li>';
	html += '<li class="last_border" style="width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li></ul>';

    $(obj).parents("form").find(".listCertificate").append(html);
    cNum++;
}
//添加从业经历
function addExperience(obj) {
	var html = "<ul>";
	html += '<li style=" width:200px;">';
	html += '<input type="text" placeholder="开始时间" readonly onclick="WdatePicker()" name="starttime[]" maxlength="10" style="ime-mode:disabled;">';
	html += '<i class="col_bla">至</i><input type="text" readonly onclick="WdatePicker()" name="endtime[]" maxlength="10" style="ime-mode:disabled;" placeholder="结束时间">';
	html += '</li>';
	html += '<li style=" width:170px;"><input type="text" name="company_name[]"  placeholder="所在企业"></li>';
	html += '<li style=" width:100px;"><input type="text" name="job[]"  placeholder="职务"></li>';
	html += '<li style=" width:446px;"><input type="text" name="description[]"  placeholder="工作描述,限30个字以内" style="width:420px;" maxlength="30"></li>';
    html += '<li class="last_border" style=" width:48px;"><a href="javascript:void(0);" onclick="deleteLi(this);">删除</a></li>';
    html += '</ul>';
    $(obj).parents("form").find(".listExperience").append(html);
    eNum++;
}

getChinaPC();
getAbroadAreaPC();
//abroadPC("expertAddress2" ,124);

//城市变动获取地区
function getChinaPC(){
	$.post("/common/area/getChinaAreaPCR",{},function(json){
		var areaData = eval("("+json+")");
		var html = '<select name="province" class="changeProvince" style="width:120px;"><option value="0">请选择</option>';
		$.each(areaData.topArea ,function(index,item){
			html += '<option value="'+item.id+'">'+item.name+'</option>';
		})
		html += "</select>";

		$("#expertAddress1").append(html);
		//省份变动
		$(".changeProvince").change(function(){
			var id = $(this).val();
			$(this).next("select").remove();
			if (id == 0) {
				return false;
			}
			var html = '<select name="city" class="changeCity" style="width:128px;" ><option value="0">请选择</option>';
			$.each(areaData[id] ,function(index,item){
				html += '<option value="'+item.id+'">'+item.name+'</option>';
			})
			html += "</select>";
			$(this).after(html);
			//城市变动
			$(".changeCity").change(function(){
				var id = $(this).val();
				if (id == 0) {
					return false;
				}
				var html = "";
				if (visit_service != 0) {
					var serviceArr = visit_service.split(',');
				}
				$.each(areaData[id] ,function(index ,item){
					if (visit_service != 0) {
						var checked = '';
						$.each(serviceArr ,function(key ,val) {
							if (val == item.id) {
								checked = 'checked';
							}
						})
						html += '<li><input type="checkbox" '+checked+' name="visit_service[]" value="'+item.id+'">'+item.name+'</li>';
					} else {
						html += '<li><input type="checkbox" name="visit_service[]" value="'+item.id+'">'+item.name+'</li>';
					}
				})
				$(".visit_service_list").find("li").remove();
				$(".visit_service_list").append(html).parent("div").show();
			})
		})
		if (expertType == 1) {
			$("#expertAddress1").find("select[name='province']").val(province).trigger("change");
			$("#expertAddress1").find("select[name='city']").val(city).trigger("change");
		}
	})
}
function getAbroadAreaPC(){
	$.post("/common/area/getAbroadAreaPC",{},function(json){
		areaData = eval("("+json+")");
		var html = '<select name="province" class="changeProvinceAbroad" style="width:115px;" ><option value="0">请选择</option>';
		$.each(areaData.topArea ,function(index,item){
			html += '<option value="'+item.id+'">'+item.name+'</option>';
		})
		html += "</select>";

		$("#expertAddress2").append(html);

		$(".changeProvinceAbroad").change(function(){
			var id = $(this).val();
			$(this).next("select").remove();
			if (id == 0) {
				return false;
			}
			var html = '<select name="city" class="changeCity" style="width:123px;" ><option value="0">请选择</option>';
			$.each(areaData[id] ,function(index,item){
				html += '<option value="'+item.id+'">'+item.name+'</option>';
			})
			html += "</select>";
			$(this).after(html);
		})

		if (expertType == 2) {
			$("#expertAddress2").find("select[name='province']").val(province).trigger("change");
			$("#expertAddress2").find("select[name='city']").val(city);
		}
	})
}
//点击服务地区的全部
function checkAll(obj) {
	if ($(obj).attr("checked") == 'checked') {
		$(obj).parents("ul").find("input[type='checkbox']").attr("checked" ,true);
	}
}
 //切换表单 验证显示
  	$(function(){

		$(".huoqu").click(function(){
			$("#verifycode1").trigger("click");
			$("#yanzheng").show();
			})
		$("#btnSendCode2").click(function(){
			$("#verifycode2").trigger("click");
			$(".huoqu_hidden2").show();
		})
		$(".jingnei").click(function(){
			cNum = 2;
			eNum = 2;
			$(".jingnei_box").find(".listExperience").find("ul").eq(1).nextAll().remove();
			$(".jingnei_box").find(".listCertificate").find("ul").eq(1).nextAll().remove();
			$(".jingwai_box").hide();
			$(".jingnei_box").show();
			$(this).find("input").attr("checked","checked")
		})
		$(".jingwei").click(function(){
			cNum = 2;
			eNum = 2;
			$(".jingwai_box").find(".listExperience").find("ul").eq(1).nextAll().remove();
			$(".jingwai_box").find(".listCertificate").find("ul").eq(1).nextAll().remove();
			$(".jingnei_box").hide();
			$(".jingwai_box").show();
			$(this).find("input").attr("checked","checked")
		})
	})
</script>
<script>
//短信验证码必须是数字
	$('#input1,#input2,#input3').keyup(function(){
		var c=$(this);
		if(/[^\d]/.test(c.val())){//替换非数字字符
		  var temp_amount=c.val().replace(/[^\d]/g,'');
		  $(this).val(temp_amount);
		}
	 });
         //*---------------------------------------手机号验证-------------------------------------*/
		$(function(){
        /*获取焦点先显示*/
        $(".shouji").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".shouji").blur(function(){
            var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        })
        $(".shouji").keyup(function(){
            var mobile = $(this).val();

            if(!mobile.match(/[0-9]/)){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }

            if(mobile.length<=10){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };

            if(mobile.length==0){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    });

     /*密码验证*/
     //*---------------------------------------密码验证-------------------------------------*/
    $(function(){
        $(".mima").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".mima").blur(function(){

            var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".mima").keyup(function(){
            var mobile = $(this).val();

            if(!mobile.match(/^[0-9a-zA-Z]*$/)){
            /*ti_2*/
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }
            if(mobile.length<6 || mobile.length>20){
            /*ti_1*/
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };
            if(mobile.length==0){
            /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    })


    //*---------------------------------------密码验证 是否相同--------------------------------------*/
    $(function(){
        $(".zaici").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".zaici").blur(function(){
           var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".zaici").keyup(function(){
            var mobile = $(this).val();
            var pw1 = $(this).val();
            var pw2 = $(this).parent("li").siblings("li").eq(1).find(".mima").val();

            //alert(pw2)
            if(pw1!=pw2){

                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{

                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };
            if(mobile.length==0){
            /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    })


     //*---------------------------------------昵称验证--------------------------------------*/
    $(function(){
        $(".nicheng").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".nicheng").blur(function(){
            var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".nicheng").keyup(function(){
            var mobile = $(this).val();

            if(!mobile.match(/([\u4e00-\u9fa5]{2,4})/)){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };

            if(mobile.length==0){
            /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    })


     //*---------------------------------------姓名验证--------------------------------------*/
    $(function(){
        $(".xingming").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".xingming").blur(function(){
           var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".xingming").keyup(function(){
            var mobile = $(this).val();
            if(!mobile.match(/([A-Za-z]|[\u4E00-\u9FA5])/)){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };
            if(mobile.length==0){
            /*ti_1*/  /*ti_2*/
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    })

      //*---------------------------------------身份证号验证--------------------------------------*/
    $(function(){
        $(".shenfenzheng").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".shenfenzheng").blur(function(){
           var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".shenfenzheng").keyup(function(){
            var mobile = $(this).val();

            if(!mobile.match(/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/)){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }

            if(mobile.length<=17){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            };

            if(mobile.length==0){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    })


     //*---------------------------------------邮箱验证--------------------------------------*/
    $(function(){
        $(".youxiang").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".youxiang").blur(function(){
           var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".youxiang").keyup(function(){
            var mobile = $(this).val();

            if(!mobile.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_ok").addClass("tri_no");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }

            if(mobile.length==0){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }
        })
    });


     //*---------------------------------------境外证件[0]--------------------------------------*/
    $(function(){
        $(".zhengjian").focus(function(){
            $(this).siblings(".ti_box").show();
        });
        $(".zhengjian").blur(function(){
           var lens= $(this).siblings(".ti_box").find(".tri_ok").length;
            //alert(lens)
            if(lens==1){
                $(this).siblings(".ti_box").hide();
            }else{
                $(this).siblings(".ti_box").show();
            }
        });
        $(".zhengjian").keyup(function(){
            var mobile = $(this).val();
            if(mobile.length==0){
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_ok").removeClass("tri_no").addClass("tri_defa");
            }else{
                $(this).siblings(".ti_box").find(".ti").find("i").removeClass("tri_defa").removeClass("tri_no").addClass("tri_ok");
            }
        })
    });


		$("#input2").blur(function(){
			var mobile_yzm = $(this).val();

			//失去光标检测短信验证码
			if(mobile_yzm.length!=0){
				$.post(
					"",
					{mobile_yzm:$(this).val()},
					function(msg){
						if(false){
							$('.info2 b').html("请输入您收到的短信验证码");
							$('.info2').css("display","block");
						}else{
							$('.info2').css("display","none");
						}
					}
				);
			}
		});
		$('#login_submit').click(function(){
			var mobile = $("#input1").val();
			var mobile_yzm = $("#input2").val();
			var img_yzm = $("#input3").val();
			var pw1 = $("#input4").val();
			var pw2 = $("#input5").val();
			var xieyi = $("#input6").attr("checked");
			if(mobile.length<=0){
				$('.info1 b').html("请输入您的11位手机号");
				$('.info1').css("display","block");
				return false;
			};
			if(!mobile.match(/^1[3-8]\d{9}$/)){
				$('.info1 b').html("您输入的手机号码格式不正确");
				$('.info1').css("display","block");
				return false;
			}else{
				$('.info1').css("display","none");
			};
			if(mobile_yzm.length<=0){
				$('.info2 b').html("请输入您收到的短信验证码");
				$('.info2').css("display","block");
				return false;
			}else{
				$('.info2').css("display","none");
			};
			if(pw1.length<=0){
				$('.info4 b').html("请输入密码（6-20位：字母、数字、特殊符号）");
				$('.info4').css("display","block");
				return false;
			};
			if(pw1.length<6){
				$('.info4 b').html("您输入的密码长度不足（至少6个字符）");
				$('.info4').css("display","block");
				return false;
			}else {
				$('.info4').css("display","none");
			};
			if(pw1!=pw2){
				$('.info5 b').html("两次输入的密码不一致");
				$('.info5').css("display","block");
				return false;
			}else{
				$('.info5').css("display","none");
			};
			if(xieyi!="checked"){
				$('.info6 b').html("您还没有同意帮游会员协议");
				$('.info6').css("display","block");
				return false;
			}else{
				$('.info6').css("display","none");
			};
			$.post(
				"<?php echo site_url('admin/b2/register/expert_register')?>",
				$('#register_form').serialize(),
				function(data) {
					var data = eval('('+data+')');
					//console.log(data);
					if (data.code == 2000) {

						location.href="<?php echo site_url('admin/b2/register/register_two')?>";
					} else {
						 alert(data.msg);
					}
				}
			);
		})
        $(function(){
            $(".mobile_code").click(function(){
                $("#yanzheng").show();
            })
            $(".guanbi").click(function(){
                $(".huoqu_hidden").hide();
            })
            $(".tijiao").click(function(){
                $(".huoqu_hidden").hide
            })
            $(".huoqu2").click(function(){
            	$("#verifycode2").trigger("click");
                $(".huoqu_hidden2").show();
            })
            $(".guanbi").click(function(){
                $(".huoqu_hidden2").hide();
            })
        })
		$(function(){
			$("input").attr("autocomplete","off")
		})
    </script>
<script type="text/javascript">

//======================================text输入框   限制最多字数150字 (倒数)===============================//
$(document).ready(function() {
    $(".text_num").keyup(function() {
        var thisnum = $(this).val().length;
        //alert(thisnum);
        $(this).siblings(".num_info").find("span").html( 150-thisnum);
        if($(".num_info span").html()<0){
        	$(".num_info span").html("0");
        }
    });
});


//选择照相馆弹框
function apply_take_photos(obj){
    //if(!isIE6){
        $(obj).addClass("apply_this");
        $(".bg").show();
        var sj = $("#mosj").val();
   // }else{
        var al_width=document.documentElement.clientWidth  //ie6 宽度(窗口)
        var al_height=document.documentElement.clientHeight  //ie6 高度(窗口)
        var scc=document.documentElement.scrollTop || document.body.scrollTop       //ie6 窗口到 顶部的距离


        $("html").css("overflow","hidden")
        $('.bg').width(al_width);
        $('.bg').height(al_height);
        $('.bg').css('top',scc)
        $('.bg').show();
}

$(".address_list label").eq(0).click().addClass("check_this");
$(".address_list label").click(function(){
	$(".address_list label").removeClass("check_this");
	$(this).addClass("check_this");

})
//选择照相馆地址
function click_submit(obj){
	$(".photo_shop_info").remove();
	var src = $(".erweima  img").attr("src");
	var value = $(".address_list .check_this").find("input").val();
	var name = $(".address_list .check_this").find(".shop_name").text();
	var address = $(".address_list .check_this").find(".shop_address").text();
	if(value==undefined){
		alert("您还未选择照相馆");
		return false;
	}
	var html = '';
		html += '<div class="photo_shop_info clear"><img src="'+src+'"/>';
		html += '<p style="width:600px;margin-top:60px;">凭此二维码免费拍照一张，申请后请于5个工作日内前往，请提前一天预约</p>';
		html += '<p class="photo_shop_name" style="margin-top:20px;">名称：'+name+'</p>';
		html += '<p class="photo_shop_address">地址：'+address+'</p><input type="hidden" name="" value="'+value+'"/></div>';
    //选中复制
    $('input[name="expert_museum"]').val(value) ;
    $('input[name="expert_qrcode"]').val(src) ;
	$(".apply_this").parent().append(html);
	$(".apply_take_photo").removeClass("apply_this");
    $("html").css("overflow","visible")
	$(".bg").hide();
}

//关闭选择照相馆弹框
function close_photo_box(obj){
    $("html").css("overflow","visible")
	$(".bg").hide();
}

</script>

<script type="text/javascript">

// ****************************选择擅长线路 *****************************//

    //触发显示
    $(".longs_blue").click(function(){

            $(".city_longs").show();
    });

    //点击事件  生成标签 ==
    $(".city_longs li").click(function(){

        //判断点击的是不是i出境游类的标题

        if($(this).hasClass("city_mune")){

            //alert('当前标题不可选择!');

        }else{

            //判断当前下有没有i这个图标

            var thisVl=$(this).val();    //当前点击的val

            var thisHt=$(this).html();    //当前点击的val

            if($(this).find("i").length<1){

                    $(this).addClass('active-dest').append('<i class="clixk_ok"></i>');

                    $(this).parent().next('.generated_city').append('<li value='+thisVl+'>'+thisHt+'<span>X</span></li>');

                }else{

                   $(this).removeClass('active-dest').find("i").remove();

                   $('.generated_city li').each(function(){

                        if(thisVl==$(this).val()){

                            $(this).remove();
                        }
                   })
            };

            //判断当前已选择的是否超过5个
            if($(this).parent().find('i').length>5){

                $(this).removeClass('active-dest').find("i").remove();

                $(this).parent().hide();

                $(this).parent().next('.generated_city').find('li').eq(5).remove();

                alert("最多可以选择5个擅长目的地");

            }

        };

    });

    //点击已生成便签的 删除 事件
    $('.generated_city li span').live('click',function(){

        //alert('1')
        var lineLi = $('.generated_city li').length;   //  获取已经生成标签的数量  (数量0 要隐藏 )

        var thisVl=$(this).parent('li').val();    //当前点击的val

        $(this).parent('li').remove();

        $('.city_longs li').each(function(){

            if(thisVl==$(this).val()){

               $(this).removeClass('active-dest').find('i').remove();

            }
        })

        // 点击已生成标签的删除需要 把显示出来的列表隐藏
        if(lineLi<2){

            $('.city_longs').hide();
        }

    })

$(document).mouseup(function(e){

    var _con = $('.goog_goin');   // 设置目标区域

    if(!_con.is(e.target) && _con.has(e.target).length === 0){

        $(".goog_goin").find('.city_longs').hide()

    }

});

// $('.longs_blue').toggle(function(){$(".city_longs").show()}, function(){$(".city_longs").hide()});

// ****************************选择擅长线路  END *****************************//


// ****************************上传的图片放大和缩小*****************************//
    $(".img_fangda").hover(function(){

        if($(this).hasClass('clixk_fangda')){

            $(this).removeClass('clixk_fangda')

        }else{

            $(".img_fangda").removeClass('clixk_fangda')

            $(this).addClass('clixk_fangda')

        }

    })

// **********************上传的图片放大和缩小  END     ***********************//
</script>

<script>
//百度统计
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?da409c07ec1641736bde4ab39783b82f";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>