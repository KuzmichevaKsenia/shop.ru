<?php
require_once "global_class.php";

class Unit extends GlobalClass
{

    public function __construct()
    {
        parent::__construct("units");
    }

    public function getAllData()
    {
        return $this->transform($this->getAll("id"));
    }

    public function getTableData($count, $offset)
    {
        return $this->transform($this->getAll("id", true, $count, $offset));
    }

    public function get($id)
    {
        return $this->transform(parent::get($id));
    }

    protected function transformElement($unit)
    {
        $unit["img"] = $this->config->address . $this->config->dir_img_products . $unit["img"];
        $unit["color"] = $this->getCell("color", $this->config->db_prefix . "colors", "id", $unit["color_id"]);
        $unit["color_title"] = $this->getCell("title", $this->config->db_prefix . "colors", "id", $unit["color_id"]);
        $size_ids = explode(",", substr($unit["size_ids"], 0, -1));
        foreach ($size_ids as $size_id) {
            $unit["sizes"][] = array(
                "id" => $size_id,
                "size" => $this->getCell("size", $this->config->db_prefix . "sizes", "id", $size_id)
            );
        }
        $unit["link_cart"] = $this->url->addCart($unit["product_id"], $unit["id"], $size_ids[0]);
        return $unit;
    }

    public function checkData($data)
    {
        foreach ($data as $field => $value) {
            switch ($field) {
                case "color_id":
                    if (!$this->check->id($value)) {
                        return "UNKNOWN_ERROR";
                    }
                    break;
                case "product_id":
                    if (!$this->check->code($value)) {
                        return "UNKNOWN_ERROR";
                    }
                    break;
                case "size_ids":
                    if (!$this->check->ids($value)) {
                        return "ERROR_SIZE";
                    }
                    break;
                case "availability":
                    if (!$this->check->title($value)) {
                        return "UNKNOWN_ERROR";
                    }
                    break;
                default:
                    return true;
            }
        }
        return true;
    }

    public function getAllOnFieldByValues($field, $arValues)
    {
        $result = $this->transform($this->getRowsOnField($field, $arValues));
        $units = array();
        if ($result) {
            foreach ($result as $res) {
                $units[$res[$field]][] = $res;
            }
        }
        return $units;
    }

    public function existsItem($id, $product_id, $size_id)
    {
        if (!$this->existsID($id)) {
            return false;
        }
        $unit = $this->getOnField("id", $id);
        $size_ids = explode(",", $unit["size_ids"]);
        return in_array($size_id, $size_ids) && $product_id == $unit["product_id"];
    }

    public function getByProductIdUnTrunsform($prod_id)
    {
        return $this->getAllOnField("product_id", $prod_id);
    }

    private function getImg($id)
    {
        return parent::getFieldOnID($id, "img");
    }

    public function delete($id)
    {
        $oldImg = $this->getImg($id);
        if (parent::delete($id)) {
            unlink("../" . $this->config->dir_img_products . $oldImg);
        } else {
            return false;
        }
        return true;
    }

    public function edit($id, $unit, $needCheck = false)
    {
        if (key_exists("img", $unit)) {
            $newImg = $unit["img"];
            $unit["img"] = $unit["img"]["name"];
            $oldImgName = $this->getImg($id);
        }
        if (parent::edit($id, $unit, $needCheck)) {
            if (key_exists("img", $unit)) {
                if ($oldImgName) {
                    unlink("../" . $this->config->dir_img_products . $oldImgName);
                }
                if (!$this->loadImage($newImg, $this->config->dir_img_products)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public function add($unit, $needCheck = false)
    {
        $unitImg = $unit["img"];
        $unit["img"] = $unit["img"]["name"];
        if (parent::add($unit, $needCheck)) {
            return $this->loadImage($unitImg, $this->config->dir_img_products);
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

    public function getAllOnIDs($ids)
    {
        return $this->transform($this->getRowsOnField("id", $ids));
    }
}
