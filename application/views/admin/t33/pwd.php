<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>
<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}

.bank{width:400px;height:300px;border:1px solid #ddd;padding:0px 20px;float:left;margin:0 20px;}
.bank p{height:32px;line-height:32px;margin:20px auto;}


.bank_div{width:476px;height:226px;border:1px solid #F1F2F2;margin:3% 0 0 10%;-moz-border-radius: 5px;     
    -webkit-border-radius: 5px;   
    border-radius:5px;       }
.bank_div .part1{height:66px;line-height:66px;width:100%;float:left;background:#70C1ED;-moz-border-radius: 5px;     
    -webkit-border-radius: 5px;   
    border-radius:5px;color:#fff;font-size:18px; padding:5px;}
.bank_div .part1 font{color:#fff;font-size:14px;float:right;margin-top:10px;margin-right:4%;}


.bank_div .part2{width:100%;float:left;margin-top:5%;}
.bank_div .part2 .p1{width:12%;float:left;padding:8px;background:#70C1ED;margin-left:5%;text-align:center;color:#fff;} 
.bank_div .part2 .p2{width:60%;float:left;padding:8px;margin-left:10%;font-size:14px;letter-spacing:1px;} 

</style>
</head>
<body>


<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>

<!--=================右侧内容区================= -->
    <div class="page-body m_w" id="bodyMsg">
    
        <!-- ===============我的位置============ -->
        <div class="current_page">
            <a href="#" class="main_page_link"><i></i>个人中心</a>
            <span class="right_jiantou">&gt;</span>
            <a href="#">账号设置</a>
        </div>
        
        <!-- =============== 右侧主体内容  ============ -->
        <div class="page_content bg_gray" style="float:left;width:100%;">      
            
            <!-- tab切换表格 -->
            <div class="table_content" style="float:left;width:100%;">
                <div class="itab">
                    <ul> 
                        <li static="1" data-id="1"><a href="#tab1" class="active">修改资料</a></li> 
                         <!-- <li static="1" data-id="2"><a href="#tab1">上传logo</a></li>  -->
      
                    </ul>
                </div>
                <div class="tab_content" id="union_bank" style="float:left;width:500px;margin:0 100px;min-height:680px;">
                   <div class="fb-content" id="form1">
						   
						    <div class="fb-form">
						        <form method="post" action="#" id="employee_from" class="form-horizontal ">
						           
						           
						            <div class="form-group div2">
						                <div class="fg-title">登录账号：</div>
						                <div class="fg-input"><input type="text" id="loginname" name="loginname" value="<?php echo $loginname;?>" readonly></div>
						            </div>
						           <div class="form-group">
						                <div class="fg-title">选择角色：<i>*</i></div>
						                <div class="fg-input">
						                       <ul class="role_content">
						                      
						                         <li><label><input type="radio" class="fg-radio sex" <?php if($sex=="1") echo "checked";?> name="roleid" value="1">男</label></li>
						                         <li><label><input type="radio" class="fg-radio sex" <?php if($sex=="0") echo "checked";?> name="roleid" value="0">女</label></li>
						                    </ul>
						                </div>
						           </div>
						         
						       
						             <div class="form-group">
						                <div class="fg-title">真实姓名：<i>*</i></div>
						                <div class="fg-input"><input type="text" id="realname" name="" value="<?php echo $realname;?>"></div>
						            </div>
						            <div class="form-group">
						                <div class="fg-title">手机号码：<i>*</i></div>
						                <div class="fg-input"><input type="text" id="mobile" name="mobile" value="<?php echo $mobile;?>"></div>
						            </div>
						              <div class="form-group">
						                <div class="fg-title">邮箱：<i></i></div>
						                <div class="fg-input"><input type="text" id="email" name="email" value="<?php echo $email;?>"></div>
						            </div>
						            <div class="form-group">
						                <div class="fg-title">登录密码：<i>*</i></div>
						                <div class="fg-input">
						                       <input type="password" name="password" id="password" placeholder="不填写默认原密码" >
						                </div>
						            </div>
						            
						            <div class="form-group">
						                <div class="fg-title">个性说明：</div>
						                <div class="fg-input"><textarea id="remark"><?php echo $remark;?></textarea></div>
						            </div>
						
						            <div class="form-group" style="text-align: center;">
						               
						                <input type="button" class="fg-but btn_save" style="float:inherit;" value="保存">
						            </div>
						            <div class="clear"></div>
						        </form>
						    </div>
						</div>


                </div>
                </div>
                <div class="tab_content" id="bangu_bank" style="display:none;float:left;width:100%;min-height:680px;">
                    <div class="table_list">
                        <div class="bank_div">
                            <div class="part1"><?php echo isset($bangu_bank['bankname'])==true?$bangu_bank['bankname']:'';?>  <font>支行：<?php echo isset($bangu_bank['branch'])==true?$bangu_bank['branch']:'';?></font></div>
                            <div class="part2"><p class="p1">卡号</p><p class="p2"><?php echo isset($bangu_bank['bankcard'])==true?$bangu_bank['bankcard']:'';?></p></div>
                            <div class="part2"><p class="p1">开户人</p><p class="p2"><?php echo isset($bangu_bank['cardholder'])==true?$bangu_bank['cardholder']:'';?></p></div>
                        </div>
                       

				    </div>
                      
                    </div>                   
                </div>
                
            </div>

        </div>
        
    </div>
   
 

<script type="text/javascript">
//js对象
var object = object || {};
var ajax_data={};
object = {
    send_ajax_noload:function(url,data){  //发送ajax请求，无加载层
  	      //没有加载效果
          var ret;
    	  $.ajax({
        	 url:url,
        	 type:"POST",
             data:data,
             async:false,
             dataType:"json",
             success:function(data){
            	 ret=data;
            	
             },
             error:function(){
            	 ret=data;
             }
                     
        	});
      	    return ret;

  }
  //object  end
};
$(document).ready(function(){


	//保存修改
	$(".btn_save").click(function(){

		var realname=$("#realname").val();
		var mobile=$("#mobile").val();
		var password=$("#password").val();
		var email=$("#email").val();
		var remark=$("#remark").val();
		var sex=$(".sex:checked").val();

		if(sex!="0"&&sex!="1") {tan('请选择性别');return false;}
		if(realname=="") {tan('真实姓名不能为空');return false;}
		if(mobile=="")   {tan('手机号码不能为空');return false;}
 		
		var url="<?php echo base_url('admin/t33/home/api_update_info')?>";
		var data={realname:realname,mobile:mobile,password:password,email:email,remark:remark,sex:sex};
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code=="2000")
		{
			tan2(return_data.data);
			t33_refresh();
		}
		else
		{
			tan(return_data.msg);
		}
    })
	//tab切换
	$(".itab ul li").click(function()
    {
     var value=$(this).attr("data-id");
     
     if(value==1)
     {
         $("#bangu_bank").hide();
         $("#union_bank").show();
     }
     else if(value==2)
     {
    	
    	 $("#bangu_bank").css("display","block");
         $("#union_bank").css("display","none");
     }
		 
   })
		
	
})

</script>
</html>


