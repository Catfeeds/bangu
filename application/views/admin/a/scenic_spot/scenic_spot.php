<link href="<?php echo base_url() ;?>assets/css/xiuxiu.css" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.css'); ?>" rel="stylesheet" />
<style type="text/css">
.page-content{ min-width: auto !important; }
</style>
<div class="page-content">
	<ul class="breadcrumb">
		<li>
			<i class="fa fa-home"></i> 
			<a href="<?php echo site_url('admin/a/')?>"> 首页 </a>
		</li>
		<li class="active"><span>/</span>景点管理</li>
	</ul>
	<div class="page-body">
		<ul class="nav-tabs">
			<li class="active" data-val="0">待审核</li>
			<li class="tab-red" data-val="1">已通过 </li>
			<li class="tab-red" data-val="-1">已拒绝</li>
			<li class="tab-red" data-val="2">已禁用</li>
		</ul>
		<div class="tab-content">
			<a id="add-button" href="javascript:void(0);" class="but-default" >添加 </a>
			<form action="#" id='search-condition' class="search-condition" method="post">
				<ul>
					<li class="search-list">
						<span class="search-title">景点名称：</span>
						<span ><input type="text" class="search-input" name="name" placeholder="景点名称"></span>
					</li>
					<li class="search-list search-admin">
						<span class="search-title">操作人：</span>
						<span ><input type="text" class="search-input" name="username" placeholder="启用人"></span>
					</li>
					<li class="search-list search-time">
						<span class="search-title">启用时间：</span>
						<span >
							<input type="text" class="search-input" style="width:110px;" id="starttime" name="starttime" placeholder="开始时间">
							<input type="text" class="search-input" style="width:110px;" id="endtime" name="endtime" placeholder="结束时间">
						</span>
					</li>
					<li class="search-list search-ishot">
						<span class="search-title">是否热门：</span>
						<span>
							<select name="ishot">
								<option value="0">请选择</option>
								<option value="1">是</option>
								<option value="2">否</option>
							</select>
						</span>
					</li>
					<li class="search-list">
						<span class="search-title">地区：</span>
						<span  class="belong-search" id="belong-search">
						</span>
					</li>
					<li class="search-list">
						<input type="hidden" name="status" value="0">
						<input type="submit" value="搜索" class="search-button" />
					</li>
				</ul>
			</form>
			<div id="dataTable"></div>
		</div>
	</div>
</div>

<div class="detail-box add-scenic" style="display:block;">
	<div class="db-body" style="width:900px;position: absolute;left: -1000px;">
		<div class="db-title">
			<h4>景点管理</h4>
			<div class="db-close close-scenic">x</div>
		</div>
		<form method="post" action="#" id="form-data"  >
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-data-row">
					<div class="db-row-title">景点名称：</div>
					<div class="db-row-content"><input type="text" name="name" maxlength="10" placeholder="10字以内" /></div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">排序：</div>
					<div class="db-row-content"><input type="text" name="displayorder" maxlength="6" /></div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">是否热门：</div>
					<div class="db-row-content">
						<ul>
							<li><label><input type="radio" name="ishot" value="0" checked="checked" />否</label></li>
							<li><label><input type="radio" name="ishot" value="1" />是</label></li>
						</ul>
					</div>
				</li>
				<li class="db-data-row">
					<div class="db-row-title">是否启用：</div>
					<div class="db-row-content">
						<ul>
							<li><label><input type="radio" name="isopen" value="1" checked="checked" />是</label></li>
							<li><label><input type="radio" name="isopen" value="2"  />否</label></li>
						</ul>
					</div>
				</li>
				<li class="db-data-row" style="width:100%;">
					<div class="db-row-title" style="width:14.8%;">所在地：</div>
					<div class="db-row-content belong-sel" id="add-belong">
					</div>
				</li>
				<li class="db-row">
					<div class="db-row-title">景点特色：</div>
					<div class="db-row-content"><textarea name="description" maxlength="250"></textarea></div>
				</li>
				<li  class="db-row">
					<div class="db-row-title">图片：</div>
					<div class="db-row-content" >
						<span class="form-but" id="upload-img">上传图片</span>
						<span><i style="color: red;margin-right: 2px;">*</i>建议上传图片剪切尺寸大小尽量保持一致</span>
						<ul class="pic-list" id="pic-list">
