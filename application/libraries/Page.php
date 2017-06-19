<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 分页封装
 * @version 1.0
 * @author hejun
 *
 */
Class CI_Page{
	var  $base_url='';
	var  $pagesize='';//一页显示几条记录
	var  $pagecount='';//总共有多少条记录
	var  $page_now='';
	var  $suffix = '';//链接后缀名
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
		$pagenow=$this->page_now;
		$pagenow==0?$pagenow=1:$pagenow;
		$next= $pagenow+1;
		$first='1';
		if($this->pagecount!=0&&$page!=1){
		//echo '总页数'.$page.' /当前页 '.$pagenow.'&nbsp;';
		echo '<li class="total"><a href="'.$this->base_url.$first.$this ->suffix.'">首页</a></li>';
		if($pagenow>=1){
			$preve= $pagenow-1;
			echo '<li class="last"><a href="' .$this->base_url. $preve.$this ->suffix.'">上一页</a></li>';
		}
		//总页数不超过10页
		if($page<11){
			for($start=1;$start<=$page;$start++){
				if($start!=$pagenow){ 
					echo '<li class="page"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';	
				}
				else{
					echo '<li class="active"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';
				}
			}
			if($pagenow>=1&&$page-$pagenow>0){
				echo '<li class="next"><a href="' .$this->base_url. $next.$this ->suffix.'">下一页</a></li>';
			}
			echo '<li class="lastest"><a href="'.$this->base_url.$page.$this ->suffix.'">尾页</a></li>';
		}
		//总页数超过10页
		if($page>=11){
			
			if($pagenow>5){
				$start=$pagenow-4;
				$index=$pagenow+4;
				if($index<$page){
				
					for(;$start<=$index;$start++){
						if($start!=$pagenow){ 
							echo '<li class="page"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';	
						}
						else{
							echo '<li class="active"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';
						}
					}
					if($pagenow>=1&&$page-$pagenow>0){
						echo '<li class="next"><a href="' .$this->base_url. $next.$this ->suffix.'">下一页</a></li>';
					}
						echo '<li class="lastest"><a href="'.$this->base_url.$page.$this ->suffix.'">尾页</a></li>';
				}	
				else{
					for(;$start<=$page;$start++){
						if($start!=$pagenow){ 
							echo '<li class="page"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';	
						}
						else{
							echo '<li class="active"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';
						}
					}
					if($pagenow>=1&&$page-$pagenow>0){
						echo '<li class="next"><a href="' .$this->base_url. $next.$this ->suffix.'">下一页</a></li>';
					}
						echo '<li class="lastest"><a href="'.$this->base_url.$page.$this ->suffix.'">尾页</a></li>';
				
				}
			}
			else{
				$index='9';
				for($start='1';$start<=$index;$start++){
						if($start!=$pagenow){ 
							echo '<li class="page"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';	
						}
						else{
							echo '<li class="active"><a href="' .$this->base_url.$start.$this ->suffix.'">'.$start.'</a></li>';
						}
					}
					if($pagenow>=1&&$page-$pagenow>0){
						echo '<li class="next"><a href="' .$this->base_url. $next.$this ->suffix.'">下一页</a></li>';
					}
						echo '<li class="lastest"><a href="'.$this->base_url.$page.$this ->suffix.'">尾页</a></li>';
			}
		}
	}
	}
	/*会员中心的分页*/
	function create_c_page()
	{
		$CI =& get_instance();
		$page=ceil($this->pagecount/$this->pagesize);//$page一共有多少页
		$pagenow=$this->page_now;
		$pagenow==0?$pagenow=1:$pagenow;
		$next= $pagenow+1;
		$first='1';
		if($this->pagecount!=0&&$page!=1){
			//echo '总页数'.$page.' /当前页 '.$pagenow.'&nbsp;';
			echo '<li class="total"><a href="'.$this->base_url.$first.'.html">首页</a></li>';
			if($pagenow>=1){
				$preve= $pagenow-1;
				echo '<li class="last"><a href="' .$this->base_url. $preve.'.html">上一页</a></li>';
			}
			//总页数不超过10页
			if($page<11){
				for($start=1;$start<=$page;$start++){
					if($start!=$pagenow){
						echo '<li class="page"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
					}
					else{
						echo '<li class="active"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
					}
				}
				if($pagenow>=1&&$page-$pagenow>0){
					echo '<li class="next"><a href="' .$this->base_url. $next.'.html">下一页</a></li>';
				}
				echo '<li class="lastest"><a href="'.$this->base_url.$page.'.html">尾页</a></li>';
			}
			//总页数超过10页
			if($page>=11){
					
				if($pagenow>5){
					$start=$pagenow-4;
					$index=$pagenow+4;
					if($index<$page){
	
						for(;$start<=$index;$start++){
							if($start!=$pagenow){
								echo '<li class="page"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
							}
							else{
								echo '<li class="active"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
							}
						}
						if($pagenow>=1&&$page-$pagenow>0){
							echo '<li class="next"><a href="' .$this->base_url. $next.'.html">下一页</a></li>';
						}
						echo '<li class="lastest"><a href="'.$this->base_url.$page.'.html">尾页</a></li>';
					}
					else{
						for(;$start<=$page;$start++){
							if($start!=$pagenow){
								echo '<li class="page"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
							}
							else{
								echo '<li class="active"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
							}
						}
						if($pagenow>=1&&$page-$pagenow>0){
							echo '<li class="next"><a href="' .$this->base_url. $next.'.html">下一页</a></li>';
						}
						echo '<li class="lastest"><a href="'.$this->base_url.$page.'.html">尾页</a></li>';
	
					}
				}
				else{
					$index='9';
					for($start='1';$start<=$index;$start++){
						if($start!=$pagenow){
							echo '<li class="page"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
						}
						else{
							echo '<li class="active"><a href="' .$this->base_url.$start.'.html">'.$start.'</a></li>';
						}
					}
					if($pagenow>=1&&$page-$pagenow>0){
						echo '<li class="next"><a href="' .$this->base_url. $next.'.html">下一页</a></li>';
					}
					echo '<li class="lastest"><a href="'.$this->base_url.$page.'.html">尾页</a></li>';
				}
			}
		}
	}
 }
 