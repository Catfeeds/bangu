<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Scenic_spot_review_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct ( 'scenic_spot_review' );
	}
	
	/**
	 * @method 获取景点评论数据，用于平台管理
	 * @author jkr
	 * @param array $whereArr
	 * @param string $orderBy
	 * @param string $specialSql
	 */
	public function getReviewData (array $whereArr ,$orderBy = 'sr.id desc',$specialSql='')
	{
		$sql = 'select sr.id,sr.nickname,sr.praise,sr.addtime,s.name,left(sr.content ,20) as content from scenic_spot_review as sr left join scenic_spot as s on s.id = sr.scenic_spot_id ';
		return $this ->getCommonData($sql ,$whereArr ,$orderBy,'',$specialSql);
	}
	
	public function getReviewPic($review_id)
	{
		$sql = 'select pic from scenic_spot_review_pic where review_id = '.$review_id;
		return $this ->db ->query($sql) ->result_array();
	}
}