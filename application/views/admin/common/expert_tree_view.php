
	<link href="<?php echo base_url("assets/ht/js/ztree/zTreeStyle.css"); ?>" rel="stylesheet">
	<script type="text/javascript" src="<?php echo base_url("assets/ht/js/ztree/jquery.ztree.core.js"); ?>"></script>
	<style type="text/css">
		/*树形结构样式*/
		li.title {list-style: none;}
		ul.list {margin-left: 17px;}
		ul.ztree {margin-top: 10px;border: 1px solid #617775;background: #f0f6e4;width:220px;height:360px;overflow-y:scroll;overflow-x:auto;}
	</style>
	<div id="menuContent" class="menuContent" style="display:none; position: absolute;">
		<ul id="treeDemo" class="ztree" style="margin-top:0;"></ul>
	</div>
<?php //$this->load->view("admin/common/tree_view"); //加载树形目的地   ?>
<script>
/**
 * showDestBaseTree(this) 国内游和出境游的目的地插件
 * showGNDestTree(this) 国内游目的地
 * showCJDestTree(this) 出境游目的地
 * showZBDestTree(this ,startplaceid) 周边游目的地
 * showCGZDestTree(this ,startplaceid) 出境，国内，周边游目的地
 * showDestCfgTree(this) 目的地配置
 * showStartplaceTree(this) 出发城市
 *
 */
var oleft = 0 ; 
var oTop = 0;
var treeInputObj="";
var TreeSetting = {
	view: {
		dblClickExpand: false
	},
	data: {
		simpleData: {
			enable: true
		}
	},
	callback: {
		beforeClick: beforeClickTree,
		onClick: onClickTree
	}
};

//出发城市
function showStartplaceTree(obj) {
	treeInputObj = obj;
	var url = '/common/get_data/getStartplaceData';
	var zNodes = commonTree1(obj ,url);
	
	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword1(obj ,zNodes ,event);
	})
}

/**
 * @param object obj input对象
 * @param string url ajax请求地址
 * @param intval cityid 出发城市ID，若要获取周边游则必须有
 */
function commonTree1(obj ,url ,cityid) {
	var value = $(obj).val();
	if (typeof cityid != 'undefined') {
		var dataArr = {startcity:cityid};
	} else {
		var dataArr = {};
	}
	//请求后台获取数据
	var zNodes = getDataTree(url ,dataArr);
	searchKeyword1(obj ,zNodes);
	return zNodes;
}

/**
 * 初始化数据插件，或者搜索
 * @param object obj input对象
 * @param array zNodes 数据
 * @param object event 
 */
function searchKeyword1(obj ,zNodes ,event) {
	if (typeof event != 'undefined') {
		var code = event.keyCode;
		if (code == 8) {
			$(treeInputObj).attr('data-id' ,'');
			$(treeInputObj).next('input').val('');
		}
	}
	
	var keyword = $(obj).val();
	if (keyword.length == 0) {
		//没有搜索值
		treeInitCommon(obj ,zNodes); // 0 
	} else {
		var dataArr = new Array();
		var searchArr = new Array();
		var idStr = '';
		var pidStr = '';
		//从数据中查询搜索的内容
		$.each(zNodes ,function(k ,v) {
			dataArr[v.id] = v;
			if (v.name.indexOf(jQuery.trim(keyword)) != -1 || v.nickname.indexOf(jQuery.trim(keyword)) != -1) {
				idStr = idStr+v.id+',';
				pidStr = pidStr + v.pId+',';
			}
		})
		
		var pidArr = uniqueArrayTree(pidStr.split(','));
		var str = getParentDataTree(dataArr,pidArr ,idStr);
		//console.log(str);
		//去掉重复值
		var idArr = uniqueArrayTree(str.split(','));
		
		$.each(idArr ,function(k ,v) {
			if (typeof dataArr[v] != 'undefined') {
				var data = dataArr[v];
				data.open = "true";
				searchArr.push(data);
			}
		})
		treeInitCommon(obj ,searchArr); //0
	}
}

/**
 * 递归获取上级
 * @param array dataArr 查询的数据
 * @param array pidArr 关键字查询结果的上级数组
 * @param str idStr 查询结果的ID
 */
function getParentDataTree(dataArr ,pidArr ,idStr) {
	var arr = new Array();
	for(var i in pidArr) {
		if (typeof dataArr[pidArr[i]] != 'undefined'){
			if (dataArr[pidArr[i]]['level'] > 1) {
				arr.push(dataArr[pidArr[i]]['pId']);
			}
			idStr = idStr + pidArr[i]+',';
		}
	}
	if (!$.isEmptyObject(arr)) {
		return getParentDataTree(dataArr ,arr ,idStr);
	}
	return idStr;
}

