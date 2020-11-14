<?php
require_once "global_class.php";

class Color extends GlobalClass
{

    public function __construct()
    {
        parent::__construct("colors");
    }

    public function getAllData()
    {
        return $this->transform($this->getAll("title"));
    }

    public function getTableData($count, $offset)
    {
        return $this->transform($this->getAll("title", true, $count, $offset));
    }

    protected function transformElement($color)
    {
        if (stristr($color["color"], 'url') === FALSE) {
            $color["link_admin_edit"] = $this->url->adminEditColor($color["id"]);
        }
        $color["link_admin_delete"] = $this->url->adminDeleteColor($color["id"]);
        return $color;
    }

    protected function checkData($data, $id = false)
    {
        if (!$this->check->title($data["title"])) {
            return "ERROR_TITLE";
        }
        $suspect_id = $this->getField("title", $data["title"], "id");
        if ($suspect_id && $suspect_id != $id) {
            return "ERROR_EXISTS_TITLE";
        }
        if (!$this->check->hex($data["color"])) {
            return "ERROR_COLOR";
        }
        return true;
    }
}
