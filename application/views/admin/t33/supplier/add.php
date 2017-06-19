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
            <div class="form-group div1">
                <div class="fg-title">供应商类型：<i>*</i></div>
                <div class="fg-input">
                    <ul>
                    	<li><label><input type="radio" class="fg-radio supplier_type" name="is_show" value="1" checked >境内供应商</label></li>
                        <li><label><input type="radio" class="fg-radio supplier_type" name="is_show" value="3">境外供应商</label></li>
                        
                         <li><label><input type="radio" class="fg-radio supplier_type" name="is_show" value="2">个人</label></li>
                       
                    </ul>
                </div>
            </div>
            <div class="form-group div2">
                <div class="fg-title">供应商名称：<i>*</i></div>
                <div class="fg-input"><input type="text" id="company_name" class="showorder" placeholder="所属企业名称" name="showorder"></div>
            </div>
            <div class="form-group div3">
                <div class="fg-title">供应商品牌：<i>*</i></div>
                <div class="fg-input"><input type="text" id="brand" class="showorder" placeholder="若没有，可填写公司简称+部门名，最多5个字" name="showorder"></div>
            </div>
             <div class="form-group div4">
                <div class="fg-title">主营业务：<i>*</i></div>
                <div class="fg-input"><input type="text" id="expert_business" class="showorder" placeholder="" name="showorder"></div>
            </div>
             <div class="form-group div4">
                <div class="fg-title">供应商代码：<i>*</i></div>
                <div class="small-input"><input type="text" id="code" class="showorder" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div5">
                <div class="fg-title">所在地：<i>*</i></div>
                 <div class="form_select">
                  
                 
                  	<select name="country" class="select_one" id="country" data-value="" style="width:137px">
                  		
                  		
                  	</select>
                  
                  	<select name="province" class="select_two" id="province" style="width: 137px; display: none;">
                  	
                  	</select>
                  	
                  	<select name="city" class="select_three" id="city" style="width: 137px; display: none;">
                  	
                  	</select>
                  </div>
                  
            </div>
             <div class="form-group div19">
                <div class="fg-title">身份证扫描件：<i>*</i></div>
                <div class="fg-input">
                    <input name="uploadFile4" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="idcardpic" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
            </div>
            <div class="form-group div6">
                <div class="fg-title">营业执照扫描件：<i>*</i></div>
                <div class="fg-input">
                 
                    <input name="uploadFile" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="business_licence" type="hidden" value="">
                    <!-- <span>不上传则默认管家头像</span> -->
                 </input>
                </div>
            </div>
           
           
            <div class="form-group div7">
                <div class="fg-title">经营许可证扫描件：<i>*</i></div>
                <div class="fg-input">
                  
                    <input name="uploadFile2" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="licence_img" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
            </div>
           
            <div class="form-group div8">
                <div class="fg-title">经营许可证编号：<i>*</i></div>
                <div class="small-input"><input type="text" id="licence_img_code" class="showorder" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div9">
                <div class="fg-title">法定代表人姓名：<i>*</i></div>
                <div class="small-input"><input type="text" id="corp_name" class="showorder" placeholder="" name="showorder"></div>
            </div>
            
             <div class="form-group div10">
                <div class="fg-title">法人代表身份证扫描件：<i>*</i></div>
                <div class="fg-input">
                    <input name="uploadFile3" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="corp_idcardpic" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
            </div>
            <div class="form-group div11">
                <div class="fg-title">设置登录密码：<i>*</i></div>
                <div class="small-input"><input type="password" id="password" class="showorder" placeholder="请填写6到20位的密码" name="showorder"></div>
            </div>
            <div class="form-group div12">
                <div class="fg-title">重复登录密码：<i>*</i></div>
                <div class="small-input"><input type="password" id="password2" class="showorder" placeholder="请填写6到20位的密码" name="showorder"></div>
            </div>
            <div class="form-group div13">
                <div class="fg-title">负责人姓名：<i>*</i></div>
                <div class="small-input"><input type="text" class="showorder" id="realname" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div14">
                <div class="fg-title">负责人手机号：<i>*</i></div>
                <div class="small-input"><input type="text" class="showorder" id="mobile" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div15">
                <div class="fg-title">联系人：<i>*</i></div>
                <div class="small-input"><input type="text" class="showorder" id="linkman" placeholder="" name="showorder"></div>
            </div>
             <div class="form-group div16">
                <div class="fg-title">联系人手机号：<i>*</i></div>
                <div class="small-input"><input type="text" class="showorder" id="link_mobile" placeholder="用于登录供应商系统" name="showorder"></div>
            </div>
             <div class="form-group div19">
                <div class="fg-title">电子邮箱：<i>*</i></div>
                <div class="small-input"><input type="text" class="showorder" id="email" placeholder="" name="showorder"></div>
            </div>
             <div class="form-group div17">
                <div class="fg-title">电话：</div>
                <div class="small-input"><input type="text" id="telephone" class="showorder" placeholder="" name="showorder"></div>
            </div>
             <div class="form-group div18">
                <div class="fg-title">传真：</div>
                <div class="small-input"><input type="text" id="fax" class="showorder" placeholder="" name="showorder"></div>
            </div>
            
            <!-- <div class="form-group">
                <div class="fg-title">描述：</div>
                <div class="fg-input"><textarea name="beizhu" maxlength="30" placeholder="最多30个字"></textarea></div>
            </div> -->
           
            
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


