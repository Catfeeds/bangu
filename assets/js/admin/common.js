/**
 * @method 平台公用的js文件
 */
//订单状态
var orderStatus = {'-5':'删除','-4':'已取消','-3':'取消中','-2':'平台拒绝','-1':'B1拒绝','0':'提交','1':'B1留位','4':'B1控位','5':'已出行','6':'已点评','7':'已投诉'};
//订单支付状态
var orderPay = {'0':'未付款','1':'已付款待确认','2':'已付款已确认','3':'退订中','4':'已退订'};
//是否启用
var openArr = {'0':'未启用' ,'1':'已启用'};
var enableArr = {'0':'关闭' ,'1':'正常'};
//是否显示
var showArr = {'0':'不显示','1':'显示'}
//是否可更改
var modifyArr = {'0':'可更改','1':'不可更改'}

/**
 * @method 清空form表单的输入
 * @param formId
 */
function emptyForm(formId) {
	var formObj = $("#"+formId);
	formObj.find("input[type='hidden']").val('');
	formObj.find("input[type='text']").val('');
	formObj.find("input[type='password']").val('');
	formObj.find("select").val(0);
}
//只能输入整数
$(".inputNumber").keyup(function(){
	var num = $(this).val().replace(/[^\d]/g,'');
	$(this).val(num);
})

//只能输入数字，包括小数(只可以有两位小数)(使用这个请禁用掉输入法:style="ime-mode:disabled;")
$(".inputDecimal").keydown(function(e){
	var key = e.keyCode;
	//数据48到57或96到105,8为删除键,190和110为小数点
	if ((key >= 48 && key <= 57) || key == 8 || (key >= 96 && key <= 105) || key == 190 || key == 110) {
		return true;
	} else {
		return false;
	}
}).keyup(function(){
	//替换非数字字符
	var num = $(this).val().replace(/[^\d.]/g,'');
	//保留小数点后两位
	num = num.substring(0,str_pos(num,'.')+3);
	//只可以有一个小数点
	index = strAppearNum(num ,'.');
	if(index > 1) {
		num = num.substring(0,num.replace('.','0').indexOf('.'));
	}
	$(this).val(num);
})
//只能输入数字，包括小数(只可以有两位小数)，并且不可以超过最大值(最大值保存在maxNumber属性中)(使用这个请禁用掉输入法:style="ime-mode:disabled;")
$(".inputDecimalMax").keydown(function(e){
	var key = e.keyCode;
	//数据48到57或96到105,8为删除键,190和110为小数点
	if ((key >= 48 && key <= 57) || key == 8 || (key >= 96 && key <= 105) || key == 190 || key == 110) {
		return true;
	} else {
		return false;
	}
}).keyup(function(){
	//替换非数字字符
	var num = $(this).val().replace(/[^\d.]/g,'');
	//只可以有一个小数点
	index = strAppearNum(num ,'.');
	if(index > 1) {
		num = num.substring(0,num.replace('.','0').indexOf('.'));
	}
	//保留小数点后两位
	num = num.substring(0,str_pos(num,'.')+3);
	//不可超过最大值
	var maxNum = ($(this).attr('maxNumber'))*1;
	if (num > maxNum) {
		num = maxNum
	}
	$(this).val(num);
})
/**
 * @method 获取字符在另一个字符中第一次出现的位置
 * @param str 再此字符中查找
 * @param searchStr 要查找的字符
 * @returns number
 */
function str_pos(str ,searchStr) {
	var index = str.indexOf(searchStr);
	if(index == -1) {
		return str.length;
	} else {
		return index;
	}
}
/**
 * @method 获取一个字符再另一个字符中出现的次数
 * @param str  再此字符中查找
 * @param searchStr 要查找的字符
 * @returns number
 */
function strAppearNum(str ,searchStr) {
	var num = (str.split(searchStr)).length-1;
	return num;
}
/**
 * @method 将字符串中出现的字符全部替换成另外一个字符
 * @param str  在这个字符中查找替换
 * @param rStr 要替换的字符
 * @param lstr 替换成的字符
 * @returns
 */
