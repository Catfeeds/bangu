<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
	<title>深圳海外国际旅行社API</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/css/api.css');?>" />	
</head>
<body>
	<?php
		$url = site_url ( "webservices" ) . "/";
	?>
	<div class="main">
		<div class="top">
			<div class="title"><h1>深圳海外国际旅行社API</h1></div>
		</div>
		<div class="apiMain">
			<div class="panel">
				<div class="portal"><a href="#summary">概述</a></div>
				<?php 
					$tmpCode="";
					foreach ($webservice as $key=>$val){
						$tmpCode.="<div class=\"portal\"><a href=\"#".$val["urlName"]."\" >".$val ["serviceName"]."</a></div>";
					}
					echo $tmpCode;
				?>
				<div class="portal"><a href="http://www.sojson.com/" target="_blank">JSON解析</a></div>
			</div>			
			<div class="content">
				<div class="bodyContent" id="summary">
					<h2>概述</h2>
					<ul>
						<li>
							<div class="para_tit">数据通信类型</div>
							<div class="para_cont">jsonp</div>
						</li>
						<li>
							<div class="para_tit">数据通信格式</div>
							<div class="para_cont">callback({"msg":"msgData","code":"codeData","data":{"field":"value"}})</div>
						</li>						
						<li>
							<div class="para_tit">数据通信方式</div>
							<div class="para_cont">get</div>
						</li>
						<li>
							<div class="para_tit">callback:自定义的回调名</div>
							<div class="para_cont">
								<table class="para_table">
									<tbody>
										<tr>
											<th>msg</th>
											<td>通信消息</td>	
										</tr>
										<tr>
											<th>code</th>
											<td>通信代码（2000表示获取数据成功，4001表示数据为空）</td>
										</tr>
										<tr>
											<th>data</th>
											<td>通信数据内容（只有 code是2000的时候才有数据）</td>
										</tr>
									</tbody>
								</table>
							</div>
						</li>
					</ul>
				</div>
				<?php 
					$tmpCont="";
					foreach ($webservice as $key=>$val){
						//$tmpCont.="<h2>".$val["serviceName"]."</h2>";
						$tmpCont.="<div class=\"bodyContent\" id=\"".$val["urlName"]."\"><h2>".$val["serviceName"]."</h2><ul>";
						$tmpCont.="<li><div class=\"para_tit\">接口说明</div><div class=\"para_cont\">".$val["serviceDesc"]."</div></li>";
						$tmpCont.="<li><div class=\"para_tit\">接口示例</div><div class=\"para_cont\"><a href=\"".$url.$val["urlName"]."\" target=\"_blank\">".$val["urlName"]."</a></div></li>";
						$tmpCont.="<li><div class=\"para_tit\">接口参数设置</div><div class=\"para_cont\"><table class=\"para_table\"><tbody><tr><th>参数名</th><th>具体描述</th></tr><tr>";
						foreach ( $val ["para"] as $k1=>$v1){							
							$tmpCont.="<tr><td>".$val['para'][$k1]["field"]."</td><td>".$val['para'][$k1]["desc"]."</td></tr>";
						}
						$tmpCont.="</tbody></table></div></li>";
						$tmpCont.="<li><div class=\"para_tit\">返回结果</div><div class=\"para_cont\">".$val["serviceName"]."</div></li>";	
						$tmpCont.="</ul></div>";
					}
					echo $tmpCont;
				?>			
			</div>
		</div>
	</div>
	<p class="link-back2top" style="display: block;"><a href="#" title="Back to top">Back to top</a></p>
	<script type="text/javascript" src="<?php echo base_url(); ?>static/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>static/js/main.js" ></script>
</body>
</html>