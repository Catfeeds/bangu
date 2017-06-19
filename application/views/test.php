<html>
<head>
<title>Test</title>
</head>
<body onload="init()">
<div id="map" style="width: 100%; height: 100%;"></div>
<script src="<?php echo base_url('static'); ?>/js/jquery-1.11.1.min.js" type="text/javascript"></script>
<script type="text/javascript">
var x=document.getElementById("map");
var map = null;
function init() {
	 if (navigator.geolocation) {
		//获取当前地理位置
		navigator.geolocation.getCurrentPosition(function (position) {
			var coords = position.coords;
			var param = jQuery.param({"lat":coords.latitude,"lon":coords.longitude});
			var url = "<?php echo site_url('lbs/test/get')?>";
			jQuery.ajax({ type : "POST", url : url, data : param,success :function(data) {
				//指定一个google地图上的坐标点，同时指定该坐标点的横坐标和纵坐标
				var latlng = new google.maps.LatLng(coords.latitude, coords.longitude);
	            var myOptions = {
					zoom: 14,//设定放大倍数
					center: latlng,//将地图中心点设定为指定的坐标点
					mapTypeControl: true,
				    mapTypeControlOptions: {
				        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				        position: google.maps.ControlPosition.TOP_CENTER
				    },
				    zoomControl: true,
				    zoomControlOptions: {
				        position: google.maps.ControlPosition.LEFT_CENTER
				    },
				    scaleControl: true,
				    streetViewControl: true,
				    streetViewControlOptions: {
				        position: google.maps.ControlPosition.LEFT_TOP
				    }
// 					zoomControl: true,
// 				    scaleControl: true,
// 					mapTypeControl: true,
// 					mapTypeId: google.maps.MapTypeId.ROADMAP //指定地图类型
				};
				//创建地图，并在页面map中显示
				map = new google.maps.Map(document.getElementById("map"), myOptions);
				//在地图上创建标记
				var marker = new google.maps.Marker({
					position: latlng,//将前面设定的坐标标注出来
					map: map //将该标注设置在刚才创建的map中
				});
				//标注提示窗口
				var infoWindow = new google.maps.InfoWindow({content: "我"});
				//打开提示窗口
				infoWindow.open(map, marker);

				drop(data);


			}
		});
	},function (error) {
			//处理错误
			switch (error.code) {
			    case 1:
			        alert("位置服务被拒绝。");
			        break;
			    case 2:
			        alert("暂时获取不到位置信息。");
			        break;
			    case 3:
			        alert("获取信息超时。");
			        break;
			    default:
			        alert("未知错误。");
			        break;
			}
	});
	} else {
		alert("你的浏览器不支持HTML5来获取地理位置信息。");
	}
}

var markers = [];
function drop(data) {
  clearMarkers();
  var list_obj = jQuery.parseJSON(data);
  for (var i = 0; i < list_obj.length; i++) {
    addMarkerWithTimeout(list_obj[i], i * 200);
  }

//   if(''!=data){
// 		var list_obj = jQuery.parseJSON(data);
// 		for(var i=0;i<list_obj.length;i++){

// 			//在地图上创建标记
// 			marker = new google.maps.Marker({
// 				position: latlng,//将前面设定的坐标标注出来
// 				map: map //将该标注设置在刚才创建的map中
// 			});
// 		//标注提示窗口
// 		infoWindow = new google.maps.InfoWindow({
// 		    content: list_obj[i].name  //提示窗体内的提示信息
// 		});
// 		//打开提示窗口
// 		infoWindow.open(map, marker);
// 						}
// 	}
}
function addMarkerWithTimeout(position, timeout) {

// 	  window.setTimeout(function() {
		latlng = new google.maps.LatLng(position.lat, position.lon);
		var marker = new google.maps.Marker({
		      position: latlng,
		      map: map,
		      animation: google.maps.Animation.DROP
		});
	    markers.push(marker);
	  	//标注提示窗口
		var infoWindow = new google.maps.InfoWindow({content: position.name});
		//打开提示窗口
		infoWindow.open(map, marker);
// 	  }, timeout);
	}
function clearMarkers() {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
  markers = [];
}
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
</body>
</html>