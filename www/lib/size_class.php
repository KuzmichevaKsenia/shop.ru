<?php
require_once "global_class.php";

class Size extends GlobalClass
{

    public function __construct()
    {
        parent::__construct("sizes");
    }

    public function getAllData()
    {
        return $this->transform($this->getAll("size"));
    }

    public function getTableData($count, $offset)
    {
        return $this->transform($this->getAll("size", true, $count, $offset));
    }

    public function get($id)
    {
        return $this->transform(parent::get($id));
    }

    protected function transformElement($size)
    {
        return $size;
    }

    protected function checkData($data, $id = false)
    {
        $suspect_id = $this->getField("id", $data["id"], "id");
        if ($suspect_id && $suspect_id != $id) {
            return "ERROR_EXISTS_CODE";
        }
        if (!$this->check->title($data["size"])) {
            return "ERROR_SIZE";
        }
        return true;
    }

}
