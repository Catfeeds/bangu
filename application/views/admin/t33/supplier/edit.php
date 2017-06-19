<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
select{display:inline-block;margin-right:5px;}
</style>
</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
 <!-- 添加供应商 弹窗 -->
<div class="fb-content" id="form1">
   
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal">
           <div style="min-height: 704px;">
           <div class="form-group div9">
                <div class="fg-title">登录账号<i>*</i>：</div>
                <div class="small-input"><input type="text" id="login_name" class="showorder" placeholder="" name="showorder" value="<?php echo $login_name;?>"></div>
            </div>
             <div class="form-group div9">
                <div class="fg-title">登录密码：</div>
                <div class="small-input"><input type="text" id="password" class="showorder" placeholder="不填写则默认原密码" name="showorder"></div>
            </div>
            <div class="form-group div9">
                <div class="fg-title">供应商代码<i>*</i>：</div>
                <div class="small-input"><input type="text" id="code" class="showorder" placeholder="" name="showorder" value="<?php echo $code;?>"></div>
            </div>
              <div class="form-group div9">
                <div class="fg-title">供应商名称<i>*</i>：</div>
                <div class="small-input"><input type="text" id="company_name" class="showorder" placeholder="" name="showorder" value="<?php echo $company_name;?>"></div>
            </div>
             <div class="form-group div9">
                <div class="fg-title">品牌名称<i>*</i>：</div>
                <div class="small-input"><input type="text" id="brand" class="showorder" placeholder="" name="showorder" value="<?php echo $brand;?>"></div>
            </div>
             <div class="form-group div13">
                <div class="fg-title">联系人姓名<i>*</i>：</div>
                <div class="small-input"><input type="text" class="showorder" id="linkman" placeholder="" name="showorder" value="<?php echo $linkman;?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title">联系人手机<i>*</i>：</div>
                <div class="small-input"><input type="text" class="showorder" id="link_mobile" placeholder="" name="showorder" value="<?php echo $link_mobile;?>"></div>
            </div>
             <div class="form-group div14">
                <div class="fg-title">负责人邮箱：</div>
                <div class="small-input"><input type="text" class="showorder" id="email" placeholder="" name="showorder" value="<?php echo $email;?>"></div>
            </div>
            <div class="form-group div13">
                <div class="fg-title">负责人姓名<i>*</i>：</div>
                <div class="small-input"><input type="text" class="showorder" id="realname" placeholder="" name="showorder" value="<?php echo $realname;?>"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title">负责人手机<i>*</i>：</div>
                <div class="small-input"><input type="text" class="showorder" id="mobile" placeholder="用于登录供应商系统" name="showorder" value="<?php echo $mobile;?>"></div>
            </div>
             <div class="form-group div14">
                <div class="fg-title">联系人邮箱<i>*</i>：</div>
                <div class="small-input"><input type="text" class="showorder" id="linkemail" placeholder="" name="showorder" value="<?php echo $linkemail;?>"></div>
            </div>
             <div class="form-group div19">
                <div class="fg-title">身份证扫描件<i>*</i>：</div>
                <div class="fg-input">
                    <input name="uploadFile4" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="idcardpic" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
                 <div style="text-align: left;width:100%;" class="olddiv">
                <img src="<?php echo BANGU_URL.$idcardpic;?>" height="80" style="margin-left:24%;" />
                </div>
            </div>
            <?php if($kind=="1"):?>
            <div class="form-group div6">
                <div class="fg-title">营业执照扫描件<i>*</i>：</div>
                <div class="fg-input">
                 
                    <input name="uploadFile" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="business_licence" type="hidden" value="">
                    <!-- <span>不上传则默认管家头像</span> -->
                 
                 
                </div>
                <div style="text-align: left;width:100%;" class="olddiv">
                <img src="<?php echo BANGU_URL.$business_licence;?>" height="80" style="margin-left:24%;" />
                </div>
            </div>
          
            <div class="form-group div7">
                <div class="fg-title">经营许可证扫描件<i>*</i>：</div>
                <div class="fg-input">
                  
                    <input name="uploadFile2" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="licence_img" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
                <div style="text-align: left;width:100%;" class="olddiv">
                <img src="<?php echo BANGU_URL.$licence_img;?>" height="80" style="margin-left:24%;" />
                </div>
            </div>
           
            <div class="form-group div8">
                <div class="fg-title">经营许可证编号<i>*</i>：</div>
                <div class="small-input"><input type="text" id="licence_img_code" class="showorder" placeholder="" name="showorder" value="<?php echo $licence_img_code;?>"></div>
            </div>
            <?php endif;?>
            
             <?php if($kind=="1"||$kind=="3"):?>
            <div class="form-group div9">
                <div class="fg-title">法定代表人姓名<i>*</i>：</div>
                <div class="small-input"><input type="text" id="corp_name" class="showorder" placeholder="" name="showorder" value="<?php echo $corp_name;?>"></div>
            </div>
            
             <div class="form-group div10">
                <div class="fg-title">法人代表身份证扫描件<i>*</i>：</div>
                <div class="fg-input">
                    <input name="uploadFile3" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="corp_idcardpic" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
                 <div style="text-align: left;width:100%;" class="olddiv">
                <img src="<?php echo BANGU_URL.$corp_idcardpic;?>" height="80" style="margin-left:24%;" />
                </div>
            </div>
           <?php endif;?>
           
           
          
            
            <!-- <div class="form-group">
                <div class="fg-title">描述：</div>
                <div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
            </div> -->
           </div>
            
            <div class="form-group" style="margin-bottom:20px;margin-bottom:20px;">
                <input type="hidden" name="id" value="">
                <input type="button" id="btn_close" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but" onclick="object.submitData()" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<script type="text/javascript">

