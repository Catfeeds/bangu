<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>my title</title>

<style type="text/css">
.yourclass{width:420px; height:240px; background-color:#81BA25; box-shadow: none; color:#fff;}
.yourclass .layui-layer-content{ padding:20px;}
select{display:inline-block;margin-right:5px;}

.dest-list{padding:5px;width:52%;border:1px solid #D5D5D5;background:#fff;position:absolute;z-index:2;height:246px;overflow:auto;display:none;}
.dest-list .check_div .input{width:25%;float:left;overflow:hidden;}
.dest-list .check_div{width:100%;height:auto;float:left;line-height:200%;}
.dest-list .one{width:100%;height:auto;float:left;border-bottom:1px solid #D5D5D5;}
.dest-list .one.last{width:100%;height:auto;float:left;border-bottom:none;}
.dest-list p{height:24px;line-height:24px;}
.input2{width:45%;float:left;text-align:right;margin-top:10px;margin-right:5%;}
.input3{width:45%;float:left;margin-top:10px;margin-left:5%;}

.service-list{padding:5px;width:52%;border:1px solid #D5D5D5;background:#fff;position:absolute;z-index:2;height:148px;overflow:auto;display:none;}
.service-list .check_div .input{width:25%;float:left;overflow:hidden;}
.service-list .check_div{width:100%;height:auto;float:left;line-height:200%;}
.service-list .one{width:100%;height:auto;float:left;border-bottom:1px solid #D5D5D5;}
.service-list .one.last{width:100%;height:auto;float:left;border-bottom:none;}
.service-list p{height:24px;line-height:24px;}
.input4{width:45%;float:left;text-align:right;margin-top:10px;margin-right:5%;}
.input5{width:45%;float:left;margin-top:10px;margin-left:5%;}


.container{width:88%;margin:0 auto;margin-top:20px;}
.container .section img{width:440px;}
.foot{width:100%;float:right;height:30px;}
.foot input{background:#da411f;color:#fff;border-radius:3px;width:60px;height:30px;border:none;cursor:pointer;}

</style>
</head>
<body>
<?php $this->load->view("admin/t33/common/js_view"); //加载公用css、js   ?>
<?php $this->load->view("admin/t33/common/depart_tree"); //加载树形营业部   ?>
 <!-- 添加供应商 弹窗 -->
<div class="fb-content" id="form1">
   
    <div class="fb-form">
        <form method="post" action="#" id="add-data" class="form-horizontal" style="z-index:1;">
            <div class="form-group div1">
                <div class="fg-title">类型：<i>*</i></div>
                <div class="fg-input">
                    <ul>
                    	<li><label><input type="radio" class="fg-radio type" name="type" value="1" checked >境内</label></li>
                        <li><label><input type="radio" class="fg-radio type" name="type" value="2">境外</label></li>

                    </ul>
                </div>
            </div>
            <div class="form-group div2">
                <div class="fg-title">手机：<i>*</i></div>
                <div class="small-input"><input type="text" id="mobile" class="showorder" placeholder="手机号码" name="showorder"></div>
            </div>
            <div class="form-group div3">
                <div class="fg-title">设置登录密码：<i>*</i></div>
                <div class="small-input"><input type="password" id="password" class="showorder" placeholder="请填写6到20位的密码" name="showorder"></div>
            </div>
            <div class="form-group div4">
                <div class="fg-title">重复登录密码：<i>*</i></div>
                <div class="small-input"><input type="password" id="password2" class="showorder" placeholder="请填写6到20位的密码" name="showorder"></div>
            </div>
            
            <!-- <div class="form-group div5">
                <div class="fg-title">昵称：<i>*</i></div>
                <div class="small-input"><input type="text" id="nickname" class="showorder" placeholder="昵称" name="showorder"></div>
            </div> -->
             <div class="form-group div6">
                <div class="fg-title">真实姓名：<i>*</i></div>
                <div class="small-input"><input type="text" id="realname" class="showorder" placeholder="真实姓名" name="showorder"></div>
            </div>
            <div class="form-group div7">
                <div class="fg-title">性别：<i>*</i></div>
                <div class="fg-input">
                    <ul>
                    	<li><label><input type="radio" class="fg-radio radio_sex" name="sex" value="1" checked >男</label></li>
                        <li><label><input type="radio" class="fg-radio radio_sex" name="sex" value="0">女</label></li>

                    </ul>
                </div>
            </div>
            <div class="form-group div7">
                 <div class="fg-title">营业部：<i>*</i></div>
                 <div class="small-input"><input type="text" id="depart_id" onfocus="showMenu(this.id,this.value);" onkeyup="showMenu(this.id,this.value);" placeholder="输入关键字搜索" class="showorder" data-id=""></div>
            </div>
            <div class="form-group div7">
                <div class="fg-title">职位：<i>*</i></div>
                <div class="fg-input">
                    <ul>
                    	<li><label><input type="radio" class="fg-radio is_dm" name="is_dm" value="0" checked >销售</label></li>
                        <li><label><input type="radio" class="fg-radio is_dm" name="is_dm" value="1">经理</label></li>

                    </ul>
                </div>
            </div>
             <div class="form-group div24" style="display: none;">
                <div class="fg-title">证件类型：<i>*</i></div>
                <div class="form_select">
                  
                 
                  	<select name="country" class="select_one" id="idcardtype" data-value="" style="width:137px">
                  		 <option value="">请选择</option>
                  		<?php foreach ($idcardtype as $k=>$v):?>
                  		  <option value="<?php echo $v['dict_id'];?>"><?php echo $v['description'];?></option>
                  		<?php endforeach;?>
                  	</select>
                  
                  
                  </div>
            </div>
            <div class="form-group div8">
                <div class="fg-title">身份证号：<i>*</i></div>
                <div class="small-input"><input type="text" id="idcard" class="showorder" placeholder="" name="showorder"></div>
            </div>
            <!-- <div class="form-group div9">
                <div class="fg-title">电子邮箱：<i>*</i></div>
                <div class="small-input"><input type="text" id="email" class="showorder" placeholder="电子邮箱" name="showorder"></div>
            </div>
            <div class="form-group div10">
                <div class="fg-title">微信：</div>
                <div class="small-input"><input type="text" id="weixin" class="showorder" placeholder="" name="showorder"></div>
            </div> -->
            <!--  
             <div class="form-group div11">
                <div class="fg-title">擅长线路：<i>*</i></div>
                 <div class="form-group">
                  
                  <div class="fg-input">
                  	<input type="text" id="expert_dest" data-id="" autoComplete="off" class="showorder" placeholder="最多选择5个线路" name="showorder">
                  	<div class="dest-list">
                  	  <?php if(!empty($top)):?>
                  	    <?php foreach ($top as $a=>$b):?>
                  	    
                       <div class="one <?php if($a==(count($top)-1)) echo 'last';?>">
                          <p><?php echo $b['kindname'];?></p>
                          <div class="check_div">
                          <?php foreach ($dest as $c=>$d):?>
                             <?php if($d['pid']==$b['id']):?>
                             <div class="input"><input class="dest" type="checkbox" data-id="<?php echo $d['id'];?>" value="<?php echo $d['kindname'];?>" style="width:16px;margin:0;padding:0;" /><?php echo $d['kindname'];?></div>
                             <?php endif;?>
                          <?php endforeach;?>
                          </div>
                       </div>
                       
                       <?php endforeach;?>
                      <?php endif;?>
                    <div class="input2"><input type="button" id="btn_sure" value="确定" style="width:35px;border:1px solid #D5D5D5;padding:4px 7px !important;" /></div>
                       
                    <div class="input3"><input type="button" id="btn_cancel" value="取消" style="width:35px;border:1px solid #D5D5D5;padding:4px 7px !important;" /></div>
                    </div>
                  </div>
                    
                  
                  </div>
                  
            </div>
            -->
            <div class="form-group div11">
                <div class="fg-title">所在地：<i>*</i></div>
                 <div class="form_select">
                  	<select name="province" data-value="<?php echo empty($province_id)==true?21:$province_id;?>" class="select_two" id="province" style="width: 137px; display: none;">
                  	
                  	</select>
                  	
                  	<select name="city" data-value="<?php echo $city==0?235:$city;?>" class="select_three" id="city" style="width: 137px; display: none;">
                  	
                  	</select>
                  </div>
                  
            </div>
            
             <div class="form-group div12">
              
                <div class="fg-title">上门服务：<i>*</i></div>
                 <div class="form-group">
                  
                  <div class="fg-input">
                  	<input type="text" id="visit_service" data-id="" class="showorder" autoComplete="off" placeholder="最多选择5个地区" name="showorder">
                  	<div class="service-list">
                  	 
                  	    
                       <div class="one last">
                         
                          <div class="check_div">
                              <!-- 上门服务地区 -->
                          </div>
                          
                       </div>
                       
                    <div class="input4"><input type="button" id="btn_sure2" value="确定" style="width:35px;border:1px solid #D5D5D5;padding:4px 7px !important;" /></div>
                       
                    <div class="input5"><input type="button" id="btn_cancel2" value="取消" style="width:35px;border:1px solid #D5D5D5;padding:4px 7px !important;" /></div>
                    </div>
                  </div>
                    
                  
                  </div>
                  
            
                  
            </div>
             <div class="form-group div13" style="display:none;">
                <div class="fg-title">上门服务：<i>*</i></div>
                <div class="fg-input">
                    <ul>
                    	<li><label><input type="radio" class="fg-radio visit" name="visit_service" value="1" checked >是</label></li>
                        <li><label><input type="radio" class="fg-radio visit" name="visit_service" value="0">否</label></li>

                    </ul>
                </div>
            </div>
           <!--  <div class="form-group div14">
                <div class="fg-title">头像：<i>*</i></div>
                <div class="fg-input">
                    <input name="uploadFile" class="uploadFile" onchange="uploadImgFile_cut(this);" type="file">
                    <input name="pic" id="big_photo" type="hidden" value="">     
            </div>  
            </div>-->
            <div class="form-group div15">
                <div class="fg-title">证件正面扫描件：<i>*</i></div>
                <div class="fg-input">
                 
                    <input name="uploadFile2" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="idcardpic" type="hidden" value="">
                    <!-- <span>不上传则默认管家头像</span> -->
                 </input>
                </div>
            </div>
           
           
            <div class="form-group div16">
                <div class="fg-title">证件反面扫描件：<i>*</i></div>
                <div class="fg-input">
                  
                    <input name="uploadFile3" class="uploadFile" onchange="uploadImgFile(this);" type="file">
                    <input name="pic" id="idcardconpic" type="hidden" value="">
                    
                    <!-- <span>不上传则默认管家头像</span> -->
                </div>
            </div>
           <!--  <div class="form-group div17">
                <div class="fg-title">个人描述：<i>*</i></div>
                <div class="fg-input"><textarea id="beizhu" maxlength="30" placeholder="最少6个字"></textarea></div>
            </div>  -->
            <!--  
             <div class="form-group div18" style="border-top:1px solid #D5D5D5;margin:15px 20px;padding-top:15px;">
                <div class="fg-title">荣誉证书：</div>
                <div class="fg-input">
                   <div class="certificate_list">
                     <div class="certificate_row" style="margin-bottom: 10px;">
	                	<input type="text" class="showorder certificate" placeholder="证书名称" style="width:40%;">
	                  	<input name="uploadFile4" class="uploadFile" onchange="uploadImgFile(this);" type="file" style="width:30%;margin:0;">
	                    <input name="pic" class="certificatepic" type="hidden">
	                    <a href="jsvascript:void(0)" class="delete_cert" style="float:right;margin-top:2%;">删除</a>
                     </div>
                  </div>
                      <a href="jsvascript:void(0)" class="add_cert">添加证书</a>
                </div>
              
            </div> 
          <div style="border-top:1px solid #D5D5D5;margin:15px 20px;"></div>
            <div class="form-group div19">
                <div class="fg-title">毕业学校：<i>*</i></div>
                <div class="small-input"><input type="text" id="school" class="showorder" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div20">
                <div class="fg-title">从业：<i>*</i></div>
                <div class="small-input"><input type="text" id="profession" class="showorder" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div21">
                <div class="fg-title">工作年限：<i>*</i></div>
                <div class="small-input"><input type="text" id="working" class="showorder" placeholder="" name="showorder"></div>
            </div>
            <div class="form-group div22">
                <div class="fg-title">工作经历：<i>*</i></div>
                <div class="fg-input">
                   <div class="work_list">
	                    <div class="work_row" style="margin-bottom: 10px;/*border-bottom:1px solid #D5D5D5;*/padding:2px;">
		                	<input type="text" class="starttime date" data-date-format="yyyy-mm-dd" placeholder="起始时间" style="width:40%;">&nbsp;-&nbsp;<input type="text" class="endtime date" data-date-format="yyyy-mm-dd" placeholder="截止时间" style="width:40%;">
	                        <input type="text" class="company_name" placeholder="所在企业" style="margin-top:2px;">
	                        <input type="text" class="job" placeholder="职务" style="margin-top:2px;">
	                        <textarea class="description" maxlength="30" placeholder="工作描述" style="margin-top:2px;width:80%;"></textarea>
	                         <a href="jsvascript:void(0)" class="delete_work">删除</a>
	                    </div>
                    </div>
                    <a href="jsvascript:void(0)" class="add_work">添加经历</a>
                </div>
            </div> 
            -->
            <div class="form-group" style="margin-bottom:20px;margin-bottom:20px;">
                <input type="hidden" name="id" value="">
                <input type="button" id="btn_close" class="fg-but layui-layer-close" value="取消">
                <input type="button" class="fg-but" onclick="object.submitData()" value="确定">
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>

<!-- 裁剪头像 -->
 <div class="fb-content" id="form2" style="display:none;">
    <div class="box-title">
        <h5>停用供应商</h5>
        <span class="layui-layer-setwin">
            <a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;">×</a>
        </span>
    </div>
    <div class="fb-form">
       <div class="container">
	
		<div class="section">
			
			<div class="row imgchoose"><img src="" id="target" data-value="" /></div>
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
			<!--  <div class="row imgchoose">
				 <p style="margin-top:5px;">头像预览：</p>
				<div style="width:200px;height:200px;margin:10px 10px 10px 0;overflow:hidden; float:left;"><img class="preview" id="preview3" src="" /></div>
				<div style="width:130px;height:130px;margin:80px 0 10px;overflow:hidden; float:left;"><img class="preview" id="preview2" src="" /></div>
				-->
			</div>
			
		</div>
		
	    <div class="foot" style="margin-top:10px;text-align:right !important;"> 
	           		 <input type="button" id="btn_s" class="btn_sure" onclick="" style="margin-right:10px;" value="确定">
	                <input type="button" id="btn_c" class="btn_close"  value="取消">
	               
	    </div>
    </div>
</div>


<div class="fb-content" id="form23" style="display:none; overflow:auto;">

   <div class="container">
	
	<div class="section">
		
		<div class="row imgchoose"><img src="" id="target" data-value="" /></div>
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
		<!--  <div class="row imgchoose">
			 <p style="margin-top:5px;">头像预览：</p>
			<div style="width:200px;height:200px;margin:10px 10px 10px 0;overflow:hidden; float:left;"><img class="preview" id="preview3" src="" /></div>
			<div style="width:130px;height:130px;margin:80px 0 10px;overflow:hidden; float:left;"><img class="preview" id="preview2" src="" /></div>
			-->
		</div>
		
	</div>
	
    <div class="foot" style="margin-top:10px;text-align:right !important;"> 
           		 <input type="button" id="btn_s" class="btn_sure" onclick="" style="margin-right:10px;" value="确定">
                <input type="button" id="btn_c" class="btn_close"  value="取消">
               
    </div>
</div>
 <!-- 裁剪头像 -->

 
</div>

<link href="<?php echo base_url("assets/ht/js/jcrop/jquery.Jcrop.css"); ?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url("assets/ht/js/jcrop/jquery.Jcrop.min.js"); ?>"></script>

<script type="text/javascript">


//js对象
var object = object || {};
var ajax_data={};
object = {
    init:function(){ //初始化方法
        
    	//拉取select数据
    	var province_id="<?php echo empty($province_id)==true?0:$province_id;?>";
    	if(province_id=="")
    		province_id=21;
    	object.getArea_two(2);
    	object.getArea_three(province_id,1);

    	var city="<?php echo $city;?>";
    	if(city==0)
        	 city=235;
    	var url="<?php echo base_url('admin/t33/expert/get_visit_service')?>";
		var data={pid:city};
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code!="-3")
		{
			//$(".div12").show();
			var json=return_data.data;
			var str="";
			for(var o in json)
			{
				str += "<div class='input'><input class='service' type='checkbox' data-id='"+json[o].id+"' value='"+json[o].name+"' style='width:16px;margin:0;padding:0;' />"+json[o].name+"</div>"
                 
			}
			$(".service-list .check_div").html(str);
		}
    	 
    },
    submitData:function(){  //提交表单
    	var flag = COM.repeat('btn');//频率限制
    	if(!flag)
    	{
	    	var type=$('.type:checked').val();
	    	var mobile=$("#mobile").val();
	    	var password=$("#password").val();
	    	var password2=$("#password2").val();
	    	var nickname=$("#nickname").val();
	    	var realname=$("#realname").val();
	    	var sex=$('.radio_sex:checked').val();
	    
	    	var depart_id=$("#depart_id").attr("data-id");
	    	var depart_name=$("#depart_id").val();
	    	var is_dm=$('.is_dm:checked').val();
	    	
	    	var idcard=$("#idcard").val();
	    	var email=$("#email").val();
	    	var weixin=$("#weixin").val();
	   
	    	var province=$("#province").attr("data-value");
	    	var city=$("#city").attr("data-value");
	
	    	var expert_dest=$("#expert_dest").attr("data-id");//擅长线路
	    	if(type=="1")
	    		 var visit_service=$("#visit_service").attr("data-id");//上门服务
	    	else
	    		 var visit_service=$('.visit:checked').val();//上门服务
	
	    	var big_photo=$("#big_photo").val();
	    	var idcardpic=$("#idcardpic").val();
	    	var idcardconpic=$("#idcardconpic").val();
	    	var beizhu=$("#beizhu").val();
	
	    	var certificate_row=[]; //荣誉证书
			$(".certificate_row").each(function(index){ 
	
				var certificate=$(this).find(".certificate").val();
				var certificatepic=$(this).find(".certificatepic").val();
				certificate_row[index]={
	                 'certificate':certificate,
	                 'certificatepic':certificatepic
					};
			});
	
			var school=$("#school").val();
			var profession=$("#profession").val();
			var working=$("#working").val();
	    	
			var work_row=[]; //工作经历
			$(".work_row").each(function(index){ 
	
				var starttime=$(this).find(".starttime").val();
				var endtime=$(this).find(".endtime").val();
				var company_name=$(this).find(".company_name").val();
				var job=$(this).find(".job").val();
				var description=$(this).find(".description").val();
				work_row[index]={
	                 'starttime':starttime,
	                 'endtime':endtime,
	                 'company_name':company_name,
	                 'job':job,
	                 'description':description
					};
			});
	
	    	//证件类型
	    	var idcardtype=$("#idcardtype option:selected").text();
	
	    	
	    	
	    	if(mobile=="")  {tan('请填写手机号');return false;}
	    	if(password==""||password.length<6||password.length>24) {tan('请填写6到20位的密码');return false;}
	    	if(password!=password2) {tan('两次输入密码不一致');return false;}
	    	
	    	//if(nickname=="") {tan('请填写昵称');return false;}
	    	if(realname=="") {tan('请填写真实姓名');return false;}
	    	if(depart_id=="") {tan('请选择营业部');return false;}
	    	if(idcardtype=="请选择"&&type=="2") {tan('请选择证件类型');return false;}
	    	if(idcard==""&&type=="2") {tan('请填写证件号');return false;}
	    	if(idcard==""&&type=="1") {tan('请填写身份证号');return false;}
	    	//if(email=="") {tan('请填写电子邮箱');return false;}
	
	    	//if(expert_dest == "") {tan('请选择擅长线路');return false;}
	    	if(province=="") {tan('请选择所在省份');return false;}
	    	if(city=="") {tan('请选择所在城市');return false;}
	    	
	    	
	    	if(visit_service== "") {tan('请选择上门服务');return false;}
	
	    	//if(big_photo=="") {tan('请上传头像');return false;}
	    	if(idcardpic=="") {tan('请上传证件正面扫描件');return false;}
	    	if(idcardconpic=="") {tan('请上传证件反面扫描件');return false;}
	
	    	//if(beizhu.length<6) {tan('个人描述需至少6个字');return false;}
	
	    	/* if(school=="") {tan('请填写毕业学校');return false;}
	    	if(profession=="") {tan('请填写从业');return false;}
	    	if(working=="") {tan('请填写工作年限');return false;}
	    	
	    	if(work_row.length==0)  {tan('请填写完整工作经历');return false;}
	
	    	for(var i in work_row)
	    	{
	    		if(work_row[i].starttime=="")  {tan('请填起始时间');return false;}
	    		if(work_row[i].endtime=="")  {tan('请填写截止时间');return false;}
	    		if(work_row[i].company_name=="")  {tan('请填写所在企业');return false;}
	        	if(work_row[i].job=="")  {tan('请填写职务');return false;}
	        	if(work_row[i].description=="")  {tan('请填写工作描述');return false;}
	        	
	        } */
	    	
	        
	    	//数据
	    	var postdata={
	    			type:type,
	    			mobile:mobile,
	    			password:password,
	    			password2:password2,
	    			nickname:nickname,
	    			realname:realname,
	    			sex:sex,
	    			depart_id:depart_id,
	    			depart_name:depart_name,
	    			is_dm:is_dm,
	    			idcardtype:idcardtype,
	    			idcard:idcard,
	    			email:email,
	    			weixin:weixin,
	    			expert_dest:expert_dest,
	    			province:province,
	    			city:city,
	    			visit_service:visit_service,
	    			big_photo:big_photo,
	    			idcardpic:idcardpic,
	    			idcardconpic:idcardconpic,
	    			beizhu:beizhu,
	    			certificate_row:certificate_row,
	    			school:school,
	    			profession:profession,
	    			working:working,
	    			work_row:work_row
	    			
	    	}
	    	var post_url="<?php echo base_url('admin/t33/expert/to_add2')?>";
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

        var province_id="<?php echo $province_id;?>"||0;
        var province_name="<?php echo $province_name;?>"||'广东省';
     	if(return_data.code=="2000")
     	{
     		var json=return_data.data;
     		var str="";
     		str += "<option value='"+province_id+"'>"+province_name+"</option>";
        	for(var i in json)
        	{
	        	str += "<option value='"+json[i].id+"' class='li_two'>"+json[i].name+"</option>";
	        		
            }
	          
            $(".select_two").html(str);
            $("#province").css("display","inline-block");
            
     	}
      },
    getArea_three:function(pid,type){  //获取三级地区

       	var post_url="<?php echo base_url('admin/t33/supplier/arealist')?>";
       	var post_data={pid:pid};
       	var return_data=object.send_ajax_noload(post_url,post_data);
       	
       	if(return_data.code=="2000")
       	{
       		var json=return_data.data;
       		var str="";
       		var city="<?php echo $city;?>";
       		if(city==0)
           		 city=235;
            var cityname="<?php echo $cityname;?>";
            if(cityname=='')
            	cityname='深圳市';
            if(type=="1")
       		str += "<option value='"+city+"'>"+cityname+"</option>";
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
		object.getArea_three(value,2);
		
	});
	$("body").on("change","#city",function(){
		var value=$(this).children('option:selected').val();
  		var con=$(this).children('option:selected').html();
  		$("#city").attr("data-value",value);

  		var url="<?php echo base_url('admin/t33/expert/get_visit_service')?>";
		var data={pid:value};
		var return_data=object.send_ajax_noload(url,data);
		if(return_data.code!="-3")
		{
			//$(".div12").show();
			var json=return_data.data;
			var str="";
			for(var o in json)
			{
				str += "<div class='input'><input class='service' type='checkbox' data-id='"+json[o].id+"' value='"+json[o].name+"' style='width:16px;margin:0;padding:0;' />"+json[o].name+"</div>"
                 
			}
			$(".service-list .check_div").html(str);
		}
	});
	//日历控件
	
    $('.date').datetimepicker({
		lang:'ch', //显示语言
		timepicker:false, //是否显示小时
		format:'Y-m-d', //选中显示的日期格式
		formatDate:'Y-m-d',
	});
	//管家类型切换
	$(".type").click(function(){
		var value=$(this).val();
		if(value=="1")
		{
			object.getArea_two(2);
			$(".div13").hide();
			$(".div12").show();
			$(".div18").show();
			$(".div24").hide();
			$(".div8 .fg-title").html("身份证号：<i>*</i>");
			
		}
		else if(value=="2")
		{
			object.getArea_two(1);
			$(".div12").hide();
			$(".div13").show();
			$(".div18").hide();
			$(".div24").show();
			$(".div24").show();
			$(".div8 .fg-title").html("证件号：<i>*</i>");
			
			
		}
		else if(value=="1")
		{
			$(".form-group").show();
		}

	})
	
	
	//添加荣誉证书html
	$(".add_cert").click(function(){
		var n=$("input[type=file]").length+1;
		var html="";
		html += "<div class='certificate_row' style='margin-bottom: 10px;'>";
		html += "   <input type='text' class='showorder certificate' placeholder='证书名称' style='width:40%;'>";
		html += "   <input name='uploadFile"+n+"' class='uploadFile' onchange='uploadImgFile(this);' type='file' style='width:30%;margin:0;'>";
		html += "   <input name='pic' class='certificatepic' type='hidden'>";
		html += "   <a href='jsvascript:void(0)' class='delete_cert' style='float:right;margin-top:2%;'>删除</a>";
		html +="</div>";
        $(".certificate_list").append(html);
	})
	//删除荣誉证书html
	$("body").on("click",".delete_cert",function(){
		
		$($(this).parent()).remove();
		
	});
	//添加工作经历html
	$(".add_work").click(function(){
		
		var html="";
		html += "<div class='work_row' style='margin-bottom: 10px;padding:2px;'>";
		html += "   <input type='text' class='starttime date' data-date-format='yyyy-mm-dd' placeholder='起始时间' style='width:40%;'>&nbsp;-&nbsp;<input type='text' class='endtime date' data-date-format='yyyy-mm-dd' placeholder='截止时间' style='width:40%;'>";
		html += "   <input type='text' class='company_name' placeholder='所在企业' style='margin-top:2px;'>";
		html += "   <input type='text' class='job' placeholder='职务' style='margin-top:2px;'>";
		html += "   <textarea class='description' maxlength='30' placeholder='工作描述' style='margin-top:2px;width:80%;'></textarea>";
        html += "	<a href='jsvascript:void(0)' class='delete_work'>删除</a>"
		html += "</div>";
        $(".work_list").append(html);
        $('.date').datetimepicker({
    		lang:'ch', //显示语言
    		timepicker:false, //是否显示小时
    		format:'Y-m-d', //选中显示的日期格式
    		formatDate:'Y-m-d',
    	});
	})
	//删除工作经历html
	$("body").on("click",".delete_work",function(){
		
		$($(this).parent()).remove();
		
	});
	//
	$("#expert_dest").focus(function(){
          $(".dest-list").show();
		})
	$("#btn_sure").click(function(){
			
			 var str="";
			 var value="";
			 var n="0";
			 $(".dest").each(function(index){
				  
				 if($(this).is(':checked'))
				 {
				  n++;
                  var a=$(this).val();
                  var b=$(this).attr("data-id");
                  str += a+" ";
                  if(n==5)
                  {
                 	 value +=b;
                  }
                  else
                  {
                	 value +=b+","; 
                  }
				 }
			})
			if(n>5)
			{ 
				tan('最多只能选择5个');
				return false; 
			}
			else
			{
				$(".dest-list").hide();
				$("#expert_dest").val(str);
				$("#expert_dest").attr("data-id",value);
			}
			
		})
	$("#btn_cancel").click(function(){
			 $(".dest-list").hide();
			
		})
	//上门服务
	$("body").on("focus","#visit_service",function(){
		
          $(".service-list").show();
		})
	$("#btn_sure2").click(function(){
			
			 var str="";
			 var value="";
			 var n="0";
			 $(".service").each(function(index){
				  
				 if($(this).is(':checked'))
				 {
				  n++;
                  var a=$(this).val();
                  var b=$(this).attr("data-id");
                  str += a+" ";
                  if(n==5)
                  {
                 	 value +=b;
                  }
                  else
                  {
                	 value +=b+","; 
                  }
				 }
			})
			if(n>5)
			{ 
				tan('最多只能选择5个');
				return false; 
			}
			else
			{
				$(".service-list").hide();
				$("#visit_service").val(str);
				$("#visit_service").attr("data-id",value);
			}
			
		})
	$("#btn_cancel2").click(function(){
			 $(".service-list").hide();
			
		})
	
	
	$('#btn_close').click(function()
	{
		t33_close_iframe_noreload();
	    
	});


	
	/*裁剪头像*/
	
	$("body").on("click","#btn_s",function(){
	
		var img = $("#target").attr("data-value");
		var x = $("#x").val();
		var y = $("#y").val();
		var w = $("#w").val();
		var h = $("#h").val();

		var new_width=$(".jcrop-holder").width();
		var new_height=$(".jcrop-holder").height();
		
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('admin/t33/expert/do_cut');?>",
				data: {"img":img,"x":x,"y":y,"w":w,"h":h,new_width:new_width,new_height:new_height},
				dataType: "json",
				success: function(data){
					if( data.code=="2000" ){
						layer.closeAll(); //关闭层
						
						$("#big_photo").val(data.data.big);
						var bangu_url="<?php echo BANGU_URL;?>"; 
						$("#big_photo").append("<img src='"+bangu_url+data.data.big+"' />");
					} else {
						tan(data.msg);
					}
				}
			});
		
	});

	
	$('#btn_c').click(function()
	{
		layer.closeAll(); //关闭层
	});

})
 //头像裁剪
	var jcrop_api, boundx, boundy;
	
	function updateCoords(c)
	{
		$('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
	};
	function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('请选择图片上合适的区域');
		return false;
	};
	function updatePreview(c){
		if (parseInt(c.w) > 0){
			var rx = 112 / c.w;
			var ry = 112 / c.h;
			$('#preview').css({
				width: Math.round(rx * boundx) + 'px',
            	height: Math.round(ry * boundy) + 'px',
            	marginLeft: '-' + Math.round(rx * c.x) + 'px',
            	marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
		}
		{
			var rx = 130 / c.w;
			var ry = 130 / c.h;
			$('#preview2').css({
            	width: Math.round(rx * boundx) + 'px',
            	height: Math.round(ry * boundy) + 'px',
            	marginLeft: '-' + Math.round(rx * c.x) + 'px',
            	marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
		}
		{
			var rx = 200 / c.w;
			var ry = 200 / c.h;
			$('#preview3').css({
				width: Math.round(rx * boundx) + 'px',
				height: Math.round(ry * boundy) + 'px',
				marginLeft: '-' + Math.round(rx * c.x) + 'px',
				marginTop: '-' + Math.round(ry * c.y) + 'px'
			});
		}
	};
function uploadImgFile3(obj)
	{
		var inputname = $(obj).attr("name");
		var hiddenObj = $(obj).nextAll("input[type='hidden']");
		
		var formData = new FormData($("form" )[0]);
		formData.append("inputname", inputname);
		$.ajax({
				type : "post",
				url : "/admin/t33/home/upload_img",
				data : formData,
				dataType:"json",
				async: false,  
	      		cache: false,  
	      		contentType: false,  
	      		processData: false, 
				success : function(data) {
				
					if(data.code=="2000")
					{
						hiddenObj.val(data.imgurl);
						$(obj).parent().find("img").remove();
						$(obj).parent().append("<img src='"+data.imgurl+"' width='80' />");
						$(obj).parent().parent().find(".olddiv").hide();
						
						layer.open({
							  type: 1,
							  title: false,
							  closeBtn: 0,
							  area: '500px',
							  //skin: 'layui-layer-nobg', //没有背景色
							  shadeClose: false,
							  content: $('#form2')
							});
						//
						
						$("#target").attr("src",data.imgurl);
						
						$('#target').Jcrop({
							minSize: [360,360],
							setSelect: [0,0,360,360],
							onChange: updatePreview,
							onSelect: updatePreview,
							onSelect: updateCoords,
							aspectRatio: 1
						},
						function(){
							// Use the API to get the real image size
							var bounds = this.getBounds();
							boundx = bounds[0];
							boundy = bounds[1];
							// Store the API in the jcrop_api variable
							jcrop_api = this;
						});
						
						jcrop_api.setImage(data.imgurl);
						$("#target").css("width","440px");
						$('#target').Jcrop({
							minSize: [360,360],
							setSelect: [0,0,360,360],
							onChange: updatePreview,
							onSelect: updatePreview,
							onSelect: updateCoords,
							aspectRatio: 1
						},
						function(){
							// Use the API to get the real image size
							var bounds = this.getBounds();
							boundx = bounds[0];
							boundy = bounds[1];
							// Store the API in the jcrop_api variable
							jcrop_api = this;
						});
					
						//end
						
					}
					else
						alert(data.msg);	
				},
				error:function(data){
					alert('请求异常');
				}
			});	
	}

//裁剪头像后，重新赋值
function update_cut(img_path)
{
	$("#big_photo").val(img_path);
	$("#big_photo").parent().find("img").remove();
	$("#big_photo").parent().append("<img src='"+img_path+"' width='80' />");
}
	
</script>


</html>


