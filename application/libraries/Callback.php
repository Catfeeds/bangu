<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * 返回数据封装
 * @version 1.0
 * @author hejun
 *
 * 使用方法
$this->load->library ( 'callback' );
$cid = $this->input->post ( 'cid' );
$whereArr = array(
		'cid' => $cid 
);
$re = $this->user_model->search_user( $whereArr );
if ($re > 0) {
	$this->callback->set_code ( 2000 ,"查到数据");
} else {
	$this->callback->set_code ( 4000 ,"没有查询到数据");
}
echo $this->callback->getJson ();
$this->callback->exit_json();
return true;
 *
 *
 *
 */
class Callback {
	public $arr;
	public function __construct() {
		$this->info = array(
				"code" => 4000, 
				"data" => array(), 
				"msg" => '操作失败'
		);
	}
	
	/**
	 * 设置返回码
	 */
	public function set_code($code, $msg = '') {
		$this->arr['code'] = $code;		
		$this->arr['msg'] = $msg;
		return true;
	}
	
	/**
	 * 设置数据
	 */
	public function set_data($data) {
		if (is_array ( $data )) {
			$this->arr['data'] = $data;
		} else {
			$this->arr['data'] = array(
					$data 
			);
		}
	}

	/**
	 * 设置返回结果和数据
	 */
	public function set_code_data($code, $data = ''){
		$this->arr['code'] = $code;
		if (is_array ( $data )) {
			$this->arr['data'] = $data;
		} else {
			$this->arr['data'] = array(
					$data
			);
		}
	}
	/**
	 * 得出json数据
	 */
	public function get_json() {
		$json = json_encode ( $this->arr );
		return $json;
	}
	
	/**
	 * 打印json数据
	 */
	public function exit_json() {
		$json = json_encode ( $this->arr );
		exit ( $json );
	}
	
	public function setJsonCode($code ,$msg='')
	{
		exit(json_encode(array('code' =>$code ,'msg' =>$msg)));
	}
	/**
	 * @method 输出json or jsonp 格式数据，终止代码向下执行
	 * @author jkr
	 * @since  2016-03-29
	 * @param number $code
	 * @param string $msg
	 */
	public function exitJsonCode($code=4000 ,$msg='')
	{
		$json_callback = empty($_REQUEST['callback']) ? '' : $_REQUEST['callback'];
		if (empty($json_callback))
		{
			exit(json_encode(array('code' =>$code ,'msg' =>$msg)));
		}
		else 
		{
			exit($json_callback . "(" . json_encode(array('code' =>$code ,'msg' =>$msg)) . ")");
		}
	}
	/**
	 * @method 输出json or jsonp 格式数据，代码可向下继续执行
	 * @author jkr
	 * @since  2016-03-29
	 * @param number $code
	 * @param string $msg
	 */
	public function echoJsonCode($code=4000 ,$msg='')
	{
		$json_callback = empty($_REQUEST['callback']) ? '' : $_REQUEST['callback'];
		if (empty($json_callback))
		{
			echo json_encode(array('code' =>$code ,'msg' =>$msg));
		}
		else
		{
			echo $json_callback . "(" . json_encode(array('code' =>$code ,'msg' =>$msg)) . ")";
		}
	}
}
/* End of Library */