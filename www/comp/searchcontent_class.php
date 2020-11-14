<?php
require_once "modules_class.php";

class SearchContent extends Modules
{

    public function getContent()
    {
        $q = $this->data["q"];
        $this->title = "Shop одежда $q";
        $this->meta_desc = "Одежда магазина Shop $q.";
        $this->meta_key = preg_replace("/\s+/i", ", ", mb_strtolower($q));

        $this->setLinkSort();
        $sort = $this->data["sort"];
        $up = $this->data["up"];
        $this->template->set("q", $q);
        $this->template->set("products_img", $this->config->dir_img_items . "search.png");
        $this->template->set("products_title", "Поиск");

        $products = $this->product->search($q, $sort, $up);

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

        return "search";
    }

}
