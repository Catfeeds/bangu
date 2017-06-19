<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * @目的地载入
 * @path：controllers/tools/cities.php
 * ===================================================================
 * 目的地联动
 * 
 * ===================================================================
 * @类别：通用工具
 * @作者：何俊 （junhey@qq.com）v1.0 Final
 */
class Cities extends CI_Controller {
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		$this->load->library ( 'session' );
		$this->load->database();
	}
	private $id;
	private $province;
	private $city;
	private $tableName="u_dest_base";
	/**
	 * 获得省份列表
	 */
	public function getProvinceList(){
		$tableName=$this->tableName;
		$sql="select id,kindname from ".$tableName." where pid='0'";
		$res=$this->db->query($sql);
		$res=$res->result_array();
		$result_msg="-1";
		$result_code="4000";
		$result_data=array();
		if( sizeof($res)!=0 ){
			$result_msg="success";
			$result_code="2000";
			$result_data=$res;
		}
		$resJSON=json_encode(
				array(
						"code"=>$result_code,
						"msg"=>$result_msg,
						"data"=>$result_data
				)
		);
		print_r($resJSON);
	}
	/**
	 * 获得市级列表
	 */	
	public function getCitiesList(){
		$pid=$this->input->get('pid');
		$tableName=$this->tableName;
	
		$sql="select id,kindname from ".$tableName." where pid='".$pid."'";
		$res=$this->db->query($sql);
		$res=$res->result_array();
		$result_msg="-1";
		$result_code="4000";
		$result_data=array();
		if( sizeof($res)!=0 ){
			$result_msg="success";
			$result_code="2000";
			$result_data=$res;
		}
		$resJSON=json_encode(
				array(
						"code"=>$result_code,
						"msg"=>$result_msg,
						"data"=>$result_data
				)
		);
		print_r($resJSON);
	}
	
	
}
/* End of file Cities.php */
/* Location: ./application/controllers/tools/cities.php */