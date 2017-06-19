<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @二维码生成工具
 * @path：controllers/tools/qr.php
 * ===================================================================
	http://IP_SERVIDOR/tool/qr/generate
	以下可以自定义二维码的样式
	$this->load->library('ciqrcode');
	$config['cacheable']    = true; //boolean, the default is true
	$config['cachedir']     = ''; //string, the default is application/cache/
	$config['errorlog']     = ''; //string, the default is application/logs/
	$config['quality']      = true; //boolean, the default is true
	$config['size']         = ''; //interger, the default is 1024
	$config['black']        = array(224,255,255); // array, default is array(255,255,255)
	$config['white']        = array(70,130,180); // array, default is array(0,0,0)
	$this->ciqrcode->initialize($config);
 * ===================================================================
 * @类别：通用工具
 * @作者：何俊 （junhey@qq.com）v1.0 Final
 */

class Qr extends CI_Controller {
		
    function __construct()
    {
        parent::__construct();
        /* Standard Libraries of codeigniter are required */
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('ciqrcode');
    }
    public function index()
    {
        $this->generate();
    }
    public function generate()
    {
       $params['data'] = 'junhey';
       $params['level'] = 'H';
       $params['size'] = 10;
       $params['savename'] = FCPATH.'file\qrcodes\test.png';
       $this->ciqrcode->generate($params);
       echo '<img src="'.base_url().'file/qrcodes/test.png" />';
    }    
    public function custom(){
    	$data = $this->security->xss_clean($_GET);    	
    	foreach($data as $key =>$val){    		
    		if ($key == 'data'  ){
    			$params['data'] = $val;
    		}else{
    			$params['data']='junhey';
    		}
    		if ($key == 'level'  ){
    			$params['level'] = $val;
    		}else{
    			$params['level']='H';
    		}
    		if ($key == 'size'  ){
    			$params['size'] = $val;
    		}else{
    			$params['size']=10;
    		}
    		if ($key == 'savename'  ){
    			$params['savename'] = $val;
    		}else{
    			$params['savename'] = FCPATH.'file\qrcodes\test.png';
    		}
    	}
    	$this->ciqrcode->generate($params);
    	echo '<img src="'.base_url().'file/qrcodes/test.png" />';
    }

}

/* End of file qr.php */
/* Location: ./application/controllers/tools/qr.php */