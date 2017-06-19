//详情页的table生成
function createDetailTab(title ,column ,boxObj) {
	var html = '<div class="content_part">';
	html += '<div class="small_title_txt clear"><span class="txt_info fl">'+title+'</span></div>';
	html += '<table class="order_info_table table_td_border" border="1" width="100%" cellspacing="0">';
	html += '</table>';
	html += '</div>';
	boxObj.append(html);

	var num = 0;
	$.each(column ,function(k,v) {
		var tableObj = boxObj.find('table').last();
		var content = typeof v.content == 'object' ? '' :v.content;
		if (v.type == 'all') {
			if (num != 0) {
				tableObj.find('tr').last().append('<td class="order_info_title"></td><td colspan="3"></td>');
				num = 0;
			}
			tableObj.append('<tr height="40"></tr>');
			tableObj.find('tr').last().html('<td class="order_info_title">'+v.title+':</td><td colspan="3">'+content+'</td>');
		} else {
			if (num == 0) {
				tableObj.append('<tr height="40"></tr>');
			}
			tableObj.find('tr').last().append('<td class="order_info_title">'+v.title+':</td><td>'+content+'</td>');
			if (num == 1) {
				num = 0;
			} else {
				num ++;
			}
		}
	})
}
//详情页的按钮生成
function createDetailBut(butList ,boxObj) {
	boxObj.append('<div class="but-list"></div>');
	$.each(butList ,function(k ,v) {
		boxObj.find('.but-list').append('<button style="position: static;">'+v+'</button>');
		boxObj.find('.but-list').find('button').last().addClass(k);
	})
}



/**
 * @method ajax上传图片文件(文件上传地址统一使用一个)
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function uploadImgFile(obj)
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
					$(obj).parent().append("<img src='"+data.imgurl+"' width='80' />");
					$(obj).parent().parent().find(".olddiv").hide();
				}
				else
					alert(data.msg);
			},
			error:function(data){
				alert('请求异常');
			}
		});
}
/**
 * @method ajax上传文件
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function uploadFile(obj)
{
	var inputname = $(obj).attr("name");
	var hiddenObj = $(obj).nextAll("input[type='hidden']");

	var formData = new FormData($("form" )[0]);
	formData.append("inputname", inputname);
	$.ajax({
			type : "post",
			url : "/admin/t33/home/upload_file",
			data : formData,
			dataType:"json",
			async: false,
      		cache: false,
      		contentType: false,
      		processData: false,
			success : function(data) {

				if(data.code=="2000")
				{
					var value=hiddenObj.val();
					hiddenObj.val(data.imgurl+","+value);

					var filename=hiddenObj.attr("data-name");
					hiddenObj.attr("data-name",data.filename+","+filename);

					$(obj).parent().append("<font>"+data.filename+"上传成功</font>");
					$(obj).parent().parent().find(".olddiv").hide();
				}
				else
					alert(data.msg);
			},
			error:function(data){
				alert('请求异常');
			}
		});
}
/**
 * @method ajax上传图片文件(文件上传地址统一使用一个)  ,并打开新的窗口进行裁剪
 * @param file_id file控件的ID同时也是file控件的name值
 * @param name 上传返回的图片路径写入的input的name值
 * @param prefix 图片保存的前缀
 */
