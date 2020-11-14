<?php
require_once "start.php";
session_start();
require_once "manageadmin_class.php";
require_once "urladmin_class.php";
require_once "auth_class.php";

$manage = new ManageAdmin();
$url = new URLAdmin();
$auth = new Auth();
$func = $_REQUEST["func"];
if ($func == "auth") {
    $link = $manage->auth();
} elseif (!$auth->checkAdmin($_SESSION["login"], $_SESSION["password"])) {
    header("Location: " . $url->auth());
    exit;
} else {
    if ($func == "logout") {
        $manage->logout();
    } elseif ($func == "add_product") {
        $link = $manage->addProduct();
    } elseif ($func == "edit_product") {
        $link = $manage->editProduct();
    } elseif ($func == "delete_product") {
        $manage->deleteProduct();
    } elseif ($func == "add_item") {
        $link = $manage->addItem();
    } elseif ($func == "edit_item") {
        $link = $manage->editItem();
    } elseif ($func == "delete_item") {
        $manage->deleteItem();
    } elseif ($func == "add_brand") {
        $link = $manage->addBrand();
    } elseif ($func == "edit_brand") {
        $link = $manage->editBrand();
    } elseif ($func == "delete_brand") {
        $manage->deleteBrand();
    } elseif ($func == "add_color") {
        $link = $manage->addColor();
    } elseif ($func == "edit_color") {
        $link = $manage->editColor();
    } elseif ($func == "delete_color") {
        $manage->deleteColor();
    } elseif ($func == "add_order") {
        $link = $manage->addOrder();
    } elseif ($func == "edit_order") {
        $link = $manage->editOrder();
    } elseif ($func == "delete_order") {
        $manage->deleteOrder();
    } elseif ($func == "add_discount") {
        $link = $manage->addDiscount();
    } elseif ($func == "edit_discount") {
        $link = $manage->editDiscount();
    } elseif ($func == "delete_discount") {
        $manage->deleteDiscount();
    } else {
        exit;
    }
}
if (!$link) {
    $link = ($_SERVER["HTTP_REFERER"] != "") ? $_SERVER["HTTP_REFERER"] : $url->index();
}
header("Location: $link");
exit;