<!-- 							<li class="active"> -->
<!-- 								<span class="pic-del">x</span> -->
<!-- 								<img src="/file/upload/20160427/146172324377363.jpg"> -->
<!-- 								<span class="mainpic">设为主图<span class="mainpic-box"></span></span> -->
<!-- 							</li> -->
						</ul>
						<input type="hidden" name="piclist">
					</div>
				</li>
				<li class="db-row google-box" >
					<div class="db-row-title">定位详细地址：</div>
					<span class="full-screen get-into">全屏</span>
					<span class="full-screen sign-out" style="display: none;">确认并退出</span>
					<div id="google-map">
						<input type="text" id="address" name="address" style="width: 88%;" placeholder="请输入地址定位">
						<span id="location">定位</span>
						<ul id="address-list">
							<li data-key="1">深圳市世界之窗</li>
							<li data-key="1">深圳市欢乐谷</li>
							<li data-key="1">中国广东省深圳市世界之窗</li>
							<li data-key="1">深圳市世界之窗深圳市世界之窗深圳市世界之窗</li>
						</ul>
					</div>
					<div class="db-row-content" id="map" style="width:85%;height:400px;"></div>
				</li>
			</ul>
			<div class="db-buttons">
				<input type="hidden" name="lat" value=""/>
				<input type="hidden" name="index" value=""/>
				<input type="hidden" name="lng" value=""/>
				<input type="hidden" name="geohash" value=""/>
				<input type="hidden" name="id" value=""/>
				<div class="close-scenic">关闭</div>
				<div id="submit-but">确定</div>
			</div>
		</div>
		</form>
	</div>
</div>

<div class="detail-box scenic-see">
	<div class="db-body">
		<div class="db-title">
			<h4>景点信息</h4>
			<div class="db-close close-detail">x</div>
		</div>
		<div class="db-content">
			<ul class="db-row-body">
				<li class="db-row">
					<div class="db-row-title">景点名称：</div>
					<div class="db-row-content scenic-name">jiakairong</div>
				</li>
				<li class="db-row">
					<div class="db-row-title">所在地：</div>
					<div class="db-row-content address"></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">封面图：</div>
					<div class="db-row-content scenic-pic"></div>
				</li>
				<li class="db-row">
					<div class="db-row-title">景点插图：</div>
					<div class="db-row-content scenic-pic-list"></div>
				</li>
				<li class="db-row google-box">
					<div class="db-row-title">地图定位：</div>
					<div class="db-row-content" id="map-edit" style="height:400px;"></div>
				</li>
			</ul>
			<div class="db-buttons">
				<input type="hidden" name="scenic_id">
				<div class="close-detail">关闭</div>
				<div class="adopt-scenic">确定</div>
				<div class="refuse-scenic">拒绝</div>
			</div>
		</div>
	</div>
</div>
<!-- <div class="form-box fb-body scenic-pic"> -->
<!--	<div class="fb-content" style="width:690px;">-->
<!-- 		<div class="box-title"> -->
<!-- 			<h4>景点图片管理</h4> -->
<!-- 			<span class="fb-close">x</span> -->
<!-- 		</div> -->
<!-- 		<div class="fb-form"> -->
<!-- 			<form method="post" action="#" id="scenic-pic-form" class="form-horizontal" > -->
<!-- 				<div class="form-group"> -->
<!--					<div class="fg-title" style="width:8%;">图片：<i>*</i></div>
<!--					<div class="fg-input" style="width:90%;">
<!-- 						<span class="form-but" id="upload-img">上传图片</span> -->
<!--						<span><i style="color: red;margin-right: 2px;">*</i>建议上传图片剪切尺寸大小尽量保持一致</span>
<!-- 						<ul class="pic-list" id="pic-list"> -->
<!-- <!-- 							<li class="active"> -->
<!-- <!-- 								<span class="pic-del">x</span> -->
<!-- <!-- 								<img src="/file/upload/20160427/146172324377363.jpg"> -->
<!-- <!-- 								<span class="mainpic">设为主图<span class="mainpic-box"></span></span> --> 
<!-- <!-- 							</li> -->
<!-- 						</ul> -->
<!-- 						<input type="hidden" name="piclist"> -->
<!-- 					</div> -->
<!-- 				</div> -->
<!-- 				<div class="form-group"> -->
<!-- 					<input type="hidden" name="picid" value=""/> -->
<!-- 					<input type="hidden" name="index" value=""/> -->
<!-- 					<input type="button" class="fg-but fb-close" value="取消" /> -->
<!-- 					<input type="submit" class="fg-but" value="确定" /> -->
<!-- 				</div> -->
<!-- 				<div class="clear"></div> -->
<!-- 			</form> -->
<!-- 		</div> -->
<!-- 	</div> -->
<!-- </div> -->
<div  style="width:700px;height:500px;"></div>
<div id="xiuxiu_box" class="xiuxiu_box"></div>
<div class="avatar_box"></div>
<script src="<?php echo base_url('assets/js/jquery.pageTable.js') ;?>"></script>
<script src="<?php echo base_url("assets/js/jquery.selectLinkage.js") ;?>"></script>
<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script src="/assets/js/jquery.extend.js"></script>
<script src="http://maps.google.cn/maps/api/js?key=AIzaSyBSKn-aQjNNb5S2sdsirPTevHU325xBoVI&callback=initMap" async defer></script>
<script src="/assets/js/jquery-select-search.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/datetimepicker/jquery.datetimepicker.js'); ?>"></script>
<script>
$('.adopt-scenic').click(function(){
	var id = $('input[name=scenic_id]').val();
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/through',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data) {
			if (data.code == '2000') {
				$("#dataTable").pageTable({
					columns:columns4,
					url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.scenic-see').hide();
			} else {
				alert(data.msg);
			}
		}
	});
})
$('.refuse-scenic').click(function(){
	var id = $('input[name=scenic_id]').val();
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/refuse',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data) {
			if (data.code == '2000') {
				$("#dataTable").pageTable({
					columns:columns4,
					url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.scenic-see').hide();
			} else {
				alert(data.msg);
			}
		}
	});
})
function seeDetail(id ,status) {
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/getScenicDetail',
		data:{id:id},
		type:'post',
		dataType:'json',
		success:function (data) {
			if ($.isEmptyObject(data)) {
				alert('数据错误');
			} else {
				var scenicArr = data.detail;
				$('.scenic-name').html(scenicArr.name);
				$('.address').html(scenicArr.country +'&nbsp;&nbsp;'+scenicArr.province+'&nbsp;&nbsp;'+scenicArr.city);
				$('.scenic-pic').html('<a href="'+scenicArr.rawPic+'" target="_blank"><img src="'+scenicArr.rawPic+'"></a>');
				$('input[name=scenic_id]').val(scenicArr.id);
				var listObj = $('.scenic-pic-list');
				listObj.empty();
				$.each(data.pic ,function(k ,v){
					listObj.append('<a href="'+scenicArr.rawPic+'" target="_blank"><img src="'+v.pic+'"></a>');
				})
				$('.scenic-see').show();
				if (status == 1) {
					$('.adopt-scenic').show();
					$('.refuse-scenic').hide();
				} else if (status == 2) {
					$('.adopt-scenic').hide();
					$('.refuse-scenic').show();
				}
				latLng = {lat: scenicArr.latitude*1, lng: scenicArr.longitude*1};
				initMapDetail();
			}
		}
	});
}
$('.close-detail').click(function(){
	$('.scenic-see').hide();
})

