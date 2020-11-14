<?php
require_once "manage_class.php";
require_once "urladmin_class.php";
require_once "auth_class.php";
require_once "item_class.php";
require_once "brand_class.php";
require_once "color_class.php";

class ManageAdmin extends Manage
{

    private $url_admin;
    private $item;
    private $brand;
    private $color;

    public function __construct()
    {
        parent::__construct();
        $this->url_admin = new URLAdmin();
        $this->item = new Item();
        $this->brand = new Brand();
        $this->color = new Color();
    }

    public function auth()
    {
        $auth = new Auth();
        $_SESSION["login"] = $this->data["login"];
        $_SESSION["password"] = $this->format->hash($this->data["password"]);
        if ($auth->checkAdmin($_SESSION["login"], $_SESSION["password"])) {
            return $this->data["r"];
        } else {
            return $this->sm->message("ERROR_AUTH");
        }
    }

    public function logout()
    {
        unset($_SESSION["login"]);
        unset($_SESSION["password"]);
    }

    /*
     * В добавлении и изменении продуктов проверка здесь, а не в global,
     * так как нужно проверить и product, и units, а потом уже добавлять или редактировать.
     *
     * В global после проверки сразу производится операция.
     * */

    public function addProduct()
    {
        $temp_data = $this->dataProduct();
        $temp_data["date"] = $this->format->ts();
        $temp_data["id"] = strtoupper(preg_replace("/[^a-zA-Z0-9]/iu", '', $temp_data["code_name"]));
        if ($temp_data["before_sale_price"] == "") {
            $temp_data["before_sale_price"] = $temp_data["price"];
        }
        $units = $temp_data["units"];
        unset($temp_data["units"]);
        $result = $this->product->checkData($temp_data);
        if ($result !== true) {
            return $this->sm->message($result);
        }
        if (empty($units)) {
            return $this->sm->message("ERROR_UNITS");
        }
        foreach ($units as $key => $unit) {
            $units[$key]["product_id"] = $temp_data["id"];
            $result = $this->unit->checkData($unit, true);
            if ($result !== true) {
                return $this->sm->message($result);
            }
        }
        if ($this->product->add($temp_data, false)) {
            foreach ($units as $unit) {
                if (!$this->unit->add($unit)) {
                    return false;
                }
            }
            $this->sm->message("SUCCESS_ADD_PRODUCT", false, "green");
            return $this->url_admin->products();
        }
        return false;
    }

    public function editProduct()
    {
        $temp_data = $this->dataProduct();
        if ($temp_data["before_sale_price"] == "") {
            $temp_data["before_sale_price"] = $temp_data["price"];
        }
        $price = $temp_data["price"];
        $beforeSalePrice = $temp_data["before_sale_price"];
        $units = $temp_data["units"];
        unset($temp_data["units"]);
        $oldProduct = $this->product->getByIdUntransform($this->data["id"]);
        foreach ($temp_data as $field => $newVal) {
            if ($oldProduct[$field] == $newVal) {
                unset($temp_data[$field]);
            }
        }
        if (key_exists("price", $temp_data) && !key_exists("before_sale_price", $temp_data)) {
            $temp_data["before_sale_price"] = $beforeSalePrice;
        }
        if (key_exists("before_sale_price", $temp_data) && !key_exists("price", $temp_data)) {
            $temp_data["price"] = $price;
        }
        $result = $this->product->checkData($temp_data, $this->data["id"]);
        if ($result !== true) {
            return $this->sm->message($result);
        }
        if (empty($units)) {
            return $this->sm->message("ERROR_UNITS");
        }
        $pre_oldUnits = $this->unit->getByProductIdUnTrunsform($this->data["id"]);
        $unitsToDelete = array();
        $oldUnits = array();
        foreach ($pre_oldUnits as $oldUnit) {
            if (!key_exists($oldUnit["id"], $units)) {
                $unitsToDelete[] = $oldUnit["id"];
            } else {
                $oldUnits[$oldUnit["id"]] = $oldUnit;
                unset($oldUnits[$oldUnit["id"]]["id"]);
            }
        }
        foreach ($units as $id => &$unit) {
            $unit["product_id"] = $this->data["id"];
            if (stristr($id, 'newunitid') === FALSE) {
                foreach ($unit as $field => $newVal) {
                    if ($oldUnits[$id][$field] == $newVal || $field == "img" && $newVal["name"] == "") {
                        unset($unit[$field]);
                    }
                }
            }
            if (empty($unit)) {
                continue;
            }
            $result = $this->unit->checkData($unit, true);
            if ($result !== true) {
                return $this->sm->message($result);
            }
        }
        if (!empty($temp_data) && !$this->product->edit($this->data["id"], $temp_data, false)) {
            return false;
        }
        foreach ($units as $id => $uniqUnit) {
            if (empty($uniqUnit)) {
                continue;
            }
            if (stristr($id, 'newunitid') === FALSE) {
                if (!$this->unit->edit($id, $uniqUnit)) {
                    return false;
                }
            } elseif (!$this->unit->add($uniqUnit)) {
                return false;
            }
        }
        foreach ($unitsToDelete as $unitIdToDelete) {
            if (!$this->unit->delete($unitIdToDelete)) {
                return false;
            }
        }
        return $this->sm->message("SUCCESS_EDIT_PRODUCT", false, "green");
    }

