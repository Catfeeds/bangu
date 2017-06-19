<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>管家人气排行榜</title>
		<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
		<link rel="stylesheet" href="<?php echo base_url('static/css/rankinglist/stroll.css'); ?>">
		<style>
			#box::-webkit-scrollbar {display: none}
			html, body {
				margin: 0px;
				padding: 0px;
				height: 100%; overflow: hidden;
			}
			body{
				background: #323232 url(<?php echo base_url('static/img/rankinglist/KingBg.jpg'); ?>) no-repeat;
				background-size: cover;
				font-family: "Arial","Sans-serif Helvetica";
				font-size: 14px;
				color: #eee;
				line-height: 1;
			}
			.cantantCon{
				position: relative;
				width: 90%;
				top: 15%;
				left:5%;
				margin: 0;
				padding: 0;
				background: #FECD57 url(<?php echo base_url('static/img/rankinglist/bangOption.png'); ?>) no-repeat;
				background-size: 100% 100%;
				background-position: 0 40px;
				height: 70%; 
				padding-bottom: 10px;
				border-top-left-radius: 20px;
				border-top-right-radius: 20px;
				box-shadow: 5px -4px 15px;
			}
			#box {
				height: calc(100% - 40px);
				overflow-x: hidden;
				overflow-y: scroll;
			}
			#box li {
				display: flex;

			}
			
			.trueBox {
				height: 40px; 
				line-height: 40px; 
				margin: 10px;
				list-style: none;
				background: #fff3c3;
				border-radius: 40px;
				color: #999;
				display: flex;
				/*align-items: center;
				justify-content: center;*/
				-webkit-transform: translate3d( 0, 0, 0px );
			}

			.ScrollH{ 
				height: 80%; 
				padding: 0;
				margin: 0;
			}
			.subTetxt{ 
				position: relative;
				width: 80%;
				top: 25%;
				left:10%;
				text-align: right;
				font-size: 12px;
				color: #946e19;
			}
			.headBox {
				width: 40px; 
				height: 40px;
				display: inline-block;
				/*position: absolute; left: 20px;*/
			}
			.headBox img{
				width: 100%;
				height: 100%;
				display: block;
				border-radius: 30px;
			}
			
			.box1{
				flex: 1; 
				display: flex; 
			}
			
			.headerTitlrBg{
				position: relative;
				height: 40px;
			}
			.bottomTitlrBg{
				position: relative;
				height: 40px;
				line-height: 30px;
				color: #946e19;
				text-align: center;
				background: #FECD57;
				border-bottom-left-radius: 20px;
				border-bottom-right-radius: 20px;
			}
			.headerTitle{
				width: 100%;
				display: flex;
				justify-content: center;
				align-items: center;
			}
			.headerTitle img{
				position: relative;
				top: -100px; 
				height: 60px;
			}
			.tipTextr{
				height: 40px; 
				line-height: 40px;
				position: relative; 
				top: -60px;
				color: #946e19;
				text-align: left;
				text-indent: 1em;
				font-size: 12px;
			}
			/*.reaopBox{ 
				position: absolute;
				top: 0;
				left: 20px;
				right: 20px; 
				height: 40px;
				background: #FECD57;
			}
			.reaopBox .quan1{ 
				position: absolute; 
				width: 40px; 
				height: 40px; 
				left: -20px; 
				top: 0px;
				background: #FECD57;
				border-radius: 20px; 
			}
			.reaopBox .quan2{ 
				position: absolute; 
				width: 40px; 
				height: 40px; 
				right: -20px; 
				top: 0px;
				background: #FECD57;
				border-radius: 20px; 
			}*/
			.cuccText{
				position: relative;
				z-index: 10;
				text-align: center;
			}
			.stand{
				width: 40px; 
				height: 40px;
				line-height: 40px;
				text-align: center;
				display: inline-block;
				margin: 10px 0;
				border-radius: 20px;
				background: #fff3c3;
				color: #946e19;
				margin-left: 10px;
			}
			.stand.oneSend{
				background: url("<?php echo base_url('static/img/rankinglist/oneIco.png'); ?>") no-repeat center center; 
				background-size: contain;
			}
			.stand.twoSend{
				background: url("<?php echo base_url('static/img/rankinglist/twoIco.png'); ?>") no-repeat center center; 
				background-size: contain;
			}
			.stand.threeSend{
				background: url("<?php echo base_url('static/img/rankinglist/threeIco.png'); ?>") no-repeat center center; 
				background-size: contain;
			}
			/*.stand.defaSend{
				background: url("threeIco.png") no-repeat center center; 
				background-size: contain;
			}*/
			.Name{
				display: inline-block;
				height: 40px; 
				line-height: 40px;
				display: inline-block;
				flex: 1;
				padding:0 10px;
				text-overflow: ellipsis;
				overflow: hidden; 
			}
			.Fraction{
				display: inline-block;
				height: 40px; 
				line-height: 40px;
				padding-right: 10px;
			}

			.Name.oneColor, .Fraction.oneColor{
				color: #db1d27;
				font-weight: bold;
			}
			.Name.twoColor, .Fraction.twoColor{
				color: #d1d1d3;
				font-weight: bold;
			}
			.Name.threeColor, .Fraction.threeColor{
				color: #b56750;
				font-weight: bold;
			}
			.shua{
				float:left;
			 	margin-left: 25px;
			}
			.zi{
				color: red;
			}

		</style>
	</head>
	
	<body>
		<div class="cantantCon">
			<div class="headerTitlrBg">
				<div class="headerTitle">
					<img src="<?php echo base_url('static/img/rankinglist/titlrTetxt.png'); ?>">
				</div>
				
				<div class="tipTextr">以下是前十名管家人气排行榜 【时间：2017-02-03 00:00:00 —— 2017-02-10 19:30:00】</div>
			</div>
			<ul id="box" class="contant ScrollH">
				<!-- <li class="future">
					<div class="stand">100</div>
					<div class="box1 trueBox">
						<div class="headBox"><img src="<?php echo base_url('static/img/rankinglist/headPhoto.jpg'); ?>"></div>
						<div class="box1">
							<span class="Name">name</span>
							<div class="Fraction">100</div>
						</div>
					</div>
				</li> -->
			</ul>
			<!-- <div class="secBottomr.png">没有中奖的不要气馁呦!</div> -->
			<div class="bottomTitlrBg">
				<div><span id="shuaxin" class="shua"><font id="hints" class="zi">60</font>秒后自动刷新</span>
				<span class="cuccText">注：若人气值相等则按时间先后排名</span>
				</div>
			</div>

		</div>

	</body>

