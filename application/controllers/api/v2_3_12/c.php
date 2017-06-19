<?php

/**
 *   @name:APP接口文件
 *   @version: v2_3_12
 *   @author: 魏勇
 *   @time: 2016-10-14 11:20:01
 *   
 * 	 @abstract:
 *
 * 		1、   cfgm是用户接口前缀 ，
 * 		    E是管家接口前缀，
 * 		    G是即时导游接口前缀，
 * 			P是公共函数接口前缀  ；
 *
 *      2、	 __outmsg()、__data()是输出格式化数据模式，
 *      	 __null()是输出空，
 *      	 __errormsg()是输出错误模式
 *        
 *      3、数据传递方式： POST
 * 		
 *      4、返回结果状态码:  2000是成功，4001是空null，-3是错误信息
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//继承APP_Controller类
class C extends APP_Controller {

    private $default_cityid = '235'; //默认城市id为深圳

    public function __construct() {
        parent::__construct();
        header('Content-type: application/json;charset=utf-8');  //文档为json格式
        // 允许ajax POST跨域访问
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
    }

    public function get_param_rules() {
        return array(
            'cfgm_home' => array(
                'cityid' => array('name' => 'user_id', 'type' => 'int', 'min' => 1, 'require' => true, 'desc' => '用户ID'),
            ),
            'cfgm_get_city' => array(
                'userIds' => array('name' => 'user_ids', 'type' => 'array', 'format' => 'explode', 'require' => true, 'desc' => '用户ID，多个以逗号分割'),
            ),
        );
    }

    /**
     * 获取app首页数据
     * @desc 用于获取app首页数据
     * @return int roll_pic 操作码，0表示成功， 1表示用户不存在
     * @return object info 用户信息对象
     * @return string info.roll_pic 导航图
     * @return string info.expert 管家
     * @return string info.dest 目的地(又分为：境外、国内、周边)
     * @return string info.line 热销线路(又分为：境外、国内、周边)	 
     * @return string msg 提示信息
     */
    public function cfgm_home() {
        $cityid = $this->input->post('cityid', true); //城市id
        $page = intval($this->input->post('page'), true);
        $page_size = intval($this->input->post('page_size'), true);
        $page = empty($page) ? 1 : $page;
        $page_size = empty($page_size) ? 12 : $page_size;
        $from = ($page - 1) * $page_size; //from
        //$cityid = "235";
        if (!$cityid) {
            $this->__errormsg('city is null');
        }

        $reDataArr = array();
        $roll_pic_sql = "select id,name,pic,showorder from cfgm_index_roll_pic where is_show=1 order by showorder";
        $reDataArr ['roll_pic'] = $this->db->query($roll_pic_sql)->result_array();
        //$this->db->select("e.id AS eid,e.talk,e.big_photo,e.small_photo,e.realname,a.name,e.praise_num,e.avg_score,(CASE WHEN grade=1 THEN '管家' WHEN grade=2 THEN '初级' WHEN grade=3 THEN '中级' WHEN grade=4 THEN '高级' END) AS grade");
        //$this->db->select("e.id AS eid,e.talk,e.big_photo,e.small_photo,e.m_bgpic,e.realname,a.name,e.praise_num,e.avg_score,(CASE WHEN grade=1 THEN '管家' WHEN grade=2 THEN '初级' WHEN grade=3 THEN '中级' WHEN grade=4 THEN '高级' END) AS grade");
        $this->db->select("e.id AS eid,e.talk,e.big_photo,e.small_photo,cfg.pic AS m_bgpic,e.nickname as realname,a.name,e.praise_num,e.avg_score,(CASE WHEN grade=1 THEN '管家' WHEN grade=2 THEN '初级' WHEN grade=3 THEN '中级' WHEN grade=4 THEN '高级' END) AS grade");
        $this->db->from("cfgm_hot_expert AS cfg");
        $this->db->join("u_expert AS e", "cfg.expert_id=e.id", "left");
        $this->db->join("u_area AS a", "e.city=a.id", "left");
        $this->db->where(array(
            'cfg.is_show' => 1,
            'cfg.startplaceid' => $cityid,
            'e.status' => 2
        ));
        $this->db->limit(21, 0); // 21 row
        $this->db->order_by("cfg.showorder", "asc");
        $query = $this->db->get();
        $reDataArr ['expert'] = $query->result_array();
        $dest_sql = "select cd.dest_id as id,cd.dest_type,ud.kindname as destname,cd.name as description,cd.pic as pic,cd.linenum as num   		from cfgm_hot_dest as cd  		left join u_dest_cfg as ud on ud.id=cd.dest_id 	left join cfg_index_kind as cik on cik.id=cd.dest_type 		where cd.is_show='1' and cd.startplaceid={$cityid}";

//		$jw_dest_sql = $dest_sql . " and cd.dest_type=1 order by cd.id desc limit 3";      
//		$gn_dest_sql = $dest_sql . " and cd.dest_type=2 order by cd.id desc limit 3";
//		$zb_dest_sql = $dest_sql . " and cd.dest_type=3 order by cd.id desc limit 3";
//		$reDataArr ['dest'] ['jw'] = $this->db->query ( $jw_dest_sql )->result_array ();
//		$reDataArr ['dest'] ['gn'] = $this->db->query ( $gn_dest_sql )->result_array ();
//		$reDataArr ['dest'] ['zb'] = $this->db->query ( $zb_dest_sql )->result_array ();
        // 当前版本线路与产品没有进行分类
        //$hot_dest_sql = $dest_sql . ' order by cd.id desc limit 6';
        $hot_dest_sql = $dest_sql . " order by cd.id desc limit {$from}, {$page_size}";
        $reDataArr['dest'] = $this->db->query($hot_dest_sql)->result_array();

        $time = date("Y-m-d"); // 依据现阶段时间迭代
        //$line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname   	FROM  	cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id     	left join cfg_index_kind as cik on cik.id=cx.dest_type left join u_expert as e on e.id=l.recommend_expert  	where l.status='2' and cx.is_show=1 and cx.starttime<='{$time}' and cx.endtime>='{$time}'";
        $line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname   	FROM  	cfgm_hot_line AS cx RIGHT JOIN u_line AS l ON cx.line_id=l.id     	left join cfg_index_kind as cik on cik.id=cx.dest_type left join u_expert as e on e.id=l.recommend_expert  	where l.status='2' and cx.is_show=1 and cx.starttime<='{$time}' and cx.endtime>='{$time}'";
//		$jw_line_sql = $line_sql . " and cx.dest_type=1 order by cx.showorder limit 4";    
//		$gn_line_sql = $line_sql . " and cx.dest_type=2 order by cx.showorder limit 4";
//		$zb_line_sql = $line_sql . " and cx.dest_type=3 order by cx.showorder limit 4";  //合并
//		$reDataArr ['line'] ['jw'] = $this->db->query ( $jw_line_sql )->result_array ();
//		$reDataArr ['line'] ['gn'] = $this->db->query ( $gn_line_sql )->result_array ();
//		$reDataArr ['line'] ['zb'] = $this->db->query ( $zb_line_sql )->result_array ();
        //$hot_line_sql = $line_sql . ' order by cx.showorder limit 6';
        //$hot_line_sql = $line_sql . ' order by cx.showorder ';
        $hot_line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id
                    FROM cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id 
                    where l.status='2' and cx.startplaceid = {$cityid} and cx.is_show=1 order by cx.showorder desc limit 6 ";
        $reDataArr ['line'] = $this->db->query($hot_line_sql)->result_array();
        // if need to this plase take on
        // $this->output->cache(5);

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：城市定位(根据经纬度获得城市名和城市id)
     * @author: 温文斌
     * @param: lat维度；lng=经度
     *        
     * @return:
     *
     */
    public function cfgm_get_city() {
        $lat = $this->input->post('lat', true); //维度
        $lng = $this->input->post('lng', true); //经度
        //$lat="22.54";
        //$lng="114.02";
        if (!$lat || !$lng)
            $this->__errormsg('param missing', $code = "3");
        $api = 'http://api.map.baidu.com/geocoder?location=' . $lat . ',' . $lng . '&output=json&key=cwnZNPB1ouBCEu9sG423iL63';
        $json = @file_get_contents($api);
        $data = json_decode($json, true);

        $city = "深圳市"; //若无法定位，默认是深圳
        $city = mb_substr($city, 0, -1);
        if (!empty($data['result']['addressComponent']['city'])) {
            $city = $data['result']['addressComponent']['city'];
        }
        $arr = $this->db->query("select * from u_area where name like '%" . $city . "%'")->row_array();
        $returnData = array('cityid' => $arr['id'], 'cityname' => $city);
        $this->__outmsg($returnData);
    }

    /**
     * @name：首页模糊搜索
     * @author: 温文斌
     * @param: content=搜索内容；
     *
     * @return:
     *
     */
    public function cfgm_home_search() {
        $content = $this->input->post('content', true); //搜索内容
        $cityid = $this->input->post("cityid", true); //当前城市
        if (empty($cityid)) {
            $cityid = $this->default_cityid; //默认城市深圳
        }
        //1、目的地
        $dest_sql = "select
							id,kindname
					 from
							u_dest_cfg as d
				     where
							isopen=1 and kindname like '%{$content}%' order by id desc limit 4";
        $dest_query = $this->db->query($dest_sql);
        $out['dest'] = $dest_query->result_array();
        //2、管家
        $expert_sql = "select
						id,nickname
			    from
					    u_expert
		        where
						status=2 and city={$cityid} and nickname like '%{$content}%' order by addtime desc limit 4";
        $expert_query = $this->db->query($expert_sql);
        $out['expert'] = $expert_query->result_array();
        //3、线路
        //10、"当前定位出发城市" where条件（若$city_name不为空，则从具体某个城市出发，否则全国出发）
        $all_redata = $this->db->query("SELECT id FROM u_startplace WHERE cityname='全国出发' ")->row_array();
        $all_redataid = isset($all_redata['id']) ? $all_redata['id'] : '391'; //"全国出发"ID		
        if ($cityid) {
            $wheresql = "  and (FIND_IN_SET({$cityid},ls.startplace_id)>0 or FIND_IN_SET({$all_redataid},ls.startplace_id)>0)"; //城市出发+全国出发
        } else {
            //全国出发
            $wheresql = "  and FIND_IN_SET({$all_redataid},ls.startplace_id)>0";
        }
        $sql_line = "select
							l.id,l.linename
					from
							u_line l
							LEFT JOIN u_line_startplace AS ls ON l.id=ls.line_id
					where
	status=2 and linename like '%{$content}%'  {$wheresql} order by addtime desc limit 20";

        $query_line = $this->db->query($sql_line);
        $out['line'] = $query_line->result_array();

        if (empty($out['expert']) && empty($out['line']) && empty($out['dest']))
            $this->__nullmsg();
        else
            $this->__outmsg($out);
    }

    /**
     * @name：管家详情
     * @author: 温文斌        魏勇编辑
     * @param: number=凭证；expertid=管家ID；usertype=用于区分管家和用户
     * @return:
     *
     */
    public function cfgm_expert_detail() {

        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        //1、传值

        $e_id = intval(isset($_REQUEST['expertid']) ? $_REQUEST['expertid'] : '0');  //$e_id = intval ( $this->input->post ( 'expertid', true ) );
        $token = $this->input->post('number', true);

        //$e_id="1372";
        if (!$e_id) {
            $this->__errormsg('param missing');
        }

        //2、是否收藏过、是否赞过
        $m_id = $this->F_get_mid($token);
        $sck = $this->db->query(" SELECT * FROM (`u_expert_collect`) WHERE `expert_id` = {$e_id} AND `member_id` = {$m_id}")->row_array();
        $sc = "0";
        if (empty($sck)) {
            $sc = '0';
        } else {
            $sc = '1';
        }

        $praise_one = $this->db->query(" SELECT * FROM (`u_expert_praise`) WHERE `expert_id` = {$e_id} AND `member_id` = {$m_id}")->row_array();
        $is_praise = "0";
        if (empty($praise_one)) {
            $is_praise = '0';
        } else {
            $is_praise = '1';
        }

        // 3、管家详情
        $expert_detail = $this->F_expert_detail($e_id);
        $expert_detail['zx_link'] = CHAT_URL . "/m_chat.html?mid=&eid=" . $e_id;

        //var_dump($expert_detail);
        foreach ($expert_detail as $k => $v) {
            if ($k == "satisfaction_rate") {
                if ($v) {
                    $expert_detail[$k] = round($v * 100);
                }
            }
        }
        // 4、售卖产品
        $sql = "select 
						la.id,la.expert_id,l.id AS line_id,l.linename,l.linetitle,l.mainpic,l.lineprice,
						l.satisfyscore,l.all_score,l.peoplecount, l.shownum,l.collectnum,sharecount,
		                (select sum(avgscore2) from u_comment as c where c.line_id=l.id and c.expert_id={$e_id} ) as expert_total_score,
		                GROUP_CONCAT(s.cityname) as startplace
				from 
						u_line_apply AS la
						left join u_line AS l on l.id=la.line_id	
						left join u_line_startplace as ls on ls.line_id=l.id
						left join u_startplace as s on s.id=ls.startplace_id
						
				where 
						la.status=2 and l.producttype=0 and l.status='2' and la.expert_id={$e_id}  
				GROUP BY 
						l.id";
        $sql_limit = $sql . " limit 0,3";
        $query = $this->db->query($sql_limit);
        $line_list = $query->result_array();
        foreach ($line_list as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "satisfyscore") {
                    if ($v) {
                        $val [$k] = round($v * 100);
                    }
                }
                if ($k == "collectnum") {
                    if (empty($v))
                        $val [$k] = "0";
                    else
                        $val [$k] = $v;
                }
                if ($k == "id")
                    $val['link'] = base_url() . 'line/line_detail?lineid=' . @$v[$k];  //“线路详情”链接
            }
            $line_list [$key] = $val;
        }

        $query = $this->db->query($sql);
        $line_list_rows = $query->num_rows();
        // 5、定制列表
        $sql2 = "
				select 
							uc.id as id,uc.question as question,uc.budget as budget,uc.pic as litpic,
							uc.total_people as total_people,uc.startdate as startdate,uc.estimatedate as estimatedate,
							uc.startplace as startplace,uc.endplace as endplace,uc.status as status,uca.expert_id as expert_id,
							uca.isuse as isuse, ua.name as area_name,ud.kindname as dest_name, ue.nickname as nickname,ue.m_bgpic as uem_m_bgpic 	 
				from
							u_customize as uc 
							left join u_customize_answer as uca on uc.id=uca.customize_id 	
							left join u_line as l on uc.line_id=l.id 		
							left join u_expert as ue on uca.expert_id=ue.id 	
							left join u_area as ua on ua.id=uc.startplace 		
							left join u_dest_cfg as ud on ud.id=uc.endplace 	
				where 
							uc.status='3' and uca.isuse='1' and ISNULL(uca.replytime)=0 	 and uca.expert_id={$e_id} 
				order by 
							uc.addtime desc";
        $sql2_limit = $sql2 . " limit 3";
        $query = $this->db->query($sql2);
        $customiz_list = $this->db->query($sql2_limit)->result_array();

        foreach ($customiz_list as $key => $val) {
            foreach ($val as $k => $v) {

                if ($k == "id")
                    $val['link'] = base_url() . 'customize/customize_detail?cid=' . @$v[$k]; //“定制详情”链接地址
            }
            $customiz_list [$key] = $val;
        }

        $customiz_list_rows = $query->num_rows();

        // 6、评价
        $sql4 = " select 
							uc.addtime,uc.expert_content,uc.reply1,uc.reply2,uc.score5,uc.score6,
							um.litpic,um.nickname as nickname,mo.productautoid as productautoid,
							l.linename as line_name,l.linetitle as line_title 
				  from 
							u_comment as uc 
							left join u_member as um on uc.memberid=um.mid 	
							left join u_member_order as mo on uc.orderid=mo.id 	
							left join u_line as l on l.id=mo.productautoid 	
				  where 
				 			uc.status=1 and uc.expert_id={$e_id} 
				  order by  
							uc.addtime desc 
				limit 0,3         	";
        $query = $this->db->query($sql4);
        $comment_list = $query->result_array();
        // 评价条
        $sql4 = rtrim($sql4, "limit 0,3 ");
        $query = $this->db->query($sql4);
        $comment_list_rows = $query->num_rows();

        //7、管家个人主页

        $expert_more = $this->db->query("select hobby,pass_way,like_food from u_expert_more_about where expert_id={$e_id}")->row_array();
        $country = $this->db->query("select a.name from u_expert_more_about as em left join u_area as a on a.id=em.county  where expert_id={$e_id}")->row_array();
        $province = $this->db->query("select a.name from u_expert_more_about as em left join u_area as a on a.id=em.province where expert_id={$e_id}")->row_array();
        $city = $this->db->query("select a.name from u_expert_more_about as em left join u_area as a on a.id=em.city  where expert_id={$e_id}")->row_array();
        $blood = $this->db->query("select d.description as name from u_expert_more_about as em left join u_dictionary as d on d.dict_id=em.blood  where expert_id={$e_id}")->row_array();
        $constellation = $this->db->query("select d.description as name from u_expert_more_about as em left join u_dictionary as d on d.dict_id=em.constellation  where expert_id={$e_id}")->row_array();
        $decade = $this->db->query("select d.description as name from u_expert_more_about as em left join u_dictionary as d on d.dict_id=em.decade  where expert_id={$e_id}")->row_array();

        $expert_info['hometown'] = @$country['name'] . @$province['name'] . @$city['name']; //喜欢美食

        $expert_info['hobby'] = isset($expert_more['hobby']) ? explode("#", $expert_more['hobby']) : ''; //爱好
        $expert_info['pass_way'] = isset($expert_more['pass_way']) ? explode("#", $expert_more['pass_way']) : ''; //去过的地方
        $expert_info['like_food'] = isset($expert_more['like_food']) ? explode("#", $expert_more['like_food']) : ''; //喜欢美食
        $expert_info['blood'] = isset($blood['name']) ? $blood['name'] : ''; //血型
        $expert_info['constellation'] = isset($constellation['name']) ? $constellation['name'] : ''; //星座
        $expert_info['decade'] = isset($decade['name']) ? $decade['name'] : ''; //年代
        //我的标签
        $attr = $this->db->query("select d.description as name from u_expert_attr as a left join u_dictionary as d on d.dict_id=a.attr_id where a.expert_id={$e_id}")->result_array();
        $attr_arr = array();
        foreach ($attr as $key => $value) {
            $attr_arr[$key] = $value['name'];
        }
        $expert_info['attr'] = $attr_arr;
        //喜欢去哪儿 (境内、境外)
        $go_in = $this->db->query("select d.description as name from u_expert_go as go left join u_dictionary as d on d.dict_id=go.dest_id left join u_dictionary as dd on dd.dict_id=d.pid where dd.dict_code='DICT_EXPERT_DEST_GN' and go.expert_id={$e_id}")->result_array();
        $go_out = $this->db->query("select d.description as name from u_expert_go as go left join u_dictionary as d on d.dict_id=go.dest_id left join u_dictionary as dd on dd.dict_id=d.pid where dd.dict_code='DICT_EXPERT_DEST_JW' and go.expert_id={$e_id}")->result_array();

        $go_arr = array();
        foreach ($go_in as $key => $value) {
            $go_arr[$key] = $value['name'];
        }
        $expert_info['go']['in'] = $go_arr;

        $go_arr = array();
        foreach ($go_out as $key => $value) {
            $go_arr[$key] = $value['name'];
        }
        $expert_info['go']['out'] = $go_arr;
        //喜欢怎样玩
        $play = $this->db->query("select d.description as name from u_expert_play as p left join u_dictionary as d on d.dict_id=p.way_id where p.expert_id={$e_id}")->result_array();
        $play_arr = array();
        foreach ($play as $key => $value) {
            $play_arr[$key] = $value['name'];
        }
        $expert_info['paly'] = $play_arr;

        //和谁玩
        $with = $this->db->query("select d.description as name from u_expert_with as w left join u_dictionary as d on d.dict_id=w.crowd_id where w.expert_id={$e_id}")->result_array();
        $with_arr = array();
        foreach ($with as $key => $value) {
            $with_arr[$key] = $value['name'];
        }
        $expert_info['with'] = $with_arr;
        //休闲方式
        $relax = $this->db->query("select d.description as name from u_expert_relax as r left join u_dictionary as d on d.dict_id=r.relax_id where r.expert_id={$e_id}")->result_array();
        $relax_arr = array();
        foreach ($relax as $key => $value) {
            $relax_arr[$key] = $value['name'];
        }
        $expert_info['relax'] = $relax_arr;

        // 8、管家主页-》动态
        $sql11 = "select 
        		       c.*,(select GROUP_CONCAT(cp.pic SEPARATOR ',') as pic from u_expert_condition_pic as cp where cp.condition_id=c.id) as pic,
        		       (select GROUP_CONCAT(cp.len SEPARATOR ',') as len from u_expert_condition_pic as cp where cp.condition_id=c.id) as len,
        		       (select GROUP_CONCAT(cp.wei SEPARATOR ',') as wei from u_expert_condition_pic as cp where cp.condition_id=c.id) as wei
        		 from 
        			   u_expert_condition as c
        		where 
        				c.id={$e_id}
        	    order by 
        	    		c.addtime desc
        		";
        $condition = $this->db->query($sql11)->result_array();
        //对动态的图片数据处理
        foreach ($condition as $item => $value) {
            $pic_arr = explode(",", $value['pic']);
            $len_arr = explode(",", $value['len']);
            $wei_arr = explode(",", $value['wei']);
            $new_pic_arr = array();
            foreach ($pic_arr as $key => $pic_value) {
                $new_pic = array();
                $new_pic['pic'] = $pic_value;
                $new_pic['len'] = $len_arr[$key];
                $new_pic['wei'] = $wei_arr[$key];

                $new_pic_arr[$key] = $new_pic;
            }

            $condition[$item]['pic_arr'] = $new_pic_arr;
            $condition[$item]['pic_num'] = count($pic_arr);
        }

        //9、返回结果
        $arr = array(
            'expert_detail' => $expert_detail,
            'line_list' => $line_list,
            'customiz_list' => $customiz_list,
            'comment_list' => $comment_list,
            'expert_info' => $expert_info,
            'condition' => $condition,
            'sc' => $sc,
            'is_praise' => $is_praise,
            'lianjie' => "http://www.1b1u.com/guanj/" . $e_id
        );

        $this->__wap($arr, $callback);  //考虑wap端请求跨域问题
    }

    /**
     * @name：线路列表显示页面（价格列表、天数列表）
     * @author: 温文斌
     * @param: 
     *
     * @return:
     *
     */
    public function cfgm_price_day() {
        $arr['price'] = $this->db->query("select * from cfg_search_condition where pid=4")->result_array();
        $arr['day'] = $this->db->query("select * from cfg_search_condition where pid=6")->result_array();
        $this->__outmsg($arr);
    }

    /**
     * @name：下拉城市列表(出发城市)
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function cfgm_startplace() {
        $this->load->library('get_pinying');
        $reDataArr = array();
        $city_arr = array();
        $sql = "SELECT  s2.areaid as id, s2.cityname as name ,s2.enname,s2.simplename , UPPER(SUBSTRING(s2.simplename,1,1 )) AS ch , s2.ishot ,s2.level ,s3.pid FROM u_startplace s2   LEFT JOIN  u_startplace s3  ON s2.pid =s3.id WHERE   s2.level =3  	AND s2.isopen=1  ORDER BY s2.enname,s2.pid DESC , s2.simplename ASC";
        $all_citys = $this->db->query($sql)->result_array();

        if ($all_citys) {
            foreach ($all_citys as $key => $val) {
                $val ['spell'] = $this->get_pinying->getAllPY($val ['name']); // 全拼
                $szm_py [$key] = strtoupper(substr($this->get_pinying->getFirstPY($val ['name']), 0, 1)); // 首字母拼音大写
                $reDataArr [$szm_py [$key]] [] = $val;
            }
            if ($reDataArr) {
                ksort($reDataArr);
            }
            $city_arr ['all_city'] = $reDataArr;
        }

        $this->__outmsg($city_arr);
    }

    /**
     * @name：下拉城市列表=》搜索(出发城市)
     * @author: 温文斌
     * @param:city=城市名字
     * @return:
     *
     */
    public function cfgm_find_startplace() {

        $city = $this->input->get_post('city', true);
        //$city="深圳";
        if (!$city)
            $this->__errormsg('城市名称不能为空');

        //$this->load->library ( 'get_pinying' );
        //$first_word=strtoupper ( substr ( $this->get_pinying->getFirstPY ( $city ), 0, 1 ) ); //首字母大写
        $first_word = strtoupper($city);


        if (preg_match("/[\x7f-\xff]/", $city)) {  //判断字符串中是否有中文
            //"中文"搜索出发城市
            $reDataArr = $this->db->query("select id,cityname,UPPER(SUBSTRING(simplename,1,1 )) AS ch from u_startplace where level=3 and cityname LIKE '%" . $city . "%'")->result_array();
        } else {
            //首字母搜索出的城市
            $reDataArr = $this->db->query("select id,cityname from u_startplace where simplename LIKE '%" . $city . "%' OR enname LIKE '%" . $city . "%' and level=3")->result_array();
        }

        //$re = $this->db->query("select id,cityname,UPPER(SUBSTRING(simplename,1,1 )) AS ch from u_startplace where level=3")->result_array();     
//        foreach ($re as $key => $value) {
//            if ($value['ch'] == $first_word)
//                $reDataArr2[] = $value;
//        }
//        print_r($reDataArr2);
//        print_r($re);
        //合并结果
//        $output = array_merge($reDataArr, $reDataArr2);
//        $output = $re;
//        $this->__outmsg($output);
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：下拉城市列表(目的地城市)
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function cfgm_destinations() {
        $type = $this->input->post("type", true); //1是出境、2是国内、3是周边
        $cityid = $this->input->post("cityid", true); //当前城市
        //$type="2";
        //$cityid="235";
        if (empty($type))
            $this->__errormsg('type参数缺失');
        if ($type == "3") {
            if (empty($cityid))
                $this->__errormsg('cityid参数缺失');
        }

        //1、境外、国内
        $this->load->library('get_pinying');
        $reDataArr = array();
        $city_arr = array();
        $sql = "SELECT  
						d.id, d.kindname as name ,d.enname,d.simplename , 
						UPPER(SUBSTRING(d.simplename,1,1 )) AS ch , d.ishot ,d.level ,d2.pid 
				FROM 
						u_dest_cfg as d 
						LEFT JOIN  u_dest_cfg d2  ON d.pid =d2.id 
				WHERE   
						d.level =3 AND d.isopen=1 and d2.pid='{$type}'
				ORDER BY 
						d.enname,d.pid DESC , d.simplename ASC";
        $all_citys = $this->db->query($sql)->result_array();

        if ($all_citys) {
            foreach ($all_citys as $key => $val) {
                $val ['spell'] = $this->get_pinying->getAllPY($val ['name']); // 全拼
                $first_word = strtoupper(substr($this->get_pinying->getFirstPY($val ['name']), 0, 1)); // 首字母拼音大写
                $reDataArr [$first_word] [] = $val;
            }
        }
        ksort($reDataArr);  //排序
        //2、周边
        $zb = $this->db->query("select d.id,d.kindname as name,d.enname,d.simplename ,UPPER(SUBSTRING(d.simplename,1,1 )) AS ch,d.ishot,d.level from cfg_round_trip as t left join u_dest_cfg as d on d.id=t.neighbor_id where t.startplaceid='{$cityid}' and t.isopen=1")->result_array();
        $reDataArr_zb = array();
        if ($zb) {
            foreach ($zb as $k => $v) {
                $v ['spell'] = $this->get_pinying->getAllPY($v ['name']); // 全拼
                $first_word = strtoupper(substr($this->get_pinying->getFirstPY($v ['name']), 0, 1)); // 首字母拼音大写
                $reDataArr_zb [$first_word] [] = $v;
            }
        }
        ksort($reDataArr_zb);

        //输出结果
        if ($type == "3") {
            $hot = array(); //热点城市
            foreach ($zb as $a => $b) {
                if ($b['ishot'] == "1")
                    $hot[] = $b;
            }
            $output['hot'] = $hot;
            $output['all'] = $reDataArr_zb;

            $this->__outmsg($reDataArr_zb); //周边
        }
        else {
            $hot = array(); //热点城市
            foreach ($all_citys as $a => $b) {
                if ($b['ishot'] == "1")
                    $hot[] = $b;
            }
            $output['hot'] = $hot;
            $output['all'] = $reDataArr;
            $this->__outmsg($reDataArr); //境内、国外
        }
    }

    /**
     * @name：下拉城市列表=》搜索(目的地城市)
     * @author: 温文斌
     * @param:city=城市名字
     * @return:
     *
     */
    public function cfgm_find_destinations() {

        $dest = $this->input->post('dest', true); //搜索的目的地
        $type = $this->input->post('type', true); //1境外 2国内 3周边
        //$dest="t";
        //$type="2";
        if (empty($dest))
            $this->__errormsg('目的地名称不能为空');
        if (empty($type))
            $this->__errormsg('type参数缺失');

        //$this->load->library ( 'get_pinying' );
        //$first_word=strtoupper ( substr ( $this->get_pinying->getFirstPY ( $city ), 0, 1 ) ); //首字母大写
        $first_word = strtoupper($dest);

        //"中文"搜索出发城市
        $reDataArr = $this->db->query("select d.id,d.kindname as name,UPPER(SUBSTRING(d.simplename,1,1 )) AS ch from u_dest_cfg as d left join u_dest_cfg as d2 on d.pid=d2.id where d.level=3 and d2.pid='{$type}' and d.kindname LIKE '%" . $dest . "%'")->result_array();
        //首字母搜索出的城市
        $reDataArr2 = array();
        $re = $this->db->query("select d.id,d.kindname as name,UPPER(SUBSTRING(d.simplename,1,1 )) AS ch from u_dest_cfg as d left join u_dest_cfg as d2 on d.pid=d2.id where d.level=3 and d2.pid='{$type}'")->result_array();
        foreach ($re as $key => $value) {
            if ($value['ch'] == $first_word)
                $reDataArr2[] = $value;
        }

        //合并结果
        $output = array_merge($reDataArr, $reDataArr2);
        $this->__outmsg($output);
    }

    /**
     * @name：公共接口：目的地三级联动（国家、省、市） u_dest_cfg表
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function dest_list_three() {
        $cityid = $this->input->post("cityid", true); //用于周边城市
        //$cityid="235";

        $areaData = $this->db->query("select id,kindname as name,pid,level from u_dest_cfg where isopen=1 and level<4  order by level asc,displayorder asc ")->result_array();
        $areaArr = array();  //格式1
        $areaArr2 = array();  //格式2
        foreach ($areaData as $key => $val) {
            switch ($val ['level']) {
                case 1 :
                    $areaArr[$val ['id']] = $val;
                    $areaArr2[$val ['id']] = $val;
                    break;
                case 2 :
                    if (array_key_exists($val ['pid'], $areaArr)) {
                        $areaArr [$val ['pid']]['province'] [$val ['id']] = $val;
                        $areaArr2 [$val ['pid']]['province'] [] = $val;
                    }
                    break;
                case 3 :

                    foreach ($areaArr as $k => $v) {

                        if (array_key_exists($val ['pid'], $v['province'])) {
                            $areaArr [$k] ['province'][$val ['pid']]['city'][] = $val;
                        }
                    }
                    foreach ($areaArr2 as $k => $v) {

                        if (array_key_exists($val ['pid'], $v['province'])) {
                            $areaArr[$k] ['province'][$val ['pid']]['city'][] = $val;
                        }

                        foreach ($v['province'] as $a => $b) {
                            //var_dump($val ['pid']);
                            //var_dump($b['id']);
                            if ($val ['pid'] == $b['id']) {
                                //var_dump($val ['pid']);
                                //var_dump($a);
                                //var_dump($val);
                                $areaArr2 [$k] ['province'][$a]['city'][] = $val;
                            }
                        }
                    }

                    break;
            }
        }

        //周边
        $zb = array();
        if ($cityid) {

            $zb = $this->db->query("select d.id,d.kindname as name,d.pid,d.level from cfg_round_trip as t left join u_dest_cfg as d on d.id=t.neighbor_id where t.startplaceid='{$cityid}' and t.isopen=1")->result_array();
        }
        $areaArr['zb'] = $areaArr2['zb'] = array(
            'id' => '3',
            'name' => '周边游',
            'level' => '1',
            'province' => array(
                '0' => array(
                    'id' => '0',
                    'name' => '周边游',
                    'level' => '2',
                    'city' => $zb
                )
            )
        );
        $areaArr2['cj'] = $areaArr2[1];
        $areaArr2['jn'] = $areaArr2[2];
        unset($areaArr2[1]);
        unset($areaArr2[2]);
        $this->__outmsg($areaArr2);
    }

    /**
     * @name：国内城市三级联动（u_area表）
     * @author: 温文斌
     * @param:无
     * @return:
     *
     */
    public function cfgm_pay_city() {
        $areaData = $this->db->query("select id,name,pid,level from u_area where isopen=1  order by level asc ")->result_array();
        $areaArr = array();
        foreach ($areaData as $key => $val) {
            switch ($val ['level']) {
                case 2 :
                    if ($val ['pid'] == 2) {
                        $areaArr ['domestic'] ['tow'] [$val ['id']] = $val;
                    }
                    break;
                case 3 :
                    if (array_key_exists($val ['pid'], $areaArr ['domestic'] ['tow'])) {
                        $areaArr ['domestic'] ['tow'] [$val ['pid']] ['three'] [$val ['id']] = $val;
                    }
                    break;
                case 4 :
                    foreach ($areaArr ['domestic'] ['tow'] as $k => &$v) {
                        if (array_key_exists($val ['pid'], $v ['three'])) {
                            $areaArr ['domestic'] ['tow'] [$k] ['three'] [$val ['pid']] ['four'] [] = $val;
                        }
                    }
                    break;
            }
        }
        $this->__outmsg($areaArr);
    }

    /**
     * @name：线路列表-》线路种类
     * @author: 温文斌
     * @param:dest=目的地
     * @return:
     *
     */
    public function cfgm_line_sort() {
        $dest_id = $this->input->post('dest', true);
        $cjy_sql = "select
							dd.id,dd.kindname as name
				   from
							u_dest_cfg as dd
				   where
							dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=1) and dd.`level`=3 and dd.ishot=1
				   limit 15
				    ";
        $gny_sql = "select
							dd.id,dd.kindname as name
				   from
							u_dest_cfg as dd
				   where
							dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=2) and dd.`level`=3 and dd.ishot=1
				   limit 15
				    ";
        $reDataArr ['cjy'] = $this->db->query($cjy_sql)->result_array();
        $reDataArr ['gny'] = $this->db->query($gny_sql)->result_array();
        //$reDataArr ['cjy'] = $this->db->query ( "select dd.id,dd.kindname as name  from u_dest_cfg as dd where dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=1) and dd.`level`=3  and dd.isopen=1  limit 15 " )->result_array ();
        //$reDataArr ['gny'] = $this->db->query ( "select dd.id,dd.kindname as name from u_dest_cfg as dd where dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=2) and dd.`level`=3  and dd.isopen=1   limit 15 " )->result_array ();
        //主题游
        $reDataArr ['zty'] = $this->db->query("	select id,name  from u_theme  ")->result_array();
        //周边游
        if ($dest_id) {
            //$pid=$dest_id;
            $pid = "10414";
        } else {
            $pid = "10414";
        }
        $zby_sql = "select
		dd.id,dd.kindname as name
		from
		u_dest_cfg as dd
		where
		dd.pid={$pid} and dd.`level`=3 and dd.isopen=1
		limit 15
		";
        $reDataArr ['zby'] = $this->db->query($zby_sql)->result_array();

        //$reDataArr ['zby'] = $this->db->query ( "	select u.kindname as name ,u.id from cfg_round_trip as c LEFT JOIN u_dest_cfg as u on u.id = c. neighbor_id where c.startplaceid='235' and u.isopen=1   " )->result_array ();

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：管家列表-》线路种类
     * @author: 温文斌
     * @param:dest=目的地
     * @return:
     *
     */
    public function cfgm_expert_line_sort() {
        $dest_id = $this->input->post('dest', true);
        $cjy_sql = "select
							dd.id,dd.kindname as name
				   from
							u_dest_cfg as dd
				   where
							dd.pid=1 and dd.`level`=2 and dd.isopen=1
				   limit 15
				    ";
        $gny_sql = "select
							dd.id,dd.kindname as name
				   from
							u_dest_cfg as dd
				   where
							dd.pid=2 and dd.`level`=2 and dd.isopen=1
				   limit 15
				    ";
        $reDataArr ['cjy'] = $this->db->query($cjy_sql)->result_array();
        $reDataArr ['gny'] = $this->db->query($gny_sql)->result_array();
        //$reDataArr ['cjy'] = $this->db->query ( "select dd.id,dd.kindname as name  from u_dest_cfg as dd where dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=1) and dd.`level`=3  and dd.isopen=1  limit 15 " )->result_array ();
        //$reDataArr ['gny'] = $this->db->query ( "select dd.id,dd.kindname as name from u_dest_cfg as dd where dd.pid IN (SELECT d.id FROM u_dest_cfg as d where d.pid=2) and dd.`level`=3  and dd.isopen=1   limit 15 " )->result_array ();
        //主题游
        $reDataArr ['zty'] = $this->db->query("	select id,name  from u_theme  ")->result_array();
        //周边游
        if ($dest_id) {
            //$pid=$dest_id;
            $pid = "10414";
        } else {
            $pid = "10414";
        }
        $zby_sql = "select
		dd.id,dd.kindname as name
		from
		u_dest_cfg as dd
		where
		dd.pid={$pid} and dd.`level`=3 and dd.isopen=1
		limit 15
		";
        $reDataArr ['zby'] = $this->db->query($zby_sql)->result_array();

        //$reDataArr ['zby'] = $this->db->query ( "	select u.kindname as name ,u.id from cfg_round_trip as c LEFT JOIN u_dest_cfg as u on u.id = c. neighbor_id where c.startplaceid='235' and u.isopen=1   " )->result_array ();

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：线路列表、管家列表显示页面=》一、二、三级目的地（国内、境外）
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function cfgm_all_product() {
        $reDataArr = array();
        $internalId = 1; // 国际ID
        $sql_inter_2 = "select * FROM  u_dest_cfg where  pid={$internalId}  order by pid asc ";
        $inter_citys_2 = $this->db->query($sql_inter_2)->result_array();
        $sql_inter_3 = "select * FROM  u_dest_cfg where  level=3  order by pid asc ";
        $inter_citys_3 = $this->db->query($sql_inter_3)->result_array();
        $inter_city = array();
        $inter_cityTab = array();
        foreach ($inter_citys_2 as $key => $val) {
            $inter_city ['id'] = $val ['id'];
            $inter_city ['name'] = $val ['kindname'];
            $inter_city ['childs'] = array();
            foreach ($inter_citys_3 as $k => $v) {
                if ($v ['pid'] == $val ['id']) {
                    $inter_city ['childs'] [] = array(
                        'id' => $v ['id'],
                        'name' => $v ['kindname']
                    );
                }
            }
            $inter_cityTab [] = $inter_city;
        }
        $reDataArr [] = array(
            "inter_city" => $inter_cityTab
        );
        $domesticId = 2; // 国内ID
        $sql_dome_2 = "select * FROM  u_dest_cfg where  pid={$domesticId}  order by pid asc ";
        $dome_citys_2 = $this->db->query($sql_dome_2)->result_array();
        $sql_dome_3 = "select * FROM  u_dest_cfg where  level=3  order by pid asc ";
        $dome_citys_3 = $this->db->query($sql_dome_3)->result_array();
        $dome_city = array();
        $dome_cityTab = array();
        foreach ($dome_citys_2 as $key => $val) {
            $dome_city ['id'] = $val ['id'];
            $dome_city ['name'] = $val ['kindname'];
            $dome_city ['childs'] = array();
            foreach ($dome_citys_3 as $k => $v) {
                if ($v ['pid'] == $val ['id']) {
                    $dome_city ['childs'] [] = array(
                        'id' => $v ['id'],
                        'name' => $v ['kindname']
                    );
                }
            }
            $dome_cityTab [] = $dome_city;
        }
        $reDataArr [] = array(
            "dome_city" => $dome_cityTab
        );
        /**
         * 周边游
         * wait development .
         * ..
         */
        /**
         * 主题游
         * wait development .
         * ..
         */
        $this->__outmsg($reDataArr);
    }

    /**
     * 写json数据在js文件里
     * */
    public function write() {
        $data = array();
        $data['a'] = 'test';
        $data['b'] = 'bbb';

        // 把PHP数组转成JSON字符串
        $json_string = "var AreaJson =" . json_encode($data);

        // 写入文件
        file_put_contents('assets/js/staticFile/area.js', $json_string);
    }

    /**
     * 读js文件里的json数据
     * */
    public function read() {
        $json_string = file_get_contents('assets/js/staticFile/area.js');
        $a = "var AreaJson =";
        $count = strpos($json_string, $a);
        $length = strlen($a);
        $str = substr_replace($json_string, "", $count, $length);
        echo $str;
        //$data = json_decode($str, true);
    }

    /**
     * @name：公共接口：上传图片
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    function upload() {
        $filename = $this->input->post('filename', true);  // $_FILE的name
        //上传图片路径
        $path = "../bangu/file/c/img/";
        $input_name = $filename;
        $photo = $this->cfgm_upload_pimg($path, $input_name);
        if (is_array($photo)) {
            $this->__errormsg("每次只能上传1张图片");
        }
        $return_path = "/file/c/img/";
        $kk = $return_path . $photo;
        echo json_encode(array('code' => 2000, 'msg' => $kk));
    }

    /**
     * @name：线路列表
     * @author: 温文斌          魏勇编辑
     * @param: num=当前页；pagesize=每页显示记录数；cityname=定位城市名； areaid=目的地，price=价格；day=天数；dest_id=线路种类
     *         sort=排序，label=标签,like=模糊搜索字段；
     * @return:
     *
     */
    public function cfgm_line_list() {

        //1、传值
        $cityid = $this->input->post('cityid', true);   // 定位的城市id
        //$cityid = "235";
        $areaid = intval($this->input->post('areaid', true)); //目的地ID（从目的地列表过来的）
        //$areaid="10454";
        $price = intval($this->input->post('price', true));   //价格
        $days = $this->input->post('day', true);     //出游天数
        $dest = $this->input->post('dest_id', true);    //线路种类
        $order = intval($this->input->post('sort', true));    //排序
        $label_id = $this->input->post('label', true);       // 标签（多选）
        $like = $this->input->post("like");                       //模糊搜索
        $page = $this->input->post("page");                       //当前页
        $page_size = intval($this->input->post('pagesize', true));  //每页显示记录数
        $token = $this->input->post('number', true);
        //$this->check_token($token);
        $m_id = $this->F_get_mid($token);
        //$m_id="291";
        //2、分页变量
        $page = empty($page) ? 1 : $page;
        $page_size = empty($page_size) ? 5 : $page_size;
        $from = ($page - 1) * $page_size; //from
        $where = "";
        $order_by = " order by l.peoplecount desc";
        $result = "";

        //3、加载model
        $this->load->model('app/u_area_model', 'area_model');
        $this->load->model('app/cfg_search_condition_model', 'cfg_search_condition');

        //4、排序
        if (!empty($order)) {
            if ($order == 2) { // 好评优先
                $order_by = " order by l.peoplecount desc";
            } elseif ($order == 3) { // 销量优先
                $order_by = " order by l.satisfyscore desc";
            } elseif ($order == 4) { // 价格由低到高
                $order_by = " order by l.lineprice desc";
            } elseif ($order == 5) { // 价格由高到低
                $order_by = " order by l.lineprice asc";
            }
        }

        //5、"价格"where条件
        if ($price) {
            $price_arr = $this->cfg_search_condition->row(array('id' => $price));
            $where .= " and (l.lineprice >= " . $price_arr ['minvalue'] . " and l.lineprice <= " . $price_arr ['maxvalue'] . ")";
        }

        //6、"出游天数"where条件
        if ($days) {
            $days_arr = $this->cfg_search_condition->row(array('id' => $days));
            $where .= " and  (l.lineday >= {$days_arr['minvalue']} and l.lineday <= {$days_arr['maxvalue']})";
        }

        //7、"线路种类"where条件
        if (!empty($dest_id)) {
            $dest_id = ltrim($dest, ','); //移除最后一个 ,符号
            if ($dest_id) {
                $l_kh = "";
                $r_kh = "";
                $dest_arr = explode(',', $dest_id);
                $i = count($dest_arr);
                foreach ($dest_arr as $key => $val) {
                    if ($i > 1) {
                        if ($key == 0) {
                            $l_kh = "(";
                        }
                        if ($key == $i - 1) {
                            $r_kh = ")";
                        }
                    }
                    if ($key == 0) {
                        $where .= " and {$l_kh} FIND_IN_SET({$val},l.overcity) > 0";
                    } else {
                        $where .= " or FIND_IN_SET({$val},l.overcity) > 0 {$r_kh}  ";
                    }
                }
            }
        }

        //8、"标签" where条件
        if ($label_id) {
            $l_kh = "";
            $r_kh = "";
            $label_arr = explode(',', $label_id);
            $i = count($label_arr);
            foreach ($label_arr as $key => $val) {
                if ($i > 1) {
                    if ($key == 0) {
                        $l_kh = "(";
                    }
                    if ($key == $i - 1) {
                        $r_kh = ")";
                    }
                }
                if ($key == 0) {
                    $where .= " and {$l_kh} FIND_IN_SET({$val},l.linetype)>0";
                } else {
                    $where .= "   or FIND_IN_SET({$val},l.linetype)>0 {$r_kh}";
                }
            }
        }

        //9、"目的地" where条件
        $title = "产品列表";
        if ($areaid) {

            $where .= "   and  FIND_IN_SET({$areaid},l.overcity)>0 ";

            $area = $this->db->query("select kindname from u_dest_cfg where id='{$areaid}'")->row_array();
//            var_dump("select kindname from u_dest_cfg where id='{$areaid}'".'-----------------------1121--------------');
//            file_put_contents('/tmp/mysql.txt', "select kindname from u_dest_cfg where id='{$areaid}'".'-----------------------1121--------------',FILE_APPEND);
            $title = $area['kindname'];
        }

        //10、"当前定位出发城市" where条件（若$city_name不为空，则从具体某个城市出发，否则全国出发）
        $all_redata = $this->db->query("SELECT id FROM u_startplace WHERE cityname='全国出发' ")->row_array();
//        var_dump("SELECT id FROM u_startplace WHERE cityname='全国出发' ".'---------------1127-------------------');
        $all_redataid = isset($all_redata['id']) ? $all_redata['id'] : '391'; //"全国出发"ID
//        file_put_contents('/tmp/mysql.txt', "(( $all_redataid || $areaid || $cityid ))SELECT id FROM u_startplace WHERE cityname='全国出发' ".'---------------1127-------------------',FILE_APPEND);

        if ($areaid) { //从“目的地列表”过来的时候，不做全国出发处理
            if ($cityid)
            // 根据cityid取出其子站点   $dest_sql = "SELECT * FROM cfgm_hot_dest WHERE startplaceid = $cityid OR startplaceid in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = $cityid) OR startplaceid = 391 ORDER BY showorder DESC, linenum DESC LIMIT 11";
                $where.="  and (FIND_IN_SET({$cityid},ls.startplace_id)>0 OR (ls.startplace_id in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = {$cityid})) OR FIND_IN_SET({$all_redataid},ls.startplace_id)>0)"; //城市出发
//                $where.="  and FIND_IN_SET({$cityid},ls.startplace_id)>0 "; //城市出发
        }
        else { //不是从“目的地列表”过来的时候，做全国出发处理
            if ($cityid) {
                $where.="  and (FIND_IN_SET({$cityid},ls.startplace_id)>0 or FIND_IN_SET({$all_redataid},ls.startplace_id)>0)"; //城市出发+全国出发
            } else {
                //全国出发
                $where .="  and FIND_IN_SET({$all_redataid},ls.startplace_id)>0";
            }
        }

        //11、"模糊搜索" where条件
        if ($like) {
            $where .= "  and (l.linename like'%{$like}%' or l.linetitle like '%{$like}%')";
        }
        //12、sql语句
        $sql = "   SELECT 
 		                    l.id,l.linename,l.linetitle,l.mainpic,l.lineprice,satisfyscore,
 		                    l.comment_count as comments,l.status,l.peoplecount,
 		                    l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname,
 		                	(SELECT	COUNT(*) FROM u_member_order AS mo WHERE l.id = mo.productautoid AND mo. STATUS > 4 ) AS volume, 	
 		                	l.collectnum,s.cityname as startplace,
 		                	(select count(1) from u_line_collect where member_id='{$m_id}' and line_id=l.id) as is_collect
 		            FROM 
 		                    u_line AS l
 		                    LEFT JOIN u_line_startplace AS ls ON l.id=ls.line_id
 		                    left join u_startplace as s on s.id=ls.startplace_id
 		                    left join u_expert as e on e.id=l.recommend_expert
 		                   
 		           WHERE 
 		                    l.status = 2 and l.producttype =0 {$where}
 		           GROUP BY 
 		                    ls.line_id  {$order_by}";
        //13、分页返回的sql
        $sql_page = $sql . " LIMIT {$from},{$page_size}";
        //$this->__errormsg($sql_page);
        //var_dump($sql_page);
        $query = $this->db->query($sql);
//        var_dump($sql.'-----1170-----');
        file_put_contents('/tmp/mysql.txt', "(( {$all_redataid} || {$areaid} || {$cityid} ))" . $sql . '-----1170-----', FILE_APPEND);
        $query_page = $this->db->query($sql_page);
//        var_dump($sql_page.'------1172---------');
//        file_put_contents('/tmp/mysql.txt', $sql_page.'------1172---------',FILE_APPEND);
        //14、数据结果
        $data['total_rows'] = $query->num_rows();
        $data ['line_list'] = $query_page->result_array();
        if (empty($data['line_list'])) {
            $this->__data($data ['line_list'], array('title' => $title));
        }

        //15、对"满意度"字段数据进行四舍五入
        foreach ($data ['line_list'] as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "satisfyscore") {
                    if ($v) {
                        //$val [$k] = round ( $v * 100 )."%";
                        $val [$k] = round($v * 100) . "";
                    }
                }
            }
            $data ['line_list'] [$key] = $val;
        }

        //16、返回结果
        $total = ceil($data ['total_rows'] / $page_size);
        $output['page'] = $page;
        $output['total'] = $total; //总页数
        $output['result'] = $data ['line_list'];
        $output['total_rows'] = $data ['total_rows'];
        $return['rows'] = $output;
        $this->__data($return, array('title' => $title));
    }

    /**
     * @name：目的地列表(new)
     * @author: 温文斌          魏勇编辑
     * @param: dest_id=目的地；page=当前页，pagesize=每页显示记录数
     * @return:
     *
     */
    public function cfgm_dest_list() {

        $dest_type = intval($this->input->get_post('dest_type', true)); //分类（1精选、2国内、3境外、4周边）
        $page = intval($this->input->post('page', true)); //页数
        $cityid = $this->input->get_post('cityid', true);  //出发城市
        //$cityid="235";
        //$dest_type="1";

        if (empty($cityid))
            $this->__errormsg('cityid不能为空');
        if (empty($dest_type))
            $this->__errormsg('dest_type不能为空');

        $this->load->model("app/cfgm_hot_dest_model", "cfgm_hot_dest_model");
        $page = empty($page) ? 1 : $page;
        $page_size = empty($page_size) ? 12 : $page_size;
        $from = ($page - 1) * $page_size; //from
        $sql_hot = "select
				ud.kindname as kindname,cd.name as description,cd.linenum as line_num, cd.pic as pic
				from
				cfgm_hot_dest as cd
                                left join u_dest_cfg as ud on ud.id=cd.dest_id
				where
				cd.is_show='1' and cd.status=1 
				order by cd.showorder desc, cd.linenum desc
				";
        if ($dest_type == "1") {//1、精选
            $pic = $this->db->query("select * from cfgm_index_roll_pic where kind=3 and status=1")->row_array();
//            var_dump("select * from cfgm_index_roll_pic where kind=3 and status=1".'------------1232------------');
//            file_put_contents('/tmp/mysql.txt', "select * from cfgm_index_roll_pic where kind=3 and status=1".'------------1232------------',FILE_APPEND);
//            $list = $this->cfgm_hot_dest_model->hot_dest_list(array('startplaceid' => $cityid), $from, $page_size);
//            $list = $this->db->query($sql_hot)->result_array();
//            $sql = 'SELECT kindname, description, line_num, pic FROM u_dest_cfg WHERE id not in (select dest_id from cfgm_hot_dest) and level = 3 AND pid in (SELECT id FROM u_dest_cfg WHERE pid = 2) AND isopen = 1 ORDER BY displayorder DESC, line_num DESC';
//            $list2 = $this->db->query($sql)->result_array();
//            $list = array_merge($list, $list2);
            $sql = "(select
				ud.id AS dest_id, ud.kindname as kindname,cd.name as description,cd.linenum as line_num, cd.pic as pic
				from
				cfgm_hot_dest as cd
                                left join u_dest_cfg as ud on ud.id=cd.dest_id
				where
				cd.is_show='1' and cd.status=1 
				order by cd.showorder desc, cd.linenum desc)
                    UNION
            (SELECT id AS dest_id, kindname, description, line_num, pic FROM u_dest_cfg WHERE id not in (select dest_id from cfgm_hot_dest) and level = 3 AND isopen = 1 ORDER BY displayorder DESC, line_num DESC) limit {$from},{$page_size}";
            $list = $this->db->query($sql)->result_array();
        } else if ($dest_type == "2") {//2、国内
            $pic = $this->db->query("select * from cfgm_index_roll_pic where kind=4 and status=1")->row_array();
//            var_dump("select * from cfgm_index_roll_pic where kind=4 and status=1".'----------------1236----------');
//            file_put_contents('/tmp/mysql.txt', "select * from cfgm_index_roll_pic where kind=4 and status=1".'----------------1236----------',FILE_APPEND);
            //$list = $this->cfgm_hot_dest_model->hot_dest_list(array('dest_type' => '2', 'startplaceid' => $cityid), $from, $page_size);
            $sql = "(select
				ud.id AS dest_id, ud.kindname as kindname,cd.name as description,cd.linenum as line_num, cd.pic as pic
				from
				cfgm_hot_dest as cd
                                left join u_dest_cfg as ud on ud.id=cd.dest_id
				where
				cd.is_show='1' and cd.status=1 AND cd.dest_type = 2
				order by cd.showorder desc, cd.linenum desc)
                    UNION
            (SELECT id AS dest_id, kindname, description, line_num, pic FROM u_dest_cfg WHERE id not in (select dest_id from cfgm_hot_dest) and level = 3 AND pid in (SELECT id FROM u_dest_cfg WHERE pid = 2) AND isopen = 1 ORDER BY displayorder DESC, line_num DESC) limit {$from},{$page_size}";
            $list = $this->db->query($sql)->result_array();
        } else if ($dest_type == "3") {//1、境外
            $pic = $this->db->query("select * from cfgm_index_roll_pic where kind=5 and status=1")->row_array();
//            var_dump("select * from cfgm_index_roll_pic where kind=5 and status=1".'-----------1240-------------');
//            file_put_contents('/tmp/mysql.txt', "select * from cfgm_index_roll_pic where kind=5 and status=1".'-----------1240-------------',FILE_APPEND);
//            $list = $this->cfgm_hot_dest_model->hot_dest_list(array('dest_type' => '1', 'startplaceid' => $cityid), $from, $page_size);
            $sql = "(select
				ud.id AS dest_id, ud.kindname as kindname,cd.name as description,cd.linenum as line_num, cd.pic as pic
				from
				cfgm_hot_dest as cd
                                left join u_dest_cfg as ud on ud.id=cd.dest_id
				where
				cd.is_show='1' and cd.status=1 AND cd.dest_type=1
				order by cd.showorder desc, cd.linenum desc)
                    UNION
            (SELECT id AS dest_id, kindname, description, line_num, pic FROM u_dest_cfg WHERE id not in (select dest_id from cfgm_hot_dest) and level = 3 AND pid in (SELECT id FROM u_dest_cfg WHERE pid = 1) AND isopen = 1 ORDER BY displayorder DESC, line_num DESC) limit {$from},{$page_size}";
            $list = $this->db->query($sql)->result_array();
        } else if ($dest_type == "4") {//3、周边
            $pic = $this->db->query("select * from cfgm_index_roll_pic where kind=6 and status=1")->row_array();
//            var_dump("select * from cfgm_index_roll_pic where kind=6 and status=1".'-------------1246--------------');
//            file_put_contents('/tmp/mysql.txt', "select * from cfgm_index_roll_pic where kind=6 and status=1".'-------------1246--------------',FILE_APPEND);
//            $list = $this->cfgm_hot_dest_model->hot_dest_list(array('dest_type' => '3', 'startplaceid' => $cityid), $from, $page_size);
            $sql = "(select
				ud.id AS dest_id, ud.kindname as kindname,cd.name as description,cd.linenum as line_num, cd.pic as pic
				from
				cfgm_hot_dest as cd
                                left join u_dest_cfg as ud on ud.id=cd.dest_id
				where
				cd.is_show='1' and cd.status=1 AND cd.dest_type = 3
				order by cd.showorder desc, cd.linenum desc)
                    UNION
            (SELECT id AS dest_id, kindname, description, line_num, pic FROM u_dest_cfg WHERE id not in (select dest_id from cfgm_hot_dest) and level = 3 AND isopen = 1 ORDER BY displayorder DESC, line_num DESC) limit {$from},{$page_size}";
            $list = $this->db->query($sql)->result_array();
        }

        $output = array(
            'list' => $list,
            'pic' => $pic,
            'page' => $page,
            'pagesize' => $page_size
        );

        $this->__data($output);
    }

    /**
     * @name：目的地列表
     * @author: 温文斌
     * @param: dest_id=目的地；page=当前页，pagesize=每页显示记录数
     * @return:
     *
     */
    public function cfgm_hot_area() {
        $page = intval($this->input->post('page', true));
        //$page="1";
        //注意：排序和筛选都是针对第3条数据之后的
        $dest_type = intval($this->input->post('dest_type', true)); //筛选（0全部、1境外、2国内、3周边）
        $sort = intval($this->input->post('sort', true)); //排序 (1默认、2线路数量降序、3是交易量降序)
        $content = $this->input->post('content', true);  //模糊搜索内容
        $cityid = $this->input->post('cityid', true);  //出发城市
        //$cityid="235";
        //$content="香港";
        //$dest_type="2";
        $content = trim($content);
        if (empty($cityid))
            $this->__errormsg('cityid不能为空');
        $page = empty($page) ? 1 : $page;
        //$page="1";
        $this->load->model("app/cfgm_hot_dest_model", "cfgm_hot_dest_model");
        //1、境外排名第一
        $jw = $this->cfgm_hot_dest_model->hot_dest_list(array('dest_type' => '1', 'startplaceid' => $cityid), "0", "1");
        //2、国内排名第一
        $gn = $this->cfgm_hot_dest_model->hot_dest_list(array('dest_type' => '2', 'startplaceid' => $cityid), "0", "1");
        //3、周边排名第一
        $zb = $this->cfgm_hot_dest_model->hot_dest_list(array('dest_type' => '3', 'startplaceid' => $cityid), "0", "1");

        //若带有搜索条件或者排序条件 ，就清除“国内游、周边游、出境游排名第一的目的地必定进入前三” 规则
        if ($dest_type || $sort || $content)
            $jw = $gn = $zb = array();
        //var_dump($jw);var_dump($gn);var_dump($zb);
        $num = count($jw) + count($gn) + count($zb);
        if ($page == "1") {
            $page_size = "5" - $num;
            $from = ($page - 1) * $page_size;
        } else {
            $page_size = "5";
            //第二页开始时
            if ($num > 0) {
                $from = ($page - 2) * $page_size + ($num - 1);
            } else {
                $from = ($page - 1) * $page_size;
            }
        }

        $dest_id = ($this->input->post('dest_id', true)); //目的地ID
        $where = array();
        if (!empty($dest_id))
            $where['dest_id'] = $dest_id;
        if (!empty($dest_type))
            $where['dest_type'] = $dest_type;
        if (!empty($sort))
            $where['sort'] = $sort;
        if (!empty($cityid))
            $where['startplaceid'] = $cityid; //出发城市
        if (!empty($content)) {
            $where['content'] = $content;
            $page_size = "1000";
        }

        //4、目的地列表（去除排名前3）
        $not_in = "";
        if (isset($jw['0']['id']))
            $not_in.=$jw['0']['id'] . ",";
        if (isset($gn['0']['id']))
            $not_in.=$gn['0']['id'] . ",";
        if (isset($zb['0']['id']))
            $not_in.=$zb['0']['id'] . ",";
        if (!empty($not_in))
            $where['not_in'] = substr($not_in, 0, -1);
        //var_dump($where['not_in']);
        $reDataArr = $this->cfgm_hot_dest_model->hot_dest_list($where, $from, $page_size);
        //返回数据
        if ($page == "1")
            $output = array_merge($jw, $gn, $zb, $reDataArr);
        else
            $output = $reDataArr;
        //var_dump($reDataArr);
        $this->__outmsg($output);
    }

    /**
     * @name：83、管家搜索
     * @author: 温文斌       
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_list() {
        //1、传值
        $page = $this->input->post("page"); // 当前页数
        $page_size = $this->input->post("page_size"); // 每页显示记录条数
        $city_name = $this->input->post('cityname', true); // 定位城市名
        $qy_id = $this->input->post('qy_id', true); // 区域id
        $e_grade = $this->input->post('type', true); // 专家等级
        $sex = $this->input->post('sex', true); // 性别
        $dest_id = $this->input->post('dest', true); // 目的地 多选
        //二级目的地和三级目的地相关联；如搜索港澳台，则需搜出香港澳门台湾三个，且搜索香港澳门台湾任意一个，需搜出港澳台
        if (!empty($dest_id)) {
            $dest_array = array();
            $arr = explode(",", $dest_id);
            foreach ($arr as $a => $b) {
                //二级
                $two = $this->db->query("select id,kindname from u_dest_cfg where (id='{$b}' or pid='{$b}') and isopen=1 and (level=2 or level=3)")->result_array();
                foreach ($two as $o => $e) {
                    array_push($dest_array, $e['id']);
                }
                //三级
                $three = $this->db->query("select id,pid,kindname from u_dest_cfg where id='{$b}' and isopen=1 and level=3")->result_array();
                foreach ($three as $o => $e) {
                    array_push($dest_array, $e['id']);
                    array_push($dest_array, $e['pid']);
                }
            }
            $dest_array = array_unique($dest_array);
            $dest_id = join(",", $dest_array);
        }
        //end

        $order = $this->input->post('sort', true); // 排序
        $like = $this->input->post('like', true); // 模糊搜索


        $lat = $this->input->post('lat', true); // 经度 多选
        $lon = $this->input->post('lon', true); // 纬度 多选
        $len = $this->input->post('len', true); // 长度 多选
        //2、分页处理
        $page = empty($page) ? 1 : $page; // 当前页
        $page_size = empty($page_size) ? 5 : $page_size; // 每页的条数
        $from = ($page - 1) * $page_size; //
        $where = "";
        $order_by = "";

        //3、排序
        if ($order) {
            if ($order == 5) { // 按管家积分由高到低排序
                $order_by = 'order by e.online desc,e.satisfaction_rate desc,e.people_count desc,e.id desc';
            } elseif ($order == 1) { // 按在线优先
                $order_by = ' order by online desc,e.satisfaction_rate desc';
            } elseif ($order == 2) { // 满意度 高到低
                $order_by = ' order by e.satisfaction_rate desc,e.online desc';
            } elseif ($order == 3) { // 年度销量 高到低
                $order_by = ' order by  e.order_amount desc';
            } elseif ($order == 4) { // 年度成交人次 高到低
                $order_by = ' order by e.people_count desc';
            } elseif ($order == 6) { // 按管家积分由高到低排序
                $order_by = ' order by total_score desc,e.online desc';
            }
        } else {
            $order_by = 'order by e.online desc,e.satisfaction_rate desc,e.people_count desc,e.id desc';
        }

        //4、"当前定位城市" where条件
        if ($city_name) {
            $this->load->model('app/u_area_model', 'area_model');
            $city_data = $this->area_model->get_row_city($city_name);
            if ($city_data) {
                $city_id = $city_data ['id'];
            }
            if (!empty($city_id)) {
                $where .= " and e.city in ({$city_id})";
            }
        }

        //5、"lat、lon" 经纬度 where 条件
        if ($lat && $lon && $len) {   //根据经纬度查询并且匹配最近管家
            $this->load->library('Geohash');
            $geohash = $this->geohash->encode_geohash($lat, $lon, $len);
            $expands = $this->geohash->getGeoHashExpand($geohash);
            $expands0 = $expands [0];
            $expands1 = $expands [1];
            $expands2 = $expands [2];
            $expands3 = $expands [3];
            $expands4 = $expands [4];
            $expands5 = $expands [5];
            $expands6 = $expands [6];
            $expands7 = $expands [7];
            $expands8 = $expands [8];
            $where .= " and (uel.geohash like '{$expands0}%'  or uel.geohash like '{$expands1}%' or uel.geohash like '{$expands2}%' or uel.geohash like '{$expands3}%' or uel.geohash like '{$expands4}%' or uel.geohash like '{$expands5}%' or uel.geohash like '{$expands6}%' or uel.geohash like '{$expands7}%' or uel.geohash like '{$expands8}%' or uel.geohash like '{$geohash}%' )";
        }

        //6、"线路种类" where条件
        $where_dest = "";
        if ($dest_id) {
            $l_kh = "";
            $r_kh = "";
            $dest_arr = explode(',', $dest_id);
            $i = count($dest_arr);
            foreach ($dest_arr as $key => $val) {
                if ($i > 1) {
                    if ($key == 0) {
                        $l_kh = "(";
                    }
                    if ($key == $i - 1) {
                        $r_kh = ")";
                    }
                }
                if ($key == 0) {
                    $where_dest .= " where {$l_kh} find_in_set({$val},A.expert_destid)>0 ";
                } else {
                    $where_dest .= " or find_in_set({$val},A.expert_destid)>0 {$r_kh}";
                }
            }
        }
        //7、"性别" where条件
        if ($sex) {
            if ($sex == 1) {
                $where .= " and e.sex=1";
            } elseif ($sex == 2) {
                $where .= " and e.sex=0";
            }
        }
        //8、"区域" where条件
        if ($qy_id) {
            $l_kh = "";
            $r_kh = "";
            $qy_id_arr = explode(',', $qy_id);
            $i = count($qy_id_arr);
            foreach ($qy_id_arr as $key => $val) {
                if ($i > 1) {
                    if ($key == 0) {
                        $l_kh = "(";
                    }
                    if ($key == $i - 1) {
                        $r_kh = ")";
                    }
                }
                if ($key == 0) {
                    $where .= " and  {$l_kh} find_in_set({$val},e.visit_service)";
                } else {
                    $where .= " or find_in_set({$val},e.visit_service) {$r_kh}";
                }
            }
        }
        //9、"管家级别" where条件
        if ($e_grade) {
            if ($e_grade != 5) {
                $where .= " and e.grade={$e_grade}";
            } else {
                $where .= " and e.isstar=1";
            }
        }
        //10、"模糊搜索" where条件

        if ($like) {
            $where .= "  and (e.nickname like'%{$like}%' or e.realname like '%{$like}%')";
        }

        //11、sql语句
        $sql_init = "
      SELECT
      e.id AS expert_id,e.small_photo,e.sex,e.online,e.nickname,e.realname,e.comment_count,
      eg.title AS grade,e.praise_num,
      e.expert_theme, e.satisfaction_rate AS satisfaction_rate , e.total_score,e.people_count, ua.name AS cityname,
      e.visit_service as visit_serviceid,(select GROUP_CONCAT(name SEPARATOR ' ') from u_area where level=4 and FIND_IN_SET(id,e.visit_service) >0 )as visit_service,
      e.expert_dest as expert_destid,(select GROUP_CONCAT(d.kindname SEPARATOR ' ') as expert_dest from u_dest_cfg as d where FIND_IN_SET(d.id,e.expert_dest)) as expert_dest

      FROM
      u_expert AS e
      LEFT JOIN u_area AS ua ON e.city=ua.id
      LEFT JOIN u_expert_location AS uel ON e.id=uel.eid
      left join u_expert_grade as eg on e.grade=eg.grade
      WHERE
      e.status=2 and e.is_kf='N' {$where}
      group by
      e.id {$order_by}
      ";

        $sql = "SELECT
      A.*
      FROM(
      " . $sql_init . "
      )A{$where_dest}
      ";
        $sql_page = $sql . " LIMIT {$from},{$page_size}";
        $query = $this->db->query($sql_init);
        $query_page = $this->db->query($sql_page);

        //12、数据结果
        $expert_list = $query_page->result_array();
        $total_rows = $query->num_rows();
        $total = ceil($total_rows / $page_size);

        //13、数据处理（满意度四舍五入）
        foreach ($expert_list as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "satisfaction_rate") {
                    if ($v) {
                        $val [$k] = round($v * 100);
                    }
                }
            }
            $expert_list [$key] = $val;
        }
        if (empty($expert_list)) {
            $this->__outmsg($expert_list);
        }

        //14、返回结果
        $output = array(
            'cur_page' => $page,
            'total' => $total,
            'result' => $expert_list,
            'total_rows' => $total_rows
        );
        $this->__outmsg($output);
    }

    /**
     * @name：线路详情
     * @author: 温文斌
     * @param: number=凭证；lineid=线路ID；usertype=区分管家和用户
     * @return:
     *
     */
    public function cfgm_line_detail() {
        $l_id = intval($this->input->post('lineid', true));
        $token = $this->input->post('number', true);
        $usertype = $this->input->post('usertype', true);  //用户类型：用户是0，管家是1
        //$l_id="918";
        if (!$l_id)
            $this->__errormsg('线路id不能为空');
        if ($usertype != "0" && $usertype != "1")
            $this->__errormsg('usertype参数有误');
        $ouput = $this->F_line_detail_more($l_id); //线路详情

        $ouput['data']['satisfyscore'] = substr($ouput['data']['satisfyscore'], 0, -1); //满意度去掉百分号
        //登录状态时：查询用户是否收藏过该线路、增加浏览记录
        $ouput['is_collect'] = "no";
        if ($token && $usertype == '0') {
            //是否收藏
            //$this->check_token ( $token );
            $m_id = $this->F_get_mid($token);

            $is_collect = $this->db->query("select id from u_line_collect where line_id={$l_id} and member_id={$m_id}")->num_rows();

            if ($is_collect > 0)
                $ouput['is_collect'] = "yes";
            else
                $ouput['is_collect'] = "no";
            //添加浏览记录
            $this->load->model('app/u_line_browse_model', 'line_browse_model');
            $result = $this->line_browse_model->row(array('line_id' => $l_id, 'member_id' => $m_id));
            if (empty($result)) {  //插入新数据
                $llData = array(
                    'member_id' => $m_id,
                    'line_id' => $l_id,
                    'times' => 0,
                    'addtime' => date('Y-m-d H:i:s', time())
                );
                $this->line_browse_model->insert($llData);
            } else {   //更新times
                $this->line_browse_model->update(array('addtime' => date('Y-m-d H:i:s', time()), 'times' => ++$result ['times']), array('line_id' => $l_id));
            }
        }
        //线路表u_line的shownum字段+1
        $this->load->model('app/u_line_model', 'u_line_model');
        $this->u_line_model->update(array('shownum' => $ouput['data']['shownum'] + 1), array('id' => $l_id));

        //分享到空间、微博时的来链接
        $ouput['lianjie'] = "http://www.1b1u.com/cj/" . $l_id;

        //返回数据结果
        $this->__data($ouput);
    }

    /**
     * @name：线路套餐
     * @author: 温文斌
     * @param: suitid=线路ID；
     * @return:
     *
     */
    public function cfgm_line_suit() {
        $l_id = $this->input->post('suitid', true); //线路id
        //$l_id="918";
        is_numeric($l_id) ? ($l_id) : $this->__errormsg('线路id不能为空');
        $reDataArr = $this->db->query("SELECT id,suitname FROM `u_line_suit` where lineid = {$l_id} ")->result_array();
        if (empty($reDataArr)) {
            $this->__errormsg();
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：线路价格日期
     * @author: 温文斌
     * @param: suitid=线路ID；
     * @return:
     *
     */
    public function cfgm_price_date() {
        $suit_id = $this->input->post('suitid', true); //套餐id
        //$suit_id="956";	
        is_numeric($suit_id) ? ($suit_id) : $this->__errormsg('套餐id不能为空');

        $suit = $this->db->query("select s.*,l.linebefore from u_line_suit as s left join u_line as l on l.id=s.lineid where s.id='{$suit_id}'")->row_array();
        //var_dump($suit['linebefore']);  //提前n天预订
        $where = array(
            'ls.id' => $suit_id,
            'day >' => date('Y-m-d', time() + $suit['linebefore'] * 24 * 3600)
        );
        $this->db->select("lsp.day,lsp.adultprice AS adult_price,lsp.childprice AS kid_price");
        $this->db->from("u_line_suit_price AS lsp");
        $this->db->join("u_line_suit AS ls", "lsp.suitid=ls.id", "left");
        $this->db->where($where);
        $this->db->order_by("lsp.day");
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        if (!empty($reDataArr)) {
            foreach ($reDataArr as $key => $val) {
                $reDataArr [$val ['day']] = $val;
                unset($reDataArr [$val ['day']] ['day']);
                unset($reDataArr [$key]);
            }
        }
        //获得本月和下月的天数
        $now_month_day = date('t');
        $next = $this->getNextMonthDays(date("Y-m-d H:i:s"));
        $next_month_day = $next['2'];

        $output['rows'] = $reDataArr;
        $this->__data($output, array('now_month_day' => $now_month_day, 'next_month_day' => $next_month_day));
    }

    /**
     * 获得下月的第一天和最后一天和总天数
     * */
    private function getNextMonthDays($date) {
        $timestamp = strtotime($date);
        $arr = getdate($timestamp);
        if ($arr['mon'] == 12) {
            $year = $arr['year'] + 1;
            $month = $arr['mon'] - 11;
            $firstday = $year . '-0' . $month . '-01';
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
            $total_day = date('d', strtotime("$firstday +1 month -1 day"));
        } else {
            $firstday = date('Y-m-01', strtotime(date('Y', $timestamp) . '-' . (date('m', $timestamp) + 1) . '-01'));
            $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));
            $total_day = date('d', strtotime("$firstday +1 month -1 day"));
        }
        return array($firstday, $lastday, $total_day);
    }

    /**
     * @name：线路套餐详情
     * @author: 温文斌
     * @param: lineid=线路ID；suitid=套餐ID；number=凭证
     * @return:
     *
     */
    public function cfgm_suit_line_detail() {
        //1、传值
        $l_id = $this->input->post('lineid', true);
        $suit_id = $this->input->post('suitid', true);
        $day = $this->input->post('day', true);
        $token = $this->input->post('number', true);

        //$suit_id = "878";
        //$day = "2016-04-15";
        //$l_id = "910";
        //2、验证
        $this->check_token($token);
        is_numeric($l_id) ? ($l_id) : $this->__errormsg('tip is null !');
        is_numeric($suit_id) ? ($suit_id) : $this->__errormsg('tip is null !');

        //3、用户信息

        $userid = $this->F_get_mid($token);
        $reDataArr ['user'] = $this->db->query("		select truename,mobile,email from u_member WHERE	mid = {$userid} ")->row_array();

        //4、线路详情、积分
        $line = $this->db->query("select l.id AS line_id,l.linename,l.overcity,l.linetitle,l.lineday,l.beizu,l.child_description,l.child_nobed_description,l.old_description,l.special_description,l.special_appointment ,l.safe_alert ,l.feeinclude ,l.feenotinclude,l.other_project ,l.insurance   ,l.visa_content  from u_line AS l where l.id={$l_id} ")->row_array();
        $linecity = $this->db->query("SELECT ul.supplier_id AS supplier_id,CONCAT(us.company_name,us.brand) AS company_name,GROUP_CONCAT(usp.cityname) AS startcity_name  	
										FROM  	u_line AS ul 	
										LEFT JOIN u_supplier AS us ON ul.supplier_id = us.id
										LEFT JOIN u_line_startplace AS ls ON ul.id=ls.line_id
										LEFT JOIN u_startplace AS usp ON ls.startplace_id=usp.id	
										WHERE	ul.id ={$l_id} AND ul. STATUS = 2  ")->row_array();
        $userjf = $this->db->query("		SELECT 	jifen 	FROM  	u_member m 	WHERE	mid = {$userid} ")->row_array();
        $reDataArr ['line'] = array_merge($line, $linecity, $userjf);

        // 5、  $num:  境内2、境外1
        $num = "2"; //默认是2：境内
        $overcity = explode(',', $line['overcity']);
        if (in_array('1', $overcity)) {
            $num = "1"; //境外
        }
        $reDataArr ['coun'] = $num;

        //6、保险  $num：境内、境外   ；$line['lineday']：天数
        $reDataArr ['insurance'] = $this->db->query("	
				select 
		              t.*,d.description as insurance_kind_name
		 
		        from 
		             u_travel_insurance as t
				     left join u_dictionary as d on t.insurance_kind=d.dict_id
		        where 
		             t.insurance_date='{$line['lineday']}' and t.insurance_type='{$num}' and t.status=1
		          ")->result_array();
        //对“保险”期限重组，并赋给insurance_date字段
        foreach ($reDataArr ['insurance'] as $key => $value) {

            $reDataArr ['insurance'][$key]['insurance_date'] = $value['min_date'] . "～" . $value['insurance_date'] . "天";
        }

        //7、线路套餐
        $where = "";
        if (!empty($suit_id)) {
            $where .= "and ls.id={$suit_id} ";
        }
        if (!empty($day)) {
            $where .= "and lsp.`day`='{$day}'";
        }
        $sql = "select ls.id AS suit_id,ls.suitname,ls.unit,lsp.day,lsp.adultprice,lsp.oldprice,lsp.childnobedprice,lsp.childprice from u_line_suit AS ls left join u_line_suit_price AS lsp on lsp.suitid=ls.id where ls.lineid={$l_id} {$where}";
        $query = $this->db->query($sql);
        $suit = $query->result_array();
        $reDataArr ['suit'] = $suit;

        //8、管家
        $sql = "select e.id AS expert_id,e.nickname,e.small_photo,CASE WHEN la.grade=1 THEN '管家' WHEN la.grade=2 THEN '初级专家' WHEN la.grade=3 THEN '中级专家' WHEN la.grade=4 THEN '高级专家' end grade  from u_expert AS e left join u_line_apply AS la on e.id=la.expert_id where e.status=2 and la.status=2 and e.is_kf='N' and la.line_id={$l_id}";
        $query = $this->db->query($sql);
        $reDataArr ['expert'] = $query->result_array();



        $sql = "  SELECT	cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,cc.min_price, cc.min_price,	cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url 	FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id 	WHERE cmc.status=0 and cc.status='1' and cmc.member_id={$userid}";
// 		$sql2 = "SELECT 	cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,cc.min_price,cc.min_price, 	cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url 	FROM cou_member_coupon AS cmc LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id 	WHERE cmc.status!=0 and cc.status='1' and cmc.member_id={$userid}";
        $query = $this->db->query($sql);
// 		$query2 = $this->db->query ( $sql2 );
        $reDataArr ['vol_new'] = $query->result_array(); // 优惠卷未使用、已使用
// 		$reDataArr ['vol_old'] = $query2->result_array (); // 优惠卷已过期
        $this->__outmsg($reDataArr, 1);
    }

    /**
     * @name：线路收藏
     * @author: 温文斌
     * @param: number=凭证；scid=线路ID
     * @return:
     *
     */
    public function cfgm_sc_line() {
        $status = 0;
        $token = $this->input->post('number', true);
        $this->check_token($token);
        $m_id = $this->F_get_mid($token);
        //$m_id="291";
        $sc['line_id'] = $this->input->post('scid', true);
        if ($sc['line_id']) {
            $query = $this->db->query("select line_id from u_line_collect where line_id={$sc['line_id']} and member_id={$m_id}");
            $sc_arr = $query->result_array();
            if ($sc_arr) { // 如果有就取消			
                $status = $this->db->query("delete from u_line_collect where line_id={$sc['line_id']} and member_id={$m_id}");
                $this->db->query("update u_line set `collectnum`=`collectnum`-1 where id = {$sc['line_id']}");   //更新线路收藏数	
            } else { // 没有就添加
                $sc ['member_id'] = $m_id;
                $sc ['addtime'] = date('Y-m-d H:i:s', time());
                $status = $this->db->insert('u_line_collect', $sc);
                $this->db->query("update u_line set `collectnum`=`collectnum`+1 where id = {$sc['line_id']}");   //更新线路收藏数					
            }
        }
        if ($status) {
            $this->__successmsg();
        }
    }

    /**
     * @param: 手机号
     * @param: 密码
     * @param： 1是普通注册，2是自动注册
     * 
     * */
    private function user_register($mobile, $password, $type = "1") {
        $this->db->trans_begin();
        //注册
        $addtime = date('Y-m-d H:i:s');
        $this->load->model('app/u_member_model', 'member_model');
        //配置表中的“送多少积分”
        $this->load->model('app/cfg_member_point_model', 'cfg_member_point');
        $point_row = $this->cfg_member_point->row(array('code' => 'REGISTER', 'isopen' => '1'));
        $nickname = substr_replace($mobile, "****", 3, 4);  // 137****4462
        $data = array(
            'loginname' => $mobile,
            'pwd' => md5($password),
            'mobile' => $mobile,
            'litpic' => '/file/c/img/face.png',
            'jointime' => $addtime,
            'nickname' => $nickname,
            'sex' => - 1,
            'register_channel' => 'APP注册',
            'jifen' => $point_row['value']
        );
        $mid = $this->member_model->insert($data);
        //送积分日志
        $memberLogArr = array(
            'member_id' => $mid,
            'point_before' => 0,
            'point_after' => $point_row['value'],
            'point' => $point_row['value'],
            'content' => '注册赠送积分',
            'addtime' => $addtime
        );
        $result = $this->db->insert('u_member_point_log', $memberLogArr);
        //发送短信
        if ($type == "1") {
            $this->load->model('app/u_sms_template_model', 'u_sms_template_model');
            $template = $this->u_sms_template_model->row(array('msgtype' => 'member_register'));
            $content = str_replace("{#loginname#}", $mobile, $template['msg']);
            $content = str_replace("{#ID#}", $mid, $content);
            $this->send_message($mobile, $content);
        } else {
            $smsData = "尊敬的帮游会员，系统已为您自动注册账号，可在会员中心查看定制单信息，账号为{$mobile}，密码为{$password}。为安全起见，请尽快修改密码，谢谢。";
            $this->send_message($mobile, $smsData);
        }

        $return = array('mid' => $mid);
        //事务
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $return['status'] = false;
        } else {
            $this->db->trans_commit();
            $return['status'] = true;
        }
        return $return;
    }

    /**
     * @name：用户注册
     * @author: 温文斌
     * @param: mobile=手机号；password=密码；code=验证码
     * @return:
     *
     */
    public function cfgm_user_register() {
        $this->load->library('session');
        $mobile = $this->input->post('mobile', true);
        $password = $this->input->post('password', true);
        $code = $this->input->post('code', true);

        //$mobile="13751174462";
        //$password="123456";

        if (empty($mobile))
            $this->__errormsg('手机号码不能为空！');
        if (!preg_match("/1[34578]{1}\d{9}$/", $mobile))
            $this->__errormsg('手机号码格式错误');
        if (empty($password))
            $this->__errormsg('密码不能为空！');

        $code_mobile = $this->session->userdata('mobile');
        $code_number = $this->session->userdata('code');
        if (($code_mobile == $mobile) && ($code_number == $code)) {
            $result = $this->db->query("select * from u_member where mobile={$mobile}")->row_array();
            if (empty($result)) {
                $status = $this->user_register($mobile, $password);
                if ($status['status'])
                    $this->__data('注册成功');
                else
                    $this->__errormsg('注册失败');
            }
            else {
                $this->__errormsg("该手机号已存在");
            }
        } else
            $this->__errormsg("验证码错误");
    }

    /**
     * @name：用户登录
     * @author: 温文斌
     * @param: mobile=手机号；password=密码；md5=
     * @return:
     *
     */
    public function cfgm_user_login() {
        $mobile = $this->input->post('mobile');
        $password = $this->input->post('password');
        $registrationId = $this->input->post('registrationId', true); //设备id
        $md5 = $this->input->post('md5');
        is_numeric($mobile) ? $mobile : $this->__errormsg("账号或密码错误");
        if (empty($password)) {
            $this->__errormsg('密码不能为空');
        }
        $this->load->model('app/u_member_model', 'mm_model');
        $result = $this->mm_model->result(array(
            'mobile' => $mobile
                ), null, null, null, 'arr', null, '*');
        if ($result) {
            if (md5($password) == $result [0] ['pwd']) {
                // 登录成功后 更新或插入token，接口访问时验证token是否过期
                $this->load->library('token');
                $token_arr = $this->token->getToken($result [0] ['mid']);
                $token = (array) json_decode($token_arr);
                $this->result_code = "1";
                $this->result_msg = "success";
                $lastData ['rows'] = array(
                    // 0 => array(
                    'key' => $token ['key'],
                    'id' => $result [0] ['mid'],
                    'nickname' => $result [0] ['nickname'],
                    'litpic' => $result [0] ['litpic']
                );
                //绑定设备
                if ($registrationId) {
                    $this->mm_model->update(array('equipment_id' => $registrationId), array('mid' => $result [0] ['mid']));
                }

                $this->result_data = $lastData;
                $this->resultJSON = json_encode(array(
                    "msg" => $this->result_msg,
                    "code" => $this->result_code,
                    "data" => $this->result_data,
                    "total" => "0"
                ));
                echo $this->resultJSON;
                exit();
            } elseif ($password == $result [0] ['pwd'] && $md5 == 'md5') {
                $this->load->library('token');
                $token_arr = $this->token->getToken($result [0] ['mid']);
                $token = (array) json_decode($token_arr);
                $this->result_code = "1";
                $this->result_msg = "success";
                $lastData ['rows'] = array(
                    // 0 => array(
                    'key' => $token ['key'],
                    'id' => $result [0] ['mid'],
                    'nickname' => $result [0] ['nickname'],
                    'litpic' => $result [0] ['litpic']
                        )
                // )
                ;
                $this->result_data = $lastData;
                $this->resultJSON = json_encode(array(
                    "msg" => $this->result_msg,
                    "code" => $this->result_code,
                    "data" => $this->result_data,
                    "total" => "0"
                ));
                echo $this->resultJSON;
                exit();
            } else {
                $this->result_code = "-3";
                $this->result_msg = "账号或密码错误";
                $lastData ['rows'] = array();
                $this->result_data = $lastData;
                $this->resultJSON = json_encode(array(
                    "msg" => $this->result_msg,
                    "code" => $this->result_code,
                    "data" => $this->result_data,
                    "total" => "0"
                ));
                echo $this->resultJSON;
                exit();
            }
        } else {
            $this->__errormsg('账号不存在');
        }
    }

    /**
     * @name：下订单操作
     * @author: 温文斌
     * @param:number=凭证；line_id=线路ID；expert_id=管家ID；suitid=套餐ID；indent_day=出游日期
     *        adult_number=出游成年人数；elder_number=出游老人数；child_bed_num=出游占床儿童数；child_not_bed_num=出游不占床儿童数
     *        linkman=联系人姓名；linkemail=联系人邮箱；linkman_phone=联系人手机号
     * @return:
     *
     */
    public function cfgm_add_order() {
        //1、session
        $this->load->library('session', true);
        $code_number = $this->session->userdata('code');
        $code_mobile = $this->session->userdata('mobile');
        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        //2、加载数据模型
        $this->load->model('app/u_sms_template_model', 'template_model');
        $this->load->model('admin/b1/order_status_model', 'order_status_model');
        $this->load->model('app/u_line_model', 'l_model');
        $this->load->model('app/u_supplier_model', 's_model');
        $this->load->model('app/u_expert_model', 'e_model');

        //3、post传值
        $token = isset($_REQUEST['number']) ? $_REQUEST['number'] : ''; //用户session
        $this->check_token($token);

        $line_id = isset($_REQUEST['line_id']) ? $_REQUEST['line_id'] : ''; //线路id
        $expert_id = isset($_REQUEST['expert_id']) ? $_REQUEST['expert_id'] : ''; //管家id
        $suitid = isset($_REQUEST['suitid']) ? $_REQUEST['suitid'] : '';   //套餐id
        $indent_day = $use_date = isset($_REQUEST['indent_day']) ? $_REQUEST['indent_day'] : ''; //出游天数
        $oldnum = isset($_REQUEST['elder_number']) ? $_REQUEST['elder_number'] : '';    //老人数
        $childnum = isset($_REQUEST['child_bed_num']) ? $_REQUEST['child_bed_num'] : '';    //小孩数
        $childnobednum = isset($_REQUEST['child_not_bed_num']) ? $_REQUEST['child_not_bed_num'] : ''; //小孩不占床数
        $linkman = isset($_REQUEST['linkman']) ? $_REQUEST['linkman'] : '';  //出游人名
        $linkemail = isset($_REQUEST['linkemail']) ? $_REQUEST['linkemail'] : ''; //出游人邮件
        $linkmobile = isset($_REQUEST['linkman_phone']) ? $_REQUEST['linkman_phone'] : '';
        $point = isset($_REQUEST['jifen']) ? $_REQUEST['jifen'] : '0';  //积分
        $coupon_choose = isset($_REQUEST['coupon_choose']) ? $_REQUEST['coupon_choose'] : ''; //优惠券
        $insuranceJson = isset($_REQUEST['insuranceList']) ? $_REQUEST['insuranceList'] : ''; //保险
        $touristList = isset($_REQUEST['touristList']) ? $_REQUEST['touristList'] : ''; //游客信息

        $dingnum = isset($_REQUEST['adult_number']) ? $_REQUEST['adult_number'] : '';  //成年人数
        $menu_num = isset($_REQUEST['menu_num']) ? $_REQUEST['menu_num'] : ''; // 套餐数
        //4、验证
        if (empty($linkmobile)) {
            $this->__wapmsg('用户手机不能为空！', $callback);
        }
        $this->load->helper('regexp');
        if (!regexp('mobile', $linkmobile)) {
            $this->__wapmsg('用户手机号码输入有误', $callback);
        }

        //5、用户、管家信息
        $m_id = $this->F_get_mid($token);
        $this->load->model('app/u_member_model', 'member_model');
        $reData_member = $this->member_model->row(array('mid' => $m_id));

        $this->load->model('app/u_expert_model', 'expert_model');
        $reData_expert = $this->expert_model->row(array('id' => $expert_id));

        //6、下订单前验证
        if (empty($line_id))
            $this->__wapmsg('线路id不能为空', $callback);
        if (empty($expert_id))
            $this->__wapmsg('管家id不能为空', $callback);
        if (empty($suitid))
            $this->__wapmsg('套餐id不能为空', $callback);
        if (empty($indent_day))
            $this->__wapmsg('出团日期不能为空', $callback);

        $expertDatapn = $this->e_model->row(array('id' => $expert_id)); //管家信息
        $lineData = $this->l_model->row(array('id' => $line_id));  //线路信息
        $supplierData = $this->s_model->row(array('id' => $lineData ['supplier_id'])); //	供应商信息

        $now_date = date('Y-m-d'); //现在的时间
        $linebefore = $lineData['linebefore'];
        $deadline = date('Y-m-d', strtotime($indent_day) - $linebefore * 24 * 3600); //截止日期   $indent_day（出团日期）
        if ($now_date > $deadline)
            $this->__wapmsg('线路需提前' . $linebefore . '天预订', $callback);  //  if($deadline>$date) echo "ok";














            
//6（2）、下订单
        if (empty($dingnum)) {
            $this->load->model('app/u_line_suit_model', 'u_line_suit_model');
            $linesuit = $this->u_line_suit_model->row(array('id' => $suitid)); //套餐
            $data['suitnum'] = $menu_num;  //套餐数
            $data['dingnum'] = $menu_num * $linesuit['unit']; // dingnum=menu_nun*unit
        } else {
            $data ['dingnum'] = $dingnum;
        }
        $data ['productautoid'] = $line_id; //线路id
        $data ['expert_id'] = $expert_id; //管家id
        $data ['suitid'] = $suitid;   //套餐id
        $data ['usedate'] = $indent_day; //出游天数
        $data ['oldnum'] = $oldnum;  //老人数
        $data ['childnum'] = $childnum; //小孩数
        $data ['childnobednum'] = $childnobednum; //小孩不占床数
        $data ['linkman'] = $linkman;    //出游人名
        $data ['linkemail'] = $linkemail;   //出游人邮件
        $data ['linkmobile'] = $linkmobile;   //出游人电话
        //积分
        $data ['jifen'] = $point;
        if ($reData_member ['jifen'] >= $point) {
            if ($point > 0) {
                $data ['jifenprice'] = $point / 100;
            } else {
                $data ['jifenprice'] = '0';
            }
        } else {
            $data ['jifenprice'] = '0';
            $this->__wapmsg('积分不足', $callback);
        }
        // 优惠卷的价格
        $data ['couponprice'] = "0";
        if (!empty($coupon_choose)) {
            $this->load->model('app/cou_member_coupon_model', 'member_coupon_model');
            $coupon_one_temp = $this->member_coupon_model->page_my_coupon_order($m_id, array('id' => $coupon_choose));
            $coupon_one = $coupon_one_temp ['new'];
            $data ['couponprice'] = isset($coupon_one [0] ['coupon_price']) ? $coupon_one [0] ['coupon_price'] : '0';
        }
        //儿童价格、老人价格
        $this->load->model('app/u_line_suit_price_model', 'line_suit_model');
        $reData = $this->line_suit_model->row(array(
            'suitid' => $suitid,
            'lineid' => $line_id,
            'day' => $indent_day
        ));
        $data ['price'] = $reData ['adultprice'];
        if ($dingnum) {//单人套餐才存储以下字段
            $data ['childprice'] = $reData ['childprice'];
            $data ['oldprice'] = $reData ['oldprice'];
            $data ['childnobedprice'] = $reData ['childnobedprice'];
        } else {
            $data['childprice'] = "0";
            $data['oldprice'] = "0";
            $data['childnobedprice'] = "0";
        }
        // 订单价格=出团费用 ；实付价格=订单价格-积分价格-优惠券价格
        ////包括“单人”套餐和“多人”套餐2种情况
        if ($dingnum) {
            $data ['order_price'] = $data ['dingnum'] * $data ['price'] + $data ['childnum'] * $data ['childprice'] + $data ['oldnum'] * $data ['oldprice'] + $data ['childnobednum'] * $data ['childnobedprice'];
        } else {
            $data ['order_price'] = $menu_num * $data ['price'];
        }
        $data ['total_price'] = $data ['order_price'] - $data ['jifenprice'] - $data ['couponprice']; // -$data['couponprice'];总价格等于订单价格-优惠价格-积分/100
        // 保险
        $insurance_price = $settlement_price = 0;
        if (!empty($insuranceJson)) {
            foreach ($insuranceJson as $in => $in_value) {
                // 保险价格
                $insurance_price = $insurance_price + ($in_value ['insurance_price'] * $in_value ['insurance_num']);
                $settlement_price = $settlement_price + ($in_value ['settlement_price'] * $in_value ['insurance_num']);
            }
            $data['isbuy_insurance'] = "1"; //是否买了保险
        }
        $data ['insurance_price'] = $insurance_price;
        $data ['settlement_price'] = $settlement_price;
        // 生成订单号
        $year = date('Y', time());
        $month = date('m', time());
        while (true) {
            $ordersn = substr($year, 2) . $month . mt_rand(10000000, 99999999);
            if ($this->F_create_ordersn($ordersn)) {
                break;
            }
        }
        $data ['ordersn'] = $ordersn;
        // 管家佣金、代理费
        if (!empty($expert_id)) {
            if ($expertDatapn['supplier_id'] == $lineData ['supplier_id']) {
                $data ['agent_fee'] = 0;
            } else {
                if (!$dingnum)
                    $data ['agent_fee'] = $lineData['agent_rate_int'] * $menu_num; //管家*套餐数
                else
                    $data ['agent_fee'] = $lineData['agent_rate_int'] * ($data['dingnum'] + $data['oldnum']) + $lineData['agent_rate_child'] * ($data['childnum'] + $data['childnobednum']); //佣金*人数
            }
        }
        else {
            $data ['agent_fee'] = 0;
        }
        $data ['agent_rate'] = isset($supplierData['agent_rate']) ? $supplierData['agent_rate'] : '0';   //agent_rate
        $data ['platform_fee'] = $data ['agent_rate'] * $data ['total_price']; //平台佣金费
        $data ['productname'] = $lineData ['linename'];                 //线路名
        $data ['litpic'] = $lineData ['mainpic'];                     //线路图
        $data ['expert_name'] = $expertDatapn ['nickname'];              //管家昵称
        $data ['supplier_name'] = $supplierData ['company_name'];            //供应商名
        $data ['supplier_id'] = $lineData ['supplier_id'];
        //其他
        $data ['channel'] = 1;
        $data ['memberid'] = $m_id;
        $data ['ispay'] = 0;
        $data ['status'] = 0;
        $data ['addtime'] = date('Y-m-d H:i:s', time());

        //6、数据操作 u_member表、u_member_point_log表、cou_member_coupon表、u_member_order表
        $this->db->trans_start();
        // u_member表
        $this->member_model->update(array('jifen' => $reData_member ['jifen'] - $point), array('mid' => $m_id));
        //u_member_point_log表
        $this->load->model('app/u_member_point_log_model', 'u_member_point_log');
        $point_log = array(
            'point_before' => $reData_member ['jifen'],
            'point_after' => $reData_member ['jifen'] - $point,
            'member_id' => $m_id,
            'point' => $point,
            'content' => '下单支付积分',
            'addtime' => date("Y-m-d H:i:s")
        );
        if ($point > '0') {
            $this->u_member_point_log->insert($point_log);
        }
        // cou_member_coupon表
        if (is_numeric($coupon_choose)) {
            $this->load->model('app/cou_member_coupon_model', 'cou_member_coupon');
            $this->cou_member_coupon->update(array('status' => '1'), array('id' => $coupon_choose));
        }
        // u_member_order订单表
        $status = $this->db->insert('u_member_order', $data);

        // u_member_order_log、u_member_order_attach表
        $order_id = $this->db->insert_id();
        $this->order_status_model->update_order_status_cal($order_id); //统计订单ID状态用
        $log = array(
            'order_id' => $order_id,
            'op_type' => 0,
            'userid' => $data ['memberid'],
            'content' => '会员自己下单',
            'addtime' => $data ['addtime']
        );
        $status = $this->db->insert('u_member_order_log', $log);
        $status_attach = $this->db->insert('u_member_order_attach', array('orderid' => $order_id));
        // u_order_insurance表
        if (!empty($insuranceJson)) {
            $this->load->model("app/u_order_insurance_model", "u_order_insurance");
            foreach ($insuranceJson as $insu => $insu_value) {
                $insu_data = array(
                    'order_id' => $order_id,
                    'insurance_id' => $insu_value ['insurance_id'],
                    'number' => $insu_value ['insurance_num'],
                    'amount' => $insu_value ['settlement_price'] * $insu_value ['insurance_num']
                );
                $insu_result = $this->u_order_insurance->insert($insu_data);
            }
        }
        // u_member_traver 、u_member_order_man游客信息表
        if (!empty($touristList)) {
            foreach ($touristList as $k => $v) {
                $tour ['name'] = isset($v ['name']) ? $v ['name'] : $this->__wapmsg(' 游客姓名不能为空！', $callback);
                $tour ['certificate_type'] = isset($v ['cardtype']) ? $v ['cardtype'] : $this->__wapmsg(' 游客证件类别不能为空！', $callback);
                $tour ['certificate_no'] = isset($v ['cardnum']) ? $v ['cardnum'] : $this->__wapmsg(' 证件号码不能为空！', $callback);
                $tour ['sex'] = isset($v ['sex']) ? $v ['sex'] : $this->__wapmsg(' 性别不能为空！', $callback);
                $tour ['telephone'] = isset($v ['phone']) ? $v ['phone'] : $this->__wapmsg(' 游客手机号不能为空！', $callback);
                $tour ['birthday'] = isset($v ['birthtime']) ? $v ['birthtime'] : $this->__wapmsg(' 游客出生日期不能为空！', $callback);
                if ((empty($v ['enname'])) && (empty($v ['issueAddr'])) && (empty($v ['issuetime'])) && (empty($v ['validtime']))) {
                    $tour ['enname'] = '';
                    $tour ['sign_place'] = '';
                    $tour ['sign_time'] = '';
                    $tour ['endtime'] = '';
                } else {
                    $tour ['enname'] = isset($v ['enname']) ? $v ['enname'] : $this->__wapmsg(' 游客英文名字不能为空！', $callback);
                    $tour ['sign_place'] = isset($v ['issueAddr']) ? $v ['issueAddr'] : $this->__wapmsg(' 签发地不能为空！', $callback);
                    $tour ['sign_time'] = isset($v ['issuetime']) ? $v ['issuetime'] : $this->__wapmsg(' 签发日期不能为空！', $callback);
                    $tour ['endtime'] = isset($v ['validtime']) ? $v ['validtime'] : $this->__wapmsg(' 有效期不能为空！', $callback);
                }
                $tour ['member_id'] = $m_id;
                $tour ['addtime'] = date('Y-m-d H:i:s', time());
                $status = $this->db->insert('u_member_traver', $tour);
                $traver_id = $this->db->insert_id();
                // 订单关联的出游人信息
                $order_man = array(
                    'order_id' => $order_id,
                    'traver_id' => $traver_id
                );
                $status = $this->db->insert('u_member_order_man', $order_man);
            }
        } else {
            $this->__wapmsg('游客信息不能为空！', $callback);
        }
        // 事务结束
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            //发送短信给用户、管家、供应商
            if (!empty($lineData)) {
                // 供应 msg
                $smsData = $this->template_model->row(array('msgtype' => 'order_leave'));
                if (!empty($smsData ['msg'])) {
                    $msg = str_replace("{#LINENAME#}", $lineData ['linename'], $smsData ['msg']);
                    $this->send_message($supplierData ['mobile'], $msg);
                }
                // user msg
                $userData = $this->template_model->row(array('msgtype' => 'line_order_msg1'));
                if (!empty($userData ['msg'])) {
                    $msg = str_replace("{#PRODUCTNAME#}", $lineData ['linename'], $userData ['msg']);
                    $this->send_message($linkmobile, $msg);
                }
                // expert msg
                if (!empty($expert_id)) {
                    $expertrData = $this->template_model->row(array('msgtype' => 'expert_order'));
                    if (!empty($expertrData ['msg'])) {
                        $msg = str_replace("{#LINENAME#}", $lineData ['linename'], $expertrData ['msg']);
                        $this->send_message($expertDatapn ['mobile'], $msg);
                    }
                }
            }
            //输出结果
            $output[0] = array(
                'orderid' => $order_id,
                'data' => $data,
                // 'insurance'=>isset($insurance)? $insurance:'',
                // 'order_price'=>$data['order_price'],
                // 'jifen'=>$data['jifenprice'],
                // 'coupon'=>isset($coupon_one)? $coupon_one:'',
                // 'total_price'=>$data['total_price'],
                'dingnum' => $dingnum,
                'name' => $reData_member ['nickname'],
                'phone' => $reData_member ['mobile'],
                'expertphone' => $reData_expert ['mobile'],
                'order_sn' => $ordersn
            );
            $this->__wap($output, $callback);
            /* $this->result_code = "2000";
              $this->result_msg = "success";
              $lastData ['rows'] = array (
              0 => array (
              'orderid' => $order_id,

              'name' => $reData_member ['nickname'],
              'phone' => $reData_member ['mobile'],
              'expertphone' => $reData_expert ['mobile'],
              'order_sn' => $ordersn
              )
              );

              $this->result_data = $lastData;
              $this->resultJSON = json_encode ( array (
              "msg" => $this->result_msg,
              "code" => $this->result_code,
              "data" => $this->result_data,
              "total" => "0"
              ) );
              echo $this->resultJSON;
              exit (); */
        } else {
            $this->db->trans_rollback(); // 事务回滚
            $this->__wapmsg('订单生成失败', $callback);
        }
        //end	
    }

    /**
     * @name：订单评价
     * @author: 温文斌
     * @param:orderid=订单ID;number=凭证；dyfw=导游服务；cyzs=餐饮住宿；xcap=行程安排；lyjt=旅游交通
     *        zytd=专业态度；fwtd=服务态度
     * @return:
     *
     */
    public function cfgm_submit_comment() {
        $pics = "";
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $m_id = $this->F_get_mid($token);
        $data ['orderid'] = $order_id = intval($this->input->post('order_id', true));
        $data ['score1'] = intval($this->input->post('dyfw', true)); // 导游服务
        $data ['score3'] = intval($this->input->post('cyzs', true)); // 餐饮住宿
        $data ['score2'] = intval($this->input->post('xcap', true)); // 行程安排
        $data ['score4'] = intval($this->input->post('lyjt', true)); // 旅游交通
        $data ['score5'] = intval($this->input->post('zytd', true)); // 专业态度
        $data ['score6'] = intval($this->input->post('fwtd', true)); // 服务态度
        $data ['content'] = $this->input->post('estimate', true); // 线路评价
        $data ['expert_content'] = $this->input->post('expert_comment', true); // 管家评价
        $data ['isanonymous'] = intval($this->input->post('is_anonymity', true)); // 匿名评价
        $data ['avgscore1'] = ($data ['score1'] + $data ['score2'] + $data ['score3'] + $data ['score4']) / 4; // 线路综合评分
        $data ['avgscore2'] = ($data ['score5'] + $data ['score6']) / 2; // 专家综合评分
        $data ['memberid'] = $m_id;
        $data ['channel'] = 1;
        $data ['isshow'] = 1;
        $data ['addtime'] = date('Y-m-d H:i:s', time());
        $this->load->model('app/u_member_order_model', 'order_model');
        $order = $this->order_model->row(array(
            'id' => $order_id
        ));
        if ($order) {
            $data ['expert_id'] = $order ['expert_id'];
            $data ['line_id'] = $order ['productautoid'];
        } else {
            $this->__errormsg('order is not exist');
        }

        /* if (empty ( $data ['orderid'] ) || empty ( $data ['score1'] ) || empty ( $data ['score2'] ) || empty ( $data ['score3'] ) || empty ( $data ['score4'] ) || empty ( $data ['score5'] ) || empty ( $data ['score6'] )) {
          $this->__errormsg ( '信息填写不完整' );
          } */
        // 上传图片
        if ($_FILES) {
            $path = "file/c/img/";
            $len = count($_FILES);

            $i = 0;
            foreach ($_FILES as $key => $val) {
                $i += 1;
                if ($i < $len) {
                    $dh = ",";
                } else {
                    $dh = "";
                }
                if ($val) {
                    $input_name = $key;
                    $fx_pic = $this->cfgm_upload_pimg($path, $input_name);
                    $pics .= "/file/c/img/" . $fx_pic . $dh;
                }
            }
            $data ['pictures'] = $pics;
            $data ['haspic'] = 1;
        }
        $this->load->model('app/cfg_member_point_model', "cfg_member_point");
        $this->load->model('app/u_member_model', "u_member");
        $line_upload_img = $this->cfg_member_point->row(array(
            'code' => 'COMMENT_PIC',
            'isopen' => '1'
        )); // 上传图片送积分
        $line_text_comment = $this->cfg_member_point->row(array(
            'code' => 'COMMENT_TEXT',
            'isopen' => '1'
        )); // 文字评价送积分
        $line_more_text_comment = $this->cfg_member_point->row(array(
            'code' => 'COMMENT_TEXT_1',
            'isopen' => '1'
        )); // 超过30文字送积分
        $line_star_comment = $this->cfg_member_point->row(array(
            'code' => 'COMMENT_NO_TEXT',
            'isopen' => '1'
        )); // 星级评价送积分
        $total_point = 0; // 总积分
        if (!empty($data ['score1']) && !empty($data ['score2']) && !empty($data ['score3']) && !empty($data ['score4'])) {
            $total_point += isset($line_star_comment ['value']) ? $line_star_comment ['value'] : '0';
        }
        if (!empty($pics)) {
            $total_point += isset($line_upload_img ['value']) ? $line_upload_img ['value'] : '0';
        }
        if (!empty($data ['content'])) {
            if (mb_strlen($data ['content']) < 30) {
                $total_point += isset($line_text_comment ['value']) ? $line_text_comment ['value'] : '0'; // 不超过30字
            } else {
                $total_point += isset($line_more_text_comment ['value']) ? $line_more_text_comment ['value'] : '0'; // 超过30字
            }
        }
        $this->db->trans_start(); // 事务开启
        $status = $this->db->insert('u_comment', $data);
        if ($status) {
            $this->db->update('u_member_order', array(
                'status' => 6
                    ), array(
                'id' => $data ['orderid']
            ));
        }
        $one = $this->u_member->row(array(
            'mid' => $m_id
        ));
        $jifen = isset($one ['jifen']) ? $one ['jifen'] : '0';
        $update = $this->u_member->update(array(
            'jifen' => $total_point + $jifen
                ), array(
            'mid' => $m_id
        ));
        // 积分记录
        $this->load->model('app/u_member_point_log_model', 'u_member_point_log');
        $logArr = array(
            'member_id' => $m_id,
            'point_before' => $jifen,
            'point_after' => $total_point + $jifen,
            'point' => $total_point,
            'content' => '订单点评赠送积分',
            'addtime' => date('Y-m-d H:i:s', time())
        );

        if ($update) { // 送积分成功后，才存记录
            $this->u_member_point_log->insert($logArr);
        }
        $comment_count_status = $this->db->query("update u_line set `comment_count`=`comment_count`+1 where id = {$data ['line_id']}");   //更新线路评论数
        $comment_count_status_expert = $this->db->query("update u_expert set `comment_count`=`comment_count`+1 where id = {$order ['expert_id']}");   //更新管家评论数
        if (!$comment_count_status) {
            $this->__errormsg('评价数添加有误！');
        }
        $this->db->trans_complete(); // 事务结束
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback(); // 事务回滚
            $this->__errormsg('评价失败');
        }

        $this->__successmsg();
    }

    /**
     * @name：取消定制单
     * @author: 温文斌
     * @param:cid=定制单ID;number=凭证；
     * @return:
     *
     */
    public function cfgm_update_status_del() {
        $token = $this->input->post('number', true);
        $this->check_token($token);
        $cid = $this->input->post('cid', true);
        is_numeric($cid) ? ($cid) : $this->__errormsg('tip is null !');
        $this->load->model('app/u_customize_model', 'customize_model');
        $result = $this->customize_model->update(array(
            'status' => '-2'
                ), array(
            'id' => $cid
        ));
        if ($result) {
            echo json_encode(array('code' => 2000, 'msg' => '取消成功!'));
        } else {
            echo json_encode(array('code' => 4000, 'msg' => '取消失败!'));
        }
    }

    /**
     * @name：得到定制单详细信息
     * @author: 温文斌
     * @param:cid=定制单ID;
     * @return:
     *
     */
    public function cfgm_customize_info() {
        $c_id = $this->input->post('cid', true);
        //$c_id="698";
        is_numeric($c_id) ? ($c_id) : $this->__errormsg('tip is null !');
        $sql = "SELECT ca.id as ca_id,c.pic AS litpic,c.days,c.question AS question,c.addtime AS addtime,c.budget AS budget,e.small_photo AS small_photo,e.id,e.nickname AS expert_name,c.people AS people_count,e.avg_score AS avg_score,e.total_score AS total_score,eg.title AS e_grade,(SELECT GROUP_CONCAT(d.kindname SEPARATOR ',') FROM u_dest_cfg AS d WHERE FIND_IN_SET(d.id,e.expert_dest)>0) AS good_dest FROM u_customize AS c LEFT JOIN u_customize_answer AS ca ON c.id=ca.customize_id LEFT JOIN u_expert AS e ON ca.expert_id=e.id LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade WHERE c.id= {$c_id}  AND ca.isuse=1 ";
        $query = $this->db->query($sql);
        $reDataArr = $query->result_array();
        if ($reDataArr) {
            $ca_id = $reDataArr [0] ['ca_id'];
        } else {
            $this->__outmsg($reDataArr);
        }
        $sql = "SELECT cj.id,day,title,transport,breakfirst as breakfirsthas,lunch as lunchhas,supper as supperhas,hotel,jieshao ,`cjp`.`pic` AS pic FROM u_customize_jieshao as cj LEFT JOIN `u_customize_jieshao_pic` AS cjp ON `cj`.`id`=`cjp`.`customize_jieshao_id` WHERE customize_answer_id={$ca_id} ORDER BY day";
        $query = $this->db->query($sql);
        $reDataArrs = $query->result_array();
        foreach ($reDataArrs as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "pic") {
                    if ($v) {
                        $val [$k] = explode(";", $v);
                        foreach ($val [$k] as $k) {
                            if (!empty($k)) {
                                $val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
                            }
                        }
                        $val ['pic'] = '1';
                    }
                }
            }
            $reDataArrs [$key] = $val;
        }
        $arr ['fangan'] = $reDataArrs;
        if ($arr ['fangan']) {
            $reDataArr = array_merge($reDataArr [0], $arr);
        } else {
            $this->__errormsg();
        }
        $this->__outmsg($reDataArr, 1);
    }

    /**
     * @name：用户个人中心的数据
     * @author: 温文斌
     * @param:number=凭证;
     * @return:
     *
     */
    public function cfgm_walk_count() {
        $token = $this->input->post('number', true);
        $m_id = $this->input->post('mid', true);
        //$m_id="291";
        if (!$m_id) {
            $this->check_token($token);
            $m_id = $this->F_get_mid($token);
        }

        $sql = "SELECT 
					(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND ispay=0 AND (mb_od.status=1) AND mb_od.ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())<24) AS wait_pay, 
					(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND (mb_od.status=1 or mb_od.status=4) AND ispay>0) AS wait_walk,
					(SELECT count(*) FROM u_member_order AS mb_od LEFT JOIN u_member AS mb ON mb_od.memberid = mb.mid WHERE mb.mid ={$m_id} AND mb_od.status=5 AND ispay>0) AS wait_comment,
					(SELECT count(*) FROM u_refund AS r LEFT JOIN u_member_order AS mo ON r.order_id=mo.id WHERE r.refund_type=0 AND r.status=0 AND r.refund_id={$m_id}) AS wait_tk 
				FROM 
						u_member_order AS mb_od 
				WHERE 
						mb_od.memberid={$m_id}  order by mb_od.memberid  limit 1        ";
        $query = $this->db->query($sql);
        $reDataArr ['four'] = $query->row_array();
        $query = $this->db->query("select mid,nickname,litpic from u_member where mid={$m_id} order by mid limit 1 ");
        $reDataArr ['user'] = $query->row_array();
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：管家游记列表
     * @author: 温文斌
     * @param:page=当前页；pagesize=每页显示记录数；eid=管家ID
     * @return:
     *
     */
    public function cfgm_note_comment_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $eid = $this->input->post("eid");
        is_numeric($eid) ? ($eid) : $this->__errormsg('标识不能为空！');
        $sql = "     SELECT `m`.`mid` AS m_id, `tn`.`id` AS note_id, `m`.`litpic` AS litpic, `m`.`nickname` AS nickname, `tnr`.`reply_content` AS reply_content, `tnr`.`addtime` AS publish_time    