    public function deleteProduct()
    {
        $units = $this->unit->getByProductIdUnTrunsform($this->data["id"]);
        foreach ($units as $unit) {
            if (!$this->unit->delete($unit["id"])) {
                return false;
            }
        }
        if ($this->product->delete($this->data["id"])) {
            return $this->sm->message("SUCCESS_DELETE_PRODUCT", false, "green");
        } else {
            return $this->sm->unknownError();
        }
    }

    public function addItem()
    {
        $temp_data = array(
            "title" => $this->data["item_title"],
            "img" => $_FILES["img"],
        );
        if ($this->item->add($temp_data)) {
            $this->sm->message("SUCCESS_ADD_ITEM", false, "green");
            return $this->url_admin->items();
        } else {
            return false;
        }
    }

    public function editItem()
    {
        $oldItem = $this->item->getByIdUntransform($this->data["id"]);
        $temp_data = array();
        if ($oldItem["title"] != $this->data["item_title"]) {
            $temp_data["title"] = $this->data["item_title"];
        }
        if ($_FILES["img"]["name"] != "") {
            $temp_data["img"] = $_FILES["img"];
        }
        if (!empty($temp_data) && !$this->item->edit($this->data["id"], $temp_data)) {
            return false;
        }
        $this->sm->message("SUCCESS_EDIT_ITEM", false, "green");
        return $this->url_admin->items();
    }

    public function deleteItem()
    {
        if ($this->item->delete($this->data["id"])) {
            return $this->sm->message("SUCCESS_DELETE_ITEM", false, "green");
        } else {
            return $this->sm->unknownError();
        }
    }

    public function addBrand()
    {
        $temp_data = array();
        $temp_data["title"] = $this->data["brand_title"];
        $temp_data["description"] = $this->data["description"];
        $temp_data["country"] = $this->data["country"];
        $temp_data["logo"] = $_FILES["img"];
        if ($this->brand->add($temp_data)) {
            $this->sm->message("SUCCESS_ADD_BRAND", false, "green");
            return $this->url_admin->brands();
        } else {
            return false;
        }
    }

    public function editBrand()
    {
        $oldBrand = $this->brand->getByIdUntransform($this->data["id"]);
        $temp_data = array();
        if ($oldBrand["title"] != $this->data["brand_title"]) {
            $temp_data["title"] = $this->data["brand_title"];
        }
        if ($oldBrand["description"] != $this->data["description"]) {
            $temp_data["description"] = $this->data["description"];
        }
        if ($oldBrand["country"] != $this->data["country"]) {
            $temp_data["country"] = $this->data["country"];
        }
        if ($_FILES["img"]["name"] != "") {
            $temp_data["logo"] = $_FILES["img"];
        }
        if (!empty($temp_data) && !$this->brand->edit($this->data["id"], $temp_data)) {
            return false;
        }
        $this->sm->message("SUCCESS_EDIT_BRAND", false, "green");
        return $this->url_admin->brands();
    }

    public function deleteBrand()
    {
        if ($this->brand->delete($this->data["id"])) {
            return $this->sm->message("SUCCESS_DELETE_BRAND", false, "green");
        } else {
            return $this->sm->unknownError();
        }
    }

    public function addColor()
    {
        $temp_data = array();
        $temp_data["title"] = $this->data["color_title"];
        $temp_data["color"] = $this->data["color"];
        if ($this->color->add($temp_data)) {
            $this->sm->message("SUCCESS_ADD_COLOR", false, "green");
            return $this->url_admin->colors();
        } else {
            return false;
        }
    }

