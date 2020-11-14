<?php
require_once "config_class.php";

class Check
{

    private $config;

    public function __construct($amp = true)
    {
        $this->config = new Config();
    }

    public function id($id, $zero = false)
    { //проверка id на корректность
        if (!$this->intNumber($id)) {
            return false;
        }
        if ((!$zero) && ($id === 0)) {
            return false; //если ноль не разрешен
        }
        return $id >= 0;
    }

    public function value($value)
    {
        if (!$this->doubleNumber($value)) {
            return false;
        }
        return ($value > 0 && $value <= 1);
    }

    public function ids($ids)
    {
        $reg = "/^(\d+,)+$/";
        return preg_match($reg, $ids);
    }

    public function codes($ids)
    {
        $arr = explode(",", $ids);
        foreach ($arr as $v) {
            if (!$this->code($v)) {
                return false;
            }
        }
        return true;
    }

    public function amount($amount)
    {
        if (!$this->doubleNumber($amount)) {
            return false;
        }
        return $amount >= 0;
    }

    public function name($name)
    {
        if ($this->isContainQuotes($name)) {
            return false;
        }
        return $this->isString($name, 1, $this->config->max_name);
    }

    public function title($title)
    {
        return $this->isString($title, 1, $this->config->max_title);
    }

    public function hex($color)
    {
        return preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $color) == 1;
    }

    public function email($email)
    {
        if ($this->isContainQuotes($email)) {
            return false;
        }
        $reg = "/^[a-z0-9][a-z0-9\._-]*[a-z0-9_]*@([a-z0-9]+([a-z0-9-]*[a-z0-9]+)*\.)+[a-z]+$/i";
        return preg_match($reg, $email);
    }

    public function text($text, $empty = false)
    {
        if (($empty) && ($text == "")) {
            return true;
        }
        return $this->isString($text, 1, $this->config->max_text);
    }

    public function code($id)
    {
        return ctype_alnum($id) && $this->title($id);
    }

    public function ts($ts)
    {
        return $this->NoNegativeInteger($ts);
    }

    public function oneOrZero($number)
    { //является ли число 0 или 1
        if (!$this->intNumber($number)) {
            return false;
        }
        return (($number == 0) || ($number == 1));
    }

    public function count($count)
    {
        return $this->NoNegativeInteger($count);
    }

    public function offset($offset)
    {
        return $this->intNumber($offset);
    }

    public function img($img, $folder)
    {
        if (!$img["name"]) {
            return false;
        }
        if (!$this->isSecureImg($img)) {
            return false;
        }
        if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/" . $folder . $img["name"])) {
            return false;
        }
        return true;
    }

    private function isSecureImg($img)
    {
        $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
        foreach ($blacklist as $bl) {
            if (preg_match("/$bl\$/i", $img["name"])) {
                return false;
            }
        }
        $type = $img["type"];
        $size = $img["size"];
        if (($type != "image/jpg") && ($type != "image/jpeg") && ($type != "image/png")) {
            return false;
        }
        if ($size > $this->config->max_size_img) {
            return false;
        }
        return true;
    }

    private function NoNegativeInteger($number)
    {
        if (!$this->intNumber($number)) {
            return false;
        }
        return ($number >= 0);
    }

    private function intNumber($number)
    { //проверка - целое ли число
        if (!is_int($number) && (!is_string($number))) {
            return false;
        }
        return preg_match("/^-?(([1-9][0-9]*)|(0))$/", $number);
    }

    private function isContainQuotes($string)
    {
        $array = array("\"", "'", "`", "&quot;", "&apos;");
        foreach ($array as $value) {
            if (strpos($string, $value) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isString($string, $min_length, $max_length)
    {
        if (!is_string($string)) {
            return false;
        }
        if (strlen($string) < $min_length) {
            return false;
        }
        if (strlen($string) > $max_length) {
            return false;
        }
        return true;
    }

    private function doubleNumber($number)
    {
        return is_numeric($number);
    }

}
