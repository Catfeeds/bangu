<?php
/**
 * 测试全文搜索引擎
 *
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends UB2_Controller {

	public function index() {


		$ip  = $this->getIP();
		$arr = $this->GetIpLookup($ip);
		$this->dump($arr);
		/* $this->load->library('PHPExcel');
        		$this->load->library('PHPExcel/IOFactory');
        		 $objPHPExcel = new PHPExcel();
       		 $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        		$objPHPExcel->setActiveSheetIndex(0);
         		 $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Test');
		 $objPHPExcel->setActiveSheetIndex(0);
		 $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        		$file="file/b2/".date("YmdHis").".xlsx";
		$objWriter->save($file);
		echo "<a href=".base_url($file).">点击下载</a>";*/
		/*$this->load->library('SphinxClient');
		$this->sphinxclient->SetServer('localhost',9312);    //连接9312端口
		$this->sphinxclient->SetMatchMode(SPH_MATCH_ANY);    //设置匹配方式
		$this->sphinxclient->SetSortMode(SPH_SORT_RELEVANCE);    //查询结果根据相似度排序
		$this->sphinxclient->SetArrayResult(true);                //设置结果返回格式,true以数组,false以PHP hash格式返回，默认为false
		$result = $this->sphinxclient->query('双飞', 'mysql');//执行搜索操作,参数(关键词，索引名)
		 $this->dump($result);*/
	}




function getIP()
{
	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$realip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$realip = $_SERVER['REMOTE_ADDR'];
		}
	} else {
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$realip = getenv( "HTTP_X_FORWARDED_FOR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$realip = getenv("HTTP_CLIENT_IP");
		} else {
			$realip = getenv("REMOTE_ADDR");
		}
	}
	return $realip;
}




