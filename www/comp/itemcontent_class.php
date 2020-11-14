<?php
require_once "modules_class.php";

class ItemContent extends Modules
{

    public function getContent()
    {

        $item_info = $this->item->get($this->data["id"]);
        if (!$item_info) {
            return $this->notFound();
        }
        $this->title = "Shop " . $item_info["title"];
        $this->meta_desc = "Дизайнерская женская одежда европейских брендов в магазине Shop из раздела " . $item_info["title"] . ".";
        $this->meta_key = mb_strtolower("женская одежда, " . $item_info["title"] . ", " . $item_info["title"] . " купить, куплю магазин женской одежды, женская одежда интернет магазин в розницу, купить женскую одежду в интернет магазине, интернет магазин женской одежды, женская одежда каталог магазин, одежда интернет магазин каталог женский");

        $this->setLinkSort();
        $sort = $this->data["sort"];
        $up = $this->data["up"];
        $this->template->set("products_img", $item_info["img"]);
        $this->template->set("products_title", $item_info["title"]);

        $products = $this->product->getAllOnItemID($item_info["id"], $sort, $up);
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

        if ($sort == "title") {
            $this->title = $this->title . " каталог";
            $this->meta_desc = $this->meta_desc . " Каталог";
            if ($up == 1) {
                $this->title = $this->title . " женской одежды";
                $this->meta_desc = $this->meta_desc . " женской одежды";
            }
        } elseif ($sort == "price") {
            $this->title = $this->title . " каталог";
            $this->meta_desc = $this->meta_desc . " Каталог";
            if ($up == 1) {
                $this->title = $this->title . " цены";
                $this->meta_desc = $this->meta_desc . ", цены";
            }
        }

        return "index";
    }

}
