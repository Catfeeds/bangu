var InterValObj;
var seconds = 60; //倒计时秒数
/**
 * @method 倒计时
 * @param buttonId 倒计时显示的元素ID 
 */
function countdown(buttonId) {
	countdownButton = $("#"+buttonId);
	countdownButton.html(seconds+"s重新发送");
	InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
}
//timer处理函数
function SetRemainTime() {
	if (seconds == 0) {                
         window.clearInterval(InterValObj);//停止计时器
         countdownButton.html("重新发送");
         codeStatus = true;
         seconds = 60
    }
    else {
    	seconds--;
    	countdownButton.html("" + seconds + "s重新发送");
    	codeStatus = false;
    }
}


//验证手机号
function isMobile(mobile) {
	var pregMobile = /^1[34578]{1}\d{9}$/;
	if (pregMobile.test(mobile)) {
		return true;
	} else {
		return false;
	}
}
//验证邮箱号
function isEmail(email) {
	var pregEmail = /^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/;
	if (pregEmail.test(email)) {
		return true;
	} else {
		return false;
	}
}

/************ 地区下拉选择开始 ****************/
//var selectNameArr = {'country':'country','province':'province','city':'city','region':'region'};
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
			var pHtml = createSelHtml(areaData[defaultJson[0]] ,'city' ,1 ,width);
			selObj.append(pHtml);
			var pHtml = createSelHtml(areaData[defaultJson[1]] ,'region' ,1 ,width);
			selObj.append(pHtml);
			$("select[name='province']").val(defaultJson[0]);
			$("select[name='city']").val(defaultJson[1]);
			$("select[name='region']").val(defaultJson[2]);
		}
	})
}
/**
 * @method 获取中国的省份，城市下拉
 * @author jiakairong
 * @param  selId select元素放的位置
 * @param  width select元素的宽度
 * @param  defaultJson  默认值{0:21,1:235}
 */
function chinaPC(selId ,width ,defaultJson){
	var selObj = $("#"+selId);
	$.post("/common/area/getChinaAreaPC",{},function(json){
		areaData = eval("("+json+")");
		var pHtml = createSelHtml(areaData.topArea ,'province' ,1 ,width);
		selObj.append(pHtml);
		if (typeof defaultJson != 'undefined') {
			var pHtml = createSelHtml(areaData[defaultJson[0]] ,'city' ,1 ,width);
			selObj.append(pHtml);
			selObj.find("select[name='province']").val(defaultJson[0]);
			selObj.find("select[name='city']").val(defaultJson[1]);
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
			var pHtml = createSelHtml(abroadData[defaultJson[0]] ,'city' ,1 ,width);
			selObj.append(pHtml);
			selObj.find("select[name='province']").val(defaultJson[0]);
			selObj.find("select[name='city']").val(defaultJson[1]);
		}
	})
}
/**
* @method 生成下拉的select元素
* @param selArr  下拉框中的数据
* @param selName 下拉框的name值
* @param type 生成的下拉框类型 1->中国省市两级联动 	2->国外的国家，城市两级联动		3->中国的省市区联动三级联动
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
	}
	$(obj).after(html);
} 

/************ 地区下拉选择结束 ****************/
