<?php
require_once "modules_class.php";

class Content extends Modules
{ //главная страница

    protected $title = "Shop - магазин дизайнерской женской одежды европейских брендов";
    protected $meta_desc = "Женская одежда Shop. Индивидуальный подход к каждому клиенту. Примерка в магазине либо с доставкой на дом. Услуги личного стилиста. Одежда из Польши, Италии, Литвы, Германии.";
    protected $meta_key = "женская одежда shop, женская одежда Москва, женская одежда shop, магазин одежды официальный сайт";

    public function getContent()
    {
        $this->setLinkSort();
        $sort = $this->data["sort"];
        $up = $this->data["up"];
        $this->template->set("products_img", "images/items/new.png");
        $this->template->set("products_title", "Новинки");

        $products = $this->product->getAllSort($sort, $up, $this->config->count_on_page);
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
                $this->title = $this->title . " новинки";
                $this->meta_desc = $this->meta_desc . " новинки";
            }
        } elseif ($sort == "price") {
            $this->title = $this->title . " новинки";
            $this->meta_desc = $this->meta_desc . " Новинки";
            if ($up == 1) {
                $this->title = $this->title . " цены";
                $this->meta_desc = $this->meta_desc . " цены";
            }
        }

        return "index";
    }

}