function replaceStr(str ,rStr ,lstr) {
	var number = strAppearNum(str ,rStr);
	var i = 0;
	for(i ;i<number ;i++) {
		str = str.replace(rStr ,lstr);
	}
	return str;
}
//图片的大图预览
$(".previewBigImg").mouseover(function(){
	var topHeight = parseInt($(this).offset().top);//原图到文档上边的距离
	var leftWidth = parseInt($(this).offset().left);//原图到文档左边的距离
	var smallWidth = parseInt($(this).width());// 原图的宽度
	var smallHeight = parseInt($(this).height());//原图的高度
	var scrollHeight = $(document).scrollTop(); //滚动条的高度
	var width = $(document).width();
	var height = $(document).height();
	var src = $(this).attr("src");
	var bigWidthImg = $(this).attr("bigWidth"); //大图的宽度
	if (typeof bigWidthImg == "undefined") {
		bigWidthImg = 480;
	}
	//计算大图到浏览器左边的距离
	if (width - (leftWidth + smallWidth) < bigWidthImg) {
		var positionLeft =  leftWidth - bigWidthImg -10;
	} else {
		var positionLeft = leftWidth + smallWidth + 10;
	}
	//计算大图到浏览器上边的距离
//	if ((topHeight - bigWidthImg) < scrollHeight) {
//		var positionTop = topHeight - bigWidthImg;
//	} else {
//		var positionTop = topHeight - bigWidthImg + smallWidth;
//	}
	if ((topHeight - bigWidthImg) < 0) {
		var positionTop = 0;
	} else {
		var positionTop = topHeight - bigWidthImg + smallWidth;
	}

	$(this).after("<div style='position:fixed;left:"+positionLeft+"px;top:"+positionTop+"px;'></div>");
	$(this).next("div").append("<img src='"+src+"' width='"+bigWidthImg+"' />");
}).mouseout(function(){
	$(this).next("div").remove();
})
//查看图片大图
function bigImg(obj) {
	var topHeight = parseInt($(obj).offset().top);
	var leftWidth = parseInt($(obj).offset().left);
	var smallWidth = parseInt($(obj).width());
	var smallHeight = parseInt($(obj).height());
	var scrollHeight = $(document).scrollTop();
	var src = $(obj).attr("src");
	var bigWidthImg = $(obj).attr("bigWidth"); //大图的宽度
	if (typeof bigWidthImg == "undefined") {
		bigWidthImg = 240;
	}
	var bigWidth = leftWidth + smallWidth + 10;
	var bigHeight = topHeight -smallHeight - scrollHeight;
	$(obj).after("<div style='position:fixed;left:"+bigWidth+"px;top:"+bigHeight+"px;'></div>");
	$(obj).next("div").append("<img src='"+src+"' width='"+bigWidthImg+"' />");
}
//鼠标移出删除大图
function removeBig(obj) {
	$(obj).next("div").remove();
}

