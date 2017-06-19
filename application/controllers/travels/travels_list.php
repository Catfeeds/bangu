<?php  use Think\Exception;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 旅游分享
 * @author HEJUN
 *
 */
class Travels_list extends UC_NL_Controller{
	public $pageNew = 1;
	public $whereArr = array(
			'tn.status' =>1,
			'tn.is_show' =>1
	);
	public $dataArr= array(
			'pid'=>0,
			'destid' =>0
	);
	public function __construct() {
		parent::__construct ();
		//set_error_handler('customError');
		$this->load_model ( 'travel_note_model', 'travel_model' );
		$this->load_model('dest/dest_base_model' ,'dest_base_model');
	}
	/**
	 * @method 游记列表
	 * @author jiakairong
	 * @since  2015-08-15
	 */
	public function index($url = '')
	{
		//解析url获取搜索条件
		$this ->analyticalUrl($url);
		$userid = $this ->session ->userdata('c_userid');
		//精华游记
		$whereArr = array(
			'tn.is_essence' =>1,
			'tn.status' =>1,
			'tn.is_show' =>1
		);
		$this ->dataArr['travelEssence'] = $this ->travel_model ->get_travel_data($whereArr ,1 ,6 ,'tn.id');
		//最新游记
		$this ->dataArr['travelDataNew'] = $this ->travel_model ->get_travel_data(array('tn.status' =>1,'tn.is_show' =>1) ,1 ,6 ,'tn.id');
		//最热游记
		$this ->dataArr['travelDataHot'] =$this ->travel_model ->get_travel_data(array('tn.status' =>1,'tn.is_show' =>1) ,1 ,6 ,'tn.shownum');
		//游记列表数据
		if ($userid > 0) //会员登录
		{
			$travelArr = $this ->travel_model ->getTravelData($this ->whereArr ,$this->pageNew ,12 , $userid);
		}
		else//会员未登录
		{
			$travelArr = $this ->travel_model ->get_travel_data($this ->whereArr ,$this->pageNew ,12,'tn.id' ,true);
		}

		foreach($travelArr['travelData'] as $key =>$val)
		{
			//获取游记目的地
			if (!empty($val['overcity']))
			{
				$travelArr['travelData'][$key]['destName'] = $this ->getDestName($val['overcity']);
			}
			else
			{
				$travelArr['travelData'][$key]['destName'] = '';
			}
		}
		//分页
		$this ->getPageStr($travelArr['count'], $url);
		//获取管家级别
		$this ->load_model('expert_grade_model' ,'grade_model');
		$gradeData = $this ->grade_model ->all();
		$grade = array();
		foreach($gradeData as $val) {
			$grade[$val['grade']] = $val['title'];
		}
		$this ->dataArr['grade'] = $grade;
		$this ->dataArr['travelData'] = $travelArr['travelData'];
		$this ->dataArr['destArr'] = $this ->getDestAll($url);
		$this ->getSeo($url);
		$this->load->view('travels/travels_list_view' ,$this->dataArr);
	}

