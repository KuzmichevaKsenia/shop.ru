<?php
require_once "global_class.php";

class Item extends GlobalClass
{

    public function __construct()
    {
        parent::__construct("items");
    }

    public function getAllData()
    {
        return $this->transform($this->getAll("title"));
    }

    public function getTableData($count, $offset)
    {
        return $this->transform($this->getAll("title", true, $count, $offset));
    }

    public function get($id)
    {
        return $this->transform(parent::get($id));
    }

    public function getByIdUntransform($id)
    {
        return parent::get($id);
    }

    protected function transformElement($item)
    {
        $item["img"] = $this->config->address . $this->config->dir_img_items . $item["img"];
        $item["link"] = $this->url->item($item["id"]);
        $item["link_admin_edit"] = $this->url->adminEditItem($item["id"]);
        $item["link_admin_delete"] = $this->url->adminDeleteItem($item["id"]);
        return $item;
    }

    protected function checkData($data, $id = false)
    {
        foreach ($data as $field => $value) {
            if ($field == "title") {
                if (!$this->check->title($value)) {
                    return "ERROR_TITLE";
                }
                $suspect_id = $this->getField("title", $value, "id");
                if ($suspect_id && $suspect_id != $id) {
                    return "ERROR_EXISTS_TITLE";
                }
            }
        }
        return true;
    }

    public function getImg($id)
    {
        return $this->getFieldOnID($id, "img");
    }

    public function delete($id)
    {
        $oldImg = $this->getImg($id);
        if (parent::delete($id)) {
            unlink("../" . $this->config->dir_img_items . $oldImg);
        } else {
            return false;
        }
        return true;
    }

    public function edit($id, $item, $needCheck = true)
    {
        if (key_exists("img", $item)) {
            $newImg = $item["img"];
            $item["img"] = $item["img"]["name"];
            $oldImgName = $this->getImg($id);
        }
        if (parent::edit($id, $item, $needCheck)) {
            if (key_exists("img", $item)) {
                if ($oldImgName) {
                    unlink("../" . $this->config->dir_img_items . $oldImgName);
                }
                if (!$this->loadImage($newImg, $this->config->dir_img_items)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public function add($item, $needCheck = true)
    {
        $img = $item["img"];
        $item["img"] = $item["img"]["name"];
        if (parent::add($item, $needCheck)) {
            return $this->loadImage($img, $this->config->dir_img_items);
        } else {
            return false;
        }
    }

    private function loadImage($img, $path)
    {
        $uploadfile = "../" . $path . $img["name"];
        if (move_uploaded_file($img["tmp_name"], $uploadfile)) {
            return $img["name"];
        } else {
            return false;
        }
    }
}
