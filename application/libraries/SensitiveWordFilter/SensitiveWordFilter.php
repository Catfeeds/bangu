<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class CI_SensitiveWordFilter
{
	private static $dict;
	private static $dictPath;
	private static $instance;	
    public function __construct()
    {
		if(empty(self::$instance)){
			self::$instance =& $this;	
			self::$dict = array();
			self::$dictPath = __DIR__ . '/sensitive_words.txt';				
		}
    }
	public static function &get_instance()
	{
		return self::$instance;
	}
	//初始化过滤词
    private function initDict()
    {
		$str = file_get_contents(self::$dictPath);
        if (!$str) {
            throw new RuntimeException('open dictionary file error.');
        }
        $strs = explode(',',$str);
		$counts = count($strs);
        for($ii=0;$ii<$counts;$ii++) {
            $word = $strs[$ii];
            if (empty($word)) {
                continue;
            }
            $uWord = $this->unicodeSplit($word);
            $pdict = &self::$dict;

            $count = count($uWord);
            for ($i = 0; $i < $count; $i++) {
                if (!isset($pdict[$uWord[$i]])) {
                    $pdict[$uWord[$i]] = array();
                }
                $pdict = &$pdict[$uWord[$i]];
            }
            $pdict['end'] = true;
        }
    }
	
    public function filter($str, $maxDistance = 5)
    {
		if(empty(self::$dict)){
			$this->initDict();			
		}
        if ($maxDistance < 1) {
            $maxDistance = 1;
        }
        $uStr = $this->unicodeSplit($str);
        $count = count($uStr);
        for ($i = 0; $i < $count; $i++) {
            if (isset(self::$dict[$uStr[$i]])) {
                $pdict = &self::$dict[$uStr[$i]];

                $matchIndexes = array();

                for ($j = $i + 1, $d = 0; $d < $maxDistance && $j < $count; $j++, $d++) {
                    if (isset($pdict[$uStr[$j]])) {
                        $matchIndexes[] = $j;
                        $pdict = &$pdict[$uStr[$j]];
                        $d = -1;
                    }
                }

                if (isset($pdict['end'])) {
                    $uStr[$i] = ':'.$uStr[$i];
                    foreach ($matchIndexes as $k) {
                        if ($k - $i == 1) {
                            $i = $k;
                        }
                        $uStr[$k] = ':'.$uStr[$k];
                    }
                }
            }
        }

        return implode($uStr);
    }
	//删除过滤符号,用于显示数据
    public function delFilterSign($str)
    {
        $uStr = $this->unicodeSplit($str);
        $count = count($uStr);
        for ($i = 0; $i < $count; $i++) {
			if($uStr[$i]==':'){
				if(isset($uStr[$i-1]) && $uStr[$i-1]=='/' ){//在添加字段时会在带有:符号前加/,所有这里不能打星号
					
				}else if(isset($uStr[$i-1]) && $uStr[$i-1]!='/'){
					unset($uStr[$i]);
					$uStr[$i+1]='*';
					$i= $i+1;					
				}else if(!isset($uStr[$i-1])){
					unset($uStr[$i]);
					$uStr[$i+1]='*';
					$i= $i+1;
				}
			}
        }
		$str = implode($uStr);
		$str = str_replace("/:",":",$str);
        return $str;
    }	
	//增加过滤符号,在插入数据时使用
    public function addFilterSign($str)
    {
		$str = str_replace(":","/:",$str);
		$str = $this->filter($str, 10);
        return $str;
    }	

    public function unicodeSplit($str)
    {
        $str = strtolower($str);
        $ret = array();
        $len = strlen($str);
        for ($i = 0; $i < $len; $i++) {
            $c = ord($str[$i]);

            if ($c & 0x80) {
                if (($c & 0xf8) == 0xf0 && $len - $i >= 4) {
                    if ((ord($str[$i + 1]) & 0xc0) == 0x80 && (ord($str[$i + 2]) & 0xc0) == 0x80 && (ord($str[$i + 3]) & 0xc0) == 0x80) {
                        $uc = substr($str, $i, 4);
                        $ret[] = $uc;
                        $i += 3;
                    }
                } else if (($c & 0xf0) == 0xe0 && $len - $i >= 3) {
                    if ((ord($str[$i + 1]) & 0xc0) == 0x80 && (ord($str[$i + 2]) & 0xc0) == 0x80) {
                        $uc = substr($str, $i, 3);
                        $ret[] = $uc;
                        $i += 2;
                    }
                } else if (($c & 0xe0) == 0xc0 && $len - $i >= 2) {
                    if ((ord($str[$i + 1])  & 0xc0) == 0x80) {
                        $uc = substr($str, $i, 2);
                        $ret[] = $uc;
                        $i += 1;
                    }
                }
            } else {
                $ret[] = $str[$i];
            }
        }

        return $ret;
    }
}
/*
$filter = new SensitiveWordFilter();
$filter2 = new SensitiveWordFilter();
$tt = $filter2->addFilterSign('ww飒飒飒飒毛泽东www飒孙a出/:中/::山飒新闻出飒飒');
echo '----------------------------------------';
$tt = $filter->addFilterSign('ww飒飒飒飒毛泽东www飒孙a出/:中/::山飒新闻出飒飒');
echo $tt;echo '<br/>';
echo $filter->delFilterSign($tt);
*/
?>