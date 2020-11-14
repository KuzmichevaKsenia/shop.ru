<?php
require_once "config_class.php";

class Format
{

    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function ts()
    {
        return time();
    }

    public function date($t)
    {
        return date("Y-m-d H:i:s", $t);
    }

    public function time($ts)
    {
        return date("d.m.Y", $ts);
    }

    public function xss($data)
    { //для безопасности
        if (is_array($data)) {
            $escaped = array();
            foreach ($data as $key => $value) {
                $escaped[$key] = $this->xss($value);
            }
            return $escaped;
        }
        return htmlspecialchars(trim($data));
    }

    public function getTime($t, $start)
    {
        if ($t) {
            preg_match_all("/(\d{2}).(\d{2}).(\d{4})/i", $t, $matches);
            if ($start) {
                return mktime(0, 0, 0, $matches[2][0], $matches[1][0], $matches[3][0]);
            } else {
                return mktime(23, 59, 59, $matches[2][0], $matches[1][0], $matches[3][0]);
            }
        } else {
            if ($start) {
                return mktime(0, 0, 0, date("n"), date("j"), date("Y")) - 6 * 24 * 3600;
            } else {
                return mktime(23, 59, 59, date("n"), date("j"), date("Y"));
            }
        }
    }

    public function hash($str)
    {
        return md5($str . $this->config->secret);
    }

}