// 验证整数(非必填)
$('.positive_int').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	// 验证规则
	var preg_int = /^[0-9]{1,5}$/;
	var positive_int = $(this).val();
	if (positive_int.length > 0) {
		if (!preg_int.test(positive_int)) {
			$(this).css('border', '1px solid red').addClass('error');
		} else {
			$(this).css('border', '1px solid #D5D5D5').removeClass('error');
		}
	}
})
// 验证整数(必填)
$('.positive_int_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	// 验证规则
	var preg_int = /^[0-9]{1,5}$/;
	var positive_int = $(this).val();
	if (!preg_int.test(positive_int)) {
		$(this).css('border', '1px solid red').addClass('error');
	} else {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	}
})
// 验证正整数(大于0)(必填)
$('.pi_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var preg_int = /^[1-9]{1,8}$/;
	var positive_int = $(this).val();
	if (!preg_int.test(positive_int)) {
		$(this).css('border', '1px solid red').addClass('error');
	} else {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	}
})
// 验证汉字，字母，数字(必填)
$('.cln_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var content = $(this).val();
	var preg_cln = /^[\u4e00-\u9fa5a-z0-9A-Z]+$/;
	if (preg_cln.test(content)) {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	} else {
		$(this).css('border', '1px solid red').addClass('error');
	}
})
// 验证汉字或字母(必填)
$('.cl_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var content = $(this).val();
	var preg_cl = /^([\u4e00-\u9fa5]+)$|^([a-z]+)$/;
	if (preg_cl.test(content)) {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	} else {
		$(this).css('border', '1px solid red').addClass('error');
	}
})
// 验证密码
$('.password').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var password = $(this).val();
	var maxlength = $(this).attr('maxlength');
	var minlength = $(this).attr('minlength');
	var pass_len = password.length;
	var preg_pass = /\s/;
	if (!preg_pass.test(password)) {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
		if (pass_len < minlength || pass_len > maxlength) {
			$(this).css('border', '1px solid red').addClass('error');
		} else {
			$(this).css('border', '1px solid #D5D5D5').removeClass('error');
		}
	} else {
		$(this).css('border', '1px solid red').addClass('error');
	}

})
// 确认密码验证
$('.repass').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var repass = $(this).val();
	var password = $('.password').val();
	if (repass !== password) {
		$(this).css('border', '1px solid red').addClass('error');
	} else {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	}
})
// 内容不可为空
$('.content_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var content = $(this).val();
	if (content.length < 1) {
		$(this).css('border', '1px solid red').addClass('error');
	} else {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	}
})
// 验证邮箱(非必填)
$('.email_no_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var email = $(this).val();
	if (email.length > 0) {
		if (/^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/.test(email)) {
			$(this).css('border', '1px solid #D5D5D5').removeClass('error');
		} else {
			$(this).css('border', '1px solid red').addClass('error');
		}
	}
})
// 验证手机号(必填)
$('.mobile_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var mobile = $(this).val();
	if (/^1[34785][0-9]{9}$/.test(mobile)) {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	} else {
		$(this).css('border', '1px solid red').addClass('error');
	}
})

// 验证身份证(必填)
$('.idcard_required').focus(function() {
	$(this).css('border', '1px solid #D5D5D5').removeClass('error');
}).blur(function() {
	var idcard = $(this).val();
	if (IdentityCodeValid(idcard)) {
		$(this).css('border', '1px solid #D5D5D5').removeClass('error');
	} else {
		$(this).css('border', '1px solid red').addClass('error');
	}
})

// 身份证验证
function IdentityCodeValid(code) {
	var city = {
	    11 : "北京",
	    12 : "天津",
	    13 : "河北",
	    14 : "山西",
	    15 : "内蒙古",
	    21 : "辽宁",
	    22 : "吉林",
	    23 : "黑龙江 ",
	    31 : "上海",
	    32 : "江苏",
	    33 : "浙江",
	    34 : "安徽",
	    35 : "福建",
	    36 : "江西",
	    37 : "山东",
	    41 : "河南",
	    42 : "湖北 ",
	    43 : "湖南",
	    44 : "广东",
	    45 : "广西",
	    46 : "海南",
	    50 : "重庆",
	    51 : "四川",
	    52 : "贵州",
	    53 : "云南",
	    54 : "西藏 ",
	    61 : "陕西",
	    62 : "甘肃",
	    63 : "青海",
	    64 : "宁夏",
	    65 : "新疆",
	    71 : "台湾",
	    81 : "香港",
	    82 : "澳门",
	    91 : "国外 "
	};
	var tip = "";
	var pass = true;

	if (!code || !/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/i.test(code)) {
		tip = "身份证号格式错误";
		pass = false;
	}

	else if (!city[code.substr(0, 2)]) {
		tip = "地址编码错误";
		pass = false;
	} else {
		// 18位身份证需要验证最后一位校验位
		if (code.length == 18) {
			code = code.split('');
			// ∑(ai×Wi)(mod 11)
			// 加权因子
			var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
			// 校验位
			var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
			var sum = 0;
			var ai = 0;
			var wi = 0;
			for (var i = 0; i < 17; i++) {
				ai = code[i];
				wi = factor[i];
				sum += ai * wi;
			}
			var last = parity[sum % 11];
			if (parity[sum % 11] != code[17]) {
				tip = "校验位错误";
				pass = false;
			}
		}
	}
	// if (!pass) alert(tip);
	return pass;
}

