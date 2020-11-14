<?php
require_once "config_class.php";

abstract class GlobalMessage
{

    private $data;

    public function __construct($file)
    {
        $config = new Config();
        $this->data = parse_ini_file($config->dir_text . $file . ".ini");
    }

    public function get($name)
    {
        return $this->data[$name];
    }
}
