<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apiservices extends CI_Controller {

    private $resultJSON;
    private $result_code;
    private $result_msg;
    private $result_data = array();
    private $callback;
    private $webserviceArr;

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database("default", TRUE);
        $this->callback = $this->input->get("callback");
        header("content-type:text/html;charset=utf-8");
        $this->webserviceArr = array(
            "dataType" => "jsonp",
            "method" => 'get',
            "format" => 'callback({"msg":"msgData","code":"codeData","data":{"field":"value"}})',
            "desc" => "callback：自定义的回调名；<br />msg：通信消息；<br />code：通信代码（2000表示获取数据成功，4001表示数据为空）；<br />data：通信数据内容（只有 code是2000的时候才有数据）"
        );
    }

    public function index() {
        $data = array(
            "dataType" => $this->webserviceArr ["dataType"],
            "method" => $this->webserviceArr['method'],
            "format" => $this->webserviceArr ["format"],
            "desc" => $this->webserviceArr ["desc"],
            "webservice" => array(
                array(
                    "serviceName" => "专家列表",
                    "urlName" => "admin_b2_orders",
                    "serviceDesc" => "获取所有专家列表",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "number",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "page",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "用户设计方案",
                    "urlName" => "customer_lines",
                    "serviceDesc" => "获取用户ID,用户名字,定制线路创建时间,出发时间,出发地,目的地,主题,人数,预算",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "number",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "page",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "热门线路",
                    "urlName" => "hot_line",
                    "serviceDesc" => "获取线路id,图片，名称，销量，评论，满意度",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                         
                    )
                ),
                array(
                    "serviceName" => "旅游顾问专家",
                    "urlName" => "consult_expert",
                    "serviceDesc" => "获取专家id和头像",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        
                    )
                ),
                array(
                    "serviceName" => "线路列表",
                    "urlName" => "line_list",
                    "serviceDesc" => "获取线路id，线路名称，线路价钱，满意度，线路特色，销量，评价，往返交通，住宿，行程天数，出团日期，路线图片",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "number",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "page",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "线路列表1",
                    "urlName" => "line_list1",
                    "serviceDesc" => "获取线路id，线路名称，线路价钱，满意度，线路特色，销量，评价，往返交通，住宿，行程天数，出团日期，路线图片",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "linecode",
                            "desc" => "线路编码"
                        ),
                        array(
                            "field" => "linename",
                            "desc" => "线路名称"
                        ),
                        array(
                            "field" => "pageSize",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "pageNum",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "专家详情",
                    "urlName" => "expert_detail?e_id=1",
                    "serviceDesc" => "获取专家id，名称，头像，专家等级，总成交量，顾客评价，专家宣言",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "e_id",
                            "desc" => "专家ID(必备)"
                        )
                    )
                ),
                 array(
                    "serviceName" => "服务记录",
                    "urlName" => "expert_services?e_id=1",
                    "serviceDesc" => "获取订单表中专家ID，线路的图片，线路名称，出团日期，专家表中专家ID",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "e_id",
                            "desc" => "专家ID(必备)"
                        ),
                        array(
                            "field" => "number",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "page",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "游客咨询",
                    "urlName" => "expert_customer_ask?e_id=1",
                    "serviceDesc" => "获取专家ID，咨询问题内容，回答问题内容",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "e_id",
                            "desc" => "专家ID(回答者ID)"
                        ),
                        array(
                            "field" => "number",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "page",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "游记",
                    "urlName" => "travel_notes?e_id=1",
                    "serviceDesc" => "获取线路定制ID，用户名，问题创建时间，需要服务(用逗号隔开)，出发地，目的地，主题，人数，预算，方案设计，方案特色",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "e_id",
                            "desc" => "专家ID(必备)"
                        ),
                        array(
                            "field" => "number",
                            "desc" => "每页条数（为空为默认每页10条）"
                        ),
                        array(
                            "field" => "page",
                            "desc" => "当前页数（为空为默认第1页）"
                        )
                    )
                ),
                array(
                    "serviceName" => "线路详情(主表)",
                    "urlName" => "line_detail?id=58",
                    "serviceDesc" => "获取线路id，线路名字，线路编号，线路价钱，线路图片，满意度，评价，销量，出发城市，儿童说明，产品经理推荐，行程概要",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                 array(
                    "serviceName" => "线路属性",
                    "urlName" => "line_property?id=58",
                    "serviceDesc" => "获取线路属性表 u_line_attr 中的所有字段",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                array(
                    "serviceName" => "线路套餐",
                    "urlName" => "line_meal?id=58",
                    "serviceDesc" => "线路id，套餐名字",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                array(
                    "serviceName" => "价格套餐日历",
                    "urlName" => "calendar_meal?suitid=62",
                    "serviceDesc" => "套餐id,日期，成人价格，儿童价格",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(  
                         array(
                            "field" => "suitid",
                            "desc" => "套餐ID(必备)"
                        )
                    )
                ), 
                 array(
                    "serviceName" => "预定须知",
                    "urlName" => "line_info?id=58",
                    "serviceDesc" => "获取线路id，费用包含，费用不包含，预定须知，签证",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                array(
                    "serviceName" => "右侧专家",
                    "urlName" => "right_expert?id=58",
                    "serviceDesc" => "获取专家id，专家小图片，专家名字，所在城市，专家等级，方案数，点评数，好评率",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                     )
                ),
                array(
                    "serviceName" => "热卖产品(销量排行)",
                    "urlName" => "hot_product",
                    "serviceDesc" => "线路id，线路名字，线路价钱，线路图片",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array(
                        
                     )
                ),
                array(
                    "serviceName" => "其他专家",
                    "urlName" => "other_expert?id=58",
                    "serviceDesc" => "获取专家id，小头像，专家名称，所在城市",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                         array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                array(
                    "serviceName" => "专家心得",
                    "urlName" => "expert_mind?id=58",
                    "serviceDesc" => "获取专家id，小头像，专家名称，所在城市，专家等级，擅长业务，专家宣言",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                         array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                 array(
                    "serviceName" => "行程须知",
                    "urlName" => "line_notice?id=58",
                    "serviceDesc" => "获取行程天数，路线主题，早餐，交通，行程内容，中餐，晚餐，住宿",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                         array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                 array(
                    "serviceName" => "游客点评",
                    "urlName" => "tourist_review?id=58",
                    "serviceDesc" => "线路id，用户头像，用户名字，满意度，对导游评分，对行程评分，对餐饮住宿评分，对交通评分， 评论内容，评论时间，评论来源渠道",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ),
                         array(
                            "field" => "lev",
                            "desc" => "评论等级"
                        )
                    )
                ),
                array(
                    "serviceName" => "在线咨询",
                    "urlName" => "online_ask?id=58",
                    "serviceDesc" => "获取id，产品id，内容，身份类型id",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "id",
                            "desc" => "线路ID(必备)"
                        ) 
                    )
                ),
                array(
                    "serviceName" => "热词搜索",
                    "urlName" => "hot_search?hot=海南",
                    "serviceDesc" => "热搜词id，名称，链接",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "hot",
                            "desc" => "热词(必备)"
                        ) 
                    )
                ),
                array(
                    "serviceName" => "导航栏",
                    "urlName" => "nav_list",
                    "serviceDesc" => "栏目id，名称",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                array(
                    "serviceName" => "轮播图",
                    "urlName" => "banner_list",
                    "serviceDesc" => "轮播图id，图片，链接",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                array(
                    "serviceName" => "线路搜索",
                    "urlName" => "line_search?homecity_name=75&fonts=普吉岛",
                    "serviceDesc" => "热搜词id，名称，链接",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "homecity_name",
                            "desc" => "出发地(必备)"
                        ),
                        array(
                            "field" => "fonts",
                            "desc" => "关键词(必备)"
                        )
                    )
                ),
                array(
                    "serviceName" => "旅游专家顾问(专家头像)",
                    "urlName" => "travel_expert",
                    "serviceDesc" => "专家ID，小图片，大图片，信用值，游客评分，名字，所在城市，等级",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                 array(
                    "serviceName" => "最美专家",
                    "urlName" => "best_expert",
                    "serviceDesc" => "专家ID，小图片，名字，专注领域",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                 array(
                    "serviceName" => "畅销路线",
                    "urlName" => "best_line",
                    "serviceDesc" => "线路id，图片，链接，名称",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                  
                 array(
                    "serviceName" => "出境游",
                    "urlName" => "emigrate_travel",
                    "serviceDesc" => "第一层(id，名称，小图片，图片),第二层(id，名称，小图片，图片)，第三层(线路id，名称，图片，价格)",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                 array(
                    "serviceName" => "国内游",
                    "urlName" => "internal_travel",
                    "serviceDesc" => "第一层(id，名称，小图片，图片),第二层(id，名称，小图片，图片)，第三层(线路id，名称，图片，价格)",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                array(
                    "serviceName" => "定制游",
                    "urlName" => "customize_travel",
                    "serviceDesc" => "第一层(id，名称，小图片，图片),第二层(id，名称，小图片，图片)，第三层(线路id，名称，图片，价格)",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ), 
                array(
                    "serviceName" => "邮轮游",
                    "urlName" => "steamer_travel",
                    "serviceDesc" => "第一层(id，名称，小图片，图片),第二层(id，名称，小图片，图片)，第三层(线路id，名称，图片，价格)",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ), 
                array(
                    "serviceName" => "可能喜欢(推荐目的地)",
                    "urlName" => "recommend_des",
                    "serviceDesc" => "目的地id，图片，名称，链接",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ),
                array(
                    "serviceName" => "最新点评",
                    "urlName" => "newest_comment",
                    "serviceDesc" => "评论ID，用户姓名，评论内容",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                          
                    )
                ), 
                array(
                    "serviceName" => "获取短信验证码",
                    "urlName" => "tel_verify?tel_id=15345657209",
                    "serviceDesc" => "手机获取验证码",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "tel_id",
                            "desc" => "手机号(必备)"
                        )
                    )
                ),
                array(
                    "serviceName" => "注册",
                    "urlName" => "register?tel_id=15345657209&m_p=12325435&m_r_p=12325435&yzm=754373",
                    "serviceDesc" => "手机注册",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "tel_id",
                            "desc" => "手机号(必备)"
                        ),
                         array(
                            "field" => "m_p",
                            "desc" => "密码(必备)"
                        ),
                         array(
                            "field" => "m_r_p",
                            "desc" => "密码(必备)"
                        ),
                         array(
                            "field" => "yzm",
                            "desc" => "验证码(必备)"
                        )
                    )
                ),
                array(
                    "serviceName" => "登录",
                    "urlName" => "login?m_name=15345657209&m_p=12325435",
                    "serviceDesc" => "登录信息验证",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                        array(
                            "field" => "m_name",
                            "desc" => "用户名(必备)"
                        ),
                         array(
                            "field" => "m_p",
                            "desc" => "用户密码(必备)"
                        )
                    )
                ),
                array(
                    "serviceName" => "退出帐号",
                    "urlName" => "u_exit",
                    "serviceDesc" => "将session销毁",
                    "format" => 'callback({"msg":"success","code":"2000","data":{"save_result":"success"}})',
                    "para" => array( 
                         
                    )
                )
            )
        );
        $this->load->view('api_view', $data);
    }

}