// 生成6位随机码
function create_rand_code() {
	var $chars = '0123456789';
	var rand_code = '';
	for (i = 0; i < 6; i++) {
		rand_code += $chars.charAt(Math.floor(Math.random() * 10));
	}
	return rand_code;
}

/**
 * @method ajax上传图片文件(文件上传地址统一使用一个)
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function ajax_upload_file(file_id, name, prefix) {
	$.ajaxFileUpload({
	    url : '/admin/upload/ajax_upload_file',
	    secureuri : false,
	    fileElementId : file_id,// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	        filename : file_id,
	        prefix : prefix
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
			    $('#' + file_id).next('.upload_pic').remove();
			    $('#' + file_id).after("<img class='upload_pic' src='" + data.msg + "' width='80' height='80'>");
			    $('input[name="' + name + '"]').val(data.msg);
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
	    }
	});
}
/**
 * @method ajax上传图片文件(文件上传地址统一使用一个)
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function uploadImgFile(obj) {
	var file_id = $(obj).attr("id");
	var inputObj = $(obj).nextAll("input[type='hidden']");
	$.ajaxFileUpload({
	    url : '/admin/upload/uploadImgFile',
	    secureuri : false,
	    fileElementId : file_id,// file标签的id
	    dataType : 'json',// 返回数据的类型
	    data : {
	    	fileId : file_id
	    },
	    success : function(data, status) {
		    if (data.code == 2000) {
		    	inputObj.siblings(".uploadImg").remove();
		    	inputObj.after("<img class='uploadImg' src='" + data.msg + "' width='80'>");
		    	inputObj.val(data.msg);
		    } else {
			    alert(data.msg);
		    }
	    },
	    error : function(data, status, e)// 服务器响应失败处理函数
	    {
		    alert('上传失败(请选择jpg/jpeg/png的图片重新上传)');
	    }
	});
}


/****************出发城市联动********************/
$('select[name="start_province"]').on('change', function() {
	var province = $('select[name="start_province"] :selected').val();
	if (province == 0) {
		$(this).next('select').remove();
		return false;
	}
	if ($(this).next('select').length == 1) {
		$(this).next('select').html("<option value='0'>请选择</option>");
	} else {
		$(this).after("<select name='start_city' style='width:140px;'><option value='0'>请选择</option></option>");
	}
	$.post("/admin/a/order/get_startplace", {
		id : province
	}, function(data) {
		var data = eval('(' + data + ')');
		$.each(data, function(key, val) {
			var str = "<option value='" + val.id + "'>" + val.cityname + "</option>";
			$('select[name="start_city"]').append(str);
		})
	})
});
/************ 地区下拉选择开始 ****************/
//var selectNameArr = {'country':'country','province':'province','city':'city','region':'region'};
var typeJson = {
		"1":{"1":"province","2":"city"},
		"3":{"1":"country","2":"province","3":"city","4":"region"},
		"2":{"1":"province","2":"city","3":"region"},
		"4":{"1":"startProvince","2":"startCity"},
};
/**
 * @method 获取中国的省份，城市下拉
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 * @param  defaultJson  默认值{0:21,1:235}
 */
function chinaPC(selId ,width ,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getChinaAreaPC",{},function(json){
		areaData = eval("("+json+")");
		var pHtml = createSelHtml(areaData.topArea ,'province' ,1 ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createSelHtml(areaData[defaultJson[0]] ,'city' ,1 ,width);
			selObj.append(pHtml);
			$("select[name='province']").val(defaultJson[0]);
			$("select[name='city']").val(defaultJson[1]);
		}
	})
}
/**
 * @method 中国的省市区三级联动
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度 
 * @param  defaultJson  默认值{0:21,1:235,2:534}
 */
function chinaPCR(selId ,width ,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getChinaAreaPCR",{},function(json){
		PCRData = eval("("+json+")");
		var pHtml = createSelHtml(PCRData.topArea ,'province' ,3 ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createSelHtml(areaData[defaultJson[0]] ,'city' ,3 ,width);
			selObj.append(pHtml);
			var pHtml = createSelHtml(areaData[defaultJson[1]] ,'region' ,3 ,width);
			selObj.append(pHtml);
			$("select[name='province']").val(defaultJson[0]);
			$("select[name='city']").val(defaultJson[1]);
			$("select[name='region']").val(defaultJson[2]);
		}
	})
}
/**
 * @method 地区四级联动
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度 
 */
