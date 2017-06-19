<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年3月20日11:59:53
 * @author		jiakairong
 * @method 		景区管理
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Review extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model ( 'scenic_spot_review_model', 'review_model' );
	}
	public function index()
	{
		$this->view ( 'admin/a/scenic_spot/review' );
	}
	//返回景点评论数据
	public function getReviewData()
	{
		$whereArr = array();
		$postArr = $this->security->xss_clean($_POST);
		
		if (!empty($postArr['name']))
		{
			$whereArr['s.name like'] = '%'.trim($postArr['name']).'%';
		}
		
		//获取数据
		$data = $this ->review_model ->getReviewData ($whereArr);
		//echo $this ->db ->last_query();
		echo json_encode($data);
	}
	//获取评论内容
	public function getContent()
	{
		$id = intval($this ->input ->post('id'));
		$reviewData = $this ->review_model ->row(array('id' =>$id));
		if (!empty($reviewData))
		{
			$picData = $this ->review_model ->getReviewPic($id);
			$dataArr = array(
					'content' =>$reviewData['content'],
					'picArr' =>$picData
			);
			echo json_encode($dataArr);
		}
	}
	//删除景点评论
	public function delete()
	{
		$id = intval($this ->input ->post('id'));
		$status = $this ->review_model ->delete(array('id' =>$id));
		if ($status == true)
		{
			$this ->log(2,3,'景点管理','删除景点评论,ID:'.$id);
			$this ->callback ->setJsonCode(2000 ,'删除成功');
		} else {
			$this ->callback ->setJsonCode(4000 ,'删除失败');
		}
	}
}