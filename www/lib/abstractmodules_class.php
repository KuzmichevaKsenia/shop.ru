<?php
require_once "config_class.php";
require_once "url_class.php";
require_once "format_class.php";
require_once "template_class.php";
require_once "item_class.php";
require_once "brand_class.php";
require_once "product_class.php";
require_once "color_class.php";
require_once "size_class.php";
require_once "unit_class.php";
require_once "discount_class.php";
require_once "message_class.php";
require_once "order_class.php";

abstract class AbstractModules
{

    protected $config;
    protected $data;
    protected $url;
    protected $format;
    protected $item;
    protected $brand;
    protected $product;
    protected $color;
    protected $size;
    protected $unit;
    protected $discount;
    protected $message;
    protected $order;
    protected $template;

    public function __construct()
    {
        session_start();
        $this->config = new Config();
        $this->url = new URL();
        $this->format = new Format();
        $this->data = $this->format->xss($_REQUEST);
        $this->template = new Template($this->getDirTmpl());
        $this->item = new Item();
        $this->brand = new Brand();
        $this->product = new Product();
        $this->color = new Color();
        $this->size = new Size();
        $this->unit = new Unit();
        $this->discount = new Discount();
        $this->message = new Message();
        $this->order = new Order();
    }

    abstract protected function getContent();

    protected function notFound()
    {
        $this->redirect($this->url->notFound());
    }

    protected function message()
    {
        if (!$_SESSION["message"]) {
            return "";
        }
        $text = $this->message->get($_SESSION["message"]);
        unset($_SESSION["message"]);
        return $text;
    }

    protected function message_color()
    {
        if (!$_SESSION["message_color"]) {
            return "";
        }
        $text = $_SESSION["message_color"];
        unset($_SESSION["message_color"]);
        return $text;
    }

    protected function redirect($link)
    {
        header("Location: $link");
        exit;
    }

    abstract protected function getDirTmpl();

    protected function getCountInArray($v, $array)
    {
        $count = 0;
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $v) {
                $count++;
            }
        }
        return $count;
    }
}