function areaAll(selId ,width) {
	var selObj = $("#"+selId);
	//areaSelectWidth = width;
	$.post("/common/area/getAreaAll",{},function(json){
		areaAllData = eval("("+json+")");
		var pHtml = createSelHtml(areaAllData.topArea ,'country' ,4 ,width);
		selObj.append(pHtml);
		
	})
}


/**
 * @method 获取境外的国家，城市下拉
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 * @param  defaultJson  默认值{0:21,1:235}
 */
function abroadPC(selId ,width ,defaultJson){
	var selObj = $("#"+selId);
	//areaSelectWidth = width;
	$.post("/common/area/getAbroadAreaPC",{},function(json){
		abroadData = eval("("+json+")");
		var pHtml = createSelHtml(abroadData.topArea ,'province' ,2 ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createSelHtml(areaData[defaultJson[0]] ,'city' ,2 ,width);
			selObj.append(pHtml);
			$("select[name='province']").val(defaultJson[0]);
			$("select[name='city']").val(defaultJson[1]);
		}
	})
}

/**
 * @method 获取国家，省，市
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 * @param  defaultJson  默认值{0:21,1:235}
 */
function getAreaCPC(selId ,width ,defaultJson){
	var selObj = $("#"+selId);
	//areaSelectWidth = width;
	$.post("/common/area/getAreaCPC",{},function(json){
		areaCPC = eval("("+json+")");
		var pHtml = createSelHtml(areaCPC.topArea ,'country' ,5 ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createSelHtml(areaCPC[defaultJson[0]] ,'province' ,5 ,width);
			selObj.append(pHtml);
			var pHtml = createSelHtml(areaCPC[defaultJson[1]] ,'city' ,5 ,width);
			selObj.append(pHtml);
			$("select[name='country']").val(defaultJson[0]);
			$("select[name='province']").val(defaultJson[1]);
			$("select[name='city']").val(defaultJson[2]);
		}
	})
}

/**
 * @method 生成下拉的select元素
 * @param selArr  下拉框中的数据
 * @param selName 下拉框的name值
 * @param type 生成的下拉框类型 1->中国省市两级联动 	2->国外的国家，城市两级联动		3->中国的省市区联动三级联动  4->地区四级联动
 * @param width select控件的宽度
 * @returns {String}
 */
function createSelHtml(selArr ,selName ,type ,width){
	if (typeof width == 'undefined' || width == 0) {
		var width = 160;
	}
	var html = "<select name='"+selName+"' style='width:"+width+"px;' onchange='getLowerArea(this ,"+type+" ,"+width+");'><option value='0'>请选择</option>";
	$.each(selArr ,function(key ,val) {
		html += "<option value='"+val.id+"'>"+val.name+"</option>";
	})
	html += "</select>";
	
	return html;
}
/**
 * @method 生成select下拉框的html元素
 * @param obj  
 * @param type 生成的下拉框类型 1->中国省市两级联动 	2->国外的国家，城市两级联动		3->中国的省市区联动三级联动
 * @param width select控件的宽度
 */
function getLowerArea(obj ,type ,width) {
	var areaId = $(obj).val();
	var areaName = $(obj).attr("name");
	var html = '';
	$(obj).nextAll('select').remove();
	if (areaId == 0) {
		return false;
	}
	if (areaName == 'country') {
		var selName = 'province';
	} else if (areaName == 'province') {
		var selName = 'city';
	} else if (areaName == 'city') {
		var selName = 'region';
	}
	if (type == 1) {
		//中国的省市两级联动
		if (typeof areaData[areaId] != 'undefined') {
			html += createSelHtml(areaData[areaId] ,selName ,type ,width);	
		}
	} else if (type == 2) {
		//国外的国家，城市两级联动
		if (typeof abroadData[areaId] != 'undefined') {
			html += createSelHtml(abroadData[areaId] ,selName ,type ,width);	
		}
	} else if (type == 3) {
		//中国省市区
		if (typeof PCRData[areaId] != 'undefined') {
			html += createSelHtml(PCRData[areaId] ,selName ,type ,width);	
		}
	} else if (type == 4) {
		//所有地区
		if (typeof areaAllData[areaId] != 'undefined') {
			html += createSelHtml(areaAllData[areaId] ,selName ,type ,width);	
		}
	} else if (type == 5) {
		//国家，省，市
		if (typeof areaCPC[areaId] != 'undefined') {
			html += createSelHtml(areaCPC[areaId] ,selName ,type ,width);	
		}
	}
	$(obj).after(html);
}
/************ 地区下拉选择结束 ****************/

