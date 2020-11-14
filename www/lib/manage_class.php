<?php
require_once "config_class.php";
require_once "format_class.php";
require_once "product_class.php";
require_once "unit_class.php";
require_once "size_class.php";
require_once "order_class.php";
require_once "discount_class.php";
require_once "systemmessage_class.php";
require_once "mail_class.php";

class Manage
{

    protected $config;
    protected $format;
    protected $product;
    protected $unit;
    protected $size;
    protected $order;
    protected $discount;
    protected $sm;
    protected $mail;
    protected $data;

    public function __construct()
    {
        session_start();
        $this->config = new Config();
        $this->format = new Format();
        $this->product = new Product();
        $this->unit = new Unit();
        $this->size = new Size();
        $this->order = new Order();
        $this->discount = new Discount();
        $this->sm = new SystemMessage();
        $this->mail = new Mail();
        $this->data = $this->format->xss($_REQUEST);
        $this->saveData();
    }

    private function saveData()
    {
        foreach ($this->data as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function addCart($id = false, $unit_id = false, $size_id = false)
    {
        if (!$id) {
            $id = $this->data["id"];
        }
        if (!$unit_id) {
            $unit_id = $this->data["unit_id"];
        }
        if (!$size_id) {
            $size_id = $this->data["size_id"];
        }
        if (!$this->unit->existsItem($unit_id, $id, $size_id)) {
            return false;
        }

        if (isset($_SESSION["cart"][$id][$unit_id][$size_id])) {
            $_SESSION["cart"][$id][$unit_id][$size_id]++;
        } else {
            $_SESSION["cart"][$id][$unit_id][$size_id] = 1;
        }
    }

    public function removeCart()
    {
        $id = $this->data["id"];
        $unit_id = $this->data["unit_id"];
        $size_id = $this->data["size_id"];
        if (isset($_SESSION["cart"][$id][$unit_id][$size_id])) {
            $_SESSION["cart"][$id][$unit_id][$size_id]--;
            if ($_SESSION["cart"][$id][$unit_id][$size_id] == 0) {
                unset($_SESSION["cart"][$id][$unit_id][$size_id]);
                if (empty($_SESSION["cart"][$id][$unit_id])) {
                    unset($_SESSION["cart"][$id][$unit_id]);
                    if (empty($_SESSION["cart"][$id])) {
                        unset($_SESSION["cart"][$id]);
                    }
                }
            }
        }
    }

    public function deleteCart()
    {
        $id = $this->data["id"];
        $unit_id = $this->data["unit_id"];
        $size_id = $this->data["size_id"];
        if (isset($_SESSION["cart"][$id][$unit_id][$size_id])) {
            unset($_SESSION["cart"][$id][$unit_id][$size_id]);
            if (empty($_SESSION["cart"][$id][$unit_id])) {
                unset($_SESSION["cart"][$id][$unit_id]);
                if (empty($_SESSION["cart"][$id])) {
                    unset($_SESSION["cart"][$id]);
                }
            }
        }
    }

    public function addOrder()
    {
        $temp_data = array();
        $temp_data["delivery"] = $this->data["delivery"];
        $temp_data["price"] = $this->getPrice();
        $temp_data["name"] = $this->data["name"];
        $temp_data["phone"] = $this->data["phone"];
        $temp_data["email"] = $this->data["email"];
        $temp_data["address"] = $this->data["address"];
        $temp_data["notice"] = $this->data["notice"];
        $temp_data["date_order"] = $this->format->ts();
        $temp_data["date_send"] = 0;
        $temp_data["units"] = $this->getUnits();
        if ($this->order->add($temp_data)) {
            $send_data = array();
            $send_data["products"] = $this->getProducts();
            $send_data["name"] = $temp_data["name"];
            $send_data["phone"] = $temp_data["phone"];
            $send_data["email"] = $temp_data["email"];
            $send_data["address"] = ($temp_data["delivery"] == 1) ? "Самовывоз из магазина по адресу г. Москва, ул. Московская, 1, ст. м. Московская, ТЦ \"Shop\" (ежедневно с 10:00 до 21:00)" : "Доставка по адресу " . $temp_data["address"];
            $send_data["notice"] = ($temp_data["notice"] == "") ? "-" : $temp_data["notice"];
            $send_data["price"] = $temp_data["price"];
            $to = $temp_data["email"];
            $this->mail->send($to, $send_data, "ORDER");
            $this->mail->sendToAdmin($send_data, "NOTIFICATION");
            $_SESSION["cart"] = array();
            return $this->sm->pageMessage("ADD_ORDER");
        }
        return false;
    }

    private function getProducts()
    {
        $style = "<style type='text/css'>
            table {
            font-family: 'Lucida Sans Unicode', 'Lucida Grande', Sans-Serif;
            font-size: 14px;
            border-radius: 10px;
            border-spacing: 0;
            text-align: center;
            width: 100%;
            }
            th {
            background: #BCEBDD;
            color: white;
            text-shadow: 0 1px 1px #2D2020;
            padding: 10px 20px;
            }
            th, td {
            border-style: solid;
            border-width: 0 1px 1px 0;
            border-color: white;
            }
            th:first-child, td:first-child {
            text-align: left;
            }
            th:first-child {
            border-top-left-radius: 10px;
            }
            th:last-child {
            border-top-right-radius: 10px;
            border-right: none;
            }
            td {
            padding: 10px 20px;
            background: #F8E391;
            }
            tr:last-child td:first-child {
            border-radius: 0 0 0 10px;
            }
            tr:last-child td:last-child {
            border-radius: 0 0 10px 0;
            }
            tr td:last-child {
            border-right: none;
            }
        </style>";
        $result = $style . "<table style='border:1px solid black; width: 100%'><tr><th colspan='2'>Товар</th><th>Количество</th><th>Цена</th><th>Стоимость</th></tr>";
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
                    $result .= "<tr>
                                    <td>
                                        <a href='" . $products[$product_id]["link"] . "'>
                                            <img src='" . $units[$product_id][$unit_id]["img"] . "' width='50px'/> 
                                        </a>
                                    </td>
                                    <td>
                                        <a href='" . $products[$product_id]["link"] . "'>"
                        . $products[$product_id]["title"] . " " . $products[$product_id]["brand"]
                        . "<br>Артикул: " . $products[$product_id]["code_name"]
                        . "<br>Цвет: " . $units[$product_id][$unit_id]["color_title"]
                        . "<br>Размер: " . $arSize["size"] . "
                                        </a>
                                    </td>
                                    <td>" . $count . " шт.</td>
                                    <td>" . $products[$product_id]["price"] . " руб.</td>
                                    <td>" . $products[$product_id]["price"] * $count . " руб.</td>
                                </tr>";
                }
            }
        }
        return $result . "</table>";
    }

    private function getPrice()
    {
        $ids = array();
        foreach ($_SESSION["cart"] as $product_id => $units) {
            foreach ($units as $sizes) {
                foreach ($sizes as $count) {
                    for ($i = 1; $i <= $count; $i++) {
                        $ids[] = $product_id;
                    }
                }
            }
        }
        return $this->product->getPriceOnIDs($ids);
    }

    private function getUnits()
    {
        $result = "";
        foreach ($_SESSION["cart"] as $units) {
            foreach ($units as $unit_id => $sizes) {
                foreach ($sizes as $sizes_id => $count) {
                    $result .= $unit_id . ":" . $sizes_id . ":" . $count . ";";
                }
            }
        }
        return $result;
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