function initMapDetail() {
	var map = new google.maps.Map(document.getElementById('map-edit'), {
		zoom: 14,
		center:latLng ,
		zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		rotateControl: false
	});
	var marker = new google.maps.Marker({
	    position: latLng,
	    map: map,
	  });
//      geocoder = new google.maps.Geocoder();
}
//http://maps.google.cn/maps/api/js?key=AIzaSyBSKn-aQjNNb5S2sdsirPTevHU325xBoVI&callback=initMap
// $.ajax({
// 	url:"/admin/a/scenic/scenic_area/getAllScenicArea",
// 	dataType:'json',
// 	type:'post',
// 	success:function(data) {
// 		if (!$.isEmptyObject(data)) {
// 			$('#belong-search').selectSearch({
// 				jsonData:data,
// 				names:['country','province','city'],
// 				hiddenVals:['country_id' ,'province_id' ,'city_id']
// 			});
// 			$('#add-belong').selectSearch({
// 				jsonData:data,
// 				names:['country','province','city'],
// 				hiddenVals:['country_id' ,'province_id' ,'city_id'],
// 				width:'125px'
// 			});
// 		}
// 	}
// });
$.ajax({
	url:'/common/selectData/getDestAll',
	dataType:'json',
	type:'post',
	data:{level:3},
	success:function(data){
// 		$('#belong-search').selectLinkage({
// 			jsonData:data,
// 			width:'110px',
// 			names:['country_id','province_id','city_id']
// 		});
// 		$('#add-belong').selectLinkage({
// 			jsonData:data,
// 			width:'110px',
// 			names:['country_id','province_id','city_id']
// 		});
		$('#belong-search').selectSearch({
			jsonData:data,
			names:['country','province','city'],
			hiddenVals:['country_id' ,'province_id' ,'city_id']
		});
		$('#add-belong').selectSearch({
			jsonData:data,
			names:['country','province','city'],
			hiddenVals:['country_id' ,'province_id' ,'city_id'],
			width:'125px'
		});
	}
});