/***************目的地下拉选择开始********************/
/**
 * @method 目的地三级下拉
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 */
function destSelect(selId ,width ,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getDestThreeData",{},function(json){
		destData = eval("("+json+")");
		var pHtml = createDestSelHtml(destData.top ,'destOne' ,width);
		selObj.html(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createDestSelHtml(destData[defaultJson[0]] ,'destTwo' ,width );
			selObj.append(pHtml);
			var pHtml = createDestSelHtml(destData[defaultJson[1]] ,'destThree' ,width );
			selObj.append(pHtml);
			$("select[name='destOne']").val(defaultJson[0]);
			$("select[name='destTwo']").val(defaultJson[1]);
			$("select[name='destThree']").val(defaultJson[2]);
		}
	})
}
/**
 * @method 国内目的地
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 */
function domesticDestSel(selId ,width ,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getDomesticDestSel",{},function(json){
		destData = eval("("+json+")");
		var pHtml = createDestSelHtml(destData.top ,'destOne' ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			//alert(defaultJson[0])
			var pHtml = createDestSelHtml(destData[defaultJson[0]] ,'destTwo' ,width );
			selObj.append(pHtml);
			$("select[name='destOne']").val(defaultJson[0]);
			$("select[name='destTwo']").val(defaultJson[1]);
		}
	})
}
/**
 * @method 国外目的地
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 */
function abroadDestSel(selId ,width ,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getAbroadDestSel",{},function(json){
		destData = eval("("+json+")");
		var pHtml = createDestSelHtml(destData.top ,'destOne' ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createDestSelHtml(destData[defaultJson[0]] ,'destTwo' ,width );
			selObj.append(pHtml);
			$("select[name='destOne']").val(defaultJson[0]);
			$("select[name='destTwo']").val(defaultJson[1]);
		}
	})
}
/**
 * @method 生成下拉的select元素
 * @param selArr  下拉框中的数据
 * @param selName 下拉框的name值
 * @param width select控件的宽度
 * @returns {String}
 */
function createDestSelHtml(selArr ,selName  ,width){
	if (typeof width == 'undefined' || width == 0) {
		var width = 160;
	}
	var html = "<select name='"+selName+"' style='width:"+width+"px;' onchange='getLowerDest(this ,"+width+");'><option value='0'>选择目的地</option>";
	$.each(selArr ,function(key ,val) {
		html += "<option value='"+val.id+"'>"+val.kindname+"</option>";
	})
	html += "</select>";
	return html;
}
/**
 * @method 生成select下拉框的html元素
 * @param obj  
 * @param width select控件的宽度
 */
function getLowerDest(obj ,width) {
	var destId = $(obj).val();
	var destName = $(obj).attr("name");
	//var html = '';
	$(obj).nextAll('select').remove();
	
	if (destName == 'destOne') {
		var selName = 'destTwo';
	} else if (destName == 'destTwo') {
		var selName = 'destThree';
	} else if (destName == 'destThree') {
		var selName = 'destFour';
	}
	if ($(obj).parents("form").find("input[name='line_id']").length>0) {
		$(obj).parents("form").find("input[name='line_id']").val('');
		$(obj).parents("form").find("input[name='linename']").val('');
	}
	if (destId == 0) {
		return false;
	}
	if (typeof destData[destId] != 'undefined') {
		var html = createDestSelHtml(destData[destId] ,selName ,width);	
		$(obj).after(html);
	}
} 

/***************目的地下拉选择结束********************/

/****************出发城市下拉开始**********************/

/**
 * @method 出发城市的下拉框(未完成)
 * @author jiakairong
 * @param  parameter 由一组参数组成的json数据{data:'城市数据',width:'select宽度',positionId:'位置ID',defaultJson:'默认值' ,name:{1:'name值1',1:'name值2'...}}
 */
