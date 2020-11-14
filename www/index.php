<?php
require_once "start.php";

require_once "url_class.php";

$url = new URL();
$view = $url->getView(); //определяет название класса из адреса

$class = mb_strtolower($view . "Content");
if ($url->fileExists($class . "_class.php")) {
    require_once $class . "_class.php";
    new $class();
} else {
    header("Location: " . $url->notFound());
    exit;
}
