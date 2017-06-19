<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Contract extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('contract_model');
	}
	
	public function index()
	{
		//获取公章
		$chapterData = $this ->contract_model ->getContractChapter();
		$dataArr = array(
				'chapterData' =>$chapterData
		);
		
		$this ->view('admin/a/ui/contract' ,$dataArr);
	}
	//首页管家数据获取
	public function getContractData()
	{
		$whereArr = array();
		$data = $this ->contract_model ->getContractData($whereArr);
		foreach($data['data'] as $k=>$v)
		{
			$data['data'][$k]['content'] = strip_tags($v['content']);
		}
		echo json_encode($data);
	}
	//合同详细
	public function getContractDetail()
	{
		$id = intval($this ->input ->post('id'));
		$contract = $this ->contract_model ->row(array('id' =>$id));
		echo json_encode($contract);
	}
	//编辑
	public function edit()
	{
		$id = intval($this ->input ->post('id'));
		$content = $this ->input ->post('content');
		$status = $this ->db ->where(array('id' =>$id)) ->update('u_contract' ,array('content' =>$content));
		if ($status == false) 
		{
			$this ->callback ->setJsonCode(4000 ,'编辑失败');
		} 
		else
		{
			$this ->callback ->setJsonCode(2000 ,'编辑成功');
		}
	}
	//更新合同公章
	public function updateChapter()
	{
		$pic = trim($this ->input ->post('pic'));
		if(empty($pic))
		{
			$this ->callback ->setJsonCode(4000 ,'请上传公章');
		}
		
		$dataArr = array(
				'bangu_chapter' =>$pic,
				'admin_id' =>$this ->admin_id,
				'modtime' =>date('Y-m-d H:i:s' ,time())
		);
		
		$chapter = $this ->db ->where('id' ,1) ->get('b_contract_chapter_bangu')->row_array();
		if (empty($chapter))
		{
			$dataArr['addtime'] = $dataArr['modtime'];
			$status = $this ->db ->insert('b_contract_chapter_bangu' ,$dataArr);
		}
		else 
		{
			$status = $this ->db ->where('id' ,1) ->update('b_contract_chapter_bangu' ,$dataArr);
		}
		
		
		if ($status == false)
		{
			$this ->callback ->setJsonCode(4000 ,'操作失败');
		}
		else 
		{
			$this ->callback ->setJsonCode(2000 ,'操作成功');
		}
		
	}
	
}