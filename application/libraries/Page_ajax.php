<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 分页封装
 * @version 1.0
 * @author hejun
 *
 */
Class CI_Page_ajax{
	var  $base_url='';
	var  $pagesize='';//一页显示几条记录
	var  $pagecount='';//总共有多少条记录
	var  $page_now='';
	function initialize($params = array()){
		if (count($params) > 0){
			foreach ($params as $key => $val){
				if (isset($this->$key)){
					$this->$key = $val;
				}
			}
		}
	}
	function create_page()
	{	
		$CI =& get_instance();
		$page=ceil($this->pagecount/$this->pagesize);//$page一共有多少页
		//只有一页不输入分页
		if ($page <= 1) {
			return '';
		}
		
		$pagenow=$this->page_now;
		$pagenow==0?$pagenow=1:$pagenow;
		$next= $pagenow+1;
		$first='1';
		//echo '总页数'.$page.' /当前页 '.$pagenow.'&nbsp;';
		$str = '<li class="total ajax_page"><a page_new="'.$first.'" href="javascript:void(0);">首页</a></li>';
		if($pagenow> 1){
			$preve= $pagenow-1;
			$str .= '<li class="last ajax_page"><a page_new="'.$preve.'" href="javascript:void(0);">上一页</a></li>';
		}
		//总页数不超过10页
		if($page<11){
			for($start=1;$start<=$page;$start++){
				if($start!=$pagenow){ 
					$str .= '<li class="page ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';	
				}
				else{
					$str .= '<li class="active ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';
				}
			}
// 			if($pagenow>=1&&$page-$pagenow>0){
// 				$str .= '<li class="next ajax_page"><a page_new="'.$next.'" href="javascript:void(0);">下一页</a>&nbsp</li>';
// 			}
// 			$str .= '<li class="lastest ajax_page"><a page_new="'.$page.'" href="javascript:void(0);">尾页</a>&nbsp</li>';
		}
		//总页数超过10页
		if($page>=11){
			
			if($pagenow>5){
				$start=$pagenow-4;
				$index=$pagenow+4;
				if($index<$page){
				
					for(;$start<=$index;$start++){
						if($start!=$pagenow){ 
							$str .= '<li class="page ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';	
						}
						else{
							$str .= '<li class="active ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';
						}
					}
// 					if($pagenow>=1&&$page-$pagenow>0){
// 						$str .= '<li class="next ajax_page"><a page_new="'.$next.'" href="javascript:void(0);">下一页</a>&nbsp</li>';
// 					}
// 						$str .= '<li class="lastest ajax_page"><a page_new="'.$page.'" href="javascript:void(0);">尾页</a>&nbsp</li>';
				}	
				else{
					for(;$start<=$page;$start++){
						if($start!=$pagenow){ 
							$str .= '<li class="page ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';	
						}
						else{
							$str .= '<li class="active ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';
						}
					}
// 					if($pagenow>=1&&$page-$pagenow>0){
// 						$str .= '<li class="next ajax_page"><a page_new="'.$next.'" href="javascript:void(0);">下一页</a>&nbsp</li>';
// 					}
// 						$str .= '<li class="lastest ajax_page"><a page_new="'.$page.'" href="javascript:void(0);">尾页</a>&nbsp</li>';
				
				}
			}
			else{
				$index='9';
				for($start='1';$start<=$index;$start++){
						if($start!=$pagenow){ 
							$str .= '<li class="page ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';	
						}
						else{
							$str .= '<li class="active ajax_page"><a page_new="'.$start.'" href="javascript:void(0);">'.$start.'</a></li>';
						}
					}
// 					if($pagenow>=1&&$page-$pagenow>0){
// 						$str .= '<li class="next ajax_page"><a page_new="'.$next.'" href="javascript:void(0);">下一页</a>&nbsp</li>';
// 					}
// 						$str .= '<li class="lastest ajax_page"><a page_new="'.$page.'" href="javascript:void(0);">尾页</a>&nbsp</li>';
			}
		}
		if($pagenow>=1&&$page-$pagenow>0){
			$str .= '<li class="next ajax_page"><a page_new="'.$next.'" href="javascript:void(0);">下一页</a></li>';
			$str .= '<li class="lastest ajax_page"><a page_new="'.$page.'" href="javascript:void(0);">尾页</a></li>';
		}
		return $str;
	}
 }
 