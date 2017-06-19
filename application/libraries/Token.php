<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * token验证
 * @version 1.0
 * @author hejun
 *
 * 使用方法
 $this->load->library ( 'token' );
 
 *
 *
 *
 */

class Token {
	public function __construct() {
		$this->CI = & get_instance ();
	}
	
	/**
	 * 获取token,并保存
	 */
	public function getToken($mid) {
		$this->CI->load->model ( "access_token_model" );
		$whereArr = array(
				"mid" => $mid
		);
		$n = $this->CI->access_token_model->row ( $whereArr );
		if (! empty ( $n )) {
			$time = time ();
			$token = md5 ($mid.$time );
			$dataArr = array(
					"access_token" => $token,
					"access_token_validtime" => $time
			);
			$re = $this->CI->access_token_model->update( $dataArr, $whereArr );
			if ($re > 0) {
				$this->arr=array(
						"key" => $token,
						"time" => $time						
				);
				return json_encode ( $this->arr );
			}
		}else{			
			$time = time ();
			$token = md5 ($mid.$time );
			$dataArr = array(
					"mid"=>$mid,
					"access_token" => $token,
					"access_token_validtime" => $time
			);
			$re = $this->CI->access_token_model->insert( $dataArr, $whereArr );
			if ($re > 0) {
				$this->arr=array(
						"key" => $token,
						"time" => $time						
				);
				return json_encode ( $this->arr );
			}
		}		
	}
	
	/**
	 * 校验token
	 * @param unknown $token
	 * @return boolean
	 */
	
	public function isValidToken($token) {
		$this->CI->load->model ( "access_token_model" );
		if (! empty ( $token )) {
			$re = $this->CI->access_token_model->row ( array(
					"access_token" => $token 
			) );
			if (! empty ( $re )) {
				$time = time ();
				$time = $time - $re['access_token_validtime'];
				if ($time < 86400) {
					return true;
				}
			}
		}
		return false;
	}
	
	
	/**
	 * 获取专家token
	 */
	public function expert_get_Token($eid) {
		$this->CI->load->model ( "expert_access_token_model" );
		$whereArr = array(
				"eid" => $eid
		);
		$n = $this->CI->expert_access_token_model->row ( $whereArr );
		if (! empty ( $n )) {
			$key = random_string ();
			$time = time ();
			$token = md5 ($key.$eid.$time );
			$dataArr = array(
					"access_token" => $token,
					"access_token_validtime" => $time
			);
			$re = $this->CI->expert_access_token_model->update( $dataArr, $whereArr );
			if ($re > 0) {
				$this->arr=array(
						"key" => $token,
						"time" => $time
				);
				return json_encode ( $this->arr );
			}
		}else{
			$key = random_string ();
			$time = time ();
			$token = md5 ($key.$eid.$time );
			$dataArr = array(
					"eid"=>$eid,
					"access_token" => $token,
					"access_token_validtime" => $time
			);
			$re = $this->CI->expert_access_token_model->insert( $dataArr, $whereArr );
			if ($re > 0) {
				$this->arr=array(
						"key" => $token,
						"time" => $time
				);
				return json_encode ( $this->arr );
			}
		}
	}
	
	/**
	 * 校验专家token
	 * @param unknown $token
	 * @return boolean
	 */
	
	public function expert_isValidToken($token) {
		$this->CI->load->model ( "expert_access_token_model" );
		if (! empty ( $token )) {
			$re = $this->CI->expert_access_token_model->row ( array(
					"access_token" => $token
			) );
			if (! empty ( $re )) {
				$time = time ();
				$time = $time - $re['access_token_validtime'];
				if ($time < 86400) {
					return true;
				}
			}
		}
		return false;
	}
	
	
	
	
}
/* End of Library */