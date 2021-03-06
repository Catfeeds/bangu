<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
    <meta charset="utf-8" />
    <title>管家管理系统</title>

    <meta name="description" content="Dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- 声明某些双核浏览器使用webkit进行渲染 -->
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png');?>" type="image/x-icon">

    <!--Basic Styles-->
    <link href="/assets/css/b2_style.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/weather-icons.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/dataTables.bootstrap.css');?>" rel="stylesheet" />
    <link href="/assets/js/jQuery-plugin/citylist/city.css" rel="stylesheet" />
    <!--Fonts-->
    <link href="<?php echo base_url('assets/css/fonts.css');?>" rel="stylesheet" type="text/css">

    <!--Beyond styles-->
    <link id="beyond-link" href="<?php echo base_url('assets/css/beyond.min.css');?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/css/demo.min.css');?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/typicons.min.css');?>" rel="stylesheet" />

    <link href="<?php echo base_url('assets/css/b2_header.css');?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.countdownTimer.css');?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/qiangdan.css');?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/order_detail_info.css');?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/reply_project.css');?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/turn_price_form.css');?>" rel="stylesheet" />

    <link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />

    <!--Skin Script: Place this script in head to load scripts for skins and rtl support-->
    <script src="<?php echo base_url('assets/js/skins.min.js');?>"></script>
    <!--Basic Scripts-->
    <script src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootbox/bootbox.js');?>"></script>
    <script src="<?php echo base_url('assets/js/jquery-paging.js');?>"></script>
    <script  src="<?php echo base_url('assets/js/jquery.countdownTimer.js');?>"></script>
    <script src="<?php echo base_url('assets/js/ajaxfileupload.js') ;?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.messager.js') ;?>"></script>
    <script type="text/javascript" src="/assets/ht/js/base.js"></script>
    <script type="text/javascript" src="/assets/ht/js/layer.js"></script>
    <script type="text/javascript" src="/assets/ht/js/laypage.js"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/ht/js/common/common.js?v=".time()); ?>"></script>
    <script type="text/javascript" src="/assets/js/jquery.pageTable.js"></script>
    <style type="text/css">
    	#xiuxiuEditor,#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3 { top:0px !important;}
		.right_box { top:50px !important;}
		.close_xiu { top:5px !important;}
    </style>
</head>

<!-- /Head -->
<!-- Body onload="setInterval('alert_unread_message()',60000);setInterval('getNewMsg()',2000);"-->
<body onload="setInterval('alert_unread_message()',60000);setInterval('getNewMsg()',5000);">



<!-- 弹框背景 -->
<div class="bg_box"></div>

<!-- 右侧返回顶部 -->
    <!--<div class="return_top">
        <ul>
            <li><a href="<?php $expert_id=$this->session->userdata('expert_id'); echo $web_config['expert_question_url'].'/kefu_expert.html?eid='.$expert_id; ?>" title="我的客户" class="kefu_link" target="_blank"><img class="kefu_logo" src="<?php echo base_url('static'); ?>/img/kefu_ico.png"/><img class="kefu_message" src="<?php echo base_url('assets'); ?>/img/kefu_msg.gif"/></a></li>
            <li><a href="#" title="返回顶部" class="return_top"><i></i></a></li>
        </ul>
    </div> -->
<script type="text/javascript">
function expert_loginout(){
    if(confirm('确定要退出吗?')){
        location.href="<?php echo site_url('admin/b2/login/logout')?>";
    }
}


    var foo=true;
    $(".choose_static").click(function(){
        if(foo){
            $(this).find('ul').show();
            foo=false;
        }else{
            $(this).find('ul').hide();
            foo=true;
        }
    });

            function online_status(obj){
                var online_status = $(obj).attr('data-val');
                var send_url="<?php echo $web_config['expert_question_url'].'/chat!updateExpertStatus.do'?>" ;
                if(online_status==0){
                    if(confirm('确定要退出吗?')){
                      $.ajax({
                                url : send_url,
                                dataType:"jsonp",
                                type : 'POST',
                                data : {
                                    'expert_id' : <?php echo $this->session->userdata('expert_id')?>,
                                    'newStatus':online_status
                                },
                                success : function(jsonData) {
                                    location.href="<?php echo site_url('admin/b2/login/logout')?>";
                                }
                            });
                        }
                }else{
                    $.ajax({
                                url : send_url,
                                dataType:"jsonp",
                                type : 'POST',
                                data : {
                                    'expert_id' : <?php echo $this->session->userdata('expert_id')?>,
                                    'newStatus':online_status
                                },
                                success : function(jsonData) {
                                    $("#online_txt").html($(obj).html());
                                }
                            });
                }

            }



    /***
    *
    * 根据管家ID 获取最新未读人数.
    *
    * */
    function getNewMsg(){
        var send_url="<?php echo $web_config['expert_question_url'].'/chat!getMsgCount.do'?>" ;
            $.ajax({
                url : send_url,
                dataType:"jsonp",
                type : 'POST',
                data : {
                    'expert_id' : <?php echo $this->session->userdata('expert_id')?>,
                    'action':1
                },
                success : function(jsonData) {
                    if (jsonData.code == '2000') {//成功
                        if(jsonData.data >0){//有新消息
                            //显示泡泡
                            $(".kefu_message").show();
                        }else{
                            //隐藏泡泡
                             $(".kefu_message").hide();
                        }
                    } else {
                    }
                }
            });

    }


    function alert_unread_message(){
        $.post("<?php echo base_url('admin/b2/home/get_unread_bus_msg')?>",
                {'minutes':1},
                function(data){
                    data = eval('('+data+')');
                    if(data>=1){
                        $.messager.lays(300, 200);
                        $.messager.show(0, "<a href='<?php echo base_url('admin/b2/message/index');?>'>你有未读新消息</a>",300000);
                    }
                });

    }


</script>

<!-- 美图秀秀 -->
<div id="altContent"></div>
<div class="close_xiu" style="">X</div>
 <div class='avatar_box'></div>

    <!-- /Navbar -->
    <!-- Main Container -->
    <div class="main-container container-fluid">
        <!-- Page Container -->
        <div class="page-container">


            <!-- Page Content -->
            <div class="page-content">



