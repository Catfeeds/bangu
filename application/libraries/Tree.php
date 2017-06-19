<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
/**
 * 树型数据结构操作
 *
 * @author 何俊
 */
class Tree {
	public $treeArr = array(); // 需要遍历的树数组，需要具备节点id及父节点id
	public $fkey = 'fid'; // 目标父节点的Key
	public $key = 'id'; // 当前目标节点的Key
	public $node = 'name'; // 节点名称的key
	public function init($params = array()) {
		if (count ( $params ) > 0) {
			foreach ( $params as $key => $val ) {
				if (isset ( $this->$key )) {
					$this->$key = $val;
				}
			}
		}
	}
	/**
	 * 遍历所有子节点id
	 *
	 * @param Array $category        	
	 * @param String $cid        	
	 * @return Array
	 */
	public function cnode($id) {
		$arr = array();
		foreach ( $this->treeArr as $n ) {
			if ($n[$this->fkey] == $id) {
				$arr[] = $n[$this->key];
			}
		}
		foreach ( $arr as $n ) {
			$sarr = $this->cnode ( $n );
			foreach ( $sarr as $v ) {
				array_push ( $arr, $v );
			}
		}
		return $arr;
	}
	
	/**
	 * 遍历当前节点的初代子节点
	 *
	 * @param string $id        	
	 */
	public function fcnode($id) {
		$arr = array();
		foreach ( $this->treeArr as $n ) {
			if ($n[$this->fkey] == $id) {
				$arr[] = $n;
			}
		}
		return $arr;
	}
	/**
	 * 根节点路径计算
	 *
	 * @param string $id
	 *        	当前节点id
	 * @param string $end
	 *        	结束节点id，默认为0
	 */
	public function path($id, $end = 0) {
		$p = "";
		try {
			// exit($id);
			// exit(var_dump($this->treeArr));
			while ( $id != 0 && ! empty ( $id ) && is_array ( $this->treeArr ) ) {
				// exit(var_dump($this->treeArr));
				foreach ( $this->treeArr as $n ) {
					if ($n[$this->key] == $id) {
						$p = "<li cid=\"{$n[$this->key]}\">" . $n[$this->node] . "</li>" . $p;
						$id = $n[$this->fkey]; // 获取父文件夹id进行迭代
					}
				}
			}
		} catch ( Exception $e ) {
			log_message ( 'error', 'Tree > Path Algorithm Error' );
			exit ();
		}
		return $p;
	}
	/**
	 * 计算当前节点父节点id
	 */
	public function fid($id) {
		$value = 0;
		foreach ( $this->treeArr as $n ) {
			if ($n[$this->key] == $id) {
				$value = $n[$this->fkey];
				break;
			}
		}
		return $value;
	}
	/**
	 * 获取当前节点的名称
	 * @param unknown $id
	 * @return Ambigous <string, unknown>
	 */
	public function name($id) {
		$name = "";
		foreach ( $this->treeArr as $n ) {
			if ($n[$this->key] == $id) {
				$name = $n[$this->node];
				break;
			}
		}
		return $name;
	}
}
?>