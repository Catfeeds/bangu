/**
 * @method 地区选择插件，以汉字导航，以汉字分类
 * @param json  
 */
function createChoicePlugin(json) {
	var dataArr = json.data; //提供选择的数据
	var nameObj = $("#"+json.nameId);//触发插件的输入框ID
	var valObj = $("#"+json.valId);//选中的值保存的输入框ID
	var width = json.width; //插件的宽度
	var number = json.number; //可以选择的个数
	var buttonObj = $("#"+json.buttonId);//选择多个时，显示选中的位置
	var isCallback = json.isCallback;//是否在选择后使用单独的回调函数，true or false,需要指定函数名称(给callbackFuncName赋值)
	var blurDefault = json.blurDefault;//失去焦点是否给默认值
	
	if (typeof width == 'undefined') {
		width = 560;  //默认宽度
	}
	if (typeof number == 'undefined' || number == 1) {
		number = 1; //默认可以选择一个 
		var multiSelect = false; //选择一个时，点击后隐藏插件显示
	} else {
		var multiSelect = true;
	}

	//调用选择插件
	nameObj.querycity({'data':dataArr,'width':width,type:"json",sortLableWidth:"65px",index:1,multiSelect:multiSelect,onchange:function(id,name){
		if (typeof id == 'undefined') {
			return false;
		}
		if (number == 1) {
			nameObj.val(name);
			valObj.val(id);	
		} else {
			choiceDataShow(json.buttonId ,json.valId ,number ,name ,id);
		}
		
		if (isCallback === true) { 
			json.callbackFuncName();
		}
	}})
	if (number == 1) {
		keyupEmptyId(nameObj ,valObj);
	}
	if (blurDefault === true) {
		blurDefaultVal(nameObj,valObj,isCallback ,json.callbackFuncName ,json.nameId);
	}
}


/**
 * @method 地区选择插件，以拼音导航，以拼音分类
 * @param json  
 */
function createChoicePluginPY(json) {
	var dataArr = json.data; //提供选择的数据
	var hotName = json.hotName;//热门显示名称
	var isHot = json.isHot;//是否显示热门   true or false
	var nameObj = $("#"+json.nameId);//触发插件的输入框ID
	var valObj = $("#"+json.valId);//选中的值保存的输入框ID
	var width = json.width; //插件的宽度
	var number = json.number; //可以选择的个数
	var buttonObj = $("#"+json.buttonId);//选择多个时，显示选中的位置
	var isCallback = json.isCallback;//是否在选择后使用单独的回调函数，  true or false,需要指定函数名称(给callbackFuncName赋值)
	var blurDefault = json.blurDefault;//失去焦点是否给默认值
	
	var hotList = new Array();
	
	if (typeof width == 'undefined') {
		width = 560;  //默认宽度
	}
	if (typeof number == 'undefined' || number == 1) {
		number = 1; //默认可以选择一个 
		var multiSelect = false; //选择一个时，点击后隐藏插件显示
	} else {
		var multiSelect = true;
	}
	var data = restructureData(dataArr ,isHot ,hotName);
	nameObj.querycity({'data':data.citysFlight,'width':width,'tabs':data.labelFromcity,'hotList':hotList,sort:true,index:1,multiSelect:multiSelect,onchange:function(id ,name){
		if (typeof id == 'undefined') {
			return false;
		}
		
		if (number == 1) {
			nameObj.val(name);
			valObj.val(id);
		} else {
			choiceDataShow(json.buttonId ,json.valId ,number ,name ,id);
		}
		if (isCallback === true) {
			json.callbackFuncName();
		}
	}});
	if (number == 1) {
		keyupEmptyId(nameObj ,valObj);
	}
	if (blurDefault === true) {
		blurDefaultVal(nameObj,valObj,isCallback ,json.callbackFuncName ,json.nameId);
	}
}

/**
 * @method 将数据按拼音分组
 * @param dataArr
 * @returns {___anonymous3497_3498}
 */
