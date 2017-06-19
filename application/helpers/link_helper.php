<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
*反盗链辅助函数
*使用方法在控制器里面调用$this->load->helper('link')
*在控制器里面的方法里面直接调用show()
*show的参数$url获取浏览器跳转前的url，$dataurl图片或文件存放在服务器的路径，$filename下载后文件或图片的名字
*作者:何俊
*时间：2015-05-07
*/

function show($url,$dfile,$filename=''){//用于批量下载并且支持防盗链
  $ADMIN = array('defaulturl' =>home_url('tools/down/error')); //盗链返回的地址 );
        $okaysites = array(
            home_url(),
            file_url()); //白名单 ;
        $reffer = $url;
        if ($reffer) {
            $yes = 0;
            $url = parse_url($reffer);
            while (list($domain, $subarray) = each($okaysites)) {
                $sub = parse_url($subarray);
                if ($sub['host'] == $url['host']) {
                    $yes = 1;
                }
            }
            if ($yes==1) {
				header('Pragma: public');
                header('Last-Modified:'.gmdate('D, d M Y H:i:s') . 'GMT');
                header('Cache-Control:no-store, no-cache, must-revalidate');
                header('Cache-Control:pre-check=0, post-check=0, max-age=0');
                header('Content-Transfer-Encoding:binary');
                header('Content-Encoding:none');
                header('Content-type:multipart/form-data');
                header('Content-Disposition:attachment; filename="'.$filename.'"'); //设置下载的默认文件名
                header('Content-length:'.filesize($dfile));
				return fopen($dfile, 'r');
            } else {
                header("Location: $ADMIN[defaulturl]");
            }
        } else {
            header("Location: $ADMIN[defaulturl]");
        }
}
function show_single($url,$filename){//用于显示图片并且防盗链
 $ADMIN = array('defaulturl' => home_url('tools/down/error')); //盗链返回的地址 );
        $okaysites = array(
            home_url(),
            file_url()); //白名单 ;
        $reffer = $url;
        if ($reffer) {
            $yes = 0;
            $url = parse_url($reffer);
            while (list($domain, $subarray) = each($okaysites)) {
                $sub = parse_url($subarray);
                if ($sub['host'] == $url['host']) {
                    $yes = 1;
                }
            }
            if ($yes==1) {
                Header("Cache-control: private");
                Header("Pragma: ");
                Header("Accept-Ranges: bytes");
                header('Content-type:image/jpeg');
                header('Content-Disposition: attachment; filename='.$filename);
                readfile($filename);
            } else {
                header("Location: $ADMIN[defaulturl]");
            }
        } else {
            header("Location: $ADMIN[defaulturl]");
        }
}
function error(){
  echo "<script>window.location.href='".home_url()."'</script>";
}

?>