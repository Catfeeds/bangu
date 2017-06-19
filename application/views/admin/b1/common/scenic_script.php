<style>
.addBar ul{ display: none;}
.destBarBlock{ display: block !important;}
</style>
<script>
var arrPar = [];
var arrId = [];
var arrBar = []; //多选时先添加到数组 
var Barlen =$(".romoveBar ul li").length; //初始获取数值
var romovelen; 
var ScenicHtml = "";
var data;
var activeId;

	//切换新数据
	$(".scenicTb ul li").click(function(){
		$(this).addClass('dataShow').siblings().removeClass('dataShow');
	});
	
	$("#showScenic").click(function(){
		var clickScenicBtn=$('input[name="click_scenic_btn"]').val(); 
		if(clickScenicBtn!=1){ //第一次点击就不加载了
		$('input[name="click_scenic_btn"]').val('1');
		var scenicData=$('input[name="scenicData"]').val();	
		//加载目的的景点
		var line_id=<?php if(!empty($data['id'])){echo $data['id'];}?>;
		$.post("<?php echo base_url()?>admin/b1/product/get_scenic_spot",{'line_id':line_id},function(json) {
			var obj = eval('(' + json + ')');	
			data = obj;

			var deststr='';
			//目的地
			$('.scenicTab').find('ul').html('');
			$('.muenScenic').find('span').html();//标题
			var deststr='';
			$.each(obj.scenic, function(key, val) {
				if(deststr==''){
					deststr=val.kindname;
				}else{
					deststr=deststr+','+val.kindname;
				}
				if(key==0){
	                $('.scenicTab').find('ul').append('<li val-id ='+val.dest_id+' class="dataShow"  onclick="change_scenic(this,'+val.dest_id+')" >'+val.kindname+'</li>');
				}else{
				    $('.scenicTab').find('ul').append('<li val-id ='+val.dest_id+' onclick="change_scenic(this,'+val.dest_id+')" >'+val.kindname+'</li>');	
				}


			});
			$('.muenScenic').find('span').html(deststr);//标题
			var scenicData = "";
			for(var i = 0; i<data.scenic.length;i++){
				if(i == 0 ){
					scenicData+="<ul ul-id="+data.scenic[i].dest_id+" class='destBar"+i+ " destBarBlock'>";
				}else{
					scenicData+="<ul ul-id="+data.scenic[i].dest_id+" class=destBar"+i+">";
				}
				for(var j = 0; j<data.scenic[i].spot.length; j++){
					if(data.scenic[i].spot[j].status==0){
                                                                   var onwait='<span style="color: #ff0000;">(待审核)</span>';
					}else{
						var onwait='';
					}
					scenicData+="<li><div class='liFog' data='"+data.scenic[i].spot[j].id+"'>"+data.scenic[i].spot[j].name+"<span>"+data.scenic[i].spot[j].ename+"</span>"+onwait+"</div></li>";
				}
				scenicData+="</ul>";
			};
			$(".addBar").append(scenicData);
			
			$("#addBar").click(function(){
				if($(".addOn").length>0){
					for(var i = 0 ; i < $(".addOn").length; i++){
						arrBar.push($(".addOn").eq(i).html());
						arrId.push($(".addOn").eq(i).attr('data'));
						
					};
					$(".addOn").parent().remove();
				};
				var dataShowId = $(".dataShow").attr('val-id');
				for(var i = 0 ; i < arrBar.length; i++){
					Barlen = parseInt(Barlen)+1;
					$(".romoveBar ul").append('<li data-type='+dataShowId+'><div class="sortNum">('+Barlen+')</div><div class="liFog" data="'+arrId[i]+'">'+arrBar[i]+'</div><div class="sortTop"></div><div class="sortBottom"></div></li>');
					sortFirst();
				};
				emptyArr();
				initgator();
			});
			
			$("#removeBar").click(function(){
				if($(".romoveOn").length>0){
					for(var i = 0 ; i < $(".romoveOn").length; i++){
						arrBar.push($(".romoveOn").eq(i).html());
						arrId.push($(".romoveOn").eq(i).attr('data'));
						arrPar.push($(".romoveOn").eq(i).parent().attr('data-type'));
						console.log("arrBar:"+arrBar);
						console.log("arrId:"+arrId);
						console.log("arrPar:"+arrPar);
					};
					for(var j = 0; j<arrPar.length; j++){
						for(var i = 0; i<data.scenic.length;i++){
							if(arrPar[j] == $(".addBar").find('ul').eq(i).attr('ul-id')){
								$(".addBar ul").eq(i).append('<li><div class="liFog" data="'+arrId[j]+'">'+arrBar[j]+'</div></li>');
							}
						}
					}
				};
				$(".romoveOn").parent().remove();
				emptyArr()
				initgator();
			});
			
			//双击事件
			$(".addBar ul li .liFog").live('dblclick',function(){
				var date = $(this).attr('data');
				var text = $(this).html();
				var dataShowId = $(".dataShow").attr('val-id');
				$(".romoveBar ul").append('<li data-type='+dataShowId+'><div class="sortNum">('+Barlen+')</div><div class="liFog" data="'+date+'">'+text+'</div><div class="sortTop"></div><div class="sortBottom"></div></li>');
				$(this).parent().remove();
				initgator()
			});
	
			$(".romoveBar ul li .liFog").live('dblclick',function(){
				var pardate = $(this).parent().attr('data-type');
				var date = $(this).attr('data');
				var text = $(this).html();
				for(var i = 0; i<data.scenic.length;i++){
					if(pardate == $(".addBar").find('ul').eq(i).attr('ul-id')){
						$(".addBar ul").eq(i).append('<li><div class="liFog" data="'+date+'">'+text+'</div></li>');
						$(this).parent().remove();
					}
				}
				initgator()
			});
		});
		$(".scenicBox").show();
		$('body,html').animate({scrollTop:0},0);
		}else{
			$(".scenicBox").show();
			$('body,html').animate({scrollTop:0},0);
		}
	})
	//景点切换
	function change_scenic(obj,id){
		activeId = id;
		$(obj).addClass('dataShow').siblings().removeClass('dataShow');
		$(".addBar ul").eq($(obj).index()).addClass('destBarBlock').siblings().removeClass('destBarBlock');
	}
		
	//显示新增景点
	$(".NewlyScenic").click(function(){
		var val=$('.dataShow').attr('val-id');
		$('input[name="city_id"]').val(val);
		$('.NewlyBox').show();
		$('.NewlyMank').show();
	});
	
	$('.NewlyMank').click(function(){
		$(this).hide();
		$(".NewlyBox").hide();
	})
	//关闭弹框
	$('.close-scenic,.close-scenic-btn').click(function(){
		$(".NewlyMank").hide();
		$(".NewlyBox").hide();
	})
	//单击选中添加事件
	$(".addBar ul li .liFog").live('click',function(){
		$(this).toggleClass('addOn'); 
		
	});
	
	//单击选中删除事件
	$(".romoveBar ul li .liFog").live('click',function(){
		$(this).toggleClass('romoveOn');
		$(this).siblings(".sortNum").toggleClass("numActive")
	});
	
	//清空数组
	function emptyArr(){
		arrId=[];
		arrBar = [];
		arrPar=[];
	}
	
	
	//判断是否是第一个
	function sortFirst(){
		if($(".romoveBar ul li").length>=1){
			$(".romoveBar ul li").find('.sortTop').removeClass('firstSort');
			$(".romoveBar ul li").find('.sortBottom').removeClass('lastSort');
			$(".romoveBar ul li:first-child").find(".sortTop").addClass('firstSort');
			$(".romoveBar ul li:last-child").find(".sortBottom").addClass('lastSort');
		}
	};
	
	//双击后 重新排序 
	function sortdbl(){
		for(var i = 0; i<romovelen ; i++){
			$(".romoveBar ul li").eq(i).find('.sortNum').html("("+(parseInt(i)+1)+")");
		};
	};
	
	//按钮排序事件(上)
	$(".sortTop").live('click',function(){
		if(!$(this).hasClass("firstSort")){
			var index  = $(this).parent().index();
			var afterHtml = $(this).parent('li').html();
			var sortData = $(this).parent('li').attr('data-type');
			$(this).parent().remove();
			$('.romoveBar ul li').eq(index-1).before('<li data-type="'+sortData+'" >'+afterHtml+'</li>');
			initgator()
		};
	});
	
	//按钮排序事件(下)
	$(".sortBottom").live('click',function(){
		if(!$(this).hasClass("lastSort")){
			var index  = $(this).parent().index();
			var afterHtml = $(this).parent('li').html();
			var sortData = $(this).parent('li').attr('data-type');
			$('.romoveBar ul li').eq(index+1).after('<li data-type="'+sortData+'" >'+afterHtml+'</li>');
			$(this).parent().remove();
			initgator()
		};
	});
	
	//排序和 首尾
	function initgator(){
		romovelen = $(".romoveBar ul li").length;
		sortdbl();
		sortFirst();
	}
	
	$("#scenicButton").click(function(){
		$('.scenicBox').hide();
		$(".NewlyBox").hide();
		$('body,html').animate({scrollTop:$('body').height()},0);
		//数据
		$('#scenic_span').html('');
		$('input[name="scenicData"]').val('');
		var scenic_id='';
		romoveleng = $(".romoveBar ul li").length;
		for(var i = 0; i<romoveleng ; i++){
			var id=$(".romoveBar ul li").eq(i).find('.liFog').attr('data');
			var name=$(".romoveBar ul li").eq(i).find('.liFog').html();

			var start_ptn = /<(?!img)[^>]*>/g;      //过滤标签开头      
			var end_ptn = /[ | ]*\n/g;            //过滤标签结束  
			var space_ptn = /&nbsp;/ig;          //过滤标签结尾
			//name = name.replace(start_ptn,"").replace(end_ptn).replace(space_ptn,"");
			$('#scenic_span').append('<span class="scenic_val">'+name+'</span');
			if(scenic_id==''){
				scenic_id=id;
			}else{
				scenic_id=scenic_id+','+id;
			}
			
		};
		$('#scenic_span').find('.scenic_val').children().remove();
		$('input[name="scenicData"]').val(scenic_id);
		
	})
	//搜索景点
	function search_scenic(obj){
		var romovelen=$('.romoveBar ul').find('li').length;
		var searchSport=$('input[name="searchSport"]').val();
		var dataShow=$('.dataShow').attr('val-id');
		var spotStr='';
		for(var i = 0; i<romovelen ; i++){
			var sport_id=$(".romoveBar ul li").eq(i).find('.liFog').attr('data');
			if(spotStr==''){
				spotStr=spotStr+sport_id;
			}else{
				spotStr=spotStr+','+sport_id;
			}
			
		};

		
		jQuery.ajax({ type : "POST",data :"searchName="+searchSport+"&spotStr="+spotStr+"&city_id="+dataShow,url : "<?php echo base_url()?>admin/b1/product/search_scenic_spot",
			success : function(data) {
				data = eval('('+data+')');
				//console.log(data);
				//alert(data.scenic.dest_id);
				$(".destBarBlock").html('');
				var scenicData='';
				for(var j = 0; j<data.scenic.spot.length; j++){

					if(data.scenic.spot[j].status==0){
                                                                   var onwait='<span style="color: #ff0000;">(待审核)</span>';
					}else{
						var onwait='';
					}
					scenicData+="<li><div class='liFog' data='"+data.scenic.spot[j].id+"'>"+data.scenic.spot[j].name+"<span>"+data.scenic.spot[j].ename+"</span>"+onwait+"</div></li>";
				}
				$(".destBarBlock").append(scenicData);
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
			var len=$('#pic-list').find('li').length;
			var html='';
			if (len== 0) {
				html += '<li class="active">';
			} else {
				html += '<li>';
			}
			html += '<span class="pic-del" onclick="delPic(this);">x</span><img src="'+data.msg+'">';
			html += '<span class="mainpic">设为主图<span onclick="choiceMainPic(this);" class="mainpic-box"></span></span>';
			html += '</li>';
			$('#pic-list').append(html);
			getListPicUrl();
			$("#xiuxiuEditor,.avatar_box").hide();		
		} else {
			alert(data.msg);
		}
	}
	$("#xiuxiuEditor,.avatar_box").show();
})
var listObj = $('#pic-list');
//获取图片路径并写入隐藏域
function getListPicUrl() {
	var url = '';
	$.each(listObj.find('li') ,function(){
		url += $(this).find('img').attr('src')+',';
	})
	$('input[name=piclist]').val(url);
}
//删除图片
function delPic(obj) {
	$(obj).parent('li').remove();
	if (listObj.find('.active').length == 0 && listObj.find('li').length>0) {
		listObj.find('li').eq(0).addClass('active');
	}
	getListPicUrl();
}


