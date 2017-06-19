<?php
/**
 * @copyright 深圳海外国际旅行社有限公司
 * @author jiakairong
 * @since  2015-12-14
 * @method 用于线路的管家刷选
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class lineExpert extends UC_NL_Controller
{
	public $dataArr = array(
			'code' =>4000,
			'data' =>array(),
			'page_string' =>''
	);
	public function __construct()
	{
		parent::__construct ();
		//set_error_handler('customError');
		$this ->load_model('common/u_line_apply_model' ,'apply_model');
	}
	/**
	 * @method 管家选择，用于线路列表，线路详情，下单页
	 * @author jiakairong
	 * @since  2015-12-11
	 */
	public function choiceExpert()
	{
		$whereArr = array(
				'e.status' =>2,
				'e.is_commit' =>1,
				'la.status' =>2,
				'is_kf' =>'Y'
		);
		$postArr = $this->security->xss_clean($_POST);
		$userid = intval($this ->session ->userdata('c_userid'));
		$page_new = empty($postArr['page_new']) ? 1 :intval($postArr['page_new']);
		if (empty($postArr['line_id'])) //必须有线路
		{
			echo json_encode($this ->$dataArr);exit;
		}
		else
		{
			$whereArr['la.line_id'] = intval($postArr['line_id']);
		}
		if (!empty($postArr['ChoiceCityId']))
		{
			$whereArr['e.city'] = intval($postArr['ChoiceCityId']);
		}
		if (!empty($postArr['grade']))
		{
			$whereArr['la.grade'] = intval($postArr['grade']);
		}
		if (!empty($postArr['nickname']))
		{
			$whereArr['e.nickname'] = trim($postArr['nickname']);
		}
		switch($postArr['sort']) {
			case 1:
				$order_by = 'e.online desc,e.total_score desc ';
				break;
			case 2:
				//满意度
				$order_by = 'e.online desc,e.satisfaction_rate desc ';
				break;
			case 3:
				//年销人数
				$order_by = 'e.online desc,e.people_count desc ';
				break;
			case 4:
				//年成交额
				$order_by = 'e.online desc,e.order_amount desc ';
				break;
			default:
				$order_by = 'e.online desc,e.total_score desc ';
				break;
		}
		//数据
		$data = $this ->apply_model ->getLineExpert($whereArr , $page_new ,8 ,$order_by  ,$userid);
		//echo $this ->db ->last_query();
		//分页
		$this->load->library ( 'page_ajax' );
		$config['pagesize'] = 8;
		$config['page_now'] = $page_new;
		$config['pagecount'] = $data['count'];
		$this->page_ajax->initialize ( $config );
		$this ->dataArr = array(
				'code' =>2000,
				'data' =>$data['list'],
				'page_string' =>$this ->page_ajax ->create_page()
		);
		
		echo json_encode($this ->dataArr);
	}
}