var kind="<?php echo $kind;?>";
var supplier_id="<?php echo $id;?>"; //供应商id
var old_mobile="<?php echo $mobile;?>"; //供应商原来负责人联系方式
//js对象
var object = object || {};
var ajax_data={};
object = {
    init:function(){ //初始化方法
        
    	
    },
    submitData:function(){  //提交表单

    	
    	var idcardpic=$("#idcardpic").val();
    	
    	var business_licence=$("#business_licence").val(); //营业执照扫描件
    	var licence_img=$("#licence_img").val();           //经营许可证扫描件
    	var licence_img_code=$("#licence_img_code").val(); //经营许可证编号
    	var corp_name=$("#corp_name").val();  //法定代表人姓名
    	var corp_idcardpic=$("#corp_idcardpic").val();  //法定代表人姓名
    	var code=$("#code").val();

    	var login_name=$("#login_name").val();
    	var password=$("#password").val();
    	var company_name=$("#company_name").val();
    	var brand=$("#brand").val();
    	var linkman=$("#linkman").val();
    	var link_mobile=$("#link_mobile").val();

    	var realname=$("#realname").val();
    	var mobile=$("#mobile").val();
    	var email=$("#email").val();
    	var linkemail=$("#linkemail").val();
    	
    	if(login_name=="")  { tan('请填写登录账号');return false;}
    	if(code=="")  { tan('请填写供应商代码');return false;}
    	if(company_name=="")  { tan('请填写供应商名称');return false;}
    	if(brand=="")  { tan('请填写品牌名称');return false;}
    	if(realname=="")  { tan('请填写负责人姓名');return false;}
    	if(mobile=="")  { tan('请填写负责人手机号');return false;}
    	
    	if(kind=="1"&&licence_img_code=="")  { tan('请填写经营许可证编号');return false;}
    	if((kind=="1"&&corp_name=="")||(kind=="3"&&corp_name==""))  { tan('请填写法定代表人姓名');return false;}
    	

    	//数据
    	var postdata={
    			supplier_id:supplier_id,
    			kind:kind,
    			code:code,
    			idcardpic:idcardpic,
    			business_licence:business_licence,
    			licence_img:licence_img,
    			licence_img_code:licence_img_code,
    			corp_name:corp_name,
    			corp_idcardpic:corp_idcardpic,
    			realname:realname,
    			mobile:mobile,
    			old_mobile:old_mobile,
    			login_name:login_name,
    		    password:password,
    		    company_name:company_name,
    		    brand:brand,
    		    linkman:linkman,
    		    link_mobile:link_mobile,
    		    email:email,
    		    linkemail:linkemail
    			
    	}
    	var post_url="<?php echo base_url('admin/t33/supplier/to_edit')?>";
    	var return_data=object.send_ajax(post_url,postdata);
    	
    	if(return_data.code=="2000")
    	{
        	tan2(return_data.data);
    		setTimeout(function(){t33_close_iframe();},500);
    		
        }
    	else
    	{
        	tan(return_data.msg);
        }
    	
	 		
       
    },
    send_ajax:function(url,data){  //发送ajax请求，有加载层
    	  layer.load(2);//加载层
          var ret;
    	  $.ajax({
        	 url:url,
        	 type:"POST",
             data:data,
             async:false,
             dataType:"json",
             success:function(data){
            	 ret=data;
            	 setTimeout(function(){ layer.closeAll('loading');}, 200);  //0.2秒后消失
     
             },
             error:function(data){
            	 ret=data;
            	 //layer.closeAll('loading');
            	 layer.msg('请求失败', {icon: 2});
             }
                     
        	});
      	    return ret;
	  
      
    },
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
	
	object.init();
	

	var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	$('#btn_close').click(function()
	{
	      //传值到父iframe
	  	 /*var data = ['哈哈大文化','19','达瓦达瓦'];
		 parent.$('#val_box').text(data);
		 parent.$("#main")[0].contentWindow.getValue();*/
		 
	     parent.layer.close(index);
	});


})






</script>


</html>


