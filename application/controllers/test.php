<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @author 何俊
 */
use PhpOffice\PhpWord\PhpWord;
include_once '/application/controllers/msg/t33_send_msg.php';
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Test extends UC_NL_Controller {
	public function __construct()
	{
		parent::__construct ();
	}
	
	public function index()
	{
		$this ->load_model('dest/dest_cfg_model' ,'dest_model');
		$destData = $this ->dest_model ->getLowerData(2);
		var_dump($destData);
	}
	
	public function geohash()
	{
		$this->load->library('Geohash');
		$longitude = '114.127119';
		$latitude = '22.608549';
		//一个hash值代表一块区域
		$geohash = $this->geohash->encode_geohash($latitude, $longitude, 6);
		echo $geohash;
// 		$expands = $this->geohash->getGeoHashExpand($geohash);
// 		var_dump($expands);
//insert into position (`longitude`,`latitude`,`point`,`name`) values('113.960759','22.579753',GeomFromText('POINT(113.960759 22.579753)'),'西丽')
		
		

// 		select st_distance_sphere(point(114.127119, 22.608549), point(114.095864, 22.57388)) as distance;
	}
	
	public function geohash1() {
		$longitude = '114.128059';
		$latitude = '22.608449';
		$deep = 12;
		
		$BASE32 = '0123456789bcdefghjkmnpqrstuvwxyz';
		$bits = array(16,8,4,2,1);
		//纬度区间
		$lat = array(-90.0, 90.0);
		//经度区间
		$lon = array(-180.0, 180.0);
			
		$bit = $ch = $i = 0;
		$is_even = true;
		$i = 0;
		$mid;
		$geohash = '';
		while($i < $deep)
		{
			if ($is_even)
			{
				//经度区间的中间值
				$mid = ($lon[0] + $lon[1]) / 2;
				//根据经度与中间值得大小，重新设置经度区间
				if($longitude > $mid)
				{
					// |位运算符，
					$ch |= $bits[$bit];
					$lon[0] = $mid;
				}else{
					$lon[1] = $mid;
				}
			} else{
				//纬度区间的中间值
				$mid = ($lat[0] + $lat[1]) / 2;
				//根据纬度与中间值得大小，重新设置纬度区间
				if($latitude > $mid)
				{
					$ch |= $bits[$bit];
					$lat[0] = $mid;
				}else{
					$lat[1] = $mid;
				}
			}
			
			//true和false交替变换，让经度纬度交替计算
			$is_even = !$is_even;
			
			if ($bit < 4)
			{
				$bit++;;
			}
			else 
			{
				$i++;
				$geohash .= $BASE32[$ch];
				$bit = 0;
				$ch = 0;
			}
		}
		
		echo $geohash;
	}
	
	//C端下单，国内出游人模板
	public function excleNamesGN()
	{
		$num = intval($this ->input ->get('num'));
		$this->load->library ( 'PHPExcel' );
		$this->load->library ( 'PHPExcel/IOFactory' );
		$style_array = array('font' => array('bold' => true),'alignment' => array('horizontal' => 		PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
		$one_style_array = array_pop($style_array);
		$objPHPExcel = new PHPExcel ();
		$objPHPExcel->getProperties ()->setTitle ( "export" )->setDescription ( "none" );
		$objPHPExcel->setActiveSheetIndex ( 0 );
		
		$objActSheet = $objPHPExcel->getActiveSheet ();
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 15 );
		$objActSheet->setCellValue ( "A1", '姓名' );
		$objActSheet->getStyle ( 'A1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 50 );
		$objActSheet->setCellValue ( "B1", '性别' );
		$objActSheet->getStyle ( 'B1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'C' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "C1", '证件类型' );
		$objActSheet->getStyle ( 'C1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'D' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "D1", '证件号码' );
		$objActSheet->getStyle ( 'D1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'E' )->setWidth ( 25 );
		$objActSheet->setCellValue ( "E1", '出生日期' );
		$objActSheet->getStyle ( 'E1' )->applyFromArray ($style_array);
		$objActSheet->getColumnDimension ( 'F' )->setWidth ( 15 );
		$objActSheet->setCellValue ( "F1", '手机号' );
		$objActSheet->getStyle ( 'F1' )->applyFromArray ($style_array);
		
		$i=0;
		for($i ;$i<$num ;$i++)
		{
			$dataArr = $this ->getName();
			$objActSheet->setCellValueExplicit ( 'A' . ($i + 2), $dataArr['name'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'A' . ($i + 2) )->applyFromArray ($one_style_array);
			
			//性别
			$objActSheet->setCellValueExplicit ( 'B' . ($i + 2), $dataArr['sex'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'B' . ($i + 2) )->applyFromArray ($one_style_array);
			
			//证件类型
			$objActSheet->setCellValueExplicit ( 'C' . ($i + 2), '身份证', PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'C' . ($i + 2) )->applyFromArray ($one_style_array);
			
			$dataArr = $this ->craeteIDcard();
			//证件号码
			$objActSheet->setCellValueExplicit ( 'D' . ($i + 2), $dataArr['idcard'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'D' . ($i + 2) )->applyFromArray ($one_style_array);
			
			//出生日期
			$objActSheet->setCellValueExplicit ( 'E' . ($i + 2), $dataArr['brithday'], PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'E' . ($i + 2) )->applyFromArray ($one_style_array);
			
			//手机号
			$mobile = $this ->createMobile();
			$objActSheet->setCellValueExplicit ( 'F' . ($i + 2), $mobile, PHPExcel_Cell_DataType::TYPE_STRING );
			$objActSheet->getStyle ( 'F' . ($i + 2) )->applyFromArray ($one_style_array);
		}
		
		$objWriter = IOFactory::createWriter ( $objPHPExcel, 'Excel2007' );
		list( $ms, $s ) = explode ( ' ', microtime () );
		$ms = sprintf ( "%03d", $ms * 1000 );
		$g_session = date ( 'YmdHis' ) . "_" . $ms . "_" . rand ( 1000, 9999 );
		$file = "file/b2/upload/" . $g_session . ".xlsx";
		$objWriter->save ( $file );
		
		
		header('Content-Description: File Transfer');
		
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		readfile($file);
		
		//echo '/'.$file;
		//$this ->callback ->setJsonCode(2000 ,'/'.$file);
	}
	
	//获取姓名
	public function getName()
	{
		$nameArr = array('李嘉运','张震驰','许贤然','赵初运','吴琛龙','王家福','王裕胤','孔海爵','朱震腾','李骏权','曹晨晨','杨佑震','吕起晨','马晨帝','苗泽栋','张骏谷','李祜初','马禧凡','宋休杰','许辰梁','曹玲蕾','孔淑欢','陈怡岚','许香月','李珊嘉','宋初娅','许美霞','宋茜梦','张正怡','曹锦桂','秦涵采','秦彦家','覃珍娜','苏萱冰','苏家琪','苏妍枫','谢惠寒','谢寒初','严桂静','严芳呈','严欣心','范倩莲','范芝格','范莉楠','李雪冰','张初薇','杜彩鑫','杜芝彤','杜曦涵','何彩彩','何珊雅','何杉美','何香格','何莲锦','贾可欣','廖寒可','廖蓓欣','廖云萱','贾丽灵','姬欢雪','姬锦曦','李漫馨','王琛茹','贾歆梦','张莲欣','宋雪初');
		$key = mt_rand(0,count($nameArr)-1);
		
		$sex = $key <= 19 ? '男' : '女';
		return array(
				'sex' =>$sex,
				'name' =>$nameArr[$key]
		);
	}
	
	//生成身份证和出生日期
	public function craeteIDcard()
	{
		$firstArr = array('422801','110101','110102','110103','422822','422921','430302','430404','423325','142629','142626','150101','150122','150202','150403','150422','152122','152130','152222','152527','152531','152727','152921','210105','210106','210222','211282','211382');
		$firstStr = $firstArr[mt_rand(0,27)];
		$year = mt_rand(1960,2016);
		$month = mt_rand(1,12);
		if ($month<10)
		{
			$month = '0'.$month;
		}
		$day = mt_rand(1,28);
		if ($day < 10)
		{
			$day = '0'.$day;
		}
		$idcard = $firstStr.$year.$month.$day.mt_rand(1234,9999);
		$birthday = $year.'/'.$month.'/'.$day;
		return array(
				'idcard' =>$idcard,
				'brithday' =>$birthday
		);
	}
	
	//生成手机号码
	public function createMobile()
	{
		$first = array(13,15,18);
		return $first[mt_rand(0,2)].mt_rand(12300123,98746123);
	}
	
	public function sendMsgTest()
	{
		
		$msg = new T33_send_msg();
		
		$s =$msg ->applyQuotaMsg('1068',1,'甲壳虫');
		var_dump($s);
		//管家下单，申请额度，营业部经理
		//$msg ->sendMsgT33(array('code' =>'test' ,'step'=>1 ,'order_id'=>103448 ,'name'=>'管家测试'));
		//管家下单，申请额度，普通销售
		//$msg ->sendMsgT33(array('code' =>'ceshi' ,'step'=>1 ,'order_id'=>103436));
	}
	
	function aa() {

		$str = file_get_contents('http://www.google.cn/s?tbm=map&fp=1&gs_ri=maps&suggest=p&authuser=0&hl=zh-CN&pb=!2i3!4m12!1m3!1d18279961.54835399!2d104.195397!3d35.86166!2m3!1f0!2f0!3f0!3m2!1i1920!2i530!4f13.1!7i20!10b1!12m6!2m3!5m1!2b0!20e3!10b1!16b1!19m3!2m2!1i392!2i106!20m44!2m2!1i203!2i100!3m1!2i4!6m6!1m2!1i86!2i86!1m2!1i408!2i256!7m30!1m3!1e1!2b0!3e3!1m3!1e2!2b1!3e2!1m3!1e2!2b0!3e3!1m3!1e3!2b0!3e3!1m3!1e4!2b0!3e3!1m3!1e8!2b0!3e3!1m3!1e3!2b1!3e2!2b1!4b1!9b0!22m3!1sdZQxV6SlKdGGjwPD9brYCA!3b1!7e81!23m1!4b1!24m5!2b1!5m1!5b1!10m1!8e3!26m3!2m2!1i80!2i92!37m1!1e81!47m0!49m1!3b1&pf=p&tch=1&ech=13&psi=dZQxV6SlKdGGjwPD9brYCA.1462867034087.1&q:东乐大厦');
		echo $str;
	}
	
	public function testMsg()
	{
		$dataArr = array(
// 				'orderid' =>102760,
// 				'type' =>3,
// 				'yfid' =>289,
// 				'refundid' =>289
				'applyId' =>536
		);
		
		// 创建一个新cURL资源
		$ch = curl_init();
		//启用时会发送一个常规的POST请求
		curl_setopt($ch, CURLOPT_POST, 1);
		
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//设置cURL允许执行的最长秒数
		curl_setopt($ch, CURLOPT_TIMEOUT,30);
		//需要获取的URL地址
		//curl_setopt($ch, CURLOPT_URL,'xiaoxi.com/supplier/message_push/sendMsgOrder');
		curl_setopt($ch, CURLOPT_URL,'xiaoxi.com/supplier/message_push/applyQuotaSendMsg');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataArr);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		
		//抓取URL并把它传递给浏览器
		$result = curl_exec($ch);
		
		// 关闭cURL资源，并且释放系统资源
		curl_close($ch);
	}

	public function xx()
	{
		$this->load->helper ( 'cryp' );
		$key = 'jiakairong';
		$str = 'php加密测试';
		echo $encrypt = encrypt($str, $key);
		echo '<br />';
		echo $decrypt = decrypt($encrypt, $key);
	}
	
	public function createWordHF(){
// 		require_once '/application/libraries/PhpWord/PhpWord.php';
		
// 		$word = new PhpOffice\PhpWord\PhpWord();
		
		$this->load->library('Word');
// // 		$path = APPPATH.'libraries/PHPWord/PhpWord.php';
		
// // 		require_once __DIR__ . '/../bootstrap.php';
		
// // 		use PhpOffice\PhpWord\Settings;
// // // 		echo $path;
// // 		include_once($path);
// 		$phpWord = new PhpOffice\PhpWord\PhpWord();
		
// 		$section = $phpWord->addSection();
// 		$section->addTitle(htmlspecialchars('Welcome to PhpWord', ENT_COMPAT, 'UTF-8'), 1);
// 		$section->addText(htmlspecialchars('Hello World!', ENT_COMPAT, 'UTF-8'));
		
// 		// Saving the document as OOXML file...
// 		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// 		//print_r($phpWord);
// // 		echo base_url() . 'uploads/MyFile.docx';
// 		$objWriter->save( 'h://MyFile.docx' );
		
		//var_dump(str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
		$templateProcessor = new PhpOffice\PhpWord\TemplateProcessor('D:/xampp_junhey/htdocs/bangu/Sample_07_TemplateCloneRow.docx');
		//
		
		// Variables on different parts of document
		$templateProcessor->setValue('weekday', date('l'));            // On section/content
		$templateProcessor->setValue('time', date('H:i'));             // On footer
		$templateProcessor->setValue('serverName', realpath(__DIR__)); // On header
		
		// Simple table
		$templateProcessor->cloneRow('rowValue', 10);
		
		$templateProcessor->setValue('rowValue#1', 'Sun');
		$templateProcessor->setValue('rowValue#2', 'Mercury');
		$templateProcessor->setValue('rowValue#3', 'Venus');
		$templateProcessor->setValue('rowValue#4', 'Earth');
		$templateProcessor->setValue('rowValue#5', 'Mars');
		$templateProcessor->setValue('rowValue#6', 'Jupiter');
		$templateProcessor->setValue('rowValue#7', 'Saturn');
		$templateProcessor->setValue('rowValue#8', 'Uranus');
		$templateProcessor->setValue('rowValue#9', 'Neptun');
		$templateProcessor->setValue('rowValue#10', 'Pluto');
		
		$templateProcessor->setValue('rowNumber#1', '1');
		$templateProcessor->setValue('rowNumber#2', '2');
		$templateProcessor->setValue('rowNumber#3', '3');
		$templateProcessor->setValue('rowNumber#4', '4');
		$templateProcessor->setValue('rowNumber#5', '5');
		$templateProcessor->setValue('rowNumber#6', '6');
		$templateProcessor->setValue('rowNumber#7', '7');
		$templateProcessor->setValue('rowNumber#8', '8');
		$templateProcessor->setValue('rowNumber#9', '9');
		$templateProcessor->setValue('rowNumber#10', '10');
		
		// Table with a spanned cell
		$templateProcessor->cloneRow('userId', 3);
		
		$templateProcessor->setValue('userId#1', '1');
		$templateProcessor->setValue('userFirstName#1', 'James');
		$templateProcessor->setValue('userName#1', 'Taylor');
		$templateProcessor->setValue('userPhone#1', '+1 428 889 773');
		
		$templateProcessor->setValue('userId#2', '2');
		$templateProcessor->setValue('userFirstName#2', 'Robert');
		$templateProcessor->setValue('userName#2', 'Bell');
		$templateProcessor->setValue('userPhone#2', '+1 428 889 774');
		
		$templateProcessor->setValue('userId#3', '3');
		$templateProcessor->setValue('userFirstName#3', 'Michael');
		$templateProcessor->setValue('userName#3', 'Ray');
		$templateProcessor->setValue('userPhone#3', '+1 428 889 775');
		
// 		echo date('H:i:s'), ' Saving the result document...', EOL;
		$templateProcessor->saveAs('H:/Sample_07_TemplateCloneRow12.docx');
		
		echo getEndingNotes(array('Word2007' => 'docx'));
		if (!CLI) {
		    include_once 'Sample_Footer.php';
		}
		
		
	}

	//财付通手机归属地
	public function b($mobile) {
		$url = 'http://life.tenpay.com/cgi-bin/mobile/MobileQueryAttribution.cgi?chgmobile='.$mobile;
		$xml = file_get_contents($url);
		$result = xml_parser_create('UTF-8'); //建立XML解析器
		$status = xml_parse_into_struct($result, $xml, $values, $tags);//将 XML 数据解析到数组中
		xml_parser_free($result); //释放指定的 XML 解析器
		$city = '';
		$province = '';
		if ($status === 1)
		{
			foreach($values as $k =>$v)
			{
				$name = strtolower($v['tag']);
				if ($name == 'city')
				{
					$city = $v['value'];
				}
				else if ($name == 'province')
				{
					$province = $v['value'];
				}
			}
		}
		return $this ->getAreaId($province, $city);
	}

	//webservice手机归属地
	public function a($mobile) {
		$url = 'http://webservice.webxml.com.cn/WebServices/MobileCodeWS.asmx/getMobileCodeInfo';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "mobileCode=".$mobile."&userId=");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);
		$data = simplexml_load_string($data);
		if (strpos($data, 'http://'))
		{
			return  false;//手机号码格式错误
		}
		else
		{
			$str = mb_substr($data ,(mb_strpos($data ,'：')+1));
			$arr = explode(' ' ,$str);
			$city = empty($arr[1]) ? '' : $arr[1];
			$province = empty($arr[0]) ? '' : $arr[0];
			return $this ->getAreaId($province, $city);
		}
	}
	public function c($mobile)
	{
		//$str = "callback({mobile:'13997786231',province:'湖北',isp:'中国移动',stock:'1',amount:'10000',maxprice:'0',minprice:'0',cityname:'恩施'}); ";
		$url = 'http://virtual.paipai.com/extinfo/GetMobileProductInfo?mobile='.$mobile.'&amount=10000&callname=getPhoneNumInfoExtCallback';
		$str = file_get_contents($url);
		$str = iconv(mb_detect_encoding($str),"UTF-8//IGNORE",$str);
		$province = '';
		$city = '';
		$arr = explode(',', $str);
		foreach($arr as $v)
		{
			if (strpos($v ,'province') !== false)
			{
				$p = explode("'", rtrim($v ,"'"));
				$province = empty($p[1]) ? '' : $p[1];
			}
			elseif (strpos($v ,'city') !== false)
			{
				$c = explode("'", $v);
				$city = empty($c[1]) ? '' : $c[1];
			}
		}
		return $this ->getAreaId($province, $city);
	}
	public function d($mobile)
	{
		$province = '';
		$city = '';
		$ch = curl_init();
	    $url = 'http://apis.baidu.com/showapi_open_bus/mobile/find?num='.$mobile;
	    $header = array(
	        'apikey: 8556055709979131267afffa968eaa75',
	    );
	    // 添加apikey到header
	    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    // 执行HTTP请求
	    curl_setopt($ch , CURLOPT_URL , $url);
	    $res = curl_exec($ch);
		$data = json_decode($res);//ret_code
		if ($data->showapi_res_body->ret_code === 0)
		{
			$province = empty($data ->showapi_res_body->prov) ? '' : $data ->showapi_res_body->prov;
			$city = empty($data ->showapi_res_body->city) ? '' : $data ->showapi_res_body->city;
		}
		return $this ->getAreaId($province ,$city);
	}
	//更改会员地址
	public function updateMember()
	{

		$sql = 'INSERT INTO  u_member_traver ( name, enname, certificate_type, certificate_no, endtime, country, telephone, sex, birthday, addtime, modtime, isman, member_id, ENABLE, sign_place, sign_time, people_type, cost, price ) SELECT NAME, enname, certificate_type, certificate_no, endtime, country, telephone, sex, birthday, addtime, modtime, isman, member_id, ENABLE, sign_place, sign_time, people_type, cost, price FROM u_order_travel_del WHERE order_id=102112 AND yf_id=8888';
		$query = $this->db->query($sql);

		var_dump($this->db->insert_id());exit();

	}

	//通过省份和城市名称获取其ID
	public function getAreaId($province ,$city)
	{
		$city_id = 0;
		$province_id = 0;
		$this->load_model('area_model');
		if (!empty($province))
		{
			$areaData = $this ->area_model ->row(array('name like' =>trim($province).'%' ,'level' =>2));
			if (!empty($areaData))
			{
				$province_id = $areaData['id'];
			}
		}
		if (!empty($city))
		{
			$areaData = $this ->area_model ->row(array('name like' =>trim($city).'%' ,'level' =>3));
			if (!empty($areaData))
			{
				$city_id = $areaData['id'];
			}
		}
		return array(
				'city_id' =>$city_id,
				'province_id' =>$province_id
		);
	}
}