    public function editColor()
    {
        $temp_data = array();
        $temp_data["title"] = $this->data["color_title"];
        $temp_data["color"] = $this->data["color"];
        if (!$this->color->edit($this->data["id"], $temp_data)) {
            return false;
        }
        $this->sm->message("SUCCESS_EDIT_COLOR", false, "green");
        return $this->url_admin->colors();
    }

    public function deleteColor()
    {
        if ($this->color->delete($this->data["id"])) {
            return $this->sm->message("SUCCESS_DELETE_COLOR", false, "green");
        } else {
            return $this->sm->unknownError();
        }
    }

    public function addOrder()
    {
        $temp_data = $this->dataOrder();
        $temp_data["date_order"] = $this->format->ts();
        if ($this->data["is_send"] != 0) {
            $temp_data["date_send"] = $this->format->ts();
        } else {
            $temp_data["date_send"] = 0;
        }
        if ($this->order->add($temp_data)) {
            $this->sm->message("SUCCESS_ADD_ORDER", false, "green");
            return $this->url_admin->orders();
        } else {
            return false;
        }
    }

    public function editOrder()
    {
        $temp_data = $this->dataOrder();
        $temp_data["date_order"] = $this->order->getDateOrder($this->data["id"]);
        $date_send = $this->order->getDateSend($this->data["id"]);
        if (($this->data["is_send"]) && ($date_send == 0)) {
            $temp_data["date_send"] = $this->format->ts();
        } elseif (($this->data["is_send"]) && ($date_send != 0)) {
            $temp_data["date_send"] = $date_send;
        } else {
            $temp_data["date_send"] = 0;
        }
        if ($this->order->edit($this->data["id"], $temp_data)) {
            return $this->sm->message("SUCCESS_EDIT_ORDER", false, "green");
        } else {
            return false;
        }
    }

    public function deleteOrder()
    {
        if ($this->order->delete($this->data["id"])) {
            $this->sm->message("SUCCESS_DELETE_ORDER", false, "green");
            return $this->url_admin->orders();
        } else {
            return $this->sm->unknownError();
        }
    }

    private function dataOrder()
    {
        $temp_data = array();
        $arDataOrderUnits = array();
        foreach ($this->data as $field => $value) {
            if ($field == "delivery"
                || $field == "price"
                || $field == "name"
                || $field == "phone"
                || $field == "email"
                || $field == "address"
                || $field == "notice"
            ) {
                $temp_data[$field] = $value;
            } elseif ($field == "id" || $field == "func" || $field == "is_send") {
                continue;
            } elseif (stristr($field, 'unit_') !== FALSE) {
                $unitField = "unit";
                if (stristr($field, 'unit_size_count_') !== FALSE) {
                    $unitField = "count";
                } elseif (stristr($field, 'unit_size_') !== FALSE) {
                    $unitField = "size";
                }
                $arr_field = explode("_", $field);
                $arDataOrderUnits[array_pop($arr_field)][$unitField] = $value;
            }
        }
        $temp_data["units"] = "";
        foreach ($arDataOrderUnits as $arDataOrderUnit) {
            $temp_data["units"] .= $arDataOrderUnit["unit"] . ":" . $arDataOrderUnit["size"] . ":" . $arDataOrderUnit["count"] . ";";
        }
        $_SESSION["units"] = $temp_data["units"];
        return $temp_data;
    }

    public function dataProduct()
    {
        $temp_data = array();
        $this->data = array_merge($this->data, $_FILES);
        $imgCnt = 0;
        foreach ($this->data as $field => $value) {
            if ($field == "code_name"
                || $field == "item_id"
                || $field == "brand_id"
                || $field == "collection"
                || $field == "composition"
                || $field == "price"
                || $field == "before_sale_price"
            ) {
                $temp_data[$field] = $value;
            } elseif ($field == "pr_title") {
                $temp_data["title"] = $value;
            } elseif ($field == "id" || $field == "func") {
                continue;
            } else {
                $arField = explode("-", $field);
                if ($arField[0] == "img") {
                    $value["name"] = str_replace(".", ++$imgCnt . ".", preg_replace("/[^a-zA-Zа-яА-Я0-9.]/iu", '', $value["name"]));
                }
                $temp_data["units"][$arField[1]][$arField[0]] = $value;
            }
        }

        return $temp_data;
    }

}
