<?php
/**
 * 客户给专家的评论
 *
 * @copyright 深圳海外国际旅行社有限公司
 * @version 1.0
 * @since 2015年3月17日11:59:53
 * @author 徐鹏
 *
 */
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class Comment extends UB2_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load_model ( 'admin/b2/comment_model', 'comment' );
	}

	/**
	 * 客户给专家的评论
	 *
	 * @param number $page
	 *        	页
	 */
	public function index($page = 1) {
		$this->load->helper ( 'my_text' );
		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/b2/comment/index/';
		$config['pagesize'] = 15;
		$config['page_now'] = $this->uri->segment ( 5, 0 );
		$page = $page==0 ? 1:$page;
		$post_arr = array();
		if ($this->uri->segment ( 5 ) != '') {
			// 产品名称
			if ($this->session->userdata ( 'linename' ) != '') {
				$post_arr['l.linename LIKE'] = '%' . $this->session->userdata ( 'linename' ) . '%';
			}
		} else {
			unset ( $post_arr['l.linename LIKE'] );
			$this->session->unset_userdata ( 'linename' );
		}

		// 搜索表单提交
		if ($this->is_post_mode ()) {
			// 线路搜索
			if ($this->input->post ( 'linename' ) != '') {
				$post_arr['l.linename LIKE'] = '%' . $this->input->post ( 'linename' ) . '%';
				$this->session->set_userdata ( array(
						'linename' => $this->input->post ( 'linename' )
				) );
			} else {
				unset ( $post_arr['l.linename LIKE'] );
				$this->session->unset_userdata ( 'linename' );
			}
		}

		$post_arr['c.expert_id'] = $this->expert_id;
		$post_arr['c.status'] = 1;
		$config['pagecount'] = $this->comment->get_customer_comments ( $post_arr, 0);

		// $this->pagination->initialize($config);
		$this->page->initialize ( $config );
		$comment_list = $this->comment->get_customer_comments ( $post_arr, $page, $config['pagesize'] );
		//print_r($config['pagecount']);exit();
		$this->load_view ( 'admin/b2/comment', array(
				'comment_list' => $comment_list,
				'linename' => $this->session->userdata ( 'linename' )
		) );
	}
	function client_comment() {
		$comment_id = $this->input->post ( 'comment_id' );
		$comment_content = $this->input->post ( 'content' );
		/*$comment_sql = "UPDATE u_comment SET reply='$comment_content' where id=" . $comment_id;
		$this->db->query ( $comment_sql );*/
		$this->comment->reply_comment ($comment_content,$comment_id);
		redirect ( $_SERVER['HTTP_REFERER'] );
	}
}