<?php
require_once "modules_class.php";

class BrandContent extends Modules
{

    public function getContent()
    {

        $brand_info = $this->brand->get($this->data["id"]);
        if (!$brand_info) {
            return $this->notFound();
        }
        $this->title = "Shop " . $brand_info["title"] . " " . $brand_info["country"];
        $this->meta_desc = "Женская одежда бренда " . $brand_info["title"] . ". " . $brand_info["country"] . ". " . $brand_info["description"];
        $this->meta_key = mb_strtolower("брендовая женская одежда, " . $brand_info["title"] . ", одежда " . $brand_info["country"] . ", купить " . $brand_info["title"] . ", одежда " . $brand_info["title"] . ", цена " . $brand_info["title"] . ", магазин модной женской одежды, магазин официальный сайт женская одежда");

        $this->setLinkSort();
        $sort = $this->data["sort"];
        $up = $this->data["up"];
        $this->template->set("brand_description", $brand_info["description"]);
        $this->template->set("products_img", $brand_info["logo"]);
        $this->template->set("products_title", $brand_info["title"]);

        $products = $this->product->getAllOnBrandID($brand_info["id"], $sort, $up);
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
