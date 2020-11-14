<?php
require_once "adminform_class.php";

class AdminOrdersContent extends AdminForm
{

    protected $title = "Заказы";
    protected $meta_data = "Страница с заказами";
    protected $maeta_key = "заказы, список заказов";

    protected function getFormData()
    {
        $this->template->set("products_all", $this->getAllProducts());
        $form_data = array();
        $form_data["fields"] = array("delivery", "units", "price", "name", "phone", "email", "address", "notice", "date_send");
        $form_data["func_add"] = "add_order";
        $form_data["func_edit"] = "edit_order";
        $form_data["title_add"] = "Добавление заказа";
        $form_data["title_edit"] = "Редактирование заказа";
        $form_data["get"] = $this->order->get($this->data["id"]);
        $form_data["form_t"] = "order_form";
        $form_data["t"] = "orders";
        $form_data["obj"] = $this->order;
        $table_data = $this->order->getTableData($this->config->pagination_count, $this->page_info["offset"]);
        for ($i = 0; $i < count($table_data); $i++) {
            $table_data[$i]["products"] = $this->getProductsInfo($table_data[$i]["ar_units"], $this->getUnitsInfo($table_data[$i]["ar_units"]));
        }
        $form_data["table_data"] = $table_data;

        if ($this->data["func"] == "new") {
            $ar_units = $_SESSION["product_ids"];
        } elseif ($this->data["func"] == "edit") {
            $ar_units = $this->order->getProductIDs($this->data["id"]);
        }
        $this->template->set("products", $this->getProductsInfo($ar_units, $this->getUnitsInfo($ar_units)));

        return $form_data;
    }

    private function getUnitsInfo($arUnits)
    {
        $units = array();
        if ($arUnits) {
            $pre_units = $this->unit->getAllOnIDs(array_keys($arUnits));
            foreach ($pre_units as &$unit) {
                $sizes = array();
                foreach ($unit["sizes"] as $arSize) {
                    $sizes[$arSize["id"]] = $arSize["size"];
                }
                $unit["sizes"] = $sizes;
                $units[$unit["id"]] = array_merge($this->product->get($unit["product_id"], $this->item->getTableName()), $unit);
            }
        }
        return $units;
    }

    private function getProductsInfo($arUnits, $units)
    {
        $products = array();
        if ($arUnits) {
            $j = 0;
            foreach ($arUnits as $unit_id => $unit_items) {
                foreach ($unit_items as $unit_item) {
                    $products[$j]["unit_id"] = $unit_id;
                    $products[$j]["product_id"] = $units[$unit_id]["product_id"];
                    $products[$j]["code_name"] = $units[$unit_id]["code_name"];
                    $products[$j]["title"] = $units[$unit_id]["title"];
                    $products[$j]["img"] = $units[$unit_id]["img"];
                    $products[$j]["size"] = $units[$unit_id]["sizes"][$unit_item["size"]];
                    $products[$j]["count"] = $unit_item["count"];
                    $products[$j]["brand"] = $units[$unit_id]["brand"];
                    $products[$j]["link"] = $units[$unit_id]["link"];
                    $products[$j]["color"] = $units[$unit_id]["color"];
                    $products[$j]["color_title"] = $units[$unit_id]["color_title"];
                    $j++;
                }
            }
        }
        return $products;
    }

    private function getAllProducts()
    {
        $products_all = $this->setArrayUniqKeyAndClear(
            $this->product->getAllBigData(),
            "id",
            array("item_id", "collection", "composition", "date", "before_sale_price", "brand_link", "link_admin_edit", "link_admin_delete")
        );
        $units_all = $this->setArrayUniqKeyAndClear($this->unit->getAllData(),
            "id",
            array("color_id", "size_ids", "availability", "link_cart")
        );
        foreach ($units_all as $unit) {
            $products_all[$unit["product_id"]]["units"][$unit["id"]] = $unit;
        }
        return $products_all;
    }

    private function setArrayUniqKeyAndClear($array, $uniqKey, $blackListKeys)
    {
        $result = array();
        foreach ($array as &$arr) {
            foreach ($blackListKeys as $blackListKey) {
                if (key_exists($blackListKey, $arr)) {
                    unset($arr[$blackListKey]);
                }
            }
            $result[$arr[$uniqKey]] = $arr;
        }
        return $result;
    }
}