function GetIpLookup($ip = ''){
    if(empty($ip)){
        $ip = GetIp();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){ return false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    return $json;
}




	function dump($vars, $label = '', $return = false) {
		    if (ini_get('html_errors')) {
		        $content = " \n";
		        if ($label != '') {
		            $content .= "<strong>{$label} :</strong>\n";
		        }
		        $content .= htmlspecialchars(print_r($vars, true));
		        $content .= "\n \n";
		    } else {
		        $content = $label . " :\n" . print_r($vars, true);
		    }
		    if ($return) { return $content; }
		    echo $content;
		    return null;
		}


function send_email(){

	$email_content = "<font color='blue'>您的问题是:</font> 你是不是真的?</br><font color='green'>管家回复:</font> 我也不知道";
	$this->load->library('email');            //加载CI的email类

	        //以下设置Email参数
	        $config['protocol'] = 'smtp';
	        $config['smtp_host'] = 'smtp.exmail.qq.com';
	        $config['smtp_user'] = 'service@1b1u.net';
	        $config['smtp_pass'] = 'bangu0508';
	        $config['smtp_port'] = '25';
	        $config['charset'] = 'utf-8';
	        $config['wordwrap'] = TRUE;
	        $config['validate'] = TRUE;
	        $config['mailtype'] = 'html';
	        $config['crlf']="\r\n";
	         $config['newline']="\r\n";
	         //$this->load->library('email');
	        $this->email->initialize($config);

	        //以下设置Email内容
	        $this->email->from('service@1b1u.net', '帮游旅行网');
	        $this->email->to('296721605@qq.com');
	        $this->email->subject('管家回复您的提问');
	        $this->email->message($email_content);
	        //$this->email->attach('application\controllers\1.jpeg');           //相对于index.php的路径

 var_dump($this->email->send());
        //echo $this->email->print_debugger();
}

function test_trans(){
	$this->db->trans_begin();

	$this->db->query("insert into a_temp (`name`)values('wxf')");
	$this->db->query("insert into a_temp (`name`)values('wxf1')");
	$this->db->query("insert into a_temp (`name`)values('wxf2')");

	if ($this->db->trans_status() === FALSE)
	{
	    $this->db->trans_rollback();
	    echo 'Fail';
	}
	else
	{
	    $this->db->trans_commit();
	    var_dump($this->db->trans_status());
	}
}


function get_real_address(){
	$ch = curl_init();
	$data = array(
		'ip'=>'113.90.203.130'
		);

	curl_setopt( $ch, CURLOPT_URL, 'http://ip.taobao.com/service/getIpInfo.php');
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	$return = json_decode(curl_exec ( $ch ));
	curl_close ( $ch );
	echo $return->data->city;
}

function GetIpLookup_w(){
        $ip = '113.90.203.130';
    $res = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
    var_dump( $res );exit();
    if(empty($res)){ echo false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        echo false;
    }
    var_dump( $json );
}

function test_pdf(){
	header( 'Content-Type:text/html;charset=utf-8 ');
	$this->load->library('fpdf');
	$this->load->model('admin/t33/u_line_model','u_line_model');
	$line_id=1184; //$this->input->get("line_id",true);
	$return = $this ->u_line_model ->line_trip($line_id);
	$list= $return['result'];
	$line_row= $this ->u_line_model ->row(array('id'=>$line_id));
	$html="<meta http-equiv='Content-Type' content='text/html; charset=utf8'>
			<head>
			<title>线路行程</title>
			<style type='text/css'>
                          *{font-family:SimSun;}
				#jieshao{width:100%}
                    </style>
			</head>
			<body>
			    <div class='page-body' id='bodyMsg'>
			        <div class='order_detail'>
			           <div class='content_part'>
			                <div  style='text-align: center;font-size:17px;padding-bottom:22px;'>
			                    <span class='txt_info fl' style='font-family: Microsoft YaHei;width:100%;text-align:center;'>".$line_row['linename']."</span>
			                </div>
			                 <table class='order_info_table table_td_border' border='1' width='100%' cellspacing='0'>
			                    <tr height='40'>
			                        <td class='order_info_title'>费用包含:</td>
			                        <td colspan='3'> ".$line_row['feeinclude']." </td>
			                    </tr>
			                     <tr height='40'>
			                        <td class='order_info_title'>费用不包含:</td>
			                        <td colspan='3'> ".$line_row['feenotinclude']." </td>
			                    </tr>
			                     <tr height='40'>
			                        <td class='order_info_title'>签证说明:</td>
			                        <td colspan='3'> ".$line_row['visa_content']." </td>
			                    </tr>
			                     <tr height='40'>
			                        <td class='order_info_title'>购物自费:</td>
			                        <td colspan='3'> ".$line_row['other_project']." </td>
			                    </tr>
			                     <tr height='40'>
			                        <td class='order_info_title'>保险说明:</td>
			                        <td colspan='3'> ".$line_row['insurance']." </td>
			                    </tr>
			                    <tr height='40'>
			                        <td class='order_info_title'>温馨提示:</td>
			                        <td colspan='3'> ".$line_row['beizu']." </td>
			                    </tr>
			                     <tr height='40'>
			                        <td class='order_info_title'>安全提示:</td>
			                        <td colspan='3'> ".$line_row['safe_alert']." </td>
			                    </tr>
			                </table>
			            </div>";
			            if(!empty($list)){
				            	foreach ($list as $k=>$v) {
				            			$html .= "<div class='content_part'>
								                <div class='small_title_txt clear'>
								                    <span class='txt_info fl'>第".$v['day']."天</span>
								                </div>
								                <div style='padding:100px;width:20px'>".(isset($v['jieshao'])==true?$v['jieshao']:'')."</div>
								                 <table class='order_info_table table_td_border' border='1' width='100%' cellspacing='0'>
								                    <tr height='40'>
								                        <td class='order_info_title'>行程内容:</td>
								                        <td colspan='3'><div>".(isset($v['jieshao'])==true?$v['jieshao']:'')."</div></td>
								                    </tr>
								                     <tr height='40'>
								                        <td class='order_info_title'>用餐:</td>
								                        <td colspan='3' style='padding:5px;'>
								                                早餐：".($v['breakfirsthas']=='1'?$v['breakfirsthas']:'无')."<br/>
								                                中餐：".($v['lunchhas']=='1'?$v['lunchhas']:'无')."<br/>
								                                晚餐：".($v['supperhas']=='1'?$v['supperhas']:'无')."<br/>
								                        </td>
								                    </tr>
								                     <tr height='40'>
								                        <td class='order_info_title'>住宿情况:</td>
								                        <td colspan='3'>".(isset($v['hotel'])==true?$v['hotel']:'')."</td>
								                    </tr>
								                     <tr height='40'>
								                        <td class='order_info_title'>交通情况:</td>
								                        <td colspan='3'>".(isset($v['title'])==true?$v['title']:'')."</td>
								                    </tr>
								                     <tr height='40'>
								                        <td class='order_info_title'>相关图片:</td>
								                        <td colspan='3'>";
								                        if(!empty($v['pic_arr'])){
								                        		foreach ($v['pic_arr'] as $k=>$v) {
								                        			$html .="<img src='". BANGU_URL.$v."' height='80' />";
								                        		}
								                        }
								                        $html.="</td>
								                    </tr>
								                </table>
								            </div>";
								}
			            }else{
			            		 $html .= " <div class='no_data'>暂无行程</div>";
			            }
			        $html .= " </div></div></body>";

			        /* $font = Font_Metrics::get_font("yourfont", "normal");
				    $size = 9;
				    $y = $this->fpdf->get_height() - 24;
				    $x = $this->fpdf->get_width() - 15 - Font_Metrics::get_text_width("1/1", $font, $size);
				    $this->fpdf->->page_text($x, $y, "{PAGE_NUM}/{PAGE_COUNT}", $font, $size);}*/
			        //var_dump($html);exit();
			//false 代表下载; true代表在线预览
	$this->fpdf->Outpdf($html ,'线路行程.pdf' ,true);
}



}

