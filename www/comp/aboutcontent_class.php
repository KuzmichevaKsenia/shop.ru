<?php
require_once "modules_class.php";

class AboutContent extends Modules
{

    protected $title = "О магазине дизайнерской женской одежды европейских брендов Shop";
    protected $meta_desc = "Информация о магазине Shop в городе Москва по адресу: улица Московская, дом 1. Отзывы о магазине женской одежды Shop в Москве.";
    protected $meta_key = "магазины shop в москве, магазин в москве, магазины женской одежды в москве, женская одежда интернет магазин москва, магазины женской одежды бутики, одежда официальный сайт, одежда в москве каталог";

    public function getContent()
    {
        return "about";
    }

}
