<?php
require_once "config_class.php";

class URL
{

    protected $config;
    protected $amp; //нужно ли заменять амперсанды на сущности ('да' по умолчанию)

    public function __construct($amp = true)
    {
        $this->config = new Config();
        $this->amp = $amp;
    }

    public function getView()
    {
        $view = $_SERVER["REQUEST_URI"];
        $view = substr($view, 1); //убираем слэш в начале
        if (($pos = strpos($view, "?")) !== false) {
            $view = substr($view, 0, $pos); //обрезаем get-параметр, если он есть
        }
        return $view;
    }

    public function setAMP($amp)
    {
        $this->amp = $amp;
    }

    public function getThisURL()
    {
        $uri = substr($_SERVER["REQUEST_URI"], 1);
        return $this->config->address . $uri;
    }

    protected function deleteGet($url, $param)
    {
        $res = $url;
        if (($p = strpos($res, "?")) !== false) {
            $paramstr = substr($res, $p + 1);
            $params = explode("&", $paramstr);
            $paramsarr = array();
            foreach ($params as $value) {
                $tmp = explode("=", $value);
                $paramsarr[$tmp[0]] = $tmp[1];
            }
            if (array_key_exists($param, $paramsarr)) {
                unset($paramsarr[$param]);
                $res = substr($res, 0, $p + 1);
                foreach ($paramsarr as $key => $value) {
                    $str = $key;
                    if ($value !== "") {
                        $str .= "=$value";
                    }
                    $res .= "$str&";
                }
                $res = substr($res, 0, -1);
            }
        }
        return $res;
    }

    public function index()
    {
        return $this->returnURL("");
    }

    public function notFound()
    {
        return $this->returnURL("notfound");
    }

    public function cart()
    {
        return $this->returnURL("cart");
    }

    public function order()
    {
        return $this->returnURL("order");
    }

    public function message()
    {
        return $this->returnURL("message");
    }

    public function sale()
    {
        return $this->returnURL("sale");
    }

    public function help()
    {
        return $this->returnURL("help");
    }

    public function style()
    {
        return $this->returnURL("style");
    }

    public function about()
    {
        return $this->returnURL("about");
    }

    public function search()
    {
        return $this->returnURL("search");
    }

    public function item($id)
    {
        return $this->returnURL("item?id=$id");
    }

    public function brand($id)
    {
        return $this->returnURL("brand?id=$id");
    }

    public function product($id)
    {
        return $this->returnURL("product?id=$id");
    }

    public function addCart($id, $unit_id, $size_id)
    {
        return $this->returnURL("functions.php?func=add_cart&id=$id&unit_id=$unit_id&size_id=$size_id");
    }

    public function removeCart($id, $unit_id, $size_id)
    {
        return $this->returnURL("functions.php?func=remove_cart&id=$id&unit_id=$unit_id&size_id=$size_id");
    }

    public function deleteCart($id, $unit_id, $size_id)
    {
        return $this->returnURL("functions.php?func=delete_cart&id=$id&unit_id=$unit_id&size_id=$size_id");
    }

    public function sortTitleUp()
    {
        return $this->sortOnField("title", 1);
    }

    public function sortTitleDown()
    {
        return $this->sortOnField("title", 0);
    }

    public function sortPriceUp()
    {
        return $this->sortOnField("price", 1);
    }

    public function sortPriceDown()
    {
        return $this->sortOnField("price", 0);
    }

    public function action()
    {
        return $this->returnURL("functions.php");
    }

    public function adminEditProduct($id)
    {
        return $this->returnURL("?view=products&func=edit&id=$id", $this->config->address_admin);
    }

    public function adminDeleteProduct($id)
    {
        return $this->returnURL("functions.php?func=delete_product&id=$id", $this->config->address_admin);
    }

    public function adminEditItem($id)
    {
        return $this->returnURL("?view=items&func=edit&id=$id", $this->config->address_admin);
    }

    public function adminDeleteItem($id)
    {
        return $this->returnURL("functions.php?func=delete_item&id=$id", $this->config->address_admin);
    }

    public function adminEditBrand($id)
    {
        return $this->returnURL("?view=brands&func=edit&id=$id", $this->config->address_admin);
    }

    public function adminDeleteBrand($id)
    {
        return $this->returnURL("functions.php?func=delete_brand&id=$id", $this->config->address_admin);
    }

    public function adminEditOrder($id)
    {
        return $this->returnURL("?view=orders&func=edit&id=$id", $this->config->address_admin);
    }

    public function adminDeleteOrder($id)
    {
        return $this->returnURL("functions.php?func=delete_order&id=$id", $this->config->address_admin);
    }

    public function adminEditDiscount($id)
    {
        return $this->returnURL("?view=discounts&func=edit&id=$id", $this->config->address_admin);
    }

    public function adminDeleteDiscount($id)
    {
        return $this->returnURL("functions.php?func=delete_discount&id=$id", $this->config->address_admin);
    }

    public function adminEditColor($id)
    {
        return $this->returnURL("?view=colors&func=edit&id=$id", $this->config->address_admin);
    }

    public function adminDeleteColor($id)
    {
        return $this->returnURL("functions.php?func=delete_color&id=$id", $this->config->address_admin);
    }

    protected function sortOnField($field, $up)
    {
        $this_url = $this->getThisURL();
        $this_url = $this->deleteGet($this_url, "up");
        $this_url = $this->deleteGet($this_url, "sort");
        if (strpos($this_url, "?") === false) {
            $url = $this_url . "?sort=$field&up=$up";
        } else {
            $url = $this_url . "&sort=$field&up=$up";
        }
        return $this->returnURL($url);
    }

    protected function returnURL($url, $index = false)
    {
        if (!$index) {
            $index = $this->config->address;
        }
        if ($url == "") {
            return $index;
        }
        if (strpos($url, $index) !== 0) {
            $url = $index . $url;
        }
        if ($this->amp) {
            $url = str_replace("&", "&amp;", $url);
        }
        return $url;
    }

    public function fileExists($file)
    {
        $arr = explode(PATH_SEPARATOR, get_include_path());
        foreach ($arr as $val) {
            if (file_exists($val . "/" . $file)) {
                return true;
            }
        }
        return false;
    }

}
