<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 旅游分享
 * @author HEJUN
 *
 */
class Share_detail extends UC_NL_Controller{
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'common/u_member_model', 'member_model' );
		$this->load->model ( 'common/u_line_share_model', 'line_share_model' );
	}

	/**
	 * @method 分享列表
	 * @author jiakairong
	 * @since  2015-08-21
	 */
	public function more_share() {
		$whereArr=array();
		$type = intval($this ->input ->get('type'));
		$page = intval($this ->input ->get('page'));
		$page = empty($page) ?1 :$page;
		switch($type) {
			case 1: //最新分享
				$orderby = "addtime desc";
				$data['type_name'] = '最新分享';
				break;
			case 2://分享图片
				$orderby = "praise_count desc";
				$data['type_name'] = '分享图片';
				break;
			default: //默认最新
				$orderby = "addtime desc";
				$data['type_name'] = '最新分享';
				break;
		}
		
		$count=$this->line_share_model->num_rows($whereArr);
		$this->load->library ( 'Page' );
		$config['base_url']='/share/share_detail/more_share?type='.$type.'&page=';
		$config['pagesize'] = '10';
		$config['page_now'] = $page;
		$config['pagecount'] = $count;
		$this->page->initialize ( $config );
		
		$data['shareData'] = $this->line_share_model->result($whereArr,$page = $page, $num =10, $orderby = $orderby, $type='arr');
		
		$this->load->view('share/more_share_view',$data);
	}

	/**
	 * @method 分享达人列表
	 */
	public function more_share_man(){
		$page = intval($this ->input ->get('page'));
		empty($page_new)?1:$page_new;
		$whereArr=array();
		$count=$this->member_model->num_rows($whereArr);
		//echo $this ->db ->last_query();
		$this->load->library ( 'Page' );
		$config['base_url']='/share/share_detail/more_share_man?page=';
		$config['pagesize'] = 12;
		$config['page_now'] = $page;
		$config['pagecount'] = $count;
		$this->page->initialize ( $config );
		//分享达人
		$data['share_man']=$this->member_model->result($whereArr,$page, $num =12, $orderby = "share_count desc", $type='arr');
		$this->load->view('share/more_sharers_view',$data);
	}

	/**
	 * @method 分享达人的游记列表
	 */
	public function personal_share(){
		$share_man_id=intval($this->input->get('share_man'));		
		$page = intval($this ->input ->get('page'));
		$whereArr=array('u_member.mid'=>$share_man_id);
		//分享达人
		$data['share_man']=$this->member_model->row($whereArr, $type='arr', $orderby ="share_count",$fieldsArr="");
		$joinArr=array('u_member','u_line_share.member_id=u_member.mid','left');
		//分享图片
		$data['share_img']=$this->line_share_model->result($whereArr,$page, $num = 10, $orderby = "praise_count desc", $type='arr',$joinArr);
		$count=$this->line_share_model->num_rows($whereArr,$joinArr);
		$this->load->library ( 'Page' );
		$config['base_url']='/share/share_detail/personal_share?share_man='.$share_man_id.'&page=';
		$config['pagesize'] = 10;
		$config['page_now'] = $page;
		$config['pagecount'] = $count;
		$this->page->initialize ( $config );
		//print_r($count);exit();
		$this->load->view('share/personal_share_view',$data);
	}
	/**
	 * @method 获取分享的详情
	 * @author jiakairong
	 */
	public function get_share_detail() {
		$id = intval($this ->input ->post('id'));
		//分享数据
		$shareData = $this ->line_share_model ->row(array('id' =>$id) ,'arr');
		//给分享加人气
		$sql = "update u_line_share set popularity = popularity +1 where id = {$id}";
		$this ->db ->query($sql);
		//给会员加人气
		$sql = "update u_member set share_popularity = share_popularity+1 where mid = {$shareData['member_id']}";
		$this ->db ->query($sql);
		//记录谁查看了分享，若用户登录则记录其ID，若没有登录则ID记录为：0
		$userid = $this ->session ->userdata('c_userid');
		$popularityArr = array(
				'line_share_id' =>$id,
				'member_id' =>empty($userid) ? 0 :$userid,
				'addtime' =>date('Y-m-d H:i:s' ,time())
		);
		$this ->db ->insert('u_line_share_popularity' ,$popularityArr);
		//用户是否点赞
		$userid = $this ->session ->userdata('c_userid');
		$is_praise = 0;
		if ($userid > 0 ) {
			$this ->load_model('common/u_line_share_praise_model' ,'praise_model');
			$praiseData = $this ->praise_model ->row(array('share_id' =>$id ,'member_id' =>$userid));
			if (!empty($praiseData)) {
				$is_praise = 1;
			}
		}
		//图片
		$this ->load_model('common/u_line_share_pic_model' ,'share_pic_model');
		$picData = $this ->share_pic_model ->all(array('line_share_id' =>$id));

		$dataArr = array(
			'shareData' =>$shareData,
			'picData' =>$picData,
			'is_praise' =>$is_praise
		);
		echo json_encode($dataArr);
	}
	/**
	 * @method 取消或增加点赞
	 * @author jiakairong
	 * @since  2015-09-21
	 */
	function change_share_praise() {
		$this->load->library ( 'callback' );
		$share_id = intval($this ->input ->post('share_id'));
		$userid = $this ->session ->userdata('c_userid');
		$this ->load_model('common/u_line_share_praise_model' ,'praise_model');
		$praiseData = $this ->praise_model ->row(array('share_id' =>$share_id ,'member_id' =>$userid));
		if (!empty($praiseData)) {
			//取消点赞
			$sql = "update u_line_share set praise_count = praise_count -1 where id = {$share_id}";
			$this ->db ->query($sql);
			$this ->praise_model ->delete(array('id' =>$praiseData['id']));
			$status = 0;
		} else {
			//增加点赞
			$sql = "update u_line_share set praise_count = praise_count +1 where id = {$share_id}";
			$this ->db ->query($sql);
			$praiseArr = array(
				'share_id' =>$share_id,
				'member_id' =>$userid,
				'addtime' =>date('Y-m-d H:i:s' ,time()),
				'ip' =>ip2long($_SERVER['REMOTE_ADDR'])
			);
			$this ->praise_model ->insert($praiseArr);
			$status = 1;
		}
		$this->callback->set_code ( 2000 ,$status);
		$this->callback->exit_json();
	}
	
}