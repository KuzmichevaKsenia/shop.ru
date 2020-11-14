<?php
require_once "order_class.php";

class Statistics
{

    private $order;

    public function __construct()
    {
        $this->order = new Order();
    }

    public function getDataForAdmin($start, $end)
    {
        $result = array();
        $orders = $this->order->getAllInInterval($start, $end);
        $result["count_orders"] = count($orders);
        $result["amount_account"] = 0;
        $result["income"] = 0;
        $result["count_goods"] = 0;
        for ($i = 0; $i < count($orders); $i++) {
            $result["amount_account"] += $orders[$i]["price"];
            if ($orders[$i]["date_send"] != 0) {
                $result["income"] += $orders[$i]["price"];
            }
            $units = explode(";", $orders[$i]["units"]);
            $result["count_goods"] += count($units);
        }
        return $result;
    }
}
