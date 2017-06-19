<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'jpush/autoload.php';
use JPush\Client as JPush;
/**
 * 类名：jpush_app
 * 功能：app消息推送
 */
class Jpush_app {
 
	//jpush账号
	const APP_KEY = '4d6511260f93b0672df25325';
	const MASTER_SECRET = '7174066567c5341a15406807';

	/**
	 * 给APP用户推送消息
	 * @param string|array $sid 设备ID，群发消息时用数组保存
	 * @param string $content 推送的消息内容
	 * @param array $extras 推送消息时，附加信息，供业务使用
	 * @param string $override_msg_id 需要覆盖的前一条消息msgid
	 */
	public function push($sid ,$content ,$title='帮游' ,$extras=array() ,$override_msg_id='')
	{
		$client = new JPush(self::APP_KEY, self::MASTER_SECRET ,null);
		try
		{
			$response = $client->push()
			->setPlatform(['ios', 'android'])
			->addRegistrationId($sid) //接收消息的设备，可以是字符串或者数组
// 			->setNotificationAlert('alert') //简单地给所有平台推送相同的 alert 消息
			->iosNotification($content, [
			
					//extras:接受一个数组，自定义 Key/value 信息以供业务使用
					'extras' => $extras
			])
			->androidNotification($content,[
					//title:通知标题，会替换通知里原来展示 App 名称的地方
					'title' => $title,
					
					//extras:接受一个数组，自定义 Key/value 信息以供业务使用
					'extras' => $extras
			])
// 			->message($content, [
// 					//title:通知标题，会替换通知里原来展示 App 名称的地方
// 					'title' => $title,
			
// 					//content_type:消息内容类型
// 					'content_type' => 'text',
			
// 					//extras:接受一个数组，自定义 Key/value 信息以供业务使用
// 					'extras' => $extras
// 			])
			->options(array(
					// sendno: 表示推送序号，纯粹用来作为 API 调用标识，
					// API 返回时被原样返回，以方便 API 调用方匹配请求与返回
					// 这里设置为 100 仅作为示例
					//'sendno' => 100,
			
					// time_to_live: 表示离线消息保留时长(秒)，
					// 推送当前用户不在线时，为该用户保留多长时间的离线消息，以便其上线时再次推送。
					// 默认 86400 （1 天），最长 10 天。设置为 0 表示不保留离线消息，只有推送当前在线的用户可以收到
					// 这里设置为 1 仅作为示例
			
					//目前测试，设置为0
					'time_to_live' => 86400,
			
					//override_msg_id:表示要覆盖的消息ID，如果当前的推送要覆盖之前的一条推送，这里填写前一条推送的 msg_id 就会产生覆盖效果
					'override_msg_id' =>$override_msg_id,
					
					// apns_production: 表示APNs是否生产环境，
					// True 表示推送生产环境，False 表示要推送开发环境；如果不指定则默认为推送生产环境
			
					'apns_production' => true,
			
					// big_push_duration: 表示定速推送时长(分钟)，又名缓慢推送，把原本尽可能快的推送速度，降低下来，
					// 给定的 n 分钟内，均匀地向这次推送的目标用户推送。最大值为1400.未设置则不是定速推送
					// 这里设置为 1 仅作为示例
			
					// 'big_push_duration' => 1
			))
			->send();
			//var_dump($response);
			if (isset($response['http_code']))
			{
				if ($response['http_code'] == 200)
				{
					//数组信息
					return $response;
				}
				else 
				{
					return '发送失败，返回码：'.$response['http_code'];
				}
			}
			else 
			{
				return '发送失败-没有获取到返回状态码';
			}
		}
		catch (\JPush\Exceptions\APIConnectionException $e)
		{
			$info = explode('-', $e);
		   	if (isset($info[2]))
		   	{
		   		return $info[2];
		   	}
		   	else 
		   	{
		   		return '发送失败';
		   	}
		}
		catch (\JPush\Exceptions\APIRequestException $e)
		{
			$info = explode('-', $e);
		   	if (isset($info[2]))
		   	{
		   		return $info[2];
		   	}
		   	else 
		   	{
		   		return '发送失败';
		   	}
		}
	}
	
}