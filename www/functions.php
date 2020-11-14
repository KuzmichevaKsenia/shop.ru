<?php
require_once "start.php";

require_once "manage_class.php";
require_once "url_class.php";

$manage = new Manage();
$url = new URL();
$func = $_REQUEST["func"];
if ($func == "add_cart") {
    $manage->addCart();
} elseif ($func == "delete_cart") {
    $manage->deleteCart();
} elseif ($func == "remove_cart") {
    $manage->removeCart();
} elseif ($func == "order") {
    $success = $manage->addOrder();
} else {
    exit;
}
if ($success) {
    $link = $url->message();
} else {
    $link = ($_SERVER["HTTP_REFERER"] != "") ? $_SERVER["HTTP_REFERER"] : $url->index();
}
header("Location: $link");
exit;
