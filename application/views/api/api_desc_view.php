<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" >	
    <title><?php echo $service;?> - 在线接口文档</title>
	
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/apidesc/semantic.min.css');?>" />		
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/apidesc/components/table.min.css');?>" />	
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/apidesc/components/container.min.css');?>" />	
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/apidesc/components/message.min.css');?>" />	
<link rel="stylesheet" type="text/css" href="<?php echo base_url('static/apidesc/components/label.min.css');?>" />		
	
<style>
.methodslist{
	padding:5px 15px 5px 5px;
}
</style>
</head>

<body>


<br /> 
    <div class="ui text container" style="max-width: none !important;">

<div>
    <?php foreach($class_methods as $v){?>
        <a href="<?php echo base_url('api').'/apidesc?service='.$version .'.'. $classname.'.'.$v ;?>" class="methodslist"><?php echo $v;?></a>
    <?php } ?>
</div>	
	
        <div class="ui floating message">

<h2 class='ui header'>接口：<?php echo base_url('api').'/'. str_replace(".","/",$service);?></h2><br/> <span class='ui teal tag label'><?php echo $description;?></span>

            <div class="ui raised segment">
                <span class="ui red ribbon label">接口说明</span>
                <div class="ui message">
                    <p><?php echo $descComment;?></p>
                </div>
            </div>
            <h3>接口参数</h3>
            <table class="ui red celled striped table" >
                <thead>
                    <tr><th>参数名字</th><th>类型</th><th>是否必须</th><th>默认值</th><th>其他</th><th>说明</th></tr>
                </thead>
                <tbody>
<?php 

foreach ($rules as $key => $rule) {
    $name = $rule['name'];
    if (!isset($rule['type'])) {
        $rule['type'] = 'string';
    }
    $type = isset($typeMaps[$rule['type']]) ? $typeMaps[$rule['type']] : $rule['type'];
    $require = isset($rule['require']) && $rule['require'] ? '<font color="red">必须</font>' : '可选';
    $default = isset($rule['default']) ? $rule['default'] : '';
    if ($default === NULL) {
        $default = 'NULL';
    } else if (is_array($default)) {
        $default = json_encode($default);
    } else if (!is_string($default)) {
        $default = var_export($default, true);
    }

    $other = '';
    if (isset($rule['min'])) {
        $other .= ' 最小：' . $rule['min'];
    }
    if (isset($rule['max'])) {
        $other .= ' 最大：' . $rule['max'];
    }
    if (isset($rule['range'])) {
        $other .= ' 范围：' . implode('/', $rule['range']);
    }
    $desc = isset($rule['desc']) ? trim($rule['desc']) : '';

    echo "<tr><td>$name</td><td>$type</td><td>$require</td><td>$default</td><td>$other</td><td>$desc</td></tr>\n";
}
?>

                </tbody>
            </table>
            <h3>返回结果</h3>
            <table class="ui green celled striped table" >
                <thead>
                    <tr><th>返回字段</th><th>类型</th><th>说明</th></tr>
                </thead>
                <tbody>
<?php 

foreach ($returns as $item) {
	$name = $item[1];
	$type = isset($typeMaps[$item[0]]) ? $typeMaps[$item[0]] : $item[0];
	$detail = $item[2];
	
	echo "<tr><td>$name</td><td>$type</td><td>$detail</td></tr>";
}

?>

            </tbody>
        </table>
        <div class="ui blue message">
          <strong>温馨提示：</strong> 此接口参数列表根据后台代码自动生成，可将 ?service= 改成您需要查询的接口/服务
        </div>
        <p>&copy; Powered  By <a href="http://www.haiwai.com/" target="_blank">HAIWAI 1.1.1</a> <p>
        </div>
    </div>
</body>
</html>