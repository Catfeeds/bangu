<?php
if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
class apidesc extends CI_Controller {
	
    private $defaultversion='v2_3_11';//默认版本号
	
    public function __construct() {
        parent::__construct();
        header("content-type:text/html;charset=utf-8");
    }
	
	public function index() {        
        $service = $this->input->get('service', true); //服务名称
        $rules = array();
        $returns = array();
        $description = '';
        $descComment = '//请使用@desc 注释';
        $typeMaps = array(
            'string' => '字符串',
            'int' => '整型',
            'float' => '浮点型',
            'boolean' => '布尔型',
            'date' => '日期',
            'array' => '数组',
            'fixed' => '固定值',
            'enum' => '枚举类型',
            'object' => '对象',
        );
        $data = array();
		$class_methods = array();
        try {
			
		    $serviceArr = explode('.', $service);
            $cnum = count($serviceArr);
			if ($cnum < 2) {
				exit('service ('.$service.') illegal');
			}
			if($cnum==2){
				$version = $this->defaultversion;
			    list ($apiClassName, $action) = $serviceArr;
				$service = $version.'.' . $service ;
			}else{
			    list ($version,$apiClassName, $action) = $serviceArr;				
			}
			if ( ! file_exists(APPPATH.'controllers/api/'.strtolower($version).'/'.strtolower($apiClassName).'.php'))
			{
				exit("no ");
			}
			include_once(APPPATH.'controllers/api/'.strtolower($version).'/'.strtolower($apiClassName).'.php');			
			$apiClassName = ucfirst($apiClassName);
			// $action = lcfirst($action);
            
			if (!class_exists($apiClassName)) {
				exit('no such service as'.$service.'');
			}	
			$api = new $apiClassName();	
			$class_methods_api = get_class_methods($api);
			$class_methods_appci = array_unique(array_merge(get_class_methods('APP_Controller'),get_class_methods('CI_Controller')));
			$class_methods_appci[]='get_param_rules';
			//$class_methods_ci = get_class_methods('CI_Controller');
			$class_methods = array_diff($class_methods_api,$class_methods_appci);
            header("Content-type: text/html; charset=utf-8");  //文档为html格式			
            $rules = $this->getapirules($api,$version,$apiClassName, $action);
			unset($api);
        } catch (Exception $ex){
            $service .= ' - ' . $ex->getMessage();
			$data['service']	= $service;	
			$data['description']	= $description;
			$data['descComment']	= $descComment;	
			$data['rules']	= $rules;
			$data['typeMaps']	= $typeMaps;	
			$data['returns']	= $returns;				
			$this->load->view('api/api_desc_view', $data);
            //$this->api_desc_tpl($service,$description,$descComment,$rules,$typeMaps,$returns);
            //exit;
        }
        $methodName = $action;		
        $className = $apiClassName;
        $rMethod = new ReflectionMethod($className, $methodName);
        $docComment = $rMethod->getDocComment();
        $docCommentArr = explode("\n", $docComment);
        foreach ($docCommentArr as $comment) {
            $comment = trim($comment);

            //标题描述
            if (empty($description) && strpos($comment, '@') === false && strpos($comment, '/') === false) {
                $description = substr($comment, strpos($comment, '*') + 1);
                continue;
            }

            //@desc注释
            $pos = stripos($comment, '@desc');
            if ($pos !== false) {
                $descComment = substr($comment, $pos + 5);
                continue;
            }

            //@return注释
            $pos = stripos($comment, '@return');
            if ($pos === false) {
                continue;
            }

            $returnCommentArr = explode(' ', substr($comment, $pos + 8));
            //将数组中的空值过滤掉，同时将需要展示的值返回
            $returnCommentArr = array_values(array_filter($returnCommentArr));
            if (count($returnCommentArr) < 2) {
                continue;
            }
            if (!isset($returnCommentArr[2])) {
                $returnCommentArr[2] = '';	//可选的字段说明
            } else {
                //兼容处理有空格的注释
                $returnCommentArr[2] = implode(' ', array_slice($returnCommentArr, 2));
            }

            $returns[] = $returnCommentArr; 
        }

        $data['service']	= $service;	
        $data['description']	= $description;
        $data['descComment']	= $descComment;	
        $data['rules']	= $rules;
        $data['typeMaps']	= $typeMaps;	
        $data['returns']	= $returns;
        $data['class_methods']	= $class_methods;
        $data['classname']	= $className;
        $data['version']	= $version;		
        //$this->api_desc_tpl($service,$description,$descComment,$rules,$typeMaps,$returns);	
		$this->load->view('api/api_desc_view', $data);		
	}		
	

	
    /**
     * 取接口参数规则
     *
     * 主要包括有：
     * - 1、[固定]系统级的service参数
     * - 2、应用级统一接口参数规则，在app.apiCommonRules中配置
     * - 3、接口级通常参数规则，在子类的*中配置
     * - 4、接口级当前操作参数规则
     *
     * <b>当规则有冲突时，以后面为准。另外，被请求的函数名和配置的下标都转成小写再进行匹配。</b>
     *
     * @uses Api::getRules()
     * @return array
     */
    public function getapirules(&$api,$version,$apiClassName, $action) {
        $rules = array();

        $allRules = $api->get_param_rules();
        if (!is_array($allRules)) {
            $allRules = array();
        }

        $allRules = array_change_key_case($allRules, CASE_LOWER);

        $action = strtolower($action); 

        if (isset($allRules[$action]) && is_array($allRules[$action])) {
            $rules = $allRules[$action];
        }
        if (isset($allRules['*'])) {
            $rules = array_merge($allRules['*'], $rules);
        }
	
		if ( ! defined('ENVIRONMENT') OR ! file_exists($file_path = APPPATH.'config/'.ENVIRONMENT.'/apicommonrules.php'))
		{
			if ( ! file_exists($file_path = APPPATH.'config/apicommonrules.php'))
			{
				show_error('The configuration file apicommonrules.php does not exist.');
			}
		}
		include($file_path);		
        if (!empty($apicommonrules) && is_array($apicommonrules)) {
            $rules = array_merge($apicommonrules, $rules);
        }
        return $rules;
    }		
			
	
	
