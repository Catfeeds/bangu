
/** 
 * 百度地图api：getCurrentPosition 方法用于返回用户当前位置
 */

var geolocation = new BMap.Geolocation();
var mobileMap={};//经纬度对象

geolocation.getCurrentPosition(function(r) {
  if(this.getStatus() === 0) {
      //console.log(r.point);  // {lat: 22.54605355, lng: 114.02597366}
	  mobileMap.lat=r.point.lat;
	  mobileMap.lng=r.point.lng;
	
	  $.ajax({
		  type:"GET",
		  url:base_url+"common/get_cityname",
		  data:{lat:r.point.lat,lng:r.point.lng},
		  dataType:"json",
		  success:function(data){
		    //没有返回处理，后台存入session
		  },
		  error:function(data){
			  
		  }
		  
	  })
   
  }
  else {
	 tan('定位失败');
  }        

},{enableHighAccuracy: true})