$('.google-box').find('.get-into').click(function(){
	var lat = $('input[name=lat]').val();
	var lng = $('input[name=lng]').val();
	if (lat.length == 0 || lng.length == 0) {
		myLatLng = {lat: 22.543096, lng: 114.05786499999999};
	} else {
		myLatLng = {lat: lat*1, lng: lng*1};
	}
	var width = $(window).width();
	var height = $(window).height();
	$('#map').css({
			'width':width-160+'px',
			'left':'160px',
			'top':'0px',
			'height':height-82+'px'
		});
	$('.full-screen').css({
			'position':'fixed',
			'left':'180px'
		})
	$('#google-map').css({
			'position':'fixed',
		})
	$(this).hide();
	$('.google-box').find('.sign-out').show();
	initMap();
	$('#map').css('position','fixed');
})
$('.google-box').find('.sign-out').click(function(){
	var lat = $('input[name=lat]').val();
	var lng = $('input[name=lng]').val();
	if (lat.length == 0 || lng.length == 0) {
		myLatLng = {lat: 22.543096, lng: 114.05786499999999};
	} else {
		myLatLng = {lat: lat*1, lng: lng*1};
	}
	$('#map').css({
		'width':'85%',
		'left':'0px',
		'top':'0px',
		'height':'400px'
	});
	$('.full-screen').css({
			'position':'absolute',
			'left':'152px'
		})
	$('#google-map').css({
			'position':'absolute',
	})
	$(this).hide();
	$('.google-box').find('.get-into').show();
	initMap();
})

var marker = '';
var map;
var myLatLng = {lat: 22.543096, lng: 114.05786499999999};
var geocoder;
var map_s = true;
function initMap() {
	//console.log(myLatLng);
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 14,
		center:myLatLng ,
		zoomControl: true,
		mapTypeControl: false,
		scaleControl: false,
		streetViewControl: false,
		rotateControl: false
	});
	marker = new google.maps.Marker({
	    position: myLatLng,
	    map: map,
	  });
    geocoder = new google.maps.Geocoder();

    if (map_s == true) {
	    //根据地址在地图上定位
	    $('#location').unbind('click');
	    document.getElementById('location').addEventListener('click', function() {
	    	submitAddress(geocoder, map);
	    	return false;
	    });
		//地址输入框变动
	    document.getElementById('address').addEventListener('keyup', function(e) {
	        if (e.keyCode == 8) {
				return false;
	        }
	    	getAddressList(geocoder, map);
	    });
	    map_s = false;
    }
    //点击地图创建标记
    map.addListener('click', function(e) {
		placeMarkerAndPanTo(e.latLng, map ,geocoder);
    });
}

//点击定位按钮获取地址
function submitAddress(geocoder, resultsMap) {
	$('#address-list').hide();
	var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
			resultsMap.setCenter(results[0].geometry.location);
			var lat = results[0].geometry.location.lat(); //纬度
			var lng = results[0].geometry.location.lng(); //经度
			var address = results[0].formatted_address;//地址
			getAddress(address ,lat ,lng);
			if (typeof marker == 'object') {
				marker.setMap(null);
			}
			marker = new google.maps.Marker({
				map: resultsMap,
				position: results[0].geometry.location,
				//draggable:true, //图标可拖动
			});
		} else {
			alert('定位失败');
		}
    });
}

var addressResults;
//将从谷歌获取的地址以列表展现
function getAddressList(geocoder, resultsMap) {
	var address = document.getElementById('address').value;

	if (typeof marker == 'object') {
		marker.setMap(null);
	}

    geocoder.geocode({'address': address}, function(results, status) {
		if (status === google.maps.GeocoderStatus.OK) {
			addressResults = results;
			//以列表展示地址
			var html = '';
			$.each(results ,function(key ,item) {
				//var address = item.formatted_address.split(' ');
				html += '<li data-key="'+key+'" onclick="addressListClick(this)">'+item.formatted_address+'</li>';
			})
			$('#address-list').html(html).show();
		} else {
			$('#address-list').html('<span style="color:red;">没有获取到地址，换个地址试试</span>');
		}
    });
}
//点击地址列表
function addressListClick(obj) {
	var key = $(obj).attr('data-key');
	map.setCenter(addressResults[key].geometry.location);
	var lat = addressResults[key].geometry.location.lat(); //纬度
	var lng = addressResults[key].geometry.location.lng(); //经度
	var address = addressResults[key].formatted_address;//地址
	getAddress(address ,lat ,lng);
	if (typeof marker == 'object') {
		marker.setMap(null);
	}
	marker = new google.maps.Marker({
		map: map,
		position: addressResults[key].geometry.location,
		//draggable:true, //图标可拖动
	});
	
	marker.setMap(map);
	$('#address-list').hide();
}