//去掉数组的重复值
function uniqueArrayTree(dataArr) {
	dataArr.sort();
	//去除重复的数值
	var arr = new Array;
	var tempStr="";
	for(var i in dataArr) {
		if(dataArr[i] != tempStr){
			arr.push(dataArr[i]);
	    	tempStr=dataArr[i];
	    }else{
	    	continue;
	    }
	}
	return arr;
}


//国内游和出境游的目的地插件
function show_expertList(obj) {
	treeInputObj = obj;
	var url = '/common/get_data/get_c_expertList';
	var zNodes = commonTree(obj ,url);
	
	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword(obj ,zNodes ,event);
	})
}


/* 
//目的地配置
function showDestCfgTree(obj) {
	treeInputObj = obj;
	var url = '/common/get_data/getDestCfgData';
	var zNodes = commonTree(obj ,url);

	$(obj).unbind('keyup');
	$(obj).keyup(function(event) {
		searchKeyword(obj ,zNodes ,event);
	})
} */

/**
 * @param object obj input对象
 * @param string url ajax请求地址
 * @param intval cityid 出发城市ID，若要获取周边游则必须有
 */
function commonTree(obj ,url ,cityid) {
	var value = $(obj).val();
	if (typeof cityid != 'undefined') {
		var dataArr = {startcity:cityid};
	} else {
		var dataArr = {};
	}
	
	var zNodes = getDataTree(url ,dataArr);
	searchKeyword(obj ,zNodes);
	return zNodes;
}

/**
 * 初始化数据插件，或者搜索
 * @param object obj input对象
 * @param array zNodes 数据
 * @param object event 
 */
function searchKeyword(obj ,zNodes ,event) {
	if (typeof event != 'undefined') {
		var code = event.keyCode;
		if (code == 8) {
			$(treeInputObj).attr('data-id' ,'');
			$(treeInputObj).next('input').val('');
		}
	}
	
	var keyword = $(obj).val();
	if (keyword.length == 0) {
		//没有搜索值
		treeInitCommon(obj ,zNodes); // 0
	} else {
		var dataArr = new Array();
		var searchArr = new Array();
		var listStr = '';
		//从数据中查询搜索的内容
		$.each(zNodes ,function(k ,v) {
			dataArr[v.id] = v;
			if (v.name.indexOf(jQuery.trim(keyword)) != -1 || v.nickname.indexOf(jQuery.trim(keyword)) != -1) {
				listStr = listStr+v.id+',';
			}
		})
		var listArr = listStr.split(',');
		//去掉重复值
		var idArr = uniqueArrayTree(listArr);
		
		$.each(idArr ,function(k ,v) {
			if (typeof dataArr[v] != 'undefined') {
				var data = dataArr[v];
				data.open = "true";
				searchArr.push(data);
			}
		})
		treeInitCommon(obj ,searchArr); // 0
	}
}


function treeInitCommon(obj ,dataArr) {

	$.fn.zTree.init($("#treeDemo"), TreeSetting, dataArr);
	var cityOffset = $(obj).offset();

	$("#menuContent").css({left:cityOffset.left+oleft + "px", top:cityOffset.top+oTop + $(obj).outerHeight() + "px"}).slideDown("fast");
	$("#menuContent").css("z-index","99999999"); 
	
	$("#treeDemo").css("width",$(obj).width()); //等于input的长
	$("body").bind("mousedown", onBodyDownTree);
}


/**
 * @param string url ajax请求数据地址
 * @param json data 请求时携带的数据
 */
function getDataTree(url ,data) {
	var treeData;
	$.ajax({
		url:url,
		data:data,
		type:'post',
		async:false,
		dataType:'json',
		success:function(result) {
			treeData = result;
		}
	});
	return treeData;
}

//关闭结构树插件
function hideTree() {
	oleft = 0 ; 
	oTop = 0 ;
	$("#menuContent").fadeOut("fast");
	$("body").unbind("mousedown", onBodyDownTree);
}
//鼠标离开结构树区域并点击时隐藏
function onBodyDownTree(event) {
	if (!(event.target.id == "menuBtn" || event.target.id == "menuContent" || $(event.target).parents("#menuContent").length>0)) {
		hideTree();
	}
}

//用于捕获单击节点之前的事件回调函数，并且根据返回值确定是否允许单击操作
function beforeClickTree(treeId, treeNode) {
	var check = (treeNode && !treeNode.isParent);
}

//点击节点时的回调函数
function onClickTree(e, treeId, treeNode) {
	var zTree = $.fn.zTree.getZTreeObj("treeDemo");
	var nodes = zTree.getSelectedNodes();

	$(treeInputObj).val(treeNode.name);
	$(treeInputObj).attr('data-id' ,treeNode.id);
	$(treeInputObj).next('input').val(treeNode.id);
	hideTree();
	//点击后执行的函数
	if (typeof callbackTree == 'function') {
		callbackTree(treeNode.id ,treeNode.name ,treeNode);
	}
}

</script>




