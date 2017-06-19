<style type="text/css">
   .D_honor{ margin-top: 10px;}
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
	.longs_blue{
	border: 1px solid #ccc;
    float: left;
    height: 30px;
    line-height: 30px;
    width: 246px;
    cursor: pointer;
    text-indent: 1em;
    }

</style>
<link href="/assets/css/registered_expert.css" type="text/css" rel="stylesheet">
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css"rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<div class="page-breadcrumbs">
	<ul class="breadcrumb">
		<li><i class="fa fa-home"></i> <a href="/admin/b1/view">首页</a></li>	
			<li><?php if(!empty($supplier['login_name'])){ echo $supplier['login_name'];} ?>&nbsp;&nbsp;你好,您上次登录时间是&nbsp;&nbsp;
			       <span style="color:#009dd9"><?php echo $logindatetime; ?></span>
			</li>
	</ul>
</div>
<div class="widget flat radius-bordered">
	<div class="widget-body">
	       <div class="widget-main ">
                 <div class="tabbable">
                      <p class="expert_tishi">管家无佣金,在客人没有联系任何管家就订购产品的时候,优先显示给客人,相当于您的专属客服</p>
                      <form action="" id="expertFrom">
                          <div class="registered_head">
                               <div>
                                   <div class="registered_time fl">
                                    	<label>注册时间：</label> <span><?php echo date('Y-m-d'); ?></span>
                                    </div>
	                                <div class="">
	                                    <label>填写人：</label><span><?php if(!empty($supplier['realname'])){ echo $supplier['realname'];} ?></span>
	                                </div>
                                </div>
                                <div class="qieh_title" >
                                   	<span class="expert_type fl"><span style="color: red;">*</span>管家类型</span>
      	                            <div class="territory fl" style="">
      	                                   <input style="left:-20px;" name="title" type="radio" checked  value="1" >境内
      	                             </div>
                                     <div class="abroad " style="position:relative">
                                            <input style="left:183px;" name="title" type="radio" value="2" >境外
                                     </div>
                                     <input type="hidden" name="countryType" id="countryType" value="2" />
                                  </div>
                             </div>
                              <div class="territory_details">
                                  <div class="account_application" style="">
                                      <div class="registered_title"><div class="Bar"></div><span>申请账号</span></div>
                                       	 <div class="clear">
                                          	<div class=" front_col col_sq fl mobile_">
                                                     <label><span style="color: red;">*</span>手机号：</label>
                                                     <input type="text" name="mobile" id="mobile" placeholder="手机号">
                                            </div>
                                            <div class="front_col col_sq fl">
                                                     <label><span style="color: red;">*</span>设置密码：</label>
                                                     <input type="password" name="password" id="password" placeholder="6-20位,区分大小写">
                                             </div>
                                             <div class="front_col col_sq">
                                                      <label style=""> <span style="color: red;">*</span>确认密码：</label>
                                                      <input type="password" name="repassword" id="repassword" placeholder="请再次输入">
                                             </div>
                                           </div>
                                     </div>
                                     <div class="personal_information" style="">
                                           <div class="registered_title"><div class="Bar"></div><span>个人信息</span>您的隐秘信息将被得到保护</div>
                                               <div class="clear">
                                                    <div class=" front_col col_sq fl">
                                                     	   <label><span style="color: red;">*</span>昵称：</label>
                                                     	   <input type="text" name="nickname" id="nickname" placeholder="登录账号">
                                                     </div>
                                                     <div class="front_col col_sq fl" style="line-height:35px;padding-right:7%;">
                                                     	    <label class="fl"><span style="color: red;">*</span>性别：</label>
                                                     	    <div class="gender_B fl">
                                                     	         <input style="left:-18px;" type="radio" checked name="sex" value="1">男
                                                     	     </div>
                                                     	     <div class="gender_G fl">
                                                     	          <input style="left:-18px;" type="radio"  name="sex" value="0">女
                                                     	     </div>
                                                     </div>
                                                     <div class="front_col ">
                                                     	     <label style=""><span style="color: red;">*</span>电子邮件：</label>
                                                     	     <input type="text" name="email" id="email" placeholder="电子邮件">
                                                     </div>
                                                </div>
                                                <div class="clear">
                                                     <div class=" front_col col_sq fl">
                                                     	      <label><span style="color: red;">*</span>真实姓名：</label>
                                                     	      <input type="text" name="realname" id="realname" placeholder="真实姓名">
                                                     </div>
                                                     <div class="front_col col_sq fl jw_hidden" style="display:none">
                                                               <label style="">证件类型：</label>
                                                               <input type="text" name="idcardtype" id="" placeholder="证件号">

                                                     </div>
                                                       <div class="front_col col_sq fl jn_hidden" style="">
                                                                <label style=""><span style="color: red;"></span>微信号：</label>
                                                                <input type="text" name="weixin" id="weixin" placeholder="微信号">

                                                     </div>
                                                     <div class="front_col jn_hidden">
                                                     	     	<label><span style="color: red;">*</span>身份证号：</label>
                                                                <input type="text" name="idcard" id="idcard" placeholder="身份证号">
                                                     </div>
                                                     <div class="front_col jw_hidden" style="display:none">
                                                                 <label><span style="color: red;">*</span>证件号：</label>
                                                                 <input type="text" name="idcard1" id="" placeholder="证件号">
                                                     </div>
                                                  </div>

                                                   <div class="clear">    
                                                     	<div class=" front_col col_ts fl" style="margin-top:8px;margin-right:2%;">
                                                     	        <label><span style="color: red;">*</span>上传头像：</label>
                                                     	        <img class="" src="#" style="width:120px; height:120px; " id="imghead">
                                                     	        <span class="add_btn" onclick="uploadImgFile(this,1);">上传</span>
                                                     	        <input type="hidden" name="big_photo" id="big_photo"/>
                                                     	</div>
                                                     	<div class=" front_col col_ts fl  " style="margin-right:2%;">
                                                     	        <label><span style="color: red;">*</span> 身份证扫描件：</label>
                                                     	        <img class="form-control date-picker" src="#" style="  width:310px; height:160px;display:inline; " id="">     	        
                                                     	        <span  class="add_btn"  onclick="uploadImgFile(this,2);">上传</span>
                                                     	        <input type="hidden" name="idcardpic" id="idcardpic">
                                                     	</div>
                                                     	<div class=" front_col  ">
                                                     	        <label><span style="color: red;">*</span> 身份证反面：</label>
                                                     	        <img class="form-control date-picker" src="#" style="  width:310px; height:160px;display:inline; " id="">     	        
                                                     	        <span  class="add_btn"  onclick="uploadImgFile(this,2);">上传</span>
                                                     	        <input type="hidden" name="idcardconpic" id="idcardconpic">
                                                     	</div>
                                                    </div>	
                                                     <div class="R_city fl" style="width:415px;">
                                                     	<div class=" front_col col_ts fl">
                                                     	    <div class="front_col  fl" id="city_div">
                                                     	        <label><span style="color: red;">*</span>所属城市：</label>
                                                     	         <span id="expertAddress1" class="city_list_box"></span>
                                                     	       <!-- <input style="width:100px" type="text" placeholder="选择省份">
                                                     	        <input style="width:100px" type="text" placeholder="选择城市"> --> 
                                                     		</div>
                                                     		<div class="front_col  fl" id="city_div1" style="display:none;">
                                                     		     <label><span style="color: red;">*</span>所属城市：</label> <span id="expertAddress2" class="city_list_box"></span> </div>
                                                     		</div>
                                                     	</div>
                                                     	<div class=" front_col door_service  fl">        
	                                                     	 <div class="fl" id="server_area">
	                                                     	    <label class="fl"><span style="color: red;">*</span>上门服务：</label> 
	                                                     	      <ul class="chen_list visit_service_list fl" style="width:700px;margin-top:7px;">
											                        <li><input type="checkbox" onclick="checkAll(this);" value="1" name="all_select" autocomplete="off">全部</li>
										                            <li><input type="checkbox" value="2156" name="visit_service[]" autocomplete="off">罗湖区</li>
										                            <li><input type="checkbox" value="2155" name="visit_service[]" autocomplete="off">龙岗区</li>
										                            <li><input type="checkbox" value="2154" name="visit_service[]" autocomplete="off">宝安区</li>
										                            <li><input type="checkbox" value="2153" name="visit_service[]" autocomplete="off">南山区</li>
										                            <li><input type="checkbox" value="2152" name="visit_service[]" autocomplete="off">福田区</li>
										                            <li><input type="checkbox" value="2151" name="visit_service[]" autocomplete="off">罗湖区</li> 
										                            <li><input type="checkbox" value="2151" name="visit_service[]" autocomplete="off">坪山</li>
										                            <li><input type="checkbox" value="2151" name="visit_service[]" autocomplete="off">光明区</li>                       
										                    	 </ul> 
									                    	 </div>
										                     <div class="fl" id="server_area1" style="display:none;"> 
											                      <div class="gender_B fl"><input style="left:-18px;" type="radio" name="visit_service1" value="1" checked >是</div>
	                                                     	      <div class="gender_G fl"><input style="left:-18px;" type="radio"  name="visit_service1" value="0">否</div>
                                                     	     </div>
                                                     	</div>
                                                     </div>	
                                                     <div class="R_road clear">
                                                     	<div class=" front_col col_sq ">
                                                     	        <label><span style="color: red;">*</span>擅长线路：</label>
                                                     	       <!--  <input type="text" id="expertDestName1" placeholder="选择目的地">
                                                     	        <input type="hidden" id="expert_dest" name="expert_dest" > -->
                                                     	        <div class="longs_blue" style=" adding-left: 10px;">最多选择5项目的地</div>
                                                                <input type="hidden" name="expert_dest" value="" id="expertDestId1">
                                                     	        <!-- <div id="destList1"></div> -->
                                                     	        <ul class="city_longs">              
										                       <?php 
										                       		if (!empty($destArr)) {
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
									                         </ul>
                                                     	</div>
                                                     </div>
                                                     <div class="'clear" style="height:80px">
                                                     	 <label><span style="color: red;">*</span>个人描述：</label>
                                                     	  <textarea placeholder="用于管家页面 个人介绍展示,150字以内" name="talk" id="talk" ></textarea>
                                                     </div>
                                                     <div class="D_honor">
											            <div>
											                    <div class=" data_title # fl">荣誉证书：</div>
											                    <span class="add_btn" onclick="addCertificate(this);">添加</span>
											                    <p>注：外旅局授予证书、省市级优秀导游、旅游顾问证、导游资格证、领队资格证、旅行社部门经理资格证、旅行社总经理资格证</p>
											           </div>
										                    <div class="honor_nav">
									                            <table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer col_tbtj" style="width:65%;position: relative;">
																  <thead>
														           <tr role="row">
																 		 <th style="width: 100px;text-align:center;">证书名称 </th>
																 		 <th style="width: 150px;text-align:center;font-weight:500">扫描件</th>
																	     <th style="width: 150px;text-align:center;font-weight:500">操作</th>
															 		</tr>
																   </thead>
																	<tbody class="train_table honor_tr">		
																		 <tr role='row' class='tianjia' style="">
																		     <td style="text-align:center">
																			       <input class=" nm_zhengshu" name="certificate[]" type="text"  id="certificate" placeholder="请填写证书名称"> 
																			 </td>          
																			<td style="text-align:center">
																			 		<input type="hidden" name="certificatepic[]" id="certificatepic" >
																		            <span  class="add_btn" onclick="uploadImgFile(this,3);">上传</span> 
																		            <span></span>      
																			</td>
																			 <td><span class="Delete"  onclick="deleteLi(this ,1);">清空</span></td>
																		</tr> 											   
																	</tbody>				    													     																		    
																</table>
										          			  </div>
                                                		</div>
	                                                   <!--   <div class="clear">
	                                                     	<div class=" front_col col_sq fl">
	                                                     	        <label><span style="color: red;">*</span>外旅局授予证书：</label>
	                                                     	        <input type="text" placeholder="证书名称" name="travel_title" id="travel_title">
	                                                     	</div> 
	                                                     	<div class=" front_col  R_saomiao">
	                                                           	扫描件
	                                                     	    <img class="" src="#" style="width:120px; height:120px; " id="travel_title_img">
		                                                     	<span  class="add_btn"  onclick="uploadImgFile(this,4);">上传</span>
		                                                     	<input type="hidden" name="travel_title_pic" id="travel_title_pic"/>
	                                                     	</div>
	                                                     	
	                                                     </div> -->
                                       		  </div>
                                             <div class="personal_resume clear">
                                             	<div class="registered_title"><div class="Bar"></div><span>个人简历</span>专业的简历是您通过管家资质审核的关键</div>
                                             	<p>以下现实与管家页面(旅游从行业年限可累加并详述如下)</p>
                                             	<div class="Education clear">
                                                     	<div class=" front_col  fl">
                                                     	        <label>毕业院校</label>
                                                     	        <input type="text" placeholder="" name="school">，
                                                     	</div>
                                                     	<div class="front_col  fl">
                                                     	        <label>从业于</label>
                                                     	        <input type="text" placeholder=""  name="job_name">，
                                                     	</div>
                                                     	<div class="front_col fl">
                                                     	       
                                                     	        <input type="text" placeholder="" name="year">
                                                     	        <span style="margin-top:5px">年</span>
                                                     	</div>
                                                     </div>
                                                     <div class="D_resume clear">
									                    <div class=" data_title #">
									                            <span  class="add_btn add_job" >添加从业经历</span>
									                             <span style=" color:#ff0000; padding-left:10px;">以下不公开显示,仅做管家资质审核用(非旅游从业不可填)</span>
									                      </div>
									                    <div class="resume_nav">
									                        <table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer" style="width:65%">
															<thead>
															      <tr role="row">
																	 <th style="width: 200px;text-align:center">起止时间 </th>
																	 <th style="width: 150px;text-align:center">所在企业</th>
																	 <th style="width: 150px;text-align:center">职务 </th>
																	 <th style="width: 300px;text-align:center">工作描述</th>
																	 <th style="width: 100px;text-align:center">操作</th>
																 </tr>
															</thead>
															<tbody class="train_table job_table">
																<tr class="train_len">
																	<td style="text-align:center"><input class="time" name="starttime[]" readonly onclick="WdatePicker()" type="text">&nbsp;&nbsp;至&nbsp;&nbsp;<input class="time" readonly onclick="WdatePicker()" name="endtime[]" type="text"></td>
																	<td style="text-align:center"><input class="time_1" name="company_name[]" type="text"></td>
																	<td style="text-align:center"><input class="time_1" name="job[]" type="text"></td>
																	<td style="text-align:center"><input class="time_1" name="description[]" type="text"></td>
																	<td style="text-align:center"><span  class="Delete"   onclick="deletejob(this,1);">清空</span></td>
																</tr>												   
															</tbody>
														</table>
									                    </div>
                                                   </div>
                                             </div>
                                   <!--       <div class="Verification_div">
                                             	<label><span style="color: red;">*</span>验证码：</label>
                                                    <input style-="position:relative;" type="text" >
                                                    <span  class="add_btn" >获取验证码</span>
                                                    <div class="stered_input" id="yzm" style="width: 232px;display:none;">
							                    	<input style="width:90px;" type="text" class="stered_five fl" placeholder="验证码" name="code" id="input5" maxlength="4">
							                        <div class="stered_yanzheng ">
							                       		 <img style="-webkit-user-select: none; width:88px; height:34px; margin-left:8px" src="#" id="verifycode">
							                        </div>
							                        <div style="margin-top:10px; text-align:center">
							                            <input type="button" value="发送" class="yzm_tijiao">
							                            <input type="button" value="关闭" class="yzm_guanbi"> 
							                        </div>   
                                                </div>
                                             </div>   -->        
		                          <div class="xieyi" style="margin-top:30px; ">
						              <!--   <div class="fl"><input type="checkbox" name="isAgree" value="1" autocomplete="off">
						                		同意<a target="_blank" href="/service/expert_agreement">&lt;&lt;帮游管家服务总则及合作协议&gt;&gt;</a>
						                </div> -->
						                  <div class="fl" style="margin-left:25%"> <span class="tijiao_btn" onclick="submitForm(this)">提交审核</span> </div>  
						      	  </div>
                              
                       
                       </form>
                       </div>
                  </div>
	        </div>
	</div>
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div id="xiuxiu_box4" class="xiuxiu_box"></div>
<div id="xiuxiu_box5" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<div class="right_box" style="display:none;"></div>

<script src="<?php echo base_url() ;?>assets/js/xiuxiu/xiuxiu.js"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script> 
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/plugins/DatePicker/WdatePicker.js'); ?>"></script> 
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script type="text/javascript">
	$('input[name="title"]').click(function(){
       var val=$(this).val();
       if(val==2){ //境外
           
             $('.D_honor').hide();
             $('#server_area').hide(); 
             $('#server_area1').show(); 
             $('#city_div').hide(); 
             $('#city_div1').show();
             $('.jw_hidden').show();
             $('.jn_hidden').hide();
             $('input[name="countryType"]').val('1');
       }else{ //境外
           
    	   $('.D_honor').show();
    	   $('#server_area').show(); 
           $('#server_area1').hide(); 
           $('#city_div1').hide(); 
           $('#city_div').show();
           $('input[name="countryType"]').val('2');
             $('.jw_hidden').hide();
            $('.jn_hidden').show();
       }
    });
    //擅长线路  目的地(所有)
$.post("/common/area/getRoundTripData",{},function(json) {
	var data = eval("("+json+")");
	chioceDestJson.trip = data;
	//所有目的地
	createChoicePlugin({
		data:chioceDestJson,
		nameId:"expertDestName1",
		valId:"expert_dest",
		width:660,
		number:3,
		buttonId:'destList1'
	});
});
	//添加荣耀证书
	function addCertificate(obj) {
	    var html='<tr role="row" class="tianjia" style="">';
	    html= html+'<td style="text-align:center">';
	    html= html+'<input class=" type="text" nm_zhengshu" name="certificate[]" id="certificate" placeholder="请填写证书名称"></td> ';
	    html= html+'<td style="text-align:center">	<input type="hidden" name="certificatepic[]" id="certificatepic" >'; 
		html=html+'<span  class="add_btn"  onclick="uploadImgFile(this,3);" >上传</span><span></span></td>';
		html=html+' <td><span class="Delete"  onclick="deleteLi(this);">删除</span></td></tr> ';      
	    $('.honor_tr').append(html);         
	}
	//删除简历以及证书的li
 	function deleteLi(obj ,type){
		if ($(obj).parents("td").parents(".honor_tr").find('tr').length < 2 || type == 1) {
			$(obj).parents("tr").find("input[type='text']").val('');
		} else {

			$(obj).parents("td").parents("tr").remove();
		}
	} 
	//添加从业经历	
	$('.add_job').click(function(){		
	    var html='<tr class="train_len">';
	    html= html+'<td style="text-align:center"><input class="time" name="starttime[]" readonly onclick="WdatePicker()" type="text">&nbsp;&nbsp;至&nbsp;&nbsp;<input readonly onclick="WdatePicker()" name="endtime[]" class="time" type="text"></td>';
	    html= html+'<td style="text-align:center"><input class="time_1" name="company_name[]" type="text"></td>';
	    html= html+'<td style="text-align:center"><input class="time_1" name="job[]"  type="text"></td>'; 
		html=html+'<td style="text-align:center"><input class="time_1" name="description[]" type="text"></td>';
		html=html+' <td style="text-align:center"><span class="Delete"   onclick="deletejob(this);">删除</span></td> </tr>';      
	    $('.job_table').append(html);    
	})
	//删除从业经历	
 	function deletejob(obj ,type){
		if ($(obj).parents("td").parents(".job_table").find('tr').length < 2 || type == 1) {
			$(obj).parents("tr").find("input[type='text']").val('');
		} else {

			$(obj).parents("td").parents("tr").remove();
		}
	} 
	/*-----------------------------------上传图片-----------------------------*/
	var imgProportion = {1:"360x360",2:"350x200",3:"360x360",4:"360x360",5:"350x200"};
	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4",5:"xiuxiu_box5"};
	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4",5:"xiuxiuEditor5"};
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
				//	buttonObj.next("input").val(data.msg);
					if (type == 3) {
						alert("上传成功");
						//buttonObj.after(data.msg);
						buttonObj.prev("input").val(data.msg);
						buttonObj.next("span").html(data.msg);
					} else if (type == 2) {
						//buttonObj.css({'margin-top': '0px','margin-left': '110px'});
						buttonObj.prev("img").attr("src",data.msg);
					//	$('input[name="idcardpic"]').val(data.msg);	
						buttonObj.next("input").val(data.msg);	
					} else if (type == 1){
						//buttonObj.css({'margin-top': '134px','margin-left': '384px'});
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="big_photo"]').val(data.msg);	
					}
				
					closeXiu(type);
				} else {
					alert(data.msg);
				}
			}
		//	alert(type);
			$("#xiuxiuEditor"+type).show();
			$('.avatar_box').show();
			$('.close_xiu').show();
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
	