//点击地图定位
function placeMarkerAndPanTo(latLng, map ,geocoder) {
	if (typeof marker == 'object') {
		marker.setMap(null);
	}
	marker = new google.maps.Marker({
		position: latLng,
		map: map
	});
	geocodeLatLng(geocoder ,map ,latLng);
}
//根据经纬度获取地址
function geocodeLatLng(geocoder, map ,latlng) {
  geocoder.geocode({'location': latlng}, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
      if (results[0]) {
		var lat = results[0].geometry.location.lat();//纬度
		var lng = results[0].geometry.location.lng();//经度
		var address = results[0].formatted_address;//地址
		getAddress(address ,lat ,lng);
      } else {
    	getAddress('' ,'' ,'');
        window.alert('获取地址失败');
      }
    } else {
    	getAddress('' ,'' ,'');
      window.alert('获取地址失败');
    }
  });
}
function getAddress(address ,lat ,lng){
	//中国广东省深圳市福田区商报路2号 邮政编码: 518034
	//var address = address.split(' ');
	$('input[name=address]').val(address);
	$('input[name=lat]').val(lat);
	$('input[name=lng]').val(lng);
	getGeohash(lat ,lng);
}
//获取经纬度哈希值 
function getGeohash(lat ,lng) {
	$.ajax({
		url:'/geohash/cfg_geohash',
		type:'post',
		dataType:'json',
		data:{'lat':lat,'lng':lng},
		success:function(data) {
			if(data.code == '2000') {
				$('input[name=geohash]').val(data.data);
			} else {
				//alert(data.msg);
				alert('经纬度获取错误，请输入地址重新定位');
			}
		}
	});
}
$('#address').keydown(function(e){
	var key = e.keyCode;
	//console.log(key); //38 40 39 37 17 32
	if (key == 37 || key == 38 || key==39 || key==40 || key==17 || key ==32) {

	} else {
		$('input[name=lat]').val('');
		$('input[name=lng]').val('');
		$('input[name=geohash]').val('');
	}
})
//已通过
var columns1 = [ {field : 'name',title : '景点名称',width : '140',align : 'center'},
		{field : 'username',title : '启用人',width : '120',align : 'center'},
		{field : 'open_time',title : '启用时间',width : '140',align : 'center'},
		{field : 'cityname',title : '所在地',width : '70',align : 'center'},
		{field : null,title : '是否热门',align : 'center', width : '70',formatter:function(item){
				return item.ishot == 1 ? '是' :'否';
			}
		},
		{field : 'pic_num',title : '图片数量',align : 'center', width : '60'},
		{field : 'comment_count',title : '评论数',align : 'center', width : '60'},
		{field : 'praise',title : '赞数量',align : 'center', width : '60'},
		{field : null,title : '操作',align : 'center', width : '170',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">编辑</a>';
			//button += '<a href="javascript:void(0);" onclick="scenicPic('+item.id+')" class="tab-button but-blue">管理图片</a>';
			button += '<a href="javascript:void(0);" onclick="disable('+item.id+')" class="tab-button but-red">禁用</a>';
			if (item.ishot == 0) {
				button += '<a href="javascript:void(0);" onclick="addHot('+item.id+')" class="tab-button but-blue">设为热门</a>';
			} else {
				button += '<a href="javascript:void(0);" onclick="cancelHot('+item.id+')" class="tab-button but-blue">取消热门</a>';
			}
			return button;
		}
	}];
//未启用
var columns2 = [ {field : null,title : '<input name="all-spot" onclick="allSpot(this);" type="checkbox">',width : '40',align : 'center',formatter:function(item){
				return '<input type="checkbox" name="check-spot" value="'+item.id+'">';
			}
		},
		 {field : 'name',title : '景点名称',width : '140',align : 'center'},
        {field : 'cityname',title : '所在地',width : '70',align : 'center'},
		{field : null,title : '是否热门',align : 'center', width : '70',formatter:function(item){
				return item.ishot == 1 ? '是' :'否';
			}
		},
		{field : 'pic_num',title : '图片数量',align : 'center', width : '60'},
		{field : 'comment_count',title : '评论数',align : 'center', width : '60'},
		{field : 'praise',title : '赞数量',align : 'center', width : '60'},
		{field : null,title : '操作',align : 'center', width : '120',formatter: function(item){
			var button = '<a href="javascript:void(0);" onclick="enable('+item.id+')" class="tab-button but-blue">启用</a>';
			button += '<a href="javascript:void(0);" onclick="edit('+item.id+')" class="tab-button but-blue">编辑</a>';
			return button;
		}
	}];
//已拒绝
var columns3 = [ {field : 'name',title : '景点名称',width : '140',align : 'center'},
         		{field : 'username',title : '操作人',width : '120',align : 'center'},
         		{field : 'open_time',title : '禁用时间',width : '140',align : 'center'},
         		{field : 'cityname',title : '所在地',width : '70',align : 'center'},
         		{field : 'pic_num',title : '图片数量',align : 'center', width : '60'}];
//待审核
var columns4 = [ {field : 'name',title : '景点名称',width : '140',align : 'center'},
          		{field : 'cityname',title : '所在地',width : '70',align : 'center'},
          		{field : 'pic_num',title : '图片数量',align : 'center', width : '60'},
          		{field : null,title : '操作',align : 'center', width : '120',formatter: function(item){
        				var button = '<a href="javascript:void(0);" onclick="seeDetail('+item.id+' ,1)" class="tab-button but-blue">通过</a>';
        				button += '<a href="javascript:void(0);" onclick="seeDetail('+item.id+' ,2)" class="tab-button but-blue">拒绝</a>';
        				return button;
        			}
        		}];
