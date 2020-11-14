<?php
require_once "global_class.php";

class Brand extends GlobalClass
{

    public function __construct()
    {
        parent::__construct("brands");
    }

    public function getAllData()
    {
        return $this->transform($this->getAll("country"));
    }

    public function getTableData($count, $offset)
    {
        return $this->transform($this->getAll("country", true, $count, $offset));
    }

    public function get($id)
    {
        return $this->transform(parent::get($id));
    }

    public function getByIdUntransform($id)
    {
        return parent::get($id);
    }

    protected function transformElement($brand)
    {
        $brand["logo"] = $this->config->address . $this->config->dir_img_brands . $brand["logo"];
        $brand["link"] = $this->url->brand($brand["id"]);
        $brand["link_admin_edit"] = $this->url->adminEditBrand($brand["id"]);
        $brand["link_admin_delete"] = $this->url->adminDeleteBrand($brand["id"]);
        return $brand;
    }

    protected function checkData($data, $id = false)
    {
        foreach ($data as $field => $value) {
            switch ($field) {
                case "title":
                    if (!$this->check->title($value)) {
                        return "ERROR_TITLE";
                    }
                    $suspect_id = $this->getField("title", $value, "id");
                    if ($suspect_id && $suspect_id != $id) {
                        return "ERROR_EXISTS_TITLE";
                    }
                    break;
                case "description":
                    if (!$this->check->title($value)) {
                        return "ERROR_DESCRIPTION";
                    }
                    break;
                case "country":
                    if (!$this->check->title($value)) {
                        return "ERROR_COUNTRY";
                    }
                    break;
                default:
                    return true;
            }
        }
        return true;
    }

    public function getImg($id)
    {
        return $this->getFieldOnID($id, "logo");
    }

    public function delete($id)
    {
        $oldImg = $this->getImg($id);
        if (parent::delete($id)) {
            unlink("../" . $this->config->dir_img_brands . $oldImg);
        } else {
            return false;
        }
        return true;
    }

    public function edit($id, $brand, $needCheck = true)
    {
        if (key_exists("logo", $brand)) {
            $newImg = $brand["logo"];
            $brand["logo"] = $brand["logo"]["name"];
            $oldImgName = $this->getImg($id);
        }
        if (parent::edit($id, $brand, $needCheck)) {
            if (key_exists("logo", $brand)) {
                if ($oldImgName) {
                    unlink("../" . $this->config->dir_img_brands . $oldImgName);
                }
                if (!$this->loadImage($newImg, $this->config->dir_img_brands)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public function add($brand, $needCheck = true)
    {
        $img = $brand["logo"];
        $brand["logo"] = $brand["logo"]["name"];
        if (parent::add($brand, $needCheck)) {
            return $this->loadImage($img, $this->config->dir_img_brands);
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
