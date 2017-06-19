<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
* @version		1.0
* @since		2015年6月3日16:43
* @method 		文章管理
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class ArticleAttr extends UA_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'admin/a/article_attr_model', 'attr_model' );
	}
	
	public function index() {
		$this ->load_view('admin/a/basics/article_category');
	}
	public function getArticleAttrData() {
		$whereArr = array();
		$page_new = intval($this ->input ->post('page_new'));
		$ishome = intval($this ->input ->post('search_ishome'));
		
		if ($ishome == 1 || $ishome === 0) {
			$whereArr ['ishome'] = $ishome;
		}
		//获取数据
		$data['list'] = $this ->attr_model ->result($whereArr ,$page_new ,sys_constant::A_PAGE_SIZE,'id desc');
		$count = $this->getCountNumber($this->db->last_query());
		$data ['page_string'] = $this ->getAjaxPage($page_new ,$count);
		echo json_encode($data);
	}
	//添加文章分类
	public function add() {
		$postArr = $this->security->xss_clean($_POST);
		try {
			if (empty($postArr['attr_name'])) {
				throw new Exception('请填写分类名称');
			} else {
				$attrData = $this ->attr_model ->row(array('attr_name' =>$postArr['attr_name']) ,'arr');
				if (!empty($attrData)) {
					throw new Exception('分类名称已存在');
				}
			}
			if (!empty($postArr['attr_code'])) {
				$attrData = $this ->attr_model ->row(array('attr_code' =>$postArr['attr_code']) ,'arr');
				if (!empty($attrData)) {
					throw new Exception('分类编号已存在');
				}
			}
			if ($postArr['ishome'] == 1) {
				$count = $this ->attr_model ->getIshomeCount();
				if ($count > 6) {
					throw new Exception('首页最多可以显示6个，不可再添加');
				}
			}
			$array = array(
				'attr_name' =>$postArr['attr_name'],
				'shortname' =>$postArr['shortname'],
				'attr_code' =>$postArr['attr_code'],
				'ishome' =>intval($postArr['ishome']),
				'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder'])
			);
			$status = $this ->attr_model ->insert($array);
			if (empty($status)) {
				throw new Exception('添加失败');
			} else {
				$this->cache->redis->delete('SYhomeArticle');
				$this ->log(1,3,'文章分类','增加文章分类');
				$this->callback->set_code ( 2000 ,'添加成功');
				$this->callback->exit_json();
			}
			
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
	}
	
	//编辑文章分类
	public function edit() {
		$postArr = $this->security->xss_clean($_POST);
		try {
			if (empty($postArr['attr_name'])) {
				throw new Exception('请填写分类名称');
			} else {
				$attrData = $this ->attr_model ->row(array('attr_name' =>$postArr['attr_name'] ,'id !='=>$postArr['id']) ,'arr');
				if (!empty($attrData)) {
					throw new Exception('分类名称已存在');
				}
			}
			if (!empty($postArr['attr_code'])) {
				$attrData = $this ->attr_model ->row(array('attr_code' =>$postArr['attr_code'] ,'id !=' =>$postArr['id']) ,'arr');
				if (!empty($attrData)) {
					throw new Exception('分类编号已存在');
				}
			}
			if ($postArr['ishome'] == 1) {
				$count = $this ->attr_model ->getIshomeCount();
				$attrData = $this ->attr_mode ->row(array('id' =>$postArr['id']) ,'arr');
				if ($attrData['ishome'] != 1) {
					if ($count > 6) {
						throw new Exception('首页最多可以显示6个，不可再增加');
					}
				} 
			}
			$array = array(
					'attr_name' =>$postArr['attr_name'],
					'shortname' =>$postArr['shortname'],
					'attr_code' =>$postArr['attr_code'],
					'ishome' =>intval($postArr['ishome']),
					'showorder' =>empty($postArr['showorder']) ? 999 : intval($postArr['showorder'])
			);
			$status = $this ->attr_model ->update($array ,array('id' =>$postArr['id']));
			if (empty($status)) {
				throw new Exception('编辑失败');
			} else {
				$this->cache->redis->delete('SYhomeArticle');
				$this ->log(3,3,'文章分类','编辑文章分类');
				$this->callback->set_code ( 2000 ,'编辑成功');
				$this->callback->exit_json();
			}
				
		} catch (Exception $e) {
			$this->callback->set_code ( 4000 ,$e->getMessage());
			$this->callback->exit_json();
		}
	}
	
	
	//获取某条数据
	public function getOneData () {
		$id = intval($this ->input ->post('id'));
		$whereArr=array('id'=>$id);
		$data=$this ->attr_model ->row($whereArr);
		if (!empty($data)) {
			echo json_encode($data);
		}
	}
	//删除
	public function delete() {
		$id = intval($this ->input ->post('id'));
		$articleCount = $this ->attr_model ->getAttrArticleCount($id);
		if ($articleCount == 0) {
			$status = $this ->attr_model ->delete(array('id' =>$id));
			if (empty($status)) {
				$this->callback->set_code ( 4000 ,"删除失败");
				$this->callback->exit_json();
			}
			else {
				$this->cache->redis->delete('SYhomeArticle');
				$this ->log(2,3,'文章分类',"平台删除文章分类,记录ID:{$id}");
				$this->callback->set_code ( 2000 ,"删除成功");
				$this->callback->exit_json();
			}
		} else {
			$this->callback->set_code ( 4000 ,"分类下有文章，不可删除");
			$this->callback->exit_json();
		}
	}
	
}
