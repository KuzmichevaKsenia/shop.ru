<?php
require_once "modules_class.php";

class ProductContent extends Modules
{

    public function getContent()
    {

        $product_info = $this->product->get($this->data["id"], $this->item->getTableName());
        if (!$product_info) {
            return $this->notFound();
        }
        $units = $this->unit->getAllOnFieldByValues("product_id", array($this->data["id"]));
        $product_info["units"] = $units[strtoupper($this->data["id"])];

        $this->title = "Shop " . $product_info["title"] . " " . $product_info["brand"] . " " . $product_info["code_name"];
        $this->meta_desc = $product_info["title"] . " " . $product_info["brand"] . " " . $product_info["code_name"] . ": коллекция, цвета, размеры, наличие, цена, запись на примерку.";
        $this->meta_key = mb_strtolower("женская одежда, купить " . $product_info["title"] . " " . $product_info["brand"] . ", " . $product_info["title"] . " " . $product_info["brand"] . ", купить " . $product_info["title"] . ", магазин одежда, одежда купить, модная лавка интернет магазин женской одежды, магазин женской одежды");
        $this->template->set("product", $product_info);

        $products = $this->product->getOthers($product_info, $this->config->count_others);
        $prod_ids = array();
        if ($products) {
            foreach ($products as $product) {
                if (!in_array($product["id"], $prod_ids)) {
                    $prod_ids[] = $product["id"];
                }
            }
            $units = $this->unit->getAllOnFieldByValues("product_id", $prod_ids);
            foreach ($products as &$product) {
                $product["units"] = $units[$product["id"]];
            }
        }

        $this->template->set("products", $products);

        return "product";
    }

}
