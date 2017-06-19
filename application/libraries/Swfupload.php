<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @swfupload图片上传接口（ User ）
 * @path：libraries/Swfupload.php
 * ===================================================================
 * @功能：上传图片
 * 
 * 
 * 上传图片处理
 *	
  public function upload()
	{		
		$this->load->library('swfupload');
		$this->config->load("file_path",TRUE);
		$path = $this->config->item('path','file_path');
		$filepath = $path['upload'];
		$save_path=$filepath.'/image/';	
		$this->swfupload->uploadimage($save_path);
	}
 *
 * ===================================================================
 * @类别：类库
 * @作者：hejun （junhey@qq.com）v1.0.0 2015-5-5
 */

class Swfupload {
	public function uploadimage($path,$maxx="",$maxy="",$pre="",$smallpath="")
	   {
	   	  if($maxx==""&&$maxy==""&&$pre==""&&$smallpath=="")  
	   	  {//如果只是简单的上传文件
	   	  	     
			date_default_timezone_set('PRC');
	
			$tmp_name = $_FILES['Filedata']['name'];
			$file_path = $path.$tmp_name;//移动文件
			$re = move_uploaded_file($_FILES['Filedata']['tmp_name'], $file_path);
			//return $file_path;  //
	   	  }
	   	  else 
	   	  {//不仅上传图片，而且对大小、名字进行修改
			date_default_timezone_set('PRC');
			$tmp_name = date("Ymdhis",strtotime("now")).".jpg";
			$file_path = $path.$tmp_name;//移动文件
			$re = move_uploaded_file($_FILES['Filedata']['tmp_name'], $file_path);
	
			//将上传的图片处理成缩略图
			$picname=$file_path;   //目标图片的路径
			$info = getimagesize($picname);	//获取图片基本信息
			$w = $info[0];	//获取宽度
			$h = $info[1];	//获取高度
			//获取图片类型，并为此创建对应图片资源
			switch ( $info[2] )
			{
				case 1: //gif
					$im = imagecreatefromgif($picname);
					break;	
				case 2: //jpg
					$im = imagecreatefromjpeg($picname);
					break;	
				case 3: //png
					$im = imagecreatefrompng($picname);
					break;		
				default:
			        die("图片类型错误！");
	        }
	     //创建一个新的图像源
	     $nim = imagecreatetruecolor($maxx,$maxy);
	     //执行等比例缩放
	     imagecopyresampled($nim,$im,0,0,0,0,$maxx,$maxy,$w,$h);
         //输出图像(根据源图像的类型，输出为对应的类型)
	     $picinfo = pathinfo($picname);	//解析源图像的路径等信息。
	     $newpicname = $smallpath.$pre.$picinfo["basename"];
	     switch ( $info[2] )
	     {
		    case 1:
			     imagegif($nim,$newpicname);
			     break;	
		    case 2:
			      imagejpeg($nim,$newpicname);
			      break;	
		    case 3:
			      imagepng($nim,$newpicname);
			      break;		
       	 }
	     imagedestroy($im); //释放图片资源
	     imagedestroy($nim);
	     return $pre.$picinfo["basename"];  //返回上传后的图片的新名称
		
	     }
	   }
	   
	   public function uploadfile($path,$maxx="",$maxy="",$pre="",$smallpath="")
	   {
	   	  if($maxx==""&&$maxy==""&&$pre==""&&$smallpath=="")  
	   	  {//如果只是简单的上传文件
	   	  	     
			date_default_timezone_set('PRC');
	
			$tmp_name = date("Ymdhis",strtotime("now")).".doc";
			$file_path = $path.$tmp_name;//移动文件
			$re = move_uploaded_file($_FILES['Filedata']['tmp_name'], $file_path);
			return $tmp_name;  //
	   	  }
	   	  else 
	   	  {//不仅上传图片，而且对大小、名字进行修改
			date_default_timezone_set('PRC');
			$tmp_name = date("Ymdhis",strtotime("now")).".jpg";
			$file_path = $path.$tmp_name;//移动文件
			$re = move_uploaded_file($_FILES['Filedata']['tmp_name'], $file_path);
	
			//将上传的图片处理成缩略图
			$picname=$file_path;   //目标图片的路径
			$info = getimagesize($picname);	//获取图片基本信息
			$w = $info[0];	//获取宽度
			$h = $info[1];	//获取高度
			//获取图片类型，并为此创建对应图片资源
			switch ( $info[2] )
			{
				case 1: //gif
					$im = imagecreatefromgif($picname);
					break;	
				case 2: //jpg
					$im = imagecreatefromjpeg($picname);
					break;	
				case 3: //png
					$im = imagecreatefrompng($picname);
					break;		
				default:
			        die("图片类型错误！");
	        }
	     //创建一个新的图像源
	     $nim = imagecreatetruecolor($maxx,$maxy);
	     //执行等比例缩放
	     imagecopyresampled($nim,$im,0,0,0,0,$maxx,$maxy,$w,$h);
         //输出图像(根据源图像的类型，输出为对应的类型)
	     $picinfo = pathinfo($picname);	//解析源图像的路径等信息。
	     $newpicname = $smallpath.$pre.$picinfo["basename"];
	     switch ( $info[2] )
	     {
		    case 1:
			     imagegif($nim,$newpicname);
			     break;	
		    case 2:
			      imagejpeg($nim,$newpicname);
			      break;	
		    case 3:
			      imagepng($nim,$newpicname);
			      break;		
       	 }
	     imagedestroy($im); //释放图片资源
	     imagedestroy($nim);
	     return $pre.$picinfo["basename"];  //返回上传后的图片的新名称
		
	     }
	   }
	
	
}
/* End of file swfupload.php */