<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- Head -->
<head>
<meta charset="utf-8" />
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta name="description" content="Dashboard" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管家管理系统</title>
<link rel="icon" href="/bangu.ico" type="image/x-icon"/>

<link href="<?php echo base_url('assets/css/v2/b2_base.css');?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.11.1.min.js');?>"></script>
 <script type="text/javascript" src="/assets/ht/js/layer.js"></script>
    <script type="text/javascript" src="/assets/ht/js/laypage.js"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/ht/js/common/common.js?v=".time()); ?>"></script>
</head>
<script >
$(function(){
    var isIE=!!window.ActiveXObject;
    var isIE8=isIE&&!!document.documentMode;
if(navigator.userAgent.indexOf("MSIE")>0){
      if(navigator.userAgent.indexOf("MSIE 6.0")>0){
        location.href('/admin/update');
      }
      if(navigator.userAgent.indexOf("MSIE 7.0")>0){
        location.href('/admin/update');
      }

      if(navigator.userAgent.indexOf("MSIE 9.0")>0){

        return false;
      }
      if(navigator.userAgent.indexOf("MSIE 10.0")>0){

        return false;
      }
      if(navigator.userAgent.indexOf("MSIE 11.0")>0){

        return false;
      }
      if(isIE8){//这里是重点，你懂的
	  	return false;
        location.href('/admin/update');
      }
    }
})
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
<body onload="setInterval('alert_unread_message()',60000);setInterval('getNewMsg()',5000);">