function uploadImgFile_cut(obj)
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
					//alert(window.name) //iframe 的id
					//弹窗
					window.top.openWin({
						  type: 2,
						  area: ['980px', '600px'],
						  title :'裁剪头像',
						  fix: true, //不固定
						  maxmin: true,
						  content: "/admin/t33/expert/cut?url="+data.imgurl+"&iframeid="+window.name
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
//失败弹窗，自动消失
function tan(msg)
{
	layer.msg(msg, {icon: 2});
}
//成功弹窗，自动消失
function tan2(msg)
{
	layer.msg(msg, {icon: 1});
}

//失败弹窗，不自动消失，需点击确定按钮关闭
function tan3(msg)
{
	layer.alert(msg, {icon: 1,title:'提示'});
}
//成功弹窗，自动消失，需点击确定按钮关闭
function tan4(msg)
{
	layer.alert(msg, {icon: 2,title:'提示'});
}
//弹出消息提示，没有关闭按钮，不能关闭遮罩层
function tan_noclose(msg)
{
	layer.alert(msg, {icon: -1,closeBtn:0,btn:[],title:'提示',shadeClose: false});
}
//弹出消息提示，有关闭按钮
function tan_msg(msg)
{
	layer.alert(msg, {icon: -1,btn:[],title:'提示',shadeClose: false});
}
//弹出消息提示，有关闭按钮,有确定按钮，确定按钮点击后刷新页面
function tan_alert(msg)
{
	layer.alert(msg, {icon: -1,btn:['确定'],title:'提示',shadeClose: false,yes:function(){ window.location.reload(); }});
}
//弹出消息提示，有关闭按钮,有确定按钮，确定按钮点击后刷新页面
function tan_alert_noreload(msg)
{
	layer.alert(msg, {icon: -1,btn:['确定'],title:'提示',shadeClose: false});
}


//关闭弹层（不是iframe）
function t33_close()
{
	layer.closeAll(); //关闭层
}
//关闭弹层（是iframe）
var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
function t33_close_iframe()
{
	 parent.$("#main")[0].contentWindow.window.location.reload();
	 parent.layer.close(index);
}
//关闭弹层（是iframe）,不刷新
function t33_close_iframe_noreload()
{
	 parent.layer.close(index);
}
//0.5秒之后刷新页面
function t33_refresh()
{
	setTimeout(function(){window.location.reload()},500);
}


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
//js 强制保留2位小数点
function toDecimal2(x) { 
      var f = parseFloat(x); 
      if (isNaN(f)) { 
        return false; 
      } 
      var f = Math.round(x*100)/100; 
      var s = f.toString(); 
      var rs = s.indexOf('.'); 
      if (rs < 0) { 
        rs = s.length; 
        s += '.'; 
      } 
      while (s.length <= rs + 2) { 
        s += '0'; 
      } 
      return s; 
    } 
/*========================   控制按钮的点击频率 ====================*/

//存储变量信息
var VAR ={
    repeatTemp:[]
}
//获取毫秒级时间戳
function microtime(){

    return new Date().getTime();
}

var COM = {
        repeat:function(s,t,msg){//限制执行频率，默认为60秒 允许执行时返回false
        	if (typeof(msg) == "undefined") msg="点击频率过快，休息一下";
            t = t ? t * 1000 : 4000;//毫秒
            var time = microtime();
                if(!VAR.repeatTemp[s]){
                    VAR.repeatTemp[s] = time;

                    return false;//允许
                }else{
                    var ts = t - (time - VAR.repeatTemp[s]);
                    ts = parseInt(ts/1000);
                if(ts > 0){
                    alert(msg);
                    return true;//禁止执行
                }else{

                    VAR.repeatTemp[s] = time;//更新时间
                    return false;//允许
                }
            }
        }
    }

/*
 * 发送ajax： 
 * @param: config{}对象
 * 					url: 目标url
 *					data: 传递的数据
 * 					type:  POST 或 GET。默认是POST
 *                  time:  时间频率限制，单位为秒，即在指定时间内重复提交请求，则弹出限制提示
 *                  msg:   重复提交时提示信息
 *                 
 *                  
 *          如 config={url:'',data:{},type:'',time:'',msg:''}
 * */
function sendAjax(config){  //发送ajax请求，无加载层
    
	var url=config.url;
	var data=config.data;
	var alert=config.alert;
	var type=config.type;
	var time=config.time;
	var tipMsg=config.msg;
	var timeout=config.timeout;
	if(!config.hasOwnProperty('url')) tan('参数url不能缺省');
	if(!config.hasOwnProperty('data')) data={};
    //if(!config.hasOwnProperty('alert')) alert=true;
    if(!config.hasOwnProperty('type'))  type='POST';
    if(!config.hasOwnProperty('time'))  time='3';
    if(!config.hasOwnProperty('msg'))  tipMsg='请求频率过快，休息一下';
    //if(!config.hasOwnProperty('timeout'))  timeout=60;
   
    var flag = COM.repeat('btn',time,tipMsg);//频率限制
	if(!flag)
	{
	    var ret; //返回值
	
	    $.ajax({
			url:url,
			type:type,
			data:data,
			//timeout:timeout,  //超时只有在 async=true时生效
			async:false,  //false浏览器锁死
			dataType:"json",
			success:function(data){
				
				ret=data;
				setTimeout(function(){layer.closeAll('loading');}, 200);  //0.2秒后消失
			},
			complete : function(XMLHttpRequest,status){
			　　　　if(status=='timeout'){   //超时,status还有success,error等值的情况
			 　　　　　 //ajaxTimeoutTest.abort();
			　　　　　  tan("请求超时");
			　　　　}
			},
			error:function(data){
				ret=data;
				tan('请求异常');
			}
         
	});
	    
	return ret;
	   
	}
}


Date.prototype.Format = function (fmt) { //author: meizz
    var o = {
        "M+": this.getMonth() + 1, //月份
        "d+": this.getDate(), //日
        "h+": this.getHours(), //小时
        "m+": this.getMinutes(), //分
        "s+": this.getSeconds(), //秒
        "q+": Math.floor((this.getMonth() + 3) / 3), //季度
        "S": this.getMilliseconds() //毫秒
    };
    if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
    if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}