	public function api_desc_tpl($service,$description,$descComment,$rules,$typeMaps,$returns) {	
	
echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{$service} - 在线接口文档</title>

    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/semantic.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/table.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/container.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/message.min.css">
    <link rel="stylesheet" href="https://staticfile.qnssl.com/semantic-ui/2.1.6/components/label.min.css">

</head>

<body>

<br /> 

    <div class="ui text container" style="max-width: none !important;">
        <div class="ui floating message">

EOT;

echo "<h2 class='ui header'>接口：$service</h2><br/> <span class='ui teal tag label'>$description</span>";

echo <<<EOT
            <div class="ui raised segment">
                <span class="ui red ribbon label">接口说明</span>
                <div class="ui message">
                    <p>{$descComment}</p>
                </div>
            </div>
            <h3>接口参数</h3>
            <table class="ui red celled striped table" >
                <thead>
                    <tr><th>参数名字</th><th>类型</th><th>是否必须</th><th>默认值</th><th>其他</th><th>说明</th></tr>
                </thead>
                <tbody>
EOT;

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

echo <<<EOT
                </tbody>
            </table>
            <h3>返回结果</h3>
            <table class="ui green celled striped table" >
                <thead>
                    <tr><th>返回字段</th><th>类型</th><th>说明</th></tr>
                </thead>
                <tbody>
EOT;

foreach ($returns as $item) {
	$name = $item[1];
	$type = isset($typeMaps[$item[0]]) ? $typeMaps[$item[0]] : $item[0];
	$detail = $item[2];
	
	echo "<tr><td>$name</td><td>$type</td><td>$detail</td></tr>";
}

$version = '1.1.1';

echo <<<EOT
            </tbody>
        </table>
        <div class="ui blue message">
          <strong>温馨提示：</strong> 此接口参数列表根据后台代码自动生成，可将 ?service= 改成您需要查询的接口/服务
        </div>
        <p>&copy; Powered  By <a href="http://www.haiwai.com/" target="_blank">HAIWAI {$version}</a> <p>
        </div>
    </div>
</body>
</html>
EOT;
	
	}
	

}
