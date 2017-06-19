<style type="text/css">
.D_honor {
	margin-top: 10px;
}
/* 目的选择样式*/
#destList1, #destList2 {
	margin-left: 396px;
	margin-top: -31px;
	min-height: 32px;
}

#destList1 .selectedTitle {
	display: none;
}

#destList1 .selectedContent {
	background: #60af00;
	color: #fff;
	border: 1px solid #60af00;
	border-radius: 3px;
	width: auto;
	padding: 3px 11px 3px 7px;
	margin-right: 10px;
}

.radius-bordered {
	margin-left: 160px;
}

@media ( max-width :855px) {
	.radius-bordered {
		margin-left: 0px
	}
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
<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/jQuery-plugin/citylist/city.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<div class="widget flat radius-bordered">
	<div class="widget-body">
		<div class="widget-main ">
			<div class="tabbable">
				<form action="" id="expertFrom">
					<div class="registered_head">
						<div class="qieh_title">
							<span class="expert_type fl"><span style="color: red;">*</span>管家类型</span>
							<input type="hidden" name="expert_type" value="1">
							<div class="territory fl" style="">
								<input style="left: -20px;" name="type" type="radio" checked value="1">境内
							</div>
							<div class="abroad " style="position: relative">
								<input style="left: 183px;" name="type" class="abroad_radio" disabled type="radio" value="2">境外
							</div>
						</div>
					</div>
					<div class="territory_details">
						<div class="account_application">
							<div class="registered_title">
								<div class="Bar"></div>
								<span>申请账号</span>
							</div>
							<div class="clear">
								<div class=" front_col col_sq fl mobile_">
									<label><span style="color: red;">*</span>手机号：</label>
									<input type="text" name="mobile" id="mobile" placeholder="手机号">
								</div>
								<div class="front_col col_sq fl">
									<label><span style="color: red;">*</span>设置密码：</label>
									<input type="password" name="password" id="password" placeholder="6-20位,区分大小写">
								</div>
								<div class="front_col ">
									<label style=""> <span style="color: red;">*</span>确认密码： </label>
									<input type="password" name="repass" id="repassword" placeholder="请再次输入">
								</div>
							</div>
						</div>
						<div class="personal_information">
							<div class="registered_title">
								<div class="Bar"></div>
								<span>个人信息</span>您的隐秘信息将被得到保护
							</div>
							<div class="clear">
								<div class=" front_col col_sq fl">
									<label><span style="color: red;">*</span>昵称：</label>
									<input type="text" name="nickname" maxlength="5" id="nickname" >
								</div>
								<div class="front_col col_sq fl" style="line-height: 35px; padding-right: 7%;">
									<label class="fl"><span style="color: red;">*</span>性别：</label>
									<div class="gender_B fl">
										<input style="left: -18px;"  type="radio"  checked="checked" name="sex" value="1">男
									</div>
									<div class="gender_G fl">
										<input style="left: -18px;" type="radio" name="sex" value="0">女
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
								<div class="front_col col_sq fl abroad_input" style="display: none">
									<label style="">证件类型：</label>
									<input type="text" name="idcardtype" disabled="disabled" placeholder="证件号">
								</div>
								<div class="front_col col_sq fl domestic_input">
									<label style=""><span style="color: red;">*</span>微信号：</label>
									<input type="text" name="weixin" id="weixin" placeholder="微信号">
								</div>
								<div class="front_col domestic_input">
									<label><span style="color: red;">*</span>身份证号：</label> 
									<input type="text" name="idcard" id="idcard" maxlength="18" placeholder="身份证号">
								</div>
								<div class="front_col abroad_input" style="display: none">
									<label><span style="color: red;">*</span>证件号：</label>
									<input type="text" name="idcard" disabled="disabled" placeholder="证件号">
								</div>
							</div>
							<div class="front_col abroad_input" style="display: none">
								<label style=""><span style="color: red;">*</span>微信号：</label>
								<input type="text" name="weixin" disabled="disabled"  placeholder="微信号">
							</div>
							<div class="clear">
								<div class=" front_col col_ts fl" style="margin-top: 8px;margin-right:2%;">
									<label><span style="color: red;">*</span>上传头像：</label>
									<img src="#" style="width: 120px; height: 120px;" id="imghead">
									<span class="add_btn" onclick="uploadImgFile(this,1);">上传</span>
									<input type="hidden" name="photo" id="big_photo" />
								</div>
								<div class="front_col col_ts fl  " style="margin-right:2%;">
									<label><span style="color: red;">*</span> 证件扫描件：</label>
									<img class="form-control date-picker" src="#" style="width:310px; height:160px; display: inline;" id="">
									<span class="add_btn" onclick="uploadImgFile(this,2);">上传</span>
									<input type="hidden" name="idcardpic" id="idcardpic">
								</div>
								<div class=" front_col  ">
                                         <label><span style="color: red;">*</span> 身份证反面：</label>
                                         <img class="form-control date-picker" src="#" style="  width:310px; height:160px;display:inline; " id="">     	        
                                         <span  class="add_btn"  onclick="uploadImgFile(this,2);">上传</span>
                                         <input type="hidden" name="idcardconpic" id="idcardconpic">
                                 </div>
							</div>
							<div class="R_city fl" style="width: 415px;">
								<div class=" front_col col_ts fl">
									<div class="front_col  fl domestic_input">
										<label><span style="color: red;">*</span>所属城市：</label>
										<span id="expertAddress1" class="city_list_box"></span>
									</div>
									<div class="front_col  fl abroad_input" style="display: none;">
										<label><span style="color: red;">*</span>所属城市：</label>
										<span id="expertAddress2" class="city_list_box"></span>
									</div>
								</div>
							</div>
							<div class=" front_col door_service  fl">
								<div class="fl domestic_input" style="display:none;">
									<label class="fl"><span style="color: red;">*</span>上门服务：</label>
									<ul class="chen_list visit_service_list fl" style="width: 700px; margin-top: 7px;">
										<li><input type="checkbox" value="2156" name="visit_service[]" autocomplete="off">罗湖区</li>
										<li><input type="checkbox" value="2155" name="visit_service[]" autocomplete="off">龙岗区</li>
										<li><input type="checkbox" value="2154" name="visit_service[]" autocomplete="off">宝安区</li>
										<li><input type="checkbox" value="2153" name="visit_service[]" autocomplete="off">南山区</li>
										<li><input type="checkbox" value="2152" name="visit_service[]" autocomplete="off">福田区</li>
									</ul>
								</div>
								<div class="fl abroad_input" id="server_area1" style="display: none;">
								<label class="fl"><span style="color: red;">*</span>上门服务：</label>
									<div class="gender_B fl" style="margin: 9px 30px 0px 40px;">
										<input style="left: -18px;" type="radio" disabled="disabled" name="visit_service" value="1">是
									</div>
									<div class="gender_G fl" style="margin: 9px 0px 0px 40px;">
										<input style="left: -18px;" type="radio" disabled="disabled" name="visit_service" value="0">否
									</div>
								</div>
							</div>
						</div>
						<div class="R_road clear">
							<div class=" front_col col_sq ">
								<label><span style="color: red;">*</span>营业部：</label>
								<div id="fl domestic_input">
									<input type="text" id="depart_name"  placeholder="选择营业部"> 
									<span class="agent_name_button" style="background:#2dc3e8;color:#fff;font-size:14px;border-radius:3px;padding:8px;">点此可选择营业部</span>
									<input type="hidden" id="depart_id" name="depart_id">
								</div>
							</div>
						</div> 	
						<div class="R_road clear">
							<div class=" front_col col_sq ">
								<label><span style="color: red;">*</span>擅长线路：</label>
								<div class="longs_blue" style=" adding-left: 10px;">最多选择5项目的地</div>
                                <input type="hidden" name="expert_dest" value="" id="expertDestId1">
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
						<div class="'clear" style="height: 80px">
							<label><span style="color: red;">*</span>个人描述：</label>
							<textarea placeholder="用于管家页面 个人介绍展示,150字以内" name="talk"></textarea>
						</div>
						<div class="D_honor domestic_input">
							<div>
								<div class=" data_title # fl">荣誉证书：</div>
								<span class="add_btn" onclick="addCertificate(this);">添加</span>
								<p>注：外旅局授予证书、省市级优秀导游、旅游顾问证、导游资格证、领队资格证、旅行社部门经理资格证、旅行社总经理资格证</p>
							</div>
							<div class="honor_nav">
								<table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer col_tbtj" style="width: 65%; position: relative;">
									<thead>
										<tr role="row">
											<th style="width: 100px; text-align: center;">证书名称</th>
											<th style="width: 150px; text-align: center; font-weight: 500">扫描件</th>
											<th style="width: 150px; text-align: center; font-weight: 500">操作</th>
										</tr>
									</thead>
									<tbody class="train_table honor_tr">
										<tr role='row' class='tianjia' style="">
											<td style="text-align: center">
												<input class=" nm_zhengshu" name="certificate[]" type="text" id="certificate" placeholder="请填写证书名称">
											</td>
											<td style="text-align: center">
												<input type="hidden" name="certificatepic[]" id="certificatepic">
												<span class="add_btn" onclick="uploadImgFile(this,3);">上传</span> <span></span>
											</td>
											<td><span class="Delete" onclick="deleteLi(this);">删除</span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="personal_resume clear">
						<div class="registered_title">
							<div class="Bar"></div>
							<span>个人简历</span>专业的简历是您通过管家资质审核的关键
						</div>
						<p>以下现实与管家页面(旅游从行业年限可累加并详述如下)</p>
						<div class="Education clear">
								<label>毕业院校</label> 
								<input type="text" placeholder="" name="school">，
							</div>
							<div class="front_col  fl">
								<label>从业于</label>
								 <input type="text" placeholder="岗位名称 " name="job_name">，
							</div>
							<div class="front_col fl">
								<input type="text" placeholder="" name="year"> 
								<span style="margin-top: 5px">年</span>
							</div>
						</div>
						<div class="D_resume clear">
							<div class=" data_title #">
								<span class="add_btn add_job">添加从业经历</span> 
								<span style="color: #ff0000; padding-left: 10px;">以下不公平显示,仅做管家资质审核用(非旅游从业不可填)</span>
							</div>
							<div class="resume_nav">
								<table aria-describedby="editabledatatable_info" class="table table-bordered dataTable no-footer" style="width: 65%">
									<thead>
										<tr role="row">
											<th style="width: 200px; text-align: center">起止时间</th>
											<th style="width: 150px; text-align: center">所在企业</th>
											<th style="width: 150px; text-align: center">职务</th>
											<th style="width: 300px; text-align: center">工作描述</th>
											<th style="width: 100px; text-align: center">操作</th>
										</tr>
									</thead>
									<tbody class="train_table job_table">
										<tr class="train_len">
											<td style="text-align: center">
												<input class="time" id="starttime1" readonly name="starttime[]" type="text">&nbsp;&nbsp;至&nbsp;&nbsp;
												<input class="time" id="endtime1" readonly name="endtime[]" type="text">
											</td>
											<td style="text-align: center">
												<input class="time_1" name="company_name[]" type="text">
											</td>
											<td style="text-align: center">
												<input class="time_1" name="job[]" type="text">
											</td>
											<td style="text-align: center">
												<input class="time_1" name="description[]" type="text">
											</td>
											<td style="text-align: center">
												<span class="Delete" onclick="deletejob(this);">删除</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="xieyi" style="margin-top: 30px;">
						<div class="fl" style="margin-left: 25%">
							<span class="tijiao_btn" onclick="submitForm(this)">确认添加</span>
						</div>
					</div>
			   </form>
		  </div>
	 </div>
</div>
<div id="xiuxiu_box1" class="xiuxiu_box"></div>
<div id="xiuxiu_box2" class="xiuxiu_box"></div>
<div id="xiuxiu_box3" class="xiuxiu_box"></div>
<div id="xiuxiu_box4" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<div class="close_xiu">×</div>
<div class="right_box" style="display: none;"></div>

<!-- 选择营业部弹出层 开始-->
<div class="eject_body">
	<div class="eject_colse colse_travel">X</div>
	<div class="eject_title">选择营业部</div>
	<div class="search_travel_input">
		<input class="search_travel_condition" type="text" placeholder="请输入营业部名称" name="search_travel_name">
		<div class="search_button">搜索</div>
	</div>
	<div class="eject_content" style="clear: both;">
		<div class="choice_tralve_agent">海外国旅旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社</div>
		<div class="choice_tralve_agent">深圳市口岸中国旅行社深圳市口岸中国旅行社</div>
	</div>	
	<div class="pagination page_travel"></div>
	<div style="clear:both;"></div>
	<div class="eject_botton">
		<div class="eject_through">选择</div>
		<div class="eject_fefuse colse_travel">取消</div>
	</div>					
</div>	
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script src="/assets/js/jQuery-plugin/citylist/querycity.js"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/common.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('static/js/choiceCity.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/staticState/chioceDestJson.js'); ?>"></script>
<script type="text/javascript">

$('#starttime1').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
});
$('#endtime1').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
});
	//添加管家
	var s = true;
   function submitForm(obj){
       var depart_id=$('input[name="depart_id"]').val();
       if(depart_id==''){
           alert('请选择营业部门');
           return false;
        }
	   if (s == false) {
			return false;
		} else {
			s = false;
		}
	   var type = $("input[name='type']:checked").val();
	   if (type == 1) {
		   $(".abroad_input").find("select").attr("disabled","disabled");
		   $(".abroad_input").find("input").attr("disabled","disabled");
	   } else {
		   $(".domestic_input").find("select").attr("disabled","disabled");
		   $(".domestic_input").find("input").attr("disabled","disabled");
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
	
 		$.post("/admin/a/manage/save_sales_expert",$("#expertFrom").serialize(),function(json){
			s = true;
			var data = eval("("+json+")");
 			if (data.code == 2000) {
				alert(data.msg);
				window.history.go(-1);
			} else {
				alert(data.msg);
			}
		}) 
		return false;
   }
	$('input[name="type"]').click(function(){
       var val=$(this).val();
       if(val==2){ //境外
    	   $(".abroad_input").show().find("input").removeAttr("disabled");
           $(".domestic_input").hide();
           $(".abroad_input").find("select").removeAttr("disabled");
       }else{ //境内
    	   $(".domestic_input").show().find("input").removeAttr("disabled");
           $(".abroad_input").hide();
           $(".domestic_input").find("select").removeAttr("disabled");
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
 	function deleteLi(obj){
		$(obj).parents("td").parents("tr").remove();
	} 
	//添加从业经历	
	var num = 2;
	$('.add_job').click(function(){		
	    var html='<tr class="train_len">';
	    html= html+'<td style="text-align:center"><input class="time" readonly id="starttime'+num+'" name="starttime[]" type="text">&nbsp;&nbsp;至&nbsp;&nbsp;';
	    html= html+'<input class="time"  name="endtime[]" readonly id="endtime'+num+'" type="text"></td>';
	    html= html+'<td style="text-align:center"><input class="time_1" name="company_name[]" type="text"></td>';
	    html= html+'<td style="text-align:center"><input class="time_1" name="job[]" type="text"></td>'; 
		html=html+'<td style="text-align:center"><input class="time_1" name="description[]" type="text"></td>';
		html=html+' <td style="text-align:center"><span class="Delete"   onclick="deletejob(this);">删除</span></td> </tr>';      
	    $('.job_table').append(html);  
	    $('#starttime'+num).datetimepicker({
	    	lang:'ch', //显示语言
	    	timepicker:false, //是否显示小时
	    	format:'Y-m-d', //选中显示的日期格式
	    	formatDate:'Y-m-d',
	    });
	    $('#endtime'+num).datetimepicker({
	    	lang:'ch', //显示语言
	    	timepicker:false, //是否显示小时
	    	format:'Y-m-d', //选中显示的日期格式
	    	formatDate:'Y-m-d',
	    });  
	})
	//删除从业经历	
 	function deletejob(obj){
		$(obj).parents("td").parents("tr").remove();
	} 
	/*-----------------------------------上传图片-----------------------------*/
	var imgProportion = {1:"360x360",2:"350x200",3:"360x360",4:"360x360"};
	var xiuBox = {1:'xiuxiu_box1',2:'xiuxiu_box2',3:"xiuxiu_box3",4:"xiuxiu_box4"};
	var xiuxiuEditor = {1:'xiuxiuEditor1',2:'xiuxiuEditor2',3:"xiuxiuEditor3",4:"xiuxiuEditor4"};
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
					
					if (type == 3) {
						buttonObj.prev("input").val(data.msg);
						buttonObj.next("span").html(data.msg);
					} else if (type == 2) {
						buttonObj.prev("img").attr("src",data.msg);
						buttonObj.next("input").val(data.msg);
					} else if (type == 1){
						buttonObj.prev("img").attr("src",data.msg);
						$('input[name="photo"]').val(data.msg);	
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
	    var _con = $('#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4'); // 设置目标区域
	    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
	        $("#xiuxiuEditor1,#xiuxiuEditor2,#xiuxiuEditor3,#xiuxiuEditor4").hide();
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
		var html = '<select name="province" style="width:120px;" onchange="getCitySel(this)"><option value="0">请选择</option>';
		$.each(areaData.topArea ,function(index,item){
			html += '<option value="'+item.id+'">'+item.name+'</option>';
		})
		html += "</select>";
		$("#expertAddress1").append(html);
	})
}
function getCitySel(obj) {
	var id = $(obj).val();
	$(obj).next("select").remove();
	if (id == 0) {
		return false;
	}
	var html = '<select name="city" style="width:128px;" onchange="getRegionCheck(this)"><option value="0">请选择</option>';
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
	var html = "";
	$.each(areaData[id] ,function(index ,item){
		html += '<li><input type="checkbox" name="visit_service[]" value="'+item.id+'">'+item.name+'</li>';
	})
	$(".visit_service_list").find("li").remove();
	$(".visit_service_list").append(html);
	$(".visit_service_list").parents(".domestic_input").show();
}
$(".abroad_radio").removeAttr("disabled");

/***************************选择营业部门***********************************/
$('.colse_travel').click(function() {
	$('.eject_body').hide();
})
//选择营业部门弹出层
$('.agent_name_button').click(function() {
	$.post(
		"/admin/a/manage/sells_depart",
		{'is':1,'pagesize':18},
		function(data) {
			data = eval('('+data+')');
			$('.eject_content').html('');
			$.each(data.list ,function(key ,val) {
				var str = '<div class="choice_tralve_agent" agent_id="'+val.id+'">'+val.name+'</div>';
				$('.eject_content').append(str);
			})
			$('.eject_content').append('<div style="clear:both;"></div>');
			$('.page_travel').html(data.page_string);

			$('input[name="search_travel_name"]').val('');
			$('.eject_content').css('min-height','200px');
			$('.eject_body').css({'z-index':'10000','top':'10px','min-height':'400px'}).show();

			//点击营业部执行
			$('.choice_tralve_agent').click(function() {
				$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
				$(this).css('border','2px solid green').addClass('active');
			})

			//点击分页
			$('.ajax_page').click(function(){
				var page_new = $(this).find('a').attr('page_new');
				get_travel_data(page_new);
			})
		}
	);
})
//营业部分页
function get_travel_data(page_new) {
	var name = $('input[name="search_travel_name"]').val();
	$.post(
		"/admin/a/manage/sells_depart",
		{'is':1,'pagesize':18,'page_new':page_new,'name':name},
		function(data) {
			data = eval('('+data+')');
			$('.eject_content').html('');
			$.each(data.list ,function(key ,val) {
				var str = '<div class="choice_tralve_agent" agent_id="'+val.id+'">'+val.name+'</div>';
				$('.eject_content').append(str);
			})
			$('.eject_content').append('<div style="clear:both;"></div>');
			$('.page_travel').html(data.page_string);

			//点击旅行社时执行
			$('.choice_tralve_agent').click(function() {
				$('.choice_tralve_agent').css('border','1px solid #ccc').removeClass('active');
				$(this).css('border','2px solid green').addClass('active');
				
			})
			//点击分页
			$('.ajax_page').click(function(){
				var page_new = $(this).find('a').attr('page_new');
				get_travel_data(page_new);
			})
		}
	);
}
//点击搜索营业部门
$('.search_button').click(function(){
	get_travel_data(1);
})
//选择旅营业部门
$('.eject_through').click(function(){
	var active = $('.eject_content').find('.active');
	var agent_name = active.html();
	var agent_id = active.attr('agent_id');

	$('input[id="depart_name"]').val(agent_name);
	$('input[id="depart_id"]').val(agent_id);
	$('.eject_body').hide();
})
/*****************选择旅行社相关**结束***********************/
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