function createSelect(parameter) {
	var dataArr = parameter.data; //出发城市的数组
	var positionObj = $("#"+parameter.positionId); //下拉框放的位置的对象
	var defaultJson = parameter.defaultJson; //下拉框的默认值
	var width = parameter.width; //select标签的宽度
	var name = parameter.name;//select的name值

	var html = "<select name='"+name[1]+"'><option value='0'>请选择</option>";
	$.each(dataArr.top ,function(key ,val) {
		html += "<option value='"+val.id+"'>"+val.name+"</option>";
	})
	html += "</select>";
	positionObj.append(html).find("select").css('width',width);
	
	$.each(name ,function(k ,v) {
		$("select[name='"+v+"']").change(function(){
			var id = $(this).val();
			if (typeof dataArr[id] != 'undefined') {
				var key = k*1 + 1;
				var html = "<select name='"+name[key]+"'><option value='0'>请选择</option>";
				$.each(dataArr[id] ,function(index ,item) {
					html += "<option value='"+item.id+"'>"+item.name+"</option>";
				})
				html += "</select>";
				positionObj.append(html).last("select").css('width',width);
			}
		})
	})
	
}



/**
 * @method 出发城市联动
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 */
function startCitySelect(selId ,width,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getStartCity",{},function(json){
		startData = eval("("+json+")");
		var pHtml = createStartSelHtml(startData.top ,'start_country' ,width);
		selObj.html(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createStartSelHtml(startData[defaultJson[0]] ,'start_province' ,width );
			selObj.append(pHtml);
			var pHtml = createStartSelHtml(startData[defaultJson[1]] ,'start_city' ,width );
			selObj.append(pHtml);
			$("select[name='start_country']").val(defaultJson[0]);
			$("select[name='start_province']").val(defaultJson[1]);
			$("select[name='start_city']").val(defaultJson[2]);
		}
	})
}
/**
 * @method 出发城市联动(国家，省份)
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 */
function startCityCP(selId ,width,defaultJson) {
	var selObj = $("#"+selId);
	$.post("/common/area/getStartCityCP",{},function(json){
		startData = eval("("+json+")");
		var pHtml = createStartSelHtml(startData.top ,'start_country' ,width);
		selObj.html(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createStartSelHtml(startData[defaultJson[0]] ,'start_province' ,width );
			selObj.append(pHtml);
			$("select[name='start_country']").val(defaultJson[0]);
			$("select[name='start_province']").val(defaultJson[1]);
		}
	})
}
/**
 * @method 生成下拉的select元素
 * @param selArr  下拉框中的数据
 * @param selName 下拉框的name值
 * @param width select控件的宽度
 * @returns {String}
 */
function createStartSelHtml(selArr ,selName,width){
	if (typeof width == 'undefined' || width == 0) {
		var width = 160;
	}
	var html = "<select name='"+selName+"' style='width:"+width+"px;' onchange='getLowerStart(this ,"+width+");'><option value='0'>选择出发地</option>";
	
	$.each(selArr ,function(key ,val) {
		html += "<option value='"+val.id+"'>"+val.cityname+"</option>";
	})
	html += "</select>";
	return html;
}
/**
 * @method 生成select下拉框的html元素
 * @param obj  
 * @param width select控件的宽度
 */
function getLowerStart(obj ,width) {
	var startId = $(obj).val();
	var startName = $(obj).attr("name");
	//var html = '';
	$(obj).nextAll('select').remove();
	
	if (startName == 'start_country') {
		var selName = 'start_province';
	} else if (startName == 'start_province') {
		var selName = 'start_city';
	} else if (startName == 'start_city') {
		if ($(obj).parents("form").find("select[name='kind_id']")) {
			$(obj).parents("form").find("select[name='kind_id']").val(0);
		}
	}
	if (startId == 0) {
		return false;
	}
	if (typeof startData[startId] != 'undefined') {
		var html = createStartSelHtml(startData[startId] ,selName ,width);	
		$(obj).after(html);
	}
} 

/****************出发城市下拉结束**********************/


