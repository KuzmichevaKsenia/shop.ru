<?php
require_once "modules_class.php";

class SaleContent extends Modules
{

    protected $title = "Распродажа в интернет-магазине женской одежды";
    protected $meta_desc = "Акции в магазине Shop. Покупай со скидкой брендовую дизайнерскую женскую одежду. Низкие цены на качественную женскую одежду.";
    protected $meta_key = "распродажа одежды, Shop акции, распродажа женской одежды, магазин женской одежды распродажа, интернет магазин женской одежды акции бесплатная доставка, интернет магазин женской одежды каталог распродажа, магазин женской одежды акция, акции женская одежда интернет магазин, одежда скидка";

    public function getContent()
    {
        $this->setLinkSort();
        $sort = $this->data["sort"];
        $up = $this->data["up"];
        $this->template->set("products_img", "images/items/sale.png");
        $this->template->set("products_title", "Распродажа");

        $products = $this->product->getAllOnSale($sort, $up);

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
            $this->title = $this->title . " одежды";
            $this->meta_desc = $this->meta_desc . " Каталог";
            if ($up == 1) {
                $this->title = $this->title . " каталог";
                $this->meta_desc = $this->meta_desc . " женской одежды";
            }
        } elseif ($sort == "price") {
            $this->title = $this->title . " скидки";
            $this->meta_desc = $this->meta_desc . " Каталог";
            if ($up == 1) {
                $this->title = $this->title . " цены";
                $this->meta_desc = $this->meta_desc . ", цены";
            }
        }

        return "index";
    }

}