function allSpot(obj) {
	//console.log($(obj).attr('checked'));
	if ($(obj).attr('checked') == 'checked') {
		$('input[name=check-spot]').attr('checked' ,true);
	} else {
		$('input[name=check-spot]').attr('checked' ,false);
	}
}


function batchEnable() {
	var ids = '';
	alert($('inupt[name=check-spot]').length);
	$('inupt[name=check-spot]').each(function(){
		ids += $(this).val()+',';
		//console.log($(this).val());
	})
	//console.log(ids);
	if (ids.length < 1) {
		alert('请选择处理的数据');
		return false;
	}
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/batchEnable',
		type:'post',
		data:ids,
		dataType:'json',
		success:function(data){
			if(data.code == 2000) {
				change_status(2);
				alert(data.msg);
			} else {
				alert(data.msg);
			}
		}
	});
}
//根据状态加载数据
function change_status(status) {
	if (status == 1) {
		$("#dataTable").pageTable({
			columns:columns1,
			url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
			pageNumNow:1,
			searchForm:'#search-condition',
			tableClass:'table-data',
			isPageJump:true
		});
		$('.search-admin,.search-time,.search-ishot').show();
		$('.search-admin').find('.search-title').html('启用人：');
		$('.search-time').find('.search-title').html('启用时间：');
	} else if (status == 2) {
		$("#dataTable").pageTable({
			columns:columns2,
			url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
			pageNumNow:1,
			searchForm:'#search-condition',
			tableClass:'table-data',
			isPageJump:true,
			isEnable:true,
			enableCallback:function(){
				$('.batch-enable').click(function(){
					var ids = '';
					$('input[name=check-spot]:checked').each(function(){
						ids += $(this).val()+',';
					})
					if (ids.length < 1) {
						alert('请选择处理的数据');
						return false;
					}
					$.ajax({
						url:'/admin/a/scenic/scenic_spot/batchEnable',
						type:'post',
						data:{ids:ids},
						dataType:'json',
						success:function(data){
							if(data.code == 2000) {
								change_status(2);
								alert(data.msg);
							} else {
								alert(data.msg);
							}
						}
					});
				})
			}
		});
		$('.search-admin,.search-time').hide();
		$('.search-ishot').show();
	} else if (status == 0) {
		$("#dataTable").pageTable({
			columns:columns4,
			url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
			pageNumNow:1,
			searchForm:'#search-condition',
			tableClass:'table-data',
			isPageJump:true
		});
		$('.search-admin,.search-time,.search-ishot').hide();
	} else if (status == -1) {
		$("#dataTable").pageTable({
			columns:columns3,
			url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
			pageNumNow:1,
			searchForm:'#search-condition',
			tableClass:'table-data',
			isPageJump:true
		});
		$('.search-admin,.search-time').show();
		$('.search-ishot').hide();
		$('.search-admin').find('.search-title').html('操作人：');
		$('.search-time').find('.search-title').html('禁用时间：');
	}
	
}
	
