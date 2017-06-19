<?php
/**
 * @copyright	深圳海外国际旅行社有限公司
 * @version		1.0
 * @since		2015年5月7日18:35:53
 * @author		jiakairong
 * @method 		首页分类目的地线路
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Kind_dest_line extends UA_Controller
{
	public function __construct()
	{
		parent::__construct ();
		$this->load_model('admin/a/index_kind_dest_line_model','dest_line_model');
	}

	public function index()
	{
		$this->view ( 'admin/a/cfg/kind_dest_line');
	}
	//获取目的地线路数据
	public function getDestLineData()
	{
		$whereArr = array();
		$name = trim($this ->input ->post('name' ,true));
		$cityid = intval($this ->input ->post('cityid'));
		$cityname = trim($this ->input ->post('cityname' ,true));
		$kindname = trim($this ->input ->post('kindname' ,true));
		$is_show = intval($this ->input ->post('isopen'));
		
		if (!empty($name))
		{
			$whereArr ['l.linename like'] = '%'.$name.'%';
		}
		
		if (!empty($kindname))
		{
			$whereArr['ikd.name like'] = '%'.$kindname.'%';
		}
		
		if (!empty($cityid))
		{
			$whereArr ['ikdl.startplaceid ='] = $cityid;
		}
		elseif (!empty($cityname))
		{
			$whereArr ['s.cityname like'] = '%'.$cityname.'%';
		}
		if ($is_show==0 || $is_show ==1)
		{
			$whereArr['ikdl.is_show ='] = $is_show;
		}
		else
		{
			$whereArr['ikdl.is_show >='] = 0;
		}
		
		$dataArr = array(
				'data' =>$this->dest_line_model->getData($whereArr),
				'count' =>$this->dest_line_model->getTotal($whereArr)
		);
		echo json_encode($dataArr);
	}
	//增加首页分类目的地线路
	public function add()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'add');
		$status = $this ->dest_line_model ->insert($dataArr);
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'添加失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(1,3,'首页分类目的地线路配置','增加首页分类目的地线路');
			$this->callback->setJsonCode ( 2000 ,'添加成功');
		}
	}
	//编辑首页分类目的地线路
	public function edit()
	{
		$postArr = $this->security->xss_clean($_POST);
		$dataArr = $this ->commonFunc($postArr, 'edit');
		$status = $this ->dest_line_model ->update($dataArr ,array('id' =>intval($postArr['id'])));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'编辑失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(3,3,'首页分类目的地线路配置','编辑首页分类目的地线路');
			$this->callback->setJsonCode ( 2000 ,'编辑成功');
		}
	}
	//添加编辑时公用
	public function commonFunc($postArr ,$type)
	{
		$city = empty($postArr['city']) ? 0 : intval($postArr['city']);
		$kindDestId = empty($postArr['kind_dest_id']) ? 0 : intval($postArr['kind_dest_id']);
		$lineId = intval($postArr['lineId']);
		$showorder = intval($postArr['showorder']);
		
		if(empty($kindDestId))
		{
			$this->callback->setJsonCode ( 4000 ,'请选择分类目的地');
		}
		if (empty($lineId)) 
		{
			$this->callback->setJsonCode ( 4000 ,'请选择线路');
		}
		else
		{
			if ($type == 'add')
			{
				$dataArr = $this ->dest_line_model ->row(array('line_id' =>$lineId ,'index_kind_dest_id' =>$kindDestId));
			}
			else
			{
				$dataArr = $this ->dest_line_model ->row(array('line_id'=>$lineId ,'index_kind_dest_id' =>$kindDestId,'id !='=>$postArr['id'] ));
			}
			if (!empty($dataArr))
			{
				$this->callback->setJsonCode ( 4000 ,'此分类目的地下已配置此线路');
			}
		}
		if (empty($postArr['pic']))
		{
			$this ->load_model('common/u_line_model' ,'line_model');
			$lineData = $this ->line_model ->row(array('id'=>$lineId) ,'arr' ,'' ,'mainpic');
			$pic = $lineData['mainpic'];	
		}
		else
		{
			$pic = $postArr['pic'];
		}
		
		return array(
				'index_kind_dest_id' =>$kindDestId,
				'line_id ' =>$lineId,
				'pic' =>$pic,
				'is_show' =>intval($postArr['is_show']),
				'beizhu' =>trim($postArr['beizhu']),
				'showorder' =>empty($showorder) ? 999 : $showorder,
				'startplaceid' =>$city
		);
	}
	
	//删除首页分类目的地线路
	public function delete()
	{
		$id = intval($this->input->post('id'));
		$status = $this ->dest_line_model ->update(array('is_show' =>-1) ,array('id'=>$id));
		if (empty($status))
		{
			$this->callback->setJsonCode ( 4000 ,'删除失败');
		}
		else
		{
			$this->cache->redis->delete('SYDestLine');
			$this ->log(2,3,'首页分类目的地线路配置','平台删除首页分类目的地线路');
			$this->callback->setJsonCode ( 2000 ,'删除成功');
		}
	}
	
	//获取某条数据
	public function getDetailJson ()
	{
		$id = intval($this ->input ->post('id'));
		$data=$this ->dest_line_model ->getDestLineDetail($id);
		if (!empty($data))
		{
			echo json_encode($data[0]);
		}
	}
	
	/**
	 * @method 获取首页一级分类以及分类目的地
	 * @since  2015-11-24
	 */
	public function getStartKindDest()
	{
		$cityId = intval($this ->input ->post('cityId'));
		$kindArr = array();
		$this ->load_model('admin/a/index_kind_dest_model','kind_dest_model');
		$kindDest = $this ->kind_dest_model ->getStartKindDest($cityId);
		if (!empty($kindDest))
		{
			foreach($kindDest as $val)
			{
				if (!array_key_exists($val['index_kind_id'], $kindArr))
				{
					$kindArr[$val['index_kind_id']]['name'] = $val['kind_name'];
				}
				$kindArr[$val['index_kind_id']]['lower'][] = $val;
			}
		}
		echo json_encode($kindArr);
	}

}