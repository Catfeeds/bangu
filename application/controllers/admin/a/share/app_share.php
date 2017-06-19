<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since  2016-07-27
 * @author jiakairong
 * @method 目的地管理
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class App_share extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this ->load_model('share/app_share_model' ,'app_share_model');
	}
	
	public function index()
	{
		$this->view ( 'admin/a/share/app_share');
	}
	
	public function getData()
	{
		$whereArr = array();
		$code = trim($this ->input ->post('code' ,true));
		$type = trim($this ->input ->post('type' ,true));
		
		if ($type == 'C' || $type=='B')
		{
			$whereArr['type ='] = $type;
		}
		if (!empty($code))
		{
			$whereArr['code ='] = $code;
		}
		
		$dataArr['data'] = $this ->app_share_model ->getData($whereArr);
		$dataArr['count'] = $this ->app_share_model ->getNum($whereArr);
		echo json_encode($dataArr);
	}
	//编辑页面
	public function edit_app_share()
	{
		$iconArr = array(
				//用户分享管家主页
				'ehome' =>array(
						array('name'=>'管家头像','icon'=>'eHeaderimg'),
						//array('name'=>'用户头像','icon'=>'userHeaderimg')
				),
				//管家分享服务直播
				'bslive' =>array(
						array('name'=>'管家头像','icon'=>'eHeaderimg'),
						array('name'=>'直播封面图','icon'=>'liveImg')
				),
				//管家分享短视频
				'bsvideo' =>array(
						array('name'=>'管家头像','icon'=>'eHeaderimg'),
						array('name'=>'直播封面图','icon'=>'liveImg')
				),
				//管家分享直播
				'blive' =>array(
						array('name'=>'管家头像','icon'=>'eHeaderimg'),
						array('name'=>'直播封面图','icon'=>'liveImg')
				),
				//管家分享个人页面
				'bhome' =>array(
						array('name'=>'管家头像','icon'=>'eHeaderimg')
				),
				//管家分享产品
				'bproduct' =>array(
						array('name'=>'管家头像','icon'=>'eHeaderimg'),
						array('name'=>'产品图','icon'=>'product')
				),
				//用户短视频分享
				'svideo' =>array(
						array('name'=>'用户头像','icon'=>'userHeaderimg'),
						array('name'=>'直播封面图','icon'=>'liveImg')
				),
				//用户直播分享
				'live' =>array(
						array('name'=>'用户头像','icon'=>'userHeaderimg'),
						array('name'=>'直播封面图','icon'=>'liveImg')
				),
				//用户产品分享
				'product' =>array(
						array('name'=>'产品图','icon'=>'product'),
						array('name'=>'用户头像','icon'=>'userHeaderimg')
				)
		);
		$btsArr = array(
				//用户分享管家主页
				'ehome' =>array(
						array('name'=>'管家名称','var'=>'{ename}')
				),
				//管家分享服务直播
				'bslive' =>array(
						array('name'=>'管家名称','var'=>'{ename}'),
						array('name'=>'直播地址','var'=>'{place}'),
						array('name'=>'直播用户名字','var'=>'{useName}'),
						array('name'=>'视频标题','var'=>'{videoTitle}')
				),
				//管家分享短视频
				'bsvideo' =>array(
						array('name'=>'管家名称','var'=>'{ename}'),
						array('name'=>'直播地址','var'=>'{place}'),
						array('name'=>'直播用户名字','var'=>'{useName}'),
						array('name'=>'视频标题','var'=>'{videoTitle}')
				),
				//管家分享直播
				'blive' =>array(
						array('name'=>'管家名称','var'=>'{ename}'),
						array('name'=>'直播地址','var'=>'{place}'),
						array('name'=>'直播用户名字','var'=>'{useName}'),
						array('name'=>'视频标题','var'=>'{videoTitle}')
				),
				//管家分享个人页面
				'bhome' =>array(
						array('name'=>'管家名称','var'=>'{ename}')
				),
				//管家分享产品
				'bproduct' =>array(
						array('name'=>'管家名称','var'=>'{ename}'),
						array('name'=>'线路名称','var'=>'{lineName}'),
						array('name'=>'品牌名称','var'=>'{brand}')
				),
				//用户短视频分享
				'svideo' =>array(
						array('name'=>'直播地址','var'=>'{place}'),
						array('name'=>'直播用户名字','var'=>'{useName}'),
						array('name'=>'视频标题','var'=>'{videoTitle}')
				),
				//用户直播分享
				'live' =>array(
						array('name'=>'直播地址','var'=>'{place}'),
						array('name'=>'直播用户名字','var'=>'{useName}'),
						array('name'=>'视频标题','var'=>'{videoTitle}')
				),
				//用户产品分享
				'product' =>array(
						array('name'=>'线路名称','var'=>'{lineName}'),
						array('name'=>'品牌名称','var'=>'{brand}')
				),
		);
		
		$id = intval($this ->input ->get('id'));
		$share = $this ->app_share_model ->row(array('id =' =>$id));
		
		$btsAll = array('{place}','{useName}','{videoTitle}','{brand}','{lineName}','{ename}');
		foreach($btsAll as $v)
		{
			$str = '<span contenteditable="false" class="bts-var">'.$v.'</span>';
			$share['title'] = str_replace($v,$str,$share['title']);
			$share['desc'] = str_replace($v,$str,$share['desc']);
		}
		
		$dataArr = array(
			'share'=>$share,
			'iconArr'=>$iconArr,
			'btsArr'=>$btsArr
		);
		if (!empty($dataArr))
		{
			$this ->view('admin/a/share/edit_app_share' ,$dataArr);
		}
	}
	
	//编辑数据
	public function edit()
	{
		$id = intval($this->input->post('id'));
		$title = strip_tags(trim($this->input->post('title' ,true)));
		$desc = strip_tags(trim($this->input->post('desc' ,true)));
		$imgUrl = trim($this->input->post('imgUrl' ,true));
		//$link = trim($this->input->post('link' ,true));
		if (empty($title))
		{
			$this->callback->setJsonCode(4000 ,'请填写标题');
		}
		if (empty($desc))
		{
			$this->callback->setJsonCode(4000 ,'请填写描述');
		}
		if (empty($imgUrl))
		{
			$this->callback->setJsonCode(4000 ,'请选择图标');
		}
		$dataArr = array(
				'title'=>$title,
				'desc'=>$desc,
				'imgUrl'=>$imgUrl,
				//'link'=>$link
		);
		$status = $this->app_share_model->update($dataArr ,array('id'=>$id));
		if ($status === false)
		{
			$this->callback->setJsonCode(4000 ,'操作失败');
		}
		else
		{
			$this->callback->setJsonCode(2000 ,'操作成功');
		}
	}
}