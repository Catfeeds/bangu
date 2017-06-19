//公共提示框
function tan(_text){
	var toast=document.createElement("div");
	var element=document.getElementsByTagName("body")[0];
		element.appendChild(toast);		
	var toastTimeOut = null;	
	var h = 0;
	var w = 0;
	toast.className='toast';
	toast.innerHTML = _text;	
	h = toast.offsetHeight;
	w = toast.offsetWidth;
	toast.style.marginLeft = "-" + w/2 + "px";
	toast.style.marginTop = "-" + h/2 + "px";
	toast.style.left = "50%";
	toast.style.top = "50%";

	toastTimeOut = setTimeout(function(){
		toast.parentNode.removeChild(toast);
	},2000);

	//点击toast，隐藏toast
	toast.addEventListener("click",function(){
		toast.parentNode.removeChild(toast);
		clearTimeout(toastTimeOut);
	},false);
}
//返回顶部
function backtop(){
	document.body.scrollTop = 0;
}
$(window).scroll(function(){
	var w_h = $(window).scrollTop();
	if(w_h >= 720 ){
		$('.common_top').show();
	}else{
		$('.common_top').hide();
	}
	$('.common_top').on('click',function(){
		backtop();
	});
});

/**
 * 保留n为小数点  四舍五入
 * numberRound： 目标值
 * roundDigit：保留的小数点位数
 * */
function roundFun(numberRound,roundDigit)   //四舍五入，保留位数为roundDigit     
{   
	if   (numberRound>=0)   
	{   
		var   tempNumber   =   parseInt((numberRound   *   Math.pow(10,roundDigit)+0.5))/Math.pow(10,roundDigit);   
		return   tempNumber;   
	}   
	else     
	{   
		numberRound1=-numberRound   
		var   tempNumber   =   parseInt((numberRound1   *   Math.pow(10,roundDigit)+0.5))/Math.pow(10,roundDigit);   
		return   -tempNumber;   
	}   
}
/**
 ** 加法函数，用来得到精确的加法结果
 ** 说明：javascript的加法结果会有误差，在两个浮点数相加的时候会比较明显。这个函数返回较为精确的加法结果。
 ** 调用：accAdd(arg1,arg2)
 ** 返回值：arg1加上arg2的精确结果
 **/
function accAdd(arg1, arg2) {
    var r1, r2, m, c;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    c = Math.abs(r1 - r2);
    m = Math.pow(10, Math.max(r1, r2));
    if (c > 0) {
        var cm = Math.pow(10, c);
        if (r1 > r2) {
            arg1 = Number(arg1.toString().replace(".", ""));
            arg2 = Number(arg2.toString().replace(".", "")) * cm;
        } else {
            arg1 = Number(arg1.toString().replace(".", "")) * cm;
            arg2 = Number(arg2.toString().replace(".", ""));
        }
    } else {
        arg1 = Number(arg1.toString().replace(".", ""));
        arg2 = Number(arg2.toString().replace(".", ""));
    }
    return (arg1 + arg2) / m;
}
/**
 ** 减法函数，用来得到精确的减法结果
 ** 说明：javascript的减法结果会有误差，在两个浮点数相减的时候会比较明显。这个函数返回较为精确的减法结果。
 ** 调用：accSub(arg1,arg2)
 ** 返回值：arg1加上arg2的精确结果
 **/
function accSub(arg1, arg2) {
    var r1, r2, m, n;
    try {
        r1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
        r2 = 0;
    }
    m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度
    n = (r1 >= r2) ? r1 : r2;
    return ((arg1 * m - arg2 * m) / m).toFixed(n);
}

/**
 ** 乘法函数，用来得到精确的乘法结果
 ** 说明：javascript的乘法结果会有误差，在两个浮点数相乘的时候会比较明显。这个函数返回较为精确的乘法结果。
 ** 调用：accMul(arg1,arg2)
 ** 返回值：arg1乘以 arg2的精确结果
 **/
function accMul(arg1, arg2) {
    var m = 0, s1 = arg1.toString(), s2 = arg2.toString();
    try {
        m += s1.split(".")[1].length;
    }
    catch (e) {
    }
    try {
        m += s2.split(".")[1].length;
    }
    catch (e) {
    }
    return Number(s1.replace(".", "")) * Number(s2.replace(".", "")) / Math.pow(10, m);
}

/** 
 ** 除法函数，用来得到精确的除法结果
 ** 说明：javascript的除法结果会有误差，在两个浮点数相除的时候会比较明显。这个函数返回较为精确的除法结果。
 ** 调用：accDiv(arg1,arg2)
 ** 返回值：arg1除以arg2的精确结果
 **/
function accDiv(arg1, arg2) {
    var t1 = 0, t2 = 0, r1, r2;
    try {
        t1 = arg1.toString().split(".")[1].length;
    }
    catch (e) {
    }
    try {
        t2 = arg2.toString().split(".")[1].length;
    }
    catch (e) {
    }
    with (Math) {
        r1 = Number(arg1.toString().replace(".", ""));
        r2 = Number(arg2.toString().replace(".", ""));
        return (r1 / r2) * pow(10, t2 - t1);
    }
}
/** 
 ** 截取字符串函数
 ** 说明：中文当作1个字符，英文当作1个字符
 ** 调用：my_substr(str,len)
 ** 返回值：str需要截取的字符串  len截取长度
 **/
function my_substr(str, len) { 
    var newLength = 0; 
    var newStr = ""; 
    var chineseRegex = /[^\x00-\xff]/g; 
    var singleChar = ""; 
    var strLength = str.replace(chineseRegex,"**").length; 
    for(var i = 0;i < strLength;i++) { 
            singleChar = str.charAt(i).toString(); 
            if(singleChar.match(chineseRegex) != null) { 
                    newLength++; 
            }else { 
                    newLength++; 
            } 
            if(newLength > len) { 
                    break; 
            } 
                    newStr += singleChar; 
    } 
    if(strLength > len) { 
            newStr += ""; 
    } 
    return newStr; 
}  

/**
 * 加减乘除
 * */
Number.prototype.add = function (arg1,arg2) {
  return accAdd(arg1,arg2);
};
Number.prototype.sub = function (arg1,arg2) {
 return accMul(arg1,arg2);
};
Number.prototype.mul = function (arg1,arg2) {
    return accMul(arg1,arg2);
};
Number.prototype.div = function (arg1,arg2) {
    return accDiv(arg1,arg2);
};

//四舍五入
Number.prototype.decimal = function (value,length) {
    return roundFun(value,length);
};
//截取字符串
Number.prototype.my_substr = function (str,length) {
    return my_substr(str,length);
};