getChinaPC();
abroadPC("expertAddress2" ,124);
//城市变动获取地区
function getChinaPC(){
	$.post("/common/area/getChinaAreaPCR",{},function(json){
		areaData = eval("("+json+")");
		var html = '<select name="province1" id="province1" style="width:120px;" onchange="getCitySel(this)"><option value="0">请选择</option>';
		$.each(areaData.topArea ,function(index,item){
			html += '<option value="'+item.id+'">'+item.name+'</option>';
		})
		html += "</select>";
		
		$("#expertAddress1").append(html);
		//$("#expertAddress1").find("select[name='province']").val(21);
	})
}
function getCitySel(obj) {
	var id = $(obj).val();
	$(obj).next("select").remove();
	if (id == 0) {
		return false;
	}
	var html = '<select name="city" id="city" style="width:128px;" onchange="getRegionCheck(this)"><option value="0">请选择</option>';
	$.each(areaData[id] ,function(index,item){
		html += '<option value="'+item.id+'">'+item.name+'</option>';
	})
	html += "</select>";
	$(obj).after(html);
}
//服务地区
function getRegionCheck(obj) {
	var id = $(obj).val();
	if (id == 0) {
		return false;
	}
	var html = '<li><input type="checkbox" onclick="checkAll(this);" name="all_select" value="1" autocomplete="off" >全部</li>';
	$.each(areaData[id] ,function(index ,item){
		html += '<li><input type="checkbox" name="visit_service[]" value="'+item.id+'">'+item.name+'</li>';
	})
//	$(".visit_service_list").find("li").eq(0).nextAll("li").remove();
	$(".visit_service_list").find("li").remove();
	$(".visit_service_list").append(html);
}
//点击服务地区的全部 
function checkAll(obj) {
	if ($(obj).attr("checked") == 'checked') {
		$(obj).parents("ul").find("input[type='checkbox']").attr("checked" ,true);
	}else{
		$(obj).parents("ul").find("input[type='checkbox']").attr("checked" ,false);
	}
}

