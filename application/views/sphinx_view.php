<?php 


$content=isset($_POST['content'])?$_POST['content']:'';
$status=isset($_POST['status'])?$_POST['status']:'2';
$day=isset($_POST['day'])?$_POST['day']:'';

header("Content-type: text/html; charset=utf-8");

$this->load->library('SphinxClient');//本地环境使用，内网或者外网环境注释掉这一行
$s = new SphinxClient;
$s->setServer("192.168.10.202", 9312);

//$s->SetArrayResult(true);
//$s->SetLimits(0,20);  //只取0到20行

//$s->SetFilter("status",array('3'));  //可行




$s->setMatchMode(SPH_MATCH_ANY); //SPH_MATCH_ANY
$s->setMaxQueryTime(30);

if(!empty($status))
{
$where_status[]=$status;
$s->SetFilter("status",$where_status);
}
if(!empty($day))
{
$where_day[]=$day;
$s->SetFilter("lineday",$where_day);  
}

//$s->SetSortMode(SPH_SORT_ATTR_DESC, 'status');
$s->SetLimits(0, 100);
$s->SetSortMode(SPH_SORT_EXTENDED, '@id desc');





$res = $s->query($content,'*');//$content="古迹遗址";
//var_dump($res);

if(!empty($res['matches']))
	$ids = array_keys($res['matches']);
//var_dump($ids);
$str=join(",",$ids);
//var_dump($str);
$result=$this->db->query("select id,linename,status,addtime,lineday from u_line where id in ({$str})")->result_array();
//var_dump($result);


?>




<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>sphinx测试</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="旅游线路,旅游网,旅游管家,旅游攻略,自助游" />
<meta name="description" content="帮游旅行网是中国专业全面的一站式旅游服务平台，首创性地推出一帮一游旅游服务理念，数万名旅游管家为您提供周边游、主题游、跟团游、自驾游、游记攻略等共五万多种一对一旅游产品服务。热线4000965166。" />


<style>
	img{display: block;}
</style>


</head>

<body style=" background:#fff">

<div style="width:960px;height:auto;margin:20px auto;">

<form action="" method="post">

   <p>搜索内容:<input type="text" name="content" class="input_con" value="<?php echo !empty($content)?$content:''; ?>" />
   状态:<input type="text" name="status" class="input_con" value="<?php echo !empty($status)?$status:''; ?>" />
   出游天数:<input type="text" name="day" class="input_con" value="<?php echo !empty($day)?$day:''; ?>" />
   <input type="submit" value="提交" name="btn_submit" class="btn_submit" style="margin:0 0 0 20px;" />
   </p>


</form>
</div>


<p style="background: #666;color:#fff;width:960px;text-align:left;font-size:12px;line-height:24px;height:24px;margin:0 auto;">搜索结果</p>

<div style="width:960px;height:auto;margin:20px auto;">
<?php 



if(empty($result))
	echo "未找到任何线路";
else 
{
	foreach ($result as $k=>$v)
	{
		echo "线路id：".$v['id']."&nbsp;&nbsp;线路名称:".$v['linename']."&nbsp;&nbsp;添加时间:".$v['addtime']."&nbsp;&nbsp;状态:".$v['status']."&nbsp;&nbsp;出游天数:".$v['lineday']."<br /><br />";
	}
}





?>
</div>







</body>
</html>

				
					