//初始加载
change_status(0);
//导航栏切换
$('.nav-tabs li').click(function(){
	$(this).addClass('active').siblings().removeClass('active');
	$("#search-condition").find('input[type=text]').val('');
	$("#search-condition").find('input[type=hidden]').val('');
	$("#search-condition").find('input[name=country]').trigger('keyup');
	$("#search-condition").find('input[name=country]').nextAll('ul').hide();
	var status = $(this).attr('data-val')
	$('input[name="status"]').val(status);
	change_status(status);
})
/***************图片管理**************/
var listObj = $('#pic-list');
function scenicPic(id) {
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/getScenicPic',
		data:{id:id},
		dataType:'json',
		type:'post',
		success:function(data) {
			if (!$.isEmptyObject(data)) {
				var html = '';
				$.each(data ,function(key ,val) {
					if (key == 0) {
						html += '<li class="active">';
					} else {
						html += '<li>';
					}
					html += '<span class="pic-del" onclick="delPic(this);">x</span><img src="'+val.pic+'">';
					html += '<span class="mainpic">设为主图<span onclick="choiceMainPic(this);" class="mainpic-box"></span></span>';
					html += '</li>';
				})
				listObj.html(html);
			} else {
				listObj.html('');
			}
			getListPicUrl();
			$('#scenic-pic-form').find('input[name=picid]').val(id);
			$('.scenic-pic,.mask-box').fadeIn(300);
			$('html, body').animate({scrollTop:0}, 'slow');
		}
	});
}
//选择主图
function choiceMainPic(obj) {
	//console.log('789978');
	if (!$(obj).parents('li').hasClass('active')) {
		//console.log('ok');
		$(obj).parent().parent('li').addClass('active').siblings().removeClass('active');
	}
}
$('.mainpic-box').click(function(){
	choiceMainPic(this);
})
//删除图片
function delPic(obj) {
	$(obj).parent('li').remove();
	if (listObj.find('.active').length == 0 && listObj.find('li').length>0) {
		listObj.find('li').eq(0).addClass('active');
	}
	getListPicUrl();
}
//上传图片
$('#upload-img').click(function(){
	xiuxiu.setLaunchVars('cropPresets', '270*200');
	xiuxiu.embedSWF('xiuxiu_box',5,'100%','100%','xiuxiuEditor');
	xiuxiu.setUploadURL("<?php echo site_url('/admin/upload/uploadImgFileXiu')?>");
    xiuxiu.setUploadType(2);
    xiuxiu.setUploadDataFieldName('uploadFile');
	xiuxiu.onInit = function ()
	{
		xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg");
	}
	xiuxiu.onUploadResponse = function (data)
	{
		data = eval('('+data+')');
		if (data.code == 2000) {
			var html = '';
			if (listObj.find('li').length == 0) {
				html += '<li class="active">';
			} else {
				html += '<li>';
			}
			html += '<span class="pic-del" onclick="delPic(this);">x</span><img src="'+data.msg+'">';
			html += '<span class="mainpic">设为主图<span onclick="choiceMainPic(this);" class="mainpic-box"></span></span>';
			html += '</li>';
			listObj.append(html);
			getListPicUrl();
			$("#xiuxiuEditor,.avatar_box").hide();		
		} else {
			alert(data.msg);
		}
	}
	$("#xiuxiuEditor,.avatar_box").show();
})
//获取图片路径并写入隐藏域
function getListPicUrl() {
	var url = '';
	$.each(listObj.find('li') ,function(){
		url += $(this).find('img').attr('src')+',';
	})
	$('input[name=piclist]').val(url);
}
//提交修改数据
$('#scenic-pic-form').submit(function(){
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	$('#scenic-pic-form').find('input[name=index]').val(listObj.find('.active').index());
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/updatePic',
		type:'post',
		dataType:'json',
		data:$(this).serialize(),
		success:function(data) {
			if (data.code == 2000) {
				$("#dataTable").pageTable({
					columns:columns1,
					url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
					searchForm:'#search-condition',
					tableClass:'table-data',
					pageNumNow:page
				});
				alert(data.msg);
				$('.scenic-pic,.mask-box').fadeOut(500);
			} else {
				alert(data.msg);
			}
		}
	});
	return false;
})