/****************验证******************/
//判断输入密码的类型
function CharMode(iN){
	if (iN>=48 && iN <=57) //数字
		return 1;
	if (iN>=65 && iN <=90) //大写
		return 2;
	if (iN>=97 && iN <=122) //小写
		return 4;
	else
		return 8;
}
//计算密码模式
function bitTotal(num){
	modes=0;
	for (i=0;i<4;i++){
		if (num & 1) modes++;
		num>>>=1;
	}
	return modes;
}
//返回强度级别
function checkStrong(sPW){
	if (sPW.length<=5)
		return 0; //密码太短
		Modes=0;
	for (i=0;i<sPW.length;i++){
	//密码模式
		Modes|=CharMode(sPW.charCodeAt(i));
	}
	return bitTotal(Modes);
}
//显示颜色
function pwStrength(pwd){
	O_color="#aeadad";
	L_color="#f00";
	M_color="#ff9c3a";
	H_color="#61d01c";
	if (pwd==null||pwd==''){
		Lcolor=Mcolor=Hcolor=O_color;
	}
	else{
		S_level=checkStrong(pwd);
	switch(S_level) {
		case 0:
		Lcolor=Mcolor=Hcolor=O_color;
		case 1:
		Lcolor=L_color;
		Mcolor=Hcolor=O_color;
		break;
		case 2:
		Lcolor=Mcolor=M_color;
		Hcolor=O_color;
		break;
		default:
		Lcolor=Mcolor=Hcolor=H_color;
		}
	}
	document.getElementById("strength_L").style.background=Lcolor;
	document.getElementById("strength_M").style.background=Mcolor;
	document.getElementById("strength_H").style.background=Hcolor;
	return;
}
function isEmail(email) {
	var pregEmail = /^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;
	if (pregEmail.test(email)) {
		return true;
	} else {
		return false;
	}
}
	//添加直属管家
   function submitForm(obj){		    	
		//所属城市
		var type=$('input[name="countryType"]').val();

	   //手机
		var mobile=$('input[name="mobile"]').val();
		if(mobile.length<=0){
			  alert('请输入手机号');
			  return false;
		}else{
			if(!mobile.match(/^1[3-8]\d{9}$/)){
				alert('手机号码格式不正确');
				return false;
			}
		}
		//密码
	    var password=$('input[name="password"]').val();
	    if(password.length<=0){
		    alert('设置密码不能为空!');
		    return false;
		}else{
			if(password.length<6&&password.length!=0){
				alert('密码为6-20个字符');
				return false;
			 }
		}
		var repassword=$('input[name="repassword"]').val();
		if(repassword.length<=0){
			 alert('确认密码不能为空!');
			 return false;
		}
		if(password!=repassword){
			alert('两次输入的密码不一致');
			return false;
		}
		 //昵称
		var  nickname=$('input[name="nickname"]').val(); 
		if(nickname.length<=0){
			alert('昵称不能为空!');
			return false;
		}  
		//电子邮件
		var email=$('input[name="email"]').val();
		if(email.length<=0){
			alert('电子邮件不能为空!');
			return false;
		}else{
			if (!isEmail(email)) {
				alert('请填写正确的邮箱号');
				return false;
			}
		}
		//真实姓名
		var realname=$('input[name="realname"]').val();
		if(realname.length<=0){
			alert('真实姓名不能为空!');
			return false;
		}
		//证件号
	   if(type==2){ //国内游	
			var idcard=$('input[name="idcard"]').val();
			if(idcard.length<=0){
				alert('身份证号不能为空!');
				return false;
			}else{
				if(!idcard.match(/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/)){	
					alert('身份证号格式不正确');
					return false;
				}
			}
	   }else if(type==1){
             var idcardtype=$('input[name="idcardtype"]').val();
             if(idcardtype.length<=0){
            	 alert('证件类型不能为空!');
 				return false;
              }
             var idcard1=$('input[name="idcard1"]').val();
             if(idcard1.length<=0){
            	 alert('证件号不能为空!');
 				return false;
              }
		}
		//上传头像
		var big_photo=$('input[name="big_photo"]').val();
		if(big_photo.length<=0){
			alert('请上传头像');
			return false;
		}
		//身份证扫描件
		var idcardpic=$('input[name="idcardpic"]').val();
		if(idcardpic.length<=0){
			alert('请上传身份证扫描件');
			return false;
		}
		//身份证扫描件
		var idcardconpic=$('input[name="idcardconpic"]').val();
		if(idcardconpic.length<=0){
			alert('请上传身份证反面');
			return false;
		}
	 	if(type==2){ //国内游		
	 		var province1=  $("#province1").find("option:selected").val();

	 		if(province1<=0){
		 		alert('请选择所属城市');
		 		return false;
		 	}
		 	var city=$("#city").find("option:selected").val();
	 		if(city==0){
	 			alert('请选择所属城市');
		 		return false;
		 	}
	 		//.find("option:selected")
		}else if(type==1){
			var province=$('select[name="province"]').find("option:selected").val();
			if(province<=0){
		 		alert('请选择所属城市');
		 		return false;
		 	}
		 	var city=$('select[name="city"]').find("option:selected").val();
	 		if(city==0){
	 			alert('请选择所属城市');
		 		return false;
		 	}
		} 

	    //擅长线路
	   	var destid = '';
	   	var formObj=$('.R_road');
		$.each(formObj.find('.city_longs').find('li'),function(){
			if ($(this).hasClass('active-dest')) {
				destid += $(this).attr('value')+',';
			}
		})
	    formObj.find('input[name=expert_dest]').val(destid);
	    var expert_dest=$('input[name="expert_dest"]').val();
		if(expert_dest.length<=0){
			alert('请选择擅长线路');
		 	return false;
		}
		   
	   var talk=$('#talk').val();
	   if(talk==''){
		   alert('请填写个人描述');
	 		return false;
		} 
	    //毕业的院校
	    var school=$('input[name="school"]').val(); 
	    if(school==''){
		    alert('毕业院校不能为空!');
		    return false;
		}
		//从业岗位
		var job_name=$('input[name="job_name"]').val(); 
		if(job_name==''){
			alert('从业岗位不能为空!');
			return false;		
		} 
		//从业时间
		var year=$('input[name="year"]').val();
		if(year==''){
			alert('从业时间不能为空');
			return false;
		}
		$.post("/admin/b1/directly_expert/save_expert",$("#expertFrom").serialize(),function(json){
			var data = eval("("+json+")");
 			if (data.status == 1) {
				alert(data.msg);
				window.close();
			} else {
				//alert('上传失败!');
				alert(data.msg);
			}  
		})
		return false;
   }
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

   var _con = $('.R_road');   // 设置目标区域

   if(!_con.is(e.target) && _con.has(e.target).length === 0){

       $(".R_road").find('.city_longs').hide()

   }

});

//$('.longs_blue').toggle(function(){$(".city_longs").show()}, function(){$(".city_longs").hide()});

//****************************选择擅长线路  END *****************************//
</script>
