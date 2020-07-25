<?php

/**
 * This class would be used to access all the configs set in "config.ini"
 * This would be helpful as to access all the configs anywhere
 */

class Config
{
    protected $config;
    public function __construct()
    {
        /*
         * __DIR__ is the system call to give the current directory. Internally it gives the path of "./"
         */
        $this->config = parse_ini_file(__DIR__ . "/../../config.ini");
    }

    public function get(string $key)
    {
        if(isset($this->config[$key]))
        {
            return $this->config[$key];
        }
        die("This config cannot be found: " . $key);
    }
}

?>