<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月3日16:43
* @method 		文章管理
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Article extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/article_model', 'article' );
	}
	

	public function index($page=1){
		$post_arr = array();
		$this->load->library('Page');
		$config['base_url'] = '/admin/a/article/index/';
		$config['pagesize'] = 10;
		$config['page_now'] = $this->uri->segment(5,0);
		$page = $page==0 ? 1:$page;

		$data['article_attr']=$this->article->all_article('u_article_attr',$post_arr,$page,$config['pagesize']);
		//print_r($this->db->last_query());exit();
		$config['pagecount'] = count($this->article->all_article('u_article_attr',$post_arr,0,$config['pagesize']));
		$this->page->initialize($config);
		$this->load_view ( 'admin/a/ui/index_config/article_category',$data);

	}
	//根据传来的数据判断是否是插入或更改
	public function insert_artCategory(){
		$type=$this->input->post('updata');
		$attr_name=$this->input->post('attr_name');
		$showorder=$this->input->post('showorder');
		$is_show=$this->input->post('is_show');
		if($attr_name==''){
			echo json_encode(array('status' =>-11 ,'msg' =>'请填写分类名称'));
			exit;
		}
		if($type=='updata'){    //更改
			$id=$this->input->post('cate_id');
			$dataArr['attr_name']=$attr_name;
			if(!empty($showorder)){
			  $dataArr['showorder']=$showorder;
			}
			$dataArr['ishome']=$is_show;
			$whereArr=array('id'=>$id);
			$status = $this->article->update($dataArr, $whereArr);
			$this->cache->redis->delete('SYhomeArticle');
			echo json_encode(array('status' =>1 ,'msg' =>'修改成功'));
			exit;
		}else{
			$data['attr_name']=$attr_name;
			if(!empty($showorder)){
			  $data['showorder']=$showorder;
			}
			$data['ishome']=$is_show;

			$status = $this ->db ->insert('u_article_attr',$data);
			$this->cache->redis->delete('SYhomeArticle');
			echo json_encode(array('status' =>1 ,'msg' =>'添加成功'));
			exit;
		}
	}

	//取单条文章分类的信息
	public function get_category(){
		$id=$this->input->post('id');
		$where=array('id'=>$id);
		$art_category=$this->article->all_article('u_article_attr',$where);

		echo json_encode ( $art_category[0] );
	}
	//文章列表
	public function art_list($page = 1){
		//文章分类
		$data['article_attr']=$this->article->all_article('u_article_attr',array(),0,40);

		$this->load->library ( 'Page' ); // 加载分页类
		$config['base_url'] = '/admin/a/article/art_list/';
		$config ['pagesize'] = 10;
		$config ['page_now'] = $this->uri->segment ( 5, 0 );
		$post_arr=array();
		$config ['pagecount'] = count($this->article->art_list($post_arr, 0, $config['pagesize']));
		$data['art'] = $this->article->art_list($post_arr, $page, $config['pagesize']);
		$this->page->initialize ( $config );
		$this->load_view ( 'admin/a/ui/index_config/article_list',$data);

	}
	//删除文章分类
	public function del_cate(){
		$id=$this->input->post('id');
		$status=$this->db->delete('u_article_attr', array('id' => $id));
		$this->cache->redis->delete('SYhomeArticle');
		echo  $status;
	}

	//删除文章
	public function del_art(){
		$id=$this->input->post('id');
		$status=$this->db->delete('u_article', array('id' => $id));
		$this->cache->redis->delete('SYhomeArticle');
		echo  $status;
	}
	//根据传来的文章数据判断是否是插入或更改
	public function insert_art(){
		//启用session
		$this->load->library ( 'session' );
		$admin_id = $this->session->userdata ( 'a_user_id' );

		$type=$this->input->post('updata');
	    	$title=$this->input->post('title');
		$showorder=$this->input->post('showorder')=='' ? 999 : $this->input->post('showorder');
		$attr_name=$this->input->post('attr_name');
		$content=$this->input->post('content');
		if($attr_name==''){
			echo json_encode(array('status' =>-11 ,'msg' =>'请选择分类名称'));
			exit;
		}
		if($title==''){
			echo json_encode(array('status' =>-11 ,'msg' =>'请填写标题'));
			exit;
		}

		if($content==''){
			echo json_encode(array('status' =>-11 ,'msg' =>'请填写文章内容'));
			exit;
		}
		if($type=='updata'){    //更改
			$id=$this->input->post('art_id');
			$dataArr=array(
					'title'=>$title,
					'content'=>$content,
					'showorder'=>$showorder,
					'modtime'=>date ("Y-m-d H:i:s" ,time()),
					'admin_id'=>$admin_id,
					'attrid'=>$attr_name,
			);
			$whereArr=array('id'=>$id);
			$status = $this->article->updata_table('u_article',$dataArr, $whereArr);
			$this->cache->redis->delete('SYhomeArticle');
			echo json_encode(array('status' =>1 ,'msg' =>'修改成功'));
			exit;
		}else{          //插入
			$data=array(
					'title'=>$title,
					'content'=>$content,
					'showorder'=>$showorder,
					'addtime'=>date ("Y-m-d H:i:s" ,time()),
					'admin_id'=>$admin_id,
					'attrid'=>$attr_name,
			);
			$status = $this ->db ->insert('u_article',$data);
			$this->cache->redis->delete('SYhomeArticle');
			echo json_encode(array('status' =>1 ,'msg' =>'添加成功'));
		}
	}

	//取单条文章的信息
	public function get_art(){
		$id=$this->input->post('id');
		$where=array('id'=>$id);
		$art=$this->article->all_article('u_article',$where);

		echo json_encode ( $art[0] );
	}
}
