<?php
require_once "config_class.php";

class DataBase
{

    private static $db = null;
    private $config;
    private $mysqli; //идентификатор соединения с бд

    public static function getDB()
    { //чтобы всегда был лишь 1 объект (1 подключение к бд)
        if (self::$db == null) {
            self::$db = new DataBase();
        }
        return self::$db;
    }

    private function __construct()
    {
        $this->config = new Config();
        $this->mysqli = new mysqli($this->config->db_host, $this->config->db_user, $this->config->db_password, $this->config->db_name); //подключаемся к бд
        $this->mysqli->query("SET NAMES 'utf8'");
    }

    private function getQuery($query, $params)
    {
        if ($params) { //если есть параметры, обрабатываем запрос
            for ($i = 0; $i < count($params); $i++) {
                $pos = strpos($query, $this->config->sym_query); //ищем первое вхождение символа
                $arg = "'" . $this->mysqli->real_escape_string($params[$i]) . "'"; //экранируем
                $query = substr_replace($query, $arg, $pos, strlen($this->config->sym_query)); //заменяем
            }
        }
        return $query;
    }

    public function select($query, $params = false)
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if (!$result_set) {
            return false;
        }
        return $this->resultSetToArray($result_set);
    }

    public function selectRow($query, $params = false)
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if ($result_set->num_rows != 1) {
            return false;
        }
        return $result_set->fetch_assoc();
    }

    public function selectCell($query, $params = false)
    {
        $result_set = $this->mysqli->query($this->getQuery($query, $params));
        if ((!$result_set) || $result_set->num_rows != 1) {
            return false;
        } else {
            $arr = array_values($result_set->fetch_assoc());
            return $arr[0];
        }
    }

    public function query($query, $params = false)
    {
        $success = $this->mysqli->query($this->getQuery($query, $params));
        if ($success) {
            if ($this->mysqli->insert_id === 0) {
                return true;
            }
            else {
                return $this->mysqli->insert_id;
            }
        } else {
            return false;
        }
    }

    private function resultSetToArray($result_set)
    {
        $array = array();
        while ($row = $result_set->fetch_assoc()) {
            $array[] = $row;
        }
        return $array;
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

}
