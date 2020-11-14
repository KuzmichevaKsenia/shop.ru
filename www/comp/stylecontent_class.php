<?php
require_once "modules_class.php";

class StyleContent extends Modules
{

    protected $title = "Услуги стилиста по подбору одежды в Москве от магазина Shop";
    protected $meta_desc = "Персональный стилист от магазина дизайнерской женской одежды европейских брендов Shop в Москве. Имиджмейкер. Шоппинг сопровождение. Консультация по стилю. Выезд на дом. Разбор гардероба.";
    protected $meta_key = "стиль Shop, личный стилист, стилист образ, стилист сайт, стилист имиджмейкер, персональный стилист, услуги стилиста, разбор гардероба, стилист москва, имиджмейкер москва, одежда Москва";

    public function getContent()
    {
        return "style";
    }

}