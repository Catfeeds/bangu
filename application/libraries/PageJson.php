<?php

if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * 分页实体类
 * 
 * @version 1.0
 * @author yijingwen
 */
class PageJson {
	var $totalPages = 0; // 总页数
	var $pageNum = 1; // 当前页
	var $totalRecords = 0; // 总记录数
	var $pageSize = 10; // 每页显示多少条数据
	var $records = null;
	var $orderCol = null; // 排序字段
	var $orderType = null; // 排序方式
	
	function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = $val;
				}
			}
		}
	}
	
	function getResult() {
		$result = '{';
		$result .= '"totalPages":"' . $this->totalPages . '",';
		$result .= '"totalRecords":"' . $this->totalRecords . '",';
		$result .= '"pageSize":"' . $this->pageSize . '",';
		$result .= '"pageNum":"' . $this->pageNum . '",';
		$result .= '"records":"' . $this->records . '",';
		$result .= '}';
	}
}