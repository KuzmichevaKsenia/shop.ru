<?php
require_once "config_class.php";
require_once "format_class.php";

class Auth
{

    private $config;
    private $format;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function checkAdmin($login, $password, $hash = true)
    {
        if (!$hash) {
            $password = $this->format->hash($password);
        }
        $login = mb_strtolower($login);
        $real_login = mb_strtolower($this->config->adm_login);
        return (($login === $real_login) && ($password === $this->config->adm_password));
    }
}
