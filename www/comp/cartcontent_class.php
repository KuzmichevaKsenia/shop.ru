<?php
require_once "modules_class.php";

class CartContent extends Modules
{

    protected $title = "Корзина Shop";
    protected $meta_desc = "Содержимое корзины в магазине дизайнерской женской одежды европейских бредов Shop";
    protected $meta_key = "корзина, содержимое корзины, магазин Shop, купить женскую одежду";

    protected function getContent()
    {
        $cart = array();
        $amount = 0;
        $all_count = 0;
        if ($_SESSION["cart"]) {
            $ids = array();
            foreach ($_SESSION["cart"] as $product_id => $units) {
                $ids[] = $product_id;
            }

            $ar_units = $this->unit->getAllOnFieldByValues("product_id", $ids);
            $units = array();
            foreach ($ar_units as $pr_id => $pr_units) {
                $units[$pr_id] = $this->setIdOnArrayKeys($pr_units);
            }

            $products = $this->setIdOnArrayKeys($this->product->getAllOnIDs($ids));

            foreach ($_SESSION["cart"] as $product_id => $arUnits) {
                foreach ($arUnits as $unit_id => $unit) {
                    foreach ($unit as $size_id => $count) {
                        $arSize = $this->size->get($size_id);
                        $all_count += $count;
                        $amount += $count * $products[$product_id]["price"];
                        $cart[] = array(
                            "link_to_product" => $products[$product_id]["link"],
                            "title" => $products[$product_id]["title"],
                            "brand" => $products[$product_id]["brand"],
                            "img" => $units[$product_id][$unit_id]["img"],
                            "size" => $arSize["size"],
                            "count" => $count,
                            "price" => $products[$product_id]["price"],
                            "cost" => $products[$product_id]["price"] * $count,
                            "link_add" => $this->url->addCart($product_id, $unit_id, $size_id),
                            "link_remove" => $this->url->removeCart($product_id, $unit_id, $size_id),
                            "link_delete" => $this->url->deleteCart($product_id, $unit_id, $size_id),
                        );
                    }
                }
            }
        }
        $this->template->set("amount", $amount);
        $this->template->set("count", $all_count);
        $this->template->set("cart", $cart);
        $this->template->set("link_order", $this->url->order());

        return "cart";
    }

    private function setIdOnArrayKeys($array)
    {
        $result = array();
        foreach ($array as $val) {
            $result[$val["id"]] = $val;
        }
        return $result;
    }
}
