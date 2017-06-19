<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'sendcloud/lib/util/HttpClient.php';
require_once 'sendcloud/lib/SendCloud.php';
require_once 'sendcloud/lib/util/Mail.php';
require_once 'sendcloud/lib/util/Mimetypes.php';
/**
 * 类名：Send_email
 * 功能：邮件发送
 * 版本：1.3
 */
class Send_email
{
	const SEND_URL = 'http://api.sendcloud.net/apiv2/mail/send';
	const API_USER = 'bangu_test_LCABK3';
	const API_KEY = 'KZr4tADwKm2NGLLw';
	const API_FROM = '10000@1b1u.com';
	
	/**
	 * 发送邮件
	 * @param string $to 收件人，多个用分号分隔，至多100个
	 * @param string $title 邮件标题
	 * @param string $content 邮件内容
	 * @param string $summary 邮件摘要
	 */
	public function email($to,$title,$content,$summary='')
	{
		$param = array(
				'apiUser' => self::API_USER,
				'apiKey' => self::API_KEY,
				'from' => self::API_FROM,//发送人
				'fromName' => '帮游网络科技有限公司',
				'to' => $to,//'373254555@qq.com;1728742369@qq.com;33@qq.com',//收件人,至多100个
				'subject' => $title,//'发送标题！',
				'contentSummary' =>$summary,//'摘要',//邮件摘要. 该字段传入值后，若原邮件已有摘要，会覆盖原邮件的摘要；若原邮件中没有摘要将会插入摘要。了解邮件摘要的更多内容
				'html' => $content,//'<b>邮件测试内容</b>',
				//'labelId' =>'128015',//本次发送所使用的标签ID. 此标签需要事先创建
				'respEmailId' => 'true'
		);
	
		$data = http_build_query($param);
		$options = array(
				'http' => array(
						'method'  => 'POST',
						'header'  => 'Content-Type: application/x-www-form-urlencoded',
						'content' => $data
				));
	
		$context  = stream_context_create($options);
		$result = file_get_contents(self::SEND_URL, false, $context);
	
		return json_decode($result);
	}
	
}