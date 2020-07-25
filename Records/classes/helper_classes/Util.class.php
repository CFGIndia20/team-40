<?php

class Util{
    private $di;
    private static $baseurl;
    public function __construct(DependencyInjector $di){
        $this->di = $di;
        self::$baseurl = $this->di->get("config")->get("base_url");
    }

    public static function redirect($filePath){
        // echo ($this->di->get("config")->get("base_url") . "views/pages/$filePath");
        header("Location: ". (self::$baseurl . "views/pages/$filePath"));
    }

    public static function dd($var=""){
        die(var_dump($var));
    }

    public static function createCSRFToken(){
        Session::setSession('csrf_token', uniqid().rand());
        Session::setSession('token_expire', time()+3600);
    }

    public static function verifyCSRFToken($data){
        return (isset($data['csrf_token']) && Session::getSession('csrf_token') != null && $data['csrf_token'] == Session::getSession('csrf_token') && Session::getSession('token_expire') > time());
    }

    public static function createAssocArray($arrayOfKeys, $data){
        $assoc_array = array();
        foreach($arrayOfKeys as $key){
            $assoc_array[$key] = $data[$key];
        }
        return $assoc_array;
    }
}

?>