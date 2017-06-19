<link href="/assets/css/b2_expert_update.css" type="text/css"rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/css/xiuxiu.css"rel="stylesheet" />
<!-- 擅长线路 -->
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script> 

<style>
.avatar_box, .opac_box {
    background: #000 none repeat scroll 0 0;
    bottom: 0;
    display: none;
    height: 100%;
    left: 0;
    opacity: 0.5;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 999;
}
    label{ margin-bottom: 0;}
    .img_fangda{
        width:180px;
        height:80px;
    }
    .clixk_fangda{
        position: absolute;
        z-index: 1000;
        width: 350px !important;
        height: 200px !important;
    }
    /* 目的选择样式*/
    #destList1, #destList2 {
        margin-left: 396px;
        margin-top: -31px;
        min-height: 32px;
    }
    #destList1 .selectedTitle {display: none;}
    #destList1 .selectedContent {
        background: #60af00;
        color: #fff;
        border: 1px solid #60af00;
        border-radius: 3px;
        width: auto;
        padding: 3px 11px 3px 7px;
        margin-right: 10px;
    } 
    select{ padding: 0; }
    .shadow{box-shadow: 0 0 10px 0 rgba(0, 0, 0, .3);
            -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .3);
            -moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, .3);
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, .3);}
    .xiugeiInput{ width: 100px; border: none !important; border-bottom: 1px solid #ddd !important; background:none !important;}
    .widget{ margin: 0}
    .widget-body{ padding: 0 10px 15px; background: #fff ;}
    .data_title{ background: #fff; border-bottom: 2px solid #09c;}
    .form-group{box-sizing: border-box; flex:1;}
    .stered_input{ width: 100%; height:100%; background: rgba(255,255,255,.8); position: fixed; top:0; left: 0; z-index: 10;}
    .mank_box{ width: 400px; height:200px; background: #fff; position: fixed; top:50%; margin-top: -220px; left:50%; margin-left: -220px; padding: 40px 0;}
    .shadows{box-shadow: 0 0 20px 0 rgba(0, 0, 0, .4); -webkit-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .4);-moz-box-shadow: 0 0 20px 0 rgba(0, 0, 0, .4);box-shadow: 0 0 20px 0 rgba(0, 0, 0, .4);}
    .overHidden{ overflow: hidden}
    .overHidden input{ height:28px; line-height: 28px;}
    .overHidden label{ height:30px; line-height: 30px; margin: 0; padding: 0}
    .D_resume{ margin-top:0;}
    .choice_img { padding: 2px 5px;}
    .imFangda{ display: none; width: 100%; height: 100%; background: rgba(255,255,255,.8); position: fixed; top:0; left: 0; z-index: 10;}
    .imFangda img{ width: 0; height: 0; position: absolute; top:50%; left:50%;}
    .form-group label, .form-group label{ height: 100%; overflow: hidden; display: -webkit-box; display: -webkit-flex; display: flex; -webkit-box-orient: vertical; -webkit-flex-flow: column; flex-flow: column; border-right:1px solid #ddd; }
    .form-group{ height: 100%;}
    .generated_city li{ background: #09c;}
    .generated_city li span{ color: #fff}
    .date-picker{ border-radius: 50%;}
    .gender_B ,.gender_G{ height: 16px; line-height: 16px; width: 50px; margin-left:10px; padding-top:10px;}
    .gender_B span ,.gender_G span{ position: relative; top:-5px;}
    .form-group{ margin: 0;}
    .data_a_1{ padding:5px 10px; border-radius: 3px;background: #09c; }
    .letitle{ background: none !important;}
    .regparan,.yanzg { width: 300px; overflow: hidden; margin-left: 40px;}
    .mobile_code{ padding: 0px; float: left; text-align: center; height: 30px; cursor: pointer; line-height: 30px; width: 60px; background: #09c;}
    .data_nr input{ width: 185px;}
    .regparan input{ height: 30px; line-height: 30px;}
    .tuy_yazh{ margin-top: 80px;top: 35px;left: 210px;}  
    .data_nr input{ margin-left: 0;}
    .yzm_tijiao_1{ margin-right: 5px;}
    .stered_input_1{ width: 100%; height:100%; background: rgba(255,255,255,.8); position: fixed; top:0; left: 0; z-index: 10;}
    .resume_span,.data_title_span{background: #09c; color: #fff; padding: 5px 10px; border-radius: 4px; cursor: pointer; float: left; margin: 10px;}
    .submitForm{ margin: 0 auto; margin-bottom: 50px !important;}
    .data_nr,.D_resume,.D_honor,.dataBorder { border: none; padding: 0 0px 15px;}
    .dataBorder{ padding: 0 20px;}
    .btn-palegreen:hover,.btn-palegreen{ background: #09c !important;border-color:#09c; margin: 20px auto; margin-left: -80px; margin-bottom: 50px;;}
    .submitForm{ margin-left: -80px;}
    .Borderlog .dataBorder{ padding: 0 !important; border-right: 1px solid #e0e0e0; border-top: 1px solid #e0e0e0;}
    .train_len,.train_table{ border: 1px solid #ddd;}
    .data_nav{ display:block; border-left:1px solid #e0e0e0;}
    .mank_box label{ border-right:none;}
    .form-group span{ margin-left:0;}
    .data_left{ border-top:1px solid #e0e0e0}
    .abcoun{ position:absolute; left:0;top:0;}
    .door_service label{ height:40px; line-height:40px; text-align:right; background:#f3f3f3; width:100px;}
    .visit_service_list li{ padding-top:5px;}
    .front_col{ border-bottom:1px solid #ddd}
    .form-group label { border:0 !important;}
    .paddingBorder { padding:10px 0;}
#xiuxiuEditor, #xiuxiuEditor1, #xiuxiuEditor2, #xiuxiuEditor3,#xiuxiuEditor4,#xiuxiuEditor5{
    height: 550px;
    left: 50%;
    margin-left: -400px;
    position: fixed;
    top: 25px;
    width: 800px;
    z-index: 10003;

}


</style>
<!-- Page Breadcrumb -->
<div class="page-breadcrumbs">
    <ul class="breadcrumb">
        <li><i class="fa fa-home"></i> <a href="/admin/b1/view">首页</a></li>
        <li class="active">管家后台</li>
        <li class="active">资料修改</li>
    </ul>
</div>
<!-- /Page Breadcrumb -->

<div class="widget flat radius-bordered">
    <div class="widget-body" style="min-width: 1000px;">
        <div id="registration-form">
            <form action="<?php echo base_url() ?>admin/b2/expert/index"
                  accept-charset="utf-8" method="post" novalidate
                  id="expertform" enctype="multipart/form-data">
                <div class="data_nr shadow" style="padding-bottom:0;height:auto;">
                    <div class="data_title #">境内管家</div>
                    <div class="paddingBorder Borderlog">
                        <div class="data_nav">
                            <div class="form-group data_left fl dataBorder">
                                <label for="inputName" class="control-label no-padding-right  col_ts">姓名：</label> 
                                <span><?php if (!empty($expert_info['realname'])) {
                                                echo $expert_info['realname'];
                                            } ?>
                                </span>
                            </div>
                            <div class="form-group dataBorder">
                                <label for="inputPhone" class=" control-label no-padding-right col_ts" style=" ma">性别： </label> 
                                <span><?php if ($expert_info['sex'] == 1) {
                                                echo '男';
                                            } else if ($expert_info['sex'] == 0) {
                                                echo '女';
                                            } elseif ($expert_info['sex'] == -1) {
                                                echo '保密';
                                            } 
                                       ?>
                                </span>
                            </div>
                        </div>
                        <div class="data_nav">
                            <div class="form-group data_left fl telephone_change_fl dataBorder">
                                <div class="">
                                    <label for="inputPhone"
                                           class=" control-label no-padding-right fl">手机号：</label> <input
                                           style="border: none;" id="expert_telephone"
                                           class="telephone_edit fl" type="text"
                                           value="<?php if (!empty($expert_info['mobile'])) {
                                                echo $expert_info['mobile'];
                                            } ?>"
                                           disabled> <a class="data_a modify_2">修改</a>
                                </div>
                                </br>
                                <div class="D_verification_code " style="display: none">
                                    <div id="yzm" class="stered_input">
                                        <div class="mank_box shadows">
                                            <div class="overHidden">
                                                <div class="regparan">
                                                    <label class=" control-label no-padding-right fl letitle"
                                                           for="inputPhone" style=" width:100px;">手机号：&nbsp;</label> 
                                                    <input type="text"
                                                           value="" name="mobile" class="telephone_edit fl" style="180px; margin: 0;">
                                                </div>
                                            </div>
                                            <div class="overHidden">
                                                <div class="fl yanzg ">

                                                    <label for="inputIdCard"
                                                           class="control-label no-padding-right letitle " style=" width:100px; margin: 0">验证码：</label> <input
                                                           type="text" name="mobile_code" class="stered_five" style=" width:30%;height:30px;line-height:30px; margin: 0;"> <span
                                                           id="btnSendCode" is_get_code="1"
                                                           class="mobile_code stered_phone" style=" width:30%;">获取验证码</span>
                                                </div>
                                            </div>
                                            <div style="margin-top: 20px; text-align: center; padding-left: 150px;">
                                                <input type="button" class="yzm_tijiao_1" id="submit_mobile"
                                                       value="确定">&nbsp;&nbsp;&nbsp; <input type="button"
                                                       class="yzm_guanbi_1" id="yzm_cancel" value="取消">
                                            </div>
                                            <div class="tuy_yazh tup_yz" style="display: none;">
                                                <div class="tuy_kj">
                                                    <input type="text" maxlength="4" id="input5" name="code"
                                                           placeholder="验证码" class="stered_five fl">
                                                    <div class="stered_yanzheng fl">
                                                        <img id="verifycode"
                                                             src="<?php echo base_url('tools/captcha/index'); ?>"
                                                             onclick="this.src = '<?php echo base_url('tools/captcha/index'); ?>?' + Math.random()"
                                                             style="-webkit-user-select: none; width: 88px;margin-left:0; margin-top:-1px; height: 32px;border:1px solid #ddd; border-left:0;">
                                                    </div>

                                                    <div style="margin-top: 58px; text-align: center;padding-left: 30px;;">
                                                        <input type="button" class="yzm_tijiao" id="submitSendCode"
                                                               value="保存"> <input type="button" class="yzm_guanbi"
                                                               id="yzm_close" value="关闭">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group data_right fl">
                                <div class="form-group telephone_change_fr dataBorder" style="width: 100%;">
                                    <label for="inputIdCard"  class="control-label no-padding-right fl"">邮箱：</label> 
                                    <input  style="border: none" class="email_edit fl" type="text"  id="expert_email"
                                        value="<?php if (!empty($expert_info['email'])) { echo $expert_info['email'];  } ?>" disabled > 
                                        <a class="data_a modify_3">修改</a>
                                </div>
                                <div class="D_verification_code verification_code_fr "
                                     style="display: none">
                                    <div name="yzm_code" id="yzm" class="stered_input_1">
                                        <div class="mank_box shadows" style="padding-left: 35px;">
                                            <label class="control-label no-padding-right fl letitle"
                                                   for="inputIdCard" style=" width: 90px; height: 30px; line-height: 30px; margin-top: 5px; margin-bottom: 10px;" >邮&nbsp;&nbsp;&nbsp;&nbsp;箱：</label> 
                                            <input
                                                type="text" value="" name="email" class="email_edit " style="width:180px; margin: 0; margin-top: 5px; margin-bottom: 10px;">
                                            <div class=" yanzg" style=" float: left; margin: 0">
                                                <label for="inputIdCard"
                                                       class="control-label no-padding-right letitle " style="width:90px">验证码：</label> <input
                                                       type="text" name="code1" class="stered_five" style="width:85px;"> 
                                                       <span id="btnSendCode" class="mobile_code " style="width: 30%; margin-top: 6px;;">获取验证码</span>
                                            </div>
                                            <div style="margin-top: 100px; padding-left: 120px; text-align: center">
                                                <input type="button" class="yzm_tijiao_1" id="email_submit"
                                                       value="确定">&nbsp;&nbsp;&nbsp; <input type="button"
                                                       class="yzm_guanbi_1" value="取消">
                                            </div>
                                            <div class="tuy_yz tup_yz" style="display: none; top: 120px; left: 190px;">
                                                <div class="tuy_kj">
                                                    <input type="text" maxlength="4" id="input5 btnSendCode2"
                                                           name="vcode" placeholder="验证码 " class="stered_five fl">
                                                    <div class="stered_yanzheng fl">
                                                        <img id="verifycode1"
                                                             src="<?php echo base_url(); ?>tools/captcha/index"
                                                             onclick="this.src = '<?php echo base_url(); ?>tools/captcha/index?' + Math.random()"
                                                             style="-webkit-user-select: none; width: 88px; height: 32px; margin-top:-2px; margin-left:0; border:1px solid #ddd; border-left:0">
                                                    </div>

                                                    <div style="margin-top: 48px; text-align: center; padding-left: 40px;;">
                                                        <input type="button" class="yzm_tijiao" id="submitSendCode1"
                                                               value="保存"> <input type="button" class="yzm_guanbi" value="关闭">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="data_nav clear" style=" height: auto">
                            <div class="form-group data_left fl dataBorder">
                                <label for="inputIdCard" class="control-label no-padding-right fl ">昵称：</label> 
                                <input class="eidt_nicheng fl" type="text" name="nickname" value="<?php if (!empty($expert_info['nickname'])) {
                                            echo $expert_info['nickname'];
                                        } ?>">
                                <!-- <a class="data_a modify_4">修改</a> -->
                            </div>

                            <div class="form-group data_left fl dataBorder">
                                <label for="inputIdCard"
                                       class="control-label no-padding-right fl ">微信号：</label> <input
                                       class="eidt_weixin fl" type="text" name="weixin"
                                       value="<?php if (!empty($expert_info['weixin'])) {
                                            echo $expert_info['weixin'];
                                        } ?>">
                                <!-- <a class="data_a modify_4">修改</a> -->
                            </div>

                        </div>

                        <div class="data_nav clear dataBorder">
                            <div class="form-group">
                                <label for="inputIdCard" class="control-label no-padding-right  ">身份证号码：</label>
                                <span>
                                <input
                                       class="eidt_nicheng fl" type="text" name="idcard"
                                       value="<?php if (!empty($expert_info['idcard'])) {
                                            echo $expert_info['idcard'];
                                        } ?>">
                            </div>
                        </div>

                        <div class="data_nav clear" style="height: 100px;">
                            <div class="form-group data_left fl dataBorder" style=" height:100px;">
                                <div class="form-group" style=" width: 100%;">
                                    <label for="inputImg" class="control-label no-padding-right  fl">身份证扫描件：</label>
                                    <img src='<?php if (!empty($expert_info['idcardpic'])) {
                                        echo $expert_info['idcardpic'];
                                    } ?>' class="img_fangda" /><a class="data_a_1"
                                     onclick="uploadImgFile(this, 4);">上传</a> 
                                     <input type="hidden" value="<?php if (!empty($expert_info['idcardpic'])) { echo $expert_info['idcardpic']; } ?>"  name="idcardpic" id="idcardpic" />
                                </div>
                            </div>

                            <div class="form-group dataBorder" style="height: 100px;">
                                <label for="inputImg" class="control-label no-padding-right  fl">身份证反面照：</label>
                                <img src='<?php if (!empty($expert_info['idcardconpic'])) {
                                    echo $expert_info['idcardconpic'];
                                } ?>' class= "img_fangda" />
                                <a class="data_a_1"
                                     onclick="uploadImgFile(this, 5);">上传</a> 
                               <input type="hidden" value="<?php if (!empty($expert_info['idcardconpic'])) { echo $expert_info['idcardconpic']; } ?>"  name="idcardconpic" id="idcardconpic" />
                                     
                            </div>
                        </div>
                        <div class="data_nav clear" style="height: 130px;">
                            <div class="form-group data_left dataBorder" style=" width:100%;height: 130px; border-bottom:1px solid #ddd;">
                                <label for="inputImg" class="control-label no-padding-right ">头像：</label>
                                <img id="imghead" style="width: 120px; height: 120px;"
                                     src='<?php if (!empty($expert_info['small_photo'])) {
                                        echo $expert_info['small_photo'];
                                    } ?>'
                                     class="date-picker" /> <a class="data_a_1"
                                     onclick="uploadImgFile(this, 1);">上传</a> <input type="hidden"
                                     value="<?php if (!empty($expert_info['small_photo'])) {
                                        echo $expert_info['small_photo'];
                                    } ?>"
                                     name="small_photo" id="small_photo" />
                            </div>
                        </div>
                        <div class="data_nav clear" style="height: 130px;">
                            <div class="form-group data_left dataBorder" style=" width:100%;height: 130px; border-bottom:1px solid #ddd;">
                                <label for="inputImg" class="control-label no-padding-right ">背景：</label>
                                <img id="imghead" style="width: 120px; height: 120px;"
                                     src='<?php if (!empty($expert_info['big_photo'])) {
                                        echo $expert_info['big_photo'];
                                    } ?>'
                                     class="date-picker" /> <a class="data_a_1"
                                     onclick="uploadImgFile(this, 2);">上传</a> <input type="hidden"
                                     value="<?php if (!empty($expert_info['big_photo'])) {
                                        echo $expert_info['big_photo'];
                                    } ?>"
                                     name="big_photo" id="big_photo" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="D_resume shadow" style="margin-top:10px;">
                    <div class=" data_title # fl">旅游从业简历</div>
                    <span class="resume_span">添加</span>

                    <div class="resume_nav">
                        <div class="tableBox">
                            <table style="width: 100%;border-left: none;border-right: none;"
                                   class="table table-bordered dataTable no-footer"
                                   aria-describedby="editabledatatable_info">
                                <thead>
                                    <tr role="row">
                                        <th style="width: 150px; text-align: center;border: none;">起止时间</th>
                                        <th style="width: 150px; text-align: center">所在企业</th>
                                        <th style="width: 150px; text-align: center">职务</th>
                                        <th style="width: 300px; text-align: center">工作描述</th>
                                        <th style="width: 80px; text-align: center;border: none;">操作</th>
                                    </tr>
                                </thead>
                                <tbody class="resume_table">
                                <?php
                                if (!empty($expert_resume)) {
                                    foreach ($expert_resume as $k => $v) {
                                        ?>
                                        <tr class="train_len">
                                            <td style="text-align: center;border-left: none;"><input type="hidden"
                                                                                                     name="job_name[]" value="<?php echo $v['starttime']; ?>" /><?php echo $v['starttime']; ?>
                                                <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span> <input type="hidden"
                                                                                              name="year[]" value="<?php echo $v['endtime']; ?>" /><?php echo $v['endtime']; ?>
                                            </td>
                                            <td style="text-align: center"><input type="hidden"
                                                                                  name="company_name[]"
                                                                                  value="<?php echo $v['company_name']; ?>"><?php echo $v['company_name']; ?></td>
                                            <td style="text-align: center"><input type="hidden"
                                                                                  name="job[]" value="<?php echo $v['job']; ?>"><?php echo $v['job']; ?></td>
                                            <td style="text-align: center"><input type="hidden"
                                                                                  name="description[]" value="<?php echo $v['description']; ?>"><?php echo $v['description']; ?></td>
                                            <td style="text-align: center;"><a href="##"
                                                                               onclick="del_resume(this)">删除</a></td>
                                        </tr>	
                                    <?php }
                                } ?>												   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="D_honor shadow" style="margin-top:10px;">
                    <div>
                        <div class=" data_title # fl">荣誉证书：</div>
                        <span class="data_title_span" style=" float: left; margin: 10px;">添加</span>
                    </div>
                    <div class="honor_nav">
                        <div class="tableBox">
                            <table style="width: 100%; min-width: 100px;border: none;border-top: 1px solid #e4e4e4; position: relative;"
                                   class="table table-bordered dataTable no-footer col_tbtj"
                                   aria-describedby="editabledatatable_info">
                                <thead>
                                    <tr role="row">
                                        <th style="width: 100px; text-align: center; border-left: none;">证书名称</th>
                                        <th style="width: 150px; text-align: center; font-weight: 500">扫描件</th>
                                        <th style="width: 56px; text-align: center; font-weight: 500;border: none">操作</th>
                                    </tr>
                                </thead>
                                <tbody class="train_table">
                                        <?php
                                        if (!empty($expert_certificate)) {
                                            foreach ($expert_certificate as $k => $v) {
                                                ?>
                                            <tr class="train_len">
                                                <td style="text-align: center;border-left: none;">
                                                    <input type="hidden" class='nm_zhengshu' name='certificate[]' value="<?php echo $v['certificate']; ?>">
                                                    <input type='hidden' name='certificatepic[]' value='<?php echo $v['certificatepic']; ?>' />
                                        <?php echo $v['certificate']; ?>
                                                </td>
                                                <td style="text-align: center;border-left: none;">
                                                    <img class="sm_img"style="width: 40px; height: 40px;"src="<?php echo $v['certificatepic']; ?>">
                                                    <div class="bg_img">
                                                        <img style="width: 350px; height: 200px;"src="<?php echo $v['certificatepic']; ?>">
                                                    </div>
                                                </td>
                                                <td style="text-align: center;border-left: none;">
                                                    <a href="##"onclick="del_certificate(this)">删除</a>
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>											   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="data_details shadow">

                    <div style="padding: 20px 0px;">
                        <div class="form-group data_left " style=" width: 100%; height:40px; position: relative;">
                            <label for="" class=" control-label no-padding-right  col_ts  fl">个人描述：</label>
                            <div class=" fl" style=" position: absolute; left:120px;top:0;right:0;height:39px; z-index:-1px;">
                                <textarea style="width: 100%; overflow: hidden; height: 39px; border: none; font-family: serif; line-height: 20px;" name="talk"><?php if (!empty($expert_info['talk'])) {echo trim($expert_info['talk']);} ?></textarea>
                            </div>
                        </div>

                        <div class="form-group data_left " style=" width: 100%; height:40px; position: relative;">
                            <label for="" class=" control-label no-padding-right  col_ts fl">个人简介：</label>
                            <span style=" position: absolute; left:120px;top:0;right:0;height:39px; z-index:-1px;padding-left:10px;">毕业院校<b><input type="text"value="<?php if (!empty($expert_info['school'])) {
                                        echo $expert_info['school'];
                                    } ?>" class="school" name="school" /></b>，
                                旅游从业<b><input type="text"value="<?php if (!empty($expert_info['profession'])) {
                                        echo $expert_info['profession'];
                                    } ?>" class="profession"  name="profession" /></b>，
                                <b><input type="text"value="<?php if (!empty($expert_info['working'])) {
                                        echo $expert_info['working'];
                                    } ?>" class="working"  name="working" /></b>年</span> 
                        </div>
                        <div class="form-group data_left " style="width:100%;height:40px;" >
                            <!-- <label for="" class=" control-label no-padding-right col_ts">擅长线路：</label>-->
                            <div class=" front_col col_sq " style="height: 40px; line-height: 40px; width: 100%;">
                                <label style="float: left; position: relative;border-bottom:1px solid #ddd"><i class="abcoun" style="color: red; width:5px;">*</i><span >擅长线路：</span></label>
                                <div class="longs_blue" style=" adding-left: 10px;">最多选择5项目的地</div>
                                <input type="hidden" name="expert_dest" value="<?php if (!empty($expert_info['expert_dest'])) {
                                    echo $expert_info['expert_dest'] . ',';
                                } ?>" id="expertDestId1">
                                <ul class="city_longs">           
                            <?php
                            if (!empty($destArr)) {
                                foreach ($destArr as $val) {
                                    if (!empty($val['lower'])) {
                                        echo '<li class="city_mune">' . $val['kindname'] . '</li>';
                                        foreach ($val['lower'] as $v) {
                                            echo '<li value="' . $v['id'] . '">' . $v['kindname'] . '</li>';
                                        }
                                    }
                                }
                            }
                            ?>
                                </ul>
                                <ul class="generated_city">
                                <?php
                                if (!empty($dest)) {
                                    foreach ($dest as $k => $v) {
                                        ?>
                                            <li value="<?php echo $v['id']; ?>" class="cityID"><?php echo $v['name']; ?><span>X</span></li>
                                    <?php }
                                } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group " style=" width: 100%; margin: 0; width: 100%;border-bottom:1px solid #ddd;">
                            <label for="" class=" control-label no-padding-right">所属城市：</label>
                            <select name="country_id" id="country_id" style="width: 110px;">
                                <option value="0">请选择</option>
                                <?php foreach ($area_arr as $val) { ?>
                                    <option value='<?php echo $val["id"]; ?>'<?php if ($expert_info['country'] == $val["id"]) {
                                    echo 'selected="selected"';
                                } ?>>
                                 <?php echo $val["name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                                <?php if (!empty($expert_info['province'])) { ?>
                                <select id="province_id" name="province_id">
                                    <?php foreach ($province_arr as $val) { ?>
                                        <option value='<?php echo $val["id"]; ?>' <?php if ($expert_info['province'] == $val["id"]) {
                                    echo 'selected="selected"';
                                } ?>>
                                 <?php echo $val["name"]; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <?php } ?>

                                <?php if (!empty($expert_info['city'])) { ?>
                                         <select id="city_id" name="city_id">
                                    <?php foreach ($city_arr as $val) { ?>
                                            <option value='<?php echo $val["id"]; ?>' <?php if ($expert_info['city'] == $val["id"]) {
                                            echo 'selected="selected"';
                                        } ?>>
                                        <?php echo $val["name"]; ?>
                                            </option>
                                    <?php } ?>
                                        </select>
                                <?php } ?>
                        </div>
                        <div class=" front_col door_service clear " style=" margin: 10px 0;">
                            <label class=" control-label no-padding-right  col_ts  fl" style="height:100px; border-right:1px solid #ddd;"><span style="color: red;">*</span>上门服务：</label>

                            <div id="up_service" class="fl"> 
                                <?php if ($expert_info['country'] == 1) { ?>
                                    <div class="gender_B fl">
                                        <input type="radio" name="visit_service[]" <?php if ($expert_info['visit_service'] == 1) echo 'checked="checked"'; ?>
                                               value="1" style="left: -18px;"><span>是</span>
                                    </div>
                                    <div class="gender_G fl">
                                        <input type="radio" name="visit_service[]"
                                <?php if ($expert_info['visit_service'] == 0) echo 'checked="checked"'; ?>
                                               value="0" style="left: -18px;"><span>否</span>
                                    </div>
                            <?php } ?>
                            </div>

                            <ul class="chen_list visit_service_list fl">
                            <?php if ($expert_info['country'] == 2) { ?>
                                    <li>
                                        <input type="checkbox"name="visit_allservice[]" value="0" id="checkAll" />
                                        <p>全部</p>
                                    </li>
                            <?php
                            if (!empty($region_arr)) {
                                $visit_str = explode(',', $expert_info ['visit_service']);
                                ?>
                                <?php foreach ($region_arr as $val) { ?>
                                    <li>
                                        <input type="checkbox"<?php if (in_array($val["id"], $visit_str)) echo 'checked="checked"'; ?>
                                               name="visit_service[]" value="<?php echo $val['id']; ?>" />
                                        <p><?php echo $val["name"]; ?></p>
                                    </li>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>

                </div>
                <input type="hidden" name="rand_code" value="<?php echo mt_rand(100000, 999999); ?>" /> 
                <label for="inputImg" class="col-sm-3 control-label no-padding-right"></label>
                <label for="inputImg" class="col-sm-3 control-label no-padding-right"></label>
                <input type="hidden" name="type_status" value="<?php if(!empty($apply_bangu)){ echo $apply_bangu;}else{0;} ?>" /> 
                <button class="btn btn-palegreen submitForm" type="button" onclick="submitForm(this)">提交</button>
            </form>
        </div>
    </div>
</div>

<div class="imFangda">
    <img class="shadows">
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div id="xiuxiu_box4" class="xiuxiu_box"></div>
<div id="xiuxiu_box5" class="xiuxiu_box"></div>
<div class="avatar_box"></div>

<div class="right_box" style="display: none;"></div>
<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script> 
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/plugins/DatePicker/WdatePicker.js'); ?>"></script>
<script>
//提交
                                    function submitForm(obj) {

                                        /*     var mobile=$('input[name="mobile"]').val();
                                         if(mobile==''){
                                         alert('手机号不能为空!');
                                         return false;
                                         } */
										 var idcard=$('input[name="idcard"]').val();
										if(idcard==""){
											alert('身份证信息不能为空!');
                                            return false;
										}
                                        var nickname = $('input[name="nickname"]').val();
                                        if (nickname == '') {
                                            alert('昵称不能为空!');
                                            return false;
                                        } else {
                                            //不能超过30个字
                                            var str = nickname;
                                            var realLength = 0, len = str.length, charCode = -1;
                                            for (var c = 0; c < len; c++) {
                                                charCode = str.charCodeAt(c);
                                                if (charCode >= 0 && charCode <= 128)
                                                    realLength += 1;
                                                else
                                                    realLength += 1;
                                            }

                                            if (realLength > 5) {
                                                var n = 0;
                                                n = i + 1;
                                                alert('昵称不能超过5个字符');
                                                return false;
                                            }
                                        }
                                        var starttime = true;
                                        $('input[name="job_name[]"]').each(function () {
                                            if ($(this).val() == '') {
                                                starttime = false;
                                            }
                                        });
                                       /*  if (starttime == false) {
                                            alert('旅游从业简历的起止时间不能为空!');
                                            return false;
                                        } */
                                        //擅长线路
                                        var destid = '';
                                        var formObj = $('.col_sq');
                                        $.each(formObj.find('.generated_city').find('li'), function () {
                                            if ($(this).hasClass('cityID')) {
                                                destid += $(this).attr('value') + ',';
                                            }
                                        })

                                        formObj.find('input[name=expert_dest]').val(destid);
                                        var expert_dest = $('input[name="expert_dest"]').val();
                                        if (expert_dest.length <= 0) {
                                            alert('请选择擅长线路');
                                            return false;
                                        }


                                        var year = true;
                                        $('input[name="year[]"]').each(function () {
                                            if ($(this).val() == '') {
                                                year = false;
                                            }
                                        });
                                       /*  if (year == false) {
                                            alert('旅游从业简历的起止时间不能为空!');
                                            return false;
                                        } */

                                        var company_name = true;
                                        $('input[name="company_name[]"]').each(function () {
                                            if ($(this).val() == '') {
                                                company_name = false;
                                            }
                                        });
                                       /*  if (company_name == false) {
                                            alert('旅游从业简历的所在企业不能为空!');
                                            return false;
                                        } */

                                        var job = true;
                                        $('input[name="job[]"]').each(function () {
                                            if ($(this).val() == '') {
                                                job = false;
                                            }
                                        });
                                       /*  if (job == false) {
                                            alert('旅游从业简历的职务不能为空!');
                                            return false;
                                        } */

                                        var flat = true;
                                        var re = true;
                                        $('input[name="certificate[]"]').each(function () {
                                            if ($(this).val() == '') {
                                                flat = false;
                                            }
                                        });
                                    /*     if (flat == false) {
                                            alert('证书名称不能为空');
                                            return false;
                                        } */
                                        $('input[name="certificatepic[]"]').each(function () {
                                            if ($(this).val() == '') {
                                                re = false;
                                            }
                                        });
                                       /*  if (re == false) {
                                            alert('荣誉证书的扫描件不能为空');
                                            return false;
                                        } */

                                        $.post("/admin/b2/expert/update_expert", $("#expertform").serialize(), function (json) {
                                            var data = eval("(" + json + ")");
                                            if (data.status == 1) {
                                                alert(data.msg);                                                
                                            } else {
                                                alert(data.msg);
                                            }
                                        })
                                        return false;
                                    }
                                    //验证码
                                    $(function () {
                                        $(".sm_img").hover(function () {
                                            $(this).parents('td').find(".bg_img").show();
                                        },
                                                function () {
                                                    $(".bg_img").hide();
                                                });
                                        // $('.modify,.modify_1,.modify_2,.modify_3,.modify_4').click(function () {
                                        //   $(this).siblings().siblings().removeAttr("disabled");
                                        //   $(this).siblings().siblings().removeAttr("style")
                                        // });
                                    })
                                    //修改手机
                                    $("#submit_mobile").click(function () {
                                        var mobile = $('input[name="mobile"]').val();
                                        var mobile_code = $('input[name="mobile_code"]').val();
                                        if (mobile == '') {
                                            alert('手机号码不能为空!');
                                            return false;
                                        }
                                        /* 	  if(mobile_code==''){
                                         alert('验证码不能为空!');
                                         return false;
                                         }  */
                                        $.post(
                                                "<?php echo site_url('/admin/b2/expert/update_mobile'); ?>",
                                                {'mobile': mobile, 'mobile_code': mobile_code},
                                                function (data) {
                                                    data = eval('(' + data + ')');
                                                    if (data.status == 1) {
                                                        alert(data.msg);
                                                        $('#expert_telephone').val(data.mobile);
                                                        $('#yzm_cancel').click();
                                                    } else {
                                                        alert(data.msg);
                                                    }
                                                }
                                        );
                                    });
                                    $(function () {
                                        $('.telephone_change_fl a,.telephone_change_fr a').click(function () {
                                            $('.D_verification_code').hide();
                                            $(this).parent().siblings().show();
                                        });
                                        $('.mobile_code').click(function () {
                                            $('.D_verification_code .tup_yz').show();
                                            //$(this).parent().siblings().show();
                                        });
                                        $('.yzm_guanbi_1').click(function () {

                                            $('.D_verification_code ').hide();
                                        })
                                        $('.yzm_guanbi').click(function () {
                                            $('.D_verification_code .tup_yz').hide();
                                        })
                                    })

                                    $(function () {
                                        //添加从业简历
                                        $(".resume_span").click(function () {
                                            var str = '<tr class="train_len"><td style="text-align:center;border-left: none;"><span> <input type="text" placeholder="" readonly onclick="WdatePicker()" name="job_name[]" style="border:none;border-bottom:1px solid #e1e1e1;width:90px;">';
                                            str = str + '至 <input type="text" placeholder="" readonly onclick="WdatePicker()" name="year[]" style="border:none;border-bottom:1px solid #e1e1e1;width:90px;"></span></td>';
                                            str = str + '<td style="text-align:center"><input class=" nm_zhengshu" name="company_name[]" ></td><td style="text-align:center"><input class=" nm_zhengshu" name="job[]" ></td>';
                                            str = str + '<td style="text-align:center"><input class=" nm_zhengshu" name="description[]"></td><td style="text-align:center;"><a href="##" onclick="del_resume(this)">删除</a></td></tr>';
                                            $(".resume_table").append(str); //添加对应的内容到table

                                        });

                                        //添加证书
                                        $(".data_title_span").click(function () {
                                            var html = "<tr role='row' class='tianjia'><td style='width: 150px;text-align:center;border-left: none;'><input class=' nm_zhengshu' name='certificate[]' placeholder='请填写证书名称'></td><td style='text-align:center;border-left:none;'> <input type='hidden' name='certificatepic[]' value='' />";
                                            html = html + "<input class='choice_img' onclick='uploadImgFile(this,3);' type='button' value='上传文件'</td><td style='text-align:center;'><a href='##' onclick='del_certificate(this)'>删除</a></td></tr>";
                                            //自己定义好要添加的信息
                                            $(".col_tbtj").append(html); //添加对应的内容到table
                                        });

                                    });
                                    //删除证书
                                    function  del_resume(obj) {
                                        $(obj).parent().parent().remove();
                                    }
                                    //删除证书
                                    function  del_certificate(obj) {
                                        $(obj).parent().parent().remove();
                                    }
                                    /*-----------------------------------上传图片-----------------------------*/
//                                    var imgProportion2 = {1: "360x360", 2: "360x360", 3: "360x360"};
                                    var imgProportion = {1: "180x180", 2: "332x222", 3: "360x360",4:"5:3",5:"5:3"};
									var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4",5:"xiuxiu_box5"};
									var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4",5:"xiuxiuEditor5"};
	
                                    function uploadImgFile(obj, type) {
										
                                        var buttonObj = $(obj);
//                                        if (subtype == 5){
//                                            xiuxiu.setLaunchVars("cropPresets", imgProportion2[type]);
//                                            xiuxiu.embedSWF(xiuBox[2], 5, '100%', '100%', xiuxiuEditor[2]);
//                                        }else{
                                            xiuxiu.setLaunchVars("cropPresets", imgProportion[type]);
                                            xiuxiu.embedSWF(xiuBox[type], 5, '100%', '100%', xiuxiuEditor[type]);
//                                        }
//                                        xiuxiu.embedSWF(xiuBox[type], 5, '100%', '100%', xiuxiuEditor[type]);
                                        //修改为您自己的图片上传接口
                                        xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu'); ?>");
                                        xiuxiu.setUploadType(2);
                                        xiuxiu.setUploadDataFieldName("uploadFile");

                                        xiuxiu.onInit = function ()
                                        {
                                            //默认图片
                                            xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg",false, xiuxiuEditor[type]);
                                        }
                                        xiuxiu.onUploadResponse = function (data)
                                        {
                                            data = eval('(' + data + ')');
                                            if (data.code == 2000) {
                                                buttonObj.next("input").val(data.msg);
                                                if (type == 3) {
                                                    alert("上传成功");
                                                    buttonObj.after(data.msg);
                                                    buttonObj.prev("input").val(data.msg);
                                                } else if (type == 2) {
                                                        buttonObj.prev("img").attr("src", data.msg);
                                                        $('input[name="big_photo"]').val(data.msg);
                                                } else if (type == 1) {
                                                        buttonObj.prev("img").attr("src", data.msg);
                                                        $('input[name="small_photo"]').val(data.msg);
                                                }else if(type == 4){
														 buttonObj.prev("img").attr("src", data.msg);
                                                        $('input[name="idcardpic"]').val(data.msg);
												}else if(type == 5){
													     buttonObj.prev("img").attr("src", data.msg);
                                                        $('input[name="idcardconpic"]').val(data.msg);
												}
                                                closeXiu(type);
                                            } else {
                                                alert(data.msg);
                                            }
                                        }
                                       	$("#xiuxiuEditor"+type).show();
										$('.avatar_box').show();
										$('.close_xiu').hide();
										$('.right_box').show();
										return false;
                                    }
                                  	$(document).mouseup(function(e) {
										var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4,#xiuxiuEditor5'); // 设置目标区域
										if (!_con.is(e.target) && _con.has(e.target).length === 0) {
											$("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4,#xiuxiuEditor5").hide();
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

                                    /*-------------------------------*/
                                    //发送手机验证码
                                    $('#submitSendCode').click(function () {
                                        var mobile = $("input[name='mobile']").val();

                                        var code = $('input[name="code"]').val();
                                        var rand_code = $("input[name='rand_code']").val();
                                        if (code.length < 1) {
                                            alert('请先输入下面的验证码再获取手机验证码');
                                            return false;
                                        }
                                        var is_get_code = $('#btnSendCode').attr('is_get_code');
                                        if (is_get_code != 1) {
                                            return false;
                                        }
                                        $.post(
                                                "<?php echo site_url('send_code/sendMobileCode'); ?>",
                                                {'mobile': mobile, 'verifycode': code, 'rand_code': rand_code, 'type': 8},
                                                function (data) {
                                                    data = eval('(' + data + ')');
                                                    if (data.code == 2000) {
                                                        //$('#yzm').css('display','none');
                                                        alert(data.msg);
                                                        sendMessage();
                                                        $('#yzm_close').click();
                                                        $("#verifycode").trigger("click");
                                                    } else if (data.code == 8000) {
                                                        return false;
                                                    } else {
                                                        alert(data.msg);
                                                        $("#verifycode").trigger("click");
                                                    }

                                                    create_code();
                                                }
                                        );

                                        //$('#yzm').hide();
                                        return false;
                                    })
                                    create_code();
                                    function create_code() {
                                        //重新生成随机码
                                    var $chars = '0123456789';
                                        var rand_code = '';
                                        for (i = 0; i < 6; i++) {
                                            rand_code += $chars.charAt(Math.floor(Math.random() * 10));
                                        }
                                        $('input[name="rand_code"]').val(rand_code);
                                    }

                                    //倒计时
                                var InterValObj; //timer变量，控制时间
                                var count = 60; //间隔函数，1秒执行
                                var curCount;//当前剩余秒数

                                function sendMessage() {
                                        curCount = count;
                                        //设置button效果，开始计时
                                                $("#btnSendCode").css({"background": "#ccc", "cursor": "auto"}).attr('is_get_code', '0');
                                        $("#btnSendCode").html("" + curCount + "s重新发送");
                                        InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                                    }

                                    //timer处理函数
                                    function SetRemainTime() {
                                        if (curCount == 0) {
                                            window.clearInterval(InterValObj);//停止计时器
                                            $("#btnSendCode").html("重新发送");
                                            $("#btnSendCode").css({"background": "#37D", "cursor": "pointer"}).attr('is_get_code', '1');
                                        } else {
                                            curCount--;
                                            $("#btnSendCode").html("" + curCount + "s重新发送");
                                        }
                                    }
                                    /***发送邮件 ***/
                                    //发送邮箱验证码
                                    var codeStatus = true;
                                    $("#submitSendCode1").click(function () {
                                        if (codeStatus == false) {
                                            return false;
                                        } else {
                                            codeStatus = false;
                                        }
                                        try {
                                            var email = $("input[name='email']").val();
                                            var vcode = ($("input[name='vcode']").val()).toLowerCase();

                                            if (!isEmail(email)) {
                                                throw   new Error("请填写正确的邮箱号");
                                            }
                                            if (vcode.length < 4) {
                                                $("#verifycode1").trigger("click");
                                                throw   new Error("请填写图形验证码");
                                            }
                                            $.post("/send_code/sendEmailCode", {email: email, type: 2, verifycode: vcode}, function (json) {
                                                var data = eval("(" + json + ")");
                                                if (data.code == 2000) {
                                                    alert("请进入您的邮箱查看验证码");
                                                    countdown("btnSendCode2");
                                                    //$(".huoqu_hidden2").hide();						
                                                    $(".yzm_guanbi").trigger("click");
                                                    $("#verifycode1").trigger("click");
                                                } else {
                                                    codeStatus = true;
                                                    alert(data.msg);
                                                    $("#verifycode1").trigger("click");
                                                }

                                            });
                                        } catch (err) {
                                            alert(err.message);
                                            codeStatus = true;
                                        }
                                    })
                                    //修改邮箱
                                    $("#email_submit").click(function () {
                                        var email = $('input[name="email"]').val();
                                        var code1 = $('input[name="code1"]').val();
                                        if (email == '') {
                                            alert('邮箱不能为空!');
                                            return false;
                                        }

                                        $.post(
                                                "<?php echo site_url('/admin/b2/expert/update_email'); ?>",
                                                {'email': email, 'code1': code1},
                                                function (data) {
                                                    data = eval('(' + data + ')');
                                                    if (data.status == 1) {
                                                        alert(data.msg);
                                                        $('#expert_email').val(data.email);
                                                        $('#yzm_cancel').click();
                                                    } else {
                                                        alert(data.msg);
                                                    }
                                                }
                                        );
                                    });
                                    //服务地区
                                    $('select[name="country_id"]').change(function () {
                                        var country_id = $('select[name="country_id"] :selected').val();
                                        if (country_id == 1) {
                                            $('#up_service').html(' <div class="gender_B fl"><input type="radio" name="visit_service[]" value="1" style="left:-18px;"><span>是</span></div> <div class="gender_G fl"><input type="radio" name="visit_service[]" value="0" style="left:-18px;"><span>否</span></div>');
                                            $('.chen_list').html('');
                                        } else {
                                            $('#up_service').html('');
                                        }
                                        $('#province_id').remove();
                                        $('#city_id').remove();
                                        $('#region_id').remove();
                                        if (country_id == 0) {
                                            return false;
                                        }
                                        $.post(
                                                "<?php echo site_url('admin/b2/expert/get_area') ?>",
                                                {'id': country_id},
                                                function (data) {
                                                    data = eval('(' + data + ')');
                                                    $('#country_id').after("<select name='province_id' id='province_id'><option value='0'>请选择</option></select>");
                                                    $.each(data, function (key, val) {
                                                        str = "<option value='" + val.id + "'>" + val.name + "</option>";
                                                        $('#province_id').append(str);
                                                    })
                                                    $('#province_id').change(function () {
                                                        var province_id = $('select[name="province_id"] :selected').val();
                                                        province(province_id)
                                                    })
                                                }
                                        );
                                    })

                                    function province(id) {
                                        $('#city_id').remove();
                                        $('#region_id').remove();
                                        if (id == 0) {
                                            return false;
                                        }
                                        $.post(
                                            "<?php echo site_url('admin/b2/expert/get_area') ?>",
                                            {'id': id},
                                            function (data) {
                                                data = eval('(' + data + ')');
                                                if (data != '') {
                                                    $('#province_id').after("<select name='city_id' id='city_id'><option value='0'>请选择</option></select>");
                                                    $.each(data, function (key, val) {
                                                        str = "<option value='" + val.id + "'>" + val.name + "</option>";
                                                        $('#city_id').append(str);
                                                    })
                                                    $('#city_id').change(function () {
                                                        var city_id = $('select[name="city_id"] :selected').val();
                                                        city(city_id)
                                                    })

                                                } else {
                                                    $('#city_id').remove();
                                                }

                                            }
                                        );
                                    }

                                    function city(id) {
                                        $('#region_id').remove();
                                        if (id == 0) {
                                            return false;
                                        }
                                        $.post(
                                            "<?php echo site_url('admin/b2/expert/get_area') ?>",
                                            {'id': id},
                                            function (data) {
                                                $('#get_area').html('');
                                                data = eval('(' + data + ')');
                                                /*		$('#city_id').after("<select name='region_id' id='region_id'><option value='0'>请选择</option></select>");*/
                                                var str = '<li><input type="checkbox" name="visit_allservice[]" checked="true" value="0" id="checkAll" /> <p>全部</p></li>';
                                                $.each(data, function (key, val) {
                                                    str = str + '<li><input type="checkbox" checked="true" name="visit_service[]" value="' + val.id + '" /><p>' + val.name + '</p></li>';
                                                })
                                                //	alert(str);
                                                $('.chen_list').html(str);
                                                $("#checkAll").click(function () {
                                                    $('input[name="visit_service[]"]').attr("checked", this.checked);
                                                })
                                            }
                                        );
                                    }

                                    $('#province_id').change(function () {
                                        var province_id = $('select[name="province_id"] :selected').val();
                                        province(province_id)
                                    })

                                    $('#city_id').change(function () {
                                        var city_id = $('select[name="city_id"] :selected').val();
                                        city(city_id)
                                    })

                                    //上门服务的全选按钮
                                var service = $('.visit_service_list').find('input');
                            
                                   if(service.length>0){
                                  	  if (service[0].checked == true) {
                                          $('input[name="visit_allservice[]"]').attr("checked", "checked");
                                      }
                                    }
                                  

                                    $("#checkAll").click(function () {
                                        //alert($(this).val());
                                        $('input[name="visit_service[]"]').attr("checked", this.checked);
                                    })

// ****************************上传的图片放大和缩小*****************************//
                                    $(".img_fangda").click(function () {

                                        var src = $(this).attr("src");
                                        $(".imFangda").show();
                                        $(".imFangda").find("img").attr("src", src);

                                        $(".imFangda").find("img").animate({
                                            width: "540px",
                                            height: "240px",
                                            marginLeft: "-270px",
                                            marginTop: "-120px",
                                        }, 500);
                                    });

                                    $(".imFangda").click(function (e) {
                                        var _con = $('.imFangda img');   // 设置目标区域

                                        if (!_con.is(e.target) && _con.has(e.target).length === 0) {

                                            $(".imFangda").hide();
                                            $(".imFangda").find("img").css({
                                                width: "0",
                                                height: "0",
                                                marginLeft: "0",
                                                marginTop: "0",
                                            })


                                        }
                                    })

// **********************上传的图片放大和缩小  END     ***********************//


// ****************************选择擅长线路 *****************************//

                                    //触发显示
                                    $(".longs_blue").click(function () {
                                        $('.generated_city li').each(function () {
                                            var thisVl = $(this).val();
                                            $('.city_longs li').each(function () {
                                                if ($(this).hasClass("active-dest")) {
                                                    //
                                                } else {
                                                    if (thisVl == $(this).val()) {
                                                        $(this).addClass('active-dest').append('<i class="clixk_ok"></i>');
                                                    }
                                                }
                                            })
                                        })
                                        $(".city_longs").show();
                                    });

                                    //点击事件  生成标签 ==
                                    $(".city_longs li").click(function () {

                                        //判断点击的是不是i出境游类的标题

                                        if ($(this).hasClass("city_mune")) {

                                            //alert('当前标题不可选择!');

                                        } else {

                                            //判断当前下有没有i这个图标

                                        var thisVl = $(this).val();    //当前点击的val

                                        var thisHt = $(this).html();    //当前点击的html

                                        if ($(this).find("i").length < 1) {

                                                $(this).addClass('active-dest').append('<i class="clixk_ok"></i>');

                                                $(this).parent().next('.generated_city').append('<li class="cityID" value=' + thisVl + '>' + thisHt + '<span>X</span></li>');

                                            } else {

                                                $(this).removeClass('active-dest').find("i").remove();

                                                $('.generated_city li').each(function () {

                                                    if (thisVl == $(this).val()) {

                                                        $(this).remove();
                                                    }
                                                })
                                            }
                                            ;
                                            //判断当前已选择的是否超过5个
                                        var len = $('.generated_city li').length;
                                            if (len > 5) {
                                                $(this).removeClass('active-dest').find("i").remove();

                                                $(this).parent().hide();

                                                $(this).parent().next('.generated_city').find('li').eq(5).remove();

                                                alert("最多可以选择5个擅长目的地");
                                            }

                                            /*            if($(this).parent().find('i').length>5){
                                                     
                                             $(this).removeClass('active-dest').find("i").remove();
                                                     
                                             $(this).parent().hide();
                                                     
                                             $(this).parent().next('.generated_city').find('li').eq(5).remove();
                                                     
                                             alert("最多可以选择5个擅长目的地");
                                                     
                                             } */

                                        }
                                        ;

                                    });

                                    //点击已生成便签的 删除 事件
                                    $('.generated_city li span').live('click', function () {

                                        //alert('1')
                                    var lineLi = $('.generated_city li').length;   //  获取已经生成标签的数量  (数量0 要隐藏 )

                                    var thisVl = $(this).parent('li').val();    //当前点击的val

                                        $(this).parent('li').remove();

                                        $('.city_longs li').each(function () {

                                            if (thisVl == $(this).val()) {

                                                $(this).removeClass('active-dest').find('i').remove();

                                            }
                                        })

                                        // 点击已生成标签的删除需要 把显示出来的列表隐藏
                                        if (lineLi < 2) {

                                            $('.city_longs').hide();
                                        }

                                    })

                                    $(document).mouseup(function (e) {

                                        var _con = $('.col_sq');   // 设置目标区域

                                        if (!_con.is(e.target) && _con.has(e.target).length === 0) {

                                            $(".col_sq").find('.city_longs').hide()


                                        }

                                    });

//$('.longs_blue').toggle(function(){$(".city_longs").show()}, function(){$(".city_longs").hide()});

//****************************选择擅长线路  END *****************************//
</script>