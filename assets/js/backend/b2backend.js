
//获取url里的参数
function GetRequest() {
  var url = location.search;
  //获取url中"?"符后的字串  url='?id=3&name=zhangsan'   
   var theRequest = new Object(); 
if (url.indexOf("?") != -1) {   
  var str = url.substr(1); 
   strs = str.split("&");  
    for(var i = 0; i < strs.length; i ++) {   
    theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);   
      } 
    }    
  return theRequest;
}

if(GetRequest().i==1){
$("#bodyMsg").html("");
	 $.get('product.html',function(html){                
                var result= $(html);       
                $("#bodyMsg").html(result);            
              },'html');

}else if(GetRequest().i==2){




}else if(GetRequest().i==3){

$("#bodyMsg").html("");

 $.get('/index.php/b2/expert/customer',function(html){  
	 
                var result= $(html);  
                $("#bodyMsg").html(result);            
              },'html');
	
}else if(GetRequest().i==4){
$("#bodyMsg").html("");
$.get('/index.php/b2/expert/account',function(html){                
         var result= $(html);       
         $("#bodyMsg").html(result);            
	},'html');

}else if(GetRequest().i==5){

$("#bodyMsg").html("");
$.get('/index.php/b2/expert/update',function(html){                
         var result= $(html);       
         $("#bodyMsg").html(result);            
	},'html');


}else if(GetRequest().i==6){

$("#bodyMsg").html("");
$.get('/index.php/b2/complain/index',function(html){                
         var result= $(html);       
         $("#bodyMsg").html(result);            
	},'html');


}else if(GetRequest().i==7){

$("#bodyMsg").html("");
$.get('template.html',function(html){                
         var result= $(html);       
         $("#bodyMsg").html(result);            
	},'html');


}else if(GetRequest().i==8){

	$("#bodyMsg").html("");
	$.get('/index.php/b2/comment/index',function(html){                
         var result= $(html);       
         $("#bodyMsg").html(result);            
	},'html');

}else if(GetRequest().i==9){

$("#bodyMsg").html("");
	$.get('/index.php/b2/question/index',function(html){                
         var result= $(html);       
         $("#bodyMsg").html(result);            
	},'html');

}