	protected function getSeo($url)
	{
		$type = 0;
		$destid = 0;
		$urlArr = explode('_',$url);
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			switch($firstStr)
			{
				case 'd':
					$destid = empty($parameterArr[0]) ? 0 : intval($parameterArr[0]);
					$type = empty($parameterArr[1]) ? 0 : intval($parameterArr[1]);
					break;
			}
		}
		$this ->dataArr['title'] = '游记攻略_旅游攻略_自助游攻略_2016最新旅游游记-帮游旅行网';
		$this ->dataArr['keyword'] = '出境游攻略,国内游攻略,旅游攻略,游记攻略';
		$this ->dataArr['description'] = '帮游旅游网游记攻略，记录了驴友们出国旅游、国内旅游等旅游过程中的景点、线路、美食、住宿、交通、购物、风土人情各方面旅游攻略信息参考和下载，让您放心旅行。';
		switch($type)
		{
			case 1://出境
				$destArr = $this ->dest_base_model ->row(array('id' =>$destid));
				if (!empty($destArr))
				{
					$this ->dataArr['title'] = $destArr['kindname'].'游记攻略_2016最新出国旅游游记-帮游旅行网';
					$this ->dataArr['keyword'] = '游记攻略,出国旅游游记,'.$destArr['kindname'].'游记攻略';
					$this ->dataArr['description'] = '帮游旅行网'.$destArr['kindname'].'旅游游记攻略频道，整合了众多体验师与驴友们关于泰国旅游的点滴，为你分享更多关于'.$destArr['kindname'].'旅游的景点、酒店、美食等各方面的旅游资讯信息。';
				}
				break;
			case 2://国内
				$destArr = $this ->dest_base_model ->getDestPdata($destid);
				if (!empty($destArr))
				{
					$destArr = $destArr[0];
					$this ->dataArr['title'] = $destArr['kindname'].'游记攻略_2016最新'.$destArr['pname'].'旅游游记-帮游旅行网';
					$this ->dataArr['keyword'] = '游记攻略,'.$destArr['pname'].'旅游游记,'.$destArr['kindname'].'游记攻略';
					$this ->dataArr['description'] = '帮游旅行网'.$destArr['pname'].$destArr['kindname'].'旅游游记攻略频道，整合了众多体验师与驴友们关于'.$destArr['pname'].$destArr['kindname'].'旅游的点滴，为你分享更多关于泰国旅游的景点、酒店、美食等各方面的旅游资讯信息';
				}
				break;
		}
	}

	/**
	 * p:分页
	 * d:目的地
	 */
	/**
	 * @method 生成url地址
	 * @param unknown $url  地址栏的url参数部分
	 * @param unknown $type  参数的字母代号,如价格：pr
	 * @param string  $type1
	 */
	protected function createUrl($url ,$type ,$type1='')
	{
		$urlArr = explode('_',$url);
		$urlStr = '';
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			if ($type != $firstStr && $type1 != $firstStr)
			{
				$urlStr = $urlStr.'_'.$val;
			}
		}
		return '/youji/'.$urlStr;          // yj改为youji
	}
	/**
	 * @method 解析url地址
	 * @param unknown $url  地址栏的url参数部分
	 */
	protected function analyticalUrl($url)
	{
		$urlArr = explode('_',$url);
		foreach($urlArr as $val)
		{
			if (empty($val))
			{
				continue;
			}
			$parameterArr = explode('-' ,$val);
			$firstStr = array_shift($parameterArr);
			switch($firstStr)
			{
				case 'p':
					$this ->pageNew = empty($parameterArr['0']) ? 1 :intval($parameterArr['0']);
					break;
				case 'd':
					$this ->whereArr['l.overcity'] = isset($parameterArr['0']) ? intval($parameterArr['0']) : 0;
					$this ->dataArr['destid'] = $this ->whereArr['l.overcity'];
					$this ->dataArr['pid'] = isset($parameterArr['1']) ? intval($parameterArr['1']) : 0;
					break;
			}
		}
	}

	/**
	 * @method 分页
	 * @param unknown $page
	 * @param unknown $count
	 */
	protected function getPageStr ($count ,$url)
	{
		$this->load->library ( 'page' );
		$config['pagesize'] = 12;
		$config['page_now'] = $this ->pageNew;
		$config['pagecount'] = $count;
		$config['base_url'] = $this ->createUrl($url ,'p').'_p-';
		$config['suffix'] = '.html';
		$this->page->initialize ( $config );
	}

	/**
	 * @method 获取目的地名称
	 * @param unknown $overcity
	 */
	protected function getDestName($overcity)
	{
		$name = '';
		$whereArr = array(
				'in' =>array('id' =>$overcity),
				'level =' =>3
		);
		$destData = $this ->dest_base_model ->getDestBaseAllData($whereArr);
		if (!empty($destData))
		{
			foreach($destData as $val)
			{
				$name .= $val['name'].',';
			}
		}
		return rtrim($name ,',');
	}

	/**
	 * @method 获取目的地
	 * @since  2015-11-20
	 * @author jkr
	 */
	protected function getDestAll($url)
	{
		$url = $this ->createUrl($url ,'d' ,'p');
		$destData = $this ->dest_base_model ->all( array('level <='=>3) ,'pid asc,displayorder asc' ,'arr' ,'id,kindname,level,pid');
		$destArr = array();
		$threeArr = array();
		foreach($destData as $key =>$val)
		{
			if (empty($val['kindname']))
			{
				continue;
			}
			switch($val['level'])
			{
				case 1:
					$val['link'] = $url.'_d-'.$val['id'].'-'.$val['id'].'.html';
					$destArr[$val['id']] = $val;
					break;
				case 2:
					if (array_key_exists($val['pid'], $destArr))
					{
						$destArr[$val['pid']]['lower'][$val['id']] = $val;
					}
					break;
				case 3:
					$threeArr[] = $val;
					break;
			}
		}
		foreach($threeArr as $val)
		{
			foreach($destArr as $k=>$v)
			{
				if (isset($v['lower']) && array_key_exists($val['pid'], (array)$v['lower']))
				{
					$val['link'] = $url.'_d-'.$val['id'].'-'.$k.'.html';
					$destArr[$k]['lower'][$val['pid']]['lower'][] = $val;
				}
			}
		}
		return $destArr;
	}

	/**
	 * @method 游记点赞与取消
	 * @author jkr
	 */
	public function praise()
	{
		$this->load->library ( 'callback' );
		$id = intval($this ->input ->post('travel_id'));
		$userid = $this ->session ->userdata('c_userid');
		if (empty($userid))
		{
			$this->callback->set_code ( 9000 ,'请登陆');
			$this->callback->exit_json();
		}
		//判断用户是否点赞
		$data = $this ->travel_model ->getTravelPraise($id ,$userid);
		if (empty($data))
		{
			$this ->travelPraise($id ,$userid);
		}
		else
		{
			$this ->cancelPraise($id ,$userid);
		}

	}
	/**
	 * @method 游记点赞
	 * @author jkr
	 */
	public function travelPraise($id ,$userid)
	{
		$status = $this ->travel_model ->travelPraise($id ,$userid);
		if ($status == true)
		{
			$this->callback->set_code ( 2000 ,'praise');
			$this->callback->exit_json();
		}
		else
		{
			$this->callback->set_code ( 2000 ,'点赞失败');
			$this->callback->exit_json();
		}
	}

	/**
	 * @method 取消点赞
	 * @author jkr
	 */
	public function cancelPraise($id ,$userid)
	{
		$status = $this ->travel_model ->cancelPraise($id ,$userid);
		if ($status == true)
		{
			$this->callback->set_code ( 2000 ,'cancel');
			$this->callback->exit_json();
		}
		else
		{
			$this->callback->set_code ( 2000 ,'取消点赞失败');
			$this->callback->exit_json();
		}
	}

	public function release_travels(){
		$this->load->view('travels/release_travels_view');
	}

	/**
	 * @method 获取游记详情
	 * @author wangxiaofeng
	 * @since  2015-08-18
	 */
	public function travel_detail($travel_note_id=0,$user_type=0){
		$whereArr = array();
		//$travel_note_id = $this->input->get('tn_id');
		$shownum_sql = "update travel_note set shownum=shownum+1 where id=$travel_note_id";
		$this->db->query($shownum_sql);
		//$user_type = $this->input->get('user_type');
		$travel_note_detail = $this->travel_model->get_travel_detail($user_type,$travel_note_id);
		$travel_note_pic = $this->travel_model->get_travel_pic($travel_note_id);


		$total_comment = count ( $this->travel_model->get_comment( array('tn.id'=>$travel_note_id), 0, 10 ) );
		$relate_products = $this->travel_model->get_relate_products();
		$recommend_note = $this->travel_model->recommend_note();
		if(empty($travel_note_detail)){
			echo "<script>alert('没有该条游记记录');window.location ='".base_url('travels/travels_list')."';</script>";
		}
		//获取目的地
		$destName = '';
		if (!empty($travel_note_detail[0]['overcity']))
		{
			$destids=str_replace("undefined","0",$travel_note_detail[0]['overcity']);
			$where = array(
					'in' =>array('id' =>$destids)
			);
			$destData = $this ->dest_base_model ->getDestData($where);
			//$destData = $this ->dest_model ->getDestIn(trim($travel_note_detail[0]['overcity'] ,','));
			if(!empty($destData))
			{
				foreach($destData as $v)
				{
					$destName .= $v['kindname'].',';
				}
			}
		}
		$travel_note_detail[0]['destName'] = rtrim($destName ,',');

		$data = array(
			'note_detail'=>$travel_note_detail[0],
			'note_pic' => $travel_note_pic,
			'note_id'=>$travel_note_id,
			'total_comment'=>$total_comment,
			'relate_products' => $relate_products,
			'recommend_note'=>$recommend_note
			);
		//print_r($travel_note_pic);exit();
		$this->load->view('travels/personal_travel_detail_view',$data);
	}

	/**
	 * @method 获取评论数据
	 * @author wangxiaofeng
	 * @since  2015-08-18
	 */
	public function travel_comment(){

		 $note_id = $this->input->post('note_id');
    		$pre_page = $this->input->post ( 'pageSize', true );
    		$num = empty ( $pre_page ) ? 10 : $pre_page;
    		$new_page = $this->input->post ( 'pageIndex', true );
    		$new_page = empty ( $new_page ) ? 1 : $new_page;
    		$post_arr = array();
    		$post_arr['tn.id'] = $note_id;
		    $total = count ( $this->travel_model->get_comment( $post_arr, 0, $num ) );
		    $travel_comment = $this->travel_model->get_comment( $post_arr, $new_page, $num );
		    echo json_encode ( array(
		        'total' => $total,
		        'result' => $travel_comment
		    ) );
	}

	/**
	 * 发表评论
	 * wangxiaofeng
	 * @return [type] [description]
	 */
	public function publish_comment(){
		$this->load->library ( 'callback' );
		$c_userid = $this->session->userdata('c_userid');
		if(empty($c_userid) || $c_userid==0){
			echo json_encode(array('status'=>-400,'msg'=>'请先登录'));
			exit();
		}
		$insert_arr = array();
		$insert_arr['note_id'] = $this->input->post('note_form_id');
		$insert_arr['member_id'] = $this->session->userdata('c_userid');
		$insert_arr['reply_content'] = $this->input->post('comment');
		if(empty($insert_arr['reply_content'])){
			echo json_encode(array('status'=>-200,'msg'=>'发表内容不能为空'));exit();
		}
		$insert_arr['ADDTIME'] = date('Y-m-d H:i:s');
		if($this->db->insert('travel_note_reply',$insert_arr)){
			$sql = "update travel_note set comment_count=comment_count+1 where id=".$this->input->post('note_form_id');
			if($this->db->query($sql)){
				echo json_encode(array('status'=>200,'msg'=>'发表成功'));
				exit();
			}else{
				echo json_encode(array('status'=>-201,'msg'=>'发表失败'));
				exit();
			}
		}else{
			echo json_encode(array('status'=>-300,'msg'=>'发表失败'));
			exit();
		}
	}

	/**
	 * 点赞
	 * @return [type] [description]
	 */
	function click_praise(){
		$c_userid = $this->session->userdata('c_userid');
		if(empty($c_userid) || $c_userid==0){
			echo json_encode(array('status'=>-400,'msg'=>'请先登录'));
		}
		$insert_arr = array();
    $c_id = $this->input->post('c_id');
    $note_id = $this->input->post('note_id');
    $this->db->select("count(*) AS  praise_count");
    $this->db->from('travel_note_praise');
    $this->db->where(array('note_id'=>$note_id,'member_id'=>$c_id));
    $res = $this->db->get()->result_array();
    if($res[0]['praise_count']==0){
        $insert_arr['note_id'] = $note_id;
        $insert_arr['member_id'] = $c_id;
        $insert_arr['ip'] = $_SERVER["REMOTE_ADDR"];
        $insert_arr['addtime'] = date('Y-m-d H:i:s');
        if($this->db->insert('travel_note_praise',$insert_arr)){
            $update_sql = "update travel_note set praise_count=praise_count+1 where id=$note_id";
            if($this->db->query($update_sql)){
                $this->db->select("praise_count");
                $this->db->from('travel_note');
                $this->db->where(array('id'=>$note_id));
                $res = $this->db->get()->result_array();
                echo json_encode(array('status'=>200,'msg'=>'点赞成功','praise_count'=>$res[0]['praise_count']));
            }else{
                echo json_encode(array('status'=>-201,'msg'=>'点赞失败'));
            }
        }else{
            echo json_encode(array('status'=>-202,'msg'=>'点赞失败'));
        }
    }else{
        $delete_sql = "delete from travel_note_praise where note_id=$note_id and member_id=$c_id";
        if($this->db->query($delete_sql)){
            $update_sql = "update travel_note set praise_count=praise_count-1 where id=$note_id";
            if($this->db->query($update_sql)){
                $this->db->select("praise_count");
                $this->db->from('travel_note');
                $this->db->where(array('id'=>$note_id));
                $res = $this->db->get()->result_array();
                echo json_encode(array('status'=>200,'msg'=>'取消点赞','praise_count'=>$res[0]['praise_count']));
            }else{
                echo json_encode(array('status'=>-201,'msg'=>'取消点赞失败'));
            }
        }else{
            echo json_encode(array('status'=>-202,'msg'=>'取消点赞失败'));
        }
    }
	}
}