FROM (`travel_note_reply` AS tnr)     
LEFT JOIN `travel_note` AS tn ON `tnr`.`note_id`=`tn`.`id`      
LEFT JOIN `u_member` AS m ON `tnr`.`member_id`=`m`.`mid`    
WHERE `tn`.`id` = {$eid} ORDER BY `tnr`.`addtime` desc      limit {$from},{$page_size}  ";
        $query = $this->db->query($sql);
        $data ['line_list'] = $query->result_array();
        if (empty($data ['line_list'])) {
            $this->__outmsg($data ['line_list']);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $data_total = $query->num_rows();
        $data = array(
            'cur_page' => $from,
            'total' => $page_size,
            'result' => $data ['line_list']
        );
        $this->__outmsg($data, $data_total);
    }

    /**
     * @name：个人中心-》我的分享
     * @author: 温文斌
     * @param:number=凭证；page=当前页；pagesize=每页显示记录数；
     * @return:
     *
     */
    public function cfgm_my_share() {
        //分页
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('pagesize', true);
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = empty($page) ? 1 : $page;
        $from = ($page - 1) * $page_size;

        //用户id
        $token = $this->input->post('number', true);
        $m_id = $this->input->post('mid', true);
        //$m_id="291";
        if (!$m_id) {
            $this->check_token($token);
            $m_id = $this->F_get_mid($token);
        }
        //“我的分享”
        $sql = "SELECT 
						ls.line_id,ls.content,ls.location,ls.addtime,l.linename,
						(select GROUP_CONCAT(pic) from u_line_share_pic where line_share_id=ls.id) as pic
				from 
						u_line_share AS ls 
						LEFT JOIN u_line AS l ON l.id=ls.line_id 
				WHERE 
						ls.member_id={$m_id} LIMIT {$from},{$page_size}";
        $query = $this->db->query($sql);
        $reDataArr = $query->result_array();
        foreach ($reDataArr as $key => $val) {
            if (!empty($val['pic'])) {
                $pic_arr = explode(',', $val ['pic']);
                $pic_arr = $this->__doImage($pic_arr);
                $val['pic'] = $pic_arr;
            }

            //月份
            $val['month'] = substr($val['addtime'], 5, 2);
            $val['day'] = substr($val['addtime'], 8, 2);

            $reDataArr [$key] = $val;
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：个人中心-》我的浏览记录
     * @author: 温文斌
     * @param:number=凭证；page=当前页；pagesize=每页显示记录数；
     * @return:
     *
     */
    public function cfgm_browse_record() {
        //分页
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('pagesize', true);
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = empty($page) ? 1 : $page;
        $from = ($page - 1) * $page_size;

        //用户id
        $token = $this->input->post('number', true);
        $m_id = $this->input->post('mid', true);
        //$m_id="291";
        if (!$m_id) {
            $this->check_token($token);
            $m_id = $this->F_get_mid($token);
        }

        //“我的浏览记录”
        $this->db->select('l.id,l.linename,l.mainpic,l.satisfyscore,l.lineprice');
        $this->db->from('u_line_browse AS lb');
        $this->db->join('u_line AS l', 'l.id=lb.line_id', 'left');
        $this->db->where(array(
            'lb.member_id' => $m_id,
            'l.status' => 2
        ));
        $this->db->order_by("l.addtime", "asc");
        $this->db->limit($page_size, $from);
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        foreach ($reDataArr as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "satisfyscore") {
                    if ($v) {
                        $val [$k] = round($v * 100);
                    }
                }
            }
            $reDataArr [$key] = $val;
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：个人中心-》我的收藏
     * @author: 温文斌      魏勇编辑
     * @param:number=凭证；page=当前页；pagesize=每页显示记录数；
     * @return:
     *
     */
    public function cfgm_my_collection() {
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('pagesize', true);
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = empty($page) ? 1 : $page;
        $from = ($page - 1) * $page_size;

        //用户id
        $token = $this->input->post('number', true);
        $m_id = $this->input->post('mid', true);
        //$m_id="291";
        if (!$m_id) {
            $this->check_token($token);
            $m_id = $this->F_get_mid($token);
        }

        $type = $this->input->post('loca', true); //类型： 1、我收藏的线路、2、我收藏的管家
        //$type="1";
        if (empty($type))
            $this->__errormsg("type值不能为空");
        // 1、我收藏的线路
        if ($type == '1') {
            $sql = "SELECT 
							lc.line_id,l.linename,l.lineday,l.lineprice,l.mainpic    
					FROM 
							u_line_collect as lc	    
							LEFT JOIN u_line as l ON l.id=lc.line_id    
					WHERE 
							lc.member_id =  '{$m_id}' and l.line_status=1   
					ORDER BY 
							lc.addtime desc limit   {$from},{$page_size}      
					";
            $reDataArr = $this->db->query($sql)->result_array();
            if (empty($reDataArr)) {
                $this->__outmsg($reDataArr);
            }
        } else {  //2、我收藏的管家
//            $sql = " 
//					SELECT 
//								e.id,e.small_photo,e.nickname,eg.title,e.satisfaction_rate,e.people_count,e.comment_count  
//					FROM 
//								u_expert_collect AS ec  	
//								LEFT JOIN u_expert AS e ON ec.expert_id=e.id  
//								LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade  
//					WHERE 
//								ec.member_id= {$m_id} and e.id is not null 	
//					ORDER BY 
//							    ec.addtime desc limit {$from},{$page_size}       
//					";
            $sql = " 
					SELECT 
								e.id,e.small_photo,e.nickname,eg.title,e.satisfaction_rate,e.people_count,e.comment_count,
                                                                e.realname, e.login_name, e.big_photo, e.province, e.city, e.start_city_id, e.service_time,
                                                                e.honor, e.visit_service, e.grade, e.credit, e.expert_dest, e.order_count, m_bgpic,
                                                                e.attention_count, e.company_name, e.country, e.sex, e.isstar
					FROM 
								u_expert_collect AS ec  	
								LEFT JOIN u_expert AS e ON ec.expert_id=e.id  
								LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade  
					WHERE 
								ec.member_id= {$m_id} and e.id is not null 	
					ORDER BY 
							    ec.addtime desc limit {$from},{$page_size}       
					";
            $reDataArr = $this->db->query($sql)->result_array();
            // 管家擅长目的地处理
            foreach ($reDataArr as &$val) {
                $val['expert_dest'] = $this->generate_chn_array($val['expert_dest']);
            }
            if (empty($reDataArr)) {
                $this->__outmsg($reDataArr);
            }
            //满意度处理
            foreach ($reDataArr as $key => $val) {
                foreach ($val as $k => $v) {
                    if ($k == "satisfaction_rate") {
                        if ($v) {
                            $val [$k] = round($v * 100);
                        }
                    }
                }
                $reDataArr [$key] = $val;
            }
            //满意度处理end
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：个人中心-》我的优惠券    新版本
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_my_coupon() {
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('pagesize', true);
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = empty($page) ? 1 : $page;
        $from = ($page - 1) * $page_size;

        $token = $this->input->post('number', true);
        $mid = $this->input->post('mid', true);

        if (!$mid) {
            $this->check_token($token);
            $mid = $this->F_get_mid($token);
        }
        //$mid="291";
        $sql = "SELECT
						cmc.id AS 'id',cmc.coupon_id as coupon_id,cmc.member_id as member_id,cmc.status as status,  cc.name as name,cc.pic as pic,cc.starttime as starttime,cc.endtime as endtime,cc.coupon_price as coupon_price,cc.use_url as use_url
				FROM
						cou_member_coupon AS cmc
						LEFT JOIN cou_coupon AS cc ON cmc.coupon_id=cc.id
				WHERE
						cc.status=1 and cmc.member_id={$mid}
				order by
						FIELD (cmc.status,0,1,-1),id desc
				
			 ";  // 按"未使用"、"已使用"、"已过期"排序
        $sql_page = $sql . " limit {$from},{$page_size} ";

        $reDataArr ['result'] = $this->db->query($sql_page)->result_array();
        if (empty($reDataArr ['result']))
            $this->__data($reDataArr ['result']);
        $reDataArr ['total_rows'] = $this->db->query($sql)->num_rows();
        $reDataArr ['page_size'] = $page_size;
        $reDataArr ['page'] = $page;
        $reDataArr ['total_page'] = ceil($reDataArr ['total_rows'] / $page_size);

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：个人中心-》我的礼品
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_my_prize() {
        $token = $this->input->post('number', true);
        $m_id = $this->input->post('mid', true);

        $page = $this->input->post('page', true);
        $page_size = $this->input->post('pagesize', true);
        $page_size = empty($page_size) ? 8 : $page_size;
        $page = empty($page) ? 1 : $page;
        $from = ($page - 1) * $page_size;
        //$m_id="291";
        if (!$m_id) {
            $this->check_token($token);
            $m_id = $this->F_get_mid($token);
        }

        $sql = "SELECT   
						lg.id,lg.worth,lg.gift_name,lg.status as isnormal,lg.starttime,lg.endtime,
						lgm.id as lgm_id,lgm.status AS 'isuse'      
				FROM 
						luck_gift_member AS lgm 
						LEFT JOIN luck_gift AS lg ON lgm.gift_id=lg.id      
			   WHERE 
						lgm.member_id={$m_id} 
				order by 
						lgm.status,lgm.addtime desc ";
        $sql_page = $sql . " limit {$from},{$page_size}";

        $reDataArr ['result'] = $this->db->query($sql_page)->result_array();
        if (empty($reDataArr ['result']))
            $this->__data($reDataArr ['result']);
        $reDataArr ['total_rows'] = $this->db->query($sql)->num_rows();
        $reDataArr ['page_size'] = $page_size;
        $reDataArr ['page'] = $page;
        $reDataArr ['total_page'] = ceil($reDataArr ['total_rows'] / $page_size);

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：个人中心-》我的礼品详情
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_my_prize_detail() {
        $token = $this->input->post('number', true);
        $m_id = $this->input->post('mid', true);
        $lg_id = $this->input->post('lg_id', true);
        //$lg_id="55";
        //$m_id="291";

        if (!$m_id) {
            $this->check_token($token);
            $m_id = $this->F_get_mid($token);
        }
        is_numeric($lg_id) ? ($lg_id) : $this->__errormsg('lg_id不能为空');
        //礼品信息
        $reDataArr ['data'] = $this->db->query(
                        "SELECT     
						lg.id as gift_id,lg.logo as pic,lg.worth,lg.gift_name,lg.description,lg.starttime,lg.endtime,      
						lgm.status,case when lgm.status=0 then '未使用' when lgm.status=1 then '已使用' when lgm.status=2 then '已过期' end as status_CH,
						CONCAT(s.company_name,s.brand) AS 'suppliername',lg. STATUS AS isnormal,lgm.member_id  
				FROM    
						luck_gift_member AS lgm    
						LEFT JOIN luck_gift AS lg ON lgm.gift_id = lg.id    
						LEFT JOIN u_supplier AS s ON lg.supplier_id = s.id   
				WHERE     
						lgm.id = {$lg_id}")->row_array();
        if (empty($reDataArr ['data']))
            $this->__errormsg('礼品不存在');
        else {
            if ($m_id != $reDataArr ['data']['member_id'])
                $this->__errormsg('抱歉，这不是你的礼品', '404');
        }
        //礼品适用于的 “线路”
        $reDataArr['data']['line_list'] = $this->db->query(
                        "SELECT   
							l.id,l.linename,l.mainpic      
				 FROM     
							 luck_gift_member AS lgm     
							 LEFT JOIN luck_gift_line AS lgl ON lgm.gift_id = lgl.gift_id 
				             left join u_line as l on lgl.line_id=l.id      
		 
				 WHERE    
							 lgm.id = {$lg_id} AND l. STATUS = 2 AND lgl. STATUS = 1 
				group by     
							 lgl.line_id
				"
                )->result_array();

        //生成二维码
        $this->load->library('qr_code_lib'); //二维码库
        $this->load->library('encrypt'); //加密解密库
        $encrypt_id = $this->encrypt->getEncryptString($lg_id); //加密id

        $url = "http://m.1b1u.com/home/use_prize?lgm_id=" . $encrypt_id; //二维码存储的信息
        $file = "/file/qrcodes/gift/" . "L" . $lg_id . ".jpg";
        @$this->qr_code_lib->jpg($url, '../bangu' . $file);

        //返回二维码的路径
        $reDataArr['data']['filepath'] = $file;

        $this->__data($reDataArr);
    }

    /**
     * @name：个人中心-》我的定制
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_my_customize_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $m_id = $this->F_get_mid($token);
        //$m_id="149";

        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $sql = "
				SELECT  
						c.id,c.startplace,us.cityname, 
						(select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace) >0 )as dest , 
						(SELECT COUNT(*) FROM u_customize_reply AS r WHERE r.customize_id=c.id and r.answer_id!=0) AS answer_num,
						(SELECT COUNT(*) FROM u_customize_reply AS r WHERE r.customize_id=c.id) AS expert_num,
						c.addtime,
						 CASE 
						     WHEN c. STATUS = 3 THEN '已完成'
							 WHEN c. STATUS = - 3 THEN '已过期'
							 WHEN c. STATUS = - 2 THEN '已取消'
							 WHEN TIMESTAMPDIFF(HOUR, c.addtime, NOW()) > 24 AND c. STATUS = 0 THEN '已过期'
							 WHEN c.id NOT IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id = c.id) THEN '制作中'
							 WHEN c.id IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id = c.id AND ca.isuse = 1) THEN '已确认'
							 WHEN c.id IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id = c.id ) THEN '待选方案' 
						END 'status_CH',
						CEIL(c.budget/c.people) AS budget,c.status,c.line_id, c.pic  
				FROM 
						u_customize AS c  
						LEFT JOIN u_customize_answer AS u ON  u.customize_id=c.id 
						left join u_startplace as us on us.id=c.startplace 
				WHERE 
						c.member_id = {$m_id} GROUP BY c.id order by c.addtime desc
				";
        $sql_page = $sql . " limit {$from},{$page_size}";

        //分页数据
        $result = $this->db->query($sql_page)->result_array();
        //总条数
        $total_rows = $this->db->query($sql)->num_rows();

        if (empty($result))
            $this->__data($result);
        else {   //数据格式处理
            foreach ($result as $k => $v) {
                $arr = array();
                if (!empty($v['dest'])) {
                    $arr = explode(",", $v['dest']);
                }
                $v['dest_array'] = $arr;
                $result[$k] = $v;
            }
        }

        $total_page = ceil($total_rows / $page_size);
        $return = array(
            'cur_page' => $page,
            'page_size' => $page_size,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
            'result' => $result
        );
        $this->__data($return);
    }

    /**
     * @name：我的定制详情
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_custoimze_detail() {
        $token = $this->input->post('number', true);
        $cid = intval($this->input->post('cid', true)); //定制单id
        //$cid="600";
        $this->check_token($token);
        if (!$cid)
            $this->__errormsg('定制单id不能为空');
        $data = $this->db->query("
				    SELECT  
						c.id,c.startplace,us.cityname, 
						(select GROUP_CONCAT(kindname) from u_dest_cfg where FIND_IN_SET(id,c.endplace) >0 )as dest , c.addtime,
				        (SELECT COUNT(*) FROM u_customize_reply AS r WHERE r.customize_id=c.id and r.answer_id!=0) AS answer_num,
						(SELECT COUNT(*) FROM u_customize_reply AS r WHERE r.customize_id=c.id) AS expert_num,
						
						
						 CASE 
						     WHEN c. STATUS = 3 THEN '已完成'
							 WHEN c. STATUS = - 3 THEN '已过期'
							 WHEN c. STATUS = - 2 THEN '已取消'
							 WHEN TIMESTAMPDIFF(HOUR, c.addtime, NOW()) > 24 AND c. STATUS = 0 THEN '已过期'
							 WHEN c.id NOT IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id = c.id) THEN '制作中'
							 WHEN c.id IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id = c.id AND ca.isuse = 1) THEN '已确认'
							 WHEN c.id IN (SELECT ca.customize_id FROM u_customize_answer AS ca WHERE ca.customize_id = c.id ) THEN '待选方案' 
						END 'status_CH',
						CEIL(c.budget/c.people) AS budget,c.status,c.line_id, c.pic  
				FROM 
						u_customize AS c  
						LEFT JOIN u_customize_answer AS u ON  u.customize_id=c.id 
						left join u_startplace as us on us.id=c.startplace 
				WHERE 
						c.id = {$cid} GROUP BY c.id order by c.addtime desc
				 ")->row_array();
        //数据处理
        if (empty($data))
            $this->__data($data);
        else {   //数据格式处理
            $arr = array();
            if (!empty($data['dest'])) {
                $arr = explode(",", $data['dest']);
            }
            $data['dest_array'] = $arr;
        }
        //回复方案
        $data ['answer'] = $this->db->query("  
				SELECT 
						r.id,r.answer_id,r.customize_id as customize_id,r.expert_id,e.realname,e.nickname,e.small_photo,
						r.reply as plan_design,r.addtime,
						CASE WHEN r.answer_id > 0 THEN '已回复方案' WHEN r.answer_id = 0 THEN '已回复方案' END 'reply_CH',
				        r.is_allow
				FROM 
						u_customize_reply AS r
						LEFT JOIN u_customize AS c ON r.customize_id = c.id 
						LEFT JOIN u_expert AS e ON r.expert_id = e.id 
				WHERE 
						r.customize_id ={$cid} ")->result_array();
        $this->__outmsg($data);
    }

    /**
     * @name：定制属性：出行方式、多项服务
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_attr() {
        //出行方式
        $data['trip'] = $this->db->query("select dict_id,description from u_dictionary where pid=39")->result_array();
        //单项服务
        $data['service'] = $this->db->query("select dict_id,description from u_dictionary where pid=83")->result_array();
        //酒店要求
        $data['hotel'] = $this->db->query("select dict_id,description from u_dictionary where pid=7")->result_array();
        //用餐要求
        $data['food'] = $this->db->query("select dict_id,description from u_dictionary where pid=59")->result_array();
        //用房要求
        $data['room'] = $this->db->query("select dict_id,description from u_dictionary where pid=92")->result_array();
        //购物要求
        $data['shop'] = $this->db->query("select dict_id,description from u_dictionary where pid=55")->result_array();

        $this->__data($data);
    }

    /**
     * @name：定制单-》提交数据
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_submit() {
        $this->load->library('session');
        $code_mobile = $this->session->userdata('mobile');
        $token = $this->input->post('number', true);
        if (!empty($token)) {
            $this->check_token($token);

            $m_id = $this->F_get_mid($token);
        }
        $data ['from'] = $this->input->post('from', true);                 //出发城市
        $data ['estimatedate'] = $this->input->post('estimatedate', true);
        $data ['test1id'] = $this->input->post('test1id', true);                // 境内外
        $data ['test2id'] = $this->input->post('test2id', true);               //省市
        $data ['method'] = $this->input->post('method', true);               //出游方式
        $data ['another_choose'] = $this->input->post('another_choose', true);        //多选出游方式
        $data ['question'] = $this->input->post('question', true);              //定制线路标题
        $data ['people'] = $this->input->post('people', true);               //成人
        $data ['childnum'] = $this->input->post('cp', true);                //小孩
        $data ['childnobednum'] = $this->input->post('cnp', true);             //小孩不占床
        $data ['oldman'] = $this->input->post('olp', true);                 //老人
        $data ['roomnum'] = $this->input->post('roomnum', true);             //房间数
        $data ['startdate'] = $startdate = $this->input->post('dayr', true);          //出游日
        $data ['days'] = $this->input->post('days', true);                 //时长
        $data ['budget'] = $this->input->post('budget', true);               //备注
        $data ['end'] = $this->input->post('end', true);                  //目的地
        $end = $data ['test2id'] . ',' . $data ['end'];
        // $data['isend']=rtrim($isend, ",");
        // $end=$data['isend'];
        $data ['hotel'] = $this->input->post('hotel', true);                  // 酒店
        $data ['room_require'] = $this->input->post('room_require', true);
        $data ['catering'] = $this->input->post('catering', true);               // 用餐
        $data ['isshopping'] = $this->input->post('isshopping', true);             // 购物
        if (empty($data ['hotel'])) {
            $data ['hotel'] = "无";
        }
        if (empty($data ['catering'])) {
            $data ['catering'] = "无";
        }
        if (empty($data ['isshopping'])) {
            $data ['isshopping'] = "无";
        }
        $data ['service_range'] = $this->input->post('beizhu', true);             //多选
        $data ['meal'] = $this->input->post('meal', true);                 //吃
        $data ['beizhu'] = $this->input->post('beizhu', true);
        $data ['linkname'] = $this->input->post('linkname', true);              //游客名
        $data ['mobile'] = $pwd = $this->input->post('mobile', true);            //手机
        $data ['weixin'] = $this->input->post('weixin', true);                //微信
        $data ['yzm'] = $this->input->post('yzm', true);                   // 验证码
        $data ['total_people'] = $this->input->post('total_people', true);           //总人数
        $testtime = date("Y-m-d");
        if (empty($data ['from'])) {
            $this->resultJSON = json_encode(array(
                "msg" => "出发城市不能为空",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        } elseif (empty($data ['method'])) {
            $this->resultJSON = json_encode(array(
                "msg" => "出游方式不能为空",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        } elseif (empty($data ['startdate']) && empty($data ['estimatedate'])) {
            $this->resultJSON = json_encode(array(
                "msg" => "出发日期不能为空",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        } elseif (empty($data ['end'])) {
            $this->resultJSON = json_encode(array(
                "msg" => "目的地城市不能为空",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        } elseif (($data ['total_people']) < 1) {
            $this->resultJSON = json_encode(array(
                "msg" => "人数至少需有一位",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        }
        $this->load->helper('regexp');
        $mobile = $data ['mobile'];
        $name = $data ['linkname'];
        if (!regexp('mobile', $mobile)) {
            $this->resultJSON = json_encode(array(
                "msg" => "请确保手机格式正确以及不能为空",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        }
        if (!regexp('name', $name)) {
            $this->resultJSON = json_encode(array(
                "msg" => "联系人姓名输入有误",
                "code" => "4001"
            ));
            echo $this->resultJSON;
            exit();
        }

        if (!empty($token)) {
            $user_id = $m_id;
        } else {
            $user_id = '';
        }
        $yzm = $this->session->userdata('code');
        if (empty($user_id)) {
            if ($yzm != $data ['yzm']) {
                $this->resultJSON = json_encode(array(
                    "msg" => "验证码错误",
                    "code" => "4001"
                ));
                echo $this->resultJSON;
                exit();
            }
        }

        $time = time();
        // var_dump($user_id);
        $this->db->trans_start();
        if (empty($user_id)) {
            // var_dump('3');
            // 没有登陆，验证此手机号是否注册，若注册则自动登陆，若没有则自动注册一个账号
            $this->load->model('app/u_member_model', 'member_model');
            $member_info = $this->member_model->row(array(
                'mobile' => $data ['mobile']
            ));
            if (!empty($member_info)) {
                $user_id = $member_info ['mid'];
                // 已注册 自动登陆
            } else {
                $this->load->model('app/cfg_member_point_model', 'cfg_member_point');
                $point = $this->cfg_member_point->row(array(
                    'code' => 'REGISTER',
                    'isopen' => '1'
                ));
                $point_num = isset($point ['value']) ? $point ['value'] : '0'; // 积分数
                $member_insert_id = array(
                    'truename' => $data ['linkname'],
                    'loginname' => $mobile,
                    'nickname' => $mobile,
                    'mobile' => $mobile,
                    'pwd' => md5($mobile),
                    'jointime' => date('Y-m-d H:i:s', $time),
                    'sex' => - 1,
                    'litpic' => '/file/c/img/face.png',
                    'jifen' => $point_num,
                    'logintime' => date('Y-m-d H:i:s', $time),
                    'loginip' => $this->get_client_ip()
                );
                $this->member_model->insert($member_insert_id);
                $user_id = $this->db->insert_id();
                // 写入积分变化表
                if ($member_insert_id ['jifen'] > 0) {
                    $memberLogArr = array(
                        'member_id' => $user_id,
                        'point_before' => 0,
                        'point_after' => $member_insert_id ['jifen'],
                        'point' => $member_insert_id ['jifen'],
                        'content' => '注册赠送积分',
                        'addtime' => $member_insert_id ['logintime']
                    );
                    $this->db->insert('u_member_point_log', $memberLogArr);
                }
                $this->member_coupon(1, $user_id);
                // 发送短信给用户提示
                $smsData = "尊敬的帮游会员，系统已为您自动注册账号，可在会员中心查看定制单信息，账号为{$mobile}，密码为{$pwd}。为安全起见，请尽快修改密码，谢谢。";
                $this->Inside_page_message($mobile, $smsData);
            }
        }
        $data ['month'] = "";
        $data ['date'] = "";
        if (!empty($data ['startdate'])) {
            $arr = explode("-", $data ['startdate']);
            $data ['month'] = $arr [1];
            $data ['date'] = $arr [2];
        }
        $data = array(
            'member_id' => $user_id,
            'startplace' => $data ['from'],
            'endplace' => $end,
            'question' => $data ['question'],
            'month' => $data ['month'],
            'date' => $data ['date'],
            'trip_way' => $data ['method'],
            'another_choose' => $data ['another_choose'],
            'people' => $data ['people'],
            'childnum' => $data ['childnum'],
            'childnobednum' => $data ['childnobednum'],
            'oldman' => $data ['oldman'],
            'roomnum' => $data ['roomnum'],
            'days' => $data ['days'],
            'startdate' => $data ['startdate'],
            'estimatedate' => $data ['estimatedate'],
            'budget' => $data ['budget'],
            'hotelstar' => $data ['hotel'],
            'room_require' => $data ['room_require'],
            'isshopping' => $data ['isshopping'],
            'service_range' => $data ['beizhu'],
            'catering' => $data ['meal'],
            'linkname' => $data ['linkname'],
            'linkphone' => $data ['mobile'],
            'linkweixin' => $data ['weixin'],
            'custom_type' => $data ['test1id'],
            // 'service_range' => $data ['beizhu'],
            'total_people' => $data ['total_people'],
            'addtime' => date('Y-m-d H:i', time()),
            'status' => '0',
            'user_type' => '0',
            'pic' => '/file/b2/upload/img/customize.png'
        );
        $this->load->model('app/u_customize_model', 'u_customize');
        $customize_id = $this->u_customize->insert($data);
        $cid = $this->db->insert_id();
        $this->load->model('app/u_customize_dest_model', 'u_customize_dest');
        $endplace = explode(',', $end);
        for ($i = 0; $i < count($endplace); $i ++) {
            $this->u_customize_dest->insert(array(
                'customize_id' => $customize_id,
                'dest_id' => $endplace [$i]
            ));
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            if (!empty($customize_id)) {
                if (!isset($m_id)) {
                    $reDataArrssdsd = $this->db->query("SELECT loginname,pwd FROM `u_member` where mid={$user_id} ORDER BY mid limit 1; ")->row_array();
                } else {
                    $reDataArrssdsd = '';
                }
                echo json_encode(array(
                    'code' => 2000,
                    'msg' => 'ok!',
                    'cid' => $reDataArrssdsd,
                    'cust_id' => $cid
                ));
            } else {
                echo json_encode(array(
                    'code' => 4000,
                    'msg' => 'null!'
                ));
            }
        }
    }

    /**
     * @name：定制(第一步)验证
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_page1() {
        $startcity = $this->input->post('startcity', true); // 出发城市
        $city_name1 = $this->input->post('city1', true); // 国内外
        $city_name2 = $this->input->post('city2', true); // 省
        $city_name3 = $this->input->post('city3', true); // 市
        $travel_type = $this->input->post('travel_type', true); // 市
        $more_service = $this->input->post('more_service', true); // 市
        if (empty($startcity)) {
            $this->__errormsg('请填写出发城市名！');
        }
        if (empty($city_name1)) {
            $this->__errormsg('请填写出发城市名！');
        }
        if (empty($city_name2)) {
            $this->__errormsg('请填写目的地城市名！');
        }
        if (empty($travel_type)) {
            $this->__errormsg('请填写出游方式！');
        }
        echo json_encode(array('code' => 2000, 'msg' => 'ok!'));
    }

    /**
     * @name：定制(第二步)验证
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_page2() {
        $travel_time1 = $this->input->post('travel_time1', true); // 出游日期
        $travel_time2 = $this->input->post('travel_time', true); // 出游日期文字描述
        $budget = $this->input->post('budget', true); // 人均预算
        $days = $this->input->post('days', true); // 出游时长
        $hotel = $this->input->post('hotel', true); // 酒店要求
        if ((!empty($travel_time1)) xor ( !empty($travel_time2))) {
            if (!empty($travel_time1)) {
                $time1 = strtotime($travel_time1);
                if ($time1 < time()) { {
                        $this->__errormsg('出游时间得大于今天！');
                    }
                }
            }
            if (empty($budget)) {
                $this->__errormsg('请填写人均预算 ！');
            }
            if (empty($days)) {
                $this->__errormsg('请填写出游时长！');
            }
            // if (empty($hotel)) {$this->__errormsg ('请填写酒店要求！'); }
            echo json_encode(array(
                'code' => 2000,
                'msg' => 'ok!'
            ));
        } else {
            $this->__errormsg('出游日期不能写两个！');
        }
    }

    /**
     * @name：定制(第一步)城市列表
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_city_list() {
        $cityId = intval($this->input->post('cityid'));
        if (is_numeric($cityId) && !empty($cityId)) {

            $this->load->model('app/cfg_round_trip_model', 'trip_model');
            // 获取周边目的地
            $tripData = $this->trip_model->all(array(
                'startplaceid' => $cityId,
                'isopen' => 1
            ));
            if (!empty($tripData)) {
                $destId = '';
                foreach ($tripData as $v) {
                    $destId .= $v ['neighbor_id'] . ',';
                }
                $destId = rtrim($destId, ',');
                // 获取目的地
                $sql = "select kindname,id from u_dest_cfg where id in ($destId)";
                $destArr = $this->db->query($sql)->result_array();
            } else {
                $this->__outmsg($tripData);
            }
        } else {
            $this->load->model('app/u_dest_cfg_model', 'dest_model');
            $destData = $this->dest_model->all(array(
                'level <=' => 3
            ));
            $destArr = array();
            $h = 'h';
            foreach ($destData as $val) {
                if ($val ['pid'] == $cityId) {
                    $destArr ['top'] [] = $val;
                } else {
                    $destArr [$h . $val ['pid']] [] = $val;
                }
            }
            unset($destData);
        }
        if ($destArr) {
            $this->__outmsg($destArr);
        }
    }

    /**
     * @name：定制单-》提交数据    新版
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_submit2() {
        $this->load->library('session');
        $sess_mobile = $this->session->userdata('mobile'); //session:手机号
        $sess_code = $this->session->userdata('code');  //session:验证码
        $token = $this->input->post('number', true);
        //$this->check_token ( $token );
        $m_id = $this->F_get_mid($token);
        //$m_id="311";
        //传值
        $startplace_id = $this->input->post('startplace_id', true);  //出发城市id															
        $dest_id = $this->input->post('dest_id', true);  //目的地城市，多个城市以","相连
        $trip_way = $this->input->post('trip_way', true); //出游方式				  										
        $another_choose = $this->input->post('another_choose', true);  //单项服务									
        $linkname = $this->input->post('linkname', true); //联系人	
        $weixin_or_qq = $this->input->post('weixin_or_qq', true); //微信或qq	

        $mobile = $this->input->post('mobile', true); //手机号
        $code = $this->input->post('code', true); //验证码

        /* $startplace_id="233";
          $dest_id="10454,10415";
          $trip_way="参团游";
          $linkname="wwb";
          $mobile="13751174462";
          $code="2312"; */
        //验证
        if (empty($startplace_id))
            $this->__errormsg('请选择出发城市');
        if (empty($dest_id))
            $this->__errormsg('请选择目的地城市');
        if (empty($trip_way))
            $this->__errormsg('请选择出游方式');
        if (empty($linkname))
            $this->__errormsg('请填写联系人');

        if (empty($mobile))
            $this->__errormsg('请填写手机号码');
        $this->load->helper('regexp');
        if (!regexp('mobile', $mobile))
            $this->__errormsg('请填写正确的手机号码');

        $islogin = false; //默认没有登录状态
        if ($m_id == "0") {  //没登录情况下做验证
            if ($mobile != $sess_mobile)
                $this->__errormsg('所填手机号和接收验证码的手机号不一致');
            if (empty($code))
                $this->__errormsg('请填写短信验证码');
            if ($code != $sess_code)
                $this->__errormsg('验证码错误');

            //是否是新用户
            $user = array();
            $is_new = $this->db->query("select * from u_member where mobile='{$mobile}' or loginname='{$mobile}'")->row_array();
            if (empty($is_new)) {
                //注册(密码是手机号)
                $re = $this->user_register($mobile, $mobile, '2');
                $m_id = $re['mid'];
                $user = $this->db->query("select * from u_member where mid='{$re['mid']}'")->row_array();
            } else {
                $m_id = $is_new['mid'];
                $user = $is_new;
            }
        } else {
            $islogin = true;
        }

        //生成定制单
        $this->db->trans_begin();
        $data = array(
            'member_id' => $m_id,
            'another_choose' => $another_choose,
            'startplace' => $startplace_id,
            'endplace' => $dest_id,
            'linkphone' => $mobile,
            'linkname' => $linkname,
            'trip_way' => $trip_way,
            'addtime' => date('Y-m-d H:i:s'),
            'status' => '0', //保存状态
            'user_type' => '0', //用户
            'pic' => '/file/b2/upload/img/customize.png'
        );
        if (!empty($another_choose))
            $data['another_choose'] = $another_choose;
        if (!empty($weixin_or_qq))
            $data['linkweixin'] = $weixin_or_qq;


        $this->load->model('app/u_customize_model', 'u_customize');
        $customize_id = $this->u_customize->insert($data);

        //定制单目的地
        $this->load->model('app/u_customize_dest_model', 'u_customize_dest');
        $dest_arr = explode(',', $dest_id);
        for ($i = 0; $i < count($dest_arr); $i ++) {
            $this->u_customize_dest->insert(array('customize_id' => $customize_id, 'dest_id' => $dest_arr [$i]));
        }

        //事务
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->__errormsg('操作失败');
        } else {
            $this->db->trans_commit();
            if ($islogin) {  //登录情况下
                echo json_encode(array('code' => '2000', 'msg' => '定制已提交', 'cid' => $customize_id), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            } else {  //没有登录情况下，返回用户信息，供前台自动登录
                $this->load->library('token');
                $token_json = $this->token->getToken($user['mid']);
                $token = json_decode($token_json, true);
                $litpic = $this->__doImage($user['litpic']);
                echo json_encode(array('code' => '2001',
                    'msg' => '定制已提交',
                    'cid' => $customize_id,
                    'key' => $token ['key'],
                    'id' => $user['mid'],
                    'nickname' => $user['nickname'],
                    'litpic' => $litpic
                        ), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            }
        }
    }

    /**
     * @name：我的定制方案详情
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_custoimze_answer_detail() {
        $answer_id = $this->input->post('answer_id', true);  // 回复id
        //$answer_id="888";
        is_numeric($answer_id) ? ($answer_id) : $this->__errormsg('方案id不能为空！');
        //回复详情 （一条）
        $sql = "select 
						ans.id,ans.title,ans.plan_design,ans.attachment,ans.childprice as childprice,ans.childnobedprice,
						ans.price,ans.price_description,ans.oldprice,ans.customize_id, ans.expert_id, ans.isuse,ISNULL(ans.replytime) AS reply
						
				from 
						u_customize_answer AS ans 
						
				where 
						ans.id ={$answer_id}";
        $answer = $this->db->query($sql)->row_array();
        //行程（多条）
        $sql_jieshao = "select
						cj.day,cj.title as cjtitle,cj.jieshao,cj.breakfirsthas, cj.breakfirst,cj.transport,
						cj.hotel,cj.lunchhas,cj.lunch, cj.supperhas, cj.supper, cjp.pic
				from
						u_customize_jieshao as cj 
						left join u_customize_jieshao_pic as cjp on cj.id = customize_jieshao_id
				where
						cj.customize_answer_id ={$answer_id}";
        $answer ['plan_list'] = $this->db->query($sql_jieshao)->result_array();
        //管家
        $expert_id = $answer['expert_id'];
        $answer ['expert'] = array();
        if (!empty($expert_id)) {
            $answer ['expert'] = $this->db->query("select   realname,mobile,weixin,nickname,id from u_expert  where id={$expert_id} ")->row_array();
        }

        foreach ($answer ['plan_list'] as $key => $val) { //用于转换数组，只因数组内嵌过多，导致图片过滤无法带上域名，而后转换域名。
            $arr = explode(";", $val['pic']);
            $val['pic'] = $this->__doImage($arr);
            $answer ['plan_list'][$key] = $val;


            //对早餐、中餐、晚餐数据处理
            if ($val['breakfirsthas'] == "1") {
                if ($val['breakfirst'] == "")
                    $val['breakfirst_show'] = "包含";
                else
                    $val['breakfirst_show'] = $val['breakfirst'];
            }else {
                $val['breakfirst_show'] = "无";
            }
            if ($val['lunchhas'] == "1") {
                if ($val['lunch'] == "")
                    $val['lunch_show'] = "包含";
                else
                    $val['lunch_show'] = $val['lunch'];
            }else {
                $val['lunch_show'] = "无";
            }
            if ($val['supperhas'] == "1") {
                if ($val['supper'] == "")
                    $val['supper_show'] = "包含";
                else
                    $val['supper_show'] = $val['supper'];
            }else {
                $val['supper_show'] = "无";
            }

            $answer ['plan_list'] [$key] = $val;
        }

        $this->__outmsg($answer);
    }

    /**
     * @name：选择方案
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_custoimze_answer_choose() {
        $answer_id = $this->input->post('answer_id', true); //回复（方案）ID
        //$answer_id="822";
        $token = $this->input->post('number', true);
        $this->check_token($token);
        $m_id = $this->F_get_mid($token);
        //$m_id="300";
        is_numeric($answer_id) ? ($answer_id) : $this->__errormsg('方案id不能为空');

        $this->load->model('app/u_customize_model', 'u_customize_model');
        $this->load->model('app/u_customize_answer_model', 'u_customize_answer_model');
        $answer = $this->db->query("select * from u_customize_answer where id='{$answer_id}'")->row_array();
        $expert_id = $answer['expert_id']; //管家id
        $customize_id = $answer['customize_id']; // 定制单ID

        $reDataArr = $this->db->query("    select status,member_id from u_customize where id ={$customize_id}")->row_array();
        if ($m_id != $reDataArr['member_id'])
            $this->__errormsg('该方案不归属你，无法选择');
        $sta = $reDataArr ['status'];
        if ($sta == '-3')
            $this->__errormsg('操作方案失败，该定制单已过期');
        if ($sta == '3')
            $this->__errormsg('操作方案失败，该定制单已完成');
        if ($sta == '-2')
            $this->__errormsg('操作方案失败，该定制单已取消');
        if ($sta == '1')
            $this->__errormsg('操作方案失败，该定制单已确定方案，不能重复选择');
        if ($sta == '0') {
            $data = array(
                'status' => 1, //已确定方案
                'is_assign' => 1, //已采用
                'expert_id' => $expert_id  //管家id
            );
            $this->db->trans_begin();
            $this->u_customize_model->update($data, array('id' => $customize_id));
            $this->u_customize_answer_model->update(array('isuse' => '1'), array('id' => $answer_id));  //方案被使用
            //事务
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->__errormsg('操作失败');
            } else {
                $this->db->trans_commit();
                $this->__data('方案选择成功');
            }
        } else
            $this->__errormsg('操作方案失败');
    }

    /**
     * @name：方案详情：允许联系
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_custoimze_answer_contact() {
        $reply_id = $this->input->post('reply_id', true); //回复（方案）ID
        $type = $this->input->post('type', true);  //0 不允许联系，1允许联系
        //$answer_id="822";
        //$type="1";
        $token = $this->input->post('number', true);
        $this->check_token($token);
        $m_id = $this->F_get_mid($token);
        //$m_id="300";
        is_numeric($reply_id) ? ($reply_id) : $this->__errormsg('回复id不能为空');
        if ($type != "0" && $type != "1")
            $this->__errormsg('type参数错误');


        $reply = $this->db->query("select * from u_customize_reply where id='{$reply_id}'")->row_array();
        $customize_id = $reply['customize_id']; // 定制单ID

        $reDataArr = $this->db->query("    select status,member_id from u_customize where id ={$customize_id}")->row_array();
        if ($m_id != $reDataArr['member_id'])
            $this->__errormsg('该方案不归属你，无法操作');
        $sta = $reDataArr ['status'];
        if ($sta == '-3')
            $this->__errormsg('操作方案失败，该定制单已过期');
        if ($sta == '3')
            $this->__errormsg('操作方案失败，该定制单已完成');
        if ($sta == '-2')
            $this->__errormsg('操作方案失败，该定制单已取消');
        if ($sta == '1')
            $this->__errormsg('操作方案失败，该定制单已确定方案，不能重复选择');
        if ($sta == '0') {
            $this->db->trans_begin();
            $this->db->where(array('id' => $reply_id))->update("u_customize_reply", array('is_allow' => $type));  //方案被使用
            //事务
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->__errormsg('操作失败');
            } else {
                $this->db->trans_commit();
                if ($type == "0")
                    $this->__data('已设置为不允许联系');
                else
                    $this->__data('已设置为可以联系');
            }
        } else
            $this->__errormsg('操作方案失败');
    }

    /**
     * @name：用户端（订单列表）
     * @author: 温文斌
     * @param:number=凭证；code=状态
     * @return:
     *
     */
    public function cfgm_user_order() {
        $where = "";
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $m_id = $this->F_get_mid($token);
        $code = $this->input->post('code', true);
        if ($code == 1) { // 待支付
            $where = "AND ( mb_od.status=1 ) AND ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())<24";
        } elseif ($code == 2) { // 待出行
            $where = "AND ( mb_od.status=1 OR mb_od.status=4 ) AND ispay>0";
        } elseif ($code == 3) { // 待评价
            $where = "AND mb_od.status=5 AND ispay>0";
        }
        $sql = "SELECT 
		               mb_od.id AS mo_id,mb_od.ordersn,l.linetitle as linetitle,mb_od.ispay AS mo_ispay,
		               mb_od.status AS mo_status,mb_od.productname AS linename,mb_od.litpic,
		               mb_od.dingnum,mb_od.childnum,mb_od.oldnum,mb_od.childnobednum,ls.unit,
		              (mb_od.dingnum+mb_od.childnum+mb_od.oldnum+mb_od.childnobednum) AS people,
		              mb_od.usedate AS day,mb_od.total_price,ls.lineid,mb_od.settlement_price,(mb_od.total_price+mb_od.settlement_price) as all_price,
		              CASE WHEN mb_od.ispay = 0 THEN '未支付' WHEN mb_od.ispay = 1 THEN '已首付' WHEN mb_od.ispay = 2 THEN '已支付' END pay_status,
		              CASE WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=0) AND mb_od.status=-3 THEN '退款审核中' WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=1) AND mb_od.status=-4 THEN '退款成功' WHEN mb_od.id IN (SELECT r.order_id FROM u_refund AS r WHERE r.status=2) AND mb_od.status=-4 THEN '退款失败' WHEN mb_od.ispay=0 AND TIMESTAMPDIFF(HOUR,mb_od.addtime,NOW())>24 THEN '已经失效' WHEN mb_od.status = -4 THEN '已经取消' WHEN mb_od.status = -3 THEN  '取消中' WHEN mb_od.status = -2 THEN '平台拒绝' WHEN mb_od.status = -1 THEN 'B1拒绝' WHEN mb_od.status = 0 THEN '待留位' WHEN mb_od.status = 1 THEN 'B1已确认留位' WHEN mb_od.status = 2 THEN '用户已付款' WHEN mb_od.status = 3 THEN '平台已确认收款' WHEN mb_od.status = 4 THEN 'B1已控位' WHEN mb_od.status = 5 THEN '出行' WHEN mb_od.status = 6 THEN '点评' WHEN mb_od.status = 7 THEN '已投诉' WHEN mb_od.status = 8 THEN '专家已点评' END order_status 
		        FROM 
		              u_member_order AS mb_od LEFT JOIN 
		              u_member AS mb ON mb_od.memberid = mb.mid 
		              left join u_line as l on mb_od.productautoid = l.id 
		              left join u_line_suit as ls on ls.id=mb_od.suitid
		        WHERE 
		              mb.mid={$m_id} {$where} 
		           
		      ORDER BY 
		              mb_od.addtime DESC,mb_od.status";
        // 退款
        if ($code == 4) {
            $sql = "SELECT 
							mo.id AS mo_id,mo.ordersn,mo.ispay AS mo_ispay,mo.status AS mo_status,r.id AS r_id,
							mo.productname AS linename,mo.litpic,l.linetitle AS linetitle,mo.dingnum,mo.childnum,mo.oldnum,mo.childnobednum,
		                    (mo.dingnum+mo.childnum+mo.oldnum+mo.childnobednum) AS people,ls.unit,
		                    mo.usedate AS day,mo.total_price,mo.settlement_price,(mo.total_price+mo.settlement_price)as all_price,
		                    CASE WHEN mo.ispay=3 AND mo.status=-3 THEN '退款中' WHEN mo.ispay=4 AND mo.status=-4 THEN '退款成功' WHEN r.status=2 THEN '退款失败' END order_status
		            FROM 
		                    u_refund AS r 
		                    LEFT JOIN u_member_order AS mo ON r.order_id=mo.id 
		                    LEFT JOIN u_line AS l ON mo.productautoid = l.id
		                    left join u_line_suit as ls on ls.id=mo.suitid
		            WHERE   
			                mo.memberid={$m_id} 
			        ORDER BY 
			                r.addtime DESC";
        }
        $query = $this->db->query($sql);
        $reDataArr = $query->result_array();
        if ($reDataArr) {
            foreach ($reDataArr as $key => $val) {
                foreach ($val as $k => $v) {
                    if ($k == "usedate") {
                        $val [$k] = date('Y-m-d', strtotime($val [$k]));
                    }
                }
                $reDataArr [$key] = $val;
            }
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：用户端（订单详情）
     * @author: 温文斌
     * @param:number=凭证；bj_id=订单ID
     * @return:
     *
     */
    public function cfgm_user_order_detail() {
        $token = $this->input->post('number', true);
        $this->check_token($token);
        $bj = $this->input->post('bj_id', true);
        //$bj="100731";
        is_numeric($bj) ? ($bj) : $this->__errormsg('标识不能为空！');
        // 我的订单
        $order_detail = $this->order_detail($bj);
        $arr ['order'] = $order_detail[0]; //第一条记录
        if (empty($arr ['order'])) {
            $this->__outmsg($arr ['order']);
        }
        $arr ['order'] ['team_free'] = $arr ['order'] ['order_price'] - $arr ['order'] ['insurance_price']; // 出团费用
        $arr ['order'] ['discount'] = $arr ['order'] ['jifenprice'] + $arr ['order'] ['couponprice']; // 已优惠
        // 国内外
        $arr ['inou'] = substr($arr ['order'] ['overcity'], - 1);
        if (empty($arr ['inou'])) {
            $arr ['overcity'] = '1';
        }
        // 游客信息列表
        $arr ['yk'] = $this->db->query(" select group_concat(mt.id) AS id,group_concat(mt.name) AS name,group_concat(mt.enname) AS enname,group_concat(mt.certificate_type) AS certificate_type,group_concat(mt.sex) AS sex,group_concat(mt.certificate_no) AS certificate_no,group_concat(mt.sign_place) AS sign_place,group_concat(mt.sign_time) AS sign_time,date(mt.endtime) AS endtime,group_concat(mt.isman) AS isman,group_concat(mt.telephone) AS phone,group_concat(mt.birthday) AS birth,ud.description as certificate_des from u_member_traver AS mt left join u_dictionary as ud on ud.dict_id=mt.certificate_type where mt.id in (select mom.traver_id from u_member_order_man AS mom where mom.order_id={$bj}) group by mt.id")->result_array();
        // 发票
        $arr ['fa'] = $this->db->query("select moi.id as id,mi.invoice_type,mi.invoice_name,mi.invoice_detail,mi.receiver,mi.telephone,mi.address,mi.addtime,mi.member_id,umo.total_price from u_member_order_invoice as moi left join u_member_invoice as mi on moi.invoice_id=mi.id 	left join u_member_order as umo on moi.order_id=umo.id 	where moi.order_id={$bj} ")->result_array();
        $arr ['log'] = $this->db->query("				SELECT *  	FROM (`u_member_order_log`)   	WHERE `order_id` = {$bj}	ORDER BY `addtime` desc")->result_array();
        $arr ['expert'] = $this->db->query("		SELECT id, mobile, big_photo, small_photo, nickname  	FROM (`u_expert`)  	WHERE `id` =  {$arr['order']['expert_id']}   	ORDER BY `id` ")->row_array();

        $this->__outmsg($arr, 1);
    }

    /**
     * @name： 评论、投诉、付款、退款页面  -----》显示页面
     * @author: 温文斌
     * @param:orderid=订单ID;action=操作类型（comment评论、complaint投诉、pay付款、back退款）
     *
     * @return:
     *
     */
    public function cfgm_order_action() {
        $order_id = $this->input->post('orderid'); //订单号
        $action = $this->input->post('action'); //操作类型
        //$order_id="101442";
        //$action="pay";
        $token = $this->input->post('number', true);
        $this->check_token($token);

        //用户id

        $mid = $this->F_get_mid($token);

        //逻辑开始
        $reDataArr = array();
        if ($action == "comment") { //评论
            $reDataArr = $this->order_detail($order_id);
        } else if ($action == "complain") {//投诉
            $sql = "
					SELECT
							mo.id,c.id as c_id,c.reason
					FROM
							u_member_order AS mo
							LEFT JOIN u_complain AS c ON mo.id=c.order_id
					WHERE 
							mo.id={$order_id}
			       ";
            $query = $this->db->query($sql);
            $row = $query->row_array();

            $reDataArr = $this->order_detail($order_id);
            $reDataArr[0]['reason'] = $row['reason'];
            $reDataArr[0]['c_id'] = $row['c_id'];
        } else if ($action == "back") { //退款
            $sql = "
					SELECT
							mo.id,r.id as r_id,r.reason,r.amount
					FROM
							u_member_order AS mo
							LEFT JOIN u_refund AS r ON mo.id=r.order_id
					WHERE
							mo.id={$order_id}
			";
            $query = $this->db->query($sql);
            $row = $query->row_array();

            $reDataArr = $this->order_detail($order_id);
            $reDataArr[0]['reason'] = $row['reason'];
            $reDataArr[0]['r_id'] = $row['r_id'];
            $reDataArr[0]['amount'] = $row['amount'];
        } else if ($action == "pay") { //付款
            $reDataArr = $this->order_detail($order_id);
            if ($reDataArr[0]['memberid'] != $mid) {
                $this->__errormsg('403非法操作');
            }
        }

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：取消订单、申请退单、评价订单、投诉  ---》提交数据
     * @author: 温文斌
     * @param:number=凭证；bjid=编辑；scid=插入；orderid=订单ID；ykname=名字；ae_name=英文名字；isman=性别
     * @return:
     *
     */
    public function cfgm_order_action_do() {
        $this->load->model('admin/b1/order_status_model', 'order_status_model');      //后台订单状态，统计用。
        $status = 0;
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $m_id = $this->F_get_mid($token);
        $qx = $this->input->post('qx_id', true); // 取消订单
        $td = $this->input->post('td_id', true); // 申请退单

        $ts = $this->input->post('ts_id', true); // 投诉
        if ($td) {
            $data ['order_id'] = $td;
            $log ['content'] = "退款成功";
            $reason = $this->input->post('reason', true); // 退款理由
            $total_price = $this->input->post('total_price', true); // 退款金额
            $mobile = $this->input->post('mobile', true);
            if (empty($reason)) {
                $this->__errormsg('退款理由不能为空！ ');
            }
            if (empty($total_price)) {
                $this->__errormsg('退款金额不能为空！ ');
            }
            if (empty($mobile)) {
                $this->__errormsg('手机不能为空! ');
            }
            if (!preg_match("/1[34578]{1}\d{9}$/", $mobile)) {
                $this->__errormsg('手机号码错误！');
            }
            // $card = $this->input->post ( 'card', true );
            // $bank = $this->input->post ( 'bank', true );
        }
        if ($qx || $td) { // 取消订单或退单
            if ($qx) {
                $data ['order_id'] = $qx;
                $log ['content'] = "取消订单成功";
                $sta = - 4;
                $ispay = 4;
                $where = array(
                    'id' => $qx
                );
                $this->order_status_model->update_order_status_cal($qx);
            }
            if ($td) {
                $data ['order_id'] = $td;
                $log ['content'] = "退订中";
                $sta = - 3;
                $ispay = 3;
                $where = array(
                    'id' => $td
                );
                $this->order_status_model->update_order_status_cal($td);
            }
            $status = $this->db->update('u_member_order', array(
                'status' => $sta
                    ), $where);
            if ($status && $td) {
                $refund = array(
                    'order_id' => $td,
                    'refund_type' => 0,
                    'refund_id' => $m_id,
                    'reason' => $reason,
                    'amount_apply' => $total_price,
                    'mobile' => $mobile,
                    // 'bankcard' => $card,
                    // 'bankname' => $bank,
                    'status' => 0,
                    'is_remit' => 0,
                    'addtime' => date('Y-m-d H:i:s', time())
                );
                // print_r($refund);exit();
                $status = $this->db->insert('u_refund', $refund);
                $status = $this->db->update('u_member_order', array(
                    'status' => '-3'
                        ), array(
                    'id' => $td
                ));
                $this->order_status_model->update_order_status_cal($td);
            }
        }

        if ($ts) { // 投诉
            $log ['content'] = "投诉成功";
            $data ['order_id'] = $ts;
            $data ['member_id'] = $m_id;
            $data ['complain_type'] = $this->input->post('complain_type', true); // 1.专家 2.供应商
            if (empty($data ['complain_type']))
                $this->__errormsg('请勾选投诉对象！');
            $data ['reason'] = $this->input->post('complaint_content', true); // 投诉内容
            $data ['mobile'] = $this->input->post('mobile', true); // 用户手机号
            $data ['user_name'] = $this->input->post('user_name', true); // 用户姓名
            $data ['addtime'] = date('Y-m-d H:i:s', time());
            $data ['status'] = 0;
            if (empty($data ['reason']) || empty($data ['mobile']) || (!preg_match("/1[34578]{1}\d{9}$/", $data ['mobile']))) {
                $this->__errormsg('请完整的输入投诉信息');
            }
            $status = $this->db->insert('u_complain', $data);
            $status = $this->db->update('u_member_order', array(
                'status' => 7
                    ), array(
                'id' => $ts
            ));
            $this->order_status_model->update_order_status_cal($ts);
        }

        // 写入订单日志
        $logArr = array(
            'order_id' => $data ['order_id'],
            'op_type' => 0,
            'userid' => $m_id,
            'content' => $log ['content'],
            'addtime' => date('Y-m-d H:i:s', time())
        );
        $status_log = $this->db->insert('u_member_order_log', $logArr);

        if ($status) {
            $this->__successmsg();
        }
    }

    /**
     * @name：游客信息操作
     * @author: 温文斌
     * @param:number=凭证；bjid=编辑；scid=插入；orderid=订单ID；ykname=名字；ae_name=英文名字；isman=性别
     * idcard=身份证号码；certificate_type=身份证类型；birth= 出生；startcity=签发地 startcity；starttime=签发时间
     * endtime= 起止时间；mobile=手机号
     * @return:
     *
     */
    public function cfgm_action_tourist() {
        $status = 0;
        $token = $this->input->post('number', true);
        $this->check_token($token);
        $bj_id = $this->input->post('bjid', true); // 编辑
        $sc_id = $this->input->post('scid', true); // 插入
        $order_id = $this->input->post('orderid', true); // 隐藏框
        $data ['name'] = $this->input->post('ykname', true); // 名字
        $data ['enname'] = $this->input->post('ae_name', true); // 英文名字
        $isman = $this->input->post('isman', true); // 性别
        if ($isman == 1) {
            $data ['isman'] = 1;
        } elseif ($isman == 2) {
            $data ['isman'] = 0;
        }
        $data ['certificate_type'] = $this->input->post('certificate_type', true); // 身份证类型
        $data ['certificate_no'] = $this->input->post('idcard', true); // 身份证号码
        $data ['birthday'] = $this->input->post('birth', true); // 出生
        $data ['sign_place'] = $this->input->post('startcity', true); // 签发地 startcity
        $data ['sign_time'] = $this->input->post('starttime', true); // 签发时间
        $data ['endtime'] = $this->input->post('endtime', true); // 起止时间
        $data ['telephone'] = $this->input->post('mobile', true); // 手机
        if ($bj_id) { // 编辑
            $where = array(
                'id' => $bj_id
            );
            $data ['modtime'] = date('Y-m-d H:i:s', time());
            $status = $this->db->update('u_member_traver', $data, $where);
        } elseif (empty($sc_id)) { // 插入
            $data ['addtime'] = date('Y-m-d H:i:s', time());
            $status = $this->db->insert('u_member_traver', $data);
            $tourist_id = $this->db->insert_id(); // 返回插入的ID
            $status = $this->db->insert('u_member_order_man', array(
                'order_id' => $order_id,
                'traver_id' => $tourist_id
            ));
        } else { // 删除
            $status = $this->db->delete('u_member_order_man', array(
                'order_id' => $order_id,
                'traver_id' => $sc_id
            ));
            $status = $this->db->delete('u_member_traver', array(
                'id' => $sc_id
            ));
        }
        if ($status) {
            $this->__successmsg();
        }
    }

    /**
     * @name：第三方支付成功后的发票上传
     * @author: 温文斌
     * @param:number=凭证；orderid=订单ID；all_price=付款金额；fapiao=订单号；bank=银行；
     * cdname=发票抬头；ticketype=发票类型；mobile= 手机号；cityval=省市区；citypid=详细地址
     * @return:
     *
     */
    public function cfgm_pay_success() {
        $this->load->model('admin/b1/order_status_model', 'order_status_model');
        $order_id = $this->input->post('orderid', true);

        $amount = $this->input->post('all_price', true); // 付款金额
        $bank = $this->input->post('bank', true);
        // $card = $this->input->post('card',true);
        // $hz_number = $this->input->post('hz_number',true);
        $fapiao = $this->input->post('fapiao', true); // 订单号
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $userid = $this->F_get_mid($token);
        is_numeric($order_id) ? ($order_id) : $this->__errormsg('tip is null ');
        if (($fapiao == '1')) {
            $invoice_name = ($this->input->post('cdname', true)); // 发票抬头
            $invoice_detail = ($this->input->post('ticketype', true)); // 发票类型
            $receiver = ($this->input->post('toname', true)); // 收件人
            $telephone = ($this->input->post('mobile', true)); // 手机号
            $city = ($this->input->post('cityval')); // 省市区
            $address = ($this->input->post('citypid', true)); // 详细地址
            if (empty($invoice_name)) {
                $this->__errormsg('请填写发票抬头');
            }
            if (empty($invoice_detail)) {
                $this->__errormsg('请填写发票类型');
            }
            if (empty($receiver)) {
                $this->__errormsg('请填写收件人');
            }
            if (empty($telephone)) {
                $this->__errormsg('请填写手机号');
            }
            if (empty($city)) {
                $this->__errormsg('请填写省市区');
            }
            if (empty($address)) {
                $this->__errormsg('请填写填写详细地址');
            }
            $time = date('Y-m-d H:i:s', time());
            $invoiceArr = array(
                'invoice_name' => $invoice_name,
                'invoice_detail' => $invoice_detail,
                'receiver' => $receiver,
                'telephone' => $telephone,
                'address' => $city . $address,
                'member_id' => $userid,
                'modtime' => $time
            );
            $this->load->model('app/u_member_order_invoice_model', 'order_invoice_model');
            $this->load->model('app/u_member_invoice_model', 'invoice_model');
            $invoiceData = $this->order_invoice_model->row(array(
                'order_id' => $order_id
            ));
            if (empty($invoiceData)) {
                $invoiceArr ['addtime'] = $time;
                $invoiceId = $this->invoice_model->insert($invoiceArr);
                if (empty($invoiceId)) {
                    $this->__errormsg('系统繁忙，稍后重试');
                } else {
                    $oiArr = array(
                        'order_id' => $order_id,
                        'invoice_id' => $invoiceId
                    );
                    $this->order_invoice_model->insert($oiArr);
                }
            } else {
                $status = $this->invoice_model->update($invoiceArr, array(
                    'id' => $invoiceData ['invoice_id']
                ));
                if (empty($status)) {
                    $this->__errormsg('系统繁忙，稍后重试');
                }
            }
        }

        $order_detail = array(
            'order_id' => $order_id,
            'amount' => $amount,
            'bankname' => $bank,
            // 'bankcard' => $card,
            // 'receipt'=>$hz_number,
            'addtime' => date('Y-m-d H:i:s', time()),
            'status' => 0
        );
        $status = $this->db->insert('u_order_detail', $order_detail);
        if ($status) {
            $data = array(
                'status' => 2,
                'ispay' => 2
            );
            $where = array(
                'id' => $order_id
            );
            $status = $this->db->update('u_member_order', $data, $where);
            $this->order_status_model->update_order_status_cal($order_id);    //统计订单用
        }
        if ($status) {
            $this->__successmsg();
        }
    }

    /**
     * @name：线下支付
     * @author: 温文斌
     * @param:data

     * @return:
     *
     */
    public function cfgm_offline_pay() {
        //1、加载模型
        $this->load->model('admin/b1/order_status_model', 'order_status_model');
        $this->load->model('app/u_member_order_model', 'order_model');
        $this->load->model('app/u_line_model', 'line_model');

        //2、传值（银行）
        $account_name = $this->input->post('name'); //开户人姓名
        $bank_name = $this->input->post('bank'); //银行
        //$card_num = $this->input->post ( 'num' ); //银行卡号
        $offline_num_before = $this->input->post('offline_num_before'); //银行卡前4位数字
        $offline_num_after = $this->input->post('offline_num_after'); //银行卡前4位数字
        $card_num = $offline_num_before . "-" . $offline_num_after;

        $receipt = $this->input->post('sn');  //流水号
        $receipt_img = $this->input->post('imgurl'); //流水图片
        if (empty($receipt_img)) {
            $receipt_img = '';
        }

        $pay_amount = floatval($this->input->post('pric')); //付款金额
        $order_id = $this->input->post('orderid'); //订单ID
        $fapiao = intval($this->input->post('fapiao')); //是否要发票
        $token = $this->input->post('number', true);  //token
        //3、传值（发票信息）
        $invoice_name = ($this->input->post('cdname', true)); // 发票抬头
        $invoice_detail = ($this->input->post('ticketype', true)); // 发票类型
        $receiver = ($this->input->post('toname', true)); // 收件人
        $telephone = ($this->input->post('mobile', true)); // 手机号
        $city = ($this->input->post('cityval')); // 省市区
        $address = ($this->input->post('citypid', true)); // 详细地址
        //4、检查登录、用户id
        $this->check_token($token); //检测登录

        $userid = $this->F_get_mid($token);

        //5、订单验证、线路有效验证
        $order_info = $this->order_model->row(array('id' => $order_id)); // 判断订单是否存在
        if (empty($order_info)) {
            $this->__errormsg("订单不存在！");
        }

        $line_info = $this->line_model->row(array('id' => $order_info ['productautoid'], 'status' => 2));
        if (empty($line_info)) {
            $this->__errormsg("您选择的旅游线路不存在或已下架，请咨询您的旅游专家！"); // 验证线路
        }

        //6、存入数据表u_member_order_invoice、u_member_invoice（发票）
        if (($fapiao == '1')) {
            if (empty($invoice_name)) {
                $this->__errormsg('请填写发票抬头');
            }
            if (empty($invoice_detail)) {
                $this->__errormsg('请填写发票类型');
            }
            if (empty($receiver)) {
                $this->__errormsg('请填写收件人');
            }
            if (empty($telephone)) {
                $this->__errormsg('请填写手机号');
            }
            if (empty($city)) {
                $this->__errormsg('请填写省市区');
            }
            if (empty($address)) {
                $this->__errormsg('请填写填写详细地址');
            }
            $time = date('Y-m-d H:i:s', time());
            $invoiceArr = array(
                'invoice_name' => $invoice_name,
                'invoice_detail' => $invoice_detail,
                'receiver' => $receiver,
                'telephone' => $telephone,
                'address' => $city . $address,
                'member_id' => $userid,
                'modtime' => $time
            );
            $this->load->model('app/u_member_order_invoice_model', 'order_invoice_model');
            $this->load->model('app/u_member_invoice_model', 'invoice_model');
            $invoiceData = $this->order_invoice_model->row(array(
                'order_id' => $order_id
            ));
            if (empty($invoiceData)) {
                $invoiceArr ['addtime'] = $time;
                $invoiceId = $this->invoice_model->insert($invoiceArr);
                if (empty($invoiceId)) {
                    $this->__errormsg('系统繁忙，稍后重试');
                } else {
                    $oiArr = array(
                        'order_id' => $order_id,
                        'invoice_id' => $invoiceId
                    );
                    $this->order_invoice_model->insert($oiArr);
                }
            } else {
                $status = $this->invoice_model->update($invoiceArr, array(
                    'id' => $invoiceData ['invoice_id']
                ));
                if (empty($status)) {
                    $this->__errormsg('系统繁忙，稍后重试');
                }
            }
        }

        //7、存入数据表u_order_detail（订单详情）
        if (empty($account_name)) {
            $this->__errormsg("付款人开户名必填！");
        }
        if (empty($bank_name)) {
            $this->__errormsg("付款人开户银行名称必填！");
        }
        if (empty($offline_num_before)) {
            $this->__errormsg("银行卡前四位数字必填！");
        }
        if (empty($offline_num_after)) {
            $this->__errormsg("银行卡后四位数字必填！");
        }
        if (empty($receipt)) {
            $this->__errormsg("流水回执号必填！");
        }

        if (empty($line_info ['first_pay_rate']))
            $first_pay_rate = "1";
        else
            $first_pay_rate = $line_info ['first_pay_rate']; // 线路首付比例

        $min_pay_money = ($order_info ['total_price'] + $order_info ['settlement_price']) * $first_pay_rate; // 最少支付金额
        $all_price = $order_info ['total_price'] + $order_info ['settlement_price']; //订单总额
        // 判断订单的支付状态
        switch ($order_info ['ispay']) {
            case 0 : // 没有支付
                if ($order_info ['status'] == 1 || $order_info ['status'] == 0) {
                    // B1已留位可以支付 、  验证支付金额
                    $pay_amount = sprintf("%.2f", $pay_amount);
                    $min_pay_money = sprintf("%.2f", $min_pay_money);
                    $all_price = sprintf("%.2f", $all_price);
                    if ($pay_amount < $min_pay_money) {
                        $this->__errormsg("支付金额最少为：￥{$min_pay_money}，请您重新填写支付金额");
                    }
                    if ($pay_amount > $all_price) {
                        $this->__errormsg("您填写的支付金额超过了订单金额!");
                    }
                } elseif ($order_info ['status'] < 0) {
                    $this->__errormsg("您的订单已取消，或留位失败");
                } else {
                    $this->__errormsg("订单有误，请联系客服");
                }
                break;
            case 1 : // 付完首付(支付宝每个订单号只可以支付一次)
                if ($order_info ['status'] < 2) {
                    $this->__errormsg("订单有误，请联系客服");
                } else {
                    // 验证支付金额
                    $final_pay = $order_info ['total_price'] - $order_info ['first_pay']; // 尾款
                    if (abs($pay_amount - $final_pay) > 0.001) {
                        $this->__errormsg("您填写的支付尾款不正确，尾款为：￥{$final_pay}");
                    }
                }
                break;
            case 2 : // 已付完
                $this->__errormsg("订单已支付完成，无需再支付");
                break;
            default : // 未知状态
                $this->__errormsg("订单有误，请联系您的专家");
                break;
        }
        // 验证流水号不能重复填写
        $this->db->select('count(*) AS receipt_count');
        $this->db->from('u_order_detail');
        $this->db->where(array(
            'receipt' => $receipt,
            'bankname' => $bank_name,
            'bankcard' => $card_num
        ));
        $receipt_c = $this->db->get()->result_array();
        if ($receipt_c [0] ['receipt_count'] >= 1) {
            $this->__errormsg("流水回执号已经存在,请重新填写");
        }
        // 写入订单支付详情表
        $this->db->trans_begin();
        $insert_data ['order_id'] = $order_info ['id'];
        $insert_data ['amount'] = $pay_amount;
        $insert_data ['account_name'] = $account_name;
        $insert_data ['bankname'] = $bank_name;
        $insert_data ['bankcard'] = $card_num;
        $insert_data ['receipt'] = $receipt;
        $insert_data ['addtime'] = date('Y-m-d H:i:s');
        $insert_data ['beizhu'] = '线下付款';
        $insert_data ['receipt_pic'] = $receipt_img;
        $insert_data ['status'] = 0;
        $status = $this->db->insert('u_order_detail', $insert_data);

        //8、写入订单日志表u_member_order_log、更改订单支付状态、发送短信
        if ($status) {
            $log_data ['order_id'] = $order_id;
            $log_data ['op_type'] = 0;
            $log_data ['userid'] = $userid;
            $log_data ['content'] = '用户付款 ';
            $log_data ['order_status'] = $order_info ['status'];
            $log_data ['addtime'] = date('Y-m-d H:i:s');
            $this->db->insert('u_member_order_log', $log_data);   //订单日志
            $order_data = array(
                'isneedpiao' => isset($fapiao) ? $fapiao : '0',
                'ispay' => 1,
                'first_pay' => $pay_amount,
                'final_pay' => 0
            );
            $this->db->where(array(
                'id' => $order_info ['id']
            ));

            $order_status = $this->db->update('u_member_order', $order_data); //更改订单状态

            $this->order_status_model->update_order_status_cal($order_id); //统计订单ID状态用

            if ($order_status) {
                /*
                 * 发消息给1:B2,2:B1
                 * 启用session
                 * $this->load->library('session');
                 * $userid=$this->session->userdata('c_userid');
                 * $username=$this->session->userdata('c_username');
                 */
                // 订单信息
                $order_message = $this->order_model->get_alldata('u_member_order', array(
                    'id' => $order_id
                ));

                $expert = $this->input->post('expert');
                $supplier = $this->input->post('supplier');
                if (!empty($expert)) { // 发给b2
                    $this->add_message('用户' . $username . '付款，订单号:' . $order_message ["ordersn"] . ',线路：' . $order_message ['productname'], '1', $expert);
                }
                if (!empty($supplier)) { // 发给B1
                    $this->add_message('用户' . $username . '付款，订单号:' . $order_message ["ordersn"] . ',线路：' . $order_message ['productname'], '2', $supplier);
                }
                // 统计订单操作数据
                $this->load->model('admin/b1/order_status_model', 'order_status_model');
                $this->order_status_model->update_order_status_cal($order_id);

                //返回接口数据
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    echo json_encode(array(
                        'code' => 2000,
                        'msg' => 'ok',
                        'status' => $order_status
                    ));
                }
                //end
            } else {
                echo json_encode(array('code' => 4000, 'msg' => '提交失败'));
            }
        } else {
            echo json_encode(array(
                'code' => 4000,
                'msg' => '写入订单付款详情失败'
            ));
        }
    }

    /**
     * @name：个人中心-》用户修改个人资料显示页面
     * @author: 温文斌
     * @param:number=凭证
     * @return:
     *
     */
    public function cfgm_show_info() {
        $token = $this->input->post('number', true);
        $mid = $this->input->post('mid', true);
        //$mid="291";
        if (!$mid) {
            $this->check_token($token);
            $mid = $this->F_get_mid($token);
        }
        $this->db->select("mid,nickname,email,truename,address,postcode,sex");
        $this->db->from('u_member');
        $this->db->where(array(
            'mid' => $mid
        ));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：个人中心-》用户修改资料提交页面
     * @author: 温文斌
     * @param:number=凭证；data
     * @return:
     *
     */
    public function cfgm_update_info() {
        $token = $this->input->post('number', true);
        $mid = $this->input->post('mid', true);

        if (!$mid) {
            $this->check_token($token);
            $mid = $this->F_get_mid($token);
        }
        $data ['nickname'] = $this->input->post('nickname', true); //昵称
        $data ['email'] = $this->input->post('email', true);   //邮件
        $data ['truename'] = $this->input->post('truename', true); //真名
        $data ['sex'] = $this->input->post('sex', true);    //性别
        $data ['address'] = $this->input->post('address', true);  //地址
        $data ['postcode'] = $this->input->post('postcode', true); //邮编		
        $where = array('mid' => $mid);
      
        $this->db->update('u_member', $data, $where);
        if(!empty($data['nickname']) && !empty($data['email']) && !empty($data['truename']) && !empty($data['sex']) && !empty($data['address']) && !empty($data['postcode']) ){
			//完善资料增加积分
			$str_sql = "select points from u_points_log where ptype=1 and member_id=".$mid;
			$u_points_log_data = $this->db->query($str_sql)->result_array();
            if(empty($u_points_log_data)){//完善资料积分只能加一次判断
				$time = time();
				$this->db->trans_begin();//事务
				$this->db->query("update u_member set `points`=`points`+20 where mid = {$mid}");//增加积分
				$data = array(
					'member_id'=>$mid,									
					'points'=>20,
					'type' => 0,
					'ptype' => 1,				
					'info' => '完善个人资料增加积分',
					'addtime' => $time,									
				);	
				$this->db->insert ( 'u_points_log', $data );//增加积分记录
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();	
				} else {
					$this->db->trans_commit();
				}
			}			
		}
        $this->__successmsg();
    }

    /**
     * @name：个人中心-》修改用户头像图片
     * @author: 温文斌
     * @param:number=凭证；data
     * @return:
     *
     */
    public function cfgm_user_update_photo() {
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $m_id = $this->F_get_mid($token);
        //$path = "/file/c/img/";
        $path = "../bangu/file/c/img/";
        $input_name = "upfile";
        $photo = $this->cfgm_upload_pimg($path, $input_name);
        $where = array(
            'mid' => $m_id
        );
        if (is_array($photo)) {
            $this->__errormsg("只能上传一张！");
        } else {
            $data = array(
                'litpic' => "/file/c/img/" . $photo
            );
            $status = $this->db->update('u_member', $data, $where);
        }
        if ($status) {
            $this->__successmsg($m_id);
        }
    }

    /**
     * @name：个人中心-》修改密码
     * @author: 温文斌
     * @param:number=凭证；data
     * @return:
     *
     */
    public function cfgm_set_password() {
        $ys_psd = $this->input->post('old_password', true);
        $new_psd = $this->input->post('new_password', true);
        $token = $this->input->post('number', true);
        $mid = $this->input->post('mid', true);
        if (!$mid) {
            $this->check_token($token);
            $mid = $this->F_get_mid($token);
        }

        $this->load->model('app/u_member_model', 'mm_model');
        $ys_data = $this->mm_model->result(array('mid' => $mid), null, null, null, 'arr', null, 'mid,pwd');
        if ($ys_data [0] ['pwd'] != md5($ys_psd)) {
            $this->__errormsg("原密码错误", "-2");
        }
        if ($new_psd) {
            $data ['pwd'] = md5($new_psd);
        } else {
            $this->__errormsg('新密码不能为空！');
        }
        $where = array(
            'mid' => $mid
        );
        $status = $this->db->update('u_member', $data, $where);
        if ($status) {
            $this->__successmsg();
        } else {
            $this->__errormsg('修改失败');
        }
    }

    /**
     * @name：忘记密码
     * @author: 温文斌
     * @param:number=凭证；data
     * @return:
     *
     */
    public function cfgm_phone_password() {
        $this->load->library('session');
        $mobile = $this->input->post('mobile', true);
        $data ['pwd'] = md5($this->input->post('new_password', true));
        $code = $this->input->post('code', true);
        $where = array(
            'mobile' => $mobile
        );
        $code_mobile = $this->session->userdata('mobile');
        $code_number = $this->session->userdata('code');
        $code_time = $this->session->userdata('time');
        if (($code_mobile == $mobile) && ($code_number == $code)) {
            $status = $this->db->update('u_member', $data, $where);
            if ($status) {
                $this->__successmsg('重设密码成功');
            } else {
                $this->__errormsg('重设密码失败');
            }
        } else {
            $this->__errormsg('验证码输入错误');
        }
    }

    /**
     * @name：退出登录
     * @author: 温文斌
     * @param:number=凭证；data
     * @return:
     *
     */
    public function cfgm_user_logout() {
        $token = $this->input->post('number', true);
        $time = time() - 3600;
        $status = $this->db->query("update u_access_token set access_token_validtime={$time} where access_token='{$token}'");
        if ($status) {
            $this->__successmsg();
        }
    }

    /**
     * @name：管家搜索条件=》目的地所在行政区域
     * @author: 温文斌
     * @param:cityname=当前城市
     * @return:
     *
     */
    public function cfgm_in_location() {
        $city_name = $this->input->post('cityname');
        if (preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $city_name)) {
            $query = $this->db->query("SELECT id AS p_id FROM u_area WHERE name like '%{$city_name}%'");
            $city = $query->result_array();
            if (empty($city)) {
                $this->__errormsg();
            }
        } else {
            $this->__errormsg('城市输入有误！');
        }
        $this->db->select('id AS a_id,name AS a_name,pid AS p_id,(SELECT name FROM u_area WHERE id=pid) AS p_name');
        $this->db->from('u_area');
        $this->db->where(array(
            'pid' => $city [0] ['p_id'],
            'isopen' => 1,
            'level' => 4
        ));
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：管家搜索条件-》管家类型
     * @author: 温文斌
     * @param:cityname=当前城市
     * @return:
     *
     */
    public function cfgm_expert_type() {
        $this->db->select('eg.id,eg.grade,eg.title');
        $this->db->from('u_expert_grade AS eg');
        $query = $this->db->get();
        $reDataArr = $query->result_array();
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：线路搜索条件-》线路标签
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function cfgm_line_attr() {

        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 155 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['观光'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 156 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['度假'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 157 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['主题'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 217 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['运动'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 218 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['娱乐'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 219 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['餐饮'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 220 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['酒店'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 221 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['交通'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 222 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['行程'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 223 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['体验'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 224 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['价格'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 225 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['适合'] = $query->result_array();
        $sql = "select id,attrname,displayorder,ishot from u_line_attr where pid= 226 and isopen =1";
        $query = $this->db->query($sql);
        $reDataArr ['类型'] = $query->result_array();
        // print_r($this->db->last_query());exit();
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：得到证件类型(提交订单和修改出游人的时候用)
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_order_idtype() {
        $lineid = $this->input->post('lineid', true);
        is_numeric($lineid) ? ($lineid) : $this->__errormsg('线路标识不能为空！');
        $query = $this->db->query("select right(overcity,1) as city from u_line where id={$lineid}");
        $city = $query->result_array();
        $num = $city [0] ['city'];
        if ($city [0] ['city'] == 1) {
            $where = "where pid =100";
        } elseif ($city [0] ['city'] == 2) {
            $where = "where pid =99";
        } else {
            $where = "where pid =99";
        }
        $query = $this->db->query("select dict_id,description from u_dictionary {$where}");
        $result ['type_id'] = $query->result_array();
        $result ['inou'] = "$num";
        if ($result) {
            $this->__outmsg($result);
        }
    }

    /**
     * @name：得到某线下的“更多管家”
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_more_expert() {
        $sort = $this->input->post("sort");
        $content = $this->input->post("content");
        $l_id = $this->input->post("lineid");
        //$l_id="1037";
        //$sort="3";
        is_numeric($l_id) ? ($l_id) : $this->__errormsg('线路id不能为空');
        is_numeric($sort) ? ($sort) : $this->__errormsg('排序参数不能为空');
        $this->load->helper('regexp');
        if (!isset($content)) {
            $content = $content;
        }
        if (!empty($content) || regexp('zhcnup', $content)) {
            $content = $content;
        }
        // where条件
        $where = "";
        if ($sort == '1') { // 在线优先
            $where = "and (e.nickname like '%{$content}%' or ua.name like '%{$content}%')   order by e.online    desc  ";
        } elseif ($sort == '2') { // 满意度
            $where = "and (e.nickname like '%{$content}%' or ua.name like '%{$content}%')  order by e.satisfaction_rate  desc";
        } elseif ($sort == '3') { // 成交
            $where = "and (e.nickname like '%{$content}%' or ua.name like '%{$content}%')  order by e.people_count  desc ";
        } else {
            $this->__errormsg();
        }
        $reDataArr = $this->db->query(
                        "     
				SELECT 
				 		e.id AS expert_id,e.realname,e.nickname, e.big_photo,e.small_photo,e.comment_count,
						e.attention_count,e.sex,e.online,e.expert_dest as expert_destid, e.expert_theme AS expert_dest, e.satisfaction_rate, 
						e.people_count, ua.name as cityname, e.title as grade,	    
						e.visit_service as visit_serviceid,(select GROUP_CONCAT(name SEPARATOR ' ') from u_area where level=4 and FIND_IN_SET(id,e.visit_service) >0 )as visit_service, 
						 (select GROUP_CONCAT(d.kindname SEPARATOR ' ') as expert_dest from u_dest_cfg as d where FIND_IN_SET(d.id,substring_index  (e.expert_dest,',',3))) as expert_dest
					    
				FROM 	
						u_expert AS e 	
						LEFT JOIN u_line_apply AS la ON e.id = la.expert_id 	
						left join u_area as ua on ua.id=e.city  
						left join u_expert_grade as eg on e.grade=eg.grade
				WHERE 	
						la.line_id = {$l_id} 	AND la. STATUS = 2  and e.`status`=2 and e.is_kf='N'   {$where}  	   
				"
                )->result_array();
        foreach ($reDataArr as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "satisfaction_rate") {
                    if ($v) {
                        $val [$k] = round($v * 100);
                    }
                }
            }
            $reDataArr [$key] = $val;
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：管家详情下的售卖线路
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_sell_line() {
        //$page = intval ( $this->input->post ( 'page', true ) );
        //$eid = $this->input->post ( "eid" );

        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        $eid = intval(isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '0');
        $page = intval(isset($_REQUEST['page']) ? $_REQUEST['page'] : '1');

        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == false ? 1 : $page;

        $from = ($page - 1) * $page_size + 3; //从第3条开始
        if (!$eid)
            $this->__errormsg('param missing');
        $sql = "select 
						la.id,la.expert_id,l.id AS line_id,l.linename,l.linetitle,l.mainpic,l.lineprice,
						l.satisfyscore,l.all_score,l.peoplecount, l.shownum,l.collectnum,sharecount,
		                (select sum(avgscore2) from u_comment as c where c.line_id=l.id and c.expert_id={$eid}) as expert_total_score,
		                GROUP_CONCAT(s.cityname) as startplace
				from 
						u_line_apply AS la
						left join u_line AS l on l.id=la.line_id	
						left join u_line_startplace as ls on ls.line_id=l.id
						left join u_startplace as s on s.id=ls.startplace_id
						
				where 
						la.status=2 and l.producttype=0 and l.status='2' and la.expert_id={$eid}  
				GROUP BY 
						l.id limit {$from},{$page_size}    
				";
        $query = $this->db->query($sql);
        $data ['line_list'] = $query->result_array();

        foreach ($data ['line_list'] as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "satisfyscore") {
                    if ($v)
                        $val [$k] = round($v * 100);
                }
                if ($k == "collectnum") {
                    if (empty($v))
                        $val [$k] = "0";
                    else
                        $val [$k] = $v;
                }
            }
            $data ['line_list'] [$key] = $val;
        }

        if (empty($data ['line_list'])) {
            $this->__wap($data ['line_list'], $callback);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $total_rows = $query->num_rows() - 3; //总条数-3
        $total_page = ceil($total_rows / $page_size);
        $data = array(
            'cur_page' => $page,
            'page_size' => $page_size,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
            'result' => $data ['line_list']
        );
        $this->__wap($data, $callback);
    }

    /**
     * @name：管家详情下的定制列表
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_custiome_list() {

        //$page = intval ( $this->input->post ( 'page', true ) );
        //$eid = $this->input->post ( "eid" );
        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        $eid = intval(isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '0');
        $page = intval(isset($_REQUEST['page']) ? $_REQUEST['page'] : '1');

        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size + 3; //从第三条开始

        if (!$eid)
            $this->__errormsg('param missing');
        $sql = "   
				select 
							uc.id as id,uc.question as question,uc.budget as budget,uc.pic as litpic,
							uc.total_people as total_people,uc.startdate as startdate,uc.estimatedate as estimatedate,
							uc.startplace as startplace,uc.endplace as endplace,uc.status as status,uca.expert_id as expert_id,
							uca.isuse as isuse, ua.name as area_name,ud.kindname as dest_name, ue.nickname as nickname 	 
				from
							u_customize as uc 
							left join u_customize_answer as uca on uc.id=uca.customize_id 	
							left join u_line as l on uc.line_id=l.id 		
							left join u_expert as ue on uca.expert_id=ue.id 	
							left join u_area as ua on ua.id=uc.startplace 		
							left join u_dest_cfg as ud on ud.id=uc.endplace 	
				where 
							uc.status='3' and uca.isuse='1' and ISNULL(uca.replytime)=0 and uca.expert_id={$eid} 
				order by 
							uc.addtime desc
				limit {$from},{$page_size}     ";
        $query = $this->db->query($sql);
        $data ['customiz_list'] = $query->result_array();
        if (empty($data ['customiz_list'])) {
            $this->__wap($data ['customiz_list'], $callback);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $total_rows = $query->num_rows() - 3; //总条数-3
        $total_page = ceil($total_rows / $page_size);
        $data = array(
            'cur_page' => $page,
            'page_size' => $page_size,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
            'result' => $data ['customiz_list']
        );

        $this->__wap($data, $callback);
    }

    /**
     * @name：管家详情下的评论
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_comment_list() {
        //$page = intval ( $this->input->post ( 'page', true ) );
        //$eid = $this->input->post ( "eid" );
        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        $eid = intval(isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '0');
        $page = intval(isset($_REQUEST['page']) ? $_REQUEST['page'] : '1');

        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size + 3; //从第3条开始
        //$eid="1";
        if (!$eid)
            $this->__errormsg('param missing');
        $type = $this->input->post("type");
        if (is_numeric($type)) {
            if ($type == '1') {
                $where = " and uc.avgscore2='5' ";
            } // 惊喜
            elseif ($type == '2') {
                $where = " and uc.avgscore2<'5' and uc.avgscore2>='4' ";
            } // 满意
            elseif ($type == '3') {
                $where = "  and uc.avgscore2<'4' and uc.avgscore2>='3' ";
            } // 一般
            elseif ($type == '4') {
                $where = " and uc.avgscore2<'3' ";
            } // 失望
            elseif ($type == '0') {
                $where = "  ";
            } // 失望
        } else {
            $where = ' ';
        }

        $sql = "
				select 
							uc.addtime,uc.expert_content,uc.reply1,uc.reply2,uc.score5,uc.score6,
							um.litpic,um.nickname as nickname,mo.productautoid as productautoid,
							l.linename as line_name,l.linetitle as line_title 
				  from 
							u_comment as uc 
							left join u_member as um on uc.memberid=um.mid 	
							left join u_member_order as mo on uc.orderid=mo.id 	
							left join u_line as l on l.id=mo.productautoid 	
				  where 
				 			uc.status=1 and uc.expert_id={$eid} 
				 order by  
							uc.addtime desc 
				 limit {$from},{$page_size}     ";
        $query = $this->db->query($sql);
        $data ['comment_list'] = $query->result_array();
        if (empty($data ['comment_list'])) {
            $this->__wap($data ['comment_list'], $callback);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $total_rows = $query->num_rows() - 3; //总条数-3
        $total_page = ceil($total_rows / $page_size);
        $data = array(
            'cur_page' => $page,
            'page_size' => $page_size,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
            'result' => $data ['comment_list']
        );
        $this->__wap($data, $callback);
    }

    /**
     * @name：管家详情下的动态
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_condition() {
        //$page = intval ( $this->input->post ( 'page', true ) );
        //$eid = $this->input->post ( "eid" );
        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        $eid = intval(isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '0');
        $page = intval(isset($_REQUEST['page']) ? $_REQUEST['page'] : '1');

        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size + 3; //从第3条开始
        if (!$eid)
            $this->__wapmsg('param missing', $callback);
        $sql = "
		        select 
        		       c.*,(select GROUP_CONCAT(cp.pic SEPARATOR ',') as pic from u_expert_condition_pic as cp where cp.condition_id=c.id) as pic,
        		       (select GROUP_CONCAT(cp.len SEPARATOR ',') as len from u_expert_condition_pic as cp where cp.condition_id=c.id) as len,
        		       (select GROUP_CONCAT(cp.wei SEPARATOR ',') as wei from u_expert_condition_pic as cp where cp.condition_id=c.id) as wei
        		from 
        			   u_expert_condition as c
        		where 
        				c.id={$eid}
        	    order by 
        	    		c.addtime desc
				limit {$from},{$page_size}     
        	 ";
        $query = $this->db->query($sql);
        $condition = $query->result_array();

        foreach ($condition as $item => $value) {
            $pic_arr = explode(",", $value['pic']);
            $len_arr = explode(",", $value['len']);
            $wei_arr = explode(",", $value['wei']);
            $new_pic_arr = array();
            foreach ($pic_arr as $key => $pic_value) {
                $new_pic = array();
                $new_pic['pic'] = $pic_value;
                $new_pic['len'] = $len_arr[$key];
                $new_pic['wei'] = $wei_arr[$key];

                $new_pic_arr[$key] = $new_pic;
            }

            $condition[$item]['pic_arr'] = $new_pic_arr;
            $condition[$item]['pic_num'] = count($pic_arr);
        }

        $data['condition_list'] = $condition;
        if (empty($data ['condition_list'])) {
            $this->__wap($data ['condition_list'], $callback);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $total_rows = $query->num_rows() - 3; //总条数-3

        $total_page = ceil($total_rows / $page_size);
        $data = array(
            'cur_page' => $page,
            'page_size' => $page_size,
            'total_rows' => $total_rows,
            'total_page' => $total_page,
            'result' => $data ['condition_list']
        );
        $this->__wap($data, $callback);
    }

    /**
     * @name：cfmg_expert_consultation_list
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_consultation_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $eid = $this->input->post("eid");
        is_numeric($eid) ? ($eid) : $this->__errormsg('管家标识不能为空！');
        $sql = "   select ulq.*,ul.linename,ul.linetitle,um.nickname from u_line_question as ulq left join u_line as ul on ul.id=ulq.productid    left join u_member as um on um.mid=ulq.memberid     where ulq.replytime!='' and ulq.reply_type=1 and ulq.reply_id={$eid}  order by ulq.addtime desc limit {$from},{$page_size}  ";
        $query = $this->db->query($sql);
        $data ['line_list'] = $query->result_array();
        if (empty($data ['line_list'])) {
            $this->__outmsg($data ['line_list']);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $data ['line_list_total'] = $query->num_rows();
        $total = ceil($data ['line_list_total'] / $page_size);
        $data = array(
            'cur_page' => $from,
            'total' => $page_size,
            'result' => $data ['line_list'],
            'total_rows' => $data ['line_list_total']
        );
        $this->__outmsg($data);
    }

    /**
     * @name：管家详情下的游记
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_travels_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $eid = $this->input->post("eid");
        is_numeric($eid) ? ($eid) : $this->__errormsg('管家标识不能为空！');
        $sql = " SELECT tn.id , tn.title, DATE_FORMAT(tn.addtime  , '%Y-%m-%d') AS addtime, `tn`.`comment_count` AS comment_count, `tn`.`praise_count` AS praise_count, `tn`.`content` AS content, `tn`.`cover_pic` AS pic FROM (`travel_note` AS tn) WHERE `tn`.`userid` = {$eid} AND `tn`.`usertype` = 1 AND `tn`.`is_show` = 1 ORDER BY `tn`.`addtime` desc limit {$from},{$page_size}  ";
        $query = $this->db->query($sql);
        $data ['line_list'] = $query->result_array();
        if (empty($data ['line_list'])) {
            $this->__outmsg($data ['line_list']);
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $data ['line_list_total'] = $query->num_rows();
        $sql = " SELECT nickname from u_expert where id={$eid} ORDER BY id desc  limit 1  ";
        $query = $this->db->query($sql);
        $data ['expert'] = $query->row_array();
        $total = ceil($data ['line_list_total'] / $page_size);
        $data = array(
            'cur_page' => $from,
            'total' => $page_size,
            'result' => $data ['line_list'],
            'expert' => $data ['expert'],
            'total_rows' => $data ['line_list_total']
        );
        $this->__outmsg($data);
    }

    /**
     * @name：管家详情下的代购
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_onuserbuy_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $eid = $this->input->post("eid");
        is_numeric($eid) ? ($eid) : $this->__errormsg('管家标识不能为空！');
        $sql = "         select uee.id as id,uee.content as content,uee.addtime as addtime,uee.praise_count as praise,ueep.pic as pic from u_expert_essay as uee left join u_expert_essay_pic as ueep on uee.id=ueep.expert_essay_id   where uee.expert_id={$eid}  order by uee.addtime desc  limit {$from},{$page_size}";
        $query = $this->db->query($sql);
        $datas = $query->result_array();
        if (empty($datas)) {
            $this->__outmsg($datas);
        }
        foreach ($datas as $key => $val) {          //用于转换数组，只因数组内嵌过多，导致图片过滤无法带上域名，而后转换域名。
            foreach ($val as $k => $v) {
                if ($k == "pic") {
                    if ($v) {
                        $val [$k] = explode(";", $v);
                        foreach ($val [$k] as $k) {
                            if (!empty($k)) {
                                $val ['pics'] [] = "http://" . $_SERVER ['HTTP_HOST'] . $k;
                            }
                        }
                        $val ['pic'] = '1';
                    }
                }
            }
            $datas [$key] = $val;
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");
        $query = $this->db->query($sql);
        $data ['line_list_total'] = $query->num_rows();         //条数
        $total = ceil($data ['line_list_total'] / $page_size);
        $data = array(
            'cur_page' => $from,
            'total' => $page_size,
            'result' => $datas,
            'total_rows' => $data ['line_list_total']
        );
        $this->__outmsg($data);
    }

    /**
     * @name：游记详情
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_travel_note_detail() {
        $note_id = $this->input->post("note_id");  //游记id
        //$note_id = "148";
        is_numeric($note_id) ? ($note_id) : $this->__errormsg('游记id不能为空！');
        //游记=》管家部分
        $reDataArr ['expert'] = $this->db->query(
                        "SELECT 
						     e.id AS expert_id,tn.is_show,tn.usertype,e.small_photo AS expert_photo,e.nickname AS expert_nickname,m.nickname as member_nickname,m.litpic as member_photo,
				 			 eg.title AS e_grade,tn.travel_impress AS travel_theme,l.linename AS linename,
							l.overcity,l.id as lineid,DATE_FORMAT(tn.addtime,'%Y-%m-%d') AS publish_time,
							(SELECT GROUP_CONCAT(attrname SEPARATOR ',') FROM u_line_attr AS la WHERE FIND_IN_SET(la.id,l.linetype)) AS line_attr, 
							tn.praise_count AS praise_count,tn.comment_count,tn.content AS content,tn.cover_pic as mainpic
				FROM 		
							travel_note AS tn 
							LEFT JOIN u_expert AS e ON e.id=tn.userid
							LEFT JOIN u_member AS m ON m.mid=tn.userid
							LEFT JOIN u_line AS l ON tn.line_id=l.id 
							LEFT JOIN u_expert_grade AS eg ON e.grade=eg.grade 
				WHERE tn.id={$note_id}  
				"
                )->row_array();

        //游记=》详情
        $pics = $this->db->query(
                        "SELECT 
						tnp.pic ,tnp.description,tn.id ,tnp.pictype 
				FROM 
						 travel_note_pic AS tnp 
				         left join travel_note as tn on tn.id=tnp.note_id
				WHERE 
						tnp.note_id={$note_id} 
				ORDER BY 
						tnp.pictype desc ")->result_array();

        if (!empty($pics)) {
            foreach ($pics as $key => $val) {
                if ($val ['pictype'] == '1') {
                    $inter_city ['eat'] [] = array('id' => $val ['id'], 'pictype' => $val ['pictype'], 'description' => $val ['description'], 'pic' => $val ['pic']);
                } elseif ($val ['pictype'] == '2') {
                    $inter_city ['live'] [] = array('id' => $val ['id'], 'pictype' => $val ['pictype'], 'description' => $val ['description'], 'pic' => $val ['pic']);
                } elseif ($val ['pictype'] == '3') {
                    $inter_city ['walk'] [] = array('id' => $val ['id'], 'pictype' => $val ['pictype'], 'description' => $val ['description'], 'pic' => $val ['pic']);
                } elseif ($val ['pictype'] == '4') {
                    $inter_city ['buy'] [] = array('id' => $val ['id'], 'pictype' => $val ['pictype'], 'description' => $val ['description'], 'pic' => $val ['pic']);
                }
                $reDataArr ['pics'] = $inter_city;
            }
        }
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：线路详情下的体验分享
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_line_share() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $eid = $this->input->post("eid");
        is_numeric($eid) ? ($eid) : $this->__errormsg('线路标识不能为空！');
        $sql = "     select tn.id,tn.title,tn.content,tn.cover_pic,tn.modtime,tn.line_id,um.nickname as nickname from travel_note as tn left join u_member as um on tn.userid=um.mid where tn.usertype='0' and tn.is_show='1' and tn.status='1' and   tn.line_id={$eid} order by tn.modtime desc limit {$from},{$page_size}  ";
        $query = $this->db->query($sql);
        $data ['line_list'] = $query->result_array();
        if (empty($data ['line_list'])) {
            $this->__outmsg($data ['line_list']);     //为空输出
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");  //输出条数
        $query = $this->db->query($sql);
        $data_total = $query->num_rows();
        $total = ceil($data_total / $page_size);
        $data = array(
            'cur_page' => $from,
            'total' => $page_size,
            'result' => $data ['line_list']
        );
        $this->__outmsg($data, $data_total);
    }

    /**
     * @name：线路详情下的线路评价
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_user_comment_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $eid = $this->input->post("eid"); //线路ID
        $type = $this->input->post("type");

        is_numeric($type) ? ($type) : $this->__errormsg('标识不能为空！');
        is_numeric($eid) ? ($eid) : $this->__errormsg('线路标识不能为空！');
        if ($type == '1') {
            $where = " and uc.avgscore1='5' ";
        } // 惊喜
        elseif ($type == '2') {
            $where = " and uc.avgscore1<'5' and uc.avgscore1>='4' ";
        } // 满意
        elseif ($type == '3') {
            $where = "  and uc.avgscore1<'4' and uc.avgscore1>='3' ";
        } // 一般
        elseif ($type == '4') {
            $where = " and uc.avgscore1<'3' ";
        } // 失望
        elseif ($type == '5') {
            $where = "  ";
        }  // 全部
        else {
            $this->__errormsg('sorry , no it !');
        }
        $sql = "select
							uc.score1,uc.score2,uc.score3,uc.score4,uc.addtime,uc.reply1,uc.reply2,uc.content ,
							um.mobile ,um.nickname ,uc.pictures as pic
							from
							u_comment as uc
							left join u_member as um on uc.memberid=um.mid
							where
							uc.status=1 and uc.line_id={$eid} {$where}
							order by
							uc.addtime desc limit {$from},{$page_size}
							";
        $query = $this->db->query($sql);
        $datas = $query->result_array();
        if (empty($datas)) {
            $this->__outmsg($datas);     //空输出
        }
        // 为图片路径 加域名
        foreach ($datas as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "pic") {
                    if ($v) {
                        $val [$k] = explode(",", $v);
                        foreach ($val [$k] as $k) {
                            if (!empty($k)) {
                                $val ['pics'] [] = BANGU_URL . $k;
                            }
                        }
                        $val ['pic'] = '1';
                    }
                }
            }
            $datas [$key] = $val;
        }
        //处理号码
        foreach ($datas as $key => $val) {
            foreach ($val as $k => $v) {
                if ($k == "mobile") {
                    if ($v) {
                        $val [$k] = substr_replace($v, '*****', 4, 4);
                    }
                }
            }
            $datas [$key] = $val;
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");  //处理条数
        $query = $this->db->query($sql);
        $dat = $query->num_rows();
        $total = ceil($dat / $page_size);
        $data = array(
            'cur_page' => $from,
            'total' => $page_size,
            'result' => $datas
        );
        $this->__outmsg($data, $dat);
    }

    /**
     * @name：管家收藏
     * @author: 温文斌
     * @param: number=凭证；eid=管家id;mid=用户id
     * @return:
     *
     */
    public function cfgm_expert_collect() {
        //$eid = $this->input->post ( 'eid' ,true);
        //$mid = $this->input->post ( 'mid' ); //wap端 ：用户id
        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        $eid = intval(isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '0');
        $mid = intval(isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '0');

        $token = $this->input->post('number', true);  //app端 : 用户session
        //$mid="291";
        //$eid="1";

        if (!$eid)
            $this->__wapmsg('参数缺失', $callback);
        if (!$token && !$mid)
            $this->__wapmsg('参数缺失', $callback);

        if ($token) { //若是app端
            $this->check_token($token);

            $mid = $this->F_get_mid($token);
        }

        $reDataArr = $this->db->query(" SELECT * FROM (`u_expert_collect`) WHERE `expert_id` = {$eid} AND `member_id` = {$mid}")->result_array();
        if (empty($reDataArr)) {
            $llData = array(
                'expert_id' => $eid,
                'member_id' => $mid,
                'addtime' => date('Y-m-d H:i:s', time())
            );
            $result = $this->db->insert("u_expert_collect", $llData);
            if ($result) {
                $this->db->query("update u_expert set `attention_count`=`attention_count`+1 where id = {$eid}");   //更新管家收藏数				
                if (empty($callback))
                    echo json_encode(array('code' => 2000, 'msg' => '收藏成功！'));
                else
                    echo $callback . "(" . json_encode(array('code' => 2000, 'msg' => '收藏成功！')) . ")";
            } else
                $this->__errormsg('操作异常');
        }
        else {
            $status = $this->db->delete('u_expert_collect', array(
                'expert_id' => $eid,
                'member_id' => $mid
            ));
            if ($status) {
                $this->db->query("update u_expert set `attention_count`=`attention_count`-1 where id = {$eid}");   //更新管家收藏数					
                if (empty($callback))
                    echo json_encode(array('code' => 2000, 'msg' => '已取消收藏！'));
                else
                    echo $callback . "(" . json_encode(array('code' => 2000, 'msg' => '已取消收藏！')) . ")";
            } else
                $this->__errormsg('操作异常');
        }
    }

    /**
     * @name：管家点赞
     * @author: 温文斌
     * @param: number=凭证；eid=管家id;mid=用户id
     * @return:
     *
     */
    public function cfgm_expert_praise() {
        $callback = empty($_REQUEST["callback"]) ? '' : $_REQUEST['callback'];
        $eid = isset($_REQUEST['eid']) ? $_REQUEST['eid'] : '0';
        $mid = isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '0'; //wap端 ：用户id
        $token = isset($_REQUEST['number']) ? $_REQUEST['number'] : ''; //app端 : 用户session
        //$eid = $this->input->post ( 'eid' ,true);
        //$mid = $this->input->post ( 'mid' ); //wap端 ：用户id
        //$token = $this->input->post ( 'number', true );  //app端 : 用户session
        //$mid="291";
        //$eid="1";

        if (!$eid)
            $this->__wapmsg('param missing', $callback);
        if (!$token && !$mid)
            $this->__wapmsg('param missing', $callback);

        if ($token) { //若是app端
            $this->check_token($token);
            $mid = $this->F_get_mid($token);
        }

        $reDataArr = $this->db->query(" SELECT * FROM (`u_expert_praise`) WHERE `expert_id` = {$eid} AND `member_id` = {$mid}")->result_array();
        if (empty($reDataArr)) {
            $this->db->trans_begin(); //事务开启
            $llData = array(
                'expert_id' => $eid,
                'member_id' => $mid,
                'addtime' => date('Y-m-d H:i:s', time())
            );
            $result = $this->db->insert("u_expert_praise", $llData);
            //管家点赞+1
            $expert_detail = $this->F_expert_detail($eid);
            $new_praise_num = $expert_detail['praise_num'] + 1;
            $this->db->where(array('id' => $eid));
            $status = $this->db->update("u_expert", array('praise_num' => $new_praise_num));

            $this->db->trans_complete(); //事务结束
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $output = json_encode(array('code' => 2000, 'msg' => '点赞成功！', 'new_praise_num' => $new_praise_num));
                if (empty($callback))
                    echo $output;
                else
                    echo $callback . "(" . $output . ")";
            } else {
                $this->db->trans_rollback(); // 事务回滚
                $this->__wapmsg('操作异常', $callback);
            }
        }  //暂时不取消
        else {
            /* $status = $this->db->delete ( 'u_expert_praise', array (
              'expert_id' => $eid,
              'member_id' => $mid
              ) ); */
            //if($status)
            //echo json_encode ( array ('code' => 2000,'msg' => '取消点赞！') );
            //else
            $this->__wapmsg('您已经点过赞！', $callback);
        }
    }

    /**
     * @name：用户为管家游记点赞
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_good_detail() {
        $insert_arr = array();
        $note_id = $this->input->post('note_id');
        is_numeric($note_id) ? ($note_id) : $this->__errormsg('tip is null !');
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $c_userid = $this->F_get_mid($token);
        $this->db->select("count(*) AS  praise_count");
        $this->db->from('travel_note_praise');
        $this->db->where(array(
            'note_id' => $note_id,
            'member_id' => $c_userid
        ));
        $res = $this->db->get()->result_array();
        if ($res [0] ['praise_count'] == 0) {
            $insert_arr ['note_id'] = $note_id;
            $insert_arr ['member_id'] = $c_userid;
            $insert_arr ['ip'] = $_SERVER ["REMOTE_ADDR"];
            $insert_arr ['addtime'] = date('Y-m-d H:i:s');
            if ($this->db->insert('travel_note_praise', $insert_arr)) {
                $update_sql = "update travel_note set praise_count=praise_count+1 where id=$note_id";
                if ($this->db->query($update_sql)) {
                    $this->db->select("praise_count");
                    $this->db->from('travel_note');
                    $this->db->where(array(
                        'id' => $note_id
                    ));
                    $res = $this->db->get()->result_array();
                    echo json_encode(array(
                        'code' => 2000,
                        'msg' => '点赞成功',
                        'praise_count' => $res [0] ['praise_count']
                    ));
                } else {
                    echo json_encode(array(
                        'code' => 4000,
                        'msg' => '点赞失败'
                    ));
                }
            } else {
                echo json_encode(array(
                    'code' => 4000,
                    'msg' => '点赞失败'
                ));
            }
        } else {
            $delete_sql = "delete from travel_note_praise where note_id=$note_id and member_id=$c_userid";
            if ($this->db->query($delete_sql)) {
                $update_sql = "update travel_note set praise_count=praise_count-1 where id=$note_id";
                if ($this->db->query($update_sql)) {
                    $this->db->select("praise_count");
                    $this->db->from('travel_note');
                    $this->db->where(array(
                        'id' => $note_id
                    ));
                    $res = $this->db->get()->result_array();
                    echo json_encode(array(
                        'code' => 2001,
                        'msg' => '取消点赞',
                        'praise_count' => $res [0] ['praise_count']
                    ));
                } else {
                    echo json_encode(array(
                        'code' => 4000,
                        'msg' => '取消点赞失败'
                    ));
                }
            } else {
                echo json_encode(array(
                    'code' => 4000,
                    'msg' => '取消点赞失败'
                ));
            }
        }
    }

    /**
     * @name：游记详情的评论
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_comment_submit() {
        $token = $this->input->post('number', true);
        $this->check_token($token);

        $c_userid = $this->F_get_mid($token);
        $comment = $this->input->post('comment');
        mysql_real_escape_string($comment);
        $insert_arr = array();
        $insert_arr ['note_id'] = $this->input->post('note_id');
        $insert_arr ['member_id'] = $c_userid;
        $insert_arr ['reply_content'] = $comment;
        if (empty($insert_arr ['reply_content'])) {
            echo json_encode(array(
                'code' => 4000,
                'msg' => '发表内容不能为空'
            ));
            exit();
        }
        $this->load->helper("getip");
        $insert_arr ['ip'] = JSGetIP();
        $insert_arr ['addtime'] = date('Y-m-d H:i:s');
        if ($this->db->insert('travel_note_reply', $insert_arr)) {
            $sql = "update travel_note set comment_count=comment_count+1 where id=" . $this->input->post('note_id');
            if ($this->db->query($sql)) {
                echo json_encode(array(
                    'code' => 2000,
                    'msg' => '发表成功'
                ));
                exit();
            } else {
                echo json_encode(array(
                    'code' => 4000,
                    'msg' => '发表失败'
                ));
                exit();
            }
        } else {
            echo json_encode(array(
                'code' => 4000,
                'msg' => '发表失败'
            ));
            exit();
        }
    }

    /**
     * @name：私人定制列表
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_customize_list() {
        $page = intval($this->input->post('page', true));
        $page_size = intval($this->input->post('pagesize', true));
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = $page == '0' ? 1 : $page;
        $from = ($page - 1) * $page_size;
        $sql = " SELECT c.id ,c.question,c.pic,c.budget,c.people,	eg.title  AS grade,e.realname,e.nickname,e.small_photo,e.id AS expert_id  FROM u_customize_answer AS ca    LEFT JOIN u_customize AS c ON ca.customize_id=c.id   LEFT JOIN u_expert AS e ON ca.expert_id=e.id     left join u_expert_grade as eg on e.grade=eg.grade   WHERE ca.isuse=1 and c.status = 3 and e.status=2    order by c.id desc     limit {$from},{$page_size}  ";
        $query = $this->db->query($sql);
        $data ['line_list'] = $query->result_array();
        if (empty($data ['line_list'])) {
            $this->__outmsg($data ['line_list']);      //输出空
        }
        $sql = rtrim($sql, "limit {$from},{$page_size} ");   //取条数
        $query = $this->db->query($sql);
        $roes = $query->num_rows();
        $total = ceil($roes / $page_size);
        $data = array(
            'this_page' => $from,
            'page' => $page_size,
            'result' => $data ['line_list']
        );
        $this->__outmsg($data, $len = $roes);
    }

    /**
     * @name：与管家对话,获取管家信息
     * @author: 温文斌
     * @param: number=凭证；data
     * @return:
     *
     */
    public function cfgm_expert_api() {
        $this->load->model("app/u_expert_model", 'expert_model');
        $eid = $this->input->post('eid', true);
        is_numeric($eid) ? ($eid) : $this->__errormsg('tip is null !');
        $reDataArr = $this->expert_model->row(array('id' => $eid), $type = "arr", $gre = "ID DESC limit 1", $select = "nickname,mobile,small_photo,online");
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：意见反馈
     * @author: 温文斌
     * @param: number=凭证；
     * @return:
     *
     */
    public function cfgm_to_suggest() {
        $token = $this->input->post('number', true);
        $mid = $this->F_get_mid($token);
        //$mid="291";
        $content = $this->input->post('content'); //反馈内容
        //$content="测试";
        if (empty($content))
            $this->__errormsg('请填写反馈的内容');

        $this->load->model('app/u_member_model', 'u_member_model');
        $member = $this->u_member_model->row(array('mid' => $mid));

        $insert_data = array(
            'member_id' => $mid,
            'nickname' => $member['nickname'],
            'content' => $content,
            'addtime' => date("Y-m-d H:i:s"),
            'isuse' => '0',
            'status' => '1'
        );
        $status = $this->db->insert("u_feekback", $insert_data);
        if ($status)
            $this->__data('反馈已提交');
        else
            $this->__errormsg('反馈失败');
    }

    /**
     * @name：常见问题和解答
     * @author: 温文斌
     * @param: number=凭证；
     * @return:
     *
     */
    public function cfgm_question_list() {
        $page = $this->input->post('page', true);
        $page_size = $this->input->post('pagesize', true);
        $page_size = empty($page_size) ? 6 : $page_size;
        $page = empty($page) ? 1 : $page;
        $from = ($page - 1) * $page_size;

        $sql = "
				select * from u_feekback where isuse=1 and status=1 order by addtime desc
				
			 ";  // 按"未使用"、"已使用"、"已过期"排序
        $sql_page = $sql . " limit {$from},{$page_size} ";

        $reDataArr ['result'] = $this->db->query($sql_page)->result_array();
        if (empty($reDataArr ['result']))
            $this->__data($reDataArr ['result']);
        $reDataArr ['total_rows'] = $this->db->query($sql)->num_rows();
        $reDataArr ['page_size'] = $page_size;
        $reDataArr ['page'] = $page;
        $reDataArr ['total_page'] = ceil($reDataArr ['total_rows'] / $page_size);

        $this->__outmsg($reDataArr);
    }

    /**
     * @name：app是否有版本更新
     * @author: 温文斌
     * @param: number=凭证；
     * @return:
     *
     */
    public function cfgm_version_check() {
        $version = $this->input->post('version', true); //版本号
        //$version = "1.5.7";
        if (empty($version))
            $this->__errormsg('版本号不能为空');
        $row = $this->db->query("select * from cfg_web where id=1")->row_array();
        if (isset($row['app_inner_version'])) {

            if ($row['app_inner_version'] == $version) {
                $this->__errormsg('版本无更新', '-1');
            } else
                $this->__errormsg('版本无更新', '-1');
            //$this->__data(array('url'=>'http://m.1b1u.com/home/download','msg'=>'有新版本更新啦'));
        } else
            $this->__errormsg('版本无更新', '-1');
    }

    /**
     * **********************************      即使导游接口         ******************************************************** */
    public function ____________________________G() {
        
    }

    /**
     * @name：即时导游：景区搜索 
     * @author: 温文斌
     * @param:content=搜索内容
     * @return:经典列表、国家列表
     *
     */
    public function G_scenic_search() {
        $content = $this->input->post("content", true); //搜素内容
        $content = trim($content);
        $content = str_replace("%", "", $content);
        //$content="深圳";
        //if(empty($content)) $this->__errormsg('param missing');
        $output = array();
        $scenic_sql = "select 
     						s.*,a.name as area_name
     			     from	
     						scenic_spot as s
     						left join u_area as a on s.area_id=a.id
     			     where 
     						s.status=1 and s.name like '%{$content}%'
     	           ";
        if (empty($content))
            $scenic_sql.=" limit 100";
        $output['scenic'] = $this->db->query($scenic_sql)->result_array(); //景点


        $city_sql = "select
     							d.*
     				 from
     							u_dest_cfg as d
     							
     				where
     							d.kindname like '%{$content}%'
     				
     	";
        $output['city'] = $this->db->query($city_sql)->result_array(); //城市
        $this->__data($output);
    }

    /**
     * @name：即时导游：景区列表
     * @author: 温文斌
     * @param:country_id=国家id
     * @return:经典列表、国家列表
     *
     */
    public function G_scenic_list() {
        $belong_id = $this->input->post("belong_id", true); //国家id或者城市id
        //$belong_id="15";
        if (!$belong_id)
            $this->__errormsg('belong_id不能为空');
        $output = array();
        $scenic_sql = "select
     						s.*,c.country_id,c.country,a.name as area_name
     				 from
	     					scenic_spot as s
	     					left join scenic_spot_belong as c on c.id=s.belong_id
	     					left join u_area as a on s.area_id=a.id
	     			 where
     						s.status=1 and s.belong_id={$belong_id}
     	             order by 
     	             	    s.displayorder desc
     	";
        $output = $this->db->query($scenic_sql)->result_array(); //景点
        $this->__data($output);
    }

    /**
     * @name：即时导游：景区(浏览次数+1)
     * @author: 温文斌
     * @param:spot_id=景区id
     * @return:
     *
     */
    public function G_scenic_view() {
        $spot_id = $this->input->post("spot_id", true); //景区id
        //$spot_id="5";
        if (!$spot_id || !is_numeric($spot_id))
            $this->__errormsg('景区id不能为空');
        $row = $this->db->query("select views from scenic_spot where id='{$spot_id}'")->row_array();
        $data = array('views' => $row['views'] + 1);
        $this->db->where(array('id' => $spot_id));
        $re = $this->db->update("scenic_spot", $data);
        if ($re)
            $this->__data(array('msg' => 'success'));
        else
            $this->__errormsg('操作异常');
    }

    /**
     * @name：即时导游：对景区点赞
     * @author: 温文斌
     * @param:spot_id=景区id
     * @return:状态
     *
     */
    public function G_scenic_praise() {
        $spot_id = $this->input->post("spot_id", true); //景区id
        $token = $this->input->post('number', true); //token

        $equipment_id = $this->input->post('equipment_id', true); // 设备id (每个设备每天只能点赞一次)
        //$this->check_token ( $token );
        $m_id = $this->F_get_mid($token); //根据token获取mid
        //$m_id="291";
        //$spot_id="405";
        //$equipment_id="190e35f7e0457002de8";
        if (!$spot_id || !is_numeric($spot_id))
            $this->__errormsg('景区id不能为空');
        if (empty($equipment_id))
            $this->__errormsg('设备id不能为空');

        $add_day = date("Y-m-d");
        $spot_detail = $this->db->query("select id,praise from scenic_spot where id={$spot_id}")->row_array();
        $is_praise = $this->db->query("select id from scenic_spot_praise_record where equipment_id='{$equipment_id}' and spot_id={$spot_id} and add_day='{$add_day}'")->row_array();
        if (empty($spot_detail)) {  //评论是否存在
            $this->__errormsg('景区不存在');
        } else {
            if (empty($is_praise)) {  //是否对评论已赞
                $praise_num = $spot_detail['praise'] + 1;

                $this->db->trans_begin(); //事务开启
                $this->db->where(array('id' => $spot_id));
                $status = $this->db->update("scenic_spot", array('praise' => $praise_num));

                $data = array(
                    'member_id' => $m_id,
                    'equipment_id' => $equipment_id,
                    'spot_id' => $spot_id,
                    'addtime' => date("Y-m-d H:i:s"),
                    'add_day' => $add_day
                );
                $result = $this->db->insert("scenic_spot_praise_record", $data); //对评论点赞
                $this->db->trans_complete(); //事务结束
                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    $this->__data($result);  //成功返回数据
                } else {
                    $this->db->trans_rollback(); // 事务回滚
                    $this->__errormsg('操作异常');
                }
            } else {
                $this->__errormsg('您今天对该景点已点过赞！');
            }
        }
    }

    /**
     * @name：即时导游：景区详情
     * @author: 温文斌
     * @param:country_id=国家id
     * @return:经典列表、国家列表
     *
     */
    public function G_scenic_detail() {
        $spot_id = $this->input->post("spot_id", true); //景区id
        $token = $this->input->post('number', true); //token
        $equipment_id = $this->input->post('equipment_id', true); // 设备id (每个设备每天只能点赞一次)

        $m_id = $this->F_get_mid($token); //根据token获取mid
        //$m_id="438"; //438
        if (empty($m_id))
            $m_id = "-1";

        //$spot_id="6"; //418
        //$equipment_id="190e35f7e0457002de8";
        $add_day = date("Y-m-d");
        if (!$spot_id)
            $this->__errormsg('景区id不能为空');
        if (empty($equipment_id))
            $this->__errormsg('设备id不能为空');
        $output = array();
        $scenic_sql = "select s.*,b.city as area_name,(select id from scenic_spot_praise_record where spot_id=s.id and equipment_id='{$equipment_id}' and add_day='{$add_day}') as is_zan from scenic_spot as s left join scenic_spot_belong as b on b.id=s.belong_id left join u_area as a on a.id=s.area_id where s.id={$spot_id}";
        $output = $this->db->query($scenic_sql)->row_array(); //景点
        if (empty($output))
            $this->__errormsg('景点不存在');

        $area_name = $output['area_name']; //景点所在的城市

        $output['pic_arr'] = $this->db->query("select p.scenic_spot_id,p.pic from scenic_spot_pic as p where p.scenic_spot_id={$spot_id} limit 6")->result_array(); //景点图集
        $comment_list = $this->db->query("
     	select 
     			r.*,
     			(select GROUP_CONCAT(pic) from scenic_spot_review_pic where review_id=r.id) as pics,
     			(select type from scenic_spot_review_praise where review_id=r.id and equipment_id='{$equipment_id}' and add_day='{$add_day}') as zan_or_cai
     			
     	from 
     			scenic_spot_review as r 
     			left join u_member as m on m.mid=r.member_id 
     	where 
     			r.scenic_spot_id={$spot_id} and r.pid=0 
     	order by r.praise desc,r.addtime desc limit 20")->result_array(); //景点评论

        $output['comment'] = $comment_list;
        //评论图片处理
        foreach ($output['comment'] as $k => $v) {
            if (!empty($v['pics'])) {
                $v['pic_arr'] = explode(",", $v['pics']);
            } else
                $v['pic_arr'] = "";
            $v['pic_arr'] = $this->__doImage($v['pic_arr']); //对图片进行处理

            $output['comment'][$k] = $v;
        }
        //景点的所有图片
        $area_img = $this->db->query("
     		select jdp.pic
				from scenic_spot as jd left join scenic_spot_pic as jdp on jd.id=jdp.scenic_spot_id where jd.id={$spot_id}   		
     	")->result_array();
        //评论的所有图片
        $com_img = $this->db->query("
     		select 
     			rp.pic
     		from scenic_spot_review as r left join  scenic_spot_review_pic as rp on rp.review_id = r.id
     		where r.scenic_spot_id={$spot_id} and r.pid=0 
     		
     	")->result_array();
        $output['area_img'] = $area_img;
        $output['com_img'] = $com_img;

        $area_img_num = $this->db->query("
     		select jdp.pic
				from scenic_spot as jd left join scenic_spot_pic as jdp on jd.id=jdp.scenic_spot_id where jd.id={$spot_id}   		
     	")->num_rows();
        $com_img_num = $this->db->query("
     		select 
     			rp.pic
     		from scenic_spot_review as r left join  scenic_spot_review_pic as rp on rp.review_id = r.id
     		where r.scenic_spot_id={$spot_id} and r.pid=0 
     		
     	")->num_rows();
        $output['img_total_num'] = $area_img_num + $com_img_num;
        //
        $output['comment_total_row'] = $this->db->query("
     			select 
     					r.*,m.litpic,
     					(select id from scenic_spot_review_praise where review_id=r.id and member_id={$m_id}) as is_zan 
     			from 
     					scenic_spot_review as r 
     					left join u_member as m on m.mid=r.member_id 
     			where 
     					r.scenic_spot_id={$spot_id} and r.pid=0 order by r.addtime desc")->num_rows(); //景点评论
        //景区是否有"定位"字段；默认5公里，当周边景区不足4个，就放松条件到10、20公里，直到凑到4个景区
        $legnth = "5"; //5公里范围

        if (empty($output['geohash'])) {
            $output['spot_zb'] = array();
        } else {
            $geohash = substr($output['geohash'], 0, $legnth); //5公里范围
            $output['spot_zb'] = $this->F_scenic_zb($geohash, $limit = "4", $output['id']); //$geohash 5公里范围，$output['geohash'] 不包括当前景区
            $output['spot_zb'] = $this->geohash_sort($output['latitude'], $output['longitude'], $output['spot_zb']);  //对周边景点从近到远排序
        }

        $need_num = 4 - count($output['spot_zb']); //还差n个景区

        $add = array();  //附近放开条件后的周边
        $add2 = array(); //还需取$need_num个景点
        if ($need_num > 0) {
            $not_in = $output['id'] . ",";
            foreach ($output['spot_zb'] as $k => $v) {
                $not_in.=$v['id'] . ",";
            }
            $not_in = substr($not_in, 0, -1);  //需去除的景点

            $geohash = substr($output['geohash'], 0, 4); //将距离放大至4位
            $zb4 = $this->F_scenic_zb($geohash, $limit = "100", $not_in, array('belong_id' => $output['belong_id'])); //$geohash 20公里范围，不包括“已符合”的景区
            $zb4 = $this->geohash_sort($output['latitude'], $output['longitude'], $zb4);  //对周边景点从近到远排序

            $zb3 = array();
            if (count($zb4) < $need_num) {
                $geohash2 = substr($output['geohash'], 0, 3); //将距离放大至3位

                $zb3 = $this->F_scenic_zb($geohash2, $limit = "100", $not_in, array('belong_id' => $output['belong_id'])); //$geohash 78公里范围，不包括“已符合”的景区
                $zb3 = $this->geohash_sort($output['latitude'], $output['longitude'], $zb4);  //对周边景点从近到远排序
            }
            $add = array_merge($zb4, $zb3);  //合并
            $add = $this->mult_unique($add);
            //取$need_num个景点
            if (!empty($add)) {
                for ($i = 0; $i <= count($add) - 1; $i++) {
                    if ($i <= $need_num - 1)
                        $add2[] = $add[$i];
                }
            }
            //var_dump($not_in);var_dump($add2);
        }
        $output['spot_zb'] = array_merge($output['spot_zb'], $add2);

        //推荐线路
        //$area_name=mb_substr($area_name, 0, -1);
        if (empty($area_name))
            $area_name = "深圳";

        $destinations = $this->db->query("select id,pid from u_dest_cfg where kindname like '%{$area_name}%'")->row_array();
        //var_dump($destinations['id']);
        if (!empty($destinations)) {
            $sql = "
     				select 
	     					l.id,l.linename,lineprice,l.satisfyscore,l.peoplecount,l.comment_count,l.mainpic,l.overcity
	     			    
	     			from 
	     					u_line as l
	     			where status=2 and (FIND_IN_SET({$destinations['id']},l.overcity)>0)
	     			order by ordertime desc 
     			 ";
            $sql_page = $sql . " limit 6";
            $output['recommend'] = $this->db->query($sql_page)->result_array();
            $total_nums = $this->db->query($sql)->num_rows();
            $output['recommend_pages'] = ceil($total_nums / 6);

            if (empty($output['recommend'])) {
                $sql = "
	     		select
	     				l.id,l.linename,lineprice,l.satisfyscore,l.peoplecount,l.comment_count,l.mainpic,l.overcity
	     			
	     		from
	     				u_line as l
	     		where
	     				 status=2 and (FIND_IN_SET({$destinations['pid']},l.overcity)>0)
	     		order by ordertime desc
	     		";
                $sql_page = $sql . " limit 6";
                $output['recommend'] = $this->db->query($sql_page)->result_array();
                $total_nums = $this->db->query($sql)->num_rows();
                $output['recommend_pages'] = ceil($total_nums / 6);
            }
        } else {
            $output['recommend'] = array();
        }


        foreach ($output['recommend'] as $key => $value) {  //满意度处理
            //$value['satisfyscore']=(round($value['satisfyscore'],2)*100).'%';
            $value['satisfyscore'] = (round($value['satisfyscore'], 2) * 100);

            $output['recommend'][$key] = $value;
        }
        $this->__data($output);
    }

    /**
     * @name：即时导游：更多推荐
     * @author: 温文斌
     * @param: spot_id=景区id,page=当前页数
     * @return:经典列表、国家列表
     *
     */
    public function G_more_recommend() {
        $spot_id = $this->input->post("spot_id", true); //景区id
        $page = $this->input->post('page', true); //页数
        //$spot_id="418"; //418
        //$page="2";
        if (!$spot_id)
            $this->__errormsg('景区id不能为空');

        $scenic_sql = "select s.*,b.city as area_name from scenic_spot as s left join scenic_spot_belong as b on b.id=s.belong_id left join u_area as a on a.id=s.area_id where s.id={$spot_id}";
        $spot = $this->db->query($scenic_sql)->row_array(); //景点
        if (empty($spot))
            $this->__errormsg('景点不存在');
        $area_name = $spot['area_name']; //景点所在的城市
        //分页数据
        $page_size = "6";
        if (!$page)
            $page = "1"; //默认第一页
        $from = ($page - 1) * $page_size;

        $output = array();
        $destinations = $this->db->query("select id,pid from u_dest_cfg where kindname like '%{$area_name}%'")->row_array();
        if (!empty($destinations)) {
            $sql = "select 
			     					l.id,l.linename,lineprice,l.satisfyscore,l.peoplecount,l.comment_count,l.mainpic,l.overcity
			     			    
			     			from 
			     					u_line as l
			     			where status=2 and (FIND_IN_SET({$destinations['id']},l.overcity)>0)
			     			order by ordertime desc";  //三级目的地下推荐线路
            $total_nums = $this->db->query($sql)->num_rows(); //线路总数

            if ($total_nums == "0") {
                $sql = "select
		     					 l.id,l.linename,lineprice,l.satisfyscore,l.peoplecount,l.comment_count,l.mainpic,l.overcity
		     			
		     		      from
		     					 u_line as l
		     			  where 
		     					status=2 and (FIND_IN_SET({$destinations['pid']},l.overcity)>0)
		     		      order by ordertime desc";  //二级目的地下推荐线路
                $total_nums = $this->db->query($sql)->num_rows(); //线路总数
            }
            $sql_page = $sql . " limit {$from},{$page_size}";
            $result = $this->db->query($sql_page)->result_array(); //线路
        } else {
            $total_nums = 0;
            $result = array();
        }

        $sql_page = $sql . " limit {$from},{$page_size}";
        $output['page'] = $page;
        $output['page_size'] = $page_size;
        $output['total_rows'] = $total_nums;
        $total_page = ceil($total_nums / $page_size);
        $output['total_page'] = $total_page;
        $output['result'] = $result;

        $this->__data($output);
    }

    /**
     * @name：即时导游：更多评价
     * @author: 温文斌
     * @param: spot_id=景区id,page=当前页数
     * @return:经典列表、国家列表
     *
     */
    public function G_more_comment() {
        //传值
        $spot_id = $this->input->post("spot_id", true); //景区id
        $page = $this->input->post("page", true);
        $token = $this->input->post('number', true); //token

        $equipment_id = $this->input->post('equipment_id', true); // 设备id (每个设备每天只能点赞一次)
        //$spot_id="416";
        //$equipment_id="190e35f7e0457002de8";
        $m_id = $this->F_get_mid($token); //根据token获取mid
        //分页数据
        $page_size = "20";
        if (!$page)
            $page = "1"; //默认第一页
        $from = ($page - 1) * $page_size;

        //$spot_id="6";
        if (!$spot_id)
            $this->__errormsg('景区id不能为空');
        if (empty($equipment_id))
            $this->__errormsg('设备id不能为空');
        $output = array();
        $add_day = date("Y-m-d");
        $total_nums = $this->db->query("select r.* from scenic_spot_review as r where r.scenic_spot_id={$spot_id} and r.pid=0")->num_rows(); //景点评论
        $output['page'] = $page;
        $output['page_size'] = $page_size;
        $output['total_rows'] = $total_nums;
        $total_page = ceil($total_nums / $page_size);
        $output['total_page'] = $total_page;

        $comment_list = $this->db->query("
     		select 
     				r.*,
     				(select GROUP_CONCAT(pic) from scenic_spot_review_pic where review_id=r.id) as pics,
     				(select type from scenic_spot_review_praise where review_id=r.id and equipment_id='{$equipment_id}' and add_day='{$add_day}') as zan_or_cai
     				
     		from 
     				scenic_spot_review as r 
     				left join u_member as m on m.mid=r.member_id 
     		where 
     				r.scenic_spot_id={$spot_id} and r.pid=0 
     		order by 
     				r.praise desc,r.addtime desc limit {$from},{$page_size}")->result_array(); //景点评论
        foreach ($comment_list as $k => $v) {
            if (!empty($v['pics']))
                $v['pic_arr'] = explode(",", $v['pics']);
            else
                $v['pic_arr'] = "";
            $v['pic_arr'] = $this->__doImage($v['pic_arr']); //对图片进行处理

            $comment_list[$k] = $v;
        }
        $output['result'] = $comment_list;

        $this->__data($output);
    }

    /**
     * @name：即时导游：发表评论
     * @author: 温文斌
     * @param:content=评论内容;number=token；
     * @return:状态
     *
     */
    public function G_add_comment() {
        $spot_id = $this->input->post("spot_id", true); //景区id
        $content = $this->input->post("content", true); //评价内容
        $pic = $this->input->post("pic", true); //评价图片
        $token = $this->input->post('number', true); //token
        //$content="非常的6";
        //$spot_id="5";
        //$pic="/file/scenicSpot/28072/81694.jpeg,/file/scenicSpot/28072/65000.jpeg";
        //$this->check_token ( $token );
        $m_id = $this->F_get_mid($token); //根据token获取mid
        //$m_id="291";
        if (empty($spot_id))
            $this->__errormsg('景点id不能为空');
        if (empty($content))
            $this->__errormsg('评论内容不能为空');
        $one = $this->db->query("select * from scenic_spot where id='{$spot_id}'")->row_array();
        if (empty($one))
            $this->__errormsg('景点不存在');

        $nickname = "游客";
        $litpic = "/file/c/img/face.png";
        $user = $this->db->query("select nickname,litpic from u_member where mid={$m_id}")->row_array();
        if (!empty($user)) {
            $nickname = $user['nickname'];
            $litpic = $user['litpic'];
        }

        $this->db->trans_begin(); //事务开启
        //发表评论
        $data = array(
            'scenic_spot_id' => $spot_id,
            'member_id' => $m_id,
            'nickname' => $nickname,
            'content' => $content,
            'pic' => $pic,
            'litpic' => $litpic,
            'addtime' => date("Y-m-d H:i:s")
        );
        $result = $this->db->insert("scenic_spot_review", $data);
        $id = $this->db->insert_id();   //评论的id
        $output = $data;
        $output['id'] = $id; //评论的id

        unset($output['pic']);
        $pic = substr($pic, 0, -1);
        $pic_arr = explode(",", $pic);
        foreach ($pic_arr as $k => $v) {
            $pic_data = array('review_id' => $id, 'pic' => $v, 'isDownLoad' => 'N');
            $this->db->insert("scenic_spot_review_pic", $pic_data);
        }
        $pic_arr = $this->__doImage($pic_arr);
        $output['pic_arr'] = $pic_arr;
        //景区评论数+1

        $comment_num = $one['comment_count'] + 1;
        $this->db->where(array('id' => $spot_id));
        $this->db->update("scenic_spot", array('comment_count' => $comment_num));

        $this->db->trans_complete(); //事务结束
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $this->__data($output);
        } else {
            $this->db->trans_rollback(); // 事务回滚
            $this->__errormsg('操作异常');
        }
    }

    /**
     * @name：即时导游：回复评论
     * @author: 温文斌
     * @param:content=评论内容;number=token；
     * @return:状态
     *
     */
    public function G_to_answer() {
        $comment_id = $this->input->post("comment_id", true); //评论id
        $spot_id = $this->input->post("spot_id", true); //评论id
        $content = $this->input->post("content", true); //评价内容
        $token = $this->input->post('number', true); //token
        //$content="我回复123了";
        //$spot_id="6";
        //$comment_id="49";
        $this->check_token($token);
        $m_id = $this->F_get_mid($token); //根据token获取mid
        //$m_id="291";
        if (!$content || !$spot_id || !$comment_id)
            $this->__errormsg('param missing');

        $user = $this->db->query("select nickname,litpic from u_member where mid={$m_id}")->row_array();
        $one_comment = $this->db->query("select nickname,pid,reply_id from scenic_spot_review where id={$comment_id}")->row_array();
        if ($one_comment['pid'] == "0") { //若是一级评论
            $reply_id = $pid = $comment_id;
        } else {
            $pid = $one_comment['pid'];
            $reply_id = $comment_id;
        }
        //发表评论
        $data = array(
            'scenic_spot_id' => $spot_id,
            'member_id' => $m_id,
            'nickname' => $user['nickname'],
            'content' => $content,
            'pid' => $pid,
            'reply_id' => $reply_id,
            'addtime' => date("Y-m-d H:i:s")
        );
        $result = $this->db->insert("scenic_spot_review", $data);
        $id = $this->db->insert_id();   //评论的id
        $output = $data;
        $output['litpic'] = $user['litpic'];
        $output['id'] = $id; //评论的id
        $output['reply_to'] = $one_comment['nickname'];
        if ($result)
            $this->__data($output);
        else
            $this->__errormsg('操作异常');
    }

    /**
     * @name：即时导游：对评论点赞
     * @author: 温文斌
     * @param:content=评论内容;number=token；
     * @return:状态
     *
     */
    public function G_to_praise() {
        $comment_id = $this->input->post("comment_id", true); //评论id
        $flag = $this->input->post("flag", true);    // 标识：用于区分是点赞还是点踩，1是赞，0是踩
        $token = $this->input->post('number', true); //token

        $equipment_id = $this->input->post('equipment_id', true); // 设备id (每个设备每天只能点赞一次)
        //$this->check_token ( $token );
        $m_id = $this->F_get_mid($token); //根据token获取mid
        //$m_id="291";
        //$comment_id="4";
        //$flag="1";
        //$equipment_id="123456789";
        if (!$comment_id)
            $this->__errormsg('评论id不能为空');
        if ($flag != "0" && $flag != "1")
            $this->__errormsg('参数flag缺失');
        if (empty($equipment_id))
            $this->__errormsg('设备id不能为空');

        $add_day = date("Y-m-d");
        $comment_detail = $this->db->query("select id,praise,down from scenic_spot_review where id={$comment_id}")->row_array();
        $is_praise = $this->db->query("select id from scenic_spot_review_praise where equipment_id='{$equipment_id}' and review_id={$comment_id} and add_day='{$add_day}'")->row_array();
        if (empty($comment_detail)) {  //评论是否存在
            $this->__errormsg('评论不存在');
        } else {
            if (empty($is_praise)) {  //是否对评论已赞
                $praise_num = $comment_detail['praise'] + 1;
                $down = $comment_detail['down'] + 1;

                $this->db->trans_begin(); //事务开启
                $this->db->where(array('id' => $comment_id));
                if ($flag == "1")
                    $status = $this->db->update("scenic_spot_review", array('praise' => $praise_num));
                else
                    $status = $this->db->update("scenic_spot_review", array('down' => $down));

                $data = array(
                    'member_id' => $m_id,
                    'equipment_id' => $equipment_id,
                    'review_id' => $comment_id,
                    'type' => $flag,
                    'addtime' => date("Y-m-d H:i:s"),
                    'add_day' => $add_day
                );
                $result = $this->db->insert("scenic_spot_review_praise", $data); //对评论点赞
                $this->db->trans_complete(); //事务结束
                if ($this->db->trans_status() === TRUE) {
                    $this->db->trans_commit();
                    $this->__data($result);  //成功返回数据
                } else {
                    $this->db->trans_rollback(); // 事务回滚
                    $this->__errormsg('操作异常');
                }
            } else {
                $this->__errormsg('你今天已经对该评论点过赞或者点过踩');
            }
        }
    }

    /**
     * @name：即时导游导航页 => 一、二、三级目的地（国内、境外）
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function G_destinations_m() {
        $cityid = $this->input->post("cityid", true);  //用于获取周边游
        //$cityid="235"; //现在默认是深圳周边
        if (!$cityid)
            $this->__errormsg('城市id传入有误');


        $reDataArr = array();
        // 国际ID
        $internalId = 1;
        $sql_inter_2 = "select * FROM  u_dest_cfg where  pid={$internalId}  order by pid asc ";
        $inter_citys_2 = $this->db->query($sql_inter_2)->result_array();
        $sql_inter_3 = "select * FROM  u_dest_cfg where  level=3  order by pid asc ";
        $inter_citys_3 = $this->db->query($sql_inter_3)->result_array();
        $inter_city = array();
        $inter_cityTab = array();
        foreach ($inter_citys_2 as $key => $val) {
            $inter_city ['id'] = $val ['id'];
            $inter_city ['name'] = $val ['kindname'];
            $inter_city ['childs'] = array();
            foreach ($inter_citys_3 as $k => $v) {
                if ($v ['pid'] == $val ['id']) {
                    $inter_city ['childs'] [] = array(
                        'id' => $v ['id'],
                        'name' => $v ['kindname'],
                        'pic' => $v ['pic']
                    );
                }
            }
            $inter_cityTab [] = $inter_city;
        }
        $reDataArr ['jw'] = $inter_cityTab;

        // 国内ID
        $domesticId = 2;
        $sql_dome_2 = "select * FROM  u_dest_cfg where  pid={$domesticId}  order by pid asc ";
        $dome_citys_2 = $this->db->query($sql_dome_2)->result_array();
        $sql_dome_3 = "select * FROM  u_dest_cfg where  level=3  order by pid asc ";
        $dome_citys_3 = $this->db->query($sql_dome_3)->result_array();
        $dome_city = array();
        $dome_cityTab = array();
        foreach ($dome_citys_2 as $key => $val) {
            $dome_city ['id'] = $val ['id'];
            $dome_city ['name'] = $val ['kindname'];
            $dome_city ['childs'] = array();
            foreach ($dome_citys_3 as $k => $v) {
                if ($v ['pid'] == $val ['id']) {
                    $dome_city ['childs'] [] = array(
                        'id' => $v ['id'],
                        'name' => $v ['kindname'],
                        'pic' => $v ['pic']
                    );
                }
            }
            $dome_cityTab [] = $dome_city;
        }
        $reDataArr ['gn'] = $dome_cityTab;

        //周边游
        $sql_zb = "select neighbor_id as id,d.pic as pic,d.kindname as name FROM  cfg_round_trip as t left join u_dest_cfg as d on d.id=t.neighbor_id where  t.isopen=1 and d.isopen=1 and startplaceid='{$cityid}' order by t.id desc";
        $zb = $this->db->query($sql_zb)->result_array();

        //当前城市的 area_id 转化为 dest_id
        $area = $this->db->query("select name from u_area where id='{$cityid}'")->row_array();
        $area_name = mb_substr($area['name'], 0, -1);
        $dest = $this->db->query("select id,kindname as name from u_dest_cfg where kindname like '%{$area_name}%'")->row_array();
        if (empty($zb)) {
            $zb[] = array('id' => $dest['id'], 'name' => $area['name']);
        }
        $zb_two_menu = array('id' => $cityid, 'name' => "周边", 'childs' => $zb);
        $zb_arr[] = $zb_two_menu;
        $reDataArr ['zb'] = $zb_arr;

        //推荐的9个景区
        $scenic_sql = "select
     						s.id,s.name,s.city_id,mainpic,d.kindname
     				 from
     						scenic_spot as s
     						left join u_dest_cfg as d on s.city_id=d.id
     				where
     						s.status=1 and s.city_id='{$dest['id']}'
     				order by
     						s.praise desc limit 12
     	";
        $reDataArr['spot_list'] = $this->db->query($scenic_sql)->result_array(); //景点
        $this->__outmsg($reDataArr);
    }

    /**
     * @name：即时导游 => 一、二、三级目的地（国内、境外）
     * @author: 温文斌
     * @param:
     * @return:
     *
     */
    public function G_nine_dest() {
        $dest_id = $this->input->post("dest_id", true);  //目的地id
        $page = $this->input->post("page", true); //页数
        $page_size = "20";
        if (!$page)
            $page = "1"; //默认第一页
        $from = ($page - 1) * $page_size;
        //$dest_id="10433";
        if (!$dest_id)
            $this->__errormsg('目的地id传入有误');


        //目的地对应的9个景区
        $scenic_sql = "select
     						s.id,s.city_id,s.name,s.comment_count,s.description,mainpic,d.kindname, (SELECT c.content FROM scenic_spot_review AS c WHERE c.scenic_spot_id=s.id ORDER BY praise desc LIMIT 1) as comment,
                            d.pic as dest_pic
     				 from
     						scenic_spot as s
     						left join u_dest_cfg as d on s.city_id=d.id
     				where
     						s.status=1 and s.city_id='{$dest_id}'
     				order by
     						s.praise desc 
     	";
        $sql_page = $scenic_sql . " limit {$from},{$page_size}";
        $reDataArr['rows'] = $this->db->query($sql_page)->result_array(); //景点
        $total_nums = $this->db->query($scenic_sql)->num_rows(); //景点
        $reDataArr['page'] = $page;
        $reDataArr['page_size'] = $page_size;
        $reDataArr['total_rows'] = $total_nums;
        $total_page = ceil($total_nums / $page_size);
        $reDataArr['total_page'] = $total_page;

        //景区封面

        $reDataArr['dest_pic'] = isset($reDataArr['rows'][0]['dest_pic']) == true ? $reDataArr['rows'][0]['dest_pic'] : '';
        $reDataArr['dest_pic'] = $this->__doImage($reDataArr['dest_pic']);
        $this->__data($reDataArr);
    }

    /**
     * @name：即时导游 =>定位显示当前目的地景点
     * @author: 陈新亮
     * @param:
     * @return:
     *
     */
    public function G_nine_dest_id() {
        $area_name = $this->input->post("area_name", true);  //目的地id
        //$area_name="深圳";
        if (!$area_name)
            $this->__errormsg('目的地传入有误');


        //目的地对应的9个景区
        $scenic_sql = "select
     						d.id 
     						
     				 from
     						u_dest_cfg as d
     				where
     						d.kindname='{$area_name}'
     	";
        $reDataArr['rows'] = $this->db->query($scenic_sql)->result_array(); //景点
        $total_nums = $this->db->query($scenic_sql)->num_rows(); //景点
        $reDataArr['total_rows'] = $total_nums;
        $this->__data($reDataArr);
    }

    /**
     * @name：多维数组去重
     * @author: 温文斌
     * @param:array
     * @param:array
     *
     */
    protected function mult_unique($array) {
        $return = array();
        foreach ($array as $key => $v) {
            if (!in_array($v, $return)) {
                $return[$key] = $v;
            }
        }
        return $return;
    }

    /**
     * @name：即时导游：地图移动时景区搜索 （周边5公里）
     * @author: 温文斌
     * @param:$geohash=景区范围；$not_in=不包括的景区 ，如  12342,12541
     * @return:经典列表、国家列表
     *
     */
    protected function F_scenic_zb($geohash, $limit = "5", $not_in = "", $con = array()) {
        //发送curl
        $post_url = base_url('geohash/cfg_nine_geohash_two');
        $post_data = array('geohash' => $geohash);
        $curl_data = $this->curl($post_url, $post_data);

        $geohash_arr = isset($curl_data['data']['rows']) ? $curl_data['data']['rows'] : array();  //周围9个点区域,若没有
        //周边景区
        $output = array();
        $where = "";
        if (!empty($geohash_arr)) {
            $where = "and (      s.geohash like '%{$geohash_arr[0]}%'
     							or s.geohash like '%{$geohash_arr[1]}%'
     							or s.geohash like '%{$geohash_arr[2]}%'
     							or s.geohash like '%{$geohash_arr[3]}%'
     							or s.geohash like '%{$geohash_arr[4]}%'
     							or s.geohash like '%{$geohash_arr[5]}%'
     							or s.geohash like '%{$geohash_arr[6]}%'
     							or s.geohash like '%{$geohash_arr[7]}%'
    						 	or s.geohash like '%{$geohash_arr[8]}%'
     				)";
        }

        //where条件
        if (isset($con['belong_id']))
            $where.=" and s.belong_id='{$con['belong_id']}'";

        $scenic_sql = "select
     						s.id,s.name,s.mainpic,s.comment_count,s.money,s.praise,s.geohash,s.longitude,s.latitude,
     						(select count(1) as comment_total_row from scenic_spot_review where scenic_spot_id=s.id) as comment_total_row,
     						(select content from scenic_spot_review where scenic_spot_id=s.id order by praise desc limit 1) as big_comment
     				from
     						scenic_spot as s
     				where
     						 s.status=1 {$where}";
        if ($not_in != "")
            $scenic_sql.=" and s.id not in ({$not_in})";
        $scenic_sql .= " order by id desc limit {$limit}";
        $output = $this->db->query($scenic_sql)->result_array(); //景点

        return $output;
    }

    /**
     * @name：即时导游：地图移动时景区搜索 （周边5公里）
     * @author: 温文斌
     * @param:lat=纬度;lng=经度；
     * @return:经典列表、国家列表
     *
     */
    public function G_scenic_zb() {
        $lat = $this->input->post("lat", true); //维度
        $lng = $this->input->post("lng", true); //经度
        $length = $this->input->post("length", true); //长度
        //$lng="114.070908";
        //$lat="22.546162";

        if (!$lat || !$lng)
            $this->__errormsg('经度和维度不能为空');
        if (!$length)
            $length = "5"; //没有值，则默认精确到5公里














            
//发送curl  
        $post_url = base_url('geohash/cfg_geohash');
        $post_data = array('lat' => $lat, 'lng' => $lng, 'length' => $length);
        $curl_data = $this->curl($post_url, $post_data);
        $geohash = $curl_data['data'];  //geohash字符
        //周边景区
        $output = $this->F_scenic_zb($geohash, $limit = "1000");  // $limit 不做限制
        $output = $this->geohash_sort($lat, $lng, $output);  //对周边景点从近到远排序
        $this->__data($output);
    }

    /**
     * @name：目的地和管家推荐
     * @author: 魏勇
     * @param: content=搜索内容；
     *
     * @return:
     *
     */
    public function cfgm_home_recommend() {
        $content = $this->input->get_post('content', true); //搜索内容
        $cityid = $this->input->post("cityid", true); //当前城市
        if (empty($cityid)) {
            $cityid = $this->default_cityid; //默认城市深圳
        }
        //1、目的地//and d.kindname like '%{$content}%'
//        $dest_sql = "select
//							d.id,d.kindname
//					 from   cfgm_hot_dest AS h   LEFT JOIN
//							u_dest_cfg as d ON d.id = h.id
//				     where
//							d.isopen=1  order by h.showorder desc, h.linenum DESC limit 11";  // 将by id改为by displayorder
        //$dest_sql = "SELECT * FROM cfgm_hot_dest WHERE startplaceid = $cityid OR startplaceid in (SELECT startplace_child_id FROM u_startplace_child WHERE startplace_id = $cityid) OR startplaceid = 391 ORDER BY showorder DESC, linenum DESC LIMIT 11";
        $dest_sql = "SELECT * FROM cfgm_hot_dest";
        $dest_query = $this->db->query($dest_sql);
        $out['dest'] = $dest_query->result_array();
        //2、管家
//        $expert_sql = "select
//						id,nickname, big_photo, small_photo
//			    from
//					    u_expert    
//		        where
//						status=2 and nickname like '%{$content}%' order by addtime desc limit 5";
        $expert_sql = "SELECT e.id, e.nickname, e.big_photo, e.small_photo, e.m_bgpic FROM cfgm_hot_expert AS h JOIN u_expert AS e on h.expert_id = e.id where e.nickname like '%{$content}%' and e.city={$cityid} ORDER BY h.showorder DESC, e.order_count DESC limit 5";

        $expert_query = $this->db->query($expert_sql);
        $out['expert'] = $expert_query->result_array();

        if (empty($out['expert']) && empty($out['dest']))
            $this->__nullmsg();
        else
            $this->__outmsg($out);
    }

    /**
     * @name 线路首页搜索
     * @author 魏勇
     * @param string type  0 精选，1 国内，2 出境， 3 周边
     * 请求方式 post
     */
    public function line_home_search() {
        $type = $this->input->get_post('type', true);           // TODO 改为post
        $cityid = $this->input->get_post('cityid', true); //定位城市
        if ('' == $cityid) {
            $this->__errormsg('cityid is null');
            //$cityid = "235";
        }
        // 类型默认是周边
        if ('' == $type) {
            $type = 3;
        }

        $reDataArr = array();
        $roll_pic_sql = "select id,name,pic,showorder from cfgm_index_roll_pic where is_show=1 order by showorder desc";
        //$reDataArr ['roll_pic'] = $this->db->query($roll_pic_sql)->result_array();        // 暂时注释
        //$dest_sql = "select cd.dest_id as id,cd.dest_type,ud.kindname as destname,cd.name as description,cd.pic as pic,cd.linenum as num from cfgm_hot_dest as cd left join u_dest_cfg as ud on ud.id=cd.dest_id 	left join cfg_index_kind as cik on cik.id=cd.dest_type 		where cd.is_show='1' ";
        $dest_sql = "select cd.startplaceid as start_id, cd.dest_id as id,cd.dest_type,ud.kindname as destname,cd.name as description,cd.pic as pic,cd.linenum as num from cfgm_hot_dest as cd left join u_dest_cfg as ud on ud.id=cd.dest_id 	left join cfg_index_kind as cik on cik.id=cd.dest_type 		where cd.is_show='1' ";
        $time = date("Y-m-d"); // 依据现阶段时间迭代
        $line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname   	FROM  	cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id  left join cfg_index_kind as cik on cik.id=cx.dest_type left join u_expert as e on e.id=l.recommend_expert where l.status='2' and cx.startplaceid = $cityid and cx.is_show=1 and cx.starttime<='{$time}' and cx.endtime>='{$time}'";
        /* $line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname   	
          FROM
          cfgm_hot_line AS cx
          RIGHT JOIN
          u_line AS l ON cx.line_id=l.id
          left join
          u_expert as e on e.id=l.recommend_expert where l.status='2'  and cx.is_show=1 ";
         */
        $page = intval($this->input->get_post("page"));                       //当前页
        $page_size = intval($this->input->get_post('pagesize', true));  //每页显示记录数
        //2、分页变量
        $page = empty($page) ? 1 : $page;
        if ($page < 0) {
            $this->__errormsg('page must be not less than 0');
        }
        $page_size = empty($page_size) ? 6 : $page_size;
        $from = ($page - 1) * $page_size; //from
        // 当page为1时,获取轮播图,热门目的地,周边线路
        if (1 === $page) {
            $roll_pic_sql = "SELECT * FROM cfgm_index_roll_pic WHERE kind =2 AND status = 1 AND is_show = 1 ORDER BY showorder DESC";
            $reDataArr['role_pic'] = $this->db->query($roll_pic_sql)->result_array();
//            $hot_dest_sql = $dest_sql . " order by cd.showorder limit {$page_size}";
//            $reDataArr['hot_dest'] = $this->db->query($hot_dest_sql)->result_array();
            switch ($type) {
                case 0:
                    $arr_curr_city_dest = array();
                    $arr_other_city_dest = array();
                    //$hot_dest_sql = $dest_sql . " and cd.startplaceid={$cityid} order by cd.showorder DESC, ud.line_num DESC limit {$page_size}";
                    $hot_dest_sql = $dest_sql . "  order by cd.showorder DESC, ud.line_num DESC ";
                    $reDataArr['destList'] = $this->db->query($hot_dest_sql)->result_array();
                    foreach ($reDataArr['destList'] as $key => $val) {
                        if ($val['start_id'] === $cityid) {
                            array_push($arr_curr_city_dest, $val);
                        } else {
                            array_push($arr_other_city_dest, $val);
                        }
                    }
                    $reDataArr['destList'] = array_merge($arr_curr_city_dest, $arr_other_city_dest);
                    break;

                case 1:
                    $guonei_dest_sql = $dest_sql . " and cd.dest_type=2 and cd.startplaceid={$cityid} order by cd.showorder desc, ud.line_num DESC limit {$from},{$page_size}";
                    $reDataArr['destList'] = $this->db->query($guonei_dest_sql)->result_array();
                    break;

                case 2:
                    $chujing_dest_sql = $dest_sql . " and cd.dest_type=1 and cd.startplaceid={$cityid} order by cd.showorder desc, ud.line_num DESC limit {$from},{$page_size}";
                    $reDataArr['destList'] = $this->db->query($chujing_dest_sql)->result_array();
                    break;

                case 3:
                    $zhoubian_dest_sql = $dest_sql . " and cd.dest_type=3 and cd.startplaceid={$cityid} order by cd.showorder desc, ud.line_num DESC limit {$from},{$page_size}";
                    $reDataArr['destList'] = $this->db->query($zhoubian_dest_sql)->result_array();
                    break;

                default:
                    $this->__errormsg('type is wrong');
                    break;
            }
        }
        switch ($type) {
            case 0:
                // 热门线路和热门目的地
//                $line_hot_sql = $line_sql . " order by cx.id desc limit {$from},{$page_size}";
                //$dest_hot_sql = $dest_sql . ' order by cd.showorder limit 6';
                $line_hot_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id
                    FROM cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id 
                    where l.status='2' and cx.startplaceid = {$cityid} and cx.is_show=1 order by cx.showorder desc limit 6 ";
                $reDataArr['lineList'] = $this->db->query($line_hot_sql)->result_array();
                //$reDataArr['dest'] = $this->db->query($dest_hot_sql)->result_array();
                break;

            case 1:
                // 国内线路和国内目的地
//                $line_guonei_sql = $line_sql . " and cx.dest_type=2 order by cx.showorder limit {$from},{$page_size}";
                //$dest_guonei_sql = $dest_sql . ' and cd.dest_type=2 order by cd.id desc';
                $line_guonei_sql = "(SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id
                    FROM  	cfgm_hot_line AS cx 
                    LEFT JOIN u_line AS l ON cx.line_id=l.id where cx.dest_type = 2 AND l.status = 2 AND l.producttype=0 AND l.line_kind = 1 AND l.startcity={$cityid} order by l.displayorder DESC, l.bookcount DESC)
                    union
                    (select ul.id as id, ul.line_classify as dest_type, ul.mainpic as pic, ul.linetitle as linetitle, ul.linename as linename, ul.satisfyscore, ul.bookcount,ul.peoplecount, ul.comment_count, ul.lineprice,ul.saveprice,ul.recommend_expert as expert_id
                    from u_line AS ul 
                    left join u_line_dest AS uld ON ul.id = uld.line_id
                    left join u_dest_cfg AS ud ON ud.id = uld.dest_id where ud.id = 2 and ul.status = 2 AND ul.producttype = 0 AND ul.line_kind = 1 order by ul.displayorder DESC, ul.bookcount DESC) limit {$from}, {$page_size}";
                $reDataArr['lineList'] = $this->db->query($line_guonei_sql)->result_array();
                //$reDataArr['dest'] = $this->db->query($dest_guonei_sql)->result_array();
                break;

            case 2:
                // 出境线路和目的地
//                $line_chujing_sql = $line_sql . " and cx.dest_type=1 order by cx.showorder limit {$from},{$page_size}";
                //$dest_chujing_sql = $dest_sql . ' and cd.dest_type=1 order by cd.id desc';
                $line_chujing_sql = "(SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id
                    FROM  	cfgm_hot_line AS cx 
                    LEFT JOIN u_line AS l ON cx.line_id=l.id where cx.dest_type = 1 AND l.status = 2 AND l.producttype=0 AND l.line_kind = 1 AND  l.startcity={$cityid} order by l.displayorder DESC, l.bookcount DESC)
                    union
                    (select ul.id as id, ul.line_classify as dest_type, ul.mainpic as pic, ul.linetitle as linetitle, ul.linename as linename, ul.satisfyscore, ul.bookcount,ul.peoplecount, ul.comment_count, ul.lineprice,ul.saveprice,ul.recommend_expert as expert_id
                    from u_line AS ul 
                    left join u_line_dest AS uld ON ul.id = uld.line_id
                    left join u_dest_cfg AS ud ON ud.id = uld.dest_id where ud.id = 1 and ul.status = 2 AND ul.producttype = 0 AND ul.line_kind = 1 order by ul.displayorder DESC, ul.bookcount DESC) limit {$from}, {$page_size}";
                $reDataArr['lineList'] = $this->db->query($line_chujing_sql)->result_array();
                //$reDataArr['dest'] = $this->db->query($dest_chujing_sql)->result_array();
                break;

            case 3:
                // 周边线路
//                $line_sql = "SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id,e.small_photo,e.nickname   	FROM  	cfgm_hot_line AS cx LEFT JOIN u_line AS l ON cx.line_id=l.id  left join cfg_index_kind as cik on cik.id=cx.dest_type left join u_expert as e on e.id=l.recommend_expert where l.status='2' and cx.startplaceid = $cityid and cx.is_show=1 and cx.starttime<='{$time}' and cx.endtime>='{$time}'";
                //$line_zhoubian_sql = $line_sql . " and cx.dest_type=3 order by cx.showorder limit {$from},{$page_size}";
//                $line_zhoubian_sql = "SELECT "
                //$dest_zhoubian_sql = $dest_sql . ' and cd.dest_type=3 order by cd.id desc';
                $line_zhoubian_sql = "(SELECT cx.line_id as id,cx.dest_type,cx.pic as pic,l.linetitle as linetitle,l.linename as linename,l.satisfyscore,l.bookcount,l.peoplecount,l.comment_count,l.lineprice,l.saveprice,l.recommend_expert as expert_id
                    FROM  	cfgm_hot_line AS cx 
                    LEFT JOIN u_line AS l ON cx.line_id=l.id where cx.dest_type = 3 AND l.status = 2 AND l.producttype=0 AND l.line_kind = 1 AND l.startcity={$cityid} order by l.displayorder DESC, l.bookcount DESC)
                    union
                    (select ul.id as id, ul.line_classify as dest_type, ul.mainpic as pic, ul.linetitle as linetitle, ul.linename as linename, ul.satisfyscore, ul.bookcount,ul.peoplecount, ul.comment_count, ul.lineprice,ul.saveprice,ul.recommend_expert as expert_id
                    from u_line AS ul 
                    left join u_line_dest AS uld ON ul.id = uld.line_id
                    left join cfg_round_trip AS crt ON crt.neighbor_id = uld.dest_id where crt.isopen = 1 AND ul.status = 2 AND ul.producttype = 0 AND ul.line_kind = 1 AND crt.startplaceid={$cityid} order by ul.displayorder desc, ul.bookcount DESC) limit {$from}, {$page_size}";
                $reDataArr['lineList'] = $this->db->query($line_zhoubian_sql)->result_array();
                //$reDataArr['dest'] = $this->db->query($dest_zhoubian_sql)->result_array();
                break;

            default:
                $this->__errormsg('type is wrong');
                break;
        }
//        }
        // if need to this plase take on
        // $this->output->cache(5);
        $this->__outmsg($reDataArr);
    }

    /**
     * @name 管家列表
     * @author 魏勇
     * @param type 1=>推荐,2=>管家,3=>关注  默认为1
     * @param member_id 用户id    查询关注的管家时需要用到
     * @param page 第几页 默认为1
     * @param per_page 每页条数  默认为6
     * @param cityid 城市id
     */
    public function cfgm_expert_list_new() {
        $type = intval($this->input->get_post('type', true));
        $member_id = $this->input->get_post('id', true);
        $city_id = $this->input->get_post('cityid', true);
        $page = intval($this->input->get_post('page', true));
        $per_page = intval($this->input->get_post('per_page', true));
        if ($type < 0 or $page < 0 or $per_page < 0) {
            $this->__errormsg('param exception');
        }
        $type = empty($type) ? 1 : $type;
        $page = empty($page) ? 1 : $page;
        $per_page = empty($per_page) ? 6 : $per_page;
        $from = ($page - 1) * $per_page;

        $reDataArr = array();
        switch ($type) {
            case 1:             // 推荐管家
//                $recommend_sql = "SELECT e.id, e.big_photo, e.small_photo, e.m_bgpic, e.realname, e.nickname, e.login_name, e.satisfaction_rate, e.expert_dest, e.people_count, e.attention_count 
//                                    FROM cfgm_hot_expert AS h LEFT JOIN u_expert AS e ON h.expert_id = e.id limit {$from},{$per_page}";   // 改为按成交量降序排列,取前20条

                $recommend_sql = "SELECT e.id, e.big_photo, e.small_photo, e.m_bgpic, e.realname, e.nickname, e.login_name, e.satisfaction_rate, e.expert_dest, e.people_count, e.attention_count 
                                    FROM cfgm_hot_expert AS h LEFT JOIN u_expert AS e ON h.expert_id = e.id WHERE e.status = 2 AND e.city = $city_id ORDER BY h.showorder DESC, e.people_count DESC  LIMIT {$from},{$per_page}";
                $reDataArr = $this->db->query($recommend_sql)->result_array();
                break;

            case 2:             // 所有管家
//                $all_sql = "SELECT e.id, e.big_photo, e.small_photo, e.m_bgpic, e.realname, e.nickname, e.login_name, e.satisfaction_rate, e.expert_dest, e.people_count, e.attention_count 
//                                FROM u_expert AS e limit {$from},{$per_page}";        // 改为按成交量降序排列
                $all_sql = "SELECT e.id, e.big_photo, e.small_photo, e.m_bgpic, e.realname, e.nickname, e.login_name, e.satisfaction_rate, e.expert_dest, e.people_count, e.attention_count 
                                FROM u_expert AS e WHERE e.status = 2 AND e.city = $city_id ORDER BY e.people_count DESC limit {$from},{$per_page}";
                $reDataArr = $this->db->query($all_sql)->result_array();
                break;

            case 3:             // 关注的管家
                if ('' == $member_id) {
                    $this->__errormsg('member_id is empty');
                }
//                $collect_sql = "SELECT e.id, e.big_photo, e.small_photo, e.m_bgpic, e.realname, e.nickname, e.login_name, e.satisfaction_rate, e.expert_dest, e.people_count, e.attention_count 
//                                    FROM
//                                u_expert AS e JOIN u_expert_collect AS c on c.expert_id = e.id and c.member_id = {$member_id} limit {$from},{$per_page}"; // 改为按成交量将序排列
                $collect_sql = "SELECT e.id, e.big_photo, e.small_photo, e.m_bgpic, e.realname, e.nickname, e.login_name, e.satisfaction_rate, e.expert_dest, e.people_count, e.attention_count 
                                    FROM
                                u_expert AS e JOIN u_expert_collect AS c on c.expert_id = e.id and c.member_id = {$member_id} WHERE e.status = 2 AND e.city = $city_id ORDER BY c.addtime DESC limit {$from},{$per_page}";
                $reDataArr = $this->db->query($collect_sql)->result_array();
                break;

            default:
                $this->__errormsg('type is wrong');
                break;
        }
        foreach ($reDataArr as &$val) {
            $val['expert_dest'] = $this->generate_chn_array($val['expert_dest']);
        }

        $this->__outmsg($reDataArr);
    }

    /**
     * 辅助方法
     * @method 生成u_dest_cfg中id与kindname的对应关系数组
     * @return u_dest_cfg中id与kindname的对应关系数组
     */
    private function generate_id_name_array() {
        $sql = "SELECT id, kindname FROM u_dest_cfg";
        $ret = $this->db->query($sql)->result_array();
        $arr = array();
        foreach ($ret as $key => $val) {
            $arr[] = array($val['id'] => $val['kindname']);
        }
        return $arr;
    }

    /**
     * 辅助方法
     * @method 将数字字符串转为对应的中文字符串
     * @param $int_str=待转换为中文字符串的数字字符串
     * @return 中文字符串的数字字符串
     */
    public function generate_chn_array($int_str) {
        $arr = $this->generate_id_name_array();
        $int_arr = explode(',', $int_str);
        $ret_arr = array();
        foreach ($int_arr as $val) {
            foreach ($arr as $v) {
                foreach ($v as $kl => $vl) {
                    if ($val == $kl) {
                        $ret_arr[] = $vl;
                    }
                }
            }
        }
        return implode(',', $ret_arr);
    }

}

/* End of file webservices.php */
/* Location: ./application/controllers/webservices.php */