//js对象
var object = object || {};
var ajax_data={};
object = {
    init:function(){ //初始化方法
        
    	//拉取select数据
    	object.getArea(0);
    },
    submitData:function(){  //提交表单
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var supplier_type=$('input:radio:checked').val();
	    	var company_name=$("#company_name").val();
	    	var brand=$("#brand").val();
	    	var expert_business=$("#expert_business").val();
	    	var code=$("#code").val();
	    	var country=$("#country").attr("data-value");
	    	var province=$("#province").attr("data-value");
	    	var city=$("#city").attr("data-value");
	    	var idcardpic=$("#idcardpic").val();
	    	
	    	
	    	var business_licence=$("#business_licence").val(); //营业执照扫描件
	    	var licence_img=$("#licence_img").val();           //经营许可证扫描件
	    	var licence_img_code=$("#licence_img_code").val(); //经营许可证编号
	    	var corp_name=$("#corp_name").val();  //法定代表人姓名
	    	var corp_idcardpic=$("#corp_idcardpic").val();  //法定代表人姓名
	    	
	    	var password=$("#password").val();// 密码
	    	var password2=$("#password2").val();// 密码
	    	
	    	var realname=$("#realname").val();
	    	var mobile=$("#mobile").val();
	    	var linkman=$("#linkman").val();
	    	var link_mobile=$("#link_mobile").val();
	    	var email=$("#email").val();
	    	var telephone=$("#telephone").val();
	    	var fax=$("#fax").val();
	
	    	if((supplier_type=="1"&&company_name=="")||(supplier_type=="3"&&company_name==""))  {tan('请填写供应商名称');return false;}
	    	
	    	if(brand=="")  {tan('请填写供应商品牌');return false;}
	    	if(expert_business=="")  {tan('请填写主营业务');return false;}
	    	if(code=="")  {tan('请填写供应商代码');return false;}
	    	if(country=="") {tan('请选择所在地');return false;}
	    	if(idcardpic=="") {tan('请上传身份证扫描件');return false;}
	    	
	    	if(supplier_type=="1"&&business_licence=="") {tan('请上传营业执照扫描件');return false;}
	    	if(supplier_type=="1"&&licence_img=="") {tan('请上传经营许可证扫描件');return false;}
	    	if(supplier_type=="1"&&licence_img_code=="")  { tan('请填写经营许可证编号');return false;}
	    	if((supplier_type=="1"&&corp_name=="")||(supplier_type=="3"&&corp_name==""))  { tan('请填写法定代表人姓名');return false;}
	    	if((supplier_type=="1"&&corp_idcardpic=="")||(supplier_type=="3"&&corp_idcardpic==""))  { tan('请上传法人代表身份证扫描件');return false;}
	    	
	
	    	if(password==""||password.length<6||password.length>24) {tan('请填写6到20位的密码');return false;}
	    	if(password!=password2) {tan('两次输入密码不一致');return false;}
	
	    	if(realname=="")  { tan('请填写负责人姓名');return false;}
	    	if(mobile=="")  { tan('请填写负责人手机号');return false;}
	
	    	if(linkman=="") {tan('请填写联系人姓名');return false;}
	    	if(link_mobile=="") {tan('请填写联系人手机号');return false;}
	    	if(email=="") {tan('请填写电子邮箱');return false;} 
	
	    	//数据
	    	var postdata={
	    			kind:supplier_type,
	    			company_name:company_name,
	    			brand:brand,
	    			expert_business:expert_business,
	    			code:code,
	    			country:country,
	    			province:province,
	    			city:city,
	    			idcardpic:idcardpic,
	    			business_licence:business_licence,
	    			licence_img:licence_img,
	    			licence_img_code:licence_img_code,
	    			corp_name:corp_name,
	    			corp_idcardpic:corp_idcardpic,
	    			password:password,
	    			password2:password2,
	    			realname:realname,
	    			mobile:mobile,
	    			linkman:linkman,
	    			link_mobile:link_mobile,
	    			email:email,
	    			telephone:telephone,
	    			fax:fax
	    	}
	    	var post_url="<?php echo base_url('admin/t33/supplier/to_add')?>";
	    	var return_data=object.send_ajax(post_url,postdata);
	    	
	    	if(return_data.code=="2000")
	    	{
	    		var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
	    		parent.layer.msg(return_data.data, {icon: 1});
	    		setTimeout(function(){parent.layer.close(index);}, 200);  //0.2秒后消失
	        }
	    	else
	    	{
	        	tan(return_data.msg);
	        }
    	}
	 		
       
    },
    getArea:function(pid){  //获取一级地区
    	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
    	var post_data={pid:pid};
    	var return_data=object.send_ajax_noload(post_url,post_data);
    	if(return_data.code=="2000")
    	{
    		var json=return_data.data;
    		var str="";
    		str += "<option value='0'>请选择</option>";
        	for(var i in json)
        	{
	        	str += "<option value='"+json[i].id+"' class='li_one'>"+json[i].name+"</option>";
	        		
            }
          
            $(".select_one").html(str);
    	}
     },
    getArea_two:function(pid){  //获取二级地区
    	
     	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
     	var post_data={pid:pid};
     	var return_data=object.send_ajax_noload(post_url,post_data);
     
     	if(return_data.code=="2000")
     	{
     		var json=return_data.data;
     		var str="";
     		str += "<option value='0'>请选择</option>";
        	for(var i in json)
        	{
	        	str += "<option value='"+json[i].id+"' class='li_two'>"+json[i].name+"</option>";
	        		
            }
	          
            $(".select_two").html(str);
            $("#province").css("display","inline-block");
     	}
      },
    getArea_three:function(pid){  //获取三级地区

       	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
       	var post_data={pid:pid};
       	var return_data=object.send_ajax_noload(post_url,post_data);
       	
       	if(return_data.code=="2000")
       	{
       		var json=return_data.data;
       		var str="";
       		str += "<option value='0'>请选择</option>";
        	for(var i in json)
        	{
	        	str += "<option value='"+json[i].id+"' class='li_three'>"+json[i].name+"</option>";
	        		
            }
	           
            $(".select_three").html(str);
            $("#city").css("display","inline-block");
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
	$("body").on("change","#country",function(){
		var value=$(this).children('option:selected').val();
  		var con=$(this).children('option:selected').html();
  		$("#country").attr("data-value",value);
		object.getArea_two(value);
	
	});
	$("body").on("change","#province",function(){
		
		var value=$(this).children('option:selected').val();
  		var con=$(this).children('option:selected').html();
  		
  		$("#province").attr("data-value",value);
		object.getArea_three(value);
		
	});
	$("body").on("change","#city",function(){
		var value=$(this).children('option:selected').val();
  		var con=$(this).children('option:selected').html();
  		$("#city").attr("data-value",value);
		
		
	});
	
	$(".supplier_type").click(function(){
		var value=$(this).val();
		if(value=="3")
		{
			$(".form-group").show();
			$(".div6").hide();
			$(".div7").hide();
			$(".div8").hide();
		}
		else if(value=="2")
		{
			$(".div2").hide();
			$(".div6").hide();
			$(".div7").hide();
			$(".div8").hide();
			$(".div9").hide();
			$(".div10").hide();
			
		}
		else if(value=="1")
		{
			$(".form-group").show();
		}

	})
	
	
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


