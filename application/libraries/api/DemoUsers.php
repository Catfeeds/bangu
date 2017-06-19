<?php
session_start();
define('SS_DEMOUSER_KEY', 'DEMO_USER_NAME');
class DemoUsers {
    static function allusers() {
        return array(
            'kyky' => array(
                'username'=>'kyky',
                'password'=>'123456',
                'fullname'=>'卖家',
                'email'=>'seller@test.com',
                'telno'=>'802',
                'department'=>'测试部门',
                ),
            'yks5712' => array(
                'username'=>'yks5712',
                'password'=>'123456',
                'fullname'=>'黄雅玲',
                'email'=>'abc@test.com',
                'telno'=>'8001',
                'department'=>'开发部/产品组',
                ),
            'wzc4116' => array(
                'username'=>'wzc4116',
                'password'=>'123456',
                'fullname'=>'李璨瑜',
                'email'=>'abc@test.com',
                'telno'=>'8002',
                'department'=>'开发部/产品组',
                ),
            'libailin' => array(
                'username'=>'libailin',
                'password'=>'123456',
                'fullname'=>'李柏麟',
                'email'=>'abc@test.com',
                'telno'=>'8003',
                'department'=>'开发部/产品组',
                ),
            'xuwenbin' => array(
                'username'=>'xuwenbin',
                'password'=>'123456',
                'fullname'=>'徐文彬',
                'email'=>'abc@test.com',
                'telno'=>'8004',
                'department'=>'市场部/产品组',
                ),
            'wangxuanhao' => array(
                'username'=>'wangxuanhao',
                'password'=>'123456',
                'fullname'=>'王炫皓',
                'email'=>'abc@test.com',
                'telno'=>'8005',
                'department'=>'开发部/产品组',
                ),
            'zhanghaozhe' => array(
                'username'=>'zhanghaozhe',
                'password'=>'123456',
                'fullname'=>'张浩哲',
                'email'=>'abc@test.com',
                'telno'=>'8006',
                'department'=>'市场部/拓展组',
                ),
            'lishaohan' => array(
                'username'=>'lishaohan',
                'password'=>'123456',
                'fullname'=>'李韶涵',
                'email'=>'abc@test.com',
                'telno'=>'8007',
                'department'=>'市场部/拓展组',
                ),
            'jdztygk%23admin' => array(
                'username'=>'jdztygk%23admin',
                'password'=>'123456',
                'fullname'=>'服务器端配置',
                'email'=>'abc@test.com',
                'telno'=>'8007',
                'department'=>'市场部/拓展组',
            ),
           
        );
    }

    function login($username, $password, $authonly) {
        unset($_SESSION[SS_DEMOUSER_KEY]);
        $users = DemoUsers::allusers();
        foreach($users as $uname => $user) {
            if (strtolower($username) == strtolower($uname) && $user['password'] == $password){
            	if(!$authonly){
                	$_SESSION[SS_DEMOUSER_KEY] = $username;
            	}
                return true;
            }
        }
        return false;
    }

    function logout() {
        unset($_SESSION[SS_DEMOUSER_KEY]);
    }

    function curuser() {
        return @$_SESSION[SS_DEMOUSER_KEY];
        //var_dump($_SESSION['SS_DEMOUSER_KEY']);
    }

    function hasuser($username) {
        return array_key_exists ($username , DemoUsers::allusers());
       // var_dump($username);
    }

    function getuser($username) {
        $users = DemoUsers::allusers();
        return $users[$username];
       // var_dump($users);
    }
}
?>