function get_ajax_page_data(columns) {
	var url = $('#search_condition').attr("action");
	//获取数据
	$.post(url,$("#search_condition").serialize(),function(data) {
		var data = eval("("+data+")");
		$('.pagination_title').html("<tr></tr>");
		$.each(columns ,function(key ,val){
			$('.pagination_title tr').append("<th style='text-align:center;width:"+val.width+"px;'>"+val.title+"</th>");
		})
		$('.pagination_data').html('');
		$.each(data.list ,function(index,item){
			var html = "<tr>";
			$.each(columns ,function(k ,v) {
				if (typeof v.field == 'object') {
					html += "<td style='text-align:"+v.align+";'>"+v.formatter(item)+"</td>";
				} else {
					if (typeof item[v.field] == 'object') { //读取数据为null
						html += "<td style='text-align:"+v.align+";'></td>";
					} else {
						if (typeof(v.length) == 'number') {
							if (typeof item[v.field] != 'object') {
								if (item[v.field].length > v.length) {
									html += "<td style='text-align:"+v.align+";' title='"+item[v.field]+"'>"+item[v.field].substring(0,v.length)+"...</td>";
								} else {
									html += "<td style='text-align:"+v.align+";' title='"+item[v.field]+"'>"+item[v.field]+"</td>";
								}	
							} else {
								html += "<td style='text-align:"+v.align+";'></td>";
							}
						} else {
							html += "<td style='text-align:"+v.align+";'>"+item[v.field]+"</td>";
						}
					}
					
				}
				
			})
			html += "</tr>";
			$('.pagination_data').append(html);
		})
		$('.pagination').html(data.page_string);
		$('.ajax_page').click(function(){
			if ($(this).hasClass('active')) {
				return false;
			}
			var page = $(this).find('a').attr('page_new');
			$('input[name="page_new"]').val(page);
			get_ajax_page_data(columns);
		})
	})
}
//ajax获取数据
//positionName的值代表的意义：formId->列表搜索的form标签的ID ； title->列表头部thead标签ID ； 
// body->列表数据tbody标签ID ； page->分页标签ID
function ajaxGetData(columns ,positionName) {
	var formObj = $("#"+positionName.formId); 
	var titleObj = $("#"+positionName.title);
	var bodyObj = $("#"+positionName.body);
	var pageObj = $("#"+positionName.page);
	var url = formObj.attr("action");
	//获取数据
	$.post(url,formObj.serialize(),function(data) {
		var data = eval("("+data+")");
		titleObj.html("<tr></tr>");
		$.each(columns ,function(key ,val){
			titleObj.find('tr').append("<th style='width:"+val.width+"px;text-align:center;'>"+val.title+"</th>");
		})
		bodyObj.html('');
		$.each(data.list ,function(index,item){
			var html = "<tr>";
			$.each(columns ,function(k ,v) {
				if (typeof v.field == 'object') {
					html += "<td style='text-align:"+v.align+";'>"+v.formatter(item)+"</td>";
				} else {
					if (typeof item[v.field] == 'object') { //读取数据为null
						html += "<td style='text-align:"+v.align+";'></td>";
					} else {
						if (typeof(v.length) == 'number') {
							if (item[v.field].length > v.length) {
								html += "<td style='text-align:"+v.align+";' title='"+item[v.field]+"'>"+item[v.field].substring(0,v.length)+"...</td>";
							} else {
								html += "<td style='text-align:"+v.align+";' title='"+item[v.field]+"'>"+item[v.field]+"</td>";
							}	
						} else {
							html += "<td style='text-align:"+v.align+";'>"+item[v.field]+"</td>";
						}
					}
					
				}
				
			})
			html += "</tr>";
			bodyObj.append(html);
		})
		pageObj.html(data.page_string);
		$('.ajax_page').click(function(){
			if ($(this).hasClass('active')) {
				return false;
			}
			var page = $(this).find('a').attr('page_new');
			formObj.find('.page_new').val(page);
			ajaxGetData(columns ,positionName);
		})
	})
}

//鼠标移入 移出给按钮改变颜色
$('.eject_botton').find('div').mouseover(function(){
	$(this).css('background','#2DC3E8');
}).mouseout(function(){
	$(this).css('background','#fff');
})