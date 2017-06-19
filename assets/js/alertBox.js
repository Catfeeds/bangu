// JavaScript Document
var i = 0;
function alertBox(_str){
	//alert(_str);
	var tk = document.createElement("div");
	
	document.body.appendChild(tk);	
	tk.setAttribute("id","msginfo"+i);
	tk.setAttribute("class","tan");	
	h = tk.offsetHeight;
	w = 300;//tk.offsetWidth;
	m_top = 100;
	tk.style.width = w + "px";
	tk.style.marginLeft = "-" + w/2 + "px";
	tk.style.marginTop = 20+ m_top*i +"px";
	tk.style.left = "50%";
	tk.style.top = "0";
	
	i++;
	
	var id = tk.getAttribute("id");

	//提示框标题
	if(title==null){
		var title=document.createElement("h4");
	}
	title.innerHTML = "帮游网提示您：";
	document.getElementById(id).appendChild(title);
	
	//提示框内容
	var txt=document.createElement("p");
	txt.innerHTML = _str;
	document.getElementById(id).appendChild(txt);
	
	var tkTimeOut = null;
	//提示框定时消失
	tkTimeOut = setTimeout(function(){
		tk.parentNode.removeChild(tk);
		if(i>5){
			i=0;	
		}
	},2000);	
	
	tk.onclick = function(){
		tk.parentNode.removeChild(tk);
		if(i>5){
			i=0;	
		}
		clearTimeout(tkTimeOut);
	}
	//点击提示框 隐藏
	/*tk.addEventListener("click",function(){
		tk.parentNode.removeChild(tk);
		if(i>6){
			i=0;	
		}
		clearTimeout(toastTimeOut);
	},false);*/
	
}