</html>

<script type="text/javascript" src="<?php echo base_url();?>static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	// 使用效果
	var objClassP = "fly";
	var lost = document.domain; 
	var data ="";
	// class 效果 : grow cards curl wave flip fly fly-simplified fly-reverse helix fan papercut twirl 
	//名称
	var dataking = ['One Name', 'Two Name', 'Three Name', 'Four Name', '雷锋', 'Six', 'Seven', '假人', '英俊123456', 'Ten'];

	//得分
	var fen = [0,1,2,3,4,5,6,7,8,9];
	//倒计时
	var t=60;

	window.onload = function(){

		document.getElementById("box").className = " ScrollH contant " + objClassP;
		// console.log("动画效果初始化完成!");
		getdata();
// 		setInterval(function(){
// 			getdata();
// 		},10000);
		setInterval(xin,1000);
	}
	function xin(){
		t--;
		if(t>0){
			document.getElementById("hints").innerHTML=t;
			//alert(document.getElementById("hints").innerHTML)
		}
		if (t==0)
		{
			getdata();
			$(".shua").hide();
			document.getElementById("shuaxin").innerHTML="正在刷新...";
			$(".shua").show();
			t=60;
		}
	}
	// 执行动画  animationKing ( callBack )
	function animationKing( fun ){

		var anmeTimeSon = 80; //动画间隔
		var timer = null; // 定时器

		// 每次重新获取 动画元素 总是 执行第一个 循环 
		timer = setInterval(function(){

			var objL = document.querySelectorAll( ".future" );
			var l = objL.length;
			if( l <= 0){
				if(fun){
					fun();
				}
				clearInterval(timer);
				return false ;
			}else{
				objL[0].className = "";		
			}

		},anmeTimeSon);

	}

	//获取数据
	function getdata(){
		$.ajax({
            type: "post",
            url: "http://"+lost+"/rankinglist/expert_list_change",
            success: function(json){
            	data="";
				data = eval(json);				
				anta();
            }
        });
	}

	//添加结构
	function anta(){
		var dl = data.length;
		$("#box").html("");
		for( var i = 0 ; i < dl ; i ++ ){
			var ht = "";
				ht +='<li class="future">';
						if(i == 0){
				ht +=		'<div class="stand oneSend"></div>';
				ht +=	'<div class="box1 trueBox">';
				ht +=		'<div class="headBox"><img src="http://'+lost+data[i].small_photo+'"></div>';
				ht +=		'<div class="box1">';
				ht +=			'<span class="Name oneColor">'+data[i].realname+'  -   '+data[i].nickname+'</span>';
				ht +=			'<div class="Fraction oneColor">'+data[i].num+'</div>';
						}else if(i == 1){
				ht +=		'<div class="stand twoSend"></div>';
				ht +=	'<div class="box1 trueBox">';
				ht +=		'<div class="headBox"><img src="http://'+lost+data[i].small_photo+'"></div>';
				ht +=		'<div class="box1">';
				ht +=			'<span class="Name twoColor">'+data[i].realname+'  -   '+data[i].nickname+'</span>';
				ht +=			'<div class="Fraction twoColor">'+data[i].num+'</div>';
						}else if(i == 2){
				ht +=		'<div class="stand threeSend"></div>';	
				ht +=	'<div class="box1 trueBox">';
				ht +=		'<div class="headBox"><img src="http://'+lost+data[i].small_photo+'"></div>';
				ht +=		'<div class="box1">';
				ht +=			'<span class="Name threeColor">'+data[i].realname+'  -   '+data[i].nickname+'</span>';
				ht +=			'<div class="Fraction threeColor">'+data[i].num+'</div>';				
						}else{
				ht +=		'<div class="stand defaSend">'+(i+1)+'</div>';	
				ht +=	'<div class="box1 trueBox">';
				ht +=		'<div class="headBox"><img src="http://'+lost+data[i].small_photo+'"></div>';
				ht +=		'<div class="box1">';
				ht +=			'<span class="Name defaColor">'+data[i].realname+'  -   '+data[i].nickname+'</span>';
				ht +=			'<div class="Fraction defaColor">'+data[i].num+'</div>';
						}
				
				ht +=		'</div>';
				ht +=	'</div>';
				ht +='</li>';
			
			document.getElementById("box").innerHTML += ht;
		}
		// console.log("数据添加完成!");

		animationKing( function (){
			// console.log("全部加载完成!");
			document.getElementById("shuaxin").innerHTML='<font id="hints" class="zi">60</font>秒后自动刷新';
		});
	}

</script>