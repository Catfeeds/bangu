<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年4月21日16:09:00
 * @author		贾开荣
 *
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Line_attr extends UA_Controller {
	const pagesize = 10;
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/line_attr_model', 'line_model' );
	}
	public function __destruct(){
		$this ->db ->close();
	}

	/**
	 * 贾开荣
	 * 线路属性列表
	 */
	public function attr_list() {
		$page_now = $this->input->get ( 'page', true );
		$status = $this->input->get ( 'status', true );
		$name = $this->input->get ( 'name', true );
		$status = empty ( $status ) ? 1 : $status;
		if ($status == 1)
			$where = array (
					'isopen' => 1
			);
		else
			$where = array (
					'isopen' => 0
			);
		$like = array();
		if (! empty ( $name ))
			$like ['attrname'] = trim($name);

		$this->load->helper ( 'url' );
		$this->load->library ( 'Page' ); // 加载分页类
		$config ['pagecount'] = $this->line_model->num_rows_total ( $where ,$like); // 获取查询结果的条数
		$config ['pagesize'] = self::pagesize;

		$config ['page_now'] = empty ( $page_now ) ? 0 : $page_now;
		$config ['base_url'] = "/admin/a/line_attr/attr_list?status={$status}&name={$name}&page=";
		$this->page->initialize ( $config );
		$data ['line_list'] = $this->line_model->get_line_attr_list ( $where, $config ['page_now'], $config ['pagesize'] ,$like);
		// var_dump($data);
		foreach ( $data ['line_list'] as &$val ) {
			if ($val ['pid'] == 0) {
				$val ['pattrname'] = '无';
				continue;
			}
			$this->db->select ( 'attrname' );
			$this->db->from ( 'u_line_attr' );
			$this->db->where ( array (
					'id' => $val ['pid']
			) );
			$query = $this->db->get ();
			$info = $query->result_array ();
			$val ['pattrname'] = $info [0] ['attrname'];
		}

		$data ['status'] = $status;
		$data ['name'] = $name;
		$this->load_view ( 'admin/a/ui/line_attr/line_attr_list', $data );
	}
	public function get_one() {
		$id = $this->input->post ( 'id', true );
		$this->db->select ( 'id,attrname' );
		$this->db->from ( 'u_line_attr' );
		$this->db->where ( array (
				'pid' => 0
		) );
		$query = $this->db->get ();
		$parent = $query->result_array ();
		$data = array (
				'parent' => $parent
		);

		$attr_data = $this->line_model->get_line_attr_list ( array (
				'id' => $id
		) );
		$data ['line'] = $attr_data [0];
		$this->db->select ( 'attrname' );
		$this->db->from ( 'u_line_attr' );
		if ($data ['line'] ['pid'] != 0) {
			$this->db->where ( array (
					'id' => $data ['line'] ['pid']
			) );
			$query = $this->db->get ();
			$info = $query->result_array ();
			$data ['pattrname'] = $info [0] ['attrname'];
		} else {
			$data ['pattrname'] = '无';
		}
		unset ( $data ['line'] ['id'] );
		unset ( $data ['line'] ['litpic'] );
		unset ( $data ['line'] ['isopen'] );
		$data ['pid'] = $data ['line'] ['pid'];
		unset ( $data ['line'] ['pid'] );
		// var_dump($data);exit;
		echo json_encode ( $data );
	}

	/**
	 * 贾开荣
	 * 获取上级分类
	 */
	public function get_parent() {
		$this->db->select ( 'id,attrname' );
		$this->db->from ( 'u_line_attr' );
		$this->db->where ( array (
				'pid' => 0
		) );
		$query = $this->db->get ();
		$parent = $query->result_array ();
		echo json_encode ( $parent );
	}

	/**
	 * 贾开荣
	 * 编辑属性
	 */
	public function edit_attr() {
		$attrname = $this->input->post ( 'attrname', true );
		$pid = intval ( $_POST ['pid'] );
		$id = intval ( $_POST ['id'] );
		$displayorder = $this->input->post ( 'displayorder', true );
		$description = $this->input->post ( 'description', true );
		if (empty ( $attrname )) {
			echo json_encode ( array (
					'status' => - 1,
					'msg' => '请填写属性名称'
			) );
			exit ();
		}
		$data = array (
				'pid' => $pid,
				'attrname' => $attrname,
				'displayorder' => $displayorder,
				'description' => $description
		);
		$status = $this->line_model->update ( $data, array (
				'id' => $id
		) );
		if (empty ( $status )) {
			echo json_encode ( array (
					'status' => - 2,
					'msg' => '操作失败'
			) );
			exit ();
		} else {
			$this ->log(3,3,"平台基础设置->线路属性管理","平台编辑线路属性,记录ID:{$id}");
			echo json_encode ( array (
					'status' => 1,
					'msg' => '操作成功'
			) );
			exit ();
		}
	}

	/*
	 * 禁用属性
	 */
	public function attr_disable() {
		$id = $this->input->post ( 'id', true );
		$is = $this->input->post ( 'is', true );
		if ($is == 2) {
			$data = array (
					'isopen' => 0
			);
			$log_message = "平台禁用线路属性,记录ID:{$id}";
		} else {
			$data = array (
					'isopen' => 1
			);
			$log_message = "平台启用线路属性,记录ID:{$id}";
		}
		$status = $this->line_model->update ( $data, array (
				'id' => $id
		) );
		if (empty ( $status )) {
			echo json_encode ( array (
					'status' => - 1,
					'msg' => '操作失败'
			) );
			exit ();
		} else {
			$this ->log(5,3,"平台基础设置->线路属性管理",$log_message);
			echo json_encode ( array (
					'status' => 1,
					'msg' => '操作成功'
			) );
			exit ();
		}
	}

	/**
	 * 贾开荣
	 * 添加线路属性
	 */
	public function add_attr() {
		$attrname = $this->input->post ( 'attrname', true );
		$pid = intval ( $_POST ['pid'] );
		$displayorder = intval ( $_POST ['displayorder'] );
		$description = $this->input->post ( 'description', true );

		if (empty ( $attrname )) {
			echo json_encode ( array (
					'status' => - 1,
					'msg' => '请填写属性名称'
			) );
			exit ();
		}
		$data = array (
				'attrname' => $attrname,
				'pid' => $pid,
				'isopen' => 1,
				'displayorder' => $displayorder,
				'description' => $description
		);
		$status = $this->line_model->insert ( $data );
		if (empty ( $status )) {
			echo json_encode ( array (
					'status' => - 2,
					'msg' => '添加失败'
			) );
			exit ();
		} else {
			$id = $this ->db ->insert_id();
			$this ->log(1,3,"平台基础设置->线路属性管理","平台添加线路属性,记录ID:{$id}");
			echo json_encode ( array (
					'status' => 1,
					'msg' => '添加成功'
			) );
			exit ();
		}
	}
}