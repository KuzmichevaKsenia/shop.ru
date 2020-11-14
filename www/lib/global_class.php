<?php
require_once "database_class.php";
require_once "config_class.php";
require_once "check_class.php";
require_once "url_class.php";
require_once "systemmessage_class.php";

abstract class GlobalClass
{

    protected $db;
    protected $table_name;
    protected $format;
    protected $config;
    protected $check;
    protected $url;

    public function __construct($table_name)
    {
        $this->db = DataBase::getDB();
        $this->format = new Format();
        $this->config = new Config();
        $this->check = new Check();
        $this->url = new URL();
        $this->table_name = $this->config->db_prefix . $table_name;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function add($data, $needCheck = true)
    {
        if ($needCheck && !$this->check($data)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach ($data as $field => $value) {
            $query .= "$field,";
        }
        $query = substr($query, 0, -1);
        $query .= ") VALUES (";
        foreach ($data as $value) {
            $query .= $this->config->sym_query . ",";
        }
        $query = substr($query, 0, -1);
        $query .= ")";
        return $this->db->query($query, array_values($data));
    }

    public function edit($id, $data, $needCheck = true)
    {
        if ($needCheck && !$this->check($data, $id)) {
            return false;
        }
        $query = "UPDATE " . $this->table_name . " SET ";
        foreach ($data as $field => $value) {
            $query .= "$field = " . $this->config->sym_query . ",";
        }
        $query = substr($query, 0, -1);
        $query .= "WHERE id = " . $this->config->sym_query;
        $data["where_id"] = $id;
        return $this->db->query($query, array_values($data));
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=" . $this->config->sym_query;
        return $this->db->query($query, array($id));
    }

    public function getCount()
    {
        $query = "SELECT COUNT(id) FROM " . $this->table_name;
        return $this->db->selectCell($query);
    }

    public function search($q, $fields, $order = false, $up = false)
    {
        if (empty($fields)) {
            return false;
        }
        $q = trim($q);
        if ($q === "") {
            return false;
        }
        $q = preg_replace("/\s+/", " ", $q);
        $q = mb_strtolower($q);
        $array_words = explode(" ", $q);
        $logic = " AND ";
        $params = array();
        foreach ($array_words as $key => $value) {
            if (isset($array_words[$key - 1])) {
                $where .= $logic;
            }
            for ($i = 0; $i < count($fields); $i++) {
                $where .= "$fields[$i] LIKE " . $this->config->sym_query;
                $params[] = "%$value%";
                if (($i + 1) != count($fields)) {
                    $where .= " OR ";
                }
            }
        }
        $ol = $this->getOL($order, $up, 0, 0);
        $query = "SELECT * FROM $this->table_name WHERE $where $ol";
        return $this->db->select($query, $params);
    }

    public function existsID($id)
    {
        if (!$this->check->id($id)) {
            return false;
        }
        return $this->isExistsFV("id", $id);
    }

    public function get($id, $isCode = false)
    {
        if (!$this->check->id($id) && !$isCode || $isCode && !$this->check->code($id)) {
            return false;
        }
        return $this->getOnField("id", $id);
    }

    protected function checkData($data, $id = false)
    {
        return false;
    }

    protected function getCell($col, $table_name, $where_left, $where_right)
    {
        $query = "SELECT $col FROM $table_name WHERE $where_left = $where_right";
        return $this->db->selectCell($query);
    }

    protected function getRowsOnField($field, $values)
    {
        $query_rows = "";
        $params = array();
        for ($i = 0; $i < count($values); $i++) {
            $query_rows .= $this->config->sym_query . ",";
            $params[] = $values[$i];
        }
        $query_rows = substr($query_rows, 0, -1);
        $query = "SELECT * FROM $this->table_name WHERE $field IN ($query_rows)";
        return $this->db->select($query, $params);
    }

    protected function isExistsFV($field, $value)
    {
        $result = $this->getAllOnField($field, $value);
        return count($result) != 0;
    }

    protected function getAll($order = false, $up = true, $count = false, $offset = false)
    { //получить все данные таблицы (сортировка, по возр./уб., количество, смещение)
        $ol = $this->getOL($order, $up, $count, $offset);
        $query = "SELECT * FROM $this->table_name $ol";
        return $this->db->select($query);
    }

    protected function getField($field_in, $value_in, $field_out)
    {
        $query = "SELECT $field_out FROM $this->table_name WHERE $field_in = " . $this->config->sym_query;
        return $this->db->selectCell($query, array($value_in));
    }

    protected function getFieldOnID($id, $field)
    {
        return $this->getField("id", $id, $field);
    }

    protected function getOnField($field, $value)
    {
        $query = "SELECT * FROM $this->table_name WHERE $field = " . $this->config->sym_query;
        return $this->db->selectRow($query, array($value));
    }

    protected function getAllOnField($field, $value, $order = false, $up = true, $count = false, $offset = false)
    {
        $ol = $this->getOL($order, $up, $count, $offset);
        $query = "SELECT * FROM $this->table_name WHERE $field = " . $this->config->sym_query . $ol;
        return $this->db->select($query, array($value));
    }

    protected function getAllOnDifferentFields($field1, $field2, $order = false, $up = true, $count = false, $offset = false)
    {
        $ol = $this->getOL($order, $up, $count, $offset);
        $query = "SELECT * FROM $this->table_name WHERE $field1 !=  $field2 $ol";
        return $this->db->select($query);
    }

    protected function getOL($order, $up, $count, $offset)
    {
        if ($order) {
            $order = "ORDER BY " . $order;
            if (!$up) {
                $order .= " DESC";
            }
        }
        $limit = $this->getL($count, $offset);
        if ($limit) {
            return "$order $limit";
        }
        return $order;
    }

    protected function transform($element)
    { //преобразуем набор полученных из бд данных
        if (!$element) {
            return false;
        }
        if (isset($element[0])) { //если это массив
            for ($i = 0; $i < count($element); $i++) {
                $element[$i] = $this->transformElement($element[$i]);
            }
            return $element;
        } else {
            return $this->transformElement($element);
        }
    }

    protected function getL($count, $offset)
    {
        $limit = "";
        if ($count) {
            if (!$this->check->count($count)) {
                return false;
            }
            if ($offset) {
                if (!$this->check->offset($offset)) {
                    return false;
                }
                $limit = "LIMIT $offset, $count";
            } else {
                $limit = "LIMIT $count";
            }
        }
        return $limit;
    }

    private function check($data, $id = false)
    {
        $result = $this->checkData($data, $id);
        if ($result === true) {
            return true;
        }
        $sm = new SystemMessage();
        return $sm->message($result);
    }


}