$(document).mouseup(function(e) {
	var _con = $('#xiuxiuEditor');
	if (!_con.is(e.target) && _con.has(e.target).length === 0) {
    	$("#xiuxiuEditor,.avatar_box").hide();
	}
})
/***************图片管理结束**************/
function disable(id) {
	if (confirm('您确定要禁用此景点？')) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/scenic/scenic_spot/disable',
			type:'post',
			dataType:'json',
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns1,
						url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
function enable(id) {
	if (confirm('您确定要启用此景点？')) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/scenic/scenic_spot/enable',
			type:'post',
			dataType:'json',
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns2,
						url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
function cancelHot(id) {
	if (confirm('您确定要取消此景点的热门？')) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/scenic/scenic_spot/cancelHot',
			type:'post',
			dataType:'json',
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns1,
						url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}
function addHot(id) {
	if (confirm('您确定要将此景点设为热门？')) {
		var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
		$.ajax({
			url:'/admin/a/scenic/scenic_spot/addHot',
			type:'post',
			dataType:'json',
			data:{id:id},
			success:function(data) {
				if (data.code == 2000) {
					$("#dataTable").pageTable({
						columns:columns1,
						url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:page
					});
					alert(data.msg);
				} else {
					alert(data.msg);
				}
			}
		});
	}
}

var addFormObj = $('#form-data');
$('#add-button').click(function(){
	addFormObj.find('input[type=text]').val('');
	addFormObj.find('input[type=hidden]').val('');
	addFormObj.find('.pic-list').html('');
	addFormObj.find('textarea').val('');
	addFormObj.find('select').val(0).change();
	//addFormObj.find('input[name=country]').trigger('keyup');
	//addFormObj.find('input[name=country]').nextAll('ul').hide();
	$("input[name='ishot'][value=0]").attr("checked",true);
	$('.edit-submit').hide();
	$('.add-scenic').find('.db-body').css('position','static');
	//console.log(typeof marker);
	$('.mask-box,.add-scenic').show();
	marker.setMap(null);
})
$('.close-scenic').click(function(){
	$('.mask-box').hide();
	$('.add-scenic').find('.db-body').css('position','absolute');
})

function edit(id) {
	$.ajax({
		url:'/admin/a/scenic/scenic_spot/getScenicDetail',
		data:{id:id},
		type:'post',
		dataType:'json',
		success:function(data) {
			if ($.isEmptyObject(data)) {
				alert('数据错误');
			} else {
				var picList = data.pic;
				var data = data.detail;
				addFormObj.find('input[name=name]').val(data.name);
				addFormObj.find('input[name=address]').val(data.address);
				addFormObj.find('input[name=lat]').val(data.latitude);
				addFormObj.find('input[name=geohash]').val(data.geohash);
				addFormObj.find('input[name=lng]').val(data.longitude);
				addFormObj.find('input[name=displayorder]').val(data.displayorder);
				addFormObj.find('textarea[name=description]').val(data.description);
				addFormObj.find('input[name=id]').val(data.id);
				$("input[name='ishot'][value="+data.ishot+"]").attr("checked",true);
				$("input[name='isopen'][value="+data.status+"]").attr("checked",true);
// 				addFormObj.find('select[name=country_id]').val(data.country_id).change();
// 				addFormObj.find('select[name=province_id]').val(data.province_id).change();
// 				addFormObj.find('select[name=city_id]').val(data.city_id);
				addFormObj.find('input[name=country]').val(data.country);
				addFormObj.find('input[name=country]').trigger('keyup');
				addFormObj.find('input[name=country_id]').val(data.country_id);
				addFormObj.find('input[name=country]').nextAll('ul').hide();
				
				addFormObj.find('input[name=province]').val(data.province).show();
				addFormObj.find('input[name=province]').trigger('keyup');
				addFormObj.find('input[name=province_id]').val(data.province_id);
				addFormObj.find('input[name=province]').nextAll('ul').hide();
				
				addFormObj.find('input[name=city]').val(data.city).show();
				addFormObj.find('input[name=city]').trigger('keyup');
				addFormObj.find('input[name=city_id]').val(data.city_id);
				addFormObj.find('input[name=city]').nextAll('ul').hide();
				if (typeof picList == 'object') {
					var pics = '';
					var html = '';
					$.each(picList ,function(index ,val) {
						pics += val.pic+',';
						
						if (val.pic == data.rawPic) {
							html += '<li class="active">';
						} else {
							html += '<li>'
						}
						html += '<span class="pic-del" onclick="delPic(this);">x</span>';
						html += '<img src="'+val.pic+'">';
						html += '<span class="mainpic">设为主图<span onclick="choiceMainPic(this);" class="mainpic-box"></span></span>';
						html += '</li>';
						
					})
					addFormObj.find('input[name=piclist]').val(pics);
					addFormObj.find('.pic-list').html(html);
				} else {
					addFormObj.find('input[name=piclist]').val('');
					addFormObj.find('.pic-list').html('');
				}
				//$('#location').trigger('click');
				myLatLng = {lat: data.latitude*1, lng: data.longitude*1};
				initMap();

				$('.add-scenic').find('.db-body').css('position','static');
				$('.mask-box,.add-scenic').show();
			}
		}
	});
}

$('#submit-but').click(function(){
	var geohash = addFormObj.find('input[name=geohash]').val();
	if (geohash.length < 1) {
		var lat = addFormObj.find('input[name=lat]').val();
		var lng = addFormObj.find('input[name=lng]').val();
		$.ajax({
			url:'/geohash/cfg_geohash',
			type:'post',
			dataType:'json',
			data:{'lat':lat,'lng':lng},
			success:function(data) {
				if(data.code == '2000') {
					$('input[name=geohash]').val(data.data);
					addSubmit();
				} else {
					alert('经纬度获取错误，请输入地址重新定位');
					//alert(data.msg);
				}
			}
		});
	} else {
		addSubmit();
	}
})

function addSubmit() {
	var city_id = addFormObj.find('input[name=city_id]').val();
	if (city_id < 1) {
		alert('请选择景点地区到第三级');
		return false;
	}
	var id = addFormObj.find('input[name=id]').val();
	var url = id>0 ? '/admin/a/scenic/scenic_spot/edit' : '/admin/a/scenic/scenic_spot/add';
	var page = $('#dataTable').find('.page-button').find('.active-page').attr('data-page');
	var index = addFormObj.find('.pic-list').find('.active').index();
	
	addFormObj.find('input[name=index]').val(index);
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:addFormObj.serialize(),
		success:function(data) {
			if (data.code == 2000) {
				alert(data.msg);
				var pageNow = id>0 ? page : 1;
					$("#dataTable").pageTable({
						columns:columns1,
						url:'/admin/a/scenic/scenic_spot/getScenicSpotData',
						searchForm:'#search-condition',
						tableClass:'table-data',
						pageNumNow:pageNow
					});
					$('.mask-box').hide();
					$('.add-scenic').find('.db-body').css('position','absolute');
			} else {
				alert(data.msg);
			}
		}
	});
}
$('#starttime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
$('#endtime').datetimepicker({
	lang:'ch', //显示语言
	timepicker:false, //是否显示小时
	format:'Y-m-d', //选中显示的日期格式
	formatDate:'Y-m-d',
	validateOnBlur:false,
});
</script>									