//-----------------------------------------加载地图------------------------------------------
//---------------------------------全屏--------------------------------
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
//------------------------------------
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
//--------------------------------地图end----------------------------------
var addFormObj = $('#form-data');
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
					alert(data.msg);
				}
			}
		});
	} else {
		addSubmit();
	}
})
function addSubmit() {
	var url='/admin/b1/product/save_line_spot';
	var index = addFormObj.find('.pic-list').find('.active').index();
	addFormObj.find('input[name=index]').val(index);
	$.ajax({
		url:url,
		type:'post',
		dataType:'json',
		data:addFormObj.serialize(),
		success:function(data) {
			if (data.status == 1) {
				var Barlen =$(".romoveBar ul li").length; 
				var len=Barlen+1;
				var dataShowId = $(".dataShow").attr('val-id');
				var text=data.scenic.name;
				var date=data.scenic.scenic_spot_id;
				$(".romoveBar ul").append('<li data-type='+dataShowId+'><div class="sortNum">('+len+')</div><div class="liFog" data="'+date+'">'+text+'<span style="color: #ff0000;margin-left:10px;">(待审核)</span></div></li>');
				alert(data.msg);
					
				$(".NewlyMank").hide();
				$(".NewlyBox").hide();
			} else {
				alert(data.msg);
			}
		}
	});
}
</script>