function restructureData (dataArr ,isHot ,hotName) {
	var labelFromcity = new Array();
	var citysFlight = new Array();
	if (isHot === true) {
		labelFromcity [hotName] = new Array();
	}
	labelFromcity ['ABCD'] = new Array();
	labelFromcity ['EFGHJ'] = new Array();
	labelFromcity ['KLMN'] = new Array();
	labelFromcity ['PQRSTW'] = new Array();
	labelFromcity ['XYZ'] = new Array();
	$.each(dataArr ,function(key ,val) {
		$.each(val.two ,function(k ,v) {
			if (typeof v.three != 'undefined' && v.three.length > 0) {
				$.each(v.three ,function(index ,item) {
					if (isHot === true && item.ishot == 1) {
						//热门
						labelFromcity [hotName].push(item.id);
					}
					citysFlight[item.id]=new Array(item.id,item.name,item.enname,item.simplename);
					//按拼音区分
					if (typeof item.simplename == 'object') {
						return false;
					}
					var firstLetter = (item.simplename.substring(0,1)).toLowerCase();
					switch(firstLetter) {
						case 'a':
						case 'b':
						case 'c':
						case 'd':
							labelFromcity ['ABCD'].push(item.id);
							break;
						case 'e':
						case 'f':
						case 'g':
						case 'h':
						case 'j':
							labelFromcity ['EFGHJ'].push(item.id);
							break;
						case 'k':
						case 'l':
						case 'm':
						case 'n':
							labelFromcity ['KLMN'].push(item.id);
							break;
						case 'p':
						case 'q':
						case 'r':
						case 's':
						case 't':
						case 'w':
							labelFromcity ['PQRSTW'].push(item.id);
							break;
						case 'x':
						case 'y':
						case 'z':
							labelFromcity ['XYZ'].push(item.id);
							break;
					}
				})
			}
		})
	})
	return {labelFromcity:labelFromcity,citysFlight:citysFlight};
}
/**
 * @method  输入框失去焦点，默认选中
 * @param nameObj
 * @param valObj
 * @param isCallback
 * @param callbackFunc
 * @param nameId
 */
function blurDefaultVal(nameObj ,valObj ,isCallback ,callbackFunc ,nameId) {
	var suggestObj = $("#suggest_city_"+nameId);
	nameObj.bind("blur" ,function(){
		if(suggestObj.find(".list_city_container").find("a").length > 0)
		{
			if (valObj.val() < 1) {
				var id = suggestObj.find(".list_city_container").find("a").eq(0).attr("dataid");
				var name = suggestObj.find(".list_city_container").find("a").eq(0).find("b").text();
				nameObj.val(name);
				valObj.val(id);
			}
			
		} else {
			nameObj.val('');
			valObj.val('');
		}
		if (isCallback === true) {
			callbackFunc();
		}
		suggestObj.hide();
	});
	if (suggestObj.is(":visible")) {
		suggestObj.mouseover(function(){
			nameObj.unbind("blur");
		}).mouseout(function(){
			nameObj.bind("blur" ,function(){
				if(suggestObj.find(".list_city_container").find("a").length > 0)
				{
					var id = suggestObj.find(".list_city_container").find("a").eq(0).attr("dataid");
					var name = suggestObj.find(".list_city_container").find("a").eq(0).find("b").text();
					nameObj.val(name);
					valObj.val(id);
					
				} else {
					nameObj.val('');
					valObj.val('');
				}
				if (isCallback === true) {
					callbackFunc();
				}
				suggestObj.hide();
			});
		})
	}
}

/**
 * @method 选择多个时，选择后的后续操作
 * @param buttonId
 * @param valId
 * @param number
 * @param name
 * @param id
 * @returns {Boolean}
 */
function choiceDataShow(buttonId ,valId ,number ,name ,id) {
	var buttonObj = $("#"+buttonId);
	var valObj = $("#"+valId);
	var buttonLen = buttonObj.children("span").length;
	if (buttonLen >= number) {
		alert("最多只可以选择"+number+"个");
	} else {
		var ids = valObj.val();
		var idArr = ids.split(",");
		var s = true;
		$.each(idArr ,function(k ,v) {
			if (id == v) {
				alert("此选项你已选择");
				s = false;
			}
		})
		if (s == false) {
			return false;
		}
		ids += id+',';
		valObj.val(ids);
		
		//添加显示按钮
		if (buttonLen == 0) {
			buttonObj.show();
			var html = '<div class="selectedTitle">已选择:</div> <span value="'+id+'" class="selectedContent">'+name+'<span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
		} else {
			var html = '<span class="selectedContent" value="'+id+'">'+name+'<span onclick="delPlugin(this ,\''+valId+'\' ,\''+buttonId+'\');" class="delPlugin">×</span></span>';
		}
		buttonObj.append(html);
	}
}

/**
 * @method 删除选择的数据显示按钮
 * @param obj
 * @param valId
 * @param buttonId
 */
function delPlugin(obj ,valId ,buttonId) {
	var valObj = $("#"+valId);
	var buttonObj = $("#"+buttonId);
	var id = $(obj).parent("span").attr("value");
	var ids = valObj.val();
	valObj.val(ids.replace(id+',',''));
	$(obj).parent("span").remove();
	if (buttonObj.children("span").length == 0) {
		buttonObj.html('');
		buttonObj.hide();
	}
}

/**
 * @method 只选择一个时，输入框变动清除之前选中的ID
 * @param nameObj
 * @param valObj
 */
function keyupEmptyId(nameObj ,valObj) {
	nameObj.keyup(function(e){
		var key =  e.which;
		if (key != 13) {
			valObj.val('');
		}
	})
}
